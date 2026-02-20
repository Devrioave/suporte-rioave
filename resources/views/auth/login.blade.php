<x-guest-layout>
    <div class="mb-8">
        <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full border border-slate-300 bg-slate-100 text-slate-700 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200 text-[10px] font-black uppercase tracking-[0.2em]">
            Painel Administrativo
        </div>
        <h2 class="mt-4 text-3xl font-black text-gray-900 dark:text-slate-100 tracking-tight leading-tight">Acesso restrito</h2>
        <p class="text-sm text-gray-500 dark:text-slate-300 font-medium mt-2">Autentique-se para gerenciar chamados, status e respostas técnicas.</p>
        <div class="mt-4 rounded-2xl border border-amber-200 bg-amber-50 px-4 py-3 dark:border-amber-700/60 dark:bg-amber-900/20">
            <p class="text-[11px] font-bold uppercase tracking-wider text-amber-700 dark:text-amber-200">Uso interno • Equipe autorizada</p>
        </div>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <div class="space-y-2">
            <label for="email" class="text-[10px] font-black text-gray-400 dark:text-slate-400 uppercase tracking-widest block">E-mail Corporativo</label>
            <x-text-input id="email" class="block w-full !rounded-2xl !px-4 !py-3.5 !border-slate-200 !bg-white/95 dark:!border-slate-700 dark:!bg-slate-800/80 focus:!ring-2 focus:!ring-blue-400/40" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="space-y-2">
            <div class="flex justify-between items-center">
                <label for="password" class="text-[10px] font-black text-gray-400 dark:text-slate-400 uppercase tracking-widest block">Senha</label>
                @if (Route::has('password.request'))
                    <a class="text-[10px] font-black text-blue-600 dark:text-blue-300 hover:text-blue-800 dark:hover:text-blue-200 uppercase tracking-[0.15em]" href="{{ route('password.request') }}">
                        Esqueceu?
                    </a>
                @endif
            </div>
            <x-text-input id="password" class="block w-full !rounded-2xl !px-4 !py-3.5 !border-slate-200 !bg-white/95 dark:!border-slate-700 dark:!bg-slate-800/80 focus:!ring-2 focus:!ring-blue-400/40"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between rounded-2xl border border-dashed border-slate-300 dark:border-slate-700 px-4 py-3 bg-slate-50/80 dark:bg-slate-800/40">
            <label for="remember_me" class="inline-flex items-center group cursor-pointer">
                <input id="remember_me" type="checkbox" class="rounded-lg border-slate-300 dark:border-slate-600 text-blue-600 shadow-sm focus:ring-blue-500 transition-all" name="remember">
                <span class="ms-2 text-xs font-bold text-gray-600 dark:text-slate-300 group-hover:text-gray-800 dark:group-hover:text-slate-100 transition-colors uppercase tracking-widest">Manter conectado</span>
            </label>
            <span class="text-[10px] font-black uppercase tracking-[0.15em] text-gray-400 dark:text-slate-500">SSL</span>
        </div>

        <div class="flex flex-col gap-3 pt-2">
            <button type="submit" class="w-full bg-slate-900 dark:bg-blue-600 text-white font-black py-4 rounded-2xl hover:bg-slate-800 dark:hover:bg-blue-700 transition-all active:scale-[0.98] uppercase tracking-[0.2em] text-xs shadow-lg shadow-slate-300/60 dark:shadow-blue-900/30">
                Entrar no Admin
            </button>

            <a href="/" class="w-full text-center py-3 text-[10px] font-black text-gray-500 dark:text-slate-400 hover:text-gray-700 dark:hover:text-slate-200 uppercase tracking-[0.2em] transition-colors border border-dashed border-gray-300 dark:border-slate-700 rounded-2xl hover:border-gray-500 dark:hover:border-slate-500">
                Voltar para o Site
            </a>
        </div>
    </form>
</x-guest-layout>
