<?php

namespace App\Models\Base;

use Illuminate\Support\Facades\DB;

trait FoldersTrait
{
    /**
     * Retorna o valor do index para ser usado em diretorios.
     *
     * Considera agrupamentos usando o atributo: $diretorioColunaAgrupada.
     * Considera registros que foram apagados usando softDelete.
     *
     * @return int
     */
    public function nextIndex()
    {
        if ($this->table && $this->folderColunm) {
            $selectQuery = DB::raw('(COALESCE(MAX('.$this->folderColunm.'), 0) + 1 ) as "index"');
            $resultado = DB::table($this->table)->select($selectQuery);

            return $resultado->value('index');
        } else {
            return;
        }
    }

    /**
     * Retorna uma string formatada com o caminho do diretório.
     * 
     * @return string
     */
    public function folderUrl()
    {
        if ($this->folderName) {
            return $this->folderName.'/'.$this->{$this->folderColunm};
        } else {
            return $this->{$this->folderColunm};
        }
    }

    /**
     * Retorna uma string com o path do diretório.
     * 
     * @return string
     */
    public function folderPath()
    {
        return public_path($this->folderUrl());
    }

    public function createFolder()
    {
        if (!is_dir($this->folderPath())) {
            mkdir($this->folderPath());
        }
    }

    public function deleteFolder()
    {
        if (is_dir($this->folderPath())) {
            $this->cleanFolder($this->folderPath(),TRUE);
        }
    }

    private function cleanFolder($path, $deleteFolder = false)
    {
        if (is_dir($path)) {
            $handle = opendir($path);
            while (false !== ($entry = readdir($handle))) {
                if (is_file($path.'/'.$entry) && $entry != '.gitignore') {
                    unlink($path.'/'.$entry);
                }
                if (is_dir($path.'/'.$entry) && $entry != '.' && $entry != '..') {
                    $this->cleanFolder($path.'/'.$entry, true);
                }
            }
            if ($deleteFolder) {
                rmdir($path);
            }
        }
    }

    public function gerarNomeHashArquivo($arquivo, $tamanho = 32)
    {
        $nomeCurto = str_random($tamanho);
        $diretorio = $this->folderPath();

        if (is_string($arquivo)) {
            $extensao = pathinfo($arquivo, PATHINFO_EXTENSION);
        } else {
            $extensao = $arquivo->getClientOriginalExtension();
        }

        $nomeCompleto = $nomeCurto.'.'.$extensao;
        $destino = $diretorio.'/'.$nomeCompleto;

        if (is_file($destino)) {
            return $this->gerarNomeHashArquivo($arquivo, $tamanho);
        } else {
            return [
                'completo' => $nomeCompleto,
                'curto' => $nomeCurto,
                'extensao' => $extensao,
            ];
        }
    }
}
