<?php
	
	class Admin extends CI_Controller{

		function addQueue(){
			$data['qname'] = htmlspecialchars($this->input->get('qname'));

			$this->load->model('queues');
			echo $this->queues->addQ($data);

		}
		function fetchQs(){
			$this->load->model('queues');

			echo json_encode( $this->queues->getQs());
		}
		function deleteQs(){
			$qname = $this->input->get('qname');
			$this->load->model('queues');
			echo $this->queues->deleteQ($qname);
		}

		function fetchUs(){
			$this->load->model('users');
			
			echo json_encode( $this->queues->getUsers());
		}


		function newUser(){
			$this->load->model('users');
			$this->load->model('qmanagers');

			$job = $this->input->post('rid');

			$rid;
			if ($job == 'Administrator'){
				$rid = 2;
			}
			else if ($job == 'Server'){
				$rid = 1;	
			}
			else{
				$rid = 0;
			}
			$data['rid'] = $rid;
			$data['uname'] = htmlspecialchars(strtolower($this->input->post('uname')));
			$data['pass'] = md5(htmlspecialchars($this->input->post('dpass')));
			$data['default'] = '1';

			if ($rid != 1){
				echo $this->users->addUser($data);

			}
			else if ($rid == 1){
				$status = $this->users->addUser($data);	
				if ($status == '1'){
					$uid = $this->users->fetchLastuser();
					if ($uid != -1){
						$data1['uid'] = $uid;
						$data1['qid'] = $this->input->post('queuename');
						echo $this->qmanagers->addMgr($data1);
					}
					else{
						echo "0";
					}
				}
				else {
					echo $status;
				}
			}

		}
	}
?>