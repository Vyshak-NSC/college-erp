<div class="mb-5">
    <div class="flex items-center gap-2 gap-x-5">
        
        <div>
            <label for="per_page">Per page</label>
            <select id="per_page" name="per_page" 
                class="px-1 py-1 border shadow-sm w-14 text-xs
                    border-gray-300 dark:border-gray-700 rounded-md 
                    bg-white dark:bg-gray-900 focus:outline-none 
                    dark:text-gray-300 dark:focus:ring-indigo-600
                    focus:ring-indigo-500 focus:border-indigo-500
                    text-gray-900"
                onchange="(function(v){
                    const u = new URL(window.location.href);
                    u.searchParams.set('per_page', v);
                    u.searchParams.delete('page'); // reset page when changing size
                    window.location = u.toString();
                    })(this.value)"
                    >
                <option value="5"   {{ request('per_page') == '5'  ? 'selected' : '' }}>5</option>
                <option value="10"  {{ request('per_page', '10') == '10' ? 'selected' : '' }}>10</option>
                <option value="25"  {{ request('per_page') == '25' ? 'selected' : '' }}>25</option>
                <option value="50"  {{ request('per_page') == '50' ? 'selected' : '' }}>50</option>
            </select>
        </div>
    </div>
    {{ $students->links() }}
</div>

<form id="bulk-delete-form" action="{{ route('students.bulk-delete') }}" method="post">
    @csrf
    @method('DELETE')
    <table class="w-full text-center border-collapse table-fixed">
        <thead class="bg-gray-100 dark:bg-gray-700">
            <tr>
                <td class="py-3 px-1 truncate w-10 selector hidden">
                    <x-input-checkbox id="select-all" />
                </td>
                <th class="py-3 px-1 truncate w-10">#</th>
                <th class="py-3 px-1 truncate">Name</th>
                <th class="py-3 px-1 truncate">Register No</th>
                <th class="py-3 px-1 truncate">Program</th>
                <th class="py-3 px-1 truncate">Department</th>
                <th class="py-3 px-1 truncate w-20">Semester</th>
                <th class="py-3 px-1 truncate">Email</th>
                <th class="py-3 px-1 truncate">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($students as $student)
                <tr class="border-b border-gray-200 dark:border-gray-700">
                    <td class="py-3 px-1 truncate selector hidden">
                        <x-input-checkbox name="select[]" value="{{ $student->id }}" />
                    </td>
                    <td class="py-3 px-1 truncate">{{ $loop->iteration }}</td>
                    <td class="py-3 px-1 truncate">{{ $student->user->name }}</td>
                    <td class="py-3 px-1 truncate">{{ $student->reg_no }}</td>
                    <td class="py-3 px-1 truncate">{{ $student->program->name }}</td>
                    <td class="py-3 px-1 truncate">{{ $student->department->name }}</td>
                    <td class="py-3 px-1 truncate">{{ $student->semester }}</td>
                    <td class="py-3 px-1 truncate">{{ $student->user->email }}</td>
                    <td class="py-3 px-1 gap-3">
                        <a href="{{ route('students.show', $student) }}" class="no-ajax mx-1 text-yellow-400 hover:text-yellow-200">View</a>
                        
                        @can('edit-student',$student)
                            <a href="{{ route('students.edit', $student) }}" class="no-ajax mx-1 text-blue-400 hover:text-blue-200">Edit</a>
                        @endcan
                        @can('delete-student',$student)
                            <a href="#" data-id="{{ $student->id }}" class="no-ajax delete-single mx-1 text-red-500 hover:text-red-200">Delete</a>
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
</form>
