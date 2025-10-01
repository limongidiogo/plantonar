<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; // Importante: para usar transações
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(Request $request): View
        {
        return view('auth.register', ['type' => $request->query('type')]);
        }


    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // 1. Validação Base (comum a ambos os usuários)
        $baseRules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'user_type' => ['required', 'in:medico,hospital'], // Valida o tipo de usuário
        ];

        // 2. Adicionar regras de validação específicas baseadas no tipo de usuário
        $specificRules = [];
        if ($request->input('user_type') === 'medico') {
            $specificRules = [
                'crm' => ['required', 'string', 'max:20', 'unique:profiles,crm'],
                'specialty' => ['required', 'string', 'max:100'],
            ];
        } elseif ($request->input('user_type') === 'hospital') {
            $specificRules = [
                'hospital_name' => ['required', 'string', 'max:255'],
                'cnpj' => ['required', 'string', 'max:18', 'unique:profiles,cnpj'],
            ];
        }

        // 3. Juntar as regras e validar
        $request->validate(array_merge($baseRules, $specificRules));

        // 4. Usar uma transação para garantir a consistência dos dados
        $user = DB::transaction(function () use ($request) {
            // 4.1. Criar o Usuário
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            // 4.2. Preparar e Criar o Perfil
            $profileData = [
                'user_id' => $user->id,
                'user_type' => $request->user_type,
            ];

            if ($request->user_type === 'medico') {
                $profileData['crm'] = $request->crm;
                $profileData['specialty'] = $request->specialty;
            } else {
                $profileData['hospital_name'] = $request->hospital_name;
                $profileData['cnpj'] = $request->cnpj;
            }

            // Usando a relação que criamos para criar o perfil
            $user->profile()->create($profileData);

            return $user;
        });

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }

    /**
     * Display the user type selection view.
     */
    public function selectUserType(): View
    {
        return view('auth.select-user-type');
    }
    
} // <-- Este é o fechamento da classe
