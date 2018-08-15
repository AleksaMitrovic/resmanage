<?php
	class Dailyrep extends CI_Controller
	{
		public function index($offset = 0)
		{
			if(!$this->session->userdata('logged_in'))
				redirect('login');

			//Pagination Config Settings

			$config['base_url'] = base_url().'dailyrep/index/';
			$config['total_rows'] = $this->db->count_all('dailyreport');
			$config['per_page'] = 10;
			$config['uri_segment'] = 3;
			$config['attributes'] = array('class' => 'pagination-link');
			$this->pagination->initialize($config);

			//Page Render Info Settings

			$data['title'] = '일보열람';

			$repdatas = $this->Dailyrep_model->get_repinfo_by_user($this->session->userdata('user_id'),$config['per_page'], $offset);
			$data['repinfos'] = array();
			foreach($repdatas as $repdata)
			{
				$this->load->model('Prolog_model');
				$repdata['prologs'] = array();
				$logtime = DateTime::createFromFormat('Y-m-d H:i:s',$repdata['created_at']);
				$prologs = $this->Prolog_model->get_loginfo_by_user_and_time($repdata['user_id'],$logtime->format('Y-m-d 00:00:00'));
				foreach($prologs as $prolog)
				{
					$this->load->model('Project_model');
					$prolog['project'] = $this->Project_model->get_project_by_id($prolog['project_id']);
					array_push($repdata['prologs'], $prolog);
				}
				
				array_push($data['repinfos'],$repdata);
			}

			$data['rep_exists'] = TRUE;

			if(sizeof($data['repinfos']) == 0){
				$data['rep_exists'] = FALSE;
			}

			$this->session->set_flashdata('page','dailyrep');

			$this->load->view('templates/header');
			$this->load->view('templates/menu');
			$this->load->view('dailyrep/index', $data);
			$this->load->view('templates/footer');
		}
		public function entire($report_date)
		{
			$this->load->model('User_model');
			$org_members = $this->User_model->get_all_members();
			$today = DateTime::createFromFormat('Y-m-d',$report_date);
			/*
			$date = $this->input->post();
			if($date){
				//$today = DateTime::createFromFormat('Y-m-d H:i:s',$data['report_day']);
				$today = new DateTime('2011-01-01T15:03:01.012345Z');
			}
			*/
			$data['today_time'] = $today->format('m/d/Y');
			$data['repinfos'] = array();
			foreach($org_members as $member)
			{
				$this->load->model('Dailyrep_model');

				$today_report =  $this->Dailyrep_model->get_repinfo_by_user_and_time($member['id'],$today->format('Y-m-d 00:00:00'));
				if($today_report){
					$report['username'] = $member['username'];
					$report['user_image'] = $member['picture'];
					$report['businessrep'] = $today_report['businessrep'];
					$report['suggestion'] = $today_report['suggestion'];
					$this->load->model('Prolog_model');
					$report['prologs'] = array();
					$prologs = $this->Prolog_model->get_loginfo_by_user_and_time($member['id'],$today->format('Y-m-d 00:00:00'));
					foreach($prologs as $prolog)
					{
						$this->load->model('Project_model');
						$prolog['project'] = $this->Project_model->get_project_by_id($prolog['project_id']);
						array_push($report['prologs'], $prolog);
					}
					array_push($data['repinfos'], $report);
				}
			}
			$this->session->set_flashdata('page','dailyrep');
			$this->load->view('templates/header');
			$this->load->view('templates/menu');
			$this->load->view('dailyrep/entire_view',$data);
			$this->load->view('templates/footer');
		}
		public function create()
		{
			$data = array('success' => false,'messages' => array());
			if(!$this->session->userdata('logged_in'))
				redirect('login');
			$this->form_validation->set_rules('businessrep','사업내용','required',array('required' => '%s을 입력하십시오.'));
			$this->form_validation->set_rules('suggestion','제기할 의견','required',array('required' => '%s을 입력하십시오.'));
			$this->load->model('Project_model');
			$progress_projects = $this->Project_model->get_project_progress($this->session->userdata('user_id'));
			if(sizeof($progress_projects) > 0)
			{
				foreach($progress_projects as $project){
						$this->form_validation->set_rules("rate_".$project['id'],'asdf','numeric');
						$this->form_validation->set_message('numeric','진척률(작업시간)은 수값이여야 합니다.');	
				}
			}
			$this->form_validation->set_error_delimiters('<p class="c-font-15 text-danger">','</p>');
			if($this->form_validation->run() === FALSE)
			{
				$this->session->set_flashdata('create_report_valid',true);
				foreach($_POST as $key => $value)
				{
					$data['messages'][$key] = form_error($key);
				}
			}
			else
			{

				$this->session->set_flashdata('create_report_valid',false);
				$report_date = $this->input->post('report_date');
				$current_date = new DateTime();
				if(!$report_date)
					$report_date = $current_date->format('Y-m-d 00:00:00');
				$in_date = DateTime::createFromFormat('Y-m-d 00:00:00',$report_date);
				
				if($in_date > $current_date)
				{
					$data['messages']['report-date-picker'] = "<p class='c-font-15 text-danger'>일보를 미리 작성할수없습니다.</p>";
					echo json_encode($data);
					return;
				}
				
				$this->load->model('Dailyrep_model');

				$report = $this->Dailyrep_model->get_repinfo_by_user_and_time($this->session->userdata('user_id'), $report_date);
				
				if($report){
					/*
					$data['messages']['report-date-picker'] = "<p class='c-font-15 text-danger'>".$report_date->format('m월d일')."일보가 이미 작성되여있습니다.</p>";
					*/
					$data['messages']['report-date-picker'] = "<p class='c-font-15 text-danger'>일보가 이미 작성되여있습니다.</p>";
					echo json_encode($data);
					return;
				}
				
				$this->Dailyrep_model->create_repinfo($report_date);
				
				$this->load->model('Prolog_model');
				foreach($progress_projects as $project)
				{
					$this->Prolog_model->add_log($project,$report_date);
				}

				$this->load->model('Project_model');
				foreach($progress_projects as $project)
				{	
					$diff = 0;
					$this->Project_model->update_project_rate($project,$this->input->post("rate_".$project['id']),$diff);
				}


				//redirect();
				$data['success'] = true;
			}
			echo json_encode($data);
		}
		public function delete($rep_id)
		{
			if(!$this->session->userdata('logged_in'))
				redirect('login');

			$repinfo = $this->Dailyrep_model->get_repinfo_by_id($rep_id);

			$this->load->model('Prolog_model');
			$logtime = DateTime::createFromFormat('Y-m-d H:i:s',$repinfo['created_at']);
			$prologs = $this->Prolog_model->get_loginfo_by_user_and_time($repinfo['user_id'],$logtime->format('Y-m-d 00:00:00'));
			
			foreach($prologs as $prolog)
			{
				$this->load->model('Project_model');
				$project = $this->Project_model->get_project_by_id($prolog['project_id']);
				$this->Project_model->update_project_rate($project['id'],$prolog['prev_rate']);
				$this->load->model('Prolog_model');
				$this->Prolog_model->delete_log($prolog['id']);
			}
			$this->Dailyrep_model->delete_repinfo($rep_id);
			redirect('dailyrep');
		}
		public function update()
		{
			$this->Dailyrep_model->update_repinfo();
			$repinfo = $this->Dailyrep_model->get_repinfo_by_id($this->input->post('id'));

			$this->load->model('Prolog_model');
			$logtime = DateTime::createFromFormat('Y-m-d H:i:s',$repinfo['created_at']);
			$prologs = $this->Prolog_model->get_loginfo_by_user_and_time($repinfo['user_id'],$logtime->format('Y-m-d 00:00:00'));
			
			foreach($prologs as $prolog)
			{
				$this->load->model('Project_model');
				$project = $this->Project_model->get_project_by_id($prolog['project_id']);
				if($project)
				{
					$value = $this->input->post("rate_".$project['id']);
					$diff = 0;
					if($project['project_type'] == HOURLY_PRICE)
						$diff = $prolog['pro_rate_change'] - $prolog['prev_rate'];
					$this->Project_model->update_project_rate($project,$value,$diff);
				}
				$this->load->model('Prolog_model');
				$this->Prolog_model->update_log($project['id']);
			}
			redirect('dailyrep');
		}
	}