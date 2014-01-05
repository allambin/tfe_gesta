<?php

/**
 * Controller gérant les utilisateurs enregistrés. Basé sur le composant Auth
 * de FuelPHP.
 */
class Controller_Users extends Controller_Main
{

    /**
     * Log in un visiteur.
     */
    public function action_login()
    {
        /**
         * On récupère d'où on vient pour rediriger
         */
        $direction = Session::get('direction');
        if (!isset($direction)) {
            $direction = Uri::create('');
        }

        // Règle de validation
        $val = Validation::forge('users');
        $val->add_field('username', 'Login', 'required');
        $val->add_field('password', 'Mot de passe', 'required');

        // Message d'erreur
        $val->set_message('required', 'Veuillez remplir le champ :label.');

        if ($val->run()) {
            $auth = Auth::instance();
            if ($auth->login($val->validated('username'), $val->validated('password'))) {
                //Important  ne pas effacer, cela me permet d'avoir l'id de la personne qui se connecte.
                $id = $auth->get_user_id();
                Session::set('id_login',$id[1]);
                
                // Si le membre existe en db, on le log et on le renvoie là où il voulait aller
                Response::redirect(Uri::create($direction));
            } else {
                // Sinon, on lui affiche les erreurs.
                $message[] = 'Le login et le mot de passe ne correspondent pas.';
                \Session::set_flash('error', $message);
            }
        } else {
            if ($_POST) {
                $message[] = $val->show_errors();
                \Session::set_flash('error', $message);
            }
        }

        $this->data['title'] = "Identification";
        return $this->theme->view('users/login', $this->data);
    }

    /**
     * Log out un membre.
     */
    public function action_logout()
    {
        Auth::instance()->logout();
        Response::redirect('/');
    }

    /**
     * Si le membre n'a pas les droits suffisants pour accéder à une certaine
     * page, il est renvoyé vers users/no_rights.
     */
    public function action_no_rights()
    {
        $this->data['title'] = "Droits insuffisants";
        return $this->theme->view('users/no_rights', $this->data);
    }
}

?>
