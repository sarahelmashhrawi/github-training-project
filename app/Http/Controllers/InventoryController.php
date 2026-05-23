<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use Illuminate\Http\Request;

class InventoryController {
    public function index() {
        $items = Inventory::all(); //جلب كافة الاصناف المسجلة في المخزن من قاعدة البيانات
        return view('inventories.index', compact('items'));
    }

    public function create() {
        return view('inventories.create');
    }

    public function store(Request $request) {
        $data = $request->validate([
            'item_name' => 'required|string',
            'total_quantity' => 'required|integer',
            'quantity_available' => 'required|integer',
            'category' => 'required|string',
            'storage_location' => 'nullable|string|max:255'
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
            'quantity_available' => 'required|integer',
            'category' => 'required|string',
            'storage_location' => 'required|string',
        ]);
        $inventory->update($data);//يقوم بتحديث الصنف المخزن في قاعدة البيانات
        return redirect()->route('inventories.index')->with('success', 'تم تحديث المخزن');
    }

    public function destroy(Inventory $inventory)
{
    $isDeleted = $inventory->delete();

    if ($isDeleted) {
        return response()->json(['icon' => 'success', 'title' => 'تم الحذف بنجاح'], 200);
    } else {
        return response()->json(['icon' => 'error', 'title' => 'فشل عملية الحذف'], 400);
    }
}
}
