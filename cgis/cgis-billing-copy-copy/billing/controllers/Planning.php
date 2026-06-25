<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Planning extends CI_Controller {
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
				$this->load->view('content/error');
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
		$this->load->view('content/error',$this->index());
	}


	// public function gate_pass_behandle($act,$id, $id2){
	// 	if (!$this->session->userdata('LOGGED')){
	// 		$this->index();
	// 		return;
	// 	}
		
	// 	$id = ($id!="")?$id:$this->input->post('id');
	// 	if($act=="add"){
	// 		//print_r($id);
	// 		$data['title'] = 'GATE PASS BEHANDLE';
	// 		$data['id'] = $id;
	// 		$data['action'] = 'create';
	// 		$this->load->model("m_billing");
	// 		$data['detail'] = $this->gatepass_detail($act,$id);
	// 		//print_r("sini".$data);
	// 		echo $this->load->view('content/gatepass/gate_pass',$data,true);
	// 	}else if($act=="active_gatepass"){
	// 		$this->load->model("m_execute");
	// 		$data['arrdata'] = $this->m_execute->cek_data('active_gatepass', $id);
	// 	}else if($act=="update"){
	// 		//print_r($id);die();
	// 		$exarrid = explode("~",$id);
	// 		$nm_kapal = $exarrid[0];
	// 		$no_cont = $exarrid[1];
			
	// 		$data['title'] = 'GATE PASS BEHANDLE';
	// 		$data['id'] = $id;
	// 		$data['action'] = 'update';
	// 		$this->load->model("m_execute");
	// 		$data['arrdata'] = $this->m_execute->get_data('gatepass', $id);
	// 		//print_r("dasdsa".$data);die();
	// 		//var_dump($data); die();
	// 		echo $this->load->view('content/gatepass/detail',$data,true);
	// 	}else if($act=="update_gatepass"){
	// 		$data['title'] = 'UPDATE GATE PASS BEHANDLE 1';
	// 		$data['id'] = $id;
	// 		$data['action'] = 'gatepass_edit';
	// 		$this->load->model("m_execute");
	// 		$data['arrdata'] = $this->m_execute->get_data('gatepass_edit', $id);
	// 		echo $this->load->view('content/gatepass/gatepass_edit',$data,true);
	// 	}else if($act=="detail"){

	// 	}else if($act=="history"){
	// 		$this->load->model("m_planning");
	// 		$data['arrdata'] = $this->m_planning->get_data('history_gbe', $id);
	// 		echo $this->content = $this->load->view('content/dokumen/history_cetak',$data,true);
	// 	}else{
	// 		$this->load->model("m_planning");
	// 		$arrdata = $this->m_planning->gate_pass_behandle($act, $id);
	// 		$data = $this->load->view('content/newtable', $arrdata, true);
	// 		if($this->input->post("ajax")||$act=="post"){
	// 			echo $arrdata;
	// 		}else{
	// 			$this->content = $data;
	// 			$this->index();
	// 		}
	// 	}
	// }

	public function gate_pass_behandle($act,$id){
		$this->load->view('content/error',$this->index());
	}

	public function gate_pass_behandle2($act,$id){
		$this->load->view('content/error',$this->index());
	}


	// public function gate_pass_behandle2($act,$id, $id2){
	// 	if (!$this->session->userdata('LOGGED')){
	// 		$this->index();
	// 		return;
	// 	}
	// 	$id = ($id!="")?$id:$this->input->post('id');
	// 	if($act=="add"){
	// 		$data['title'] = 'GATE PASS BEHANDLE 2';
	// 		$data['id'] = $id;
	// 		$data['action'] = 'create';
	// 		$data['detail'] = $this->gatepass2_detail($act,$id);
	// 		echo $this->load->view('content/newtable',$data,true);
	// 	}else if($act=="save"){
	// 	//
	// 	}else if($act=="update"){
	// 		//print_r($id);
	// 		$data['title'] = 'GATE PASS BEHANDLE 2';
	// 		$data['id'] = $id;
	// 		$data['action'] = 'update';
	// 		$this->load->model("m_execute");
	// 		$data['arrdata'] = $this->m_execute->get_data('gatepass2', $id);
	// 		//var_dump($data['arrdata']);
	// 		$data['spk'] = $this->m_execute->get_data('spk_data', $data);
	// 		//var_dump($data['spk']); //die();
	// 		//echo $id; die();
	// 		//print_r($data); die();
	// 		echo $this->load->view('content/gatepass/detail2',$data,true);
	// 	}else if($act=="delete"){
	// 		/*$data['title'] = 'DELETE KAPAL';
	// 		$data['id'] = $id;
	// 		$data['action'] = 'update';
	// 		$this->load->model("m_execute");
	// 		$data['arrdata'] = $this->m_execute->get_data('kapal', $id);
	// 		//var_dump($data);die();
	// 		echo $this->load->view('content/kapal/form_add',$data,true);*/
	// 	}else if($act=="detail"){
	// 		//$this->index();
	// 	}else if($act=="history"){
	// 		$this->load->model("m_planning");
	// 		$data['arrdata'] = $this->m_planning->get_data('history_gbe', $id);
	// 		echo $this->content = $this->load->view('content/dokumen/history_cetak',$data,true);
	// 	}else{
	// 		$this->load->model("m_planning");
	// 		$arrdata = $this->m_planning->gate_pass_behandle2($act, $id);
	// 		$data = $this->load->view('content/newtable', $arrdata, true);
	// 		if($this->input->post("ajax")||$act=="post"){
	// 			echo $arrdata;
	// 		}else{
	// 			$this->content = $data;
	// 			$this->index();
	// 		}
	// 	}
	// }

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

	// public function spk($act, $id){
	// 	if (!$this->session->userdata('LOGGED')){
	// 		$this->index();
	// 		return;
	// 	}
	// 	$id = ($id!="")?$id:$this->input->post('id');

	// 	if($act=="spk_detail"){
	// 		//print_r($id);die();
	// 		$this->newtable->breadcrumb('SPK', site_url());
	// 		$this->newtable->breadcrumb('Planning', 'javascript:void(0)');
	// 		$this->newtable->breadcrumb('DETAIL ', site_url('planning/sppmp'));
	// 		$this->newtable->breadcrumb('SPK', 'javascript:void(0)');
	// 		$data['title'] = 'SPK';
	// 		$data['id'] = $id;
	// 		//print_r($id);die();
	// 		$this->load->model("m_planning");
	// 		$data['arrdata'] = $this->m_planning->get_data('detail_spk', $id);
	// 		//var_dump($data);die();
	// 		echo $this->content = $this->load->view('content/dokumen/detail_spk',$data,true);
	// 	} else if($act=="announcement_spk"){
	// 		if (!$this->session->userdata('LOGGED')){
	//             $this->index();
	//             return;
	//         }

	// 		//$func->load->model("m_main", "main");
	// 		//$cek = $this->m_main->get_uraian("SELECT count(LOKASI) AS JML FROM t_spk_cont A inner join reff_status_spk B on A.status_cont = B.id where A.ID = '".$id."'","JML");
	// 		$cek = $this->db->query("SELECT B.LOKASI FROM t_spk A inner join t_spk_cont B on A.ID = B.ID where A.ID = '".$id."'")->result_array();
	// 		$cek2 = $this->db->query("SELECT A.KD_STATUS FROM t_spk A where A.ID = '".$id."'")->result_array();
	// 		//echo count($cek); die('AAAAAA');
	//         $lokasi = 0;
	// 		for ($a=0; $a<count($cek); $a++){
	// 			if ($cek[$a]['LOKASI'] == ''){
	// 				$lokasi++;
	// 			}
	// 		}

	// 		if (count($cek) == 0){
	// 			$lokasi = 1;
	// 		}

	// 		if ($cek2[0]['KD_STATUS'] != '000' && $cek2[0]['KD_STATUS'] != '100' ) {
	// 			echo "<b>Kontainer Sudah Proses Pickup ..!! <b>";
	// 		} else if ($lokasi > 0){
	// 			//echo "MSG#ERR#GAGAL#";
	// 			echo "<b>Lokasi Kontainer Belum di Plan ..!! <b>";
	// 		} else {

	// 			$id = ($id!="")?$id:$this->input->post('id');
	// 			//print_r($id);die();
	// 			/*$SQL = $this->db->query("SELECT A.NO_SPK, CASE WHEN A.JNS_DOK = 19 THEN 'SPJM' ELSE 'SPPMP' END AS 'DOK', A.TGL_DOK, B.NO_CONT, A.NPWP, A.CONSIGNEE FROM t_spk A, t_spk_cont B WHERE A.ID = B.ID AND A.ID = '$id'")->row();*/
				
	// 			$SQL = $this->db->query("SELECT A.NO_SPK, C.NAMA AS 'DOK', A.NO_DOK,
	// 									A.TGL_DOK, B.NO_CONT, A.NPWP, A.CONSIGNEE FROM t_spk A, t_spk_cont B , reff_kode_dok_bc C
	// 									WHERE A.ID = B.ID AND A.JNS_DOK = C.ID AND A.ID ='$id'")->row();
	// 			$SQL2 = $this->db->query("SELECT A.NO_SPK, CASE WHEN A.JNS_DOK = 19 THEN 'SPJM' ELSE 'SPPMP' END AS 'DOK', A.TGL_DOK, B.NO_CONT FROM t_spk A, t_spk_cont B WHERE A.ID = B.ID AND A.ID = '$id'")->result_array();
	// 			for ($i=0; $i < count($SQL2); $i++) {
	// 				$tr .= '
	// 					<tr>
	// 						<td>'.$SQL2[$i]["NO_SPK"].'</td>
	// 						<td>'.$SQL2[$i]["NO_CONT"].'</td>
	// 					</tr>
	// 				';
	// 			}
	// 			$email2 = $this->db->query("SELECT EMAIL,KEGIATAN FROM reff_mail WHERE KEGIATAN = 'ANNOUNCE'")->result_array();
	// 		for ($i=0; $i <count($email2); $i++) {

	// 			$subject = "SPK PENARIKAN BEHANDLE - [".$SQL->CONSIGNEE."]";
	// 			$email = $email2[$i]['EMAIL'];//'nuridin.mu23@gmail.com';//$email2[$i]['EMAIL'];//'nuridin.mu23@gmail.com';//$mail;
	// 			$this->load->helper('email');
	// 			$email_success = 0;
	// 			if(valid_email($email)){
	// 				$config = array(
	// 					'protocol'  => 'smtp',
	// 					'smtp_host' => 'mail2.edi-indonesia.co.id',
	// 					'smtp_port' => 25,
	// 					'smtp_user' => '',
	// 					'smtp_pass' => '',
	// 					'mailtype'  => 'html',
	// 					'charset'   => 'iso-8859-1',
	// 					'wrapchars' => 100,
	// 					'crlf'         => "\r\n",
	// 					'newline'     => "\r\n",
	// 					'start_tls' => TRUE
	// 				);
	// 				$msg = '
	// 					<html lang="en">
	// 						<head>
	// 							<meta charset="UTF-8">
	// 							<title>Document</title>
	// 						</head>
	// 						<body>
	// 						<div>
	// 							<p>
	// 								Dengan Hormat,<br><br>
	// 								Bersama ini kami informasikan bahwa saat ini akan dilakukan pick up container untuk kebutuhan pemeriksaan (behandle) dengan data sebagai berikut :
	// 							</p>
	// 							<table border="0" class="table" width="100%">
	// 								<tr>
	// 									<td>Jenis Dokumen </td>
	// 									<td>:</td>
	// 									<td>'.$SQL->DOK.'</td>
	// 								</tr>
	// 								<tr>
	// 									<td>No./Tgl  Dok </td>
	// 									<td>:</td>
	// 									<td>'.$SQL->NO_DOK.'/'.$SQL->TGL_DOK.'</td>
	// 								</tr>
	// 							</table><br><br>
	// 							<table border="1" class="table" width="80%">
	// 								<tr>
	// 									<th>No. SPK</th>
	// 									<th>Nomor Kontainer</th>
	// 								</tr>
	// 								'.$tr.'
	// 							</table><br>
	// 							<div>
	// 								Atas perhatian dan kerjasamanya kami ucapkan terima kasih.<br><br>
	// 								=================================================================================<br><br>
	// 								<table border="0" class="table" width="100%">
	// 									<tr>
	// 										<td>
	// 											<img src="'.base_url().'/assets/images/ipc_logo.png" alt="">
	// 										</td>
	// 										<td>
	// 											<div style="color:#050567" align="justify">
	// 												This message was delivered by BOS - IPCTPK.
	// 												You are receiving this message because your email address are registered in our user database.
	// 												If you have any question or information regarding this message, or if you do not want to receive any notifications in the future, please contact our Customer Care officer.
	// 											</div>
	// 										</td>
	// 									</tr>
	// 								</table
	// 							</div>
	// 							</body>
	// 						</html>
	// 				';

	// 				$this->load->library('email', $config);
	// 				#$this->email->set_newline("\r\n");
	// 				$this->email->from('cgs.ipc@gmail.com', 'BOS NOTIFICATION - ANNOUNCEMENT');
	// 				$email = str_replace(';', ',', $email);
	// 				$this->email->to($email);
	// 				//$array_bcc = array('nuridin.mu23@gmail.com','muhammad.nuridin@edi-indonesia.co.id','salman.abdulaziz@edi-indonesia.co.id', 'cgs@indonesiaport.co.id', 'cgs.ipc@gmail.com','get@npct1.co.id');
	// 				//$this->email->bcc($array_bcc);
	// 				$this->email->subject($subject);
	// 				$this->email->message($msg);

	// 		 }
	// 				if ($this->email->send()){
	// 					$email_success = 1;
	// 					/*echo "<script>alert('Email Terkirim');window.location=''</script>";*/
	// 					echo " Email Terkirim ";
	// 					//echo "MSG#OK#Data berhasil dikirim#".site_url()."/planning/spk";
	// 					$this->db->where(array('ID' => $id));
	// 					$this->db->update('t_spk', array('KD_STATUS' => '100'));
	// 				}
	// 			}
	// 			return $email_success;
	// 			//print_r($SQL);die();
	// 		}
	// 				$action = '/planning/spk/post';
	// 				echo "MSG#OK#Data berhasil diproses#".site_url().$action;
	// 	} else if($act == "cetak_spk"){
	// 		//print_r($id);die();
	// 		$this->load->library('mpdf');
	// 		$this->load->model("m_execute");
	// 		$data['data'] = $this->m_execute->get_data('cetak_spk',$id);
	// 		$this->load->view('content/dokumen/print_spk', $data);
	// 	} else if($act == "history_spk"){
	// 		//print_r($id);die('AAAA');
	// 		//$this->load->model("m_execute");
	// 		//$data['data'] = $this->m_execute->get_data('cetak_spk',$id);
	// 		$this->load->model("m_planning");
	// 		$data['arrdata'] = $this->m_planning->get_data('history_spk', $id);
	// 		echo $this->content = $this->load->view('content/dokumen/history_cetak',$data,true);

	// 	} else if($act == "spk_create"){
	// 		//echo "sini";
	// 		//print_r($act);die();
	// 		/**/
	// 		$this->load->model("m_planning");
	// 		$arrdata = $this->m_planning->list_spk_create($act, $id);
	// 		$data = $this->load->view('content/newtable', $arrdata, true);
	// 		if($this->input->post("ajax")||$act=="post"){
	// 			echo $arrdata;
	// 		}else{
	// 			$this->content = $data;
	// 			$this->index();
	// 		}
	// 	}else if($act == "add_spk"){
	// 		//echo "sini";die();
	// 		//print_r($id);die();
	// 		if (!$this->session->userdata('LOGGED')){
	//             $this->index();
	//             return;
	//         }
	//         $id = ($id!="")?$id:$this->input->post('id');
	//         $this->newtable->breadcrumb('REQUEST', site_url());
	//         $this->newtable->breadcrumb('Planning', 'javascript:void(0)');
	//         $this->newtable->breadcrumb('Detail', 'javascript:void(0)');
	//         $data['page_title'] = 'Create SPK';
	//         $data['table_spk_req_detail'] = $this->req_detail_spk($act, $id);
	//         echo $this->content = $this->load->view('content/dokumen/req_detail',$data,true);
	// 	}else if($act=="gate_pass_request"){
	// 		/*echo "<button class='btn btn-primary'>SPJM</button>&nbsp;&nbsp;&nbsp;";
	// 		echo "<button class='btn btn-success'>SPPB</button>";
	// 		die();
	// 		$this->newtable->breadcrumb('Spjm', site_url());
	// 		$this->newtable->breadcrumb('Planning', 'javascript:void(0)');
	// 		$this->newtable->breadcrumb('List pelepasan_karantina', site_url('planning/pelepasan_karantina'));
	// 		$this->newtable->breadcrumb('Detail', 'javascript:void(0)');
	// 		$data['title'] = 'DETAIL pelepasan_karantina';
	// 		$data['id'] = $id;
	// 		//print_r($id);die();
	// 		$this->load->model("m_execute");
	// 		$data['arrdata'] = $this->m_execute->get_data_dokumen('gate_pass', $id);
	// 		//var_dump($data);die();
	// 		//$data['table_kontainer'] = $this->discharge_kontainer($act,$id);
	// 		//$data['table_kemasan'] = $this->discharge_kemasan($act,$id);
	// 		$this->content = $this->load->view('content/gate_pass',$data,true);
	// 		$this->index();*/
	// 		//echo "string";
	// 	}else{
	// 		$this->load->model("m_planning");
	// 		$arrdata = $this->m_planning->list_spk($act, $id);
	// 		$data = $this->load->view('content/newtable', $arrdata, true);
	// 		if($this->input->post("ajax")||$act=="post"){
	// 			echo $arrdata;
	// 		}else{
	// 			$this->content = $data;
	// 			$this->index();
	// 		}
	// 	}
	// }

	public function spk($act,$id){
		$this->load->view('content/error',$this->index());
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

	// public function placement($act, $id){
	// 	if (!$this->session->userdata('LOGGED')){
	// 		$this->index();
	// 		return;
	// 	}
	// 	$id = ($id!="")?$id:$this->input->post('id');

	// 	if($act=="add"){
	// 		/*echo "string";die();*/
	// 		$data['title'] = 'ENTRY KAPAL';
	// 		$data['id'] = '';
	// 		$data['action'] = 'save';
	// 		echo $this->load->view('content/kapal/form_add',$data,true);

	// 	}else if($act=="relokasia"){
	// 		$data['title'] = 'RELOKASI PLACEMENT';
	// 		$data['id'] = $id;
	// 		$data['action'] = 'create';
	// 		$this->load->model("m_planning");
	// 		$data['detail'] = $this->relokasi1($act, $id);
	// 		echo $this->load->view('content/placement/form_add2',$data,true);
	// 	} else if($act=="detail_placement"){
	// 		if (!$this->session->userdata('LOGGED')){
	//             $this->index();
	//             return;
	//         }
	//         $id = ($id!="")?$id:$this->input->post('id');
	//         $this->newtable->breadcrumb('REQUEST', site_url());
	//         $this->newtable->breadcrumb('Planning', 'javascript:void(0)');
	//         $this->newtable->breadcrumb('Detail', 'javascript:void(0)');
	//         $data['page_title'] = 'Create SPK';
	//         $data['table_spk_req_detail'] = $this->req_detail_spk($act, $id);
	//         echo $this->content = $this->load->view('content/dokumen/req_detail',$data,true);
	//        // $this->index();
	// 	} else if($act=="spk_announcement_placement"){
	// 		/*$data['title'] = 'UPDATE DISCHARGE';
	// 		$data['id'] = $id;
	// 		$data['action'] = 'update';
	// 		$this->load->model("m_execute");
	// 		$data['arrdata'] = $this->m_execute->get_data('kapal', $id);*/
	// 		echo "spk_announcement";
	// 		//echo $this->load->view('content/planning/shipment/update',$data,true);
	// 	}else if($act=="placement_lokasi"){
	// 		//echo "string";die();
	// 		//print_r($id);die();
	// 		$data['title'] = 'UPDATE LOKASI';
	// 		$data['id'] = $id;
	// 		$data['action'] = 'update';
	// 		$this->load->model("m_execute");
	// 		$data['arrdata'] = $this->m_execute->get_data('lokasi', $id);
	// 		echo $this->load->view('content/placement/form_add',$data,true);
	// 	}else if($act == "placement_lokasi_detail"){
	// 		//print_r($id);die();
	// 		$arrdata['id'] = $id;
	// 		$data['action'] = 'update';
	// 		$this->load->model("m_execute");
	// 		$this->load->model("m_setting");
	// 		$data['arrdata'] = $this->m_execute->get_data('lokasi', $id);
	// 		//print_r($data['arrdata']);die();
	// 		$data['arrdata_denah'] = $this->m_setting->get_data('lokasi_denah', $id);
	// 		$data['tier'] = $this->m_setting->get_data('tier', $id);
	// 		$data = $this->load->view('content/placement/set_location',$data,true);
	// 		if($this->input->post("ajax")||$act=="post"){
	// 			echo $arrdata;
	// 		}else{
	// 			$this->content = $data;
	// 			$this->index();
	// 		}
	// 	} else if($act == "spk_cetak"){
	// 		echo "spk_cetak";
	// 	} else if($act == "spk_create_placement"){
	// 		//echo "string";die();
	// 		//print_r($id);die();
	// 		$this->load->model("m_planning");
	// 		$arrdata = $this->m_planning->list_spk_create('spk_create', $id);
	// 		$data = $this->load->view('content/newtable', $arrdata, true);
	// 		if($this->input->post("ajax")||$act=="post"){
	// 			echo $arrdata;
	// 		}else{
	// 			$this->content = $data;
	// 			$this->index();
	// 		}
	// 		/*echo "string";die();
	// 		$this->newtable->breadcrumb('Request Spjm', site_url());
	// 		$this->newtable->breadcrumb('Planning', 'javascript:void(0)');
	// 		$this->newtable->breadcrumb('Gate Pass Request ', site_url('planning/sppmp'));
	// 		$this->newtable->breadcrumb('Spjm', 'javascript:void(0)');
	// 		$data['title'] = 'Request Spjm';
	// 		$data['id'] = $id;
	// 		//print_r($id);die();
	// 		$this->load->model("m_execute");
	// 		$data['arrdata'] = $this->m_execute->get_data_dokumen('get_data_dokumen', $id);*/
	// 	}else if($act=="gate_pass_request__placement"){
	// 		/*echo "<button class='btn btn-primary'>SPJM</button>&nbsp;&nbsp;&nbsp;";
	// 		echo "<button class='btn btn-success'>SPPB</button>";
	// 		die();
	// 		$this->newtable->breadcrumb('Spjm', site_url());
	// 		$this->newtable->breadcrumb('Planning', 'javascript:void(0)');
	// 		$this->newtable->breadcrumb('List pelepasan_karantina', site_url('planning/pelepasan_karantina'));
	// 		$this->newtable->breadcrumb('Detail', 'javascript:void(0)');
	// 		$data['title'] = 'DETAIL pelepasan_karantina';
	// 		$data['id'] = $id;
	// 		//print_r($id);die();
	// 		$this->load->model("m_execute");
	// 		$data['arrdata'] = $this->m_execute->get_data_dokumen('gate_pass', $id);
	// 		//var_dump($data);die();
	// 		//$data['table_kontainer'] = $this->discharge_kontainer($act,$id);
	// 		//$data['table_kemasan'] = $this->discharge_kemasan($act,$id);
	// 		$this->content = $this->load->view('content/gate_pass',$data,true);
	// 		$this->index();*/
	// 		//echo "string";
	// 	}else{
	// 		$this->load->model("m_planning");
	// 		$arrdata = $this->m_planning->list_placement($act, $id);
	// 		$data = $this->load->view('content/newtable', $arrdata, true);
	// 		if($this->input->post("ajax")||$act=="post"){
	// 			return $arrdata;
	// 		}else{
	// 			$this->content = $data;
	// 			$this->index();
	// 		}
	// 	}
	// }

	public function placement($act,$id){
		$this->load->view('content/error',$this->index());
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
		$params['data'] = $data['result'][0]['TRANSACTION_ID']."/BHD";
		$params['size'] = 4;
		$params['level'] = 'H';
		$params['savename'] = 'assets/files/qrcode/code.png';
		$this->ciqrcode->generate($params);
		$this->load->view('content/gatepass/cetak_gatepass_delivery', $data);
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
            //echo $this->load->view('content/dokumen/manualadd', $data, true);
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
            //$data['arr_group'] = $this->m_planning->get_combobox('group');
            $data['arrdata'] = $this->m_planning->get_data('dok_manualhdr', $id);
			$data['array_cont'] = $this->m_planning->get_data('dok_manualcont', $id);
            echo $this->load->view('content/dokumen/manualadd', $data, true);
        }else if($act=="manual_detail"){
        	//echo $id;die();
			/*$this->newtable->breadcrumb('Request Spjm', site_url());
			$this->newtable->breadcrumb('Planning', 'javascript:void(0)');
			$this->newtable->breadcrumb('Gate Pass Request ', site_url('planning/sppmp'));
			$this->newtable->breadcrumb('Spjm', 'javascript:void(0)');
			$data['title'] = 'Request Spjm';
			$data['id'] = $id;*/
			//print_r($id);die();
			$this->load->model("m_execute");
			$data['arrdata'] = $this->m_execute->get_data_dokumen('detail_dok_manual', $id);
			//print_r($data);die();
			echo $this->content = $this->load->view('content/dokumen/detail_dok_manual',$data,true);
		} else {
            $arrdata = $this->m_planning->manual($act, $id);
            $data = $this->load->view('content/newtable', $arrdata, true);
            if ($this->input->post("ajax") || $act == "post") {
                echo $arrdata;
				//$this->index();
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
}
