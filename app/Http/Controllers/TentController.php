<?php

namespace App\Http\Controllers;

// استدعاء الكلاس الأساسي بشكل مباشر
use Illuminate\Routing\Controller as BaseController;
use App\Models\Tent;
use App\Models\Sector;
use App\Models\Camp;

use Illuminate\Http\Request;

class TentController extends BaseController
{
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
    $camps = \App\Models\Camp::all(); 
    $sectors = \App\Models\Sector::all(); 

    return view('tents.create', compact('camps', 'sectors'));
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
        $camps = Camp::all(); 
    return view('tents.edit', compact('tent', 'sectors', 'camps'));
        }

    /**
     * تحديث بيانات الخيمة
     */
 
    public function store(Request $request)
    {
        $request->validate([
            'sector_id' => 'required',
            'tent_number' => ['required', 'regex:/^[A-Z]+-[0-9]+$/', 'unique:tents,tent_number'],
           'condition' => 'required',
        'capacity' => 'required|integer|min:1|max:20', 
        'camp_id' => 'required|exists:camps,id',

            ], [
                
            'tent_number.regex' => 'تنسيق رقم الخيمة خاطئ! (مثال: T-11)',
            'tent_number.unique' => 'رقم هذه الخيمة مسجل مسبقاً!',
            'capacity.max' => 'أقصى سعة مسموحة هي 20 فرداً!' 
        ]);

      Tent::create($request->all());

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