<?php defined('BASEPATH') or exit('No direct script access allowed');
class AtensiP2 extends CI_Controller
{
  public $content;
  public function __construct()
  {
    parent::__construct();
    $this->load->model('M_operation');
    $this->load->model('M_AtensiP2');
  }

  public function index()
  {
    $headers  = '<link rel="apple-touch-icon" href="' . base_url() . 'assets/images/apple-touch-icon.png">';
    $headers .= '<link rel="shortcut icon" href="' . base_url() . 'assets/images/favicon.ico">';
    #Stylesheets
    $headers .= '<link rel="stylesheet" href="' . base_url() . 'assets/css/bootstrap.min.css?v2.1.0">';
    $headers .= '<link rel="stylesheet" href="' . base_url() . 'assets/css/bootstrap-extend.min.css?v2.1.0">';
    $headers .= '<link rel="stylesheet" href="' . base_url() . 'assets/css/site.min.css?v2.1.0">';
    $headers .= '<link rel="stylesheet" href="' . base_url() . 'assets/css/slide-unlock.css">';
    //$headers .= '<link rel="stylesheet" href="'.base_url().'assets/css/login_handheld.css">';
    #Plugins
    $headers .= '<link rel="stylesheet" href="' . base_url() . 'assets/vendor/animsition/animsition.min.css?v2.1.0">';
    $headers .= '<link rel="stylesheet" href="' . base_url() . 'assets/vendor/asscrollable/asScrollable.min.css?v2.1.0">';
    $headers .= '<link rel="stylesheet" href="' . base_url() . 'assets/vendor/switchery/switchery.min.css?v2.1.0">';
    $headers .= '<link rel="stylesheet" href="' . base_url() . 'assets/vendor/intro-js/introjs.min.css?v2.1.0">';
    $headers .= '<link rel="stylesheet" href="' . base_url() . 'assets/vendor/slidepanel/slidePanel.min.css?v2.1.0">';
    $headers .= '<link rel="stylesheet" href="' . base_url() . 'assets/vendor/flag-icon-css/flag-icon.min.css?v2.1.0">';
    $headers .= '<link rel="stylesheet" href="' . base_url() . 'assets/vendor/waves/waves.min.css?v2.1.0">';
    $headers .= '<link rel="stylesheet" href="' . base_url() . 'assets/vendor/sweetalert/sweetalert.css">';
    $headers .= '<link rel="stylesheet" href="' . base_url() . 'assets/vendor/themes/twitter.css">';
    #Page
    //$headers .= '<link rel="stylesheet" href="'.base_url().'assets/vendor/pages/login.min.css?v2.1.0">';
    #Fonts
    $headers .= '<link rel="stylesheet" href="' . base_url() . 'assets/fonts/material-design/material-design.min.css?v2.1.0">';
    $headers .= '<link rel="stylesheet" href="' . base_url() . 'assets/fonts/brand-icons/brand-icons.min.css?v2.1.0">';
    $headers .= '<link rel="stylesheet" href="' . base_url() . 'assets/fonts/font.css?v2.1.0">';
    #Scripts
    $headers .= '<script src="' . base_url() . 'assets/vendor/modernizr/modernizr.min.js"></script>';
    $headers .= '<script src="' . base_url() . 'assets/vendor/breakpoints/breakpoints.min.js"></script>';
    $headers .= '<script>Breakpoints();</script>';
    #Core
    $footers  = '<script src="' . base_url() . 'assets/vendor/jquery/jquery.min.js"></script>';
    $footers .= '<script src="' . base_url() . 'assets/vendor/bootstrap/bootstrap.min.js"></script>';

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
    $footers .= '<script src="' . base_url() . 'assets/vendor/alertify-js/alertify.js"></script>';

    $footers .= '<script src="' . base_url() . 'assets/vendor/jquery-placeholder/jquery.placeholder.min.js"></script>';
    $footers .= '<script src="' . base_url() . 'assets/js/core.min.js"></script>';
    $footers .= '<script src="' . base_url() . 'assets/js/site.min.js"></script>';
    $footers .= '<script src="' . base_url() . 'assets/js/sections/menu.min.js"></script>';
    $footers .= '<script src="' . base_url() . 'assets/js/sections/menubar.min.js"></script>';
    $footers .= '<script src="' . base_url() . 'assets/js/sections/gridmenu.min.js"></script>';
    $footers .= '<script src="' . base_url() . 'assets/js/sections/sidebar.min.js"></script>';
    $footers .= '<script src="' . base_url() . 'assets/js/configs/config-colors.min.js"></script>';
    $footers .= '<script src="' . base_url() . 'assets/js/configs/config-tour.min.js"></script>';
    $footers .= '<script src="' . base_url() . 'assets/js/components/asscrollable.min.js"></script>';
    $footers .= '<script src="' . base_url() . 'assets/js/components/animsition.min.js"></script>';
    $footers .= '<script src="' . base_url() . 'assets/js/components/slidepanel.min.js"></script>';
    $footers .= '<script src="' . base_url() . 'assets/js/components/switchery.min.js"></script>';
    $footers .= '<script src="' . base_url() . 'assets/js/components/tabs.min.js"></script>';
    $footers .= '<script src="' . base_url() . 'assets/js/components/jquery-placeholder.min.js"></script>';
    $footers .= '<script src="' . base_url() . 'assets/js/components/material.min.js"></script>';
    $footers .= '<script src="' . base_url() . 'assets/vendor/sweetalert/sweetalert.min.js"></script>';
    $footers .= '<script src="' . base_url() . 'assets/js/main.js"></script>';
    $footers .= '<script src="' . base_url() . 'assets/js/jquery.slideunlock.js"></script>';
    $footers .= '<script src="' . base_url() . 'assets/js/pickupjs_new.js"></script>';

    if ($this->content == "") {
      $this->content = $this->load->view('content/operation/atensip2', '', true);
    }
    $data = array(
      '_title_' => 'BOS',
      '_headers_' => $headers,
      '_footers_' => $footers,
      '_content_' => $this->content
    );
    $this->parser->parse('index', $data);
  }

