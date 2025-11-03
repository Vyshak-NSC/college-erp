<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
            {{ __('Add staff') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">
                <form method="POST" action="{{ route('staffs.store') }}" class="grid grid-cols-3 gap-4">
                    @csrf
                    <input type="hidden" value="{{ request('_origin') }}" name="_origin">

                    <!-- Name -->
                    <div class="mb-4 col-span-1">
                        <x-input-label for="name" :value="__('Name')" />
                        <x-text-input id="name" name="name" type="text"
                                      class="mt-1 block w-full" required autofocus />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- Email -->
                    <div class="mb-4 col-span-1">
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" name="email" type="text"
                                      class="mt-1 block w-full" required autofocus />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>
                
                    <!-- Employee Id -->
                    <div class="mb-4 col-span-1">
                        <x-input-label for="employee_id" :value="__('Employee ID')" />
                        <x-text-input id="employee_id" name="employee_id" type="text"
                                      class="mt-1 block w-full" required autofocus />
                        <x-input-error :messages="$errors->get('employee_id')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div class="mb-4 col-span-1">
                        <x-input-label for="password" :value="__('Password')" />
                        <x-text-input id="password" name="password" type="password"
                                      class="mt-1 block w-full" required autofocus />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>
                    
                    <div class="mb-4 col-span-1">
                        <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                        <x-text-input id="password_confirmation" name="password_confirmation" type="password"
                                      class="mt-1 block w-full" required autofocus />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>
                    
                    <!-- Designation -->
                    <div class="mb-4 col-span-1">
                        <x-input-label for="designation" :value="__('Designation')" />
                        <x-text-input id="designation" name="designation" type="text"
                                      class="mt-1 block w-full" required autofocus />
                        <x-input-error :messages="$errors->get('designation')" class="mt-2" />
                    </div>
                    
                    <!-- Department -->
                    <div class="mb-4">
                        <x-input-label for="department_id" :value="__('Department')" />
                        <select id="department" name="department_id" class="block w-full mt-1  shadow-sm rounded-md
                                                                   border-gray-300 dark:border-gray-700 
                                                                   dark:bg-gray-900 dark:text-gray-300 
                                                                   focus:border-indigo-500 dark:focus:border-indigo-600 
                                                                   focus:ring-indigo-500 dark:focus:ring-indigo-600">
                            <option value="">--Select a Department--</option>
                            @foreach ($departments as $department)
                                <option value="{{ $department->id }}">
                                    {{ $department->name }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('department')" class="mt-2" />
                    </div>
                    
                    <!-- Program -->
                    <div class="mb-4">
                        <x-input-label for="program_id" :value="__('Program')" />
                        <select  id="programs" class="block w-full mt-1  shadow-sm rounded-md
                                                                   border-gray-300 dark:border-gray-700 
                                                                   dark:bg-gray-900 dark:text-gray-300 
                                                                   focus:border-indigo-500 dark:focus:border-indigo-600 
                                                                   focus:ring-indigo-500 dark:focus:ring-indigo-600">
                            <option value="">--Select a Program--</option> 
                        </select>
                        <x-input-error :messages="$errors->get('department')" class="mt-2" />
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
                            @foreach ($departments as $dept)
                                <option value="{{ $dept?->id }}">{{ $dept?->name }}</option>
                            @endforeach
                        </select> 
                    </div>

                    <!-- Hire Date -->
                    <div class="mb-4 col-span-1">
                        <x-input-label for="hire_date" :value="__('Hire Date')" />
                        <x-text-input id="hire_date" name="hire_date" type="date"
                                    class="mt-1 block w-full" />
                        <x-input-error :messages="$errors->get('hire_date')" class="mt-2" />
                    </div>

                    <div class="col-span-3 mt-6 flex gap-3">
                        <a href="javascript:history.back()"
                        class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded">
                            <span>{{ __('Cancel') }}</span>
                        </a>
                        <x-primary-button>{{ __('Save') }}</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>


<script>
    const PROGRAMS = @json($departments->pluck('programs')->flatten());
    
    $(document).ready(function () {
        // Set program list
        $('#department').change(function(){
            console.log(PROGRAMS)
            var dept_id = parseInt($(this).val());
            var program_select = $('#programs');
            var program_list = PROGRAMS.filter(program => program.department_id === dept_id);
            
            program_select.empty().append('<option value="">-- Select a Program --</option> ')
            $.each(program_list,(index,program) =>{
                program_select.append(`
                    <option value='${program.id}' data-total-semesters=${program.total_semesters} >${program.name}</option> 
                `)
            })
        })       
    })
</script>