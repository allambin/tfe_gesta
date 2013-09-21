<?php

/*
* To change this template, choose Tools | Templates
* and open the template in the editor.
*/

/**
 * Description of Model_My_Contrat
 * Gestion des contrat pour la partie base de données.
 *
 * @author gg
 */
class Model_My_Contrat extends \Maitrepylos\db
{
    /**
     *Appel au constructeur
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     *Récupération de l'ensemble des contrat pour un participant
     * @param type $id
     * @return type
     */
    public function getContrat($id)
    {

        $sql = "SELECT c.i_temps_travail,c.d_date_debut_contrat,c.d_date_fin_contrat_prevu,c.d_date_fin_contrat,c.t_remarque,g.t_nom,tc.t_type_contrat,c.id_contrat,c.b_derogation_rw";
        $sql .= " FROM contrat c";
        $sql .= " INNER JOIN groupe g";
        $sql .= " ON g.id_groupe = c.groupe_id";
        $sql .= " INNER JOIN type_contrat tc";
        $sql .= " ON c.type_contrat_id = tc.id_type_contrat";
        $sql .= " WHERE participant_id = ?";

        $req = $this->_db->prepare($sql);
        $req->execute(array($id));


        $result = $req->fetchAll(PDO::FETCH_ASSOC);
        $count = count($result);

        $date = new DateTime();


        for ($i = 0; $i < $count; $i++) {

            $dateFinContrat = \DateTime::createFromFormat('Y-m-d', $result[$i]['d_date_fin_contrat']);
            /**
             * On vérifie si les contrats sont arrivés à termes
             */
            $result[$i]['finContrat'] = 1;
            if ($dateFinContrat != null) {
                if ($date >= $dateFinContrat) {
                    $result[$i]['finContrat'] = 0;

                }
            }
        }

        return $result;
    }

    /**
     * Calcul du nombres de jours de travail
     * @param \DateTime $date_fin_contrat
     * @param \DateTime $date_debut_contrat
     * @return type
     */
    public function getJoursTravail($date_fin_contrat, $date_debut_contrat)
    {

        list($day, $month, $year) = explode('/', $date_fin_contrat);
        $date_fin_contrat = new \DateTime();
        $date_fin_contrat->setDate($year, $month, $day);

        list($day, $month, $year) = explode('/', $date_debut_contrat);
        $date_debut_contrat = new \DateTime();
        $date_debut_contrat->setDate($year, $month, $day);

        $sql = "SELECT DATEDIFF(?,?) AS jour ;";
        $req = $this->_db->prepare($sql);
        $req->execute(array(
            $date_fin_contrat->format('Y-m-d'),
            $date_debut_contrat->format('Y-m-d')));
        return $req->fetchAll(PDO::FETCH_ASSOC);


    }

    /**
     * Vérification lors d'un nouveau contrat que l'on ne depasse pas les 100%
     * @param type $id
     * @param string $date
     * @param type $jour
     * @return type
     */
    public function verifContrat($id, $date, $jour)
    {

        list($day, $month, $year) = explode('/', $date);
        $date = $year . '-' . $month . '-' . $day;

        $sql = "SELECT SUM(i_temps_travail) AS somme,DATE_ADD(?, INTERVAL ? DAY) AS jour
                FROM contrat
                    WHERE participant_id = ?
                AND d_date_debut_contrat <= DATE_ADD(?, INTERVAL ? DAY)
                AND d_date_fin_contrat >= DATE_ADD(?, INTERVAL ? DAY) ";

        $req = $this->_db->prepare($sql);
        $req->execute(array($date, $jour, $id, $date, $jour, $date, $jour));
        return $req->fetchAll(PDO::FETCH_ASSOC);

    }

