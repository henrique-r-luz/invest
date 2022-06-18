<?php


namespace app\lib\rbac;

use Yii;
use yii\helpers\Url;
use yii\filters\AccessControl;


class AccessControlInvest extends AccessControl
{

    public function beforeAction($action)
    {

        $user = $this->user;
        /**
         * páginas públicas
         */
        if (
            Yii::$app->controller->id == 'site' && Yii::$app->controller->action->id == 'login' ||
            Yii::$app->controller->id == 'site' && Yii::$app->controller->action->id == 'error' ||
            Yii::$app->controller->id == 'site' && Yii::$app->controller->action->id == 'logout' ||
            Yii::$app->controller->id == 'financas/atualiza-acao' && Yii::$app->controller->action->id == 'url'
        ) {
            return true;
        }
        /**
         * grupo administrador tem acesso inrestrito
         */
        if (Yii::$app->user->can('admin')) {
            return true;
        }
        /**
         * verifica se o usuário tem acesso a rota
         */
        $pagina = (Yii::$app->controller->id . '/' . Yii::$app->controller->action->id);
        if (Yii::$app->authManager->checkAccess($user->id, $pagina)) {
            return true;
        }
        if ($this->denyCallback !== null) {
            call_user_func($this->denyCallback, null, $action);
        } else {
            if ($pagina != 'default/toolbar') {
                Url::remember([$pagina], 'pagina_after_login');
            }
            $this->denyAccess($user);
        }

        return false;
    }
}
