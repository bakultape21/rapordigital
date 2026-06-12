<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
 *  FrontEnd Controller
 *  untuk menangani filter list produk
 *  Author : Moch Zawaruddin Abdullah
 * */
class FE_Controller extends CI_Controller {
    protected $order_filter = array();
    protected $schema_filter = array();
    protected $paginate_filter = array();
    protected $price_filter = array();

	function __construct() {
		parent::__construct();

        $this->order_filter = [
            'AZ' => 'Harga Terkecil - Terbesar',
            'ZA' => 'Harga Terbesar - Terkecil',
        ];

        $this->schema_filter = [
            'minat' => 'Paling Diminati',
            'populer' => 'Populer',
            'terbaru' => 'Produk Terbaru',
            'terlaris' => 'Terlaris',
            'sesuai' => 'Paling Sesuai'
        ];
        $this->paginate_filter = [
            10 => '10 Produk',
            20 => '20 Produk',
            40 => '40 Produk',
            80 => '80 Produk',
            120 => '120 Produk',
        ];

        $this->price_filter = [
            0 => 'Semua',
            1 => 'Rp0 - Rp100.000',
            2 => 'Rp100.000 - Rp500.000',
            3 => 'Rp500.000 - Rp1.000.000',
            4 => 'Rp1.000.000 and above'
        ];
	}

    public function order_exists($order_by = null): bool {
        return (!empty($order_by) && array_key_exists(strtoupper($order_by), $this->order_filter));
    }

    public function schema_exists($schema_by = null): bool {
        return (!empty($schema_by) && array_key_exists(strtolower($schema_by), $this->schema_filter));
    }

    public function paginate_exists($paginate_by = 0): bool {
        return (!empty($paginate_by) && array_key_exists(intval($paginate_by), $this->paginate_filter));
    }

    public function pagination_link($url, $total = 10, $pages = []){
        $this->load->library('pagination');

        unset($pages['page']);

        $config['page_query_string'] 	= true;
        $config['query_string_segment'] = 'page';
        $config['base_url'] 	        = site_url($url.'?'.http_build_query($pages));
        $config['total_rows'] 	        = $total;
        $config['per_page'] 	        = $pages['perpage'];
        $config['num_links'] 	        = 5;
        $config['first_link'] 			= '&laquo; First';
        $config['first_tag_open'] 		= '<li class="page-item">';
        $config['first_tag_close'] 		= '</li>';
        $config['last_link'] 			= 'Last &raquo;';
        $config['last_tag_open'] 		= '<li class="page-item">';
        $config['last_tag_close'] 		= '</li>';
        $config['next_link'] 			= 'Next';
        $config['next_tag_open'] 		= '<li class="page-item">';
        $config['next_tag_close'] 		= '</li>';
        $config['prev_link'] 			= 'Prev';
        $config['prev_tag_open'] 		= '<li class="page-item">';
        $config['prev_tag_close'] 		= '</li>';
        $config['cur_tag_open'] 		= '<li class="page-item active"><a href="#" class="page-link">';
        $config['cur_tag_close'] 		= '</a></li>';
        $config['num_tag_open'] 		= '<li class="page-item">';
        $config['num_tag_close'] 		= '</li>';
        $config['use_page_numbers'] 	= TRUE;
        $config['full_tag_open'] 		= '<ul class="pagination justify-content-center">';
        $config['full_tag_close'] 		= '</ul>';
        $config['attributes'] 		    = ['class' => 'page-link'];

        $this->pagination->initialize($config);

        return $this->pagination->create_links();
    }
}
