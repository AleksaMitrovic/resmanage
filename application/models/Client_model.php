<?php
	class Client_model extends CI_Model{

		public function __construct()
		{
			$this->load->database();
		}
		public function delete_client($pro_id)
		{
		}
		public function add_client($pro_id)
		{
			$data = array(
				'name' => $this->input->post('client-name'),
				'type' => $this->input->post('client-company'),
				'project_id' => $pro_id
			);
			return $this->db->insert('client',$data);
		}
	}