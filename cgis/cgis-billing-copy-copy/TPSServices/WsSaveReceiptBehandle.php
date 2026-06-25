<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
error_reporting(E_ALL & ~E_NOTICE);
set_time_limit(3600);
require_once("config.php");
$url = 'http://103.19.80.243/cfs_dev/bos_ipctpk/server.php';
$jam_awal = "00";
$jam_akhir = "21";
$method = 'SaveIntegrasiBehandle';
$filename = $CONF['root.dir'] . "CheckScheduler/" . $method . ".txt";
$main = new main($CONF, $conn);
$CheckFile = $main->CheckFile($filename);
if (!$CheckFile) {
    $createFile = $main->createFile($filename);
    $main->connect();
    if (date('H') >= $jam_awal && date('H') <= $jam_akhir) {
        $SQL = "SELECT DISTINCT A.ID AS ID, A.ID_REQ AS NO_ORDER, A.NO_NOTA_BEHANDLE AS NO_INVOICE, '' AS EX_NOTA, C.NAMA_BANK AS BANK,
                A.NAMA_CUST AS NAMA, A.NPWP AS NPWP, A.SUBTOTAL, A.PPN, A.TOTAL_JUMLAH AS TOTAL, DATE_FORMAT(A.TGL_NOTA,'%d/%m/%Y %H:%i:%s') AS TGL_TERIMA, 
                A.NM_KAPAL AS NM_ANGKUT, A.NO_VOY AS NO_VOYAGE, '' AS TGL_TIBA, A.NO_DO AS NO_DO, A.NO_BL AS NO_BL_AWB, 
                DATE_FORMAT(A.EXPIRED,'%d/%m/%Y') AS TGL_KELUAR, A.FL_SEND_TRANS_SIMKEU, A.FL_SEND_RECEIPT_SIMKEU , F.ID_CUST AS 'ID_CUST'
                FROM req_behandle_hdr A                 
                INNER JOIN m_bank C ON A.BANK_ID = C.BANK_ID
                INNER JOIN req_delivery_simkeu D ON A.ID_REQ = D.ID_REQ
                LEFT JOIN t_permit_hdr E ON A.NO_DOK = E.NO_DOK_INOUT AND A.TGL_DOK = E.TGL_DOK_INOUT
                LEFT JOIN m_pelanggan F ON A.NPWP = F.NPWP
                WHERE 
                -- A.NO_NOTA_BEHANDLE IS NOT NULL AND YEAR(A.TGL_NOTA) = '2018' 
                 A.NO_NOTA_BEHANDLE IN ('030.801.18-65.012079')
                GROUP BY A.NO_NOTA_BEHANDLE
                ORDER BY A.NO_NOTA_BEHANDLE ASC 
                LIMIT 10";
        $Query = $conn->query($SQL);
        if ($Query->size() > 0) {
            $message = '<?xml version="1.0" encoding="UTF-8"?>';
            $message .= '<root>';
            $message .= '<group>';
            while ($Query->next()) {
                for ($i = 0; $i < $Query->columnSize(); $i++) {
                    $data[$Query->fieldName($i)] = htmlspecialchars($Query->get($Query->fieldName($i)));
                }
                $dataBank = $main->getData(array("BANK_ID", "CONCAT(NAMA_BANK,' ', REKENING) AS BANK_ACCOUNT"), "m_bank", "NAMA_BANK", "=", "'" . $data['BANK'] . "'");
                $is_transaction = "F";
                $is_receipt = $data['FL_SEND_RECEIPT_SIMKEU'] == "Y" ? "F" : "T";
                $is_payable = "F";

                $message .= '<component>';
                $message .= '<transaction>';
                $message .= '<header>';
                $message .= '<is_transaction>' . $is_transaction . '</is_transaction>';
                $message .= '<is_receipt>' . $is_receipt . '</is_receipt>';
                $message .= '<is_payable>' . $is_payable . '</is_payable>';
		$message .= '<source_system>BOSITPKCA</source_system>';
                $message .= '</header>';
                $message .= '</transaction>';

                $SQL = "SELECT A.JENIS_TARIF, A.CHARGE, COUNT(DISTINCT A.NO_CONT) AS QTY, SUM(A.TOTAL) AS TOTAL
                        FROM req_delivery_simkeu A INNER JOIN req_behandle_hdr B ON A.ID_REQ = B.ID_REQ
                        WHERE B.ID = '" . $data['ID'] . "'
                        GROUP BY A.JENIS_TARIF, A.CHARGE
                        HAVING SUM(A.TOTAL) > 0";
                $Query2 = $conn->query($SQL);
                if ($Query2->size() > 0) {
                    $lineNumber = 1;
                    $message .= '<details>';
                    while ($Query2->next()) {
                        for ($i = 0; $i < $Query2->columnSize(); $i++) {
                            $data2[$Query2->fieldName($i)] = $Query2->get($Query2->fieldName($i));
                        }

                        if ($data2['JENIS_TARIF'] == 'ADMINISTRASI') {
                            $serviceType = 'CMA BEHANDLE ADM';
                            $data2['QTY'] = '1';
                        } else if ($data2['JENIS_TARIF'] == 'BEHANDLE 1') {
                            $serviceType = 'CMA BEHANDLE BEHANDLE';
                        } else if ($data2['JENIS_TARIF'] == 'BEHANDLE 2') {
                            $serviceType = 'CMA BEHANDLE BEHANDLE';
                        } else if ($data2['JENIS_TARIF'] == 'MATERAI BHD') {
                            $serviceType = 'CMA BEHANDLE MATERAI';
                        } else {
                            $serviceType = "";
                        }

                        $ITEM_CODE = '';
                        $message .= '<item>';
                        $message .= '<line_number>' . $lineNumber . '</line_number>';
                        $message .= '<item_code>' . $ITEM_CODE . '</item_code>';
                        $message .= '<item_name>' . $data2['JENIS_TARIF'] . '</item_name>';
                        $message .= '<service_type>' . $serviceType . '</service_type> '; //MASIH TENTATIVE
                        $message .= '<qty>' . $data2['QTY'] . '</qty>';
                        $message .= '<unit></unit>';
                        $message .= '<tariff>' . $data2['CHARGE'] . '</tariff>';
                        $message .= '<amount>' . $data2['TOTAL'] . '</amount>';
                        if ($data2['JENIS_TARIF'] == 'MATERAI BHD') {
                            $message .= '<tax_flag>N</tax_flag>';
                        } else {
                            $message .= '<tax_flag>N</tax_flag>';
                        }
                        $message .= '<tax></tax>';
                        $message .= '</item>';
                        $lineNumber++;
                    }
                    $message .= '</details>';
                }

                $message .= '<receipt>';
                $message .= '<receipt_number>' . $data['NO_INVOICE'] . '</receipt_number>';
                $message .= '<receipt_method>ITPK BANK</receipt_method>';
                $message .= '<receipt_account>' . $dataBank['BANK_ACCOUNT'] . '</receipt_account>';
                $message .= '<organization_id>1827</organization_id>';
                $message .= '<bank_id>' . $dataBank['BANK_ID'] . '</bank_id>';
                $message .= '<customer_number>999999</customer_number>';
                $message .= '<receipt_date>' . $data['TGL_TERIMA'] . '</receipt_date>';
                $message .= '<currency>IDR</currency>';
                $message .= '<currency_type></currency_type>';
                $message .= '<currency_rate></currency_rate>';
                $message .= '<currency_date></currency_date>';
                $message .= '<amount>' . $data['TOTAL'] . '</amount>';
                $message .= '<receipt_type>PTKM</receipt_type>';
                $message .= '<receipt_sub_type>PTKM05</receipt_sub_type>';
                $message .= '</receipt>';
                $message .= '</component>';
            }
            $message .= '</group>';
            $message .= '<configuration>';
            $message .= '<source_apps>BOSITPKCA</source_apps>';
            $message .= '<ip_address>' . getIP() . '</ip_address>';
            $message .= '<token></token>';
            $message .= '<key></key>';
            $message .= '</configuration>';
            $message .= '</root>';

            $SOAPAction = 'urn:portalintegrasiipc';
            $xml = '<soapenv:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:urn="urn:saveIntegrasiwsdl">
                        <soapenv:Header/>
                        <soapenv:Body>
                           <urn:saveIntegrasi soapenv:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/">
                              <in_param xsi:type="xsd:string"><![CDATA[' . ($message) . ']]></in_param>
                           </urn:saveIntegrasi>
                        </soapenv:Body>
                     </soapenv:Envelope>';
            echo "<pre>";
            echo $message . "<br>";
//            print_r($message);
            echo "</pre>";
            $Send = $main->SendCurl($xml, $url, $SOAPAction);
            echo "<pre>";
            print_r($Send);
            echo "</pre>";
            if ($Send['response'] != '') {
                $arr1 = 'ns1:saveIntegrasiResponse';
                $arr2 = 'return';
                $response = xml2ary($Send['response']);
                $response = $response['SOAP-ENV:Envelope']['_c']['SOAP-ENV:Body']['_c'][$arr1]['_c'][$arr2]['_v'];
                $xml = xml2ary($response);
//                echo "<pre>";
//                print_r($xml);
//                echo "</pre>";

                $component = $xml['root']['_c']['group']['_c']['component'];
                $length = count($component);
                if ($length > 1) {
                    for ($c = 0; $c < $length; $c++) {
                        $receipt = $component[$c]['_c']['receipt']['_c'];
                        $receipt_number = $receipt['receipt_number']['_v'];
                        $status = strtoupper($receipt['status']['_v']);
                        $message = $receipt['message']['_v'];
                        $SQL = "UPDATE req_behandle_hdr SET FL_SEND_RECEIPT_SIMKEU = '" . $status . "', 
                                                            MESSAGE_SEND_RECEIPT_SIMKEU = '" . $message . "', 
                                                            TGL_SEND_RECEIPT_SIMKEU = NOW()
                                WHERE NO_NOTA_BEHANDLE = '" . $receipt_number . "'";
                        echo $SQL . "<br>";
                        $Execute = $conn->execute($SQL);

                        echo "<hr>";
                    }
                } elseif ($length == 1) {
                    $receipt = $component['_c']['receipt']['_c'];
                    $receipt_number = $receipt['receipt_number']['_v'];
                    $status = strtoupper($receipt['status']['_v']);
                    $message = $receipt['message']['_v'];
                    $SQL = "UPDATE req_behandle_hdr SET FL_SEND_RECEIPT_SIMKEU = '" . $status . "', 
                                                        MESSAGE_SEND_RECEIPT_SIMKEU = '" . $message . "', 
                                                        TGL_SEND_RECEIPT_SIMKEU = NOW()
                            WHERE NO_NOTA_BEHANDLE = '" . $receipt_number . "'";
                    echo $SQL . "<br>";
                    $Execute = $conn->execute($SQL);
                    echo "<hr>";
                }
            } else {
                $response = '';
                $FL_SEND_RECEIPT_SIMKEU = 'E';
                $FL_SEND_TRANS_SIMKEU = 'E';
            }
            echo "<hr>";
        } else {
            echo "Data tidak ada";
        }
    } else {
        echo "Scheduler akan berjalan pada pukul " . $jam_awal . " sampai dengan " . $jam_akhir;
    }

    $main->connect(false);
    $main->removeFile($filename);
} else {
    echo 'Scheduler sedang berjalan, harap menghapus file ' . $method . '.txt yang ada difolder CheckScheduler.';
}

function getIP() {
    if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown"))
        $ip = getenv("HTTP_CLIENT_IP");
    else if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown"))
        $ip = getenv("REMOTE_ADDR");
    else if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown"))
        $ip = getenv("HTTP_X_FORWARDED_FOR");
    else if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown"))
        $ip = $_SERVER['REMOTE_ADDR'];
    else {
        $ip = "unknown/server";
    }
    return $ip;
}

?>
