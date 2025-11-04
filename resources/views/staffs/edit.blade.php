<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
            {{ __('Edit Staff') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">
                <form method="POST" action="{{ route('staffs.update', $staff) }}" class="grid grid-cols-3 gap-4">
                    @csrf
                    @method('PUT')

                    <!-- Name -->
                    <div class="mb-4 col-span-1">
                        <x-input-label for="name" :value="__('Name')" />
                        <x-text-input id="name" name="name" type="text"
                                      class="mt-1 block w-full"
                                      value="{{ old('name', $staff->user->name) }}" required />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>
                    
                    <!-- Email -->
                    <div class="mb-4 col-span-1">
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="emil" name="email" type="text"
                                      class="mt-1 block w-full"
                                      value="{{ old('email', $staff->user->email) }}" required />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>
                    
                    <!-- Employee Id -->
                    <div class="mb-4 col-span-1">
                        <x-input-label for="name" :value="__('Emoployee ID')" />
                        <x-text-input id="employee_id" name="employee_id" type="text"
                                      class="mt-1 block w-full"
                                      value="{{ old('employee_id', $staff->employee_id) }}" required />
                        <x-input-error :messages="$errors->get('employee_id')" class="mt-2" />
                    </div>


                    <!-- Department -->
                    <div class="mb-4 col-span-1">
                        <x-input-label for="department_id" :value="__('Department')" />
                        
                        <select name="department_id" id="department" class="block w-full mt-1  shadow-sm rounded-md
                                                            border-gray-300 dark:border-gray-700 
                                                            dark:bg-gray-900 dark:text-gray-300 
                                                            focus:border-indigo-500 dark:focus:border-indigo-600 
                                                            focus:ring-indigo-500 dark:focus:ring-indigo-600">
                            <option value="">-- Select Department --</option>
                            @foreach ($departments as $dept)
                                <option value="{{ $dept->id }}" @selected(old('department_id',$staff->department_id)==$dept->id)>{{ $dept->name }}</option>
                            @endforeach
                        </select> 
                        <x-input-error :messages="$errors->get('credits')" class="mt-2" />
                    </div>
                    
                    <!-- Program -->
                    <div class="mb-4">
                        <x-input-label for="program_id" :value="__('Program')" />
                        <select  id="programs" name="program_id" class="block w-full mt-1  shadow-sm rounded-md
                                                                   border-gray-300 dark:border-gray-700 
                                                                   dark:bg-gray-900 dark:text-gray-300 
                                                                   focus:border-indigo-500 dark:focus:border-indigo-600 
                                                                   focus:ring-indigo-500 dark:focus:ring-indigo-600">
                            <option value="">-- Select a Program --</option> 
                        </select>
                        <x-input-error :messages="$errors->get('department')" class="mt-2" />
                    </div>

                    <!-- Course -->
                    <div class="mb-4 col-span-1">
                        <x-input-label for="course_id" :value="__('Course')" />
                        <select id="courses" class="block w-full mt-1  shadow-sm rounded-md
                                                            border-gray-300 dark:border-gray-700 
                                                            dark:bg-gray-900 dark:text-gray-300 
                                                            focus:border-indigo-500 dark:focus:border-indigo-600 
                                                            focus:ring-indigo-500 dark:focus:ring-indigo-600">
                            <option value="">-- Select Course --</option>
                        </select> 
                    </div>

                    <!-- Designation -->
                    <div class="mb-4 col-span-1">
                        <x-input-label for="designation" :value="__('Designation')" />
                        <x-text-input id="designation" name="designation" type="text"
                                      class="mt-1 block w-full"
                                      value="{{ old('designation', $staff->designation) }}" required />
                        <x-input-error :messages="$errors->get('designation')" class="mt-2" />
                    </div>
                    
                    <!-- Hire Date -->
                   <div class="mb-4 col-span-1">
                        <x-input-label for="hire_date" :value="__('Hire Date')" />
                        <x-text-input id="hire_date" name="hire_date" type="date"
                                    class="mt-1 block w-full" :value="old('hire_date', $staff->hire_date)" />
                        <x-input-error :messages="$errors->get('hire_date')" class="mt-2" />
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
</x-app-layout>

<script>
    const PROGRAMS = @json($departments->pluck('programs')->flatten());
    const CURR_DEPT = {{ $staff->department->id }}
    const CURR_PROGRAM = {{ $staff->program_id }}
    
    $(document).ready(function () {
        console.log(CURR_PROGRAM)
        // Set program list
        $('#department').change(function(){
            var dept_id = parseInt($(this).val());
            var program_select = $('#programs');
            var program_list = PROGRAMS.filter(program => program.department_id === dept_id);
            
            program_select.empty().append('<option value="">-- Select Program --</option> ')
            $.each(program_list,(index,program) =>{
                program_select.append(`
                    <option value='${program.id}'>${program.name}</option> 
                `)
            })
        })

        // Set semester limit
        $('#programs').change(function(){
            let courses = $(this).find(':selected');
            let course_options = $('#courses')
            course_options.empty().append(`
                <option value="">-- Select Semester --</option>
            `);
            
        })

        $('#department').val(CURR_DEPT).trigger('change')
        $('#programs').val(CURR_PROGRAM).trigger('change') 
    })
</script>