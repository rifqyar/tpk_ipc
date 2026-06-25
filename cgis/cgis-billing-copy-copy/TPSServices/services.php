<?php
die();
ob_start();
// call library
require_once ('config.php' );

require_once ($CONF['root.dir'] . 'Libraries/nusoap/nusoap.php' );
require_once ($CONF['root.dir'] . 'Libraries/xml2array.php' );

// create instance
$server = new soap_server();

// initialize WSDL support
$server->configureWSDL('TPSServices Web Service', 'http://services.beacukai.go.id/');

// place schema at namespace with prefix tns
$server->wsdl->schemaTargetNamespace = 'http://services.beacukai.go.id/';

// register method
$server->register('CheckConnection', // method name
        array('Username' => 'xsd:string', 'Password' => 'xsd:string'),
        // input parameter
        array('CheckConnectionResult' => 'xsd:string'), // output
        'http://services.beacukai.go.id/', // namespace
        'http://services.beacukai.go.id/CheckConnection', // soapaction
        'rpc', // style
        'encoded', // use
        'Fungsi untuk pengecekan koneksi webservice'// documentation
);

$server->register('CoarriCodeco_Container', // method name
        array('fStream' => 'xsd:string', 'Username' => 'xsd:string', 'Password' => 'xsd:string'),
        // input parameter
        array('CoarriCodeco_ContainerResult' => 'xsd:string'), // output
        'http://services.beacukai.go.id/', // namespace
        'http://services.beacukai.go.id/CoarriCodeco_Container', // soapaction
        'rpc', // style
        'encoded', // use
        'Fungsi untuk insert data Coarri-Codeco Container(Baru, dengan penambahan kolom pada detil container)'// documentation
);

$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
$server->service($HTTP_RAW_POST_DATA);

function CheckConnection($Username, $Password) {
    global $CONF, $conn;
    $conn->connect();
    $IDLogServices = insertLogServices($Username, $Password, $CONF['url.wsdl'], 'CheckConnection', $fStream);

    $return = "Hello " . $Username;

    updateLogServices($IDLogServices, $return);
    $conn->disconnect();
    return $return;
}

