<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
            {{ __('Edit Staff') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">
                <form method="POST" action="{{ route('students.update', $student) }}" class="grid grid-cols-3 gap-4">
                    @csrf
                    @method('PUT')

                    <!-- Name -->
                    <div class="mb-4 col-span-1">
                        <x-input-label for="name" :value="__('Name')" />
                        <x-text-input id="name" name="name" type="text"
                                      class="mt-1 block w-full"
                                      value="{{ old('name', $student->user->name) }}" required />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- Register No. -->
                    <div class="mb-4 col-span-1">
                        <x-input-label for="name" :value="__('Register No.')" />
                        <x-text-input id="reg_no" name="reg_no" type="text"
                                      class="mt-1 block w-full"
                                      value="{{ old('reg_no', $student->reg_no) }}" readonly />
                        <x-input-error :messages="$errors->get('reg_no')" class="mt-2" />
                    </div>
                    
                    <!-- Email -->
                    <div class="mb-4 col-span-1">
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="emil" name="email" type="text"
                                      class="mt-1 block w-full"
                                      value="{{ old('email', $student->user->email) }}" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
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
                                <option value="{{ $dept->id }}" @selected(old('department_id',$student->department->id)==$dept->id)>{{ $dept->name }}</option>
                            @endforeach
                        </select> 
                        <x-input-error :messages="$errors->get('credits')" class="mt-2" />
                    </div>

                    <!-- Programs -->
                    <div class="mb-4 col-span-1">
                        <x-input-label for="department_id" :value="__('Program')" />
                        
                        <select name="program_id" id="programs" class="block w-full mt-1  shadow-sm rounded-md
                                                            border-gray-300 dark:border-gray-700 
                                                            dark:bg-gray-900 dark:text-gray-300 
                                                            focus:border-indigo-500 dark:focus:border-indigo-600 
                                                            focus:ring-indigo-500 dark:focus:ring-indigo-600">
                            
                            <option>{{ $student->program->name }}</option>
                        </select>
                        <x-input-error :messages="$errors->get('credits')" class="mt-2" />
                    </div>

                    <!-- Semester -->
                    <div class="mb-4">
                        <x-input-label for="total_semesters" :value="__('Semesters')" />
                        <select name="semester" id="semester" class="block w-full mt-1  shadow-sm rounded-md
                                                                   border-gray-300 dark:border-gray-700 
                                                                   dark:bg-gray-900 dark:text-gray-300 
                                                                   focus:border-indigo-500 dark:focus:border-indigo-600 
                                                                   focus:ring-indigo-500 dark:focus:ring-indigo-600">
                            <option>{{ $student->semester }}</option>
                        </select>
                        <x-input-error :messages="$errors->get('semester')" class="mt-2" />
                    </div>

                    <!-- Admission Date -->
                    <div class="mb-4 col-span-1">
                        <x-input-label for="admission_date" :value="__('Admission Date')" />
                        <x-text-input id="admission_date" name="admission_date" type="text"
                                      class="mt-1 block w-full"
                                      value="{{ old('adminssion_date', $student->admission_date) }}" required />
                        <x-input-error :messages="$errors->get('admission_date')" class="mt-2" />
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
    $(document).ready(function(){
        
        // set program list
        $(document).on('change','#department',function(){
            let dept_id = parseInt($(this).val());
            let program_select = $('#programs');
            let program_list = PROGRAMS.filter(program => program.department_id === dept_id);

            program_select.empty().append('<option value="">-- Select Program --</option> ')

            $.each(program_list,(index,program) =>{
                let selected = program.id == {{ $student->program_id }} ? 'selected':''
                program_select.append(`
                    <option value='${program.id}' ${selected} data-total-semesters=${program.total_semesters}>${program.name}</option> 
                `)
            })
            $('#programs').val({{ $student->program_id }}).trigger('change');
        })
        // set semester limit
        $(document).on('change','#programs',function(){
            let sems = $(this).find(':selected').data('total-semesters');
            let sem_options = $('#semester')
            sem_options.empty().append(`
                <option value="">--Select Semester--</option>
            `);
            for(let i = 1; i< sems+1; i++){
                let selected = (i == {{ $student->semester }}) ? 'selected':'';
                sem_options.append(`
                    <option value="${i} "${selected}>${i}</option>
                `)
            }
        })
        $('#department').val({{ $student?->department?->id }}).trigger('change');
    })
</script>