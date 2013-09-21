<?php
/**
 * Created by JetBrains PhpStorm.
 * User: gg
 * Date: 22/08/12
 * Time: 17:48
 * To change this template use File | Settings | File Templates.
 */

/**
 * @class
 *
 */
namespace Maitrepylos\Gestion;


class Heure extends \Maitrepylos\db
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     *Méthod permettant de récupérer les heures à prester de son début de contrat jusqu'a la fin de contrat
     */
    public function hour_in_prester($id, \Datetime $date)
    {
        $date_dernier_jour = clone $date;
        $date_dernier_jour->setDate($date->format('Y'), $date->format('m'), $date->format('t'));

        /**
         * on se connecte à la base de données.
         */


        /**
         *  Vérifier si les heures de son contrat sont fixe ou non
         */
        // On recupère les infos liées à ce participant pour cette date dans la db
        $participant = \Model_Heures_Fixer::find()->where(array(
            'participant' => $id,
            'd_date' => $date->format('Y-m-d')
        ))->get_one();

        /**
         * On a des heures ok on les livres
         */
        if ($participant != NULL) {
            return $participant->i_heures;
        }


        /**
         *  Si on ne dispose pas d'heures, il ne faut pas avoir plusieurs contrat
         *
         */
        /**
         * Si on dispose de plusieurs contrat, il n'est pas normal de ne pas avoir d'heure fixer.
         * Si on ne dispose pas de contrat, alors il faut valider les heures à Zéro
         * Si on dispose que d'un seul contrat alors
         */
        $nom_mois = \Maitrepylos\Utils::mois($date->format('m'));
        $maj = ucfirst($nom_mois);
        $sql =
            "SELECT `$nom_mois`,`jours$maj`
            FROM heures_prestations
            WHERE groupe IN (   SELECT c.groupe
                                FROM participant as p
                                    INNER JOIN contrat as c
                                        ON p.IdParticipant = c.participant
                                WHERE p.IdParticipant = ?
                                AND c.d_date_debut_contrat <= ?
                                AND c.d_date_fin_contrat_prevu >= ?)

            AND annee = ? ";


        $result = $this->_db->fetchAll($sql, array($id, $date_dernier_jour->format('Y-m-d')
        , $date->format('Y-m-d'), $date->format('Y')));
        $nombres_contrat = count($result);

        if ($nombres_contrat > 1) {
            return false;

        }

        if ($nombres_contrat == 0) {

            $participant->participant = $id;
            $participant->d_date = $date->format('Y-m-d');
            $participant->save();
            return 0;


        }

        return $result[0][$nom_mois];


    }


}
