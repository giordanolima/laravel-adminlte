<?php

namespace App\Libraries\Helpers;

use Illuminate\Support\Facades\File;

class Helpers
{
    public static function meses($mes) {
        $retorno = [
            "01" => "Janeiro",
            "02" => "Fevereiro",
            "03" => "Março",
            "04" => "Abril",
            "05" => "Maio",
            "06" => "Junho",
            "07" => "Julho",
            "08" => "Agosto",
            "09" => "Setembro",
            "10" => "Outubro",
            "11" => "Novembro",
            "12" => "Dezembro"
        ];
        return $retorno[$mes];
    }
    
    public static function gerarNomeHashArquivo($arquivo, $diretorio, $tamanho = 32)
    {
        $nomeCurto = str_random($tamanho);

        if (is_string($arquivo)) {
            $extensao = pathinfo($arquivo, PATHINFO_EXTENSION);
        } else {
            $extensao = $arquivo->getClientOriginalExtension();
        }

        $nomeCompleto = $nomeCurto.'.'.$extensao;
        $destino = $diretorio.'/'.$nomeCompleto;

        if (File::exists($destino)) {
            return self::gerarNomeHashArquivo($arquivo, $diretorio, $tamanho);
        } else {
            return [
                'completo' => $nomeCompleto,
                'curto' => $nomeCurto,
                'extensao' => $extensao,
            ];
        }
    }

    public static function retirarTagsVazias($str)
    {
        $procurar = [
            0 => '<p></p>',
            1 => '<p> </p>',
            2 => '<div></div>',
            3 => '<div> </div>',
            4 => '<br><br>',
            5 => '<br/><br/>',
            6 => '<br /><br />',
            7 => '<br><br/>',
            8 => '<br/><br>',
            9 => '<br><br />',
            10 => '<br /><br>',
            11 => '<br/><br />',
            12 => '<br /><br/>',
        ];
        $substituir = [
            0 => '',
            1 => '',
            2 => '',
            3 => '',
            4 => '<br />',
            5 => '<br />',
            6 => '<br />',
            7 => '<br />',
            8 => '<br />',
            9 => '<br />',
            10 => '<br />',
            11 => '<br />',
            12 => '<br //>',
        ];
        $novaStr = str_replace($procurar, $substituir, $str);
        if ($str === $novaStr) {
            return $novaStr;
        } else {
            return self::retirarTagsVazias($novaStr);
        }
    }

    public static function limparDiretorio($caminho, $removerDiretorio = false)
    {
        if (is_dir($caminho)) {
            $handle = opendir($caminho);
            while (false !== ($entry = readdir($handle))) {
                if (is_file($caminho.'/'.$entry) && $entry != '.gitignore') {
                    unlink($caminho.'/'.$entry);
                }
                if (is_dir($caminho.'/'.$entry) && $entry != '.' && $entry != '..') {
                    self::limparDiretorio($caminho.'/'.$entry, true);
                }
            }
            if ($removerDiretorio) {
                rmdir($caminho);
            }
        }
    }

    public static function segundosParaHora($sec)
    {
        //        if ($sec == "" || $sec == 0)
//            return "00:00";
//        if (!is_int($sec)) {
//            $sec = intval($sec);
//        }
//        $s = $sec % 60;
//        $m = (($sec - $s) / 60) % 60;
//        $h = floor($sec / 3600);
//        return $h . ":" . substr("0" . $m, -2);
        return gmdate('H:i:s', $sec);
    }

    public static function horaPraSegundos($hora)
    {
        $parse = array();
        if ($hora == '') {
            return (int) 0;
        }
        if (!preg_match('#^(?<hours>[\d]{1,3}):(?<mins>[\d]{2})$#', $hora, $parse)) {
            // Throw error, exception, etc
            throw new \RuntimeException("Hour Format not valid: '".$hora."'");
        }

        return (int) $parse['hours'] * 3600 + (int) $parse['mins'] * 60;
    }

