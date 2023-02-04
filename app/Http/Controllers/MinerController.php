<?php

namespace App\Http\Controllers;

use App\Computer;
use App\Mine;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

class MinerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function miner($name)
    {
        if(!Session::get('computer_id')) return redirect()->route('computer_select');

        $computer = Computer::find(Session::get('computer_id'));
        $mine = Mine::whereRaw('LOWER(`name`) = ?', [$name])->first();

        if(!$computer->isComplete()) {
            session()->now('alert-class', 'alert-danger');
            session()->now('message', 'Cannot use miner. Your computer is missing key parts');
        }

        return view('programs.miner')->with(['computer' => $computer, 'mine' => $mine]);
    }

    public function byteminer_start()
    {
        if(!Session::get('computer_id')) return redirect('computer_select');

        $computer = Computer::find(Session::get('computer_id'));
        $user = User::find(Auth::user()->id);
        if($computer->mine_start_time === null) {
            $computer->mine_start_time = Carbon::now()->getTimestamp();
            session()->now('alert-class', 'alert-info');
            session()->now('message', 'Miner started');
        } else {
            $user->bytecoin += $computer->current_mined_coins();
            $computer->mine_start_time = null;
            session()->now('alert-class', 'alert-info');
            session()->now('message', 'Miner stopped');
        }

        $user->save();
        $computer->save();

        return redirect('/programs/byteminer');
    }

    public function byteminer_collect()
    {
        if(!Session::get('computer_id')) return redirect('computer_select');

        $computer = Computer::find(Session::get('computer_id'));
        $user = User::find(Auth::user()->id);
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
        if(!Session::get('computer_id')) return redirect('computer_select');

        $user = User::find(Auth::user()->id);
        $money = round(($user->bytecoin * 38100) / 1e5, 0, PHP_ROUND_HALF_DOWN);

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
