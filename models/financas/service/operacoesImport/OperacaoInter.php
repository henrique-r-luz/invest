<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models\financas\service\operacoesImport;

use Yii;
use app\lib\dicionario\TipoArquivoUpload;
use app\models\financas\OperacoesImport;
use app\models\financas\service\operacoesImport\OperacoesImportHelp;
use app\models\financas\service\operacoesImport\OperacoesImportAbstract;

/**
 * Description of BancoInter
 *
 * @author henrique
 */
class OperacaoInter extends OperacoesImportAbstract
{
    use OperacaoInterTrait;

    private $valorCdbBruto;
    private $valorCdbLiquido;
    private $cdbBancoInterId = 40;
    private $valorCompra;
    private $erros;

    //put your code here
    protected function getDados()
    {
        if ($this->operacoesImport == null) {
            $this->objImportado =   OperacoesImport::find()
                ->where(['tipo_arquivo' => TipoArquivoUpload::INTER])
                ->orderBy(['data' => SORT_DESC])
                ->one();

            if (empty($this->objImportado)) {
                return;
            }
            $this->operacoesImport = $this->objImportado;
        }
        $filePath = Yii::getAlias('@' . OperacoesImport::DIR) . '/' . $this->operacoesImport->hash_nome . '.' . $this->operacoesImport->extensao;
        if (!file_exists($filePath)) {
            throw new \Exception("O arquivo envado não foi salvo no servidor. ");
        }
        $this->atualizaValores($filePath);
    }

    public function atualiza()
    {
        OperacoesImportHelp::AtualizaInter(
            [
                'cdbBancoInterId' => $this->cdbBancoInterId,
                'valorCdbBruto' => $this->valorCdbBruto,
                'valorCdbLiquido' => $this->valorCdbLiquido,
                'valorCompra'=>$this->valorCompra
            ]
        );
    }


}
