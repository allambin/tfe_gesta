<?php

namespace Maitrepylos;


/**
 * Classe de validation de MaitrePylos.
 * @since Cette classe permet de faire des vérifiaction sur les contrats et la 
 * géstion des heures. 
 */
class Validation {
    
    const HEURE_MAX_SEMAINE = 144000;
    
    /**
     * Validation pour une valeur n'est aps supérieur à 100.
     * @param type $value
     * @return boolean 
     */
    public static function _validation_exceeds_onehundred($value) {
        if ($value > 100) {

            return false;
        }

        return true;
    }
        /**
     * Validation pour une valeur n'est pas supérieur à 40 heures en secondes.
     * @param type $value
     * @return boolean 
     */
    public static function _validation_more_forty_hours($value) {
        $time = new \Maitrepylos\Timetosec();
        
        if ($time->StringToTime($value) > self::HEURE_MAX_SEMAINE ) {
            return false;
        }

        return true;
    }
    /**
     * Validation pour une date n'est pas inférieure à l'autre
     * @param type $date1
     * @param type $date2
     * @return boolean 
     */
    public static function _validation_date_less($date1, $date2) {



        list($day, $month, $year) = explode('/', $date1);
        $date[0] = new \DateTime();
        $date[0]->setDate($year, $month, $day);

        list($day, $month, $year) = explode('/', $date2);
        $date[1] = new \DateTime();
        $date[1]->setDate($year, $month, $day);



        if ($date[0] < $date[1]) {

            return false;
        }

        return true;
    }
    /**
     * Validation qu'une date n'est pas supérieur à 18 mois.
     * @param type $date1
     * @param type $date2
     * @return boolean 
     */
    public static function _validation_eighteen_months_more($date1, $date2) {

        list($day, $month, $year) = explode('/', $date1);
        $date[0] = new \DateTime();
        $date[0]->setDate($year, $month, $day);

        list($day, $month, $year) = explode('/', $date2);
        $date[1] = new \DateTime();
        $date[1]->setDate($year, $month, $day);

        $date[0]->add(new \DateInterval('P18M'));

        if ($date[1] > $date[0]) {
            return false;
        }
        return true;
    }
    /**
     * Validation sur True/False
     * @param type $value
     * @return boolean 
     */
    public static function _validation_true($value) {

        if ($value === true) {
            return true;
        }

        return false;
    }
    /**
     * Validation du paterne des heures de prestations
     * @param type $value
     * @return boolean 
     */
    public static function _validation_bland_hour($value) {
        if (!preg_match('/^[0-9]{2,3}(\:[0-5]{1}[0-9]{1})(\:[0-5]{1}[0-9]{1})?$/', $value)) {
            return false;
        }
        return true;
    }
    
    
     public static function validate_hour() 
    {
        $val = Validation::forge();

        $val->add_callable('\Maitrepylos\Validation');

        $val->add_field('heuresprester', 'Heures', 'required|bland_hour');
        $val->set_message('bland_hour','Le champ :label doit-être sous forme 00:00');

        return $val;
    }

}

?>
