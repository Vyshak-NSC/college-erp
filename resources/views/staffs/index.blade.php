<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Staffs') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 p-3 rounded bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200">
                    {{ session('success') }}
                </div>
            @endif

            <div x-data="{tab:'staff'}">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <div class="flex justify-between items-center mb-4">
                            <nav class="-mb-px flex space-x-8 px-6" aria-label="Tabs">
                                <button 
                                    @click="tab='staff'" 
                                    :class="{
                                        'border-blue-500 text-blue-600 dark:text-blue-400': tab === 'staff',
                                        'border-transparent text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-600': tab !== 'staff'
                                    }" 
                                    class="text-lg font-semibold" class="whitespace-nowrap py-4 px-1 border-b-2 text-sm">Staffs</button>
                                
                                    <button 
                                    @click="tab='assign'" 
                                    :class="{
                                        'border-blue-500 text-blue-600 dark:text-blue-400': tab === 'assign',
                                        'border-transparent text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-600': tab !== 'assign'
                                    }"
                                    class="text-lg font-semibold" class="whitespace-nowrap py-4 px-1 border-b-2 text-sm">Assign course</button>
                            </nav>
                            
                            @can('create-department')
                                <a href="{{ route('staffs.create') }}"
                                class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded">
                                    Add Staff
                                </a>
                            @endcan
                        </div>

                        <!-- All Staff -->
                        <div x-show="tab==='staff'">
                            <table class="w-full text-center border-collapse">
                                <thead class="bg-gray-100 dark:bg-gray-700">
                                    <tr>
                                        <th class="p-3">#</th>
                                        <th class="p-3">Name</th>
                                        <th class="p-3">Employee ID</th>
                                        <th class="p-3">Department</th>
                                        <th class="p-3">Designation</th>
                                        <th class="p-3">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($staffs as $staff)
                                        <tr class="border-b border-gray-200 dark:border-gray-700">
                                            <td class="py-3 px-1">{{ $loop->iteration }}</td>
                                            <td class="py-3 px-1">{{ $staff->user->name }}</td>
                                            <td class="py-3 px-1">{{ $staff->employee_id }}</td>
                                            <td class="py-3 px-1">{{ $staff->department?->name ?? 'N/A'}}</td>
                                            <td class="py-3 px-1">{{ $staff->designation}}</td>
                                            <td class="py-3 px-1 flex gap-3 justify-center">
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

                        <!-- Assign Course -->
                        <div x-show="tab==='assign'">
                            <div class="w-full bg-white dark:bg-gray-800 shadow sm:rounded-lg p-4">
                                <form method="POST" action="{{ route('staffs.set-course',$staff) }}" class="grid grid-cols-3 gap-4">
                                    @csrf
                                    <!-- Name -->
                                    <div class="mb-4 col-span-1">
                                        <x-input-label for="name" :value="__('Name')" />
                                        <x-text-input id="name" type="text" 
                                                    class="mt-1 block w-full"
                                                    value="{{ old('name',$staff->user->name) }}" readonly/>
                                        <input type="hidden" name="id" value="{{ $staff->id }}">
                                    </div>
                                    
                                    <!-- Employee Id -->
                                    <div class="mb-4 col-span-1">
                                        <x-input-label for="name" :value="__('Emoployee ID')" />
                                        <x-text-input id="employee_id" type="text"
                                                    class="mt-1 block w-full"
                                                    value="{{ old('employee_id',$staff->employee_id) }}" readonly />
                                        <x-input-error :messages="$errors->get('employee_id')" class="mt-2" />
                                    </div>


                                    <!-- Department -->
                                    <div class="mb-4 col-span-1">
                                        <x-input-label for="department_id" :value="__('Department')" />
                                        
                                        <select id="department" class="block w-full mt-1  shadow-sm rounded-md
                                                                            border-gray-300 dark:border-gray-700 
                                                                            dark:bg-gray-900 dark:text-gray-300 
                                                                            focus:border-indigo-500 dark:focus:border-indigo-600 
                                                                            focus:ring-indigo-500 dark:focus:ring-indigo-600">
                                            <option value="">-- Select Department --</option>
                                            @foreach ($departments as $dept)
                                                <option value="{{ $dept->id }}" @selected(old('department_id',$staff->department_id)==$dept->id)>{{ $dept->name }}</option>
                                            @endforeach
                                        </select> 
                                        <x-input-error :messages="$errors->get('department_id')" class="mt-2" />
                                    </div>
                                    
                                    <!-- Program -->
                                    <div class="mb-4">
                                        <x-input-label for="program_id" :value="__('Program')" />
                                        <select  id="programs" class="block w-full mt-1  shadow-sm rounded-md
                                                                                border-gray-300 dark:border-gray-700 
                                                                                dark:bg-gray-900 dark:text-gray-300 
                                                                                focus:border-indigo-500 dark:focus:border-indigo-600 
                                                                                focus:ring-indigo-500 dark:focus:ring-indigo-600">
                                            <option value="">-- Select Program --</option> 
                                        </select>
                                        <x-input-error :messages="$errors->get('program_id')" class="mt-2" />
                                    </div>

                                    <!-- Course -->
                                    <div class="mb-4 col-span-1">
                                        <x-input-label for="course_id" :value="__('Course')" />
                                        <select name="course_id" id="courses" class="block w-full mt-1  shadow-sm rounded-md
                                                                            border-gray-300 dark:border-gray-700 
                                                                            dark:bg-gray-900 dark:text-gray-300 
                                                                            focus:border-indigo-500 dark:focus:border-indigo-600 
                                                                            focus:ring-indigo-500 dark:focus:ring-indigo-600">
                                            <option value="">-- Select Course --</option>
                                        </select> 
                                    </div>

                                    
                                    <div class="col-span-3 mt-6 flex gap-3">
                                        <a href="javascript:history.back()"
                                        class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded">
                                            <span>{{ __('Back') }}</span>
                                        </a>
                                        <x-primary-button>{{ __('Update') }}</x-primary-button>
                                    </div>
                                </form>
                            </div>
                                
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
