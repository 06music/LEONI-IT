<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ManagerDashboardController extends Controller
{
    public function index(Request $request)
    {
        return Inertia::render('Manager/Dashboard', [
            'site' => [
                'id' => 1,
                'name' => 'Example Site', // Static site name
            ],
            'total_users' => 30, // Static example value
            'total_equipments' => 150, // Static example value
        ]);
    }
}
