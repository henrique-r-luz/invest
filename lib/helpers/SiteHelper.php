<?php

namespace app\lib\helpers;

use Yii;
use yii\helpers\Url;

class SiteHelper
{

    public static function urlDepoisLogin($controller)
    {
        $relember = Url::previous();
        if (isset($relember)) {
            $url = Url::previous('pagina_after_login');
            return $controller->redirect($url);
        }

        return $controller->redirect('index');
    }
}
