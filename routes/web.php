<?php

use App\Http\Controllers\Admin\SiteController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\ManagerDashboardController;
use App\Http\Controllers\SuperiorDashboardController;
use App\Http\Controllers\EmployeeDashboardController;
use App\Http\Controllers\SuperAdminDashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

}); // Super Admin Routes
Route::prefix('admin')->middleware(['role:super_admin'])->group(function () {
    Route::get('/dashboard', [SuperAdminDashboardController::class, 'index'])->name('dashboard.super_admin');
    Route::resource('sites', SiteController::class);
    Route::resource('users', UserController::class);


});

// Manager Routes
Route::prefix('manager')->middleware(['role:manager'])->group(function () {
    Route::get('/dashboard', [ManagerDashboardController::class, 'index'])->name('dashboard.manager');
  //  Route::post('/assign-equipment', [EquipmentController::class, 'assign'])->name('equipment.assign');
});

// Employee Routes
Route::prefix('employee')->middleware(['role:employee'])->group(function () {
    Route::get('/dashboard', [EmployeeDashboardController::class, 'index'])->name('dashboard.employee');
  //  Route::get('/my-equipments', [EquipmentController::class, 'myEquipments'])->name('equipment.my');
});

// Superior Hierarchique Routes
Route::prefix('superior')->middleware(['role:superior_hierarchique'])->group(function () {
    Route::get('/dashboard', [SuperiorDashboardController::class, 'index'])->name('dashboard.superior');
   // Route::get('/equipments', [EquipmentController::class, 'employeesEquipments'])->name('equipment.superior');
});

require __DIR__.'/auth.php';
