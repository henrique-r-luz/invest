<?php

namespace app\models\sincronizar\services;

use Yii;
use app\lib\CajuiHelper;
use app\models\sincronizar\Preco;
use app\lib\helpers\InvestException;
use app\lib\helpers\ConvertValorMonetario;
use app\lib\config\atualizaAtivos\ComponenteOperacoes;

class AddPreco
{
    private $local_file = '/var/www/dados/preco_acao.csv';
    private $arquivo;

    public function __construct()
    {
        $this->getDados();
    }

    public function salva()
    {
        $this->analisaDados();
    }

    private function getDados()
    {
        $file = $this->local_file;
        $this->arquivo = array_map(function ($v) use ($file) {
            return str_getcsv($v, ComponenteOperacoes::getFileDelimiter($file));
        }, file($file));
        unset($this->arquivo[0]);
    }

    private function analisaDados()
    {

        foreach ($this->arquivo as $item) {
            $this->inserePreco($item[0], $item[1]);
        }
    }

    private function inserePreco($ativo_id, $valor)
    {
        if ($valor == '-1') {
            return;
        }
        $preco  = new Preco();
        $preco->ativo_id  = $ativo_id;
        $preco->valor = ConvertValorMonetario::brParaUs($valor);
        $preco->data = date("Y-m-d H:i:s");
        if (!$preco->save()) {
            $erro =  CajuiHelper::processaErros($preco->getErrors());
            throw new InvestException($erro);
        }
    }
}
