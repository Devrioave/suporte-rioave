<?php

namespace App\Http\Controllers;

use App\Models\Solicitacao;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PublicSolicitacaoController extends Controller
{
    public function store(Request $request)
    {
        $dados = $request->validate([
            'nome_solicitante' => 'required|string|max:255',
            'telefone_solicitante' => 'required',
            'email_solicitante' => 'required|email',
            'motivo_contato' => 'required',
            'descricao_duvida' => 'required',
            'prioridade' => 'nullable|in:baixa,media,alta,urgente',
            'anexo.*' => 'nullable|file|mimes:jpg,png,pdf|max:2048',
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
        $solicitacao = Solicitacao::create($dados);
        $solicitacao->historicos()->create([
            'user_id' => null,
            'acao' => 'Chamado criado',
            'detalhes' => ['changes' => ['Registro inicial do chamado']],
        ]);

        return back()->with('sucesso', 'Solicitação enviada!')
            ->with('protocolo', $protocolo);
    }

    public function acompanhar(Request $request)
    {
        $request->validate(['protocolo' => 'required|string']);
        $solicitacao = Solicitacao::where('protocolo', $request->protocolo)->first();

        return view('acompanhar', compact('solicitacao'))->with('busca_realizada', true);
    }
}
