<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderController extends Controller
{
    public function index()
    {
        $props['title'] = 'Order';
        $props['orders'] = Order::with('customer')->get();
        return view('admin.orders', $props);
    }

    public function show($id)
    {
        $props['title'] = 'Order';
        $props['order'] = Order::where('id', $id)->with('customer')->first();
        $props['details'] = OrderDetail::where('order_id', $id)->with(['order', 'menu'])->get();
        return view('admin.order-details', $props);
    }

    public function updateStatus(Request $request, Order $order)
    {
        $order->update(['status' => $request->status]);

        return response()->json(['message' => 'Order status updated!', 'success' => true]);
    }

    public function exportPDF()
    {
        $orders = Order::all();
        $pdf = Pdf::loadView('admin.orders_pdf', compact('orders'));
        return $pdf->download('orders.pdf');
    }
}
