<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Create_setting_table extends CI_Migration
{

	private $tableName 	= "m_setting";
	public function up()
	{
		$fields = [
			"uuid"        			=> [
				"type"    			=> "VARCHAR",
				"constraint"        => 36,
				"null"              => FALSE,
			],
			"author"        		=> [
				"type"    			=> "VARCHAR",
				"constraint"        => 255,
				"null"              => FALSE,
			],
			"id_prov"				=> [
				"type"    			=> "VARCHAR",
				"constraint"        => 255,
				"null"              => TRUE,
			],
			"id_kab"				=> [
				"type"    			=> "VARCHAR",
				"constraint"        => 255,
				"null"              => TRUE,
			],
			"id_kec"				=> [
				"type"    			=> "VARCHAR",
				"constraint"        => 255,
				"null"              => TRUE,
			],
			"id_kel"				=> [
				"type"    			=> "VARCHAR",
				"constraint"        => 255,
				"null"              => TRUE,
			],
			"alamat"				=> [
				"type"    			=> "VARCHAR",
				"constraint"        => 255,
				"null"              => TRUE,
			],
			"kode_pos"				=> [
				"type"    			=> "VARCHAR",
				"constraint"        => 255,
				"null"              => TRUE,
			],
			"no_telp"				=> [
				"type"    			=> "VARCHAR",
				"constraint"        => 255,
				"null"              => TRUE,
			],
			"hotline"				=> [
				"type"    			=> "VARCHAR",
				"constraint"        => 255,
				"null"              => TRUE,
			],
			"email"				=> [
				"type"    			=> "VARCHAR",
				"constraint"        => 255,
				"null"              => TRUE,
			],
			"created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP",
			"updated_at DATETIME NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP",
			"deleted_at DATETIME NULL DEFAULT NULL"
		];

		$this->dbforge->add_field($fields);                         //? ADD FIELDS        
		$this->dbforge->add_key("uuid", TRUE);                 		//? ADD PRIMARY KEY		
		$this->dbforge->create_table($this->tableName, TRUE, ['ENGINE' => 'InnoDB']);

		//TODO : INSERT DATA DUMMY
		$dataSeeder		= [
			[
				"uuid"		=> uuid(),
				"author"	=> "PT. ALDANA TEKNIK INDONESIA",
				"id_prov"	=> "33",
				"id_kab"	=> "33.02",
				"id_kec"	=> "33.02.19",
				"id_kel"	=> "33.02.19.2006",
				"alamat"	=> "Jln. Raya Sokaraja Banyumas",
				"kode_pos"	=> "53191",
				"no_telp"	=> "0281-7862146",
				"hotline"	=> "081327893274",
				"email"		=> "aldanateknikindonesia@gmail.com"
			]
		];
		$this->db->insert_batch($this->tableName, $dataSeeder);
	}

	public function down()
	{
		$this->dbforge->drop_table($this->tableName);
	}
}
