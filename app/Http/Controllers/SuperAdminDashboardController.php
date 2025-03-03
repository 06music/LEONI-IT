<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SuperAdminDashboardController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Dashboard', [
            'total_users' => 100, // Example static value
            'total_sites' => 10,  // Example static value
            'total_equipments' => 500, // Example static value
        ]);
    }
}
