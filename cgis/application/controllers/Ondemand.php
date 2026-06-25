<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Ondemand extends CI_Controller {
	public $content;

    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('LOGGED')) {
            redirect(base_url('index.php'), 'refresh');
        }
    }

    public function spjm()
    {
        echo $this->load->view("content/ondemand/index");
    }
    public function sppb(){
        echo $this->load->view("content/ondemand/sppb");
    }
    public function manual(){
        echo $this->load->view("content/ondemand/manual");
    }
    public function npe(){
        echo $this->load->view("content/ondemand/npe");
    }
    public function karantina(){
        echo $this->load->view("content/ondemand/karantina");
    }

    public function process_spjm(){

    }
}