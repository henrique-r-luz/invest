<?php

namespace tests\unit\app\models\financas\atualizaItensAtivos;

use Yii;
use app\models\admin\User;
use Codeception\Test\Unit;
use app\models\financas\Operacao;
use app\tests\_support\unit\SalvaOperacoes;


class RendaVariavelInsereTest extends Unit
{

    protected function _before()
    {
        /**
         * usuário admin
         */
        Yii::$app->user->login(User::findOne(Yii::$app->params['userAdminPadraoId']), 1000);
    }

    public function providerRendaVariavelInsert()
    {
        //insere compra no final da operação
        $post1  = [

            'Operacao' => [
                'itens_ativos_id' => 31,
                'tipo' => Operacao::tipoOperacaoId()[Operacao::COMPRA],
                'quantidade' => 5,
                'data' => '2023-06-08 08:25:30',
                'valor' => 52,
            ],
        ];

        $respEsperado1 = [
            'quantidade' => 621,
            'valor_compra' => 4881.06,

        ];

        //insere venda no final da operacao
        $post2  = [

            'Operacao' => [
                'itens_ativos_id' => 31,
                'tipo' => Operacao::tipoOperacaoId()[Operacao::VENDA],
                'quantidade' => 10,
                'data' => '2023-06-08 08:25:30',
                'valor' => 100,
            ],
        ];

        $respEsperado2 = [
            'quantidade' => 606,
            'valor_compra' =>  4751.04,

        ];

        //insere desdobramento mais no final da lista de operações
        $post3  = [

            'Operacao' => [
                'itens_ativos_id' => 31,
                'tipo' => Operacao::tipoOperacaoId()[Operacao::DESDOBRAMENTO_MAIS],
                'quantidade' => 10,
                'data' => '2023-06-08 08:25:30',
                'valor' => 0,
            ],
        ];

        $respEsperado3 = [
            'quantidade' => 626,
            'valor_compra' =>  4832.72,

        ];

        //insere desdobramento menos no final da lista de operações
        $post4  = [

            'Operacao' => [
                'itens_ativos_id' => 31,
                'tipo' => Operacao::tipoOperacaoId()[Operacao::DESDOBRAMENTO_MENOS],
                'quantidade' => 10,
                'data' => '2023-06-08 08:25:30',
                'valor' => 0,
            ],
        ];

        $respEsperado4 = [
            'quantidade' => 606,
            'valor_compra' =>  4829.82,

        ];


        return [
            'insere uma operação Compra no fim da lista, renda variável' => [$post1, $respEsperado1],
            'insere uma operação Venda no fim da lista, renda variável' => [$post2, $respEsperado2],
            'insere uma operação desdobramento mais no fim da lista, renda variável' => [$post3, $respEsperado3],
            'insere uma operação desdobramento menos no fim da lista, renda variável' => [$post4, $respEsperado4]
        ];
    }

    /**
     * @dataProvider providerRendaVariavelInsert
     * @return void
     * @author Henrique Luz
     */
    public function testAtualizaItensAtivoInsereOperacao($post, $respEsperado)
    {
        $salvaOperacoes = new SalvaOperacoes($post);
        $respGerado =  $salvaOperacoes->salvar();
        $this->assertEquals($respGerado, $respEsperado);
    }
}
