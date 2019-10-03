<?php

namespace App\Http\Controllers;

use App\Computer;
use App\HardwareType;
use App\Item;
use App\Player;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ComputerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return redirect('/computers');
    }

    public function selector()
    {
        $computers = Auth::user()->player->computers;
        Session::forget('computer_id');

        return view('computer.select')->with(['computers' => $computers]);
    }

    public function play($id)
    {
        $computer = Computer::find($id);
        if($computer->state === 0){
            Session::flash('message', 'The computer is not turned on.');
            Session::flash('alert-class', 'alert-danger');
            return redirect('/computers');
        }

        Session::put('computer_id', $id);

        return view('computer.play')->with(['computer' => $computer]);
    }

    public function assembler($id)
    {
        $computer = Computer::find($id);
        if($computer->user_id !== Auth::user()->player->id) return redirect()->back();

        $items = Item::where('user_id', Auth::user()->player->id)->where('computer_id', null)->orWhere('computer_id', $computer->id)->get();

        return view('computer.assembler')->with(['items' => $items, 'computer' => $computer]);
    }

    public function add_part($id, $item_id)
    {
        $computer = Computer::find($id);
        if($computer->state === 1) {
            Session::flash('message', 'Turn off the computer!');
            Session::flash('alert-class', 'alert-danger');
            return redirect('computer/assembler/' . $id);
        }

        $itemClass = Item::find($item_id);
        $data = json_decode($itemClass->hardware->data, true);
        $hasItem = false;

        if(isset($data['depends']) && !empty($data['depends'])) {
            foreach ($computer->items as $item){
                if(in_array($item->hardware->hardware_type->id, $data['depends'])) {
                    $hasItem = true;
                    break;
                }
            }
        }

        if($hasItem || empty($data['depends'])){
            $itemClass->computer_id = $computer->id;
            $itemClass->save();
        } else {
            $needed = HardwareType::find($data['depends'][0])->type;
            Session::flash('message', 'The computer needs a '.$needed.' first!');
            Session::flash('alert-class', 'alert-danger');
        }

        return redirect('computer/assembler/' . $id);
    }

    public function remove_part($id, $item_id)
    {
        $computer = Computer::find($id);
        if($computer->state === 1) {
            Session::flash('message', 'Turn off the computer!');
            Session::flash('alert-class', 'alert-danger');
            return redirect('computer/assembler/' . $id);
        }

        $item = Item::find($item_id);

        $item->computer_id = null;
        $item->save();

        return redirect('computer/assembler/' . $id);
    }

    public function set_state($computer_id)
    {
        $computer = Computer::find($computer_id);
        if($computer->fully_functional()){
            $computer->mine_start_time = null;
            $computer->state = !$computer->state;
            $computer->save();
        } else {
            Session::flash('message', 'You are missing some parts from this computer!');
            Session::flash('alert-class', 'alert-danger');
        }

        return redirect('/computers/');
    }
}
