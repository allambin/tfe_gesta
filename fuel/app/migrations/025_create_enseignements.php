<?php

namespace Fuel\Migrations;

class Create_enseignements
{
	public function up()
	{
		\DBUtil::create_table('enseignement', array(
			'id_enseignement' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			't_nom' => array('constraint' => 255, 'type' => 'varchar'),
			't_valeur' => array('constraint' => 10, 'type' => 'varchar'),
			'i_position' => array('constraint' => 11, 'type' => 'int'),
			'type_enseignement' => array('constraint' => 11, 'type' => 'int'),

		), array('id_enseignement'));
                \DB::query('alter table enseignement add constraint fk_type_enseignement foreign key (type_enseignement) references type_enseignement (id_type_enseignement)')->execute();
	}

	public function down()
	{
                \DB::query('alter groupe enseignement drop foreign key fk_type_enseignement')->execute();
		\DBUtil::drop_table('enseignement');
	}
}