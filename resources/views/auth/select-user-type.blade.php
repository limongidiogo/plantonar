<x-guest-layout>
    <div class="flex flex-col items-center min-h-screen pt-6 sm:pt-0 bg-gray-100">
        <div>
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </div>

        <div class="w-full sm:max-w-md mt-6 px-6 py-8 bg-white shadow-md overflow-hidden sm:rounded-lg text-center">
            
            <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Como você quer se cadastrar?</h2>

            <div class="space-y-4">
                {{-- Botão para se registrar como Médico --}}
                <a href="{{ route('register', ['type' => 'medico']) }}"
                   class="block w-full px-4 py-3 text-lg font-semibold text-center text-white bg-blue-500 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition ease-in-out duration-150">
                    Sou Médico
                </a>

                {{-- Botão para se registrar como Hospital --}}
                <a href="{{ route('register', ['type' => 'hospital']) }}"
                   class="block w-full px-4 py-3 text-lg font-semibold text-center text-white bg-green-500 rounded-lg hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition ease-in-out duration-150">
                    Sou Hospital
                </a>
            </div>

        </div>
    </div>
</x-guest-layout>
