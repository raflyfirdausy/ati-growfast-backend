<?php

defined("BASEPATH") or exit("No direct script access allowed");

class Migration_Create_table_user extends CI_Migration
{
	private $tableName 	= "m_user";
	public function up()
	{
		$fields = [
			"uuid"        		=> [
				"type"    			=> "VARCHAR",
				"constraint"        => 36,
				"null"              => FALSE,
			],
			"username"        		=> [
				"type"    			=> "VARCHAR",
				"constraint"        => 255,
				"null"              => FALSE,
			],
			"password"        		=> [
				"type"    			=> "VARCHAR",
				"constraint"        => 255,
				"null"              => FALSE,
			],
			"role"        			=> [
				"type"    			=> "VARCHAR", 		//? ADMIN | PETUGAS | INSTANSI
				"constraint"        => 255,
				"null"              => FALSE,
			],
			"uuid_instansi"     	=> [
				"type"    			=> "VARCHAR",
				"constraint"        => 36,
				"null"              => TRUE,
			],
			"foto"        			=> [
				"type"    			=> "VARCHAR",
				"constraint"        => 255,
				"null"              => TRUE,
			],
			"nama"        			=> [
				"type"    			=> "VARCHAR",
				"constraint"        => 255,
				"null"              => TRUE,
			],
			"jenis_id_kelamin"			=> [
				"type"    			=> "VARCHAR",
				"constraint"        => 255,
				"null"              => TRUE,
			],
			"no_telp"				=> [
				"type"    			=> "VARCHAR",
				"constraint"        => 255,
				"null"              => TRUE,
			],
			"id_prov"					=> [
				"type"    			=> "VARCHAR",
				"constraint"        => 255,
				"null"              => TRUE,
			],
			"id_kab"					=> [
				"type"    			=> "VARCHAR",
				"constraint"        => 255,
				"null"              => TRUE,
			],
			"id_kec"					=> [
				"type"    			=> "VARCHAR",
				"constraint"        => 255,
				"null"              => TRUE,
			],
			"id_kel"					=> [
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

		//TODO : INSERT ROOT ADMIN

		$dataSeeder		= [
			[
				"uuid"					=> uuid(),
				"username"    			=> "admin",
				"password"    			=> md5("123123123"),
				"role"        			=> ADMIN,
				"uuid_instansi"        	=> NULL,
				"foto"        			=> NULL,
				"nama"        			=> "Admin Testing",
				"jenis_id_kelamin" 		=> "LAKI-LAKI",
				"no_telp"				=> "081111111111",
				"id_prov"					=> "33",
				"id_kab"					=> "33.02",
				"id_kec"					=> "33.02.19",
				"id_kel"					=> "33.02.19.2006",
				"alamat"				=> "Klahang",
				"rt"					=> "005",
				"rw"					=> "002",
				"keterangan"			=> "Testing Aja",
			],
			[
				"uuid"					=> uuid(),
				"username"    			=> "petugas",
				"password"    			=> md5("123123123"),
				"role"        			=> PETUGAS,
				"uuid_instansi"        	=> NULL,
				"foto"        			=> NULL,
				"nama"        			=> "Petugas Testing",
				"jenis_id_kelamin" 		=> "PEREMPUAN",
				"no_telp"				=> "082222222222",
				"id_prov"					=> "33",
				"id_kab"					=> "33.02",
				"id_kec"					=> "33.02.01",
				"id_kel"					=> "33.02.01.2003",
				"alamat"				=> "Klahang",
				"rt"					=> "005",
				"rw"					=> "002",
				"keterangan"			=> "Testing Aja petugas",
			],
			[
				"uuid"					=> uuid(),
				"username"    			=> "instansi",
				"password"    			=> md5("123123123"),
				"role"        			=> INSTANSI,
				"uuid_instansi"        	=> "980b2002-e57d-43d4-99eb-e91fd04df766",
				"foto"        			=> NULL,
				"nama"        			=> "Instansi Testing",
				"jenis_id_kelamin" 		=> "LAKI-LAKI",
				"no_telp"				=> "08333333333",
				"id_prov"					=> "33",
				"id_kab"					=> "33.02",
				"id_kec"					=> "33.02.03",
				"id_kel"					=> "33.02.03.2006",
				"alamat"				=> "Klahang",
				"rt"					=> "005",
				"rw"					=> "002",
				"keterangan"			=> "Testing Aja instansi",
			]
		];
		$this->db->insert_batch($this->tableName, $dataSeeder);
	}

	public function down()
	{
		$this->dbforge->drop_table($this->tableName);
	}
}
