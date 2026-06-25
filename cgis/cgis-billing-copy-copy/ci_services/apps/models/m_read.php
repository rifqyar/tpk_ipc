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
				WHERE B.FL_USE = 'N' 
					  AND A.NO_BC11 IS NOT NULL
					  AND A.TGL_BC11 IS NOT NULL
				ORDER BY A.KD_ASAL_BRG ASC LIMIT 0,30";
		//echo $SQL; die();
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
								   WHERE KD_ASAL_BRG = ".$this->db->escape($data['KD_ASAL_BRG'])."
								   		 AND NO_VOY_FLIGHT = ".trim($this->db->escape($data['NO_VOY_FLIGHT']))."
										 AND CALL_SIGN = ".trim($this->db->escape($data['CALL_SIGN']))."
										 AND TGL_TIBA = ".trim($this->db->escape($data['TGL_TIBA']));
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
						
						$this->db->where(array('ID' => $arrheader['ID']));
						$this->db->update('t_cocostshdr',$arr_in_header);
						$ID = $arrheader['ID'];
					}else{
						$arr_in_header['KD_ASAL_BRG'] 	 = '1';
						$arr_in_header['KD_TPS'] 	  	 = 'NCT1';
						$arr_in_header['KD_GUDANG'] 	 = 'NCT1';
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
						$this->db->insert('t_cocostshdr',$arr_in_header);
						$ID = $this->db->insert_id();
						if($ID!=""){
							echo "DISCHARGE [INSERT HEADER]<br>";
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
							$data['WK_REKAM'] = $NOW;
							
							$this->db->where(array('ID' => $ID, 'NO_CONT' => $arrcont['NO_CONT']));
							$res = $this->db->update('t_cocostscont',$data);
							if($res){
								echo "&nbsp;&nbsp;- DISCHARGE [UPDATE CONTAINER] - ".$NEW_CONT."<BR>";
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
							
							$res = $this->db->insert('t_cocostscont',$data);
							if($res){
								echo "&nbsp;&nbsp;- DISCHARGE [INSERT CONTAINER] - ".$NEW_CONT."<BR>";
							}
						}
						$this->update_repo($NEW_ID,$NEW_CONT);
					}
				}
				
				#CODECO IMPOR
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
									   AND A.NO_VOY_FLIGHT = ".trim($this->db->escape($data['NO_VOY_FLIGHT']))."
									   AND A.CALL_SIGN = ".trim($this->db->escape($data['CALL_SIGN']))."
									   AND A.TGL_TIBA = ".trim($this->db->escape($data['TGL_TIBA']))."
									   AND B.NO_CONT = ".trim($this->db->escape($data['NO_CONT']));
					$res_cont = $func->main->get_result($SQL_CONT);
					if($res_cont){
						 foreach($SQL_CONT->result_array() as $row => $value){
							$cont = $value;
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
										  "KD_DOK_IN" 				=> $this->field($data['KD_DOK_IN'],$cont['KD_DOK_IN']),
										  "NO_DOK_IN" 			 	=> $this->field($data['NO_DOK_IN'],$cont['NO_DOK_IN']),
										  "TGL_DOK_IN" 		 		=> $this->field($data['TGL_DOK_IN'],$cont['TGL_DOK_IN']),
										  "WK_IN" 				 	=> $this->field($data['WK_IN'],$cont['WK_IN']),
										  "KD_CONT_STATUS_IN"   	=> $this->field($data['KD_CONT_STATUS_IN'],$cont['KD_CONT_STATUS_IN']),
										  "KD_SARANA_ANGKUT_IN" 	=> $this->field($data['KD_SARANA_ANGKUT_IN'],$cont['KD_SARANA_ANGKUT_IN']),
										  "NO_POL_IN" 			 	=> $this->field($data['NO_POL_IN'],$cont['NO_POL_IN']),
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
						$this->db->where(array('ID' => $cont['ID'], 'NO_CONT' => $cont['NO_CONT']));
						$res = $this->db->update('t_cocostscont',$arrdata);
						if($res){
							echo "&nbsp;&nbsp;- GATE OUT IMPORT [UPDATE CONTAINER] - ".$data['NO_CONT']."<BR>";
						}
					}else{
						echo "NO RECORDS MATCH CONTAINER ".$data['NO_CONT']."<BR>";
					}
					$this->update_repo($data['ID'],$data['NO_CONT']);
				}
				
				#COARRI EKSPOR
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
								 WHERE A.KD_ASAL_BRG = '4'
									   AND A.NO_VOY_FLIGHT = ".trim($this->db->escape($data['NO_VOY_FLIGHT']))."
									   AND A.CALL_SIGN = ".trim($this->db->escape($data['CALL_SIGN']))."
									   AND A.TGL_TIBA = ".trim($this->db->escape($data['TGL_TIBA']))."
									   AND A.NO_CONT = ".trim($this->db->escape($data['NO_CONT']));
					$res_cont = $func->main->get_result($SQL_CONT);
					if($res_cont){
						 foreach($SQL_CONT->result_array() as $row => $value){
							$cont = $value;
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
										  "KD_DOK_IN" 				=> $this->field($data['KD_DOK_IN'],$cont['KD_DOK_IN']),
										  "NO_DOK_IN" 			 	=> $this->field($data['NO_DOK_IN'],$cont['NO_DOK_IN']),
										  "TGL_DOK_IN" 		 		=> $this->field($data['TGL_DOK_IN'],$cont['TGL_DOK_IN']),
										  "WK_IN" 				 	=> NULL,#$this->field($data['WK_IN'],$cont['WK_IN']),
										  "KD_CONT_STATUS_IN"   	=> $this->field($data['KD_CONT_STATUS_IN'],$cont['KD_CONT_STATUS_IN']),
										  "KD_SARANA_ANGKUT_IN" 	=> $this->field($data['KD_SARANA_ANGKUT_IN'],$cont['KD_SARANA_ANGKUT_IN']),
										  "NO_POL_IN" 			 	=> $this->field($data['NO_POL_IN'],$cont['NO_POL_IN']),
										  "KD_DOK_OUT" 		 		=> $this->field($data['KD_DOK_OUT'],$cont['KD_DOK_OUT']),
										  "NO_DOK_OUT" 		 		=> $this->field($data['NO_DOK_OUT'],$cont['NO_DOK_OUT']),
										  "TGL_DOK_OUT" 		 	=> $this->field($data['TGL_DOK_OUT'],$cont['TGL_DOK_OUT']),
										  "WK_OUT" 			 		=> NULL,#$this->field($data['WK_OUT'],$cont['WK_OUT']),
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
						$this->db->where(array('ID' => $cont['ID'], 'NO_CONT' => $cont['NO_CONT']));
						$res = $this->db->update('t_cocostscont',$arrdata);
						if($res){
							echo "&nbsp;&nbsp;- LOADING EXPORT [UPDATE CONTAINER] - ".$data['NO_CONT']."<BR>";
						}
					}else{
						echo "NO RECORDS MATCH CONTAINER ".$data['NO_CONT']."<BR>";
					}
					$this->update_repo($data['ID'],$data['NO_CONT']);
				}
				
				#CODECO EKSPOR
				if($V_KD_ASAL_BRG == '4'){
					$SQL_HEADER = "SELECT ID FROM t_cocostshdr 
								   WHERE KD_ASAL_BRG = ".$this->db->escape($data['KD_ASAL_BRG'])."
								   		 AND NO_VOY_FLIGHT = ".trim($this->db->escape($data['NO_VOY_FLIGHT']))."
										 AND CALL_SIGN = ".trim($this->db->escape($data['CALL_SIGN']))."
										 AND TGL_TIBA = ".trim($this->db->escape($data['TGL_TIBA']));
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
						$this->db->where(array('ID' => $arrheader['ID']));
						$this->db->update('t_cocostshdr',$arr_in_header);
						$ID = $arrheader['ID'];
					}else{
						$arr_in_header['KD_ASAL_BRG'] 	 = '4';
						$arr_in_header['KD_TPS'] 	  	 = 'NCT1';
						$arr_in_header['KD_GUDANG'] 	 = 'NCT1';
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
						$this->db->insert('t_cocostshdr',$arr_in_header);
						$ID = $this->db->insert_id();
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
							$data['WK_IN'] = NULL;
							$data['WK_IN'] = NULL;
							$data['WK_REKAM'] = $NOW;
							$this->db->where(array('ID' => $ID, 'NO_CONT' => $arrcont['NO_CONT']));
							$res = $this->db->update('t_cocostscont',$data);
							if($res){
								echo "GATE IN EXPORT [UPDATE CONTAINER] - ".$NEW_CONT."<BR>";
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
							$data['ID'] = $ID;
							$data['WK_IN'] = NULL;
							$data['WK_OUT'] = NULL;
							$data['WK_REKAM'] = $NOW;
							$res = $this->db->insert('t_cocostscont',$data);
							if($res){
								echo "GATE IN EXPORT [INSERT CONTAINER] - ".$NEW_CONT."<BR>";
							}
						}
						$this->update_repo($NEW_ID,$NEW_CONT);
					}
				}
			}
		}else{
			echo "NO RECORDS FOUND"; exit();
		}
	}
	
	function update_repo($ID,$NO_CONT){
		$this->db->where(array('ID' => $ID, 'NO_CONT' => $NO_CONT));
		$res = $this->db->update('t_repocont',array('FL_USE' => 'Y'));
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
	
	function send_email(){
		$func =&get_instance();
		$func->load->model("m_main","main", true);
		$message = "";
		$SQL = "SELECT A.ID, B.URAIAN AS DOCUMENT, TRIM(A.NM_ANGKUT) AS NM_ANGKUT,  TRIM(A.NO_VOY_FLIGHT) AS NO_VOY_FLIGHT, 
				TRIM(A.CALL_SIGN) AS CALL_SIGN, A.TGL_TIBA, TRIM(A.NO_BC11) AS NO_BC11, A.TGL_BC11
				FROM t_repohdr A
				INNER JOIN reff_asal_brg B ON B.ID=A.KD_ASAL_BRG
				WHERE A.NO_BC11 IS NULL
					  AND A.TGL_BC11 IS NULL
				ORDER BY A.KD_ASAL_BRG ASC";
		$result = $func->main->get_result($SQL);
		if($result){
			$message .= '<html><head><title>REMINDER DATA BC11 [TPS ONLINE NPCT1] (no-reply)</title></head>';
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
			$this->format_mail($message);
		}
	}
	
	
	function format_mail($message){
		$subject = "REMINDER DATA BC11 [TPSONLINE]";
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
			$array_bcc = array('ric.corporation@gmail.com','rizki@edi-indonesia.co.id','salman.abdulaziz@edi-indonesia.co.id');
			$this->email->bcc($array_bcc);
			$this->email->subject($subject);		
			$this->email->message($message);
			if ($this->email->send()){
				$email_success = 1;
			}
		}
		return $email_success;
	}
	
	function send_email_document(){
		$func =&get_instance();
		$func->load->model("m_main","main", true);
		$message = "";
		$SQL = "SELECT A.ID, B.URAIAN AS DOCUMENT, TRIM(A.NM_ANGKUT) AS NM_ANGKUT,  TRIM(A.NO_VOY_FLIGHT) AS NO_VOY_FLIGHT, 
				TRIM(A.CALL_SIGN) AS CALL_SIGN, A.TGL_TIBA, TRIM(A.NO_BC11) AS NO_BC11, A.TGL_BC11
				FROM t_repohdr A
				INNER JOIN t_cocostscont B ON B.ID=A.ID
				WHERE A.KD_ASAL_BRG IN('2','4')
					  AND A.NO_DAFTAR_PABEAN IS NULL
					  AND A.TGL_DAFTAR_PABEAN IS NULL 
				ORDER BY A.KD_ASAL_BRG ASC";
		$result = $func->main->get_result($SQL);
		if($result){
			$message .= '<html><head><title>REMINDER DATA BC11 [TPS ONLINE NPCT1] (no-reply)</title></head>';
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
			$this->format_mail($message);
		}
	}
}
?>