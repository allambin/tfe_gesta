<?php
use Orm\Model;

class Model_Type_Contact extends Model
{
    protected static $_primary_key = array('id_type_contact');
    protected static $_table_name = 'type_contact';
    
//    protected static $_has_many = array(
//        'contact' => array(
//            'key_from' => 'id_type_contact',
//            'model_to' => 'Model_Contact',
//            'key_to' => 'typecontact',
//            'cascade_save' => false,
//            'cascade_delete' => false,
//        )
//    );
    
	protected static $_properties = array(
		'id_type_contact',
		't_type_contact',
	);
        
        public static function getNames()
        {
            return DB::select('t_typecontact')->from('type_contact')->execute();
        }

        public static function validate($factory) 
        {
            $val = Validation::forge($factory);
            $val->add_field('t_typecontact', 'Type', 'required');

            return $val;
        }

}
