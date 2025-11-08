<div>
    {{ $students->links() }}
</div>
<table class="w-full text-center border-collapse">
    <thead class="bg-gray-100 dark:bg-gray-700">
        <tr>
            <th class="p-3">#</th>
            <th class="p-3">Name</th>
            <th class="p-3">Register No</th>
            <th class="p-3">Department</th>
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
                <td class="p-3">{{ $student->department->name }}</td>
                <td class="p-3">{{ $student->user->email }}</td>
                <td class="p-3 flex gap-3 justify-center">
                    <a href="{{ route('departments.show', $student) }}" class="text-yellow-400 hover:text-yellow-200">View</a>
                    
                    @can('edit-student',$student)
                        <a href="{{ route('departments.edit', $student) }}" class="text-blue-400 hover:text-blue-200">Edit</a>
                    @endcan
                    @can('delete-student',$student)
                        <form action="{{ route('departments.destroy', $student) }}" method="POST"
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
                <td colspan="4" class="p-3 text-center text-gray-500 dark:text-gray-400">
                    No departments found.
                </td>
            </tr>
        @endforelse
    </tbody>
</table>