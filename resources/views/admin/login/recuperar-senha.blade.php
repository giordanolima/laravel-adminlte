@extends("admin.login.template")

@section("conteudo")
<p class="login-box-msg">Recuperar senha</p>
@include("admin.templates.mensagens")

{!! 
    Form::open([
        "route" => "admin::recuperar-senha-post",
        "method" => "POST"
    ]) 
!!}

    <div class="form-group has-feedback">
        <input type="email" name="email" class="form-control" placeholder="Email" />
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
    </div>
    <div class="row">
        <div class="col-xs-12 text-right">
            <button type="submit" class="btn btn-primary btn-block btn-flat">Entrar</button>
        </div>
    </div>


{!! Form::close() !!}

@stop