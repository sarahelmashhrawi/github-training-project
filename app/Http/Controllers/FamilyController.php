<?php

namespace App\Http\Controllers;

use App\Models\Family;
use Illuminate\Http\Request;
use App\Models\Tent;
class FamilyController
{

public function index()
    {
        // نجلب كل العائلات مع بيانات الخيمة المرتبطة بها (لتسريع الأداء)
        $families = Family::with('tent')->latest()->get();
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
     * حفظ العائلة الجديدة في قاعدة البيانات
     */
    public function store(Request $request)
    {
        // 1. التحقق من صحة البيانات
        $request->validate([
            'tent_id'       => 'required|exists:tents,id',
            'head_name'     => 'required|string|max:255',
            'id_number'     => 'required|digits:9',
            'phone'         => 'nullable|string|max:20',
            'original_area' => 'nullable|string|max:255',
            'current_area'  => 'nullable|string|max:255',
            'family_type'   => 'required|in:normal,female_headed,orphans',
        ], [
            'id_number.required' => 'رقم الهوية مطلوب.',
            'id_number.digits'   => 'عذراً، رقم الهوية يجب أن يتكون من 9 أرقام بالضبط.',
            'tent_id.required'   => 'الرجاء اختيار الخيمة التي ستسكن فيها العائلة.',
            'head_name.required' => 'اسم رب/ربة الأسرة مطلوب.',
        
            ]);

        // 2. حفظ البيانات
        Family::create($request->all());

        // 3. التوجيه لصفحة العرض مع رسالة نجاح
        return redirect()->route('families.index')->with('success', 'تم تسجيل العائلة بنجاح!');
    }

    /**
     * عرض تفاصيل عائلة محددة (ممكن نستخدمها لاحقاً لعرض أفراد العائلة)
     */
    public function show(Family $family)
    {
        // نجلب أفراد العائلة التابعين لها
        $individuals = $family->individuals;
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
     * تحديث بيانات العائلة في قاعدة البيانات
     */
    public function update(Request $request, Family $family)
    {
        // 1. التحقق من صحة البيانات
        $request->validate([
            'tent_id'       => 'required|exists:tents,id',
            'head_name'     => 'required|string|max:255',
            'id_number'     => 'required|digits:9',
            'phone'         => 'nullable|string|max:20',
            'original_area' => 'nullable|string|max:255',
            'current_area'  => 'nullable|string|max:255',
            'family_type'   => 'required|in:normal,female_headed,orphans',
        ],[
            'id_number.required' => 'رقم الهوية مطلوب.',
            'id_number.digits'   => 'عذراً، رقم الهوية يجب أن يتكون من 9 أرقام بالضبط.', 
        ]);

        // 2. تحديث البيانات
        $family->update($request->all());

        // 3. التوجيه
        return redirect()->route('families.index')->with('success', 'تم تعديل بيانات العائلة بنجاح!');
    }

    /**
     * حذف العائلة من قاعدة البيانات
     */
    public function destroy(Family $family)
    {
        $family->delete();
        return redirect()->route('families.index')->with('success', 'تم حذف العائلة بنجاح!');
    }
}

