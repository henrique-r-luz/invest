<?php

namespace app\models\financas\service\operacoesImport;

use Yii;
use app\lib\CajuiHelper;
use app\models\financas\Operacao;
use app\lib\helpers\InvestException;
use app\models\financas\OperacoesImport;
use app\models\financas\service\sincroniza\ComponenteOperacoes;


class OperacaoProventos extends OperacoesImportAbstract
{
    private $linha;
    private $itensAtivo;
    private $dataAcao;

    protected function getDados()
    {
        
       
    }

    public  function atualiza()
    {
       
    }

    public function delete()
    {
        OperacoesImportHelp::deleteProventos($this->operacoesImport);
    }
}
