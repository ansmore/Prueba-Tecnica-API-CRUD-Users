<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable {
    
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Retorna todos los usuarios.
     */
    public static function getAllUsers()
    {
        return self::all();
    }

    /**
     * Crea un nuevo usuario con los datos validados.
     */
    public static function createUser(array $data)
    {
        $data['password'] = Hash::make($data['password']);
        return self::create($data);
    }

    /**
     * Actualiza un usuario existente con los datos proporcionados.
     */
    public function updateUser(array $data)
    {
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }
        $this->update($data);
        return $this;
    }

    /**
     * Devuelve los 3 dominios más usados en los emails.
     */
    public static function getTopEmailDomains()
    {
        return self::selectRaw('SUBSTRING_INDEX(email, "@", -1) as domain, COUNT(*) as total')
            ->groupBy('domain')
            ->orderByDesc('total')
            ->limit(3)
            ->pluck('total', 'domain');
    }

    /**
    * Genera y devuelve un token de acceso para el usuario.
    */
    public function generateToken(): string
    {
        return $this->createToken('api-token')->plainTextToken;
    }
}
