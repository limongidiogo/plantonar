<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Meus Plantões Publicados') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="space-y-6">
                @forelse ($plantoes as $plantao)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="text-lg font-bold text-gray-900">{{ $plantao->specialty }}</h3>
                                <p class="mt-1 text-sm text-gray-600">
                                    Data: {{ \Carbon\Carbon::parse($plantao->date)->format('d/m/Y') }} | 
                                    Status: 
                                    <span class="font-semibold @if($plantao->status == 'preenchido') text-green-600 @else text-blue-600 @endif">
                                        {{ ucfirst($plantao->status) }}
                                    </span>
                                </p>
                                {{-- Mostra o nome do médico aprovado, se houver --}}
                                @if($plantao->approved_profile_id)
                                    <p class="mt-1 text-sm text-gray-800">
                                        Médico Aprovado: <span class="font-bold">{{ $plantao->approvedProfile->user->name }}</span>
                                    </p>
                                @endif
                            </div>
                            {{-- Mostra o contador de candidatos apenas se o plantão estiver disponível --}}
                            @if($plantao->status == 'disponivel')
                                <div class="text-right">
                                    <span class="text-lg font-bold text-blue-600">{{ $plantao->candidates_count }}</span>
                                    <p class="text-sm text-gray-500">Candidato(s)</p>
                                </div>
                            @endif
                        </div>
                        {{-- Mostra o link "Ver Candidatos" apenas se o plantão estiver disponível --}}
                        @if($plantao->status == 'disponivel')
                            <div class="mt-4">
                                <a href="{{ route('plantoes.candidates', $plantao) }}" class="text-indigo-600 hover:text-indigo-900 font-semibold">
                                    Ver Candidatos &rarr;
                                </a>
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <p class="text-center text-gray-500">Você ainda não publicou nenhum plantão.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
