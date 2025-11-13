<table class="w-full text-center border-collapse dark:text-gray-100">
    <thead class="bg-gray-100 dark:bg-gray-700">
        <tr>
            <th class="p-3">#</th>
            <th class="p-3">Name</th>
            <th class="p-3">Email</th>
            <th class="p-3">Role</th>
            <th class="p-3">Created at</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($users as $user)
            <tr class="border-b border-gray-200 dark:border-gray-700">
                <td class="p-3">{{ $user->id }}</td>
                <td class="p-3">{{ $user->name }}</td>
                <td class="p-3">{{ $user->email }}</td>
                <td class="p-3">{{ $user->role }}</td>
                <td class="p-3">{{ $user->created_at }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="4" class="p-3 text-center text-gray-500 dark:text-gray-400">
                    No staff found.
                </td>
            </tr>
        @endforelse
    </tbody>
</table>