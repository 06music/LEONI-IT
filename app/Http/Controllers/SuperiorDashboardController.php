<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SuperiorDashboardController extends Controller
{
    public function index(Request $request)
    {
        return Inertia::render('Superior/Dashboard', [
            'total_employees' => 50, // Static example value
            'assigned_equipments' => 200, // Static example value
        ]);
    }
}
