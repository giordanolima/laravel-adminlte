<?php

namespace App\Http\Requests\Admin\Usuarios;

use App\Http\Requests\Request;

class CadastrarSenhaRequest extends Request {

    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            'usuario_email' => 'required',
            'password' => 'required|min:6',
            'password_confirmation' => 'required|same:password'
        ];
    }

    public function attributes(){
        return [
            'usuario_email' => 'E-MAIL',
            'password' => 'SENHA',
            'password_confirmation' => 'REPETIR SENHA'
        ];
    }

}
