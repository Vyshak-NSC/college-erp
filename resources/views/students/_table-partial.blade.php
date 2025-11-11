<div class="flex items-center gap-2 justify-between">
  
<div>
    <label for="per_page">Per page</label>
      <select id="per_page" name="per_page" 
      class="block px-3 py-2 border shadow-sm w-20
         border-gray-300 dark:border-gray-700 rounded-md 
         bg-white dark:bg-gray-900 focus:outline-none 
         dark:text-gray-300 dark:focus:ring-indigo-600
         focus:ring-indigo-500 focus:border-indigo-500
         text-gray-900" onchange="(function(v){
                const u = new URL(window.location.href);
                u.searchParams.set('per_page', v);
                u.searchParams.delete('page'); // reset page when changing size
                window.location = u.toString();
                })(this.value)"
        >
        <option value=" 5"   {{ request('per_page') == '5'  ? 'selected' : '' }}>5</option>
        <option value="10"  {{ request('per_page', '10') == '10' ? 'selected' : '' }}>10</option>
        <option value="25"  {{ request('per_page') == '25' ? 'selected' : '' }}>25</option>
        <option value="50"  {{ request('per_page') == '50' ? 'selected' : '' }}>50</option>
      </select>
</div>

  {{ $students->links() }}
</div>
<table class="w-full text-center border-collapse">
    <thead class="bg-gray-100 dark:bg-gray-700">
        <tr>
            <th class="py-3 px-1">#</th>
            <th class="py-3 px-1">Name</th>
            <th class="py-3 px-1">Register No</th>
            <th class="py-3 px-1 whitespace-nowrap">Program</th>
            <th class="py-3 px-1 whitespace-nowrap">Department</th>
            <th class="py-3 px-1">Semester</th>
            <th class="py-3 px-1">Email</th>
            <th class="py-3 px-1">Action</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($students as $student)
            <tr class="border-b border-gray-200 dark:border-gray-700">
                <td class="py-3 px-1">{{ $loop->iteration }}</td>
                <td class="py-3 px-1 whitespace-nowrap">{{ $student->user->name }}</td>
                <td class="py-3 px-1">{{ $student->reg_no }}</td>
                <td class="py-3 px-1 whitespace-nowrap">{{ $student->program->name }}</td>
                <td class="py-3 px-1 whitespace-nowrap">{{ $student->department->name }}</td>
                <td class="py-3 px-1">{{ $student->semester }}</td>
                <td class="py-3 px-1">{{ $student->user->email }}</td>
                <td class="py-3 px-1 gap-3 whitespace-nowrap">
                    <a href="{{ route('students.show', $student) }}" class="mx-1 text-yellow-400 hover:text-yellow-200">View</a>
                    
                    @can('edit-student',$student)
                        <a href="{{ route('students.edit', $student) }}" class="mx-1 text-blue-400 hover:text-blue-200">Edit</a>
                    @endcan
                    @can('delete-student',$student)
                        <form action="{{ route('students.destroy', $student) }}" method="POST"
                            onsubmit="return confirm('Delete this department?')" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button class="mx-1 text-red-500 hover:text-red-200">Delete</button>
                        </form>
                    @endcan
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="8" class="p-3 text-center text-gray-500 dark:text-gray-400">
                    No students found.
                </td>
            </tr>
        @endforelse
    </tbody>
</table>