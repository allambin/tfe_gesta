<?php

namespace Participant;
use Fuel\Core\Input;
use Fuel\Core\Session;
use Fuel\Core\Response;

/**
 * Controller gérant toute la partie "Participant".
 */
class Controller_Participant extends \Controller_Main 
{    
    public $title = 'Gestion des participants';
    public $data = array();
    private $dir = 'participant/';
    
    /**
     * Override la function before().
     * Permet de vérifier si un membre est bien authentifié, sinon il est renvoyé
     * vers la page users/login et s'il a les bons droits, sinon il est renvoyé 
     * vers la page users/no_rights.
     */
    public function before()
    {
        parent::before();

//        if ($this->current_user == NULL)
//        {
//            \Session::set('direction', '/participant');
//            \Response::redirect('users/login');
//        }
//        else if (!\Auth::member(100))
//        {
//            \Response::redirect('users/no_rights');
//        }
//
//        $this->data['view_dir'] = $this->view_dir;
//        $this->data['partial_dir'] = $this->partial_dir;
    }
    
    public function action_index()
    {
        $this->data['title'] = $this->title;
        return $this->theme->view($this->dir.'index', $this->data);
    }
    
    public function action_ajax_liste()
    {        
        $columns = array('id_participant', 't_nom', 't_prenom', 'd_date_naissance', 't_lieu_naissance',
                            't_nationalite', 't_lieu_naissance', 't_registre_national',
                             't_numero_inscription_onem', 'b_is_actif', ' ');
        
        $entry = \Model_Participant::query()->select('id_participant', 't_nom', 't_prenom', 't_nationalite', 
                             't_lieu_naissance', 'd_date_naissance', 't_registre_national',
                             't_numero_inscription_onem', 'b_is_actif');
        
        if (isset($_GET['sSearch']) && $_GET['sSearch'] != "")
        {
            for ($i = 0; $i < count($columns); $i++)
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
        
        $participants = $entry->get();
        
        $return = new \stdClass();
        $return->sEcho = intval($_GET['sEcho']);
        $return->iTotalRecords = $tempTotal;
        $return->iTotalDisplayRecords = $tempTotal;
        $return->aaData = array();
        
        foreach ($participants as $participant)
        {
            $t = array(
                $participant->id_participant,
                $participant->t_nom,
                $participant->t_prenom,
                $participant->d_date_naissance,
                $participant->t_lieu_naissance,
                $participant->t_nationalite,
                $participant->t_registre_national,
                $participant->t_numero_inscription_onem,
                $participant->b_is_actif,
                ''
            );
            array_push($return->aaData, $t);
        }
        
        return json_encode($return);
    }
    
    /**
     * Ajoute un nouveau participant
     * 
     * @param type $id 
     * 
     * @todo fieldset, twig, etc
     */
    public function action_ajouter()
    {
        $participant = new \Model_Participant();
        
        if (\Input::method() == 'POST')
	{
            // Validation des champs
            $val = \Model_Participant::validate('create_participant');
			
            // si la validation ne renvoie aucune erreur et si le participant n'existe pas
            if ($val->run())
            {
                // On forge un objet participant
                $participant->set_massive_assigment(\Input::post());
                $participant->b_is_actif = 1;

                // On save si c'est bon
                if ($participant->save())
                {
                    Session::set_flash('success', "Le participant a bien été ajouté.");
                    Response::redirect($this->dir . 'modifier/'.$participant->id_participant);
                }
                else // sinon on affiche les erreurs
                {
                    Session::set_flash('error', "Impossible de sauver le participant.");
                }
            }
            else // si la validation a échoué
            {
                Session::set_flash('error', $val->show_errors());
            }
        }
        
        $this->data['title'] = $this->title . ' - Nouvelle inscription';
        $this->data['participant'] = $participant;
        $this->data['pays'] = \Cranberry\MyXML::getPaysAsSelect();
        return $this->theme->view($this->dir.'create', $this->data);
    }
    
    /**
     * Permet de réactiver un participant précédemment "supprimé"
     *
     * @param type $id
     * @param type $confirmation 
     */
//    public function action_reactiver($id)
//    {
//        // On récupère le participant
//        $participant = \Model_Participant::find($id);
//        
//        if(!is_object($participant))
//        {
//            \Session::set_flash('error', 'Impossible de trouver le participant.');
//            \Response::redirect($this->dir . 'index');
//        }
//        
//        $participant->b_is_actif = 1;
//        
//        if($participant->save())
//        {
//            \Session::set_flash('success', 'Le participant a bien été réactivé.');
//            \Response::redirect($this->dir . 'index');
//        }
//        else
//        {
//            \Session::set_flash('error', 'Impossible de réactiver le participant.');
//            \Response::redirect($this->dir . 'index');
//        }
//    }
   
    /**
     * Modifie un participant selon l'id passé en paramètre.
     * 
     * @param type $id 
     */
    public function action_modifier($id)
    {
        // On récupère le participant dont l'id est passé en paramètres.
        $participant = \Model_Participant::find($id, array(
                    'related' => array(
                        'adresses',
                        'contacts' => array(
                            'related' => 'adresse'
                        ),
                        'checklist' => array(
                            'related' => 'valeurs'
                        )
                    )
                ));
        
        if(!is_object($participant) || $id === null )
        {
            Session::set_flash('error', 'Impossible de trouver le participant.');
            Response::redirect('/');
        }
        
        // on vérifie si le participant possède déjà une adresse par défaut
        // sinon, on ajoute la checkbox, si oui on ne la met pas
        $already_default = \Model_Adresse::find()->where(array('t_courrier' => 1, 'participant_id' => $id))->get();

        // Validation
        $val = \Model_Participant::validate('edit');

        if ($val->run()) 
        {
            $participant->set_massive_assigment(\Input::post(), 'update');
            
            if ($participant->save()) 
            {
                \Session::set_flash('success', 'Le participant a bien été mis à jour.');
                \Response::redirect($this->dir . 'modifier/' . $id);
            } 
            else
                \Session::set_flash('error', 'Impossible de mettre à jour le participant.');
        } 
        else 
            if (\Input::method() == 'POST') 
                \Session::set_flash('error', $val->show_errors());

        // création du formulaire adresse
        $fs_adresse = \Fieldset::forge('new_address')->add_model('Model_Adresse')->repopulate();
        $form_adresse = $fs_adresse->form();
        $form_adresse->add('submit', '', array('type' => 'submit', 'value' => 'Ajouter', 'class' => 'btn medium primary'));
                
        // Transformation du string en array
        $participant->t_permis = explode(",", $participant->t_permis);
        
        // On récupère les valeurs et sections de la checklist
        $checklist_model = \Model_Checklist_Section::find('all', array('related' => 'valeurs', 'order_by' => 't_nom'));
        $current_checklist = array();
        if(is_array($participant->checklist))
        {
            foreach ($participant->checklist->valeurs as $value)
                $current_checklist[$value->id_checklist_valeur] = $value->id_checklist_valeur;
        }
        
        
        $types_enseignement = \Model_Type_Enseignement::find('all', array('order_by' => array('t_nom' => 'ASC'), 'related' => array('enseignements' => array('order_by' => array('i_position' => 'ASC')))));
        $types = array('' => '');
        $diplomes = array('' => '');
        
        foreach ($types_enseignement as $type_enseignement)
        {
            foreach ($type_enseignement->enseignements as $enseignement)
            {
                if(preg_match('#dipl.*me#i', $type_enseignement->t_nom))
                {
                    $diplomes[(string) $enseignement->t_valeur] = (string) $enseignement->t_nom;
                }
                else if(preg_match('#type#i', $type_enseignement->t_nom))
                {
                    $types[(string) $enseignement->t_valeur] = (string) $enseignement->t_nom;
                }
            }
        }
        
        // Transformation des children en array
        $children = explode(';', $participant->t_children);
        $participant->t_children = !empty($participant->t_children) ? array_chunk($children, 3) : 0;
        
        $this->data['title'] = $this->title;
        $this->data['current_checklist'] = $current_checklist;
        $this->data['checklist_model'] = $checklist_model;
        $this->data['already_default'] = $already_default;
        $this->data['participant'] = $participant;
        $this->data['types'] = $types;
        $this->data['diplomes'] = $diplomes;
        $this->data['annees'] = \Cranberry\MyXML::get_annee_etude();
        $this->data['pays'] = \Cranberry\MyXML::getPaysAsSelect();
        $this->data['form_adresse'] = $form_adresse->build(\Uri::create($this->dir.'/ajouter_adresse/'.$participant->id_participant));
        return $this->theme->view($this->dir.'update', $this->data);
    }
        
    /**
     * Supprimer un participant (le rendre inactif)
     * @param type $id
     */
    public function action_supprimer($id)
    {
        $participant = \Model_Participant::find($id);
        
        if(!is_object($participant))
            Session::set_flash('error', 'Impossible de trouver le participant.');
        
        $participant->b_is_actif = 0;
        
        if ($participant->save())
            Session::set_flash('success', 'Le participant a bien été supprimé.');
        else
            Session::set_flash('error', 'Impossible de supprimer le participant.');
        
        Response::redirect($this->dir . 'index');
    }
    
    /**
     * Ajouter une adresse à un participant dont l'id est passé en paramètre.
     *
     * @param type $id 
     */
    public function action_ajouter_adresse($id)
    {
        $participant = \Model_Participant::find($id);
        
        $fieldset = \Fieldset::forge('new')->add_model('Model_Adresse')->repopulate();
        
        if (\Input::method() == 'POST')
	{
            if ($fieldset->validation()->run() == true)
            {
                $fields = $fieldset->validated();

                $adresse = new \Model_Adresse();
                $adresse->set_massive_assigment($fields);
                $participant->adresses[] = $adresse;

                if ($participant->save())
                    Session::set_flash('success', "L'adresse a bien été créée.");
            }
            else
            {
                Session::set_flash('error', $fieldset->validation()->show_errors());
            }
	}
        
        Response::redirect($this->dir.'modifier/'.$id);
    }
    
    /**
     * Modification d'une adresse selon son id passé en paramètre.
     *
     * @param type $id 
     */
    public function action_modifier_adresse($id)
    {
        // On va chercher l'adresse via son id.
        $adresse = \Model_Adresse::find($id);
        
        if(!is_object($adresse))
        {
            Session::set_flash('error', "Impossible de trouver l'adresse.");
            Response::redirect($this->dir);
        }

        $fieldset = \Fieldset::forge('update')->add_model('Model_Adresse')->populate($adresse);
        $form = $fieldset->form();
        $form->add('submit', '', array('type' => 'submit', 'value' => 'Sauvegarder', 'class' => 'btn medium primary'));

        if (Input::method() == 'POST')
        {
            if ($fieldset->validation()->run() == true)
            {
                $fields = $fieldset->validated();

                $adresse->set_massive_assigment($fields);

                if ($adresse->save())
                {
                    Session::set_flash('success', "L'adresse a bien été mise à jour.");
                    Response::redirect($this->dir.'modifier/'.$adresse->participant_id);
                }
            }
            else
            {
                Session::set_flash('error', $fieldset->validation()->show_errors());
            }
        }
        
        $this->data['form'] = $form->build();
        $this->data['title'] = $this->title . " - Modifier l'adresse";
        $this->data['subtitle'] = " Modifier l'adresse";
        return $this->theme->view($this->dir.'adresse', $this->data);
    }

    /**
     * Ajouter un contact à un participant.
     * 
     * @param type $id 
     */
    public function action_ajouter_contact($id)
    {
        $participant = \Model_Participant::find($id);
                
        if (\Input::method() == 'POST')
	{
            // Validation du contact
            $val = \Model_Contact::validate('create');            
            
            // Validation de l'adresse liée au contact
            $val_adresse = \Model_Adresse::validate('create_adresse');
			
            if ($val->run() & $val_adresse->run())
            {
                $contact = new \Model_Contact();
                $contact->set_massive_assigment(\Input::post());
                $participant->contacts[] = $contact;

                if ($participant->save())
                    Session::set_flash('success', "L'adresse a bien été créée.");
            }
            else
            {
                Session::set_flash('error', $val->show_errors());
            }
	}
        
        Response::redirect($this->dir.'modifier/'.$id);
    }

    /**
     * Modifier un contact selon son id passé en paramètre.
     *
     * @param type $id 
     */
    public function action_modifier_contact($id = NULL)
    {
        // On va chercher l'adresse via son id.
        $contact = \Model_Contact::find($id, array(
                    'related' => array(
                        'adresse'
                    )
                ));
        
        if(!is_object($contact))
        {
            Session::set_flash('error', "Impossible de trouver le contact.");
            Response::redirect($this->dir);
        }

        if (Input::method() == 'POST')
        {
            // Validation du contact
            $val = \Model_Contact::validate('create');
            
            // Validation de l'adresse
            $val_adresse = \Model_Adresse::validate('create_adresse');

            if ($val->run() & $val_adresse->run())
            {
                $contact->set_massive_assigment(Input::post());

                if ($contact->save())
                {
                    Session::set_flash('success', "Le contact a bien été mis à jour.");
                    Response::redirect($this->dir.'modifier/'.$contact->participant_id);
                }
            }
            else
            {
                $separator = "";
                $contact_errors = $val->show_errors();
                $adresse_errors = $val_adresse->show_errors();
                if($contact_errors && $adresse_errors)
                    $separator = "<br />";
                Session::set_flash('error', $contact_errors.$separator.$adresse_errors);
            }
        }
        
        // Transformation du string en array
        $contact->t_cb_type = explode(",", $contact->t_cb_type);
        
        $this->data['title'] = $this->title . " - Modifier le contact";
        $this->data['subtitle'] = " Modifier le contact";
        $this->data['contact'] = $contact;
        return $this->theme->view($this->dir.'contact', $this->data);
    }
    
    /**
     * Suppression d'une adresse selon son id.
     * 
     * @param type $id 
     */
    public function action_supprimer_adresse($id)
    {
        // On récupère l'adresse via son id.
        $adresse = \Model_Adresse::find($id);
        
        if(!is_object($adresse))
        {
            Session::set_flash('error', "Impossible de trouver l'adresse.");
            Response::redirect($this->dir);
        }
        
        // On récupère l'id du participant lié à l'adresse.
        $id_participant = $adresse->participant_id;
        
        if ($adresse)
	{
            // On supprime l'adresse
            $adresse->delete();
            Session::set_flash('success', "L'adresse a bien été supprimée.");
	}
        else
	{
            Session::set_flash('error', "Impossible de trouver l'adresse sélectionnée.");
	}
        
	Response::redirect($this->dir.'modifier/'.$id_participant);
    }

    /**
     * Suppression d'un contact selon son id.
     * 
     * @param type $id 
     */
    public function action_supprimer_contact($id)
    {
        // On récupère le contact
        $contact = \Model_Contact::find($id, array('related' => 'adresse'));
        
        $id_participant = $contact->participant_id;
        
        if(!is_object($contact))
        {
            Session::set_flash('error', "Impossible de trouver le contact.");
            Response::redirect($this->dir);
        }
        
        if ($contact->delete())
            Session::set_flash('success', "Le contact a bien été supprimé.");
        else
            Session::set_flash('error', "Impossible de trouver le contact sélectionné.");
        
	Response::redirect($this->dir.'modifier/'.$id_participant);
    }
}
