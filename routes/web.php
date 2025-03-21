<?php

use App\Http\Controllers\User\BulkUserEntitiesController;
use App\Http\Controllers\User\UserRoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    Route::get('/about', fn () => Inertia::render('About'))->name('about');

    Route::get('users', [UserController::class, 'index'])->name('users.index');
    Route::get('alumnos', [UserController::class, 'alumnosIndex'])->name('alumnos.index');

// Vista principal donde se muestra el componente de asignación masiva
    Route::get('/bulk-roles', [BulkUserEntitiesController::class, 'edit'])->name('bulk.roles.edit');

// Rutas para asignar o quitar roles parcialmente
    Route::post('/bulk-roles/assign-partial', [BulkUserEntitiesController::class, 'assignPartial'])->name('bulk.roles.assignPartial');
    Route::post('/bulk-roles/remove-partial', [BulkUserEntitiesController::class, 'removePartial'])->name('bulk.roles.removePartial');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
