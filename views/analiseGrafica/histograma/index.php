<?php

use app\lib\Atributos;
use app\lib\dicionario\Tempo;
use app\models\financas\AcaoBolsa;
use kartik\widgets\Select2;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this View */
/* @var $searchModel app\models\OperacaoSearch */
/* @var $dataProvider ActiveDataProvider */

$this->title = 'Histograma';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="index">


    <div class = "search">

        <?php
        $form = ActiveForm::begin([
                    'action' => ['/histograma'],
                    'method' => 'post',
        ]);
        ?>
        <div class="box-success box">
            <div class="box-body">
                <div class="col-xs-12 col-lg-12 no-padding">
                    <div class="col-xs-12 col-sm-12 col-lg-12">
                        <?=
                        $form->field($model, 'empresas')->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(AcaoBolsa::find()
                                            ->innerJoin('balanco_empresa_bolsa', 'balanco_empresa_bolsa.codigo=acao_bolsa.codigo')
                                            ->asArray()->all(), 'codigo', 'codigo'),
                            'options' => ['placeholder' => 'Selecione as empresas'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                            'options' => [
                                'multiple' => true,
                            ],
                        ]);
                        ?>
                    </div>
                </div>
                <div class="col-xs-12 col-lg-12 no-padding">
                    <div class="col-xs-4 col-sm-4 col-lg-4">
                        <?=
                        $form->field($model, 'atributo')->widget(Select2::classname(), [
                            //'data' => ArrayHelper::map(Tipo::find()->asArray()->all(), 'id', 'nome'),
                            'data' => Atributos::all(),
                            'options' => ['placeholder' => 'escolha um atributo'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);
                        ?>
                    </div>
                    <div class="col-xs-4 col-sm-4 col-lg-4">
<?=
$form->field($model, 'numeroClasse')->textInput()
?>
                    </div>

                    <div class="col-xs-4 col-sm-4 col-lg-4">
                        <?=
                        $form->field($model, 'tempo')->widget(Select2::classname(), [
                            //'data' => ArrayHelper::map(Tipo::find()->asArray()->all(), 'id', 'nome'),
                            'data' => Tempo::all(),
                            'options' => ['placeholder' => 'Tempo'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);
                        ?>
                    </div>
                </div>
                <div class="col-xs-12 col-lg-12 ">
                    <div class="form-group">
        <?= Html::submitButton('Gráfico', ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Limpar', ['/histograma'], ['class' => 'btn btn-default']) ?>
                    </div>
                </div>
            </div>
        </div>
        <?php if (!empty($histogramaClasse)): ?>
            <?= $this->render('_grafico',['labelClasse'=>$labelClasse,
                    'histogramaClasse'=>$histogramaClasse,
                'model'=>$model]); ?>
        <?php endif; ?>

    </div>    
<?php ActiveForm::end(); ?>

</div>
</div>    


