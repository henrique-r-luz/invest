<?php
/* @var $this yii\web\View */
use app\assets\AppAsset;
use yii\widgets\Pjax;


AppAsset::register($this);  
$this->title = 'Recebe';
$this->registerJs(
    "var socket = io('http://192.168.200.10:3001');
    socket.on('new_order', function (data) {
        console.log(data);
         $.pjax.reload({container:'#containerPjax'}); 
        //socket.emit('my other event', {my: 'data'});
    });"
);

?>

<?php Pjax::begin(['id' => 'containerPjax', 'enablePushState'=>false]);?>

        <h3><?= $now ?></h3>

        <?php  Pjax::end(); ?>

