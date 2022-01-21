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

use Closure;
use kartik\grid\DataColumn;
use PhpParser\Node\Expr\Closure as Closure2;

/**
 * A BooleanColumn to convert true/false values as user friendly indicators
 * with an automated drop down filter for the Grid widget [[\kartik\widgets\GridView]]
 *
 * @author Robert Cristiano
 * @since
 */
class RepercursoColumn extends DataColumn
{

    /**
     * @var string the horizontal alignment of each column. Should be one of
     * 'left', 'right', or 'center'. Defaults to `center`.
     */
    public $hAlign = 'center';

    /**
     * @var string the width of each column (matches the CSS width property).
     * Defaults to `110px`.
     * @see http://www.w3schools.com/cssref/pr_dim_width.asp
     */
    public $width = '110px';

    /**
     * @var string|array in which format should the value of each data model be displayed
     * Defaults to `html`.
     */
    public $format = 'html';

    /**
     * @var boolean|string|Closure2 the page summary that is displayed above the footer.
     * Defaults to false.
     */
    public $pageSummary = false;

    /**
     * @var string label for the true value. Defaults to `t`.
     */
    public $trueLabel;

    /**
     * @var string label for the false value. Defaults to `f`.
     */
    public $falseLabel;

    /**
     * @var string icon/indicator for the true value. If this is not set, it will use the value from `trueLabel`.
     */
    public $trueDataCel;

    /**
     * @var string icon/indicator for the false value. If this is null, it will use the value from `falseLabel`.
     * '<span class="fas fa-times text-success"></span>'
     */
    public $falseDataCel;

    /**
     * @var bool whether to show null value as a false icon.
     */
    public $showNullAsFalse = false;

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        if (empty($this->trueLabel)) {
            $this->trueLabel = 'Sim';
        }
        if (empty($this->falseLabel)) {
            $this->falseLabel = 'Não';
        }

        $this->filter = ['0' => $this->falseLabel, '1' => $this->trueLabel];

        if (empty($this->trueDataCel)) {
            $this->trueDataCel = $this->trueLabel;
        }

        if (empty($this->falseDataCel)) {
            $this->falseDataCel = $this->falseLabel;
        }

        parent::init();
    }

    /**
     * {@inheritdoc}
     */
    public function getDataCellValue($model, $key, $index)
    {
        $value = parent::getDataCellValue($model, $key, $index);
        if ($this->value instanceof Closure) {
            return $value;
        } elseif ($value !== null) {
            return $value ? $this->trueDataCel : $this->falseDataCel;
        }
        return $this->showNullAsFalse ? $this->falseDataCel : $value;
    }
}
