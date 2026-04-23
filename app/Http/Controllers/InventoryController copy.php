<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use Illuminate\Http\Request;


class InventoryController  {

public function index() {
   $inventories = Inventory::all(); 
    return view('inventories.index', compact('inventories'));
    }

    public function create() {
        return view('inventories.create');
    }

    public function store(Request $request) {
        $request->validate([
            'item_name' => 'required',
            'total_quantity' => 'required|numeric',
             'quantity_available' => 'required',        ]);

        Inventory::create($request->all());
        return response()->json(['icon' => 'success', 'title' => 'تم الحفظ', 'text' => 'تمت إضافة الصنف بنجاح', 'redirect' => route('inventories.index')]);
    }

    public function edit(Inventory $inventory) {
        return view('inventories.edit', compact('inventory'));
    }

    public function update(Request $request, Inventory $inventory) {
        $request->validate(['item_name' => 'required']);
        $inventory->update($request->all());
        return response()->json(['icon' => 'success', 'title' => 'تم التعديل', 'text' => 'تم تحديث البيانات بنجاح', 'redirect' => route('inventories.index')]);
    }

    public function destroy(Inventory $inventory) {
        $inventory->delete();
        return response()->json(['icon' => 'success', 'title' => 'تم الحذف', 'message' => 'تم حذف الصنف من المخزن']);
    }
}