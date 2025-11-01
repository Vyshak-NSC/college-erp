<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
            {{ __('Staff Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6 text-gray-900 dark:text-gray-100">
                
                <h3 class="text-2xl font-bold mb-4">{{ $staff->user->name }}</h3>

                <div class="grid grid-cols-3 gap-y-3 gap-x-2">
                    <span class="col-span-1 font-semibold">{{ __('Employee ID:') }}</span>
                    <span class="col-span-2">{{ $staff->employee_id }}</span>

                    <span class="col-span-1 font-semibold">{{ __('Department:') }}</span>
                    <span class="col-span-2">{{ $staff->department?->name }}</span>
                    
                    <span class="col-span-1 font-semibold">{{ __('Designation:') }}</span>
                    <span class="col-span-2">{{ $staff->designation }}</span>
                    
                    <span class="col-span-1 font-semibold">{{ __('Hire Date:') }}</span>
                    <span class="col-span-2">{{ $staff->hire_date }}</span>

                    <div class="col-span-3 mt-6 flex gap-3">
                        <a href="javascript:history.back()"
                        class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded">
                            <span>{{ __('Back') }}</span>
                        </a>

                        <a href="{{ route('staffs.edit', $staff) }}"
                        class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded">
                            <span>{{ __('Edit') }}</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
