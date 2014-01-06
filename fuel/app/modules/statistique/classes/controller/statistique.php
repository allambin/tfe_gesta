<?php

namespace Statistique;

use Fuel\Core\Response;
use Fuel\Core\Input;

/**
 *Gestion des liens de modification d'un participant.
 */
class Controller_Statistique extends \Controller_Main 
{
    public $title = 'Statistiques';
    public $data = array();
    private $dir = 'statistique/';

    /**
     * Redirige toute personne non membre du groupe "100"
     */
    public function before()
    {
        parent::before();

        if (!\Auth::member(100)) {
            \Session::set('direction', '/statistique');
            \Response::redirect('users/login');
        }

    }

    public function action_index()
    {
        $this->data['title'] = $this->title;
        return $this->theme->view($this->dir.'index', $this->data);
    }

    public function action_l3()
    {
        $formData = \Input::post();
        $db = new \Model_My_Statistique();

        //calcul du temps de script
//        $debut_calcul = microtime(true);

        $date = new \DateTime();
        $date->setDate((int)$formData['annee'], 01, 01);

        $groupe = $db->getGroupe($date);

        $count_groupe = count($groupe);

        $data = array();
        $filtre = \Maitrepylos\Helper::time();

        for($a = 0; $a < $count_groupe; $a++) {
            $date_boucle = clone $date;
            
            $total_eft = 0;
            $total_gratuit = 0;
            $total_payant = 0;
            $total_stage = 0;
            $total_assimile = 0;

            for($i = 0; $i < 12; $i++) {
                $jours = $date_boucle->format('t');
                $id_participant = $db->getIdParticipant($groupe[$a]['id_groupe'], $date_boucle);

                $count_id_participant = count($id_participant);
                $eft = 0;
                $gratuit = 0;
                $payant = 0;
                $stage = 0;
                $assimile = 0;
                
                for($b = 0; $b < $count_id_participant; $b++) {

                    $date_jour = clone $date_boucle;

                    for($d = 0; $d < $jours; $d++) {


                        $db_eft = $db->calculHeuresMoisStat($id_participant[$b]['participant'], "'+','-'", $date_jour);
                        $eft = $eft + $db_eft[0]['iSum'];

                        $db_gratuit = $db->calculHeuresMoisStat($id_participant[$b]['participant'], "'$'", $date_jour);
                        $gratuit = $gratuit + $db_gratuit[0]['iSum'];

                        $db_payant = $db->calculHeuresMoisStat($id_participant[$b]['participant'], "'@','#'", $date);
                        $payant = $payant + $db_payant[0]['iSum'];

                        $db_stage = $db->calculHeuresMoisStat($id_participant[$b]['participant'], "'='", $date);
                        $stage = $stage + $db_stage[0]['iSum'];

                        $db_assimile = $db->calculHeuresMoisStat($id_participant[$b]['participant'], "'/'", $date);
                        $assimile = $assimile + $db_assimile[0]['iSum'];

                        $date_jour->add(new \DateInterval('P1D'));
                    }

                }


                $data[$groupe[$a]['t_nom']][\Maitrepylos\Utils::mois($i + 1)]['eft'] = $filtre->TimeToString($eft);
                $data[$groupe[$a]['t_nom']][\Maitrepylos\Utils::mois($i + 1)]['gratuit'] = $filtre->TimeToString($gratuit);
                $data[$groupe[$a]['t_nom']][\Maitrepylos\Utils::mois($i + 1)]['payant'] = $filtre->TimeToString($payant);
                $data[$groupe[$a]['t_nom']][\Maitrepylos\Utils::mois($i + 1)]['stage'] = $filtre->TimeToString($stage);
                $data[$groupe[$a]['t_nom']][\Maitrepylos\Utils::mois($i + 1)]['assimile'] = $filtre->TimeToString($assimile);
                
                $total_eft = $total_eft + $eft;
                $total_gratuit = $total_gratuit + $gratuit;
                $total_payant = $total_payant + $payant;
                $total_stage = $total_stage + $stage;
                $total_assimile = $total_assimile + $assimile;

                /**
                 * On ajoute 1 mois à la date pour boucler
                 */
                $date_boucle->add(new \DateInterval('P1M'));


            }
            $data[$groupe[$a]['t_nom']]['totaleft'] = $filtre->TimeToString($total_eft);
            $data[$groupe[$a]['t_nom']]['totalgratuit'] = $filtre->TimeToString($total_gratuit);
            $data[$groupe[$a]['t_nom']]['totalpayant'] = $filtre->TimeToString($total_payant);
            $data[$groupe[$a]['t_nom']]['totalstage'] = $filtre->TimeToString($total_stage);
            $data[$groupe[$a]['t_nom']]['totalassimile'] = $filtre->TimeToString($total_assimile);
            $total_general = $total_eft + $total_gratuit + $total_payant + $total_stage;
            
            $data[$groupe[$a]['t_nom']]['totalgeneral'] = $filtre->TimeToString($total_general);

        }


    //    $fin_calcul = microtime(true);
    //    $total_temp = ($fin_calcul - $debut_calcul);
  
        
        $this->data['nom_groupe'] = $groupe;
        $this->data['compteur'] = $count_groupe;
        $this->data['data'] = $data;
        $this->data['annee'] = $date->format('Y');
       // $this->data['duree'] = $total_temp;

        $this->template->title = 'Gestion des fichier Excel';
        $this->template->content = \View::forge('statistique/l3', $this->data);


    }

