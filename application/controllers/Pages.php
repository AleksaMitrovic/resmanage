<?php
	class Pages extends CI_Controller
	{
		public function view($result_owner = FALSE)
		{

			$this->session->set_flashdata('page','home');
			$this->session->set_flashdata('boss_page',false);
			
			$data['last_report'] = null;
			$data['project_logs'] = array();
			if($this->session->userdata('logged_in')){

				$user_id = $this->session->userdata('user_id');
				$this->load->model('User_model');
				$current_user = $this->User_model->get_user_by_id($user_id);

				
				if($current_user['status'] == STATUS_BOSS){

					$this->session->set_flashdata('boss_page',true);
					$this->load->model('Project_model');
					$data['progress_projects'] = $this->Project_model->get_project_progress();
					$data['pending_projects'] = $this->Project_model->get_project_pending();
					$this->load->model('Protaxed_model');
					$data['taxed_logs'] = $this->Protaxed_model->get_taxed_log($result_owner);

					$data['result_owner_image'] = '';
					if($result_owner){
						$this->load->model('User_model');
						$owner = $this->User_model->get_user_by_id($result_owner);
						$data['result_owner_image'] = $owner['picture'];
					}
					
					$data['project_owner_images'] = array();
					$data['is_changed'] = array();
					foreach($data['progress_projects'] as $project)
					{
						$this->load->model('User_model');
						$user  = $this->User_model->get_user_by_id($project['project_owner']);
						$data['project_owner_images'] += [$project['id'] => $user['picture']];
						$this->load->model('Prochange_model');
						$prochange = $this->Prochange_model->get_pro_change_log_by_id($project['id']);
						$data['is_changed'][$project['id']] = $prochange;
					}
					foreach($data['pending_projects'] as $project)
					{
						$this->load->model('User_model');
						$user  = $this->User_model->get_user_by_id($project['project_owner']);
						$data['project_owner_images'] += [$project['id'] => $user['picture']];
					}
					$data['users'] = $this->User_model->get_all_members();
					
				}
				else
				{
					$this->load->model('Project_model');
					$data['progress_projects'] = $this->Project_model->get_project_progress($user_id);
					$this->load->model('Protaxed_model');
					$data['taxed_logs'] = $this->Protaxed_model->get_taxed_log($user_id);
				}

				$this->load->model('Dailyrep_model');
				$reports = $this->Dailyrep_model->get_repinfo_by_user($user_id);
				if(sizeof($reports) > 0){
					$data['last_report'] = reset($reports);	
					$logtime = DateTime::createFromFormat('Y-m-d H:i:s',$data['last_report']['created_at']);
					$data['project_logs'] = array();
					$prologs = $this->Prolog_model->get_loginfo_by_user_and_time($user_id,$logtime->format('Y-m-d 00:00:00'));
					foreach($prologs as $prolog)
					{
						$this->load->model('Project_model');
						$prolog['project'] = $this->Project_model->get_project_by_id($prolog['project_id']);
						array_push($data['project_logs'], $prolog);
					}
				}	
			}
			else
			{
				redirect('login');
			}

			$data['rep_refresh'] = true;
			
			if($this->session->flashdata('create_report_valid'))
				$data['rep_refresh'] = false;
			$this->load->view('templates/header');
			$this->load->view('templates/menu');
			$this->load->view('pages/home', $data);
			$this->load->view('templates/footer');
		}
	}