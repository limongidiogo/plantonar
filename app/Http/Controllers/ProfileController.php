<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        // 1. Pega o usuário logado a partir do objeto Request.
        //    Isso garante que temos um usuário, pois a rota está protegida por middleware.
        $user = $request->user();

        // 2. Agora que temos certeza que $user é um objeto User, carregamos a relação.
        $user->load('profile');

        // 3. Retornamos a view com os dados.
        return view('profile.edit', [
            'user' => $user,
            'profile' => $user->profile,
        ]);
    }



    /**
 * Update the user's profile information.
 */
public function update(ProfileUpdateRequest $request): RedirectResponse
{
    // A validação dos dados do User (name, email) já é feita pelo ProfileUpdateRequest
    $request->user()->fill($request->validated());

    if ($request->user()->isDirty('email')) {
        $request->user()->email_verified_at = null;
    }

    $profile = $request->user()->profile;
    
    // Validação dos dados pessoais (comuns a ambos)
    // Usamos 'sometimes' para não exigir em todos os updates, mas se vier, valida.
    $personalData = $request->validate([
        'data_nascimento' => ['sometimes', 'nullable', 'date'],
        'cpf' => ['sometimes', 'nullable', 'string', 'max:14'],
        'telefone_celular' => ['sometimes', 'nullable', 'string', 'max:20'],
        'endereco_completo' => ['sometimes', 'nullable', 'string'],
    ]);

    $specificData = [];
    if ($profile->user_type === 'medico') {
        $specificData = $request->validate([
            'crm' => ['required', 'string', 'max:20'],
            'specialty' => ['required', 'string', 'max:100'],
        ]);
    } elseif ($profile->user_type === 'hospital') {
        $specificData = $request->validate([
            'hospital_name' => ['required', 'string', 'max:255'],
            'cnpj' => ['required', 'string', 'max:18'],
        ]);
    }

    // Junta todos os dados validados para o perfil
    $profileData = array_merge($personalData, $specificData);

    // Atualiza o perfil com os dados validados
    if (!empty($profileData)) {
        $profile->update($profileData);
    }

    // Salva as alterações no User
    $request->user()->save();

    return Redirect::route('profile.edit')->with('status', 'profile-updated');
}



    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function myCandidacies(): View
    {
        $userProfile = Auth::user()->profile;

        // Carrega os plantões para os quais o médico se candidatou
        $candidaturas = $userProfile->candidacies()->with('approvedProfile.user')->get();

        return view('profile.candidacies', ['candidaturas' => $candidaturas]);
    }

    /**
     * Mostra a página de gerenciamento de documentos.
     */
    public function documents(): View
    {
        return view('profile.documents');
    }


}
