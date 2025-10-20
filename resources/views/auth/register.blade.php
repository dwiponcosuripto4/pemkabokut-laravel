<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required
                autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Select Unit -->
        <div class="mt-4">
            <x-input-label for="unit" value="Unit" />
            <select id="unit" name="unit" class="block mt-1 w-full rounded border-gray-300">
                <option value="">-- Pilih Unit --</option>
                <option value="Bidang Informasi dan Komunikasi Publik">Bidang Informasi dan Komunikasi Publik</option>
                <option value="Bidang Pengelolaan Data dan Statistik">Bidang Pengelolaan Data dan Statistik</option>
                <option value="Bidang Persandian dan Keamanan Informasi">Bidang Persandian dan Keamanan Informasi
                </option>
                <option value="Bidang Infrastruktur Teknologi Informasi">Bidang Infrastruktur Teknologi Informasi
                </option>
                <option value="Sekretariat Diskominfo">Sekretariat Diskominfo</option>
            </select>
            <x-input-error :messages="$errors->get('unit')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <div class="relative">
                <x-text-input id="password" class="block mt-1 w-full pr-10" type="password" name="password" required
                    autocomplete="new-password" />
                <span class="absolute inset-y-0 right-0 flex items-center pr-3 cursor-pointer"
                    onclick="togglePassword('password', 'eyeIconPassword')">
                    <svg id="eyeIconPassword" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                </span>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <div class="relative">
                <x-text-input id="password_confirmation" class="block mt-1 w-full pr-10" type="password"
                    name="password_confirmation" required autocomplete="new-password" />
                <span class="absolute inset-y-0 right-0 flex items-center pr-3 cursor-pointer"
                    onclick="togglePassword('password_confirmation', 'eyeIconPasswordConfirmation')">
                    <svg id="eyeIconPasswordConfirmation" xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                </span>
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Simple Math Captcha -->
        <div class="mt-4">
            <x-input-label for="captcha" value="Captcha" />
            <div class="flex items-center space-x-2 mt-1">
                <span
                    class="text-lg font-semibold bg-gray-100 px-3 py-2 rounded border">{{ session('captcha_question') }}</span>
                <span class="text-lg">=</span>
                <x-text-input id="captcha" class="w-20" type="number" name="captcha" required placeholder="?" />
            </div>
            <x-input-error :messages="$errors->get('captcha')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
        <script>
            function togglePassword(inputId, iconId) {
                const passwordInput = document.getElementById(inputId);
                const eyeIcon = document.getElementById(iconId);
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    eyeIcon.innerHTML =
                        `<path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.956 9.956 0 012.907-4.568M6.634 6.634A9.956 9.956 0 0112 5c4.477 0 8.268 2.943 9.542 7a9.96 9.96 0 01-4.21 5.442M15 12a3 3 0 11-6 0 3 3 0 016 0z' /><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M3 3l18 18' />`;
                } else {
                    passwordInput.type = 'password';
                    eyeIcon.innerHTML =
                        `<path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M15 12a3 3 0 11-6 0 3 3 0 016 0z' /><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z' />`;
                }
            }
        </script>
    </form>
</x-guest-layout>
