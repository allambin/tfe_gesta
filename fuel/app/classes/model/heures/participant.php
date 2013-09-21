<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of participant
 *
 * @author gg
 */
class Model_Heures_Participant extends \Maitrepylos\db
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getParticipant($id)
    {

        $sql = "SELECT t_nom,t_prenom FROM participant WHERE id_participant = ?";
       $result =  $this->_db->prepare($sql);
       $result->execute(array($id));
        return $result->fetchAll(PDO::FETCH_ASSOC);
        
        //return $this->_db->fetchAll($sql, array($id));
    }

    public function hour_prester($id, \DateTime $date, $string = 0)
    {
        $time = new \Maitrepylos\Timetosec();
        $date_dernier_jour = new \DateTime();
        $date_dernier_jour->setDate($date->format('Y'), $date->format('m'), $date->format('t'));

        /**
         * on se connecte à la base de données.
         */


        /**
         *  Vérifier si les heures de son contrat sont fixe ou non
         */
        // On recupère les infos liées à ce participant pour cette date dans la db
        $participant = \Model_Heures_Fixer::find()->where(array(
            'participant_id' => $id,
            'd_date' => $date->format('Y-m-d')
        ))->get_one();

        /**
         * On a des heures ok on les livres
         */
        if ($participant != NULL) {
            if ($string === 1) {
                return $participant->i_heures;
            }
            return $time->TimeToString($participant->i_heures);
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
        //$maj = ucfirst($nom_mois);
        $sql =
            "SELECT `$nom_mois`,`jours_$nom_mois`
            FROM heures_prestations
            WHERE groupe_id IN (   SELECT c.groupe_id
                                FROM contrat as c
                                WHERE c.participant_id = ?
                                AND c.d_date_debut_contrat <= ?
                                AND c.d_date_fin_contrat_prevu >= ?)

            AND annee = ? ";


//        $result = $this->_db->fetchAll($sql, array($id, $date_dernier_jour->format('Y-m-d')
//        , $date->format('Y-m-d'), $date->format('Y')));
        
        $req = $this->_db->prepare($sql);
        $req->execute(array($id, $date_dernier_jour->format('Y-m-d')
        , $date->format('Y-m-d'), $date->format('Y')));
        $result = $req->fetchAll(PDO::FETCH_ASSOC);
        
        $nombres_contrat = $req->rowCount();

        if ($nombres_contrat > 1) {
            return false;

        }
        /**
         * Si le mois tombes entre deux contrat, il faut le fixer, même si c'est 0 heures
         */
        if ($nombres_contrat == 0) {
            $new = new \Model_Heures_Fixer();
            $new->participant_id = $id;
            $new->i_heures = 0;
            $new->t_motif = 'Fixer';
            $new->d_date = $date->format('Y-m-d');
            $new->save();
            return $time->TimeToString(0);


        }
        if ($string == 1) {
            return $result[0][$nom_mois];
        }

        return $time->TimeToString($result[0][$nom_mois]);
   



    }


}

?>
