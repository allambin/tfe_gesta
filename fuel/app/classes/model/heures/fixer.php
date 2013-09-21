<?php

use Orm\Model;

class Model_Heures_Fixer extends Orm\Model {

    protected static $_primary_key = array('id_heures_fixer');
    protected static $_table_name = 'heures_fixer';
    protected static $_properties = array(
        'id_heures_fixer',
        'd_date',
        'i_heures',
        't_motif',
        'participant_id',
    );

    public static function validate_heures($factory) {
        $val = Validation::forge($factory);
        $val->add_callable('\Maitrepylos\Validation');
        $val->add_field('i_heures', 'Heures', 'required|bland_hour');
       
        return $val;
    }

}

?>
