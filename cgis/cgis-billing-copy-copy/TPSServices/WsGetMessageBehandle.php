<?php
die();
ini_set('display_errors', 1);
error_reporting(E_ALL);
set_time_limit(3600);
require_once("config.php");
$url = 'http://103.19.80.243/cfs_dev/bos_ipctpk/server.php';
$jam_awal = "00";
$jam_akhir = "21";
$method = 'GetMessageBehandle';
$filename = $CONF['root.dir'] . "CheckScheduler/" . $method . ".txt";
$main = new main($CONF, $conn);
$CheckFile = $main->CheckFile($filename);
if (!$CheckFile) {
    $createFile = $main->createFile($filename);
    $main->connect();   
    if (date('H') >= $jam_awal && date('H') <= $jam_akhir) {
        $is_transaction = 'T'; 
        $is_receipt = 'T';
        $is_payable = 'F';
        $SOAPAction = 'urn:portalintegrasiipc';
        $xml = '<soapenv:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:urn="urn:getMessagewsdl">
                        <soapenv:Header/>
                        <soapenv:Body>
                           <urn:getMessage soapenv:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/">
			      <source_system xsi:type="xsd:string">BOSITPKCA</source_system>
                              <is_transaction xsi:type="xsd:string">' . $is_transaction . '</is_transaction>
                              <is_receipt xsi:type="xsd:string">' . $is_receipt . '</is_receipt>
                              <is_payable xsi:type="xsd:string">' . $is_payable . '</is_payable>
                           </urn:getMessage>
                        </soapenv:Body>
                     </soapenv:Envelope>';
        //echo $xml . "<br>";
        $Send = $main->SendCurl($xml, $url, $SOAPAction); 
        if ($Send['response'] != '') {
            $arr1 = 'ns1:getMessageResponse'; 
            $arr2 = 'return';
            $response = xml2ary($Send['response']); 
            $response = $response['SOAP-ENV:Envelope']['_c']['SOAP-ENV:Body']['_c'][$arr1]['_c'][$arr2]['_v'];
            echo "<pre>";
            print_r($Send['response']); 
            echo "</pre>"; //die();
           $SQL = "INSERT INTO mailbox (KD_APRF, KD_ORG_SENDER, KD_ORG_RECEIVER, STR_DATA, KD_STATUS, TGL_STATUS)
                   VALUES ('GetMessageBehandle','0','0','" . $response . "','100',NOW())";
           $Execute = $conn->execute($SQL);            
        } else {
            $response = '';
            $FL_SEND_RECEIPT_SIMKEU = 'E';
            $FL_SEND_TRANS_SIMKEU = 'E';
        }
        echo "<hr>";
    } else {
        echo "Scheduler akan berjalan pada pukul " . $jam_awal . " sampai dengan " . $jam_akhir;
    }

    $main->connect(false);
    $main->removeFile($filename);
} else {
    echo 'Scheduler sedang berjalan, harap menghapus file ' . $method . '.txt yang ada difolder CheckScheduler.';
}

function getXml() {
    $xml = '';
}

?>
