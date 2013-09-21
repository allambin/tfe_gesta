<?php

namespace Fuel\Migrations;

class Add_actif
{
	public function up()
	{
            \Fuel\Core\DBUtil::add_fields('liste_attente', array(
                'bIsActif' => array('type' => 'tinyint', 'null' => false, 'default' => 1),
            ));
	}

	public function down()
	{
            \Fuel\Core\DBUtil::drop_fields('liste_attente', array('bIsActif'));
	}
}