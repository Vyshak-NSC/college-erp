<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
            {{ __('Department Details') }}
        </h2>
    </x-slot>

    <!-- tab container -->
    <div x-data="{ selectedTab: '{{ request('tab','details') }}' }" class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="border-b border-gray-200 dark:border-gray-700 flex relative">
                    <div class="flex gap-3 space-x-8 m-2 absolute">
                        <a href="javascript:history.back()"
                        class="px-4 py-2 hover:bg-gray-600 text-white rounded">
                            <span><i class='fas fa-angle-left text-gray-500'></i></span>
                        </a>

                        @can('edit-department')
                        <a href="{{ route('departments.edit', $department) }}"
                        class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded">
                            <span>{{ __('Edit') }}</span>
                        </a>
                        @endcan
                    </div>
                
                    <nav class="ml-10 -mb-px flex space-x-8 px-6" aria-label="Tabs">
                        <button 
                            @click="selectedTab = 'details'"
                            :class="{
                                'border-blue-500 text-blue-600 dark:text-blue-400': selectedTab === 'details',
                                'border-transparent text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-600': selectedTab !== 'details'
                            }"
                            class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                            Details
                        </button>

                        <button 
                            @click="selectedTab = 'programs'"
                            :class="{
                                'border-blue-500 text-blue-600 dark:text-blue-400': selectedTab === 'programs',
                                'border-transparent text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-600': selectedTab !== 'programs'
                            }"
                            class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                            Programs ({{ $department->programs->count() }})
                        </button>

                        <button 
                            @click="selectedTab = 'staff'"
                            :class="{
                                'border-blue-500 text-blue-600 dark:text-blue-400': selectedTab === 'staff',
                                'border-transparent text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-600': selectedTab !== 'staff'
                            }"
                            class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                            Staff ({{ $department->staff->count() }})
                        </button>

                        <button 
                            @click="selectedTab = 'courses'"
                            :class="{
                                'border-blue-500 text-blue-600 dark:text-blue-400': selectedTab === 'courses',
                                'border-transparent text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-600': selectedTab !== 'courses'
                            }"
                            class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                            Courses ({{ $department->courses->count() }})
                        </button>
                    </nav>
                </div>

                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    <!-- ========== Details ========== -->
                    <div x-show="selectedTab === 'details'">
                        <div class="mb-4 text-sm text-gray-500 dark:text-gray-400">
                            Department : {{ $department->name }}
                        </div>
                        <div class="grid grid-cols-4 gap-y-3 gap-x-2">
                            <span class="col-span-1 font-semibold ml-5">{{ __('Code') }}</span>
                            <span class="col-span-3">: {{ $department->code }}</span>

                            <span class="col-span-1 font-semibold ml-5">{{ __('Staff') }}</span>
                            <span class="col-span-3">: {{ $department->staff->count() ?: 'N/A' }}</span>

                            <span class="col-span-1 font-semibold ml-5">{{ __('Programs') }}</span>
                            <span class="col-span-3">: {{ $department->programs->count() ?: 'N/A' }}</span>

                            <span class="col-span-1 font-semibold ml-5">{{ __('Courses') }}</span>
                            <span class="col-span-3">: {{ $department->courses->count() ?: 'N/A' }}</span>
                            
                            @if($department->description)
                                <span class="col-span-1 font-semibold ml-5">{{ __('Description:') }}</span>
                                <span class="col-span-2">: {{ $department->description }}</span>
                            @endif
                        </div>
                    </div>

                    <!-- ========== Programs ========== -->
                    <div x-show="selectedTab === 'programs'">
                        <div class="mb-4 text-sm text-gray-500 dark:text-gray-400">
                            Department : {{ $department->name }}
                        </div>
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold">Programs</h3>
                            @can('create-program', $department->id)
                                <a href="{{ route('programs.create') }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded text-sm">
                                    Add Program
                                </a>
                            @endcan
                        </div>
                        @include('departments.partials._programs-table')
                    </div>
                    

                    <!-- ========== Staff ========== -->
                    <div x-show="selectedTab === 'staff'">
                        <div class="mb-4 text-sm text-gray-500 dark:text-gray-400">
                            Department : {{ $department->name }}
                        </div>
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold">Staff Members</h3>
                            @can('create-staff', $department->id)
                                <a href="{{ route('staff.create', ['origin'=>'department']) }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded text-sm">
                                    Add Staff
                                </a>
                            @endcan
                        </div>
                        @include('departments.partials._staff-table')
                    </div>

                    <!-- ========== Courses ========== -->
                    <div x-show="selectedTab === 'courses'">
                        <div class="mb-4 text-sm text-gray-500 dark:text-gray-400">
                            Department : {{ $department->name }}
                        </div>
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold">Courses</h3>
                            @can('create-course', $department->id)
                                <a href="{{ route('courses.create') }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded text-sm">
                                    Add Course
                                </a>
                            @endcan
                        </div>
                        @include('departments.partials._courses-table')
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    function loadStudents(){
        axios.get({{ route('students.index').'?program=1' }})
    }
</script>