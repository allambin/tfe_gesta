<?php

namespace Fuel\Migrations;

class Add_type_and_cb_contact
{
	public function up()
	{
            \Fuel\Core\DBUtil::add_fields('contact', array(
                't_type' => array('type' => 'varchar', 'null' => true, 'constraint' => 255),
                'tCBType' => array('type' => 'varchar', 'null' => true, 'constraint' => 255),
            ));
	}

	public function down()
	{
            \Fuel\Core\DBUtil::drop_fields('contact', array('t_type', 'tCBType'));
	}
}