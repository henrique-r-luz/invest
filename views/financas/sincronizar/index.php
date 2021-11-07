<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->title = 'Sincroniza Dados';
//\app\assets\AppAsset::register($this);
?>
<div class="box-body">
    <div class="sinc-form">
 
<?php $form = ActiveForm::begin(['action' => [Url::to('sincroniza')]]); ?> 



        <div class="form-group">
            <?= Html::submitButton('Backup Dados', ['class' => 'btn btn-warning', 'name' => 'but', 'value' => 'backup']) ?>
            <?= Html::submitButton('Atualiza Dados', ['class' => 'btn btn-info', 'name' => 'but', 'value' => 'atualiza_dados']) ?>
            <?= Html::submitButton('Atualiza ações', ['id' => 'acoes_id', 'class' => 'btn btn-success', 'name' => 'but', 'value' => 'acoes']) ?>
        </div>

<?php ActiveForm::end(); ?> 
    </div>
</div>

