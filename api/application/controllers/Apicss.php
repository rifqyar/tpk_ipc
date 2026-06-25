<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include_once './vendor/autoload.php';
use Firebase\JWT\JWT;
class Apicss extends CI_Controller {
    public function index()
	{
		$this->load->view('welcome_message');
	}

    public function getcustomer(){
        $npwp = isset($_POST['npwp']) ? $_POST['npwp'] : '';
        
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://apiserver.multiterminal.co.id/api/staging_customer/index.php/Getcust',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array('npwp' => $npwp),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;
    }
}