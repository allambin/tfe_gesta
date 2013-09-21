<?php

/**
 * Fuel
 *
 * Fuel is a fast, lightweight, community driven PHP5 framework.
 *
 * @package    Fuel
 * @version    1.5
 * @author     Fuel Development Team
 * @license    MIT License
 * @copyright  2010 - 2013 Fuel Development Team
 * @link       http://fuelphp.com
 */

/**
 * Provides Twig support for commonly used FuelPHP classes and methods.
 */
class Twig_Fuel_Extension extends \Parser\Twig_Fuel_Extension
{

    public function getFunctions()
    {
        $functions = parent::getFunctions();
        $new_functions = array(
            'print_r' => new Twig_Function_Function('print_r'),
            'uri_create' => new Twig_Function_Function('Uri::create'),
            'html_anchor' => new Twig_Function_Function('Html::anchor'),
            'screen_name' => new Twig_Function_Function('Auth::instance()->get_screen_name'),
            'form_open' => new Twig_Function_Function('Form::open'),
            'form_label' => new Twig_Function_Function('Form::label'),
            'form_input' => new Twig_Function_Function('Form::input'),
            'form_select' => new Twig_Function_Function('Form::select'),
            'form_checkbox' => new Twig_Function_Function('Form::checkbox'),
            'form_submit' => new Twig_Function_Function('Form::submit'),
            'input_post' => new Twig_Function_Function('Input::post'),
            'session_get_flash' => new Twig_Function_Function('Session::get_flash'),
        );
        
        return array_merge($functions, $new_functions);
    }

}
