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
            document.documentElement.classList.add('dark');
            localStorage.setItem('theme', 'dark');
        })();
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased text-slate-100">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-br from-[#0b1220] via-[#111c31] to-[#1a2942] px-4">
        <div class="w-full sm:max-w-md px-8 py-12 glass-surface overflow-hidden sm:rounded-[2.5rem]">
            {{ $slot }}
        </div>

        <div class="mt-10 text-center">
            <p class="text-[10px] text-gray-400 font-black tracking-[0.3em] uppercase opacity-60">
                Rio Ave • Painel Seguro
            </p>
        </div>
    </div>
</body>
</html>
