<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\CustomerLoyalty;
use App\Models\LoyaltyProgram;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CustomerLoyaltyController extends Controller
{
    public function redeemLoyaltyPoint(Request $request)
    {
        $valid = Validator::make($request->all(), [
            'loyalty_program_id' => 'required',
        ]);

        if ($valid->fails()) {
            return response()->json(['message' => $valid->errors()->first(), 'success' => false], 400);
        }

        $decrement = LoyaltyProgram::find($request->loyalty_program_id)->point;
        $customer = Customer::find(session('id'));
        
        if ($customer->loyaltyPoint - $decrement < 0) {
            return response()->json(['message' => 'Insufficient loyalty points!', 'success' => false], 400);
        }

        CustomerLoyalty::create([
            'customer_id' => session('id'),
            'loyalty_program_id' => $request->loyalty_program_id,
        ]);

        $customer->update([
            'loyaltyPoint' => $customer->loyaltyPoint - $decrement,
        ]);

        return response()->json(['message' => 'Loyalty program redeemed successfully!', 'success' => true], 200);
    }
}
