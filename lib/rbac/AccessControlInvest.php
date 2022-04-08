<?php


namespace app\lib\rbac;

use PhpParser\Node\Expr\Throw_;
use Yii;
use yii\filters\AccessControl;
use yii\web\ForbiddenHttpException;

class AccessControlInvest extends AccessControl
{

    public function beforeAction($action)
    {
        
        $user = $this->user;
       /* echo 'use: '.Yii::$app->user->getId().'</br>';
        echo 'rota:'.Yii::$app->controller->id.'</br>';
        echo 'action:'.Yii::$app->controller->action->id.'</br>';*/
        if(Yii::$app->controller->id=='site' && Yii::$app->controller->action->id=='login' ||
           Yii::$app->controller->id=='site' && Yii::$app->controller->action->id=='error' ||
           Yii::$app->controller->id=='site' && Yii::$app->controller->action->id=='logout'){
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
       // throw new ForbiddenHttpException();
        
        return false;
      /*
        foreach ($this->rules as $rule) {
            if ($allow = $rule->allows($action, $user, $request)) {
                return true;
            } elseif ($allow === false) {
                if (isset($rule->denyCallback)) {
                    call_user_func($rule->denyCallback, $rule, $action);
                } elseif ($this->denyCallback !== null) {
                    call_user_func($this->denyCallback, $rule, $action);
                } else {
                    $this->denyAccess($user);
                }

                return false;
            }
        }
        if ($this->denyCallback !== null) {
            call_user_func($this->denyCallback, null, $action);
        } else {
            $this->denyAccess($user);
        }

        return false;*/
    }
}
