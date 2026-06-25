<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Operation extends CI_Controller {
	public $content;

	public function __construct() {
        parent::__construct();
				$this->load->model('M_operation');

    }

	public function index(){
		$headers .= '<link rel="apple-touch-icon" href="'.base_url().'assets/images/apple-touch-icon.png">';
		#Stylesheetss
		$headers  = '<link rel="stylesheet" href="'.base_url().'assets/css/bootstrap.min.css?v2.1.0">';
		$headers .= '<link rel="stylesheet" href="'.base_url().'assets/css/bootstrap-extend.min.css?v2.1.0">';
		$headers .= '<link rel="stylesheet" href="'.base_url().'assets/css/site.min.css?v2.1.0">';
		$headers .= '<link rel="stylesheet" href="'.base_url().'assets/vendor/jquery-ui/jquery-ui.min.css?v2.1.0">';
		#Plugins For This Page
  		$headers .= '<link rel="stylesheet" href="'.base_url().'assets/vendor/filament-tablesaw/tablesaw.min.css?v2.1.0">';
		$headers .= '<link rel="stylesheet" href="'.base_url().'assets/vendor/uikit/modals.min.css?v2.1.0">';
		$headers .= '<link rel="stylesheet" href="'.base_url().'assets/vendor/bootstrap-datetimepicker/bootstrap-datetimepicker.min.css?v2.1.0">';
		$headers .= '<link rel="stylesheet" href="'.base_url().'assets/vendor/jquery-wizard/jquery-wizard.min.css?v2.1.0">';
		#Plugins
        $headers .= '<link rel="stylesheet" href="'.base_url().'assets/vendor/animsition/animsition.min.css?v2.1.0">';
       	$headers .= '<link rel="stylesheet" href="'.base_url().'assets/vendor/asscrollable/asScrollable.min.css?v2.1.0">';
        $headers .= '<link rel="stylesheet" href="'.base_url().'assets/vendor/switchery/switchery.min.css?v2.1.0">';
        $headers .= '<link rel="stylesheet" href="'.base_url().'assets/vendor/intro-js/introjs.min.css?v2.1.0">';
        $headers .= '<link rel="stylesheet" href="'.base_url().'assets/vendor/slidepanel/slidePanel.min.css?v2.1.0">';
        $headers .= '<link rel="stylesheet" href="'.base_url().'assets/vendor/waves/waves.min.css?v2.1.0">';
		$headers .= '<link rel="stylesheet" href="'.base_url().'assets/vendor/sweetalert/sweetalert.css">';
		$headers .= '<link rel="stylesheet" href="'.base_url().'assets/vendor/themes/twitter.css">';
		$headers .= '<link rel="stylesheet" href="'.base_url().'assets/css/newtable.css">';
		$headers .= '<link rel="stylesheet" href="'.base_url().'assets/vendor/toastr/toastr.min.css">';
        #Fonts
        $headers .= '<link rel="stylesheet" href="'.base_url().'assets/fonts/material-design/material-design.min.css?v2.1.0">';
        $headers .= '<link rel="stylesheet" href="'.base_url().'assets/fonts/brand-icons/brand-icons.min.css?v2.1.0">';
        $headers .= '<link rel="stylesheet" href="'.base_url().'assets/fonts/font.css?v2.1.0">';
        #Scripts
		$headers .= '<script src="'.base_url().'assets/js/jquery.min.js"></script>';
		$headers .= '<script src="'.base_url().'assets/js/alerts.js"></script>';
        $headers .= '<script src="'.base_url().'assets/vendor/modernizr/modernizr.min.js"></script>';
        $headers .= '<script src="'.base_url().'assets/vendor/breakpoints/breakpoints.min.js"></script>';
        $headers .= '<script>Breakpoints();</script>';
		#Core
		$footers  = '<script src="'.base_url().'assets/vendor/jquery/jquery.min.js"></script>';
		$footers .= '<script src="'.base_url().'assets/vendor/jquery-ui/jquery-ui.min.js"></script>';
		$footers .= '<script src="'.base_url().'assets/vendor/bootstrap/bootstrap.js"></script>';
		$footers .= '<script src="'.base_url().'assets/vendor/bootstrap-datetimepicker/bootstrap-datetimepicker.js"></script>';
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
		$footers .= '<script src="'.base_url().'assets/vendor/formatter-js/jquery.formatter.min.js"></script>';
        $footers .= '<script src="'.base_url().'assets/vendor/jquery-wizard/jquery-wizard.min.js"></script>';
		#Scripts
  		$footers .= '<script src="'.base_url().'assets/js/core.min.js"></script>';
		$footers .= '<script src="'.base_url().'assets/js/site.min.js"></script>';
        $footers .= '<script src="'.base_url().'assets/js/sections/menu.min.js"></script>';
        $footers .= '<script src="'.base_url().'assets/js/sections/menubar.min.js"></script>';
        $footers .= '<script src="'.base_url().'assets/js/sections/gridmenu.min.js"></script>';
        $footers .= '<script src="'.base_url().'assets/js/sections/sidebar.min.js"></script>';
		$footers .= '<script src="'.base_url().'assets/js/configs/config-colors.min.js"></script>';
        $footers .= '<script src="'.base_url().'assets/js/components/asscrollable.min.js"></script>';
        $footers .= '<script src="'.base_url().'assets/js/components/animsition.min.js"></script>';
        $footers .= '<script src="'.base_url().'assets/js/components/slidepanel.min.js"></script>';
        $footers .= '<script src="'.base_url().'assets/js/components/switchery.min.js"></script>';
		$footers .= '<script src="'.base_url().'assets/js/newtable.js"></script>';
		$footers .= '<script src="'.base_url().'assets/js/main.js"></script>';
		$footers .= '<script src="'.base_url().'assets/vendor/sweetalert/sweetalert.min.js"></script>';
		$footers .= '<script src="'.base_url().'assets/vendor/filament-tablesaw/tablesaw.js"></script>';
		$footers .= '<script src="'.base_url().'assets/vendor/toastr/toastr.min.js"></script>';
		$footers .= '<script src="'.base_url().'assets/js/components/input-group-file.min.js"></script>';
		$footers .= '<script src="'.base_url().'assets/js/components/formatter-js.min.js"></script>';
		$footers .= '<script src="'.base_url().'assets/js/components/jquery-wizard.min.js"></script>';

		if($this->session->userdata('LOGGED')){
			if($this->content==""){
				redirect(site_url(),'refresh');
			}
			$data = array('_title_' 	  => 'BOS',
						  '_headers_' 	  => $headers,
						  '_header_' 	  => $this->load->view('content/header','',true),
						  '_menus_'		  => $this->load->view('content/menus','',true),
						  '_breadcrumbs_' => $this->load->view('content/breadcrumbs','',true),
						  '_content_' 	  => (grant()=="")?$this->load->view('content/error','',true):$this->content,
						  '_footers_' 	  => $footers,
						  '_footer_' 	  => $this->load->view('content/menus','',true));
			$this->parser->parse('index', $data);
		}else{
			redirect(base_url('index.php'),'refresh');
		}
	}

	public function opr(){
		if (!$this->session->userdata('LOGGED')){
			$this->index();
			return;
		}
			$this->newtable->breadcrumb('Menu Handheld', site_url('operation/opr'));
			$data['title'] = 'Menu Handheld';
			$data['usernya'] = $this->session->userdata('KD_GROUP');
			$data['jumlahmarshcic'] = $this->M_operation->datajumlahmarshallingcic();
			$data['jumlahmarshyard'] = $this->M_operation->datajumlahmarshallingyard();
			$data['jumlah'] = $this->M_operation->getalldelivery();
		$this->content = $this->load->view('content/operation/index',$data,true);
		$this->index();
	}

	public function pickup(){
		if (!$this->session->userdata('LOGGED')){
			$this->index();
			return;
		}
  		$this->newtable->breadcrumb('Handheld', site_url('operation/opr'));
		$this->newtable->breadcrumb('Pick Up', 'javascript:void(0)');
		$data['title'] = 'Menu Handheld';
		//proses pickup
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('nomerspk','NO SPK', 'required');
			if ($this->form_validation->run() === false) {
				$this->content = $this->load->view('content/operation/pickup',$data,true);
				$this->index();
			}else{
				$this->M_operation->set_pickup();
				// 	redirect('Operation/pickup');
			}
	}

	public function search_pickup(){
		$this->newtable->breadcrumb('Handheld', site_url('operation/opr'));
		$this->newtable->breadcrumb('pick up', 'javascript:void(0)');
		$ss=date('y');
		$keyword    =  "ITPK-".$ss."/".$this->input->post('search_spk');
		$re = $this->M_operation->cek_tspk3($keyword);
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

	public function behandlein(){
			if (!$this->session->userdata('LOGGED')){
				$this->index();
				return;
			}
			$this->newtable->breadcrumb('Handheld', site_url('operation/opr'));
			$this->newtable->breadcrumb('behandle in', 'javascript:void(0)');
			$this->load->helper('form');
			$this->load->library('form_validation');
			$this->form_validation->set_rules('nomerkon','No Cont', 'required');
				if ($this->form_validation->run() ===false) {
					$this->content = $this->load->view('content/operation/inspection',$data,true);
					$this->index();
				}else{
					$this->M_operation->set_inspection();
					// redirect('Operation/behandlein');
				}
	}

	public function search_behandle(){
		$this->newtable->breadcrumb('Handheld', site_url('operation/opr'));
		$this->newtable->breadcrumb('Behandle in', 'javascript:void(0)');
        $keyw    = $this->input->post('search_cont');
		$keyword = strtoupper($keyw);
		$re  	 = $this->M_operation->searchb22($keyword);
		$dan 	= $re->result_array();
		if (count($dan)==0) {
			$data['status']=0;
			$data['nilai']=$keyword;
			$data['kode']=1;
			$this->content = $this->load->view('content/operation/inspection',$data,true);
			$this->index();
		}else {
			$data['nilai']=$re;
			$data['status']=2;
			$data['kondisi']=$kondis;
			$this->content = $this->load->view('content/operation/inspection',$data,true);
			$this->index();
		}
    }

    public function search_behandlein(){
		$this->newtable->breadcrumb('Handheld', site_url('operation/opr'));
		$this->newtable->breadcrumb('Behandle in', 'javascript:void(0)');
        $keyword   	= $this->input->post('submitman2');
		$re  		= $this->M_operation->search($keyword);
		$reftruck	= $this->M_operation->ambiltruck2($re['ID_FLAT']);
		$kondis 	= $this->M_operation->ambilkondisi();
		if (count($re)==0) {
			$data['status']=0;
			$data['nilai']=$keyword;
			$data['kode']=1;
			$this->content = $this->load->view('content/operation/inspection',$data,true);
			$this->index();
		}else {
			$data['nilai']=$re;
			$data['truck']=$reftruck;
			$data['status']=1;
			$data['kondisi']=$kondis;
			$this->content = $this->load->view('content/operation/inspection',$data,true);
			$this->index();
		}
    }

	public function hold(){
		if (!$this->session->userdata('LOGGED')){
			$this->index();
			return;
		}
		$this->newtable->breadcrumb('Handheld', site_url('operation/opr'));
		$this->newtable->breadcrumb('Hold', 'javascript:void(0)');
				//proses pickup
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('nomerspk','NO SPK', 'required');
		if ($this->form_validation->run() ===false) {
			$this->content = $this->load->view('content/operation/hold',$data,true);
			$this->index();
		}else{
			$this->M_operation->set_hold();
			// redirect('Operation/hold');
		}
	}

	public function marshallingcic(){
		if (!$this->session->userdata('LOGGED')){
			$this->index();
			return;
		}
		$this->newtable->breadcrumb('Handheld', site_url('operation/opr'));
		$this->newtable->breadcrumb('Marshalling', 'javascript:void(0)');
		$data['nilai'] = $this->M_operation->getalljobscic();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('jobs','NO JOB SLIP', 'required');
		if($this->form_validation->run() ===false) {
			$this->content = $this->load->view('content/operation/marshallingcic',$data,true);
			$this->index();
		}else{
			$this->M_operation->set_marshalling_cic();
		}
	}

	public function search_cic(){
		$this->newtable->breadcrumb('Handheld', site_url('operation/opr'));
		$this->newtable->breadcrumb('Marshalling', 'javascript:void(0)');
		$keyword    =   $this->input->post('search_js');
		$re  		=  $this->M_operation->ambilmarshcic($keyword,$job);
		if (count($re)==0) {
			$data['status']!=1;
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
		$this->newtable->breadcrumb('Handheld', site_url('operation/opr'));
		$this->newtable->breadcrumb('Marshalling', 'javascript:void(0)');
		$data['nilai'] = $this->M_operation->getalljobsyard();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('jobs','NO JOB SLIP', 'required');
		if($this->form_validation->run() ===false) {
			$this->content = $this->load->view('content/operation/marshallingyard',$data,true);
			$this->index();
		}else{
			$this->M_operation->set_marshalling_yard();
		}
	}

	public function search_yard(){
		$this->newtable->breadcrumb('Handheld', site_url('operation/opr'));
		$this->newtable->breadcrumb('Marshalling', 'javascript:void(0)');
			$keyword    =   $this->input->post('search_js');
			$re  		=  $this->M_operation->ambilmarshyard($keyword,$job);
			if (count($re)==0) {
				$data['status']!=1;
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
		$this->newtable->breadcrumb('Handheld', site_url('operation/opr'));
		$this->newtable->breadcrumb('Pemeriksaan Behandle', 'javascript:void(0)');
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('nomerkon','No Cont', 'required');
		if ($this->form_validation->run() === false) {
			$this->content = $this->load->view('content/operation/realisasibi',$data,true);
			$this->index();
		}else{
			$this->M_operation->set_pemeriksaan();
			// redirect('Operation/opr');
		}
	}

	public function search_realis(){
		$this->newtable->breadcrumb('Handheld', site_url('operation/opr'));
		$this->newtable->breadcrumb('Pemeriksaan Behandle', 'javascript:void(0)');
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
		$this->newtable->breadcrumb('Handheld', site_url('operation/opr'));
		$this->newtable->breadcrumb('Pemeriksaan Behandle', 'javascript:void(0)');
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
				// print_r($start);die();

				if ($start['START_INSP']==NULL) {
					$data['kond']=0;
				}elseif ($start['FINISH_INSP']==NULL) {
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
		
		$this->newtable->breadcrumb('Handheld', site_url('operation/opr'));
		$this->newtable->breadcrumb('Delivery', 'javascript:void(0)');
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('nomercont','No Cont', 'required');
			if ($this->form_validation->run() === false) {
				$this->content = $this->load->view('content/operation/delivery',$data,true);
				$this->index();
			}else{
				$this->M_operation->set_delivery();
				// redirect('Operation/opr');
			}
	}

	public function search_delivery(){
		$this->newtable->breadcrumb('Handheld', site_url('operation/opr'));
		$this->newtable->breadcrumb('Delivery', 'javascript:void(0)');
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
		$this->newtable->breadcrumb('Handheld', site_url('operation/opr'));
		$this->newtable->breadcrumb('delivery', 'javascript:void(0)');
		$keyword    =   $this->input->post('submitman2');
		$cari= $this->M_operation->searchdeliv2($keyword);
		$del =   $this->M_operation->searchdeliv($keyword);
		$kondis= $this->M_operation->ambilkondisi()->result_array();;
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

	public function chases(){
		if (!$this->session->userdata('LOGGED')){
			$this->index();
			return;
		}
		$this->newtable->breadcrumb('Handheld', site_url('operation/opr'));
		$this->newtable->breadcrumb('Onchassis', 'javascript:void(0)');

		$data['nilai'] = $this->M_operation->getalldelivery();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('nomercont','NO CONT', 'required');
		if ($this->form_validation->run() ===false) {
			$this->content = $this->load->view('content/operation/onchases',$data,true);
			$this->index();
		}else{
			$this->M_operation->set_onchases();
			// redirect('Operation/opr');
		}
	}

	public function search_chases(){
		$this->newtable->breadcrumb('Handheld', site_url('operation/opr'));
		$this->newtable->breadcrumb('delivery', 'javascript:void(0)');
		$keyword    =   $this->input->post('search_ch');
		$dat= $this->M_operation->ambilchases("$keyword");
			if (count($dat)==0){
				$data['status']=0;
				$data['NOCONT']=$keyword;
				$data['kode']=1;
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
	
	public function copy(){
		if (!$this->session->userdata('LOGGED')){
			$this->index();
			return;
		}
		$this->newtable->breadcrumb('Handheld', site_url('operation/opr'));
		$this->newtable->breadcrumb('Copyyard', 'javascript:void(0)');
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
			
	public function search_copy(){
		$this->newtable->breadcrumb('Handheld', site_url('operation/opr'));
		$this->newtable->breadcrumb('Copyyard', 'javascript:void(0)');
		$NO_CONT = strtoupper($this->input->post('search_cont'));
        $SPK_CEK = $this->M_operation->searchop($NO_CONT);

		if (count($SPK_CEK) > 0) {
			$data['nilai']  = $SPK_CEK;
			$data['status'] = 2;
			$this->content  = $this->load->view('content/operation/copy',$data,true);
			$this->index();
		}else {
			$data['NOCONT']  = $NO_CONT;
			$data['notif'] = 2;
			$this->content  = $this->load->view('content/operation/copy',$data,true);
			$this->index();
		}
	}
	
	public function search_copyard(){
		$this->newtable->breadcrumb('Handheld', site_url('operation/opr'));
		$this->newtable->breadcrumb('Copyyard', 'javascript:void(0)');
		$NO_CONT    = strtoupper($this->input->post('submitman'));
		$SPK_CEK    = $this->M_operation->searchop2($NO_CONT);
		if($SPK_CEK[0]['STATUS_CONT'] == '300'){
			$data['status'] = 0;
			$data['nilai']  = $NO_CONT;
			$data['kode']  	= 4;
			$this->content 	= $this->load->view('content/operation/copy',$data,true);
			$this->index();
		}else if($SPK_CEK[0]['STATUS_CONT'] == '400'){
			$data['status'] = 0;
			$data['nilai']  = $NO_CONT;
			$data['kode']  	= 5;
			$this->content 	= $this->load->view('content/operation/copy',$data,true);
			$this->index();
		}else{
			$data['nilai']  = $SPK_CEK[0];
			$data['status'] = 1;
			$this->content  = $this->load->view('content/operation/copy',$data,true);
			$this->index();
		}
	}

	public function search_inspect(){
		$this->newtable->breadcrumb('Handheld', site_url('operation/opr'));
		$this->newtable->breadcrumb('', 'javascript:void(0)');
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

	public function searchdeliveryinspect(){
		$this->newtable->breadcrumb('Handheld', site_url('operation/opr'));
		$this->newtable->breadcrumb('inspection out', 'javascript:void(0)');
			$keyword    =   $this->input->post('submitman2');
			$cari	= $this->M_operation->searchdeliv2($keyword);
			$del 	= $this->M_operation->searchdeliv($keyword);
			$kondis	= $this->M_operation->ambilkondisi()->result_array();;
			
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
				
	public function inspect(){
		if (!$this->session->userdata('LOGGED')){
			$this->index();
			return;
		}
		
		$this->newtable->breadcrumb('Handheld', site_url('operation/opr'));
		$this->newtable->breadcrumb('Inspection Out', 'javascript:void(0)');
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('nomercont','No Cont', 'required');
			if ($this->form_validation->run() === false) {
				$this->content = $this->load->view('content/operation/inspectout',$data,true);
				$this->index();
			}else{
				$this->M_operation->set_inspect();
				// redirect('Operation/opr');
			}
	}

//end class
}
