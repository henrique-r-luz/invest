<?php

use yii\helpers\Url;
use yii\helpers\Html;

$skin  = (YII_ENV_DEV) ? 'navbar-lightblue' : 'navbar-success';
$user = '';
if(!empty(Yii::$app->user->id)){
    $user = Yii::$app->user->identity->username; 
}
?>
<!-- Navbar -->
<nav class="main-header navbar navbar-dark <?= $skin ?> navbar-expand" style="z-index: 1031;">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Navbar Search -->
        <!-- Messages Dropdown Menu -->
        <!-- Notifications Dropdown Menu -->
        <li class="nav-item">
            <?= Html::a('<i class="fas fa-user-lock"></i> '.$user, Url::toRoute(['site/logout']), ['class' => "nav-link"]) ?>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>

        </li>
    </ul>
</nav>
<!-- /.navbar -->