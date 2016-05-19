@extends("admin.login.template")

@section("conteudo")
<p class="login-box-msg">Entrar no sistema</p>
@include("admin.templates.mensagens")
{!! 
    Form::open([
        "route" => "admin::login-post",
        "method" => "POST"
    ]) 
!!}
    
    <div class="form-group has-feedback">
        <input type="email" name="email" class="form-control" placeholder="Email" />
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
    </div>
    <div class="form-group has-feedback">
        <input type="password" name="password" class="form-control" placeholder="Password" />
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
    </div>
    <div class="row">
        <div class="col-xs-8">
            <div class="checkbox icheck">
                <label>
                    <input type="checkbox" name="lembrar" value="1" /> Continuar conectado
                </label>
            </div>
        </div>
        <div class="col-xs-4">
            <button type="submit" class="btn btn-primary btn-block btn-flat">Entrar</button>
        </div>
    </div>
{!! Form::close() !!}

<a href="{{ route('admin::recuperar-senha') }}">Esqueceu sua senha?</a><br>
@stop