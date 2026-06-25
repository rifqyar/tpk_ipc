<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';


//use Restserver\Libraries\REST_Controller;


class Test extends REST_Controller {

    public function __construct() {

        parent::__construct();
 
        $this->load->database();
 
     }
 
     public function index_get($id = 0)
 
     {
 
         if(!empty($id)){
 
            $data = $this->db->get_where("list_dokumens", ['id_dokumen' => $id])->row_array();
 
         }else{
 
             $data = $this->db->get("list_dokumens")->result();
 
         }
 
         $this->response([
                'Keterangan ' => [
                'Success ' => 'True',
                'List Dokumens ' => $data]], REST_Controller::HTTP_OK);
 
     }
 
     public function index_post()
 
     {
 
         $input = $this->input->post();
 
         $this->db->insert('list_dokumens',$input);
 
        // $this->response(['Dokumens created successfully.'], REST_Controller::HTTP_OK);
 
     } 

 
     public function index_put($id)
 
     {
 
         $input = $this->put();
 
         $this->db->update('list_dokumens', $input, array('id'=>$id));
 
        // $this->response(['Dokumen updated successfully.'], REST_Controller::HTTP_OK);
 
     }
 
 
     public function index_delete($id)
 
     {
 
         $this->db->delete('list_dokumens', array('id'=>$id));
 
       //  $this->response(['Dokumen deleted successfully.'], REST_Controller::HTTP_OK);
 
     }
 
         

}
