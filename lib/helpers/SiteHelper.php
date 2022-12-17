<?php

namespace app\lib\helpers;

use yii\helpers\Url;

class SiteHelper
{

    public static function urlDepoisLogin($controller)
    {
        /*$relember = Url::previous();
        if (isset($relember)) {
            echo $relember . ' ';
            //  exit();
            $url = Url::previous('pagina_after_login');
            echo $url;
            exit();
            return $controller->redirect($relember);
        }*/
        return $controller->redirect('index');
    }
}
