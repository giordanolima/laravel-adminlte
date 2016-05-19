<?php

namespace App\Http\Requests\Base;

use App\Http\Requests\Request;

abstract class BaseRequest extends Request
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        return $this->repo->regras($this->fields);
    }
    public function attributes()
    {
        return $this->repo->nomes($this->fields);
    }
}
