<div class="bg-white shadow-2xl rounded-2xl overflow-hidden border border-gray-100 dark:bg-slate-900 dark:border-slate-700/70">
    <table class="min-w-full divide-y divide-gray-200 dark:divide-slate-700/80">
        <thead class="bg-gray-50/50 dark:bg-slate-800/60">
            <tr>
                <th class="px-6 py-4 text-left text-xs font-black text-gray-400 uppercase tracking-widest dark:text-slate-400">
                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'nome_solicitante', 'direction' => $currentSort === 'nome_solicitante' && $currentDirection === 'asc' ? 'desc' : 'asc', 'page' => 1]) }}" class="inline-flex items-center gap-1 hover:text-blue-600 dark:hover:text-blue-300">
                        Solicitante
                        @if($currentSort === 'nome_solicitante') {{ $currentDirection === 'asc' ? '▲' : '▼' }} @endif
                    </a>
                </th>
                <th class="px-6 py-4 text-left text-xs font-black text-gray-400 uppercase tracking-widest dark:text-slate-400">
                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'protocolo', 'direction' => $currentSort === 'protocolo' && $currentDirection === 'asc' ? 'desc' : 'asc', 'page' => 1]) }}" class="inline-flex items-center gap-1 hover:text-blue-600 dark:hover:text-blue-300">
                        Protocolo
                        @if($currentSort === 'protocolo') {{ $currentDirection === 'asc' ? '▲' : '▼' }} @endif
                    </a>
                </th>
                <th class="px-6 py-4 text-left text-xs font-black text-gray-400 uppercase tracking-widest dark:text-slate-400">
                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'status', 'direction' => $currentSort === 'status' && $currentDirection === 'asc' ? 'desc' : 'asc', 'page' => 1]) }}" class="inline-flex items-center gap-1 hover:text-blue-600 dark:hover:text-blue-300">
                        Status
                        @if($currentSort === 'status') {{ $currentDirection === 'asc' ? '▲' : '▼' }} @endif
                    </a>
                </th>
                <th class="px-6 py-4 text-left text-xs font-black text-gray-400 uppercase tracking-widest dark:text-slate-400">
                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'prioridade', 'direction' => $currentSort === 'prioridade' && $currentDirection === 'asc' ? 'desc' : 'asc', 'page' => 1]) }}" class="inline-flex items-center gap-1 hover:text-blue-600 dark:hover:text-blue-300">
                        Prioridade
                        @if($currentSort === 'prioridade') {{ $currentDirection === 'asc' ? '▲' : '▼' }} @endif
                    </a>
                </th>
                <th class="px-6 py-4 text-left text-xs font-black text-gray-400 uppercase tracking-widest dark:text-slate-400">
                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'created_at', 'direction' => $currentSort === 'created_at' && $currentDirection === 'asc' ? 'desc' : 'asc', 'page' => 1]) }}" class="inline-flex items-center gap-1 hover:text-blue-600 dark:hover:text-blue-300">
                        Abertura
                        @if($currentSort === 'created_at') {{ $currentDirection === 'asc' ? '▲' : '▼' }} @endif
                    </a>
                </th>
                <th class="px-6 py-4 text-left text-xs font-black text-gray-400 uppercase tracking-widest dark:text-slate-400">Responsavel</th>
                <th class="px-6 py-4 text-right text-xs font-black text-gray-400 uppercase tracking-widest dark:text-slate-400">Ações</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-100 dark:bg-slate-900 dark:divide-slate-800">
            @forelse($chamados as $chamado)
            <tr class="hover:bg-blue-50/40 dark:hover:bg-slate-800/40 transition-colors">
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm font-bold text-gray-900 dark:text-slate-100">{{ $chamado->nome_solicitante }}</div>
                    <div class="text-xs text-gray-500 dark:text-slate-400">{{ $chamado->email_solicitante }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap font-mono text-xs text-blue-600 font-bold dark:text-blue-300">
                    {{ $chamado->protocolo }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    @php
                        $statusClass = match ($chamado->status) {
                            'novo' => 'bg-sky-50 text-sky-700 border-sky-200 dark:bg-sky-900/20 dark:text-sky-200 dark:border-sky-700/70',
                            'pendente' => 'bg-amber-50 text-amber-700 border-amber-200 dark:bg-amber-900/20 dark:text-amber-200 dark:border-amber-700/70',
                            'em_andamento' => 'bg-violet-50 text-violet-700 border-violet-200 dark:bg-violet-900/20 dark:text-violet-200 dark:border-violet-700/70',
                            'resolvido' => 'bg-green-50 text-green-700 border-green-200 dark:bg-green-900/20 dark:text-green-200 dark:border-green-700/70',
                            default => 'bg-slate-50 text-slate-700 border-slate-200 dark:bg-slate-800/60 dark:text-slate-200 dark:border-slate-600',
                        };
                    @endphp
                    <span class="px-2.5 py-1 rounded-full text-[10px] font-black uppercase border {{ $statusClass }}">
                        {{ str_replace('_', ' ', $chamado->status) }}
                    </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    @php
                        $priorityClass = match ($chamado->prioridade) {
                            'baixa' => 'bg-emerald-50 text-emerald-700 border-emerald-200 dark:bg-emerald-900/20 dark:text-emerald-200 dark:border-emerald-700/70',
                            'media' => 'bg-sky-50 text-sky-700 border-sky-200 dark:bg-sky-900/20 dark:text-sky-200 dark:border-sky-700/70',
                            'alta' => 'bg-orange-50 text-orange-700 border-orange-200 dark:bg-orange-900/20 dark:text-orange-200 dark:border-orange-700/70',
                            'urgente' => 'bg-rose-50 text-rose-700 border-rose-200 dark:bg-rose-900/20 dark:text-rose-200 dark:border-rose-700/70',
                            default => 'bg-slate-50 text-slate-700 border-slate-200 dark:bg-slate-800/60 dark:text-slate-200 dark:border-slate-600',
                        };
                    @endphp
                    <span class="px-2.5 py-1 rounded-full text-[10px] font-black uppercase border {{ $priorityClass }}">
                        {{ $chamado->prioridade ?? 'media' }}
                    </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-600 dark:text-slate-300">
                    {{ optional($chamado->created_at)->format('d/m/Y H:i') }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-700 dark:text-slate-300 font-semibold">
                    {{ $chamado->responsavel?->name ?? 'Nao atribuido' }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                    @php
                        $historicoJson = addslashes($chamado->historicos->map(function ($item) {
                            return [
                                'acao' => $item->acao,
                                'usuario' => $item->usuario?->name ?? 'Sistema',
                                'changes' => $item->detalhes['changes'] ?? [],
                                'data' => optional($item->created_at)->format('d/m/Y H:i'),
                            ];
                        })->values()->toJson());
                    @endphp
                    <div class="inline-flex items-center gap-2">
                        <button type="button" onclick="openTicketModal({{ $chamado->id }}, '{{ addslashes($chamado->status) }}', '{{ addslashes($chamado->prioridade) }}', '{{ $chamado->responsavel_id }}', '{{ addslashes($chamado->resposta_admin) }}', '{{ addslashes($chamado->descricao_duvida) }}', '{{ $chamado->arquivo_anexo }}', '{{ $chamado->protocolo }}', '{{ $historicoJson }}', 'details')"
                            class="px-3 py-1.5 rounded-lg border border-slate-200 dark:border-slate-700 text-blue-700 dark:text-blue-300 bg-white dark:bg-slate-800 hover:bg-blue-50 dark:hover:bg-slate-700 text-[11px] font-bold uppercase tracking-wide transition-all active:scale-95">
                            Ver detalhes
                        </button>
                        <button type="button" onclick="openTicketModal({{ $chamado->id }}, '{{ addslashes($chamado->status) }}', '{{ addslashes($chamado->prioridade) }}', '{{ $chamado->responsavel_id }}', '{{ addslashes($chamado->resposta_admin) }}', '{{ addslashes($chamado->descricao_duvida) }}', '{{ $chamado->arquivo_anexo }}', '{{ $chamado->protocolo }}', '{{ $historicoJson }}', 'edit')"
                            class="px-3 py-1.5 rounded-lg border border-blue-200 dark:border-blue-700/70 text-white bg-blue-600 dark:bg-blue-500 hover:bg-blue-700 dark:hover:bg-blue-400 text-[11px] font-bold uppercase tracking-wide transition-all active:scale-95">
                            Editar
                        </button>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="px-6 py-10 text-center text-sm font-medium text-gray-500 dark:text-slate-400">
                    Nenhum chamado encontrado.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="px-6 py-4 border-t border-gray-100 dark:border-slate-700/70 bg-white dark:bg-slate-900">
        {{ $chamados->links() }}
    </div>
</div>
