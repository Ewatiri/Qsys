<?php
	
	class Qmanagers extends CI_Model{

		function addMgr($data){
			$this->db->insert('qmanagers',$data) or die ('0');
			return 1;
		}
	}
?>