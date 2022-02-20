<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models\financas\service\operacoesImport;

use Yii;
use app\lib\dicionario\Categoria;
use app\lib\CajuiHelper;
use yii\base\UserException;
use app\lib\dicionario\TipoArquivoUpload;
use app\models\financas\Operacao;
use app\models\financas\ItensAtivo;
use app\models\financas\OperacoesImport;
use app\models\financas\service\sincroniza\ComponenteOperacoes;
use app\models\financas\service\operacoesImport\OperacoesImportHelp;
use app\models\financas\service\operacoesImport\OperacoesImportAbstract;

/**
 * Description of CotacaoEasy
 *
 * @author henrique
 */
class OperacaoNu extends OperacoesImportAbstract
{

    private $csv;

    //put your code here
    protected function getDados()

    {
        if ($this->operacoesImport == null) {
            $objImportado =   OperacoesImport::find()
                ->where(['tipo_arquivo' => TipoArquivoUpload::NU])
                ->orderBy(['data' => SORT_DESC])
                ->one();
            if (empty($objImportado)) {
                return;
            }
            $this->operacoesImport = $objImportado;
        }

        $filePath = Yii::getAlias('@' . OperacoesImport::DIR) . '/' . $this->operacoesImport->hash_nome . '.' . $this->operacoesImport->extensao;

        if (!file_exists($filePath)) {
            throw new \Exception("O arquivo envado não foi salvo no servidor. ");
        }

        $this->csv = array_map(function ($v) use ($filePath) {
            return str_getcsv($v, ComponenteOperacoes::getFileDelimiter($filePath));
        }, file($filePath));
        unset($this->csv[0]);
        unset($this->csv[1]);
    }

    public function atualiza()
    {

        if (empty($this->operacoesImport)) {
            return;
        }
        $contErro = 0;
        $erros = '';
        foreach ($this->csv as $titulo) {
            $codigo = $titulo[1] . '-' . $titulo[3] . '-' . $titulo[2];
            $itensAtivos = ItensAtivo::find()
                ->joinWith(['ativos'])
                ->where(['codigo' => $codigo])->all();
            foreach ($itensAtivos as $itensAtivo) {
                if ($itensAtivo == null) {
                    $contErro++;
                    $erros .= ' o codigo do itensAtivo:' . $codigo . ' não existe</br>';
                } else {
                    
                    $itensAtivo->valor_bruto = floatval(str_replace(',', '.', str_replace('R$', '', str_replace('.', '', $titulo[6]))));
                    $itensAtivo->valor_liquido = floatval(str_replace(',', '.', str_replace('R$', '', str_replace('.', '', $titulo[7]))));
                    $itensAtivo->valor_compra = floatval(str_replace(',', '.', str_replace('R$', '', str_replace('.', '', $titulo[5]))));
                    if ($itensAtivo->valor_compra <= 0 && $itensAtivo->quantidade > 0) {
                        $itensAtivo->valor_compra = $itensAtivo->valor_bruto;
                    }
                    if (!$itensAtivo->save()) {
                        $contErro++;
                        $erros .= CajuiHelper::processaErros($itensAtivo->getErrors()) . '</br>';
                    }
                }
            }
        }
        list($cont, $msg) = $this->atualizaBaby();
        $contErro += $cont;
        $erros .= $msg;
        if ($contErro != 0) {
            throw new UserException($erros);
        }
    }

    public function atualizaBaby()
    {
        $itensAtivos = ItensAtivo::find()
            ->joinWith(['ativos'])
            ->andWhere(['investidor_id' => 2])
            ->andWhere(['categoria' => Categoria::RENDA_FIXA])->all();
        $erros = '';
        foreach ($itensAtivos as $itensAtivo) {
            $compra = Operacao::find()
                ->where(['itens_ativos_id' => $itensAtivo->id])->sum('valor');

            $itensAtivo->valor_compra = $compra;
            $itensAtivo->valor_bruto = $compra;
            $itensAtivo->valor_liquido = $compra;
            if (!$itensAtivo->save()) {
                $erros .= CajuiHelper::processaErros($itensAtivo->getErrors()) . '</br>';
                return [1, $erros];
            }
        }
        return [0, $erros];
    }

    public  function delete()
    {
        OperacoesImportHelp::delete($this->operacoesImport);
    }
}
