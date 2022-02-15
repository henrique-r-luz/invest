<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models\financas\service\sincroniza;

use app\models\financas\service\operacoesImport\OperacaoNu;
use app\models\financas\service\sincroniza\CotacoesAcao;
use app\models\financas\service\sincroniza\CotacaoCambio;
use app\models\financas\service\sincroniza\CotacoesAcaoApi;
use app\models\financas\service\sincroniza\CotacaoCambioApi;
use app\models\financas\service\sincroniza\InseriEmpresasBolsa;
use app\models\financas\service\operacoesImport\OperacaoInterSicroniza;

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
                return self::getCambio();
            case 'cambioApi':
                return self::getCambioApi();
            case 'acao':
                return self::getAcao();
            case 'acaoApi':
                return self::getAcaoApi();
            case 'easy':
                return self::getEasy();
            case 'empresa':
                return self::getEmpresa();
            case 'banco_inter':
                return self::getBancoInter();
        }
    }

    private static function getAcao()
    {
        return new CotacoesAcao();
    }

    private static function getAcaoApi()
    {
        return new CotacoesAcaoApi();
    }

    private static function getCambio()
    {
        return new CotacaoCambio();
    }

    private static function getCambioApi()
    {
        return new CotacaoCambioApi();
    }


    private static function getEasy()
    {
        return new OperacaoNu(null);
    }

    private static function getEmpresa()
    {
        return new InseriEmpresasBolsa();
    }

    private static function getBancoInter()
    {
        return new OperacaoInterSicroniza();
    }
}
