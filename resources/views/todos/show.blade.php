<x-layout>
    <a href="{{ url()->previous() }}" class="inline-block text-black ml-4 my-4"
        ><i class="fa-solid fa-arrow-left"></i> {{ __('messages.back') }}
    </a>
    <div class="mx-4">        
        <x-card class="p-10">
            <div class="flex flex-col items-center justify-center text-center">             
                <h3 class="text-2xl mb-2 font-bold {{ $todo->completed ? 'line-through' : '' }}">
                    {{ $todo->name }}
                    @if ($todo->completed)
                        <span data-toggle="tooltip" title="{{ __('messages.completed_info') }}">
                            <i class="fa-solid fa-check text-green-600 ml-2"></i>
                        </span>
                    @endif
                </h3>
                <x-todo-category :category="$todo->category" class="text-xl font-bold mb-4"/>
                @php
                    $shared_users = $todo->shared_users()->get();
                @endphp
                @if ($shared_users ?? false)
                    <div class="inline">
                        @foreach ($shared_users as $sUser)
                            <span>
                                <i class="fa-solid fa-user text-pink-500"></i> {{ $sUser->name }}
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
                @if($todo->completed)
                    <form class="inline" method="POST" action="/todos/{{ $todo->id }}/reopen">
                        @csrf                                        
                        <button class="text-gray-600 pr-6 py-2"><i class="fa-solid fa-rotate-left">
                            </i> {{ __('messages.action_reopen') }}
                        </button>
                    </form>
                @else
                    <form class="inline" method="POST" action="/todos/{{ $todo->id }}/complete">
                        @csrf                                        
                        <button class="text-green-600 pr-6 py-2"><i class="fa-solid fa-check">
                            </i> {{ __('messages.action_done') }}
                        </button>
                    </form>                                    
                @endif
                <a href="/todos/{{ $todo->id }}/edit" class="text-blue-400 pr-6 py-2 rounded-xl">
                    <i class="fa-solid fa-pen-to-square"></i> {{ __('messages.action_edit') }}
                </a>
                <a href="/todos/{{ $todo->id }}/share" class="text-pink-500 pr-6 py-2 rounded-xl">
                    <i class="fa-solid fa-share-nodes"></i> {{ __('messages.action_share') }}
                </a>
                <form method="POST" action="/todos/{{ $todo->id }}" class="">
                    @csrf
                    @method('DELETE')
                    <button class="text-red-500 pr-6 py-2 rounded-xl"><i class="fa-solid fa-trash"></i>
                        {{ __('messages.action_delete') }}
                    </button>
                </form>
            </x-card>
        @endcan        
    </div>
</x-layout>