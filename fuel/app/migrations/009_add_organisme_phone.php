<?php

namespace Fuel\Migrations;

class Add_organisme_phone
{
	public function up()
	{
            \Fuel\Core\DBUtil::add_fields('participant', array(
                't_organisme_paiement_phone' => array('constraint' => 20, 'type' => 'varchar', 'null' => true)
            ));
	}

	public function down()
	{
            \Fuel\Core\DBUtil::drop_fields('participant', array('t_organisme_paiement_phone'));
	}
}