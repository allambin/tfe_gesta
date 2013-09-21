<?php

namespace Contrat;

use Fuel\Core\Input;
use Maitrepylos\Debug;

class Controller_Contrat extends \Controller_Main
{

    public $view_dir = 'contrat';
    public $title = 'Contrat';
    public $data = array();

//    // Selon la doc, à overwriter à la place de __construct()
    public function before($data = null)
    {
        parent::before();


        if ($this->current_user == NULL) {
            \Session::set('direction', 'gesta/choisir/contrat/');
            \Response::redirect('users/login');
        }
    }


    public function action_index()
    {

        \Response::redirect('gesta/choisir/contrat/');
    }

    public function action_ajouter($id = NULL)
    {

        if ($id === null) {
            $message[] = 'Impossible de trouver le participant.';
            \Session::set_flash('error', $message);
            \Response::redirect('/gesta/choisir/contrat');
        }
        //on instancie un objet doctrine personalisé

        $db_contrat = new \Model_My_Contrat();


        if (Input::method() == 'POST') {
            //On récupère les heures du contrat de travail
            $heures = \Model_Contrat::getTempTravail(\Input::post('type_contrat'));
            $val = \Model_Contrat::validate('create_contrat');
            //on vérifie que l'on ne dépasse pas 100% de travail sur plusieurs contrat
            $true = true;
            $nombre_jours = $db_contrat->getJoursTravail(\Input::post('d_date_fin_contrat_prevu'), \Input::post('d_date_debut_contrat'));

            $nombre_jours[0]['jour']++;
            $a = array();
            for ($i = 0; $i < $nombre_jours[0]['jour']; $i++) {
                $b = $db_contrat->verifContrat($id, \Input::post('d_date_debut_contrat'), $i);
                //144000 = à 40heures en secondes.

                if (($b[0]['somme'] + (int)$heures) > 144000) {
                    $a[] = $b[0]['jour'];
                    $true = false;
                }
            }
            if (!$true) {
                $message[] = '<ul><li>Vous dépassez les 40h semaines entre ces deux périodes '
                    . \MaitrePylos\date::db_to_date(current($a)) . ' et ' . \MaitrePylos\date::db_to_date(end($a)) . '</li></ul>';
            }

            //on vérifie que l'on garde le même groupe durant les mêmes périodes.
            if ($db_contrat->verifGroupeContrat($id, Input::post('groupe'), Input::post('d_date_debut_contrat'), Input::post('d_date_fin_contrat_prevu')) === false) {
                $message[] = 'Vous ne pouvez pas mélanger les groupes';
                $true = false;
            }


            $val->set_message('max_length', 'Le champ :label doit faire maximum :param:1 chiffres');
            //$val->set_message('exceeds_onehundred', 'Le :label ne peut dépasser 100');
            //J'ajoute ici la vérification des dates, car il n'est pas possible de le faire dans \model_contat
            $val->add_field('d_date_fin_contrat_prevu', 'Date Fin de contrat prévu', 'required|date_less[' . \Input::post('d_date_debut_contrat') . ']');
            $val->add_field('d_date_debut_contrat', 'Formation ', 'eighteen_months_more[' . \Input::post('d_date_fin_contrat_prevu') . ']');
            $val->add_field('f_frais_deplacement', 'Frais de déplacement', 'valid_string[numeric]');
            $val->set_message('date_less', 'La :label ne peut être inférieure à la date de début de contrat');
            $val->set_message('eighteen_months_more', 'La :label ne peut être supérieure à 18 mois');
            $val->set_message('f_frais_deplacement', 'Le :label doit-etre numérique');


            if ($val->run() && $true) {
                $avertissement_1 = (\Input::post('d_avertissement1') != "") ? \MaitrePylos\date::date_to_db(Input::post('d_avertissement1')) : NULL;
                $avertissement_2 = (\Input::post('d_avertissement2') != "") ? \MaitrePylos\date::date_to_db(Input::post('d_avertissement2')) : NULL;
                $avertissement_3 = (\Input::post('d_avertissement3') != "") ? \MaitrePylos\date::date_to_db(Input::post('d_avertissement3')) : NULL;
                $dateDemande = (\Input::post('d_date_demande_derogation_rw') != "") ? \MaitrePylos\date::date_to_db(Input::post('d_date_demande_derogation_rw')) : NULL;
                $dateDemandeForem = (\Input::post('d_date_demande_forem') != "") ? \MaitrePylos\date::date_to_db(Input::post('d_date_demande_forem')) : NULL;
                $dateDemandeOnem = (\Input::post('d_date_demande_onem') != "") ? \MaitrePylos\date::date_to_db(Input::post('d_date_demande_onem')) : NULL;
                $dateReponseOnem = (\Input::post('d_date_reponse_onem') != "") ? \MaitrePylos\date::date_to_db(Input::post('d_date_reponse_onem')) : NULL;
                $dateFinContrat = (\Input::post('d_date_fin_contrat') != "") ? \MaitrePylos\date::date_to_db(Input::post('d_date_fin_contrat')) : NULL;


                $contrat = \Model_Contrat::forge(array(
                    // "i_temps_travail" => Input::post('i_temps_travail');
                    "i_temps_travail" => $heures,
                    "d_date_debut_contrat" => \MaitrePylos\date::date_to_db(Input::post('d_date_debut_contrat')),
                    "d_date_fin_contrat" => $dateFinContrat,
                    "d_date_fin_contrat_prevu" => \MaitrePylos\date::date_to_db(Input::post('d_date_fin_contrat_prevu')),
                    "t_remarque" => Input::post('t_remarque'),
                    "f_frais_deplacement" => Input::post('f_frais_deplacement'),
                    "t_duree_innoccupation" => Input::post('t_duree_innoccupation'),
                    "b_derogation_rw" => Input::post('b_derogation_rw'),
                    "t_abonnement" => Input::post('t_abonnement'),
                    "f_tarif_horaire" => Input::post('f_tarif_horaire'),
                    "t_situation_sociale" => Input::post('t_situation_sociale'),
                    "type_contrat_id" => Input::post('type_contrat'),
                    "groupe_id" => Input::post('groupe'),
                    "d_avertissement1" => $avertissement_1,
                    "d_avertissement2" => $avertissement_2,
                    "d_avertissement3" => $avertissement_3,
                    "participant_id" => $id,
                    'b_necessaire' => Input::post('b_necessaire'),
                    'd_date_demande_derogation_rw' => $dateDemande,
                    'b_reponse_forem' => Input::post('b_reponse_forem'),
                    'd_date_demande_forem' => $dateDemandeForem,
                    'b_reponse_rw' => Input::post('b_reponse_rw'),
                    'b_dispense_onem' => Input::post('b_dispense_onem'),
                    'd_date_demande_onem' => $dateDemandeOnem,
                    'd_date_reponse_onem' => $dateReponseOnem,
                    't_passe_professionnel' => Input::post('t_passe_professionnel'),
                    't_ressource' => Input::post('t_ressource'),
                    't_connaissance_eft' => Input::post('t_connaissance_eft')
                ));

                if ($contrat->save()) {

                    $success[] = 'Contrat Ajouté !';
                    \Session::set_flash('success', $success);
                    \Response::redirect('contrat/ajouter/' . $id);

                } else {

                    \Session::set_flash('error', 'Erreur de base de données, merci de reccommencé !');
                    \Response::redirect('contrat/ajouter/' . $id);
                }
            }
            $message[] = $val->show_errors();
            \Session::set_flash('error', $message);
        }


        $this->data['id_participant'] = $id;

        $this->template->title = 'Nouveau contrat';
        $this->data['viewcontrat'] = $db_contrat->getContrat($id);
        // $this->template->set_global('viewcontrat', $db_contrat->getContrat($id));
        $this->data['statut'] = \Model_My_Contrat::get_statut_entree();
        $this->data['getcontrat'] = \Model_Type_Contrat::getNames();
        $this->data['getgroupe'] = \Model_Groupe::getNames();
        //Récupération du nom du particitant
        $this->data['participant'] = \Model_Participant::find($id);


        $this->template->content = \View::forge('contrat/ajouter', $this->data);
    }

