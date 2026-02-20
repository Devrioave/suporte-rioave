<?php

namespace App\Http\Controllers;

use App\Models\Solicitacao;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $totalChamados = Solicitacao::count();
        $totalResolvidos = Solicitacao::where('status', 'resolvido')->count();

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

        $foraDoSla = Solicitacao::where('status', '!=', 'resolvido')
            ->where('created_at', '<', now()->subDay())
            ->count();

        $prioridades = Solicitacao::select('prioridade', DB::raw('count(*) as total'))
            ->groupBy('prioridade')
            ->pluck('total', 'prioridade');

        $statusCounts = Solicitacao::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        $estatisticasMotivo = Solicitacao::select('motivo_contato', DB::raw('count(*) as total'))
            ->groupBy('motivo_contato')
            ->get();

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
}
