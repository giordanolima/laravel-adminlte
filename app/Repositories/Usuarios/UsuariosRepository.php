<?php

namespace App\Repositories\Usuarios;

use App\Repositories\Base\BaseRepository;

class UsuariosRepository extends BaseRepository
{
    protected $orderBy = [
        "field" => "usuario_nome",
        "order" => "ASC"
    ];
    protected $regras = [
        'usuario_nome' => 'required|max:255',
        'usuario_email' => 'required|email|max:255',
        'usuario_senha' => 'required|min:6',
        'repetir_senha' => 'required|required',
        'senha_atual' => 'required|password:@pass',
        'nova_senha' => 'required|same:repetir_senha|min:6',
    ];
    protected $nomes = [
        'usuario_nome' => 'NOME',
        'usuario_email' => 'E-MAIL',
        'usuario_senha' => 'SENHA',
        'repetir_senha' => 'REPETIR SENHA',
        'senha_atual' => 'SENHA ATUAL',
        'nova_senha' => 'NOVA SENHA',
    ];

    public function model()
    {
        return \App\Models\Usuarios\Usuarios::class;
    }
}
