<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Colaborador extends Model
{
    use HasFactory;
    
    protected $table = 'colaboradores'; // Informa ao Laravel que a tabela é 'colaboradores' no plural

    protected $fillable = [
        'nome', 'cpf', 'matricula', 'data_nascimento', 'telefone', 'email', 'cargo_id', 'departamento_id'
    ];

    // Relacionamento 1:N com Cargo (um colaborador pertence a um cargo)
    public function cargo()
    {
        return $this->belongsTo(Cargo::class);
    }

    // Relacionamento 1:N com Departamento (um colaborador pertence a um departamento)
    public function departamento()
    {
        return $this->belongsTo(Departamento::class);
    }

    // Relacionamento 1:N com EntregaEpi (um colaborador tem muitas entregas de EPI)
    public function entregas()
    {
        return $this->hasMany(EntregaEpi::class);
    }
}