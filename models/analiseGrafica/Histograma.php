<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models\analiseGrafica;

/**
 * Description of Histograma
 *
 * @author henrique
 */
class Histograma extends \yii\base\Model {
    
    public $atributo;
    public $numeroClasse;
    public $empresas;
    public $tempo;
    
       public function rules()
    {
        return [
            [['numeroClasse','atributo','tempo'], 'required'],
            [['empresas'],'safe'],
            [['numeroClasse'],'integer'],
           
            
        ];
    }

    public function attributeLabels()
    {
        return [
            'atributo'    => 'Atributo',
            'numeroClasse' => 'Classes',
            'empresas'=>'Empresas',
            'tempo'=>'Tempo'
            ];
    }

    public function attributeComments()
    {
         return [
            'atributo'    => 'Atributo',
            'numeroClasse' => 'Classes',
            'empresas'=>'Empresas',
            'tempo'=>'Tempo'
            ];
    }
    
}