    public function action_supprimer($id, $id_participant)
    {
        $db = new \Model_My_Contrat();
        $db->deleteContrat($id);
        $success[] = 'Contrat Supprimé !';
        \Session::set_flash('success', $success);
        \Response::redirect('contrat/ajouter/' . $id_participant);
    }

    public function action_modifier($id = null, $id_participant = null)
    {

        $participant = \Model_Participant::find($id_participant);
        $contrat = \Model_Contrat::find($id);


        if (Input::method() == 'POST') {
            $db_contrat = new \Model_My_Contrat();
            //On récupère les heures du contrat de travail
            $heures = \Model_Contrat::getTempTravail(\Input::post('type_contrat'));
            $val = \Model_Contrat::validate('create_contrat');
            //on vérifie que l'on ne dépasse pas 100% de travail sur plusieurs contrat
            $true = true;
            $nombre_jours = $db_contrat->getJoursTravail(\Input::post('d_date_fin_contrat_prevu'), \Input::post('d_date_debut_contrat'));

            $nombre_jours[0]['jour']++;
            $a = array();
            for ($i = 0; $i < $nombre_jours[0]['jour']; $i++) {
                $b = $db_contrat->verifContrat($id_participant, \Input::post('d_date_debut_contrat'), $i);
                //144000 = à 40heures en secondes.

                if (($b[0]['somme'] + (int)$heures) > 144000) {
                    $a[] = $b[0]['jour'];
                    $true = false;

                }
            }


            if (!$true) {
                $message[] = '<ul><li>Vous dépassez les 40h semaines entre ces deux périodes '
                    . \MaitrePylos\date::db_to_date(current($a)) . ' et ' . \MaitrePylos\date::db_to_date(end($a)) . '</li></ul>';
            }

            //on vérifie que l'on garde le même groupe durant les mêmes périodes.
            if ($db_contrat->verifGroupeContrat($id_participant, Input::post('groupe'), Input::post('d_date_debut_contrat'), Input::post('d_date_fin_contrat_prevu')) === false) {
                $message[] = 'Vous ne pouvez pas mélanger les groupes';
                $true = false;
            }


            $val->set_message('max_length', 'Le champ :label doit faire maximum :param:1 chiffres');
            //$val->set_message('exceeds_onehundred', 'Le :label ne peut dépasser 100');
            //J'ajoute ici la vérification des dates, car il n'est pas possible de le faire dans \model_contat
            $val->add_field('d_date_fin_contrat_prevu', 'Date Fin de contrat', 'required|date_less[' . \Input::post('d_date_debut_contrat') . ']');
            $val->add_field('d_date_debut_contrat', 'Formation ', 'eighteen_months_more[' . \Input::post('d_date_fin_contrat_prevu') . ']');
            $val->add_field('f_frais_deplacement', 'Frais de déplacement', 'valid_string[numeric]');
            $val->set_message('date_less', 'La :label ne peut être inférieure à la date de début de contrat');
            $val->set_message('eighteen_months_more', 'La :label ne peut être supérieure à 18 mois');
            $val->set_message('f_frais_deplacement', 'Le :label doit-etre numérique');


            if ($val->run() && $true) {
                $avertissement_1 = (\Input::post('d_avertissement1') != "") ? \MaitrePylos\date::date_to_db(Input::post('d_avertissement1')) : NULL;
                $avertissement_2 = (\Input::post('d_avertissement2') != "") ? \MaitrePylos\date::date_to_db(Input::post('d_avertissement2')) : NULL;
                $avertissement_3 = (\Input::post('d_avertissement3') != "") ? \MaitrePylos\date::date_to_db(Input::post('d_avertissement3')) : NULL;
                $dateDemande = (\Input::post('d_date_demande_derogation_rw') != "") ? \MaitrePylos\date::date_to_db(Input::post('d_date_demande_derogation_rw')) : NULL;
                $dateDemandeForem = (\Input::post('d_date_demande_forem') != "") ? \MaitrePylos\date::date_to_db(Input::post('d_date_demande_forem')) : NULL;
                $dateDemandeOnem = (\Input::post('d_date_demande_onem') != "") ? \MaitrePylos\date::date_to_db(Input::post('d_date_demande_onem')) : NULL;
                $dateReponseOnem = (\Input::post('d_date_reponse_onem') != "") ? \MaitrePylos\date::date_to_db(Input::post('d_date_reponse_onem')) : NULL;
                $dateFinContrat = (\Input::post('d_date_fin_contrat') != "") ? \MaitrePylos\date::date_to_db(Input::post('d_date_fin_contrat')) : NULL;


                $contrat->i_temps_travail = $heures;
                $contrat->d_date_debut_contrat = \MaitrePylos\date::date_to_db(Input::post('d_date_debut_contrat'));
                $contrat->d_date_fin_contrat = $dateFinContrat;
                $contrat->d_date_fin_contrat_prevu = \MaitrePylos\date::date_to_db(Input::post('d_date_fin_contrat_prevu'));
                $contrat->t_remarque = Input::post('t_remarque');
                $contrat->f_frais_deplacement = Input::post('f_frais_deplacement');
                /**
                 * On vérifie que c'est pas une réactivaction d'un contrat.
                 * Dans ce cas il faut supprimer la fin de formation si elle existe en base
                 */


                $fin_formation = \DB::select()->from('formation')->where('contrat_id', $id)->execute();
                if ($fin_formation != null) {
                    if ($fin_formation[0]['d_date_fin_formation'] != $dateFinContrat) {

                        $result = \DB::delete('formation')->where('contrat_id', '=', $id)->execute();
                        $message[] = 'la fin de formation a bien été supprimée';
                    }
                }

                $contrat->t_duree_innoccupation = Input::post('t_duree_innoccupation');
                $contrat->b_derogation_rw = Input::post('b_derogation_rw');
                $contrat->t_abonnement = Input::post('t_abonnement');
                $contrat->f_tarif_horaire = Input::post('f_tarif_horaire');
                $contrat->t_situation_sociale = Input::post('t_situation_sociale');
                $contrat->type_contrat_id = Input::post('type_contrat');
                $contrat->groupe_id = Input::post('groupe');
                $contrat->d_avertissement1 = $avertissement_1;
                $contrat->d_avertissement2 = $avertissement_2;
                $contrat->d_avertissement3 = $avertissement_3;
                //$contrat->participant = $id;
                $contrat->b_necessaire = Input::post('b_necessaire');
                $contrat->d_date_demande_derogation_rw = $dateDemande;
                $contrat->b_reponse_forem = Input::post('b_reponse_forem');
                $contrat->d_date_demande_forem = $dateDemandeForem;
                $contrat->b_reponse_rw = Input::post('b_reponse_rw');
                $contrat->b_dispense_onem = Input::post('b_dispense_onem');
                $contrat->d_date_demande_onem = $dateDemandeOnem;
                $contrat->d_date_reponse_onem = $dateReponseOnem;
                $contrat->t_passe_professionnel = Input::post('t_passe_professionnel');
                $contrat->t_ressource = Input::post('t_ressource');
                $contrat->t_connaissance_eft = Input::post('t_connaissance_eft');


                if ($contrat->save()) {
                    $message[] = 'Le contrat a bien été mis à jour.';
                    \Session::set_flash('success', $message);
                    \Response::redirect('contrat/ajouter/' . $id_participant);
                } else {
                    $message[] = 'Impossible de mettre à jour le contrat.';
                    \Session::set_flash('error', $message);
                }
            }
            $message[] = $val->show_errors();
            \Session::set_flash('error', $message);
        }

        /**
         * On remet les date en affichage
         */
        $contrat->d_date_fin_contrat = \MaitrePylos\date::db_to_date($contrat->d_date_fin_contrat);
        $contrat->d_date_fin_contrat_prevu = \MaitrePylos\date::db_to_date($contrat->d_date_fin_contrat_prevu);
        $contrat->d_date_debut_contrat = \MaitrePylos\date::db_to_date($contrat->d_date_debut_contrat);

        $contrat->d_avertissement1 = \MaitrePylos\date::db_to_date($contrat->d_avertissement1);
        $contrat->d_avertissement2 = \MaitrePylos\date::db_to_date($contrat->d_avertissement2);
        $contrat->d_avertissement3 = \MaitrePylos\date::db_to_date($contrat->d_avertissement3);
        $contrat->d_date_demande_derogation_rw = \MaitrePylos\date::db_to_date($contrat->d_date_demande_derogation_rw);
        $contrat->d_date_demande_forem = \MaitrePylos\date::db_to_date($contrat->d_date_demande_forem);
        $contrat->d_date_demande_onem = \MaitrePylos\date::db_to_date($contrat->d_date_demande_onem);
        $contrat->d_date_reponse_onem = \MaitrePylos\date::db_to_date($contrat->d_date_reponse_onem);

        $this->data['contrat'] = $contrat;
        $this->data['statut'] = \Model_My_Contrat::get_statut_entree();
        $this->data['participant'] = $participant;
        $this->data['getcontrat'] = \Model_Type_Contrat::getNames();
        $this->data['getgroupe'] = \Model_Groupe::getNames();
        $this->data['fin_formation'] = \Model_Fin_Formation::fin_formation_contrat($id);
        $this->template->title = 'Modifier contrat';
        $this->template->content = \View::forge('contrat/modifier', $this->data);


    }


