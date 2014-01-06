<?php
use Orm\Model;

class Model_Type_Cedefop extends Model
{
    
    protected static $list_properties = array('t_nom', 'i_code', 'i_position');
    
    protected static $_primary_key = array('id_cedefop');
    protected static $_table_name = 'type_cedefop';
    
    protected static $_properties = array(
        'id_cedefop',
        't_nom' => array(
            'data_type' => 'text',
            'label' => 'Nom',
            'validation' => array('required', 'max_length' => array(255))
        ),
        'i_position' => array(
            'data_type' => 'text',
            'label' => 'Position'
        ),
        'i_code' => array(
            'data_type' => 'text',
            'label' => 'Code',
            'validation' => array('required', 'exact_length' => array(3), 'valid_string' => array('numeric'))
        ),
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
        $this->i_code = $fields['i_code'];
        $this->i_position = $fields['i_position'];
    }

}
