<?php
	class Project_model extends CI_Model{

		public function __construct()
		{
			$this->load->database();
		}
		public function get_project_taxed($user_id = FALSE)
		{

			if($user_id)
				$this->db->where('project_owner',$user_id);
			$this->db->order_by('project.id','DESC');
			$query = $this->db->get_where('project',array('taxed_status !=' => PROJECT_NONE_TAXED));
			return $query->result_array();
		}
		public function get_project_progress($user_id = FALSE)
		{
			$this->db->order_by('project.id','DESC');

			if($user_id)
				$this->db->where('project_owner',$user_id);
			$query = $this->db->get_where('project', array('is_progress' => true));
			return $query->result_array();
		}
		public function get_project_pending($user_id = FALSE)
		{
			$this->db->order_by('project.id','DESC');
			if($user_id)
				$this->db->where('project_owner',$user_id);
			$query = $this->db->get_where('project', array('pending_status !=' => PROJECT_NONE_PENDING));

			return $query->result_array();
		}
		public function get_project_by_id($pro_id)
		{
			$query = $this->db->get_where('project', array('id' => $pro_id));
			if($query->num_rows() == 1)
				return $query->row_array();
			else
				return false;
		}
		public function create_project()
		{
			$st_time = date('Y-m-d H:i:s',strtotime($this->input->post('start_at')));
			$end_time = date('Y-m-d H:i:s', strtotime($this->input->post('end_at')));	
			$hours_per_week = 0;
			if($this->input->post('project-type') == HOURLY_PRICE){
				$hours_per_week = $this->input->post('hours-per-week');
				$current_time = new DateTime();
				$st_time = $current_time->format('Y-m-d H:i:s');
				$end_time = null;
			}
			$data = array(
				'project_title' => $this->input->post('project-title'),
				'project_description' => $this->input->post('project-description'),
				'project_type' => $this->input->post('project-type'),
				'contract_price' => $this->input->post('fixed-price') + $this->input->post('hourly-price'),
				'is_progress' => true,
				'start_at' => $st_time,
				'end_at' => $end_time,
				'taxed_price '=> 0,
				'taxed_date' => null,
				'progress_rate' => 0,
				'project_owner' => $this->input->post('user_id'),
				'taxed_status' => PROJECT_NONE_TAXED,
				'pending_status' => PROJECT_NONE_PENDING,
				'hour_week' => $hours_per_week	
			);
			$this->db->insert('project',$data);
			$query= $this->db->query("SELECT * FROM project ORDER BY id DESC LIMIT 1");
			$result = $query->result();
			return $result;
		}
		public function delete_project($pro_id)
		{
			$result = $this->get_project_by_id($pro_id);
			if($this->session->userdata('user_id') != $result['user_id'])
			{
				return false;
			}
			$this->db->where('id',$pro_id);
			$this->db->delete('project');
			return true;
		}
		public function update_project_rate($project,$value,$diff)
		{
			if($value)
			{
				$rate = $value;
				if($project['project_type'] == HOURLY_PRICE)
					$rate = $project['progress_rate'] - $diff + $rate;
				$data = array(
					'progress_rate' => $rate
				);
				$this->db->where('id', $project['id']);
				if(!$this->db->update('project',$data))
					return false;
			}
		 	return true;
		}
		public function update_project()
		{
			$enddate = null;
			$hour_week = 0;
			if($this->input->post('pro_end_date'))
			{
				$enddate = DateTime::createFromFormat('Y년m월d일',$this->input->post('pro_end_date'));
				
			}
			else if($this->input->post('hour_week'))
				$hour_week = $this->input->post('hour_week');
			if($this->input->post('pro_end_date') || $this->input->post('hour_week'))
			{
				$data = array(
					'contract_price' => $this->input->post('contract-price'),
					'project_description' => $this->input->post('project-description'),
					'project_title' => $this->input->post('project-title'),
					'end_at' => $enddate ? date('Y-m-d H:i:s',strtotime($enddate->format('Y-m-d H:i:s'))) : null,
					'hour_week' => $hour_week
				);
				$this->db->where('id', $this->input->post('id'));
				return $this->db->update('project',$data);
			}
			else
				return false;
		}
		public function moveTopending($status)
		{
			//if(!$this->input->post('status-type'))
			//	return false;
			$data = array(
				'is_progress' => ($status != PROJECT_PARTLY_PENDING)?false:true,
				'pending_status' => $status,
				'progress_rate' => 0
			);
			$this->db->where('id', $this->input->post('id'));
			return $this->db->update('project',$data);
		}
		public function moveTotaxed($taxed_price,$project,$taxed_date)
		{
			$pending_status = null;
			$taxed_status = null;
			$is_progress = false;
			if($project['pending_status'] == PROJECT_FULLY_PENDING)
			{
				if($project['taxed_status'] != PROJECT_NONE_TAXED)
					$taxed_price += $project['taxed_price'];
				$taxed_status = PROJECT_FULLY_TAXED;
				$pending_status = PROJECT_NONE_PENDING;
			}
			elseif($project['pending_status'] == PROJECT_PARTLY_PENDING)
			{
				$taxed_status = PROJECT_PARTLY_TAXED;
				$pending_status = PROJECT_NONE_PENDING;
				$is_progress = true;
				$taxed_price += $project['taxed_price'];
			}
			elseif($project['pending_status'] == PROJECT_INTERRUPTED)
			{
				$taxed_status = PROJECT_INTERRUPT_FINISH;
				$pending_status = PROJECT_NONE_PENDING;
				$taxed_price += $project['taxed_price'];
			}
			$data = array(
				'taxed_price' => $taxed_price,
 				'taxed_date' => $taxed_date,
				'pending_status' => $pending_status,
				'taxed_status' => $taxed_status,	
				'is_progress' => $is_progress
			);
			$this->db->where('id',$project['id']);
			return $this->db->update('project',$data);
		}
	}