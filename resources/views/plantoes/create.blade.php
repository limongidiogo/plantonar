<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Publicar Novo Plantão') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <form method="POST" action="{{ route('plantoes.store') }}">
                        @csrf

                        <!-- Especialidade -->
                        <div class="mt-4">
                            <x-input-label for="specialty" :value="__('Especialidade Necessária')" />
                            <x-text-input id="specialty" class="block mt-1 w-full" type="text" name="specialty" :value="old('specialty')" required autofocus />
                            <x-input-error :messages="$errors->get('specialty')" class="mt-2" />
                        </div>

                        <!-- Data -->
                        <div class="mt-4">
                            <x-input-label for="date" :value="__('Data do Plantão')" />
                            <x-text-input id="date" class="block mt-1 w-full" type="date" name="date" :value="old('date')" required />
                            <x-input-error :messages="$errors->get('date')" class="mt-2" />
                        </div>

                        <!-- Horário de Início -->
                        <div class="mt-4">
                            <x-input-label for="start_time" :value="__('Horário de Início')" />
                            <x-text-input id="start_time" class="block mt-1 w-full" type="time" name="start_time" :value="old('start_time')" required />
                            <x-input-error :messages="$errors->get('start_time')" class="mt-2" />
                        </div>

                        <!-- Horário de Término -->
                        <div class="mt-4">
                            <x-input-label for="end_time" :value="__('Horário de Término')" />
                            <x-text-input id="end_time" class="block mt-1 w-full" type="time" name="end_time" :value="old('end_time')" required />
                            <x-input-error :messages="$errors->get('end_time')" class="mt-2" />
                        </div>

                        <!-- Remuneração -->
                        <div class="mt-4">
                            <x-input-label for="remuneration" :value="__('Valor da Remuneração (R$)')" />
                            <x-text-input id="remuneration" class="block mt-1 w-full" type="number" name="remuneration" step="0.01" :value="old('remuneration')" required />
                            <x-input-error :messages="$errors->get('remuneration')" class="mt-2" />
                        </div>

                        <!-- Detalhes -->
                        <div class="mt-4">
                            <x-input-label for="details" :value="__('Detalhes Adicionais (Opcional)')" />
                            <textarea id="details" name="details" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('details') }}</textarea>
                            <x-input-error :messages="$errors->get('details')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <x-primary-button>
                                {{ __('Publicar Plantão') }}
                            </x-primary-button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
