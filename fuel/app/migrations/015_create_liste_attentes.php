<?php

namespace Fuel\Migrations;

class Create_liste_attentes
{
	public function up()
	{
		\DBUtil::create_table('liste_attente', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			't_nom' => array('constraint' => 50, 'type' => 'varchar'),
			't_prenom' => array('constraint' => 50, 'type' => 'varchar'),
			'd_date_naissance' => array('type' => 'date'),
			'd_dateEntretien' => array('type' => 'date'),
			't_contact' => array('constraint' => 255, 'type' => 'varchar', 'null' => true),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('liste_attente');
	}
}