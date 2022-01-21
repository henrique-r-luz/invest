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

use kartik\date\DatePicker;
use kartik\grid\DataColumn;
use kartik\grid\GridView;

/**
 * Extends the Yii's DataColumn for the Grid widget [[\kartik\widgets\GridView]]
 *
 * @author Christopher Mota
 * @since  3.0.0
 */
class DateColumn extends DataColumn {

    /**
     * @var string the width of each column (matches the CSS width property).
     * Defaults to `70px`.
     */
    public $width = '70px';
    public $format = ['date','php:d/m/Y'];
    public $filterType = GridView::FILTER_DATE;
    public $filterWidgetOptions = [
        'type' => DatePicker::TYPE_INPUT,
        'options' => ['autocomplete' => 'off'],
        'pluginOptions' => ['autoclose' => true,],
    ];

}