    /**
     * @param null $id
     * @param null $idParticipant
     * Interuption d'un contrat.
     * On rempli deux tables, la table contrat pour mettre une date à la fin de contrat
     * La table formation pour donne rles motif de la fin de formation.
     * Cette méthode remplace la méthode action_fin
     */
    public function action_fin_formation($id = null, $id_participant = null)
    {

        if (Input::method() == 'POST') {

            $contrat = \Model_Contrat::find($id);


            $date[0] = \DateTime::createFromFormat('Y-m-d', $contrat->d_date_debut_contrat);
            $date[1] = \DateTime::createFromFormat('d/m/Y', Input::post('d_date_fin_formation'));

            if ($date[0] > $date[1]) {

                $success[] = 'La Date de fin de contrat ne peut être inférieure à la date de début de contrat';
                \Session::set_flash('error', $success);
                \Response::redirect('contrat/ajouter/' . $id_participant);
            }

            $contrat->d_date_fin_contrat = $date[1]->format('Y-m-d');
            $contrat->d_date_fin_contrat_prevu = $date[1]->format('Y-m-d');
            $contrat->save();


            $formation = New \Model_Formation();


            $formation->d_date_fin_formation = $date[1]->format('Y-m-d');
            $formation->t_fin_formation = Input::post('t_fin_formation');
            $formation->t_fin_formation_suite = Input::post('t_fin_formation_suite');
            $formation->contrat_id = $id;
            $formation->save();

            $success[] = 'Fin du contrat !';
            \Session::set_flash('success', $success);
            \Response::redirect('contrat/ajouter/' . $id_participant);
        }


        $types_formation = \Model_Type_Formation::find('all', array('order_by' => array('t_nom' => 'ASC'), 'related' => array('fins_formation' => array('order_by' => array('i_position' => 'ASC')))));

        $select_formation = array();
        $select_suite_formation = array();
        foreach ($types_formation as $type_formation) {

            foreach ($type_formation->fins_formation as $item) {

                $select_formation[$type_formation->t_nom][$item->t_valeur] = $item->t_nom;
            }
        }


        $this->data['participant'] = \Model_Participant::find($id_participant);
        $this->data['select_formation'] = $select_formation;
        $this->data['select_suite_formation'] = $select_suite_formation;
        $this->template->title = 'Fin de formation/Contrat';
        $this->template->content = \View::forge('contrat/fin_formation', $this->data);


    }


