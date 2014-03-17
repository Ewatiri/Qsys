<?php
	
	class Cqueues extends CI_Controller{

		function addtoQueue($data){
			$this->db->set('jtime','NOW()',FALSE);
			$this->db->insert('cqueues',$data) or die ('0');
			return 1;
		}
	}
?>