<?php

namespace Document;

/**
 * Controller gérant toute la partie "Participant".
 */
class Controller_Document extends \Controller_Main
{
    public $title = 'Impression';
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
            \Session::set('direction', '/document');
            \Response::redirect('users/login');
        } else if (!\Auth::member(100)) {
            \Response::redirect('users/no_rights'); #7F7F7F
        }
    }


    public function action_index()
    {

        $this->template->title = 'Gestion des impressions';
        $this->template->content = \View::forge('document/index', $this->data);


    }

    /**
     * @see Methode gerant la generation du PDF fiche_paye
     * @method fiche_paye
     * @return file PDF
     */
    public function action_fichepaye($id, $date)
    {
        //$id = \Session::get('id_participant');
        //$date_prestation = \Session::get('date_prestation');
        $date_prestation = \DateTime::createFromFormat('Y-m-d', $date);

        $db_prestation = new \Model_My_Prestation();

        $valide = $db_prestation->verifie_valide($id, $date_prestation);

        if ($valide[0]['compteur'] < 1) {

            $message[] = 'Vous devez d\abord validez le mois';
            \Session::set_flash('error', $message);
            \Response::redirect('prestation/modifier_participant');

        } else {

            $db = new \Model_My_Document();

            $nom_mois = \Maitrepylos\Utils::mois($date_prestation->format('m'));
            $maj_nom_mois = 'jours_' . $nom_mois;
            $form_data = array();

            //on récupère les contrats

            $form_data = $db_prestation->get_contrat_full($id, $date_prestation, $nom_mois, $maj_nom_mois);

            $nombres_contrat = count($form_data);


            for($i = 0; $i < $nombres_contrat; $i++) {

                /**
                 * récupération des informations du participant suivante:
                 * nom
                 * prénom
                 * compte bancaire
                 * le moyen de transport
                 *
                 */


                $form_data[$i]['user'] = $db->getParticipant($id);
                //le mois de la prestation, à enlever plus tard on possède l'info dans date_prestation
                $form_data[$i]['mois'] = $date_prestation->format('m');
                //l'année de la prestation à enlever plus tard on possède l'info dans date_prestation
                $form_data[$i]['annee'] = $date_prestation->format('Y');

                /**
                 * récupération d'un groupe liés à un contrat
                 *
                 * C'est ici que nous allons dans la suite récupérer plusieurs contrats
                 */

                $form_data[$i]['groupe'] = $db->get_groupe($form_data[$i]['id_contrat']);

                //récupérations des heures encodée en fonctions de l'année et du mois

                $rows = $db->heures_mois($id, $date_prestation, $form_data[$i]['id_contrat']);
                //calcul pour eventuellement faire 2 fiches
                $form_data[$i]['count'] = ceil((count($rows)) / 28);

                $size = (int)28 * $form_data[$i]['count'];
                $form_data[$i]['rows'] = \SplFixedArray::fromArray($rows);
                $form_data[$i]['rows']->setSize($size);


                //Recupere le nombre d'heures à effectuer pour un mois donnee
                $form_data[$i]['max_heure'] = $db->get_heures_a_effectuer($date_prestation, $id, 1);
                $deplacement[$i]['t_abonnement'] = 0; //cas de l'art 60
                $form_data[$i]['deplacement'] = 0;


                //Récupère le nombres de jours effectués le mois en cours
                $form_data[$i]['nombres_jours'] = $db_prestation->get_jours_deplacememnt($id,
                    $form_data[$i]['id_contrat'], $date_prestation);

                $form_data[$i]['ajout_deplacemement'] = $db_prestation->get_ajout_deplacement($id, $date_prestation);


                $form_data[$i]['total_heures_mois'] = $db->total_heure_mois($id, $date_prestation, $form_data[$i]['id_contrat']);


                //Si le contrat permet de gérer le salaire du stagiaire.
                if ($form_data[$i]['i_paye'] == 1) {

                    $form_data[$i]['deplacement'] = $db_prestation->get_deplacement($form_data[$i]['jours'],
                        $form_data[$i]['nombres_jours'][0]['compteur'], $form_data[$i]['id_contrat']);


                    $form_data[$i]['salaire'] = $db->salaire($form_data[$i]['heures'],
                        $form_data[$i]['total_heures_mois'][0]['fulltime'], $form_data[$i]['f_tarif_horaire']);
                }


                // Calcul les heures d'absences justifier
                $form_data[$i]['heure_justifier'] = $db->total_heure_mois_justifier($id, $date_prestation,
                    $form_data[$i]['id_contrat']);
                //Calcul les heures d'absences non justifier
                $form_data[$i]['heure_non_justifier'] = $db->total_heure_mois_non_justifier($id,
                    $date_prestation, $form_data[$i]['id_contrat']);
                //Calcul le nombres d'heures effectuer au total de la formation
                $form_data[$i]['heure_total_formation'] = $db_prestation->get_heure_total_formation($id, $date_prestation);
                $form_data[$i]['heure_recup'] = $db_prestation->get_hour_recup($id, $date_prestation);
            }

            // \Debug::dump($form_data);


            \Maitrepylos\Pdf\Paye::pdf($form_data, $nombres_contrat);
            $this->template->title = 'Gestion des documents';
            $this->template->content = \View::forge('test');


        }
    }


    /**
     * @see Methode gerant la generation du PDF c98
     * @method c98
     * @return file PDF
     */
    public function action_c98($date, $nom_centre, $groupe = Null, $id = NULL)
    {


        $date_prestation = \DateTime::createFromFormat('Y-m-d', $date);

        $form_data = array();

        $db = new \Model_My_Document();

        $coordonnees = \Cranberry\MyXML::getCoordonnees();

        foreach($coordonnees as $centre) {

            if ($centre->nom_centre == $nom_centre) {

                $result = $centre;
            }


        }

        //todo regarder à remplacer la boucle par xpath
        //$result = $coordonnees->xpath("/coordonnee/centre/[nom_centre='Pontaury']");

        if ($id != NULL) {
            $form_data = $db->get_c98_solo($id);
        } else {
            $form_data = $db->get_c98_full($groupe, $date_prestation);
        }
        // \Debug::dump($groupe);

        \Maitrepylos\Pdf\C98::pdf($form_data, $result, $date_prestation);
        $this->template->title = 'Gestion des documents';
        $this->template->content = \View::forge('test');
        // My_Pdf_C98::pdf($formData, $coordonnees, $date_prestation);
    }


    public function action_l1()
    {
        $db = new \Model_My_Document();
        $formData = \Input::post();

        list ($groupe, $cedefop) = explode(':', $formData['groupe']);
        $formData['cedefop'] = $cedefop;
        $formData['groupe'] = $groupe;

        $coordonnees = \Cranberry\MyXML::getCoordonnees();
        $nom_centre = \SplFixedArray::fromArray(explode('-', $formData['groupe']));
        $nom_centre->setSize(3);

        foreach($coordonnees as $centre) {

            if ($centre->nom_centre == $nom_centre[1] || $centre->nom_centre == $nom_centre[2]) {

                $formData['xml'] = $centre;
            }
        }
        //compte le nombres de jours entre deux date
        $s = strtotime($formData['date2']) - strtotime($formData['date']);
        $count = intval($s / 86400) + 1;

        $date = \DateTime::createFromFormat('d-m-Y', $formData['date']);


        for($i = 0; $i < $count; $i++) {
            //$dateFormater = $date->format('Y-m-d');
            $formData['new_date'][$i] = $date->format('d-m-Y');
            $rows = $db->groupe_l1($groupe, $date->format('Y-m-d'));
            $formData['count'][$i] = count($rows);
            $formData['nombre'][$i] = ceil($formData['count'][$i] / 18);

            $size = (int)18 * $formData['nombre'][$i];
            $formData['rows'][$i] = \SplFixedArray::fromArray($rows);
            $formData['rows'][$i]->setSize($size);


            $date->add(new \DateInterval('P1D'));
            //$this->calculeDateEcheance($date, self::AJOUTE_1_JOUR);
        }

        $formData['compteur'] = count($formData['count']);
        if ($formData['doc'] == '1') {
            \Maitrepylos\Pdf\L1::pdf($formData);
        } else {
            \Maitrepylos\Pdf\L1Bis::pdf($formData);
        }


        $this->template->title = 'Gestion des documents';
        $this->template->content = \View::forge('test');


    }

    public function action_l2()
    {
        $db = new \Model_My_Document();
        $formData = \Input::post();

        $filiere = \Model_Filiere::find($formData['filiere'], array('related' => array('agrements')));
        $formData['filieres'] = $filiere;

       /* list ($groupe, $cedefop) = explode(':', $formData['groupe']);
        $formData['cedefop'] = $cedefop;
        $formData['groupe'] = $groupe;*/

//        $coordonnees = \Cranberry\MyXML::getCoordonnees();
//        $nom_centre = \SplFixedArray::fromArray(explode('-', $formData['groupe']));
//        $nom_centre->setSize(3);
//
//        foreach($coordonnees as $centre) {
//
//            if ($centre->nom_centre == $nom_centre[1] || $centre->nom_centre == $nom_centre[2]) {
//
//                $formData['xml'] = $centre;
//            }
//        }

//        $formData['centre'] = \Model_Centre::find('all', array(
//            'where' => array(
//                array('i_position', 1))));

       $centre = \DB::select()->from('centre')->where('i_position', 1)->execute();
       $formData['centre'] = $centre->as_array();



        $date = \DateTime::createFromFormat('Y-m-d', $formData['annee'] . '-' . $formData['mois'] . '-01');
        $id_participant = $db->nombreParticipantEntreDeuxDate($date, $formData['filiere']);
        if ($id_participant != null) {
            $count_id_participant = count($id_participant[0]);
        } else {

            $message[] = 'Nous ne disposons pas de données pour ce L2.';
            \Session::set_flash('error', $message);
            \Response::redirect('/document/formulaire/l2');

        }


        $eft = 0;
        $gratuit = 0;
        $payant = 0;
        $stage = 0;
        $assimile = 0;


        for($d = 0; $d < $date->format('t'); $d++) {
            $eft_jours = 0;
            $gratuit_jours = 0;
            $payant_jours = 0;
            $stage_jours = 0;
            $assimile_jours = 0;
            for($b = 0; $b < $count_id_participant; $b++) {


                /**
                 * Ne pas tenir compte des heures de récup : schéma '-'
                 */
                /*$db_eft = $db->calculHeuresMoisStatL2($id_participant[$b]['participant_id'], "'+','-'", $date);*/
                $db_eft = $db->calculHeuresMoisStatL2($id_participant[$b]['participant_id'], "'+'", $date);
                $eft_jours = $eft_jours + $db_eft[0]['iSum'];
                $eft = $eft + $db_eft[0]['iSum'];

                $db_gratuit = $db->calculHeuresMoisStatL2($id_participant[$b]['participant_id'], "'$'", $date);
                $gratuit_jours = $gratuit_jours + $db_gratuit[0]['iSum'];
                $gratuit = $gratuit + $db_gratuit[0]['iSum'];

                $db_payant = $db->calculHeuresMoisStatL2($id_participant[$b]['participant_id'], "'@','#'", $date);
                $payant_jours = $payant_jours + $db_payant[0]['iSum'];
                $payant = $payant + $db_payant[0]['iSum'];

                $db_stage = $db->calculHeuresMoisStatL2($id_participant[$b]['participant_id'], "'='", $date);
                $stage_jours = $stage_jours + $db_stage[0]['iSum'];
                $stage = $stage + $db_stage[0]['iSum'];

                $db_assimile = $db->calculHeuresMoisStatL2($id_participant[$b]['participant_id'], "'/'", $date);
                $assimile_jours = $assimile_jours + $db_assimile[0]['iSum'];
                $assimile = $assimile + $db_assimile[0]['iSum'];

                // $formData[$groupe[$a]->dos_groupe][My_Classe_Utils::mois($i+1)]['eft'] = $filtre->TimeToString($eft[0]->fulltime);
                //var_dump($id_groupe);
            }
            $data[$d]['heures_date'] = $d + 1;
            $data[$d]['eft'] = $eft_jours;
            $data[$d]['gratuit'] = $gratuit_jours;
            $data[$d]['payant'] = $payant_jours;
            $data[$d]['stage'] = $stage_jours;
            $data[$d]['assimile'] = $assimile_jours;
            $date->add(new \DateInterval('P1D'));
        }
        $formData['jours'] = \SplFixedArray::fromArray($data);
        $formData['jours']->setSize(32);

        $formData['eft'] = $eft;
        $formData['gratuit'] = $gratuit;
        $formData['payant'] = $payant;
        $formData['stage'] = $stage;
        $formData['assimile'] = $assimile;

        \Maitrepylos\Pdf\L2::pdf($formData);

      //  \Debug::dump($formData);

        $this->template->title = 'Gestion des documents';
        $this->template->content = \View::forge('test');

    }

    public function action_signaletique()
    {
        $db = new \Model_My_Document();
        $formData = \Input::post();

        $data = $db->fiche($formData['idparticipant']);

        \Maitrepylos\Debug::dump($data);
        if ($data == null) {
            $message[] = 'la fiche du participant est imcomplète, en générale il y a un souci avec ses contrats.';
            \Session::set_flash('error', $message);
            \Response::redirect('/document/formulaire/signaletique');
        } else {

            if ($formData['fiche'] == 1) {
                \Maitrepylos\Pdf\Signaletique::pdf($data[0]);
            } else {
                \Maitrepylos\Pdf\Signaletiqued::pdf($data[0]);
            }
        }

        $this->template->title = 'Gestion des documents';
        $this->template->content = \View::forge('test');

    }

    public function action_formation($n)
    {
        $db = new \Model_My_Document();
        $formData = \Input::post();

        $data = $db->fiche($formData['idparticipant']);


        if ($n == 1) {
            $coordonnees = \Cranberry\MyXML::getCoordonnees();
            $nom_centre = \SplFixedArray::fromArray(explode('-', $data[0]['t_nom']));
            $nom_centre->setSize(3);

            foreach($coordonnees as $centre) {

                if ($centre->nom_centre == $nom_centre[1] || $centre->nom_centre == $nom_centre[2]) {

                    $xml = $centre;
                }
            }
            \Maitrepylos\Pdf\Formation::pdf($data[0], $xml);
        } elseif ($n == 2) {

            \Maitrepylos\Pdf\Deplacement::pdf($data[0]);
        }


        $this->template->title = 'Gestion des documents';
        $this->template->content = \View::forge('test');

    }

    public function action_prestation()
    {
        $db = new \Model_My_Document();
        $formData = \Input::post();
        $groupe = \Model_Groupe::find($formData['groupe']);
        $coordonnees = \Cranberry\MyXML::getCoordonnees();
        $nom_centre = \SplFixedArray::fromArray(explode('-', $groupe['t_nom']));
        $nom_centre->setSize(3);

        foreach($coordonnees as $centre) {

            if ($centre->nom_centre == $nom_centre[1] || $centre->nom_centre == $nom_centre[2]) {

                $xml = $centre;
            }
        }
        $formData['xml'] = $xml;
        $date = \DateTime::createFromFormat('d-m-Y', $formData['date']);
        $date2 = \DateTime::createFromFormat('d-m-Y', $formData['date2']);
        $id = $db->idEtatPretsation($formData['groupe'], $date, $date2);

        $count_id = count($id[0]);
        $id_participant = '';
        for($i = 0; $i < $count_id; $i++) {
            if (($i + 1) < $count_id) {
                $id_participant = $id_participant . $id[$i]['participant'] . ',';
            } else {
                $id_participant = $id_participant . $id[$i]['participant'];
            }
        }

        for($i = 0; $i < $count_id; $i++) {
            $formData['rows'][$i] = $db->ficheEtatPrestationFormation($formData['groupe'], $date, $date2, $id[$i]['participant']);
            $rows = $db->ficheEtatPrestationStage($date, $date2, $id[$i]['participant']);
            if ($rows != null) {
                $formData['rows'][$i][0]['time_partenaire_stage'] = $rows[0]['time_partenaire_stage'];
                $formData['rows'][$i][0]['time_total_stage'] = $rows[0]['time_total_stage'];
                $formData['rows'][$i][0]['compteur_stage'] = $rows[0]['compteur_stage'];
            }
            if ($formData['rows'][$i][0]['t_registre_national'] == NULL) {
                $formData['rows'][$i][0]['t_registre_national'] = $rows[0]['t_registre_national'];
            }
        }

        $maladie = $db->ficheEtatPrestationMaladie($formData['groupe'], $date, $date2, $id_participant);
        $count_maladie = count($maladie);
        for($i = 0; $i < $count_maladie; $i++) {
            $formData['rows'][][] = $maladie[$i];
        }

        $formData['count'] = ceil((count($formData['rows'])) / 11);

        $trie = new \Model_My_Alphabetique();

        $recup = $trie->ordre_alphabetique($formData['rows']);
        $formData['rows'] = NULL;
        $formData['rows'] = \SplFixedArray::fromArray($recup);
        $formData['rows']->setSize($formData['count'] * 11);


        \Maitrepylos\Pdf\Etatprestation::pdf($formData);

        $this->template->title = 'Gestion des documents';
        $this->template->content = \View::forge('test');

    }

    public function action_liste()
    {
        $db = new \Model_My_Document();
        $formData = \Input::post();

        $this->data['liste'] = $db->listeStagiaire($formData['groupe']);
        $this->data['groupe'] = \Model_Groupe::find($formData['groupe']); //$formData['groupe'];
        $count = count($this->data['liste']);
        for($i = 0; $i < $count; $i++) {
            $contrat = $db->dateContrat($this->data['liste'][$i]['id_contrat']);
            $this->data['liste'][$i]['d_date_debut_contrat'] = $contrat[0]['d_date_debut_contrat'];
            $this->data['liste'][$i]['d_date_fin_contrat_prevu'] = $contrat[0]['d_date_fin_contrat_prevu'];


        }


        //\Maitrepylos\Excel\Listestagiaire::excel($data, $groupe->t_nom);

        $this->template->title = 'Gestion des documents';
        $this->template->content = \View::forge('document/liste', $this->data);
        // $this->template->content = \View::forge('test');


    }

    public function action_liste_excel($id_groupe)
    {
        $db = new \Model_My_Document();

        $data = $db->listeStagiaire($id_groupe);
        $groupe = \Model_Groupe::find($id_groupe);
        $count = count($data);

        for($i = 0; $i < $count; $i++) {
            $contrat = $db->dateContrat($data[$i]['id_contrat']);
            $data[$i]['d_date_debut_contrat'] = $contrat[0]['d_date_debut_contrat'];
            $data[$i]['d_date_fin_contrat_prevu'] = $contrat[0]['d_date_fin_contrat_prevu'];


        }


        //\Debug::dump($groupe->t_nom);

        \Maitrepylos\Excel\Listestagiaire::excel($data, $groupe->t_nom);

        $this->template->title = 'Gestion des documents';
        //$this->template->content = \View::forge('document/liste',$this->data);
        $this->template->content = \View::forge('test');


    }

    public function action_inscription()
    {
        $db = new \Model_My_Document();
        $formData = \Input::post();

        $annee = $formData['annee'];
        // echo $this->_request->getPost('trimestre');

        switch($formData['trimestre']) {
            case 1:
                $date1 = "$annee-01-01";
                $date2 = "$annee-03-31";
                break;
            case 2:
                $date1 = "$annee-04-01";
                $date2 = "$annee-06-30";
                break;
            case 3:
                $date1 = "$annee-07-01";
                $date2 = "$annee-09-30";
                break;
            case 4:
                $date1 = "$annee-10-01";
                $date2 = "$annee-12-31";
                break;
            default:
                $date1 = "$annee-01-01";
                $date2 = "$annee-03-31";
                break;
        }


        $this->template->title = 'Gestion des documents';
        //$this->template->content = \View::forge('document/liste',$this->data);
        $this->template->content = \View::forge('test');


    }


}
