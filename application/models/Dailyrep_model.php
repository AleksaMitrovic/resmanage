<?php
	class Dailyrep_model extends CI_Model{

		public function __construct()
		{
			$this->load->database();
		}
		public function get_repinfo_by_user($user_id, $limit = FALSE, $offset = FALSE)
		{
			$this->db->order_by('dailyreport.id','DESC');

			$query = $this->db->get_where('dailyreport', array('user_id' => $user_id),$limit,$offset);

			return $query->result_array();
		}
		public function get_repinfo_by_user_and_time($user_id, $date)
		{
			$this->db->order_by('dailyreport.id','DESC');
			$query = $this->db->get_where('dailyreport', array('user_id' => $user_id, 'created_at' => $date));
			if($query->num_rows() == 1)
				return $query->row_array();
			else
				return false;
		}
		public function get_repinfo_by_id($rep_id)
		{
			$query = $this->db->get_where('dailyreport', array('id' => $rep_id));
			if($query->num_rows() == 1)
				return $query->row_array();
			else
				return false;
		}
		public function create_repinfo($report_date)
		{
			$data = array(
				'businessrep' => $this->input->post('businessrep'),
				'suggestion' => $this->input->post('suggestion'),
				'created_at' => $report_date,
				'user_id' => $this->input->post('user_id')
			);
			return $this->db->insert('dailyreport',$data);
		}
		public function delete_repinfo($rep_id)
		{
			$result = $this->get_repinfo_by_id($rep_id);
			if($this->session->userdata('user_id') != $result['user_id'])
			{
				return false;
			}
			$this->db->where('id',$rep_id);
			$this->db->delete('dailyreport');
			return true;
		}
		public function update_repinfo()
		{
			$data = array(
				'businessrep' => $this->input->post('businessrep'),
				'suggestion' => $this->input->post('suggestion'),
				'user_id' => $this->session->userdata['user_id']
			);
			$this->db->where('id', $this->input->post('id'));
			$this->db->update('dailyreport',$data);
			return true;
		}
	}