<?php

/**
 * 
 */
class AutoGatePass extends CI_Controller
{

	public $content;

	public function __construct()
	{
		parent::__construct();
		$this->load->model("m_requestGatePass");
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
		$footers .= '<script src="' . base_url() . 'assets/js/main.js"></script>';
		$footers .= '<script src="' . base_url() . 'assets/vendor/sweetalert/sweetalert.min.js"></script>';
		$footers .= '<script src="' . base_url() . 'assets/vendor/filament-tablesaw/tablesaw.js"></script>';
		$footers .= '<script src="' . base_url() . 'assets/vendor/toastr/toastr.min.js"></script>';
		$footers .= '<script src="' . base_url() . 'assets/js/components/input-group-file.min.js"></script>';
		$footers .= '<script src="' . base_url() . 'assets/js/components/formatter-js.min.js"></script>';

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
				'_content_' 	  => $this->content, //(grant()=="")?$this->load->view('content/error','',true):$this->content,
				'_footers_' 	  => $footers,
				'_footer_' 	  => $this->load->view('content/menus', '', true)
			);
			$this->parser->parse('index', $data);
		} else {
			redirect(base_url('index.php'), 'refresh');
		}
	}

	public function cetak()
	{
		$this->load->library('mpdf');
		$this->load->library('ciqrcode');
		$type = 'update';
		$act = 'fl_finish_print';
		$id = base64_decode($this->input->get('id'));
		$nocont = base64_decode($this->input->get('nocont'));
		//echo $id." - ".$nocont;
		$idpost = $id . '~' . $nocont;
		$arrdata = $this->m_requestGatePass->execute($type, $act, $idpost);

		$SQL = "SELECT A.*, B.*
					FROM t_request A 
					INNER JOIN t_request_cont B ON A.ID = B.ID
					WHERE A.ID ='$id' AND B.NO_CONT='$nocont'";
		//echo $SQL;die();
		$data['result'] = $this->db->query($SQL)->result_array();

		$params['data'] = $data['result'][0]['TAR'];
		$params['size'] = 3;
		$params['savename'] = 'assets/files/qrcode/code.png';
		$this->ciqrcode->generate($params);
		$this->load->view('content/dokumen/format_gatepass_cic', $data);
	}


	public function gatepassNPCT($act, $id)
	{
		if (!$this->session->userdata('LOGGED')) {
			$this->index();
			return;
		}

		$id = ($id != "") ? $id : $this->input->post('id');
		if ($act == "gate_pass_request_detail") {
			$this->newtable->breadcrumb('Request Gate Pass', site_url());
			$this->newtable->breadcrumb('Planning', 'javascript:void(0)');
			$this->newtable->breadcrumb('Gate Pass Request ', site_url('planning/sppmp'));
			$this->newtable->breadcrumb('Gate Pass', 'javascript:void(0)');
			$data['title'] = 'Request Gate Pass';
			$data['id'] = $id;
			$this->load->model("m_autoGatePass");
			$data['arrdata'] = $this->m_autoGatePass->get_data('gate_pass_request_detail', $id);
			echo $this->content = $this->load->view('content/dokumen/auto_gate_pass_detail', $data, true);
		} else if ($act == "add_keterangan") {
			$type = 'update';
			$act = 'fl_finish';
			$arrdata = $this->m_requestGatePass->execute($type, $act, $id);
		} else if ($act == "cetak") {
			$type = 'update';
			$act = 'fl_finish_print';
			$arrdata = $this->m_requestGatePass->execute($type, $act, $id);
		} else if ($act == "add_paidThrough_karantina") {
			$data['id'] = $id;
			$cont = "SELECT * FROM t_request_cont WHERE ID = '" . $id . "'";
			$data['getCont'] = $this->db->query($cont)->result_array();
			$SQLDok = "SELECT NO_DOK,JNS_DOK FROM t_request WHERE ID = '" . $id . "'";
			$DOK = $this->db->query($SQLDok)->result_array();
			if ($DOK[0]['JNS_DOK'] == 83) {
				$SQLLic = "SELECT ID_IJIN FROM t_lic_hdr WHERE NO_IJIN = '" . $DOK[0]['NO_DOK'] . "'";
			} else {
				$SQLLic = "SELECT ID FROM t_permit_hdr WHERE NO_DAFTAR_PABEAN = '" . $DOK[0]['NO_DOK'] . "'";
			}

			$IDDOK = $this->db->query($SQLLic)->result_array();
			if ($DOK[0]['JNS_DOK'] == 83) {
				$data['NO_DOK'] = $IDDOK[0]['ID_IJIN'];
			} else {
				$data['NO_DOK'] = $IDDOK[0]['ID'];
			}
			echo $this->content = $this->load->view('content/dokumen/form_gatepass_karantina', $data);
		} else if ($act == "paidthrought_karantina") {
			$type = 'update';
			$act = 'paidthrought_karantina';
			$iddata = $this->input->post('DATA[ID]');
			$paidthrought = $this->input->post('DATA[paidthrought]');
			$idijin = $this->input->post('DATA[ID_DOK]');
			$arrdid = $iddata . '~' . $paidthrought . '~' . $idijin;
			$arrdata = $this->m_requestGatePass->execute($type, $act, $arrdid);
		} else if ($act == "updateconsigne") {
			$data['id'] = $id;
			$data['permit'] = $this->db->query("SELECT NO_DOK,TGL_DOK from t_request where id = $id")->row();
			echo $this->content = $this->load->view('content/dokumen/form_udapte_cons', $data);
		} else {
			$this->load->model("m_autoGatePass");
			$arrdata = $this->m_autoGatePass->list_reqGatePass($act, $id);
			$data = $this->load->view('content/newtable', $arrdata, true);
			if ($this->input->post("ajax") || $act == "post") {
				echo $arrdata;
			} else {
				$this->content = $data;
				$this->index();
			}
		}
	}

	public function updatecons()
	{
		$id = $_GET['id'];
		$nm = $this->input->post('nm_cust');
		$nama = trim(preg_replace('/\s\s+/', '', str_replace("\n", " ", $nm)));
		$nodok = $this->input->post('no_dok');
		$tgdok = $this->input->post('tgl_dok');
		// echo var_dump($nama);die();
		try {
			$this->db->query("UPDATE tpk_ipc.t_request SET CONSIGNEE='$nama' WHERE ID=$id");
			$this->db->query("UPDATE tpk_ipc.t_permit_hdr SET CONSIGNEE='$nama' where NO_DAFTAR_PABEAN = '$nodok' and TGL_DAFTAR_PABEAN = '$tgdok'");
			echo "MSG#OK#Data berhasil diproses#";
		} catch (\Throwable $th) {
			echo "MSG#ERR#Data tidak bisa di Prosess#";
		}
	}

	public function request($type = "", $act = "", $id = "", $met = "")
	{
		if (!$this->session->userdata('LOGGED')) {
			$this->index();
			return;
		}
		$id = ($id != "") ? $id : $this->input->post('id');
		$this->load->model('m_requestGatePass');
		$this->m_requestGatePass->execute($type, $act, $id);
	}

	function proces($type = "", $act = "", $id = "")
	{
		if (!$this->session->userdata('LOGGED')) {
			$this->index();
			return;
		} else {
			if (strtolower($_SERVER['REQUEST_METHOD']) != "post") {
				$this->load->model("m_requestGatePass");
				$this->m_requestGatePass->process($type, $act, $id);
			} else {
				$this->load->model("m_requestGatePass");
				$this->m_requestGatePass->process($type, $act, $id);
			}
		}
	}

	public function autoGetGatepass()
	{
		$now = date('Y-m-d');
		$data = $this->db->query("
				SELECT A.NO_DOK, A.TGL_DOK, A.NO_CONT, A.PERIKSA, B.KD_REQ, B.JNS_DOK, B.ID as ID_T_REQUEST 
				FROM t_rekon_dokumen_npct1 A
				LEFT JOIN t_request B ON A.NO_DOK = B.NO_DOK AND A.TGL_DOK = B.TGL_DOK
				LEFT JOIN t_request_cont C ON C.ID = B.ID AND A.NO_CONT = C.NO_CONT
				WHERE B.KD_REQ IS NOT NULL 
				AND A.STATUS_NPCT1 = 'STACKING'
				and A.NO_CONT = 'HAMU4006315'
				AND A.TGL_DOK > '2025-08-10'
				ORDER BY A.ID DESC
			")->result_array();
		// and C.KD_STATUS = 'DRAFT'
		// kalo mau go live, tinggal ubah C.KD_STATUS = 'DRAFT' dan hapus kondisi A.NO_CONT = 'HAMU4006315'
		foreach ($data as $row) {
			$id_request = $row['ID_T_REQUEST'];
			$no_dok = $row['NO_DOK'];
			$tgl_dok = $row['TGL_DOK'];
			$no_cont = $row['NO_CONT'];

			// Cek apakah kontainer sudah punya REF_NUMBER
			$existing = $this->db->query("
					SELECT REF_NUMBER FROM t_request_cont 
					WHERE ID = '$id_request' AND NO_CONT = '$no_cont' AND REF_NUMBER IS NOT NULL
				")->row_array();

			if (!$existing) {
				// Ambil ID terakhir dari t_sequence dan generate REF_NUMBER
				$getlast = $this->db->query("SELECT ID FROM t_sequence ORDER BY ID DESC LIMIT 1")->result_array();
				$lastid = isset($getlast[0]['ID']) ? $getlast[0]['ID'] : 0;
				$newid = $lastid + 1;
				$nosec = 'CGO' . str_pad($newid, 7, '0', STR_PAD_LEFT);

				$paidtrough = date('Y-m-d', strtotime("+1 month"));

				// Update t_request_cont
				$this->db->where(array('ID' => $id_request, 'NO_CONT' => $no_cont));
				$this->db->update('t_request_cont', array(
					'REF_NUMBER' => $nosec,
					'REQ_PILIH' => 'Y'
				));

				// Insert ke t_sequence
				$this->db->insert('t_sequence', array('NAMA' => $nosec));

				// Update t_request: KD_REQ dan WK_REQ
				$this->db->where(array('ID' => $id_request));
				$this->db->update('t_request', array(
					'KD_REQ' => 'QUEUED',
					'WK_REQ' => $paidtrough
				));
			}
		}

		echo "Proses autoGetGatepass selesai: " . count($data) . " data diproses.";
	}

	public function autogetTAR()
	{
		$now = date('Y-m-d');
		$data = $this->db->query("SELECT DISTINCT A.ID, CONCAT(C.NAMA,'<BR>',A.NO_DOK,'<BR>',A.TGL_DOK) AS 'DOKUMEN', B.NO_CONT AS 'KONTAINER', A.CONSIGNEE AS 'CUSTOMER', B.REF_NUMBER AS 'REFF NUMBER', B.KD_STATUS AS 'STATUS', B.TGL_STATUS AS 'TGL STATUS'
					FROM t_request A
					INNER JOIN t_request_cont B ON A.ID = B.ID
					INNER JOIN reff_kode_dok_bc C ON A.JNS_DOK = C.ID
					WHERE B.KD_STATUS ='APPROVED' AND B.REF_NUMBER IS NOT NULL
			")->result_array();
		foreach ($data as $row) {
			$id = $row['ID'];
			$type = 'update';
			$act = 'ondimine_gatepass_api';
			$this->load->model("m_requestGatePass");
			$data['arrdata'] = $this->m_requestGatePass->execute($type, $act, $id);
		}
	}
}
