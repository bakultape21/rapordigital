<?php
class Template {

	protected $_ci;

	function __construct()
	{
		$this->_ci = &get_instance();
	}

	

	function display( $template, $data = NULL)
	{
		// $url 		= isset($data['url']) ? $data['url'] : null;
		// $permission = (isset($data['permission'])) ? $data['permission'] : false;

		
		$menu = $this->navbar();
		$data['brand']=$menu['brand'];
		
		
		$this->_ci->load->view('front/template/header', $data);
		$this->_ci->load->view('front/template/navbar', $menu);
		$this->_ci->load->view($template, $data);
		$this->_ci->load->view('front/template/footer', $data);

		// $this->_ci->load->view('templates/index.php', $data);

		
	}
	function display_user( $template, $data = NULL)
	{
		// $url 		= isset($data['url']) ? $data['url'] : null;
		// $permission = (isset($data['permission'])) ? $data['permission'] : false;

		
		$menu = $this->navbar();
		$data['brand']=$menu['brand'];
		
		$this->_ci->load->view('front/template/header', $data);
		$this->_ci->load->view('front/template/navbar', $menu);

        $this->_ci->load->view('front/template/sidebar', $data);
		$this->_ci->load->view($template, $data);
		$this->_ci->load->view('front/template/footer', $data);

		// $this->_ci->load->view('templates/index.php', $data);

		
	}
	function navbar(){

		$this->_ci->load->model('M_auth', 'M_slider', 'M_product', 'M_front', 'm_global');

		$menu['engineering'] = array();
		$menu['material'] = array();
		$menu['installation'] = array();
		$menu['testing']=array();
		$menu['brand']=$this->_ci->M_front->getBrand();
		$data_menu = $this->_ci->M_front->getMenuLevel1();
		
		foreach($data_menu->result() as $dm1){
			if($dm1->product_type === "material"){
				$data_menu2 = $this->_ci->M_front->getMenuLevel2($dm1->cat_lvl_1_id);
				foreach($data_menu2->result() as $dm2){
					$data_menu3 = $this->_ci->M_front->getMenuLevel3($dm2->cat_lvl_2_id);
					foreach($data_menu3->result() as $dm3){
						$menu['material'][$dm1->cat_lvl_1_name][$dm2->cat_lvl_2_name][]=array(
							'id_menu'=>$dm3->cat_lvl_3_id,
							'nama_menu'=>$dm3->cat_lvl_3_name
						);
					}
				}
			} 
			elseif($dm1->product_type === "engineering"){
				$data_menu2 = $this->_ci->M_front->getMenuLevel2($dm1->cat_lvl_1_id);
				foreach($data_menu2->result() as $dm2){
					$data_menu3 = $this->_ci->M_front->getMenuLevel3($dm2->cat_lvl_2_id);
					foreach($data_menu3->result() as $dm3){
						$menu['engineering'][$dm1->cat_lvl_1_name][$dm2->cat_lvl_2_name][]=array(
							'id_menu'=>$dm3->cat_kode,
							'nama_menu'=>$dm3->cat_lvl_3_name
						);
					}
				}
			} else if($dm1->product_type === "installation"){
				$data_menu2 = $this->_ci->M_front->getMenuLevel2($dm1->cat_lvl_1_id);
				foreach($data_menu2->result() as $dm2){
					$menu['installation'][$dm1->cat_lvl_1_name][]=array(
						'id_menu' => $dm2->cat_lvl_1_id,
						'nama_menu'=> $dm2->cat_lvl_2_name
					);
				}
			} elseif($dm1->product_type === "testing"){
				$data_menu2 = $this->_ci->M_front->getMenuLevel2($dm1->cat_lvl_1_id);
				foreach($data_menu2->result() as $dm2){
					$data_menu3 = $this->_ci->M_front->getMenuLevel3($dm2->cat_lvl_2_id);
					foreach($data_menu3->result() as $dm3){
						$menu['testing'][$dm1->cat_lvl_1_name][$dm2->cat_lvl_2_name][]=array(
							'id_menu'=>$dm3->cat_lvl_3_id,
							'nama_menu'=>$dm3->cat_lvl_3_name
						);
					}
				}
			}
			
		}
		return $menu;
	}
}