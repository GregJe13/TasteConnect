<?php

namespace App\Http\Controllers;

use App\Models\Promotion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PromotionController extends Controller
{
    public function index()
    {
        $props['title'] = 'Manage Promotions';
        $props['promotions'] = Promotion::all();
        return view('admin.promotion', $props);
    }

    public function deletePromotion(Promotion $promotion)
    {
        $promotion->delete();
        return response()->json(['message' => 'Data successfully deleted!', 'success' => true]);
    }

    public function createPromotion(Request $request)
    {
        $valid = Validator::make($request->all(), [
            'title' => 'required',
            'discountAmount' => 'required',
            'startDate' => 'required|date',
            'endDate' => 'required|date',
        ]);
        if ($valid->fails()) {
            return response()->json(['message' => $valid->errors()->first(), 'success' => false]);
        }

        Promotion::create($valid->validated());
        return response()->json(['message' => 'Data successfully added!', 'success' => true]);
    }

    public function updatePromotion(Request $request, Promotion $promotion)
    {
        $valid = Validator::make($request->all(), [
            'title' => 'required',
            'discountAmount' => 'required',
            'startDate' => 'required|date',
            'endDate' => 'required|date',
        ]);
        if ($valid->fails()) {
            return response()->json(['message' => $valid->errors()->first(), 'success' => false]);
        }

        $promotion->update($valid->validated());
        return response()->json(['message' => 'Data successfully updated!', 'success' => true]);
    }
}
