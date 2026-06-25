<?php defined('BASEPATH') or exit('No direct script access allowed');

class Apibehandle extends CI_Controller
{
	public $content;
	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_home');
	}
	public function getdata()
	{
		$data = json_decode(file_get_contents('php://input'), true);
		header('Content-Type: application/json');
		$key = 'bXRp8cd1dd4afdff53aa86e959e2db0486d2';
		$start = $data['startdate'];
		$end = $data['enddate'];

		if ($data["key"] == $key) {
			$q = $this->db->query("SELECT distinct 
				tg2.NO_CONT as 'NO_CONT',
				trc.TIPE_CONT,
				trc.UKR_CONT,
				tob.W_BEHANDLE as 'WK_BEHANDLE_IN',
				rkdb.NAMA,
				tg2.NO_DOK,
				tg2.TGL_DOK,
				toi.START_INSP as 'MULAI_PEMERIKSAAN',
				toi.FINISH_INSP as 'SELESAI_PEMERIKSAAN',
				tod.WK_TRUCKIN as 'LIFT_OFF_DELIVERY',
				tg.JNS_DOK as 'JENIS_DOK_PENGELUARAN',
				tg.NO_DOK as 'NO_DOK_PENGELUARAN',
				tg.TGL_DOK as 'TGL_DOK_PENGELUARAN',
				tod.WK_GATEOUT as 'TGL_GATEOUT',
				tg.NAMA_CUST,
				tg.NPWP as 'NPWP_CUST',
				rbh.TOTAL_JUMLAH as 'NILAI_INVOICE_BEHANDLE',
				rdh.TOTAL as 'NILAI_INVOICE_DELIVERY'
				from t_gatepass tg2
				join t_spk ts on tg2.NO_DOK = ts.NO_DOK and ts.TGL_DOK = tg2.TGL_DOK
				join t_request tr on ts.NO_DOK = tr.NO_DOK and ts.TGL_DOK = tr.TGL_DOK
				join t_request_cont trc on tr.ID = trc.ID 
				join t_op_behandlein tob on ts.NO_SPK = tob.NO_SPK and tg2.NO_CONT = tob.NO_CONT
				join t_op_inspection toi on toi.NO_CONT = tg2.NO_CONT and toi.NO_SPK = ts.NO_SPK 
				join t_op_delivery tod on tod.NO_CONT = tg2.NO_CONT and tod.NO_SPK = ts.NO_SPK 
				join t_gatepass tg on tg.NO_CONT = tg2.NO_CONT and tg.NO_SPK = ts.NO_SPK
				join reff_kode_dok_bc rkdb on ts.JNS_DOK = rkdb.ID
				join req_behandle_hdr rbh on rbh.NO_DOK = ts.NO_DOK and rbh.TGL_DOK = ts.TGL_DOK
				join req_delivery_hdr rdh on rdh.NO_DOK = tg.NO_DOK and rdh.TGL_DOK = tg.TGL_DOK
				where tod.WK_GATEOUT between '$start' and '$end' and tg.JNS_KEGIATAN = '3'");
			echo json_encode($q->result());
		} else {
			echo 'invalid key';
		}
	}
	public function getdatadev()
	{
		$data = json_decode(file_get_contents('php://input'), true);
		header('Content-Type: application/json');
		$key = 'bXRp8cd1dd4afdff53aa86e959e2db0486d2';
		$start = $data['startdate'];
		$end = $data['enddate'];

		if ($data["key"] == $key) {
			$q = $this->db->query("SELECT distinct 
				tg2.NO_CONT as 'NO_CONT',
				tob.W_BEHANDLE as 'WK_BEHANDLE_IN',
				rkdb.NAMA,
				tg2.NO_DOK,
				tg2.TGL_DOK,
				toi.START_INSP as 'MULAI_PEMERIKSAAN',
				toi.FINISH_INSP as 'SELESAI_PEMERIKSAAN',
				tod.WK_TRUCKIN as 'LIFT_OFF_DELIVERY',
				tg.JNS_DOK as 'JENIS_DOK_PENGELUARAN',
				tg.NO_DOK as 'NO_DOK_PENGELUARAN',
				tg.TGL_DOK as 'TGL_DOK_PENGELUARAN',
				tod.WK_GATEOUT as 'TGL_GATEOUT',
				tg.NAMA_CUST,
				tg.NPWP as 'NPWP_CUST',
				rbh.TOTAL_JUMLAH as 'NILAI_INVOICE_BEHANDLE',
				rdh.TOTAL as 'NILAI_INVOICE_DELIVERY'
				from t_gatepass tg2
				join t_spk ts on tg2.NO_DOK = ts.NO_DOK and ts.TGL_DOK = tg2.TGL_DOK
				join t_op_behandlein tob on ts.NO_SPK = tob.NO_SPK and tg2.NO_CONT = tob.NO_CONT
				join t_op_inspection toi on toi.NO_CONT = tg2.NO_CONT and toi.NO_SPK = ts.NO_SPK 
				join t_op_delivery tod on tod.NO_CONT = tg2.NO_CONT and tod.NO_SPK = ts.NO_SPK 
				join t_gatepass tg on tg.NO_CONT = tg2.NO_CONT and tg.NO_SPK = ts.NO_SPK
				join reff_kode_dok_bc rkdb on ts.JNS_DOK = rkdb.ID
				join req_behandle_hdr rbh on rbh.NO_DOK = ts.NO_DOK and rbh.TGL_DOK = ts.TGL_DOK
				join req_delivery_hdr rdh on rdh.NO_DOK = tg.NO_DOK and rdh.TGL_DOK = tg.TGL_DOK
				where tod.WK_GATEOUT between '$start' and '$end' and tg.JNS_KEGIATAN = '3'");
			echo json_encode($q->result());
		} else {
			echo 'invalid key';
		}
	}

	public function get_container_data()
	{
		$headers = getallheaders();
		$expectedKey = 'ABC123';

		if (isset($headers['Key']) && $headers['Key'] === $expectedKey) {
			// Read the raw POST data
			$rawPostData = file_get_contents('php://input');

			// Load the XML string into a SimpleXMLElement object
			$xml = new SimpleXMLElement($rawPostData);

			// Access the values of container and reff_number
			$container = (string) $xml->container;
			$reffNumber = (string) $xml->reff_number;

			// Output the values (for debugging or further processing)
			echo "Container: " . $container . "\n";
			echo "Reff Number: " . $reffNumber . "\n";

			// You can now use $container and $reffNumber as needed in your application
		} else {
			// Header key not found or does not match
			header('HTTP/1.0 403 Forbidden');
			echo 'Invalid or missing header key.';
		}
	}

	public function get_container_status()
	{
		// Load the database
		$this->load->database();
		
		// Get the raw POST data (XML input)
		$xml_data = file_get_contents("php://input");
	
		// Parse the XML input
		$xml = simplexml_load_string($xml_data);
	
		// Check if the XML is valid and has the required fields
		if ($xml && isset($xml->ref_number) && isset($xml->no_cont)) {
			// Extract ref_number and no_cont from the XML
			$ref_number = (string)$xml->ref_number;
			$no_cont = (string)$xml->no_cont;
	
			// Build the SQL query with LEFT JOIN for t_operation
			$sql = "
				SELECT B.JNS_DOK, B.NO_DOK, DATE_FORMAT(B.TGL_DOK, '%Y%m%d') AS 'TGL_DOK',
					   A.NO_CONT, A.UKR_CONT, A.TIPE_CONT, A.VESSEL, A.VOY_IN, A.VOY_OUT, A.CALL_SIGN, A.REF_NUMBER, 
					   C.NO_SPK, DATE_FORMAT(D.WK_IN, '%Y%m%d%H%i%s') AS 'WK_IN',
					   DATE_FORMAT(E.WK_RESPON, '%Y%m%d%H%i%s') AS 'RESPON_PPK',
					   DATE_FORMAT(F.WK_STATUS, '%Y%m%d%H%i%s') AS 'PLANING_INSPECT_STACK_CIC',
					   DATE_FORMAT(G.START_INSP, '%Y%m%d%H%i%s') AS 'START_PERIKSA',
					   DATE_FORMAT(G.FINISH_INSP, '%Y%m%d%H%i%s') AS 'FINISH_PERIKSA',
					   DATE_FORMAT(H.WK_STATUS, '%Y%m%d%H%i%s') AS 'MARSHALLING_EX_BEHANDLE',
					   DATE_FORMAT(I.WK_REK , '%Y%m%d%H%i%s') AS 'GATEPASS_OUT',
					   I.JNS_DOK as 'JNS_DOKUMEN_OUT',
					   I.NO_DOK as 'NO_SPPB',
					   DATE_FORMAT(I.TGL_DOK , '%Y%m%d') AS 'TGL_SPPB',
					   DATE_FORMAT(J.WK_GATEOUT , '%Y%m%d%H%i%s') AS 'TRUCK_OUT'
				FROM t_request_cont A
				JOIN t_request B ON A.ID = B.ID
				JOIN (SELECT AA.NO_SPK, AA.NO_DOK, AA.TGL_DOK, BB.NO_CONT 
					  FROM t_spk AA 
					  JOIN t_spk_cont BB ON AA.ID = BB.ID) C 
				ON C.NO_DOK = B.NO_DOK AND C.TGL_DOK = B.TGL_DOK AND C.NO_CONT = A.NO_CONT
				LEFT JOIN t_operation D ON D.NO_SPK = C.NO_SPK AND D.NO_CONT = A.NO_CONT
				left join t_gatepass E on E.NO_DOK = B.NO_DOK and E.NO_CONT = A.NO_CONT and E.TGL_DOK = B.TGL_DOK
				left join (select * from t_job_slip tjs where tjs.JENIS = 'BEHANDLE 1' and STATUS = 'DONE' and KD_STATUS = '50') F
				on F.NO_CONT = A.NO_CONT and F.NO_SPK = C.NO_SPK
				left join t_op_inspection G on G.NO_CONT = A.NO_CONT and G.NO_SPK = C.NO_SPK
				left join (select * from t_job_slip tjs where tjs.JENIS = 'EX BEHANDLE 1' and STATUS = 'DONE' and KD_STATUS = '50') H
				on H.NO_CONT = A.NO_CONT and H.NO_SPK = C.NO_SPK
				left join t_gatepass I on I.NO_CONT = A.NO_CONT and I.NO_SPK = C.NO_SPK
				left join (SELECT t1.*
							FROM t_op_delivery t1
							INNER JOIN (
							    SELECT NO_CONT, NO_SPK, MAX(ID) as max_id
							    FROM t_op_delivery
							    GROUP BY NO_CONT, NO_SPK
							) t2 ON t1.NO_CONT = t2.NO_CONT
							     AND t1.NO_SPK = t2.NO_SPK
							     AND t1.ID = t2.max_id
							) J on J.NO_CONT = A.NO_CONT and J.NO_SPK = C.NO_SPK
				WHERE A.NO_CONT = ? AND A.REF_NUMBER = ?
			";
	
			// Execute the query
			$query = $this->db->query($sql, array($no_cont, $ref_number));
	
			// Check if any rows were returned
			if ($query->num_rows() > 0) {
				// Start building the XML response
				$xml_response = new SimpleXMLElement('<request/>');
				$containers = $xml_response->addChild('containers');
	
				foreach ($query->result() as $row) {
					$container = $containers->addChild('container');
					$container->addChild('reff_number', $row->REF_NUMBER);
					$container->addChild('vessel_name', $row->VESSEL);
					$container->addChild('call_sign', $row->CALL_SIGN);
					$container->addChild('voyage_in', $row->VOY_IN);
					$container->addChild('voyage_out', $row->VOY_OUT);
					$container->addChild('cont_no', $row->NO_CONT);
					$container->addChild('document_type', $row->JNS_DOK);
					$container->addChild('document_no', $row->NO_DOK);
					$container->addChild('document_date', $row->TGL_DOK);
					
					// Add <process> element
					$process = $container->addChild('process', '');
					
					// Check if WK_IN is not empty and add only if it's available
					if (!empty($row->WK_IN)) {
						// Add <in_behandle> with data
						$in_behandle = $process->addChild('in_behandle');
						$in_behandle->addChild('document_type', $row->JNS_DOK);
						$in_behandle->addChild('document_no', $row->NO_DOK);
						$in_behandle->addChild('document_date', $row->TGL_DOK);
						$in_behandle->addChild('actual_time', $row->WK_IN);  // Use WK_IN for actual_time
	
						// Add <stacking_yard_before> with data
						$stacking_yard_before = $process->addChild('stacking_yard_before');
						$stacking_yard_before->addChild('document_type', $row->JNS_DOK);
						$stacking_yard_before->addChild('document_no', $row->NO_DOK);
						$stacking_yard_before->addChild('document_date', $row->TGL_DOK);
						$stacking_yard_before->addChild('actual_time', $row->WK_IN);  // Use WK_IN for actual_time
					}
					if (!empty($row->RESPON_PPK)) {
						// Add <in_behandle> with data
						$in_behandle = $process->addChild('response_ppk');
						$in_behandle->addChild('document_type', $row->JNS_DOK);
						$in_behandle->addChild('document_no', $row->NO_DOK);
						$in_behandle->addChild('document_date', $row->TGL_DOK);
						$in_behandle->addChild('actual_time', $row->RESPON_PPK);  
					}
					if (!empty($row->RESPON_PPK)) {
						// Add <in_behandle> with data
						$in_behandle = $process->addChild('response_ppk');
						$in_behandle->addChild('document_type', $row->JNS_DOK);
						$in_behandle->addChild('document_no', $row->NO_DOK);
						$in_behandle->addChild('document_date', $row->TGL_DOK);
						$in_behandle->addChild('actual_time', $row->RESPON_PPK); 
					}
					if (!empty($row->PLANING_INSPECT_STACK_CIC)) {
						// Add <planning_inspection> with data
						$in_behandle = $process->addChild('planning_inspection');
						$in_behandle->addChild('document_type', $row->JNS_DOK);
						$in_behandle->addChild('document_no', $row->NO_DOK);
						$in_behandle->addChild('document_date', $row->TGL_DOK);
						$in_behandle->addChild('actual_time', $row->PLANING_INSPECT_STACK_CIC);  
						// Add <stacking_cic> with data
						$in_behandle = $process->addChild('stacking_cic');
						$in_behandle->addChild('document_type', $row->JNS_DOK);
						$in_behandle->addChild('document_no', $row->NO_DOK);
						$in_behandle->addChild('document_date', $row->TGL_DOK);
						$in_behandle->addChild('actual_time', $row->PLANING_INSPECT_STACK_CIC);  
					}
					if (!empty($row->START_PERIKSA)) {
						// Add <START_PERIKSA> with data
						$in_behandle = $process->addChild('start_inspection');
						$in_behandle->addChild('document_type', $row->JNS_DOK);
						$in_behandle->addChild('document_no', $row->NO_DOK);
						$in_behandle->addChild('document_date', $row->TGL_DOK);
						$in_behandle->addChild('actual_time', $row->START_PERIKSA); 
					}
					if (!empty($row->FINISH_PERIKSA)) {
						// Add <START_PERIKSA> with data
						$in_behandle = $process->addChild('end_inspection');
						$in_behandle->addChild('document_type', $row->JNS_DOK);
						$in_behandle->addChild('document_no', $row->NO_DOK);
						$in_behandle->addChild('document_date', $row->TGL_DOK);
						$in_behandle->addChild('actual_time', $row->FINISH_PERIKSA); 
					}
					if (!empty($row->MARSHALLING_EX_BEHANDLE)) {
						// Add <START_PERIKSA> with data
						$in_behandle = $process->addChild('stacking_yard_after');
						$in_behandle->addChild('document_type', $row->JNS_DOK);
						$in_behandle->addChild('document_no', $row->NO_DOK);
						$in_behandle->addChild('document_date', $row->TGL_DOK);
						$in_behandle->addChild('actual_time', $row->MARSHALLING_EX_BEHANDLE); 
					}
					if (!empty($row->GATEPASS_OUT)) {
						// Add <START_PERIKSA> with data
						$in_behandle = $process->addChild('gatepass');
						$in_behandle->addChild('document_type', $row->JNS_DOKUMEN_OUT);
						$in_behandle->addChild('document_no', $row->NO_SPPB);
						$in_behandle->addChild('document_date', $row->TGL_SPPB);
						$in_behandle->addChild('actual_time', $row->GATEPASS_OUT); 
					}
					if (!empty($row->TRUCK_OUT)) {
						// Add <START_PERIKSA> with data
						$in_behandle = $process->addChild('out_behandle');
						$in_behandle->addChild('document_type', $row->JNS_DOKUMEN_OUT);
						$in_behandle->addChild('document_no', $row->NO_SPPB);
						$in_behandle->addChild('document_date', $row->TGL_SPPB);
						$in_behandle->addChild('actual_time', $row->TRUCK_OUT); 
					}
				}
	
				// Output the XML response
				header('Content-Type: application/xml');
				echo $xml_response->asXML();
	
			} else {
				// No data found, return empty XML structure
				$xml_response = new SimpleXMLElement('<request/>');
				$xml_response->addChild('status', 'No data found.');
				
				header('Content-Type: application/xml');
				echo $xml_response->asXML();
			}
	
		} else {
			// Invalid or missing XML fields, return error in XML format
			$xml_response = new SimpleXMLElement('<request/>');
			$xml_response->addChild('status', 'Invalid XML input.');
			
			header('Content-Type: application/xml');
			echo $xml_response->asXML();
		}
	}
	public function get_data_relokasi() {
		// Load required helpers and libraries
		$this->load->helper('xml');
		$this->load->database();
	
		// Retrieve raw XML input
		$xml_input = file_get_contents('php://input');
		
		// Parse the XML
		$xml = simplexml_load_string($xml_input);
		if ($xml === false) {
			// Return error response if the XML is invalid
			$response = '<response><status>error</status><message>Invalid XML format</message></response>';
			echo $response;
			return;
		}
	
		// Extract no_dok and no_cont from XML
		$no_dok = (string) $xml->no_dok;
		$no_cont = (string) $xml->no_cont;
	
		// Perform the query with the provided values
		$query = $this->db->query("
			SELECT D.NO_DOK_INOUT AS 'NO_PABEAN', 
				DATE_FORMAT(D.TGL_DOK_INOUT, '%Y%m%d') AS 'TGL_PABEAN', 
				A.NO_CONT, 
				C.UKR_CONT, 
				C.TIPE_CONT, 
				C.KD_CONT_JENIS, 
				D.NO_POS_BC11, 
				D.CONSIGNEE, 
				D.NO_BL_AWB, 
				DATE_FORMAT(D.TGL_BL_AWB, '%Y%m%d') AS 'TGL_BL_AWB', 
				C.VESSEL AS 'NM_ANGKUT', 
				C.VOY_IN AS 'NO_VOY_FLIGHT', 
				DATE_FORMAT(C.DISCHARGE, '%Y%m%d') AS 'TGL_TIBA', 
				D.NO_BC11, 
				DATE_FORMAT(D.TGL_BC11, '%Y%m%d') AS 'TGL_BC11', 
				DATE_FORMAT(E.TGL_TIBA, '%Y%m%d') AS 'TGL_TIBA'
			FROM t_gatepass A
			JOIN t_request B ON A.NO_DOK = B.NO_DOK AND A.TGL_DOK = B.TGL_DOK
			JOIN t_request_cont C ON B.ID = C.ID
			JOIN t_permit_hdr D ON D.NO_DOK_INOUT = A.NO_DOK AND D.TGL_DOK_INOUT = A.TGL_DOK
			JOIN t_cocostshdr E ON E.NM_ANGKUT = C.VESSEL AND E.NO_VOY_FLIGHT = C.VOY_IN
			WHERE A.NO_DOK = ? AND A.NO_CONT = ?", array($no_dok, $no_cont));
	
		// Check if the query returned any results
		if ($query->num_rows() > 0) {
			$result = $query->result_array();
	
			// Prepare the success response
			$xml_response = '<response><status>success</status><data>';
			foreach ($result as $row) {
				$xml_response .= '<record>';
				foreach ($row as $key => $value) {
					$xml_response .= "<$key>$value</$key>";
				}
				$xml_response .= '</record>';
			}
			$xml_response .= '</data></response>';
		} else {
			// No data found response
			$xml_response = '<response><status>not found</status><data></data></response>';
		}
	
		// Set content-type header and return the response as XML
		header('Content-Type: application/xml');
		echo $xml_response;
	}
	public function get_discharge(){
		header('Content-Type: application/xml; charset=utf-8');
        $url    = "https://api.npct1.co.id:9443/api/v1/tracking";
        $user   = "BEHANDLE";
        $key    = "5d3a2ffcb778f4b1c224f2447c048c8f";

            $addXML ='<request> 
            <containers>
                <cont_no>MRKU6663766</cont_no> 
            </containers>
                ';
            $addXML .='</request>
            ';

            $addXML= trim(preg_replace('/\s\s+/', '', str_replace("\n", " ", $addXML)));
            // print_r($addXML);die();
            $curl = curl_init();
            curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
			CURLOPT_SSL_VERIFYPEER => false,
			CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>$addXML,
            CURLOPT_HTTPHEADER => array(
                'User-ID: '.$user,
                'NPCT-API-Key: '.$key,
                'Content-Type: application/xml'
            ),
            ));
            $response = curl_exec($curl);
            if (!curl_errno($curl)) {
				curl_close($curl); 
				echo $response;die;
				// print_r($response);die();
				// var_dump($response);
            }else{
                echo "Connection Failed =".curl_error($curl);
            }

    }
}