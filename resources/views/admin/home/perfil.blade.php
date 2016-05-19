@extends("admin.templates.principal")

@section("conteudo")
<section class="content-header">
    <h1>Meu perfil</h1>
    <ol class="breadcrumb">
        <li><a href="{{ route("admin::home") }}"><i class="icon ion-ios-home"></i> Dashboard</a></li>
        <li class="active">Meu perfil</li>
    </ol>
</section>
<section class="content">
    @include("admin.templates.mensagens")

    <div class="row">
        <div class="col-lg-6 col-lg-offset-3 col-md-8 col-md-offset-2">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Meus dados</h3>
                </div>
                {!! 
                    Form::model($usuario,[
                        "url" => route("admin::perfil::dados-pessoais"),
                        "method" => "POST"
                    ]) 
                !!}
                    <div class="box-body">
                        <div class="form-group">
                            <label for="usuario_nome">Nome</label>
                            {!! 
                                Form::text('usuario_nome', null, [
                                    "id" => "usuario_nome",
                                    "class" => "form-control",
                                    "placeholder" => "Seu nome"
                                ]); 
                            !!}
                        </div>
                        <div class="form-group">
                            <label for="usuario_email">E-mail</label>
                            {!! 
                                Form::email('usuario_email', null, [
                                    "id" => "usuario_email",
                                    "class" => "form-control",
                                    "placeholder" => "Seu email"
                                ]); 
                            !!}
                        </div>
                    </div>

                    <div class="box-footer text-right">
                        <button type="submit" class="btn btn-primary">Salvar</button>
                    </div>
                {!! Form::close() !!}
            </div>            
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6 col-lg-offset-3 col-md-8 col-md-offset-2">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Alterar senha</h3>
                </div>
                {!! 
                    Form::open([
                        "url" => route("admin::perfil::alterar-senha"),
                        "method" => "POST"
                    ]) 
                !!}
                    <div class="box-body">
                        <div class="form-group">
                            <label for="senha_atual">Senha atual</label>
                            {!! 
                                Form::password('senha_atual', [
                                    "id" => "senha_atual",
                                    "class" => "form-control",
                                    "placeholder" => "Senha atual"
                                ]); 
                            !!}
                        </div>
                        <div class="form-group">
                            <label for="nova_senha">Nova senha</label>
                            {!! 
                                Form::password('nova_senha', [
                                    "id" => "nova_senha",
                                    "class" => "form-control",
                                    "placeholder" => "Nova senha"
                                ]); 
                            !!}
                        </div>
                        <div class="form-group">
                            <label for="repetir_senha">Repetir senha</label>
                            {!! 
                                Form::password('repetir_senha', [
                                    "id" => "repetir_senha",
                                    "class" => "form-control",
                                    "placeholder" => "Repetir senha"
                                ]); 
                            !!}
                        </div>
                    </div>

                    <div class="box-footer text-right">
                        <button type="submit" class="btn btn-primary">Salvar</button>
                    </div>
                {!! Form::close() !!}
            </div>            
        </div>
    </div>

</section>

@stop