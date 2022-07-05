<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'controllers/admin/Base_Controller.php';

class Committees_manage extends Base_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->model('basic_m');
    }

	public function index()
	{
		$data['primary_menu'] = 'Committees';
		
		$this->load->view('admin/header', $data);
		$this->load->view('admin/committees_manage', $data);
		$this->load->view('template/footer');
	}

	public function get_committees(){
		$list = $this->basic_m->get_committees();
		
		$data = [];
		$index = 0;
		
		for($index = 0; $index < count($list); $index++){

			$last_item = '<a onclick="change_info(' . $list[$index]['id'] . ')" title="edit"><i class="fa fa-edit"></i></a>';
			$last_item .= '<a onclick="delete_info(' . $list[$index]['id'] . ')" title="delete">' . '<i class="fa fa-trash-o position-right"></i></a>';

			$array_item = array($index + 1, $list[$index]['committee'], $last_item);
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

	public function delete_committee($id){
		$where['id'] = $id;
		$this->basic_m->delete_committee($where);
		$this->generate_json("");
	}

	public function add_update_info(){
		$req = $this->input->post();

		if($req['id'] == "0"){	//add new
			$where1 = " committee LIKE '" . $req['committee'] . "'";
			$info = $this->basic_m->get_committee($where1);
			if(!empty($info)){
				$this->generate_json("0", false);
				exit();
				return;
			}
			unset($req['id']);

			$this->basic_m->add_committee($req);
			$this->generate_json("");
		}else{
			// update
			$where3 = "id != " . $req['id'] . " AND committee LIKE '" . $req['committee'] . "'";
			$info3 = $this->basic_m->get_committee($where3);
			if(!empty($info3)){
				$this->generate_json("0", false);
				exit();
				return;
			}			
			$where['id'] = $req['id'];
			$this->basic_m->update_committee($req, $where);
			$this->generate_json("");
		}
	}

	public function get_committee_info($id){
		$info = $this->basic_m->get_committee(array('id'=>$id));
		$this->generate_json($info);
	}

}
