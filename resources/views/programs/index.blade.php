<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Programs') }}
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
                        <h3 class="text-lg font-semibold">All programs</h3>
                        
                        @can('create-program')
                            <a href="{{ route('programs.create') }}"
                            class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded">
                                Add Program
                            </a>
                        @endcan
                    </div>

                    <table class="w-full text-center border-collapse">
                        <thead class="bg-gray-100 dark:bg-gray-700">
                            <tr>
                                <th class="p-3">#</th>
                                <th class="p-3">Name</th>
                                <th class="p-3">Code</th>
                                <th class="p-3">Department</th>
                                <th class="p-3">Semesters</th>
                                <th class="p-3">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($programs as $dept)
                                <tr class="border-b border-gray-200 dark:border-gray-700">
                                    <td class="p-3">{{ $loop->iteration }}</td>
                                    <td class="p-3">{{ $dept->name }}</td>
                                    <td class="p-3">{{ $dept->code }}</td>
                                    <td class="p-3">{{ $dept->department->name }}</td>
                                    <td class="p-3">{{ $dept->total_semesters }}</td>
                                    <td class="p-3 flex gap-3 justify-center">
                                        <a href="{{ route('programs.show', $dept) }}" class="text-yellow-400 hover:underline">View</a>
                                        
                                        @can('edit-program',$dept)
                                            <a href="{{ route('programs.edit', $dept) }}" class="text-blue-400 hover:underline">Edit</a>
                                        @endcan
                                        @can('delete-program',$dept)
                                            <form action="{{ route('programs.destroy', $dept) }}" method="POST"
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
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
