<?php

namespace Fuel\Migrations;

class Create_type_statuts
{
	public function up()
	{
		\DBUtil::create_table('type_statut', array(
			'id_type_statut' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			't_nom' => array('constraint' => 255, 'type' => 'varchar'),

		), array('id_type_statut'));
	}

	public function down()
	{
		\DBUtil::drop_table('type_statut');
	}
}