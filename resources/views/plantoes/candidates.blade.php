<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Candidatos para: {{ $plantao->specialty }} ({{ \Carbon\Carbon::parse($plantao->date)->format('d/m/Y') }})
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold border-b pb-3 mb-4">Lista de Candidatos</h3>
                <div class="space-y-4">
                    @forelse ($plantao->candidates as $candidate)
                        <div class="flex justify-between items-center p-4 border rounded-lg">
                            <div>
                                {{-- Acessamos o nome através da relação profile->user --}}
                                <p class="font-bold text-gray-800">{{ $candidate->user->name }}</p>
                                <p class="text-sm text-gray-600">Especialidade: {{ $candidate->specialty }}</p>
                            </div>
                           <div>
                                <form method="POST" action="{{ route('plantoes.approve', ['plantao' => $plantao, 'candidate' => $candidate]) }}">
                                    @csrf
                                    <x-primary-button>
                                        {{ __('Aprovar') }}
                                    </x-primary-button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-gray-500">Ainda não há candidatos para este plantão.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
