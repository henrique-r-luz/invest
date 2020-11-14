<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Modal;

$this->title = 'Sincroniza Dados';
//\app\assets\AppAsset::register($this);
?>
<div class="box-body">
    <div class="sinc-form">
 
<?php $form = ActiveForm::begin(['action' => ['sincronizar/sincroniza']]); ?> 



        <div class="form-group">
            <?= Html::submitButton('Backup Dados', ['class' => 'btn btn-warning', 'name' => 'but', 'value' => 'backup']) ?>
            <?= Html::submitButton('Cotação Titulo', ['class' => 'btn btn-success', 'name' => 'but', 'value' => 'titulo']) ?>
            <?= Html::submitButton('Empresas da bolsa site Eduardo', ['id' => 'empresa_id', 'class' => 'btn btn-success', 'name' => 'but', 'value' => 'empresa']) ?>
            <?= Html::submitButton('Dados da bolsa site Eduardo', ['id' => 'dados_empresa_id', 'class' => 'btn btn-success', 'name' => 'but', 'value' => 'dados_empresa']) ?>
        </div>

<?php ActiveForm::end(); ?> 
    </div>
</div>

