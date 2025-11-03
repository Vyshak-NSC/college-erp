<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
            {{ __('Edit program') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">
                <form method="POST" action="{{ route('programs.update', $program) }}">
                    @csrf
                    @method('PUT')

                    <!-- Name -->
                    <div class="mb-4">
                        <x-input-label for="name" :value="__('Name')" />
                        <x-text-input id="name" name="name" type="text"
                                      class="mt-1 block w-full"
                                      value="{{ old('name', $program->name) }}" required />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- Code -->
                    <div class="mb-4">
                        <x-input-label for="code" :value="__('Code')" />
                        <x-text-input id="code" name="code" type="text"
                                      class="mt-1 block w-full"
                                      value="{{ old('code', $program->code) }}" required />
                        <x-input-error :messages="$errors->get('code')" class="mt-2" />
                    </div>
                    
                    <!-- Department -->
                    <div class="mb-4">
                        <x-input-label for="department_id" :value="__('Department')" />
                       <select name="department_id" id="department_id" class="block w-full mt-1  shadow-sm rounded-md
                                                                   border-gray-300 dark:border-gray-700 
                                                                   dark:bg-gray-900 dark:text-gray-300 
                                                                   focus:border-indigo-500 dark:focus:border-indigo-600 
                                                                   focus:ring-indigo-500 dark:focus:ring-indigo-600">
                            <option value="">-- Select Department --</option>
                            @foreach ($departments as $department)
                                <option value="{{ $department->id }}" @selected(old('department_id',$program->id)===$department->id)>
                                    {{ $department->name }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('department_id')" class="mt-2" />
                    </div>

                    <!-- Description -->
                    <div class="mb-4">
                        <x-input-label for="description" :value="__('Description')" />
                        <textarea id="description" name="description"
                                  class="mt-1 block w-full rounded-md border-gray-300
                                         dark:bg-gray-900 dark:text-gray-100">{{ old('description', $program->description) }}</textarea>
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
