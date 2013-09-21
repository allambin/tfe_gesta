<?php

namespace Fuel\Migrations;

class Create_contacts
{
	public function up()
	{
		\DBUtil::create_table('contacts', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'id_contact' => array('constraint' => 11, 'type' => 'int'),
			't_civilite' => array('constraint' => 15, 'type' => 'varchar'),
			't_nom' => array('constraint' => 50, 'type' => 'varchar'),
			't_prenom' => array('constraint' => 50, 'type' => 'varchar'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('contacts');
	}
}