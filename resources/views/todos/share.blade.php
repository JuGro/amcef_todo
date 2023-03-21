<x-layout>
    <x-card class="p-10 max-w-lg mx-auto mt-24">
        <header class="text-center">
            <h2 class="text-2xl font-bold uppercase mb-1">
                Share Task - #{{ $todo->id }}
            </h2>
            <div class="font-bold">{{ $todo->name }}</div>
        </header>

        <form method="POST" action="/todos/{{ $todo->id }}/share">
            @csrf
            <div class="mb-6">
                <label for="shared_users" class="inline-block text-lg mb-2 mt-8">Select one or mulitple rows (= use Ctrl + click):</label>                                      
                <select id="shared_users[]" name="shared_users[]" multiple
                     class="border border-gray-200 rounded p-2.5 w-full focus:ring-blue-500 focus:border-blue-500"
                    >
                    <option value="0">[Nobody = No Sharing]</option>                  
                    @foreach ($users as $user)
                       <option value="{{ $user->id }}"
                            @selected($shared_users->where('user_id', $user->id)->count() > 0)>{{ $user->name }}</option>    
                    @endforeach                    
                </select>
                
                @error('shared_users')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>                    
                @enderror
            </div>                        

            <div class="mb-6">
                <button class="bg-myblue text-white rounded py-2 px-4 hover:bg-black">
                    Update Sharing
                </button>
                <a href="{{ url()->previous(); }}" class="text-black ml-4"> Back </a>
            </div>
        </form>
    </x-card>
</x-layout>    

