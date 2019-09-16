<?php

namespace App\Http\Controllers;

use App\Computer;
use App\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ComputerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $computers = Auth::user()->computers;

        return view('computer.select')->with(['computers' => $computers]);
    }

    public function assembler($id)
    {
        $items = Item::where('user_id', Auth::id())->get();
        $computer = Computer::find($id);

        return view('computer.assembler')->with(['items' => $items, 'computer' => $computer]);
    }

    public function add_part($id, $item_id)
    {
        $computer = Computer::find($id);
        $item = Item::find($item_id);

        $data = array_merge(json_decode($computer->data, true), [
            str_replace(' ', '_', strtolower($item->hardware->hardware_type->type)) => $item_id
        ]);

        $computer->data = json_encode($data);
        $computer->save();

        return $this->assembler($id);
    }
}
