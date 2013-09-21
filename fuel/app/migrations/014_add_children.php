<?php

namespace Fuel\Migrations;

class Add_children
{
	public function up()
	{
            \Fuel\Core\DBUtil::add_fields('participant', array(
                't_children' => array('type' => 'text', 'null' => true),
            ));
	}

	public function down()
	{
            \Fuel\Core\DBUtil::drop_fields('participant', array('t_children'));
	}
}