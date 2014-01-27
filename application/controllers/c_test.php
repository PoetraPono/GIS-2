<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class C_test extends CI_Controller {
	
			public function index(){
				$data['base_url'] = $this->config->base_url();
				$data['menu'] = $this->ex->menu();
				$data['list'] = $this->ex->getList('sompret','c_user','c_user','c_user', 'c_user');
				$this->load->view('v_backend', $data);
			}
	}
	