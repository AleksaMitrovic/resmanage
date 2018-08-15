<?php
	class Protaxed_model extends CI_Model{

		public function __construct()
		{
			$this->load->database();
		}
		public function get_taxed_log($user_id = FALSE)
		{
			if($user_id)
				$this->db->where('user_id',$user_id);
			$query = $this->db->get_where('project_taxed_log');
			return $query->result_array();
		}
		public function add_taxed_log($taxed_price, $project,$taxed_date)
		{
			$data = array(
				'taxed_price' => $taxed_price,
				'taxed_date' => $taxed_date,
				'project_id' => $project['id'],
				'user_id' => $project['project_owner']
			);
			$this->db->insert('project_taxed_log',$data);
		}
		public function delete_taxed_log($id)
		{
			$this->db->where('project_taxed_log.id',$id);
			return $this->db->delete('project_taxed_log');
		}
	}