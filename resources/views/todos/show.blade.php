<x-layout>
    <a href="{{ url()->previous() }}" class="inline-block text-black ml-4 mb-4"
        ><i class="fa-solid fa-arrow-left"></i> Back
    </a>
    <div class="mx-4">        
        <x-card class="p-10">
            <div
                class="flex flex-col items-center justify-center text-center"
            >
                <img
                    class="w-48 mr-6 mb-6"
                    src="images/acme.png"
                    alt=""
                />                
                <h3 class="text-2xl mb-2 font-bold">{{ $todo->name }}</h3>
                <x-todo-category :category="$todo->category" class="text-xl font-bold mb-4"/>
                @php
                    $shared_users = $todo->shared_users()->get();
                @endphp
                @if ($shared_users ?? false)
                    <div class="inline">
                        @foreach ($shared_users as $sUser)
                            <span>
                                <i class="fa-solid fa-user text-green-600"></i> {{ $sUser->name }}
                            </span>
                        @endforeach
                    </div>    
                @endif              
                
                <div>                    
                </div>
                <div class="border border-gray-200 w-full my-6 text-lg space-y-6">
                    <p>
                        {{ $todo->description }}
                    </p>                        
                </div>

            </div>
        </x-card>
        @can('update-todo', $todo)
            <x-card class="x-card mt-4 p-2 flex space-x-6">
                <a href="/todos/{{ $todo->id }}/edit" class="text-blue-400 px-6 py-2 rounded-xl">
                    <i class="fa-solid fa-pen-to-square"></i> Edit
                </a>
                <a href="/todos/{{ $todo->id }}/share" class="text-green-600 px-6 py-2 rounded-xl">
                    <i class="fa-solid fa-share-nodes"></i> Share
                </a>
                <form method="POST" action="/todos/{{ $todo->id }}" class="">
                    @csrf
                    @method('DELETE')
                    <button class="text-red-500 px-6 py-2 rounded-xl"><i class="fa-solid fa-trash"></i>
                        Delete
                    </button>
                </form>
            </x-card>
        @endcan        
    </div>
</x-layout>