<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'controllers/admin/Base_Controller.php';

class Submittals extends Base_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->model('basic_m');
        $this->load->model('log_m');
    }

	public function index()
	{
		$data['primary_menu'] = 'Submittals';
		
		$data['to_date'] = date("m/d/Y");
		$data['from_date'] = date('m/d/Y', strtotime('-7 day', strtotime($data['to_date'])));

		$this->load->view('admin/header', $data);
		$this->load->view('admin/submittals', $data);
		$this->load->view('template/footer');
	}

	public function get_submittals(){
		$from_date = $this->input->get('from_date');
		$to_date = $this->input->get('to_date');

		$temp_date = date_create($from_date);
		$f_from_date = date_format($temp_date, 'Y-m-d');
		$temp_date = date_create($to_date);
		$f_to_date = date_format($temp_date, 'Y-m-d');

		$list = $this->log_m->get_tickets($f_from_date, $f_to_date);
		
		$data = [];
		$index = 0;
		
		for($index = 0; $index < count($list); $index++){

			$ticket_item = '<a onclick="view_info(' . $list[$index]['id'] . ')" title="' . $list[$index]['email'] . '">' . $list[$index]['supervisor_name'] . '</a>';

			$short_note = $list[$index]['note'];
			if(strlen($short_note) > 30){
				$short_note = substr($short_note, 0, 30) . '...';
			}
			$note_item = '<span class="document-note" title="' . $list[$index]['note'] . '">' . $short_note . '</span>';

			$array_item = array(date('m/d/Y', strtotime($list[$index]['submit_date'])), $ticket_item, $note_item, $list[$index]['payperiod_total'], $list[$index]['is_corrected'], $list[$index]['initial']);

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

	public function get_submittal_info($id){
		$ticket_info = $this->log_m->get_ticket_where(array('ticket.id' => $id));
		$meeting_list = $this->log_m->get_meeting_logs(array('ticket_id' => $id));
		$event_list = $this->log_m->get_event_logs(array('ticket_id' => $id));

		$msg = array('ticket_info' => $ticket_info, 'meeting_list' => $meeting_list, 'event_list' => $event_list);

		$this->generate_json($msg);
	}

	public function get_supervisor_info($id){
		$info = $this->basic_m->get_supervisor(array('id'=>$id));
		$this->generate_json($info);
	}

}
