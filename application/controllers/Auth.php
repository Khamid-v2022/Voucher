<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('America/Los_Angeles');
        $this->load->model('auth_m');
    }

	public function index()
	{
		$this->load->view('template/header');
		$this->load->view('login');
		$this->load->view('template/footer');
	}

	public function login(){
		$first_name = $this->input->post('first_name');
		$last_name = $this->input->post('last_name');
		$district = $this->input->post('district');

		$where = "LOWER(first_name) LIKE '" . strtolower($first_name) . "' AND LOWER(last_name) LIKE '" . strtolower($last_name) . "' AND district = '" . $district . "'";

		$info = $this->auth_m->get_user($where);

		if(empty($info)){
			echo "no";
			return;
		}
		$info['is_loggedin'] = true;
		$this->session->set_userdata('user_data', $info);
		echo 'yes';
	}

	public function logout(){
		$this->session->sess_destroy();
        redirect();
	}

	public function update_profile(){
		$req = $this->input->post();
		
		$where1 = "LOWER(first_name) LIKE '" . strtolower($req['first_name']) . "' AND LOWER(last_name) LIKE '" . strtolower($req['last_name']) . "' AND id != " . $req['id'];
		$user_exist = $this->auth_m->get_user($where1);
		if($user_exist){
			echo 'no';
			return;
		}

		$where['id'] = $req['id'];
		$update_info['first_name'] = $req['first_name'];
		$update_info['last_name'] = $req['last_name'];
		$update_info['district'] = $req['district'];
		$update_info['email'] = $req['email'];

		$this->auth_m->update_user($update_info, $where);
		$info = $this->auth_m->get_user($where);
		$info['is_loggedin'] = true;
		$this->session->set_userdata('user_data', $info);
		echo 'yes';
	}

}
