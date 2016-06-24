<?php namespace App\Repositories\Base;

use Prettus\Repository\Events\RepositoryEntityUpdated;

trait SortableRepository {
    public function reordenar($data) {
        $obj        = $this->model->findOrFail($data["id"]);
        $objVizinho = $this->model->findOrFail($data["vizinho_id"]);
        if ($data["tipo"] == 'moverApos') {
            $obj->moveAfter($objVizinho);
        } else {
            $obj->moveBefore($objVizinho);
        }
        event(new RepositoryEntityUpdated($this, $this->model));
    }    
}
