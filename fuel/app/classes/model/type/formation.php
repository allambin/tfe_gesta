<?php

use Orm\Model;

class Model_Type_Formation extends Model
{
    protected static $list_properties = array('t_nom');
    
    protected static $_primary_key = array('id_type_formation');
    protected static $_table_name = 'type_formation';
    protected static $_properties = array(
        'id_type_formation',
        't_nom' => array(
            'data_type' => 'text',
            'label' => 'Nom',
            'validation' => array('required', 'max_length'=>array(255)) //validation rules
        ),
    );

    protected static $_has_many = array(
        'fins_formation' => array(
            'key_from' => 'id_type_formation',
            'model_to' => 'Model_Fin_Formation',
            'key_to' => 'type_formation_id',
            'cascade_save' => false,
            'cascade_delete' => false,
        )
    );
    
    public static function get_primary_key_name()
    {
        return self::$_primary_key[0];
    }
    
    public static function validate($factory)
    {
        $val = Validation::forge($factory);
        $val->add_field('t_nom', 'Nom', 'required|max_length[255]');

        $val->set_message('required', 'Veuillez remplir le champ :label.');
        
        return $val;
    }
    
    public static function get_list_properties()
    {
        $to_return = array();
        foreach (self::$list_properties as $value)
            $to_return[$value] = self::$_properties[$value];
        
        return $to_return;
    }
    
    public function set_massive_assigment($fields)
    {
        $this->t_nom = $fields['t_nom'];
    }
    
//    public static function getAsSelect()
//    {
//        $query = \DB::select()->from('type_formation')->execute();
//        $result = $query->as_array('id_type_formation', 't_nom');
//        $types = array();
//        foreach ($result as $id => $nom)
//        {
//            $types[$id] = $nom;
//        }
//        return $types;
//    }

}