    public function action_stat()
    {
        $formData = \Input::post();
        $db = new \Model_My_Statistique();


        $date = new \DateTime();
        $date->setDate((int)$formData['annee'], 01, 01);

        $groupe = $db->getGroupe($date);
        $data['groupe'] = $groupe;

        //$count_groupe = count($groupe);


        $participant = array();

        foreach($groupe as $groupes) {


            $participant[$groupes['t_nom']] = $db->getIdParticipantContrat($date, $groupes['id_groupe']);


            /**
             * Insertion des heures préstées depuis le début de la formation
             */


            $compteur = count($participant[$groupes['t_nom']]);
            $total = 0;
            $total_heure_eft_rw = 0;
            $heure_eft_rw = 0;
            $total_absenceJ = 0;
            $total_absenceNJ = 0;
            $total_conge = 0;
            $total_social = 0;

            for($a = 0; $a < $compteur; $a++) {

                $id = $participant[$groupes['t_nom']][$a]['participant'];

                $date_premier_contrat = new \DateTime($db->firstContrat($id));

                $total_heure = $db->totalFullHeuresParticipant($id, $date_premier_contrat, "'+', '@', '=', '-', '$','#'");
                $participant[$groupes['t_nom']][$a]['heures_full'] = $total_heure[0]['fullTime'];
                $total = $total + $total_heure[0]['fullTime'];

                $heure_eft_rw = $db->totalFullHeuresSubside($id, $date_premier_contrat, "'+', '@', '=', '-'");
                $participant[$groupes['t_nom']][$a]['heures_eft_rw'] = $heure_eft_rw[0]['fullTime'];
                $total_heure_eft_rw = $total_heure_eft_rw + $heure_eft_rw[0]['fullTime'];

                $absenceJ = $db->totalFullHeuresParticipant($id, $date_premier_contrat, "'%', '/'");
                $participant[$groupes['t_nom']][$a]['heures_absenceJ'] = $absenceJ[0]['fullTime'];
                $total_absenceJ = $total_absenceJ + $absenceJ[0]['fullTime'];

                $absenceNJ = $db->totalFullHeuresParticipant($id, $date_premier_contrat, "'*'");
                $participant[$groupes['t_nom']][$a]['heures_absenceNJ'] = $absenceNJ[0]['fullTime'];
                $total_absenceNJ = $total_absenceNJ + $absenceNJ[0]['fullTime'];

                $conge = $db->totalFullHeuresParticipant_motif($id, $date_premier_contrat, "'Conge'");
                $participant[$groupes['t_nom']][$a]['heures_conge'] = $conge[0]['fullTime'];
                $total_conge = $total_conge + $conge[0]['fullTime'];

                $social = $db->totalFullHeuresParticipant_motif($id, $date_premier_contrat, "'Debriefing_ateliers','Gestion_Collective','Suivi_individuel'");
                $participant[$groupes['t_nom']][$a]['heures_social'] = $social[0]['fullTime'];
                $total_social = $total_social + $social[0]['fullTime'];


                /**
                 * Calcul de pourcentage par rapport aux heures préstée
                 */
                $fullTotalHeure = $total_heure[0]['fullTime'] + $absenceJ[0]['fullTime'] + $absenceNJ[0]['fullTime'];
                if ($total_heure[0]['fullTime'] == null) {
                    $participant[$groupes['t_nom']][$a]['pourcent_present'] = 0;
                } else {
                    $participant[$groupes['t_nom']][$a]['pourcent_present'] = (100 / $fullTotalHeure) * $total_heure[0]['fullTime'];
                }

                if ($absenceJ[0]['fullTime'] == null) {
                    $participant[$groupes['t_nom']][$a]['pourcent_absentj'] = 0;
                } else {
                    $participant[$groupes['t_nom']][$a]['pourcent_absentj'] = (100 / $fullTotalHeure) * $absenceJ[0]['fullTime'];
                }

                if ($absenceNJ[0]['fullTime'] == null) {
                    $participant[$groupes['t_nom']][$a]['pourcent_absentnj'] = 0;
                } else {
                    $participant[$groupes['t_nom']][$a]['pourcent_absentnj'] = (100 / $fullTotalHeure) * $absenceNJ[0]['fullTime'];
                }


                $date_diff = \DateTime::createFromFormat('d-m-Y', $participant[$groupes['t_nom']][$a]['d_date_debut_contrat']);
                $differenceMois = $db->nombresMoisEntreDeuxDate($date_diff);
                $participant[$groupes['t_nom']][$a]['heures_mois'] = $differenceMois[0]['mois'];


            }
            $participant['total_heure'][$groupes['t_nom']] = $total;
            $participant['total_heureEftRw'][$groupes['t_nom']] = $total_heure_eft_rw;
            $participant['total_absenceJ'][$groupes['t_nom']] = $total_absenceJ;
            $participant['total_absenceNJ'][$groupes['t_nom']] = $total_absenceNJ;
            $participant['total_conge'][$groupes['t_nom']] = $total_conge;
            $participant['total_social'][$groupes['t_nom']] = $total_social;


            //  }


        }


        \Maitrepylos\Excel\Statexcel::excel($data, $participant);


        $this->template->title = 'Gestion des documents';
        $this->template->content = \View::forge('test');

    }

