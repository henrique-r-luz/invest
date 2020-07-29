<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models;

/**
 * Description of FiltroEmpresa
 *
 * @author henrique
 */
class FiltroEmpresaDados extends \yii\base\Model {
    //put your code here
    //id do filtro 
    
    public $cnpj;
    public $codigo;
    public $nome;
    public $setor;
    
     public function rules()
    {
        return [
            [['cnpj','nome','setor','codigo'], 'safe'],
            [['id','cnpj','codigo','nome','setor'], 'string'],
            
        ];
    }

    public function attributeLabels()
    {
        return [
           
            'codigo'=>'Código',
            'cnpj'=>'CNPJ',
            'nome'=>'Nome',
            'setor'=>'Setor'
            ];
    }

    public function attributeComments()
    {
        return [
           
              'codigo'=>'Código',
              'cnpj'=>'CNPJ',
              'nome'=>'Nome',
              'setor'=>'Setor'
             
        ];
    }
}
