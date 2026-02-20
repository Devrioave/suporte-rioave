<?php

namespace App\Http\Controllers;

use App\Models\Solicitacao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class SolicitacaoController extends Controller
{
    /**
     * Exibe o resumo operacional e métricas avançadas (Dashboard).
     */
    public function dashboard()
    {
        // KPIs de Eficiência
        $totalChamados = Solicitacao::count();
        $totalResolvidos = Solicitacao::where('status', 'resolvido')->count();
        
        // Cálculo do Tempo Médio de Resolução (TMR) em horas
        $tmrQuery = Solicitacao::where('status', 'resolvido')
            ->whereNotNull('resolvido_em');

        $driver = DB::connection()->getDriverName();
        if ($driver === 'sqlite') {
            $tmrHoras = $tmrQuery
                ->selectRaw('AVG((julianday(resolvido_em) - julianday(created_at)) * 24) as avg_tmr')
                ->value('avg_tmr') ?? 0;
        } else {
            $tmrHoras = $tmrQuery
                ->selectRaw('AVG(TIMESTAMPDIFF(HOUR, created_at, resolvido_em)) as avg_tmr')
                ->value('avg_tmr') ?? 0;
        }

        // SLA: Chamados abertos há mais de 24h sem resolução
        $foraDoSla = Solicitacao::where('status', '!=', 'resolvido')
            ->where('created_at', '<', now()->subDay())
            ->count();

        // Distribuição por Prioridade para o Gráfico de Radar
        $prioridades = Solicitacao::select('prioridade', DB::raw('count(*) as total'))
            ->groupBy('prioridade')
            ->pluck('total', 'prioridade');

        // Agrupamento por status para os indicadores rápidos
        $statusCounts = Solicitacao::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        // Volume por motivo para o gráfico de barras
        $estatisticasMotivo = Solicitacao::select('motivo_contato', DB::raw('count(*) as total'))
            ->groupBy('motivo_contato')
            ->get();

        // Tendência dos últimos 7 dias para o gráfico de linha
        $tendenciaSemanal = Solicitacao::selectRaw('DATE(created_at) as data, count(*) as total')
            ->where('created_at', '>=', now()->subDays(7))
            ->groupBy('data')
            ->orderBy('data')
            ->get();

        return view('dashboard', compact(
            'totalChamados', 
            'totalResolvidos',
            'tmrHoras', 
            'foraDoSla', 
            'prioridades', 
            'statusCounts', 
            'estatisticasMotivo', 
            'tendenciaSemanal'
        ));
    }

    /**
     * Exibe a listagem administrativa de chamados.
     */
    public function index()
    {
        $status = request('status');
        $prioridade = request('prioridade');
        $busca = trim((string) request('q', ''));
        $dataInicio = request('data_inicio');
        $dataFim = request('data_fim');

        $sort = request('sort', 'created_at');
        $direction = request('direction', 'desc');

        $allowedSorts = ['created_at', 'protocolo', 'nome_solicitante', 'status', 'prioridade'];
        if (!in_array($sort, $allowedSorts, true)) {
            $sort = 'created_at';
        }

        if (!in_array($direction, ['asc', 'desc'], true)) {
            $direction = 'desc';
        }

        $query = Solicitacao::query()
            ->when($status, fn ($query) => $query->where('status', $status))
            ->when($prioridade, fn ($query) => $query->where('prioridade', $prioridade))
            ->when($busca !== '', function ($query) use ($busca) {
                $query->where(function ($subQuery) use ($busca) {
                    $subQuery->where('protocolo', 'like', "%{$busca}%")
                        ->orWhere('nome_solicitante', 'like', "%{$busca}%")
                        ->orWhere('email_solicitante', 'like', "%{$busca}%")
                        ->orWhere('descricao_duvida', 'like', "%{$busca}%");
                });
            })
            ->when($dataInicio, fn ($query) => $query->whereDate('created_at', '>=', $dataInicio))
            ->when($dataFim, fn ($query) => $query->whereDate('created_at', '<=', $dataFim));

        if ($sort === 'created_at') {
            $query->orderBy('created_at', $direction)->orderBy('id', $direction);
        } else {
            $query->orderBy($sort, $direction)->orderByDesc('created_at')->orderByDesc('id');
        }

        $chamados = $query->paginate(12)->withQueryString();

        return view('admin.index', compact('chamados'));
    }

    /**
     * Atualiza o chamado e automatiza métricas de tempo.
     */
    public function update(Request $request, Solicitacao $solicitacao)
    {
        $request->validate([
            'status' => 'required|in:novo,pendente,em_andamento,resolvido',
            'prioridade' => 'nullable|in:baixa,media,alta,urgente',
            'resposta_admin' => 'nullable|string'
        ]);

        $dados = [
            'status' => $request->status,
            'resposta_admin' => $request->resposta_admin,
            'prioridade' => $request->prioridade ?? $solicitacao->prioridade
        ];

        // Lógica sênior: registra automaticamente o tempo de conclusão se finalizado
        if ($request->status === 'resolvido' && $solicitacao->status !== 'resolvido') {
            $dados['resolvido_em'] = now();
        }

        $solicitacao->update($dados);

        return back()->with('sucesso', 'Chamado atualizado com sucesso!');
    }

    /**
     * Remove o chamado permanentemente.
     */
    public function destroy(Solicitacao $solicitacao)
    {
        $solicitacao->delete();
        return back()->with('sucesso', 'Chamado excluído permanentemente.');
    }

    /**
     * Cria a solicitação e gera o protocolo.
     */
    public function store(Request $request)
    {
        $dados = $request->validate([
            'nome_solicitante'     => 'required|string|max:255',
            'telefone_solicitante' => 'required',
            'email_solicitante'    => 'required|email',
            'motivo_contato'       => 'required',
            'descricao_duvida'     => 'required',
            'prioridade'           => 'nullable|in:baixa,media,alta,urgente',
            'anexo.*'              => 'nullable|file|mimes:jpg,png,pdf|max:2048', 
        ]);

        $protocolo = date('Ymd') . '-' . strtoupper(Str::random(6));
        $dados['protocolo'] = $protocolo;
        $dados['prioridade'] = $request->prioridade ?? 'media';

        if ($request->hasFile('anexo')) {
            $arquivosSalvos = [];
            foreach ($request->file('anexo') as $arquivo) {
                $arquivosSalvos[] = $arquivo->store('evidencias', 'public');
            }
            $dados['arquivo_anexo'] = json_encode($arquivosSalvos); 
        }

        unset($dados['anexo']); 
        Solicitacao::create($dados);

        return back()->with('sucesso', 'Solicitação enviada!')
                     ->with('protocolo', $protocolo);
    }

    /**
     * Consulta pública de protocolo.
     */
    public function acompanhar(Request $request)
    {
        $request->validate(['protocolo' => 'required|string']);
        $solicitacao = Solicitacao::where('protocolo', $request->protocolo)->first();

        return view('acompanhar', compact('solicitacao'))->with('busca_realizada', true);
    }
}
