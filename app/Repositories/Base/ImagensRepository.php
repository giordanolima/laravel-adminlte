<?php

namespace App\Repositories\Base;

use Intervention\Image\Facades\Image;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpFoundation\File\UploadedFile;

trait ImagensRepository
{
    public function enviarImagem(Model $obj, $tipo, UploadedFile $file, $substituir = false)
    {
        //EXCLUINDO ANTIGA
        if ($substituir) {
            $imagens = $this->findWhere([
                $obj->getKeyName() => $obj->getKey(),
                'imagem_tipo' => $tipo,
            ], ['imagem_id']);
            foreach ($imagens as $img) {
                $this->delete($img->imagem_id);
            }
        }

        
        $arquivo = $obj->gerarNomeHashArquivo($file);
        $file->move($obj->folderPath(), $arquivo['completo']);
        $tamanho = getimagesize($obj->folderPath().'/'.$arquivo['completo']);
        
        list($largura, $altura) = getimagesize($obj->folderPath() . "/" . $arquivo['completo']);
        if($largura < $this->model->sizes[$tipo][0] || $altura < $this->model->sizes[$tipo][1]){
            $img = Image::make($obj->folderPath() . "/" . $arquivo['completo']);
            $img->resizeCanvas($this->model->sizes[$tipo][0], $this->model->sizes[$tipo][1], 'center');
            $img->save($obj->folderPath() . "/" . $arquivo['completo']);
            $tamanho = getimagesize($obj->folderPath().'/'.$arquivo['completo']);
        }

        $imagem = $this->create([
            $obj->getKeyName() => $obj->getKey(),
            'imagem_tipo' => $tipo,
            'imagem_nome' => $arquivo['completo'],
            'imagem_largura' => $tamanho[0],
            'imagem_altura' => $tamanho[1],
        ]);

        return $imagem;
    }
    public function thumbs($id) {
        $retorno = [];
        $imagens = $this->find($id)->filhos;
        foreach ($imagens as $img) {
            $retorno[] = [
                "imagem_id" => $img->imagem_id,
                "imagem_url" => asset($img->{$this->belongs}->folderUrl() . "/" . $img->imagem_nome),
                "imagem_largura" => $img->imagem_largura,
                "imagem_altura" => $img->imagem_altura,
            ];
        }
        return $retorno;
    }
    public function crop($data) {
        $data = collect($data);
        $imagem = $this->find($data->get("id"));
        $obj = $imagem->{$this->belongs};
        $arquivo = $obj->gerarNomeHashArquivo($imagem->imagem_nome);
        
        $img = Image::make($obj->folderPath() . "/" . $imagem->pai->imagem_nome);
        $img->crop((int)$data->get("w"), (int)$data->get("h"), (int)$data->get("x"), (int)$data->get("y"));
        $img->resize($imagem->imagem_largura, $imagem->imagem_altura);
        $img->save($obj->folderPath() . '/' . $arquivo['completo']);
        
        $this->create([
            $obj->getKeyName() => $obj->getKey(),
            "imagem_pai" => $imagem->imagem_pai,
            "imagem_tipo" => "THUMBNAIL",
            "imagem_nome" => $arquivo['completo'],
            "imagem_largura" => $imagem->imagem_largura,
            "imagem_altura" => $imagem->imagem_altura
        ]);
        
        $imagem->delete();
    }
}