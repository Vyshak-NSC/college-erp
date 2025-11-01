<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
            {{ __('Department Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6 text-gray-900 dark:text-gray-100">
                
                <h3 class="text-2xl font-bold mb-4">{{ $department->name }}</h3>

                <div class="grid grid-cols-3 gap-y-3 gap-x-2">
                    <span class="col-span-1 font-semibold">{{ __('Code:') }}</span>
                    <span class="col-span-2">{{ $department->code }}</span>
                    
                    <span class="col-span-1 font-semibold">{{ __('Courses:') }}</span>
                    <div class="col-span-2 grid grid-cols-[auto_1fr] gap-x-4 gap-y-2">
                        @foreach ($department->courses as $course)
                            <span class="fotn-mono text-gray-500 dark:text-gray-400">{{ $course->code }}</span>
                            <span>{{ $course->name }}</span>
                        @endforeach
                    </div>
                    
                    @if($department->description)
                        <span class="col-span-1 font-semibold">{{ __('Description:') }}</span>
                        <span class="col-span-2">{{ $department->description }}</span>
                    @endif

                    <div class="col-span-3 mt-6 flex gap-3">
                        <a href="javascript:history.back()"
                        class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded">
                            <span>{{ __('Back') }}</span>
                        </a>

                        <a href="{{ route('departments.edit', $department) }}"
                        class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded">
                            <span>{{ __('Edit') }}</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
