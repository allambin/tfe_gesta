<?php

namespace Listeattente;

class Controller_Listeattente extends \Controller_Main
{
    public $title = "Gestion de la liste d'attente";
    public $data = array();
    private $view_dir = 'listeattente/';
    private $partial_dir = 'listeattente/partials/';
    
    /**
     * Redirige toute personne non membre du groupe "100"
     */
    public function before()
    {
        parent::before();

        if (!\Auth::member(100)) {
            \Session::set('direction', '/listeattente');
            \Response::redirect('users/login');
        }
        
        $this->data['view_dir'] = $this->view_dir;
        $this->data['partial_dir'] = $this->partial_dir;
    }
    
    public function action_index()
    {
        $this->template->title = $this->title;
        
        $stagiaires = \Model_Listeattente::find('all', 
                array(
                    'where' => array(array('b_is_actif', 1)), 
                    'related' => array('adresse', 'groupe'),
                    'order_by' => array('d_date_entretien' => 'desc')
                ));

        $this->data['stagiaires'] = $stagiaires;
        $this->template->content = \View::forge($this->view_dir . 'index', $this->data);
    }

    public function action_ajouter()
    {
        $this->template->title = 'Nouveau stagiaire';

        $groupes = \Model_Groupe::getAsArray();

        if (\Input::method() == 'POST')
        {
            // Validation des champs
            $val = \Model_Listeattente::validate('create_stagiaire');

            // Validation
            $val_adresse = \Model_Adresse::validate('create');

            if ($val->run() & $val_adresse->run())
            {
                // Transformation du nom
                $nom = strtoupper(\Cranberry\MySanitarization::filterAlpha(\Cranberry\MySanitarization::stripAccents(\Input::post('t_nom'))));
                // Transformation du prenom
                $prenom = \Cranberry\MySanitarization::ucFirstAndToLower(\Cranberry\MySanitarization::filterAlpha(\Input::post('t_prenom')));

                // Transformation de la date de naissance
                $dob = (\Input::post('d_date_naissance') != NULL) ? date('Y/m/d', strtotime(\Input::post('d_date_naissance'))) : NULL;
                // Transformation de la date d'entretien
                $doe = (\Input::post('d_date_entretien') != NULL) ? date('Y/m/d', strtotime(\Input::post('d_date_entretien'))) : NULL;

                $existing_stagiaire = \Model_Listeattente::find('first', array(
                            'where' => array(
                                array(
                                    't_nom' => $nom,
                                    't_prenom' => $prenom,
                                    'd_date_naissance' => $dob,
                                    'groupe_id' => \Input::post('groupe_id'),
                                )
                            ),
                        ));

                if (is_object($existing_stagiaire))
                {
                    $existing_stagiaire->b_is_actif = 1;
                    $existing_stagiaire->save();
                    $message[] = "Le stagiaire a bien réactivé.";
                    \Session::set_flash('success', $message);

                    \Response::redirect($this->view_dir);
                }
                else
                {
                    $liste = new \Model_Listeattente();
                    $liste->t_nom = $nom;
                    $liste->t_prenom = $prenom;
                    $liste->d_date_naissance = $dob;
                    $liste->d_date_entretien = $doe;
                    $liste->t_contact = \Input::post('t_contact');
                    $liste->groupe_id = \Input::post('groupe_id');
                    $liste->b_is_actif = 1;

                    $adresse = \Model_Adresse::forge(array(
                                't_nom_rue' => \Input::post('t_nom_rue'),
                                't_bte' => \Input::post('t_bte'),
                                't_code_postal' => \Input::post('t_code_postal'),
                                't_commune' => \Input::post('t_commune'),
                                't_telephone' => \Input::post('t_telephone'),
                                't_courrier' => 0,
                            ));
                    
                    $liste->adresse = $adresse;
                    
                    if ($liste->save())
                    {
                        $message[] = "Le stagiaire a bien été ajouté.";
                        \Session::set_flash('success', $message);

                        \Response::redirect($this->view_dir);
                    }
                    else
                    {
                        $message[] = "Impossible de sauver le stagiaire.";
                        \Session::set_flash('error', $message);
                    }
                }
            }
            else
            {
                $message[] = $val->show_errors();
                $message[] = $val_adresse->show_errors();
                \Session::set_flash('error', $message);
            }
        }

        $this->template->set_global('groupes', $groupes, false);
        $this->template->content = \View::forge($this->view_dir . '/ajouter', $this->data);
    }

