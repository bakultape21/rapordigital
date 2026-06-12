<?php
/**
 * @author   Moch Zawaruddin Abdullah
 */
defined('BASEPATH') OR exit('No direct script access allowed');

if ( ! function_exists('sendEmail'))
{
	function sendEmail($email_destinations = '', $subject = '', $desc = '', $attachments = ''): object
	{
        $CI = &get_instance();
        $config = config_item('email_setting');

        $CI->load->library('email', $config);
        $CI->email->initialize($config);

        $CI->email->set_newline("\r\n");
        $CI->email->set_mailtype("html");

        $CI->email->from($config['smtp_user'], $config['email_alias']);
        $CI->email->to($email_destinations);

        $CI->email->subject($subject);
        $CI->email->message($desc);

        if(is_array($attachments)){
            foreach($attachments as $a){
                $CI->email->attach($a['file_path'], '',  $a['file_name']);
            }
        } else {
            if(!empty($attachments)){
                $CI->email->attach($attachments);
            }
        }

        $status = [
            'status' => false,
            'message' => null,
            'error' => null
        ];

        if (!$CI->email->send()){
            $status['error'] = $this->email->print_debugger();
            $status['message'] = 'Email gagal dikirim.';
        } else {
            $status['status'] =  true;
            $status['message'] =  'Email berhasil dikirim.';
        }
        return json_decode (json_encode ($status), FALSE);
	}
}