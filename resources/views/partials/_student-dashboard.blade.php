<div class="grid gap-4 grid-cols-2 grid-row-2 h-fit">

    <!-- Details -->
    <div class="col-span-1 row-span-1 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div  class="p-6 text-gray-900 dark:text-gray-100">
            <h3 class="text-2xl font-bold mt-4">{{ $user->name }}</h3>
            <div class="text-gray-500 font-semibold mb-4 text-sm">
                Department: {{ $user->student->department->name }}
            </div>
            <div class="grid grid-cols-3 gap-y-2">
                <span class="col-span-1 font-semibold ml-2">{{ __('Register No.:') }}</span>
                <span class="col-span-2">: {{ $user->student?->reg_no }}</span>
                
                <span class="col-span-1 font-semibold ml-2">{{ __('Admission Date:') }}</span>
                <span class="col-span-2">: {{ $user->student->admission_date }}</span>
                
                <span class="col-span-1 font-semibold ml-2">{{ __('Email:') }}</span>
                <span class="col-span-2 break-all">: {{ $user->email}}</span>
                
                <span class="col-span-1 font-semibold ml-2">{{ __('Program:') }}</span>
                <span class="col-span-2">: {{ $user->student->program?->name }}</span>
                
                <span class="col-span-1 font-semibold ml-2">{{ __('Semester:') }}</span>
                <span class="col-span-2">: {{ $user->student->semester }}</span>
            </div>
        </div>
    </div>


    <!-- Attendance -->
    <div class="flex col-span-1 row-span-2 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="w-full flex flex-col justify-between p-6 text-gray-900 dark:text-gray-100">
            <div class="flex justify-between">
                <h3 class="text-2xl font-bold mt-4">Attendance</h3>
                <select id="semesters" name="semesters" class="block mt-2  shadow-sm rounded-md h-10 w-auto text-xs
                                                                        border-gray-300 dark:border-gray-700 
                                                                        dark:bg-gray-900 dark:text-gray-300 
                                                                        focus:border-indigo-500 dark:focus:border-indigo-600 
                                                                        focus:ring-indigo-500 dark:focus:ring-indigo-600">
                    <option>-- Semester --</option>
                    @for ($i=1; $i<=$user->student->program->total_semesters; $i++)
                        <option value="{{ $i }}" {{ $user->student->semester == $i ? 'selected':'' }}>{{ $i }}</option>
                    @endfor
                </select>
            </div>
            <div class="box-border relative mx-auto max-w-xs dark:bg-gray-800 rounded-lg shadow">
                <canvas id="attendanceChart"></canvas>
            </div>
            <div class="w-full">
                <div class="text-gray-500 font-semibold mb-4 text-sm grid grid-cols-3 w-full">
                    <p class="col-span-1 text-gray-400">Code:</p>
                    <p class="col-span-1 text-gray-400">Courses:</p>
                    <p class="col-span-1 text-gray-400">Attendance:</p>
                    @foreach ($user->student->courses as $course)
                        <p class="col-span-1">{{ $course->code }}</p>
                        <p class="col-span-1">{{ $course->name }}</p>
                        <p class="col-span-1">{{ $course->pivot->attendance }}</p>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Course -->
    <div class="col-span-1 row-span-1 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg w-full">
        <div class="p-6 text-gray-900 dark:text-gray-100">
            <h3 class="text-2xl font-bold m-2">Course Marks</h3>
            <div id="course-progress" class="gap-y-3 gap-x-2 w-full h-1/3 flex">
            </div>
        </div>
    </div>
</div>
<script>
    // Wait for the page to be ready
    document.addEventListener('DOMContentLoaded', (event) => {
        // Attendance chart
        // Get the canvas element by its ID
        const attendanceChart = $('#attendanceChart'); 
        
        // Course chart
        let courseNames = @json($user->student->courses);
        let courseProgress = $('#course-progress');
        
        // draw attendance chart
        createChart(attendanceChart, ['Present','Absent'],[80,20] )
        // draw course progress chart
        courseNames.forEach(course => {
            const canvasContainer = document.createElement('div');
            canvasContainer.classList.add('relative','w-40','h-40');

            let canvas = document.createElement('canvas');
            let marks = course.pivot.marks
            createChart(canvas, [course.name] ,[marks, 100-marks],false);
            
            canvasContainer.append(canvas)
            courseProgress.append(canvasContainer)
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
                        backgroundColor: [  
                            'rgba(75, 192, 192, 0.8)',
                            'rgba(255, 99, 132, 0.8)'
                        ],
                        borderColor: [
                            'rgba(75, 192, 192, 1)',
                            'rgba(255, 99, 132, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
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
                            usePointStyle: true,
                            boxWidth: 8,
                            boxHeight: 8,
                        }
                    }
                }
            });
        }
    });
</script>