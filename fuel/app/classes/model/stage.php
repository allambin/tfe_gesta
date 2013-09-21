<?php

use Orm\Model;

class Model_Stage extends Orm\Model
{
    protected static $_primary_key = array('id_stage');
    protected static $_table_name = 'stage';
    
    protected static $_properties = array(
        'contrat_id',
        'societe_id',
        'lieu_stage_id',
        'responsable_interne_id',
        'id_stage',
        't_finalite',
        'd_dateDebutStage',
        't_duree_stage',
        'd_dateFinStage',
        't_horaire_stage',
        't_typeStage',
        'd_contrat_stage',
        't_metier_stage',
        't_activite_stage',
        't_criteres_stage'
    );
}