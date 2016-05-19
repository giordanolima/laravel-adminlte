<?php

namespace App\Http\Controllers\Admin\Home;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Usuarios\SenhaRequest;
use App\Http\Requests\Admin\Usuarios\DadosPessoaisRequest;
use App\Repositories\Usuarios\UsuariosRepository;

class HomeController extends Controller {
    
    protected $repository;
    public function __construct(UsuariosRepository $repo) {
        $this->repository = $repo;
    }
    
    public function getIndex() {
        return view('admin.home.home', ['titulo' => 'Home']);
    }
    public function getPerfil() {
        $data['titulo'] = 'Meus Perfil';
        $data['usuario'] = auth()->user();
        return view('admin.home.perfil', $data);
    }
    public function postDadosCadastrais(DadosPessoaisRequest $request) {
        $this->repository->update($request->except(["_token"]), auth()->user()->usuario_id);
        return redirect()->back()->with(['ok' => 'Dados atualizados com sucesso.']);
    }
    public function postAlterarSenha(SenhaRequest $request) {
        $this->repository->update(['usuario_senha' => bcrypt($request->nova_senha)], auth()->user()->usuario_id);
        return redirect()->back()->with(['ok' => 'Senha atualizadas com sucesso.']);
    }
    
}
