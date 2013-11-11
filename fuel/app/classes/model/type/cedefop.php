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
    
//    protected static $_has_many = array(
//        'groupes' => array(
//            'key_from' => 'id_cedefop',
//            'model_to' => 'Model_Groupe',
//            'key_to' => 't_code_cedefop',
//            'cascade_save' => true,
//            'cascade_delete' => true,
//        )
//    );
    
    protected static $_observers = array(
        'Observer_Logging' => array(
            'events' => array('after_insert', 'after_update', 'after_delete'), 
        )
    );

    public static function get_primary_key_name()
    {
        return self::$_primary_key[0];
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
        $this->i_code = $fields['i_code'];
        $this->i_position = $fields['i_position'];
    }
    
//    public static function validate($factory)
//    {
//        $val = Validation::forge($factory);
//        $val->add_field('t_nom', 'Nom', 'required|max_length[255]');
//        $val->add_field('i_code', 'Code ', 'required|exact_length[3]|valid_string[numeric]');
//
//        $val->set_message('required', 'Veuillez remplir le champ :label.');
//        $val->set_message('min_length', 'Le champ :label doit faire au moins :param:1 caractères.');
//        $val->set_message('max_length', 'Le champ :label doit faire au plus :param:1 caractères.');
//        $val->set_message('exact_length', 'Le champ :label doit compter exactement :param:1 caractères.');
//        $val->set_message('valid_string', 'Le champ :label ne doit contenir que des chiffres.');
//
//        
//        return $val;
//    }
    
//    public static function getAsSelect()
//    {
//        $query = \DB::select()->from('type_cedefop')->execute();
//        $result = $query->as_array('id_cedefop', 't_nom');
//        $types = array();
//        foreach ($result as $id => $nom)
//        {
//            $types[$id] = $nom;
//        }
//        return $types;
//    }

//    public static function getCedefop(){
//
//        $query = \DB::select()->from('type_cedefop')->execute();
//        return $query;
//    }


}
