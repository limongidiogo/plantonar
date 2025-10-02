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

                    {{-- Formulário para a Foto de Perfil --}}
                    <form method="POST" action="{{ route('profile.documents.upload') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="tipo_documento" value="foto_perfil">
                        <div>
                            <x-input-label for="foto_perfil" :value="__('Foto de Perfil (Profissional)')" />
                            <x-text-input id="foto_perfil" name="documento" type="file" class="mt-1 block w-full" required />
                            {{-- <x-input-error :messages="$errors->get('documento')" class="mt-2" /> --}}
                        </div>
                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Enviar Foto') }}</x-primary-button>
                        </div>
                    </form>

                     {{-- Formulário para o Diploma --}}
                    <form method="POST" action="{{ route('profile.documents.upload') }}" class="mt-10 border-t pt-6 space-y-6" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="tipo_documento" value="diploma">
                        <div>
                            <x-input-label for="diploma" :value="__('Diploma de Graduação')" />
                            <x-text-input id="diploma" name="documento" type="file" class="mt-1 block w-full" required />
                            {{-- <x-input-error :messages="$errors->get('documento')" class="mt-2" /> --}}
                        </div>
                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Enviar Diploma') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

