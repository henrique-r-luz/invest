<?php

namespace app\models\financas\service\operacoesImport;

use Yii;
use app\lib\CajuiHelper;
use yii\web\UploadedFile;
use app\models\financas\OperacoesImport;

/**
 * Define o serviço para os trabalhos de operações de importação de dados 
 */
class OperacoesImportService
{

    private  $operacoesImport;

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
        return  $this->operacoesImport->load($post);
    }


    public function save()
    {
        try {
            $transaction = Yii::$app->db->beginTransaction();
            $this->operacoesImport->arquivo = UploadedFile::getInstance($this->operacoesImport, 'arquivo');
            if (!$this->operacoesImport->saveUpload()) {
                $erro = CajuiHelper::processaErros($this->operacoesImport->getErrors());
                $this->operacoesImport->addError('arquivo', CajuiHelper::processaErros($this->operacoesImport->getErrors()));
                return false;
            }
            OperacoesImportFactory::getObjeto($this->operacoesImport);
            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw new \Exception("Erro ao salvar operações Import ");
            
        }
    }


    public function update()
    {
    }


    public function delte()
    {
    }


    public function getErrors(){
        return $this->operacoesImport->getErrors();
    }


    public function getModel(){
        return $this->operacoesImport;
    }
}
