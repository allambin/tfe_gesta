<?php

namespace Fuel\Migrations;

class Move_email
{
	public function up()
	{
            \Fuel\Core\DBUtil::add_fields('participant', array(
                't_email' => array('type' => 'varchar', 'null' => true, 'constraint' => 255)
            ));
            \Fuel\Core\DBUtil::drop_fields('adresse', array('t_email'));
	}

	public function down()
	{
            \Fuel\Core\DBUtil::drop_fields('participant', array('t_email'));
            \Fuel\Core\DBUtil::add_fields('adresse', array(
                't_email' => array('type' => 'varchar', 'null' => true, 'constraint' => 255)
            ));
	}
}