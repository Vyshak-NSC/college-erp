<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
            {{ __('Edit Staff') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">
                <form method="POST" action="{{ route('staffs.set-course',$staff) }}" class="grid grid-cols-3 gap-4">
                    @csrf
                    <!-- Name -->
                    <div class="mb-4 col-span-1">
                        <x-input-label for="name" :value="__('Name')" />
                        <x-text-input id="name" value="{{ old('name',$staff->user->name) }}" readonly/>
                        <input type="hidden" name="staff_id" value="{{ $staff->id }}">
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
</x-app-layout>

<script>
    $(document).ready(()=>{
        $('#name').change(function(){
            let emp_id = $(this).val();
            $('#employee_id').val(emp_id)
        })

        $('#employee_id').on('input',function(){
            let emp_id = $(this).val();
            if(emp_id === '') {
                $('#name').val('');
                return;
            }
            let staff = $('#name option').filter(function(){
                return $(this).val()===emp_id;
            }).val();

            if(staff){
                $('#name').val(staff);
                $('#name option.no-match').remove();
            }else{
                $('#name option.no-match').remove();
                $('#name').append(`<option class="no-match" value="not-found">No Staff of ID: ${emp_id}</option>`);
                $('#name').val('not-found');
            }
        })
    

        
        const DEPTS = @json($departments);
        let oldDept = "{{ $staff->department_id }}";
        let oldProgram = "{{ $staff->program_id }}";
        
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

        // Set semester limit
        $('#programs').change(function(){
            let program_select = $(this).find(':selected');
            let program_id = program_select.val();
            let dept_id = program_select.data('dept_id');
            
            let course_select = $('#courses');
            let programs = null;
            DEPTS.find(dept => dept.id == dept_id).programs.forEach(pgm => {
                if(pgm.id = program_id) program = pgm
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