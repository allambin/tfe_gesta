<?php

namespace Fuel\Migrations;

class Create_type_cedefop
{
	public function up()
	{
		\DBUtil::create_table('type_cedefop', array(
			'id_cedefop' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			't_nom' => array('constraint' => 255, 'type' => 'varchar'),
			'i_code' => array('constraint' => 11, 'type' => 'int'),
			'i_position' => array('constraint' => 11, 'type' => 'int'),

		), array('id_cedefop'));
                
                \DB::query('alter table groupe modify column t_code_cedefop int')->execute();
                \DB::query('alter table groupe add constraint fk_user foreign key (login) references users (id)')->execute();
                
	}

	public function down()
	{
		\DBUtil::drop_table('type_cedefop');
                \DB::query('alter groupe adresse drop foreign key fk_user')->execute();
                \DB::query('alter table groupe modify column t_code_cedefop varchar(50)')->execute();
	}
}