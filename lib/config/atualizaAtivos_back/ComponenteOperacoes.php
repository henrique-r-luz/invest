<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\lib\config\atualizaAtivos;

use SplFileObject;

/**
 * Description of ComponenteOperacoes
 *
 * @author henrique
 */
class ComponenteOperacoes
{

    //put your code here
    public static function getFileDelimiter($file, $checkLines = 2)
    {
        $file = new SplFileObject($file);
        $delimiters = array(',', '\t', ';', '|', ':');
        $results = array();
        $i = 0;
        while ($file->valid() && $i <= $checkLines) {
            $line = $file->fgets();
            foreach ($delimiters as $delimiter) {
                $regExp = '/[' . $delimiter . ']/';
                $fields = preg_split($regExp, $line);
                if (count($fields) > 1) {
                    if (!empty($results[$delimiter])) {
                        $results[$delimiter]++;
                    } else {
                        $results[$delimiter] = 1;
                    }
                }
            }
            $i++;
        }
        $results = array_keys($results, max($results));
        return $results[0];
    }
}
