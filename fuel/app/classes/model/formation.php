<?php

use Orm\Model;

class Model_Formation extends Model
{
    
    protected static $_primary_key = array('id_formation');
    protected static $_table_name = 'formation';



    protected static $_properties = array(
        'id_formation',
        'd_date_fin_formation',
        't_fin_formation',
        't_fin_formation_suite',
        'contrat_id',
    );
    
//    protected static $_belongs_to = array(
//        'contrat' => array(
//            'key_from' => 'contrat_id',
//            'model_to' => 'Model_contrat',
//            'key_to' => 'id_contrat',
//            'cascade_save' => true,
//            'cascade_delete' => false,
//        ),
//    );


}
