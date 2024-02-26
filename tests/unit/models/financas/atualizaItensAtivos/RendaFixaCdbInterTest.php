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

class RendaFixaCdbInterTest extends Unit
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
        //insere compra no final da operação
        $post1  = [

            'Operacao' => [
                'itens_ativos_id' => 40,
                'tipo' => Operacao::tipoOperacaoId()[Operacao::COMPRA],
                'quantidade' => 0.1,
                'data' => '2023-06-30 08:25:30',
                'valor' => 1000,
            ],
        ];

        $respEsperado1 = [
            'quantidade' => 200.291,
            'valor_compra' => 17686.98,

        ];

        //insere venda no final da operacao
        $post2  = [

            'Operacao' => [
                'itens_ativos_id' => 40,
                'tipo' => Operacao::tipoOperacaoId()[Operacao::VENDA],
                'quantidade' => 0.1,
                'data' => '2023-06-30 08:25:30',
                'valor' => 1000,
            ],
        ];

        $respEsperado2 = [
            'quantidade' => 200.091,
            'valor_compra' =>  15686.98,
        ];

        //insere desdobramento mais no final da operacao
        $post3  = [

            'Operacao' => [
                'itens_ativos_id' => 40,
                'tipo' => Operacao::tipoOperacaoId()[Operacao::DESDOBRAMENTO_MAIS],
                'quantidade' => 0.1,
                'data' => '2023-06-28 08:25:30',
                'valor' => 0,
            ],
        ];

        $respEsperado3 = [
            'quantidade' => 200.291,
            'valor_compra' => 16686.98,

        ];

        //insere desdobramento mais no final da operacao
        $post4  = [

            'Operacao' => [
                'itens_ativos_id' => 40,
                'tipo' => Operacao::tipoOperacaoId()[Operacao::DESDOBRAMENTO_MENOS],
                'quantidade' => 0.1,
                'data' => '2023-06-28 08:25:30',
                'valor' => 0,
            ],
        ];

        $respEsperado4 = [
            'quantidade' => 200.091,
            'valor_compra' => 16686.98,

        ];

        //insere compra no meio
        $post5  = [

            'Operacao' => [
                'itens_ativos_id' => 40,
                'tipo' => Operacao::tipoOperacaoId()[Operacao::COMPRA],
                'quantidade' => 0.1,
                'data' => '2023-03-03 08:25:30',
                'valor' => 1000,
            ],
        ];

        $respEsperado5 = [
            'quantidade' => 200.291,
            'valor_compra' => 17686.98,

        ];

        //insere venda no meio
        $post6  = [

            'Operacao' => [
                'itens_ativos_id' => 40,
                'tipo' => Operacao::tipoOperacaoId()[Operacao::VENDA],
                'quantidade' => 0.1,
                'data' => '2023-03-03 08:25:30',
                'valor' => 1000,
            ],
        ];

        $respEsperado6 = [
            'quantidade' => 200.091,
            'valor_compra' => 15686.98,

        ];


        return [
            'insere uma operação Compra cdbInter no fim da lista, renda fixa' => [$post1, $respEsperado1],
            'insere uma operação Venda cdbInter no fim da lista, renda fixa' => [$post2, $respEsperado2],
            'insere uma operação desdobramento mais cdbInter no fim da lista, renda fixa' => [$post3, $respEsperado3],
            'insere uma operação desdobramento menos cdbInter no fim da lista, renda fixa' => [$post4, $respEsperado4],
            'insere uma operação compra cdbInter no meio da lista, renda fixa' => [$post5, $respEsperado5],
            'insere uma operação venda cdbInter no meio da lista, renda fixa' => [$post6, $respEsperado6],
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

    public function testUpdate()
    {
        $idOperacoes = 801;

        $model = Operacao::findOne($idOperacoes);
        $model->tipo = Operacao::tipoOperacaoId()[Operacao::COMPRA];
        $operacaoService = new OperacaoService($model, TiposOperacoes::UPDATE);
        $operacaoService->acaoSalvaOperacao();

        $itensAtivos = ItensAtivo::findOne($model->itens_ativos_id);
        $respGerado = [
            'quantidade' => $itensAtivos->quantidade,
            'valor_compra' => round($itensAtivos->valor_compra, 2),

        ];

        $respEsperado = [
            'quantidade' => 200.391,
            'valor_compra' => 17486.98,

        ];

        $this->assertEquals($respGerado, $respEsperado);
    }
}