    /**
     * @param null $id
     * @param null $idParticipant
     * Interuption d'un contrat.
     * On rempli deux tables, la table contrat pour mettre une date à la fin de contrat
     * La table formation pour donne rles motif de la fin de formation.
     * Cette méthode remplace la méthode action_fin
     */
    public function action_fin_formation_modifier($id = null, $id_participant = null)
    {
        $formation = \Model_Formation::find('first', array(
            'where' => array(
                array('contrat_id', $id),
            )));
        $contrat = \Model_Contrat::find($id);

        if (Input::method() == 'POST') {



            $date[0] = \DateTime::createFromFormat('Y-m-d', $contrat->d_date_debut_contrat);
            $date[1] = \DateTime::createFromFormat('d/m/Y', Input::post('d_date_fin_formation'));

            if ($date[0] > $date[1]) {

                $success[] = 'La Date de fin de contrat ne peut être inférieure à la date de début de contrat';
                \Session::set_flash('error', $success);
                \Response::redirect('contrat/ajouter/' . $id_participant);
            }

            $contrat->d_date_fin_contrat = $date[1]->format('Y-m-d');
            $contrat->d_date_fin_contrat_prevu = $date[1]->format('Y-m-d');
            $contrat->save();




            $formation->d_date_fin_formation = $date[1]->format('Y-m-d');
            $formation->t_fin_formation = Input::post('t_fin_formation');
            $formation->t_fin_formation_suite = Input::post('t_fin_formation_suite');
            $formation->contrat_id = $id;
            $formation->save();

            $success[] = 'Fin du contrat !';
            \Session::set_flash('success', $success);
            \Response::redirect('contrat/ajouter/' . $id_participant);
        }


        $types_formation = \Model_Type_Formation::find('all', array('order_by' => array('t_nom' => 'ASC'), 'related' => array('fins_formation' => array('order_by' => array('i_position' => 'ASC')))));

        $select_formation = array();
        $select_suite_formation = array();
        foreach ($types_formation as $type_formation) {

            foreach ($type_formation->fins_formation as $item) {

                $select_formation[$type_formation->t_nom][$item->t_valeur] = $item->t_nom;
            }
        }


        $this->data['contrat'] = $contrat;
        $this->data['formation'] = $formation;
        $this->data['participant'] = \Model_Participant::find($id_participant);
        $this->data['select_formation'] = $select_formation;
        $this->data['select_suite_formation'] = $select_suite_formation;
        $this->template->title = 'Fin de formation/Contrat';
        $this->template->content = \View::forge('contrat/fin_formation', $this->data);


    }

    public function action_impression($id_contrat, $id_participant)
    {
        if (\Model_Fin_Formation::get_count_adresse($id_participant) == 0) {
            $message[] = 'Le participant à besoin d\'une adresse par défaut.';
            \Session::set_flash('error', $message);
            \Response::redirect('participant/modifier/' . $id_participant);

        }

        $participant = \Model_Fin_Formation::get_participant_fin_formation($id_participant);
        $contrat = \Model_Fin_Formation::fin_formation_pdf($id_contrat);
        \Maitrepylos\Pdf\Finformation::pdf($participant, $contrat);
        $this->template->title = 'Gestion des documents';
        $this->template->content = \View::forge('test');
    }


}
