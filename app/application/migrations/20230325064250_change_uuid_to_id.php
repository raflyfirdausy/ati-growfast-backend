<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Change_uuid_to_id extends CI_Migration
{

	public function up()
	{
		$this->dbforge->modify_column("m_alat_barang", [
			"uuid"	=> [
				"name"			=> "id",
				"type"			=> "VARCHAR",
				"constraint"	=> 36,
				"null"			=> FALSE
			]
		]);

		$this->dbforge->modify_column("m_instansi", [
			"uuid"	=> [
				"name"			=> "id",
				"type"			=> "VARCHAR",
				"constraint"	=> 36,
				"null"			=> FALSE
			]
		]);

		$this->dbforge->modify_column("m_pekerjaan", [
			"uuid"	=> [
				"name"			=> "id",
				"type"			=> "VARCHAR",
				"constraint"	=> 36,
				"null"			=> FALSE
			]
		]);

		$this->dbforge->modify_column("m_pekerjaan_kondisi", [
			"uuid"	=> [
				"name"			=> "id",
				"type"			=> "VARCHAR",
				"constraint"	=> 36,
				"null"			=> FALSE
			],
			"uuid_pekerjaan"	=> [
				"name"			=> "id_pekerjaan",
				"type"			=> "VARCHAR",
				"constraint"	=> 36,
				"null"			=> FALSE
			]
		]);

		$this->dbforge->modify_column("m_pekerjaan_tindakan", [
			"uuid"	=> [
				"name"			=> "id",
				"type"			=> "VARCHAR",
				"constraint"	=> 36,
				"null"			=> FALSE
			],
			"uuid_pekerjaan"	=> [
				"name"			=> "id_pekerjaan",
				"type"			=> "VARCHAR",
				"constraint"	=> 36,
				"null"			=> FALSE
			]
		]);

		$this->dbforge->modify_column("m_setting", [
			"uuid"	=> [
				"name"			=> "id",
				"type"			=> "VARCHAR",
				"constraint"	=> 36,
				"null"			=> FALSE
			]
		]);

		$this->dbforge->modify_column("m_user", [
			"uuid"	=> [
				"name"			=> "id",
				"type"			=> "VARCHAR",
				"constraint"	=> 36,
				"null"			=> FALSE
			],
			"uuid_instansi"	=> [
				"name"			=> "id_instansi",
				"type"			=> "VARCHAR",
				"constraint"	=> 36,
				"null"			=> FALSE
			]
		]);
	}

	public function down()
	{
		$this->dbforge->modify_column("m_alat_barang", [
			"id"	=> [
				"name"			=> "uuid",
				"type"			=> "VARCHAR",
				"constraint"	=> 36,
				"null"			=> FALSE
			]
		]);

		$this->dbforge->modify_column("m_instansi", [
			"id"	=> [
				"name"			=> "uuid",
				"type"			=> "VARCHAR",
				"constraint"	=> 36,
				"null"			=> FALSE
			]
		]);

		$this->dbforge->modify_column("m_pekerjaan", [
			"id"	=> [
				"name"			=> "uuid",
				"type"			=> "VARCHAR",
				"constraint"	=> 36,
				"null"			=> FALSE
			]
		]);

		$this->dbforge->modify_column("m_pekerjaan_kondisi", [
			"id"	=> [
				"name"			=> "uuid",
				"type"			=> "VARCHAR",
				"constraint"	=> 36,
				"null"			=> FALSE
			],
			"id_pekerjaan"	=> [
				"name"			=> "uuid_pekerjaan",
				"type"			=> "VARCHAR",
				"constraint"	=> 36,
				"null"			=> FALSE
			]
		]);

		$this->dbforge->modify_column("m_pekerjaan_tindakan", [
			"id"	=> [
				"name"			=> "uuid",
				"type"			=> "VARCHAR",
				"constraint"	=> 36,
				"null"			=> FALSE
			],
			"id_pekerjaan"	=> [
				"name"			=> "uuid_pekerjaan",
				"type"			=> "VARCHAR",
				"constraint"	=> 36,
				"null"			=> FALSE
			]
		]);

		$this->dbforge->modify_column("m_setting", [
			"id"	=> [
				"name"			=> "uuid",
				"type"			=> "VARCHAR",
				"constraint"	=> 36,
				"null"			=> FALSE
			]
		]);

		$this->dbforge->modify_column("m_user", [
			"id"	=> [
				"name"			=> "uuid",
				"type"			=> "VARCHAR",
				"constraint"	=> 36,
				"null"			=> FALSE
			],
			"id_instansi"	=> [
				"name"			=> "uuid_instansi",
				"type"			=> "VARCHAR",
				"constraint"	=> 36,
				"null"			=> FALSE
			]
		]);
	}
}
