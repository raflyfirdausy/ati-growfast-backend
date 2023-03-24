<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Create_table_m_alat_barang extends CI_Migration
{

	private $tableName 	= "m_alat_barang";
	public function up()
	{
		$fields = [
			"uuid"        		=> [
				"type"    			=> "VARCHAR",
				"constraint"        => 36,
				"null"              => FALSE,
			],
			"kode"        		=> [
				"type"    			=> "VARCHAR",
				"constraint"        => 10,
				"null"              => FALSE,
			],
			"jenis"        		=> [					//! ALAT | BARANG
				"type"    			=> "VARCHAR",
				"constraint"        => 255,
				"null"              => FALSE,
			],
			"nama"        		=> [
				"type"    			=> "VARCHAR",
				"constraint"        => 255,
				"null"              => FALSE,
			],
			"harga"        		=> [
				"type"    			=> "INT",
				"constraint"        => 11,
				"null"              => FALSE,
				"default"			=> 0
			],
			"gambar"        	=> [
				"type"    			=> "VARCHAR",
				"constraint"        => 255,
				"null"              => TRUE,
			],
			"deskripsi"   		=> [
				"type"    			=> "TEXT",
				"constraint"        => 0,
				"null"              => TRUE,
			],
			"pdf_pemakaian" 	=> [
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

		$this->createSeeder();
	}

	private function createSeeder()
	{
		$dataSeeder		= [
			[
				"uuid"				=> uuid(),
				"kode"				=> generator(5),
				"jenis"				=> "ALAT",
				"nama"				=> "Timbangan Dewasa",
				"harga"				=> 180000,
				"gambar"			=> NULL,
				"deskripsi"			=> "Contoh timbangan dewasa",
				"pdf_pemakaian"		=> NULL
			],
			[
				"uuid"				=> uuid(),
				"kode"				=> generator(5),
				"jenis"				=> "ALAT",
				"nama"				=> "Dental Unit",
				"harga"				=> 433000,
				"gambar"			=> NULL,
				"deskripsi"			=> "Contoh dental unit",
				"pdf_pemakaian"		=> NULL
			],
			[
				"uuid"				=> uuid(),
				"kode"				=> generator(5),
				"jenis"				=> "ALAT",
				"nama"				=> "Nebulizer",
				"harga"				=> 329000,
				"gambar"			=> NULL,
				"deskripsi"			=> "Contoh Nebulizer",
				"pdf_pemakaian"		=> NULL
			],
			[
				"uuid"				=> uuid(),
				"kode"				=> generator(5),
				"jenis"				=> "BARANG",
				"nama"				=> "Contoh Barang 1",
				"harga"				=> 123000,
				"gambar"			=> NULL,
				"deskripsi"			=> "Contoh Barang 1",
				"pdf_pemakaian"		=> NULL
			],
			[
				"uuid"				=> uuid(),
				"kode"				=> generator(5),
				"jenis"				=> "BARANG",
				"nama"				=> "Contoh Barang 2",
				"harga"				=> 321000,
				"gambar"			=> NULL,
				"deskripsi"			=> "Contoh Barang 2",
				"pdf_pemakaian"		=> NULL
			],
		];
		$this->db->insert_batch($this->tableName, $dataSeeder);
	}

	public function down()
	{
		$this->dbforge->drop_table($this->tableName);
	}
}
