@extends('layouts.app')

@section('title', 'Controle de Chamados - Rio Ave')

@section('content')
<div class="max-w-7xl mx-auto">
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

    @php
        $currentSort = request('sort', 'created_at');
        $currentDirection = request('direction', 'desc');
    @endphp

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
                        <span class="px-2.5 py-1 rounded-full text-[10px] font-black uppercase border 
                            {{ $statusClass }}">
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
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <div class="inline-flex items-center gap-2">
                            <button type="button" onclick="openTicketModal({{ $chamado->id }}, '{{ addslashes($chamado->status) }}', '{{ addslashes($chamado->prioridade) }}', '{{ addslashes($chamado->resposta_admin) }}', '{{ addslashes($chamado->descricao_duvida) }}', '{{ $chamado->arquivo_anexo }}', '{{ $chamado->protocolo }}', 'details')" 
                                class="px-3 py-1.5 rounded-lg border border-slate-200 dark:border-slate-700 text-blue-700 dark:text-blue-300 bg-white dark:bg-slate-800 hover:bg-blue-50 dark:hover:bg-slate-700 text-[11px] font-bold uppercase tracking-wide transition-all active:scale-95">
                                Ver detalhes
                            </button>
                            <button type="button" onclick="openTicketModal({{ $chamado->id }}, '{{ addslashes($chamado->status) }}', '{{ addslashes($chamado->prioridade) }}', '{{ addslashes($chamado->resposta_admin) }}', '{{ addslashes($chamado->descricao_duvida) }}', '{{ $chamado->arquivo_anexo }}', '{{ $chamado->protocolo }}', 'edit')" 
                                class="px-3 py-1.5 rounded-lg border border-blue-200 dark:border-blue-700/70 text-white bg-blue-600 dark:bg-blue-500 hover:bg-blue-700 dark:hover:bg-blue-400 text-[11px] font-bold uppercase tracking-wide transition-all active:scale-95">
                                Editar
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-10 text-center text-sm font-medium text-gray-500 dark:text-slate-400">
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
</div>

