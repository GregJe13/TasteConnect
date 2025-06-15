<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Symfony\Component\HttpFoundation\StreamedResponse;

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

    public function exportExcel()
    {
        $fileName = 'orders_export_' . date('Y-m-d') . '.csv';
        $orders = Order::with('customer')->get();

        $headers = [
            "Content-type"        => "text/csv; charset=utf-8",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['Order ID', 'Customer Name', 'Customer Email', 'Order Date', 'Total Amount', 'Status', 'Address'];

        $callback = function () use ($orders, $columns) {
            // Membuka output stream untuk menulis file
            $file = fopen('php://output', 'w');

            // Menambahkan UTF-8 BOM agar karakter non-Inggris tampil benar di Excel
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            // Menulis baris header dengan pemisah titik koma
            fputcsv($file, $columns, ';');

            $statusMap = [
                0 => 'Processing',
                1 => 'Delivery',
                2 => 'Completed',
                3 => 'Cancelled',
                4 => 'Feedback'
            ];

            // Menulis setiap baris data pesanan
            foreach ($orders as $order) {
                $row = [
                    $order->id,
                    $order->customer->name,
                    $order->customer->email,
                    $order->orderDate,
                    // Format angka agar sesuai dengan standar lokal tanpa simbol mata uang
                    number_format($order->totalAmount, 2, ',', ''),
                    $statusMap[$order->status] ?? 'Unknown',
                    // Menghapus newline dari alamat agar tidak merusak baris CSV
                    str_replace(["\r", "\n"], ' ', $order->address)
                ];

                // Menulis baris data dengan pemisah titik koma
                fputcsv($file, $row, ';');
            }

            fclose($file);
        };

        return new StreamedResponse($callback, 200, $headers);
    }

    public function exportPDF()
    {
        $orders = Order::all();
        $pdf = Pdf::loadView('admin.orders_pdf', compact('orders'));
        return $pdf->download('orders.pdf');
    }
}
