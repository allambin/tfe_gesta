<?php

namespace Fuel\Migrations;

class Swap_address_contact_fk
{
	public function up()
	{
            \DB::query('alter table contact drop foreign key fk_contact_adresse1')->execute();
            
            \Fuel\Core\DBUtil::add_fields('adresse', array(
                'contact' => array('type' => 'int', 'null' => true),
            ));
            
            \DB::query('alter table adresse add constraint fk_contact foreign key (contact) references contact (id_contact)')->execute();
            
            $contacts = \Model_Contact::find('all');
            foreach ($contacts as $contact)
            {
                $adresse = \Model_Adresse::find('first', array('where' => array(array('id_adresse', $contact->adresse))));
                $adresse->contact = $contact->id_contact;
                $adresse->save();
            }
            
            \Fuel\Core\DBUtil::drop_fields('contact', array('adresse'));
	}

	public function down()
	{
            \DB::query('alter table adresse drop foreign key fk_contact')->execute();
            
            \Fuel\Core\DBUtil::add_fields('contact', array(
                'adresse' => array('type' => 'int', 'null' => false),
            ));
            
            \DB::query('alter table contact add constraint fk_adresse foreign key (adresse) references adresse (id_adresse)')->execute();
            
            $adresses = \Model_Adresse::find('all');
            foreach ($adresses as $adresse)
            {
                $contact = \Model_Contact::find('first', array('where' => array(array('id_contact', $adresse->contact))));
                $contact->adresse = $adresse->id_adresse;
                $contact->save();
            }
            
            \Fuel\Core\DBUtil::drop_fields('adresse', array('contact'));
	}
}