    /** Valida CNPJ
     * @param string $cnpj CNPJ a ser validado
     *
     * @return bool Verdadeiro se válido e Falso se inválido
     * */
    public static function ValidaCNPJ($cnpj)
    {
        $soma = ((5 * $cnpj[0]) + (4 * $cnpj[1]) + (3 * $cnpj[2]) + (2 * $cnpj[3]) + (9 * $cnpj[4]) + (8 * $cnpj[5]) + (7 * $cnpj[6]) + (6 * $cnpj[7]) + (5 * $cnpj[8]) + (4 * $cnpj[9]) + (3 * $cnpj[10]) + (2 * $cnpj[11]));
        $n1 = 11 - ($soma % 11);
        if ($n1 > 9) {
            $n1 = 0;
        }

        $soma = ((6 * $cnpj[0]) + (5 * $cnpj[1]) + (4 * $cnpj[2]) + (3 * $cnpj[3]) + (2 * $cnpj[4]) + (9 * $cnpj[5]) + (8 * $cnpj[6]) + (7 * $cnpj[7]) + (6 * $cnpj[8]) + (5 * $cnpj[9]) + (4 * $cnpj[10]) + (3 * $cnpj[11]) + (2 * $n1));
        $n2 = 11 - ($soma % 11);
        if ($n2 > 9) {
            $n2 = 0;
        }

        if (($n1 == $cnpj[12]) && ($n2 == $cnpj[13])) {
            return true;
        } else {
            return false;
        }
    }

    /** Valida CPF
     * @param string $partes CPF a ser validado
     *
     * @return bool Verdadeiro se válido e Falso se inválido
     * */
    public static function ValidaCPF($partes)
    {
        $partes = str_replace('.', '', $partes);
        $partes = str_replace('-', '', $partes);
        switch ($partes) {
            case '00000000000':
            case '11111111111':
            case '22222222222':
            case '33333333333':
            case '44444444444':
            case '55555555555':
            case '66666666666':
            case '77777777777':
            case '88888888888':
            case '99999999999':
                return false;
        }
        if (strlen($partes) < 11) {
            return false;
        }
        $soma = ($partes[0] * 10) + ($partes[1] * 9) + ($partes[2] * 8) + ($partes[3] * 7) + ($partes[4] * 6) + ($partes[5] * 5) + ($partes[6] * 4) + ($partes[7] * 3) + ($partes[8] * 2);
        if ($soma % 11 < 2) {
            $D1 = 0;
        } else {
            $D1 = 11 - ($soma % 11);
        }

        $soma = ($partes[0] * 11) + ($partes[1] * 10) + ($partes[2] * 9) + ($partes[3] * 8) + ($partes[4] * 7) + ($partes[5] * 6) + ($partes[6] * 5) + ($partes[7] * 4) + ($partes[8] * 3) + ($partes[9] * 2);
        if ($soma % 11 < 2) {
            $D2 = 0;
        } else {
            $D2 = 11 - ($soma % 11);
        }

        if ($D1 == $partes[9] && $D2 == $partes[10]) {
            return true;
        } else {
            return false;
        }
    }

    /*     * Transforma datas Americanas em Brasilerias e vice-versa
     * @param string $data Data a ser transformada
     * @param string $delimitadorEntrada Caracter que separa data na String de Entrada null="/"
     * @param string $delimitadorEntrada Caracter que separa data na String de Saída null="/"
     * @return string Nova data formatada
     * */

    public static function TransformaData($data, $delimitadorEntrada = '/', $delimitadorSaida = '/')
    {
        $partes = explode($delimitadorEntrada, $data);

        return $partes[2].$delimitadorSaida.$partes[1].$delimitadorSaida.$partes[0];
    }

    public static function caixaalta($string)
    {
        $retorno = strtoupper($string);
        $localizar[1] = 'ã';
        $localizar[2] = 'õ';
        $localizar[3] = 'á';
        $localizar[4] = 'é';
        $localizar[5] = 'í';
        $localizar[6] = 'ó';
        $localizar[7] = 'ú';
        $localizar[8] = 'à';
        $localizar[9] = 'â';
        $localizar[10] = 'ê';
        $localizar[11] = 'î';
        $localizar[12] = 'ô';
        $localizar[13] = 'û';
        $localizar[14] = 'ü';
        $localizar[15] = 'ç';

        $substituir[1] = 'Ã';
        $substituir[2] = 'Õ';
        $substituir[3] = 'Á';
        $substituir[4] = 'É';
        $substituir[5] = 'Í';
        $substituir[6] = 'Ó';
        $substituir[7] = 'Ú';
        $substituir[8] = 'À';
        $substituir[9] = 'Â';
        $substituir[10] = 'Ê';
        $substituir[11] = 'Î';
        $substituir[12] = 'Ô';
        $substituir[13] = 'Û';
        $substituir[14] = 'Ü';
        $substituir[15] = 'Ç';

        $retorno = str_replace($localizar, $substituir, $retorno);

        return $retorno;
    }

