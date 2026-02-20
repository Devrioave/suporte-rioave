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
                    <div id="modalAnexos" class="grid grid-cols-3 md:grid-cols-4 gap-4"></div>
                </div>

                <div class="grid md:grid-cols-4 gap-6 pt-6 border-t border-gray-100 dark:border-slate-700">
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
                    <div>
                        <label class="text-[10px] font-black text-gray-400 dark:text-slate-400 uppercase block mb-2">Responsavel</label>
                        <select name="responsavel_id" id="modalResponsavel" class="w-full rounded-xl border-gray-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-sm font-bold dark:text-slate-100 focus:ring-blue-500">
                            <option value="">Nao atribuido</option>
                            @foreach($usuarios as $usuario)
                                <option value="{{ $usuario->id }}">{{ $usuario->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex items-end">
                        <button type="submit" class="w-full bg-blue-600 text-white font-bold py-3 rounded-xl hover:bg-blue-700 transition-all active:scale-[0.99]">
                            Salvar Alterações
                        </button>
                    </div>
                </div>

                <div>
                    <label class="text-[10px] font-black text-gray-400 dark:text-slate-400 uppercase block mb-2">Historico de Alteracoes</label>
                    <div id="modalHistorico" class="space-y-2 text-xs text-gray-600 dark:text-slate-300"></div>
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
