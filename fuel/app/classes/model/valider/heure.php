<?php

use Orm\Model;

class Model_Valider_Heure extends Orm\Model {

    protected static $_primary_key = array('id_valider_heure');
    protected static $_table_name = 'valider_heure';
    protected static $_properties = array(
        'id_valider_heure',
        't_mois',
        'i_secondes',
        'participant_id',
    );



}

?>
