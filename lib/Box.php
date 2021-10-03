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
 */

namespace app\lib;

use yii\bootstrap\ButtonGroup;
use yii\bootstrap\Widget;
use yii\helpers\Html;

/**
 * Classe Box
 *
 * @example
 * <?php
 *   Box::begin([
 *      'type'=>Box::TYPE_SUCCESS,
 *      'tooltip'=>'Caixa estilo adminLte',
 *      'title'=>'Título',
 *      'footer'=>'Rodapé'
 *   ]);
 * ?>
 *    Conteúdo da caixa
 * <?php
 *   Box::end();
 * ?>
 *
 * Também suporte
 * <?= Box::widget([
 *      'type'=>Box::TYPE_SUCCESS,
 *      'tooltip'=>'Caixa estilo adminLte',
 *      'title'=>'Título',
 *      'body'=>'Conteúdo da caixa',
 *      'footer'=>'Rodapé'
 * ])?>
 *
 * @author Christopher Morandi Mota
 * @since 1.0.0
 */
class Box extends Widget
{
    const TYPE_INFO    = 'info';
    const TYPE_PRIMARY = 'primary';
    const TYPE_SUCCESS = 'success';
    const TYPE_DEFAULT = 'default';
    const TYPE_DANGER  = 'danger';
    const TYPE_WARNING = 'warning';

    /**
     * @var string $type estilo de cor do widget. Valor padrão de "default(cinza)".
     */
    public $type = self::TYPE_DEFAULT;

    /**
     * @var boolean $isTile true para o box com background.
     */
    public $isTile = false;

    /**
     * @var boolean $isSolid true for solid box header.
     */
    public $isSolid = false;

    /**
     * @var boolean $withBorder add border after box header
     */
    public $withBorder = false;

    /**
     * @var string $tooltip box tooltip.
     */
    public $tooltip = '';

    /**
     * @var string $tooltip Posições: top, bottom, left or right
     */
    public $tooltipPlacement = 'bottom';

    /**
     * @var string $title *
     */
    public $title = '';

    /**
     * @var string
     */
    public $body = '';

    /**
     * @var array|string
     */
    public $boxTools;

    /**
     * @var string $footer *
     */
    public $footer = '';

    /**
     * @var string $footer *
     */
    public $footerOptions = '';

    /**
     * @var boolean $loading Indica se incone de loading é para estar presente.
     */
    public $loading = false;

    /**
     * @var string
     */
    public $topTemplate = <<<HTML
<div {options}>
<div {headerOptions}><h3 class="box-title">{title}</h3>{box-tools}</div>
<div class="box-body">
HTML;

    /**
     * @var string
     */
    public $bottomTemplate = <<<HTML
</div>
<div class="box-footer {footerOptions}">{footer}</div>
</div>
HTML;

    /**
     * @var string
     */
    public $loadingTemplate = <<<HTML
<div class="overlay loading" style="display: none;">
    <i class="fa fa-refresh fa-spin"></i>
</div>
HTML;

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        Html::addCssClass($this->options, 'box');
        if (!$this->isTile) {
            Html::addCssClass($this->options, 'box-' . $this->type);
        } else {
            Html::addCssClass($this->options, 'bg-' . $this->type);
        }
        if ($this->isSolid || $this->isTile) {
            Html::addCssClass($this->options, 'box-solid');
        }
        echo strtr($this->topTemplate, [
            '{options}'       => Html::renderTagAttributes($this->options),
            '{headerOptions}' => Html::renderTagAttributes($this->prepareHeaderOptions()),
            '{title}'         => $this->title,
            '{box-tools}'     => $this->prepareBoxTools(),
            ]
        ) . $this->body;
    }

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        if ($this->footer) {
            return strtr(
                $this->bottomTemplate, [
                '{footer}'        => $this->footer . ($this->loading ? $this->loadingTemplate : ''),
                '{footerOptions}' => $this->isTile ? 'bg-' . $this->type : $this->footerOptions,
                ]
            );
        } else {
            return '</div>' . ($this->loading ? $this->loadingTemplate : '') . '</div>';
        }
    }

    /**
     * @return array
     */
    protected function prepareHeaderOptions()
    {
        $headerOptions = ['class' => 'box-header'];
        if ($this->withBorder) {
            Html::addCssClass($headerOptions, 'with-border');
        }
        if ($this->tooltip) {
            $headerOptions = array_merge(
                $headerOptions, [
                'data-toggle'         => 'tooltip',
                'data-original-title' => $this->tooltip,
                'data-placement'      => $this->tooltipPlacement ?: 'bottom',
                ]
            );
        }
        return $headerOptions;
    }

    /**
     * @return string
     */
    protected function prepareBoxTools()
    {
        $boxTools = '';
        if (!empty($this->boxTools)) {
            if (is_array($this->boxTools)) {
                $boxTools = ButtonGroup::widget([
                        'buttons'      => $this->boxTools,
                        'encodeLabels' => false,
                ]);
            } else {
                $boxTools = $this->boxTools;
            }
        }
        return $boxTools ? Html::tag('div', $boxTools, ['class' => 'box-tools pull-right']) : '';
    }

}
