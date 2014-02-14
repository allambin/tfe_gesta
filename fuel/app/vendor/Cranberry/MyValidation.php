<?php

namespace Cranberry;

use Fuel\Core\DB;
use Fuel\Core\Date;

class MyValidation
{

    /**
     * Vérifie si un participant existe déjà selon les nom, prénom et date de naissance.
     * Le parametre $actif permet de sélectionner soit les participants actifs,
     * soit ceux qui ont été "supprimés".
     */
    public static function exists($nom, $prenom, $datenaissance, $actif)
    {
        $result = DB::select("tnom")
                        ->where('t_nom', '=', $nom)
                        ->and_where('t_prenom', '=', $prenom)
                        ->and_where('d_date_naissance', '=', $datenaissance)
                        ->and_where('is_actif', '=', $actif)
                        ->from('participant')->execute();

        return ($result->count() > 0);
    }

    /**
     * Vérifie si le participant est majeur.
     *
     * @param type $val
     * @return type 
     */
    public static function _validation_is_majeur($val)
    {
        $d1 = new \DateTime($val);
        $d2 = new \DateTime("now");
        $diff = $d1->diff($d2);
        $years = $diff->format('%y');

        \Validation::active()->set_message('is_majeur', 'Le participant doit être majeur.');

        return ($years >= 18) ? true : false;
    }

    /**
     * Vérifie le format de la date (dd-mm-yyyy)
     * 
     * @param string $val
     * @return boolean
     */
    public static function _validation_checkdate($val)
    {
        \Validation::active()->set_message('checkdate', 'La date de naissance est invalide (dd-mm-yyyy)');
        $date = explode('-', $val);
        if (count($date) == 3 && checkdate($date[1], $date[0], $date[2]))
            return true;

        return false;
    }

    /**
     * Valide le registre national.
     *
     * @param type $val
     * @return type 
     */
    public static function _validation_registre_national($val)
    {
        \Validation::active()->set_message('registre_national', 'Le registre national doit comporter 11 chiffres.');
        if ($val != null || !empty($val))
        {
            $registre = \Cranberry\MySanitarization::filter_digits($val);

            $nbr = strlen($registre);
            if ($nbr != 11)
            {
                return false;
            }
            return true;
        }
        else
        {
            return true;
        }
    }

    /**
     * Valide le compte bancaire.
     *
     * @param type $val
     * @return type 
     */
    public static function _validation_compte_bancaire($val)
    {
        \Validation::active()->set_message('compte_bancaire', 'Le compte bancaire doit comporter 12 chiffres.');
        if ($val != null || !empty($val))
        {
            $compte = \Cranberry\MySanitarization::filter_digits($val);
            $nbr = strlen($compte);
            if ($nbr != 12)
            {
                return false;
            }
            return true;
        }
        else
        {
            return true;
        }
    }

    /**
     * Vérifie l'unicité d'une année dans la table heures_prestation
     *
     * @param type $val 
     */
    public static function _validation_unique_annee($val, $idgroupe)
    {
        \Validation::active()->set_message('unique_annee', 'Cette année existe déjà pour ce groupe.');
        $result = DB::select("annee")
                        ->where("annee", '=', $val)
                        ->where("groupe_id", "=", $idgroupe)
                        ->from('heures_prestations')->execute();

        return !($result->count() > 0);
    }

    /**
     * Vérifie les données sur les enfants à charge
     * 
     * @param type $val
     * @return boolean
     */
    public static function _validation_children_data($val)
    {
        \Validation::active()->set_message('children_data', 'Veuillez entrer toutes les informations concernant les enfants à charge.');

        if (count($val) == 1 || empty($val))
            return true;

        foreach ($val as $input)
        {
            if ($val != null && empty($input))
                return false;
        }

        return true;
    }

    /**
     * Vérifie l'unicité du nom d'une activité
     * @param type $val
     * @return type
     */
    public static function _validation_uniqueActivityName($val)
    {
        \Validation::active()->set_message('uniqueActivityName', 'Ce nom existe déjà.');

        $field = 't_nom';

        $result = DB::select("LOWER (\"$field\")")
                        ->where($field, '=', \Str::lower($val))
                        ->from('activite')->execute();

        return !($result->count() > 0);
    }

    /**
     * Vérifie l'unicité du nom d'une activité
     * @param type $val
     * @return type
     */
    public static function _validation_unique_registre_national($val, $id = null)
    {
        \Validation::active()->set_message('unique_registre_national', 'Ce registre national existe déjà.');

        $val = trim($val);
        if (empty($val))
            return true;

        $field = 't_registre_national';
        $val = \Cranberry\MySanitarization::filter_registre_national($val);

        $query = DB::select("LOWER (\"$field\")")
                ->where($field, '=', \Str::lower($val))
                ->from('participant');

        if ($id)
            $query->where('id_participant', '<> ', $id);

        $result = $query->execute();

        return !($result->count() > 0);
    }

}

?>
