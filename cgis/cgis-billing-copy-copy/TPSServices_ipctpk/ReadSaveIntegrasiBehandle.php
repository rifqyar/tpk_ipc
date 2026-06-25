<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);
set_time_limit(3600);
require_once("config.php");
$jam_awal = "00";
$jam_akhir = "21";
$method = 'ReadSaveIntegrasiBehandle';
$filename = $CONF['root.dir'] . "CheckScheduler/" . $method . ".txt";
$main = new main($CONF, $conn);
$CheckFile = $main->CheckFile($filename);
if (!$CheckFile) {
    $createFile = $main->createFile($filename);
    $main->connect();
    if (date('H') >= $jam_awal && date('H') <= $jam_akhir) {
        $SQL = "";
        $Query = $conn->query($SQL);
        if ($Query->size() > 0) {
            while ($Query->next()) {
                $xml = xml2ary($response);
                echo "<pre>";
                print_r($xml);
                echo "</pre>";
                $component = $xml['root']['_c']['group']['_c']['component'];
                $length = count($component);
                if ($length > 1) {
                    for ($c = 0; $c < $length; $c++) {
                        $transaction = $component[$c]['_c']['transaction']['_c'];
                        $transaction_number = $transaction['transaction_number']['_v'];
                        $status = strtoupper($transaction['status']['_v']) == "T" ? "Y" : "E";
                        $message = $transaction['message']['_v'];
                        $SQL = "UPDATE req_behandle_hdr SET FL_SEND_TRANS_SIMKEU = '" . $status . "' WHERE NO_NOTA_BEHANDLE = '" . $transaction_number . "'";
                        echo $SQL . "<br>";
                        $Execute = $conn->execute($SQL);

                        $receipt = $component[$c]['_c']['receipt']['_c'];
                        $receipt_number = $receipt['receipt_number']['_v'];
                        $status = strtoupper($receipt['status']['_v']) == "T" ? "Y" : "E";
                        $message = $receipt['message']['_v'];
                        $SQL = "UPDATE req_behandle_hdr SET FL_SEND_RECEIPT_SIMKEU = '" . $status . "' WHERE NO_NOTA_BEHANDLE = '" . $receipt_number . "'";
                        echo $SQL . "<br>";
                        $Execute = $conn->execute($SQL);

                        $payable = $component[$c]['_c']['payable']['_c'];
                        $transaction_number = $payable['transaction_number']['_v'];
                        $status = strtoupper($payable['status']['_v']) == "T" ? "Y" : "E";
                        $message = $payable['message']['_v'];
                    }
                } elseif ($length == 1) {
                    $transaction = $component['_c']['transaction']['_c'];
                    $transaction_number = $transaction['transaction_number']['_v'];
                    $status = strtoupper($transaction['status']['_v']) == "T" ? "Y" : "E";
                    $message = $transaction['message']['_v'];
                    $SQL = "UPDATE req_behandle_hdr SET FL_SEND_TRANS_SIMKEU = '" . $status . "' WHERE NO_NOTA_BEHANDLE = '" . $transaction_number . "'";
                    echo $SQL . "<br>";
                    $Execute = $conn->execute($SQL);

                    $receipt = $component['_c']['receipt']['_c'];
                    $receipt_number = $receipt['receipt_number']['_v'];
                    $status = strtoupper($receipt['status']['_v']) == "T" ? "Y" : "E";
                    $message = $receipt['message']['_v'];
                    $SQL = "UPDATE req_behandle_hdr SET FL_SEND_RECEIPT_SIMKEU = '" . $status . "' WHERE NO_NOTA_BEHANDLE = '" . $receipt_number . "'";
                    echo $SQL . "<br>";
                    $Execute = $conn->execute($SQL);

                    $payable = $component['_c']['payable']['_c'];
                    $transaction_number = $payable['transaction_number']['_v'];
                    $status = strtoupper($payable['status']['_v']) == "T" ? "Y" : "E";
                    $message = $payable['message']['_v'];
                }

                $SQL = "";
                $Execute = $conn->execute($SQL);
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
