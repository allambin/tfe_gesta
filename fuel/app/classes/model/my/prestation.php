<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of prestation
 *
 * @author gg
 */
class Model_My_Prestation extends \Maitrepylos\Db {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Vérification que nous disposons de contrat lors de l'insertion des heures de prestations.
     * @param type $id
     * @param \DateTime $date
     * @return boolean
     */
    public function verif_contrat($id, \DateTime $date) {
        $format = $date->format('Y') . '-' . $date->format('m') . '-' . $date->format('t');
        //$date = new \DateTime('2012-02-29');
        $sql = "SELECT count(participant_id) as compteur
                FROM contrat
                WHERE participant_id = ?
                HAVING MIN(d_date_debut_contrat) <= ? AND MAX(d_date_fin_contrat_prevu) >= ?
                UNION
                SELECT 0 ";
        $req = $this->_db->prepare($sql);
        $req->execute(array($id, $format,$format));
        $result = $req->fetchAll(PDO::FETCH_ASSOC);

        if ($result[0]['compteur'] > 0) {
            return true;
        }
        return false;
    }

    /**
     * @param $id_participant
     * @param DateTime $date
     * @param $id_contrat
     * @param $heure
     * @param $nom
     * @param $schema
     * @param int $formateur
     * @return bool
     */
    public function insertion_heures_prestation($id_participant, \DateTime $date, $id_contrat, $heure, $nom, $schema, $formateur = 0) {


        /**
         * Vérification que l'on dispose du contrat en fonction de la date du jour que l'on veut mettre des heures
         */
        $result = $this->get_contrat($id_participant, $date, $id_contrat);

        if ($result === false) {
            return false;
        }


        $count = count($result);

        //on boucle pour l'insertion des heures

        for ($i = 0; $i < $count; $i++) {
            $this->insertHeures($date->format('Y-m-d'), $heure, $nom, $schema, $id_participant, $result[$i]['id_contrat'], $result[$i]['subside_id'], $formateur);
        }
    }


