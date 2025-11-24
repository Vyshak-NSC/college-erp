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
    $user = Auth::user();
    $role = $user->role;
    if($user->isStudent()){
        $sem = $user->student->semester;
        $student = $user->load(['student.program.department','student.courses' => fn($q) => $q->where('semester',$sem)]);    
        return view('dashboard', compact('role','student'));
    }
    elseif($user->isStaff()){
        $id = $user->staff->id;
        $staff = $user->staff->load(['courses' => fn($q) => $q->where('staff_id',$id)]);    
        return view('dashboard', compact('role','staff'));
    }
    else{
        $admin = $user;
        $users = User::all();
        return view('dashboard', compact('role','admin','users'));
    }
})->middleware(['auth'])->name('dashboard');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // view
    Route::get('/departments', [DepartmentController::class, 'index'])->name('departments.index');
    Route::get('/departments/{department}', [DepartmentController::class, 'show'])->name('departments.show');

    Route::get('/staff', [StaffController::class, 'index'])->name('staff.index');
    Route::get('/staff/{staff}', [StaffController::class, 'show'])->name('staff.show');

    });

// role:admin middleware applicable
Route::middleware(['auth','admin'])->group(function(){
    Route::resource('departments', DepartmentController::class)
            ->except(['index','show']);
    Route::resource('courses', CourseController::class);
    
    Route::get('staff/{staff}/assign-course', [StaffController::class,'assignCourse'])
            ->name('staff.assign-course');
    Route::post('staff/set-course', [StaffController::class,'setCourse'])
            ->name('staff.set-course');
    Route::get('staff/{staff}/edit-course/{course}', [StaffController::class,'editCourse'])
            ->name('staff.edit-course');
    Route::put('staff/update-course/{staff}/{course}', [StaffController::class,'updateCourse'])
            ->name('staff.update-course');
    Route::delete('staff/{staff}/destroy-course/{course}', [StaffController::class,'destroyCourse'])
            ->name('staff.destroy-course');
    
    Route::resource('staff', StaffController::class)
            ->except(['index','show']);
    Route::resource('programs', ProgramController::class);
    Route::resource('students', StudentController::class)->whereNumber('student');
    Route::delete('/students/bulk-delete', [StudentController::class, 'bulkDelete'])->name('students.bulk-delete');

});




require __DIR__.'/auth.php';
