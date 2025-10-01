<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Minhas Candidaturas e Plantões Agendados') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="space-y-6">
                @forelse ($candidaturas as $candidatura)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-bold text-gray-900">{{ $candidatura->specialty }}</h3>
                        <p class="mt-1 text-sm text-gray-600">Data: {{ \Carbon\Carbon::parse($candidatura->date)->format('d/m/Y') }}</p>
                        
                        @if ($candidatura->status == 'preenchido' && $candidatura->approved_profile_id == Auth::user()->profile->id)
                            <p class="mt-2 font-bold text-green-600">Status: APROVADO!</p>
                        @elseif ($candidatura->status == 'preenchido')
                            <p class="mt-2 font-semibold text-red-600">Status: Vaga Preenchida por outro médico</p>
                        @else
                            <p class="mt-2 font-semibold text-blue-600">Status: Em Análise</p>
                        @endif
                    </div>
                @empty
                    <p class="text-center text-gray-500">Você ainda não se candidatou a nenhum plantão.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
