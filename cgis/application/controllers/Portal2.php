<?php defined('BASEPATH') or exit('No direct script access allowed');

class Portal2 extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('LOGGED')) {
            redirect(base_url('index.php'), 'refresh');
        }
    }

    public function index() 
    {
        echo $this->load->view("content/portal2/index");

    }
    public function delstatbhd(){
        echo $this->load->view("content/portal2/statbhd");
    }

    // fungsi

    public function get_data_billing()
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: *");
        header('Content-Type: application/json');
        $nodok = $_POST['nodok'];

        $this->db->select('ID, NO_DOK, TGL_DOK, JNS_DOK, NO_CONT, FL_BIL');
        $this->db->from('t_gatepass');
        $this->db->where('NO_DOK', $nodok);

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $result = $query->result_array(); 
            echo json_encode($result); 
        } else {
            // echo json_encode([]); 
        }

    }
}