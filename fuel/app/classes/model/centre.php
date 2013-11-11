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

//    public static function validate($factory)
//    {
//        $val = Validation::forge($factory);
//        $val->add_field('t_responsable', 'Responsable', 'required|max_length[255]');
//        $val->add_field('t_statut', 'Statut', 'max_length[50]');
//        $val->add_field('t_denomination', 'Dénomination', 'max_length[255]');
//        $val->add_field('t_nom_centre', 'Nom du centre', 'required|max_length[255]');
//        $val->add_field('t_objet_social', 'Objet social', 'max_length[255]');
//        $val->add_field('t_agregation', 'Agrégation', 'max_length[255]');
//        $val->add_field('t_agence', 'Agence', 'max_length[255]');
//        $val->add_field('t_adresse', 'Adresse', 'max_length[255]');
//        $val->add_field('t_localite', 'Localité', 'max_length[120]');
//        $val->add_field('t_email', 'Email', 'max_length[255]|valid_email');
//        $val->add_field('t_tva', 'TVA', 'max_length[50]');
//        $val->add_field('t_enregistrement', 'Enregistrement', 'max_length[50]');
//        $val->add_field('t_responsable_pedagogique', 'Responsable pédagogique', 'max_length[255]');
//        $val->add_field('t_secretaire', 'Secrétaire', 'max_length[255]');
//        $val->add_field('t_code_postal', 'Code postal', 'exact_length[4]');
//        $val->add_field('t_telephone', 'Téléphone', 'exact_length[9]');
//        
//        $val->set_message('required', 'Veuillez remplir le champ :label.');
//        $val->set_message('min_length', 'Le champ :label doit faire au moins :param:1 caractères.');
//        $val->set_message('max_length', 'Le champ :label doit faire au plus :param:1 caractères.');
//        $val->set_message('exact_length', 'Le champ :label doit compter exactement :param:1 caractères.');
//        $val->set_message('valid_string', 'Le champ :label ne doit contenir que des chiffres.');
//        $val->set_message('valid_email', 'Le champ :label est invalide.');
//
//        return $val;
//    }

    public static function get_centre(){

        $query = \DB::select('id_centre','t_nom_centre')->from('centre')->execute();
        return $query;

    }
    public static function get_centre_names($id){

        $query = \DB::select('t_nom_centre')->from('centre')->where('id_centre','=',$id)->execute();
        return $query;

    }

}
