<?php


namespace app\lib\rbac;

use Yii;
use yii\filters\AccessControl;


class AccessControlInvest extends AccessControl
{

    public function beforeAction($action)
    {
        
        $user = $this->user;
        /**
         * páginas publicas
         */
        if(Yii::$app->controller->id=='site' && Yii::$app->controller->action->id=='login' ||
           Yii::$app->controller->id=='site' && Yii::$app->controller->action->id=='error' ||
           Yii::$app->controller->id=='site' && Yii::$app->controller->action->id=='logout' ||
           Yii::$app->controller->id=='financas/atualiza-acao' && Yii::$app->controller->action->id=='url'
           ){
            return true;
        }

        if(Yii::$app->user->can('admin')){
            return true;
        }

        if(Yii::$app->authManager->checkAccess($user->id,(Yii::$app->controller->id.'/'.Yii::$app->controller->action->id))){
            return true;
        }
        if ($this->denyCallback !== null) {
            call_user_func($this->denyCallback, null, $action);
        } else {
            $this->denyAccess($user);
        }
        
        return false;
     
    }
}
