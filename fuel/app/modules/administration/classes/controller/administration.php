<?php

namespace Administration;

use Fuel\Core\Input;
use Fuel\Core\Session;
use Fuel\Core\Response;

/**
 * Controller gérant toute la partie administration
 */
class Controller_Administration extends \Controller_Main
{

    protected $dir = 'administration/';
    
    public function action_test()
    {
        $checklist = \Model_Checklist::find(5, array('related' => array('valeurs')));
        $valeurs = \Model_Checklist_Valeur::find('all');

        if (Input::method() == 'POST')
        {
//            $new_valeurs = \Input::post('test');
////            die(print_r($new_valeurs));
//            foreach ($new_valeurs as $value)
//            {
//                $v = \Model_Checklist_Valeur::find($value);
////                die(print_r($v));
//                $checklist->valeurs[] = $v;
//            }
//            $checklist->save();
        }

        $this->data['checklist'] = $checklist;
        $this->data['valeurs'] = $valeurs;
        return $this->theme->view('administration/test', $this->data);
    }

//    public $template = 'template_admin.twig'; // do that to take /root/views/template_admin.twig

    public $title = 'Administration';
    public $data = array();
    
    protected $items = array(
        'type_enseignement' => array(
            'name' => array(
                'single' => 'type d\'enseignement',
                'plural' => 'types d\'enseignement'
            ),
            'layout' => 'simple',
            'model' => 'Model_Type_Enseignement'
        ),
        'enseignement' => array(
            'name' => array(
                'single' => 'enseignement',
                'plural' => 'enseignements'
            ),
            'layout' => 'multiple',
            'model' => 'Model_Enseignement'
        ),
        'login' => array(
            'name' => array(
                'single' => 'login',
                'plural' => 'logins'
            ),
            'layout' => 'simple',
            'model' => 'Model_User'
        ),
        'type_cedefop' => array(
            'name' => array(
                'single' => 'type de CEDEFOP',
                'plural' => 'types de CEDEFOP'
            ),
            'layout' => 'simple',
            'model' => 'Model_Type_Cedefop'
        ),
        'type_statut' => array(
            'name' => array(
                'single' => 'type de statut',
                'plural' => 'types de statut'
            ),
            'layout' => 'simple',
            'model' => 'Model_Type_Statut'
        ),
        'statut_entree' => array(
            'name' => array(
                'single' => 'statut à l\'entrée',
                'plural' => 'statuts à l\'entrée'
            ),
            'layout' => 'multiple',
            'model' => 'Model_Statut_Entree'
        ),
    );

    /**
     * Redirige toute personne non membre du groupe "100"
     */
    public function before()
    {
        parent::before();


//        if (!\Auth::member(100)) {
//            \Session::set('direction', '/administration');
//            \Response::redirect('users/login');
//        }
//
//        $this->data['view_dir'] = $this->view_dir;
//        $this->data['partial_dir'] = $this->partial_dir;
    }

    /**
     * Affichage du menu de l'administration
     */
    public function action_index()
    {
        $this->data['title'] = $this->title;
        return $this->theme->view($this->dir.'index', $this->data);
    }

    /**
     * Private function that lists the items according to the key,
     * if the key is found in the $items attribute
     * @param string $key
     * @param array $params     additionnal parameters
     * @return type
     * @throws HttpNotFoundException
     */
    private function _list($key, $params = array())
    {
        if (!isset($this->items[$key]))
            throw new \HttpNotFoundException;

        $class = $this->items[$key]['model'];

        if (!isset($params['conditions']))
            $params['conditions'] = array();

        $this->data['key'] = $key;
        $this->data['primary_key'] = $class::get_primary_key_name();
        $this->data['items'] = $class::find('all', $params['conditions']);
        $this->data['properties'] = $class::get_list_properties();
        
        // Common properties
        $this->data['title'] = $this->title . ' - ' . ucfirst($this->items[$key]['name']['plural']);
        $this->data['subtitle'] = "Gestion des " . lcfirst($this->items[$key]['name']['plural']);
        $this->data['layout'] = $this->items[$key]['layout'];
        $this->data['back'] = 'index';

        // Usually for double template, meaning there a list and there're parents.
        // Meaning it's not always necessary nor available.
        $this->data['parents'] = isset($params['parents']) ? $params['parents'] : null;
        $this->data['foreign_key'] = isset($params['foreign_key']) ? $params['foreign_key'] : null;
        $this->data['parent_primary_key'] = isset($params['parent_primary_key']) ? $params['parent_primary_key'] : null;
        $this->data['parent_display_key'] = isset($params['parent_display_key']) ? $params['parent_display_key'] : null;

        return $this->theme->view($this->dir.'list', $this->data);
    }

