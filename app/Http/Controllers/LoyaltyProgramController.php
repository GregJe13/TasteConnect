<?php

namespace App\Http\Controllers;

use App\Models\LoyaltyProgram;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LoyaltyProgramController extends Controller
{
    public function index()
    {
        $props['title'] = 'Manage Loyalty Program';
        $props['programs'] = LoyaltyProgram::all();
        return view('admin.loyalty', $props);
    }
    public function show($id)
    {
        $props['title'] = 'Loyalty Program Details';
        $props['program'] = LoyaltyProgram::where('id', $id)->first();
        return view('admin.loyalty-details', $props);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'      => 'required|string|max:255|unique:loyalty_programs,name',
            'point'     => 'required|integer|min:1',
            'reward'    => 'required|string|max:255',
            'startDate' => 'required|date',
            'endDate'   => 'required|date|after_or_equal:startDate',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
        }

        LoyaltyProgram::create($validator->validated());
        return response()->json(['message' => 'Data berhasil ditambahkan!', 'success' => true]);
    }

    public function update(Request $request, LoyaltyProgram $program)
    {
        $validator = Validator::make($request->all(), [
            'name'      => 'required|string|max:255|unique:loyalty_programs,name,' . $program->id,
            'point'     => 'required|integer|min:1',
            'reward'    => 'required|string|max:255',
            'startDate' => 'required|date',
            'endDate'   => 'required|date|after_or_equal:startDate',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
        }

        $program->update($validator->validated());

        return response()->json(['message' => 'Data berhasil diperbarui!', 'success' => true]);
    }

    public function delete(LoyaltyProgram $program)
    {
        if ($program->customerLoyalties()->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Program ini tidak dapat dihapus karena sudah pernah di-redeem oleh pelanggan.'
            ], 409);
        }

        $program->delete();

        return response()->json(['message' => 'Data berhasil dihapus!', 'success' => true]);
    }
}
