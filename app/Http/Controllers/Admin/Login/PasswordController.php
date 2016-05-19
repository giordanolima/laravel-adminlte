<?php

namespace App\Http\Controllers\Admin\Login;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Usuarios\RecuperarSenhaRequest;
use App\Http\Requests\Admin\Usuarios\CadastrarSenhaRequest;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\PasswordBroker;

class PasswordController extends Controller {
    
    use ResetsPasswords;
    
    public function __construct(Guard $auth, PasswordBroker $passwords) {
        $this->auth = $auth;
        $this->passwords = $passwords;
    }

    public function getIndex() {
        $data['titulo'] = 'Recuperar Senha';
        return view('admin.login.recuperar-senha', $data);
    }
    public function postIndex(RecuperarSenhaRequest $request) {
        
        $response = $this->passwords->sendResetLink(['usuario_email' => $request->email], function($message){
            $message->subject('Recuperar Senha - '.config("app.name"));
        });
        
        switch ($response) {
            case PasswordBroker::RESET_LINK_SENT:
                return redirect()->route("admin::login")->with(['ok' => 'Um e-mail foi enviado para sua caixa de entrada com instruções para reiniciar sua senha.']);

            case PasswordBroker::INVALID_USER:
                return redirect()->back()->withErrors(['login' => 'E-mail não encontrado']);
        }
    }
    public function getCadastrarSenha($token = null) {
        if (is_null($token))
            App::abort(404);
        
        $data['titulo'] = 'Cadastrar nova senha';
        $data['token'] = $token;
        return view('admin.login.cadastrar-senha', $data);
    }
    public function postCadastrarSenha(CadastrarSenhaRequest $request){
        
        $credentials = $request->except('_token');
        
        $response = $this->passwords->reset($credentials, function($user, $password) {
            $user->usuario_senha = bcrypt($password);
            $user->save();
        });

        switch ($response) {
            case PasswordBroker::INVALID_PASSWORD:
                return redirect()->back()->withErrors(['senha' => 'Senha inválida.']);
            case PasswordBroker::INVALID_TOKEN:
                return redirect()->back()->withErrors(['Token inválido. Faça uma nova solicitação de renovação de senha.']);
            case PasswordBroker::INVALID_USER:
                return redirect()->back()->withErrors(['login' => 'Login ou email não encontrado!']);

            case PasswordBroker::PASSWORD_RESET:
                return redirect()->route("admin::login")->with(['ok' => 'Sua senha foi cadastrada com sucesso. Faça o login usando suas novas credenciais.']);
        }
    }
    
}