function CoarriCodeco_Container($fStream, $Username, $Password) {
    global $CONF, $conn;
    $conn->connect();
    $IDLogServices = insertLogServices($Username, $Password, $CONF['url.wsdl'], 'CoarriCodeco_Container', $fStream);

    $xml2ary = xml2ary(strtoupper($fStream)); //print_r($xml);
    $xml = $xml2ary['DOCUMENT']['_c']['COCOCONT']['_c'];
    $HEADER = $xml['HEADER']['_c'];
    $KD_DOK = $HEADER['KD_DOK']['_v'] == '' ? "NULL" : "'" . strtoupper(trim($HEADER['KD_DOK']['_v'])) . "'";
    $KD_TPS = $HEADER['KD_TPS']['_v'] == '' ? "NULL" : "'" . strtoupper(trim($HEADER['KD_TPS']['_v'])) . "'";
    $NM_ANGKUT = $HEADER['NM_ANGKUT']['_v'] == '' ? "NULL" : "'" . strtoupper(trim($HEADER['NM_ANGKUT']['_v'])) . "'";
    $NO_VOY_FLIGHT = $HEADER['NO_VOY_FLIGHT']['_v'] == '' ? "NULL" : "'" . strtoupper(trim($HEADER['NO_VOY_FLIGHT']['_v'])) . "'";
    $CALL_SIGN = $HEADER['CALL_SIGN']['_v'] == '' ? "NULL" : "'" . strtoupper(trim($HEADER['CALL_SIGN']['_v'])) . "'";
    $TGL_TIBA = $HEADER['TGL_TIBA']['_v'] == '' ? "NULL" : "STR_TO_DATE('" . strtoupper(trim($HEADER['TGL_TIBA']['_v'])) . "','%Y%m%d')";
    $KD_GUDANG = $HEADER['KD_GUDANG']['_v'] == '' ? "NULL" : "'" . strtoupper(trim($HEADER['KD_GUDANG']['_v'])) . "'";
    $REF_NUMBER = $HEADER['REF_NUMBER']['_v'] == '' ? "NULL" : "'" . strtoupper(trim($HEADER['REF_NUMBER']['_v'])) . "'";

    /* if ($HEADER['KD_DOK']['_v'] != '3') {
      $return = 'KD_DOK not allowed.';
      updateLogServices($IDLogServices, $return);
      $conn->disconnect();
      return $return;
      } */

    switch ($HEADER['KD_DOK']['_v']) {
        case "1":
        case "3":
            $KD_ASAL_BRG = '1';
            break;
        case "2":
        case "4":
            $KD_ASAL_BRG = '3';
            break;
    }

    /*$SQL = "SELECT ID 
            FROM t_cocostshdr 
            WHERE NM_ANGKUT = " . $NM_ANGKUT . "
                  AND NO_VOY_FLIGHT = " . $NO_VOY_FLIGHT . "
                  AND TGL_TIBA = " . $TGL_TIBA . "
                  AND KD_TPS = " . $KD_TPS . "
                  AND KD_GUDANG = " . $KD_GUDANG . "
                  AND KD_ASAL_BRG = '" . $KD_ASAL_BRG . "'";*/
	$SQL = "SELECT ID 
            FROM t_cocostshdr 
            WHERE NM_ANGKUT = " . $NM_ANGKUT . "
                  AND NO_VOY_FLIGHT = " . $NO_VOY_FLIGHT . "
                  AND KD_TPS = " . $KD_TPS . "
                  AND KD_GUDANG = " . $KD_GUDANG . "
                  AND KD_ASAL_BRG = '" . $KD_ASAL_BRG . "'";
    $Query = $conn->query($SQL);
    $Size = $Query->size();
    if ($Size == 0) {
        $SQL = "INSERT INTO t_cocostshdr (KD_ASAL_BRG, KD_TPS, KD_GUDANG, NM_ANGKUT, CALL_SIGN, NO_VOY_FLIGHT, TGL_TIBA, WK_REKAM)
                VALUES ('" . $KD_ASAL_BRG . "', " . $KD_TPS . ", " . $KD_GUDANG . ", " . $NM_ANGKUT . ", " . $CALL_SIGN . ", " . $NO_VOY_FLIGHT . ", " . $TGL_TIBA . ", NOW())";
        $Execute = $conn->execute($SQL);
        $ID = mysql_insert_id();
    } else {
        $Query->next();
        $ID = $Query->get("ID");
    }

    if ($return == '') {
        $DETIL = $xml['DETIL']['_c']; //print_r($DETIL);
        $countContainer = count($DETIL['CONT']);
        if ($countContainer > 1) {
            for ($c = 0; $c < $countContainer; $c++) {
                $CONT = $DETIL['CONT'][$c]['_c'];
                $return = parseXmlCoarriCodeco_Container($CONT, $ID, $HEADER['KD_DOK']['_v']);
                if ($return == 'error') {
                    updateLogServices($IDLogServices, $return);
                    $conn->disconnect();
                    return $return;
                }
            }
        } elseif ($countContainer == 1) {
            $CONT = $DETIL['CONT']['_c'];
            $return = parseXmlCoarriCodeco_Container($CONT, $ID, $HEADER['KD_DOK']['_v']);
            if ($return == 'error') {
                updateLogServices($IDLogServices, $return);
                $conn->disconnect();
                return $return;
            }
        }
    }

    updateLogServices($IDLogServices, $return);
    $conn->disconnect();
    return $return;
}

