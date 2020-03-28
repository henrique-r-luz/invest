<?php

use yii\helpers\Html;
use app\lib\widget\NotificacaoWidget;
use yii\widgets\Pjax;

/*
 * utiliza o node js para informar ao usuário que uam nova notificação foi criada
 */
$this->registerJs(
        "var socket = io('" . \Yii::$app->params['serverNode'] . "');
    socket.on('new_order', function (data) {
        setTimeout(atualiza,1000);
        console.log(data);
       

        $.growl.notifica({message:'Você tem uma nova notificação'});



        function atualiza(){
           $.pjax.reload({container:'#containerPusherNodejs'}); 
        }
        //socket.emit('my other event', {my: 'data'});
    });");
/* @var $this \yii\web\View */
/* @var $content string */
?>

<header class="main-header">

<?= Html::a('<span class="logo-mini">APP</span><span class="logo-lg">' . Yii::$app->name . '</span>', Yii::$app->homeUrl, ['class' => 'logo']) ?>

    <nav class="navbar navbar-static-top" role="navigation">

        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
<?php Pjax::begin(['id' => 'containerPusherNodejs', 'enablePushState' => false]); ?>
        <div class="navbar-custom-menu">

            <ul class="nav navbar-nav">

                <div class="navbar-custom-menu">

                    <ul class="nav navbar-nav">


<?= NotificacaoWidget::widget() ?>


                        <!-- Tasks: style can be found in dropdown.less -->



                        <!-- User Account: style can be found in dropdown.less -->

                        <li class="dropdown user user-menu">

                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header">
                                    <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle"
                                         alt="User Image"/>

                                    <p>
                                        Alexander Pierce - Web Developer
                                        <small>Member since Nov. 2012</small>
                                    </p>
                                </li>
                                <!-- Menu Body -->
                                <li class="user-body">
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Followers</a>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Sales</a>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Friends</a>
                                    </div>
                                </li>
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <a href="#" class="btn btn-default btn-flat">Profile</a>
                                    </div>
                                    <div class="pull-right">
                                        <?=
                                        Html::a(
                                                'Sign out', ['/site/logout'], ['data-method' => 'post', 'class' => 'btn btn-default btn-flat']
                                        )
                                        ?>
                                    </div>
                                </li>
                            </ul>
                        </li>

                        <!-- User Account: style can be found in dropdown.less -->
                        <li>
                            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                        </li>
                    </ul>
                </div>
<?php Pjax::end(); ?>
                </nav>
                </header>
