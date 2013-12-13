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
//    
//    protected static $_many_many = array(
//        'valeurs' => array(
//            'key_from' => 'id_checklist',
//            'key_through_from' => 'valeur_id', // column 1 from the table in between, should match a posts.id
//            'table_through' => 'checklist_rel_valeur', // both models plural without prefix in alphabetical order
//            'key_through_to' => 'checklist_id', // column 2 from the table in between, should match a users.id
//            'model_to' => 'Model_Checklist_Valeur',
//            'key_to' => 'id_checklist_valeur',
//            'cascade_save' => true,
//            'cascade_delete' => false,
//        )
//    );
    
    public static function getList($id)
    {
        $result = \DB::select('*')->from('checklist')->where('stagiaire_id', $id)->as_assoc()->execute();

        $liste = array();
        foreach ($result as $res)
        {
            $liste = $res['t_liste'];
        }
        
        return $liste;
    }
    
    public static function saveParticipant($stagiaireid, $participantid)
    {
        \Fuel\Core\DB::update('checklist')
                ->set(array(
                    'participant' => $participantid
                ))
                ->where('stagiaire_id', '=', $stagiaireid)->execute();
    }

}
