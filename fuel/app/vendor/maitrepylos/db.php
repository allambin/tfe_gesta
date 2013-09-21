<?php

namespace Maitrepylos;

/**
 * Description of db
 *
 * @author gg
 */
class Db {

    protected $_db = Null;

    public function __construct() {

        try {

            $this->_db = \Database_Connection::instance()->connection();
            $this->_db->exec('SET NAMES utf8');

        } catch (Exception $e) {
            echo 'Erreur : ' . $e->getMessage() . '<br />';
            echo 'N° : ' . $e->getCode();
            die();
        }
    }

    public static function getPdo(){

        $db = \Database_Connection::instance()->connection();
        $db->exec('SET NAMES utf8');
        return $db;

    }

    public static function getMaxPosition($table){

        $db = self::getPdo();
        $sql = 'SELECT (MAX(i_position)+1) AS i_position  FROM '.$table;
        $req = $db->prepare($sql);
        $req->execute();
        $result = $req->fetchAll(\PDO::FETCH_ASSOC);
        return $result;


    }

    public static function getMaxPositionStatut($table,$where,$id)
    {

        $db = self::getPdo();
        $sql = 'SELECT (MAX(i_position)+1) AS i_position  FROM ' . $table.' WHERE '.$where.' = ?';
        $req = $db->prepare($sql);
        $req->execute(array($id));
        $result = $req->fetchAll(\PDO::FETCH_ASSOC);
        return $result;


    }

    /**
     * Cette fonction permet de gérer les listes dans administration et de les ordonnées.
     * @param $tab
     * @param $table
     * @param $id_table
     */
    public static function updatePosition($tab,$table,$id_table)
    {
        $db = self::getPdo();
        $sql = 'SELECT COUNT('.$id_table.') FROM '.$table;
        $result = $db->prepare($sql);
        $result->execute();
        $count = $result->fetchAll(\PDO::FETCH_ASSOC);

        $count++;

        for ($i = 1; $i < $count; $i++) {
            $id = $i - 1;
            $sql = 'UPDATE '.$table.' SET i_position = ? WHERE '.$id_table.' = ?';
            $result = $db->prepare($sql);
            $result->execute(array($i, $tab[$id]));
        }
    }

}


