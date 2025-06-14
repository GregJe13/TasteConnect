<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Customer;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        $props['title'] = 'Admin Dashboard';
        return view('admin.user-profile', $props);
    }
    public function login()
    {
        $props['title'] = 'Admin Login';
        return view('admin.login', $props);
    }
    public function auth(Request $request)
    {
        $admin = Admin::where('email', $request->email)->first();

        if (($admin && Hash::check($request->password, $admin->password))) {
            session()->put('id', $admin->id);
            session()->put('email', $admin->email);
            session()->put('name', $admin->name);
            session()->put('role', $admin->role);

            return redirect()->route('admin.index')->with('success', 'Login berhasil!');
        } else {
            return redirect()->route('admin.login')->with('error', 'Email atau password salah!');
        }
    }

    public function getCustomerProfile()
    {
        $props['title'] = 'Manage Users Profile';
        $props['users'] = Customer::all();
        return view('admin.user-profile', $props);
    }

    public function editCustomerProfile(Customer $customer)
    {
        $props['title'] = 'Manage Users Profile';
        $props['customer'] = $customer;
        return view('admin.user-details', $props);
    }

    public function updateCustomerProfile(Request $request, Customer $customer)
    {
        $customer->name = $request->name;
        $customer->email = $request->email;
        $customer->phoneNum = $request->phoneNum;
        $customer->address = $request->address;
        $customer->loyaltyPoint = $request->loyaltyPoint;
        $customer->save();

        return response()->json(['message' => 'Data successfully updated!', 'success' => true]);
    }

    public function deleteCustomerProfile(Customer $customer)
    {
        $customer->delete();
        return response()->json(['message' => 'Data successfully deleted!', 'success' => true]);
    }

    public function reservation()
    {
        $props['title'] = 'Manage Reservations';
        $props['reservations'] = Reservation::with('customer')->get();
        return view('admin.reservation', $props);
    }

    public function processReservation(Reservation $reservation, Request $request)
    {
        $reservation->status = $request->status;
        $reservation->save();

        return response()->json(['message' => 'Reservation successfully processed!', 'success' => true]);
    }
}
