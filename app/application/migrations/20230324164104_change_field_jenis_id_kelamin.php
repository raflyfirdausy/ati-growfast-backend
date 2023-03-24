<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Change_field_jenis_id_kelamin extends CI_Migration
{

	private $tableName 	= "m_user";
	public function up()
	{
		$fields = [
			"jenis_id_kelamin"	=> [
				"name"			=> "jenis_kelamin",
				"type"			=> "VARCHAR",
				"constraint"	=> 255,
				"null"			=> TRUE
			]
		];

		$this->dbforge->modify_column($this->tableName, $fields);
	}

	public function down()
	{
		$fields = [
			"jenis_kelamin"	=> [
				"name"			=> "jenis_id_kelamin",
				"type"			=> "VARCHAR",
				"constraint"	=> 255,
				"null"			=> TRUE
			]
		];

		$this->dbforge->modify_column($this->tableName, $fields);
	}
}
