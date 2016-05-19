{!! 
    Form::open([
        "url" => request()->url(),
        "method" => "GET"
    ]) 
!!}

<div class="input-group input-group-sm">
    {!! 
        Form::text('busca', request("busca"), [
            "class" => "form-control",
            "placeholder" => "Buscar"
        ]) 
    !!}
    <div class="input-group-btn">
        <button class="btn btn-default" type="submit"><i class="icon ion-search"></i></button>
    </div>
</div>

{!! Form::close() !!}