<?php

namespace app\tests\_support\unit;

use app\models\financas\Operacao;
use app\models\financas\ItensAtivo;
use app\lib\config\atualizaAtivos\TiposOperacoes;
use app\models\financas\service\operacoesAtivos\OperacaoService;

class SalvaOperacoes
{

    public function __construct(
        private ?array $post = [],
    ) {
    }

    public function salvar()
    {
        $model = new Operacao();
        $operacaoService = new OperacaoService($model, TiposOperacoes::INSERIR);
        $operacaoService->load($this->post);
        $operacaoService->acaoSalvaOperacao();
        $itensAtivos = ItensAtivo::findOne($this->post['Operacao']['itens_ativos_id']);
        $respGerado = [
            'quantidade' => $itensAtivos->quantidade,
            'valor_compra' => round($itensAtivos->valor_compra, 2),
            'valor_bruto' => round($itensAtivos->valor_bruto, 2)
        ];
        return $respGerado;
    }


    public function delete($id)
    {
        $model = Operacao::findOne($id);
        $operacaoService = new OperacaoService($model, TiposOperacoes::DELETE);
        $operacaoService->acaoDeletaOperacao();

        $itensAtivos = ItensAtivo::findOne($model->itens_ativos_id);
        $respGerado = [
            'quantidade' => $itensAtivos->quantidade,
            'valor_compra' => round($itensAtivos->valor_compra, 2),
            'valor_bruto' => round($itensAtivos->valor_bruto, 2)
        ];
        return $respGerado;
    }


    public function update($id)
    {
        $model = Operacao::findOne($id);
        $model->tipo = Operacao::tipoOperacaoId()[Operacao::COMPRA];
        $operacaoService = new OperacaoService($model, TiposOperacoes::UPDATE);
        $operacaoService->acaoSalvaOperacao();

        $itensAtivos = ItensAtivo::findOne($model->itens_ativos_id);
        $respGerado = [
            'quantidade' => $itensAtivos->quantidade,
            'valor_compra' => round($itensAtivos->valor_compra, 2),
            'valor_bruto' => round($itensAtivos->valor_bruto, 2)
        ];
        return $respGerado;
    }
}