    /**
     * Nous vérifions à l'insertion d'un nouveau contrat que l'on reste dans le
     * même groupe, sinon, il faut vérifier que l'insertion du nouveau groupe est
     * supérieur à la date de fin de contrat du dernier contrat.
     *
     * @param type $id
     * @param type $groupe
     * @param type $date
     */
    public function verifGroupeContrat($id, $groupe, $date_debut_contrat, $date_fin_contrat)
    {

        // list($day, $month, $year) = explode('/', $date_fin_contrat);
        $date_fin = \DateTime::createFromFormat('d/m/Y', $date_fin_contrat);
        // $date_fin->setDate($year, $month, $day);

        // list($day, $month, $year) = explode('/', $date_debut_contrat);
        $date_debut = \DateTime::createFromFormat('d/m/Y', $date_debut_contrat);
        //$date_debut->setDate($year, $month, $day);

        /**
         * Si le groupe du contrat est diférents du groupe du nouveau contrat
         * et à une date de fin de contrat inférieur au début du contrat en cours alors on passe.
         */
//        $sql = "SELECT COUNT(*) AS compteur
//                FROM contrat
//                WHERE participant_id = ?
//                AND groupe_id != ?
//                HAVING MIN(d_date_debut_contrat) > ? ";
//        $req = $this->_db->prepare($sql);
//        $req->execute(array($id, $groupe, $date_fin->format('Y-m-d')));
//        $result = $req->fetchAll(PDO::FETCH_ASSOC);
//        if ($result == null || $result[0]['compteur'] == 0) {
//            return true;
//        }

        /**
         * Si le contrat est beetwen entre deux contrat différents , alors on peut pas passer.
         * Cela risque de se produire dans les modification de contrats
         */

        $sql = "SELECT COUNT(*) AS compteur
                FROM contrat
                WHERE participant_id = ?
                AND groupe_id != ?
                AND  d_date_debut_contrat BETWEEN ? AND ?
                UNION
                SELECT 0  ";
        $req = $this->_db->prepare($sql);
        $req->execute(array($id, $groupe, $date_debut->format('Y-m-d'), $date_fin->format('Y-m-d')));
        $result = $req->fetchAll(PDO::FETCH_ASSOC);
        if ($result[0]['compteur'] > 0) {
            return false;

        }


        /**
         * Si le contrat qu'on essaye d'insérer est supérieure à la dernière date
         * de la fin de contrat le plus loin, alors continue
         * @param type $id
         * @param type $date
         */


//        $sql = "SELECT COUNT(*) AS compteur
//                FROM contrat
//                WHERE participant_id = ?
//                AND groupe_id != ?
//                HAVING MAX(d_date_fin_contrat_prevu) >= ?
//                UNION
//                SELECT 0  ";
//        $req = $this->_db->prepare($sql);
//        $req->execute(array($id, $groupe, $date_debut->format('Y-m-d')));
//        $result = $req->fetchAll(PDO::FETCH_ASSOC);
//        if ($result[0]['compteur'] > 0) {
//            return false;
//        }

        return true;


    }

    public function deleteContrat($id)
    {

        /**
         * Il faut supprimer aussi les dérogations Région Wallonne
         *
         */
        /**
         * Il n'y a plus de table derogation_rw, elle est rentré dans contrat
         */
//        $sql = "SELECT COUNT(*) AS compteur
//                FROM derogation_rw
//                WHERE contrat = ?
//                UNION
//                SELECT 0 ";
//        $req = $this->_db->prepare($sql);
//        $req->execute(array($id));
//        $result = $req->fetchAll(PDO::FETCH_ASSOC);
//
//        if($result[0]['compteur'] > 0){
//            $sql = 'DELETE FROM derogation WHERE contrat = ?';
//            $req = $this->_db->prepare($sql);
//            $req->execute(array($id));
//            //$this->_db->delete('derogation_rw',array('contrat'=> $id));
//        }
        $sql = 'DELETE FROM contrat WHERE id_contrat = :id ';
        $req = $this->_db->prepare($sql);
        $req->bindParam('id', $id, PDO::PARAM_INT);
        $req->execute();
        //$this->id_db->delete('contrat', array('id_contrat' => $id));
    }

    public function updateTypeContrat($tab)
    {

        $sql = "SELECT COUNT(id_type_contrat) FROM type_contrat";
        $result = $this->_db->prepare($sql);
        $result->execute();
        $count = $result->fetchAll(PDO::FETCH_ASSOC);

        $count++;

        for ($i = 1; $i < $count; $i++) {
            $id = $i - 1;
            $sql = 'UPDATE type_contrat SET i_position = :i_position WHERE id_type_contrat = :id';
            $result = $this->_db->prepare($sql);
            $result->bindParam('i_position', $i, PDO::PARAM_INT);
            $result->bindParam('id', $tab[$id], PDO::PARAM_INT);
            $result->execute();
            //$this->_db->update('activite', array('i_position' => $i), array('id_activite' => $tab[$id]));


        }

    }

    public static function get_statut_entree()
    {

        $t = array();

        $pdo = \Maitrepylos\Db::getPdo();
        $sql = 'SELECT id_type_statut,t_nom FROM type_statut';
        $r = $pdo->prepare($sql);
        $r->execute();
        $result = $r->fetchAll(\PDO::FETCH_OBJ);

        foreach ($result as $value) {

            $t[$value->t_nom] = array();

            $sql = 'SELECT t_nom,t_valeur FROM statut_entree WHERE type_statut_id = ?';
            $r = $pdo->prepare($sql);
            $r->execute(array($value->id_type_statut));
            $set = $r->fetchAll(\PDO::FETCH_OBJ);

            foreach ($set as $valeur) {
                $t[$value->t_nom][$valeur->t_valeur] = $valeur->t_nom;
            }

        }

        return $t;
    }


}

?>

