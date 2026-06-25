<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_billing_behandle_materai extends CI_Model {

	public $variable;

	public function __construct()
	{
		parent::__construct();
		
	}

	public function behandle($act, $id){
		//echo json_encode($_POST);die();
		$page_title = 'BILLING BEHANDLE';
		$title = "BILLING BEHANDLE";
		$this->newtable->breadcrumb('Billing', 'javascript:void(0)','');
		$this->newtable->breadcrumb('Behandle', 'javascript:void(0)','');
		$check = (grant()=="W")?true:false;
		$SQLTEMP1 = "SELECT DISTINCT CONCAT('REQUEST: ','<span style=\"color:green;font-weight:bold\">',A.ID_REQ,'</span>','<BR>','TANGGAL: ',A.TGL_REQ) AS REQUEST, CONCAT('CUSTOMER: ',A.NAMA_CUST,'<BR>','NPWP: ',A.NPWP) AS CUSTOMER, CONCAT('DOKUMEN: ','<span style=\"color:green;font-weight:bold\">',A.NO_DOK,'</span>','<BR>','TANGGAL: ',DATE(A.TGL_DOK)) AS DOKUMEN, 
		CASE WHEN A.NO_NOTA_BEHANDLE IS NOT NULL AND A.VAID IS NOT NULL THEN CONCAT('NOTA: ','<span style=\"color:green;font-weight:bold\">',A.NO_NOTA_BEHANDLE,'</span>','<BR>','TANGGAL: ',A.TGL_NOTA) WHEN A.NO_NOTA_BEHANDLE IS NULL AND A.VAID IS NOT NULL THEN CONCAT('PAYMENT: ','<span style=\"color:green;font-weight:bold\">',A.VAID,'</span>','<BR>','TANGGAL: ',A.WK_PAYMENT) WHEN A.NO_NOTA_BEHANDLE IS NOT NULL AND A.VAID IS NULL THEN CONCAT('NOTA: ','<span style=\"color:green;font-weight:bold\">',A.NO_NOTA_BEHANDLE,'</span>','<BR>','TANGGAL: ',A.TGL_NOTA) ELSE '' END AS PEMBAYARAN, IF(A.NO_NOTA_BEHANDLE IS NULL AND A.VAID IS NULL,'',CONCAT('BANK: ','<span style=\"color:green;font-weight:bold\">',E.NAMA_BANK,'</span>','<BR>','REKENING: ',E.REKENING)) AS BANK, CONCAT('<span style=\"color:red;font-weight:bold\">','Rp. ', FORMAT(A.TOTAL_JUMLAH,0),'</span>') AS TOTAL,
		A.ID_REQ, A.TGL_REQ, A.NO_DOK, A.NO_NOTA_BEHANDLE, A.BANK_ID
		FROM req_behandle_hdr A
		LEFT JOIN t_gatepass B ON B.NO_DOK = A.NO_DOK AND B.JNS_KEGIATAN IS NOT NULL
		LEFT JOIN m_bank E ON A.BANK_ID = E.BANK_ID
		WHERE A.ID > (select max(A.ID)-50 from req_behandle_hdr)";
		$SQLTEMP2 = "SELECT DISTINCT CONCAT('REQUEST: ','<span style=\"color:green;font-weight:bold\">',A.ID_REQ,'</span>','<BR>','TANGGAL: ',A.TGL_REQ) AS REQUEST, CONCAT('CUSTOMER: ',A.NAMA_CUST,'<BR>','NPWP: ',A.NPWP) AS CUSTOMER, CONCAT('DOKUMEN: ','<span style=\"color:green;font-weight:bold\">',A.NO_DOK,'</span>','<BR>','TANGGAL: ',DATE(A.TGL_DOK)) AS DOKUMEN, 
		CASE WHEN A.NO_NOTA_BEHANDLE IS NOT NULL AND A.VAID IS NOT NULL THEN CONCAT('NOTA: ','<span style=\"color:green;font-weight:bold\">',A.NO_NOTA_BEHANDLE,'</span>','<BR>','TANGGAL: ',A.TGL_NOTA) WHEN A.NO_NOTA_BEHANDLE IS NULL AND A.VAID IS NOT NULL THEN CONCAT('PAYMENT: ','<span style=\"color:green;font-weight:bold\">',A.VAID,'</span>','<BR>','TANGGAL: ',A.WK_PAYMENT) WHEN A.NO_NOTA_BEHANDLE IS NOT NULL AND A.VAID IS NULL THEN CONCAT('NOTA: ','<span style=\"color:green;font-weight:bold\">',A.NO_NOTA_BEHANDLE,'</span>','<BR>','TANGGAL: ',A.TGL_NOTA) ELSE '' END AS PEMBAYARAN, IF(A.NO_NOTA_BEHANDLE IS NULL AND A.VAID IS NULL,'',CONCAT('BANK: ','<span style=\"color:green;font-weight:bold\">',E.NAMA_BANK,'</span>','<BR>','REKENING: ',E.REKENING)) AS BANK, CONCAT('<span style=\"color:red;font-weight:bold\">','Rp. ', FORMAT(A.TOTAL_JUMLAH,0),'</span>') AS TOTAL,
		A.ID_REQ, A.TGL_REQ, A.NO_DOK, A.NO_NOTA_BEHANDLE, A.BANK_ID
		FROM req_behandle_hdr A
		LEFT JOIN t_gatepass B ON B.NO_DOK = A.NO_DOK AND B.JNS_KEGIATAN IS NOT NULL
		LEFT JOIN m_bank E ON A.BANK_ID = E.BANK_ID
		WHERE 1=1";

		if ($_POST['ajax'] == 1) {
			$dat = '';
			foreach ($_POST['form'] as $key => $value) {
				if ($value[0] != "") {
					$dat = 'ada';
				}
			}
			echo $dat;
			if ($dat == 'ada') {
				$SQL = $SQLTEMP2;
			}else{
				$SQL = $SQLTEMP1;
			}
		}else {
			$SQL = $SQLTEMP1;
		}

			$proses = array('ENTRY'  => array('MODAL',"billingBehandle/behandle_add", '','','md-plus-circle','', 'menu'),
			'CETAK'  => array('PRINT',"billingBehandle/cetak_nota_behandle", '0','','md-print','','list'),
			'CONFIRM' => array('MODAL',"billingBehandle/behandle_confirm", '1','','md-confirmation-number','', 'list'),
			'HISTORY' => array('MODAL',"billingBehandle/behandle_history", '1', '', 'md-watch','','list'),
			'DELETE'  => array('DELETE',"billingBehandle/behandle_del", '1','','md-close-circle','', 'menu'),
			'UPDATE' => array('MODAL',"billingBehandle/behandle_update", '1','NOT-NULL','md-edit','','list'));
		$this->newtable->multiple_search(true);
		$this->newtable->show_chk(true);
		$this->newtable->show_menu($check);
		$this->newtable->show_search(true);
		$arr_bank = array(""=>"","232006"=>"MANDIRI","265006"=>"BCA");
		$this->newtable->search(array(array('ID_REQ','ID REQUEST'),array('A.NO_NOTA_BEHANDLE','NO. NOTA'),array('A.NO_DOK','NO. DOKUMEN'),array('A.NAMA_CUST','CUSTOMER'),array('E.BANK_ID','NAMA BANK','OPTION',$arr_bank)));
		$this->newtable->action(site_url() . "/billingBehandle/behandle");
		$this->newtable->tipe_proses('button');
		$this->newtable->keys(array("ID_REQ","NO_DOK","NO_NOTA_BEHANDLE"));
		$this->newtable->hiddens(array("ID_REQ","TGL_REQ","NO_DOK","NO_NOTA_BEHANDLE","BANK_ID"));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby(1);
		$this->newtable->groupby(array("A.ID_REQ"));
		$this->newtable->sortby("DESC");
		$this->newtable->validasi(array("A.NO_NOTA_BEHANDLE"));
		$this->newtable->rowcount(10);
		$this->newtable->set_formid("tblbehandle");
		$this->newtable->set_divid("divtblbehandle");
		$this->newtable->clear();
		$this->newtable->menu($proses);
		$tabel .= $this->newtable->generate($SQL);
		$arrdata = array("page_title" => $page_title, "title" => $title, "content" => $tabel);
		if($this->input->post("ajax")||$act == "post"){
			echo $tabel;
		}else{
			return $arrdata;
		}
	}

	public function behandle_spjm($act, $id){
		$page_title = 'Behandle SPJM';
		$title = "";
		$this->newtable->breadcrumb('Billing', 'javascript:void(0)','');
		$this->newtable->breadcrumb('Behandle', 'javascript:void(0)','');
		$check = (grant()=="W")?true:false;
		$SQLTEMP1 = "SELECT DISTINCT A.ID AS 'ID', C.JNS_DOK AS 'JENIS DOKUMEN', A.NO_DAFTAR_PABEAN AS 'NO DOKUMEN', A.TGL_DAFTAR_PABEAN AS 'TGL DOKUMEN', A.NM_ANGKUT AS 'NAMA KAPAL', A.NO_VOY_FLIGHT AS 'NO VOYAGE'
			FROM t_permit_hdr A
			INNER JOIN t_permit_cont B ON A.ID = B.ID
			INNER JOIN t_gatepass C ON A.NO_DAFTAR_PABEAN = C.NO_DOK AND B.NO_CONT = C.NO_CONT AND C.JNS_KEGIATAN IN ('1','2')
			INNER JOIN t_op_inspection D ON B.NO_CONT = D.NO_CONT AND C.NO_CONT = D.NO_CONT AND D.STATUS = 'DONE'
			WHERE C.FL_BIL IS NULL AND A.KD_DOK_INOUT !='1' and DATE(A.TGL_STATUS) > DATE_ADD(NOW() , INTERVAL -20 day)";
		$SQLTEMP2 = "SELECT DISTINCT A.ID AS 'ID', C.JNS_DOK AS 'JENIS DOKUMEN', A.NO_DAFTAR_PABEAN AS 'NO DOKUMEN', A.TGL_DAFTAR_PABEAN AS 'TGL DOKUMEN', A.NM_ANGKUT AS 'NAMA KAPAL', A.NO_VOY_FLIGHT AS 'NO VOYAGE'
			FROM t_permit_hdr A
			INNER JOIN t_permit_cont B ON A.ID = B.ID
			INNER JOIN t_gatepass C ON A.NO_DAFTAR_PABEAN = C.NO_DOK AND B.NO_CONT = C.NO_CONT AND C.JNS_KEGIATAN IN ('1','2')
			INNER JOIN t_op_inspection D ON B.NO_CONT = D.NO_CONT AND C.NO_CONT = D.NO_CONT AND D.STATUS = 'DONE'
			WHERE C.FL_BIL IS NULL AND A.KD_DOK_INOUT !='1'";
		
		if ($_POST['ajax'] == 1) {
			$dat = '';
			foreach ($_POST['form'] as $key => $value) {
				if ($value[0] != "") {
					$dat = 'ada';
				}
			}
			echo $dat;
			if ($dat == 'ada') {
				$SQL = $SQLTEMP2;
			}else{
				$SQL = $SQLTEMP1;
			}
		}else {
			$SQL = $SQLTEMP1;
		}
		
		$this->newtable->multiple_search(true);
		$this->newtable->show_chk(false);
		$this->newtable->show_menu($check);
		$this->newtable->show_search(true);
		$this->newtable->search(array(array('C.JNS_DOK','JENIS DOKUMEN'),array('A.NO_DAFTAR_PABEAN','NO. DOKUMEN'),array('C.NO_CONT','NO. KONTAINER')));
		$this->newtable->action(site_url() . "/billingBehandle/behandle_spjm/post");
		$this->newtable->detail(array('POPUP',"billingBehandle/behandlespjm_detail"));
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("ID"));
		$this->newtable->keys(array("ID"));
		$this->newtable->cidb($this->db);
		$this->newtable->set_formid("tblbehandle1");
		$this->newtable->set_divid("divtblbehandle1");
		$this->newtable->groupby();
		$this->newtable->sortby("DESC");
		$this->newtable->rowcount(10);
		$this->newtable->clear();
		$this->newtable->menu($proses);
		$tabel .= $this->newtable->generate($SQL);
		$arrdata = array("page_title" => $page_title, "title" => $title, "content" => $tabel);
		if($this->input->post("ajax")||$act == "post"){
			echo $tabel;
		}else{
			return $arrdata;
		}
	}

	public function behandle_sppmp($act, $id){
		$page_title = 'Behandle';
		$title = "";
		$this->newtable->breadcrumb('Billing', 'javascript:void(0)','');
		$this->newtable->breadcrumb('Behandle', 'javascript:void(0)','');
		$check = (grant()=="W")?true:false;
		$SQLTEMP1 = "SELECT DISTINCT A.ID_IJIN AS 'ID', C.JNS_DOK AS 'JENIS DOKUMEN', A.NO_RESPON AS 'NO DOKUMEN', A.TG_RESPON AS 'TGL DOKUMEN', A.ANGKUTNAMA AS 'NAMA KAPAL', A.ANGKUTNO AS 'NO VOYAGE'
				FROM t_ppk_hdr A
				INNER JOIN t_ppk_cont B ON A.ID_IJIN = B.ID_IJIN
				INNER JOIN t_gatepass C ON A.NO_RESPON = C.NO_DOK AND B.NO_CONT = C.NO_CONT
				INNER JOIN t_op_inspection D ON B.NO_CONT = D.NO_CONT AND C.NO_CONT = D.NO_CONT AND D.STATUS = 'DONE'
				WHERE C.FL_BIL IS NULL and DATE(A.TG_RESPON) > DATE_ADD(NOW() , INTERVAL -20 day)";
		$SQLTEMP2 = "SELECT DISTINCT A.ID_IJIN AS 'ID', C.JNS_DOK AS 'JENIS DOKUMEN', A.NO_RESPON AS 'NO DOKUMEN', A.TG_RESPON AS 'TGL DOKUMEN', A.ANGKUTNAMA AS 'NAMA KAPAL', A.ANGKUTNO AS 'NO VOYAGE'
				FROM t_ppk_hdr A
				INNER JOIN t_ppk_cont B ON A.ID_IJIN = B.ID_IJIN
				INNER JOIN t_gatepass C ON A.NO_RESPON = C.NO_DOK AND B.NO_CONT = C.NO_CONT
				INNER JOIN t_op_inspection D ON B.NO_CONT = D.NO_CONT AND C.NO_CONT = D.NO_CONT AND D.STATUS = 'DONE'
				WHERE C.FL_BIL IS NULL";

		if ($_POST['ajax'] == 1) {
			$dat = '';
			foreach ($_POST['form'] as $key => $value) {
				if ($value[0] != "") {
					$dat = 'ada';
				}
			}
			echo $dat;
			if ($dat == 'ada') {
				$SQL = $SQLTEMP2;
			}else{
				$SQL = $SQLTEMP1;
			}
		}else {
			$SQL = $SQLTEMP1;
		}

		$this->newtable->multiple_search(true);
		$this->newtable->show_chk(false);
		$this->newtable->show_menu($check);
		$this->newtable->show_search(true);
		$this->newtable->search(array(array('C.JNS_DOK','JENIS DOKUMEN'),array('A.NO_RESPON','NO. DOKUMEN'),array('C.NO_CONT','NO. KONTAINER')));
		$this->newtable->action(site_url() . "/billingBehandle/behandle_sppmp/post");
		$this->newtable->detail(array('POPUP',"billingBehandle/behandlesppmp_detail"));
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("ID"));
		$this->newtable->keys(array("ID"));
		$this->newtable->cidb($this->db);
		$this->newtable->set_formid("tblbehandle2");
		$this->newtable->set_divid("divtblbehandle2");
		$this->newtable->groupby(array("A.NO_RESPON"));
		$this->newtable->sortby("DESC");
		$this->newtable->rowcount(10);
		$this->newtable->clear();
		$this->newtable->menu($proses);
		$tabel .= $this->newtable->generate($SQL);
		$arrdata = array("page_title" => $page_title, "title" => $title, "content" => $tabel);
		if($this->input->post("ajax")||$act == "post"){
			echo $tabel;
		}else{
			return $arrdata;
		}
	}

	public function process($type,$act,$id){
        $error = 0;
		if($act=="behandle"){
			foreach($this->input->post('DATA') as $a => $b){
				if($b=="") unset($DATA[$a]);
				else $DATA[$a] = strtoupper(trim($b));
			}

			$seq = $this->db->query("SELECT MAX(id) AS 'urut' FROM req_behandle_hdr")->row()->urut;
			$norut = $seq + 1;

			$REQ = "BHD/".date('Y-m-d')."/".$norut;
			$DATA_BHD['ID_REQ'] = $REQ;
			$DATA_BHD['JNS_DOK'] = $DATA['JNS_DOK'];
			$DATA_BHD['NO_DOK'] = $DATA['NO_DOK'];
			$DATA_BHD['TGL_DOK'] = $DATA['TGL_DOK'];
			$DATA_BHD['NM_KAPAL'] = $DATA['NM_KAPAL'];
			$DATA_BHD['NO_VOY'] = $DATA['NO_VOY'];
			$DATA_BHD['NO_DO'] = $DATA['NO_DO'];
			$DATA_BHD['NO_BL'] = $DATA['NO_BL'];
			$DATA_BHD['TGL_REQ'] = date('Y-m-d H:i:s');
			$DATA_BHD['NAMA_CUST'] = $DATA['CUSTOMER'];
			$DATA_BHD['OPERATOR'] = $this->session->userdata('USERLOGIN');
			$DATA_BHD['NPWP'] = $DATA['NPWP'];

			$this->db->insert('req_behandle_hdr', $DATA_BHD);
			$this->db->where(array('NO_DOK' =>$DATA['NO_DOK']));
			$this->db->update('t_gatepass', array('FL_BIL' => 'DONE'));

			foreach($this->input->post('DT[]') as $a => $b){
				foreach($b as $value){
					if($value=="") unset($DT[$a]);
					else $DT[$a][] = strtoupper(trim($value));
				}
			}
	
			$jumlah_dipilih = count($DT['NO_CONT']);
			$sub_total = 0;
			$tarif=0;
			$seal=0;

			for($x=0; $x<$jumlah_dipilih; $x++){
				$DETAIL = array();
				$SIZE = array();
				$SIZE = $DT['UKR_CONT'][$x];
				$KET = $DT['JNS_KEGIATAN'][$x];

				if ($KET == 'BEHANDLE 1') {
					$KEGIATAN = 1;
				}else if ($KET == 'BEHANDLE 2'){
					$KEGIATAN = 2;
				}else if ($KET == 'BEHANDLE JOIN'){
					$KEGIATAN = 3;
				}

				$nmkpl = $DATA_BHD['NM_KAPAL'];
				$novy = $DATA_BHD['NO_VOY'];
				echo "nama kapal".$nmkpl."<br>";
				echo "nama voy".$novy;
				$kapalsandar = $this->db->query("SELECT * from t_cocostshdr where date(TGL_TIBA) >= date('2021-04-15') and NM_ANGKUT = '$nmkpl' and NO_VOY_FLIGHT = '$novy'")->num_rows();
				if ($kapalsandar == 1) {
					$SQL = $this->db->query("SELECT * FROM m_tarif2 WHERE SIZE = '$SIZE' AND JENIS_BIAYA = 'PAKET BEHANDLE' AND KET LIKE '$KEGIATAN'")->row();	
				}else{
					$SQL = $this->db->query("SELECT * FROM m_tarif WHERE SIZE = '$SIZE' AND JENIS_BIAYA = 'PAKET BEHANDLE' AND KET LIKE '$KEGIATAN'")->row();
				}

				
				$SQL2 = $this->db->query("SELECT * FROM m_tarif WHERE JENIS_BIAYA = 'SEAL'")->row();
				$sub_total = $sub_total + $SQL->TARIF;
				//$tarif= $SQL->TARIF + $SQL2->TARIF;
				$seal=$seal+$SQL2->TARIF;

				if ($KET == 'BEHANDLE JOIN'){
					$KEGIATAN = 'JOIN';
				}

				$DETAIL['ID_REQ'] = $REQ;
				$DETAIL['NO_CONT'] = $DT['NO_CONT'][$x];
				$DETAIL['UK_CONT'] = $DT['UKR_CONT'][$x];
				$DETAIL['JNS_KEGIATAN'] = $KEGIATAN;
				$DETAIL['TOTAL'] = $SQL->TARIF; 
				$this->db->insert('req_behandle_dtl',$DETAIL);

				// INSERT SIMKEU
				if ($DETAIL['TOTAL'] > 0) {
					$SIM['ID_REQ'] = $REQ ;
					$SIM['NO_CONT'] = $DT['NO_CONT'][$x];
					$SIM['UKR_CONT'] = $DT['UKR_CONT'][$x];
					$SIM['CHARGE'] = $SQL->TARIF;
					$SIM['JENIS_TARIF'] = 'BEHANDLE '.$KEGIATAN;
					$SIM['TOTAL'] = $SQL->TARIF;
					$SIM['WK_REKAM'] = date('Y-m-d H:i:s');
					$this->db->insert('req_delivery_simkeu',$SIM);
				}
			}

				$SUM_MAX_ID = $this->db->query("SELECT ID_REQ AS 'ID' FROM req_behandle_dtl WHERE ID_REQ IN
												(SELECT ID_REQ FROM req_behandle_dtl WHERE SUBSTRING(ID_REQ, 16) =
												(SELECT IFNULL(COUNT(id_req),1) AS 'urut' FROM req_behandle_hdr))")->row()->ID;
				$SQL_MAX = $this->db->query("SELECT MAX(ID) AS ID FROM req_behandle_hdr")->row()->ID;
				$MAX_ID = $SQL_MAX;
				$sub_total1 = $this->db->query("SELECT SUM(TOTAL) AS TOTAL FROM req_behandle_dtl WHERE ID_REQ = '$REQ'")->row()->TOTAL;
				$BA = $this->db->query("SELECT TARIF AS 'Tarif' FROM m_tarif WHERE JENIS_BIAYA = 'ADMINISTRASI'")->row()->Tarif;

				$sub_totalA = $sub_total1 + $BA + $seal;
				$PPN = $sub_totalA * 0.11;
				// $PPN = 0;

				$sub_totalBM  = $sub_totalA + $PPN;
				if($sub_totalBM > 5000000){
					$MAT = 10000;
				} else {
					$MAT = 0;
				}

				$TOTAL_ALL = $sub_totalA + $PPN + $MAT;
				$DATA_HDR_BH['BIAYA_ADMIN'] = $BA;
				$DATA_HDR_BH['BIAYA_MATERAI'] = $MAT;
				$DATA_HDR_BH['SUBTOTAL'] = $sub_total1;
				$DATA_HDR_BH['PPN'] = $PPN;
				$DATA_HDR_BH['SEAL'] = $seal;
				$DATA_HDR_BH['TOTAL_JUMLAH'] = $TOTAL_ALL;
				$this->db->where(array('ID_REQ' => $REQ));
				$this->db->update('req_behandle_hdr', $DATA_HDR_BH);


				// INSERT SIMKEU
				$SIM_MAT['ID_REQ'] = $REQ ;
				$SIM_MAT['CHARGE'] = $MAT;
				$SIM_MAT['JENIS_TARIF'] = 'MATERAI BHD';
				$SIM_MAT['TOTAL'] = $MAT;
				$SIM_MAT['WK_REKAM'] = date('Y-m-d H:i:s');
				print_r($SIM_MAT);
				$this->db->insert('req_delivery_simkeu',$SIM_MAT);
				
				// INSERT BIAYA SEAL SIMKEU
				$SIM_SEAL['ID_REQ'] = $REQ ;
				$SIM_SEAL['CHARGE'] = $SQL2->TARIF;
				$SIM_SEAL['JENIS_TARIF'] = 'SEAL';
				$SIM_SEAL['TOTAL'] = $seal;
				$SIM_SEAL['WK_REKAM'] = date('Y-m-d H:i:s');
				print_r($SIM_SEAL);
				$this->db->insert('req_delivery_simkeu',$SIM_SEAL);

				// INSERT BIAYA ADM SIMKEU

				$SIM_ADM['ID_REQ'] = $REQ ;
				$SIM_ADM['CHARGE'] = $BA;
				$SIM_ADM['JENIS_TARIF'] = 'ADMINISTRASI';
				$SIM_ADM['TOTAL'] = $BA;
				$SIM_ADM['WK_REKAM'] = date('Y-m-d H:i:s');
				print_r($SIM_ADM);
				$this->db->insert('req_delivery_simkeu',$SIM_ADM);

			if($error == 0){
				$action = '/billingBehandle/behandle/post';
				echo "MSG#OK#Data berhasil diproses#".site_url().$action;
				site_url().$action;
			}else{
				echo "MSG#ERR#".$message."#";
			}
		}else if($act == "confirm_behandle"){
			foreach($this->input->post('DATA') as $a => $b){
				if($b=="") unset($DATA[$a]);
				else $DATA[$a] = strtoupper(trim($b));
			}
			// SPLIT ID REQUEST
			$ID 	= explode('~',$DATA['ID']);
			$ID_REQ = $ID[0];
			$NO_DOK = $ID[1];
			// SPLIT BANK ID
			$BANK 		= explode('~',$DATA['BANK']);
			$ID_BANK 	= $BANK[0];
			$NAMA_BANK 	= $BANK[1];

			//if ($ID_BANK != "") {
				$codecustom = $this->db->query("SELECT kode from solver_kode_billing where jenis = 'bhd' order by id desc limit 1")->row();

				$SQL = $this->db->query("SELECT DISTINCT A.ID_REQ, A.TGL_REQ, A.NO_DOK, A.NPWP, A.NAMA_CUST, C.ALAMAT, C.EMAIL, C.TELEPON,
													(20000 + A.SUBTOTAL) AS SUBTOTAL, A.PPN AS PPN, A.TOTAL_JUMLAH AS TOTAL_BAYAR, B.JENIS_TARIF, SUM(B.TOTAL) AS TOTAL_NOMINAL,
													DATE_FORMAT(A.TGL_REQ,'%Y-%m-%d 23:59:59') AS EXPIRED
													FROM req_behandle_hdr A
													INNER JOIN req_delivery_simkeu B ON A.ID_REQ = B.ID_REQ
													INNER JOIN m_pelanggan C ON A.NPWP = C.NPWP
													WHERE A.ID_REQ = '".$ID_REQ."' AND A.NO_DOK = '".$NO_DOK."' AND A.BILLING_ID IS NULL GROUP BY B.JENIS_TARIF
							");
				$RESULT = $SQL->result_array();
				$COUNT_RESULT = count($RESULT);
				if ($COUNT_RESULT > 0) {
					$VAR = array();
					$ARRHEADER = "";
					$ARRDETAIL = "";
					$INDEX = -1;
					$CODE = 1;
					$CHANNEL_ID = $ID_BANK == '11021' ? 'B00201' : 'B00601';
					for ($i = 0; $i < $COUNT_RESULT; $i++) {
						$BILLING_ID = $codecustom->kode.preg_replace('/\D/', '', $RESULT[$i]['ID_REQ']);
						if ($ARRHEADER != $RESULT[$i]['ID_REQ']) {
							$index++;
							$VAR['user'] = 'admin.mti';
							$VAR['password'] = 'b8ad6e10f5d8789c587d2f2b0d173b7e';
							$VAR['billerId'] = '19';
							$VAR['productId'] = 'C03001';
							$VAR['channelId'] = $CHANNEL_ID;
							$VAR['data']['billingId'] = $BILLING_ID;
							$VAR['data']['billingDate'] = $RESULT[$i]['TGL_REQ'];
							$VAR['data']['billingType'] = '1';
							$VAR['data']['customerId'] = preg_replace('/\D/', '', $RESULT[$i]['NPWP']);
							$VAR['data']['customerName'] = substr($RESULT[$i]['NAMA_CUST'],0,30);
							$VAR['data']['customerAddress'] = $RESULT[$i]['ALAMAT'];
							$VAR['data']['customerMail'] = $RESULT[$i]['EMAIL'];
							$VAR['data']['customerPhone'] = $RESULT[$i]['TELEPON'];
							$VAR['data']['billerAccountNo'] = '00000000';
							$VAR['data']['billerName'] = 'PT MTI COMMON AREA';
							$VAR['data']['currency'] = 'IDR';
							$VAR['data']['amount'] = $RESULT[$i]['SUBTOTAL'];
							$VAR['data']['tax'] = $RESULT[$i]['PPN'];
							$VAR['data']['totalAmount'] = $RESULT[$i]['TOTAL_BAYAR'];
							$VAR['data']['expiredDate'] = $RESULT[$i]['EXPIRED'];
							$VAR['data']['interval'] = '50000';
							$VAR['data']['remark'] = 'Pembayaran Behandle MTI';
							$VAR['data']['signature'] = hash("sha256","admin.mti"."19".$BILLING_ID);
							$VAR['data']['documentNo'] = $RESULT[$i]['NO_DOK'];
							$VAR['data']['bankClientId'] = $ID_BANK;
							$VAR['data']['accountNo'] = $NAMA_BANK;
						}
						if ($ARRHEADER == $RESULT[$i]['ID_REQ'] && $ARRDETAIL != $RESULT[$i]['ID_REQ']) {
							$index++;
							$ARRDETAIL['data']['detail']['code'][] = $RESULT[$i]['ID_REQ'];
						}
						$DETAIL['code'] = '00' . (string) $code++;
						$DETAIL['description'] = $RESULT[$i]['JENIS_TARIF'];
						$DETAIL['nominal'] = $RESULT[$i]['TOTAL_NOMINAL'];
						$VAR['data']['detail'][] = $DETAIL;
						$ARRHEADER = $RESULT[$i]['ID_REQ'];
						$ARRDETAIL = $RESULT[$i]['ID_REQ'];
					}
					$ARRVAR = json_encode($VAR);
					$this->insertMailBox('PAYMENTSEND', str_replace("'", "''", json_encode($ARRVAR)));
					$URL = 'https://apipay.edi-indonesia.co.id/api/server/sendBilling';
					$SEND = $this->curl->CallApi('POST', $URL, $ARRVAR);
					$response = json_decode($SEND);
					print_r($response);
					if ($response->status == true) {
						$this->db->where('ID_REQ', $RESULT[0]['ID_REQ']);
						$this->db->update('req_behandle_hdr', array('BANK_ID' => $ID_BANK, 'FL_PAYMENT' => 'Y', 'BILLING_ID' => $response->data->billingId, 'PAYMENT_ID' => $response->data->paymentId, 'VAID' => $response->data->vaid, 'MESSAGE_PAYMENT' => 'SEND', 'WK_PAYMENT' => date('Y-m-d H:i:s')));
						$action = '/billingBehandle/behandle/post';
						echo "MSG#OK#Data berhasil diproses#" . site_url() . $action;
					} else {
						$this->db->where('ID_REQ', $RESULT[0]['ID_REQ']);
						$this->db->update('req_behandle_hdr', array('FL_PAYMENT' => 'E', 'MESSAGE_PAYMENT' => 'FAILED', 'WK_PAYMENT' => date('Y-m-d H:i:s')));
						echo "MSG#ERR#" . $response->errDesc . "#";
					}
				} else {
					echo "MSG#ERR#Data Billing Behandle Not Found#";
				}
			//}			
		}else if($act == "update_behandle1"){
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
		}else if($act == "update_behandle2"){
			foreach($this->input->post('DATA') as $a => $b){
				if($b=="") unset($DATA[$a]);
				else $DATA[$a] = strtoupper(trim($b));
			}
			$id = $DATA['ID'];
			$DATAN['JNS_DOK'] = $DATA['JNS_DOK'];
			$DATAN['NO_DOK'] = $DATA['NO_DOK'];
			$DATAN['JNS_KEGIATAN'] = '2';
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
		}
	}

	public function get_data_behandle_spjm($id){
		$sql = $this->db->query("SELECT DISTINCT A.ID, C.JNS_DOK, A.NO_DAFTAR_PABEAN, A.TGL_DAFTAR_PABEAN, C.NO_CONT, C.UKR_CONT, 
				CASE WHEN C.JNS_KEGIATAN = '1' THEN 'BEHANDLE 1' WHEN C.JNS_KEGIATAN ='2' THEN 'BEHANDLE 2' ELSE '' END AS JNS_KEGIATAN
				FROM t_permit_hdr A
				INNER JOIN t_permit_cont B ON A.ID = B.ID
				INNER JOIN t_gatepass C ON A.NO_DAFTAR_PABEAN = C.NO_DOK AND B.NO_CONT = C.NO_CONT AND C.STATUS ='DONE'
				INNER JOIN t_op_inspection D ON B.NO_CONT = D.NO_CONT AND C.NO_CONT = D.NO_CONT AND D.STATUS = 'DONE'
				WHERE C.FL_BIL IS NULL AND C.JNS_KEGIATAN !='' AND A.ID ='$id'");
		return $sql->result();
	}

	public function get_data_behandle_sppmp($id){
		$sql = $this->db->query("SELECT DISTINCT A.ID_IJIN, C.JNS_DOK, A.NO_RESPON, A.TG_RESPON, C.NO_CONT, C.UKR_CONT, 
				CASE WHEN C.JNS_KEGIATAN = '1' AND H.LNSW_NOAJU IS null THEN 'BEHANDLE 1' WHEN C.JNS_KEGIATAN ='2' AND H.LNSW_NOAJU IS null THEN 'BEHANDLE 2' WHEN H.LNSW_NOAJU IS not NULL then 'BEHANDLE JOIN' ELSE '' END AS JNS_KEGIATAN
				FROM t_ppk_hdr A
				INNER JOIN t_ppk_cont B ON A.ID_IJIN = B.ID_IJIN
				INNER JOIN t_gatepass C ON A.NO_RESPON = C.NO_DOK AND B.NO_CONT = C.NO_CONT AND C.STATUS ='DONE'
				INNER JOIN t_op_inspection D ON B.NO_CONT = D.NO_CONT AND C.NO_CONT = D.NO_CONT AND D.STATUS = 'DONE'
				LEFT JOIN v_ppk_permit_join H ON C.NO_DOK = H.NO_RESPON AND C.NO_CONT = H.NO_CONT
				WHERE A.ID_IJIN = '$id' AND C.JNS_KEGIATAN !='' AND C.FL_BIL IS NULL
				GROUP BY C.NO_CONT, C.JNS_KEGIATAN");
		return $sql->result();
	}

	public function get_nota_behandle($id){
		$func = get_instance();
        $func->load->model("m_main", "main", true);
		$func->main->log_prints($id);
		$arrid = explode("~",$id);
		$SQL = "SELECT ID_REQ,'PAKET BEHANDLE' AS 'TITLE', UK_CONT AS 'SIZE', COUNT(NO_CONT) AS 'BOX',NO_CONT ,
		CASE WHEN JNS_KEGIATAN = 1 THEN 'PAKET 1' when JNS_KEGIATAN = 2 then 'PAKET 2' when JNS_KEGIATAN = 'JOIN' then 'PAKET JOIN'  ELSE 'PAKET' END AS PAKET, TOTAL AS 'TARIF', SUM(TOTAL) AS TOTAL
		FROM req_behandle_dtl WHERE ID_REQ = '$arrid[0]' GROUP BY UK_CONT, PAKET";
		$result = $func->main->get_result($SQL);
		if($result){
			foreach($SQL->result_array() as $row => $value){
				$arrdata[] = $value;
			}
			return $arrdata;
		}else {
			echo "not found ";
		}
	}

	public function get_nota_behandle_hdr($id){
		$func = get_instance();
        $func->load->model("m_main", "main", true);
		$func->main->log_prints($id);
		$arrid = explode("~",$id);
		$SQL = "SELECT * FROM req_behandle_hdr WHERE ID_REQ = '$arrid[0]'";
		$result = $func->main->get_result($SQL);
		if($result){
			foreach($SQL->result_array() as $row => $value){
				$arrdata[] = $value;
			}
			return $arrdata;
		}else {
			echo "not found ";
		}
	}
	
	public function get_nota_cust($id){
		$func = get_instance();
        $func->load->model("m_main", "main", true);
		$func->main->log_prints($id);
		$arrid = explode("~",$id);
		$SQL = "SELECT A.*, B.*
				FROM m_pelanggan A, req_behandle_hdr B
				WHERE REPLACE(
				REPLACE(A.NPWP,'.',''),'-','') =
				REPLACE(
				REPLACE(B.NPWP,'.',''),'-','') AND B.ID_REQ = '$arrid[0]'";
		$result = $func->main->get_result($SQL);
		/* print_r($SQL);die(); */
		if($result){
			foreach($SQL->result_array() as $row => $value){
				$arrdata[] = $value;
			}
			return $arrdata;
		}else {
			echo "not found ";
		}
	}

	public function get_nota_beh($id){
		$func = get_instance();
        $func->load->model("m_main", "main", true);
		$func->main->log_prints($id);
		$arrid = explode("~",$id);
		$SQL = "SELECT CASE WHEN COUNT(DISTINCT NO_CONT) > 10 THEN GROUP_CONCAT(DISTINCT NO_CONT,'-',UK_CONT) ELSE GROUP_CONCAT(DISTINCT NO_CONT,'-',UK_CONT) END AS 'NO_KONTAINER' FROM req_behandle_dtl WHERE ID_REQ = '$arrid[0]'";
		$result = $func->main->get_result($SQL);
		//print_r($SQL);die();
		if($result){
			foreach($SQL->result_array() as $row => $value){
				$arrdata[] = $value;
			}
			return $arrdata;
		}else {
			echo "not found ";
		}
	}

	public function get_nota_materai() {
		$func = get_instance();
        $func->load->model("m_main", "main", true);

		$SQL = $this->db->query("SELECT * FROM bea_materai_online where SISA_DEPOSIT >= 10000");
		
		return $SQL->result_array();
	}

	public function get_data_bank(){
		$SQL =  $this->db->query("SELECT BANK_ID, NAMA_BANK, REKENING FROM m_bank WHERE FL_ACTIVE='Y'");
		return $SQL->result_array();
	}

	public function history_cetak($id){
		$func = get_instance();
        $func->load->model("m_main", "main", true);
		$func->main->log_prints($id);
		$arrid = explode("~",$id);
		$kodeuser = $this->session->userdata("ID");

		$DATA['ID_HANDLE'] = $id;
		$DATA['TYPE_RPT'] = "nota_behandle";
		$DATA['USER_PRINTS'] = $kodeuser;
		$DATA['DATE_PRINTS'] = date('Y-m-d H:i:s');

		$this->db->insert('hist_print', $DATA);	
	}

	public function get_history_behandle($id){
		$SQL = "SELECT COUNT(ID_HANDLE) AS JML, B.NAMA, A.ID_HANDLE, A.USER_PRINTS, A.TYPE_RPT
				FROM hist_print A
				LEFT JOIN reff_user B ON A.USER_PRINTS = B.ID
				where A.ID_HANDLE = '".$id."' AND TYPE_RPT = 'nota_behandle'
				GROUP BY USER_PRINTS
				";
        $result = $this->db->query($SQL); 
        return $result->result_array();
	}

	public function get_cek_behandle($id){
		$arrid = explode("~",$id);
		$sql = $this->db->query("SELECT JNS_KEGIATAN FROM req_behandle_hdr WHERE ID_REQ = '$arrid[0]'");
		return $sql->row();
	}

	public function get_data_behandle1($id){
		$arrid = explode("~",$id);
			$sql = $this->db->query("SELECT A.NO_SPK ,A.TGL_SPK , CASE WHEN A.JNS_DOK = 19 THEN 'SPJM' ELSE 'SPPMP' END AS JNS_DOK,
									CASE WHEN B.JNS_KEGIATAN = 1 THEN 'BEHANDLE 1' ELSE 'BEHANDLE 2' END AS JNS_KEGIATAN,
									A.NO_DOK, B.NM_KAPAL, B.NO_VOY, B.NAMA_CUST, B.NPWP, B.NO_DO, B.NO_BL 
									FROM t_spk A INNER JOIN req_behandle_hdr B ON A.NO_DOK = B.NO_DOK WHERE B.ID_REQ = '$arrid[0]'");
			return $sql->result_array();
	}

	public function get_data_behandle2($id){
		$arrid = explode("~",$id);
		$sql = $this->db->query("SELECT DISTINCT A.JNS_DOK, A.NO_DOK, A.TGL_DOK, CASE WHEN B.JNS_KEGIATAN = 1 THEN 'BEHANDLE 1' ELSE 'BEHANDLE 2' END AS JNS_KEGIATAN,B.NAMA_CUST, B.NPWP, B.NO_DO, B.NO_BL FROM t_gatepass A INNER JOIN req_behandle_hdr B ON A.NO_DOK = B.NO_DOK WHERE B.ID_REQ = '$arrid[0]'");
		return $sql->result_array();
	}

	public function del_behandle($id){
		$exparr = explode('~',$id);

		$id_req = $exparr[0];
		$no_dok = $exparr[1];
		$no_nota = $exparr[2];
		if($no_nota != ''){
			$message .= "DATA TIDAK BISA DIHAPUS";
			$error = 1;
		}else{
			$query_cont		= $this->db->get_where('req_behandle_dtl', array('ID_REQ' => $id_req));
			$data_cont		= $query_cont->row_array();
			$dataid_cont	= $data_cont['NO_CONT'];

			$this->db->where(array('NO_DOK' => $no_dok));
			$this->db->update('t_gatepass',array('FL_BIL' => null));	

			$result = $this->db->delete('req_behandle_dtl', array('ID_REQ' => $id_req));
			$this->db->delete('req_behandle_hdr', array('ID_REQ' => $id_req));
			$this->db->delete('req_delivery_simkeu', array('ID_REQ' => $id_req));
			//----------------
			$qw = $this->db->query("SELECT a.ID_REQ,a.NO_DOK,a.BANK_ID,a.PAYMENT_ID,a.VAID,a.BILLING_ID
			FROM req_behandle_hdr a
			WHERE a.ID_REQ = '$id_req' AND a.NO_DOK = '$no_dok' AND a.VAID IS NOT NULL");
			if ($qw->num_rows() > 0) {
				$row = $qw->row();
				$VAR['user'] = 'admin.mti';
				$VAR['password'] = 'b8ad6e10f5d8789c587d2f2b0d173b7e';
				$VAR['billerId'] = '19';
				$VAR['channelId'] = $row->BANK_ID;
				$VAR['data']['billingId'] = $row->BILLING_ID;
				$VAR['data']['paymentId'] = $row->PAYMENT_ID;
				$VAR['data']['signature'] = hash("sha256","admin.mti"."19".$BILLING_ID);
				$ARRVAR = json_encode($VAR);
				$URL = 'https://apipay.edi-indonesia.co.id/api/server/cancelBilling';
				$SEND = $this->curl->CallApi('POST', $URL, $ARRVAR);
				$response = json_decode($SEND);
				if ($response->status == true) {
					$this->db->query("INSERT INTO log_hapus_req_pembayaran (id_req,raw1,raw2,raw3) VALUES ('$id_req', '$ARRVAR', '$response', '1')");
				}
			}
			//----------------
			if (!$result) {
	            $error += 1;
	            $message .= "Data gagal diproses";
	        }
		}

        if ($error==0) {
            echo "MSG#OK#Data berhasil diproses#".site_url()."/billingBehandle/behandle/post";
        } else {
            echo "MSG#ERR#".$message."#";
        }
	}
	
	public function resend_behandle($IdReq, $FlTrans, $FlReceipt){
		
		if (($FlTrans == 'F')&&($FlReceipt == 'F')) {
			$this->db->where(array('ID_REQ' =>$IdReq));
			$this->db->update('req_behandle_hdr',array('FL_SEND_TRANS_SIMKEU' => 'N','MESSAGE_SEND_TRANS_SIMKEU' => '','FL_SEND_RECEIPT_SIMKEU' => 'N','MESSAGE_SEND_RECEIPT_SIMKEU' => ''));
		}else if (($FlTrans == 'S')&&($FlReceipt == 'F')) {
			$this->db->where(array('ID_REQ' =>$IdReq));
			$this->db->update('req_behandle_hdr',array('FL_SEND_RECEIPT_SIMKEU' => 'N','MESSAGE_SEND_RECEIPT_SIMKEU' => ''));
		}else if (($FlTrans == 'F')&&($FlReceipt == 'Y')) {
			$this->db->where(array('ID_REQ' =>$IdReq));
			$this->db->update('req_behandle_hdr',array('FL_SEND_TRANS_SIMKEU' => 'N','MESSAGE_SEND_TRANS_SIMKEU' => '','FL_SEND_RECEIPT_SIMKEU' => 'N','MESSAGE_SEND_RECEIPT_SIMKEU' => ''));
		}else if (($FlTrans == 'S')&&($FlReceipt == 'S')) {
			$message .= "DATA TIDAK BISA DIKIRIM ULANG";
			$error = 1;
		}

		if ($error==0) {
            echo "MSG#OK#Data berhasil diproses#".site_url()."/billingDelivery/delivery/post";
        } else {
            echo "MSG#ERR#".$message."#";
        }
	}

	private function insertMailBox($KodeAPRF, $StrData) {
	    $KodeAPRF = $KodeAPRF == '' ? 'NULL' : $KodeAPRF;
	    $StrData = $StrData == '' ? 'NULL' : $StrData;
	    $SQL = array('KD_APRF' => $KodeAPRF, 'STR_DATA' => $StrData, 'TGL_STATUS' => date('Y-m-d H:i:s')); 
	    $this->db->insert('mailbox',$SQL);
	}
}

/* End of file M_billing_behandle.php */
/* Location: ./application/models/M_billing_behandle.php */