<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PontoController;

Route::post('/Salvar', [PontoController::class, 'salvar']);