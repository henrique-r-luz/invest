<?php
/**
 * Este arquivo é parte do
 *    ___       _       _
 *   / __\__ _ (_)_   _(_)
 *  / /  / _` || | | | | |
 * / /__| (_| || | |_| | |
 * \____/\__,_|/ |\__,_|_|
 *           |__/
 *                 Um sistema integrado do IFNMG
 * PHP version 7
 *
 * @copyright Copyright (c) 2016, IFNMG
 * @license   http://cajui.ifnmg.edu.br/license/ MIT License
 * @link      http://cajui.ifnmg.edu.br/
 */

namespace app\lib;

use Symfony\Component\Process\Process;
use Yii;

/**
 * Classe contem funções uteis para o sistema.
 *
 * @author Christopher Mota
 * @since  1.1.0
 */
class CajuiHelper
{

    /**
     * Trasforma a string proveniente de um campo array do postgres em um array do php
     * {data,data} to [data, data]
     * @param string $value
     * @return array
     */
    public static function stringToArray($value)
    {
        $data = str_replace('{', '', $value);
        $data = str_replace('}', '', $data);
        $data = explode(',', $data);        
        return $data;
    }
    
    /**
     * Passa erros de um array para uma string
     * @param array $erros
     * @return string
     */
    public static function processaErros($erros)
    {
        $msg = '';
        foreach ($erros as $erro) {
            $msg = $msg . \implode("</br>", $erro);
        }
        return $msg;
    }
    
    /**
     * Retorna array com lista de modulos do sistema.
     * @return array
     */
    public static function getModulos()
    {
        $modulos = [];        
        foreach (scandir(Yii::getAlias('@modules')) as $moduleId){
            if ($moduleId != '.' && $moduleId != '..') {
                $modulos[$moduleId] = $moduleId;
            }
        }
        return $modulos;
    }

    /**
     * Gera lista de dias
     *
     * Example:
     *
     * ~~~
     * $dias = CajuiHelper::dias();
     * echo $dias[0]; // returns: Domingo
     * echo $dias[1]; // returns: Segunda-feira
     * ~~~
     *
     * @return array
     */
    public static function dias()
    {
        return ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sabado'];
    }

    /**
     * Converte arquivo de texto(que abre no libreoffice) para pdf
     * @param string $arquivo arquivo com seu endereço completo
     * @param string $saida diretorio no qual será gravado o arquivo. Ex.: /tmp/
     * @return boolean
     * @throws RuntimeException
     */
    public static function convertToPdf($arquivo, $saida)
    {
        $binary = '/usr/bin/libreoffice';

        if (!is_executable($binary)) {
            throw new \RuntimeException(
            'O comando do libreoffice  ("' . $binary . '") ' .
            'não foi encontrado! '
            );
        }
        // Check to see if the profile dir exists and is writeable
        if (is_dir($arquivo) && !is_writable($arquivo)) {
            throw new \RuntimeException(
            'Falta permissão no arquivo ("' . $arquivo . '")!'
            );
        }
        // Build the cmd to run
        $cmd = 'export HOME=/tmp && ' . $binary . ' ' .
            '--headless ' .
            '--convert-to pdf:writer_pdf_Export ' .
            '--outdir "' . $saida . '" ' .
            '"' . $arquivo . '"'
        ;
        
        // Run the command
        $process = new Process($cmd);
        $process->run();
        if (!$process->isSuccessful())
        {
            throw new RuntimeException ($process->getErrorOutput());
        }

        return true;
    }
    
    /**
     * Retira acentos de uma string
     * @param string $string
     * @return string
     */
    public static function retirarAcentos($string)
    {
        return preg_replace(array("/(á|à|ã|â|ä)/", 
                                  "/(Á|À|Ã|Â|Ä)/", 
                                  "/(é|è|ê|ë)/", 
                                  "/(É|È|Ê|Ë)/", 
                                  "/(í|ì|î|ï)/", 
                                  "/(Í|Ì|Î|Ï)/", 
                                  "/(ó|ò|õ|ô|ö)/", 
                                  "/(Ó|Ò|Õ|Ô|Ö)/", 
                                  "/(ú|ù|û|ü)/", 
                                  "/(Ú|Ù|Û|Ü)/", 
                                  "/(ñ)/", "/(Ñ)/"), 
                                  explode(" ", "a A e E i I o O u U n N"), $string);
    }

