<?php

namespace App\Http\Controllers;

use App\Models\Receiving;
use App\Models\Family;
use App\Models\Inventory;
use App\Models\Campaign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReceivingController 
{
    // عرض الكل باستخدام Eloquent Relationships
    public function index()
    {
        $receivings = Receiving::with(['family', 'inventory', 'campaign'])->latest()->get();
        return view('receivings.index', compact('receivings'));
    }
public function create()
{
    $families = \App\Models\Family::all();
    $inventories = \App\Models\Inventory::all();
    $campaigns = \App\Models\Campaign::all();
    
    return view('receivings.create', compact('families', 'inventories', 'campaigns'));
}
public function store(Request $request)
{
    // 1. التحقق من البيانات
    $validator = Validator($request->all(), [
        'family_id'         => 'required|exists:families,id',
        'inventory_id'      => 'required|exists:inventories,id',
        'campaign_id'       => 'required|exists:campaigns,id',
        'quantity_received' => 'required|numeric|min:1',
    ]);

    if (!$validator->fails()) {
        // 2. حفظ البيانات
        $receiving = new Receiving();//انشاء كائن جديد من مودل الاستلام
        $receiving->family_id = $request->input('family_id');
        $receiving->inventory_id = $request->input('inventory_id');
        $receiving->campaign_id = $request->input('campaign_id');
        $receiving->quantity_received = $request->input('quantity_received');
        
        $isSaved = $receiving->save();//تقوم بكتابة السطر الجديد في قاعدة البيانات

        // 3. إرسال رد لـ JavaScript (عشان تطلع رسالة النجاح)
        return response()->json([
            'icon' => $isSaved ? 'success' : 'error',
            'title' => $isSaved ? 'تم التسجيل بنجاح' : 'فشل التسجيل'
        ], $isSaved ? 200 : 400);
        
    } else {
        // إذا كانت البيانات ناقصة)
        return response()->json([
            'icon' => 'error',
            'title' => $validator->getMessageBag()->first()
        ], 400);
    }
}
    // عرض صفحة التعديل
public function edit(Receiving $receiving)
{
    $families = Family::all();
    $inventories = Inventory::all();
    $campaigns = Campaign::all(); // جلب الحملات من الجدول
    return view('receivings.edit', compact('receiving', 'families', 'inventories', 'campaigns'));
}

// دالة التحديث النهائية
public function update(Request $request, Receiving $receiving)
{
    $request->validate([
        'quantity_received' => 'required|integer|min:1',
        'campaign_id' => 'required|exists:campaigns,id', // نتحقق من الـ ID
    ]);

    $inventory = $receiving->inventory;
    $difference = $request->quantity_received - $receiving->quantity_received;

    if ($inventory->quantity_available < $difference) {
        return response()->json(['icon' => 'error', 'title' => 'المخزن لا يكفي للتعديل!'], 400);
    }

    $inventory->decrement('quantity_available', $difference);

    // تحديث البيانات باستخدام Eloquent
    $updated = $receiving->update([
        'quantity_received' => $request->quantity_received,
        'campaign_id' => $request->campaign_id, // حفظ الـ ID الصحيح
    ]);

    if ($updated) {
        return response()->json(['icon' => 'success', 'title' => 'تم التعديل بنجاح'], 200);
    }

    return response()->json(['icon' => 'error', 'title' => 'فشل في تحديث البيانات'], 500);
}
    // حذف السجل وإعادة الكمية للمخزن
    public function destroy(Receiving $receiving)
    {
        // 1. استرجاع الكمية للمخزن أولاً
    $inventory = $receiving->inventory;
    if ($inventory) {
        $inventory->increment('quantity_available', $receiving->quantity_received);
    }

    // 2. حذف السجل
    if ($receiving->delete()) {
        return response()->json(['icon' => 'success', 'title' => 'تم حذف العملية وإرجاع الكمية للمخزن'], 200);
    }

    return response()->json(['icon' => 'error', 'title' => 'حدث خطأ أثناء الحذف'], 500);
    }
}