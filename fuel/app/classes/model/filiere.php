<?php

use Orm\Model;

class Model_Filiere extends Orm\Model
{

    protected static $_primary_key = array('id_filiere');
    protected static $_table_name = 'filiere';
    protected static $list_properties = array(
        't_nom',
        't_code_forem',
        'i_code_cedefop'
    );
    
    protected static $_properties = array(
        'id_filiere',
        't_nom' => array(
            'data_type' => 'text',
            'label' => 'Filière',
            'validation' => array('required', 'max_length' => array(255))
        ),
        't_code_forem' => array(
            'data_type' => 'text',
            'label' => 'Code Forem',
            'validation' => array()
        ),
        'i_code_cedefop' => array(
            'data_type' => 'text',
            'label' => 'Cedefop',
            'validation' => array('exact_length' => array(3), 'valid_string' => array('numeric'))
        ),
        'agrement_id' => array(
            'data_type' => 'text',
            'label' => 'Agrément',
            'validation' => array('required'),
            'form' => array('type' => 'select', 'options' => array() ),
        )
    );

    /**
     * Liaison vers la table Adresse
     * @var type 
     */
    protected static $_belongs_to = array(
        'agrements' => array(
            'key_from' => 'agrement_id',
            'model_to' => 'Model_agrement',
            'key_to' => 'id_agrement',
            'cascade_save' => false,
            'cascade_delete' => false,
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
     * Permet de remplir les champs select depuis un autre Model
     * 
     */
    public static function _init()
    {
        $types = DB::select()->from('agrement')->as_object()->execute();

        foreach ($types as $t)
            $data[$t->id_agrement] = $t->t_agrement;

        static::$_properties['agrement_id']['form']['options'] = $data;
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
        $this->t_code_forem = $fields['t_code_forem'];
        $this->i_code_cedefop = $fields['i_code_cedefop'];
        $this->agrement_id = $fields['agrement_id'];
    }
    
}
