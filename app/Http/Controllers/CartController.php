<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{

    public function index()
    {
        $carts = Cart::where('customer_id', session('id'))->with(['menu', 'customer'])->get();
        return response()->json(['data' => $carts, 'success' => true]);
    }
    public function addToCart(Request $request)
    {
        $data = $request->all();

        $valid = Validator::make($data, [
            'menu_id' => 'required',
            'quantity' => 'required',
        ], [
            'menu_id.required' => 'Your cart is empty!',
            'quantity.required' => 'Menu quantity is required!',
        ]);

        if ($valid->fails()) {
            return response()->json(['message' => $valid->errors()->first(), 'success' => false]);
        }

        $menuPrice = Menu::where('id', $request->menu_id)->first()->price;

        $price = $menuPrice * $request->quantity;

        $data['price'] = $price;
        $data['customer_id'] = session('id');

        $cart = Cart::where('menu_id', $data['menu_id'])->where('customer_id', $data['customer_id'])->first();
        $currentQty = $cart->quantity ?? 0;
        $currentPrice = $cart->price ?? 0;
        Cart::updateOrCreate(
            [
                'menu_id' => $data['menu_id'],
                'customer_id' => $data['customer_id'],
            ],
            [
                'quantity' => $currentQty +  $data['quantity'],
                'price' => $currentPrice + $data['price'],
            ]
        );
        return response()->json(['message' => 'Menu added to cart!', 'success' => true]);
    }

    public function destroy(Cart $cart)
    {
        $cart->delete();
        return response()->json(['message' => 'Menu removed from cart!', 'success' => true]);
    }

    public function update(Request $request, Cart $cart)
    {
        if ($cart == null) {
            return response()->json(['message' => 'Cart not found!', 'success' => false]);
        }

        if ($request->deduct) {
            $cart->update(['quantity' => $cart->quantity - 1, 'price' => $cart->menu->price * ($cart->quantity - 1)]);
            return response()->json(['message' => 'Cart updated!', 'success' => true]);
        } else {
            $cart->update(['quantity' => $cart->quantity + 1, 'price' => $cart->menu->price * ($cart->quantity + 1)]);
            return response()->json(['message' => 'Cart updated!', 'success' => true]);
        }
    }
}
