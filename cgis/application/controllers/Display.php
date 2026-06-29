<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

class Display extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$headers .= '<link rel="apple-touch-icon" href="' . base_url() . 'assets/images/apple-touch-icon.png">';
		#Stylesheetss
		$headers  = '<link rel="stylesheet" href="' . base_url() . 'assets/css/bootstrap.min.css?v2.1.0">';
		$headers .= '<link rel="stylesheet" href="' . base_url() . 'assets/css/bootstrap-extend.min.css?v2.1.0">';
		$headers .= '<link rel="stylesheet" href="' . base_url() . 'assets/css/site.min.css?v2.1.0">';
		$headers .= '<link rel="stylesheet" href="' . base_url() . 'assets/vendor/jquery-ui/jquery-ui.min.css?v2.1.0">';
		#Plugins For This Page
		$headers .= '<link rel="stylesheet" href="' . base_url() . 'assets/vendor/filament-tablesaw/tablesaw.min.css?v2.1.0">';
		$headers .= '<link rel="stylesheet" href="' . base_url() . 'assets/vendor/uikit/modals.min.css?v2.1.0">';
		$headers .= '<link rel="stylesheet" href="' . base_url() . 'assets/vendor/bootstrap-datetimepicker/bootstrap-datetimepicker.min.css?v2.1.0">';
		$headers .= '<link rel="stylesheet" href="' . base_url() . 'assets/vendor/jquery-wizard/jquery-wizard.min.css?v2.1.0">';
		#Plugins
		$headers .= '<link rel="stylesheet" href="' . base_url() . 'assets/vendor/animsition/animsition.min.css?v2.1.0">';
		$headers .= '<link rel="stylesheet" href="' . base_url() . 'assets/vendor/asscrollable/asScrollable.min.css?v2.1.0">';
		$headers .= '<link rel="stylesheet" href="' . base_url() . 'assets/vendor/switchery/switchery.min.css?v2.1.0">';
		$headers .= '<link rel="stylesheet" href="' . base_url() . 'assets/vendor/intro-js/introjs.min.css?v2.1.0">';
		$headers .= '<link rel="stylesheet" href="' . base_url() . 'assets/vendor/slidepanel/slidePanel.min.css?v2.1.0">';
		$headers .= '<link rel="stylesheet" href="' . base_url() . 'assets/vendor/waves/waves.min.css?v2.1.0">';
		$headers .= '<link rel="stylesheet" href="' . base_url() . 'assets/vendor/sweetalert/sweetalert.css">';
		$headers .= '<link rel="stylesheet" href="' . base_url() . 'assets/vendor/themes/twitter.css">';
		$headers .= '<link rel="stylesheet" href="' . base_url() . 'assets/css/newtable.css">';
		$headers .= '<link rel="stylesheet" href="' . base_url() . 'assets/vendor/toastr/toastr.min.css">';
		#Fonts
		$headers .= '<link rel="stylesheet" href="' . base_url() . 'assets/fonts/material-design/material-design.min.css?v2.1.0">';
		$headers .= '<link rel="stylesheet" href="' . base_url() . 'assets/fonts/brand-icons/brand-icons.min.css?v2.1.0">';
		$headers .= '<link rel="stylesheet" href="' . base_url() . 'assets/fonts/font.css?v2.1.0">';
		#Scripts
		$headers .= '<script src="' . base_url() . 'assets/js/jquery.min.js"></script>';
		$headers .= '<script src="' . base_url() . 'assets/js/alerts.js"></script>';
		$headers .= '<script src="' . base_url() . 'assets/vendor/modernizr/modernizr.min.js"></script>';
		$headers .= '<script src="' . base_url() . 'assets/vendor/breakpoints/breakpoints.min.js"></script>';
		$headers .= '<script>Breakpoints();</script>';
		#Core
		$footers  = '<script src="' . base_url() . 'assets/vendor/jquery/jquery.min.js"></script>';
		$footers .= '<script src="' . base_url() . 'assets/vendor/jquery-ui/jquery-ui.min.js"></script>';
		$footers .= '<script src="' . base_url() . 'assets/vendor/bootstrap/bootstrap.js"></script>';
		$footers .= '<script src="' . base_url() . 'assets/vendor/bootstrap-datetimepicker/bootstrap-datetimepicker.js"></script>';
		$footers .= '<script src="' . base_url() . 'assets/vendor/animsition/animsition.min.js"></script>';
		$footers .= '<script src="' . base_url() . 'assets/vendor/asscroll/jquery-asScroll.min.js"></script>';
		$footers .= '<script src="' . base_url() . 'assets/vendor/mousewheel/jquery.mousewheel.min.js"></script>';
		$footers .= '<script src="' . base_url() . 'assets/vendor/asscrollable/jquery.asScrollable.all.min.js"></script>';
		$footers .= '<script src="' . base_url() . 'assets/vendor/ashoverscroll/jquery-asHoverScroll.min.js"></script>';
		$footers .= '<script src="' . base_url() . 'assets/vendor/waves/waves.min.js"></script>';
		#Plugins
		$footers .= '<script src="' . base_url() . 'assets/vendor/switchery/switchery.min.js"></script>';
		$footers .= '<script src="' . base_url() . 'assets/vendor/intro-js/intro.min.js"></script>';
		$footers .= '<script src="' . base_url() . 'assets/vendor/screenfull/screenfull.min.js"></script>';
		$footers .= '<script src="' . base_url() . 'assets/vendor/slidepanel/jquery-slidePanel.min.js"></script>';
		$footers .= '<script src="' . base_url() . 'assets/vendor/formatter-js/jquery.formatter.min.js"></script>';
		$footers .= '<script src="' . base_url() . 'assets/vendor/jquery-wizard/jquery-wizard.min.js"></script>';
		#Scripts
		$footers .= '<script src="' . base_url() . 'assets/js/core.min.js"></script>';
		$footers .= '<script src="' . base_url() . 'assets/js/site.min.js"></script>';
		$footers .= '<script src="' . base_url() . 'assets/js/sections/menu.min.js"></script>';
		$footers .= '<script src="' . base_url() . 'assets/js/sections/menubar.min.js"></script>';
		$footers .= '<script src="' . base_url() . 'assets/js/sections/gridmenu.min.js"></script>';
		$footers .= '<script src="' . base_url() . 'assets/js/sections/sidebar.min.js"></script>';
		$footers .= '<script src="' . base_url() . 'assets/js/configs/config-colors.min.js"></script>';
		$footers .= '<script src="' . base_url() . 'assets/js/components/asscrollable.min.js"></script>';
		$footers .= '<script src="' . base_url() . 'assets/js/components/animsition.min.js"></script>';
		$footers .= '<script src="' . base_url() . 'assets/js/components/slidepanel.min.js"></script>';
		$footers .= '<script src="' . base_url() . 'assets/js/components/switchery.min.js"></script>';
		$footers .= '<script src="' . base_url() . 'assets/js/newtable.js"></script>';
		$footers .= '<script src="' . base_url() . 'assets/js/reload.js"></script>';
		$footers .= '<script src="' . base_url() . 'assets/js/main.js"></script>';
		$footers .= '<script src="' . base_url() . 'assets/vendor/sweetalert/sweetalert.min.js"></script>';
		$footers .= '<script src="' . base_url() . 'assets/vendor/filament-tablesaw/tablesaw.js"></script>';
		$footers .= '<script src="' . base_url() . 'assets/vendor/toastr/toastr.min.js"></script>';
		$footers .= '<script src="' . base_url() . 'assets/js/components/input-group-file.min.js"></script>';
		$footers .= '<script src="' . base_url() . 'assets/js/components/formatter-js.min.js"></script>';
		$footers .= '<script src="' . base_url() . 'assets/js/components/jquery-wizard.min.js"></script>';

		if ($this->session->userdata('LOGGED')) {
			if ($this->content == "") {
				redirect(site_url(), 'refresh');
			}
			$data = array(
				'_title_' 	  => 'BOS',
				'_headers_' 	  => $headers,
				'_header_' 	  => $this->load->view('content/header', '', true),
				'_menus_'		  => $this->load->view('content/menus', '', true),
				'_breadcrumbs_' => $this->load->view('content/breadcrumbs', '', true),
				'_content_' 	  => (grant() == "") ? $this->load->view('content/error', '', true) : $this->content,
				'_footers_' 	  => $footers,
				'_footer_' 	  => $this->load->view('content/menus', '', true)
			);
			$this->parser->parse('index', $data);
		} else {
			redirect(base_url('index.php'), 'refresh');
		}
	}

	function custom()
	{
		if (!$this->session->userdata('LOGGED')) {
			$this->index();
			return;
		}
		$this->load->model("m_display");
		$arrdata['datacount'] = $this->m_display->get_data('count_longroom', '');
		$arrdata['datalongroom'] = $this->m_display->get_data('custom', '');
		// var_dump($arrdata['datacount']);
		// die();
		$data = $this->load->view('content/monitoring/custom', $arrdata, true);
		echo $data;
		/*if($this->input->post("ajax")||$act=="post"){
				echo $arrdata;
			}else{
				$this->content = $data;
				$this->index();
			}*/
	}

	function customspjm()
	{
		if (!$this->session->userdata('LOGGED')) {
			$this->index();
			return;
		}
		$this->load->model("m_display");
		$arrdata = $this->m_display->get_data_rekon();
		// var_dump($arrdata['datacount']);
		// die();

		$data = $this->load->view('content/newtable', $arrdata, true);
		if($this->input->post("ajax")||$act=="post"){
			echo $arrdata;
		}else{
			$this->content = $data;
			$this->index();
		}
	}

	function customplanner()
	{
		if (!$this->session->userdata('LOGGED')) {
			$this->index();
			return;
		}
		$this->load->model("m_display");
		$arrdata['datalongroom'] = $this->m_display->get_data('customplanner', '');
		$data = $this->load->view('content/monitoring/customplanner', $arrdata, true);
		echo $data;
		/*if($this->input->post("ajax")||$act=="post"){
				echo $arrdata;
			}else{
				$this->content = $data;
				$this->index();
			}*/
	}

	function list_antrian()
	{
		$this->load->model("m_display");
		$arrdata['datalongroom'] = $this->m_display->get_data('custom', '');
		$data = $this->load->view('content/monitoring/custom', $arrdata, true);
		echo $data;
		/*if($this->input->post("ajax")||$act=="post"){
				echo $arrdata;
			}else{
				$this->content = $data;
				$this->index();
			}*/
	}

	public function statusreefer($act, $id)
	{
		if (!$this->session->userdata('LOGGED')) {
			$this->index();
			return;
		}
		$this->load->model("m_display");
		$arrdata['list'] = $this->m_display->list_statusreefer();
		$data = $this->load->view('content/monitoring/status_reefer', $arrdata, true);
		echo $data;
		/*if($this->input->post("ajax")||$act=="post"){
				echo $arrdata;
			}else{
				$this->content = $data;
				$this->index();
			}*/
	}

	public function set_pemeriksaan($iddd)
	{

		$NO_CONT = $iddd;

		$SQL_SPK_CONT    = $this->db->query("SELECT A.*, B.* FROM t_spk_cont A INNER JOIN t_spk B ON A.ID = B.ID WHERE A.NO_CONT ='" . $NO_CONT . "' AND A.STATUS_CONT = '460' ORDER BY A.ID DESC")->row_array();

		$SQL_PEMERIKSAAN = $this->db->query("SELECT * FROM t_op_inspection WHERE NO_CONT = '" . $NO_CONT . "' AND NO_SPK='" . $SQL_SPK_CONT['NO_SPK'] . "' ORDER BY ID DESC LIMIT 1")->row_array();

		$SQL_KODE_DOK	 = $this->db->query("SELECT * FROM reff_kode_dok_bc WHERE ID='" . $SQL_SPK_CONT['JNS_DOK'] . "'")->row_array();

		$SQL_GATEPASS 	 = $this->db->query("SELECT * FROM t_gatepass WHERE NO_CONT ='" . $NO_CONT . "' AND JNS_DOK = '" . $SQL_KODE_DOK['NAMA'] . "' AND NO_DOK = '" . $SQL_SPK_CONT['NO_DOK'] . "' AND TGL_DOK ='" . $SQL_SPK_CONT['TGL_DOK'] . "' AND JNS_KEGIATAN IN('1','2') ORDER BY ID DESC LIMIT 1")->row_array();

		$SQL_JOBSLIP = $this->db->query("SELECT * FROM t_job_slip WHERE NO_CONT = '" . $NO_CONT . "' AND NO_SPK = '" . $SQL_SPK_CONT['NO_SPK'] . "' ORDER BY ID_JOB_SLIP DESC LIMIT 1")->row_array();

		if ($SQL_SPK_CONT['NO_CONT'] == $NO_CONT) {
			if ($SQL_SPK_CONT['STATUS_CONT'] == '460') {
				if ($SQL_PEMERIKSAAN == NULL) {
					/* START INSPECTION */
					$startinsp = array(
						'NO_CONT' 		 => $NO_CONT,
						'OPERATOR_START' => $this->session->userdata('USERLOGIN'),
						'LOKASI' 		 => $SQL_SPK_CONT['LOKASI'] . '0' . $SQL_SPK_CONT['TIER'],
						'JNS_KEGIATAN' 	 => $SQL_GATEPASS['JNS_KEGIATAN'],
						'NO_DOK' 		 => $SQL_SPK_CONT['NO_DOK'],
						'JNS_DOK' 		 => $SQL_KODE_DOK['NAMA'],
						'TGL_DOK' 		 => $SQL_SPK_CONT['TGL_DOK'],
						'NO_SPK' 		 => $SQL_SPK_CONT['NO_SPK'],
						'START_INSP' 	 => date('Y-m-d H:i:s')
					);
					$this->db->insert('t_op_inspection', $startinsp);

					/* UPDATE TABEL OPERATION */
					$this->db->where(array('NO_CONT' => $NO_CONT, 'NO_SPK' =>  $SQL_SPK_CONT['NO_SPK']));
					$this->db->update('t_operation', array('WK_START' => date('Y-m-d H:i:s')));

					//echo "MSG#OK#Berhasil Menjadikan Siap Periksa#".base_url()."application.php/display/pergerakan";
					//redirect('display/pergerakan');
				} else {
					/* FINISH INSPECTION */
					echo 'MSG#ERR#Sudah dalam Posisi Siap Periksa';
				}
			} else {
				echo 'MSG#ERR#Belum Di CIC';
			}
		} else {
			echo 'MSG#ERR#Tidak dalam posisi siap periksa';
		}

		//echo $message;
		//redirect('display/pergerakan');
	}

	function karantina()
	{
		if (!$this->session->userdata('LOGGED')) {
			$this->index();
			return;
		}
		$this->load->model("m_display");
		$arrdata['datalongroom'] = $this->m_display->get_data('karantina', '');
		$data = $this->load->view('content/monitoring/karantina', $arrdata, true);
		echo $data;
	}

	function percepatan_penarikan()
	{
		if (!$this->session->userdata('LOGGED')) {
			$this->index();
			return;
		}
		$this->load->model("m_display");
		$arrdata['datalongroom'] = $this->m_display->get_data('percepatan_penarikan', '');
		$data = $this->load->view('content/monitoring/percepatan_penarikan', $arrdata, true);
		echo $data;
	}

	function penarikan()
	{
		if (!$this->session->userdata('LOGGED')) {
			$this->index();
			return;
		}
		$this->load->model("m_display");
		$arrdata['dataPenarikan'] = $this->m_display->get_data('penarikan', '');
		$data = $this->load->view('content/monitoring/display_penarikan', $arrdata, true);
		echo $data;
	}

	/* public function respon_custom($act,$id){
			if (!$this->session->userdata('LOGGED')){
				$this->index();
				return;
			}
			$id = ($id!="")?$id:$this->input->post('id');
			if($act=="pkblr"){
				$this->load->model("m_execute");
				$data['arrdata'] = $this->m_execute->cek_data('active_pkblr', $id);
			}else if($act=="pkbyard"){
				$this->load->model("m_execute");
				$data['arrdata'] = $this->m_execute->cek_data('active_pkbyard', $id);
			}else if($act=="pkbyardn"){
				$this->load->model("m_execute");
				$data['arrdata'] = $this->m_execute->cek_data('active_pkbyardn', $id);
			}else if($act=="pkbprioritas"){
				$this->load->model("m_execute");
				$data['arrdata'] = $this->m_execute->cek_data('active_pkbprioritas', $id);
			}else if($act=="update"){
				$data['title'] = 'UPDATE RESPON CUSTOMS';
				$data['id'] = $id;
				$data['action'] = 'update';
				$this->load->model("m_execute");
				$data['arrdata'] = $this->m_execute->get_data('customs', $id);

				echo $this->load->view('content/monitoring/respon_custom',$data,true);
			}else{
				$this->load->model("m_display");
				$arrdata = $this->m_display->getresponcustoms($act, $id);
				$data = $this->load->view('content/newtable', $arrdata, true);
				if($this->input->post("ajax")||$act=="post"){
					echo $arrdata;
				}else{
					$this->content = $data;
					$this->index();
				}
				
			}
		} */
	public function respon_custom($type, $act, $id)
	{
		if (!$this->session->userdata('LOGGED')) {
			$this->index();
			return;
		}
		$id = ($id != "") ? $id : $this->input->post('id');
		if ($type == "respon") {
			$iddata = $this->input->post('DATA[ID]');
			$this->load->model("m_display");
			$this->m_display->set_pkb($iddata);
		} elseif ($type == "detail") {
			$this->load->model("m_display");
			$data['title'] = 'RESPON PPK';
			$data['id'] = $id;
			$data['arrdata'] = $this->m_display->detail_respon($id);
			$data['arrdata_detail'] = $this->m_display->detail_respon($id);
			echo $this->content = $this->load->view('content/dokumen/detail_respon_custom', $data, true);
		} elseif ($type == "getrespon") {
			$this->load->model("m_display");
			$data['user'] = $this->session->userdata('KD_GROUP');
			$data['title'] = "REQUEST PPK";
			$data['id'] = $id;
			$data['arrdata'] = $this->m_display->detail_respon($id);
			echo $this->content = $this->load->view('content/dokumen/form_respon_custom', $data, true);
		} elseif ($type == "getrespon_history") {
			$this->load->model("m_display");
			$data['user'] = $this->session->userdata('KD_GROUP');
			$data['title'] = "REQUEST PPK";
			$data['id'] = $id;
			$data['arrdata'] = $this->m_display->detail_respon_history($id);
			echo $this->content = $this->load->view('content/dokumen/form_respon_custom_history', $data, true);
		} else {
			$this->load->model("m_display");
			$arrdata = $this->m_display->getresponcustoms($type, $act, $id);
			$data = $this->load->view('content/newtable', $arrdata, true);
			if ($this->input->post("ajax") || $act == "post") {
				echo $arrdata;
			} else {
				$this->content = $data;
				$this->index();
			}
		}
	}
	public function ppkjoininspection($type, $act, $id)
	{
		if (!$this->session->userdata('LOGGED')) {
			$this->index();
			return;
		}
		$id = ($id != "") ? $id : $this->input->post('id');
		$id = explode('~', $id);
		$id2 = $id;
		$id = $id[0];

		if ($type == "respon") {
			//echo json_encode($_POST);die();
			$iddata = $this->input->post('DATA[ID]');
			$this->load->model("m_display");
			$this->m_display->set_pkbjoin($iddata, $this->input->post('id'));
		} elseif ($type == "detail") {
			$this->load->model("m_display");
			$data['title'] = 'RESPON IPK JOIN INSPECTION';
			$data['id'] = $id;
			$data['arrdata'] = $this->m_display->detail_responjoin($id);
			//$data['arrdata_detail'] = $this->m_display->detail_respon($id);
			echo $this->content = $this->load->view('content/dokumen/detail_respon_customjoin', $data, true);
		} elseif ($type == "respon2") {
			$iddata = $this->input->post('DATA[ID]');
			$this->load->model("m_display");
			$this->m_display->set_pkbjoin2($iddata, $this->input->post('id'));
		} elseif ($type == "getrespon") {
			$this->load->model("m_display");
			$data['user'] = $this->session->userdata('KD_GROUP');
			$data['title'] = "REQUEST IPK";
			$data['id'] = $id;
			$data['dok'] = $id2;
			$data['arrdata'] = $this->m_display->detail_responjoin($id);
			echo $this->content = $this->load->view('content/dokumen/form_respon_customjoin', $data, true);
		} elseif ($type == "setpemeriksa") {
			$this->load->model("m_display");
			$data['user'] = $this->session->userdata('KD_GROUP');
			$data['title'] = "REQUEST IPK";
			$data['id'] = $id;
			$data['dok'] = $id2;
			$data['arrdata'] = $this->m_display->detail_responjoin($id);
			echo $this->content = $this->load->view('content/dokumen/form_respon_customjoin2', $data, true);
		} elseif ($type == "getrespon_history") {
			// $this->load->model("m_display");
			// $data['user'] = $this->session->userdata('KD_GROUP');
			// $data['title'] = "REQUEST PPK";
			// $data['id'] = $id;
			// $data['arrdata'] = $this->m_display->detail_respon_history($id);
			// echo $this->content = $this->load->view('content/dokumen/form_respon_custom_history',$data,true);
		} else {
			$this->load->model("m_display");
			$arrdata = $this->m_display->getresponcustomsjoin($type, $act, $id);
			$data = $this->load->view('content/newtable', $arrdata, true);
			if ($this->input->post("ajax") || $act == "post") {
				echo $arrdata;
			} else {
				$this->content = $data;
				$this->index();
			}
		}
	}

	public function respon_custom_list($type, $act, $id)
	{
		if (!$this->session->userdata('LOGGED')) {
			$this->index();
			return;
		}
		$id = ($id != "") ? $id : $this->input->post('id');
		if ($type == "respon") {
			$iddata = $this->input->post('DATA[ID]');
			$this->load->model("m_display");
			$this->m_display->set_pkb($iddata);
		} elseif ($type == "detail") {
			$this->load->model("m_display");
			$data['title'] = 'RESPON PPK';
			$data['id'] = $id;
			$data['arrdata'] = $this->m_display->detail_respon_white($id);
			echo $this->content = $this->load->view('content/dokumen/detail_respon_custom', $data, true);
		} elseif ($type == "getrespon") {
			$this->load->model("m_display");
			$data['user'] = $this->session->userdata('KD_GROUP');
			$data['title'] = "REQUEST PPK";
			$data['id'] = $id;
			$data['arrdata'] = $this->m_display->detail_respon_white($id);
			echo $this->content = $this->load->view('content/dokumen/form_respon_custom', $data, true);
		} else {
			$this->load->model("m_display");
			$arrdata = $this->m_display->getresponcustoms_white($type, $act, $id);
			$data = $this->load->view('content/newtable', $arrdata, true);
			if ($this->input->post("ajax") || $act == "post") {
				echo $arrdata;
			} else {
				$this->content = $data;
				$this->index();
			}
		}
	}

	public function respon_karantina($type, $act, $id)
	{
		if (!$this->session->userdata('LOGGED')) {
			$this->index();
			return;
		}
		$id = ($id != "") ? $id : $this->input->post('id');
		if ($type == "respon") {
			$this->load->model("m_display");
			$this->m_display->set_pkb_karantina($type, $act, $id);
		} elseif ($type == "detail") {
			$this->load->model("m_display");
			$data['id'] = $id;
			$data['arrdata'] = $this->m_display->detail_respon($id);
			echo $this->content = $this->load->view('content/dokumen/detail_respon_custom', $data, true);
		} else {
			$this->load->model("m_display");
			$arrdata = $this->m_display->getresponkarantina($type, $act, $id);
			$data = $this->load->view('content/newtable', $arrdata, true);
			if ($this->input->post("ajax") || $act == "post") {
				echo $arrdata;
			} else {
				$this->content = $data;
				$this->index();
			}
		}
	}
	public function resetantrian()
	{
		$q = $this->db->query("UPDATE t_antrian_respon_ppk SET RESET = 'Y',tgl_reset = now() WHERE RESET = 'N'");
		if ($q) {
			redirect("/display/respon_custom");
		}
	}
	public function resetantrianjoin()
	{
		// $q = $this->db->query("UPDATE t_antrian_respon_ppk SET RESET = 'Y',tgl_reset = now() WHERE RESET = 'N'");
		// if ($q) {
		// 	redirect("/display/respon_custom");
		// }
	}
	public function pergerakan($act, $id)
	{
		if (!$this->session->userdata('LOGGED')) {
			$this->index();
			return;
		}
		$id = ($id != "") ? $id : $this->input->post('id');

		if ($act == "detail") {
			$this->load->model("m_display");
			$data['id'] = $id;
			$data['arrdata'] = $this->m_display->detail_pergerakan($act, $id);
			echo $this->content = $this->load->view('content/monitoring/detail_pergerakan', $data, true);
		} else if ($act == "setpemeriksaan") {
			//$this->load->model("m_display");
			$idd = $this->input->post('id');
			$idd = explode('~', $idd);
			$this->set_pemeriksaan($idd[2]);
		} else {
			$this->load->model("m_display");
			$arrdata = $this->m_display->pergerakan($type, $act, $id);
			$data = $this->load->view('content/newtable', $arrdata, true);
			if ($this->input->post("ajax") || $act == "post") {
				echo $arrdata;
			} else {
				$this->content = $data;
				$this->index();
			}
		}
	}

	function monitoring_jinspection()
	{
		if (!$this->session->userdata('LOGGED')) {
			$this->index();
			return;
		}
		$this->load->model("m_display");
		$arrdata['jinspection'] = $this->m_display->get_data('monitoring_jinspection', '');
		$data = $this->load->view('content/monitoring/monitoring_jinspection', $arrdata, true);
		echo $data;
	}

	public function pergerakan_jinspection($act, $id)
	{
		if (!$this->session->userdata('LOGGED')) {
			$this->index();
			return;
		}
		$id = ($id != "") ? $id : $this->input->post('id');

		if ($act == "detail") {
			$this->load->model("m_display");
			$data['id'] = $id;
			$data['arrdata'] = $this->m_display->detail_pergerakan_jinspection($act, $id);
			echo $this->content = $this->load->view('content/monitoring/detail_pergerakan_jinspection', $data, true);
		} else if ($act == "set_pemeriksa") {
			$this->load->model("m_display");
			$data['id'] = $id;
			$data['action'] = 'set_pemeriksa_simpan';
			$simpan = explode('~', $id);
			$data['no_cont'] = $simpan[2];
			$data['no_respon'] = $simpan[1];
			// print_r($simpan[3]);die();
			$data['hasil'] = $this->db->query("SELECT * FROM t_detail_pemeriksa_join a JOIN t_pemeriksa_ppk b ON (CASE WHEN ISNULL(a.id_pemeriksa_bc) THEN a.id_pemeriksa = b.id ELSE a.id_pemeriksa_bc = b.id END) WHERE a.no_dok = '" . $simpan[1] . "' AND a.no_cont = '" . $simpan[2] . "'")->row_array();
			// var_dump($data['hasil']);die();
			echo $this->content = $this->load->view('content/monitoring/set_pemeriksa', $data, true);
		} else if ($act == "set_pemeriksa_gagal") {
			echo 'MSG#ERR#Karantina belum melakukan set pemeriksa';
			die();
		} else if ($act == "set_pemeriksa_simpan") {
			$simpan = explode('~', $id);
			// var_dump($simpan[3]);die();
			if ($simpan[3] == "" || $simpan[3] == NULL) {
				echo 'MSG#ERR#Karantina belum melakukan set pemeriksa';
				die();
			} else {
				$this->load->model("m_display");
				$data['arrdata'] = $this->m_display->set_pemeriksa_simpan($act, $id);
			}
		} else {
			$this->load->model("m_display");
			$arrdata = $this->m_display->pergerakan_jinspection($type, $act, $id);
			$data = $this->load->view('content/newtable', $arrdata, true);
			if ($this->input->post("ajax") || $act == "post") {
				echo $arrdata;
			} else {
				$this->content = $data;
				$this->index();
			}
		}
	}

	public function monitoring_pemeriksa($act, $id)
	{
		if (!$this->session->userdata('LOGGED')) {
			$this->index();
			return;
		}
		$id = ($id != "") ? $id : $this->input->post('id');

		$this->load->model("m_display");
		$arrdata = $this->m_display->monitoring_pemeriksa($type, $act, $id);
		$data = $this->load->view('content/newtable', $arrdata, true);
		if ($this->input->post("ajax") || $act == "post") {
			echo $arrdata;
		} else {
			$this->content = $data;
			$this->index();
		}
	}

	function process($type = "", $act = "", $id = "")
	{ //print_r($type.$act);die();
		if (!$this->session->userdata('LOGGED')) {
			$this->index();
			return;
		} else {
			if (strtolower($_SERVER['REQUEST_METHOD']) != "post") {
				$this->load->model("m_display");
				$this->m_display->process($type, $act, $id);
			} else {
				$this->load->model("m_display");
				$this->m_display->process($type, $act, $id);
			}
		}
	}

	public function pergerakanPlanner($act, $id)
	{
		if (!$this->session->userdata('LOGGED')) {
			$this->index();
			return;
		}
		$id = ($id != "") ? $id : $this->input->post('id');

		if ($act == "detail") {
			$this->load->model("m_display");
			$data['id'] = $id;
			$data['arrdata'] = $this->m_display->detail_pergerakan_planner($act, $id);
			echo $this->content = $this->load->view('content/monitoring/detail_pergerakan', $data, true);
		} else {
			$this->load->model("m_display");
			$arrdata = $this->m_display->pergerakanplanner($type, $act, $id);
			$data = $this->load->view('content/newtable', $arrdata, true);
			if ($this->input->post("ajax") || $act == "post") {
				echo $arrdata;
			} else {
				$this->content = $data;
				$this->index();
			}
		}
	}

	public function respon_quarantine($act, $id)
	{
		if (!$this->session->userdata('LOGGED')) {
			$this->index();
			return;
		}
		$id = ($id != "") ? $id : $this->input->post('id');
		$this->load->model("m_display");
		$arrdata = $this->m_display->getresponquarantine($act, $id);
		$data = $this->load->view('content/newtable', $arrdata, true);
		if ($this->input->post("ajax") || $act == "post") {
			echo $arrdata;
		} else {
			$this->content = $data;
			$this->index();
		}
	}

	function execute($type = "", $act = "", $id = "", $met = "")
	{
		if (!$this->session->userdata('LOGGED')) {
			$this->index();
			return;
		} else {
			if (strtolower($_SERVER['REQUEST_METHOD']) != "post") {
				redirect(base_url());
				exit();
			} else {
				$this->load->model("m_display");
				$this->m_display->execute($type, $act, $id, $met);
			}
		}
	}

	public function monitorSuhu($act, $id)
	{
		if (!$this->session->userdata('LOGGED')) {
			$this->index();
			return;
		}
		$this->load->model("m_display");
		$arrdata['datareefer'] = $this->m_display->get_data('reefer', '');
		//$arrdata['suhureefer'] = $this->m_display->get_data('suhu','');
		$data = $this->load->view('content/monitoring/reefer', $arrdata, true);
		echo $data;
	}


	public function monitorOrderOnlineee($act, $id)
	{
		if (!$this->session->userdata('LOGGED')) {
			$this->index();
			return;
		}
		$this->load->model("m_display");
		$arrdata['datareefer'] = $this->m_display->get_data('reefer', '');
		//$arrdata['suhureefer'] = $this->m_display->get_data('suhu','');
		$data = $this->load->view('content/monitoring/orderOnline', $arrdata, true);
		echo $data;
	}



	// public function monitorOrderOnline($type, $act, $id) {
	// 	if (!$this->session->userdata('LOGGED')){
	// 		$this->index();
	// 		return;
	// 	}

	// 	// $url ="http://8a534e82a8b0.ngrok.io/api/cekdok";
	// 	// $ch = curl_init();

	// 	// $header=array(
	// 	//   'User-Agent: Mozilla/5.0 (Windows NT 5.2; WOW64; rv:43.0) Gecko/20100101 Firefox/43.0',
	// 	//   'Accept: text/html,application/xhtml+xml,application/json;q=0.9,*/*;q=0.8',
	// 	//   'Accept-Language: en-us,en;q=0.5',
	// 	//   'Accept-Encoding: gzip,deflate',
	// 	//   'Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7',
	// 	//   'Keep-Alive: 115',
	// 	//   'Connection: keep-alive',
	// 	// );
	// 	// curl_setopt($ch, CURLOPT_URL, $url);
	// 	// curl_setopt($ch, CURLOPT_REFERER, $url); 
	// 	// curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 5.2; WOW64; rv:43.0) Gecko/20100101 Firefox/43.0");
	// 	// curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	// 	// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); //Set curl to return the data instead of printing it to the browser.
	// 	// curl_setopt($ch, CURLOPT_COOKIEJAR, 'curl_cookies.txt');
	// 	// curl_setopt($ch, CURLOPT_COOKIEFILE, 'curl_cookies.txt');
	// 	// curl_setopt($ch, CURLOPT_ENCODING, 'gzip,deflate');
	// 	// curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

	// 	// $data = curl_exec($ch);

	// 	// if (!curl_errno($ch)) {
	// 	// 	switch ($http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE)) {
	// 	// 	  case 200:  # OK
	// 	// 		break;
	// 	// 	  default:
	// 	// 		echo 'Unexpected HTTP code: ', $http_code, "\n";
	// 	// 	}
	// 	//   }

	// 	// curl_close($ch);

	// 	// $status = curl_getinfo($ch);

	// 	// if ($status['http_code'] == 200) {
	// 	// 	return $data;    
	// 	// } else {
	// 	// 	echo "gagal";
	// 	// }

	// 	// $ch = curl_init(); // create cURL handle (ch)
	// 	// if (!$ch) {
	// 	// 	die("Couldn't initialize a cURL handle");
	// 	// }
	// 	// // set some cURL options
	// 	// $ret = curl_setopt($ch, CURLOPT_URL,            "http://8a534e82a8b0.ngrok.io/api/cekdok");
	// 	// $ret = curl_setopt($ch, CURLOPT_HEADER,         1);
	// 	// $ret = curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	// 	// $ret = curl_setopt($ch, CURLOPT_RETURNTRANSFER, 0);
	// 	// $ret = curl_setopt($ch, CURLOPT_TIMEOUT,        30);

	// 	// // execute
	// 	// $ret = curl_exec($ch);

	// 	// if (empty($ret)) {
	// 	// 	// some kind of an error happened
	// 	// 	die(curl_error($ch));
	// 	// 	curl_close($ch); // close cURL handler
	// 	// } else {
	// 	// 	$info = curl_getinfo($ch);
	// 	// 	curl_close($ch); // close cURL handler

	// 	// 	if (empty($info['http_code'])) {
	// 	// 			die("No HTTP code was returned");
	// 	// 	} else {
	// 	// 		// load the HTTP codes
	// 	// 		$http_codes = parse_ini_file("path/to/the/ini/file/I/pasted/above");

	// 	// 		// echo results
	// 	// 		echo "The server responded: <br />";
	// 	// 		echo $info['http_code'] . " " . $http_codes[$info['http_code']];
	// 	// 	}

	// 	// }

	// }



	public function monitorOrderOnline($act, $id)
	{
		if (!$this->session->userdata('LOGGED')) {
			$this->index();
			return;
		}

		$id = ($id != "") ? $id : $this->input->post('id');

		if ($act == "add_data") {
			$data['id'] = $id;
			//echo $data['id'];die();
			$data['arrdata'] = $this->db->query("SELECT ID, ID_DOKUMEN, NO_DOK, TGL_DOK, TYPE_DOK,  NOTE, FL_STATUS FROM list_dokumens WHERE ID = '" . $id . "'")->row();
			//echo $data['arrdata'];die();
			echo $this->content = $this->load->view('content/dokumen/form_proses', $data);
		} else if ($act == "add_data_tolak") {
			$data['id'] = $id;
			//echo $data['id'];die();
			$data['arrdata'] = $this->db->query("SELECT ID, ID_DOKUMEN, NO_DOK, TGL_DOK, TYPE_DOK,  NOTE, FL_STATUS FROM list_dokumens WHERE ID = '" . $id . "'")->row();
			//echo $data['arrdata'];die();
			echo $this->content = $this->load->view('content/dokumen/form_tolak', $data);
		} else if ($act == "print") {
			$data['id'] = $id;
			//echo $data['id'];die();
			$data['arrdata'] = $this->db->query("SELECT ID, ID_DOKUMEN, NO_DOK, TGL_DOK, TYPE_DOK,  NOTE, FL_STATUS, FILE_DOK FROM list_dokumens WHERE ID = '" . $id . "'")->row();
			$data['test'] = explode("#", $data['arrdata']->FILE_DOK);

			// var_dump($data);die();
			// $arrid = explode("~",$id);
			// $id = $arrid;die();

			echo $this->content = $this->load->view('content/dokumen/list_dokumen', $data);
		} else {
			$this->load->model("m_display");
			$arrdata = $this->m_display->getresponrequestonline($act, $id);
			$data = $this->load->view('content/newtable', $arrdata, true);
			if ($this->input->post("ajax") || $act == "post") {
				echo $arrdata;
			} else {
				$this->content = $data;
				$this->index();
			}
		}
	}


	public function prosesonline()
	{
		$id = $_GET['id'];

		$fl_status = $this->input->post('FL_STATUS');
		$note = $this->input->post('NOTE');
		$id_dokumen = $this->input->post('ID_DOKUMEN');
		//echo "$fl_status";die();

		try {

			$list_dokumen = $this->db->query("UPDATE tpk_ipc.list_dokumens SET  NOTE ='$note', FL_STATUS ='Y' WHERE ID=$id");

			if ($list_dokumen != 0) {
				$url = "http://10.1.6.177/api/prosesdokumen";
				$postData = array('id' => $id_dokumen, 'fl_status' => 'Y', 'note' => $note);

				$data = http_build_query($postData);

				$curl = curl_init();
				curl_setopt_array($curl, array(
					CURLOPT_URL => $url,
					CURLOPT_RETURNTRANSFER => true,
					CURLOPT_ENCODING => '',
					CURLOPT_MAXREDIRS => 10,
					CURLOPT_TIMEOUT => 0,
					CURLOPT_FOLLOWLOCATION => true,
					CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
					CURLOPT_CUSTOMREQUEST => 'POST',
					CURLOPT_POSTFIELDS => $data,
				));

				$response = curl_exec($curl);

				if (!curl_errno($curl)) {
					$info = curl_getinfo($curl);
					echo "Connection Success , This is Url : ", $info['url'], "\r\n";
				} else {
					echo "Connection Failed =" . curl_error($curl);
				}
				curl_close($curl);
				// var_dump($response);die();
				$json = json_encode($response);
				if (preg_match("/success/i", $json)) {
					echo "MSG#OK#Data berhasil diproses#";
				} else {
					echo $json;
				}
				//var_dump($json);die();
			} else {
				echo "Data Tidak Ada";
			}
		} catch (\Throwable $th) {
			echo "MSG#ERR#Data tidak bisa di Prosess#";
		}
	}


	public function prosesonlinetolak()
	{
		$id = $_GET['id'];

		$fl_status = $this->input->post('FL_STATUS');
		$note = $this->input->post('NOTE');
		$id_dokumen = $this->input->post('ID_DOKUMEN');
		//echo "$fl_status";die();

		try {

			$list_dokumen = $this->db->query("UPDATE tpk_ipc.list_dokumens SET  NOTE ='$note', FL_STATUS ='Y' WHERE ID=$id");

			if ($list_dokumen != 0) {
				$url = "http://10.1.6.177/api/prosesdokumen";
				$postData = array('id' => $id_dokumen, 'fl_status' => 'X', 'note' => $note);

				$data = http_build_query($postData);

				$curl = curl_init();
				curl_setopt_array($curl, array(
					CURLOPT_URL => $url,
					CURLOPT_RETURNTRANSFER => true,
					CURLOPT_ENCODING => '',
					CURLOPT_MAXREDIRS => 10,
					CURLOPT_TIMEOUT => 0,
					CURLOPT_FOLLOWLOCATION => true,
					CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
					CURLOPT_CUSTOMREQUEST => 'POST',
					CURLOPT_POSTFIELDS => $data,
				));

				$response = curl_exec($curl);

				if (!curl_errno($curl)) {
					$info = curl_getinfo($curl);
					echo "Connection Success , This is Url : ", $info['url'], "\r\n";
				} else {
					echo "Connection Failed =" . curl_error($curl);
				}
				curl_close($curl);
				// var_dump($response);die();
				$json = json_encode($response);
				if (preg_match("/success/i", $json)) {
					echo "MSG#OK#Data berhasil diproses#";
				} else {
					echo $json;
				}
				//var_dump($json);die();
			} else {
				echo "Data Tidak Ada";
			}
		} catch (\Throwable $th) {
			echo "MSG#ERR#Data tidak bisa di Prosess#";
		}
	}




	public function monitorOrderOnlinee($act, $id)
	{
		if (!$this->session->userdata('LOGGED')) {
			$this->index();
			return;
		}

		$id = ($id != "") ? $id : $this->input->post('id');

		if ($act == "add_data") {
			$data['id'] = $id;
			//echo $data['id'];die();
			$data['arrdata'] = $this->db->query("SELECT ID, ID_BEHANDLE2, NO_DOK, TGL_DOK, TIPE, NOTE, FL_STATUS FROM behandle2s WHERE ID = '" . $id . "'")->row();
			//echo $data['arrdata'];die();
			echo $this->content = $this->load->view('content/dokumen/form_proses2', $data);
		} else if ($act == "add_data_tolak") {
			$data['id'] = $id;
			//echo $data['id'];die();
			$data['arrdata'] = $this->db->query("SELECT ID, ID_BEHANDLE2, NO_DOK, TGL_DOK, TIPE, NOTE, FL_STATUS FROM behandle2s WHERE ID = '" . $id . "'")->row();
			//echo $data['arrdata'];die();
			echo $this->content = $this->load->view('content/dokumen/form_tolak2', $data);
		} else if ($act == "print") {
			$data['id'] = $id;
			//echo $data['id'];die();
			$data['arrdata'] = $this->db->query("SELECT ID, ID_BEHANDLE2, NO_DOK, TGL_DOK, TIPE,  NOTE, FL_STATUS, FILE_DOK FROM behandle2s WHERE ID = '" . $id . "'")->row();
			$data['test'] = explode("#", $data['arrdata']->FILE_DOK);

			//var_dump($data);die();
			// $arrid = explode("~",$id);
			// $id = $arrid;die();

			echo $this->content = $this->load->view('content/dokumen/list_behandle2', $data);
		} else {
			$this->load->model("m_display");
			$arrdata = $this->m_display->getresponrequestonlinee($act, $id);
			$data = $this->load->view('content/newtable', $arrdata, true);
			if ($this->input->post("ajax") || $act == "post") {
				echo $arrdata;
			} else {
				$this->content = $data;
				$this->index();
			}
		}
	}


	public function prosesonlinee()
	{
		$id = $_GET['id'];
		$fl_status = $this->input->post('FL_STATUS');
		$note = $this->input->post('NOTE');
		$id_behandle = $this->input->post('ID_BEHANDLE2');
		//echo "$id_behandle";die();

		try {

			$list_dokumen = $this->db->query("UPDATE tpk_ipc.behandle2s SET NOTE='$note', FL_STATUS ='Y' WHERE ID=$id");

			if ($list_dokumen != 0) {

				$url = "http://10.1.6.177/api/prosesbehandle2";

				$postData = array('id' => $id_behandle, 'fl_status' => 'Y', 'note' => $note);

				$data = http_build_query($postData);

				$curl = curl_init();
				curl_setopt_array($curl, array(
					CURLOPT_URL => $url,
					CURLOPT_RETURNTRANSFER => true,
					CURLOPT_ENCODING => '',
					CURLOPT_MAXREDIRS => 10,
					CURLOPT_TIMEOUT => 0,
					CURLOPT_FOLLOWLOCATION => true,
					CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
					CURLOPT_CUSTOMREQUEST => 'POST',
					CURLOPT_POSTFIELDS => $data,
				));

				$response = curl_exec($curl);

				if (!curl_errno($curl)) {
					$info = curl_getinfo($curl);
					echo "Connection Success , This is Url : ", $info['url'], "\r\n";
				} else {
					echo "Connection Failed =" . curl_error($curl);
				}
				curl_close($curl);
				// var_dump($response);die();
				$json = json_encode($response);
				if (preg_match("/success/i", $json)) {
					echo "MSG#OK#Data berhasil diproses#";
				} else {
					echo $json;
				}
				//var_dump($json);die();
			} else {
				echo "Data Tidak Ada";
			}
		} catch (\Throwable $th) {
			echo "MSG#ERR#Data tidak bisa di Prosess#";
		}
	}

	public function prosesonlineetolak()
	{
		$id = $_GET['id'];
		$fl_status = $this->input->post('FL_STATUS');
		$note = $this->input->post('NOTE');
		$id_behandle = $this->input->post('ID_BEHANDLE2');
		//echo "$id_behandle";die();

		try {

			$list_dokumen = $this->db->query("UPDATE tpk_ipc.behandle2s SET NOTE='$note', FL_STATUS ='X' WHERE ID=$id");

			if ($list_dokumen != 0) {

				$url = "http://10.1.6.177/api/prosesbehandle2";

				$postData = array('id' => $id_behandle, 'fl_status' => 'Y', 'note' => $note);

				$data = http_build_query($postData);

				$curl = curl_init();
				curl_setopt_array($curl, array(
					CURLOPT_URL => $url,
					CURLOPT_RETURNTRANSFER => true,
					CURLOPT_ENCODING => '',
					CURLOPT_MAXREDIRS => 10,
					CURLOPT_TIMEOUT => 0,
					CURLOPT_FOLLOWLOCATION => true,
					CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
					CURLOPT_CUSTOMREQUEST => 'POST',
					CURLOPT_POSTFIELDS => $data,
				));

				$response = curl_exec($curl);

				if (!curl_errno($curl)) {
					$info = curl_getinfo($curl);
					echo "Connection Success , This is Url : ", $info['url'], "\r\n";
				} else {
					echo "Connection Failed =" . curl_error($curl);
				}
				curl_close($curl);
				// var_dump($response);die();
				$json = json_encode($response);
				if (preg_match("/success/i", $json)) {
					echo "MSG#OK#Data berhasil diproses#";
				} else {
					echo $json;
				}
				//var_dump($json);die();
			} else {
				echo "Data Tidak Ada";
			}
		} catch (\Throwable $th) {
			echo "MSG#ERR#Data tidak bisa di Prosess#";
		}
	}

	// public function monitorOrderOnlinee($type, $act, $id) {
	// 	if (!$this->session->userdata('LOGGED')){
	// 		$this->index();
	// 		return;
	// 	}

	// 	$id = ($id!="")?$id:$this->input->post('id');
	// 	if ($type=="prosesonlinee") {
	// 		$type = 'update';
	// 		$act = 'prosesonlinee';
	// 		$this->load->model("m_display");
	// 		$data['arrdata'] = $this->m_display->prosesonlinee($type, $act, $id);
	// 	} else {
	// 	$this->load->model("m_display");
	// 		$arrdata = $this->m_display->getresponrequestonlinee($act, $id);
	// 		$data = $this->load->view('content/newtable', $arrdata, true);
	// 		if($this->input->post("ajax")||$act=="post"){
	// 			echo $arrdata;
	// 		}else{
	// 			$this->content = $data;
	// 			$this->index();
	// 		}
	// 	}	
	// }

	// public function statusreefer($act, $id){
	// 	if (!$this->session->userdata('LOGGED')){
	// 		$this->index();
	// 		return;
	// 	}
	// 	$this->load->model("m_display");
	// 	$arrdata['list'] = $this->m_display->list_statusreefer();
	// 	$data = $this->load->view('content/monitoring/status_reefer', $arrdata, true);
	// 	echo $data;
	// 	/*if($this->input->post("ajax")||$act=="post"){
	// 		echo $arrdata;
	// 	}else{
	// 		$this->content = $data;
	// 		$this->index();
	// 	}*/

	// }

	public function rekonsppmp()
	{
		$data['rekon'] = $this->db->query("SELECT * FROM data_rekon_sppmp")->result();
		$this->load->view("content/monitoring/v_rekon_sppmp", $data);
	}

	public function hasilrekon()
	{
		$this->load->view("content/monitoring/v_t_request");
	}
	public function saverekonkon()
	{
		$con = $this->input->post("nokon");
		$con = $string = preg_replace('/\s+/', '', $con);
		$con = strtoupper($con);
		$datac = explode(',', $con);
		$user = "-";
		foreach ($datac as $key => $value) {
			if ($value != ',' or $value != '') {
				$this->db->query("INSERT INTO data_rekon_sppmp (no_cont,user_input,status) VALUES ('$value', '$user', 'n')");
			}
		}

		redirect("/display/rekonsppmp");
	}

	public function daftar_pemeriksa($act, $id)
	{
		if (!$this->session->userdata('LOGGED')) {
			$this->index();
			return;
		}
		$id = ($id != "") ? $id : $this->input->post('id');

		if ($act == "detail") {
			$this->load->model("m_display");
			$data['id'] = $id;
			$data['arrdata'] = $this->m_display->detail_pergerakan_planner($act, $id);
			echo $this->content = $this->load->view('content/monitoring/detail_pergerakan', $data, true);
		} else {
			$this->load->model("m_display");
			$arrdata = $this->m_display->daftar_pemeriksa($act, $id);
			$data = $this->load->view('content/newtable', $arrdata, true);
			if ($this->input->post("ajax") || $act == "post") {
				echo $arrdata;
			} else {
				$this->content = $data;
				$this->index();
			}
		}
	}
}
/* End of file Display.php */
/* Location: ./application/controllers/Display.php */
