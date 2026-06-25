<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
	public $content;
	public function __construct() {
        parent::__construct();
    }
	
	public function index(){
		$headers  = '<link rel="apple-touch-icon" href="'.base_url().'assets/images/apple-touch-icon.png">';
		$headers .= '<link rel="shortcut icon" href="'.base_url().'assets/images/favicon.ico">';
		#Stylesheets
		$headers .= '<link rel="stylesheet" href="'.base_url().'assets/css/bootstrap.min.css?v2.1.0">';
		$headers .= '<link rel="stylesheet" href="'.base_url().'assets/css/bootstrap-extend.min.css?v2.1.0">';
		$headers .= '<link rel="stylesheet" href="'.base_url().'assets/css/site.min.css?v2.1.0">';
		$headers .= '<link rel="stylesheet" href="'.base_url().'assets/css/slide-unlock.css">';
		$headers .= '<link rel="stylesheet" href="'.base_url().'assets/css/captche.css">';
        #Plugins
        $headers .= '<link rel="stylesheet" href="'.base_url().'assets/vendor/animsition/animsition.min.css?v2.1.0">';
       	$headers .= '<link rel="stylesheet" href="'.base_url().'assets/vendor/asscrollable/asScrollable.min.css?v2.1.0">';
        $headers .= '<link rel="stylesheet" href="'.base_url().'assets/vendor/switchery/switchery.min.css?v2.1.0">';
        $headers .= '<link rel="stylesheet" href="'.base_url().'assets/vendor/intro-js/introjs.min.css?v2.1.0">';
        $headers .= '<link rel="stylesheet" href="'.base_url().'assets/vendor/slidepanel/slidePanel.min.css?v2.1.0">';
        $headers .= '<link rel="stylesheet" href="'.base_url().'assets/vendor/flag-icon-css/flag-icon.min.css?v2.1.0">';
        $headers .= '<link rel="stylesheet" href="'.base_url().'assets/vendor/waves/waves.min.css?v2.1.0">';
		$headers .= '<link rel="stylesheet" href="'.base_url().'assets/vendor/sweetalert/sweetalert.css">';
		$headers .= '<link rel="stylesheet" href="'.base_url().'assets/vendor/themes/twitter.css">';
      	#Page
        $headers .= '<link rel="stylesheet" href="'.base_url().'assets/vendor/pages/login.min.css?v2.1.0">';
        #Fonts
        $headers .= '<link rel="stylesheet" href="'.base_url().'assets/fonts/material-design/material-design.min.css?v2.1.0">';
        $headers .= '<link rel="stylesheet" href="'.base_url().'assets/fonts/brand-icons/brand-icons.min.css?v2.1.0">';
        $headers .= '<link rel="stylesheet" href="'.base_url().'assets/fonts/font.css?v2.1.0">';
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
        $footers .= '<script src="'.base_url().'assets/js/sections/menu.min.js"></script>';
        $footers .= '<script src="'.base_url().'assets/js/sections/menubar.min.js"></script>';
        $footers .= '<script src="'.base_url().'assets/js/sections/gridmenu.min.js"></script>';
        $footers .= '<script src="'.base_url().'assets/js/sections/sidebar.min.js"></script>';
		$footers .= '<script src="'.base_url().'assets/js/configs/config-colors.min.js"></script>';
        $footers .= '<script src="'.base_url().'assets/js/configs/config-tour.min.js"></script>';
        $footers .= '<script src="'.base_url().'assets/js/components/asscrollable.min.js"></script>';
        $footers .= '<script src="'.base_url().'assets/js/components/animsition.min.js"></script>';
        $footers .= '<script src="'.base_url().'assets/js/components/slidepanel.min.js"></script>';
        $footers .= '<script src="'.base_url().'assets/js/components/switchery.min.js"></script>';
        $footers .= '<script src="'.base_url().'assets/js/components/tabs.min.js"></script>';
        $footers .= '<script src="'.base_url().'assets/js/components/jquery-placeholder.min.js"></script>';
        $footers .= '<script src="'.base_url().'assets/js/components/material.min.js"></script>';
		$footers .= '<script src="'.base_url().'assets/vendor/sweetalert/sweetalert.min.js"></script>';
		$footers .= '<script src="'.base_url().'assets/js/main.js"></script>';
		$footers .= '<script src="'.base_url().'assets/js/jquery.slideunlock.js"></script>';
		if($this->content==""){
			$data['chaptca'] = $this->get_chaptca(4);
			$this->content = $this->load->view('content/home/index',$data,true);	
		}
		$data = array('_title_' => 'BOS',
					  '_headers_' => $headers,
					  '_footers_' => $footers,
					  '_content_' => $this->content);
		$this->parser->parse('index', $data);	
	}
	
	private function get_chaptca($param){ // method pembuat chapta
		$alphabet   = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
		$num        = range(0, 35);
		$result     = '';
		shuffle($num);
		for ($x = 0; $x < $param; $x++){
			$result .= substr($alphabet, $num[$x], 1);
		}
			return $result;
    }
	
	function usehandheld(){
		redirect(base_url('handheld.php'));		
	}

	function signin(){
		$arrayReturn = array();
		$returnData = "";
		if(strtolower($_SERVER['REQUEST_METHOD'])!="post"){
			$returnData = "0|Login failed, please refresh page";
		}
		else{
			$uid = $this->input->post('username');
			$pwd = $this->input->post('password');
			$code = $this->input->post('code');
			$unlock = $this->input->post('unlock');
			//if(strtolower($code)===$_SESSION['captkodex'])
			//if(strtolower('erik')==='erik'){
			//if($unlock == 0){ #def $unlock == 1
			if(strtolower($this->input->post('txt_chaptca_real')) == strtolower($this->input->post('txt_chaptca'))){
				$this->load->model('m_home');
				$result = $this->m_home->signin($uid, md5($pwd));
				if($result > 0){
					if($result==2){
						$returnData = "1|Login success, Please change your password|".$this->get_next_link($result);
					}else{
						$returnData = "1|Login success|".$this->get_next_link($result);
					}
				}else{ 
					$returnData = "0|Wrong username or password";
				}
			}
			else
			{
				$returnData = "0|Wrong capctha code";
			}			
		}
		$arrayReturn['returnData'] = $returnData;
		echo json_encode($arrayReturn);
	}

	function signinportal(){
        $uid = $this->input->post('username');
		$pwd = $this->input->post('password');

		$this->load->model('m_home');
		$result = $this->m_home->signin($uid, md5($pwd));
		if($result > 0){
			if($result==2){
				$this->password();
			}else{
				redirect('../billing.php','refresh');
			}
		}
	}
	
	function password(){
		if($this->session->userdata('USERLOGIN')!=""){
			$this->content = $this->load->view('content/home/password','',true);
			$this->index();
		}else{
			redirect(base_url('index.php'));		
		}
	}
	
	function execute($type="",$act=""){
		if ($this->session->userdata('USERLOGIN')==""){
			$this->index();
			return;
		}else{
			if (strtolower($_SERVER['REQUEST_METHOD']) != "post") {
				redirect(base_url());
				exit();
			}else{
				$this->load->model("m_home");
				$this->m_home->execute($type,$act);
			}
		}
	}
	
	function get_next_link($result){
		if($result==1){
			$returnLink = base_url()."billing.php";
		}else if($result==2){
			$returnLink = site_url()."/home/password";
		}
		return $returnLink;
	}
	
	function signout(){
		$this->session->sess_destroy();
			redirect(base_url());	
	}
}
