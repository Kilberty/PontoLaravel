<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Funcionario;
use App\Models\Ponto2;
use Carbon\Carbon;

class Ponto2Controller extends Controller
{
    public function salvarPonto(Request $request)
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
                // Verificar se já existe um ponto para o funcionário na data atual
                $pontoExistente = Ponto2::where('FuncionarioID', $funcionario->id)
                    ->where('Data', $now->toDateString())
                    ->first();

                if ($pontoExistente) {
                    // Atualizar a próxima coluna de ponto não preenchida
                    if (is_null($pontoExistente->HoraInicio)) {
                        $pontoExistente->HoraInicio = $now->toTimeString();
                    } elseif (is_null($pontoExistente->HoraAlmoco)) {
                        $pontoExistente->HoraAlmoco = $now->toTimeString();
                    } elseif (is_null($pontoExistente->HoraRetorno)) {
                        $pontoExistente->HoraRetorno = $now->toTimeString();
                    } elseif (is_null($pontoExistente->HoraFim)) {
                        $pontoExistente->HoraFim = $now->toTimeString();
                    } else {
                        return response()->json(["message" => "Todos os pontos do dia já foram registrados"], 400);
                    }
                    $pontoExistente->save();

                    return response()->json([
                        "id" => $funcionario->id,
                        "Codigo" => $funcionario->Codigo,
                        "Nome" => $funcionario->Nome,
                        "Data" => $now->toDateString(),
                        "Hora" => $now->toTimeString(),
                        "message" => "Ponto atualizado com sucesso!"
                    ]);
                } else {
                    // Criar um novo registro de ponto
                    $CriarPonto = new Ponto2();
                    $CriarPonto->FuncionarioID = $funcionario->id;
                    $CriarPonto->Data = $now->toDateString();
                    $CriarPonto->HoraInicio = $now->toTimeString();
                    $CriarPonto->save();

                    return response()->json([
                        "id" => $funcionario->id,
                        "Codigo" => $funcionario->Codigo,
                        "Nome" => $funcionario->Nome,
                        "Data" => $now->toDateString(),
                        "Hora" => $now->toTimeString(),
                        "message" => "Ponto salvo com sucesso!"
                    ]);
                }
            } else {
                return response()->json(["message" => "Funcionário não encontrado"], 404);
            }
        } catch (\Exception $ex) {
            return response()->json(["message" => "Erro ao salvar ponto: " . $ex->getMessage()], 500);
        }
    }
}
