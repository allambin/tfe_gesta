<?php

use Orm\Model;

class Model_Centre extends Model
{
    protected static $list_properties = array(
        't_responsable',
        't_denomination',
        't_nom_centre'
    );

    protected static $_primary_key = array('id_centre');
    protected static $_table_name = 'centre';
    protected static $_properties = array(
        'id_centre',
        't_responsable' => array(
            'data_type' => 'text',
            'label' => 'Reponsable',
            'validation' => array('required', 'max_length'=>array(255))
        ),
        't_statut' => array(
            'data_type' => 'text',
            'label' => 'Statut',
            'validation' => array('max_length'=>array(50))
        ),
        't_denomination' => array(
            'data_type' => 'text',
            'label' => 'Dénomination',
            'validation' => array('max_length'=>array(255))
        ),
        't_nom_centre' => array(
            'data_type' => 'text',
            'label' => 'Nom du centre',
            'validation' => array('required', 'max_length'=>array(255))
        ),
        't_objet_social' => array(
            'data_type' => 'text',
            'label' => 'Objet social',
            'validation' => array('max_length'=>array(255))
        ),
        't_agregation' => array(
            'data_type' => 'text',
            'label' => 'Agrégation',
            'validation' => array('max_length'=>array(255))
        ),
        't_agence' => array(
            'data_type' => 'text',
            'label' => 'Agence',
            'validation' => array('max_length'=>array(255))
        ),
        't_adresse' => array(
            'data_type' => 'text',
            'label' => 'Adresse',
            'validation' => array('max_length'=>array(255))
        ),
        't_code_postal' => array(
            'data_type' => 'text',
            'label' => 'Code postal',
            'validation' => array('exact_length'=>array(4))
        ),
        't_localite' => array(
            'data_type' => 'text',
            'label' => 'Localité',
            'validation' => array('max_length'=>array(120))
        ),
        't_telephone' => array(
            'data_type' => 'text',
            'label' => 'Téléphone',
            'validation' => array('exact_length' => array(9))
        ),
        't_email' => array(
            'data_type' => 'text',
            'label' => 'Email',
            'validation' => array('valid_email', 'max_length'=>array(255))
        ),
        't_tva' => array(
            'data_type' => 'text',
            'label' => 'TVA',
            'validation' => array('max_length'=>array(50))
        ),
        't_enregistrement' => array(
            'data_type' => 'text',
            'label' => 'Enregistrement',
            'validation' => array('max_length'=>array(50))
        ),
        't_responsable_pedagogique' => array(
            'data_type' => 'text',
            'label' => 'Reponsable pédagogique',
            'validation' => array('max_length'=>array(255))
        ),
        't_secretaire' => array(
            'data_type' => 'text',
            'label' => 'Secrétaire',
            'validation' => array('max_length'=>array(255))
        ),
        'i_position' => array(
            'data_type' => 'text',
            'label' => 'Position',
            'validation' => array('required', 'valid_string'=>array('numeric'))
        ),
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
    public function set_massive_assigment($fields)
    {
        $this->t_responsable = $fields['t_responsable'];
        $this->t_statut = $fields['t_statut'];
        $this->t_denomination = $fields['t_denomination'];
        $this->t_nom_centre = $fields['t_nom_centre'];
        $this->t_objet_social = $fields['t_objet_social'];
        $this->t_agregation = $fields['t_agregation'];
        $this->t_agence = $fields['t_agence'];
        $this->t_adresse = $fields['t_adresse'];
        $this->t_code_postal = $fields['t_code_postal'];
        $this->t_localite = $fields['t_localite'];
        $this->t_telephone = $fields['t_telephone'];
        $this->t_email = $fields['t_email'];
        $this->t_tva = $fields['t_tva'];
        $this->t_enregistrement = $fields['t_enregistrement'];
        $this->t_responsable_pedagogique = $fields['t_responsable_pedagogique'];
        $this->t_secretaire = $fields['t_secretaire'];
        $this->i_position = $fields['i_position'];
    }

    public static function get_centre(){

        $query = \DB::select('id_centre','t_nom_centre')->from('centre')->execute();
        return $query;

    }
    public static function get_centre_names($id){

        $query = \DB::select('t_nom_centre')->from('centre')->where('id_centre','=',$id)->execute();
        return $query;

    }

}
