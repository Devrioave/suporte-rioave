<script>
    function openTicketModal(id, status, prioridade, responsavelId, resposta, descricao, anexosJson, protocolo, historicoJson, mode = 'details') {
        document.getElementById('ticketForm').action = `/admin/chamados/${id}`;
        document.getElementById('modalStatus').value = status;
        document.getElementById('modalPrioridade').value = prioridade || 'media';
        document.getElementById('modalResponsavel').value = responsavelId || '';
        document.getElementById('modalResposta').value = resposta;
        document.getElementById('modalDescricao').textContent = descricao;
        document.getElementById('modalProtocolo').textContent = protocolo;

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

        const historyContainer = document.getElementById('modalHistorico');
        historyContainer.innerHTML = '';

        if (historicoJson && historicoJson !== '[]') {
            const historicos = JSON.parse(historicoJson);
            historicos.forEach(item => {
                const details = (item.changes || []).map(change => `<li>${change}</li>`).join('');
                historyContainer.innerHTML += `
                    <div class="rounded-xl border border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-800 p-3">
                        <p class="font-bold text-gray-700 dark:text-slate-100">${item.acao}</p>
                        <p class="text-[11px] text-gray-500 dark:text-slate-400 mt-1">${item.data} • ${item.usuario}</p>
                        ${details ? `<ul class="mt-2 list-disc list-inside space-y-1">${details}</ul>` : ''}
                    </div>
                `;
            });
        } else {
            historyContainer.innerHTML = '<p class="text-xs text-gray-400 dark:text-slate-400 italic">Sem historico de alteracoes.</p>';
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
