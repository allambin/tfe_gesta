<?php

use Orm\Model;

class Model_Checklist_Valeur extends Model
{
    
    protected static $_primary_key = array('id_checklist_valeur');
    
    protected static $_properties = array(
        'id_checklist_valeur',
        't_nom',
        'section_id',
    );
    protected static $_table_name = 'checklist_valeur';

    protected static $_belongs_to = array(
        'section' => array(
            'key_from' => 'section_id',
            'model_to' => 'Model_Checklist_Section',
            'key_to' => 'id_checklist_section',
            'cascade_save' => true,
            'cascade_delete' => false,
        )
    );
    
    public static function validate($factory)
    {
        $val = Validation::forge($factory);
        $val->add_field('t_nom', 'Tnom', 'required|max_length[255]');
        $val->add_field('section_id', 'Section', 'required|valid_string[numeric]');

        return $val;
    }

    public static function getCount($id)
    {
        $res = DB::select()->from('checklist_valeur')->where('section_id', '=', $id)->execute();

        return DB::count_last_query();
    }
    

}
