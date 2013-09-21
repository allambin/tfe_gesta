<?php

namespace Fuel\Migrations;

class Create_type_contacts
{
	public function up()
	{
		\DBUtil::create_table('type_contacts', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'idTypeContact' => array('constraint' => 11, 'type' => 'int'),
			't_typeContact' => array('constraint' => 45, 'type' => 'varchar'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('type_contacts');
	}
}