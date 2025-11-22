<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Students') }}
        </h2>
    </x-slot>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <!-- <div class="mb-4 p-3 rounded bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200"> -->
                <div
                    x-data="{ show: true }"
                    x-show="show"
                    x-init="setTimeout(() => show = false, 3000)"
                    class="mb-4 p-3 bg-green-600/80 rounded bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200">
                    {{ session('success') }}
                </div>
            @endif
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form id="department-filter" method="GET" class="grid grid-cols-3 gap-4 p-2">
                        <!-- Department -->
                        <div class="col-span-1">
                            <x-input-label for="department_id" :value="__('Department')" />
                            <select id="department"
                                    class="block w-full mt-2  shadow-sm rounded-md 
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
                                @for ($i=1; $i<=8;$i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                            <x-input-error :messages="$errors->get('semester')" class="mt-2" />
                        </div>

                        <div class="col-span-3 flex gap-3 justify-end">
                            <x-primary-button class="my-auto" id="get-all">{{ __('All') }}</x-primary-button>
                            <div class="relative">
                            <label class="absolute text-gray-500 -top-5">Search :</label>
                                <x-text-input  id="search" name="search" class="my-1"/>
                            </div>
                        </div>
                    </form>

                    <div id="data">
                       
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    const PROGRAMS = @json($departments->pluck('programs')->flatten());
    $(document).ready(function(){
        let countSelected = $('input[name="select[]"]:checked').length
        
        
        // ========== begin helper functions ==========
        const url = "{{ route('students.index') }}" 
        
        function getFilters(){
            return {
                department : $('#department').val(),
                program : $('#programs').val(),
                semester : $('#semesters').val(),
                per_page : $('#per_page').val() || 10,
                search  : $('#search').val()
            };
        }
        
        // get the student from url
        function fetchStudents(params=[], targeturl = url){
            axios.get(targeturl, {params})
                .then(res => $('#data').html(res.data));
        }

        // get prior search query params if any 
        const params = Object.fromEntries(new URLSearchParams(window.location.search));
        if(Object.keys(params).length){
            // if param exist, refetch it
            // allows refecth if returned to page or refreshed
            fetchStudents(params);
        }


        // ========== end helper | begin filter handler ==========
        $(document).on('click','#get-all', function(e){
            e.preventDefault();
            fetchStudents();
        })
        let filterForm = $('#department-filter')
        // fetch filtered student list on submit
        filterForm.on('change',function(e){
            e.preventDefault()
            let filters = getFilters();
            
            fetchStudents(filters);
        })

        $('#data').on('click','a:not(.no-ajax)',function(e){
            // get paginated url
            const href = $(this).attr('href');
            e.preventDefault();
            // get prior params
            let filters = getFilters();

            fetchStudents(filters, href);
        })
    
        // check for pagination size changes
        $(document).on('change', '#per_page',()=>{
            let filters = getFilters();
            // reset current page to 1
            delete filters.page
            const separator = url.includes('?') ? '&' : '?'
            fetchStudents(filters)
        });

        $('#search').on('input', () => {
            $search_query = $('#search').val();
            let filters = getFilters();
            filters = {...filters, search:$search_query};
            fetchStudents(filters);
        })


        // ========== end filter handler | begin dropdown handler ==========

        // set program list for department
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
        // ========== end dropdown handler | begin bulk delete handler ==========

        // check all checkboxes
        $(document).on('click', '#select-all', function () {
            const checked = $(this).prop('checked');
            // if(checked){
                $('input[name="select[]"]').prop('checked', checked).trigger('change');
            // }
        });

        $(document).on('change','input[name="select[]"]', function(){
            countSelected = $('input[name="select[]"]:checked').length;
            if(countSelected < $('#per_page').val()){
                $('#select-all').prop('checked',false)
            }
            $('#delete').text(`Delete (${countSelected})`)
        })

        // enter select deletion
        $(document).on('click', '#bulk-delete', function(){
            if($('#delete').data('submit-ready')){
                $('#bulk-delete-form').submit()
            }else{
                $('#delete').data('submit-ready',true)
                $('.selector.hidden').removeClass('hidden');
                $('#delete')
                    .addClass('text-red-500')
                    .text(`Delete (${countSelected})`);
            }
        })
        // ========== end bulk delete handler ==========
    });
</script>
