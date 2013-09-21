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
    protected static $_has_one = array(
        'checklist' => array(
            'key_from' => 'id_participant',
            'model_to' => 'Model_Checklist',
            'key_to' => 'participant_id',
            'cascade_save' => true,
            'cascade_delete' => true,
        )
    );
    protected static $_properties = array(
        'id_participant',
        't_nom',
        't_prenom',
        't_nationalite',
        't_lieu_naissance',
        'd_date_naissance',
        't_sexe',
        't_type_etude',
        't_diplome',
        'd_fin_etude',
        't_annee_etude',
        't_etat_civil',
        't_registre_national',
        't_compte_bancaire',
        't_pointure',
        't_taille',
        't_enfants_charge',
        't_mutuelle',
        't_organisme_paiement',
        't_organisme_paiement_phone',
        't_permis',
        't_moyen_transport',
        'i_frais_stagiaire',
        'd_date_inscription_onem',
        'd_date_fin_stage_onem',
        't_numero_inscription_onem',
        'd_date_expiration_carte_sejour',
        'd_date_examen_medical',
        't_lieu_examen_medical',
        'i_identification_bob',
        't_gsm',
        't_gsm2',
        't_numero_inscription_forem',
        'd_date_inscription_forem',
        'b_attestation_reussite',
        'b_is_actif',
        'd_date_permis_theorique',
        't_email',
        't_children',
    );

    public static function validate($factory) 
    {
        $val = Validation::forge($factory);

        $val->add_callable('\Cranberry\MyValidation');

        $val->add_field('t_nom', 'Nom', 'required|max_length[50]');
        $val->add_field('t_prenom', 'Prénom', 'required|max_length[50]');
        $val->add_field('t_registre_national', 'Registre national', 'registreNational');
        $val->add_field('t_compte_bancaire', 'Compte bancaire', 'compteBancaire');
        $val->add_field('t_gsm', 'GSM', 'exact_length[10]|valid_string[numeric]');
        $val->add_field('t_gsm2', 'GSM', 'exact_length[10]|valid_string[numeric]');
        $val->add_field('t_organisme_paiement_phone', 'Téléphone de l\'orgasnime', 'exact_length[9]|valid_string[numeric]');
        $val->add_field('t_taille', 'Taille', 'max_length[3]|valid_string[numeric]');
        $val->add_field('d_date_naissance', 'Date de naissance', 'required|checkdate|isMajeur');
        $val->add_field('t_email', 'Email', 'valid_email');
        $val->add_field('t_children', 'Enfants à charge', 'childrenData');

        $val->set_message('required', 'Veuillez remplir le champ :label.');
        $val->set_message('min_length', 'Le champ :label doit faire au moins :param:1 caractères.');
        $val->set_message('max_length', 'Le champ :label doit faire au plus :param:1 caractères.');
        $val->set_message('exact_length', 'Le champ :label doit compter exactement :param:1 caractères.');
        $val->set_message('valid_string', 'Le champ :label ne doit contenir que des chiffres.');
        $val->set_message('valid_email', 'Le champ :label est invalide.');
        
        return $val;
    }
    
    public static function exists($nom, $prenom, $dob, $actif)
    {
        $query = Model_Participant::query()->where(array('t_nom' => $nom, 't_prenom' => $prenom, 'd_date_naissance' => $dob, 'b_is_actif' => $actif));
        return ($query->count() > 0) ? true : false;
    }

}
