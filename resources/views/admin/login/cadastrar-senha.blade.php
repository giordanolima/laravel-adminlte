@extends("admin.login.template")

@section("conteudo")
<p class="login-box-msg">Recuperar senha</p>
@include("admin.templates.mensagens")

{!! 
    Form::open([
        "route" => "admin::cadastrar-senha-post",
        "method" => "POST"
    ]) 
!!}
    {!! Form::hidden('token', $token); !!}
    <div class="form-group has-feedback">
        <input type="email" name="usuario_email" class="form-control" placeholder="Email" />
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
    </div>
    <div class="form-group has-feedback">
        <input type="password" name="password" class="form-control" placeholder="Nova senha" />
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
    </div>
    <div class="form-group has-feedback">
        <input type="password" name="password_confirmation" class="form-control" placeholder="Repetir senha" />
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
    </div>
    <div class="row">
        <div class="col-xs-12 text-right">
            <button type="submit" class="btn btn-primary btn-block btn-flat">Entrar</button>
        </div>
    </div>


{!! Form::close() !!}

@stop