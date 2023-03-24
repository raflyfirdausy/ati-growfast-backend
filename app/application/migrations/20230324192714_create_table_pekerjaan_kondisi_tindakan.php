<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Create_table_pekerjaan_kondisi_tindakan extends CI_Migration
{

	public function up()
	{
		$this->createPekerjaanTable();
		$this->createPekerjaanKondisiTable();
		$this->createPekerjaanTindakanTable();
	}

	private function createPekerjaanTable()
	{
		$tableName 	= "m_pekerjaan";

		$fields 	= [
			"uuid"        		=> [
				"type"    			=> "VARCHAR",
				"constraint"        => 36,
				"null"              => FALSE,
			],
			"nama"        		=> [
				"type"    			=> "VARCHAR",
				"constraint"        => 255,
				"null"              => FALSE,
			],
			"keterangan"   		=> [
				"type"    			=> "TEXT",
				"constraint"        => 0,
				"null"              => TRUE,
			],
			"created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP",
			"updated_at DATETIME NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP",
			"deleted_at DATETIME NULL DEFAULT NULL"
		];

		$this->dbforge->add_field($fields);                         //? ADD FIELDS        
		$this->dbforge->add_key("uuid", TRUE);                 		//? ADD PRIMARY KEY
		$this->dbforge->create_table($tableName, TRUE, ['ENGINE' => 'InnoDB']);

		//! TODO : SEEDER
		$dataSeeder		= [
			[
				"uuid"				=> "848d8df7-7cfa-4acb-bc30-29ef74f63c27",
				"nama"				=> "Perbaikan Bedside Monitor merk Philips MX500",
				"keterangan"		=> NULL
			],
			[
				"uuid"				=> "29319eb2-4e69-4161-83b8-6190abc225ba",
				"nama"				=> "Perbaikan Bedside Monitor merk Philips",
				"keterangan"		=> NULL
			],
		];

		$this->db->insert_batch($tableName, $dataSeeder);
	}

	private function createPekerjaanKondisiTable()
	{
		$tableName 	= "m_pekerjaan_kondisi";

		$fields 	= [
			"uuid"        		=> [
				"type"    			=> "VARCHAR",
				"constraint"        => 36,
				"null"              => FALSE,
			],
			"uuid_pekerjaan"	=> [
				"type"    			=> "VARCHAR",
				"constraint"        => 36,
				"null"              => FALSE,
			],
			"nama"        		=> [
				"type"    			=> "VARCHAR",
				"constraint"        => 255,
				"null"              => FALSE,
			],
			"keterangan"   		=> [
				"type"    			=> "TEXT",
				"constraint"        => 0,
				"null"              => TRUE,
			],
			"created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP",
			"updated_at DATETIME NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP",
			"deleted_at DATETIME NULL DEFAULT NULL"
		];

		$this->dbforge->add_field($fields);                         //? ADD FIELDS        
		$this->dbforge->add_key("uuid", TRUE);                 		//? ADD PRIMARY KEY
		$this->dbforge->create_table($tableName, TRUE, ['ENGINE' => 'InnoDB']);

		//! TODO : SEEDER
		$dataSeeder		= [
			[
				"uuid"				=> uuid(),
				"uuid_pekerjaan"	=> "848d8df7-7cfa-4acb-bc30-29ef74f63c27",
				"nama"				=> "NIB tidak berfungsi",
				"keterangan"		=> NULL
			],
			[
				"uuid"				=> uuid(),
				"uuid_pekerjaan"	=> "29319eb2-4e69-4161-83b8-6190abc225ba",
				"nama"				=> "Alat Mati dan NIBP tidak berfungsi",
				"keterangan"		=> NULL
			],
		];

		$this->db->insert_batch($tableName, $dataSeeder);
	}

	private function createPekerjaanTindakanTable()
	{
		$tableName 	= "m_pekerjaan_tindakan";

		$fields 	= [
			"uuid"        		=> [
				"type"    			=> "VARCHAR",
				"constraint"        => 36,
				"null"              => FALSE,
			],
			"uuid_pekerjaan"	=> [
				"type"    			=> "VARCHAR",
				"constraint"        => 36,
				"null"              => FALSE,
			],
			"nama"        		=> [
				"type"    			=> "VARCHAR",
				"constraint"        => 255,
				"null"              => FALSE,
			],
			"keterangan"   		=> [
				"type"    			=> "TEXT",
				"constraint"        => 0,
				"null"              => TRUE,
			],
			"created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP",
			"updated_at DATETIME NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP",
			"deleted_at DATETIME NULL DEFAULT NULL"
		];

		$this->dbforge->add_field($fields);                         //? ADD FIELDS        
		$this->dbforge->add_key("uuid", TRUE);                 		//? ADD PRIMARY KEY
		$this->dbforge->create_table($tableName, TRUE, ['ENGINE' => 'InnoDB']);

		//! TODO : SEEDER
		$dataSeeder		= [
			[
				"uuid"				=> uuid(),
				"uuid_pekerjaan"	=> "848d8df7-7cfa-4acb-bc30-29ef74f63c27",
				"nama"				=> "Perbaikan Blok Sensor",
				"keterangan"		=> NULL
			],
			[
				"uuid"				=> uuid(),
				"uuid_pekerjaan"	=> "848d8df7-7cfa-4acb-bc30-29ef74f63c27",
				"nama"				=> "Uji Fungsi Alat",
				"keterangan"		=> NULL
			],
			[
				"uuid"				=> uuid(),
				"uuid_pekerjaan"	=> "29319eb2-4e69-4161-83b8-6190abc225ba",
				"nama"				=> "Perbaikan Supply Blok",
				"keterangan"		=> NULL
			],
			[
				"uuid"				=> uuid(),
				"uuid_pekerjaan"	=> "29319eb2-4e69-4161-83b8-6190abc225ba",
				"nama"				=> "Perbaikan Blok Sensor",
				"keterangan"		=> NULL
			],
			[
				"uuid"				=> uuid(),
				"uuid_pekerjaan"	=> "29319eb2-4e69-4161-83b8-6190abc225ba",
				"nama"				=> "Uji Fungsi Alat",
				"keterangan"		=> NULL
			],
		];

		$this->db->insert_batch($tableName, $dataSeeder);
	}

	public function down()
	{
		$this->dbforge->drop_table("m_pekerjaan");
		$this->dbforge->drop_table("m_pekerjaan_kondisi");
		$this->dbforge->drop_table("m_pekerjaan_tindakan");
	}
}
