<?php defined('BASEPATH') or exit('No direct script access allowed');

class Report extends CI_Controller
{
	public $content;

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		#Stylesheets
		$headers .= '<link rel="stylesheet" href="' . base_url() . 'assets/css/bootstrap.min.css?v2.1.0">';
		$headers .= '<link rel="stylesheet" href="' . base_url() . 'assets/css/bootstrap-extend.min.css?v2.1.0">';
		$headers .= '<link rel="stylesheet" href="' . base_url() . 'assets/css/site.min.css?v2.1.0">';
		$headers .= '<link rel="stylesheet" href="' . base_url() . 'assets/vendor/jquery-ui/jquery-ui.min.css?v2.1.0">';
		#Plugins For This Page
		$headers .= '<link rel="stylesheet" href="' . base_url() . 'assets/vendor/filament-tablesaw/tablesaw.min.css?v2.1.0">';
		$headers .= '<link rel="stylesheet" href="' . base_url() . 'assets/vendor/uikit/modals.min.css?v2.1.0">';
		$headers .= '<link rel="stylesheet" href="' . base_url() . 'assets/vendor/bootstrap-datetimepicker/bootstrap-datetimepicker.min.css?v2.1.0">';
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
		$footers .= '<script src="' . base_url() . 'assets/js/datetime.js"></script>';
		$footers .= '<script src="' . base_url() . 'assets/vendor/sweetalert/sweetalert.min.js"></script>';
		$footers .= '<script src="' . base_url() . 'assets/vendor/filament-tablesaw/tablesaw.js"></script>';
		$footers .= '<script src="' . base_url() . 'assets/vendor/toastr/toastr.min.js"></script>';
		$footers .= '<script src="' . base_url() . 'assets/js/components/input-group-file.min.js"></script>';
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
				'_footer_' 	  => $this->load->view('content/footer', '', true)
			);
			$this->parser->parse('index', $data);
		} else {
			redirect(base_url('index.php'), 'refresh');
		}
	}

	function process($type = "", $act = "", $id = "")
	{ //print_r($type.$act);die();
		if (!$this->session->userdata('LOGGED')) {
			$this->index();
			return;
		} else {
			if (strtolower($_SERVER['REQUEST_METHOD']) != "post") {
				$this->load->model("m_report");
				$this->m_report->process($type, $act, $id);
			} else {
				$this->load->model("m_report");
				$this->m_report->process($type, $act, $id);
			}
		}
	}

	function process1($type = "", $act = "", $id = "")
	{ //print_r($type.$act);die();
		if (!$this->session->userdata('LOGGED')) {
			$this->index();
			return;
		} else {
			if (strtolower($_SERVER['REQUEST_METHOD']) != "post") {
				$this->load->model("m_monitoring");
				$this->m_monitoring->process($type, $act, $id);
			} else {
				$this->load->model("m_monitoring");
				$this->m_monitoring->process($type, $act, $id);
			}
		}
	}

	public function monthly($act, $id)
	{
		if (!$this->session->userdata('LOGGED')) {
			$this->index();
			return;
		}
		$id = ($id != "") ? $id : $this->input->post('id');
		$this->load->model('m_report');
		$arrdata = $this->m_report->monthly($act, $id);
		$data = $this->load->view('content/newtable', $arrdata, true);
		if ($this->input->post("ajax") || $act == "post") {
			echo $arrdata;
		} else {
			$this->content = $data;
			$this->index();
		}
	}

	public function repository($act, $id)
	{
		if (!$this->session->userdata('LOGGED')) {
			$this->index();
			return;
		}
		$id = ($id != "") ? $id : $this->input->post('id');
		$this->load->model('m_report');
		$arrdata = $this->m_report->repository($act, $id);
		$data = $this->load->view('content/newtable', $arrdata, true);
		if ($this->input->post("ajax") || $act == "post") {
			echo $arrdata;
		} else {
			$this->content = $data;
			$this->index();
		}
	}

	public function report_jinspection($act, $id)
	{
		if (!$this->session->userdata('LOGGED')) {
			$this->index();
			return;
		}
		$id = ($id != "") ? $id : $this->input->post('id');
		$this->load->model('m_report');
		$arrdata = $this->m_report->report_jinspection($act, $id);
		$data = $this->load->view('content/newtable', $arrdata, true);
		if ($this->input->post("ajax") || $act == "post") {
			echo $arrdata;
		} else {
			$this->content = $data;
			$this->index();
		}
	}

	public function behandle($act, $id)
	{
		if (!$this->session->userdata('LOGGED')) {
			$this->index();
			return;
		}
		$id = ($id != "") ? $id : $this->input->post('id');
		$this->load->model('m_report');
		$arrdata = $this->m_report->behandle($act, $id);
		$data = $this->load->view('content/newtable', $arrdata, true);
		if ($this->input->post("ajax") || $act == "post") {
			echo $arrdata;
		} else {
			$this->content = $data;
			$this->index();
		}
	}

	public function reportStack()
	{
		if (!$this->session->userdata('LOGGED')) {
			$this->index();
			return;
		}

		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('jobs', 'NO JOB SLIP', 'required');
		$this->content = $this->load->view('content/operation/reportstack', $data, true);
		$this->index();
	}

	public function reportDetail()
	{
		if (!$this->session->userdata('LOGGED')) {
			$this->index();
			return;
		}

		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('jobs', 'NO JOB SLIP', 'required');
		$this->content = $this->load->view('content/operation/reportdetail', $data, true);
		$this->index();
	}

	public function reportPaket()
	{
		if (!$this->session->userdata('LOGGED')) {
			$this->index();
			return;
		}

		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('jobs', 'NO JOB SLIP', 'required');
		$this->content = $this->load->view('content/operation/reportpaket', $data, true);
		$this->index();
	}
	// public function get_data_by_date_range()
	// {

	// 	//$start_date = $this->input->post('start_date');
	// 	//$end_date = $this->input->post('end_date');
	//     $var = $this->input->post('start_date');
	// 	$date = str_replace('/', '-', $var);
	// 	$starDate= date('Y-m-d', strtotime($date));

	// 	$var22 = $this->input->post('end_date');
	// 	$date22 = str_replace('/', '-', $var22);
	// 	$endDate= date('Y-m-d', strtotime($date22));

	// 	$search_value = $this->input->post('search[value]');
	// 	$start=$this->input->post('start');
	// 	$length=$this->input->post('length');
	// 	$total_data = $this->db->select('tr.NO_DOK as no,tr.NO_DOK, tr.TGL_DOK, trc.NO_CONT, trc.UKR_CONT, trc.TIPE_CONT, trc.DISCHARGE as WAKTU_MASUK, ts.NO_SPK, tob.W_BEHANDLE, tod.WK_GATEOUT')

	// 								->from('t_request tr')
	// 								->join('t_request_cont trc', 'tr.ID = trc.ID')
	// 								->join('t_spk ts', 'tr.NO_DOK = ts.NO_DOK')
	// 								->join('t_spk tss', 'tr.TGL_DOK = tss.TGL_DOK')
	// 								->join('t_op_behandlein tob', 'tob.NO_SPK = ts.NO_SPK')
	// 								->join('t_op_behandlein tob1', 'tob1.NO_CONT = trc.NO_CONT')
	// 								->join('t_op_delivery tod ', 'tod.NO_SPK = ts.NO_SPK')
	// 								->join('t_op_delivery tod1 ', 'tod1.NO_CONT = trc.NO_CONT')
	// 								->select("COALESCE(tr.NO_DOK, '-') as NO_DOK", FALSE)
	// 								->select("COALESCE(tr.TGL_DOK, '-') as TGL_DOK", FALSE)
	// 								->select("COALESCE(trc.NO_CONT, '-') as NO_CONT", FALSE)
	// 								->select("COALESCE(trc.UKR_CONT, '-') as UKR_CONT", FALSE)
	// 								->select("COALESCE(trc.TIPE_CONT, '-') as TIPE_CONT", FALSE)
	// 								->select("COALESCE(trc.DISCHARGE, '-') as WAKTU_MASUK", FALSE)
	// 								->select("COALESCE(ts.NO_SPK, '-') as NO_SPK", FALSE)
	// 								->select("COALESCE(tob.W_BEHANDLE, '-') as WAKTU_BEHANDLE_IN", FALSE)
	// 								->select("COALESCE(tod.WK_GATEOUT, '-') as GATEOUT", FALSE)
	// 								->where('tr.TGL_DOK >=', $starDate)
	// 								->where('tr.TGL_DOK <=', $endDate)
	// 								->count_all_results();
	// 	$query = $this->db->select('tr.NO_DOK as no,tr.NO_DOK, tr.TGL_DOK, trc.NO_CONT, trc.UKR_CONT, trc.TIPE_CONT, trc.DISCHARGE as WAKTU_MASUK, ts.NO_SPK, tob.W_BEHANDLE , tod.WK_GATEOUT')

	// 					->from('t_request tr')
	// 					->join('t_request_cont trc', 'tr.ID = trc.ID')
	// 					->join('t_spk ts', 'tr.NO_DOK = ts.NO_DOK')
	// 					->join('t_spk tss', 'tr.TGL_DOK = tss.TGL_DOK')
	// 					->join('t_op_behandlein tob', 'tob.NO_SPK = ts.NO_SPK')
	// 					->join('t_op_behandlein tob1', 'tob1.NO_CONT = trc.NO_CONT')
	// 					->join('t_op_delivery tod ', 'tod.NO_SPK = ts.NO_SPK')
	// 					->join('t_op_delivery tod1 ', 'tod1.NO_CONT = trc.NO_CONT')
	// 					->select("COALESCE(tr.NO_DOK, '-') as NO_DOK", FALSE)
	// 					->select("COALESCE(tr.TGL_DOK, '-') as TGL_DOK", FALSE)
	// 					->select("COALESCE(trc.NO_CONT, '-') as NO_CONT", FALSE)
	// 					->select("COALESCE(trc.UKR_CONT, '-') as UKR_CONT", FALSE)
	// 					->select("COALESCE(trc.TIPE_CONT, '-') as TIPE_CONT", FALSE)
	// 					->select("COALESCE(trc.DISCHARGE, '-') as WAKTU_MASUK", FALSE)
	// 					->select("COALESCE(ts.NO_SPK, '-') as NO_SPK", FALSE)
	// 					->select("COALESCE(tob.W_BEHANDLE, '-') as WAKTU_BEHANDLE_IN", FALSE)
	// 					->select("COALESCE(tod.WK_GATEOUT, '-') as GATEOUT", FALSE)
	// 					->where('tr.TGL_DOK >=', $starDate)
	// 					->where('tr.TGL_DOK <=', $endDate)
	// 					->limit($length,$start)
	// 					->get();



	// 	// Mengirim data dalam format json ke datatables
	// 	$data['draw'] =  $this->input->post('draw');
	//     	$data['recordsTotal'] = $total_data;
	//     	$data['recordsFiltered'] = $total_data;
	// 	$data['data'] = $query->result_array();
	//     	echo json_encode($data);
	// }

	public function get_data_by_date_range()
	{

		//$start_date = $this->input->post('start_date');
		//$end_date = $this->input->post('end_date');
		$var = $this->input->post('start_date');
		$date = str_replace('/', '-', $var);
		$starDate = date('Y-m-d', strtotime($date));

		$var22 = $this->input->post('end_date');
		$date22 = str_replace('/', '-', $var22);
		$endDate = date('Y-m-d', strtotime($date22));

		$search_value = $this->input->post('search[value]');
		$start = $this->input->post('start');
		$length = $this->input->post('length');
		$condition = '';
		if (!empty($search_value)) {
			$condition = " (tr.NO_DOK LIKE '%$search_value%' OR tr.TGL_DOK LIKE '%$search_value%' OR trc.NO_CONT LIKE '%$search_value%' OR trc.UKR_CONT LIKE '%$search_value%' OR trc.TIPE_CONT LIKE '%$search_value%' OR trc.DISCHARGE LIKE '%$search_value%' OR  ts.NO_SPK LIKE '%$search_value%' OR tob.W_BEHANDLE LIKE '%$search_value%' OR tod.WK_GATEOUT LIKE '%$search_value%') ";
		}

		$total_data = $this->db->select('tr.NO_DOK as no,tr.NO_DOK, tr.TGL_DOK, trc.NO_CONT, trc.UKR_CONT, trc.TIPE_CONT, trc.DISCHARGE as WAKTU_MASUK, ts.NO_SPK, tob.W_BEHANDLE, tod.WK_GATEOUT')

			->from('t_request tr')
			->join('t_request_cont trc', 'tr.ID = trc.ID')
			->join('t_spk ts', 'tr.NO_DOK = ts.NO_DOK')
			->join('t_spk tss', 'tr.TGL_DOK = tss.TGL_DOK')
			->join('t_op_behandlein tob', 'tob.NO_SPK = ts.NO_SPK')
			->join('t_op_behandlein tob1', 'tob1.NO_CONT = trc.NO_CONT')
			->join('t_op_delivery tod ', 'tod.NO_SPK = ts.NO_SPK')
			->join('t_op_delivery tod1 ', 'tod1.NO_CONT = trc.NO_CONT')
			->select("COALESCE(tr.NO_DOK, '-') as NO_DOK", FALSE)
			->select("COALESCE(tr.TGL_DOK, '-') as TGL_DOK", FALSE)
			->select("COALESCE(trc.NO_CONT, '-') as NO_CONT", FALSE)
			->select("COALESCE(trc.UKR_CONT, '-') as UKR_CONT", FALSE)
			->select("COALESCE(trc.TIPE_CONT, '-') as TIPE_CONT", FALSE)
			->select("COALESCE(trc.DISCHARGE, '-') as WAKTU_MASUK", FALSE)
			->select("COALESCE(ts.NO_SPK, '-') as NO_SPK", FALSE)
			->select("COALESCE(tob.W_BEHANDLE, '-') as WAKTU_BEHADNLE_IN", FALSE)
			->select("COALESCE(tod.WK_GATEOUT, '-') as GATEOUT", FALSE)
			->where('tr.TGL_DOK >=', $starDate)
			->where('tr.TGL_DOK <=', $endDate);
		//->count_all_results();
		if (!empty($condition)) {
			$total_data->where($condition);
		}
		$resultstotal = $total_data->count_all_results();
		$query = $this->db->select('tr.NO_DOK as no,tr.NO_DOK, tr.TGL_DOK, trc.NO_CONT, trc.UKR_CONT, trc.TIPE_CONT, trc.DISCHARGE as WAKTU_MASUK, ts.NO_SPK, tob.W_BEHANDLE , tod.WK_GATEOUT')

			->from('t_request tr')
			->join('t_request_cont trc', 'tr.ID = trc.ID')
			->join('t_spk ts', 'tr.NO_DOK = ts.NO_DOK')
			->join('t_spk tss', 'tr.TGL_DOK = tss.TGL_DOK')
			->join('t_op_behandlein tob', 'tob.NO_SPK = ts.NO_SPK')
			->join('t_op_behandlein tob1', 'tob1.NO_CONT = trc.NO_CONT')
			->join('t_op_delivery tod ', 'tod.NO_SPK = ts.NO_SPK')
			->join('t_op_delivery tod1 ', 'tod1.NO_CONT = trc.NO_CONT')
			->select("COALESCE(tr.NO_DOK, '-') as NO_DOK", FALSE)
			->select("COALESCE(tr.TGL_DOK, '-') as TGL_DOK", FALSE)
			->select("COALESCE(trc.NO_CONT, '-') as NO_CONT", FALSE)
			->select("COALESCE(trc.UKR_CONT, '-') as UKR_CONT", FALSE)
			->select("COALESCE(trc.TIPE_CONT, '-') as TIPE_CONT", FALSE)
			->select("COALESCE(trc.DISCHARGE, '-') as WAKTU_MASUK", FALSE)
			->select("COALESCE(ts.NO_SPK, '-') as NO_SPK", FALSE)
			->select("COALESCE(tob.W_BEHANDLE, '-') as WAKTU_BEHADNLE_IN", FALSE)
			->select("COALESCE(tod.WK_GATEOUT, '-') as GATEOUT", FALSE)
			->where('tr.TGL_DOK >=', $starDate)
			->where('tr.TGL_DOK <=', $endDate)
			->limit($length, $start);
		//->get();

		if (!empty($condition)) {
			$query->where($condition);
		}
		$results = $query->get();

		// Mengirim data dalam format json ke datatables
		$data['draw'] =  $this->input->post('draw');
		$data['recordsTotal'] = $resultstotal;
		$data['recordsFiltered'] = $resultstotal;
		$data['data'] = $results->result_array();
		echo json_encode($data);
	}


	public function getrange2()
	{
		$var = $this->input->post('start_date');
		$date = str_replace('/', '-', $var);
		$starDate = date('Y-m-d', strtotime($date));

		$var22 = $this->input->post('end_date');
		$date22 = str_replace('/', '-', $var22);
		$endDate = date('Y-m-d', strtotime($date22));

		$search_value = $this->input->post('search[value]');
		$start = $this->input->post('start');
		$length = $this->input->post('length');
		$condition = '';
		if (!empty($search_value)) {
			$condition = " (a.NO_SPK LIKE '%$search_value%' OR a.TGL_SPK LIKE '%$search_value%' OR a.NO_DOC LIKE '%$search_value%' OR a.JENIS_DOK LIKE '%$search_value%' OR a.NO_CONT LIKE '%$search_value%' OR a.UKR_CONT LIKE '%$search_value%' OR a.TYPE_CONT LIKE '%$search_value%' OR a.ALAT1 LIKE '%$search_value%' OR a.ALAT2 LIKE '%$search_value%' OR a.ALAT3 LIKE '%$search_value%' OR a.ALAT4 LIKE '%$search_value%' OR a.ALAT5 LIKE '%$search_value%' OR a.ALAT6 LIKE '%$search_value%'OR a.ALAT7 LIKE '%$search_value%'OR a.ALAT8 LIKE '%$search_value%' OR a.ALAT9 LIKE '%$search_value%') ";
			// var_dump($condition);
			// die();
		}


		$sqltotal = $this->db->select('a.NO_SPK as no,a.NO_SPK,a.TGL_SPK,a.NO_DOC,a.JENIS_DOK,a.NO_CONT,a.UKR_CONT,a.TYPE_CONT,a.ALAT1,a.ALAT2 ,ALAT3,a.ALAT4,a.ALAT5 ,a.ALAT6,a.ALAT7,a.ALAT8,a.ALAT9')
			->from('r_jobslip a')
			->where('a.tgl_spk >=', $starDate)
			->where('a.tgl_spk <=', $endDate);

		if (!empty($condition)) {
			$sqltotal->where($condition);
		}
		$resultstotal = $sqltotal->count_all_results();


		$SQL = $this->db->select('a.NO_SPK as no,a.NO_SPK,a.TGL_SPK,a.NO_DOC,a.JENIS_DOK,a.NO_CONT,a.UKR_CONT,a.TYPE_CONT,a.ALAT1,a.ALAT2 ,ALAT3,a.ALAT4,a.ALAT5 ,a.ALAT6,a.ALAT7,a.ALAT8,a.ALAT9')

			->from('r_jobslip a')
			->where('a.tgl_spk >=', $starDate)
			->where('a.tgl_spk <=', $endDate)
			->limit($length, $start);
		if (!empty($condition)) {
			$SQL->where($condition);
		}
		$results = $SQL->get();

		$data['draw'] =  $this->input->post('draw');
		$data['recordsTotal'] = $resultstotal;
		$data['recordsFiltered'] = $resultstotal;
		$data['data'] = $results->result_array();
		echo json_encode($data);
	}

	public function get_data_paket_bydate_range()
	{
		$var = $this->input->post('start_date');
		$date = str_replace('/', '-', $var);
		$starDate = date('Y-m-d', strtotime($date));

		$var22 = $this->input->post('end_date');
		$date22 = str_replace('/', '-', $var22);
		$endDate = date('Y-m-d', strtotime($date22));
		// $starDate='2023-03-21';
		// $endDate='2023-03-29';

		$search_value = $this->input->post('search[value]');
		$start = $this->input->post('start');
		$length = $this->input->post('length');
		$condition = '';
		if (!empty($search_value)) {
			$condition = " (no_spk LIKE '%$search_value%' OR tgl_spk LIKE '%$search_value%' OR no_dok LIKE '%$search_value%' OR no_cont LIKE '%$search_value%' OR ukr_cont LIKE '%$search_value%' OR tipe_cont LIKE '%$search_value%'  ) ";
		}

		$sqltotal = $this->db->select('no_spk as no,no_spk,tgl_spk,no_dok,no_cont,ukr_cont,tipe_cont,
											(case when pre_liftof=1 and pre_storage=1 and cic_lifton=1 and cic_striping=1 and cic_liftchasis=1 and post_haulage=1 and post_liftoff=1 and post_stogare=1 then 1 else 0 end )as PAKET1,
											(case	 when pre_liftof=0 and pre_storage=0 and cic_lifton=1 and cic_striping=1 and cic_liftchasis=1 and post_haulage=1 and post_liftoff=1 and post_stogare=1 then 1 else 0 end) as PAKET2,
											(case 	when pre_liftof=0 and pre_storage=0 and cic_lifton=1 and cic_striping=1 and cic_liftchasis=1 and post_haulage=0 and post_liftoff=0 and post_stogare=0 then 1 else 0 end ) as PAKET3,
											(case  	when pre_liftof=1 and pre_storage=1 and cic_lifton=1 and cic_striping=1 and cic_liftchasis=1 and post_haulage=0 and post_liftoff=0 and post_stogare=0 then 1 else 0 end) as PAKET4,
											(case 	when pre_liftof=1 and pre_storage=1 and cic_lifton=0 and cic_striping=0 and cic_liftchasis=0 and post_haulage=0 and post_liftoff=0 and post_stogare=0 then 1 else 0 end) as PAKET5,
											(case 	when pre_liftof=1 and pre_storage=1 and cic_lifton>1 and cic_striping=1 and cic_liftchasis=1 and post_haulage=1 and post_liftoff=1 and post_stogare>1 then 1 else 0 end) as PAKET6,
											(case 	when pre_liftof=1 and pre_storage=1 and cic_lifton=1 and cic_striping=1 and cic_liftchasis=1 and post_haulage=1 and post_liftoff=1 and post_stogare=1 then 1 else 0 end )as PAKET8')

			->from('(
									select job.no_spk as no,job.no_spk,job.tgl_spk,job.no_dok,job.no_cont,job.ukr_cont,job.tipe_cont, 
									(select count(pre_liftof) from vw_pre_liftof a where NO_SPK =job.NO_SPK)as pre_liftof,
									(select count(pre_storage) from vw_pre_storage where NO_SPK =job.NO_SPK) as pre_storage,
									(select count(cic_lifton) from vw_cic_lifton where NO_SPK =job.NO_SPK ) as cic_lifton,
									(select count(cic_striping) from vw_cic_striping where NO_SPK =job.NO_SPK)  as cic_striping,
									(select count(cic_liftchasis) from vw_cic_liftchasis where NO_SPK =job.NO_SPK ) as cic_liftchasis,
									(select count(post_haulage) from vw_post_haulage where NO_SPK =job.NO_SPK ) as post_haulage,
									(select count(post_liftoff) from vw_post_liftoff where NO_SPK =job.NO_SPK ) as post_liftoff,
									(select count(post_stogare) from vw_post_stogare where NO_SPK =job.NO_SPK )as post_stogare
									from vw_laporankegiatan job)abc')

			->where('tgl_spk >=', $starDate)
			->where('tgl_spk <=', $endDate);

		if (!empty($condition)) {
			$sqltotal->where($condition);
		}

		$resultstotal = $sqltotal->count_all_results();

		$SQL = $this->db->select('no_spk as no,no_spk,tgl_spk,no_dok,no_cont,ukr_cont,tipe_cont,
						(case when pre_liftof=1 and pre_storage=1 and cic_lifton=1 and cic_striping=1 and cic_liftchasis=1 and post_haulage=1 and post_liftoff=1 and post_stogare=1 then 1 else 0 end )as PAKET1,
						(case	 when pre_liftof=0 and pre_storage=0 and cic_lifton=1 and cic_striping=1 and cic_liftchasis=1 and post_haulage=1 and post_liftoff=1 and post_stogare=1 then 1 else 0 end) as PAKET2,
						(case 	when pre_liftof=0 and pre_storage=0 and cic_lifton=1 and cic_striping=1 and cic_liftchasis=1 and post_haulage=0 and post_liftoff=0 and post_stogare=0 then 1 else 0 end ) as PAKET3,
						(case  	when pre_liftof=1 and pre_storage=1 and cic_lifton=1 and cic_striping=1 and cic_liftchasis=1 and post_haulage=0 and post_liftoff=0 and post_stogare=0 then 1 else 0 end) as PAKET4,
						(case 	when pre_liftof=1 and pre_storage=1 and cic_lifton=0 and cic_striping=0 and cic_liftchasis=0 and post_haulage=0 and post_liftoff=0 and post_stogare=0 then 1 else 0 end) as PAKET5,
						(case 	when pre_liftof=1 and pre_storage=1 and cic_lifton>1 and cic_striping=1 and cic_liftchasis=1 and post_haulage=1 and post_liftoff=1 and post_stogare>1 then 1 else 0 end) as PAKET6,
						(case 	when pre_liftof=1 and pre_storage=1 and cic_lifton=1 and cic_striping=1 and cic_liftchasis=1 and post_haulage=1 and post_liftoff=1 and post_stogare=1 then 1 else 0 end )as PAKET8')

			->from('(
							select job.no_spk as no,job.no_spk,job.tgl_spk,job.no_dok,job.no_cont,job.ukr_cont,job.tipe_cont, 
							(select count(pre_liftof) from vw_pre_liftof a where NO_SPK =job.NO_SPK)as pre_liftof,
							(select count(pre_storage) from vw_pre_storage where NO_SPK =job.NO_SPK) as pre_storage,
							(select count(cic_lifton) from vw_cic_lifton where NO_SPK =job.NO_SPK ) as cic_lifton,
							(select count(cic_striping) from vw_cic_striping where NO_SPK =job.NO_SPK)  as cic_striping,
							(select count(cic_liftchasis) from vw_cic_liftchasis where NO_SPK =job.NO_SPK ) as cic_liftchasis,
							(select count(post_haulage) from vw_post_haulage where NO_SPK =job.NO_SPK ) as post_haulage,
							(select count(post_liftoff) from vw_post_liftoff where NO_SPK =job.NO_SPK ) as post_liftoff,
							(select count(post_stogare) from vw_post_stogare where NO_SPK =job.NO_SPK )as post_stogare
							from vw_laporankegiatan job)abc')
			->where('tgl_spk >=', $starDate)
			->where('tgl_spk <=', $endDate)
			->limit($length, $start);
		if (!empty($condition)) {
			$SQL->where($condition);
		}
		$results = $SQL->get();

		$data['draw'] =  $this->input->post('draw');
		$data['recordsTotal'] = $resultstotal;
		$data['recordsFiltered'] = $resultstotal;
		$data['data'] = $results->result_array();
		echo json_encode($data);
	}

	public function get_data_paket_bydate_range2()
	{
		$var = $this->input->post('start_date');
		$date = str_replace('/', '-', $var);
		$starDate = date('Y-m-d', strtotime($date));

		$var22 = $this->input->post('end_date');
		$date22 = str_replace('/', '-', $var22);
		$endDate = date('Y-m-d', strtotime($date22));
		// $starDate='2023-03-21';
		// $endDate='2023-03-29';

		$search_value = $this->input->post('search[value]');
		$start = $this->input->post('start');
		$length = $this->input->post('length');
		$condition = '';
		if (!empty($search_value)) {
			$condition = " (rj.NO_SPK LIKE '%$search_value%' OR rj.NO_DOC LIKE '%$search_value%' OR rj.TGL_SPK LIKE '%$search_value%' OR rj.NO_CONT LIKE '%$search_value%') ";
		}

		$sqltotal = $this->db->select('rj.NO_SPK as no, rj.NO_SPK, rj.NO_DOC, rj.TGL_SPK, rj.NO_CONT,
											(case when rj.PEKERJAAN1 =1 and rj.PEKERJAAN2 =1 and rj.PEKERJAAN3 =1 and rj.PEKERJAAN4 =1 and rj.PEKERJAAN5 =1 or rj.PEKERJAAN5 =0 and rj.PEKERJAAN6 =1 or rj.PEKERJAAN6 =0 and rj.PEKERJAAN7 =1 and rj.PEKERJAAN8 =1  and FUMIGASI = "N" then 1 else 0 end) PAKET1 ,
											(case when rj.PEKERJAAN1 =0 and rj.PEKERJAAN2 =0 and rj.PEKERJAAN3 =1 and rj.PEKERJAAN4 =1 and rj.PEKERJAAN5 =1 and rj.PEKERJAAN6 =1  and rj.PEKERJAAN7 =1 and rj.PEKERJAAN8 =1  and FUMIGASI = "N" then 1 else 0 end) PAKET2, 
											(case when rj.PEKERJAAN1 =0 and rj.PEKERJAAN2 =0 and rj.PEKERJAAN3 =1 and rj.PEKERJAAN4 =1 and rj.PEKERJAAN5 =1 and rj.PEKERJAAN6 =0  and rj.PEKERJAAN7 =0 and rj.PEKERJAAN8 =0  and FUMIGASI = "N" then 1 else 0 end) PAKET3,
											(case when rj.PEKERJAAN1 =1 and rj.PEKERJAAN2 =1 and rj.PEKERJAAN3 =1 and rj.PEKERJAAN4 =1 and rj.PEKERJAAN5 =1 and rj.PEKERJAAN6 =0  and rj.PEKERJAAN7 =0 and rj.PEKERJAAN8 =0 and FUMIGASI = "N" then 1 else 0 end) PAKET4,
											(case when rj.PEKERJAAN1 =1 and rj.PEKERJAAN2 =1 and rj.PEKERJAAN3 =0 and rj.PEKERJAAN4 =0 and rj.PEKERJAAN5 =0 and rj.PEKERJAAN6 =0  and rj.PEKERJAAN7 =0 and rj.PEKERJAAN8 =0 and FUMIGASI = "N" then 1 else 0 end) PAKET5,(case when FUMIGASI = "Z" then 1 else 0 end) PAKET6,
											(case when FUMIGASI = "Y" then 1 else 0 end) PAKET7,
											0 PAKET8, 
											0 PAKET9')

			->from('vw_rjobslip rj')

			->where('rj.TGL_SPK >=', $starDate)
			->where('rj.TGL_SPK <=', $endDate)
			->group_by('NO_CONT', 'NO_DOC');

		if (!empty($condition)) {
			$sqltotal->where($condition);
		}

		$resultstotal = $sqltotal->count_all_results();

		$SQL = $this->db->select('rj.NO_SPK as no, rj.NO_SPK, rj.NO_DOC, rj.TGL_SPK, rj.NO_CONT,
											(case when rj.PEKERJAAN1 =1 and rj.PEKERJAAN2 =1 and rj.PEKERJAAN3 =1 and rj.PEKERJAAN4 =1 and rj.PEKERJAAN5 =1 or rj.PEKERJAAN5 =0 and rj.PEKERJAAN6 =1 or rj.PEKERJAAN6 =0 and rj.PEKERJAAN7 =1 and rj.PEKERJAAN8 =1  and FUMIGASI = "N" then 1 else 0 end) PAKET1 ,
											(case when rj.PEKERJAAN1 =0 and rj.PEKERJAAN2 =0 and rj.PEKERJAAN3 =1 and rj.PEKERJAAN4 =1 and rj.PEKERJAAN5 =1 and rj.PEKERJAAN6 =1  and rj.PEKERJAAN7 =1 and rj.PEKERJAAN8 =1  and FUMIGASI = "N" then 1 else 0 end) PAKET2, 
											(case when rj.PEKERJAAN1 =0 and rj.PEKERJAAN2 =0 and rj.PEKERJAAN3 =1 and rj.PEKERJAAN4 =1 and rj.PEKERJAAN5 =1 and rj.PEKERJAAN6 =0  and rj.PEKERJAAN7 =0 and rj.PEKERJAAN8 =0  and FUMIGASI = "N" then 1 else 0 end) PAKET3,
											(case when rj.PEKERJAAN1 =1 and rj.PEKERJAAN2 =1 and rj.PEKERJAAN3 =1 and rj.PEKERJAAN4 =1 and rj.PEKERJAAN5 =1 and rj.PEKERJAAN6 =0  and rj.PEKERJAAN7 =0 and rj.PEKERJAAN8 =0 and FUMIGASI = "N" then 1 else 0 end) PAKET4,
											(case when rj.PEKERJAAN1 =1 and rj.PEKERJAAN2 =1 and rj.PEKERJAAN3 =0 and rj.PEKERJAAN4 =0 and rj.PEKERJAAN5 =0 and rj.PEKERJAAN6 =0  and rj.PEKERJAAN7 =0 and rj.PEKERJAAN8 =0 and FUMIGASI = "N" then 1 else 0 end) PAKET5,(case when FUMIGASI = "Z" then 1 else 0 end) PAKET6,
											(case when FUMIGASI ="Y" then 1 else 0 end) PAKET7,
											0 PAKET8, 
											0 PAKET9')

			->from('vw_rjobslip rj')
			->where('rj.TGL_SPK >=', $starDate)
			->where('rj.TGL_SPK <=', $endDate)
			->group_by('NO_CONT', 'NO_DOC')
			->limit($length, $start);
		if (!empty($condition)) {
			$SQL->where($condition);
		}
		$results = $SQL->get();

		$data['draw'] =  $this->input->post('draw');
		$data['recordsTotal'] = $resultstotal;
		$data['recordsFiltered'] = $resultstotal;
		$data['data'] = $results->result_array();
		echo json_encode($data);
	}

	public function stacking($act, $id)
	{
		if (!$this->session->userdata('LOGGED')) {
			$this->index();
			return;
		}
		$id = ($id != "") ? $id : $this->input->post('id');
		$this->load->model('m_report');
		$arrdata = $this->m_report->stacking($act, $id);
		$data = $this->load->view('content/newtable', $arrdata, true);
		if ($this->input->post("ajax") || $act == "post") {
			echo $arrdata;
		} else {
			$this->content = $data;
			$this->index();
		}
	}

	public function terbit_gatepass($act, $id)
	{
		if (!$this->session->userdata('LOGGED')) {
			$this->index();
			return;
		}
		$id = ($id != "") ? $id : $this->input->post('id');
		$this->load->model('m_report');
		$arrdata = $this->m_report->terbit_gatepass($act, $id);
		$data = $this->load->view('content/newtable', $arrdata, true);
		if ($this->input->post("ajax") || $act == "post") {
			echo $arrdata;
		} else {
			$this->content = $data;
			$this->index();
		}
	}

	public function penarikan($act, $id)
	{
		if (!$this->session->userdata('LOGGED')) {
			$this->index();
			return;
		}
		$id = ($id != "") ? $id : $this->input->post('id');
		$this->load->model('m_report');
		$arrdata = $this->m_report->penarikan($act, $id);
		$data = $this->load->view('content/newtable', $arrdata, true);
		if ($this->input->post("ajax") || $act == "post") {
			echo $arrdata;
		} else {
			$this->content = $data;
			$this->index();
		}
	}

	public function terbit_spk($act, $id)
	{
		if (!$this->session->userdata('LOGGED')) {
			$this->index();
			return;
		}
		$id = ($id != "") ? $id : $this->input->post('id');
		$this->load->model('m_report');
		$arrdata = $this->m_report->terbit_spk($act, $id);
		$data = $this->load->view('content/newtable', $arrdata, true);
		if ($this->input->post("ajax") || $act == "post") {
			echo $arrdata;
		} else {
			$this->content = $data;
			$this->index();
		}
	}

	public function reefer($act, $id)
	{
		if (!$this->session->userdata('LOGGED')) {
			$this->index();
			return;
		}
		$id = ($id != "") ? $id : $this->input->post('id');
		$this->load->model('m_report');
		$arrdata = $this->m_report->reefer($act, $id);
		$data = $this->load->view('content/newtable', $arrdata, true);
		if ($this->input->post("ajax") || $act == "post") {
			echo $arrdata;
		} else {
			$this->content = $data;
			$this->index();
		}
	}

	public function bilbehandle($act, $id)
	{
		if (!$this->session->userdata('LOGGED')) {
			$this->index();
			return;
		}
		$id = ($id != "") ? $id : $this->input->post('id');
		$this->load->model('m_report');
		$arrdata = $this->m_report->bilbehandle($act, $id);
		$data = $this->load->view('content/newtable', $arrdata, true);
		if ($this->input->post("ajax") || $act == "post") {
			echo $arrdata;
		} else {
			$this->content = $data;
			$this->index();
		}
	}

	public function bildelivery($act, $id)
	{
		if (!$this->session->userdata('LOGGED')) {
			$this->index();
			return;
		}
		$id = ($id != "") ? $id : $this->input->post('id');
		$this->load->model('m_report');
		$arrdata = $this->m_report->bildelivery($act, $id);
		$data = $this->load->view('content/newtable', $arrdata, true);
		if ($this->input->post("ajax") || $act == "post") {
			echo $arrdata;
		} else {
			$this->content = $data;
			$this->index();
		}
	}

	public function pergerakan($act, $id)
	{
		if (!$this->session->userdata('LOGGED')) {
			$this->index();
			return;
		}
		$id = ($id != "") ? $id : $this->input->post('id');
		$this->load->model('m_report');
		$arrdata = $this->m_report->pergerakan($act, $id);
		$data = $this->load->view('content/newtable', $arrdata, true);
		if ($this->input->post("ajax") || $act == "post") {
			echo $arrdata;
		} else {
			$this->content = $data;
			$this->index();
		}
	}

	public function bilextention($act, $id)
	{
		if (!$this->session->userdata('LOGGED')) {
			$this->index();
			return;
		}
		$id = ($id != "") ? $id : $this->input->post('id');
		$this->load->model('m_report');
		$arrdata = $this->m_report->bilextention($act, $id);
		$data = $this->load->view('content/newtable', $arrdata, true);
		if ($this->input->post("ajax") || $act == "post") {
			echo $arrdata;
		} else {
			$this->content = $data;
			$this->index();
		}
	}

	public function respon_pkb($act, $id)
	{
		if (!$this->session->userdata('LOGGED')) {
			$this->index();
			return;
		}
		$id = ($id != "") ? $id : $this->input->post('id');
		$this->load->model('m_report');
		$arrdata = $this->m_report->respon_pkb($act, $id);
		$data = $this->load->view('content/newtable', $arrdata, true);
		if ($this->input->post("ajax") || $act == "post") {
			echo $arrdata;
		} else {
			$this->content = $data;
			$this->index();
		}
	}

	public function delivery($act, $id)
	{
		if (!$this->session->userdata('LOGGED')) {
			$this->index();
			return;
		}
		$id = ($id != "") ? $id : $this->input->post('id');
		$this->load->model('m_report');
		$arrdata = $this->m_report->delivery($act, $id);
		$data = $this->load->view('content/newtable', $arrdata, true);
		if ($this->input->post("ajax") || $act == "post") {
			echo $arrdata;
		} else {
			$this->content = $data;
			$this->index();
		}
	}

	public function pemeriksaan($act, $id)
	{
		if (!$this->session->userdata('LOGGED')) {
			$this->index();
			return;
		}
		$id = ($id != "") ? $id : $this->input->post('id');
		$this->load->model('m_report');
		$arrdata = $this->m_report->pemeriksaan($act, $id);
		$data = $this->load->view('content/newtable', $arrdata, true);
		if ($this->input->post("ajax") || $act == "post") {
			echo $arrdata;
		} else {
			$this->content = $data;
			$this->index();
		}
	}

	public function marshalling($act, $id)
	{
		if (!$this->session->userdata('LOGGED')) {
			$this->index();
			return;
		}
		$id = ($id != "") ? $id : $this->input->post('id');
		$this->load->model('m_report');
		$arrdata = $this->m_report->marshalling($act, $id);
		$data = $this->load->view('content/newtable', $arrdata, true);
		if ($this->input->post("ajax") || $act == "post") {
			echo $arrdata;
		} else {
			$this->content = $data;
			$this->index();
		}
	}

	public function siap_periksa($act, $id)
	{
		if (!$this->session->userdata('LOGGED')) {
			$this->index();
			return;
		}
		$id = ($id != "") ? $id : $this->input->post('id');
		$this->load->model('m_report');
		$arrdata = $this->m_report->siap_periksa($act, $id);
		$data = $this->load->view('content/newtable', $arrdata, true);
		if ($this->input->post("ajax") || $act == "post") {
			echo $arrdata;
		} else {
			$this->content = $data;
			$this->index();
		}
	}

	public function marshallingex($act, $id)
	{
		if (!$this->session->userdata('LOGGED')) {
			$this->index();
			return;
		}
		$id = ($id != "") ? $id : $this->input->post('id');
		$this->load->model('m_report');
		$arrdata = $this->m_report->marshallingex($act, $id);
		$data = $this->load->view('content/newtable', $arrdata, true);
		if ($this->input->post("ajax") || $act == "post") {
			echo $arrdata;
		} else {
			$this->content = $data;
			$this->index();
		}
	}

	public function monitoringbc($act, $id)
	{
		if (!$this->session->userdata('LOGGED')) {
			$this->index();
			return;
		}
		$id = ($id != "") ? $id : $this->input->post('id');
		$this->load->model('m_report');
		$arrdata = $this->m_report->monitoringbc($act, $id);
		$data = $this->load->view('content/newtable', $arrdata, true);
		if ($this->input->post("ajax") || $act == "post") {
			echo $arrdata;
		} else {
			$this->content = $data;
			$this->index();
		}
	}

	public function dashboard_monitoring($act, $id)
	{
		if (!$this->session->userdata('LOGGED')) {
			$this->index();
			return;
		}
		$id = ($id != "") ? $id : $this->input->post('id');
		if ($act == "detail") {
			$data['id'] = $id;
			$data['action'] = 'save';
			$this->load->model('m_report');
			$data['result_monitoring'] = $this->m_report->data_monitoring($id);
		} else {
			$this->load->model('m_report');
			$arrdata = $this->m_report->dashboard_monitoring($act, $id);
			$data = $this->load->view('content/newtable', $arrdata, true);
			if ($this->input->post("ajax") || $act == "post") {
				echo $arrdata;
			} else {
				$this->content = $data;
				$this->index();
			}
		}
	}

	public function karantina($act, $id)
	{
		if (!$this->session->userdata('LOGGED')) {
			$this->index();
			return;
		}
		$id = ($id != "") ? $id : $this->input->post('id');

		$this->load->model('m_report');
		$arrdata = $this->m_report->monitoring_karantina($act, $id);
		$data = $this->load->view('content/newtable', $arrdata, true);
		if ($this->input->post("ajax") || $act == "post") {
			echo $arrdata;
		} else {
			$this->content = $data;
			$this->index();
		}
	}

	public function nhi($act, $id)
	{
		if (!$this->session->userdata('LOGGED')) {
			$this->index();
			return;
		}
		$id = ($id != "") ? $id : $this->input->post('id');
		$this->load->model('m_report');
		$arrdata = $this->m_report->monitorNHI($act, $id);
		$data = $this->load->view('content/newtable', $arrdata, true);
		if ($this->input->post("ajax") || $act == "post") {
			echo $arrdata;
		} else {
			$this->content = $data;
			$this->index();
		}
	}

	public function monitoringbcnew($act, $id)
	{
		if (!$this->session->userdata('LOGGED')) {
			$this->index();
			return;
		}
		$id = ($id != "") ? $id : $this->input->post('id');
		$this->load->model('m_report');
		$arrdata = $this->m_report->monitoringbcnew($act, $id);
		$data = $this->load->view('content/newtable', $arrdata, true);
		if ($this->input->post("ajax") || $act == "post") {
			echo $arrdata;
		} else {
			$this->content = $data;
			$this->index();
		}
	}
}
