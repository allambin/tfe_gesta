<?php

namespace Fuel\Migrations;

class Create_statut_entrees
{
	public function up()
	{
		\DBUtil::create_table('statut_entree', array(
			'id_statut_entree' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			't_nom' => array('constraint' => 255, 'type' => 'varchar'),
			't_valeur' => array('constraint' => 10, 'type' => 'varchar'),
			'i_position' => array('constraint' => 11, 'type' => 'int'),
			'type_statut' => array('constraint' => 11, 'type' => 'int'),

		), array('id_statut_entree'));
                \DB::query('alter table statut_entree add constraint fk_type_statut foreign key (type_statut) references type_statut (id_type_statut)')->execute();
	}

	public function down()
	{                
                \DB::query('alter groupe statut_entree drop foreign key fk_type_statut')->execute();
		\DBUtil::drop_table('statut_entree');
	}
}