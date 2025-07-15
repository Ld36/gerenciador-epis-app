<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Epi extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome', 'descricao', 'ca', 'validade_ca', 'quantidade_estoque'
    ];

    // Relacionamento 1:N com EntregaEpi (um EPI tem muitas entregas)
    public function entregas()
    {
        return $this->hasMany(EntregaEpi::class);
    }
}