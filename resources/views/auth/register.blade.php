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
                {{-- O x-input-error já exibe a mensagem de validação que vamos criar no controller --}}
                <x-input-error :messages="$errors->get('crm')" class="mt-2" />
            </div>

            {{-- ================================================================== --}}
            {{-- │ NOVO CAMPO ADICIONADO AQUI                                     │ --}}
            {{-- ================================================================== --}}
            <div class="mt-4">
                <x-input-label for="uf" value="UF do CRM" />
                <select id="uf" name="uf" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required>
                    <option value="" disabled {{ old('uf') ? '' : 'selected' }}>Selecione o estado</option>
                    <option value="AC" @if(old('uf') == 'AC') selected @endif>Acre</option>
                    <option value="AL" @if(old('uf') == 'AL') selected @endif>Alagoas</option>
                    <option value="AP" @if(old('uf') == 'AP') selected @endif>Amapá</option>
                    <option value="AM" @if(old('uf') == 'AM') selected @endif>Amazonas</option>
                    <option value="BA" @if(old('uf') == 'BA') selected @endif>Bahia</option>
                    <option value="CE" @if(old('uf') == 'CE') selected @endif>Ceará</option>
                    <option value="DF" @if(old('uf') == 'DF') selected @endif>Distrito Federal</option>
                    <option value="ES" @if(old('uf') == 'ES') selected @endif>Espírito Santo</option>
                    <option value="GO" @if(old('uf') == 'GO') selected @endif>Goiás</option>
                    <option value="MA" @if(old('uf') == 'MA') selected @endif>Maranhão</option>
                    <option value="MT" @if(old('uf') == 'MT') selected @endif>Mato Grosso</option>
                    <option value="MS" @if(old('uf') == 'MS') selected @endif>Mato Grosso do Sul</option>
                    <option value="MG" @if(old('uf') == 'MG') selected @endif>Minas Gerais</option>
                    <option value="PA" @if(old('uf') == 'PA') selected @endif>Pará</option>
                    <option value="PB" @if(old('uf') == 'PB') selected @endif>Paraíba</option>
                    <option value="PR" @if(old('uf') == 'PR') selected @endif>Paraná</option>
                    <option value="PE" @if(old('uf') == 'PE') selected @endif>Pernambuco</option>
                    <option value="PI" @if(old('uf') == 'PI') selected @endif>Piauí</option>
                    <option value="RJ" @if(old('uf') == 'RJ') selected @endif>Rio de Janeiro</option>
                    <option value="RN" @if(old('uf') == 'RN') selected @endif>Rio Grande do Norte</option>
                    <option value="RS" @if(old('uf') == 'RS') selected @endif>Rio Grande do Sul</option>
                    <option value="RO" @if(old('uf') == 'RO') selected @endif>Rondônia</option>
                    <option value="RR" @if(old('uf') == 'RR') selected @endif>Roraima</option>
                    <option value="SC" @if(old('uf') == 'SC') selected @endif>Santa Catarina</option>
                    <option value="SP" @if(old('uf') == 'SP') selected @endif>São Paulo</option>
                    <option value="SE" @if(old('uf') == 'SE') selected @endif>Sergipe</option>
                    <option value="TO" @if(old('uf') == 'TO') selected @endif>Tocantins</option>
                </select>
                <x-input-error :messages="$errors->get('uf')" class="mt-2" />
            </div>
            {{-- ================================================================== --}}
            {{-- │ FIM DO NOVO CAMPO                                                │ --}}
            {{-- ================================================================== --}}

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
            </x--primary-button>
        </div>
    </form>
</x-guest-layout>

