<?php

namespace App\Libraries\Validacoes;

use Illuminate\Validation\Validator;

class Validacoes extends Validator {

    public function validatePassword($attribute, $value, $parameters) {
        return \Illuminate\Support\Facades\Hash::check($value, $parameters[0]);
    }

    public function validateMoeda($attribute, $value) {
        $valor = str_replace(',', '.', str_replace('.', '', $value));

        return is_numeric($valor);
    }

    public function validateHoras($attribute, $value) {
        if ($value) {
            $partes = explode(':', $value);
            if (count($partes) != 2) {
                return false;
            }

            if (!is_numeric($partes[0])) {
                return false;
            }

            if (!is_numeric($partes[1]) || (int) $partes[1] > 60) {
                return false;
            }
        }

        return true;
    }

    public function validateCPFCNPJ($attribute, $value, $parameters) {
        $c = preg_replace('/\D/', '', $value);
        if (strlen($c) == 11) {
            return $this->validateCPF($attribute, $value, $parameters);
        }
        if (strlen($c) == 14) {
            return $this->validateCNPJ($attribute, $value, $parameters);
        }

        return false;
    }

    public function validateCPF($attribute, $value, $parameters) {
        $c = preg_replace('/\D/', '', $value);
        if (strlen($c) != 11 || preg_match("/^{$c[0]}{11}$/", $c)) {
            return false;
        }
        for ($s = 10, $n = 0, $i = 0; $s >= 2; $n += $c[$i++] * $s--)
            ;
        if ($c[9] != ((($n %= 11) < 2) ? 0 : 11 - $n)) {
            return false;
        }
        for ($s = 11, $n = 0, $i = 0; $s >= 2; $n += $c[$i++] * $s--)
            ;
        if ($c[10] != ((($n %= 11) < 2) ? 0 : 11 - $n)) {
            return false;
        }

        return true;
    }

    public function validateCNPJ($attribute, $value, $parameters) {
        $c = preg_replace('/\D/', '', $value);
        $b = array(6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2);
        if (strlen($c) != 14) {
            return false;
        }
        for ($i = 0, $n = 0; $i < 12; $n += $c[$i] * $b[++$i])
            ;
        if ($c[12] != ((($n %= 11) < 2) ? 0 : 11 - $n)) {
            return false;
        }
        for ($i = 0, $n = 0; $i <= 12; $n += $c[$i] * $b[$i++])
            ;
        if ($c[13] != ((($n %= 11) < 2) ? 0 : 11 - $n)) {
            return false;
        }

        return true;
    }

    public function validateTelefone($attribute, $value, $parameters) {
        return (bool) preg_match("/^\(\d{2}\)[1-9]?\d{4}-\d{4}\d?$/", $value);
    }

}
