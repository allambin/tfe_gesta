<?php

namespace Fuel\Migrations;

class Add_address_type
{
	public function up()
	{
            \Fuel\Core\DBUtil::add_fields('adresse', array(
                't_type' => array('type' => 'varchar', 'null' => true, 'constraint' => 255)
            ));
	}

	public function down()
	{
            \Fuel\Core\DBUtil::drop_fields('adresse', array('t_type'));
	}
}