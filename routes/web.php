<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\StudentController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    $users = User::all();
    return view('dashboard', compact('users'));
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// role:admin middleware applicable
Route::middleware(['auth'])->group(function(){
    Route::resource('departments', DepartmentController::class);
    Route::resource('courses', CourseController::class);
    
    Route::get('staff/{staff}/assign-course', [StaffController::class,'assignCourse'])->name('staff.assign-course');
    Route::post('staff/set-course', [StaffController::class,'setCourse'])->name('staff.set-course');
    Route::get('staff/{staff}/edit-course/{course}', [StaffController::class,'editCourse'])->name('staff.edit-course');
    Route::put('staff/update-course/{staff}/{course}', [StaffController::class,'updateCourse'])->name('staff.update-course');
    Route::delete('staff/{staff}/destroy-course/{course}', [StaffController::class,'destroyCourse'])->name('staff.destroy-course');
    
    Route::resource('staff', StaffController::class);
    Route::resource('programs', ProgramController::class);
    Route::resource('students', StudentController::class);
});



require __DIR__.'/auth.php';
