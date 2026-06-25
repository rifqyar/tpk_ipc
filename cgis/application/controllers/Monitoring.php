<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Monitoring extends CI_Controller {
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
	
	function process($type="",$act="", $id=""){//print_r($type.$act);die();
		if (!$this->session->userdata('LOGGED')) {
			$this->index();
			return;
		}else{
			if (strtolower($_SERVER['REQUEST_METHOD']) != "post") {
				$this->load->model("m_monitoring");
				$this->m_monitoring->process($type,$act,$id);
			}else{
				$this->load->model("m_monitoring");
				$this->m_monitoring->process($type,$act,$id);
			}
		}
	}

	public function kontainer($act,$id){
		//echo "Monitoring Kontainer";die();//
		if (!$this->session->userdata('LOGGED')){
			$this->index();
			return;
		}
		$id = ($id!="")?$id:$this->input->post('id');//

		if($act=="detail"){
			$data['id'] = $id;
			$data['action'] = 'save';
			$this->load->model('m_monitoring');
			$data['result_cont'] = $this->m_monitoring->get_data('operation', $id);
			$data['terbitspk'] = $this->m_monitoring->get_terbitspk($id);
			$data['get_terbitbehandle2'] = $this->m_monitoring->get_terbitbehandle2($id);
			$data['reqbehandle1New'] = $this->m_monitoring->get_reqbehandle1New($id);
			$data['rbehandle1'] = $this->m_monitoring->get_reqbehandle1($id);
			$data['rbehandle2'] = $this->m_monitoring->get_reqbehandle2($id);
			$data['penarikan'] = $this->m_monitoring->get_penarikan($id);
			$data['pembehandle1'] = $this->m_monitoring->get_pembehandle1($id);
			$data['pemeriksaan_behandle1'] = $this->m_monitoring->get_data('pemeriksaan_behandle1',$id);
			$data['m_exb1'] = $this->m_monitoring->get_data('m_exb1',$id);
			$data['m_behandle2'] = $this->m_monitoring->get_data('m_behandle2',$id);
			$data['m_exb2'] = $this->m_monitoring->get_data('m_exb2',$id);
			 //print_r($data['m_exb2']);die();
			/*$data['cek_m_exb2'] = count($this->m_monitoring->get_data('cek_m_exb2',$id));
			$cek_mbex2 = $data['cek_m_exb2'];
			if($cek_mbex2 == 2){
				$data['m_exb2'] = $this->m_monitoring->get_data('m_exb2',$id);
			}else {
				$data['m_exb2'] = "-";
			}*/
			//print_r($cek_mbex2);
			$data['pembehandle2'] = $this->m_monitoring->get_pembehandle2($id);
			$data['delivery'] = $this->m_monitoring->get_delivery($id);
			$data['bill_behandle1'] = $this->m_monitoring->get_behandle1($id);
			$data['bill_behandle2'] = $this->m_monitoring->get_behandle2($id);
			//print_r($data['pembehandle2']);//die();
			$data['reqdelivery'] = $this->m_monitoring->get_reqdelivery($id);
			$data['delivext'] = $this->m_monitoring->get_delivext($id);
			echo $this->load->view('content/monitoring/detail_cont',$data,true);
		}else{
			$this->load->model("m_monitoring");
			$arrdata = $this->m_monitoring->list_kontainer($act, $id);
			$data = $this->load->view('content/newtable', $arrdata, true);
			if($this->input->post("ajax")||$act=="post"){
				echo $arrdata;
			}else{
				$this->content = $data;
				$this->index();
			}
		}
	}
	
	
	public function delivery($act,$id){
		//echo "Monitoring Kontainer";die();//
		if (!$this->session->userdata('LOGGED')){
			$this->index();
			return;
		}
		$id = ($id!="")?$id:$this->input->post('id');//

		if($act=="detail"){
			$data['id'] = $id;
			$data['action'] = 'save';
			$this->load->model('m_monitoring');
			$data['result_cont'] = $this->m_monitoring->get_data('operation', $id);
			$data['reqbehandle1New'] = $this->m_monitoring->get_reqbehandle1New($id);
			$data['rbehandle1'] = $this->m_monitoring->get_reqbehandle1($id);
			$data['rbehandle2'] = $this->m_monitoring->get_reqbehandle2($id);
			$data['penarikan'] = $this->m_monitoring->get_penarikan($id);
			$data['pembehandle1'] = $this->m_monitoring->get_pembehandle1($id);
			$data['pemeriksaan_behandle1'] = $this->m_monitoring->get_data('pemeriksaan_behandle1',$id);
			$data['m_exb1'] = $this->m_monitoring->get_data('m_exb1',$id);
			$data['m_behandle2'] = $this->m_monitoring->get_data('m_behandle2',$id);
			$data['m_exb2'] = $this->m_monitoring->get_data('m_exb2',$id);
			$data['pembehandle2'] = $this->m_monitoring->get_pembehandle2($id);
			//print_r($data['m_behandle2']);//die();
			$data['delivery'] = $this->m_monitoring->get_delivery($id);
			$data['reqdelivery'] = $this->m_monitoring->get_reqdelivery($id);
			$data['delivext'] = $this->m_monitoring->get_delivext($id);
			echo $this->load->view('content/monitoring/detail_cont',$data,true);
		}else{
			$this->load->model("m_monitoring");
			$arrdata = $this->m_monitoring->list_delivery($act, $id);
			$data = $this->load->view('content/newtable', $arrdata, true);
			if($this->input->post("ajax")||$act=="post"){
				echo $arrdata;
			}else{
				$this->content = $data;
				$this->index();
			}
		}
	}

	public function jobslip($act,$id){
		if (!$this->session->userdata('LOGGED')){
			$this->index();
			return;
		}
		$id = ($id!="")?$id:$this->input->post('id');
		if($act=="detail"){
			$data['title'] = 'ENTRY CUSTOMER';
			$data['id'] = '';
			$data['action'] = 'save';
			$this->load->model('m_monitoring');
			$data['result_cont'] = $this->m_monitoring->get_data('detail_job', $id);
			//var_dump($data); die();
			echo $this->load->view('content/monitoring/detail_job',$data,true);
		}else{
			$this->load->model("m_monitoring");
			$arrdata = $this->m_monitoring->list_jobslip($act, $id);
			$data = $this->load->view('content/newtable', $arrdata, true);
			if($this->input->post("ajax")||$act=="post"){
				echo $arrdata;
			}else{
				$this->content = $data;
				$this->index();
			}
		}
	}

	function penarikan(){
		if (!$this->session->userdata('LOGGED')){
			$this->index();
			return;
		}

		$id = ($id!="")?$id:$this->input->post('id');

		$this->load->model("m_monitoring");
		$arrdata = $this->m_monitoring->list_penarikan();
		$data = $this->load->view('content/newtable', $arrdata, true);
		if($this->input->post("ajax")||$act=="post"){
			echo $arrdata;
		}else{
			$this->content = $data;
			$this->index();
		}
	}
	
	function karantina(){
		if (!$this->session->userdata('LOGGED')){
			$this->index();
			return;
		}

		$id = ($id!="")?$id:$this->input->post('id');

		$this->load->model("m_monitoring");
		$arrdata = $this->m_monitoring->list_karantina();
		$data = $this->load->view('content/newtable', $arrdata, true);
		if($this->input->post("ajax")||$act=="post"){
			echo $arrdata;
		}else{
			$this->content = $data;
			$this->index();
		}
	}
	
	function penarikanBaru(){
		if (!$this->session->userdata('LOGGED')){
			$this->index();
			return;
		}
		
		$this->load->model("m_monitoring");
		$dataArr['arrdata'] = $this->m_monitoring->get_data('penarikan','');
		//print_r($data);
		$data = $this->load->view('content/monitoring/penarikan', $dataArr, true);
		if($this->input->post("ajax")||$act=="post"){
			echo $dataArr;
		}else{
			$this->content = $data;
			$this->index();
		}
	}
	
	function filter(){
		$this->load->model('m_monitoring');
		$status_penarikan = $this->input->post('status_penarikan');
		$tgl = $this->input->post('tgl');
		$key = $status_penarikan."~".$tgl;
		
		$data = $this->m_monitoring->filter('penarikan', $key);
	}

	function longroomOld(){
		if (!$this->session->userdata('LOGGED')){
			$this->index();
			return;
		}

		$id = ($id!="")?$id:$this->input->post('id');

		$this->load->model("m_monitoring");
		$arrdata = $this->m_monitoring->list_longroom();
		$data = $this->load->view('content/newtable', $arrdata, true);
		if($this->input->post("ajax")||$act=="post"){
			echo $arrdata;
		}else{
			$this->content = $data;
			$this->index();
		}
	}
	
	function longroom(){
		if (!$this->session->userdata('LOGGED')){
			$this->index();
			return;
		}
		$this->load->model("m_monitoring");
		$arrdata['datalongroom'] = $this->m_monitoring->get_data('longroom','');
		$data = $this->load->view('content/monitoring/longroom', $arrdata, true);
		if($this->input->post("ajax")||$act=="post"){
			echo $arrdata;
		}else{
			$this->content = $data;
			$this->index();
		}
	}
	
	function filterLongroom(){
		$value = $this->input->post('vals');
		$kd_status = $this->input->post('statuslongroom');
		$key = $value."~".$kd_status;
		$this->load->model("m_monitoring");
		$arrdata = $this->m_monitoring->get_data('filterLongroom',$key);
		print_r($arrdata);
	}

	public function reefer($act,$id) {
		if (!$this->session->userdata('LOGGED')){
			$this->index();
			return;
		}

		$id = ($id!="")?$id:$this->input->post('id');

		if($act=="detail"){
			$data['id'] = $id;
			$data['action'] = 'save';
			$this->load->model('m_monitoring');
			// $data['result_cont'] = $this->m_monitoring->result_reefer($id);
			$data['monitor_plug'] = $this->m_monitoring->monitor_plug($id);
			echo $this->load->view('content/monitoring/detail_reefer',$data,true);
		} else if($act=="cetak_monitoring") {
			$data['id'] = $id;
			$data['action'] = 'save';
			$this->load->model('m_monitoring');
			$this->load->library('mpdf');
			$sess = $this->session->userdata('USERLOGIN');
			$data['title'] = "".$sess;
			$data['result_cont'] = $this->m_monitoring->get_data('cetak_monitor', $id);
			$data['monitor_cont'] = $this->m_monitoring->get_data('monitor_cont', $id);
			$data['result_utama'] = $this->m_monitoring->get_data('cetak_utama', $id);
			$this->load->view('content/monitoring/print_monitor', $data);
		}else{
			$this->load->model("m_monitoring");
			$arrdata = $this->m_monitoring->monitor_reefer($act, $id);
			$data = $this->load->view('content/newtable', $arrdata, true);
			if($this->input->post("ajax")||$act=="post"){
				echo $arrdata;
			}else{
				$this->content = $data;
				$this->index();
			}
		}
	}

	function monitor_pkb($act, $id) {
		$this->load->model("m_monitoring");
		$arrdata = $this->m_monitoring->pkb_monitor($act, $id);
		$data = $this->load->view('content/newtable', $arrdata, true);
		if($this->input->post("ajax")||$act=="post"){
			echo $arrdata;
		}else{
			$this->content = $data;
			$this->index();
		}
	}

	function monitor_ppjk(){
		if (!$this->session->userdata('LOGGED')){
			$this->index();
			return;
		}
		$arrdata = '';
		$data = $this->load->view('content/monitoring/ppjk', '', true);
		if($this->input->post("ajax")||$act=="post"){
			echo $arrdata;
		}else{
			$this->content = $data;
			$this->index();
		}
	}
	function httes(){
		if (!$this->session->userdata('LOGGED')){
			$this->index();
			return;
		}
		$arrdata = '';
		$data = $this->load->view('content/httes', '', true);
		if($this->input->post("ajax")||$act=="post"){
			echo $arrdata;
		}else{
			$this->content = $data;
			$this->index();
		}
	}
}
