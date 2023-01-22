<?php

namespace app\models\financas\service\operacoesImport;


use app\lib\CajuiHelper;
use yii\web\UploadedFile;
use app\lib\helpers\InvestException;
use app\models\financas\OperacoesImport;

/**
 * Define o serviço para os trabalhos de operações de importação de dados 
 */
class OperacoesImportService
{

    private  $operacoesImport;
    private $post;

    function __construct($operacoesImport = null)
    {
        if ($operacoesImport != null) {
            $this->operacoesImport = $operacoesImport;
        } else {
            $this->operacoesImport  = new OperacoesImport();
        }
    }


    /**
     * @param mixed $post
     * 
     * @return void
     */
    public function load($post)
    {
        $this->post = $post;
        return  $this->operacoesImport->load($post);
    }


    public function save()
    {
        $this->operacoesImport->arquivo = UploadedFile::getInstance($this->operacoesImport, 'arquivo');
        $this->operacoesImport->data = date("Y-m-d H:i:s");
        if (!$this->operacoesImport->saveUpload()) {
            throw new InvestException('Ocorreu um erro ao salvar upload. ');
        }
        $this->salvaOperacaoImport();
        $acaoImport = OperacoesImportFactory::getObjeto($this->operacoesImport);
        $acaoImport->atualiza();
        $this->operacoesImport->lista_operacoes_criadas_json = $acaoImport->getJson();
        $this->salvaOperacaoImport();
        //atualiza json em operações import

    }


    private function salvaOperacaoImport()
    {
        if (!$this->operacoesImport->save(false)) {
            $erro =  CajuiHelper::processaErros($this->operacoesImport->getErrors());
            throw new InvestException($erro);
        }
    }


    public function removeArquivo()
    {
        if (!OperacoesImport::find()->where(['hash_nome' => $this->operacoesImport->hash_nome])->exists()) {
            $this->operacoesImport->removeArquivo();
        }
    }

    public function reload()
    {
        return  $this->operacoesImport->load($this->post);
    }


    public function delete()
    {
        $acaoImport = OperacoesImportFactory::getObjeto($this->operacoesImport);

        $acaoImport->delete();
    }

    public function getErrors()
    {
        return $this->operacoesImport->getErrors();
    }


    public function getModel()
    {
        return $this->operacoesImport;
    }
}
