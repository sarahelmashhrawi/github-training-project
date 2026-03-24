<?php

namespace App\Http\Controllers;

use App\Models\EmergencyNeed;
use App\Models\Tent;
use Illuminate\Http\Request;

class EmergencyNeedController 
{
    public function index() {
        $needs = EmergencyNeed::with('tent')->latest()->get();
        return view('emergency_needs.index', compact('needs'));
    }

    public function create() {
        $tents = Tent::all(); 
        return view('emergency_needs.create', compact('tents'));
    }

    public function store(Request $request) {
        $data = $request->validate([
            'item_name'     => 'required|string|max:255',
            'quantity'      => 'required|integer|min:1',
            'urgency_level' => 'required|in:low,medium,high,critical',
            'tent_id'       => 'required|exists:tents,id',
        ]);

        EmergencyNeed::create($data);
        return redirect()->route('emergency-needs.index')->with('success', 'تم تسجيل الاحتياج بنجاح');
    }

    public function edit(EmergencyNeed $emergencyNeed) {
        $tents = Tent::all();
        return view('emergency_needs.edit', compact('emergencyNeed', 'tents'));
    }

    public function update(Request $request, EmergencyNeed $emergencyNeed) {
        $data = $request->validate([
            'item_name'     => 'required|string|max:255',
            'quantity'      => 'required|integer|min:1',
            'urgency_level' => 'required|string',
            'tent_id'       => 'required|exists:tents,id',
        ]);

        $emergencyNeed->update($data);
        return redirect()->route('emergency-needs.index')->with('success', 'تم تحديث البيانات');
    }

    public function destroy(EmergencyNeed $emergencyNeed) {
        $emergencyNeed->delete();
        return redirect()->route('emergency-needs.index')->with('success', 'تم حذف الطلب');
    }
}