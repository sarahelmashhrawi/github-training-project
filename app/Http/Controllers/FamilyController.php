<?php

namespace App\Http\Controllers;

use App\Models\Family;
use Illuminate\Http\Request;
use App\Models\Tent;
class FamilyController
{

    /**
     * عرض كل العائلات
     */
    public function index()
    {
      
        $families = Family::with('tent')->get(); 
    return view('families.index', compact('families'));
    }

    /**
     * عرض فورم إضافة عائلة جديدة
     */
    public function create()
    {
        // نجلب كل الخيام لكي تظهر في القائمة المنسدلة لاختيار خيمة العائلة
        $tents = Tent::all();
        return view('families.create', compact('tents'));
    }

    /**
     * حفظ العائلة الجديدة في قاعدة البيانات (AJAX)
     */
    public function store(Request $request)
    {
        // 1. التحقق من صحة البيانات (تم إضافة تاريخ الميلاد والحالة الاجتماعية)
        $request->validate([
            'tent_id'        => 'required|exists:tents,id',
            'head_name'      => 'required|string|max:255',
            'id_number'      => 'required|digits:9',
            'dob'            => 'nullable|date',
            'marital_status' => 'nullable|string',
            'phone'          => 'nullable|string|max:20',
            'original_area'  => 'nullable|string|max:255',
            'current_area'   => 'nullable|string|max:255',
            'family_type'    => 'required|in:normal,female_headed,orphans',
        ], [
            'id_number.required' => 'رقم الهوية مطلوب.',
            'id_number.digits'   => 'عذراً، رقم الهوية يجب أن يتكون من 9 أرقام بالضبط.',
            'tent_id.required'   => 'الرجاء اختيار الخيمة التي ستسكن فيها العائلة.',
            'head_name.required' => 'اسم رب/ربة الأسرة مطلوب.',
        ]);

        // 2. حفظ البيانات
        Family::create($request->all());

        // 3. إرجاع استجابة JSON للـ AJAX
        return response()->json([
            'icon'     => 'success',
            'title'    => 'رائع!',
            'text'     => 'تم تسجيل العائلة بنجاح!',
            'redirect' => route('families.index') 
        ], 200);
    }

    /**
     * عرض تفاصيل عائلة محددة
     */
    public function show(Family $family)
    {
        // نجلب أفراد العائلة التابعين لها
        $individuals = $family->individuals ?? []; // حماية إضافية لو العلاقة مش موجودة
        return view('families.show', compact('family', 'individuals'));
    }

    /**
     * عرض فورم تعديل بيانات العائلة
     */
    public function edit(Family $family)
    {
        $tents = Tent::all();
        return view('families.edit', compact('family', 'tents'));
    }

    /**
     * تحديث بيانات العائلة في قاعدة البيانات (AJAX)
     */
    public function update(Request $request, Family $family)
    {
        // 1. التحقق من صحة البيانات
        $request->validate([
            'tent_id'        => 'required|exists:tents,id',
            'head_name'      => 'required|string|max:255',
            'id_number'      => 'required|digits:9',
            'dob'            => 'nullable|date',
            'marital_status' => 'nullable|string',
            'phone'          => 'nullable|string|max:20',
            'original_area'  => 'nullable|string|max:255',
            'current_area'   => 'nullable|string|max:255',
            'family_type'    => 'required|in:normal,female_headed,orphans',
        ], [
            'id_number.required' => 'رقم الهوية مطلوب.',
            'id_number.digits'   => 'عذراً، رقم الهوية يجب أن يتكون من 9 أرقام بالضبط.', 
        ]);

        // 2. تحديث البيانات
        $family->update($request->all());

        // 3. إرجاع استجابة JSON للـ AJAX بدل الـ Redirect
        return response()->json([
            'icon'     => 'success',
            'title'    => 'تم التعديل!',
            'text'     => 'تم تعديل بيانات العائلة بنجاح!',
            'redirect' => route('families.index')
        ], 200);
    }

    /**
     * حذف العائلة من قاعدة البيانات (AJAX)
     */
    public function destroy(Family $family)
    {
        $family->delete();
        
        // إرجاع استجابة JSON لزر الحذف اللي بيستخدم AJAX
        return response()->json([
            'icon'  => 'success',
            'title' => 'تم الحذف!',
            'text'  => 'تم حذف العائلة بنجاح!'
        ], 200);
    }
}