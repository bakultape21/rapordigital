<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Kebiasaan_model extends CI_Model {

    public function __construct(){
        parent::__construct();
        $this->db->query("SET time_zone='+07:00'");
    }
    public function tarikKebiasaan($id) {

         $this->db->query("INSERT into t_kelas_belajar_kebiasaan(  pertanyaan, icon, kelas_id)   SELECT  pertanyaan, icon, ? from t_kelas_belajar_kebiasaan_template", [$id]);
         $this->db->query("INSERT into t_kelas_belajar_kebiasaan_option (kebiasaan_id, option)
            select k.kebiasaan_id, opt.option
            from t_kelas_belajar_kebiasaan k
            join t_kelas_belajar_kebiasaan_template t on t.pertanyaan= k.pertanyaan
            join t_kelas_belajar_kebiasaan_template_option opt on opt.kebiasaan_id= t.kebiasaan_id
            where kelas_id=?", [$id]);

        return true;
    }
}