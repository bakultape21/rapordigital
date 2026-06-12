<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	function get_plugin($plugin = null) {
		$arr = [
			'datatables' => [
								'css' => [
											'<link href="'.base_url('./../assets/plugins/custom/datatables/datatables.bundle.css').'" rel="stylesheet" type="text/css" />',
										],
								'js'  => [
											'<script src="'.base_url('./../assets/plugins/custom/datatables/datatables.bundle.js').'" type="text/javascript"></script>',
											'<script src="'.base_url('./../assets/custom/js/helper_datatable.js').'" type="text/javascript"></script>',
											'<script src="'.base_url('./../assets/custom/js/initDataTable.js').'" type="text/javascript"></script>',
										]
							],
			'validation' => [
								'css' => [],
								'js'  => [
											// '<script src="'.base_url('./../assets/plugins/jquery-validation/jquery.validate.min.js').'" type="text/javascript"></script>',
											// '<script src="'.base_url('./../assets/plugins/jquery-validation/additional-methods.min.js').'" type="text/javascript"></script>',
											'<script src="'.base_url('./../assets/custom/js/validation.js').'" type="text/javascript"></script>',
										]
							],
			'jstree' => [
							'css' => ['<link href="'.base_url('./../assets/plugins/custom/jstree/jstree.bundle.css').'" rel="stylesheet" type="text/css" />'],
							'js'  => ['<script src="'.base_url('./../assets/plugins/custom/jstree/jstree.bundle.js').'" type="text/javascript"></script>']
						],
			// 'fancytree' => [
			// 	 				'css' => [
			// 	 					'<link href="'.base_url('./../assets/plugins/fancytree/skin-win8/ui.fancytree.css').'" rel="stylesheet" type="text/css" />'
			// 	 				],
			// 	 				'js' => [
			// 	 					'<script src="'.base_url('./../assets/plugins/fancytree/js/jquery-ui.min.js').'" type="text/javascript"></script>',
			// 	 					'<script src="'.base_url('./../assets/plugins/fancytree/js/jquery.fancytree-all.min.js').'" type="text/javascript"></script>'
			// 	 				]
			// 				],
			'nestable' => [
				 				'css' => [
				 					'<link href="'.base_url('./../assets/custom/css/nestable.css').'" rel="stylesheet" type="text/css" />'
				 				],
				 				'js' => [
				 					'<script src="'.base_url('./../assets/custom/js/nestable.js').'" type="text/javascript"></script>',
				 				]
							],
		];

		if($plugin == null) {
			return false;
			exit;
		}

		if(is_array($plugin)) {
			foreach ($plugin as $key => $val) {
				if(!in_array($val, ['js', 'css'])) {
					$css = $arr[ $val ]['css'];
					$js  = $arr[ $val ]['js'];

					foreach ($css as $k => $v) {
						echo $v."\n";
					}

					foreach ($js as $k => $v) {
						echo $v."\n";
					}
				} else {
					$each  = $arr[ $key ][ $val ];

					foreach ($each as $k => $v) {
						echo $v."\n";
					}
				}
			}
		} else {
			$css = $arr[ $plugin ]['css'];
			$js  = $arr[ $plugin ]['js'];

			foreach ($css as $key => $val) {
				echo $val."\n";
			}

			foreach ($js as $key => $val) {
				echo $val."\n";
			}
		}
	}
