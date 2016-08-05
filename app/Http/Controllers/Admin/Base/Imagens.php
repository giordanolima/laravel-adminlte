<?php

namespace App\Http\Controllers\Admin\Base;

use App\Http\Requests\Base\ImagensCropRequest;

trait Imagens {
    
    public function getExcluirImagem($id) {
        if($this->imagens_repository){
            app()->make($this->imagens_repository)->delete($id);
        }
        if(!request()->ajax())
            return redirect()->back()->with("ok", "Imagem excluída com sucesso!");
    }
    public function getThumbs($id) {
        if($this->imagens_repository){
            return app()->make($this->imagens_repository)->thumbs($id);
        }
        return [];
    }
    public function getRecortarImagem($id) {
        $view = "admin.templates.recortar-imagem";
        if(property_exists($this, "views") && array_key_exists("recortar-imagem", $this->views))
            $view = $this->views["recortar-imagem"];
        return view($view, app()->make($this->imagens_repository)->recortarImagem($id));
    }
    public function postRecortarImagem(ImagensCropRequest $request) {
        if($this->imagens_repository){
            app()->make($this->imagens_repository)->crop($request->all());
        }
        if(!request()->ajax())
            return redirect($request->get("redirect"))->with("ok", "Imagem excluída com sucesso!");
    }
}
