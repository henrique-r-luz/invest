<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;

/* @var $this \yii\web\View */
/* @var $content string */


?>
<div class="login-box">
    <?php $form = ActiveForm::begin([]); ?>
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">Faça o seu login</p>
            <div class="row">
                <div class="col-12">
                    <?= $form->field($model, 'username')->textInput(['placeholder' => 'Usuário', 'autofocus' => true])->label(false) ?>
                </div>
                <div class="col-12">
                    <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Senha'])->label(false) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <?= Html::a('Limpar', ['login'], ['class' => 'btn btn-default btn-block']) ?>
                </div>
                <div class="col-6">
                    <?= Html::submitButton('Acessar', ['class' => 'btn btn-primary btn-block', 'name' => 'login-button']) ?>
                </div>

            </div>

        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>