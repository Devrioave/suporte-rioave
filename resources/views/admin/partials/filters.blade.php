<form method="GET" action="{{ route('admin.index') }}" class="mb-6 grid grid-cols-1 md:grid-cols-6 gap-3 bg-white dark:bg-slate-900 border border-gray-100 dark:border-slate-700/70 rounded-2xl p-4">
    <div class="md:col-span-2">
        <label for="q" class="block text-[10px] font-black uppercase tracking-widest text-gray-400 dark:text-slate-400 mb-2">Busca</label>
        <input type="text" id="q" name="q" value="{{ request('q') }}" placeholder="Protocolo, nome, e-mail..."
            class="w-full rounded-xl border-gray-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-sm dark:text-slate-100 focus:ring-blue-500">
    </div>
    <div>
        <label for="status" class="block text-[10px] font-black uppercase tracking-widest text-gray-400 dark:text-slate-400 mb-2">Status</label>
        <select id="status" name="status" class="w-full rounded-xl border-gray-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-sm dark:text-slate-100 focus:ring-blue-500">
            <option value="">Todos</option>
            <option value="novo" @selected(request('status') === 'novo')>Novo</option>
            <option value="pendente" @selected(request('status') === 'pendente')>Pendente</option>
            <option value="em_andamento" @selected(request('status') === 'em_andamento')>Em andamento</option>
            <option value="resolvido" @selected(request('status') === 'resolvido')>Resolvido</option>
        </select>
    </div>
    <div>
        <label for="prioridade" class="block text-[10px] font-black uppercase tracking-widest text-gray-400 dark:text-slate-400 mb-2">Prioridade</label>
        <select id="prioridade" name="prioridade" class="w-full rounded-xl border-gray-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-sm dark:text-slate-100 focus:ring-blue-500">
            <option value="">Todas</option>
            <option value="baixa" @selected(request('prioridade') === 'baixa')>Baixa</option>
            <option value="media" @selected(request('prioridade') === 'media')>Media</option>
            <option value="alta" @selected(request('prioridade') === 'alta')>Alta</option>
            <option value="urgente" @selected(request('prioridade') === 'urgente')>Urgente</option>
        </select>
    </div>
    <div>
        <label for="data_inicio" class="block text-[10px] font-black uppercase tracking-widest text-gray-400 dark:text-slate-400 mb-2">De</label>
        <input type="date" id="data_inicio" name="data_inicio" value="{{ request('data_inicio') }}"
            class="w-full rounded-xl border-gray-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-sm dark:text-slate-100 focus:ring-blue-500">
    </div>
    <div>
        <label for="data_fim" class="block text-[10px] font-black uppercase tracking-widest text-gray-400 dark:text-slate-400 mb-2">Ate</label>
        <input type="date" id="data_fim" name="data_fim" value="{{ request('data_fim') }}"
            class="w-full rounded-xl border-gray-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-sm dark:text-slate-100 focus:ring-blue-500">
    </div>
    <div class="md:col-span-6 flex items-center justify-end gap-2 pt-1">
        <a href="{{ route('admin.index') }}" class="px-4 py-2 rounded-xl border border-slate-300 dark:border-slate-700 text-xs font-bold uppercase tracking-wide text-gray-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition-all">
            Limpar
        </a>
        <button type="submit" class="px-4 py-2 rounded-xl bg-blue-600 text-white text-xs font-bold uppercase tracking-wide hover:bg-blue-700 transition-all">
            Filtrar
        </button>
    </div>
</form>
