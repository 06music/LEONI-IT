<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\equipment_reasons;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EquipmentReasonController extends Controller
{

    public function index()
    {
        $reasons = equipment_reasons::all();
        return Inertia::render('Admin/EquipmentReasons/Index', ['reasons' => $reasons]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'reason_type' => 'required|in:assignment,return',
            'description' => 'nullable|string',
        ]);

        equipment_reasons::create($validated);

        return redirect()->back()->with('success', 'Equipment Reason created successfully.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, equipment_reasons $equipmentReason)
    {
        $validated = $request->validate([
            'reason_type' => 'required|in:assignment,return',
            'description' => 'nullable|string',
        ]);

        $equipmentReason->update($validated);

        return redirect()->back()->with('success', 'Equipment Reason updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(equipment_reasons $equipmentReason)
    {
        $equipmentReason->delete();
        return redirect()->back()->with('success', 'Equipment Reason deleted.');
    }
}
