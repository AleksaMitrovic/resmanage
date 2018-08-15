<?php
	class User_model extends CI_Model{

		public function __construct()
		{
			$this->load->database();
		}
		public function update($picture)
		{
			$user = $this->get_user_by_id($this->input->post('user_id'));
			$username = $user['username'];
			$password = $user['password'];
			$userpicture = $user['picture'];
			if($this->input->post('name'))
				$username = $this->input->post('name');
			if($this->input->post('password'))
				$password = md5($this->input->post('password'));
			if($picture)
				$userpicture = $picture;
			$data = array(
				'username' => $username,
				'password' => $password,
				'picture' => $userpicture
			);
			$this->db->where('id', $this->input->post('user_id'));
			return $this->db->update('sysuser',$data);
		}
		public function regist($enc_password,$picture)
		{

			$data = array(
				'username' => $this->input->post('name'),
				'password' => $enc_password,
				'status' => STATUS_MEMBERSHIP,
				'picture' => $picture
			);
			$this->db->insert('sysuser',$data);

			// RETURN LAST RECORD

			$query= $this->db->query("SELECT * FROM sysuser ORDER BY id DESC LIMIT 1");
			$result = $query->result();
			return $result;
		}

		public function login($username, $enc_password)
		{	
			$this->db->where('username',$username);
			$this->db->where('password',$enc_password);
			$result = $this->db->get('sysuser');
			if(($result->num_rows() == 1) && ($result->row(0)->status % 4 != 0))
			{
				return $result->row(0);
			}
			else 
			{
				return null;
			}

		}
		public function username_exists($username)
		{
			$query = $this->db->get_where('sysuser',array('username'=>$username));
			if(empty($query->row_array())){
				return true;
			}
			else{
				return false;
			}
		}
		public function get_all_members()
		{

			$this->db->order_by('sysuser.id','DESC');

			$query = $this->db->get_where('sysuser');

			return $query->result_array();
		}
		public function get_user_by_id($user_id)
		{
			$this->db->order_by('sysuser.id','DESC');
			$query = $this->db->get_where('sysuser', array('id' => $user_id));
			if($query->num_rows() == 1)
				return $query->row_array();
			else
				return false;
		}
	}