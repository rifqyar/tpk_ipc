<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Billing extends CI_Controller {
	public $content;

	public function __construct() {
        parent::__construct();
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
		if ($act=="detail_behandle") {
			$data['title'] = '';
			$data['id'] = $id;
			$data['action'] = 'create';
			$this->load->model("m_billing");
			$data['arrdata'] = $this->m_billing->behandle_detail($id);
			//var_dump($data);die();
			$data['detail'] = $this->detail($act,$id);
			echo $this->load->view('content/billing/detail_behandle',$data,true);
		}else if ($act=="add") {
			$data['title'] = 'Billing Behandle';
			$data['id'] = $id;
			$data['action'] = 'create';
			$this->load->model("m_billing");
			//echo "fdsfsfsd"; die();
		//		$this->load->model("m_execute");
			$data['behandle1'] = $this->tbehandle1($act, $id);
			$data['behandle2'] = $this->tbehandle2($act, $id);
			echo $this->load->view('content/billing/detail_behandle',$data,true);

			// $data['detail'] = $this->billing_detail($act,$id);
			// echo $this->load->view('content/gatepass/gate_pass',$data,true);
		}else if ($act=="behandle1_detail") {
			//print_r($id);die();
			$data['id'] = $id;
			$data['title'] = 'Billing';
			$data['action'] = "save";
			$this->load->model("m_execute");
			$data['arrdata'] = $this->m_execute->get_data_dokumen('spk', $id);
			$data['detail_cont'] = $this->m_execute->get_data_dokumen('spk_cont', $id);
			$this->load->view('content/billing/behandle/tbehandle1', $data);

		}elseif($act == "behandle2_detail"){
			$data['id'] = $id;
			$data['title'] = 'Billing';
			$data['action'] = "save";
			$this->load->model("m_execute");
			$data['arrdata'] = $this->m_execute->get_data_dokumen('gate', $id);
			// var_dump($data); die();
			$this->load->view('content/billing/behandle/tbehandle2', $data);

		}else if($act == 'confirm'){
			//print_r($id);die;
			$data['id'] = $id;
			$data['title'] = 'REKENING BANK';
			$data['action'] = "save";
			
			// $query = "SELECT LPAD(SEQUENCE+1,'6','0') SEQ, (SEQUENCE+1) SEQUE FROM m_generate_nota WHERE TYPE_NOTA = 'BEHANDLE'";
			// $rs = $this->db->query($query);
			// $data = $rs->row_array();
			// $seq = $data["SEQ"];
			// $seque = $data["SEQUE"];
			// $no_nota_behandle = '010.000-16.65'.$seq;

			// $query = "UPDATE m_generate_nota SET SEQUENCE = '$seque'
			// WHERE TYPE_NOTA = 'BEHANDLE'";
			// $this->db->query($query);
			
			$this->load->model("m_execute");
			// $DATA_HDR['NO_NOTA_BEHANDLE'] = $no_nota_behandle;//'010.000-16.65000005';
			// $DATA_HDR['TGL_NOTA'] =  date('Y-m-d H:i:s');
			// //$DATA_HDR['PAID_STATUS'] =  "DONE";
			// $this->db->where(array('ID_REQ' => $id));
			// $this->db->update('req_behandle_hdr', $DATA_HDR);
			// $this->m_execute->process('save','nota_confirm',$id);
			//echo "Berhasil";
			$data['bank'] = $this->m_execute->get_data('bank_data');
			//var_dump($data); die();
			echo $this->content = $this->load->view('content/billing/behandle/confirm',$data,true);
		}else if($act=="history"){
			$this->load->model("m_billing");
			$data['arrdata'] = $this->m_billing->get_data('history_behandle', $id);
			echo $this->load->view('content/dokumen/history_cetak',$data,true);
		}else if($act == "update"){
			$arrid = explode("~", $this->input->post('id'));

			if($arrid[2] != ''){
				echo "DATA TIDAK BISA DIUPDATE";die();
			}

			$id = $arrid[0];
			
			$data['id'] = $id;
			$data['action'] = "update";
			$this->load->model("m_execute");
			$cek['kegiatan'] = $this->m_execute->get_data_dokumen('cek_behandle', $id);
			if ($cek['kegiatan']->JNS_KEGIATAN == '1') {
				$data['title'] = "UPDATE BILLING BEHANDLE";
				$data['arrdata'] = $this->m_execute->get_data_dokumen('behandle1', $id);
				//print_r($data); die();
				$this->load->view('content/billing/behandle/behandle1', $data);
			}else{
				$data['title'] = "UPDATE BILLING BEHANDLE";
			 	$data['arrdata'] = $this->m_execute->get_data_dokumen('behandle2', $id);
			 	//print_r($data); die();
				$this->load->view('content/billing/behandle/behandle2', $data);
			}
		}else{
			$this->load->model("m_billing");
			$arrdata = $this->m_billing->behandle($act, $id);
			$data = $this->load->view('content/newtable', $arrdata, true);
			if($this->input->post("ajax")||$act=="post"){
				return $arrdata;
			}else{
				$this->content = $data;
				$this->index();
			}
		}
	}

	public function cetak_nota_behandle($act, $id){
		if (!$this->session->userdata('LOGGED')) {
            $this->index();
            return;
        } 
		
		//echo "sini";die();
		//print_r($_POST);die();
		$id = ($id!="")?$id:$this->input->post('id');
		$this->load->model("m_execute");
		$data['id'] = $id;
		$data['title'] = "Nota Billing Behandle";
		$data['result'] = $this->m_execute->get_data('nota_behandle',$id);
		$data['result_hdr'] = $this->m_execute->get_data('nota_behandle_hdr',$id);
		$data['result_cont'] = $this->m_execute->get_data('nota_beh',$id);
		$this->load->view('content/billing/cetak_nota_behandle', $data);
	}
	
	function tbehandle1($act, $id){
		if (!$this->session->userdata('LOGGED')) {
			$this->index();
			return;
		}
		$id = ($id!="")?$id:$this->input->post('id');
		$this->load->model("m_billing");
		$arrdata = $this->m_billing->tbehandle1($act, $id);
		$data = $this->load->view('content/newtable', $arrdata, true);
		if($this->input->post("ajax")||$act=="post"){
			return $arrdata;
		}else{
			return $data;
		}
	}

	function tbehandle2($act, $id){
		if (!$this->session->userdata('LOGGED')) {
			$this->index();
			return;
		}
		$id = ($id!="")?$id:$this->input->post('id');
		$this->load->model("m_billing");
		$arrdata = $this->m_billing->tbehandle2($act, $id);
		$data = $this->load->view('content/newtable', $arrdata, true);
		if($this->input->post("ajax")||$act=="post"){
			return $arrdata;
		}else{
			return $data;
		}
	}

	public function billing_detail($act, $id){
		if (!$this->session->userdata('LOGGED')){
			$this->index();
			return;
		}
		$id = ($id!="")?$id:$this->input->post('id');
		$this->load->model("m_billing");
		$arrdata = $this->m_billing->behandle_add($act, $id);
		$data = $this->load->view('content/newtable', $arrdata, true);
		if($this->input->post("ajax")||$act=="post"){
			echo $arrdata;
		}else{
			return $data;
		}
	}

	public function delivery($act, $id){
		if (!$this->session->userdata('LOGGED')){
			$this->index();
			return;
		}
		$id = ($id!="")?$id:$this->input->post('id');
		if($act == 'add'){
			$data['title'] = 'DOKUMEN SPPB';
			$data['id'] = $id;
			$data['action'] = 'create';
			$this->load->model("m_billing");
			$data['detail'] = $this->detail_sppb($act,$id);
			echo $this->load->view('content/newtable',$data,true);
		}else if($act == 'save_delivery'){
			//print_r($id);die;
			$data['id'] = $id;
			$data['title'] = 'Billing Delivery';
			$data['action'] = "save";
			$this->load->model("m_execute");
			$data['arrdata'] = $this->m_execute->get_data_dokumen('sppb', $id);
			$data['detail_cont'] = $this->m_execute->get_data_dokumen('detail_sppb', $id);
			//var_dump($data['detail_cont']);die();
			$this->load->view('content/billing/delivery/form_add', $data);
		}else if($act == 'confirm'){
			$data['id'] = $id;
			$data['title'] = 'REKENING BANK';
			$data['action'] = "save";						
			$this->load->model("m_execute");
			$data['bank'] = $this->m_execute->get_data('bank_data');
			echo $this->content = $this->load->view('content/billing/delivery/confirm',$data,true);
			//$this->m_execute->process('save','confirm_delivery',$id);
		}else if($act=="history"){
			$this->load->model("m_billing");
			$data['arrdata'] = $this->m_billing->get_data('history_delivery', $id);
			echo $this->content = $this->load->view('content/dokumen/history_cetak',$data,true);
		}else if($act == "update"){
			$arrid = explode("~", $this->input->post('id'));
			if($arrid[2] != ''){
				echo "DATA TIDAK BISA DIUPDATE";die();
			}
			$id = $arrid[0];
			
			$data['title'] = "UPDATE BILLING DELIVERY";
			$data['id'] = $id;
			$data['action'] = "update";
			$this->load->model("m_execute");
			$data['arrdata'] = $this->m_execute->get_data_dokumen('delivery', $id);
			$data['detail_cont'] = $this->m_execute->get_data_dokumen('delivery_dtl', $id);
			$this->load->view('content/billing/delivery/delivery', $data);
		}else if($act == "hapus"){
			
			$arrpost = $this->input->post('tb_chktbldelivery');
			$exparrpost = explode('~',$arrpost[0]);
			$id_req = $exparrpost[0];
			$no_dok = $exparrpost[1];
			$key = $id_req."~".$no_dok;
			$this->load->model('m_billing');
			$this->m_billing->execute($act,'delivery',$key);
		}else{
			$this->load->model("m_billing");
			$arrdata = $this->m_billing->delivery($act, $id);
			$data = $this->load->view('content/newtable', $arrdata, true);
			if($this->input->post("ajax")||$act=="post"){
				return $arrdata;
			}else{
				$this->content = $data;
				$this->index();
			}
		}
	}

	public function detail_sppb($act, $id){
		if (!$this->session->userdata('LOGGED')){
			$this->index();
			return;
		}
		$id = ($id!="")?$id:$this->input->post('id');
		$this->load->model("m_billing");
		$arrdata = $this->m_billing->delivery_add($act, $id);
		$data = $this->load->view('content/newtable', $arrdata, true);
		if($this->input->post("ajax")||$act=="post"){
			echo $arrdata;
		}else{
			return $data;
			//$this->index();
		}
	}

	function cetak_nota_del($type, $act, $id) {
        if (!$this->session->userdata('LOGGED')) {
            $this->index();
            return;
        }
		
		//$id = ($id!="")?$id:$this->input->post('id');
		$arrid = explode('~',$this->input->post('id'));
		$id = $arrid[0];
		//print_r($id);die();
		$this->load->model("m_execute");

		$data['title'] = "Billing Nota";

		$data['result'] = $this->m_execute->get_data('nota_del',$id);
		$data['result_hdr'] = $this->m_execute->get_data('nota_del_hdr',$id);
		$data['result_cust'] = $this->m_execute->get_data('nota_cust',$id);//print_r($data['result_cust']);die();
		$data['result_cont'] = $this->m_execute->get_data('nota_cont',$id);
		
		//var_dump($data);die();
		$this->load->view('content/billing/delivery/simulasi', $data);

    }

	function cetak_nota_ext($type, $act, $id) {
        if (!$this->session->userdata('LOGGED')) {
            $this->index();
            return;
        }

		$id = ($id!="")?$id:$this->input->post('id');
		$this->load->model("m_execute");
		$data['title'] = "Billing Nota";
		$data['result'] = $this->m_execute->get_data('nota_del',$id);
		$data['result_hdr'] = $this->m_execute->get_data('nota_del_hdr',$id);
		$data['result_cust'] = $this->m_execute->get_data('nota_cust',$id);
		$data['result_cont'] = $this->m_execute->get_data('nota_cont',$id);
		//print_r($data['result_cont']);die();
		$this->load->view('content/billing/delivery_ext/simulasi', $data);

    }

	public function delivery_ext($act, $id){
		if (!$this->session->userdata('LOGGED')){
			$this->index();
			return;
		}
		$id = ($id!="")?$id:$this->input->post('id');
		if($act == 'add'){
			//$data['title'] = 'Dokumen SPPB';
			$data['id'] = $id;
			$data['action'] = 'create';
			$this->load->model("m_billing");
			//$data['arrdata'] = $this->m_billing->behandle_detail($id);
			//var_dump($data);die();
			$data['detail'] = $this->detail_sppb_ext($act,$id);
			echo $this->load->view('content/billing/delivery_ext/detail_delivery',$data,true);
			//$this->load->view('content/billing/delivery/detail_delivery', $data);
		}else if($act == 'save_delivery'){
			//print_r($id);die;
			$data['id'] = $id;
			//$data['title'] = 'Billing Delivery Ext';
			$data['action'] = "save";
			$this->load->model("m_execute");
			$data['arrdata'] = $this->m_execute->get_data_dokumen('delivery_hdr', $id);
			//var_dump($data);die();
			$data['detail_cont'] = $this->m_execute->get_data_dokumen('delivery_dtl', $id);
			//var_dump($data);die();
			$this->load->view('content/billing/delivery_ext/form_add', $data);
		}else if($act == 'confirm'){
			$data['id'] = $id;
			$data['title'] = 'REKENING BANK';
			$data['action'] = "save";
			$this->load->model("m_execute");
			$data['bank'] = $this->m_execute->get_data('bank_data');
			echo $this->content = $this->load->view('content/billing/delivery_ext/confirm',$data,true);
		}else if($act == 'history'){
			//var_dump($id);die();
			$this->load->model("m_billing");
			$data['arrdata'] = $this->m_billing->get_data('history_ext', $id);
			echo $this->content = $this->load->view('content/dokumen/history_cetak',$data,true);
		}else if($act == "update"){
			$arrid = explode("~", $this->input->post('id'));
			if($arrid[2] != ''){
				echo "DATA TIDAK BISA DIUPDATE";die();
			}
			$id = $arrid[0];
			
			$data['title'] = "UPDATE BILLING DELIVERY";
			$data['id'] = $id;
			$data['action'] = "update";
			$this->load->model("m_execute");
			$data['arrdata'] = $this->m_execute->get_data_dokumen('delivery', $id);
			//print_r($data);die();
			$this->load->view('content/billing/delivery/delivery', $data);
		}else {
			$this->load->model("m_billing");
			$arrdata = $this->m_billing->delivery_ext($act, $id);
			$data = $this->load->view('content/newtable', $arrdata, true);
			if($this->input->post("ajax")||$act=="post"){
				return $arrdata;
			}else{
				$this->content = $data;
				$this->index();
			}
		}
	}

	public function detail_sppb_ext($act, $id){
		if (!$this->session->userdata('LOGGED')){
			$this->index();
			return;
		}
		$id = ($id!="")?$id:$this->input->post('id');
		$this->load->model("m_billing");
		$arrdata = $this->m_billing->delivery_ext_add($act, $id);
		$data = $this->load->view('content/newtable', $arrdata, true);
		if($this->input->post("ajax")||$act=="post"){
			echo $arrdata;
		}else{
			return $data;
			//$this->index();
		}
	}

	function execute($type="", $act="", $id="", $met="") {
		$id = ($id!="")?$id:$this->input->post('id');
		//print_r($id);die();
        if (!$this->session->userdata('LOGGED')) {
            $this->index();
            return;
        } else {
            if (strtolower($_SERVER['REQUEST_METHOD']) != "post") {
                redirect(base_url());
                exit();
            } else {
                $this->load->model("m_planning");
                $this->m_billing->execute($type, $act, $id, $met);
            }
        }
    }
	
	function cetak_simulasi($type, $act, $id) {
        if (!$this->session->userdata('LOGGED')) {
            $this->index();
            return;
        } 
		
		$id = $this->db->query("SELECT MAX(ID_REQ) AS ID FROM req_simulasi_hdr")->row()->ID;
		//print_r("ID Simulasi ".$id);//die();
		$this->load->model("m_execute");
		
		$data['title'] = "Billing Nota";
		
		$data['result'] = $this->m_execute->get_data('nota_simulasi',$id);
		//print_r($data);die();

		$data['result_hdr'] = $this->m_execute->get_data('nota_simulasi_hdr',$id);
		$data['result_cust'] = $this->m_execute->get_data('nota_simulasi_cust',$id);

		$data['result_cont'] = $this->m_execute->get_data('nota_simulasi_cont',$id);
		//var_dump($data);die();
		$this->load->view('content/billing/simulasi/simulasi', $data);
        
    }

}
