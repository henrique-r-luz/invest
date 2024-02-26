<?php

namespace tests\unit\app\models\financas\atualizaItensAtivos;

use Yii;
use app\models\admin\User;
use Codeception\Test\Unit;
use app\models\financas\Operacao;
use app\models\financas\ItensAtivo;
use app\tests\_support\unit\SalvaOperacoes;
use app\lib\config\atualizaAtivos\TiposOperacoes;
use app\models\financas\service\operacoesAtivos\OperacaoService;

class RendaFixaNormalTest extends Unit
{

    protected function _before()
    {
        /**
         * usuário admin
         */
        Yii::$app->user->login(User::findOne(Yii::$app->params['userAdminPadraoId']), 1000);
    }

    public function provider()
    {
        $post1  = [

            'Operacao' => [
                'itens_ativos_id' => 53,
                'tipo' => Operacao::tipoOperacaoId()[Operacao::COMPRA],
                'quantidade' => 0.08,
                'data' => '2023-06-28 08:25:30',
                'valor' => 1044,
            ],
        ];

        $respEsperado1 = [
            'quantidade' => 0.79,
            'valor_compra' => 10052.13,

        ];

        $post2  = [

            'Operacao' => [
                'itens_ativos_id' => 53,
                'tipo' => Operacao::tipoOperacaoId()[Operacao::VENDA],
                'quantidade' => 0.08,
                'data' => '2023-06-28 08:25:30',
                'valor' => 1044,
            ],
        ];

        $respEsperado2 = [
            'quantidade' => 0.63,
            'valor_compra' => 7993.13,

        ];

        $post3  = [

            'Operacao' => [
                'itens_ativos_id' => 53,
                'tipo' => Operacao::tipoOperacaoId()[Operacao::DESDOBRAMENTO_MAIS],
                'quantidade' => 0.08,
                'data' => '2023-06-28 08:25:30',
                'valor' => 0,
            ],
        ];

        $respEsperado3 = [
            'quantidade' => 0.79,
            'valor_compra' => 9008.13,

        ];


        $post4  = [

            'Operacao' => [
                'itens_ativos_id' => 53,
                'tipo' => Operacao::tipoOperacaoId()[Operacao::DESDOBRAMENTO_MENOS],
                'quantidade' => 0.08,
                'data' => '2023-06-28 08:25:30',
                'valor' => 0,
            ],
        ];

        $respEsperado4 = [
            'quantidade' => 0.63,
            'valor_compra' => 9008.13,

        ];


        return [
            'Insere operação renda fixa normal de compra no fim da lista ' => [$post1, $respEsperado1],
            'Insere operação renda fixa normal de venda no fim da lista ' => [$post2, $respEsperado2],
            'Insere operação renda fixa normal de desdobramento mais no fim da lista ' => [$post3, $respEsperado3],
            'Insere operação renda fixa normal de desdobramento menos no fim da lista ' => [$post4, $respEsperado4],

        ];
    }


    /**
     * @dataProvider provider
     * @return void
     * @author Henrique Luz
     */
    public function testAtualizaItensAtivoInsereOperacao($post, $respEsperado)
    {
        $salvaOperacoes = new SalvaOperacoes($post);
        $respGerado =  $salvaOperacoes->salvar();

        $this->assertEquals($respGerado, $respEsperado);
    }

    public function testUpdateNoMeioDaLista()
    {
        $idOperacao = 793;
        $model = Operacao::findOne($idOperacao);
        $model->tipo = Operacao::tipoOperacaoId()[Operacao::VENDA];
        $operacaoService = new OperacaoService($model, TiposOperacoes::UPDATE);
        $operacaoService->acaoSalvaOperacao();

        $itensAtivos = ItensAtivo::findOne($model->itens_ativos_id);

        $respGerado = [
            'quantidade' => $itensAtivos->quantidade,
            'valor_compra' => round($itensAtivos->valor_compra, 2),

        ];

        $respEsperado = [
            'quantidade' => 0.55,
            'valor_compra' => 6974.27,

        ];

        $this->assertEquals($respGerado, $respEsperado);
    }


    public function testDeleteCompraFinalDaLista()
    {
        $idOperacao = 803;

        $salvaOperacoes = new SalvaOperacoes();
        $respGerado =  $salvaOperacoes->delete($idOperacao);


        $respEsperado = [
            'quantidade' => 0.63,
            'valor_compra' => 7975.04,

        ];

        $this->assertEquals($respGerado, $respEsperado);
    }

    public function testDeleteVendaFinalDaLista()
    {
        $idOperacao = 843;

        $salvaOperacoes = new SalvaOperacoes();
        $respGerado =  $salvaOperacoes->delete($idOperacao);


        $respEsperado = [
            'quantidade' => 2.8,
            'valor_compra' => 32934.78,

        ];

        $this->assertEquals($respGerado, $respEsperado);
    }


    public function testDeleteDesdoBramentoMaisFinalLista()
    {
        $idOperacao = 842;
        $salvaOperacoes = new SalvaOperacoes();
        $respGerado =  $salvaOperacoes->delete($idOperacao);


        $respEsperado = [
            'quantidade' => 0.08,
            'valor_compra' => 1033.09,

        ];

        $this->assertEquals($respGerado, $respEsperado);
    }

    public function testDeleteDesdoBramentoMenosFinalLista()
    {
        $idOperacao = 844;
        $salvaOperacoes = new SalvaOperacoes();
        $respGerado =  $salvaOperacoes->delete($idOperacao);


        $respEsperado = [
            'quantidade' => 0.73,
            'valor_compra' => 8385.16,

        ];

        $this->assertEquals($respGerado, $respEsperado);
    }
}