    /**
     * Private function that will displays the form to add an object,
     * according to the key if the key is found in the $items attribute,
     * and manages the action to effectively add it in the databases
     * @param string $key
     * @return type
     * @throws HttpNotFoundException
     */
    private function _create($key)
    {
        if (!isset($this->items[$key]))
            throw new \HttpNotFoundException;

        $class = $this->items[$key]['model'];

        $fieldset = \Fieldset::forge('new')->add_model($class)->repopulate();
        $form = $fieldset->form();
        $form->add('submit', '', array('type' => 'submit', 'value' => 'Ajouter', 'class' => 'btn medium primary'));

        if (Input::method() == 'POST')
        {
            if ($fieldset->validation()->run() == true)
            {
                $fields = $fieldset->validated();

                $object = new $class;
                $object->set_massive_assigment($fields);

                if ($object->save())
                {
                    Session::set_flash('success', "L'objet a bien été créé.");
                    Response::redirect($this->dir.'liste_' . $key);
                }
            }
            else
            {
                Session::set_flash('error', $fieldset->validation()->show_errors());
            }
        }

        $this->data['form'] = $form->build();
        $this->data['title'] = $this->title . ' - ' . ucfirst($this->items[$key]['name']['plural']);
        $this->data['subtitle'] = "Gestion des " . lcfirst($this->items[$key]['name']['plural']);
        $this->data['back'] = 'liste_' . $key;

        return $this->theme->view($this->dir.'create', $this->data);
    }

    /**
     * Private function that will displays the form to updat an object,
     * according to the key if the key is found in the $items attribute,
     * and manages the action to effectively update it in the databases
     * @param string $key
     * @param int $id
     * @return type
     * @throws HttpNotFoundException
     */
    private function _update($key, $id)
    {
        if (!isset($this->items[$key]))
            throw new \HttpNotFoundException;

        $class = $this->items[$key]['model'];

        $object = $class::find($id);

        $fieldset = \Fieldset::forge('update')->add_model($class)->populate($object);
        $form = $fieldset->form();
        $form->add('submit', '', array('type' => 'submit', 'value' => 'Sauvegarder', 'class' => 'btn medium primary'));

        if (Input::method() == 'POST')
        {
            if ($fieldset->validation()->run() == true)
            {
                $fields = $fieldset->validated();

                $object->set_massive_assigment($fields);

                if ($object->save())
                {
                    Session::set_flash('success', "L'objet a bien été mis à jour.");
                    Response::redirect($this->dir.'liste_' . $key);
                }
            }
            else
            {
                Session::set_flash('error', $fieldset->validation()->show_errors());
            }
        }

        $this->data['form'] = $form->build();
        $this->data['title'] = $this->title . ' - ' . ucfirst($this->items[$key]['name']['plural']);
        $this->data['subtitle'] = "Gestion des " . lcfirst($this->items[$key]['name']['plural']);
        $this->data['back'] = 'liste_' . $key;

        return $this->theme->view($this->dir.'update', $this->data);
    }

    /**
     * Private function that will delete an object,
     * according to the key if the key is found in the $items attribute
     * @param string $key
     * @param int $id
     * @throws HttpNotFoundException
     */
    private function _delete($key, $id)
    {
        if (!isset($this->items[$key]))
            throw new HttpNotFoundException;

        is_null($id) and \Response::redirect($this->dir.'liste_' . $key);

        $class = $this->items[$key]['model'];

        if ($object = $class::find($id))
        {
            try
            {
                $object->delete();
                Session::set_flash('success', 'L\'objet a bien été supprimé.');
            }
            catch (Exception $e)
            {
                Session::set_flash('error', 'Impossible de supprimer l\'objet');
            }
        }
        else
        {
            Session::set_flash('error', 'Impossible de trouver l\'objet');
        }

        \Response::redirect($this->dir.'liste_' . $key);
    }

    public function action_liste_type_enseignement()
    {
        return $this->_list('type_enseignement');
    }

    public function action_ajouter_type_enseignement()
    {
        return $this->_create('type_enseignement');
    }

    public function action_modifier_type_enseignement($id)
    {
        return $this->_update('type_enseignement', $id);
    }

    public function action_supprimer_type_enseignement($id)
    {
        return $this->_delete('type_enseignement', $id);
    }

    public function action_liste_enseignement()
    {
        $params = array();
        $params['conditions'] = array('order_by' => array('i_position' => 'ASC', 'type_enseignement_id' => 'ASC'), 'related' => array('type_enseignement' => array('order_by' => array('t_nom' => 'ASC'))));
        $params['parents'] = \Model_Type_Enseignement::find('all', array('order_by' => array('t_nom' => 'ASC')));
        $params['foreign_key'] = 'type_enseignement_id';

        $params['parent_primary_key'] = \Model_Type_Enseignement::get_primary_key_name();
        $params['parent_display_key'] = 't_nom';


        return $this->_list('enseignement', $params);
    }

