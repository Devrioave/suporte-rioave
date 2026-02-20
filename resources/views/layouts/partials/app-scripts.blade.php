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

    function toggleChat() {
        const chatWindow = document.getElementById('chat-window');
        const iconOpen = document.getElementById('bot-icon-open');
        const iconClose = document.getElementById('bot-icon-close');
        if (!chatWindow || !iconOpen || !iconClose) return;

        chatWindow.classList.toggle('hidden');
        iconOpen.classList.toggle('hidden');
        iconClose.classList.toggle('hidden');

        if (!chatWindow.classList.contains('hidden')) {
            const input = document.getElementById('chat-input');
            if (input) input.focus();
        }
    }

    async function handleChatSubmit(e) {
        e.preventDefault();
        const input = document.getElementById('chat-input');
        const messages = document.getElementById('chat-messages');
        if (!input || !messages) return;

        const text = input.value.trim();
        if (text === '') return;

        appendMessage(text, 'user');
        input.value = '';

        const typingId = 'typing-' + Date.now();
        const typingDiv = document.createElement('div');
        typingDiv.id = typingId;
        typingDiv.className = 'bg-gray-200 text-gray-500 p-2 rounded-lg self-start text-xs italic animate-pulse';
        typingDiv.textContent = '🤖 Bot está pensando...';
        messages.appendChild(typingDiv);
        messages.scrollTop = messages.scrollHeight;

        try {
            const response = await fetch("{{ route('chatbot.handle') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ message: text })
            });

            if (!response.ok) {
                throw new Error(`Erro HTTP: ${response.status}`);
            }

            const data = await response.json();
            const typingElement = document.getElementById(typingId);
            if (typingElement) {
                typingElement.remove();
            }

            const reply = data.response || data.message || 'Erro ao receber resposta do servidor.';
            appendMessage(reply, 'bot');
        } catch (error) {
            console.error('Erro no chatbot:', error);
            const typingElement = document.getElementById(typingId);
            if (typingElement) {
                typingElement.remove();
            }
            appendMessage('⚠️ Erro de conexão com o bot. Por favor, tente novamente.', 'bot');
        }
    }

    function appendMessage(text, side) {
        const messages = document.getElementById('chat-messages');
        if (!messages) return;

        const div = document.createElement('div');
        div.className = side === 'user'
            ? 'bg-blue-600 text-white p-3 rounded-lg shadow-sm self-end max-w-[80%] text-sm'
            : 'bg-white p-3 rounded-lg shadow-sm self-start max-w-[80%] border border-gray-100 text-sm text-gray-700';

        const sanitizedText = String(text)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;')
            .replace(/\n/g, '<br>');

        div.innerHTML = sanitizedText;
        messages.appendChild(div);
        messages.scrollTop = messages.scrollHeight;
    }
</script>
