<?php

class Model_User extends \Orm\Model 
{
    protected static $list_properties = array('username', 'email', 'group');
    
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
    
    /**
     * Renvoie le nom de la PK (utilisé dans les observers)
     * 
     * @return string
     */
    public static function get_primary_key_name()
    {
        return self::$_primary_key[0];
    }
    
    /**
     * Renvoie le tableau $list_properties, utilisé dans l'administration
     * 
     * @return array
     */
    public static function get_list_properties()
    {
        $to_return = array();
        foreach (self::$list_properties as $value)
            $to_return[$value] = self::$_properties[$value];
        
        return $to_return;
    }
    
    /**
     * Remplit les champs de l'objet avec le tableau passé en paramètre
     * 
     * @param array $fields
     */
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
    
    /**
     * Permet de remplir les champs select depuis un autre Model
     */
    public static function _init()
    {
        $groups = \Config::get('simpleauth');
        $groups = $groups['groups'];

        foreach ($groups as $key => $g)
        {
            $data[$key] = $g['name'];
        }

        static::$_properties['group']['form']['options'] = $data;
    }

}
