<?php defined('BASEPATH') or exit('No direct script access allowed');

class PortalHelpdesk extends CI_Controller
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
		echo $this->load->view("content/portalhelpdesk/index");
	}
	public function delbildel()
	{

		$this->load->database();

		$this->db->select('A.no_dok, A.tgl');
		$this->db->from('solver_req_dokumen_log A');
		$this->db->where('A.tipe', 'delbilstat');
		$this->db->order_by('A.ID', 'desc');
		$query = $this->db->get();

		$data['logs'] = $query->result_array();
		echo $this->load->view("content/portalhelpdesk/deldel", $data, true);
	}
	public function delbilbhd()
	{
		$this->load->database();

		$this->db->select('A.no_dok, A.tgl');
		$this->db->from('solver_req_dokumen_log A');
		$this->db->where('A.tipe', 'delbilstab');
		$this->db->order_by('A.ID', 'desc');
		$query = $this->db->get();

		$data['logs'] = $query->result_array();
		echo $this->load->view("content/portalhelpdesk/delbhd", $data, true);
	}

	// fungsinya
	//delivery
	public function getdelivery()
	{
		// Get NO_DOK_INOUT from POST request (from the frontend JavaScript)
		$no_dok_inout = $this->input->post('no_dok_inout');

		// Run the query
		$this->db->select('A.ID, A.NO_DOK_INOUT, A.TGL_DOK_INOUT, B.NO_CONT, B.KD_STATUS_BIL, B.WK_STATUS_BIL');
		$this->db->from('t_permit_hdr A');
		$this->db->join('t_permit_cont B', 'A.ID = B.ID');
		$this->db->where('A.NO_DOK_INOUT', $no_dok_inout);
		$query = $this->db->get();

		// Check if there is any result
		if ($query->num_rows() > 0) {
			$result = $query->result_array();  // Fetch the data as an array
		} else {
			$result = array();  // Return an empty array if no result
		}

		// Return the data as JSON
		echo json_encode($result);
	}

	public function prosesdel()
	{
		// Get the ID and NO_DOK_INOUT from the POST request
		$id = $this->input->post('id');
		$no_dok_inout = $this->input->post('no_dok_inout'); // Retrieve NO_DOK_INOUT

		// Load the database model (if you haven't loaded it globally)
		$this->load->database();

		// Ensure ID is provided
		if ($id) {
			// Prepare the update query
			$this->db->set('WK_STATUS_BIL', null);
			$this->db->set('KD_STATUS_BIL', null);
			$this->db->where('ID', $id);
			$result = $this->db->update('t_permit_cont');

			// Check if the update was successful
			if ($result) {
				$log_data = array(
					'tipe' => 'delbilstat',
					'no_dok' => $no_dok_inout,
					'tgl' => date('Y-m-d H:i:s') // Current date and time
				);
				$this->db->insert('solver_req_dokumen_log', $log_data);

				echo json_encode(array('status' => 'success', 'message' => 'Status billing berhasil dihapus.'));
			} else {
				// Respond with a failure message
				echo json_encode(array('status' => 'error', 'message' => 'Gagal menghapus status billing.'));
			}

		} else {
			// Respond with an error if ID is not provided
			echo json_encode(array('status' => 'error', 'message' => 'ID tidak ditemukan.'));
		}
	}
	//behandle
	public function getbehandle()
	{
		// Get NO_DOK_INOUT from POST request (from the frontend JavaScript)
		$no_dok_inout = $this->input->post('no_dok_inout');

		// Run the query
		$this->db->select('A.ID, A.NO_DOK, A.TGL_DOK, A.NO_CONT, A.FL_BIL');
		$this->db->from('t_gatepass A');
		$this->db->where('A.NO_DOK', $no_dok_inout); // Use NO_DOK instead of NO_DOK_INOUT
		$query = $this->db->get();

		// Check if there is any result
		if ($query->num_rows() > 0) {
			$result = $query->result_array();  // Fetch the data as an array
		} else {
			$result = array();  // Return an empty array if no result
		}

		// Return the data as JSON
		echo json_encode($result);
	}
	public function prosesbhd()
	{
		$tgl_dok = $this->input->post('tgl');
		$no_dok = $this->input->post('no_dok');

		$this->load->database();

		if ($no_dok) {

			$this->db->set('FL_BIL', null);
			$this->db->where('NO_DOK', $no_dok);
			$this->db->where('TGL_DOK', $tgl_dok);
			$result = $this->db->update('t_gatepass');

			// Check if the update was successful
			if ($result) {
				$log_data = array(
					'tipe' => 'delbilstab',
					'no_dok' => $no_dok,
					'tgl' => date('Y-m-d H:i:s')
				);
				$this->db->insert('solver_req_dokumen_log', $log_data);

				echo json_encode(array('status' => 'success', 'message' => 'Status billing berhasil dihapus.'));
			} else {
				// Respond with a failure message
				echo json_encode(array('status' => 'error', 'message' => 'Gagal menghapus status billing.'));
			}
		} else {
			// Respond with an error if ID is not provided
			echo json_encode(array('status' => 'error', 'message' => 'ID tidak ditemukan.'));
		}
	}
	// update waktu in dan pickup
	public function updatewkinnpck()
	{
		// Retrieve the input values from the GET request
		$no_container = $this->input->get('no_container');
		$no_spk = $this->input->get('no_spk');

		// Initialize an empty array for results
		$data['results'] = array();

		// Run the query if both inputs are provided
		if ($no_container && $no_spk) {
			$this->db->select('A.NO_SPK, A.NO_DOK, A.TGL_DOK, B.NO_CONT, C.WK_PICKUP, C.WK_IN');
			$this->db->from('t_spk A');
			$this->db->join('t_spk_cont B', 'A.ID = B.ID');
			$this->db->join('t_operation C', 'A.NO_SPK = C.NO_SPK AND B.NO_CONT = C.NO_CONT');
			$this->db->where('A.NO_SPK', $no_spk);
			$this->db->where('B.NO_CONT', $no_container);
			$query = $this->db->get();

			// Store the results in the data array
			if ($query->num_rows() > 0) {
				$data['results'] = $query->result_array();
			}
		}

		echo $this->load->view("content/portalhelpdesk/updatepickupdanin", $data, true);
	}
	public function updatePickupAndBehandle()
	{
		// Capture the data from the POST request
		$no_spk = $this->input->post('no_spk');
		$no_cont = $this->input->post('no_cont');
		$pickup = $this->input->post('wk_pickup');
		$behandle = $this->input->post('wk_in');

		// Load the database model (if not loaded globally)
		$this->load->database();

		// Perform the updates
		$this->db->set('W_PICKUP', $pickup);
		$this->db->where('NO_SPK', $no_spk);
		$this->db->where('NO_CONT', $no_cont);
		$this->db->update('t_op_pickup');

		$this->db->set('W_BEHANDLE', $behandle);
		$this->db->where('NO_SPK', $no_spk);
		$this->db->where('NO_CONT', $no_cont);
		$this->db->update('t_op_behandlein');

		$this->db->set('WK_PICKUP', $pickup);
		$this->db->set('WK_IN', $behandle);
		$this->db->where('NO_SPK', $no_spk);
		$this->db->where('NO_CONT', $no_cont);
		$this->db->update('t_operation');

		$this->db->set('PRN_PICKUP', $pickup);
		$this->db->set('PRN_BEHANDLE_IN', $behandle);
		$this->db->where('RB1_NO_SPK', $no_spk);
		$this->db->where('NO_CONT', $no_cont);
		$this->db->update('report_behandle');

		echo json_encode(array('status' => 'success', 'message' => 'Data updated successfully.'));
	}
	public function clearing()
	{
		$data = array();

		// Check if the 'no_dok' parameter is set in the GET request
		if ($this->input->get('no_dok')) {
			$no_dok = $this->input->get('no_dok');

			// Prepare the SQL query
			$query = "SELECT A.ID_REQ as 'NOTA', A.SAP_TGL_PELUNASAN FROM (
						SELECT rdh.ID_REQ, b.SAP_TGL_PELUNASAN 
						FROM req_delivery_hdr rdh 
						JOIN t_log_kode_bayar_sap b ON rdh.ID_REQ = b.PROFORMA
						WHERE rdh.NO_DOK = ? 
						
						UNION
						
						SELECT e.ID_REQ, f.SAP_TGL_PELUNASAN 
						FROM req_delivery_hdr rdh 
						JOIN t_log_kode_bayar_sap b ON rdh.ID_REQ = b.PROFORMA
						JOIN t_gatepass c ON c.NO_DOK = rdh.NO_DOK AND c.TGL_DOK = rdh.TGL_DOK
						JOIN t_spk d ON c.NO_SPK = d.NO_SPK
						JOIN req_behandle_hdr e ON e.NO_DOK = d.NO_DOK AND e.TGL_DOK = d.TGL_DOK
						JOIN t_log_kode_bayar_sap f ON e.ID_REQ = f.PROFORMA
						WHERE rdh.NO_DOK = ?
					  ) A";

			// Execute the query using CodeIgniter's database query builder
			$results = $this->db->query($query, array($no_dok, $no_dok))->result_array();
			$data['results'] = $results; // Pass the results to the view
		}

		echo $this->load->view("content/portalhelpdesk/clearing", $data, true);
	}
	public function prosesclearing()
	{
		$action = $this->input->post('action');
		$proforma = $this->input->post('proforma');

		if ($action && $proforma) {
			if ($action == 'clearing') {

				$this->db->set('SAP_TGL_PELUNASAN', date('Y-m-d H:i:s'));
				$this->db->where('PROFORMA', $proforma);
				$result = $this->db->update('t_log_kode_bayar_sap');

				if ($result) {
					echo json_encode(array('status' => 'success', 'message' => 'Clearing manual berhasil.'));
				} else {
					echo json_encode(array('status' => 'error', 'message' => 'Gagal melakukan clearing manual.'));
				}
			} elseif ($action == 'hapus') {
				$this->db->where('PROFORMA', $proforma);
				$result = $this->db->delete('t_log_kode_bayar_sap');

				if ($result) {
					echo json_encode(array('status' => 'success', 'message' => 'Data berhasil dihapus.'));
				} else {
					echo json_encode(array('status' => 'error', 'message' => 'Gagal menghapus data.'));
				}
			} else {
				echo json_encode(array('status' => 'error', 'message' => 'Aksi tidak dikenali.'));
			}
		} else {
			echo json_encode(array('status' => 'error', 'message' => 'Data tidak lengkap.'));
		}
	}
	// resend autogate
	public function sendcustomdatamanual()
	{
		$container_id = $this->input->get('container_id');
		$data = array();

		if ($container_id) {
			$query = $this->db->query("
				SELECT TRANSACTION_ID ,CONTAINER_ID, CONTAINER_SIZE, VESSEL_NAME, VOYAGE, DOCUMENT_NO, DOCUMENT_DATE, REMAKS
				FROM t_autogate_send_customs
				WHERE CONTAINER_ID = ?", array($container_id));

			$data['results'] = $query->result_array(); // Fetch the result as an array
		} else {
			$data['results'] = array(); // No results if no search
		}

		echo $this->load->view("content/portalhelpdesk/resendautogate", $data, true);
	}
	public function resendcustomdata()
	{
		$transaction_id = $this->input->post('transaction_id');

		if (empty($transaction_id)) {
			echo json_encode(array('status' => 'error', 'message' => 'TRANSACTION ID is required'));
			return;
		}

		// Prepare the query with the container ID
		$q = $this->db->query("SELECT * FROM t_autogate_send_customs A WHERE A.TRANSACTION_ID = ?", array($transaction_id));

		if ($q->num_rows() == 0) {
			echo json_encode(array('status' => 'error', 'message' => 'No data found for the specified Transaction ID'));
			return;
		}

		foreach ($q->result() as $value1) {
			// Variables preparation (from your existing script)
			$ID = $value1->TRANSACTION_ID;
			$TRANSACTION_ID = $value1->TRANSACTION_ID . "/BHD";
			$CONTAINER_ID = $value1->CONTAINER_ID;
			$VOYAGE = $value1->VOYAGE;
			$VESSEL_NAME = $value1->VESSEL_NAME;
			$CONTAINER_SIZE = $value1->CONTAINER_SIZE;
			$ISO_CODE = $value1->ISO_CODE;
			$TERMINAL_ID = $value1->TERMINAL_ID;
			$TERMINAL_TRANSACTION_TYPE = $value1->TERMINAL_TRANSACTION_TYPE;
			$DOCUMENT_TYPE = $value1->DOCUMENT_TYPE;
			$DOCUMENT_NO = $value1->DOCUMENT_NO;
			$FORMAT_DOC_DATE = date('Ymd', strtotime($value1->DOCUMENT_DATE));
			$DOCUMENT_DATE = $FORMAT_DOC_DATE;
			$FULL_EMPTY = $value1->FULL_EMPTY;
			$PORT_LOADING = $value1->PORT_LOADING;
			$PORT_DISCHARGE = $value1->PORT_DISCHARGE;
			$ATB = $value1->ATB;
			$ETD = $value1->ETD;
			$BC11_NO = $value1->BC11_NO;
			$FORMAT_BC11_DATE = date('Ymd', strtotime($value1->BC11_DATE));
			$BC11_DATE = $FORMAT_BC11_DATE;
			$BL_NO = $value1->BL_NO;
			$AUTO_HOLD = $value1->AUTO_HOLD;
			$CONSIGNEE = htmlspecialchars($value1->CONSIGNEE);
			$KPBC_CODE = $value1->KPBC_CODE;
			$BRUTO = $value1->BRUTO;

			// XML generation
			$xml = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:tem="http://tempuri.org/">
				<soapenv:Header/>
				<soapenv:Body>
					<tem:SendCustomsData>
						<tem:TRANSACTIONID>' . $TRANSACTION_ID . '</tem:TRANSACTIONID>
						<tem:CONTAINERID>' . $CONTAINER_ID . '</tem:CONTAINERID>
						<tem:VOYAGE>' . $VOYAGE . '</tem:VOYAGE>
						<tem:VESSELNAME>' . $VESSEL_NAME . '</tem:VESSELNAME>
						<tem:CONTAINERSIZE>' . $CONTAINER_SIZE . '</tem:CONTAINERSIZE>
						<tem:ISOCODE>' . $ISO_CODE . '</tem:ISOCODE>
						<tem:TERMINALID>' . $TERMINAL_ID . '</tem:TERMINALID>
						<tem:TERMINALTRANSACTIONTYPE>' . $TERMINAL_TRANSACTION_TYPE . '</tem:TERMINALTRANSACTIONTYPE>
						<tem:DOCUMENTTYPE>' . $DOCUMENT_TYPE . '</tem:DOCUMENTTYPE>
						<tem:DOCUMENTNBR>' . $DOCUMENT_NO . '</tem:DOCUMENTNBR>
						<tem:DOCUMENTDATE>' . $DOCUMENT_DATE . '</tem:DOCUMENTDATE>
						<tem:FULLEMPTYINDR>' . $FULL_EMPTY . '</tem:FULLEMPTYINDR>
						<tem:PORTLOADING>' . $PORT_LOADING . '</tem:PORTLOADING>
						<tem:PORTDISCHARGE>' . $PORT_DISCHARGE . '</tem:PORTDISCHARGE>
						<tem:ATB>' . $ATB . '</tem:ATB>
						<tem:ETD>' . $ETD . '</tem:ETD>
						<tem:BC11NBR>' . $BC11_NO . '</tem:BC11NBR>
						<tem:BC11DATE>' . $BC11_DATE . '</tem:BC11DATE>
						<tem:BLNBR>' . $BL_NO . '</tem:BLNBR>
						<tem:AUTOHOLD>' . $AUTO_HOLD . '</tem:AUTOHOLD>
						<tem:CONSIGNEE>' . $CONSIGNEE . '</tem:CONSIGNEE>
						<tem:KPBCCODE>' . $KPBC_CODE . '</tem:KPBCCODE>
						<tem:BRUTTOWEIGHTS>' . $BRUTO . '</tem:BRUTTOWEIGHTS>
					</tem:SendCustomsData>
				</soapenv:Body>
			</soapenv:Envelope>'; 
			
			// Send SOAP request via CURL
			$curl = curl_init();
			curl_setopt_array($curl, array(
				CURLOPT_URL => 'https://cusmod-ca.multiterminal.co.id/customsrepo/CustomsDataRepositoryWebService.asmx',
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_POST => true,
				CURLOPT_SSL_VERIFYHOST => false,
				CURLOPT_SSL_VERIFYPEER => false,
				CURLOPT_POSTFIELDS => $xml,
				CURLOPT_HTTPHEADER => array('Content-Type: text/xml;charset=UTF-8'),
			));
			$response = curl_exec($curl);
			curl_close($curl);

			// Parse response
			$raw_response = str_replace(
				array('<?xml version="1.0" encoding="utf-8"?><soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema"><soap:Body><SendCustomsDataResponse xmlns="http://tempuri.org/"><SendCustomsDataResult><Message>', '</Message></SendCustomsDataResult></SendCustomsDataResponse></soap:Body></soap:Envelope>'),
				'',
				$response
			);

			// Update database based on response
			if (strpos($raw_response, 'OK') !== false) {
				$this->db->query("UPDATE t_autogate_send_customs SET FL_SEND = 'Y', SEND_DATE = NOW(), REMAKS = ? WHERE TRANSACTION_ID = ?", array($raw_response, $value1->TRANSACTION_ID));
				echo json_encode(array('status' => 'success', 'message' => 'Resend successful: ' . $raw_response));
			} else {
				$this->db->query("UPDATE t_autogate_send_customs SET FL_SEND = 'E', SEND_DATE = NOW(), REMAKS = ? WHERE TRANSACTION_ID = ?", array($raw_response, $value1->TRANSACTION_ID));
				echo json_encode(array('status' => 'error', 'message' => 'Resend failed: ' . $raw_response));
			}
		}
	}

	public function set_announce()
	{
		$container_id = $this->input->get('container_id');
		$data = array();

		if ($container_id) {
			$query = $this->db->query("
				select A.NO_SPK, B.NO_CONT, C.KETERANGAN , B.LOKASI
				from t_spk A 
				join t_spk_cont B on A.ID = B.ID
				join reff_status_spk C on B.STATUS_CONT = C.ID 
				where B.NO_CONT = ?", array($container_id));

			$data['results'] = $query->result_array(); // Fetch the result as an array
		} else {
			$data['results'] = array(); // No results if no search
		}

		echo $this->load->view("content/portalhelpdesk/set_announce", $data, true);
	}

	public function tes()
	{
		$all_data = $this->session->all_userdata();
		print_r($all_data);
	}

	public function xmltes()
	{
		// Sample XML string (you may load this from a file instead)
		$xmlString = "<GETCONTAINERPERIKSA>
    <LOOP>
        <KODE_RESPONSE>005</KODE_RESPONSE>
        <URAIAN_RESPONSE>INSW - JOINT INSPECTION</URAIAN_RESPONSE>
        <NO_AJU>201201C01D7D20241008000315</NO_AJU>
        <TGL_AJU>2024-10-08</TGL_AJU>
        <IMP>
            <ID>030794242009000</ID>
            <NAMA>PT SURI NUSANTARA JAYA</NAMA>
            <ALAMAT>GEDUNG GRAHA KOMANDO LT.3 JL CIPINANG INDAH RAYA, Nomor 1, RT 001, RW 013</ALAMAT>
            <PJAWAB>
                <NAMA>DIMAS WIBOWO</NAMA>
                <JABATAN>DIREKTUR</JABATAN>
                <ALAMAT>JL. SEPAKAT IX KOTA JAKTIM</ALAMAT>
                <TELP>02184310583</TELP>
                <EMAIL>importbeef@surinusantara.com</EMAIL>
            </PJAWAB>
            <PPJK>
                <IDPPJK>null</IDPPJK>
                <NMPPJK>null</NMPPJK>
                <ALPPJK>null</ALPPJK>
            </PPJK>
        </IMP>
        <JML_CONTAINER>1</JML_CONTAINER>
        <JML_CONTAINER_PERIKSA>1</JML_CONTAINER_PERIKSA>
        <TRANSPORT>
            <LIST>
                <MODA>1</MODA>
                <NOMOR>MA435R</NOMOR>
                <KODE_TERMINAL>NPCT1</KODE_TERMINAL>
                <NAMA>MSC JUSTICE VIII</NAMA>
                <TGL_TIBA>2024-10-09</TGL_TIBA>
                <CONTLIST>
                    <CONTAINER>
                        <NOCONT>TTNU8084623</NOCONT>
                        <NOSEAL>null</NOSEAL>
                        <TPCONT>5</TPCONT>
                        <UKCONT>40</UKCONT>
                        <FLPERIKSA>true</FLPERIKSA>
                    </CONTAINER>
                </CONTLIST>
            </LIST>
        </TRANSPORT>
        <INSTANSI>
            <LOOP>
                <INSTANSI>07</INSTANSI>
                <KODE_KANTOR>040300</KODE_KANTOR>
                <NAMA_KANTOR>KPU TANJUNG PRIOK</NAMA_KANTOR>
                <NO_DOC>621267/KPU.1/2024</NO_DOC>
                <TGL_DOC>2024-10-14</TGL_DOC>
                <JNS_DOC>null</JNS_DOC>
                <RISK_LEVEL/>
                <CONTAINER_LIST>
                    <CONTLIST_LOOP>
                        <NOCONTAINER>TTNU8084623</NOCONTAINER>
                        <FLAGPERIKSA>true</FLAGPERIKSA>
                    </CONTLIST_LOOP>
                </CONTAINER_LIST>
            </LOOP>
            <LOOP>
                <INSTANSI>03</INSTANSI>
                <KODE_KANTOR>3100</KODE_KANTOR>
                <NAMA_KANTOR>Balai Besar Karantina Hewan, Ikan, dan Tumbuhan DKI Jakarta - UPT Induk</NAMA_KANTOR>
                <NO_DOC>2024-H2.0-3100.0-K.3.10-000332</NO_DOC>
                <TGL_DOC>2024-10-12</TGL_DOC>
                <JNS_DOC>03204</JNS_DOC>
                <RISK_LEVEL>M</RISK_LEVEL>
                <CONTAINER_LIST/>
            </LOOP>
        </INSTANSI>
    </LOOP>
</GETCONTAINERPERIKSA>";
		// Load the XML into SimpleXML
		$xml = simplexml_load_string($xmlString);

		// Extract main information
		echo "KODE RESPONSE: " . $xml->LOOP->KODE_RESPONSE . PHP_EOL;
		echo "URAIAN RESPONSE: " . $xml->LOOP->URAIAN_RESPONSE . PHP_EOL;
		echo "NO AJU: " . $xml->LOOP->NO_AJU . PHP_EOL;
		echo "TGL AJU: " . $xml->LOOP->TGL_AJU . PHP_EOL;

		// Extract importer information
		$importer = $xml->LOOP->IMP;
		echo "IMPORTER ID: " . $importer->ID . PHP_EOL;
		echo "IMPORTER NAME: " . $importer->NAMA . PHP_EOL;
		echo "IMPORTER ADDRESS: " . $importer->ALAMAT . PHP_EOL;

		// Extract person in charge
		$pjawab = $importer->PJAWAB;
		echo "PERSON IN CHARGE NAME: " . $pjawab->NAMA . PHP_EOL;
		echo "POSITION: " . $pjawab->JABATAN . PHP_EOL;
		echo "CONTACT EMAIL: " . $pjawab->EMAIL . PHP_EOL;

		// Extract transport details
		$transport = $xml->LOOP->TRANSPORT->LIST;
		echo "MODA: " . $transport->MODA . PHP_EOL;
		echo "TRANSPORT NUMBER: " . $transport->NOMOR . PHP_EOL;
		echo "TERMINAL CODE: " . $transport->KODE_TERMINAL . PHP_EOL;
		echo "SHIP NAME: " . $transport->NAMA . PHP_EOL;
		echo "ARRIVAL DATE: " . $transport->TGL_TIBA . PHP_EOL;

		// Extract container information
		$container = $transport->CONTLIST->CONTAINER;
		echo "CONTAINER NO: " . $container->NOCONT . PHP_EOL;
		echo "CONTAINER SIZE: " . $container->UKCONT . PHP_EOL;
		echo "INSPECTION FLAG: " . $container->FLPERIKSA . PHP_EOL;

		// Extract instance information
		foreach ($xml->LOOP->INSTANSI->LOOP as $instansi) {
			echo "INSTANSI: " . $instansi->INSTANSI . PHP_EOL;
			echo "OFFICE CODE: " . $instansi->KODE_KANTOR . PHP_EOL;
			echo "OFFICE NAME: " . $instansi->NAMA_KANTOR . PHP_EOL;
			echo "DOCUMENT NO: " . $instansi->NO_DOC . PHP_EOL;
			echo "DOCUMENT DATE: " . $instansi->TGL_DOC . PHP_EOL;
			echo "RISK LEVEL: " . ($instansi->RISK_LEVEL . 'N/A') . PHP_EOL;

			if (isset($instansi->CONTAINER_LIST->CONTLIST_LOOP)) {
				foreach ($instansi->CONTAINER_LIST->CONTLIST_LOOP as $containerLoop) {
					echo "CONTAINER NO: " . $containerLoop->NOCONTAINER . PHP_EOL;
					echo "INSPECTION FLAG: " . $containerLoop->FLAGPERIKSA . PHP_EOL;
				}
			}
			echo PHP_EOL;
		}
	}

	public function soaptes()
	{
		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => 'https://api.insw.go.id/webservice-prod/ssm-qc',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_POSTFIELDS => '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ser="http://services.insw.go.id/">
   <soapenv:Header/>
   <soapenv:Body>
      <ser:getContainerPeriksaOnRequest>
         <!--Optional:-->
         <USERNAME>wster3</USERNAME>
         <!--Optional:-->
         <PASSWORD>pass123abc</PASSWORD>
         <!--Optional:-->
         <INSTANSI></INSTANSI>
         <!--Optional:-->
         <NO_AJU>201201768F3420241007000011</NO_AJU>
         <!--Optional:-->
         <TGL_AJU></TGL_AJU>
         <!--Optional:-->
         <NO_DOC></NO_DOC>
         <!--Optional:-->
         <TGL_DOC></TGL_DOC>
         <!--Optional:-->
         <JNS_DOC></JNS_DOC>
         <!--Optional:-->
         <kd_tps></kd_tps>
      </ser:getContainerPeriksaOnRequest>
   </soapenv:Body>
</soapenv:Envelope>',
			CURLOPT_HTTPHEADER => array(
				'Content-Type: text/xml',
				'Cookie: cookiesession1=678B290315F62F94957606533A5D4D91'
			),
		));

		$response = curl_exec($curl);

		curl_close($curl);

		// Load the SOAP response
		$soapResponse = simplexml_load_string($response);

		// Use xpath to find the 'result' element
		$resultArray = $soapResponse->xpath('//result');
		if (!empty($resultArray)) {
			$resultXml = $resultArray[0];  // Access the first result
		} else {
			$resultXml = '';  // Handle case if result is not found
		}

		// Decode the XML entities (like &lt;, &gt;)
		$decodedXml = html_entity_decode($resultXml);

		// Load the decoded XML as SimpleXMLElement to work with it
		$xml = simplexml_load_string($decodedXml);

		// Output the decoded XML
		// echo '<textarea rows="20" cols="100">' . htmlspecialchars($decodedXml) . '</textarea>';

		echo $decodedXml;
	}

	public function ssmnpct(){
		$url    = "https://api.npct1.co.id:9443/api/v1/setSSMOnDemand	";
                $user   = "BEHANDLE";
                $key    = "5d3a2ffcb778f4b1c224f2447c048c8f";
                $addXML ='<request>    
        					<request_no>201201768F3420241007000011</request_no>
						  </request>';

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
                    $info = curl_getinfo($curl);
                    echo "Connection Success , This is Url : ", $info['url'], "<br>\r\n";
                }else{
                    echo "Connection Failed =".curl_error($curl);
                }
                curl_close($curl); 
                $xml1 = str_replace('<?xml version="1.0"?>',"",$response);
				echo $response;
	}

	public function tesquery(){
		$REQ = 'DEL154150';
		$sub_total = $this->db->query("SELECT SUM(TOTAL) AS TOTAL FROM req_delivery_dtl WHERE ID_REQ = '$REQ'")->row()->TOTAL;
		$ppn_value = $this->db->query("SELECT TARIF FROM m_tarif2 WHERE JENIS_BIAYA = 'PPN' LIMIT 1")->row()->TARIF;
		// $PPN = $sub_total * ($ppn_value / 100);
		$PPN = $sub_total * 0.11;
		echo $PPN;
	}

	// public function tesitung()
	// {
	// 	// Hardcoded $REQ for demonstration
	// 	$REQ = 'BHD124145'; // Replace with the actual value as needed
	
	// 	// Define the number of seals being charged
	// 	$numSeals = 3; // Change this value to the number of seals (e.g., 2, 3, etc.)
	
	// 	// Fetch the seal tariff
	// 	$sealTariffQuery = $this->db->query("SELECT TARIF FROM m_tarif WHERE JENIS_BIAYA = 'SEAL'");
	// 	$sealTariff = $sealTariffQuery->row();
	// 	$seal = 0; // Initialize seal in case it was undefined
	// 	$seal += isset($sealTariff->TARIF) ? $sealTariff->TARIF * $numSeals : 0;
	
	// 	// Fetch the subtotal from the details table
	// 	$subTotal1Query = $this->db->query("SELECT SUM(TOTAL) AS TOTAL FROM req_behandle_dtl WHERE ID_REQ = '$REQ'");
	// 	$subTotal1Row = $subTotal1Query->row();
	// 	$subTotal1 = isset($subTotal1Row->TOTAL) ? $subTotal1Row->TOTAL : 0;
	
	// 	// Fetch the administration fee
	// 	$adminFeeQuery = $this->db->query("SELECT TARIF FROM m_tarif WHERE JENIS_BIAYA = 'ADMINISTRASI'");
	// 	$adminFeeRow = $adminFeeQuery->row();
	// 	$adminFee = isset($adminFeeRow->TARIF) ? $adminFeeRow->TARIF : 0;
	
	// 	// Calculate the adjusted subtotal
	// 	$adjustedSubTotal = $subTotal1 + $adminFee + $seal;
	
	// 	// Calculate PPN (tax) at 11%
	// 	$tax = $adjustedSubTotal * 0.11;
	
	// 	// Calculate the total after adding PPN
	// 	$totalAfterTax = $adjustedSubTotal + $tax;
	
	// 	// Determine MAT fee based on the threshold
	// 	$MAT = ($totalAfterTax > 5000000) ? 10000 : 0;
	
	// 	// Calculate the final total
	// 	$finalTotal = $totalAfterTax + $MAT;
	
	// 	// Prepare JSON output
	// 	// $output = [
	// 	// 	'REQ' => $REQ,
	// 	// 	'numSeals' => $numSeals,
	// 	// 	'sealTariffPerSeal' => isset($sealTariff->TARIF) ? $sealTariff->TARIF : 0,
	// 	// 	'totalSealTariff' => $seal,
	// 	// 	'subtotal1' => $subTotal1,
	// 	// 	'adminFee' => $adminFee,
	// 	// 	'adjustedSubtotal' => $adjustedSubTotal,
	// 	// 	'taxPPN' => $tax,
	// 	// 	'totalAfterTax' => $totalAfterTax,
	// 	// 	'MATFee' => $MAT,
	// 	// 	'finalTotal' => $finalTotal,
	// 	// ];
	
	// 	// Output JSON
	// 	header('Content-Type: application/json');
	// 	echo json_encode($output);
	// }
	
}