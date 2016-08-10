$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(document).on("click", ".confirma-exclusao", function (e) {
        var fire = $(this).hasClass("fire") ? true : false;
        var _this = $(this);
        e.preventDefault();
        bootbox.confirm("Você tem certeza que desejar excluir esse registro?", function (result) {
            if (result) {
                if (fire)
                    _this.trigger("fire");
                if (_this.is("[type=submit]"))
                    _this.closest("form").trigger("submit");
                if (_this.is("a"))
                    window.location = _this.prop("href");
            }
        });
    });
    Dropzone.autoDiscover = false;
    $(".dropzone").each(function () {
        var paramName = $(this).data("name");
        var url = $(this).prop("action");
        $(this).dropzone({
            url: url,
            acceptedFiles: "image/*",
            paramName: paramName,
            dictInvalidFileType: "Formato de imagem inválido",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            init: function () {
                this.on("complete", function (file) {
                    var data = JSON.parse(file.xhr.responseText);
                    var obj = $(".cada-galeria").last().clone().first();
                    obj.find("[data-field]").each(function () {
                        var field = $(this).data("field");
                        var prop = $(this).data("prop");
                        $(this).prop(prop, data[field]);
                    });
                    if ($("#todos-galeria").children(".callout").length > 0)
                        $("#todos-galeria").children(".callout").remove();

                    obj.removeClass("hidden");
                    $("#todos-galeria").append(obj);
                });
            }
        });
    });
    $(document).on('change', '.btn-file :file', function () {
        var input = $(this),
                label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
        input.trigger('fileselect', [label]);
    });

    $('.btn-file :file').on('fileselect', function (event, label) {
        var input = $(this).parents('.input-group').find(':text'),
                log = label;
        if (input.length) {
            input.val(log);
        } else {
            if (log)
                alert(log);
        }
    });
    
    var action;
    $(".number-spinner button").mousedown(function () {
        btn = $(this);
        input = btn.closest('.number-spinner').find('input');
        btn.closest('.number-spinner').find('button').prop("disabled", false);

    	if (btn.attr('data-dir') == 'up') {
            action = setInterval(function(){
                if ( input.attr('max') == undefined || parseInt(input.val()) < parseInt(input.attr('max')) ) {
                    input.val(parseInt(input.val())+1);
                }else{
                    btn.prop("disabled", true);
                    clearInterval(action);
                }
            }, 50);
    	} else {
            action = setInterval(function(){
                if ( input.attr('min') == undefined || parseInt(input.val()) > parseInt(input.attr('min')) ) {
                    input.val(parseInt(input.val())-1);
                }else{
                    btn.prop("disabled", true);
                    clearInterval(action);
                }
            }, 50);
    	}
    }).mouseup(function(){
        clearInterval(action);
    });

    $(".sortable").each(function(){
        $(this).sortable({
            placeholder: "sort-highlight",
            handle: ".handle",
            cancel: '',
            forcePlaceholderSize: true,
            zIndex: 999999,
            cursor: "move",
            update: function (a, b) {
                var $elemento = b.item;

                var $elementoAnterior = $elemento.prev();
                var $elementoProximo = $elemento.next();
                var $id = $elemento.data('id');
                var $vizinho_id;
                var $tipo;
                if ($elementoAnterior.length > 0) {
                    $tipo = 'moverApos';
                    $vizinho_id = $elementoAnterior.data('id');
                } else if ($elementoProximo.length > 0) {
                    $tipo = 'moverAntes';
                    $vizinho_id = $elementoProximo.data('id');
                }
                $.ajax({
                    url: $rotaSortable,
                    type: 'POST',
                    data: {
                        tipo: $tipo,
                        id: $id,
                        vizinho_id: $vizinho_id
                    },
                    beforeSend: function(){
                        waitingDialog.show();
                    },
                    complete: function () {
                        waitingDialog.hide();
                    }
                });
            }
        });
    });
    $(document).on("click", ".ver-thumbs", function(){
        var url = $(this).data("url");
        $.getJSON(url, function(data){
            var obj = $("#thumbnails").find("table tbody");
            obj.find("tr").remove();
            for (var i = 0; i < data.length; i++) {
                var tr = "<tr>";
                tr += "<td><img src='" + data[i].imagem_url + "' height='80'/></td>";
                tr += "<td class='text-center'>" + data[i].imagem_largura + "px X " + data[i].imagem_altura + "px</td>";
                tr += "<td class='text-right'><a class='btn btn-primary' href='" + url_recortar_imagem(data[i].imagem_id) + "'>Recortar Novamente</a></td>";
                tr += "</tr>";
                obj.append(tr);
            }
            $("#thumbnails").modal("show");
        });
    });
    $(document).on("click", ".adicionar-imagem", function (e) {
        var parent = $(this).closest(".imagens-parent");
        var appendImg = parent.children(".imagens-append");
        var clone = appendImg.children(".form-group").last().clone();
        appendImg.append(clone);
        appendImg.children(".form-group").last().find("[type=file]").val("");
    });
});

$(window).load(function () {
    /* JCROP */
    if ($(".JCrop").length > 0) {

        var ratio = $(".JCrop").data("largura") + ":" + $(".JCrop").data("altura");
        var largura = parseInt($(".JCrop").data("largura"));
        var altura = parseInt($(".JCrop").data("altura"));
        var true_largura = parseInt($(".JCrop").data("true-largura"));
        var true_altura = parseInt($(".JCrop").data("true-altura"));
        var box = $(".JCrop").parent();

        var jcrop = $('.JCrop').imgAreaSelect({
            handles: "corners",
            aspectRatio: ratio,
            imageHeight: true_altura,
            imageWidth: true_largura,
            minHeight: altura,
            minWidth: largura,
            parent: box,
            instance: true,
            x1: 0,
            y1: 0,
            x2: largura,
            y2: altura
        });
        $('.JCrop').closest("form").on("submit", function (e) {
            var crop = jcrop.getSelection();
            if (crop.width == 0 || crop.height == 0) {
                e.preventDefault();
                bootbox.alert("Você deve selecionar a área do recorte.");
            } else {
                $('#cropX1').val(crop.x1);
                $('#cropY1').val(crop.y1);
                $('#cropW').val(crop.width);
                $('#cropH').val(crop.height);
            }

        });

    }
    
    // MASKS
    $('.data').inputmask({ alias: "dd/mm/yyyy"});
    $('.data').datepicker({
        format: 'dd/mm/yyyy',
        language: 'pt-BR'
    });
    $(".timepicker").timepicker({
        minuteStep: 1,
        showMeridian: false,
        defaultTime: false
    });
    if ($('.select2').length > 0) {
        $('.select2').select2();
    }
    if ($('.select2-sem-busca').length > 0) {
        $('.select2-sem-busca').select2({minimumResultsForSearch: Infinity});
    }
    
    // ICHECK
    $('input[type="checkbox"].icheck, input[type="radio"].icheck').iCheck({
        checkboxClass: 'icheckbox_flat-blue',
        radioClass: 'iradio_flat-blue'
    });
    
    if($(".editor").length > 0 && typeof CKEDITOR != "undefined"){
        $(".editor").each(function(){
            CKEDITOR.replace( $(this).attr("id"), {
                filebrowserBrowseUrl: "/fileman/index.html",
                filebrowserImageBrowseUrl: '/fileman/index.html?type=image',
                removeDialogTabs: 'link:upload;image:upload'
            });
        });
    }
});
function nl2br (str, isXhtml) {
  var breakTag = (isXhtml || typeof isXhtml === 'undefined') ? '<br ' + '/>' : '<br>';
  return (str + '')
    .replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2')
}