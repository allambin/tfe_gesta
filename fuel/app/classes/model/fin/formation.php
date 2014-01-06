<?php

use Orm\Model;

class Model_Fin_Formation extends Model
{
    protected static $list_properties = array(
        't_nom',
        't_valeur',
        'i_position'
    );
    
    protected static $_primary_key = array('id_fin_formation');
    protected static $_table_name = 'fin_formation';
    protected static $_properties = array(
        'id_fin_formation',
        't_nom' => array(
            'data_type' => 'text',
            'label' => 'Nom',
            'validation' => array('required', 'max_length'=>array(255))
        ),
        't_valeur' => array(
            'data_type' => 'text',
            'label' => 'Valeur',
            'validation' => array('required')
        ),
        'i_position' => array(
            'data_type' => 'text',
            'label' => 'Position'
        ),
        'type_formation_id' => array(
            'data_type' => 'text',
            'label' => 'Type de formation',
            'validation' => array('required'),
            'form' => array('type' => 'select', 'options' => array() ),
        )
    );
    
    protected static $_belongs_to = array(
        'type_formation' => array(
            'key_from' => 'type_formation_id',
            'model_to' => 'Model_Type_Formation',
            'key_to' => 'id_type_formation',
            'cascade_save' => false,
            'cascade_delete' => false,
        ),
    );
    
    protected static $_observers = array(
        'Observer_Logging' => array(
            'events' => array('after_insert', 'after_update', 'after_delete'), 
        )
    );
    
    /**
     * Renvoie le nom de la PK (utilisé dans l'administration)
     * 
     * @return string
     */
    public static function get_primary_key_name()
    {
        return self::$_primary_key[0];
    }
    
    /**
     * Renvoie le tableau $list_properties, utilisé dans l'administration
     * 
     * @return array
     */
    public static function get_list_properties()
    {
        $to_return = array();
        foreach (self::$list_properties as $value)
            $to_return[$value] = self::$_properties[$value];
        
        return $to_return;
    }
    
    /**
     * Permet de remplir les champs select depuis un autre Model
     */
    public static function _init()
    {
        $types = DB::select()->from('type_formation')->as_object()->execute();

        foreach ($types as $t)
            $data[$t->id_type_formation] = $t->t_nom;

        static::$_properties['type_formation_id']['form']['options'] = $data;
    }
    
    /**
     * Remplit les champs de l'objet avec le tableau passé en paramètre
     * 
     * @param array $fields
     */
    public function set_massive_assigment($fields)
    {
        $this->t_nom = $fields['t_nom'];
        $this->t_valeur = $fields['t_valeur'];
        $this->i_position = $fields['i_position'];
        $this->type_formation_id = $fields['type_formation_id'];
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
