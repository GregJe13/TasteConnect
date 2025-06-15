<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Customer;
use App\Models\OrderDetail;
use App\Models\OrderDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

        $cartItems = Cart::where('customer_id', session('id'))->with('menu')->get();
        if ($cartItems->isEmpty()) {
            return response()->json(['message' => 'Cart is empty!', 'success' => false]);
        }

        // --- AWAL TRANSAKSI DATABASE ---
        try {
            DB::beginTransaction();

            // 1. Validasi stok sebelum proses
            foreach ($cartItems as $item) {
                if ($item->quantity > $item->menu->stock) {
                    // Batalkan transaksi jika ada stok yang tidak cukup
                    DB::rollBack();
                    return response()->json(['message' => 'Sorry, ' . $item->menu->name . ' is out of stock.', 'success' => false]);
                }
            }

            $totalAmount = $cartItems->sum('price');
            // ... (logika diskon promo jika ada)

            // 2. Buat pesanan
            $order = Order::create([
                'customer_id' => session('id'),
                'orderDate' => now(),
                'totalAmount' => $totalAmount,
                'status' => 0,
                'address' => $request->address,
            ]);

            // 3. Buat detail pesanan DAN kurangi stok
            foreach ($cartItems as $item) {
                OrderDetail::create([
                    'order_id' => $order->id,
                    'menu_id' => $item->menu_id,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                ]);

                // Kurangi stok menu
                $menu = $item->menu;
                $menu->stock -= $item->quantity;
                $menu->save();

                // Hapus item dari keranjang
                $item->delete();
            }

            // 4. Buat data pembayaran
            Payment::create([
                'order_id' => $order->id,
                'amount' => $totalAmount,
                'method' => $request->method,
                'date' => now(),
            ]);

            // 5. Tambah poin loyalitas
            $customer = Customer::find(session('id'));
            $loyaltyPoint = $customer->loyaltyPoint + ($totalAmount / 1000);
            $customer->update(['loyaltyPoint' => $loyaltyPoint]);

            // Jika semua berhasil, konfirmasi transaksi
            DB::commit();

            return response()->json(['message' => 'Order successfully created!', 'success' => true]);
        } catch (\Exception $e) {
            // Jika terjadi error, batalkan semua perubahan
            DB::rollBack();
            return response()->json(['message' => 'An error occurred. Please try again. Error: ' . $e->getMessage(), 'success' => false], 500);
        }
        // --- AKHIR TRANSAKSI DATABASE ---
    }
}