function parseXmlCoarriCodeco_Container($CONT, $ID, $KD_DOK) {
    global $CONF, $conn;
    $NO_CONT = $CONT['NO_CONT']['_v'] == '' ? "NULL" : "'" . strtoupper(trim($CONT['NO_CONT']['_v'])) . "'";
    $UK_CONT = $CONT['UK_CONT']['_v'] == '' ? "NULL" : "'" . strtoupper(trim($CONT['UK_CONT']['_v'])) . "'";
    $NO_SEGEL = $CONT['NO_SEGEL']['_v'] == '' ? "NULL" : "'" . strtoupper(trim($CONT['NO_SEGEL']['_v'])) . "'";
    $JNS_CONT = $CONT['JNS_CONT']['_v'] == '' ? "NULL" : "'" . strtoupper(trim($CONT['JNS_CONT']['_v'])) . "'";
    $NO_BL_AWB = $CONT['NO_BL_AWB']['_v'] == '' ? "NULL" : "'" . strtoupper(trim($CONT['NO_BL_AWB']['_v'])) . "'";
    $TGL_BL_AWB = $CONT['TGL_BL_AWB']['_v'] == '' ? "NULL" : "STR_TO_DATE('" . strtoupper(trim($CONT['TGL_BL_AWB']['_v'])) . "','%Y%m%d')";
    $NO_MASTER_BL_AWB = $CONT['NO_MASTER_BL_AWB']['_v'] == '' ? "NULL" : "'" . strtoupper(trim($CONT['NO_MASTER_BL_AWB']['_v'])) . "'";
    $TGL_MASTER_BL_AWB = $CONT['TGL_MASTER_BL_AWB']['_v'] == '' ? "NULL" : "STR_TO_DATE('" . strtoupper(trim($CONT['TGL_MASTER_BL_AWB']['_v'])) . "','%Y%m%d')";
    $ID_CONSIGNEE = $CONT['ID_CONSIGNEE']['_v'] == '' ? "NULL" : "'" . strtoupper(trim($CONT['ID_CONSIGNEE']['_v'])) . "'";
    $CONSIGNEE = $CONT['CONSIGNEE']['_v'] == '' ? "NULL" : "'" . strtoupper(trim($CONT['CONSIGNEE']['_v'])) . "'";
    $BRUTO = $CONT['BRUTO']['_v'] == '' ? "NULL" : "'" . strtoupper(trim($CONT['BRUTO']['_v'])) . "'";
    $NO_BC11 = $CONT['NO_BC11']['_v'] == '' ? "NULL" : "'" . strtoupper(trim($CONT['NO_BC11']['_v'])) . "'";
    $TGL_BC11 = $CONT['TGL_BC11']['_v'] == '' ? "NULL" : "STR_TO_DATE('" . strtoupper(trim($CONT['TGL_BC11']['_v'])) . "','%Y%m%d')";
    $NO_POS_BC11 = $CONT['NO_POS_BC11']['_v'] == '' ? "NULL" : "'" . strtoupper(trim($CONT['NO_POS_BC11']['_v'])) . "'";
    $KD_TIMBUN = $CONT['KD_TIMBUN']['_v'] == '' ? "NULL" : "'" . strtoupper(trim($CONT['KD_TIMBUN']['_v'])) . "'";
    $KD_DOK_INOUT = $CONT['KD_DOK_INOUT']['_v'] == '' ? "NULL" : "'" . strtoupper(trim($CONT['KD_DOK_INOUT']['_v'])) . "'";
    $NO_DOK_INOUT = $CONT['NO_DOK_INOUT']['_v'] == '' ? "NULL" : "'" . strtoupper(trim($CONT['NO_DOK_INOUT']['_v'])) . "'";
    $TGL_DOK_INOUT = $CONT['TGL_DOK_INOUT']['_v'] == '' ? "NULL" : "STR_TO_DATE('" . strtoupper(trim($CONT['TGL_DOK_INOUT']['_v'])) . "','%Y%m%d')";
    $WK_INOUT = $CONT['WK_INOUT']['_v'] == '' ? "NULL" : "STR_TO_DATE('" . strtoupper(trim($CONT['WK_INOUT']['_v'])) . "','%Y%m%d%H%i%s')";
    $KD_SAR_ANGKUT_INOUT = $CONT['KD_SAR_ANGKUT_INOUT']['_v'] == '' ? "NULL" : "'" . strtoupper(trim($CONT['KD_SAR_ANGKUT_INOUT']['_v'])) . "'";
    $NO_POL = $CONT['NO_POL']['_v'] == '' ? "NULL" : "'" . strtoupper(trim($CONT['NO_POL']['_v'])) . "'";
    $FL_CONT_KOSONG = $CONT['FL_CONT_KOSONG']['_v'] == '' ? "NULL" : "'" . strtoupper(trim($CONT['FL_CONT_KOSONG']['_v'])) . "'";
    $ISO_CODE = $CONT['ISO_CODE']['_v'] == '' ? "NULL" : "'" . strtoupper(trim($CONT['ISO_CODE']['_v'])) . "'";
    $PEL_MUAT = $CONT['PEL_MUAT']['_v'] == '' ? "NULL" : "'" . strtoupper(trim($CONT['PEL_MUAT']['_v'])) . "'";
    $PEL_TRANSIT = $CONT['PEL_TRANSIT']['_v'] == '' ? "NULL" : "'" . strtoupper(trim($CONT['PEL_TRANSIT']['_v'])) . "'";
    $PEL_BONGKAR = $CONT['PEL_BONGKAR']['_v'] == '' ? "NULL" : "'" . strtoupper(trim($CONT['PEL_BONGKAR']['_v'])) . "'";
    $GUDANG_TUJUAN = $CONT['GUDANG_TUJUAN']['_v'] == '' ? "NULL" : "'" . strtoupper(trim($CONT['GUDANG_TUJUAN']['_v'])) . "'";
    $KODE_KANTOR = $CONT['KODE_KANTOR']['_v'] == '' ? "NULL" : "'" . strtoupper(trim($CONT['KODE_KANTOR']['_v'])) . "'";
    $NO_DAFTAR_PABEAN = $CONT['NO_DAFTAR_PABEAN']['_v'] == '' ? "NULL" : "'" . strtoupper(trim($CONT['NO_DAFTAR_PABEAN']['_v'])) . "'";
    $TGL_DAFTAR_PABEAN = $CONT['TGL_DAFTAR_PABEAN']['_v'] == '' ? "NULL" : "STR_TO_DATE('" . strtoupper(trim($CONT['TGL_DAFTAR_PABEAN']['_v'])) . "','%Y%m%d')";
    $NO_SEGEL_BC = $CONT['NO_SEGEL_BC']['_v'] == '' ? "NULL" : "'" . strtoupper(trim($CONT['NO_SEGEL_BC']['_v'])) . "'";
    $TGL_SEGEL_BC = $CONT['TGL_SEGEL_BC']['_v'] == '' ? "NULL" : "STR_TO_DATE('" . strtoupper(trim($CONT['TGL_SEGEL_BC']['_v'])) . "','%Y%m%d')";
    $NO_IJIN_TPS = $CONT['NO_IJIN_TPS']['_v'] == '' ? "NULL" : "'" . strtoupper(trim($CONT['NO_IJIN_TPS']['_v'])) . "'";
    $TGL_IJIN_TPS = $CONT['TGL_IJIN_TPS']['_v'] == '' ? "NULL" : "STR_TO_DATE('" . strtoupper(trim($CONT['TGL_IJIN_TPS']['_v'])) . "','%Y%m%d')";

    $SQL = "SELECT ID FROM t_organisasi WHERE NPWP = " . $ID_CONSIGNEE . "";
    $Query = $conn->query($SQL);
    if ($Query->size() > 0) {
        $Query->next();
        $KD_ORG_CONSIGNEE = "'" . $Query->get('ID') . "'";
    } else {
        $SQL = "INSERT INTO t_organisasi (NPWP, NAMA, KD_TIPE_ORGANISASI)
                VALUES (" . $ID_CONSIGNEE . ", " . $CONSIGNEE . ", 'CONS')";
        $Execute = $conn->execute($SQL);
        if ($Execute) {
            $KD_ORG_CONSIGNEE = "'" . mysql_insert_id() . "'";
        } else {
            $KD_ORG_CONSIGNEE = "NULL";
        }
    }

    $SQL = "SELECT KD_TPS, KD_GUDANG FROM reff_gudang WHERE KD_GUDANG = " . $GUDANG_TUJUAN . "";
    $Query = $conn->query($SQL);
    if ($Query->size() > 0) {
        $Query->next();
        $KD_TPS_TUJUAN = "'" . $Query->get('KD_TPS') . "'";
        $KD_GUDANG_TUJUAN = "'" . $Query->get('KD_GUDANG') . "'";
    } else {
        $KD_TPS_TUJUAN = "NULL";
        $KD_GUDANG_TUJUAN = "NULL";
    }

    switch (strtoupper(trim($CONT['JNS_CONT']['_v']))) {
        case "F":
            $KD_CONT_STATUS_INOUT = "'FCL'";
            break;
        case "L":
            $KD_CONT_STATUS_INOUT = "'LCL'";
            break;
        case "E":
            $KD_CONT_STATUS_INOUT = "'MTY'";
            break;
        default:
            $KD_CONT_STATUS_INOUT = "NULL";
            break;
    }

    $insertArr = array();
    $fieldName = array();
    $ValueData = array();
    $insertArrDefault = array("ID" => "'" . $ID . "'",
        "NO_CONT" => $NO_CONT,
        "KD_CONT_UKURAN" => $UK_CONT,
        "KD_CONT_JENIS" => $JNS_CONT,
        //"KD_CONT_TIPE" => "'" .  . "'",
        "KD_ISO_CODE" => $ISO_CODE,
        //"TEMPERATURE" => "'" .  . "'",
        "BRUTO" => $BRUTO,
        "NO_SEGEL" => $NO_SEGEL,
        //"KONDISI_SEGEL" => "'" .  . "'",
        "NO_BL_AWB" => $NO_BL_AWB,
        "TGL_BL_AWB" => $TGL_BL_AWB,
        "NO_MASTER_BL_AWB" => $NO_MASTER_BL_AWB,
        "TGL_MASTER_BL_AWB" => $TGL_MASTER_BL_AWB,
        "NO_POS_BC11" => $NO_POS_BC11,
        "KD_ORG_CONSIGNEE" => $KD_ORG_CONSIGNEE,
        //"KD_TIMBUN_KAPAL" => "'" .  . "'",
        "KD_TIMBUN" => $KD_TIMBUN,
        "KD_PEL_MUAT" => $PEL_MUAT,
        "KD_PEL_TRANSIT" => $PEL_TRANSIT,
        "KD_PEL_BONGKAR" => $PEL_BONGKAR,
        "KD_TPS_TUJUAN" => $KD_TPS_TUJUAN,
        "KD_GUDANG_TUJUAN" => $KD_GUDANG_TUJUAN,
        "KD_KANTOR_PABEAN" => $KODE_KANTOR,
        "NO_DAFTAR_PABEAN" => $NO_DAFTAR_PABEAN,
        "TGL_DAFTAR_PABEAN" => $TGL_DAFTAR_PABEAN,
        "NO_SEGEL_BC" => $NO_SEGEL_BC,
        "TGL_SEGEL_BC" => $TGL_SEGEL_BC,
        "NO_IJIN_TPS" => $NO_IJIN_TPS,
        "TGL_IJIN_TPS" => $TGL_IJIN_TPS,
        "FL_CONT_KOSONG" => $FL_CONT_KOSONG,
    );

    $insertGateInArr = array("KD_DOK_IN" => $KD_DOK_INOUT,
        "NO_DOK_IN" => $NO_DOK_INOUT,
        "TGL_DOK_IN" => $TGL_DOK_INOUT,
        "WK_IN" => $WK_INOUT,
        "KD_CONT_STATUS_IN" => $KD_CONT_STATUS_INOUT,
        "KD_SARANA_ANGKUT_IN" => $KD_SAR_ANGKUT_INOUT,
        "NO_POL_IN" => $NO_POL,
        "WK_REKAM" => "NOW()");

    $insertGateOutArr = array("KD_DOK_OUT" => $KD_DOK_INOUT,
        "NO_DOK_OUT" => $NO_DOK_INOUT,
        "TGL_DOK_OUT" => $TGL_DOK_INOUT,
        "WK_OUT" => $WK_INOUT,
        "KD_CONT_STATUS_OUT" => $KD_CONT_STATUS_INOUT,
        "KD_SARANA_ANGKUT_OUT" => $KD_SAR_ANGKUT_INOUT,
        "NO_POL_OUT" => $NO_POL);

    switch ($KD_DOK) {
        case "1":
        case "4":
            $insertArr = array_merge($insertArrDefault, $insertGateInArr);
            $ExecuteData = 'INSERT';
            break;
        case "2":
        case "3":
            $insertArr = array_merge($insertArrDefault, $insertGateOutArr);
            $ExecuteData = 'UPDATE';
            break;
    }

    if ($ExecuteData == 'INSERT') {
        foreach ($insertArr as $field => $value) {
            $fieldName[] = $field;
            $ValueData[] = $value;
        }
        $SQL = "INSERT INTO t_cocostscont(" . implode(", ", $fieldName) . ") VALUES (" . implode(", ", $ValueData) . ")";
    } else {
        $parameterArr = array("ID" => "'" . $ID . "'", "NO_CONT" => $NO_CONT);
        foreach ($insertArr as $field => $value) {
            $updated[] = $field . " = " . $value;
        }
        foreach ($parameterArr as $field => $value) {
            $parameter[] = $field . " = " . $value;
        }
        $SQL = "UPDATE t_cocostscont SET " . implode(", ", $updated) . "
                WHERE " . implode(" AND ", $parameter) . "";
    }
    //echo $SQL;
    $Execute = $conn->execute($SQL);
    if ($Execute) {
        $return = 'success';
        $SQL = "UPDATE t_cocostshdr SET KD_PEL_MUAT = " . $PEL_MUAT . ", KD_PEL_TRANSIT = " . $PEL_TRANSIT . ", KD_PEL_BONGKAR = " . $PEL_BONGKAR . "
                WHERE ID = '" . $ID . "'";
        $Execute = $conn->execute($SQL);
        switch ($KD_DOK) {
            case "1":
            case "3":
                $SQL = "UPDATE t_cocostshdr SET NO_BC11 = " . $NO_BC11 . ", TGL_BC11 = " . $TGL_BC11 . "
                        WHERE ID = '" . $ID . "'
                              AND NO_BC11 IS NULL";
                $Execute = $conn->execute($SQL);
                break;
        }
    } else {
        $return = 'error' . $SQL;
    }
    //$return = 'success';
    return $return;
}

