<?php

class Model_My_Tableau extends \Maitrepylos\db
{
    /**
     *Appel au constructeur
     */
    public function __construct()
    {
        parent::__construct();
    }
//
//    public function getGroupe($login)
//    {
//        $sql = "SELECT g.id_groupe,g.t_nom
//                FROM groupe g
//                WHERE login = $login";
//        $result = $this->_db->fetchAll($sql, array($login));
//        return $result;
//
//    }
    public function getGroupe()
    {
        $sql = "SELECT g.id_groupe,g.t_nom
                FROM groupe g";
        $req = $this->_db->prepare($sql);
        $req->execute();
        $result = $req->fetchAll(PDO::FETCH_ASSOC);
        return $result;

    }

    /**
     * Méthode permettant de récuperer les participant pour les tableaux
     *
     * @param $id_login
     * @param DateTime $lundi
     * @return mixed
     */
    public function getParticipantTableau($id_login, \DateTime $lundi)
    {

        $sql = "SELECT DISTINCT(p.id_participant),p.t_nom,p.t_prenom,g.id_groupe,
                g.i_lundi as '0' ,g.i_mardi as '1',g.i_mercredi as '2',g.i_jeudi as '3',g.i_vendredi as '4',
                g.i_samedi as '5',g.i_dimanche as '6'
                FROM participant p
                  INNER JOIN contrat c
                    ON p.id_participant = c.participant_id
                  INNER JOIN groupe g
                    ON c.groupe_id = g.id_groupe
                 WHERE g.id_groupe = ?
                 AND c.d_date_fin_contrat_prevu >= ?
                 ORDER BY p.t_nom";
        
        $result = $this->_db->prepare($sql);
        $result->execute(array($id_login, $lundi->format('Y-m-d')));
        return $result->fetchAll(PDO::FETCH_ASSOC);
       // return $result;
//        $result = $this->_db->fetchAll($sql, );
//        return $result;

    }

    public function get_unique_id_contrat($id)
    {
        $sql = "SELECT MAX(id_contrat) AS id_contrat FROM contrat WHERE participant_id = ? LIMIT 1";
        $result = $this->_db->prepare($sql);
        $result->execute(array($id));
        return $result->fetchAll(PDO::FETCH_ASSOC);
      

    }


    /**
     * Récupération des contrats spécifique pour un jour données.
     * @param type $id_participant
     * @param \Datetime $date
     * @param type $id_contrat
     * @return boolean
     */
    public function get_contrat($id_participant, \Datetime $lundi, $id_groupe)
    {


        $sql = "
            SELECT count(id_contrat) as compteur
            FROM contrat
            WHERE participant_id = ?
            AND d_date_debut_contrat <= ?
            AND d_date_fin_contrat_prevu >= ?
            AND groupe_id = ?
            UNION
            SELECT 0  ";
        
        $req = $this->_db->prepare($sql);
        $req->execute(array($id_participant, $lundi->format('Y-m-d'), $lundi->format('Y-m-d'), $id_groupe));
        $result = $req->fetchAll(PDO::FETCH_ASSOC);

        if ($result[0]['compteur'] > 0) {

            $schema = $this->get_schema($lundi, $id_participant);

            return array(true, $schema);
            //return true;
        }
        return array(false);
    }


    /**
     * @see Recuperation des heures prestées
     * @method getWorked
     * @param \DateTime $date
     * @param integer $id
     * @return array
     */
    public function get_schema(\DateTime $date, $id)
    {

        $sql = "SELECT t_schema
                    FROM heures
                WHERE participant_id = ?
                AND d_date = ?
                UNION
                SELECT 0 ";

        $req = $this->_db->prepare($sql);
        $req->execute(array($id, $date->format('Y-m-d')));
        $result = $req->fetchAll(PDO::FETCH_ASSOC);
         return $result[0]['t_schema'];
    }


}