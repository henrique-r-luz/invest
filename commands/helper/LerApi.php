<?php

namespace app\commands\helper;

use Yii;
use Throwable;
use app\lib\CajuiHelper;
use app\models\sincronizar\Preco;
use app\commands\ScrapingAtualizaAcoesController;
use app\lib\dicionario\Categoria;
use app\lib\dicionario\Pais;
use app\models\financas\ItensAtivo;

class LerApi
{

    private $vetAtivos;
    private $atualizaAcoes;


    public function __construct(&$atualizaAcoes)
    {
        $this->atualizaAcoes = $atualizaAcoes;
    }

    public function analisaSalvaPreco()
    {
        $this->getAtivos();
        $this->percorreAtivo();
    }


    private  function percorreAtivo()
    {
        foreach ($this->vetAtivos as $ativo_id => $ativo) {
            try {

                if ($ativo['pais'] === Pais::CR) {
                    $this->inserePreco(null, $ativo['pais'], $ativo_id, Yii::$app->api_preco->apiBitcoin, null);
                }
                if ($ativo['pais'] == Pais::US) {
                    $this->inserePreco($ativo['codigo'], $ativo['pais'], $ativo_id, Yii::$app->api_preco->apiUsa, Yii::$app->api_preco->apiUsaKey);
                }
                if ($ativo['pais'] == Pais::BR) {
                    $this->inserePreco($ativo['codigo'], $ativo['pais'], $ativo_id, Yii::$app->api_preco->apiBr, Yii::$app->api_preco->apiBrKey);
                }
                if (!$this->atualizaAcoes->save()) {
                    $erro = CajuiHelper::processaErros($this->atualizaAcoes->getErrors());
                    Yii::error($erro, ScrapingAtualizaAcoesController::categoriaLog);
                }
            } catch (Throwable $ex) {
                $erro = 'Throwable :' . $ativo_id . ' ' . $ex->getMessage();
                $vetAtivos[$ativo_id]['erro'] = $erro;
                Yii::error($erro, ScrapingAtualizaAcoesController::categoriaLog);
                Yii::error($ex->getTraceAsString(), ScrapingAtualizaAcoesController::categoriaLog);
                echo  $erro;
            }
        }
    }



    private function getAtivos()
    {

        $itensAtivos = ItensAtivo::find()
            ->joinWith(['ativos'])
            ->select([
                'itens_ativo.ativo_id',
                'ativo.codigo',
                'pais',
                'ativo.tipo'
            ])
            ->where(['itens_ativo.ativo' => true])
            ->andWhere(['ativo.categoria' => Categoria::RENDA_VARIAVEL])
            ->distinct()->asArray()->all();

        $vetAtivos = [];
        foreach ($itensAtivos as $siteAcoe) {
            try {
                $vetAtivos[$siteAcoe['ativo_id']]['status'] = false;
                $vetAtivos[$siteAcoe['ativo_id']]['codigo'] = $siteAcoe['codigo'];
                $vetAtivos[$siteAcoe['ativo_id']]['tipo'] = $siteAcoe['tipo'];
                $vetAtivos[$siteAcoe['ativo_id']]['pais'] = $siteAcoe['pais'];
                $vetAtivos[$siteAcoe['ativo_id']]['erro'] = '';
            } catch (Throwable $e) {
                echo  $e->getMessage();
            }
        }

        $this->vetAtivos = $vetAtivos;
        $this->atualizaAcoes->ativo_atualizado  = $this->vetAtivos;
    }

    private function inserePreco($ativo, $pais, $ativo_id, $url, $key)
    {

        $preco = new Preco();
        $preco->ativo_id = $ativo_id;
        $preco->valor = $this->getPreco($ativo, $url, $key, $pais);
        $preco->atualiza_acoes_id = $this->atualizaAcoes->id;
        $preco->data = date("Y-m-d H:i:s");
        if ($preco->save()) {
            $this->vetAtivos[$ativo_id]['status'] = true;
        }
        $this->atualizaAcoes->ativo_atualizado  = $this->vetAtivos;
    }

    private function getPreco($codigo, $url, $key, $pais)
    {
        $chave = '';
        $chave = $key;
        $ativoCodigo = $codigo;
        if ($key == null || $key == '') {
            $chave = '';
        }
        if ($codigo == null || $codigo == '') {
            $ativoCodigo = '';
        }
        $urlCompleta = $url . $ativoCodigo  . $chave;
        $json = file_get_contents($urlCompleta);
        return $this->trataJson($json, $pais);
    }


    private function trataJson($json, $pais)
    {
        if ($pais === Pais::CR) {
            $json = json_decode($json);
            return  $json->BRL->last;
        }
        if ($pais == Pais::US) {
            $json = json_decode($json, true);

            return $json[0]['price'];
        }
        if ($pais == Pais::BR) {
            $json = json_decode($json, true);
            return $json['results'][0]['regularMarketPrice'];
        }
    }
}
