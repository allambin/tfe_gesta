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
    
    /**
     * Renvoie le nom de la PK (utilisé dans les observers)
     * 
     * @return string
     */
    public static function get_primary_key_name()
    {
        return self::$_primary_key[0];
    }
    
    protected static $_properties = array(
        'id_adresse',
        't_nom_rue' => array(
            'data_type' => 'text',
            'label' => 'Nom de la rue',
            'validation' => array('max_length'=>array(255))
        ),
        't_bte' => array(
            'data_type' => 'text',
            'label' => 'Boite',
            'validation' => array('max_length'=>array(255))
        ),
        't_code_postal' => array(
            'data_type' => 'text',
            'label' => 'Code postal',
            'validation' => array('exact_length'=>array(4))
        ),
        't_commune' => array(
            'data_type' => 'text',
            'label' => 'Commune',
            'validation' => array('max_length'=>array(255))
        ),
        't_telephone' => array(
            'data_type' => 'text',
            'label' => 'Téléphone',
            'validation' => array('exact_length'=>array(9))
        ),
        't_courrier' => array(
            'data_type' => 'text',
            'label' => 'Défaut',
            'validation' => array(),
            'form' => array(
                'type' => 'checkbox',
                'value' => 1
            )
        ),
        'participant_id' => array(
            'data_type' => 'text',
            'label' => 'Participant',
            'validation' => array(),
            'form' => array(
                'type' => false, // this prevents this field from being rendered on a form
            ),
        ),
        'contact_id' => array(
            'data_type' => 'text',
            'label' => 'Contact',
            'validation' => array(),
            'form' => array(
                'type' => false, // this prevents this field from being rendered on a form
            ),
        ),
        't_type' => array(
            'data_type' => 'text',
            'label' => 'Type',
            'validation' => array('max_length'=>array(255))
        ),
    );
    
    protected static $_observers = array(
        'Observer_Logging' => array(
            'events' => array('after_insert', 'after_update', 'after_delete'), 
        )
    );
    
    /**
     * Remplit les champs de l'objet avec le tableau passé en paramètre
     * 
     * @param array $fields
     */
    public function set_massive_assigment($fields, $origin = null)
    {
        $this->t_nom_rue = $fields['t_nom_rue'];
        $this->t_bte = isset($fields['t_bte']) ? $fields['t_bte'] : '';
        $this->t_code_postal = $fields['t_code_postal'];
        $this->t_commune = \Cranberry\MySanitarization::uc_first_and_to_lower(\Cranberry\MySanitarization::filter_alpha($fields['t_commune']));
        $this->t_telephone = isset($fields['t_telephone']) ? $fields['t_telephone'] : '';
        $this->t_courrier = isset($fields['t_courrier']) ? (int)$fields['t_courrier']: 0;
        $this->t_type = isset($fields['t_type']) ? $fields['t_type'] : '';
        
        if($origin == 'contact')
        {
            $this->t_courrier = 0;
            $this->t_type = '';
        }
    }
    
    /**
     * Renvoie un string avec l'adresse formatée
     * 
     * @return string
     */
    public function getFullAddress()
    {
        return $this->t_bte . ", " . $this->t_nom_rue . "<br />" . $this->t_code_postal . " " . $this->t_commune . "<br />" . $this->t_telephone;
    }
    
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

}
