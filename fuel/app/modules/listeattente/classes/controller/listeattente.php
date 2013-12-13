<?php

namespace Listeattente;
use Fuel\Core\Input;
use Fuel\Core\Session;
use Fuel\Core\Response;

class Controller_Listeattente extends \Controller_Main
{
//    public $title = "Gestion de la liste d'attente";
//    public $data = array();
//    private $view_dir = 'listeattente/';
//    private $partial_dir = 'listeattente/partials/';
    public $title = 'Gestion de la liste d\'attente';
    public $data = array();
    private $dir = 'listeattente/';
    
    /**
     * Redirige toute personne non membre du groupe "100"
     */
    public function before()
    {
        parent::before();

//        if (!\Auth::member(100)) {
//            \Session::set('direction', '/listeattente');
//            \Response::redirect('users/login');
//        }
//        
//        $this->data['view_dir'] = $this->view_dir;
//        $this->data['partial_dir'] = $this->partial_dir;
    }
    
    public function action_ajax_liste()
    {        
        $columns = array('id_liste_attente', 't_nom', 't_prenom', 't_nom', 'd_date_naissance', 'd_date_entretien', 'b_is_actif', ' ');
        
        $entry = \Model_Listeattente::query()->select('id_liste_attente', 't_nom', 't_prenom', 'groupe_id', 'd_date_naissance', 'd_date_entretien', 'b_is_actif');
        $entry->related(array('groupe' => array('select' => array('t_nom'))));
//        $entry->where('b_is_actif', '=', '1');
        
        if (isset($_GET['sSearch']) && $_GET['sSearch'] != "")
        {
            $count = count($columns);
            for ($i = 0; $i < $count; $i++)
            {
                if($columns[$i] != ' ')
                    $entry->or_where($columns[$i], 'LIKE', '%' . $_GET['sSearch'] . '%');
            }
        }
        
        $tempTotal = $entry->count();
        
        if (isset($_GET['iDisplayStart']) && $_GET['iDisplayLength'] != '-1')
        {
            $entry->limit(intval($_GET['iDisplayLength']));
            $entry->offset(intval($_GET['iDisplayStart']));
        }
        
        if (isset($_GET['iSortCol_0']))
        {
            for ($i = 0; $i < intval($_GET['iSortingCols']); $i++)
            {
                if ($_GET['bSortable_' . intval($_GET['iSortCol_' . $i])] == "true")
                {
                    if($columns[intval($_GET['iSortCol_' . $i])]  != ' ')
                        $entry->order_by($columns[intval($_GET['iSortCol_' . $i])], $_GET['sSortDir_' . $i] === 'asc' ? 'asc' : 'desc');
                }
            }
        }

        /* Individual column filtering */
        for ($i = 0; $i < count($columns); $i++)
        {
            if (isset($_GET['bSearchable_' . $i]) && $_GET['bSearchable_' . $i] == "true" && $_GET['sSearch_' . $i] != '')
            {
                if($columns[$i] != ' ')
                    $entry->or_where($columns[$i], 'LIKE', '%' . $_GET['sSearch_' . $i] . '%');
            }
        }
        
        $stagiaires = $entry->get();
        
        $return = new \stdClass();
        $return->sEcho = intval($_GET['sEcho']);
        $return->iTotalRecords = $tempTotal;
        $return->iTotalDisplayRecords = $tempTotal;
        $return->aaData = array();
        
        $can_delete = \Auth::member(100) ? true : false;
        
        foreach ($stagiaires as $stagiaire)
        {
            $t = array(
                $stagiaire->id_liste_attente,
                $stagiaire->t_nom,
                $stagiaire->t_prenom,
                $stagiaire->groupe->t_nom,
                $stagiaire->d_date_naissance,
                $stagiaire->d_date_entretien,
                $stagiaire->b_is_actif,
                $can_delete,
                ''
            );
            array_push($return->aaData, $t);
        }
        
        return json_encode($return);
    }
    
