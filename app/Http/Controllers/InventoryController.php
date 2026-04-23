<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use Illuminate\Http\Request;

class InventoryController {
    public function index() {
        $items = Inventory::all();
        return view('inventories.index', compact('items'));
    }

    public function create() {
        return view('inventories.create');
    }

    public function store(Request $request) {
        $data = $request->validate([
            'item_name' => 'required|string',
            'total_quantity' => 'required|integer',
            'available_quantity' => 'required|integer',
            'category' => 'required|string',
        ]);
        Inventory::create($data);
        return redirect()->route('inventories.index')->with('success', 'تم إضافة الصنف');
    }

    public function edit(Inventory $inventory) {
        return view('inventories.edit', compact('inventory'));
    }

    public function update(Request $request, Inventory $inventory) {
        $data = $request->validate([
            'item_name' => 'required|string',
            'total_quantity' => 'required|integer',
            'available_quantity' => 'required|integer',
            'category' => 'required|string',
        ]);
        $inventory->update($data);
        return redirect()->route('inventories.index')->with('success', 'تم تحديث المخزن');
    }

    public function destroy(Inventory $inventory) {
        $inventory->delete();
        return redirect()->route('inventories.index')->with('success', 'تم حذف الصنف');
    }
}
