<?php

namespace App\Libraries\Validacoes;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use App\Libraries\Validacoes\Validacoes;

class ValidacoesServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        Validator::resolver(function ($translator, $data, $rules, $messages, $attributes) {
            return new Validacoes($translator, $data, $rules, $messages, $attributes);
        });
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        //
    }
}
