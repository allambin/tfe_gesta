<?php

use Orm\Model;

class Model_Checklist_Valeur extends Model
{
    
    protected static $list_properties = array('t_nom');
    protected static $_primary_key = array('id_checklist_valeur');
    
    protected static $_properties = array(
        'id_checklist_valeur',
        't_nom' => array(
            'data_type' => 'text',
            'label' => 'Nom',
            'validation' => array('required', 'max_length'=>array(255)) //validation rules
        ),
        'section_id' => array(
            'data_type' => 'text',
            'label' => 'Section',
            'validation' => array('required'),
            'form' => array('type' => 'select', 'options' => array() ),
        )
    );
    protected static $_table_name = 'checklist_valeur';

    protected static $_belongs_to = array(
        'section' => array(
            'key_from' => 'section_id',
            'model_to' => 'Model_Checklist_Section',
            'key_to' => 'id_checklist_section',
            'cascade_save' => true,
            'cascade_delete' => false,
        )
    );
    
    protected static $_observers = array(
        'Observer_Logging' => array(
            'events' => array('after_insert', 'after_update', 'after_delete'), 
        ),
        'Observer_Delete' => array(
            'events' => array('before_delete'), 
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
     * Permet de remplir les champs select depuis un autre Model
     */
    public static function _init()
    {
        $types = DB::select()->from('checklist_section')->as_object()->execute();

        foreach ($types as $t)
            $data[$t->id_checklist_section] = $t->t_nom;

        static::$_properties['section_id']['form']['options'] = $data;
    }
    
    /**
     * Remplit les champs de l'objet avec le tableau passé en paramètre
     * 
     * @param array $fields
     */
    public function set_massive_assigment($fields)
    {
        $this->t_nom = $fields['t_nom'];
        $this->section_id = $fields['section_id'];
    }    

}
