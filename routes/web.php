<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\DashboardController;



Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 
'index'])->middleware(['auth', 'verified'])->name('dashboard');


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

// Importar o novo controller no topo do arquivo routes/web.php
use App\Http\Controllers\PlantaoController;

// Adicionar este grupo de rotas no final do arquivo
Route::middleware(['auth', 'verified'])->group(function () {
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

    Route::get('/plantoes', [PlantaoController::class, 'index'])->name('plantoes.index');
    Route::get('/plantoes/create', [PlantaoController::class, 'create'])->name('plantoes.create');
    Route::post('/plantoes', [PlantaoController::class, 'store'])->name('plantoes.store');
    
});



require __DIR__.'/auth.php';
