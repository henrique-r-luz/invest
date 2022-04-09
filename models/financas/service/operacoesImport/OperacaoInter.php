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
    private $cdbBancoInterId; //id do cdb inter
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
        if($this->operacoesImport->isNewRecord && empty($this->operacoesImport->itens_ativos)){
            throw new \Exception("Essa operação necessita de um item ativo! ");
        }
        if(!$this->operacoesImport->isNewRecord){
            $this->operacoesImport->itens_ativos = [];
            foreach($this->operacoesImport->itensAtivosImports as $itensAtivo){
                $this->operacoesImport->itens_ativos[] = $itensAtivo->itens_ativo_id;
            }
        }
        $this->cdbBancoInterId = $this->operacoesImport->itens_ativos;
        $filePath = Yii::getAlias('@' . OperacoesImport::DIR) . '/' . $this->operacoesImport->hash_nome . '.' . $this->operacoesImport->extensao;
        if (!file_exists($filePath)) {
            throw new \Exception("O arquivo banco Inter enviado não foi salvo no servidor. ");
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


    



    /**
     * Get the value of cdbBancoInterId
     */ 
    public function getCdbBancoInterId()
    {
        return $this->cdbBancoInterId;
    }

    /**
     * Set the value of cdbBancoInterId
     *
     * @return  self
     */ 
    public function setCdbBancoInterId($cdbBancoInterId)
    {
        $this->cdbBancoInterId = $cdbBancoInterId;

        return $this;
    }
}
