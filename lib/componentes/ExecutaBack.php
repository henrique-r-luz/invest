<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\lib\componentes;

use toriphes\console\Runner;
use Yii;

/**
 * Description of ExecutaBack
 *
 * @author henrique
 */
class ExecutaBack extends Runner {
    
    
    protected function buildCommand($cmd)
    {
        return $this->getPHPExecutable() . ' ' . Yii::getAlias($this->yiiscript) . ' ' . $cmd . ' >/dev/null 2>&1 &';
    }
    //put your code here
}
