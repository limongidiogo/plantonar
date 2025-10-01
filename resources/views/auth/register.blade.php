<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- User Type (Hidden Field) -->
        <input type="hidden" name="user_type" value="{{ request('type') }}">

        <!-- Name -->
        <div>
            @if(request('type') === 'hospital')
                <x-input-label for="name" value="Nome do Responsável" />
            @else
                <x-input-label for="name" value="Nome Completo" />
            @endif
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Hospital-specific fields -->
        @if(request('type') === 'hospital')
            <div class="mt-4">
                <x-input-label for="hospital_name" value="Nome do Hospital" />
                <x-text-input id="hospital_name" class="block mt-1 w-full" type="text" name="hospital_name" :value="old('hospital_name')" required />
                <x-input-error :messages="$errors->get('hospital_name')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="cnpj" value="CNPJ" />
                <x-text-input id="cnpj" class="block mt-1 w-full" type="text" name="cnpj" :value="old('cnpj')" required />
                <x-input-error :messages="$errors->get('cnpj')" class="mt-2" />
            </div>
        @endif

        <!-- Doctor-specific fields -->
        @if(request('type') === 'medico')
            <div class="mt-4">
                <x-input-label for="crm" value="CRM" />
                <x-text-input id="crm" class="block mt-1 w-full" type="text" name="crm" :value="old('crm')" required />
                <x-input-error :messages="$errors->get('crm')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="specialty" value="Especialidade" />
                <x-text-input id="specialty" class="block mt-1 w-full" type="text" name="specialty" :value="old('specialty')" required />
                <x-input-error :messages="$errors->get('specialty')" class="mt-2" />
            </div>
        @endif


        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
