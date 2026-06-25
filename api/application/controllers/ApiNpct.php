<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include_once './vendor/autoload.php';
use Firebase\JWT\JWT;
class ApiNpct extends CI_Controller {

	public function index()
	{
		$this->load->view('welcome_message');
	}
	
	public function token()
	{
		$key = "bos_mti";
		$payload = array(
			"name" => "npct1",
			"pass" => "123npct1",
		);
		$jwt = JWT::encode($payload, $key);
		print_r($jwt);
	}

	public function decode()
	{	
		try {
			$token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJuYW1lIjoibnBjdDEiLCJwYXNzIjoiMTIzbnBjdDEifQ.wsfRUMNpxTZl6EodAyegmzraMY3nncW-rY5Rd8vTRh0';
			$key = "bos_mti";
			$decoded = JWT::decode($token, $key, array('HS256'));
			$this->httpres(200,'success',$decoded,'');
		} catch (Exception $e) {
			$this->httpres(200,'error','',$e->getMessage());
		}
	}

	public function ResponseGatepass(){

		$token = $this->input->post('token');
		$xml = $this->input->post('xml');
		try {
			$user='wsnpct1';
			$key = "bos_mti";
			$decoded = JWT::decode($token, $key, array('HS256'));
			$xml= trim(strtoupper(preg_replace('/\s\s+/', '', str_replace("\n", " ", $xml))));
			// print_r($xml);die();
			$IDLogServices = $this->insertLogServices($user, $xml, '', '', 'StatusGatePass');
			// print_r($IDLogServices);die();
			if ($xml == '') {
				$return = '<?xml version="1.0" encoding="UTF-8"?>';
				$return .= '<DOCUMENT>';
				$return .= '<MESSAGE>';
				$return .= '<RESPON>STRING1 BELUM TERDEFINISI</RESPON>';
				$return .= '</MESSAGE>';
				$return .= '</DOCUMENT>';
				$logServices = $this->updateLogServices($IDLogServices, $return, 'STRING1 BELUM TERDEFINISI');
				return $return;
			} else {
				// $this->insertLogServicesCGIS($user, str_replace("'", "''", $xml), 'true', $remarks, 'StatusGatePass');
				$this->insertMailBoxCGIS('GETSTATUSGATEPASS', str_replace("'", "''", $xml));
				$xml = simplexml_load_string($xml);
				$loop = $xml->GATEPASS;
    			$count = count($loop);
				// print_r($count);die();
				if ($count > 1) {
					for ($c = 0; $c < $count; $c++) {
						$UpdateGatePass = $this->UpdateGatePass($loop[$c]);
						if (!$UpdateGatePass) {
							$return = 'false';
							$logServices = $this->updateLogServices($IDLogServices, $return, 'GAGAL UPDATE t_request_cont.');
							return $return;
						}
					}
					$this->httpres(200, 'success', $UpdateGatePass, '');
				} elseif ($count == 1) {
					$UpdateGatePass = $this->UpdateGatePass($loop);
					if (!$UpdateGatePass) {
						$return = 'false';
						$logServices = $this->updateLogServices($IDLogServices, $return, 'GAGAL UPDATE t_request_cont.');
						return $return;
					}
					$this->httpres(200, 'success', $UpdateGatePass, '');
				}
				$return = 'true';
				$logServices = $this->updateLogServices($IDLogServices, $return, '');
				return $return;
			}
		}catch (Exception $e) {
			$this->httpres(200,'error','',$e->getMessage());
		}
	}

