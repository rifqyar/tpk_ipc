<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Integrasi extends CI_Controller{
	function __construct(){
        parent::__construct();
    }
	
	function index(){
		echo "Welcome to CGIS Service"; exit();
	}
	
	function manifest(){
		$this->load->model("m_integrasi");
		$this->m_integrasi->manifest();	
	}
	
	function respon_plp(){
		$this->load->model("m_integrasi");
		$this->m_integrasi->respon_plp();	
	}
	
	function coarri_cont(){
		$this->load->model("m_integrasi");
		$this->m_integrasi->coarri_cont();	
	}
	
	function coarri_loadingcont(){
		$this->load->model("m_integrasi");
		$this->m_integrasi->coarri_loadingcont();	
	}
	
	function codeco_incont(){
		$this->load->model("m_integrasi");
		$this->m_integrasi->codeco_incont();	
	}
	
	function codeco_outcont(){
		$this->load->model("m_integrasi");
		$this->m_integrasi->codeco_outcont();	
	}
	
	function codeco_kms(){
		$this->load->model("m_integrasi");
		$this->m_integrasi->codeco_kms();	
	}
	
	function coarri_car(){
		$this->load->model("m_integrasi");
		$this->m_integrasi->coarri_car();	
	}
	
	function coarri_carout(){
		$this->load->model("m_integrasi");
		$this->m_integrasi->coarri_carout();	
	}
	
	function coarri_carkms(){
		$this->load->model("m_integrasi");
		$this->m_integrasi->coarri_carkms();	
	}
	
	function coarri_carkmsout(){
		$this->load->model("m_integrasi");
		$this->m_integrasi->coarri_carkmsout();	
	}
}

