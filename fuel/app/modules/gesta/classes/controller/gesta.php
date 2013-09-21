<?php

namespace Gesta;
/**
 *Gestion des liens de modification d'un participant.
 */
class Controller_Gesta extends \Controller_Main
{
    public $data = array();

    /**
     * Override la function before().
     * Permet de vérifier si un membre est bien authentifié, sinon il est renvoyé
     * vers la page users/login et s'il a les bons droits, sinon il est renvoyé
     * vers la page users/no_rights.
     */
    public function before()
    {
        parent::before();

        if ($this->current_user == NULL) {
            //récupère le lieu d'où l'on vient pour la redirection ensuite

            $action = basename($_SERVER['REQUEST_URI']);
            \Session::set('direction', '/gesta/choisir/' . $action);
            \Response::redirect('users/login');
        } else if (!\Auth::member(100)) {
            \Response::redirect('users/no_rights'); #7F7F7F
        }
    }


    /**
     * Affiche la page avec les liens C-R-U-D
     */
    public function action_choisir($action)
    {
        $val = \Validation::forge('choix');
        $val->add_field('t_nom', 'Nom', 'required');
        $val->set_message('required', 'Veuillez choisir un participant.');

        if ($val->run()) {
            switch ($action) {
                case 'ajouter':
                    \Response::redirect('participant/ajouter/');
                    break;
                case 'modifier':
                    \Response::redirect('participant/modifier/' . \Input::post('idparticipant'));
                    break;
                case 'supprimer':
                    \Response::redirect('participant/supprimer/' . \Input::post('idparticipant'));
                    break;
                case 'contrat':
                    \Response::redirect('contrat/ajouter/' . \Input::post('idparticipant'));
                    break;
                default:
                    break;
            }
        } else {
            $this->data['errors'] = $val->show_errors();
        }

        $participants = \Model_Participant::find('all', array(
            'where' => array(
                'b_is_actif' => 1
            ),
            'order_by' => array('t_nom' => 'asc')
        ));
        $this->template->set_global('participants', $participants, false);
        $this->template->set_global('action', $action);

        $this->template->title = 'Choisir un participant';
        $this->template->content = \View::forge('gesta/choisir', $this->data, false);
    }
}

?>
