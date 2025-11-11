<div class="flex w-full justify-between">
    <form id="filters" method="GET">
        <select id="per_page" name="per_page"
        class="block w-full mt-2 px-3 py-2 border shadow-sm
             border-gray-300 dark:border-gray-700 rounded-md 
             bg-white dark:bg-gray-900 focus:outline-none 
             dark:text-gray-300 dark:focus:ring-indigo-600
             focus:ring-indigo-500 focus:border-indigo-500
               first-letter:focus:ring-2 text-gray-900"
               >
            <option value= "5" {{ request('per_page') == '5' ? 'selected' : '' }}>5</option>
            <option value="10" {{ request('per_page') == '10' ? 'selected' : '' }}>10</option>
            <option value="25" {{ request('per_page') == '25' ? 'selected' : '' }}>25</option>
            <option value="50" {{ request('per_page') == '50' ? 'selected' : '' }}>50</option>
        </select>
    </form>
    {{ $students->withQueryString()->links() }}
</div>
<table class="w-full text-center border-collapse">
    <thead class="bg-gray-100 dark:bg-gray-700">
        <tr>
            <th class="p-3 w-10">#</th>
            <th class="p-3">Name</th>
            <th class="p-3">Register No</th>
            <th class="p-3 w-56">Program</th>
            <th class="p-3">Department</th>
            <th class="p-3">Semester</th>
            <th class="p-3">Email</th>
            <th class="p-3">Action</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($students as $student)
            <tr class="border-b border-gray-200 dark:border-gray-700">
                <td class="p-3">{{ $loop->iteration }}</td>
                <td class="p-3">{{ $student->user->name }}</td>
                <td class="p-3">{{ $student->reg_no }}</td>
                <td class="p-3">{{ $student->program->name }}</td>
                <td class="p-3">{{ $student->department->name }}</td>
                <td class="p-3">{{ $student->semester }}</td>
                <td class="p-3">{{ $student->user->email }}</td>
                <td class="p-3 flex gap-3 justify-center">
                    <a href="{{ route('students.show', $student) }}" class="text-yellow-400 hover:text-yellow-200">View</a>
                    
                    @can('edit-student',$student)
                        <a href="{{ route('students.edit', $student) }}" class="text-blue-400 hover:text-blue-200">Edit</a>
                    @endcan
                    @can('delete-student',$student)
                        <form action="{{ route('students.destroy', $student) }}" method="POST"
                            onsubmit="return confirm('Delete this department?')">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-500 hover:text-red-200">Delete</button>
                        </form>
                    @endcan
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="p-3 text-center text-gray-500 dark:text-gray-400">
                    No students found.
                </td>
            </tr>
        @endforelse
    </tbody>
</table>