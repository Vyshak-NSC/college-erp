<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('staffs') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 p-3 rounded bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold">All Staffs</h3>
                        
                        @can('create-department')
                            <a href="{{ route('staffs.create') }}"
                            class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded">
                                Add Staff
                            </a>
                        @endcan
                    </div>

                    <table class="w-full text-center border-collapse">
                        <thead class="bg-gray-100 dark:bg-gray-700">
                            <tr>
                                <th class="p-3">#</th>
                                <th class="p-3">Name</th>
                                <th class="p-3">Department</th>
                                <th class="p-3">Designation</th>
                                <th class="p-3">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($staffs as $staff)
                                <tr class="border-b border-gray-200 dark:border-gray-700">
                                    <td class="p-3">{{ $loop->iteration }}</td>
                                    <td class="p-3">{{ $staff->user->name }}</td>
                                    <td class="p-3">{{ $staff->department?->name ?? 'N/A'}}</td>
                                    <td class="p-3">{{ $staff->designation}}</td>
                                    <td class="p-3 flex gap-3 justify-center">
                                        <a href="{{ route('staffs.show', $staff) }}" class="text-yellow-400 hover:underline">View</a>
                                        
                                        @can('edit-staff',$staff)
                                            <a href="{{ route('staffs.edit', $staff) }}" class="text-blue-400 hover:underline">Edit</a>
                                        @endcan
                                        @can('delete-staff',$staff)
                                            <form action="{{ route('staffs.destroy', $staff) }}" method="POST"
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
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
