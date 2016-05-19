<?php

namespace App\Http\Requests\Base;

interface AdminRequest {
    
    public function authorize();
    public function rules();
    public function attributes();
    
}
