<?php 
	/**
	* 
	*/
	class RequestGatePass extends CI_Controller
	{
		
		public $content;

		public function __construct() {
	        parent::__construct();
			$this->load->model("m_requestGatePass");
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
							  '_content_' 	  => $this->content,//(grant()=="")?$this->load->view('content/error','',true):$this->content,
							  '_footers_' 	  => $footers,
							  '_footer_' 	  => $this->load->view('content/menus','',true));
				$this->parser->parse('index', $data);
			}else{
				redirect(base_url('index.php'),'refresh');
			}
		}
		
		public function cetak(){
			$this->load->library('mpdf');
			$this->load->library('ciqrcode');
			$type = 'update';
			$act = 'fl_finish_print';
			$id = base64_decode($this->input->get('id'));
			$nocont= base64_decode($this->input->get('nocont'));
			//echo $id." - ".$nocont;
			$idpost = $id.'~'.$nocont;
			$arrdata = $this->m_requestGatePass->execute($type,$act,$idpost);

			$SQL = "SELECT A.*, B.*
					FROM t_request A 
					INNER JOIN t_request_cont B ON A.ID = B.ID
					WHERE A.ID ='$id' AND B.NO_CONT='$nocont'";
			//echo $SQL;die();
			$data['result']= $this->db->query($SQL)->result_array();
			
			$params['data'] = $data['result'][0]['TAR'];
			$params['size'] = 3;
			$params['savename'] = 'assets/files/qrcode/code-'.$this->input->get('id').'.png';
			$data['savename']= $params['savename'];
			$this->ciqrcode->generate($params);
			$this->load->view('content/dokumen/format_gatepass_cic', $data);
		}
		
		public function gatepass($act, $id){
			if (!$this->session->userdata('LOGGED')){
				$this->index();
				return;
			}
			
			$id = ($id!="")?$id:$this->input->post('id');
			if($act=="gate_pass_request_detail"){
				$this->newtable->breadcrumb('Request Gate Pass', site_url());
				$this->newtable->breadcrumb('Planning', 'javascript:void(0)');
				$this->newtable->breadcrumb('Gate Pass Request ', site_url('planning/sppmp'));
				$this->newtable->breadcrumb('Gate Pass', 'javascript:void(0)');
				$data['title'] = 'Request Gate Pass';
				$data['id'] = $id;
				$this->load->model("m_requestGatePass");
				$data['arrdata'] = $this->m_requestGatePass->get_data('gate_pass_request_detail', $id);
				echo $this->content = $this->load->view('content/dokumen/gate_pass_detail',$data,true);
			}else if($act == "add_keterangan"){
				$type = 'update';
				$act = 'fl_finish';
				$arrdata = $this->m_requestGatePass->execute($type,$act, $id);
			}else if($act == "cetak"){
				$type = 'update';
				$act = 'fl_finish_print';
				$arrdata = $this->m_requestGatePass->execute($type,$act, $id);
			}else if($act == "add_paidThrough_karantina"){
				$data['id'] = $id;
				$cont = "SELECT * FROM t_request_cont WHERE ID = '".$id."'";
				$data['getCont'] = $this->db->query($cont)->result_array();
				$SQLDok = "SELECT NO_DOK,JNS_DOK FROM t_request WHERE ID = '".$id."'";
				$DOK = $this->db->query($SQLDok)->result_array();
				if($DOK[0]['JNS_DOK'] == 83){
					$SQLLic = "SELECT ID_IJIN FROM t_lic_hdr WHERE NO_IJIN = '".$DOK[0]['NO_DOK']."'";
				} else {
					$SQLLic = "SELECT ID FROM t_permit_hdr WHERE NO_DAFTAR_PABEAN = '".$DOK[0]['NO_DOK']."'";
				}
				
				$IDDOK = $this->db->query($SQLLic)->result_array();
				if($DOK[0]['JNS_DOK'] == 83){
					$data['NO_DOK'] = $IDDOK[0]['ID_IJIN'];
				}else{
					$data['NO_DOK'] = $IDDOK[0]['ID'];
				}
				echo $this->content = $this->load->view('content/dokumen/form_gatepass_karantina',$data);
			}else if($act == "paidthrought_karantina"){
				$type = 'update';
				$act = 'paidthrought_karantina';
				$iddata = $this->input->post('DATA[ID]');
				$paidthrought = $this->input->post('DATA[paidthrought]');
				//$paidnobl = $this->input->post('DATA[paidnobl]');
				$idijin = $this->input->post('DATA[ID_DOK]');
				$arrdid = $iddata.'~'.$paidthrought.'~'.$idijin;
				$arrdata = $this->m_requestGatePass->execute($type,$act, $arrdid);
				//echo $this->content = $this->load->view('content/dokumen/form_paidthrought',$data);
			}else{
				$this->load->model("m_requestGatePass");
				$arrdata = $this->m_requestGatePass->list_reqGatePassKarantina($act, $id);
				$data = $this->load->view('content/newtable', $arrdata, true);
				if($this->input->post("ajax")||$act=="post"){
					echo $arrdata;
				}else{
					$this->content = $data;
					$this->index();
				}
			}
		}
		
		public function gatepassBc($act, $id){
			if (!$this->session->userdata('LOGGED')){
				$this->index();
				return;
			}
			
			$id = ($id!="")?$id:$this->input->post('id');
			if($act=="gate_pass_request_detail"){
				$this->newtable->breadcrumb('Request Gate Pass', site_url());
				$this->newtable->breadcrumb('Planning', 'javascript:void(0)');
				$this->newtable->breadcrumb('Gate Pass Request ', site_url('planning/sppmp'));
				$this->newtable->breadcrumb('Gate Pass', 'javascript:void(0)');
				$data['title'] = 'Request Gate Pass';
				$data['id'] = $id;
				$this->load->model("m_requestGatePass");
				$data['arrdata'] = $this->m_requestGatePass->get_data('gate_pass_request_detail', $id);
				echo $this->content = $this->load->view('content/dokumen/gate_pass_detail',$data,true);
			}else if($act == "add_keterangan"){
				$type = 'update';
				$act = 'fl_finish';
				$arrdata = $this->m_requestGatePass->execute($type,$act, $id);
			}else if($act == "cetak"){
				$type = 'update';
				$act = 'fl_finish_print';
				$arrdata = $this->m_requestGatePass->execute($type,$act, $id);
			}else if($act == "add_paidThrough_karantina"){
				$data['id'] = $id;
				$cont = "SELECT * FROM t_request_cont WHERE ID = '".$id."'";
				$data['getCont'] = $this->db->query($cont)->result_array();
				$SQLDok = "SELECT NO_DOK,JNS_DOK FROM t_request WHERE ID = '".$id."'";
				$DOK = $this->db->query($SQLDok)->result_array();
				if($DOK[0]['JNS_DOK'] == 83){
					$SQLLic = "SELECT ID_IJIN FROM t_lic_hdr WHERE NO_IJIN = '".$DOK[0]['NO_DOK']."'";
				} else {
					$SQLLic = "SELECT ID FROM t_permit_hdr WHERE NO_DAFTAR_PABEAN = '".$DOK[0]['NO_DOK']."'";
				}
				
				$IDDOK = $this->db->query($SQLLic)->result_array();
				if($DOK[0]['JNS_DOK'] == 83){
					$data['NO_DOK'] = $IDDOK[0]['ID_IJIN'];
				}else{
					$data['NO_DOK'] = $IDDOK[0]['ID'];
				}
				echo $this->content = $this->load->view('content/dokumen/form_gatepass_karantina',$data);
			}else if($act == "paidthrought_karantina"){
				$type = 'update';
				$act = 'paidthrought_karantina';
				$iddata = $this->input->post('DATA[ID]');
				$paidthrought = $this->input->post('DATA[paidthrought]');
				$idijin = $this->input->post('DATA[ID_DOK]');
				$arrdid = $iddata.'~'.$paidthrought.'~'.$idijin;
				$arrdata = $this->m_requestGatePass->execute($type,$act, $arrdid);
			}else if($act == "updateconsigne"){
				$data['id'] = $id;
				$data['permit'] = $this->db->query("SELECT NO_DOK,TGL_DOK from t_request where id = $id")->row();
				echo $this->content = $this->load->view('content/dokumen/form_udapte_cons',$data);
			}else{
				$this->load->model("m_requestGatePass");
				$arrdata = $this->m_requestGatePass->list_reqGatePassBc($act, $id);
				$data = $this->load->view('content/newtable', $arrdata, true);
				if($this->input->post("ajax")||$act=="post"){
					echo $arrdata;
				}else{
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
		public function gatepassJoin($act, $id){
			if (!$this->session->userdata('LOGGED')){
				$this->index();
				return;
			}
			
			$id = ($id!="")?$id:$this->input->post('id');
			if($act=="gate_pass_request_detail"){
				$this->newtable->breadcrumb('Request Gate Pass', site_url());
				$this->newtable->breadcrumb('Planning', 'javascript:void(0)');
				$this->newtable->breadcrumb('Gate Pass Request ', site_url('planning/sppmp'));
				$this->newtable->breadcrumb('Gate Pass', 'javascript:void(0)');
				$data['title'] = 'Request Gate Pass';
				$data['id'] = $id;
				$this->load->model("m_requestGatePass");
				$data['arrdata'] = $this->m_requestGatePass->get_data('gate_pass_request_detailjoin', $id);
				echo $this->content = $this->load->view('content/dokumen/gate_pass_detail',$data,true);
			}else if($act == "add_keterangan"){
				$type = 'update';
				$act = 'fl_finish';
				$arrdata = $this->m_request->execute($type,$act, $id);
			}else if($act == "cetak"){
				$type = 'update';
				$act = 'fl_finish_print';
				$arrdata = $this->m_requestGatePass->execute($type,$act, $id);
			}else if($act == "add_paidThrough_karantina"){
				// $data['id'] = $id;
				// $cont = "SELECT * FROM t_request_cont WHERE ID = '".$id."'";
				// $data['getCont'] = $this->db->query($cont)->result_array();
				// $SQLDok = "SELECT NO_DOK,JNS_DOK FROM t_request WHERE ID = '".$id."'";
				// $DOK = $this->db->query($SQLDok)->result_array();
				// if($DOK[0]['JNS_DOK'] == 83){
				// 	$SQLLic = "SELECT ID_IJIN FROM t_lic_hdr WHERE NO_IJIN = '".$DOK[0]['NO_DOK']."'";
				// } else {
				// 	$SQLLic = "SELECT ID FROM t_permit_hdr WHERE NO_DAFTAR_PABEAN = '".$DOK[0]['NO_DOK']."'";
				// }
				
				// $IDDOK = $this->db->query($SQLLic)->result_array();
				// if($DOK[0]['JNS_DOK'] == 83){
				// 	$data['NO_DOK'] = $IDDOK[0]['ID_IJIN'];
				// }else{
				// 	$data['NO_DOK'] = $IDDOK[0]['ID'];
				// }
				// echo $this->content = $this->load->view('content/dokumen/form_gatepass_karantina',$data);
			}else if($act == "paidthrought_karantina"){
				// $type = 'update';
				// $act = 'paidthrought_karantina';
				// $iddata = $this->input->post('DATA[ID]');
				// $paidthrought = $this->input->post('DATA[paidthrought]');
				// $idijin = $this->input->post('DATA[ID_DOK]');
				// $arrdid = $iddata.'~'.$paidthrought.'~'.$idijin;
				// $arrdata = $this->m_requestGatePass->execute($type,$act, $arrdid);
			}else{
				$this->load->model("m_requestGatePass");
				$arrdata = $this->m_requestGatePass->list_reqGatePassJoin($act, $id);
				$data = $this->load->view('content/newtable', $arrdata, true);
				if($this->input->post("ajax")||$act=="post"){
					echo $arrdata;
				}else{
					$this->content = $data;
					$this->index();
				}
			}
		}

		function request1($act, $id){
			if (!$this->session->userdata('LOGGED')){
				$this->index();
				return;
			}
			
			$id = ($id!="")?$id:$this->input->post('id');
			if($act=="gate_pass_request_detail"){
				$this->newtable->breadcrumb('Request Gate Pass', site_url());
				$this->newtable->breadcrumb('Planning', 'javascript:void(0)');
				$this->newtable->breadcrumb('Gate Pass Request ', site_url('planning/sppmp'));
				$this->newtable->breadcrumb('Gate Pass', 'javascript:void(0)');
				$data['title'] = 'Request Gate Pass';
				$data['id'] = $id;
				$this->load->model("m_requestGatePass");
				$data['arrdata'] = $this->m_requestGatePass->get_data('gate_pass_request_detail', $id);
				echo $this->content = $this->load->view('content/dokumen/gate_pass_detail',$data,true);
			}else if($act == "add_keterangan"){
				$type = 'update';
				$act = 'fl_finish';
				$arrdata = $this->m_requestGatePass->execute($type,$act, $id);
			}else if($act == "cetak"){
				$type = 'update';
				$act = 'fl_finish_print';
				$arrdata = $this->m_requestGatePass->execute($type,$act, $id);
			}else if($act == "add_paidThrough"){
				$data['id'] = $id;
				
				$cont = "SELECT * FROM t_request_cont WHERE ID = '".$id."'";
				$data['getCont'] = $this->db->query($cont)->result_array();
				 $this->load->view('content/dokumen/form_paidthrought',$data);			
			}else if($act == "paidthrought"){
				$type = 'update';
				$act = 'paidthrought';
				$iddata = $this->input->post('DATA[ID]');
				$paidthrought = $this->input->post('DATA[paidthrought]');
				$arrdid = $iddata.'~'.$paidthrought;
				$arrdata = $this->m_requestGatePass->execute($type,$act, $arrdid);
				//echo $this->content = $this->load->view('content/dokumen/form_paidthrought',$data);
			}else{
				$this->load->model("m_requestGatePass");
				$arrdata = $this->m_requestGatePass->list_reqGatePassBc($act, $id);
				$data = $this->load->view('content/newtable', $arrdata, true);
				if($this->input->post("ajax")||$act=="post"){
					echo $arrdata;
				}else{
					return $data;
				}
			}
		}
			
		function request2($act, $id){
			if (!$this->session->userdata('LOGGED')){
				$this->index();
				return;
			}
			$id = ($id!="")?$id:$this->input->post('id');
			if($act=="gate_pass_request_detail"){
				$this->newtable->breadcrumb('Request Gate Pass', site_url());
				$this->newtable->breadcrumb('Planning', 'javascript:void(0)');
				$this->newtable->breadcrumb('Gate Pass Request ', site_url('planning/sppmp'));
				$this->newtable->breadcrumb('Gate Pass', 'javascript:void(0)');
				$data['title'] = 'Request Gate Pass';
				$data['id'] = $id;
				$this->load->model("m_requestGatePass");
				$data['arrdata'] = $this->m_requestGatePass->get_data('gate_pass_request_detail', $id);
				echo $this->content = $this->load->view('content/dokumen/gate_pass_detail',$data,true);
			}else if($act == "add_keterangan"){
				$type = 'update';
				$act = 'fl_finish';
				$arrdata = $this->m_requestGatePass->execute($type,$act, $id);
			}else if($act == "cetak"){
				$type = 'update';
				$act = 'fl_finish_print';
				$arrdata = $this->m_requestGatePass->execute($type,$act, $id);
			}else if($act == "add_paidThrough"){
				$data['id'] = $id;
				$cont = "SELECT * FROM t_request_cont WHERE ID = '".$id."'";
				$data['getCont'] = $this->db->query($cont)->result_array();
				 $this->content = $this->load->view('content/dokumen/form_paidthrought',$data,true);
			}else if($act == "paidthrought"){
				$type = 'update';
				$act = 'paidthrought';
				$iddata = $this->input->post('DATA[ID]');
				$paidthrought = $this->input->post('DATA[paidthrought]');
				$arrdid = $iddata.'~'.$paidthrought;
				$arrdata = $this->m_requestGatePass->execute($type,$act, $arrdid);
				//echo $this->content = $this->load->view('content/dokumen/form_paidthrought',$data);
			}else{
				$this->load->model("m_requestGatePass");
				$arrdata = $this->m_requestGatePass->list_reqGatePassKarantina($act, $id);
				$data = $this->load->view('content/newtable', $arrdata, true);
				if($this->input->post("ajax")||$act=="post"){
					return $arrdata;
				}else{
					return $data;
				}
			}
		}

		function ondemand($act, $id){
			if (!$this->session->userdata('LOGGED')){
				$this->index();
				return;
			}
			$id = ($id!="")?$id:$this->input->post('id');
			if ($act=="ondimine_gatepass") {
				$type = 'update';
				$act = 'ondimine_gatepass';
				$this->load->model("m_requestGatePass");
				$data['arrdata'] = $this->m_requestGatePass->execute($type, $act, $id);
			} else {
				$this->load->model("m_requestGatePass");
				$arrdata = $this->m_requestGatePass->list_gatepassondemand($act, $id);
				$data = $this->load->view('content/newtable', $arrdata, true);
				if($this->input->post("ajax")||$act=="post"){
					return $arrdata;
				}else{
					$this->content = $data;
					$this->index();
				}
			}
		}

		function ondemand_api($act, $id){
			if (!$this->session->userdata('LOGGED')){
				$this->index();
				return;
			}
			$id = ($id!="")?$id:$this->input->post('id');
			if ($act=="ondimine_gatepass_api") {
				$type = 'update';
				$act = 'ondimine_gatepass_api';
				$this->load->model("m_requestGatePass");
				$data['arrdata'] = $this->m_requestGatePass->execute($type, $act, $id);
			} else {
				$this->load->model("m_requestGatePass");
				$arrdata = $this->m_requestGatePass->list_gatepassondemand_api($act, $id);
				$data = $this->load->view('content/newtable', $arrdata, true);
				if($this->input->post("ajax")||$act=="post"){
					return $arrdata;
				}else{
					$this->content = $data;
					$this->index();
				}
			}
		}
		
		public function request($type="", $act="", $id="", $met=""){
			if (!$this->session->userdata('LOGGED')){
				$this->index();
				return;
			}
			$id = ($id!="")?$id:$this->input->post('id');
			$this->load->model('m_requestGatePass');
			$this->m_requestGatePass->execute($type, $act, $id);
		}
	   
		function proces($type="",$act="", $id=""){
			if (!$this->session->userdata('LOGGED')) {
				$this->index();
				return;
			}else{
				if (strtolower($_SERVER['REQUEST_METHOD']) != "post") {
					$this->load->model("m_requestGatePass");
					$this->m_requestGatePass->process($type,$act,$id);
				}else{
					$this->load->model("m_requestGatePass");
					$this->m_requestGatePass->process($type,$act,$id);
				}
			}
		}
	}
?>