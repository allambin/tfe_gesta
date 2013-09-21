<?php

class Model_My_Document extends \Maitrepylos\db
{

    /**
     * Appel au constructeur
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function getParticipant($id)
    {

        $sql = 'SELECT t_nom,t_prenom,t_compte_bancaire,t_moyen_transport
                FROM participant
                WHERE id_participant = ?';
        $req = $this->_db->prepare($sql);
        $req->execute(array($id));
        $r = $req->fetchAll(PDO::FETCH_ASSOC);
        return $r;
    }

    public function get_groupe($id_contrat)
    {
        $sql = 'SELECT g.t_nom
                FROM contrat c
                INNER JOIN groupe g
                ON g.id_groupe = c.groupe_id
                AND id_contrat = ?';
        $req = $this->_db->prepare($sql);
        $req->execute(array($id_contrat));
        return $req->fetchAll(PDO::FETCH_ASSOC);

//        $date_fin = new DateTime();
//        $date_fin->setDate($date->format('Y'), $date->format('m'), $date->format('t'));
//
//        $sql = 'SELECT g.t_nom
//               FROM contrat c
//               INNER JOIN groupe g
//               ON g.id_groupe = c.groupe
//               WHERE  (
//                      c.d_date_debut_contrat BETWEEN ? AND ?
//                  OR  c.d_date_fin_contrat_prevu   BETWEEN ? AND ?
//                  )
//               AND c.participant = ?
//               LIMIT 1 ';
//
//        return $this->_db->fetchAll($sql, array(
//            $date->format('Y-m-d'),
//            $date_fin->format('Y-m-d'),
//            $date->format('Y-m-d'),
//            $date_fin->format('Y-m-d'),
//            $id));
    }

    /**
     * @method heuresMois
     * @see Methode qui calcul, le nombres d'heures a facturer par jours
     * @param $id : indentifications du participant
     * @param $date \Datetime
     * @return array array
     */
    public function heures_mois($id, \Datetime $date, $id_contrat)
    {

        $sql = "
       SELECT
            i_secondes ,
            DATE_FORMAT(d_date,'%d-%m-%Y') as d_date,
            t_motif ,
            t_schema
        FROM heures
        WHERE participant_id = ?
        AND EXTRACT(YEAR_MONTH FROM d_date) = ?
        AND contrat_id = ?
        ORDER BY d_date";
        $req = $this->_db->prepare($sql);
        $req->execute(array($id, $date->format('Ym'), $id_contrat));
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @method get_heures_a_effectuer
     * @see Methode qui recupere le nombre d'heures à effectuer via la classe Model_Heures_Participant
     * @param Datetime $date
     * @param $id
     * @return array()|Boolean
     */
    public static function get_heures_a_effectuer(\Datetime $date, $id, $string = 0)
    {


        //$nom_mois = \Maitrepylos\utils::mois($date->format('m'));
        //Variable qui va nous servir de conteneur
        $heure_ajouter = NULL;

        //$db = new HeuresModel();
        // a voir pour la gestion des heures de récup
        // $date = $db->DateCalculRecup($this->_id);
        // $this->_date_debut = $date[0]->date1;

        /**
         * On vérifie que le participant n'a pas des heures qui sont fixer pour le mois rechercher.
         * Si c'est le cas on récupère le nombre d'heures.
         * Sinon on va rechecher les heures en fonction de son régime de travail, puisque par défaut c'est 100%
         */
        $heure_participant = new Model_Heures_Participant();
        $heure = $heure_participant->hour_prester($id, $date, $string);


//        $recuperation2 = $db->getHeureFixerRegime($this->_nom_mois, $this->_id, $this->_date_debut,
//            $this->_year, $this->_month);
//
//        if (count($recuperation) != 0) {
//            $this->_heure = $recuperation[0]->totaltime;
//
//
//        } elseif ($recuperation2[0]->totaltime != NULL) {
//            $this->_heure = $recuperation2[0]->totaltime;
//
//        } else {
//            $recuperation = $db->getHeureMois($this->_nom_mois, $this->_year);
//            $this->_heure = $recuperation[0]->totaltime;
//
//        }
        return $heure;
    }

    /**
     * @method total_heure_mois
     * @see Methode qui calcul le nombres d'heures total, a facturer
     * @param $id : indentifications du participant
     * @param $annee année du calcul
     * @param $mois mois du calcul
     * @return Array array
     */
    public function total_heure_mois($id, \DateTime $date, $id_contrat)
    {
        $sql = "
            SELECT
            SUM(i_secondes) AS fulltime
                    FROM heures
                    WHERE participant_id = ?
                    AND t_schema
                    IN (
                    '+', '@', '=', '-', '$'
                    )
                    AND EXTRACT(
                    YEAR_MONTH FROM d_date ) = ?
                    AND contrat_id = ?
                ";
        $req = $this->_db->prepare($sql);
        $req->execute(array($id, $date->format('Ym'), $id_contrat));
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @method total_heure_mois_justifier
     * @see Méthode qui calcul le nombres d'heures total justifier
     * @param $id : indentifications du participant
     * @param $annee année du calcul
     * @param $mois mois du calcul
     */
    public function total_heure_mois_justifier($id, \DateTime $date, $id_contrat)
    {
        $sql = "
        SELECT SUM(i_secondes) AS fulltime
            FROM heures
            WHERE participant_id = ?
            AND t_schema
            IN (
            '/', '%'
            )
            AND EXTRACT(
            YEAR_MONTH FROM d_date ) = ?
            AND contrat_id = ?
        ";
        $req = $this->_db->prepare($sql);
        $req->execute(array($id, $date->format('Ym'), $id_contrat));
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @method totalHeureMoisNonJustifier
     * @see Methode qui calcul le nombres d'heures total non justifier
     * @param $id : indentifications du participant
     * @param $annee année du calcul
     * @param $mois mois du calcul
     */
    public function total_heure_mois_non_justifier($id, \Datetime $date, $id_contrat)
    {
        $sql = "
        SELECT SUM(i_secondes) AS fulltime
            FROM heures
            WHERE participant_id = ?
            AND t_schema
            IN (
            '*'
            )
            AND EXTRACT(
            YEAR_MONTH FROM d_date ) = ?
            AND contrat_id = ?
        ";
        $req = $this->_db->prepare($sql);
        $req->execute(array($id, $date->format('Ym'), $id_contrat));
                
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @method salaire
     * @see Methode calculant le salaire sans contrat f70bis, en fonction du mois etabli
     * Si les heures effectuées sont supérieur au mois, on fixe la rémunération au maximum du mois.
     * Les heures du mois sont calculer grace a la classe My_Gestion_HeureFixer
     * @return array array
     */
    public function salaire($heure_mois, $heure_prester, $tarif)
    {
        $sql = "

            SELECT
              CASE
                WHEN (?)<(?) THEN ROUND((((?/3600) * (?))),2)
                ELSE ROUND(((?/3600)*(?)),2)
              END
                    AS total ";
        $req = $this->_db->prepare($sql);
        $req->execute(array(
            $heure_mois,
            $heure_prester,
            $heure_mois,
            $tarif,
            $heure_prester,
            $tarif
        ));
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }

    public function get_c98_solo($id)
    {

        $sql = 'SELECT
            t_nom,
            t_prenom,
            t_registre_national,
            t_organisme_paiement,
            id_participant,
            t_nom_rue,
            t_bte,
            t_code_postal,
            t_commune
            FROM
            participant
            INNER JOIN adresse ON id_participant = participant_id
            WHERE
            participant.id_participant = ? AND
            adresse.t_courrier = 1';
        $req = $this->_db->prepare($sql);
        $req->execute(array($id));

        return $req->fetchAll(PDO::FETCH_ASSOC);
    }

    public function get_c98_full($groupe, \DateTime $date)
    {

        $date_fin = \DateTime::createFromFormat('Y-m-d', $date->format('Y-m-') . $date->format('t'));

        $sql = "SELECT
                p.t_nom,
                t_prenom,
                t_registre_national,
                t_organisme_paiement,
                id_participant,
                t_nom_rue,
                t_bte,
                t_code_postal,
                t_commune
                FROM
                participant p
                INNER JOIN adresse ON p.id_participant = adresse.participant_id
                INNER JOIN contrat ON p.id_participant = contrat.participant_id
                INNER JOIN groupe ON groupe.id_groupe = contrat.groupe_id
                WHERE
                   (d_date_debut_contrat BETWEEN ? AND ?
                            OR  d_date_fin_contrat_prevu   BETWEEN ? AND ?
                            )
                AND
                adresse.t_courrier = 1
                AND id_groupe = ? ";

        $req = $this->_db->prepare($sql);
        $req->execute(array(
            $date->format('Y-m-d'),
            $date_fin->format('Y-m-d'),
            $date->format('Y-m-d'),
            $date_fin->format('Y-m-d'),
            (int)$groupe));
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }

    public function get_filiere()
    {

        //$sql = 'SELECT id_cedefop,t_nom FROM type_cedefop';
        $sql = 'SELECT id_filiere,t_nom FROM filiere';
        $req = $this->_db->query($sql);
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Requête pour les documents L1
     */
    public function groupe_l1($groupe, $date)
    {

        $sql = 'SELECT  t_nom,t_prenom ';
        $sql .= 'FROM participant p ';
        $sql .= 'INNER JOIN contrat c ';
        $sql .= 'ON p.id_participant = c.participant_id ';
        $sql .= 'AND c.groupe = (SELECT id_groupe FROM groupe WHERE t_nom = ?) ';
        $sql .= 'AND c.d_date_fin_contrat_prevu >= ? ';
        
        $req = $this->_db->prepare($sql);
        $req->execute(array($groupe, $date));
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }

    public function nombreParticipantEntreDeuxDate(\DateTime $date, $codeCedefop)
    {

        $date2 = $date->format('Y-m-') . $date->format('t');
        $sql = 'SELECT DISTINCT(h.participant_id) ';
        $sql .= 'FROM heures h ';
        $sql .= 'INNER JOIN contrat c ';
        $sql .= 'ON c.participant_id = h.participant_id ';
        $sql .= 'AND c.groupe_id IN (SELECT id_groupe FROM groupe WHERE filiere_id = ?) ';
        $sql .= 'WHERE d_date BETWEEN ? AND ?    ';
        
        $req = $this->_db->prepare($sql);
        $req->execute(array($codeCedefop, $date->format('Y-m-d'), $date2));
        return $req->fetchAll(PDO::FETCH_ASSOC);

    }

    public function calculHeuresMoisStatL2($id_participant, $schema, \DateTime $date)
    {

        $sql = 'SELECT SUM(i_secondes) AS iSum ';
        $sql .= 'FROM heures h ';
        $sql .= 'WHERE participant_id = ? ';
        $sql .= 'AND t_schema IN (' . $schema . ') ';
        $sql .= 'AND d_date  = ? ';
        
        $req = $this->_db->prepare($sql);
        $req->execute(array($id_participant, $date->format('Y-m-d')));
        return $req->fetchAll(PDO::FETCH_ASSOC);

    }

    public function fiche($id)
    {
        $sql = 'SELECT p.t_nom as nom,p.t_prenom, DATE_FORMAT(p.d_date_naissance, \'%d/%c/%Y\') AS d_date_naissance, ';
        $sql .= 'p.t_registre_national,t_nom_rue,t_bte,t_code_postal,t_commune,g.t_nom,a.t_telephone,p.t_gsm,p.t_registre_national, ';
        $sql .= 'p.t_compte_bancaire,p.t_lieu_naissance,p.t_nationalite,p .t_mutuelle,p.t_numero_inscription_forem ';
        $sql .= 'FROM participant p ';
        $sql .= 'INNER JOIN adresse a ';
        $sql .= 'ON p.id_participant = a.participant_id AND t_courrier = 1 ';
        $sql .= 'INNER JOIN contrat c ';
        $sql .= 'ON c . participant_id = p . id_participant ';
        $sql .= 'INNER JOIN groupe g ';
        $sql .= 'ON g . id_groupe = c . groupe_id ';
        $sql .= 'WHERE p . id_participant = ? ';
        
        $req = $this->_db->prepare($sql);
        $req->execute(array($id));
        return $req->fetchAll(PDO::FETCH_ASSOC);        
    }

    /**
     * Méthode retournant le nombres d'années gérer par le logiciel, permettant par la même de générer les menus
     * déroulant où les dates années sont nécéssaire.
     * @return Dataset
     */
    public function nombreAnnee()
    {
        $sql = ' SELECT DISTINCT(annee) as annee FROM heures_prestations ORDER BY annee DESC';

        $req = $this->_db->prepare($sql);
        $req->execute();
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }

    public function idEtatPretsation($groupe, \DateTime $date_debut, \DateTime $date_fin)
    {
        $sql = "SELECT h.participant_id
               FROM heures h
               INNER JOIN contrat c
               ON c.id_contrat = h.contrat_id
               AND c.groupe_id = ?
               WHERE h.d_date BETWEEN ? AND ?
               AND h.t_schema IN ('+','@','$','-','=')
               AND c.d_date_fin_contrat_prevu >= ?
               AND c.d_date_debut_contrat<= ?

               GROUP BY h.participant_id ";
        
        $req = $this->_db->prepare($sql);
        $req->execute(array(
            $groupe,
            $date_debut->format('Y-m-d'),
            $date_fin->format('Y-m-d'),
            $date_fin->format('Y-m-d'),
            $date_debut->format('Y-m-d')
        ));
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }

    public function ficheEtatPrestationFormation($groupe, \DateTime $date_debut, \DateTime $date_fin, $id)
    {
        $sql =
            "
            SELECT p.t_nom,p.t_prenom,p.t_registre_national,
            COUNT(DISTINCT(h.d_date)) AS compteur_formation,
            SUM(h.i_secondes) AS time_partenaire_formation,
            SUM(h.i_secondes) AS time_total_formation,
            ROUND((c.f_frais_deplacement * COUNT(DISTINCT(h.d_date))),2) AS deplacement
            FROM participant p
            INNER JOIN heures h
            ON h.participant_id = p.id_participant
            INNER JOIN contrat c
            ON c.id_contrat = h.contrat_id
            AND c.groupe_id = ?
            WHERE h.d_date BETWEEN ? AND ?
            AND h.t_schema IN ('+','@','$','-')
            AND c.d_date_fin_contrat_prevu >= ?
            AND c.d_date_debut_contrat<= ?
            AND p.id_participant = ? ";
        $req = $this->_db->prepare($sql);
        $req->execute(array(
            $groupe,
            $date_debut->format('Y-m-d'),
            $date_fin->format('Y-m-d'),
            $date_fin->format('Y-m-d'),
            $date_debut->format('Y-m-d'),
            $id
        ));
        return $req->fetchAll(PDO::FETCH_ASSOC);        
    }

    public function ficheEtatPrestationStage(\DateTime $date_debut, \DateTime $date_fin, $id)
    {
        $sql =
            "
            SELECT p.t_nom,p.t_prenom,p.t_registre_national,
            COUNT(DISTINCT(h.d_date)) AS compteur_stage,
            SUM(h.i_secondes) AS time_partenaire_stage,
            SUM(h.i_secondes) AS time_total_stage,
            ROUND((c.f_frais_deplacement * COUNT(DISTINCT(h.d_date))),2) AS deplacement
            FROM participant p
            INNER JOIN heures h
            ON h.participant_id = p.id_participant
            INNER JOIN contrat c
            ON c.id_contrat = h.contrat_id
            WHERE h.d_date BETWEEN ? AND ?
            AND h.t_schema IN ('=')
            AND c.d_date_fin_contrat_prevu >= ?
            AND c.d_date_debut_contrat<= ?
            AND p.id_participant = ?
            GROUP BY p.id_participant";
        
        $req = $this->_db->prepare($sql);
        $req->execute(array(
            $date_debut->format('Y-m-d'),
            $date_fin->format('Y-m-d'),
            $date_fin->format('Y-m-d'),
            $date_debut->format('Y-m-d'),
            $id
        ));
        return $req->fetchAll(PDO::FETCH_ASSOC);

    }

    public function ficheEtatPrestationMaladie($groupe, \DateTime $date_debut, \DateTime $date_fin, $id)
    {
        $sql =
            "
            SELECT p.t_nom,p.t_prenom,p.t_registre_national,
            0 AS compteur_formation,
            0 AS time_partenaire_formation,
            0 AS time_total_formation,
            0 AS deplacement,
            0 AS compteur_stage,
            0 AS time_partenaire_stage,
            0 AS time_total_stage
            FROM participant p
            INNER JOIN heures h
            ON h.participant_id = p.id_participant
            INNER JOIN contrat c
            ON c.id_contrat = h.contrat_id
            AND c.groupe_id = ?
            WHERE h.d_date BETWEEN ? AND ?
            AND h.t_schema NOT IN ('+','@','$','-','=','#')
            AND c.d_date_fin_contrat_prevu >= ?
            AND c.d_date_debut_contrat<= ?
            AND p.id_participant NOT IN ($id)
            GROUP BY p.id_participant";
        
         $req = $this->_db->prepare($sql);
        $req->execute(array(
            $groupe,
            $date_debut->format('Y-m-d'),
            $date_fin->format('Y-m-d'),
            $date_fin->format('Y-m-d'),
            $date_debut->format('Y-m-d')
        ));
        return $req->fetchAll(PDO::FETCH_ASSOC);

    }

    public function listeStagiaire($groupe)
    {
        $sql = "
        SELECT p.t_nom,p.t_prenom,p.t_registre_national,p.id_participant,
        (YEAR(CURRENT_DATE)-YEAR(p.d_date_naissance))
            - (RIGHT(CURRENT_DATE,5)<RIGHT(p.d_date_naissance,5))
            AS age,p.d_date_naissance,p.t_gsm,a.t_telephone,CONCAT_WS(' ',a.t_nom_rue,a.t_bte,a.t_code_postal,a.t_commune) as adresse,c.t_situation_sociale,
            tc.t_type_contrat,c.id_contrat
        FROM participant p
        INNER JOIN adresse a
        ON p.id_participant = a.participant_id
        INNER JOIN contrat c
        ON c.participant_id = p.id_participant
        AND c.groupe_id = ?
        INNER JOIN type_contrat tc
        ON tc.id_type_contrat = c.type_contrat_id
        WHERE d_date_fin_contrat_prevu >= CURRENT_DATE

                ";
        
        $req = $this->_db->prepare($sql);
        $req->execute(array($groupe));
        return $req->fetchAll(PDO::FETCH_ASSOC);
       
    }

    public function dateContrat($id_contrat)
    {
        $sql = "SELECT MIN(d_date_debut_contrat) AS d_date_debut_contrat,d_date_fin_contrat_prevu FROM contrat WHERE id_contrat = ?";

        $req = $this->_db->prepare($sql);
        $req->execute(array($id_contrat));
        $result = $req->fetchAll(PDO::FETCH_ASSOC);
        return $result;

    }

}
