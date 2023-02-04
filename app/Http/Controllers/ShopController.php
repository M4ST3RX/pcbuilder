<?php

namespace App\Http\Controllers;

use App\Computer;
use App\ComputerBrand;
use App\ComputerHardware;
use App\HardwareType;
use App\Item;
use App\ItemGenerator;
use App\Managers\InventoryManager;
use App\Shop;
use App\ShopItem;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ShopController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if(!Session::has('computer_id')) return redirect('computer_select');

        $shops = Shop::where('enabled', true)->get();
        $balance = 0;

        return view('shop.view')->with(['shops' => $shops, 'balance' => $balance]);
    }

    public function purchase(Request $request)
    {
        $shop_item = ShopItem::find($request->item);
        $computer = Computer::find(Session::get('computer_id'));
        $user = User::find(Auth::id());
        $inventoryManager = new InventoryManager();
        $itemPrefab = $shop_item->item_prefab;

        $price = $shop_item->price;
        $balance = $shop_item->shop->currency_id == 1 ? $user->money : $computer->wallet->getBalance($shop_item->shop->currency_id);

        if(!$inventoryManager->hasSpace()) {
            return json_encode(['error' => true, 'message' => 'You don\'t have enough space in your inventory.', 'title' => 'Shop']);
        }

        if($balance >= $price) {
            if($shop_item->discount > 0) {
                $price = round($shop_item->price * ((100 - $shop_item->discount) / 100), 2);
            }

            if($shop_item->shop->currency_id == 1) {
                $user->money -= $price * 100;
                $user->save();
            } else {
                $computer->wallet->takeBalance($price);
                $computer->wallet->save();
            }

            $ItemGenerator = new ItemGenerator();
            $ItemGenerator->createItem($itemPrefab->tier, $itemPrefab->rarity, $itemPrefab->type);
        } else {
            return json_encode(['error' => true, 'message' => 'You don\'t have enough money.', 'title' => 'Shop']);
        }

        return json_encode(['error' => false, 'message' => 'You have purchased the item <span class="item-name">' . $shop_item->item_prefab->name . '</span>', 'title' => 'Shop']);
    }
}
