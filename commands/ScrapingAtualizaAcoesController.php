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

/**
 * Atualiza ativos dos tipo renda variável cadastrados no sistema
 *
 * @author Henrique Luz
 */
class ScrapingAtualizaAcoesController extends Controller
{

    private $xPath = './/*[contains(concat(" ",normalize-space(@class)," ")," text-5xl ")]';


    public function actionPage()
    {
        $vetAtivos = $this->getAtivos();
        try {
            foreach ($vetAtivos as $ativo_id => $ativo) {
                $pagina = \file_get_contents($ativo['site']);
                $documento = new DOMDocument('1.0', 'UTF-8');
                $internalErrors = libxml_use_internal_errors(true);
                $documento->loadHTML($pagina);
                libxml_use_internal_errors($internalErrors);
                $tagPreco = new DOMXPath($documento);
                $tagPrecoList = $tagPreco->query($this->xPath);

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
                        $vetAtivos[$ativo_id]['status'] = true;
                        echo 'salva ' . $ativo_id . \PHP_EOL;
                    } else {
                        echo 'erro ' . CajuiHelper::processaErros($preco->getErrors()) . \PHP_EOL;
                    }

                    break;
                }
            }
        } catch (Throwable $ex) {
            echo  $ex->getMessage();
        }
    }


    private function getAtivos()
    {
        $siteAcoes = SiteAcoes::find()->all();
        $vetAtivos = [];
        foreach ($siteAcoes as $siteAcoe) {
            $vetAtivos[$siteAcoe->ativo_id]['status'] = false;
            $vetAtivos[$siteAcoe->ativo_id]['site'] = $siteAcoe->url;
        }
        return $vetAtivos;
    }
}
