<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
        'resposta_admin',
        'resolvido_em',
    ];
}
