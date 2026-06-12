<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Syarat_ketentuan extends CI_Controller {

  public function index()
  {
    $this->load->view('Syarat_ketentuan');
  }
  public function delete_account()
  {

    $this->load->view('head');
    $this->load->view('delete_account');
    $this->load->view('footer');
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
}