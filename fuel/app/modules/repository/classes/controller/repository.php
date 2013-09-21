<?php

namespace Repository;

class Controller_Repository extends \Controller_Main
{
    public $title = "Gestion du repository";
    public $data = array();
    private $view_dir = 'repository/';
    private $partial_dir = 'repository/partials/';
    
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
        
        $this->data['view_dir'] = $this->view_dir;
        $this->data['partial_dir'] = $this->partial_dir;
    }
    
    /**
     * Display the status of the git repository
     */
    public function action_status()
    {
        $this->template->title = $this->title;
        
        \Config::load('repository');
        $path = \Config::get('path');
        
        $portal = array();
        $portal['incoming_changes'] = shell_exec("cd $path && git fetch && git log ..origin/master");
        $portal['modified_files'] = shell_exec("cd $path && git status -s");
        
        $this->data['portal'] = $portal;
        
        $this->template->content = \View::forge($this->view_dir . 'status', $this->data);
    }
    
    /**
     * Update the repository if there's no local changes
     */
    public function action_update()
    {
        \Config::load('repository');
        $path = \Config::get('path');
        
        $local_changes = shell_exec("cd $path && git status -s");
        if(empty($local_changes))
            shell_exec("cd $path && git pull");
        
        \Response::redirect($this->view_dir . 'status');
    }

}
