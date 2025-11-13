<?php

namespace App\Providers;

use App\Models\Student;
use App\Models\User;
use App\Models\Staff;
use App\Models\Course;
use App\Models\Program;
use App\Models\Department;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Gate::define('access-admin-panel', function (User $user){
            return $user->role === 'admin';
        });

        // ---------- Department ----------
        Gate::define('view-department'  ,fn () => true);
        Gate::define('create-department',fn (User $user) => $user->role === 'admin');
        Gate::define('edit-department'  ,fn (User $user) => $user->role === 'admin');
        Gate::define('update-department',fn (User $user) => $user->role === 'admin');
        Gate::define('delete-department',fn (User $user) => $user->role === 'admin');

        // ---------- Program ----------
        Gate::define('view-program'  ,fn () => true);
        Gate::define('create-program',fn (User $user, $dept_id) => $user->role === 'admin' || 
                ($user->role === 'staff' && 
                $user->staff->department_id == $dept_id &&
                $user->staff?->designation ==='hod')
            );
        Gate::define('edit-program'  , fn (User $user, Program $program)=> $user->role === 'admin' ||
                ($user->role === 'staff' &&
                $user->staff?->department_id === $program->department_id &&
                $user->staff->designation === 'hod')
            );
        Gate::define('update-program',fn (User $user, Program $program) => $user->role === 'admin' || 
                ($user->role == 'staff' &&
                $user->staff->designation === 'hod' &&
                $user->staff->department_id === $program->department_id)
            );
        Gate::define('delete-program',fn (User $user, Program $program)=> $user->role === 'admin' ||
                ($user->role === 'staff' &&
                $user->staff->designation === 'hod' &&
                $user->staff->department_id === $program->department_id)
            );


        // ---------- Course ----------
        Gate::define('view-course', fn () => true);
        Gate::define('create-course', fn(User $user, $dept_id)=> $user->role === 'admin' || 
                ($user->role === 'staff' &&
                $user->staff->designation === 'hod' &&
                $user->staff->department_id === $dept_id)
            );
        Gate::define('edit-course', fn (User $user, Course $course) => $user->role === 'admin' || 
                ($user->role === 'staff' &&
                $user->staff->designation === 'hod' &&
                $user->staff->department_id === $course->program->department_id)
            );
        Gate::define('update-course', fn (User $user, Course $course) => $user->role === 'admin'|| 
                ($user->role === 'staff' &&
                $user->staff->designation === 'hod' &&
                $user->staff->department_id === $course->program->department_id)
            );
        Gate::define('delete-course', fn (User $user, Course $course) => $user->role === 'admin' || 
                ($user->role === 'staff' &&
                $user->staff->designation === 'hod' &&
                $user->staff->department_id === $course->program->department_id)
            );


        // ---------- Staff ----------
        Gate::define('view-staff', fn () => true);
        Gate::define('create-staff', fn(User $user, $dept_id=null): bool =>  $user->role === 'admin' || 
                ($dept_id && $user->role === 'staff' &&
                $user->staff?->designation === 'hod' &&
                $user->staff->department_id === $dept_id)
            );
        Gate::define('edit-staff', fn (User $user, Staff $staff) => $user->role === 'admin' ||
                ($user->role === 'staff' &&
                $user->id === $staff->user_id) ||
                ($user->staff?->designation === 'hod' &&
                $user->staff->department_id === $staff->department_id)
            );
        Gate::define('update-staff', fn (User $user, Staff $staff) => $user->role === 'admin' || 
                ($user->role === 'staff' &&
                $user->staff?->designation === 'hod' &&
                $user->staff->department_id === $staff->department_id)
            );
        Gate::define('delete-staff', fn (User $user, Staff $staff) => $user->role === 'admin' || 
                ($user->role === 'staff' &&
                $user->staff?->designation === 'hod' &&
                $user->staff->department_id === $staff->department_id)
            );


        // ---------- Student ----------
        Gate::define('view-student', fn (User $user, Student $student=null) => 
                $user->role === 'admin' || 
                ($student &&
                $user->id === $student->user_id ||
                ($user->role === 'staff' && 
                in_array($user->staff->designation, ['hod','professor','asst. professor']) &&
                $user->staff->department_id === $student->department_id))
            );
        Gate::define('create-student', fn(User $user) => $user->role === 'admin');

        Gate::define('edit-student', fn (User $user, Student $student) => 
                $user->role === 'admin' || 
                $user->id === $student->user_id ||  
                ($user->role === 'staff' &&
                $user->staff->designation === 'hod' &&
                $user->staff->department_id === $student->department_id)
            );
        Gate::define('update-student', fn (User $user, Student $student) => 
                $user->role === 'admin' || 
                $user->id === $student->user_id ||  
                ($user->role === 'staff' &&
                $user->staff->designation === 'hod' &&
                $user->staff->department_id === $student->department_id));
        Gate::define('delete-student', fn (User $user) =>$user->role === 'admin');
    }
}
