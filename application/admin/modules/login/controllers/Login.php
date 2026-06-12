<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends MX_Controller
{

	private $table_db       = 't_user';
	private $table_prefix   = 'user_';

	public function index()
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

		$this->load->view('index');
	}

	public function action()
	{
		$this->form_validation->set_rules('username', 'Username', 'trim|required');
		$this->form_validation->set_rules('password', 'Password', 'trim|required');

		if ($this->form_validation->run($this)) {
			$username = $this->input->post('username');
			$password = md5_mod($this->input->post('password'), $this->input->post('username'));

			$array_config = [
				'table'     => $this->table_db,
				'join'      => [['t_role', 'role_id = user_role']],
				'where'     => ['user_name' => $username, 'user_password' => $password],
				'select'    => 'user_id, user_full_name, user_name, user_email, user_status, user_photo, role_permission'
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