<?php

namespace App\Models\Base;

trait ImagensTrait {
    
    private $thumbs = [];
    public function getThumb($largura,$altura) {
        if(!array_key_exists($largura.'X'.$altura, $this->thumbs))
            $this->thumbs[$largura.'X'.$altura] = $this->filhos->whereLoose('imagem_largura',$largura)->whereLoose('imagem_altura',$altura)->first();
        return $this->thumbs[$largura.'X'.$altura];
    }
    public function url($largura = null, $altura = null) {
        
        if(property_exists($this, "belongs")){
            $path = $this->{$this->belongs}->folderUrl();
        }else{
            $path = $this->folderUrl();
        }
        
        if(!is_null($altura) && !is_null($largura))
            return asset($path . "/" . $this->getThumb($largura, $altura)->imagem_nome);
        return asset($path . "/" . $this->imagem_nome);
    }
    public function pai()
    {
        return $this->belongsTo(self::class, 'imagem_pai');
    }
    public function filhos()
    {
        return $this->hasMany(self::class, 'imagem_pai')->orderBy('imagem_largura', 'DESC');
    }
}
