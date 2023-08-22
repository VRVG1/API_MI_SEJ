<?php
// Importando la clase Route
use App\Controllers\Home_Controller;
use App\Controllers\User_Controller;
use App\Controllers\Event_Controller;
use Lib\Route;

Route::get('/', [Home_Controller::class, 'index']);

Route::get('about', function () {
    return "Pagina About";
});

Route::get('contact', function () {
    return "Pagina Contact";
});


Route::post('login', [User_Controller::class, 'login']);
// Ruta para almacenar eventos
Route::post('event', [Event_Controller::class, 'post_event']);
// Ruta para obtener eventos
Route::get('event', [Event_Controller::class, 'get_events']);
// Ruta para eliminar un evento
Route::delete('event/:id', [Event_Controller::class, 'delete_event']);
// Ruta para obtener solo un evento
Route::get('event/:id', [Event_Controller::class, 'get_event']);
// Ruta para actualizar un evento
Route::post('event/:id', [Event_Controller::class, 'update_event']);

// Usuarios
// Ruta para crear un usuarios
Route::post('user', [User_Controller::class, 'post_user']);
// Ruta para obtener usuarios
Route::get('user', [User_Controller::class, 'get_users']);
// Ruta para eliminar un usuario
Route::delete('user/:id', [User_Controller::class, 'delete_user']);
// Ruta para obtener solo un usuario
Route::get('user/:id', [User_Controller::class, 'get_user']);
// Ruta para actualizar un usuario
Route::put('user/:id', [User_Controller::class, 'update_user']);

Route::dispatch();