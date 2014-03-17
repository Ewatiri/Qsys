<?php
	
	class Queues extends CI_Model{

		function chkAvailability($qname){
	 		$sql = ("SELECT * FROM queues WHERE qname = ?");
            $query = $this->db->query($sql,array($qname));
            if ($query->num_rows > 0){
            	return 1;
            }
            else 
            	return 0;
 		}

 		function getQs(){
			$query = $this->db->query('SELECT * FROM queues') or die ('0');
			$rs = $query->result_array();
			return $rs;
		}

		function addQ($data){
			if ($this->chkAvailability($data['qname']) == 0){
				$this->db->insert('queues',$data) or die ('0');
				return 1;
	
			}
			else{
				return 2;
			}
		}
		function deleteQ($qname){
			$sql = ('DELETE FROM queues WHERE qname = ?');
			$query = $this->db->query($sql,$qname) or die ('0');
			return 1;
		}
	}
?>