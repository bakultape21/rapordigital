<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends MX_Controller
{

	private $table_db       = 't_user';
	private $table_prefix   = 'user_';

	public function index()
	{
		$this->load->view('head-new');
		$this->load->view('index-new');
		$this->load->view('footer-new');
	}

	 public function delete_account()
  {

    $this->load->view('head-new');
    $this->load->view('delete_account');
    $this->load->view('footer-new');
  }

  public function save_action($value='')

  {
    $this->form_validation->set_rules('email', 'email', 'trim|required');
    $this->form_validation->set_rules('password', 'password', 'trim|required');
    $this->form_validation->set_rules('reason', 'reason', 'trim|required');

      if ($this->form_validation->run() == TRUE) {

        $cek= $this->m_global->get(['table'=> 't_user_wali', 'where'=> ['email'=> $_POST['email']]]);

        if (@$cek[0] == null) {

            $data['status']     = 0;
            $data['message']    = 'Email Tidak ada';
            if (ENVIRONMENT == 'development')
              $data['error']  = $this->db->error();

            echo json_encode($data);
            exit();
        }else{

            

            if ($cek[0]->password !=  md5_modlogin($_POST['password'], $cek[0]->email)) {

              $data['status']     = 0;
              $data['message']    = 'Password Tidak Sama';
              if (ENVIRONMENT == 'development')
                $data['error']  = $this->db->error();

              echo json_encode($data);
              exit();
            }

        }

        $data_array['email']    = $_POST['email'];
        $data_array['reason']    = $_POST['reason'];
        $insert = [
          'table' => 't_delete_account',
          'datas' => $data_array
        ];

        $result = $this->m_global->insert($insert);

        if ($result['status']) {

          $data['status']     = 1;
          $data['message']    = 'Successfully';

          echo json_encode($data);
        } else {

          $data['status']     = 0;
          $data['message']    = 'Failed';
          if (ENVIRONMENT == 'development')
            $data['error']  = $this->db->error();

          echo json_encode($data);
        }

      } else {
        $result['message']  = validation_errors();
        $result['status']   = 2;

        echo json_encode($result);
      }

  }

	public function form_login()
	{
		$cookie_name   	= $this->config->item('cookie_name');
		$session_name   = $this->config->item('session_name');

		if (get_cookie($cookie_name)) {
			$cookie     = get_cookie($cookie_name);
			$array_config = [
				'table'     => $this->table_db,
				'join'      => [['t_role', 'role_id = user_role']],
				'where'     => ['user_password' => $cookie],
				'select'    => 'user_id, user_full_name, user_name, user_email, user_status, user_photo, role_permission'
			];
			$result   = $this->m_global->get($array_config);
			$this->session->set_userdata($session_name, $result[0]);
			redirect(base_url() . 'dashboard');
		}

		// $this->load->view('index');
		$this->load->view('head-new');
		$this->load->view('login');
		$this->load->view('footer-new');
	}
	public function get_sekolah()
	{
		$q 				= @$_POST['q'];
		$where_e		= "( sekolah_nama LIKE '%" . $q . "%' or npsn LIKE '%" . $q . "%' or kabupaten LIKE '%" . $q . "%' )";

		$arr_config = [
			'table' 	=> 't_sekolah s',
			'where_e' 	=> $where_e,
			'select' 	=> 'sekolah_id id, concat(sekolah_nama, " - ", npsn, " - ",kabupaten) name',
			'join'		=> [
							['kabupaten kb', 'kb.kabupaten_id=s.kabupaten_id'],
							['provinsi p', 'p.provinsi_id=kb.provinsi_id']],
			'start'		=> 0,
			'show'		=> 10,
			'array' 	=> true
		];

		$result = $this->m_global->get($arr_config);

		$data = [];

		foreach ($result as $key => $val) {

			$data[$key] = ['id' => $val['id'], 'text' =>  $val['name']];
		}

		echo json_encode(['item' => $data]);
	}
	public function register()
	{
		$cookie_name   	= $this->config->item('cookie_name');
		$session_name   = $this->config->item('session_name');

		if (get_cookie($cookie_name)) {
			$cookie     = get_cookie($cookie_name);
			$array_config = [
				'table'     => $this->table_db,
				'join'      => [['t_role', 'role_id = user_role']],
				'where'     => ['user_password' => $cookie],
				'select'    => 'user_id, user_full_name, user_name, user_email, user_status, user_photo, role_permission'
			];
			$result   = $this->m_global->get($array_config);
			$this->session->set_userdata($session_name, $result[0]);
			redirect(base_url() . 'dashboard');
		}
		$this->load->view('head-new');
		$this->load->view('register');
		$this->load->view('footer-new');
	}

	public function action_register()
	{
		$this->form_validation->set_rules('guru_nama', 'Nama Guru', 'trim|required');
		$this->form_validation->set_rules('password', 'Password', 'trim|required');
		$this->form_validation->set_rules('nip', 'NIP', 'trim|required');
		$this->form_validation->set_rules('nomor_telepon', 'nomor Telepon', 'trim|required');
		$this->form_validation->set_rules('email', 'email', 'trim|required|is_unique[t_guru.email]');
		$this->form_validation->set_rules('sekolah_id', 'Sekolah', 'trim|required');
		$this->form_validation->set_rules('jabatan', 'Jabatan', 'trim|required');
		$this->form_validation->set_rules('code_aktivasi', 'Kode Aktivasi', 'trim|required');
		$this->form_validation->set_rules('confirm_password', 'Konfirmasi Password', 'trim|required');

		if ($this->form_validation->run($this)) {

			if($_POST['password'] == $_POST['confirm_password']){

				$cek_code= $this->m_global->get(['table'=> 't_code_register', 'where'=> ['code'=> $_POST['code_aktivasi'], ' sampai > NOW()'=> null]]);


				if (!empty($cek_code)) {

					$cek_sekolah= [
						'table'=> 't_sekolah s',
						'select'=> 'count(guru_id) as total_guru, maximum_register',
						'join' => [['t_guru g', 'g.sekolah_id=s.sekolah_id', 'left']],
						'where'=> ['s.sekolah_id'=> $this->input->post('sekolah_id')]
					];
					$sekolah = $this->m_global->get($cek_sekolah)[0];

					if ($sekolah->total_guru >= $sekolah->maximum_register) {
						
						$res = [
							'message' => 'Melebihi Batas Pendaftaran Peserta !',
							'status'  => 0
						];
						echo json_encode($res);
						exit();
					}

					$password=  md5_mod($this->input->post('password'), $this->input->post('email'));
					
					$data_register=[
						'guru_nama'=> $_POST['guru_nama'],
						'nip'		=> $_POST['nip'],
						'nomor_telepon'=> $_POST['nomor_telepon'],
						'email'=> $_POST['email'],
						'jabatan'=> $_POST['jabatan'],
						'sekolah_id'=> $_POST['sekolah_id'],
						'kode_aktivasi'=> $_POST['code_aktivasi'],
						'password'=> $password
					];
					$this->m_global->insert(['table'=> 't_guru', 'datas'=> $data_register]);
					$res = [
						'message' => 'Register Berhasil, Silahkan Login !',
						'status'  => 1
					];
					echo json_encode($res);

				}else{
					$res = [
						'message' => 'Kode Aktivasi Kadaluarsa !',
						'status'  => 0
					];
					echo json_encode($res);
				}
			}else{
				$res = [
					'message' => 'Password tidak sama !',
					'status'  => 0
				];
				echo json_encode($res);

			}
		} else {
			$result['message'] 	= validation_errors();
			$result['status'] 	= 2;

			echo json_encode($result);
		}
	}
	public function action()
	{
		$this->form_validation->set_rules('email', 'Email', 'trim|required');
		$this->form_validation->set_rules('password', 'Password', 'trim|required');

		if ($this->form_validation->run($this)) {
			$email = $this->input->post('email');
			$password = md5_mod($this->input->post('password'), $this->input->post('email'));

			$array_config = [
				'table'     => 't_guru g',
				'join'      => [['t_guru_role', 'role_id = jabatan'], ['t_sekolah s', 's.sekolah_id= g.sekolah_id']],
				'where'     => ['g.email' => $email, 'password' => $password],
				'select'    => 'guru_id as user_id, jabatan as user_role, guru_nama as user_full_name, nip as user_name, g.email as user_email, 1 as user_status, guru_photo as user_photo, role_permission, s.logo as logo_sekolah , g.sekolah_id, s.sekolah_nama'
			];

			$result   = $this->m_global->get($array_config);


			if (!empty($result)) {
				$cookie_name   	= $this->config->item('cookie_name');
				if ($this->input->post('remember') == 1) {
					$day = 60 * 60 * 24 * 7;
					set_cookie($cookie_name, $password, $day);
				}

				$session_name   = $this->config->item('session_name');

				$this->session->set_userdata($session_name, $result[0]);

				$res = [
					'message' => 'Login Berhasil.',
					'status'  => 1
				];

				echo json_encode($res);
			} else {
				$res = [
					'message' => 'Username atau Password salah !',
					'status'  => 0
				];

				echo json_encode($res);
			}
		} else {
			$res = [
				'message' => 'Username atau Password kosong !',
				'status'  => 0
			];

			echo json_encode($res);
		}
	}

	function out()
	{
		$cookie_name   	= $this->config->item('cookie_name');

		if (get_cookie($cookie_name)) {
			delete_cookie($cookie_name);
		}

		$this->session->sess_destroy();

		redirect(base_url() . 'login');
	}
}

/* End of file Login.php */
/* Location: ./application/modules/login/controllers/Login.php */