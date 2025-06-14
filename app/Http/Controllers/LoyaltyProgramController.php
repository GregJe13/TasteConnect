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
        $valid = Validator::make($request->all(), [
            'name' => 'required',
            'point' => 'required',
            'reward' => 'required',
            'startDate' => 'required|date',
            'endDate' => 'required|date',
        ]);
        if ($valid->fails()) {
            return response()->json(['message' => $valid->errors()->first(), 'success' => false]);
        }

        LoyaltyProgram::create($valid->validated());
        return response()->json(['message' => 'Data successfully added!', 'success' => true]);
    }
    public function update(Request $request, LoyaltyProgram $program)
    {
        $valid = Validator::make($request->all(), [
            'name' => 'required',
            'point' => 'required',
            'reward' => 'required',
            'startDate' => 'required|date',
            'endDate' => 'required|date',
        ]);
        if ($valid->fails()) {
            return response()->json(['message' => $valid->errors()->first(), 'success' => false]);
        }

        $program->name = $request->name;
        $program->point = $request->point;
        $program->reward = $request->reward;
        $program->startDate = $request->startDate;
        $program->endDate = $request->endDate;
        $program->save();

        return response()->json(['message' => 'Data successfully updated!', 'success' => true]);
    }

    public function delete(LoyaltyProgram $program)
    {
        $program->delete();
        return response()->json(['message' => 'Data successfully deleted!', 'success' => true]);
    }
}
