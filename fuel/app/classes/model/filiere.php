<?php

use Orm\Model;

class Model_Filiere extends Orm\Model
{

    protected static $_primary_key = array('id_filiere');
    protected static $_table_name = 'filiere';

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



    protected static $_properties = array(
        'id_filiere',
        't_nom',
        't_code_forem',
        'i_code_cedefop',
        'agrement_id',

    );

    public static function validate($factory) 
    {
        $val = Validation::forge($factory);

        $val->add_field('t_nom', 'Nom', 'required');
        $val->set_message('required', 'Veuillez remplir le champ :label.');

        
        return $val;
    }
    


}
