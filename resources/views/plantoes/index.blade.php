<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Plantões Disponíveis') }}
        </h2>
    </x-slot>

    {{-- Bloco para exibir mensagens de sucesso --}}
    @if (session('success'))
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-2">
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        </div>
    @endif
    
    {{-- Bloco para exibir mensagens de erro --}}
    @if (session('error'))
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-2">
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        </div>
    @endif


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="space-y-6">
                
                {{-- Loop para exibir cada plantão --}}
                @forelse ($plantoes as $plantao)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-bold text-gray-900">{{ $plantao->specialty }}</h3>
                        
                        <p class="mt-1 text-sm text-gray-600">
                            Data: {{ \Carbon\Carbon::parse($plantao->date)->format('d/m/Y') }} | 
                            Horário: {{ \Carbon\Carbon::parse($plantao->start_time)->format('H:i') }} às {{ \Carbon\Carbon::parse($plantao->end_time)->format('H:i') }}
                        </p>

                        <p class="mt-2 font-semibold text-green-600">
                            Remuneração: R$ {{ number_format($plantao->remuneration, 2, ',', '.') }}
                        </p>

                        @if($plantao->details)
                            <p class="mt-2 text-sm text-gray-800">
                                <strong>Detalhes:</strong> {{ $plantao->details }}
                            </p>
                        @endif

                        <div class="mt-4">
                                {{-- Verifica se a coleção de 'candidates' do plantão contém o ID do perfil do médico logado --}}
                                @if ($plantao->candidates->contains('id', $medicoProfileId))
                                    {{-- Se já se candidatou, mostra um botão desabilitado --}}
                                    <span class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-600 uppercase tracking-widest cursor-not-allowed">
                                        Candidatura Enviada
                                    </span>
                                @else
                                    {{-- Se não, mostra o botão para se candidatar --}}
                                    <form method="POST" action="{{ route('plantoes.apply', $plantao) }}">
                                        @csrf
                                        <x-primary-button>
                                            {{ __('Tenho Interesse') }}
                                        </x-primary-button>
                                    </form>
                                @endif
                        </div>

                    </div>
                @empty
                    {{-- Mensagem para quando não houver plantões --}}
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <p class="text-center text-gray-500">Nenhum plantão disponível no momento.</p>
                    </div>
                @endforelse

            </div>
        </div>
    </div>
</x-app-layout>

