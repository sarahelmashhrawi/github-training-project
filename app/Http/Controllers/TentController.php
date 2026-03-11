<?php

namespace App\Http\Controllers;

// استدعاء الكلاس الأساسي بشكل مباشر
use Illuminate\Routing\Controller as BaseController;
use App\Models\Tent;
use App\Models\Sector;
use Illuminate\Http\Request;

class TentController extends BaseController
{
    // ... باقي الدوال (index, create, store) بتضل مثل ما هي

    /**
     * عرض قائمة الخيام
     */
    public function index()
    {
        // سحب الخيام مع بيانات المنطقة التابعة لها لمنع استعلامات إضافية
        $tents = Tent::with('sector')->get(); 
        return view('tents.index', compact('tents'));
    }

    /**
     * صفحة إضافة خيمة جديدة
     */
    public function create()
    {
        // نحتاج جلب كل المناطق لعرضها في قائمة الاختيار (Dropdown)
        $sectors = Sector::all();
        return view('tents.create', compact('sectors'));
    }

    /**
     * حفظ الخيمة في قاعدة البيانات
     */
    
    /**
     * صفحة تعديل خيمة موجودة
     */
    public function edit(Tent $tent)
    {
        $sectors = Sector::all();
        return view('tents.edit', compact('tent', 'sectors'));
    }

    /**
     * تحديث بيانات الخيمة
     */
  public function store(Request $request)
    {
        // 1. فحص البيانات (هذا الكود اللي كان ناقص عندك)
        $request->validate([
            'sector_id' => 'required',
            'tent_number' => [
                'required',
                'regex:/^[A-Z]+-[0-9]+$/', // السيستم: حرف ثم شرطة ثم رقم
                'unique:tents,tent_number'  // يمنع التكرار
            ],
            'condition' => 'required',
            // التعديل هنا: إضافة max:20
            'capacity' => 'required|integer|min:1|max:20' 
        ], [
            // الرسائل اللي رح تظهر في النافذة المنبثقة
            'tent_number.regex' => 'تنسيق رقم الخيمة خاطئ! (مثال: T-11)',
            'tent_number.unique' => 'رقم هذه الخيمة مسجل مسبقاً في النظام، الرجاء التأكد!',
            // التعديل هنا: رسالة التنبيه إذا تجاوز العدد 20
            'capacity.max' => 'أقصى سعة مسموحة للخيمة هي 20 فرداً فقط!' 
        ]);

        // 2. الحفظ في قاعدة البيانات
        \App\Models\Tent::create($request->all());

        // 3. العودة لصفحة العرض مع رسالة نجاح
        return redirect()->route('tents.index')->with('success', 'تم إضافة الخيمة بنجاح');
    }

    public function update(Request $request, $id)
    {
        // 1. فحص البيانات والسيستم (مع استثناء الخيمة الحالية من شرط التكرار)
        $request->validate([
            'sector_id' => 'required',
            'tent_number' => [
                'required',
                'regex:/^[A-Z]+-[0-9]+$/', // السيستم: يرفض أي قيمة شاذة (يجب حرف-رقم)
                'unique:tents,tent_number,' . $id // السر هنا: استثناء الخيمة الحالية من فحص التكرار
            ],
            'condition' => 'required',
            // التعديل هنا: إضافة max:20
            'capacity' => 'required|integer|min:1|max:20'
        ], [
            'tent_number.regex' => 'تنسيق رقم الخيمة خاطئ! يجب أن يكون حرف ثم شرطة ثم رقم (مثال: T-11)',
            'tent_number.unique' => 'رقم هذه الخيمة مسجل مسبقاً لخيمة أخرى، الرجاء التأكد!',
            // التعديل هنا: رسالة التنبيه إذا تجاوز العدد 20
            'capacity.max' => 'أقصى سعة مسموحة للخيمة هي 20 فرداً فقط!'
        ]);

        // 2. جلب الخيمة وتحديثها
        $tent = \App\Models\Tent::findOrFail($id);
        $tent->update($request->all());

        // 3. العودة لصفحة العرض مع رسالة النجاح
        return redirect()->route('tents.index')->with('success', 'تم تعديل الخيمة بنجاح');
    }

    /**
     * حذف خيمة
     */
    public function destroy(Tent $tent)
    {
        $tent->delete();
        // هذه الرسالة ستظهر في التنبيه الذي برمجناه في الـ Index
        return redirect()->route('tents.index')->with('success', 'تم حذف الخيمة بنجاح');
    }
}