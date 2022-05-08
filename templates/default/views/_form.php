<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

/* @var $model \yii\db\ActiveRecord */

$model = new $generator->modelClass();
$safeAttributes = $model->safeAttributes();
if (empty($safeAttributes)) {
    $safeAttributes = $model->attributes();
}

echo "<?php\n";
?>

use yii\helpers\Html;
use kartik\form\ActiveForm;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */
/* @var $form kartik\form\ActiveForm */
?>

<div class="<?= $model->isNewRecord ? 'card-success' : 'card-info' ?> card card-outline">
    <div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-form">
        <div class="card-body">
            <?= "<?php " ?>$form = ActiveForm::begin(); ?>

            <?php
            foreach ($generator->getColumnNames() as $attribute) {
                if (in_array($attribute, $safeAttributes)) {
                    echo "    <?= " . $generator->generateActiveField($attribute) . " ?>\n\n";
                }
            }
            ?>
        </div>
        <div class="card-footer">
            <?= "<?= " ?>Html::submitButton(<?= $generator->generateString('Save') ?>, ['class' => 'btn btn-success']) ?>
            <?= "<?= " ?>Html::a(<?= $generator->generateString('Voltar') ?>,['index'], ['class' => 'btn btn-default']) ?>
        </div>
        <?= "<?php " ?>ActiveForm::end(); ?>
    </div>
</div>
</div>