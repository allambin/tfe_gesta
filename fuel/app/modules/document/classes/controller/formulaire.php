<?php
/**
 * Created by JetBrains PhpStorm.
 * User: gg
 * Date: 1/08/12
 * Time: 11:05
 * To change this template use File | Settings | File Templates.
 */

namespace Document;

class Controller_Formulaire extends \Controller_Main
{

    public function action_formulaire($formulaire)
    {

        /**
         * Affiche le formulaire pour choisir le participant
         */
        $participants = \Model_Participant::find('all', array(
            'where' => array(
                'b_is_actif' => 1
            ),
            'order_by'=> array('t_nom'=> 'asc')
        ));
        $annees = \Model_Heures_Prestation::find('all');

        $mois = array();
        for ($i = 1; $i < 13; $i++) {
            $mois[$i] = str_pad($i, 2, "0", STR_PAD_LEFT);
        }

        $select_annees = array();
        foreach ($annees as $annee) {
            $select_annees[$annee->annee] = $annee->annee;
        }


        //on récupère le nom des centres dans le fichier xml
        $coordonnees = \Cranberry\MyXML::getCoordonnees();
        $centre = array();
        foreach ($coordonnees->centre as $value) {

            $centre[(string)$value->nom_centre] = (string)$value->nom_centre;
        }

        $groupe = \Model_Groupe::find('all');

        $groupes = array();
        foreach ($groupe as $value) {

            $groupes[(string)$value->id_groupe] = (string)$value->t_nom;
        }


        if (\Input::method() == 'POST') {

            $val = \Validation::forge();
            if ($formulaire != 2) {
                $val->add_field('nom', 'Nom', 'required');
                $val->set_message('required', 'Veuillez remplir le champ :label.');
            }

            if ($formulaire == 2) {

                $nom_centre = \Input::post('centre');
                $groupe = \Input::post('groupe');

            }


            // si la validation ne renvoie aucune erreur
            if ($val->run()) {
                $this->_connexion = new \Model_Heures_Participant();

                $form_data = \Input::post();
                \Session::set('nom', $form_data['nom']);
                // \Session::set('id_participant', \Input::post('idparticipant'));
                $id = \Input::post('idparticipant');

                if ($id == '') {
                    $id = null;
                }

                if ($id === null) {
                    $message[] = 'Impossible de trouver le participant.';
                    \Session::set_flash('error', $message);
                    \Response::redirect('document/formulaire/formulaire/' . $formulaire);
                }


                /**
                 * Création de la date du mois que l'on va travailler et mise en session de celle-ci
                 */
                $date = new \DateTime();
                $date->setDate($form_data['annee'], $form_data['mois'], '01');
                //\Session::set('date_prestation', $date);


                switch ($formulaire) {

                    case 1 :
                        \Response::redirect('document/fichepaye/' . $id . '/' . $date->format('Y-m-d'));
                        break;
                    case 2 :
                        \Response::redirect('document/c98/' . $date->format('Y-m-d') . '/' . $nom_centre . '/' . $groupe . '/' . $id);
                }




            } else { // si la validation a échoué
                $message[] = $val->show_errors();
                \Session::set_flash('error', $message);
            }
        }
        
        //$this->template->set_global('participants', $participants, false);
        //$this->template->set_global('annees', $select_annees);
        //$this->template->set_global('mois', $mois);
        $this->data['participants'] = $participants;
        $this->data['annees'] = $select_annees;
        $this->data['mois'] = $mois;
        $this->data['centre'] = $centre;
        $this->data['groupe'] = $groupes;
        $this->data['formulaire'] = $formulaire;
        $this->template->title = 'Gestion des documents';
        $this->data['titre_document'] = ($formulaire == 1) ? 'Fiche salaire' : 'C98';
        $this->template->content = \View::forge('formulaire/completion', $this->data);


    }


    public function action_ldoc()
    {
        $db = new \Model_My_Document();

        $date = new \DateTime();
        $this->data['date1'] = $date->format('d-m-Y');
        //création date aujourd'hui + 5 jours
        $date = new \DateTime('now +4 days');
        $this->data['date2'] = $date->format('d-m-Y');

        //formulaire pour le groupe
        $groupe = $db->get_groupe_cedefop();
        $this->data['groupe'] = array();

        foreach ($groupe as $value) {
            $this->data['groupe'][$value['t_nom'] . ':' . $value['t_code_cedefop']] = $value['t_nom'];

        }
        $this->data['doc'] = array(1 => 'L1', 2 => 'L1Bis');

        //\Maitrepylos\Debug::dump($groupe);

        $this->template->title = '';
        $this->template->content = \View::forge('formulaire/ldoc', $this->data);


    }

    public function action_l2()
    {

        $db = new \Model_My_Document();

        //formulaire pour le groupe
        $groupe = $db->get_filiere();
        $this->data['groupe'] = array();

        foreach ($groupe as $value) {
            $this->data['groupe'][$value['id_filiere']] = $value['t_nom'];

        }

        $this->data['mois'] = array(
            '01' => 'Janvier',
            '02' => 'Février',
            '03' => 'Mars',
            '04' => 'Avril',
            '05' => 'Mai',
            '06' => 'Juin',
            '07' => 'Juillet',
            '08' => 'Août',
            '09' => 'Septembre',
            '10' => 'Octobre',
            '11' => 'Novembre',
            '12' => 'Décembre'
        );

        $annee = $db->nombreAnnee();
        foreach ($annee as $value) {
            $this->data['annee'][$value['annee']] = $value['annee'];

        }

        $this->template->title = '';
        $this->template->content = \View::forge('formulaire/l2', $this->data);
    }


    public function action_signaletique()
    {
        /**
         * Affiche le formulaire pour choisir le participant
         */
        $participants = \Model_Participant::find('all', array(
            'where' => array(
                'b_is_actif' => 1
            ),
            'order_by'=> array('t_nom'=> 'asc')
        ));
        $this->data['participants'] = $participants;

        $this->template->title = '';
        $this->template->content = \View::forge('formulaire/signaletique', $this->data);


    }

    public function action_formation($n)
    {
        /**
         * Affiche le formulaire pour choisir le participant
         */
        $participants = \Model_Participant::find('all', array(
            'where' => array(
                'b_is_actif' => 1
            ),
            'order_by'=> array('t_nom'=> 'asc')
        ));
        $this->data['participants'] = $participants;
        $this->data['route'] = 'document/formation/' . $n;

        if ($n == 1) {
            $this->data['titre'] = 'Impression Contrat de formation professionnelle - Forem';
        } elseif ($n == 2) {
            $this->data['titre'] = 'Impression Fiche déplacement';
        }


        $this->template->title = '';
        $this->template->content = \View::forge('formulaire/formation', $this->data);


    }

    public function action_prestation()
    {
        $date = new \DateTime();
        $this->data['date'] = $date->format('d-m-Y');
        $date->add(new \DateInterval('P15D'));
        $this->data['date2'] = $date->format('d-m-Y');
        $this->data['groupe'] = \Model_groupe::getNames();

        $this->template->title = '';
        $this->template->content = \View::forge('formulaire/prestation', $this->data);


    }
    public function action_liste(){

        $this->data['groupe'] = \Model_Groupe::getNames();


        $this->template->title = '';
        $this->template->content = \View::forge('formulaire/liste', $this->data);

    }

    public function action_inscription()
    {

        $this->data['annee'] = \Model_Heures_Prestation::getAnnee();
        $this->data['trimestre'] = array(1=>1,2=>2,3=>3,4=>4);

        $this->template->title = '';
        $this->template->content = \View::forge('formulaire/inscription', $this->data);

    }

}
