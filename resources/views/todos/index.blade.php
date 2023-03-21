<x-layout>
    
    @include('partials._search')

    <div class="lg:grid lg:grid-cols-1 gap-4 space-y-4 md:space-y-0 mx-4">        
        @auth
            <header>
                <a href="/todos/create" class="left right-10 bg-red-600 text-white py-2 px-5 rounded">
                    {{ __('messages.new_task') }}
                </a>                
                <span class="float-right"> {{ __('messages.filters') }}: 
                    <ul class="inline">
                        <li class="inline bg-black text-white py-2 px-5 ml-2 rounded">
                            <a href="{{ url()->current() }}/?owner=my">{{ __('messages.my_tasks') }}</a>
                        </li>
                        <li class="inline bg-black text-white py-2 px-5 ml-2 rounded">
                            <a href="{{ url()->current() }}/?owner=myshared">{{ __('messages.my_shared') }}</a>
                        </li>
                        <li class="inline bg-black text-white py-2 px-5 ml-2 rounded">
                            <a href="{{ url()->current() }}/?owner=sharedme">{{ __('messages.shared_me') }}</a>
                        </li>
                    </ul>
                </span>
            </header>
        @endauth                    
        @if(count($todos) > 0)            
            <table class="w-full table-auto rounded-sm">
                <thead>
                    <tr class="bg-myblue text-white font-bold">                    
                        <th class="p-4 text-left">#</th>
                        <th class="p-4 text-left">{{ __('messages.task_name') }}</th>
                        <th class="p-4 text-left">{{ __('messages.shared_to') }}</th>
                        <th class="p-4 text-left">{{ __('messages.category') }}</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($todos as $todo)                                    
                    <tr class="border-gray-300">
                        <x-todo-td>
                            {{ $todo->id }}
                        </x-todo-td>
                        <x-todo-td>
                            <a href="/todos/{{ $todo->id }}">{{ $todo->name }}</a>
                        </x-todo-td>
                        <x-todo-td>
                            @foreach ($todo->shared_users()->get() as $sUser)
                                <span data-toggle="tooltip" title="{{ $sUser->name }}">
                                    <i class="fa-solid fa-user text-green-600"></i>
                                </span>
                            @endforeach
                        </x-todo-td>
                        <x-todo-td>
                            <x-todo-category :category="$todo->category" :with_filter="true" />
                            
                        </x-todo-td>
                        <x-todo-td>
                            @can('update-todo', $todo)
                                <a href="/todos/{{ $todo->id }}/edit" class="text-blue-400 pr-6 py-2 rounded-xl">
                                    <i class="fa-solid fa-pen-to-square"></i> {{ __('messages.action_edit') }}
                                </a>
                                <a href="/todos/{{ $todo->id }}/share" class="text-green-600 px-6 py-2 rounded-xl">
                                    <i class="fa-solid fa-share-nodes"></i> {{ __('messages.action_share') }}
                                </a>
                                <form class="inline" method="POST" action="/todos/{{ $todo->id }}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-600"><i class="fa-solid fa-trash-can">
                                        </i> {{ __('messages.action_delete') }}
                                    </button>
                                </form>
                            @endcan 
                        </x-todo-td>
                    </tr>
                    @endforeach
                </tbody>
            </table>  
        @else
            <p>{{ __('messages.no_tasks_info') }}</p>
        @endif    
    </div>

    <div class="mt-6 p-4">
        {{ $todos->links() }}
    </div>
</x-layout>