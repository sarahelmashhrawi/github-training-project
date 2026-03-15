<?php

namespace App\Http\Controllers;

use App\Models\Individual;
use App\Models\Family; 
use App\Models\Tent;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class IndividualController
{
   public function index()
{
   // 1. جلب كل الأفراد مع عائلاتهم
    $individuals = Individual::with('family')->get();

    // 2. جلب كل رؤساء العائلات (أرباب الأسر)
    $familyHeads = Family::all();

    
    return view('individuals.index', compact('individuals', 'familyHeads'));
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
        // 1. التحقق من صحة البيانات
        $validatedData = $request->validate([
            'family_id'            => 'required|exists:families,id',
            'full_name'            => 'required|string|max:255',
            'id_number'            => 'required|digits:9|unique:individuals,id_number',
            'dob'                  => 'nullable|date',
            'gender'               => 'required|in:male,female,other',
            'relation_to_head'     => 'required|string|max:255',
            'special_status'       => 'nullable|string|max:255',
            'has_disability'       => 'boolean',
            'disability_type'      => 'required_if:has_disability,1',
            'has_chronic_disease'  => 'boolean',
            'chronic_disease_name' => 'required_if:has_chronic_disease,1',
            'medical_attachment'   => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
            'is_pregnant'          => 'boolean',
            'is_breastfeeding'     => 'boolean',
        ], [
            'full_name.required'                 => 'اسم الفرد مطلوب.',
            'gender.required'                    => 'يرجى تحديد الجنس.',
            'relation_to_head.required'          => 'صلة القرابة مطلوبة.',
            'id_number.digits'                   => 'رقم الهوية يجب أن يتكون من 9 أرقام بالضبط.',
            'id_number.unique'                   => 'رقم الهوية هذا مسجل مسبقاً في النظام!',
            'disability_type.required_if'        => 'يرجى تحديد نوع الإعاقة.',
            'chronic_disease_name.required_if'   => 'يرجى كتابة اسم المرض المزمن.',
        ]);

        // 2. معالجة المرفق الطبي إن وجد
        if ($request->hasFile('medical_attachment')) {
            $path = $request->file('medical_attachment')->store('medical_attachments', 'public');
            $validatedData['medical_attachment'] = $path;
        }

        // 3. تحويل قيمة صناديق الاختيار وتخليص البيانات
        $validatedData['has_disability'] = $request->has('has_disability') ? 1 : 0;
        $validatedData['has_chronic_disease'] = $request->has('has_chronic_disease') ? 1 : 0;

        if (!$validatedData['has_disability']) {
            $validatedData['disability_type'] = null;
        }
        if (!$validatedData['has_chronic_disease']) {
            $validatedData['chronic_disease_name'] = null;
        }

        // معالجة قيم الحمل والرضاعة
        $validatedData['is_pregnant'] = $request->has('is_pregnant') ? 1 : 0;
        $validatedData['is_breastfeeding'] = $request->has('is_breastfeeding') ? 1 : 0;

        // حماية إضافية: إذا كان ذكراً، نصفر القيم إجبارياً
        if ($validatedData['gender'] === 'male') {
            $validatedData['is_pregnant'] = 0;
            $validatedData['is_breastfeeding'] = 0;
        }

        // 4. حفظ الفرد في قاعدة البيانات
        Individual::create($validatedData);

        // 5. العودة لصفحة العائلة مع رسالة نجاح
        return redirect()->route('families.show', $request->family_id)
                         ->with('success', 'تم إضافة الفرد بنجاح!');
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
        // 1. التحقق من صحة البيانات
        $validatedData = $request->validate([
            'full_name'            => 'required|string|max:255',
            'id_number'            => 'required|digits:9|unique:individuals,id_number,' . $individual->id,
            'dob'                  => 'nullable|date',
            'gender'               => 'required|in:male,female,other',
            'relation_to_head'     => 'required|string|max:255',
            'special_status'       => 'nullable|string|max:255',
            'has_disability'       => 'boolean',
            'disability_type'      => 'required_if:has_disability,1',
            'has_chronic_disease'  => 'boolean',
            'chronic_disease_name' => 'required_if:has_chronic_disease,1',
            'medical_attachment'   => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
            'is_pregnant'          => 'boolean',
            'is_breastfeeding'     => 'boolean',
        ], [
            'full_name.required'                 => 'اسم الفرد مطلوب.',
            'gender.required'                    => 'يرجى تحديد الجنس.',
            'relation_to_head.required'          => 'صلة القرابة مطلوبة.',
            'id_number.digits'                   => 'رقم الهوية يجب أن يتكون من 9 أرقام بالضبط.',
            'id_number.unique'                   => 'رقم الهوية هذا مسجل مسبقاً في النظام!',
            'disability_type.required_if'        => 'يرجى تحديد نوع الإعاقة.',
            'chronic_disease_name.required_if'   => 'يرجى كتابة اسم المرض المزمن.',
        ]);

        // 2. معالجة المرفق الطبي وتحديثه
        if ($request->hasFile('medical_attachment')) {
            if ($individual->medical_attachment) {
                Storage::disk('public')->delete($individual->medical_attachment);
            }
            $path = $request->file('medical_attachment')->store('medical_attachments', 'public');
            $validatedData['medical_attachment'] = $path;
        }

        // 3. تحويل قيمة صناديق الاختيار وتنظيف البيانات
        $validatedData['has_disability'] = $request->has('has_disability') ? 1 : 0;
        $validatedData['has_chronic_disease'] = $request->has('has_chronic_disease') ? 1 : 0;

        if (!$validatedData['has_disability']) {
            $validatedData['disability_type'] = null;
        }
        if (!$validatedData['has_chronic_disease']) {
            $validatedData['chronic_disease_name'] = null;
        }

        // معالجة قيم الحمل والرضاعة
        $validatedData['is_pregnant'] = $request->has('is_pregnant') ? 1 : 0;
        $validatedData['is_breastfeeding'] = $request->has('is_breastfeeding') ? 1 : 0;

        // حماية إضافية: إذا كان ذكراً، نصفر القيم إجبارياً
        if ($validatedData['gender'] === 'male') {
            $validatedData['is_pregnant'] = 0;
            $validatedData['is_breastfeeding'] = 0;
        }

        // 4. تحديث البيانات
        $individual->update($validatedData);

        // 5. العودة لصفحة تفاصيل العائلة مع رسالة نجاح
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
        
        // التحقق مما إذا كان هناك ملف مرفق وحذفه من السيرفر
        if ($individual->medical_attachment) {
            Storage::disk('public')->delete($individual->medical_attachment);
        }
        
        // حذف الفرد
        $individual->delete();

        return redirect()->route('families.show', $family_id)
                         ->with('success', 'تم حذف الفرد بنجاح!');
    }
}