	public function check_behandle(){

		$token = $this->input->post('token');
		$cont = $this->input->post('cont_no');

		try {
			$user='wsnpct1';
			$key = "bos_mti";
			$decoded = JWT::decode($token, $key, array('HS256'));
			$cekdata ="SELECT b.NO_SPK, a.NO_CONT,b.NO_DOK, b.TGL_DOK, DATE_FORMAT(c.WK_IN,'%Y%m%d%H%i%s') as 'BehandleIn_Time' from t_spk_cont a join t_spk b on a.ID = b.ID 
			left join t_operation c on c.NO_CONT = a.NO_CONT and b.NO_DOK = c.NO_DOK and c.TGL_DOK = b.TGL_DOK 
			where a.NO_CONT ='$cont' and year(b.WK_REQ) >= 2021";
			$test = $this->db->query($cekdata);

			if($test->num_rows() > 0){
				foreach($test->result() as $key => $value){
					$NO_CONT= $value->NO_CONT;
					$NO_DOK = $value->NO_DOK;
					$TGL_DOK = $value->TGL_DOK;
					$NO_SPK = $value->NO_SPK;
					$BEHANDLE_IN = $value->BehandleIn_Time;
					$xml ='<response>
					<status>success</status>
					<header> 
						<no_dok>'.$NO_DOK.'</no_dok> 
						<tgl_dok>'.$TGL_DOK.'</tgl_dok> 
						<behandlein_time>'.$BEHANDLE_IN.'</behandlein_time> 
					</header>';
					$xml .= '<detail>';
					if($NO_CONT != ''){
                    $SQL1 = " SELECT a.ID_JOB_SLIP, a.NO_CONT, a.NO_DOK,a.LOKASI_AWAL, a.LOKASI_AKHIR,a.TIER_AKHIR, a.STATUS, DATE_FORMAT(a.WK_STATUS,'%Y%m%d%H%i%s') as 'stacking_before_time' from t_job_slip a
					where a.NO_CONT ='$NO_CONT' and a.NO_DOK ='$NO_DOK' and left(a.LOKASI_AKHIR ,2) = '1B' and a.STATUS ='DONE' order by a.ID_JOB_SLIP desc";
					}
					$cek1= $this->db->query($SQL1);
					if($cek1->num_rows() > 0 ){
						$xml .= '<detail_before>';
						foreach($cek1->result() as $key => $value1){
							$lokasi_akhir = $value1->LOKASI_AKHIR;
							$stacking_before_time = $value1->stacking_before_time;
							$tier = $value1->TIER_AKHIR;
							$xml .= '<stacking_before_yard>'.$lokasi_akhir.'0'.$tier.'</stacking_before_yard>
									 <stacking_before_time>'.$stacking_before_time.'</stacking_before_time>';
						}
						$xml .= '</detail_before>';
					}else if($cek1->num_rows() == 0 ){
						$xml .= '<detail_before>';
						$xml .= '<stacking_before_yard></stacking_before_yard>
								 <stacking_before_time></stacking_before_time>';
						$xml .= '</detail_before>';
					}

					if($NO_CONT != ''){
						$SQL2 = "SELECT a.ID_JOB_SLIP, b.NO_CONT, b.NO_DOK, b.TGL_DOK,a.LOKASI_AWAL, a.LOKASI_AKHIR,a.TIER_AKHIR, a.STATUS, DATE_FORMAT(a.WK_STATUS,'%Y%m%d%H%i%s') as 'stacking_cic_time', DATE_FORMAT(b.WK_RESPON ,'%Y%m%d%H%i%s') as 'time_response',DATE_FORMAT(d.jadwal,'%Y%m%d%H%i%s') as 'rencana_periksa' from t_gatepass b join t_job_slip a on b.ID = a.NO_GATEPASS
						left join t_detail_pemeriksa_join d on d.no_cont = b.NO_CONT and d.no_dok = b.NO_DOK and d.tgl_dok = b.TGL_DOK
						where a.NO_CONT ='$NO_CONT' and a.NO_DOK ='$NO_DOK' and left(a.LOKASI_AKHIR,3) = 'CIC' and a.STATUS ='DONE' order by a.ID_JOB_SLIP desc";
					}
					$cek2= $this->db->query($SQL2);
						if($cek2->num_rows() > 0 ){
							$xml .= '<detail_cic>';
							foreach($cek2->result() as $key => $value2){
								$stacking_cic_time = $value2->stacking_cic_time;
								$lokasi = $value2->LOKASI_AKHIR;
								$rencana_periksa = $value2->rencana_periksa;
								$time_response = $value2->time_response;
								$tier = $value2->TIER_AKHIR;
								$xml .= '<time_response>'.$time_response.'</time_response>
										 <rencana_periksa_time>'.$rencana_periksa.'</rencana_periksa_time>
										 <stacking_cic>'.$lokasi.'0'.$tier.'</stacking_cic>
										 <stacking_cic_time>'.$stacking_cic_time.'</stacking_cic_time>';
							}
							$xml .= '</detail_cic>';
						} else if($cek2->num_rows() == 0 ){
							$xml .= '<detail_cic>';
							$xml .= '<time_response></time_response>
									<rencana_periksa_time></rencana_periksa_time>
									<stacking_cic></stacking_cic>
									<stacking_cic_time></stacking_cic_time>';
							$xml .= '</detail_cic>';
						}
						
					if($NO_CONT != ''){
						$SQL3 = "SELECT a.NO_CONT, a.NO_DOK, a.TGL_DOK,  DATE_FORMAT(a.START_INSP,'%Y%m%d%H%i%s') as 'START_INSP',DATE_FORMAT(a.FINISH_INSP,'%Y%m%d%H%i%s') as 'FINISH_INSP', a.STATUS, a.JNS_KEGIATAN, a.FL_GRAHA from t_op_inspection a where a.FL_GRAHA ='Y' AND a.NO_CONT ='$NO_CONT' and a.NO_DOK ='$NO_DOK' order by a.ID desc";
					}
					$cek3= $this->db->query($SQL3);
						if($cek3->num_rows() > 0 ){
							$xml .= '<detail_pemeriksaan>';
							foreach($cek3->result() as $key => $value3){
								$start_periksa = $value3->START_INSP;
								$finish_periksa = $value3->FINISH_INSP;
								$xml .= '<start_periksa>'.$start_periksa.'</start_periksa>
										<finish_periksa>'.$finish_periksa.'</finish_periksa>';
							}
							$xml .= '</detail_pemeriksaan>';
						}else if($cek3->num_rows() == 0 ){
							$xml .= '<detail_pemeriksaan>';
							$xml .= '<start_periksa></start_periksa>
									 <finish_periksa></finish_periksa>';
							$xml .= '</detail_pemeriksaan>';
						}


					if($NO_CONT != ''){
                    $SQL4 = "SELECT a.ID_JOB_SLIP, b.NO_CONT, b.NO_DOK, b.TGL_DOK,a.LOKASI_AWAL, a.LOKASI_AKHIR, a.STATUS, DATE_FORMAT(a.WK_STATUS,'%Y%m%d%H%i%s') as 'stacking_after_time' from t_gatepass b join t_job_slip a on b.ID = a.NO_GATEPASS 
					where a.NO_CONT ='$NO_CONT' and left(a.LOKASI_AKHIR,2) = '1A' and a.STATUS ='DONE' order by a.ID_JOB_SLIP desc limit 1";
					}
					$cek4= $this->db->query($SQL4);
					if($cek4->num_rows() > 0 ){
						$xml .= '<detail_after>';
						foreach($cek4->result() as $key => $value4){
							$lokasi_akhir = $value4->LOKASI_AKHIR;
							$stacking_after_time = $value4->stacking_after_time;
							$xml .= '<stacking_after_yard>'.$lokasi_akhir.'</stacking_after_yard>
									 <stacking_after_time>'.$stacking_after_time.'</stacking_after_time>';
						}
						$xml .= '</detail_after>';
					} else if($cek4->num_rows() == 0 ){
						$xml .= '<detail_after>';
						$xml .= '<stacking_after_yard></stacking_after_yard>
								 <stacking_after_time></stacking_after_time>';
						$xml .= '</detail_after>';
					}

					if($NO_CONT != ''){
					$SQL5 = "SELECT a.DOCUMENT_NO, a.DOCUMENT_DATE, DATE_FORMAT(b.EXPIRED,'%Y%m%d') as 'PAYMENT_TIME',
					(case when b.NO_NOTA_DELIVERY is not null then 'success'
					when b.NO_NOTA_DELIVERY is null THEN NULL
					END) AS 'KETERANGAN'
					from t_autogate_send_customs a join req_delivery_hdr b on a.DOCUMENT_NO = b.NO_DOK and a.DOCUMENT_DATE = b.TGL_DOK 
					where a.CONTAINER_ID = '$NO_CONT' and b.NO_NOTA_DELIVERY is not null and DATE(a.CREATED) > DATE_ADD(NOW() , INTERVAL -1 year)
					order by a.TRANSACTION_ID desc limit 1";
					}
					$cek5= $this->db->query($SQL5);
					if($cek5->num_rows() > 0 ){
						$xml .= '<detail_payment>';
						foreach($cek5->result() as $key => $value5){
							$payment_time = $value5->PAYMENT_TIME;
							$keterangan = $value5->KETERANGAN;
							$xml .= '<payment_time>'.$payment_time.'</payment_time>
							<payment_status>'.$keterangan.'</payment_status>';
						}
						$xml .= '</detail_payment>';
					}else if($cek5->num_rows() == 0 ){
						$xml .= '<detail_payment>';
						$xml .= '<payment_time></payment_time>
								 <payment_status></payment_status>';
						$xml .= '</detail_payment>';
					}

					if($NO_CONT != ''){
					$SQL6 = "SELECT a.NO_CONT, a.WK_TRUCKIN, a.WK_CHASSIS, a.WK_INSPECT, DATE_FORMAT(a.WK_GATEOUT,'%Y%m%d%H%i%s') as 'WK_GATEOUT' , FL_NPCT1 from t_op_delivery a 
					where  a.NO_SPK ='$NO_SPK' and a.NO_CONT ='$NO_CONT' and DATE(a.WK_REKAM) > DATE_ADD(NOW() , INTERVAL -1 year) order by a.ID desc";
					}
					$cek6= $this->db->query($SQL6);
					if($cek6->num_rows() > 0 ){
						$xml .= '<detail_gateout>';
						foreach($cek6->result() as $key => $value6){
							$wk_truckin = $value6->WK_TRUCKIN;
							$wk_chasis = $value6->WK_CHASSIS;
							$wk_inspect = $value6->WK_INSPECT;
							$wk_gateout = $value6->WK_GATEOUT;
							$xml .= '
							<gateout_time>'.$wk_gateout.'</gateout_time>';
						}
						$xml .= '</detail_gateout>';
					}else if($cek6->num_rows() == 0 ){
						$xml .= '<detail_gateout>';
						$xml .= '<gateout_time></gateout_time>';
						$xml .= '</detail_gateout>';
					}
					$xml .= '</detail>'; 
				$xml .= '</response>';
				$xml= trim((preg_replace('/\s\s+/', '', str_replace("\n", " ", $xml))));
				print_r($xml);

				}

			}
		} catch (Exception $e) {
			$this->httpres(200,'error','',$e->getMessage());
		}

	}