    /**
     * Récupération de l'ensemble des contrats pour un mois donnés
     * @param $id_participant
     * @param Datetime $date
     * @param $nom_mois
     * @param $maj_nom_mois
     * @return array
     */
    public function get_contrat_full($id_participant, \Datetime $date, $nom_mois, $maj_nom_mois) {
        $date_fin = new DateTime();
        $date_fin->setDate($date->format('Y'), $date->format('m'), $date->format('t'));


        $sql = "
            SELECT c.id_contrat,g.t_nom,$nom_mois as heures ,$maj_nom_mois as jours,subside_id,i_paye,f_tarif_horaire
            FROM contrat c
                INNER JOIN groupe g
                    ON c.groupe_id = g.id_groupe
                INNER JOIN heures_prestations p
                    ON p.groupe_id = g.id_groupe
                INNER JOIN type_contrat as tc
                  ON tc.id_type_contrat = c.type_contrat_id


            WHERE (
            c.d_date_debut_contrat BETWEEN ? AND ?
            OR  c.d_date_fin_contrat_prevu   BETWEEN ? AND ?
            )
            AND c.participant_id = ?
            AND p.annee = ? ";

        $req = $this->_db->prepare($sql);
        $req->execute(array(
            $date->format('Y-m-d'),
            $date_fin->format('Y-m-d'),
            $date->format('Y-m-d'),
            $date_fin->format('Y-m-d'),
            $id_participant,
            $date->format('Y')
        ));
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupération des contrats spécifique pour un jour données.
     * @param type $id_participant
     * @param \Datetime $date
     * @param type $id_contrat
     * @return boolean
     */
    public function get_contrat($id_participant, \Datetime $date, $id_contrat) {

        $sql = "
            SELECT id_contrat,i_temps_travail,count(id_contrat) as compteur,subside_id
            FROM contrat
            INNER JOIN type_contrat
              ON id_type_contrat = type_contrat_id
            WHERE participant_id = ?
            AND d_date_debut_contrat <= ?
            AND d_date_fin_contrat_prevu >= ?
            AND id_contrat = ?";

        $req = $this->_db->prepare($sql);
        $req->execute(array($id_participant, $date->format('Y-m-d'), $date->format('Y-m-d'), $id_contrat));
        $result = $req->fetchAll(PDO::FETCH_ASSOC);

        //$result = $this->_db->fetchAll($sql, array($id_participant, $date->format('Y-m-d'), $date->format('Y-m-d'),$id_contrat));


        if ($result[0]['compteur'] > 0) {
            return $result;
        }
        return false;
    }

    /**
     * Récupération des contrats spécifique pour un jour données.
     * @param type $id_participant
     * @param \Datetime $date
     * @param type $id_contrat
     * @return boolean
     */
    public function get_contrat_ajout($id_participant, \Datetime $date) {

        $sql = "
            SELECT id_contrat,i_temps_travail,count(id_contrat) as compteur
            FROM contrat
            WHERE participant_id = ?
            AND d_date_debut_contrat <= ?
            AND d_date_fin_contrat_prevu >= ?
           ";
        $req = $this->_db->prepare($sql);
        $req->execute(array($id_participant, $date->format('Y-m-d'), $date->format('Y-m-d')));
        $result = $req->fetchAll(PDO::FETCH_ASSOC);
        // $result = $this->_db->fetchAll($sql, array($id_participant, $date->format('Y-m-d'), $date->format('Y-m-d')));
        if ($result[0]['compteur'] > 0) {
            return $result;
        }
        return false;
    }

    /**
     * Permet de générer le menu déroulant des contrats dans la fiche de prestation
     * @param $id id_participant
     * @param DateTime $date
     * @return array
     */
    public function select_contrat($id,  \DateTime $date) {


        $sql = "SELECT id_contrat,t_type_contrat
                FROM contrat as c
                    INNER JOIN type_contrat as tc
                        ON tc.id_type_contrat = c.type_contrat_id
                WHERE participant_id = ?
                AND c.d_date_debut_contrat <= ?
                AND c.d_date_fin_contrat_prevu >= ? ";
        $req = $this->_db->prepare($sql);
        $req->execute(array($id,$date->format('Y-m-t'), $date->format('Y-m-d')));
        return $req->fetchAll(PDO::FETCH_ASSOC);
        //return $this->_db->fetchAll($sql, array($id));
    }

    /**
     * Insertion des heures presté par le participant
     * @param type $date
     * @param type $heures
     * @param type $motif
     * @param type $schema
     * @param type $id_participant
     * @param type $idcontrat
     */
  public function insertHeures($date, $heures, $motif, $schema, $id_participant, $idcontrat = 0, $rw = 0, $formateur = 0) {
     
 
        $rows = array(
            $date,
            $heures,
            $motif,
            $schema,
            $id_participant,
            $idcontrat,
            $formateur,
            $rw,
            \Session::get('id_login')
        );

        $sql = "INSERT INTO heures (d_date,i_secondes,t_motif,t_schema, participant_id,contrat_id,formateur_id,subside,login_id)
            VALUES (?,?,?,?,?,?,?,?,?)";
        $req = $this->_db->prepare($sql);
        $req->execute($rows);

        
        //$req = $this->_db->prepare($sql);
       // $req->execute($rows);

        //$this->_db->insert('heures', $rows);
    }

    /**
     * getTimeWorked
     * @param \DateTime $date
     * @param type $id
     * @return type
     */
    public function get_time_worked(\DateTime $date, $id) {
        $time = new \Maitrepylos\Timetosec();
        $maxJours = $date->format('t');
        $maxJours++;
        for ($i = 1; $i < $maxJours; $i++) {
            $datetime = \DateTime::createFromFormat('Y-m-d', $date->format('Y') . '-' . $date->format('m') . '-' . $i);
            $jour = $datetime->format('Y-m-d');
            $this->_db->query("SET lc_time_names = 'fr_FR'");
            $sql = 'SELECT DAYNAME(?) as jour';

            $req = $this->_db->prepare($sql);
            $req->execute(array($jour));
            $jour = $req->fetchAll(PDO::FETCH_ASSOC);
            $time_worked[$i] = $this->get_worked($datetime, $id);
            $time_worked[$i][0]['dateFormater'] = $datetime->format('d/m/Y');
            $time_worked[$i][0]['jour'] = $jour[0]['jour'];
            if ($time_worked[$i][0]['i_secondes'] === NULL) {
                $time_worked[$i][0]['i_secondes'] = '00:00:00';
            } else {
                $time_worked[$i][0]['i_secondes'] = $time->TimeToString($time_worked[$i][0]['i_secondes']);
            }
            $time_worked[$i]['id_participant'] = $id;
        }

//        //  $time_worked = $this->_db->getWorked($date, $id);
//        $count = count($time_worked) + 1;
//        for ($i = 1; $i < $count; $i++) {
//
//            $time_worked[$i][0]['formateur'] = $this->_db->getTimesTrainer($time_worked[$i][0]['d_date'], $id);
//        }
        $time_worked[1]['date'] = $date->format('Y-m-d');
        return $time_worked;
        //  return $formateur;
    }

    /**
     * @see Recuperation des heures prestées
     * @method getWorked
     * @param \DateTime $date
     * @param integer $id
     * @return array
     */
    public function get_worked(\DateTime $date, $id) {

        $sql = "SELECT SUM(i_secondes) as i_secondes,participant_id,d_date,DAYNAME(d_date) as jour,t_schema,formateur_id,contrat_id
                    FROM heures
                 WHERE participant_id = ?
                AND d_date = ? ";

        $req = $this->_db->prepare($sql);
        $req->execute(array($id, $date->format('Y-m-d')));
        return $req->fetchAll(PDO::FETCH_ASSOC);

        //return $this->_db->fetchAll($sql, array($id, $date->format('Y-m-d')));
    }

    public function delete_heure($id, $date) {
        $sql = 'DELETE FROM heures WHERE participant_id = ? AND d_date = ?';
        $req = $this->_db->prepare($sql);
        $req->execute(array($id, $date));
        // $this->_db->delete('heures', array('participant' => $id, 'd_date' => $date));
    }

    public function delete_heure_details($id) {
        $sql = 'DELETE FROM heures WHERE id_heures = ?';
        $req = $this->_db->prepare($sql);
        $req->execute(array($id));

        // $this->_db->delete('heures', array('id_heures' => $id));
    }

    /**
     * @see Calcul des heures presté par un participant pour un mois donnés
     * @method totalHeuresMois
     * @param integer $annee
     * @param integer $mois
     * @param integre $maxJours
     * @param integer $id
     * @return array
     */
    public function total_hours_month(\DateTime $date, $id_participant) {
        $time = new \Maitrepylos\Timetosec();

        $sql = "
            SELECT SUM(i_secondes) as fullTime FROM heures
            WHERE d_date BETWEEN ? AND ?
            AND t_schema IN ('+','@','=','$','#','%','-','/')
            AND participant_id = ?";

        $req = $this->_db->prepare($sql);
        $req->execute(array($date->format('Y-m-d'), $date->format('Y-m') . '-' . $date->format('t')
            , $id_participant));
        $result = $req->fetchAll(PDO::FETCH_ASSOC);

//        $result = $this->_db->fetchAll($sql, array($date->format('Y-m-d'), $date->format('Y-m') . '-' . $date->format('t')
//        , $id_participant));

        if ($result[0]['fullTime'] == NULL) {
            return '00:00';
        } else {
            return $time->TimeToString($result[0]['fullTime']);
        }
    }

    public function total_hours_recovery($id_participant, \DateTime $date) {

        //j'ai mal géré, remplacé par $this->get_hour_recup();
        // je laisse la focntion pour accèssibilité, le temps de vérifier les effets de bords éventuelle.
        $var = $this->get_hour_recup($id_participant, $date);
        return $var;



//        $total_heures_a_prester = NULL;
//        $time = new \Maitrepylos\Timetosec();
//
//        /**
//         * Récupération de la date du premier contrat
//         */
//        $sql = "SELECT MIN(d_date_debut_contrat) as datecontrat
//                FROM contrat
//                WHERE participant = ? ";
//        $resutl = $this->_db->fetchAll($sql, array($id_participant));
//
//        //pour s'assurer qu'on obtient une date commençant par le premier du mois
//        list($year, $month, $day) = explode('-', $resutl[0]['datecontrat']);
//
//        $date_contrat = \DateTime::createFromFormat('Y-m-d', $year . '-' . $month . '-01');
//        $date_requete_sql = \DateTime::createFromFormat('Y-m-d', $date_contrat->format('Y-m-d'));
//        /**
//         * Calcul le nombre de mois depuis la première signature de contrat
//         * Ce qui va nous permettre de boucler pour calculer le nombres d'heures que le stagiaire à du prester
//         */
//        $nombres_mois = \Maitrepylos\Date::nbMois($date, $date_contrat);
//
//        for ($i = 0; $i < $nombres_mois; $i++) {
//            if ($i != 0) {
//                $date_requete_sql->add(new \DateInterval('P' . $i . 'M'));
//            }
//
//            $model_heure = new \Model_Heures_Participant();
//            $heure_a_prester = $model_heure->hour_prester($id_participant, $date_requete_sql);
//
//            if ($heure_a_prester != NULL) {
//                $total_heures_a_prester += $time->StringToTime($heure_a_prester);
//            }
//
//            $heure_deja_prester = $this->total_hours_month($date_requete_sql, $id_participant);
//            $sql = "SELECT ((?) - (?)) AS solde ";
//            $solde = $this->_db->fetchAll($sql, array($total_heures_a_prester, $time->StringToTime($heure_deja_prester)));
//            $total_heures_a_prester = $solde[0]['solde'];
//
//            $date_requete_sql = \DateTime::createFromFormat('Y-m-d', $date_contrat->format('Y-m-d'));
//        }
//
//        return $time->TimeToString($total_heures_a_prester);
    }

    public function get_details($id, $date) {

        $sql = "SELECT h.id_heures,h.d_date,h.i_secondes,h.t_motif,h.participant_id,h.formateur_id,tc.t_type_contrat,u.username
                FROM heures h
                INNER JOIN contrat c
                ON h.contrat_id = c.id_contrat
                INNER JOIN type_contrat tc
                ON c.type_contrat_id = tc.id_type_contrat
				INNER JOIN users u
				ON u.id = h.login_id
                WHERE h.participant_id = ?
                AND h.d_date = ?
                ORDER BY h.d_date";
        $req = $this->_db->prepare($sql);
        $req->execute(array($id, $date));
        return $req->fetchAll(PDO::FETCH_ASSOC);
        // return $this->_db->fetchAll($sql, array($id, $date));
    }

    /**
     * Récupération des heures pour comparer avec les heures introduites par les formateurs
     */
    public function get_hours($id_heures) {

        $sql = 'SELECT i_secondes,t_motif,t_schema FROM heures WHERE id_heures = ?';
        $req = $this->_db->prepare($sql);
        $req->execute(array($id_heures));
        return $req->fetchAll(PDO::FETCH_ASSOC);
        //  return $this->_db->fetchAll($sql, array($id_heures));
    }

    /**
     * Mise à jour des heures en fonction de ce qui est modifié dans la partie formateur
     */
    public function update_hours($id, $heures, $motif, $schema, $contrat, $formateur = 1) {

//        $array = array(
//
//            'i_secondes' => $heures,
//            't_schema' => $schema,
//            't_motif' => $motif,
//            'contrat' => $contrat,
//            'formateur' => $formateur
//
//        );
        $sql = 'UPDATE heures SET i_secondes = ?,t_schema = ?,t_motif = ?,contrat_id = ?,formateur = ?
            WHERE id_heures = ?';
        $req = $this->_db->prepare($sql);
        $req->execute(array($heures, $schema, $motif, $contrat, $formateur_id, $id));

        //$this->_db->update('heures', $array, array('id_heures' => $id));
    }

    public function ajout_deplacement($euro, $id, \DateTime $date) {
        $rows = array(
            $euro,
            $date->format('Y-m-d'),
            $id
        );

        $sql = 'INSERT INTO ajout_deplacement (i_sommes,t_mois,participant_id) VALUES (?,?,?)';
        $req = $this->_db->prepare($sql);
        $req->execute($rows);
        // $this->_db->insert('ajout_deplacement', $rows);
    }

    public function get_ajout_deplacement($id, \Datetime $date) {

        $sql = 'SELECT * FROM
                ajout_deplacement
                WHERE participant_id = ?
                AND t_mois = ?';
        $req = $this->_db->prepare($sql);
        $req->execute(array($id, $date->format('Y-m-d')));
        $result = $req->fetchAll(PDO::FETCH_ASSOC);
        if ($result == null) {
            return 0;
        }
        return $result[0]['i_sommes'];
    }

//    public function get_ajout_deplacement($id, \DateTime $date)
//    {
//
//        $sql = "SELECT i_sommes FROM ajout_deplacement
//                WHERE participant = ?
//                AND t_mois = ? ";
//        return $this->_db->fetchAll($sql, array($id, $date->format('Y-m-d')));
//    }

    public function update_ajout_deplacement($euro, $id, \Datetime $date) {

        $sql = 'UPDATE ajout_deplacemement SET i_sommes = ? WHERE t_mois = ? AND participant_id = ?';
        $req = $this->_db->prepare($sql);
        $req->execute(array($euro, $date->format('Y-m-d'), $id));
        // return $req->fetchAll(PDO::FETCH_ASSOC);
        // $this->_db->update('ajout_deplacement', $rows, $where);
    }

    public function get_recapitulatif($id, \DateTime $date) {

        $date_fin = new \Datetime();
        $date_fin->setDate($date->format('Y'), $date->format('m'), $date->format(('t')));

        $sql = "
                SELECT t_motif,SUM(i_secondes) AS i_secondes
                FROM heures
                WHERE d_date BETWEEN ? AND ?
                AND participant_id = ?
                GROUP BY t_motif ";

        $req = $this->_db->prepare($sql);
        $req->execute(array($date->format('Y-m-d'), $date_fin->format('Y-m-d'), $id));
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }

    public function get_absent($id, \DateTime $date) {

        $date_fin = new \DateTime();
        $date_fin->setDate($date->format('Y'), $date->format('m'), $date->format(('t')));

        $sql = "
                SELECT t_motif,SUM(i_secondes) AS i_secondes
                    FROM heures
                WHERE d_date BETWEEN ? AND ?
                AND participant_id = ?
                AND t_motif LIKE 'Absent'
                GROUP BY t_motif ";
        $req = $this->_db->prepare($sql);
        $req->execute(array($date->format('Y-m-d'), $date_fin->format('Y-m-d'), $id));
        return $req->fetchAll(PDO::FETCH_ASSOC);
        //    return $this->_db->fetchAll($sql, );
    }

    /**
     * @see Calcul des heures presté par un participant pour un mois donnés
     * @method totalHeuresMois
     * @param integer $annee
     * @param integer $mois
     * @param integre $maxJours
     * @param integer $id
     * @return array
     */
    public function total_hours_month_valid(\DateTime $date, $id_participant) {

        $sql = "
            SELECT SUM(i_secondes) as fullTime FROM heures
            WHERE d_date BETWEEN ? AND ?
            AND t_schema IN ('+','@','=','$','#','%','-','/')
            AND participant_id = ?";
        $req = $this->_db->prepare($sql);
        $req->execute(array($date->format('Y-m-d'), $date->format('Y-m') . '-' . $date->format('t')
            , $id_participant));
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Function retournant la date du premier contrat
     * @param id id du participant
     * @return \Datetime
     */
    public function get_date_first_contrat($id) {

        $sql = '
            SELECT MIN(d_date_debut_contrat) as d_date_debut_contrat
            FROM contrat
            WHERE participant_id = ?';
        $req = $this->_db->prepare($sql);
        $req->execute(array($id));
        $result = $req->fetchAll(PDO::FETCH_ASSOC);
        return \DateTime::createFromFormat('Y-m-d', $result[0]['d_date_debut_contrat']);
    }

    public function verifie_valide($id, \DateTime $date) {

        $sql = '
            SELECT COUNT(*) as compteur FROM valider_heure
            WHERE t_mois = ?
            AND participant_id = ?';
        $req = $this->_db->prepare($sql);
        $req->execute(array($date->format('Y-m-d'), $id));
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }

    public function get_valide($id, \DateTime $date) {

        $sql = '
            SELECT i_secondes,COUNT(participant_id) as compteur FROM valider_heure
            WHERE t_mois = ?
            AND participant_id = ?';
        $req = $this->_db->prepare($sql);
        $req->execute(array($date->format('Y-m-d'), $id));
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }

    public function valider($id, $heures, $date) {


        $rows = array(
            $heures,
            $date,
            $id
        );
        $sql = 'INSERT INTO valider_heure (i_secondes,t_mois,participant_id) VALUES (?,?,?)';
        $req = $this->_db->prepare($sql);
        $req->execute($rows);

        //$this->_db->insert('valider_heure', $rows);
    }

    public function update_formateur($id, \Datetime $date) {
        $sql = "UPDATE heures SET formateur_id = 0
                WHERE participant_id = ?
                AND EXTRACT(YEAR_MONTH FROM d_date) = ?
                AND t_schema IN ('*','+')
                AND formateur_id = 1";

        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(1, $id);
        $stmt->bindvalue(2, $date->format('Ym'));
        $stmt->execute();
    }

    public function verifie_formateur_id($id, \Datetime $date) {
        $sql = "SELECT count(*) AS compteur FROM heures
                WHERE participant_id = ?
                AND EXTRACT(YEAR_MONTH FROM d_date) = ?
                AND formateur_id = 1";

        $req = $this->_db->prepare($sql);
        $req->execute(array($id, $date->format('Ym')));
        $result = $req->fetchAll(PDO::FETCH_ASSOC);

        if ($result[0]['compteur'] == 0) {

            return true;
        }
        return false;
    }

    public function get_jours_deplacememnt($id_participant, $id_contrat, \Datetime $date) {

        $sql = "SELECT count(*) as compteur
                FROM heures h
                 INNER JOIN participant p
                ON h.participant_id = p.id_participant
                WHERE h.participant_id = ?
                AND EXTRACT(YEAR_MONTH FROM h.d_date) = ?
                AND h.contrat_id = ?
                AND t_moyen_transport LIKE '%TEC%'
                AND t_schema IN ('+', '@', '=','-','$')";
        $req = $this->_db->prepare($sql);
        $req->execute(array($id_participant, $date->format('Ym'), $id_contrat));
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Cette fonction permet de récupérer les frais de déplacememnt en fonction
     * des jours qui on été presté et des jours qui sont à prester.
     *
     * @param $prestation
     * @param $prester
     * @param $id_contrat
     * @return array()
     */
    public function get_deplacement($prestation, $prester, $id_contrat) {
        $sql = "SELECT (IF(? < ?,t_abonnement,ROUND((t_abonnement/?)* ?,2))) as total,t_abonnement
                FROM contrat
                WHERE id_contrat = ?";

        $req = $this->_db->prepare($sql);
        $req->execute(array((int) $prestation, (int) $prester, (int) $prestation, (int) $prester, $id_contrat));
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @see Methode calculant le nombres d'heures total realiser par un participant.
     * Cette methode sert pour le PDF fiche de salaire.
     * @method totalFullHeuresParticipants
     * @return
     */
    public function get_heure_total_formation($id, \DateTime $date) {
        $date_fin = new \DateTime();
        $date_fin->setDate($date->format('Y'), $date->format('m'), $date->format('t'));
        $sql = "SELECT SUM(i_secondes) as fullTime FROM heures
                WHERE d_date <= ?
                AND t_schema IN ('+', '@', '=', '-', '$')
                AND participant_id = ?";

        $req = $this->_db->prepare($sql);
        $req->execute(array($date_fin->format('Y-m-d'), $id));
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @see Retourne le total des heures de recuperation.
     * @method total_heures_recup
     * @param integer $id
     * @param String $date
     * @return array
     * attention je viens de faire une changement au départ la ligne suivante est AND heures_schema IN ('-','*')
     */
    public function total_heures_recup($id, \DateTime $date_debut, \Datetime $date) {
        $date_fin = \DateTime::createFromFormat('Y-m-d', $date->format('Y-m-') . $date->format('t'));
        $sql = "
            SELECT SUM(i_secondes) as i_secondes
            FROM heures
            WHERE d_date BETWEEN ? AND ?
            AND t_schema IN ('-')
            AND participant_id = ?
            ";
        $req = $this->_db->prepare($sql);
        $req->execute(array($date_debut->format('Y-m-d'), $date_fin->format('Y-m-d'), $id));
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @see Retourne l'ensemble des heures prestee par un participant.
     * @method totalFullHeuresMois
     * @param integer $id
     * @param String $date1
     * @param String $date2
     * @return array
     * pour le momemnt j'ai ajouté '-' et c'est bon, je tente en enlevant '*'
     */
    public function total_full_heures_mois($id, \DateTime $date_debut, \DateTime $date_fin) {
        $date_fin_last_day = \DateTime::createFromFormat('Y-m-d', $date_fin->format('Y-m-') . $date_fin->format('t'));

        $sql = "
            SELECT SUM(i_secondes) as i_secondes FROM heures
            WHERE d_date BETWEEN ? AND ?
            AND t_schema IN ('+','@','=','$','#','/','%','-')
            AND participant_id = ? ";
        $req = $this->_db->prepare($sql);
        $req->execute(array($date_debut->format('Y-m-d'), $date_fin_last_day->format('Y-m-d'), $id));
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @see methode retournant une soustraction des deux heures passer en paramettre
     * @method subtime
     * @return array array
     */
    public function subTime($heure1, $heure2) {
        $sql = "
        	SELECT ((?)-(?)) AS i_secondes;
        	";
        $req = $this->_db->prepare($sql);
        $req->execute(array($heure1, $heure2));
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }

    public function get_hour_recup($id, \DateTime $date) {

        $heures_a_prester = 0;

        /**
         * Récupération de la date du premier contrat
         */
        $sql = "SELECT MIN(d_date_debut_contrat) as datecontrat
                FROM contrat
                WHERE participant_id = ? ";
        $req = $this->_db->prepare($sql);
        $req->execute(array($id));
        $result = $req->fetchAll(PDO::FETCH_ASSOC);

        $date_premier_contrat = \DateTime::createFromFormat('Y-m-d', $result[0]['datecontrat']);
        // on fixe la date au premier jour du mois.
        $date_boucle = clone $date_premier_contrat;
        $date_boucle->setDate($date_premier_contrat->format('Y'), $date_premier_contrat->format('m'), '01');

        /**
         * On calcule le nombres de mois entre la date du premier contrat et maintenant
         */
        $nombres_mois = \Maitrepylos\date::nbMois($date, $date_boucle);



        for ($i = 0; $i < $nombres_mois; $i++) {

            //récupération des heures à prester
            $heures_a_ajouter = \Model_My_Document::get_heures_a_effectuer($date_boucle, $id, 1);

            $nbr_recup = $heures_a_ajouter + $heures_a_prester;

            //Récupération des heures valider
            $absence = $this->get_valide($id, $date_boucle);

            ($absence[0]['compteur'] == 0) ? $nbr_abscence = 0 : $nbr_abscence = $absence[0]['i_secondes'];

            $sub = $nbr_recup - $nbr_abscence;

            $heures_a_prester = $sub;
            //ajoute 1 mois pour la boucle
            $date_boucle->add(new \DateInterval('P1M'));
        }

        // $heures_a_prester = $this->total_hours_recovery($id,$date);



        $total_heures_recup = $this->total_heures_recup($id, $date_premier_contrat, $date);

        ($total_heures_recup[0]['i_secondes'] == NULL) ? $total_heures_recup = '0000' :
                        $total_heures_recup = $total_heures_recup[0]['i_secondes'];


        $total_full_heures_mois = $this->total_full_heures_mois($id, $date_premier_contrat, $date);



        ($total_full_heures_mois[0]['i_secondes'] == NULL ) ? $total_full_heures_mois = '0000' :
                        $total_full_heures_mois = $total_full_heures_mois[0]['i_secondes'];

        $heure_effectuer_moins_heure_a_prester = $this->subTime($total_full_heures_mois, $heures_a_prester);

        $heure_total = $this->subTime($heure_effectuer_moins_heure_a_prester[0]['i_secondes'], $total_heures_recup);


        return $heure_total[0]['i_secondes'];
    }

}

?>