function insertLogServices($userName, $Password, $url, $method, $xmlRequest = '', $xmlResponse = '') {
    global $CONF, $conn;
    $ipAddress = getIP();
    $userName = $userName == '' ? 'NULL' : "'" . $userName . "'";
    $Password = $Password == '' ? 'NULL' : "'" . $Password . "'";
    $url = $url == '' ? 'NULL' : "'" . $url . "'";
    $method = $method == '' ? 'NULL' : "'" . $method . "'";
    $xmlRequest = $xmlRequest == '' ? 'NULL' : "'" . $xmlRequest . "'";
    $xmlResponse = $xmlResponse == '' ? 'NULL' : "'" . $xmlResponse . "'";
    $SQL = "INSERT INTO app_log_server (USERNAME, PASSWORD, URL, METHOD, REQUEST, RESPONSE, IP_ADDRESS, WK_REKAM)
            VALUES (" . $userName . ", " . $Password . ", " . $url . ", " . $method . ", " . $xmlRequest . ", " . $xmlResponse . ", '" . $ipAddress . "', NOW())";
    $Execute = $conn->execute($SQL);
    $ID = mysql_insert_id();
    return $ID;
}

function updateLogServices($ID, $xmlResponse = '') {
    global $CONF, $conn;
    $xmlResponse = $xmlResponse == '' ? 'NULL' : "'" . $xmlResponse . "'";
    $SQL = "UPDATE app_log_server SET RESPONSE = " . $xmlResponse . "
            WHERE ID = '" . $ID . "'";
    $Execute = $conn->execute($SQL);
}

function SendCurl($xml, $url, $SOAPAction, $proxy = "", $port = "443") {
    $header[] = 'Content-Type: text/xml';
    $header[] = 'SOAPAction: "' . $SOAPAction . '"';
    $header[] = 'Content-length: ' . strlen($xml);
    $header[] = 'Connection: close';

    $ch = curl_init();
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

function getIP($type = 0) {
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
?>

