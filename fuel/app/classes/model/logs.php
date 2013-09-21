<?php

use Orm\Model;

class Model_Logs extends \Orm\Model {

    protected static $_table_name = 'logs';
    protected static $_properties = array(
        'user_id',
        'action',
        'model',
        'tms',

    );
}

?>
