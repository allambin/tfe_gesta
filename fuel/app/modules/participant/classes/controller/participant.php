<?php

namespace Participant;
use Fuel\Core\Input;

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
        
        $where = array();
        if (isset($_GET['sSearch']) && $_GET['sSearch'] != "")
        {
            $where = array('where' => array());
            for ($i = 0; $i < count($columns); $i++)
            {
                if($columns[$i] != ' ')
                    $entry->or_where($columns[$i], 'LIKE', '%' . $_GET['sSearch'] . '%');
            }
        }
        
        $tempTotal = $entry->count();
        
        $limit = array();
        if (isset($_GET['iDisplayStart']) && $_GET['iDisplayLength'] != '-1')
        {
            $entry->limit(intval($_GET['iDisplayLength']));
            $entry->offset(intval($_GET['iDisplayStart']));
        }

        $order = array();
        if (isset($_GET['iSortCol_0']))
        {
            $order = array('order_by' => array());
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
//    public function action_ajouter($id = NULL)
//    {
//
//        $this->template->title = 'Gestion des participants - Nouvelle inscription';
//        
//        if (\Input::method() == 'POST')
//	{
//            // Validation des champs
//            $val = \Model_Participant::validate('create_participant');
//            
//            // Transformation de la date de naissance
//            $dob = (\Input::post('d_date_naissance') != NULL) ? date('Y/m/d', strtotime(\Input::post('d_date_naissance'))) : NULL;
//            // Transformation du nom
//            $nom = strtoupper(\Cranberry\MySanitarization::filterAlpha(\Cranberry\MySanitarization::stripAccents(\Input::post('t_nom'))));
//            // Transformation du prenom
//            $prenom = \Cranberry\MySanitarization::ucFirstAndToLower(\Cranberry\MySanitarization::filterAlpha(\Input::post('t_prenom')));
//            
//            // On vérifie si ce membre existe déjà, en se basant sur les nom, prénom et date de naissance (participants actifs)
//            $exists = \Model_Participant::exists($nom, $prenom, $dob, 1);
//			
//            // si la validation ne renvoie aucune erreur et si le participant n'existe pas
//            if ($val->run() and !$exists)
//            {
//                // On vérifie si ce participant n'avait pas été "supprimé"
//                $reactivate = \Model_Participant::exists($nom, $prenom, $dob, 0);
//            
//                // Auquel cas, on propose de le réactiver
//                if($reactivate)
//                {
//                    // On recupère les infos liées à ce participant dans la db
//                    $participant = \Model_Participant::find()->where(array(
//                        't_nom' => $nom,
//                        't_prenom' => $prenom,
//                        'd_date_naissance' => $dob
//                         ))->get_one();
//                              
//                    // Et on redirige le tout
//                    \Response::redirect($this->view_dir . 'reactiver/'.$participant->id_participant);
//                }
//                else // Sinon, on l'ajoute en db
//                {
//                    // On forge un objet participant
//                    $participant = \Model_Participant::forge(array(
//                        't_nom' => $nom,
//                        't_prenom' => $prenom,
//                        't_nationalite' => \Input::post('t_nationalite'),
//                        't_lieu_naissance' => \Cranberry\MySanitarization::ucFirstAndToLower(\Input::post('t_lieu_naissance')),
//                        'd_date_naissance' => $dob,
//                        't_sexe' => \Input::post('t_sexe'),
//                        't_gsm' => \Input::post('t_gsm'),
//                        't_gsm2' => \Input::post('t_gsm2'),
//                        'b_is_actif' => 1
//                    ));
//
//                    // On save si c'est bon
//                    if ($participant and $participant->save())
//                    {
//                        $message[] = "Le participant a bien été ajouté.";
//                        \Session::set_flash('success', $message);
//                        \Response::redirect($this->view_dir . 'modifier/'.$participant->id_participant);
//                    }
//                    else // sinon on affiche les erreurs
//                    {
//                        $message[] = 'Impossible de sauver le participant.';
//                        \Session::set_flash('error', $message);
//                    }
//                }
//            }
//            else // si la validation a échoué
//            {
//                $message[] = $val->show_errors();
//                if($exists) $message[] = 'Ce participant existe déjà';
//                \Session::set_flash('error', $message);
//            }
//        }
//        
//        $this->template->content = \View::forge($this->view_dir . '/ajouter', $this->data);
//    }
    
    /**
     * Permet de réactiver un participant précédemment "supprimé"
     *
     * @param type $id
     * @param type $confirmation 
     */
    public function action_reactiver($id)
    {
        // On récupère le participant
        $participant = \Model_Participant::find($id);
        
        if(!is_object($participant))
        {
            \Session::set_flash('error', 'Impossible de trouver le participant.');
            \Response::redirect($this->dir . 'index');
        }
        
        $participant->b_is_actif = 1;
        
        if($participant->save())
        {
            \Session::set_flash('success', 'Le participant a bien été réactivé.');
            \Response::redirect($this->dir . 'index');
        }
        else
        {
            \Session::set_flash('error', 'Impossible de réactiver le participant.');
            \Response::redirect($this->dir . 'index');
        }
    }
   
    /**
     * Modifie un participant selon l'id passé en paramètre.
     * 
     * @param type $id 
     */
    public function action_modifier($id = null) // todo
    {
        die("toto");
        $this->template->title = "Gestion des participants - Modifier une inscription";

        // On récupère le participant dont l'id est passé en paramètres.
        $participant = \Model_Participant::find($id, array(
                    'related' => array(
                        'adresses',
                        'contacts' => array(
                            'related' => 'adresse'
                        ),
                        'checklist'
                    )
                ));
        
        if(!is_object($participant) || $id === null )
        {
            $message[] = 'Impossible de trouver le participant.';
            \Session::set_flash('error', $message);
            \Response::redirect('/');
        }
        
        // on vérifie si le participant possède déjà une adresse par défaut
        // sinon, on ajoute la checkbox, si oui on ne la met pas
        $alreadyDefault = \Model_Adresse::find()->where(array('t_courrier' => 1, 'participant_id' => $id))->get();

        // Validation
        $val = \Model_Participant::validate('edit');

        if ($val->run()) 
        {
            $children = \Input::post('t_children');
            if(\Input::post('t_enfants_charge') == 'Non' || \Input::post('t_enfants_charge') == '')
                $children = "";
            if(!empty($children))
                $children = implode (";", $children);
            // Transformation de la date de naissance
            $dob = (\Input::post('d_date_naissance') != NULL) ? date('Y/m/d', strtotime(\Input::post('d_date_naissance'))) : NULL;
            // Transformation de la date de fin d'études
            $dfe = (\Input::post('d_fin_etude') != NULL) ? date('Y/m/d', strtotime(\Input::post('d_fin_etude'))) : NULL;
            // Transformation de la date du permis théorique
            $dpt = (\Input::post('d_date_permis_theorique') != NULL) ? date('Y/m/d', strtotime(\Input::post('d_date_permis_theorique'))) : NULL;
            // Transformation du permis
            $permis = \Input::post('t_permis');
            if (!empty($permis))
                $permis = implode(',', \Input::post('t_permis'));
            // Transformation du registre national
            $registre = \Input::post('t_registre_national');
            if (!empty($registre) || $registre != null)
                $registre = \Cranberry\MySanitarization::filterRegistreNational($registre);
            // Transformation du compte bancaire
            $compte = \Input::post('t_compte_bancaire');
            if (!empty($compte) || $compte != null)
                $compte = \Cranberry\MySanitarization::filterCompteBancaire($compte);

            $checklist = $participant->checklist;
            if(!is_object($checklist))
                $checklist = new \Model_Checklist();
            $checklist->t_liste = is_array(\Input::post('liste')) ? implode(",", \Input::post('liste')) : null;
            $participant->checklist = $checklist;
            
            // Modification des attributs de l'objet participant
            $participant->t_nom = strtoupper(\Cranberry\MySanitarization::filterAlpha(\Cranberry\MySanitarization::stripAccents(\Input::post('t_nom'))));
            $participant->t_prenom = \Cranberry\MySanitarization::ucFirstAndToLower(\Cranberry\MySanitarization::filterAlpha(\Input::post('t_prenom')));
            $participant->t_nationalite = \Input::post('t_nationalite');
            $participant->t_lieu_naissance = \Cranberry\MySanitarization::ucFirstAndToLower(\Input::post('t_lieu_naissance'));
            $participant->d_date_naissance = $dob;
            $participant->t_sexe = \Input::post('t_sexe');
            $participant->t_type_etude = \Input::post('t_type_etude');
            $participant->t_diplome = \Input::post('t_diplome');
            $participant->d_fin_etude = $dfe;
            $participant->t_annee_etude = \Input::post('t_annee_etude');
            $participant->t_etat_civil = \Input::post('t_etat_civil');
            $participant->t_registre_national = $registre;
            $participant->t_compte_bancaire = $compte;
            $participant->t_pointure = \Input::post('t_pointure');
            $participant->t_taille = \Input::post('t_taille');
            $participant->t_enfants_charge = \Input::post('t_enfants_charge');
            $participant->t_mutuelle = \Input::post('t_mutuelle');
            $participant->t_organisme_paiement = \Input::post('t_organisme_paiement');
            $participant->t_organisme_paiement_phone = \Input::post('t_organisme_paiement_phone');
            $participant->t_permis = $permis;
            $participant->t_moyen_transport = \Input::post('t_moyen_transport');
            $participant->t_gsm = \Input::post('t_gsm');
            $participant->t_gsm2 = \Input::post('t_gsm2');
            $participant->b_attestation_reussite = \Input::post('b_attestation_reussite');
            $participant->d_date_permis_theorique = $dpt;
            $participant->t_email = \Input::post('t_email');
            $participant->t_children = $children;
            
            if ($participant->save()) 
            {                
                $message[] = 'Le participant a bien été mis à jour.';
                \Session::set_flash('success', $message);
                \Response::redirect($this->view_dir . 'modifier/' . $id .'#'.\Input::post('tab'));
            } 
            else 
            {
                $message[] = 'Impossible de mettre à jour le participant.';
                \Session::set_flash('error', $message);
            }
        } 
        else 
        {
            if (\Input::method() == 'POST') 
            {
                $message[] = $val->show_errors();
                \Session::set_flash('error', $message);
            }
        }

        // Transformation du string en array
        $participant->t_permis = explode(",", $participant->t_permis);
        
        // On passe tout ça dans la vue
        $checklist_sections = \Model_Checklist_Section::find('all', array('related' => 'valeurs'));
        $checklist = array();
        if(isset($participant->checklist) && isset($participant->checklist->t_liste))
            $checklist = explode(",", $participant->checklist->t_liste);
        
        
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
        
        $this->template->set_global('checklist', $checklist, false);
        $this->template->set_global('checklist_sections', $checklist_sections, false);
        $this->template->set_global('alreadyDefault', $alreadyDefault, false);
        $this->template->set_global('participant', $participant, false);
        $this->template->set_global('types', $types, false);
        $this->template->set_global('diplomes', $diplomes, false);
        $this->template->content = \View::forge($this->view_dir . 'modifier', $this->data, false);
    }
    
    public function action_supprimer($id = null)
    {
        $participant = \Model_Participant::find($id);
        
        if(!is_object($participant) || $id === null)
        {
            \Session::set_flash('error', 'Impossible de trouver le participant.');
        }
        
        $participant->b_is_actif = 0;
        
        if ($participant->save())
	{
            \Session::set_flash('success', 'Le participant a bien été supprimé.');
	}
        else
	{
            \Session::set_flash('error', 'Impossible de supprimer le participant.');
	}
        
        \Response::redirect($this->dir . 'index');
    }
    
    /**
     * Ajouter une adresse à un participant dont l'id est passé en paramètre.
     *
     * @param type $id 
     */
    public function action_ajouter_adresse($id = NULL)
    {
        $participant = \Model_Participant::find($id);
        
        if (\Input::method() == 'POST')
	{
            // Validation
            $val = \Model_Adresse::validate('create');
            
            if ($val->run())
            {
                // On forge un objet adresse
                $adresse = \Model_Adresse::forge(array(
                    't_nom_rue' => \Input::post('t_nom_rue'),
                    't_bte' => \Input::post('t_bte'),
                    't_code_postal' => \Input::post('t_code_postal'),
                    't_commune' => \Cranberry\MySanitarization::ucFirstAndToLower(\Cranberry\MySanitarization::filterAlpha(\Input::post('t_commune'))),
                    't_telephone' => \Input::post('t_telephone'),
                    't_courrier' => (\Input::post('t_courrier') != NULL) ? \Input::post('t_courrier'): 0,
                    't_type' => \Input::post('t_type'),
		));
                
                // On lie l'adresse au participant
                $participant->adresses[] = $adresse;

                // On sauvegarde
		if ($participant->save())
		{
                    $message[] = 'L\'adresse a bien été créée.';
                    \Session::set_flash('success', $message);
                    \Response::redirect($this->view_dir . 'modifier/'.$id.'#adresse');
		}
                else
		{
                    $message[] = 'Impossible de créer l\'adresse';
                    \Session::set_flash('error', $message);
		}
            }
            else
            {
                $message[] = $val->show_errors();
                \Session::set_flash('error', $message);
                \Response::redirect($this->view_dir . 'modifier/'.$id.'#adresse');
            }
	}
    }
    
    /**
     * Modification d'une adresse selon son id passé en paramètre.
     *
     * @param type $id 
     */
    public function action_modifier_adresse($id = NULL)
    {
        // On va chercher l'adresse via son id.
        $adresse = \Model_Adresse::find($id);
        $this->template->set_global('adresse', $adresse);
        
        if(!is_object($adresse))
        {
            $message[] = 'Impossible de trouver l\'adresse.';
            \Session::set_flash('error', $message);
            \Response::redirect($this->view_dir);
        }
        
        // Validation
	$val = \Model_Adresse::validate('edit');
        
        if ($val->run())
	{
            // On modifie l'objet adresse
            $adresse->t_nom_rue = \Input::post('t_nom_rue');
            $adresse->t_bte = \Input::post('t_bte');
            $adresse->t_code_postal = \Input::post('t_code_postal');
            $adresse->t_commune = \Cranberry\MySanitarization::ucFirstAndToLower(\Cranberry\MySanitarization::filterAlpha(\Input::post('t_commune')));
            $adresse->t_telephone = \Input::post('t_telephone');
            $adresse->t_type = \Input::post('t_type');
            $adresse->t_courrier = (\Input::post('t_courrier') != NULL) ? \Input::post('t_courrier'): 0;
	
            // On sauvegarde
            if ($adresse->save())
            {
                // Si l'adresse est cochée comme étant l'adresse par défaut,
                // on modifie les autres adresses liées au participant.
                if($adresse->t_courrier == 1)
                    \Model_Adresse::updateDefaultAddress($adresse->participant_id, $adresse->id_adresse);
                
                $message[] = "L'adresse a bien été modifiée.";
                \Session::set_flash('success', $message);
                \Response::redirect($this->view_dir . 'modifier/'.$adresse->participant_id.'#adresse');
            }
            else
            {
                $message = "Impossible de mettre à jour l'adresse.";
                \Session::set_flash('error', $message);
            }
	}
        else
	{
            if (\Input::method() == 'POST')
            {
                $message[] = $val->show_errors();
		\Session::set_flash('error', $message);
            }
	}

	$this->template->title = "Gestion des participants - Modifier l'adresse";
	$this->template->content = \View::forge($this->view_dir . 'edit_address', $this->data);
    }

    /**
     * Ajouter un contact à un participant.
     * 
     * @param type $id 
     */
    public function action_ajouter_contact($id = NULL)
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
                $cb = \Input::post('t_cb_type');
                if (!empty($cb))
                    $cb = implode(',', \Input::post('t_cb_type'));
                
                // On forge un objet contact
                $contact = \Model_Contact::forge(array(
                    't_civilite' => \Input::post('t_civilite'),
                    't_type' => \Input::post('t_type'),
                    't_cb_type' => $cb,
                    't_civilite' => \Input::post('t_civilite'),
                    't_nom' => strtoupper(\Cranberry\MySanitarization::filterAlpha(\Cranberry\MySanitarization::stripAccents(\Input::post('t_nom')))),
                    't_prenom' => \Cranberry\MySanitarization::ucFirstAndToLower(\Cranberry\MySanitarization::filterAlpha(\Input::post('t_prenom'))),
		));
                
                // On forge un objet adresse
                $adresse = \Model_Adresse::forge(array(
                    't_nom_rue' => \Input::post('t_nom_rue'),
                    't_bte' => \Input::post('t_bte'),
                    't_code_postal' => \Input::post('t_code_postal'),
                    't_commune' => \Cranberry\MySanitarization::ucFirstAndToLower(\Cranberry\MySanitarization::filterAlpha(\Input::post('t_commune'))),
                    't_telephone' => \Input::post('t_telephone'),
                    't_courrier' => 0
		));
                
                $contact->stage = NULL;
                
                // On lie l'adresse au participant
                $contact->adresse = $adresse;
                $participant->contacts[] = $contact;
                
                // On sauvegarde
		if ($participant->save())
		{                    
                    $message[] = 'Le contact a bien été créé.';
                    \Session::set_flash('success', $message);
                    \Response::redirect($this->view_dir . 'modifier/'.$id.'#personne_contact');
		}
                else
		{
                    $message[] = 'Impossible de sauver le contact.';
                    \Session::set_flash('error', $message);
                    \Response::redirect($this->view_dir . 'modifier/'.$id.'#personne_contact');
		}
            }
            else
            {
                $message[] = $val->show_errors();
                $message[] = $val_adresse->show_errors();
                
                \Session::set_flash('error', $message);
                \Response::redirect($this->view_dir . 'modifier/'.$id.'#personne_contact');
            }
	}
    }

    /**
     * Modifier un contact selon son id passé en paramètre.
     *
     * @param type $id 
     */
    public function action_modifier_contact($id = NULL)
    {
        // On récupère le contact grâce à son id
        $contact = \Model_Contact::find($id, array('related' => 'adresse'));
                
        if(!is_object($contact))
        {
            $message[] = 'Impossible de trouver le contact.';
            \Session::set_flash('error', $message);
            \Response::redirect('participant');
        }        
                
        if (\Input::method() == 'POST')
	{
            // Validation du contact
            $val = \Model_Contact::validate('create');
            
            // Validation de l'adresse
            $val_adresse = \Model_Adresse::validate('create_adresse');

            if ($val->run() & $val_adresse->run())
            {
                $cb = \Input::post('t_cb_type');
                if (!empty($cb))
                    $cb = implode(',', \Input::post('t_cb_type'));
                // On modifie le contact
		$contact->t_civilite = \Input::post('t_civilite');
		$contact->t_type = \Input::post('t_type');
		$contact->t_cb_type = $cb;
		$contact->t_civilite = \Input::post('t_civilite');
		$contact->t_nom = strtoupper(\Cranberry\MySanitarization::filterAlpha(\Cranberry\MySanitarization::stripAccents(\Input::post('t_nom'))));
		$contact->t_prenom = \Cranberry\MySanitarization::ucFirstAndToLower(\Cranberry\MySanitarization::filterAlpha(\Input::post('t_prenom')));
		
                // On modifie l'adresse
                $contact->adresse->t_nom_rue = \Input::post('t_nom_rue');
		$contact->adresse->t_bte = \Input::post('t_bte');
		$contact->adresse->t_code_postal = \Input::post('t_code_postal');
		$contact->adresse->t_commune = \Cranberry\MySanitarization::ucFirstAndToLower(\Cranberry\MySanitarization::filterAlpha(\Input::post('t_commune')));
		$contact->adresse->t_telephone = \Input::post('t_telephone');

                // On met à jour
                if ($contact->save())
                {
                    $message[] = 'Le contact a bien été modifié.';
                    \Session::set_flash('success', $message);
                    \Response::redirect($this->view_dir . 'modifier/'.$contact->participant_id.'#personne_contact');
                }
                else
                {
                    $message[] = 'Impossible de modifier le contact.';
                    \Session::set_flash('error', $message);
                    \Response::redirect($this->view_dir . 'modifier/'.$contact->participant_id.'#personne_contact');
                }
            }
            else
            {
                $message[] = $val->show_errors();
                $message[] = $val_adresse->show_errors();
                
                \Session::set_flash('error', $message);
            }
        }
        
        // Transformation du string en array
        $contact->t_cb_type = explode(",", $contact->t_cb_type);
        
        // On passe tout ça dans la view
        $this->template->set_global('contact', $contact, false);
        
        $this->template->title = "Gestion des participants - Modifier le contact";
	$this->template->content = \View::forge($this->view_dir . 'edit_contact', $this->data);
    }
    
    /**
     * Suppression d'une adresse selon son id.
     * 
     * @param type $id 
     */
    public function action_supprimer_adresse($id = NULL)
    {
        // On récupère l'adresse via son id.
        $adresse = \Model_Adresse::find($id);
        
        if(!is_object($adresse))
        {
            $message[] = 'Impossible de trouver l\'adresse.';
            \Session::set_flash('error', $message);
            \Response::redirect('gesta/choisir/modifier');
        }
        
        // On récupère l'id du participant lié à l'adresse.
        $id_participant = $adresse->participant_id;
        
        if ($adresse)
	{
            // On supprime l'adresse
            $adresse->delete();
            
            $message[] = 'L\'adresse a bien été supprimée.';
            \Session::set_flash('success', $message);
	}
        else
	{
            $message[] = 'Impossible de trouver l\'adresse sélectionnée.';
            \Session::set_flash('error', $message);
	}

	\Response::redirect($this->view_dir . 'modifier/'.$id_participant.'#adresse');
    }

    /**
     * Suppression d'un contact selon son id.
     * 
     * @param type $id 
     */
    public function action_supprimer_contact($id = NULL)
    {
        // On récupère le contact
        $contact = \Model_Contact::find($id, array('related' => 'adresse'));
        
        $id_participant = $contact->participant_id;
        
        if(!is_object($contact))
        {
            $message[] = 'Impossible de trouver le contact.';
            \Session::set_flash('error', $message);
            \Response::redirect($this->view_dir . 'modifier/'.$id_participant.'#personne_contact');
        }
        
        if ($contact->adresse->delete() && $contact->delete())
	{
            $message[] = 'Le contact a bien été supprimé.';
            
            \Session::set_flash('success', $message);
	}
        else
	{
            $message[] = 'Impossible de trouver le contact sélectionné.';
            \Session::set_flash('error', $message);
	}
        
	\Response::redirect($this->view_dir . 'modifier/'.$id_participant.'#personne_contact');
    }
}
