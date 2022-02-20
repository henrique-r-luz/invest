<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models\service;

use app\models\analiseGrafica\Histograma;
use app\models\financas\BalancoEmpresaBolsa;
use \app\lib\dicionario\Tempo;

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
    private $balancos;

    function __construct() {
        $this->histograma = new Histograma();
    }

    public function load($post) {
        return $this->histograma->load($post);
    }

    public function geraDados() {


        $this->balancos = $this->getDadosBd();
        if (empty($this->balancos)) {
            return;
        }
        //intevalo de classes do histograma e frequências
        $classes = $this->geraLabelClasse();
        $this->geraClassesHistograma($classes);
    }

    private function geraLabelClasse() {
        $min = $this->balancos[0][$this->histograma->atributo];
        $max = $this->balancos[count($this->balancos) - 1][$this->histograma->atributo];
        $intergalo = $max - $min;
        $denominador = ($this->histograma->numeroClasse == 0) ? 1 : $this->histograma->numeroClasse;
        $tamanhoIntervalos = $intergalo / $denominador;
        $limiteInferiror = $min;
        $limiteSuperiror = $limiteInferiror + $tamanhoIntervalos;
        $classes = [];
        $this->labelClasse = [];
        for ($i = 0; $i < $denominador; $i++) {
            $classes[$i] = [$limiteInferiror, $limiteSuperiror];
            $this->labelClasse[$i] = '(' . round(($limiteInferiror), 2) . ', ' . round($limiteSuperiror, 2) . ')';
            $limiteInferiror = $limiteSuperiror;
            $limiteSuperiror += $tamanhoIntervalos;
        }
        return $classes;
    }

    private function geraClassesHistograma($classes) {
        $this->classesHistograma = [];
        foreach ($classes as $id => $classe) {
            $this->classesHistograma[$id] = 0;
        }
        foreach ($this->balancos as $balanco) {
            foreach ($classes as $id => $classe) {
                if ($balanco[$this->histograma->atributo] >= $classe[0] && $balanco[$this->histograma->atributo] < $classe[1]) {

                    $this->classesHistograma[$id]++;
                }
            }
        }
    }

    private function getDadosBd() {
        if (!empty($this->histograma->empresas)) {
            $balancos = BalancoEmpresaBolsa::find()
                    ->select([$this->histograma->atributo])
                    ->orderBy([$this->histograma->atributo => SORT_ASC])
                    ->andWhere(['is not', $this->histograma->atributo, null])
                    ->andWhere(['trimestre' => $this->getTempo()])
                    ->andWhere(['codigo' => $this->histograma->empresas])
                    ->asArray()
                    ->all();
        }else{
              $balancos = BalancoEmpresaBolsa::find()
                    ->select([$this->histograma->atributo])
                    ->orderBy([$this->histograma->atributo => SORT_ASC])
                    ->andWhere(['is not', $this->histograma->atributo, null])
                    ->andWhere(['trimestre' => $this->getTempo()])
                    ->asArray()
                    ->all();
        }
        return $balancos;
    }

    private function getTempo() {
        if ($this->histograma->tempo == Tempo::ANO) {
            $tempo = false;
        } else {
            $tempo = true;
        }
        return $tempo;
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
