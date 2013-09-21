<?php
class Controller_Checklist_Section extends Controller_Template 
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
		$data['checklist_sections'] = \Model_Checklist_Section::find('all');
		$this->template->title = "Checklist_sections";
		$this->template->content = \View::forge('checklist/section/index', $data);

	}

	public function action_view($id = null)
	{
		$data['checklist_section'] = Model_Checklist_Section::find($id);

		$this->template->title = "Checklist_section";
		$this->template->content = View::forge('checklist/section/view', $data);

	}

	public function action_create($id = null)
	{
		if (Input::method() == 'POST')
		{
			$val = Model_Checklist_Section::validate('create');
			
			if ($val->run())
			{
				$checklist_section = Model_Checklist_Section::forge(array(
					't_nom' => Input::post('t_nom'),
				));

				if ($checklist_section and $checklist_section->save())
				{
					Session::set_flash('success', 'Added checklist_section #'.$checklist_section->id.'.');

					Response::redirect('checklist/section');
				}

				else
				{
					Session::set_flash('error', 'Could not save checklist_section.');
				}
			}
			else
			{
				Session::set_flash('error', $val->show_errors());
			}
		}

		$this->template->title = "Checklist_Sections";
		$this->template->content = View::forge('checklist/section/create');

	}

	public function action_edit($id = null)
	{
		$checklist_section = Model_Checklist_Section::find($id);
		$val = Model_Checklist_Section::validate('edit');

		if ($val->run())
		{
			$checklist_section->t_nom = Input::post('t_nom');

			if ($checklist_section->save())
			{
				Session::set_flash('success', 'Updated checklist_section #' . $id);

				Response::redirect('checklist/section');
			}

			else
			{
				Session::set_flash('error', 'Could not update checklist_section #' . $id);
			}
		}

		else
		{
			if (Input::method() == 'POST')
			{
				$checklist_section->t_nom = $val->validated('t_nom');

				Session::set_flash('error', $val->show_errors());
			}
			
			$this->template->set_global('checklist_section', $checklist_section, false);
		}

		$this->template->title = "Checklist_sections";
		$this->template->content = View::forge('checklist/section/edit');

	}

	public function action_delete($id = null)
	{
		if ($checklist_section = Model_Checklist_Section::find($id))
		{
			$checklist_section->delete();

			Session::set_flash('success', 'Deleted checklist_section #'.$id);
		}

		else
		{
			Session::set_flash('error', 'Could not delete checklist_section #'.$id);
		}

		Response::redirect('checklist/section');

	}


}