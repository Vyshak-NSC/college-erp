<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Staff') }}
        </h2>
    </x-slot>

    <div class="py-6">
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
                            @can('assign-staff-course')
                                <nav class="-mb-px flex space-x-8 px-6" aria-label="Tabs">
                                    <button 
                                        @click="tab='staff'" 
                                        :class="{
                                            'border-blue-500 text-blue-600 dark:text-blue-400': tab === 'staff',
                                            'border-transparent text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-600': tab !== 'staff'
                                        }" 
                                        class="text-lg font-semibold" class="whitespace-nowrap py-4 px-1 border-b-2 text-sm">All Staff</button>
                                        
                                        
                                        <button 
                                        @click="tab='assign'" 
                                        :class="{
                                            'border-blue-500 text-blue-600 dark:text-blue-400': tab === 'assign',
                                            'border-transparent text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-600': tab !== 'assign'
                                        }"
                                        class="text-lg font-semibold" class="whitespace-nowrap py-4 px-1 border-b-2 text-sm">Assign course</button>
                                    </nav>
                                @else
                                    <h3 class="text-lg font-semibold">All Staff</h3>
                                @endcan
                            
                            @can('create-staff')
                                <a href="{{ route('staff.create') }}"
                                class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded">
                                    Add Staff
                                </a>
                            @endcan
                        </div>

                        <!-- All Staff -->
                        <div x-show="tab==='staff'">
                            @include('staff._staff-table-partial')
                        </div>

                        @can('assign-staff-course')
                        <!-- Assign Course -->
                            <div x-show="tab==='assign'">
                                <div class="w-full bg-white dark:bg-gray-800 shadow ">
                                    <form method="POST" action="{{ route('staff.set-course') }}" class="grid grid-cols-3 gap-4">
                                        @csrf
                                        <!-- Name -->
                                        <div class="mb-4 col-span-1">
                                            <x-input-label for="name" :value="__('Name')" />
                                            <select name="id" id="name" class="block w-full mt-1  shadow-sm rounded-md
                                                                border-gray-300 dark:border-gray-700 
                                                                dark:bg-gray-900 dark:text-gray-300 
                                                                focus:border-indigo-500 dark:focus:border-indigo-600 
                                                                focus:ring-indigo-500 dark:focus:ring-indigo-600">
                                            <option value="">-- Select Staff --</option>
                                            @foreach ($staffs as $staff)
                                                <option value="{{ $staff->id }}"
                                                        data-emp-id="{{ $staff->employee_id }}"
                                                        data-dept-id="{{ $staff->department_id }}"
                                                >
                                                    {{ $staff->user->name }}
                                                </option>
                                            @endforeach
                                        </select> 
                                        </div>
                                        
                                        <!-- Employee Id -->
                                        <div class="mb-4 col-span-1">
                                            <x-input-label for="name" :value="__('Emoployee ID')" />
                                            <x-text-input id="employee_id" type="text"
                                                        class="mt-1 block w-full"/>
                                            <x-input-error :messages="$errors->get('employee_id')" class="mt-2" />
                                        </div>


                                        <!-- Department -->
                                        <div class="mb-4 col-span-1">
                                            <x-input-label for="department" :value="__('Department')" />
                                            
                                            <select id="department" class="block w-full mt-1  shadow-sm rounded-md
                                                                                border-gray-300 dark:border-gray-700 
                                                                                dark:bg-gray-900 dark:text-gray-300 
                                                                                focus:border-indigo-500 dark:focus:border-indigo-600 
                                                                                focus:ring-indigo-500 dark:focus:ring-indigo-600">
                                                <option value="">-- Select Department --</option>
                                                @foreach ($departments as $dept)
                                                    <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                                                @endforeach
                                            </select> 
                                            <x-input-error :messages="$errors->get('department_id')" class="mt-2" />
                                        </div>
                                        
                                        <!-- Program -->
                                        <div class="mb-4">
                                            <x-input-label for="program" :value="__('Program')" />
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
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


<script>
    $(document).ready(()=>{
        $('#name').change(function(){
            let emp_id = $(this).find(':selected').data('emp-id');
            let dept_id = $(this).find(':selected').data('dept-id');
            $('#employee_id').val(emp_id)
            $('#department').val(dept_id);
        })

        $('#employee_id').on('input',function(){
            let emp_id = $(this).val();
            if(emp_id === '') {
                $('#name').val('');
                return;
            }
            let staff = $('#name option').filter(function(){
                return $(this).data('emp-id') === emp_id;
            });

            if(staff){
                $('#name').val(staff.val());
                $('#department').val(staff.data('dept-id'))
                $('#name option.no-match').remove();
            }else{
                $('#name option.no-match').remove();
                $('#name').append(`<option class="no-match" value="not-found">No Staff of ID: ${emp_id}</option>`);
                $('#name').val('not-found');
            }
        })



        const DEPTS = @json($departments);
        let oldProgram = "{{ old('program_id') }}";
        let oldDept = "{{ old('department_id') }}";
        
        
        // Set program list
        $('#department').change(function(){
            let dept_id = parseInt($(this).val());
            let program_select = $('#programs');
            const program_list = DEPTS.find(dept => dept.id == dept_id).programs;

            program_select.empty().append('<option value="">-- Select Program --</option> ')
            $.each(program_list,(index,program) =>{
                program_select.append(`
                    <option data-dept_id=${dept_id} value='${program.id}' ${oldProgram === program.id ? 'selected' : ''} >${program.name}</option> 
                `)
            })
        })

        // Set course list
        $('#programs').change(function(){
            let program_select = $(this).find(':selected');
            let program_id = program_select.val();
            let dept_id = program_select.data('dept_id');

            let course_select = $('#courses');
            let program = null;
            DEPTS.find(dept => dept.id == dept_id).programs.forEach(pgm => {
                if(pgm.id == program_id) program = pgm
            });;
            
            let course_list = program ? program.courses : ''

            course_select.empty().append(`<option value="">-- Select Course --</option>`);

            course_list.forEach(course => {
                course_select.append(`
                    <option value="${course.id}">${course.name}</option>
                `);
            });
            
        })
        
        if(oldDept){
            $('#department').val(oldDept).trigger('change');
        }
    })
</script>