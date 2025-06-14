<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FeedbackController extends Controller
{
    public function addFeedback(Request $request)
    {
        $valid = Validator::make($request->all(), [
            'order_id' => 'required',
            'comment' => 'required',
            'rating' => 'required',

        ]);

        if ($valid->fails()) {
            return response()->json(['message' => $valid->errors()->first(), 'success' => false]);
        }

        Feedback::create([
            'order_id' => $request->order_id,
            'comment' => $request->comment,
            'rating' => $request->rating,
            'date' => now(),
        ]);

        Order::where('id', $request->order_id)->update(['status' => 4]);

        return response()->json(['message' => 'Feedback created successfully', 'success' => true]);
    }
}
