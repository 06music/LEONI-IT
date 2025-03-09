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
            ->orderBy('assigned_at', 'desc')
            ->get();

        $users = User::select('id', 'name', 'email', 'role', 'site_id')->get();
        $equipment_types = equipment_types::select('id', 'name')->get();
        $computers = Computer::select('id', 'computer_name', 'model', 'serial_number', 'site_id')->get();

        return Inertia::render('Manager/EquipmentAssignments/Index', [
            'assignments' => $assignments,
            'users' => $users,
            'equipment_types' => $equipment_types,
            'computers' => $computers
        ]);
    }
    public function create() {
        $users = User::where('role', 'employee')->get();
        $equipments = Equipment::where('status', 'available')->get();

        return Inertia::render('Manager/EquipmentAssignments/Create', [
            'users' => $users,
            'equipments' => $equipments
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
}
