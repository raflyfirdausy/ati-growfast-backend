<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Create_view_user extends CI_Migration
{

	private $viewName 	= "v_user";
	public function up()
	{
		$queryCreate = "CREATE VIEW $this->viewName AS SELECT
				m_user.id,
				m_user.username,
				m_user.`password`,
				m_user.role,
				m_user.id_instansi,
				m_instansi.nama as instansi_nama,
				m_user.foto,
				m_user.nama,
				m_user.jenis_kelamin,
				m_user.no_telp,
				m_user.id_prov,
				prov.nama AS prov_nama,
				m_user.id_kab,
				kab.nama AS kab_nama,
				m_user.id_kec,
				kec.nama AS kec_nama,
				m_user.id_kel,
				kel.nama AS kel_nama,
				m_user.alamat,
				m_user.rt,
				m_user.rw,
				m_user.keterangan,
				m_user.created_at,
				m_user.updated_at,
				m_user.deleted_at 
			FROM
				m_user
				LEFT JOIN wilayah prov ON prov.kode = m_user.id_prov
				LEFT JOIN wilayah kab ON kab.kode = m_user.id_kab
				LEFT JOIN wilayah kec ON kec.kode = m_user.id_kec
				LEFT JOIN wilayah kel ON kel.kode = m_user.id_kel
				LEFT JOIN m_instansi ON m_instansi.id = m_user.id_instansi";
		$this->db->query($queryCreate);
	}

	public function down()
	{
		$queryDrop = "DROP VIEW " . $this->viewName;
		$this->db->query($queryDrop);
	}
}
