<?php

use Orm\Model;


class Model_Type_Contrat extends Model {

    protected static $_primary_key = array('id_type_contrat');
    protected static $_table_name = 'type_contrat';
    protected static $_properties = array(
        'id_type_contrat',
        't_type_contrat',
        'b_type_contrat_actif',
        'i_heures',
        'i_paye',
        'subside_id'
    );
    
    protected static $_observers = array(
        'Observer_Logging' => array(
            'events' => array('after_insert', 'after_update', 'after_delete'), 
        )
    );
    
    /**
     * Renvoie le nom de la PK (utilisé dans l'administration)
     * 
     * @return string
     */
    public static function get_primary_key_name()
    {
        return self::$_primary_key[0];
    }

    public static function getNames() {
        $result = array();
        $contrat = DB::select('id_type_contrat', 't_type_contrat')->from('type_contrat')->order_by('i_position')->execute();
        foreach ($contrat->as_array() as $value) {
            $result[$value['id_type_contrat']]= $value['t_type_contrat'];
            
        }        
        return $result;
       
    }
    
    public static function validate($factory) 
    {
        $val = Validation::forge($factory);
        $val->add_callable('\Maitrepylos\Validation');
        $val->add_field('i_heures', 'Heures', 'required|bland_hour|more_forty_hours');
        $val->add_field('t_type_contrat', 'Type', 'required');

        return $val;
    }




}
