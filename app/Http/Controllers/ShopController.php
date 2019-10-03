<?php

namespace App\Http\Controllers;

use App\Computer;
use App\ComputerHardware;
use App\Item;
use App\Player;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShopController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $products = ComputerHardware::where('listed', true)->get();

        return view('shop.view')->with(['products' => $products]);
    }

    public function purchase($id)
    {
        $product = ComputerHardware::find($id);
        $user = Player::where('player_id', Auth::id())->first();

        if(!$product->listed) return redirect('/shop');

        if($user->money >= $product->price) {
            $user->money = $user->money - $product->price;
            $user->save();

            if($product->hardware_type->type == 'Case') {
                $computer = new Computer();
                $computer->user_id = $user->id;
                $computer->name = 'Computer';
                $computer->brand = 1;
                $computer->data = json_encode(['case' => $product->id]);
                $computer->state = 0;
                $computer->save();
            } else {
                $item = new Item();
                $item->user_id = $user->id;
                $item->computer_hardware_id = $id;
                $item->save();
            }
        }

        return redirect('/shop');
    }
}
