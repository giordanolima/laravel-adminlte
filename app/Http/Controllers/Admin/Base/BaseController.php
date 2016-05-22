<?php

namespace App\Http\Controllers\Admin\Base;

use App\Http\Controllers\Controller;
use App\Http\Requests\Base\AdminRequest;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

abstract class BaseController extends Controller {

    protected $titulo = "";
    protected $data = [];
    protected $excluirMetodos = [];
    protected $request;

    public function __construct() {
        $this->data["titulo"] = $this->titulo;
        if($this->request)
            app()->bind(AdminRequest::class, $this->request);
    }

    public function getIndex() {
        if (!in_array("getIndex", $this->excluirMetodos)) {
            $this->data['lista'] = $this->repository->adminLista(request()->all());
            return view($this->views["lista"], $this->data);
        } else {
            throw new NotFoundHttpException;
        }
    }

    public function getCadastrar($id = null) {
        if (!in_array("getCadastrar", $this->excluirMetodos)) {
            $this->data["obj"] = $this->repository->findOrNew($id);
            return view($this->views["cadastrar"], $this->data);
        } else {
            throw new NotFoundHttpException;
        }
    }

    public function postCadastrar(AdminRequest $request) {
        if (!in_array("getCadastrar", $this->excluirMetodos)) {
            $obj = $this->repository->updateOrCreate([$this->repository->getKeyName() => $request->get($this->repository->getKeyName())], $request->except([$this->repository->getKeyName(), '_token']));
            if (method_exists($this->repository, "afterCadastrar"))
                $this->repository->afterCadastrar($obj);
            return redirect()->route($this->route)->with(['ok' => 'Dados atualizados com sucesso.']);
            
        } else {
            throw new NotFoundHttpException;
        }
    }

    public function getExcluir($id) {
        if (!in_array("getIndex", $this->excluirMetodos)) {
            $this->repository->delete($id);
            return redirect()->route($this->route)->with(['ok' => 'Dados excluídos com sucesso.']);
        } else {
            throw new NotFoundHttpException;
        }
    }

    public function getVer($id) {
        if (!in_array("getVer", $this->excluirMetodos)) {
            $this->data["obj"] = $this->repository->find($id);
            return view($this->views["ver"], $this->data);
        } else {
            throw new NotFoundHttpException;
        }
    }
}
