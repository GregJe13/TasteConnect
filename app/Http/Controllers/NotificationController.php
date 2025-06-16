<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Notification;
use App\Models\Promotion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NotificationController extends Controller
{
    public function get()
    {
        $notifications = Notification::where('customer_id', session('id'))->get();
        return response()->json(['data' => $notifications, 'success' => true]);
    }

    public function index()
    {
        $props['promotions'] = Promotion::all();
        $props['notifications'] = Notification::where('customer_id', session('id'))->get();
        $props['customers'] = Customer::all();
        $props['title'] = 'Send Personalized';
        return view('admin.notification', $props);
    }

    public function sendNotification(Request $request)
    {
        $valid = Validator::make($request->all(), [
            'customers' => 'required',
            'promotion_id' => 'required'
        ]);

        if ($valid->fails()) {
            return response()->json(['message' => 'Invalid data', 'success' => false]);
        }
        foreach ($request->customers as $customer) {
            Notification::create([
                'customer_id' => $customer,
                'title' => Promotion::find($request->promotion_id)->title
            ]);
        }
        return response()->json(['message' => 'Notification successfully sent to customers', 'success' => true]);
    }

    public function destroy(Notification $notification)
    {
        if ($notification->customer_id !== session('id')) {
            return response()->json(['success' => false, 'message' => 'Akses ditolak.'], 403);
        }

        $notification->delete();

        return response()->json(['success' => true, 'message' => 'Notifikasi berhasil dihapus.']);
    }
}
