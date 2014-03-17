<?php
	
	class Sys extends CI_Model{

		function getStatus(){
			$query = $this->db->query('SELECT * FROM sys') or die ('-1');
			$rs = $query->row_array();
			return $rs['status'];
		}

	}
?>