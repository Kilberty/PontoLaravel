<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ponto2 extends Model
{
    protected $table = 'RegistroPonto'; // Nome da tabela

    protected $fillable = ['FuncionarioID', 'Data', 'HoraInicio','HoraAlmoco','HoraRetorno','HoraFim']; // Colunas que podem ser preenchidas em massa

    public function funcionario()
    {
        return $this->belongsTo(Funcionario::class, 'FuncionarioID');
    }
    
 
}
