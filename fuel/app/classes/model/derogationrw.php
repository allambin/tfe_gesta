<?php

use Orm\Model;

class Model_Derogationrw extends Orm\Model {

    protected static $_primary_key = array('id_derogation_rw');
    protected static $_table_name = 'derogation_rw';


    protected static $_properties = array(
        'contrat',
        'id_derogation_rw',
        'b_necessaire',
        'd_dateDemande',
        'b_reponse_forem',
        'd_date_demande_forem',
        'b_reponse_rw',
        'b_dispense_onem',
        'd_date_demande_onem',
        'd_date_reponse_onem',
        't_passe_professionnel',
        't_ressource',
        't_connaissance_eft'
    );

    public static function validate($factory) {
        $val = Validation::forge($factory);
        return $val;
    }

}
