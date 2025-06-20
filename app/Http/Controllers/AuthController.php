<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $req)
    {
        $req->validate([
            'name'=>'required',
            'email'=>'required|email|unique:users',
            'password'=>'required|confirmed|min:6'
        ]);
        $u = User::create([
            'name'=>$req->name,
            'email'=>$req->email,
            'password'=>Hash::make($req->password)
        ]);
        $token = $u->createToken('api-token')->plainTextToken;
        return response()->json(['user'=>$u,'token'=>$token],201);
    }

    public function login(Request $req)
    {
        $req->validate(['email'=>'required|email','password'=>'required']);
        $u = User::where('email',$req->email)->first();
        if (!$u || !Hash::check($req->password,$u->password)) {
            return response()->json(['message'=>'Credenciales inválidas'],401);
        }
        $token = $u->createToken('api-token')->plainTextToken;
        return response()->json(['user'=>$u,'token'=>$token],200);
    }

    public function logout(Request $req)
    {
        $req->user()->currentAccessToken()->delete();
        return response()->json(['message'=>'Sesión cerrada'],200);
    }
}

