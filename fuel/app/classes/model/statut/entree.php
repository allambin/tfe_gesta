
<?php

use Orm\Model;

class Model_Statut_Entree extends Model
{

    protected static $list_properties = array('t_nom', 't_valeur', 'i_position');

    protected static $_primary_key = array('id_statut_entree');
    protected static $_table_name = 'statut_entree';
    protected static $_properties = array(
        'id_statut_entree',
        't_nom' => array(
            'data_type' => 'text',
            'label' => 'Nom',
            'validation' => array('required', 'max_length'=>array(255))
        ),
        't_valeur' => array(
            'data_type' => 'text',
            'label' => 'Valeur',
            'validation' => array('required')
        ),
        'i_position' => array(
            'data_type' => 'text',
            'label' => 'Position'
        ),
        'type_statut_id' => array(
            'data_type' => 'text',
            'label' => 'Type de statut',
            'validation' => array('required'),
            'form' => array('type' => 'select', 'options' => array() ),
        ),
    );
    
    protected static $_belongs_to = array(
        'type_statut' => array(
            'key_from' => 'type_statut_id',
            'model_to' => 'Model_Type_Statut',
            'key_to' => 'id_type_statut',
            'cascade_save' => true,
            'cascade_delete' => false,
        ),
    );
    
    protected static $_observers = array(
        'Observer_Logging' => array(
            'events' => array('after_insert', 'after_update', 'after_delete'), 
        )
    );
    
    public static function get_primary_key_name()
    {
        return self::$_primary_key[0];
    }

    public static function _init()
    {
        // doit faire ça pour éviter le bug du "FrozenObject"
        $types = DB::select()->from('type_statut')->as_object()->execute();

        foreach ($types as $t)
            $data[$t->id_type_statut] = $t->t_nom;

        static::$_properties['type_statut_id']['form']['options'] = $data;
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
        $this->t_valeur = $fields['t_valeur'];
        $this->i_position = $fields['i_position'];
        $this->type_statut_id = $fields['type_statut_id'];
    }

//    public static function validate($factory)
//    {
//        $val = Validation::forge($factory);
//        $val->add_field('t_nom', 'Nom', 'required|max_length[255]');
//        $val->add_field('t_valeur', 'Valeur', 'required');
//
//        $val->set_message('required', 'Veuillez remplir le champ :label.');
//        $val->set_message('max_length', 'Le champ :label doit faire au plus :param:1 caractères.');
//
//        return $val;
//    }
    
//    public static function orm_notify(Model $model, $event)
//    {
//        \Log::info('I was notified of the event '.$event.' on a Model of class '.get_class($model));
//    }
//    
//    public static function orm_notify(Model $model, $event)
//    {
//        die("GREEEEUH");
//        \Log::info('I was notified of the event '.$event.' on a Model of class '.get_class($model));
//    }

}
