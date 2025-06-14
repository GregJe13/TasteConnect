<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderDetails;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    public function index()
    {
        $props['title'] = 'Payment';
        return view('user.payment', $props);
    }

    public function makePayment(Request $request)
    {

        $valid = Validator::make($request->all(), [
            'method' => 'required',
            'address' => 'required',
        ]);

        if ($valid->fails()) {
            return response()->json(['message' => $valid->errors()->first(), 'success' => false]);
        }

        $cartItems = Cart::where('customer_id', session('id'))->get();
        if ($cartItems->count() == 0) {
            return response()->json(['message' => 'Cart is empty!', 'success' => false]);
        }

        $totalAmount = $cartItems->sum('price');

        $order = Order::create([
            'customer_id' => session('id'),
            'orderDate' => now(),
            'totalAmount' => $totalAmount,
            'status' => 0,
            'address' => $request->address,
        ]);
       

            foreach ($cartItems as $item) {
            OrderDetail::create([
                'order_id' => $order->id,
                'menu_id' => $item->menu_id,
                'quantity' => $item->quantity,
                'price' => $item->price,
            ]);
            $item->delete();
        }

        $payment = Payment::create([
            'order_id' => $order->id,
            'amount' => $totalAmount,
            'method' => $request->method,
            'date' => now(),
        ]);

        $customer = Customer::find(session('id'));
        $loyaltyPoint = $customer->loyaltyPoint + ($totalAmount / 1000);
        Customer::find(session('id'))->update(['loyaltyPoint' => $loyaltyPoint]);


        return response()->json(['message' => 'Order successfully created!', 'success' => true]);
    }
}
