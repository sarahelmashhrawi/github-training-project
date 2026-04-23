<?php

namespace App\Http\Controllers;

use App\Models\Camp;
use App\Models\Sector;
use Illuminate\Http\Request;

class CampController 
{
    /**
     * 1. عرض جميع المخيمات في جدول
     */
    public function index()
    {
        // جلب المخيمات مع بيانات القطاع المرتبط بها لتحسين الأداء
        $camps = Camp::with('sector')->get();
        return view('camps.index', compact('camps'));
    }

    /**
     * 2. عرض صفحة إضافة مخيم جديد
     */
    public function create()
    {
        // جلب القطاعات عشان تختار المخيم هاد لأي قطاع بيتبع
        $sectors = Sector::all();
        return view('camps.create', compact('sectors'));
    }

    /**
     * 3. تخزين بيانات المخيم الجديد في قاعدة البيانات
     */
    public function store(Request $request)
    {
        $request->validate([
            'camp_number' => 'required|unique:camps',
            'name' => 'required|string|max:255',
            'location' => 'required',
            'sector_id' => 'required|exists:sectors,id',
            'max_capacity' => 'required|integer|min:1',
            'status' => 'required|in:active,full,under_construction',
        ]);

        Camp::create($request->all());

        return redirect()->route('camps.index')->with('success', 'تم إضافة المخيم بنجاح');
    }

    /**
     * 4. عرض تفاصيل مخيم معين (اختياري)
     */
    public function show(Camp $camp)
    {
        // جلب المخيم مع كل اللي جواه: خيام، عائلات، واحتياجات
        $camp->load(['tents', 'families', 'emergencyNeeds']);
        return view('admin.camps.show', compact('camp'));
    }

    /**
     * 5. عرض صفحة تعديل بيانات مخيم
     */
    public function edit($id)
{
    $camp = Camp::findOrFail($id);
    
    // تأكد من جلب السيكتورز من قاعدة البيانات
    $sectors = Sector::all(); 

    // تأكد من تمرير المتغير هنا باستخدام compact أو array
    return view('camps.edit', compact('camp', 'sectors'));
}
    /**
     * 6. تحديث البيانات في قاعدة البيانات
     */
 public function update(Request $request, $id)
{
    // التحقق من البيانات
    $request->validate([
        'camp_number'  => 'required|string|unique:camps,camp_number,' . $id,
        'name'         => 'required|string|max:255',
        'location'     => 'required|string',
        'max_capacity' => 'required|integer|min:0',
        'needed_aid'   => 'nullable|string',
        'status'       => 'required|in:active,full,under_construction',
        'sector_id'    => 'required|exists:sectors,id',
    ]);

    // جلب السجل وتحديثه
    $camp = Camp::findOrFail($id);
    $isUpdated = $camp->update($request->all());

    // التوجيه مع رسالة نجاح 
    if ($isUpdated) {
        return redirect()->route('camps.index')->with('success', 'تم تحديث بيانات المخيم بنجاح');
    } else {
        return redirect()->back()->with('error', 'حدث خطأ أثناء التحديث');
    }
}

    /**
     * 7. حذف مخيم
     */
    public function destroy(Camp $camp)
{
    $isDeleted = $camp->delete();

    if ($isDeleted) {
        return response()->json([
            'icon' => 'success',
            'title' => 'تم الحذف بنجاح',
            'text' => 'تم إزالة بيانات المخيم من النظام بنجاح'
        ], 200);
    } else {
        return response()->json([
            'icon' => 'error',
            'title' => 'فشل الحذف',
            'text' => 'حدث خطأ غير متوقع أثناء محاولة الحذف'
        ], 400);
    }
}
}