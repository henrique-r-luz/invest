<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models\service;

use app\models\Histograma;
use \app\models\BalancoEmpresaBolsa;

/**
 * Description of HistogramaService
 *
 * @author henrique
 */
class HistogramaService {

    //put your code here

    private $histograma;
    private $labelClasse;
    private $classesHistograma;

    function __construct() {
        $this->histograma = new Histograma();
    }

    public function load($post) {
        return $this->histograma->load($post);
    }

    public function geraDados() {
        if($this->histograma->tempo==\app\lib\Tempo::ANO){
            $tempo = false;
        }else{
            $tempo = true;
        }
        $balancos = BalancoEmpresaBolsa::find()
                ->select([$this->histograma->atributo])
                //->where($model->empresas)
                ->orderBy([$this->histograma->atributo => SORT_ASC])
                ->andWhere(['is not', $this->histograma->atributo, null])
                ->andWhere(['trimestre'=>$tempo])
                ->asArray()
                ->all();
       
        if (empty($balancos)) {
           
            return;
        }
        $min = $balancos[0][$this->histograma->atributo];
        $max = $balancos[count($balancos) - 1][$this->histograma->atributo];
        $intergalo = $max - $min;
        $denominador = ($this->histograma->numeroClasse == 0) ? 1 : $this->histograma->numeroClasse;
        $tamanhoIntervalos = $intergalo / $denominador;
        $limiteInferiror = $min;
        $limiteSuperiror = $limiteInferiror + $tamanhoIntervalos;
        $classes = [];
        $this->labelClasse = [];
        for ($i = 0; $i < $denominador; $i++) {
            $classes[$i] = [$limiteInferiror, $limiteSuperiror];
            $this->labelClasse[$i] = round(($limiteInferiror)/1000, 2).'__'.round($limiteSuperiror/1000, 2);
            $limiteInferiror = $limiteSuperiror;
            $limiteSuperiror += $tamanhoIntervalos;
        }
        //$classes[count($classes) - 1][1]++;
        $this->classesHistograma = [];
        foreach ($classes as $id => $classe) {
            $this->classesHistograma[$id] = 0;
        }
        foreach ($balancos as $balanco) {
            foreach ($classes as $id => $classe) {
                if ($balanco[$this->histograma->atributo] >= $classe[0] && $balanco[$this->histograma->atributo] < $classe[1]) {

                    $this->classesHistograma[$id]++;
                }
            }
        }
       
    }

    public function getHistograma() {
        return $this->histograma;
    }

    public function getClasseHistograma() {
        return $this->classesHistograma;
    }

    public function getLabelClasse() {
        return $this->labelClasse;
    }

}
