<?php
	
	class Clients extends CI_Model{

		function checker($sno){
			$sql = ("SELECT * FROM clients WHERE sno = ?");
            $query = $this->db->query($sql,array($sno));
            if ($query->num_rows == 1){

            	return 1;
            }
            else 
            	return 0;
		}

		function getClientId(){
			$query = $this->db->query('SELECT * FROM clients ORDER BY custid DESC LIMIT 1') or die ('-1');
			$rs = $query->row_array();
			return $rs['custid'];
		}


		function addClient($data){
			$sno = $data['sno'];
			$this->load->library('session');

			if ($this->checker($sno) == 0){
				$this->db->insert('clients',$data) or die ('0');
				$this->session->set_userdata('lastclient',$this->getClientId());
				return 1;	
			} 
			else{
				return 2;
			}
		}

		function getClient($regno){
			$sql = ("SELECT * FROM clients WHERE regno = ?");
        	$query = $this->db->query($sql,array($regno)) or die ('0');
        	if ($query->num_rows == 0){
        		return 2;
        	}
        	else{
        		return $query->result_array();	
        	}
        	
		}

	}
?>