<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Models\Receiving;
use App\Models\Family;
use App\Models\Inventory;
use App\Models\Campaign;
use Illuminate\Support\Facades\Auth;

class ReceivingController 
{
    public function index() {
        // بجلب البيانات مع علاقاتها      
        $receivings = Receiving::with(['family', 'inventory', 'campaign'])->latest()->get();
        return view('receivings.index', compact('receivings'));
    }

    public function create() {
       $families = Family::all();
        $inventories = Inventory::where('quantity_available', '>', 0)->get();
        $campaigns = Campaign::all();
        return view('receivings.create', compact('families', 'inventories', 'campaigns'));
    }

    public function store(Request $request) {
        $data = $request->validate([
            'family_id'         => 'required|exists:families,id',
            'inventory_id'      => 'required|exists:inventories,id',
            'quantity_received' => 'required|integer|min:1',
            'campaign_id'       => 'required|exists:campaigns,id',
        ]);

        $data['user_id'] = Auth::id();

        // تسجيل الاستلام
        Receiving::create($data);

        // تحديث المخزن تلقائياً
        Inventory::find($request->inventory_id)->decrement('available_quantity', $request->quantity_received);

        return redirect()->route('receivings.index')->with('success', 'تم تسجيل الاستلام وتحديث المخزن');
    }

    public function destroy(Receiving $receiving) {
        // لو حذفنا عملية استلام، لازم نرجع الكمية للمخزن 
        Inventory::find($receiving->inventory_id)->increment('available_quantity', $receiving->quantity_received);
        
        $receiving->delete();
        return redirect()->route('receivings.index')->with('success', 'تم إلغاء الاستلام وإرجاع الكمية للمخزن');
    }
    
}
