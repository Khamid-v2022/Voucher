<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Basic_m extends CI_Model
{
	private $committees = 'committees';
	private $hourspay = 'hourspay';
	private $setting = 'settings';
	private $supervisors = 'supervisor';

	public function get_setting(){
		return $this->db->get($this->setting)->row_array();
	}

	public function update_setting($info){
		$this->db->update($this->setting, $info);
	}

	// committees
	public function get_committees(){
		$this->db->order_by('committee');
		return $this->db->get($this->committees)->result_array();
	}

	public function get_committee($where){
		$this->db->where($where);
		return $this->db->get($this->committees)->row_array();
	}

	public function add_committee($info){
		$this->db->insert($this->committees, $info);
		return $this->db->insert_id();
	}

	public function update_committee($info, $where){
		$this->db->where($where);
		$this->db->update($this->committees, $info);
	}

	public function delete_committee($where){
		$this->db->where($where);
		$this->db->delete($this->committees);
	}


	// hourspay
	public function get_hourspays(){
		return $this->db->get($this->hourspay)->result_array();
	}

	public function get_hourspay($where){
		$this->db->where($where);
		return $this->db->get($this->hourspay)->row_array();
	}

	public function update_hourspay($info, $where){
		$this->db->where($where);
		$this->db->update($this->hourspay, $info);
	}


	// supervisor
	public function get_supervisors(){
		return $this->db->get($this->supervisors)->result_array();
	}

	public function get_supervisor($where){
		$this->db->where($where);
		return $this->db->get($this->supervisors)->row_array();
	}

	public function add_supervisor($info){
		$this->db->insert($this->supervisors, $info);
		return $this->db->insert_id();
	}

	public function update_supervisor($info, $where){
		$this->db->where($where);
		$this->db->update($this->supervisors, $info);
	}

	public function delete_supervisor($where){
		$this->db->where($where);
		$this->db->delete($this->supervisors);
	}
}

?>