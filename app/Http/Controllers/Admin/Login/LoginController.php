<?php

namespace App\Http\Controllers\Admin\Login;

use App\Http\Controllers\Controller,
    App\Http\Requests\Admin\Usuarios\LoginRequest,
    App\Repositories\Usuarios\UsuariosRepository;

class LoginController extends Controller {

    protected $repository;
    
    public function __construct(UsuariosRepository $repository){
        $this->repository = $repository;
    }
    
    public function getIndex() {
        return view('admin.login.login', ['titulo' => 'Login']);
    }

    public function postIndex(LoginRequest $request) {
        $usuario = [
            'usuario_email' => $request->email,
            'password' => $request->password
        ];

        if (auth()->attempt($usuario, (bool)$request->lembrar)) {
            return redirect()->intended(route("admin::home"));
        } else {
            return redirect()
                ->back()
                ->withErrors('Usuário ou senha inválidos.');
        }
    }

    public function getLogout() {
        auth()->logout();
        return redirect()->route("admin::login");
    }
    
}
