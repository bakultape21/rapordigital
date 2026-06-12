<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Tanggal	: 02-11-2017
 * versi 	: 1.000.1.0
 */

class M_cp extends CI_Model
{

	public function set_cp_belajar($kelas_id='', $jenis='')
	{
		$this->db->query("

		INSERT into t_cp_kelas_belajar (cp_nomor, capaian_belajar, elemen_data_id, kelas_id)
		select cp.`capaian_nomor`, cp.capaian_belajar, ed.`elemen_data_id`, k.kelas_id
		 from t_kelas_belajar k 
		join t_sekolah s on s.sekolah_id= k.sekolah_id
		join t_sekolah_elemen se on se.sekolah_id= s.sekolah_id
		join t_sekolah_elemen_data ed on ed.sekolah_elemen_id= se.sekolah_elemen_id

		join t_master_elemen_kelompok mk on mk.kelompok_id= se.sekolah_elemen_kelompok_id
		join t_master_elemen me on me.kelompok_id= mk.kelompok_id and ed.elemen_data = me.`elemen`
		join t_master_cp cp on cp.elemen_id= me.elemen_id


		where se.sekolah_elemen_status=1 and cp.`capaian_jenis`='$jenis' and k.kelas_id='$kelas_id'

			");
	}
}