<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\lib\actions;
/**
 * Description of ActionException
 *
 * @author henrique
 */


use yii\web\ErrorAction;

class ActionException extends ErrorAction{
    //put your code here
    
     /**
     * Runs the action.
     *
     * @return string result content
     */
    public function run()
    {
       // echo 'olaa:'.$this->layout;
        //exit();
       /* if ($this->layout !== null) {
            $this->controller->layout = $this->layout;
        }

        Yii::$app->getResponse()->setStatusCodeByException($this->exception);

        if (Yii::$app->getRequest()->getIsAjax()) {
            return $this->renderAjaxResponse();
        }
        //return $this->renderAjaxResponse();
       return $this->renderHtmlResponse();*/
    }
}
