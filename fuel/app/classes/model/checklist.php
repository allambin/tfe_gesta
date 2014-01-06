<?php

use Orm\Model;

/**
 * @todo : delete
 */
class Model_Checklist extends Orm\Model
{

    protected static $_primary_key = array('id_checklist');
    protected static $_table_name = 'checklist';
    protected static $_properties = array(
        'id_checklist',
        'participant_id',
        'stagiaire_id',
        't_liste',
    );
    
    protected static $_belongs_to = array(
        'participant' => array(
            'key_from' => 'participant_id',
            'model_to' => 'Model_Participant',
            'key_to' => 'id_participant',
            'cascade_save' => true,
            'cascade_delete' => false,
        )
    );
    
    protected static $_many_many = array(
        'valeurs' => array(
            'key_from' => 'id_checklist',
            'key_through_from' => 'checklist_id',
            'table_through' => 'checklist_rel_valeur',
            'key_through_to' => 'valeur_id',
            'model_to' => 'Model_Checklist_Valeur',
            'key_to' => 'id_checklist_valeur',
            'cascade_save' => true,
            'cascade_delete' => false,
        )
    );
    
    protected static $_observers = array(
        'Observer_Logging' => array(
            'events' => array('after_insert', 'after_update', 'after_delete'), 
        )
    );
    
    /**
     * Renvoie le nom de la PK (utilisé dans l'administration)
     * 
     * @return string
     */
    public static function get_primary_key_name()
    {
        return self::$_primary_key[0];
    }

}