	public function insertLogServices($userName, $xmlRequest, $xmlResponse, $remarks, $method = '') {
		$ipAddress = $this->getIP();
		$method = $method == '' ? 'NULL' : "'" . $method . "'";
		$userName = $userName == '' ? 'NULL' : "'" . $userName . "'";
		$xmlRequest = $xmlRequest == '' ? 'NULL' : "'" . $xmlRequest . "'";
		$xmlResponse = $xmlResponse == '' ? 'NULL' : "'" . $xmlResponse . "'";
		$remarks = $remarks == '' ? 'NULL' : "'" . $remarks . "'";
		$SQL = "INSERT INTO `tpk_ipc`.`log_services` (`METHOD`, `USERNAME`, `XML_REQUEST`, `XML_RESPONSE`, `IPADDRESS`, `REMARKS`, `WK_REKAM`)VALUES (" . $method . ", " . $userName . ", " . $xmlRequest . ", " . $xmlResponse . ", '" . $ipAddress . "', " . $remarks . ", NOW())";
		// var_dump($SQL);die();
		$this->db->query($SQL);
		$ID = $this->db->insert_id();
		return $ID;	
	}

	public function insertLogServicesCGIS($userName, $xmlRequest, $xmlResponse, $remarks, $method = '') {
		$ipAddress = $this->getIP();
		$url = "http://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
		$method = $method == '' ? 'NULL' : "'" . $method . "'";
		$userName = $userName == '' ? 'NULL' : "'" . $userName . "'";
		$xmlRequest = $xmlRequest == '' ? 'NULL' : "'" . $xmlRequest . "'";
		$xmlResponse = $xmlResponse == '' ? 'NULL' : "'" . $xmlResponse . "'";
		$remarks = $remarks == '' ? 'NULL' : "'" . $remarks . "'";
		$SQL = "INSERT INTO `cgis`.`app_log_services` (`URL`, `METHOD`, `REQUEST`, `RESPONSE`, `IP_ADDRESS`, `REMARKS`, `WK_REKAM`) VALUES ('" . $url . "', " . $method . ", " . $xmlRequest . ", " . $xmlResponse . ", '" . $ipAddress . "', " . $remarks . ", NOW())";
		$this->db->query($SQL);
		$ID =  $this->db->insert_id();
		return $ID;
	}

