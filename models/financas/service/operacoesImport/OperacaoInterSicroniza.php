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
    use OperacaoInterTrait;

    private $valorCdbBruto;
    private $valorCdbLiquido;
    private $cdbBancoInterId = 40;
    private $objImportado;

    //put your code here
    protected function getDados()
    {
        $this->objImportado =   OperacoesImport::find()
            ->where(['tipo_arquivo' => TipoArquivoUpload::INTER])
            ->orderBy(['data' => SORT_DESC])
            ->one();
        if (empty($this->objImportado)) {
            return;
        }
        $this->operacoesImport = $this->objImportado;
        $filePath = Yii::getAlias('@' . OperacoesImport::DIR) . '/' . $this->objImportado->hash_nome . '.' . $this->objImportado->extensao;
        if (!file_exists($filePath)) {
            throw new \Exception("O arquivo envado não foi salvo no servidor. ");
        }
        $this->atualizaValores($filePath);
        
    }

    public function atualiza()
    {
        if (empty($this->objImportado)) {
            return;
        }
        OperacoesImportHelp::AtualizaInter(
            [
                'cdbBancoInterId' => $this->cdbBancoInterId,
                'valorCdbBruto' => $this->valorCdbBruto,
                'valorCdbLiquido' => $this->valorCdbLiquido
            ]
        );
    }

}
