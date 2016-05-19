<?php

namespace App\Http\Requests\Admin\Usuarios;

use App\Http\Requests\Request;

class RecuperarSenhaRequest extends Request {

    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            'email' => 'required'
        ];
    }

    public function attributes(){
        return [
            'email' => 'E-MAIL'
        ];
    }

}
