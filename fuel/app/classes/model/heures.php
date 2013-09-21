<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of heures
 *
 * @author gg
 */
use Orm\Model;

class Model_Heures extends \Orm\Model {

    protected static $_primary_key = array('id_heures');
    protected static $_table_name = 'heures';
    protected static $_properties = array(
        'id_heures',
        'i_secondes',
        'd_date',
        't_motif',
        't_schema',
        'formateur_id',
        'contrat_id',
        'login_id'
    );

    public static function validate_heures($factory) {
        $val = Validation::forge($factory);
        $val->add_callable('\Maitrepylos\Validation');
        $val->add_field('i_secondes', 'Heures', 'required|bland_hour');

        return $val;
    }

}

?>
