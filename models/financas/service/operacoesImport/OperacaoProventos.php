<?php

namespace app\models\financas\service\operacoesImport;

use Yii;
use app\lib\CajuiHelper;
use app\models\financas\Proventos;
use app\models\financas\ItensAtivo;
use app\lib\helpers\InvestException;
use app\models\financas\OperacoesImport;
use app\lib\dicionario\ProventosMovimentacao;
use app\lib\config\atualizaAtivos\ComponenteOperacoes;


class OperacaoProventos extends OperacoesImportAbstract
{
    private $proventosInseridos = [];

    protected function getDados()
    {
        $this->proventosInseridos = [];
        $filePath = Yii::getAlias('@' . OperacoesImport::DIR) . '/' . $this->operacoesImport->hash_nome . '.' . $this->operacoesImport->extensao;
        if (!file_exists($filePath)) {
            throw new InvestException("O arquivo enviado não foi salvo no servidor. ");
        }

        $this->arquivo = array_map(function ($v) use ($filePath) {
            return str_getcsv($v, ComponenteOperacoes::getFileDelimiter($filePath));
        }, file($filePath));
        unset($this->arquivo[0]);
    }

    private function removeLinhasVazias($linha)
    {
        if ($linha[0] == null) {
            return true;
        }
        return false;
    }
    private function uniaoDadosRepetidos($item)
    {
        /**
         * valor que está no banco
         */
        $proventos = array_filter($this->proventosInseridos, function ($provento) use ($item) {
            return (($provento->itens_ativos_id == $item->itens_ativos_id)
                && $provento->movimentacao == $item->movimentacao
                && $provento->data == $item->data);
        });
        if (!empty($proventos)) {
            $objProvento = array_values($proventos);
            $provento  = $objProvento[0];
            $provento->valor += $item->valor;
            if (!$provento->save()) {
                $erro = CajuiHelper::processaErros($provento->getErrors());
                throw new InvestException($erro);
            }
            return true;
        }
        return false;
    }

    public  function atualiza()
    {

        try {
            $transaction = Yii::$app->db->beginTransaction();
            foreach ($this->arquivo as $id => $linha) {
                if ($this->removeLinhasVazias($linha)) {
                    continue;
                }

                $ativoProvento = $linha[0];
                $ativoProvento = str_replace(' ', '', $ativoProvento);
                $ativoProvento = \explode('-', $ativoProvento)[0];

                $valorProvento = $linha[6];
                $valorProvento = str_replace('R$', '', $valorProvento);
                $valorProvento = str_replace('.', '', $valorProvento);
                $valorProvento = str_replace(',', '.', $valorProvento);


                $data  = $linha[1];

                list($d, $m, $y) = explode('/', $data);
                $data = $y . '-' . $m . '-' . ($d);


                $movimentacao = $linha[2];
                $provento = new Proventos();
                $provento->itens_ativos_id =  ItensAtivo::find()
                    ->innerJoin('ativo', 'itens_ativo.ativo_id = ativo.id')
                    ->where(['ativo.codigo' => $ativoProvento])
                    ->andWhere(['investidor_id' => $this->operacoesImport->investidor_id])
                    ->one()
                    ->id;
                $provento->valor = floatval($valorProvento);
                $provento->data =  $data . " 20:00:00";
                $provento->movimentacao = ProventosMovimentacao::getId($movimentacao);

                if ($this->uniaoDadosRepetidos($provento)) {
                    continue;
                }

                if (!$provento->save()) {
                    $erro = CajuiHelper::processaErros($provento->getErrors());
                    $transaction->rollBack();
                    throw new InvestException($erro);
                }
                $this->proventosInseridos[] = $provento;

                $this->dadosJson['operacoes_id'][] = $provento->id;
            }
            $transaction->commit();
        } catch (\Exception $e) {
            throw $e;
        } catch (InvestException $e) {
            throw $e;
        }
    }

    public function delete()
    {
        try {
            $transaction = Yii::$app->db->beginTransaction();
            $operacoes =  json_decode($this->operacoesImport->lista_operacoes_criadas_json, true);
            if (!isset($operacoes['operacoes_id'])) {
                $this->operacoesImport->deleteUpload();
                $transaction->commit();
                return true;
            }
            foreach ($operacoes['operacoes_id'] as $operacao) {
                $objOperacao = Proventos::findOne($operacao);
                $objOperacao->delete();
            }
            $this->operacoesImport->deleteUpload();
            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw new InvestException("Error ao remover operação Import. ");
        }
    }
}
