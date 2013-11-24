<?php

use Orm\Model;

class Model_Contrat extends Orm\Model
{


    protected static $_primary_key = array('id_contrat');
    protected static $_table_name = 'contrat';
    protected static $_properties = array(
        'id_contrat',
        'i_temps_travail',
        'd_date_debut_contrat',
        'd_date_fin_contrat',
        'd_date_fin_contrat_prevu',
        't_remarque',
        'f_frais_deplacement',
        't_duree_innoccupation',
        'b_derogation_rw',
        't_abonnement',
        'f_tarif_horaire',
        't_situation_sociale',
        'd_avertissement1',
        'd_avertissement2',
        'd_avertissement3',
        't_motif_avertissement1',
        't_motif_avertissement2',
        't_motif_avertissement3',
        'd_date_demande_derogation_rw',
        't_connaissance_eft',
        't_ressource',
        't_passe_professionnel',
        'd_date_reponse_onem',
        'd_date_demande_onem',
        'b_dispense_onem',
        'b_reponse_rw',
        'd_date_demande_forem',
        'b_reponse_forem',
        'b_necessaire',
        'groupe_id',
        'participant_id',
        'type_contrat_id'
    );
    
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

    public static function validate($factory)
    {
        $val = Validation::forge($factory);
        $val->add_callable('MaitrePylos\validation');
        //$val->add_field('i_temps_travail', 'Temps de Travail', 'required|max_length[3]|exceeds_onehundred');

        return $val;
    }

    public static function getTempTravail($id)
    {

        $heures = DB::select('i_heures')
            ->from('type_contrat')
            ->where('id_type_contrat', $id)
            ->execute();
        return $heures->as_array();

    }

    public static function getContrat()
    {

        //$contrat =  DB::select('SELECT * FROM type_contrat tc INNER JOIN subside s ON s.id_subside = tc.subside',DB::SELECT)->execute();
        //return $contrat->as_array();

        return DB::select()->from('type_contrat')->join('subside', 'INNER')
            ->on('subside.id_subside', '=', 'type_contrat.subside_id')->order_by('i_position', 'asc')->execute();

    }


}