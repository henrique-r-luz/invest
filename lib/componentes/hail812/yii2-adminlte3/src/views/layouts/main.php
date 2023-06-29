<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use kartik\growl\Growl;
use app\assets\AppAsset;
use app\lib\widget\GrowlInvest;

AppAsset::register($this);
\hail812\adminlte3\assets\FontAwesomeAsset::register($this);
\hail812\adminlte3\assets\AdminLteAsset::register($this);
$this->registerCssFile('https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback');

$assetDir = Yii::$app->assetManager->getPublishedUrl('@vendor/almasaeed2010/adminlte/dist');
?>
<!--
 notificação de erro quando é chamado diretamento pelo
 javascript 
 -->
<?php GrowlInvest::widget([
    'type' =>  'danger',
    'title' => '<b>Erro</b>',
    'icon' => 'fa fa-times-circle',
    'nomeTemplate' => 'hash_Grow_invest',
    // 'icon' => (!empty($message['icon'])) ? $message['icon'] : 'fa fa-info',
    'body' => '', //(!empty($message['message'])) ? Html::encode($message['message']) : 'Message Not Set!',
    'showSeparator' => true,
    'delay' => 1, //This delay is how long before the message shows
    'pluginOptions' => [
        'delay' =>  3000000, //This delay is how long the message shows for
        'placement' => [
            'from' =>  'top',
            'align' =>  'right',
        ]
    ]
]); ?>

<!--
 notificação de sucesso quando é chamado diretamento pelo
 javascript 
 -->
<?php GrowlInvest::widget([
    'type' =>  'success',
    'title' => '<b>Sucesso</b>',
    'icon' => 'fa fa-check-circle',
    'nomeTemplate' => 'hash_Grow_invest_sucesso',
    // 'icon' => (!empty($message['icon'])) ? $message['icon'] : 'fa fa-info',
    'body' => '', //(!empty($message['message'])) ? Html::encode($message['message']) : 'Message Not Set!',
    'showSeparator' => true,
    'delay' => 1, //This delay is how long before the message shows
    'pluginOptions' => [
        'delay' =>  3000, //This delay is how long the message shows for
        'placement' => [
            'from' =>  'top',
            'align' =>  'right',
        ]
    ]
]); ?>
<?php foreach (Yii::$app->session->getAllFlashes() as $key => $message) :; ?>

    <?php
    $titulo = '<b>Erro</b>';
    $icon = 'fa fa-times-circle';
    $duracao = 3000000;
    if ($key == 'success') {
        $titulo = '<b>Sucesso</b>';
        $icon = 'fa fa-check-circle';
        $duracao = 3000;
    }
    if ($key == 'warning') {
        $titulo = '<b>Aviso</b>';
        $icon = 'fa fa-check-circle';
        $duracao = 3000;
    }

    echo \kartik\widgets\Growl::widget([
        'type' =>  $key,
        'title' => $titulo,
        'icon' => $icon,
        // 'icon' => (!empty($message['icon'])) ? $message['icon'] : 'fa fa-info',
        'body' => $message, //(!empty($message['message'])) ? Html::encode($message['message']) : 'Message Not Set!',
        'showSeparator' => true,
        'delay' => 1, //This delay is how long before the message shows
        'pluginOptions' => [
            'delay' =>  $duracao, //This delay is how long the message shows for
            'placement' => [
                'from' =>  'top',
                'align' =>  'right',
            ]
        ]
    ]);
    ?>
<?php endforeach; ?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">

<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>

<body class="hold-transition sidebar-mini">
    <?php $this->beginBody() ?>

    <div class="wrapper">
        <!-- Navbar -->
        <?= $this->render('navbar', ['assetDir' => $assetDir]) ?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <?= $this->render('sidebar', ['assetDir' => $assetDir]) ?>

        <!-- Content Wrapper. Contains page content -->
        <?= $this->render('content', ['content' => $content, 'assetDir' => $assetDir]) ?>
        <!-- /.content-wrapper -->

        <!-- Control Sidebar -->
        <?= $this->render('control-sidebar') ?>
        <!-- /.control-sidebar -->

        <!-- Main Footer -->
        <?= $this->render('footer') ?>
    </div>

    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>