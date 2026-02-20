@extends('layouts.app')

@section('title', 'Cadastrar Novo Admin - Rio Ave')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 dark:text-slate-100 tracking-tight">Cadastrar Novo Administrador</h1>
            <p class="text-sm text-gray-500 dark:text-slate-400">Adicione um novo membro à equipe de suporte da Rio Ave.</p>
        </div>
        <a href="{{ route('admin.index') }}" class="text-sm font-medium text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 transition-colors">
            &larr; Voltar para Chamados
        </a>
    </div>

    <div class="bg-white dark:bg-slate-900 rounded-2xl overflow-hidden border border-gray-100 dark:border-slate-700">
        <div class="p-8">
            <form method="POST" action="{{ route('admin.user.store') }}">
                @csrf

                <div>
                    <label for="name" class="block text-sm font-semibold text-gray-700 dark:text-slate-300 mb-1">Nome Completo</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                           class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-slate-600 bg-white dark:bg-slate-800 text-gray-800 dark:text-slate-100 focus:ring-4 focus:ring-blue-50 dark:focus:ring-blue-900/40 focus:border-blue-500 transition-all outline-none"
                           placeholder="Ex: João Silva">
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <div class="mt-6">
                    <label for="email" class="block text-sm font-semibold text-gray-700 dark:text-slate-300 mb-1">Endereço de E-mail</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                           class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-slate-600 bg-white dark:bg-slate-800 text-gray-800 dark:text-slate-100 focus:ring-4 focus:ring-blue-50 dark:focus:ring-blue-900/40 focus:border-blue-500 transition-all outline-none"
                           placeholder="joao.admin@rioave.com.br">
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                    <div>
                        <label for="password" class="block text-sm font-semibold text-gray-700 dark:text-slate-300 mb-1">Senha de Acesso</label>
                        <input id="password" type="password" name="password" required autocomplete="new-password"
                               class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-slate-600 bg-white dark:bg-slate-800 text-gray-800 dark:text-slate-100 focus:ring-4 focus:ring-blue-50 dark:focus:ring-blue-900/40 focus:border-blue-500 transition-all outline-none"
                               placeholder="Mínimo 8 caracteres">
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 dark:text-slate-300 mb-1">Confirmar Senha</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                               class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-slate-600 bg-white dark:bg-slate-800 text-gray-800 dark:text-slate-100 focus:ring-4 focus:ring-blue-50 dark:focus:ring-blue-900/40 focus:border-blue-500 transition-all outline-none"
                               placeholder="Repita a senha">
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>
                </div>

                <div class="mt-10 flex items-center justify-end border-t border-gray-50 dark:border-slate-700 pt-6">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-xl font-bold transition-all transform active:scale-95">
                        Concluir Cadastro
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="mt-6 flex items-center gap-3 bg-amber-50 dark:bg-amber-950/30 border border-amber-100 dark:border-amber-800 p-4 rounded-xl">
        <span class="text-xl">⚠️</span>
        <p class="text-xs text-amber-800 dark:text-amber-300 leading-relaxed">
            <strong>Aviso de Segurança:</strong> Novos administradores terão acesso total ao sistema de chamados. 
            Certifique-se de que o e-mail cadastrado é de um membro confiável da equipe <strong>Rio Ave</strong>.
        </p>
    </div>
</div>
@endsection

