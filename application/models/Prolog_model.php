<?php
	class Prolog_model extends CI_Model{

		public function __construct()
		{
			$this->load->database();
		}
		public function get_loginfo_by_user_and_time($user_id, $date)
		{
			$this->db->order_by('daily_pro_log.id','DESC');
			$query = $this->db->get_where('daily_pro_log', array('user_id' => $user_id, 'change_at' => $date));
			return $query->result_array();
		}
		public function get_loginfo_by_id($log_id)
		{
			$query = $this->db->get_where('daily_pro_log', array('id' => $log_id));
			if($query->num_rows() == 1)
				return $query->row_array();
			else
				return false;
		}
		public function delete_log($log_id)
		{
			$result = $this->get_loginfo_by_id($log_id);
			if($this->session->userdata('user_id') != $result['user_id'])
			{
				return false;
			}
			$this->db->where('id',$log_id);
			$this->db->delete('daily_pro_log');
			return true;
		}
		public function add_log($project,$report_date)
		{
			if($this->input->post("rate_".$project['id']))
			{
				$rate_change = $this->input->post("rate_".$project['id']);
				if($project['project_type'] == HOURLY_PRICE)
					$rate_change += $project['progress_rate'];
			}
			else
				$rate_change = $project['progress_rate'];
			$data = array(
				'user_id' => $this->session->userdata('user_id'),
				'project_id' => $project['id'],
				'prev_rate' => $project['progress_rate'],
				'pro_rate_change' => $rate_change,
				'change_at' => $report_date,
				'bus_at_pro' => $this->input->post("projectrep_".$project['id'])
			);
			return $this->db->insert('daily_pro_log',$data);		
		}
		public function update_log($project_id)
		{
			$data = array(
				'pro_rate_change' => $this->input->post('rate_'.$project_id),
				'bus_at_pro' => $this->input->post('projectrep_'.$project_id)
			);
			$this->db->where('project_id', $project_id);
			$this->db->update('daily_pro_log',$data);
			return true;
		}
	}