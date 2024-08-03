<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Ponto2Controller;

Route::post('/Salvar', [Ponto2Controller::class, 'salvarPonto']);