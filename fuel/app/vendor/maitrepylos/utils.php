<?php

namespace Maitrepylos;

/**
 * Description of utils
 *
 * @author gg
 */
class Utils {

    /**
     * Methode retournant le nom literal d'un mois
     * @method mois
     * @param integer $num
     * @return String
     */
    static function mois($num) {

        $mois = array(
            '01' => 'janvier',
            '02' => 'fevrier',
            '03' => 'mars',
            '04' => 'avril',
            '05' => 'mai',
            '06' => 'juin',
            '07' => 'juillet',
            '08' => 'aout',
            '09' => 'septembre',
            '1' => 'janvier',
            '2' => 'fevrier',
            '3' => 'mars',
            '4' => 'avril',
            '5' => 'mai',
            '6' => 'juin',
            '7' => 'juillet',
            '8' => 'aout',
            '9' => 'septembre',
            '10' => 'octobre',
            '11' => 'novembre',
            '12' => 'decembre'
        );

        return $mois[(string) $num];
    }
    
    /**
     * Compte le nombres de jour entre deux nombres .
     * @param type $s
     * @return type 
     * @example 
     */
    public static function srange ($s) {
        preg_match_all("/([0-9]{1,2})-?([0-9]{0,2}) ?,?;?/", $s, $a);
        $n = array ();
        foreach ($a[1] as $k => $v) {
            $n  = array_merge ($n, range ($v, (empty($a[2][$k])?$v:$a[2][$k])));
        }
        return ($n);
    }

    public static function cedefop($array,$compare) {
        $cedefop = NULL;
        foreach ($array as $valeur) {
            list ($nom) = explode('-', (string)$valeur['t_nom']);
            if($compare===$nom) {
                $cedefop = $valeur['t_nom'];
            }
        }
        return $cedefop;
    }
    
    

}

?>
