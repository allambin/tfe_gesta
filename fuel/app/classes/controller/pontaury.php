<?php

/**
 * Controller gérant la page d'accueil.
 */
class Controller_Pontaury extends Controller_Main
{

    /**
     * Affiche l'index.
     */
    public function action_index()
    {
        \Session::set('direction', ' ');
        return $this->theme->view('pontaury/home', $this->data);
    }

}

?>
