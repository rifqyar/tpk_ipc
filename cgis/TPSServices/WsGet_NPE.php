<?php


set_time_limit(3600);
require_once("config.php");
//$CONF['url.wsdl'] = 'http://10.1.5.109/TPSServices/services.php';
$method = 'Get_NPE';
$KdAPRF = 'GETNPE';
$main = new main($CONF, $conn);
$xml = '';
$SOAPAction = 'http://services.beacukai.go.id/' . $method;
$NO_DOK_INOUT = $_GET['NO_SPPB'];
$TGL_DOK_INOUT = $_GET['TGL_SPPB'];
$NPWP_CONSIGNEE = $_GET['NPWP'];

$xml = '<?xml version="1.0" encoding="utf-8"?>
  <soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
  <soapenv:Body>
  <ser:GetEkspor_NPE>
     <!--Optional:-->
     <ser:UserName>NCT1</ser:UserName>
     <!--Optional:-->
     <ser:Password>NCT1123456</ser:Password>
     <!--Optional:-->
     <ser:No_PE>571942/KPU.01/2022</ser:No_PE>
     <!--Optional:-->
     <ser:npwp>014944946441000</ser:npwp>
     <!--Optional:-->
     <ser:kdKantor>040300</ser:kdKantor>
  </ser:GetEkspor_NPE>
</soapenv:Body>

  </soap:Envelope>'; 
/*$xml = '<?xml version="1.0" encoding="utf-8"?>
		<soapenv:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ser="http://services.beacukai.go.id/">
		<soapenv:Header/>
		<soapenv:Body>
		   <ser:GetImpor_Sppb soapenv:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/">
			  <Username xsi:type="xsd:string">' . $USERNAME_TPSONLINE_BC . '</Username>
			  <Password xsi:type="xsd:string">' . $PASSWORD_TPSONLINE_BC . '</Password>
			  <No_Sppb xsi:type="xsd:string">' . $NO_DOK_INOUT . '</No_Sppb>
			  <Tgl_Sppb xsi:type="xsd:string">' . $TGL_DOK_INOUT . '</Tgl_Sppb>
			  <NPWP_Imp xsi:type="xsd:string">' . $NPWP_CONSIGNEE . '</NPWP_Imp>
		   </ser:GetImpor_Sppb>
		</soapenv:Body>
	 </soapenv:Envelope>';*/
//$Send = $main->SendCurl($xml, $CONF['url.wsdl'], $SOAPAction, $CONF['proxyhost'] . ":" . $CONF['proxyport']);
$Send = SendCurl1($xml, $CONF['url.wsdl'], $SOAPAction, $CONF['proxyhost'] . ":" . $CONF['proxyport']);
//echo '<pre>';
//print_r($Send);
//echo '</pre>';
if ($Send['response'] != '') {
	$arr1 = 'GetImpor_SppbResponse';
	//$arr1 = 'ns1:GetImpor_SppbResponse';
	$arr2 = 'GetImpor_SppbResult';
	$response = xml2ary($Send['response']);
	$data = $response['soap:Envelope']['_c']['soap:Body']['_c'][$arr1]['_c'][$arr2]['_v'];
	$response = $response['soap:Envelope']['_c']['soap:Body']['_c'][$arr1]['_c'][$arr2]['_v'];//echo $data;
	$response = WhiteSpaceXML($response);
	if($response=='Data tidak ditemukan'){
		$response = $response;
	}else{
		$main->connect();
		// $SQL = "INSERT INTO mailbox (SNRF, KD_APRF, KD_ORG_SENDER, KD_ORG_RECEIVER, STR_DATA, KD_STATUS, TGL_STATUS)
  //                       VALUES (NULL, '" . $KdAPRF . "','0','0','" . $response . "','200',NOW())";
  //               $Execute = $conn->execute($SQL);//echo $SQL;
		$response = $response;
	}
	
} else {
	$response = '';
}
$main->connect(false);
echo $response;

function SendCurl1($xml, $url, $SOAPAction, $proxy = "", $port = "443") {
        $header[] = 'Content-Type: text/xml';
        $header[] = 'SOAPAction: "' . $SOAPAction . '"';
        $header[] = 'Content-length: ' . strlen($xml);
        $header[] = 'Connection: close';

        $ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		//curl_setopt($ch, CURLOPT_PORT, $port);
		//curl_setopt($ch, CURLOPT_PROXY, $proxy);
        #curl_setopt($ch, CURLOPT_VERBOSE, 0);
        #curl_setopt($ch, CURLOPT_HEADER, 0);
        #curl_setopt($ch, CURLOPT_SSLVERSION, 3);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        //curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POST, true);
        //curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		/*
        curl_setopt($ch, CURLOPT_URL, $url);
//        curl_setopt($ch, CURLOPT_PORT, $port);
//        curl_setopt($ch, CURLOPT_PROXY, $proxy);
        curl_setopt($ch, CURLOPT_VERBOSE, 0);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_SSLVERSION, 3);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		*/
        $response = curl_exec($ch);
        if (!curl_errno($ch)) {
            $return['return'] = TRUE;
            $return['info'] = curl_getinfo($ch);
            $return['response'] = $response;
        } else {
            $return['return'] = FALSE;
            $return['info'] = curl_error($ch);
            $return['response'] = '';
        }
        return $return;
    }
	
	function WhiteSpaceXML($text) {

    $hasil = str_replace("&amp;"," ",$text);
    $hasil = str_replace("&apos;"," ",$hasil);
    $hasil = str_replace("&"," ",$hasil);
    $hasil = str_replace("'"," ",$hasil);
    //$hasil = str_replace("\"","&quot;",$hasil);
    //$hasil = str_replace("<","&lt;",$hasil);
    //$hasil = str_replace(">","&gt;",$hasil);  
    return $hasil;
}
?>