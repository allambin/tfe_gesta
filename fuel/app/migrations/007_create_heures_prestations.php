<?php

namespace Fuel\Migrations;

class Create_heures_prestations
{
	public function up()
	{
		\DBUtil::create_table('heures_prestations', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'annee' => array('constraint' => 5, 'type' => 'varchar'),
			'janvier' => array('constraint' => 100, 'type' => 'bigint'),
			'fevrier' => array('constraint' => 100, 'type' => 'bigint'),
			'mars' => array('constraint' => 100, 'type' => 'bigint'),
			'avril' => array('constraint' => 100, 'type' => 'bigint'),
			'mai' => array('constraint' => 100, 'type' => 'bigint'),
			'juin' => array('constraint' => 100, 'type' => 'bigint'),
			'juillet' => array('constraint' => 100, 'type' => 'bigint'),
			'aout' => array('constraint' => 100, 'type' => 'bigint'),
			'septembre' => array('constraint' => 100, 'type' => 'bigint'),
			'octobre' => array('constraint' => 100, 'type' => 'bigint'),
			'novembre' => array('constraint' => 100, 'type' => 'bigint'),
			'decembre' => array('constraint' => 100, 'type' => 'bigint'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('heures_prestations');
	}
}