	function insertMailBoxCGIS($KodeAPRF, $StrData, $KodeOrgSender = "", $KodeOrgReceiver = "") {
		global $CONF, $conn;
		$KodeAPRF = $KodeAPRF == '' ? 'NULL' : "'" . $KodeAPRF . "'";
		$KodeOrgSender = $KodeOrgSender == '' ? 'NULL' : "'" . $KodeOrgSender . "'";
		$KodeOrgReceiver = $KodeOrgReceiver == '' ? 'NULL' : "'" . $KodeOrgReceiver . "'";
		$StrData = $StrData == '' ? 'NULL' : "'" . $StrData . "'";
		$SQL = "INSERT INTO `tpk_ipc`.`mailbox` (`KD_APRF`, `KD_ORG_SENDER`, `KD_ORG_RECEIVER`, `STR_DATA`, `TGL_STATUS`)VALUES (" . $KodeAPRF . ", " . $KodeOrgSender . ", " . $KodeOrgReceiver . ", " . $StrData . ", NOW())";
		$this->db->query($SQL);
		$ID =  $this->db->insert_id();
		return $ID;
	}

	public function updateLogServices($ID, $xmlResponse, $remarks) {
		$xmlResponse = $xmlResponse == '' ? 'NULL' : "'" . $xmlResponse . "'";
		$remarks = $remarks == '' ? 'NULL' : "'" . $remarks . "'";
		$SQL = "UPDATE `tpk_ipc`.`log_services` SET XML_RESPONSE = " . $xmlResponse . ", REMARKS = " . $remarks . " WHERE ID = '" . $ID . "'";
		$this->db->query($SQL);
	}

