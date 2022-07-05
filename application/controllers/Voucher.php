<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require __DIR__ . '/../../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require __DIR__ . '/../../vendor/phpmailer/phpmailer/src/PHPMailer.php';
require __DIR__ . '/../../vendor/phpmailer/phpmailer/src/SMTP.php';
require __DIR__ . '/../../vendor/phpmailer/phpmailer/src/Exception.php';

class Voucher extends MY_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->model('basic_m');
        $this->load->model('log_m');
    }

	public function index() {

		$data['submitted_dates'] = [];
		$my_tickets = $this->log_m->get_ticket_list($this->session->user_data['id']);
		foreach($my_tickets as $item){
			array_push($data['submitted_dates'], $item['submit_date']);
		}


		$data['committees'] = $this->basic_m->get_committees();
		$data['today'] = date('m/d/Y');

		if(isset($_POST['sel_date'])){
			$data['sel_date'] = $_POST['sel_date'];
		}
		else{
			$data['sel_date'] = $data['today'];
		}

		$data['ticket_info'] = $this->log_m->get_ticket($this->session->user_data['id'], $data['sel_date']);
		
		if($data['today'] == $data['sel_date']){
			$data['is_today'] = 'y';
		}else{
			$data['is_today'] = 'n';
		}


		// old rule
		// if((!empty($data['ticket_info']) && $data['ticket_info']['is_submited'] == 'y') || $data['today'] != $data['sel_date']){
			
		// 	$data['is_editable'] = 'n';
			
		// 	if(!empty($data['ticket_info']) && $data['ticket_info']['is_corrected'] == 'y' && $data['is_today'] == 'y'){
		// 		$data['is_editable'] = 'y';
		// 	}
		// } else {
		// 	$data['is_editable'] = 'y';
		// }



		// if((!empty($data['ticket_info']) && $data['ticket_info']['is_submited'] == 'y')){
			
		// 	$data['is_editable'] = 'n';
			
		// 	if(!empty($data['ticket_info']) && $data['ticket_info']['is_corrected'] == 'y' && $data['is_today'] == 'y'){
		// 		$data['is_editable'] = 'y';
		// 	}
		// } else {
		// 	$data['is_editable'] = 'y';
		// }
		$data['is_editable'] = 'y';
		
		
		$meeting_list = [];
		$event_list = [];
		if(!empty($data['ticket_info'])){
			$where['ticket_id'] = $data['ticket_info']['id'];
			$meeting_list = $this->log_m->get_meeting_logs($where);
			$event_list = $this->log_m->get_event_logs($where);
		}
		
		$data['meeting_list'] = $meeting_list;
		$data['event_list'] = $event_list;

		$data['setting'] = $this->basic_m->get_setting();

		$this->load->view('template/header');
		$this->load->view('voucher', $data);
	}

	public function add_update_committe_meeting(){
		$req = $this->input->post();

		if($req['ticket_id'] == "0"){
			// create ticket
			$info['ticket_id'] = $this->create_empty_ticket();
		} else {
			$info['ticket_id'] = $req['ticket_id'];
		}
		// re calculate ticket payperiod_total



		$where_hourspay['hours'] = $req['hours'];
		$hourspay = $this->basic_m->get_hourspay($where_hourspay);
		
		if(empty($hourspay))
			$info['hourspay'] = 0;
		else
			$info['hourspay'] = $hourspay['pay'];
		

		$setting = $this->basic_m->get_setting();

		$info['committee_id'] = $req['committe'];

		$date = date_create($req['date']);
		$info['date'] = date_format($date, 'Y-m-d');
		$info['hours'] = $req['hours'];
		$info['miles'] = $req['miles'];
		$info['mileagepay'] = round($setting['mileagerate'] * intval($req['miles']), 2);
		


		// calculate daily limit hourspay - limit 110$
		if(isset($req['id'])){
			$total_hourpay_daily = $this->log_m->get_total_hourspay_for_update($info['ticket_id'], $info['date'], $req['id']);
		}else {
			$total_hourpay_daily = $this->log_m->get_total_hourspay($info['ticket_id'], $info['date']);
		}
		
		
		if($total_hourpay_daily + $info['hourspay'] > $setting['daily_limit']){
			$temp_hourspay = $setting['daily_limit'] - $total_hourpay_daily;
			$temp = $total_hourpay_daily + $info['hourspay'] - $setting['daily_limit'];
			$info['hourspay'] = $temp_hourspay;
			$info['hourspay_more'] = $temp;
		}

		$info['totalpay'] = $info['hourspay'] + $info['mileagepay'];

		if(isset($req['id'])){
			$where['id'] = $req['id'];
			$info['updated_at'] = date('Y-m-d H:i:s');
			$this->log_m->update_meeting_log($info, $where);
		}else {
			$info['created_at'] = date('Y-m-d H:i:s');
			$this->log_m->add_meeting_log($info);
		}

		$this->generate_json("");
	}

	public function get_meeting($meeting_id){
		$info = $this->log_m->get_meeting_log($meeting_id);
		$this->generate_json($info);
	}

	public function delete_meeting($meeting_id){
		$where['id'] = $meeting_id;
		$this->log_m->delete_meeting_log($where);
		$this->generate_json("");
	}


	public function get_submitted_dates(){
		$result = $this->log_m->get_ticket_list($this->session->user_data['id']);
		$this->generate_json($result);
	}


	// event
	public function get_event($event_id){
		$info = $this->log_m->get_event_log($event_id);
		$this->generate_json($info);
	}

	public function add_update_event(){
		$req = $this->input->post();

		if($req['ticket_id'] == "0"){
			// create ticket
			$info['ticket_id'] = $this->create_empty_ticket();
		} else {
			$info['ticket_id'] = $req['ticket_id'];
		}
		// re calculate ticket payperiod_total


		$info['event_name'] = $req['event_name'];

		$date = date_create($req['date']);
		$info['date'] = date_format($date, 'Y-m-d');

		$info['breakfast'] = $req['breakfast'];
		$info['lunch'] = $req['lunch'];
		$info['dinner'] = $req['dinner'];
		$info['other_amount'] = number_format($req['other_amount'], 2);


		// calc total pay.
		$setting = $this->basic_m->get_setting();
		$total_amont = $info['other_amount'];
		
		if($info['breakfast'] == "y")
			$total_amont += number_format($setting['breakfast'], 2);
		if($info['lunch'] == "y")
			$total_amont += number_format($setting['lunch'], 2);
		if($info['dinner'] == "y")
			$total_amont += number_format($setting['dinner'], 2);

		$info['totalpay'] = $total_amont;

		if(isset($req['id'])){
			$where['id'] = $req['id'];
			$info['updated_at'] = date('Y-m-d H:i:s');
			$this->log_m->update_event_log($info, $where);
		}else{
			$info['created_at'] = date('Y-m-d H:i:s');
			$this->log_m->add_event_log($info);
		}

		$this->generate_json("");
	}

	public function delete_event($event_id){
		$where['id'] = $event_id;
		$this->log_m->delete_event_log($where);
		$this->generate_json("");
	}

	// submit document
	public function update_document_as_corrected(){
		$req = $this->input->post();
		$where['id'] = $req['ticket_id'];
		$info['is_corrected'] = $req['is_corrected'];
		$this->log_m->update_ticket($info, $where);
		$this->generate_json(""); 
	}

	public function submit_document(){
		$req = $this->input->post();

		if($req['ticket_id']=="0"){
			$where['id'] = $this->create_empty_ticket();
		}else{
			$where['id'] = $req['ticket_id'];
		}

		$info['note'] = $req['note'];
		$info['payperiod_total'] = $req['payperiod_total'];
		$info['is_corrected'] = $req['is_corrected'];
		$info['initial'] = $req['initial'];
		// $info['created_date'] 
		$submit_date = date_create($req['submit_date']);
		$info['submit_date'] = date_format($submit_date, 'Y-m-d');
		$info['is_submited'] = 'y';

		$this->log_m->update_ticket($info, $where);

		$this->generate_json($where['id']);
	}

	private function create_empty_ticket(){
		$ticket_info['supervisor_id'] = $this->session->user_data['id'];
		$ticket_info['is_submited'] = 'n';
		$ticket_info['submit_date'] = date("Y-m-d");

		return $this->log_m->add_ticket($ticket_info);
	}


	public function email_send($ticket_id){
		$ticket_info = $this->log_m->get_ticket_where(array('ticket.id' => $ticket_id));
		$meeting_list = $this->log_m->get_meeting_logs(array('ticket_id' => $ticket_id));
		$event_list = $this->log_m->get_event_logs(array('ticket_id' => $ticket_id));
		$setting = $this->basic_m->get_setting();

		$html = '<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
	<style type="text/css">
		table {
			width: 100%;
		}
		table.bordered, table.bordered th, table.bordered td {
		  border: 1px solid grey;
		  padding: 5px 10px;
		}
		table {
			border-collapse: collapse;
		}

		table.dotted, table.dotted th, table.dotted td {
			border: 1px dotted grey;
			padding: 5px 10px;
		}

		.text-right {
			text-align: right;
		}
		.text-center {
			text-align: center;
		}

		.section {
			margin-bottom: 20px;
		}

		.bg-lightgray {
			background-color: #eee;
		}
	</style>
</head>
<body>
	<div class="section">
		<h1>Committee Meetings</h1>';

		$is_message = false;

		foreach($meeting_list as $item){
			if($item['hourspay_more'] > 0){
				$is_message = true;
				break;
			}
		}
		if($is_message){
			$html .= '<span style="color:red">Number in parenthesis () indicates payment reduced. $' . $setting['daily_limit'] . ' is daily cap.</span>';
		}


		$html .= '<table class="bordered">
			<thead class="bg-lightgray">
				<tr>
					<td class="text-center">Committee Meeting</td>
					<td class="text-center">Date</td>
					<td class="text-center">Hours</td>
					<td class="text-center">Miles</td>
					<td class="text-center">HoursPay</td>
					<td class="text-center">MileagePay</td>
					<td class="text-center">TotalPay</td>
				</tr>
			</thead>
			<tbody>';
		$meeting_total_pay = 0;

		$hourspay_total = 0;
		$mileagepay_total = 0;
		foreach($meeting_list as $item){
			$meeting_total_pay += $item['totalpay'];
			$hourspay_total += $item['hourspay'];
			$mileagepay_total += $item['mileagepay'];
			$html .= '<tr>';
			$html .= '<td>' . $item['committee'] . '</td>';
			$html .= '<td class="text-center">' . $item['date'] . '</td>';
			$html .= '<td class="text-right">' . $item['hours'] . '</td>';
			$html .= '<td class="text-right">' . $item['miles'] . '</td>';
			$html .= '<td class="text-right">' . $item['hourspay'];
			if($item['hourspay_more'] > 0){
				$html .= ' (' . $item['hourspay_more'] . ')';
			}
			$html .= '</td>';
			$html .= '<td class="text-right">' . $item['mileagepay'] . '</td>';
			$html .= '<td class="text-right">' . $item['totalpay'] . '</td>';
			$html .= '</tr>';
		}
		
		$html .= '</tbody>
			<tfoot class="bg-lightgray">
				<tr>
					<td colspan="4">Totals</td>
					<td class="text-right">';
		$html .= $hourspay_total;		
		$html .= '</td>
					<td class="text-right">'; 
		$html .= $mileagepay_total;
		$html .= '</td>
					<td class="text-right">';
		$html .= $meeting_total_pay;
		$html .= '</td>
				</tr>
			</tfoot>
		</table>
	</div>
	<div class="section">
		<h1>Meal Reimbursement</h1>
		<table class="bordered">
			<thead class="bg-lightgray">
				<tr>
					<td class="text-center">Event</td>
					<td class="text-center">Date</td>
					<td class="text-center">Breakfast</td>
					<td class="text-center">Lunch</td>
					<td class="text-center">Dinner</td>
					<td class="text-center">Other Amount</td>
					<td class="text-center">TotalPay</td>
				</tr>
			</thead>
			<tbody>';
		$event_total_pay = 0;
		foreach($event_list as $item){
			$event_total_pay += $item['totalpay'];
			$html .= '<tr>';
			$html .= '<td>' . $item['event_name'] . '</td>';
			$html .= '<td class="text-center">' . $item['date'] . '</td>';

			$html .= '<td class="text-center">';
			if($item['breakfast']=='y')
			 	$html .= 'YES';
			$html .= '</td>';
			
			$html .= '<td class="text-center">';
			if($item['lunch']=='y')
			 	$html .= 'YES';
			$html .= '</td>';

			$html .= '<td class="text-center">';
			if($item['dinner']=='y')
			 	$html .= 'YES';
			$html .= '</td>';

			$html .= '<td class="text-right">' . $item['other_amount'] . '</td>';
			$html .= '<td class="text-right">' . $item['totalpay'] . '</td>';
			$html .= '</tr>';
		}

		$html .= '</tbody>
			<tfoot class="bg-lightgray">
				<tr>
					<td colspan="6">Totals</td>
					<td class="text-right">';
		$html .= $event_total_pay;
		$html .= '</td>
				</tr>
			</tfoot>
		</table>
	</div>

	<hr>
	<div class="section">
		<table class="dotted">
			<tbody>
				<tr class="bg-lightgray">
					<td>Pay Period Total</td>
					<td>';

		$html .= $ticket_info['payperiod_total'];
		$html .= '</td>
				</tr>
				<tr>
					<td>Note</td>
					<td>';
		$html .= $ticket_info['note'];
		$html .= '</td>
				</tr>';
		if($ticket_info['is_corrected'] == 'y') {	
			$html .= '<tr>
					<td>This is a correction of a previously submitted form</td>
					<td>YES</td>
				</tr>';
		}
		$html .= '<tr>
					<td>Initials</td>
					<td>';
		$html .= $ticket_info['initial'];
		$html .= '</td>
				</tr>
				<tr>
					<td>Date</td>
					<td>';

		$html .= $ticket_info['submit_date'];
		$html .= '</td>
				</tr>
				<tr class="bg-lightgray">
					<td>Supervisor</td>
					<td>';

		$html .= $ticket_info['supervisor_name'] . ' (' . $ticket_info['email'] . ')';
		$html .= '</td>
				</tr>
			</tbody>
		</table>
	</div>

</body>
</html>';

		$setting = $this->basic_m->get_setting();
	    $emails = array();
		$emails[] = $ticket_info['email'];
		$emails[] = $setting['payrollemail'];
		
		$this->send_email($emails, $ticket_info['supervisor_name'], $html, $setting);
		
		$this->generate_json("");
	}

	

	private function send_email($to_email, $subject, $body, $setting){
		$mail = new PHPMailer;

		try {
		    //Server settings
		    $mail->isSMTP();
		   
		   // $mail->SMTPDebug = 4;
		    $mail->Host       = $setting['smtp_server'];  
		    $mail->SMTPAuth   = true;       
		    $mail->Username   = $setting['smtp_userid'];    
		    $mail->Password   = $setting['smtp_pass']; 
		    $mail->CharSet =  "utf-8";
		    $mail->SMTPSecure = 'tls';
		    $mail->Port       = 587; 

 
		    //Recipients
		    $mail->setFrom($setting['sending_email'], 'Expense Voucher');
		    if(is_array($to_email)){
		    	foreach($to_email as $item)
		    		$mail->addAddress($item); 
		    }
		    else
		     	$mail->addAddress($to_email); 
		    
		    $mail->isHTML(true);                                  
		    $mail->Subject = $subject;
		    $mail->Body    = $body;
		    $mail->send();
		    // return $email;
		} catch (Exception $e) {
			// return $mail->ErrorInfo;
		}
	}

	public function email_test(){
		$ticket_info = $this->log_m->get_ticket_where(array('ticket.id' => 1));
		$meeting_list = $this->log_m->get_meeting_logs(array('ticket_id' => 1));
		$event_list = $this->log_m->get_event_logs(array('ticket_id' => 1));

		$data['ticket_info'] = $ticket_info;
		$data['meeting_list'] = $meeting_list;
		$data['event_list'] = $event_list;
		$this->load->view('template/email', $data);
	}
}
