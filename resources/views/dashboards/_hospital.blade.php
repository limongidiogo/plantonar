{{-- resources/views/dashboards/_hospital.blade.php --}}

<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 text-gray-900">
        <h3 class="text-xl font-semibold mb-4">Dashboard do Hospital</h3>
        <p>Bem-vindo, {{ Auth::user()->name }}!</p>
        <p class="mt-2">Aqui você poderá publicar novos plantões, gerenciar médicos e visualizar o calendário de plantões.</p>

        {{-- Em breve, adicionaremos botões e componentes aqui --}}
        <div class="mt-6 flex space-x-4">
            <a href="{{ route('plantoes.create') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                Publicar Novo Plantão
            </a>
            <a href="{{ route('plantoes.my') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Gerenciar Meus Plantões
            </a>
        </div>
    </div>
</div>
