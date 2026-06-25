<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Planning extends CI_Controller {
	public $content;

	public function __construct() {
        parent::__construct();
        $this->load->model("m_planning");
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

	public function shipment($act,$id){
		if (!$this->session->userdata('LOGGED')){
			$this->index();
			return;
		}
		$id = ($id!="")?$id:$this->input->post('id');
		if($act=="add"){
			/*echo "string";die();*/
			$data['title'] = 'ENTRY KAPAL';
			$data['id'] = '';
			$data['action'] = 'save';
			echo $this->load->view('content/kapal/form_add',$data,true);
		}else if($act=="update"){
			//echo "string";die();
			//print_r($id);die();
			$data['title'] = 'UPDATE KAPAL';
			$data['id'] = $id;
			$data['action'] = 'update';
			$this->load->model("m_execute");
			$data['arrdata'] = $this->m_execute->get_data('kapal', $id);
			//var_dump($data);die();
			echo $this->load->view('content/kapal/form_add',$data,true);
		}else if($act=="release"){
			//echo "Sini";die();
			//print_r($id);die();
			$data['title'] = 'REALISASI KAPAL';
			$data['id'] = $id;
			$data['action'] = 'update';
			$this->load->model("m_execute");
			$data['arrdata'] = $this->m_execute->get_data('kapal_release', $id);
			$data['jadwal'] = $this->jadwal_kapal($act, $id);
			//var_dump($data);die();
			echo $this->load->view('content/kapal/release',$data,true);
		}else if($act=="delete"){
			/*$data['title'] = 'DELETE KAPAL';
			$data['id'] = $id;
			$data['action'] = 'update';
			$this->load->model("m_execute");
			$data['arrdata'] = $this->m_execute->get_data('kapal', $id);
			//var_dump($data);die();
			echo $this->load->view('content/kapal/form_add',$data,true);*/
		}else if($act=="detail"){
			$this->newtable->breadcrumb('Kapal', site_url());
			$this->newtable->breadcrumb('Planning', 'javascript:void(0)');
			$this->newtable->breadcrumb('Kapal', site_url('planning/spjm'));
			$this->newtable->breadcrumb('Detail', 'javascript:void(0)');
			$data['title'] = 'DETAIL KAPAL';
			$data['id'] = $id;
			//print_r($id);die();
			$this->load->model("m_execute");
			$data['arrdata'] = $this->m_execute->get_data_dokumen('detail_kapal', $id);
			//print_r($data);die();
			echo $this->content = $this->load->view('content/kapal/detail_kapal',$data,true);
			//$this->index();
		}else{
			$this->load->model("m_planning");
			$arrdata = $this->m_planning->shipment($act, $id);
			$data = $this->load->view('content/newtable', $arrdata, true);
			if($this->input->post("ajax")||$act=="post"){
				echo $arrdata;
			}else{
				$this->content = $data;
				$this->index();
			}
		}
	}


	public function gate_pass_behandle($act,$id, $id2){
		if (!$this->session->userdata('LOGGED')){
			$this->index();
			return;
		}
		
		$id = ($id!="")?$id:$this->input->post('id');
		if($act=="add"){
			$data['title'] = 'GATE PASS BEHANDLE';
			$data['id'] = $id;
			$data['action'] = 'create';
			$this->load->model("m_billing");
			$data['detail'] = $this->gatepass_detail($act,$id);
			echo $this->load->view('content/gatepass/gate_pass',$data,true);
		}else if($act=="active_gatepass"){
			$this->load->model("m_execute");
			$data['arrdata'] = $this->m_execute->cek_data('active_gatepass', $id);
		}else if($act=="update"){
			$exarrid = explode("~",$id);
			$nm_kapal = $exarrid[0];
			$no_cont = $exarrid[1];
			$data['title'] = 'GATE PASS BEHANDLE';
			$data['id'] = $id;
			$data['action'] = 'update';
			$this->load->model("m_execute");
			$data['arrdata'] = $this->m_execute->get_data('gatepass', $id);
			echo $this->load->view('content/gatepass/detail',$data,true);
		}else if($act=="update_gatepass"){
			$data['title'] = 'UPDATE GATE PASS BEHANDLE 1';
			$data['id'] = $id;
			$data['action'] = 'gatepass_edit';
			$this->load->model("m_execute");
			$data['arrdata'] = $this->m_execute->get_data('gatepass_edit', $id);
			echo $this->load->view('content/gatepass/gatepass_edit',$data,true);
		}else if($act=="delete_gatepass"){
			foreach ($this->input->post('tb_chktblgate') as $CheckArr) {
				$id = $CheckArr;
			}
			$this->load->model("m_execute");
			$data['arrdata'] = $this->m_execute->cek_data('delete_gatepass', $id);
		}else if($act=="history"){
			$this->load->model("m_planning");
			$data['arrdata'] = $this->m_planning->get_data('history_gbe', $id);
			echo $this->content = $this->load->view('content/dokumen/history_cetak',$data,true);
		}else{
			$this->load->model("m_planning");
			$arrdata = $this->m_planning->gate_pass_behandle($act, $id);
			$data = $this->load->view('content/newtable', $arrdata, true);
			if($this->input->post("ajax")||$act=="post"){
				echo $arrdata;
			}else{
				$this->content = $data;
				$this->index();
			}
		}
	}


	public function gate_pass_behandle2($act,$id, $id2){
		if (!$this->session->userdata('LOGGED')){
			$this->index();
			return;
		}
		$id = ($id!="")?$id:$this->input->post('id');
		if($act=="add"){
			$data['title'] = 'GATE PASS BEHANDLE 2';
			$data['id'] = $id;
			$data['action'] = 'create';
			$data['detail'] = $this->gatepass2_detail($act,$id);
			echo $this->load->view('content/newtable',$data,true);
		}else if($act=="update"){
			$data['title'] = 'GATE PASS BEHANDLE 2';
			$data['id'] = $id;
			$data['action'] = 'update';
			$this->load->model("m_execute");
			$data['arrdata'] = $this->m_execute->get_data('gatepass2', $id);
			$data['spk'] = $this->m_execute->get_data('spk_data', $data);
			echo $this->load->view('content/gatepass/detail2',$data,true);
		}else if($act=="history"){
			$this->load->model("m_planning");
			$data['arrdata'] = $this->m_planning->get_data('history_gbe', $id);
			echo $this->content = $this->load->view('content/dokumen/history_cetak',$data,true);
		}else if($act=="delete_gatepass"){
			foreach ($this->input->post('tb_chktblkapallist') as $CheckArr) {
				$id = $CheckArr;
			}
			$this->load->model("m_execute");
			$data['arrdata'] = $this->m_execute->cek_data('delete_gatepass', $id);
		}else{
			$this->load->model("m_planning");
			$arrdata = $this->m_planning->gate_pass_behandle2($act, $id);
			$data = $this->load->view('content/newtable', $arrdata, true);
			if($this->input->post("ajax")||$act=="post"){
				echo $arrdata;
			}else{
				$this->content = $data;
				$this->index();
			}
		}
	}

	public function gate_pass_delivery($act,$id, $id2){
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
			$this->load->model("m_planning");
			$arrdata = $this->m_planning->gate_pass_delivery($act, $id);
			$data = $this->load->view('content/newtable', $arrdata, true);
			if($this->input->post("ajax")||$act=="post"){
				echo $arrdata;
			}else{
				$this->content = $data;
				$this->index();
			}
		}
	}
	
	public function gatepass_delivery_detail($act, $id){
		if (!$this->session->userdata('LOGGED')){
			$this->index();
			return;
		}
		$id = ($id!="")?$id:$this->input->post('id');
		$this->load->model("m_planning");
		$arrdata = $this->m_planning->gate_pass_delivery_add($act, $id);
		$data = $this->load->view('content/newtable', $arrdata, true);
		if($this->input->post("ajax")||$act=="post"){
			echo $arrdata;
		}else{
			return $data;
		}
	}

	public function gatepass_detail($act, $id){
		if (!$this->session->userdata('LOGGED')){
			$this->index();
			return;
		}
		$id = ($id!="")?$id:$this->input->post('id');
		$this->load->model("m_planning");
		$arrdata = $this->m_planning->behandle_add($act, $id);
		$data = $this->load->view('content/newtable', $arrdata, true);
		if($this->input->post("ajax")||$act=="post"){
			echo $arrdata;
		}else{
			return $data;
		}
	}

	public function gatepass2_detail($act, $id){
		if (!$this->session->userdata('LOGGED')){
			$this->index();
			return;
		}
		$id = ($id!="")?$id:$this->input->post('id');
		$this->load->model("m_planning");
		$arrdata = $this->m_planning->behandle2_add($act, $id);
		$data = $this->load->view('content/newtable', $arrdata, true);
		if($this->input->post("ajax")||$act=="post"){
			echo $arrdata;
		}else{
			return $data;
		}
	}

	public function jadwal_kapal($act, $id){
		if (!$this->session->userdata('LOGGED')){
			$this->index();
			return;
		}
		$id = ($id!="")?$id:$this->input->post('id');
		$this->load->model("m_planning");
		$arrdata = $this->m_planning->list_jadwal_kapal($act, $id);
		$data = $this->load->view('content/newtable', $arrdata, true);
		if($this->input->post("ajax")||$act=="post"){
			echo $arrdata;
		}else{
			return $data;
			//$this->index();
		}
	}

	public function discharge_kontainer($act,$id){
		if (!$this->session->userdata('LOGGED')){
			$this->index();
			return;
		}
		$id = ($id!="")?$id:$this->input->post('id');
		if($act=="add"){
			$this->load->model('m_popup');
			$this->load->model('m_execute');
			$data['title'] = 'ENTRY DISCHARGE - KONTAINER';
			$data['id'] = $id;
			$data['post'] = $id;
			$data['action'] = 'save';
			$data['arr_ukuran'] = $this->m_popup->get_combobox('cont_ukuran');
			$data['arr_jenis'] = $this->m_popup->get_combobox('cont_jenis');
			$data['arr_status'] = $this->m_popup->get_combobox('cont_status');
			$data['arr_tipe'] = $this->m_popup->get_combobox('cont_tipe');
			$data['arr_angkut'] = $this->m_popup->get_combobox('sarana_angkut');
			$data['arrdata'] = $this->m_execute->get_data('kapal', $id);
			echo $this->load->view('content/coarri/impor/discharge-kontainer',$data,true);
		}else if($act=="update"){
			$arrid = explode('~',$id);
			$this->load->model('m_popup');
			$this->load->model('m_execute');
			$data['title'] = 'UPDATE DISCHARGE - KONTAINER';
			$data['id'] = $id;
			$data['post'] = $arrid[0];
			$data['action'] = 'update';
			$data['arr_ukuran'] = $this->m_popup->get_combobox('cont_ukuran');
			$data['arr_jenis'] = $this->m_popup->get_combobox('cont_jenis');
			$data['arr_status'] = $this->m_popup->get_combobox('cont_status');
			$data['arr_tipe'] = $this->m_popup->get_combobox('cont_tipe');
			$data['arr_angkut'] = $this->m_popup->get_combobox('sarana_angkut');
			$data['arrdata'] = $this->m_execute->get_data('kontainer', $id);
			echo $this->load->view('content/coarri/impor/discharge-kontainer',$data,true);
		}else if($act=="detail-kontainer"){
			$arrid = explode('~',$id);
			$this->load->model('m_execute');
			$data['title'] = 'DETAIL DISCHARGE - KONTAINER';
			$data['arrdata'] = $this->m_execute->get_data('kontainer', $id);
			echo $this->load->view('content/coarri/impor/discharge-kontainer-detail',$data,true);
		}else{
			$this->load->model("m_coarri");
			$arrdata = $this->m_coarri->discharge_kontainer($act, $id);
			$data = $this->load->view('content/newtable', $arrdata, true);
			if($this->input->post("ajax")||$act=="post"){
				return $arrdata;
			}else{
				return $data;
			}
		}
	}

	public function discharge_kemasan($act,$id){
		if (!$this->session->userdata('LOGGED')){
			$this->index();
			return;
		}
		$id = ($id!="")?$id:$this->input->post('id');
		if($act=="add"){
			$this->load->model('m_popup');
			$this->load->model('m_execute');
			$data['title'] = 'ENTRY DISCHARGE - KEMASAN';
			$data['id'] = $id;
			$data['post'] = $id;
			$data['action'] = 'save';
			$data['arr_ukuran'] = $this->m_popup->get_combobox('cont_ukuran');
			$data['arr_jenis'] = $this->m_popup->get_combobox('cont_jenis');
			$data['arr_status'] = $this->m_popup->get_combobox('cont_status');
			$data['arr_tipe'] = $this->m_popup->get_combobox('cont_tipe');
			$data['arr_angkut'] = $this->m_popup->get_combobox('sarana_angkut');
			$data['arrdata'] = $this->m_execute->get_data('kapal', $id);
			echo $this->load->view('content/coarri/impor/discharge-kemasan',$data,true);
		}else if($act=="update"){
			$arrid = explode('~',$id);
			$this->load->model('m_popup');
			$this->load->model('m_execute');
			$data['title'] = 'UPDATE DISCHARGE - KEMASAN';
			$data['id'] = $id;
			$data['post'] = $arrid[0];
			$data['action'] = 'update';
			$data['arr_angkut'] = $this->m_popup->get_combobox('sarana_angkut');
			$data['arrdata'] = $this->m_execute->get_data('kemasan', $id);
			echo $this->load->view('content/coarri/impor/discharge-kemasan',$data,true);
		}else if($act=="detail-kemasan"){
			$arrid = explode('~',$id);
			$this->load->model('m_execute');
			$data['title'] = 'DETAIL DISCHARGE - KEMASAN';
			$data['arrdata'] = $this->m_execute->get_data('kemasan', $id);
			echo $this->load->view('content/coarri/impor/discharge-kemasan-detail',$data,true);
		}else{
			$this->load->model("m_coarri");
			$arrdata = $this->m_coarri->discharge_kemasan($act, $id);
			$data = $this->load->view('content/newtable', $arrdata, true);
			if($this->input->post("ajax")||$act=="post"){
				return $arrdata;
			}else{
				return $data;
			}
		}
	}

	public function loading($act,$id){
		if (!$this->session->userdata('LOGGED')){
			$this->index();
			return;
		}
		$id = ($id!="")?$id:$this->input->post('id');
		if($act=="detail"){
			$this->newtable->breadcrumb('Home', site_url());
			$this->newtable->breadcrumb('Pergerakan Barang', 'javascript:void(0)');
			$this->newtable->breadcrumb('Barang Ekspor', 'javascript:void(0)');
			$this->newtable->breadcrumb('Loading', site_url('codeco/gateout'));
			$this->newtable->breadcrumb('Detail', 'javascript:void(0)');
			$data['title'] = 'DETAIL LOADING';
			$data['id'] = $id;
			$this->load->model("m_execute");
			$data['arrdata'] = $this->m_execute->get_data('kapal', $id);
			$data['table_kontainer'] = $this->loading_kontainer($act,$id);
			$data['table_kemasan'] = $this->loading_kemasan($act,$id);
			$this->content = $this->load->view('content/coarri/ekspor/loading-detail',$data,true);
			$this->index();
		}else if($act=="upload"){
			$this->newtable->breadcrumb('Home', site_url());
			$this->newtable->breadcrumb('Pergerakan Barang', 'javascript:void(0)');
			$this->newtable->breadcrumb('Barang Ekspor', 'javascript:void(0)');
			$this->newtable->breadcrumb('Loading', site_url('coarri/discharge'));
			$this->newtable->breadcrumb('Upload', 'javascript:void(0)');
			$data['title'] = 'UPLOAD LOADING';
			$data['id'] = '';
			$data['action'] = 'save';
			$this->content = $this->load->view('content/coarri/ekspor/loading-upload',$data,true);
			$this->index();
		}else{
			$this->load->model("m_coarri");
			$arrdata = $this->m_coarri->loading($act, $id);
			$data = $this->load->view('content/newtable', $arrdata, true);
			if($this->input->post("ajax")||$act=="post"){
				echo $arrdata;
			}else{
				$this->content = $data;
				$this->index();
			}
		}
	}

	public function loading_kontainer($act,$id){
		if (!$this->session->userdata('LOGGED')){
			$this->index();
			return;
		}
		$id = ($id!="")?$id:$this->input->post('id');
		if($act=="update"){
			$arrid = explode('~',$id);
			$this->load->model('m_popup');
			$this->load->model('m_execute');
			$data['title'] = 'LOADING - KONTAINER';
			$data['id'] = $id;
			$data['post'] = $arrid[0];
			$data['action'] = 'update';
			$data['arr_ukuran'] = $this->m_popup->get_combobox('cont_ukuran');
			$data['arr_jenis'] = $this->m_popup->get_combobox('cont_jenis');
			$data['arr_status'] = $this->m_popup->get_combobox('cont_status');
			$data['arr_tipe'] = $this->m_popup->get_combobox('cont_tipe');
			$data['arr_angkut'] = $this->m_popup->get_combobox('sarana_angkut');
			$data['arrdata'] = $this->m_execute->get_data('kontainer', $id);
			echo $this->load->view('content/coarri/ekspor/loading-kontainer',$data,true);
		}else if($act=="detail-kontainer"){
			$arrid = explode('~',$id);
			$this->load->model('m_execute');
			$data['title'] = 'DETAIL LOADING - KONTAINER';
			$data['arrdata'] = $this->m_execute->get_data('kontainer', $id);
			echo $this->load->view('content/coarri/ekspor/loading-kontainer-detail',$data,true);
		}else{
			$this->load->model("m_coarri");
			$arrdata = $this->m_coarri->loading_kontainer($act, $id);
			$data = $this->load->view('content/newtable', $arrdata, true);
			if($this->input->post("ajax")||$act=="post"){
				return $arrdata;
			}else{
				return $data;
			}
		}
	}

	public function loading_kemasan($act,$id){
		if (!$this->session->userdata('LOGGED')){
			$this->index();
			return;
		}
		$id = ($id!="")?$id:$this->input->post('id');
		if($act=="update"){
			$arrid = explode('~',$id);
			$this->load->model('m_popup');
			$this->load->model('m_execute');
			$data['title'] = 'LOADING - KEMASAN';
			$data['id'] = $id;
			$data['post'] = $arrid[0];
			$data['action'] = 'update';
			$data['arr_angkut'] = $this->m_popup->get_combobox('sarana_angkut');
			$data['arrdata'] = $this->m_execute->get_data('kemasan', $id);
			echo $this->load->view('content/coarri/ekspor/loading-kemasan',$data,true);
		}else if($act=="detail-kemasan"){
			$arrid = explode('~',$id);
			$this->load->model('m_execute');
			$data['title'] = 'DETAIL LOADING - KEMASAN';
			$data['arrdata'] = $this->m_execute->get_data('kemasan', $id);
			echo $this->load->view('content/coarri/ekspor/loading-kemasan-detail',$data,true);
		}else{
			$this->load->model("m_coarri");
			$arrdata = $this->m_coarri->loading_kemasan($act, $id);
			$data = $this->load->view('content/newtable', $arrdata, true);
			if($this->input->post("ajax")||$act=="post"){
				return $arrdata;
			}else{
				return $data;
			}
		}
	}

	public function spjm($act, $id){
		//print_r($id);
		if (!$this->session->userdata('LOGGED')){
			$this->index();
			return;
		}
		$id = ($id!="")?$id:$this->input->post('id');

		if($act=="add"){
			/*$data['title'] = 'ENTRY DISCHARGE';
			$data['id'] = '';
			$data['action'] = 'save';
			echo $this->load->view('content/planning/shipment/add',$data,true);*/
		}else if($act=="update"){
			/*$data['title'] = 'UPDATE DISCHARGE';
			$data['id'] = $id;
			$data['action'] = 'update';
			$this->load->model("m_execute");
			$data['arrdata'] = $this->m_execute->get_data('kapal', $id);
			echo $this->load->view('content/planning/shipment/update',$data,true);*/
		}else if($act=="spjm_detail"){
			//echo "sini";die();
			/**/$this->newtable->breadcrumb('Spjm', site_url());
			$this->newtable->breadcrumb('Planning', 'javascript:void(0)');
			$this->newtable->breadcrumb('List Spjm', site_url('planning/spjm'));
			$this->newtable->breadcrumb('Detail', 'javascript:void(0)');
			$data['title'] = 'DETAIL SPJM';
			$data['id'] = $id;
			//print_r($id);die();
			$this->load->model("m_execute");
			$data['arrdata'] = $this->m_execute->get_data_dokumen('spjm', $id);
			echo $this->content = $this->load->view('content/dokumen/detail_spjm',$data,true);
			//$this->index();
			//echo "string";
		}else{
			$this->load->model("m_planning");
			$arrdata = $this->m_planning->list_dokumen($act, $id);
			$data = $this->load->view('content/newtable', $arrdata, true);
			if($this->input->post("ajax")||$act=="post"){
				echo $arrdata;
			}else{
				$this->content = $data;
				$this->index();
			}
		}
		//$this->load->view('content/dokumen/spjm');
	}

	public function sppb($act, $id){
		//print_r($id);
		if (!$this->session->userdata('LOGGED')){
			$this->index();
			return;
		}
		$id = ($id!="")?$id:$this->input->post('id');

		if($act=="add"){
			$data['title'] = 'ENTRY DISCHARGE';
			$data['id'] = '';
			$data['action'] = 'save';
			echo $this->load->view('content/planning/shipment/add',$data,true);
		}else if($act=="update"){
			$data['title'] = 'UPDATE DISCHARGE';
			$data['id'] = $id;
			$data['action'] = 'update';
			$this->load->model("m_execute");
			$data['arrdata'] = $this->m_execute->get_data('kapal', $id);
			echo $this->load->view('content/planning/shipment/update',$data,true);
		}else if($act=="sppb_detail"){
			/**/$this->newtable->breadcrumb('Spjm', site_url());
			$this->newtable->breadcrumb('Planning', 'javascript:void(0)');
			$this->newtable->breadcrumb('List Sppb', site_url('planning/sppb'));
			$this->newtable->breadcrumb('Detail', 'javascript:void(0)');
			$data['title'] = 'DETAIL SPPB';
			$data['id'] = $id;
			//print_r($id);die();
			$this->load->model("m_execute");
			$data['arrdata'] = $this->m_execute->get_data_dokumen('sppb', $id);
			//var_dump($data);die();
			//$data['table_kontainer'] = $this->discharge_kontainer($act,$id);
			//$data['table_kemasan'] = $this->discharge_kemasan($act,$id);
			echo $this->content = $this->load->view('content/dokumen/detail_sppb',$data,true);
			//$this->index();
			//echo "string";
		}else{
			$this->load->model("m_planning");
			$arrdata = $this->m_planning->list_sppb('sppb', $id);
			$data = $this->load->view('content/newtable', $arrdata, true);
			if($this->input->post("ajax")||$act=="post"){
				echo $arrdata;
			}else{
				$this->content = $data;
				$this->index();
			}
		}
		//$this->load->view('content/dokumen/spjm');
	}

	public function sppmp($act, $id){
		//print_r($id);
		if (!$this->session->userdata('LOGGED')){
			$this->index();
			return;
		}
		$id = ($id!="")?$id:$this->input->post('id');

		if($act=="add"){
			/*$data['title'] = 'ENTRY DISCHARGE';
			$data['id'] = '';
			$data['action'] = 'save';
			echo $this->load->view('content/planning/shipment/add',$data,true);*/
		}else if($act=="update"){
			/*$data['title'] = 'UPDATE DISCHARGE';
			$data['id'] = $id;
			$data['action'] = 'update';
			$this->load->model("m_execute");
			$data['arrdata'] = $this->m_execute->get_data('kapal', $id);
			echo $this->load->view('content/planning/shipment/update',$data,true);*/
		}else if($act=="sppmp_detail"){
			$this->newtable->breadcrumb('Request Spjm', site_url());
			$this->newtable->breadcrumb('Planning', 'javascript:void(0)');
			$this->newtable->breadcrumb('Gate Pass Request ', site_url('planning/sppmp'));
			$this->newtable->breadcrumb('Spjm', 'javascript:void(0)');
			$data['title'] = 'Request Spjm';
			$data['id'] = $id;
			//print_r($id);die();
			$this->load->model("m_execute");
			$data['arrdata'] = $this->m_execute->get_data_dokumen('detail_sppmp', $id);
			echo $this->content = $this->load->view('content/dokumen/detail_sppmp',$data,true);
		}else{
			$this->load->model("m_planning");
			$arrdata = $this->m_planning->list_sppmp($act, $id);
			$data = $this->load->view('content/newtable', $arrdata, true);
			if($this->input->post("ajax")||$act=="post"){
				echo $arrdata;
			}else{
				$this->content = $data;
				$this->index();
			}
		}
		//$this->load->view('content/dokumen/spjm');
	}

	public function coarri($act, $id){
		if (!$this->session->userdata('LOGGED')){
			$this->index();
			return;
		}
		$this->load->model("m_planning");
		$arrdata = $this->m_planning->list_coarri($act, $id);
		$data = $this->load->view('content/newtable', $arrdata, true);
		if($this->input->post("ajax")||$act=="post"){
			echo $arrdata;
		}else{
			$this->content = $data;
			$this->index();
		}
	}

	public function pelepasan_karantina($act, $id){
		//print_r($id);
		if (!$this->session->userdata('LOGGED')){
			$this->index();
			return;
		}
		$id = ($id!="")?$id:$this->input->post('id');

		if($act=="add"){
			/*$data['title'] = 'ENTRY DISCHARGE';
			$data['id'] = '';
			$data['action'] = 'save';
			echo $this->load->view('content/planning/shipment/add',$data,true);*/
		}else if($act=="update"){
			/*$data['title'] = 'UPDATE DISCHARGE';
			$data['id'] = $id;
			$data['action'] = 'update';
			$this->load->model("m_execute");
			$data['arrdata'] = $this->m_execute->get_data('kapal', $id);
			echo $this->load->view('content/planning/shipment/update',$data,true);*/
		}else if($act=="spjm_detail"){
			/**/$this->newtable->breadcrumb('Spjm', site_url());
			$this->newtable->breadcrumb('Planning', 'javascript:void(0)');
			$this->newtable->breadcrumb('List pelepasan_karantina', site_url('planning/pelepasan_karantina'));
			$this->newtable->breadcrumb('Detail', 'javascript:void(0)');
			$data['title'] = 'DETAIL pelepasan_karantina';
			$data['id'] = $id;
			//print_r($id);die();
			$this->load->model("m_execute");
			$data['arrdata'] = $this->m_execute->get_data_dokumen('pelepasan_karantina', $id);
			//var_dump($data);die();
			//$data['table_kontainer'] = $this->discharge_kontainer($act,$id);
			//$data['table_kemasan'] = $this->discharge_kemasan($act,$id);
			$this->content = $this->load->view('content/dokumen/detail_pelepasan_karantina',$data,true);
			$this->index();
			//echo "string";
		}else{
			$this->load->model("m_planning");
			$arrdata = $this->m_planning->list_karantina('pelepasan_karantina', $id);
			$data = $this->load->view('content/newtable', $arrdata, true);
			if($this->input->post("ajax")||$act=="post"){
				echo $arrdata;
			}else{
				$this->content = $data;
				$this->index();
			}
		}
		//$this->load->view('content/dokumen/spjm');
	}

	public function gate_pass($act, $id){
		if (!$this->session->userdata('LOGGED')){
			$this->index();
			return;
		}
		$id = ($id!="")?$id:$this->input->post('id');

		if($act=="add"){
			/*$data['title'] = 'ENTRY DISCHARGE';
			$data['id'] = '';
			$data['action'] = 'save';
			echo $this->load->view('content/planning/shipment/add',$data,true);*/
		}else if($act=="showContGatePass"){
			#print_r($id);die();
			$expid = explode('~', $id);
			$idpost = $expid[0];
			$jns_dokumen = $expid[1];
			//print_r($idpost);die();
			if ($jns_dokumen == 'SPPMP') {
				#print_r($idpost);die();
				$data['action'] = 'sendMail';
				#$data['param'] = 'sendMail';
				$this->load->model("m_planning");
				$data['detail_cont'] = $this->m_planning->get_data('ContSppmp', $idpost);
				//print_r($data);die();
				echo $this->content = $this->load->view('content/dokumen/sppmp/detailCont',$data,true);
				#echo "sini sppmp";
			}else if ($jns_dokumen == 'SPJM') {
				print_r($idpost);die();
				$data['action'] = 'sendMail';
				$this->load->model("m_planning");
				$data['detail_cont'] = $this->m_planning->get_data('ContSpjm', $idpost);
				print_r($data);die();
				echo $this->content = $this->load->view('content/dokumen/spjm/detailCont',$data,true);
				echo "sini SPJM";
			}
		}else if($act=="gate_pass_request_spjmn"){
			$this->newtable->breadcrumb('Request Spjm', site_url());
			$this->newtable->breadcrumb('Planning', 'javascript:void(0)');
			$this->newtable->breadcrumb('Gate Pass Request ', site_url('planning/sppmp'));
			$this->newtable->breadcrumb('Spjm', 'javascript:void(0)');
			$data['title'] = 'Request Spjm';
			$data['id'] = $id;
			//print_r($id);die();
			$this->load->model("m_execute");
			$data['arrdata'] = $this->m_execute->get_data_dokumen('gate_pass_request_spjmn', $id);
			echo $this->content = $this->load->view('content/dokumen/request_spjm',$data,true);
		}else if($act=="gate_pass_request_spjmn_detail"){
			$arrid = explode('~',$id);
			$idpost = $arrid[0];
			$jns_dokumen = $arrid[1];

			if($jns_dokumen == 'SPJM' || $jns_dokumen == 'NHI'){
				$this->newtable->breadcrumb('Request Spjm', site_url());
				$this->newtable->breadcrumb('Planning', 'javascript:void(0)');
				$this->newtable->breadcrumb('Gate Pass Request ', site_url('planning/sppmp'));
				$this->newtable->breadcrumb('Spjm', 'javascript:void(0)');
				$data['title'] = 'Request Spjm';
				$data['id'] = $idpost;
				$this->load->model("m_execute");
				$data['arrdata'] = $this->m_execute->get_data_dokumen('gate_pass_request_spjmn_detail', $idpost);
				echo $this->content = $this->load->view('content/dokumen/gate_pass_detail_spjm',$data,true);
			} else if($jns_dokumen == 'SPPMP'){
				$this->newtable->breadcrumb('Request SPPMP', site_url());
				$this->newtable->breadcrumb('Planning', 'javascript:void(0)');
				$this->newtable->breadcrumb('Gate Pass Request ', site_url('planning/sppmp'));
				$this->newtable->breadcrumb('Spjm', 'javascript:void(0)');
				$data['title'] = 'Request SPPMP';
				$data['id'] = $idpost;
				$this->load->model("m_execute");
				$data['arrdata'] = $this->m_execute->get_data_dokumen('detail_sppmp', $idpost);
				echo $this->content = $this->load->view('content/dokumen/detail_sppmp',$data,true);
			}

		}else if($act=="gate_pass_request"){
			//echo "<a href='".site_url('planning/gate_pass_spjmn')."' class='btn btn-primary'>SPJM</a>&nbsp;&nbsp;&nbsp;";
			//echo "<a href='#' class='btn btn-success'>SPPMP</a>";
			//die();
			/*/*$this->newtable->breadcrumb('Spjm', site_url());
			$this->newtable->breadcrumb('Planning', 'javascript:void(0)');
			$this->newtable->breadcrumb('List pelepasan_karantina', site_url('planning/pelepasan_karantina'));
			$this->newtable->breadcrumb('Detail', 'javascript:void(0)');
			$data['title'] = 'DETAIL pelepasan_karantina';
			$data['id'] = $id;
			//print_r($id);die();
			$this->load->model("m_execute");
			$data['arrdata'] = $this->m_execute->get_data_dokumen('gate_pass', $id);
			//var_dump($data);die();
			//$data['table_kontainer'] = $this->discharge_kontainer($act,$id);
			//$data['table_kemasan'] = $this->discharge_kemasan($act,$id);
			$this->content = $this->load->view('content/gate_pass',$data,true);
			$this->index();*/
			//echo "string";die();
			$this->load->model("m_planning");
			$data['title'] = "Gate Pass";
			$data['table_spjm'] = $this->gate_pass2($act, $id);
			$data['table_sppmp'] = $this->gate_pass_sppmp($act, $id);
			//var_dump($data);die();
			echo $this->load->view('content/dokumen/gate_pas_spjmn', $data, true) ;
		}else{
			$this->load->model("m_planning");
			$arrdata = $this->m_planning->gate_pass('gate_pass', $id);
			$data = $this->load->view('content/newtable', $arrdata, true);
			if($this->input->post("ajax")||$act=="post"){
				echo $arrdata;
			}else{
				$this->content = $data;
				$this->index();
			}
		}
	}

	public function gate_pass_gate($act, $id){
	  if (!$this->session->userdata('LOGGED')){
        $this->index();
        return;
    	}
        $id = ($id!="")?$id:$this->input->post('id');
        $this->newtable->breadcrumb('Dashboard', site_url());
        $this->newtable->breadcrumb('Planning', 'javascript:void(0)');
        $this->newtable->breadcrumb('Gate Pass', 'javascript:void(0)');
        $data['page_title'] = 'Gate Pass';
        $data['table_spjm'] = $this->gate_pass2($act, $id);
		$data['table_sppmp'] = $this->gate_pass_sppmp($act, $id);
        $this->content = $this->load->view('content/dokumen/index',$data,true);
        $this->index();
	}

	public function gate_pass2($act, $id){
		if (!$this->session->userdata('LOGGED')){
			$this->index();
			return;
		}
		$id = ($id!="")?$id:$this->input->post('id');
		$this->load->model("m_planning");
		$arrdata = $this->m_planning->list_gate_pass_spjmn('gate_pass_request2', $id);
		$data = $this->load->view('content/newtable', $arrdata, true);
		if($this->input->post("ajax")||$act=="post"){
			echo $arrdata;
		}else{
			return $data;
			//$this->index();
		}
	}

	public function gate_pass_sppmp($act, $id){
		if (!$this->session->userdata('LOGGED')){
			$this->index();
			return;
		}
		$id = ($id!="")?$id:$this->input->post('id');
		$this->load->model("m_planning");
		$arrdata = $this->m_planning->list_gate_pass_sppmp('gate_pass_request_sppmp', $id);
		$data = $this->load->view('content/newtable', $arrdata, true);
		if($this->input->post("ajax")||$act=="post"){
			return $arrdata;
		}else{
			return $data;
			//$this->index();
		}
	}

	public function gate_pass_spjmn($act, $id){
		//print_r($id);
		if (!$this->session->userdata('LOGGED')){
			$this->index();
			return;
		}

		$id = ($id!="")?$id:$this->input->post('id');

		if($act=="add"){
			/*$data['title'] = 'ENTRY DISCHARGE';
			$data['id'] = '';
			$data['action'] = 'save';
			echo $this->load->view('content/planning/shipment/add',$data,true);*/
		}else if($act=="update"){
			/*$data['title'] = 'UPDATE DISCHARGE';
			$data['id'] = $id;
			$data['action'] = 'update';
			$this->load->model("m_execute");
			$data['arrdata'] = $this->m_execute->get_data('kapal', $id);
			echo $this->load->view('content/planning/shipment/update',$data,true);*/
		}else if($act=="gate_pd"){
			//print_r($id);die();
			$this->newtable->breadcrumb('Request Spjm', site_url());
			$this->newtable->breadcrumb('Planning', 'javascript:void(0)');
			$this->newtable->breadcrumb('Gate Pass Request ', site_url('planning/sppmp'));
			$this->newtable->breadcrumb('Spjm', 'javascript:void(0)');
			$data['title'] = 'Request Spjm';
			$data['id'] = $id;
			//print_r($id);die();
			$this->load->model("m_execute");
			$data['arrdata'] = $this->m_execute->get_data_dokumen('request_spjm', $id);
			var_dump($data);die();
			//$data['table_kontainer'] = $this->discharge_kontainer($act,$id);
			//$data['table_kemasan'] = $this->discharge_kemasan($act,$id);
			echo $this->content = $this->load->view('content/dokumen/request_spjm',$data,true);
			//$this->index();
		}else{
			$this->load->model("m_planning");
			$arrdata = $this->m_planning->list_gate_pass_spjmn('gate_pass_spjmn', $id);
			$data = $this->load->view('content/newtable', $arrdata, true);
			if($this->input->post("ajax")||$act=="post"){
				echo $arrdata;
			}else{
				$this->content = $data;
				$this->index();
			}
		}
		//$this->load->view('content/dokumen/spjm');
	}

	public function spk($act, $id){
		if (!$this->session->userdata('LOGGED')){
			$this->index();
			return;
		}
		$id = ($id!="")?$id:$this->input->post('id');
		if ($act == 'spk_create') {
			$arrdata = $this->m_planning->spk_create($act, $id);
			$data = $this->load->view('content/newtable', $arrdata, true);
			if($this->input->post("ajax")||$act=="post"){
				echo $arrdata;
			}else{
				$this->content = $data;
				$this->index();
			}
		}else if($act == 'spk_add_cont'){
			$arrdata = $this->m_planning->spk_add_cont($act, $id);
			$data = $this->load->view('content/newtable', $arrdata, true);
			if($this->input->post("ajax")||$act=="post"){
				echo $arrdata;
			}else{
				$this->content = $data;
				$this->index();
			}
		}else if($act == 'spk_save'){
			if (strtolower($_SERVER['REQUEST_METHOD']) != "post") {
                redirect(base_url());
                exit();
            } else {
            	$id = $this->input->post('tb_chktbldetailSpkCont');
                $this->m_planning->spk_save($id);
            }
		}else if($act == 'spk_detail'){
			$this->newtable->breadcrumb('SPK', site_url());
			$this->newtable->breadcrumb('PLANNING', 'javascript:void(0)');
			$this->newtable->breadcrumb('DETAIL ', site_url('planning/sppmp'));
			$this->newtable->breadcrumb('SPK', 'javascript:void(0)');
			$data['title'] = 'SPK';
			$data['id'] = $id;
			$data['arrdata'] = $this->m_planning->get_data('detail_spk', $id);
			echo $this->content = $this->load->view('content/dokumen/detail_spk',$data,true);
		}else if($act == 'spk_announcement'){
			$arrId = explode('~', $id);
			$arrIdspk = $arrId[0];
			$arrNospk = $arrId[1];
	        $this->m_planning->spk_announcement($arrIdspk, $arrNospk);
		}else if($act == 'spk_cetak'){
			$dataArr = explode("~", $id);
			$id = $dataArr[0];
			$cekStatusSpk = "SELECT A.KD_STATUS,B.STATUS_CONT
							FROM t_spk A
							INNER JOIN t_spk_cont B ON A.ID = B.ID
							WHERE A.ID = '$dataArr[0]' AND A.NO_SPK='$dataArr[1]' AND B.STATUS_CONT != '500'";

			$result = $this->db->query($cekStatusSpk)->result_array();
			if ($result[0]['KD_STATUS'] == '000') {
				$url = site_url('/planning/spk');
				echo "<script>alert('Spk Belum Di Announce...');location.href='$url'</script>";
				die();
			}
			$this->load->library('mpdf');
			$this->load->model("m_execute");
			$sess = $this->session->userdata('USERLOGIN');
			$data['title'] = "".$sess;
			$data['result'] = $this->m_planning->get_data('cetak_spk',$id);
			$this->load->view('content/dokumen/print_spk', $data);
		}else if($act == 'spk_history'){
			$data['arrdata'] = $this->m_planning->get_data('history_spk', $id);
			echo $this->content = $this->load->view('content/dokumen/history_cetak',$data,true);
		}else if($act == 'spk_delete'){
			foreach ($this->input->post('tb_chktblspk') as $key => $value) {
				$Arrvalue = explode('~', $value);
				$id = $Arrvalue[0];
				$spk = $Arrvalue[1];
			}
			$this->m_planning->spk_delete($id,$spk);
		}else{
			$arrdata = $this->m_planning->spk_list($act, $id);
			$data = $this->load->view('content/newtable', $arrdata, true);
			if($this->input->post("ajax")||$act=="post"){
				echo $arrdata;
			}else{
				$this->content = $data;
				$this->index();
			}
		}
	}

	function process($type, $act, $id) {
        if (!$this->session->userdata('LOGGED')) {
            $this->index();
            return;
        }
		$id = ($id!="")?$id:$this->input->post('id');
		$dataArr = explode("~", $id);
		$cekStatusSpk = "SELECT A.KD_STATUS,B.STATUS_CONT
						FROM t_spk A
						INNER JOIN t_spk_cont B ON A.ID = B.ID
						WHERE A.id = '$dataArr[0]' AND B.STATUS_CONT != '500'";
		$result = $this->db->query($cekStatusSpk)->result_array();
		if ($result[0]['KD_STATUS'] == '000') {
			$url = site_url('/planning/spk');
			echo "<script>alert('Spk Belum Di Announce!');location.href='$url'</script>";
			die();
		}
		$this->load->library('mpdf');
		$this->load->model("m_execute");
		$abc= $this->session->userdata('USERLOGIN');
		$data['title'] = "".$abc;
		$data['result'] = $this->m_execute->get_data('cetak_spk',$id);
		//var_dump($data);die();
		
		$this->load->view('content/dokumen/print_spk', $data);

    }
	
	function process2($type="",$act="", $id=""){
		if (!$this->session->userdata('LOGGED')) {
			$this->index();
			return;
		}else{
			if (strtolower($_SERVER['REQUEST_METHOD']) != "post") {
				$this->load->model("m_planning");
				$this->m_planning->process2($type,$act,$id);
			}else{
				$this->load->model("m_planning");
				$this->m_planning->process2($type,$act,$id);
			}
		}
	}
	
	function proces($type="",$act="", $id=""){
		if (!$this->session->userdata('LOGGED')) {
			$this->index();
			return;
		}else{
			if (strtolower($_SERVER['REQUEST_METHOD']) != "post") {
				$this->load->model("m_planning");
				$this->m_planning->process($type,$act,$id);
			}else{
				$this->load->model("m_planning");
				$this->m_planning->process($type,$act,$id);
			}
		}
	}

	function relokasi1($act, $id){
		if (!$this->session->userdata('LOGGED')) {
			$this->index();
			return;
		}
		$id = ($id!="")?$id:$this->input->post('id');
		if($act=="add"){
			$data['title'] = 'UPDATE LOKASI';
			$data['id'] = $id;
			$data['action'] = 'update';
			//echo $id; die();
			$this->load->model("m_execute");
			$this->load->model("m_setting");
			$data['arrdata'] = $this->m_execute->get_data('lokasi2', $id);
			$data['arrdata_denah'] = $this->m_setting->get_data('lokasi_denah', $id);
			$data['tier'] = $this->m_setting->get_data('tier', $id);
			//print_r($data); die();
			$data = $this->load->view('content/placement/set_relocation',$data,true);
			
			if($this->input->post("ajax")||$act=="post"){
				echo $arrdata;
			}else{
				$this->content = $data;
				$this->index();
			}
		}else{
			$id = ($id!="")?$id:$this->input->post('id');
			$this->load->model("m_planning");
			$arrdata = $this->m_planning->relokasi1($act, $id);
			$data = $this->load->view('content/newtable', $arrdata, true);
			if($this->input->post("ajax")||$act=="post"){
				return $arrdata;
			}else{
				return $data;
			}
		}
	}

	public function placement($act, $id){
		if (!$this->session->userdata('LOGGED')){
			$this->index();
			return;
		}
		$id = ($id!="")?$id:$this->input->post('id');
		if ($act == 'placement_lokasi_detail') {
			
			$data['arrdata'] = $this->m_planning->get_data('lokasi', $id);
			$data['arrdata_denah'] = $this->m_planning->get_data('lokasi_denah', $id);
			
			$data = $this->load->view('content/placement/set_location',$data,true);
			if($this->input->post("ajax")||$act=="post"){
				echo $arrdata;
			}else{
				$this->content = $data;
				$this->index();
			}
		}else if($act == 'getGudang'){
			if (strtolower($_SERVER['REQUEST_METHOD']) != "post") {
				echo 'access is forbidden'; exit();
			}else{
				echo $this->m_planning->getAreaGudang();
			}
		}else if($act == 'insertGudang'){
			if (strtolower($_SERVER['REQUEST_METHOD']) != "post") {
				echo 'access is forbidden'; exit();
			}else{
				echo $this->m_planning->insertGudang();
			}
		}else if($act == 'relokasi'){
			$arrdata = $this->m_planning->list_relokasi($act, $id);
			$data = $this->load->view('content/newtable', $arrdata, true);
			if($this->input->post("ajax")||$act=="post"){
				echo $arrdata;
			}else{
				echo $data;
			}
		}else if($act == 'relokasi_add'){
			$data['id'] = $id;
			$data['action'] = 'update';
			$data['arrdata'] = $this->m_planning->get_data('lokasi', $id);
			$data['arrdata_denah'] = $this->m_planning->get_data('lokasi_denah', $id);
			$data = $this->load->view('content/placement/set_relocation',$data,true);
			
			if($this->input->post("ajax")||$act=="post"){
				echo $arrdata;
			}else{
				$this->content = $data;
				$this->index();
			}
		}else{
			$arrdata = $this->m_planning->plan_placement($act, $id);
			$data = $this->load->view('content/newtable', $arrdata, true);
			if($this->input->post("ajax")||$act=="post"){
				echo $arrdata;
			}else{
				$this->content = $data;
				$this->index();
			}
		}
	}



	public function attbehandle($act, $id){
		if (!$this->session->userdata('LOGGED')){
			$this->index();
			return;
		}
		$id = ($id!="")?$id:$this->input->post('id');
	
		$arrdata = $this->m_planning->plan_placement_att_behanddle($act, $id);
		$data = $this->load->view('content/newtable', $arrdata, true);
		if($this->input->post("ajax")||$act=="post"){
				echo $arrdata;
		}else{
				$this->content = $data;
				$this->index();
		}
		
	}


	public function placement_old($act, $id){
		if (!$this->session->userdata('LOGGED')){
			$this->index();
			return;
		}
		$id = ($id!="")?$id:$this->input->post('id');

		if($act=="add"){
			/*echo "string";die();*/
			$data['title'] = 'ENTRY KAPAL';
			$data['id'] = '';
			$data['action'] = 'save';
			echo $this->load->view('content/kapal/form_add',$data,true);

		}else if($act=="relokasia"){
			$data['title'] = 'RELOKASI PLACEMENT';
			$data['id'] = $id;
			$data['action'] = 'create';
			$this->load->model("m_planning");
			$data['detail'] = $this->relokasi1($act, $id);
			echo $this->load->view('content/placement/form_add2',$data,true);
		} else if($act=="detail_placement"){
			if (!$this->session->userdata('LOGGED')){
	            $this->index();
	            return;
	        }
	        $id = ($id!="")?$id:$this->input->post('id');
	        $this->newtable->breadcrumb('REQUEST', site_url());
	        $this->newtable->breadcrumb('Planning', 'javascript:void(0)');
	        $this->newtable->breadcrumb('Detail', 'javascript:void(0)');
	        $data['page_title'] = 'Create SPK';
	        $data['table_spk_req_detail'] = $this->req_detail_spk($act, $id);
	        echo $this->content = $this->load->view('content/dokumen/req_detail',$data,true);
	       // $this->index();
		} else if($act=="spk_announcement_placement"){
			/*$data['title'] = 'UPDATE DISCHARGE';
			$data['id'] = $id;
			$data['action'] = 'update';
			$this->load->model("m_execute");
			$data['arrdata'] = $this->m_execute->get_data('kapal', $id);*/
			echo "spk_announcement";
			//echo $this->load->view('content/planning/shipment/update',$data,true);
		}else if($act=="placement_lokasi"){
			//echo "string";die();
			//print_r($id);die();
			$data['title'] = 'UPDATE LOKASI';
			$data['id'] = $id;
			$data['action'] = 'update';
			$this->load->model("m_execute");
			$data['arrdata'] = $this->m_execute->get_data('lokasi', $id);
			echo $this->load->view('content/placement/form_add',$data,true);
		}else if($act == "placement_lokasi_detail"){
			//print_r($id);die();
			$arrdata['id'] = $id;
			$data['action'] = 'update';
			$this->load->model("m_execute");
			$this->load->model("m_setting");
			$data['arrdata'] = $this->m_execute->get_data('lokasi', $id);
			//print_r($data['arrdata']);die();
			$data['arrdata_denah'] = $this->m_setting->get_data('lokasi_denah', $id);
			$data['tier'] = $this->m_setting->get_data('tier', $id);
			$data = $this->load->view('content/placement/set_location',$data,true);
			if($this->input->post("ajax")||$act=="post"){
				echo $arrdata;
			}else{
				$this->content = $data;
				$this->index();
			}
		} else if($act == "spk_cetak"){
			echo "spk_cetak";
		} else if($act == "spk_create_placement"){
			//echo "string";die();
			//print_r($id);die();
			$this->load->model("m_planning");
			$arrdata = $this->m_planning->list_spk_create('spk_create', $id);
			$data = $this->load->view('content/newtable', $arrdata, true);
			if($this->input->post("ajax")||$act=="post"){
				echo $arrdata;
			}else{
				$this->content = $data;
				$this->index();
			}
			/*echo "string";die();
			$this->newtable->breadcrumb('Request Spjm', site_url());
			$this->newtable->breadcrumb('Planning', 'javascript:void(0)');
			$this->newtable->breadcrumb('Gate Pass Request ', site_url('planning/sppmp'));
			$this->newtable->breadcrumb('Spjm', 'javascript:void(0)');
			$data['title'] = 'Request Spjm';
			$data['id'] = $id;
			//print_r($id);die();
			$this->load->model("m_execute");
			$data['arrdata'] = $this->m_execute->get_data_dokumen('get_data_dokumen', $id);*/
		}else if($act=="gate_pass_request__placement"){
			/*echo "<button class='btn btn-primary'>SPJM</button>&nbsp;&nbsp;&nbsp;";
			echo "<button class='btn btn-success'>SPPB</button>";
			die();
			$this->newtable->breadcrumb('Spjm', site_url());
			$this->newtable->breadcrumb('Planning', 'javascript:void(0)');
			$this->newtable->breadcrumb('List pelepasan_karantina', site_url('planning/pelepasan_karantina'));
			$this->newtable->breadcrumb('Detail', 'javascript:void(0)');
			$data['title'] = 'DETAIL pelepasan_karantina';
			$data['id'] = $id;
			//print_r($id);die();
			$this->load->model("m_execute");
			$data['arrdata'] = $this->m_execute->get_data_dokumen('gate_pass', $id);
			//var_dump($data);die();
			//$data['table_kontainer'] = $this->discharge_kontainer($act,$id);
			//$data['table_kemasan'] = $this->discharge_kemasan($act,$id);
			$this->content = $this->load->view('content/gate_pass',$data,true);
			$this->index();*/
			//echo "string";
		}else{
			$this->load->model("m_planning");
			$arrdata = $this->m_planning->list_placement($act, $id);
			$data = $this->load->view('content/newtable', $arrdata, true);
			if($this->input->post("ajax")||$act=="post"){
				return $arrdata;
			}else{
				$this->content = $data;
				$this->index();
			}
		}
	}

	/*public function spk_create(){
		//echo "string";die();
		  if (!$this->session->userdata('LOGGED')){
            $this->index();
            return;
        }
        $id = ($id!="")?$id:$this->input->post('id');
        $this->newtable->breadcrumb('Dashboard', site_url());
        $this->newtable->breadcrumb('Planning', 'javascript:void(0)');
        $this->newtable->breadcrumb('SPK', 'javascript:void(0)');
        $data['page_title'] = 'Create SPK';
        $data['table_spk_req_spjm'] = $this->spk_req_spjm($act, $id);
		$data['table_spk_req_sppmp'] = $this->spk_req_sppmp($act, $id);
        $this->content = $this->load->view('content/dokumen/spk_index',$data,true);
        $this->index();
	}*/

	public function spk_req_spjm($act, $id){
		if (!$this->session->userdata('LOGGED')){
			$this->index();
			return;
		}
		$id = ($id!="")?$id:$this->input->post('id');
		$this->load->model("m_planning");
		$arrdata = $this->m_planning->list_spk_req_spjm('spk_req_spjm', $id);
		$data = $this->load->view('content/newtable', $arrdata, true);
		if($this->input->post("ajax")||$act=="post"){
			echo $arrdata;
		}else{
			return $data;
			//$this->index();
		}
	}

	public function req_detail_spk($act, $id){
		if (!$this->session->userdata('LOGGED')){
			$this->index();
			return;
		}
		$id = ($id!="")?$id:$this->input->post('id');
		$this->load->model("m_planning");
		$arrdata = $this->m_planning->list_spk_req_detail($act, $id);
		$data = $this->load->view('content/newtable', $arrdata, true);
		if($this->input->post("ajax")||$act=="post"){
			echo $arrdata;
		}else{
			return $data;
			//$this->index();
		}
	}

	public function spk_req_sppmp($act, $id){
		if (!$this->session->userdata('LOGGED')){
			$this->index();
			return;
		}
		$id = ($id!="")?$id:$this->input->post('id');
		$this->load->model("m_planning");
		$arrdata = $this->m_planning->list_gate_pass_spjmn('gate_pass_request', $id);
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
		//print_r($_POST);die();
		//echo "sii";die();
        if (!$this->session->userdata('LOGGED')) {
            $this->index();
            return;
        } else {
            if (strtolower($_SERVER['REQUEST_METHOD']) != "post") {
                redirect(base_url());
                exit();
            } else {
                $this->load->model("m_planning");
                $this->m_planning->execute($type, $act, $id, $met);
            }
        }
    }

    function format_mail(){
        $subject = "REMINDER [BOS]";
        $email = 'nuridin.mu23@gmail.com';
		//$msg = $this->load->view('content/spk/mail_announcement');
        $this->load->helper('email');
        $email_success = 0;
        if(valid_email($email)){
            $config = array(
                'protocol'  => 'smtp',
                'smtp_host' => 'mail2.edi-indonesia.co.id',
                'smtp_port' => 25,
                'smtp_user' => '',
                'smtp_pass' => '',
                'mailtype'  => 'html',
                'charset'   => 'iso-8859-1',
                'wrapchars' => 100,
                'crlf'         => "\r\n",
                'newline'     => "\r\n",
                'start_tls' => TRUE
            );
			$msg = '
				<html lang="en">
					<head>
						<meta charset="UTF-8">
						<title>Document</title>
					</head>
					<body>
					<div>
						<p>
							Dear Operasional NPCT1,<br><br>
							DENGAN INI KAMI LAMPIRKAN INFORMASI BARANG YANG AKAN DIANGKUT SEBAGAI BERIKUT:
						</p>
						<table border="1" class="table" width="80%">
							<tr>
								<th>No. SPK</th>
								<th>Nomor Kontainer</th>
							</tr>
							<tr>
								<td>SPK/01/11/001/IPCTPK-16</td>
								<td>EITU0238570</td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td>EITU0238570</td>
							</tr>
						</table>
						<p>
							TERIMAKASIH.
						</p>
					</div>
					</body>
					</html>
			';


            $this->load->library('email', $config);
            #$this->email->set_newline("\r\n");
            $this->email->from('muhammad.nuridin@edi-indonesia.co.id', 'bos');
            $email = str_replace(';', ',', $email);
            $this->email->to($email);
           // $array_bcc = array('muhammad.nuridin@edi-indonesia.co.id','salman.abdulaziz@edi-indonesia.co.id');
           // $this->email->bcc($array_bcc);
            $this->email->subject($subject);
            $this->email->message($msg);
            if ($this->email->send()){
                $email_success = 1;
				/*echo "<script>alert('Email Terkirim');window.location=''</script>";*/
				echo "Email Terkirim";
            }
        }
        return $email_success;
    }

	function gate_pass_sendMail(){
        $subject = "REMINDER [BOS]";
        $email = 'nuridin.mu23@gmail.com';
		//$msg = $this->load->view('content/spk/mail_announcement');
        $this->load->helper('email');
        $email_success = 0;
        if(valid_email($email)){
            $config = array(
                'protocol'  => 'smtp',
                'smtp_host' => 'mail2.edi-indonesia.co.id',
                'smtp_port' => 25,
                'smtp_user' => '',
                'smtp_pass' => '',
                'mailtype'  => 'html',
                'charset'   => 'iso-8859-1',
                'wrapchars' => 100,
                'crlf'         => "\r\n",
                'newline'     => "\r\n",
                'start_tls' => TRUE
            );
			$msg = '
				<html lang="en">
					<head>
						<meta charset="UTF-8">
						<title>Document</title>
					</head>
					<body>
					<div>
						<p>
							Dear Operasional NPCT1,<br><br>
							DENGAN INI KAMI LAMPIRKAN INFORMASI BARANG YANG AKAN DIANGKUT SEBAGAI BERIKUT:
						</p>
						<table border="1" class="table" width="80%">
							<tr>
								<th>No. SPK</th>
								<th>Nomor Kontainer</th>
							</tr>
							<tr>
								<td>SPK/01/11/001/IPCTPK-16</td>
								<td>EITU0238570</td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td>EITU0238570</td>
							</tr>
						</table>
						<p>
							TERIMAKASIH.
						</p>
					</div>
					</body>
					</html>
			';


            $this->load->library('email', $config);
            #$this->email->set_newline("\r\n");
            $this->email->from('muhammad.nuridin@edi-indonesia.co.id', 'bos');
            $email = str_replace(';', ',', $email);
            $this->email->to($email);
           // $array_bcc = array('muhammad.nuridin@edi-indonesia.co.id','salman.abdulaziz@edi-indonesia.co.id');
           // $this->email->bcc($array_bcc);
            $this->email->subject($subject);
            $this->email->message($msg);
            if ($this->email->send()){
                $email_success = 1;
				/*echo "<script>alert('Email Terkirim');window.location=''</script>";*/
				echo "Email Terkirim";
            }
        }
        return $email_success;
    }

	public function request($type="", $act="", $id="", $met=""){
		if (!$this->session->userdata('LOGGED')){
			$this->index();
			return;
		}
		$id = ($id!="")?$id:$this->input->post('id');
		//print_r($_POST);die();
		$this->load->model('m_planning');
		$this->m_planning->execute($type, $act, $id);
		//$SQL2 = $this->db->query("select ID_IJIN AS 'ID', 'SPPMP' AS 'JENIS_DOKUMEN' from t_ppk_hdr where ID_IJIN = '$id'")->row();
			//echo "EMAIL SPPMP";die();
		//print_r($SQL2);die();
    }

	function execute_dokumen_ctrl($type="", $act="", $id="", $met="") {
		//echo $this->input->post('id');die();
		$id = ($id!="")?$id:$this->input->post('id');
		//print_r($_POST);die();
        if (!$this->session->userdata('LOGGED')) {
            $this->index();
            return;
        } else {
            if (strtolower($_SERVER['REQUEST_METHOD']) != "post") {
                redirect(base_url());
                exit();
            } else {
                $this->load->model("m_planning");
               	$this->m_planning->execute_dokumen($type, $act, $id, $met);
            }
        }
    }

	function cetak_gatepass_delivery($type, $act, $id) {
		if (!$this->session->userdata('LOGGED')) {
			$this->index();
			return;
		}
		$id =($id!="")?$id:$this->input->post('id');
		$this->load->library('mpdf');
		$this->load->library('ciqrcode');
		$this->load->model('m_execute');
		$data['result'] = $this->m_execute->get_data('cetak_gdel',$id);
		$params['data'] = $data['result'][0]['NO_CONT']."/BHD";
		// var_dump($params); die();
		$params['size'] = 3;
		$params['savename'] = 'assets/files/qrcode/code.png';
		$this->ciqrcode->generate($params);
		$this->load->view('content/gatepass/cetak_gatepass_delivery', $data);
		}

	function cetak_gatepass_delivery_banda($type, $act, $id)
	{
		if (!$this->session->userdata('LOGGED')) {
			$this->index();
			return;
		}
		$id = ($id != "") ? $id : $this->input->get('id');
		$this->load->library('mpdf');
		$this->load->library('ciqrcode');
		$this->load->model('m_execute');
		$data['result'] = $this->m_execute->get_data('cetak_gdel', $id);
		$params['data'] = $data['result'][0]['NO_CONT'] . "/BHD";
		// var_dump($params); die();
		$params['size'] = 3;
		$params['savename'] = 'assets/files/qrcode/code.png';
		$this->ciqrcode->generate($params);
		$this->load->view('content/gatepass/cetak_gatepass_delivery_banda', $data);
	}

	function cetak_gatepass_behandle($type, $act, $id) {
		if (!$this->session->userdata('LOGGED')) {
			$this->index();
			return;
		}
		$id =($id!="")?$id:$this->input->post('id');
		$this->load->library('mpdf');
		$this->load->library('ciqrcode');
		$this->load->model('m_execute');
		$data['result'] = $this->m_execute->get_data('cetak_gbe',$id);
		$params['data'] = $data['result'][0]['NO_CONT'];
		$params['size'] = 3;
		$params['savename'] = 'assets/files/qrcode/code.png';
		$this->ciqrcode->generate($params);
		$this->load->view('content/gatepass/cetak_gatepass_behandle', $data);
	}

	function cetak_gatepass_behandle_api() {
		$id = $this->input->get('no_cont');
		$this->load->library('mpdf');
		$this->load->library('ciqrcode');
		$this->load->model('m_execute');
		$data['result'] = $this->m_execute->get_data('cetak_gbe2',$id);
		$params['data'] = $data['result'][0]['NO_CONT'];
		$params['size'] = 3;
		$params['savename'] = 'assets/files/qrcode/code.png';
		$this->ciqrcode->generate($params);
		$this->load->view('content/gatepass/cetak_gatepass_behandle', $data);
	}


	/*function cetak_gatepass_behandle($type, $act, $id) {
		if (!$this->session->userdata('LOGGED')) {
			$this->index();
			return;
		}
		$id =($id!="")?$id:$this->input->post('id');
		$SQL = "SELECT JNS_DOK,FL_ACTIVE FROM t_gatepass WHERE ID = '$id'";
		$Active = $this->db->query($SQL)->row()->FL_ACTIVE;
		$SQL2= "SELECT A.NO_CONT, A.FL_ACTIVE, B.LOKASI_AKHIR FROM t_gatepass A
				INNER JOIN t_job_slip B ON B.NO_CONT = A.NO_CONT AND B.NO_GATEPASS = A.ID
				WHERE A.ID = '$id' AND B.STATUS = 'WAITING' -- AND B.OPERATOR IS NOT NULL
				GROUP BY A.NO_CONT";
		$CIC = $this->db->query($SQL2)->row()->LOKASI_AKHIR;	
		$CIC_ACT = substr($CIC,0,3);

		if ($CIC_ACT == 'CIC') {
			if($Active == "N"){
				$DATA['FL_ACTIVE'] = "Y"; 
				$DATA['WK_ACTIVE'] = date('Y-m-d H:i:s');
				$this->db->where(array('ID' => $id));
				$this->db->update('t_gatepass', $DATA);
				$this->load->library('mpdf');
				$this->load->library('ciqrcode');
				$this->load->model('m_execute');
				$data['result'] = $this->m_execute->get_data('cetak_gbe',$id);
				$params['data'] = $data['result'][0]['NO_CONT'];
				$params['size'] = 3;
				$params['savename'] = 'assets/files/qrcode/code.png';
				$this->ciqrcode->generate($params);
				$this->load->view('content/gatepass/cetak_gatepass_behandle', $data);
			}else{
				$this->load->library('mpdf');
				$this->load->library('ciqrcode');
				$this->load->model('m_execute');
				$data['result'] = $this->m_execute->get_data('cetak_gbe',$id);
				$params['data'] = $data['result'][0]['NO_CONT'];
				$params['size'] = 3;
				$params['savename'] = 'assets/files/qrcode/code.png';
				$this->ciqrcode->generate($params);
				$this->load->view('content/gatepass/cetak_gatepass_behandle', $data);
			}
		}else{
			$url = site_url('/planning/gate_pass_behandle');
			echo "<script>alert('Container Belum Di Planning ke CIC!');location.href='$url'</script>";
		}
	}*/



	function manual($act="", $id="") {
        if (!$this->session->userdata('LOGGED')) {
            $this->index();
            return;
        }
        $id = ($id != "") ? $id : $this->input->post('id');
        $this->load->model('m_planning');
        if ($act == "add") {
            $data['title'] = 'DOKUMEN MANUAL';
            $data['act'] = 'save';
			$this->load->model("m_planning");
			$data['manual1'] = $this->manual1($act, $id);
			$data['manual2'] = $this->manual2($act, $id);
			echo $this->load->view('content/dokumen/detail_manual',$data,true);
        } else if($act=="manual_mail"){
			if (!$this->session->userdata('LOGGED')){
				$this->index();
				return;
			}
			$id = ($id!="")?$id:$this->input->post('id');
			$this->load->model('m_planning');
			$this->m_planning->send_mail_manual($act, $id);

		}else if ($act == "edit") {
            $data['title'] = 'UPDATE USER';
            $data['id'] = $id;
            $data['act'] = 'update';
            $data['arrdata'] = $this->m_planning->get_data('dok_manualhdr', $id);
			$data['array_cont'] = $this->m_planning->get_data('dok_manualcont', $id);
            echo $this->load->view('content/dokumen/manualadd', $data, true);
        }else if($act=="manual_detail"){
			$this->load->model("m_execute");
			$data['arrdata'] = $this->m_execute->get_data_dokumen('detail_dok_manual', $id);
			echo $this->content = $this->load->view('content/dokumen/detail_dok_manual',$data,true);
		} else {
            $arrdata = $this->m_planning->manual($act, $id);
            $data = $this->load->view('content/newtable', $arrdata, true);
            if ($this->input->post("ajax") || $act == "post") {
                echo $arrdata;
            } else {
                $this->content = $data;
                $this->index();
            }
        }
    }

	function manual1($act, $id){
		if (!$this->session->userdata('LOGGED')) {
			$this->index();
			return;
		}
		$id = ($id!="")?$id:$this->input->post('id');
		$data = $this->load->view('content/dokumen/manualadd', $data, true);
		if($this->input->post("ajax")||$act=="post"){
			return $arrdata;
		}else{
			return $data;
		}
	}

	function manual2($act, $id){
		if (!$this->session->userdata('LOGGED')) {
			$this->index();
			return;
		}
		$id = ($id!="")?$id:$this->input->post('id');
		$data = $this->load->view('content/dokumen/manualkarantina', $data, true);
		if($this->input->post("ajax")||$act=="post"){
			return $arrdata;
		}else{
			return $data;
		}
	}

	public function FunctionName()
	{
		$this->load->helper('email');
		$this->load->library('email');

$this->email->initialize(array(
  'protocol' => 'smtp',
  'smtp_host' => 'smtp.sendgrid.net',
  'smtp_user' => 'yanzadmiral',
  'smtp_pass' => 'cijati211',
  'smtp_port' => 587,
  'crlf' => "\r\n",
  'newline' => "\r\n"
));

$this->email->from('yayan@gmail.com', 'yayan');
$this->email->to('yayanchy@gmail.com');
$this->email->subject('Email Test');
$this->email->message('Testing the email class.');
$this->email->send();

echo $this->email->print_debugger();
	}

	// public function spk_relokasi() {
	// 	if (!$this->session->userdata('LOGGED')) {
	// 		$this->index();
	// 		return;
	// 	}
	
	// 	// Load the model
	// 	$this->load->model('SpkRelokasiModel');
	
	// 	// Fetch header data
	// 	$data['headers'] = $this->SpkRelokasiModel->get_all_headers();
	
	// 	// Pass the header data to the view
	// 	$this->content = $this->load->view('content/spk_relokasi/index', $data, true);
	// 	$this->index();
	// }
	
	// public function spk_relokasi_detail($id_spk) {
	// 	if (!$this->session->userdata('LOGGED')) {
	// 		$this->index();
	// 		return;
	// 	}
	
	// 	// Load the model
	// 	$this->load->model('SpkRelokasiModel');
	
	// 	// Fetch header and container data
	// 	$data['header'] = $this->SpkRelokasiModel->get_header_by_id($id_spk); // Optional if you need header data
	// 	$data['containers'] = $this->SpkRelokasiModel->get_containers_by_spk($id_spk);
	
	// 	// Pass the data to the view
	// 	$this->content = $this->load->view('content/spk_relokasi/detail', $data, true);
	// 	$this->index();
	// }

	// public function spk_relokasi_add() {
	// 	if (!$this->session->userdata('LOGGED')) {
	// 		$this->index();
	// 		return;
	// 	}
	
	// 	// Initialize the search result as an empty array
	// 	$data['permit_records'] = [];
	
	// 	// Check if 'no_dok_inout' parameter is present in the GET request
	// 	$no_dok_inout = $this->input->get('no_dok_inout');
	// 	if ($no_dok_inout) {
	// 		// Load the model
	// 		$this->load->model('SpkRelokasiModel');
			
	// 		// Fetch the records matching the no_dok_inout value
	// 		$data['permit_records'] = $this->SpkRelokasiModel->get_permits_by_no_dok($no_dok_inout);
	// 	}
	
	// 	// Load the add form view with search results
	// 	$this->content = $this->load->view('content/spk_relokasi/add', $data, true);
	// 	$this->index();
	// }
	
	// Method to fetch permit details by NO_DOK_INOUT
	// public function spk_relokasi_search_permit() {
	// 	if (!$this->session->userdata('LOGGED')) {
	// 		$this->index();
	// 		return;
	// 	}
	
	// 	// Get the search input
	// 	$no_dok_inout = $this->input->get('no_dok_inout');
	// 	$this->load->model('SpkRelokasiModel');
	
	// 	// Fetch permit data based on the search input
	// 	$permit = $this->SpkRelokasiModel->get_permit_by_no_dok($no_dok_inout);
	
	// 	// Load the add form view with the permit data
	// 	$data['permit_record'] = $permit;
	// 	$this->content = $this->load->view('content/spk_relokasi/add', $data, true);
	// 	$this->index();
	// }

	// public function spk_relokasi_fill_form() {
	// 	if (!$this->session->userdata('LOGGED')) {
	// 		$this->index();
	// 		return;
	// 	}
	
	// 	// Capture the GET parameters
	// 	$permit_id = $this->input->get('id');
	// 	$no_dok_inout = $this->input->get('no_dok_inout');
	// 	$tgl_dok = $this->input->get('tgl_dok');
	
	// 	// Load the model
	// 	$this->load->model('SpkRelokasiModel');
		
	// 	// Fetch the permit record by ID
	// 	$permit_record = $this->SpkRelokasiModel->get_permit_by_id($permit_id);
	
	// 	// Fetch container data related to the permit ID from t_permit_cont
	// 	$containers = $this->SpkRelokasiModel->get_containers_by_permit_id($permit_id);
	
	// 	// Pass the permit record and container data to the add view
	// 	$data['permit_record'] = $permit_record;
	// 	$data['containers'] = $containers;
	// 	$this->content = $this->load->view('content/spk_relokasi/fill_add', $data, true);
	// 	$this->index();
	// }	
	// public function spk_relokasi_store() {
	// 	if (!$this->session->userdata('LOGGED')) {
	// 		$this->index();
	// 		return;
	// 	}
	
	// 	// Capture the posted data
	// 	$no_spk = $this->input->post('no_spk');
	// 	$tgl_spk = $this->input->post('tgl_spk'); // Format: d-m-Y
	// 	$no_dok = $this->input->post('no_dok');
	// 	$tgl_dok = $this->input->post('tgl_dok'); // Format: d-m-Y
	// 	$containers = $this->input->post('containers');
	
	// 	// Convert the date format from d-m-Y to Y-m-d for database insertion
	// 	$tgl_spk_db = date('Y-m-d', strtotime($tgl_spk));
	// 	$tgl_dok_db = date('Y-m-d', strtotime($tgl_dok));
	
	// 	// Data to be inserted into t_spk_relocation_hdr
	// 	$hdr_data = [
	// 		'NO_SPK' => $no_spk,
	// 		'TGL_SPK' => $tgl_spk_db, // Use the converted date
	// 		'NO_DOK' => $no_dok,
	// 		'TGL_DOK' => $tgl_dok_db, // Use the converted date
	// 	];
	
	// 	// Insert into t_spk_relocation_hdr
	// 	$this->db->insert('t_spk_relocation_hdr', $hdr_data);
	// 	$insert_id = $this->db->insert_id(); // Get the inserted ID for the header
	
	// 	// Check if header insert was successful and there are containers to insert
	// 	if ($insert_id && !empty($containers)) {
	// 		// Prepare data for t_spk_relocation_cont
	// 		$cont_data = [];
	// 		foreach ($containers as $container) {
	// 			$cont_data[] = [
	// 				'ID_SPK' => $insert_id, // Reference to the header ID
	// 				'NO_CONT' => $container,
	// 			];
	// 		}
	
	// 		// Insert multiple rows into t_spk_relocation_cont
	// 		$this->db->insert_batch('t_spk_relocation_cont', $cont_data);
	// 	}
	
	// 	// Optionally, redirect or display a success message
	// 	redirect('planning/spk_relokasi'); // Redirect back to the listing page, for example
	// }
	
	// public function create_gatepass($id_container) {
	// 	if (!$this->session->userdata('LOGGED')) {
	// 		$this->index();
	// 		return;
	// 	}
	
	// 	// Load the required model
	// 	$this->load->model('SpkRelokasiModel');
	
	// 	// Fetch container details by ID
	// 	$container = $this->SpkRelokasiModel->get_container_by_id($id_container);
	
	// 	// Check if container exists
	// 	if (empty($container)) {
	// 		show_404(); // Display error if container not found
	// 		return;
	// 	}
	
	// 	// Pass the container data to the view to create the gatepass
	// 	$data['container'] = $container;
	// 	$this->content = $this->load->view('content/spk_relokasi/create_gatepass', $data, true);
	// 	$this->index();
	// }
	
	// public function search_by_nodok() {
	// 	if (!$this->session->userdata('LOGGED')) {
	// 		$this->index();
	// 		return;
	// 	}
	
	// 	$no_dok = $this->input->post('no_dok');
	
	// 	$this->load->model('SpkRelokasiModel');
	// 	$results = $this->SpkRelokasiModel->search_by_nodok($no_dok);
	
	// 	echo json_encode($results);
	// }
	
	// public function update_container() {
	// 	$id = $this->input->post('id');
		
	// 	// Load the model
	// 	$this->load->model('SpkRelokasiModel');
		
	// 	// Get the SPK by container ID
	// 	$id_spk = $this->SpkRelokasiModel->get_spk_by_container_id($id);
		
	// 	// Handle case where no SPK is found
	// 	if ($id_spk === null) {
	// 		echo "No SPK found for the given container ID.";
	// 		return; // Use return instead of exit for better control flow
	// 	}
	
	// 	echo "ID_SPK: " . $id_spk . "<br>";
	
	// 	// Prepare data array for the update
	// 	$data = array(
	// 		'NO_CONT' => $this->input->post('no_cont'),
	// 		'SIZE' => $this->input->post('ukr_cont'),
	// 		'TYPE' => $this->input->post('tipe_cont'),
	// 		'ISOCODE' => $this->input->post('iso_code'),
	// 		'NPWP' => $this->input->post('npwp'), // Fixed the typo
	// 		'CONSIGNEE' => $this->input->post('nama_cust'),
	// 		'NM_KAPAL' => $this->input->post('vessel'),
	// 		'VOYAGE' => $this->input->post('voy_in'),
	// 		'BRUTO' => $this->input->post('bruto'),
	// 		'NO_BC11' => $this->input->post('no_bc11'),
	// 		'TGL_BC11' => $this->input->post('tgl_dok'),
	// 	);
		
	
	// 	// Retrieve SPK data by ID_SPK
	// 	$spk_data = $this->SpkRelokasiModel->get_spk_by_id($id_spk);
	
	// 	// Handle case where no SPK data is found
	// 	if ($spk_data === null) {
	// 		echo "No SPK data found for the given ID_SPK.";
	// 		return; // Again, use return for better flow control
	// 	}

	// 	$gatepass_data = array(
	// 		'JNS_DOK'      => $spk_data->JENIS_DOK,   // Dynamic from $spk_data
	// 		'NO_DOK'       => $spk_data->NO_DOK,      // Dynamic from $spk_data
	// 		'TGL_DOK'      => $spk_data->TGL_DOK,     // Dynamic from $spk_data
	// 		'STATUS'       => 'WAITING',              // Hardcoded
	// 		'JNS_KEGIATAN' => '3',                    // Hardcoded
	// 		'NO_CONT'      => $this->input->post('no_cont'),  // From form input
	// 		'UKR_CONT'     => $this->input->post('ukr_cont'), // From form input
	// 		'NPWP'         => '021066204093000',      // Hardcoded
	// 		'NAMA_CUST'    => 'MULTI TERMINAL INDONESIA', // Hardcoded
	// 		'NM_KAPAL'     => $this->input->post('vessel'),  // From form input
	// 		'NO_VOY'       => $this->input->post('voy_in'),  // From form input
	// 		'BRUTO'        => $this->input->post('bruto'),   // From form input
	// 	);
	
	// 	// Debugging output
	// 	echo '<pre>';
	// 	print_r($spk_data); // Debug SPK data
	// 	print_r($id);       // Debug container ID
	// 	print_r($data);     // Debug data to be updated
	// 	print_r($gatepass_data);
	// 	echo '</pre>';
	
	// 	// Optionally remove or comment out the following line once debugging is done
	// 	exit;
	
	// 	// Update the container
	// 	$update_status = $this->SpkRelokasiModel->update_container($id, $data);
		
	// 	// Redirect or show error based on the update status
	// 	if ($update_status) {
	// 		redirect('some_success_page');
	// 	} else {
	// 		$this->load->view('some_error_page');
	// 	}
	// }
	
}
