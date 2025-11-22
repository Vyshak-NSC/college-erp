<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Student;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // $perPage = request('per_page');
        // dd($request->all());
        $departments = Department::with('programs')->get(['id','name']);
        $user = Auth::user()->load('staff.department');
        $department = $user->staff?->department;
        if($request->ajax()){
            $query = Student::with(['program','user']);

            if ($request->filled('department')) {
                $query->whereHas('program', function ($q) use ($request) {
                    $q->where('department_id', $request->department);
                });
            }
            if($request->filled('program')){
                $query->where('program_id',$request->program);
            }

            if($request->filled('semester')){
                $query->where('semester',$request->semester);
            }
            
            if($request->filled('search')){
                // get search query and list of column
                $search = "%$request->search%";
                $studentColumns = ['reg_no'];
                $userColumns = ['name','email'];
                
                $query->where(function($group) use ($search, $studentColumns, $userColumns) {
                    // search in user table
                    $group->whereHas('user', function($u) use ($search, $userColumns) {
                        $u->where(function($userGroup) use ($search, $userColumns) {
                            foreach ($userColumns as $col) {
                                $userGroup->orWhere($col, 'LIKE', $search);
                            }
                        });
                    });

                    // search in student table
                    $group->orWhere(function($studentGroup) use ($search, $studentColumns) {
                        foreach ($studentColumns as $col) {
                            $studentGroup->orWhere($col, 'LIKE', $search);
                        }
                    });

                });

            }
            $query->orderBy('semester','asc');
            $students = $query->paginate($request->get('per_page', 10))
                              ->withQueryString();
            // return $students;
            return view('students._table-partial', compact('students'))->render();
        }

        return view('students.index', compact('user','departments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $departments = Department::with('programs')->get(['name','id']) ;
        return view('students.create', compact('departments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        return view('students.show', compact('student'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        //
    }

    public function bulkDelete(Request $request){
        $ids = $request->input('select',[]);
        if(!empty($ids)){
            Student::whereIn('id',$ids)->delete();
        }
        return back()->with('success', 'Deleted selected students');
    }
}
