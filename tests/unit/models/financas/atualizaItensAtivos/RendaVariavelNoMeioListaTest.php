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

class RendaVariavelNoMeioListaTest extends Unit
{
    protected function _before()
    {
        /**
         * usuário admin
         */
        Yii::$app->user->login(User::findOne(Yii::$app->params['userAdminPadraoId']), 1000);
    }

    public function providerRendaVariavel()
    {
        $post1  = [

            'Operacao' => [
                'itens_ativos_id' => 14,
                'tipo' => Operacao::tipoOperacaoId()[Operacao::COMPRA],
                'quantidade' => 7,
                'data' => '2023-06-25 12:21:04',
                'valor' => 385,
            ],
        ];

        $respEsperado1 = [
            'quantidade' => 106,
            'valor_compra' => 10963.34,
            'valor_bruto' => 10834.26
        ];

        $post2  = [

            'Operacao' => [
                'itens_ativos_id' => 14,
                'tipo' => Operacao::tipoOperacaoId()[Operacao::VENDA],
                'quantidade' => 7,
                'data' => '2023-06-25 12:21:04',
                'valor' => 385,
            ],
        ];

        $respEsperado2 = [
            'quantidade' => 92,
            'valor_compra' =>  10230.59,
            'valor_bruto' => 9403.32
        ];

        $post3  = [

            'Operacao' => [
                'itens_ativos_id' => 14,
                'tipo' => Operacao::tipoOperacaoId()[Operacao::DESDOBRAMENTO_MAIS],
                'quantidade' => 7,
                'data' => '2023-06-25 12:21:04',
                'valor' => 0,
            ],
        ];

        $respEsperado3 = [
            'quantidade' => 106,
            'valor_compra' => 10606.10,
            'valor_bruto' => 10834.26
        ];

        $post4  = [

            'Operacao' => [
                'itens_ativos_id' => 14,
                'tipo' => Operacao::tipoOperacaoId()[Operacao::DESDOBRAMENTO_MENOS],
                'quantidade' => 7,
                'data' => '2023-06-25 12:21:04',
                'valor' => 0,
            ],
        ];

        $respEsperado4 = [
            'quantidade' => 92,
            'valor_compra' => 10553.76,
            'valor_bruto' =>  9403.32
        ];


        return [
            'Insere operações de compra no meio' => [$post1, $respEsperado1],
            'Insere operações de venda no meio' => [$post2, $respEsperado2],
            'Insere operações de desdobramento mais no meio' => [$post3, $respEsperado3],
            'Insere operações de desdobramento menos no meio' => [$post4, $respEsperado4],
        ];
    }

    /**
     * @dataProvider providerRendaVariavel
     * @return void
     * @author Henrique Luz
     */
    public function testAddOperacoes($post, $respEsperado)
    {
        $salvaOperacoes = new SalvaOperacoes($post);
        $respGerado =  $salvaOperacoes->salvar();
        $this->assertEquals($respGerado, $respEsperado);
    }


    public function testRemoveNoMeioDaLista()
    {
        $idOperacoes  = 629;

        $model = Operacao::findOne($idOperacoes);
        $operacaoService = new OperacaoService($model, TiposOperacoes::DELETE);
        $operacaoService->acaoDeletaOperacao();

        $itensAtivos = ItensAtivo::findOne($model->itens_ativos_id);
        $respGerado = [
            'quantidade' => $itensAtivos->quantidade,
            'valor_compra' => round($itensAtivos->valor_compra, 2),
            'valor_bruto' => round($itensAtivos->valor_bruto, 2)
        ];
        $respEsperado = [
            'quantidade' => 88,
            'valor_compra' => 9563.47,
            'valor_bruto' => 8994.48
        ];
        $this->assertEquals($respGerado, $respEsperado);
    }
}
