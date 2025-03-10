<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Computer;
use App\Models\Equipment;
use App\Models\equipment_types;
use App\Models\EquipmentAssignment;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EquipmentAssignmentController extends Controller
{
    public function index() {
        $assignments = EquipmentAssignment::with(['user', 'equipment'])
            ->latest('assigned_at')
            ->get();

        $users = User::select('id', 'name', 'email', 'role', 'site_id')->get();
        $equipment_types = equipment_types::select('id', 'name')->get(); // Fixed Model Name
        $computers = Computer::select('id', 'computer_name', 'model', 'serial_number', 'site_id')->get();

        return Inertia::render('Manager/EquipmentAssignments/Index', [
            'assignments' => $assignments,
            'users' => $users,
            'equipment_types' => $equipment_types,
            'computers' => $computers
        ]);
    }

    public function store(Request $request) {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'equipment_id' => 'required|exists:equipments,id',
        ]);

        EquipmentAssignment::create([
            'user_id' => $request->user_id,
            'equipment_id' => $request->equipment_id,
            'assigned_by' => auth()->id(),
            'assigned_at' => now(),
            'status' => 'assigned'
        ]);

        return redirect()->route('manager.assign_equipment')->with('success', 'Equipment assigned successfully.');
    }

    public function edit($id) {
        $assignment = EquipmentAssignment::findOrFail($id);
        $users = User::select('id', 'name')->get();
        $equipments = Equipment::select('id', 'name')->get();

        return Inertia::render('Manager/EquipmentAssignments/Edit', [
            'assignment' => $assignment,
            'users' => $users,
            'equipments' => $equipments
        ]);
    }

    public function update(Request $request, $id) {
        $assignment = EquipmentAssignment::findOrFail($id);

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'equipment_id' => 'required|exists:equipments,id',
        ]);

        $assignment->update([
            'user_id' => $request->user_id,
            'equipment_id' => $request->equipment_id,
            'status' => $request->status,
            'returned_at' => $request->status === 'returned' ? now() : null
        ]);

        return redirect()->route('manager.assign_equipment')->with('success', 'Equipment assignment updated.');
    }

    public function destroy($id) {
        $assignment = EquipmentAssignment::findOrFail($id);
        $assignment->delete();

        return redirect()->route('manager.assign_equipment')->with('success', 'Equipment assignment deleted.');
    }
}
