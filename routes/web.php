<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PlantaoController; // Movido para o topo para melhor organização
use App\Services\CrmVerificationService;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('register/select', [RegisteredUserController::class, 'selectUserType'])
    ->middleware('guest')
    ->name('register.select');

Route::get('register', function () {
    if (request()->has('type')) {
        return app(RegisteredUserController::class)->create(request());
    }
    return redirect()->route('register.select');
})->middleware('guest')->name('register');

// Grupo de rotas para funcionalidades principais da aplicação (após login)
Route::middleware(['auth', 'verified'])->group(function () {
    // --- ROTAS DE DOCUMENTOS ---
    // Rota para MOSTRAR a página de gerenciamento de documentos
    Route::get('/profile/documents', [ProfileController::class, 'documents'])->name('profile.documents');
    
    // ROTA ADICIONADA AQUI: Rota para RECEBER o upload do documento
    Route::post('/profile/documents', [ProfileController::class, 'uploadDocument'])->name('profile.documents.upload');

    // --- ROTAS DE CANDIDATURAS E PLANTÕES ---
    // Rota para o médico ver seus plantões agendados e candidaturas
    Route::get('/minhas-candidaturas', [ProfileController::class, 'myCandidacies'])->name('profile.candidacies');

    // Rota para o hospital aprovar um candidato para um plantão
    Route::post('/plantoes/{plantao}/approve/{candidate}', [PlantaoController::class, 'approve'])->name('plantoes.approve');

    // Rota para o hospital ver os detalhes e candidatos de um plantão específico
    Route::get('/plantoes/{plantao}/candidatos', [PlantaoController::class, 'showCandidates'])->name('plantoes.candidates');

    // Rota para o hospital ver seus próprios plantões publicados
    Route::get('/meus-plantoes', [PlantaoController::class, 'myPlantoes'])->name('plantoes.my');

    // Rota para um médico se candidatar a um plantão
    Route::post('/plantoes/{plantao}/apply', [PlantaoController::class, 'apply'])->name('plantoes.apply');

    // Rotas CRUD para Plantões
    Route::get('/plantoes', [PlantaoController::class, 'index'])->name('plantoes.index');
    Route::get('/plantoes/create', [PlantaoController::class, 'create'])->name('plantoes.create');
    Route::post('/plantoes', [PlantaoController::class, 'store'])->name('plantoes.store');
});
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

Route::get('/debug-db', function () {
    // Pergunta 1: Qual arquivo de banco de dados você está usando?
    $databasePath = DB::connection()->getDatabaseName();
    dump("Caminho do Banco de Dados em uso:", $databasePath);

    // Pergunta 2: Quais são as colunas da tabela 'profiles'?
    $profileColumns = Schema::getColumnListing('profiles');
    dump("Colunas na tabela 'profiles':", $profileColumns);

    // Pergunta 3: Quais são as colunas da tabela 'documentos'?
    $documentoColumns = Schema::getColumnListing('documentos');
    dump("Colunas na tabela 'documentos':", $documentoColumns);
});

require __DIR__.'/auth.php';
