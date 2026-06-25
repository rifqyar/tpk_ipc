<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Read extends CI_Controller{
	function __construct(){
        parent::__construct();
    }
	
	function repository(){
		$this->load->model("m_read");
		$this->m_read->repository();	
	}
	
	function send_email(){
		$this->load->model("m_read");
		$this->m_read->send_email();
	}
}

