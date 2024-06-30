<?php
namespace App\Http\Controllers;

use App\Models\Funcionario;
use App\Models\Ponto;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class PontoController extends Controller
{
    public function salvar(Request $request)
    {
        // Definindo o fuso horário de Brasília como padrão
        date_default_timezone_set('America/Sao_Paulo');

        $data = $request->validate([
            'codigo' => 'required|string',
        ]);

        // Obter a data e hora atuais no fuso horário de Brasília
        $now = Carbon::now();

        // Log para verificar a data e hora
        \Log::info('Data e Hora em Brasília: ' . $now);

        try {
            $funcionario = Funcionario::where('Codigo', $data['codigo'])->first();
             
            if ($funcionario) {
                $novoPonto = new Ponto();
                $novoPonto->FuncionarioID = $funcionario->id;
                $novoPonto->Data = $now->toDateString();
                $novoPonto->Hora = $now->toTimeString();
                $novoPonto->save();

                return response()->json([
                    "id" => $funcionario->id,
                    "Codigo" => $funcionario->Codigo,
                    "Nome" => $funcionario->Nome,
                    "Data" => $now->toDateString(),
                    "Hora" => $now->toTimeString(),
                    "message" => "Ponto salvo com sucesso!"
                ]);
            } else {
                return response()->json(["message" => "Funcionário não encontrado"], 404);
            }
        } catch (\Exception $ex) {
            return response()->json(["message" => "Erro ao salvar ponto: " . $ex->getMessage()], 500);
        }
    }
}
