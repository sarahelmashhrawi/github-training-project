<?php

namespace App\Http\Controllers;

use App\Models\Sector;
use App\Models\User;

use Illuminate\Http\Request;

class SectorController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sectors = Sector::orderBy('id', 'desc')->withoutTrashed()->simplePaginate(10);
        
        return response()->view('sectors.index', compact('sectors'));
    }
    

    /**
     * Show the form for creating a new resource.
     */
   public function create()
{
   // جلب كل المستخدمين الذين نريدهم أن يظهروا كمشرفين
    $users = \App\Models\User::all(); 

    // فتح الواجهة وإرسال المتغير لها
    return view('sectors.create', compact('users'));
}

    /**
     * Store a newly created resource in storage.
     */
    
public function store(Request $request) {
    $request->validate(['name' => 'required']);
    Sector::create($request->all());
    return redirect()->route('sectors.index')->with('success', 'تمت الإضافة!');
}
    /**
     * Display the specified resource.
     */
    public function show(Sector $sector)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */

public function edit(Sector $sector)
{
            $users = \App\Models\User::all(); 
    
    return view('sectors.edit', compact('sector', 'users'));
}


public function update(Request $request, Sector $sector)
{
   // 1. التحقق من البيانات
    $request->validate([
        'name' => 'required|string|max:255',
        'location' => 'nullable|string',
        'supervisor_id' => 'required|exists:users,id',
    ]);

    // 2. تحديث البيانات في قاعدة البيانات
    $sector->update($request->all());

    // 3. إعادة التوجيه لصفحة العرض مع رسالة نجاح خضراء
    return redirect()->route('sectors.index')->with('success', 'تم تحديث بيانات المنطقة بنجاح!');
}
    /**
     * Remove the specified resource from storage.
     */
  public function destroy(Sector $sector)
{
    try {
        // محاولة حذف المنطقة
        $deleted = $sector->delete();
        
        if ($deleted) {
            return response()->json([
                'icon' => 'success',
                'title' => 'تم حذف المنطقة بنجاح'
            ], 200);
        } else {
            return response()->json([
                'icon' => 'error',
                'title' => 'فشل الحذف'
            ], 400);
        }
    } catch (\Exception $e) {
        // التقاط أي خطأ من قاعدة البيانات (مثل وجود بيانات مرتبطة بالمنطقة)
        return response()->json([
            'icon' => 'error',
            'title' => 'لا يمكن حذف المنطقة لوجود بيانات مرتبطة بها'
        ], 400);
    }
}

    public function trashed()
    {
        $sectors = Sector::onlyTrashed()->orderBy('id', 'desc')->simplePaginate(10);
        
        return response()->view('sectors.trashed', compact('sectors'));
    }

  
    public function restore($id)
    {
        $sector = Sector::onlyTrashed()->findOrFail($id)->restore();
        
        
        return back()->with('success', 'تم استرجاع المنطقة بنجاح');
    }
        public function force($id)
    {
        $sector = Sector::onlyTrashed()->findOrFail($id)->forceDelete();
        
        
        return back()->with('success', 'تم حذف المنطقة نهائيا');
    }
}