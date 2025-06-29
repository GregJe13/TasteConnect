<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Cart;
use App\Models\Customer;
use App\Models\CustomerLoyalty;
use App\Models\LoyaltyProgram;
use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Request as FacadesRequest;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $props['title'] = 'Homepage';
        $props['menus'] = Menu::all();
        $props['carts'] = Cart::where('customer_id', session('id'))->with(['menu', 'customer'])->get();
        return view('user.index', $props);
    }

    public function login(Request $request)
    {
        $props['title'] = 'Login';

        return view('user.login', $props);
    }

    public function register(Request $request)
    {
        $props['title'] = 'Register';

        return view('user.register', $props);
    }

    public function regist(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255',
            'address' => 'required|string',
            'number' => 'required|string',
            'email' => 'required|string|email|max:255|unique:customers',
            'password' => 'required|string|min:6|confirmed', // 'confirmed' akan otomatis mencocokkan dengan 'password_confirmation'
        ]);

        if ($validator->fails()) {
            return redirect()->route('register')
                ->withErrors($validator)
                ->withInput();
        }

        $cust = new Customer;
        $cust->name = $request->username;
        $cust->email = $request->email;
        $cust->address = $request->address;
        $cust->phoneNum = $request->number;
        $cust->password = Hash::make($request->password);

        $cust->save();
        return redirect()->route('login')->with('success', 'Successfully regist your account!');
    }

    public function auth(Request $request)
    {
        $customer = Customer::where('email', $request->email)->first();

        if (($customer && Hash::check($request->password, $customer->password))) {
            session()->put('id', $customer->id);
            session()->put('email', $customer->email);
            session()->put('name', $customer->name);

            if ($request->has('menu_id') && $request->has('quantity')) {
                $menuId = $request->input('menu_id');
                $quantity = $request->input('quantity');
                $menu = Menu::find($menuId);

                if ($menu && $quantity > 0) {
                    $price = $menu->price * $quantity;

                    $cartItem = Cart::where('customer_id', $customer->id)
                        ->where('menu_id', $menuId)
                        ->first();

                    $currentQty = $cartItem->quantity ?? 0;
                    $currentPrice = $cartItem->price ?? 0;

                    Cart::updateOrCreate(
                        [
                            'menu_id' => $menuId,
                            'customer_id' => $customer->id,
                        ],
                        [
                            'quantity' => $currentQty + $quantity,
                            'price' => $currentPrice + $price,
                        ]
                    );

                    return redirect()->route('index')->with('success', 'Login berhasil & item telah ditambahkan ke keranjang!');
                }
            }
            return redirect()->route('index')->with('success', 'Successfully logged in!');
        } else {
            return redirect()->route('login')->with('error', 'Invalid credentials, please check your email or password!');
        }
    }
    public function profile(Request $request)
    {
        $props['title'] = 'Profile';
        $props['customer'] = Customer::find(session('id'));

        return view('user.profile', $props);
    }
    public function updateProfile(Request $request)
    {
        $customer = Customer::find(session('id'));
        $customer->name = $request->name;
        $customer->email = $request->email;
        $customer->phoneNum = $request->phoneNum;
        $customer->address = $request->address;
        $customer->save();

        return response()->json(['message' => 'Data successfully updated!', 'success' => true]);
    }
    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect()->route('index')->with('success', 'Successfully logged out!');
    }

    public function loyalty(Request $request)
    {
        $props['title'] = 'View and Redeem Points';
        $props['customerLoyalties'] = CustomerLoyalty::selectRaw('count(*) as count, loyalty_program_id')->with(['loyaltyProgram'])->groupBy('loyalty_program_id')->get();
        $props['loyalties'] = LoyaltyProgram::all();
        $props['customer'] = Customer::find(session('id'));
        return view('user.loyalty', $props);
    }

    public function orders()
    {
        $props['title'] = 'Order';
        $props['orders'] = Order::where('customer_id', session('id'))->with('customer')->get();
        return view('user.orders', $props);
    }
    public function showOrders($id)
    {
        $props['title'] = 'Order';
        $props['order'] = Order::where('id', $id)->with('customer')->first();
        $props['details'] = OrderDetail::where('order_id', $id)->with(['order', 'menu'])->get();
        return view('user.order-details', $props);
    }

    public function cancelOrder(Order $order)
    {
        if ($order->customer_id !== session('id')) {
            return response()->json(['success' => false, 'message' => 'Anda tidak berwenang melakukan aksi ini.'], 403);
        }

        if ($order->status !== 0) {
            return response()->json(['success' => false, 'message' => 'Pesanan ini tidak dapat dibatalkan lagi.'], 422);
        }

        $order->status = 3;
        $order->save();

        return response()->json(['success' => true, 'message' => 'Pesanan berhasil dibatalkan.']);
    }
}
