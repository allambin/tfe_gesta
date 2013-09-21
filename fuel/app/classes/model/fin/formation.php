<?php

use Orm\Model;

class Model_Fin_Formation extends Model
{
    
    protected static $_primary_key = array('id_fin_formation');
    protected static $_table_name = 'fin_formation';
    protected static $_properties = array(
        'id_fin_formation',
        't_nom',
        't_valeur',
        'i_position',
        'type_formation_id',
    );
    
    protected static $_belongs_to = array(
        'type_formation' => array(
            'key_from' => 'type_formation_id',
            'model_to' => 'Model_Type_Formation',
            'key_to' => 'id_type_formation',
            'cascade_save' => true,
            'cascade_delete' => false,
        ),
    );

    public static function validate($factory)
    {
        $val = Validation::forge($factory);
        $val->add_field('t_nom', 'Nom', 'required|max_length[255]');
        $val->add_field('t_valeur', 'Valeur', 'required|max_length[10]');


        $val->set_message('required', 'Veuillez remplir le champ :label.');
        $val->set_message('max_length', 'Le champ :label doit faire au plus :param:1 caractères.');

        return $val;
    }

    public static function fin_formation_pdf($id_contrat){
        $pdo = \Maitrepylos\Db::getPdo();
        $sql = 'SELECT c.d_date_debut_contrat,c.d_date_fin_contrat,f.t_nom FROM contrat c
                INNER JOIN groupe g
                    ON c.groupe_id = g.id_groupe
                INNER JOIN filiere f
                    ON g.filiere_id = f.id_filiere
                WHERE c.id_contrat = ?';
        $result = $pdo->prepare($sql);
        $result->execute(array($id_contrat));
        return $result->fetch(PDO::FETCH_OBJ);

    }


    public static function get_participant_fin_formation($id){
        $pdo = \Maitrepylos\Db::getPdo();
        $sql = "SELECT p.t_nom,p.t_prenom,p.t_registre_national,a.t_nom_rue,a.t_code_postal,a.t_commune FROM participant p
                INNER JOIN adresse a
                    ON p.id_participant  = a.participant_id
                WHERE p.id_participant = ?
                AND a.t_courrier = 1
                LIMIT 1";
        $result = $pdo->prepare($sql);
        $result->execute(array($id));
        return $result->fetch(PDO::FETCH_OBJ);
    }

    public static function fin_formation_contrat($id_contrat){
        $pdo = \Maitrepylos\Db::getPdo();
        $sql = 'SELECT f.t_fin_formation,f.d_date_fin_formation,ff.t_nom
                FROM formation f
                INNER JOIN fin_formation ff
                 ON f.t_fin_formation = ff.t_valeur
                WHERE f.contrat_id = ?';
        $result = $pdo->prepare($sql);
        $result->execute(array($id_contrat));
        return $result->fetch(PDO::FETCH_OBJ);
    }

    public static function get_count_adresse($id_participant){

        $pdo = \Maitrepylos\Db::getPdo();
        $sql = 'SELECT COUNT(id_adresse) FROM adresse WHERE participant_id = ? AND t_courrier = 1';
        $result = $pdo->prepare($sql);
        $result->execute(array($id_participant));
        return $result->fetchColumn();
    }



}
