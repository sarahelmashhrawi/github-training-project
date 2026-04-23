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
        $individuals = Individual::with('family')->get();
        $familyHeads = Family::all();
        return view('individuals.index', compact('individuals', 'familyHeads'));
    }

    public function create(Request $request)
    {
        $family_id = $request->query('family_id');
        $family = Family::findOrFail($family_id);
        return view('individuals.create', compact('family'));
    }

    public function store(Request $request)
    {
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
        ]);

        if ($request->hasFile('medical_attachment')) {
            $path = $request->file('medical_attachment')->store('medical_attachments', 'public');
            $validatedData['medical_attachment'] = $path;
        }

        // معالجة قيم الـ Boolean
        $validatedData['has_disability'] = $request->has('has_disability') ? 1 : 0;
        $validatedData['has_chronic_disease'] = $request->has('has_chronic_disease') ? 1 : 0;
        $validatedData['is_pregnant'] = $request->has('is_pregnant') ? 1 : 0;
        $validatedData['is_breastfeeding'] = $request->has('is_breastfeeding') ? 1 : 0;

        if ($validatedData['gender'] === 'male') {
            $validatedData['is_pregnant'] = 0;
            $validatedData['is_breastfeeding'] = 0;
        }

        Individual::create($validatedData);

        // الاستجابة المطلوبة لملف CRUD.js
        return response()->json([
            'icon'     => 'success',
            'title'    => 'تم الحفظ!',
            'message'  => 'تم إضافة الفرد بنجاح إلى العائلة',
            'redirect' => url('/families/' . $request->family_id) // التحويل التلقائي لصفحة العائلة
        ], 200);
    }

    public function update(Request $request, Individual $individual)
    {
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
        ]);

        if ($request->hasFile('medical_attachment')) {
            if ($individual->medical_attachment) {
                Storage::disk('public')->delete($individual->medical_attachment);
            }
            $path = $request->file('medical_attachment')->store('medical_attachments', 'public');
            $validatedData['medical_attachment'] = $path;
        }

        $validatedData['has_disability'] = $request->has('has_disability') ? 1 : 0;
        $validatedData['has_chronic_disease'] = $request->has('has_chronic_disease') ? 1 : 0;
        $validatedData['is_pregnant'] = $request->has('is_pregnant') ? 1 : 0;
        $validatedData['is_breastfeeding'] = $request->has('is_breastfeeding') ? 1 : 0;

        $individual->update($validatedData);

        return response()->json([
            'icon'     => 'success',
            'title'    => 'تم التعديل!',
            'message'  => 'تم تحديث بيانات الفرد بنجاح',
            'redirect' => url('/families/' . $individual->family_id)
        ], 200);
    }

    public function destroy(Individual $individual)
    {
        if ($individual->medical_attachment) {
            Storage::disk('public')->delete($individual->medical_attachment);
        }
        
        $individual->delete();

        return response()->json([
            'icon'    => 'success',
            'title'   => 'تم الحذف!',
            'message' => 'تم حذف بيانات الفرد نهائياً'
        ], 200);
    }

    public function edit($id)
    {
        $individual = Individual::findOrFail($id);
        return view('individuals.edit', compact('individual'));
    }
}