<?php
	class Setting extends CI_Controller {
	public $content;
	
	public function __construct() {
        parent::__construct();
    }
	
	public function index(){		
		#Stylesheets
		$headers .= '<link rel="stylesheet" href="'.base_url().'assets/css/bootstrap.min.css?v2.1.0">';
		$headers .= '<link rel="stylesheet" href="'.base_url().'assets/css/bootstrap-extend.min.css?v2.1.0">';
		$headers .= '<link rel="stylesheet" href="'.base_url().'assets/css/site.min.css?v2.1.0">';
		$headers .= '<link rel="stylesheet" href="'.base_url().'assets/vendor/jquery-ui/jquery-ui.min.css?v2.1.0">';
		#Plugins For This Page
  		$headers .= '<link rel="stylesheet" href="'.base_url().'assets/vendor/filament-tablesaw/tablesaw.min.css?v2.1.0">';
		$headers .= '<link rel="stylesheet" href="'.base_url().'assets/vendor/uikit/modals.min.css?v2.1.0">';
		$headers .= '<link rel="stylesheet" href="'.base_url().'assets/vendor/bootstrap-datetimepicker/bootstrap-datetimepicker.min.css?v2.1.0">';
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
		//$headers .= '<script src="'.base_url().'assets/js/jquery-ui.js"></script>';
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
		if($this->session->userdata('LOGGED')){
			if($this->content==""){
				$this->load->view('content/error');
			}
			$data = array('_title_' 	  => 'BOS',
						  '_headers_' 	  => $headers,
						  '_header_' 	  => $this->load->view('content/header','',true),
						  '_menus_'		  => $this->load->view('content/menus','',true),
						  '_breadcrumbs_' => $this->load->view('content/breadcrumbs','',true),
						  '_content_' 	  => $this->content,
						  '_footers_' 	  => $footers,
						  '_footer_' 	  => $this->load->view('content/footer','',true));
			$this->parser->parse('index', $data);
		}else{
			redirect(base_url('index.php'),'refresh');	
		}
	}
	
	// public function denah_lapangan(){
	// 	if (!$this->session->userdata('LOGGED')){
	// 		$this->index();
	// 		return;
	// 	}
	// 	/**/$id = ($id!="")?$id:$this->input->post('id');
	// 	if($act=="add"){

	// 		$data['id'] = $id;
	// 		$data['title'] = 'Billing Delivery';
	// 		$data['action'] = "save";
	// 		$this->load->model("m_execute");
	// 		$data['arrdata'] = $this->m_execute->get_data_dokumen('sppb', $id);
	// 		//print_r($data);die();
	// 		//print_r($data);die();
	// 		$data['detail_cont'] = $this->m_execute->get_data_dokumen('detail_sppb', $id);
	// 		//var_dump($data);die();
	// 		$this->load->view('content/billing/simulasi/form', $data);
	// 	}else{
	// 		$page_title = "Denah Lapangan";
	// 		$title = "Denah Lapangan";
	// 		$this->newtable->breadcrumb('Dashboard', site_url(),'icon-home');
	// 		$this->newtable->breadcrumb('Setting', 'javascript:void(0)','');
	// 		$this->newtable->breadcrumb('Denah Lapangan', 'javascript:void(0)','');
	// 		$data['title'] = 'ENTRY DENAH';
	// 		$data['id'] = '';
	// 		$data['action'] = 'save';
	// 		$this->load->model("m_setting");
	// 		$data['arrdata_ya'] = $this->m_setting->get_data('detail_denah_YA', $id);
	// 		$data['arrdata_yb'] = $this->m_setting->get_data('detail_denah_YB', $id);
	// 		$data['arrdata_cic'] = $this->m_setting->get_data('detail_denah_cic', $id);
	// 		$data['arrdata_lap_ya'] = $this->m_setting->get_data('detail_denah_lapangan_ya', $id);
	// 		$data['arrdata_lap_yb'] = $this->m_setting->get_data('detail_denah_lapangan_yb', $id);
	// 		$data['arrdata_lap_cic'] = $this->m_setting->get_data('detail_denah_lapangan_cic', $id);
	// 		//print_r($data['arrdata_lap_ya']);die();
	// 		$data = $this->load->view('content/layout/form_denah',$data,true);
	// 		if($this->input->post("ajax")||$act=="post"){
	// 			echo $arrdata;
	// 		}else{
	// 			$this->content = $data;
	// 			$this->index();
	// 		}
	// 	}
	// 	//$this->denah();//
	// }

	public function denah_lapangan($act,$id){	
		$this->load->view('content/error',$this->index());
	}
	
	/* public function gudang_detail($act,$id){
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
			//print_r($data);die();
			$data['detail_cont'] = $this->m_execute->get_data_dokumen('detail_sppb', $id);
			//var_dump($data);die();
			$this->load->view('content/billing/simulasi/form', $data);
		}else{
			$this->load->model("m_setting");
			$arrdata = $this->m_setting->denah($type, $act);
			$data = $this->load->view('content/newtable', $arrdata, true);
			if ($this->input->post("ajax") || $act == "post") {
				echo $arrdata;
			} else {
				$this->content = $data;
				$this->index();
			}
		}
	} */
	
	public function gudang_detail($act,$id){
		$this->load->view('content/error',$this->index());
	}
	
	public function form_denah_act($act,$id){
		if (!$this->session->userdata('LOGGED')){
			$this->index();
			return;
		}
		$id = ($id!="")?$id:$this->input->post('id');
		if($act=="add"){
			$this->newtable->breadcrumb('Lapangan & Gudang', site_url()."/setting/gudang_detail");
			$this->newtable->breadcrumb('Entry', 'javascript:void(0)');
			$this->newtable->breadcrumb('Detail', 'javascript:void(0)');

			$data['title'] = 'ENTRY DENAH';
			$data['id'] = '';
			$data['action'] = 'save';
			$this->load->model("m_setting");
			$data['arrdata'] = $this->m_setting->get_data('detail_denah', $id);
			//print_r($data[0]['ID']);die();
			//echo $this->load->view('content/kapal/form_add',$data,true);
			echo $this->load->view('content/layout/add',$data,true);
			
		}else if($act=="update"){
			$data['title'] = 'UPDATE DENAH';
			$data['id'] = $id;
			$data['action'] = 'update';
			$this->load->model("m_setting");
			$data['arrdata'] = $this->m_setting->get_data_denah('denah1', $id);
			echo $this->load->view('content/layout/add',$data,true);
		}else if($act=="detail"){
			//print_r($id);die();
			$data['title'] = 'DETAIL DENAH';
			$data['id'] = $id;
			$data['action'] = 'update';
			$this->load->model("m_setting");
			$data['arrdata'] = $this->m_setting->get_data('detail_denah', $id);
			$data['iddata'] = $this->m_setting->get_data('detail_denah_iddata', $id);
			//print_r($data);die();
			//echo grant();
			$data = $this->load->view('content/layout/detail_denah',$data,true);
			if($this->input->post("ajax")||$act=="post"){
				echo $arrdata;
			}else{
				$this->content = $data;
				$this->index();
			}
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
	
	function form_denah($type="", $id="") {
        $func = get_instance();
        $func->load->model("m_main", "main", true);
        $this->load->library('newtable');
        $add_header = '<link rel="stylesheet" href="' . base_url() . 'assets/layout/css/stylesheets.css">';
        $add_header .= '<link rel="stylesheet" href="' . base_url() . 'css/newtable.css">';
        $add_header .= '<link rel="stylesheet" href="' . base_url() . 'assets/layout/css/alerts.css">';
        $add_header .= '<link rel="stylesheet" href="' . base_url() . 'assets/layout/css/stepy/smart_wizard.css">';
        //$add_header .= '<script src="' . base_url() . 'js/plugins/jquery/jquery.min.js"></script>';
        //$add_header .= '<script src="' . base_url() . 'js/plugins/jquery/jquery-ui.min.js"></script>';
        $add_header .= '<script src="' . base_url() . 'assets/layout/jquery/jquery-migrate.min.js"></script>';
        //$add_header .= '<script src="' . base_url() . 'js/plugins/bootstrap/bootstrap.min.js"></script>';
        $add_header .= '<script src="' . base_url() . 'assets/layout/uniform/jquery.uniform.min.js"></script>';
        $add_header .= '<script src="' . base_url() . 'assets/layout/jquery/plugins.js"></script>';
        $add_header .= '<script src="' . base_url() . 'js/newtable.js"></script>';
        //$add_header .= '<script src="' . base_url() . 'js/alerts.js"></script>';
        //$add_header .= '<script src="' . base_url() . 'js/main.js"></script>';
        $add_header .= '<script src="' . base_url() . 'assets/layout/stepy/jquery.smartWizard-2.0.js"></script>';
        $add_header .= '<script src="' . base_url() . 'assets/layout/noty/jquery.noty.js"></script>';
        $add_header .= '<script src="' . base_url() . 'assets/layout/noty/layouts/topCenter.js"></script>';
        $add_header .= '<script src="' . base_url() . 'assets/layout/noty/layouts/topLeft.js"></script>';
        $add_header .= '<script src="' . base_url() . 'assets/layout/noty/layouts/topRight.js"></script>';
        $add_header .= '<script src="' . base_url() . 'assets/layout/noty/themes/default.js"></script>';
        $add_header .= '<script src="' . base_url() . 'assets/layout/jquery/referensi.js"></script>';
        if ($type == "tambah") {
            $this->newtable->breadcrumb('Home', site_url());
            $this->newtable->breadcrumb('Setting', "javascript:void(0)");
            $this->newtable->breadcrumb('Denah', site_url('setting/denah'));
            $this->newtable->breadcrumb('Input Denah', "javascript:void(0)");
            if ($this->session->userdata('LOGGED')) {
                if ($this->content == "") {
                    $this->content = $this->load->view('content/layout/add', '', true);
                }
                $data = array('_add_header_' => $add_header,
                    '_tittle_' => 'WMS',
                    '_header_' => $this->load->view('content/header', '', true),
                    '_content_' => $this->content,
                    '_footer_' => $this->load->view('content/footer', '', true));
                $this->parser->parse('index', $data);
            } else {
                redirect(base_url('index.php'), 'refresh');
            }
        } else if ($type == "edit") {
            $this->newtable->breadcrumb('Home', site_url());
            $this->newtable->breadcrumb('Reference', "javascript:void(0)");
            $this->newtable->breadcrumb('Denah', site_url('layout/denah'));
            $this->newtable->breadcrumb('Edit Denah', "javascript:void(0)");
            if ($this->newsession->userdata('LOGGED')) {
                if ($this->content == "") {
                    $this->load->model('m_setting');
                    $arrdata = $this->m_setting->get_data("denah", $id);
                    $this->content = $this->load->view('content/layout/edit', $arrdata, true);
                }
                $data = array('_add_header_' => $add_header,
                    '_tittle_' => 'WMS',
                    '_header_' => $this->load->view('content/header', '', true),
                    '_content_' => $this->content,
                    '_footer_' => $this->load->view('content/footer', '', true));
                $this->parser->parse('index', $data);
            } else {
                redirect(base_url('index.php'), 'refresh');
            }
        } else if ($type == "detail") {
			echo "detail";die();
            $this->newtable->breadcrumb('Home', site_url());
            $this->newtable->breadcrumb('Setting', "javascript:void(0)");
            $this->newtable->breadcrumb('Denah', site_url('setting/denah'));
            $this->newtable->breadcrumb('Detail Denah', "javascript:void(0)");
            if ($this->newsession->userdata('LOGGED')) {
                if ($this->content == "") {
                    $this->load->model('m_setting');
                    $arrdata = $this->m_setting->get_data("denah", $id);
                    $this->content = $this->load->view('content/layout/detail', $arrdata, true);
                }
                $data = array('_add_header_' => $add_header,
                    '_tittle_' => 'WMS',
                    '_header_' => $this->load->view('content/header', '', true),
                    '_content_' => $this->content,
                    '_footer_' => $this->load->view('content/footer', '', true));
                $this->parser->parse('index', $data);
            } else {
                redirect(base_url('index.php'), 'refresh');
            }
        }
    }
	
	public function insertDenah(){
		//print_r($_POST);die();
		$this->load->model('m_setting');
		$x = $this->input->post('x');
		$y = $this->input->post('y');
		$val = $x."-".$y;
		$data = array(
			'LEVEL_2' => $x,
			'LEVEL_3' => $y,
			'IDDATA' => $val,
			'KD_STATUS' => '000',
			'TGL_STATUS' => date('Y-m-d H:i:s')
		);
		$this->m_setting->inDen($data);
		echo "Berhasil";
	}
	
	public function insertToDenah(){
		//print_r($_POST);
		/*die();*/
		$this->load->model('m_setting');
		$kd = $this->input->post('kode');
		$blok = $this->input->post('blok');
		$nm_blok = $this->input->post('nm_blok');
		$penumpukan = $this->input->post('penumpukan');
		$xx = $this->input->post('xx');
		$yy = $this->input->post('yy');
		$val = $xx."-".$yy;
		$data = array(
			'KD_GUDANG_DTL' => $kd,
			'NM_BLOK' => $nm_blok,
			'LEVEL_1' => $blok,
			'LEVEL_2' => $xx,
			'LEVEL_3' => $yy,
			'LEVEL_4' => $penumpukan,
			'KD_STATUS' => '001',
			'IDDATA' => $val,
			'TGL_STATUS' => date('Y-m-d H:i:s')
			);
		//print_r($data);die();
		$cek = $this->m_setting->cekBlok($nm_blok);
		if (!$cek) {
			for($a = 1; $a <= $penumpukan; $a++){
				$this->db->insert('t_denah_lapangan',array('KD_GUDANG_DTL' => $kd,'NM_BLOK' => $nm_blok,'LEVEL_1' => $blok,
				'LEVEL_2' => $xx,'LEVEL_3' => $yy,'LEVEL_4' => $a,'IDDATA' => $val,'KD_STATUS' => '','TGL_STATUS' => date('Y-m-d H:i:s')));
			}
			echo json_encode(array("Info" => "Berhasil UPDATE","result" => "SUKSES"));
		} else {
			$alertTxt = "<div class=\"alert alert-danger\">
						    <strong>Warning!</strong> BLOK SUDAH ADA!
						  </div>";
			echo json_encode(array("Info" => "BLOK SUDAH ADA!","alert" => $alertTxt));
		}
	}
	
	public function getDenah(){
		$this->load->model('m_setting');
		$id = $this->input->post('id');
		echo json_encode($this->m_setting->get_data('detail_blok', $id));
		//echo json_encode($this->m_setting->get_data('totalCont', $id));
		//print_r($data);
		
	}	
	
	public function countData($aa = ''){
		//print_r($_POST);die();
		$this->load->model('m_setting');
		$id = $this->input->post('id');
		echo json_encode($this->m_setting->get_data('totalCont', $id));
		//echo $this->m_setting->get_data('totalCont', $id);
	}
	
	public function insertToDenah1(){
		$kd = $this->input->post('kode');
		$blok = $this->input->post('blok');
		$penumpukan = $this->input->post('penumpukan');
		$data = array(
			'KD_GUDANG_DTL' => $kd,
			'LEVEL_1' => $blok,
			'LEVEL_4' => $penumpukan,
			'KD_STATUS' => '001',
			);
			
		$SQL_MAX = $this->db->query("SELECT MAX(ID) AS ID FROM t_denah_lapangan")->result_array();
		$ID = $SQL_MAX[0]['ID'];
		$this->db->where(array('ID' => $ID));
		$this->db->update('t_denah_lapangan', $data);
		echo json_encode(array("Info" => "Berhasil UPDATE","result" => $ID));
	}

	public function getKd($act,$id){
		$this->load->model("m_setting");
		$data['arrdata'] = $this->m_setting->get_kd();
		//var_dump($data);die();
		$this->load->view('content/layout/form_denah',$data);
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
				$this->load->model("m_setting");
				$this->m_setting->process($type,$act,$id);
			}
		}
	}
	
	public function getTier(){
		$BLOK = $this->input->post('blok');
		$this->load->model('m_setting');
		echo $this->m_setting->getTier($BLOK);
	}
	
	public function updateDenah(){
		//print_r($_POST);die();
		$id = $this->input->post('id');
		$this->load->model('m_setting');
		echo json_encode($this->m_setting->get_data_denah('get_kd_lapangan', $id));
	}
	
	public function deleteToDenah(){
		$blok = $this->input->post('blok');
		//print($blok); die();
		$this->db->where('LEVEL_1', $blok);
   		$this->db->delete('t_denah_lapangan');
		//print($blok); 
	}
	
	public function updateToDenah(){
		$kd = $this->input->post('kode');
		$blok = $this->input->post('blok');
		$nm_blok = $this->input->post('nm_blok');
		$penumpukan = $this->input->post('penumpukan');
		$xx = $this->input->post('xx');
		$yy = $this->input->post('yy');
		$val = $xx."-".$yy;
		
		$this->db->where('LEVEL_1', $blok);
   		$this->db->delete('t_denah_lapangan');

   		$data = array(
			'KD_GUDANG_DTL' => $kd,
			'NM_BLOK' => $nm_blok,
			'LEVEL_1' => $blok,
			'LEVEL_2' => $xx,
			'LEVEL_3' => $yy,
			'LEVEL_4' => $penumpukan,
			'KD_STATUS' => '001',
			'IDDATA' => $val,
			'TGL_STATUS' => date('Y-m-d H:i:s')
			);
		$this->load->model('m_setting');
   		$cek = $this->m_setting->cekBlok($nm_blok);
		if (!$cek) {
			for($a = 1; $a <= $penumpukan; $a++){
				$this->db->insert('t_denah_lapangan',array('KD_GUDANG_DTL' => $kd,'NM_BLOK' => $nm_blok,'LEVEL_1' => $blok,
				'LEVEL_2' => $xx,'LEVEL_3' => $yy,'LEVEL_4' => $a,'IDDATA' => $val,'KD_STATUS' => '','TGL_STATUS' => date('Y-m-d H:i:s')));
			}
			echo json_encode(array("Info" => "Berhasil UPDATE","result" => "SUKSES"));
		} else {
			$alertTxt = "<div class=\"alert alert-danger\">
						    <strong>Warning!</strong> BLOK SUDAH ADA!
						  </div>";
			echo json_encode(array("Info" => "BLOK SUDAH ADA!","alert" => $alertTxt));
		}
		/*for($a = 1; $a <= $penumpukan; $a++){
			$this->db->insert('t_denah_lapangan',array('KD_GUDANG_DTL' => $kd,'NM_BLOK' => $nm_blok,'LEVEL_1' => $blok,
			'LEVEL_2' => $xx,'LEVEL_3' => $yy,'LEVEL_4' => $a,'IDDATA' => $val,'KD_STATUS' => '001','TGL_STATUS' => date('Y-m-d H:i:s')));
		}
		echo json_encode(array("Info" => "Berhasil UPDATE","result" => "SUKSES"));*/
	}
	
	public function insertGudang(){
		//print_r($this->input->post());//die();
		$ID_JOB = $this->input->post('ID_JOB');
		$NO_SPK = $this->input->post('NO_SPK');
		$sqlid = $this->db->query("SELECT ID FROM t_spk	WHERE NO_SPK='$NO_SPK' ")->row_array();
		$idspk = $sqlid['ID'];
		$GUDANG = $this->input->post('KODE_GDG');
		$BLOK = $this->input->post('BLOK');
		$LOK_AKHIR = $this->input->post('LOK_AKHIR');
		$NO_CONT = $this->input->post('NO_CONT');
		$PENUMPUKAN = $this->input->post('PENUMPUKAN');
		$cek_jns_kegiatan = $this->input->post('jns_kegiatan23');
		$no_dok = $this->input->post('no_dok');
		$lokasi_awal = $this->input->post('lokasi_awal');
		$X = $this->input->post('X');
		$Y = $this->input->post('Y');
		$VAL = $X."-".$Y;
		$SQLSTATUSCONT = $this->db->query("SELECT STATUS_CONT FROM t_spk_cont WHERE ID = '$idspk' AND NO_CONT = '$NO_CONT' ")->row();
		$STATUSCONT = $SQLSTATUSCONT->STATUS_CONT;
		echo $STATUSCONT;//die();
		//klo tidak masuk kondisi cek di jenis kegiatannya!
		if ($STATUSCONT == 450 || $STATUSCONT == 460 || $STATUSCONT == 500) {
			//echo "masuk cic = ".$cek_jns_kegiatan;
			//echo $LOK_AKHIR;
			$cekCIC = substr($LOK_AKHIR,0,3);
			if ($cekCIC == 'CIC') {
				
				//echo "cek cic = ".$cekCIC;die();
				if($cek_jns_kegiatan==1){
					$ubahlokasi = array(
						'STATUS_CONT' => '510'
					);
					$this->db->where(array('ID' => $idspk, 'NO_CONT' => $NO_CONT));
					$this->db->update('t_spk_cont', $ubahlokasi);
				}else if($cek_jns_kegiatan==2){
					//echo "sini masuk";die();
					$ubahlokasi = array(
						'STATUS_CONT' => '530'
					);
					$this->db->where(array('ID' => $idspk, 'NO_CONT' => $NO_CONT));
					$this->db->update('t_spk_cont', $ubahlokasi);
				}

				$dataPlan = array(
					'LOKASI_AKHIR' => $LOK_AKHIR,
					'TIER_AKHIR' => $PENUMPUKAN,
					'KD_STATUS' => '20', //default 10 karna masih ambigu
					'WK_STATUS' => date('Y-m-d H:i:s')
				);
				$this->db->where(array('ID_JOB_SLIP' => $ID_JOB,'NO_SPK' => $NO_SPK, 'NO_CONT' => $NO_CONT));
				$this->db->update('t_job_slip', $dataPlan);//echo"sini";die();
			}elseif((substr($LOK_AKHIR,0,2)=="1A") || (substr($LOK_AKHIR,0,2)=="1B")){
				//echo "1a".$cek_jns_kegiatan;//die();
				if($cek_jns_kegiatan==1){
					$ubahlokasi = array(
						'STATUS_CONT' => '520'
					);
					$this->db->where(array('ID' => $idspk, 'NO_CONT' => $NO_CONT));
					$this->db->update('t_spk_cont', $ubahlokasi);
				}else if($cek_jns_kegiatan==2){
					$ubahlokasi = array(
						'STATUS_CONT' => '540'
					);
					$this->db->where(array('ID' => $idspk, 'NO_CONT' => $NO_CONT));
					$this->db->update('t_spk_cont', $ubahlokasi);
				}

				$dataPlan = array(
					'LOKASI_AKHIR' => $LOK_AKHIR,
					'TIER_AKHIR' => $PENUMPUKAN,
					'KD_STATUS' => '20',
					'WK_STATUS' => date('Y-m-d H:i:s')
					);
				$this->db->where(array('ID_JOB_SLIP' => $ID_JOB,'NO_SPK' => $NO_SPK, 'NO_CONT' => $NO_CONT));
				$this->db->update('t_job_slip', $dataPlan);
			}
		}else {
			//echo "salah";die();
			$dataPlan = array(
				'LOKASI_AKHIR' => $LOK_AKHIR,
				'TIER_AKHIR' => $PENUMPUKAN,
				'KD_STATUS' => '20',
				'WK_STATUS' => date('Y-m-d H:i:s')
			);
			$this->db->where(array('ID_JOB_SLIP' => $ID_JOB, 'NO_SPK' => $NO_SPK, 'NO_CONT' => $NO_CONT));
			$this->db->update('t_job_slip', $dataPlan);
			$SQL_LOK_AWAL = $this->db->query("SELECT JNS_JOB_SLIP, NO_SPK, NO_CONT, IFNULL(LOKASI_AWAL, '-') AS LOKASI_AWAL 
											  FROM t_job_slip
											  WHERE ID_JOB_SLIP = '$ID_JOB' AND NO_CONT = '$NO_CONT'")->row();
			
			//print_r($SQL_LOK_AWAL->LOKASI_AWAL);
			//die();
			if ($SQL_LOK_AWAL->LOKASI_AWAL == "-") {
				$this->db->where(array('ID_JOB_SLIP' => $ID_JOB, 'NO_CONT' => $NO_CONT));
				$this->db->update('t_job_slip', array("STATUS" => "DRAFT"));
			}
			//print_r($this->db->last_query());die();
			$SQL_LOK = $this->db->query("SELECT IFNULL(B.LOKASI, '-') AS LOKASI
								FROM t_spk A INNER JOIN t_spk_cont B 
								ON A.ID = B.ID
								WHERE B.NO_CONT = '$NO_CONT'")->row();
			
			if ($SQL_LOK->LOKASI == "-" || $SQL_LOK->LOKASI == "" || $SQL_LOK->LOKASI == NULL) {
				echo "LOKASI NULL!";
				$this->db->query("UPDATE t_spk_cont a 
							JOIN t_spk b ON a.ID = b.ID  
							SET a.LOKASI = '$LOK_AKHIR', a.TIER = '$PENUMPUKAN'
							WHERE a.NO_CONT ='$NO_CONT'");
				
			}else{
				echo $SQL_LOK;
			}
			//print_r($this->db->last_query());die();
		}
		
		$this->db->where(array('LEVEL_1' => $BLOK, 'LEVEL_4' =>$PENUMPUKAN));
		$this->db->update('t_denah_lapangan', array('USE' => '1'));
	}
	
	public function updateGudangRelocation(){
		
		$ID_JOB = $this->input->post('ID_JOB');
		$NO_SPK = $this->input->post('NO_SPK');
		$GUDANG = $this->input->post('KODE_GDG');
		$BLOK = $this->input->post('BLOK');
		$LOK_AKHIR = $this->input->post('LOK_AKHIR');
		$LOK_AKHIR_LOCATION = $this->input->post('LOK_AKHIR_LOCATION');
		$NO_CONT = $this->input->post('NO_CONT');
		$PENUMPUKAN = $this->input->post('PENUMPUKAN');
		$TIER_AKHIR_LOCATION = $this->input->post('TIER_AKHIR_LOCATION');
		$X = $this->input->post('X');
		$Y = $this->input->post('Y');
		$VAL = $X."-".$Y;
		/*$SQL_LOK_AWAL = $this->db->query("SELECT JNS_JOB_SLIP, NO_SPK, NO_CONT, IFNULL(LOKASI_AWAL, '-') AS LOKASI_AWAL 
										  FROM t_job_slip
										  WHERE ID_JOB_SLIP = '$ID_JOB' AND NO_CONT = '$NO_CONT'")->row();
		if ($SQL_LOK_AWAL->LOKASI_AWAL == "-") {
			$this->db->where(array('ID_JOB_SLIP' => $ID_JOB, 'NO_CONT' => $NO_CONT));
			$this->db->update('t_job_slip', array("STATUS" => "DRAFT"));
		}*/

		$dataPlan = array(
			'LOKASI_AKHIR' => $LOK_AKHIR,
			'TIER_AKHIR' => $PENUMPUKAN,
			'KD_STATUS' => '20',
			'WK_STATUS' => date('Y-m-d H:i:s')
			);
		//print_r($_POST);
		//print_r($dataPlan);
		$this->db->where(array('NO_SPK' => $NO_SPK, 'NO_CONT' => $NO_CONT));
		$this->db->update('t_job_slip', $dataPlan);
		//die('sukses');
		/*$SQL_LOK = $this->db->query("SELECT IFNULL(B.LOKASI, '-') AS LOKASI
							FROM t_spk A INNER JOIN t_spk_cont B 
							ON A.ID = B.ID
							WHERE B.NO_CONT = '$NO_CONT'")->row();
		if ($SQL_LOK->LOKASI == "-" || $SQL_LOK->LOKASI == "" || $SQL_LOK->LOKASI == NULL) {
			echo "LOKASI NULL!";
			$this->db->query("UPDATE t_spk_cont a 
   						JOIN t_spk b ON a.ID = b.ID  
                        SET a.LOKASI = '$LOK_AKHIR', a.TIER = '$PENUMPUKAN'
   	                    WHERE a.NO_CONT ='$NO_CONT'");
			
		}else{
			echo $SQL_LOK;//"LOKASI SUDAH ADA!";
			//die();
		}*/
		
		$this->db->where(array('NM_BLOK' => $LOK_AKHIR_LOCATION, 'LEVEL_4' =>$TIER_AKHIR_LOCATION));
		$this->db->update('t_denah_lapangan', array('USE' => '0'));
		
		$this->db->where(array('LEVEL_1' => $BLOK, 'LEVEL_4' =>$PENUMPUKAN));
		$this->db->update('t_denah_lapangan', array('USE' => '1'));
		//print_r($this->db->last_query());
		//die('sukses');
	}
	
	public function getGudang(){
		$this->load->model('m_setting');
		echo $this->m_setting->getAreaGudang();
	}
	
	public function getNmBlok(){
		//print_r($_POST);die();
		$blok = $this->input->post('id');
		$this->load->model('m_setting');
		echo json_encode($this->m_setting->getNmBlok($blok));
	}
}
?>