<x-app-layout>
    <x-slot name="header">
        </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6 ...">
                <h3 class="text-2xl font-bold mb-6">{{ $department->name }}</h3>
                </div>

            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold">Programs Offered</h3>
                    
                    <a href="{{ route('programs.create') }}"
                       class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded">
                        Add New Program
                    </a>
                </div>

                <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse ($department->programs as $program)
                        <li class="py-3">
                            <h4 class="font-semibold">{{ $program->name }} ({{ $program->code }})</h4>
                            <p class="text-sm text-gray-500">{{ $program->total_semesters }} Semesters</p>
                        </li>
                    @empty
                        <li class="py-3 text-gray-500">
                            No programs have been added to this department yet.
                        </li>
                    @endforelse
                </ul>
            </div>

        </div>
    </div>
</x-app-layout>