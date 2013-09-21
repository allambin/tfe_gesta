<?php

class Model_My_Activite extends \Maitrepylos\Db
{
    /**
     *Appel au constructeur
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function updateActivite($tab){

        $sql = "SELECT COUNT(id_activite) FROM activite";
        $result = $this->_db->prepare($sql);
        $result->execute();
        $count = $result->fetchAll(PDO::FETCH_ASSOC);

        $count++;

        for($i=1;$i<$count;$i++){
            $id = $i-1;
            $sql = 'UPDATE activite SET i_position = ? WHERE id_activite = ?';
            $result = $this->_db->prepare($sql);
            $result->execute(array($i,$tab[$id]));
            //$this->_db->update('activite', array('i_position' => $i), array('id_activite' => $tab[$id]));


        }

    }

    public function add_activite($nom,$schema){

        $sql = 'SELECT (MAX(i_position) + 1) AS number  FROM activite';
        $req = $this->_db->query($sql);
        
        
        $count = $req->fetchAll();
        $sql = 'INSERT activite (t_nom,t_schema,i_position) VALUES(?,?,?)';
        $req = $this->_db->prepare($sql);
        $req->execute(array($nom,$schema,$count[0]['number']));

       // $this->_db->insert('activite',array('t_nom'=>$nom,'t_schema'=>$schema,'i_position'=>$count[0]['number']));


    }

    public function del_activite($id){
        
        $sql = 'DELETE FROM activite WHERE id_activite = ?';
        $req = $this->_db->prepare($sql);
        $req->execute(array($id));

        //$this->_db->delete('activite',array('id_activite'=>$id));
    }




}