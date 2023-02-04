<?php

namespace App\Http\Controllers;

use App\Computer;
use App\Item;
use App\Mine;
use App\Shop;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class APIController extends Controller
{
    public function login_as(Request $request)
    {
        if(!$request->has('computer_id')) return json_encode(['error' => true, 'message' => 'Invalid computer']);

        Session::put('computer_id', $request->get('computer_id'));
        return json_encode(['error' => false]);
    }

    public function move_item(Request $request)
    {
        $response_json = ['error' => false];

        $fromSlot = $request->get('fromSlot');
        $toSlot = $request->get('toSlot');
        $fromComputer = $request->get('fromComputer');
        $toComputer = $request->get('toComputer');

        $computer = Computer::find(Session::get('computer_id'));

        if($fromComputer && !$toComputer) {
            // Computer -> Inventory
            $itemFrom = Item::where('computer_id', $computer->id)->where('in_computer', true)->where('slot', $fromSlot)->first();
            $itemTo = Item::where('computer_id', $computer->id)->where('in_computer', false)->where('slot', $toSlot)->first();

            if($itemFrom == null) return json_encode(['error' => true]);
            if ($computer->mine_id != null) return json_encode(['error' => true]);

            if($itemTo != null) {
                if($computer->canPlaceItem($itemTo->id, $fromSlot)) {
                    $itemTo->in_computer = true;
                    $itemTo->slot = $fromSlot;
                    $itemTo->save();
                } else {
                    return json_encode(['error' => true, 'message' => 'Item cannot be placed into slot']);
                }
            }

            $itemFrom->in_computer = false;
            $itemFrom->slot = $toSlot;

            $itemFrom->save();

            $response_json['computer'] = ['storage_size' => $computer->storage_size(true), 'storage_speed' => $computer->storage_speed(true), 'gpu_speed' => $computer->gpu_speed(true)];
        } else if($toComputer && !$fromComputer){
            // Inventory -> Computer
            $itemFrom = Item::where('computer_id', $computer->id)->where('in_computer', false)->where('slot', $fromSlot)->first();
            $itemTo = Item::where('computer_id', $computer->id)->where('in_computer', true)->where('slot', $toSlot)->first();

            if ($computer->mine_id != null) return json_encode(['error' => true]);

            if(!$computer->canPlaceItem($itemFrom->id, $toSlot)) {
                return json_encode(['error' => true, 'message' => 'Item cannot be placed into this slot']);
            }

            if ($itemTo != null) {
                $itemTo->in_computer = true;
                $itemTo->slot = $fromSlot;
                $itemTo->save();
            }

            $itemFrom->in_computer = true;
            $itemFrom->slot = $toSlot;

            $itemFrom->save();

            $response_json['computer'] = ['storage_size' => $computer->storage_size(true), 'storage_speed' => $computer->storage_speed(true), 'gpu_speed' => $computer->gpu_speed(true)];
        } else if($toComputer && $fromComputer) {
            // Computer -> Computer
            $itemFrom = Item::where('computer_id', $computer->id)->where('in_computer', true)->where('slot', $fromSlot)->first();
            $itemTo = Item::where('computer_id', $computer->id)->where('in_computer', true)->where('slot', $toSlot)->first();

            if ($computer->mine_id != null) return json_encode(['error' => true]);
            if (!$computer->canPlaceItem($itemFrom->id, $toSlot)) {
                return json_encode(['error' => true, 'message' => 'Item cannot be placed into this slot']);
            }

            if ($itemTo != null) {
                if($computer->canPlaceItem($itemTo->id, $fromSlot)) {
                    $itemTo->in_computer = true;
                    $itemTo->slot = $fromSlot;
                    $itemTo->save();
                } else {
                    return json_encode(['error' => true, 'message' => 'Item cannot be placed into this slot']);
                }
            }

            $itemFrom->in_computer = true;
            $itemFrom->slot = $toSlot;

            $itemFrom->save();

            $response_json['computer'] = ['storage_size' => $computer->storage_size(true), 'storage_speed' => $computer->storage_speed(true), 'gpu_speed' => $computer->gpu_speed(true)];
        } else {
            // Inventory -> Inventory
            $itemFrom = Item::where('computer_id', $computer->id)->where('in_computer', false)->where('slot', $fromSlot)->first();
            $itemTo = Item::where('computer_id', $computer->id)->where('in_computer', false)->where('slot', $toSlot)->first();

            $itemFrom->in_computer = false;
            $itemFrom->slot = $toSlot;

            if($itemTo != null) {
                $itemTo->in_computer = false;
                $itemTo->slot = $fromSlot;
                $itemTo->save();
            }

            $itemFrom->save();
        }


        return json_encode($response_json);
    }

    public function toggle_miner(Request $request)
    {
        if (!Session::get('computer_id')) return json_encode(['error' => true, 'message' => 'Invalid computer']);
        if (!$request->has('mine_id')) return json_encode(['error' => true, 'message' => 'Invalid mine']);

        $computer = Computer::find(Session::get('computer_id'));
        $mine = Mine::find($request->get('mine_id'));
        $current_time = Carbon::now();

        if($computer->mine_start_time == null) {
            $computer->mine_start_time = $current_time->format('Y-m-d H:i:s');
            $computer->mine_id = $mine->id;
        } else {
            $balance = (rand(80, 120) / 100) * $computer->current_mined_blocks($mine->id) / 1480;
            $computer->wallet->addBalance($mine->currency_id, $balance);
            $computer->wallet->save();
            $computer->mine_start_time = null;
            $computer->mine_id = null;
        }

        $computer->save();

        return json_encode(['error' => false, 'started' => $computer->mine_start_time != null]);
    }

    public function miner_sell(Request $request) {
        if (!Session::get('computer_id')) return json_encode(['error' => true, 'message' => 'Invalid computer']);
        if (!$request->has('mine_id')) return json_encode(['error' => true, 'message' => 'Invalid mine']);

        $computer = Computer::find(Session::get('computer_id'));
        $mine = Mine::find($request->get('mine_id'));
        $user = User::find(Auth::id());
        $coins = $computer->wallet->getBalance($mine->currency_id);

        if($coins * $mine->exchange_rate < 5) return json_encode(['error' => true, 'message' => 'Not enough ' . $mine->name]);

        $dollars = $coins * $mine->exchange_rate * 100;

        $computer->wallet->takeBalance($mine->currency_id, $coins);
        $computer->wallet->save();

        $user->money += $dollars;
        $user->save();

        return json_encode(['error' => false, 'coins' => $computer->wallet->getBalance($mine->currency_id)]);
    }

    public function reset_date(Request $request) {
        if(!$request->has('shop'))  {
            $shop = Shop::all()->first();
        } else {
            $shop = Shop::find($request->get('shop'));
        }

        if($shop == null) return json_encode(['error' => false, 'date' => null]);

        return json_encode(['error' => false, 'date' => $shop->reset_date]);
    }
}
