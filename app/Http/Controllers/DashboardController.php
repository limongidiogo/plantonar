<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Exibe o dashboard apropriado com base no tipo de perfil do usuário.
     *
     * @return View
     */
    public function index(): View
    {
        // 1. Pega o usuário autenticado
        $user = Auth::user();

        // 2. Carrega a relação 'profile' para evitar consultas extras (eager loading)
        //    e pega o tipo de usuário do perfil.
        $userType = Auth::user()->profile->user_type;


        // 3. Retorna a view principal do dashboard, passando o tipo de usuário para ela.
        //    A view 'dashboard.blade.php' vai usar essa variável para decidir o que mostrar.
        return view('dashboard', [
            'userType' => $userType
        ]);
    }
}
