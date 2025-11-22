<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Staff;
use App\Models\Course;
use App\Models\Department;
use Hash;
use Illuminate\Http\Request;
use Throwable;
use Illuminate\Support\Facades\DB;


class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $staffs = Staff::all();
        $departments = Department::with('programs.courses')->get(['name','id']);
        return view('staff.index',compact('staffs','departments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $departments = Department::with('programs.courses')->get(['name','id']);
        return view('staff.create', compact('departments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $dept_id = (int)request('department_id');

        $this->authorize('create-staff', $dept_id);
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
        DB::transaction(function () use($validated){
            $user = User::create([
                'name'=> $validated['name'],
                'email'=>$validated['email'],
                'password'=>Hash::make($validated['password']),
                'role'=>'staff'
            ]);

            $user->staff()->create([
                'department_id'=>$validated['department_id'],
                'employee_id'=>$validated['employee_id'],
                'designation'=>$validated['designation']??null,
                'hire_date'=>$validated['hire_date']??null
            ]);
        });
         
        if(request('origin')==='department'){
            return redirect()->route('departments.show',[
                'department'=>$validated['department_id'], 
                'tab'=>'staff'
            ])->with('success', 'Staff added successfully');
        }
        return redirect()->route('staff.index')
            ->with('success', 'Staff added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Staff $staff)
    {
        $department = $staff->department;
        $this->authorize('view-staff');
        return view('staff.show', compact('staff', 'department'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Staff $staff)
    {
        $this->authorize('edit-staff', $staff);
        $departments = Department::with('programs.courses')->get(['name','id']);
        return view('staff.edit',compact('staff','departments'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Staff $staff)
    {
        // dd($request->all());
        $this->authorize('update-staff',$staff);
        $validated = $request->validate([
            'name'=>'nullable|string|max:30',
            'email'=>'nullable|email|max:30',
            'designation'=>'nullable|string|max:30',
            'employee_id' => 'nullable|string|max:10',
            'hire_date'=> 'nullable|date',
            'department_id'=>'nullable|integer|exists:departments,id'
        ]);
        $staff->user->update([
            'name'=>$validated['name'],
            'email'=>$validated['email']
        ]);
        $staff->update([
            'designation'=> $validated['designation'],
            'department_id'=> $validated['department_id'] ?? null,
            'employee_id'=> $validated['employee_id'],
            'hire_date' => $validated['hire_date'] ?? null
        ]);

        if(request('origin')==='department'){
            return redirect()->route('departments.show',[
                                    'department'=>$validated['department_id'],
                                    'tab'=>'staff'
            ])->with('success','Staff updated successfully');
        }
        return redirect()->route('staff.index')
                         ->with('success','Staff updated successfully');
    }



    /**
     * Show orm for assigning course to staff
     */
    public function assignCourse(Staff $staff){
        $departments = Department::with('programs.courses')->get(['name','id']);
        return view('staff.assign-course', compact('staff','departments'));
    }

    /**
     * Add teh assigned course and staff to table
     */
    public function setCourse(Request $request){
        // dd($request->all());
        $validated = $request->validate([
            'staff_id'=>'required|integer|exists:staff,id',
            'course_id' => 'required|exists:courses,id'
        ]);

        $staff = Staff::find($request->staff_id);
        $staff->courses()->syncWithoutDetaching([$request->course_id]);

        if(request('origin')==='department'){
            return redirect()->route('departments.show',[
                                    'department'=>$validated['department_id'],
                                    'tab'=>'staff'
            ])->with('success','Course assigned successfully');
        }

        return redirect()->route('staff.show',['staff'=>$staff, 'tab'=>'courses'])->with('success','Course assigned successfully');
    }

    /**
     * Edit assigned course
     */
    public function editCourse(Staff $staff, Course $course, Request $request){
        $departments = Department::with('programs.courses')->get(['name','id']);
        return view('staff.edit-course', compact('staff', 'course', 'departments'));
    }
    
    /**
     * Updaet assigned courses in storage
     */
    public function updateCourse(Staff $staff, Course $course, Request $request){
        // dd($request->all());
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id'
        ]);

        $stf = DB::table('course_staff')
            ->where('staff_id',$staff->id)
            ->where('course_id',$course->id)
            ->update([
                'course_id' => $validated['course_id']
            ]);
        $departments = Department::with('programs.courses')->get(['name','id']);
        return redirect()->route('staff.show', ['staff'=>$staff,'tab'=>'courses']);
    }

    /**
     * Delete assigned course
     */
    public function destroyCourse(Staff $staff, Course $course){
        $staff->courses()->detach($course->id);
        return redirect()->route('staff.show',['staff'=>$staff, 'tab'=>'courses'])
                         ->with('success','Staff deleted successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Staff $staff)
    {
        $this->authorize('delete-staff',$staff);
        $staff->delete();
        if(request('origin')==='department'){
            return redirect()->route('departments.show',[
                                    'department'=>$staff->department_id,
                                    'tab'=>'staff'
            ])->with('success','Course assigned successfully');
        }
        return redirect()->route('staff.index')
                         ->with('success','Staff deleted successfully');
    }
}
