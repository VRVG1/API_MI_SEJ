<?php

use App\Http\Controllers\AdministrativeAreaParticipantsController;
use App\Http\Controllers\EventExcelController;
use App\Http\Controllers\EventMailController;
use App\Http\Controllers\EventsController;
use App\Http\Controllers\SedeController;
use App\Http\Controllers\WorkplaceCenterParticipantsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\user_controller;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Grupo de rutas usuarios
Route::prefix('user')->group(function () {
    // Ruta para crear un usuario
    Route::post('/', [user_controller::class, 'store']);
    // Ruta para obtener todos los usuarios
    Route::middleware('auth:api')->get('/', [user_controller::class, 'index']);
    // Ruta para obtener un usuario
    Route::middleware('auth:api')->get('/{id}', [user_controller::class, 'show']);
    // Ruta para actualizar un usuario
    Route::middleware('auth:api')->put('/{id}', [user_controller::class, 'update']);
    // Ruta para eliminar un usuario
    Route::middleware('auth:api')->delete('/{id}', [user_controller::class, 'destroy']);

});

// Grupo de rutas eventos, todas tienes que pasar por el middleware auth:api
Route::prefix('event')->group(function () {
    // Ruta para crear un evento
    Route::middleware('auth:api')->post('/', [EventsController::class, 'store']);
    // Ruta para obtener todos los eventos
    Route::middleware('auth:api')->get('/', [EventsController::class, 'index']);
    // Ruta para obtener un evento
    Route::middleware('auth:api')->get('/{id}', [EventsController::class, 'show']);
    // Ruta para actualizar un evento
    Route::middleware('auth:api')->post('/{id}', [EventsController::class, 'update']);
    // Ruta para eliminar un evento
    Route::middleware('auth:api')->delete('/{id}', [EventsController::class, 'destroy']);
});

// Ruta para enviar un correo 
Route::middleware('auth:api')->post('/send_email', [EventMailController::class, 'sendEventToEmail']);
// Ruta para exportar a excel un evento
Route::middleware('auth:api')->get('/export_events', [EventExcelController::class, 'index']);

// Grupo de rutas de administrative_area_participants
// Solo pongo el post ya que no se requieren las demas, de momento
Route::middleware('auth:api')->post('/administrative_area_participants', [AdministrativeAreaParticipantsController::class, 'create']);

// Grupo de rutas de workplace_center_participants
// Solo pongo el post ya que no se requieren las demas, de momento
Route::middleware('auth:api')->post('/workplace_center_participants', [WorkplaceCenterParticipantsController::class, 'create']);

// Grupo de rutas de sedes
// Solo pongo el post ya que no se requieren las demas, de momento
Route::middleware('auth:api')->post('/sedes', [SedeController::class, 'create']);

// Ruta para iniciar sesión
Route::post('/login', [user_controller::class, 'login']);
// Ruta para cerrar sesión
Route::middleware('auth:api')->post('/logout', [user_controller::class, 'logout']);