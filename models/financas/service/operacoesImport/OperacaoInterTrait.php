<?php

namespace app\models\financas\service\operacoesImport;
use app\models\financas\service\operacoesImport\OperacoesImportHelp;
use Smalot\PdfParser\Parser;
/**
 * Undocumented trait
 *
 * @author henrique.luz <henrique_r_luz@yahoo.com.br>
 */
trait OperacaoInterTrait
{


    public function atualizaValores($filePath){
        $parser = new Parser();
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


    public function after($antes, $inthat)
    {
        if (!is_bool(strpos($inthat, $antes)))
            return substr($inthat, strpos($inthat, $antes) + strlen($antes));
    }

    public function before($antes, $inthat)
    {
        return substr($inthat, 0, strpos($inthat, $antes));
    }

    public function between($antes, $that, $inthat)
    {
        return $this->before($that, $this->after($antes, $inthat));
    }

    public function delete()
    {
        OperacoesImportHelp::delete($this->operacoesImport);
    }
}
