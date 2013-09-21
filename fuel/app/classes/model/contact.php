<?php

use Orm\Model;

class Model_Contact extends Orm\Model 
{

    protected static $_primary_key = array('id_contact');
    protected static $_table_name = 'contact';
    protected static $_belongs_to = array(
        'participant' => array(
            'key_from' => 'participant_id',
            'model_to' => 'Model_Participant',
            'key_to' => 'id_participant',
            'cascade_save' => true,
            'cascade_delete' => false,
        )
    );
    protected static $_has_one = array(
        'adresse' => array(
            'key_from' => 'id_contact',
            'model_to' => 'Model_Adresse',
            'key_to' => 'contact_id',
            'cascade_save' => true,
            'cascade_delete' => true,
        )
    );
    protected static $_properties = array(
        'id_contact',
        't_civilite',
        't_nom',
        't_prenom',
        'participant_id',
        'stage_id',
        't_type',
        't_cb_type',
    );

    public static function validate($factory) 
    {
        $val = Validation::forge($factory);
        $val->add_field('t_nom', 'Nom', 'required|max_length[50]');
        $val->add_field('t_prenom', 'Prénom', 'required|max_length[50]');

        $val->set_message('required', 'Veuillez remplir le champ :label.');
        $val->set_message('min_length', 'Le champ :label doit faire au moins :param:1 caractères.');
        $val->set_message('max_length', 'Le champ :label doit faire au plus :param:1 caractères.');
        $val->set_message('exact_length', 'Le champ :label doit compter exactement :param:1 caractères.');
        $val->set_message('valid_string', 'Le champ :label ne doit contenir que des chiffres.');
        
        return $val;
    }

    /**
     * Renvoie l'id de l'adresse liée au contact.
     *
     * @param type $id
     * @return type 
     */
    public static function getIdAddress($id) 
    {
        return DB::select('adresse')->from('contact')
                        ->where('contact.id_contact', $id)->execute()->as_array();
    }

}
