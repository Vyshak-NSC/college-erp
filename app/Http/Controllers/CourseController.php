<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Department;
use App\Models\Program;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courses = Course::all();
        return view('courses.index', compact('courses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $departments = Department::with('programs')->get(['name','id']);

        return view('courses.create', compact('departments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create-course');
        $validated=$request->validate([
            'name'=>'required|max:255|unique:courses,name',
            'code'=>'required|max:50|unique:courses,code',
            'credits'=>'required|integer|min:1',
            'semester'=>'required|integer|min:1|max:8',
            'description'=>'nullable|string',
            'program_id'=>'required|integer|exists:programs,id'
        ]);

        $course = Course::create($validated);
        return redirect()->route('departments.show',['department'=> $course->program->department_id,'tab'=>'courses'])->with('success','Course created successfully');

    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        return view('courses.show',compact('course'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course)
    {
        $this->authorize('edit-course', $course);
        $departments = Department::all();
        return view('courses.edit', compact('course', 'departments'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Course $course)
    {
        $this->authorize('update-course',$course);
        $validated=$request->validate([
            'name'=>'required|max:255|unique:courses,name,'. $course->id,
            'code'=>'required|max:50|unique:courses,code,'. $course->id,
            'credits'=>'required|integer|min:1',
            'semester'=>'required|integer|min:1|max:8',
            'description'=>'nullable|string',
            'program_id'=>'required|integer|exists:programs,id'
        ]);

        $course->update($validated);
        return redirect()->route('departments.show',['department'=> $course->program->department_id,'tab'=>'courses'])->with('success','Course updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        $this->authorize('delete-course',$course);
        $course->delete();
        if(request('origin')==='department'){
            return redirect()->route('departments.show',['department'=> $course->program->department_id,'tab'=>'courses'])->with('success','Course deleted successfully');
        }

        return redirect()->route('courses.index')
                         ->with('success','"Course deleted successfully');
    }
}
