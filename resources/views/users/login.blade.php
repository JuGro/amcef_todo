<x-layout>
    <x-card class="p-10 max-w-lg mx-auto mt-24">
        <header class="text-center">
            <h2 class="text-2xl font-bold uppercase mb-1">
                {{ __('messages.login') }}
            </h2>
            <p class="mb-4">{{ __('messages.login_instruction') }}</p>
        </header>

        <form method="POST" action="/users/authenticate">
            @csrf
            <div class="mb-6">
                <label for="email" class="inline-block text-lg mb-2">{{ __('messages.email') }}</label>
                <input class="border border-gray-200 rounded p-2 w-full"
                    type="email" name="email"value="{{ old('email') }}"
                />
                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>                    
                @enderror
            </div>

            <div class="mb-6">
                <label class="inline-block text-lg mb-2" for="password">
                    {{ __('messages.password') }}
                </label>
                <input class="border border-gray-200 rounded p-2 w-full"
                    type="password" name="password"
                />
                @error('password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>                    
                @enderror
            </div>

            <div class="mb-6">
                <button class="bg-myblue text-white rounded py-2 px-4 hover:bg-black"
                    type="submit">
                    {{ __('messages.sign_in') }}
                </button>
            </div>

            <div class="mt-8">
                <p>
                    {{ __('messages.no_acount_instruction') }}
                    <a href="/register" class="text-myblue"> {{ __('messages.register') }}</a>
                </p>
            </div>
        </form>
    </x-card>
</x-layout>