<?php

namespace App\Http\Controllers;

use App\Models\EmergencyNeed;
use App\Models\Family;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class EmergencyNeedController 
{
    public function index()
    {
        // جلب البيانات مع العائلات والخيام المرتبطة بها
        $needs = EmergencyNeed::with('family.tent')->latest()->get();
        return view('emergency_needs.index', compact('needs'));
    }

    public function create()
    {
        // جلب العائلات لعرضها في قائمة الاختيار
        $families = Family::all();
        return view('emergency_needs.create', compact('families'));
    }

    public function store(Request $request)
    {
       $validator = Validator($request->all(), [
            'family_id' => 'required|exists:families,id',
            'type_of_need' => 'required|string',
            'urgency_level' => 'required|in:critical,high,medium,low', 
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'icon'  => 'error',
                'title' => 'خطأ في البيانات',
                'text'  => $validator->getMessageBag()->first()
            ], 400);
        }

        $need = new EmergencyNeed();
        $need->family_id = $request->input('family_id');
        $need->type_of_need = $request->input('type_of_need');
        $need->urgency_level = $request->input('urgency_level');
        $need->description = $request->input('description');
        $need->status = 'pending';
        $need->reported_by = Auth::id(); 
        
        $isSaved = $need->save();

        return response()->json([
            'icon'  => $isSaved ? 'success' : 'error',
            'title' => $isSaved ? 'رائع' : 'فشل',
            'text'  => $isSaved ? 'تم تسجيل الاحتياج بنجاح' : 'فشلت عملية التسجيل',
        ], $isSaved ? 200 : 400);
    }
    public function edit($id)
{
    $need = EmergencyNeed::findOrFail($id);
    $families = Family::all();
    return view('emergency_needs.edit', compact('need', 'families'));
}
public function update(Request $request, $id)
{
    $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
        'family_id'     => 'required',
        'type_of_need'  => 'required',
        'urgency_level' => 'required',
        'status'        => 'required',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'icon'  => 'error',
            'title' => 'خطأ في البيانات',
            'text'  => $validator->getMessageBag()->first() 
        ], 400);
    }

    try {
        $need = EmergencyNeed::findOrFail($id);
        $need->family_id     = $request->input('family_id');
        $need->type_of_need  = $request->input('type_of_need');
        $need->urgency_level = $request->input('urgency_level');
        $need->status        = $request->input('status');
        $need->description   = $request->input('description');
        
        $isSaved = $need->save();

        return response()->json([
            'icon'  => $isSaved ? 'success' : 'error',
            'title' => $isSaved ? 'رائع' : 'فشل',
            'text'  => $isSaved ? 'تم تحديث البلاغ بنجاح' : 'فشل التحديث'
        ], $isSaved ? 200 : 400);

    } catch (\Exception $e) {
        return response()->json([
            'icon'  => 'error',
            'title' => 'خطأ فني',
            'text'  => 'حدث خطأ أثناء الحفظ: ' . $e->getMessage()
        ], 500);
    }
}
    public function destroy($id)
    {
        $deleted = EmergencyNeed::destroy($id);
        return response()->json([
            'icon' => $deleted ? 'success' : 'error',
            'title' => $deleted ? 'تم الحذف بنجاح' : 'فشل الحذف'
        ], $deleted ? 200 : 400);
    }
}