  public function search()
  {
    $data['menuu'] = 'HANDHELD';
    $keyw    =   $this->input->post('search');
    $sessionFromHold = $this->session->flashdata('keyword_search');
    if (empty($keyw)) {
      $keyw = $sessionFromHold;
    }
    $keyword = strtoupper($keyw);
    $re  =   $this->M_AtensiP2->search_holdd($keyword);
    $dan = $re->result_array();
    if (count($dan) > 0) {
      if (isset($sessionFromHold)) {
        $data['nilai'] = $dan;
        $data['status'] = 1;
      }
      $data['nilai'] = $dan;
      $data['status'] = 1;
      $this->content = $this->load->view('content/operation/atensip2', $data, true);
      $this->index();
    } else {
      $data['status'] = 2;
      $data['nilai'] = $keyword;
      $data['kode'] = 2;
      $this->content = $this->load->view('content/operation/atensip2', $data, true);
      $this->index();
    }
  }

  public function hold_cont()
  {
    $ID       = $this->input->post('id', TRUE);
    $NO_SPK   = $this->input->post('nospk', TRUE);
    $NO_CONT  = $this->input->post('nomercont', TRUE);
    $NO_DOK   = strtoupper($this->input->post('nodok', TRUE));
    $WARNA    = 'M';

    $cekdokumen = $this->db->query("SELECT * FROM t_spk_cont WHERE ID = ? AND NO_CONT = ?", array($ID, $NO_CONT))->result();

    if (!empty($cekdokumen)) {
      $data_update = array(
        'FL_HOLD'       => 'Y',
        'FL_WARNA_HOLD' => $WARNA
      );
      $this->db->where('ID', $ID);
      $this->db->where('NO_CONT', $NO_CONT);
      $this->db->update('t_spk_cont', $data_update);

      $data_insert = array(
        'NO_DOK'      => $NO_DOK,
        'NO_CONT'     => $NO_CONT,
        'NO_SPK'      => $NO_SPK,
        'UKR_CONT' => isset($cekdokumen[0]->UKR_CONT) ? $cekdokumen[0]->UKR_CONT : NULL,
        'STATUS_HOLD' => 'Y',
        'HOLD_AT'     => date('Y-m-d H:i:s')
      );
      $this->db->insert('t_atensi_p2', $data_insert);
    } else {
      echo "Error: Data tidak ditemukan";
      // $this->session->set_flashdata('error_msg', 'Gagal hold: Data tidak ditemukan.');
    }

    $keyword = $NO_SPK;
    $this->session->set_flashdata('keyword_search', $keyword);
    redirect('AtensiP2/search/');
  }
}
