@php
    $headerActionBase = 'inline-flex items-center gap-2 px-3 py-2 rounded-xl text-sm font-semibold border border-transparent transition-all duration-200 hover:-translate-y-px hover:bg-slate-100 dark:hover:bg-slate-700 hover:text-blue-600 dark:hover:text-blue-300 active:translate-y-0 active:scale-95 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-300/70 dark:focus-visible:ring-blue-500/60';
    $headerActionActive = 'bg-blue-50 text-blue-700 border-blue-200 shadow-sm dark:bg-blue-900/30 dark:text-blue-200 dark:border-blue-700/70';
    $headerActionIdle = 'text-gray-700 dark:text-slate-200';
@endphp

<header class="sticky top-0 z-50 border-b border-slate-200/80 dark:border-slate-700/80 bg-white/90 dark:bg-slate-900/90 backdrop-blur">
    <nav class="container mx-auto px-6 py-4 flex items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <a href="{{ route('home') }}" class="flex items-center gap-2 transition-opacity hover:opacity-80">
                <img src="{{ asset('images/logo.png') }}?v={{ filemtime(public_path('images/logo.png')) }}" alt="Logo Rio Ave" class="h-10 w-auto">
            </a>
        </div>

        <div class="flex items-center gap-3">
            <button id="theme-toggle"
                    type="button"
                    class="{{ $headerActionBase }} {{ $headerActionIdle }} border-slate-300 dark:border-slate-700 bg-white/85 dark:bg-slate-800/90">
                <span class="mr-2">Tema</span>
                <span id="theme-toggle-state" class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-bold bg-gray-200 text-gray-700">OFF</span>
            </button>

            <div class="hidden md:flex items-center gap-2 rounded-2xl border border-slate-200/90 dark:border-slate-700/90 bg-white/80 dark:bg-slate-800/80 px-2 py-1.5 font-medium shadow-sm">
                @auth
                    <a href="{{ route('admin.user.create') }}" class="{{ $headerActionBase }} {{ request()->routeIs('admin.user.create') ? $headerActionActive : $headerActionIdle }}">
                        Novo Membro
                    </a>

                    <a href="{{ route('admin.index') }}" class="{{ $headerActionBase }} {{ request()->routeIs('admin.index') ? $headerActionActive : $headerActionIdle }}">
                        Controle de Chamados
                    </a>

                    <a href="{{ route('dashboard') }}" class="{{ $headerActionBase }} {{ request()->routeIs('dashboard') ? $headerActionActive : $headerActionIdle }}">
                        Dashboard
                    </a>

                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="{{ $headerActionBase }} text-red-600 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300 hover:bg-red-50 dark:hover:bg-red-900/20 border-red-200/70 dark:border-red-800/40">
                            Sair
                        </button>
                    </form>
                @else
                    <a href="{{ route('protocolo.index') }}" class="{{ $headerActionBase }} {{ request()->routeIs('protocolo.index') ? $headerActionActive : $headerActionIdle }}">
                        Acompanhar Chamado
                    </a>

                    <a href="{{ route('home') }}" class="{{ $headerActionBase }} {{ request()->routeIs('home') ? $headerActionActive : $headerActionIdle }}">
                        Abrir Chamado
                    </a>

                    <a href="{{ route('login') }}" class="{{ $headerActionBase }} {{ request()->routeIs('login') ? $headerActionActive : $headerActionIdle }}">
                        Área de Membros
                    </a>
                @endauth
            </div>
        </div>
    </nav>
</header>
