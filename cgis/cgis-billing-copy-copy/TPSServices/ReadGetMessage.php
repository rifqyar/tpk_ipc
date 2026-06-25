<?php
die();
ini_set('display_errors', 1);
error_reporting(E_ALL);
set_time_limit(3600);
require_once("config.php");
$jam_awal = "00";
$jam_akhir = "21";
$method = 'ReadGetMessage';
$filename = $CONF['root.dir'] . "CheckScheduler/" . $method . ".txt";
$main = new main($CONF, $conn);
$CheckFile = $main->CheckFile($filename);
if (!$CheckFile) {
    $createFile = $main->createFile($filename);
    $main->connect();
    if (date('H') >= $jam_awal && date('H') <= $jam_akhir) {
        $SQL = "SELECT ID, STR_DATA FROM mailbox
				WHERE KD_APRF = 'GetMessage' AND KD_STATUS='100' LIMIT 0,50";
        $Query = $conn->query($SQL);
        if ($Query->size() > 0) {
            while ($Query->next()) {
				$ID_LOG = $Query->get("ID");
				$STR_DATA = $Query->get("STR_DATA");
                $xml = xml2ary($STR_DATA);
                echo "<pre>";
                print_r($xml);
                echo "</pre>";
                echo $ID_LOG;
                $component = $xml['root']['_c']['group']['_c']['component']['_c']['receipt'];
                $component2 = $xml['root']['_c']['group']['_c']['component']['_c']['transaction'];
                $length = count($component);
                $length2 = count($component2);
                if ($length > 1) {
                    for ($c = 0; $c < $length; $c++) {
                        $receipt = $component[$c]['_c'];
                        $receipt_number = $receipt['receipt_number']['_v'];
                        $status = strtoupper($receipt['status']['_v']) == "S" ? "S" : "F";
                        $message = $receipt['message']['_v'];
                        $SQLDEL = "UPDATE req_delivery_hdr SET FL_SEND_RECEIPT_SIMKEU = '" . $status . "', MESSAGE_SEND_RECEIPT_SIMKEU = '" . mysql_real_escape_string($message) . "' WHERE NO_NOTA_DELIVERY = '" . $receipt_number . "'";
                        $SQLBHD = "UPDATE req_behandle_hdr SET FL_SEND_RECEIPT_SIMKEU = '" . $status . "', MESSAGE_SEND_RECEIPT_SIMKEU = '" . mysql_real_escape_string($message) . "' WHERE NO_NOTA_BEHANDLE = '" . $receipt_number . "'";
                        echo $SQLDEL . "<br>";
                        echo $SQLBHD . "<br>";
                        $ExecuteDEL = $conn->execute($SQLDEL);
                        $ExecuteBHD = $conn->execute($SQLBHD);
                    }
                } elseif ($length == 1) { 
                    $receipt = $component['_c'];
                    $receipt_number = $receipt['receipt_number']['_v'];
                    $status = strtoupper($receipt['status']['_v']) == "S" ? "S" : "F";
                    $message = $receipt['message']['_v'];
                    $SQLDEL = "UPDATE req_delivery_hdr SET FL_SEND_RECEIPT_SIMKEU = '" . $status . "', MESSAGE_SEND_RECEIPT_SIMKEU = '" . mysql_real_escape_string($message) . "' WHERE NO_NOTA_DELIVERY = '" . $receipt_number . "'";
                    $SQLBHD = "UPDATE req_behandle_hdr SET FL_SEND_RECEIPT_SIMKEU = '" . $status . "', MESSAGE_SEND_RECEIPT_SIMKEU = '" . mysql_real_escape_string($message) . "' WHERE NO_NOTA_BEHANDLE = '" . $receipt_number . "'";
                    echo $SQLDEL . "<br>";
                    echo $SQLBHD . "<br>";
                    $ExecuteDEL = $conn->execute($SQLDEL);
                    $ExecuteBHD = $conn->execute($SQLBHD);
                }

                if ($length2 > 1) {
                    for ($c = 0; $c < $length2; $c++) {
                        $transaction = $component2[$c]['_c'];
                        $transaction_number = $transaction['transaction_number']['_v'];
                        $status = strtoupper($transaction['status']['_v']) == "S" ? "S" : "F";
                        $message = $transaction['message']['_v'];
                        $SQLDEL = "UPDATE req_delivery_hdr SET FL_SEND_TRANS_SIMKEU = '" . $status . "', MESSAGE_SEND_TRANS_SIMKEU = '" . mysql_real_escape_string($message) . "' WHERE NO_NOTA_DELIVERY = '" . $transaction_number . "'";
                        $SQLBHD = "UPDATE req_behandle_hdr SET FL_SEND_TRANS_SIMKEU = '" . $status . "', MESSAGE_SEND_TRANS_SIMKEU = '" . mysql_real_escape_string($message) . "' WHERE NO_NOTA_BEHANDLE = '" . $transaction_number . "'";
                        echo $SQLDEL . "<br>";
                        echo $SQLBHD . "<br>";
                        $ExecuteDEL = $conn->execute($SQLDEL);
                        $ExecuteBHD = $conn->execute($SQLBHD);
                    } 
                } elseif ($length2 == 1) { 
                    $transaction = $component2['_c'];
                    $transaction_number = $transaction['transaction_number']['_v'];
                    $status = strtoupper($transaction['status']['_v']) == "S" ? "S" : "F";
                    $message = $transaction['message']['_v'];
                    $SQLDEL = "UPDATE req_delivery_hdr SET FL_SEND_TRANS_SIMKEU = '" . $status . "', MESSAGE_SEND_TRANS_SIMKEU = '" . mysql_real_escape_string($message) . "' WHERE NO_NOTA_DELIVERY = '" . $transaction_number . "'";
                    $SQLBHD = "UPDATE req_behandle_hdr SET FL_SEND_TRANS_SIMKEU = '" . $status . "', MESSAGE_SEND_TRANS_SIMKEU = '" . mysql_real_escape_string($message) . "' WHERE NO_NOTA_BEHANDLE = '" . $transaction_number . "'";
                    echo $SQLDEL . "<br>";
                    echo $SQLBHD . "<br>";
                    $ExecuteDEL = $conn->execute($SQLDEL);
                    $ExecuteBHD = $conn->execute($SQLBHD);
                }

                $SQL2 = "UPDATE mailbox SET KD_STATUS = '200', TGL_STATUS = NOW() WHERE ID = '" . $ID_LOG . "'";
                $Execute = $conn->execute($SQL2);
            }
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
