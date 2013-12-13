<?php

class Model_My_Statistique extends \Maitrepylos\db {


    /**
     * Appel au constructeur
     */
    public function __construct() {

        parent::__construct();
    }



    public function getGroupe(\DateTime $date) {
        $sql = "SELECT DISTINCT(g.id_groupe),t_nom
                FROM contrat c
                INNER JOIN groupe g
                ON c.groupe_id = g.id_groupe
                WHERE c.d_date_fin_contrat_prevu >= ?";
        $result = $this->_db->prepare($sql);
        $result->execute(array($date->format('Y-m-d')));
        //$result->fetchAll(PDO::FETCH_ASSOC);
        //$result = $this->_db->fetchAll($sql, array($date));
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }



    public function getCountGroupe($date) {
        $sql =
                'SELECT COUNT(tp.t_type_contrat) as compteur,tp.t_type_contrat,g.t_nom
                 FROM contrat c
                 INNER JOIN groupe g
                 ON c.groupe_id = g.id_groupe
			     INNER JOIN type_contrat tp
				 ON c.type_contrat_id = tp.id_type_contrat
                 WHERE c.d_date_fin_contrat_prevu >= ?
                 AND tp.subside_id = 1
			     GROUP BY tp.t_type_contrat';
        //$result = $this->_db->fetchAll($sql, array($date));
        $result = $this->_db->prepare($sql);
        $result->execute(array($date));
        return $result->fetchAll(PDO::FETCH_ASSOC);
        //return $result;
    }


    public function getcountDerogationRw($date) {
        $sql =
                'SELECT COUNT(tp.t_type_contrat) as compteur,tp.t_type_contrat,g.t_nom
                 FROM contrat c
                 INNER JOIN groupe g
                 ON c.groupe_id = g.id_groupe
			     INNER JOIN type_contrat tp
				 ON c.type_contrat_id = tp.id_type_contrat
                 WHERE c.d_date_fin_contrat_prevu >= ?
                 AND tp.subside_id = 1
                 AND b_derogation_rw = 1
			     GROUP BY tp.t_type_contrat';
        //$result = $this->_db->fetchAll($sql, array($date));
        $result = $this->_db->prepare($sql);
        $result->execute(array($date));
        return $result->fetchAll(PDO::FETCH_ASSOC);
        //return $result;
    }

    public function getIdParticipant($groupe, \DateTime $date) {
        $sql = 'SELECT DISTINCT(h.participant_id)
                FROM	heures h
                INNER JOIN contrat c ON c.id_contrat = h.contrat_id
                WHERE h.d_date BETWEEN ? AND ?
                AND c.groupe_id = ?
                ORDER BY h.participant_id ASC';

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
                WHERE c.d_date_fin_contrat_prevu >= ? AND c.groupe_id = ?
                GROUP BY p.id_participant";

        $result = $this->_db->prepare($sql);
        $result->execute(array($date->format('Y-m-d'), $groupe));
        return $result->fetchAll(PDO::FETCH_ASSOC);
        //return $this->_db->fetchAll($sql, array($date->format('Y-m-d'), $groupe));
    }


