<?php
/**
 * Este arquivo é parte do
 *    ___       _       _
 *   / __\__ _ (_)_   _(_)
 *  / /  / _` || | | | | |
 * / /__| (_| || | |_| | |
 * \____/\__,_|/ |\__,_|_|
 *           |__/
 *                 Um sistema integrado do IFNMG
 * PHP version 7
 *
 * @author    Christopher Morandi Mota
 * @copyright Copyright (c) 2016, IFNMG
 * @license   http://cajui.ifnmg.edu.br/license/ MIT License
 * @link      http://cajui.ifnmg.edu.br/
 * @since     2.2.0
 */

namespace app\lib\grid;

use Yii;
use yii\base\BaseObject;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * Processa tollbar para grid
 */
class GridToolbar extends BaseObject
{
    public $toolbar;

    /**
     * @var string Html personalizado para o botão create
     */
    public $create;

    /**
     * Executa o widget.
     * @return string O resultado da execução do widget.
     */
    public function init()
    {
        // Toolbar do grid personalizada
        $btnCreate          = $this->getBtnCreate();
        $botaoLimparFiltros = Html::a('<i class="fas fa-redo"></i>', ['index'], ['class' => 'btn btn-default', 'title' => 'Limpar Filtros']);

        if (isset(Yii::$app->controller->actions()['ajuda'])) {
            $botaoAjuda = Html::a('<i class="fas fa-question"></i>', '#', [
                    'class'        => 'loadModal btn btn-default',
                    'title'        => 'Ajuda',
                    'titulo-modal' => '<i class="fas fa-question-circle"></i> Ajuda <small>' . substr(strrchr(Yii::$app->controller->uniqueId, "/"), 1) . '</small>',
                    'value'        => Url::toRoute(['ajuda', 'modulo' => Yii::$app->controller->module->id, 'file' => Yii::$app->controller->id . mb_strtoupper(mb_substr(Yii::$app->controller->action->id, 0, 1)) . mb_substr(Yii::$app->controller->action->id, 1)]),
                    'data-toggle'  => 'modal',
                    'data-target'  => '#modal',
            ]);
        } else {
            $botaoAjuda = null;
        }

        $this->toolbar = [
            'content' => $btnCreate . ' ' . $botaoLimparFiltros,
            '{export}',
            '{toggleData}',
            $botaoAjuda
        ];
    }

    /**
     * @return string Retorna html do botão adicionar
     */
    private function getBtnCreate()
    {
        if (!Yii::$app->user->checkRoute('create')) {
            return '';
        }
        return $this->create ?? Html::a('<i class="fas fa-plus"></i>', ['create'], ['class' => 'btn btn-success', 'title' => 'Adicionar']);
    }

}
