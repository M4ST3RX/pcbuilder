<?php

namespace App\Http\Controllers;

use App\Computer;
use App\Settins;
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
        if($computer->mine_start_time === null) {
            $computer->mine_start_time = Carbon::now()->getTimestamp();
        } else {
            $computer->byte_coins += $computer->current_mined_coins();
            $computer->mine_start_time = null;
        }

        $computer->save();

        return redirect('/programs/byteminer');
    }

    public function byteminer_collect()
    {
        if(!Session::get('computer_id')) return redirect('/computers');

        $computer = Computer::find(Session::get('computer_id'));
        if($computer->mine_start_time) {
            $computer->byte_coins += $computer->current_mined_coins();
            $computer->mine_start_time = Carbon::now()->getTimestamp();
            $computer->save();
        }

        return redirect('/programs/byteminer');
    }

    public function sell()
    {
        if(!Session::get('computer_id')) return redirect('/computers');

        $computer = Computer::find(Session::get('computer_id'));
        $user = User::find(Auth::id());
        $money = $computer->byte_coins * 381;

        $user->money += $money;
        $computer->byte_coins = 0;

        $user->save();
        $computer->save();

        return redirect('/programs/byteminer');
    }
}
