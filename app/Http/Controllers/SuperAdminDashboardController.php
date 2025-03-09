<?php

namespace App\Http\Controllers;

use App\Models\Computer;
use App\Models\Site;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SuperAdminDashboardController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Dashboard', [
            'totalUsers' => User::count(),
            'totalSites' => Site::count(),
            'totalEquipments' => Computer::count(),
            'recentComputers' => Computer::latest()->take(5)->get(),
        ]);
    }
}
