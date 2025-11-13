<div  class="p-6 text-gray-900 dark:text-gray-100">
<div x-show="selectedTab === 'details'">
    <h3 class="text-2xl font-bold mb-4 mt-4">{{ $user->name }}</h3>
    <div class="grid grid-cols-4 gap-y-3 gap-x-2">
        <span class="col-span-1 font-semibold ml-5">{{ __('Employee ID:') }}</span>
        <span class="col-span-3">: {{ $user->employee_id }}</span>

        <span class="col-span-1 font-semibold ml-5">{{ __('Department:') }}</span>
        <span class="col-span-3">: {{ $user->department?->name }}</span>
        
        <span class="col-span-1 font-semibold ml-5">{{ __('Designation:') }}</span>
        <span class="col-span-3">: {{ $user->designation }}</span>
        
        <span class="col-span-1 font-semibold ml-5">{{ __('Hire Date:') }}</span>
        <span class="col-span-3">: {{ $user->hire_date }}</span>
    </div>
</div>