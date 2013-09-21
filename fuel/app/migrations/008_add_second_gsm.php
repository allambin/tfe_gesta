<?php

namespace Fuel\Migrations;

class Add_second_gsm
{
	public function up()
	{
            \Fuel\Core\DBUtil::add_fields('participant', array(
                't_gsm2' => array('constraint' => 20, 'type' => 'varchar', 'null' => true)
            ));
	}

	public function down()
	{
            \Fuel\Core\DBUtil::drop_fields('participant', array('t_gsm2'));
	}
}