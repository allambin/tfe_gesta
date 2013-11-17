<?php

use Orm\Model;

class Model_Checklist_Section extends Model
{

    protected static $list_properties = array('t_nom');
    protected static $_primary_key = array('id_checklist_section');
    
    protected static $_properties = array(
        'id_checklist_section',
        't_nom' => array(
            'data_type' => 'text',
            'label' => 'Nom',
            'validation' => array('required', 'max_length'=>array(255)) //validation rules
        ),
    );
    protected static $_table_name = 'checklist_section';

    protected static $_has_many = array(
        'valeurs' => array(
            'key_from' => 'id_checklist_section',
            'model_to' => 'Model_Checklist_Valeur',
            'key_to' => 'section_id',
            'cascade_save' => true,
            'cascade_delete' => false,
        )
    );
    
    public static function get_primary_key_name()
    {
        return self::$_primary_key[0];
    }
    
    public static function get_list_properties()
    {
        $to_return = array();
        foreach (self::$list_properties as $value)
            $to_return[$value] = self::$_properties[$value];
        
        return $to_return;
    }
    
    public function set_massive_assigment($fields)
    {
        $this->t_nom = $fields['t_nom'];
    }
    
//    public static function validate($factory)
//    {
//        $val = Validation::forge($factory);
//        $val->add_field('t_nom', 'Nom', 'required|max_length[255]');
//
//        $val->set_message('required', 'Veuillez remplir le champ :label.');
//        
//        return $val;
//    }
    
    public static function getAsSelect()
    {
        $o_sections = \Model_Checklist_Section::find('all');
        $sections = array();

        foreach ($o_sections as $section)
        {
            $sections[$section->id_checklist_section] = $section->t_nom;
        }
        
        return $sections;
    }
    
    public static function getAsArray()
    {
        $result = \DB::select('*')->from('checklist_section')->as_assoc()->execute();

        $liste = array();
        foreach ($result as $res)
        {
            $liste[$res['id_checklist_section']] = $res['t_nom'];
        }
        
        return $liste;
    }

}
