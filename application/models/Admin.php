<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Model {

	public function __construct(){
		parent::__construct();
		$this->load->database();
	}
	
	public function get_all_jobs($conditions){
		return $this->db->get_where(TBL_JOBS, $conditions)->result();
	}
	
}// end of model