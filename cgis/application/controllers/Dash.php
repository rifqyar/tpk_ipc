<?php 
	
	/**
	* 
	*/
	class Dash extends CI_Controller
	{
		
		function __construct()
		{
			parent::__construct();
			$this->load->model("m_home");
			$this->load->library('pagination');
		}

		function index(){
			//secho "string";die();
			$jumlah_data = $this->m_home->jumlah_data();
			//print_r($jumlah_data);die();
			
			$config['base_url'] = site_url().'dashboard/dashMonitoring';
			$config['total_rows'] = $jumlah_data;
			$config['per_page'] = 10;
			$from = $this->uri->segment(3);
			$this->pagination->initialize($config);		
			$arrdata['dash'] = $this->m_home->data($config['per_page'],$from);
			//print_r($arrdata);die();
			$this->load->view('content/dashboard/dashboard_view', $arrdata);
		}
	}
?>