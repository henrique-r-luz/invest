<?php

namespace app\commands;

use DOMNode;
use DOMXPath;
use Throwable;
use DOMDocument;
use app\lib\CajuiHelper;
use yii\console\Controller;
use app\models\sincronizar\Preco;
use app\models\sincronizar\SiteAcoes;
use app\models\sincronizar\services\atualizaAtivos\rendaVariavel\AtualizaRendaVariavel;

/**
 * Atualiza ativos dos tipo renda variável cadastrados no sistema
 *
 * @author Henrique Luz
 */
class ScrapingAtualizaAcoesController extends Controller
{

    private $xPath = './/*[contains(concat(" ",normalize-space(@class)," ")," text-5xl ")]';
    private $vetAtivos = [];


    public function actionPage()
    {
        $this->botPreco();
        $atualizaRendaVariavel = new AtualizaRendaVariavel();
        $atualizaRendaVariavel->alteraIntesAtivo();
        echo "atualiza itens ativos" . \PHP_EOL;
    }

    private function botPreco()
    {
        $this->getAtivos();
        foreach ($this->vetAtivos as $ativo_id => $ativo) {
            try {
                $pagina = \file_get_contents($ativo['site']);
                $documento = new DOMDocument('1.0', 'UTF-8');
                $internalErrors = libxml_use_internal_errors(true);
                $documento->loadHTML($pagina);
                libxml_use_internal_errors($internalErrors);
                $tagPreco = new DOMXPath($documento);
                $tagPrecoList = $tagPreco->query($this->xPath);
                $this->inserePreco($tagPrecoList, $ativo_id);
            } catch (Throwable $ex) {
                $erro = $ex->getMessage();
                $vetAtivos[$ativo_id]['erro'] = $erro;
                echo  $erro;
            }
        }
    }

    private function getAtivos()
    {
        $siteAcoes = SiteAcoes::find()->all();
        $vetAtivos = [];
        foreach ($siteAcoes as $siteAcoe) {
            $vetAtivos[$siteAcoe->ativo_id]['status'] = false;
            $vetAtivos[$siteAcoe->ativo_id]['site'] = $siteAcoe->url;
            $vetAtivos[$siteAcoe->ativo_id]['erro'] = $siteAcoe->url;
        }
        $this->vetAtivos = $vetAtivos;
    }

    private function inserePreco($tagPrecoList, $ativo_id)
    {
        /**
         * @var DOMNode $preco
         */
        foreach ($tagPrecoList as $precoSite) {

            $preco = new Preco();
            $preco->ativo_id = $ativo_id;
            $valor = str_replace(".", "", $precoSite->textContent);
            $valor = str_replace(",", ".", $valor);
            $preco->valor = $valor;
            $preco->data = date("Y-m-d H:i:s");
            if ($preco->save()) {
                $this->vetAtivos[$ativo_id]['status'] = true;
                echo 'salva ' . $ativo_id . \PHP_EOL;
            } else {
                $erro = CajuiHelper::processaErros($preco->getErrors());
                $vetAtivos[$ativo_id]['erro'] = $erro;
                echo 'erro ' . $erro . \PHP_EOL;
            }
            break;
        }
    }
}
