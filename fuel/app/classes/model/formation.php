<?php

use Orm\Model;

class Model_Formation extends Model
{
    
    protected static $_primary_key = array('id_formation');
    protected static $_table_name = 'formation';

    protected static $_properties = array(
        'id_formation',
        'd_date_fin_formation',
        't_fin_formation',
        't_fin_formation_suite',
        'contrat_id',
    );
    
    protected static $_observers = array(
        'Observer_Logging' => array(
            'events' => array('after_insert', 'after_update', 'after_delete'), 
        )
    );
    
    /**
     * Renvoie le nom de la PK (utilisé dans les observers)
     * 
     * @return string
     */
    public static function get_primary_key_name()
    {
        return self::$_primary_key[0];
    }

}
