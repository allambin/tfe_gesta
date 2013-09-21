<?php

use Orm\Model;

class Model_Centre extends Model
{

    protected static $_primary_key = array('id_centre');
    protected static $_table_name = 'centre';
    protected static $_properties = array(
        'id_centre',
        't_responsable',
        't_statut',
        't_denomination',
        't_nom_centre',
        't_objet_social',
        't_agregation',
        't_agence',
        't_adresse',
        't_code_postal',
        't_localite',
        't_telephone',
        't_email',
        't_tva',
        't_enregistrement',
        //'t_agrement',
        't_responsable_pedagogique',
        't_secretaire',
        'i_position',
    );

    public static function validate($factory)
    {
        $val = Validation::forge($factory);
        $val->add_field('t_responsable', 'Responsable', 'required|max_length[255]');
        $val->add_field('t_statut', 'Statut', 'max_length[50]');
        $val->add_field('t_denomination', 'Dénomination', 'max_length[255]');
        $val->add_field('t_nom_centre', 'Nom du centre', 'required|max_length[255]');
        $val->add_field('t_objet_social', 'Objet social', 'max_length[255]');
        $val->add_field('t_agregation', 'Agrégation', 'max_length[255]');
        $val->add_field('t_agence', 'Agence', 'max_length[255]');
        $val->add_field('t_adresse', 'Adresse', 'max_length[255]');
        $val->add_field('t_localite', 'Localité', 'max_length[120]');
        $val->add_field('t_email', 'Email', 'max_length[255]|valid_email');
        $val->add_field('t_tva', 'TVA', 'max_length[50]');
        $val->add_field('t_enregistrement', 'Enregistrement', 'max_length[50]');
        $val->add_field('t_responsable_pedagogique', 'Responsable pédagogique', 'max_length[255]');
        $val->add_field('t_secretaire', 'Secrétaire', 'max_length[255]');
        $val->add_field('t_code_postal', 'Code postal', 'exact_length[4]');
        $val->add_field('t_telephone', 'Téléphone', 'exact_length[9]');
        
        $val->set_message('required', 'Veuillez remplir le champ :label.');
        $val->set_message('min_length', 'Le champ :label doit faire au moins :param:1 caractères.');
        $val->set_message('max_length', 'Le champ :label doit faire au plus :param:1 caractères.');
        $val->set_message('exact_length', 'Le champ :label doit compter exactement :param:1 caractères.');
        $val->set_message('valid_string', 'Le champ :label ne doit contenir que des chiffres.');
        $val->set_message('valid_email', 'Le champ :label est invalide.');

        return $val;
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
