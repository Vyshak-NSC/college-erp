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
            $students = $query->orderBy('id')->paginate($request->get('per_page', 10))
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
        $this->authorize('edit-student', $student);
        $departments = Department::with('programs')->get(['id','name']);
        return view('students.edit', compact('student', 'departments'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student)
    {
        // dd($request->all());
        $this->authorize('update-student', $student);
        $validated = $request->validate([
            'name' => "nullable|string",
            'email' => "nullable|email",
            'department_id' => "nullable|integer|exists:departments,id",
            'program_id' => "nullable|integer|exists:programs,id",
            'semester' => "nullable|integer|min:1|max:8",
            'admission_date' => "nullable|date"
        ]);

        $student->user->update([
            'name' => $validated['name'],
            'email' => $validated['email']
        ]);

        $student->update([
            'department_id' => $validated['department_id'],
            'program_id' => $validated['program_id'],
            'semester' => $validated['semester'],
            'admission_date' => $validated['admission_date'],
        ]);

        return redirect()->route('students.show',$student->id)->with('success','Student updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Student $student)
    {
        $this->authorize('delete-student',$student);
        $student->delete();
        return back()->with('success', 'Deleted student successfully'); 
    }

    public function bulkDelete(Request $request){
        $ids = $request->input('select',[]);
        if(!empty($ids)){
            Student::whereIn('id',$ids)->delete();
        }
        if(count($ids)==1){
            return back()->with('success', 'Student deleted successfully.');
        }
        return back()->with('success', 'Students deleted successfully.');
    }
}
