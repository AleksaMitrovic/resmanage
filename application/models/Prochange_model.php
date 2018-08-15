<?php
	class Prochange_model extends CI_Model{

		public function __construct()
		{
			$this->load->database();
		}
		public function get_pro_change_log_by_id($pro_id)
		{
			$query = $this->db->get_where('project_change_log',array('project_id' => $pro_id));
			if($query->num_rows() == 1)
				return $query->row_array();
			else
				return false;
		}
		public function add_change_log()
		{
			$regist_date = null;
			$hour_week = 0;
			if($this->input->post('pro_end_date'))
				$regist_date = date('Y-m-d H:i:s', strtotime($this->input->post('pro_end_date')));
			if($this->input->post('project-type') == HOURLY_PRICE)
				$hour_week = $this->input->post('hour_week');
			$data = array(
				'price' => $this->input->post('contract_price'),
				'description' => $this->input->post('project-description'),
				'title' => $this->input->post('project-title'),
				'end_at' => $regist_date,
				'hour_week' => $hour_week,
				'project_type' => $this->input->post('project-type'),
				'project_id' => $this->input->post('id')
			);
			if(!$this->get_pro_change_log_by_id($this->input->post('id')))
				return $this->db->insert('project_change_log',$data);
			else
			{
				$this->db->where('project_id', $this->input->post('id'));
				return $this->db->update('project_change_log',$data);
			}
		}
		public function delete_change_log()
		{
			$this->db->where('project_id',$this->input->post('id'));
			return $this->db->delete('project_change_log');
		}
	}