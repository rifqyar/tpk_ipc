<?php
echo "sini";die();
set_time_limit(3600);
require_once("config.php");
$CONF['url.wsdl'] = 'https://ebooking.npct1.co.id/booking/index.php/service/tpk';
$method = 'insertSPJM';
$KdAPRF = 'LicenseCustoms';
$filename = $CONF['root.dir'] . "CheckScheduler/" . $method . ".txt";
$main = new main($CONF, $conn);
$CheckFile = $main->CheckFile($filename);
if (!$CheckFile) {
    #$createFile = $main->createFile($filename);
    $main->connect();
    //BEGIN
    $SOAPAction = 'urn:insertSPJM#'.$method;
	$SQL_MAILBOX = "SELECT A.ID, A.USERNAME,A.METHOD, A.XML_REQUEST AS STR_DATA
					FROM log_services A
					WHERE A.METHOD = 'LicenseCustoms'
					AND A.XML_REQUEST <> '' 
					AND A.XML_REQUEST <> 'Data tidak ditemukan'
					AND A.FL_SPJM = 'N'
					ORDER BY A.WK_REKAM ASC LIMIT 0,1";echo $SQL_MAILBOX;die();
	$Query_Mailbox = $conn->query($SQL_MAILBOX);
    if ($Query_Mailbox->size() > 0) {
        while ($Query_Mailbox->next()) {
			$ID = $Query_Mailbox->get("ID");
			$SNRF = $Query_Mailbox->get("SNRF");
			$STR_DATA = $Query_Mailbox->get("STR_DATA");
			$SQL_INSERT = "INSERT INTO postbox(METHOD, SENDER, RECEIVER, STR_DATA, KD_STATUS, TGL_STATUS) VALUES
						  ('".$KdAPRF."', 'TPKIPC' ,'NPCT1', '".$STR_DATA."', '100', NOW())";
			$ExecuteMailbox = $conn->execute($SQL_INSERT);
			$ID_NEW = mysql_insert_id();
			if($ExecuteMailbox){
				$SQL = "UPDATE log_services SET FL_SPJM = 'Y'
						WHERE ID = '" . $ID . "'";	
				$Execute = $conn->execute($SQL);
				echo "Berhasil Insert ke Postbox<br>";
			}else{
				echo "Gagal Insert ke Postbox<br>";
			}
		}
	}
	
	$SQL = "SELECT A.ID, A.STR_DATA
			FROM postbox A 
			WHERE A.KD_APRF = '" . $KdAPRF . "'
				  AND A.KD_STATUS = '100'
			LIMIT 0,20";
	#echo $SQL; die();
	$Query = $conn->query($SQL);
	if ($Query->size() > 0) {
		while ($Query->next()) {
			$ID = $Query->get("ID");
			$STR_DATA = $Query->get("STR_DATA");
			$xml = '<soapenv:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:urn="urn:insertSPJM">
				   <soapenv:Header/>
				   <soapenv:Body>
					  <urn:insertSPJM soapenv:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/">
						 <username xsi:type="xsd:string">npct1</username>
						 <password xsi:type="xsd:string">npct10k</password>
						 <xml xsi:type="xsd:string">'.htmlspecialchars($STR_DATA).'</xml>
					  </urn:insertSPJM>
				   </soapenv:Body>
				</soapenv:Envelope>';
			/*$xml = '<soapenv:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:urn="urn:LicenseCustomswsdl">
					   <soapenv:Header/>
					   <soapenv:Body>
						  <urn:LicenseCustoms soapenv:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/">
							 <String xsi:type="xsd:string">npct1</String>
							 <String0 xsi:type="xsd:string">npct10k</String0>
							 <String2 xsi:type="xsd:string">'.htmlspecialchars($STR_DATA).'</String2>
						  </urn:LicenseCustoms>
					   </soapenv:Body>
					</soapenv:Envelope>';*/
			$Send = $main->SendCurl($xml, $CONF['url.wsdl'], $SOAPAction, $CONF['proxyhost'] . ":" . $CONF['proxyport']);
			print_r($Send);
			 if ($Send['response'] != '') {
				$arr1 = 'ns1:insertSPJMResponse';
				$arr2 = 'return';
				$response = xml2ary($Send['response']);
				$response = $response['SOAP-ENV:Envelope']['_c']['SOAP-ENV:Body']['_c'][$arr1]['_c'][$arr2]['_v'];
				echo '<br>';
				echo '<pre>';
				print_r($response);
				echo '</pre>';
				$pos = strpos(strtolower($response), 'success');
				//print_r($pos);
				if ($pos === false){
					$STATUS_POST = '300';
				}else{
					$STATUS_POST = '200';
				}
			} else {
				$response = '';
				$STATUS_POST = '300';
			}
			$SQL = "UPDATE postbox SET KD_STATUS = '".$STATUS_POST."', KETERANGAN = '".$Send['response']."', TGL_STATUS = NOW()
					WHERE ID = '" . $ID . "'";
			$Execute = $conn->execute($SQL);
		}
	} else {
		echo 'Data user TPS tidak ada.';
	}
    //END

    $main->connect(false);
    $main->removeFile($filename);
} else {
    echo 'Scheduler sedang berjalan, harap menghapus file ' . $method . '.txt yang ada difolder CheckScheduler.';
}
?>