<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class M_home extends CI_Model {
	
	public function __construct(){
		parent::__construct();
	}
	
	function ambil_data($user,$pass){		
		$data=array(
			'USER_NAME'=>$user,
			'PASS'=>$pass
		);
		$user = $this->db->get_where('reff_user',$data);	
		return $user->num_rows();
	}
	
	function ambil_data2($user,$pass){		
		$data=array(
			'USER_NAME'=>$user,
			'PASS'=>$pass
		);
		$user = $this->db->get_where('reff_user',$data);	
		return $user->row_array();
	}
	
}
?>