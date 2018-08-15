<?php
	class User extends CI_Controller
	{
		public function regist()
		{
			$this->form_validation->set_rules('name','사용자이름','required|is_unique[sysuser.username]',array('required' => '%s을 입력하십시오.','is_unique' => '같은 이름을 가진 사용자가 존재합니다.'));
			$this->form_validation->set_rules('password','암호','required',array('required' => '%s를 입력하십시오.'));
			$this->form_validation->set_rules('password2','암호확인','matches[password]',array('matches[password]' => '%s을 다시 하십시오.'));
			$this->form_validation->set_rules('phone_number','전화번호','required',array('required' => '%s를 입력하십시오.'));
			if($this->form_validation->run() === FALSE)
			{
				$error = array('error'=>'');
				$this->load->view('templates/header');
				$this->load->view('user/register',$error);
				$this->load->view('templates/footer');
			}
			else
			{
				$enc_password = md5($this->input->post('password'));
				
				$config['upload_path'] = './assets/img/account';
				$config['allowed_types'] = 'jpg|jpeg|png|gif';
				$this->load->library('upload',$config);
				$this->upload->initialize($config);	
				if(!$this->upload->do_upload('picture')){
					$error = array('error'=>$this->upload->display_errors());
					$this->load->view('templates/header');
					$this->load->view('user/register',$error);
					$this->load->view('templates/footer');
				}
				else{
					$uploadData = $this->upload->data();
					$picture = $uploadData['file_name'];
					$user = $this->User_model->regist($enc_password,$picture);
					//ADD PHONE NUMBER OF REGISTED USER
					if($user){
						$this->load->model('Phone_model');
						$this->Phone_model->add_phone($user[0]->id);
						$this->load->model('User_model');
					}
					redirect('login');
				}
				
			}
		}
		public function login()
		{
			if($this->session->userdata('logged_in'))
				redirect();
			$data['title'] = 'Create PersonalInfo';

			$this->form_validation->set_rules('name','사용자이름','required',array('required' => '%s을 입력하십시오.'));
			$this->form_validation->set_rules('password','가입암호','required',array('required' => '%s를 입력하십시오.'));
			if($this->form_validation->run() === FALSE)
			{
				$this->load->view('templates/header');
				$this->load->view('user/login',$data);			
				$this->load->view('templates/footer');
			}
			else
			{
				$username = $this->input->post('name');
				$enc_password = md5($this->input->post('password'));
				$user = $this->User_model->login($username,$enc_password);
				if($user){
					$user_data = array(
						'user_id' => $user->id,
						'username' => $username,
						'status' => $user->status,
						'logged_in' => true
					);
					$this->session->set_userdata($user_data);
					redirect();
				}
				else
				{
					$this->session->set_flashdata('user_loggedin_fail','사용자정보를 다시 입력하십시오.');
					redirect('login');
				}
				
			}
		}
		public function logout()
		{
			$this->session->unset_userdata('logged_in');
			$this->session->unset_userdata('user_id');
			$this->session->unset_userdata('status');
			$this->session->unset_userdata('permission');
			redirect();
		}
		public function update($origin)
		{
			/*
			$this->form_validation->set_rules('password2','암호확인','matches[password]',array('matches' => '%s을 다시 하십시오.'));
			*/
			if(!$this->session->userdata('logged_in'))
				redirect('login');
			if($origin == 'from_menu_bar')
			{
				$error = array('error'=>'');
				$this->session->set_flashdata('page','dailyrep');
				$this->load->view('templates/header');
				$this->load->view('templates/menu');
				$this->load->view('user/update',$error);
				$this->load->view('templates/footer');
			}
			else
			{
				if($this->input->post('password') != $this->input->post('password2'))
				{
					$error = array('error' => '암호확인을 다시 하여주십시오.');
					$this->session->set_flashdata('page','dailyrep');
					$this->load->view('templates/header');
					$this->load->view('templates/menu');
					$this->load->view('user/update',$error);
					$this->load->view('templates/footer');
				}
				else
				{
					$picture = '';
					
					$config['upload_path'] = './assets/img/account';
					$config['allowed_types'] = 'jpg|jpeg|png|gif';
					$this->load->library('upload',$config);
					$this->upload->initialize($config);	
					if(!empty($_FILES['picture']['name']))
					{
						if($this->upload->do_upload('picture')){
							$uploadData = $this->upload->data();
							$picture = $uploadData['file_name'];
						}
					}
					$this->User_model->update($picture);
					$this->load->model('Phone_model');
					$this->Phone_model->add_phone($this->session->userdata('user_id'));
					$this->logout();
				}
			}
		}
	}