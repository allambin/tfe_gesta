<?php

namespace Maitrepylos;

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Date
 *
 * @author gg
 */
class Date {

    const NOT_DIGITS = "la date ne contient pas que des chiffres";
    const STRING_EMPTY = "La première date est vide";
    const DATE_HEURE_SUP = " la date est supérieur à la date maximal du mois";
    const DATE_SUP_DATE = "La première date est supérieur à la deuxième";

    /**
     * Digits filter used for validation
     *
     * @var Filter_Digits
     */
    protected static $_filter = null;

    /**
     * On affirme qu'il y a deux données
     * @var int
     */
    private $_nombres = 1;

    /**
     * Le jours maximum du mois 28,29,30 ou 31
     */
    private $_max_jours_mois = 31;
    private $_message = array();

    /**
     * le constrcuteur permet de passer des informations, comme le nombre de jours du mois
     */
    public function __construct($jours_max = 31) {
        $this->_max_jours_mois = $jours_max;
    }

    /**
     * Defined by Zend_Validate_Interface
     *
     * Returns true if and only if $value only contains digit characters
     *
     * @param  string $value
     * @return boolean
     */
    public function isValid($value) {
        $valueString = (string) $value[0];



        if ('' === $valueString || '0' == $valueString || '00' == $valueString) {
            $this->set_message(self::STRING_EMPTY);
            return false;
        }

        if ('' !== $value[1] || '0' == $value[1] || '00' == $value[1]) {
            $this->_nombres = 2;
            if ($value[0] > $value[1]) {
                $this->set_message(self::DATE_SUP_DATE);
                return false;
            }
        }

        for ($i = 0; $i < $this->_nombres; $i++) {

            if ($value[$i] !== \Maitrepylos\Filter\Digit::filter($value[$i])) {

                $this->set_message(self::NOT_DIGITS);
                return false;
            }
            if ($value[$i] > $this->_max_jours_mois) {
                $this->set_message(self::DATE_HEURE_SUP);
                return false;
            }
            //mettre la suite ici;
        }
        return true;
    }

    public static function date_to_db($date) {
        list($day, $month, $year) = explode('/', $date);
        $objDate = new \DateTime();
        $objDate->setDate($year, $month, $day);
        return $objDate->format('Y-m-d');
    }

    public static function db_to_date($date) {

        if ($date == Null) {
            return Null;
        }

        list($year, $month, $day) = explode('-', $date);
        $objDate = new \DateTime();
        $objDate->setDate($year, $month, $day);
        return $objDate->format('d/m/Y');
    }

    public function get_message() {
        return $this->_message;
    }

    public function set_message($_message) {
        $this->_message[] = $_message;
    }
    
        /**
	 * Cette methode a pour objectif de calculer la difference de mois entre 2 dates
	 * On ajoute 1, pour prendre en compte le mois courrant
         * Nous passons par un fonction maison car le diff de datetime est trop précis et note les jours au lieu de 1 mois  
	 * @method nbMois	
	 * @param String $date1
	 * @param String $date2
	 * @return integer 
	 */
	public static function nbMois(\ Datetime $date1,\Datetime $date2) 
	{
		
		return (($date1->format('Y')-$date2->format('Y'))*12 + ($date1->format('m')- $date2->format('m')))+1;
	}


}

?>