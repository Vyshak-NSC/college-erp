<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Students') }}
        </h2>
    </x-slot>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form id="department-filter" method="GET" class="grid grid-cols-3 gap-4 mb-4 p-2">
                        <!-- Department -->
                        <div class="mb-4 col-span-1">
                            <x-input-label for="department_id" :value="__('Department')" />
                            
                            <select id="department" class="block w-full mt-2  shadow-sm rounded-md 
                                                                border-gray-300 dark:border-gray-700 
                                                                dark:bg-gray-900 dark:text-gray-300 
                                                                focus:border-indigo-500 dark:focus:border-indigo-600 
                                                                focus:ring-indigo-500 dark:focus:ring-indigo-600">
                                <option value="">-- Select Department --</option>
                                @foreach ($departments as $dept)
                                    <option value="{{ $dept->id }}" @selected(old('department_id')==$dept->id)>{{ $dept->name }}</option>
                                @endforeach
                            </select> 
                            <x-input-error :messages="$errors->get('department_id')" class="mt-2" />
                        </div>
                        
                        <!-- Program -->
                        <div class="mb-4 col-span-1">
                            <x-input-label for="program_id" :value="__('Program')" />
                            <select  id="programs" name="program" class="block w-full mt-2  shadow-sm rounded-md
                                                                    border-gray-300 dark:border-gray-700 
                                                                    dark:bg-gray-900 dark:text-gray-300 
                                                                    focus:border-indigo-500 dark:focus:border-indigo-600 
                                                                    focus:ring-indigo-500 dark:focus:ring-indigo-600">
                                <option value="">-- Select Program --</option> 
                            </select>
                            <x-input-error :messages="$errors->get('program_id')" class="mt-2" />
                        </div>
                        
                        <!-- Semester -->
                        <div class="mb-4 col-span-1">
                            <x-input-label for="program_id" :value="__('Semester')" />
                            <select  id="semesters" name="semester" class="block w-full mt-2  shadow-sm rounded-md
                                                                    border-gray-300 dark:border-gray-700 
                                                                    dark:bg-gray-900 dark:text-gray-300 
                                                                    focus:border-indigo-500 dark:focus:border-indigo-600 
                                                                    focus:ring-indigo-500 dark:focus:ring-indigo-600">
                                <option value="">-- Select Semester --</option> 
                            </select>
                            <x-input-error :messages="$errors->get('semester')" class="mt-2" />
                        </div>

                        <div class="col-span-3 flex gap-3">
                            <x-primary-button>{{ __('Submit') }}</x-primary-button>
                        </div>
                    </form>

                    <div id="data" class="">
                       
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    const PROGRAMS = @json($departments->pluck('programs')->flatten());
    $(document).ready(function(){

        const url = "{{ route('students.index') }}"
        
        function getFilters(){
            return {
                department : $('#department').val(),
                program : $('#programs').val(),
                semester : $('#semesters').val(),
                per_page : $('#per_page').val() || 10
            };
        }

        function fetchStudents(params){
            axios.get(url, {params})
                .then(res => $('#data').html(res.data));
        }

        // get prior search query params if any 
        const params = Object.fromEntries(new URLSearchParams(window.location.search));
        if(Object.keys(params).length){
            // if param exist, refetch it
            fetchStudents(params);
        }

        let filterForm = $('#department-filter')
        // get student list for selected program
        filterForm.on('submit',function(e){
            e.preventDefault()
            let filters = getFilters();
            
            history.pushState({},'',`${url}?${$.param(filters)}`);
            fetchStudents(filters);
        })

        $('#data').on('click','a:not(.no-ajax)',function(e){
            const targetUrl = $(this).attr('href');
            e.preventDefault();

            const filters = getFilters();
            history.pushState({},'',`${targetUrl}?${$.param(filters)}`);
            fetchStudents(filters);
        })
    
        $(document).on('change', '#per_page',()=>{
            let filters = getFilters();
            delete filters.page
            history.pushState({},'', `${url}&${$.param(filters)}`)
            fetchStudents(filters)
        });

        $('#department').change(function(){
            let dept_id = parseInt($(this).val());
            let program_select = $('#programs');
            let program_list = PROGRAMS.filter(program => program.department_id === dept_id);

            program_select.empty().append('<option value="">-- Select Program --</option> ')

            $.each(program_list,(index,program) =>{
                program_select.append(`
                    <option value='${program.id}' data-total-semesters=${program.total_semesters}>${program.name}</option> 
                `)
            })
            
        })
        $('#programs').change(function(){
            let sem_count = $(this).find(':selected').data('total-semesters')
            $('#semesters').empty().append(`<option value=''>-- Select Semester --</option>`)
            for(let i=1; i<sem_count+1; i++){
                $('#semesters').append(`<option value='${i}' >${i}</option>`)
            };
        })
    });
</script>