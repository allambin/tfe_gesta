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

class Model_Activite extends \Orm\Model {

    protected static $_primary_key = array('id_activite');
    protected static $_table_name = 'activite';
    protected static $list_properties = array(
        't_nom',
        't_schema',
        'i_position'
    );
    
    protected static $_properties = array(
        'id_activite',
        't_nom' => array(
            'data_type' => 'text',
            'label' => 'Nom',
            'validation' => array('required', 'max_length' => array(255))
        ),
        't_schema' => array(
            'data_type' => 'text',
            'label' => 'Schéma',
            'validation' => array('required', 'exact_length' => array(1))
        ),
        'i_position' => array(
            'data_type' => 'text',
            'label' => 'Position',
            'validation' => array('required', 'exact_length' => array(1), 'valid_string' => array('numeric'))
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
        $this->t_schema = $fields['t_schema'];
        $this->i_position = $fields['i_position'];
    }

}

?>
