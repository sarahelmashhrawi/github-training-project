<?php

namespace App\Http\Controllers;

use App\Models\Individual;
use App\Models\Family; 
use App\Models\Tent;
use Illuminate\Http\Request;

class IndividualController
{
    public function index()
    {
        //
    }

    /**
     * عرض فورم إضافة فرد جديد
     */
    public function create(Request $request)
    {
        // نستقبل id العائلة القادم من زر "إضافة فرد" في صفحة العائلة
        $family_id = $request->query('family_id');
        
        // نجلب بيانات العائلة لنعرض اسمها في صفحة الإضافة للتأكيد
        $family = Family::findOrFail($family_id);

        return view('individuals.create', compact('family'));
    }

    /**
     * حفظ الفرد الجديد في قاعدة البيانات
     */
    public function store(Request $request)
    {
        // التحقق من صحة البيانات
        $validatedData = $request->validate([
            'family_id'            => 'required|exists:families,id',
            'full_name'            => 'required|string|max:255',
            'id_number'            => 'nullable|digits:9|unique:individuals,id_number', // 9 أرقام وغير مكرر
            'dob'                  => 'nullable|date',
            'gender'               => 'required|in:male,female,other',
            'relation_to_head'     => 'required|string|max:255',
            'special_status'       => 'nullable|string|max:255',
            'has_disability'       => 'boolean',
            'disability_type'      => 'required_if:has_disability,1',
            'has_chronic_disease'  => 'boolean',
            'chronic_disease_name' => 'required_if:has_chronic_disease,1',
        ], [
            'full_name.required'                 => 'اسم الفرد مطلوب.',
            'gender.required'                    => 'يرجى تحديد الجنس.',
            'relation_to_head.required'          => 'صلة القرابة مطلوبة.',
            'id_number.digits'                   => 'رقم الهوية يجب أن يتكون من 9 أرقام بالضبط.',
            'id_number.unique'                   => 'رقم الهوية هذا مسجل مسبقاً في النظام!',
            'disability_type.required_if'        => 'يرجى تحديد نوع الإعاقة.',
            'chronic_disease_name.required_if'   => 'يرجى كتابة اسم المرض المزمن.',
        ]);

        // تحويل قيمة صناديق الاختيار (الـ Checkboxes)
        $validatedData['has_disability'] = $request->has('has_disability') ? 1 : 0;
        $validatedData['has_chronic_disease'] = $request->has('has_chronic_disease') ? 1 : 0;

        // تنظيف البيانات (لو شال الصح، نحذف النص عشان ما يتخزن بالداتا بيز)
        if (!$validatedData['has_disability']) $validatedData['disability_type'] = null;
        if (!$validatedData['has_chronic_disease']) $validatedData['chronic_disease_name'] = null;

        // حفظ الفرد
        Individual::create($validatedData);

        // العودة لصفحة العائلة (الملف الشامل) مع رسالة نجاح
        return redirect()->route('families.show', $request->family_id)
                         ->with('success', 'تم إضافة الفرد إلى العائلة بنجاح!');
    }

    public function show(Individual $individual)
    {
        //
    }

   public function edit(Individual $individual)
    {
        return view('individuals.edit', compact('individual'));
    }

    /**
     * حفظ التعديلات في قاعدة البيانات
     */
    public function update(Request $request, Individual $individual)
    {
        // التحقق من صحة البيانات
        $validatedData = $request->validate([
            'full_name'            => 'required|string|max:255',
            // استثناء رقم الفرد الحالي من فحص التكرار لكي يقبل الحفظ
            'id_number'            => 'nullable|digits:9|unique:individuals,id_number,' . $individual->id,
            'dob'                  => 'nullable|date',
            'gender'               => 'required|in:male,female,other',
            'relation_to_head'     => 'required|string|max:255',
            'special_status'       => 'nullable|string|max:255',
            'has_disability'       => 'boolean',
            'disability_type'      => 'required_if:has_disability,1',
            'has_chronic_disease'  => 'boolean',
            'chronic_disease_name' => 'required_if:has_chronic_disease,1',
        ], [
            'full_name.required'                 => 'اسم الفرد مطلوب.',
            'gender.required'                    => 'يرجى تحديد الجنس.',
            'relation_to_head.required'          => 'صلة القرابة مطلوبة.',
            'id_number.digits'                   => 'رقم الهوية يجب أن يتكون من 9 أرقام بالضبط.',
            'id_number.unique'                   => 'رقم الهوية هذا مسجل مسبقاً في النظام!',
            'disability_type.required_if'        => 'يرجى تحديد نوع الإعاقة.',
            'chronic_disease_name.required_if'   => 'يرجى كتابة اسم المرض المزمن.',
        ]);

        // تحويل قيمة صناديق الاختيار
        $validatedData['has_disability'] = $request->has('has_disability') ? 1 : 0;
        $validatedData['has_chronic_disease'] = $request->has('has_chronic_disease') ? 1 : 0;

        // تنظيف البيانات في حال ألغى المستخدم التحديد
        if (!$validatedData['has_disability']) $validatedData['disability_type'] = null;
        if (!$validatedData['has_chronic_disease']) $validatedData['chronic_disease_name'] = null;

        // تحديث الفرد بالبيانات الجديدة
        $individual->update($validatedData);

        // العودة لصفحة تفاصيل العائلة مع رسالة نجاح
        return redirect()->route('families.show', $individual->family_id)
                         ->with('success', 'تم تعديل بيانات الفرد بنجاح!');
    }

    /**
     * حذف الفرد من قاعدة البيانات
     */
    public function destroy(Individual $individual)
    {
        // نحتفظ برقم العائلة قبل الحذف لكي نتمكن من العودة لصفحتها
        $family_id = $individual->family_id; 
        
        $individual->delete();

        return redirect()->route('families.show', $family_id)
                         ->with('success', 'تم حذف الفرد بنجاح!');
    }
}