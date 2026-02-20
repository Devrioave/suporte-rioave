<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Rio Ave - Acesso Administrativo</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <script>
        (() => {
            const savedTheme = localStorage.getItem('theme');
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            const shouldUseDark = savedTheme ? savedTheme === 'dark' : prefersDark;
            document.documentElement.classList.toggle('dark', shouldUseDark);
        })();
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-gray-900 antialiased dark:text-slate-100">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-br from-gray-50 to-blue-50 dark:from-slate-950 dark:to-slate-900 px-4">
        <div class="w-full max-w-md flex justify-end mb-4">
            <button id="theme-toggle"
                    type="button"
                    class="px-3 py-2 rounded-lg border border-gray-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-gray-700 dark:text-slate-200 hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors text-sm font-semibold">
                <span class="mr-2">Modo noturno</span>
                <span id="theme-toggle-state" class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-bold bg-gray-200 text-gray-700">OFF</span>
            </button>
        </div>
        
        <div class="w-full sm:max-w-md px-8 py-12 bg-white dark:bg-slate-900 shadow-[0_20px_60px_rgba(8,_112,_184,_0.1)] border border-gray-100 dark:border-slate-700 overflow-hidden sm:rounded-[2.5rem]">
            {{ $slot }}
        </div>

        <div class="mt-10 text-center">
            <p class="text-[10px] text-gray-400 font-black tracking-[0.3em] uppercase opacity-60">
                Rio Ave • Painel Seguro
            </p>
        </div>
    </div>
    <script>
        function applyTheme(isDark) {
            document.documentElement.classList.toggle('dark', isDark);
            localStorage.setItem('theme', isDark ? 'dark' : 'light');
            const toggle = document.getElementById('theme-toggle');
            const state = document.getElementById('theme-toggle-state');

            if (toggle) {
                toggle.setAttribute('aria-pressed', isDark ? 'true' : 'false');
            }

            if (state) {
                state.textContent = isDark ? 'ON' : 'OFF';
                state.className = isDark
                    ? 'inline-flex items-center rounded-full px-2 py-0.5 text-xs font-bold bg-emerald-100 text-emerald-700'
                    : 'inline-flex items-center rounded-full px-2 py-0.5 text-xs font-bold bg-gray-200 text-gray-700';
            }
        }

        const themeToggle = document.getElementById('theme-toggle');
        if (themeToggle) {
            const isDark = document.documentElement.classList.contains('dark');
            applyTheme(isDark);
            themeToggle.addEventListener('click', () => {
                const shouldUseDark = !document.documentElement.classList.contains('dark');
                applyTheme(shouldUseDark);
            });
        }
    </script>
</body>
</html>
