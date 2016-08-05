@extends("admin.templates.principal")

@section("conteudo")
<section class="content-header">
    <h1>Usuários</h1>
    <ol class="breadcrumb">
        <li><a href="{{ route("admin::home") }}"><i class="icon ion-ios-home"></i> Home</a></li>
        <li class="active">Usuários</li>
    </ol>
</section>
<section class="content">
    @include("admin.templates.mensagens")
    <div class="box">
        <div class="box-header">
            <div class="pull-left">
                <a class="btn btn-primary" href="{{ route("admin::usuarios::cadastrar") }}">
                    <i class="icon ion-plus"></i>  Cadastrar Usuário
                </a>
            </div>
            <div class="pull-right">
                @include("admin.templates.lista-controls")
            </div>
            
        </div>
        <div class="box-body table-responsive no-padding">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th class="text-center">E-mail</th>
                        <th class="text-center col-lg-2">Açoes</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($lista as $usuario)
                    <tr>
                        <td>{{ $usuario->usuario_nome }}</td>
                        <td class="text-center">{{ $usuario->usuario_email }}</td>
                        <td class="text-center">
                            <a class="btn btn-sm btn-social btn-primary" href="{{ route("admin::usuarios::cadastrar",["id" => $usuario->usuario_id]) }}">
                                <i class="icon ion-edit"></i> Editar
                            </a>
                            <a class="btn btn-sm btn-social btn-danger confirma-exclusao" href="{{ route("admin::usuarios::excluir",["id" => $usuario->usuario_id]) }}">
                                <i class="icon ion-trash-b"></i> Excluir
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center"><strong><em>Nenhum usuário cadastrado.</em></strong></td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($lista->hasPages())
        <div class="box-footer clearfix">
            <div class="pull-right">
                {!! $lista->render() !!}
            </div>
        </div>
        @endif
    </div>
</section>
@stop