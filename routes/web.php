<?php

use App\Http\Controllers\FolderController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\PasswordEntryController;
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

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/dashboard', [PagesController::class, 'dashboard'])->name('dashboard');

    Route::delete('/folders/{folder}/destroy', [FolderController::class, 'destroy'])->name('folders.destroy');
    Route::get('/folders/{folder}', [FolderController::class, 'show'])->name('folders.show');
    Route::post('/folders/store', [FolderController::class, 'store'])->name('folders.store');

    Route::post('/password-entries//move', [PasswordEntryController::class, 'move'])->name('password-entries.move');
    Route::post('/password-entries/{entryId}/get-entry', [PasswordEntryController::class, 'getEntry'])->name('password-entries.get-entry');
    Route::delete('/password-entries/{passwordEntry}/destroy', [PasswordEntryController::class, 'destroy'])->name('password-entries.destroy');
    Route::post('/password-entries/{passwordEntry}/get-password', [PasswordEntryController::class, 'getPassword'])->name('password-entries.get-password');
    Route::put('/password-entries/{passwordEntry}/update', [PasswordEntryController::class, 'update'])->name('password-entries.update');
    Route::get('/password-entries/{passwordEntry}', [PasswordEntryController::class, 'show'])->name('password-entries.show');
    Route::post('/password-entries/store', [PasswordEntryController::class, 'store'])->name('password-entries.store');
});

require __DIR__ . '/auth.php';
