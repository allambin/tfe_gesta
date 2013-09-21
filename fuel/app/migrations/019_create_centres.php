<?php

namespace Fuel\Migrations;

class Create_centres
{
	public function up()
	{
		\DBUtil::create_table('centre', array(
			'id_centre' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			't_responsable' => array('constraint' => 255, 'type' => 'varchar'),
			't_statut' => array('constraint' => 50, 'type' => 'varchar', 'null' => true),
			't_denomination' => array('constraint' => 255, 'type' => 'varchar', 'null' => true),
			't_nom_centre' => array('constraint' => 255, 'type' => 'varchar'),
			't_objet_social' => array('constraint' => 255, 'type' => 'varchar', 'null' => true),
			't_agregation' => array('constraint' => 255, 'type' => 'varchar', 'null' => true),
			't_agence' => array('constraint' => 255, 'type' => 'varchar', 'null' => true),
			't_adresse' => array('constraint' => 255, 'type' => 'varchar', 'null' => true),
			't_code_postal' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			't_localite' => array('constraint' => 120, 'type' => 'varchar', 'null' => true),
			't_telephone' => array('constraint' => 20, 'type' => 'varchar', 'null' => true),
			't_email' => array('constraint' => 255, 'type' => 'varchar', 'null' => true),
			't_tva' => array('constraint' => 50, 'type' => 'varchar', 'null' => true),
			't_enregistrement' => array('constraint' => 50, 'type' => 'varchar', 'null' => true),
			't_agrement' => array('constraint' => 120, 'type' => 'varchar', 'null' => true),
			't_responsable_pedagogique' => array('constraint' => 255, 'type' => 'varchar', 'null' => true),
			't_secretaire' => array('constraint' => 255, 'type' => 'varchar', 'null' => true),
			'i_position' => array('constraint' => 11, 'type' => 'int'),

		), array('id_centre'));
	}

	public function down()
	{
		\DBUtil::drop_table('centre');
	}
}