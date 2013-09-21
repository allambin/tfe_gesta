<?php

use Orm\Model;

class Model_Agrement extends Orm\Model
{

    protected static $_primary_key = array('id_agrement');
    protected static $_table_name = 'agrement';

    /**
     * Liaison vers la table Adresse
     * @var type 
     */
    protected static $_belongs_to = array(
        'users' => array(
            'key_from' => 'users_id',
            'model_to' => 'Model_User',
            'key_to' => 'id',
            'cascade_save' => false,
            'cascade_delete' => false,
        ),
        'centres' => array(
            'key_from' => 'centre_id',
            'model_to' => 'Model_Centre',
            'key_to' => 'id_centre',
            'cascade_save' => false,
            'cascade_delete' => false,
        )
    );



    protected static $_properties = array(
        'id_agrement',
        't_agrement',
        't_origine_agrement',
        'centre_id',
        'users_id',

    );

    public static function validate($factory) 
    {
        $val = Validation::forge($factory);

        $val->add_field('t_agrement', 'Nom', 'required');
        $val->set_message('required', 'Veuillez remplir le champ :label.');

        
        return $val;
    }

    public static function getAgrement()
    {

        $query = \DB::select()->from('agrement')->execute();
        return $query;
    }

    


}
