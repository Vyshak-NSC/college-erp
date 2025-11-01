<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Staff;
use App\Models\User;
use Hash;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $staffs = Staff::all();
        return view('staffs.index',compact('staffs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('staffs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create-staff');
        
        $validated = $request->validate([
            // User
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',

            'department_id'=>'required|exists:departments,id',
            'employee_id'=>'required|string|unique:staff,employee_id',
            'designation'=>'nullable|string',
            'hire_date' => 'nulllable|date'
        ]);

        $user = User::create([
            'name'=> $validated['name'],
            'email'=>$validated['email'],
            'password'=>Hash::make($validated['password']),
            'role'=>'staff'
        ]);

        $user->staff()->create([
            'department_id'=>$validated['department_id'],
            'employee_id'=>$validated['employee_id'],
            'designation'=>$validated['designation'],
            'hire_date'=>$validated['hire_date']
        ]);

        return redirect()->route('staffs.index')
                         ->with('success', 'Staff added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Staff $staff)
    {
        return view('staffs.show', compact('staff'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Staff $staff)
    {
        $this->authorize('edit-staff', $staff);
        $departments = Department::get(['name','id']);
        return view('staffs.edit',compact('staff','departments'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Staff $staff)
    {
        
        $this->authorize('update-staff',$staff);
        $validated = $request->validate([
            'name'=>'string|max:30',
            'designation'=>'nullable|string|max:30',
            'department_id'=>'nullable|integer|exists:departments,id'
        ]);
        $staff->update($validated);
        return redirect()->route('staffs.index')
                         ->with('success','Staff updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Staff $staff)
    {
        $this->authorize('delete-staff',$staff);
    }
}
