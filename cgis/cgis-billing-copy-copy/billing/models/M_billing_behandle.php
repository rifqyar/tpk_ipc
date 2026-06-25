<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_billing_behandle extends CI_Model {

	public $variable;

	public function __construct()
	{
		parent::__construct();
		
	}

	public function behandle($act, $id){
		$page_title = 'BILLING BEHANDLE';
		$title = "BILLING BEHANDLE";
		$this->newtable->breadcrumb('Billing', 'javascript:void(0)','');
		$this->newtable->breadcrumb('Behandle', 'javascript:void(0)','');
		$check = (grant()=="W")?true:false;

		$SQL = "SELECT A.ID_REQ AS 'NO REQUEST',CONCAT(A.ID_REQ,'<BR>',A.TGL_REQ) AS 'REQUEST',CONCAT(A.NAMA_CUST,'<BR>',A.NPWP) AS 'CUSTOMER',A.TGL_REQ AS 'TGL REQUEST', 
				CONCAT(A.NO_DOK,'<BR>',A.TGL_DOK) AS 'DOKUMEN',A.NO_DOK AS 'NO DOKUMEN',B.NM_KAPAL AS 'NAMA KAPAL', IFNULL(A.NO_NOTA_BEHANDLE, NULL) AS 'NO. NOTA BEHANDLE',
				CASE WHEN A.NO_NOTA_BEHANDLE > 0 && A.TGL_NOTA > 0 THEN CONCAT(IFNULL(A.NO_NOTA_BEHANDLE, NULL),'<BR>',DATE_FORMAT(A.TGL_NOTA, '%d-%m-%Y'),' ',E.NAMA_BANK) ELSE '' END AS 'NOTA',
				CONCAT('<span class=\"label label-danger\">Rp. ', FORMAT(A.TOTAL_JUMLAH,0),'</span>') AS 'TOTAL',
				CONCAT(CASE WHEN FL_SEND_TRANS_SIMKEU = 'S' THEN '<span style=\"color:green;font-weight:bold\">SUCCESS</span>' 
				WHEN  FL_SEND_TRANS_SIMKEU = 'N' THEN '<span style=\"color:#660066;font-weight:bold\">DRAFT</span>' 
				WHEN FL_SEND_TRANS_SIMKEU = 'F' THEN '<span style=\"color:red;font-weight:bold\">FAILD</span>' 
				ELSE '<span style=\"color:green;font-weight:bold\">SEND</span>' END,'<BR>',CASE WHEN A.MESSAGE_SEND_TRANS_SIMKEU IS NULL THEN '' ELSE A.MESSAGE_SEND_TRANS_SIMKEU END) AS 'TRANSAKSI', 
				A.FL_SEND_TRANS_SIMKEU AS 'TRANSAKSI2', A.FL_SEND_RECEIPT_SIMKEU AS 'RECEIPT2',
				CONCAT(CASE WHEN FL_SEND_RECEIPT_SIMKEU = 'S' THEN '<span style=\"color:green;font-weight:bold\">SUCCESS</span>' 
				WHEN  FL_SEND_RECEIPT_SIMKEU = 'N' THEN '<span style=\"color:#660066;font-weight:bold\">DRAFT</span>' 
				WHEN FL_SEND_RECEIPT_SIMKEU = 'F' THEN '<span style=\"color:red;font-weight:bold\">FAILD</span>'  
				ELSE '<span style=\"color:green;font-weight:bold\">SEND</span>' END,'<BR>',CASE WHEN A.MESSAGE_SEND_RECEIPT_SIMKEU IS NULL THEN '' ELSE A.MESSAGE_SEND_RECEIPT_SIMKEU END) AS 'RECEIPT', A.BANK_ID AS 'BANK_ID'
				FROM req_behandle_hdr A
				INNER JOIN t_gatepass B ON B.NO_DOK = A.NO_DOK AND B.JNS_KEGIATAN IS NOT NULL
				LEFT JOIN m_bank E ON A.BANK_ID = E.BANK_ID";

		$proses = array('ENTRY'  => array('MODAL',"billingBehandle/behandle_add", '','','md-plus-circle','', 'menu'),
		'CETAK'  => array('PRINT',"billingBehandle/cetak_nota_behandle", '0','','md-print','','list'),
		'CONFIRM' => array('MODAL',"billingBehandle/behandle_confirm", '1','','md-confirmation-number','', 'list'),
		'HISTORY' => array('MODAL',"billingBehandle/behandle_history", '1', '', 'md-watch','','list'),
		'DELETE'  => array('DELETE',"billingBehandle/behandle_del", '1','','md-close-circle','', 'menu'),
		'UPDATE' => array('MODAL',"billingBehandle/behandle_update", '1','NOT-NULL','md-edit','','list'),
		'RESEND'  => array('POST',"billingBehandle/behandle_resend", 'all','','md-mail-send','', 'menu'));
		$this->newtable->multiple_search(true);
		$this->newtable->show_chk(true);
		$this->newtable->show_menu($check);
		$this->newtable->show_search(true);
		$arr_dok = array(""=>"","N"=>"DRAFT","Y"=>"SEND","S"=>"SUCCESS","F"=>"FAILD");
		$arr_bank = array(""=>"","232006"=>"MANDIRI","265006"=>"BCA");
		$this->newtable->search(array(array('ID_REQ','ID REQUEST'),array('A.NO_NOTA_BEHANDLE','NO. NOTA'),array('A.NO_DOK','NO. DOKUMEN'),array('A.NAMA_CUST','CUSTOMER'),array('FL_SEND_TRANS_SIMKEU','STATUS PENGIRIMAN TRANSAKSI','OPTION',$arr_dok),array('FL_SEND_RECEIPT_SIMKEU','STATUS PENGIRIMAN RECEIPT','OPTION',$arr_dok),array('E.BANK_ID','NAMA BANK','OPTION',$arr_bank)));
		$this->newtable->action(site_url() . "/billingBehandle/behandle");
		$this->newtable->tipe_proses('button');
		$this->newtable->keys(array("NO REQUEST","NO DOKUMEN","NO. NOTA BEHANDLE","TRANSAKSI2","RECEIPT2"));
		$this->newtable->hiddens(array("NO REQUEST","TGL REQUEST","NAMA KAPAL","NO. NOTA BEHANDLE","NO DOKUMEN","TRANSAKSI2","RECEIPT2","BANK_ID"));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby(1);
		$this->newtable->groupby(array("A.ID_REQ"));
		$this->newtable->sortby("DESC");
		$this->newtable->validasi(array("NO. NOTA BEHANDLE"));
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
		$SQL = "SELECT DISTINCT A.ID AS 'ID', C.JNS_DOK AS 'JENIS DOKUMEN', A.NO_DAFTAR_PABEAN AS 'NO DOKUMEN', A.TGL_DAFTAR_PABEAN AS 'TGL DOKUMEN', A.NM_ANGKUT AS 'NAMA KAPAL', A.NO_VOY_FLIGHT AS 'NO VOYAGE'
			FROM t_permit_hdr A
			INNER JOIN t_permit_cont B ON A.ID = B.ID
			INNER JOIN t_gatepass C ON A.NO_DAFTAR_PABEAN = C.NO_DOK AND B.NO_CONT = C.NO_CONT AND C.JNS_KEGIATAN IN ('1','2')
			INNER JOIN t_op_inspection D ON B.NO_CONT = D.NO_CONT AND C.NO_CONT = D.NO_CONT AND D.STATUS = 'DONE'
			WHERE C.FL_BIL IS NULL AND A.KD_DOK_INOUT !='1'";
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
		$SQL = "SELECT DISTINCT A.ID_IJIN AS 'ID', C.JNS_DOK AS 'JENIS DOKUMEN', A.NO_RESPON AS 'NO DOKUMEN', A.TG_RESPON AS 'TGL DOKUMEN', A.ANGKUTNAMA AS 'NAMA KAPAL', A.ANGKUTNO AS 'NO VOYAGE'
				FROM t_ppk_hdr A
				INNER JOIN t_ppk_cont B ON A.ID_IJIN = B.ID_IJIN
				INNER JOIN t_gatepass C ON A.NO_RESPON = C.NO_DOK AND B.NO_CONT = C.NO_CONT
				INNER JOIN t_op_inspection D ON B.NO_CONT = D.NO_CONT AND C.NO_CONT = D.NO_CONT AND D.STATUS = 'DONE'
				WHERE C.FL_BIL IS NULL";

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
			$ID_BIL = preg_replace('/\D/', '', "61".date('Y-m-d').$norut);
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
			$DATA_BHD['NO_NOTA_BEHANDLE'] = "";
			$DATA_BHD['TGL_NOTA'] = "";
			$DATA_BHD['BANK_ID'] = "";
			$this->db->where(array('NO_DOK' =>$DATA['NO_DOK']));
			$this->db->update('t_gatepass', array('FL_BIL' => 'DONE'));
			$this->db->insert('req_behandle_hdr', $DATA_BHD);

			foreach($this->input->post('DT[]') as $a => $b){
				foreach($b as $value){
					if($value=="") unset($DT[$a]);
					else $DT[$a][] = strtoupper(trim($value));
				}
			}
	
			$jumlah_dipilih = count($DT['NO_CONT']);
			$sub_total = 0;

			for($x=0; $x<$jumlah_dipilih; $x++){
				$DETAIL = array();
				$SIZE = array();
				$SIZE = $DT['UKR_CONT'][$x];
				$KET = $DT['JNS_KEGIATAN'][$x];

				if ($KET == 'BEHANDLE 1') {
					$KEGIATAN = 1;
				}else{
					$KEGIATAN = 2;
				}

				$SQL = $this->db->query("SELECT * FROM m_tarif WHERE SIZE = '$SIZE' AND JENIS_BIAYA = 'PAKET BEHANDLE' AND KET LIKE '$KEGIATAN'")->row();
				$sub_total = $sub_total + $SQL->TARIF;

				$DETAIL['ID_REQ'] = $REQ;
				$DETAIL['ID_BILLING'] = $ID_BIL;
				$DETAIL['NO_CONT'] = $DT['NO_CONT'][$x];
				$DETAIL['UK_CONT'] = $DT['UKR_CONT'][$x];
				$DETAIL['JNS_KEGIATAN'] = $KEGIATAN;
				$DETAIL['TOTAL'] = $SQL->TARIF;
				$this->db->insert('req_behandle_dtl',$DETAIL);

				// INSERT SIMKEU
				if ($DETAIL['TOTAL'] > 0) {
					$SIM['ID_REQ'] = $REQ ;
					$SIM['ID_BILLING'] = $ID_BIL ;
					$SIM['NO_CONT'] = $DT['NO_CONT'][$x];
					$SIM['UKR_CONT'] = $DT['UKR_CONT'][$x];
					$SIM['CHARGE'] = $SQL->TARIF;
					$SIM['JENIS_TARIF'] = 'BEHANDLE '.$KEGIATAN;
					$SIM['TOTAL'] = $SQL->TARIF;
					$SIM['WK_REKAM'] = date('Y-m-d H:i:s');
					print_r($SIM);
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
				$this->db->where(array('ID_REQ' => $REQ));
				$this->db->update('req_behandle_hdr', $DATA_HDR_BH);

				// INSERT SIMKEU
				$SIM_MAT['ID_REQ'] = $REQ ;
				$SIM_MAT['ID_BILLING'] = $ID_BIL ;
				$SIM_MAT['CHARGE'] = $MAT;
				$SIM_MAT['JENIS_TARIF'] = 'MATERAI BHD';
				$SIM_MAT['TOTAL'] = $MAT;
				$SIM_MAT['WK_REKAM'] = date('Y-m-d H:i:s');
				print_r($SIM_MAT);
				$this->db->insert('req_delivery_simkeu',$SIM_MAT);

				$SIM_ADM['ID_REQ'] = $REQ ;
				$SIM_ADM['ID_BILLING'] = $ID_BIL ;
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
			$ID_NOTA = explode('~',$DATA['ID']);
			$id = $ID_NOTA[0];
			$sql = $this->db->query("SELECT NO_NOTA_BEHANDLE FROM req_behandle_hdr WHERE ID_REQ = '$id'");

			foreach ($sql->result_array() as $value) {
				$cek_nota = $value['NO_NOTA_BEHANDLE'];
			}
			if ($cek_nota == NULL) {
				$query = "SELECT LPAD(SEQUENCE+1,'6','0') SEQ, (SEQUENCE+1) SEQUE FROM m_generate_nota WHERE TYPE_NOTA = 'BEHANDLE'";
				$rs = $this->db->query($query);
				$data = $rs->row_array();
				$seq = $data["SEQ"];
				$seque = $data["SEQUE"];
				$no_nota_behandle = '010.801.18-65.'.$seq;

				$this->db->where('TYPE_NOTA','BEHANDLE');
				$this->db->update('m_generate_nota',array('SEQUENCE' => $seque));

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
				CASE WHEN C.JNS_KEGIATAN = '1' THEN 'BEHANDLE 1' WHEN C.JNS_KEGIATAN ='2' THEN 'BEHANDLE 2' ELSE '' END AS JNS_KEGIATAN
				FROM t_ppk_hdr A
				INNER JOIN t_ppk_cont B ON A.ID_IJIN = B.ID_IJIN
				INNER JOIN t_gatepass C ON A.NO_RESPON = C.NO_DOK AND B.NO_CONT = C.NO_CONT AND C.STATUS ='DONE'
				INNER JOIN t_op_inspection D ON B.NO_CONT = D.NO_CONT AND C.NO_CONT = D.NO_CONT AND D.STATUS = 'DONE'
				WHERE A.ID_IJIN = '$id' AND C.JNS_KEGIATAN !='' AND C.FL_BIL IS NULL
				GROUP BY C.NO_CONT");
		return $sql->result();
	}

	public function get_nota_behandle($id){
		$func = get_instance();
        $func->load->model("m_main", "main", true);
		$func->main->log_prints($id);
		$arrid = explode("~",$id);
		$SQL = "SELECT ID_REQ,'PAKET BEHANDLE' AS 'TITLE', UK_CONT AS 'SIZE', COUNT(NO_CONT) AS 'BOX',NO_CONT ,
				CASE WHEN JNS_KEGIATAN = 1 THEN 'PAKET 1' ELSE 'PAKET 2' END AS PAKET, TOTAL AS 'TARIF', SUM(TOTAL) AS TOTAL
				FROM req_behandle_dtl WHERE ID_REQ = '$arrid[0]' GROUP BY UK_CONT, PAKET";
		$result = $func->main->get_result($SQL);
		if($result){
			foreach($SQL->result_array() as $row => $value){
				$arrdata[] = $value;
			}
			return $arrdata;
		}else {
			redirect(site_url(), 'refresh');
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
			redirect(site_url(), 'refresh');
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
			redirect(site_url(), 'refresh');
		}
	}

	public function get_nota_beh($id){
		$func = get_instance();
        $func->load->model("m_main", "main", true);
		$func->main->log_prints($id);
		$arrid = explode("~",$id);
		$SQL = "SELECT CASE WHEN COUNT(DISTINCT NO_CONT) > 10 THEN GROUP_CONCAT(DISTINCT NO_CONT,'-',UK_CONT,'<br>') ELSE GROUP_CONCAT(DISTINCT NO_CONT,'-',UK_CONT) END AS 'NO_KONTAINER' FROM req_behandle_dtl WHERE ID_REQ = '$arrid[0]'";
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

	public function get_data_bank(){
		$SQL =  $this->db->query("SELECT BANK_ID, NAMA_BANK, REKENING FROM m_bank WHERE FL_ACTIVE='N'");
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

			$this->db->get_where('t_gatepass', array('NO_DOK' => $no_dok, 'NO_CONT' => $dataid_cont));
			$this->db->update('t_gatepass',array('FL_BIL' => NULL));
			
			$result = $this->db->delete('req_behandle_dtl', array('ID_REQ' => $id_req));
			$this->db->delete('req_behandle_hdr', array('ID_REQ' => $id_req));
			$this->db->delete('req_delivery_simkeu', array('ID_REQ' => $id_req));
			
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
}

/* End of file M_billing_behandle.php */
/* Location: ./application/models/M_billing_behandle.php */