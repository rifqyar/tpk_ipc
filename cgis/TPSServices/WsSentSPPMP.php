<?php
set_time_limit(3600);
require_once("config.php");
//$CONF['url.wsdl'] = 'http://103.29.187.109/TPSServices/services.php';
$method = 'sendContSppmp';
$KdAPRF = 'GETIMPPERMIT';
$filename = $CONF['root.dir'] . "CheckScheduler/" . $method . ".txt";
echo "sini";die();
$main = new main($CONF, $conn);
$CheckFile = $main->CheckFile($filename);
if (!$CheckFile) {
	echo "sini";
    //$createFile = $main->createFile($filename);
    $main->connect();

    //BEGIN
    $SOAPAction = 'http://192.168.5.22/tps-all/TPSServices/servergrd.php/' . $method;
    $SQL = "SELECT A.NM_ANGKUT, A.NO_VOY_FLIGHT, A.CALL_SIGN,A.TGL_TIBA, B.NO_CONT
            FROM t_cocostshdr A
            INNER JOIN t_cocostscont_new B ON A.ID=B.ID
            WHERE A.KD_ASAL_BRG = '1'
            LIMIT 1";
                  
    $Query = $conn->query($SQL);
    if ($Query->size() > 0) {
        while ($Query->next()) {
            $NM_ANGKUT = $Query->get("NM_ANGKUT");
            $NO_VOY_FLIGHT = $Query->get("NO_VOY_FLIGHT");
            $CALL_SIGN = $Query->get("CALL_SIGN");
            $TGL_TIBA = $Query->get("TGL_TIBA");
            $NO_CONT = $Query->get("NO_CONT");
			
			$xml = '<?xml version="1.0"?>
					<DOCUMENT>
						<SPPMP>
							<NM_ANGKUT>'.$NM_ANGKUT.'</NM_ANGKUT>
							<NO_VOY_FLIGHT>'.$NO_VOY_FLIGHT.'</NO_VOY_FLIGHT>
							<CALL_SIGN>'.$CALL_SIGN.'</CALL_SIGN>
							<TGL_TIBA>'.$TGL_TIBA.'</TGL_TIBA>
							<NO_CONT>'.$NO_CONT.'</NO_CONT>
						</SPPMP>
					</DOCUMENT>'; 
			echo $xml;die();
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