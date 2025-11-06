<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\AjaxController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $users = User::all();
    return view('dashboard', compact('users'));
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->group(function() {
    Route::resource('departments', DepartmentController::class);
    Route::resource('courses', CourseController::class);
    Route::get('staffs/{staff}/assign-course', [StaffController::class,'assignCourse'])->name('staffs.assign-course');
    Route::post('staffs/set-course', [StaffController::class,'setCourse'])->name('staffs.set-course');
    Route::get('staffs/{staff}/edit-course', [StaffController::class,'editCourse'])->name('staffs.edit-course');
    Route::delete('staffs/{staff}/destroy-course/{course}', [StaffController::class,'destroyCourse'])->name('staffs.destroy-course');
    Route::resource('staffs', StaffController::class);
    Route::resource('programs', ProgramController::class);
});

require __DIR__.'/auth.php';
