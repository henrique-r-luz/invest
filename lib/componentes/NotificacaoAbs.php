<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\lib\componentes;

use app\models\Notificacao;

/**
 * Description of NotificacaoAbs
 *
 * @author henrique
 */
abstract class NotificacaoAbs {
    /*
     * model notificação
     */

    private $notificacao;

    /**
     * parâmetro recebido por cada objeto que tem como objetivo
     * a montagem do atributo dados da tabela notificação.
     * Esse variável poderá ser qualquer objeto que servirá de insumo para
     * a construção da messagem
     * @var type 
     */

    public function __construct() {
        $this->notificacao = new Notificacao();
    }

    /**
     * monta as informações da messagem para cada notificação
     */
    abstract public function montaDados();

     /**
     * envia notificação
     */
    public function envia() {
       $this->montaDados();
        if(!$this->notificacao->save()){
            //criar um systema de erro eficiente
           /*print_r($this->notificacao->getErrors());
           exit();*/
        }
    }
    
    public function getNotificacao(){
        return $this->notificacao;
    }

  

    //put your code here
}
