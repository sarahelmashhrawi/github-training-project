<?php

namespace App\Http\Controllers;

use App\Models\Sector;
use Illuminate\Http\Request;

class SectorController
{
    /**
     * Display a listing of the resource.
     */
    
       public function index()
    {
  
        $sectors = \App\Models\Sector::all();
        
        return view('sectors.index', compact('sectors'));
    }
    

    /**
     * Show the form for creating a new resource.
     */
   public function create()
{
    $users = \App\Models\User::where('role', 'sector_supervisor')->get(); 
        
    return view('sectors.create', compact('users'));
}

    /**
     * Store a newly created resource in storage.
     */
    
public function store(Request $request) {
    $request->validate(['name' => 'required']);
    \App\Models\Sector::create($request->all());
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
             $users = \App\Models\User::where('role', 'sector_supervisor')->get();
             return view('sectors.edit', compact('sector', 'users'));
}


public function update(Request $request, Sector $sector)
{
    $request->validate(['name' => 'required']);
    $sector->update($request->all());
    return redirect()->route('sectors.index')->with('success', 'تم تحديث بيانات المنطقة');
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
            // إرجاع رد بصيغة JSON ليفهمه الجافاسكربت في crud.js
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
}}