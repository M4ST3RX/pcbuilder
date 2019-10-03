<?php

namespace App\Http\Controllers;

use App\Computer;
use App\Player;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ByteMinerController extends Controller
{
    public function byteminer()
    {
        if(!Session::get('computer_id')) return redirect('/computers');

        $computer = Computer::find(Session::get('computer_id'));

        return view('programs.byteminer')->with(['computer' => $computer]);
    }

    public function byteminer_start()
    {
        if(!Session::get('computer_id')) return redirect('/computers');

        $computer = Computer::find(Session::get('computer_id'));
        $user = Player::where('player_id', Auth::id())->first();
        if($computer->mine_start_time === null) {
            $computer->mine_start_time = Carbon::now()->getTimestamp();
        } else {
            $user->bytecoin += $computer->current_mined_coins();
            $computer->mine_start_time = null;
        }

        $user->save();
        $computer->save();

        return redirect('/programs/byteminer');
    }

    public function byteminer_collect()
    {
        if(!Session::get('computer_id')) return redirect('/computers');

        $computer = Computer::find(Session::get('computer_id'));
        $user = Player::where('player_id', Auth::id())->first();
        if($computer->mine_start_time) {
            $user->bytecoin += $computer->current_mined_coins();
            $computer->mine_start_time = Carbon::now()->getTimestamp();
            $computer->save();
            $user->save();
        }

        return redirect('/programs/byteminer');
    }

    public function sell()
    {
        if(!Session::get('computer_id')) return redirect('/computers');

        $user = Player::where('player_id', Auth::id())->first();
        $money = round(($user->bytecoin * 38100) / 100000, 0, PHP_ROUND_HALF_DOWN);

        if($money < 100) {
            Session::flash('message', 'A minimum of $1 is needed to sell your ByteCoins.');
            Session::flash('alert-class', 'alert-danger');
            return redirect('/programs/byteminer');
        }
        $user->money += $money;
        $user->bytecoin = 0;
        $user->save();

        return redirect('/programs/byteminer');
    }
}
