<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Operation_Behandle extends CI_Controller {
	public $content;

	public function __construct() {
        parent::__construct();
				$this->load->model('M_operation');

    }

	public function index(){
		$headers  = '<link rel="apple-touch-icon" href="'.base_url().'assets/images/apple-touch-icon.png">';
		$headers .= '<link rel="shortcut icon" href="'.base_url().'assets/images/favicon.ico">';
		#Stylesheets
		$headers .= '<link rel="stylesheet" href="'.base_url().'assets/css/bootstrap.min.css?v2.1.0">';
		$headers .= '<link rel="stylesheet" href="'.base_url().'assets/css/bootstrap-extend.min.css?v2.1.0">';
		$headers .= '<link rel="stylesheet" href="'.base_url().'assets/css/site.min.css?v2.1.0">';
		$headers .= '<link rel="stylesheet" href="'.base_url().'assets/css/slide-unlock.css">';
		//$headers .= '<link rel="stylesheet" href="'.base_url().'assets/css/login_handheld.css">';
        #Plugins
        $headers .= '<link rel="stylesheet" href="'.base_url().'assets/vendor/animsition/animsition.min.css?v2.1.0">';
       	$headers .= '<link rel="stylesheet" href="'.base_url().'assets/vendor/asscrollable/asScrollable.min.css?v2.1.0">';
        $headers .= '<link rel="stylesheet" href="'.base_url().'assets/vendor/switchery/switchery.min.css?v2.1.0">';
        $headers .= '<link rel="stylesheet" href="'.base_url().'assets/vendor/intro-js/introjs.min.css?v2.1.0">';
        $headers .= '<link rel="stylesheet" href="'.base_url().'assets/vendor/slidepanel/slidePanel.min.css?v2.1.0">';
        $headers .= '<link rel="stylesheet" href="'.base_url().'assets/vendor/flag-icon-css/flag-icon.min.css?v2.1.0">';
        $headers .= '<link rel="stylesheet" href="'.base_url().'assets/vendor/waves/waves.min.css?v2.1.0">';
		$headers .= '<link rel="stylesheet" href="'.base_url().'assets/vendor/sweetalert/sweetalert.css">';
		$headers .= '<link rel="stylesheet" href="'.base_url().'assets/vendor/themes/twitter.css">';
      	#Page
        //$headers .= '<link rel="stylesheet" href="'.base_url().'assets/vendor/pages/login.min.css?v2.1.0">';
        #Fonts
        $headers .= '<link rel="stylesheet" href="'.base_url().'assets/fonts/material-design/material-design.min.css?v2.1.0">';
        $headers .= '<link rel="stylesheet" href="'.base_url().'assets/fonts/brand-icons/brand-icons.min.css?v2.1.0">';
        $headers .= '<link rel="stylesheet" href="'.base_url().'assets/fonts/font.css?v2.1.0">';
        #Scripts
        $headers .= '<script src="'.base_url().'assets/vendor/modernizr/modernizr.min.js"></script>';
        $headers .= '<script src="'.base_url().'assets/vendor/breakpoints/breakpoints.min.js"></script>';
        $headers .= '<script>Breakpoints();</script>';
		#Core
		$footers  = '<script src="'.base_url().'assets/vendor/jquery/jquery.min.js"></script>';
		$footers .= '<script src="'.base_url().'assets/vendor/bootstrap/bootstrap.min.js"></script>';

		$footers .= '<script src="'.base_url().'assets/vendor/animsition/animsition.min.js"></script>';
		$footers .= '<script src="'.base_url().'assets/vendor/asscroll/jquery-asScroll.min.js"></script>';
		$footers .= '<script src="'.base_url().'assets/vendor/mousewheel/jquery.mousewheel.min.js"></script>';
		$footers .= '<script src="'.base_url().'assets/vendor/asscrollable/jquery.asScrollable.all.min.js"></script>';
		$footers .= '<script src="'.base_url().'assets/vendor/ashoverscroll/jquery-asHoverScroll.min.js"></script>';
		$footers .= '<script src="'.base_url().'assets/vendor/waves/waves.min.js"></script>';
		#Plugins
		$footers .= '<script src="'.base_url().'assets/vendor/switchery/switchery.min.js"></script>';
		$footers .= '<script src="'.base_url().'assets/vendor/intro-js/intro.min.js"></script>';
		$footers .= '<script src="'.base_url().'assets/vendor/screenfull/screenfull.min.js"></script>';
		$footers .= '<script src="'.base_url().'assets/vendor/slidepanel/jquery-slidePanel.min.js"></script>';
		$footers .= '<script src="'.base_url().'assets/vendor/alertify-js/alertify.js"></script>';

		
		#Plugins For This Page
		$footers .= '<script src="'.base_url().'assets/vendor/jquery-placeholder/jquery.placeholder.min.js"></script>';
		#Scripts
		$footers .= '<script src="'.base_url().'assets/js/core.min.js"></script>';
		$footers .= '<script src="'.base_url().'assets/js/site.min.js"></script>';
        $footers .= '<script src="'.base_url().'assets/js/sections/menu.min.js"></script>';
        $footers .= '<script src="'.base_url().'assets/js/sections/menubar.min.js"></script>';
        $footers .= '<script src="'.base_url().'assets/js/sections/gridmenu.min.js"></script>';
        $footers .= '<script src="'.base_url().'assets/js/sections/sidebar.min.js"></script>';
		$footers .= '<script src="'.base_url().'assets/js/configs/config-colors.min.js"></script>';
        $footers .= '<script src="'.base_url().'assets/js/configs/config-tour.min.js"></script>';
        $footers .= '<script src="'.base_url().'assets/js/components/asscrollable.min.js"></script>';
        $footers .= '<script src="'.base_url().'assets/js/components/animsition.min.js"></script>';
        $footers .= '<script src="'.base_url().'assets/js/components/slidepanel.min.js"></script>';
        $footers .= '<script src="'.base_url().'assets/js/components/switchery.min.js"></script>';
        $footers .= '<script src="'.base_url().'assets/js/components/tabs.min.js"></script>';
        $footers .= '<script src="'.base_url().'assets/js/components/jquery-placeholder.min.js"></script>';
        $footers .= '<script src="'.base_url().'assets/js/components/material.min.js"></script>';
		$footers .= '<script src="'.base_url().'assets/vendor/sweetalert/sweetalert.min.js"></script>';
		$footers .= '<script src="'.base_url().'assets/js/main.js"></script>';
		$footers .= '<script src="'.base_url().'assets/js/jquery.slideunlock.js"></script>';
		$footers .= '<script src="'.base_url().'assets/js/pickupjs_test.js"></script>';
		
		/*if($this->session->userdata('LOGGED')){
			redirect(base_url().'handheld.php');
		}else{*/
			if($this->content==""){
				$this->content = $this->load->view('content/home/index','',true);
			}
			$data = array('_title_' => 'BOS',
						  '_headers_' => $headers,
						  '_footers_' => $footers,
						  '_content_' => $this->content);
			$this->parser->parse('index', $data);
		//}

	}

	public function opr(){
		if (!$this->session->userdata('LOGGED')){
			$this->index();
			return;
		}
		
			$data['usernya'] = $this->session->userdata('KD_GROUP');
			$data['title'] = 'MENU HANDHELD';
			$data['jumlahmarshcic'] = $this->M_operation->datajumlahmarshallingcic();
			$data['jumlahmarshyard'] = $this->M_operation->datajumlahmarshallingyard();
			$data['jumlah'] = $this->M_operation->getalldelivery();
	    $this->content = $this->load->view('content/operation/index',$data,true);
		$this->index();
	}

	public function pickup_test(){
		if (!$this->session->userdata('LOGGED')){
			$this->index();
			return;
		}
		$data['title'] = 'MENU HANDHELD';
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('nomerspk','NO SPK', 'required');
		if ($this->form_validation->run() === false) {
			$this->content = $this->load->view('content/operation/pickup_test',$data,true);
			$this->index();
		}else{
			$this->M_operation->set_pickup();
		}
	}

	public function pickup(){
		if (!$this->session->userdata('LOGGED')){
			$this->index();
			return;
		}
		$data['title'] = 'MENU HANDHELD';
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('nomerspk','NO SPK', 'required');
		if ($this->form_validation->run() === false) {
			$this->content = $this->load->view('content/operation/pickup',$data,true);
			$this->index();
		}else{
			$this->M_operation->set_pickup();
		}
	}

	public function search_pickup(){
		$data['menuu']='HANDHELD';
		$ss=date('y');
		$keyword    =  strtoupper(str_replace(' ', '',$this->input->post('search_spk')));
		$keyword1    =  strtoupper(str_replace(' ', '',$this->input->post('search_spk')));
		
		if (substr($keyword,1,3) != 'MTI') {
			$keyword    =  "MTI-".$ss."/".$this->input->post('search_spk');
			$keyword1    =  "ITPK-".$ss."/".$this->input->post('search_spk');
		}else {
			$keyword    =  strtoupper(str_replace(' ', '',$this->input->post('search_spk')));
			$keyword1    =  strtoupper(str_replace(' ', '',$this->input->post('search_spk')));
		}
		$re  =   $this->M_operation->cek_tspk3($keyword,$keyword1);
		$spk= $this->M_operation->searchco($re['ID']);
		$kondis= $this->M_operation->ambiltruck();

		if (count($spk)==0){
			$data['status']=0;
			$data['spk']=$keyword;
			$data['kode']=1;
			$this->content = $this->load->view('content/operation/pickup',$data,true);
			$this->index();
		}else {
			$data['nilai']=$spk;
			$data['totale']=count($spk);
			$data['status']=1;
			$data['kondisi']=$kondis;
			$data['spk']=$keyword;
			$this->content = $this->load->view('content/operation/pickup',$data,true);
			$this->index();
		}
	}



	public function search_pickup_test(){
		$data['menuu']='HANDHELD';
		$ss=date('y');
		$keyword    =  strtoupper(str_replace(' ', '',$this->input->post('search_spk')));
		$keyword1    =  strtoupper(str_replace(' ', '',$this->input->post('search_spk')));
		
		if (substr($keyword,1,3) != 'MTI') {
			$keyword    =  "MTI-".$ss."/".$this->input->post('search_spk');
			$keyword1    =  "ITPK-".$ss."/".$this->input->post('search_spk');
		}else {
			$keyword    =  strtoupper(str_replace(' ', '',$this->input->post('search_spk')));
			$keyword1    =  strtoupper(str_replace(' ', '',$this->input->post('search_spk')));
		}
		$re  =   $this->M_operation->cek_tspk3($keyword,$keyword1);
		$spk= $this->M_operation->searchco($re['ID']);
		$kondis= $this->M_operation->ambiltruck();

		if (count($spk)==0){
			$data['status']=0;
			$data['spk']=$keyword;
			$data['kode']=1;
			$this->content = $this->load->view('content/operation/pickup_test',$data,true);
			$this->index();
		}else {
			$data['nilai']=$spk;
			$data['totale']=count($spk);
			$data['status']=1;
			$data['kondisi']=$kondis;
			$data['spk']=$keyword;
			$this->content = $this->load->view('content/operation/pickup_test',$data,true);
			$this->index();
		}
	}

	// public function behandlein(){
	// 	if (!$this->session->userdata('LOGGED')){
	// 		$this->index();
	// 		return;
	// 	}
	// 	$data['menuu']='Behandle IN';
	// 	$this->load->helper('form');
	// 	$this->load->library('form_validation');
	// 	$this->form_validation->set_rules('nomerkon','No Cont', 'required');
	// 		if ($this->form_validation->run() ===false) {
	// 			$this->content = $this->load->view('content/operation/inspection',$data,true);
	// 			$this->index();
	// 		}else{
	// 			$this->M_operation->set_inspection();
	// 		}
	// }

	public function behandlein_new(){
		if (!$this->session->userdata('LOGGED')){
			$this->index();
			return;
		}
		$data['menuu']='Behandle IN';
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('nomerkon','No Cont', 'required');
			if ($this->form_validation->run() ===false) {
				$this->content = $this->load->view('content/operation/inspectionn',$data,true);
				$this->index();
			}else{
				$this->M_operation->set_inspectionn();
			}
	}

	// public function search_behandle(){
	// 	$data['menuu']='HANDHELD';
	// 	$keyw    =   $this->input->post('search_cont');
    //     $keyword =strtoupper($keyw);
    //     $re  =   $this->M_operation->searchb22($keyword);
	// 	$dan=$re->result_array();
	// 	if (count($dan)==0) {
	// 		$data['status']=0;
	// 		$data['nilai']=$keyword;
	// 		$data['kode']=1;
	// 		$this->content = $this->load->view('content/operation/inspection',$data,true);
	// 		$this->index();
	// 	}else {
	// 		$data['nilai']=$re;
	// 		$data['status']=2;
	// 		$this->content = $this->load->view('content/operation/inspection',$data,true);
	// 		$this->index();
	// 	}
	// }


	// public function search_behandlein(){
	// 	$data['menuu']='HANDHELD';
    //     $keyword   =   $this->input->post('submitman2');
    //     $re  =   $this->M_operation->search($keyword);
	// 	$reftruck= $this->M_operation->ambiltruck2($re['ID_FLAT']);
    //     $kondis= $this->M_operation->ambilkondisi();
	// 	if (count($re)==0) {
	// 		$data['status']=0;
	// 		$data['nilai']=$keyword;
	// 		$data['kode']=1;
	// 		$this->content = $this->load->view('content/operation/inspection',$data,true);
	// 		$this->index();
	// 	}else {
	// 		$data['nilai']=$re;
	// 		$data['status']=1;
	// 		$data['truck']=$reftruck;
	// 		$data['kondisi']=$kondis;
	// 		$this->content = $this->load->view('content/operation/inspection',$data,true);
	// 		$this->index();
	// 	}
	// }

	public function search_behandle_new(){
		$data['menuu']='HANDHELD';
		$keyw    =   $this->input->post('search_cont');
        $keyword =strtoupper($keyw);
        $re  =   $this->M_operation->searchb23($keyword);
		$dan=$re->result_array();
		//var_dump(($dan));die();
		if (count($dan)==0) {
			$data['status']=0;
			$data['nilai']=$keyword;
			$data['kode']=1;
			$this->content = $this->load->view('content/operation/inspectionn',$data,true);
			$this->index();
		}else {
			$data['nilai']=$re;
			$data['status']=2;
			$this->content = $this->load->view('content/operation/inspectionn',$data,true);
			$this->index();
		}
	}

	public function search_behandlein_new(){
		$data['menuu']='HANDHELD';
        $keyword   =   $this->input->post('submitman2');
        $re  =   $this->M_operation->searchh($keyword);
		//var_dump(($re));die();
		$reftruck= $this->M_operation->ambiltruck2($re['ID_FLAT']);
        $kondis= $this->M_operation->ambilkondisi();
		if (count($re)==0) {
			$data['status']=0;
			$data['nilai']=$keyword;
			$data['kode']=1;
			$this->content = $this->load->view('content/operation/inspectionn',$data,true);
			$this->index();
		}else {
			$data['nilai']=$re;
			$data['status']=1;
			$data['truck']=$reftruck;
			$data['kondisi']=$kondis;
			$this->content = $this->load->view('content/operation/inspectionn',$data,true);
			$this->index();
		}
	}

	// public function hold(){
	//   	if (!$this->session->userdata('LOGGED')){
	// 		$this->index();
	// 		return;
	// 	}
  	// 	//proses hold
	// 		$data['menuu']='Hold';
	// 		$data['nilai'] = $this->M_operation->get_hold();
	// 		$this->load->helper('form');
	// 		$this->load->library('form_validation');
	// 		$this->form_validation->set_rules('nomerspk','NO SPK', 'required');
	// 			if ($this->form_validation->run() ===false) {
	// 				$this->content = $this->load->view('content/operation/hold',$data,true);
	// 				$this->index();
	// 			}else{
	// 				$this->M_operation->set_hold();
	// 				redirect('Operation_Behandle/hold');
	// 			}
	// }


	public function hold_cont(){
		if (!$this->session->userdata('LOGGED')){
		  $this->index();
		  return;
	  }
		// proses hold
		$this->M_operation->set_holdd();
		redirect('Operation_Behandle/hold_new');
  	}

	public function release(){
		if (!$this->session->userdata('LOGGED')){
		  $this->index();
		  return;
	  }
		//proses release
		$this->M_operation->set_release();
		redirect('Operation_Behandle/hold_new');
  	}

	public function hold_new(){
		if (!$this->session->userdata('LOGGED')){
			$this->index();
			return;
		}
		$data['menuu']='HOLD';
		$data['nilai'] = $this->M_operation->realese();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('nomerkon','No Cont', 'required');
			if ($this->form_validation->run() ===false) {
				$this->content = $this->load->view('content/operation/list_realese',$data,true);
				$this->index();
			}else{
				$this->M_operation->set_holdd();
				redirect('Operation_Behandle/hold_new');
			}
	}

	public function search_hold(){
		$data['menuu']='HANDHELD';
        $keyword   =   $this->input->post('submitman2');
        $re  =   $this->M_operation->search_hold($keyword);
		//var_dump(($re));die();
		if (count($re)==0) {
			$data['status']=0;
			$data['nilai']=$keyword;
			$data['kode']=1;
			$this->content = $this->load->view('content/operation/holdd',$data,true);
			$this->index();
		}else {
			$data['nilai']=$re;
			$data['status']=1;
			$this->content = $this->load->view('content/operation/holdd',$data,true);
			$this->index();
		}
	}

	public function search_hold_new(){
		$data['menuu']='HANDHELD';
		$keyw    =   $this->input->post('search_cont');
		//var_dump(($keyw));die();
        $keyword =strtoupper($keyw);
        $re  =   $this->M_operation->search_holdd($keyword);
		$dan=$re->result_array();
		// var_dump(($dan));die();
		if (count($dan)==0) {
			$cek = $this->M_operation->search_realease($keyword)->result_array();
			if(count($cek) > 0){
				$data['status']=3;
				$data['nilai']=$keyword;
				$data['hold'] = $cek;
				$this->content = $this->load->view('content/operation/holdd',$data,true);
				$this->index();
			} else {
				$data['status']=0;
				$data['nilai']=$keyword;
				$data['kode']=1;
				$this->content = $this->load->view('content/operation/holdd',$data,true);
				$this->index();
			}
		}else {
			$data['nilai']=$re;
			$data['status']=2;
			$this->content = $this->load->view('content/operation/holdd',$data,true);
			$this->index();
		}
	}

	public function listcontainer(){
		if (!$this->session->userdata('LOGGED')){
			$this->index();
			return;
		}
		$data['menuu']='handheld';
		$data['nilai'] = $this->M_operation->get_list();
		//var_dump($data['nilai']);die();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('nomercont','NO CONT', 'required');
			if ($this->form_validation->run() ===false) {
				$this->content = $this->load->view('content/operation/listcontainer',$data,true);
				$this->index();
			}else{
				$this->M_operation->set_listcontainer();
				redirect('Operation_Behandle/listcontainer');
				//echo "test";
			}
	}


	public function marshallingcic(){
		if (!$this->session->userdata('LOGGED')){
			$this->index();
			return;
		}
		
		$data['nilai'] = $this->M_operation->getalljobscic();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('jobs','NO JOB SLIP', 'required');
			if ($this->form_validation->run() ===false) {
				$this->content = $this->load->view('content/operation/marshallingcic',$data,true);
				$this->index();
			}else{
				$this->M_operation->set_marshalling_cic();
			}
	}

	public function search_cic(){
		$data['menuu']='HANDHELD';
		$keyword    =   $this->input->post('search_js');
		$re  		=  $this->M_operation->ambilmarshcic($keyword);
		if (count($re)==0) {
			$data['status']=0;
			$data['jobs']=$keyword;
			$data['kode']=1;
			$this->content = $this->load->view('content/operation/marshallingcic',$data,true);
			$this->index();
		}else {
			$data['nilai']=$re;
			$data['status']=1;
			$this->content = $this->load->view('content/operation/marshallingcic',$data,true);
			$this->index();
		}
	}

	public function marshallingyard(){
		if (!$this->session->userdata('LOGGED')){
			$this->index();
			return;
		}
		
		$data['nilai'] = $this->M_operation->getalljobsyard();
		
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('jobs','NO JOB SLIP', 'required');
			if ($this->form_validation->run() ===false) {
				$this->content = $this->load->view('content/operation/marshallingyard',$data,true);
				$this->index();
			}else{
				$this->M_operation->set_marshalling_yard();
			}
	}

	public function search_yard(){
		$data['menuu']='HANDHELD';
		$job    	=   $this->input->post('jenis_js');
		$keyword    =   $this->input->post('search_js');
		$re  		=  $this->M_operation->ambilmarshyard($keyword);
		if (count($re)==0) {
			$data['status']=0;
			$data['jobs']=$keyword;
			$data['kode']=1;
			$this->content = $this->load->view('content/operation/marshallingyard',$data,true);
			$this->index();
		}else {
			$data['nilai']=$re;
			$data['status']=1;
			$this->content = $this->load->view('content/operation/marshallingyard',$data,true);
			$this->index();
		}
	}

	public function realisasi(){
		if (!$this->session->userdata('LOGGED')){
			$this->index();
			return;
		}
		
		$data['menuu']='PEMERIKSAAN BEHANDLE';
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('nomerkon','No Cont', 'required');
		if ($this->form_validation->run() === false) {
			$this->content = $this->load->view('content/operation/realisasibi',$data,true);
			$this->index();
		}else{
			$this->M_operation->set_pemeriksaan();
		}
	}

	public function search_realis(){
		$data['menuu']='HANDHELD';
			$keyword    =   $this->input->post('search_cont');
			$re =   $this->M_operation->searchreal($keyword);
			if (COUNT($re) == 0) {
				$data['status']=0;
				$data['kode']=1;
				$data['nilai']= $keyword;
				$this->content = $this->load->view('content/operation/realisasibi',$data,true);
				$this->index();
			}else {
				$data['nilai']=$re;
				$data['status']=2;
				$this->content = $this->load->view('content/operation/realisasibi',$data,true);
				$this->index();
			}
	}

	public function search_realisasi(){
			$data['menuu']='HANDHELD';
			$keyword    =   $this->input->post('submitman2');
			$re =   $this->M_operation->searchreal($keyword);
			if (COUNT($re) == 0) {
				$data['status']=0;
				$data['kode']=1;
				$data['nilai']= $keyword;
				$this->content = $this->load->view('content/operation/realisasibi',$data,true);
				$this->index();
			}else {
				$data['nilai']=$re;
				$start= $this->M_operation->statusnya($keyword);
				if ($start['START_INSP']==NULL) {
					$data['kond']=0;
				}elseif ($start['FINISH_INSP']==NULL) {
					$kddok = $start['NO_DOK'];
					$tgldok = $start['TGL_DOK'];
					$data['join'] = $this->db->query("SELECT a.LNSW_NOAJU FROM t_ppk_hdr a JOIN t_ppk_cont b ON a.ID_IJIN = b.ID_IJIN WHERE a.LNSW_KD_RESPON = '005' AND no_cont = '$keyword' and a.NO_RESPON = '$kddok' and a.TG_RESPON = '$tgldok'")->row();
					$data['kond']=1;
					$data['insp']=$start;
				}else{
					$data['kond']=2;
					$data['NOCONT']=$keyword;
				}
				$data['status']=1;
				$this->content = $this->load->view('content/operation/realisasibi',$data,true);
				$this->index();
			}
	}

	public function delivery(){
		if (!$this->session->userdata('LOGGED')){
			$this->index();
			return;
		}

		$data['menuu']='HANDHELD';
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('nomercont','No Cont', 'required');
			if ($this->form_validation->run() === false) {
				$this->content = $this->load->view('content/operation/delivery',$data,true);
				$this->index();
			}else{
				$this->M_operation->set_delivery();
			}
	}

	public function search_delivery(){
		$data['menuu']='HANDHELD';
		$keyword    =   $this->input->post('search_cont2');
		$re =   $this->M_operation->searcingdelive($keyword);

		if (COUNT($re) == 0) {
			$data['status']=0;
			$data['kode']=1;
			$data['kontainer']= $keyword;
			$this->content = $this->load->view('content/operation/delivery',$data,true);
			$this->index();
		}else {
			$data['nilai']=$re;
			$data['status']=5;
			$this->content = $this->load->view('content/operation/delivery',$data,true);
			$this->index();
		}
	}

	public function searchdelivery(){
		$data['menuu']='HANDHELD';
				$keyword    =   $this->input->post('submitman2');
				$cari	= $this->M_operation->searchdeliv2($keyword);
				$del 	= $this->M_operation->searchdeliv($keyword);
				$kondis	= $this->M_operation->ambilkondisi()->result_array();
				
				if (count($cari)==0){
					$data['status']=0;
					$data['kontainer']=$keyword;
					$data['kode']=1;
					$data['kondisi']=$kondis;
					$this->content = $this->load->view('content/operation/delivery',$data,true);
					$this->index();
				}else{
					if (count($del)==0){
						$data['nilai']=$del;
						$data['ukurane']=$cari[0]['UKR_CONT'];
						$data['kontainer']=$keyword;
						$data['status']=1;
						$this->content = $this->load->view('content/operation/delivery',$data,true);
						$this->index();
					}else {
						if ($del[0]['WK_TRUCKIN'] !== NULL && $del[0]['WK_CHASSIS'] !== NULL  && $del[0]['WK_INSPECT'] !== NULL && $del[0]['WK_GATEOUT'] == NULL ) {
							$data['nilai']=$del;
							$data['kondisi']=$kondis;
							$data['kontainer']=$keyword;
							$data['status']=2;
							$this->content = $this->load->view('content/operation/delivery',$data,true);
							$this->index();
						}else{
							$data['status']=0;
							$data['kontainer']=$keyword;
							$data['kode']=1;
							$this->content = $this->load->view('content/operation/delivery',$data,true);
							$this->index();
						}
					}
				}
	}

	public function inspectout(){
		if (!$this->session->userdata('LOGGED')){
			$this->index();
			return;
		}
		$data['menuu']='HANDHELD';
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('nomercont','No Cont', 'required');
		if ($this->form_validation->run() === false) {
			$this->content = $this->load->view('content/operation/inspectout',$data,true);
			$this->index();
		}else{
			$this->M_operation->set_inspect();
		}
	}

	public function search_inspect(){
		$data['menuu']='HANDHELD';
		$keyword    =   $this->input->post('search_cont');
		$re =   $this->M_operation->searcinspect($keyword);

		if (COUNT($re) == 0) {
			$data['status']=0;
			$data['kode']=1;
			$data['kontainer']= $keyword;
			$data['nilai']= $keyword;
			$this->content = $this->load->view('content/operation/inspectout',$data,true);
			$this->index();
		}else {
			$data['nilai']=$re;
			$data['status']=1;
			$this->content = $this->load->view('content/operation/inspectout',$data,true);
			$this->index();
		}
	}

	public function searchdelivinspect(){
		$data['menuu']='HANDHELD';
			$keyword    =   $this->input->post('submitman2');
			$cari= $this->M_operation->searchdeliv2($keyword);
			$del =   $this->M_operation->searchdeliv($keyword);
			$kondis= $this->M_operation->ambilkondisi()->result_array();
			
			if (count($cari)==0){
				$data['status']=0;
				$data['kontainer']=$keyword;
				$data['kode']=1;
				$data['kondisi']=$kondis;
				$this->content = $this->load->view('content/operation/inspectout',$data,true);
				$this->index();
			}else{
				if (count($del)==0){
					$data['nilai']=$del;
					$data['kontainer']=$keyword;
					$data['status']=0;
					$this->content = $this->load->view('content/operation/inspectout',$data,true);
					$this->index();
				}else {
					if ($del[0]['WK_TRUCKIN']!==NULL && $del[0]['WK_CHASSIS']!==NULL && $del[0]['WK_INSPECT']==NULL) {
						$data['nilai']=$del;
						$data['kondisi']=$kondis;
						$data['kontainer']=$keyword;
						$data['status']=2;
						$this->content = $this->load->view('content/operation/inspectout',$data,true);
						$this->index();
					}else{
						$data['status']=0;
						$data['kontainer']=$keyword;
						$data['kode']=1;
						$this->content = $this->load->view('content/operation/inspectout',$data,true);
						$this->index();
					}
				}
			}
	}

	public function chases(){
		if (!$this->session->userdata('LOGGED')){
			$this->index();
			return;
		}
		$data['menuu']='handheld';
		$data['nilai'] = $this->M_operation->getalldelivery();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('nomercont','NO CONT', 'required');
			if ($this->form_validation->run() ===false) {
				$this->content = $this->load->view('content/operation/onchases',$data,true);
				$this->index();
			}else{
				$this->M_operation->set_onchases();
				// redirect('Operation_Behandle/opr');
			}
	}

	public function search_chases(){
		$data['menuu']='handheld';
		$keyword    =   $this->input->post('search_ch');
		$dat= $this->M_operation->ambilchases("$keyword");
			if (count($dat)==0){
				$data['status']=0;
				$data['NOCONT']=$keyword;
				$data['kode']=1;
				$data['notif']=2;
				$this->content = $this->load->view('content/operation/onchases',$data,true);
				$this->index();
			}else {
				$data['nilai']=$dat;
				$data['status']=1;
				$data['NOCONT']=$keyword;
				$this->content = $this->load->view('content/operation/onchases',$data,true);
				$this->index();
			}
	}	
		  
	public function copyard(){
		if (!$this->session->userdata('LOGGED')){
			$this->index();
			return;
		}
		$data['menuu']='COPY YARD';
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('nomerkon','NO KONTAINER', 'required');
		$data['usernya'] = $this->session->userdata('KD_GROUP');
		if ($this->form_validation->run() ===false) {
			$this->content = $this->load->view('content/operation/copy',$data,true);
			$this->index();
		}else{
			$this->M_operation->set_copy();
		}
	}

	public function searchcopy(){
			$data['menuu'] 	= 'HANDHELD';
			$NO_CONT    	= $this->input->post('search_cont');
	        $keyword 		= strtoupper($NO_CONT);
	        $CEK_SPK_CONT	=   $this->M_operation->searchop($keyword);
	        $data['usernya'] = $this->session->userdata('KD_GROUP');
			if (count($CEK_SPK_CONT)==0) {
				$data['status'] = 0;
				$data['nilai']	= $keyword;
				$data['kode']	= 1;
				$this->content 	= $this->load->view('content/operation/copy',$data,true);
				$this->index();
			}else {
				$data['nilai']	= $CEK_SPK_CONT;
				$data['status']	= 2;
				$this->content 	= $this->load->view('content/operation/copy',$data,true);
				$this->index();
			}
	} 
			
	public function search_copy(){
			$data['menuu'] 	= 'HANDHELD';
			$NO_CONT   		= $this->input->post('submitman');
	        $keyword 		= strtoupper($NO_CONT);
	        $CEK_SPK_CONT	= $this->M_operation->searchop2($keyword);
	        $data['usernya'] = $this->session->userdata('KD_GROUP');
			if (count($CEK_SPK_CONT)==0) {
				$data['status'] = 0;
				$data['nilai'] 	= $keyword;
				$data['kode']	= 1;
				$this->content 	= $this->load->view('content/operation/copy',$data,true);
				$this->index();
			}else {
				$data['nilai']	= $CEK_SPK_CONT;
				$data['status']	= 1;
				$this->content 	= $this->load->view('content/operation/copy',$data,true);
				$this->index();
			}
	}
	
	public function reefer() {
		if (!$this->session->userdata('LOGGED')){
			$this->index();
			return;
		}
		
		$data['menuu']='PLUGIN REEFER';
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('nomerkon','No Cont', 'required');
		if ($this->form_validation->run() === false) {
			$this->content = $this->load->view('content/operation/plugin',$data,true);
			$this->index();
		}else{
			$this->M_operation->set_plug();
		}
	}

	public function search_reefer() {
		$data['menuu']='HANDHELD';
		$keyword    =   $this->input->post('search_cont');
		$re =   $this->M_operation->searchreefer($keyword);
		if (COUNT($re) == 0) {
			$data['status']=0;
			$data['kode']=1;
			$data['nilai']= $keyword;
			$this->content = $this->load->view('content/operation/plugin',$data,true);
			$this->index();
		}else {
			$data['nilai']=$re;
			$data['status']=2;
			$this->content = $this->load->view('content/operation/plugin',$data,true);
			$this->index();
		}
	}

	public function serch_reefer() {
		$data['menuu']='HANDHELD';
		$keyword    =   $this->input->post('submitman2');
		$re =   $this->M_operation->searchreefer($keyword);
		if (COUNT($re) == 0) {
			$data['status']=0;
			$data['kode']=1;
			$data['nilai']= $keyword;
			$this->content = $this->load->view('content/operation/plugin',$data,true);
			$this->index();
		}else {
			$data['nilai']=$re;
			$data['temp_monitor'] = $this->M_operation->temp_akhir($keyword);
			$start= $this->M_operation->checked($keyword);
			
			if ($start == NULL || $start == 0) {
				$data['kond']=1;
			} else if ($start[0]['WAKTU'] != NULL AND $start[0]['FL_PLUG'] == 'Y' AND $start[0]['FL_UNPLUG'] == 'N') {
				$data['kond']=2;
				$data['insp'] = $start;
			} else {
				$data['kond']=0;
				$data['NOCONT']=$keyword;
			}

			$data['status']=1;
			$this->content = $this->load->view('content/operation/plugin',$data,true);
			$this->index();
		}
	}

	public function monitor_reefer() {
		if (!$this->session->userdata('LOGGED')){
			$this->index();
			return;
		}
		
		$data['menuu']='MONITORING REEFER';
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('nomerkon','No Cont', 'required');
		if ($this->form_validation->run() === false) {
			$this->content = $this->load->view('content/operation/monitor_reefer',$data,true);
			$this->index();
		}else{
			$this->M_operation->set_monitoring();
		}
	}

	public function list_reefer() {
		$data['menuu']='HANDHELD';
		$keyword    =   $this->input->post('search_cont');
		$re =   $this->M_operation->searchmonitorreefer($keyword);
		if (COUNT($re) == 0) {
			$data['status']=0;
			$data['kode']=1;
			$data['nilai']= $keyword;
			$this->content = $this->load->view('content/operation/monitor_reefer',$data,true);
			$this->index();
		}else {
			$data['nilai']=$re;
			$data['status']=2;
			$this->content = $this->load->view('content/operation/monitor_reefer',$data,true);
			$this->index();
		}
	}

	public function monitoring_reefer() {
		$data['menuu']='HANDHELD';
		$keyword    =   $this->input->post('submitman2');
		$re =   $this->M_operation->serchmonitor($keyword);
		if (COUNT($re) == 0) {
			$data['status']=0;
			$data['kode']=1;
			$data['nilai']= $keyword;
			$this->content = $this->load->view('content/operation/monitor_reefer',$data,true);
			$this->index();
		}else {
			$data['nilai']=$re;
			$data['temprev'] = $this->M_operation->temprev($keyword);
			$start = $this->M_operation->serchmonitor($keyword);
			
			if ($start['WAKTU'] != NULL AND $start['WAKTU_END'] == NULL) {
				$data['kond']=1;
			} else {
				$data['kond']=0;
				$data['NOCONT']=$keyword;
			}
			$data['status']=1;
			$this->content = $this->load->view('content/operation/monitor_reefer',$data,true);
			$this->index();
		}
	}

	// public function kirimnpct1()
	// {
	// 	//echo var_dump($_POST);die();
	// 	$cont = $this->input->post('container');
	// 	$plat = $this->input->post('no_plat');
	// 	$this->load->model('Requestgatepass');
	// 	$plat = ltrim($plat);
	// 	$plat = rtrim($plat);
	// 	//$this->db->query("UPDATE t_spk_cont SET ID_FLAT='' WHERE ID= AND NO_CONT=''");
		
	// 	$datacont = $this->db->query("SELECT A.NO_DOK,A.NO_SPK,A.TGL_DOK,A.NO_CONT,'$plat' as ID_FLAT,B.TAR,B.TIPE_CONT,B.KD_CONT_JENIS,B.VESSEL,B.VOY_IN,B.ISO_CODE,C.NO_PLAT,C.BERAT_TRUCK,B.BRUTO,B.FL_DG,B.FL_OOG FROM(
    //         SELECT a.NO_DOK,a.TGL_DOK,a.NO_SPK,b.NO_CONT,b.ID_FLAT,b.ISO_CODE FROM t_spk a JOIN t_spk_cont b ON a.ID = b.ID ) A
    //      JOIN (
    //         SELECT c.NO_DOK,c.TGL_DOK,d.NO_CONT,d.TAR,d.TIPE_CONT,d.KD_CONT_JENIS,d.VESSEL,d.VOY_IN,d.ISO_CODE,d.BRUTO,d.FL_DG,d.FL_OOG FROM t_request c JOIN t_request_cont d ON c.ID = d.ID) B ON  A.no_dok = B.no_dok AND A.NO_CONT = B.NO_CONT
    //      LEFT JOIN reff_truck C ON '$plat' = C.NO_TRUCK
    //      WHERE A.NO_CONT = '$cont' ORDER BY A.TGL_DOK desc")->row();
         

	// 	 $data1 = $this->Requestgatepass->message2a($datacont);
	// 	 $data2 = $this->Requestgatepass->message2b($datacont);
		

	// 	//  $data3 = $this->Requestgatepass->message3a($datacont);
	// 	//  $data4 = $this->Requestgatepass->message3b($datacont);
    //     // echo $data1->status;
    //     // echo $data2->TruckEvent->TruckCall->AppStatus;
    //     // echo $data3->message;
	// 	// echo $data4->TruckEvent->TruckCall->AppStatus;

	// 	$mes = '';
	// 	if ($data1->status == 'OK' && $data2->TruckEvent->TruckCall->AppStatus == 'OK') {
	// 		$data3 = $this->Requestgatepass->message3a($datacont);
	// 		if ($data3->message == 'Success') {
	// 			$data4 = $this->Requestgatepass->message3b($datacont);
	// 			if ($data4->TruckEvent->TruckCall->AppStatus == 'OK') {
	// 				$stat = 'success';
	// 				$this->db->query("UPDATE `t_spk_cont` SET `FL_SEND_NPCT1`='Y' WHERE NO_CONT = '$cont' AND status_cont = '100'");
	// 				$this->db->query("UPDATE `t_spk_cont` SET `ID_FLAT`='$plat' WHERE `NO_CONT`='$cont' AND status_cont = '100'");
	// 			}else {
	// 				$stat = 'Error';
	// 				$mes = 'error3';
	// 			}
	// 		}
	// 		else {
	// 			$stat = 'Error';
	// 			$mes = 'error2';
	// 		}
	// 	}else {
	// 		$stat = 'Error';
	// 		$mes = 'error1';
	// 	}    
	// 	$data['cont'] =  $datacont;
	// 	$data['message'] = $mes;
	// 	$data['status'] = $stat;
	// 	echo json_encode($data);
	// }

	public function testkirimnpct1()
	{
		//echo var_dump($_POST);die();
		$cont = $this->input->post('container');
		$plat = $this->input->post('no_plat');
		$this->load->model('Requestgatepasstest');
		$plat = ltrim($plat);
		$plat = rtrim($plat);
		//$this->db->query("UPDATE t_spk_cont SET ID_FLAT='' WHERE ID= AND NO_CONT=''");
		
		$datacont = $this->db->query("SELECT A.NO_DOK,A.NO_SPK,A.TGL_DOK,A.NO_CONT,'$plat' as ID_FLAT,B.TAR,B.TIPE_CONT,B.KD_CONT_JENIS,B.VESSEL,B.VOY_IN,B.ISO_CODE,C.NO_PLAT,C.BERAT_TRUCK,B.BRUTO,B.FL_DG,B.FL_OOG FROM(
            SELECT a.NO_DOK,a.TGL_DOK,a.NO_SPK,b.NO_CONT,b.ID_FLAT,b.ISO_CODE FROM t_spk a JOIN t_spk_cont b ON a.ID = b.ID ) A
         JOIN (
            SELECT c.NO_DOK,c.TGL_DOK,d.NO_CONT,d.TAR,d.TIPE_CONT,d.KD_CONT_JENIS,d.VESSEL,d.VOY_IN,d.ISO_CODE,d.BRUTO,d.FL_DG,d.FL_OOG FROM t_request c JOIN t_request_cont d ON c.ID = d.ID) B ON  A.no_dok = B.no_dok AND A.NO_CONT = B.NO_CONT
         LEFT JOIN reff_truck C ON '$plat' = C.NO_TRUCK
         WHERE A.NO_CONT = '$cont' ORDER BY A.TGL_DOK desc")->row();
         

		 $data1 = $this->Requestgatepasstest->message2a($datacont);
		 $data2 = $this->Requestgatepasstest->message2b($datacont);
		
		 $data1 = $data1->code;
		 $data2 = $data2->code;

		//  var_dump($data1);
		//  var_dump($data2);die();

		if ($data1== 00 && $data2 == 00) {
			$stat = 'success';
			$this->db->query("UPDATE `t_spk_cont` SET `FL_SEND_NPCT1`='Y' WHERE NO_CONT = '$cont' AND status_cont = '100'");
			$this->db->query("UPDATE `t_spk_cont` SET `ID_FLAT`='$plat' WHERE `NO_CONT`='$cont' AND status_cont = '100'");
		} else {
			$stat = 'error';
			$mes = 'error1';
		}    
		$data['cont'] =  $datacont;
		$data['message'] = $mes;
		$data['status'] = $stat;
		echo json_encode($data);
	}

	public function pickuppercontainer()
	{
		$NO_SPK = $this->input->post('nomerspk');
		$NO_CONT = $this->input->post('nocont');

		$SQL_SPK_CONT = $this->db->query("SELECT A.*, B.* FROM t_spk A INNER JOIN t_spk_cont B ON A.ID = B.ID WHERE A.NO_SPK='".$NO_SPK."' AND B.NO_CONT = '".$NO_CONT."'")->result_array();

		if ($SQL_SPK_CONT[0]['NO_SPK'] == $NO_SPK) {
			$STATUS_CONT = 0;
			for ($i=0; $i < count($SQL_SPK_CONT); $i++) {
				/* UNTUK COMBOBOX ID_FLAT */
				$idflat = "idflat".$i; 
				$ARR_ID_FLAT = $SQL_SPK_CONT[$i]['ID_FLAT'];
				$ID_FLAT[$i] = $ARR_ID_FLAT;
				/* CEK KONDISI STATUS CONTAINER*/
				if ($SQL_SPK_CONT[$i]['STATUS_CONT'] == '900') {
					$STATUS_CONT ++;
				}
			}
			if ($STATUS_CONT == 0) {
				//echo 'sampe sini lagi 1';die();
				if($SQL_SPK_CONT[0]['STATUS_CONT'] == '100'){
					/* UPDATE SPK */
					//$this->db->where(array('NO_SPK' => $NO_SPK));
					//$this->db->update('t_spk', array('KD_STATUS' => '200'));

					$pickup = array(
						'OPERATOR' => $this->session->userdata('USERLOGIN'), 
						'NO_SPK' => $NO_SPK,
						'NO_CONT' => $NO_CONT,
						'JNS_PICK' => 'S',
						'W_PICKUP' => date('Y-m-d H:i:s')
					);
					$this->db->insert('t_op_pickup',$pickup);

					/* UPDATE SPK CONTAINER */
					for ($c=0; $c < count($SQL_SPK_CONT); $c++) {
						$this->db->where(array('ID' => $SQL_SPK_CONT[$c]['ID'], 'NO_CONT' => $SQL_SPK_CONT[$c]['NO_CONT']));
						$this->db->update('t_spk_cont', array('STATUS_CONT' => '200', 'ID_FLAT' => $ID_FLAT[$c]));
						
						/* UPDATE JOBSLIP */
						$this->db->where(array('NO_SPK' => $NO_SPK, 'NO_CONT' => $SQL_SPK_CONT[$c]['NO_CONT']));
						$this->db->update('t_job_slip', array('KD_STATUS' => '30','STATUS' => 'WAITING' ));

						/* INSERT TO OPERATION */
						$operation = array(
							'NO_SPK' => $NO_SPK,
							'NO_CONT' => $SQL_SPK_CONT[$c]['NO_CONT'],
							'JNS_DOK' => $SQL_SPK_CONT[$c]['JNS_DOK'],
							'NO_DOK' => $SQL_SPK_CONT[$c]['NO_DOK'],
							'TGL_DOK' => $SQL_SPK_CONT[$c]['TGL_DOK'],
							'WK_PICKUP' => date('Y-m-d H:i:s')
						     ); 
						$this->db->insert('t_operation', $operation);

						$SQLReport = $this->db->query("SELECT * FROM report_behandle WHERE NO_CONT='".$SQL_SPK_CONT[$c]['NO_CONT']."' AND REQ_NO_DOK='".$SQL_SPK_CONT[$c]['NO_DOK']."' AND RB1_NO_SPK = '".$SQL_SPK_CONT[$c]['NO_SPK']."' ORDER BY ID DESC")->result_array();
						if (count($SQLReport) > 0) {
							$updateReport = array(
								'NO_CONT' 		=> $SQL_SPK_CONT[$c]['NO_CONT'],
								'PRN_PICKUP' 	=> date('Y-m-d H:i:s'),
								'PRN_TID' 		=> $ID_FLAT[$c]							
							);
							$this->db->where(array('ID' => $SQLReport[0]['ID'], 'NO_CONT' => $SQL_SPK_CONT[$c]['NO_CONT']));
							$this->db->update('report_behandle', $updateReport);
						}
					}
					$data['notif']=1;
					$data['NOSPK']=$NO_SPK;
					$data['status'] = 'success';
				}else if($SQL_SPK_CONT[0]['STATUS_CONT'] == '300'){
					/* UPDATE SPK */
					//$this->db->where(array('NO_SPK' => $NO_SPK));
					//$this->db->update('t_spk', array('KD_STATUS' => '200'));

					$pickup = array(
						'OPERATOR' => $this->session->userdata('USERLOGIN'), 
						'NO_SPK' => $NO_SPK,
						'NO_CONT' => $NO_CONT,
						'JNS_PICK' => 'S',
						'W_PICKUP' => date('Y-m-d H:i:s')
					);
					$this->db->insert('t_op_pickup',$pickup);

					/* UPDATE SPK CONTAINER */
					for ($c=0; $c < count($SQL_SPK_CONT); $c++) {
						$this->db->where(array('ID' => $SQL_SPK_CONT[$c]['ID'], 'NO_CONT' => $SQL_SPK_CONT[$c]['NO_CONT']));
						$this->db->update('t_spk_cont', array('STATUS_CONT' => '200', 'ID_FLAT' => $ID_FLAT));
						
						/* UPDATE JOBSLIP */
						$this->db->where(array('NO_SPK' => $NO_SPK, 'NO_CONT' => $SQL_SPK_CONT[$c]['NO_CONT']));
						$this->db->update('t_job_slip', array('KD_STATUS' => '30','STATUS' => 'WAITING' ));
					}
					$data['status'] = 'success';
					$data['notif']=1;
					$data['NOSPK']=$NO_SPK;

				}else if($SQL_SPK_CONT[0]['STATUS_CONT'] == '000'){
					$data['notif'] = 3;
					$data['NOSPK'] = $NO_SPK;
					$data['status'] = 'error';
				}else{
					$data['notif'] = 2;
					$data['NOSPK'] = $NO_SPK;
					$data['status'] = 'error';
				}
			}else{
				$data['notif'] = 4;
				$data['NOSPK'] = $NO_SPK;
				$data['status'] = 'error';
			}

		}else{
			$data['notif'] = 2;
			$data['NOSPK'] = $NO_SPK;
			$data['status'] = 'error';
		}

		$sq = $this->db->query("SELECT A.*, B.* FROM t_spk A INNER JOIN t_spk_cont B ON A.ID = B.ID WHERE A.NO_SPK='".$NO_SPK."'");
		$spkkont100 = 0;
		if ($sq->num_rows() > 0) {
			foreach ($sq->result() as $key => $value) {
				if ($value->STATUS_CONT == '100') {
					$spkkont100++;
				}
			}
			if ($spkkont100 == 0) {
				$this->db->query("UPDATE `t_spk` SET `KD_STATUS`='200' WHERE NO_SPK='$NO_SPK'");
			}else {
				$data['jmlcont'] = 'tidak';
			}
		}
		echo json_encode($data);
	}

	public function pickuppercontainertest()
	{
		$NO_SPK = $this->input->post('nomerspk');
		$NO_CONT = $this->input->post('nocont');

		$SQL_SPK_CONT = $this->db->query("SELECT A.*, B.* FROM t_spk A INNER JOIN t_spk_cont B ON A.ID = B.ID WHERE A.NO_SPK='".$NO_SPK."' AND B.NO_CONT = '".$NO_CONT."'")->result_array();

		if ($SQL_SPK_CONT[0]['NO_SPK'] == $NO_SPK) {
			$STATUS_CONT = 0;
			for ($i=0; $i < count($SQL_SPK_CONT); $i++) {
				/* UNTUK COMBOBOX ID_FLAT */
				$idflat = "idflat".$i; 
				$ARR_ID_FLAT = $SQL_SPK_CONT[$i]['ID_FLAT'];
				$ID_FLAT[$i] = $ARR_ID_FLAT;
				/* CEK KONDISI STATUS CONTAINER*/
				if ($SQL_SPK_CONT[$i]['STATUS_CONT'] == '900') {
					$STATUS_CONT ++;
				}
			}
			if ($STATUS_CONT == 0) {
				//echo 'sampe sini lagi 1';die();
				if($SQL_SPK_CONT[0]['STATUS_CONT'] == '100'){
					/* UPDATE SPK */
					//$this->db->where(array('NO_SPK' => $NO_SPK));
					//$this->db->update('t_spk', array('KD_STATUS' => '200'));

					$pickup = array(
						'OPERATOR' => $this->session->userdata('USERLOGIN'), 
						'NO_SPK' => $NO_SPK,
						'NO_CONT' => $NO_CONT,
						'JNS_PICK' => 'S',
						'W_PICKUP' => date('Y-m-d H:i:s')
					);
					$this->db->insert('t_op_pickup',$pickup);

					/* UPDATE SPK CONTAINER */
					for ($c=0; $c < count($SQL_SPK_CONT); $c++) {
						$this->db->where(array('ID' => $SQL_SPK_CONT[$c]['ID'], 'NO_CONT' => $SQL_SPK_CONT[$c]['NO_CONT']));
						$this->db->update('t_spk_cont', array('STATUS_CONT' => '200', 'ID_FLAT' => $ID_FLAT[$c]));
						
						/* UPDATE JOBSLIP */
						$this->db->where(array('NO_SPK' => $NO_SPK, 'NO_CONT' => $SQL_SPK_CONT[$c]['NO_CONT']));
						$this->db->update('t_job_slip', array('KD_STATUS' => '30','STATUS' => 'WAITING' ));

						/* INSERT TO OPERATION */
						$operation = array(
							'NO_SPK' => $NO_SPK,
							'NO_CONT' => $SQL_SPK_CONT[$c]['NO_CONT'],
							'JNS_DOK' => $SQL_SPK_CONT[$c]['JNS_DOK'],
							'NO_DOK' => $SQL_SPK_CONT[$c]['NO_DOK'],
							'TGL_DOK' => $SQL_SPK_CONT[$c]['TGL_DOK'],
							'WK_PICKUP' => date('Y-m-d H:i:s')
						     ); 
						$this->db->insert('t_operation', $operation);

						$SQLReport = $this->db->query("SELECT * FROM report_behandle WHERE NO_CONT='".$SQL_SPK_CONT[$c]['NO_CONT']."' AND REQ_NO_DOK='".$SQL_SPK_CONT[$c]['NO_DOK']."' AND RB1_NO_SPK = '".$SQL_SPK_CONT[$c]['NO_SPK']."' ORDER BY ID DESC")->result_array();
						if (count($SQLReport) > 0) {
							$updateReport = array(
								'NO_CONT' 		=> $SQL_SPK_CONT[$c]['NO_CONT'],
								'PRN_PICKUP' 	=> date('Y-m-d H:i:s'),
								'PRN_TID' 		=> $ID_FLAT[$c]							
							);
							$this->db->where(array('ID' => $SQLReport[0]['ID'], 'NO_CONT' => $SQL_SPK_CONT[$c]['NO_CONT']));
							$this->db->update('report_behandle', $updateReport);
						}
					}
					$data['notif']=1;
					$data['NOSPK']=$NO_SPK;
					$data['status'] = 'success';
				}else if($SQL_SPK_CONT[0]['STATUS_CONT'] == '300'){
					/* UPDATE SPK */
					//$this->db->where(array('NO_SPK' => $NO_SPK));
					//$this->db->update('t_spk', array('KD_STATUS' => '200'));

					$pickup = array(
						'OPERATOR' => $this->session->userdata('USERLOGIN'), 
						'NO_SPK' => $NO_SPK,
						'NO_CONT' => $NO_CONT,
						'JNS_PICK' => 'S',
						'W_PICKUP' => date('Y-m-d H:i:s')
					);
					$this->db->insert('t_op_pickup',$pickup);

					/* UPDATE SPK CONTAINER */
					for ($c=0; $c < count($SQL_SPK_CONT); $c++) {
						$this->db->where(array('ID' => $SQL_SPK_CONT[$c]['ID'], 'NO_CONT' => $SQL_SPK_CONT[$c]['NO_CONT']));
						$this->db->update('t_spk_cont', array('STATUS_CONT' => '200', 'ID_FLAT' => $ID_FLAT));
						
						/* UPDATE JOBSLIP */
						$this->db->where(array('NO_SPK' => $NO_SPK, 'NO_CONT' => $SQL_SPK_CONT[$c]['NO_CONT']));
						$this->db->update('t_job_slip', array('KD_STATUS' => '30','STATUS' => 'WAITING' ));
					}
					$data['status'] = 'success';
					$data['notif']=1;
					$data['NOSPK']=$NO_SPK;

				}else if($SQL_SPK_CONT[0]['STATUS_CONT'] == '000'){
					$data['notif'] = 3;
					$data['NOSPK'] = $NO_SPK;
					$data['status'] = 'error';
				}else{
					$data['notif'] = 2;
					$data['NOSPK'] = $NO_SPK;
					$data['status'] = 'error';
				}
			}else{
				$data['notif'] = 4;
				$data['NOSPK'] = $NO_SPK;
				$data['status'] = 'error';
			}

		}else{
			$data['notif'] = 2;
			$data['NOSPK'] = $NO_SPK;
			$data['status'] = 'error';
		}

		$sq = $this->db->query("SELECT A.*, B.* FROM t_spk A INNER JOIN t_spk_cont B ON A.ID = B.ID WHERE A.NO_SPK='".$NO_SPK."'");
		$spkkont100 = 0;
		if ($sq->num_rows() > 0) {
			foreach ($sq->result() as $key => $value) {
				if ($value->STATUS_CONT == '100') {
					$spkkont100++;
				}
			}
			if ($spkkont100 == 0) {
				$this->db->query("UPDATE `t_spk` SET `KD_STATUS`='200' WHERE NO_SPK='$NO_SPK'");
			}else {
				$data['jmlcont'] = 'tidak';
			}
		}
		echo json_encode($data);
	}
//end class
}
