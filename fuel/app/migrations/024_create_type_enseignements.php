<?php

namespace Fuel\Migrations;

class Create_type_enseignements
{
	public function up()
	{
		\DBUtil::create_table('type_enseignement', array(
			'id_type_enseignement' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			't_nom' => array('constraint' => 255, 'type' => 'varchar'),

		), array('id_type_enseignement'));
	}

	public function down()
	{
		\DBUtil::drop_table('type_enseignement');
	}
}