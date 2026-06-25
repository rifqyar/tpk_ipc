<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Codeco_kms extends CI_Controller{
	function __construct(){
        parent::__construct();
    }
	
	function index(){
		echo "Welcome to Airin Service"; exit();
	}
	
	/*function respon_plp(){
		$this->load->model("m_integrasi");
		$this->m_integrasi->respon_plp();	
	}
	
	function codeco_cont(){
		$this->load->model("m_integrasi");
		$this->m_integrasi->codeco_cont();	
	}*/
	
	function codeco_kms(){
		$this->load->model("m_integrasi");
		$this->m_integrasi->codeco_kms();	
	}
}

