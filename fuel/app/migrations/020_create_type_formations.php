<?php

namespace Fuel\Migrations;

class Create_type_formations
{
	public function up()
	{
		\DBUtil::create_table('type_formation', array(
			'id_type_formation' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			't_nom' => array('constraint' => 255, 'type' => 'varchar'),

		), array('id_type_formation'));
	}

	public function down()
	{
		\DBUtil::drop_table('type_formation');
	}
}