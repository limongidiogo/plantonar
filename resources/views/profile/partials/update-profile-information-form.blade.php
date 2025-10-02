<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>
        {{-- Verifica o tipo de usuário a partir do perfil --}}
        @if ($profile->user_type === 'medico')
            {{-- Campos para o Médico --}}
            <div class="mt-4">
                <x-input-label for="crm" :value="__('CRM')" />
                <x-text-input id="crm" name="crm" type="text" class="mt-1 block w-full" :value="old('crm', $profile->crm)" required autofocus autocomplete="crm" />
                <x-input-error class="mt-2" :messages="$errors->get('crm')" />
            </div>

            <div class="mt-4">
                <x-input-label for="specialty" :value="__('Especialidade')" />
                <x-text-input id="specialty" name="specialty" type="text" class="mt-1 block w-full" :value="old('specialty', $profile->specialty)" required autofocus autocomplete="specialty" />
                <x-input-error class="mt-2" :messages="$errors->get('specialty')" />
            </div>

        @elseif ($profile->user_type === 'hospital')
            {{-- Campos para o Hospital --}}
            <div class="mt-4">
                <x-input-label for="hospital_name" :value="__('Nome do Hospital')" />
                <x-text-input id="hospital_name" name="hospital_name" type="text" class="mt-1 block w-full" :value="old('hospital_name', $profile->hospital_name)" required autofocus autocomplete="organization" />
                <x-input-error class="mt-2" :messages="$errors->get('hospital_name')" />
            </div>

            <div class="mt-4">
                <x-input-label for="cnpj" :value="__('CNPJ')" />
                <x-text-input id="cnpj" name="cnpj" type="text" class="mt-1 block w-full" :value="old('cnpj', $profile->cnpj)" required autofocus autocomplete="organization-id" />
                <x-input-error class="mt-2" :messages="$errors->get('cnpj')" />
            </div>
        @endif

        {{-- =============================================================== --}}
        {{-- == INÍCIO DO BLOCO DE INFORMAÇÕES PESSOAIS ESSENCIAIS == --}}
        {{-- =============================================================== --}}

        <div class="mt-6 border-t border-gray-200 pt-6">
            <h3 class="text-lg font-medium text-gray-900">Informações Pessoais</h3>
            <p class="mt-1 text-sm text-gray-600">Preencha seus dados para completar seu perfil.</p>
        </div>

        <div class="mt-4">
            <x-input-label for="data_nascimento" :value="__('Data de Nascimento')" />
            <x-text-input id="data_nascimento" name="data_nascimento" type="date" class="mt-1 block w-full" :value="old('data_nascimento', $profile->data_nascimento)" />
            <x-input-error class="mt-2" :messages="$errors->get('data_nascimento')" />
        </div>

        <div class="mt-4">
            <x-input-label for="cpf" :value="__('CPF')" />
            <x-text-input id="cpf" name="cpf" type="text" class="mt-1 block w-full" :value="old('cpf', $profile->cpf)" />
            <x-input-error class="mt-2" :messages="$errors->get('cpf')" />
        </div>

        <div class="mt-4">
            <x-input-label for="telefone_celular" :value="__('Telefone Celular (WhatsApp)')" />
            <x-text-input id="telefone_celular" name="telefone_celular" type="text" class="mt-1 block w-full" :value="old('telefone_celular', $profile->telefone_celular)" />
            <x-input-error class="mt-2" :messages="$errors->get('telefone_celular')" />
        </div>

        <div class="mt-4">
            <x-input-label for="endereco_completo" :value="__('Endereço Completo')" />
            <textarea id="endereco_completo" name="endereco_completo" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full">{{ old('endereco_completo', $profile->endereco_completo) }}</textarea>
            <x-input-error class="mt-2" :messages="$errors->get('endereco_completo')" />
        </div>


        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
