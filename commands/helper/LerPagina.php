<?php

namespace app\commands\helper;

use Yii;
use DOMAttr;
use DOMXPath;
use Throwable;
use DOMDocument;
use app\lib\CajuiHelper;
use app\models\sincronizar\Preco;
use app\models\sincronizar\SiteAcoes;
use app\commands\ScrapingAtualizaAcoesController;

class LerPagina
{

    /**
     * local em que está os preços dos ativos
   
     * @var array
     * @author Henrique Luz
     */
    private $xPaths  = [
        './/*[contains(concat(" ",normalize-space(@class)," ")," text-5xl ")]',
        '/html/body/div[1]/div[2]/div/div/div[2]/main/div/div[1]/div[2]/div[1]/span',
        '/html/body/div[1]/div[2]/div[2]/div[1]/div[1]/div[3]/div/div[1]/div[1]/div[1]',
        '/html/body/div[1]/div[2]/div[2]/div[2]/div[1]/div[1]/div[3]/div/div[1]/div[1]/div[1]',
        '/html/body/div[1]/div[2]/div/div/div/main/div/div[1]/div[2]/div[1]/span'
    ];

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
                $tagPrecoList = $this->getTagPreco($ativo);
                $this->inserePreco($tagPrecoList, $ativo_id);
            } catch (Throwable $ex) {
                $erro = 'Throwable :' . $ativo_id . ' ' . $ex->getMessage();
                $vetAtivos[$ativo_id]['erro'] = $erro;
                Yii::error($erro, ScrapingAtualizaAcoesController::categoriaLog);
                echo  $erro;
            }
        }
    }


    private function getTagPreco($ativo)
    {
        $tagPrecoList = null;
        $pagina = \file_get_contents($ativo['site']);
        $documento = new DOMDocument('1.0', 'UTF-8');
        $internalErrors = libxml_use_internal_errors(true);
        $documento->loadHTML($pagina);
        libxml_use_internal_errors($internalErrors);
        $tagPreco = new DOMXPath($documento);
        foreach ($this->xPaths as $xPath) {
            $tagPrecoList = $tagPreco->query($xPath);
            if ($tagPrecoList->length == 0) {
                Yii::error("Não achou o valor do ativo: " . $ativo['codigo'], ScrapingAtualizaAcoesController::categoriaLog);
                continue;
            } else {
                return $tagPrecoList;
            }
        }
    }


    private function inserePreco($tagPrecoList, $ativo_id)
    {
        if ($tagPrecoList == null || $tagPrecoList->length == 0) {
            return;
        }
        /**
         * @var DOMNode $preco
         */
        foreach ($tagPrecoList as $precoSite) {

            $preco = new Preco();
            $preco->ativo_id = $ativo_id;
            Yii::error($precoSite->textContent, ScrapingAtualizaAcoesController::categoriaLog);
            $valor = str_replace(".", "", $precoSite->textContent);
            $valor = str_replace(",", ".", $valor);
            $preco->valor = $valor;
            $preco->atualiza_acoes_id = $this->atualizaAcoes->id;
            $preco->data = date("Y-m-d H:i:s");
            if ($preco->save()) {
                $this->vetAtivos[$ativo_id]['status'] = true;
                echo 'salva ' . $ativo_id . \PHP_EOL;
            } else {
                $erro = CajuiHelper::processaErros($preco->getErrors());
                $this->vetAtivos[$ativo_id]['erro'] = $erro;
                echo 'erro ' . $erro . \PHP_EOL;
                Yii::error($erro, ScrapingAtualizaAcoesController::categoriaLog);
            }
            break;
        }
        $this->atualizaAcoes->ativo_atualizado  = $this->vetAtivos;
        if (!$this->atualizaAcoes->save()) {
            $erro = CajuiHelper::processaErros($this->atualizaAcoes->getErrors());
            Yii::error($erro, ScrapingAtualizaAcoesController::categoriaLog);
        }
    }


    private function getAtivos()
    {
        $siteAcoes = SiteAcoes::find()
            ->joinWith(['ativo'])
            ->all();
        $vetAtivos = [];
        foreach ($siteAcoes as $siteAcoe) {
            $vetAtivos[$siteAcoe->ativo_id]['status'] = false;
            $vetAtivos[$siteAcoe->ativo_id]['site'] = $siteAcoe->url;
            $vetAtivos[$siteAcoe->ativo_id]['codigo'] = $siteAcoe->ativo->codigo;
            $vetAtivos[$siteAcoe->ativo_id]['erro'] = '';
        }
        $this->vetAtivos = $vetAtivos;
    }
}