    public function action_index()
    {
        $this->data['title'] = $this->title;
        return $this->theme->view($this->dir.'index', $this->data);
    }

    public function action_ajouter()
    {
        $this->data['title'] = $this->title . ' - Nouveau stagiaire';

        $object = new \Model_Listeattente();
        $fieldset = \Fieldset::forge('new')->add_model('Model_Listeattente')->repopulate();
        $form = $fieldset->form();
        
        // création du formulaire adresse
        $fs_adresse = \Fieldset::forge('new_address')->add_model('Model_Adresse')->repopulate();
        $form->add($fs_adresse);
        
        $form->add('submit', '', array('type' => 'submit', 'value' => 'Ajouter', 'class' => 'btn medium primary'));
        
        $groupes = \Model_Groupe::getAsArray();

        if (\Input::method() == 'POST')
        {
            if ($fieldset->validation()->run() == true)
            {
                $fields = $fieldset->validated();

                $object->set_massive_assigment($fields);
                
                $adresse = new \Model_Adresse();
                $adresse->set_massive_assigment($fields);
                
                $object->adresse = $adresse;
                
                // On vérifie qu'un/des participant(s) ayant le même tryptique n'existe(nt) pas déjà
                $stagiaires = \Model_Listeattente::query()
                                ->where('t_nom', $object->t_nom)
                                ->where('t_prenom', $object->t_prenom)
                                ->where('d_date_naissance', $object->d_date_naissance)
                                ->get();
                if(!empty($stagiaires) && \Input::post('checked') != '1')
                {
                    $this->data['title'] = $this->title . ' - Vérification';
                    $this->data['$object'] = $object;
                    $this->data['stagiaires'] = $stagiaires;
                    return $this->theme->view($this->dir.'check', $this->data);
                }

                if ($object->save())
                {
                    Session::set_flash('success', "Le stagiaire a bien été créé.");
                    Response::redirect($this->dir.'index');
                }
            }
            else
            {
                Session::set_flash('error', $fieldset->validation()->show_errors());
            }
        }

        $this->data['form'] = $form->build();
//        $this->data['form_adresse'] = $form_adresse->build();
        $this->data['groupes'] = $groupes;
        return $this->theme->view($this->dir.'create', $this->data);
    }

    public function action_desactiver($id)
    {
        if ($stagiaire = \Model_Listeattente::find($id))
        {
            $result = \Model_Participant::find('all', array(
                        'where' => array(
                            array(
                                'b_is_actif' => 1,
                                't_nom' => strtoupper($stagiaire->t_nom),
                                't_prenom' => $stagiaire->t_prenom,
                                'd_date_naissance' => $stagiaire->d_date_naissance,
                            )
                        ),
                    ));

            if (count($result) > 0)
            {
                $stagiaire->b_is_actif = 0;
                $stagiaire->save();
                $message[] = "Le stagiaire a bien été désactivé.";
            }
            else
            {
                $stagiaire->delete();
                $message[] = "Le stagiaire a bien été supprimé.";
            }

            \Session::set_flash('success', $message);
        }
        else
        {
            $message[] = "Impossible de trouver le stagiaire sélectionné.";
            \Session::set_flash('error', $message);
        }
        
        Response::redirect($this->dir . 'index');
    }

