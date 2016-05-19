<?php

namespace App\Http\Requests\Admin\Usuarios;

use App\Http\Requests\Base\BaseRequest;
use App\Http\Requests\Base\AdminRequest;
use App\Repositories\Usuarios\UsuariosRepository;

class DadosPessoaisRequest extends BaseRequest implements AdminRequest
{
    protected $repo;
    protected $fields = [
        'usuario_nome',
        'usuario_email',
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
}
