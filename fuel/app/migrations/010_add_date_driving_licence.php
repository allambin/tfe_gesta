<?php

namespace Fuel\Migrations;

class Add_date_driving_licence
{
	public function up()
	{
            \Fuel\Core\DBUtil::add_fields('participant', array(
                'd_date_permis_theorique' => array('type' => 'date', 'null' => true)
            ));
	}

	public function down()
	{
            \Fuel\Core\DBUtil::drop_fields('participant', array('d_date_permis_theorique'));
	}
}