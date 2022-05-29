<?php

namespace app\models\financas\service\operacoesImport;

use Yii;
use Exception;
use Throwable;
use app\lib\CajuiHelper;
use yii\web\UploadedFile;
use app\lib\helpers\InvestException;
use app\models\financas\OperacoesImport;
use app\models\financas\ItensAtivoImport;

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
            //insere ativos que serão atualizadas
            $this->saveItensAtivoImport();
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
            throw new InvestException($e->getMessage());
        }
    }

    private function saveItensAtivoImport()
    {
        if(empty($this->operacoesImport->itens_ativos)){
            return ;
        }
        foreach ($this->operacoesImport->itens_ativos as $item_ativo) {
            $itensAtivoImport  =  new ItensAtivoImport();
            $itensAtivoImport->operacoes_import_id = $this->operacoesImport->id;
            $itensAtivoImport->itens_ativo_id = $item_ativo;
            if (!$itensAtivoImport->save()) {
                $erro = CajuiHelper::processaErros($itensAtivoImport->getErrors());
                throw new InvestException($erro);
            }
        }
    }


    public function reload()
    {
        return  $this->operacoesImport->load($this->post);
    }


    public function delete()
    {
            $acaoImport = OperacoesImportFactory::getObjeto($this->operacoesImport);
            $this->deleteItensAtivoImport($this->operacoesImport);
            $acaoImport->delete();
    }


    private function deleteItensAtivoImport($operacoesImport){
        foreach ($operacoesImport->itensAtivosImports as $item_ativo) {
            if (!$item_ativo->delete()) {
                //throw new \Exception('Erro ao remover ItensAtivoImport. ');
            }
        }
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
