<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
	public $content;
	public function __construct() {
        parent::__construct();
		$this->load->model('M_home');
    }
	
	public function index(){
		$headers  = '<link rel="apple-touch-icon" href="'.base_url().'assets/images/apple-touch-icon.png">';
		$headers .= '<link rel="shortcut icon" href="'.base_url().'assets/images/favicon.ico">';
		#Stylesheets
		$headers .= '<link rel="stylesheet" href="'.base_url().'assets/css/bootstrap.min.css?v2.1.0">';
		$headers .= '<link rel="stylesheet" href="'.base_url().'assets/css/bootstrap-extend.min.css?v2.1.0">';
		$headers .= '<link rel="stylesheet" href="'.base_url().'assets/css/site.min.css?v2.1.0">';
		$headers .= '<link rel="stylesheet" href="'.base_url().'assets/css/slide-unlock.css">';
		$headers .= '<link rel="stylesheet" href="'.base_url().'assets/css/login_handheld.css">';
        #Plugins
        $headers .= '<link rel="stylesheet" href="'.base_url().'assets/vendor/animsition/animsition.min.css?v2.1.0">';
       	$headers .= '<link rel="stylesheet" href="'.base_url().'assets/vendor/asscrollable/asScrollable.min.css?v2.1.0">';
        $headers .= '<link rel="stylesheet" href="'.base_url().'assets/vendor/switchery/switchery.min.css?v2.1.0">';
        $headers .= '<link rel="stylesheet" href="'.base_url().'assets/vendor/intro-js/introjs.min.css?v2.1.0">';
        $headers .= '<link rel="stylesheet" href="'.base_url().'assets/vendor/slidepanel/slidePanel.min.css?v2.1.0">';
        $headers .= '<link rel="stylesheet" href="'.base_url().'assets/vendor/flag-icon-css/flag-icon.min.css?v2.1.0">';
        $headers .= '<link rel="stylesheet" href="'.base_url().'assets/vendor/waves/waves.min.css?v2.1.0">';
		$headers .= '<link rel="stylesheet" href="'.base_url().'assets/vendor/sweetalert/sweetalert.css">';
		//$headers .= '<link rel="stylesheet" href="'.base_url().'assets/vendor/themes/twitter.css">';
      	#Page
        //$headers .= '<link rel="stylesheet" href="'.base_url().'assets/vendor/pages/login.min.css?v2.1.0">';
        #Fonts
        //$headers .= '<link rel="stylesheet" href="'.base_url().'assets/fonts/material-design/material-design.min.css?v2.1.0">';
        //$headers .= '<link rel="stylesheet" href="'.base_url().'assets/fonts/brand-icons/brand-icons.min.css?v2.1.0">';
        //$headers .= '<link rel="stylesheet" href="'.base_url().'assets/fonts/font.css?v2.1.0">';
        #Scripts
        $headers .= '<script src="'.base_url().'assets/vendor/modernizr/modernizr.min.js"></script>';
        $headers .= '<script src="'.base_url().'assets/vendor/breakpoints/breakpoints.min.js"></script>';
        $headers .= '<script>Breakpoints();</script>';
		#Core
		$footers  = '<script src="'.base_url().'assets/vendor/jquery/jquery.min.js"></script>';
		$footers .= '<script src="'.base_url().'assets/vendor/bootstrap/bootstrap.min.js"></script>';
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
		$footers .= '<script src="'.base_url().'assets/vendor/alertify-js/alertify.js"></script>';
		#Plugins For This Page
		$footers .= '<script src="'.base_url().'assets/vendor/jquery-placeholder/jquery.placeholder.min.js"></script>';
		#Scripts
		$footers .= '<script src="'.base_url().'assets/js/core.min.js"></script>';
		$footers .= '<script src="'.base_url().'assets/js/site.min.js"></script>';
        //$footers .= '<script src="'.base_url().'assets/js/sections/menu.min.js"></script>';
        //$footers .= '<script src="'.base_url().'assets/js/sections/menubar.min.js"></script>';
        //$footers .= '<script src="'.base_url().'assets/js/sections/gridmenu.min.js"></script>';
        //$footers .= '<script src="'.base_url().'assets/js/sections/sidebar.min.js"></script>';
		//$footers .= '<script src="'.base_url().'assets/js/configs/config-colors.min.js"></script>';
        //$footers .= '<script src="'.base_url().'assets/js/configs/config-tour.min.js"></script>';
        //$footers .= '<script src="'.base_url().'assets/js/components/asscrollable.min.js"></script>';
        //$footers .= '<script src="'.base_url().'assets/js/components/animsition.min.js"></script>';
        //$footers .= '<script src="'.base_url().'assets/js/components/slidepanel.min.js"></script>';
        $footers .= '<script src="'.base_url().'assets/js/components/switchery.min.js"></script>';
        //$footers .= '<script src="'.base_url().'assets/js/components/tabs.min.js"></script>';
        //$footers .= '<script src="'.base_url().'assets/js/components/jquery-placeholder.min.js"></script>';
        //$footers .= '<script src="'.base_url().'assets/js/components/material.min.js"></script>';
		$footers .= '<script src="'.base_url().'assets/vendor/sweetalert/sweetalert.min.js"></script>';
		$footers .= '<script src="'.base_url().'assets/js/main.js"></script>';
		$footers .= '<script src="'.base_url().'assets/js/jquery.slideunlock.js"></script>';
		if($this->session->userdata('LOGGED')){
			redirect(base_url().'handheld.php/operation');
		}else{
			if($this->content==""){
				$this->content = $this->load->view('content/home/index','',true);	
			}
			$data = array('_title_' => 'BOS',
						  '_headers_' => $headers,
						  '_footers_' => $footers,
						  '_content_' => $this->content);
			$this->parser->parse('index', $data);	
		}
		
	}
	
	function signin(){
			$this->load->model('m_home');
			$uid = $this->input->post('username');
			$pwd = $this->input->post('password');
			$cek2=$this->m_home->ambil_data2($uid, md5($pwd));			
				$data=array(
					'LOGGED'=>True,
					'USERLOGIN'=>$uid,
					'KD_GROUP'=>$cek2[KD_GROUP],
					'PASS'=>$pwd
				);
				
				$data2=array(
					'LOGGED'=>False,
					'USERLOGIN'=>$uid,
					'PASS'=>$pwd
				);
			$cek=$this->m_home->ambil_data($uid, md5($pwd));
				if($cek == 1) { // Berfungsi untuk mengecek kebenaran data login yang diinput (1 = true)
					// Berfungsi untuk menyimpan user data
					//echo"berhasil";die();
					if ($cek2[KD_GROUP] == 'GRH') {
						$sesi=$this->session->set_userdata($data2);
						redirect(base_url('handheld.php'));
					}else if ($cek2[KD_GROUP] == 'ADM' && $cek2[USER_NAME] == 'SOLVERBOS') {
						$sesi=$this->session->set_userdata($data);
						redirect(base_url('handheld.php/Solverhandheld'));
					} else {
						$sesi=$this->session->set_userdata($data);
						redirect(base_url('handheld.php/operation/opr'));
					}
					// Jika data yang dimasukkan valid maka akan redirect ke halaman Dashboard
				}else{ // Jika data yang diinput tidak valid maka akan dialihkan ke view login gagal
					//echo"gagal";die();
					$sesi=$this->session->set_userdata($data2);
					redirect(base_url('handheld.php'));
				}
	}
		
	function signout(){
		$this->session->sess_destroy();
			redirect(base_url('handheld.php'));	
	}

	function homelogin(){
		redirect(base_url('index.php'));		
	}

	
}
