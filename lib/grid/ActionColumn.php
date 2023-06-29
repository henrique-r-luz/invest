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

use Yii;
use yii\bootstrap4\Button;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * Extends the Yii's ActionColumn for the Grid widget [[\kartik\widgets\GridView]]
 * with various enhancements.
 *
 * ActionColumn is a column for the [[GridView]] widget that displays buttons
 * for viewing and manipulating the items.
 *
 * @author Christopher Morandi Mota
 * @since  1.0.0
 */
class ActionColumn extends \kartik\grid\ActionColumn
{
    /**
     * @var string the width of each column (matches the CSS width property).
     * @see http://www.w3schools.com/cssref/pr_dim_width.asp
     */
    public $width = '10%';

    /**
     * {@inheritdoc}
     */
    public function init(): void
    {
        $this->template = $this->filterActionColumn($this->template);
        parent::init();
    }

    /**
     * Filter action column button. Use with [[yii\grid\GridView]]
     * @param array|string $buttons
     * @return string
     */
    protected function filterActionColumn($buttons = [])
    {
        return $buttons;
    }

    /**
     * Sets a default button configuration based on the button name (bit different than [[initDefaultButton]] method)
     *
     * @param string $name button name as written in the [[template]]
     * @param string $title the title of the button
     * @param string $icon the meaningful glyphicon suffix name for the button
     */
    protected function setDefaultButton($name, $title, $icon)
    {
        /*if (isset($this->buttons[$name])) {
            return;
        }*/
        $this->buttons[$name] = function ($url, $model, $key) use ($name, $title, $icon) {
            $opts = "{$name}Options";
            $options = ['title' => $title, 'aria-label' => $title, 'data-pjax' => 0];
            if ($name === 'delete') {
                $options = ['title' => $title, 'aria-label' => $title, 'data-pjax' => 1];
                $options['onClick'] = "grid.delete('" . $url . "')";
                $url = '#';
            }
            $options = array_replace_recursive($options, $this->buttonOptions, $this->$opts);
            $label = ArrayHelper::remove($options, 'label', $icon);
            return Html::a($label, $url, $options);
        };
    }

    /**
     * @inheritdoc
     */
    protected function initDefaultButtons(): void
    {
        $this->setDefaultButton('view', 'Visualizar', '<button type="button" class="btn btn-default btn-xs" style="margin-top: 1px"><i class="fas fa-eye"></i></button>');
        $this->setDefaultButton('update', 'Editar', '<button type="button" class="btn btn-primary btn-xs" style="margin-top: 1px"><i class="fas fa-pencil-alt"> </i> </button>');
        $this->setDefaultButton('delete', 'Excluir', '<button type="button" class="btn btn-danger btn-xs" style="margin-top: 1px"><i class="fas fa-trash-alt"> </i> </button>');
    }
}
