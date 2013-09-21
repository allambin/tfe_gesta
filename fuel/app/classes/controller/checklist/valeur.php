<?php
class Controller_Checklist_Valeur extends Controller_Template 
{
    /**
     * Redirige toute personne non membre du groupe "100"
     */
    public function before()
    {
        parent::before();

        if (!\Auth::member(100)) {
            \Session::set('direction', '/administration');
            \Response::redirect('users/login');
        }

    }

	public function action_index()
	{
		$data['checklist_valeurs'] = Model_Checklist_Valeur::find('all');
		$this->template->title = "Checklist_valeurs";
		$this->template->content = View::forge('checklist/valeur/index', $data);

	}

	public function action_view($id = null)
	{
		$data['checklist_valeur'] = Model_Checklist_Valeur::find($id);

		$this->template->title = "Checklist_valeur";
		$this->template->content = \View::forge('listeattente/valeur', $data);

	}

	public function action_create($id = null)
	{
		if (Input::method() == 'POST')
		{
			$val = Model_Checklist_Valeur::validate('create');
			
			if ($val->run())
			{
				$checklist_valeur = Model_Checklist_Valeur::forge(array(
					't_nom' => Input::post('t_nom'),
					'tcode' => Input::post('tcode'),
					'section' => Input::post('section'),
				));

				if ($checklist_valeur and $checklist_valeur->save())
				{
					Session::set_flash('success', 'Added checklist_valeur #'.$checklist_valeur->id.'.');

					Response::redirect('checklist/valeur');
				}

				else
				{
					Session::set_flash('error', 'Could not save checklist_valeur.');
				}
			}
			else
			{
				Session::set_flash('error', $val->show_errors());
			}
		}

		$this->template->title = "Checklist_Valeurs";
		$this->template->content = View::forge('checklist/valeur/create');

	}

	public function action_edit($id = null)
	{
		$checklist_valeur = Model_Checklist_Valeur::find($id);
		$val = Model_Checklist_Valeur::validate('edit');

		if ($val->run())
		{
			$checklist_valeur->t_nom = Input::post('t_nom');
			$checklist_valeur->tcode = Input::post('tcode');
			$checklist_valeur->section = Input::post('section');

			if ($checklist_valeur->save())
			{
				Session::set_flash('success', 'Updated checklist_valeur #' . $id);

				Response::redirect('checklist/valeur');
			}

			else
			{
				Session::set_flash('error', 'Could not update checklist_valeur #' . $id);
			}
		}

		else
		{
			if (Input::method() == 'POST')
			{
				$checklist_valeur->t_nom = $val->validated('t_nom');
				$checklist_valeur->tcode = $val->validated('tcode');
				$checklist_valeur->section = $val->validated('section');

				Session::set_flash('error', $val->show_errors());
			}
			
			$this->template->set_global('checklist_valeur', $checklist_valeur, false);
		}

		$this->template->title = "Checklist_valeurs";
		$this->template->content = View::forge('checklist/valeur/edit');

	}

	public function action_delete($id = null)
	{
		if ($checklist_valeur = Model_Checklist_Valeur::find($id))
		{
			$checklist_valeur->delete();

			Session::set_flash('success', 'Deleted checklist_valeur #'.$id);
		}

		else
		{
			Session::set_flash('error', 'Could not delete checklist_valeur #'.$id);
		}

		Response::redirect('checklist/valeur');

	}


}