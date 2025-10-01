<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

        {{-- Bloco para exibir mensagens de sucesso --}}
        @if (session('success'))
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-4">
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            </div>
        @endif


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

             @if ($userType === 'medico') 
                @include('dashboards._medico')

            @elseif ($userType === 'hospital')
                @include('dashboards._hospital')

            @else
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <p>Seu tipo de perfil não foi identificado. Por favor, contate o suporte.</p>
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>

