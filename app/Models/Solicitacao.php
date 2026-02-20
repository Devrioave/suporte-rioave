<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Solicitacao extends Model
{
    protected $fillable = [
        'protocolo',
        'nome_solicitante',
        'telefone_solicitante',
        'email_solicitante',
        'motivo_contato',
        'descricao_duvida',
        'arquivo_anexo',
        'status',
        'prioridade',
        'responsavel_id',
        'resposta_admin',
        'resolvido_em',
    ];

    public function responsavel(): BelongsTo
    {
        return $this->belongsTo(User::class, 'responsavel_id');
    }

    public function historicos(): HasMany
    {
        return $this->hasMany(SolicitacaoHistorico::class)->latest();
    }
}
