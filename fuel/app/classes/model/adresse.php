<?php

use Orm\Model;

class Model_Adresse extends Orm\Model 
{

    protected static $_primary_key = array('id_adresse');
    protected static $_table_name = 'adresse';
    
    protected static $_belongs_to = array(
        'participant' => array(
            'key_from' => 'participant_id',
            'model_to' => 'Model_Participant',
            'key_to' => 'id_participant',
            'cascade_save' => true,
            'cascade_delete' => false,
        ),
        'contact' => array(
            'key_from' => 'contact_id',
            'model_to' => 'Model_Contact',
            'key_to' => 'id_contact',
            'cascade_save' => true,
            'cascade_delete' => false,
        )
    );
    
    protected static $_has_one = array(
        'stagiaire' => array(
            'key_from' => 'id_adresse',
            'model_to' => 'Model_Listeattente',
            'key_to' => 'adresse_id',
            'cascade_save' => true,
            'cascade_delete' => false,
        )
    );

    
    protected static $_properties = array(
        'id_adresse',
        't_nom_rue',
        't_bte',
        't_code_postal',
        't_commune',
        't_telephone',
        't_courrier',
        'participant_id',
        'contact_id',
        't_type',
    );

    public static function validate($factory) 
    {
        $val = Validation::forge($factory);
        $val->add_field('t_code_postal', 'Code postal', 'exact_length[4]');
        $val->add_field('t_telephone', 'Téléphone', 'exact_length[9]');
        $val->add_field('t_email', 'Email', 'valid_email');

        $val->set_message('required', 'Veuillez remplir le champ :label.');
        $val->set_message('min_length', 'Le champ :label doit faire au moins :param:1 caractères.');
        $val->set_message('max_length', 'Le champ :label doit faire au plus :param:1 caractères.');
        $val->set_message('exact_length', 'Le champ :label doit compter exactement :param:1 caractères.');
        $val->set_message('valid_string', 'Le champ :label ne doit contenir que des chiffres.');
        
        return $val;
    }

    /**
     * Méthode mettant à 0 le champ t_courrier dans la table adresse,
     * selon un id_participant et un id_adresse.
     *
     * @param type $participant
     * @param type $adresse 
     */
    public static function updateDefaultAddress($participant, $adresse) {
        DB::update('adresse')
                ->set(array(
                    't_courrier' => 0
                ))
                ->where('participant_id', '=', $participant)
                ->and_where('id_adresse', '!=', $adresse)
                ->execute();
    }
    
    public function getFullAddress()
    {
        return $this->t_bte . ", " . $this->t_nom_rue . "<br />" . $this->t_code_postal . " " . $this->t_commune . "<br />" . $this->t_telephone;
    }

}