    public function action_trimestre()
    {
        $formData = Input::post();

        $date = new \DateTime();
        $date->setDate((int) $formData['annee'], 01, 01);

        $db = new \Model_My_Statistique();

        /**
         * Récupération des contrat par filière et par dérogation
         */
        $formData['annexe1'][1] = $db->getCountContratFiliere($date);
        $formData['annexe1'][2] = $db->getCountContratFiliereDerogation($date);
        $formData['xml'] = \Model_Centre::find('first');

        $count = count($formData['annexe1'][1]);

        for ($i = 0; $i < $count; $i++)
        {
            $derogation = NULL;
            $result = NULL;

            foreach ($formData['annexe1'][2] as $compteur)
            {
                if ($formData['annexe1'][1][$i]['t_nom'] == $compteur['t_nom'])
                {
                    $derogation = $compteur['compteur'];
                    $result = ((int) $formData['annexe1'][1][$i]['compteur']) - ((int) $compteur['compteur']);
                }
            }

            $formData['annexe1'][1][$i]['derogation'] = $derogation;
            $formData['annexe1'][1][$i]['resultat'] = (int) $result;
        }

        $formData['agrement'] = \Model_agrement::find($formData['agrement']);


        /*
         * Récupération des filière en fonctions des agréments
         */
        $filieres = \Model_Filiere::find('all', array('where' => array(array('agrement_id', $formData['agrement']->id_agrement))));

        /*
         * Récupération de tout les contrats concerné par la filière durant l'année choisie
         */
        $contratsTrimestre = $db->getContratTrimestreBis($date);
        $idsParticipant = array();
        $idsContrats = array();
        foreach ($contratsTrimestre as $idFiliere => $values)
            foreach ($values as $value)
            {
                $idsParticipant[] = $value['participant_id'];
                $idsContrats[] = $value['id_contrat'];
            }
        
        $idsParticipant = array_unique($idsParticipant);
        $idsContrats = array_unique($idsContrats);
        
        $heuresPrecedentes = $db->getHeuresPrecedentesBis($idsParticipant, $date, "'+','$','@','#','/','='");        
        $participants = $db->participantBis($idsParticipant);        
        $finsFormation = $db->getFinFormationBis();
        $heuresTotalContrat = $db->getHeuresTotalContratBis($date,$idsContrats);
        $heuresTotalFiliere = $db->getHeuresTotalFiliereBis($date);
        
        foreach ($filieres as $filiere)
        {
            /**
             * Récupération des contrats par filière
             */
            $formData['filiere'][$filiere['t_nom']] = $contratsTrimestre[$filiere['id_filiere']];
            $countContrat = count($formData['filiere'][$filiere['t_nom']]);

            for ($i = 0; $i < $countContrat; $i++)
            {
                /**
                 * Recherche motif fin de contrat
                 */
                $formData['filiere'][$filiere['t_nom']][$i]['type_fin_contrat'] = isset($finsFormation[$formData['filiere'][$filiere['t_nom']][$i]['id_contrat']]) ? $finsFormation[$formData['filiere'][$filiere['t_nom']][$i]['id_contrat']] : null;

                /**
                 * Calcul des heures éffectuées l'année précédente
                 */
                $formData['filiere'][$filiere['t_nom']][$i]['precedente'] = isset($heuresPrecedentes[$formData['filiere'][$filiere['t_nom']][$i]['participant_id']]) ? $heuresPrecedentes[$formData['filiere'][$filiere['t_nom']][$i]['participant_id']] : 0;
                /**
                 * Récupération des informations du stagiaire
                 */
                $formData['filiere'][$filiere['t_nom']][$i]['signaletique'] = $participants[$formData['filiere'][$filiere['t_nom']][$i]['participant_id']][$formData['filiere'][$filiere['t_nom']][$i]['id_contrat']];

                /**
                 * Calcule des heures de prestations pour l'année définie
                 */
                $formData['filiere'][$filiere['t_nom']][$i]['eft'] = isset($heuresTotalContrat['+'][$formData['filiere'][$filiere['t_nom']][$i]['id_contrat']]) ? $heuresTotalContrat['+'][$formData['filiere'][$filiere['t_nom']][$i]['id_contrat']] : 0;
                $formData['filiere'][$filiere['t_nom']][$i]['gratuit'] = (isset($heuresTotalContrat['$'][$formData['filiere'][$filiere['t_nom']][$i]['id_contrat']]) ? $heuresTotalContrat['$'][$formData['filiere'][$filiere['t_nom']][$i]['id_contrat']] : 0) + (isset($heuresTotalContrat['#'][$formData['filiere'][$filiere['t_nom']][$i]['id_contrat']]) ? $heuresTotalContrat['#'][$formData['filiere'][$filiere['t_nom']][$i]['id_contrat']] : 0);
                $formData['filiere'][$filiere['t_nom']][$i]['payant'] = isset($heuresTotalContrat['@'][$formData['filiere'][$filiere['t_nom']][$i]['id_contrat']]) ? $heuresTotalContrat['@'][$formData['filiere'][$filiere['t_nom']][$i]['id_contrat']] : 0;
                $formData['filiere'][$filiere['t_nom']][$i]['stage'] = isset($heuresTotalContrat['='][$formData['filiere'][$filiere['t_nom']][$i]['id_contrat']]) ? $heuresTotalContrat['='][$formData['filiere'][$filiere['t_nom']][$i]['id_contrat']] : 0;
                $formData['filiere'][$filiere['t_nom']][$i]['assimile'] = isset($heuresTotalContrat['/'][$formData['filiere'][$filiere['t_nom']][$i]['id_contrat']]) ? $heuresTotalContrat['/'][$formData['filiere'][$filiere['t_nom']][$i]['id_contrat']] : 0;                
            }

            for ($ii = 1; $ii < 13; $ii++)
            {
                $formData['filiere'][$filiere['t_nom']]['mois'][$ii]['eft'] = isset($heuresTotalFiliere['+'][$ii][$filiere['id_filiere']]) ? $heuresTotalFiliere['+'][$ii][$filiere['id_filiere']] : 0;
                $formData['filiere'][$filiere['t_nom']]['mois'][$ii]['gratuit'] = (isset($heuresTotalFiliere['$'][$ii][$filiere['id_filiere']]) ? $heuresTotalFiliere['$'][$ii][$filiere['id_filiere']] : 0) + (isset($heuresTotalFiliere['#'][$ii][$filiere['id_filiere']]) ? $heuresTotalFiliere['#'][$ii][$filiere['id_filiere']] : 0);
                $formData['filiere'][$filiere['t_nom']]['mois'][$ii]['payant'] = isset($heuresTotalFiliere['@'][$ii][$filiere['id_filiere']]) ? $heuresTotalFiliere['@'][$ii][$filiere['id_filiere']] : 0;
                $formData['filiere'][$filiere['t_nom']]['mois'][$ii]['stage'] = isset($heuresTotalFiliere['='][$ii][$filiere['id_filiere']]) ? $heuresTotalFiliere['='][$ii][$filiere['id_filiere']] : 0;
                $formData['filiere'][$filiere['t_nom']]['mois'][$ii]['assimile'] = isset($heuresTotalFiliere['/'][$ii][$filiere['id_filiere']]) ? $heuresTotalFiliere['/'][$ii][$filiere['id_filiere']] : 0;
            }
        }

        $formData['annexe1'][1] = \SplFixedArray::fromArray($formData['annexe1'][1]);
        $formData['annexe1'][1]->setSize(24);

        \Maitrepylos\Excel\L3excel::excel($formData);
    }

    public function action_menu($id)
    {
        $annees = \Model_Heures_Prestation::find('all', array('order_by' => array('annee'=>'desc')));
        $select_annees = array();
        foreach($annees as $annee) {
            $select_annees[$annee->annee] = $annee->annee;
        }
        
        $route = array(1 => 'statistique/stat/', 2 => 'statistique/l3/', 3 => 'statistique/trimestre/');
        $title = array(1 => 'Statistiques de présence', 2 => 'Stat l3', 3 => 'Recensement annuel des stagiaires (xls)');

        $agrement = \Model_agrement::find('all');
        $agrements = array();
        foreach ($agrement as $value) {

            $agrements[$value->id_agrement] = $value->t_agrement;
        }
        
        $this->data['title'] = $this->title . ' - '.$title[$id];
        $this->data['route'] = $route[$id];
        $this->data['annee'] = $select_annees;
        $this->data['titre'] = $title[$id];
        $this->data['agrements'] = $agrements;
        $this->data['id'] = $id;
        return $this->theme->view($this->dir.'menu', $this->data);

    }
}

?>
