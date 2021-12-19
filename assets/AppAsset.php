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
        'css/site.css',
        // 'css/all.css',
        "js/grow-js/jquery.growl.css",
        "dist/css/adminlte.min.css",
        //'plugins/fontawesome-free/css/all.min.css',
        //'plugins/icheck-bootstrap/icheck-bootstrap.min.css',
    ];
    public $js = [
        //"/usr/local/bin/node-server/node_modules/socket.io-client/dist/socket.io.js",
        "js/node_modules/socket.io-client/dist/socket.io.js",
        "js/notificacao.js",
        "js/grow-js/jquery.growl.js",
        "js/investimento.js",
        // "js/demo.js"
        // 'js/all.js',

    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        //'rmrevin\yii\fontawesome\cdn'
        // '@vendro\rmrevin\yii\fontawesome\AssetBundle',
        //'yii\fontawesome\CdnProAssetBundle',
    ];
}