    public static function caixaalta_semacento($string, $espaco = false)
    {
        $localizar[1] = 'ã';
        $localizar[2] = 'õ';
        $localizar[3] = 'á';
        $localizar[4] = 'é';
        $localizar[5] = 'í';
        $localizar[6] = 'ó';
        $localizar[7] = 'ú';
        $localizar[8] = 'à';
        $localizar[9] = 'â';
        $localizar[10] = 'ê';
        $localizar[11] = 'î';
        $localizar[12] = 'ô';
        $localizar[13] = 'û';
        $localizar[14] = 'ü';
        $localizar[15] = 'ç';
        $localizar[16] = 'Ã';
        $localizar[17] = 'Õ';
        $localizar[18] = 'Á';
        $localizar[19] = 'É';
        $localizar[20] = 'Í';
        $localizar[21] = 'Ó';
        $localizar[22] = 'Ú';
        $localizar[23] = 'À';
        $localizar[24] = 'Â';
        $localizar[25] = 'Ê';
        $localizar[26] = 'Î';
        $localizar[27] = 'Ô';
        $localizar[28] = 'Û';
        $localizar[29] = 'Ü';
        $localizar[30] = 'Ç';
        $localizar[31] = '/';
        $localizar[32] = '\\';
        $localizar[33] = 'ª';
        $localizar[34] = 'º';
        $localizar[35] = '"';
        $localizar[36] = "'";
        $localizar[37] = ',';
        $localizar[38] = '!';
        $localizar[39] = '?';
        $localizar[40] = '.';
        $localizar[41] = ' ';
        $localizar[42] = '%';
        $localizar[43] = '~';
        $localizar[44] = '`';
        $localizar[45] = '@';
        $localizar[46] = '#';
        $localizar[47] = '$';
        $localizar[48] = '%';
        $localizar[49] = '^';
        $localizar[51] = '&';
        $localizar[52] = "\&";
        $localizar[53] = '*';
        $localizar[54] = '(';
        $localizar[55] = ')';
        $localizar[56] = '+';
        $localizar[57] = '=';
        $localizar[58] = '{';
        $localizar[59] = '}';
        $localizar[60] = '[';
        $localizar[61] = ']';
        $localizar[62] = '|';
        $localizar[63] = ':';
        $localizar[64] = ';';
        $localizar[65] = '<';
        $localizar[66] = '>';
        $localizar[67] = '“';
        $localizar[68] = '”';

        $substituir[1] = 'A';
        $substituir[2] = 'O';
        $substituir[3] = 'A';
        $substituir[4] = 'E';
        $substituir[5] = 'I';
        $substituir[6] = 'O';
        $substituir[7] = 'U';
        $substituir[8] = 'A';
        $substituir[9] = 'A';
        $substituir[10] = 'E';
        $substituir[11] = 'I';
        $substituir[12] = 'O';
        $substituir[13] = 'U';
        $substituir[14] = 'U';
        $substituir[15] = 'C';
        $substituir[16] = 'A';
        $substituir[17] = 'O';
        $substituir[18] = 'A';
        $substituir[19] = 'E';
        $substituir[20] = 'I';
        $substituir[21] = 'O';
        $substituir[22] = 'U';
        $substituir[23] = 'A';
        $substituir[24] = 'A';
        $substituir[25] = 'E';
        $substituir[26] = 'I';
        $substituir[27] = 'O';
        $substituir[28] = 'U';
        $substituir[29] = 'U';
        $substituir[30] = 'C';
        $substituir[31] = '_';
        $substituir[32] = '_';
        $substituir[33] = '';
        $substituir[34] = '';
        $substituir[35] = '';
        $substituir[36] = '';
        $substituir[37] = '';
        $substituir[38] = '';
        $substituir[39] = '';
        $substituir[40] = '';
        $substituir[41] = '-';
        $substituir[42] = '';
        $substituir[43] = '';
        $substituir[44] = '';
        $substituir[45] = '';
        $substituir[46] = '';
        $substituir[47] = '';
        $substituir[48] = '';
        $substituir[49] = '';
        $substituir[50] = '';
        $substituir[51] = 'e';
        $substituir[52] = 'e';
        $substituir[53] = '';
        $substituir[54] = '';
        $substituir[55] = '';
        $substituir[56] = '';
        $substituir[57] = '';
        $substituir[58] = '';
        $substituir[59] = '';
        $substituir[60] = '';
        $substituir[61] = '';
        $substituir[62] = '';
        $substituir[63] = '';
        $substituir[64] = '';
        $substituir[65] = '';
        $substituir[66] = '';
        $substituir[67] = '';
        $substituir[68] = '';

        if ($espaco == true) {
            $substituir[41] = ' ';
        }

        $retorno = str_replace($localizar, $substituir, $string);
        $retorno = strtoupper($retorno);

        return $retorno;
    }

