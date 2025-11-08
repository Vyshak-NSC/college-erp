<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Courses') }}
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
                        <h3 class="text-lg font-semibold">All Courses</h3>
                        
                        {{-- @can('create-course')
                            <!-- <a href="{{ route('courses.create') }}"
                            class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded">
                                Add Courses
                            </a> -->
                        @endcan --}}
                    </div>

                    <table class="w-full text-center border-collapse">
                        <thead class="bg-gray-100 dark:bg-gray-700">
                            <tr>
                                <th class="p-3">#</th>
                                <th class="p-3">Code</th>
                                <th class="p-3">Name</th>
                                <th class="p-3">Credits</th>
                                <th class="p-3">Department</th>
                                <th class="p-3">Semester</th>
                                <th class="p-3">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($courses as $course)
                                <tr class="border-b border-gray-200 dark:border-gray-700">
                                    <td class="p-3">{{ $loop->iteration }}</td>
                                    <td class="p-3">{{ $course->code }}</td>
                                    <td class="p-3">{{ $course->name }}</td>
                                    <td class="p-3">{{ $course->credits }}</td>
                                    <td class="p-3">{{ $course->program?->department?->name }}</td>
                                    <td class="p-3">{{ $course->semester }}</td>
                                    <td class="p-3 flex gap-3 justify-center">
                                        <a href="{{ route('courses.show', $course) }}" class="text-yellow-400 hover:underline">View</a>
                                        
                                        {{-- @can('edit-course',$course)
                                            <a href="{{ route('courses.edit', $course) }}" class="text-blue-400 hover:underline">Edit</a>
                                        @endcan
                                        --}}
                                        @can('delete-course',$course)
                                            <form action="{{ route('courses.destroy', $course) }}" method="POST"
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
                                    <td colspan="7" class="p-3 text-center text-gray-500 dark:text-gray-400">
                                        No courses found.
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
