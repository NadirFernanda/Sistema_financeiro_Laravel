<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Notifications\Notifiable;
use App\Notifications\UsuarioResetPasswordNotification;

class Usuario extends Authenticatable implements CanResetPasswordContract
{
    use HasFactory, Notifiable, CanResetPassword;

    protected $fillable = [
        'nome', 'email', 'role', 'senha'
    ];
    public function getAuthPassword()
    {
        return $this->senha;
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new UsuarioResetPasswordNotification($token));
    }
}
