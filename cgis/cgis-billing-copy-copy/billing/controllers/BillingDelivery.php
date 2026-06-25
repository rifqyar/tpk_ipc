<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class BillingDelivery extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model("m_billing_delivery");
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

	public function delivery($act, $id){
		if (!$this->session->userdata('LOGGED')){
			$this->index();
			return;
		}
		$id = ($id!="")?$id:$this->input->post('id');

		$arrdata = $this->m_billing_delivery->delivery($act, $id);
		$data = $this->load->view('content/newtable', $arrdata, true);
		if($this->input->post("ajax")||$act=="post"){
			return $arrdata;
		}else{
			$this->content = $data;
			$this->index();
		}
	}

	public function delivery_add($act, $id){
		if (!$this->session->userdata('LOGGED')){
			$this->index();
			return;
		}
		$id = ($id!="")?$id:$this->input->post('id');

		$data['title'] = 'DOKUMEN SPPB';
		$data['id'] = $id;
		$data['detail'] = $this->detail_sppb($act,$id);
		echo $this->load->view('content/newtable',$data,true);
	}

	public function detail_sppb($act, $id){
		if (!$this->session->userdata('LOGGED')){
			$this->index();
			return;
		}
		$id = ($id!="")?$id:$this->input->post('id');

		$arrdata = $this->m_billing_delivery->delivery_add($act, $id);
		$data = $this->load->view('content/newtable', $arrdata, true);
		if($this->input->post("ajax")||$act=="post"){
			echo $arrdata;
		}else{
			return $data;
		}
	}

	public function save_delivery($act, $id){
		if (!$this->session->userdata('LOGGED')){
			$this->index();
			return;
		}
		$id = ($id!="")?$id:$this->input->post('id');
		$data['id'] = $id;
		$data['action'] = "save";
		$data['title'] = 'BILLING DELIVERY';
		$data['arrdata'] = $this->m_billing_delivery->get_data_sppb($id);
		$data['arrdatacont'] = $this->m_billing_delivery->get_data_detail_sppb($id);
		$this->load->view('content/billing/delivery/form_add', $data);
	}

	public function cetak_nota_del($act, $id) {
        if (!$this->session->userdata('LOGGED')) {
            $this->index();
            return;
        }
        $arrid = explode('~',$this->input->post('id'));
		$id = $arrid[0];

		$this->load->library('mpdf');
		$this->load->model("m_execute");
		$sess = $this->session->userdata('NM_LENGKAP');
		$data['title'] = "".$sess; 
		$this->m_billing_delivery->history_delivery($id);
		$data['result'] = $this->m_billing_delivery->get_nota_del($id);
		$data['result_hdr'] = $this->m_billing_delivery->get_nota_del_hdr($id);
		$data['result_cust'] = $this->m_billing_delivery->get_nota_cust($id);
		$data['result_cont'] = $this->m_billing_delivery->get_nota_cont($id);
		$this->load->view('content/billing/delivery/simulasi', $data);
    }

    public function delivery_confirm($act, $id){
    	if (!$this->session->userdata('LOGGED')) {
            $this->index();
            return;
        }
        $id = ($id!="")?$id:$this->input->post('id');
        $data['id'] = $id;
		$data['title'] = 'REKENING BANK';
		$data['bank'] = $this->m_billing_delivery->get_data_bank();
		echo $this->content = $this->load->view('content/billing/delivery/confirm',$data,true);
    }

	public function process($act="", $id=""){
		$id = ($id!="")?$id:$this->input->post('id');
		if (!$this->session->userdata('LOGGED')) {
			$this->index();
			return;
		}else{
			if (strtolower($_SERVER['REQUEST_METHOD']) != "post") {
				echo 'access is forbidden'; exit();
			}else{
				$this->m_billing_delivery->process($act,$id);
			}
		}
	}

	public function confirm_delivery($act="", $id=""){
		$id = ($id!="")?$id:$this->input->post('id');
		if (!$this->session->userdata('LOGGED')) {
			$this->index();
			return;
		}else{
			if (strtolower($_SERVER['REQUEST_METHOD']) != "post") {
				echo 'access is forbidden'; exit();
			}else{
				$this->m_billing_delivery->confirm_delivery($act,$id);
			}
		}
	}

	public function delivery_history($act, $id){
		if (!$this->session->userdata('LOGGED')) {
            $this->index();
            return;
        } 
        $arrid = explode('~',$this->input->post('id'));
		$id = $arrid[0];
		$data['arrdata'] = $this->m_billing_delivery->get_history_delivery($id);

		echo $this->load->view('content/dokumen/history_cetak',$data,true);
	}

	public function delivery_del($act, $id){
		if (!$this->session->userdata('LOGGED')){
			$this->index();
			return;
		}
		$arrpost = $this->input->post('tb_chktbldelivery');
		$exparrpost = explode('~',$arrpost[0]); 
		$id_req = $exparrpost[0];
		$no_dok = $exparrpost[1];
		$no_nota = $exparrpost[2];
		$key = $id_req."~".$no_dok."~".$no_nota;
		$this->m_billing_delivery->del_delivery($key);
	}

	public function delivery_update($act, $id){
		if (!$this->session->userdata('LOGGED')){
			$this->index();
			return;
		}

		$arrid = explode("~", $this->input->post('id'));
		$id = $arrid[0];
		$data['title'] = "UPDATE BILLING DELIVERY";
		$data['id'] = $id;
		$data['action'] = "update";
		$this->load->model("m_execute");
		$data['arrdata'] = $this->m_execute->get_data_dokumen('delivery', $id);
		$data['detail_cont'] = $this->m_execute->get_data_dokumen('delivery_dtl', $id);
		
		$this->load->view('content/billing/delivery/delivery', $data);
	}

	public function delivery_resend($id){
		if (!$this->session->userdata('LOGGED')){
			$this->index();
			return;
		}
		foreach ($this->input->post('tb_chktbldelivery') as $CheckArr) {
			$ArrCheck 	= explode("~", $CheckArr);
			print_r($ArrCheck);
			$IdReq 		= $ArrCheck[0];
			$FlTrans	= $ArrCheck[3];
			$FlReceipt	= $ArrCheck[4];
		
			$this->m_billing_delivery->resend_delivery($IdReq, $FlTrans, $FlReceipt);
		}
	}
}

/* End of file BillingDelivery.php */
/* Location: ./application/controllers/BillingDelivery.php */