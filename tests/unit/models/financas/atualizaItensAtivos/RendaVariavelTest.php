<?php

namespace tests\unit\app\models\financas\atualizaItensAtivos;

use Yii;
use app\models\admin\User;
use Codeception\Test\Unit;
use app\models\financas\Operacao;
use app\lib\config\atualizaAtivos\TiposOperacoes;
use app\models\financas\ItensAtivo;
use app\models\financas\service\operacoesAtivos\OperacaoService;

class RendaVariavelTest extends Unit
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
            'valor_compra' => 4883.21,
            'valor_bruto' => 5042.52
        ];


        return [
            'insere uma operação no fim da lista, renda variável' => [$post1, $respEsperado1]
        ];
    }

    /**
     * @dataProvider providerRendaVariavelInsert
     * @return void
     * @author Henrique Luz
     */
    public function testAtualizaItensAtivoInsereOperacao($post, $respEsperado)
    {
        $model = new Operacao();
        $operacaoService = new OperacaoService($model, TiposOperacoes::INSERIR);
        $operacaoService->load($post);
        $operacaoService->acaoSalvaOperacao();
        $itensAtivos = ItensAtivo::findOne($post['Operacao']['itens_ativos_id']);
        $respGerado = [
            'quantidade' => $itensAtivos->quantidade,
            'valor_compra' => $itensAtivos->valor_compra,
            'valor_bruto' => $itensAtivos->valor_bruto
        ];
        $this->assertEquals($respGerado, $respEsperado);
    }
}
