<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\lib\componentes;

use  yii\db\JsonExpression;

/**
 * Description of NotificacaoRank
 *
 * @author henrique
 */
class NotificacaoRank extends NotificacaoAbs {
  
    private $parametros;
    
    public function __construct($params) {
        parent::__construct();
        $this->parametros = $params;
    }
    
    public function montaDados() {
        parent::getNotificacao()->user_id = 1;
        parent::getNotificacao()->dados = new JsonExpression($this->parametros);
        
    }
    
  
}
