<?php

namespace app\models\financas\service\operacoesImport;

use Yii;
use app\lib\CajuiHelper;
use yii\web\UploadedFile;
use app\models\financas\OperacoesImport;
use Throwable;

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
        try {

            $transaction = Yii::$app->db->beginTransaction();
            $this->operacoesImport->arquivo = UploadedFile::getInstance($this->operacoesImport, 'arquivo');
            $this->operacoesImport->data = date("Y-m-d H:i:s");
            if (!$this->operacoesImport->saveUpload()) {
                $transaction->rollBack();
                return false;
            }
            $acaoImport = OperacoesImportFactory::getObjeto($this->operacoesImport);
            $acaoImport->atualiza();
            $this->operacoesImport->refresh();
            $this->operacoesImport->lista_operacoes_criadas_json = $acaoImport->getJson();
            if (!$this->operacoesImport->save(false)) {
                $transaction->rollBack();
                return false;
            }
            $transaction->commit();
            return true;
        } catch (Throwable $e) {
            $transaction->rollBack();
            if (!OperacoesImport::find()->where(['hash_nome' => $this->operacoesImport->hash_nome])->exists()) {
                $this->operacoesImport->removeArquivo();
            }
            throw new \Exception($e->getMessage());
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