    /**
     * Normaliza o nome próprio dado, aplicando a capitalização correta de acordo
     * com as regras e exceções definidas no código.
     * @param string $nome O nome a ser normalizado
     * @return string O nome devidamente normalizado
     */
    public static function normalizarNome($nome)
    {
        $ponto = '\.';
        $pontoEspaco = '. ';
        $espaco = ' ';
        $multiplosEspacos = '\s+';
        $numeroRomanao = '^M{0,4}(CM|CD|D?C{0,3})(XC|XL|L?X{0,3})(IX|IV|V?I{0,3})$';

        /*
         * A primeira tarefa da normalização é lidar com partes do nome que
         * porventura estejam abreviadas,considerando-se para tanto a existência de
         * pontos finais (p. ex. JOÃO A. DA SILVA, onde "A." é uma parte abreviada).
         * Dado que mais à frente dividiremos o nome em partes tomando em
         * consideração o caracter de espaço (" "), precisamos garantir que haja um
         * espaço após o ponto. Fazemos isso substituindo todas as ocorrências do
         * ponto por uma sequência de ponto e espaço.
         */
        $nome = mb_ereg_replace($ponto, $pontoEspaco, $nome);

        /*
         * O procedimento anterior, ou mesmo a digitação errônea, podem ter
         * introduzido espaços múltiplos entre as partes do nome, o que é totalmente
         * indesejado. Para corrigir essa questão, utilizamos uma substituição
         * baseada em expressão regular, a qual trocará todas as ocorrências de
         * espaços múltiplos por espaços simples.
         */
        $nome = mb_ereg_replace($multiplosEspacos, $espaco, $nome);

        /*
         * Isso feito, podemos fazer a capitalização "bruta", deixando cada parte do
         * nome com a primeira letra maiúscula e as demais minúsculas. Assim,
         * JOÃO DA SILVA => João Da Silva.
         */
        $nome = mb_convert_case($nome, MB_CASE_TITLE, mb_detect_encoding($nome));


        // Nesse ponto, dividimos o nome em partes, para trabalhar com cada uma delas separadamente.
        $partesNome = mb_split($espaco, $nome);


        // A seguir, são definidas as exceções à regra de capitalização.
        $excecoes = array(
            'de', 'di', 'do', 'da', 'dos', 'das', 'dello', 'della', 'dalla', 'dal',
            'del', 'e', 'em', 'na', 'no', 'nas', 'nos', 'van', 'von', 'y'
        );

        for ($i = 0; $i < count($partesNome); ++$i) {

            /*
             * Verificamos cada parte do nome contra a lista de exceções. Caso haja
             * correspondência, a parte do nome em questão é convertida para letras
             * minúsculas.
             */
            foreach ($excecoes as $excecao) {
                if (mb_strtolower($partesNome[$i]) == mb_strtolower($excecao)) {
                    $partesNome[$i] = $excecao;
                }
            }

            /*
             * Uma situação rara em nomes de pessoas, mas bastante comum em nomes de
             * logradouros, é a presença de numerais romanos, os quais, como é sabido,
             * são utilizados em letras MAIÚSCULAS. Assim utilizu-se uma espressão 
             * regular que testa se há uma correspondência e, em caso positivo,
             * passa a parte do nome para MAIÚSCULAS. Assim, o que antes era
             * "Av. Papa João Xxiii" passa para "Av. Papa João XXIII".
             */
            if (mb_ereg_match($numeroRomanao, mb_strtoupper($partesNome[$i]))) {
                $partesNome[$i] = mb_strtoupper($partesNome[$i]);
            }
        }

        // Finalmente, basta juntar novamente todas as partes do nome, colocando um espaço entre elas.
        return implode($espaco, $partesNome);
    }
    
    /**
     * Retorna a url de um icone para o mime type informado.
     * @param string $mimeType
     */
    public static function getMimeTypeUrlIcon ($mimeType) 
    {
        $extencoes = \yii\helpers\FileHelper::getExtensionsByMimeType($mimeType);
        foreach ($extencoes as $extencao) {
            if (file_exists(Yii::getAlias('@webroot') . Yii::getAlias(Yii::$app->params['img.mimetype']) . '/' . $extencao . '.png')) {
                return Yii::getAlias(Yii::$app->params['img.mimetype']) . '/' . $extencao . '.png';
            }
        }
        return Yii::getAlias(Yii::$app->params['img.mimetype']) . '/_blank.png';
    }
}
