<?php

use Orm\Model;

class Model_Type_Formation extends Model
{
    protected static $_primary_key = array('id_type_formation');
    protected static $_table_name = 'type_formation';
    protected static $_properties = array(
        'id_type_formation',
        't_nom',
    );

    protected static $_has_many = array(
        'fins_formation' => array(
            'key_from' => 'id_type_formation',
            'model_to' => 'Model_Fin_Formation',
            'key_to' => 'type_formation_id',
            'cascade_save' => true,
            'cascade_delete' => true,
        )
    );
    
    public static function validate($factory)
    {
        $val = Validation::forge($factory);
        $val->add_field('t_nom', 'Nom', 'required|max_length[255]');

        $val->set_message('required', 'Veuillez remplir le champ :label.');
        
        return $val;
    }
    
    public static function getAsSelect()
    {
        $query = \DB::select()->from('type_formation')->execute();
        $result = $query->as_array('id_type_formation', 't_nom');
        $types = array();
        foreach ($result as $id => $nom)
        {
            $types[$id] = $nom;
        }
        return $types;
    }

}
