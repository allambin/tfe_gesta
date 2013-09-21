<?php

use Orm\Model;

class Model_Subside extends Orm\Model
{
    protected static $_primary_key = array('id_subside');
    protected static $_table_name = 'subside';
    
    protected static $_properties = array(
        'id_subside',
        't_nom'
    );


    public static function validate($factory)
    {
        $val = Validation::forge($factory);
        $val->add_field('t_nom', 'Type', 'required');

        return $val;
    }
}