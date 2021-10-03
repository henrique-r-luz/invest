<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models\relatorios;

/**
 * Description of FiltroDataRelatorio
 *
 * @author henrique
 */
class FiltroDataRelatorio extends \yii\base\Model {
    
    public $dataInicio;
    public $dataFim;
    
     public function rules() {
        return [
            [['dataInicio','dataFim'], 'required'],
            [['dataInicio','dataFim'], 'date'],
          
        ];
    }
    
     public function attributeLabels() {
        return [
            'dataInicio' => 'Data inicial',
            'dataFim' => 'Data Final',
            
        ];
    }
    
    //put your code here
}
