<?php

use Orm\Model;

class Model_Type_Pays extends Model
{
    protected static $_primary_key = array('id_pays');
    protected static $_table_name = 'type_pays';
    protected static $list_properties = array(
        't_nom',
        't_valeur'
    );
    
    protected static $_properties = array(
        'id_pays',
        't_nom' => array(
            'data_type' => 'text',
            'label' => 'Nom',
            'validation' => array('required', 'max_length' => array(255))
        ),
        't_valeur' => array(
            'data_type' => 'text',
            'label' => 'Schéma',
            'validation' => array('required', 'valid_string' => array('numeric'))
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
        $this->t_valeur = $fields['t_valeur'];
    }
    
    public static function getAsSelect()
    {
        $query = \DB::select()->from('type_pays')->order_by('t_nom')->execute();
        $result = $query->as_array('t_nom');
        $types = array();
        foreach ($result as $nom)
        {
            $types[$nom['t_nom']] = $nom['t_nom'];
        }
        return $types;
    }

}