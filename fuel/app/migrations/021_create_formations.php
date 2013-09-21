<?php

namespace Fuel\Migrations;

class Create_formations
{
	public function up()
	{
		\DBUtil::create_table('fin_formation', array(
			'id_fin_formation' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			't_nom' => array('constraint' => 255, 'type' => 'varchar'),
			't_valeur' => array('constraint' => 10, 'type' => 'varchar'),
			'i_position' => array('constraint' => 11, 'type' => 'int'),
			'type_formation' => array('constraint' => 11, 'type' => 'int'),

		), array('id_fin_formation'));
                \DB::query('alter table fin_formation add constraint fk_type_formation foreign key (type_formation) references type_formation (id_type_formation)')->execute();
	}

	public function down()
	{
                \DB::query('alter groupe fin_formation drop foreign key fk_type_formation')->execute();
		\DBUtil::drop_table('formation');
	}
}