<x-guest-layout>

    <!-- Formulaire -->
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md text-[#442b1f] font-sans">

        <!-- Image dans le formulaire -->
        <div class="flex justify-center mb-6">
            <img src="{{ asset('images/Atelier404.png') }}" alt="Atelier404" class="h-48 w-auto">
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email -->
            <div class="mb-4">
                <x-input-label for="email" :value="__('Email')" class="text-[#442b1f]" />
                <x-text-input id="email"
                    class="block mt-1 w-full border border-gray-300 rounded px-3 py-2 text-[#442b1f]"
                    style="background-color: #f9eddd;"
                    type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-600" />
            </div>

            <!-- Password -->
            <div class="mb-4">
                <x-input-label for="password" :value="__('Password')" class="text-[#442b1f]" />
                <x-text-input id="password"
                    class="block mt-1 w-full border border-gray-300 rounded px-3 py-2 text-[#442b1f]"
                    style="background-color: #f9eddd;"
                    type="password" name="password" required autocomplete="current-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-600" />
            </div>

            <!-- Remember Me -->
            <div class="block mb-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox"
                        class="rounded border-gray-300 text-[#442b1f] shadow-sm focus:ring-[#442b1f]"
                        name="remember">
                    <span class="ms-2 text-sm text-[#442b1f]">{{ __('Remember me') }}</span>
                </label>
            </div>

            <!-- Boutons -->
            <div class="flex flex-col gap-3 mt-4">

                <!-- Bouton login -->
                <button
                    class="text-center bg-[#442b1f] text-[#f9eddd] font-semibold rounded hover:opacity-90 transition w-full py-2">
                    Log in
                </button>

                <!-- Bouton retour -->
                <a href="{{ url('/') }}"
                    class="text-center bg-[#442b1f] text-[#f9eddd] font-semibold rounded hover:opacity-90 transition w-full py-2">
                    Retour à l'accueil
                </a>
            </div>

            <!-- Forgot password -->
            @if (Route::has('password.request'))
                <div class="mt-4 text-center">
                    <a class="underline text-sm text-[#442b1f] hover:text-gray-800"
                        href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                </div>
            @endif
        </form>

    </div>

</x-guest-layout>
