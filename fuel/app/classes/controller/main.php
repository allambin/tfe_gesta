<?php

/**
 * Main controller dont héritent tous les autres. Permet d'y placer des functions
 * devant s'exécuter à toutes les pages.
 */
class Controller_Main extends \Fuel\Core\Controller
{
    protected $theme;
    protected $data = array();
    
    /**
     * Overrides la function before.
     * Permet ici de vérifier si le visiteur est authentifié. Si c'est le cas,
     * ses informations sont stockées dans $this->current_user.
     * Utilise le composant Auth de FuelPHP.
     */
    public function before()
    {
        $this->theme = Theme::instance();
        $this->theme->set_template('base');
        $this->theme->get_template()->set('title', 'My homepage');
        
        Config::load('theme', 'theme');
        $active_template = Config::get('theme.active');
        $default_template = Config::get('theme.default');
        $paths = Config::get('theme.paths');
        $assets_folder = Config::get('theme.assets_folder');
                
        foreach ($paths as $path)
        {
            Asset::add_path("$path/$active_template/$assets_folder");
            Asset::add_path("$path/$default_template/$assets_folder");
        }

        if(Uri::segment(1) != 'users')
            Session::set('direction', 'administration');
        $this->current_user = Auth::check() ? Model_User::find(Arr::get(Auth::get_user_id(), 1)) : NULL;
        
        $this->data['current_user'] = $this->current_user;
        
        // gestion des extras (github, eid)
        $extras = \Config::get('extras');
        $this->data['use_eid'] = $extras['eid'];
        $this->data['use_github'] = $extras['github'];
        
        parent::before();
    }

}

?>
