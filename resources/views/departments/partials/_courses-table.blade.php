<table class="w-full text-center border-collapse">
<thead class="bg-gray-100 dark:bg-gray-700">
    <tr>
        <th class="p-3">#</th>
        <th class="p-3">Name</th>
        <th class="p-3">Program</th>
        <th class="p-3">Semester</th>
        <th class="p-3">Credits</th>
        <th class="p-3">Action</th>
    </tr>
</thead>
<tbody>
    @forelse ($department->courses as $course)
        <tr class="border-b border-gray-200 dark:border-gray-700">
            <td class="p-3">{{ $loop->iteration }}</td>
            <td class="p-3">{{ $course->name }}</td>
            <td class="p-3">{{ $course->program?->name ?? 'N/A'}}</td>
            <td class="p-3">{{ $course->semester ?? 'N/A'}}</td>
            <td class="p-3">{{ $course->credits ?? 'N/A'}}</td>
            <td class="p-3 flex gap-3 justify-center">
                <a href="{{ route('courses.show', $course) }}" class="text-yellow-400 hover:underline">View</a>
                
                @can('edit-course',$course)
                    <a href="{{ route('courses.edit', $course) }}" class="text-blue-400 hover:underline">Edit</a>
                @endcan
                @can('delete-course',$course)
                    <form action="{{ route('courses.destroy', $course).'?origin=department' }}" method="POST"
                        onsubmit="return confirm('Delete this course?')">
                        @csrf
                        @method('DELETE')
                        <button class="text-red-500 hover:underline">Delete</button>
                    </form>
                @endcan
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="5" class="p-3 text-center text-gray-500 dark:text-gray-400">
                No staff found.
            </td>
        </tr>
    @endforelse
</tbody>
</table>