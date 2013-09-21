<?php

namespace Prestation;

use Fuel\Core\Session;

class Controller_Prestation extends \Controller_Main
{


    public $title = 'Gestion des heures';
    public $data = array();
    private $_connexion = null;
    private $_message = array();

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
            \Session::set('direction', '/prestation');
            \Response::redirect('users/login');
        } else if (!\Auth::member(100)) {
            \Response::redirect('users/no_rights');
        }
    }

    /**
     * Affiche le formulaire pour choisir le participant
     */
    public function action_index()
    {
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

        if (\Input::method() == 'POST') {

            $val = \Validation::forge();
            $val->add_field('nom', 'Nom', 'required');
            $val->set_message('required', 'Veuillez remplir le champ :label.');

            // si la validation ne renvoie aucune erreur
            if ($val->run()) {
                $this->_connexion = new \Model_Heures_Participant();

                $form_data = \Input::post();
                \Session::set('nom', $form_data['nom']);
                \Session::set('idparticipant', \Input::post('idparticipant'));

                if($form_data['idparticipant'] == '' )
                {
                    $message[] = 'Impossible de trouver le participant.';
                    \Session::set_flash('error', $message);
                    \Response::redirect('/prestation');
                }


                /**
                 * Création de la date du mois que l'on va travailler et mise en session de celle-ci
                 */
                $date = new \DateTime();
                $date->setDate($form_data['annee'], $form_data['mois'], '01');
                \Session::set('date_prestation', $date);


                //on Vérifie que l'on peut introduire des heures
                $prestation_db = new \Model_My_Prestation();
                if ($prestation_db->verif_contrat($form_data['idparticipant'], $date) === false) {
                    $msg[] = 'Le participant n\a pas de contrat à cette période';
                    \Session::set_flash('error', $msg);
                    \Session::delete('date_prestation');
                    \Response::redirect('prestation');
                }

                \Response::redirect('prestation/modifier_participant/');
            } else { // si la validation a échoué
                $message[] = $val->show_errors();
                \Session::set_flash('error', $message);
            }
        }
        /**
         * Si nous sommes dans le cas de validation des mois de prestations, nous arrivons ici
         */
        if (\Input::get('valide') == 1) {


            $date = \DateTime::createFromFormat('Y-m-d', \Input::get('date'));
            \Session::set('date_prestation', $date);
            \Response::redirect('prestation/modifier_participant/');


        }

        //$this->template->set_global('participants', $participants, false);
        //$this->template->set_global('annees', $select_annees);
        //$this->template->set_global('mois', $mois);
        $this->data['participants'] = $participants;
        $this->data['annees'] = $select_annees;
        $this->data['mois'] = $mois;
        $this->template->title = 'Gestion des heures';
        $this->template->content = \View::forge('prestation/index', $this->data);
    }

    public function action_change_participant()
    {

        $form_data = \Input::post();

        $date = new \DateTime();
        $date->setDate($form_data['annee'], $form_data['mois'], '01');



        //on Vérifie que l'on peut introduire des heures
        $prestation_db = new \Model_My_Prestation();
        if ($prestation_db->verif_contrat($form_data['idparticipant'], $date) === false) {
            $msg[] = 'Le participant n\a pas de contrat à cette période';
            \Session::set_flash('error', $msg);
            \Response::redirect('prestation/modifier_participant/');
        }
       // \Session::set('nom', $form_data['nom']);
       // \Session::set('idparticipant', \Input::post('idparticipant'));
        \Session::set('date_prestation', $date);


        \Response::redirect('prestation/modifier_participant/');
    }

    /**
     * Function permettant l'affichage de prestation au départ de la fiche de signalétique
     */

    public function action_change_participant_fiche($nom,$id_participant,$annee,$mois)
    {

        \Session::set('nom', $nom);
        \Session::set('idparticipant',$id_participant);
        /**
         *
         * Création de la date du mois que l'on va travailler et mise en session de celle-ci
         */
        $date = new \DateTime();
        $date->setDate($annee, $mois, '01');
        \Session::set('date_prestation', $date);
        \Response::redirect('prestation/modifier_participant/');
    }

    /**
     * Affiche le méga formulaire qui permet de modifier les heures
     *
     * @param type $id
     * @param type $annee
     * @param type $mois
     */
    public function action_modifier_participant()
    {
        $this->data['modifieur'] = new \stdClass();
        /**
         * partie de code pour récupérer les informations du modifieurs en cas d'erreur.
         */
        if(\Session::get('formdata')){
            $form = \Session::get('formdata');
            $this->data['modifieur']->date1 = $form['date'][0] ;
            $this->data['modifieur']->date2 = $form['date'][1] ;
            $this->data['modifieur']->motif = $form['motif'] ;
            $this->data['modifieur']->heuresprester = $form['heuresprester'] ;
        }


        /**
         * @object objet Datetime créer à la selection du participant.
         */
        $date = \Session::get('date_prestation');

        $id_participant = \Session::get('idparticipant');

        $this->_connexion = new \Model_Heures_Participant();

        //Gestion du menus des contrats
        $db = new \Model_My_Prestation();



        /**
         * Récupération des heures du participant à prester.
         */
        $this->data['heure_prester'] = $this->_connexion->hour_prester($id_participant, $date);
        if ($this->data['heure_prester'] === false) {
            $msg = 'Vous devez absolument editer les heures à prester';
            $this->data['heure_prester'] = $msg;
            $this->_message[] = $msg;
        }
        
     
        /**
         * Récupération des heures déjà prestées
         */
        $prester = $db->get_time_worked($date, $id_participant);

        /**
         * Récupération de la sommes des heures prestée
         */
        $total_heures_mois = $db->total_hours_month($date, $id_participant);


        /**
         * Affichage des heures en boni ou négatif.
         */
        //$total_heures_recup = $db->total_hours_recovery($id_participant, $date);
        $total_heures_recup = $db->get_hour_recup($id_participant,$date);


        /**
         * Récupération des participant pour ne pas changer de page
         */
        $participants_autocomplete = \Model_Participant::find('all', array(
            'where' => array(
                'b_is_actif' => 1
            ),
            'order_by'=>array('t_nom'=>'asc')
        ));

        /**
         *  On vérifie que les heures ne sont pas valider
         */
        $control = \Model_Valider_Heure::find()->where(array(
            'participant_id' => $id_participant,
            't_mois' => $date->format('Y-m-d')
        ))->get_one();


        /**
         * Template
         */
        $tab = $this->template_heure($id_participant);
        $this->data['id_participant'] = $id_participant;
        $this->data['motifs'] = $tab['motifs'];
        $this->data['contrats'] = $tab['contrats'];

        $this->data['total_heures_recup'] = $total_heures_recup;
        $this->data['participants_autocomplete'] = $participants_autocomplete;
        $this->data['total_heures_prester'] = $total_heures_mois;
        $this->data['prester'] = $prester;
        $this->data['participant'] = \Session::get('nom') . ' - ' . ucfirst(\Maitrepylos\Utils::mois($date->format('m')))
            . ' ' . $date->format('Y');

        $this->data['control'] = count($control);

        /**
         * Gestion des $_POST, pour le traitement des heures
         */
        if (\Input::method() == 'POST') {

            $time = new \Maitrepylos\Timetosec();

            $form_data = \Input::post();


            $validate_date = new \Maitrepylos\Date($date->format('t'));

            if ($validate_date->isValid($form_data['date'])) {

                /**
                 * Vérification que l'heure passé est correcte
                 *
                 */
                $val = $this->validation_heures();

                /**
                 * Si l'heure est correcte on fait le traitement.
                 */
                if ($val->run()) {
                    /**
                     * Transformation de l'heure en secondes
                     */
                    $heuresprester = $time->StringToTime($form_data['heuresprester']);
                    /**
                     * Séparation du motif et du Schéma
                     */
                    list ($nom, $schema) = explode(':', $form_data['motif']);
                    $range = \Maitrepylos\Utils::srange($form_data['date'][0] . '-' . $form_data['date'][1]);
                    $count = count($range);

                    for ($i = 0; $i < $count; $i++) {

                        $date_insertion = \DateTime::createFromFormat('Y-m-d', $date->format('Y-m') . '-' . $range[$i]);

                        //Si on modifie les heures, il faut d'abords les supprimer
                        if (\Input::post('action') == 0) {
                            $db->delete_heure($id_participant, $date_insertion->format('Y-m-d'));
                        }

                        if ($db->insertion_heures_prestation($id_participant
                            , $date_insertion, $form_data['t_typecontrat'], $heuresprester, $nom, $schema) === false
                        ) {
                            $this->_message[] = 'Pas de contrat en date du ' . $date_insertion->format('d-m-Y');
                        } else {
                            \Session::set_flash('success', array('Les heures ont été introduites'));
                        }
                    }

                } else {



                    $this->_message[] = $val->show_errors();
                }
            } else {
                /**
                 * Gestion des messages d'erreur du au mauvais passage de date.
                 */
                foreach ($validate_date->get_message() as $message) {

                    $this->_message[] = $message;
                }
            }
            if (count($this->_message) != 0) {

                \Session::set_flash('error', $this->_message);
            }
            \Session::set('formdata',$form_data);
            \Response::redirect('prestation/modifier_participant/');


        }


        $this->template->title = 'Gestion des heures';
        $this->template->content = \View::forge('prestation/fiche', $this->data);
//        } else {
//            $msg[] = 'Vous avez fait une mauvaise manipulation !';
//            \Session::set_flash('error', $msg);
//            \Response::redirect('/');
//        }
    }

    public function action_modifier()
    {

        $id = \Session::get('idparticipant');
        $date = \Session::get('date_prestation');
        $time = new \Maitrepylos\Timetosec();

        // On recupère les infos liées à ce participant pour cette date dans la db
        $participant = \Model_Heures_Fixer::find()->where(array(
            'participant' => $id,
            'd_date' => $date->format('Y-m-d')
        ))->get_one();

        if (\Input::method() == 'POST') {
            $form_data = \Input::post();

            $val = \Model_Heures_Fixer::validate_heures('heures_fixer');
            $val->set_message('required', 'Le champ :label est obligatoire');
            $val->set_message('bland_hour', 'le champ :label doit être de forme 00:00');

            if ($val->run()) {
                /**
                 * Si le participant est à null alors, il faut créer un objet ORM pour pouvoir insérer les données.
                 * Sinon, on dispose déjà d'un objet ORM ligne 160.
                 */
                if ($participant == NULL) {
                    $participant = \Model_Heures_Fixer::forge();
                }

                $participant->d_date = $date->format('Y-m-d');
                $participant->i_heures = $time->StringToTime($form_data['i_heures']);
                $participant->t_motif = 'fixer';
                $participant->participant_id = $id;

                // $prestation = \Model_Heures_Fixer::forge($data);

                if ($participant->save()) {
                    $message[] = 'Heures Fixée';
                    \Session::set_flash('success', $message);
                    \Response::redirect('prestation/modifier_participant');
                } else {
                    $message[] = 'Erreur de base de données, merci de rééssayer plus tard';
                    \Session::set_flash('error', $message);
                    \Response::redirect('prestation/modifier');
                }
            } else {
                $message[] = $val->show_errors();
                \Session::set_flash('error', $message);
            }
        }


        /**
         * Si c'est la première fois qu'on introduits des heures, alors il faut lui afficher 00:00
         */
        $this->data['participant'] = '00:00';
        if ($participant != NULL) {
            $this->data['participant'] = $time->TimeToString($participant->i_heures);
        }
        $this->data['date'] = \Session::get('date_prestation');
        $this->data['nom'] = \Session::get('nom');
        $this->template->title = 'Modification des heures de prestations';
        $this->template->content = \View::forge('prestation/modifier', $this->data);
    }

    /**
     * Méthode de validation des heures.
     * @return type
     */
    public function validation_heures()
    {

        $val = \Validation::forge();

        $val->add_callable('\Maitrepylos\Validation');
        $val->add_field('heuresprester', 'Heures', 'required|bland_hour');
        $val->set_message('bland_hour', 'Le champ :label doit-être sous forme 00:00');

        return $val;
    }

    public function action_supprimer($id, $date)
    {

        $db = new \Model_My_Prestation();
        $db->delete_heure($id, $date);
        \Response::redirect('prestation/modifier_participant/');
    }

    public function action_delete_details($id, $participant, $date)
    {
        $db = new \Model_My_Prestation();
        $db->delete_heure_details($id);
        \Response::redirect('prestation/ajout/' . $participant . '/' . $date);

    }

    public function action_details($id, $date)
    {

        $db = new \Model_My_Prestation();
        $this->data['heure'] = $db->get_details($id, $date);
        $this->data['participant'] = \Session::get('nom');
        $this->template->title = 'Modification des heures de prestations';
        $this->template->content = \View::forge('prestation/detail', $this->data);

    }

    public function action_formateur($id, $date)
    {

        if (\Input::method() == 'POST') {

            $form_data = \Input::post();

            $val = \Validation::forge();
            $val->add_callable('\Maitrepylos\Validation');
            $val->add_field('heuresprester', 'Heures', 'required|bland_hour');
            $val->set_message('required', 'Veuillez remplir le champ :label.');
            $val->set_message('bland_hour', 'Le champ :label doit-être sous forme 00:00');

            list ($nom, $schema) = explode(':', $form_data['motif']);

            // si la validation ne renvoie aucune erreur
            if ($val->run()) {
                $time = new \Maitrepylos\Timetosec();
                $db = new \Model_My_Prestation();
                $heure_db = $db->get_hours($form_data['id_heures']);
                $heure = $time->StringToTime(\Input::post('heuresprester'));

                if ((int)$heure_db[0]['i_secondes'] === (int)$heure) {
                    $db->update_hours($form_data['id_heures'], $heure, $nom, $schema, $form_data['t_typecontrat'], 0);


                } elseif ((int)$heure_db[0]['i_secondes'] < (int)$heure) {

                    $db->update_hours($form_data['id_heures'], $heure, $nom, $schema, $form_data['t_typecontrat'], 0);


                } else {

                    $sub_heures = bcsub((int)$heure_db[0]['i_secondes'], (int)$heure);
                    $db->update_hours($form_data['id_heures'], $sub_heures, $heure_db[0]['t_motif'],$heure_db[0]['t_schema'], $form_data['t_typecontrat'], 1);
                    $db->insertHeures($date, $heure, $nom, $schema, $id, $form_data['t_typecontrat']);
                    \Response::redirect('prestation/formateur/' . $id . '/' . $date);

                }
                \Response::redirect('prestation/modifier_participant');


            } else {

                $message[] = $val->show_errors();
                \Session::set_flash('error', $message);
                \Response::redirect('prestation/formateur/' . $id . '/' . $date);
            }
        }


        /**
         * Template
         */
        $tab = $this->template_heure($id);
        $this->data['motifs'] = $tab['motifs'];
        $this->data['contrats'] = $tab['contrats'];

        $db = new \Model_My_Prestation();
        $this->data['heure'] = $db->get_details($id, $date);
        $this->data['participant'] = \Session::get('nom');
        $this->template->title = 'Modification des heures inséré par les formateur .';
        $this->template->content = \View::forge('prestation/formateur', $this->data);


    }

    public function action_ajout($id, $date)
    {

        $db = new \Model_My_Prestation();
        $this->data['heure'] = $db->get_details($id, $date);

        $date = \DateTime::createFromFormat('Y-m-d', $date);
        if ($db->get_contrat_ajout($id, $date) === false) {

            $message[] = 'Pas de contrat en date du ' . $date->format('d-m-Y');
            \Session::set_flash('error', $message);
            \Response::redirect('prestation/modifier_participant');
        }


        if (\Input::method() == 'POST') {

            $form_data = \Input::post();


            $val = \Validation::forge();
            $val->add_callable('\Maitrepylos\Validation');
            $val->add_field('heuresprester', 'Heures', 'required|bland_hour');
            $val->set_message('required', 'Veuillez remplir le champ :label.');
            $val->set_message('bland_hour', 'Le champ :label doit-être sous forme 00:00');

            list ($nom, $schema) = explode(':', $form_data['motif']);

            // si la validation ne renvoie aucune erreur
            if ($val->run()) {
                $time = new \Maitrepylos\Timetosec();
                $heure = $time->StringToTime(\Input::post('heuresprester'));

                $db->insertHeures($date->format('Y-m-d'), $heure, $nom, $schema, $id, $form_data['t_typecontrat']);
                //\Response::redirect('prestation/modifier_participant');
                \Response::redirect('prestation/ajout/' . $id . '/' . $date->format('Y-m-d'));


            } else {
                $message[] = $val->show_errors();
                \Session::set_flash('error', $message);
                \Response::redirect('prestation/ajout/' . $id . '/' . $date);
            }
        }


        /**
         * Template
         */
        $tab = $this->template_heure($id);
        $this->data['motifs'] = $tab['motifs'];
        $this->data['contrats'] = $tab['contrats'];
        $this->data['date'] = $date->format('Y-m-d');
        $this->data['id'] = $id;



        $this->data['participant'] = \Session::get('nom');
        $this->template->title = 'Modification des heures inséré par les formateur .';
        $this->template->content = \View::forge('prestation/ajout', $this->data);


    }


    public function action_tableau($nom, $id_participant, $date)
    {

        \Session::set('nom', $nom);
        \Session::set('idparticipant', $id_participant);

        $c = explode('-', $date);
        $date = new \Datetime();
        $date->setDate($c[0], $c[1], '01');

        \Session::set('date_prestation', $date);

        \Response::redirect('prestation/modifier_participant/');
        //\Debug::dump(\Session::get());
    }


    public function action_ajout_deplacement()
    {

        $db = new \Model_My_Prestation();
        $date = \Session::get('date_prestation');
        $id = \Session::get('idparticipant');


        if (\Input::method() == 'POST') {
            (\Input::post('supplement') == "") ? $euro = 0 : $euro = \Input::Post('supplement');

            if ($db->get_ajout_deplacement($id, $date)) {
                $db->update_ajout_deplacement($euro, $id, $date);
            } else {
                $db->ajout_deplacement($euro, $id, $date);
            }
        }


        $message[] = 'Déplacemement Ajouté';
        \Session::set_flash('success', $message);
        \Response::redirect('prestation/modifier_participant/');
    }


    public function template_heure($id_participant)
    {
         $date = \Session::get('date_prestation');

        /**
         * Mise en place du template pour la gestions des heures du partiicpant.
         */
        //$motifs = \Cranberry\MyXML::getActivites();

        $motifs = \Model_Activite::find('all',array('order_by'=>array('i_position'=>'asc')));

        $select_motifs = array();
        foreach ($motifs as $value) {
            $nom = $value->t_nom . ':' . $value->t_schema;
            $select_motifs[(string)$nom] = $value->t_nom;
        }
        //Gestion du menus des contrats
        $db = new \Model_My_Prestation();


        $select_contrats = array();
        $contrats = $db->select_contrat($id_participant,$date);

        foreach ($contrats as $value) {
            $select_contrats[$value['id_contrat']] = $value['t_type_contrat'];
        }

        $tab = array(
            'motifs' => $select_motifs,
            'contrats' => $select_contrats
        );
        return $tab;


    }


    public function action_est_valide()
    {

        $db = new \Model_My_Prestation();
        $heures_participant = new \Model_Heures_Participant();
        $id = \Session::get('idparticipant');
        $date_prestation = \Session::get('date_prestation');
        // Permet de savoir dans quelle situation nous nous trouvons
        $situation = 0;
        $pourcentage = 0;
        $heure_a_ajouter = 0;
        $array = array();

        if($db->verifie_formateur($id,$date_prestation) == false){

            $message[] = 'Il reste des heures formateurs non validé !';
            \Session::set_flash('error', $message);
            \Response::redirect('prestation/modifier_participant');

        }


        //on fais en sorte de vérifier que l'ensemble des heures précédent le mois en cours est valide.
        //Si d'autres mois ne sont pas valider on l'affiche

        //on récupère la date du premier contrat
        $date_premier_contrat = $db->get_date_first_contrat($id);
        $date_premier_contrat->setDate($date_premier_contrat->format('Y'), $date_premier_contrat->format('m'), 01);
        //$date_premier_contrat_bis = clone $date_premier_contrat;
        $interval_mois = \Maitrepylos\Date::nbMois($date_prestation, $date_premier_contrat);


        for ($i = 0; $i < $interval_mois; $i++) {


            //nous vérifions que les mois antérieur sont bien validés
            $compteur = $db->verifie_valide($id, $date_premier_contrat);

            if ($compteur[0]['compteur'] === '0') {

                $array[] = array(
                    'date' => $date_premier_contrat->format('Y-m-d'),
                    'annee' => $date_premier_contrat->format('Y'),
                    'mois' => \Maitrepylos\Utils::mois($date_premier_contrat->format('m')),
                    'nom' => \Session::get('nom'),
                    'id' => $id);

            }

            $date_premier_contrat->add(new \DateInterval('P1M'));


        }

        if (count($array) > 1) {
            //dans le cas présent, nous avons retrouver des mois non validés, nous renvoyons
            //vers la méthode aValiderAction
            \Session::set('tableau', $array);
            $message[] = 'Vous devez d\'abord valider les mois suivants ';

            \Session::set_flash('error', $message);
            \Response::redirect('prestation/a_valider');

        }

        // A l'inverse si nous validons un mois, alors que d'autres mois supérieur à la date sont validé,
        //cela risque de ne plus correspondre, donc nous dévalidons l'entièrté des prestations validés.

        $verifie_superieur_date = \Model_Valider_Heure::find()->where(array(
            'participant_id' => $id,
            array('t_mois', '>', $date_prestation->format('Y-m-d'))
        ))->get();


        if (count($verifie_superieur_date) > 0) {

            $message[] = 'Vous devez d\'abord dévalidez les mois superieur à la date ';

            \Session::set_flash('error', $message);
            \Response::redirect('prestation/devalider/0');

        }


        $recupere_situation_mois = $db->get_recapitulatif($id, $date_prestation);
        //recupère les heures d'absences
        $absent = \SplFixedArray::fromArray($db->get_absent($id, $date_prestation));
        if ($absent->getSize() === 0) {
            unset($absent);
            $absent[0] = array('i_secondes' => 0);
        }
        ;

        //compte le nombre d'itération afin de faire une boucle pour mettre le résultat au standard choisi
        $count = count($recupere_situation_mois);
        $time = new \Maitrepylos\timetosec();

        $total_prester = $db->total_hours_month_valid($date_prestation, $id);
        if ($total_prester[0]['fullTime'] == NULL) {

            $total_prester[0]['fullTime'] = '0000';
        }

        /**
         * Afficher les heures du mois à prester(en janvier, en février ....) en fonction de son temps de travail.
         * Ou si un changement de regime de travail     a été effectuer on affiche ce qui se trouve dans
         * la table heures_fixer
         */
        $heure_a_prester = $heures_participant->hour_prester($id, $date_prestation);

        if ($heure_a_prester == null) {

            $message[] = 'Dans votre situation vous devez absolument fixer des heures';
            \Session::set_flash('error', $message);
            \Response::redirect('prestation/modifier');

        }

        $total_mois = $db->total_hours_month($date_prestation, $id);

        $heure_a_prester = $time->StringToTime($heure_a_prester);
        $mois_no_string = $time->StringToTime($total_mois);

        if (($mois_no_string - $heure_a_prester) < 0) {


            if ((($mois_no_string + $absent[0]['i_secondes']) - $heure_a_prester) < 0) {

                $situation = 1;

            } elseif ((($mois_no_string + $absent[0]['i_secondes']) - $heure_a_prester) > 0) {
                //dans la situation présente, si nous compenssons avec le total des heures d'absences, le participant
                //se retrouveras avec des heures supplémentaires, ce qui n'est pas l'effet rechercher

                $somme_total = ($total_mois + $absent[0]['i_secondes']) - $heure_a_prester;
                $heure_a_ajouter = $absent[0]['i_secondes'] - $somme_total;
                $situation = 2;
            } else {

                $heure_a_ajouter = $absent[0]['i_secondes'];
                $situation = 3;

            }

        } else {
            $heure_a_ajouter = 0;
            $situation = 3;
        }

        /**
         * Calcul pour afficher le résumé du mois
         */

        $resume['resultat'] = $time->TimeToString($heure_a_prester - $mois_no_string);
        /**
         * juste pour que l'affichage soit correcte.
         */
        if ($heure_a_prester < $mois_no_string) {
            $resume['resultat'] = $time->TimeToString($mois_no_string - $heure_a_prester);
        }
        if ($heure_a_prester === $mois_no_string) {
            $resume['resultat'] = 0;
        }
        $resume['heure_a_pretser'] = $time->TimeToString($heure_a_prester);


        /**
         * Calcul des pourcentages à afficher.
         */

        for ($i = 0; $i < $count; $i++) {

            $recupere_situation_mois[$i]['pourcentage'] = round(($recupere_situation_mois[$i]['i_secondes']
                / $heure_a_prester) * 100, 3);
            $recupere_situation_mois[$i]['i_secondes'] = $time->TimeToString($recupere_situation_mois[$i]['i_secondes']);
            $pourcentage = $pourcentage + $recupere_situation_mois[$i]['pourcentage'];

        }


        $this->template->set_global('resume', $resume);
        $this->template->set_global('heure_ajouter', $heure_a_ajouter);
        $this->template->set_global('id', $id);
        $this->template->set_global('date', $date_prestation);
        $this->template->set_global('nom', \Session::get('nom'));
        $this->template->set_global('total_heures_prester', $total_mois);
        $this->template->set_global('total_pourcentage', $pourcentage);
        $this->template->set_global('tableau', $recupere_situation_mois);
        $this->template->set_global('situation', $situation);

        $this->template->title = 'Validation des documents';
        $this->template->content = \View::forge('prestation/valide/valide');
        // $this->template->content = \View::forge('test');

    }

    public function action_a_valider()
    {


        $count = count(\Session::get('tableau'));
        $this->data['s'] = array(
            'tableau' => \Session::get('tableau'),
            'compteur' => $count
        );


        $this->template->title = 'Validation des documents';
        $this->template->content = \View::forge('prestation/valide/a_valide', $this->data);

    }

    /**
     * Nous validons les heures de prestations
     * @param $id
     * @param $heures
     * @param $date
     *
     */
    public function action_valider($id, $heures, $date)
    {

        $db = new \Model_My_Prestation();
        $db->valider($id, $heures, $date);
        \Response::redirect('prestation/modifier_participant/');


    }

    public function action_supprime_valide()
    {
        $date = \Session::get('date_prestation');
        $id_participant = \Session::get('idparticipant');
        $valide = \Model_Valider_Heure::find()->where(array(
            'participant_id' => $id_participant,
            't_mois' => $date->format('Y-m-d')
        ));
        $valide->delete();
        \Response::redirect('prestation/modifier_participant/');


    }

    public function action_devalider($count)
    {

        if ($count == 1) {
            $date = \Session::get('date_prestation');
            $id = \Session::get('idparticipant');
            $verifie = \Model_Valider_Heure::find()->where(array(
                'participant_id' => $id,
                array('t_mois', '>', $date->format('Y-m-d'))
            ));
            $verifie->delete();
            \Response::redirect('prestation/modifier_participant/');

        }

        $this->template->title = 'Validation des documents';
        $this->template->content = \View::forge('prestation/valide/devalide');

    }

    public function action_est_valide_formateur()
    {

        $db = new \Model_My_Prestation();

        $date = \Session::get('date_prestation');
        $id = \Session::get('idparticipant');
        $db->update_formateur($id, $date);
        \Response::redirect('prestation/modifier_participant/');

    }

}

?>
