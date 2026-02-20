<?php

namespace App\Http\Controllers;

use App\Models\Solicitacao;
use App\Models\User;
use Illuminate\Http\Request;

class AdminChamadoController extends Controller
{
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
            ->with([
                'responsavel:id,name',
                'historicos' => fn ($historyQuery) => $historyQuery->with('usuario:id,name')->take(10),
            ])
            ->when($status, fn ($builder) => $builder->where('status', $status))
            ->when($prioridade, fn ($builder) => $builder->where('prioridade', $prioridade))
            ->when($busca !== '', function ($builder) use ($busca) {
                $builder->where(function ($subQuery) use ($busca) {
                    $subQuery->where('protocolo', 'like', "%{$busca}%")
                        ->orWhere('nome_solicitante', 'like', "%{$busca}%")
                        ->orWhere('email_solicitante', 'like', "%{$busca}%")
                        ->orWhere('descricao_duvida', 'like', "%{$busca}%");
                });
            })
            ->when($dataInicio, fn ($builder) => $builder->whereDate('created_at', '>=', $dataInicio))
            ->when($dataFim, fn ($builder) => $builder->whereDate('created_at', '<=', $dataFim));

        if ($sort === 'created_at') {
            $query->orderBy('created_at', $direction)->orderBy('id', $direction);
        } else {
            $query->orderBy($sort, $direction)->orderByDesc('created_at')->orderByDesc('id');
        }

        $chamados = $query->paginate(12)->withQueryString();
        $usuarios = User::query()->orderBy('name')->get(['id', 'name']);

        return view('admin.index', compact('chamados', 'usuarios'));
    }

    public function update(Request $request, Solicitacao $solicitacao)
    {
        $request->validate([
            'status' => 'required|in:novo,pendente,em_andamento,resolvido',
            'prioridade' => 'nullable|in:baixa,media,alta,urgente',
            'responsavel_id' => 'nullable|exists:users,id',
            'resposta_admin' => 'nullable|string',
        ]);

        $oldStatus = $solicitacao->status;
        $oldPrioridade = $solicitacao->prioridade;
        $oldResponsavel = $solicitacao->responsavel_id;
        $oldResposta = $solicitacao->resposta_admin;

        $dados = [
            'status' => $request->status,
            'resposta_admin' => $request->resposta_admin,
            'prioridade' => $request->prioridade ?? $solicitacao->prioridade,
            'responsavel_id' => $request->responsavel_id ?: null,
        ];

        if ($request->status === 'resolvido' && $solicitacao->status !== 'resolvido') {
            $dados['resolvido_em'] = now();
        }
        if ($request->status !== 'resolvido' && $solicitacao->status === 'resolvido') {
            $dados['resolvido_em'] = null;
        }

        $solicitacao->update($dados);
        $solicitacao->refresh()->load('responsavel:id,name');

        $changes = [];
        if ($oldStatus !== $solicitacao->status) {
            $changes[] = "Status: {$oldStatus} -> {$solicitacao->status}";
        }
        if ($oldPrioridade !== $solicitacao->prioridade) {
            $changes[] = "Prioridade: {$oldPrioridade} -> {$solicitacao->prioridade}";
        }
        if ((int) $oldResponsavel !== (int) $solicitacao->responsavel_id) {
            $oldName = User::query()->where('id', $oldResponsavel)->value('name') ?? 'Sem responsavel';
            $newName = $solicitacao->responsavel?->name ?? 'Sem responsavel';
            $changes[] = "Responsavel: {$oldName} -> {$newName}";
        }
        if (trim((string) $oldResposta) !== trim((string) $solicitacao->resposta_admin)) {
            $changes[] = 'Resposta tecnica atualizada';
        }

        if (!empty($changes)) {
            $solicitacao->historicos()->create([
                'user_id' => auth()->id(),
                'acao' => 'Atualizacao manual do chamado',
                'detalhes' => ['changes' => $changes],
            ]);
        }

        return back()->with('sucesso', 'Chamado atualizado com sucesso!');
    }

    public function destroy(Solicitacao $solicitacao)
    {
        $solicitacao->delete();
        return back()->with('sucesso', 'Chamado excluído permanentemente.');
    }
}
