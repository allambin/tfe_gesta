<?php

class Model_Listeattente extends \Orm\Model {

    protected static $_primary_key = array('id_liste_attente');
    protected static $_table_name = 'liste_attente';
    protected static $_properties = array(
        'id_liste_attente',
        't_nom' => array(
            'data_type' => 'text',
            'label' => 'Nom',
            'validation' => array('required', 'max_length'=>array(255))
        ),
        't_prenom' => array(
            'data_type' => 'text',
            'label' => 'Prénom',
            'validation' => array('required', 'max_length'=>array(255))
        ),
        'd_date_naissance' => array(
            'data_type' => 'text',
            'label' => 'Date de naissance',
            'validation' => array('required', 'valid_date[dd-mm-YYY]', 'isMajeur')
        ),
        'd_date_entretien' => array(
            'data_type' => 'text',
            'label' => 'Date de l\'entretien',
            'validation' => array('valid_date[dd-mm-YYY]')
        ),
        't_contact' => array(
            'data_type' => 'text',
            'label' => 'Contact',
            'validation' => array('max_length'=>array(255))
        ),
        'b_is_actif' => array(
            'data_type' => 'text',
            'label' => 'Est actif',
            'validation' => array(),
            'form' => array(
                'type' => false, // this prevents this field from being rendered on a form
            ),
        ),
        'groupe_id' => array(
            'data_type' => 'text',
            'label' => 'Groupe',
            'validation' => array(),
            'form' => array(
                'type' => false,
            ),
        ),
        'adresse_id' => array(
            'data_type' => 'text',
            'label' => 'Adresse',
            'validation' => array(),
            'form' => array(
                'type' => false,
            ),
        )
    );
    
    protected static $_observers = array(
        'Observer_Logging' => array(
            'events' => array('after_insert', 'after_update', 'after_delete'), 
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
    
    protected static $_observers = array(
        'Observer_Logging' => array(
            'events' => array('after_insert', 'after_update', 'after_delete'), 
        ),
        'Observer_Delete' => array(
            'events' => array('before_delete'), 
        )
    );
    
    protected static $_belongs_to = array(
        'adresse' => array(
            'key_from' => 'adresse_id',
            'model_to' => 'Model_Adresse',
            'key_to' => 'id_adresse',
            'cascade_save' => true,
            'cascade_delete' => false,
        ),
        'groupe' => array(
            'key_from' => 'groupe_id',
            'model_to' => 'Model_Groupe',
            'key_to' => 'id_groupe',
            'cascade_save' => true,
            'cascade_delete' => false,
        )
    );
    
    protected static $_many_many = array(
        'checklist' => array(
            'key_from' => 'id_liste_attente',
            'key_through_from' => 'stagiaire_id',
            'table_through' => 'checklist_stagiaire',
            'key_through_to' => 'valeur_id',
            'model_to' => 'Model_Checklist_Valeur',
            'key_to' => 'id_checklist_valeur',
            'cascade_save' => true,
            'cascade_delete' => false,
        )
    );
    
    /**
     * Remplit les champs de l'objet avec le tableau passé en paramètre
     * 
     * @param array $fields
     */
    public function set_massive_assigment($fields)
    {
        // Transformation de la date de naissance
        $dob = ($fields['d_date_naissance'] != NULL) ? date('Y/m/d', strtotime($fields['d_date_naissance'])) : NULL;
        $de = ($fields['d_date_entretien'] != NULL) ? date('Y/m/d', strtotime($fields['d_date_entretien'])) : NULL;
        // Modification des attributs de l'objet participant
        $this->t_nom = strtoupper(\Cranberry\MySanitarization::filterAlpha(\Cranberry\MySanitarization::stripAccents($fields['t_nom'])));
        $this->t_prenom = \Cranberry\MySanitarization::ucFirstAndToLower(\Cranberry\MySanitarization::filterAlpha($fields['t_prenom']));
        $this->d_date_naissance = $dob;
        $this->d_date_entretien = $de;
        $this->t_contact = $fields['t_contact'];
        $this->groupe_id = $fields['groupe_id'];
        $this->b_is_actif = 1;
    }
    
}
