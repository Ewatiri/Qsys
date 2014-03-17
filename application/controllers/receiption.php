<?php
	
	class Receiption extends CI_Controller{
		
		function addNewClient(){
			$this->load->model('clients');

			$data['regno'] = htmlspecialchars($this->input->get('regno'));
			$data['fname'] = htmlspecialchars($this->input->get('fname'));
			$data['email'] = htmlspecialchars($this->input->get('email'));
			$data['tel'] = htmlspecialchars($this->input->get('tel'));
			$data['sno'] = htmlspecialchars($this->input->get('sno'));

			echo $this->clients->addClient($data);
		}

		function setlastClient(){
			$this->session->set_userdata('lastclient',$this->input->get('clientid'));
		}

		function addtQueue2(){
			$this->load->model('cqueues');
			$this->load->library('session');

			$data['custid'] = $this->session->userdata('lastclient');
			$data['diagnosis'] = htmlspecialchars($this->input->get('diag2'))."-".$this->session->userdata('name');
			$data['queue'] = $this->input->get('queue2');
			$data['notes'] = '';
			$data['status'] = '0';
			//$data['jtime']= time();
			$data['ltime'] = '';

			echo $this->cqueues->addtoQueue($data);	
		}

		function addtQueue(){
			$this->load->model('cqueues');
			$this->load->library('session');

			$data['custid'] = $this->session->userdata('lastclient');
			$data['diagnosis'] = htmlspecialchars($this->input->get('diag')).$this->session->userdata('name');
			$data['queue'] = $this->input->get('queue1');
			$data['notes'] = '';
			$data['status'] = '0';
			//$data['jtime']= time();
			$data['ltime'] = '';

			echo $this->cqueues->addtoQueue($data);	
		}

		function searchClient(){
			$regno = htmlspecialchars($this->input->post('sregno'));
			$this->load->model('clients');

			echo json_encode($this->clients->getClient($regno));
		}
	}
?>