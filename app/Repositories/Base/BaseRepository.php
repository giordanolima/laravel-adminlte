<?php

namespace App\Repositories\Base;

use Prettus\Repository\Eloquent\BaseRepository as BaseRepo;
use Prettus\Repository\Contracts\CacheableInterface;
use Prettus\Repository\Traits\CacheableRepository;

abstract class BaseRepository extends BaseRepo implements CacheableInterface
{
    use CacheableRepository;
    protected $orderBy = [
        "field" => "created_at",
        "order" => "DESC"
    ];
    protected $regras = [];
    protected $nomes = [];
    protected $limit = 20;

    public function model()
    {
    }
    public function regras(array $fields = array())
    {
        if (count($fields) > 0) {
            $retorno = [];
            foreach ($fields as $field) {
                if (array_key_exists($field, $this->regras)) {
                    $retorno[$field] = $this->regras[$field];
                }
            }

            return $retorno;
        } else {
            return $this->regras;
        }
    }
    public function nomes(array $fields = array())
    {
        if (count($fields) > 0) {
            $retorno = [];
            foreach ($fields as $field) {
                if (array_key_exists($field, $this->nomes)) {
                    $retorno[$field] = $this->nomes[$field];
                }
            }

            return $retorno;
        } else {
            return $this->nomes;
        }
    }
    public function findOrNew($id)
    {
        return $this->model->findOrNew($id);
    }
    public function adminLista($request) {
        
        if(array_key_exists("busca", $request) && $request["busca"] && method_exists($this->model, "busca"))
            $this->scopeQuery($this->model->busca($request["busca"]));
        
        $qtd = array_key_exists("qtd", $request) ? $request["qtd"] : $this->limit;
        return $this->orderBy($this->orderBy["field"],$this->orderBy["order"])->paginate($qtd)->appends($request);
    }
    public function getKeyName() {
        return $this->model->getKeyName();
    }
}
