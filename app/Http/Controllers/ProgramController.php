<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Program;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $programs = Program::all();
        return view('programs.index', compact('programs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $departments = Department::get(['name','id']);
        return view('programs.create',compact('departments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create-program');

        $validated = $request->validate([
            'name'=>'required|string|max:30|unique:programs,name',
            'code'=>'required|string|unique:programs,code',
            'total_semesters'=>'required|integer|min:1|max:8',
            'department_id'=>'required|integer|exists:departments,id'
        ]);

        $program = Program::create($validated);

        return redirect()->route('departments.show',[
                'department'=>$program->department_id,
                'tab'=>'programs'
            ])->with('success','Program created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Program $program)
    {
        return view('programs.show', compact('program'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Program $program)
    {
        $this->authorize('edit-program', $program);
        $departments = Department::with('programs')->get(['id','name']);
        return view('programs.edit', compact('program','departments'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Program $program)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Program $program)
    {
        //
    }
}
