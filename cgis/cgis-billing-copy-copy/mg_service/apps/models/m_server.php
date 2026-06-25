<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function sendTest($username,$password){
	global $objci;
	$objci->load->model('m_act');
	$hasil = $objci->m_act->sendTest($username,$password);
	return $hasil;
}

function sendDocumentSP2MP($username,$password,$xml){
	global $objci;
	$objci->load->model('m_act');
	$hasil = $objci->m_act->sendDocumentSP2MP($username,$password,$xml);
	return $hasil;
}

function sendFinishQuarantine($username,$password,$xml){
	global $objci;
	$objci->load->model('m_act');
	$hasil = $objci->m_act->sendFinishQuarantine($username,$password,$xml);
	return $hasil;
}

?>
