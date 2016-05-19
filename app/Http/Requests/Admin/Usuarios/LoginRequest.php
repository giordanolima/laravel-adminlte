<?php

namespace App\Http\Requests\Admin\Usuarios;

use App\Http\Requests\Request;

class LoginRequest extends Request
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        return [
            'email' => 'required',
            'password' => 'required',
            'lembrar' => 'boolean',
        ];
    }
    public function attributes()
    {
        return [
            'email' => 'E-MAIL',
            'password' => 'SENHA',
        ];
    }
}
