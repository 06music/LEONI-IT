<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\equipment_models;
use Illuminate\Http\Request;

class EquipmentModelController extends Controller
{
    public function index()
    {
        $models = equipment_models::all();
        return inertia('Admin/EquipmentModels/Index', ['models' => $models]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:equipment_models|max:255',
            'description' => 'nullable|string',
        ]);

        equipment_models::create($request->all());

        return redirect()->back()->with('success', 'Equipment Model created successfully.');
    }

    public function destroy(equipment_models $equipmentModel)
    {
        $equipmentModel->delete();
        return redirect()->back()->with('success', 'Equipment Model deleted.');
    }
}
