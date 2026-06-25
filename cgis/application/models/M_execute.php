<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class M_execute extends CI_Model {

	public function __construct(){
		parent::__construct();
	}

	public function emailnya($alamatemail,$nama,$pass){

		if (!$this->session->userdata('LOGGED')){
            $this->index();
            return;
        }
		$mail = $email->EMAIL;
		$subject = "REMINDER []";
		$email = $alamatemail;
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
				'crlf'         => "\r\n",
				'newline'     => "\r\n",
				'start_tls' => TRUE
			);
			$msg = '
			<html>
				<head>
					<title>Customer Regristration</title>
				</head>
				<body style="background: #ffffff; color: #000000; font-family: arial; font-size: 13px; margin: 20px; color: #363636;">
					<table style="margin-bottom: 2px">
							<tr style="font-size: 13px; color: #0b1d90; font-weight: 700; font-family: arial;">
									<td style="font-family: arial; vertical-align: middle; color: #153f6f;">Persetujuan Registrasi Aplikasi CGIS<br/>
											<span style="color: #858585; font-size: 10px; text-decoration: none;">Administrator</span>
									</td>
							</tr></table>
							<div style="background-color: #dee8f4; margin-top: 4px; margin-bottom: 10px; padding: 5px; font-family: Verdana; font-size: 11px; width:610px; height:auto;text-align:justify;">
							Yth. Bapak/Ibu terimakasih telah melakukan penambahan user aplikasi CGIS. Berikut kami informasikan mengenai user di Sistem Aplikasi CGIS, yaitu :
									<table style="margin: 4px 4px 4px 10px; font-family: arial; font-size:12px; font-weight: 700; width:580px;">
											<tr>
													<td width="150" valign="top">Username</td>
													<td valign="top">: <b>'.$alamatemail.'</b></td>
											</tr>
											<tr>
													<td width="150" valign="top">Password</td>
													<td valign="top">: <b>'.$pass.'</b></td>
											</tr>
									</table>
									Lakukan perubahan password segera demi keamanan dan kenyamanan anda. Silahkan login ke halaman berikut 103.29.187.33/tpk_ipc/cgis
							</div>
							<div style="border-top: 1px solid #dcdcdc; clear: both; font-size: 11px; margin-top: 10px; padding-top: 5px;">
									<div style="font-family: arial; font-size: 10px; color: #a7aaab;">
											<a style="text-decoration: none; font-family: arial; font-size: 10px; font-weight: normal;">Behandle Operating System (BOS)</a>
									</div>
							 </div>
					</body>
			</html>
			';

			$this->load->library('email', $config);
			#$this->email->set_newline("\r\n");
			$this->email->from('automail@multiterminal.co.id', 'BOS NOTIFICATION - CUSTOMER REGRISTRATION');
			$email = str_replace(';', ',', $email);
			$this->email->to($email);
			//$array_bcc = array('nuridin.mu23@gmail.com','muhammad.nuridin@edi-indonesia.co.id','salman.abdulaziz@edi-indonesia.co.id', 'cgs@indonesiaport.co.id', 'automail@multiterminal.co.id','get@npct1.co.id');
			//$this->email->bcc($array_bcc);
			$this->email->subject($subject);
			$this->email->message($msg);
			if ($this->email->send()){
				$email_success = 1;
				/*echo "<script>alert('Email Terkirim');window.location=''</script>";*/
				// echo "Email Terkirim";
				//echo "MSG#OK#Data berhasil dikirim#".site_url()."/planning/spk";
				// $this->db->where(array('ID' => $id));
				// $this->db->update('t_spk', array('KD_STATUS' => '100'));
			}
		}
		return $email_success;
		//print_r($SQL);die();
	}
	
	public function insertGatepassDelivery($cek_nodok,$cek_exp){
		$SQLCekGatePass = "SELECT NO_DOK FROM t_gatepass WHERE JNS_KEGIATAN = 3 AND NO_DOK = '$cek_nodok'";
		$resultGatePass = $this->db->query($SQLCekGatePass)->result_array();
		$cekTotalGatePass = count($resultGatePass);
		if (@$resultGatePass) {
			echo "Data Sudah Ada";
		}else{
			$SQLInsGatePAss = "SELECT E.NAMA AS 'JNS_DOK',A.NO_DOK_INOUT,A.TGL_DOK_INOUT,'WAITING' AS 'STATUS', '3' AS JNS_KEGIATAN, B.NO_CONT,B.KD_CONT_UKURAN,A.ID_CONSIGNEE,A.CONSIGNEE,A.ANGKUTNAMA_TPS,A.ANGKUTNO_TPS,'2017-11-28' AS 'EXPIRED DATE', D.NO_SPK, NOW() AS 'WK_REQ'
							FROM t_permit_hdr A
							INNER JOIN t_permit_cont B ON A.ID = B.ID
							INNER JOIN t_spk_cont C ON B.NO_CONT=C.NO_CONT
							INNER JOIN t_spk D ON C.ID = D.ID
							INNER JOIN reff_kode_dok_bc E ON A.KD_DOK_INOUT = E.ID
							WHERE A.NO_DOK_INOUT LIKE '%$cek_nodok%'";
			$result = $this->db->query($SQLInsGatePAss)->result_array();
			$totalCont = count($result);
			for ($i=0; $i < $totalCont ; $i++) { 
				$tmpData = array(
						"JNS_DOK" => $result[$i]['JNS_DOK'], 
						"NO_DOK" => $result[$i]['NO_DOK_INOUT'], 
						"TGL_DOK" => $result[$i]['TGL_DOK_INOUT'], 
						"STATUS" => $result[$i]['STATUS'], 
						"JNS_KEGIATAN" => $result[$i]['JNS_KEGIATAN'], 
						"NO_CONT" => $result[$i]['NO_CONT'], 
						"UKR_CONT" => $result[$i]['KD_CONT_UKURAN'], 
						"NPWP" => $result[$i]['ID_CONSIGNEE'], 
						"NAMA_CUST" => $result[$i]['CONSIGNEE'], 
						"NM_KAPAL" => $result[$i]['ANGKUTNAMA_TPS'], 
						"NO_VOY" => $result[$i]['ANGKUTNO_TPS'], 
						"EXPIRED_DATE" => $cek_exp, 
						"NO_SPK" => $result[$i]['NO_SPK'], 
						"WK_REK" => date('Y-m-d H:i:s')
					);
				$this->db->insert('t_gatepass',$tmpData);
			}
			//echo "berhasil Insert";
		}			
	}
	
	public function updateGatepassDelivery($cek_nodok,$id_req){
		$SQLCekGatePass = "SELECT ID,NO_DOK FROM t_gatepass WHERE JNS_KEGIATAN = 3 AND NO_DOK = '$cek_nodok'";
		$resultGatePass = $this->db->query($SQLCekGatePass)->result_array();
		$cekTotalGatePass = count($resultGatePass);
		if (@$resultGatePass) {
			$SQLUpdtGatePass = "SELECT A.ID_REQ,A.NO_DOK,A.ID_REQ_OLD, B.NO_CONT,A.EXPIRED
								FROM req_delivery_hdr A
								INNER JOIN req_delivery_dtl B ON A.ID_REQ = B.ID_REQ
								WHERE A.NO_DOK  LIKE '%$cek_nodok%' AND A.ID_REQ_OLD IS NOT NULL AND B.NO_CONT IS NOT NULL
								GROUP BY B.NO_CONT";
			$result = $this->db->query($SQLUpdtGatePass)->result_array();
			$totalCont = count($result);
			for ($i=0; $i < $totalCont ; $i++) { 
				$tmpData = array(
						"EXPIRED_DATE" => $result[$i]['EXPIRED'], 
					);
				$this->db->where('id',$resultGatePass[$i]['ID']);
				$this->db->update('t_gatepass',$tmpData);
			}
			echo "berhasil Insert";
		}else{
			echo "Data Belum Pernah Di Proses";
		}			
	}

	public function process($type,$act,$id){
		$func = get_instance();
        $func->load->model("m_main", "main", true);
		$KD_TPS = $this->session->userdata('KD_TPS');
		$KD_GUDANG = $this->session->userdata('KD_GUDANG');
		$KD_KPBC = $this->session->userdata('KD_KPBC');
		$error = 0;
		if($type=="save"){
			if($act=="kapal"){
				foreach($this->input->post('DATA') as $a => $b){
					if($b=="") unset($DATA[$a]);
					else $DATA[$a] = strtoupper(trim($b));
				}
				$eta=$DATA['ETA'];
				$etd=$DATA['ETD'];
				$cls=$DATA['CLS_TIME'];
				$os=$DATA['OPN_STACK'];
				$er=$DATA['EARLY_STACK'];


				if (strtotime($etd) <= strtotime($eta) ) {
					$error += 1;
					$message = "ETD HARUS LEBIH BESAR DARI ETA";
				}elseif (strtotime($eta) <= strtotime($os) ) {
					$error += 1;
					$message = "OPEN STACK HARUS LEBIH KECIL DARI ETA";
				}elseif (strtotime($cls) >= strtotime($etd)) {
					$error += 1;
					$message = "CLOSING TIME HARUS LEBIH KECIL DARI ETD";
				}else {
					$DATA['NM_KAPAL'] = $DATA['NM_KAPAL'];
					$DATA['NO_VOYAGE'] = $DATA['NO_VOYAGE'];
					$DATA['ETA'] = $DATA['ETA'];
					$DATA['ATA'] = $DATA['ATA'];
					$DATA['ETD'] = $DATA['ETD'];
					$DATA['ATD'] = $DATA['ATD'];
					$DATA['OPN_STACK'] = $DATA['OPN_STACK'];
					$DATA['NO_PPKB'] = $DATA['NO_PPKB'];
					$DATA['WK_DISCH'] = $DATA['WK_DISCH'];
					$DATA['JMLH_MUAT'] = $DATA['JMLH_MUAT'];
					$DATA['EARLY_STACK'] = $DATA['EARLY_STACK'];
					$DATA['CLS_TIME'] = $DATA['CLS_TIME'];
					$DATA['WK_REKAM'] = date('Y-m-d H:i:s');

					$this->db->insert('t_jadwal_kapal', $DATA);
				}



				if($id!=""){
					$error += 1;
					// $message = "Data gagal diproses";
				}else{
					/*$QUERY = "SELECT ID FROM t_repohdr
							  WHERE KD_ASAL_BRG  = ".$this->db->escape(trim($DATA['KD_ASAL_BRG']))."
							  AND NO_VOY_FLIGHT = ".$this->db->escape(trim($DATA['NO_VOY_FLIGHT']))."
							  AND CALL_SIGN = ".$this->db->escape(trim($DATA['CALL_SIGN']))."
							  AND TGL_TIBA = ".$this->db->escape(trim($DATA['TGL_TIBA']));
					$QUERY = "SELECT * FROM t_jadwal_kapal";
					$result = $this->db->query($QUERY);
					if($result){
						$result = $this->db->insert('t_jadwal_kapal', $DATA);
						$ID = $this->db->insert_id();
						if(!$result){
							$error += 1;
							$message = "Data gagal diproses";
						}
					}*/
				}
				if($error == 0){
					//$func->main->get_log("add","t_repohdr");
					echo "MSG#OK#Data berhasil diproses#".$this->input->post('action');
				}else{
					echo "MSG#ERR#".$message."#";
				}
			}else if($act == 'gatepass_delivery'){
				foreach($this->input->post('DATA') as $a => $b){
					if($b=="") unset($DATA[$a]);
					else $DATA[$a] = strtoupper(trim($b));
				}
				$DATA['NO_DOK'] = $DATA['NO_DOK'];
				$DATA['JNS_DOK'] = $DATA['JNS_DOK'];
				$DATA['NO_CONT'] = $DATA['NO_CONT'];
				$DATA['TGL_DOK'] = date('Y-m-d',strtotime($DATA['TGL_DOK']));;
				$DATA['NAMA_CUST'] = $DATA['NAMA_CUST'];
				$DATA['NO_VOY'] = $DATA['NO_VOY'];
				$DATA['NPWP'] = $DATA['NPWP'];
				$DATA['JNS_KEGIATAN'] = 3;
				$DATA['UKR_CONT'] = $DATA['UKR_CONT'];
				$DATA['WK_REK'] = date('Y-m-d H:i:s');
				$this->db->insert('t_gatepass', $DATA);

				if($error == 0){
					$action = '/planning/get_pass_delivery/post';
					echo "MSG#OK#Data berhasil diproses#".site_url().$action;
				}else{
					echo "MSG#ERR#Data gagal diproses#";
				}
			}else if($act == 'nota_confirm'){
				if($error == 0){
					$action = '/billing/behandle/post';
					echo "MSG#OK#Konfirmasi nota berhasil dilakukan#".site_url().$action;
				}else{
					echo "MSG#ERR#".$message."#";
				}
			}else if($act == 'nota_confirm_del'){
				if($error == 0){
					$action = '/billing/delivery/post';
					echo "MSG#OK#Konfirmasi nota berhasil dilakukan#".site_url().$action;
				}else{
					echo "MSG#ERR#".$message."#";
				}
			}else if($act == 'behandle1'){
				foreach($this->input->post('DATA') as $a => $b){
					if($b=="") unset($DATA[$a]);
					else $DATA[$a] = strtoupper(trim($b));
					///$jumlah_dipilih = count($DATA['NO_CONT']);
				}

				//$count = count($DATA);
				//print_r($count);die();
				$seq = $this->db->query("SELECT IFNULL(COUNT(id_req)+1,1) AS 'urut' FROM req_behandle_hdr")->row()->urut;
				$norut = $seq;

				$BA = $this->db->query("SELECT TARIF AS 'Tarif' FROM m_tarif WHERE JENIS_BIAYA = 'ADMINISTRASI'")->row()->Tarif;

				$REQ = "BHD/".date('Y-m-d')."/".$norut;
				$DATA_BHD['ID_REQ'] = $REQ;//$DATA['NO_REQ'];
				//$DATA_BHD['TGL_REQ'] = date('Y-m-d H:i:s');
				//echo "dasdasda"; die();
				$DATA_BHD['JNS_DOK'] = $DATA['JNS_DOK'];
				$DATA_BHD['NO_DOK'] = $DATA['NO_DOK'];
				$DATA_BHD['TGL_DOK'] = $DATA['TGL_DOK'];
				$DATA_BHD['NM_KAPAL'] = $DATA['NM_KAPAL'];
				$DATA_BHD['NO_VOY'] = $DATA['NO_VOY'];
				$DATA_BHD['NO_DO'] = $DATA['NO_DO'];
				$DATA_BHD['NO_BL'] = $DATA['NO_BL'];
				$DATA_BHD['JNS_KEGIATAN'] = '1';
				$DATA_BHD['TGL_REQ'] = date('Y-m-d H:i:s');
				$DATA_BHD['NAMA_CUST'] = $DATA['CUSTOMER'];
				$DATA_BHD['OPERATOR'] = $this->session->userdata('USERLOGIN');
				$DATA_BHD['NPWP'] = $DATA['NPWP'];
				$DATA_BHD['NO_NOTA_BEHANDLE'] = "";
				$DATA_BHD['TGL_NOTA'] = "";

				$DATA_BHD['BANK_ID'] = "";

				$DA = $DATA['NO_DOK'];
				$this->db->where(array('NO_DOK' =>$DA));
				$this->db->update('t_spk', array('FL_BIL' => 'DONE'));

				$this->db->insert('req_behandle_hdr', $DATA_BHD);
				foreach($this->input->post('DT[]') as $a => $b){
					foreach($b as $value){
						if($value=="") unset($DT[$a]);
						else $DT[$a][] = strtoupper(trim($value));
					}
				}

				$jumlah_dipilih = count($DT['NO_CONT']);
				$sub_total = 0;
				$KET = $DATA['JNS_KEGIATAN'];
				for($x=0; $x<$jumlah_dipilih; $x++){
					$DETAIL = array();
					$SIZE = array();
					$SIZE = $DT['UKR_CONT'][$x];


					$SQL = $this->db->query("SELECT * FROM m_tarif WHERE SIZE = '$SIZE' AND JENIS_BIAYA = 'PAKET BEHANDLE' AND KET = 1")->row();

					$sub_total = $sub_total + $SQL->TARIF;

					$DETAIL['ID_REQ'] = $REQ;
					$DETAIL['NO_CONT'] = $DT['NO_CONT'][$x];
					$DETAIL['UK_CONT'] = $DT['UKR_CONT'][$x];
					$DETAIL['JNS_KEGIATAN'] = 1;
					$DETAIL['TOTAL'] = $SQL->TARIF;
					$this->db->insert('req_behandle_dtl',$DETAIL);

					//EDITBILLING
					$SUM_MAX_ID = $this->db->query("SELECT ID_REQ AS 'ID' FROM req_behandle_dtl WHERE ID_REQ IN
													(SELECT ID_REQ FROM req_behandle_dtl WHERE SUBSTRING(ID_REQ, 16) =
													(SELECT IFNULL(COUNT(id_req),1) AS 'urut' FROM req_behandle_hdr))")->row()->ID;
					$SQL_MAX = $this->db->query("SELECT MAX(ID) AS ID FROM req_behandle_hdr")->row()->ID;
					$MAX_ID = $SQL_MAX;
					//echo $MAX_ID;die();
					$sub_total1 = $this->db->query("SELECT SUM(TOTAL) AS TOTAL FROM req_behandle_dtl WHERE ID_REQ = '$SUM_MAX_ID'")->row()->TOTAL;

					$sub_totalA = $sub_total1 + $BA;
					$PPN = $sub_totalA * 0.1;
					if($sub_total1 >= 1000000){
						$MAT = 6000;
					} else {
						$MAT = 3000;
					}

					$TOTAL_ALL = $sub_totalA + $PPN + $MAT;
					$DATA_HDR_BH['BIAYA_ADMIN'] = $BA;
					$DATA_HDR_BH['BIAYA_MATERAI'] = $MAT;
					$DATA_HDR_BH['SUBTOTAL'] = $sub_total1;
					$DATA_HDR_BH['PPN'] = $PPN;
					$DATA_HDR_BH['TOTAL_JUMLAH'] = $TOTAL_ALL;
					//print_r($DATA_HDR_BH);die();
					$this->db->where(array('ID' => $MAX_ID));
					$this->db->update('req_behandle_hdr', $DATA_HDR_BH);
				}


				//$DATA_BHD['TOTAL_JUMLAH'] = $sub_total;

				echo "MSG#OK#Data berhasil diproses#".$this->input->post('action');
			}else if($act == 'behandle2'){
				foreach($this->input->post('DATA') as $a => $b){
					if($b=="") unset($DATA[$a]);
					else $DATA[$a] = strtoupper(trim($b));
					///$jumlah_dipilih = count($DATA['NO_CONT']);
				}

				//$count = count($DATA);
				//print_r($count);die();
				$seq = $this->db->query("SELECT IFNULL(COUNT(id_req)+1,1) AS 'urut' FROM req_behandle_hdr")->row()->urut;
				$norut = $seq;

				$BA = $this->db->query("SELECT TARIF AS 'Tarif' FROM m_tarif WHERE JENIS_BIAYA = 'ADMINISTRASI'")->row()->Tarif;

				$REQ = "BHD/".date('Y-m-d')."/".$norut;
				$DATA_BHD['ID_REQ'] = $REQ;//$DATA['NO_REQ'];
				//$DATA_BHD['TGL_REQ'] = date('Y-m-d H:i:s');
				//echo "dasdasda"; die();
				$DATA_BHD['JNS_DOK'] = $DATA['JNS_DOK'];
				$DATA_BHD['NO_DOK'] = $DATA['NO_DOK'];
				$DATA_BHD['TGL_DOK'] = $DATA['TGL_DOK'];
				$DATA_BHD['NM_KAPAL'] = $DATA['NM_KAPAL'];
				$DATA_BHD['TGL_REQ'] = date('Y-m-d H:i:s');
				$DATA_BHD['JNS_KEGIATAN'] = '2';
				$DATA_BHD['NO_DO'] = $DATA['NO_DO'];
				$DATA_BHD['NO_BL'] = $DATA['NO_BL'];
				$DATA_BHD['NPWP'] = $DATA['NPWP'];
				$DATA_BHD['NAMA_CUST'] = $DATA['CUSTOMER'];
				$DATA_BHD['OPERATOR'] = $this->session->userdata('USERLOGIN');
				$DATA_BHD['NO_NOTA_BEHANDLE'] = "";
				$DATA_BHD['TGL_NOTA'] = "";
				
				$DATA_BHD['BANK_ID'] = "";
				$this->db->insert('req_behandle_hdr', $DATA_BHD);
				
				//EDIT 23
				$NO_GP2 = $DATA['NO_DOK'];
				$DATA_GP2['FL_USE'] = 'Y';
				$this->db->where(array('NO_DOK' => $NO_GP2));
				$this->db->update('t_gatepass', $DATA_GP2);
				//
				
				foreach($this->input->post('DT[]') as $a => $b){
					foreach($b as $value){
						if($value=="") unset($DT[$a]);
						else $DT[$a][] = strtoupper(trim($value));
					}
				}

				$jumlah_dipilih = count($DT['NO_CONT']);
				// echo $jumlah_dipilih; die();
				$sub_total = 0;
				for($x=0; $x<$jumlah_dipilih; $x++){
					$DETAIL = array();
					$SIZE = array();
					$SIZE = $DT['UKR_CONT'][$x];


					$SQL = $this->db->query("SELECT * FROM m_tarif WHERE SIZE = '$SIZE' AND JENIS_BIAYA = 'PAKET BEHANDLE' AND KET = 2")->row();

					$sub_total = $sub_total + $SQL->TARIF;


					$DETAIL['ID_REQ'] = $REQ;
					$DETAIL['NO_CONT'] = $DT['NO_CONT'][$x];
					$DETAIL['UK_CONT'] = $DT['UKR_CONT'][$x];
					$DETAIL['JNS_KEGIATAN'] = '2';
					$DETAIL['TOTAL'] = $SQL->TARIF;
					$this->db->insert('req_behandle_dtl',$DETAIL);

					//EDITBILLING
					$SUM_MAX_ID = $this->db->query("SELECT ID_REQ AS 'ID' FROM req_behandle_dtl WHERE ID_REQ IN
													(SELECT ID_REQ FROM req_behandle_dtl WHERE SUBSTRING(ID_REQ, 16) =
													(SELECT IFNULL(COUNT(id_req),1) AS 'urut' FROM req_behandle_hdr))")->row()->ID;
					$SQL_MAX = $this->db->query("SELECT MAX(ID) AS ID FROM req_behandle_hdr")->row()->ID;
					$MAX_ID = $SQL_MAX;
					//echo $MAX_ID;die();
					$sub_total1 = $this->db->query("SELECT SUM(TOTAL) AS TOTAL FROM req_behandle_dtl WHERE ID_REQ = '$SUM_MAX_ID'")->row()->TOTAL;
					$sub_totalA = $sub_total1 + $BA;
					$PPN = $sub_totalA * 0.1;
					if($sub_total1 >= 1000000){
						$MAT = 6000;
					} else {
						$MAT = 3000;
					}
					$TOTAL_ALL = $sub_totalA + $PPN + $MAT;
					//print_r("materai".$MAT);die();
					$DATA_HDR_BH['BIAYA_ADMIN'] = $BA;
					$DATA_HDR_BH['BIAYA_MATERAI'] = $MAT;
					$DATA_HDR_BH['SUBTOTAL'] = $sub_total1;
					$DATA_HDR_BH['PPN'] = $PPN;
					$DATA_HDR_BH['TOTAL_JUMLAH'] = $TOTAL_ALL;
					//print_r($DATA_HDR_BH);die();
					$this->db->where(array('ID' => $MAX_ID));
					$this->db->update('req_behandle_hdr', $DATA_HDR_BH);
				}



				//$DATA_BHD['TOTAL_JUMLAH'] = $sub_total;

				echo "MSG#OK#Data berhasil diproses#".$this->input->post('action');
			}else if($act == "confirm_behandle"){
				//print_r($_POST).'xfxfsdvdf'; die();
				foreach($this->input->post('DATA') as $a => $b){
					if($b=="") unset($DATA[$a]);
					else $DATA[$a] = strtoupper(trim($b));
				}

				$ID_NOTA = explode('~',$DATA['ID']);
				$id = $ID_NOTA[0];
				$sql = $this->db->query("SELECT NO_NOTA_BEHANDLE FROM req_behandle_hdr WHERE ID_REQ = '$id'");

				foreach ($sql->result_array() as $value) {
					$cek_nota = $value['NO_NOTA_BEHANDLE'];
				}

				if ($cek_nota == NULL) {
					//echo "dssds"; die();
					$query = "SELECT LPAD(SEQUENCE+1,'6','0') SEQ, (SEQUENCE+1) SEQUE FROM m_generate_nota WHERE TYPE_NOTA = 'BEHANDLE'";
					$rs = $this->db->query($query);
					$data = $rs->row_array();
					$seq = $data["SEQ"];
					$seque = $data["SEQUE"];
					$no_nota_behandle = '010.000-16.65'.$seq;
					
					//$query = "UPDATE m_generate_nota SET SEQUENCE = '$seque'
					//WHERE TYPE_NOTA = 'BEHANDLE'";
					$this->db->where('TYPE_NOTA','BEHANDLE');
					$this->db->update('m_generate_nota',array('SEQUENCE' => $seque));
					//$this->db->query($query);

					$DATA_HDR['NO_NOTA_BEHANDLE'] = $no_nota_behandle;
					$DATA_HDR['TGL_NOTA'] =  date('Y-m-d H:i:s');
					$split = explode('~',$DATA['BANK']);
					$DATA_HDR['BANK_ID'] = $split[0];
					$this->db->where(array('ID_REQ' => $id));
					$this->db->update('req_behandle_hdr', $DATA_HDR);
				}

				$split = explode('~',$DATA['BANK']);
				$DATA_HDR['BANK_ID'] = $split[0];
				$this->db->where(array('ID_REQ' => $id));
				$this->db->update('req_behandle_hdr', $DATA_HDR);

				if($error == 0){
					$action = '/billing/behandle/post';
					echo "MSG#OK#Data berhasil diproses#".site_url().$action;
					site_url().$action;
				}else{
					echo "MSG#ERR#".$message."#";
				}
			}else if($act == "confirm_delivery"){
				foreach($this->input->post('DATA') as $a => $b){
					if($b=="") unset($DATA[$a]);
					else $DATA[$a] = strtoupper(trim($b));
				}

				$ID_NOTA = explode('~',$DATA['ID']);
				$id = $ID_NOTA[0];
				$sql = $this->db->query("SELECT NO_NOTA_DELIVERY,NO_DOK,EXPIRED FROM req_delivery_hdr WHERE ID_REQ = '$id'");

				foreach ($sql->result_array() as $value) {
					$cek_nota = $value['NO_NOTA_DELIVERY'];
					$cek_nodok = $value['NO_DOK'];
					$cek_exp = $value['EXPIRED'];
				}

				if ($cek_nota == NULL) {
					$query = "SELECT LPAD(SEQUENCE+1,'6','0') SEQ, (SEQUENCE+1) SEQUE FROM m_generate_nota WHERE TYPE_NOTA = 'DELIVERY'";
					$rs = $this->db->query($query);
					$data = $rs->row_array();
					$seq = $data["SEQ"];
					$seque = $data["SEQUE"];
					$no_nota_delivery = '010.000-16.61'.$seq;
					$this->db->where('TYPE_NOTA','DELIVERY');
					$this->db->update('m_generate_nota',array('SEQUENCE' => $seque));
					$DATA_HDR['NO_NOTA_DELIVERY'] = $no_nota_delivery;
					$DATA_HDR['TGL_NOTA'] =  $cek_exp;
					$split = explode('~',$DATA['BANK']);
					$DATA_HDR['BANK_ID'] = $split[0];
					$ID_BARU = explode('~',$DATA['ID']);
					
					$dataarr = array("NO_NOTA_DELIVERY" => $no_nota_delivery,"TGL_NOTA" =>$cek_exp,"BANK_ID" =>$split[0]);
					$this->db->where('ID_REQ', $ID_BARU[0]);
					$this->db->update('req_delivery_hdr', $dataarr);
				}
				$split = explode('~',$DATA['BANK']);
				$DATA_HDR['BANK_ID'] = $split[0];
				$this->db->where(array('ID_REQ' => $id));
				$this->db->update('req_delivery_hdr', $DATA_HDR);

				$DATA_HDR['PAID_STATUS'] =  "DONE";
				$this->db->where(array('ID_REQ' => $DATA['ID']));
				$this->db->update('req_delivery_hdr', $DATA_HDR);
				
				$this->insertGatepassDelivery($cek_nodok,$cek_exp);

				if($error == 0){
					$action = '/billing/delivery/post';
					echo "MSG#OK#Data berhasil diproses#".site_url().$action;
				}else{
					echo "MSG#ERR#".$message."#";
				}
			}else if($act == "confirm_ext"){
				foreach($this->input->post('DATA') as $a => $b){
					if($b=="") unset($DATA[$a]);
					else $DATA[$a] = strtoupper(trim($b));
				}

				$ID_NOTA = explode('~',$DATA['ID']);
				$id = $ID_NOTA[0];

				$sql = $this->db->query("SELECT ID_REQ,NO_NOTA_DELIVERY,NO_DOK,EXPIRED FROM req_delivery_hdr WHERE ID_REQ = '$id'");

				foreach ($sql->result_array() as $value) {
					$cek_nota = $value['NO_NOTA_DELIVERY'];
					$cek_nodok = $value['NO_DOK'];
					$id_req = $value['ID_REQ'];
				}
				if ($cek_nota == NULL) {
					$query = "SELECT LPAD(SEQUENCE+1,'6','0') SEQ, (SEQUENCE+1) SEQUE FROM m_generate_nota WHERE TYPE_NOTA = 'DELIVERY EXT'";
					$rs = $this->db->query($query);
					$data = $rs->row_array();
					$seq = $data["SEQ"];
					$seque = $data["SEQUE"];
					$no_nota_delivery = '010.000-16.61'.$seq;
					//echo "No Nota Delivery = ".$no_nota_delivery;

					$query = "UPDATE m_generate_nota SET SEQUENCE = '$seque'
					WHERE TYPE_NOTA = 'DELIVERY EXT'";
					$this->db->query($query);
					$DATA_HDR['NO_NOTA_DELIVERY'] = $no_nota_delivery;
					$DATA_HDR['TGL_NOTA'] =  date('Y-m-d H:i:s');
					$split = explode('~',$DATA['BANK']);
					$DATA_HDR['BANK_ID'] = $split[0];
					$this->db->where(array('ID_REQ' => $DATA['ID']));
					$this->db->update('req_delivery_hdr', $DATA_HDR);
				}

				$split = explode('~',$DATA['BANK']);
				$DATA_HDR['BANK_ID'] = $split[0];
				$this->db->where(array('ID_REQ' => $id));
				$this->db->update('req_delivery_hdr', $DATA_HDR);

				$DATA_HDR['PAID_STATUS'] =  "DONE";
				$this->db->where(array('ID_REQ' => $DATA['ID']));
				$this->db->update('req_delivery_hdr', $DATA_HDR);
				
				$this->updateGatepassDelivery($cek_nodok,$id_req);
				
				if($error == 0){
					$action = '/billing/delivery_ext/post';
					echo "MSG#OK#Data berhasil diproses#".site_url().$action;
					//site_url().$action;
				}else{
					echo "MSG#ERR#".$message."#";
				}
			}else if($act == "customer2"){
				$this->load->helper('reset_helper');
				foreach($this->input->post('DATA') as $a => $b){
					if($b=="") unset($DATA[$a]);
					else $DATA[$a] = trim($b);
				}
				if($DATA['EMAIL'] == NULL){
					$DATA['EMAIL'] = '-';
				}else{
					$DATA['EMAIL'] = $DATA['EMAIL'];
				}
				$PASS=ResetPassword();
				$DATA['NPWP'] = $DATA['NPWP'];
				$DATA['NAMA_CUST'] = $DATA['NAMA_CUST'];
				$DATA['PASSWORD'] = md5($PASS);
				$DATA['ALAMAT'] = $DATA['ALAMAT'];
				$DATA['TELEPON'] = $DATA['TELEPON'];
				$DATA['TLP_KANTOR'] = $DATA['TLP_KANTOR'];

				$this->emailnya($DATA['EMAIL'], $DATA['NAMA_CUST'], $PASS);
				$this->db->insert('m_pelanggan', $DATA);
				if($id!=""){
					$error += 1;
					$message = "Data gagal diproses";
				}else{
					/*$QUERY = "SELECT ID FROM t_repohdr
							  WHERE KD_ASAL_BRG  = ".$this->db->escape(trim($DATA['KD_ASAL_BRG']))."
							  AND NO_VOY_FLIGHT = ".$this->db->escape(trim($DATA['NO_VOY_FLIGHT']))."
							  AND CALL_SIGN = ".$this->db->escape(trim($DATA['CALL_SIGN']))."
							  AND TGL_TIBA = ".$this->db->escape(trim($DATA['TGL_TIBA']));
					$QUERY = "SELECT * FROM t_jadwal_kapal";
					$result = $this->db->query($QUERY);
					if($result){
						$result = $this->db->insert('t_jadwal_kapal', $DATA);
						$ID = $this->db->insert_id();
						if(!$result){
							$error += 1;
							$message = "Data gagal diproses";
						}
					}*/
				}
				if($error == 0){
					//$func->main->get_log("add","t_repohdr");
					echo "MSG#OK#Data berhasil diproses#".$this->input->post('action');
				}else{
					echo "MSG#ERR#".$message."#";
				}
			}else if($act == "dokbc"){
				foreach($this->input->post('DATA') as $a => $b){
					if($b=="") unset($DATA[$a]);
					else $DATA[$a] = strtoupper(trim($b));
				}

				$seq = $this->db->query("SELECT IFNULL(COUNT(ID)+1,1) AS 'urut' FROM reff_kode_dok_bc")->row()->urut;
				$norut = $seq;

				$DATA['ID'] = $norut;
				$DATA['NAMA'] = $DATA['NAMA'];
				$DATA['KD_PERMIT'] = $DATA['KD_PERMIT'];

				//print_r($data); die();
				$this->db->insert('reff_kode_dok_bc', $DATA);
				if($id!=""){
					$error += 1;
					$message = "Data gagal diproses";
				}else{

				}
				if($error == 0){
					//$func->main->get_log("add","t_repohdr");
					echo "MSG#OK#Data berhasil diproses#".$this->input->post('action');
				}else{
					echo "MSG#ERR#".$message."#";
				}
			}else if($act=="mail"){
				foreach($this->input->post('DATA') as $a => $b){
					if($b=="") unset($DATA[$a]);
					else $DATA[$a] = trim($b);
				}
				$DATA['EMAIL'] = $DATA['EMAIL'];
				$DATA['JNS_EMAIL'] = $DATA['JNS_EMAIL'];
				$DATA['NAMA_USER'] = $DATA['NAMA_USER'];

				$this->db->insert('reff_mail', $DATA);
				if($id!=""){
					$error += 1;
					$message = "Data gagal diproses";
				}else{
					/*$QUERY = "SELECT ID FROM t_repohdr
							  WHERE KD_ASAL_BRG  = ".$this->db->escape(trim($DATA['KD_ASAL_BRG']))."
							  AND NO_VOY_FLIGHT = ".$this->db->escape(trim($DATA['NO_VOY_FLIGHT']))."
							  AND CALL_SIGN = ".$this->db->escape(trim($DATA['CALL_SIGN']))."
							  AND TGL_TIBA = ".$this->db->escape(trim($DATA['TGL_TIBA']));
					$QUERY = "SELECT * FROM t_jadwal_kapal";
					$result = $this->db->query($QUERY);
					if($result){
						$result = $this->db->insert('t_jadwal_kapal', $DATA);
						$ID = $this->db->insert_id();
						if(!$result){
							$error += 1;
							$message = "Data gagal diproses";
						}
					}*/
				}
				if($error == 0){
					//$func->main->get_log("add","t_repohdr");
					echo "MSG#OK#Data berhasil diproses#".$this->input->post('action');
				}else{
					echo "MSG#ERR#".$message."#";
				}
			}else if($act=="libur"){

				foreach($this->input->post('DATA') as $a => $b){
					if($b=="") unset($DATA[$a]);
					else $DATA[$a] = strtoupper(trim($b));
				}

					$DATA['TANGGAL'] = $DATA['TANGGAL'];
					$DATA['KETERANGAN'] = $DATA['KETERANGAN'];

					// print_r($DATA); die();

					$this->db->insert('t_hari_libur', $DATA);

				if($id!=""){
					$error += 1;
					$message = "Data gagal diproses";
				}else{
					/*$QUERY = "SELECT ID FROM t_repohdr
							  WHERE KD_ASAL_BRG  = ".$this->db->escape(trim($DATA['KD_ASAL_BRG']))."
							  AND NO_VOY_FLIGHT = ".$this->db->escape(trim($DATA['NO_VOY_FLIGHT']))."
							  AND CALL_SIGN = ".$this->db->escape(trim($DATA['CALL_SIGN']))."
							  AND TGL_TIBA = ".$this->db->escape(trim($DATA['TGL_TIBA']));
					$QUERY = "SELECT * FROM t_jadwal_kapal";
					$result = $this->db->query($QUERY);
					if($result){
						$result = $this->db->insert('t_jadwal_kapal', $DATA);
						$ID = $this->db->insert_id();
						if(!$result){
							$error += 1;
							$message = "Data gagal diproses";
						}
					}*/
				}
				if($error == 0){
					//$func->main->get_log("add","t_repohdr");
					echo "MSG#OK#Data berhasil diproses#".$this->input->post('action');
				}else{
					echo "MSG#ERR#".$message."#";
				}
			}else if($act == "manual_karantina"){
				foreach($this->input->post('DATA') as $a => $b){
					if($b=="") unset($DATA[$a]);
					else $DATA[$a] = trim($b);
				}
				
				$kd_dok = $DATA['KD_DOK_INOUT'];
				$no_dok = $DATA['NO_DOK_INOUT'];
				$tgl_dok = $DATA['TGL_DOK_INOUT'];
				
				
				$SQLCekData = $this->db->query("SELECT A.* , B.NAMA
												FROM t_permit_hdr A
												INNER JOIN reff_kode_dok_bc B ON A.KD_DOK_INOUT = B.ID
												WHERE A.KD_DOK_INOUT = '$kd_dok' AND A.NO_DOK_INOUT = '$no_dok' AND A.TGL_DOK_INOUT = '$tgl_dok'")->row();
				$cek = count($SQLCekData);
				
				if($this->input->post('indexkon') != NULL || $this->input->post('indexkon') != ""){
					$DATA0['JENIS_DOK'] = "SPPMP";
					$DATA0['NO_IJIN'] = $DATA['NO_IJIN'];
					$DATA0['TGL_IJIN'] = $DATA['TGL_IJIN'];
					$DATA0['WK_REKAM'] = date('Y-m-d');
					$DATA0['NPWP'] = $DATA['NPWP'];
					$DATA0['NM_TRADER'] = $DATA['CONSIGNEE'];
					$DATA0['ALM_TRADER'] = $DATA['ALAMAT'];
					$this->db->insert('t_lic_hdr', $DATA0);

					$total = $this->db->query("SELECT MAX(ID_IJIN) AS TOTAL FROM t_lic_hdr")->row()->TOTAL;

					$DATA1['ANGKUTNAMA_TPS'] = $DATA['NM_KAPAL'];
					$DATA1['ANGKUTNAMA'] = $DATA['NM_KAPAL'];
					$DATA1['ANGKUTNO_TPS'] = $DATA['VOYAGE'];
					$DATA1['ANGKUTNO'] = $DATA['VOYAGE'];
					$DATA1['NO_RESPON'] = $DATA['NO_IJIN'];
					$DATA1['TG_RESPON'] = $DATA['TGL_IJIN'];
					$DATA1['TG_TIBA'] = $DATA['TGL_TIBA'];
					$DATA1['TG_RESPON'] = $DATA['TGL_IJIN'];
					$DATA1['FL_MANUAL'] = "Y";
					$DATA1['OPERATOR'] = $this->session->userdata('USERLOGIN');
					$DATA1['ID_IJIN'] = $total;
					$this->db->insert('t_ppk_hdr', $DATA1);

					$addXml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?><PERSETUJUAN>
								<LICHEADER>
									<NPWP>".$DATA['NPWP']."</NPWP>
									<NM_TRADER>".$DATA['CONSIGNEE']."</NM_TRADER>
									<ALM_TRADER>".$DATA['ALAMAT']."</ALM_TRADER>
									<NO_IJIN>".$DATA['NO_IJIN']."</NO_IJIN>
									<TGL_IJIN>".preg_replace('/\D/', '', $DATA['TGL_IJIN'])."</TGL_IJIN>
									<KODE_IJIN></KODE_IJIN>
									<ID_GA></ID_GA>
								</LICHEADER>";

					$addXml .= "<KRTHDR>
									<KD_UPT></KD_UPT>
									<NO_DAFTPPK></NO_DAFTPPK>
									<TG_DAFTPPK></TG_DAFTPPK>
									<JN_RESPON></JN_RESPON>
									<NO_RESPON>".$DATA['NO_IJIN']."</NO_RESPON>
									<TG_RESPON>".preg_replace('/\D/', '', $DATA['TGL_IJIN'])."</TG_RESPON>
									<ISI_RESPON></ISI_RESPON>
									<NM__PARTNER></NM__PARTNER>
									<ALM_PARTNER></ALM_PARTNER>
									<NEG_PARNTER></NEG_PARNTER>
									<PEL_BKR></PEL_BKR>
									<PEL_MUAT></PEL_MUAT>
									<TMP_TIMBUN>NPCT</TMP_TIMBUN>
									<MODA></MODA>
									<ANGKUTNO></ANGKUTNO>
									<ANGKUTNAMA>".$DATA['NM_KAPAL']."</ANGKUTNAMA>
									<TG_TIBA>".preg_replace('/\D/', '', $DATA['TGL_TIBA'])."</TG_TIBA>
									<TMP_INSTALASI></TMP_INSTALASI>
							       	<ALM_INSTALASI></ALM_INSTALASI>
							       	<TUJ_MASUK></TUJ_MASUK>
							       	<DRH_TUJU></DRH_TUJU>
							       	<NEG_TUJU>ID</NEG_TUJU>
							       	<NM_JAB></NM_JAB>
							       	<NIP_JAB></NIP_JAB>
							       	<JAB></JAB>
								</KRTHDR>";

					$IDHEADER = $this->db->query("SELECT MAX(ID_IJIN) AS TOTAL FROM t_lic_hdr")->row()->TOTAL;
					if ($IDHEADER != "") {
						$indexcont = $this->input->post('indexkon');
						$arrayindexcont = explode(",", substr($indexcont, 1));
						$banyakcont = count($arrayindexcont);
						
						if ($banyakcont > 0) {
							$indexcont = $this->input->post('indexkon');
							$arrayindexcont = explode(",", substr($indexcont, 1));
							$banyakcont = count($arrayindexcont);

							$addXml .= "<CONTAINER>";
								for ($c = 0; $c < $banyakcont; $c++) {
									$indexcontid = $c;
									$indexcontid = $arrayindexcont[$c];
									foreach($this->input->post('KONTAINER'.$indexcontid) as $a => $b){
										if($b=="") unset($KONTAINER[$a]);
										else $KONTAINER[$a] = trim($b);
									}

									$DATA2['NO_CONT'] = $KONTAINER["KONTAINER"];
									$DATA2['UKURAN'] = $KONTAINER["UKURAN"];
									$DATA2['ISO_CODE'] = $KONTAINER["ISO"];
									$DATA2['TIPE_CONT'] = $KONTAINER["TIPE"];
									$DATA2['NO_TPFT'] = $KONTAINER["NO_TPFT"];
									$DATA2['TGL_TPFT'] = $KONTAINER["TGL_TPFT"];
									$DATA2['KD_GUDANG'] = "NPCT";
									$DATA2['KD_GUDANG_PERIKSA'] = "NTPK";
									$DATA2['ID_IJIN'] = $total;
									$NNULL = $this->input->post('KONTAINER');

									$addXml .= "<LOOP>
													<NO_CONT>".$KONTAINER["KONTAINER"]."</NO_CONT>
													<SEGEL></SEGEL>
													<UKURAN>".$KONTAINER["UKURAN"]."</UKURAN>
													<SP3UDKNO>".$KONTAINER["NO_TPFT"]."</SP3UDKNO>
													<SP3UDKTG>".preg_replace('/\D/', '', $KONTAINER["TGL_TPFT"])."</SP3UDKTG>
												</LOOP>";
									$this->db->insert('t_ppk_cont', $DATA2);
							}
							$addXml .= "</CONTAINER>";
						}
						$addXml .= "<KEMASAN></KEMASAN>";
					
						$DATA3['KD_DOK'] = "705";
						$DATA3['NO_DOK'] = $DATA["NO_BL"];
						$DATA3['TG_DOK'] = $DATA["TGL_BL"];
						$DATA3['ID_IJIN'] = $total;
						$this->db->insert('t_ppk_dok', $DATA3);
					
						$addXml .= "<DOKUMEN>
										<LOOP>
										<KD_DOK>".$DATA3['KD_DOK']."</KD_DOK>
										<NO_DOK>".$DATA["NO_BL"]."</NO_DOK>
										<TG_DOK>".preg_replace('/\D/', '', $DATA["TGL_BL"])."</TG_DOK>
										<NEG_DOK></NEG_DOK>
										</LOOP>
									</DOKUMEN>
						</PERSETUJUAN>";
						
						$dataArr = array(
							'METHOD' =>'setLicense',
							'USERNAME' =>'dokManual',
							'XML_REQUEST' => $addXml,
							'WK_REKAM' => date('Y-m-d H:i:s')
						);
						$this->db->insert('log_services',$dataArr);
					}else {
						$error += 1;
						$message .= " &raquo; Data Gagal Diproses";
					}
				}else{
					$error += 1;
					$message .= " Mohon Tambahkan Data Kontainer";
				}
				
				if($error == 0){
					echo "MSG#OK#Data berhasil diproses#".$this->input->post('action');
				}else{
					echo "MSG#ERR#".$message."#";
				}
			}else if($act=="user"){

				foreach($this->input->post('DATA') as $a => $b){
					if($b=="") unset($DATA[$a]);
					else $DATA[$a] = trim($b);
				}
				
				//print_r($DATA); die();
				$leng = strlen($DATA['PASS']);
				// echo  $leng; die();

				if ($leng >= 6) {
					$DATA['USER_NAME'] = $DATA['USER_NAME'];
					$DATA['NAMA'] = $DATA['NAMA'];
					$DATA['EMAIL'] = $DATA['EMAIL'];
					$DATA['PASS'] = md5($DATA['PASS']);
					$DATA['KD_GROUP'] = $DATA['KD_GROUP'];
					$DATA['STATUS'] = $DATA['STATUS'];
					$this->db->insert('reff_user', $DATA);
				}else{
					$error += 1;
					$message = "Password harus lebih atau sama dengan dari 8 Karakter !";
				}

				if($id!=""){
					$error += 1;
					$message = "Data gagal diproses";
				}else{
					/*$QUERY = "SELECT ID FROM t_repohdr
							  WHERE KD_ASAL_BRG  = ".$this->db->escape(trim($DATA['KD_ASAL_BRG']))."
							  AND NO_VOY_FLIGHT = ".$this->db->escape(trim($DATA['NO_VOY_FLIGHT']))."
							  AND CALL_SIGN = ".$this->db->escape(trim($DATA['CALL_SIGN']))."
							  AND TGL_TIBA = ".$this->db->escape(trim($DATA['TGL_TIBA']));
					$QUERY = "SELECT * FROM t_jadwal_kapal";
					$result = $this->db->query($QUERY);
					if($result){
						$result = $this->db->insert('t_jadwal_kapal', $DATA);
						$ID = $this->db->insert_id();
						if(!$result){
							$error += 1;
							$message = "Data gagal diproses";
						}
					}*/
				}
				if($error == 0){
					//$func->main->get_log("add","t_repohdr");
					echo "MSG#OK#Data berhasil diproses#".$this->input->post('action');
				}else{
					echo "MSG#ERR#".$message."#";
				}
			}else if($act=="delivery"){
				foreach($this->input->post('DATA') as $a => $b){
					if($b=="") unset($DATA[$a]);
					else $DATA[$a] = strtoupper(trim($b));
				}
				//print_r($DATA);die();
				$FORMAT_PAIDHTHRU = date('Y-m-d', strtotime($DATA['PAIDTHRU']));
				$seq = $this->db->query("SELECT MAX(id) AS 'urut' FROM req_delivery_hdr")->row()->urut;
				$norut = $seq + 1;
				$REQ = "DEL/".date('Y-m-d')."/".$norut;
				$DATA_HDR['ID_REQ'] = $REQ;
				$DATA_HDR['TGL_REQ'] = date('Y-m-d H:i:s');
				$DATA_HDR['JNS_DOK'] = "SPPB";
				$DATA_HDR['NO_DOK'] = $DATA['NO_DOK'];
				$DATA_HDR['TGL_DOK'] = $DATA['TGL_DOK'];
				$DATA_HDR['NO_DO'] =  $DATA['NO_DO'];
				$DATA_HDR['NO_BL'] = $DATA['NO_BL'];
				$DATA_HDR['NO_VOY'] = $DATA['VOYAGE'];
				$DATA_HDR['NM_KAPAL'] = $DATA['NM_KAPAL'];
				$DATA_HDR['NPWP'] = $DATA['NPWP'];
				$DATA_HDR['NO_NOTA_DELIVERY'] = "";
				$DATA_HDR['NO_REQUEST'] = '010.000-16.61000007';
				$DATA_HDR['OPERATOR'] = $this->session->userdata('USERLOGIN');
				$DATA_HDR['TGL_NOTA'] = "";
				$DATA_HDR['SUBTOTAL'] = "";
				$DATA_HDR['PPN'] = "";
				$DATA_HDR['TOTAL'] = "";
				$DATA_HDR['EXPIRED'] = $FORMAT_PAIDHTHRU;
				$DATA_HDR['PAID_STATUS'] = "";
				$DATA_HDR['PAID_DATE'] = "";
				$DATA_HDR['BANK_ID'] = "";
				$this->db->insert('req_delivery_hdr', $DATA_HDR);

				// $ID_SPPB = $DATA['ID'];
				// $this->db->where(array('ID' =>$ID_SPPB));
				// $this->db->update('t_permit_hdr', array('KD_STATUS_BIL' => '901'));

				$SQL_ADMIN = $this->db->query("SELECT * FROM m_tarif WHERE JENIS_BIAYA = 'ADMIN'")->row();
				$TARIF_ADMIN = $SQL_ADMIN->TARIF;
				$TARIF_ADMIN_ID = $SQL_ADMIN->TARIF_ID;
				$DATA_ADM['ID_REQ'] = $REQ;
				$DATA_ADM['TARIF_ID'] =	$TARIF_ADMIN_ID;
				$DATA_ADM['CHARGE'] = $TARIF_ADMIN;
				$DATA_ADM['TOTAL'] = $TARIF_ADMIN;

				$this->db->insert('req_delivery_dtl', $DATA_ADM);

				$PAID = $DATA['PAIDTHRU'];
				$NM_KAPAL = $DATA['NM_KAPAL'];
				$id_post = $this->input->post('cont_post');
				$arrid_post = explode(',', $id_post);
				$jumlah_dipilih = count($arrid_post);
				for($x=0; $x<$jumlah_dipilih; $x++){
					$DETAIL = array();
					$DETAIL_DENDASPPB = array();
					$SIZE = array();
					$arrid_val = explode('~',$arrid_post[$x]);
					foreach($this->input->post('DTL_'.$arrid_val[1]) as $a => $b){
						if($b=="") unset($DTL[$a]);
						else $DTL[$a] = strtoupper(trim($b));
					}
					$NO_CONT = $DTL['NO_CONT'];
					$SIZE = $DTL['UKR_CONT'];
					$TYPE = $DTL['TYPE'];
					$STATUS = $DTL['STATUS'];
					
					$ID_CONT = $DATA['ID'];
					$this->db->where(array('ID' =>$ID_CONT,'NO_CONT' =>$NO_CONT));
					$this->db->update('t_permit_cont', array('KD_STATUS_BIL' => '901'));

					$SQL = $this->db->query("SELECT * FROM m_tarif WHERE SIZE = '$SIZE' AND TYPE ='$TYPE' AND STATUS =  '$STATUS'")->row();

					$SQL_SPPB = $this->db->query("SELECT * FROM m_tarif WHERE SIZE = '$SIZE' AND TYPE ='$TYPE' AND STATUS =  '$STATUS' AND JENIS_BIAYA='SPPB'")->row();
					//echo $SQL_SPPB->TARIF_ID;die();
					$SQL_LO = $this->db->query("SELECT * FROM m_tarif WHERE SIZE = '$SIZE' AND STATUS =  '$STATUS' AND JENIS_BIAYA = 'LIFT ON'")->row();
					$SQL_MAX = $this->db->query("SELECT MAX(ID) AS ID FROM req_delivery_hdr")->row()->ID;
					//$WK_IN = $this->db->query("SELECT WK_IN FROM t_cocostscont WHERE NO_CONT = '$NO_CONT'")->row();
					$WK_IN = $this->db->query("SELECT WK_IN
												FROM t_cocostscont A
												INNER JOIN t_cocostshdr B
												ON A.ID = B.ID WHERE NO_CONT = '$NO_CONT' AND B.NM_ANGKUT = '$NM_KAPAL' AND WK_IN IS NOT NULL")->row();
												//print($this->db->last_query());
					$TGL_STATUS = $this->db->query("SELECT A.TGL_STATUS FROM t_permit_cont A, reff_status_cont B WHERE A.KD_STATUS = B.ID AND A.NO_CONT = '$NO_CONT'")->row();
					$TARIF_ID = $SQL->TARIF_ID;
					$MAX_ID = $SQL_MAX;
					$cek = $WK_IN->WK_IN;
					if($cek == NULL){
						$error += 1;
						echo "ERROR";
						$message = "Tgl Stacking Tidak Ada";
						echo "MSG#ERR#".$message."#";
						$this->db->where(array('ID' => SQL_MAX));
						$this->db->delete('req_delivery_hdr');
						die();
					} else {
						$in = $WK_IN->WK_IN;
					}

					//$in = $WK_IN->WK_IN;
					$tgl_stack = $in;
					$this->db->where(array('ID' => $MAX_ID));
					$this->db->update('req_delivery_hdr', array('TGL_STACK' => $in));

					$Charge = $SQL->TARIF;
					$FirstStack = $in;
					$format = $PAID;
					$PaidThru = date("Y-m-d", strtotime($format));

					$jam = date("Hi", strtotime($FirstStack));
					if ($jam > "1200") {
						$MasaBebas = date("Y-m-d", strtotime($FirstStack . "+1 days"));
					} else {
						$MasaBebas = date("Y-m-d", strtotime($FirstStack));
					}
					$SelisihMasaBebas = 0;
					$PenumpukanMasaBebas = $SelisihMasaBebas * ($Charge * 0);

					$Masa1 = date("Y-m-d", strtotime($MasaBebas . "+1 days"));
					//echo "Masa1 ".$Masa1;
					if($PaidThru >= $Masa1){
						$SelisihMasa1 = 1;
						$PenumpukanMasa1 = $SelisihMasa1 * ($Charge * 3);
					}

					$Masa2 = date("Y-m-d", strtotime($Masa1 . "+1 days"));
					if($PaidThru >= $Masa2){
						$SelisihMasa2 = 1;
						$PenumpukanMasa2 = $SelisihMasa2 * ($Charge * 6);
					}

					$Masa3Awal = date("Y-m-d", strtotime($Masa2 . "+1 days"));
					$Masa3Akhir = $PaidThru;
					if ($PaidThru >= $Masa3Awal) {
						$datetime1 = new DateTime($Masa3Awal);
						$datetime2 = new DateTime($Masa3Akhir);
						$difference = $datetime1->diff($datetime2);
						$selisihM44 = $difference->days;
						$selisihM4 = $selisihM44 + 1;
						$SelisihDateM3 = ($Masa3Akhir - $Masa3Awal) + 1;
						$PenumpukanMasa3 = $selisihM4 * ($Charge * 9);
					}

					$Total = $PenumpukanMasaBebas + $PenumpukanMasa1 + $PenumpukanMasa2 + $PenumpukanMasa3;
					//echo "Selisih ".$selisihM4." ";
					//echo "PENUMPUKAN MASA BEBAS 3 = ".$PenumpukanMasa3."<br>";
					/*echo "PENUMPUKAN MASA BEBAS = ".$PenumpukanMasaBebas."<br>";
					echo "PENUMPUKAN MASA BEBAS 1 = ".$PenumpukanMasa1."<br>";
					echo "PENUMPUKAN MASA BEBAS 2 = ".$PenumpukanMasa2."<br>";
					echo "PENUMPUKAN MASA BEBAS 3 = ".$PenumpukanMasa3."<br>";
					echo "Total = ".$Total;*/

					//die();

					$DETAIL['ID_REQ'] = $REQ;
					$DETAIL['NO_CONT'] = $DTL['NO_CONT'];
					$DETAIL['UKR_CONT'] = $DTL['UKR_CONT'];
					$DETAIL['ISO_CODE'] = $DTL['TYPE'];
					$DETAIL['STATUS'] = $DTL['STATUS'];
					$DETAIL['TARIF_ID'] = $TARIF_ID;
					$DETAIL['CHARGE'] = $Charge;
					$DETAIL['TOTAL_UNIT'] = NULL;
					$DETAIL['TOTAL'] = $Total;
					$DETAIL['PROSEN_M1'] = '0';
					$DETAIL['SELISIH_M1'] = $SelisihMasaBebas;
					$DETAIL['M1_START_DATE'] = $FirstStack;
					$DETAIL['M1_END_DATE'] = $FirstStack;
					$DETAIL['TOTAL_M1'] = $PenumpukanMasaBebas;
					$DETAIL['PROSEN_M2'] = '3';
					$DETAIL['SELISIH_M2'] = $SelisihMasa1;
					$DETAIL['M2_START_DATE'] = $Masa1;
					$DETAIL['M2_END_DATE'] = $Masa1;
					$DETAIL['TOTAL_M2'] = $PenumpukanMasa1;
					$DETAIL['PROSEN_M3'] = '6';
					$DETAIL['SELISIH_M3'] = $SelisihMasa2;
					$DETAIL['M3_START_DATE'] = $Masa2;
					$DETAIL['M3_END_DATE'] = $Masa2;
					$DETAIL['TOTAL_M3'] = $PenumpukanMasa2;
					$DETAIL['PROSEN_M4'] = '9';
					$DETAIL['SELISIH_M4'] = $selisihM4;
					$DETAIL['M4_START_DATE'] = $Masa3Awal;
					$DETAIL['M4_END_DATE'] = $Masa3Akhir;
					$DETAIL['TOTAL_M4'] = $PenumpukanMasa3;
					$DETAIL['WK_REKAM'] = date('Y-m-d H:i:s');
					//print_r($DETAIL);
					$this->db->insert('req_delivery_dtl',$DETAIL);

					#denda sppb
					$Charge_sppb = $SQL_SPPB->TARIF;
					$WkBilling = date('Y-m-d H:i:s');//'2017-05-13 11:00:00';
					$TglSPPB = $DATA['TGL_DOK'];
					$holiday = $this->db->query("SELECT * FROM t_hari_libur WHERE DATE_FORMAT(TANGGAL,'%Y-%m-%d') = '$TglSPPB'")->row();

					$check_libur = date('Y-m-d', strtotime($holiday->TANGGAL. ' + 1 days'));
					if ($check_libur->TANGGAL != NULL) {
						$CheckHariLibur = true;
					} else {
						$CheckHariLibur = false;
					}
					
					$CheckDaySppb = strtoupper(trim(date("D", strtotime($TglSPPB))));
					$day = strtoupper(trim(date("D", strtotime($WkBilling))));
					echo "day ".$day;
					$TglBilling = strtoupper(trim(date("Y-m-d", strtotime($WkBilling))));
					echo "TglBilling ".$TglBilling;
					$TglStack = strtoupper(trim(date("Y-m-d", strtotime($FirstStack))));
					echo "TglStack ".$TglStack;
					if($TglSPPB != $TglBilling){
						if ($TglSPPB <= $TglStack) {
							$JumlahMasaBebas = 3; // 3 hari
							$datetime1 = new DateTime($TglBilling);
							$datetime2 = new DateTime($TglStack);
							$difference = $datetime1->diff($datetime2);
							$selisihM44 = $difference->days;
							$selisihM4 = $selisihM44 + 1;
							$RangeDate = $selisihM4;//($TglBilling - $TglStack) + 1;
							echo "rangedate ".$RangeDate;
						}
						else{
							if (($day == "SUN") || ($day == "SAT") || ($CheckHariLibur) || ($CheckDaySppb == "FRI") || ($CheckDaySppb == "SAT")) {
								$JumlahMasaBebas = 4; // 3 hari
							}
							else{
								$JumlahMasaBebas = 3; // 2 hari
							}
							$datetime1 = new DateTime($TglBilling);
							$datetime2 = new DateTime($TglSPPB);
							$difference = $datetime1->diff($datetime2);
							$selisihM44 = $difference->days;
							$selisihM46 = $selisihM44 + 1;
							$RangeDate = $selisihM46;
						}
						echo "rangedate ".$RangeDate;
						echo "JumlahMasaBebas ".$JumlahMasaBebas;

						$SelisihMasaBebas = $RangeDate - $JumlahMasaBebas;
						$SelisihDateM1 = 0;
						$SelisihDateM2 = 0;
						$SelisihDateM3 = 0;
						$SelisihDateM4 = 0;
						 echo "SelisihMasaBebas ".$SelisihMasaBebas;
						if ($SelisihMasaBebas > 0) {
							$startDenda = date("Y-m-d", strtotime($TglBilling . "-" . $SelisihMasaBebas . " days"));
							echo "startDenda ".$startDenda;
							$Total_DENDA = 0;
							$DendaM1 = 0;
							$DendaM2 = 0;
							$DendaM3 = 0;
							$DendaM4 = 0;
							$MasaBebasDendaSPPB = NULL;
							$Masa1DendaSPPB = NULL;
							$Masa2DendaSPPB = NULL;
							$Masa3AwalDendaSPPB = NULL;
							$Masa3AkhirDendaSPPB = NULL;
							echo "Denda1 = ".$DendaM1;
							echo "Denda2 = ".$DendaM2;
							echo "Denda3 = ".$DendaM3;
							echo "Denda4 = ".$DendaM4;
							echo "Total Denda = ".$Total_DENDA;
							echo "No Kont ".$DTL['NO_CONT'];
							for ($c = 0; $c <= $SelisihMasaBebas; $c++) {
								echo "mampir sini";
								$checkDate = date("Y-m-d", strtotime($TglBilling . "-" . $c . " days"));
								if ($checkDate == $MasaBebas) {
									$SelisihDateM1 = 0;
									$DendaM1 = $SelisihDateM1 * (($Charge_sppb * 0) * 2);
									$MasaBebasDendaSPPB = $startDenda;
								}
								if ($checkDate == $Masa1) {
									$SelisihDateM2 = 1;
									$DendaM2 = $SelisihDateM2 * (($Charge_sppb * 3) * 2);
									$Masa1DendaSPPB = $startDenda;
								}
								if ($checkDate == $Masa2) {
									$SelisihDateM3 = 1;
									$DendaM3 = $SelisihDateM3 * (($Charge_sppb * 6) * 2);
									$Masa2DendaSPPB = $startDenda;
								}
								if (($checkDate >= $Masa3Awal) && ($checkDate <= $Masa3Akhir)) {
									$SelisihDateM4++;
									$DendaM4 = $DendaM4 + (($Charge_sppb * 9) * 2);
									if($SelisihMasaBebas==1){
										$Masa3AwalDendaSPPB = $checkDate;
										$Masa3AkhirDendaSPPB = $checkDate;
										$cek = "sini SelisihMasaBebas==1";
									}
									else{
										if($c==0){
											$Masa3AkhirDendaSPPB = $TglBilling;
											$cek = "sini Masa3AkhirDendaSPPB = TglBilling";
										}
										else{
											$Masa3AwalDendaSPPB = $checkDate;
										}
									}
								}
							}
							echo "cek Masa3AwalDendaSPPB".$cek;
							/**/$Total_DENDA = $DendaM1 + $DendaM2 + $DendaM3 + $DendaM4;
							echo "Denda1 = ".$DendaM1;
							echo "Denda2 = ".$DendaM2;
							echo "Denda3 = ".$DendaM3;
							echo "Denda4 = ".$DendaM4;
							echo "Total Denda = ".$Total_DENDA;
							echo "MasaBebasDendaSPPB = ".$MasaBebasDendaSPPB;
							echo "Masa1DendaSPPB = ".$Masa1DendaSPPB;
							echo "Masa2DendaSPPB = ".$Masa2DendaSPPB;
							echo "Masa3AwalDendaSPPB = ".$Masa3AwalDendaSPPB;
							echo "Masa3AkhirDendaSPPB = ".$Masa3AkhirDendaSPPB;
						}
					}
					echo "Total Denda2 = ".$Total_DENDA;//die();

					if ($Total_DENDA > 0){
						$DETAIL_DENDASPPB['ID_REQ'] = $REQ;
						$DETAIL_DENDASPPB['NO_CONT'] = $DTL['NO_CONT'];
						$DETAIL_DENDASPPB['UKR_CONT'] = $DTL['UKR_CONT'];
						$DETAIL_DENDASPPB['ISO_CODE'] = $DTL['TYPE'];
						$DETAIL_DENDASPPB['STATUS'] = $DTL['STATUS'];
						$DETAIL_DENDASPPB['TARIF_ID'] = $SQL_SPPB->TARIF_ID;;
						$DETAIL_DENDASPPB['CHARGE'] = $Charge_sppb;
						$DETAIL_DENDASPPB['TOTAL_UNIT'] = NULL;
						$DETAIL_DENDASPPB['TOTAL'] = $Total_DENDA;
						$DETAIL_DENDASPPB['PROSEN_M1'] = '0';
						$DETAIL_DENDASPPB['SELISIH_M1'] = $SelisihDateM1;
						$DETAIL_DENDASPPB['M1_START_DATE'] = $MasaBebasDendaSPPB;
						$DETAIL_DENDASPPB['M1_END_DATE'] = $MasaBebasDendaSPPB;
						$DETAIL_DENDASPPB['TOTAL_M1'] = $DendaM1;
						$DETAIL_DENDASPPB['PROSEN_M2'] = '3';
						$DETAIL_DENDASPPB['SELISIH_M2'] = $SelisihDateM2;
						$DETAIL_DENDASPPB['M2_START_DATE'] = $Masa1DendaSPPB;
						$DETAIL_DENDASPPB['M2_END_DATE'] = $Masa1DendaSPPB;
						$DETAIL_DENDASPPB['TOTAL_M2'] = $DendaM2;
						$DETAIL_DENDASPPB['PROSEN_M3'] = '6';
						$DETAIL_DENDASPPB['SELISIH_M3'] = $SelisihDateM3;
						$DETAIL_DENDASPPB['M3_START_DATE'] = $Masa2DendaSPPB;
						$DETAIL_DENDASPPB['M3_END_DATE'] = $Masa2DendaSPPB;
						$DETAIL_DENDASPPB['TOTAL_M3'] = $DendaM3;
						$DETAIL_DENDASPPB['PROSEN_M4'] = '9';
						$DETAIL_DENDASPPB['SELISIH_M4'] = $SelisihDateM4;
						$DETAIL_DENDASPPB['M4_START_DATE'] = $Masa3AwalDendaSPPB;
						$DETAIL_DENDASPPB['M4_END_DATE'] = $Masa3AkhirDendaSPPB;
						$DETAIL_DENDASPPB['TOTAL_M4'] = $DendaM4;
						$DETAIL_DENDASPPB['WK_REKAM'] = date('Y-m-d H:i:s');
						print_r($DETAIL_DENDASPPB);
						$this->db->insert('req_delivery_dtl',$DETAIL_DENDASPPB);
					}
					//echo 'masuk sini';
					$NO_DOK = $DATA['NO_DOK'];
					$SQL_SP2 = $this->db->query("SELECT * FROM m_tarif WHERE SIZE = '$SIZE' AND TYPE ='$TYPE' AND STATUS =  '$STATUS' AND JENIS_BIAYA='SP2'")->row();
					$COUNT_CONT = $this->db->query("SELECT COUNT(A.NO_CONT) AS 'NO_CONT'
													FROM t_permit_cont A, req_delivery_hdr B, t_permit_hdr C
													WHERE C.NO_DOK_INOUT = B.NO_DOK
													AND C.ID = A.ID
													AND C.NO_DOK_INOUT ='$NO_DOK'")->row()->NO_CONT;
					$Charge_sp2 = $SQL_SP2->TARIF;
					echo "Tarif SP2 ".$Charge_sp2." ". $SQL_SP2->TARIF_ID;
				    $WkBilling = date('Y-m-d H:i:s');//'2016-11-23 11:00:00';
				    $JumlahKontainerPerBL = $COUNT_CONT;
				   echo "jum cont ".$JumlahKontainerPerBL;
				    if ($JumlahKontainerPerBL > 30) {
				        $JumlahMasaBebas = 4;
				        //echo "JumlahKontainerPerBL ".$JumlahKontainerPerBL;
				    } else {
				        $JumlahMasaBebas = 2;
				        //echo "JumlahKontainerPerBL ".$JumlahKontainerPerBL;
				    }

				    $TglBilling = strtoupper(trim(date("Y-m-d", strtotime($WkBilling))));
				    $datePaidThru = new DateTime($PaidThru);
				    $dateBilling = new DateTime($TglBilling);
				    $difference = $datePaidThru->diff($dateBilling);
				    $selisih = $difference->days;
				    $GetDateDiff = $selisih + 1;
				    $RangeDate = $GetDateDiff;//GetDateDiff($PaidThru, $TglBilling) + 1;
				    echo "RangeDate ".$RangeDate;
				    if ($RangeDate > $JumlahMasaBebas) {
				        $SelisihMasaBebas = $RangeDate - $JumlahMasaBebas;
				        echo "SelisihMasaBebas ".$SelisihMasaBebas;
				        $SelisihDateM1Sp2 = 0;
				        $SelisihDateM2Sp2 = 0;
				        $SelisihDateM3Sp2 = 0;
				        $SelisihDateM4Sp2 = 0;
				        $DendaM1Sp2 = 0;
				        $DendaM2Sp2 = 0;
				        $DendaM3Sp2 = 0;
				        $DendaM4Sp2 = 0;
				        $TotalDendaSp2 = 0;
						$MasaBebasDendaSP2 = NULL;
						$Masa1DendaSP2 = NULL;
						$Masa2DendaSP2 = NULL;
						$Masa3AwalDendaSP2 = NULL;
						$Masa3AkhirDendaSP2 = NULL;
				        if ($SelisihMasaBebas > 0) {
				            for ($c = 0; $c < $SelisihMasaBebas; $c++) {
				                $checkDate = date("Y-m-d", strtotime($PaidThru . "-" . $c . " days"));
				                echo "checkDate ".$checkDate;
				                if ($checkDate == $MasaBebas) {
				                    $SelisihDateM1Sp2 = 0;
				                    $DendaM1Sp2 = $SelisihDateM1Sp2 * (($Charge_sp2 * 0) * 3);
				                    $MasaBebasDendaSP2 = $checkDate;
				                }
				                if ($checkDate == $Masa1) {
				                    $SelisihDateM2Sp2 = 1;
				                    $DendaM2Sp2 = $SelisihDateM2Sp2 * (($Charge_sp2 * 3) * 3);
				                    $Masa1DendaSP2 = $checkDate;
				                }
				                if ($checkDate == $Masa2) {
				                    $SelisihDateM3Sp2 = 1;
				                    $DendaM3Sp2 = $SelisihDateM3Sp2 * (($Charge_sp2 * 6) * 3);
				                    $Masa2DendaSP2 = $checkDate;
				                }
				                if (($checkDate >= $Masa3Awal) && ($checkDate <= $Masa3Akhir)) {
				                    $SelisihDateM4Sp2++;
				                    $DendaM4Sp2 = $DendaM4Sp2 + (($Charge_sp2 * 9) * 3);
				                    if($SelisihMasaBebas==1){
										$Masa3AwalDendaSP2 = $checkDate;
										$Masa3AkhirDendaSP2 = $checkDate;
									}
									else{
										if($c==0){
											$Masa3AkhirDendaSP2 = $PaidThru;
										}
										else{
											$Masa3AwalDendaSP2 = $checkDate;
										}
									}
				                }
				            }
				            $TotalDendaSp2 = $DendaM1Sp2 + $DendaM2Sp2 + $DendaM3Sp2 + $DendaM4Sp2;
				        }
				    }
				    /*echo "TotalDendaSp2 ".$TotalDendaSp2;
				    echo "Masa 3 awal ". $Masa3Awal;
				    echo "Masa 3 akhir ". $Masa3Akhir;
				    echo "Masa 3 awal denda ". $Masa3AwalDendaSP2;
				    echo "Masa 3 akhir denda ". $Masa3AkhirDendaSP2;*/
				    if ($TotalDendaSp2 > 0){
						$DENDA_SP2['ID_REQ'] = $REQ;
						$DENDA_SP2['NO_CONT'] = $DTL['NO_CONT'];
						$DENDA_SP2['UKR_CONT'] = $DTL['UKR_CONT'];
						$DENDA_SP2['ISO_CODE'] = $DTL['TYPE'];
						$DENDA_SP2['STATUS'] = $DTL['STATUS'];
						$DENDA_SP2['TARIF_ID'] = $SQL_SP2->TARIF_ID;
						$DENDA_SP2['CHARGE'] = $Charge_sp2;
						$DENDA_SP2['TOTAL_UNIT'] = NULL;
						$DENDA_SP2['TOTAL'] = $TotalDendaSp2;
						$DENDA_SP2['PROSEN_M1'] = '0';
						$DENDA_SP2['SELISIH_M1'] = $SelisihDateM1Sp2;
						$DENDA_SP2['M1_START_DATE'] = $MasaBebasDendaSP2;
						$DENDA_SP2['M1_END_DATE'] = $MasaBebasDendaSP2;
						$DENDA_SP2['TOTAL_M1'] = $DendaM1Sp2;
						$DENDA_SP2['PROSEN_M2'] = '3';
						$DENDA_SP2['SELISIH_M2'] = $SelisihDateM2Sp2;
						$DENDA_SP2['M2_START_DATE'] = $Masa1DendaSP2;
						$DENDA_SP2['M2_END_DATE'] = $Masa1DendaSP2;
						$DENDA_SP2['TOTAL_M2'] = $DendaM2Sp2;
						$DENDA_SP2['PROSEN_M3'] = '6';
						$DENDA_SP2['SELISIH_M3'] = $SelisihDateM3Sp2;
						$DENDA_SP2['M3_START_DATE'] = $Masa2DendaSP2;
						$DENDA_SP2['M3_END_DATE'] = $Masa2DendaSP2;
						$DENDA_SP2['TOTAL_M3'] = $DendaM3Sp2;
						$DENDA_SP2['PROSEN_M4'] = '9';
						$DENDA_SP2['SELISIH_M4'] = $SelisihDateM4Sp2;
						$DENDA_SP2['M4_START_DATE'] = $Masa3AwalDendaSP2;
						$DENDA_SP2['M4_END_DATE'] = $Masa3AkhirDendaSP2;
						$DENDA_SP2['TOTAL_M4'] = $DendaM4Sp2;
						$DENDA_SP2['WK_REKAM'] = date('Y-m-d H:i:s');
						print_r($DENDA_SP2);
						$this->db->insert('req_delivery_dtl',$DENDA_SP2);
					}

					$TARIF_ID_LO = $SQL_LO->TARIF_ID;
					$TARIF_LO = $SQL_LO->TARIF;
					$DATA_LO['ID_REQ'] = $REQ;
					$DATA_LO['NO_CONT'] = $DTL['NO_CONT'];
					$DATA_LO['UKR_CONT'] = $DTL['UKR_CONT'];
					$DATA_LO['ISO_CODE'] = $DTL['TYPE'];
					$DATA_LO['STATUS'] = $DTL['STATUS'];
					$DATA_LO['TARIF_ID'] = $TARIF_ID_LO;
					$DATA_LO['CHARGE'] = $TARIF_LO;
					$DATA_LO['TOTAL_UNIT'] = NULL;
					$DATA_LO['TOTAL'] = $TARIF_LO;
					$DATA_LO['WK_REKAM'] = date('Y-m-d H:i:s');

					$this->db->insert('req_delivery_dtl', $DATA_LO);

					//EDITBILLING
					$SUM_MAX_ID = $this->db->query("SELECT ID_REQ AS 'ID' FROM req_delivery_dtl WHERE ID_REQ IN
													(SELECT ID_REQ FROM req_delivery_dtl WHERE SUBSTRING(ID_REQ, 16) =
													(SELECT IFNULL(COUNT(id_req),1) AS 'urut' FROM req_delivery_hdr))")->row()->ID;
					//print_r($SUM_MAX_ID);die();
					$sub_total = $this->db->query("SELECT SUM(TOTAL) AS TOTAL FROM req_delivery_dtl WHERE ID_REQ = '$REQ'")->row()->TOTAL;
					//echo "SUBTOTAL ".$sub_total;
					$PPN = $sub_total * 0.1;
					if($sub_total >= 1000000){
						$MAT = 6000;
					} else {
						$MAT = 3000;
					}
					$TOTAL_ALL = $MAT + $sub_total + $PPN;

					$DATA_HDR_UP['BIAYA_MATERAI'] = $MAT;
					$DATA_HDR_UP['SUBTOTAL'] = $sub_total;
					$DATA_HDR_UP['PPN'] = $PPN;
					$DATA_HDR_UP['TOTAL'] = $TOTAL_ALL;

					$this->db->where(array('ID' => $MAX_ID));
					$this->db->update('req_delivery_hdr', $DATA_HDR_UP);
				}

				//die();

				if($error==0){
					echo "MSG#OK#Data berhasil diproses#".site_url()."/billing/delivery/post";
				}else{
					echo "MSG#ERR#".$message."#";
				}
			}else if($act=="delivery_ext"){
				//print_r($id);die();
				foreach($this->input->post('DATA') as $a => $b){
					if($b=="") unset($DATA[$a]);
					else $DATA[$a] = strtoupper(trim($b));
					///$jumlah_dipilih = count($DATA['NO_CONT']);
				}
				//print_r($this->input->post('cont_post'));die();
				//$count = count($DATA);
				//print_r($count);die();
				$req = $this->db->query("SELECT MAX(ID_REQ) AS 'REQ' FROM req_delivery_hdr
		 								 WHERE ID_REQ LIKE 'DEL%'")->row()->REQ;
				//$req = $this->db->query("SELECT MAX(ID_REQ) AS 'REQ' FROM req_delivery_hdr")->row()->REQ;

				$seq = $this->db->query("SELECT MAX(id) AS 'urut' FROM req_delivery_hdr")->row()->urut;
				$norut = $seq + 1;
				$REQ = "EXT/".date('Y-m-d')."/".$norut;
				$DATA_HDR['ID_REQ'] = $REQ;//$DATA['NO_REQ'];
				$DATA_HDR['TGL_REQ'] = date('Y-m-d H:i:s');
				$DATA_HDR['JNS_DOK'] = "SPPB";
				$DATA_HDR['NO_DOK'] = $DATA['NO_DOK'];
				$DATA_HDR['TGL_DOK'] = $DATA['TGL_DOK'];
				$DATA_HDR['NO_DO'] = $DATA['NO_DO'];
				$DATA_HDR['NO_BL'] = $DATA['NO_BL'];
				$DATA_HDR['NO_VOY'] = $DATA['VOYAGE'];
				$DATA_HDR['NM_KAPAL'] = $DATA['NM_KAPAL'];
				$DATA_HDR['NPWP'] = $DATA['NPWP'];
				$DATA_HDR['NO_NOTA_DELIVERY'] = "";
				$DATA_HDR['NO_REQUEST'] = '010.000-16.61000007';
				$DATA_HDR['OPERATOR'] = $this->session->userdata('USERLOGIN');
				$DATA_HDR['ID_REQ_OLD'] = $req;
				$DATA_HDR['TGL_NOTA'] = "";
				$DATA_HDR['SUBTOTAL'] = "";
				$DATA_HDR['PPN'] = "";
				$DATA_HDR['TOTAL'] = "";
				$DATA_HDR['EXPIRED'] = date('Y-m-d',strtotime($DATA['PAIDTHRU']));
				$DATA_HDR['PAID_STATUS'] = "";
				$DATA_HDR['PAID_DATE'] = "";
				$DATA_HDR['BANK_ID'] = "";

				//print_r($DATA_HDR);die();

				$this->db->insert('req_delivery_hdr', $DATA_HDR);

				$SQL_ADMIN = $this->db->query("SELECT * FROM m_tarif WHERE JENIS_BIAYA = 'ADMIN'")->row();
				$TARIF_ADMIN = $SQL_ADMIN->TARIF;
				$TARIF_ADMIN_ID = $SQL_ADMIN->TARIF_ID;
				$DATA_ADM['ID_REQ'] = $REQ;
				$DATA_ADM['TARIF_ID'] =	$TARIF_ADMIN_ID;
				$DATA_ADM['CHARGE'] = $TARIF_ADMIN;
				$DATA_ADM['TOTAL'] = $TARIF_ADMIN;

				$this->db->insert('req_delivery_dtl', $DATA_ADM);

				$PAID = $DATA['PAIDTHRU'];
				$id_post = $this->input->post('cont_post');
				$arrid_post = explode(',', $id_post);
				$jumlah_dipilih = count($arrid_post);
				for($x=0; $x<$jumlah_dipilih; $x++){
					$arrid_val = explode('~',$arrid_post[$x]);
					foreach($this->input->post('DTL_'.$arrid_val[1]) as $a => $b){
						if($b=="") unset($DTL[$a]);
						else $DTL[$a] = strtoupper(trim($b));
					}
					$NO_CONT = $DTL['NO_CONT'];
					$SIZE = $DTL['UKR_CONT'];
					$TYPE = $DTL['TYPE'];
					$STATUS = $DTL['STATUS'];
					$SQL = $this->db->query("SELECT * FROM m_tarif WHERE SIZE = '$SIZE' AND TYPE ='$TYPE' AND STATUS =  '$STATUS'")->row();
					$SQL_MAX = $this->db->query("SELECT MAX(ID) AS ID FROM req_delivery_hdr")->row()->ID;
					$TGL_STATUS = $this->db->query("SELECT A.TGL_STATUS FROM t_permit_cont A, reff_status_cont B WHERE A.KD_STATUS = B.ID AND A.NO_CONT = '$NO_CONT'")->row();
					$TARIF_ID = $SQL->TARIF_ID;
					$MAX_ID = $SQL_MAX;

					$SUM_MAX_ID = $this->db->query("SELECT MAX(ID_REQ) AS 'ID' FROM req_delivery_dtl")->row()->ID;
					$IDREQ = $DATA['ID'];
					$SQL_END = $this->db->query("SELECT DISTINCT DATE_FORMAT(M4_END_DATE, '%d-%m-%Y') AS END
												FROM req_delivery_dtl
												WHERE ID_REQ = '$SUM_MAX_ID'
												AND M4_END_DATE IS NOT NULL")->row()->END;
					$SQL_PAID = $this->db->query("SELECT EXPIRED AS PAID
												  FROM req_delivery_hdr
												  WHERE ID_REQ = '$IDREQ'")->row()->PAID;
					$SQL_STACK = $this->db->query("SELECT DISTINCT M1_START_DATE AS FIRSTACK
												  FROM req_delivery_dtl
												  WHERE ID_REQ = '$IDREQ'
												  AND M1_START_DATE IS NOT NULL")->row()->FIRSTACK;
					$SQL_TGL_BILLING_LAMA = $this->db->query("SELECT DISTINCT TGL_REQ AS 'TGL_BILLING'
													 FROM req_delivery_hdr
													 WHERE ID_REQ = '$IDREQ'")->row()->TGL_BILLING;

					$billing_lama = date('Y-m-d',strtotime($SQL_TGL_BILLING_LAMA));

					$Charge = $SQL->TARIF;
					echo "TARIF ".$Charge;
					$format = $PAID;
					$FirstStackAwal = $SQL_STACK;
					echo "FirstStackAwal ".$FirstStackAwal;
					$PaidThruOld = $SQL_PAID;
					echo "PaidThruOld ".$PaidThruOld;
					$FirstStack = date('Y-m-d', strtotime($FirstStackAwal));
					echo "FirstStack ".$FirstStack;
					$PaidThru = date("Y-m-d", strtotime($format));
					echo "PaidThru ".$PaidThru;

					$jam = date("Hi", strtotime($FirstStack));
					if ($jam > "1200") {
						$MasaBebas = date("Y-m-d", strtotime($FirstStack . "+1 days"));
					} else {
						$MasaBebas = date("Y-m-d", strtotime($FirstStack));
					}
					echo "Masa Bebas ".$MasaBebas;
					$SelisihMasaBebas = 0;
					$PenumpukanMasaBebas = $SelisihMasaBebas * ($Charge * 0);

					$Masa1 = date("Y-m-d", strtotime($MasaBebas . "+1 days"));
					echo "Masa1 ".$Masa1;
					if(($PaidThruOld < $Masa1) && ($PaidThru >= $Masa1)){
						$SelisihMasa1 = 1;
						echo "SelisihMasa1 ".$SelisihMasa1;
						$PenumpukanMasa1 = $SelisihMasa1 * ($Charge * 3);
					}

					$Masa2 = date("Y-m-d", strtotime($Masa1 . "+1 days"));
					echo "Masa2 ".$Masa2;
					if(($PaidThruOld < $Masa2) && ($PaidThru >= $Masa2)){
						$SelisihMasa2 = 1;
						echo "SelisihMasa2 ".$SelisihMasa2;
						$PenumpukanMasa2 = $SelisihMasa2 * ($Charge * 6);
					}

					$Masa3Awal = date("Y-m-d", strtotime($Masa2 . "+1 days"));
					$Masa3Akhir = $PaidThru;
					if (($PaidThruOld < $Masa3Awal) && ($PaidThru >= $Masa3Awal)) {
						//$selisihM4 = $Masa3Akhir - $Masa3Awal;
						$datetime1 = new DateTime($Masa3Akhir);
					    $datetime2 = new DateTime($PaidThruOld);
					    $difference = $datetime1->diff($datetime2);
					    $range = $difference->days;
					    //$selisihM3 = $range + 1;
					    $selisihM3 = $range;
					    echo "selisihM3 ".$selisihM3;
					    //echo "Selisih M4 ".$selisihM3." ";
						//echo "Selisih M4 ".$Masa3Awal ." - ".$Masa3Akhir." ";
						$SelisihDateM3 = ($Masa3Akhir - $Masa3Awal) + 1;
						$PenumpukanMasa3 = $selisihM3 * ($Charge * 9);
					}else {
	                    if ($PaidThruOld < $PaidThru) {
	                    	$datetime1 = new DateTime($PaidThru);
						    $datetime2 = new DateTime($PaidThruOld);
						    $difference = $datetime1->diff($datetime2);
						    $range = $difference->days;
						    //$selisihM3 = $range + 1;
						    $selisihM3 = $range;
						    echo "selisihM3 ".$selisihM3;

	                        //$SelisihDateM3 = $this->GetDateDiff($this->PaidThru, $this->PaidThruOld);
	                        //$SelisihDateM3 = ($Masa3Akhir - $Masa3Awal) + 1;
	                        $PenumpukanMasa3 = $selisihM3 * ($Charge * 9);
	                    }
	                }

					$Total = $PenumpukanMasaBebas + $PenumpukanMasa1 + $PenumpukanMasa2 + $PenumpukanMasa3;

					echo "PENUMPUKAN MASA BEBAS = ".$PenumpukanMasaBebas."<br>";
					echo "PENUMPUKAN MASA BEBAS 1 = ".$PenumpukanMasa1."<br>";
					echo "PENUMPUKAN MASA BEBAS 2 = ".$PenumpukanMasa2."<br>";
					echo "PENUMPUKAN MASA BEBAS 3 = ".$PenumpukanMasa3."<br>";
					echo "Total = ".$Total;

					/*if ($Total > 0) {
						# code...
					}*/

					//die();

					$DETAIL['ID_REQ'] = $REQ;
					$DETAIL['NO_CONT'] = $DTL['NO_CONT'];
					$DETAIL['UKR_CONT'] = $DTL['UKR_CONT'];
					$DETAIL['ISO_CODE'] = $DTL['TYPE'];
					$DETAIL['STATUS'] = $DTL['STATUS'];
					$DETAIL['TARIF_ID'] = $TARIF_ID;
					$DETAIL['CHARGE'] = $Charge;
					$DETAIL['TOTAL_UNIT'] = NULL;
					$DETAIL['TOTAL'] = $Total;
					$DETAIL['PROSEN_M1'] = '0';
					$DETAIL['SELISIH_M1'] = $SelisihMasaBebas;
					$DETAIL['M1_START_DATE'] = $FirstStack;
					$DETAIL['M1_END_DATE'] = $FirstStack;
					$DETAIL['TOTAL_M1'] = $PenumpukanMasaBebas;
					$DETAIL['PROSEN_M2'] = '3';
					$DETAIL['SELISIH_M2'] = $SelisihMasa1;
					$DETAIL['M2_START_DATE'] = $Masa1;
					$DETAIL['M2_END_DATE'] = $Masa1;
					$DETAIL['TOTAL_M2'] = $PenumpukanMasa1;
					$DETAIL['PROSEN_M3'] = '6';
					$DETAIL['SELISIH_M3'] = $SelisihMasa2;
					$DETAIL['M3_START_DATE'] = $Masa2;
					$DETAIL['M3_END_DATE'] = $Masa2;
					$DETAIL['TOTAL_M3'] = $PenumpukanMasa2;
					$DETAIL['PROSEN_M4'] = '9';
					$DETAIL['SELISIH_M4'] = $selisihM3;
					$DETAIL['M4_START_DATE'] = date("Y-m-d", strtotime($PaidThruOld . "+1 days"));//$PaidThruOld;
					$DETAIL['M4_END_DATE'] = $PaidThru;
					$DETAIL['TOTAL_M4'] = $PenumpukanMasa3;
					$DETAIL['WK_REKAM'] = date('Y-m-d H:i:s');
					print_r($DETAIL);
					$this->db->insert('req_delivery_dtl',$DETAIL);

					$NO_DOK = $DATA['NO_DOK'];
					$SQL_SP2 = $this->db->query("SELECT * FROM m_tarif WHERE SIZE = '$SIZE' AND TYPE ='$TYPE' AND STATUS =  '$STATUS' AND JENIS_BIAYA='SP2'")->row();
					$COUNT_CONT = $this->db->query("SELECT COUNT(A.NO_CONT) AS 'NO_CONT'
													FROM t_permit_cont A, req_delivery_hdr B, t_permit_hdr C
													WHERE C.NO_DOK_INOUT = B.NO_DOK
													AND C.ID = A.ID
													AND C.NO_DOK_INOUT ='$NO_DOK'")->row()->NO_CONT;
					$Charge_sp2 = $SQL_SP2->TARIF;
					echo "Tarif SP2 ".$Charge_sp2." ". $SQL_SP2->TARIF_ID;
				    $WkBilling = date('Y-m-d H:i:s');//'2016-11-23 11:00:00';
				    $JumlahKontainerPerBL = $COUNT_CONT;//'10';
				   	echo "jum cont ".$JumlahKontainerPerBL;
				    //$PaidThru = '2016-11-26';
				    $CekdatePaidThruOld = new DateTime($PaidThruOld);
				    $CekdateBillLama = new DateTime($billing_lama);
				    $difference = $CekdatePaidThruOld->diff($CekdateBillLama);
				    $selisih = $difference->days;
				    $GetDateDiff = $selisih;
				    echo "PaidThruOld ". $PaidThruOld;
				    echo "billing_lama ". $billing_lama;
				    echo "Selsih billing ". $GetDateDiff;//die();
				   	//$CEK_BILL = GetDateDiff($PaidThruOld, $billing_lama);

				   	if ($JumlahKontainerPerBL > 30) {
			        	$JumlahMasaBebas = 4;
				        //echo "JumlahKontainerPerBL ".$JumlahKontainerPerBL;
				    } else {
				        $JumlahMasaBebas = 2;
				        //echo "JumlahKontainerPerBL ".$JumlahKontainerPerBL;
				    }

				    //if ($GetDateDiff > $JumlahMasaBebas) {
				    	//$TglBilling = strtoupper(trim(date("Y-m-d", strtotime($WkBilling))));
					    $datePaidThru = new DateTime($PaidThru);
					    $datePaidThruOld = new DateTime($PaidThruOld);
					    $difference = $datePaidThru->diff($datePaidThruOld);
					    $selisih = $difference->days;
					    $GetDateDiff = $selisih;
					    echo "Selisih masa bebas".$GetDateDiff;
					    $RangeDate = $GetDateDiff;//GetDateDiff($PaidThru, $TglBilling) + 1;
				   // }

				    echo "RangeDate ".$RangeDate;
				    //if ($RangeDate > $JumlahMasaBebas) {
				        //$SelisihMasaBebas = $RangeDate - $JumlahMasaBebas;
				   	if ($GetDateDiff >= $JumlahMasaBebas) {
				   		$SelisihMasaBebas = $RangeDate;
				        echo "SelisihMasaBebas ".$SelisihMasaBebas;
				        $SelisihDateM1Sp2 = 0;
				        $SelisihDateM2Sp2 = 0;
				        $SelisihDateM3Sp2 = 0;
				        $SelisihDateM4Sp2 = 0;
				        $DendaM1Sp2 = 0;
				        $DendaM2Sp2 = 0;
				        $DendaM3Sp2 = 0;
				        $DendaM4Sp2 = 0;
				        $TotalDendaSp2 = 0;
						$MasaBebasDendaSP2 = NULL;
						$Masa1DendaSP2 = NULL;
						$Masa2DendaSP2 = NULL;
						$Masa3AwalDendaSP2 = NULL;
						$Masa3AkhirDendaSP2 = NULL;
				        if ($SelisihMasaBebas > 0) {
				            for ($c = 0; $c < $SelisihMasaBebas; $c++) {
				                $checkDate = date("Y-m-d", strtotime($PaidThru . "-" . $c . " days"));
				                echo "checkDate ".$checkDate;
				                if ($checkDate == $MasaBebas) {
				                    $SelisihDateM1Sp2 = 0;
				                    $DendaM1Sp2 = $SelisihDateM1Sp2 * (($Charge_sp2 * 0) * 3);
				                    $MasaBebasDendaSP2 = $checkDate;
				                }
				                if ($checkDate == $Masa1) {
				                    $SelisihDateM2Sp2 = 1;
				                    $DendaM2Sp2 = $SelisihDateM2Sp2 * (($Charge_sp2 * 3) * 3);
				                    $Masa1DendaSP2 = $checkDate;
				                }
				                if ($checkDate == $Masa2) {
				                    $SelisihDateM3Sp2 = 1;
				                    $DendaM3Sp2 = $SelisihDateM3Sp2 * (($Charge_sp2 * 6) * 3);
				                    $Masa2DendaSP2 = $checkDate;
				                }
				                if (($checkDate >= $Masa3Awal) && ($checkDate <= $Masa3Akhir)) {
				                    $SelisihDateM4Sp2++;
				                    //$SelisihDateM4Sp2 = $SelisihDateM4Sp2 - 1;
				                    $DendaM4Sp2 = $DendaM4Sp2 + (($Charge_sp2 * 9) * 3);
				                    if($SelisihMasaBebas==1){
										$Masa3AwalDendaSP2 = $checkDate;
										$Masa3AkhirDendaSP2 = $checkDate;
									}
									else{
										if($c==0){
											$Masa3AkhirDendaSP2 = $PaidThru;
										}
										else{
											$Masa3AwalDendaSP2 = $checkDate;
										}
									}
				                }
				            }
				            $TotalDendaSp2 = $DendaM1Sp2 + $DendaM2Sp2 + $DendaM3Sp2 + $DendaM4Sp2;
				        }
				    }
				    echo "TotalDendaSp2 ".$TotalDendaSp2;
				    echo "Masa 3 awal ". $Masa3Awal;
				    echo "Masa 3 akhir ". $Masa3Akhir;
				    echo "Masa 3 awal denda ". $Masa3AwalDendaSP2;
				    echo "Masa 3 akhir denda ". $Masa3AkhirDendaSP2;
				    if ($TotalDendaSp2 > 0){
						$DENDA_SP2['ID_REQ'] = $REQ;
						$DENDA_SP2['NO_CONT'] = $DTL['NO_CONT'];
						$DENDA_SP2['UKR_CONT'] = $DTL['UKR_CONT'];
						$DENDA_SP2['ISO_CODE'] = $DTL['TYPE'];
						$DENDA_SP2['STATUS'] = $DTL['STATUS'];
						$DENDA_SP2['TARIF_ID'] = $SQL_SP2->TARIF_ID;
						$DENDA_SP2['CHARGE'] = $Charge_sp2;
						$DENDA_SP2['TOTAL_UNIT'] = NULL;
						$DENDA_SP2['TOTAL'] = $TotalDendaSp2;
						$DENDA_SP2['PROSEN_M1'] = '0';
						$DENDA_SP2['SELISIH_M1'] = $SelisihDateM1Sp2;
						$DENDA_SP2['M1_START_DATE'] = $MasaBebasDendaSP2;
						$DENDA_SP2['M1_END_DATE'] = $MasaBebasDendaSP2;
						$DENDA_SP2['TOTAL_M1'] = $DendaM1Sp2;
						$DENDA_SP2['PROSEN_M2'] = '3';
						$DENDA_SP2['SELISIH_M2'] = $SelisihDateM2Sp2;
						$DENDA_SP2['M2_START_DATE'] = $Masa1DendaSP2;
						$DENDA_SP2['M2_END_DATE'] = $Masa1DendaSP2;
						$DENDA_SP2['TOTAL_M2'] = $DendaM2Sp2;
						$DENDA_SP2['PROSEN_M3'] = '6';
						$DENDA_SP2['SELISIH_M3'] = $SelisihDateM3Sp2;
						$DENDA_SP2['M3_START_DATE'] = $Masa2DendaSP2;
						$DENDA_SP2['M3_END_DATE'] = $Masa2DendaSP2;
						$DENDA_SP2['TOTAL_M3'] = $DendaM3Sp2;
						$DENDA_SP2['PROSEN_M4'] = '9';
						$DENDA_SP2['SELISIH_M4'] = $SelisihDateM4Sp2;
						$DENDA_SP2['M4_START_DATE'] = date("Y-m-d", strtotime($PaidThruOld . "+1 days"));//$PaidThruOld;
						$DENDA_SP2['M4_END_DATE'] = $Masa3AkhirDendaSP2;
						$DENDA_SP2['TOTAL_M4'] = $DendaM4Sp2;
						$DENDA_SP2['WK_REKAM'] = date('Y-m-d H:i:s');
						print_r($DENDA_SP2);
						$this->db->insert('req_delivery_dtl',$DENDA_SP2);
					}

					$SUM_MAX_ID = $this->db->query("SELECT MAX(ID_REQ) AS 'ID' FROM req_delivery_dtl WHERE ID_REQ LIKE 'EXT%'")->row()->ID;

					$sub_total = $this->db->query("SELECT SUM(TOTAL) AS TOTAL FROM req_delivery_dtl WHERE ID_REQ = '$SUM_MAX_ID'")->row()->TOTAL;
					$PPN = $sub_total * 0.1;
					if($sub_total >= 1000000){
						$MAT = 6000;
					} else {
						$MAT = 3000;
					}
					$TOTAL_ALL = $MAT + $sub_total + $PPN;
					//print_r("materai".$MAT);die();

					$DATA_HDR_UP['BIAYA_MATERAI'] = $MAT;
					$DATA_HDR_UP['SUBTOTAL'] = $sub_total;
					$DATA_HDR_UP['PPN'] = $PPN;
					$DATA_HDR_UP['TOTAL'] = $TOTAL_ALL;

					$this->db->where(array('ID' => $MAX_ID));
					$this->db->update('req_delivery_hdr', $DATA_HDR_UP);

					//echo $STATUS;
					//$SQL_EXT = $this->db->query("");
				}
				//die("okes");
					//print_r($sub_total);die();

					echo "MSG#OK#Data berhasil diproses#".site_url()."/billing/delivery_ext/post";//$this->input->post('action');
					//die();
			}else if($act=="simulasi"){
				foreach($this->input->post('DATA') as $a => $b){
					if($b=="") unset($DATA[$a]);
					else $DATA[$a] = strtoupper(trim($b));
					///$jumlah_dipilih = count($DATA['NO_CONT']);
				}
				//print_r($DATA);die();
				$FORMAT_PAIDHTHRU = date('Y-m-d', strtotime($DATA['PAIDTHRU']));
				//echo $FORMAT_PAIDHTHRU;die();
				//$count = count($DATA);
				//print_r($count);die();
				$seq = $this->db->query("SELECT MAX(id) AS 'urut' FROM req_simulasi_hdr")->row()->urut;
				$norut = $seq + 1;
				$REQ = "DEL/".date('Y-m-d')."/".$norut;
				$DATA_HDR['ID_REQ'] = $REQ;//$DATA['NO_REQ'];
				$DATA_HDR['TGL_REQ'] = date('Y-m-d H:i:s');
				$DATA_HDR['JNS_DOK'] = "SPPB";
				$DATA_HDR['NO_DOK'] = $DATA['NO_DOK'];
				$DATA_HDR['TGL_DOK'] = $DATA['TGL_DOK'];
				$DATA_HDR['NO_DO'] =  $DATA['NO_DO'];;
				$DATA_HDR['NO_BL'] = $DATA['NO_BL'];
				$DATA_HDR['NO_VOY'] = $DATA['VOYAGE'];
				$DATA_HDR['NM_KAPAL'] = $DATA['NM_KAPAL'];
				$DATA_HDR['NPWP'] = $DATA['NPWP'];
				$DATA_HDR['NO_NOTA_DELIVERY'] = "";
				$DATA_HDR['NO_REQUEST'] = '010.000-16.61000007';
				$DATA_HDR['TGL_NOTA'] = "";
				$DATA_HDR['SUBTOTAL'] = "";
				$DATA_HDR['PPN'] = "";
				$DATA_HDR['TOTAL'] = "";
				$DATA_HDR['EXPIRED'] = $FORMAT_PAIDHTHRU;
				$DATA_HDR['PAID_STATUS'] = "";
				$DATA_HDR['PAID_DATE'] = "";
				$DATA_HDR['BANK_ID'] = "";
				//print_r($DATA_HDR);die();
				$this->db->insert('req_simulasi_hdr', $DATA_HDR);

				$ID_SPPB = $DATA['ID'];
				//print_r($ID_SPPB);die();
				#$this->db->where(array('ID' =>$ID_SPPB));
				#$this->db->update('t_permit_hdr', array('KD_STATUS_BIL' => '901'));

				/*foreach($this->input->post('DTL[]') as $a => $b){
					foreach($b as $value){
						if($value=="") unset($DTL[$a]);
						else $DTL[$a][] = strtoupper(trim($value));
					}
				}*/

				$SQL_ADMIN = $this->db->query("SELECT * FROM m_tarif WHERE JENIS_BIAYA = 'ADMIN'")->row();
				$TARIF_ADMIN = $SQL_ADMIN->TARIF;
				$TARIF_ADMIN_ID = $SQL_ADMIN->TARIF_ID;
				$DATA_ADM['ID_REQ'] = $REQ;
				$DATA_ADM['TARIF_ID'] =	$TARIF_ADMIN_ID;
				$DATA_ADM['CHARGE'] = $TARIF_ADMIN;
				$DATA_ADM['TOTAL'] = $TARIF_ADMIN;

				$this->db->insert('req_simulasi_dtl', $DATA_ADM);

				//$jumlah_dipilih = count($DTL['NO_CONT']);
				//print_r($jumlah_dipilih);die();
				$PAID = $DATA['PAIDTHRU'];
				$id_post = $this->input->post('cont_post');
				$arrid_post = explode(',', $id_post);
				$jumlah_dipilih = count($arrid_post);
				//print_r($jumlah_dipilih);die();
				for($x=0; $x<$jumlah_dipilih; $x++){
					//$DETAIL = array();
					//$DETAIL_DENDASPPB = array();
					//$SIZE = array();
					$arrid_val = explode('~',$arrid_post[$x]);
					//print_r($arrid_val);die();
					foreach($this->input->post('DTL_'.$arrid_val[1]) as $a => $b){
						if($b=="") unset($DTL[$a]);
						else $DTL[$a] = strtoupper(trim($b));
					}
					//print_r($DTL);die();
					$NO_CONT = $DTL['NO_CONT'];
					$SIZE = $DTL['UKR_CONT'];
					$TYPE = $DTL['TYPE'];
					$STATUS = $DTL['STATUS'];
					//print_r($DTL);//die();
					//print_r("No kont ".$NO_CONT);die();

					$SQL = $this->db->query("SELECT * FROM m_tarif WHERE SIZE = '$SIZE' AND TYPE ='$TYPE' AND STATUS =  '$STATUS'")->row();

					$SQL_SPPB = $this->db->query("SELECT * FROM m_tarif WHERE SIZE = '$SIZE' AND TYPE ='$TYPE' AND STATUS =  '$STATUS' AND JENIS_BIAYA='SPPB'")->row();
					//echo $SQL_SPPB->TARIF_ID;die();
					$SQL_LO = $this->db->query("SELECT * FROM m_tarif WHERE SIZE = '$SIZE' AND STATUS =  '$STATUS' AND JENIS_BIAYA = 'LIFT ON'")->row();
					$SQL_MAX = $this->db->query("SELECT MAX(ID) AS ID FROM req_simulasi_hdr")->row()->ID;
					$WK_IN = $this->db->query("SELECT WK_IN FROM t_cocostscont WHERE NO_CONT = '$NO_CONT'")->row();
					$TGL_STATUS = $this->db->query("SELECT A.TGL_STATUS FROM t_permit_cont A, reff_status_cont B WHERE A.KD_STATUS = B.ID AND A.NO_CONT = '$NO_CONT'")->row();
					$TARIF_ID = $SQL->TARIF_ID;
					$MAX_ID = $SQL_MAX;
					$cek = $WK_IN->WK_IN;
					if($cek == NULL){
						$error += 1;
						echo "ERROR";
						$message = "Data Stacking Kontainer Belum Tersedia";
						echo "MSG#ERR#".$message."#";
						$this->db->where(array('ID' => $SQL_MAX));
						$this->db->delete('req_simulasi_hdr');
						die();
					} else {
						$in = $WK_IN->WK_IN;
					}

					//$in = $WK_IN->WK_IN;

					$Charge = $SQL->TARIF;
					$FirstStack = $in;//'2016-11-23 11:00:00';//
					$format = $PAID;
					$PaidThru = date("Y-m-d", strtotime($format));
					//echo $format;die();

					/*$Charge = '13200';
					$FirstStack = '2016-11-23 11:00:00';
					$PaidThru = '2016-11-26';*/

					$jam = date("Hi", strtotime($FirstStack));
					if ($jam > "1200") {
						$MasaBebas = date("Y-m-d", strtotime($FirstStack . "+1 days"));
					} else {
						$MasaBebas = date("Y-m-d", strtotime($FirstStack));
					}
					$SelisihMasaBebas = 0;
					$PenumpukanMasaBebas = $SelisihMasaBebas * ($Charge * 0);

					$Masa1 = date("Y-m-d", strtotime($MasaBebas . "+1 days"));
					//echo "Masa1 ".$Masa1;
					if($PaidThru >= $Masa1){
						$SelisihMasa1 = 1;
						$PenumpukanMasa1 = $SelisihMasa1 * ($Charge * 3);
					}

					$Masa2 = date("Y-m-d", strtotime($Masa1 . "+1 days"));
					if($PaidThru >= $Masa2){
						$SelisihMasa2 = 1;
						$PenumpukanMasa2 = $SelisihMasa2 * ($Charge * 6);
					}

					$Masa3Awal = date("Y-m-d", strtotime($Masa2 . "+1 days"));
					$Masa3Akhir = $PaidThru;
					if ($PaidThru >= $Masa3Awal) {
						//$selisihM4 = $Masa3Akhir - $Masa3Awal;
						$datetime1 = new DateTime($Masa3Awal);
						$datetime2 = new DateTime($Masa3Akhir);
						$difference = $datetime1->diff($datetime2);
						$selisihM44 = $difference->days;
						$selisihM4 = $selisihM44 + 1;
						//echo "Selisih M4 ".$selisihM4." ";
						//echo "Selisih M4 ".$Masa3Awal ." - ".$Masa3Akhir." ";
						$SelisihDateM3 = ($Masa3Akhir - $Masa3Awal) + 1;
						$PenumpukanMasa3 = $selisihM4 * ($Charge * 9);
					}

					$Total = $PenumpukanMasaBebas + $PenumpukanMasa1 + $PenumpukanMasa2 + $PenumpukanMasa3;
					echo "Selisih ".$selisihM4." ";
					echo "PENUMPUKAN MASA BEBAS 3 = ".$PenumpukanMasa3."<br>";
					/*echo "PENUMPUKAN MASA BEBAS = ".$PenumpukanMasaBebas."<br>";
					echo "PENUMPUKAN MASA BEBAS 1 = ".$PenumpukanMasa1."<br>";
					echo "PENUMPUKAN MASA BEBAS 2 = ".$PenumpukanMasa2."<br>";
					echo "PENUMPUKAN MASA BEBAS 3 = ".$PenumpukanMasa3."<br>";
					echo "Total = ".$Total;*/

					//die();

					$DETAIL['ID_REQ'] = $REQ;
					$DETAIL['NO_CONT'] = $DTL['NO_CONT'];
					$DETAIL['UKR_CONT'] = $DTL['UKR_CONT'];
					$DETAIL['ISO_CODE'] = $DTL['TYPE'];
					$DETAIL['STATUS'] = $DTL['STATUS'];
					$DETAIL['TARIF_ID'] = $TARIF_ID;
					$DETAIL['CHARGE'] = $Charge;
					$DETAIL['TOTAL_UNIT'] = NULL;
					$DETAIL['TOTAL'] = $Total;
					$DETAIL['PROSEN_M1'] = '0';
					$DETAIL['SELISIH_M1'] = $SelisihMasaBebas;
					$DETAIL['M1_START_DATE'] = $FirstStack;
					$DETAIL['M1_END_DATE'] = $FirstStack;
					$DETAIL['TOTAL_M1'] = $PenumpukanMasaBebas;
					$DETAIL['PROSEN_M2'] = '3';
					$DETAIL['SELISIH_M2'] = $SelisihMasa1;
					$DETAIL['M2_START_DATE'] = $Masa1;
					$DETAIL['M2_END_DATE'] = $Masa1;
					$DETAIL['TOTAL_M2'] = $PenumpukanMasa1;
					$DETAIL['PROSEN_M3'] = '6';
					$DETAIL['SELISIH_M3'] = $SelisihMasa2;
					$DETAIL['M3_START_DATE'] = $Masa2;
					$DETAIL['M3_END_DATE'] = $Masa2;
					$DETAIL['TOTAL_M3'] = $PenumpukanMasa2;
					$DETAIL['PROSEN_M4'] = '9';
					$DETAIL['SELISIH_M4'] = $selisihM4;
					$DETAIL['M4_START_DATE'] = $Masa3Awal;
					$DETAIL['M4_END_DATE'] = $Masa3Akhir;
					$DETAIL['TOTAL_M4'] = $PenumpukanMasa3;
					$DETAIL['WK_REKAM'] = date('Y-m-d H:i:s');
					//print_r($DETAIL);
					$this->db->insert('req_simulasi_dtl',$DETAIL);

					#denda sppb
					$Charge_sppb = $SQL_SPPB->TARIF;
					echo "Chargea = ".$Charge;
					$WkBilling = date('Y-m-d H:i:s');//'2016-11-23 11:00:00';
					echo "Wk billing ".$WkBilling;
					$TglSPPB = $DATA['TGL_DOK'];//'2016-11-23';
					echo "TglSPPB ".$TglSPPB;
					//$CheckHariLibur = true;
					$holiday = $this->db->query("SELECT * FROM t_hari_libur WHERE DATE_FORMAT(TANGGAL,'%Y-%m-%d') = '$TglSPPB'")->row();
					echo "holiday  ".$holiday->TANGGAL;
					$check_libur = date('Y-m-d', strtotime($holiday->TANGGAL. ' + 1 days'));
					//date("Y-m-d", strtotime($holiday . "+1 days"));
					//echo "TglSPPB +1  ".$check_libur;//die();
					echo "hari libur".$check_libur;
					if ($check_libur->TANGGAL != NULL) {
						$CheckHariLibur = true;
					} else {
						$CheckHariLibur = false;
					}

				   // $FirstStack = '2016-11-23 11:00:00';

					$day = strtoupper(trim(date("D", strtotime($WkBilling))));
					echo "day ".$day;
					$TglBilling = strtoupper(trim(date("Y-m-d", strtotime($WkBilling))));
					echo "TglBilling ".$TglBilling;
					$TglStack = strtoupper(trim(date("Y-m-d", strtotime($FirstStack))));
					echo "TglStack ".$TglStack;
					if($TglSPPB != $TglBilling){
						if ($TglSPPB <= $TglStack) {
							$JumlahMasaBebas = 3; // 3 hari
							$datetime1 = new DateTime($TglBilling);
							$datetime2 = new DateTime($TglStack);
							$difference = $datetime1->diff($datetime2);
							$selisihM44 = $difference->days;
							$selisihM4 = $selisihM44 + 1;
							$RangeDate = $selisihM4;//($TglBilling - $TglStack) + 1;
							echo "rangedate ".$RangeDate;
						}
						else{
							if (($day == "SUN") || ($day == "SAT") || ($CheckHariLibur)) {
								$JumlahMasaBebas = 3; // 3 hari
							}
							else{
								$JumlahMasaBebas = 2; // 2 hari
							}
							$datetime1 = new DateTime($TglBilling);
							$datetime2 = new DateTime($TglSPPB);
							$difference = $datetime1->diff($datetime2);
							$selisihM44 = $difference->days;
							$selisihM46 = $selisihM44 + 1;
							$RangeDate = $selisihM46;
						}
						echo "JumlahMasaBebas ".$JumlahMasaBebas;

						$SelisihDateM1 = 0;
						$SelisihDateM2 = 0;
						$SelisihDateM3 = 0;
						$SelisihDateM4 = 0;
						$DendaM1 = 0;
						$DendaM2 = 0;
						$DendaM3 = 0;
						$DendaM4 = 0;
						$MasaBebasDendaSPPB = NULL;
						$Masa1DendaSPPB = NULL;
						$Masa2DendaSPPB = NULL;
						$Masa3AwalDendaSPPB = NULL;
						$Masa3AkhirDendaSPPB = NUL;
						$SelisihMasaBebas = $RangeDate - $JumlahMasaBebas;
						 echo "SelisihMasaBebas ".$SelisihMasaBebas;
						if ($SelisihMasaBebas > 0) {
							$startDenda = date("Y-m-d", strtotime($TglBilling . "-" . $SelisihMasaBebas . " days"));
							echo "startDenda ".$startDenda;	L;
							$Total_DENDA_SPPB = 0;
							echo "Denda1 = ".$DendaM1;
							echo "Denda2 = ".$DendaM2;
							echo "Denda3 = ".$DendaM3;
							echo "Denda4 = ".$DendaM4;
							echo "Total Denda = ".$Total_DENDA_SPPB;
							echo "No Kont ".$DTL['NO_CONT'];
							for ($c = 0; $c <= $SelisihMasaBebas; $c++) {
								$checkDate = date("Y-m-d", strtotime($TglBilling . "-" . $c . " days"));
								if ($checkDate == $MasaBebas) {
									$SelisihDateM1 = 0;
									$DendaM1 = $SelisihDateM1 * (($Charge_sppb * 0) * 2);
									$MasaBebasDendaSPPB = $startDenda;
								}
								if ($checkDate == $Masa1) {
									$SelisihDateM2 = 1;
									$DendaM2 = $SelisihDateM2 * (($Charge_sppb * 3) * 2);
									$Masa1DendaSPPB = $startDenda;
								}
								if ($checkDate == $Masa2) {
									$SelisihDateM3 = 1;
									$DendaM3 = $SelisihDateM3 * (($Charge_sppb * 6) * 2);
									$Masa2DendaSPPB = $startDenda;
								}
								if (($checkDate >= $Masa3Awal) && ($checkDate <= $Masa3Akhir)) {
									$SelisihDateM4++;
									$DendaM4 = $DendaM4 + (($Charge_sppb * 9) * 2);
									if($SelisihMasaBebas==1){
										$Masa3AwalDendaSPPB = $checkDate;
										$Masa3AkhirDendaSPPB = $checkDate;
									}
									else{
										if($c==0){
											$Masa3AkhirDendaSPPB = $TglBilling;
										}
										else{
											$Masa3AwalDendaSPPB = $checkDate;
										}
									}
									/*if($startDenda == $checkDate){
										$Masa3AwalDendaSPPB = $startDenda;
										if($Masa3Awal == $Masa3Akhir){
											$Masa3AkhirDendaSPPB = $Masa3Akhir;
										}
									}
									if($Masa3Akhir == $checkDate){
										$Masa3AkhirDendaSPPB = $Masa3Akhir;
									}*/
								}
							}
							/**/$Total_DENDA_SPPB = $DendaM1 + $DendaM2 + $DendaM3 + $DendaM4;
							echo "Denda1 = ".$DendaM1;
							echo "Denda2 = ".$DendaM2;
							echo "Denda3 = ".$DendaM3;
							echo "Denda4 = ".$DendaM4;
							echo "Total Denda SPPB = ".$Total_DENDA_SPPB;
							echo "MasaBebasDendaSPPB = ".$MasaBebasDendaSPPB;
							echo "Masa1DendaSPPB = ".$Masa1DendaSPPB;
							echo "Masa2DendaSPPB = ".$Masa2DendaSPPB;
							echo "Masa3AwalDendaSPPB = ".$Masa3AwalDendaSPPB;
							echo "Masa3AkhirDendaSPPB = ".$Masa3AkhirDendaSPPB;
						}
					}
					//echo "Total Denda2 = ".$Total_DENDA_SPPB;die();

					if ($Total_DENDA_SPPB > 0){
						$DETAIL_DENDASPPB['ID_REQ'] = $REQ;
						$DETAIL_DENDASPPB['NO_CONT'] = $DTL['NO_CONT'];
						$DETAIL_DENDASPPB['UKR_CONT'] = $DTL['UKR_CONT'];
						$DETAIL_DENDASPPB['ISO_CODE'] = $DTL['TYPE'];
						$DETAIL_DENDASPPB['STATUS'] = $DTL['STATUS'];
						$DETAIL_DENDASPPB['TARIF_ID'] = $SQL_SPPB->TARIF_ID;;
						$DETAIL_DENDASPPB['CHARGE'] = $Charge_sppb;
						$DETAIL_DENDASPPB['TOTAL_UNIT'] = NULL;
						$DETAIL_DENDASPPB['TOTAL'] = $Total_DENDA_SPPB;
						$DETAIL_DENDASPPB['PROSEN_M1'] = '0';
						$DETAIL_DENDASPPB['SELISIH_M1'] = $SelisihDateM1;
						$DETAIL_DENDASPPB['M1_START_DATE'] = $MasaBebasDendaSPPB;
						$DETAIL_DENDASPPB['M1_END_DATE'] = $MasaBebasDendaSPPB;
						$DETAIL_DENDASPPB['TOTAL_M1'] = $DendaM1;
						$DETAIL_DENDASPPB['PROSEN_M2'] = '3';
						$DETAIL_DENDASPPB['SELISIH_M2'] = $SelisihDateM2;
						$DETAIL_DENDASPPB['M2_START_DATE'] = $Masa1DendaSPPB;
						$DETAIL_DENDASPPB['M2_END_DATE'] = $Masa1DendaSPPB;
						$DETAIL_DENDASPPB['TOTAL_M2'] = $DendaM2;
						$DETAIL_DENDASPPB['PROSEN_M3'] = '6';
						$DETAIL_DENDASPPB['SELISIH_M3'] = $SelisihDateM3;
						$DETAIL_DENDASPPB['M3_START_DATE'] = $Masa2DendaSPPB;
						$DETAIL_DENDASPPB['M3_END_DATE'] = $Masa2DendaSPPB;
						$DETAIL_DENDASPPB['TOTAL_M3'] = $DendaM3;
						$DETAIL_DENDASPPB['PROSEN_M4'] = '9';
						$DETAIL_DENDASPPB['SELISIH_M4'] = $SelisihDateM4;
						$DETAIL_DENDASPPB['M4_START_DATE'] = $Masa3AwalDendaSPPB;
						$DETAIL_DENDASPPB['M4_END_DATE'] = $Masa3AkhirDendaSPPB;
						$DETAIL_DENDASPPB['TOTAL_M4'] = $DendaM4;
						$DETAIL_DENDASPPB['WK_REKAM'] = date('Y-m-d H:i:s');
						print_r($DETAIL_DENDASPPB);
						$this->db->insert('req_simulasi_dtl',$DETAIL_DENDASPPB);
					}
					//echo 'masuk sini';
					$NO_DOK = $DATA['NO_DOK'];
					//print_r("No DOk". $NO_DOK);die();
					$SQL_SP2 = $this->db->query("SELECT * FROM m_tarif WHERE SIZE = '$SIZE' AND TYPE ='$TYPE' AND STATUS =  '$STATUS' AND JENIS_BIAYA='SP2'")->row();
					$COUNT_CONT = $this->db->query("SELECT COUNT(A.NO_CONT) AS 'NO_CONT'
													FROM t_permit_cont A, req_simulasi_hdr B, t_permit_hdr C
													WHERE C.NO_DOK_INOUT = B.NO_DOK
													AND C.ID = A.ID
													AND C.NO_DOK_INOUT ='$NO_DOK'")->row()->NO_CONT;

					$Charge_sp2 = $SQL_SP2->TARIF;
					echo "Tarif SP2 ".$Charge_sp2." ". $SQL_SP2->TARIF_ID;
				    $WkBilling = date('Y-m-d H:i:s');//'2016-11-23 11:00:00';
				    $JumlahKontainerPerBL = $COUNT_CONT;//'10';
				   echo "jum cont ".$JumlahKontainerPerBL;
				    //$PaidThru = '2016-11-26';

				    if ($JumlahKontainerPerBL > 30) {
				        $JumlahMasaBebas = 4;
				        //echo "JumlahKontainerPerBL ".$JumlahKontainerPerBL;
				    } else {
				        $JumlahMasaBebas = 2;
				        //echo "JumlahKontainerPerBL ".$JumlahKontainerPerBL;
				    }

			        $SelisihDateM1Sp2 = 0;
			        $SelisihDateM2Sp2 = 0;
			        $SelisihDateM3Sp2 = 0;
			        $SelisihDateM4Sp2 = 0;
			        $DendaM1Sp2 = 0;
			        $DendaM2Sp2 = 0;
			        $DendaM3Sp2 = 0;
			        $DendaM4Sp2 = 0;
			        $TotalDendaSp2 = 0;
					$MasaBebasDendaSP2 = NULL;
					$Masa1DendaSP2 = NULL;
					$Masa2DendaSP2 = NULL;
					$Masa3AwalDendaSP2 = NULL;
					$Masa3AkhirDendaSP2 = NULL;
				    $TglBilling = strtoupper(trim(date("Y-m-d", strtotime($WkBilling))));
				    $datePaidThru = new DateTime($PaidThru);
				    $dateBilling = new DateTime($TglBilling);
				    $difference = $datePaidThru->diff($dateBilling);
				    $selisih = $difference->days;
				    $GetDateDiff = $selisih + 1;
				    $RangeDate = $GetDateDiff;//GetDateDiff($PaidThru, $TglBilling) + 1;
				    echo "RangeDate ".$RangeDate;
				    if ($RangeDate > $JumlahMasaBebas) {
				        $SelisihMasaBebas = $RangeDate - $JumlahMasaBebas;
				        echo "SelisihMasaBebas ".$SelisihMasaBebas;
				        if ($SelisihMasaBebas > 0) {
				            for ($c = 0; $c < $SelisihMasaBebas; $c++) {
				                $checkDate = date("Y-m-d", strtotime($PaidThru . "-" . $c . " days"));
				                echo "checkDate ".$checkDate;
				                if ($checkDate == $MasaBebas) {
				                    $SelisihDateM1Sp2 = 0;
				                    $DendaM1Sp2 = $SelisihDateM1Sp2 * (($Charge_sp2 * 0) * 3);
				                    $MasaBebasDendaSP2 = $checkDate;
				                }
				                if ($checkDate == $Masa1) {
				                    $SelisihDateM2Sp2 = 1;
				                    $DendaM2Sp2 = $SelisihDateM2Sp2 * (($Charge_sp2 * 3) * 3);
				                    $Masa1DendaSP2 = $checkDate;
				                }
				                if ($checkDate == $Masa2) {
				                    $SelisihDateM3Sp2 = 1;
				                    $DendaM3Sp2 = $SelisihDateM3Sp2 * (($Charge_sp2 * 6) * 3);
				                    $Masa2DendaSP2 = $checkDate;
				                }
				                if (($checkDate >= $Masa3Awal) && ($checkDate <= $Masa3Akhir)) {
				                    $SelisihDateM4Sp2++;
				                    $DendaM4Sp2 = $DendaM4Sp2 + (($Charge_sp2 * 9) * 3);
				                    if($SelisihMasaBebas==1){
										$Masa3AwalDendaSP2 = $checkDate;
										$Masa3AkhirDendaSP2 = $checkDate;
									}
									else{
										if($c==0){
											$Masa3AkhirDendaSP2 = $PaidThru;
										}
										else{
											$Masa3AwalDendaSP2 = $checkDate;
										}
									}
				                    /*if($c == $SelisihMasaBebas){
										$Masa3AwalDendaSP2 = $checkDate;
										echo "Masa3AwalDendaSP2 ".$Masa3AwalDendaSP2;
				                    }
				                    if($c == 0){
										$Masa3AkhirDendaSP2 = $checkDate;
										echo "Masa3AkhirDendaSP2 ".$Masa3AkhirDendaSP2;
				                    }
									if($SelisihMasaBebas==1){
										$Masa3AkhirDendaSP2 = $checkDate;
										echo "Masa3AkhirDendaSP2 ".$Masa3AkhirDendaSP2;
									}*/
				                    /*if($Masa3Awal == $checkDate){
										$Masa3AwalDendaSP2 = $Masa3Awal;
										if($Masa3Awal == $Masa3Akhir){
											$Masa3AkhirDendaSP2 = $Masa3Awal;
										}
										if($SelisihMasaBebas==1){
											$Masa3AkhirDendaSP2 = $Masa3Awal;
										}
									}
									if($Masa3Akhir == $checkDate){
										$Masa3AkhirDendaSP2 = $Masa3Akhir;
										if($Masa3Awal == $Masa3Akhir){
											$Masa3AwalDendaSP2 = $Masa3Akhir;
										}
										if($SelisihMasaBebas==1){
											$Masa3AwalDendaSP2 = $Masa3Akhir;
										}
									}*/
				                }
				            }
				            $TotalDendaSp2 = $DendaM1Sp2 + $DendaM2Sp2 + $DendaM3Sp2 + $DendaM4Sp2;
				        }
				    }
				    echo "TotalDendaSp2 ".$TotalDendaSp2;
				    echo "Masa 3 awal ". $Masa3Awal;
				    echo "Masa 3 akhir ". $Masa3Akhir;
				    echo "Masa 3 awal denda ". $Masa3AwalDendaSP2;
				    echo "Masa 3 akhir denda ". $Masa3AkhirDendaSP2;
				    if ($TotalDendaSp2 > 0){
						$DENDA_SP2['ID_REQ'] = $REQ;
						$DENDA_SP2['NO_CONT'] = $DTL['NO_CONT'];
						$DENDA_SP2['UKR_CONT'] = $DTL['UKR_CONT'];
						$DENDA_SP2['ISO_CODE'] = $DTL['TYPE'];
						$DENDA_SP2['STATUS'] = $DTL['STATUS'];
						$DENDA_SP2['TARIF_ID'] = $SQL_SP2->TARIF_ID;
						$DENDA_SP2['CHARGE'] = $Charge_sp2;
						$DENDA_SP2['TOTAL_UNIT'] = NULL;
						$DENDA_SP2['TOTAL'] = $TotalDendaSp2;
						$DENDA_SP2['PROSEN_M1'] = '0';
						$DENDA_SP2['SELISIH_M1'] = $SelisihDateM1Sp2;
						$DENDA_SP2['M1_START_DATE'] = $MasaBebasDendaSP2;
						$DENDA_SP2['M1_END_DATE'] = $MasaBebasDendaSP2;
						$DENDA_SP2['TOTAL_M1'] = $DendaM1Sp2;
						$DENDA_SP2['PROSEN_M2'] = '3';
						$DENDA_SP2['SELISIH_M2'] = $SelisihDateM2Sp2;
						$DENDA_SP2['M2_START_DATE'] = $Masa1DendaSP2;
						$DENDA_SP2['M2_END_DATE'] = $Masa1DendaSP2;
						$DENDA_SP2['TOTAL_M2'] = $DendaM2Sp2;
						$DENDA_SP2['PROSEN_M3'] = '6';
						$DENDA_SP2['SELISIH_M3'] = $SelisihDateM3Sp2;
						$DENDA_SP2['M3_START_DATE'] = $Masa2DendaSP2;
						$DENDA_SP2['M3_END_DATE'] = $Masa2DendaSP2;
						$DENDA_SP2['TOTAL_M3'] = $DendaM3Sp2;
						$DENDA_SP2['PROSEN_M4'] = '9';
						$DENDA_SP2['SELISIH_M4'] = $SelisihDateM4Sp2;
						$DENDA_SP2['M4_START_DATE'] = $Masa3AwalDendaSP2;
						$DENDA_SP2['M4_END_DATE'] = $Masa3AkhirDendaSP2;
						$DENDA_SP2['TOTAL_M4'] = $DendaM4Sp2;
						$DENDA_SP2['WK_REKAM'] = date('Y-m-d H:i:s');
						print_r($DENDA_SP2);
						$this->db->insert('req_simulasi_dtl',$DENDA_SP2);
					}

					$TARIF_ID_LO = $SQL_LO->TARIF_ID;
					$TARIF_LO = $SQL_LO->TARIF;
					$DATA_LO['ID_REQ'] = $REQ;
					$DATA_LO['NO_CONT'] = $DTL['NO_CONT'];
					$DATA_LO['UKR_CONT'] = $DTL['UKR_CONT'];
					$DATA_LO['ISO_CODE'] = $DTL['TYPE'];
					$DATA_LO['STATUS'] = $DTL['STATUS'];
					$DATA_LO['TARIF_ID'] = $TARIF_ID_LO;
					$DATA_LO['CHARGE'] = $TARIF_LO;
					$DATA_LO['TOTAL_UNIT'] = NULL;
					$DATA_LO['TOTAL'] = $TARIF_LO;
					$DATA_LO['WK_REKAM'] = date('Y-m-d H:i:s');
					print_r($DATA_LO);
					//print_r($REQ." ".$TARIF_ID_LO." ".$TARIF_LO);die();

					$this->db->insert('req_simulasi_dtl', $DATA_LO);

					$SUM_MAX_ID = $this->db->query("SELECT MAX(ID_REQ) AS 'ID' FROM req_simulasi_dtl WHERE ID_REQ LIKE 'DEL%'")->row()->ID;
					//print_r($SUM_MAX_ID);die();
					$sub_total = $this->db->query("SELECT SUM(TOTAL) AS TOTAL FROM req_simulasi_dtl WHERE ID_REQ = '$SUM_MAX_ID'")->row()->TOTAL;
					//echo "SUBTOTAL ".$sub_total;
					$PPN = $sub_total * 0.1;
					if($sub_total >= 1000000){
						$MAT = 6000;
					} else {
						$MAT = 3000;
					}
					$TOTAL_ALL = $MAT + $sub_total + $PPN;
					///echo "Total ".$TOTAL_ALL;
					//print_r("materai".$MAT);die();

					$DATA_HDR_UP['BIAYA_MATERAI'] = $MAT;
					$DATA_HDR_UP['SUBTOTAL'] = $sub_total;
					$DATA_HDR_UP['PPN'] = $PPN;
					$DATA_HDR_UP['TOTAL'] = $TOTAL_ALL;

					$this->db->where(array('ID' => $MAX_ID));
					$this->db->update('req_simulasi_hdr', $DATA_HDR_UP);
				}

				if($error==0){
					echo "MSG#OK#Data berhasil diproses#".site_url()."/billing/cetak_simulasi/post";
				}else{
					echo "MSG#ERR#".$message."#";
				}
			}
		} else if($type == "update"){
			if($act=="kapal"){

				foreach($this->input->post('DATA') as $a => $b){
					if($b=="") unset($DATA[$a]);
					else $DATA[$a] = strtoupper(trim($b));
				}


				$eta=$DATA['ETA'];
				$etd=$DATA['ETD'];
				$cls=$DATA['CLS_TIME'];
				$os=$DATA['OPN_STACK'];
				$er=$DATA['EARLY_STACK'];

				if (strtotime($etd) <= strtotime($eta) ) {
					$error += 1;
					$message = "ETD HARUS LEBIH BESAR DARI ETA";
				}elseif (strtotime($eta) <= strtotime($os) ) {
					$error += 1;
					$message = "OPEN STACK HARUS LEBIH KECIL DARI ETA";
				}/*elseif (strtotime($er) >= strtotime($os)) {
					$error += 1;
					$message = "EARLY STACK HARUS LEBIH KECIL DARI OPEN STACK";
				}*/elseif (strtotime($cls) >= strtotime($etd)) {
					$error += 1;
					$message = "CLOSING TIME HARUS LEBIH KECIL DARI ETD";
				}else {
						//print_r($id);die();
					//print_r($DATA);die();
					$DATA['NM_KAPAL'] = $DATA['NM_KAPAL'];
					$DATA['NO_VOYAGE'] = $DATA['NO_VOYAGE'];
					$DATA['ETA'] = $DATA['ETA'];
					$DATA['ATA'] = $DATA['ATA'];
					$DATA['ETD'] = $DATA['ETD'];
					$DATA['ATD'] = $DATA['ATD'];
					$DATA['OPN_STACK'] = $DATA['OPN_STACK'];
					$DATA['NO_PPKB'] = $DATA['NO_PPKB'];
					$DATA['WK_DISCH'] = $DATA['WK_DISCH'];
					$DATA['JMLH_MUAT'] = $DATA['JMLH_MUAT'];
					$DATA['EARLY_STACK'] = $DATA['EARLY_STACK'];
					$DATA['CLS_TIME'] = $DATA['CLS_TIME'];

					//print_r($DATA);die();

					$this->db->where(array('ID' => $id));
					$result = $this->db->update('t_jadwal_kapal', $DATA);
					//print_r($resul);die();
					//$QUERY = "SELECT * FROM t_jadwal_kapal WHERE ID = '$id'";
						//$result = $this->db->query($QUERY);
				}


				if($error == 0){
					//$func->main->get_log("add","t_repohdr");
					echo "MSG#OK#Data berhasil diproses#".$this->input->post('action');
				}else{
					echo "MSG#ERR#".$message."#";
				}
			}else if($act == "customer2"){

				foreach($this->input->post('DATA') as $a => $b){
					if($b=="") unset($DATA[$a]);
					else $DATA[$a] = trim($b);
				}
				
				if($DATA['EMAIL'] == NULL){
					$DATA['EMAIL'] = '-';
				}else{
					$DATA['EMAIL'] = $DATA['EMAIL'];
				}
				
				$DATA['NPWP'] = $DATA['NPWP'];
				$DATA['NAMA_CUST'] = $DATA['NAMA_CUST'];
				$DATA['ALAMAT'] = $DATA['ALAMAT'];
				//$DATA['EMAIL'] = $DATA['EMAIL'];
				$DATA['TELEPON'] = $DATA['TELEPON'];
				$DATA['TLP_KANTOR'] = $DATA['TLP_KANTOR'];

				$this->emailnya($DATA['EMAIL'], $DATA['NAMA_CUST'], $PASS);
				$this->db->where(array('ID_CUST' => $id));
				$this->db->update('m_pelanggan', $DATA);
				if($id==""){
					$error += 1;
					$message = "Data gagal diproses";
				}else{

				}
				if($error == 0){
					//$func->main->get_log("add","t_repohdr");
					echo "MSG#OK#Data berhasil diproses#".$this->input->post('action');
				}else{
					echo "MSG#ERR#".$message."#";
				}
			}else if($act == "customs2"){
				foreach($this->input->post('DATA') as $a => $b){
					if($b=="") unset($DATA[$a]);
					else $DATA[$a] = trim($b);
				}
				
				$DATA['NO_SPK'] = $DATA['NO_SPK'];
				$DATA['JNS_DOK'] = $DATA['JNS_DOK'];
				$DATA['NO_DOK'] = $DATA['NO_DOK'];
				$DATA['NAMA_CUST'] = $DATA['NAMA_CUST'];
				$DATA['RESPON'] = $DATA['RESPON'];
				$DATA['WK_RESPON'] = date('Y-m-d H:i:s');

				$this->db->where(array('ID' => $id));
				$this->db->update('t_gatepass', $DATA);
				if($id==""){
					$error += 1;
					$message = "Data gagal diproses";
				}else{

				}
				if($error == 0){
					//$func->main->get_log("add","t_repohdr");
					echo "MSG#OK#Data berhasil diproses#".$this->input->post('action');
				}else{
					echo "MSG#ERR#".$message."#";
				}
			}else if($act == "gatepass"){
				foreach($this->input->post('DATA') as $a => $b){
					if($b=="") unset($DATA[$a]);
					else $DATA[$a] = strtoupper(trim($b));
				}

				$SQLGATEPASS = $this->db->query("SELECT * FROM t_gatepass WHERE NO_CONT ='".$DATA['NO_CONT']."' AND NO_DOK LIKE '%".$DATA['NO_DOK']."%' AND JNS_KEGIATAN ='1' ORDER BY ID DESC LIMIT 1")->result_array();
				$SQLSPK 	 = $this->db->query("SELECT A.*, B.* FROM t_spk A INNER JOIN t_spk_cont B ON A.ID = B.ID WHERE B.NO_CONT ='".$DATA['NO_CONT']."' AND A.NO_DOK LIKE '%".$DATA['NO_DOK']."%' AND B.STATUS_CONT ='450' ORDER BY A.ID DESC LIMIT 1")->result_array();

				if(count($SQLGATEPASS) == 0){
					if($DATA['JNS_DOK'] == 'SPPMP'){
						$this->db->where(array('NO_CONT' => $DATA['NO_CONT']));
						$this->db->update('t_ppk_cont', array('FL_GATEPASS' => 'Y'));
					}else{
						$DTB = $DATA['NO_CONT'];
						$this->db->where(array('NO_CONT' => $DATA['NO_CONT']));
						$this->db->update('t_permit_cont', array('FL_GATEPASS' => 'Y'));
					}

					$gatepass['NO_DOK'] 		= trim($DATA['NO_DOK']);
					$gatepass['JNS_DOK'] 		= $DATA['JNS_DOK'];
					$gatepass['NO_CONT'] 		= $DATA['NO_CONT'];
					$gatepass['NM_KAPAL'] 		= $DATA['NM_KAPAL'];
					$gatepass['TGL_DOK'] 		= date('Y-m-d',strtotime($DATA['TGL_DOK']));
					$gatepass['NAMA_CUST'] 		= $DATA['NAMA_CUST'];
					$gatepass['NO_VOY'] 		= $DATA['NO_VOY'];
					$gatepass['NPWP'] 			= $DATA['NPWP'];
					$gatepass['JNS_KEGIATAN'] 	= '1';
					$gatepass['UKR_CONT'] 		= $DATA['UKR_CONT'];
					$gatepass['WK_REK'] 		= date('Y-m-d H:i:s');
					$gatepass['FL_USE'] 		= 'N';
					$gatepass['FL_ACTIVE'] 		= 'N';
					$lnswnod = trim($DATA['NO_DOK']);
					$lnswtgl = date('Y-m-d',strtotime($DATA['TGL_DOK']));
					$ceklnsw = $this->db->query("SELECT respon_karantina,waktu_respon_kr FROM t_lnsw_responjoin  WHERE dok_karantina = '$lnswnod' AND tgl_karantina = '$lnswtgl'");
					
					//echo "SELECT respon_karantina,waktu_respon_kr FROM t_lnsw_responjoin  WHERE dok_karantina = '$lnswnod' AND tgl_karantina = '$lnswtgl'";
					//var_dump($ceklnsw->row());die();
					if ($ceklnsw->num_rows() > 0) {
						$gatepass['RESPON'] = $ceklnsw->row()->respon_karantina;
						$gatepass['WK_ACTIVE'] = date('Y-m-d H:i:s');
						$gatepass['WK_RESPON'] = $ceklnsw->row()->waktu_respon_kr;
						$gatepass['FL_ACTIVE'] 		= 'Y';
					}
					$this->db->insert('t_gatepass', $gatepass);
					$idGatepass = $this->db->insert_id();
					
					if (count($SQLSPK) > 0) {
						/* DATA SUDAH BEHANDLE IN DAN INSERT TO JOBSLIP BARU */
						$jobslip = array(
							'JNS_JOB_SLIP'	=> 'MARSHALLING',
							'JENIS'			=> 'BEHANDLE 1',
							'NO_SPK'		=> $SQLSPK[0]['NO_SPK'],
							'TGL_SPK'		=> $SQLSPK[0]['TGL_SPK'],
							'JNS_DOK'		=> $DATA['JNS_DOK'],
							'NO_DOK'		=> $DATA['NO_DOK'],
							'NO_CONT' 		=> $DATA['NO_CONT'],
							'NO_GATEPASS'	=> $idGatepass,
							'TGL_GATEPASS'	=> date('Y-m-d H:i:s'),
							'LOKASI_AWAL'	=> $SQLSPK[0]['LOKASI'],
							'TIER_AWAL'		=> $SQLSPK[0]['TIER'],
							'STATUS'		=> 'WAITING',
							'KD_STATUS'		=> '20',
							'OPERATOR' 		=> $this->session->userdata('USERLOGIN')
						);
						$this->db->insert('t_job_slip',$jobslip);
					}

					$SQLReport = $this->db->query("SELECT * FROM report_behandle WHERE NO_CONT='".$DATA['NO_CONT']."' AND REQ_NO_DOK LIKE '%".$DATA['NO_DOK']."%' ORDER BY ID DESC")->result_array();
					if (count($SQLReport) > 0) {
						$updateReport = array(
							'NO_CONT' 		=> $DATA['NO_CONT'],
							'REQ_NO_DOK' 	=> $DATA['NO_DOK'],
							'REQ_TGL_DOK' 	=> date('Y-m-d',strtotime($DATA['TGL_DOK'])),
							'REQ_CUSTOMER' 	=> $DATA['CONSIGNEE'],
							'RB1_GATEPASS_B1' => date('Y-m-d H:i:s')
						);
						$this->db->where(array('ID' => $SQLReport[0]['ID'], 'NO_CONT' => $DATA['NO_CONT'], 'REQ_NO_DOK' => $DATA['NO_DOK']));
						$this->db->update('report_behandle', $updateReport);
					}else{
						$insertReport = array(
							'NO_CONT' 		=> $DATA['NO_CONT'],
							'REQ_NO_DOK' 	=> $DATA['NO_DOK'],
							'REQ_TGL_DOK' 	=> date('Y-m-d',strtotime($DATA['TGL_DOK'])),
							'REQ_CUSTOMER' 	=> $DATA['CONSIGNEE'],
							'RB1_GATEPASS_B1' => date('Y-m-d H:i:s')
						);
						$this->db->insert('report_behandle', $insertReport);
					}
				}else{
					$message = "GATEPASS SUDAH ADA";
					echo "MSG#ERR#".$message."#";
				}

				if ($idGatepass) {
					$action = '/planning/gate_pass_behandle/post';
					echo "MSG#OK#Data berhasil diproses#".site_url().$action;
				}else{
					$message = "DATA GAGAL PROSES";
					echo "MSG#ERR#".$message."#";
				}
			}else if($act == "gatepass_old"){
				foreach($this->input->post('DATA') as $a => $b){
					if($b=="") unset($DATA[$a]);
					else $DATA[$a] = strtoupper(trim($b));
				}
				//Edit 20 Maret
				$DSPK = $DATA['NO_SPK'];
				$DCONT = $DATA['NO_CONT'];

				$sql = $this->db->query("SELECT NO_CONT FROM t_job_slip WHERE KD_STATUS = '40' AND LEFT(LOKASI_AKHIR,3) != 'CIC'");
				foreach ($sql->result_array() as $value) {
					$CONT = $value['NO_CONT'];
				}
				
				if($DATA['JNS_DOK'] == 'SPPMP'){
					$DTB = $DATA['NO_CONT'];
					$this->db->where(array('NO_CONT' => $DTB));
					$this->db->update('t_ppk_cont', array('FL_GATEPASS' => 'Y'));
				}else{
					$DTB = $DATA['NO_CONT'];
					$this->db->where(array('NO_CONT' => $DTB));
					$this->db->update('t_permit_cont', array('FL_GATEPASS' => 'Y'));
				}

				$Cek = 0;
				if($Cek == 0){
					$FTGL =  $DATA['TGL_DOK'];
					$GTGL = date('Y-m-d',strtotime($FTGL));
					$DATA2['NO_DOK'] = $DATA['NO_DOK'];
					$DATA2['JNS_DOK'] = $DATA['JNS_DOK'];
					$DATA2['NO_CONT'] = $DATA['NO_CONT'];
					$DATA2['NM_KAPAL'] = $DATA['NM_KAPAL'];
					$DATA2['TGL_DOK'] = $GTGL;
					$DATA2['NAMA_CUST'] = $DATA['NAMA_CUST'];
					$DATA2['NO_VOY'] = $DATA['NO_VOY'];
					$DATA2['NPWP'] = $DATA['NPWP'];
					$DATA2['JNS_KEGIATAN'] = 1;
					$DATA2['UKR_CONT'] = $DATA['UKR_CONT'];
					$DATA2['WK_REK'] = date('Y-m-d H:i:s');
					$DATA2['FL_USE'] = 'N';
					$DATA2['FL_ACTIVE'] = 'N';
					$this->db->insert('t_gatepass', $DATA2);
				}else{
					$Cek++;
				}

				if($Cek > 0){
					echo "MSG#ERR#Kontainer tersebut belum di Marshalling !#";
				}

				if($error == 0){
					$action = '/planning/gate_pass_behandle/post';
					echo "MSG#OK#Data berhasil diproses#".site_url().$action;
				}else{
					echo "MSG#ERR#".$message."#";
				}
			}else if($act == "gatepass_edit"){
				foreach($this->input->post('DATA') as $a => $b){
					if($b=="") unset($DATA[$a]);
					else $DATA[$a] = strtoupper(trim($b));
				}
					$CEK_JNS_KEGIATAN = str_replace(' ', '',$DATA['JNS_KEGIATAN']);
					if($CEK_JNS_KEGIATAN == 'BEHANDLE1'){
						$JNS_KEGIATAN = '1';
					}else{
						$JNS_KEGIATAN = '2';
					}

					$SQLSPK 	 = $this->db->query("SELECT A.*, B.* FROM t_spk A INNER JOIN t_spk_cont B ON A.ID = B.ID WHERE B.NO_CONT ='".$DATA['NO_CONT']."' AND A.NO_DOK LIKE '%".$DATA['NO_DOK']."%' ORDER BY A.ID DESC LIMIT 1")->result_array();

					if ($SQLSPK[0]['NO_DOK'] == $DATA['NO_DOK']) {
						if ($SQLSPK[0]['NO_CONT'] == $DATA['NO_CONT']) {

							$ID = $DATA['ID'];
							$UPDATE['JNS_DOK'] = $DATA['JNS_DOK'];
							$UPDATE['NO_DOK'] = $DATA['NO_DOK'];
							$UPDATE['TGL_DOK'] = $DATA['TGL_DOK'];
							$UPDATE['NM_KAPAL'] = $DATA['NM_KAPAL'];
							$UPDATE['NO_VOY'] = $DATA['NO_VOY'];
							$UPDATE['NAMA_CUST'] = $DATA['NAMA_CUST'];
							$UPDATE['NPWP'] = $DATA['NPWP'];
							$UPDATE['JNS_KEGIATAN'] = $JNS_KEGIATAN;
							$UPDATE['NO_CONT'] = $DATA['NO_CONT'];
							$UPDATE['UKR_CONT'] = $DATA['UKR_CONT'];
							$this->db->where(array('ID' => $ID));
							$result = $this->db->update('t_gatepass', $UPDATE);
						}else{
							$message = "Data Kontainer Tidak Sama Dengan SPK";
						}
					}else{
						$message = "Data Dokumen Tidak sama SPK";
						$error = 1;
					}
					
				if($error == 0){
					$action = '/planning/gate_pass_behandle/post';
					echo "MSG#OK#Data berhasil diubah#".site_url().$action;
				}else{
					echo "MSG#ERR#".$message."#";
				}
			}else if($act == "gatepass2"){
				foreach($this->input->post('DATA') as $a => $b){
					if($b=="") unset($DATA[$a]);
					else $DATA[$a] = strtoupper(trim($b));
				}

				$SQLGATEPASS = $this->db->query("SELECT * FROM t_gatepass WHERE NO_CONT ='".$DATA['NO_CONT']."' AND NO_DOK LIKE '%".$DATA['NO_DOK']."%' AND JNS_KEGIATAN ='2' ORDER BY ID DESC LIMIT 1")->result_array();
				$SQLSPK 	 = $this->db->query("SELECT A.*, B.* FROM t_spk A INNER JOIN t_spk_cont B ON A.ID = B.ID WHERE B.NO_CONT ='".$DATA['NO_CONT']."' AND B.STATUS_CONT ='450' ORDER BY A.ID DESC LIMIT 1")->result_array();

				$SQL_JOBSLIP = $this->db->query("SELECT * FROM t_job_slip WHERE NO_CONT ='".$DATA['NO_CONT']."' AND JNS_JOB_SLIP IS NULL AND JENIS IS NULL AND LOKASI_AKHIR IS NULL AND STATUS ='WAITING' ORDER BY ID_JOB_SLIP DESC LIMIT 1")->result_array();

				if(count($SQLGATEPASS) == 0){
					if (count($SQLSPK) > 0) {
						/* UPDATE GATEPASS OLD */
						$DOK1 = $this->input->post('DOK');
						$this->db->where(array('NO_DOK' => $DOK1,'JNS_KEGIATAN' => '1','NO_CONT' => $DATA['NO_CONT']));
						$this->db->update('t_gatepass', array('FL_USE' => 'Y'));

						/* INSERT GATEPASS NEW */
						$gatepass['NO_DOK'] 		= trim($DATA['NO_DOK']);
						$gatepass['JNS_DOK'] 		= $DATA['JNS_DOK'];
						$gatepass['NO_CONT'] 		= $DATA['NO_CONT'];
						$gatepass['NM_KAPAL'] 		= $DATA['NM_KAPAL'];
						$gatepass['TGL_DOK'] 		= date('Y-m-d',strtotime($DATA['TGL_DOK']));
						$gatepass['NAMA_CUST'] 		= $DATA['NAMA_CUST'];
						$gatepass['NO_VOY'] 		= $DATA['NO_VOY'];
						$gatepass['NPWP'] 			= $DATA['NPWP'];
						$gatepass['JNS_KEGIATAN'] 	= '2';
						$gatepass['UKR_CONT'] 		= $DATA['UKR_CONT'];
						$gatepass['WK_REK'] 		= date('Y-m-d H:i:s');
						$gatepass['FL_USE'] 		= 'N';
						$gatepass['FL_ACTIVE'] 		= 'N';
						$this->db->insert('t_gatepass', $gatepass);
						$idGatepass = $this->db->insert_id();

						/* INSERT TO JOBSLIP BARU */
						$jobslip = array(
							'JNS_JOB_SLIP'	=> 'MARSHALLING',
							'JENIS'			=> 'BEHANDLE 2',
							'JNS_DOK'		=> $DATA['JNS_DOK'],
							'NO_DOK'		=> $DATA['NO_DOK'],
							'NO_CONT' 		=> $DATA['NO_CONT'],
							'NO_GATEPASS'	=> $idGatepass,
							'TGL_GATEPASS'	=> date('Y-m-d H:i:s'),
							'STATUS'		=> 'WAITING',
							'KD_STATUS'		=> '20',
							'OPERATOR' 		=> $this->session->userdata('USERLOGIN')
						);
						$this->db->where(array('ID_JOB_SLIP' => $SQL_JOBSLIP[0]['ID_JOB_SLIP'], 'NO_CONT' => $DATA['NO_CONT']));
						$this->db->update('t_job_slip',$jobslip);

						$SQLReport = $this->db->query("SELECT * FROM report_behandle WHERE NO_CONT='".$DATA['NO_CONT']."' AND REQ_NO_DOK='".$DOK1."' ORDER BY ID DESC")->result_array();
						if (count($SQLReport) > 0) {
							$updateReport = array(
								'NO_CONT' 		=> $DATA['NO_CONT'],
								'RB2_JNS_DOK' 	=> $DATA['JNS_DOK'],
								'RB2_NO_DOK' 	=> $DATA['NO_DOK'],
								'RB2_TGL_DOK' 	=> $DATA['TGL_DOK'],
								'RB2_GATEPASS_B2' => date('Y-m-d H:i:s')
							);
							$this->db->where(array('ID' => $SQLReport[0]['ID'], 'NO_CONT' => $DATA['NO_CONT'], 'REQ_NO_DOK' => $DATA['NO_DOK']));
							$this->db->update('report_behandle', $updateReport);
						}
					}
				}else{
					$message = "GATEPASS SUDAH ADA";
					echo "MSG#ERR#".$message."#";
				}

				if ($idGatepass) {
					$action = '/planning/gate_pass_behandle2/post';
					echo "MSG#OK#Data berhasil diproses#".site_url().$action;
				}else{
					$message = "DATA GAGAL PROSES";
					echo "MSG#ERR#".$message."#";
				}
			}else if($act == "gatepass2_old"){
				/*             OLD              */

				foreach($this->input->post('DATA') as $a => $b){
					if($b=="") unset($DATA[$a]);
					else $DATA[$a] = strtoupper(trim($b));
				}

				$FTGL =  $DATA['TGL_DOK'];
				$GTGL = date('Y-m-d',strtotime($FTGL));
				$DATA['TGL_DOK'] = $GTGL;
				$DATA['NO_DOK'] = $DATA['NO_DOK'];
				$DATA['JNS_DOK'] = $DATA['JNS_DOK'];
				$DATA['NO_CONT'] = $DATA['NO_CONT'];
				$DATA['NAMA_CUST'] = $DATA['NAMA_CUST'];
				$DATA['NM_KAPAL'] = $DATA['NM_KAPAL'];
				$DATA['NO_VOY'] = $DATA['NO_VOY'];
				$DATA['JNS_KEGIATAN'] = 2;
				$DATA['UKR_CONT'] = $DATA['UKR_CONT'];
				$DATA['WK_REK'] = date('Y-m-d H:i:s');
				$DATA['NO_SPK'] = $DATA['NO_SPK'];

				$DOK1 = $this->input->post('DOK');
				$DATAT['FL_USE'] = "Y";

				$this->db->where(array('NO_DOK' => $DOK1,'JNS_KEGIATAN' => '1','NO_CONT' => $DATA['NO_CONT']));
				$result = $this->db->update('t_gatepass', $DATAT);
				$this->db->insert('t_gatepass', $DATA);

				if (!$result) {
		            $error += 1;
		            $message .= "Data gagal diproses";
		        }

				if($error == 0){
					$action = '/planning/gate_pass_behandle2/post';
					echo "MSG#OK#Data berhasil diproses#".site_url().$action;
				}else{
					echo "MSG#ERR#".$message."#";
				}
			}else if($act == "gatepass_flat"){
				foreach($this->input->post('DATA') as $a => $b){
					if($b=="") unset($DATA[$a]);
					else $DATA[$a] = strtoupper(trim($b));
				}

				$DATA['FLAT'] = $DATA['FLAT'];

				$this->db->where(array('id' => $id));
				$result = $this->db->update('t_gatepass', $DATA);

				if($error == 0){
					$action = '/planning/gate_pass_delivery/post';
					echo "MSG#OK#Data berhasil diproses#".site_url().$action;
				}else{
					echo "MSG#ERR#".$message."#";
				}
			}else if($act == "behandle1"){
				foreach($this->input->post('DATA') as $a => $b){
					if($b=="") unset($DATA[$a]);
					else $DATA[$a] = strtoupper(trim($b));
				}
				$id = $DATA['ID'];
				$DATAN['JNS_DOK'] = $DATA['JNS_DOK'];
				$DATAN['NO_DOK'] = $DATA['NO_DOK'];
				$DATAN['JNS_KEGIATAN'] = '1';
				$DATAN['NO_DO'] = $DATA['NO_DO'];
				$DATAN['NO_BL'] = $DATA['NO_BL'];
				$DATAN['NAMA_CUST'] = $DATA['CUSTOMER'];
				$DATAN['NPWP'] = $DATA['NPWP'];
				

				$this->db->where(array('ID_REQ' => $id));
				$result = $this->db->update('req_behandle_hdr', $DATAN);

				if($error == 0){
					$action = '/billing/behandle/post';
					echo "MSG#OK#Data berhasil diproses#".site_url().$action;
				}else{
					echo "MSG#ERR#".$message."#";
				}
			}else if($act == "delivery"){
				foreach($this->input->post('DATA') as $a => $b){
					if($b=="") unset($DATA[$a]);
					else $DATA[$a] = strtoupper(trim($b));
					//print_r($DATA);
				}

				$id = $DATA['ID'];
				$DATAN['NPWP'] = $DATA['NPWP'];
				$DATAN['EXPIRED'] = $DATA['EXPIRED'];
				$DATAN['NM_KAPAL'] = $DATA['NM_KAPAL'];
				$DATAN['NO_DOK'] = $DATA['NO_DOK'];
				$DATAN['NO_DO'] = $DATA['NO_DO'];
				$DATAN['NO_VOY'] = $DATA['NO_VOY'];
				$DATAN['TGL_DOK'] = $DATA['TGL_DOK'];
				// print_r($id); die();
				// $this->db->where(array('ID_REQ' => $id));
				// $this->db->update('req_delivery_hdr', $DATAN);
				
				//================================================== TAHAP 1 ==================================================//

				// $this->db->delete('req_delivery_dtl', array('ID_REQ' => $id));

				//================================================== TAHAP 2 ==================================================//

				$SQL_ADMIN = $this->db->query("SELECT * FROM m_tarif WHERE JENIS_BIAYA = 'ADMIN'")->row();
				$TARIF_ADMIN = $SQL_ADMIN->TARIF;
				$TARIF_ADMIN_ID = $SQL_ADMIN->TARIF_ID;
				$DATA_ADM['ID_REQ'] = $DATA['ID'];
				$DATA_ADM['TARIF_ID'] =	$TARIF_ADMIN_ID;
				$DATA_ADM['CHARGE'] = $TARIF_ADMIN;
				$DATA_ADM['TOTAL'] = $TARIF_ADMIN;

				// $this->db->insert('req_delivery_dtl', $DATA_ADM);

				//================================================== TAHAP 3 ==================================================//

				$PAID = $DATA['EXPIRED'];
				$NM_KAPAL = $DATA['NM_KAPAL'];
				$id_post = $this->input->post('cont_post');
				$arrid_post = explode(',', $id_post);
				$jumlah_dipilih = count($arrid_post);
				for($x=0; $x<$jumlah_dipilih; $x++){
					$DETAIL = array();
					$DETAIL_DENDASPPB = array();
					$SIZE = array();
					$arrid_val = explode('~',$arrid_post[$x]);
					foreach($this->input->post('DTL_'.$arrid_val[1]) as $a => $b){
						if($b=="") unset($DTL[$a]);
						else $DTL[$a] = strtoupper(trim($b));
					}
					$NO_CONT = $DTL['NO_CONT']; echo($NO_CONT); die();
					$SIZE = $DTL['UKR_CONT'];
					$TYPE = $DTL['TYPE'];
					$STATUS = $DTL['STATUS'];
					
					$ID_CONT = $DATA['ID'];
					// $this->db->where(array('ID' =>$ID_CONT,'NO_CONT' =>$NO_CONT));
					// $this->db->update('t_permit_cont', array('KD_STATUS_BIL' => '901'));

					$SQL = $this->db->query("SELECT * FROM m_tarif WHERE SIZE = '$SIZE' AND TYPE ='$TYPE' AND STATUS =  '$STATUS'")->row();

					$SQL_SPPB = $this->db->query("SELECT * FROM m_tarif WHERE SIZE = '$SIZE' AND TYPE ='$TYPE' AND STATUS =  '$STATUS' AND JENIS_BIAYA='SPPB'")->row();
					//echo $SQL_SPPB->TARIF_ID;die();
					$SQL_LO = $this->db->query("SELECT * FROM m_tarif WHERE SIZE = '$SIZE' AND STATUS =  '$STATUS' AND JENIS_BIAYA = 'LIFT ON'")->row();
					$SQL_MAX = $this->db->query("SELECT MAX(ID) AS ID FROM req_delivery_hdr")->row()->ID;
					//$WK_IN = $this->db->query("SELECT WK_IN FROM t_cocostscont WHERE NO_CONT = '$NO_CONT'")->row();
					$WK_IN = $this->db->query("SELECT WK_IN
												FROM t_cocostscont A
												INNER JOIN t_cocostshdr B
												ON A.ID = B.ID WHERE NO_CONT = '$NO_CONT' AND B.NM_ANGKUT = '$NM_KAPAL' AND WK_IN IS NOT NULL")->row();
												//print($this->db->last_query());
					$TGL_STATUS = $this->db->query("SELECT A.TGL_STATUS FROM t_permit_cont A, reff_status_cont B WHERE A.KD_STATUS = B.ID AND A.NO_CONT = '$NO_CONT'")->row();
					$TARIF_ID = $SQL->TARIF_ID;
					$MAX_ID = $SQL_MAX;
					$cek = $WK_IN->WK_IN;
					if($cek == NULL){
						$error += 1;
						echo "ERROR";
						$message = "Tgl Stacking Tidak Ada";
						echo "MSG#ERR#".$message."#";
						$this->db->where(array('ID' => SQL_MAX));
						$this->db->delete('req_delivery_hdr');
						die();
					} else {
						$in = $WK_IN->WK_IN;
					}

					//$in = $WK_IN->WK_IN;
					$tgl_stack = $in;
					$this->db->where(array('ID_REQ' => $id));
					$result2 = $this->db->update('req_delivery_hdr', array('TGL_STACK' => $in));
					
					//================================================== TAHAP 4 ==================================================//

					$Charge = $SQL->TARIF;
					$FirstStack = $in;
					$format = $PAID;
					$PaidThru = date("Y-m-d", strtotime($format));
					//print_r($PaidThru); die();
					$jam = date("Hi", strtotime($FirstStack));
					if ($jam > "1200") {
						$MasaBebas = date("Y-m-d", strtotime($FirstStack . "+1 days"));
					} else {
						$MasaBebas = date("Y-m-d", strtotime($FirstStack));
					}
					$SelisihMasaBebas = 0;
					$PenumpukanMasaBebas = $SelisihMasaBebas * ($Charge * 0);

					$Masa1 = date("Y-m-d", strtotime($MasaBebas . "+1 days"));
					//echo "Masa1 ".$Masa1;
					if($PaidThru >= $Masa1){
						$SelisihMasa1 = 1;
						$PenumpukanMasa1 = $SelisihMasa1 * ($Charge * 3);
					}

					$Masa2 = date("Y-m-d", strtotime($Masa1 . "+1 days"));
					if($PaidThru >= $Masa2){
						$SelisihMasa2 = 1;
						$PenumpukanMasa2 = $SelisihMasa2 * ($Charge * 6);
					}

					$Masa3Awal = date("Y-m-d", strtotime($Masa2 . "+1 days"));
					$Masa3Akhir = $PaidThru;
					if ($PaidThru >= $Masa3Awal) {
						$datetime1 = new DateTime($Masa3Awal);
						$datetime2 = new DateTime($Masa3Akhir);
						$difference = $datetime1->diff($datetime2);
						$selisihM44 = $difference->days;
						$selisihM4 = $selisihM44 + 1;
						$SelisihDateM3 = ($Masa3Akhir - $Masa3Awal) + 1;
						$PenumpukanMasa3 = $selisihM4 * ($Charge * 9);
					}

					$Total = $PenumpukanMasaBebas + $PenumpukanMasa1 + $PenumpukanMasa2 + $PenumpukanMasa3;
					//echo "Selisih ".$selisihM4." ";
					//echo "PENUMPUKAN MASA BEBAS 3 = ".$PenumpukanMasa3."<br>";
					/*echo "PENUMPUKAN MASA BEBAS = ".$PenumpukanMasaBebas."<br>";
					echo "PENUMPUKAN MASA BEBAS 1 = ".$PenumpukanMasa1."<br>";
					echo "PENUMPUKAN MASA BEBAS 2 = ".$PenumpukanMasa2."<br>";
					echo "PENUMPUKAN MASA BEBAS 3 = ".$PenumpukanMasa3."<br>";
					echo "Total = ".$Total;*/

					//die();

					$DETAIL['ID_REQ'] = $DATA['ID'];
					$DETAIL['NO_CONT'] = $DTL['NO_CONT'];
					$DETAIL['UKR_CONT'] = $DTL['UKR_CONT'];
					$DETAIL['ISO_CODE'] = $DTL['TYPE'];
					$DETAIL['STATUS'] = $DTL['STATUS'];
					$DETAIL['TARIF_ID'] = $TARIF_ID;
					$DETAIL['CHARGE'] = $Charge;
					$DETAIL['TOTAL_UNIT'] = NULL;
					$DETAIL['TOTAL'] = $Total;
					$DETAIL['PROSEN_M1'] = '0';
					$DETAIL['SELISIH_M1'] = $SelisihMasaBebas;
					$DETAIL['M1_START_DATE'] = $FirstStack;
					$DETAIL['M1_END_DATE'] = $FirstStack;
					$DETAIL['TOTAL_M1'] = $PenumpukanMasaBebas;
					$DETAIL['PROSEN_M2'] = '3';
					$DETAIL['SELISIH_M2'] = $SelisihMasa1;
					$DETAIL['M2_START_DATE'] = $Masa1;
					$DETAIL['M2_END_DATE'] = $Masa1;
					$DETAIL['TOTAL_M2'] = $PenumpukanMasa1;
					$DETAIL['PROSEN_M3'] = '6';
					$DETAIL['SELISIH_M3'] = $SelisihMasa2;
					$DETAIL['M3_START_DATE'] = $Masa2;
					$DETAIL['M3_END_DATE'] = $Masa2;
					$DETAIL['TOTAL_M3'] = $PenumpukanMasa2;
					$DETAIL['PROSEN_M4'] = '9';
					$DETAIL['SELISIH_M4'] = $selisihM4;
					$DETAIL['M4_START_DATE'] = $Masa3Awal;
					$DETAIL['M4_END_DATE'] = $Masa3Akhir;
					$DETAIL['TOTAL_M4'] = $PenumpukanMasa3;
					$DETAIL['WK_REKAM'] = date('Y-m-d H:i:s');
					//print_r($DETAIL); //die();
					$this->db->insert('req_delivery_dtl',$DETAIL);

					//================================================== TAHAP 5 ==================================================//

					#denda sppb
					$Charge_sppb = $SQL_SPPB->TARIF;
					$WkBilling = date('Y-m-d H:i:s');//'2017-05-13 11:00:00';
					$TglSPPB = $DATA['TGL_DOK'];
					$holiday = $this->db->query("SELECT * FROM t_hari_libur WHERE DATE_FORMAT(TANGGAL,'%Y-%m-%d') = '$TglSPPB'")->row();

					$check_libur = date('Y-m-d', strtotime($holiday->TANGGAL. ' + 1 days'));
					if ($check_libur->TANGGAL != NULL) {
						$CheckHariLibur = true;
					} else {
						$CheckHariLibur = false;
					}
					
					$CheckDaySppb = strtoupper(trim(date("D", strtotime($TglSPPB))));
					$day = strtoupper(trim(date("D", strtotime($WkBilling))));
					echo "day ".$day;
					$TglBilling = strtoupper(trim(date("Y-m-d", strtotime($WkBilling))));
					echo "TglBilling ".$TglBilling;
					$TglStack = strtoupper(trim(date("Y-m-d", strtotime($FirstStack))));
					echo "TglStack ".$TglStack;
					if($TglSPPB != $TglBilling){
						if ($TglSPPB <= $TglStack) {
							$JumlahMasaBebas = 3; // 3 hari
							$datetime1 = new DateTime($TglBilling);
							$datetime2 = new DateTime($TglStack);
							$difference = $datetime1->diff($datetime2);
							$selisihM44 = $difference->days;
							$selisihM4 = $selisihM44 + 1;
							$RangeDate = $selisihM4;//($TglBilling - $TglStack) + 1;
							echo "rangedate ".$RangeDate;
						}
						else{
							if (($day == "SUN") || ($day == "SAT") || ($CheckHariLibur) || ($CheckDaySppb == "FRI") || ($CheckDaySppb == "SAT")) {
								$JumlahMasaBebas = 4; // 3 hari
							}
							else{
								$JumlahMasaBebas = 3; // 2 hari
							}
							$datetime1 = new DateTime($TglBilling);
							$datetime2 = new DateTime($TglSPPB);
							$difference = $datetime1->diff($datetime2);
							$selisihM44 = $difference->days;
							$selisihM46 = $selisihM44 + 1;
							$RangeDate = $selisihM46;
						}
						echo "rangedate ".$RangeDate;
						echo "JumlahMasaBebas ".$JumlahMasaBebas;

						$SelisihMasaBebas = $RangeDate - $JumlahMasaBebas;
						$SelisihDateM1 = 0;
						$SelisihDateM2 = 0;
						$SelisihDateM3 = 0;
						$SelisihDateM4 = 0;
						 echo "SelisihMasaBebas ".$SelisihMasaBebas;
						if ($SelisihMasaBebas > 0) {
							$startDenda = date("Y-m-d", strtotime($TglBilling . "-" . $SelisihMasaBebas . " days"));
							echo "startDenda ".$startDenda;
							$Total_DENDA = 0;
							$DendaM1 = 0;
							$DendaM2 = 0;
							$DendaM3 = 0;
							$DendaM4 = 0;
							$MasaBebasDendaSPPB = NULL;
							$Masa1DendaSPPB = NULL;
							$Masa2DendaSPPB = NULL;
							$Masa3AwalDendaSPPB = NULL;
							$Masa3AkhirDendaSPPB = NULL;
							echo "Denda1 = ".$DendaM1;
							echo "Denda2 = ".$DendaM2;
							echo "Denda3 = ".$DendaM3;
							echo "Denda4 = ".$DendaM4;
							echo "Total Denda = ".$Total_DENDA;
							echo "No Kont ".$DTL['NO_CONT'];
							for ($c = 0; $c <= $SelisihMasaBebas; $c++) {
								echo "mampir sini";
								$checkDate = date("Y-m-d", strtotime($TglBilling . "-" . $c . " days"));
								if ($checkDate == $MasaBebas) {
									$SelisihDateM1 = 0;
									$DendaM1 = $SelisihDateM1 * (($Charge_sppb * 0) * 2);
									$MasaBebasDendaSPPB = $startDenda;
								}
								if ($checkDate == $Masa1) {
									$SelisihDateM2 = 1;
									$DendaM2 = $SelisihDateM2 * (($Charge_sppb * 3) * 2);
									$Masa1DendaSPPB = $startDenda;
								}
								if ($checkDate == $Masa2) {
									$SelisihDateM3 = 1;
									$DendaM3 = $SelisihDateM3 * (($Charge_sppb * 6) * 2);
									$Masa2DendaSPPB = $startDenda;
								}
								if (($checkDate >= $Masa3Awal) && ($checkDate <= $Masa3Akhir)) {
									$SelisihDateM4++;
									$DendaM4 = $DendaM4 + (($Charge_sppb * 9) * 2);
									if($SelisihMasaBebas==1){
										$Masa3AwalDendaSPPB = $checkDate;
										$Masa3AkhirDendaSPPB = $checkDate;
										$cek = "sini SelisihMasaBebas==1";
									}
									else{
										if($c==0){
											$Masa3AkhirDendaSPPB = $TglBilling;
											$cek = "sini Masa3AkhirDendaSPPB = TglBilling";
										}
										else{
											$Masa3AwalDendaSPPB = $checkDate;
										}
									}
								}
							}
							echo "cek Masa3AwalDendaSPPB".$cek;
							/**/$Total_DENDA = $DendaM1 + $DendaM2 + $DendaM3 + $DendaM4;
							echo "Denda1 = ".$DendaM1;
							echo "Denda2 = ".$DendaM2;
							echo "Denda3 = ".$DendaM3;
							echo "Denda4 = ".$DendaM4;
							echo "Total Denda = ".$Total_DENDA;
							echo "MasaBebasDendaSPPB = ".$MasaBebasDendaSPPB;
							echo "Masa1DendaSPPB = ".$Masa1DendaSPPB;
							echo "Masa2DendaSPPB = ".$Masa2DendaSPPB;
							echo "Masa3AwalDendaSPPB = ".$Masa3AwalDendaSPPB;
							echo "Masa3AkhirDendaSPPB = ".$Masa3AkhirDendaSPPB;
						}
					}
					echo "Total Denda2 = ".$Total_DENDA;//die();

					if ($Total_DENDA > 0){
						$DETAIL_DENDASPPB['ID_REQ'] = $DATA['ID'];
						$DETAIL_DENDASPPB['NO_CONT'] = $DTL['NO_CONT'];
						$DETAIL_DENDASPPB['UKR_CONT'] = $DTL['UKR_CONT'];
						$DETAIL_DENDASPPB['ISO_CODE'] = $DTL['TYPE'];
						$DETAIL_DENDASPPB['STATUS'] = $DTL['STATUS'];
						$DETAIL_DENDASPPB['TARIF_ID'] = $SQL_SPPB->TARIF_ID;;
						$DETAIL_DENDASPPB['CHARGE'] = $Charge_sppb;
						$DETAIL_DENDASPPB['TOTAL_UNIT'] = NULL;
						$DETAIL_DENDASPPB['TOTAL'] = $Total_DENDA;
						$DETAIL_DENDASPPB['PROSEN_M1'] = '0';
						$DETAIL_DENDASPPB['SELISIH_M1'] = $SelisihDateM1;
						$DETAIL_DENDASPPB['M1_START_DATE'] = $MasaBebasDendaSPPB;
						$DETAIL_DENDASPPB['M1_END_DATE'] = $MasaBebasDendaSPPB;
						$DETAIL_DENDASPPB['TOTAL_M1'] = $DendaM1;
						$DETAIL_DENDASPPB['PROSEN_M2'] = '3';
						$DETAIL_DENDASPPB['SELISIH_M2'] = $SelisihDateM2;
						$DETAIL_DENDASPPB['M2_START_DATE'] = $Masa1DendaSPPB;
						$DETAIL_DENDASPPB['M2_END_DATE'] = $Masa1DendaSPPB;
						$DETAIL_DENDASPPB['TOTAL_M2'] = $DendaM2;
						$DETAIL_DENDASPPB['PROSEN_M3'] = '6';
						$DETAIL_DENDASPPB['SELISIH_M3'] = $SelisihDateM3;
						$DETAIL_DENDASPPB['M3_START_DATE'] = $Masa2DendaSPPB;
						$DETAIL_DENDASPPB['M3_END_DATE'] = $Masa2DendaSPPB;
						$DETAIL_DENDASPPB['TOTAL_M3'] = $DendaM3;
						$DETAIL_DENDASPPB['PROSEN_M4'] = '9';
						$DETAIL_DENDASPPB['SELISIH_M4'] = $SelisihDateM4;
						$DETAIL_DENDASPPB['M4_START_DATE'] = $Masa3AwalDendaSPPB;
						$DETAIL_DENDASPPB['M4_END_DATE'] = $Masa3AkhirDendaSPPB;
						$DETAIL_DENDASPPB['TOTAL_M4'] = $DendaM4;
						$DETAIL_DENDASPPB['WK_REKAM'] = date('Y-m-d H:i:s');
						//print_r($DETAIL_DENDASPPB);
						$this->db->insert('req_delivery_dtl',$DETAIL_DENDASPPB);
					}

					//================================================== TAHAP 6 ==================================================//

					//echo 'masuk sini';
					$NO_DOK = $DATA['NO_DOK'];
					$SQL_SP2 = $this->db->query("SELECT * FROM m_tarif WHERE SIZE = '$SIZE' AND TYPE ='$TYPE' AND STATUS =  '$STATUS' AND JENIS_BIAYA='SP2'")->row();
					$COUNT_CONT = $this->db->query("SELECT COUNT(A.NO_CONT) AS 'NO_CONT'
													FROM t_permit_cont A, req_delivery_hdr B, t_permit_hdr C
													WHERE C.NO_DOK_INOUT = B.NO_DOK
													AND C.ID = A.ID
													AND C.NO_DOK_INOUT ='$NO_DOK'")->row()->NO_CONT;
					$Charge_sp2 = $SQL_SP2->TARIF;
					echo "Tarif SP2 ".$Charge_sp2." ". $SQL_SP2->TARIF_ID;
				    $WkBilling = date('Y-m-d H:i:s');//'2016-11-23 11:00:00';
				    $JumlahKontainerPerBL = $COUNT_CONT;
				   echo "jum cont ".$JumlahKontainerPerBL;
				    if ($JumlahKontainerPerBL > 30) {
				        $JumlahMasaBebas = 4;
				        //echo "JumlahKontainerPerBL ".$JumlahKontainerPerBL;
				    } else {
				        $JumlahMasaBebas = 2;
				        //echo "JumlahKontainerPerBL ".$JumlahKontainerPerBL;
				    }

				    $TglBilling = strtoupper(trim(date("Y-m-d", strtotime($WkBilling))));
				    $datePaidThru = new DateTime($PaidThru);
				    $dateBilling = new DateTime($TglBilling);
				    $difference = $datePaidThru->diff($dateBilling);
				    $selisih = $difference->days;
				    $GetDateDiff = $selisih + 1;
				    $RangeDate = $GetDateDiff;//GetDateDiff($PaidThru, $TglBilling) + 1;
				    echo "RangeDate ".$RangeDate;
				    if ($RangeDate > $JumlahMasaBebas) {
				        $SelisihMasaBebas = $RangeDate - $JumlahMasaBebas;
				        echo "SelisihMasaBebas ".$SelisihMasaBebas;
				        $SelisihDateM1Sp2 = 0;
				        $SelisihDateM2Sp2 = 0;
				        $SelisihDateM3Sp2 = 0;
				        $SelisihDateM4Sp2 = 0;
				        $DendaM1Sp2 = 0;
				        $DendaM2Sp2 = 0;
				        $DendaM3Sp2 = 0;
				        $DendaM4Sp2 = 0;
				        $TotalDendaSp2 = 0;
						$MasaBebasDendaSP2 = NULL;
						$Masa1DendaSP2 = NULL;
						$Masa2DendaSP2 = NULL;
						$Masa3AwalDendaSP2 = NULL;
						$Masa3AkhirDendaSP2 = NULL;
				        if ($SelisihMasaBebas > 0) {
				            for ($c = 0; $c < $SelisihMasaBebas; $c++) {
				                $checkDate = date("Y-m-d", strtotime($PaidThru . "-" . $c . " days"));
				                echo "checkDate ".$checkDate;
				                if ($checkDate == $MasaBebas) {
				                    $SelisihDateM1Sp2 = 0;
				                    $DendaM1Sp2 = $SelisihDateM1Sp2 * (($Charge_sp2 * 0) * 3);
				                    $MasaBebasDendaSP2 = $checkDate;
				                }
				                if ($checkDate == $Masa1) {
				                    $SelisihDateM2Sp2 = 1;
				                    $DendaM2Sp2 = $SelisihDateM2Sp2 * (($Charge_sp2 * 3) * 3);
				                    $Masa1DendaSP2 = $checkDate;
				                }
				                if ($checkDate == $Masa2) {
				                    $SelisihDateM3Sp2 = 1;
				                    $DendaM3Sp2 = $SelisihDateM3Sp2 * (($Charge_sp2 * 6) * 3);
				                    $Masa2DendaSP2 = $checkDate;
				                }
				                if (($checkDate >= $Masa3Awal) && ($checkDate <= $Masa3Akhir)) {
				                    $SelisihDateM4Sp2++;
				                    $DendaM4Sp2 = $DendaM4Sp2 + (($Charge_sp2 * 9) * 3);
				                    if($SelisihMasaBebas==1){
										$Masa3AwalDendaSP2 = $checkDate;
										$Masa3AkhirDendaSP2 = $checkDate;
									}
									else{
										if($c==0){
											$Masa3AkhirDendaSP2 = $PaidThru;
										}
										else{
											$Masa3AwalDendaSP2 = $checkDate;
										}
									}
				                }
				            }
				            $TotalDendaSp2 = $DendaM1Sp2 + $DendaM2Sp2 + $DendaM3Sp2 + $DendaM4Sp2;
				        }
				    }
				    /*echo "TotalDendaSp2 ".$TotalDendaSp2;
				    echo "Masa 3 awal ". $Masa3Awal;
				    echo "Masa 3 akhir ". $Masa3Akhir;
				    echo "Masa 3 awal denda ". $Masa3AwalDendaSP2;
				    echo "Masa 3 akhir denda ". $Masa3AkhirDendaSP2;*/
				    if ($TotalDendaSp2 > 0){
						$DENDA_SP2['ID_REQ'] = $DATA['ID'];
						$DENDA_SP2['NO_CONT'] = $DTL['NO_CONT'];
						$DENDA_SP2['UKR_CONT'] = $DTL['UKR_CONT'];
						$DENDA_SP2['ISO_CODE'] = $DTL['TYPE'];
						$DENDA_SP2['STATUS'] = $DTL['STATUS'];
						$DENDA_SP2['TARIF_ID'] = $SQL_SP2->TARIF_ID;
						$DENDA_SP2['CHARGE'] = $Charge_sp2;
						$DENDA_SP2['TOTAL_UNIT'] = NULL;
						$DENDA_SP2['TOTAL'] = $TotalDendaSp2;
						$DENDA_SP2['PROSEN_M1'] = '0';
						$DENDA_SP2['SELISIH_M1'] = $SelisihDateM1Sp2;
						$DENDA_SP2['M1_START_DATE'] = $MasaBebasDendaSP2;
						$DENDA_SP2['M1_END_DATE'] = $MasaBebasDendaSP2;
						$DENDA_SP2['TOTAL_M1'] = $DendaM1Sp2;
						$DENDA_SP2['PROSEN_M2'] = '3';
						$DENDA_SP2['SELISIH_M2'] = $SelisihDateM2Sp2;
						$DENDA_SP2['M2_START_DATE'] = $Masa1DendaSP2;
						$DENDA_SP2['M2_END_DATE'] = $Masa1DendaSP2;
						$DENDA_SP2['TOTAL_M2'] = $DendaM2Sp2;
						$DENDA_SP2['PROSEN_M3'] = '6';
						$DENDA_SP2['SELISIH_M3'] = $SelisihDateM3Sp2;
						$DENDA_SP2['M3_START_DATE'] = $Masa2DendaSP2;
						$DENDA_SP2['M3_END_DATE'] = $Masa2DendaSP2;
						$DENDA_SP2['TOTAL_M3'] = $DendaM3Sp2;
						$DENDA_SP2['PROSEN_M4'] = '9';
						$DENDA_SP2['SELISIH_M4'] = $SelisihDateM4Sp2;
						$DENDA_SP2['M4_START_DATE'] = $Masa3AwalDendaSP2;
						$DENDA_SP2['M4_END_DATE'] = $Masa3AkhirDendaSP2;
						$DENDA_SP2['TOTAL_M4'] = $DendaM4Sp2;
						$DENDA_SP2['WK_REKAM'] = date('Y-m-d H:i:s');
						//print_r($DENDA_SP2);
						$this->db->insert('req_delivery_dtl',$DENDA_SP2);
					}

					$TARIF_ID_LO = $SQL_LO->TARIF_ID;
					$TARIF_LO = $SQL_LO->TARIF;
					$DATA_LO['ID_REQ'] = $DATA['ID'];
					$DATA_LO['NO_CONT'] = $DTL['NO_CONT'];
					$DATA_LO['UKR_CONT'] = $DTL['UKR_CONT'];
					$DATA_LO['ISO_CODE'] = $DTL['TYPE'];
					$DATA_LO['STATUS'] = $DTL['STATUS'];
					$DATA_LO['TARIF_ID'] = $TARIF_ID_LO;
					$DATA_LO['CHARGE'] = $TARIF_LO;
					$DATA_LO['TOTAL_UNIT'] = NULL;
					$DATA_LO['TOTAL'] = $TARIF_LO;
					$DATA_LO['WK_REKAM'] = date('Y-m-d H:i:s');

					$this->db->insert('req_delivery_dtl', $DATA_LO);

					//EDITBILLING
					$SUM_MAX_ID = $this->db->query("SELECT ID_REQ AS 'ID' FROM req_delivery_dtl WHERE ID_REQ IN
													(SELECT ID_REQ FROM req_delivery_dtl WHERE SUBSTRING(ID_REQ, 16) =
													(SELECT IFNULL(COUNT(id_req),1) AS 'urut' FROM req_delivery_hdr))")->row()->ID;
					//print_r($SUM_MAX_ID);die();
					$sub_total = $this->db->query("SELECT SUM(TOTAL) AS TOTAL FROM req_delivery_dtl WHERE ID_REQ = '$id'")->row()->TOTAL;
					//echo "SUBTOTAL ".$sub_total;
					$PPN = $sub_total * 0.1;
					if($sub_total >= 1000000){
						$MAT = 6000;
					} else {
						$MAT = 3000;
					}
					$TOTAL_ALL = $MAT + $sub_total + $PPN;

					$DATA_HDR_UP['BIAYA_MATERAI'] = $MAT;
					$DATA_HDR_UP['SUBTOTAL'] = $sub_total;
					$DATA_HDR_UP['PPN'] = $PPN;
					$DATA_HDR_UP['TOTAL'] = $TOTAL_ALL;

					$this->db->where(array('ID_REQ' => $id));
					$this->db->update('req_delivery_hdr', $DATA_HDR_UP);
				}
				//die();

				if($error==0){
					echo "MSG#OK#Data berhasil diproses#".site_url()."/billing/delivery/post";
				}else{
					echo "MSG#ERR#".$message."#";
				}
			}else if($act=="mail"){
				foreach($this->input->post('DATA') as $a => $b){
					if($b=="") unset($DATA[$a]);
					else $DATA[$a] = strtoupper(trim($b));
				}

				$DATA['EMAIL'] = $DATA['EMAIL'];
				$DATA['JNS_EMAIL'] = $DATA['JNS_EMAIL'];
				$DATA['NAMA_USER'] = $DATA['NAMA_USER'];
				$this->db->where(array('ID' => $id));
				$result = $this->db->update('reff_mail', $DATA);

					//$result = $this->db->query($QUERY);

				if($error == 0){
					//$func->main->get_log("add","t_repohdr");
					echo "MSG#OK#Data berhasil diproses#".$this->input->post('action');
				}else{
					echo "MSG#ERR#".$message."#";
				}
			}else if($act=="libur"){
				foreach($this->input->post('DATA') as $a => $b){
					if($b=="") unset($DATA[$a]);
					else $DATA[$a] = strtoupper(trim($b));
				}

				$DATA['TANGGAL'] = $DATA['TANGGAL'];
				$DATA['KETERANGAN'] = $DATA['KETERANGAN'];

				//print_r($DATA);die();

				$this->db->where(array('ID' => $id));
				$result = $this->db->update('t_hari_libur', $DATA);
				//print_r($resul);die();
				//$QUERY = "SELECT * FROM t_jadwal_kapal WHERE ID = '$id'";
					//$result = $this->db->query($QUERY);

				if($error == 0){
					//$func->main->get_log("add","t_repohdr");
					echo "MSG#OK#Data berhasil diproses#".$this->input->post('action');
				}else{
					echo "MSG#ERR#".$message."#";
				}
			}else if($act == "customer"){
				foreach($this->input->post('DATA') as $a => $b){
					if($b=="") unset($DATA[$a]);
					else $DATA[$a] = trim($b);
				}
				//print_r($id);die();
				//print_r($DATA);die();
				//$DATA['ID'] = $DATA['ID'];
				$DATA['NPWP'] = $DATA['NPWP'];
				$DATA['NAMA_CUST'] = $DATA['NAMA_CUST'];
				$DATA['ALAMAT'] = $DATA['ALAMAT'];
				$DATA['EMAIL'] = $DATA['EMAIL'];
				$DATA['TELEPON'] = $DATA['TELEPON'];

				//print_r($DATA);die();

				$this->db->where(array('ID_CUST' => $id));
				$result = $this->db->update('m_pelanggan', $DATA);
				//print_r($resul);die();
				//$QUERY = "SELECT * FROM t_jadwal_kapal WHERE ID = '$id'";
					//$result = $this->db->query($QUERY);

				if($error == 0){
					//$func->main->get_log("add","t_repohdr");
					echo "MSG#OK#Data berhasil diproses#".$this->input->post('action');
				}else{
					echo "MSG#ERR#".$message."#";
				}
			}else if($act=="user"){
				foreach($this->input->post('DATA') as $a => $b){
					if($b=="") unset($DATA[$a]);
					else $DATA[$a] = trim($b);
				}

				$leng = strlen($DATA['PASS']);

				if($leng >= 6){
				$DATA['USER_NAME'] = $DATA['USER_NAME'];
				$DATA['NAMA'] = $DATA['NAMA'];
				$DATA['EMAIL'] = $DATA['EMAIL'];
				$DATA['PASS'] = md5($DATA['PASS']);
				$DATA['KD_GROUP'] = $DATA['KD_GROUP'];
				$DATA['STATUS'] = $DATA['STATUS'];

				$this->db->where(array('ID' => $id));
				$result = $this->db->update('reff_user', $DATA);
				}else{
					$error += 1;
					$message = "Password harus lebih atau sama dengan dari 8 Karakter !";
				}


				if($error == 0){
					//$func->main->get_log("add","t_repohdr");
					echo "MSG#OK#Data berhasil diproses#".$this->input->post('action');
				}else{
					echo "MSG#ERR#".$message."#";
				}
			}else if($act == "lokasi"){
				foreach($this->input->post('DATA') as $a => $b){
					if($b=="") unset($DATA[$a]);
					else $DATA[$a] = strtoupper(trim($b));
				}
				// print_r($id);die();
				//print_r($DATA);die();
				$DATA['NO_CONT'] = validate($DATA['NO_CONT']);
				$DATA['LOKASI_AKHIR'] = validate($DATA['LOKASI_AKHIR']);
				//$DATA['ROOM'] = validate($DATA['ROOM']);
				$nocontt=$DATA['NO_CONT'];
				$lokss=$DATA['LOKASI_AKHIR'];
				// print_r($dat);die();
				// echo $dat['NO_SPK'];die();
				//
				$this->db->where(array('ID_JOB_SLIP' => $id));
				$result = $this->db->update('t_job_slip', $DATA);

				$dat=$this->db->query("SELECT NO_SPK FROM t_job_slip WHERE ID_JOB_SLIP='$id' ")->row_array();
				$spk=$dat['NO_SPK'];
				// echo $spk;die();
				// print_r($dat);die();
				$iddd=$this->db->query("SELECT ID FROM t_spk WHERE NO_SPK='$spk' ")->row_array();
				$idnya=$iddd['ID'];
				// print_r($iddd);die();
				// echo " ".$nocontt." ".$lokss." ".$spk." ".$idnya." ";die();
				$this->db->query("UPDATE t_spk_cont SET LOKASI='$lokss' WHERE NO_CONT='$nocontt' AND ID='$idnya' ");

				$datMars['NO_CONT'] =  $DATA['NO_CONT'];
				$datMars['L_AWAL'] =  $DATA['LOKASI_AWAL'];
				$datMars['NO_AWAL'] =  "";//$DATA['LOKASI_AKHIR'];
				//$datMars['W_MARSHALING'] =  date('Y-m-d H:i:s');;
				$this->db->insert('t_op_marshalling',$datMars);
				//$QUERY = "SELECT * FROM t_jadwal_kapal WHERE ID = '$id'";
					//$result = $this->db->query($QUERY);

				if($error == 0){
					//$func->main->get_log("add","t_repohdr");
					echo "MSG#OK#Data berhasil diproses#".$this->input->post('action');
				}else{
					echo "MSG#ERR#".$message."#";
				}
			}else if($act == "lokasi2"){
				foreach($this->input->post('DATA') as $a => $b){
					if($b=="") unset($DATA[$a]);
					else $DATA[$a] = strtoupper(trim($b));
				}
				// print_r($id);die();
				//print_r($DATA);die();
				$DATA['NO_CONT'] = validate($DATA['NO_CONT']);
				$DATA['LOKASI_AKHIR'] = validate($DATA['LOKASI_AKHIR']);
				//$DATA['ROOM'] = validate($DATA['ROOM']);
				$nocontt=$DATA['NO_CONT'];
				$lokss=$DATA['LOKASI_AKHIR'];
				// print_r($dat);die();
				// echo $dat['NO_SPK'];die();
				//
				$this->db->where(array('ID_JOB_SLIP' => $id));
				$result = $this->db->update('t_job_slip', $DATA);

				$dat=$this->db->query("SELECT NO_SPK FROM t_job_slip WHERE ID_JOB_SLIP='$id' ")->row_array();
				$spk=$dat['NO_SPK'];
				// echo $spk;die();
				// print_r($dat);die();
				$iddd=$this->db->query("SELECT ID FROM t_spk WHERE NO_SPK='$spk' ")->row_array();
				$idnya=$iddd['ID'];
				// print_r($iddd);die();
				// echo " ".$nocontt." ".$lokss." ".$spk." ".$idnya." ";die();
				$this->db->query("UPDATE t_spk_cont SET LOKASI='$lokss' WHERE NO_CONT='$nocontt' AND ID='$idnya' ");

				$datMars['NO_CONT'] =  $DATA['NO_CONT'];
				$datMars['L_AWAL'] =  $DATA['LOKASI_AWAL'];
				$datMars['NO_AWAL'] =  "";//$DATA['LOKASI_AKHIR'];
				//$datMars['W_MARSHALING'] =  date('Y-m-d H:i:s');;
				$this->db->insert('t_op_marshalling',$datMars);
				//$QUERY = "SELECT * FROM t_jadwal_kapal WHERE ID = '$id'";
					//$result = $this->db->query($QUERY);

				if($error == 0){
					//$func->main->get_log("add","t_repohdr");
					echo "MSG#OK#Data berhasil diproses#".$this->input->post('action');
				}else{
					echo "MSG#ERR#".$message."#";
				}
			}else if($act=="realisasi"){

				foreach($this->input->post('DATA') as $a => $b){
					if($b=="") unset($DATA[$a]);
					else $DATA[$a] = strtoupper(trim($b));
				}
						$ata=$DATA['ATA'];
						$atd=$DATA['ATD'];
						$wk=$DATA['WK_DISCH'];

						if (strtotime($atd) <= strtotime($ata) ) {
							$error += 1;
							$message = "ATD HARUS LEBIH BESAR DARI ATA";
						}elseif (strtotime($wk) < strtotime($ata) ) {
							$error += 1;
							$message = "WAKTU DISCHARGE HARUS LEBIH BESAR DARI ATA";
						}elseif (strtotime($wk) >= strtotime($atd) ) {
							$error += 1;
							$message = "WAKTU DISCHARGE HARUS LEBIH KECIL DARI ATD";
						}else {
							$DATA['ATA'] = $DATA['ATA'];
							//$DATA['ETD'] = $DATA['ETD'];
							$DATA['ATD'] = $DATA['ATD'];
							//$DATA['OPN_STACK'] = $DATA['OPN_STACK'];
							$DATA['NO_PPKB'] = $DATA['NO_PPKB'];
							$DATA['WK_DISCH'] = $DATA['WK_DISCH'];
							$DATA['JMLH_MUAT'] = $DATA['JMLH_MUAT'];
							//$DATA['EARLY_STACK'] = $DATA['EARLY_STACK'];
							//$DATA['CLS_TIME'] = $DATA['CLS_TIME'];

							//print_r($DATA);die();

							$this->db->where(array('ID' => $id));
							$result = $this->db->update('t_jadwal_kapal', $DATA);
						}

				if($error == 0){
					//$func->main->get_log("add","t_repohdr");
					echo "MSG#OK#Data berhasil diproses#".$this->input->post('action');
				}else{
					echo "MSG#ERR#".$message."#";
				}
			}
		}else if($type == "delete"){
			if($act=="kapal"){
				//print_r($_POST);die();
				foreach($this->input->post('tb_chktblkapallist') as $chkitem){
					$arrchk = explode("~", $chkitem);
					$ID  = $arrchk[0];
					$exec = $this->db->delete('t_jadwal_kapal', array('ID' => $ID));
					if(!$exec){
						$error += 1;
						$message = "Data gagal diproses";
					}
				}

				if($error==0){
					//$func->main->get_log("delete","t_request_plp_hdr,t_request_plp_cont,t_request_plp_status");
					$action = '/planning/shipment/post';
					echo "MSG#OK#Data berhasil dihapus#".site_url().$action;
				}else{
					echo "MSG#ERR#Data gagal dihapus#";
				}
			}else if($act=="spk"){
				$post = $this->input->post('tb_chktblkapal88');
				$row = count($post);
				$arrExplode = explode("~",$post[0]);
				$idarr = $arrExplode[0];
				//print_r($idarr);die();
				for ($i=0; $i < $row; $i++) {
					$ID = $idarr;
					// print_r($ID);die();
					$this->db->delete('t_operation_new', array('ID_SPK' => $ID));
					
					$exec_t_spk = $this->db->delete('t_spk', array('ID' => $ID));
					$this->db->delete('t_spk_cont', array('ID' => $ID));
					
					$SQL_SPK = "SELECT NO_SPK,TGL_SPK FROM t_spk WHERE ID='".$ID."'";
					$SQL = $this->db->query($SQL_SPK)->result_array();
					//echo $SQL_SPK;die();
					$no_spk = $SQL[0]['NO_SPK'];
					$tgl_spk = date('Y-m-d', strtotime($SQL[0]['TGL_SPK']));

					$this->db->delete('t_job_slip', array('NO_SPK' => $no_spk,'TGL_SPK' => $tgl_spk));
					$SQL_JOB = $this->db->query("SELECT ID_JOB_SLIP FROM t_job_slip WHERE NO_SPK='".$no_spk."' AND TGL_SPK ='".$tgl_spk."'")->result_array();
					$row_job = count($SQL_JOB);
					for ($job=0; $job < $row_job ; $job++) {
						$ID_JOB = $SQL_JOB[$job];
						$this->db->delete('t_job_slip_status', array('ID_JOB_SLIP' => $ID_JOB));
						$this->db->delete('t_job_slip', array('NO_SPK' => $no_spk,'TGL_SPK' => $tgl_spk,'ID_JOB_SLIP' => $ID_JOB_SLIP));
						print_r($this->db->last_query());
					}

					if(!$exec_t_spk){
						$error += 1;
						$message = "Data gagal diproses";
					}
				}
				// die();

				if($error==0){
					$action = '/planning/spk/post';
					echo "MSG#OK#Data berhasil dihapus#".site_url().$action;
				}else{
					echo "MSG#ERR#Data gagal dihapus#";
				}
			}else if($act == "dokumenbc"){
				foreach($this->input->post('tb_chktblbc') as $chkitem){
					$arrchk = explode("~", $chkitem);
					$ID  = $arrchk[0];
					$exec = $this->db->delete('reff_kode_dok_bc', array('ID' => $ID));
					if(!$exec){
						$error += 1;
						$message = "Data gagal diproses";
					}
				}
				if($error==0){
					//$func->main->get_log("delete","t_request_plp_hdr,t_request_plp_cont,t_request_plp_status");
					$action = '/reference/dokumenbc/post';
					echo "MSG#OK#Data berhasil dihapus#".site_url().$action;
				}else{
					echo "MSG#ERR#Data gagal dihapus#";
				}
			}else if($act == "customer"){
				//print_r($this->input->post());die();
				foreach($this->input->post('tb_chktblcustomer') as $chkitem){
					$arrchk = explode("~", $chkitem);
					$ID  = $arrchk[0];
					$exec = $this->db->delete('m_pelanggan', array('ID_CUST' => $ID));
					if(!$exec){
						$error += 1;
						$message = "Data gagal diproses";
					}
				}


				if($error==0){
					//$func->main->get_log("delete","t_request_plp_hdr,t_request_plp_cont,t_request_plp_status");
					$action = '/reference/customer/post';
					echo "MSG#OK#Data berhasil dihapus#".site_url().$action;
				}else{
					echo "MSG#ERR#Data gagal dihapus#";
				}
			}else if($act == "mail") {
				foreach($this->input->post('tb_chktblmail') as $chkitem){
					$arrchk = explode("~", $chkitem);
					$ID  = $arrchk[0];
					$exec = $this->db->delete('reff_mail', array('ID' => $ID));
					if(!$exec){
						$error += 1;
						$message = "Data gagal diproses";
					}
				}
				if($error==0){
					//$func->main->get_log("delete","t_request_plp_hdr,t_request_plp_cont,t_request_plp_status");
					$action = '/reference/mail/post';
					echo "MSG#OK#Data berhasil dihapus#".site_url().$action;
				}else{
					echo "MSG#ERR#Data gagal dihapus#";
				}
			}else if($act == "hrlibur") {
				foreach($this->input->post('tb_chktbllibur') as $chkitem){
					$arrchk = explode("~", $chkitem);
					$ID  = $arrchk[0];
					$exec = $this->db->delete('t_hari_libur', array('ID' => $ID));
					if(!$exec){
						$error += 1;
						$message = "Data gagal diproses";
					}
				}

				if($error==0){
					//$func->main->get_log("delete","t_request_plp_hdr,t_request_plp_cont,t_request_plp_status");
					$action = '/reference/hrlibur/post';
					echo "MSG#OK#Data berhasil dihapus#".site_url().$action;
				}else{
					echo "MSG#ERR#Data gagal dihapus#";
				}
			}elseif ($act == "user") {
				foreach($this->input->post('tb_chktbluser') as $chkitem){
					$arrchk = explode("~", $chkitem);
					$ID  = $arrchk[0];
					$exec = $this->db->delete('reff_user', array('ID' => $ID));
					if(!$exec){
						$error += 1;
						$message = "Data gagal diproses";
					}
				}
				if($error==0){
					//$func->main->get_log("delete","t_request_plp_hdr,t_request_plp_cont,t_request_plp_status");
					$action = '/Usermanage/user/post';
					echo "MSG#OK#Data berhasil dihapus#".site_url().$action;
				}else{
					echo "MSG#ERR#Data gagal dihapus#";
				}
			}
		}
	}

	function get_data($act,$id){
		$func = get_instance();
        $func->load->model("m_main", "main", true);
		$KD_TPS = $this->session->userdata('KD_TPS');
		$KD_GUDANG = $this->session->userdata('KD_GUDANG');
		//$func->main->log_prints($id, $act);
		if($act=="kapal"){
			//echo "string";die();
			$arrid = explode("~",$id);
			$SQL = "SELECT * FROM t_jadwal_kapal WHERE ID = '$id'";//.$this->db->escape($arrid[0]);
			$result = $func->main->get_result($SQL);
			//print_r($SQL);die();
			if($result){
				foreach($SQL->result_array() as $row => $value){
					$arrdata = $value;
				}
				return $arrdata;
			}else {
				redirect(site_url(), 'refresh');
			}
		}else if($act == "gatepass"){
			$arrid = explode("~",$id);
			$no_dok=$arrid[0];
			$tgl_dok= $arrid[1];
			$no_cont=$arrid[2];
			// $SQL = "SELECT X.ID,X.NAMA_KAPAL AS 'NAMA KAPAL',X.NO_VOYAGE AS 'NO. VOYAGE', X.JENIS_DOKUMEN AS 'JENIS DOKUMEN', X.NO_DOKUMEN AS 'NO. DOKUMEN',DATE_FORMAT(X.TGL_DOKUMEN,'%d-%m-%Y') AS 'TGL. DOKUMEN', X.NO_KONTAINER AS 'NO. KONTAINER', X.UKURAN AS 'UKURAN', X.STATUS_DOKUMEN AS 'STATUS DOKUMEN'
			// 		FROM(
			// 		SELECT C.ID AS 'ID', C.ANGKUTNAMA_TPS AS 'NAMA_KAPAL', C.ANGKUTNO_TPS 'NO_VOYAGE', H.NAMA AS 'JENIS_DOKUMEN', C.NO_DOK_INOUT AS 'NO_DOKUMEN', C.TGL_DOK_INOUT AS 'TGL_DOKUMEN',D.NO_CONT AS 'NO_KONTAINER', KD_CONT_UKURAN AS 'UKURAN', CASE WHEN C.FL_MANUAL IS NULL THEN 'INTEGRASI' ELSE 'MANUAL' END AS 'STATUS_DOKUMEN'
			// 		FROM t_permit_hdr C
			// 		LEFT JOIN t_permit_cont D on C.ID = D.ID
			// 		LEFT JOIN reff_kode_dok_bc H ON C.KD_DOK_INOUT = H.ID
			// 		WHERE KD_DOK_INOUT != '83' AND KD_DOK_INOUT != '1'
			// 		UNION ALL
			// 		SELECT A.ID_IJIN AS 'ID', A.ANGKUTNAMA_TPS AS 'NAMA_KAPAL', A.ANGKUTNO_TPS AS 'NO_VOYAGE', 'SPPMP' AS 'JENIS_DOKUMEN', A.NO_RESPON AS 'NO_DOKUMEN', A.TG_RESPON AS 'TGL_DOKUMEN',B.NO_CONT AS 'NO_KONTAINER', B.UKURAN AS 'UKURAN', 'INTEGRASI' AS 'STATUS_DOKUMEN'
			// 		FROM t_ppk_hdr A
			// 		LEFT JOIN t_ppk_cont B ON A.ID_IJIN = B.ID_IJIN
			// 		WHERE B.NO_TPFT IS NOT NULL) X WHERE X.NO_DOKUMEN = '".$no_dok."' AND X.NO_KONTAINER = '".$no_cont."'";


			$SQL = "SELECT 
    X.ID,
    X.NAMA_KAPAL AS 'NAMA KAPAL',
    X.NO_VOYAGE AS 'NO. VOYAGE',
    X.JENIS_DOKUMEN AS 'JENIS DOKUMEN',
    X.NO_DOKUMEN AS 'NO. DOKUMEN',
    DATE_FORMAT(X.TGL_DOKUMEN,'%d-%m-%Y') AS 'TGL. DOKUMEN',
    X.NO_KONTAINER AS 'NO. KONTAINER',
    X.UKURAN AS 'UKURAN',
    X.STATUS_DOKUMEN AS 'STATUS DOKUMEN'
FROM (
    SELECT 
        C.ID AS ID,
        C.ANGKUTNAMA_TPS AS NAMA_KAPAL,
        C.ANGKUTNO_TPS AS NO_VOYAGE,
        H.NAMA AS JENIS_DOKUMEN,
        C.NO_DOK_INOUT AS NO_DOKUMEN,
        C.TGL_DOK_INOUT AS TGL_DOKUMEN,
        D.NO_CONT AS NO_KONTAINER,
        KD_CONT_UKURAN AS UKURAN,
        CASE 
            WHEN C.FL_MANUAL IS NULL THEN 'INTEGRASI' 
            ELSE 'MANUAL' 
        END AS STATUS_DOKUMEN
    FROM t_permit_hdr C
    LEFT JOIN t_permit_cont D ON C.ID = D.ID
    LEFT JOIN reff_kode_dok_bc H ON C.KD_DOK_INOUT = H.ID
    WHERE 
        KD_DOK_INOUT NOT IN ('83', '1')
        AND C.NO_DOK_INOUT = '$no_dok'
        AND D.NO_CONT = '$no_cont'

    UNION ALL

    SELECT 
        A.ID_IJIN AS ID,
        A.ANGKUTNAMA_TPS AS NAMA_KAPAL,
        A.ANGKUTNO_TPS AS NO_VOYAGE,
        'SPPMP' AS JENIS_DOKUMEN,
        A.NO_RESPON AS NO_DOKUMEN,
        A.TG_RESPON AS TGL_DOKUMEN,
        B.NO_CONT AS NO_KONTAINER,
        B.UKURAN AS UKURAN,
        'INTEGRASI' AS STATUS_DOKUMEN
    FROM t_ppk_hdr A
    LEFT JOIN t_ppk_cont B ON A.ID_IJIN = B.ID_IJIN
    WHERE 
        B.NO_TPFT IS NOT NULL
        AND A.NO_RESPON = '$no_dok'
        AND B.NO_CONT = '$no_cont'
) AS X";

			$result = $func->main->get_result($SQL);
			if($result){
				foreach($SQL->result_array() as $row => $value){
					$arrdata = $value;
				}
				return $arrdata;
			}else {
				redirect(site_url(), 'refresh');
			}
		}else if($act == "gatepass_edit"){
			$arrid = explode("~",$id);
			$id1=$arrid[0];
			$id2=$arrid[1];
			$SQL = "SELECT ID, JNS_DOK AS 'JENIS DOKUMEN', NO_DOK AS 'NO. DOKUMEN', TGL_DOK AS 'TGL. DOKUMEN', NM_KAPAL AS 'NAMA KAPAL', NO_VOY AS 'NO. VOYAGE', NAMA_CUST, NPWP, NO_CONT AS 'NO. KONTAINER', UKR_CONT AS 'UKURAN' FROM t_gatepass WHERE ID = '$id1'";

			$result = $func->main->get_result($SQL);
			//var_dump($SQL);die();
			if($result){
				foreach($SQL->result_array() as $row => $value){
					$arrdata = $value;
				}
				return $arrdata;
			}else {
				redirect(site_url(), 'refresh');
			}			
		}else if($act == "gatepass_delivery"){
			$SQL = "SELECT A.ID AS 'ID', B.NO_CONT, B.KD_CONT_UKURAN,
					CASE WHEN A.KD_DOK_INOUT = 1 THEN 'SPPB' ELSE 'NULL' END AS 'JENIS DOKUMEN',
					A.NO_DOK_INOUT, A.TGL_DOK_INOUT, A.ANGKUTNAMA_TPS, A.ANGKUTNO_TPS
					FROM t_permit_hdr A
					INNER JOIN t_permit_cont B ON A.ID = B.ID
					WHERE B.NO_CONT = '".$id."' ";
			$result = $func->main->get_result($SQL);
			if($result){
				foreach($SQL->result_array() as $row => $value){
					$arrdata = $value;
				}
				return $arrdata;
			}else {
				redirect(site_url(), 'refresh');
			}
		}else if($act == "bank_data"){
			$SQL =  $this->db->query("SELECT BANK_ID, NAMA_BANK, REKENING FROM m_bank");
			return $SQL->result_array();
		}else if($act == "libur"){
			$arrid = explode("~",$id);
			$SQL = "SELECT * FROM t_hari_libur WHERE ID = '$id'";//.$this->db->escape($arrid[0]);
			$result = $func->main->get_result($SQL);
			//print_r($SQL);die();
			if($result){
				foreach($SQL->result_array() as $row => $value){
					$arrdata = $value;
				}
				return $arrdata;
			}else {
				redirect(site_url(), 'refresh');
			}
		}else if($act == "gatepass2"){
			$arrid = explode("~",$id);
			//print_r($id);
			$SQL = "SELECT * FROM t_gatepass WHERE ID = '$id'";
			//echo $SQL;
			$result = $func->main->get_result($SQL);
			//print_r($result);
			if($result){
				foreach($SQL->result_array() as $row => $value){
					$arrdata = $value;
				}
				return $arrdata;
			}else {
				redirect(site_url(), 'refresh');
			}
		}else if($act == "spk_data"){
			$no_dok = $id['arrdata']['NO_DOK'];
			$jns_dok = $id['arrdata']['JNS_DOK'];
			$tgl = $id['arrdata']['TGL_DOK'];

			if($jns_dok == 'SPJM'){
				$jns_dokumen = '19';
			}elseif($jns_dok == 'NHI'){
				$jns_dokumen = '81';
			}elseif($jns_dok == 'ATA CARNET (IMPORT)'){
				$jns_dokumen = '43';
			}else{
				$jns_dokumen = '83';
			}

			$SQL_DOK = $this->db->query("SELECT ID FROM reff_kode_dok_bc WHERE NAMA ='".$jns_dok."'")->row_array();
			$query = "SELECT NO_SPK FROM t_spk WHERE NO_DOK LIKE '%$no_dok%' AND JNS_DOK = '".$SQL_DOK['ID']."'";
			$SQL = $this->db->query($query);
			$result = $SQL->result_array();
			if ($SQL->num_rows() > 0) {
				if($result){
					foreach($SQL->result_array() as $row => $value){
						$arrdata = $value;
					}
					return $arrdata;
				}else {
					redirect(site_url(), 'refresh');
				}
			}else{
				$query = "SELECT NO_SPK FROM t_spk A INNER JOIN t_spk_cont B ON A.ID = B.ID WHERE B.NO_CONT = '".$id['arrdata']['NO_CONT']."' ORDER BY A.ID DESC LIMIT 1";
				$SQL = $this->db->query($query);
				$result = $SQL->result_array();
				if($result){
					foreach($SQL->result_array() as $row => $value){
						$arrdata = $value;
					}
					return $arrdata;
				}else {
					redirect(site_url(), 'refresh');
				}
			} 
			
		}else if($act=="customer"){
			//echo $id; die();
			$arrid = explode("~",$id);
			$SQL = "SELECT * FROM m_pelanggan WHERE ID_CUST = '$id'";//.$this->db->escape($arrid[0]);
			$result = $func->main->get_result($SQL);
			//print_r($SQL);die();
			if($result){
				foreach($SQL->result_array() as $row => $value){
					$arrdata = $value;
				}
				return $arrdata;
			}else {
				redirect(site_url(), 'refresh');
			}
		}else if($act=="customs"){
			$arrid = explode("~",$id);
			$SQL = "SELECT C.ID,A.NO_SPK,B.NO_CONT,B.UKR_CONT,C.NO_DOK,G.NAMA,CONCAT(B.LOKASI,'0',B.TIER) AS 'LOKASI',
				CASE WHEN C.JNS_KEGIATAN = '1' THEN 'BEHANDLE 1' WHEN C.JNS_KEGIATAN = '2' THEN 'BEHANDLE 2' END AS 'KETERANGAN',A.CONSIGNEE, 
				CASE WHEN B.STATUS_CONT = '460' AND F.START_INSP IS NULL AND F.FINISH_INSP IS NULL THEN 'SIAP PERIKSA' 
				WHEN B.STATUS_CONT IN ('500','540','520') THEN 'SELESAI PERIKSA' 
				WHEN B.STATUS_CONT = '460' AND F.START_INSP IS NOT NULL AND F.FINISH_INSP IS NULL THEN 'SEDANG PERIKSA' 
				ELSE 'ANTRIAN PERIKSA' END AS 'STATUS'
				FROM t_spk A
				LEFT JOIN t_spk_cont B ON A.ID = B.ID
				LEFT JOIN t_gatepass C ON B.NO_CONT = C.NO_CONT AND C.`STATUS` = 'WAITING'
				INNER JOIN t_request D ON C.NO_DOK = D.NO_DOK
				LEFT JOIN reff_status_spk E ON B.STATUS_CONT = E.ID
				LEFT JOIN t_op_inspection F ON F.NO_CONT = B.NO_CONT
				LEFT JOIN reff_kode_dok_bc G ON D.JNS_DOK = G.ID
				LEFT JOIN t_job_slip H ON H.NO_CONT = B.NO_CONT
				WHERE B.STATUS_CONT IN('460','500','510','530','540','520') AND C.FL_ACTIVE = 'Y' AND C.ID ='$id'
				GROUP BY B.NO_CONT";//.$this->db->escape($arrid[0]);
			$result = $func->main->get_result($SQL);
			//print_r($SQL);die();
			if($result){
				foreach($SQL->result_array() as $row => $value){
					$arrdata = $value;
				}
				return $arrdata;
			}else {
				redirect(site_url(), 'refresh');
			}
		}else if($act=="cetak_gbe"){
			//print_r($id);die();
			$func->main->log_prints($id, $act);
			$arrid = explode("~",$id);
			$SQL="SELECT A.*,C.NO_SPK,CASE WHEN LEFT(LOKASI,3) = 'CIC' THEN LOKASI WHEN LOKASI IS NULL THEN 'TERMINAL' ELSE CONCAT(LOKASI,'0', TIER) END AS 'LOKASI', X.TIPE, X.ISO_CODE, X.BRUTO
				FROM t_gatepass A
				LEFT JOIN t_spk_cont B ON A.NO_CONT = B.NO_CONT
				LEFT JOIN t_spk C ON A.NO_DOK = C.NO_DOK AND A.TGL_DOK = C.TGL_DOK
				LEFT JOIN (
					SELECT NO_CONT, KD_CONT_TIPE AS 'TIPE', ISO_CODE, BRUTO
					FROM t_cocostscont 
					) X ON X.NO_CONT = A.NO_CONT 
				WHERE A.ID ='$id'";
			//echo $SQL;
			$result = $func->main->get_result($SQL);

			if($result){
				foreach($SQL->result_array() as $row => $value){
					$arrdata[] = $value;
				}
				return $arrdata;
			}else {
				redirect(site_url(), 'refresh');
			}
		}else if($act=="cetak_gbe2"){
			//print_r($id);die();
			$func->main->log_prints($id, $act);
			$arrid = explode("~",$id);
			// $SQL="SELECT A.*,C.NO_SPK,CASE WHEN LEFT(LOKASI,3) = 'CIC' THEN LOKASI WHEN LOKASI IS NULL THEN 'TERMINAL' ELSE CONCAT(LOKASI,'0', TIER) END AS 'LOKASI', X.TIPE, X.ISO_CODE, X.BRUTO
			// 	FROM t_gatepass A
			// 	LEFT JOIN t_spk_cont B ON A.NO_CONT = B.NO_CONT
			// 	LEFT JOIN t_spk C ON A.NO_DOK = C.NO_DOK AND A.TGL_DOK = C.TGL_DOK
			// 	LEFT JOIN (
			// 		SELECT NO_CONT, KD_CONT_TIPE AS 'TIPE', ISO_CODE, BRUTO
			// 		FROM t_cocostscont 
			// 		) X ON X.NO_CONT = A.NO_CONT 
			// 	WHERE A.NO_CONT ='$id' and
			// 	B.STATUS_CONT != '900'  and A.JNS_KEGIATAN in (1,2) order by A.ID desc limit 1";
						$SQL="SELECT A.*,C.NO_SPK,CASE WHEN LEFT(LOKASI,3) = 'CIC' THEN LOKASI WHEN LOKASI IS NULL THEN 'TERMINAL' ELSE CONCAT(LOKASI,'0', TIER) END AS 'LOKASI', X.TIPE, X.ISO_CODE, X.BRUTO
				FROM t_gatepass A
				LEFT JOIN t_spk_cont B ON A.NO_CONT = B.NO_CONT
				LEFT JOIN t_spk C ON A.NO_DOK = C.NO_DOK AND A.TGL_DOK = C.TGL_DOK
				LEFT JOIN (
					SELECT NO_CONT, KD_CONT_TIPE AS 'TIPE', ISO_CODE, BRUTO
					FROM t_cocostscont 
					) X ON X.NO_CONT = A.NO_CONT 
				WHERE A.NO_CONT ='$id'
				and A.JNS_KEGIATAN in (1,2) order by A.ID desc limit 1";
				
			//echo $SQL;
			$result = $func->main->get_result($SQL);

			if($result){
				foreach($SQL->result_array() as $row => $value){
					$arrdata[] = $value;
				}
				return $arrdata;
			}else {
				redirect(site_url(), 'refresh');
			}
		}else if($act=="cetak_gdel"){
			
			$func->main->log_prints($id, $act);
			$arrid = explode("~",$id);
			$SQL="SELECT G.*,A.*, C.NO_SPK, CASE WHEN LEFT(B.LOKASI,3) = 'CIC' THEN B.LOKASI WHEN B.LOKASI IS NULL THEN 'TERMINAL' ELSE CONCAT(B.LOKASI,'0', B.TIER) END AS 'LOKASI', 
			E.KD_CONT_TIPE AS 'TIPE', E.ISO_CODE, D.NETTO, E.BRUTO, E.JNS_CONT, E.PEL_BONGKAR, 
			E.PEL_MUAT, F.NO_SEAL , rd.PLUG_END_DATE
			FROM t_gatepass A 
			LEFT JOIN t_spk_cont B ON A.NO_CONT = B.NO_CONT 
			LEFT JOIN t_spk C ON A.NO_DOK = C.NO_DOK AND A.TGL_DOK = C.TGL_DOK 
			LEFT JOIN t_permit_hdr D ON D.NO_DOK_INOUT = A.NO_DOK 
			LEFT JOIN t_cocostscont E ON E.NO_CONT = A.NO_CONT 
			LEFT JOIN t_op_delivery F ON F.NO_CONT = A.NO_CONT
			LEFT JOIN t_autogate_send_customs G ON A.NO_CONT = G.CONTAINER_ID AND A.NO_DOK = G.DOCUMENT_NO
			LEFT JOIN req_delivery_hdr rh ON A.NO_DOK = rh.NO_DOK
			LEFT JOIN (SELECT * FROM req_delivery_dtl WHERE PLUG_END_DATE IS NOT NULL)  rd ON rh.ID_REQ = rd.ID_REQ
			WHERE A.ID ='$id' GROUP BY A.ID LIMIT 1";

			//update valde
			// $SQL="SELECT G.*,A.*, C.NO_SPK, CASE WHEN LEFT(B.LOKASI,3) = 'CIC' THEN B.LOKASI WHEN B.LOKASI IS NULL THEN 'TERMINAL' ELSE CONCAT(B.LOKASI,'0', B.TIER) END AS 'LOKASI', 
			// E.KD_CONT_TIPE AS 'TIPE', E.ISO_CODE, D.NETTO, E.BRUTO, E.JNS_CONT, E.PEL_BONGKAR, 
			// E.PEL_MUAT, F.NO_SEAL , rd.PLUG_END_DATE
			// FROM t_gatepass A 
			// LEFT JOIN t_spk_cont B ON A.NO_CONT = B.NO_CONT 
			// LEFT JOIN t_spk C ON A.NO_DOK = C.NO_DOK AND A.TGL_DOK = C.TGL_DOK 
			// LEFT JOIN t_permit_hdr D ON D.NO_DOK_INOUT = A.NO_DOK 
			// LEFT JOIN t_cocostscont E ON E.NO_CONT = A.NO_CONT 
			// LEFT JOIN t_op_delivery F ON F.NO_CONT = A.NO_CONT
			// LEFT JOIN t_autogate_send_customs G ON A.NO_CONT = G.CONTAINER_ID AND A.NO_DOK = G.DOCUMENT_NO
			// LEFT JOIN req_delivery_hdr rh ON A.NO_DOK = rh.NO_DOK
			// LEFT JOIN (SELECT * FROM req_delivery_dtl WHERE PLUG_END_DATE IS NOT NULL)  rd ON rh.ID_REQ = rd.ID_REQ
			// WHERE A.ID ='$id' order by E.ID DESC LIMIT 1";

			/*$SQL = "SELECT A.*,C.NO_SPK, CASE WHEN
					LEFT(LOKASI,3) = 'CIC' THEN LOKASI WHEN LOKASI IS NULL THEN 'TERMINAL' ELSE CONCAT(LOKASI,'0', TIER) END AS 'LOKASI', E.TIPE_CONT AS 'TIPE', E.ISO_CODE, D.NETTO
					FROM t_gatepass A
					INNER JOIN t_spk_cont B ON A.NO_CONT = B.NO_CONT 
					INNER JOIN t_spk C ON A.NO_DOK = C.NO_DOK AND A.TGL_DOK = C.TGL_DOK
					INNER JOIN t_permit_hdr D ON D.NO_DOK_INOUT = A.NO_DOK
					INNER JOIN t_permit_cont E ON D.ID = D.ID
					WHERE A.ID ='$id'
					GROUP BY A.ID";*/
			//echo $SQL;die();
			$result = $func->main->get_result($SQL);

			if($result){
				foreach($SQL->result_array() as $row => $value){
					$arrdata[] = $value;
				}
				return $arrdata;
			}else {
				redirect(site_url(), 'refresh');
			}
		}else if($act=="mail"){
			//echo "string";die();
			$arrid = explode("~",$id);
			$SQL = "SELECT * FROM reff_mail WHERE ID = '$id'";//.$this->db->escape($arrid[0]);
			$result = $func->main->get_result($SQL);
			//print_r($SQL);die();
			if($result){
				foreach($SQL->result_array() as $row => $value){
					$arrdata = $value;
				}
				return $arrdata;
			}else {
				redirect(site_url(), 'refresh');
			}
		}else if($act=="user"){
			//echo "string";die();
			//$arrdata['groups'] = $func->main->get_combobox("SELECT * FROM reff_group", "ID", "NAMA", TRUE);
			$arrid = explode("~",$id);
			if ($id != ''){
				$SQL = "SELECT * FROM reff_user WHERE ID = '$id'";//.$this->db->escape($arrid[0]);
				$result = $func->main->get_result($SQL);
				//print_r($SQL);die();
				if($result){
					foreach($SQL->result_array() as $row => $value){
						$arrdata = $value;
					}
					return $arrdata;
				}else {
					redirect(site_url(), 'refresh');
				}
			}
		}else if($act=="lokasi"){
			//$arrid = explode("~",$id);
			//$SQL = "SELECT * FROM t_job_slip WHERE ID_JOB_SLIP = '$id'";//.$this->db->escape($arrid[0]);
			/*$SQL = "SELECT A.NO_SPK,A.NO_DOK, B.UKR_CONT, C.*, D.JNS_KEGIATAN
					FROM t_spk A INNER JOIN t_spk_cont B
					ON A.ID = B.ID
					INNER JOIN t_job_slip C
					ON A.NO_SPK = C.NO_SPK
					INNER JOIN t_gatepass D ON D.NO_CONT = B.NO_CONT AND D.`STATUS` = 'WAITING' AND D.JNS_KEGIATAN IS NOT NULL
					WHERE C.ID_JOB_SLIP = '$id' AND C.JNS_JOB_SLIP IS NOT NULL
					GROUP BY A.NO_SPK";*/
					
			$SQL_ID_JOB = "SELECT * FROM t_job_slip WHERE ID_JOB_SLIP = '$id'";
			$RESULTID = $this->db->query($SQL_ID_JOB)->result_array();
			
			$NO_GATEPASS = count($RESULTID[0]['NO_GATEPASS']);
			//print_r("sini".count($NO_GATEPASS));die();
			if($NO_GATEPASS != 0){
				$SQL = "SELECT A.NO_SPK,A.NO_DOK, B.UKR_CONT, C.*, D.JNS_KEGIATAN, D.ID
						FROM t_spk A
						INNER JOIN t_spk_cont B ON A.ID = B.ID
						INNER JOIN t_job_slip C ON A.NO_SPK = C.NO_SPK
						INNER JOIN t_gatepass D ON D.NO_CONT = B.NO_CONT AND D.JNS_KEGIATAN IS NOT NULL AND C.NO_GATEPASS = D.ID -- AND D.`STATUS` = 'WAITING'
						WHERE C.ID_JOB_SLIP = '$id' AND C.JNS_JOB_SLIP IS NOT NULL
						GROUP BY A.NO_SPK";
			}else{
				$SQL = "SELECT A.NO_SPK,A.NO_DOK, B.UKR_CONT, C.*, D.JNS_KEGIATAN, D.ID
						FROM t_spk A
						INNER JOIN t_spk_cont B ON A.ID = B.ID
						INNER JOIN t_job_slip C ON A.NO_SPK = C.NO_SPK
						LEFT JOIN t_gatepass D ON D.NO_CONT = B.NO_CONT
						WHERE C.ID_JOB_SLIP = '$id' AND C.JNS_JOB_SLIP IS NOT NULL
						GROUP BY A.NO_SPK";
			}
			
			
			//print_r($SQL);die();
			$result = $func->main->get_result($SQL);
			if($result){
				foreach($SQL->result_array() as $row => $value){
					$arrdata = $value;
				}
				return $arrdata;
			}else {
				redirect(site_url(), 'refresh');
			}
		}else if($act=="lokasi2"){
			$arrid = explode("~",$id);
			//print_r($id);// die();
			//$SQL = "SELECT * FROM t_job_slip WHERE ID_JOB_SLIP = '$id'";//.$this->db->escape($arrid[0]);
			$SQL = "SELECT A.NO_SPK, B.UKR_CONT, C.*
					FROM t_spk A INNER JOIN t_spk_cont B
					ON A.ID = B.ID
					INNER JOIN t_job_slip C
					ON A.NO_SPK = C.NO_SPK
					WHERE C.ID_JOB_SLIP = '$id' AND C.JNS_JOB_SLIP IS NOT NULL";
					//echo $SQL; die();
			$result = $func->main->get_result($SQL);
			if($result){
				foreach($SQL->result_array() as $row => $value){
					$arrdata = $value;
				}
				return $arrdata;
			}else {
				redirect(site_url(), 'refresh');
			}
		}else if($act=="kapal_release"){
			//print_r($id);die();
			$arrid = explode("~",$id);
			$SQL = "SELECT * FROM t_jadwal_kapal WHERE ID = '$id'";//.$this->db->escape($arrid[0]);
			$result = $func->main->get_result($SQL);
			//print_r($SQL);die();
			if($result){
				foreach($SQL->result_array() as $row => $value){
					$arrdata = $value;
				}
				return $arrdata;
			}else {
				redirect(site_url(), 'refresh');
			}
		}else if($act=="cetak_spk"){
			//print_r($id);die();
			$func->main->log_prints($id, $act);
			$arrid = explode("~",$id);
			/*$SQL= "SELECT A.NO_SPK, DATE_FORMAT(A.TGL_SPK,'%d-%m-%Y') AS 'TGL_SPK' ,A.NO_DOK, CASE WHEN A.JNS_DOK = '19' THEN 'SPJM' ELSE 'SPPMP' END AS 'JENIS_DOKUMEN', B.NO_CONT, B.UKR_CONT
					FROM t_spk A, t_spk_cont B WHERE A.ID = B.ID AND A.ID = '$id'";*/

			$SQL = "SELECT A.NO_SPK, DATE_FORMAT(A.TGL_SPK,'%d-%m-%Y') AS 'TGL_SPK',
					A.NO_DOK, C.NAMA AS JENIS_DOKUMEN, B.NO_CONT, B.UKR_CONT
					FROM t_spk A, t_spk_cont B, reff_kode_dok_bc C
					WHERE A.ID = B.ID AND A.JNS_DOK = C.ID AND A.ID = '$id'";
			$result = $func->main->get_result($SQL);
			if($result){
				foreach($SQL->result_array() as $row => $value){
					$arrdata[] = $value;
				}
				return $arrdata;
			}else {
				redirect(site_url(), 'refresh');
			}
		}else if($act=="nota_del"){
			//print_r($id);die();
			$func->main->log_prints($id, $act);
			$arrid = explode("~",$id);
			//$SQL = "SELECT * FROM req_delivery_dtl WHERE ID_REQ = '$id'";
			$SQL = "
				SELECT 'PENUMPUKAN 1' AS TITLE, IFNULL(DATE_FORMAT(A.M2_START_DATE,'%d-%m-%Y'), '') AS 'START', IFNULL(DATE_FORMAT(A.M2_END_DATE,'%d-%m-%Y'), '') AS 'END', A.SELISIH_M2 AS HARI, A.UKR_CONT AS SIZE, A.ISO_CODE AS TYPE, A.STATUS,
						  COUNT(DISTINCT A.NO_CONT) AS BOX, A.CHARGE * A.PROSEN_M2 AS TARIF, SUM(A.TOTAL_M2) AS JUMLAH
				FROM req_delivery_dtl A INNER JOIN m_tarif B
				ON A.TARIF_ID = B.TARIF_ID
				WHERE A.ID_REQ = '$id'
						AND B.JENIS_BIAYA = 'PENUMPUKAN'
				GROUP BY 'PENUMPUKAN 1', A.M2_START_DATE, A.M2_END_DATE, A.SELISIH_M2, A.UKR_CONT, A.ISO_CODE, A.STATUS, A.CHARGE

				UNION ALL

				SELECT 'PENUMPUKAN 1.1' AS TITLE, IFNULL(DATE_FORMAT(A.M3_START_DATE,'%d-%m-%Y'), '') AS 'START', IFNULL(DATE_FORMAT(A.M3_END_DATE,'%d-%m-%Y'), '') AS 'END', A.SELISIH_M3 AS HARI, A.UKR_CONT AS SIZE, A.ISO_CODE AS TYPE, A.STATUS,
						  COUNT(DISTINCT A.NO_CONT) AS BOX, A.CHARGE * A.PROSEN_M3 AS TARIF, SUM(A.TOTAL_M3) AS JUMLAH
				FROM req_delivery_dtl A INNER JOIN m_tarif B
				ON A.TARIF_ID = B.TARIF_ID
				WHERE A.ID_REQ = '$id'
						AND B.JENIS_BIAYA = 'PENUMPUKAN'
				GROUP BY 'PENUMPUKAN 1.1', A.M3_START_DATE, A.M3_END_DATE, A.SELISIH_M3, A.UKR_CONT, A.ISO_CODE, A.STATUS, A.CHARGE

				UNION ALL

				SELECT 'PENUMPUKAN 2' AS TITLE, IFNULL(DATE_FORMAT(A.M4_START_DATE,'%d-%m-%Y'), '') AS 'START', IFNULL(DATE_FORMAT(A.M4_END_DATE,'%d-%m-%Y'), '') AS 'END', A.SELISIH_M4 AS HARI, A.UKR_CONT AS SIZE, A.ISO_CODE AS TYPE, A.STATUS,
						  COUNT(DISTINCT A.NO_CONT) AS BOX, A.CHARGE * A.PROSEN_M4 AS TARIF, SUM(A.TOTAL_M4) AS JUMLAH
				FROM req_delivery_dtl A INNER JOIN m_tarif B
				ON A.TARIF_ID = B.TARIF_ID
				WHERE A.ID_REQ = '$id'
						AND B.JENIS_BIAYA = 'PENUMPUKAN'
				GROUP BY 'PENUMPUKAN 2', A.M4_START_DATE, A.M4_END_DATE, A.SELISIH_M4, A.UKR_CONT, A.ISO_CODE, A.STATUS, A.CHARGE

				UNION ALL

				SELECT 'DENDA SPPB 1' AS TITLE, IFNULL(DATE_FORMAT(A.M2_START_DATE,'%d-%m-%Y'), '') AS 'START', IFNULL(DATE_FORMAT(A.M2_END_DATE,'%d-%m-%Y'), '') AS 'END', A.SELISIH_M2 AS HARI, A.UKR_CONT AS SIZE, A.ISO_CODE AS TYPE, A.STATUS,
						  COUNT(DISTINCT A.NO_CONT) AS BOX, A.CHARGE * A.PROSEN_M2 * 2 AS TARIF, SUM(A.TOTAL_M2) AS JUMLAH
				FROM req_delivery_dtl A INNER JOIN m_tarif B
				ON A.TARIF_ID = B.TARIF_ID
				WHERE A.ID_REQ = '$id'
						AND B.JENIS_BIAYA = 'SPPB'
						AND A.TOTAL_M2 > 0
				GROUP BY 'DENDA SPPB 1', A.M2_START_DATE, A.M2_END_DATE, A.SELISIH_M2, A.UKR_CONT, A.ISO_CODE, A.STATUS, A.CHARGE

				UNION ALL

				SELECT 'DENDA SPPB 1.1' AS TITLE, IFNULL(DATE_FORMAT(A.M3_START_DATE,'%d-%m-%Y'), '') AS 'START', IFNULL(DATE_FORMAT(A.M3_END_DATE,'%d-%m-%Y'), '') AS 'END', A.SELISIH_M3 AS HARI, A.UKR_CONT AS SIZE, A.ISO_CODE AS TYPE, A.STATUS,
						  COUNT(DISTINCT A.NO_CONT) AS BOX, A.CHARGE * A.PROSEN_M3 * 2 AS TARIF, SUM(A.TOTAL_M3) AS JUMLAH
				FROM req_delivery_dtl A INNER JOIN m_tarif B
				ON A.TARIF_ID = B.TARIF_ID
				WHERE A.ID_REQ = '$id'
						AND B.JENIS_BIAYA = 'SPPB'
						AND A.TOTAL_M2 > 0
				GROUP BY 'DENDA SPPB 1.1', A.M3_START_DATE, A.M3_END_DATE, A.SELISIH_M3, A.UKR_CONT, A.ISO_CODE, A.STATUS, A.CHARGE

				UNION ALL

				SELECT 'DENDA SPPB 2' AS TITLE, IFNULL(DATE_FORMAT(A.M4_START_DATE,'%d-%m-%Y'), '') AS 'START', IFNULL(DATE_FORMAT(A.M4_END_DATE,'%d-%m-%Y'), '') AS 'END', A.SELISIH_M4 AS HARI, A.UKR_CONT AS SIZE, A.ISO_CODE AS TYPE, A.STATUS,
						  COUNT(DISTINCT A.NO_CONT) AS BOX, A.CHARGE * A.PROSEN_M4 * 2 AS TARIF, SUM(A.TOTAL_M4) AS JUMLAH
				FROM req_delivery_dtl A INNER JOIN m_tarif B
				ON A.TARIF_ID = B.TARIF_ID
				WHERE A.ID_REQ = '$id'
						AND B.JENIS_BIAYA = 'SPPB'
						AND A.TOTAL_M4 > 0
				GROUP BY 'DENDA SPPB 2', A.M4_START_DATE, A.M4_END_DATE, A.SELISIH_M4, A.UKR_CONT, A.ISO_CODE, A.STATUS, A.CHARGE


				UNION ALL

				SELECT 'DENDA SP2 1' AS TITLE, IFNULL(DATE_FORMAT(A.M2_START_DATE,'%d-%m-%Y'), '') AS 'START', IFNULL(DATE_FORMAT(A.M2_END_DATE,'%d-%m-%Y'), '') AS 'END', A.SELISIH_M2 AS HARI, A.UKR_CONT AS SIZE, A.ISO_CODE AS TYPE, A.STATUS,
						  COUNT(DISTINCT A.NO_CONT) AS BOX, A.CHARGE * A.PROSEN_M2 * 3 AS TARIF, SUM(A.TOTAL_M2) AS JUMLAH
				FROM req_delivery_dtl A INNER JOIN m_tarif B
				ON A.TARIF_ID = B.TARIF_ID
				WHERE A.ID_REQ = '$id'
						AND B.JENIS_BIAYA = 'SP2'
						AND A.TOTAL_M2 > 0
				GROUP BY 'DENDA SP2 1', A.M2_START_DATE, A.M2_END_DATE, A.SELISIH_M2, A.UKR_CONT, A.ISO_CODE, A.STATUS, A.CHARGE

				UNION ALL

				SELECT 'DENDA SP2 1.1' AS TITLE, IFNULL(DATE_FORMAT(A.M3_START_DATE,'%d-%m-%Y'), '') AS 'START', IFNULL(DATE_FORMAT(A.M3_END_DATE,'%d-%m-%Y'), '') AS 'END', A.SELISIH_M3 AS HARI, A.UKR_CONT AS SIZE, A.ISO_CODE AS TYPE, A.STATUS,
						  COUNT(DISTINCT A.NO_CONT) AS BOX, A.CHARGE * A.PROSEN_M3 * 3  AS TARIF, SUM(A.TOTAL_M3) AS JUMLAH
				FROM req_delivery_dtl A INNER JOIN m_tarif B
				ON A.TARIF_ID = B.TARIF_ID
				WHERE A.ID_REQ = '$id'
						AND B.JENIS_BIAYA = 'SP2'
						AND A.TOTAL_M3 > 0
				GROUP BY 'DENDA SP2 1.1', A.M3_START_DATE, A.M3_END_DATE, A.SELISIH_M3, A.UKR_CONT, A.ISO_CODE, A.STATUS, A.CHARGE

				UNION ALL

				SELECT 'DENDA SP2 2' AS TITLE, IFNULL(DATE_FORMAT(A.M4_START_DATE,'%d-%m-%Y'), '') AS 'START', IFNULL(DATE_FORMAT(A.M4_END_DATE,'%d-%m-%Y'), '') AS 'END', A.SELISIH_M4 AS HARI, A.UKR_CONT AS SIZE, A.ISO_CODE AS TYPE, A.STATUS,
						  COUNT(DISTINCT A.NO_CONT) AS BOX, A.CHARGE * A.PROSEN_M4 * 3 AS TARIF, SUM(A.TOTAL_M4) AS JUMLAH
				FROM req_delivery_dtl A INNER JOIN m_tarif B
				ON A.TARIF_ID = B.TARIF_ID
				WHERE A.ID_REQ = '$id'
						AND B.JENIS_BIAYA = 'SP2'
						AND A.TOTAL_M4 > 0
				GROUP BY 'DENDA SP2 2', A.M4_START_DATE, A.M4_END_DATE, A.SELISIH_M4, A.UKR_CONT, A.ISO_CODE, A.STATUS, A.CHARGE

				UNION ALL

				SELECT 'LIFT ON' AS TITLE, IFNULL(DATE_FORMAT(A.M4_START_DATE,'%d-%m-%Y'), '') AS 'START', IFNULL(DATE_FORMAT(A.M4_END_DATE,'%d-%m-%Y'), '') AS 'END', A.SELISIH_M4 AS 'HARI',
				A.UKR_CONT AS 'SIZE', A.ISO_CODE AS 'TYPE', A.STATUS AS 'STATUS', COUNT(A.NO_CONT) AS 'BOX', A.CHARGE AS 'TARIF',
				SUM(A.TOTAL) AS JUMLAH
				FROM req_delivery_dtl A INNER JOIN m_tarif B
				ON A.TARIF_ID = B.TARIF_ID
				WHERE A.ID_REQ = '$id'
						AND B.JENIS_BIAYA = 'LIFT ON'
				GROUP BY A.CHARGE
			";
			//print_r($SQL);die();
			$result = $func->main->get_result($SQL);
			//print_r($SQL);die();
			if($result){
				foreach($SQL->result_array() as $row => $value){
					$arrdata[] = $value;
				}
				return $arrdata;
			}else {
				redirect(site_url(), 'refresh');
			}
		}else if($act=="nota_del_hdr"){
			//print_r($id);die();
			$arrid = explode("~",$id);
			$SQL = "SELECT * FROM req_delivery_hdr WHERE ID_REQ = '$id'";
			//print_r($SQL);die();
			$result = $func->main->get_result($SQL);
			//print_r($SQL);die();
			if($result){
				foreach($SQL->result_array() as $row => $value){
					$arrdata[] = $value;
				}
				return $arrdata;
			}else {
				redirect(site_url(), 'refresh');
			}
		}else if($act=="nota_ext"){
			//print_r($id);die();
			$arrid = explode("~",$id);
			//$SQL = "SELECT * FROM req_delivery_dtl WHERE ID_REQ = '$id'";
			$SQL = "
				SELECT 'PENUMPUKAN 1' AS TITLE, A.M2_START_DATE AS START, A.M2_END_DATE AS END, A.SELISIH_M2 AS HARI, A.UKR_CONT AS SIZE, A.ISO_CODE AS TYPE, A.STATUS,
						  COUNT(DISTINCT A.NO_CONT) AS BOX, A.CHARGE * A.PROSEN_M2 AS TARIF, SUM(A.TOTAL_M2) AS TOTAL
				FROM req_delivery_dtl A INNER JOIN m_tarif B
				ON A.TARIF_ID = B.TARIF_ID
				WHERE A.ID_REQ = '$id'
						AND B.JENIS_BIAYA = 'PENUMPUKAN'
						AND A.TOTAL_M2 > 0
				GROUP BY 'PENUMPUKAN 1', A.M2_START_DATE, A.M2_END_DATE, A.SELISIH_M2, A.UKR_CONT, A.ISO_CODE, A.STATUS, A.CHARGE

				UNION ALL

				SELECT 'PENUMPUKAN 1.1' AS TITLE, A.M3_START_DATE AS START, A.M3_END_DATE AS END, A.SELISIH_M3 AS HARI, A.UKR_CONT AS SIZE, A.ISO_CODE AS TYPE, A.STATUS,
						  COUNT(DISTINCT A.NO_CONT) AS BOX, A.CHARGE * A.PROSEN_M3 AS TARIF, SUM(A.TOTAL_M3) AS TOTAL
				FROM req_delivery_dtl A INNER JOIN m_tarif B
				ON A.TARIF_ID = B.TARIF_ID
				WHERE A.ID_REQ = '$id'
						AND B.JENIS_BIAYA = 'PENUMPUKAN'
						AND A.TOTAL_M3 > 0
				GROUP BY 'PENUMPUKAN 1.1', A.M3_START_DATE, A.M3_END_DATE, A.SELISIH_M3, A.UKR_CONT, A.ISO_CODE, A.STATUS, A.CHARGE

				UNION ALL

				SELECT 'PENUMPUKAN 2' AS TITLE, A.M4_START_DATE AS START, A.M4_END_DATE AS END, A.SELISIH_M4 AS HARI, A.UKR_CONT AS SIZE, A.ISO_CODE AS TYPE, A.STATUS,
						  COUNT(DISTINCT A.NO_CONT) AS BOX, A.CHARGE * A.PROSEN_M4 AS TARIF, SUM(A.TOTAL_M4) AS TOTAL
				FROM req_delivery_dtl A INNER JOIN m_tarif B
				ON A.TARIF_ID = B.TARIF_ID
				WHERE A.ID_REQ = '$id'
						AND B.JENIS_BIAYA = 'PENUMPUKAN'
						AND A.TOTAL_M4 > 0
				GROUP BY 'PENUMPUKAN 2', A.M4_START_DATE, A.M4_END_DATE, A.SELISIH_M4, A.UKR_CONT, A.ISO_CODE, A.STATUS, A.CHARGE

				UNION ALL

				SELECT 'DENDA SP2 1' AS TITLE, A.M2_START_DATE AS START, A.M2_END_DATE AS END, A.SELISIH_M2 AS HARI, A.UKR_CONT AS SIZE, A.ISO_CODE AS TYPE, A.STATUS,
						  COUNT(DISTINCT A.NO_CONT) AS BOX, A.CHARGE * A.PROSEN_M2 * 3 AS TARIF, SUM(A.TOTAL_M2) AS TOTAL
				FROM req_delivery_dtl A INNER JOIN m_tarif B
				ON A.TARIF_ID = B.TARIF_ID
				WHERE A.ID_REQ = '$id'
						AND B.JENIS_BIAYA = 'SP2'
						AND A.TOTAL_M2 > 0
				GROUP BY 'DENDA SP2 1', A.M2_START_DATE, A.M2_END_DATE, A.SELISIH_M2, A.UKR_CONT, A.ISO_CODE, A.STATUS, A.CHARGE

				UNION ALL

				SELECT 'DENDA SP2 1.1' AS TITLE, A.M3_START_DATE AS START, A.M3_END_DATE AS END, A.SELISIH_M3 AS HARI, A.UKR_CONT AS SIZE, A.ISO_CODE AS TYPE, A.STATUS,
						  COUNT(DISTINCT A.NO_CONT) AS BOX, A.CHARGE * A.PROSEN_M3 * 3 AS TARIF, SUM(A.TOTAL_M3) AS TOTAL
				FROM req_delivery_dtl A INNER JOIN m_tarif B
				ON A.TARIF_ID = B.TARIF_ID
				WHERE A.ID_REQ = '$id'
						AND B.JENIS_BIAYA = 'SP2'
						AND A.TOTAL_M3 > 0
				GROUP BY 'DENDA SP2 1.1', A.M3_START_DATE, A.M3_END_DATE, A.SELISIH_M3, A.UKR_CONT, A.ISO_CODE, A.STATUS, A.CHARGE

				UNION ALL

				SELECT 'DENDA SP2 2' AS TITLE, A.M4_START_DATE AS START, A.M4_END_DATE AS END, A.SELISIH_M4 AS HARI, A.UKR_CONT AS SIZE, A.ISO_CODE AS TYPE, A.STATUS,
						  COUNT(DISTINCT A.NO_CONT) AS BOX, A.CHARGE * A.PROSEN_M4 * 3 AS TARIF, SUM(A.TOTAL_M4) AS TOTAL
				FROM req_delivery_dtl A INNER JOIN m_tarif B
				ON A.TARIF_ID = B.TARIF_ID
				WHERE A.ID_REQ = '$id'
						AND B.JENIS_BIAYA = 'SP2'
						AND A.TOTAL_M4 > 0
				GROUP BY 'DENDA SP2 2', A.M4_START_DATE, A.M4_END_DATE, A.SELISIH_M4, A.UKR_CONT, A.ISO_CODE, A.STATUS, A.CHARGE
			";
			//print_r($SQL);die();
			$result = $func->main->get_result($SQL);
			//print_r($SQL);die();
			if($result){
				foreach($SQL->result_array() as $row => $value){
					$arrdata[] = $value;
				}
				return $arrdata;
			}else {
				redirect(site_url(), 'refresh');
			}
		}else if($act=="nota_ext_hdr"){
			//print_r($id);die();
			$arrid = explode("~",$id);
			$SQL = "SELECT * FROM req_delivery_hdr WHERE ID_REQ = '$id'";
			//print_r($SQL);die();
			$result = $func->main->get_result($SQL);
			//print_r($SQL);die();
			if($result){
				foreach($SQL->result_array() as $row => $value){
					$arrdata[] = $value;
				}
				return $arrdata;
			}else {
				redirect(site_url(), 'refresh');
			}
		}else if($act=="nota_cust"){
			//print_r($id);die();
			$arrid = explode("~",$id);
			/*$SQL = "SELECT A.*, B.* FROM m_pelanggan A, req_delivery_hdr B WHERE A.NPWP = B.NPWP AND B.ID_REQ = '$id'";*/
			$SQL = "SELECT A.*, B.*
					FROM m_pelanggan A, req_delivery_hdr B
					WHERE REPLACE(
					REPLACE(A.NPWP,'.',''),'-','') =
					REPLACE(
					REPLACE(B.NPWP,'.',''),'-','') AND B.ID_REQ = '$id'";
			$result = $func->main->get_result($SQL);
			//print_r($SQL);die();
			if($result){
				foreach($SQL->result_array() as $row => $value){
					$arrdata[] = $value;
				}
				return $arrdata;
			}else {
				redirect(site_url(), 'refresh');
			}
		}else if($act == "dokbc"){
			$arrid = explode("~",$id);
			$SQL = "SELECT * FROM reff_kode_dok_bc WHERE ID=$id";//.$this->db->escape($arrid[0]);
			$result = $func->main->get_result($SQL);
			//print_r($SQL);die();
			if($result){
				foreach($SQL->result_array() as $row => $value){
					$arrdata = $value;
				}
				return $arrdata;
			}else {
				redirect(site_url(), 'refresh');
			}
		}else if($act=="nota_cont"){
			//print_r($id);
			$arrid = explode("~",$id);
			$SQL = "SELECT GROUP_CONCAT(DISTINCT NO_CONT,'-',UKR_CONT) AS 'NO_KONTAINER' FROM req_delivery_dtl WHERE ID_REQ = '$id'";
			//echo $SQL;die();
			//print_r($SQL);die();
			$result = $func->main->get_result($SQL);
			//print_r($SQL);die();
			if($result){
				foreach($SQL->result_array() as $row => $value){
					$arrdata[] = $value;
				}
				return $arrdata;
			}else {
				redirect(site_url(), 'refresh');
			}
		}else if($act == "nota_beh"){
			//print_r($id);die();
			$arrid = explode("~",$id);
			$SQL = "SELECT GROUP_CONCAT(DISTINCT NO_CONT,'-',UK_CONT) AS 'NO_KONTAINER' FROM req_behandle_dtl WHERE ID_REQ = '$arrid[0]'";
			$result = $func->main->get_result($SQL);
			//print_r($SQL);die();
			if($result){
				foreach($SQL->result_array() as $row => $value){
					$arrdata[] = $value;
				}
				return $arrdata;
			}else {
				redirect(site_url(), 'refresh');
			}
		}else if($act=="nota_behandle"){
			//print_r($id);die();
			$func->main->log_prints($id, $act);
			//die($id);
			$arrid = explode("~",$id);
			//$SQL = "SELECT * FROM req_delivery_dtl WHERE ID_REQ = '$id'";
			$SQL = "
				SELECT ID_REQ,'PAKET BEHANDLE' AS 'TITLE', UK_CONT AS 'SIZE', COUNT(NO_CONT) AS 'BOX',NO_CONT ,
				CASE WHEN JNS_KEGIATAN = 1 THEN 'PAKET 1' ELSE 'PAKET 2' END AS PAKET, TOTAL AS 'TARIF', SUM(TOTAL) AS TOTAL
				FROM req_behandle_dtl WHERE ID_REQ = '$arrid[0]' GROUP BY UK_CONT, PAKET
			";
			//print_r($SQL);die();
			$result = $func->main->get_result($SQL);
			//print_r($SQL);die();
			if($result){
				foreach($SQL->result_array() as $row => $value){
					$arrdata[] = $value;
				}
				return $arrdata;
			}else {
				redirect(site_url(), 'refresh');
			}
		}else if($act=="nota_behandle_hdr"){
			//print_r($id);die();
			$arrid = explode("~",$id);
			$SQL = "SELECT * FROM req_behandle_hdr WHERE ID_REQ = '$arrid[0]'";
			$result = $func->main->get_result($SQL);
			//print_r($SQL);die();
			if($result){
				foreach($SQL->result_array() as $row => $value){
					$arrdata[] = $value;
				}
				return $arrdata;
			}else {
				redirect(site_url(), 'refresh');
			}
		}else if($act=="nota_simulasi"){
			//print_r($id);die();
			$arrid = explode("~",$id);
			//$SQL = "SELECT * FROM req_simulasi_dtl WHERE ID_REQ = '$id'";
			$SQL = "
				SELECT 'PENUMPUKAN 1' AS TITLE, IFNULL(DATE_FORMAT(A.M2_START_DATE,'%d-%m-%Y'), '') AS 'START', IFNULL(DATE_FORMAT(A.M2_END_DATE,'%d-%m-%Y'), '') AS 'END', A.SELISIH_M2 AS HARI, A.UKR_CONT AS SIZE, A.ISO_CODE AS TYPE, A.STATUS,
						  COUNT(DISTINCT A.NO_CONT) AS BOX, A.CHARGE * A.PROSEN_M2 AS TARIF, SUM(A.TOTAL_M2) AS JUMLAH
				FROM req_simulasi_dtl A INNER JOIN m_tarif B
				ON A.TARIF_ID = B.TARIF_ID
				WHERE A.ID_REQ = '$id'
						AND B.JENIS_BIAYA = 'PENUMPUKAN'
				GROUP BY 'PENUMPUKAN 1', A.M2_START_DATE, A.M2_END_DATE, A.SELISIH_M2, A.UKR_CONT, A.ISO_CODE, A.STATUS, A.CHARGE

				UNION ALL

				SELECT 'PENUMPUKAN 1.1' AS TITLE, IFNULL(DATE_FORMAT(A.M3_START_DATE,'%d-%m-%Y'), '') AS 'START', IFNULL(DATE_FORMAT(A.M3_END_DATE,'%d-%m-%Y'), '') AS 'END', A.SELISIH_M3 AS HARI, A.UKR_CONT AS SIZE, A.ISO_CODE AS TYPE, A.STATUS,
						  COUNT(DISTINCT A.NO_CONT) AS BOX, A.CHARGE * A.PROSEN_M3 AS TARIF, SUM(A.TOTAL_M3) AS JUMLAH
				FROM req_simulasi_dtl A INNER JOIN m_tarif B
				ON A.TARIF_ID = B.TARIF_ID
				WHERE A.ID_REQ = '$id'
						AND B.JENIS_BIAYA = 'PENUMPUKAN'
				GROUP BY 'PENUMPUKAN 1.1', A.M3_START_DATE, A.M3_END_DATE, A.SELISIH_M3, A.UKR_CONT, A.ISO_CODE, A.STATUS, A.CHARGE

				UNION ALL

				SELECT 'PENUMPUKAN 2' AS TITLE, IFNULL(DATE_FORMAT(A.M4_START_DATE,'%d-%m-%Y'), '') AS 'START', IFNULL(DATE_FORMAT(A.M4_END_DATE,'%d-%m-%Y'), '') AS 'END', A.SELISIH_M4 AS HARI, A.UKR_CONT AS SIZE, A.ISO_CODE AS TYPE, A.STATUS,
						  COUNT(DISTINCT A.NO_CONT) AS BOX, A.CHARGE * A.PROSEN_M4 AS TARIF, SUM(A.TOTAL_M4) AS JUMLAH
				FROM req_simulasi_dtl A INNER JOIN m_tarif B
				ON A.TARIF_ID = B.TARIF_ID
				WHERE A.ID_REQ = '$id'
						AND B.JENIS_BIAYA = 'PENUMPUKAN'
				GROUP BY 'PENUMPUKAN 2', A.M4_START_DATE, A.M4_END_DATE, A.SELISIH_M4, A.UKR_CONT, A.ISO_CODE, A.STATUS, A.CHARGE

				UNION ALL

				SELECT 'DENDA SPPB 1' AS TITLE, IFNULL(DATE_FORMAT(A.M2_START_DATE,'%d-%m-%Y'), '') AS 'START', IFNULL(DATE_FORMAT(A.M2_END_DATE,'%d-%m-%Y'), '') AS 'END', A.SELISIH_M2 AS HARI, A.UKR_CONT AS SIZE, A.ISO_CODE AS TYPE, A.STATUS,
						  COUNT(DISTINCT A.NO_CONT) AS BOX, A.CHARGE * A.PROSEN_M2 AS TARIF, SUM(A.TOTAL_M2) AS JUMLAH
				FROM req_simulasi_dtl A INNER JOIN m_tarif B
				ON A.TARIF_ID = B.TARIF_ID
				WHERE A.ID_REQ = '$id'
						AND B.JENIS_BIAYA = 'SPPB'
						AND A.TOTAL_M2 > 0
				GROUP BY 'DENDA SPPB 1', A.M2_START_DATE, A.M2_END_DATE, A.SELISIH_M2, A.UKR_CONT, A.ISO_CODE, A.STATUS, A.CHARGE

				UNION ALL

				SELECT 'DENDA SPPB 1.1' AS TITLE, IFNULL(DATE_FORMAT(A.M3_START_DATE,'%d-%m-%Y'), '') AS 'START', IFNULL(DATE_FORMAT(A.M3_END_DATE,'%d-%m-%Y'), '') AS 'END', A.SELISIH_M3 AS HARI, A.UKR_CONT AS SIZE, A.ISO_CODE AS TYPE, A.STATUS,
						  COUNT(DISTINCT A.NO_CONT) AS BOX, A.CHARGE * A.PROSEN_M3 AS TARIF, SUM(A.TOTAL_M3) AS JUMLAH
				FROM req_simulasi_dtl A INNER JOIN m_tarif B
				ON A.TARIF_ID = B.TARIF_ID
				WHERE A.ID_REQ = '$id'
						AND B.JENIS_BIAYA = 'SPPB'
						AND A.TOTAL_M2 > 0
				GROUP BY 'DENDA SPPB 1.1', A.M3_START_DATE, A.M3_END_DATE, A.SELISIH_M3, A.UKR_CONT, A.ISO_CODE, A.STATUS, A.CHARGE

				UNION ALL

				SELECT 'DENDA SPPB 2' AS TITLE, IFNULL(DATE_FORMAT(A.M4_START_DATE,'%d-%m-%Y'), '') AS 'START', IFNULL(DATE_FORMAT(A.M4_END_DATE,'%d-%m-%Y'), '') AS 'END', A.SELISIH_M4 AS HARI, A.UKR_CONT AS SIZE, A.ISO_CODE AS TYPE, A.STATUS,
						  COUNT(DISTINCT A.NO_CONT) AS BOX, A.CHARGE * A.PROSEN_M4 AS TARIF, SUM(A.TOTAL_M4) AS JUMLAH
				FROM req_simulasi_dtl A INNER JOIN m_tarif B
				ON A.TARIF_ID = B.TARIF_ID
				WHERE A.ID_REQ = '$id'
						AND B.JENIS_BIAYA = 'SPPB'
						AND A.TOTAL_M4 > 0
				GROUP BY 'DENDA SPPB 2', A.M4_START_DATE, A.M4_END_DATE, A.SELISIH_M4, A.UKR_CONT, A.ISO_CODE, A.STATUS, A.CHARGE


				UNION ALL

				SELECT 'DENDA SP2 1' AS TITLE, IFNULL(DATE_FORMAT(A.M2_START_DATE,'%d-%m-%Y'), '') AS 'START', IFNULL(DATE_FORMAT(A.M2_END_DATE,'%d-%m-%Y'), '') AS 'END', A.SELISIH_M2 AS HARI, A.UKR_CONT AS SIZE, A.ISO_CODE AS TYPE, A.STATUS,
						  COUNT(DISTINCT A.NO_CONT) AS BOX, A.CHARGE * A.PROSEN_M2 AS TARIF, SUM(A.TOTAL_M2) AS JUMLAH
				FROM req_simulasi_dtl A INNER JOIN m_tarif B
				ON A.TARIF_ID = B.TARIF_ID
				WHERE A.ID_REQ = '$id'
						AND B.JENIS_BIAYA = 'SP2'
						AND A.TOTAL_M2 > 0
				GROUP BY 'DENDA SP2 1', A.M2_START_DATE, A.M2_END_DATE, A.SELISIH_M2, A.UKR_CONT, A.ISO_CODE, A.STATUS, A.CHARGE

				UNION ALL

				SELECT 'DENDA SP2 1.1' AS TITLE, IFNULL(DATE_FORMAT(A.M3_START_DATE,'%d-%m-%Y'), '') AS 'START', IFNULL(DATE_FORMAT(A.M3_END_DATE,'%d-%m-%Y'), '') AS 'END', A.SELISIH_M3 AS HARI, A.UKR_CONT AS SIZE, A.ISO_CODE AS TYPE, A.STATUS,
						  COUNT(DISTINCT A.NO_CONT) AS BOX, A.CHARGE * A.PROSEN_M3 AS TARIF, SUM(A.TOTAL_M3) AS JUMLAH
				FROM req_simulasi_dtl A INNER JOIN m_tarif B
				ON A.TARIF_ID = B.TARIF_ID
				WHERE A.ID_REQ = '$id'
						AND B.JENIS_BIAYA = 'SP2'
						AND A.TOTAL_M3 > 0
				GROUP BY 'DENDA SP2 1.1', A.M3_START_DATE, A.M3_END_DATE, A.SELISIH_M3, A.UKR_CONT, A.ISO_CODE, A.STATUS, A.CHARGE

				UNION ALL

				SELECT 'DENDA SP2 2' AS TITLE, IFNULL(DATE_FORMAT(A.M4_START_DATE,'%d-%m-%Y'), '') AS 'START', IFNULL(DATE_FORMAT(A.M4_END_DATE,'%d-%m-%Y'), '') AS 'END', A.SELISIH_M4 AS HARI, A.UKR_CONT AS SIZE, A.ISO_CODE AS TYPE, A.STATUS,
						  COUNT(DISTINCT A.NO_CONT) AS BOX, A.CHARGE * A.PROSEN_M4 AS TARIF, SUM(A.TOTAL_M4) AS JUMLAH
				FROM req_simulasi_dtl A INNER JOIN m_tarif B
				ON A.TARIF_ID = B.TARIF_ID
				WHERE A.ID_REQ = '$id'
						AND B.JENIS_BIAYA = 'SP2'
						AND A.TOTAL_M4 > 0
				GROUP BY 'DENDA SP2 2', A.M4_START_DATE, A.M4_END_DATE, A.SELISIH_M4, A.UKR_CONT, A.ISO_CODE, A.STATUS, A.CHARGE

				UNION ALL

				SELECT 'LIFT ON' AS TITLE, IFNULL(DATE_FORMAT(A.M4_START_DATE,'%d-%m-%Y'), '') AS 'START', IFNULL(DATE_FORMAT(A.M4_END_DATE,'%d-%m-%Y'), '') AS 'END', A.SELISIH_M4 AS 'HARI',
				A.UKR_CONT AS 'SIZE', A.ISO_CODE AS 'TYPE', A.STATUS AS 'STATUS', COUNT(A.NO_CONT) AS 'BOX', A.CHARGE AS 'TARIF',
				SUM(A.TOTAL) AS JUMLAH
				FROM req_simulasi_dtl A INNER JOIN m_tarif B
				ON A.TARIF_ID = B.TARIF_ID
				WHERE A.ID_REQ = '$id'
						AND B.JENIS_BIAYA = 'LIFT ON'
				GROUP BY A.CHARGE
			";
			//print_r($SQL);die();
			$result = $func->main->get_result($SQL);
			//print_r($SQL);die();
			if($result){
				foreach($SQL->result_array() as $row => $value){
					$arrdata[] = $value;
				}
				return $arrdata;
			}else {
				redirect(site_url(), 'refresh');
			}
		}else if($act=="nota_simulasi_hdr"){
			//print_r($id);die();
			$arrid = explode("~",$id);
			$SQL = "SELECT * FROM req_simulasi_hdr WHERE ID_REQ = '$id'";
			//print_r($SQL);die();
			$result = $func->main->get_result($SQL);
			//print_r($SQL);die();
			if($result){
				foreach($SQL->result_array() as $row => $value){
					$arrdata[] = $value;
				}
				return $arrdata;
			}else {
				redirect(site_url(), 'refresh');
			}
		}else if($act=="nota_simulasi_cust"){
			//print_r($id);die();
			$arrid = explode("~",$id);			
			$SQL = "SELECT A.*, B.* FROM m_pelanggan A, req_simulasi_hdr B WHERE REPLACE(A.NPWP,'.',''),'-','') =
					REPLACE(
					REPLACE(B.NPWP,'.',''),'-','') AND B.ID_REQ = '$id'";
			//print_r($SQL);die();
			$result = $func->main->get_result($SQL);
			//print_r($SQL);die();
			if($result){
				foreach($SQL->result_array() as $row => $value){
					$arrdata[] = $value;
				}
				return $arrdata;
			}else {
				redirect(site_url(), 'refresh');
			}
		}else if($act=="nota_simulasi_cont"){
			//print_r($id);die();
			$arrid = explode("~",$id);
			$SQL = "SELECT GROUP_CONCAT(DISTINCT NO_CONT,'-',UKR_CONT) AS 'NO_KONTAINER' FROM req_simulasi_dtl WHERE ID_REQ = '$id'";
			//print_r($SQL);die();
			$result = $func->main->get_result($SQL);
			//print_r($SQL);die();
			if($result){
				foreach($SQL->result_array() as $row => $value){
					$arrdata[] = $value;
				}
				return $arrdata;
			}else {
				redirect(site_url(), 'refresh');
			}
		}
	}

	##Model C G I S

	public function get_data_dokumen($act, $id){
		if ($act == 'spjm') {
			// $sql = $this->db->query("SELECT A.*, B.NO_CONT, KD_CONT_UKURAN FROM t_permit_hdr A INNER JOIN t_permit_cont B ON A.ID = B.ID WHERE A.ID = '$id'");
				$sql = $this->db->query("SELECT A.CAR, A.NO_POS_BC11, A.KD_KANTOR, A.FL_KARANTINA, A.NM_ANGKUT, A.NO_VOY_FLIGHT, A.NO_DAFTAR_PABEAN, DATE_FORMAT(A.TGL_DAFTAR_PABEAN,'%d-%m-%Y') AS 'TGL_PIB', A.ID_CONSIGNEE, A.CONSIGNEE, A.NPWP_PPJK, A.NAMA_PPJK, A.KD_GUDANG, A.JML_CONT, A.NO_BC11, DATE_FORMAT(A.TGL_BC11,'%d-%m-%Y') AS 'TGL_BC_11', B.NO_CONT, KD_CONT_UKURAN FROM t_permit_hdr A INNER JOIN t_permit_cont B ON A.ID = B.ID WHERE A.ID = '$id' ");
			return $sql->result();
		} elseif ($act == 'sppb') {
			/*$sql = $this->db->query("SELECT A.ID, A.CAR, A.NO_POS_BC11, A.KD_KANTOR, A.FL_KARANTINA, A.NM_ANGKUT, A.NO_VOY_FLIGHT,A.NO_DOK_INOUT,A.TGL_DOK_INOUT, A.NO_BL_AWB, DATE_FORMAT(A.TGL_DOK_INOUT,'%d-%m-%Y') AS 'TGL_SPPB', A.NO_DAFTAR_PABEAN, DATE_FORMAT(A.TGL_DAFTAR_PABEAN,'%d-%m-%Y') AS 'TGL_PIB', A.ID_CONSIGNEE, A.CONSIGNEE, A.NPWP_PPJK, A.NAMA_PPJK, A.KD_GUDANG, A.JML_CONT, A.NO_BC11, DATE_FORMAT(A.TGL_BC11,'%d-%m-%Y') AS 'TGL_BC_11', B.NO_CONT, B.KD_CONT_UKURAN, B.ISO_CODE FROM t_permit_hdr A INNER JOIN t_permit_cont B ON A.ID = B.ID WHERE A.ID = '$id' ");*/
			$sql = $this->db->query("SELECT A.ID, A.CAR, A.NO_POS_BC11, A.KD_KANTOR, A.FL_KARANTINA, A.ANGKUTNAMA_TPS AS NM_ANGKUT, A.ANGKUTNO_TPS AS NO_VOY_FLIGHT,A.NO_DOK_INOUT,A.TGL_DOK_INOUT, A.NO_BL_AWB, DATE_FORMAT(A.TGL_DOK_INOUT,'%d-%m-%Y') AS 'TGL_SPPB', A.NO_DAFTAR_PABEAN, DATE_FORMAT(A.TGL_DAFTAR_PABEAN,'%d-%m-%Y') AS 'TGL_PIB', A.ID_CONSIGNEE, A.CONSIGNEE, A.NPWP_PPJK, A.NAMA_PPJK, A.KD_GUDANG, A.JML_CONT, A.NO_BC11, DATE_FORMAT(A.TGL_BC11,'%d-%m-%Y') AS 'TGL_BC_11', B.NO_CONT, B.KD_CONT_UKURAN, B.ISO_CODE FROM t_permit_hdr A INNER JOIN t_permit_cont B ON A.ID = B.ID WHERE A.ID = '$id' ");
			return $sql->result();
		}elseif ($act == 'sppb_bill') {
			$sql = $this->db->query("SELECT A.*, B.NO_CONT, B.KD_CONT_UKURAN, B.ISO_CODE FROM t_permit_hdr A INNER JOIN
			t_permit_cont B ON A.ID = B.ID WHERE A.KD_DOK_INOUT = 1
			AND A.KD_STATUS_BIL IS NULL");
			return $sql->result();
		}elseif ($act == 'detail_sppb') {
			$sql = $this->db->query("SELECT * FROM t_permit_cont WHERE ID = '$id'");
			return $sql->result();
		}else if($act == 'spk'){
			$sql = $this->db->query("SELECT NO_SPK, TGL_SPK, JNS_DOK, NO_DOK, TGL_DOK, WK_REQ, NM_KAPAL, NO_VOY FROM t_spk WHERE ID = '$id'");
			return $sql->result();
		}else if($act == 'gate'){
			$sql = $this->db->query("SELECT * FROM t_gatepass WHERE ID = '$id'");
			return $sql->result();
		}else if($act == 'spk_cont'){
			$sql = $this->db->query("SELECT * FROM t_spk_cont WHERE ID = '$id'");
			return $sql->result();
		}elseif ($act == 'gate_pass_request_spjmn') {
			$sql = $this->db->query("SELECT * FROM t_request_cont WHERE ID = '$id'");
			return $sql->result();
		}elseif ($act == 'gate_pass_request_spjmn_detail') {
			$sql = $this->db->query("SELECT * FROM t_permit_cont WHERE ID = '$id'");
			return $sql->result();
		}elseif ($act == 'req_detail') {
			$sql = $this->db->query("SELECT * FROM t_request_cont WHERE ID = '$id'");
			return $sql->result();
		}else if($act == 'detail_sppmp'){
			$sql = $this->db->query("SELECT A.NO_CONT, A.NO_TPFT, A.UKURAN, A.KD_STATUS, B.NAMA AS STATUS FROM t_ppk_cont A
									INNER JOIN reff_status_cont B
									ON B.ID = A.KD_STATUS
									WHERE A.ID_IJIN = '$id'
									AND A.NO_TPFT IS NOT NULL");
			return $sql->result();
		}else if($act == 'detail_dok_manual'){
			$exp_id = explode('~', $id);
			$arrid_post = $exp_id[0];
			$sql = $this->db->query("SELECT B.NO_CONT, NO_DOK_INOUT, B.KD_CONT_UKURAN
									FROM t_permit_hdr A INNER JOIN t_permit_cont B
									ON A.ID = B.ID
									WHERE A.ID = '$arrid_post'");
			return $sql->result();
		}else if($act == 'detail_spk'){
			$sql = $this->db->query("SELECT A.*,CONCAT('<span style=\"color:green;font-weight:bold\">', B.KETERANGAN,'</span>') AS 'STATUS' FROM t_spk_cont A, reff_status_spk B WHERE B.ID = A.STATUS_CONT AND A.ID = '$id'");//print_r($sql);die();
			
			return $sql->result();
		}else if ($act == 'detail_kapal') {
			$sql = $this->db->query("SELECT * FROM t_jadwal_kapal WHERE ID = '$id'");
			return $sql->result();
		}else if ($act == 'delivery_hdr') {
			//$sql = $this->db->query("SELECT * FROM req_delivery_hdr WHERE ID_REQ = '$id'");
			$sql = $this->db->query("SELECT A.* , B.NAMA_CUST, B.NPWP
					FROM req_delivery_hdr A LEFT JOIN m_pelanggan B ON REPLACE(REPLACE(A.NPWP,'.',''),'-','') = REPLACE(REPLACE(B.NPWP,'.',''),'-','')
					WHERE A.ID_REQ = '$id'");
			/*$sql = $this->db->query("SELECT A.* , B.CONSIGNEE AS 'NAMA_CUST'
					FROM req_delivery_hdr A INNER JOIN t_permit_hdr B ON A.NPWP = B.ID_CONSIGNEE AND B.NO_DOK_INOUT = A.NO_DOK
					WHERE ID_REQ = '$id'");*/
			//print_r($sql);die();
			return $sql->result();
		}else if ($act == 'delivery_dtl') {
			$sql = $this->db->query("SELECT DISTINCT NO_CONT, ID_REQ, UKR_CONT FROM req_delivery_dtl WHERE ID_REQ = '$id' AND NO_CONT IS NOT NULL");
			//print_r($sql);die();
			return $sql->result();
		}elseif($act == 'spk'){
			$sql = $this->db->query("SELECT * FROM t_spk WHERE ID = '$id'");
			return $sql->result();
		}else if($act == 'spk_cont'){
			// print_r($id);die();
			$sql = $this->db->query("SELECT * FROM t_spk_cont WHERE ID = '$id'");
			return $sql->result();
		}else if($act == 'behandle1'){
			$arrid = explode("~",$id);
			$sql = $this->db->query("SELECT A.NO_SPK ,A.TGL_SPK , CASE WHEN A.JNS_DOK = 19 THEN 'SPJM' ELSE 'SPPMP' END AS JNS_DOK,
										CASE WHEN B.JNS_KEGIATAN = 1 THEN 'BEHANDLE 1' ELSE 'BEHANDLE 2' END AS JNS_KEGIATAN,
										A.NO_DOK, B.NM_KAPAL, B.NO_VOY, B.NAMA_CUST, B.NPWP, B.NO_DO, B.NO_BL FROM t_spk A INNER JOIN req_behandle_hdr B ON A.NO_DOK = B.NO_DOK WHERE B.ID_REQ = '$arrid[0]'");
			return $sql->result_array();
		}else if($act == 'behandle2'){
			$arrid = explode("~",$id);
			$sql = $this->db->query("SELECT DISTINCT A.JNS_DOK, A.NO_DOK, A.TGL_DOK, CASE WHEN B.JNS_KEGIATAN = 1 THEN 'BEHANDLE 1' ELSE 'BEHANDLE 2' END AS JNS_KEGIATAN,
										B.NAMA_CUST, B.NPWP, B.NO_DO, B.NO_BL FROM t_gatepass A INNER JOIN req_behandle_hdr B ON A.NO_DOK = B.NO_DOK WHERE B.ID_REQ = '$arrid[0]'");
			return $sql->result_array();
		}else if($act == 'delivery'){
			$arrid = explode("~",$id);
			$sql = $this->db->query("SELECT A.NM_KAPAL, A.NO_VOY, B.NAMA_CUST, A.NPWP, A.NO_DO, A.TGL_DOK, A.NO_DOK, A.EXPIRED
											FROM req_delivery_hdr A LEFT JOIN m_pelanggan B ON REPLACE(
											REPLACE(A.NPWP,'.',''),'-','') =
											REPLACE(
											REPLACE(B.NPWP,'.',''),'-','')
											WHERE A.ID_REQ = '$arrid[0]'");
			return $sql->result_array();
		}else if($act == 'cek_behandle'){
			$arrid = explode("~",$id);
			$sql = $this->db->query("SELECT JNS_KEGIATAN FROM req_behandle_hdr WHERE ID_REQ = '$arrid[0]'");
			return $sql->row();
		}else if($act == "gate"){
			$sql = $this->db->query("SELECT * FROM t_gatepass WHERE ID = '$id'");
			return $sql->result();
		}
	}
	
	function cek_data($act,$id){
		$func = get_instance();
        $func->load->model("m_main", "main", true);
		$KD_TPS = $this->session->userdata('KD_TPS');
		$KD_GUDANG = $this->session->userdata('KD_GUDANG');
		$error = 0;
		$result = 0;
		if($act == "active_gatepass"){
			$SQL = "SELECT FL_ACTIVE FROM t_gatepass WHERE ID = '$id'";
			$Active = $this->db->query($SQL)->row()->FL_ACTIVE;
			$SQL2= "SELECT A.NO_CONT, A.FL_ACTIVE, B.LOKASI_AWAL,B.LOKASI_AKHIR FROM t_gatepass A
					INNER JOIN t_job_slip B ON B.NO_CONT = A.NO_CONT AND B.NO_GATEPASS = A.ID
					WHERE A.ID = '$id' AND B.STATUS = 'WAITING' -- AND B.OPERATOR IS NOT NULL
					GROUP BY A.NO_CONT";
			$CIC = $this->db->query($SQL2)->row()->LOKASI_AKHIR;
			$CICA = $this->db->query($SQL2)->row()->LOKASI_AWAL;
			$NO_CONT = $this->db->query($SQL2)->row()->NO_CONT;
			 
	
			$CIC_ACT = substr($CIC,0,3);
			$CIC_AWL = substr($CICA,0,2);
			
			if ($CIC_AWL == '' && $CIC_ACT == '' || $CIC_AWL == 'NULL' && $CIC_ACT == 'NULL'){
				$this->db->delete('t_job_slip', array('NO_CONT' => $NO_CONT , 'LOKASI_AWAL' => NULL, 'LOKASI_AKHIR' => NULL));
			}

			if($CIC_ACT == 'CIC'){
				if($Active == "N"){
					$DATA['FL_ACTIVE'] = "Y";
					$DATA['WK_ACTIVE'] = date('Y-m-d H:i:s');
					$this->db->where(array('ID' => $id));
					$this->db->update('t_gatepass', $DATA);
				}else{
					$message = "Data sudah pernah diproses !";
					$error=1;
				}
			}else{
				$message = "Lakukan Stacking CIC dahulu !";
				$error=1;
				
			}
			
			if($error == 0){
				$action = '/planning/get_pass_behandle/post';
				echo "MSG#OK#Data berhasil diproses#".site_url().$action;
			}else{
				echo "MSG#ERR#".$message."#";
			}
		}else if($act == "active_pkblr"){
			$SQL = "SELECT * FROM t_gatepass WHERE ID = '$id'";
			$Active = $this->db->query($SQL)->row();
			if ($Active != '' || $Active != 'NULL') {
				$DATA['RESPON'] = "PKB LR";
				$DATA['WK_RESPON'] = date('Y-m-d H:i:s');
				$this->db->where(array('ID' => $id));
				$this->db->update('t_gatepass', $DATA);
				$messagedone = "Data berhasil diproses";
				$error=0;
			}else{
				$message = "Error Respon Customs";
				$error=1;
			}

			if($error == 0){
				echo "MSG#OK#DATA BERHASIL DIPROSES#".$messagedone."#";
			}else{
				echo "MSG#ERR#".$message."#";
			}
		}else if($act == "active_pkbyard"){
			$SQL = "SELECT * FROM t_gatepass WHERE ID = '$id'";
			$Active = $this->db->query($SQL)->row();
			if ($Active != '' || $Active != 'NULL') {
				$DATA['RESPON'] = "PKB YARD";
				$DATA['WK_RESPON'] = date('Y-m-d H:i:s');
				$this->db->where(array('ID' => $id));
				$this->db->update('t_gatepass', $DATA);
				$messagedone = "Data berhasil diproses";
				$error=0;
			}else{
				$message = "Error Respon Customs";
				$error=1;
			}
			
			if($error == 0){
				echo "MSG#OK#DATA BERHASIL DIPROSES#".$messagedone."#";
			}else{
				echo "MSG#ERR#".$message."#";
			}
		}else if($act == "active_pkbyardn"){
			$SQL = "SELECT * FROM t_gatepass WHERE ID = '$id'";
			$Active = $this->db->query($SQL)->row();
			if ($Active != '' || $Active != 'NULL') {
				$DATA['RESPON'] = "PKB YARD N";
				$DATA['WK_RESPON'] = date('Y-m-d H:i:s');
				$this->db->where(array('ID' => $id));
				$this->db->update('t_gatepass', $DATA);
				$messagedone = "Data berhasil diproses";
				$error=0;
			}else{
				$message = "Error Respon Customs";
				$error=1;
			}

			if($error == 0){
				echo "MSG#OK#DATA BERHASIL DIPROSES#".$messagedone."#";
			}else{
				echo "MSG#ERR#".$message."#";
			}
		}else if($act == "delete_gatepass"){
			$error = 0;

			$SQL = $this->db->query("SELECT * FROM t_gatepass WHERE ID = '".$id."'")->result_array();
			$SQL[0]['NO_CONT'];
			$SQL[0]['JNS_DOK'];
			$SQL[0]['JNS_KEGIATAN'];

			if($SQL[0]['JNS_KEGIATAN'] == '1'){
				if($SQL[0]['JNS_DOK'] == 'SPPMP'){
					$this->db->where(array('NO_CONT' => $SQL[0]['NO_CONT']));
				 	$this->db->update('t_ppk_cont', array('FL_GATEPASS' => 'N'));
				}else{
				 	$this->db->where(array('NO_CONT' => $SQL[0]['NO_CONT']));
				 	$this->db->update('t_permit_cont', array('FL_GATEPASS' => 'N'));
				}
				$this->db->where(array('ID' => $id));
				$this->db->delete('t_gatepass');

				if($error == 0){
					$action = '/planning/get_pass_behandle/post';
					echo "MSG#OK#Data berhasil diproses#".site_url().$action;
				}else{
					echo "MSG#ERR#".$message."#";
				}
			}else if ($SQL[0]['JNS_KEGIATAN'] == '2') {
				$this->db->where(array('NO_CONT' => $SQL[0]['NO_CONT'], 'JNS_KEGIATAN' => '1'));
				$this->db->update('t_gatepass', array('FL_USE' => 'N'));

				$this->db->where(array('ID' => $id));
				$this->db->delete('t_gatepass');

				if($error == 0){
					$action = '/planning/get_pass_behandle2/post';
					echo "MSG#OK#Data berhasil diproses#".site_url().$action;
				}else{
					echo "MSG#ERR#".$message."#";
				}
			}
		}else{
			$SQL = "SELECT * FROM t_gatepass WHERE ID = '$id'";
			$Active = $this->db->query($SQL)->row();
			if ($Active != '' || $Active != 'NULL') {
				$DATA['RESPON'] = "PKB PRIORITAS";
				$DATA['WK_RESPON'] = date('Y-m-d H:i:s');
				$this->db->where(array('ID' => $id));
				$this->db->update('t_gatepass', $DATA);
				$messagedone = "Data berhasil diproses";
				$error=0;
			}else{
				$message = "Error Respon Customs";
				$error=1;
			}

			if($error == 0){
				echo "MSG#OK#DATA BERHASIL DIPROSES#".$messagedone."#";
			}else{
				echo "MSG#ERR#".$message."#";
			}
		}
	}
	
}

	