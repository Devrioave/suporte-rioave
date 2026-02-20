<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SolicitacaoHistorico extends Model
{
    protected $fillable = [
        'solicitacao_id',
        'user_id',
        'acao',
        'detalhes',
    ];

    protected $casts = [
        'detalhes' => 'array',
    ];

    public function solicitacao(): BelongsTo
    {
        return $this->belongsTo(Solicitacao::class);
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
