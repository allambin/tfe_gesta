<?php

use Orm\Model;

class Model_Heures_Prestation extends Orm\Model
{
    protected static $_primary_key = array('id_heures_prestations');

    protected static $_properties = array(
        'id_heures_prestations',
        'annee',
        'janvier',
        'fevrier',
        'mars',
        'avril',
        'mai',
        'juin',
        'juillet',
        'aout',
        'septembre',
        'octobre',
        'novembre',
        'decembre',
        'jours_janvier',
        'jours_fevrier',
        'jours_mars',
        'jours_avril',
        'jours_mai',
        'jours_juin',
        'jours_juillet',
        'jours_aout',
        'jours_septembre',
        'jours_octobre',
        'jours_novembre',
        'jours_decembre',
        'groupe_id'
    );

    protected static $_table_name = 'heures_prestations';

    public static function validate_heures($factory, $id_groupe)
    {
        $val = Validation::forge($factory);
        $val->add_callable('\MaitrePylos\Validation');

        if ($factory == "create") {
            $val->add_callable('\Cranberry\MyValidation');
            $val->add_field('annee', 'Année', 'required|exact_length[4]|valid_string[numeric]|unique_annee[' . $id_groupe . ']');
        } else if ($factory == "edit") {
            $val->add_field('annee', 'Année', 'required|exact_length[4]|valid_string[numeric]');
        }

        $val->add_field('janvier', 'Janvier', 'required|bland_hour');
        $val->add_field('fevrier', 'Février', 'required|bland_hour');
        $val->add_field('mars', 'Mars', 'required|bland_hour');
        $val->add_field('avril', 'Avril', 'required|bland_hour');
        $val->add_field('mai', 'Mai', 'required|bland_hour');
        $val->add_field('juin', 'Juin', 'required|bland_hour');
        $val->add_field('juillet', 'Juillet', 'required|bland_hour');
        $val->add_field('aout', 'Août', 'required|bland_hour');
        $val->add_field('septembre', 'Septembre', 'required|bland_hour');
        $val->add_field('octobre', 'Octobre', 'required|bland_hour');
        $val->add_field('novembre', 'Novembre', 'required|bland_hour');
        $val->add_field('decembre', 'Décembre', 'required|bland_hour');

        return $val;
    }

    public static function validate_jours_($factory, $id_groupe = null)
    {
        $val = Validation::forge($factory);

        if ($factory == "create") {
            $val->add_callable('\Cranberry\MyValidation');
            $val->add_field('annee', 'Année', 'required|exact_length[4]|valid_string[numeric]|unique_annee[' . $id_groupe . ']');
        } else if ($factory == "edit") {
            $val->add_field('annee', 'Année', 'required|exact_length[4]|valid_string[numeric]');
        }

        $val->add_field('jours_janvier', 'Janvier', 'valid_string[numeric]');
        $val->add_field('jours_fevrier', 'Février', 'valid_string[numeric]');
        $val->add_field('jours_mars', 'Mars', 'valid_string[numeric]');
        $val->add_field('jours_avril', 'Avril', 'valid_string[numeric]');
        $val->add_field('jours_mai', 'Mai', 'valid_string[numeric]');
        $val->add_field('jours_juin', 'Juin', 'valid_string[numeric]');
        $val->add_field('jours_juillet', 'Juillet', 'valid_string[numeric]');
        $val->add_field('jours_aout', 'Août', 'valid_string[numeric]');
        $val->add_field('jours_septembre', 'Septembre', 'valid_string[numeric]');
        $val->add_field('jours_octobre', 'Octobre', 'valid_string[numeric]');
        $val->add_field('jours_novembre', 'Novembre', 'valid_string[numeric]');
        $val->add_field('jours_decembre', 'Décembre', 'valid_string[numeric]');

        return $val;
    }

    public static function getAnnee()
    {
        $result = array();
        $annee = DB::query('SELECT DISTINCT(annee) FROM heures_prestations')->execute();
//        //$annee = DB::select('DISTINCT(annee)')->from('heures_prestations')->execute();
        foreach ($annee->as_array() as $value) {
            $result[$value['annee']] = $value['annee'];

        }
        return $result;

    }


//        public static function getHeuresAndGroupe($id_groupe)
//        {
//            \Validation::active()->set_message('unique_annee', 'Cette année existe déjà pour ce groupe.');
//            $result = DB::select("annee")
//                ->where("annee", '=', $val)
//                ->where("groupe", "=", $id_groupe)
//                ->from('heures_prestations')->execute();
//
//            return ! ($result->count() > 0);
//        }

}
