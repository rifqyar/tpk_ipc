<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Management extends CI_Controller {
	
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
        $headers .= '<script>Breakpoints();</script>';
		#Core		
		$footers  = '<script src="'.base_url().'assets/vendor/jquery/jquery.min.js"></script>';
		$footers .= '<script src="'.base_url().'assets/vendor/jquery-ui/jquery-ui.min.js"></script>';
		$footers .= '<script src="'.base_url().'assets/vendor/bootstrap/bootstrap.min.js"></script>';
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
	
    function execute($type="", $act="", $id="", $met="") {
        if (!$this->session->userdata('LOGGED')) {
            $this->index();
            return;
        } else {
            if (strtolower($_SERVER['REQUEST_METHOD']) != "post") {
                redirect(base_url());
                exit();
            } else {
                $this->load->model("m_management");
                $this->m_management->execute($type, $act, $id, $met);
            }
        }
    }
	
	function user($act="", $id="") {
        if (!$this->session->userdata('LOGGED')) {
            $this->index();
            return;
        }
		$id = ($id!="")?$id:$this->input->post('id');
        $this->load->model('m_management');
        if ($act == "add") {
			$data['title'] = 'ENTRY USER';
			 $data['id'] = '';
            $data['act'] = 'save';
            $data['arr_group'] = $this->m_management->get_combobox('group');
            echo $this->load->view('content/management/user', $data, true);
        } else if ($act == "edit") {
			$data['title'] = 'UPDATE USER';
            $data['id'] = $id;
			$data['act'] = 'update';
            $data['arr_group'] = $this->m_management->get_combobox('group');
            $data['arrdata'] = $this->m_management->get_data('user', $id);
            echo $this->load->view('content/management/user', $data, true);
        } else {
            $arrdata = $this->m_management->user($act, $id);
            $data = $this->load->view('content/newtable', $arrdata, true);
            if ($this->input->post("ajax") || $act == "post") {
                echo $arrdata;
            } else {
                $this->content = $data;
                $this->index();
            }
        }
    }
	
	function privilege($act="", $id="") {
        if (!$this->session->userdata('LOGGED')) {
            $this->index();
            return;
        }
		$id = ($id!="")?$id:$this->input->post('id');
        $this->load->model('m_management');
        if ($act == "add") {
			$data['title'] = 'ENTRY PRIVILEGE';
            $data['action'] = 'save';
			$data['menus'] = $this->m_management->get_data('access_menu');
            echo $this->load->view('content/management/privilege', $data, true);
        } else if ($act == "edit") {
			$data['title'] = 'UPDATE PRIVILEGE';
            $data['action'] = 'update';
			$data['arrdata'] = $this->m_management->get_data('user_profile', $id);
            $data['menus'] = $this->m_management->get_data('access_menu', $id);
            echo $this->load->view('content/management/privilege', $data, true);
        } else {
            $arrdata = $this->m_management->privilege($act, $id);
            $data = $this->load->view('content/newtable', $arrdata, true);
            if ($this->input->post("ajax") || $act == "post") {
                echo $arrdata;
            } else {
                $this->content = $data;
                $this->index();
            }
        }
    }
	
    function group($act="", $id="") {
        if (!$this->session->userdata('LOGGED')) {
            $this->index();
            return;
        }
        $this->load->model('m_management');
        if ($act == "add") {
            $data['act'] = 'save';
            echo $this->load->view('content/management/group', $data, true);
        } else if ($act == "edit") {
            $arrid = explode("~", $id);
            $data['act'] = 'update';
            $data['arrhdr'] = $this->m_management->get_data('group', $id);
            echo $this->load->view('content/management/group', $data, true);
        } else {
            $arrdata = $this->m_management->group($act, $id);
            $data = $this->load->view('content/newtable', $arrdata, true);
            if ($this->input->post("ajax") || $act == "post") {
                echo $arrdata;
            } else {
                $this->content = $data;
                $this->index();
            }
        }
    }

    function menu($act="", $id="") {
        if (!$this->session->userdata('LOGGED')) {
            $this->index();
            return;
        }
        $this->load->model('m_management');
        if ($act == "add") {
            $data['act'] = 'save';
            $data['arr_parent'] = $this->m_management->get_combobox('parent');
            echo $this->load->view('content/management/menu', $data, true);
        } else if ($act == "edit") {
            $data['act'] = 'update';
            $data['ID'] = $id;
            $data['arrhdr'] = $this->m_management->get_data('menu', $id);
            $data['arr_parent'] = $this->m_management->get_combobox('parent');
            echo $this->load->view('content/management/menu', $data, true);
        } else {
            $arrdata = $this->m_management->menu($act, $id);
            $data = $this->load->view('content/newtable', $arrdata, true);
            if ($this->input->post("ajax") || $act == "post") {
                echo $arrdata;
            } else {
                $this->content = $data;
                $this->index();
            }
        }
    }
	
	function organisasi($act="", $id="") {
        if (!$this->session->userdata('LOGGED')) {
            $this->index();
            return;
        }
        $this->load->model('m_management');
        if ($act == "add") {
            $data['act'] = 'save';
            $data['arr_tipe'] = $this->m_management->get_combobox('tipe');
            echo $this->load->view('content/management/organisasi', $data, true);
        } else if ($act == "edit") {
            $arrid = explode("~", $id);
            $data['ID'] = $id;
            $data['act'] = 'update';
            $data['arr_tipe'] = $this->m_management->get_combobox('tipe');
            $data['arrhdr'] = $this->m_management->get_data('organisasi', $id);
            echo $this->load->view('content/management/organisasi', $data, true);
        } else {
            $arrdata = $this->m_management->organisasi($act, $id);
            $data = $this->load->view('content/newtable', $arrdata, true);
            if ($this->input->post("ajax") || $act == "post") {
                echo $arrdata;
            } else {
                $this->content = $data;
                $this->index();
            }
        }
    }

    function password($act, $id) {
        if (!$this->session->userdata('LOGGED')) {
            $this->index();
            return;
        }
        $this->newtable->breadcrumb('Home', site_url());
        $this->newtable->breadcrumb('User Management', 'javascript:void(0)');
        $this->newtable->breadcrumb('Edit Password', 'javascript:void(0)');
        $this->content = $this->load->view('content/management/password', '', true);
        $this->index();
    }

    function user_profile($act, $id) {
        if (!$this->session->userdata('LOGGED')) {
            $this->index();
            return;
        }
        $this->load->model('m_management');
        $ID_USR = $this->session->userdata('ID');
        $ID_ORG = $this->session->userdata('KD_ORGANISASI');
        $this->newtable->breadcrumb('Home', site_url());
        $this->newtable->breadcrumb('User Management', 'javascript:void(0)');
        $this->newtable->breadcrumb('Edit Profile', 'javascript:void(0)');
        $data['arr_org'] = $this->m_management->get_data('profile', $ID_ORG);
        $data['arr_usr'] = $this->m_management->get_data('user_profile', $ID_USR);
        $this->content = $this->load->view('content/management/user_profile', $data, true);
        $this->index();
    }

    function log_activity($act="", $id="") {
        if (!$this->session->userdata('LOGGED')) {
            $this->index();
            return;
        }
        $this->load->model('m_management');
        $arrdata = $this->m_management->log_activity($act, $id);
        $data = $this->load->view('content/newtable', $arrdata, true);
        if ($this->input->post("ajax") || $act == "post") {
            echo $arrdata;
        } else {
            $this->content = $data;
            $this->index();
        }
    }

}