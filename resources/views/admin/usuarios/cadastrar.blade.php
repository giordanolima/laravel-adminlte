@extends("admin.templates.principal")

@section("conteudo")
<section class="content-header">
    <h1>Usuários</h1>
    <ol class="breadcrumb">
        <li><a href="{{ route("admin::home") }}"><i class="icon ion-ios-home"></i> Home</a></li>
        <li><a href="{{ route("admin::usuarios") }}">Usuários</a></li>
        <li class="active">Cadastrar Cliente</li>
    </ol>
</section>
<section class="content">
    
    <div class="row">
        <div class="col-lg-6 col-lg-offset-3 col-md-8 col-md-offset-2">            
            @include("admin.templates.mensagens")
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Cadastrar dados</h3>
                </div>
                {!! 
                    Form::model($obj,[
                        "route" => "admin::usuarios::cadastrar",
                        "method" => "POST"
                    ]) 
                !!}
                    {!! Form::hidden('usuario_id') !!}
                    <div class="box-body">
                        <div class="form-group">
                            <label for="usuario_nome">Nome</label>
                            {!! 
                                Form::text('usuario_nome', null, [
                                    "id" => "usuario_nome",
                                    "class" => "form-control",
                                    "placeholder" => "Nome"
                                ]); 
                            !!}
                        </div>
                        <div class="form-group">
                            <label for="usuario_email">E-mail</label>
                            {!! 
                                Form::email('usuario_email', null, [
                                    "id" => "usuario_email",
                                    "class" => "form-control",
                                    "placeholder" => "E-mail"
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