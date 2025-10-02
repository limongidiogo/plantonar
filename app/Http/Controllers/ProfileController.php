<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Garante que o Facade Auth está importado
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    // ... (todos os outros métodos como edit, update, destroy, etc. permanecem iguais) ...

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();
        $user->load('profile');

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
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $profile = $request->user()->profile;
        
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

        $profileData = array_merge($personalData, $specificData);

        if (!empty($profileData)) {
            $profile->update($profileData);
        }

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
        $candidaturas = $userProfile->candidacies()->with('approvedProfile.user')->get();

        return view('profile.candidacies', ['candidaturas' => $candidaturas]);
    }

    /**
     * Mostra a página de gerenciamento de documentos, agora com os documentos existentes.
     */
    public function documents(): View
    {
        // LINHA CORRIGIDA AQUI: Usando Auth::user() que é o padrão.
        $profile = Auth::user()->profile;

        $documentos = $profile->documentos->keyBy('tipo_documento');

        return view('profile.documents', [
            'foto_perfil' => $documentos->get('FOTO_PERFIL'),
            'diploma' => $documentos->get('DIPLOMA_GRADUACAO'),
        ]);
    }

    /**
     * Lida com o upload de um documento do usuário.
     */
    public function uploadDocument(Request $request): RedirectResponse
    {
        $request->validate([
            'tipo_documento' => ['required', 'string', 'in:FOTO_PERFIL,DIPLOMA_GRADUACAO'],
            'documento' => ['required', 'file', 'mimes:jpg,png,pdf', 'max:2048'],
        ]);

        $profile = $request->user()->profile;
        $file = $request->file('documento');
        $tipoDocumento = $request->input('tipo_documento');

        $path = $file->store('documentos/' . $profile->id, 'public');

        $profile->documentos()->updateOrCreate(
            ['tipo_documento' => $tipoDocumento],
            [
                'caminho_arquivo' => $path,
                'nome_original' => $file->getClientOriginalName(),
                'extensao' => $file->getClientOriginalExtension(),
            ]
        );

        return redirect()->route('profile.documents')->with('status', 'document-uploaded');
    }
}

