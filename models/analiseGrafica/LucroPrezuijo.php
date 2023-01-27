<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models\analiseGrafica;

use app\lib\config\ValorDollar;
use yii\base\Model;
use \app\models\financas\Ativo;
use \app\lib\dicionario\Tipo;
use \app\lib\dicionario\Categoria;
use app\lib\dicionario\Pais;
use app\models\financas\ItensAtivo;

/**
 * Description of LucroPrezuijo
 *
 * @author henrique
 */
class LucroPrezuijo extends Model
{
    const verde = '#90ed7d';
    const vermelho = '#d70026';



    public function getDadosLucroPrejuizo()
    {
        $valor_bruto = ItensAtivo::find()
            ->select(['ativo_id', 'ativo', 'sum(valor_bruto) as valor_bruto ', 'sum(valor_compra) as valor_compra'])
            ->groupBy(['ativo_id', 'ativo']);
        $ativos = Ativo::find()
            ->select([
                'ativo.codigo',
                'itens_ativo.valor_bruto',
                'itens_ativo.valor_compra',
                'pais'
            ])
            ->innerjoin(['itens_ativo' => $valor_bruto], 'itens_ativo.ativo_id = ativo.id')
            ->where(['itens_ativo.ativo' => true])
            ->andWhere(['categoria' => Categoria::RENDA_VARIAVEL])
            ->asArray()
            ->all();
        return $this->criaDadosGrafico($ativos);
    }

    public function criaDadosGrafico($ativos)
    {
        $dados = ['name' => 'Ações', 'data' => []];
        foreach ($ativos as $ativo) {
            $lucro = $ativo['valor_bruto'] - $ativo['valor_compra'];
           
            $lucro = round(ValorDollar::convertValorMonetario($lucro, $ativo['pais']));
            $cor = self::vermelho;
            if ($lucro >= 0) {
                $cor = self::verde;
            }
            $denominador =  1;
            if ($ativo['valor_compra'] != 0) {
                $denominador = ValorDollar::convertValorMonetario($ativo['valor_compra'], $ativo['pais']); 
            }
            $por = round((($lucro) / $denominador) * 100);
            $dados['data'][] = ['name' => $ativo['codigo'], 'y' => $lucro, 'por' => $por, 'color' => $cor];
        }
        $auxSort =  $dados['data'];
        $y  = array_column($auxSort, 'y');
        array_multisort($y, \SORT_DESC, $auxSort);
        $dados['data'] = $auxSort;
        return $dados;
    }
}
