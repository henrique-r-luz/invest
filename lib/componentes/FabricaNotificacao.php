<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\lib\componentes;

/**
 * Description of FabricaNotificacao
 *
 * @author henrique
 */
class FabricaNotificacao {

    public static function create($tipo,$params) {
        switch ($tipo) {
            case 'rank':
                return new NotificacaoRank($params);
                break;
            default:
                null;
        }
    }

    //put your code here
}
