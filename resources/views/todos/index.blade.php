<x-layout>
    
    @include('partials._search')

    <div class="lg:grid lg:grid-cols-1 gap-4 space-y-4 md:space-y-0 mx-4">        
        @auth
            <header>
                <a href="/todos/create"
                    class="left right-10 bg-red-600 text-white py-2 px-5 rounded"
                    >New Task
                </a>                
                <span class="float-right"> FILTERS: 
                    <ul class="inline">
                        <li class="inline bg-black text-white py-2 px-5 ml-2 rounded">
                            <a href="{{ url()->current() }}/?owner=my">My Tasks</a>
                        </li>
                        <li class="inline bg-black text-white py-2 px-5 ml-2 rounded">
                            <a href="{{ url()->current() }}/?owner=myshared">My Shared</a>
                        </li>
                        <li class="inline bg-black text-white py-2 px-5 ml-2 rounded">
                            <a href="{{ url()->current() }}/?owner=sharedme">Shared with me</a>
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
                        <th class="p-4 text-left">Task Name</th>
                        <th class="p-4 text-left">Shared To</th>
                        <th class="p-4 text-left">Category</th>
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
                                <a href="/todos/{{ $todo->id }}/edit" class="text-blue-400 px-6 py-2 rounded-xl">
                                    <i class="fa-solid fa-pen-to-square"></i> Edit
                                </a>
                                <a href="/todos/{{ $todo->id }}/share" class="text-green-600 px-6 py-2 rounded-xl">
                                    <i class="fa-solid fa-share-nodes"></i> Share
                                </a>
                                <form class="inline" method="POST" action="/todos/{{ $todo->id }}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-600"><i class="fa-solid fa-trash-can"></i> Delete</button>
                                </form>
                            @endcan 
                        </x-todo-td>
                    </tr>
                    @endforeach
                </tbody>
            </table>  
        @else
            <p>No tasks found!</p>
        @endif    
    </div>

    <div class="mt-6 p-4">
        {{ $todos->links() }}
    </div>
</x-layout>