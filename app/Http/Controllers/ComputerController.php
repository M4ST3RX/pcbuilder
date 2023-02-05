<?php

namespace App\Http\Controllers;

use App\Computer;
use App\CryptoWallet;
use App\Currency;
use App\HardwareType;
use App\Item;
use App\Managers\InventoryManager;
use App\User;
use App\Util;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ComputerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function selector()
    {
        $user = User::where('id', Auth::id())->first();

        $computers = $user->computers;
        Session::forget('computer_id');

        return view('computer.select')->with(['computers' => $computers]);
    }

    public function play()
    {
        $id = Session::get('computer_id');
        if(!$id) return redirect('/');

        $computer = Computer::find($id);
        $items = Item::where('computer_id', $id)->get();
        $inventoryManager = new InventoryManager($items);

        return view('computer.play')->with(['computer' => $computer, 'inventoryManager' => $inventoryManager]);
    }

    public function showCreateComputer()
    {
        return view('computer.create');
    }

    public function showOverclock() {
        $id = Session::get('computer_id');
        if (!$id) return redirect('/');

        $items = Item::where('computer_id', $id)->get();
        $inventoryManager = new InventoryManager($items);
        return view('computer.overclock')->with(['inventoryManager' => $inventoryManager]);
    }

    public function createComputer(Request $request)
    {
        $name = $request->get('computer-name');

        if(!$request->has('computer-name')) {
            Session::flash('message', 'Please enter a name!');
            Session::flash('alert-class', 'alert-danger');
            return redirect('/create');
        }

        $computer_exists = Computer::where('name', '=', $name)->first() !== null;

        if($computer_exists) {
            Session::flash('message', 'You already have a computer with this name!');
            Session::flash('alert-class', 'alert-danger');
            return redirect('/create');
        }

        $currencies = Currency::where('is_crypto', true)->get();
        $currency_array = [];
        foreach($currencies as $currency) {
            $currency_array[$currency->id] = 0;
        }

        $CryptoWallet = new CryptoWallet();
        $CryptoWallet->wallet_hash = Util::createCryptoWalletHash(Computer::max('id'));
        $CryptoWallet->currencies = json_encode($currency_array);
        $CryptoWallet->save();

        $Computer = new Computer();
        $Computer->user_id = Auth::user()->id;
        $Computer->crypto_wallet_id = $CryptoWallet->id;
        $Computer->name = $name;
        $Computer->save();
        return redirect('/');
    }
}
