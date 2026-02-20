<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminChamadoController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PublicSolicitacaoController;
use App\Http\Controllers\ChatBotController; // Importação adicionada para limpeza
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Rotas Públicas (Rio Ave - Suporte Técnico)
|--------------------------------------------------------------------------
*/

Route::middleware('web')->group(function () {
// Formulário de abertura de chamado
Route::get('/', function () {
    return view('solicitacao');
})->name('home');

// Processamento do envio do chamado
Route::post('/enviar', [PublicSolicitacaoController::class, 'store'])->name('solicitacao.store');

// ROTAS DE PROTOCOLO (PÚBLICAS)
Route::get('/acompanhar', function () {
    return view('acompanhar');
})->name('protocolo.index');

Route::post('/acompanhar-busca', [PublicSolicitacaoController::class, 'acompanhar'])->name('protocolo.buscar');

// Rota para o ChatBot Inteligente (PÚBLICA)
Route::post('/chatbot', [ChatBotController::class, 'handle'])->name('chatbot.handle');

/*
|--------------------------------------------------------------------------
| Rotas Protegidas (Painel Administrativo)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard e Listagem principal
    Route::get('/dashboard', DashboardController::class)->name('dashboard');
    Route::get('/admin', [AdminChamadoController::class, 'index'])->name('admin.index');
    
    // Gerenciamento de Equipe (Criação de novos Admins)
    Route::get('/admin/novo-usuario', [RegisteredUserController::class, 'create'])->name('admin.user.create');
    Route::post('/admin/novo-usuario', [RegisteredUserController::class, 'store'])->name('admin.user.store');
    
    // Gestão de Chamados (Update de status/resposta e Delete)
    Route::patch('/admin/chamados/{solicitacao}', [AdminChamadoController::class, 'update'])->name('admin.chamados.update');
    Route::delete('/admin/chamados/{solicitacao}', [AdminChamadoController::class, 'destroy'])->name('admin.chamados.destroy');

    // Gestão de Perfil do Administrador
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
});
