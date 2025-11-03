<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Staff;
use App\Models\User;
use Hash;
use Illuminate\Http\Request;
use Throwable;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $staffs = Staff::all();
        $departments = Department::get(['name','id']);
        return view('staffs.index',compact('staffs','departments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $departments = Department::with('programs')->get(['name','id']);
        return view('staffs.create', compact('departments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create-staff');
        try{
            $validated = $request->validate([
                // User
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:8|confirmed',

                'department_id'=>'required|exists:departments,id',
                'employee_id'=>'required|string|unique:staff,employee_id',
                'designation'=>'nullable|string',
                'hire_date' => 'nullable|date'
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
            
        }catch(Throwable $e){
            return redirect()->back()
                ->withInput()
                ->with('error','Failed to add staff.');
        }

        $origin = $request->input('_origin') ?? '';
            
        if($origin==='department'){
            return redirect()->route('departments.show',['department'=>$validated['department_id'], 
                'tab'=>'staff'])->with('success', 'Staff added successfully');
        }
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
            'name'=>'nullable|string|max:30',
            'designation'=>'nullable|string|max:30',
            'employee_id' => 'nullable|string|max:10',
            'hire_date'=> 'nullable|date',
            'department_id'=>'nullable|integer|exists:departments,id'
        ]);
        $staff->user->update([
            'name'=>$validated['name']
        ]);
        $staff->update([
            'designation'=> $validated['designation'],
            'department_id'=> $validated['department_id'],
            'employee_id'=> $validated['employee_id'],
            'hire_date' => $validated['hire_date']
        ]);
        return redirect()->route('staffs.index')
                         ->with('success','Staff updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Staff $staff)
    {
        $this->authorize('delete-staff',$staff);
        $staff->delete();

        return redirect()->route('staffs.index')
                         ->with('success','Staff deleted successfully');
    }
}
