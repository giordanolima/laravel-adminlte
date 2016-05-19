<?php

namespace App\Http\Controllers\Admin\Usuarios;

use App\Http\Controllers\Admin\Base\BaseController;
use App\Http\Requests\Admin\Usuarios\DadosPessoaisRequest;
use App\Repositories\Usuarios\UsuariosRepository;

class UsuariosController extends BaseController {
    
    protected $repository;
    protected $titulo = "Contatos";
    protected $route = "admin::usuarios";
    protected $request = DadosPessoaisRequest::class;
    protected $excluirMetodos = ["getVer"];
    protected $views = [
        "lista" => "admin.usuarios.lista",
        "cadastrar" => "admin.usuarios.cadastrar",
    ];

    public function __construct(UsuariosRepository $repository)
    {
        $this->repository = $repository;
        parent::__construct();
    }
    
}