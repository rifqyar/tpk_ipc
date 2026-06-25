<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include_once './vendor/autoload.php';
use Firebase\JWT\JWT;
class Apibc extends CI_Controller {

	public function index()
	{
		$this->load->view('welcome_message');
	}
	public function token()
	{
		$key = "beacukai_mti";
		$payload = array(
			"name" => "beacukai",
			"pass" => "123456mti",
		);

		$jwt = JWT::encode($payload, $key);
		print_r($jwt);
	}

	public function decode()
	{	
		try {
			$token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJuYW1lIjoiYmVhY3VrYWkiLCJwYXNzIjoiMTIzNDU2bXRpIn0.-lfpyLRoDJbfjx1oBkByGsJzeKRhWbwt1cdxvlSNuss';
			$key = "beacukai_mti";
			$decoded = JWT::decode($token, $key, array('HS256'));
			
			$this->httpres(200,'success',$decoded,'');
		} catch (Exception $e) {
			$this->httpres(200,'error','',$e->getMessage());
		}
	}



	
	public function httpres($header,$status,$data = array(),$message = '')
	{
		if ($status === 'success') {
			$response = array(
				'status' => $status,
				'data'	=> $data
			);
			$this->output
			->set_status_header($header)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode($response));
		}else{
			$response = array(
				'status' => $status,
				'message'	=> $message
			);
			$this->output
			->set_status_header($header)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode($response));
		}
	}
}
