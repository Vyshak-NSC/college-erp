<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
            {{ __('Course Details') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6 text-gray-900 dark:text-gray-100">
                
                <h3 class="text-2xl font-bold mb-4">{{ $course->name }}</h3>
                <div class="grid grid-cols-3 gap-y-3 gap-x-2">
                    <span class="col-span-1 font-semibold">{{ __('Code:') }}</span>
                    <span class="col-span-2">{{ $course->code }}</span>

                    <span class="col-span-1 font-semibold">{{ __('Program:') }}</span>
                    <span class="col-span-2">{{ $course->program->name }}</span>

                    <span class="col-span-1 font-semibold">{{ __('Department:') }}</span>
                    <span class="col-span-2">{{ $course->department->name }}</span>

                    <span class="col-span-1 font-semibold">{{ __('Semester:') }}</span>
                    <span class="col-span-2">{{ $course->semester }}</span>

                    <span class="col-span-1 font-semibold">{{ __('Credits:') }}</span>
                    <span class="col-span-2">{{ $course->credits }}</span>

                    @if($course->description)
                        <span class="col-span-1 font-semibold">{{ __('Description:') }}</span>
                        <span class="col-span-2">{{ $course->description }}</span>
                    @endif

                    <div class="col-span-3 mt-6 flex gap-3">
                        <a href="javascript:history.back()"
                        class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded">
                            <span>{{ __('Back') }}</span>
                        </a>

                        <a href="{{ route('courses.edit', $course) }}"
                        class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded">
                            <span>{{ __('Edit') }}</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
