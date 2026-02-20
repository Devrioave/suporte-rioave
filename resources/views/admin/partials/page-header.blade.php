@if(session('sucesso'))
    <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-r-xl shadow-sm animate-fade-in dark:bg-green-900/20 dark:border-green-500/70">
        <p class="text-sm font-bold text-green-800 dark:text-green-200">✅ {{ session('sucesso') }}</p>
    </div>
@endif

<div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
        <h2 class="text-2xl font-bold text-gray-800 tracking-tight dark:text-slate-100">Gestão de Chamados</h2>
        <p class="text-sm text-gray-500 mt-1 dark:text-slate-300">Visualize detalhes, anexos e atualize o status dos pedidos.</p>
    </div>
</div>
