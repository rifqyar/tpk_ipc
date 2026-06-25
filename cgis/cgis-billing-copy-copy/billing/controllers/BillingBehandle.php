<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class BillingBehandle extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model("m_billing_behandle");
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

	public function behandle($act, $id){
		if (!$this->session->userdata('LOGGED')){
			$this->index();
			return;
		}
		$id = ($id!="")?$id:$this->input->post('id');

		$arrdata = $this->m_billing_behandle->behandle($act, $id);
		$data = $this->load->view('content/newtable', $arrdata, true);
		if($this->input->post("ajax")||$act=="post"){
			return $arrdata;
		}else{
			$this->content = $data;
			$this->index();
		}
	}

	public function behandle_add($act, $id){
		if (!$this->session->userdata('LOGGED')){
			$this->index();
			return;
		}
		$id = ($id!="")?$id:$this->input->post('id');

		$data['title'] = 'Billing Behandle';
		$data['id'] = $id;
		$data['behandle_spjm'] = $this->behandle_spjm($act, $id);
		$data['behandle_sppmp'] = $this->behandle_sppmp($act, $id);
		echo $this->load->view('content/billing/detail_behandle',$data,true);
	}

	public function behandlespjm_detail($act, $id){
		if (!$this->session->userdata('LOGGED')){
			$this->index();
			return;
		}
		$id = ($id!="")?$id:$this->input->post('id');

		$data['id'] = $id;
		$data['title'] = 'Billing';
		$data['arrdata'] = $this->m_billing_behandle->get_data_behandle_spjm($id);
		$this->load->view('content/billing/behandle/tbehandle1', $data);
	}

	public function behandlesppmp_detail($act, $id){
		if (!$this->session->userdata('LOGGED')){
			$this->index();
			return;
		}
		$id = ($id!="")?$id:$this->input->post('id');

		$data['id'] = $id;
		$data['title'] = 'Billing';
		$data['arrdata'] = $this->m_billing_behandle->get_data_behandle_sppmp($id);
		$this->load->view('content/billing/behandle/tbehandle2', $data);
	}

	public function behandle_spjm($act, $id){
		if (!$this->session->userdata('LOGGED')) {
			$this->index();
			return;
		}
		$id = ($id!="")?$id:$this->input->post('id');
		$arrdata = $this->m_billing_behandle->behandle_spjm($act, $id);
		$data = $this->load->view('content/newtable', $arrdata, true);
		if($this->input->post("ajax")||$act=="post"){
			return $arrdata;
		}else{
			return $data;
		}
	}

	public function behandle_sppmp($act, $id){
		if (!$this->session->userdata('LOGGED')) {
			$this->index();
			return;
		}
		$id = ($id!="")?$id:$this->input->post('id');
		$this->load->model("m_billing_behandle");
		$arrdata = $this->m_billing_behandle->behandle_sppmp($act, $id);
		$data = $this->load->view('content/newtable', $arrdata, true);
		if($this->input->post("ajax")||$act=="post"){
			return $arrdata;
		}else{
			return $data;
		}
	}

	public function cetak_nota_behandle($act, $id){
		if (!$this->session->userdata('LOGGED')) {
            $this->index();
            return;
        } 

		$id = ($id!="")?$id:$this->input->post('id');
		$data['id'] = $id;
		$this->load->library('mpdf');
		$this->load->model("m_execute");
		$sess = $this->session->userdata('NM_LENGKAP');
		$data['title'] = "".$sess; 
		$this->m_billing_behandle->history_cetak($id);
		$data['result'] = $this->m_billing_behandle->get_nota_behandle($id);
		$data['result_hdr'] = $this->m_billing_behandle->get_nota_behandle_hdr($id);
		$data['result_cust'] = $this->m_billing_behandle->get_nota_cust($id);
		$data['result_cont'] = $this->m_billing_behandle->get_nota_beh($id);
		$this->load->view('content/billing/cetak_nota_behandle', $data);
	}

	public function behandle_confirm($act, $id){
		if (!$this->session->userdata('LOGGED')) {
            $this->index();
            return;
        } 

		$id = ($id!="")?$id:$this->input->post('id');
		$data['id'] = $id;
		$data['title'] = 'REKENING BANK';
		$data['action'] = "save";
		$data['bank'] = $this->m_billing_behandle->get_data_bank();
		echo $this->content = $this->load->view('content/billing/behandle/confirm',$data,true);
	}

	public function behandle_history($act, $id){
		if (!$this->session->userdata('LOGGED')) {
            $this->index();
            return;
        } 

		$id = ($id!="")?$id:$this->input->post('id');
		$data['arrdata'] = $this->m_billing_behandle->get_history_behandle($id);
		echo $this->load->view('content/dokumen/history_cetak',$data,true);
	}

	public function behandle_update($act, $id){
		$arrid = explode("~", $this->input->post('id'));
		$id = $arrid[0];
		
		$data['id'] = $id;
		$data['action'] = "update";
		$cek['kegiatan'] = $this->m_billing_behandle->get_cek_behandle($id);
		if ($cek['kegiatan']->JNS_KEGIATAN == '1') {
			$data['title'] = "UPDATE BILLING BEHANDLE";
			$data['arrdata'] = $this->m_billing_behandle->get_data_behandle1($id);
			//print_r($data); die();
			$this->load->view('content/billing/behandle/behandle1', $data);
		}else{
			$data['title'] = "UPDATE BILLING BEHANDLE";
		 	$data['arrdata'] = $this->m_billing_behandle->get_data_behandle2($id);
		 	//print_r($data); die();
			$this->load->view('content/billing/behandle/behandle2', $data);
		}
	}

	public function process($act="", $id=""){
		$id = ($id!="")?$id:$this->input->post('id');
		if (!$this->session->userdata('LOGGED')) {
			$this->index();
			return;
		}else{
			if (strtolower($_SERVER['REQUEST_METHOD']) != "post") {
				echo 'access is forbidden'; exit();
			}else{
				$this->m_billing_behandle->process($type,$act,$id);
			}
		}
	}
	
	public function behandle_del($act, $id){
		if (!$this->session->userdata('LOGGED')){
			$this->index();
			return;
		}
		$arrpost = $this->input->post('tb_chktblbehandle');
		$exparrpost = explode('~',$arrpost[0]); 
		/* print_r($exparrpost); die(); */
		$id_req = $exparrpost[0];
		$no_dok = $exparrpost[1];
		$no_nota = $exparrpost[2];
		$key = $id_req."~".$no_dok."~".$no_nota;
		$this->m_billing_behandle->del_behandle($key);
	}
	
	public function behandle_resend($id){
		if (!$this->session->userdata('LOGGED')){
			$this->index();
			return;
		}
		foreach ($this->input->post('tb_chktblbehandle') as $CheckArr) {
			$ArrCheck 	= explode("~", $CheckArr);
			print_r($ArrCheck);
			$IdReq 		= $ArrCheck[0];
			$FlTrans	= $ArrCheck[3];
			$FlReceipt	= $ArrCheck[4];

			$this->m_billing_behandle->resend_behandle($IdReq, $FlTrans, $FlReceipt);
		}
	}
}

/* End of file BillingBehandle.php */
/* Location: ./application/controllers/BillingBehandle.php */