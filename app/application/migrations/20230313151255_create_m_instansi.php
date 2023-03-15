<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Create_m_instansi extends CI_Migration
{

	private $tableName 	= "m_instansi";
	public function up()
	{
		$fields = [
			"uuid"        		=> [
				"type"    			=> "VARCHAR",
				"constraint"        => 36,
				"null"              => FALSE,
			],
			"nama"        			=> [
				"type"    			=> "VARCHAR",
				"constraint"        => 255,
				"null"              => FALSE,
			],
			"no_telp"				=> [
				"type"    			=> "VARCHAR",
				"constraint"        => 255,
				"null"              => TRUE,
			],
			"direktur"				=> [
				"type"    			=> "VARCHAR",
				"constraint"        => 255,
				"null"              => TRUE,
			],
			"prov"					=> [
				"type"    			=> "VARCHAR",
				"constraint"        => 255,
				"null"              => TRUE,
			],
			"kab"					=> [
				"type"    			=> "VARCHAR",
				"constraint"        => 255,
				"null"              => TRUE,
			],
			"kec"					=> [
				"type"    			=> "VARCHAR",
				"constraint"        => 255,
				"null"              => TRUE,
			],
			"kel"					=> [
				"type"    			=> "VARCHAR",
				"constraint"        => 255,
				"null"              => TRUE,
			],
			"alamat"				=> [
				"type"    			=> "VARCHAR",
				"constraint"        => 255,
				"null"              => TRUE,
			],
			"rt"					=> [
				"type"    			=> "VARCHAR",
				"constraint"        => 255,
				"null"              => TRUE,
			],
			"rw"					=> [
				"type"    			=> "VARCHAR",
				"constraint"        => 255,
				"null"              => TRUE,
			],
			"keterangan"			=> [
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
		$attributes = ['ENGINE' => 'InnoDB'];
		$this->dbforge->create_table($this->tableName, TRUE, $attributes);


		$dataSeeder		= [
			[
				"uuid"					=> "980b2002-e57d-43d4-99eb-e91fd04df766",
				"nama"    				=> "RS Uji coba GrowFast",
				"no_telp"    			=> "085726096515",
				"direktur"        		=> "Rafly Firdausy",
				"prov"					=> "33",
				"kab"					=> "33.02",
				"kec"					=> "33.02.19",
				"kel"					=> "33.02.19.2006",
				"alamat"				=> "Klahang",
				"rt"					=> "005",
				"rt"					=> "002",
				"keterangan"			=> "Testing Aja",
			],
		];
		$this->db->insert_batch($this->tableName, $dataSeeder);
	}

	public function down()
	{
		$this->dbforge->drop_table($this->tableName);
	}
}
