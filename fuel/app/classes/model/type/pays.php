<?php

use Orm\Model;

class Model_Type_Pays extends Model
{
    protected static $_primary_key = array('id_pays');
    protected static $_table_name = 'type_pays';
    protected static $_properties = array(
        'id_pays',
        't_nom',
        't_valeur',
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