    public function action_supprimer($id)
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
            }
            else
            {
                $stagiaire->delete();
            }

            $message[] = "Le stagiaire a bien été supprimé.";
            \Session::set_flash('success', $message);
            \Response::redirect($this->view_dir);
        }
        else
        {
            $message[] = "Impossible de trouver le stagiaire sélectionné.";
            \Session::set_flash('error', $message);
            \Response::redirect($this->view_dir);
        }
    }

    public function action_confirmer($id)
    {
        $this->template->title = 'Confirmer le stagiaire';
        $stagiaire = \Model_Listeattente::find($id);

        $checklist = \Model_Checklist::find('first', array(
            'where' => array(
                'stagiaire' => $id
            )
        ));
        
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
                $participant->is_actif = 1;
                $participant->save();

                $stagiaire->b_is_actif = 0;
                $stagiaire->save();
                
                \Model_Checklist::saveParticipant($stagiaire->id, $participant->idparticipant);

                $message[] = "Le participant a bien été réactivé.";
                \Session::set_flash('success', $message);
                \Response::redirect($this->view_dir);
            }
            else
            {
                $new_participant = new \Model_Participant();
                $new_participant->t_nom = $stagiaire->t_nom;
                $new_participant->t_prenom = $stagiaire->t_prenom;
                $new_participant->d_date_naissance = $stagiaire->d_date_naissance;
                $new_participant->is_actif = 1;

                $adresse = \Model_Adresse::find($stagiaire->adresse);
                $new_adresse = new \Model_Adresse();
                $new_adresse->t_nom_centre = $adresse->t_nom_centre;
                $new_adresse->t_bte = $adresse->t_bte;
                $new_adresse->t_code_postal = $adresse->t_code_postal;
                $new_adresse->t_commune = $adresse->t_commune;
                $new_adresse->t_telephone = $adresse->t_telephone;
                $new_adresse->t_courrier = 0;

                if ($new_participant->save())
                {
                    \Model_Checklist::saveParticipant($id, $new_participant->idparticipant);
                    
                    $new_adresse->participant = $new_participant->idparticipant;
                    $new_adresse->save();

                    $stagiaire->b_is_actif = 0;
                    $stagiaire->save();

                    $message[] = "Le participant a bien été sauvé.";
                    \Session::set_flash('success', $message);
                    \Response::redirect('participant/modifier/' . $new_participant->idparticipant);
                }
                else
                {
                    $message[] = "Impossible de sauver le participant.";
                    \Session::set_flash('error', $message);
                }
            }
        }
        else
        {
            $message[] = "Impossible de trouver le stagiaire.";
            \Session::set_flash('error', $message);
            \Response::redirect($this->view_dir);
        }

        $this->template->content = '';
    }

    public function action_checklist($id)
    {
        $this->template->title = 'Checklist';

        $checklist_valeurs = \Model_Checklist_Valeur::find('all');
        $checklist_sections = \Model_Checklist_Section::getAsArray();
        $checklist = \Model_Checklist::find('first', array(
            'where' => array(
                'stagiaire_id' => $id
            )
        ));

        $liste = \Model_Checklist::getList($id);
        
        if(!empty($liste))
            $liste = explode(",", $liste);
        
        if (\Input::method() == 'POST')
        {
            $all = \Input::all();
            $input_liste = empty($all['list']) ? 0 : $all['list'];
            
            if(!$checklist)
                $checklist = new \Model_Checklist();
            
            $checklist->stagiaire = $id;
            $checklist->tliste = is_array($input_liste) ? implode(",", $input_liste) : null;
            
            if ($checklist->save())
            {
                $message[] = "La liste a bien été sauvée.";
                \Session::set_flash('success', $message);

                \Response::redirect($this->view_dir);
            }
            else
            {
                $message[] = "Impossible de sauver la liste.";
                \Session::set_flash('error', $message);
            }
        }

        $this->template->set_global('checklist_valeurs', $checklist_valeurs, false);
        $this->template->set_global('checklist_sections', $checklist_sections, false);
        $this->template->set_global('checklist', $liste, false);
        $this->template->content = \View::forge($this->view_dir . '/checklist');
    }

    public function action_section()
    {
        $this->data['checklist_sections'] = \Model_Checklist_Section::find('all');
        $this->template->title = "Gestion des sections de la liste d'attente";
        $this->template->content = \View::forge($this->view_dir . '/section', $this->data);
    }

    public function action_ajouter_section()
    {
        $this->template->title = "Sections de la liste d'attente";
        
        if (\Input::method() == 'POST')
        {
            $val = \Model_Checklist_Section::validate('create');            

            if ($val->run())
            {
                $checklist_section = \Model_Checklist_Section::forge(array(
                            't_nom' => \Input::post('t_nom'),
                        ));

                if ($checklist_section->save())
                {
                    $message[] = "La section a bien été sauvée.";
                    \Session::set_flash('success', $message);

                    \Response::redirect($this->view_dir . 'section');
                }
                else
                {
                    $message[] = "Impossible de sauver la section.";
                    \Session::set_flash('error', $message);
                }
            }
            else
            {
                $message[] = $val->show_errors();
                \Session::set_flash('error', $message);
            }
        }
        
        $this->template->set_global('action', 'Ajouter', false);
        $this->template->content = \View::forge($this->view_dir . 'ajouter_section', $this->data);
    }

    public function action_modifier_section($id = null)
    {
        $this->template->title = "Sections de la liste d'attente";
        
        $checklist_section = \Model_Checklist_Section::find($id);

        if (\Input::method() == 'POST')
        {
            $val = \Model_Checklist_Section::validate('edit');
            
            if ($val->run())
            {
                $checklist_section->t_nom = \Input::post('t_nom');

                if ($checklist_section->save())
                {
                    $message[] = 'Section mise à jour.';
                    \Session::set_flash('success', $message);

                    \Response::redirect($this->view_dir . 'section');
                }
                else
                {
                    $message[] = 'Impossible de mettre à jour la section';
                    \Session::set_flash('error', $message);
                }
            }
        }

        $this->template->set_global('action', 'Modifier', false);
        $this->template->content = \View::forge($this->view_dir . 'modifier_section', $this->data);
    }

    public function action_supprimer_section($id = null)
    {
        if ($checklist_section = \Model_Checklist_Section::find($id))
        {
            $valeurs_sections = \Model_Checklist_Valeur::getCount($id);
            if($valeurs_sections)
            {
                $message[] = "Impossible de supprimer la section, elle est sans doute liée à des valeurs.";
                \Session::set_flash('error', $message);
            }
            else
            {
                $checklist_section->delete();
                $message[] = 'Section supprimée.';
                \Session::set_flash('success', $message);
            }
            }
        else
        {
            $message[] = 'Impossible de supprimer la section.';
            \Session::set_flash('error', $message);
        }

        \Response::redirect($this->view_dir . 'section');
    }

    public function action_valeur()
    {
        $this->template->title = "Valeurs de la liste d'attente";
        $this->data['valeurs'] = \Model_Checklist_Valeur::find('all', array('order_by' => 'section_id', 'related' => array('section')));
        $this->template->set_global('action', 'Modifier', false);
        $this->template->content = \View::forge($this->view_dir . 'valeur', $this->data);
    }

    public function action_ajouter_valeur()
    {
        $this->template->title = "Valeurs de la liste d'attente";
        
        $sections = \Model_Checklist_Section::getAsSelect();

        if (\Input::method() == 'POST')
        {
            $val = \Model_Checklist_Valeur::validate('create');

            if ($val->run())
            {
                $checklist_valeur = \Model_Checklist_Valeur::forge(array(
                            't_nom' => \Input::post('t_nom'),
                            'section_id' => \Input::post('section_id'),
                        ));

                if ($checklist_valeur and $checklist_valeur->save())
                {
                    $message[] = "La valeur a bien été ajoutée.";
                    \Session::set_flash('success', $message);

                    \Response::redirect($this->view_dir . 'valeur');
                }
                else
                {
                    $message[] = "Impossible de sauver la valeur";
                    \Session::set_flash('error', $message);
                }
            }
            else
            {
                $message[] = $val->show_errors();
                \Session::set_flash('error', $message);
            }
        }

        $this->template->set_global('sections', $sections, false);
        $this->template->set_global('action', 'Ajouter', false);
        $this->template->content = \View::forge($this->view_dir . 'ajouter_valeur', $this->data);
    }

    public function action_modifier_valeur($id = null)
    {
        $sections = \Model_Checklist_Section::getAsSelect();
        $checklist_valeur = \Model_Checklist_Valeur::find($id);
        
        if (\Input::method() == 'POST')
        {
            $val = \Model_Checklist_Valeur::validate('edit');
            
            if ($val->run())
            {
                $checklist_valeur->t_nom = \Input::post('t_nom');
                $checklist_valeur->section_id = \Input::post('section_id');

                if ($checklist_valeur->save())
                {
                    $message[] = "Valeur mise à jour.";
                    \Session::set_flash('success', $message);

                    \Response::redirect($this->view_dir . 'valeur');
                }
                else
                {
                    $message[] = "Impossible de mettre la valeur à jour.";
                    \Session::set_flash('error', $message);
                }
            }
        }

        $this->template->set_global('checklist_valeur', $checklist_valeur, false);
        $this->template->set_global('sections', $sections, false);
        $this->template->title = "Valeurs de la liste d'attente";
        $this->template->set_global('action', 'Modifier', false);
        $this->template->content = \View::forge($this->view_dir . 'modifier_valeur', $this->data);
    }

    public function action_supprimer_valeur($id = null)
    {
        if ($checklist_valeur = \Model_Checklist_Valeur::find($id))
        {
            $checklist_valeur->delete();

            $message[] = "La valeur a bien été supprimée.";
            \Session::set_flash('success', $message);
        }
        else
        {
            $message[] = "Impossible de supprimer la valeur.";
            \Session::set_flash('error', $message);
        }

        \Response::redirect($this->view_dir . 'valeur');
    }

    public function action_print_checklist($id){

        //$participant = \Model_Participant::find($id);

        $checklist_valeurs = \Model_Checklist_Valeur::find('all');
        $checklist_sections = \Model_Checklist_Section::getAsArray();
        $checklist = \Model_Checklist::find('first', array(
            'where' => array(
                'stagiaire' => $id
            )
        ));

        $liste = \Model_Checklist::getList($id);

        if(!empty($liste))
            $liste = explode(",", $liste);

        //\Debug::dump($participant);

        \Maitrepylos\Pdf\Checklist::pdf($checklist_valeurs,$checklist_sections,$liste);
        $this->template->title = 'Gestion des documents';
        $this->template->content = \View::forge('test');


    }

}
