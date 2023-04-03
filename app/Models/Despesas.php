<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Despesas extends Model
{
    use HasFactory;

    /**
     * Definiçao do nome da chave primária
     *
     * @var string
     */
    protected $primaryKey = 'desp_id';

    protected $fillable = [
        'desp_descricao', 'desp_data', 'desp_valor',
    ];

    /**
     * garante o relacionamento de despesas do usuário
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Atributos do tipo data
     *
     * @var array
     */
    protected $dates = [
        'desp_data',
    ];
}


