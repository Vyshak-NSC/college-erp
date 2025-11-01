<?php

namespace App\Providers;

use App\Models\Staff;
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


        // ---------- Department ----------
        Gate::define('create-department', function(User $user){
            return $user->role === 'admin';
        });

        Gate::define('view-department', function (User $user, Department $department){
            if($user->role === 'admin'){
                return true;
            }
            return $user->department_id === $department->id;
        });

        Gate::define('edit-department', function (User $user, Department $department) {
            return $user->role === 'admin';
        });

        Gate::define('update-department', function (User $user, Department $department) {
            return $user->role === 'admin';
        });

        Gate::define('delete-department', function (User $user, Department $department) {
            return $user->role === 'admin';
        });


        // ---------- Course ----------
        Gate::define('create-course', function(User $user){
            return $user->role === 'admin';
        });

        Gate::define('view-course', function (User $user, Course $course){
            if($user->role === 'admin'){
                return true;
            }
            return $user->department_id === $course->department_id;
        });

        Gate::define('edit-course', function (User $user, Course $course) {
            return $user->role === 'admin';
        });

        Gate::define('update-course', function (User $user, Course $course) {
            return $user->role === 'admin';
        });

        Gate::define('delete-course', function (User $user, Course $course) {
            return $user->role === 'admin';
        });


        // ---------- Staff ----------
        Gate::define('create-staff', function(User $user){
            return $user->role === 'admin';
        });

        Gate::define('view-staff', function (User $user, Staff $staff){
            if($user->role === 'admin'){
                return true;
            }
            return $user->department_id === $staff->department_id;
        });

        Gate::define('edit-staff', function (User $user, Staff $staff) {
            return $user->role === 'admin';
        });

        Gate::define('update-staff', function (User $user, Staff $staff) {
            return $user->role === 'admin';
        });

        Gate::define('delete-staff', function (User $user, Staff $staff) {
            return $user->role === 'admin';
        });
    }
}
