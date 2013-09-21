<?php

namespace Fuel\Migrations;

class Create_adresses
{
	public function up()
	{
		\DBUtil::create_table('adresses', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'id_adresse' => array('constraint' => 11, 'type' => 'int'),
			't_nom_rue' => array('constraint' => 255, 'type' => 'varchar'),
			't_bte' => array('constraint' => 10, 'type' => 'varchar'),
			't_code_postal' => array('constraint' => 10, 'type' => 'varchar'),
			't_commune' => array('constraint' => 10, 'type' => 'varchar'),
			't_telephone' => array('constraint' => 20, 'type' => 'varchar'),
			't_email' => array('constraint' => 255, 'type' => 'varchar'),
			't_courrier' => array('constraint' => 1, 'type' => 'tinyint'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('adresses');
	}
}