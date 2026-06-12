<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_helpers extends CI_Model {

	public function set_elemen_data($id)
	{
		$query = "INSERT into 
t_sekolah_elemen_data(sekolah_elemen_id, elemen_data, elemen_nomor)

		select s.sekolah_elemen_id, elemen, nomor from 
t_master_elemen e  
		join t_sekolah_elemen s on s.sekolah_elemen_kelompok_id= e.kelompok_id
		where s.sekolah_elemen_id='$id'";

		$this->db->query($query);
	}

}
