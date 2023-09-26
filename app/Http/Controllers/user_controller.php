<?php

namespace App\Http\Controllers;

use App\Http\Requests\auth_request;
use App\Http\Requests\user_controller_request;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Auth;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;

class user_controller extends Controller
{
    protected function test()
    {
        return 'test';
    }

    /**
     * Metodo que recibe los datos de una peticion post para crear un usuario
     * Valida los datos y si todo es correcto, crea el usuario y lo agrega a
     * la base de datos.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(user_controller_request $request): JsonResponse
    {
        Log::channel('user')->info('Entra a store');
        // Valida los datos
        $validated = $request->validated();
        Log::channel('user')->info('Datos a crear usuario: ', $request->all());
        // crear el usuario
        $result = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
        if (is_null($result)) {
            Log::channel('user')->error('Error al crear el usuario');
            return response()->json(['message' => 'Error al crear el usuario'], 400);
        }
        Log::channel('user')->info('Usuario creado');
        $role = Role::findByName($request->role, 'web');
        $role->users()->attach($result);
        Log::channel('user')->info('Usuario asignado a role: ' . $role);
        return response()->json(['message' => 'Usuario creado correctamente'], 200);
    }

    /**
     * Obtiene todos los usuarios de la base de datos y los devuelve
     * Preguntar como se usa el chunk o la paginacion
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        Log::channel('user')->info('Entra a index');
        $users = User::paginate(10);
        if (is_null($users)) {
            Log::channel('user')->warning('No hay usuarios');
            return response()->json(['message' => 'No hay usuarios'], 404);
        }
        Log::channel('user')->info('Usuarios encontrados');
        return response()->json($users, 200);
    }

    /**
     * Busca un usuario en la base de datos mediante su id y lo regresa
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, int $id): JsonResponse
    {
        Log::channel('user')->info('Entra a show buscando el usuario con id: ' . $id);
        // Regresamos los datos del usuario
        $user = User::find($id);
        if (is_null($user)) {
            Log::channel('user')->warning('Usuario no encontrado');
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }
        Log::channel('user')->info('Usuario encontrado');
        return response()->json(["user" => $user], 200);
    }

    /**
     * Busca un usuario en la base de datos mediante su id y actualiza los datos
     * No estoy seguro si tambien se puede dar la opcion de actualizar su
     * contrasena, pero por si las dudas, yo lo permito.
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(user_controller_request $request, int $id): JsonResponse
    {
        Log::channel('user')->info('Entra a update con el id: ' . $id);
        Log::channel('user')->info('Datos a actualizar: ', $request->all());
        // Busca el usuario
        $user = User::find($id);
        if (is_null($user)) {
            Log::channel('user')->warning('Usuario no encontrado');
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }
        Log::channel('user')->info('Usuario encontrado');
        // Validamos que la contrasena sea correcta
        if (!Hash::check($request->password, $user->password)) {
            Log::channel('user')->warning('Contrasena incorrecta');
            return response()->json(['message' => 'Contrasena incorrecta'], 400);
        }
        Log::channel('user')->info('Contrasena correcta');
        // Actualiza los datos del usuario
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->new_password);
        $role = Role::findByName($request->role, 'web');
        $user->syncRoles($role);
        $user->save();
        Log::channel('user')->info('Usuario actualizado');
        return response()->json(['message' => 'Usuario actualizado correctamente'], 200);
    }

    /**
     * Elimina de forma suave el usuario que se especifica mediante su id.
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        Log::channel('user')->info('Entra a destroy con el id: ' . $id);
        //validar si el usuario existe
        $user = User::find($id);
        if (is_null($user)) {
            Log::channel('user')->warning('Usuario no encontrado');
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }
        Log::channel('user')->info('Usuario encontrado');
        // borrar suavemente el usuario
        $user->delete();
        Log::channel('user')->info('Usuario eliminado de forma suave');
        return response()->json(['message' => 'Usuario eliminado correctamente'], 200);
    }

    /**
     * Inicia secion en el sistema, verifica que los datos sean correctos
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(auth_request $request): JsonResponse
    {
        Log::channel('user')->info('Entra a login');
        $accessToken = auth()->user()->createToken('authToken')->accessToken;
        Log::channel('user')->info('Token creado');
        return response()->json([
            'message' => 'Usuario logueado correctamente',
            'user' => Auth::user(),
            'access_token' => $accessToken
        ], 200);

    }

    /**
     * cierra la sesion del usuario, elimina el token para que no tenga acceso al sistema
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(): JsonResponse
    {
        Log::channel('user')->info('Entra a logout');
        Auth::user()->tokens()->delete();
        Log::channel('user')->info('Sesion cerrada');
        return response()->json(['message' => 'Sesion cerrada correctamente'], 200);
    }
}