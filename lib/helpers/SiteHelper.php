<?php

namespace app\lib\helpers;

use Yii;
use yii\helpers\Url;

class SiteHelper
{

    public static function urlDepoisLogin($controller)
    {
        $url = Url::previous('pagina_after_login');
        if (isset($url)) {
            return $controller->redirect($url);
        }
        return $controller->redirect('index');
    }
}
