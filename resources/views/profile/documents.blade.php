<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Meus Documentos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <header>
                        <h2 class="text-lg font-medium text-gray-900">Envio de Documentos</h2>
                        <p class="mt-1 text-sm text-gray-600">
                            Envie seus documentos para verificação. Formatos aceitos: PDF, JPG, PNG. Tamanho máximo: 2MB.
                        </p>
                    </header>

                    {{-- Bloco para exibir a mensagem de sucesso --}}
                    @if (session('status') === 'document-uploaded')
                        <p
                            x-data="{ show: true }"
                            x-show="show"
                            x-transition
                            x-init="setTimeout(() => show = false, 3000)"
                            class="text-sm font-medium text-green-600"
                        >
                            {{ __('Documento enviado com sucesso!') }}
                        </p>
                    @endif

                    {{-- Seção da Foto de Perfil --}}
                    <div class="mt-6 border-t border-gray-200 pt-6">
                        <h3 class="text-md font-medium text-gray-900">Foto de Perfil (Profissional)</h3>
                        {{-- Verifica se a foto de perfil já foi enviada --}}
                        @if ($foto_perfil)
                            <div class="mt-4 flex items-center gap-4">
                                {{-- Mostra uma miniatura se for imagem --}}
                                @if (in_array(strtolower($foto_perfil->extensao), ['jpg', 'jpeg', 'png', 'gif']))
                                    <img src="{{ Storage::url($foto_perfil->caminho_arquivo) }}" alt="Foto de Perfil" class="h-16 w-16 rounded-full object-cover">
                                @else
                                    {{-- Ícone genérico para outros tipos de arquivo (PDF) --}}
                                    <div class="h-16 w-16 flex items-center justify-center bg-gray-200 rounded-lg">
                                        <svg class="w-8 h-8 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    </div>
                                @endif
                                <a href="{{ Storage::url($foto_perfil->caminho_arquivo ) }}" target="_blank" class="text-sm text-blue-600 hover:underline">
                                    {{ $foto_perfil->nome_original }}
                                </a>
                            </div>
                        @else
                            <p class="mt-2 text-sm text-gray-500">Nenhum arquivo enviado.</p>
                        @endif

                        {{-- Formulário para trocar ou enviar a foto --}}
                        <form method="POST" action="{{ route('profile.documents.upload') }}" class="mt-4 space-y-6" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="tipo_documento" value="FOTO_PERFIL">
                            <div>
                                <x-input-label for="foto_perfil_input" :value="$foto_perfil ? 'Trocar Foto' : 'Enviar Nova Foto'" />
                                <x-text-input id="foto_perfil_input" name="documento" type="file" class="mt-1 block w-full" required />
                            </div>
                            <div class="flex items-center gap-4">
                                <x-primary-button>{{ $foto_perfil ? __('Salvar Alteração') : __('Enviar Foto') }}</x-primary-button>
                            </div>
                        </form>
                    </div>

                    {{-- Seção do Diploma --}}
                    <div class="mt-10 border-t border-gray-200 pt-6">
                        <h3 class="text-md font-medium text-gray-900">Diploma de Graduação</h3>
                        {{-- Verifica se o diploma já foi enviado --}}
                        @if ($diploma)
                            <div class="mt-4 flex items-center gap-4">
                                {{-- Ícone de documento --}}
                                <div class="h-16 w-16 flex items-center justify-center bg-gray-200 rounded-lg">
                                    <svg class="w-8 h-8 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                </div>
                                <a href="{{ Storage::url($diploma->caminho_arquivo ) }}" target="_blank" class="text-sm text-blue-600 hover:underline">
                                    {{ $diploma->nome_original }}
                                </a>
                            </div>
                        @else
                            <p class="mt-2 text-sm text-gray-500">Nenhum arquivo enviado.</p>
                        @endif

                        {{-- Formulário para trocar ou enviar o diploma --}}
                        <form method="POST" action="{{ route('profile.documents.upload') }}" class="mt-4 space-y-6" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="tipo_documento" value="DIPLOMA_GRADUACAO">
                            <div>
                                <x-input-label for="diploma_input" :value="$diploma ? 'Trocar Diploma' : 'Enviar Novo Diploma'" />
                                <x-text-input id="diploma_input" name="documento" type="file" class="mt-1 block w-full" required />
                            </div>
                            <div class="flex items-center gap-4">
                                <x-primary-button>{{ $diploma ? __('Salvar Alteração') : __('Enviar Diploma') }}</x-primary-button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
