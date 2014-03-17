<?php
	
	class Home extends CI_Controller{

		function index(){
			$this->load->view('home');
		}

		function login(){
			$this->load->model('sys');
			$this->load->model('users');
			$this->load->library('session');

			$sys = $this->sys->getStatus();
			if ($sys == 1){
				$data['uname'] = htmlspecialchars(strtolower($this->input->post('uname')));
				$data['pass'] = md5(htmlspecialchars($this->input->post('pass')));
				$stat =  $this->users->loginUser($data);
				$rid = $this->session->userdata('rid');
				if ($stat == 1 && $rid == 2){
					echo "12";		
				}
				else if ($stat == 1 && $rid == 0){
					echo "10";			
				}
				else if($stat == 0){
					echo "3";
				}
			}
			else{
				echo "2";
			}

		}
		function adminDash(){
			$this->load->view('admin');		
		}
		function receiption(){
			$this->load->view('receiption');		
		}

	}

?>