<table class="w-full text-center border-collapse">
    <thead class="bg-gray-100 dark:bg-gray-700">
        <tr>
            <th class="p-3">#</th>
            <th class="p-3">Name</th>
            <th class="p-3">Employee ID</th>
            <th class="p-3">Designation</th>
            <th class="p-3">Action</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($department->staff as $staff)
            <tr class="border-b border-gray-200 dark:border-gray-700">
                <td class="p-3">{{ $loop->iteration }}</td>
                <td class="p-3">{{ $staff->user->name }}</td>
                <td class="p-3">{{ $staff->employee_id}}</td>
                <td class="p-3">{{ $staff->designation}}</td>
                <td class="p-3 flex gap-3 justify-center">
                    <a href="{{ route('staff.show', $staff) }}" class="text-yellow-400 hover:underline">View</a>
                    
                    @can('edit-staff',$staff)
                        <a href="{{ route('staff.edit', $staff) }}" class="text-blue-400 hover:underline">Edit</a>
                    @endcan
                    @can('delete-staff',$staff)
                        <form action="{{ route('staff.destroy', $staff) }}" method="POST"
                            onsubmit="return confirm('Delete this staff?')">
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