<div id="ticketModal" class="hidden fixed inset-0 z-[60] flex items-center justify-center bg-gray-900/60 backdrop-blur-sm p-4">
    <div class="bg-white dark:bg-slate-900 w-full max-w-3xl rounded-3xl shadow-2xl overflow-hidden animate-fade-in-up border border-gray-100 dark:border-slate-700/70">
        <form id="ticketForm" method="POST">
            @csrf @method('PATCH')
            
            <div class="bg-blue-600 p-6 text-white flex justify-between items-center">
                <div>
                    <p class="text-blue-100 text-[10px] font-black uppercase tracking-widest">Protocolo de Atendimento</p>
                    <h3 id="modalProtocolo" class="text-xl font-mono font-bold">---</h3>
                </div>
                <button type="button" onclick="closeModal()" class="text-white/80 hover:text-white text-3xl">&times;</button>
            </div>

            <div class="p-8 max-h-[75vh] overflow-y-auto space-y-8">
                <div>
                    <label class="text-[10px] font-black text-gray-400 dark:text-slate-400 uppercase block mb-2">Descrição do Cliente</label>
                    <p id="modalDescricao" class="text-sm text-gray-700 dark:text-slate-200 leading-relaxed bg-gray-50 dark:bg-slate-800 p-4 rounded-2xl italic border border-gray-100 dark:border-slate-700"></p>
                </div>

                <div>
                    <label class="text-[10px] font-black text-gray-400 dark:text-slate-400 uppercase block mb-3">Arquivos em Anexo</label>
                    <div id="modalAnexos" class="grid grid-cols-3 md:grid-cols-4 gap-4">
                        </div>
                </div>

                <div class="grid md:grid-cols-3 gap-6 pt-6 border-t border-gray-100 dark:border-slate-700">
                    <div>
                        <label class="text-[10px] font-black text-gray-400 dark:text-slate-400 uppercase block mb-2">Atualizar Status</label>
                        <select name="status" id="modalStatus" class="w-full rounded-xl border-gray-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-sm font-bold dark:text-slate-100 focus:ring-blue-500">
                            <option value="novo">Novo</option>
                            <option value="pendente">Pendente</option>
                            <option value="em_andamento">Em Andamento</option>
                            <option value="resolvido">Resolvido</option>
                        </select>
                    </div>
                    <div>
                        <label class="text-[10px] font-black text-gray-400 dark:text-slate-400 uppercase block mb-2">Prioridade</label>
                        <select name="prioridade" id="modalPrioridade" class="w-full rounded-xl border-gray-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-sm font-bold dark:text-slate-100 focus:ring-blue-500">
                            <option value="baixa">Baixa</option>
                            <option value="media">Media</option>
                            <option value="alta">Alta</option>
                            <option value="urgente">Urgente</option>
                        </select>
                    </div>
                    <div class="flex items-end">
                        <button type="submit" class="w-full bg-blue-600 text-white font-bold py-3 rounded-xl hover:bg-blue-700 transition-all active:scale-[0.99]">
                            Salvar Alterações
                        </button>
                    </div>
                </div>

                <div>
                    <label class="text-[10px] font-black text-gray-400 dark:text-slate-400 uppercase block mb-2">Resposta Técnica (Visível ao Cliente)</label>
                    <textarea name="resposta_admin" id="modalResposta" rows="4" 
                              class="w-full rounded-2xl border-gray-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-sm dark:text-slate-100 focus:ring-blue-500" 
                              placeholder="Escreva a solução ou orientações para o cliente aqui..."></textarea>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    function openTicketModal(id, status, prioridade, resposta, descricao, anexosJson, protocolo, mode = 'details') {
        // Configura o formulário
        document.getElementById('ticketForm').action = `/admin/chamados/${id}`;
        document.getElementById('modalStatus').value = status;
        document.getElementById('modalPrioridade').value = prioridade || 'media';
        document.getElementById('modalResposta').value = resposta;
        document.getElementById('modalDescricao').textContent = descricao;
        document.getElementById('modalProtocolo').textContent = protocolo;

        // Limpa e reconstrói a galeria de anexos
        const container = document.getElementById('modalAnexos');
        container.innerHTML = '';

        if (anexosJson && anexosJson !== 'null' && anexosJson !== '[]') {
            const anexos = JSON.parse(anexosJson);
            anexos.forEach(path => {
                const url = `/storage/${path}`;
                const ext = path.split('.').pop().toLowerCase();
                
                let html = '';
                if (['jpg', 'jpeg', 'png', 'gif'].includes(ext)) {
                    html = `<a href="${url}" target="_blank" class="block aspect-square rounded-xl overflow-hidden border border-gray-200 dark:border-slate-700 hover:opacity-80 transition-opacity">
                                <img src="${url}" class="w-full h-full object-cover">
                            </a>`;
                } else {
                    html = `<a href="${url}" target="_blank" class="flex items-center justify-center aspect-square rounded-xl bg-gray-100 dark:bg-slate-800 border border-gray-200 dark:border-slate-700 text-[10px] font-bold text-gray-500 dark:text-slate-300 uppercase hover:bg-gray-200 dark:hover:bg-slate-700">
                                📄 PDF
                            </a>`;
                }
                container.innerHTML += html;
            });
        } else {
            container.innerHTML = '<p class="text-xs text-gray-400 dark:text-slate-400 italic col-span-full">Nenhum anexo disponível.</p>';
        }

        document.getElementById('ticketModal').classList.remove('hidden');
        if (mode === 'edit') {
            setTimeout(() => document.getElementById('modalResposta').focus(), 80);
        }
    }

    function closeModal() {
        document.getElementById('ticketModal').classList.add('hidden');
    }
</script>
@endsection
