<?php

/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        "js/grow-js/jquery.growl.css",
    ];
    public $js = [
        "js/grow-js/jquery.growl.js",
        "js/gridView/gridView.js",
        "js/gridView/bootstrap-notify.js",
        "js/operacao/tipoMoeda.js"

    ];

    public $publishOptions = [
        'forceCopy' => YII_ENV_DEV,
    ];
}
