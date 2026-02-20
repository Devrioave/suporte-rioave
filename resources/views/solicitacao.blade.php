@extends('layouts.app')

@section('title', 'Nova Solicitação')

@section('content')
<div class="max-w-3xl mx-auto bg-white p-10 rounded-lg shadow-md border border-gray-100">
    
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Criar Nova Solicitação</h2>

   @if(session('sucesso'))
    <div class="mb-8 animate-fade-in">
        <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-r-lg shadow-sm mb-4">
            <div class="flex items-center">
                <span class="text-green-600 text-xl mr-3">✅</span>
                <p class="text-green-800 font-bold">{{ session('sucesso') }}</p>
            </div>
        </div>

        @if(session('protocolo'))
            <div class="bg-blue-600 rounded-xl p-6 text-white shadow-xl transform transition-all hover:scale-[1.01]">
                <p class="text-blue-100 text-xs uppercase font-black tracking-widest mb-2">Seu Número de Protocolo</p>
                <div class="flex items-center justify-between">
                    <h3 id="protocol-number" class="text-3xl font-mono font-bold">{{ session('protocolo') }}</h3>
                    <div class="flex items-center gap-2">
                        <button id="copy-protocol-btn" type="button" onclick="copyProtocol()" class="bg-blue-500 text-white px-4 py-2 rounded-lg text-sm font-bold hover:bg-blue-400 transition-colors">
                            Copiar protocolo
                        </button>
                        <a href="{{ route('protocolo.index') }}" class="bg-white text-blue-600 px-4 py-2 rounded-lg text-sm font-bold hover:bg-blue-50 transition-colors">
                            Acompanhar agora
                        </a>
                    </div>
                </div>
                <p id="copy-protocol-feedback" class="mt-2 text-xs text-blue-100 hidden">Protocolo copiado para a area de transferencia.</p>
                <p class="mt-4 text-sm text-blue-100 italic">* Guarde este número para consultar o status do seu chamado futuramente.</p>
            </div>
        @endif
    </div>
@endif

    <form action="{{ route('solicitacao.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-6">
            <label for="nome" class="block text-gray-700 font-bold mb-2">* Nome do solicitante</label>
            <input type="text" id="nome" name="nome_solicitante" placeholder="Digite seu nome completo" value="{{ old('nome_solicitante') }}"
                class="w-full p-3 border @error('nome_solicitante') border-red-500 @else border-gray-300 @enderror rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            @error('nome_solicitante') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
        </div>

        <div class="mb-6">
            <label for="telefone" class="block text-gray-700 font-bold mb-2">* Número de telefone do solicitante</label>
            <div class="flex gap-2">
                <span class="inline-flex items-center px-3 border border-gray-300 bg-gray-50 rounded-md text-xl">🇧🇷</span>
                <input type="text" id="telefone" name="telefone_solicitante" placeholder="(99) 99999-9999" value="{{ old('telefone_solicitante') }}"
                    class="w-full p-3 border @error('telefone_solicitante') border-red-500 @else border-gray-300 @enderror rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            @error('telefone_solicitante') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
        </div>

        <div class="mb-6">
            <label for="email" class="block text-gray-700 font-bold mb-2">* E-mail do solicitante</label>
            <input type="email" id="email" name="email_solicitante" placeholder="email@exemplo.com" value="{{ old('email_solicitante') }}"
                class="w-full p-3 border @error('email_solicitante') border-red-500 @else border-gray-300 @enderror rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            @error('email_solicitante') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 font-bold mb-2">* Motivo do contato</label>
            <div class="flex flex-wrap gap-4 mt-2">
                @foreach(['suporte' => 'Suporte técnico', 'duvida' => 'Dúvida', 'solicitacao' => 'Solicitação', 'outro' => 'Outro'] as $value => $label)
                    <label class="flex items-center cursor-pointer group">
                        <input type="radio" name="motivo_contato" value="{{ $value }}" class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500" {{ old('motivo_contato') == $value ? 'checked' : '' }}>
                        <span class="ml-2 text-gray-700 group-hover:text-blue-600 transition-colors">{{ $label }}</span>
                    </label>
                @endforeach
            </div>
            @error('motivo_contato') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
        </div>

        <div class="mb-6">
            <label for="descricao" class="block text-gray-700 font-bold mb-2">Descreva sua dúvida</label>
            <p class="text-gray-500 text-sm mb-2">Forneça detalhes para que possamos ajudar melhor.</p>
            <textarea id="descricao" name="descricao_duvida" rows="4" placeholder="Descreva aqui o seu problema..."
                class="w-full p-3 border @error('descricao_duvida') border-red-500 @else border-gray-300 @enderror rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('descricao_duvida') }}</textarea>
            @error('descricao_duvida') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
        </div>

        <div class="mb-8 p-6 rounded-xl border-2 border-dashed border-blue-200 bg-blue-50 dark:border-blue-700/60 dark:bg-slate-900/60">
            <label class="block font-bold mb-2 text-blue-800 dark:text-blue-200">Anexos e Evidências</label>
            <p class="text-sm mb-4 text-blue-600 dark:text-blue-300">Você pode selecionar múltiplos arquivos (Imagens ou PDF).</p>
            
            <input type="file" name="anexo[]" multiple 
                class="block w-full rounded-lg border border-blue-200/80 bg-white/80 px-3 py-2 text-sm text-gray-600
                file:mr-4 file:rounded-lg file:border-0 file:bg-blue-600 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-white hover:file:bg-blue-700
                dark:border-slate-600 dark:bg-slate-800/70 dark:text-slate-300 dark:file:bg-blue-500 dark:hover:file:bg-blue-400
                focus:outline-none focus:ring-2 focus:ring-blue-500/60">
            
            <p class="mt-3 text-xs text-blue-500 dark:text-blue-300/90">Limite: 2MB por arquivo. Formatos: JPG, PNG, PDF.</p>
            @error('anexo.*') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
        </div>

        <button type="submit" class="w-full md:w-48 bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 px-6 rounded-lg shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-1">
            Enviar Solicitação
        </button>
    </form>
</div>
<script>
    async function copyProtocol() {
        const protocolEl = document.getElementById('protocol-number');
        const feedbackEl = document.getElementById('copy-protocol-feedback');
        const copyBtn = document.getElementById('copy-protocol-btn');
        if (!protocolEl || !feedbackEl || !copyBtn) return;

        const protocol = protocolEl.textContent.trim();

        try {
            if (navigator.clipboard && window.isSecureContext) {
                await navigator.clipboard.writeText(protocol);
            } else {
                const tempInput = document.createElement('input');
                tempInput.value = protocol;
                document.body.appendChild(tempInput);
                tempInput.select();
                document.execCommand('copy');
                document.body.removeChild(tempInput);
            }

            feedbackEl.textContent = 'Protocolo copiado para a area de transferencia.';
            feedbackEl.classList.remove('hidden');
            copyBtn.textContent = 'Copiado!';
            setTimeout(() => {
                feedbackEl.classList.add('hidden');
                copyBtn.textContent = 'Copiar protocolo';
            }, 1800);
        } catch (error) {
            feedbackEl.textContent = 'Nao foi possivel copiar automaticamente.';
            feedbackEl.classList.remove('hidden');
        }
    }
</script>
@endsection
