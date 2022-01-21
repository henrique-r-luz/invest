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

namespace app\lib\grid;

use cajui\assets\CheckboxColumnAsset;
use cajui\lib\dicionarios\Cor;
use Closure;
use yii\bootstrap4\Html;
use yii\helpers\Json;

/**
 * CheckboxColumn displays a column of checkboxes in a grid view.
 *
 * To add a CheckboxColumn to the [[GridView]], add it to the [[GridView::columns|columns]] configuration as follows:
 *
 * ```php
 * 'columns' => [
 *     // ...
 *     [
 *         'class' => 'cajui\lib\grid\CheckboxColumn',
 *         // you may configure additional properties here
 *     ],
 * ]
 * ```
 *
 * Users may click on the checkboxes to select rows of the grid. The selected rows may be
 * obtained by calling the following JavaScript code:
 *
 * ```javascript
 * var keys = $('#grid').yiiGridView('getSelectedRows');
 * // keys is an array consisting of the keys associated with the selected rows
 * ```
 *
 * @author Christopher Morandi Mota
 * @since  3.0.0
 */
class CheckboxColumn extends \yii\grid\CheckboxColumn
{
    /**
     * Opçoes de cor em "cajui\lib\dicionarios\Cor"
     * @var string Cor do checkbox. Default
     */
    public $cor = Cor::TYPE_PRIMARY;

    /**
     * {@inheritdoc}
     */
    protected function renderDataCellContent($model, $key, $index)
    {
        if ($this->content !== null) {
            return parent::renderDataCellContent($model, $key, $index);
        }

        if ($this->checkboxOptions instanceof Closure) {
            $options = call_user_func($this->checkboxOptions, $model, $key, $index, $this);
        } else {
            $options = $this->checkboxOptions;
        }

        if (!isset($options['value'])) {
            $options['value'] = is_array($key) ? Json::encode($key) : $key;
        }

        if ($this->cssClass !== null) {
            Html::addCssClass($options, $this->cssClass);
        }

        $checkbox = Html::checkbox($this->name, !empty($options['checked']), $options);

        return Html::tag('div', $checkbox, ['class' => 'icheck-' . $this->cor]);
    }

    /**
     * Renders the header cell content.
     * The default implementation simply renders [[header]].
     * This method may be overridden to customize the rendering of the header cell.
     * @return string the rendering result
     */
    protected function renderHeaderCellContent()
    {
        if ($this->header !== null || !$this->multiple) {
            return parent::renderHeaderCellContent();
        }

        $checkbox = Html::checkbox($this->getHeaderCheckBoxName(), false, ['class' => 'select-check-all']);

        return Html::tag('div', $checkbox, ['class' => 'icheck-' . $this->cor]);
    }

    /**
     * Registers the needed JavaScript.
     */
    public function registerClientScript()
    {
        CheckboxColumnAsset::register($this->grid->getView());
        $id = $this->grid->options['id'];
        $options = Json::encode([
                'name' => $this->name,
                'class' => $this->cssClass,
                'multiple' => $this->multiple,
                'checkAll' => $this->grid->showHeader ? $this->getHeaderCheckBoxName() : null,
        ]);
        $this->grid->getView()->registerJs("cajuiSelectColumn('{$id}', {$options});");
    }
}
