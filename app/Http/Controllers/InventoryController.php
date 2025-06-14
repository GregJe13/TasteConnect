<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InventoryController extends Controller
{
    public function checkStock()
    {
        $props['title'] = 'Inventory';
        $props['inventories'] = Inventory::all();
        return view('admin.inventory', $props);
    }

    public function store(Request $request)
    {
        $valid =  Validator::make($request->all(), [
            'name' => 'required',
            'stock' => 'required|numeric'
        ]);

        if ($valid->fails()) {
            return response()->json(['message' => $valid->errors()->first(), 'success' => false]);
        }
        Inventory::create($valid->validated());
        return response()->json(['message' => 'Data added successfully', 'success' => true]);
    }

    public function updateStock(Request $request, Inventory $inventory)
    {
        $valid =  Validator::make($request->all(), [
            'name' => 'required',
            'stock' => 'required|numeric'
        ]);

        if ($valid->fails()) {
            return response()->json(['message' => $valid->errors()->first(), 'success' => false]);
        }
        $inventory->update($request->all());
        return response()->json(['message' => 'Data updated successfully', 'success' => true]);
    }

    public function destroy(Inventory $inventory)
    {
        $inventory->delete();
        return response()->json(['message' => 'Data deleted successfully', 'success' => true]);
    }
}
