<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Execute extends CI_Controller {
	public function __construct() {
        parent::__construct();
    }
	
	function process($type="",$act="", $id=""){
		//echo "sini"; die();
		$id = ($id!="")?$id:$this->input->post('id');
		//print_r("sini ex id:".$id);die();
		if (!$this->session->userdata('LOGGED')) {
			$this->index();
			return;
		}else{
			if (strtolower($_SERVER['REQUEST_METHOD']) != "post") {
				echo 'access is forbidden'; exit();
			}else{
				$this->load->model("m_execute");
				$this->m_execute->process($type,$act,$id);
			}
		}
	}
	
	function download($act,$id){
		if($act=="excel"){
			if($id=="discharge"){
				$data = file_get_contents(base_url()."assets/files/CoarriCodecoKontainer-Discharge.xls");
				$name = 'CoarriCodecoKontainer-Discharge.xls';
			}else if($id=="loading"){
				$data = file_get_contents(base_url()."assets/files/CoarriCodecoKontainer-Loading.xls");
				$name = 'CoarriCodecoKontainer-Loading.xls';
			}else if($id=="gatein"){
				$data = file_get_contents(base_url()."assets/files/CoarriCodecoKontainer-GateIn.xls");
				$name = 'CoarriCodecoKontainer-GateIn.xls';
			}else if($id=="gateout"){
				$data = file_get_contents(base_url()."assets/files/CoarriCodecoKontainer-GateOut.xls");
				$name = 'CoarriCodecoKontainer-GateOut.xls';
			}
			force_download($name, $data); 	
		}
	}
}