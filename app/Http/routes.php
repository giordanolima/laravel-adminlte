<?php

Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'as' => "admin::"], function(){
    Route::controller('login', 'Login\LoginController', [
        'getIndex' => 'login',
        'postIndex' => 'login-post',
        'getLogout' => 'logout',
    ]);
    Route::controller('recuperar-senha', 'Login\PasswordController', [
        'getIndex' => 'recuperar-senha',
        'postIndex' => 'recuperar-senha-post',
        'getCadastrarSenha' => 'cadastrar-senha',
        'postCadastrarSenha' => 'cadastrar-senha-post',
    ]);
    Route::group(['middleware' => 'auth'], function(){
        Route::controller('usuarios', "Usuarios\UsuariosController", [
            "getIndex" => "usuarios",
            "getCadastrar" => "usuarios::cadastrar",
            "getExcluir" => "usuarios::excluir",
        ]);
        Route::controller('/', "Home\HomeController", [
            "getIndex" => "home",
            "getPerfil" => "perfil",
            "postDadosCadastrais" => "perfil::dados-pessoais",
            "postAlterarSenha" => "perfil::alterar-senha",
        ]);
    });
});

Route::get("/",function(){
    return "Home!";
});