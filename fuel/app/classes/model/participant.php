<?php

use Orm\Model;

class Model_Participant extends Orm\Model 
{

    protected static $_primary_key = array('id_participant');
    protected static $_table_name = 'participant';

    /**
     * Liaison vers la table Adresse
     * @var type 
     */
    protected static $_has_many = array(
        'adresses' => array(
            'key_from' => 'id_participant',
            'model_to' => 'Model_Adresse',
            'key_to' => 'participant_id',
            'cascade_save' => true,
            'cascade_delete' => true,
        ),
        'contacts' => array(
            'key_from' => 'id_participant',
            'model_to' => 'Model_Contact',
            'key_to' => 'participant_id',
            'cascade_save' => true,
            'cascade_delete' => true,
        )
    );
    
    protected static $_many_many = array(
        'checklist' => array(
            'key_from' => 'id_participant',
            'key_through_from' => 'participant_id',
            'table_through' => 'checklist',
            'key_through_to' => 'valeur_id',
            'model_to' => 'Model_Checklist_Valeur',
            'key_to' => 'id_checklist_valeur',
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
        'id_participant',
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
        't_nationalite' => array(
            'data_type' => 'text',
            'label' => 'Nationalité',
            'validation' => array(),
            'form' => array('type' => 'select', 'options' => array())
        ),
        't_lieu_naissance' => array(
            'data_type' => 'text',
            'label' => 'Lieu de naissance',
            'validation' => array('required', 'checkdate', '')
        ),
        'd_date_naissance' => array(
            'data_type' => 'text',
            'label' => 'Date de naissance',
            'validation' => array('required', 'checkdate', 'isMajeur')
        ),
        't_sexe' => array(
            'data_type' => 'text',
            'label' => 'Sexe',
            'validation' => array(),
            'form' => array('type' => 'select', 'options' => array('' => '', 'M' => 'Homme', 'F' => 'Femme'))
        ),
        't_type_etude' => array(
            'data_type' => 'text',
            'label' => 'Type d\'études',
            'validation' => array(),
            'form' => array('type' => 'select', 'options' => array() )
        ),
        't_diplome' => array(
            'data_type' => 'text',
            'label' => 'Diplômes',
            'validation' => array(),
            'form' => array('type' => 'select', 'options' => array() )
        ),
        'd_fin_etude' => array(
            'data_type' => 'text',
            'label' => 'Fin des études',
            'validation' => array('required', 'max_length'=>array(255))
        ),
        't_annee_etude' => array(
            'data_type' => 'text',
            'label' => 'Année d\'étude',
            'validation' => array('required', 'max_length'=>array(255))
        ),
        't_etat_civil' => array(
            'data_type' => 'text',
            'label' => 'Etat civil',
            'validation' => array(),
            'form' => array('type' => 'select', 'options' => array('' => '', 'Célibataire' => 'Célibataire', 'Marié(e)' => 'Marié(e)', 'Veuf(ve)' => 'Veuf(ve)'))
        ),
        't_registre_national' => array(
            'data_type' => 'text',
            'label' => 'Registre national',
            'validation' => array('registreNational')
        ),
        't_compte_bancaire' => array(
            'data_type' => 'text',
            'label' => 'Compte bancaire',
            'validation' => array('compteBancaire')
        ),
        't_pointure' => array(
            'data_type' => 'text',
            'label' => 'Pointure',
            'validation' => array('required', 'max_length'=>array(255))
        ),
        't_taille' => array(
            'data_type' => 'text',
            'label' => 'Taille',
            'validation' => array('max_length' => array(3), 'valid_string'=>array('numeric'))
        ),
        't_enfants_charge' => array(
            'data_type' => 'text',
            'label' => 'Enfants à charge',
            'validation' => array(),
            'form' => array('type' => 'select', 'options' => array('' => '', 'Oui' => 'Oui', 'Non' => 'Non'))
        ),
        't_mutuelle' => array(
            'data_type' => 'text',
            'label' => 'Mutuelle',
            'validation' => array('required', 'max_length'=>array(255))
        ),
        't_organisme_paiement' => array(
            'data_type' => 'select',
            'label' => 'Organisme de paiement',
            'validation' => array(),
            'form' => array('type' => 'select', 'options' => array('' => '', 'CAPAC' => 'CAPAC', 'FGTB' => 'FGTB', 'CSC' => 'CSC', 'CGLSB' => 'CGLSB'))
        ),
        't_organisme_paiement_phone' => array(
            'data_type' => 'text',
            'label' => 'Organisme de paiement (téléphone)',
            'validation' => array('exact_length' => array(9), 'valid_string'=>array('numeric'))
        ),
        't_permis' => array(
            'data_type' => 'text',
            'label' => 'Permis',
            'validation' => array('required', 'max_length'=>array(255))
        ),
        't_moyen_transport' => array(
            'data_type' => 'text',
            'label' => 'Moyen de transport',
            'validation' => array(),
            'form' => array('type' => 'select', 'options' => array('' => '', 'TEC' => 'Transports en commun', 'Voiture/scooter/vélo' => 'Voiture/scooter/vélo', 'Rien' => 'Rien'))
        ),
        'i_frais_stagiaire' => array(
            'data_type' => 'text',
            'label' => 'Frais de stagiaire',
            'validation' => array('required', 'max_length'=>array(255))
        ),
        'd_date_inscription_onem' => array(
            'data_type' => 'text',
            'label' => 'Date d\'inscription ONEM',
            'validation' => array('required', 'max_length'=>array(255))
        ),
        'd_date_fin_stage_onem' => array(
            'data_type' => 'text',
            'label' => 'Date de fin du stage ONEM',
            'validation' => array('required', 'max_length'=>array(255))
        ),
        't_numero_inscription_onem' => array(
            'data_type' => 'text',
            'label' => 'Numéro d\'inscription ONEM',
            'validation' => array('required', 'max_length'=>array(255))
        ),
        'd_date_expiration_carte_sejour' => array(
            'data_type' => 'text',
            'label' => 'Date d\'expiration de la carte de séjour',
            'validation' => array('required', 'max_length'=>array(255))
        ),
        'd_date_examen_medical' => array(
            'data_type' => 'text',
            'label' => 'Date de l\'examen médical',
            'validation' => array('required', 'max_length'=>array(255))
        ),
        't_lieu_examen_medical' => array(
            'data_type' => 'text',
            'label' => 'Lieu de l\'examen médical',
            'validation' => array('required', 'max_length'=>array(255))
        ),
        'i_identification_bob' => array(
            'data_type' => 'text',
            'label' => 'Identification Bob',
            'validation' => array('required', 'max_length'=>array(255))
        ),
        't_gsm' => array(
            'data_type' => 'text',
            'label' => 'Numéro de GSM',
            'validation' => array('exact_length' => array(10), 'valid_string'=>array('numeric'))
        ),
        't_gsm2' => array(
            'data_type' => 'text',
            'label' => 'Numéro de GSM (2)',
            'validation' => array('exact_length' => array(10), 'valid_string'=>array('numeric'))
        ),
        't_numero_inscription_forem' => array(
            'data_type' => 'Numéro d\'inscription FOREM',
            'label' => 'Nom',
            'validation' => array('required', 'max_length'=>array(255))
        ),
        'd_date_inscription_forem' => array(
            'data_type' => 'text',
            'label' => 'Date d\'inscription FOREM',
            'validation' => array('required', 'max_length'=>array(255))
        ),
        'b_attestation_reussite' => array(
            'data_type' => 'text',
            'label' => 'Attestation de réussite',
            'validation' => array('required', 'max_length'=>array(255))
        ),
        'b_is_actif' => array(
            'data_type' => 'text',
            'label' => 'Est actif',
            'validation' => array('required', 'max_length'=>array(255)),
            'form' => array(
                'type' => false, // this prevents this field from being rendered on a form
            ),
        ),
        'd_date_permis_theorique' => array(
            'data_type' => 'text',
            'label' => 'Date du permis théoriqe',
            'validation' => array('required', 'max_length'=>array(255))
        ),
        't_email' => array(
            'data_type' => 'text',
            'label' => 'Email',
            'validation' => array('required', 'max_length'=>array(255))
        ),
        't_children' => array(
            'data_type' => 'text',
            'label' => 'Nom',
            'validation' => array('required', 'max_length'=>array(255)),
            'form' => array(
                'type' => false, // this prevents this field from being rendered on a form
            ),
        ),
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
     * Remplit les champs de l'objet avec le tableau passé en paramètre
     * 
     * @param array $fields
     */
    public function set_massive_assigment($fields, $scenario = null)
    {
        // Transformation de la date de naissance
        $dob = ($fields['d_date_naissance'] != NULL) ? date('Y/m/d', strtotime($fields['d_date_naissance'])) : NULL;
        // Modification des attributs de l'objet participant
        $this->t_nom = strtoupper(\Cranberry\MySanitarization::filterAlpha(\Cranberry\MySanitarization::stripAccents($fields['t_nom'])));
        $this->t_prenom = \Cranberry\MySanitarization::ucFirstAndToLower(\Cranberry\MySanitarization::filterAlpha($fields['t_prenom']));
        $this->t_nationalite = $fields['t_nationalite'];
        $this->t_lieu_naissance = \Cranberry\MySanitarization::ucFirstAndToLower($fields['t_lieu_naissance']);
        $this->d_date_naissance = $dob;
        $this->t_sexe = $fields['t_sexe'];
        // Transformation du registre national
        $registre = null;
        if(isset($fields['t_registre_national']))
            $registre = \Cranberry\MySanitarization::filterRegistreNational($fields['t_registre_national']);
        $this->t_registre_national = $registre;
        
        if($scenario != 'eid')
        {
            $this->t_gsm = $fields['t_gsm'];
            $this->t_gsm2 = $fields['t_gsm2'];
            $this->t_email = $fields['t_email'];
            $this->t_etat_civil = $fields['t_etat_civil'];
            $this->t_moyen_transport = $fields['t_moyen_transport'];
            $this->t_pointure = $fields['t_pointure'];
            $this->t_taille = $fields['t_taille'];

            // Transformation du compte bancaire
            $compte = null;
            if(isset($fields['t_compte_bancaire']))
                $compte = \Cranberry\MySanitarization::filterCompteBancaire($fields['t_compte_bancaire']);
            $this->t_compte_bancaire = $compte;
        }
        
        if($scenario == 'update')
        {
            $children = isset($fields['t_children']) ? $fields['t_children'] : '' ;
            if($fields['t_enfants_charge'] == 'Non' || $fields['t_enfants_charge'] == '')
                $children = "";
            if(!empty($children))
                $children = implode (";", $children);
            // Transformation de la date de fin d'études
            $dfe = ($fields['d_fin_etude'] != NULL) ? date('Y/m/d', strtotime($fields['d_fin_etude'])) : NULL;
            // Transformation de la date du permis théorique
            $dpt = ($fields['d_date_permis_theorique'] != NULL) ? date('Y/m/d', strtotime($fields['d_date_permis_theorique'])) : NULL;

            // Transformation du permis
            $permis = null;
            if(isset($fields['t_permis']))
                $permis = implode(',', $fields['t_permis']);
            
            $this->t_type_etude = $fields['t_type_etude'];
            $this->t_diplome = $fields['t_diplome'];
            $this->d_fin_etude = $dfe;
            $this->t_annee_etude = $fields['t_annee_etude'];
            $this->t_enfants_charge = $fields['t_enfants_charge'];
            $this->t_mutuelle = $fields['t_mutuelle'];
            $this->t_organisme_paiement = $fields['t_organisme_paiement'];
            $this->t_organisme_paiement_phone = $fields['t_organisme_paiement_phone'];
            $this->t_permis = $permis;
            if(isset($fields['b_attestation_reussite']))
                $this->b_attestation_reussite = $fields['b_attestation_reussite'];
            $this->d_date_permis_theorique = $dpt;
            $this->t_children = $children;

            // checklist
            \DB::delete('checklist')->where('participant_id', '=', $this->id_participant)->execute();

            if(isset($fields['liste']))
            {
                $checklist = $fields['liste'];
                foreach ($checklist as $value)
                {
                    $v = \Model_Checklist_Valeur::find($value);
                    $this->checklist[] = $v;
                }
            }
        }
    }
    
    /**
     * Vérifie si l'utilisateur existe, via un tryptique nom - prénom - dob
     * 
     * @param string $nom
     * @param string $prenom
     * @param string $dob
     * @param bool $actif
     * @return bool
     */
    public static function exists($nom, $prenom, $dob, $actif)
    {
        $query = Model_Participant::query()->where(array('t_nom' => $nom, 't_prenom' => $prenom, 'd_date_naissance' => $dob, 'b_is_actif' => $actif));
        return ($query->count() > 0) ? true : false;
    }

}
