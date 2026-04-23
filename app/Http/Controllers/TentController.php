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
 /**
     * حفظ الخيمة في قاعدة البيانات
     */
    public function store(Request $request)
    {
        $request->validate([
            'sector_id' => 'required',
            'tent_number' => ['required', 'regex:/^[A-Z]+-[0-9]+$/', 'unique:tents,tent_number'],
            'condition' => 'required',
            'capacity' => 'required|integer|min:1|max:20' 
        ], [
            'tent_number.regex' => 'تنسيق رقم الخيمة خاطئ! (مثال: T-11)',
            'tent_number.unique' => 'رقم هذه الخيمة مسجل مسبقاً!',
            'capacity.max' => 'أقصى سعة مسموحة هي 20 فرداً!' 
        ]);

        \App\Models\Tent::create($request->all());

        // التعديل: إرجاع JSON ليتوافق مع الـ AJAX الخاص بـ crud.js
        return response()->json(['message' => 'تم إضافة الخيمة بنجاح'], 200);
    }

    /**
     * تحديث بيانات الخيمة
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'sector_id' => 'required',
            'tent_number' => ['required', 'regex:/^[A-Z]+-[0-9]+$/', 'unique:tents,tent_number,' . $id],
            'condition' => 'required',
            'capacity' => 'required|integer|min:1|max:20'
        ], [
            'tent_number.regex' => 'تنسيق رقم الخيمة خاطئ!',
            'tent_number.unique' => 'رقم هذه الخيمة مسجل مسبقاً!',
            'capacity.max' => 'أقصى سعة مسموحة هي 20 فرداً!'
        ]);

        $tent = \App\Models\Tent::findOrFail($id);
        $tent->update($request->all());

        // التعديل: إرجاع JSON
        return response()->json(['message' => 'تم تعديل الخيمة بنجاح'], 200);
    }

    /**
     * حذف خيمة
     */
    public function destroy(Tent $tent)
    {
        $tent->delete();
        
        // التعديل: إرجاع JSON ليتوافق مع دالة confirmDestroy
        return response()->json(['message' => 'تم حذف الخيمة بنجاح'], 200);
    }

}