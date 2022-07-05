<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'controllers/admin/Base_Controller.php';

class Settings extends Base_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->model('basic_m');
    }

	public function index()
	{
		$data['primary_menu'] = 'Settings';
		
		$data['settings'] = $this->basic_m->get_setting();
		$this->load->view('admin/header', $data);
		$this->load->view('admin/settings', $data);
		$this->load->view('template/footer');
	}

	public function update_setting(){
		$req = $this->input->post();
		$this->basic_m->update_setting($req);
		$this->generate_json("");
	}

}
