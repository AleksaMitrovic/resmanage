<?php
	class Phone_model extends CI_Model{

		public function __construct()
		{
			$this->load->database();
		}
		public function delete_phone($phone_id)
		{
		}
		public function add_phone($user_id)
		{
			$x = 1;
			while($this->input->post('phone_number_'.$x)){
				$data = array(
					'phone_number' => $this->input->post('phone_number_'.$x),
					'user_id' => $user_id
				);
				$this->db->insert('phone',$data);
				$x++;
			}
			return true;
		}
	}