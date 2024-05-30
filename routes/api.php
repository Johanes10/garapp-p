<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

// Definir las rutas del API para el controlador de usuarios
Route::apiResource('user', UserController::class);