<?php

use yii\helpers\Html;
use app\lib\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\admin\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

        <?php // echo $this->render('_search', ['model' => $searchModel]); 
        ?>

        <?= GridView::widget([
                'toolbar' => 'padraoCajui',
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'boxTitle' => 'Usuários',
                'columns' => [

                        [
                                'attribute' => 'id',
                                'options' => ['style' => 'width:5%;']
                        ],
                        'username',
                        [
                                'attribute'=>'grupo',
                                'value'=>function($model){
                                        foreach($model->authAssignment as $id=>$item){
                                                $grupo = '';
                                                if($id==0){
                                                   $grupo.=$item->item_name;
                                                }else{
                                                        $grupo.=', '.$item->item_name;
                                                }
                                                return $grupo;
                                        }
                                        //return $model->authAssignment->item_name;
                                }
                        ],
                        //'authAssignment.iten_name',

                        ['class' => 'app\lib\grid\ActionColumn'],
                ],
        ]); ?>


</div>