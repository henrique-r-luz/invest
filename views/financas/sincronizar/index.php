<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\helpers\Url;
use yii\helpers\Html;
use app\assets\AppAsset;
use yii\bootstrap\Modal;
use yii\widgets\ActiveForm;
use yii\bootstrap\Progress;


$this->title = 'Sincroniza Dados';
$this->registerJsFile(
    '@web/js/sincroniza/carregaBotAcoes.js',
    ['depends' => [yii\web\YiiAsset::class,
                  yii\bootstrap\BootstrapAsset::class]
    ]);

?>
<div class="box-body">
    <div class="sinc-form">
 
<?php $form = ActiveForm::begin(['action' => [Url::to('sincroniza')]]); ?> 



        <div class="form-group">
            <?= Html::submitButton('Backup Dados', ['class' => 'btn btn-warning', 'name' => 'but', 'value' => 'backup']) ?>
            <?= Html::submitButton('Atualiza Dados', ['class' => 'btn btn-info', 'name' => 'but', 'value' => 'atualiza_dados']) ?>
            <?= Html::Button('Atualiza ações', ['id' => 'acoes_id', 'class' => 'btn btn-success','onclik'=>'alert("olaa");']) ?>
        </div>

<?php ActiveForm::end(); ?> 

    </div>
</div>

<?php
    Modal::begin([
        'header'        => '<h5 class = "card-title" id="progress"></h5>',
        'id'            => 'progress-modal',
        'closeButton'   => false,
        'clientOptions' => ['backdrop' => 'static', 'keyboard' => false]]);
    ?>

    <?=
    Progress::widget([
        'percent' => 0,
        'options' => ['class' => 'progress-success active progress-striped']
    ]);
    ?>

    <?php Modal::end(); ?>

