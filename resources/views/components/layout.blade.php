<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>ToDos - Simple Tasks Manager</title>
        <link rel="icon" href="favicon.ico" />
        <link
            rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
            integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
            crossorigin="anonymous"
            referrerpolicy="no-referrer"
        />
        <script src="//unpkg.com/alpinejs" defer></script>
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        colors: {
                            myblue: "#7092BE",                            
                        },
                    },
                },
            };
        </script>
        <title>ToDos - Simple Tasks Manager</title>
    </head>
    <body class="mb-48">
        <nav class="flex justify-between items-center p-2 bg-black text-white">
            <a href="/"><img class="w-24" src="{{ asset('images/logo.svg') }}" alt="" class="'logo'"/></a>
            <h1 class="text-lg">ToDos - Simple Tasks Manager</h1>
            <ul class="flex space-x-6 mr-6 text-lg">
                @auth
                    <li>
                        <span class="font-bold text-red-600">{{ auth()->user()->name }}</span>
                    </li>
                    <li>                        
                        <form method="POST" action="/logout" class="inline">
                            @csrf
                            <button type="submit"><i class="fa-solid fa-door-open"></i> Logout</button>
                        </form>                        
                    </li>                    
                @else
                    <li>
                        <a href="/register" class="hover:text-myblue"
                            ><i class="fa-solid fa-user-plus"></i> Register</a
                        >
                    </li>
                    <li>
                        <a href="/login" class="hover:text-myblue"
                            ><i class="fa-solid fa-arrow-right-to-bracket"></i>
                            Login</a
                        >
                    </li>                                    
                @endauth
            </ul>
        </nav>        

        <x-flash-message />

        <main>

            {{ $slot }}

        </main>

        <footer class="fixed bottom-0 left-0 w-full flex items-center bg-myblue text-white h-24 mt-24 opacity-90 md:justify-center">
            <span class="ml-2">
                AMCEF Test Project by Juraj Gromoš (Mar 2023) | Thanks BD 
                <a href="https://github.com/bradtraversy/laragigs/tree/main/_laragigs_theme" target="blank">for UI templates!</a>
            </span>            
        </footer>
    </body>
</html>