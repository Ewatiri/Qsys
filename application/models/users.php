<?php
	
	class Users extends CI_Model{

		function getUsers(){
			$query = $this->db->query('SELECT * FROM users') or die ('0');
			$rs = $query->result_array();
			return $rs;
		}

		function fetchLastuser(){
			$query = $this->db->query('SELECT * FROM users ORDER BY uid DESC LIMIT 1') or die ('-1');
			$rs = $query->row_array();
			return $rs['uid'];
		}
		
		function checker($uname){
			$sql = ("SELECT * FROM users WHERE uname = ?");
            $query = $this->db->query($sql,array($uname));
            if ($query->num_rows == 1){

            	return 1;
            }
            else 
            	return 0;
		}

		function addUser($data){
			$uname = $data['uname'];
			$chk = $this->checker($uname);

			if ($chk == 0){
				$this->db->insert('users',$data) or die ('0');
				return 1;
			}
			else if($chk == 1){
				return 2;
			}
			else{
				return 0;
			}


		}
		function loginUser($data){
 			$uname = $data['uname'];
 			$pass = $data['pass'];

 			$sql = ("SELECT * FROM users WHERE uname = ? AND pass = ?");
            $query = $this->db->query($sql,array($uname,$pass));

            if($query->num_rows == 1){
            	$rs = $query->row_array();
         		$this->load->library('session');

 		    	$this->session->set_userdata('name',$rs['uname']);
 				$this->session->set_userdata('default',$rs['default']);
 				$this->session->set_userdata('rid',$rs['rid']);

            	return 1;
            }
            else{
            	return 0;
            }
 	}
		

	}
?>