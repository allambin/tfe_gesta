<?php
namespace Maitrepylos;

/**
 * Suite à la limite du type TIME de MySQL,
 * j'ai du trouver une alternative pour le comptage des heures
 *
 * @author gg
 */
class Timetosec {

    private $_heures;
    private $_moduloHeures;
    private $_minutes;
    private $_secondes;
    private $_explode;
    private $_total;

    /**
     * La fonction retourne un entier correpondant au temps de travail en seconde
     * transformer en string sous forme 10:23:15
     * @param <BIGINT> $seconde
     * @return String
     */
    public  function TimeToString($seconde){
        if ($seconde==''){
            return null;
        }else{
            $tiret = null;
            if($seconde[0]=='-'){
                $seconde = substr($seconde, 1);
                $tiret = '-';
            }

            $this->_heures =  bcdiv($seconde, '3600');
            $this->_heures = $this->AddToZero($this->_heures);
            $this->_moduloHeures = bcmod($seconde, '3600');

            $this->_minutes = bcdiv($this->_moduloHeures,'60');
            $this->_secondes = bcmod($this->_moduloHeures, '60');
            $this->_minutes = $this->AddToZero($this->_minutes);
            $this->_secondes = $this->AddToZero($this->_secondes);
            if ($tiret != null){
                $this->_heures = $tiret.$this->_heures;
            }
            return $this->_heures.':'.$this->_minutes.':'.$this->_secondes;
        }
    }
    /**
     * A partir d'un string représentant des heures (19:23:12)
     * nous transformons en secondes.
     * @param <string> $string
     * @return <Bigint>
     */
    public function StringToTime($string){


        $tiret = null;
        $caractere = $string[0];
        if($caractere =='-'){
            $string = substr($string,1);
            $tiret = '-';
        }

        //list ($this->_heures,$this->_minutes,$this->_secondes) = explode(':', $string);
        $this->_explode = explode(':',$string);
        $this->_heures = $this->_explode[0];
        $this->_minutes = $this->_explode[1];
        if(isset($this->_explode[2])){$this->_secondes = $this->_explode[2];}
        //$this->_secondes = $this->_explode[2];

        $this->_heures = bcmul($this->_heures, '3600');
        $this->_minutes = bcmul($this->_minutes, '60');

        $this->_total = bcadd((int)$this->_heures,(int)$this->_minutes);
        $this->_total = bcadd((int)$this->_total,(int)$this->_secondes);

        if ($tiret != null){
            $this->_total = $tiret.$this->_total;
        }

        return $this->_total;


    }

    public function AddToZero($string){
        if ($string < 10){
            return '0'.$string;
        }else{
            return $string;
        }
    }

}
?>
