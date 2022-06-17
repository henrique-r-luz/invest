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
 * @copyright Copyright (c) 2016, IFNMG
 * @license   http://cajui.ifnmg.edu.br/license/ MIT License
 * @link      http://cajui.ifnmg.edu.br/
 * @author    Christopher Mota
 * @since     1.0.0
 */

namespace app\lib\grid;

use Yii;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * Description of GridView
 *
 * @author Wesley Oliveira
 *
 * @property-read string $btnRedo
 * @property-read string $btnCreate
 */
class GridView extends \kartik\grid\GridView
{
    /**
     * @var string Estipo aparencia do card. Valor padrão 'card-secondary card-outline'
     */
    public string $cardStyle = 'card-secondary card-outline';

    /**
     * @var string título do card que contem o grid.
     */
    public  $boxTitle;

    /**
     * @var string Header do card-body que contem o grid.
     */
    public $bodyHeader;

    /**
     * @var array the HTML attributes for the summary of the list view.
     * The "tag" element specifies the tag name of the summary element and defaults to "div".
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $summaryOptions = ['class' => 'summary float-left'];

    /**
     * @var string[]
     */
    public $filterErrorOptions = ['class' => 'form-text invalid-feedback-filter'];

    /**
     * @var array the configuration for the pager widget. By default, [[LinkPager]] will be
     * used to render the pager. You can use a different widget class by configuring the "class" element.
     * Note that the widget must support the `pagination` property which will be populated with the
     * [[\yii\data\BaseDataProvider::pagination|pagination]] value of the [[dataProvider]] and will overwrite this value.
     */
    public $pager = ['options' => ['class' => 'pagination pagination-sm m-0 float-right']];

    /**
     * @var array|string the toolbar content configuration.
     */
    public $toolbar = 'padraoCajui';

    /**
     * Barra de ferramentas que aparece no final do grid
     */
    public $toolbarFooter = '';

    /**
     * @var string Html personalizado para o botão create quando toolbar é 'padrãoCajui'.
     */
    public  $create;

    /**
     * @var string Html personalizado para o botão redo quando toolbar é 'padrãoCajui'.
     */
    public string $redo;
    public bool $footer = true;
    public $responsiveWrap = false;
    public $hover = true;
    public $condensed = true;
    public $striped = false;

    /** @var int|bool tamanho da paginação. Padrão 10. Use "false" para não utilizar paginação */
    public $pagination = 10;

    /**
     * {@inheritdoc}
     */
    public function init(): void
    {
        $this->layout = '
            <div class="card ' . $this->cardStyle . '">
              <div class="card-header" style="padding-left: 10px;">
                  <h3 class="card-title">
                      <i class="fas fa-search"></i>
                      Lista de ' . $this->boxTitle . '
                  </h3>
                  <div class="card-tools">
                      {toolbar}
                  </div>
              </div>
              <div class="card-body" style="padding: 0">
                <div class="card-body-header">
                    ' . ($this->bodyHeader ? $this->bodyHeader : '') . '
                </div>
                {items}
              </div>'
            . $this->toolbarFooter .
            '<div class="card-footer clearfix">
                ' . ($this->footer ? '{summary}' : '') . '
                {pager}
              </div>
              <div class="overlay loading" style="display: none;">
                  <i class="spinner-border text-success"></i>
              </div>
            </div>';

        $this->initToolBar();


        if ($this->dataProvider->getPagination() !== false) {
            $this->dataProvider->pagination->defaultPageSize = $this->pagination;
        }

        parent::init();
    }


    /**
     * Creates column objects and initializes them.
     */
    protected function initToolBar(): void
    {
        if ($this->toolbar === 'padraoCajui') {
            // Toolbar do grid personalizada
            $botaoAdicionar = $this->getBtnCreate();
            $botaoRedo = $this->getBtnRedo();

            if (isset(Yii::$app->controller->actions()['ajuda'])) {
                $botaoAjuda = Html::a('<i class="fas fa-question"></i>', '#', [
                    'class' => 'loadModal btn btn-outline-secondary',
                    'title' => 'Ajuda',
                    'titulo-modal' => '<i class="fas fa-question-circle"></i> Ajuda <small>' . substr(strrchr(Yii::$app->controller->uniqueId, '/'), 1) . '</small>',
                    'value' => Url::toRoute(['ajuda', 'modulo' => Yii::$app->controller->module->id, 'file' => Yii::$app->controller->id . mb_strtoupper(mb_substr(Yii::$app->controller->action->id, 0, 1)) . mb_substr(Yii::$app->controller->action->id, 1)]),
                    'data-toggle' => 'modal',
                    'data-target' => '#modal',
                    'data-pjax' => 0,
                ]);
            } else {
                $botaoAjuda = null;
            }

            $this->toolbar = [
                'content' => '<div class="btn-group">' . $botaoAdicionar . $botaoRedo . $botaoAjuda . '</div>',
                '{toggleData}',
                '{export}',
            ];
        }
        if ($this->toolbar === 'precoCajui') {
            $this->toolbar = $this->toolbarPreco();
        }
    }

    protected function toolbarPreco(){
        return [
            'content' => '<div class="btn-group">' . $this->getBtnRedo()  . '</div>',
            '{toggleData}',
            '{export}',
        ];
    }

    /**
     * @return string Retorna html do botão adicionar
     */
    protected function getBtnCreate(): string
    {
        //if (!Yii::$app->user->checkRoute('create')) {
        //    return '';
       // }
        return $this->create ?? Html::a('<i class="fas fa-plus"></i>', ['create'], ['class' => 'btn btn-success but-add-registro', 'title' => 'Adicionar', 'data-pjax' => 0]);
    }

    /**
     * @return string Retorna html do botão limpar filtros
     */
    protected function getBtnRedo(): string
    {
        return $this->redo ?? Html::a('<i class="fas fa-redo"></i>', ['index'], ['class' => 'btn btn-outline-secondary', 'title' => 'Limpar Filtros', 'data-pjax' => 0]);
    }
}
