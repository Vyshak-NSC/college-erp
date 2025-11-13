<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Departments') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <!-- <div class="mb-4 p-3 rounded bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200"> -->
                <div
                    x-data="{ show: true }"
                    x-show="show"
                    x-init="setTimeout(() => show = false, 3000)"
                    class="mb-4 p-3 bg-green-600/80 rounded bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold">All Departments</h3>
                        
                        @can('create-department')
                            <a href="{{ route('departments.create') }}"
                            class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded">
                                Add Department
                            </a>
                        @endcan
                    </div>

                    <table class="w-full text-center border-collapse">
                        <thead class="bg-gray-100 dark:bg-gray-700">
                            <tr>
                                <th class="p-3">#</th>
                                <th class="p-3">Name</th>
                                <th class="p-3">Code</th>
                                <th class="p-3">Programs</th>
                                <th class="p-3">Courses</th>
                                <th class="p-3">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($departments as $dept)
                                <tr class="border-b border-gray-200 dark:border-gray-700">
                                    <td class="p-3">{{ $loop->iteration }}</td>
                                    <td class="p-3">{{ $dept->name }}</td>
                                    <td class="p-3">{{ $dept->code }}</td>
                                    <td class="p-3">{{ $dept->programs->count() }}</td>
                                    <td class="p-3">{{ $dept->courses->count() }}</td>
                                    <td class="p-3 flex gap-3 justify-center">
                                        <a href="{{ route('departments.show', $dept) }}" class="text-yellow-400 hover:text-yellow-200">View</a>
                                        
                                        @can('edit-department',$dept)
                                            <a href="{{ route('departments.edit', $dept) }}" class="text-blue-400 hover:text-blue-200">Edit</a>
                                        @endcan
                                        @can('delete-department',$dept)
                                            <form action="{{ route('departments.destroy', $dept) }}" method="POST"
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
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
