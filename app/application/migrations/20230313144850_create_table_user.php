<?php

defined("BASEPATH") or exit("No direct script access allowed");

class Migration_Create_table_user extends CI_Migration
{
	private $tableName 	= "m_user";
	public function up()
	{
		$fields = [
			"uuid VARCHAR(36) DEFAULT UUID()",
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
			"jenis_kelamin"			=> [
				"type"    			=> "VARCHAR",
				"constraint"        => 255,
				"null"              => TRUE,
			],
			"no_telp"				=> [
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
		$this->dbforge->add_key("id", TRUE);                 		//? ADD PRIMARY KEY
		$attributes = array('ENGINE' => 'InnoDB');
		$this->dbforge->create_table($this->tableName, TRUE, $attributes);

		//TODO : INSERT ROOT ADMIN

		$dataSeeder		= [
			[
				"username"    			=> "admin",
				"password"    			=> md5("123123123"),
				"role"        			=> ADMIN,
				"uuid_instansi"        	=> NULL,
				"foto"        			=> NULL,
				"nama"        			=> "Admin Testing",
				"jenis_kelamin" 		=> "LAKI-LAKI",
				"no_telp"				=> "081111111111",
				"prov"					=> "33",
				"kab"					=> "33.02",
				"kec"					=> "33.02.19",
				"kel"					=> "33.02.19.2006",
				"alamat"				=> "Klahang",
				"rt"					=> "005",
				"rt"					=> "002",
				"keterangan"			=> "Testing Aja",
			],
			[
				"username"    			=> "petugas",
				"password"    			=> md5("123123123"),
				"role"        			=> PETUGAS,
				"uuid_instansi"        	=> NULL,
				"foto"        			=> NULL,
				"nama"        			=> "Petugas Testing",
				"jenis_kelamin" 		=> "PEREMPUAN",
				"no_telp"				=> "082222222222",
				"prov"					=> "33",
				"kab"					=> "33.02",
				"kec"					=> "33.02.01",
				"kel"					=> "33.02.01.2003",
				"alamat"				=> "Klahang",
				"rt"					=> "005",
				"rt"					=> "002",
				"keterangan"			=> "Testing Aja petugas",
			],
			[
				"username"    			=> "instansi",
				"password"    			=> md5("123123123"),
				"role"        			=> INSTANSI,
				"uuid_instansi"        	=> NULL,
				"foto"        			=> NULL,
				"nama"        			=> "Instansi Testing",
				"jenis_kelamin" 		=> "LAKI-LAKI",
				"no_telp"				=> "08333333333",
				"prov"					=> "33",
				"kab"					=> "33.02",
				"kec"					=> "33.02.03",
				"kel"					=> "33.02.03.2006",
				"alamat"				=> "Klahang",
				"rt"					=> "005",
				"rt"					=> "002",
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
