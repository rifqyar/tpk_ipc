<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class M_read extends CI_Model{
	
	function repository(){
		#error_reporting(E_ALL);
		$func =&get_instance();
		$func->load->model("m_main","main", true);
		date_default_timezone_set('Asia/Jakarta');
		$NOW = date('Y-m-d H:i:s');
		$SQL = "SELECT A.ID, A.KD_ASAL_BRG, A.KD_TPS, A.KD_GUDANG, A.KD_KAPAL, TRIM(A.NM_ANGKUT) AS NM_ANGKUT, 
				TRIM(A.NO_VOY_FLIGHT) AS NO_VOY_FLIGHT, TRIM(A.CALL_SIGN) AS CALL_SIGN, A.TGL_TIBA,
				TRIM(A.NO_BC11) AS NO_BC11, A.TGL_BC11, TRIM(A.KD_PEL_MUAT) AS PEL_MUAT, TRIM(A.KD_PEL_TRANSIT) AS PEL_TRANSIT,
				TRIM(A.KD_PEL_BONGKAR) AS PEL_BONGKAR,
				TRIM(B.NO_CONT) AS NO_CONT, TRIM(B.KD_CONT_UKURAN) AS KD_CONT_UKURAN, TRIM(B.KD_CONT_JENIS) AS KD_CONT_JENIS, 
				TRIM(B.KD_CONT_TIPE) AS KD_CONT_TIPE, TRIM(B.KD_ISO_CODE) AS KD_ISO_CODE, TRIM(B.TEMPERATURE) AS TEMPERATURE, 
				TRIM(B.BRUTO) AS BRUTO, TRIM(B.NO_SEGEL) AS NO_SEGEL, TRIM(B.KONDISI_SEGEL) AS KONDISI_SEGEL, 
				TRIM(B.NO_BL_AWB) AS NO_BL_AWB, B.TGL_BL_AWB, TRIM(B.NO_MASTER_BL_AWB) AS NO_MASTER_BL_AWB,
				B.TGL_MASTER_BL_AWB, TRIM(B.NO_POS_BC11) AS NO_POS_BC11, TRIM(B.KD_ORG_CONSIGNEE) AS KD_ORG_CONSIGNEE,
				TRIM(B.KD_TIMBUN_KAPAL) AS KD_TIMBUN_KAPAL, TRIM(B.KD_TIMBUN) AS KD_TIMBUN, TRIM(B.KD_PEL_MUAT) AS KD_PEL_MUAT, 
				TRIM(B.KD_PEL_TRANSIT) AS KD_PEL_TRANSIT, TRIM(B.KD_PEL_BONGKAR) AS KD_PEL_BONGKAR, TRIM(B.KD_DOK_IN) AS KD_DOK_IN, 
				TRIM(B.NO_DOK_IN) AS NO_DOK_IN, B.TGL_DOK_IN, TRIM(B.WK_IN) AS WK_IN, 
				TRIM(B.KD_CONT_STATUS_IN) AS KD_CONT_STATUS_IN, TRIM(B.KD_SARANA_ANGKUT_IN) AS KD_SARANA_ANGKUT_IN, 
				TRIM(B.NO_POL_IN) AS NO_POL_IN, TRIM(B.KD_DOK_OUT) AS KD_DOK_OUT, TRIM(B.NO_DOK_OUT) AS NO_DOK_OUT, 
				B.TGL_DOK_OUT, TRIM(B.WK_OUT) AS WK_OUT, TRIM(B.KD_CONT_STATUS_OUT) AS KD_CONT_STATUS_OUT,
				TRIM(B.KD_SARANA_ANGKUT_OUT) AS KD_SARANA_ANGKUT_OUT, TRIM(B.NO_POL_OUT) AS NO_POL_OUT, TRIM(B.KD_TPS_TUJUAN) AS KD_TPS_TUJUAN,
				TRIM(B.KD_GUDANG_TUJUAN) AS KD_GUDANG_TUJUAN, TRIM(B.KD_KANTOR_PABEAN) AS KD_KANTOR_PABEAN, 
				TRIM(B.NO_DAFTAR_PABEAN) AS NO_DAFTAR_PABEAN, B.TGL_DAFTAR_PABEAN, 
				TRIM(B.NO_SEGEL_BC) AS NO_SEGEL_BC, B.TGL_SEGEL_BC, TRIM(B.NO_IJIN_TPS) AS NO_IJIN_TPS, 
				B.TGL_IJIN_TPS, TRIM(B.FL_CONT_KOSONG) AS FL_CONT_KOSONG, TRIM(B.FL_TRANSFER_IN) AS FL_TRANSFER_IN,
				TRIM(B.FL_TRANSFER_OUT) AS FL_TRANSFER_OUT, B.WK_REKAM
				FROM t_repohdr A
				INNER JOIN t_repocont B ON B. ID=A.ID
				LEFT JOIN reff_asal_brg C ON C.ID=A.KD_ASAL_BRG
				WHERE B.FL_USE = 'N'
					  AND CASE A.KD_ASAL_BRG
								WHEN '1' THEN A.NO_BC11 IS NOT NULL AND A.TGL_BC11 IS NOT NULL
								WHEN '4' THEN A.NO_BC11 IS NULL AND A.TGL_BC11 IS NULL
								WHEN '3' THEN A.NO_BC11 IS NOT NULL AND A.TGL_BC11 IS NOT NULL
								WHEN '2' THEN A.NO_BC11 IS NOT NULL AND A.TGL_BC11 IS NOT NULL
							END
					  AND CASE A.KD_ASAL_BRG
						  WHEN '2' THEN B.KD_DOK_OUT IS NOT NULL OR B.NO_DOK_OUT IS NOT NULL OR B.TGL_DOK_OUT IS NOT NULL 
								   OR B.NO_DAFTAR_PABEAN IS NOT NULL OR B.TGL_DAFTAR_PABEAN IS NOT NULL
						  WHEN '4' THEN B.KD_DOK_IN IS NOT NULL OR B.NO_DOK_IN IS NOT NULL OR B.TGL_DOK_IN IS NOT NULL 
								   OR B.NO_DAFTAR_PABEAN IS NOT NULL OR B.TGL_DAFTAR_PABEAN IS NOT NULL
						  ELSE 1=1
						  END
				ORDER BY C.URUTAN ASC LIMIT 0,30";
		#echo $SQL; die();
		$result = $func->main->get_result($SQL);
		if($result){
			foreach($SQL->result_array() as $row => $value){
				$arrdata[] = $value;
			}
			foreach($arrdata as $data){
				$V_KD_ASAL_BRG = $data['KD_ASAL_BRG'];
				#COARRI DISCHARGE
				if($V_KD_ASAL_BRG == '1'){
					$SQL_HEADER = "SELECT ID FROM t_cocostshdr 
								   WHERE KD_ASAL_BRG = ".$wms_db->escape($data['KD_ASAL_BRG'])."
								   		 AND NO_VOY_FLIGHT = ".trim($wms_db->escape($data['NO_VOY_FLIGHT']))."
										 AND CALL_SIGN = ".trim($wms_db->escape($data['CALL_SIGN']))."";
										 //AND TGL_TIBA = ".trim($wms_db->escape($data['TGL_TIBA']));
					$res_header = $func->main->get_result($SQL_HEADER);
					if($res_header){
						foreach($SQL_HEADER->result_array() as $row => $value){
							$arrheader = $value;
						}
						$arr_in_header['KD_KAPAL'] 		 = $this->emptystr($data['KD_KAPAL']);
						$arr_in_header['NM_ANGKUT'] 	 = $this->emptystr($data['NM_ANGKUT']);
						$arr_in_header['NO_VOY_FLIGHT']  = $this->emptystr($data['NO_VOY_FLIGHT']);
						$arr_in_header['CALL_SIGN'] 	 = $this->emptystr($data['CALL_SIGN']);
						$arr_in_header['TGL_TIBA'] 		 = $this->emptystr($data['TGL_TIBA']);
						$arr_in_header['NO_BC11'] 		 = $this->emptystr($data['NO_BC11']);
						$arr_in_header['TGL_BC11'] 		 = $this->emptystr($data['TGL_BC11']);
						$arr_in_header['KD_PEL_MUAT'] 	 = $this->emptystr($data['PEL_MUAT']);
						$arr_in_header['KD_PEL_TRANSIT'] = $this->emptystr($data['PEL_TRANSIT']);
						$arr_in_header['KD_PEL_BONGKAR'] = $this->emptystr($data['PEL_BONGKAR']);
						
						$wms_db->where(array('ID' => $arrheader['ID']));
						$wms_db->update('t_cocostshdr',$arr_in_header);
						$ID = $arrheader['ID'];
					}else{
						$arr_in_header['KD_ASAL_BRG'] 	 = '1';
						$arr_in_header['KD_TPS'] 	  	 = 'NCT1';
						$arr_in_header['KD_GUDANG'] 	 = 'NCT1';
						$arr_in_header['FL_FROM'] 	 	 = 'FTP';
						$arr_in_header['KD_KAPAL'] 		 = $this->emptystr($data['KD_KAPAL']);
						$arr_in_header['NM_ANGKUT'] 	 = $this->emptystr($data['NM_ANGKUT']);
						$arr_in_header['NO_VOY_FLIGHT']  = $this->emptystr($data['NO_VOY_FLIGHT']);
						$arr_in_header['CALL_SIGN'] 	 = $this->emptystr($data['CALL_SIGN']);
						$arr_in_header['TGL_TIBA'] 		 = $this->emptystr($data['TGL_TIBA']);
						$arr_in_header['NO_BC11'] 		 = $this->emptystr($data['NO_BC11']);
						$arr_in_header['TGL_BC11'] 		 = $this->emptystr($data['TGL_BC11']);
						$arr_in_header['KD_PEL_MUAT'] 	 = $this->emptystr($data['PEL_MUAT']);
						$arr_in_header['KD_PEL_TRANSIT'] = $this->emptystr($data['PEL_TRANSIT']);
						$arr_in_header['KD_PEL_BONGKAR'] = $this->emptystr($data['PEL_BONGKAR']);
						
						$arr_in_header['WK_REKAM'] 		 = $NOW;
						$wms_db->insert('t_cocostshdr',$arr_in_header);
						$ID = $wms_db->insert_id();
						if($ID!=""){
							echo "DISCHARGE [INSERT HEADER]<br>";
						}
						
					}
					if($ID!=""){
						$SQL_CONT = "SELECT NO_CONT FROM t_cocostscont
									 WHERE ID = ".$wms_db->escape($ID)."
									 	   AND NO_CONT = ".$wms_db->escape($data['NO_CONT']);
						$res_cont = $func->main->get_result($SQL_CONT);
						if($res_cont){
							foreach($SQL_CONT->result_array() as $row => $value){
								$arrcont = $value;
							}
							$NEW_ID = $data['ID'];
							$NEW_CONT = $data['NO_CONT'];
							unset($data['ID']);
							unset($data['KD_ASAL_BRG']);
							unset($data['KD_TPS']);
							unset($data['KD_GUDANG']);
							unset($data['KD_KAPAL']);
							unset($data['NM_ANGKUT']);
							unset($data['NO_VOY_FLIGHT']);
							unset($data['CALL_SIGN']);
							unset($data['TGL_TIBA']);
							unset($data['NO_BC11']);
							unset($data['TGL_BC11']);
							unset($data['PEL_MUAT']);
							unset($data['PEL_TRANSIT']);
							unset($data['PEL_BONGKAR']);
							unset($data['NO_CONT']);
							unset($data['WK_OUT']);
							$data['WK_REKAM'] = $NOW;
							
							$wms_db->where(array('ID' => $ID, 'NO_CONT' => $arrcont['NO_CONT']));
							$res = $wms_db->update('t_cocostscont',$data);
							if($res){
								echo $arr_in_header['NM_ANGKUT']."&nbsp;&nbsp;- DISCHARGE [UPDATE CONTAINER ".$NEW_ID."] - ".$NEW_CONT." IN ".$data['WK_IN']."<BR>";
							}
						}else{
							$NEW_ID = $data['ID'];
							$NEW_CONT = $data['NO_CONT'];
							unset($data['ID']);
							unset($data['KD_ASAL_BRG']);
							unset($data['KD_TPS']);
							unset($data['KD_GUDANG']);
							unset($data['KD_KAPAL']);
							unset($data['NM_ANGKUT']);
							unset($data['NO_VOY_FLIGHT']);
							unset($data['CALL_SIGN']);
							unset($data['TGL_TIBA']);
							unset($data['NO_BC11']);
							unset($data['TGL_BC11']);
							unset($data['PEL_MUAT']);
							unset($data['PEL_TRANSIT']);
							unset($data['PEL_BONGKAR']);
							unset($data['WK_OUT']);
							$data['ID'] = $ID;
							$data['WK_REKAM'] = $NOW;
							
							$res = $wms_db->insert('t_cocostscont',$data);
							if($res){
								$RESPONSE = "SUCCESS";
								echo $arr_in_header['NM_ANGKUT']."&nbsp;&nbsp;- DISCHARGE [INSERT CONTAINER ".$NEW_ID."] - ".$NEW_CONT." IN ".$data['WK_IN']."<BR>";
							}else{
								$RESPONSE = "FAILED";
							}
						}
						$this->update_repo($NEW_ID,$NEW_CONT,$RESPONSE);
					}
				}
				
				#CODECO IMPOR [GATE OUT]
				if($V_KD_ASAL_BRG == '2'){
					$SQL_CONT = "SELECT A.ID, A.KD_ASAL_BRG, A.KD_TPS, A.KD_GUDANG, A.KD_KAPAL, TRIM(A.NM_ANGKUT) AS NM_ANGKUT, 
								 TRIM(A.NO_VOY_FLIGHT) AS NO_VOY_FLIGHT, TRIM(A.CALL_SIGN) AS CALL_SIGN, TRIM(A.TGL_TIBA) AS TGL_TIBA,
								 TRIM(A.NO_BC11) AS NO_BC11, TRIM(A.TGL_BC11) AS TGL_BC11, TRIM(A.KD_PEL_MUAT) AS PEL_MUAT, 
								 TRIM(A.KD_PEL_TRANSIT) AS PEL_TRANSIT, TRIM(A.KD_PEL_BONGKAR) AS PEL_BONGKAR,
								 TRIM(B.NO_CONT) AS NO_CONT, TRIM(B.KD_CONT_UKURAN) AS KD_CONT_UKURAN, TRIM(B.KD_CONT_JENIS) AS KD_CONT_JENIS, 
								 TRIM(B.KD_CONT_TIPE) AS KD_CONT_TIPE, TRIM(B.KD_ISO_CODE) AS KD_ISO_CODE, TRIM(B.TEMPERATURE) AS TEMPERATURE, 
								 TRIM(B.BRUTO) AS BRUTO, TRIM(B.NO_SEGEL) AS NO_SEGEL, TRIM(B.KONDISI_SEGEL) AS KONDISI_SEGEL, 
								 TRIM(B.NO_BL_AWB) AS NO_BL_AWB, TRIM(B.TGL_BL_AWB) AS TGL_BL_AWB, TRIM(B.NO_MASTER_BL_AWB) AS NO_MASTER_BL_AWB,
								 TRIM(B.TGL_MASTER_BL_AWB) AS TGL_MASTER_BL_AWB, TRIM(B.NO_POS_BC11) AS NO_POS_BC11, 
								 TRIM(B.KD_ORG_CONSIGNEE) AS KD_ORG_CONSIGNEE, TRIM(B.KD_TIMBUN_KAPAL) AS KD_TIMBUN_KAPAL, 
								 TRIM(B.KD_TIMBUN) AS KD_TIMBUN, TRIM(B.KD_PEL_MUAT) AS KD_PEL_MUAT, 
								 TRIM(B.KD_PEL_TRANSIT) AS KD_PEL_TRANSIT, TRIM(B.KD_PEL_BONGKAR) AS KD_PEL_BONGKAR, 
								 TRIM(B.KD_DOK_IN) AS KD_DOK_IN,  TRIM(B.NO_DOK_IN) AS NO_DOK_IN, TRIM(B.TGL_DOK_IN) AS TGL_DOK_IN, 
								 TRIM(B.WK_IN) AS WK_IN, TRIM(B.KD_CONT_STATUS_IN) AS KD_CONT_STATUS_IN, 
								 TRIM(B.KD_SARANA_ANGKUT_IN) AS KD_SARANA_ANGKUT_IN, TRIM(B.NO_POL_IN) AS NO_POL_IN, 
								 TRIM(B.KD_DOK_OUT) AS KD_DOK_OUT, TRIM(B.NO_DOK_OUT) AS NO_DOK_OUT, 
								 TRIM(B.TGL_DOK_OUT) AS TGL_DOK_OUT, TRIM(B.WK_OUT) AS WK_OUT, TRIM(B.KD_CONT_STATUS_OUT) AS KD_CONT_STATUS_OUT,
								 TRIM(B.KD_SARANA_ANGKUT_OUT) AS KD_SARANA_ANGKUT_OUT, TRIM(B.NO_POL_OUT) AS NO_POL_OUT, 
								 TRIM(B.KD_TPS_TUJUAN) AS KD_TPS_TUJUAN,
								 TRIM(B.KD_GUDANG_TUJUAN) AS KD_GUDANG_TUJUAN, TRIM(B.KD_KANTOR_PABEAN) AS KD_KANTOR_PABEAN, 
								 TRIM(B.NO_DAFTAR_PABEAN) AS NO_DAFTAR_PABEAN, TRIM(B.TGL_DAFTAR_PABEAN) AS TGL_DAFTAR_PABEAN, 
								 TRIM(B.NO_SEGEL_BC) AS NO_SEGEL_BC, TRIM(B.TGL_SEGEL_BC) AS TGL_SEGEL_BC, TRIM(B.NO_IJIN_TPS) AS NO_IJIN_TPS, 
								 TRIM(B.TGL_IJIN_TPS) AS TGL_IJIN_TPS, TRIM(B.FL_CONT_KOSONG) AS FL_CONT_KOSONG, 
								 TRIM(B.FL_TRANSFER_IN) AS FL_TRANSFER_IN,
								 TRIM(B.FL_TRANSFER_OUT) AS FL_TRANSFER_OUT, B.WK_REKAM
								 FROM t_cocostshdr A
								 INNER JOIN t_cocostscont B ON B.ID=A.ID
								 WHERE A.KD_ASAL_BRG = '1'
									   AND A.NO_VOY_FLIGHT = ".trim($wms_db->escape($data['NO_VOY_FLIGHT']))."
									   AND A.CALL_SIGN = ".trim($wms_db->escape($data['CALL_SIGN']))."
									   AND A.TGL_TIBA = ".trim($wms_db->escape($data['TGL_TIBA']))."
									   AND B.NO_CONT = ".trim($wms_db->escape($data['NO_CONT']));
					$res_cont = $func->main->get_result($SQL_CONT);
					if($res_cont){
						 foreach($SQL_CONT->result_array() as $row => $value){
							$cont = $value;
						 }
						 $QUERY_REPO_CONT = "SELECT TRIM(B.KD_DOK_IN) AS KD_DOK_IN, TRIM(B.NO_DOK_IN) AS NO_DOK_IN, TRIM(B.TGL_DOK_IN) AS TGL_DOK_IN, 
											 TRIM(B.WK_IN) AS WK_IN, TRIM(B.KD_CONT_STATUS_IN) AS KD_CONT_STATUS_IN, TRIM(B.KD_SARANA_ANGKUT_IN) AS KD_SARANA_ANGKUT_IN, 
											 TRIM(B.NO_POL_IN) AS NO_POL_IN
											 FROM t_repohdr A
											 INNER JOIN t_repocont B ON B.ID=A.ID
											 WHERE A.KD_ASAL_BRG = '1'
											 AND A.NO_VOY_FLIGHT = ".trim($wms_db->escape($data['NO_VOY_FLIGHT']))."
											 AND A.CALL_SIGN = ".trim($wms_db->escape($data['CALL_SIGN']))."
											 AND A.TGL_TIBA = ".trim($wms_db->escape($data['TGL_TIBA']))."
											 AND B.NO_CONT = ".trim($wms_db->escape($data['NO_CONT']))."
											 ORDER BY A.ID DESC LIMIT 1";
						 $res_repocont = $func->main->get_result($QUERY_REPO_CONT);
						 if($res_repocont){
							 foreach($QUERY_REPO_CONT->result_array() as $rows => $values){
								$repocont = $values;
							 }
						 }
						 $arrdata = array("KD_CONT_UKURAN" 		 	=> $this->field($data['KD_CONT_UKURAN'],$cont['KD_CONT_UKURAN']),
						 				  "KD_CONT_JENIS"		 	=> $this->field($data['KD_CONT_JENIS'],$cont['KD_CONT_JENIS']),
										  "KD_CONT_TIPE"		 	=> $this->field($data['KD_CONT_TIPE'],$cont['KD_CONT_TIPE']),
										  "KD_ISO_CODE" 		 	=> $this->field($data['KD_ISO_CODE'],$cont['KD_ISO_CODE']),
										  "TEMPERATURE" 		 	=> $this->field($data['TEMPERATURE'],$cont['TEMPERATURE']),
										  "BRUTO" 				 	=> $this->field($data['BRUTO'],$cont['BRUTO']),
										  "NO_SEGEL" 			 	=> $this->field($data['NO_SEGEL'],$cont['NO_SEGEL']),
										  "KONDISI_SEGEL" 		 	=> $this->field($data['KONDISI_SEGEL'],$cont['KONDISI_SEGEL']),
										  "NO_BL_AWB" 			 	=> $this->field($data['NO_BL_AWB'],$cont['NO_BL_AWB']),
										  "TGL_BL_AWB" 		 		=> $this->field($data['TGL_BL_AWB'],$cont['TGL_BL_AWB']),
										  "NO_MASTER_BL_AWB" 	 	=> $this->field($data['NO_MASTER_BL_AWB'],$cont['NO_MASTER_BL_AWB']),
										  "TGL_MASTER_BL_AWB" 	 	=> $this->field($data['TGL_MASTER_BL_AWB'],$cont['TGL_MASTER_BL_AWB']),
										  "NO_POS_BC11" 		 	=> $this->field($data['NO_POS_BC11'],$cont['NO_POS_BC11']),
										  "KD_ORG_CONSIGNEE" 	 	=> $this->field($data['KD_ORG_CONSIGNEE'],$cont['KD_ORG_CONSIGNEE']),
										  "KD_TIMBUN_KAPAL" 	 	=> $this->field($data['KD_TIMBUN_KAPAL'],$cont['KD_TIMBUN_KAPAL']),
										  "KD_TIMBUN" 				=> $this->field($data['KD_TIMBUN'],$cont['KD_TIMBUN']),
										  "KD_PEL_MUAT" 			=> $this->field($data['KD_PEL_MUAT'],$cont['KD_PEL_MUAT']),
										  "KD_PEL_TRANSIT" 			=> $this->field($data['KD_PEL_TRANSIT'],$cont['KD_PEL_TRANSIT']),
										  "KD_PEL_BONGKAR" 			=> $this->field($data['KD_PEL_BONGKAR'],$cont['KD_PEL_BONGKAR']),
										  "KD_DOK_IN" 				=> $this->field($data['KD_DOK_IN'],$repocont['KD_DOK_IN']),
										  "NO_DOK_IN" 			 	=> $this->field($data['NO_DOK_IN'],$repocont['NO_DOK_IN']),
										  "TGL_DOK_IN" 		 		=> $this->field($data['TGL_DOK_IN'],$repocont['TGL_DOK_IN']),
										  "WK_IN" 				 	=> $this->field($data['WK_IN'],$repocont['WK_IN']),
										  "KD_CONT_STATUS_IN"   	=> $this->field($data['KD_CONT_STATUS_IN'],$repocont['KD_CONT_STATUS_IN']),
										  "KD_SARANA_ANGKUT_IN" 	=> $this->field($data['KD_SARANA_ANGKUT_IN'],$repocont['KD_SARANA_ANGKUT_IN']),
										  "NO_POL_IN" 			 	=> $this->field($data['NO_POL_IN'],$repocont['NO_POL_IN']),
										  "KD_DOK_OUT" 		 		=> $this->field($data['KD_DOK_OUT'],$cont['KD_DOK_OUT']),
										  "NO_DOK_OUT" 		 		=> $this->field($data['NO_DOK_OUT'],$cont['NO_DOK_OUT']),
										  "TGL_DOK_OUT" 		 	=> $this->field($data['TGL_DOK_OUT'],$cont['TGL_DOK_OUT']),
										  "WK_OUT" 			 		=> $this->field($data['WK_OUT'],$cont['WK_OUT']),
										  "KD_CONT_STATUS_OUT"	  	=> $this->field($data['KD_CONT_STATUS_OUT'],$cont['KD_CONT_STATUS_OUT']),
										  "KD_SARANA_ANGKUT_OUT" 	=> $this->field($data['KD_SARANA_ANGKUT_OUT'],$cont['KD_SARANA_ANGKUT_OUT']),
										  "NO_POL_OUT" 		  		=> $this->field($data['NO_POL_OUT'],$cont['NO_POL_OUT']),
										  "KD_TPS_TUJUAN" 			=> $this->field($data['KD_TPS_TUJUAN'],$cont['KD_TPS_TUJUAN']),
										  "KD_GUDANG_TUJUAN"		=> $this->field($data['KD_GUDANG_TUJUAN'],$cont['KD_GUDANG_TUJUAN']), 
										  "KD_KANTOR_PABEAN" 		=> $this->field($data['KD_KANTOR_PABEAN'],$cont['KD_KANTOR_PABEAN']),
										  "NO_DAFTAR_PABEAN" 		=> $this->field($data['NO_DAFTAR_PABEAN'],$cont['NO_DAFTAR_PABEAN']),
										  "TGL_DAFTAR_PABEAN" 		=> $this->field($data['TGL_DAFTAR_PABEAN'],$cont['TGL_DAFTAR_PABEAN']),
										  "NO_SEGEL_BC" 			=> $this->field($data['NO_SEGEL_BC'],$cont['NO_SEGEL_BC']),
										  "TGL_SEGEL_BC" 			=> $this->field($data['TGL_SEGEL_BC'],$cont['TGL_SEGEL_BC']),
										  "NO_IJIN_TPS" 			=> $this->field($data['NO_IJIN_TPS'],$cont['NO_IJIN_TPS']),
										  "TGL_IJIN_TPS" 			=> $this->field($data['TGL_IJIN_TPS'],$cont['TGL_IJIN_TPS']),
										  "FL_CONT_KOSONG"			=> $this->field($data['FL_CONT_KOSONG'],$cont['FL_CONT_KOSONG']),
										  "WK_REKAM"			    => $NOW);
						$wms_db->where(array('ID' => $cont['ID'], 'NO_CONT' => $cont['NO_CONT']));
						$res = $wms_db->update('t_cocostscont',$arrdata);
						if($res){
							echo "&nbsp;&nbsp;- GATE OUT IMPORT [UPDATE CONTAINER] - ".$data['NO_CONT']." IN ".$this->field($data['WK_IN'],$repocont['WK_IN'])." OUT ".$this->field($data['WK_OUT'],$cont['WK_OUT'])."<BR>";
							$RESPONSE = "SUCCESS";
						}
					}else{
						echo "NO RECORDS MATCH CONTAINER ".$data['NO_CONT']."<BR>";
						$RESPONSE = "FAILED";
					}
					$this->update_repo($data['ID'],$data['NO_CONT'],$RESPONSE);
				}
				
				#CODECO EKSPOR [GATE IN]
				if($V_KD_ASAL_BRG == '4'){
					$SQL_HEADER = "SELECT ID FROM t_cocostshdr 
								   WHERE KD_ASAL_BRG = '3'
								   		 AND NO_VOY_FLIGHT = ".trim($this->db->escape($data['NO_VOY_FLIGHT']))."
										 AND CALL_SIGN = ".trim($this->db->escape($data['CALL_SIGN']))."
										 AND TGL_TIBA = ".trim($this->db->escape($data['TGL_TIBA']));
					#echo $SQL_HEADER; die();
					$res_header = $func->main->get_result($SQL_HEADER);
					if($res_header){
						foreach($SQL_HEADER->result_array() as $row => $value){
							$arrheader = $value;
						}
						$arr_in_header['KD_KAPAL'] 		 = $this->emptystr($data['KD_KAPAL']);
						$arr_in_header['NM_ANGKUT'] 	 = $this->emptystr($data['NM_ANGKUT']);
						$arr_in_header['NO_VOY_FLIGHT']  = $this->emptystr($data['NO_VOY_FLIGHT']);
						$arr_in_header['CALL_SIGN'] 	 = $this->emptystr($data['CALL_SIGN']);
						$arr_in_header['TGL_TIBA'] 		 = $this->emptystr($data['TGL_TIBA']);
						$arr_in_header['NO_BC11'] 		 = $this->emptystr($data['NO_BC11']);
						$arr_in_header['TGL_BC11'] 		 = $this->emptystr($data['TGL_BC11']);
						$arr_in_header['KD_PEL_MUAT'] 	 = $this->emptystr($data['PEL_MUAT']);
						$arr_in_header['KD_PEL_TRANSIT'] = $this->emptystr($data['PEL_TRANSIT']);
						$arr_in_header['KD_PEL_BONGKAR'] = $this->emptystr($data['PEL_BONGKAR']);
						$wms_db->where(array('ID' => $arrheader['ID']));
						$wms_db->update('t_cocostshdr',$arr_in_header);
						$ID = $arrheader['ID'];
					}else{
						$arr_in_header['KD_ASAL_BRG'] 	 = '3';
						$arr_in_header['KD_TPS'] 	  	 = 'NCT1';
						$arr_in_header['KD_GUDANG'] 	 = 'NCT1';
						$arr_in_header['FL_FROM'] 	 	 = 'FTP';
						$arr_in_header['KD_KAPAL'] 		 = $this->emptystr($data['KD_KAPAL']);
						$arr_in_header['NM_ANGKUT'] 	 = $this->emptystr($data['NM_ANGKUT']);
						$arr_in_header['NO_VOY_FLIGHT']  = $this->emptystr($data['NO_VOY_FLIGHT']);
						$arr_in_header['CALL_SIGN'] 	 = $this->emptystr($data['CALL_SIGN']);
						$arr_in_header['TGL_TIBA'] 		 = $this->emptystr($data['TGL_TIBA']);
						$arr_in_header['NO_BC11'] 		 = $data['NO_BC11'];
						$arr_in_header['TGL_BC11'] 		 = $data['TGL_BC11'];
						$arr_in_header['KD_PEL_MUAT'] 	 = $this->emptystr($data['PEL_MUAT']);
						$arr_in_header['KD_PEL_TRANSIT'] = $this->emptystr($data['PEL_TRANSIT']);
						$arr_in_header['KD_PEL_BONGKAR'] = $this->emptystr($data['PEL_BONGKAR']);
						$arr_in_header['WK_REKAM'] 		 = $NOW;
						$wms_db->insert('t_cocostshdr',$arr_in_header);
						$ID = $wms_db->insert_id();
						if($ID!=0){
							echo "GATE IN EXPORT [INSERT HEADER]<BR>";
						}
						
					}
					if($ID!=""){
						$SQL_CONT = "SELECT NO_CONT FROM t_cocostscont
									 WHERE ID = ".$this->db->escape($ID)."
									 	   AND NO_CONT = ".$this->db->escape($data['NO_CONT']);
						$res_cont = $func->main->get_result($SQL_CONT);
						if($res_cont){
							foreach($SQL_CONT->result_array() as $row => $value){
								$arrcont = $value;
							}
							$NEW_ID = $data['ID'];
							$NEW_CONT = $data['NO_CONT'];
							unset($data['ID']);
							unset($data['KD_ASAL_BRG']);
							unset($data['KD_TPS']);
							unset($data['KD_GUDANG']);
							unset($data['KD_KAPAL']);
							unset($data['NM_ANGKUT']);
							unset($data['NO_VOY_FLIGHT']);
							unset($data['CALL_SIGN']);
							unset($data['TGL_TIBA']);
							unset($data['NO_BC11']);
							unset($data['TGL_BC11']);
							unset($data['PEL_MUAT']);
							unset($data['PEL_TRANSIT']);
							unset($data['PEL_BONGKAR']);
							unset($data['NO_CONT']);
							unset($data['WK_OUT']);
							$data['WK_IN'] = $data['WK_IN'];
							$data['WK_REKAM'] = $NOW;
							$wms_db->where(array('ID' => $ID, 'NO_CONT' => $arrcont['NO_CONT']));
							$res = $wms_db->update('t_cocostscont',$data);
							if($res){
								echo "GATE IN EXPORT [UPDATE CONTAINER] - ".$NEW_CONT." IN ".$data['WK_IN']."<BR>";
							}
						}else{
							$NEW_ID = $data['ID'];
							$NEW_CONT = $data['NO_CONT'];
							unset($data['ID']);
							unset($data['KD_ASAL_BRG']);
							unset($data['KD_TPS']);
							unset($data['KD_GUDANG']);
							unset($data['KD_KAPAL']);
							unset($data['NM_ANGKUT']);
							unset($data['NO_VOY_FLIGHT']);
							unset($data['CALL_SIGN']);
							unset($data['TGL_TIBA']);
							unset($data['NO_BC11']);
							unset($data['TGL_BC11']);
							unset($data['PEL_MUAT']);
							unset($data['PEL_TRANSIT']);
							unset($data['PEL_BONGKAR']);
							unset($data['WK_OUT']);
							$data['ID'] = $ID;
							$data['WK_IN'] = $data['WK_IN'];
							$data['WK_REKAM'] = $NOW;
							$res = $wms_db->insert('t_cocostscont',$data);
							if($res){
								echo "GATE IN EXPORT [INSERT CONTAINER] - ".$NEW_CONT." IN ".$data['WK_IN']."<BR>";
								$RESPONSE = "SUCCESS";
							}else{
								$RESPONSE = "FAILED";
							}
						}
						$this->update_repo($NEW_ID,$NEW_CONT,$RESPONSE);
					}
				}
				
				#COARRI EKSPOR [LOADING]
				if($V_KD_ASAL_BRG == '3'){
					$SQL_CONT = "SELECT A.ID, A.KD_ASAL_BRG, A.KD_TPS, A.KD_GUDANG, A.KD_KAPAL, TRIM(A.NM_ANGKUT) AS NM_ANGKUT, 
								 TRIM(A.NO_VOY_FLIGHT) AS NO_VOY_FLIGHT, TRIM(A.CALL_SIGN) AS CALL_SIGN, TRIM(A.TGL_TIBA) AS TGL_TIBA,
								 TRIM(A.NO_BC11) AS NO_BC11, TRIM(A.TGL_BC11) AS TGL_BC11, TRIM(A.KD_PEL_MUAT) AS PEL_MUAT, 
								 TRIM(A.KD_PEL_TRANSIT) AS PEL_TRANSIT, TRIM(A.KD_PEL_BONGKAR) AS PEL_BONGKAR,
								 TRIM(B.NO_CONT) AS NO_CONT, TRIM(B.KD_CONT_UKURAN) AS KD_CONT_UKURAN, TRIM(B.KD_CONT_JENIS) AS KD_CONT_JENIS, 
								 TRIM(B.KD_CONT_TIPE) AS KD_CONT_TIPE, TRIM(B.KD_ISO_CODE) AS KD_ISO_CODE, TRIM(B.TEMPERATURE) AS TEMPERATURE, 
								 TRIM(B.BRUTO) AS BRUTO, TRIM(B.NO_SEGEL) AS NO_SEGEL, TRIM(B.KONDISI_SEGEL) AS KONDISI_SEGEL, 
								 TRIM(B.NO_BL_AWB) AS NO_BL_AWB, TRIM(B.TGL_BL_AWB) AS TGL_BL_AWB, TRIM(B.NO_MASTER_BL_AWB) AS NO_MASTER_BL_AWB,
								 TRIM(B.TGL_MASTER_BL_AWB) AS TGL_MASTER_BL_AWB, TRIM(B.NO_POS_BC11) AS NO_POS_BC11, 
								 TRIM(B.KD_ORG_CONSIGNEE) AS KD_ORG_CONSIGNEE, TRIM(B.KD_TIMBUN_KAPAL) AS KD_TIMBUN_KAPAL, 
								 TRIM(B.KD_TIMBUN) AS KD_TIMBUN, TRIM(B.KD_PEL_MUAT) AS KD_PEL_MUAT, 
								 TRIM(B.KD_PEL_TRANSIT) AS KD_PEL_TRANSIT, TRIM(B.KD_PEL_BONGKAR) AS KD_PEL_BONGKAR, 
								 TRIM(B.KD_DOK_IN) AS KD_DOK_IN,  TRIM(B.NO_DOK_IN) AS NO_DOK_IN, TRIM(B.TGL_DOK_IN) AS TGL_DOK_IN, 
								 TRIM(B.WK_IN) AS WK_IN, TRIM(B.KD_CONT_STATUS_IN) AS KD_CONT_STATUS_IN, 
								 TRIM(B.KD_SARANA_ANGKUT_IN) AS KD_SARANA_ANGKUT_IN, TRIM(B.NO_POL_IN) AS NO_POL_IN, 
								 TRIM(B.KD_DOK_OUT) AS KD_DOK_OUT, TRIM(B.NO_DOK_OUT) AS NO_DOK_OUT, 
								 TRIM(B.TGL_DOK_OUT) AS TGL_DOK_OUT, TRIM(B.WK_OUT) AS WK_OUT, TRIM(B.KD_CONT_STATUS_OUT) AS KD_CONT_STATUS_OUT,
								 TRIM(B.KD_SARANA_ANGKUT_OUT) AS KD_SARANA_ANGKUT_OUT, TRIM(B.NO_POL_OUT) AS NO_POL_OUT, 
								 TRIM(B.KD_TPS_TUJUAN) AS KD_TPS_TUJUAN,
								 TRIM(B.KD_GUDANG_TUJUAN) AS KD_GUDANG_TUJUAN, TRIM(B.KD_KANTOR_PABEAN) AS KD_KANTOR_PABEAN, 
								 TRIM(B.NO_DAFTAR_PABEAN) AS NO_DAFTAR_PABEAN, TRIM(B.TGL_DAFTAR_PABEAN) AS TGL_DAFTAR_PABEAN, 
								 TRIM(B.NO_SEGEL_BC) AS NO_SEGEL_BC, TRIM(B.TGL_SEGEL_BC) AS TGL_SEGEL_BC, TRIM(B.NO_IJIN_TPS) AS NO_IJIN_TPS, 
								 TRIM(B.TGL_IJIN_TPS) AS TGL_IJIN_TPS, TRIM(B.FL_CONT_KOSONG) AS FL_CONT_KOSONG, 
								 TRIM(B.FL_TRANSFER_IN) AS FL_TRANSFER_IN,
								 TRIM(B.FL_TRANSFER_OUT) AS FL_TRANSFER_OUT, B.WK_REKAM
								 FROM t_cocostshdr A
								 INNER JOIN t_cocostscont B ON B.ID=A.ID
								 WHERE A.KD_ASAL_BRG = '3'
									   AND A.NO_VOY_FLIGHT = ".trim($this->db->escape($data['NO_VOY_FLIGHT']))."
									   AND A.CALL_SIGN = ".trim($this->db->escape($data['CALL_SIGN']))."
									   AND A.TGL_TIBA = ".trim($this->db->escape($data['TGL_TIBA']))."
									   AND B.NO_CONT = ".trim($this->db->escape($data['NO_CONT']));
					$res_cont = $func->main->get_result($SQL_CONT);
					if($res_cont){
						 foreach($SQL_CONT->result_array() as $row => $value){
							$cont = $value;
						 }
						 $QUERY_REPO_CONT = "SELECT TRIM(B.KD_DOK_IN) AS KD_DOK_IN,  TRIM(B.NO_DOK_IN) AS NO_DOK_IN, TRIM(B.TGL_DOK_IN) AS TGL_DOK_IN, 
											 TRIM(B.WK_IN) AS WK_IN, TRIM(B.KD_CONT_STATUS_IN) AS KD_CONT_STATUS_IN, TRIM(B.KD_SARANA_ANGKUT_IN) AS KD_SARANA_ANGKUT_IN, 
											 TRIM(B.NO_POL_IN) AS NO_POL_IN
											 FROM t_repohdr A
											 INNER JOIN t_repocont B ON B.ID=A.ID
											 WHERE A.KD_ASAL_BRG = '4'
											 AND A.NO_VOY_FLIGHT = ".trim($this->db->escape($data['NO_VOY_FLIGHT']))."
											 AND A.CALL_SIGN = ".trim($this->db->escape($data['CALL_SIGN']))."
											 AND A.TGL_TIBA = ".trim($this->db->escape($data['TGL_TIBA']))."
											 AND B.NO_CONT = ".trim($this->db->escape($data['NO_CONT']))."
											 ORDER BY A.ID DESC LIMIT 1";
						 #echo $QUERY_REPO_CONT; die();
						 $res_repocont = $func->main->get_result($QUERY_REPO_CONT);
						 if($res_repocont){
							 foreach($QUERY_REPO_CONT->result_array() as $rows => $values){
								$repocont = $values;
							 }
						 }					 
						 $arrdata = array("KD_CONT_UKURAN" 		 	=> $this->field($data['KD_CONT_UKURAN'],$cont['KD_CONT_UKURAN']),
						 				  "KD_CONT_JENIS"		 	=> $this->field($data['KD_CONT_JENIS'],$cont['KD_CONT_JENIS']),
										  "KD_CONT_TIPE"		 	=> $this->field($data['KD_CONT_TIPE'],$cont['KD_CONT_TIPE']),
										  "KD_ISO_CODE" 		 	=> $this->field($data['KD_ISO_CODE'],$cont['KD_ISO_CODE']),
										  "TEMPERATURE" 		 	=> $this->field($data['TEMPERATURE'],$cont['TEMPERATURE']),
										  "BRUTO" 				 	=> $this->field($data['BRUTO'],$cont['BRUTO']),
										  "NO_SEGEL" 			 	=> $this->field($data['NO_SEGEL'],$cont['NO_SEGEL']),
										  "KONDISI_SEGEL" 		 	=> $this->field($data['KONDISI_SEGEL'],$cont['KONDISI_SEGEL']),
										  "NO_BL_AWB" 			 	=> $this->field($data['NO_BL_AWB'],$cont['NO_BL_AWB']),
										  "TGL_BL_AWB" 		 		=> $this->field($data['TGL_BL_AWB'],$cont['TGL_BL_AWB']),
										  "NO_MASTER_BL_AWB" 	 	=> $this->field($data['NO_MASTER_BL_AWB'],$cont['NO_MASTER_BL_AWB']),
										  "TGL_MASTER_BL_AWB" 	 	=> $this->field($data['TGL_MASTER_BL_AWB'],$cont['TGL_MASTER_BL_AWB']),
										  "NO_POS_BC11" 		 	=> $this->field($data['NO_POS_BC11'],$cont['NO_POS_BC11']),
										  "KD_ORG_CONSIGNEE" 	 	=> $this->field($data['KD_ORG_CONSIGNEE'],$cont['KD_ORG_CONSIGNEE']),
										  "KD_TIMBUN_KAPAL" 	 	=> $this->field($data['KD_TIMBUN_KAPAL'],$cont['KD_TIMBUN_KAPAL']),
										  "KD_TIMBUN" 				=> $this->field($data['KD_TIMBUN'],$cont['KD_TIMBUN']),
										  "KD_PEL_MUAT" 			=> $this->field($data['KD_PEL_MUAT'],$cont['KD_PEL_MUAT']),
										  "KD_PEL_TRANSIT" 			=> $this->field($data['KD_PEL_TRANSIT'],$cont['KD_PEL_TRANSIT']),
										  "KD_PEL_BONGKAR" 			=> $this->field($data['KD_PEL_BONGKAR'],$cont['KD_PEL_BONGKAR']),
										  "KD_DOK_IN" 				=> $this->field($data['KD_DOK_IN'],$repocont['KD_DOK_IN']),
										  "NO_DOK_IN" 			 	=> $this->field($data['NO_DOK_IN'],$repocont['NO_DOK_IN']),
										  "TGL_DOK_IN" 		 		=> $this->field($data['TGL_DOK_IN'],$repocont['TGL_DOK_IN']),
										  "WK_IN" 				 	=> $this->field($data['WK_IN'],$repocont['WK_IN']),
										  "KD_CONT_STATUS_IN"   	=> $this->field($data['KD_CONT_STATUS_IN'],$repocont['KD_CONT_STATUS_IN']),
										  "KD_SARANA_ANGKUT_IN" 	=> $this->field($data['KD_SARANA_ANGKUT_IN'],$repocont['KD_SARANA_ANGKUT_IN']),
										  "NO_POL_IN" 			 	=> $this->field($data['NO_POL_IN'],$repocont['NO_POL_IN']),
										  "KD_DOK_OUT" 		 		=> $this->field($data['KD_DOK_OUT'],$cont['KD_DOK_OUT']),
										  "NO_DOK_OUT" 		 		=> $this->field($data['NO_DOK_OUT'],$cont['NO_DOK_OUT']),
										  "TGL_DOK_OUT" 		 	=> $this->field($data['TGL_DOK_OUT'],$cont['TGL_DOK_OUT']),
										  "WK_OUT" 			 		=> $this->field($data['WK_OUT'],$cont['WK_OUT']),
										  "KD_CONT_STATUS_OUT"	  	=> $this->field($data['KD_CONT_STATUS_OUT'],$cont['KD_CONT_STATUS_OUT']),
										  "KD_SARANA_ANGKUT_OUT" 	=> $this->field($data['KD_SARANA_ANGKUT_OUT'],$cont['KD_SARANA_ANGKUT_OUT']),
										  "NO_POL_OUT" 		  		=> $this->field($data['NO_POL_OUT'],$cont['NO_POL_OUT']),
										  "KD_TPS_TUJUAN" 			=> $this->field($data['KD_TPS_TUJUAN'],$cont['KD_TPS_TUJUAN']),
										  "KD_GUDANG_TUJUAN"		=> $this->field($data['KD_GUDANG_TUJUAN'],$cont['KD_GUDANG_TUJUAN']), 
										  "KD_KANTOR_PABEAN" 		=> $this->field($data['KD_KANTOR_PABEAN'],$cont['KD_KANTOR_PABEAN']),
										  "NO_DAFTAR_PABEAN" 		=> $this->field($data['NO_DAFTAR_PABEAN'],$cont['NO_DAFTAR_PABEAN']),
										  "TGL_DAFTAR_PABEAN" 		=> $this->field($data['TGL_DAFTAR_PABEAN'],$cont['TGL_DAFTAR_PABEAN']),
										  "NO_SEGEL_BC" 			=> $this->field($data['NO_SEGEL_BC'],$cont['NO_SEGEL_BC']),
										  "TGL_SEGEL_BC" 			=> $this->field($data['TGL_SEGEL_BC'],$cont['TGL_SEGEL_BC']),
										  "NO_IJIN_TPS" 			=> $this->field($data['NO_IJIN_TPS'],$cont['NO_IJIN_TPS']),
										  "TGL_IJIN_TPS" 			=> $this->field($data['TGL_IJIN_TPS'],$cont['TGL_IJIN_TPS']),
										  "FL_CONT_KOSONG"			=> $this->field($data['FL_CONT_KOSONG'],$cont['FL_CONT_KOSONG']),
										  "WK_REKAM"			    => $NOW);
						$wms_db->where(array('ID' => $cont['ID'], 'NO_CONT' => $cont['NO_CONT']));
						$res = $wms_db->update('t_cocostscont',$arrdata);
						if($res){
							echo "&nbsp;&nbsp;- LOADING EXPORT [UPDATE CONTAINER ".$data['ID']."] - ".$data['NO_CONT']." IN ".$this->field($data['WK_IN'],$repocont['WK_IN'])." OUT ".$this->field($data['WK_OUT'],$cont['WK_OUT'])."<BR>";
							$RESPONSE = "SUCCESS";
						}else{
							$RESPONSE = "FAILED";
						}
					}else{
						echo "NO RECORDS MATCH CONTAINER ".$data['NO_CONT']."<BR>";
						$RESPONSE = "FAILED";
					}
					$this->update_repo($data['ID'],$data['NO_CONT'],$RESPONSE);
				}
			}
		}else{
			echo "NO RECORDS FOUND"; exit();
		}
	}
	
	function repository_discharge(){
		#error_reporting(E_ALL);
		$wms_db = $this->load->database('wms',TRUE);
		$func =&get_instance();
		$func->load->model("m_main","main", true);
		date_default_timezone_set('Asia/Jakarta');
		$NOW = date('Y-m-d H:i:s');
		$SQL = "SELECT A.ID, A.KD_ASAL_BRG, A.KD_TPS, A.KD_GUDANG, A.KD_KAPAL, TRIM(A.NM_ANGKUT) AS NM_ANGKUT, 
				TRIM(A.NO_VOY_FLIGHT) AS NO_VOY_FLIGHT, TRIM(A.CALL_SIGN) AS CALL_SIGN, A.TGL_TIBA,
				TRIM(A.NO_BC11) AS NO_BC11, A.TGL_BC11, TRIM(A.KD_PEL_MUAT) AS PEL_MUAT, TRIM(A.KD_PEL_TRANSIT) AS PEL_TRANSIT,
				TRIM(A.KD_PEL_BONGKAR) AS PEL_BONGKAR,
				TRIM(B.NO_CONT) AS NO_CONT, TRIM(B.KD_CONT_UKURAN) AS KD_CONT_UKURAN, TRIM(B.KD_CONT_JENIS) AS KD_CONT_JENIS, 
				TRIM(B.KD_CONT_TIPE) AS KD_CONT_TIPE, TRIM(B.KD_ISO_CODE) AS KD_ISO_CODE, TRIM(B.TEMPERATURE) AS TEMPERATURE, 
				TRIM(B.BRUTO) AS BRUTO, TRIM(B.NO_SEGEL) AS NO_SEGEL, TRIM(B.KONDISI_SEGEL) AS KONDISI_SEGEL, 
				TRIM(B.NO_BL_AWB) AS NO_BL_AWB, B.TGL_BL_AWB, TRIM(B.NO_MASTER_BL_AWB) AS NO_MASTER_BL_AWB,
				B.TGL_MASTER_BL_AWB, TRIM(B.NO_POS_BC11) AS NO_POS_BC11, TRIM(B.KD_ORG_CONSIGNEE) AS KD_ORG_CONSIGNEE,
				TRIM(B.KD_TIMBUN_KAPAL) AS KD_TIMBUN_KAPAL, TRIM(B.KD_TIMBUN) AS KD_TIMBUN, TRIM(B.KD_PEL_MUAT) AS KD_PEL_MUAT, 
				TRIM(B.KD_PEL_TRANSIT) AS KD_PEL_TRANSIT, TRIM(B.KD_PEL_BONGKAR) AS KD_PEL_BONGKAR, TRIM(B.KD_DOK_IN) AS KD_DOK_IN, 
				TRIM(B.NO_DOK_IN) AS NO_DOK_IN, B.TGL_DOK_IN, TRIM(B.WK_IN) AS WK_IN, 
				TRIM(B.KD_CONT_STATUS_IN) AS KD_CONT_STATUS_IN, TRIM(B.KD_SARANA_ANGKUT_IN) AS KD_SARANA_ANGKUT_IN, 
				TRIM(B.NO_POL_IN) AS NO_POL_IN, TRIM(B.KD_DOK_OUT) AS KD_DOK_OUT, TRIM(B.NO_DOK_OUT) AS NO_DOK_OUT, 
				B.TGL_DOK_OUT, TRIM(B.WK_OUT) AS WK_OUT, TRIM(B.KD_CONT_STATUS_OUT) AS KD_CONT_STATUS_OUT,
				TRIM(B.KD_SARANA_ANGKUT_OUT) AS KD_SARANA_ANGKUT_OUT, TRIM(B.NO_POL_OUT) AS NO_POL_OUT, TRIM(B.KD_TPS_TUJUAN) AS KD_TPS_TUJUAN,
				TRIM(B.KD_GUDANG_TUJUAN) AS KD_GUDANG_TUJUAN, TRIM(B.KD_KANTOR_PABEAN) AS KD_KANTOR_PABEAN, 
				TRIM(B.NO_DAFTAR_PABEAN) AS NO_DAFTAR_PABEAN, B.TGL_DAFTAR_PABEAN, 
				TRIM(B.NO_SEGEL_BC) AS NO_SEGEL_BC, B.TGL_SEGEL_BC, TRIM(B.NO_IJIN_TPS) AS NO_IJIN_TPS, 
				B.TGL_IJIN_TPS, TRIM(B.FL_CONT_KOSONG) AS FL_CONT_KOSONG, TRIM(B.FL_TRANSFER_IN) AS FL_TRANSFER_IN,
				TRIM(B.FL_TRANSFER_OUT) AS FL_TRANSFER_OUT, B.WK_REKAM
				FROM t_repohdr A
				INNER JOIN t_repocont B ON B. ID=A.ID
				LEFT JOIN reff_asal_brg C ON C.ID=A.KD_ASAL_BRG
				WHERE B.FL_USE = 'N'
					  AND A.KD_ASAL_BRG= '1' AND A.NO_BC11 IS NOT NULL AND A.TGL_BC11 IS NOT NULL AND A.KD_TPS IN ('PLDP','PLKB','LPJG')
				ORDER BY C.URUTAN ASC LIMIT 0,10";
		//echo $SQL; die();
		$result = $func->main->get_result($SQL);
		if($result){
			foreach($SQL->result_array() as $row => $value){
				$arrdata[] = $value;
			}
			foreach($arrdata as $data){//print_r($data);die();
				$V_KD_ASAL_BRG = $data['KD_ASAL_BRG'];	//print_r($V_KD_ASAL_BRG);die();
				#COARRI DISCHARGE
				if($V_KD_ASAL_BRG == '1'){//echo "sin0";die();
					$SQL_HEADER = "SELECT ID FROM t_cocostshdr 
								   WHERE KD_ASAL_BRG = '".$data['KD_ASAL_BRG']."'
								   		 AND NO_VOY_FLIGHT = '".trim($data['NO_VOY_FLIGHT'])."'
										 AND CALL_SIGN = '".trim($data['CALL_SIGN'])."'";//echo $SQL_HEADER;die();
										 //AND TGL_TIBA = ".trim($this->db->escape($data['TGL_TIBA']));echo 
					$res_header = $func->main->get_result($SQL_HEADER);
					if($res_header){
						foreach($SQL_HEADER->result_array() as $row => $value){
							$arrheader = $value;
						}
						$arr_in_header['KD_KAPAL'] 		 = $this->emptystr($data['KD_KAPAL']);
						$arr_in_header['NM_ANGKUT'] 	 = $this->emptystr($data['NM_ANGKUT']);
						$arr_in_header['NO_VOY_FLIGHT']  = $this->emptystr($data['NO_VOY_FLIGHT']);
						$arr_in_header['CALL_SIGN'] 	 = $this->emptystr($data['CALL_SIGN']);
						$arr_in_header['TGL_TIBA'] 		 = $this->emptystr($data['TGL_TIBA']);
						$arr_in_header['NO_BC11'] 		 = $this->emptystr($data['NO_BC11']);
						$arr_in_header['TGL_BC11'] 		 = $this->emptystr($data['TGL_BC11']);
						$arr_in_header['KD_PEL_MUAT'] 	 = $this->emptystr($data['PEL_MUAT']);
						$arr_in_header['KD_PEL_TRANSIT'] = $this->emptystr($data['PEL_TRANSIT']);
						$arr_in_header['KD_PEL_BONGKAR'] = $this->emptystr($data['PEL_BONGKAR']);
						
						$wms_db->where(array('ID' => $arrheader['ID']));
						$wms_db->update('t_cocostshdr',$arr_in_header);//print_r($wms_db->last_query());die();
						$ID = $arrheader['ID'];
					}else{//print_r($data);die();
						$arr_in_header['KD_ASAL_BRG'] 	 = '1';
						$arr_in_header['KD_TPS'] 	  	 = $this->emptystr($data['KD_TPS']);
						$arr_in_header['KD_GUDANG'] 	 = $this->emptystr($data['KD_GUDANG']);
						$arr_in_header['KD_KAPAL'] 		 = $this->emptystr($data['KD_KAPAL']);
						$arr_in_header['NM_ANGKUT'] 	 = $this->emptystr($data['NM_ANGKUT']);
						$arr_in_header['NO_VOY_FLIGHT']  = $this->emptystr($data['NO_VOY_FLIGHT']);
						$arr_in_header['CALL_SIGN'] 	 = $this->emptystr($data['CALL_SIGN']);
						$arr_in_header['TGL_TIBA'] 		 = $this->emptystr($data['TGL_TIBA']);
						$arr_in_header['NO_BC11'] 		 = $this->emptystr($data['NO_BC11']);
						$arr_in_header['TGL_BC11'] 		 = $this->emptystr($data['TGL_BC11']);
						$arr_in_header['KD_PEL_MUAT'] 	 = $this->emptystr($data['PEL_MUAT']);
						$arr_in_header['KD_PEL_TRANSIT'] = $this->emptystr($data['PEL_TRANSIT']);
						$arr_in_header['KD_PEL_BONGKAR'] = $this->emptystr($data['PEL_BONGKAR']);
						
						$arr_in_header['WK_REKAM'] 		 = $NOW;//print_r($arr_in_header);die();
						$wms_db->insert('t_cocostshdr',$arr_in_header);//print_r($wms_db->last_query());die();
						$ID = $wms_db->insert_id();
						if($ID!=""){
							echo "DISCHARGE [INSERT HEADER]<br>";
						}
						
					}
					if($ID!=""){
						$SQL_CONT = "SELECT NO_CONT FROM t_cocostscont
									 WHERE ID = '".$ID."'
									 	   AND NO_CONT = '".$data['NO_CONT']."'";//print_r($SQL_CONT);die();
						$res_cont = $func->main->get_result($SQL_CONT);
						if($res_cont){
							foreach($SQL_CONT->result_array() as $row => $value){
								$arrcont = $value;
							}
							//print_r($data);die();
							$NEW_ID = $data['ID'];
							$NEW_CONT = $data['NO_CONT'];
							unset($data['ID']);
							unset($data['KD_ASAL_BRG']);
							unset($data['KD_TPS']);
							unset($data['KD_GUDANG']);
							unset($data['KD_KAPAL']);
							unset($data['NM_ANGKUT']);
							unset($data['NO_VOY_FLIGHT']);
							unset($data['CALL_SIGN']);
							unset($data['TGL_TIBA']);
							unset($data['NO_BC11']);
							unset($data['TGL_BC11']);
							unset($data['PEL_MUAT']);
							unset($data['PEL_TRANSIT']);
							unset($data['PEL_BONGKAR']);
							unset($data['NO_CONT']);
							unset($data['WK_OUT']);
							$data['WK_REKAM'] = $NOW;
							//print_r($data);die();
							
							$wms_db->where(array('ID' => $ID, 'NO_CONT' => $arrcont['NO_CONT']));
							$res = $wms_db->update('t_cocostscont',$data);
							//print_r($wms_db->last_query());die();
							if($res){
								$RESPONSE = "SUCCESS";
								echo $arr_in_header['NM_ANGKUT']."&nbsp;&nbsp;- DISCHARGE [UPDATE CONTAINER ".$NEW_ID."] - ".$NEW_CONT." IN ".$data['WK_IN']."<BR>";
							}else{
								$RESPONSE = "FAILED";
							}
						}else{
							$NEW_ID = $data['ID'];
							$NEW_CONT = $data['NO_CONT'];
							unset($data['ID']);
							unset($data['KD_ASAL_BRG']);
							unset($data['KD_TPS']);
							unset($data['KD_GUDANG']);
							unset($data['KD_KAPAL']);
							unset($data['NM_ANGKUT']);
							unset($data['NO_VOY_FLIGHT']);
							unset($data['CALL_SIGN']);
							unset($data['TGL_TIBA']);
							unset($data['NO_BC11']);
							unset($data['TGL_BC11']);
							unset($data['PEL_MUAT']);
							unset($data['PEL_TRANSIT']);
							unset($data['PEL_BONGKAR']);
							unset($data['WK_OUT']);
							$data['ID'] = $ID;
							$data['WK_REKAM'] = $NOW;
							//print_r($data);die();
							$res = $wms_db->insert('t_cocostscont',$data);
							//print_r($wms_db->last_query());die();
							if($res){
								$RESPONSE = "SUCCESS";
								echo $arr_in_header['NM_ANGKUT']."&nbsp;&nbsp;- DISCHARGE [INSERT CONTAINER ".$NEW_ID."] - ".$NEW_CONT." IN ".$data['WK_IN']."<BR>";
							}else{
								$RESPONSE = "FAILED";
							}
						}
						$this->update_repo($NEW_ID,$NEW_CONT,$RESPONSE);
					}
				}
			}
		}else{
			echo "NO RECORDS FOUND"; exit();
		}
	}
	
	function repository_gateout(){
		#error_reporting(E_ALL);
		$wms_db = $this->load->database('wms',TRUE);
		$func =&get_instance();
		$func->load->model("m_main","main", true);
		date_default_timezone_set('Asia/Jakarta');
		$NOW = date('Y-m-d H:i:s');
		$SQL = "SELECT A.ID, A.KD_ASAL_BRG, A.KD_TPS, A.KD_GUDANG, A.KD_KAPAL, TRIM(A.NM_ANGKUT) AS NM_ANGKUT, 
				TRIM(A.NO_VOY_FLIGHT) AS NO_VOY_FLIGHT, TRIM(A.CALL_SIGN) AS CALL_SIGN, A.TGL_TIBA,
				TRIM(A.NO_BC11) AS NO_BC11, A.TGL_BC11, TRIM(A.KD_PEL_MUAT) AS PEL_MUAT, TRIM(A.KD_PEL_TRANSIT) AS PEL_TRANSIT,
				TRIM(A.KD_PEL_BONGKAR) AS PEL_BONGKAR,
				TRIM(B.NO_CONT) AS NO_CONT, TRIM(B.KD_CONT_UKURAN) AS KD_CONT_UKURAN, TRIM(B.KD_CONT_JENIS) AS KD_CONT_JENIS, 
				TRIM(B.KD_CONT_TIPE) AS KD_CONT_TIPE, TRIM(B.KD_ISO_CODE) AS KD_ISO_CODE, TRIM(B.TEMPERATURE) AS TEMPERATURE, 
				TRIM(B.BRUTO) AS BRUTO, TRIM(B.NO_SEGEL) AS NO_SEGEL, TRIM(B.KONDISI_SEGEL) AS KONDISI_SEGEL, 
				TRIM(B.NO_BL_AWB) AS NO_BL_AWB, B.TGL_BL_AWB, TRIM(B.NO_MASTER_BL_AWB) AS NO_MASTER_BL_AWB,
				B.TGL_MASTER_BL_AWB, TRIM(B.NO_POS_BC11) AS NO_POS_BC11, TRIM(B.KD_ORG_CONSIGNEE) AS KD_ORG_CONSIGNEE,
				TRIM(B.KD_TIMBUN_KAPAL) AS KD_TIMBUN_KAPAL, TRIM(B.KD_TIMBUN) AS KD_TIMBUN, TRIM(B.KD_PEL_MUAT) AS KD_PEL_MUAT, 
				TRIM(B.KD_PEL_TRANSIT) AS KD_PEL_TRANSIT, TRIM(B.KD_PEL_BONGKAR) AS KD_PEL_BONGKAR, TRIM(B.KD_DOK_IN) AS KD_DOK_IN, 
				TRIM(B.NO_DOK_IN) AS NO_DOK_IN, B.TGL_DOK_IN, TRIM(B.WK_IN) AS WK_IN, 
				TRIM(B.KD_CONT_STATUS_IN) AS KD_CONT_STATUS_IN, TRIM(B.KD_SARANA_ANGKUT_IN) AS KD_SARANA_ANGKUT_IN, 
				TRIM(B.NO_POL_IN) AS NO_POL_IN, TRIM(B.KD_DOK_OUT) AS KD_DOK_OUT, TRIM(B.NO_DOK_OUT) AS NO_DOK_OUT, 
				B.TGL_DOK_OUT, TRIM(B.WK_OUT) AS WK_OUT, TRIM(B.KD_CONT_STATUS_OUT) AS KD_CONT_STATUS_OUT,
				TRIM(B.KD_SARANA_ANGKUT_OUT) AS KD_SARANA_ANGKUT_OUT, TRIM(B.NO_POL_OUT) AS NO_POL_OUT, TRIM(B.KD_TPS_TUJUAN) AS KD_TPS_TUJUAN,
				TRIM(B.KD_GUDANG_TUJUAN) AS KD_GUDANG_TUJUAN, TRIM(B.KD_KANTOR_PABEAN) AS KD_KANTOR_PABEAN, 
				TRIM(B.NO_DAFTAR_PABEAN) AS NO_DAFTAR_PABEAN, B.TGL_DAFTAR_PABEAN, 
				TRIM(B.NO_SEGEL_BC) AS NO_SEGEL_BC, B.TGL_SEGEL_BC, TRIM(B.NO_IJIN_TPS) AS NO_IJIN_TPS, 
				B.TGL_IJIN_TPS, TRIM(B.FL_CONT_KOSONG) AS FL_CONT_KOSONG, TRIM(B.FL_TRANSFER_IN) AS FL_TRANSFER_IN,
				TRIM(B.FL_TRANSFER_OUT) AS FL_TRANSFER_OUT, B.WK_REKAM
				FROM t_repohdr A
				INNER JOIN t_repocont B ON B. ID=A.ID
				LEFT JOIN reff_asal_brg C ON C.ID=A.KD_ASAL_BRG
				WHERE B.FL_USE = 'N' AND A.KD_TPS IN ('PLDP','PLKB','LPJG')
					  AND CASE A.KD_ASAL_BRG
								WHEN '2' THEN A.NO_BC11 IS NOT NULL AND A.TGL_BC11 IS NOT NULL
							END
					  AND CASE A.KD_ASAL_BRG
						  WHEN '2' THEN B.KD_DOK_OUT IS NOT NULL OR B.NO_DOK_OUT IS NOT NULL OR B.TGL_DOK_OUT IS NOT NULL
						  ELSE 1=1
						  END
				ORDER BY C.URUTAN ASC LIMIT 0,30";
		//echo $SQL; die();
		$result = $func->main->get_result($SQL);
		if($result){
			foreach($SQL->result_array() as $row => $value){
				$arrdata[] = $value;
			}
			foreach($arrdata as $data){
				$V_KD_ASAL_BRG = $data['KD_ASAL_BRG'];
				
				#CODECO IMPOR [GATE OUT]
				if($V_KD_ASAL_BRG == '2'){
					$SQL_CONT = "SELECT A.ID, A.KD_ASAL_BRG, A.KD_TPS, A.KD_GUDANG, A.KD_KAPAL, TRIM(A.NM_ANGKUT) AS NM_ANGKUT, 
								 TRIM(A.NO_VOY_FLIGHT) AS NO_VOY_FLIGHT, TRIM(A.CALL_SIGN) AS CALL_SIGN, TRIM(A.TGL_TIBA) AS TGL_TIBA,
								 TRIM(A.NO_BC11) AS NO_BC11, TRIM(A.TGL_BC11) AS TGL_BC11, TRIM(A.KD_PEL_MUAT) AS PEL_MUAT, 
								 TRIM(A.KD_PEL_TRANSIT) AS PEL_TRANSIT, TRIM(A.KD_PEL_BONGKAR) AS PEL_BONGKAR,
								 TRIM(B.NO_CONT) AS NO_CONT, TRIM(B.KD_CONT_UKURAN) AS KD_CONT_UKURAN, TRIM(B.KD_CONT_JENIS) AS KD_CONT_JENIS, 
								 TRIM(B.KD_CONT_TIPE) AS KD_CONT_TIPE, TRIM(B.KD_ISO_CODE) AS KD_ISO_CODE, TRIM(B.TEMPERATURE) AS TEMPERATURE, 
								 TRIM(B.BRUTO) AS BRUTO, TRIM(B.NO_SEGEL) AS NO_SEGEL, TRIM(B.KONDISI_SEGEL) AS KONDISI_SEGEL, 
								 TRIM(B.NO_BL_AWB) AS NO_BL_AWB, TRIM(B.TGL_BL_AWB) AS TGL_BL_AWB, TRIM(B.NO_MASTER_BL_AWB) AS NO_MASTER_BL_AWB,
								 TRIM(B.TGL_MASTER_BL_AWB) AS TGL_MASTER_BL_AWB, TRIM(B.NO_POS_BC11) AS NO_POS_BC11, 
								 TRIM(B.KD_ORG_CONSIGNEE) AS KD_ORG_CONSIGNEE, TRIM(B.KD_TIMBUN_KAPAL) AS KD_TIMBUN_KAPAL, 
								 TRIM(B.KD_TIMBUN) AS KD_TIMBUN, TRIM(B.KD_PEL_MUAT) AS KD_PEL_MUAT, 
								 TRIM(B.KD_PEL_TRANSIT) AS KD_PEL_TRANSIT, TRIM(B.KD_PEL_BONGKAR) AS KD_PEL_BONGKAR, 
								 TRIM(B.KD_DOK_IN) AS KD_DOK_IN,  TRIM(B.NO_DOK_IN) AS NO_DOK_IN, TRIM(B.TGL_DOK_IN) AS TGL_DOK_IN, 
								 TRIM(B.WK_IN) AS WK_IN, TRIM(B.KD_CONT_STATUS_IN) AS KD_CONT_STATUS_IN, 
								 TRIM(B.KD_SARANA_ANGKUT_IN) AS KD_SARANA_ANGKUT_IN, TRIM(B.NO_POL_IN) AS NO_POL_IN, 
								 TRIM(B.KD_DOK_OUT) AS KD_DOK_OUT, TRIM(B.NO_DOK_OUT) AS NO_DOK_OUT, 
								 TRIM(B.TGL_DOK_OUT) AS TGL_DOK_OUT, TRIM(B.WK_OUT) AS WK_OUT, TRIM(B.KD_CONT_STATUS_OUT) AS KD_CONT_STATUS_OUT,
								 TRIM(B.KD_SARANA_ANGKUT_OUT) AS KD_SARANA_ANGKUT_OUT, TRIM(B.NO_POL_OUT) AS NO_POL_OUT, 
								 TRIM(B.KD_TPS_TUJUAN) AS KD_TPS_TUJUAN,
								 TRIM(B.KD_GUDANG_TUJUAN) AS KD_GUDANG_TUJUAN, TRIM(B.KD_KANTOR_PABEAN) AS KD_KANTOR_PABEAN, 
								 TRIM(B.NO_DAFTAR_PABEAN) AS NO_DAFTAR_PABEAN, TRIM(B.TGL_DAFTAR_PABEAN) AS TGL_DAFTAR_PABEAN, 
								 TRIM(B.NO_SEGEL_BC) AS NO_SEGEL_BC, TRIM(B.TGL_SEGEL_BC) AS TGL_SEGEL_BC, TRIM(B.NO_IJIN_TPS) AS NO_IJIN_TPS, 
								 TRIM(B.TGL_IJIN_TPS) AS TGL_IJIN_TPS, TRIM(B.FL_CONT_KOSONG) AS FL_CONT_KOSONG, 
								 TRIM(B.FL_TRANSFER_IN) AS FL_TRANSFER_IN,
								 TRIM(B.FL_TRANSFER_OUT) AS FL_TRANSFER_OUT, B.WK_REKAM
								 FROM t_cocostshdr A
								 INNER JOIN t_cocostscont B ON B.ID=A.ID
								 WHERE A.KD_ASAL_BRG = '1'
									   AND A.NO_VOY_FLIGHT = ".trim($wms_db->escape($data['NO_VOY_FLIGHT']))."
									   AND A.CALL_SIGN = ".trim($wms_db->escape($data['CALL_SIGN']))."
									   AND B.NO_CONT = ".trim($wms_db->escape($data['NO_CONT']));//echo $SQL_CONT; //die();
					$res_cont = $func->main->get_result($SQL_CONT);
					if($res_cont){
						 foreach($SQL_CONT->result_array() as $row => $value){
							$cont = $value;
						 }
						 $QUERY_REPO_CONT = "SELECT TRIM(B.KD_DOK_IN) AS KD_DOK_IN, TRIM(B.NO_DOK_IN) AS NO_DOK_IN, TRIM(B.TGL_DOK_IN) AS TGL_DOK_IN, 
											 TRIM(B.WK_IN) AS WK_IN, TRIM(B.KD_CONT_STATUS_IN) AS KD_CONT_STATUS_IN, TRIM(B.KD_SARANA_ANGKUT_IN) AS KD_SARANA_ANGKUT_IN, 
											 TRIM(B.NO_POL_IN) AS NO_POL_IN
											 FROM t_repohdr A
											 INNER JOIN t_repocont B ON B.ID=A.ID
											 WHERE A.KD_ASAL_BRG = '1'
											 AND A.NO_VOY_FLIGHT = ".trim($wms_db->escape($data['NO_VOY_FLIGHT']))."
											 AND A.CALL_SIGN = ".trim($wms_db->escape($data['CALL_SIGN']))."
											 AND A.TGL_TIBA = ".trim($wms_db->escape($data['TGL_TIBA']))."
											 AND B.NO_CONT = ".trim($wms_db->escape($data['NO_CONT']))."
											 ORDER BY A.ID DESC LIMIT 1";
						 $res_repocont = $func->main->get_result($QUERY_REPO_CONT);
						 if($res_repocont){
							 foreach($QUERY_REPO_CONT->result_array() as $rows => $values){
								$repocont = $values;
							 }
						 }
						 $arrdata = array("KD_CONT_UKURAN" 		 	=> $this->field($data['KD_CONT_UKURAN'],$cont['KD_CONT_UKURAN']),
						 				  "KD_CONT_JENIS"		 	=> $this->field($data['KD_CONT_JENIS'],$cont['KD_CONT_JENIS']),
										  "KD_CONT_TIPE"		 	=> $this->field($data['KD_CONT_TIPE'],$cont['KD_CONT_TIPE']),
										  "KD_ISO_CODE" 		 	=> $this->field($data['KD_ISO_CODE'],$cont['KD_ISO_CODE']),
										  "TEMPERATURE" 		 	=> $this->field($data['TEMPERATURE'],$cont['TEMPERATURE']),
										  "BRUTO" 				 	=> $this->field($data['BRUTO'],$cont['BRUTO']),
										  "NO_SEGEL" 			 	=> $this->field($data['NO_SEGEL'],$cont['NO_SEGEL']),
										  "KONDISI_SEGEL" 		 	=> $this->field($data['KONDISI_SEGEL'],$cont['KONDISI_SEGEL']),
										  "NO_BL_AWB" 			 	=> $this->field($data['NO_BL_AWB'],$cont['NO_BL_AWB']),
										  "TGL_BL_AWB" 		 		=> $this->field($data['TGL_BL_AWB'],$cont['TGL_BL_AWB']),
										  "NO_MASTER_BL_AWB" 	 	=> $this->field($data['NO_MASTER_BL_AWB'],$cont['NO_MASTER_BL_AWB']),
										  "TGL_MASTER_BL_AWB" 	 	=> $this->field($data['TGL_MASTER_BL_AWB'],$cont['TGL_MASTER_BL_AWB']),
										  "NO_POS_BC11" 		 	=> $this->field($data['NO_POS_BC11'],$cont['NO_POS_BC11']),
										  "KD_ORG_CONSIGNEE" 	 	=> $this->field($data['KD_ORG_CONSIGNEE'],$cont['KD_ORG_CONSIGNEE']),
										  "KD_TIMBUN_KAPAL" 	 	=> $this->field($data['KD_TIMBUN_KAPAL'],$cont['KD_TIMBUN_KAPAL']),
										  "KD_TIMBUN" 				=> $this->field($data['KD_TIMBUN'],$cont['KD_TIMBUN']),
										  "KD_PEL_MUAT" 			=> $this->field($data['KD_PEL_MUAT'],$cont['KD_PEL_MUAT']),
										  "KD_PEL_TRANSIT" 			=> $this->field($data['KD_PEL_TRANSIT'],$cont['KD_PEL_TRANSIT']),
										  "KD_PEL_BONGKAR" 			=> $this->field($data['KD_PEL_BONGKAR'],$cont['KD_PEL_BONGKAR']),
										  "KD_DOK_IN" 				=> $this->field($data['KD_DOK_IN'],$repocont['KD_DOK_IN']),
										  "NO_DOK_IN" 			 	=> $this->field($data['NO_DOK_IN'],$repocont['NO_DOK_IN']),
										  "TGL_DOK_IN" 		 		=> $this->field($data['TGL_DOK_IN'],$repocont['TGL_DOK_IN']),
										  "WK_IN" 				 	=> $this->field($data['WK_IN'],$repocont['WK_IN']),
										  "KD_CONT_STATUS_IN"   	=> $this->field($data['KD_CONT_STATUS_IN'],$repocont['KD_CONT_STATUS_IN']),
										  "KD_SARANA_ANGKUT_IN" 	=> $this->field($data['KD_SARANA_ANGKUT_IN'],$repocont['KD_SARANA_ANGKUT_IN']),
										  "NO_POL_IN" 			 	=> $this->field($data['NO_POL_IN'],$repocont['NO_POL_IN']),
										  "KD_DOK_OUT" 		 		=> $this->field($data['KD_DOK_OUT'],$cont['KD_DOK_OUT']),
										  "NO_DOK_OUT" 		 		=> $this->field($data['NO_DOK_OUT'],$cont['NO_DOK_OUT']),
										  "TGL_DOK_OUT" 		 	=> $this->field($data['TGL_DOK_OUT'],$cont['TGL_DOK_OUT']),
										  "WK_OUT" 			 		=> $this->field($data['WK_OUT'],$cont['WK_OUT']),
										  "KD_CONT_STATUS_OUT"	  	=> $this->field($data['KD_CONT_STATUS_OUT'],$cont['KD_CONT_STATUS_OUT']),
										  "KD_SARANA_ANGKUT_OUT" 	=> $this->field($data['KD_SARANA_ANGKUT_OUT'],$cont['KD_SARANA_ANGKUT_OUT']),
										  "NO_POL_OUT" 		  		=> $this->field($data['NO_POL_OUT'],$cont['NO_POL_OUT']),
										  "KD_TPS_TUJUAN" 			=> $this->field($data['KD_TPS_TUJUAN'],$cont['KD_TPS_TUJUAN']),
										  "KD_GUDANG_TUJUAN"		=> $this->field($data['KD_GUDANG_TUJUAN'],$cont['KD_GUDANG_TUJUAN']), 
										  "KD_KANTOR_PABEAN" 		=> $this->field($data['KD_KANTOR_PABEAN'],$cont['KD_KANTOR_PABEAN']),
										  "NO_DAFTAR_PABEAN" 		=> $this->field($data['NO_DAFTAR_PABEAN'],$cont['NO_DAFTAR_PABEAN']),
										  "TGL_DAFTAR_PABEAN" 		=> $this->field($data['TGL_DAFTAR_PABEAN'],$cont['TGL_DAFTAR_PABEAN']),
										  "NO_SEGEL_BC" 			=> $this->field($data['NO_SEGEL_BC'],$cont['NO_SEGEL_BC']),
										  "TGL_SEGEL_BC" 			=> $this->field($data['TGL_SEGEL_BC'],$cont['TGL_SEGEL_BC']),
										  "NO_IJIN_TPS" 			=> $this->field($data['NO_IJIN_TPS'],$cont['NO_IJIN_TPS']),
										  "TGL_IJIN_TPS" 			=> $this->field($data['TGL_IJIN_TPS'],$cont['TGL_IJIN_TPS']),
										  "FL_CONT_KOSONG"			=> $this->field($data['FL_CONT_KOSONG'],$cont['FL_CONT_KOSONG']),
										  "WK_REKAM"			    => $NOW);
						$wms_db->where(array('ID' => $cont['ID'], 'NO_CONT' => $cont['NO_CONT']));
						$res = $wms_db->update('t_cocostscont',$arrdata);//print_r($wms_db->last_query());die();
						if($res){
							echo "&nbsp;&nbsp;- GATE OUT IMPORT [UPDATE CONTAINER] - ".$data['NO_CONT']." IN ".$this->field($data['WK_IN'],$repocont['WK_IN'])." OUT ".$this->field($data['WK_OUT'],$cont['WK_OUT'])."<BR>";
							$RESPONSE = "SUCCESS";
						}
					}else{
						echo "NO RECORDS MATCH CONTAINER ".$data['NO_CONT']."<BR>";
						$RESPONSE = "FAILED";
					}
					$this->update_repo($data['ID'],$data['NO_CONT'],$RESPONSE);
				}
				
			}
		}else{
			echo "NO RECORDS FOUND"; exit();
		}
	}
	
	function repository_gatein(){
		#error_reporting(E_ALL);
		$wms_db = $this->load->database('wms',TRUE);
		$func =&get_instance();
		$func->load->model("m_main","main", true);
		date_default_timezone_set('Asia/Jakarta');
		$NOW = date('Y-m-d H:i:s');
		$SQL = "SELECT A.ID, A.KD_ASAL_BRG, A.KD_TPS, A.KD_GUDANG, A.KD_KAPAL, TRIM(A.NM_ANGKUT) AS NM_ANGKUT, 
				TRIM(A.NO_VOY_FLIGHT) AS NO_VOY_FLIGHT, TRIM(A.CALL_SIGN) AS CALL_SIGN, A.TGL_TIBA,
				TRIM(A.NO_BC11) AS NO_BC11, A.TGL_BC11, TRIM(A.KD_PEL_MUAT) AS PEL_MUAT, TRIM(A.KD_PEL_TRANSIT) AS PEL_TRANSIT,
				TRIM(A.KD_PEL_BONGKAR) AS PEL_BONGKAR,
				TRIM(B.NO_CONT) AS NO_CONT, TRIM(B.KD_CONT_UKURAN) AS KD_CONT_UKURAN, TRIM(B.KD_CONT_JENIS) AS KD_CONT_JENIS, 
				TRIM(B.KD_CONT_TIPE) AS KD_CONT_TIPE, TRIM(B.KD_ISO_CODE) AS KD_ISO_CODE, TRIM(B.TEMPERATURE) AS TEMPERATURE, 
				TRIM(B.BRUTO) AS BRUTO, TRIM(B.NO_SEGEL) AS NO_SEGEL, TRIM(B.KONDISI_SEGEL) AS KONDISI_SEGEL, 
				TRIM(B.NO_BL_AWB) AS NO_BL_AWB, B.TGL_BL_AWB, TRIM(B.NO_MASTER_BL_AWB) AS NO_MASTER_BL_AWB,
				B.TGL_MASTER_BL_AWB, TRIM(B.NO_POS_BC11) AS NO_POS_BC11, TRIM(B.KD_ORG_CONSIGNEE) AS KD_ORG_CONSIGNEE,
				TRIM(B.KD_TIMBUN_KAPAL) AS KD_TIMBUN_KAPAL, TRIM(B.KD_TIMBUN) AS KD_TIMBUN, TRIM(B.KD_PEL_MUAT) AS KD_PEL_MUAT, 
				TRIM(B.KD_PEL_TRANSIT) AS KD_PEL_TRANSIT, TRIM(B.KD_PEL_BONGKAR) AS KD_PEL_BONGKAR, TRIM(B.KD_DOK_IN) AS KD_DOK_IN, 
				TRIM(B.NO_DOK_IN) AS NO_DOK_IN, B.TGL_DOK_IN, TRIM(B.WK_IN) AS WK_IN, 
				TRIM(B.KD_CONT_STATUS_IN) AS KD_CONT_STATUS_IN, TRIM(B.KD_SARANA_ANGKUT_IN) AS KD_SARANA_ANGKUT_IN, 
				TRIM(B.NO_POL_IN) AS NO_POL_IN, TRIM(B.KD_DOK_OUT) AS KD_DOK_OUT, TRIM(B.NO_DOK_OUT) AS NO_DOK_OUT, 
				B.TGL_DOK_OUT, TRIM(B.WK_OUT) AS WK_OUT, TRIM(B.KD_CONT_STATUS_OUT) AS KD_CONT_STATUS_OUT,
				TRIM(B.KD_SARANA_ANGKUT_OUT) AS KD_SARANA_ANGKUT_OUT, TRIM(B.NO_POL_OUT) AS NO_POL_OUT, TRIM(B.KD_TPS_TUJUAN) AS KD_TPS_TUJUAN,
				TRIM(B.KD_GUDANG_TUJUAN) AS KD_GUDANG_TUJUAN, TRIM(B.KD_KANTOR_PABEAN) AS KD_KANTOR_PABEAN, 
				TRIM(B.NO_DAFTAR_PABEAN) AS NO_DAFTAR_PABEAN, B.TGL_DAFTAR_PABEAN, 
				TRIM(B.NO_SEGEL_BC) AS NO_SEGEL_BC, B.TGL_SEGEL_BC, TRIM(B.NO_IJIN_TPS) AS NO_IJIN_TPS, 
				B.TGL_IJIN_TPS, TRIM(B.FL_CONT_KOSONG) AS FL_CONT_KOSONG, TRIM(B.FL_TRANSFER_IN) AS FL_TRANSFER_IN,
				TRIM(B.FL_TRANSFER_OUT) AS FL_TRANSFER_OUT, B.WK_REKAM
				FROM t_repohdr A
				INNER JOIN t_repocont B ON B. ID=A.ID
				LEFT JOIN reff_asal_brg C ON C.ID=A.KD_ASAL_BRG
				WHERE B.FL_USE = 'N' AND A.KD_ASAL_BRG='4' AND A.KD_TPS IN ('PLDP','PLKB','LPJG')
					  
					  AND CASE A.KD_ASAL_BRG
						  WHEN '4' THEN B.KD_DOK_IN IS NOT NULL OR B.NO_DOK_IN IS NOT NULL OR B.TGL_DOK_IN IS NOT NULL 
						  ELSE 1=1
						  END
				ORDER BY C.URUTAN ASC LIMIT 0,30";
		//echo $SQL; die();
		$result = $func->main->get_result($SQL);
		if($result){
			foreach($SQL->result_array() as $row => $value){
				$arrdata[] = $value;
			}
			foreach($arrdata as $data){//print_r($data);die();
				$V_KD_ASAL_BRG = $data['KD_ASAL_BRG'];
				#COARRI DISCHARGE
				
				#CODECO EKSPOR [GATE IN]
				if($V_KD_ASAL_BRG == '4'){
					$SQL_HEADER = "SELECT ID FROM t_cocostshdr 
								   WHERE KD_ASAL_BRG = '3'
								   		 AND NO_VOY_FLIGHT = ".trim($wms_db->escape($data['NO_VOY_FLIGHT']))."
										 AND CALL_SIGN = ".trim($wms_db->escape($data['CALL_SIGN']))."
										 AND TGL_TIBA = ".trim($wms_db->escape($data['TGL_TIBA']));
					//echo $SQL_HEADER; die();
					$res_header = $func->main->get_result($SQL_HEADER);
					if($res_header){
						foreach($SQL_HEADER->result_array() as $row => $value){
							$arrheader = $value;
						}
						
						$arr_in_header['KD_TPS'] 	  	 = $this->emptystr($data['KD_TPS']);
						$arr_in_header['KD_GUDANG'] 	 = $this->emptystr($data['KD_GUDANG']);
						$arr_in_header['KD_KAPAL'] 		 = $this->emptystr($data['KD_KAPAL']);
						$arr_in_header['NM_ANGKUT'] 	 = $this->emptystr($data['NM_ANGKUT']);
						$arr_in_header['NO_VOY_FLIGHT']  = $this->emptystr($data['NO_VOY_FLIGHT']);
						$arr_in_header['CALL_SIGN'] 	 = $this->emptystr($data['CALL_SIGN']);
						$arr_in_header['TGL_TIBA'] 		 = $this->emptystr($data['TGL_TIBA']);
						$arr_in_header['NO_BC11'] 		 = $this->emptystr($data['NO_BC11']);
						$arr_in_header['TGL_BC11'] 		 = $this->emptystr($data['TGL_BC11']);
						$arr_in_header['KD_PEL_MUAT'] 	 = $this->emptystr($data['PEL_MUAT']);
						$arr_in_header['KD_PEL_TRANSIT'] = $this->emptystr($data['PEL_TRANSIT']);
						$arr_in_header['KD_PEL_BONGKAR'] = $this->emptystr($data['PEL_BONGKAR']);
						$wms_db->where(array('ID' => $arrheader['ID']));
						$wms_db->update('t_cocostshdr',$arr_in_header);
						$ID = $arrheader['ID'];
					}else{
						
						$arr_in_header['KD_ASAL_BRG'] 	 = '3';
						//$arr_in_header['FL_FROM'] 	 	 = 'FTP';
						$arr_in_header['KD_TPS'] 	  	 = $this->emptystr($data['KD_TPS']);
						$arr_in_header['KD_GUDANG'] 	 = $this->emptystr($data['KD_GUDANG']);
						$arr_in_header['KD_KAPAL'] 		 = $this->emptystr($data['KD_KAPAL']);
						$arr_in_header['NM_ANGKUT'] 	 = $this->emptystr($data['NM_ANGKUT']);
						$arr_in_header['NO_VOY_FLIGHT']  = $this->emptystr($data['NO_VOY_FLIGHT']);
						$arr_in_header['CALL_SIGN'] 	 = $this->emptystr($data['CALL_SIGN']);
						$arr_in_header['TGL_TIBA'] 		 = $this->emptystr($data['TGL_TIBA']);
						$arr_in_header['NO_BC11'] 		 = $data['NO_BC11'];
						$arr_in_header['TGL_BC11'] 		 = $data['TGL_BC11'];
						$arr_in_header['KD_PEL_MUAT'] 	 = $this->emptystr($data['PEL_MUAT']);
						$arr_in_header['KD_PEL_TRANSIT'] = $this->emptystr($data['PEL_TRANSIT']);
						$arr_in_header['KD_PEL_BONGKAR'] = $this->emptystr($data['PEL_BONGKAR']);
						$arr_in_header['WK_REKAM'] 		 = $NOW;
						$wms_db->insert('t_cocostshdr',$arr_in_header);
						$ID = $wms_db->insert_id();
						if($ID!=0){
							echo "GATE IN EXPORT [INSERT HEADER]<BR>";
						}
						
					}
					if($ID!=""){
						$SQL_CONT = "SELECT NO_CONT FROM t_cocostscont
									 WHERE ID = ".$wms_db->escape($ID)."
									 	   AND NO_CONT = ".$wms_db->escape($data['NO_CONT']);//echo $SQL_CONT; die();
						$res_cont = $func->main->get_result($SQL_CONT);
						if($res_cont){
							foreach($SQL_CONT->result_array() as $row => $value){
								$arrcont = $value;
							}
							
							$NEW_ID = $data['ID'];
							$NEW_CONT = $data['NO_CONT'];
							unset($data['ID']);
							unset($data['KD_ASAL_BRG']);
							unset($data['KD_TPS']);
							unset($data['KD_GUDANG']);
							unset($data['KD_KAPAL']);
							unset($data['NM_ANGKUT']);
							unset($data['NO_VOY_FLIGHT']);
							unset($data['CALL_SIGN']);
							unset($data['TGL_TIBA']);
							unset($data['NO_BC11']);
							unset($data['TGL_BC11']);
							unset($data['PEL_MUAT']);
							unset($data['PEL_TRANSIT']);
							unset($data['PEL_BONGKAR']);
							unset($data['NO_CONT']);
							unset($data['WK_OUT']);
							$data['WK_IN'] = $data['WK_IN'];
							$data['WK_REKAM'] = $NOW;
							$wms_db->where(array('ID' => $ID, 'NO_CONT' => $arrcont['NO_CONT']));
							$res = $wms_db->update('t_cocostscont',$data);
							if($res){
								echo "GATE IN EXPORT [UPDATE CONTAINER] - ".$NEW_CONT." IN ".$data['WK_IN']."<BR>";
								$RESPONSE = "SUCCESS";
							}else{
								$RESPONSE = "FAILED";
							}
						}else{
							
							$NEW_ID = $data['ID'];
							$NEW_CONT = $data['NO_CONT'];
							unset($data['ID']);
							unset($data['KD_ASAL_BRG']);
							unset($data['KD_TPS']);
							unset($data['KD_GUDANG']);
							unset($data['KD_KAPAL']);
							unset($data['NM_ANGKUT']);
							unset($data['NO_VOY_FLIGHT']);
							unset($data['CALL_SIGN']);
							unset($data['TGL_TIBA']);
							unset($data['NO_BC11']);
							unset($data['TGL_BC11']);
							unset($data['PEL_MUAT']);
							unset($data['PEL_TRANSIT']);
							unset($data['PEL_BONGKAR']);
							unset($data['WK_OUT']);
							$data['ID'] = $ID;
							$data['WK_IN'] = $data['WK_IN'];
							$data['WK_REKAM'] = $NOW;
							$res = $wms_db->insert('t_cocostscont',$data);
							if($res){
								echo "GATE IN EXPORT [INSERT CONTAINER] - ".$NEW_CONT." IN ".$data['WK_IN']."<BR>";
								$RESPONSE = "SUCCESS";
							}else{
								$RESPONSE = "FAILED";
							}
						}
						$this->update_repo($NEW_ID,$NEW_CONT,$RESPONSE);
					}
				}
			}
		}else{
			echo "NO RECORDS FOUND"; exit();
		}
	}
	
	function repository_loading(){
		#error_reporting(E_ALL);
		$wms_db = $this->load->database('wms',TRUE);
		$func =&get_instance();
		$func->load->model("m_main","main", true);
		date_default_timezone_set('Asia/Jakarta');
		$NOW = date('Y-m-d H:i:s');
		$SQL = "SELECT A.ID, A.KD_ASAL_BRG, A.KD_TPS, A.KD_GUDANG, A.KD_KAPAL, TRIM(A.NM_ANGKUT) AS NM_ANGKUT, 
				TRIM(A.NO_VOY_FLIGHT) AS NO_VOY_FLIGHT, TRIM(A.CALL_SIGN) AS CALL_SIGN, A.TGL_TIBA,
				TRIM(A.NO_BC11) AS NO_BC11, A.TGL_BC11, TRIM(A.KD_PEL_MUAT) AS PEL_MUAT, TRIM(A.KD_PEL_TRANSIT) AS PEL_TRANSIT,
				TRIM(A.KD_PEL_BONGKAR) AS PEL_BONGKAR,
				TRIM(B.NO_CONT) AS NO_CONT, TRIM(B.KD_CONT_UKURAN) AS KD_CONT_UKURAN, TRIM(B.KD_CONT_JENIS) AS KD_CONT_JENIS, 
				TRIM(B.KD_CONT_TIPE) AS KD_CONT_TIPE, TRIM(B.KD_ISO_CODE) AS KD_ISO_CODE, TRIM(B.TEMPERATURE) AS TEMPERATURE, 
				TRIM(B.BRUTO) AS BRUTO, TRIM(B.NO_SEGEL) AS NO_SEGEL, TRIM(B.KONDISI_SEGEL) AS KONDISI_SEGEL, 
				TRIM(B.NO_BL_AWB) AS NO_BL_AWB, B.TGL_BL_AWB, TRIM(B.NO_MASTER_BL_AWB) AS NO_MASTER_BL_AWB,
				B.TGL_MASTER_BL_AWB, TRIM(B.NO_POS_BC11) AS NO_POS_BC11, TRIM(B.KD_ORG_CONSIGNEE) AS KD_ORG_CONSIGNEE,
				TRIM(B.KD_TIMBUN_KAPAL) AS KD_TIMBUN_KAPAL, TRIM(B.KD_TIMBUN) AS KD_TIMBUN, TRIM(B.KD_PEL_MUAT) AS KD_PEL_MUAT, 
				TRIM(B.KD_PEL_TRANSIT) AS KD_PEL_TRANSIT, TRIM(B.KD_PEL_BONGKAR) AS KD_PEL_BONGKAR, TRIM(B.KD_DOK_IN) AS KD_DOK_IN, 
				TRIM(B.NO_DOK_IN) AS NO_DOK_IN, B.TGL_DOK_IN, TRIM(B.WK_IN) AS WK_IN, 
				TRIM(B.KD_CONT_STATUS_IN) AS KD_CONT_STATUS_IN, TRIM(B.KD_SARANA_ANGKUT_IN) AS KD_SARANA_ANGKUT_IN, 
				TRIM(B.NO_POL_IN) AS NO_POL_IN, TRIM(B.KD_DOK_OUT) AS KD_DOK_OUT, TRIM(B.NO_DOK_OUT) AS NO_DOK_OUT, 
				B.TGL_DOK_OUT, TRIM(B.WK_OUT) AS WK_OUT, TRIM(B.KD_CONT_STATUS_OUT) AS KD_CONT_STATUS_OUT,
				TRIM(B.KD_SARANA_ANGKUT_OUT) AS KD_SARANA_ANGKUT_OUT, TRIM(B.NO_POL_OUT) AS NO_POL_OUT, TRIM(B.KD_TPS_TUJUAN) AS KD_TPS_TUJUAN,
				TRIM(B.KD_GUDANG_TUJUAN) AS KD_GUDANG_TUJUAN, TRIM(B.KD_KANTOR_PABEAN) AS KD_KANTOR_PABEAN, 
				TRIM(B.NO_DAFTAR_PABEAN) AS NO_DAFTAR_PABEAN, B.TGL_DAFTAR_PABEAN, 
				TRIM(B.NO_SEGEL_BC) AS NO_SEGEL_BC, B.TGL_SEGEL_BC, TRIM(B.NO_IJIN_TPS) AS NO_IJIN_TPS, 
				B.TGL_IJIN_TPS, TRIM(B.FL_CONT_KOSONG) AS FL_CONT_KOSONG, TRIM(B.FL_TRANSFER_IN) AS FL_TRANSFER_IN,
				TRIM(B.FL_TRANSFER_OUT) AS FL_TRANSFER_OUT, B.WK_REKAM
				FROM t_repohdr A
				INNER JOIN t_repocont B ON B. ID=A.ID
				LEFT JOIN reff_asal_brg C ON C.ID=A.KD_ASAL_BRG
				WHERE B.FL_USE = 'N'
					  AND A.KD_ASAL_BRG = '3' AND A.KD_TPS IN ('PLDP','PLKB','LPJG')
					 
				ORDER BY C.URUTAN DESC LIMIT 0,30";
		//echo $SQL; die();
		$result = $func->main->get_result($SQL);
		if($result){
			foreach($SQL->result_array() as $row => $value){
				$arrdata[] = $value;
			}
			foreach($arrdata as $data){
				$V_KD_ASAL_BRG = $data['KD_ASAL_BRG'];
				
				#COARRI EKSPOR [LOADING]
				if($V_KD_ASAL_BRG == '3'){
					$SQL_CONT = "SELECT A.ID, A.KD_ASAL_BRG, A.KD_TPS, A.KD_GUDANG, A.KD_KAPAL, TRIM(A.NM_ANGKUT) AS NM_ANGKUT, 
								 TRIM(A.NO_VOY_FLIGHT) AS NO_VOY_FLIGHT, TRIM(A.CALL_SIGN) AS CALL_SIGN, TRIM(A.TGL_TIBA) AS TGL_TIBA,
								 TRIM(A.NO_BC11) AS NO_BC11, TRIM(A.TGL_BC11) AS TGL_BC11, TRIM(A.KD_PEL_MUAT) AS PEL_MUAT, 
								 TRIM(A.KD_PEL_TRANSIT) AS PEL_TRANSIT, TRIM(A.KD_PEL_BONGKAR) AS PEL_BONGKAR,
								 TRIM(B.NO_CONT) AS NO_CONT, TRIM(B.KD_CONT_UKURAN) AS KD_CONT_UKURAN, TRIM(B.KD_CONT_JENIS) AS KD_CONT_JENIS, 
								 TRIM(B.KD_CONT_TIPE) AS KD_CONT_TIPE, TRIM(B.KD_ISO_CODE) AS KD_ISO_CODE, TRIM(B.TEMPERATURE) AS TEMPERATURE, 
								 TRIM(B.BRUTO) AS BRUTO, TRIM(B.NO_SEGEL) AS NO_SEGEL, TRIM(B.KONDISI_SEGEL) AS KONDISI_SEGEL, 
								 TRIM(B.NO_BL_AWB) AS NO_BL_AWB, TRIM(B.TGL_BL_AWB) AS TGL_BL_AWB, TRIM(B.NO_MASTER_BL_AWB) AS NO_MASTER_BL_AWB,
								 TRIM(B.TGL_MASTER_BL_AWB) AS TGL_MASTER_BL_AWB, TRIM(B.NO_POS_BC11) AS NO_POS_BC11, 
								 TRIM(B.KD_ORG_CONSIGNEE) AS KD_ORG_CONSIGNEE, TRIM(B.KD_TIMBUN_KAPAL) AS KD_TIMBUN_KAPAL, 
								 TRIM(B.KD_TIMBUN) AS KD_TIMBUN, TRIM(B.KD_PEL_MUAT) AS KD_PEL_MUAT, 
								 TRIM(B.KD_PEL_TRANSIT) AS KD_PEL_TRANSIT, TRIM(B.KD_PEL_BONGKAR) AS KD_PEL_BONGKAR, 
								 TRIM(B.KD_DOK_IN) AS KD_DOK_IN,  TRIM(B.NO_DOK_IN) AS NO_DOK_IN, TRIM(B.TGL_DOK_IN) AS TGL_DOK_IN, 
								 TRIM(B.WK_IN) AS WK_IN, TRIM(B.KD_CONT_STATUS_IN) AS KD_CONT_STATUS_IN, 
								 TRIM(B.KD_SARANA_ANGKUT_IN) AS KD_SARANA_ANGKUT_IN, TRIM(B.NO_POL_IN) AS NO_POL_IN, 
								 TRIM(B.KD_DOK_OUT) AS KD_DOK_OUT, TRIM(B.NO_DOK_OUT) AS NO_DOK_OUT, 
								 TRIM(B.TGL_DOK_OUT) AS TGL_DOK_OUT, TRIM(B.WK_OUT) AS WK_OUT, TRIM(B.KD_CONT_STATUS_OUT) AS KD_CONT_STATUS_OUT,
								 TRIM(B.KD_SARANA_ANGKUT_OUT) AS KD_SARANA_ANGKUT_OUT, TRIM(B.NO_POL_OUT) AS NO_POL_OUT, 
								 TRIM(B.KD_TPS_TUJUAN) AS KD_TPS_TUJUAN,
								 TRIM(B.KD_GUDANG_TUJUAN) AS KD_GUDANG_TUJUAN, TRIM(B.KD_KANTOR_PABEAN) AS KD_KANTOR_PABEAN, 
								 TRIM(B.NO_DAFTAR_PABEAN) AS NO_DAFTAR_PABEAN, TRIM(B.TGL_DAFTAR_PABEAN) AS TGL_DAFTAR_PABEAN, 
								 TRIM(B.NO_SEGEL_BC) AS NO_SEGEL_BC, TRIM(B.TGL_SEGEL_BC) AS TGL_SEGEL_BC, TRIM(B.NO_IJIN_TPS) AS NO_IJIN_TPS, 
								 TRIM(B.TGL_IJIN_TPS) AS TGL_IJIN_TPS, TRIM(B.FL_CONT_KOSONG) AS FL_CONT_KOSONG, 
								 TRIM(B.FL_TRANSFER_IN) AS FL_TRANSFER_IN,
								 TRIM(B.FL_TRANSFER_OUT) AS FL_TRANSFER_OUT, B.WK_REKAM
								 FROM t_cocostshdr A
								 INNER JOIN t_cocostscont B ON B.ID=A.ID
								 WHERE A.KD_ASAL_BRG = '3'
									   AND A.NO_VOY_FLIGHT = ".trim($wms_db->escape($data['NO_VOY_FLIGHT']))."
									   AND A.CALL_SIGN = ".trim($wms_db->escape($data['CALL_SIGN']))."
									   AND B.NO_CONT = ".trim($wms_db->escape($data['NO_CONT']));//echo $SQL_CONT;//die();
					$res_cont = $func->main->get_result($SQL_CONT);
					if($res_cont){
						 foreach($SQL_CONT->result_array() as $row => $value){
							$cont = $value;
						 }
						 $QUERY_REPO_CONT = "SELECT TRIM(B.KD_DOK_IN) AS KD_DOK_IN,  TRIM(B.NO_DOK_IN) AS NO_DOK_IN, TRIM(B.TGL_DOK_IN) AS TGL_DOK_IN, 
											 TRIM(B.WK_IN) AS WK_IN, TRIM(B.KD_CONT_STATUS_IN) AS KD_CONT_STATUS_IN, TRIM(B.KD_SARANA_ANGKUT_IN) AS KD_SARANA_ANGKUT_IN, 
											 TRIM(B.NO_POL_IN) AS NO_POL_IN
											 FROM t_repohdr A
											 INNER JOIN t_repocont B ON B.ID=A.ID
											 WHERE A.KD_ASAL_BRG = '4'
											 AND A.NO_VOY_FLIGHT = ".trim($wms_db->escape($data['NO_VOY_FLIGHT']))."
											 AND A.CALL_SIGN = ".trim($wms_db->escape($data['CALL_SIGN']))."
											 AND B.NO_CONT = ".trim($wms_db->escape($data['NO_CONT']))."
											 ORDER BY A.ID DESC LIMIT 1";
						 //echo $QUERY_REPO_CONT;
						 $res_repocont = $func->main->get_result($QUERY_REPO_CONT);
						 if($res_repocont){
							 foreach($QUERY_REPO_CONT->result_array() as $rows => $values){
								$repocont = $values;
							 }
						 }					 
						 $arrdata = array("KD_CONT_UKURAN" 		 	=> $this->field($data['KD_CONT_UKURAN'],$cont['KD_CONT_UKURAN']),
						 				  "KD_CONT_JENIS"		 	=> $this->field($data['KD_CONT_JENIS'],$cont['KD_CONT_JENIS']),
										  "KD_CONT_TIPE"		 	=> $this->field($data['KD_CONT_TIPE'],$cont['KD_CONT_TIPE']),
										  "KD_ISO_CODE" 		 	=> $this->field($data['KD_ISO_CODE'],$cont['KD_ISO_CODE']),
										  "TEMPERATURE" 		 	=> $this->field($data['TEMPERATURE'],$cont['TEMPERATURE']),
										  "BRUTO" 				 	=> $this->field($data['BRUTO'],$cont['BRUTO']),
										  "NO_SEGEL" 			 	=> $this->field($data['NO_SEGEL'],$cont['NO_SEGEL']),
										  "KONDISI_SEGEL" 		 	=> $this->field($data['KONDISI_SEGEL'],$cont['KONDISI_SEGEL']),
										  "NO_BL_AWB" 			 	=> $this->field($data['NO_BL_AWB'],$cont['NO_BL_AWB']),
										  "TGL_BL_AWB" 		 		=> $this->field($data['TGL_BL_AWB'],$cont['TGL_BL_AWB']),
										  "NO_MASTER_BL_AWB" 	 	=> $this->field($data['NO_MASTER_BL_AWB'],$cont['NO_MASTER_BL_AWB']),
										  "TGL_MASTER_BL_AWB" 	 	=> $this->field($data['TGL_MASTER_BL_AWB'],$cont['TGL_MASTER_BL_AWB']),
										  "NO_POS_BC11" 		 	=> $this->field($data['NO_POS_BC11'],$cont['NO_POS_BC11']),
										  "KD_ORG_CONSIGNEE" 	 	=> $this->field($data['KD_ORG_CONSIGNEE'],$cont['KD_ORG_CONSIGNEE']),
										  "KD_TIMBUN_KAPAL" 	 	=> $this->field($data['KD_TIMBUN_KAPAL'],$cont['KD_TIMBUN_KAPAL']),
										  "KD_TIMBUN" 				=> $this->field($data['KD_TIMBUN'],$cont['KD_TIMBUN']),
										  "KD_PEL_MUAT" 			=> $this->field($data['KD_PEL_MUAT'],$cont['KD_PEL_MUAT']),
										  "KD_PEL_TRANSIT" 			=> $this->field($data['KD_PEL_TRANSIT'],$cont['KD_PEL_TRANSIT']),
										  "KD_PEL_BONGKAR" 			=> $this->field($data['KD_PEL_BONGKAR'],$cont['KD_PEL_BONGKAR']),
										  "KD_DOK_IN" 				=> $this->field($data['KD_DOK_IN'],$repocont['KD_DOK_IN']),
										  "NO_DOK_IN" 			 	=> $this->field($data['NO_DOK_IN'],$repocont['NO_DOK_IN']),
										  "TGL_DOK_IN" 		 		=> $this->field($data['TGL_DOK_IN'],$repocont['TGL_DOK_IN']),
										  "WK_IN" 				 	=> $this->field($data['WK_IN'],$repocont['WK_IN']),
										  "KD_CONT_STATUS_IN"   	=> $this->field($data['KD_CONT_STATUS_IN'],$repocont['KD_CONT_STATUS_IN']),
										  "KD_SARANA_ANGKUT_IN" 	=> $this->field($data['KD_SARANA_ANGKUT_IN'],$repocont['KD_SARANA_ANGKUT_IN']),
										  "NO_POL_IN" 			 	=> $this->field($data['NO_POL_IN'],$repocont['NO_POL_IN']),
										  "KD_DOK_OUT" 		 		=> $this->field($data['KD_DOK_OUT'],$cont['KD_DOK_OUT']),
										  "NO_DOK_OUT" 		 		=> $this->field($data['NO_DOK_OUT'],$cont['NO_DOK_OUT']),
										  "TGL_DOK_OUT" 		 	=> $this->field($data['TGL_DOK_OUT'],$cont['TGL_DOK_OUT']),
										  "WK_OUT" 			 		=> $this->field($data['WK_OUT'],$cont['WK_OUT']),
										  "KD_CONT_STATUS_OUT"	  	=> $this->field($data['KD_CONT_STATUS_OUT'],$cont['KD_CONT_STATUS_OUT']),
										  "KD_SARANA_ANGKUT_OUT" 	=> $this->field($data['KD_SARANA_ANGKUT_OUT'],$cont['KD_SARANA_ANGKUT_OUT']),
										  "NO_POL_OUT" 		  		=> $this->field($data['NO_POL_OUT'],$cont['NO_POL_OUT']),
										  "KD_TPS_TUJUAN" 			=> $this->field($data['KD_TPS_TUJUAN'],$cont['KD_TPS_TUJUAN']),
										  "KD_GUDANG_TUJUAN"		=> $this->field($data['KD_GUDANG_TUJUAN'],$cont['KD_GUDANG_TUJUAN']), 
										  "KD_KANTOR_PABEAN" 		=> $this->field($data['KD_KANTOR_PABEAN'],$cont['KD_KANTOR_PABEAN']),
										  "NO_DAFTAR_PABEAN" 		=> $this->field($data['NO_DAFTAR_PABEAN'],$cont['NO_DAFTAR_PABEAN']),
										  "TGL_DAFTAR_PABEAN" 		=> $this->field($data['TGL_DAFTAR_PABEAN'],$cont['TGL_DAFTAR_PABEAN']),
										  "NO_SEGEL_BC" 			=> $this->field($data['NO_SEGEL_BC'],$cont['NO_SEGEL_BC']),
										  "TGL_SEGEL_BC" 			=> $this->field($data['TGL_SEGEL_BC'],$cont['TGL_SEGEL_BC']),
										  "NO_IJIN_TPS" 			=> $this->field($data['NO_IJIN_TPS'],$cont['NO_IJIN_TPS']),
										  "TGL_IJIN_TPS" 			=> $this->field($data['TGL_IJIN_TPS'],$cont['TGL_IJIN_TPS']),
										  "FL_CONT_KOSONG"			=> $this->field($data['FL_CONT_KOSONG'],$cont['FL_CONT_KOSONG']),
										  "WK_REKAM"			    => $NOW);
						$wms_db->where(array('ID' => $cont['ID'], 'NO_CONT' => $cont['NO_CONT']));
						$res = $wms_db->update('t_cocostscont',$arrdata);
						if($res){
							echo "&nbsp;&nbsp;- LOADING EXPORT [UPDATE CONTAINER ".$data['ID']."] - ".$data['NO_CONT']." IN ".$this->field($data['WK_IN'],$repocont['WK_IN'])." OUT ".$this->field($data['WK_OUT'],$cont['WK_OUT'])."<BR>";
							$RESPONSE = "SUCCESS";
						}else{
							$RESPONSE = "FAILED";
						}
					}else{
						echo "NO RECORDS MATCH CONTAINER ".$data['NO_CONT']."<BR>";
						$RESPONSE = "FAILED";
					}
					
					$this->update_repo($data['ID'],$data['NO_CONT'],$RESPONSE);
					
				}
			}
		}else{
			echo "NO RECORDS FOUND"; exit();
		}
	}
		
	function update_repo($ID,$NO_CONT,$RESPONSE){
		$wms_db = $this->load->database('wms',TRUE);
		$wms_db->where(array('ID' => $ID, 'NO_CONT' => $NO_CONT));
		$res = $wms_db->update('t_repocont',array('FL_USE' => 'Y', 'RESPONSE' => $RESPONSE));
		if($res){
			return true;
		}else{
			return false;
		}		
	}
	
	function field($NEW,$OLD){
		if($NEW!=""){
			$data = $this->emptystr($NEW);
		}else{
			$data = $this->emptystr($OLD);
		}
		return $data;
	}
	
	function emptystr($str){
		if($str!=""){
			$data = trim($str);
		}else{
			$data = NULL;
		}
		return $data;
	}
	
	function format_mail_bc11($message){
		$subject = "TPSONLINE NPCT1 [REMINDER DATA BC11]";
		$email = 'edifact@npct1.co.id';
		$this->load->helper('email');
		$email_success = 0;
		if(valid_email($email)){
			$config = array(  
				'protocol'  => 'smtp',
				'smtp_host' => 'mail2.edi-indonesia.co.id',
				'smtp_port' => 25,
				'smtp_user' => '',
				'smtp_pass' => '',
				'mailtype'  => 'html', 
				'charset'   => 'iso-8859-1',
				'wrapchars' => 100,
				'crlf' 		=> "\r\n",
				'newline' 	=> "\r\n",
				'start_tls' => TRUE
			);
			$this->load->library('email', $config);
			#$this->email->set_newline("\r\n");
			$this->email->from('tpsonline@npct1.co.id', 'TPSONLINE NPCT1');
			$email = str_replace(';', ',', $email);			
			$this->email->to($email);
			$array_bcc = array('rizki@edi-indonesia.co.id','salman.abdulaziz@edi-indonesia.co.id');
			$this->email->bcc($array_bcc);
			$this->email->subject($subject);		
			$this->email->message($message);
			if ($this->email->send()){
				$email_success = 1;
			}
		}
		return $email_success;
	}
	
	function sendmail_bc11_is_null(){
		$func =&get_instance();
		$func->load->model("m_main","main", true);
		$message = "";
		$SQL = "SELECT A.ID, B.URAIAN AS DOCUMENT, TRIM(A.NM_ANGKUT) AS NM_ANGKUT,  TRIM(A.NO_VOY_FLIGHT) AS NO_VOY_FLIGHT, 
				TRIM(A.CALL_SIGN) AS CALL_SIGN, A.TGL_TIBA, TRIM(A.NO_BC11) AS NO_BC11, A.TGL_BC11
				FROM t_repohdr A
				INNER JOIN reff_asal_brg B ON B.ID=A.KD_ASAL_BRG
				WHERE CASE A.KD_ASAL_BRG
					  WHEN '1' THEN A.NO_BC11 IS NULL AND A.TGL_BC11 IS NULL
					  WHEN '2' THEN A.NO_BC11 IS NULL AND A.TGL_BC11 IS NULL
					  WHEN '3' THEN A.NO_BC11 IS NULL AND A.TGL_BC11 IS NULL
					END
				ORDER BY A.KD_ASAL_BRG ASC";
		echo $SQL; die();
		$result = $func->main->get_result($SQL);
		if($result){
			$message .= '<html><head><title>TPSONLINE NPCT1 [REMINDER DATA BC11](no-reply)</title></head>';
			$message .= '<body>';
			$message .= '<p>Please check BC 1.1 data on vessel data bellow : </p>';
			$message .= '<table style="border:1px solid #000" border="1">';
			$message .= '<tr>';
			$message .= '<td>DOCUMENT</td>';
			$message .= '<td>VESSEL</td>';
			$message .= '<td>CALL SIGN</td>';
			$message .= '<td>VOYAGE</td>';
			$message .= '<td>ARRIVAL/DEPARTURE DATE</td>';
			$message .= '<td>BC 1.1 NUMBER</td>';
			$message .= '<td>BC 1.1 DATE</td>';
			$message .= '</tr>';
			foreach($SQL->result_array() as $row => $value){
				$message .= '<tr>';
				$message .= '<td>'.$value['DOCUMENT'].'</td>';
				$message .= '<td>'.$value['NM_ANGKUT'].'</td>';
				$message .= '<td>'.$value['CALL_SIGN'].'</td>';
				$message .= '<td>'.$value['NO_VOY_FLIGHT'].'</td>';
				$message .= '<td>'.$value['TGL_TIBA'].'</td>';
				$message .= '<td align="center" style="color:red">?</td>';
				$message .= '<td align="center" style="color:red">?</td>';
				$message .= '</tr>';
			}
			$message .= '<table>';
			$message .= '</body>';
			$this->format_mail_bc11($message);
		}
	}
	
	function format_mail_codeco($message){
		$subject = "TPSONLINE NPCT1 [REMINDER DATA DOCUMENT CODECO]";
		$email = 'edifact@npct1.co.id';
		$this->load->helper('email');
		$email_success = 0;
		if(valid_email($email)){
			$config = array(  
				'protocol'  => 'smtp',
				'smtp_host' => 'mail2.edi-indonesia.co.id',
				'smtp_port' => 25,
				'smtp_user' => '',
				'smtp_pass' => '',
				'mailtype'  => 'html', 
				'charset'   => 'iso-8859-1',
				'wrapchars' => 100,
				'crlf' 		=> "\r\n",
				'newline' 	=> "\r\n",
				'start_tls' => TRUE
			);
			$this->load->library('email', $config);
			#$this->email->set_newline("\r\n");
			$this->email->from('tpsonline@npct1.co.id', 'TPSONLINE NPCT1');
			$email = str_replace(';', ',', $email);			
			$this->email->to($email);
			$array_bcc = array('rizki@edi-indonesia.co.id','salman.abdulaziz@edi-indonesia.co.id');
			$this->email->bcc($array_bcc);
			$this->email->subject($subject);		
			$this->email->message($message);
			if ($this->email->send()){
				$email_success = 1;
			}
		}
		return $email_success;
	}
	
	function sendmail_doc_codeco_is_null(){
		$func =&get_instance();
		$func->load->model("m_main","main", true);
		$message = "";
		$SQL = "SELECT A.ID, TRIM(A.NM_ANGKUT) AS NM_ANGKUT, TRIM(A.NO_VOY_FLIGHT) AS NO_VOY_FLIGHT, 
				TRIM(A.CALL_SIGN) AS CALL_SIGN, A.TGL_TIBA, TRIM(A.NO_BC11) AS NO_BC11, A.TGL_BC11, B.NO_CONT,
				CASE A.KD_ASAL_BRG
					WHEN '2' THEN B.KD_DOK_OUT
					WHEN '4' THEN B.KD_DOK_IN
				END AS DOCUMENT,
				CASE A.KD_ASAL_BRG
					WHEN '2' THEN B.NO_DOK_OUT
					WHEN '4' THEN B.NO_DOK_IN
				END AS NO_DOCUMENT,
				CASE A.KD_ASAL_BRG
					WHEN '2' THEN B.TGL_DOK_OUT
					WHEN '4' THEN B.TGL_DOK_IN
				END AS TGL_DOCUMENT,
				CASE A.KD_ASAL_BRG
					WHEN '2' THEN 'CODECO GATE OUT'
					WHEN '4' THEN 'CODECO GATE IN'
				END AS TYPE,
				B.NO_DAFTAR_PABEAN, B.TGL_DAFTAR_PABEAN	
				FROM t_repohdr A
				INNER JOIN t_repocont B ON B.ID=A.ID
				WHERE 1=1
				AND CASE A.KD_ASAL_BRG
					 WHEN '2' THEN B.KD_DOK_OUT IS NULL OR B.NO_DOK_OUT IS NULL OR B.TGL_DOK_OUT IS NULL 
								   OR B.NO_DAFTAR_PABEAN IS NULL OR B.TGL_DAFTAR_PABEAN IS NULL
					 WHEN '4' THEN B.KD_DOK_IN IS NULL OR B.NO_DOK_IN IS NULL OR B.TGL_DOK_IN IS NULL 
								   OR B.NO_DAFTAR_PABEAN IS NULL OR B.TGL_DAFTAR_PABEAN IS NULL
					END
				ORDER BY A.KD_ASAL_BRG ASC";
		$result = $func->main->get_result($SQL);
		if($result){
			$message = '';
			$message .= '<html><head><title>TPSONLINE NPCT1 [REMINDER DATA DOCUMENT CODECO](no-reply)</title></head>';
			$message .= '<body>';
			$message .= '<p>Please check document codeco on vessel data bellow : </p>';
			$message .= '<table style="border:1px solid #000" border="1">';
			$message .= '<tr>';
			$message .= '<td>DOCUMENT EDI</td>';
			$message .= '<td>VESSEL</td>';
			$message .= '<td>VOYAGE</td>';
			$message .= '<td>ARRIVAL/DEPARTURE DATE</td>';
			$message .= '<td>CONTAINER NO.</td>';
			$message .= '<td>CUSTOM NO.</td>';
			$message .= '<td>CUSTOM DATE</td>';
			$message .= '<td>DOCUMENT TYPE</td>';
			$message .= '<td>DOCUMENT NO.</td>';
			$message .= '<td>DOCUMENT DATE</td>';
			$message .= '</tr>';
			foreach($SQL->result_array() as $row => $value){
				$message .= '<tr>';
				$message .= '<td>'.$value['TYPE'].'</td>';
				$message .= '<td>'.$value['NM_ANGKUT'].'</td>';
				$message .= '<td>'.$value['NO_VOY_FLIGHT'].'</td>';
				$message .= '<td>'.$value['TGL_TIBA'].'</td>';
				$message .= '<td>'.$value['NO_CONT'].'</td>';
				if($value['NO_DAFTAR_PABEAN']!= ""){
					$css1 = '';
					$NO_DAFTAR_PABEAN = $value['NO_DAFTAR_PABEAN'];
				}else{
					$css1 = 'align="center" style="color:red"';
					$NO_DAFTAR_PABEAN = "?";
				}
				if($value['TGL_DAFTAR_PABEAN'] != ""){
					$css2 = '';
					$TGL_DAFTAR_PABEAN = $value['TGL_DAFTAR_PABEAN'];
				}else{
					$css2 = 'align="center" style="color:red"';
					$TGL_DAFTAR_PABEAN = "?";
				}
				if($value['DOCUMENT'] != ""){
					$css3 = '';
					$DOCUMENT = $value['DOCUMENT'];
				}else{
					$css3 = 'align="center" style="color:red"';
					$DOCUMENT = "?";
				}
				if($value['NO_DOCUMENT'] != ""){
					$css4 = '';
					$NO_DOCUMENT = $value['NO_DOCUMENT'];
				}else{
					$css4 = 'align="center" style="color:red"';
					$NO_DOCUMENT = "?";
				}
				if($value['TGL_DOCUMENT'] != ""){
					$css5 = '';
					$TGL_DOCUMENT = $value['TGL_DOCUMENT'];
				}else{
					$css5 = 'align="center" style="color:red"';
					$TGL_DOCUMENT = "?";
				}
				$message .= '<td '.$css1.'>'.$NO_DAFTAR_PABEAN.'</td>';
				$message .= '<td '.$css2.'>'.$TGL_DAFTAR_PABEAN.'</td>';
				$message .= '<td '.$css3.'>'.$DOCUMENT.'</td>';
				$message .= '<td '.$css4.'>'.$NO_DOCUMENT.'</td>';
				$message .= '<td '.$css5.'>'.$TGL_DOCUMENT.'</td>';
				$message .= '</tr>';
			}
			$message .= '<table>';
			$message .= '</body>';
			$this->format_mail_codeco($message);
		}
	}
}
?>