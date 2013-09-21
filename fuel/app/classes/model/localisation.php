<?php

use Orm\Model;

class Model_Localisation extends Orm\Model
{

    protected static $_primary_key = array('id_localisation');
    protected static $_table_name = 'localisation';

    /**
     * Liaison vers la table Adresse
     * @var type 
     */
    protected static $_belongs_to = array(
        'adresses' => array(
            'key_from' => 'adresse_id',
            'model_to' => 'Model_adresse',
            'key_to' => 'id_adresse',
            'cascade_save' => true,
            'cascade_delete' => true,
        )
    );



    protected static $_properties = array(
        'id_localisation',
        't_lieu',
        'adresse_id'
    );

    public static function validate($factory) 
    {
        $val = Validation::forge($factory);

        $val->add_field('t_lieu', 'Lieu', 'required');
        $val->set_message('required', 'Veuillez remplir le champ :label.');

        
        return $val;
    }

    public static function get_localisation_names($id)
    {

        $query = \DB::select('t_lieu')->from('localisation')->where('id_localisation', '=', $id)->execute();
        return $query;

    }
    


}
