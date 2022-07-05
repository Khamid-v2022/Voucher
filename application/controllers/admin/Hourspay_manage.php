<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'controllers/admin/Base_Controller.php';

class Hourspay_manage extends Base_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->model('basic_m');
    }

	public function index()
	{
		$data['primary_menu'] = 'Hours Pay';
		
		$this->load->view('admin/header', $data);
		$this->load->view('admin/hourspay_manage', $data);
		$this->load->view('template/footer');
	}

	public function get_hourspays(){
		$list = $this->basic_m->get_hourspays();
		
		$data = [];
		$index = 0;
		
		for($index = 0; $index < count($list); $index++){

			$last_item = '<a onclick="change_info(' . $list[$index]['hours'] . ')" title="edit"><i class="fa fa-edit"></i></a>';

			$array_item = array($list[$index]['hours'], '$' . $list[$index]['pay'], $last_item);
			$data[] = $array_item;
		}

		$result = array(      
	        "recordsTotal" => count($list),
	        "recordsFiltered" => count($list),
	        "data" => $data
	    );

	    echo json_encode($result);
	    exit();
	}

	public function update_info(){
		$req = $this->input->post();

		// update
		$where['hours'] = $req['hours'];
		$this->basic_m->update_hourspay($req, $where);
		$this->generate_json("");
	}

	public function get_hourspay_info($hours){
		$info = $this->basic_m->get_hourspay(array('hours'=>$hours));
		$this->generate_json($info);
	}

}
