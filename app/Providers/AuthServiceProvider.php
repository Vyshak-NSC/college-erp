<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Course;
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


        // Department
        Gate::define('create-department', function(User $user){
            return $user->role === 'admin';
        });

        Gate::define('view-department', function (User $user, Department $department){
            if($user->role === 'admin'){
                return true;
            }
            return$user->department_id === $department->id;
        });

        Gate::define('edit-department', function (User $user, Department $department) {
            // For now, only 'admin' can edit.
            return $user->role === 'admin';
        });

        // We also need rules for update and delete
        Gate::define('update-department', function (User $user, Department $department) {
            return $user->role === 'admin';
        });

        Gate::define('delete-department', function (User $user, Department $department) {
            return $user->role === 'admin';
        });


        // Course
        Gate::define('create-course', function(User $user){
            return $user->role === 'admin';
        });

        Gate::define('view-course', function (User $user, Course $course){
            if($user->role === 'admin'){
                return true;
            }
            return$user->department_id === $course->id;
        });

        Gate::define('edit-course', function (User $user, Course $course) {
            // For now, only 'admin' can edit.
            return $user->role === 'admin';
        });

        // We also need rules for update and delete
        Gate::define('update-course', function (User $user, Course $course) {
            return $user->role === 'admin';
        });

        Gate::define('delete-course', function (User $user, Course $course) {
            return $user->role === 'admin';
        });
    }
}
