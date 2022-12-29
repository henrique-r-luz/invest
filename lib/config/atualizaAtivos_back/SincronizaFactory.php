<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace  app\lib\config\atualizaAtivos;

use app\lib\config\atualizaAtivos\CotacoesAcao;
use app\lib\config\atualizaAtivos\CotacaoCambio;
use app\models\financas\service\operacoesImport\OperacaoNu;




/**
 * Description of Sincronizafactory
 *
 * @author henrique
 */
class SincronizaFactory
{

    //put your code here
    public static function sincroniza($tipo)
    {

        switch ($tipo) {
            case 'cambio':
                return new CotacaoCambio();
            case 'acao':
                return new CotacoesAcao();
            case 'easy':
                return new OperacaoNu(null);
        }
    }
}
