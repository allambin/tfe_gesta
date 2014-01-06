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
    
    protected static $_observers = array(
        'Observer_Logging' => array(
            'events' => array('after_insert', 'after_update', 'after_delete'), 
        ),
        'Observer_Delete' => array(
            'events' => array('before_delete'), 
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
        'id_contact',
        't_civilite' => array(
            'data_type' => 'text',
            'label' => 'Civilité',
            'validation' => array()
        ),
        't_nom' => array(
            'data_type' => 'text',
            'label' => 'Nom',
            'validation' => array('required', 'max_length'=>array(50))
        ),
        't_prenom' => array(
            'data_type' => 'text',
            'label' => 'Prénom',
            'validation' => array('required', 'max_length'=>array(50))
        ),
        'participant_id' => array(
            'data_type' => 'text',
            'label' => 'Participant',
            'validation' => array(),
            'form' => array(
                'type' => false, 
            ),
        ),
        'stage_id' => array(
            'data_type' => 'text',
            'label' => 'Stage',
            'validation' => array(),
            'form' => array(
                'type' => false,
            ),
        ),
        't_type' => array(
            'data_type' => 'text',
            'label' => 'Type',
            'validation' => array()
        ),
        't_cb_type' => array(
            'data_type' => 'text',
            'label' => 'Type',
            'validation' => array()
        ),
    );
    
    /**
     * Remplit les champs de l'objet avec le tableau passé en paramètre
     * 
     * @param array $fields
     */
    public function set_massive_assigment($fields)
    {
        $adresse = new Model_Adresse();
        $adresse->set_massive_assigment($fields, 'contact');
        
        $cb = '';
        if(isset($fields['t_cb_type']))
        {
            $cb = $fields['t_cb_type'];
            $cb = implode(',', $cb);
        }
        
        $this->t_civilite = $fields['t_civilite'];
        $this->t_type = $fields['t_type'];
        $this->t_cb_type = $cb;
        $this->t_nom = strtoupper(\Cranberry\MySanitarization::filterAlpha(\Cranberry\MySanitarization::stripAccents($fields['t_nom'])));
        $this->t_prenom = \Cranberry\MySanitarization::ucFirstAndToLower(\Cranberry\MySanitarization::filterAlpha($fields['t_prenom']));
        
        $this->adresse = $adresse;
    }

}
