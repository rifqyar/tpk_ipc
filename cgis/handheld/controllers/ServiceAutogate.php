<?php defined('BASEPATH') or exit('No direct script access allowed');

class ServiceAutogate extends CI_Controller
{
    public $content;
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_home');
    }

    public function sendcustomdata(){
        $q = $this->db->query("SELECT * FROM t_autogate_send_customs 
            WHERE FL_SEND IN ('N','E') 
            -- WHERE TRANSACTION_ID ='363049'
            ORDER BY TRANSACTION_ID DESC
            LIMIT 50");

        foreach ($q->result() as $key => $value1) {
            echo 'sending ' . $value1->TRANSACTION_ID .' to autogate';
            echo "\r\n";
                $curl = curl_init();

                curl_setopt_array($curl, array(
                  CURLOPT_URL => 'https://cusmod-ca.multiterminal.co.id/customsrepo/CustomsDataRepositoryWebService.asmx',
                  CURLOPT_RETURNTRANSFER => true,
                  CURLOPT_ENCODING => '',
                  CURLOPT_MAXREDIRS => 10,
                  CURLOPT_TIMEOUT => 0,
                  CURLOPT_FOLLOWLOCATION => true,
                  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                  CURLOPT_CUSTOMREQUEST => 'POST',
                  CURLOPT_POSTFIELDS =>'<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:tem="http://tempuri.org/">
                   <soapenv:Header/>
                   <soapenv:Body>
                      <tem:SendCustomsData>
                             <!--Optional:-->
                             <tem:TRANSACTIONID>' . $value1->TRANSACTION_ID . '/BHD</tem:TRANSACTIONID>
                             <!--Optional:-->
                             <tem:CONTAINERID>' . $value1->CONTAINER_ID . '</tem:CONTAINERID>
                             <!--Optional:-->
                             <tem:VOYAGE>' . $value1->VOYAGE . '</tem:VOYAGE>
                             <!--Optional:-->
                             <tem:VESSELNAME>' . $value1->VESSEL_NAME . '</tem:VESSELNAME>
                             <!--Optional:-->
                             <tem:CONTAINERSIZE>' . $value1->CONTAINER_SIZE . '</tem:CONTAINERSIZE>
                             <!--Optional:-->
                             <tem:ISOCODE>' . $value1->ISO_CODE . '</tem:ISOCODE>
                             <!--Optional:-->
                             <tem:TERMINALID>' . $value1->TERMINAL_ID . '</tem:TERMINALID>
                             <!--Optional:-->
                             <tem:TERMINALTRANSACTIONTYPE>' . $value1->TERMINAL_TRANSACTION_TYPE . '</tem:TERMINALTRANSACTIONTYPE>
                             <!--Optional:-->
                             <tem:DOCUMENTTYPE>'. $value1->DOCUMENT_TYPE .'</tem:DOCUMENTTYPE>
                             <!--Optional:-->
                             <tem:DOCUMENTNBR>' . $value1->DOCUMENT_NO . '</tem:DOCUMENTNBR>
                             <!--Optional:-->
                             <tem:DOCUMENTDATE>'.$value1->DOCUMENT_DATE.'</tem:DOCUMENTDATE>
                             <!--Optional:-->
                             <tem:FULLEMPTYINDR>' . $value1->FULL_EMPTY . '</tem:FULLEMPTYINDR>
                             <!--Optional:-->
                             <tem:PORTLOADING>' . $value1->PORT_LOADING . '</tem:PORTLOADING>
                             <!--Optional:-->
                             <tem:PORTDISCHARGE>' . $value1->PORT_DISCHARGE . '</tem:PORTDISCHARGE>
                             <!--Optional:-->
                             <tem:ATB>' . $value1->ATB . '</tem:ATB>
                             <!--Optional:-->
                             <tem:ETD>' . $value1->ETD . '</tem:ETD>
                             <!--Optional:-->
                             <tem:BC11NBR>' . $value1->BC11_NO . '</tem:BC11NBR>
                             <!--Optional:-->
                             <tem:BC11DATE>'.$value1->BC11_DATE.'</tem:BC11DATE>
                             <!--Optional:-->
                             <tem:BLNBR>' . $value1->BL_NO . '</tem:BLNBR>
                             <!--Optional:-->
                             <tem:AUTOHOLD>' . $value1->AUTO_HOLD . '</tem:AUTOHOLD>
                             <!--Optional:-->
                             <tem:CONSIGNEE>' . $value1->CONSIGNEE . '</tem:CONSIGNEE>
                             <!--Optional:-->
                             <tem:KPBCCODE>' . $value1->KPBC_CODE . '</tem:KPBCCODE>
                             <!--Optional:-->
                             <tem:BRUTTOWEIGHTS>' . $value1->BRUTO . '</tem:BRUTTOWEIGHTS>
                          </tem:SendCustomsData>
                   </soapenv:Body>
                </soapenv:Envelope>',
                  CURLOPT_HTTPHEADER => array(
                    'Content-Type: text/xml;charset=UTF-8'
                  ),
                ));
                
                $response = curl_exec($curl);

                curl_close($curl);
                $xml1 = str_replace('<?xml version="1.0" encoding="utf-8"?><soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema"><soap:Body><SendCustomsDataResponse xmlns="http://tempuri.org/"><SendCustomsDataResult><Message>',"",$response);
                $raw_response = str_replace('</Message></SendCustomsDataResult></SendCustomsDataResponse></soap:Body></soap:Envelope>',"",$xml1);
                // echo $raw_response;

                if (strpos($raw_response, 'OK') !== false) {
                    $SQL = "UPDATE t_autogate_send_customs SET FL_SEND = 'Y', SEND_DATE = NOW(), REMAKS = '$raw_response' WHERE TRANSACTION_ID='$value1->TRANSACTION_ID'";
                    $this->db->query($SQL);
                    echo $raw_response;
                    echo "\r\n";
                } else {
                    $SQL = "UPDATE t_autogate_send_customs SET FL_SEND = 'E', SEND_DATE = NOW(), REMAKS = '$raw_response' WHERE TRANSACTION_ID='$value1->TRANSACTION_ID'";
                    $this->db->query($SQL);
                    echo $raw_response;
                    echo "\r\n";
                }
        }

    }

    public function sendcustomdatadev(){
        $q = $this->db->query("SELECT * FROM t_autogate_send_customs 
            WHERE FL_SEND IN ('N','E') 
            -- WHERE TRANSACTION_ID ='365232'
            ORDER BY TRANSACTION_ID DESC
            LIMIT 50");

        foreach ($q->result() as $key => $value1) {
            $ID = $value1->TRANSACTION_ID;
			$TRANSACTION_ID = $value1->TRANSACTION_ID."/BHD";
			$CONTAINER_ID = $value1->CONTAINER_ID;
			$VOYAGE = $value1->VOYAGE;
			$VESSEL_NAME = $value1->VESSEL_NAME;
			$CONTAINER_SIZE = $value1->CONTAINER_SIZE;
			$ISO_CODE = $value1->ISO_CODE;
			$TERMINAL_ID = $value1->TERMINAL_ID;
			$TERMINAL_TRANSACTION_TYPE = $value1->TERMINAL_TRANSACTION_TYPE;
			$DOCUMENT_TYPE = $value1->DOCUMENT_TYPE;
			$DOCUMENT_NO = $value1->DOCUMENT_NO;
			$FORMAT_DOC_DATE = date('Ymd',strtotime($value1->DOCUMENT_DATE));
			$DOCUMENT_DATE = $FORMAT_DOC_DATE;
			$FULL_EMPTY = $value1->FULL_EMPTY;
			$PORT_LOADING = $value1->PORT_LOADING;//$Query->get('PORT_LOADING');
			$PORT_DISCHARGE = $value1->PORT_DISCHARGE;//$Query->get('PORT_DISCHARGE');
			$ATB = $value1->ATB;
			$ETD = $value1->ETD;
			$BC11_NO = $value1->BC11_NO;
			$FORMAT_BC11_DATE = date('Ymd',strtotime($value1->BC11_DATE));
			$BC11_DATE = $FORMAT_BC11_DATE;
			$BL_NO = $value1->BL_NO;
			$AUTO_HOLD = $value1->AUTO_HOLD;
			$CONSIGNEE = htmlspecialchars($value1->CONSIGNEE);
			$KPBC_CODE = $value1->KPBC_CODE;
			$BRUTO = $value1->BRUTO;

            // 
            
            $xml = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:tem="http://tempuri.org/">
							   <soapenv:Header/>
							   <soapenv:Body>';
			$xml .= '<tem:SendCustomsData>
									 <!--Optional:-->
									 <tem:TRANSACTIONID>' . $TRANSACTION_ID . '</tem:TRANSACTIONID>
									 <!--Optional:-->
									 <tem:CONTAINERID>' . $CONTAINER_ID . '</tem:CONTAINERID>
									 <!--Optional:-->
									 <tem:VOYAGE>' . $VOYAGE . '</tem:VOYAGE>
									 <!--Optional:-->
									 <tem:VESSELNAME>' . $VESSEL_NAME . '</tem:VESSELNAME>
									 <!--Optional:-->
									 <tem:CONTAINERSIZE>' . $CONTAINER_SIZE . '</tem:CONTAINERSIZE>
									 <!--Optional:-->
									 <tem:ISOCODE>' . $ISO_CODE . '</tem:ISOCODE>
									 <!--Optional:-->
									 <tem:TERMINALID>' . $TERMINAL_ID . '</tem:TERMINALID>
									 <!--Optional:-->
									 <tem:TERMINALTRANSACTIONTYPE>' . $TERMINAL_TRANSACTION_TYPE . '</tem:TERMINALTRANSACTIONTYPE>
									 <!--Optional:-->
									 <tem:DOCUMENTTYPE>'. $DOCUMENT_TYPE .'</tem:DOCUMENTTYPE>
									 <!--Optional:-->
									 <tem:DOCUMENTNBR>' . $DOCUMENT_NO . '</tem:DOCUMENTNBR>
									 <!--Optional:-->
									 <tem:DOCUMENTDATE>'.$DOCUMENT_DATE.'</tem:DOCUMENTDATE>
									 <!--Optional:-->
									 <tem:FULLEMPTYINDR>' . $FULL_EMPTY . '</tem:FULLEMPTYINDR>
									 <!--Optional:-->
									 <tem:PORTLOADING>' . $PORT_LOADING . '</tem:PORTLOADING>
									 <!--Optional:-->
									 <tem:PORTDISCHARGE>' . $PORT_DISCHARGE . '</tem:PORTDISCHARGE>
									 <!--Optional:-->
									 <tem:ATB>' . $ATB . '</tem:ATB>
									 <!--Optional:-->
									 <tem:ETD>' . $ETD . '</tem:ETD>
									 <!--Optional:-->
									 <tem:BC11NBR>' . $BC11_NO . '</tem:BC11NBR>
									 <!--Optional:-->
									 <tem:BC11DATE>'.$BC11_DATE.'</tem:BC11DATE>
									 <!--Optional:-->
									 <tem:BLNBR>' . $BL_NO . '</tem:BLNBR>
									 <!--Optional:-->
									 <tem:AUTOHOLD>' . $AUTO_HOLD . '</tem:AUTOHOLD>
									 <!--Optional:-->
									 <tem:CONSIGNEE>' . $CONSIGNEE . '</tem:CONSIGNEE>
									 <!--Optional:-->
									 <tem:KPBCCODE>' . $KPBC_CODE . '</tem:KPBCCODE>
									 <!--Optional:-->
									 <tem:BRUTTOWEIGHTS>' . $BRUTO . '</tem:BRUTTOWEIGHTS>
								  </tem:SendCustomsData>
							   </soapenv:Body>
							</soapenv:Envelope>';


                            echo $xml;

            echo 'sending ' . $value1->TRANSACTION_ID .' to autogate';
            echo "\r\n";
                $curl = curl_init();

                curl_setopt_array($curl, array(
                  CURLOPT_URL => 'https://cusmod-ca.multiterminal.co.id/customsrepo/CustomsDataRepositoryWebService.asmx',
                  CURLOPT_RETURNTRANSFER => true,
                  CURLOPT_ENCODING => '',
                  CURLOPT_MAXREDIRS => 10,
                  CURLOPT_SSL_VERIFYHOST => false,
                  CURLOPT_SSL_VERIFYPEER => false,
                  CURLOPT_TIMEOUT => 0,
                  CURLOPT_FOLLOWLOCATION => true,
                  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                  CURLOPT_CUSTOMREQUEST => 'POST',
                  CURLOPT_POSTFIELDS =>$xml,
                  CURLOPT_HTTPHEADER => array(
                    'Content-Type: text/xml;charset=UTF-8'
                  ),
                ));

                $response = curl_exec($curl);

                curl_close($curl);
                $xml1 = str_replace('<?xml version="1.0" encoding="utf-8"?><soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema"><soap:Body><SendCustomsDataResponse xmlns="http://tempuri.org/"><SendCustomsDataResult><Message>',"",$response);
                $raw_response = str_replace('</Message></SendCustomsDataResult></SendCustomsDataResponse></soap:Body></soap:Envelope>',"",$xml1);
                // echo $raw_response;

                if (strpos($raw_response, 'OK') !== false) {
                    $SQL = "UPDATE t_autogate_send_customs SET FL_SEND = 'Y', SEND_DATE = NOW(), REMAKS = '$raw_response' WHERE TRANSACTION_ID='$value1->TRANSACTION_ID'";
                    $this->db->query($SQL);
                    echo $raw_response;
                    echo "\r\n";
                } else {
                    $SQL = "UPDATE t_autogate_send_customs SET FL_SEND = 'E', SEND_DATE = NOW(), REMAKS = '$raw_response' WHERE TRANSACTION_ID='$value1->TRANSACTION_ID'";
                    $this->db->query($SQL);
                    echo $raw_response;
                    echo "\r\n";
                }
        }

    }

    public function sendcustomdatamanual(){
        $container_id = $this->input->get('container_id');

            // Check if the container ID is provided
            if (empty($container_id)) {
                echo "Container ID is required";
                return;
            }

            // Prepare the query with the container ID
            $q = $this->db->query("
                SELECT *
                FROM t_autogate_send_customs A
                WHERE A.CONTAINER_ID = ?
                ORDER BY A.TRANSACTION_ID DESC
                LIMIT 1", array($container_id));



        foreach ($q->result() as $key => $value1) {
            $ID = $value1->TRANSACTION_ID;
			$TRANSACTION_ID = $value1->TRANSACTION_ID."/BHD";
			$CONTAINER_ID = $value1->CONTAINER_ID;
			$VOYAGE = $value1->VOYAGE;
			$VESSEL_NAME = $value1->VESSEL_NAME;
			$CONTAINER_SIZE = $value1->CONTAINER_SIZE;
			$ISO_CODE = $value1->ISO_CODE;
			$TERMINAL_ID = $value1->TERMINAL_ID;
			$TERMINAL_TRANSACTION_TYPE = $value1->TERMINAL_TRANSACTION_TYPE;
			$DOCUMENT_TYPE = $value1->DOCUMENT_TYPE;
			$DOCUMENT_NO = $value1->DOCUMENT_NO;
			$FORMAT_DOC_DATE = date('Ymd',strtotime($value1->DOCUMENT_DATE));
			$DOCUMENT_DATE = $FORMAT_DOC_DATE;
			$FULL_EMPTY = $value1->FULL_EMPTY;
			$PORT_LOADING = $value1->PORT_LOADING;//$Query->get('PORT_LOADING');
			$PORT_DISCHARGE = $value1->PORT_DISCHARGE;//$Query->get('PORT_DISCHARGE');
			$ATB = $value1->ATB;
			$ETD = $value1->ETD;
			$BC11_NO = $value1->BC11_NO;
			$FORMAT_BC11_DATE = date('Ymd',strtotime($value1->BC11_DATE));
			$BC11_DATE = $FORMAT_BC11_DATE;
			$BL_NO = $value1->BL_NO;
			$AUTO_HOLD = $value1->AUTO_HOLD;
			$CONSIGNEE = htmlspecialchars($value1->CONSIGNEE);
			$KPBC_CODE = $value1->KPBC_CODE;
			$BRUTO = $value1->BRUTO;

            // 
            
            $xml = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:tem="http://tempuri.org/">
							   <soapenv:Header/>
							   <soapenv:Body>';
			$xml .= '<tem:SendCustomsData>
									 <!--Optional:-->
									 <tem:TRANSACTIONID>' . $TRANSACTION_ID . '</tem:TRANSACTIONID>
									 <!--Optional:-->
									 <tem:CONTAINERID>' . $CONTAINER_ID . '</tem:CONTAINERID>
									 <!--Optional:-->
									 <tem:VOYAGE>' . $VOYAGE . '</tem:VOYAGE>
									 <!--Optional:-->
									 <tem:VESSELNAME>' . $VESSEL_NAME . '</tem:VESSELNAME>
									 <!--Optional:-->
									 <tem:CONTAINERSIZE>' . $CONTAINER_SIZE . '</tem:CONTAINERSIZE>
									 <!--Optional:-->
									 <tem:ISOCODE>' . $ISO_CODE . '</tem:ISOCODE>
									 <!--Optional:-->
									 <tem:TERMINALID>' . $TERMINAL_ID . '</tem:TERMINALID>
									 <!--Optional:-->
									 <tem:TERMINALTRANSACTIONTYPE>' . $TERMINAL_TRANSACTION_TYPE . '</tem:TERMINALTRANSACTIONTYPE>
									 <!--Optional:-->
									 <tem:DOCUMENTTYPE>'. $DOCUMENT_TYPE .'</tem:DOCUMENTTYPE>
									 <!--Optional:-->
									 <tem:DOCUMENTNBR>' . $DOCUMENT_NO . '</tem:DOCUMENTNBR>
									 <!--Optional:-->
									 <tem:DOCUMENTDATE>'.$DOCUMENT_DATE.'</tem:DOCUMENTDATE>
									 <!--Optional:-->
									 <tem:FULLEMPTYINDR>' . $FULL_EMPTY . '</tem:FULLEMPTYINDR>
									 <!--Optional:-->
									 <tem:PORTLOADING>' . $PORT_LOADING . '</tem:PORTLOADING>
									 <!--Optional:-->
									 <tem:PORTDISCHARGE>' . $PORT_DISCHARGE . '</tem:PORTDISCHARGE>
									 <!--Optional:-->
									 <tem:ATB>' . $ATB . '</tem:ATB>
									 <!--Optional:-->
									 <tem:ETD>' . $ETD . '</tem:ETD>
									 <!--Optional:-->
									 <tem:BC11NBR>' . $BC11_NO . '</tem:BC11NBR>
									 <!--Optional:-->
									 <tem:BC11DATE>'.$BC11_DATE.'</tem:BC11DATE>
									 <!--Optional:-->
									 <tem:BLNBR>' . $BL_NO . '</tem:BLNBR>
									 <!--Optional:-->
									 <tem:AUTOHOLD>' . $AUTO_HOLD . '</tem:AUTOHOLD>
									 <!--Optional:-->
									 <tem:CONSIGNEE>' . $CONSIGNEE . '</tem:CONSIGNEE>
									 <!--Optional:-->
									 <tem:KPBCCODE>' . $KPBC_CODE . '</tem:KPBCCODE>
									 <!--Optional:-->
									 <tem:BRUTTOWEIGHTS>' . $BRUTO . '</tem:BRUTTOWEIGHTS>
								  </tem:SendCustomsData>
							   </soapenv:Body>
							</soapenv:Envelope>';


                            // echo $xml;

            echo 'sending ' . $value1->TRANSACTION_ID .' to autogate';
            echo "\r\n";
                $curl = curl_init();

                curl_setopt_array($curl, array(
                  CURLOPT_URL => 'https://cusmod-ca.multiterminal.co.id/customsrepo/CustomsDataRepositoryWebService.asmx',
                  CURLOPT_RETURNTRANSFER => true,
                  CURLOPT_ENCODING => '',
                  CURLOPT_MAXREDIRS => 10,
                  CURLOPT_SSL_VERIFYHOST => false,
                  CURLOPT_SSL_VERIFYPEER => false,
                  CURLOPT_TIMEOUT => 0,
                  CURLOPT_FOLLOWLOCATION => true,
                  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                  CURLOPT_CUSTOMREQUEST => 'POST',
                  CURLOPT_POSTFIELDS =>$xml,
                  CURLOPT_HTTPHEADER => array(
                    'Content-Type: text/xml;charset=UTF-8'
                  ),
                ));

                $response = curl_exec($curl);

                curl_close($curl);
                $xml1 = str_replace('<?xml version="1.0" encoding="utf-8"?><soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema"><soap:Body><SendCustomsDataResponse xmlns="http://tempuri.org/"><SendCustomsDataResult><Message>',"",$response);
                $raw_response = str_replace('</Message></SendCustomsDataResult></SendCustomsDataResponse></soap:Body></soap:Envelope>',"",$xml1);
                // echo $raw_response;
                

                if (strpos($raw_response, 'OK') !== false) {
                    $SQL = "UPDATE t_autogate_send_customs SET FL_SEND = 'Y', SEND_DATE = NOW(), REMAKS = '$raw_response' WHERE TRANSACTION_ID='$value1->TRANSACTION_ID'";
                    $this->db->query($SQL);
                    // Tampilkan XML yang dikirim
                    $dom = new DOMDocument();
                    $dom->preserveWhiteSpace = false;
                    $dom->formatOutput = true;
                    $dom->loadXML($xml);
                    echo "<pre>" . htmlspecialchars($dom->saveXML()) . "</pre>";

                    // Setelah curl_exec
                    echo "<h3>Raw Response:</h3>";
                    echo "<pre>" . htmlspecialchars($raw_response) . "</pre>";

                    echo "\r\n";
                } else {
                    $SQL = "UPDATE t_autogate_send_customs SET FL_SEND = 'E', SEND_DATE = NOW(), REMAKS = '$raw_response' WHERE TRANSACTION_ID='$value1->TRANSACTION_ID'";
                    $this->db->query($SQL);
                                        $dom = new DOMDocument();
                    $dom->preserveWhiteSpace = false;
                    $dom->formatOutput = true;
                    $dom->loadXML($xml);
                    echo "<pre>" . htmlspecialchars($dom->saveXML()) . "</pre>";

                    // Setelah curl_exec
                    echo "<h3>Raw Response:</h3>";
                    echo "<pre>" . htmlspecialchars($raw_response) . "</pre>";
                }
        }

    }

    public function sendcustomdatamanual_xml(){
        header('Content-Type: application/xml');
        $container_id = $this->input->get('container_id');

            // Check if the container ID is provided
            if (empty($container_id)) {
                echo "Container ID is required";
                return;
            }

            // Prepare the query with the container ID
            $q = $this->db->query("SELECT * FROM t_autogate_send_customs A WHERE A.CONTAINER_ID = ?", array($container_id));


        foreach ($q->result() as $key => $value1) {
            $ID = $value1->TRANSACTION_ID;
			$TRANSACTION_ID = $value1->TRANSACTION_ID."/BHD";
			$CONTAINER_ID = $value1->CONTAINER_ID;
			$VOYAGE = $value1->VOYAGE;
			$VESSEL_NAME = $value1->VESSEL_NAME;
			$CONTAINER_SIZE = $value1->CONTAINER_SIZE;
			$ISO_CODE = $value1->ISO_CODE;
			$TERMINAL_ID = $value1->TERMINAL_ID;
			$TERMINAL_TRANSACTION_TYPE = $value1->TERMINAL_TRANSACTION_TYPE;
			$DOCUMENT_TYPE = $value1->DOCUMENT_TYPE;
			$DOCUMENT_NO = $value1->DOCUMENT_NO;
			$FORMAT_DOC_DATE = date('Ymd',strtotime($value1->DOCUMENT_DATE));
			$DOCUMENT_DATE = $FORMAT_DOC_DATE;
			$FULL_EMPTY = $value1->FULL_EMPTY;
			$PORT_LOADING = $value1->PORT_LOADING;//$Query->get('PORT_LOADING');
			$PORT_DISCHARGE = $value1->PORT_DISCHARGE;//$Query->get('PORT_DISCHARGE');
			$ATB = $value1->ATB;
			$ETD = $value1->ETD;
			$BC11_NO = $value1->BC11_NO;
			$FORMAT_BC11_DATE = date('Ymd',strtotime($value1->BC11_DATE));
			$BC11_DATE = $FORMAT_BC11_DATE;
			$BL_NO = $value1->BL_NO;
			$AUTO_HOLD = $value1->AUTO_HOLD;
			$CONSIGNEE = htmlspecialchars($value1->CONSIGNEE);
			$KPBC_CODE = $value1->KPBC_CODE;
			$BRUTO = $value1->BRUTO;

            // 
            
            $xml = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:tem="http://tempuri.org/">
							   <soapenv:Header/>
							   <soapenv:Body>';
			$xml .= '<tem:SendCustomsData>
									 <!--Optional:-->
									 <tem:TRANSACTIONID>' . $TRANSACTION_ID . '</tem:TRANSACTIONID>
									 <!--Optional:-->
									 <tem:CONTAINERID>' . $CONTAINER_ID . '</tem:CONTAINERID>
									 <!--Optional:-->
									 <tem:VOYAGE>' . $VOYAGE . '</tem:VOYAGE>
									 <!--Optional:-->
									 <tem:VESSELNAME>' . $VESSEL_NAME . '</tem:VESSELNAME>
									 <!--Optional:-->
									 <tem:CONTAINERSIZE>' . $CONTAINER_SIZE . '</tem:CONTAINERSIZE>
									 <!--Optional:-->
									 <tem:ISOCODE>' . $ISO_CODE . '</tem:ISOCODE>
									 <!--Optional:-->
									 <tem:TERMINALID>' . $TERMINAL_ID . '</tem:TERMINALID>
									 <!--Optional:-->
									 <tem:TERMINALTRANSACTIONTYPE>' . $TERMINAL_TRANSACTION_TYPE . '</tem:TERMINALTRANSACTIONTYPE>
									 <!--Optional:-->
									 <tem:DOCUMENTTYPE>'. $DOCUMENT_TYPE .'</tem:DOCUMENTTYPE>
									 <!--Optional:-->
									 <tem:DOCUMENTNBR>' . $DOCUMENT_NO . '</tem:DOCUMENTNBR>
									 <!--Optional:-->
									 <tem:DOCUMENTDATE>'.$DOCUMENT_DATE.'</tem:DOCUMENTDATE>
									 <!--Optional:-->
									 <tem:FULLEMPTYINDR>' . $FULL_EMPTY . '</tem:FULLEMPTYINDR>
									 <!--Optional:-->
									 <tem:PORTLOADING>' . $PORT_LOADING . '</tem:PORTLOADING>
									 <!--Optional:-->
									 <tem:PORTDISCHARGE>' . $PORT_DISCHARGE . '</tem:PORTDISCHARGE>
									 <!--Optional:-->
									 <tem:ATB>' . $ATB . '</tem:ATB>
									 <!--Optional:-->
									 <tem:ETD>' . $ETD . '</tem:ETD>
									 <!--Optional:-->
									 <tem:BC11NBR>' . $BC11_NO . '</tem:BC11NBR>
									 <!--Optional:-->
									 <tem:BC11DATE>'.$BC11_DATE.'</tem:BC11DATE>
									 <!--Optional:-->
									 <tem:BLNBR>' . $BL_NO . '</tem:BLNBR>
									 <!--Optional:-->
									 <tem:AUTOHOLD>' . $AUTO_HOLD . '</tem:AUTOHOLD>
									 <!--Optional:-->
									 <tem:CONSIGNEE>' . $CONSIGNEE . '</tem:CONSIGNEE>
									 <!--Optional:-->
									 <tem:KPBCCODE>' . $KPBC_CODE . '</tem:KPBCCODE>
									 <!--Optional:-->
									 <tem:BRUTTOWEIGHTS>' . $BRUTO . '</tem:BRUTTOWEIGHTS>
								  </tem:SendCustomsData>
							   </soapenv:Body>
							</soapenv:Envelope>';


                            echo $xml;

            // echo 'sending ' . $value1->TRANSACTION_ID .' to autogate';
            echo "\r\n";
                $curl = curl_init();

                curl_setopt_array($curl, array(
                  CURLOPT_URL => 'https://cusmod-ca.multiterminal.co.id/customsrepo/CustomsDataRepositoryWebService.asmx',
                  CURLOPT_RETURNTRANSFER => true,
                  CURLOPT_ENCODING => '',
                  CURLOPT_MAXREDIRS => 10,
                  CURLOPT_SSL_VERIFYHOST => false,
                  CURLOPT_SSL_VERIFYPEER => false,
                  CURLOPT_TIMEOUT => 0,
                  CURLOPT_FOLLOWLOCATION => true,
                  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                  CURLOPT_CUSTOMREQUEST => 'POST',
                  CURLOPT_POSTFIELDS =>$xml,
                  CURLOPT_HTTPHEADER => array(
                    'Content-Type: text/xml;charset=UTF-8'
                  ),
                ));

                $response = curl_exec($curl);

                curl_close($curl);
                $xml1 = str_replace('<?xml version="1.0" encoding="utf-8"?><soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema"><soap:Body><SendCustomsDataResponse xmlns="http://tempuri.org/"><SendCustomsDataResult><Message>',"",$response);
                $raw_response = str_replace('</Message></SendCustomsDataResult></SendCustomsDataResponse></soap:Body></soap:Envelope>',"",$xml1);
                // echo $raw_response;

                if (strpos($raw_response, 'OK') !== false) {
                    $SQL = "UPDATE t_autogate_send_customs SET FL_SEND = 'Y', SEND_DATE = NOW(), REMAKS = '$raw_response' WHERE TRANSACTION_ID='$value1->TRANSACTION_ID'";
                    $this->db->query($SQL);
                    echo $raw_response;
                    echo "\r\n";
                } else {
                    $SQL = "UPDATE t_autogate_send_customs SET FL_SEND = 'E', SEND_DATE = NOW(), REMAKS = '$raw_response' WHERE TRANSACTION_ID='$value1->TRANSACTION_ID'";
                    $this->db->query($SQL);
                    // echo $raw_response;
                    echo "\r\n";
                }
        }

    }
    
}