<?php
	class Project extends CI_Controller
	{
		public function index($offset = 0)
		{
			if(!$this->session->userdata('logged_in'))
				redirect('login');

			$data['taxed_projects'] = $this->Project_model->get_project_taxed($this->session->userdata('user_id'));
			$data['progress_projects'] = $this->Project_model->get_project_progress($this->session->userdata('user_id'));

			$data['rep_exists'] = TRUE;
			
			/*
			if(sizeof($data['progress_projects']) == 0){
				$data['rep_exists'] = FALSE;
			}
			*/

			$this->session->set_flashdata('page','project');

			$this->load->view('templates/header');
			$this->load->view('templates/menu');
			$this->load->view('project/index', $data);
			$this->load->view('templates/footer');
		}

		public function create()
		{
			if(!$this->session->userdata('logged_in'))
				redirect('login');
			$data = array('success' => false,'messages' => array());
			$this->form_validation->set_rules('project-title','프로젝트명','required',array('required' => '%s을 입력하십시오.'));
			$this->form_validation->set_rules('project-description','프로젝트서술','required',array('required' => '%s을 입력하십시오.'));
			$this->form_validation->set_rules('client-name','대방이름','required',array('required' => '%s을 입력하십시오.'));
			if($this->input->post('project-type') == FIXED_PRICE){
				$this->form_validation->set_rules('fixed-price','고정액수','required|numeric',array('required' =>'%s을 입력하십시오.', 'numeric' => '%s는 수가 되여야 합니다.'));
			}
			else if($this->input->post('project-type') == HOURLY_PRICE)
			{
				$this->form_validation->set_rules('hourly-price','시간당액수','required|numeric',array('required' =>'%s을 입력하십시오.', 'numeric' => '%s는 수가 되여야 합니다.'));
				$this->form_validation->set_rules('hours-per-week','주간당액수','required|numeric',array('required' =>'%s을 입력하십시오.', 'numeric' => '%s는 수가 되여야 합니다.'));
			}
	//		$this->form_validation->set_rules('project_price','Price','required');
			$this->form_validation->set_error_delimiters('<p class="c-font-15 text-danger">','</p>');
			if($this->form_validation->run() === FALSE)
			{
				foreach($_POST as $key => $value)
				{
					$data['messages'][$key] = form_error($key);
				}
			}
			else
			{
				$project = $this->Project_model->create_project();
				
				$this->load->model('Client_model');
				$this->Client_model->add_client($project[0]->id);
				//redirect('project');
				$data['success'] = true;
			}
			echo json_encode($data);
		}
		public function delete($pro_id)
		{
			if(!$this->session->userdata('logged_in'))
				redirect('login');
			$this->Project_model->delete_project($pro_id);
			redirect('dailyrep');
		}
		public function update()
		{
			$this->Project_model->update_project();
			$this->load->model('Prochange_model');
			$this->Prochange_model->delete_change_log();
			redirect();
		}
		public function regist_pro_change()
		{
			$this->load->model('Prochange_model');
			$this->Prochange_model->add_change_log();
			redirect('project');
		}
		public function moveTopending()
		{
			if($this->input->post('status-type'))
				$this->Project_model->moveTopending($this->input->post('status-type'));
			redirect('project');
		}
		public function moveTotaxed()
		{
			$taxed_price = $this->input->post('taxed-price');
			$taxed_date = $this->input->post('taxed_date');
			if(!$taxed_date)
			{
				$current = new DateTime();
				$taxed_date = $current->format('Y-m-d');
			}
			$project = $this->Project_model->get_project_by_id($this->input->post('id'));	
			$this->Project_model->moveTotaxed($taxed_price,$project,$taxed_date);
			$this->Protaxed_model->add_taxed_log($taxed_price, $project,$taxed_date);
			redirect();
		}
		public function entire()
		{
			$data['taxed_projects'] = $this->Project_model->get_project_taxed();
			$data['project_owner_images'] = array();
			foreach($data['taxed_projects'] as $project){
				$this->load->model('User_model');
				$user  = $this->User_model->get_user_by_id($project['project_owner']);
				$data['project_owner_images'] += [$project['id'] => $user['picture']];
			}
			$this->session->set_flashdata('page','dailyrep');
			$this->load->view('templates/header');
			$this->load->view('templates/menu');
			$this->load->view('project/entire_view', $data);
			$this->load->view('templates/footer');
		}
	}