    public static function gerar_codigo_rando($tamanho)
    {
        $chaves = array('1', '2', '3', '4', '5', '6', '7', '8', '9', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'X', 'Y', 'W', 'Z');
        $retorno = '';
        for ($i = 1; $i <= $tamanho; ++$i) {
            $k = rand(0, (count($chaves) - 1));
            $retorno .= $chaves[$k];
        }

        return $retorno;
    }

    public static function validaHora($hora)
    {
        try {
            $t = explode(':', $hora);
            if ($t == '' || count($t) < 2) {
                return false;
            }
            $h = $t[0];
            $m = $t[1];

            if (!is_numeric($h) || !is_numeric($m)) {
                return false;
            }

            if ($h < 0 || $h > 24) {
                return false;
            }
            if ($m < 0 || $m > 59) {
                return false;
            }

            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public static function ValidaData($str)
    {
        try {
            $data = explode('/', $str); // fatia a string $dat em pedados, usando / como referência
            if (count($data) != 3) {
                return false;
            }
            $d = $data[0];
            $m = $data[1];
            $y = $data[2];

            // verifica se a data é válida!
            // 1 = true (válida)
            // 0 = false (inválida)
            return (bool) @checkdate($m, $d, $y);
        } catch (Exception $e) {
            return false;
        }
    }

    public static function slug($str)
    {
        return strtolower(self::caixaalta_semacento($str));
    }

    public static function retiraQuebraLinha($str)
    {
        return str_replace("\r", '', str_replace("\n", '', trim($str)));
    }

    public static function UFs()
    {
        return [
            'AC' => 'Acre',
            'AL' => 'Alagoas',
            'AM' => 'Amazonas',
            'AP' => 'Amapá',
            'BA' => 'Bahia',
            'CE' => 'Ceará',
            'DF' => 'Distrito Federal',
            'ES' => 'Espírito Santo',
            'GO' => 'Goiás',
            'MA' => 'Maranhão',
            'MT' => 'Mato Grosso',
            'MS' => 'Mato Grosso do Sul',
            'MG' => 'Minas Gerais',
            'PA' => 'Pará',
            'PB' => 'Paraíba',
            'PR' => 'Paraná',
            'PE' => 'Pernambuco',
            'PI' => 'Piauí',
            'RJ' => 'Rio de Janeiro',
            'RN' => 'Rio Grande do Norte',
            'RO' => 'Rondônia',
            'RS' => 'Rio Grande do Sul',
            'RR' => 'Roraima',
            'SC' => 'Santa Catarina',
            'SE' => 'Sergipe',
            'SP' => 'São Paulo',
            'TO' => 'Tocantins',
        ];
    }

    public static function diasDaSemana()
    {
        return [
            'DOMINGO' => 'DOMINGO',
            'SEGUNDA-FEIRA' => 'SEGUNDA-FEIRA',
            'TERCA-FEIRA' => 'TERÇA-FEIRA',
            'QUARTA-FEIRA' => 'QUARTA-FEIRA',
            'QUINTA-FEIRA' => 'QUINTA-FEIRA',
            'SEXTA-FEIRA' => 'SEXTA-FEIRA',
            'SABADO' => 'SÁBADO',
        ];
    }
}
