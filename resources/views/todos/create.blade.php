<x-layout>
    <x-card class="p-10 max-w-lg mx-auto mt-24">
        <header class="text-center">
            <h2 class="text-2xl font-bold uppercase mb-1">
                {{ __('messages.task_create') }}
            </h2>
        </header>

        <form method="POST" action="/todos/store">
            @csrf
            <div class="mb-6">
                <label for="name" class="inline-block text-lg mb-2">{{ __('messages.task_name') }}</label>
                <input class="border border-gray-200 rounded p-2 w-full"
                    type="text" name="name" value="{{ old('name') }}"
                />
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>                    
                @enderror
            </div>
                            
            <div class="mb-6">
                <label for="category_id" class="inline-block text-lg mb-2">{{ __('messages.task_category') }}</label>                
                <select class="border border-gray-200 rounded p-2.5 w-full focus:ring-blue-500 focus:border-blue-500"
                        id="category_id" name="category_id">                    
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>
                            {{ $category->name }}
                        </option>    
                    @endforeach                    
                </select>
                
                @error('category_id')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>                    
                @enderror
            </div>

            <div class="mb-6">
                <label for="description" class="inline-block text-lg mb-2">
                    {{ __('messages.task_description') }}
                </label>
                <textarea class="border border-gray-200 rounded p-2 w-full"
                        name="description" rows="10">{{ old('description') }}</textarea>

                @error('description')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>                    
                @enderror
            </div>

            <div class="mb-6">
                <button class="bg-myblue text-white rounded py-2 px-4 hover:bg-black">
                    {{ __('messages.create') }}
                </button>
                <a href="/" class="text-black ml-4"> {{ __('messages.back') }} </a>
            </div>
        </form>
    </x-card>
</x-layout>    