<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ponto extends Model
{
    protected $table = 'Ponto'; // Nome da tabela

    protected $fillable = ['FuncionarioID', 'Data', 'Hora']; // Colunas que podem ser preenchidas em massa

    public function funcionario()
    {
        return $this->belongsTo(Funcionario::class, 'FuncionarioID');
    }
}