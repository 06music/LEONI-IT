<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class EmployeeDashboardController extends Controller
{
    public function index(Request $request)
    {
        return Inertia::render('Employee/Dashboard', [
            'equipments' => [
                [
                    'id' => 1,
                    'name' => 'Laptop',
                    'model' => 'Dell XPS 13',
                ],
                [
                    'id' => 2,
                    'name' => 'Monitor',
                    'model' => 'LG UltraWide',
                ]
            ], // Static example values
        ]);
    }
}
