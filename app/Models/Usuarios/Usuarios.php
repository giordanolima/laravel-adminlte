<?php

namespace App\Models\Usuarios;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class Usuarios extends Model implements AuthenticatableContract, CanResetPasswordContract {
    
    use Authenticatable, CanResetPassword;
    protected $table = 'tb_usuarios';
    protected $primaryKey = 'usuario_id';
    protected $fillable = ['usuario_nome', 'usuario_email', 'usuario_senha'];
    protected $hidden = ['usuario_senha', 'remember_token'];
    public $timestamps = false;
    
    public static function errorData($code = 404)
    {
        $errorData = [
            404 => [
                'code' => 404,
                'titulo' => 'Usuário não encontrado',
                'texto' => 'O Usuário solicitado foi não encontrado ou não está mais disponível',
                'link_route' => route('admin::usuarios'),
                'link_texto' => 'Listar usuários',
            ],
        ];

        return $errorData[$code];
    }
    // Scope para ser usado no repositorio
    public static function busca($busca)
    {
        return function ($query) use ($busca) {
            if ($busca) {
                return $query->where(function ($q) use ($busca) {
                    return $q
                            ->where('usuario_nome', 'like', "%$busca%")
                            ->orWhere('usuario_email', 'like', "%$busca%");
                });
            } else {
                return $query;
            }
        };
    }
    
    // ---------------------------------
    // ------------- AUTH --------------
    // ---------------------------------
    public function getAuthIdentifier()
    {
        return $this->usuario_id;
    }
    public function getAuthPassword()
    {
        return $this->usuario_senha;
    }
    public function getRememberToken()
    {
        return $this->remember_token;
    }
    public function getRememberTokenName()
    {
        return 'remember_token';
    }
    public function getEmailForPasswordReset()
    {
        return $this->usuario_email;
    }
}
