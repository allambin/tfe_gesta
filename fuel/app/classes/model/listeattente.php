<?php

class Model_Listeattente extends \Orm\Model {

    protected static $_primary_key = array('id_liste_attente');
    protected static $_table_name = 'liste_attente';
    protected static $_properties = array(
        'id_liste_attente',
        't_nom',
        't_prenom',
        'd_date_naissance',
        'd_date_entretien',
        't_contact',
        'groupe_id',
        'adresse_id',
        'b_is_actif'
    );
    
    protected static $_belongs_to = array(
        'adresse' => array(
            'key_from' => 'adresse_id',
            'model_to' => 'Model_Adresse',
            'key_to' => 'id_adresse',
            'cascade_save' => true,
            'cascade_delete' => false,
        ),
        'groupe' => array(
            'key_from' => 'groupe_id',
            'model_to' => 'Model_Groupe',
            'key_to' => 'id_groupe',
            'cascade_save' => true,
            'cascade_delete' => false,
        )
    );

    public static function validate($factory) {
        $val = Validation::forge($factory);

        $val->add_callable('\Cranberry\MyValidation');

        $val->add_field('t_nom', 'Nom', 'required|max_length[50]');
        $val->add_field('t_prenom', 'Prénom', 'required|max_length[50]');
        $val->add_field('d_date_naissance', 'Date de naissance', 'required|isMajeur');

        $val->set_message('required', 'Veuillez remplir le champ :label.');
        $val->set_message('min_length', 'Le champ :label doit faire au moins :param:1 caractères.');
        $val->set_message('max_length', 'Le champ :label doit faire au plus :param:1 caractères.');
        $val->set_message('exact_length', 'Le champ :label doit compter exactement :param:1 caractères.');
        $val->set_message('valid_string', 'Le champ :label ne doit contenir que des chiffres.');
        
        return $val;
    }

}
