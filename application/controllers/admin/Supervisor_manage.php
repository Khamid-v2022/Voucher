<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'controllers/admin/Base_Controller.php';

class Supervisor_manage extends Base_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->model('basic_m');
    }

	public function index()
	{
		$data['primary_menu'] = 'Supervisors';
		
		$this->load->view('admin/header', $data);
		$this->load->view('admin/supervisor_manage', $data);
		$this->load->view('template/footer');
	}

	public function get_supervisors(){
		$list = $this->basic_m->get_supervisors();
		
		$data = [];
		$index = 0;
		
		for($index = 0; $index < count($list); $index++){

			$last_item = '<a onclick="change_info(' . $list[$index]['id'] . ')" title="edit"><i class="fa fa-edit"></i></a>';
			$last_item .= '<a onclick="delete_info(' . $list[$index]['id'] . ')" title="delete">' . '<i class="fa fa-trash-o position-right"></i></a>';

			$array_item = array($index + 1, $list[$index]['first_name'], $list[$index]['last_name'], $list[$index]['district'], $list[$index]['email'], $last_item);
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

	public function delete_supervisor($id){
		$where['id'] = $id;
		$this->basic_m->delete_supervisor($where);
		$this->generate_json("");
	}

	public function add_update_info(){
		$req = $this->input->post();

		if($req['id'] == 0){	//add new
			$where1 = " LOWER(first_name) LIKE '" . strtolower($req['first_name']) . "' AND LOWER(last_name) LIKE '" . strtolower($req['last_name']) . "'";
			$info = $this->basic_m->get_supervisor($where1);
			if(!empty($info)){
				$this->generate_json("0", false);
				exit();
			}

			unset($req['id']);

			$this->basic_m->add_supervisor($req);
			$this->generate_json("");
		}else{
			// update
			$where3 = "id != " . $req['id'] . " AND LOWER(first_name) LIKE '" . strtolower($req['first_name']) . "' AND LOWER(last_name) LIKE '" . strtolower($req['last_name']) . "'";
			$info3 = $this->basic_m->get_supervisor($where3);
			if(!empty($info3)){
				$this->generate_json("0", false);
				exit();
			}

			$where['id'] = $req['id'];
			$this->basic_m->update_supervisor($req, $where);
			$this->generate_json("");
		}
	}

	public function get_supervisor_info($id){
		$info = $this->basic_m->get_supervisor(array('id'=>$id));
		$this->generate_json($info);
	}

}
