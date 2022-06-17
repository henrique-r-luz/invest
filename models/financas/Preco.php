<?php

namespace app\models\financas;

use Yii;
use yii\data\ArrayDataProvider;
use app\lib\helpers\InvestException;
use app\models\financas\service\sincroniza\ComponenteOperacoes;

class Preco
{

    private $rendaVariavel;
    private $dollar;

    public function getArrayProvaider()
    {
        $this->rendaVariavel =  $this->loadArquivo(Yii::getAlias('@dados') . '/preco_acao.csv');
        $this->rendaVariavel = $this->montaDadosPrecoAcao();
        $this->dollar = $this->loadArquivo(Yii::getAlias('@dados') . '/cambio.csv');
        $this->dollar = $this->montaDadosDollar();

        $dados = array_merge($this->rendaVariavel, $this->dollar);
        $provider = new ArrayDataProvider([
            'allModels' => $dados,
            'sort' => [
                'attributes' => ['codigo'],
            ],
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

      return $provider;
    }


    private function loadArquivo($path)
    {
        $file = $path;
        if (!file_exists($file)) {
            throw new InvestException("O arquivo não foi encontrato. ");
        }

        $arquivo = array_map(function ($v) use ($file) {
            return str_getcsv($v, ComponenteOperacoes::getFileDelimiter($file));
        }, file($file));
        unset($arquivo[0]);
        return $arquivo;
    }


    private function montaDadosPrecoAcao()
    {
        $ativos = Ativo::find()
            ->select(['id', 'codigo'])
            ->innerjoin('atualiza_acao', 'atualiza_acao.ativo_id = ativo.id')
            ->asArray()
            ->indexBy(['id'])
            ->all();
        $vetAcoes = [];
        /**
         * $item[0] = código do ativo
         * $item[1] = valor do ativo
         */
        foreach ($this->rendaVariavel as $id => $item) {
            $vetAcoes[] = ['codigo' => $ativos[$item[0]]['codigo'], 'valor' => $item[1]];
        }
        return $vetAcoes;
    }


    private function montaDadosDollar()
    {
        $vetDollar = [];
        foreach ($this->dollar as $id => $item) {
            $vetDollar[] = ['codigo' => 'Dollar', 'valor' => $item[1]];
        }
        return $vetDollar;
    }
}
