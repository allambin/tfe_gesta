<?php

class Model_User extends \Orm\Model 
{
    protected static $list_properties = array('username', 'email', 'group');

//    protected static $_properties = array(
//        'id',
//        'username',
//        'password',
//        'group',
//        'email',
//        'last_login',
//        'login_hash',
//        'profile_fields',
//        'is_actif',
//        't_nom',
//        't_prenom',
//        't_acl'
//    );
    
    protected static $_properties = array(
        'id',
        'username' => array( //column name
            'data_type' => 'string',
            'label' => 'Nom d\'utilisateur', //label for the input field
            'validation' => array('required', 'max_length'=>array(100), 'min_length'=>array(5)) //validation rules
        ),
        'password' => array( 
            'data_type' => 'password',
            'label' => 'Mot de passe',
            'validation' => array('required', 'max_length'=>array(100), 'min_length'=>array(4)),
            'form' => array('type' => 'password')
        ),
        'group' => array( 
            'data_type' => 'string',
            'label' => 'Groupe',
            'validation' => array('required', 'max_length'=>array(100)),
            'form' => array('type' => 'select', 'options' => array())
        ),
        'email' => array( 
            'data_type' => 'string',
            'label' => 'Email',
            'validation' => array('required', 'max_length'=>array(255)) //validation rules
        ),
        'last_login' => array( 
            'form' => array(
                'type' => false, // this prevents this field from being rendered on a form
            ),
        ),
        'login_hash' => array( 
            'form' => array(
                'type' => false, // this prevents this field from being rendered on a form
            ),
        ),
        'profile_fields' => array( 
            'form' => array(
                'type' => false, // this prevents this field from being rendered on a form
            ),
        ),
        'is_actif' => array( 
            'form' => array(
                'type' => false,
            ),
        ),
        't_prenom'=> array(
            'data_type' => 'string',
            'label' => 'Prénom',
            'validation' => array('required', 'max_length'=>array(100)) 
        ),
        't_nom' => array(
            'data_type' => 'string',
            'label' => 'Nom',
            'validation' => array('required', 'max_length'=>array(100)) 
        ),
        't_acl' => array( 
            'form' => array(
                'type' => false,
            ),
        )
    );
    
    protected static $_has_many = array(
        'groupes' => array(
            'key_from' => 'id',
            'model_to' => 'Model_Groupe',
            'key_to' => 'login_id',
            'cascade_save' => true,
            'cascade_delete' => true,
        )
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
    
//    public static function validate($factory, $required_password = true) 
//    {
//        $val = Validation::forge($factory);
//
//        $val->add_callable('\Cranberry\MyValidation');
//        $val->add_field('username', 'Login', 'required');        
//        if($required_password)
//            $val->add_field('password', 'Mot de passe', 'required');
//        
//        $val->set_message('required', 'Veuillez remplir le champ :label.');
//
//        return $val;
//    }

//    public static function get_users()
//    {
//
//        $query = \DB::select('id', 'username')->from('users')->execute();
//        return $query;
//
//    }
    
    public static function get_list_properties()
    {
        $to_return = array();
        foreach (self::$list_properties as $value)
            $to_return[$value] = self::$_properties[$value];
        
        return $to_return;
    }
    
    public function set_massive_assigments($fields)
    {
        $this->username = $fields['username'];
        $this->password = \Auth::instance()->hash_password($fields['password']);
        $this->group = $fields['group'];
        $this->last_login = 0;
        $this->login_hash = $fields['username'];
        $this->profile_fields = 'a:0:{}';
        $this->is_actif = 1;
        $this->t_nom = $fields['t_nom'];
        $this->t_prenom = $fields['t_prenom'];
        $this->t_acl = $fields['t_acl'];
    }
    
    public static function _init()
    {
        $groups = \Config::get('simpleauth');
        $groups = $groups['groups'];

        foreach ($groups as $key => $g)
        {
//            group
            $data[$key] = $g['name'];
        }

        static::$_properties['group']['form']['options'] = $data;
    }

}
