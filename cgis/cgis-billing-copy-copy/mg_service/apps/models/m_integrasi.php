<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class M_integrasi extends CI_Model{
	
	function manifest(){

		$wms_db = $this->load->database('wms',TRUE);

		$HeaderSQL 	= "	SELECT DISTINCT A.ID AS ID, A.ID_REQ, A.TGL_REQ, A.NO_NOTA_DELIVERY,  DATE_FORMAT(A.TGL_NOTA,'%Y-%m-%d') AS TGL_NOTA, F.NAMA_CUST, F.ALAMAT, A.NPWP, A.NM_KAPAL, A.TOTAL AS AMOUNT, NOW() AS DATE_NOW
						FROM req_delivery_hdr A INNER JOIN m_bank C ON A.BANK_ID = C.BANK_ID
						INNER JOIN req_delivery_simkeu D ON A.ID_REQ = D.ID_REQ
						INNER JOIN t_permit_hdr E ON A.NO_DOK = E.NO_DOK_INOUT AND A.TGL_DOK = E.TGL_DOK_INOUT
						LEFT JOIN m_pelanggan F ON A.NPWP = F.NPWP
						WHERE A.NO_NOTA_DELIVERY IS NOT NULL AND A.FLAG_AR ='N' AND DATE(A.TGL_NOTA) =  CURDATE() 
						GROUP BY A.NO_NOTA_DELIVERY
						ORDER BY A.NO_NOTA_DELIVERY DESC  ";

		echo $HeaderSQL;
		echo "<br>";

		$HeaderResult 	= $wms_db->query($HeaderSQL);
		$ArrayHeader 	= $HeaderResult->result_array();

		if($HeaderResult->num_rows() > 0){
			foreach ($ArrayHeader as $data) {
				$ID_REQ = $data['ID_REQ'];

				$SQL_CEK ="SELECT INVOICE FROM MTI_AR WHERE INVOICE = '".$data['NO_NOTA_DELIVERY']."'";
				echo $SQL_CEK;
				echo "<br>";
				$CekResult = $this->db->query($SQL_CEK);
				$ArrayCek = $CekResult->result_array();

				if ($CekResult->num_rows() == 0) {
					$ContentSQL = " SELECT A.JENIS_TARIF, A.CHARGE, COUNT(DISTINCT A.NO_CONT) AS QTY, SUM(A.TOTAL) AS TOTAL FROM req_delivery_simkeu A INNER JOIN req_delivery_hdr B ON A.ID_REQ = B.ID_REQ WHERE B.ID_REQ = '" . $ID_REQ . "' GROUP BY A.JENIS_TARIF HAVING SUM(A.TOTAL) > 0 ";
					echo $ContentSQL;
					echo "<br>";

					$ContentResult 	= $wms_db->query($ContentSQL);
					$ArrayContent 	= $ContentResult->result_array();

					foreach($ArrayContent as $datas){
						if ($datas['JENIS_TARIF'] == 'MATERAI DEL') {
							$pajak = 'PPN 0%';
						}else{
							$pajak = 'PPN 10%';
						}

						$this->db->set('BATCH_NAME', 'MTI BILLING');
						$this->db->set('CUST_TYPE', 'PIUT. AFILIASI PTP');
						$this->db->set('INVOICE', $data['NO_NOTA_DELIVERY']);
						$this->db->set('ORIG_SYSTEM_BILL_CUSTOMER_ID', 51076);
						$this->db->set('ORIG_SYSTEM_BILL_ADDRESS_ID', 54062);
						$this->db->set('ORIG_SYSTEM_SHIP_CUSTOMER_ID', 51076);
						$this->db->set('ORIG_SYSTEM_SHIP_ADDRESS_ID', 54062);
						$this->db->set('ORIG_SOLD_BILL_CUSTOMER_ID', 51076);
						$this->db->set('TERM_NAME', 'IMMEDIATE');
						$this->db->set('TGL_TRX', "to_date('".$data['TGL_NOTA']."', 'YYYY-MM-DD')",FALSE);
						$this->db->set('GL_DATE', "to_date('".$data['TGL_NOTA']."', 'YYYY-MM-DD')",FALSE);
						$this->db->set('CURRENCY', 'IDR');
						$this->db->set('CONVERSION_TYPE', 'Corporate');
						$this->db->set('LINE_TYPE', 'LINE');
						$this->db->set('HEADER_ATTRIBUTE1', 'MTI');
						$this->db->set('HEADER_ATTRIBUTE3', $data['NAMA_CUST']);
						$this->db->set('HEADER_ATTRIBUTE4', $data['ALAMAT']);
						$this->db->set('HEADER_ATTRIBUTE5', $data['NPWP']);
						$this->db->set('HEADER_ATTRIBUTE6', 'SCS');
						$this->db->set('INTERF_LINE', 'MTI');
						$this->db->set('NO_FAKTUR', $data['NO_NOTA_DELIVERY']);
						$this->db->set('ANUMBER', 17435);
						$this->db->set('NO_SP', 'SPBOS2018-1');
						$this->db->set('STATUS_BAYAR', 'TUNAI');
						$this->db->set('MEMO_LINE', 0);
						$this->db->set('JOURNAL_DESC', $datas['JENIS_TARIF']);
						$this->db->set('JUMLAH_DIBAYAR', $datas['TOTAL']);
						$this->db->set('PAJAK', $pajak);
						$this->db->set('INC_PAJAK', 'N');
						$this->db->set('SET_BOOK_ID', '2021');
						$this->db->set('ORG_ID', '84');
						$this->db->set('MSG_DATA', '0');
						$this->db->set('PAJAK_AMT', '0.00');
						$this->db->set('LOKASI', 'COMMON AREA');
						$this->db->set('SEGMENT1', '04');
						$this->db->set('SEGMENT2', '003');
						$this->db->set('SEGMENT3', '113');
						$this->db->set('SEGMENT4', '2022');
						$this->db->set('SEGMENT5', '70100000');
						$this->db->set('SEGMENT6', '999');
						$this->db->set('SEGMENT7', '010104');
						$this->db->set('SEGMENT8', '00000');
						$this->db->set('SEGMENT9', '00000');

						$SENDAR = $this->db->insert('MTI_AR');
						print_r($this->db->last_query());
						echo "<br>";

						if(!$SENDAR){
							echo "AR GAGAL <hr>";
						}else{
							echo "AR BERHASIL <hr>";
							$wms_db->where(array('ID_REQ' =>$ID_REQ));
							$wms_db->update('req_delivery_hdr', array('FLAG_AR' => 'Y'));
						}
					}

					$SQL_CEK2 ="SELECT RECEIPT_NUMBER FROM MTI_AR_RECEIPT WHERE RECEIPT_NUMBER = '".$data['NO_NOTA_DELIVERY']."'";
					echo $SQL_CEK2;
					echo "<br>";
					$CekResult2 = $this->db->query($SQL_CEK2);
					$ArrayCek2 = $CekResult2->result_array();

					if ($CekResult2->num_rows() == 0) {
						$this->db->set('RECEIPT_NUMBER', $data['NO_NOTA_DELIVERY']);
						$this->db->set('RECEIPT_METHOD', 'MDR-IDR-MTI-JKT-7593');
						$this->db->set('RECEIPT_ACCOUNT', 'MDR-IDR-MTI-JKT-7593');
						$this->db->set('ORG_ID', 84);
						$this->db->set('BANK_ID', 11021);
						$this->db->set('CUSTOMER_NUMBER', 51076);
						$this->db->set('RECEIPT_DATE', "to_date('".$data['TGL_NOTA']."', 'YYYY-MM-DD')",FALSE);
						$this->db->set('TRX_DATE', "to_date('".$data['TGL_NOTA']."', 'YYYY-MM-DD')",FALSE);
						$this->db->set('CURRENCY', 'IDR');
						$this->db->set('AMOUNT', $data['AMOUNT']);
						$this->db->set('RECEIPT_TYPE', 'BRG');
						$this->db->set('RECEIPT_SUB_TYPE', 'BRG12');
						$this->db->set('REF_NUMBER', $data['NO_NOTA_DELIVERY']);
						$this->db->set('CREATION_DATE', "to_date('".$data['DATE_NOW']."', 'YYYY-MM-DD HH24:MI:SS')",FALSE);

						$SENDRECEIPT = $this->db->insert('MTI_AR_RECEIPT');
						print_r($this->db->last_query());
						echo "<br>";

						if(!$SENDRECEIPT){
							echo "RECEIPT GAGAL <hr>";
						}else{
							echo "RECEIPT BERHASIL <hr>";
							$wms_db->where(array('ID_REQ' =>$ID_REQ));
							$wms_db->update('req_delivery_hdr', array('FLAG_RECEIPT' => 'Y'));
						}
					}
				}
				echo "<hr>";
			}

			$wms_db->close();	
			$this->db->close();	
		}		
	}
	
	function respon_plp(){

		$wms_db = $this->load->database('wms',TRUE);

		$SQL = " SELECT * FROM req_delivery_hdr WHERE FLAG_AR ='Y' ";

		$result 		= $wms_db->query($SQL);
		$arrayResult	= $result->result_array();

		if($result->num_rows() > 0){
			foreach ($arrayResult as $data) {

				$SQL_AR =" SELECT * FROM MTI_AR WHERE INVOICE = '".$data['NO_NOTA_DELIVERY']."' AND STATUS IS NOT NULL ";
				$resultAR = $this->db->query($SQL_AR);
				$ArrayAR = $resultAR->result_array();
				
				if ($resultAR->num_rows() > 0) {
					foreach($ArrayAR as $datas){

						$wms_db->where(array('NO_NOTA_DELIVERY' =>$datas['INVOICE']));
						$wms_db->update('req_delivery_hdr', array('FLAG_AR' => $datas['STATUS'], 'MESSAGE_AR' => $datas['MSG_DATA']));
						print_r($wms_db->last_query());
					}
				}
			}
		}
	}
	
	function coarri_cont(){

		$wms_db = $this->load->database('wms',TRUE);

		$SQL = " SELECT * FROM req_delivery_hdr WHERE FLAG_RECEIPT ='N' ";

		$result 		= $wms_db->query($SQL);
		$arrayResult	= $result->result_array();

		if($result->num_rows() > 0){
			foreach ($arrayResult as $data) {

				$SQL_RECEIPT =" SELECT * FROM MTI_AR_RECEIPT WHERE REF_NUMBER = '".$data['NO_NOTA_DELIVERY']."' AND STATUS_RECEIPT IS NOT NULL ";
				$resultReceipt = $this->db->query($SQL_RECEIPT);
				$ArrayReceipt = $resultReceipt->result_array();
				
				if ($resultReceipt->num_rows() > 0) {
					foreach($ArrayReceipt as $datas){

						$wms_db->where(array('NO_NOTA_DELIVERY' =>$datas['REF_NUMBER']));
						$wms_db->update('req_delivery_hdr', array('FLAG_RECEIPT' => $datas['STATUS_RECEIPT'], 'MESSAGE_RECEIPT' => $datas['STATUS_RECEIPTMSG']));
						print_r($wms_db->last_query());
					}
				}
			}
		}
	}
	
	function coarri_loadingcont(){
		$SQL = "SELECT * FROM IBIS.m_coarri A   
				LEFT JOIN IBIS.m_cont_tps_document B ON b.no_container=a.no_container AND a.point=b.point
				WHERE a.e_i='E' AND B.UK_CONT is not null AND A.flag_send_edi IS NULL AND A.ID_TERMINAL='IDPLG' AND ROWNUM <= 30";//echo $SQL;die();
		$exec = $this->db->query($SQL);//echo "sini";die();
		if($exec->num_rows() > 0){
			//$filename = DIR_EXE.'codeco_cont.txt';
			//$check_file = check_file($filename);
			if(!$check_file){
				create_file($filename);
				$wms_db = $this->load->database('wms',TRUE);
				$array_data = $exec->result_array();//print_r($array_data);die();
				foreach($array_data as $data){
					switch ($data['INOUT']) {
						case "I": // COARRI DISCHARGE
							$KD_ASAL_BRG = '1';
							$URAIAN_DOKUMEN = 'COARRI DISCHARGE';
							break;
						case "O": // COARRI LOADING
							$KD_ASAL_BRG = '3';
							$URAIAN_DOKUMEN = 'COARRI LOADING';
							break;
					}
					switch ($data['ID_TERMINAL']) {
						case "IDPLG": // COARRI DISCHARGE
							$KD_TPS = 'PLDP';
							$KD_GUDANG = 'BBPK';
							break;
					}
					$ID = $data['ID'];
					$KD_DOK = $KD_ASAL_BRG;
					$KD_TPS = $KD_TPS;
					$KD_GUDANG = $KD_GUDANG;
					$NM_ANGKUT = trim($data['VESSEL']);
					if($KD_ASAL_BRG=='1'){
						$NO_VOY_FLIGHT = trim($data['VOYAGE_IN']);
						$TGL_TIBA = validate($data['REAL_VS_ARRIVAL'],'DATE');
					}else{
						$NO_VOY_FLIGHT = trim($data['VOYAGE_OUT']);
						$TGL_TIBA = validate($data['REAL_VS_ARRIVAL'],'DATE');
					}
					$CALL_SIGN = trim($data['CALL_SIGN']);
					$NO_BC11 = trim($data['NO_BC11']);
					$TGL_BC11 = validate($data['TGL_BC11'],'DATE');
					$GETID = $this->get_data('t_repohdr',array($KD_DOK,$KD_GUDANG,$NM_ANGKUT,$NO_VOY_FLIGHT,$CALL_SIGN,$TGL_TIBA));
					$next = false;
					if($GETID == ""){
						$array_hdr = array('KD_ASAL_BRG' => $KD_DOK,
										   'URAIAN_DOKUMEN' => $URAIAN_DOKUMEN,
										   'KD_TPS' => $KD_TPS,
										   'NM_ANGKUT' => $NM_ANGKUT,
										   'NO_VOY_FLIGHT' => $NO_VOY_FLIGHT,
										   'CALL_SIGN' => $CALL_SIGN,
										   'TGL_TIBA' => $TGL_TIBA,
										   'KD_GUDANG' => $KD_GUDANG,
										   'NO_BC11' => $NO_BC11,
										   'TGL_BC11' => $TGL_BC11,
										   'WK_REKAM' => date('Y-m-d H:i:s'));//print_r($array_hdr);die();
						$wms_db->insert('t_repohdr',$array_hdr);//echo $wms_db->last_query();die();
						$NEW_ID = $wms_db->insert_id();
						if($NEW_ID == 0){
							$next = false;
						}else{
							$next = true;
						}
					}else{
						$array_hdr = array('KD_ASAL_BRG' => $KD_DOK,
										   'URAIAN_DOKUMEN' => $URAIAN_DOKUMEN,
										   'KD_TPS' => $KD_TPS,
										   'NM_ANGKUT' => $NM_ANGKUT,
										   'NO_VOY_FLIGHT' => $NO_VOY_FLIGHT,
										   'CALL_SIGN' => $CALL_SIGN,
										   'TGL_TIBA' => $TGL_TIBA,
										   'KD_GUDANG' => $KD_GUDANG,
										   'NO_BC11' => $NO_BC11,
										   'TGL_BC11' => $TGL_BC11,
										   'WK_REKAM' => date('Y-m-d H:i:s'));//print_r($array_hdr);die();
						$wms_db->where(array('ID' => $GETID));
						$ex = $wms_db->update('t_repohdr',$array_hdr);//echo $wms_db->last_query();die();
						$NEW_ID = $GETID;
						$next = true;
					}
					if($next){
						if($KD_ASAL_BRG=='1'){
							list($COUNT, $ID_CONT, $NO_CONT) = $this->get_data('t_repocont',array($NEW_ID,$data['NO_CONTAINER']));//echo"sini";die();
							$KD_ORG_CONSIGNEE  = $this->get_data('organisasi',array($data['ID_CONSIGNEE'],$data['CONSIGNEE']));//print_r($KD_ORG_CONSIGNEE);die();
							switch ($data['STATUS']) {
								case "Empty": // COARRI DISCHARGE
									$JNS_CONT = 'E';
									break;
								case "Full": // COARRI LOADING
									$JNS_CONT = 'F';
									break;
							}
							$array_cont = array('ID' => $NEW_ID,
												'NO_CONT' => $data['NO_CONTAINER'],
												'KD_CONT_UKURAN' => $data['UK_CONT'],
												'KD_CONT_JENIS' => $JNS_CONT, 
												'FL_CONT_KOSONG' => $data['FL_CONT_KOSONG'], 
												'KD_ISO_CODE' => $data['ISO_CODE'], 
												'NO_SEGEL' => $data['NO_SEGEL'], 
												'NO_BL_AWB' => $data['NO_BL_AWB'], 
												'TGL_BL_AWB' => validate($data['TGL_BL_AWB'],'DATE'), 
												'NO_MASTER_BL_AWB' => $data['NO_MASTER_BL_AWB'], 
												'TGL_MASTER_BL_AWB' => validate($data['TGL_MASTER_BL_AWB'],'DATE'), 
												'KD_ORG_CONSIGNEE' => $KD_ORG_CONSIGNEE, 
												'BRUTO' => $data['BERAT'], 
												'NO_POS_BC11' => $data['NO_POS_BC11'], 
												'KD_TIMBUN' => $data['LOKASI_BP'],
												'NO_POL_IN' => $data['NO_POL_IN'], 
												'KD_DOK_IN' => $data['KD_DOK_IN'], 
												'NO_DOK_IN' => $data['NO_DOK_IN'], 
												'TGL_DOK_IN' => validate($data['TGL_DOK_IN'],'DATE'), 
												'WK_IN' => validate($data['DISCHARGE_CONFIRM'],'DATETIME'), 
												'KD_PEL_MUAT' => $data['POL'], 
												'KD_PEL_TRANSIT' => $data['PEL_TRANSIT'], 
												'KD_PEL_BONGKAR' => $data['POD'],
												/*'KD_SAR_ANGKUT_OUT' => $data['KD_SAR_ANGKUT_OUT'], 
												'NO_POL_OUT' => $data['NO_POL_OUT'], 
												'KD_DOK_OUT' => $data['KD_DOK_OUT'], 
												'NO_DOK_OUT' => $data['NO_DOK_OUT'], 
												'TGL_DOK_OUT' => $data['TGL_DOK_OUT'], 
												'WK_OUT' => $data['WK_OUT'], 
												'NO_SEGEL_BC' => $data['NO_SEGEL_BC'], 
												'TGL_SEGEL_BC' => $data['TGL_SEGEL_BC'], 
												'NO_IJIN_TPS' => $data['NO_IJIN_TPS'], 
												'TGL_IJIN_TPS' => $data['TGL_IJIN_TPS'], 
												'NO_DAFTAR_PABEAN' => $data['NO_DAFTAR_PABEAN'], 
												'TGL_DAFTAR_PABEAN' => $data['TGL_DAFTAR_PABEAN'], */
												'WK_REKAM' => date('Y-m-d H:i:s'));
						}else{
							list($COUNT, $ID_CONT, $NO_CONT) = $this->get_data('t_repocont',array($NEW_ID,$data['NO_CONTAINER']));//echo"sini";die();
							$KD_ORG_CONSIGNEE  = $this->get_data('organisasi',array($data['ID_CONSIGNEE'],$data['CONSIGNEE']));//print_r($KD_ORG_CONSIGNEE);die();
							switch ($data['STATUS']) {
								case "Empty": 
									$JNS_CONT = 'E';
									break;
								case "Full": 
									$JNS_CONT = 'F';
									break;
							}
							$array_cont = array('ID' => $NEW_ID,
												'NO_CONT' => $data['NO_CONTAINER'],
												'KD_CONT_UKURAN' => $data['UK_CONT'],
												'KD_CONT_JENIS' => $JNS_CONT, 
												'FL_CONT_KOSONG' => $data['FL_CONT_KOSONG'], 
												'KD_ISO_CODE' => $data['ISO_CODE'], 
												'NO_SEGEL' => $data['NO_SEGEL'], 
												'NO_BL_AWB' => $data['NO_BL_AWB'], 
												'TGL_BL_AWB' => validate($data['TGL_BL_AWB'],'DATE'), 
												'NO_MASTER_BL_AWB' => $data['NO_MASTER_BL_AWB'], 
												'TGL_MASTER_BL_AWB' => validate($data['TGL_MASTER_BL_AWB'],'DATE'), 
												'KD_ORG_CONSIGNEE' => $KD_ORG_CONSIGNEE, 
												'BRUTO' => $data['BERAT'], 
												'NO_POS_BC11' => $data['NO_POS_BC11'], 
												'KD_TIMBUN' => $data['LOKASI_BP'],
												/*'NO_POL_IN' => $data['NO_POL_IN'], 
												'KD_DOK_IN' => $data['KD_DOK_IN'], 
												'NO_DOK_IN' => $data['NO_DOK_IN'], 
												'TGL_DOK_IN' => validate($data['TGL_DOK_IN'],'DATE'), 
												'WK_IN' => validate($data['DISCHARGE_CONFIRM'],'DATETIME'), */
												'KD_PEL_MUAT' => $data['POD'], 
												'KD_PEL_TRANSIT' => $data['PEL_TRANSIT'], 
												'KD_PEL_BONGKAR' => $data['POL'],
												//'KD_SAR_ANGKUT_OUT' => $data['KD_SAR_ANGKUT_OUT'], 
												'NO_POL_OUT' => $data['NO_POL_OUT'], 
												//'KD_DOK_OUT' => $data['KD_DOK_INOUT'], 
												//'NO_DOK_OUT' => $data['NO_DOK_INOUT'], 
												//'TGL_DOK_OUT' => validate($data['TGL_DOK_INOUT'],'DATE'), 
												'WK_OUT' => validate($data['LOADING_CONFIRM'],'DATETIME'), 
												'NO_SEGEL_BC' => $data['NO_SEGEL_BC'], 
												'TGL_SEGEL_BC' => validate($data['TGL_SEGEL_BC'],'DATE'), 
												//'NO_IJIN_TPS' => $data['NO_IJIN_TPS'], 
												//'TGL_IJIN_TPS' => validate($data['TGL_IJIN_TPS'],'DATE'), 
												'NO_DAFTAR_PABEAN' => $data['NO_DAFTAR_PABEAN'], 
												'TGL_DAFTAR_PABEAN' => validate($data['TGL_DAFTAR_PABEAN'],'DATE'), 
												'WK_REKAM' => date('Y-m-d H:i:s'));

						}
						
						if($COUNT > 0){
							unset($array_cont['ID']);
							unset($array_cont['NO_CONTAINER']);
							$wms_db->where(array('ID' => $ID_CONT, 'NO_CONT' => $NO_CONT));
							$ex = $wms_db->update('t_repocont',$array_cont);//echo $wms_db->last_query();die();
							echo "SUCCESS UPDATE, NO. CONT ".$NEW_ID." - ".$data['NO_CONTAINER']."<BR>";
						}else{
							$ex = $wms_db->insert('t_repocont',$array_cont);//echo $wms_db->last_query();die();
							echo "SUCCESS INSERT, NO. CONT ".$NEW_ID." - ".$data['NO_CONTAINER']."<BR>";
						}
						if($ex){//echo "sini";
							$SQL = "UPDATE IBIS.m_coarri SET FLAG_SEND_EDI = '100', FLAG_SEND_EDI_DATE = '".date('Ymdhis')."' WHERE NO_CONTAINER = '".$data['NO_CONTAINER']."'";
							ECHO $SQL;
							$this->db->query($SQL);
							//$this->db->where(array('NO_CONTAINER' => $data['NO_CONTAINER']));
							//$this->db->update("m_coarri",array('FLAG_SEND_EDI' => 'Y','FLAG_SEND_EDI_DATE' => date('Ymdhis')));echo $this->db->last_query();die();
						}	
					}
				}
				$wms_db->close();
				remove_file($filename);
			}else{
				echo "APPLICATION IS RUNNING"; exit();
			}
		}else{
			echo "NO RECORDS FOUND"; exit();
		}
	}
	
	function codeco_incont(){
		$SQL = "select * from IBIS.m_codeco A
				LEFT JOIN IBIS.m_cont_tps_document B ON a.no_container=b.no_container and b.point=a.point
				WHERE A.ID_TERMINAL='IDPLG' AND a.inout='I' AND a.e_i='E' AND A.FLAG_SEND_EDI IS NULL AND b.no_dok_inout IS NOT NULL AND ROWNUM <= 10";//echo $SQL;die();
		$exec = $this->db->query($SQL);//print_r($exec);die();
		if($exec->num_rows() > 0){
			//$filename = DIR_EXE.'codeco_cont.txt';
			//$check_file = check_file($filename);
			if(!$check_file){
				create_file($filename);
				$wms_db = $this->load->database('wms',TRUE);
				$array_data = $exec->result_array();//print_r($array_data);die();
				foreach($array_data as $data){
					switch ($data['INOUT']) {
						case "I": // CODECO GATEIN
							$KD_ASAL_BRG = '4';
							$URAIAN_DOKUMEN = 'CODECO GATEIN';
							break;
						/*case "O": // CODECO GATEOUT
							if(trim($data['E_I'])=='E'){
								$KD_ASAL_BRG = '3';
								$URAIAN_DOKUMEN = 'COARRI LOADING';
							}
							else{
								$KD_ASAL_BRG = '2';
								$URAIAN_DOKUMEN = 'CODECO GATEOUT';
							}*/
							break;
					}
					switch ($data['ID_TERMINAL']) {
						case "IDPLG": // COARRI DISCHARGE
							$KD_TPS = 'PLDP';
							$KD_GUDANG = 'BBPK';
							break;
					}
					$ID = $data['ID'];
					$KD_DOK = $KD_ASAL_BRG;
					$KD_TPS = $KD_TPS;
					$KD_GUDANG = $KD_GUDANG;
					$NM_ANGKUT = trim($data['VESSEL']);
					if($KD_ASAL_BRG=='2'){
						$NO_VOY_FLIGHT = trim($data['VOYAGE_IN']);
						$TGL_TIBA = validate($data['REAL_VS_ARRIVAL'],'DATE');
					}else{
						$NO_VOY_FLIGHT = trim($data['VOYAGE_OUT']);
						$TGL_TIBA = validate($data['EST_VS_ARRIVAL'],'DATE');
					}
					$CALL_SIGN = trim($data['CALL_SIGN']);
					$NO_BC11 = trim($data['NO_BC11']);
					$TGL_BC11 = validate($data['TGL_BC11'],'DATE');
					$GETID = $this->get_data('t_repohdr',array($KD_DOK,$KD_GUDANG,$NM_ANGKUT,$NO_VOY_FLIGHT,$CALL_SIGN,$TGL_TIBA));
					$next = false;
					if($GETID == ""){
						$array_hdr = array('KD_ASAL_BRG' => $KD_DOK,
										   'URAIAN_DOKUMEN' => $URAIAN_DOKUMEN,
										   'KD_TPS' => $KD_TPS,
										   'NM_ANGKUT' => $NM_ANGKUT,
										   'NO_VOY_FLIGHT' => $NO_VOY_FLIGHT,
										   'CALL_SIGN' => $CALL_SIGN,
										   'TGL_TIBA' => $TGL_TIBA,
										   'KD_GUDANG' => $KD_GUDANG,
										   'NO_BC11' => $NO_BC11,
										   'TGL_BC11' => $TGL_BC11,
										   'WK_REKAM' => date('Y-m-d H:i:s'));
						$wms_db->insert('t_repohdr',$array_hdr);//echo $wms_db->last_query();die();
						$NEW_ID = $wms_db->insert_id();
						if($NEW_ID == 0){
							$next = false;
						}else{
							$next = true;
						}
					}else{
						$array_hdr = array('KD_ASAL_BRG' => $KD_DOK,
										   'URAIAN_DOKUMEN' => $URAIAN_DOKUMEN,
										   'KD_TPS' => $KD_TPS,
										   'NM_ANGKUT' => $NM_ANGKUT,
										   'NO_VOY_FLIGHT' => $NO_VOY_FLIGHT,
										   'CALL_SIGN' => $CALL_SIGN,
										   'TGL_TIBA' => $TGL_TIBA,
										   'KD_GUDANG' => $KD_GUDANG,
										   'NO_BC11' => $NO_BC11,
										   'TGL_BC11' => $TGL_BC11,
										   'WK_REKAM' => date('Y-m-d H:i:s'));
						$wms_db->where(array('ID' => $GETID));
						$ex = $wms_db->update('t_repohdr',$array_hdr);
						$NEW_ID = $GETID;
						$next = true;
					}
					if($next){
						if($KD_ASAL_BRG=='2'){
							list($COUNT, $ID_CONT, $NO_CONT) = $this->get_data('t_repocont',array($NEW_ID,$data['NO_CONTAINER']));//echo"sini";die();
							$KD_ORG_CONSIGNEE  = $this->get_data('organisasi',array($data['ID_CONSIGNEE'],$data['CONSIGNEE']));//print_r($KD_ORG_CONSIGNEE);die();
							switch ($data['STATUS']) {
								case "Empty": 
									$JNS_CONT = 'E';
									break;
								case "Full": 
									$JNS_CONT = 'F';
									break;
							}
							$array_cont = array('ID' => $NEW_ID,
												'NO_CONT' => $data['NO_CONTAINER'],
												'KD_CONT_UKURAN' => $data['UK_CONT'],
												'KD_CONT_JENIS' => $JNS_CONT, 
												'FL_CONT_KOSONG' => $data['FL_CONT_KOSONG'], 
												'KD_ISO_CODE' => $data['ISO_CODE'], 
												'NO_SEGEL' => $data['NO_SEGEL'], 
												'NO_BL_AWB' => $data['NO_BL_AWB'], 
												'TGL_BL_AWB' => validate($data['TGL_BL_AWB'],'DATE'), 
												'NO_MASTER_BL_AWB' => $data['NO_MASTER_BL_AWB'], 
												'TGL_MASTER_BL_AWB' => validate($data['TGL_MASTER_BL_AWB'],'DATE'), 
												'KD_ORG_CONSIGNEE' => $KD_ORG_CONSIGNEE, 
												'BRUTO' => $data['BERAT'], 
												'NO_POS_BC11' => $data['NO_POS_BC11'], 
												'KD_TIMBUN' => $data['LOKASI_BP'],
												/*'NO_POL_IN' => $data['NO_POL_IN'], 
												'KD_DOK_IN' => $data['KD_DOK_IN'], 
												'NO_DOK_IN' => $data['NO_DOK_IN'], 
												'TGL_DOK_IN' => validate($data['TGL_DOK_IN'],'DATE'), 
												'WK_IN' => validate($data['DISCHARGE_CONFIRM'],'DATETIME'), */
												'KD_PEL_MUAT' => $data['POL'], 
												'KD_PEL_TRANSIT' => $data['PEL_TRANSIT'], 
												'KD_PEL_BONGKAR' => $data['POD'],
												'NO_POL_OUT' => $data['NO_TRUCK'], 
												'KD_DOK_OUT' => $data['KD_DOK_INOUT'], 
												'NO_DOK_OUT' => $data['NO_DOK_INOUT'], 
												'TGL_DOK_OUT' => validate($data['TGL_DOK_INOUT'],'DATE'), 
												'WK_OUT' => validate($data['TGL_GATE_OUT'],'DATETIME'), 
												'NO_SEGEL_BC' => $data['NO_SEGEL_BC'], 
												'TGL_SEGEL_BC' => validate($data['TGL_SEGEL_BC'],'DATE'), 
												'NO_IJIN_TPS' => $data['NO_IJIN_TPS'], 
												'TGL_IJIN_TPS' => validate($data['TGL_IJIN_TPS'],'DATE'), 
												'NO_DAFTAR_PABEAN' => $data['NO_DAFTAR_PABEAN'], 
												'TGL_DAFTAR_PABEAN' => validate($data['TGL_DAFTAR_PABEAN'],'DATE'), 
												'WK_REKAM' => date('Y-m-d H:i:s'));
						}elseif($KD_ASAL_BRG=='4'){
							list($COUNT, $ID_CONT, $NO_CONT) = $this->get_data('t_repocont',array($NEW_ID,$data['NO_CONTAINER']));//echo"sini";die();
							$KD_ORG_CONSIGNEE  = $this->get_data('organisasi',array($data['ID_CONSIGNEE'],$data['CONSIGNEE']));//print_r($KD_ORG_CONSIGNEE);die();
							switch ($data['STATUS']) {
								case "Empty": 
									$JNS_CONT = 'E';
									break;
								case "Full": 
									$JNS_CONT = 'F';
									break;
							}
							$array_cont = array('ID' => $NEW_ID,
												'NO_CONT' => $data['NO_CONTAINER'],
												'KD_CONT_UKURAN' => $data['UK_CONT'],
												'KD_CONT_JENIS' => $JNS_CONT, 
												'FL_CONT_KOSONG' => $data['FL_CONT_KOSONG'], 
												'KD_ISO_CODE' => $data['ISO_CODE'], 
												'NO_SEGEL' => $data['NO_SEGEL'], 
												'NO_BL_AWB' => $data['NO_BL_AWB'], 
												'TGL_BL_AWB' => validate($data['TGL_BL_AWB'],'DATE'), 
												'NO_MASTER_BL_AWB' => $data['NO_MASTER_BL_AWB'], 
												'TGL_MASTER_BL_AWB' => validate($data['TGL_MASTER_BL_AWB'],'DATE'), 
												'KD_ORG_CONSIGNEE' => $KD_ORG_CONSIGNEE, 
												'BRUTO' => $data['BERAT'], 
												'NO_POS_BC11' => $data['NO_POS_BC11'], 
												'KD_TIMBUN' => $data['LOKASI_BP'],
												'NO_POL_IN' => $data['NO_TRUCK'], 
												'KD_DOK_IN' => $data['KD_DOK_INOUT'], 
												'NO_DOK_IN' => $data['NO_DOK_INOUT'], 
												'TGL_DOK_IN' => validate($data['TGL_DOK_INOUT'],'DATE'), 
												'WK_IN' => validate($data['TGL_GATE_IN'],'DATETIME'), 
												'KD_PEL_MUAT' => $data['POD'], 
												'KD_PEL_TRANSIT' => $data['PEL_TRANSIT'], 
												'KD_PEL_BONGKAR' => $data['POL'],
												/*'KD_SAR_ANGKUT_OUT' => $data['KD_SAR_ANGKUT_OUT'], 
												'NO_POL_OUT' => $data['NO_POL_OUT'], 
												'KD_DOK_OUT' => $data['KD_DOK_OUT'], 
												'NO_DOK_OUT' => $data['NO_DOK_OUT'], 
												'TGL_DOK_OUT' => $data['TGL_DOK_OUT'], 
												'WK_OUT' => $data['WK_OUT'], 
												'NO_SEGEL_BC' => $data['NO_SEGEL_BC'], 
												'TGL_SEGEL_BC' => $data['TGL_SEGEL_BC'], 
												'NO_IJIN_TPS' => $data['NO_IJIN_TPS'], 
												'TGL_IJIN_TPS' => $data['TGL_IJIN_TPS'], 
												'NO_DAFTAR_PABEAN' => $data['NO_DAFTAR_PABEAN'], 
												'TGL_DAFTAR_PABEAN' => $data['TGL_DAFTAR_PABEAN'], */
												'WK_REKAM' => date('Y-m-d H:i:s'));

						}else{
							list($COUNT, $ID_CONT, $NO_CONT) = $this->get_data('t_repocont',array($NEW_ID,$data['NO_CONTAINER']));//echo"sini";die();
							$KD_ORG_CONSIGNEE  = $this->get_data('organisasi',array($data['ID_CONSIGNEE'],$data['CONSIGNEE']));//print_r($KD_ORG_CONSIGNEE);die();
							switch ($data['STATUS']) {
								case "Empty": 
									$JNS_CONT = 'E';
									break;
								case "Full": 
									$JNS_CONT = 'F';
									break;
							}
							$array_cont = array('ID' => $NEW_ID,
												'NO_CONT' => $data['NO_CONTAINER'],
												'KD_CONT_UKURAN' => $data['UK_CONT'],
												'KD_CONT_JENIS' => $JNS_CONT, 
												'FL_CONT_KOSONG' => $data['FL_CONT_KOSONG'], 
												'KD_ISO_CODE' => $data['ISO_CODE'], 
												'NO_SEGEL' => $data['NO_SEGEL'], 
												'NO_BL_AWB' => $data['NO_BL_AWB'], 
												'TGL_BL_AWB' => validate($data['TGL_BL_AWB'],'DATE'), 
												'NO_MASTER_BL_AWB' => $data['NO_MASTER_BL_AWB'], 
												'TGL_MASTER_BL_AWB' => validate($data['TGL_MASTER_BL_AWB'],'DATE'), 
												'KD_ORG_CONSIGNEE' => $KD_ORG_CONSIGNEE, 
												'BRUTO' => $data['BERAT'], 
												'NO_POS_BC11' => $data['NO_POS_BC11'], 
												'KD_TIMBUN' => $data['LOKASI_BP'],
												/*'NO_POL_IN' => $data['NO_POL_IN'], 
												'KD_DOK_IN' => $data['KD_DOK_IN'], 
												'NO_DOK_IN' => $data['NO_DOK_IN'], 
												'TGL_DOK_IN' => validate($data['TGL_DOK_IN'],'DATE'), 
												'WK_IN' => validate($data['DISCHARGE_CONFIRM'],'DATETIME'), */
												'KD_PEL_MUAT' => $data['POD'], 
												'KD_PEL_TRANSIT' => $data['PEL_TRANSIT'], 
												'KD_PEL_BONGKAR' => $data['POL'],
												'NO_POL_OUT' => $data['NO_POL_OUT'], 
												'KD_DOK_OUT' => $data['KD_DOK_INOUT'], 
												'NO_DOK_OUT' => $data['NO_DOK_INOUT'], 
												'TGL_DOK_OUT' => validate($data['TGL_DOK_INOUT'],'DATE'), 
												'WK_OUT' => validate($data['TGL_GATE_OUT'],'DATETIME'), 
												'NO_SEGEL_BC' => $data['NO_SEGEL_BC'], 
												'TGL_SEGEL_BC' => validate($data['TGL_SEGEL_BC'],'DATE'), 
												'NO_IJIN_TPS' => $data['NO_IJIN_TPS'], 
												'TGL_IJIN_TPS' => validate($data['TGL_IJIN_TPS'],'DATE'), 
												'NO_DAFTAR_PABEAN' => $data['NO_DAFTAR_PABEAN'], 
												'TGL_DAFTAR_PABEAN' => validate($data['TGL_DAFTAR_PABEAN'],'DATE'), 
												'WK_REKAM' => date('Y-m-d H:i:s'));

						}
						if($COUNT > 0){
							unset($array_cont['ID']);
							unset($array_cont['NO_CONTAINER']);
							$wms_db->where(array('ID' => $ID_CONT, 'NO_CONT' => $NO_CONT));
							$ex = $wms_db->update('t_repocont',$array_cont);
							echo "SUCCESS UPDATE, NO. CONT ".$NEW_ID." - ".$data['NO_CONTAINER']."<BR>";
						}else{
							$ex = $wms_db->insert('t_repocont',$array_cont);//echo $wms_db->last_query();die();
							echo "SUCCESS INSERT, NO. CONT ".$NEW_ID." - ".$data['NO_CONTAINER']."<BR>";
						}
						if($ex){
							$SQL = "UPDATE IBIS.m_codeco SET FLAG_SEND_EDI = '200', FLAG_SEND_EDI_DATE = '".date('Ymdhis')."' WHERE NO_CONTAINER = '".$data['NO_CONTAINER']."'";
							ECHO $SQL;
							$this->db->query($SQL);
							//$this->db->where(array('ID' => $ID, 'NO_CONT' => $data['NO_CONT']));
							//$this->db->update('t_cocostscont',array('FL_WMS' => 'Y'));
						}	
					}
				}
				$wms_db->close();
				remove_file($filename);
			}else{
				echo "APPLICATION IS RUNNING"; exit();
			}
		}else{
			echo "NO RECORDS FOUND"; exit();
		}
	}
	
	function codeco_outcont(){
		$SQL = "select * from IBIS.m_codeco A
				LEFT JOIN IBIS.m_cont_tps_document B ON a.no_container=b.no_container and b.point=a.point
				WHERE A.ID_TERMINAL='IDPLG' AND a.e_i='I' AND b.no_bc11 IS NOT NULL AND A.FLAG_SEND_EDI IS NULL AND ROWNUM <= 10";//echo $SQL;die();
		$exec = $this->db->query($SQL);//print_r($exec);die();
		if($exec->num_rows() > 0){
			//$filename = DIR_EXE.'codeco_cont.txt';
			//$check_file = check_file($filename);
			if(!$check_file){
				create_file($filename);
				$wms_db = $this->load->database('wms',TRUE);
				$array_data = $exec->result_array();//print_r($array_data);die();
				foreach($array_data as $data){
					switch ($data['INOUT']) {
						/*case "I": // CODECO GATEIN
							$KD_ASAL_BRG = '4';
							$URAIAN_DOKUMEN = 'CODECO GATEIN';
							break;*/
						case "O": // CODECO GATEOUT
							if(trim($data['E_I'])=='I'){
								$KD_ASAL_BRG = '2';
								$URAIAN_DOKUMEN = 'CODECO GATEOUT';
							}
							break;
					}
					switch ($data['ID_TERMINAL']) {
						case "IDPLG": // COARRI DISCHARGE
							$KD_TPS = 'PLDP';
							$KD_GUDANG = 'BBPK';
							break;
					}
					$ID = $data['ID'];
					$KD_DOK = $KD_ASAL_BRG;
					$KD_TPS = $KD_TPS;
					$KD_GUDANG = $KD_GUDANG;
					$NM_ANGKUT = trim($data['VESSEL']);
					if($KD_ASAL_BRG=='2'){
						$NO_VOY_FLIGHT = trim($data['VOYAGE_IN']);
						$TGL_TIBA = validate($data['REAL_VS_ARRIVAL'],'DATE');
					}else{
						$NO_VOY_FLIGHT = trim($data['VOYAGE_OUT']);
						$TGL_TIBA = validate($data['EST_VS_ARRIVAL'],'DATE');
					}
					$CALL_SIGN = trim($data['CALL_SIGN']);
					$NO_BC11 = trim($data['NO_BC11']);
					$TGL_BC11 = validate($data['TGL_BC11'],'DATE');
					$GETID = $this->get_data('t_repohdr',array($KD_DOK,$KD_GUDANG,$NM_ANGKUT,$NO_VOY_FLIGHT,$CALL_SIGN,$TGL_TIBA));
					$next = false;
					if($GETID == ""){
						$array_hdr = array('KD_ASAL_BRG' => $KD_DOK,
										   'URAIAN_DOKUMEN' => $URAIAN_DOKUMEN,
										   'KD_TPS' => $KD_TPS,
										   'NM_ANGKUT' => $NM_ANGKUT,
										   'NO_VOY_FLIGHT' => $NO_VOY_FLIGHT,
										   'CALL_SIGN' => $CALL_SIGN,
										   'TGL_TIBA' => $TGL_TIBA,
										   'KD_GUDANG' => $KD_GUDANG,
										   'NO_BC11' => $NO_BC11,
										   'TGL_BC11' => $TGL_BC11,
										   'WK_REKAM' => date('Y-m-d H:i:s'));
						$wms_db->insert('t_repohdr',$array_hdr);//echo $wms_db->last_query();die();
						$NEW_ID = $wms_db->insert_id();
						if($NEW_ID == 0){
							$next = false;
						}else{
							$next = true;
						}
					}else{
						$array_hdr = array('KD_ASAL_BRG' => $KD_DOK,
										   'URAIAN_DOKUMEN' => $URAIAN_DOKUMEN,
										   'KD_TPS' => $KD_TPS,
										   'NM_ANGKUT' => $NM_ANGKUT,
										   'NO_VOY_FLIGHT' => $NO_VOY_FLIGHT,
										   'CALL_SIGN' => $CALL_SIGN,
										   'TGL_TIBA' => $TGL_TIBA,
										   'KD_GUDANG' => $KD_GUDANG,
										   'NO_BC11' => $NO_BC11,
										   'TGL_BC11' => $TGL_BC11,
										   'WK_REKAM' => date('Y-m-d H:i:s'));
						$wms_db->where(array('ID' => $GETID));
						$ex = $wms_db->update('t_repohdr',$array_hdr);
						$NEW_ID = $GETID;
						$next = true;
					}
					if($next){
						if($KD_ASAL_BRG=='2'){
							list($COUNT, $ID_CONT, $NO_CONT) = $this->get_data('t_repocont',array($NEW_ID,$data['NO_CONTAINER']));//echo"sini";die();
							$KD_ORG_CONSIGNEE  = $this->get_data('organisasi',array($data['ID_CONSIGNEE'],$data['CONSIGNEE']));//print_r($KD_ORG_CONSIGNEE);die();
							switch ($data['STATUS']) {
								case "Empty": 
									$JNS_CONT = 'E';
									break;
								case "Full": 
									$JNS_CONT = 'F';
									break;
							}
							$array_cont = array('ID' => $NEW_ID,
												'NO_CONT' => $data['NO_CONTAINER'],
												'KD_CONT_UKURAN' => $data['UK_CONT'],
												'KD_CONT_JENIS' => $JNS_CONT, 
												'FL_CONT_KOSONG' => $data['FL_CONT_KOSONG'], 
												'KD_ISO_CODE' => $data['ISO_CODE'], 
												'NO_SEGEL' => $data['NO_SEGEL'], 
												'NO_BL_AWB' => $data['NO_BL_AWB'], 
												'TGL_BL_AWB' => validate($data['TGL_BL_AWB'],'DATE'), 
												'NO_MASTER_BL_AWB' => $data['NO_MASTER_BL_AWB'], 
												'TGL_MASTER_BL_AWB' => validate($data['TGL_MASTER_BL_AWB'],'DATE'), 
												'KD_ORG_CONSIGNEE' => $KD_ORG_CONSIGNEE, 
												'BRUTO' => $data['BERAT'], 
												'NO_POS_BC11' => $data['NO_POS_BC11'], 
												'KD_TIMBUN' => $data['LOKASI_BP'],
												/*'NO_POL_IN' => $data['NO_POL_IN'], 
												'KD_DOK_IN' => $data['KD_DOK_IN'], 
												'NO_DOK_IN' => $data['NO_DOK_IN'], 
												'TGL_DOK_IN' => validate($data['TGL_DOK_IN'],'DATE'), 
												'WK_IN' => validate($data['DISCHARGE_CONFIRM'],'DATETIME'), */
												'KD_PEL_MUAT' => $data['POL'], 
												'KD_PEL_TRANSIT' => $data['PEL_TRANSIT'], 
												'KD_PEL_BONGKAR' => $data['POD'],
												'NO_POL_OUT' => $data['NO_TRUCK'], 
												'KD_DOK_OUT' => $data['KD_DOK_INOUT'], 
												'NO_DOK_OUT' => $data['NO_DOK_INOUT'], 
												'TGL_DOK_OUT' => validate($data['TGL_DOK_INOUT'],'DATE'), 
												'WK_OUT' => validate($data['TGL_GATE_OUT'],'DATETIME'), 
												'NO_SEGEL_BC' => $data['NO_SEGEL_BC'], 
												'TGL_SEGEL_BC' => validate($data['TGL_SEGEL_BC'],'DATE'), 
												'NO_IJIN_TPS' => $data['NO_IJIN_TPS'], 
												'TGL_IJIN_TPS' => validate($data['TGL_IJIN_TPS'],'DATE'), 
												'NO_DAFTAR_PABEAN' => $data['NO_DAFTAR_PABEAN'], 
												'TGL_DAFTAR_PABEAN' => validate($data['TGL_DAFTAR_PABEAN'],'DATE'), 
												'WK_REKAM' => date('Y-m-d H:i:s'));
						}elseif($KD_ASAL_BRG=='4'){
							list($COUNT, $ID_CONT, $NO_CONT) = $this->get_data('t_repocont',array($NEW_ID,$data['NO_CONTAINER']));//echo"sini";die();
							$KD_ORG_CONSIGNEE  = $this->get_data('organisasi',array($data['ID_CONSIGNEE'],$data['CONSIGNEE']));//print_r($KD_ORG_CONSIGNEE);die();
							switch ($data['STATUS']) {
								case "Empty": 
									$JNS_CONT = 'E';
									break;
								case "Full": 
									$JNS_CONT = 'F';
									break;
							}
							$array_cont = array('ID' => $NEW_ID,
												'NO_CONT' => $data['NO_CONTAINER'],
												'KD_CONT_UKURAN' => $data['UK_CONT'],
												'KD_CONT_JENIS' => $JNS_CONT, 
												'FL_CONT_KOSONG' => $data['FL_CONT_KOSONG'], 
												'KD_ISO_CODE' => $data['ISO_CODE'], 
												'NO_SEGEL' => $data['NO_SEGEL'], 
												'NO_BL_AWB' => $data['NO_BL_AWB'], 
												'TGL_BL_AWB' => validate($data['TGL_BL_AWB'],'DATE'), 
												'NO_MASTER_BL_AWB' => $data['NO_MASTER_BL_AWB'], 
												'TGL_MASTER_BL_AWB' => validate($data['TGL_MASTER_BL_AWB'],'DATE'), 
												'KD_ORG_CONSIGNEE' => $KD_ORG_CONSIGNEE, 
												'BRUTO' => $data['BERAT'], 
												'NO_POS_BC11' => $data['NO_POS_BC11'], 
												'KD_TIMBUN' => $data['LOKASI_BP'],
												'NO_POL_IN' => $data['NO_POL_IN'], 
												'KD_DOK_IN' => $data['KD_DOK_INOUT'], 
												'NO_DOK_IN' => $data['NO_DOK_INOUT'], 
												'TGL_DOK_IN' => validate($data['TGL_DOK_INOUT'],'DATE'), 
												'WK_IN' => validate($data['TGL_GATE_IN'],'DATETIME'), 
												'KD_PEL_MUAT' => $data['POD'], 
												'KD_PEL_TRANSIT' => $data['PEL_TRANSIT'], 
												'KD_PEL_BONGKAR' => $data['POL'],
												/*'KD_SAR_ANGKUT_OUT' => $data['KD_SAR_ANGKUT_OUT'], 
												'NO_POL_OUT' => $data['NO_POL_OUT'], 
												'KD_DOK_OUT' => $data['KD_DOK_OUT'], 
												'NO_DOK_OUT' => $data['NO_DOK_OUT'], 
												'TGL_DOK_OUT' => $data['TGL_DOK_OUT'], 
												'WK_OUT' => $data['WK_OUT'], 
												'NO_SEGEL_BC' => $data['NO_SEGEL_BC'], 
												'TGL_SEGEL_BC' => $data['TGL_SEGEL_BC'], 
												'NO_IJIN_TPS' => $data['NO_IJIN_TPS'], 
												'TGL_IJIN_TPS' => $data['TGL_IJIN_TPS'], 
												'NO_DAFTAR_PABEAN' => $data['NO_DAFTAR_PABEAN'], 
												'TGL_DAFTAR_PABEAN' => $data['TGL_DAFTAR_PABEAN'], */
												'WK_REKAM' => date('Y-m-d H:i:s'));

						}else{
							list($COUNT, $ID_CONT, $NO_CONT) = $this->get_data('t_repocont',array($NEW_ID,$data['NO_CONTAINER']));//echo"sini";die();
							$KD_ORG_CONSIGNEE  = $this->get_data('organisasi',array($data['ID_CONSIGNEE'],$data['CONSIGNEE']));//print_r($KD_ORG_CONSIGNEE);die();
							switch ($data['STATUS']) {
								case "Empty": 
									$JNS_CONT = 'E';
									break;
								case "Full": 
									$JNS_CONT = 'F';
									break;
							}
							$array_cont = array('ID' => $NEW_ID,
												'NO_CONT' => $data['NO_CONTAINER'],
												'KD_CONT_UKURAN' => $data['UK_CONT'],
												'KD_CONT_JENIS' => $JNS_CONT, 
												'FL_CONT_KOSONG' => $data['FL_CONT_KOSONG'], 
												'KD_ISO_CODE' => $data['ISO_CODE'], 
												'NO_SEGEL' => $data['NO_SEGEL'], 
												'NO_BL_AWB' => $data['NO_BL_AWB'], 
												'TGL_BL_AWB' => validate($data['TGL_BL_AWB'],'DATE'), 
												'NO_MASTER_BL_AWB' => $data['NO_MASTER_BL_AWB'], 
												'TGL_MASTER_BL_AWB' => validate($data['TGL_MASTER_BL_AWB'],'DATE'), 
												'KD_ORG_CONSIGNEE' => $KD_ORG_CONSIGNEE, 
												'BRUTO' => $data['BERAT'], 
												'NO_POS_BC11' => $data['NO_POS_BC11'], 
												'KD_TIMBUN' => $data['LOKASI_BP'],
												/*'NO_POL_IN' => $data['NO_POL_IN'], 
												'KD_DOK_IN' => $data['KD_DOK_IN'], 
												'NO_DOK_IN' => $data['NO_DOK_IN'], 
												'TGL_DOK_IN' => validate($data['TGL_DOK_IN'],'DATE'), 
												'WK_IN' => validate($data['DISCHARGE_CONFIRM'],'DATETIME'), */
												'KD_PEL_MUAT' => $data['POD'], 
												'KD_PEL_TRANSIT' => $data['PEL_TRANSIT'], 
												'KD_PEL_BONGKAR' => $data['POL'],
												'NO_POL_OUT' => $data['NO_POL_OUT'], 
												'KD_DOK_OUT' => $data['KD_DOK_INOUT'], 
												'NO_DOK_OUT' => $data['NO_DOK_INOUT'], 
												'TGL_DOK_OUT' => validate($data['TGL_DOK_INOUT'],'DATE'), 
												'WK_OUT' => validate($data['TGL_GATE_OUT'],'DATETIME'), 
												'NO_SEGEL_BC' => $data['NO_SEGEL_BC'], 
												'TGL_SEGEL_BC' => validate($data['TGL_SEGEL_BC'],'DATE'), 
												'NO_IJIN_TPS' => $data['NO_IJIN_TPS'], 
												'TGL_IJIN_TPS' => validate($data['TGL_IJIN_TPS'],'DATE'), 
												'NO_DAFTAR_PABEAN' => $data['NO_DAFTAR_PABEAN'], 
												'TGL_DAFTAR_PABEAN' => validate($data['TGL_DAFTAR_PABEAN'],'DATE'), 
												'WK_REKAM' => date('Y-m-d H:i:s'));

						}
						if($COUNT > 0){
							unset($array_cont['ID']);
							unset($array_cont['NO_CONTAINER']);
							$wms_db->where(array('ID' => $ID_CONT, 'NO_CONT' => $NO_CONT));
							$ex = $wms_db->update('t_repocont',$array_cont);
							echo "SUCCESS UPDATE, NO. CONT ".$NEW_ID." - ".$data['NO_CONTAINER']."<BR>";
						}else{
							$ex = $wms_db->insert('t_repocont',$array_cont);//echo $wms_db->last_query();die();
							echo "SUCCESS INSERT, NO. CONT ".$NEW_ID." - ".$data['NO_CONTAINER']."<BR>";
						}
						if($ex){
							$SQL = "UPDATE IBIS.m_codeco SET FLAG_SEND_EDI = '200', FLAG_SEND_EDI_DATE = '".date('Ymdhis')."' WHERE NO_CONTAINER = '".$data['NO_CONTAINER']."'";
							ECHO $SQL;
							$this->db->query($SQL);
							//$this->db->where(array('ID' => $ID, 'NO_CONT' => $data['NO_CONT']));
							//$this->db->update('t_cocostscont',array('FL_WMS' => 'Y'));
						}	
					}
				}
				$wms_db->close();
				remove_file($filename);
			}else{
				echo "APPLICATION IS RUNNING"; exit();
			}
		}else{
			echo "NO RECORDS FOUND"; exit();
		}
	}
	
	function codeco_kms(){
		$SQL = "SELECT A.ID, A.KD_DOK, A.KD_TPS, A.NM_ANGKUT, A.NO_VOY_FLIGHT, A.CALL_SIGN, A.TGL_TIBA, A.KD_GUDANG,
				B.NO_BL_AWB, B.TGL_BL_AWB, B.NO_MASTER_BL_AWB, B.TGL_MASTER_BL_AWB, B.ID_CONSIGNEE, B.CONSIGNEE, B.BRUTO, B.NO_BC11, 
				B.TGL_BC11, B.NO_POS_BC11, B.CONT_ASAL, B.SERI_KEMAS, B.KD_KEMAS, B.JML_KEMAS, B.KD_TIMBUN, B.KD_DOK_IN, B.NO_DOK_IN, 
				B.TGL_DOK_IN, B.WK_IN, B.KD_SAR_ANGKUT_IN, B.NO_POL_IN, B.KD_DOK_OUT, B.NO_DOK_OUT, B.TGL_DOK_OUT, B.WK_OUT, B.KD_SAR_ANGKUT_OUT,
				B.NO_POL_OUT, B.FL_CONT_KOSONG, B.ISO_CODE, B.PEL_MUAT, B.PEL_TRANSIT, B.PEL_BONGKAR, B.GUDANG_TUJUAN, B.KODE_KANTOR_IN, 
				B.NO_DAFTAR_PABEAN_IN, B.TGL_DAFTAR_PABEAN_IN, B.NO_SEGEL_BC_IN, B.TGL_SEGEL_BC_IN, B.NO_IJIN_TPS_IN, B.TGL_IJIN_TPS_IN, 
				B.FLAG, B.REF_NUMBER, B.KODE_KANTOR_OUT, B.NO_DAFTAR_PABEAN_OUT, B.TGL_DAFTAR_PABEAN_OUT, B.NO_SEGEL_BC_OUT, B.TGL_SEGEL_BC_OUT,
				B.NO_IJIN_TPS_OUT, B.TGL_IJIN_TPS_OUT, B.WK_INSERT
				FROM cocostshdr A
				INNER JOIN cocostskms B ON B.ID=A.ID
				WHERE A.KD_DOK = '5'
				AND (B.WK_IN IS NOT NULL OR B.WK_IN <> '')
				AND B.WK_IN <> '0000-00-00 00:00:00'
				AND B.FL_WMS = 'N'
				ORDER BY B.WK_IN ASC LIMIT 20";
		$exec = $this->db->query($SQL);
		if($exec->num_rows() > 0){
			$filename = DIR_EXE.'codeco_kms.txt';
			$check_file = check_file($filename);
			if(!$check_file){
				#create_file($filename);
				$wms_db = $this->load->database('wms',TRUE);
				$array_data = $exec->result_array();
				foreach($array_data as $data){
					$ID = $data['ID'];
					$KD_DOK = $data['KD_DOK'];
					$KD_TPS = $data['KD_TPS'];
					$KD_GUDANG = $data['KD_GUDANG'];
					$NM_ANGKUT = trim($data['NM_ANGKUT']);
					$NO_VOY_FLIGHT = trim($data['NO_VOY_FLIGHT']);
					$CALL_SIGN = trim($data['CALL_SIGN']);
					$TGL_TIBA = trim($data['TGL_TIBA']);
					$GETID = $this->get_data('t_cocostshdr',array($KD_TPS,$KD_GUDANG,$NM_ANGKUT,$NO_VOY_FLIGHT,$CALL_SIGN,$TGL_TIBA));
					$next = false;
					if($GETID == ""){
						$array_hdr = array('KD_DOK' => $KD_DOK,
										   'KD_TPS' => $KD_TPS,
										   'NM_ANGKUT' => $NM_ANGKUT,
										   'NO_VOY_FLIGHT' => $NO_VOY_FLIGHT,
										   'CALL_SIGN' => $CALL_SIGN,
										   'TGL_TIBA' => $TGL_TIBA,
										   'KD_GUDANG' => $KD_GUDANG,
										   'TGL_REKAM' => date('Y-m-d H:i:s'));
						$wms_db->insert('t_cocostshdr',$array_hdr);
						$NEW_ID = $wms_db->insert_id();
						$next = true;
					}else{
						$NEW_ID = $GETID;
						$next = true;
					}
					if($next){
						list($COUNT, $ID_KMS, $NO_BL_AWB) = $this->get_data('cocostskms',array($NEW_ID,$data['NO_BL_AWB']));
						$array_kms = array('ID' => $NEW_ID,
										   'SERI_KEMAS' => $this->set_seri('cocostskms',$NEW_ID),
										   'KD_KEMAS' => $data['KD_KEMAS'],
										   'JML_KEMAS' => $data['JML_KEMAS'], 
										   'CONT_ASAL' => $data['CONT_ASAL'],
										   'NO_BL_AWB' => $data['NO_BL_AWB'],
										   'TGL_BL_AWB' => $data['TGL_BL_AWB'],
										   'NO_MASTER_BL_AWB' => $data['NO_MASTER_BL_AWB'],
										   'TGL_MASTER_BL_AWB' => $data['TGL_MASTER_BL_AWB'],
										   'ID_CONSIGNEE' => $data['ID_CONSIGNEE'],
										   'CONSIGNEE' => $data['CONSIGNEE'],
										   'BRUTO' => $data['BRUTO'],
										   'NO_BC11' => $data['NO_BC11'],
										   'TGL_BC11' => $data['TGL_BC11'],
										   'NO_POS_BC11' => $data['NO_POS_BC11'],
										   'KD_TIMBUN' => $data['KD_TIMBUN'],
										   'KD_SAR_ANGKUT_IN' => $data['KD_SAR_ANGKUT_IN'],
										   'NO_POL_IN' => $data['NO_POL_IN'],
										   'KD_DOK_IN' => $data['KD_DOK_IN'],
										   'NO_DOK_IN' => $data['NO_DOK_IN'],
										   'TGL_DOK_IN' => $data['TGL_DOK_IN'],
										   'WK_IN' => $data['WK_IN'],
										   'KD_SAR_ANGKUT_OUT' => $data['KD_SAR_ANGKUT_OUT'],
										   'NO_POL_OUT' => $data['NO_POL_OUT'],
										   'KD_DOK_OUT' => $data['KD_DOK_OUT'],
										   'NO_DOK_OUT' => $data['NO_DOK_OUT'],
										   'TGL_DOK_OUT' => $data['TGL_DOK_OUT'],
										   'WK_OUT' => $data['WK_OUT'],
										   'PEL_MUAT' => $data['PEL_MUAT'],
										   'PEL_TRANSIT' => $data['PEL_TRANSIT'],
										   'PEL_BONGKAR' => $data['PEL_BONGKAR'],
										   'GUDANG_TUJUAN' => $data['GUDANG_TUJUAN'],
										   'KODE_KANTOR_IN' => $data['KODE_KANTOR_IN'],
										   'NO_DAFTAR_PABEAN_IN' => $data['NO_DAFTAR_PABEAN_IN'],
										   'TGL_DAFTAR_PABEAN_IN' => $data['TGL_DAFTAR_PABEAN_IN'],
										   'NO_SEGEL_BC_IN' => $data['NO_SEGEL_BC_IN'],
										   'TGL_SEGEL_BC_IN' => $data['TGL_SEGEL_BC_IN'],
										   'NO_IJIN_TPS_IN' => $data['NO_IJIN_TPS_IN'],
										   'TGL_IJIN_TPS_IN' => $data['TGL_IJIN_TPS_IN'],
										   'KODE_KANTOR_OUT' => $data['KODE_KANTOR_OUT'],
										   'NO_DAFTAR_PABEAN_OUT' => $data['NO_DAFTAR_PABEAN_OUT'], 
										   'TGL_DAFTAR_PABEAN_OUT' => $data['TGL_DAFTAR_PABEAN_OUT'],
										   'NO_SEGEL_BC_OUT' => $data['NO_SEGEL_BC_OUT'],
										   'TGL_SEGEL_BC_OUT' => $data['TGL_SEGEL_BC_OUT'],
										   'NO_IJIN_TPS_OUT' => $data['NO_IJIN_TPS_OUT'],
										   'TGL_IJIN_TPS_OUT' => $data['TGL_IJIN_TPS_OUT'],
										   'TGL_REKAM' => date('Y-m-d H:i:s'));
						if($COUNT > 0){
							unset($array_kms['ID']);
							unset($array_kms['NO_BL_AWB']);
							$wms_db->where(array('ID' => $ID_KMS, 'NO_BL_AWB' => $NO_BL_AWB));
							$ex = $wms_db->update('cocostskms',$array_kms);
							echo "SUCCESS UPDATE, NO. BL/AWB ".$NEW_ID." - ".$data['NO_BL_AWB']."<BR>";
						}else{
							$ex = $wms_db->insert('cocostskms',$array_kms);
							echo "SUCCESS INSERT, NO. BL/AWB ".$NEW_ID." - ".$data['NO_BL_AWB']."<BR>";
						}
						if($ex){
							$this->db->where(array('ID' => $ID, 'NO_BL_AWB' => $data['NO_BL_AWB']));
							$this->db->update('cocostskms',array('FL_WMS' => 'Y'));
						}	
					}
				}
				$wms_db->close();
				remove_file($filename);
			}else{
				echo "APPLICATION IS RUNNING"; exit();
			}
		}else{
			echo "NO RECORDS FOUND"; exit();
		}
	}
	
	function coarri_car(){
		$SQL = "SELECT A.*, B.*, TO_CHAR(A.WK_INOUT,'YYYY-MM-DD HH24:MM:SS') AS WK_IN FROM cococarter A 
				LEFT JOIN cocohdr B ON A.ID=B.ID WHERE b.kd_dok='1' AND  a.flag_mg IS NULL AND to_char(a.received_date, 'YYYY') = '2018' AND ROWNUM <= 100";//echo $SQL;die();
		$exec = $this->db->query($SQL);
		if($exec->num_rows() > 0){
			//$filename = DIR_EXE.'codeco_cont.txt';
			//$check_file = check_file($filename);
			if(!$check_file){
				create_file($filename);
				$wms_db = $this->load->database('wms',TRUE);
				$array_data = $exec->result_array();//print_r($array_data);die();
				foreach($array_data as $data){
					
					$ID = $data['ID'];
					$KD_DOK = $data['KD_DOK'];
					$KD_TPS = $data['KD_TPS'];
					$KD_GUDANG = $data['KD_GUDANG'];
					$NM_ANGKUT = trim($data['NM_ANGKUT']);
					$NO_VOY_FLIGHT = trim($data['NO_VOY_FLIGHT']);
					$TGL_TIBA = validate($data['TGL_TIBA'],'DATE');
					$CALL_SIGN = trim($data['CALL_SIGN']);
					$NO_BC11 = trim($data['NO_BC11']);
					$TGL_BC11 = validate($data['TGL_BC11'],'DATE');
					$GETID = $this->get_data('t_cocostshdr',array($KD_DOK,$KD_GUDANG,$NM_ANGKUT,$NO_VOY_FLIGHT,$CALL_SIGN,$TGL_TIBA));//PRINT_R($GETID);die();
					$KD_KAPAL  = $this->get_data('kapal',array($data['NM_ANGKUT'],$data['CALL_SIGN']));
					$next = false;
					if($GETID == ""){
						$array_hdr = array('KD_ASAL_BRG' => $KD_DOK,
										   'KD_TPS' => $KD_TPS,
										   'KD_KAPAL' => $KD_KAPAL,
										   'NM_ANGKUT' => $NM_ANGKUT,
										   'NO_VOY_FLIGHT' => $NO_VOY_FLIGHT,
										   'CALL_SIGN' => $CALL_SIGN,
										   'TGL_TIBA' => $TGL_TIBA,
										   'KD_GUDANG' => $KD_GUDANG,
										   'NO_BC11' => $NO_BC11,
										   'TGL_BC11' => $TGL_BC11,
										   'WK_REKAM' => date('Y-m-d H:i:s'));//print_r($array_hdr);die();
						$wms_db->insert('t_cocostshdr',$array_hdr);//echo $wms_db->last_query();die();
						$NEW_ID = $wms_db->insert_id();
						if($NEW_ID == 0){
							$next = false;
						}else{
							$next = true;
						}
					}else{
						$array_hdr = array('KD_ASAL_BRG' => $KD_DOK,
										   'KD_KAPAL' => $KD_KAPAL,
										   'KD_TPS' => $KD_TPS,
										   'NM_ANGKUT' => $NM_ANGKUT,
										   'NO_VOY_FLIGHT' => $NO_VOY_FLIGHT,
										   'CALL_SIGN' => $CALL_SIGN,
										   'TGL_TIBA' => $TGL_TIBA,
										   'KD_GUDANG' => $KD_GUDANG,
										   'NO_BC11' => $NO_BC11,
										   'TGL_BC11' => $TGL_BC11,
										   'WK_REKAM' => date('Y-m-d H:i:s'));//print_r($array_hdr);die();
						$wms_db->where(array('ID' => $GETID));
						$ex = $wms_db->update('t_cocostshdr',$array_hdr);//echo $wms_db->last_query();die();
						$NEW_ID = $GETID;
						$next = true;
					}
					if($next){
						if($KD_DOK=='1'){
							list($COUNT, $ID_VIN, $VIN_NUMBER) = $this->get_data('t_cocostscarter',array($NEW_ID,$data['VIN_NUMBER']));
							$KD_ORG_CONSIGNEE  = $this->get_data('organisasi',array($data['ID_CONSIGNEE'],$data['CONSIGNEE']));//print_r($KD_ORG_CONSIGNEE);die();
							$array_cont = array('ID' => $NEW_ID,
												'VIN_NUMBER' => $data['VIN_NUMBER'],
												'NO_RANGKA' => $data['NO_RANGKA'],
												'NO_MESIN' => $data['NO_MESIN'],
												'TIPE' => $data['TIPE'], 
												'WARNA' => $data['WARNA'], 
												'MERK' => $data['MERK'], 
												'BRUTO' => $data['BRUTO'], 
												'NO_BL_AWB' => $data['NO_BL_AWB'], 
												'TGL_BL_AWB' => validate($data['TGL_BL_AWB'],'DATE'), 
												'NO_MASTER_BL_AWB' => $data['NO_MASTER_BL_AWB'], 
												'TGL_MASTER_BL_AWB' => validate($data['TGL_MASTER_BL_AWB'],'DATE'), 
												'KD_ORG_CONSIGNEE' => $KD_ORG_CONSIGNEE,
												'NO_POS_BC11' => $data['NO_POS_BC11'], 
												'KD_TIMBUN' => $data['KD_TIMBUN'],
												'NO_POL_IN' => $data['NO_POL'], 
												'KD_DOK_IN' => $data['KD_DOK_IN'], 
												'NO_DOK_IN' => $data['NO_DOK_IN'], 
												'TGL_DOK_IN' => validate($data['TGL_DOK_IN'],'DATE'),
												'KD_SARANA_ANGKUT_IN' => $data['KD_SAR_ANGKUT_INOUT'], 												
												'WK_IN' => $data['WK_IN'], 
												'KD_PEL_MUAT' => $data['PEL_MUAT'], 
												'KD_PEL_TRANSIT' => $data['PEL_TRANSIT'], 
												'KD_PEL_BONGKAR' => $data['PEL_BONGKAR'],
												'REF_NUMBER_IN' => $data['REF_NUMBER'],
												/*
												'NO_POL_OUT' => $data['NO_POL_OUT'],
												'KD_DOK_OUT' => $data['KD_DOK_OUT'], 
												'NO_DOK_OUT' => $data['NO_DOK_OUT'], 
												'TGL_DOK_OUT' => $data['TGL_DOK_OUT'], 
												'WK_OUT' => $data['WK_OUT'], 
												'NO_SEGEL_BC' => $data['NO_SEGEL_BC'], 
												'TGL_SEGEL_BC' => $data['TGL_SEGEL_BC'], 
												'NO_IJIN_TPS' => $data['NO_IJIN_TPS'], 
												'TGL_IJIN_TPS' => $data['TGL_IJIN_TPS'], 
												'NO_DAFTAR_PABEAN' => $data['NO_DAFTAR_PABEAN'], 
												'TGL_DAFTAR_PABEAN' => $data['TGL_DAFTAR_PABEAN'], */
												'WK_REKAM' => date('Y-m-d H:i:s'));
						}else{
							list($COUNT, $ID_VIN, $VIN_NUMBER) = $this->get_data('t_cococarter',array($NEW_ID,$data['VIN_NUMBER']));//echo"sini";die();
							$KD_ORG_CONSIGNEE  = $this->get_data('organisasi',array($data['ID_CONSIGNEE'],$data['CONSIGNEE']));//print_r($KD_ORG_CONSIGNEE);die();
							
							$array_cont = array('ID' => $NEW_ID,
												'VIN_NUMBER' => $data['VIN_NUMBER'],
												'NO_RANGKA' => $data['NO_RANGKA'],
												'NO_MESIN' => $data['NO_MESIN'],
												'TIPE' => $data['TIPE'], 
												'WARNA' => $data['WARNA'], 
												'MERK' => $data['MERK'], 
												'BRUTO' => $data['BRUTO'], 
												'NO_BL_AWB' => $data['NO_BL_AWB'], 
												'TGL_BL_AWB' => validate($data['TGL_BL_AWB'],'DATE'), 
												'NO_MASTER_BL_AWB' => $data['NO_MASTER_BL_AWB'], 
												'TGL_MASTER_BL_AWB' => validate($data['TGL_MASTER_BL_AWB'],'DATE'), 
												'KD_ORG_CONSIGNEE' => $KD_ORG_CONSIGNEE, 
												'NO_POS_BC11' => $data['NO_POS_BC11'], 
												'KD_TIMBUN' => $data['LOKASI_BP'],
												/*'NO_POL_IN' => $data['NO_POL_IN'], 
												'KD_DOK_IN' => $data['KD_DOK_IN'], 
												'NO_DOK_IN' => $data['NO_DOK_IN'], 
												'TGL_DOK_IN' => validate($data['TGL_DOK_IN'],'DATE'), 
												'WK_IN' => validate($data['DISCHARGE_CONFIRM'],'DATETIME'), */
												'KD_PEL_MUAT' => $data['PEL_MUAT'], 
												'KD_PEL_TRANSIT' => $data['PEL_TRANSIT'], 
												'KD_PEL_BONGKAR' => $data['PEL_BONGKAR'],
												'KD_SARANA_ANGKUT_OUT' => $data['KD_SAR_ANGKUT_INOUT'], 
												'NO_POL_OUT' => $data['NO_POL'], 
												'KD_DOK_OUT' => $data['KD_DOK_INOUT'], 
												'NO_DOK_OUT' => $data['NO_DOK_INOUT'], 
												'TGL_DOK_OUT' => validate($data['TGL_DOK_INOUT'],'DATE'), 
												'WK_OUT' => validate($data['WK_INOUT'],'DATETIME'), 
												'NO_SEGEL_BC' => $data['NO_SEGEL_BC'], 
												'TGL_SEGEL_BC' => validate($data['TGL_SEGEL_BC'],'DATE'), 
												'NO_IJIN_TPS' => $data['NO_IJIN_TPS'], 
												'TGL_IJIN_TPS' => validate($data['TGL_IJIN_TPS'],'DATE'), 
												'NO_DAFTAR_PABEAN' => $data['NO_DAFTAR_PABEAN'], 
												'TGL_DAFTAR_PABEAN' => validate($data['TGL_DAFTAR_PABEAN'],'DATE'),
												'REF_NUMBER_OUT' => $data['REF_NUMBER'],
												'WK_REKAM' => date('Y-m-d H:i:s'));

						}
						
						if($COUNT > 0){
							unset($array_cont['ID']);
							unset($array_cont['VIN_NUMBER']);
							$wms_db->where(array('ID' => $ID_VIN, 'VIN_NUMBER' => $VIN_NUMBER));
							$ex = $wms_db->update('t_cocostscarter',$array_cont);//echo $wms_db->last_query();die();
							echo "SUCCESS UPDATE, NO. VIN ".$NEW_ID." - ".$data['VIN_NUMBER']."<BR>";
						}else{
							$ex = $wms_db->insert('t_cocostscarter',$array_cont);//echo $wms_db->last_query();die();
							echo "SUCCESS INSERT, NO. VIN ".$NEW_ID." - ".$data['VIN_NUMBER']."<BR>";
						}
						if($ex){//echo "sini";
							$SQL = "UPDATE cococarter SET FLAG_MG = '1' WHERE ID= '".$data['ID']."' AND VIN_NUMBER = '".$data['VIN_NUMBER']."'";
							//ECHO $SQL;
							$this->db->query($SQL);
							//$this->db->where(array('NO_CONTAINER' => $data['NO_CONTAINER']));
							//$this->db->update("m_coarri",array('FLAG_SEND_EDI' => 'Y','FLAG_SEND_EDI_DATE' => date('Ymdhis')));echo $this->db->last_query();die();
						}	
					}
				}
				$wms_db->close();
				remove_file($filename);
			}else{
				echo "APPLICATION IS RUNNING"; exit();
			}
		}else{
			echo "NO RECORDS FOUND"; exit();
		}
	}
	
	function coarri_carout(){
		$SQL = "SELECT A.*, B.*, TO_CHAR(A.WK_INOUT,'YYYY-MM-DD HH24:MM:SS') AS WK_IN FROM cococarter A 
				LEFT JOIN cocohdr B ON A.ID=B.ID WHERE b.kd_dok='3' AND  a.flag_mg IS NULL AND to_char(a.received_date, 'YYYY') = '2018' AND ROWNUM <= 100";//echo $SQL;die();
		$exec = $this->db->query($SQL);
		if($exec->num_rows() > 0){
			//$filename = DIR_EXE.'codeco_cont.txt';
			//$check_file = check_file($filename);
			if(!$check_file){
				create_file($filename);
				$wms_db = $this->load->database('wms',TRUE);
				$array_data = $exec->result_array();//print_r($array_data);die();
				foreach($array_data as $data){
					switch ($data['KD_DOK']) {
						case "3": // COARRI DISCHARGE
							$KD_ASAL_BRG = '1';
							break;
					}
					$ID = $data['ID'];
					$KD_DOK = $KD_ASAL_BRG;
					$KD_TPS = $data['KD_TPS'];
					$KD_GUDANG = $data['KD_GUDANG'];
					$NM_ANGKUT = trim($data['NM_ANGKUT']);
					$NO_VOY_FLIGHT = trim($data['NO_VOY_FLIGHT']);
					$TGL_TIBA = validate($data['TGL_TIBA'],'DATE');
					$CALL_SIGN = trim($data['CALL_SIGN']);
					$NO_BC11 = trim($data['NO_BC11']);
					$TGL_BC11 = validate($data['TGL_BC11'],'DATE');
					$GETID = $this->get_data('t_cocostshdr',array($KD_DOK,$KD_GUDANG,$NM_ANGKUT,$NO_VOY_FLIGHT,$CALL_SIGN,$TGL_TIBA));//PRINT_R($GETID);die();
					$KD_KAPAL  = $this->get_data('kapal',array($data['NM_ANGKUT'],$data['CALL_SIGN']));
					$next = false;
					if($GETID == ""){
						$array_hdr = array('KD_ASAL_BRG' => $KD_DOK,
										   'KD_TPS' => $KD_TPS,
										   'KD_KAPAL' => $KD_KAPAL,
										   'NM_ANGKUT' => $NM_ANGKUT,
										   'NO_VOY_FLIGHT' => $NO_VOY_FLIGHT,
										   'CALL_SIGN' => $CALL_SIGN,
										   'TGL_TIBA' => $TGL_TIBA,
										   'KD_GUDANG' => $KD_GUDANG,
										   'NO_BC11' => $NO_BC11,
										   'TGL_BC11' => $TGL_BC11,
										   'WK_REKAM' => date('Y-m-d H:i:s'));//print_r($array_hdr);die();
						$wms_db->insert('t_cocostshdr',$array_hdr);//echo $wms_db->last_query();die();
						$NEW_ID = $wms_db->insert_id();
						if($NEW_ID == 0){
							$next = false;
						}else{
							$next = true;
						}
					}else{
						$array_hdr = array('KD_ASAL_BRG' => $KD_DOK,
										   'KD_KAPAL' => $KD_KAPAL,
										   'KD_TPS' => $KD_TPS,
										   'NM_ANGKUT' => $NM_ANGKUT,
										   'NO_VOY_FLIGHT' => $NO_VOY_FLIGHT,
										   'CALL_SIGN' => $CALL_SIGN,
										   'TGL_TIBA' => $TGL_TIBA,
										   'KD_GUDANG' => $KD_GUDANG,
										   'NO_BC11' => $NO_BC11,
										   'TGL_BC11' => $TGL_BC11,
										   'WK_REKAM' => date('Y-m-d H:i:s'));//print_r($array_hdr);die();
						$wms_db->where(array('ID' => $GETID));
						$ex = $wms_db->update('t_cocostshdr',$array_hdr);//echo $wms_db->last_query();die();
						$NEW_ID = $GETID;
						$next = true;
					}
					if($next){
						if($KD_DOK=='1'){
							list($COUNT, $ID_VIN, $VIN_NUMBER) = $this->get_data('t_cocostscarter',array($NEW_ID,$data['VIN_NUMBER']));
							$KD_ORG_CONSIGNEE  = $this->get_data('organisasi',array($data['ID_CONSIGNEE'],$data['CONSIGNEE']));//print_r($KD_ORG_CONSIGNEE);die();
							$array_cont = array('ID' => $NEW_ID,
												'VIN_NUMBER' => $data['VIN_NUMBER'],
												'NO_RANGKA' => $data['NO_RANGKA'],
												'NO_MESIN' => $data['NO_MESIN'],
												'TIPE' => $data['TIPE'], 
												'WARNA' => $data['WARNA'], 
												'MERK' => $data['MERK'], 
												'BRUTO' => $data['BRUTO'], 
												'NO_BL_AWB' => $data['NO_BL_AWB'], 
												'TGL_BL_AWB' => validate($data['TGL_BL_AWB'],'DATE'), 
												'NO_MASTER_BL_AWB' => $data['NO_MASTER_BL_AWB'], 
												'TGL_MASTER_BL_AWB' => validate($data['TGL_MASTER_BL_AWB'],'DATE'), 
												'KD_ORG_CONSIGNEE' => $KD_ORG_CONSIGNEE, 
												'NO_POS_BC11' => $data['NO_POS_BC11'], 
												'KD_TIMBUN' => $data['KD_TIMBUN'],
												/*'NO_POL_IN' => $data['NO_POL_IN'], 
												'KD_DOK_IN' => $data['KD_DOK_IN'], 
												'NO_DOK_IN' => $data['NO_DOK_IN'], 
												'TGL_DOK_IN' => validate($data['TGL_DOK_IN'],'DATE'), 
												'WK_IN' => validate($data['DISCHARGE_CONFIRM'],'DATETIME'), */
												'KD_PEL_MUAT' => $data['PEL_MUAT'], 
												'KD_PEL_TRANSIT' => $data['PEL_TRANSIT'], 
												'KD_PEL_BONGKAR' => $data['PEL_BONGKAR'],
												'KD_SARANA_ANGKUT_OUT' => $data['KD_SAR_ANGKUT_INOUT'], 
												'NO_POL_OUT' => $data['NO_POL'], 
												'KD_DOK_OUT' => $data['KD_DOK_INOUT'], 
												'NO_DOK_OUT' => $data['NO_DOK_INOUT'], 
												'TGL_DOK_OUT' => validate($data['TGL_DOK_INOUT'],'DATE'), 
												'WK_OUT' => validate($data['WK_IN'],'DATETIME'), 
												'NO_SEGEL_BC' => $data['NO_SEGEL_BC'], 
												'TGL_SEGEL_BC' => validate($data['TGL_SEGEL_BC'],'DATE'), 
												'NO_IJIN_TPS' => $data['NO_IJIN_TPS'], 
												'TGL_IJIN_TPS' => validate($data['TGL_IJIN_TPS'],'DATE'), 
												'NO_DAFTAR_PABEAN' => $data['NO_DAFTAR_PABEAN'], 
												'TGL_DAFTAR_PABEAN' => validate($data['TGL_DAFTAR_PABEAN'],'DATE'),
												'REF_NUMBER_OUT' => $data['REF_NUMBER'],
												'WK_REKAM' => date('Y-m-d H:i:s'));
						}
						
						if($COUNT > 0){
							unset($array_cont['ID']);
							unset($array_cont['VIN_NUMBER']);
							$wms_db->where(array('ID' => $ID_VIN, 'VIN_NUMBER' => $VIN_NUMBER));
							$ex = $wms_db->update('t_cocostscarter',$array_cont);//echo $wms_db->last_query();die();
							echo "SUCCESS UPDATE, NO. VIN ".$NEW_ID." - ".$data['VIN_NUMBER']."<BR>";
						}else{
							$ex = $wms_db->insert('t_cocostscarter',$array_cont);//echo $wms_db->last_query();die();
							echo "SUCCESS INSERT, NO. VIN ".$NEW_ID." - ".$data['VIN_NUMBER']."<BR>";
						}
						if($ex){//echo "sini";
							$SQL = "UPDATE cococarter SET FLAG_MG = '1' WHERE ID= '".$data['ID']."' AND VIN_NUMBER = '".$data['VIN_NUMBER']."'";
							//ECHO $SQL;
							$this->db->query($SQL);
							//$this->db->where(array('NO_CONTAINER' => $data['NO_CONTAINER']));
							//$this->db->update("m_coarri",array('FLAG_SEND_EDI' => 'Y','FLAG_SEND_EDI_DATE' => date('Ymdhis')));echo $this->db->last_query();die();
						}	
					}
				}
				$wms_db->close();
				remove_file($filename);
			}else{
				echo "APPLICATION IS RUNNING"; exit();
			}
		}else{
			echo "NO RECORDS FOUND"; exit();
		}
	}	
	
	function coarri_carkms(){
		$SQL = "SELECT A.*, B.*, TO_CHAR(A.WK_INOUT,'YYYY-MM-DD HH24:MM:SS') AS WK_IN FROM cocokms A 
				LEFT JOIN cocohdr B ON A.ID=B.ID 
        WHERE b.kd_dok='1' AND  a.flag_mg IS NULL AND to_char(a.received_date, 'YYYY') = '2018' and b.kd_tps='CART' AND ROWNUM <= 100";
		$exec = $this->db->query($SQL);
		if($exec->num_rows() > 0){
			//$filename = DIR_EXE.'codeco_kms.txt';
			//$check_file = check_file($filename);
			if(!$check_file){
				#create_file($filename);
				$wms_db = $this->load->database('wms',TRUE);
				$array_data = $exec->result_array();//print_r($array_data);die();
				foreach($array_data as $data){
					$ID = $data['ID'];
					$KD_DOK = $data['KD_DOK'];
					$KD_TPS = $data['KD_TPS'];
					$KD_GUDANG = $data['KD_GUDANG'];
					$NM_ANGKUT = trim($data['NM_ANGKUT']);
					$NO_VOY_FLIGHT = trim($data['NO_VOY_FLIGHT']);
					$TGL_TIBA = validate($data['TGL_TIBA'],'DATE');
					$CALL_SIGN = trim($data['CALL_SIGN']);
					$NO_BC11 = trim($data['NO_BC11']);
					$TGL_BC11 = validate($data['TGL_BC11'],'DATE');
					$GETID = $this->get_data('t_cocostshdr',array($KD_DOK,$KD_GUDANG,$NM_ANGKUT,$NO_VOY_FLIGHT,$CALL_SIGN,$TGL_TIBA));
					$KD_KAPAL  = $this->get_data('kapal',array($data['NM_ANGKUT'],$data['CALL_SIGN']));
					$next = false;
					if($GETID == ""){
						$array_hdr = array('KD_ASAL_BRG' => $KD_DOK,
										   'KD_TPS' => $KD_TPS,
										   'KD_KAPAL' => $KD_KAPAL,
										   'NM_ANGKUT' => $NM_ANGKUT,
										   'NO_VOY_FLIGHT' => $NO_VOY_FLIGHT,
										   'CALL_SIGN' => $CALL_SIGN,
										   'TGL_TIBA' => $TGL_TIBA,
										   'KD_GUDANG' => $KD_GUDANG,
										   'NO_BC11' => $NO_BC11,
										   'TGL_BC11' => $TGL_BC11,
										   'WK_REKAM' => date('Y-m-d H:i:s'));//print_r($array_hdr);die();
						$wms_db->insert('t_cocostshdr',$array_hdr);
						$NEW_ID = $wms_db->insert_id();
						$next = true;
					}else{
						$array_hdr = array('KD_ASAL_BRG' => $KD_DOK,
										   'KD_KAPAL' => $KD_KAPAL,
										   'KD_TPS' => $KD_TPS,
										   'NM_ANGKUT' => $NM_ANGKUT,
										   'NO_VOY_FLIGHT' => $NO_VOY_FLIGHT,
										   'CALL_SIGN' => $CALL_SIGN,
										   'TGL_TIBA' => $TGL_TIBA,
										   'KD_GUDANG' => $KD_GUDANG,
										   'NO_BC11' => $NO_BC11,
										   'TGL_BC11' => $TGL_BC11,
										   'WK_REKAM' => date('Y-m-d H:i:s'));//print_r($array_hdr);die();
						$wms_db->where(array('ID' => $GETID));
						$ex = $wms_db->update('t_cocostshdr',$array_hdr);//echo $wms_db->last_query();die();
						$NEW_ID = $GETID;
						$next = true;
					}
					if($next){
						//list($COUNT, $ID_KMS, $NO_BL_AWB) = $this->get_data('t_cocokms',array($NEW_ID,$data['NO_BL_AWB']));
						$array_kms = array('ID' => $NEW_ID,
										   'SERI_KEMAS' => $data['SERI_KEMAS'],
										   'KD_KEMAS' => $data['KD_KEMAS'],
										   'JML_KEMAS' => $data['JML_KEMAS'],
										   'KD_DOK' => $data['KD_DOK'],
										   'NO_BL_AWB' => $data['NO_BL_AWB'],
										   'TGL_BL_AWB' => validate($data['TGL_BL_AWB'],'DATE'),
										   'NO_MASTER_BL_AWB' => $data['NO_MASTER_BL_AWB'],
										   'TGL_MASTER_BL_AWB' => validate($data['TGL_MASTER_BL_AWB'],'DATE'),
										   'ID_CONSIGNEE' => $data['ID_CONSIGNEE'],
										   'CONSIGNEE' => $data['CONSIGNEE'],
										   'BRUTO' => $data['BRUTO'],
										   'NO_BC11' => $data['NO_BC11'],
										   'TGL_BC11' => validate($data['TGL_BC11'],'DATE'),
										   'NO_POS_BC11' => $data['NO_POS_BC11'],
										   'KD_TIMBUN' => $data['KD_TIMBUN'],
										   'KD_SAR_ANGKUT_INOUT' => $data['KD_SAR_ANGKUT_INOUT'],
										   'NO_POL' => $data['NO_POL'],
										   'KD_DOK_INOUT' => $data['KD_DOK_INOUT'],
										   'NO_DOK_INOUT' => $data['NO_DOK_INOUT'],
										   'TGL_DOK_INOUT' => validate($data['TGL_DOK_INOUT'],'DATE'),
										   'WK_INOUT' => $data['WK_IN'],
										   'PEL_MUAT' => $data['PEL_MUAT'],
										   'PEL_TRANSIT' => $data['PEL_TRANSIT'],
										   'PEL_BONGKAR' => $data['PEL_BONGKAR'],
										   'GUDANG_TUJUAN' => $data['GUDANG_TUJUAN'],
										   'KODE_KANTOR' => $data['KODE_KANTOR'],
										   'NO_DAFTAR_PABEAN' => $data['NO_DAFTAR_PABEAN'],
										   'TGL_DAFTAR_PABEAN' => validate($data['TGL_DAFTAR_PABEAN'],'DATE'),
										   'NO_SEGEL_BC' => $data['NO_SEGEL_BC'],
										   'TGL_SEGEL_BC' => validate($data['TGL_SEGEL_BC'],'DATE'),
										   'NO_IJIN_TPS' => $data['NO_IJIN_TPS'],
										   'TGL_IJIN_TPS' => validate($data['TGL_IJIN_TPS'],'DATE'),
										   'WK_REKAM' => date('Y-m-d H:i:s'));//print_r($array_kms);die();
						/*if($COUNT > 0){
							unset($array_kms['ID']);
							unset($array_kms['NO_BL_AWB']);
							$wms_db->where(array('ID' => $ID_KMS, 'NO_BL_AWB' => $NO_BL_AWB));
							$ex = $wms_db->update('t_cocokms',$array_kms);
							echo "SUCCESS UPDATE, NO. BL/AWB ".$NEW_ID." - ".$data['NO_BL_AWB']."<BR>";
						}else{*/
							$ex = $wms_db->insert('t_cocokms',$array_kms);//echo $wms_db->last_query();//die();
							echo "SUCCESS INSERT, NO. BL/AWB ".$NEW_ID." - ".$data['NO_BL_AWB']."<BR>";
						//}
						if($ex){
							
							$SQL = "UPDATE cocokms SET FLAG_MG = '1' WHERE ID= '".$data['ID']."' AND NO_BL_AWB = '".$data['NO_BL_AWB']."'";
							//ECHO $SQL;
							$this->db->query($SQL);
						}	
					}
				}
				$wms_db->close();
				remove_file($filename);
			}else{
				echo "APPLICATION IS RUNNING"; exit();
			}
		}else{
			echo "NO RECORDS FOUND"; exit();
		}
	}
	
	function coarri_carkmsout(){
		$SQL = "SELECT A.*, B.*, TO_CHAR(A.WK_INOUT,'YYYY-MM-DD HH24:MM:SS') AS WK_OUT FROM cocokms A 
				LEFT JOIN cocohdr B ON A.ID=B.ID 
        WHERE b.kd_dok='3' AND  a.flag_mg IS NULL AND to_char(a.received_date, 'YYYY') = '2018' and b.kd_tps='CART' AND ROWNUM <= 100";
		$exec = $this->db->query($SQL);
		if($exec->num_rows() > 0){
			//$filename = DIR_EXE.'codeco_kms.txt';
			//$check_file = check_file($filename);
			if(!$check_file){
				#create_file($filename);
				$wms_db = $this->load->database('wms',TRUE);
				$array_data = $exec->result_array();//print_r($array_data);die();
				foreach($array_data as $data){
					$ID = $data['ID'];
					$KD_DOK = "1";
					$KD_TPS = $data['KD_TPS'];
					$KD_GUDANG = $data['KD_GUDANG'];
					$NM_ANGKUT = trim($data['NM_ANGKUT']);
					$NO_VOY_FLIGHT = trim($data['NO_VOY_FLIGHT']);
					$TGL_TIBA = validate($data['TGL_TIBA'],'DATE');
					$CALL_SIGN = trim($data['CALL_SIGN']);
					$NO_BC11 = trim($data['NO_BC11']);
					$TGL_BC11 = validate($data['TGL_BC11'],'DATE');
					$GETID = $this->get_data('t_cocostshdr',array($KD_DOK,$KD_GUDANG,$NM_ANGKUT,$NO_VOY_FLIGHT,$CALL_SIGN,$TGL_TIBA));
					$KD_KAPAL  = $this->get_data('kapal',array($data['NM_ANGKUT'],$data['CALL_SIGN']));
					$next = false;
					if($GETID == ""){
						$array_hdr = array('KD_ASAL_BRG' => $KD_DOK,
										   'KD_TPS' => $KD_TPS,
										   'KD_KAPAL' => $KD_KAPAL,
										   'NM_ANGKUT' => $NM_ANGKUT,
										   'NO_VOY_FLIGHT' => $NO_VOY_FLIGHT,
										   'CALL_SIGN' => $CALL_SIGN,
										   'TGL_TIBA' => $TGL_TIBA,
										   'KD_GUDANG' => $KD_GUDANG,
										   'NO_BC11' => $NO_BC11,
										   'TGL_BC11' => $TGL_BC11,
										   'WK_REKAM' => date('Y-m-d H:i:s'));//print_r($array_hdr);die();
						$wms_db->insert('t_cocostshdr',$array_hdr);
						$NEW_ID = $wms_db->insert_id();
						$next = true;
					}else{
						$array_hdr = array('KD_ASAL_BRG' => $KD_DOK,
										   'KD_KAPAL' => $KD_KAPAL,
										   'KD_TPS' => $KD_TPS,
										   'NM_ANGKUT' => $NM_ANGKUT,
										   'NO_VOY_FLIGHT' => $NO_VOY_FLIGHT,
										   'CALL_SIGN' => $CALL_SIGN,
										   'TGL_TIBA' => $TGL_TIBA,
										   'KD_GUDANG' => $KD_GUDANG,
										   'NO_BC11' => $NO_BC11,
										   'TGL_BC11' => $TGL_BC11,
										   'WK_REKAM' => date('Y-m-d H:i:s'));//print_r($array_hdr);die();
						$wms_db->where(array('ID' => $GETID));
						$ex = $wms_db->update('t_cocostshdr',$array_hdr);//echo $wms_db->last_query();die();
						$NEW_ID = $GETID;
						$next = true;
					}
					if($next){
						//list($COUNT, $ID_KMS, $NO_BL_AWB) = $this->get_data('t_cocokms',array($NEW_ID,$data['NO_BL_AWB']));
						$array_kms = array('ID' => $NEW_ID,
										   'SERI_KEMAS' => $data['SERI_KEMAS'],
										   'KD_KEMAS' => $data['KD_KEMAS'],
										   'JML_KEMAS' => $data['JML_KEMAS'],
										   'KD_DOK' => '3',
										   'NO_BL_AWB' => $data['NO_BL_AWB'],
										   'TGL_BL_AWB' => validate($data['TGL_BL_AWB'],'DATE'),
										   'NO_MASTER_BL_AWB' => $data['NO_MASTER_BL_AWB'],
										   'TGL_MASTER_BL_AWB' => validate($data['TGL_MASTER_BL_AWB'],'DATE'),
										   'ID_CONSIGNEE' => $data['ID_CONSIGNEE'],
										   'CONSIGNEE' => $data['CONSIGNEE'],
										   'BRUTO' => $data['BRUTO'],
										   'NO_BC11' => $data['NO_BC11'],
										   'TGL_BC11' => validate($data['TGL_BC11'],'DATE'),
										   'NO_POS_BC11' => $data['NO_POS_BC11'],
										   'KD_TIMBUN' => $data['KD_TIMBUN'],
										   'KD_SAR_ANGKUT_INOUT' => $data['KD_SAR_ANGKUT_INOUT'],
										   'NO_POL' => $data['NO_POL'],
										   'KD_DOK_INOUT' => $data['KD_DOK_INOUT'],
										   'NO_DOK_INOUT' => $data['NO_DOK_INOUT'],
										   'TGL_DOK_INOUT' => validate($data['TGL_DOK_INOUT'],'DATE'),
										   'WK_INOUT' => $data['WK_OUT'],
										   'PEL_MUAT' => $data['PEL_MUAT'],
										   'PEL_TRANSIT' => $data['PEL_TRANSIT'],
										   'PEL_BONGKAR' => $data['PEL_BONGKAR'],
										   'GUDANG_TUJUAN' => $data['GUDANG_TUJUAN'],
										   'KODE_KANTOR' => $data['KODE_KANTOR'],
										   'NO_DAFTAR_PABEAN' => $data['NO_DAFTAR_PABEAN'],
										   'TGL_DAFTAR_PABEAN' => validate($data['TGL_DAFTAR_PABEAN'],'DATE'),
										   'NO_SEGEL_BC' => $data['NO_SEGEL_BC'],
										   'TGL_SEGEL_BC' => validate($data['TGL_SEGEL_BC'],'DATE'),
										   'NO_IJIN_TPS' => $data['NO_IJIN_TPS'],
										   'TGL_IJIN_TPS' => validate($data['TGL_IJIN_TPS'],'DATE'),
										   'WK_REKAM' => date('Y-m-d H:i:s'));//print_r($array_kms);die();
						/*if($COUNT > 0){
							unset($array_kms['ID']);
							unset($array_kms['NO_BL_AWB']);
							$wms_db->where(array('ID' => $ID_KMS, 'NO_BL_AWB' => $NO_BL_AWB));
							$ex = $wms_db->update('t_cocokms',$array_kms);
							echo "SUCCESS UPDATE, NO. BL/AWB ".$NEW_ID." - ".$data['NO_BL_AWB']."<BR>";
						}else{*/
							$ex = $wms_db->insert('t_cocokms',$array_kms);//echo $wms_db->last_query();//die();
							echo "SUCCESS INSERT, NO. BL/AWB ".$NEW_ID." - ".$data['NO_BL_AWB']."<BR>";
						//}
						if($ex){
							
							$SQL = "UPDATE cocokms SET FLAG_MG = '1' WHERE ID= '".$data['ID']."' AND NO_BL_AWB = '".$data['NO_BL_AWB']."'";
							//ECHO $SQL;
							$this->db->query($SQL);
						}	
					}
				}
				$wms_db->close();
				remove_file($filename);
			}else{
				echo "APPLICATION IS RUNNING"; exit();
			}
		}else{
			echo "NO RECORDS FOUND"; exit();
		}
	}
	
	function set_seri($table,$id){
		$wms_db = $this->load->database('wms',TRUE);
		$SQL = "SELECT IFNULL(MAX(SERI_KEMAS)+1,1) AS SERI 
				FROM $table 
				WHERE ID = ".$this->db->escape($id);
		$result = $wms_db->query($SQL);
		if($result->num_rows() > 0){
			$seri = $result->row()->SERI;
		}
		return $seri;
	}
	
	function get_data($act,$data=array()){
		$wms_db = $this->load->database('wms',TRUE);
		if($act=="t_repohdr"){//echo "SINI";die();
			$SQL = "SELECT ID
					FROM t_repohdr 
					WHERE KD_ASAL_BRG = ".$this->db->escape($data[0])."
					AND NM_ANGKUT = ".$this->db->escape($data[2])."
					AND NO_VOY_FLIGHT =".$this->db->escape($data[3])."
					AND CALL_SIGN = ".$this->db->escape($data[4]);//echo $SQL;DIE();
			$result = $wms_db->query($SQL);
			if($result->num_rows() > 0){
				$data = $result->row_array();
				$ID_HDR = $data['ID'];
			}else{
				$ID_HDR = "";
			}
			return $ID_HDR;
		}else if($act=="t_repocont"){
			$SQL = "SELECT ID, NO_CONT
					FROM t_repocont 
					WHERE ID = ".$this->db->escape($data[0])."
					AND NO_CONT = ".$this->db->escape($data[1]);//echo$SQL;die();
			$result = $wms_db->query($SQL);
			if($result->num_rows() > 0){
				$data = $result->row_array();
				$arrReturn = array($result->num_rows(),$data['ID'],$data['NO_CONT']);//print_r($arrReturn);die();
			}else{
				$arrReturn = array(0,'','');
			}
			return $arrReturn;
		}else if($act=="cocostskms"){
			$SQL = "SELECT ID, NO_BL_AWB
					FROM cocostskms 
					WHERE ID = ".$this->db->escape($data[0])."
					AND NO_BL_AWB = ".$this->db->escape($data[1]);
			$result = $wms_db->query($SQL);
			if($result->num_rows() > 0){
				$data = $result->row_array();
				$arrReturn = array($result->num_rows(),$data['ID'],$data['NO_BL_AWB']);
			}else{
				$arrReturn = array(0,'','');
			}
			return $arrReturn;
		}else if($act=="t_cocokms"){
			$SQL = "SELECT ID, NO_BL_AWB
					FROM t_cocokms 
					WHERE ID = ".$this->db->escape($data[0])."
					AND NO_BL_AWB = ".$this->db->escape($data[1]);
			$result = $wms_db->query($SQL);
			if($result->num_rows() > 0){
				$data = $result->row_array();
				$arrReturn = array($result->num_rows(),$data['ID'],$data['NO_BL_AWB']);
			}else{
				$arrReturn = array(0,'','');
			}
			return $arrReturn;
		}else if($act=="t_cocostshdr"){//echo "SINI";die();
			$SQL = "SELECT ID
					FROM t_cocostshdr 
					WHERE KD_ASAL_BRG = ".$this->db->escape($data[0])."
					AND NM_ANGKUT = ".$this->db->escape($data[2])."
					AND NO_VOY_FLIGHT =".$this->db->escape($data[3])."
					AND CALL_SIGN = ".$this->db->escape($data[4]);//echo $SQL;DIE();
			$result = $wms_db->query($SQL);
			if($result->num_rows() > 0){
				$data = $result->row_array();
				$ID_HDR = $data['ID'];
			}else{
				$ID_HDR = "";
			}
			return $ID_HDR;
		}else if($act=="t_cocostscarter"){
			$SQL = "SELECT ID, VIN_NUMBER
					FROM t_cocostscarter 
					WHERE ID = ".$this->db->escape($data[0])."
					AND VIN_NUMBER = ".$this->db->escape($data[1]);//echo$SQL;die();
			$result = $wms_db->query($SQL);
			if($result->num_rows() > 0){
				$data = $result->row_array();
				$arrReturn = array($result->num_rows(),$data['ID'],$data['VIN_NUMBER']);//print_r($arrReturn);die();
			}else{
				$arrReturn = array(0,'','');
			}
			return $arrReturn;
		}else if($act=="organisasi"){
			$SQL = "SELECT ID FROM t_organisasi WHERE NPWP = " . $this->db->escape($data[0]);
			$result = $wms_db->query($SQL);
			if ($result->num_rows() > 0) {
				$data = $result->row_array();
				$KD_ORG_CONSIGNEE = $data['ID'];
			} else {
				$array_org = array('NPWP' => $data[0],
									'NAMA' => $data[1],
									'KD_TIPE_ORGANISASI' => 'CONS');
				$Execute = $wms_db->insert('t_organisasi',$array_org);
				if ($Execute) {
					$ID= $wms_db->insert_id();
					$KD_ORG_CONSIGNEE = $ID;
				} else {
					$KD_ORG_CONSIGNEE = NULL;
				}
			}
			return $KD_ORG_CONSIGNEE;
		}else if($act=="kapal"){
			$SQL = "SELECT ID FROM reff_kapal WHERE 
					NAMA = " . $this->db->escape($data[0])."
					AND CALL_SIGN = " . $this->db->escape($data[1]);//print_r($SQL);DIE();
			$result = $wms_db->query($SQL);
			if ($result->num_rows() > 0) {
				$data = $result->row_array();
				$KD_KAPAL = $data['ID'];
			} else {
				$array_org = array('NAMA' => $data[0],
									'CALL_SIGN' => $data[1]);
				$Execute = $wms_db->insert('reff_kapal',$array_org);
				if ($Execute) {
					$ID= $wms_db->insert_id();
					$KD_KAPAL = $ID;
				} else {
					$KD_KAPAL = NULL;
				}
			}
			return $KD_KAPAL;
		}else if($act=="manifin_header"){//echo "SINI";die();
			$SQL = "SELECT ID
					FROM IBIS.manifin_header 
					WHERE NAMA_KAPAL = ".$this->db->escape($data[0])."
					AND NO_VOYAGE =".$this->db->escape($data[1])."
					AND NOBC11 = ".$this->db->escape($data[3]);
			$result = $this->db->query($SQL);
			if($result->num_rows() > 0){
				$data = $result->row_array();
				$ID_HDR = $data['ID'];
			}else{
				$ID_HDR = "";
			}
			return $ID_HDR;
		}
		$wms_db->close();
	}
}
?>