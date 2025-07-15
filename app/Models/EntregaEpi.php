<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EntregaEpi extends Model
{
    use HasFactory;

    protected $table = 'entrega_epis'; // Garante que o Laravel use o nome da tabela no plural corretamente

    protected $fillable = [
        'colaborador_id',
        'epi_id',
        'quantidade_entregue', // <--- CAMPO CORRIGIDO
        'data_entrega',
        'motivo' // <--- CAMPO CORRIGIDO
    ];

    // Relacionamento N:1 com Colaborador (uma entrega pertence a um colaborador)
    public function colaborador()
    {
        return $this->belongsTo(Colaborador::class);
    }

    // Relacionamento N:1 com Epi (uma entrega pertence a um EPI)
    public function epi()
    {
        return $this->belongsTo(Epi::class);
    }
}