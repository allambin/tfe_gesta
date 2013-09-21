<?php

namespace Fuel\Migrations;

class Create_participants
{
	public function up()
	{
		\DBUtil::create_table('participants', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'id_participant' => array('constraint' => 11, 'type' => 'int'),
			't_nom' => array('constraint' => 50, 'type' => 'varchar'),
			't_prenom' => array('constraint' => 50, 'type' => 'varchar'),
			't_nationalite' => array('constraint' => 50, 'type' => 'varchar'),
			't_lieu_naissance' => array('constraint' => 255, 'type' => 'varchar'),
			'd_date_naissance' => array('type' => 'date'),
			't_sexe' => array('constraint' => 1, 'type' => 'varchar'),
			't_type_etude' => array('constraint' => 255, 'type' => 'varchar'),
			't_diplome' => array('constraint' => 255, 'type' => 'varchar'),
			'd_fin_etude' => array('type' => 'date'),
			't_annee_etude' => array('constraint' => 255, 'type' => 'varchar'),
			't_etat_civil' => array('constraint' => 11, 'type' => 'varchar'),
			't_registre_national' => array('constraint' => 15, 'type' => 'varchar'),
			't_compte_bancaire' => array('constraint' => 14, 'type' => 'varchar'),
			't_pointure' => array('constraint' => 10, 'type' => 'varchar'),
			't_taille' => array('constraint' => 10, 'type' => 'varchar'),
			't_enfants_charge' => array('constraint' => 3, 'type' => 'varchar'),
			't_mutuelle' => array('constraint' => 50, 'type' => 'varchar'),
			't_organisme_paiement' => array('constraint' => 255, 'type' => 'varchar'),
			't_permis' => array('constraint' => 10, 'type' => 'varchar'),
			't_moyen_transport' => array('constraint' => 50, 'type' => 'varchar'),
			'i_frais_stagiaire' => array('type' => 'double'),
			'd_date_inscription_onem' => array('type' => 'date'),
			'd_date_fin_stage_onem' => array('type' => 'date'),
			'tNumeroInscriptionOnem' => array('constraint' => 45, 'type' => 'varchar'),
			'd_date_expiration_carte_sejour' => array('type' => 'date'),
			'd_date_examen_medical' => array('type' => 'date'),
			't_lieu_examen_medical' => array('constraint' => 45, 'type' => 'varchar'),
			'i_identification_bob' => array('constraint' => 11, 'type' => 'int'),
			't_gsm' => array('constraint' => 20, 'type' => 'varchar'),
			't_numero_inscription_forem' => array('constraint' => 45, 'type' => 'varchar'),
			'd_date_inscription_forem' => array('type' => 'date'),
			'b_attestation_reussite' => array('constraint' => 1, 'type' => 'tinyint'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('participants');
	}
}