    public function calculHeuresMoisStat($id_participant, $schema, \DateTime $date) {

        $sql = "SELECT SUM(i_secondes) AS iSum
                FROM heures
                    WHERE participant_id = ?
                AND d_date = ?
                AND t_schema IN ($schema)";
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

//    public function participant($groupe, $annee) {
//
//        $sql = "SELECT
//            participant.id_participant,
//            participant.t_nom,
//            participant.t_prenom,
//            participant.t_nationalite,
//            participant.t_lieu_naissance,
//            DATE_FORMAT(participant.d_date_naissance,'%d-%m-%Y') AS d_date_naissance,
//            participant.t_sexe,
//            adresse.t_nom_rue,
//            adresse.t_bte,
//            adresse.t_code_postal,
//            adresse.t_commune,
//            contrat.t_situation_sociale,
//            DATE_FORMAT(contrat.d_date_debut_contrat,'%d-%m-%Y') AS d_date_debut_contrat,
//            DATE_FORMAT(contrat.d_date_fin_contrat_prevu,'%d-%m-%Y') AS d_date_fin_contrat,
//            contrat.t_duree_innoccupation,
//            participant.t_type_etude,
//            participant.t_diplome,
//            participant.d_fin_etude,
//            participant.t_numero_inscription_forem,
//            DATE_FORMAT(participant.d_date_inscription_forem,'%d-%m-%Y') AS d_date_inscription_forem,
//            contrat.b_derogation_rw,
//            groupe.t_nom as nom_groupe
//          --  formation.t_fin_formation,
//          --  formation.t_fin_formation_suite
//            FROM
//            participant
//            INNER JOIN contrat ON participant.id_participant = contrat.participant_id
//            INNER JOIN adresse ON participant.id_participant = adresse.participant_id
//            INNER JOIN groupe ON contrat.groupe_id = groupe.id_groupe
//           -- INNER JOIN formation ON formation.contrat_id = contrat.id_contrat
//            WHERE EXTRACT(YEAR FROM d_date_fin_contrat_prevu) >= ?
//            AND groupe.t_nom  LIKE ('%$groupe%')";
//        //return $this->_db->fetchAll($sql,array($annee));
//        $result = $this->_db->prepare($sql);
//        $result->execute(array($annee));
//        return $result->fetchAll(PDO::FETCH_ASSOC);
//        //  return $result;
//    }

    public function participant($idParticipant,$idContrat)
    {

        $sql = "SELECT
            participant.id_participant,
            participant.t_nom,
            participant.t_prenom,
            participant.t_nationalite,
            participant.t_lieu_naissance,
            (SELECT t_valeur FROM type_pays WHERE t_nom = participant.t_nationalite) as t_nationalite,
            DATE_FORMAT(participant.d_date_naissance,'%d-%m-%Y') AS d_date_naissance,
            participant.t_sexe,
            adresse.t_nom_rue,
            adresse.t_bte,
            adresse.t_code_postal,
            adresse.t_commune,
            contrat.t_situation_sociale,
            DATE_FORMAT(contrat.d_date_debut_contrat,'%d-%m-%Y') AS d_date_debut_contrat,
            DATE_FORMAT(contrat.d_date_fin_contrat_prevu,'%d-%m-%Y') AS d_date_fin_contrat,
            contrat.t_duree_innoccupation,
            participant.t_type_etude,
            participant.t_diplome,
            participant.d_fin_etude,
            participant.t_numero_inscription_forem,
            DATE_FORMAT(participant.d_date_inscription_forem,'%d-%m-%Y') AS d_date_inscription_forem,
            contrat.b_derogation_rw,
            groupe.t_nom as nom_groupe,
            formation.t_fin_formation,
            formation.t_fin_formation_suite
            FROM
            participant
            INNER JOIN contrat ON participant.id_participant = contrat.participant_id
            INNER JOIN adresse ON participant.id_participant = adresse.participant_id
            INNER JOIN groupe ON contrat.groupe_id = groupe.id_groupe
            LEFT OUTER JOIN formation ON formation.contrat_id = contrat.id_contrat
            WHERE id_participant = ?
            AND id_contrat = ? ";
        //return $this->_db->fetchAll($sql,array($annee));
        $result = $this->_db->prepare($sql);
        $result->execute(array($idParticipant,$idContrat));
        return $result->fetchAll(PDO::FETCH_ASSOC);
        //  return $result;
    }



    public function createStatTatble($annee){

        $sql = "DROP TEMPORARY TABLE IF EXISTS stat";
        $this->_db->exec($sql);

        $sql = "
        CREATE  TEMPORARY TABLE  stat (
        id INTEGER NOT NULL AUTO_INCREMENT,
        i_secondes INTEGER NULL,
        d_date DATE NULL,
        participant_id INTEGER NULL,
        t_schema CHAR(1) NULL,
        d_date_debut_contrat DATE NULL,
        d_date_fin_contrat_prevu DATE NULL,
        PRIMARY KEY (id),
        INDEX(participant_id),
        INDEX(d_date)
        )";
        $this->_db->exec($sql);


        $insert = "
                INSERT INTO stat (i_secondes,d_date,participant_id,t_schema,d_date_debut_contrat,d_date_fin_contrat_prevu)
                SELECT h.i_secondes, h.d_date,h.participant_id,h.t_schema,c.d_date_debut_contrat,c.d_date_fin_contrat_prevu
                FROM heures AS h
                INNER JOIN contrat c
                ON c.id_contrat = h.contrat_id
                WHERE h.subside = 1
                AND EXTRACT(YEAR FROM h.d_date) = ?
                ORDER BY participant_id,d_date";

        $r = $this->_db->prepare($insert);
        $r->execute(array($annee));
    }

    public function stat(){

        $sql = "SELECT * FROM stat";
        $r = $this->_db->prepare($sql);
        $r->execute();
        return $r->fetchAll();

    }

    public function calculHeuresMoisStatTemporary($id_participant, $schema, $date){

        $sql = "
                SELECT SUM(i_secondes) AS iSum
                FROM stat
                WHERE participant_id = ?
                AND d_date = ?
                AND t_schema IN ($schema)
                ";

        $result = $this->_db->prepare($sql);
        $result->bindParam(1, $id_participant);
        $result->bindParam(2, $date);
        $result->execute();
        //return $result->debugDumpParams();
        return $result->fetchAll(PDO::FETCH_ASSOC);

    }


    public function calculHeuresMoisStatL2($id_participant, $schema, $date) {

        $sql = "
                SELECT SUM(h.i_secondes) AS iSum
                FROM heures AS h
                INNER JOIN contrat c
                  ON c.id_contrat = h.contrat_id
                WHERE h.participant_id = ?
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

    /**
     * Récupération des filières
     * @param $idAgrement
     * @return array
     */
    public function getFiliere($idAgrement){

        $sql = "SELECT id_filiere,t_nom FROM filiere WHERE agrement_id = ?";
        $r = $this->_db->prepare($sql);
        $r->execute(array($idAgrement));
        return $r->fetchAll(PDO::FETCH_ASSOC);


    }

    /**
     * Récupération du total d'heures de l'année précedente par filiére pour le trimestrielle.
     * @param $idParticipant
     * @param $date
     * @param $schema
     * @return int
     */
    public function getHeuresPrecedente($idParticipant,$date,$schema){

        $sql = "
                SELECT SUM(h.i_secondes) AS iSum
                FROM heures AS h
                WHERE h.participant_id = ?
                AND EXTRACT(YEAR FROM h.d_date) = ?
                AND h.t_schema IN ($schema) ";

        $r = $this->_db->prepare($sql);
        $r->execute(array($idParticipant,$date));
        $f =$r->fetch(PDO::FETCH_ASSOC);
        if($f['iSum']==null){
            return 0;
        }
        return $f['iSum'];
    }

    /**
     * Récupération de l'ensemble des contrats pour le trimestrille de 'année demandé
     * @param DateTime $date
     * @param $idFilliere
     * @return array
     */
    public function getContratTrimestre(\DateTime $date,$idFiliere){

        $finAnnee = clone $date;
        $finAnnee->setDate($date->format('Y'),'12','31');

        $sql = "SELECT c.id_contrat,c.d_date_debut_contrat,c.d_date_fin_contrat_prevu,c.d_date_fin_contrat,g.id_groupe,f.id_filiere,c.participant_id,i_code_cedefop
                FROM contrat c
                INNER JOIN groupe g
                ON g.id_groupe = c.groupe_id
                INNER JOIN filiere f
                ON f.id_filiere = g.filiere_id
                WHERE c.d_date_debut_contrat <= ?
                AND c.d_date_fin_contrat_prevu >= ?
                AND f.id_filiere = ?
                ORDER BY g.id_groupe,c.participant_id";

        $r = $this->_db->prepare($sql);
        $r->execute(array($finAnnee->format('Y-m-d'),$date->format('Y-m-d'),$idFiliere));
        return $r->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Calcul le nombres d'heures éffectuè au total par les participant et par filière
     * @param $annee
     * @param $idFiliere
     * @param $schema
     * @return int
     */
    public function getHeuresTotalFiliere($extract,$idFiliere,$schema){

        $sql = "SELECT SUM(h.i_secondes) AS iSum
                FROM contrat c
                INNER JOIN heures h
                ON h.contrat_id = c.id_contrat
                INNER JOIN groupe g
                ON g.id_groupe = c.groupe_id
                INNER JOIN filiere f
                ON f.id_filiere = g.filiere_id
                WHERE EXTRACT(YEAR_MONTH FROM h.d_date) = ?
                AND h.t_schema IN ($schema)
                AND f.id_filiere = ? ";

        $r = $this->_db->prepare($sql);
        $r->execute(array($extract,$idFiliere));
        $f = $r->fetch(PDO::FETCH_ASSOC);
        if ($f['iSum'] == null) {
            return 0;
        }
        return $f['iSum'];

    }

    /**
     * Calcule des heures par contrat pour le trimestrielle en fonction de l'année et des contrats
     * @param Datetime $annee
     * @param $idContrat
     * @param $schema
     * @return int
     */
    public function getHeuresTotalContrat(\Datetime $annee, $idContrat, $schema)
    {

        $sql = "SELECT SUM(i_secondes) AS iSum
                FROM heures
                WHERE EXTRACT(YEAR FROM d_date) = ?
                AND t_schema IN ($schema)
                AND contrat_id = ? ";

        $r = $this->_db->prepare($sql);
        $r->execute(array($annee->format('Y'), $idContrat));
        $f = $r->fetch(PDO::FETCH_ASSOC);
        if ($f['iSum'] == null) {
            return 0;
        }
        return $f['iSum'];

    }

    /**
     * Nombres de contrat retourné par filiere pour l'annexe 1.
     * @param DateTime $date
     * @return array
     */
    public function getCountContratFiliere(\DateTime $date){

        $anneSuivante = clone $date;
        $anneSuivante->add(new DateInterval('P1Y'));

        $sql = "SELECT COUNT(g.id_groupe) AS compteur, f.t_nom,f.i_code_cedefop
                FROM filiere f
                INNER JOIN groupe g
                ON g.filiere_id = f.id_filiere
                INNER JOIN contrat c
                ON c.groupe_id = g.id_groupe
                INNER JOIN type_contrat tc
                ON tc.id_type_contrat = c.type_contrat_id
                WHERE c.d_date_fin_contrat_prevu >= ?
                AND c.d_date_debut_contrat < ?
                AND tc.subside_id = 1
                GROUP BY g.filiere_id";

        $r = $this->_db->prepare($sql);
        $r->execute(array($date->format('Y-m-d'),$anneSuivante->format('Y-m-d')));
        return $r->fetchAll(PDO::FETCH_ASSOC);

    }


    /**
     * Nombres de contrat retourné par filiere pour l'annexe 1 et par dérogation.
     * @param DateTime $date
     * @return array
     */
    public function getCountContratFiliereDerogation(\DateTime $date)
    {

        $anneSuivante = clone $date;
        $anneSuivante->add(new DateInterval('P1Y'));

        $sql = "SELECT COUNT(g.id_groupe) AS compteur, f.t_nom,f.i_code_cedefop
                FROM filiere f
                INNER JOIN groupe g
                ON g.filiere_id = f.id_filiere
                INNER JOIN contrat c
                ON c.groupe_id = g.id_groupe
                INNER JOIN type_contrat tc
                ON tc.id_type_contrat = c.type_contrat_id
                WHERE c.d_date_fin_contrat_prevu >= ?
                AND c.d_date_debut_contrat < ?
                AND tc.subside_id = 1
                AND b_derogation_rw = 1
                GROUP BY g.filiere_id";

        $r = $this->_db->prepare($sql);
        $r->execute(array($date->format('Y-m-d'), $anneSuivante->format('Y-m-d')));
        return $r->fetchAll(PDO::FETCH_ASSOC);

    }



}