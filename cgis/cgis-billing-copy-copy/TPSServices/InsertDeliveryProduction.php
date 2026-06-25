<?php 
die();
ini_set('display_errors', 1);
error_reporting(E_ALL);
error_reporting(E_ALL & ~E_NOTICE);
set_time_limit(3600);
require_once("config.php");
$jam_awal = "12";
$jam_akhir = "23";
$method = 'InsertDeliveryProduction';
$filename = $CONF['root.dir'] . "CheckScheduler/" . $method . ".txt";
$main = new main($CONF, $conn);
$CheckFile = $main->CheckFile($filename);
if (!$CheckFile) {
	$createFile = $main->createFile($filename);
    $main->connect();
    if (date('H') >= $jam_awal && date('H') <= $jam_akhir) {
		$SQL1 = "SELECT A.ID_REQ, A.TGL_REQ, A.JNS_DOK, A.NO_DOK, A.TGL_DOK, A.NM_KAPAL, A.NO_VOY, A.NO_NOTA_DELIVERY, A.TGL_NOTA, C.WK_IN, C.WK_OUT, B.NO_CONT, B.UKR_CONT, B.ISO_CODE, B.`STATUS`, B.TARIF_ID, B.CHARGE
				FROM req_delivery_hdr A
				INNER JOIN req_delivery_dtl B ON A.ID_REQ = B.ID_REQ
				INNER JOIN t_cocostscont C ON B.NO_CONT = C.NO_CONT
				LEFT JOIN t_cocostshdr D ON A.NM_KAPAL = D.NM_ANGKUT AND A.NO_VOY = D.NO_VOY_FLIGHT
				WHERE A.NO_NOTA_DELIVERY !='' AND C.WK_OUT IS NOT NULL AND C.WK_IN IS NOT NULL AND B.FL_PRODUCTION ='N' AND A.ID_REQ NOT LIKE 'EXT%'
				GROUP BY B.NO_CONT
			-- LIMIT 100
			";
			// echo $SQL1 . '<br>';
			$Query1 = $conn->query($SQL1);
	        if ($Query1->size() > 0) {
	            while ($Query1->next()) {
	                $ID_REQ 	= $Query1->get('ID_REQ');
					$TGL_REQ 	= $Query1->get('TGL_REQ');
					$JNS_DOK 	= $Query1->get('JNS_DOK');
					$NO_DOK 	= $Query1->get('NO_DOK');
					$TGL_DOK 	= $Query1->get('TGL_DOK');
					$NM_KAPAL 	= $Query1->get('NM_KAPAL');
					$NO_VOY 	= $Query1->get('NO_VOY');
					$NOTA_DEL 	= $Query1->get('NO_NOTA_DELIVERY');
					$TGL_NOTA 	= $Query1->get('TGL_NOTA');
					$WK_IN 		= $Query1->get('WK_IN');
					$WK_OUT 	= $Query1->get('WK_OUT');
					$NO_CONT 	= $Query1->get('NO_CONT');
					$UKR_CONT 	= $Query1->get('UKR_CONT');
					$ISO_CODE 	= $Query1->get('ISO_CODE');
					$STATUS 	= $Query1->get('STATUS');
					$TARIF_ID 	= $Query1->get('TARIF_ID');
					$CHARGE 	= $Query1->get('CHARGE');

					$SelisihMasa3	 = 0;
					$PenumpukanMasa3 = 0;
					$jam 			 = date("Hi", strtotime($WK_IN));
					if ($jam > "1200"){
						$MasaBebas = date("Y-m-d", strtotime($WK_IN . "+1 days"));
					} else {
						$MasaBebas = date("Y-m-d", strtotime($WK_IN));
					}

					$Masa1 		= date("Y-m-d", strtotime($MasaBebas . "+1 days")); 
                    $Masa2 		= date("Y-m-d", strtotime($Masa1 . "+1 days")); 
                    $Masa3 		= date("Y-m-d", strtotime($Masa2 . "+1 days")); 
                    $PaidThru 	= date("Y-m-d", strtotime($WK_OUT));
					
					$DateTime1   = new DateTime($MasaBebas);
                    $DateTime2   = new DateTime($PaidThru);
                    $difference  = $DateTime1->diff($DateTime2);
                    $selisihDiff = $difference->days;
                    $selisih     = $selisihDiff;
					
					for ($i=0; $i <= $selisih; $i++) { 
                        $checkDate = date("Y-m-d", strtotime($i . " days" . $MasaBebas));
                        if ($checkDate == $MasaBebas) {
                            $SelisihMasaBebas = 0;
                            $PenumpukanMasaBebas = $SelisihMasaBebas * ($CHARGE * 0);
                        }
                        if ($checkDate == $Masa1) {
                            $SelisihMasa1 = 1;
                            $PenumpukanMasa1 = $SelisihMasa1 * ($CHARGE * 3);
                        }
                        if ($checkDate == $Masa2) {
                            $SelisihMasa2 = 1;
                            $PenumpukanMasa2 = $SelisihMasa2 * ($CHARGE * 6);
                        }
                        if (($checkDate >= $Masa3)&&($checkDate <= $PaidThru)) {
                            $SelisihMasa3 ++;
                            $PenumpukanMasa3 = $PenumpukanMasa3 + ($CHARGE * 9);
                        }
                    }
					
					$TotalTagihan 	= $PenumpukanMasa1 + $PenumpukanMasa2 + $PenumpukanMasa3;
					$TotalSelisih	= $SelisihMasa1 + $SelisihMasa2 + $SelisihMasa3;
					
					/* QUERY INSERT */
					$SQL2 = "INSERT INTO `req_delivery_production` (`ID_REQ`, `TGL_REQ`, `JNS_DOK`, `NO_DOK`, `TGL_DOK`, `NM_KAPAL`, `NO_VOY`, `NO_NOTA_DELIVERY`, `TGL_NOTA`, `TGL_GATEIN`, `TGL_GATEOUT`, `NO_CONT`, `UKR_CONT`, `ISO_CODE`, `STATUS`, `TARIF_ID`, `CHARGE`, `SELISIH_HARI`, `TOTAL`, `WK_REKAM`) VALUES ('". $ID_REQ ."', '". $TGL_REQ ."', '". $JNS_DOK ."', '". $NO_DOK ."', '". $TGL_DOK ."', '". $NM_KAPAL ."', '". $NO_VOY ."', '". $NOTA_DEL ."', '". $TGL_NOTA ."', '". $WK_IN ."', '". $WK_OUT ."', '". $NO_CONT ."', '". $UKR_CONT ."', '". $ISO_CODE ."', '". $STATUS ."', '". $TARIF_ID ."', '". $CHARGE ."', '". $TotalSelisih ."', '". $TotalTagihan ."', NOW())";
					echo $SQL2 . '<br>';
					$Execute1 = $conn->execute($SQL2);
					if($Execute1){
						echo 'Sukses Insert<br>';
						$SQL3 = "SELECT TARIF FROM m_tarif WHERE SIZE = '". $UKR_CONT ."' AND STATUS =  '". $STATUS ."' AND JENIS_BIAYA = 'LIFT ON'";
						$Query2 = $conn->query($SQL3);
			            if ($Query2->size() > 0) {
			                $Query2->next();
			                $TARIF_LO = $Query2->get('TARIF');

			                $SQL4 = "UPDATE `req_delivery_production` SET LIFT_ON = '".$TARIF_LO."' WHERE ID_REQ ='".$ID_REQ."' AND NO_CONT = '".$NO_CONT."'";
			                echo $SQL4 . '<br>';
							$Execute2 = $conn->execute($SQL4);
							if($Execute2){
								echo "Sukses Update<br>";
								$SQL5 ="UPDATE req_delivery_dtl SET FL_PRODUCTION ='Y' WHERE ID_REQ='".$ID_REQ."' AND NO_CONT='". $NO_CONT ."'";
								echo $SQL5 . '<br>';
                    			$Execute3 = $conn->execute($SQL5);
                    			if($Execute3){
                    				echo "Sukses Update Delivery HDR<br>";
                    			} else {
                    				echo "Gagal Update Delivery HDR<br>";
                    			}
							} else {
								echo "Gagal Update<br>";
							}
			            }
					} else{
						echo 'Gagal Insert<br>';
					}
					echo '<hr>';
	            }
	        } else {
	            echo "Data tidak ada";
	            echo '<hr>';
	        }
	} else {
        echo "Scheduler akan berjalan pada pukul " . $jam_awal . " sampai dengan " . $jam_akhir;
    }
$main->connect(false);
$main->removeFile($filename);
} else {
    echo 'Scheduler sedang berjalan, harap menghapus file ' . $method . '.txt yang ada difolder CheckScheduler.';
}
?>