<footer class="bg-gray-900 text-gray-400 py-16 mt-auto border-t border-gray-800">
    <div class="container mx-auto px-6 grid grid-cols-1 md:grid-cols-4 gap-12">
        <div class="col-span-1">
            <div class="flex items-center gap-2 mb-6">
                <img src="{{ asset('images/logo.png') }}?v={{ filemtime(public_path('images/logo.png')) }}" alt="Rio Ave Logo" class="h-8 w-auto brightness-0 invert opacity-90">
            </div>
            <p class="text-sm leading-relaxed mb-6 italic border-l-2 border-blue-500 pl-4">
                "Soluções inteligentes que simplificam o seu suporte diário e impulsionam sua eficiência."
            </p>
        </div>

        <div>
            <h4 class="text-white font-bold mb-6 uppercase text-xs tracking-widest">Plataforma</h4>
            <ul class="space-y-4 text-sm font-medium">
                <li><a href="{{ route('home') }}" class="hover:text-white transition-colors">Nova Solicitação</a></li>
                <li><a href="{{ route('protocolo.index') }}" class="hover:text-white transition-colors">Acompanhar Chamado</a></li>
                @auth
                    <li><a href="{{ route('admin.index') }}" class="hover:text-white transition-colors">Controle de Chamados</a></li>
                @endauth
            </ul>
        </div>

        <div>
            <h4 class="text-white font-bold mb-6 uppercase text-xs tracking-widest">Empresa</h4>
            <ul class="space-y-4 text-sm font-medium">
                <li><a href="#" class="hover:text-white transition-colors">Política de Privacidade</a></li>
                <li><a href="#" class="hover:text-white transition-colors">Termos de Uso</a></li>
            </ul>
        </div>

        <div>
            <h4 class="text-white font-bold mb-6 uppercase text-xs tracking-widest">Contato</h4>
            <div class="space-y-4 text-sm text-gray-300">
                <p class="flex items-center gap-2 font-medium">📧 suporte@rioave.com.br</p>
                <p class="flex items-center gap-2 font-medium">📞 +55 (81) 98235-0502</p>
            </div>
        </div>
    </div>
    <div class="container mx-auto px-6 mt-16 pt-8 border-t border-gray-800/50 text-center text-xs">
        &copy; {{ date('Y') }} <strong>Rio Ave</strong>. Todos os direitos reservados.
    </div>
</footer>
