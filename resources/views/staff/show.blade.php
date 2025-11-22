<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
            {{ __('Staff Details') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg text-gray-900 dark:text-gray-100">
                <div x-data="{ selectedTab: '{{ request('tab','details') }}' }">
                    <div class="border-b border-gray-100 dark:border-gray-700 flex relative justify-between">
                        <div class="flex gap-3 space-x-8 m-2 absolute">
                            <a href="javascript:history.back()"
                            class="px-4 py-2 hover:bg-gray-600 text-white rounded">
                                <span><i class='fas fa-angle-left text-gray-500'></i></span>
                            </a>
                        </div>    

                        <nav class="ml-10 -mb-px flex space-x-8 px-6" aria-label="Tabs">
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
                        @can('edit-department')
                            <div class="ml-10 my-auto flex space-x-2 px-6 w-fit">
                                <a href="{{ route('departments.edit', $department) }}"
                                class="px-4 py-1 bg-blue-600 hover:bg-blue-700 text-white rounded">
                                    <span>{{ __('Edit') }}</span>
                                </a>

                                <a x-show="selectedTab==='courses'" href="{{ route('staff.assign-course', $staff) }}"
                                    class="px-2 py-1 bg-blue-600 hover:bg-blue-700 text-white rounded">
                                    Assign Course
                                </a>
                            </div>
                        @endcan
                    </div>

                    <!-- Details -->
                    <div  class="p-6 text-gray-900 dark:text-gray-100">
                        <div x-show="selectedTab === 'details'">
                            <h3 class="text-2xl font-bold mb-4 mt-4">{{ $staff->user->name }}</h3>
                            <div class="grid grid-cols-4 gap-y-3 gap-x-2">
                                <span class="col-span-1 font-semibold ml-5">{{ __('Employee ID:') }}</span>
                                <span class="col-span-3">: {{ $staff->employee_id }}</span>

                                <span class="col-span-1 font-semibold ml-5">{{ __('Department:') }}</span>
                                <span class="col-span-3">: {{ $staff->department?->name }}</span>
                                
                                <span class="col-span-1 font-semibold ml-5">{{ __('Designation:') }}</span>
                                <span class="col-span-3">: {{ $staff->designation }}</span>
                                
                                <span class="col-span-1 font-semibold ml-5">{{ __('Hire Date:') }}</span>
                                <span class="col-span-3">: {{ $staff->hire_date }}</span>
                                
                                <span class="col-span-1 font-semibold ml-5">{{ __('Email:') }}</span>
                                <span class="col-span-3">: {{ $staff->user->email }}</span>
                            </div>
                        </div>

                        <!-- Courses -->
                        <div x-show="selectedTab === 'courses'">
                            <h3 class="text-xl font-semibold mb-4 mt-4 flex justify-between">
                                Courses
                            </h3>
                            <table class="w-full text-center border-collapse">
                                <thead class="bg-gray-100 dark:bg-gray-700">
                                    <tr>
                                        <th class="p-3">#</th>
                                        <th class="p-3">Course Name</th>
                                        <th class="p-3">Department</th>
                                        <th class="p-3">Program</th>
                                        <th class="p-3">Semester</th>
                                        <th class="p-3">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($staff->courses as $course)
                                        <tr class="border-b border-gray-200 dark:border-gray-700">
                                            <td class="py-3 px-1">{{ $loop->iteration }}</td>
                                            <td class="py-3 px-1">{{ $course->name }}</td>
                                            <td class="py-3 px-1">{{ $course->department->name }}</td>
                                            <td class="py-3 px-1">{{ $course->program->name }}</td>
                                            <td class="py-3 px-1">{{ $course->semester }}</td>
                                            
                                            <td class="py-3 px-1 flex gap-3 justify-center">
                                                <a href="{{ route('courses.show', $course) }}" class="text-yellow-400 hover:underline">View</a>
                                                
                                                @can('edit-staff',$staff)
                                                    <a href="{{ route('staff.edit-course', ['staff'=>$staff,'course'=>$course]) }}" class="text-blue-400 hover:underline">Edit</a>
                                                @endcan
                                                @can('delete-staff',$staff)
                                                    <form action="{{ route('staff.destroy-course', ['staff'=>$staff, 'course'=>$course]) }}" method="POST"
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
                                                No courses assigned.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
