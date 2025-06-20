<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{

    private const USER_NOT_FOUND = 'Usuario no encontrado';

    public function index(): JsonResponse
    {
        return response()->json(User::getAllUsers(), 200);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
        ]);

        $user = User::createUser($validated);
        return response()->json($user, 201);
    }

    public function show(int $id): JsonResponse
    {
        $user = User::find($id);
        return $user
            ? response()->json($user)
            : response()->json(['error' => self::USER_NOT_FOUND], 404);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['error' => self::USER_NOT_FOUND], 404);
        }

        $validated = $request->validate([
            'name'     => 'sometimes|required|string|max:255',
            'email'    => 'sometimes|required|email|unique:users,email,' . $id,
            'password' => 'sometimes|required|string|min:6',
        ]);

        return response()->json($user->updateUser($validated));
    }

    public function destroy(int $id): JsonResponse
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['error' => self::USER_NOT_FOUND], 404);
        }

        $user->delete();
        return response()->json(['message' => 'Usuario eliminado correctamente']);
    }

    public function topDomains(): JsonResponse
    {
        return response()->json(User::getTopEmailDomains());
    }
}
