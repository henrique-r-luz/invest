<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace app\models\financas\service\operacoesImport;
/**
 * Description of OperacoesInterface
 *
 * @author henrique
 */
abstract class OperacoesAbstract {
    
    //arquivo recebido no CRUD, que pode ser cvs , pdf e etc
    protected $arquivo;
    protected $operacoesImport;

    function __construct($operacoesImport) {
       $this->operacoesImport =  $operacoesImport;
        $this->getDados();
    }
    
    //get os dados externos
    abstract protected function getDados();
    
    //Atuliza a base de dados com as informações obtidas de fora
    abstract public  function atualiza();
}