    public function action_ajouter_enseignement()
    {
        return $this->_create('enseignement');
    }

    public function action_modifier_enseignement($id)
    {
        return $this->_update('enseignement', $id);
    }

    public function action_supprimer_enseignement($id)
    {
        return $this->_delete('enseignement', $id);
    }

    public function action_liste_login()
    {
        // On récupère tous les users actifs (comportement par défaut)
        $users = \Model_User::find('all', array(
                    'where' => array(
                        array('is_actif', 1),
                    )
                ));

        // Récupération des groupes spécifiés dans le fichier /config/simpleauth.php
        $groups = \Config::get('simpleauth');

        $this->data['title'] = $this->title . " - Gestion des logins";
        $this->data['subtitle'] = "Gestion des logins";
        $this->data['users'] = $users;
        $this->data['groupes'] = $groups['groups'];
        return $this->theme->view($this->dir.'logins', $this->data);
    }

    public function action_ajouter_login()
    {
        return $this->_create('login');
    }

    public function action_supprimer_login($id)
    {
        return $this->_delete('login', $id);
    }

    public function action_liste_type_cedefop()
    {
        $params = array();
        $params['conditions'] = array('order_by' => array('i_position' => 'ASC'));

        return $this->_list('type_cedefop', $params);
    }

    public function action_ajouter_type_cedefop()
    {
        return $this->_create('type_cedefop');
    }

    public function action_modifier_type_cedefop($id)
    {
        return $this->_update('type_cedefop', $id);
    }

    public function action_supprimer_type_cedefop($id)
    {
        return $this->_delete('type_cedefop', $id);
    }

    /**
     * Modifie un login selon son id
     * 
     * @todo still needs a fieldset.
     *
     * @param type $id
     */
    public function action_modifier_login($id = NULL)
    {
        $user = \Model_User::find($id);

        if (\Input::method() == 'POST')
        {
            $modif_pass = (bool) \Input::post('required_password');
            $val = \Model_User::validate('edit', $modif_pass);

            if ($val->run())
            {
                $user->username = \Input::post('username');
                if ($modif_pass)
                    $user->password = \Auth::instance()->hash_password(\Input::post('password'));
                $user->group = \Input::post('group');
                $user->last_login = 0;
                $user->login_hash = \Input::post('username');
                $user->profile_fields = 'a:0:{}';
                $user->is_actif = 1;
                $user->t_nom = \Input::post('t_nom');
                $user->t_prenom = \Input::post('t_prenom');
                $user->t_acl = \Input::post('t_acl');

                if ($user and $user->save())
                {
                    $message[] = 'Le login a bien été modifié.';
                    \Session::set_flash('success', $message);
                    \Response::redirect($this->view_dir . 'liste_logins');
                }
                else
                {
                    $message[] = 'Impossible de modifier le login.';
                    Session::set_flash('error', $message);
                }
            }
            else
            {
                $message[] = $val->show_errors();
                \Session::set_flash('error', $message);
            }
        }

        $groups = \Config::get('simpleauth');
        $groups = $groups['groups'];
        $droits = array();
        foreach ($groups as $key => $value)
        {
            $droits[$key] = $value['name'];
        }

        $this->data['action'] = 'Modifier';
        $this->data['droits'] = $droits;
        $this->data['user'] = $user;
        $this->data['reset_password'] = true;
        $this->data['title'] = 'Administration - Gestion des logins';
        $this->data['subtitle'] = 'Gestion des logins';
        return $this->theme->view($this->dir.'form_login', $this->data);
    }

    public function action_liste_type_statut()
    {
        return $this->_list('type_statut');
    }

    public function action_ajouter_type_statut()
    {
        return $this->_create('type_statut');
    }

    public function action_modifier_type_statut($id)
    {
        return $this->_update('type_statut', $id);
    }

    public function action_supprimer_type_statut($id)
    {
        return $this->_delete('type_statut', $id);
    }

    public function action_liste_statut_entree()
    {
        $params = array();
        $params['conditions'] = array('order_by' => array('i_position' => 'ASC', 'type_statut_id' => 'ASC'), 'related' => array('type_statut' => array('order_by' => array('t_nom' => 'ASC'))));
        $params['parents'] = \Model_Type_Statut::find('all', array('order_by' => array('t_nom' => 'ASC')));
        $params['foreign_key'] = 'type_statut_id';

        $params['parent_primary_key'] = \Model_Type_Statut::get_primary_key_name();
        $params['parent_display_key'] = 't_nom';

        return $this->_list('statut_entree', $params);
    }

    public function action_ajouter_statut_entree()
    {
        return $this->_create('statut_entree');
    }

    public function action_modifier_statut_entree($id)
    {
        return $this->_update('statut_entree', $id);
    }

    public function action_supprimer_statut_entree($id)
    {
        return $this->_delete('statut_entree', $id);
    }

}

?>