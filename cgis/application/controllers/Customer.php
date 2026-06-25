<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Customer extends CI_Controller {
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

	public function simulasi_billing($act,$id){
		if (!$this->session->userdata('LOGGED')){
			$this->index();
			return;
		}
		$id = ($id!="")?$id:$this->input->post('id');
		if($act=="add"){
			$data['id'] = $id;
			$data['title'] = 'Billing Delivery';
			$data['action'] = "save";
			$this->load->model("m_execute");
			$data['arrdata'] = $this->m_execute->get_data_dokumen('sppb', $id);
			//print_r($data);die();
			$data['detail_cont'] = $this->m_execute->get_data_dokumen('detail_sppb', $id);
			//var_dump($data);die();
			$this->load->view('content/billing/simulasi/form', $data);
		}else{
			if (!$this->session->userdata('LOGGED')){
				$this->index();
				return;
			}
			/*$this->load->model("m_billing");
			$arrdata = $this->m_billing->simulasi_dok_sppb($act, $id);
			$data = $this->load->view('content/billing/delivery', $arrdata, true);
			if($this->input->post("ajax")||$act=="post"){
				return $arrdata;
			}else{
				$this->content = $data;
				$this->index();
			}*/

			$data = $this->load->view('content/billing/simulasi/search', $arrdata, true);
			if($this->input->post("ajax")||$act=="post"){
				echo $arrdata;
			}else{
				$this->content = $data;
				$this->index();
			}
		}
	}

	public function info_billing($act,$id){
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
			$this->load->view('content/billing/behandle/tbehandle2', $data);
		}else if($act == 'confirm'){
			//print_r($id);die;
			$data['id'] = $id;
			$data['title'] = 'Billing Delivery';
			$data['action'] = "save";
			$this->load->model("m_execute");
			$DATA_HDR['NO_NOTA_BEHANDLE'] = '010.000-16.65000005';
			$DATA_HDR['TGL_NOTA'] =  date('Y-m-d H:i:s');
			//$DATA_HDR['PAID_STATUS'] =  "DONE";
			$this->db->where(array('ID_REQ' => $id));
			$this->db->update('req_behandle_hdr', $DATA_HDR);
			echo "Berhasil";
			//$this->load->view('content/billing/delivery/confirmation');
		}else{
			$this->load->model("M_customer");
			$arrdata = $this->M_customer->info_billing($act, $id);
			$data = $this->load->view('content/newtable', $arrdata, true);
				if($this->input->post("ajax")||$act=="post"){
					return $arrdata;
				}else{
					$this->content = $data;
					$this->index();
					}
				}
		}

	public function tracking($act,$id){
		if (!$this->session->userdata('LOGGED')){
			$this->index();
			return;
		}
		$id = ($id!="")?$id:$this->input->post('id');
		if ($act=="detail") {
			//$data['title'] = 'ENTRY CUSTOMER';
			$data['id'] = $id;
//			print_r($id); die();
			$data['action'] = 'save';
			$this->load->model('m_customer');
			$data['result_cont'] = $this->m_customer->get_data('operation', $id);
			//print_r($data); die();
			echo $this->load->view('content/customer/detail_cont',$data,true);
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
			//var_dump($data);die();
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
			$data['title'] = 'Billing Delivery';
			$data['action'] = "save";
			$this->load->model("m_execute");
			$DATA_HDR['NO_NOTA_BEHANDLE'] = '010.000-16.65000005';
			$DATA_HDR['TGL_NOTA'] =  date('Y-m-d H:i:s');
			//$DATA_HDR['PAID_STATUS'] =  "DONE";
			$this->db->where(array('ID_REQ' => $id));
			$this->db->update('req_behandle_hdr', $DATA_HDR);
			echo "Berhasil";
			//$this->load->view('content/billing/delivery/confirmation');
		}else{
			$this->load->model("M_customer");
			$arrdata = $this->M_customer->tracking($act, $id);
			$data = $this->load->view('content/newtable', $arrdata, true);
				if($this->input->post("ajax")||$act=="post"){
					return $arrdata;
				}else{
					$this->content = $data;
					$this->index();
					}
				}
		}

	public function behandle1($act, $id){
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
				$data['detail'] = $this->detail($act,$id);
				echo $this->load->view('content/billing/detail_behandle',$data,true);
			}else if ($act=="add") {
				$data['title'] = 'Billing Behandle';
				$data['id'] = $id;
				$data['action'] = 'create';
				$this->load->model("m_billing");
				$data['behandle1'] = $this->tbehandle1($act, $id);
				$data['behandle2'] = $this->tbehandle2($act, $id);
				echo $this->load->view('content/billing/detail_behandle',$data,true);
			}else{
				$this->load->model("m_customer");
				$arrdata = $this->m_customer->behandle1($act, $id);
				$data = $this->load->view('content/newtable', $arrdata, true);
				if($this->input->post("ajax")||$act=="post"){
					return $arrdata;
				}else{
					$this->content = $data;
					$this->index();
				}
			}
		}

	public function behandle2($act, $id){
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
				$data['detail'] = $this->detail($act,$id);
				echo $this->load->view('content/billing/detail_behandle',$data,true);
			}else if ($act=="add") {
				$data['title'] = 'Billing Behandle';
				$data['id'] = $id;
				$data['action'] = 'create';
				$this->load->model("m_billing");
				$data['behandle1'] = $this->tbehandle1($act, $id);
				$data['behandle2'] = $this->tbehandle2($act, $id);
				echo $this->load->view('content/billing/detail_behandle',$data,true);
			}else{
				$this->load->model("m_customer");
				$arrdata = $this->m_customer->behandle2($act, $id);
				$data = $this->load->view('content/newtable', $arrdata, true);
				if($this->input->post("ajax")||$act=="post"){
					return $arrdata;
				}else{
					$this->content = $data;
					$this->index();
				}
			}
		}

	public function delivery($act, $id){
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
			$data['detail'] = $this->detail($act,$id);
			echo $this->load->view('content/billing/detail_behandle',$data,true);
		}else if ($act=="add") {
			$data['title'] = 'Billing Behandle';
			$data['id'] = $id;
			$data['action'] = 'create';
			$this->load->model("m_billing");
			$data['behandle1'] = $this->tbehandle1($act, $id);
			$data['behandle2'] = $this->tbehandle2($act, $id);
			echo $this->load->view('content/billing/detail_behandle',$data,true);
		}else{
			$this->load->model("m_customer");
			$arrdata = $this->m_customer->delivery($act, $id);
			$data = $this->load->view('content/newtable', $arrdata, true);
			if($this->input->post("ajax")||$act=="post"){
				return $arrdata;
			}else{
				$this->content = $data;
				$this->index();
			}
		}
	}
	//
	public function reprint($act,$id, $id2){
		if (!$this->session->userdata('LOGGED')){
			$this->index();
			return;
		}
		$id = ($id!="")?$id:$this->input->post('id');
		if($act=="add"){
			$data['title'] = 'GATE PASS DELIVERY';
			$data['id'] = $id;
			$data['action'] = 'create';
			$data['detail'] = $this->gatepass2_detail($act,$id);
			echo $this->load->view('content/newtable',$data,true);
		}else if($act=="save"){
		
		}else if($act=="update"){
			$data['title'] = 'GATE PASS DELIVERY';
			$data['id'] = $id;
			$data['action'] = 'update';
			$this->load->model("m_execute");
			$data['arrdata'] = $this->m_execute->get_data('gatepass2', $id);
			echo $this->load->view('content/newtable',$data,true);
		}else if($act=="associate"){
			$data['title'] = 'ASSOCIATE TRUCK';
			$data['id'] = $id;
			$data['action'] = 'update';
			$this->load->model("m_execute");
			$data['arrdata'] = $this->m_execute->get_data('gatepass2', $id);
			echo $this->load->view('content/gatepass/associate',$data,true);
		}else if($act=="add_gp_del"){
			$data['title'] = 'GATE PASS DELIVERY';
			$data['id'] = $id;
			$data['action'] = 'create';
			$data['detail'] = $this->gatepass_delivery_detail($act,$id);
			echo $this->load->view('content/gatepass/gate_pass_delivery',$data,true);
		}else if($act=="detail"){
			$data['title'] = 'GATE PASS DELIVERY';
			$data['id'] = $id;
			$data['action'] = 'update';
			$this->load->model("m_execute");
			$data['arrdata'] = $this->m_execute->get_data('gatepass_delivery', $id);
			echo $this->load->view('content/gatepass/gate_pass_delivery_detail',$data,true);
		}else if($act=="history"){
			$this->load->model("m_planning");
			$data['arrdata'] = $this->m_planning->get_data('history_gbe', $id);
			echo $this->content = $this->load->view('content/dokumen/history_cetak',$data,true);
		}else{
			$this->load->model("m_customer");
			$arrdata = $this->m_customer->gate_pass_delivery($act, $id);
			$data = $this->load->view('content/newtable', $arrdata, true);
			if($this->input->post("ajax")||$act=="post"){
				echo $arrdata;
			}else{
				$this->content = $data;
				$this->index();
			}
		}
	}
	//

	public function src($act, $id, $keyword){
		$this->load->model('M_billing');
		$this->newtable->breadcrumb('Customer', site_url('customer/simulasi_billing'));
		$this->newtable->breadcrumb('Simulasi Billing', 'javascript:void(0)');
		$keyword =  $this->input->post('search_js');
		$re  =  $this->M_billing->getSrch($keyword);
		//print_r($re);die();
		if ($re) {
			$data['no_dok'] = $keyword;
			$data['status']=1;
			$data['result']=$re;
			$data['jobs']=$keyword;

			$this->load->model("m_billing");
			$arrdata = $this->m_billing->simulasi_dok_sppb($act, $id, $keyword);
			$data = $this->load->view('content/billing/delivery', $arrdata, true);
			if($this->input->post("ajax")||$act=="post"){
				return $arrdata;
			}else{
				$this->content = $data;
				$this->index();
			}

			/**/
			//print_r($data);die();
			/*$this->content = $this->load->view('content/billing/simulasi/search',$data,true);
			$this->index();*/
		}else {
			$data['jobs']=$keyword;
			$data['status']=0;
			$data['kode']=1;
			$this->content = $this->load->view('content/billing/simulasi/search',$data,true);
			$this->index();
		}
	}
}
?>
