@if(is_array($imagens))
    <div>
        <table>
            <tbody class="sortable">
                @forelse($imagens as $imagem)
                <tr class="table-row" role="row" data-id="{{ $imagem->imagem_id }}">
                    <td class="col-xs-3">
                        <img src="{{ $imagem->url() }}" />
                    </td>
                    <td class="text-right">
                        @if(isset($route_ordenar))
                        <button class="btn btn-primary handle"><i class="fa fa-sort"></i> Reordenar</button>
                        @endif
                        <button type="button" class="btn btn-primary ver-thumbs" data-url="{{ route($route_thumbs, $imagem->imagem_id) }}">Ver Thumbnails</button>
                        <a type="button" href="{{ route($route_excluir, $imagem->imagem_id) }}" class="btn btn-danger confirma-exclusao">Excluir Imagem</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td class="text-center">
                        <strong><em>Nenhuma imagem cadastrada</em></strong>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@else
    <table class="table">
        <tr>
            @if($imagens)
            <td class="col-xs-2">
                <img src="{{ $imagens->url() }}" class="img-responsive" />
            </td>
            <td class="col-xs-10 text-right">
                <button type="button" class="btn btn-primary ver-thumbs" data-url="{{ $route_thumbs or '#' }}">Ver Thumbnails</button>
                <a type="button" href="{{ $route_excluir or '#' }}" class="btn btn-danger confirma-exclusao">Excluir Imagem</a>
            </td>
            @else
            <td class="text-center">
                <strong><em>Nenhuma imagem cadastrada</em></strong>
            </td>
            @endif
        </tr>
    </table>
@endif

<div class="modal fade" tabindex="-1" role="dialog" id="thumbnails">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Thumbnails</h4>
            </div>
            <div class="modal-body">
                <div class="panel panel-default">
                    <table class="table table-condensed">
                        <tbody></tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

@if(isset($route_ordenar))
<script>
    $rotaSortable = "{{ $route_ordenar }}";
</script>
@endif