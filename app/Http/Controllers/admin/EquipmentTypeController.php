<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\equipment_types;
use Illuminate\Http\Request;

class EquipmentTypeController extends Controller
{
    public function index()
    {
        $types = equipment_types::all();
        return inertia('Admin/EquipmentTypes/Index', ['types' => $types]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:equipment_types|max:255',
            'description' => 'nullable|string',
        ]);

        equipment_types::create($request->all());

        return redirect()->back()->with('success', 'Equipment Type created successfully.');
    }

    public function destroy(equipment_types $equipmentType)
    {
        $equipmentType->delete();
        return redirect()->back()->with('success', 'Equipment Type deleted.');
    }
}
