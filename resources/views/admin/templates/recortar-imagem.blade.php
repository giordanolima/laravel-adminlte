@extends("admin.templates.principal")

@section("conteudo")
<section class="content-header">
    <h1>{{ $titulo or 'Título' }}</h1>
    <ol class="breadcrumb">
        <li><a href="{{ route("admin::home") }}"><i class="icon ion-ios-home"></i> Home</a></li>
        @foreach($breadcumb as $bc)
            @if(array_key_exists("url", $bc))
            <li><a href='{{ $bc["url"] }}'>{{ $bc["titulo"] }}</a></li>
            @else
            <li class="active">{{ $bc["titulo"] }}</li>
            @endif
        @endforeach
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-lg-6 col-lg-offset-3 col-md-8 col-md-offset-2">
            @include('admin.templates.mensagens')
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Recortar Imagem</h3>
                </div>
                {!! Form::open(['url' => $route, "class" => "form-horizontal"]) !!}
                <input type="hidden" name="redirect"        value="{{ $redirect }}" />
                <input type="hidden" name="id"              value="{{ $imagem->imagem_id }}" />
                <input type="hidden" name="x"               value=""    id="cropX1" />
                <input type="hidden" name="y"               value=""    id="cropY1" />
                <input type="hidden" name="w"               value=""    id="cropW" />
                <input type="hidden" name="h"               value=""    id="cropH" />
                <div class="box-body">
                    <div class="crop-parent">
                        {!! Html::image(
                            $path . '/' . $imagem->pai->imagem_nome,
                            'Imagem Principal',
                            [
                                "class"                 => "JCrop",
                                "data-largura"          => $imagem->imagem_largura,
                                "data-altura"           => $imagem->imagem_altura,
                                "data-true-largura"     => $imagem->pai->imagem_largura,
                                "data-true-altura"      => $imagem->pai->imagem_altura
                            ]
                        ) !!}
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