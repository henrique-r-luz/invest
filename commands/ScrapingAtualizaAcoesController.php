<?php

namespace app\commands;

use DOMDocument;
use DOMNode;
use DOMXPath;
use Throwable;
use yii\console\Controller;


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
        try {
            $pagina = \file_get_contents('https://br.investing.com/equities/fleury-on-nm');
            $documento = new DOMDocument('1.0', 'UTF-8');
            $internalErrors = libxml_use_internal_errors(true);
            $documento->loadHTML($pagina);
            libxml_use_internal_errors($internalErrors);
            $tagPreco = new DOMXPath($documento);
            $tagPrecoList = $tagPreco->query($this->xPath);

            /**
             * @var DOMNode $preco
             */
            foreach ($tagPrecoList as $preco) {
                echo $preco->textContent . \PHP_EOL;
                break;
            }
        } catch (Throwable $ex) {
            return $ex->getMessage();
        }
    }
}
