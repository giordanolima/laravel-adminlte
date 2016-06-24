<?php namespace App\Http\Controllers\Admin\Base;

trait Sortable {
    public function postReordenar() {
        $obj = $this->repository->reordenar(request()->all());
        if (request()->ajax()) 
            return $obj;
        
        return redirect()->back();
    }
}
