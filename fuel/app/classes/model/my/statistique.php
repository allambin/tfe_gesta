<?php

class Model_My_Statistique extends \Maitrepylos\db {


    /**
     * Appel au constructeur
     */
    public function __construct() {

        parent::__construct();
    }

//    public function getGroupe(\DateTime $date)
//    {
//        $sql = "SELECT DISTINCT(g.id_groupe),t_nom
//                FROM contrat c
//                INNER JOIN groupe g
//                ON c.groupe = g.id_groupe
//                WHERE c.d_date_fin_contrat >= ?";
//        $result = $this->_db->fetchAll($sql, array($date->format('Y-m-d')));
//        return $result;
//
//    }

    public function getGroupe(\DateTime $date) {
        $sql = "SELECT DISTINCT(g.id_groupe),t_nom
                FROM contrat c
                INNER JOIN groupe g
                ON c.groupe = g.id_groupe
                WHERE c.d_date_fin_contrat_prevu >= ?";
        $result = $this->_db->prepare($sql);
        $result->execute(array($date->format('Y-m-d')));
        //$result->fetchAll(PDO::FETCH_ASSOC);
        //$result = $this->_db->fetchAll($sql, array($date));
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

//    public function getCountGroupe(\DateTime $date)
//    {
//        $sql =
//            'SELECT COUNT(tp.t_type_contrat) as compteur,tp.t_type_contrat,g.t_nom
//                 FROM contrat c
//                 INNER JOIN groupe g
//                 ON c.groupe = g.id_groupe
//			     INNER JOIN type_contrat tp
//				 ON c.type_contrat = tp.id_type_contrat
//                 WHERE c.d_date_fin_contrat >= ?
//                 AND subside = 1
//			     GROUP BY tp.t_type_contrat';
//        $result = $this->_db->fetchAll($sql, array($date->format('Y-m-d')));
//        return $result;
//
//    }

    public function getCountGroupe($date) {
        $sql =
                'SELECT COUNT(tp.t_type_contrat) as compteur,tp.t_type_contrat,g.t_nom
                 FROM contrat c
                 INNER JOIN groupe g
                 ON c.groupe_id = g.id_groupe
			     INNER JOIN type_contrat tp
				 ON c.type_contrat_id = tp.id_type_contrat
                 WHERE c.d_date_fin_contrat_prevu >= ?
                 AND subside = 1
			     GROUP BY tp.t_type_contrat';
        //$result = $this->_db->fetchAll($sql, array($date));
        $result = $this->_db->prepare($sql);
        $result->execute(array($date));
        return $result->fetchAll(PDO::FETCH_ASSOC);
        //return $result;
    }

//    public function getcountDerogationRw(\DateTime $date)
//    {
//        $sql =
//            'SELECT COUNT(tp.t_type_contrat) as compteur,tp.t_type_contrat,g.t_nom
//                 FROM contrat c
//                 INNER JOIN groupe g
//                 ON c.groupe = g.id_groupe
//			     INNER JOIN type_contrat tp
//				 ON c.type_contrat = tp.id_type_contrat
//                 WHERE c.d_date_fin_contrat >= ?
//                 AND subside = 1
//                 AND b_derogation_rw = 1
//			     GROUP BY tp.t_type_contrat';
//        $result = $this->_db->fetchAll($sql, array($date->format('Y-m-d')));
//        return $result;
//
//    }
    public function getcountDerogationRw($date) {
        $sql =
                'SELECT COUNT(tp.t_type_contrat) as compteur,tp.t_type_contrat,g.t_nom
                 FROM contrat c
                 INNER JOIN groupe g
                 ON c.groupe_id = g.id_groupe
			     INNER JOIN type_contrat tp
				 ON c.type_contrat_id = tp.id_type_contrat
                 WHERE c.d_date_fin_contrat_prevu >= ?
                 AND subside = 1
                 AND b_derogation_rw = 1
			     GROUP BY tp.t_type_contrat';
        //$result = $this->_db->fetchAll($sql, array($date));
        $result = $this->_db->prepare($sql);
        $result->execute(array($date));
        return $result->fetchAll(PDO::FETCH_ASSOC);
        //return $result;
    }

    public function getIdParticipant($groupe, \DateTime $date) {
        $sql = 'SELECT DISTINCT(h.participant)
                FROM	heures h
                INNER JOIN contrat c ON c.id_contrat = h.contrat_id
                WHERE h.d_date BETWEEN ? AND ?
                AND c.groupe_id = ?
                ORDER BY h.participant ASC';

        $result = $this->_db->prepare($sql);
        $result->execute(array($date->format('Y-m-d'),
            $date->format('Y-m-') . $date->format('t'),
            $groupe));
        return $result->fetchAll(PDO::FETCH_ASSOC);
//
//        return $this->_db->fetchAll($sql, array($date->format('Y-m-d'),
//            $date->format('Y-m-') . $date->format('t'),
//            $groupe));
    }

    public function getIdParticipantContrat(\DateTime $date, $groupe) {
        $sql = "SELECT
                p.id_participant as participant,p.t_nom,p.t_prenom,DATE_FORMAT(MIN(c.d_date_debut_contrat),'%d-%m-%Y') as d_date_debut_contrat
                 FROM participant p
                INNER JOIN contrat c
                ON p.id_participant = c.participant_id
                WHERE c.d_dateFincontratPrevu >= ? AND c.groupe = ?
                GROUP BY p.id_participant";

        $result = $this->_db->prepare($sql);
        $result->execute(array($date->format('Y-m-d'), $groupe));
        return $result->fetchAll(PDO::FETCH_ASSOC);
        //return $this->_db->fetchAll($sql, array($date->format('Y-m-d'), $groupe));
    }

    public function calculHeuresMoisStat($id_participant, $schema, \DateTime $date) {

        $sql = "SELECT SUM(h.i_secondes) AS iSum
                FROM heures AS h
                    WHERE h.participant_id = ?
                AND h.d_date = ?
                AND h.t_schema IN ($schema)
                AND h.subside = 1";
        $result = $this->_db->prepare($sql);
        $result->execute(array($id_participant, $date->format('Y-m-d')));
        return $result->fetchAll(PDO::FETCH_ASSOC);
        // return $this->_db->fetchAll($sql, array($id_participant, $date->format('Y-m-d')));
    }

    public function firstContrat($id) {
        $sql = 'SELECT MIN(d_date_debut_contrat) as d  FROM contrat WHERE participant_id = ?';

        $stm = $this->_db->prepare($sql);
        $stm->execute(array($id));
        $result = $stm->fetchAll(PDO::FETCH_ASSOC);
        return $result[0]['d'];
    }

    public function totalFullHeuresParticipant($id, \DateTime $date, $schema) {

        $sql = "
            SELECT SUM(i_secondes) as fullTime FROM heures
            WHERE d_date BETWEEN ? AND NOW()
            AND t_schema IN ($schema)
            AND participant_id = ? ";
        // return  $sql;
        $stm = $this->_db->prepare($sql);
        $stm->execute(array($date->format('Y-m-d'), $id));
        return $stm->fetchAll(PDO::FETCH_ASSOC);
        //return $this->_db->fetchAll($sql, array($date->format('Y-m-d'), $id));
    }

    /**
     * @param $id
     * @param DateTime $date
     * @param $schema
     * @return array
     * Fonction spéciale pour calculer les heures eft égion walonne
     */
    public function totalFullHeuresSubside($id, \DateTime $date, $schema) {

        $sql = "
            SELECT SUM(i_secondes) as fullTime FROM heures
            WHERE d_date BETWEEN ? AND NOW()
            AND t_schema IN ($schema)
            AND participant_id = ?
            AND subside = 1";
        // return  $sql;
        $stm = $this->_db->prepare($sql);
        $stm->execute(array($date->format('Y-m-d'), $id));
        return $stm->fetchAll(PDO::FETCH_ASSOC);
        //return $this->_db->fetchAll($sql, array($date->format('Y-m-d'), $id));
    }

    public function totalFullHeuresParticipant_motif($id, \DateTime $date, $motif) {

        $sql = "
            SELECT SUM(i_secondes) as fullTime FROM heures
            WHERE d_date BETWEEN ? AND NOW()
            AND t_motif IN ($motif)
            AND participant_id = ? ";
        // return  $sql;
        $stm = $this->_db->prepare($sql);
        $stm->execute(array($date->format('Y-m-d'), $id));
        return $stm->fetchAll(PDO::FETCH_ASSOC);
        //return $this->_db->fetchAll($sql, array($date->format('Y-m-d'), $id));
    }

    public function nombresMoisEntreDeuxDate(\Datetime $date) {
        $sql = "SELECT PERIOD_DIFF(EXTRACT(YEAR_MONTH FROM NOW()), EXTRACT(YEAR_MONTH FROM ?))+1 AS mois";
        $stm = $this->_db->prepare($sql);
        $stm->execute(array($date->format('Y-m-d')));
        return $stm->fetchAll(PDO::FETCH_ASSOC);
        //return $this->_db->fetchAll($sql, array($date->format('Y-m-d')));
    }

    public function participant($groupe, $annee) {

        $sql = "SELECT
            participant.id_participant,
            participant.t_nom,
            participant.t_prenom,
            participant.t_nationalite,
            participant.t_lieu_naissance,
            DATE_FORMAT(participant.d_date_naissance,'%d-%m-%Y') AS d_date_naissance,
            participant.t_sexe,
            adresse.t_nom_rue,
            adresse.t_bte,
            adresse.t_code_postal,
            adresse.t_commune,
            contrat.t_situation_sociale,
            DATE_FORMAT(contrat.d_date_debut_contrat,'%d-%m-%Y') AS d_date_debut_contrat,
            DATE_FORMAT(contrat.d_date_fin_contrat_prevu,'%d-%m-%Y') AS d_date_fin_contrat,
            contrat.tDureeInoccupation,
            participant.t_type_etude,
            participant.t_diplome,
            participant.d_fin_etude,
            participant.t_numero_inscription_forem,
            DATE_FORMAT(participant.d_date_inscription_forem,'%d-%m-%Y') AS d_date_inscription_forem,
            contrat.b_derogation_rw,
            groupe.t_nom as nom_groupe,
            contrat.t_fin_formation,
            contrat.t_fin_formation_suite
            FROM
            participant
            INNER JOIN contrat ON participant.id_participant = contrat.participant_id
            INNER JOIN adresse ON participant.id_participant = adresse.participant_id
            INNER JOIN groupe ON contrat.groupe_id = groupe.id_groupe
            WHERE EXTRACT(YEAR FROM d_date_fin_contrat_prevu) >= ?
            AND groupe.t_nom  LIKE ('%$groupe%')";
        //return $this->_db->fetchAll($sql,array($annee));
        $result = $this->_db->prepare($sql);
        $result->execute(array($annee));
        return $result->fetchAll(PDO::FETCH_ASSOC);
        //  return $result;
    }

//    public function calculHeuresMoisStatL2($id_participant, $schema, \DateTime $date)
//    {
//
//        $sql = "SELECT SUM(h.i_secondes) AS iSum
//                FROM heures AS h
//                INNER JOIN contrat c
//                  ON c.id_contrat = h.contrat
//                WHERE h.participant = ?
//                AND h.d_date = ?
//                AND h.t_schema IN ($schema)
//                AND h.subside = 1
//                AND c.d_date_debut_contrat <= ?
//                AND c.d_date_fin_contrat >= ?
//                ";
//        return $this->_db->fetchAll($sql, array($id_participant, $date->format('Y-m-d'),$date->format('Y-m-d'),$date->format('Y-m-d')));
//
//
//    }
//
    public function calculHeuresMoisStatL2($id_participant, $schema, $date) {

        $sql = "
                SELECT SUM(h.i_secondes) AS iSum
                FROM heures AS h
                INNER JOIN contrat c
                  ON c.id_contrat = h.contrat_id
                WHERE h.participant = ?
                AND h.d_date = ?
                AND h.t_schema IN ($schema)
                AND h.subside = 1
                AND c.d_date_debut_contrat <= ?
                AND c.d_date_fin_contrat_prevu >= ?

                ";
        // return $this->_db->fetchAll($sql, array($id_participant, $date,$date,$date));
        $result = $this->_db->prepare($sql);
        $result->bindParam(1, $id_participant);
        $result->bindParam(2, $date);
        $result->bindParam(3, $date);
        $result->bindParam(4, $date);
        $result->execute();
        //return $result->debugDumpParams();
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

}