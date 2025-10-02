<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View; // Importe a classe View
use App\Models\Plantao;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use App\Models\Profile;
use App\Notifications\MedicoAprovadoNotification;




class PlantaoController extends Controller
{
    /**
     * Mostra o formulário para criar um novo plantão.
     */
    public function create(): View
    {
        // Por enquanto, apenas retornamos a view.
        // No futuro, podemos adicionar uma verificação para garantir que só hospitais acessem.
        return view('plantoes.create');
    }

    public function store(Request $request): RedirectResponse
    {
        // 1. Validação dos dados recebidos do formulário
        $validatedData = $request->validate([
            'specialty' => 'required|string|max:255',
            'date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'remuneration' => 'required|numeric|min:0',
            'details' => 'nullable|string',
        ]);

        // 2. Pegar o perfil do hospital logado
        $hospitalProfile = Auth::user()->profile;

        // 3. Criar o plantão associado diretamente a este perfil
        $hospitalProfile->plantoes()->create($validatedData);

        // 4. Redirecionar de volta para o dashboard com uma mensagem de sucesso
        return redirect()->route('dashboard')->with('success', 'Plantão publicado com sucesso!');
    }
    
    /**
     * Exibe uma lista de plantões disponíveis.
     */
   public function index()
        {
        // Pega o ID do perfil do médico logado
        $medicoProfileId = Auth::user()->profile->id;

        // Busca todos os plantões disponíveis
        $plantoes = Plantao::where('status', 'disponivel')
                            ->with('candidates') // Otimização: Carrega os candidatos de uma vez
                            ->latest()
                            ->get();

        // Retorna a view, passando os plantões E o ID do perfil do médico
        return view('plantoes.index', [
            'plantoes' => $plantoes,
            'medicoProfileId' => $medicoProfileId
        ]);
    }

        /**
         * Aplica o médico logado a um plantão.
         */
            public function apply(Plantao $plantao): RedirectResponse
            {
                $medicoProfile = Auth::user()->profile;

                // VERIFICAÇÃO: Checa se o médico já se candidatou a este plantão
                if ($plantao->candidates()->where('profile_id', $medicoProfile->id)->exists()) {
                    // Se já existe, redireciona de volta com uma mensagem de erro/aviso
                    return redirect()->route('plantoes.index')->with('error', 'Você já se candidatou para este plantão.');
                }

                // Se não existe, anexa o perfil do médico aos candidatos do plantão
                $plantao->candidates()->attach($medicoProfile->id);

                return redirect()->route('plantoes.index')->with('success', 'Você se candidatou para o plantão com sucesso!');
            }

        /**
         * Exibe os plantões publicados pelo hospital logado.
         */
            public function myPlantoes()
            {
                $hospitalProfileId = Auth::user()->profile->id;

                $meusPlantoes = Plantao::where('profile_id', $hospitalProfileId)
                                        ->withCount('candidates') // Conta quantos candidatos cada plantão tem
                                        ->latest()
                                        ->get();

                return view('plantoes.my-plantoes', ['plantoes' => $meusPlantoes]);
            }

        /**
         * Mostra os detalhes de um plantão e a lista de seus candidatos.
         */
            public function showCandidates(Plantao $plantao)
            {
                // Otimização: Carrega os perfis dos candidatos e, para cada perfil, carrega o usuário associado.
                $plantao->load('candidates.user');

                // Retorna a view, passando o plantão com seus candidatos já carregados.
                return view('plantoes.candidates', ['plantao' => $plantao]);
            }

       /**
         * Aprova um candidato para um plantão.
         */
       public function approve(Plantao $plantao, Profile $candidate): RedirectResponse
        {
            if ($plantao->status !== 'disponivel') {
                return redirect()->route('plantoes.my')->with('error', 'Este plantão não está mais disponível para aprovação.');
            }

            $plantao->update([
                'approved_profile_id' => $candidate->id,
                'status' => 'preenchido',
            ]);

            // --- LÓGICA DA NOTIFICAÇÃO ---
            // 1. Encontra o objeto User do médico aprovado
            $medicoUser = $candidate->user;

            // 2. Envia a notificação para este usuário
            $medicoUser->notify(new MedicoAprovadoNotification($plantao));
            // --- FIM DA LÓGICA DA NOTIFICAÇÃO ---

            return redirect()->route('plantoes.my')->with('success', 'Médico aprovado e plantão preenchido com sucesso!');
        }


}
