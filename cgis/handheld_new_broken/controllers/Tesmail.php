<?php defined('BASEPATH') or exit('No direct script access allowed');

class Tesmail extends CI_Controller
{
    public $content;
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_home');
    }
    public function mailto(){
    	$subject = "TES SENDMAIL";//"REMINDER GATEPASS";
								//$email = $email3[$i]['EMAIL'];
								$this->load->helper('email');
								$email_success = 0;
								//if(valid_email($email)){
									$config = array(
										'protocol'  => 'smtp',
										'smtp_host' => 'mail2.edi-indonesia.co.id',
										'smtp_port' => 25,
										'smtp_user' => '',
										'smtp_timeout' => 30,
										'smtp_pass' => '',
										'mailtype'  => 'html',
										'charset'   => 'iso-8859-1',
										'wrapchars' => 100,
										'crlf'         => "\r\n",
										'newline'     => "\r\n",
										'start_tls' => TRUE
									);
									$msg = '
									<!DOCTYPE html>
									<html lang="en">
									<head>
										<meta charset="UTF-8">
										<title>Document</title>
									</head>
									
									<body>
										<div>
										tes email kirim
										</div>
									</body>
									
									</html>';
									$emailcustomrr = array('fachrurozi2206@gmail.com');
									$this->load->library('email', $config);
									$this->email->from('mohamad.ersa@edi-indonesia.co.id', 'BOS NOTIFICATION - REQUEST GATEPASS');
									//$email = str_replace(';', ',', $email);
									$this->email->to($emailcustomrr);
									$this->email->subject($subject);
									$this->email->message($msg);

								if ($this->email->send()){
									//$deb = $this->email->print_debugger();
									//$this->db->query("INSERT INTO log_email_solver (`email`, `status`, `debugger`) VALUES ('$msg', '1', 'deb')");
									$email_success = 1;
									echo "Terkirim";						
								}else{
									//$deb = $this->email->print_debugger();
									//$this->db->query("INSERT INTO log_email_solver (`email`, `status`, `debugger`) VALUES ('$msg', '0', 'deb')");
									echo "tidak terkirim 2";
								}
    }
}