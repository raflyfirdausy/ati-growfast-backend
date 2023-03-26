<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Create_view_instansi extends CI_Migration
{

	private $viewName 	= "v_instansi";
	public function up()
	{
		$queryCreate = "CREATE VIEW $this->viewName AS SELECT
			m_instansi.id,
			m_instansi.nama,
			m_instansi.no_telp,
			m_instansi.direktur,
			m_instansi.prov,
			prov.nama as prov_nama,
			m_instansi.kab,
			kab.nama as kab_nama,
			m_instansi.kec,
			kec.nama as kec_nama,
			m_instansi.kel,
			kel.nama as kel_nama,
			m_instansi.alamat,
			m_instansi.rt,
			m_instansi.rw,
			m_instansi.keterangan,
			m_instansi.created_at,
			m_instansi.updated_at,
			m_instansi.deleted_at 
		FROM
			m_instansi
		LEFT JOIN wilayah prov ON prov.kode = m_instansi.prov
		LEFT JOIN wilayah kab ON kab.kode = m_instansi.kab
		LEFT JOIN wilayah kec ON kec.kode = m_instansi.kec
		LEFT JOIN wilayah kel ON kel.kode = m_instansi.kel";
		$this->db->query($queryCreate);
	}

	public function down()
	{
		$queryDrop = "DROP VIEW " . $this->viewName;
		$this->db->query($queryDrop);
	}
}
