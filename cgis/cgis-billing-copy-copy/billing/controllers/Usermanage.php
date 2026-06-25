<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Usermanage extends CI_Controller {
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
                $this->load->view('content/error');
            }
            $data = array('_title_'       => 'BOS',
                          '_headers_'     => $headers,
                          '_header_'      => $this->load->view('content/header','',true),
                          '_menus_'       => $this->load->view('content/menus','',true),
                          '_breadcrumbs_' => $this->load->view('content/breadcrumbs','',true),
                          '_content_'     => (grant()=="")?$this->load->view('content/error','',true):$this->content,
                          '_footers_'     => $footers,
                          '_footer_'      => $this->load->view('content/menus','',true));
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
                $this->load->model("m_userm");
                $this->m_userm->execute($type, $act, $id, $met);
            }
        }
    }
	
  //   public function user($act,$id){
  //       if (!$this->session->userdata('LOGGED')){
  //           $this->index();
  //           return;
  //       }
  //       $id = ($id!="")?$id:$this->input->post('id');
		// $this->load->model('m_management');
  //       if($act=="add"){
  //           /*echo "string";die();*/
  //           $data['title'] = 'ENTRY USER';
  //           $data['id'] = '';
  //           $data['action'] = 'save';
		// 	$data['arr_group'] = $this->m_management->get_combobox('group_user');
  //           echo $this->load->view('content/privilege/user_add',$data,true);
  //       }else if($act=="update"){
  //           $data['title'] = 'UPDATE USER';
  //           $data['id'] = $id;
  //           $data['action'] = 'update';
  //           $this->load->model("m_execute");
  //           $data['arrdata'] = $this->m_execute->get_data('user', $id);
		// 	$data['arr_group'] = $this->m_management->get_combobox('group_user');
  //           echo $this->load->view('content/privilege/user_add',$data,true);
  //       }else if($act=="delete"){
  //           // $data['title'] = 'DELETE KAPAL';
  //           // $data['id'] = $id;
  //           // $data['action'] = 'delete';
  //           // $this->load->model("m_execute");
  //           // $data['arrdata'] = $this->m_execute->get_data('mail', $id);
  //           // echo $this->load->view('content/reference/mail_add',$data,true);
  //       }else{
  //           $this->load->model("m_userm");
  //           $arrdata = $this->m_userm->user($act, $id);
  //           $data = $this->load->view('content/newtable', $arrdata, true);
  //           if($this->input->post("ajax")||$act=="post"){
  //               echo $arrdata;
  //           }else{
  //               $this->content = $data;
  //               $this->index();
  //           }
  //       }
  //   }

    public function user($act,$id){
		$this->load->view('content/error',$this->index());
	}

    // public function privil($act="",$id=""){
    //         if (!$this->session->userdata('LOGGED')){
    //             $this->index();
    //             return;
    //         }
    //         $id = ($id!="")?$id:$this->input->post('id');
    //         if($act=="add"){//print_r($id);die();
				// $data['title'] = 'ENTRY PRIVILEGE';
				// $data['action'] = 'save';
				// $this->load->model("m_userm");
				// $data['menus'] = $this->m_userm->get_data('access_menu');
				// echo $this->load->view('content/privilege/privilege_add', $data, true);
                
    //         }else if($act=="update"){
    //             $data['title'] = 'UPDATE PRIVILEGE';
				// $data['action'] = 'update';
				// $this->load->model("m_userm");
				// $data['arrdata'] = $this->m_userm->get_data('group', $id);
				// $data['menus'] = $this->m_userm->get_data('access_menu', $id);
				// echo $this->load->view('content/privilege/privilege_add', $data, true);
                
    //         }else{
    //             $this->load->model("m_userm");
    //             $arrdata = $this->m_userm->privil($act, $id);
    //             $data = $this->load->view('content/newtable', $arrdata, true);
    //                 if($this->input->post("ajax")||$act=="post"){
    //                     echo $arrdata;
    //                 }else{
    //                     $this->content = $data;
    //                     $this->index();
    //                 }
    //         }
    // }

    public function privil($act,$id){
		$this->load->view('content/error',$this->index());
	}

    // public function group($act="",$id=""){
    //         if (!$this->session->userdata('LOGGED')){
    //             $this->index();
    //             return;
    //         }
    //         $id = ($id!="")?$id:$this->input->post('id');
    //         if($act=="add"){//print_r($id);die();
    //             $data['title'] = 'ENTRY GROUP';
    //             $data['action'] = 'save';
    //             $this->load->model("m_userm");
    //             echo $this->load->view('content/group/group_add', $data, true);
                
    //         }else if($act=="update"){
    //             $data['title'] = 'UPDATE GROUP';
    //             $data['id'] = $id;
    //             $data['action'] = 'update';
    //             $this->load->model("m_userm");
    //             $data['arrdata'] = $this->m_userm->get_data('group', $id);
    //             $data['menus'] = $this->m_userm->get_data('access_menu', $id);
    //             echo $this->load->view('content/group/group_add', $data, true);                
    //         }else{
    //             $this->load->model("m_userm");
    //             $arrdata = $this->m_userm->group($act, $id);
    //             $data = $this->load->view('content/newtable', $arrdata, true);
    //                 if($this->input->post("ajax")||$act=="post"){
    //                     echo $arrdata;
    //                 }else{
    //                     $this->content = $data;
    //                     $this->index();
    //                 }
    //         }
    // }

	public function group($act,$id){
		$this->load->view('content/error',$this->index());
	}

}
