<table class="w-full text-center border-collapse">
    <thead class="bg-gray-100 dark:bg-gray-700">
        <tr>
            <th class="p-3">#</th>
            <th class="p-3">Name</th>
            <th class="p-3">Code</th>
            <th class="p-3">Department</th>
            <th class="p-3">Students</th>
            <th class="p-3">Semesters</th>
            <th class="p-3">Action</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($department->programs as $program)
            <tr class="border-b border-gray-200 dark:border-gray-700">
                <td class="p-3">{{ $loop->iteration }}</td>
                <td class="p-3">{{ $program->name }}</td>
                <td class="p-3">{{ $program->code }}</td>
                <td class="p-3">{{ $program->department?->name }}</td>
                <td class="p-3">{{ $program->students?->count() }}</td>
                <td class="p-3">{{ $program->total_semesters }}</td>
                <td class="p-3 flex gap-3 justify-center">
                    <a href="{{ route('programs.show', $program) }}" class="text-yellow-400 hover:underline">View</a>
                    
                    @can('edit-program',$program)
                        <a href="{{ route('programs.edit', $program) }}" class="text-blue-400 hover:underline">Edit</a>
                    @endcan
                    @can('delete-program',$program)
                        <form action="{{ route('programs.destroy', $program) }}" method="POST"
                            onsubmit="return confirm('Delete this program?')">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-500 hover:underline">Delete</button>
                        </form>
                    @endcan
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="p-3 text-center text-gray-500 dark:text-gray-400">
                    No programs found.
                </td>
            </tr>
        @endforelse
    </tbody>
</table>