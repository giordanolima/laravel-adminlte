@extends("admin.templates.principal")

@section("conteudo")
<section class="content-header">
    <h1>{{ $titulo or 'Página não encontrada' }}</h1>
    <ol class="breadcrumb">
        <li><a href="{{ route("admin::home") }}"><i class="icon ion-ios-home"></i> Home</a></li>
    </ol>
</section>
<section class="content">
    
    <div class="error-page clearfix">
        <h2 class="headline text-yellow"> {{ $code or '404' }}</h2>
        <div class="error-content">
            <h3><i class="fa fa-warning text-yellow"></i> {{ $titulo or 'Página não encontrada' }}.</h3>
            <p>{{ $texto or 'A página solicitado não foi encontrada.' }}</p>
            <p>
                <a class="btn btn-primary btn-flat" href="{{ $link_route or route("admin::home") }}">{{ $link_texto or 'Ir para Home' }}</a>
            </p>
        </div>
    </div>
    
    @if(app()->environment() != 'production' && isset($erro))
    <div class="well well-lg">
        <h1>{{ $erro->getMessage() }}</h1>
        <p>in {{ $erro->getFile()." - Line: ".$erro->getLine() }}</p>
    </div>
    @endif
    
</section>

@stop