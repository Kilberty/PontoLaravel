<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Funcionario extends Model
{
    protected $table = 'Funcionarios'; // Nome da tabela

    protected $fillable = ['Codigo', 'Nome']; // Colunas que podem ser preenchidas em massa

    public function pontos()
    {
        return $this->hasMany(Ponto::class, 'FuncionarioID');
    }
}