<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models\relatorios;

/**
 * Description of FiltroEmpresa
 *
 * @author henrique
 */
class FiltroEmpresa extends \yii\base\Model {
    //put your code here
    //id do filtro 
    public $id;
    
  
    
     public function rules()
    {
        return [
            [['id'], 'required'],
           
            
        ];
    }

    public function attributeLabels()
    {
        return [
            'id'    => 'Filtra Empresas',
           
            ];
    }

    public function attributeComments()
    {
        return [
              'id'    => 'Filtro',
                
        ];
    }
}
