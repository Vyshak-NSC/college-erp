<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
            {{ __('Student Details') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6 text-gray-900 dark:text-gray-100">
                <div x-data="{ selectedTab: '{{ request('tab','details') }}' }">
                    <div class="border-b border-gray-100 dark:border-gray-700">
                        <nav class="-mb-px flex space-x-8 px-6" aria-label="Tabs">
                            <button
                                @click = "selectedTab='details'"
                                class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm" 
                                :class="{
                                    'border-blue-500 text-blue-600 dark:text-blue-400': selectedTab === 'details',
                                    'border-transparent text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-600': selectedTab !== 'details'
                                }"
                                >
                                Details
                            </button>
                            <button 
                                @click = "selectedTab='courses'"
                                class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm" 
                                :class="{
                                    'border-blue-500 text-blue-600 dark:text-blue-400': selectedTab === 'courses',
                                    'border-transparent text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-600': selectedTab !== 'courses'
                                }">
                                Courses
                            </button>
                        </nav>
                    </div>

                    <!-- Details -->
                    <div x-show="selectedTab === 'details'">
                        
                        <h3 class="text-2xl font-bold mb-4 mt-4">{{ $student->user->name }}</h3>
                        <div class="grid grid-cols-4 gap-y-3 gap-x-2">
                            <span class="col-span-1 font-semibold ml-5">{{ __('Reg. No.:') }}</span>
                            <span class="col-span-3">: {{ $student->reg_no }}</span>

                            <span class="col-span-1 font-semibold ml-5">{{ __('Program:') }}</span>
                            <span class="col-span-3">: {{ $student->program->name }}</span>
                            
                            <span class="col-span-1 font-semibold ml-5">{{ __('Semester:') }}</span>
                            <span class="col-span-3">: {{ $student->semester }}</span>
                            
                            <span class="col-span-1 font-semibold ml-5">{{ __('Admission Date:') }}</span>
                            <span class="col-span-3">: {{ $student->admission_date }}</span>
                            
                            <span class="col-span-1 font-semibold ml-5">{{ __('Email:') }}</span>
                            <span class="col-span-3">: {{ $student->user->email }}</span>

                            <div class="col-span-3 mt-6 flex gap-3">
                                <a href="{{ route('students.index') }}"
                                class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded">
                                    <span>{{ __('Back') }}</span>
                                </a>

                                <a href="{{ route('students.edit', $student) }}"
                                class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded">
                                    <span>{{ __('Edit') }}</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Courses -->
                    <div x-show="selectedTab === 'courses'">
                        <h3 class="text-xl font-semibold mb-4 mt-4 flex justify-between">
                            Enrolled Courses
                        </h3>
                        <table class="w-full text-center border-collapse">
                            <thead class="bg-gray-100 dark:bg-gray-700">
                                <tr>
                                    <th class="p-3">#</th>
                                    <th class="p-3">Course Name</th>
                                    <th class="p-3">Course Code</th>
                                    <th class="p-3">Department</th>
                                    <th class="p-3">Program</th>
                                    <th class="p-3">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($student->program->courses as $course)
                                    @if($course->semester == $student->semester)
                                        <tr class="border-b border-gray-200 dark:border-gray-700">
                                            <td class="py-3 px-1">{{ $loop->iteration }}</td>
                                            <td class="py-3 px-1">{{ $course->name }}</td>
                                            <td class="py-3 px-1">{{ $course->code }}</td>
                                            <td class="py-3 px-1">{{ $course->department->name }}</td>
                                            <td class="py-3 px-1">{{ $course->program->name }}</td>
                                            
                                            <td class="py-3 px-1 flex gap-3 justify-center">
                                                <a href="{{ route('courses.show', $course) }}" class="text-yellow-400 hover:underline">View</a>
                                                
                                                @can('edit-student',$student)
                                                    <a href="{{ route('staff.edit-course', ['staff'=>$student,'course'=>$course]) }}" class="text-blue-400 hover:underline">Edit</a>
                                                @endcan
                                                @can('delete-student',$student)
                                                    <form action="{{ route('staff.destroy-course', ['staff'=>$student, 'course'=>$course]) }}" method="POST"
                                                        onsubmit="return confirm('Delete this staff?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="text-red-500 hover:underline">Delete</button>
                                                    </form>
                                                @endcan
                                            </td>
                                        </tr>
                                    @endif
                                @empty
                                    <tr>
                                        <td colspan="5" class="p-3 text-center text-gray-500 dark:text-gray-400">
                                            No courses assigned.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="col-span-3 mt-6 flex gap-3">
                            <a href="javascript:history.back()"
                            class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded">
                                <span>{{ __('Back') }}</span>
                            </a>

                            <a x-show="selectedTab==='details'" href="{{ route('staff.edit', $student) }}"
                            class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded">
                                <span>{{ __('Edit') }}</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
