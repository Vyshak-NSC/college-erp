<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
            {{ __('Edit Course') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">
                <form method="POST" action="{{ route('courses.update', $course) }}">
                    @csrf
                    @method('PUT')

                    <!-- Name -->
                    <div class="mb-4">
                        <x-input-label for="name" :value="__('Name')" />
                        <x-text-input id="name" name="name" type="text"
                                      class="mt-1 block w-full"
                                      value="{{ old('name', $course->name) }}" required />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- Code -->
                    <div class="mb-4">
                        <x-input-label for="code" :value="__('Code')" />
                        <x-text-input id="code" name="code" type="text"
                                      class="mt-1 block w-full"
                                      value="{{ old('code', $course->code) }}" required />
                        <x-input-error :messages="$errors->get('code')" class="mt-2" />
                    </div>

                    <!-- Department -->
                    <div class="mb-4">
                        <x-input-label for="department" :value="__('Department')" />
                        <select name="department_id" id="department" class="block w-full mt-1  shadow-sm rounded-md
                                                                   border-gray-300 dark:border-gray-700 
                                                                   dark:bg-gray-900 dark:text-gray-300 
                                                                   focus:border-indigo-500 dark:focus:border-indigo-600 
                                                                   focus:ring-indigo-500 dark:focus:ring-indigo-600">
                            <option value="">-- Select a Department --</option>
                            @foreach ($departments as $department)
                                <option value="{{ $department->id }}" @selected(old('department_id',$course->department->id) === $department->id)>
                                    {{ $department->name }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('department')" class="mt-2" />
                    </div>

                    <!-- Program -->
                    <div class="mb-4">
                        <x-input-label for="program" :value="__('Program')" />
                        <select name="program_id" id="programs" class="block w-full mt-1  shadow-sm rounded-md
                                                                   border-gray-300 dark:border-gray-700 
                                                                   dark:bg-gray-900 dark:text-gray-300 
                                                                   focus:border-indigo-500 dark:focus:border-indigo-600 
                                                                   focus:ring-indigo-500 dark:focus:ring-indigo-600">
                            <option value="">-- Select a Program --</option>
                        </select>
                        <x-input-error :messages="$errors->get('program')" class="mt-2" />
                    </div>

                    <!-- Semester -->
                    <div class="mb-4">
                        <x-input-label for="semester" :value="__('Semester')" />
                        
                        <select name="semester" id="semester" class="block w-full mt-1  shadow-sm rounded-md
                                                            border-gray-300 dark:border-gray-700 
                                                            dark:bg-gray-900 dark:text-gray-300 
                                                            focus:border-indigo-500 dark:focus:border-indigo-600 
                                                            focus:ring-indigo-500 dark:focus:ring-indigo-600">
                            <option value="">--Select Semester--</option>
                            <option>{{ $course->program }}</option>
                        </select> 
                        <x-input-error :messages="$errors->get('semester')" class="mt-2" />
                    </div>

                    <!-- Credits -->
                    <div class="mb-4">
                        <x-input-label for="credits" :value="__('Credits')" />
                        
                        <select name="credits" id="credits" class="block w-full mt-1  shadow-sm rounded-md
                                                            border-gray-300 dark:border-gray-700 
                                                            dark:bg-gray-900 dark:text-gray-300 
                                                            focus:border-indigo-500 dark:focus:border-indigo-600 
                                                            focus:ring-indigo-500 dark:focus:ring-indigo-600">
                            <option value="3" @selected($course->credits===3)>3</option>
                            <option value="4" @selected($course->credits===4)>4</option>
                        </select> 
                        <x-input-error :messages="$errors->get('credits')" class="mt-2" />
                    </div>

                    <!-- Description -->
                    <div class="mb-4">
                        <x-input-label for="description" :value="__('Description')" />
                        <textarea id="description" name="description"
                                  class="mt-1 block w-full rounded-md border-gray-300
                                         dark:bg-gray-900 dark:text-gray-100">{{ old('description', $course->description) }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
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
    const CURR_DEPT = {{ $course->department->id }}
    const CURR_PROGRAM = {{ $course->program_id }}
    $(document).ready(function () {
        // Set program list
        $('#department').change(function(){
            let dept_id = parseInt($(this).val());
            let program_select = $('#programs');
            let program_list = PROGRAMS.filter(program => program.department_id === dept_id);

            program_select.empty().append('<option value="">--Select Program--</option> ')

            $.each(program_list,(index,program) =>{
                program_select.append(`
                    <option value='${program.id}' data-total-semesters=${program.total_semesters}>${program.name}</option> 
                `)
            })
        })

        // Set semester limit
        $('#programs').change(function(){
            let sems = $(this).find(':selected').data('total-semesters');
            let sem_options = $('#semester')
            sem_options.empty().append(`
                <option value="">--Select Semester--</option>
            `);
            for(let i = 1; i< sems+1; i++){
                sem_options.append(`
                    <option value="${i}" ${i === {{ $course->semester }} ? 'selected':''} >${i}</option>
                `)
            }
        })

        $('#department').val(CURR_DEPT).trigger('change')
        $('#programs').val(CURR_PROGRAM).trigger('change')        
    })
</script>