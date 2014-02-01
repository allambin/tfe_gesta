<?php

use Orm\Model;

class Model_Subside extends Orm\Model
{
    protected static $_primary_key = array('id_subside');
    protected static $_table_name = 'subside';
    protected static $list_properties = array(
        't_nom'
    );
    
    protected static $_properties = array(
        'id_subside',
        't_nom' => array(
            'data_type' => 'text',
            'label' => 'Nom',
            'validation' => array('required', 'max_length' => array(255))
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
    
    protected static $_observers = array(
        'Observer_Logging' => array(
            'events' => array('after_insert', 'after_update', 'after_delete'), 
        )
    );
    
    /**
     * Renvoie le tableau $list_properties, utilisé dans l'administration
     * 
     * @return array
     */
    public static function get_list_properties()
    {
        $to_return = array();
        foreach (self::$list_properties as $value)
            $to_return[$value] = self::$_properties[$value];
        
        return $to_return;
    }
    
    /**
     * Remplit les champs de l'objet avec le tableau passé en paramètre
     * 
     * @param array $fields
     */
    public function set_massive_assigment($fields)
    {
        $this->t_nom = $fields['t_nom'];
    }
}