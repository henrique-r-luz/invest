<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models\financas\service\operacoesImport;

use Yii;
use Smalot\PdfParser\Parser;
use app\lib\TipoArquivoUpload;
use app\models\financas\OperacoesImport;
use app\models\financas\service\operacoesImport\OperacoesImportHelp;
use app\models\financas\service\operacoesImport\OperacoesImportAbstract;

/**
 * Description of BancoInter
 *
 * @author henrique
 */
class OperacaoInterSicroniza extends OperacoesImportAbstract
{

    private $valorCdbBruto;
    private $valorCdbLiquido;
    private $cdbBancoInterId = 40;

    //put your code here
    protected function getDados()
    {
        $objImportado =   OperacoesImport::find()
                          ->where(['tipo_arquivo'=>TipoArquivoUpload::INTER])
                          ->orderBy(['data'=>SORT_DESC])
                          ->one();
        $this->operacoesImport = $objImportado;
        $parser = new Parser();
        $filePath = Yii::getAlias('@' . OperacoesImport::DIR) . '/' . $objImportado->hash_nome . '.' . $objImportado->extensao;
        if (!file_exists($filePath)) {
            throw new \Exception("O arquivo envado não foi salvo no servidor. ");
        }
        $pdf = $parser->parseFile($filePath);
        $text = $pdf->getText();
        $valores = $this->between('TOTAL', 'POUPANÇA', $text);
        $valores = preg_replace('/[ ]{2,}|[\t]/', '@', trim($valores));
        $valores = explode('@', trim($valores));
        $this->valorCdbBruto = str_replace('.', '', $valores[count($valores) - 3]);
        $this->valorCdbBruto = str_replace(',', '.', $this->valorCdbBruto);
        $this->valorCdbLiquido = str_replace('.', '', $valores[count($valores) - 1]);
        $this->valorCdbLiquido = str_replace(',', '.', $this->valorCdbLiquido);
    }

    public function atualiza()
    {
        OperacoesImportHelp::AtualizaInter(
            [ 'cdbBancoInterId' => $this->cdbBancoInterId,
                  'valorCdbBruto' => $this->valorCdbBruto,
                  'valorCdbLiquido' => $this->valorCdbLiquido]
        );
    }

    function after($antes, $inthat)
    {
        if (!is_bool(strpos($inthat, $antes)))
            return substr($inthat, strpos($inthat, $antes) + strlen($antes));
    }

    function before($antes, $inthat)
    {
        return substr($inthat, 0, strpos($inthat, $antes));
    }

    function between($antes, $that, $inthat)
    {
        return $this->before($that, $this->after($antes, $inthat));
    }

    public function delete()
    {
        OperacoesImportHelp::delete($this->operacoesImport);
    }
}
