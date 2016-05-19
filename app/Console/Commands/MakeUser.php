<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Usuarios\Usuarios;
use Illuminate\Support\Facades\Hash;

class MakeUser extends Command
{
    protected $signature = 'make:user';
    protected $description = 'Cria um novo usuario.';

    public function __construct()
    {
        parent::__construct();
    }
    
    public function handle()
    {
        $nome = $this->ask('Digite o nome do usuário: ');
        $email = $this->ask('Digite o e-mail para acesso: ');
        $senha = $this->secret('Digite a senha de acesso: ');
        Usuarios::create([
            "usuario_nome" => $nome,
            "usuario_email" => $email,
            "usuario_senha" => Hash::make($senha)
        ]);
        $this->info('Usuario criado! Obrigado por escolher a WP8 Agencia Digital.');
        $this->call("inspire");
    }
}