    public function action_confirmer($id)
    {
        $stagiaire = \Model_Listeattente::find($id);

//        $checklist = \Model_Checklist::find('first', array(
//            'where' => array(
//                'stagiaire' => $id
//            )
//        ));
        
        if (is_object($stagiaire))
        {

            // Si le stagiaire existe déjà, on le réactive, sinon on l'ajoute
            $participant = \Model_Participant::find('first', array(
                        'where' => array(
                            array(
                                't_nom' => $stagiaire->t_nom,
                                't_prenom' => $stagiaire->t_prenom,
                                'd_date_naissance' => $stagiaire->d_date_naissance,
                            )
                        ),
                    ));

            if (is_object($participant))
            {
                $participant->b_is_actif = 1;
                $participant->save();

                $stagiaire->b_is_actif = 0;
                $stagiaire->save();
                
//                \Model_Checklist::saveParticipant($stagiaire->id, $participant->idparticipant);

                \Session::set_flash('success', "Le participant a bien été réactivé.");
                Response::redirect('participant/modifier/' . $participant->id_participant);
            }
            else
            {
                $new_participant = new \Model_Participant();
                $new_participant->t_nom = $stagiaire->t_nom;
                $new_participant->t_prenom = $stagiaire->t_prenom;
                $new_participant->d_date_naissance = $stagiaire->d_date_naissance;
                $new_participant->is_actif = 1;

//                $adresse = \Model_Adresse::find($stagiaire->adresse);
//                $new_adresse = new \Model_Adresse();
//                $new_adresse->t_nom_centre = $adresse->t_nom_centre;
//                $new_adresse->t_bte = $adresse->t_bte;
//                $new_adresse->t_code_postal = $adresse->t_code_postal;
//                $new_adresse->t_commune = $adresse->t_commune;
//                $new_adresse->t_telephone = $adresse->t_telephone;
//                $new_adresse->t_courrier = 0;

                if ($new_participant->save())
                {
//                    \Model_Checklist::saveParticipant($id, $new_participant->idparticipant);
                    
//                    $new_adresse->participant = $new_participant->id_participant;
//                    $new_adresse->save();

                    $stagiaire->b_is_actif = 0;
                    $stagiaire->save();

                    \Session::set_flash('success', "Le participant a bien été sauvé.");
                    \Response::redirect('participant/modifier/' . $new_participant->id_participant);
                }
                else
                    \Session::set_flash('error', "Impossible de sauver le participant.");
            }
        }
        else
            \Session::set_flash('error', "Impossible de trouver le stagiaire.");
        
        Response::redirect($this->dir . 'index');
    }

    public function action_checklist($id)
    {
        $this->data['title'] = $this->title . ' - Checklist';

        $stagiaire = \Model_Listeattente::find($id, array('related' => array('checklist')));
        
        $checklist_model = \Model_Checklist_Section::find('all', array('related' => 'valeurs', 'order_by' => 't_nom'));
        $current_checklist = array();
        if(count($stagiaire->checklist) > 0)
        {
            foreach ($stagiaire->checklist as $value)
                $current_checklist[$value->id_checklist_valeur] = $value->id_checklist_valeur;
        }
                
        if (\Input::method() == 'POST')
        {
            $fields = \Input::all();
            foreach ($stagiaire->checklist as $key => $value)
            {
                unset($stagiaire->checklist[$key]);
                $stagiaire->save();
            }
            if(isset($fields['liste']))
            {
                $checklist = $fields['liste'];
                foreach ($checklist as $value)
                    $stagiaire->checklist[] = \Model_Checklist_Valeur::find($value);
            }
            
            if ($stagiaire->save())
            {
                \Session::set_flash('success', "La liste a bien été sauvée.");
                \Response::redirect($this->dir);
            }
            else
                \Session::set_flash('error', "Impossible de sauver la liste.");
        }

        $this->data['current_checklist'] = $current_checklist;
        $this->data['checklist_model'] = $checklist_model;
        return $this->theme->view($this->dir.'checklist', $this->data);
    }

    public function action_print_checklist($id)
    {
        $this->data['title'] = $this->title . ' - Checklist';
        \Maitrepylos\Pdf\Checklist::pdf($id);
//        $this->template->title = 'Gestion des documents';
//        $this->template->content = \View::forge('test');
        $response = new Response();
        $response->set_header('Content-Type', 'application/pdf');
        \Maitrepylos\Pdf\Checklist::pdf($id);

// This will be a NOT FOUND response
//$response->set_status(303);
return $response;
        return $this->theme->view($this->dir.'checklist', $this->data);
    }

}
