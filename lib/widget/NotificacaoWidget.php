<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of NotificacaoWidget
 *
 * @author henrique
 */
namespace  app\lib\widget;

use yii\base\Widget;
use \app\models\NotificacaoSearch;

class NotificacaoWidget extends Widget {
    public function init()
    {
        parent::init();
       
    }

    public function run()
    {
      
       $notificacaoSearch = new NotificacaoSearch();
       $params = [
           'NotificacaoSearch'=>
           ['lido'=>FALSE]
       ];
       $dataProvider = $notificacaoSearch->search($params);
     ;
        return $this->render('notificacao/notificacao-widget',['dataProvider'=>$dataProvider]);
    }
    
    
}
