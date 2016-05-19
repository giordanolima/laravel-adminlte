<?php

namespace App\Http\Requests\Admin\Usuarios;

use App\Http\Requests\Base\BaseRequest;
use App\Repositories\Usuarios\UsuariosRepository;

class SenhaRequest extends BaseRequest
{
    protected $repo;
    protected $fields = [
        'senha_atual',
        'nova_senha',
        'repetir_senha',
    ];

    public function __construct(UsuariosRepository $repo)
    {
        parent::__construct();
        $this->repo = $repo;
    }
    public function authorize()
    {
        return auth()->check();
    }
    public function rules()
    {
        $regras = parent::rules();
        $regras['senha_atual'] = str_replace('@pass', auth()->user()->usuario_senha, $regras['senha_atual']);

        return $regras;
    }
}
