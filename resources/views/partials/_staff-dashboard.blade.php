<div class="grid gap-4 grid-cols-4 grid-row-2 h-fit">

    <!-- Details -->
    <div class="relative col-span-2 row-span-1 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">
            <h3 class="text-2xl font-bold mb-4 mt-4">{{ $staff->user->name }}</h3>
            <div class="grid grid-cols-4 gap-y-2 gap-x-2">
                <span class="col-span-1 font-semibold ml-5">{{ __('Employee ID:') }}</span>
                <span class="col-span-3">: {{ $staff->employee_id }}</span>

                <span class="col-span-1 font-semibold ml-5">{{ __('Department:') }}</span>
                <span class="col-span-3">: {{ $staff->department?->name }}</span>
                
                <span class="col-span-1 font-semibold ml-5">{{ __('Designation:') }}</span>
                <span class="col-span-3">: {{ $staff->designation }}</span>
                
                <span class="col-span-1 font-semibold ml-5">Email</span>
                <span class="col-span-3">: {{ $staff->user->email }}</span>

                <span class="col-span-1 font-semibold ml-5">{{ __('Hire Date:') }}</span>
                <span class="col-span-3">: {{ $staff->hire_date }}</span>
            </div>
            @can('edit-profile-staff', $staff) 
                <a class="bg-blue-600 rounded px-2 py-2 absolute bottom-4 right-4" href="{{ route('staff.edit', $staff) }}" >Edit Profile</a>
            @endcan    
        </div>
    </div>

    <!-- Announcements -->
    <div class="col-span-2 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">
            <h3 class="text-2xl font-bold mb-4 mt-4">Announcements</h3>
            <div class="flex relative h-40 justify-center items-center text-2xl font-bold text-gray-400">
                No Announcements
            </div>
        </div>
    </div>
    
    <!-- Course Completion -->
    <div class="col-span-3 flex-wrap bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">
            <h3 class="text-2xl font-bold mb-4 mt-4">Course Completion</h3>
            <div id="course-progress" class="flex flex-wrap relative min-h-40 justify-between">
                <!-- Course chart here -->
            </div>
        </div>
    </div>
    <div class="col-span-1 row-span-1 flex-wrap bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">
            <h3 class="text-2xl font-bold mb-4 mt-4">Alerts</h3>
            <div id="course-progress" class="flex flex-wrap relative min-h-40 justify-between">
                
            </div>
        </div>
    </div>
</div>


<script>
    // Wait for the page to be ready
    document.addEventListener('DOMContentLoaded', (event) => {
        let courseProgress = $('#course-progress');
        let courseNames = @json($staff->courses);

        if(!courseNames.length){
            courseProgress.html('<p class="w-full top-[45%] flex justify-center items-center text-gray-400 font-bold">No Courses</p>')
        }
        courseNames.forEach(course => {
            const wrapper = document.createElement('div');
            wrapper.className = 'responsive h-40 relative mt-5'
            wrapper.style.minHeight = '160px';
            wrapper.style.minWidth = '160px';

            const canvas = document.createElement('canvas');
            const progress = document.createElement('p');
            progress.textContent = course.id + "%";
            progress.className = "absolute top-[40%] -translate-y-1/2 left-1/2 -translate-x-1/2 font-bold text-gray-400"

            createChart(canvas, [course.name], [course.id, 100-course.id],false)

            wrapper.appendChild(canvas);
            wrapper.appendChild(progress);
            courseProgress.append(wrapper);
        });

        function createChart(container ,labels, graphData, showLegend=true, type='doughnut'){
            new Chart(container, {
                type: type,
                data: {
                    // slice name
                    labels: labels,
                    datasets: [{
                        // slice size, data set
                        data: graphData,
                        backgroundColor: ['rgba(75, 192, 192, 0.8)','transparent'],
                        borderRadius: 10,
                        borderWidth:0,
                        }
                    ]
                },
                options: {
                    cutout:50,
                    responsive: true,
                    plugins: {
                        legend: {
                            display: showLegend,
                            position: 'bottom',
                            labels: { color: '#AAA' }
                        },

                        title: {
                            display:!showLegend,
                            text: labels[0],
                            position:'bottom',
                            font:{ size: 12},
                        },

                        tooltip: {
                            enabled:false,
                            // usePointStyle: true,
                            // boxWidth: 8,
                            // boxHeight: 8,
                        }
                    }
                }
            });
        }
    });
</script>