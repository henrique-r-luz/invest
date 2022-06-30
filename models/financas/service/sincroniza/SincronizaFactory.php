<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models\financas\service\sincroniza;

use app\models\financas\service\sincroniza\CotacoesAcao;
use app\models\financas\service\sincroniza\CotacaoCambio;
use app\models\financas\service\operacoesImport\OperacaoNu;
use app\models\financas\service\operacoesImport\OperacaoInter;


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
                return new OperacaoNu(null);;
            case 'banco_inter':
                return new OperacaoInter(null);
        }
    }
}
