<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use Illuminate\Http\Request;

class CampaignController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $campaigns = \App\Models\Campaign::all();
    return view('campaigns.index', compact('campaigns'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('campaigns.create');
    }

    /**
     * Store a newly created resource in storage.
     */
   public function store(Request $request)
{
   $data = $request->validate([
    'title'           => 'required|string|max:255',
    'location'        => 'required|string',
    'target_families' => 'required|integer',
    'total_capacity'  => 'required|integer',
    'start_date'      => 'required|date',
    'status'          => 'required|in:0,1', // 1 لمتاح و 0 لممتلئ
    'description'     => 'nullable|string',
    'end_date' => 'nullable|date',
]);
    \App\Models\Campaign::create($data);

    return redirect()->route('campaigns.index')->with('success', 'تم إضافة الحملة بنجاح');
}
   
    /**
     * Display the specified resource.
     */
    public function show(Campaign $campaign)
    {
          return view('campaigns.show', compact('campaign'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Campaign $campaign)
    {
         return view('campaigns.edit', compact('campaign'));
    }

    /**
     * Update the specified resource in storage.
     */
   public function update(Request $request, Campaign $campaign)
{
    $data = $request->validate([
        'title'           => 'required|string',
        'location'        => 'required|string',
        'target_families' => 'required|integer',
        'total_capacity'  => 'required|integer',
        'start_date'      => 'required|date',
        'end_date'        => 'nullable|date',
        'status'          => 'required|in:available,full', 
        'description'     => 'nullable|string',
    ]);

    $campaign->update($data); // هذا السطر هو المسؤول عن الحفظ

    return redirect()->route('campaigns.index')->with('success', 'تم تعديل الحملة بنجاح');
}
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Campaign $campaign)
    {
         $campaign->delete();
        return redirect()->route('campaigns.index')->with('success', 'تم الحذف بنجاح');
    }
}
