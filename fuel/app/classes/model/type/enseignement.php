<?php

use Orm\Model;

class Model_Type_Enseignement extends Model
{

    protected static $list_properties = array('t_nom');
    
    protected static $_primary_key = array('id_type_enseignement');
    protected static $_table_name = 'type_enseignement';
    protected static $_properties = array(
        'id_type_enseignement',
        't_nom' => array(
            'data_type' => 'text',
            'label' => 'Nom',
            'validation' => array('required', 'max_length'=>array(255)) //validation rules
        ),
    );
    
    public static function get_primary_key_name()
    {
        return self::$_primary_key[0];
    }
    
    protected static $_has_many = array(
        'enseignements' => array(
            'key_from' => 'id_type_enseignement',
            'model_to' => 'Model_Enseignement',
            'key_to' => 'type_enseignement_id',
            'cascade_save' => true,
            'cascade_delete' => true,
        )
    );
    
    public static function get_list_properties()
    {
        $to_return = array();
        foreach (self::$list_properties as $value)
            $to_return[$value] = self::$_properties[$value];
        
        return $to_return;
    }
    
    public function set_massive_assigments($fields)
    {
        $this->t_nom = $fields['t_nom'];
    }

}
