{{-- resources/views/dashboards/_medico.blade.php --}}

<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 text-gray-900">
        <h3 class="text-xl font-semibold mb-4">Dashboard do Médico</h3>
        <p>Bem-vindo, Dr(a). {{ Auth::user()->name }}!</p>
        <p class="mt-2">Aqui você poderá buscar por novos plantões, gerenciar seus plantões agendados e atualizar seu perfil.</p>
        
        {{-- Em breve, adicionaremos botões e componentes aqui --}}
        <div class="mt-6 flex space-x-4">
            <a href="{{ route('plantoes.index') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Buscar Plantões
            </a>
            <a href="{{ route('profile.candidacies') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Minhas Candidaturas
            </a>
        </div>
    </div>
</div>

<div class="mt-6 flex space-x-4">
    <a href="{{ route('plantoes.index') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
        Buscar Plantões
    </a>
    <a href="{{ route('profile.candidacies') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
        Minhas Candidaturas
    </a>
</div>