	public function UpdateGatePass($data) {
		$REF_NUMBER = $data->REFF_NUMBER;
		$STATUS = $data->STATUS;
		$CONTAINER = $data->CONT_NO;
		$CEKREFFNUMBER = $data->REFF_NUMBER;
		// var_dump($CEKREFFNUMBER);die();
		if(substr($CEKREFFNUMBER,0,3) == 'BIL'){
			$SQL = "UPDATE t_request_cont SET KD_STATUS = '$STATUS', REF_NUMBER = '$REF_NUMBER' WHERE NO_CONT = '$CONTAINER'";    
		}else{
			$SQL = "UPDATE t_request_cont SET KD_STATUS = '$STATUS' WHERE REF_NUMBER = '$REF_NUMBER' AND NO_CONT = '$CONTAINER' ";
		}
		$Execute = $this->db->query($SQL);
		// var_dump($Execute);die();
		return $Execute;
	}

	public function getIP($type = 0) {
		if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown"))
			$ip = getenv("HTTP_CLIENT_IP");
		else if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown"))
			$ip = getenv("REMOTE_ADDR");
		else if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown"))
			$ip = getenv("HTTP_X_FORWARDED_FOR");
		else if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown"))
			$ip = $_SERVER['REMOTE_ADDR'];
		else {
			$ip = "unknown";
			return $ip;
		}
		if ($type == 1) {
			return md5($ip);
		}
		if ($type == 0) {
			return $ip;
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
		}else if($status === 'error'){
			$response = array(
				'status' => $status,
				'message'	=> $message
			);
			$this->output
			->set_status_header($header)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode($response));

		}else if($status === 'error_field'){
			$response = array(
				'status' => $status,
				'message'	=> 'parameter is not field'
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
	public function httpresxml($header,$status,$data = array(),$message = '')
	{
		if ($status === 'success') {
			$response = array(
				'status' => $status,
				'data'	=> $data
			);
			$this->output
			->set_status_header($header)
			->set_content_type('application/xml', 'utf-8')
			->set_output(print_r($response));
		}else if($status === 'error'){
			$response = array(
				'status' => $status,
				'message'	=> $message
			);
			$this->output
			->set_status_header($header)
			->set_content_type('application/json', 'utf-8')
			->set_output(print_r($response));

		}else if($status === 'error_field'){
			$response = array(
				'status' => $status,
				'message'	=> 'parameter is not field'
			);
			$this->output
			->set_status_header($header)
			->set_content_type('application/json', 'utf-8')
			->set_output(print_r($response));

		}else{
			$response = array(
				'status' => $status,
				'message'	=> $message
			);
			$this->output
			->set_status_header($header)
			->set_content_type('application/json', 'utf-8')
			->set_output(print_r($response));
		}
	}
}
