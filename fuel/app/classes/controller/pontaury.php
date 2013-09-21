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
        return $this->theme->view('pontaury/home', $this->data);
    }

}

?>
