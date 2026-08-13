<?php if (! defined('BASEPATH')) exit('No direct script access allowed');
class MonitoringNew extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
  }
  
  function index()
  {
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
}
