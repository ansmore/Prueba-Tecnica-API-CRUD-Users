<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    /**
     * Registra un nuevo usuario, genera y devuelve su token de acceso.
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        // Crea el usuario con la contraseña cifrada
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Genera el token de acceso personal
        $token = $user->generateToken();

        return response()->json(['user' => $user, 'token' => $token], 201);
    }

    /**
     * Verifica las credenciales y devuelve el token si son válidas.
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $user = User::where('email', $request->email)->first();

         // Verifica si el usuario existe y si la contraseña es correcta
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Credenciales inválidas'], 401);
        }

        // Genera un nuevo token de acceso
        $token = $user->generateToken();

        return response()->json(['user' => $user, 'token' => $token]);
    }

    /**
     * Cierra la sesión eliminando el token de acceso actual.
     */
    public function logout(): JsonResponse
    {
        auth()->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Sesión cerrada']);
    }
}
