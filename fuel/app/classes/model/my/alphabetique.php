<?php

/*
* To change this template, choose Tools | Templates
* and open the template in the editor.
*/

/**
 * Description of Model_My_Alphabetique
 * Gestion des contrat pour la partie base de données.
 *
 * @author gg
 */
class Model_My_Alphabetique extends \Maitrepylos\db
{
    /**
     *Appel au constructeur
     */
    public function __construct()
    {
        parent::__construct();
        try {

            $this->deleteRows();
        } catch (PDOException $e) {

            echo $e->getMessage();
        }

    }

    /**
     * Function pour insrérer les données
     * @param type array
     */
    public function insertRows($data)
    {

        foreach ($data as $val) {


            $rows = array(
                //"id_participant" => $val[0]['participant'],
               $val[0]['t_nom'],
               $val[0]['t_prenom'],
               $val[0]['compteur_formation'],
               $val[0]['time_partenaire_formation'],
               $val[0]['time_total_formation'],
               $val[0]['t_registre_national'],
               $val[0]['deplacement'],
               $val[0]['time_partenaire_stage'],
               $val[0]['time_total_stage'],
               $val[0]['compteur_stage']
            );
            
            $sql = 'INSERT INTO rows (t_nom,t_prenom,compteur_formation,time_partenaire_formation,
                time_total_formation,t_registre_national,deplacement,time_partenaire_stage,time_total_stage,
                compteur_stage) VALUES (?,?,?,?,?,?,?,?,?,?)';
            $req = $this->_db->prepare($sql);
            $req->execute($rows);
            
            
          //  $this->_db->insert('rows', $rows);


        }


    }

    /**
     * Supprime les éléments de la table
     */
    public function deleteRows()
    {
       $sql = 'DELETE FROM rows';

        $this->_db->query($sql);
    }

    /**
     *  Selectionne les données insérer et les remets par ordres Alphabétique.
     * @param type array
     * @return type array
     */
    public function ordre_alphabetique($data)
    {

        $this->insertRows($data);

        $sql = 'SELECT * FROM rows ORDER BY t_nom ASC';
        $req = $this->_db->prepare($sql);
        $req->execute();
        $result = $req->fetchAll(PDO::FETCH_ASSOC);

        $this->deleteRows();

        return $result;
    }

}

?>

