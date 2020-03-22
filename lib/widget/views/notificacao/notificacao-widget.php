


<?php

use yii\helpers\Html;

$html = Html::beginTag('li', ['class' => 'dropdown notifications-menu']);
$html .= Html::beginTag('a', ['href' => '#', 'class' => 'dropdown-toggle', 'data-toggle' => 'dropdown']);
$html .= Html::tag('i', '', ['class' => 'fa fa-bell-o']);
$html .= Html::tag('span', $dataProvider->getCount(), ['class' => 'label label-warning']);
$html .= Html::endTag('a');
$html .= Html::beginTag('ul', ['class' => 'dropdown-menu']);
$html .= Html::tag('li', '<b>Você tem '.$dataProvider->getCount().' notificações</b>', ['class' => 'header']);
$html .= Html::beginTag('li');
$html .= Html::beginTag('ul', ['class' => 'menu']);
foreach ($dataProvider->getModels() as $notificacao){
   $html .= aviso($notificacao['dados']);
}
$html .= Html::endTag('ul');
$html .= Html::endTag('li');
$html .= Html::beginTag('li',['class'=>'footer meu-footers']);
$html .= Html::tag('a','Ver Todos',['href' => 'index.php/notificacao']);
$html .= Html::endTag('li');
$html .= Html::endTag('ul');
$html .= Html::endTag('li');
echo $html;

//echo $html;
//text-red
//text-aqua
function aviso($dados) {
    $obj = Html::beginTag('li');
    $obj .= Html::beginTag('a', ['href' => '#']);
    if($dados['ok']==true){
        $class = 'fa fa-thumbs-o-up text-red';
    }else{
        $class = 'fa-thumbs-o-down text-red';
    }
    $obj .= Html::tag('i', '', ['class' => 'fa fa-thumbs-o-up text-red']);
    $obj .= $dados['titulo'];
    $obj .= Html::endTag('a');
    $obj .= Html::endTag('li');
    return $obj;
}
?>        
