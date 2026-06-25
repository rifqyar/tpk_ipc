<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_billing_delivery_ext extends CI_Model {

	public $variable;

	public function __construct()
	{
		parent::__construct();
		
	}

	public function delivery_ext($act, $id){
		$page_title = 'Delivery';
		$title ='BILLING DELIVERY EXT';
		$this->newtable->breadcrumb('Billing', 'javascript:void(0)','');
		$this->newtable->breadcrumb('Delivery Extend', 'javascript:void(0)','');
		$check =(grant()=="W")?true:false;

		$SQL = "SELECT CONCAT(A.ID_REQ,'<BR>',A.TGL_REQ) AS 'REQUEST', CONCAT(B.NAMA_CUST,'<BR>',A.NPWP) AS 'CUSTOMER',A.ID_REQ_OLD, CONCAT(A.NO_DOK,'<BR>',DATE_FORMAT(A.TGL_DOK, '%Y-%m-%d')) AS 'DOKUMEN',A.ID_REQ AS 'NO REQUEST', A.NO_DOK AS 'NO DOKUMEN', A.NO_NOTA_DELIVERY AS 'NO. NOTA DELIVERY', 
			CASE WHEN A.NO_NOTA_DELIVERY > 0 && A.TGL_NOTA > 0 THEN CONCAT(IFNULL(A.NO_NOTA_DELIVERY, NULL),'<BR>',DATE_FORMAT(A.TGL_NOTA, '%d-%m-%Y'),' ',E.NAMA_BANK) ELSE '' END AS 'NOTA', CONCAT('<span class=\"label label-danger\">Rp. ', FORMAT(A.TOTAL,0),'</span>') AS 'TOTAL',
			CONCAT(CASE WHEN FL_SEND_TRANS_SIMKEU = 'S' THEN '<span style=\"color:green;font-weight:bold\">SUCCESS</span>' 
			WHEN  FL_SEND_TRANS_SIMKEU = 'N' THEN '<span style=\"color:#660066;font-weight:bold\">DRAFT</span>' 
			WHEN FL_SEND_TRANS_SIMKEU = 'F' THEN '<span style=\"color:red;font-weight:bold\">FAILD</span>' 
			ELSE '<span style=\"color:green;font-weight:bold\">SEND</span>' END,'<BR>',CASE WHEN A.MESSAGE_SEND_TRANS_SIMKEU IS NULL THEN '' ELSE A.MESSAGE_SEND_TRANS_SIMKEU END) AS 'TRANSAKSI', 
			A.FL_SEND_TRANS_SIMKEU AS 'TRANSAKSI2', A.FL_SEND_RECEIPT_SIMKEU AS 'RECEIPT2',
			CONCAT(CASE WHEN FL_SEND_RECEIPT_SIMKEU = 'S' THEN '<span style=\"color:green;font-weight:bold\">SUCCESS</span>' 
			WHEN  FL_SEND_RECEIPT_SIMKEU = 'N' THEN '<span style=\"color:#660066;font-weight:bold\">DRAFT</span>' 
			WHEN FL_SEND_RECEIPT_SIMKEU = 'F' THEN '<span style=\"color:red;font-weight:bold\">FAILD</span>'  
			ELSE '<span style=\"color:green;font-weight:bold\">SEND</span>' END,'<BR>', CASE WHEN A.MESSAGE_SEND_RECEIPT_SIMKEU IS NULL THEN '' ELSE A.MESSAGE_SEND_RECEIPT_SIMKEU END) AS 'RECEIPT', A.BANK_ID AS 'BANK_ID'
			FROM req_delivery_hdr A
			JOIN m_pelanggan B ON A.NPWP = B.NPWP
			LEFT JOIN m_bank E ON A.BANK_ID = E.BANK_ID
			WHERE A.ID_REQ_OLD IS NOT NULL";

		$proses = array('ENTRY'  => array('MODAL',"billingDeliveryExt/delivery_ext_add", '0','','md-plus-circle','', 'menu'),
						'CETAK' => array('PRINT',"billingDeliveryExt/cetak_nota_ext", '1','','md-print','', 'list'),
						'CONFIRM' => array('MODAL',"billingDeliveryExt/delivery_ext_confirm", '1','','md-confirmation-number','', 'list'),
						'HISTORY' => array('MODAL',"billingDeliveryExt/delivery_ext_history", '1', '', 'md-watch','','list'),
						'UPDATE' => array('MODAL',"billingDeliveryExt/delivery_ext_update", '1','NOT-NULL','md-edit','','list'),
						'DELETE'  => array('DELETE',"billingDeliveryExt/delivery_ext_del", '1','','md-close-circle','', 'menu'),
						'RESEND'  => array('POST',"billingDeliveryExt/delivery_ext_resend", 'all','','md-mail-send','', 'menu'));

		$this->newtable->multiple_search(true);
		$this->newtable->show_chk(true);
		$this->newtable->show_menu($check);
		$this->newtable->show_search(true);
		$arr_dok = array(""=>"","N"=>"DRAFT","Y"=>"SEND","S"=>"SUCCESS","F"=>"FAILD");
		$arr_bank = array(""=>"","232006"=>"MANDIRI","265006"=>"BCA");
		$this->newtable->search(array(array('A.ID_REQ','ID REQUEST'),array('A.NO_NOTA_DELIVERY','NO. NOTA'),array('A.NO_DOK','NO. DOKUMEN'),array('B.NAMA_CUST','CUSTOMER'),array('FL_SEND_TRANS_SIMKEU','STATUS PENGIRIMAN TRANSAKSI','OPTION',$arr_dok),array('FL_SEND_RECEIPT_SIMKEU','STATUS PENGIRIMAN RECEIPT','OPTION',$arr_dok),array('E.BANK_ID','NAMA BANK','OPTION',$arr_bank)));
		$this->newtable->action(site_url() . "/billingDeliveryExt/delivery_ext");
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("ID_REQ_OLD","NO REQUEST","NO DOKUMEN","NO. NOTA DELIVERY","TRANSAKSI2","RECEIPT2","BANK_ID"));
		$this->newtable->keys(array("NO REQUEST","NO DOKUMEN","NO. NOTA DELIVERY","TRANSAKSI2","RECEIPT2"));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby(1);
		$this->newtable->sortby("DESC");
		$this->newtable->groupby(array("A.ID_REQ"));
		$this->newtable->set_formid("tbldeliveryext");
		$this->newtable->set_divid("divtbldeliveryext");
		$this->newtable->rowcount(10);
		$this->newtable->clear();
		$this->newtable->menu($proses);
		$tabel .= $this->newtable->generate($SQL);
		$arrdata = array("page_title" => $page_title, "title" => $title, "content" => $tabel);
		if($this->input->post("ajax")||$act == "post")
			echo $tabel;
		else
			return $arrdata;
	}

	public function delivery_ext_add($act, $id){
		$title ='DOKUMEN DELIVERY';
		$this->newtable->breadcrumb('Billing', 'javascript:void(0)','');
		$this->newtable->breadcrumb('Delivery', 'javascript:void(0)','');
		$check =(grant()=="W")?true:false;
		$SQL = "SELECT DISTINCT A.ID_REQ AS 'ID',A.JNS_DOK AS 'JENIS DOKUMEN',CONCAT(A.ID_REQ,'<br>',A.TGL_REQ) AS 'ID REQUEST',B.NAMA_CUST AS 'NAMA CUSTOMER',CONCAT(B.NAMA_CUST,'<BR>',A.NPWP) AS 'IMPORTIR', A.NM_KAPAL AS 'NAMA KAPAL', A.NO_DOK AS 'NO DOK', A.TGL_DOK AS 'TGL DOK', A.NO_NOTA_DELIVERY FROM req_delivery_hdr A 
				LEFT JOIN m_pelanggan B ON A.NPWP = B.NPWP
				WHERE A.NO_NOTA_DELIVERY > 0 AND A.FL_ID_REQ_OLD ='N'";

		$this->newtable->multiple_search(true);
		$this->newtable->show_chk(false);
		$this->newtable->show_menu($check);
		$this->newtable->show_search(true);
		$this->newtable->search(array(array('A.ID_REQ','ID REQUEST'),array('A.NO_DOK','NO. DOKUMEN'),array('B.NAMA_CUST','IMPORTIR')));
		$this->newtable->action(site_url() . "/billingDeliveryExt/delivery_ext_add");
		if($check) $this->newtable->detail(array('POPUP',"billingDeliveryExt/save_delivery"));
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("ID","NAMA CUSTOMER","NAMA KAPAL"));
		$this->newtable->keys(array("ID"));
		$this->newtable->cidb($this->db);
		$this->newtable->groupby(array("A.ID_REQ"));
		$this->newtable->orderby(1);
		$this->newtable->sortby("ASC");
		$this->newtable->rowcount(10);
		$this->newtable->clear();
		$this->newtable->menu($proses);
		$tabel .= $this->newtable->generate($SQL);
		$arrdata = array("title" => $title, "content" => $tabel);
		if($this->input->post("ajax")||$act == "post")
			echo $tabel;
		else
			return $arrdata;
	}

	public function process($act,$id){
        $error = 0;
		if ($act=="save") {
			foreach($this->input->post('DATA') as $a => $b){
				if($b=="") unset($DATA[$a]);
				else $DATA[$a] = strtoupper(trim($b));
			}

			$SEQ 	= $this->db->query("SELECT MAX(id) AS 'urut' FROM req_delivery_hdr")->row()->urut;
			$NO_URT = $SEQ + 1;
			$REQ = "EXT/".date('Y-m-d')."/".$NO_URT;
			$DATA_HDR['ID_REQ'] 			= $REQ;
			$DATA_HDR['TGL_REQ'] 			= date('Y-m-d H:i:s');
			$DATA_HDR['JNS_DOK'] 			= "SPPB PIB 2.0";
			$DATA_HDR['NO_DOK']				= $DATA['NO_DOK'];
			$DATA_HDR['TGL_DOK'] 			= $DATA['TGL_DOK'];
			$DATA_HDR['NO_DO'] 				= $DATA['NO_DO'];
			$DATA_HDR['NO_BL'] 				= $DATA['NO_BL'];
			$DATA_HDR['NO_VOY'] 			= $DATA['VOYAGE'];
			$DATA_HDR['NM_KAPAL'] 			= $DATA['NM_KAPAL'];
			$DATA_HDR['NPWP'] 				= $DATA['NPWP'];
			$DATA_HDR['ID_REQ_OLD'] 		= $DATA['NOTA_OLD'];
			$DATA_HDR['NO_REQUEST'] 		= '010.000-16.61000007';
			$DATA_HDR['OPERATOR'] 			= $this->session->userdata('USERLOGIN');
			$DATA_HDR['EXPIRED'] 			= date('Y-m-d', strtotime($DATA['PAIDTHRU']));
			$this->db->insert('req_delivery_hdr', $DATA_HDR);

			$ID_POST 	= $this->input->post('cont_post');
			$ARRID_POST = explode(',', $ID_POST);
			$JML_CONT 	= count($ARRID_POST);
			$DG 		= $DTL['DG']; 

			for($x= 0; $x < $JML_CONT; $x++){
				$arrid_val = explode('~',$ARRID_POST[$x]);
				foreach($this->input->post('DTL_'.$arrid_val[1]) as $a => $b){
					if($b=="") unset($DTL[$a]);
					else $DTL[$a] = strtoupper(trim($b));
				}

				$SIZE 		 = $DTL['UKR_CONT'];
				$TYPE 		 = $DTL['TYPE'];
				$STATUS 	 = $DTL['STATUS'];
				$FL_DG 		 = $DTL['DG'];
				$StartNHI	 = $DATA['TGL_NHI'];
				$EndNHI		 = $DATA['TGL_BK_SEGEL'];
				$IDREQ 		 = $DATA['ID'];
				$NO_DOK 	 = $DATA['NO_DOK'];
				$IdReqOld 	 = $DATA['ID'];

				$SQL 		 = $this->db->query("SELECT * FROM m_tarif WHERE SIZE = '$SIZE' AND TYPE ='$TYPE' AND STATUS =  '$STATUS'")->row();
				$SQL_SP2 	 = $this->db->query("SELECT * FROM m_tarif WHERE SIZE = '$SIZE' AND TYPE ='$TYPE' AND STATUS =  '$STATUS' AND JENIS_BIAYA='SP2'")->row();
				$SQL_PAID 	 = $this->db->query("SELECT EXPIRED AS PAID FROM req_delivery_hdr WHERE ID_REQ = '$IDREQ'")->row()->PAID;
				$SQL_STACK 	 = $this->db->query("SELECT DISTINCT M1_START_DATE AS FIRSTACK FROM req_delivery_dtl WHERE ID_REQ = '$IDREQ' AND M1_START_DATE IS NOT NULL")->row()->FIRSTACK;
				$TGL_BONGKAR = $this->db->query("SELECT DISTINCT TGL_STACK AS TGL_BONGKAR FROM req_delivery_HDR WHERE ID_REQ = '$IDREQ' AND TGL_STACK IS NOT NULL")->row()->TGL_BONGKAR;
				$COUNT_CONT  = $this->db->query("SELECT COUNT(A.NO_CONT) AS 'NO_CONT' FROM t_permit_cont A, t_permit_hdr C WHERE C.ID = A.ID AND C.NO_DOK_INOUT ='$NO_DOK'")->row();
				$SQL_BILLING = $this->db->query("SELECT DISTINCT IFNULL(TGL_REQ_SP2,TGL_REQ) AS 'SQL_BILLING' FROM req_delivery_hdr WHERE ID_REQ = '$IDREQ'")->row()->SQL_BILLING;
				$CekBilling  = $this->db->query("SELECT DISTINCT TGL_REQ_SP2 AS 'CEK_SQL_BILLING' FROM req_delivery_hdr WHERE ID_REQ = '$IDREQ'")->row()->CEK_SQL_BILLING;
				$SQL_ADMIN 	 = $this->db->query("SELECT * FROM m_tarif WHERE JENIS_BIAYA = 'ADMIN'")->row();

				$TARIF_HARGA = $SQL->TARIF;
				$TARIF_ID 	 = $SQL->TARIF_ID;
				$PaidThruOld = $SQL_PAID; 
				$FirstStack	 = date('Y-m-d', strtotime($SQL_STACK));
				$PaidThru 	 = date("Y-m-d", strtotime($DATA['PAIDTHRU'])); 
				$COUNTCONT 	 = $COUNT_CONT->NO_CONT;
				$TglSp2 	 = date("Y-m-d", strtotime($SQL_BILLING)); 

				if ($FL_DG == '') {
					$Charge 	 = $TARIF_HARGA;
					$TYPE_CONT 	 = $DTL['TYPE'];
					$Charge_sp2  = $SQL_SP2->TARIF;
				}else if($FL_DG == 'DG'){
					$Charge 	 = ($TARIF_HARGA * 2);
					$TYPE_CONT 	 =  $DTL['DG'];
					$Charge_sp2  = ($SQL_SP2->TARIF * 2);
				}else{
					$Charge 	 = ($TARIF_HARGA * 3);
					$TYPE_CONT 	 =  $DTL['DG'];
					$Charge_sp2  = ($SQL_SP2->TARIF * 3);
				}

				$jam = date("Hi", strtotime($FirstStack));
				if ($jam > "1200") {
					$MasaBebas = date("Y-m-d", strtotime($FirstStack . "+1 days"));
				} else {
					$MasaBebas = date("Y-m-d", strtotime($FirstStack));
				}

				$indexNHI		 = 0;
				$SelisihNHI		 = 0;
				$SelisihMasa1 	 = 0;
				$SelisihMasa2 	 = 0;
				$SelisihMasa3 	 = 0;
				$PenumpukanNHI 	 = 0;
				$PenumpukanMasa1 = 0;
				$PenumpukanMasa2 = 0;
				$PenumpukanMasa3 = 0;

				if ($STATUS == 'EMPTY') {
					$Masa1 = date("Y-m-d", strtotime($MasaBebas . "+2 days")); 
					$Masa2 = date("Y-m-d", strtotime($Masa1 . "+7 days")); 
					$Masa3 = date("Y-m-d", strtotime($Masa2 . "+1 days")); 

					echo "Masa Bebas 	> ".$MasaBebas."<br>";
					echo "Masa 1 		> ".$Masa1."<br>";
					echo "Masa 2 		> ".$Masa2."<br>";
					echo "Masa 3 		> ".$Masa3."<br>";
					echo "Masa Paid		> ".$PaidThru."<br>";
					echo "Masa Paid Old	> ".$PaidThruOld."<br>";

					$DateTime1 	 = new DateTime($MasaBebas);
					$DateTime2	 = new DateTime($PaidThru);
					$difference  = $DateTime1->diff($DateTime2);
					$selisihDiff = $difference->days;
					$selisih 	 = $selisihDiff;
					echo "Selisih Paid > ".$selisih."<br>";

					for ($i=0; $i <= $selisih; $i++) { 
						$checkDate = date("Y-m-d", strtotime($i . " days" . $MasaBebas));
						echo $checkDate." - ";
						if (($checkDate <= $Masa1)&&($checkDate > $PaidThruOld)) {
							$SelisihMasa1 ++;
							$PenumpukanMasa1 = $PenumpukanMasa1 + ($Charge * 0);
							echo $PenumpukanMasa1 ;
						}
						if (($checkDate > $Masa1)&&($checkDate <= $Masa2)&&($checkDate > $PaidThruOld)) {
							$SelisihMasa2 ++;
							$PenumpukanMasa2 = $PenumpukanMasa2 + ($Charge * 2);
							echo $PenumpukanMasa2;
							if ($PaidThru >= $Masa2) {
								$EndDateMasa2 = $Masa2;
							}else{
								$EndDateMasa2 = $PaidThru;
							}
						}
						if (($checkDate >= $Masa3)&&($checkDate <= $PaidThru)&&($checkDate > $PaidThruOld)) {
							$SelisihMasa3 ++;
							$PenumpukanMasa3 = $PenumpukanMasa3 + ($Charge * 3);
							echo $PenumpukanMasa3;
						}
						echo "<br>";
					}
					$Total = $PenumpukanMasa1 + $PenumpukanMasa2 + $PenumpukanMasa3 ;
					if ($Total > 0) {
						$DETAIL['ID_REQ'] 		 = $REQ;
						$DETAIL['ID_BILLING'] 	 = $ID_BIL;
						$DETAIL['NO_CONT'] 		 = $DTL['NO_CONT'];
						$DETAIL['UKR_CONT'] 	 = $DTL['UKR_CONT'];
						$DETAIL['ISO_CODE'] 	 = $TYPE_CONT;
						$DETAIL['STATUS'] 		 = $DTL['STATUS'];
						$DETAIL['TARIF_ID'] 	 = $TARIF_ID;
						$DETAIL['CHARGE'] 		 = $Charge;
						$DETAIL['TOTAL_UNIT'] 	 = '1';
						$DETAIL['TOTAL'] 		 = $Total;
						$DETAIL['PROSEN_M1'] 	 = '0';
						$DETAIL['SELISIH_M1'] 	 = '0';
						$DETAIL['M1_START_DATE'] = NULL;
						$DETAIL['M1_END_DATE'] 	 = NULL;
						$DETAIL['TOTAL_M1'] 	 = '0';
						$DETAIL['PROSEN_M2'] 	 = '0';
						$DETAIL['SELISIH_M2'] 	 = '0';
						$DETAIL['M2_START_DATE'] = NULL;
						$DETAIL['M2_END_DATE'] 	 = NULL;
						$DETAIL['TOTAL_M2'] 	 = $PenumpukanMasa1;
						$DETAIL['PROSEN_M3'] 	 = '2';
						$DETAIL['SELISIH_M3'] 	 = $SelisihMasa2;
						$DETAIL['M3_START_DATE'] = date("Y-m-d", strtotime($Masa1 . "+1 days"));
						$DETAIL['M3_END_DATE'] 	 = $EndDateMasa2;
						$DETAIL['TOTAL_M3'] 	 = $PenumpukanMasa2;
						$DETAIL['PROSEN_M4'] 	 = '3';
						$DETAIL['SELISIH_M4'] 	 = $SelisihMasa3;
						$DETAIL['M4_START_DATE'] = date("Y-m-d", strtotime($PaidThruOld. "+1 days"));
						$DETAIL['M4_END_DATE'] 	 = $PaidThru;
						$DETAIL['TOTAL_M4'] 	 = $PenumpukanMasa3;
						$DETAIL['WK_REKAM'] 	 = date('Y-m-d H:i:s');
						$DETAIL['FL_DG'] 		 = $DTL['DG'];
						$this->db->insert('req_delivery_dtl',$DETAIL);
						if ($PenumpukanMasa1 > 0) {
							$SIM_M1['ID_REQ'] 		= $REQ ;
							$SIM_M1['ID_BILLING'] 	= $ID_BIL;
							$SIM_M1['NO_CONT'] 		= $DTL['NO_CONT'] ;
							$SIM_M1['UKR_CONT'] 	= $DTL['UKR_CONT'] ;
							$SIM_M1['CHARGE'] 		= $Charge;
							$SIM_M1['JENIS_TARIF'] 	= 'PENUMPUKAN 1';
							$SIM_M1['TOTAL'] 		= $PenumpukanMasa1;
							$SIM_M1['WK_REKAM'] 	= date('Y-m-d H:i:s');
							$this->db->insert('req_delivery_simkeu',$SIM_M1);
						}
						if ($PenumpukanMasa2 > 0) {
							$SIM_M2['ID_REQ']		= $REQ ;
							$SIM_M2['ID_BILLING'] 	= $ID_BIL;
							$SIM_M2['NO_CONT'] 		= $DTL['NO_CONT'] ;
							$SIM_M2['UKR_CONT'] 	= $DTL['UKR_CONT'] ;
							$SIM_M2['CHARGE'] 		= $Charge;
							$SIM_M2['JENIS_TARIF'] 	= 'PENUMPUKAN 1.1';
							$SIM_M2['TOTAL'] 		= $PenumpukanMasa2;
							$SIM_M2['WK_REKAM'] 	= date('Y-m-d H:i:s');
							$this->db->insert('req_delivery_simkeu',$SIM_M2);
						}
						if ($PenumpukanMasa3 > 0) {
							$SIM_M3['ID_REQ'] 		= $REQ ;
							$SIM_M3['ID_BILLING'] 	= $ID_BIL;
							$SIM_M3['NO_CONT'] 		= $DTL['NO_CONT'] ;
							$SIM_M3['UKR_CONT'] 	= $DTL['UKR_CONT'] ;
							$SIM_M3['CHARGE'] 		= $Charge;
							$SIM_M3['JENIS_TARIF'] 	= 'PENUMPUKAN 2';
							$SIM_M3['TOTAL'] 		= $PenumpukanMasa3;
							$SIM_M3['WK_REKAM'] 	= date('Y-m-d H:i:s');
							$this->db->insert('req_delivery_simkeu',$SIM_M3);
						}
					}
				}else{
					$Masa1 = date("Y-m-d", strtotime($MasaBebas . "+1 days")); 
					$Masa2 = date("Y-m-d", strtotime($Masa1 . "+1 days")); 
					$Masa3 = date("Y-m-d", strtotime($Masa2 . "+1 days")); 

					echo "Masa Bebas 	> ".$MasaBebas."<br>";
					echo "Masa 1 		> ".$Masa1."<br>";
					echo "Masa 2 		> ".$Masa2."<br>";
					echo "Masa 3 		> ".$Masa3."<br>";
					echo "Masa Paid		> ".$PaidThru."<br>";
					echo "Masa PaidOld	> ".$PaidThruOld."<br>";
					echo "Masa NHI		> ".$StartNHI."<br>";
					echo "Masa END NHI	> ".$EndNHI."<br>";

					$DateTime1 	 = new DateTime($MasaBebas);
					$DateTime2	 = new DateTime($PaidThru);
					$difference  = $DateTime1->diff($DateTime2);
					$selisihDiff = $difference->days;
					$selisih 	 = $selisihDiff;
					echo "Selisih Paid > ".$selisih."<br>";

					$DateTime3 	 = new DateTime($StartNHI);
					$DateTime4	 = new DateTime($EndNHI);
					$difference  = $DateTime3->diff($DateTime4);
					$selisihDiff = $difference->days;
					$selisihNHI  = $selisihDiff;
					echo "Selisih NHI > ".$selisihNHI."<br>";

					for ($i=0; $i <= $selisihNHI; $i++) { 
						$checkDate1[] = date("Y-m-d", strtotime($i . " days" . $StartNHI));
					}
					for ($j=0; $j <= $selisih; $j++) { 
						$checkDate = date("Y-m-d", strtotime($j . " days" . $MasaBebas));
						echo $checkDate." - ";
						if((in_array($checkDate, $checkDate1))&&($selisihNHI !=0)){
							if ($checkDate > $PaidThruOld) {
								$PenumpukanNHI = $PenumpukanNHI + ($Charge * 0);
								echo $PenumpukanNHI;
							}
						}else{
							if (($checkDate <= $MasaBebas)&&($checkDate > $PaidThruOld)) {
								$SelisihMasaBebas = 0;
								$PenumpukanMasaBebas = $SelisihMasaBebas * ($Charge * 0);
								echo $PenumpukanMasaBebas;
							}
							if (($checkDate <= $Masa1)&&($checkDate > $PaidThruOld)) {
								$SelisihMasa1 = 1;
								$PenumpukanMasa1 = $SelisihMasa1 * ($Charge * 3);
								echo $PenumpukanMasa1;
							}
							if (($checkDate <= $Masa2)&&($checkDate > $PaidThruOld)) {
								$SelisihMasa2 = 1;
					 			$PenumpukanMasa2 = $SelisihMasa2 * ($Charge * 6);
								echo $PenumpukanMasa2;
							}
							if (($checkDate >= $Masa3)&&($checkDate <= $PaidThru)&&($checkDate > $PaidThruOld)) {
								$SelisihMasa3 ++;
								$PenumpukanMasa3 = $PenumpukanMasa3 + ($Charge * 9);
								echo $PenumpukanMasa3;
							}
						}
						echo "<br>";
					}
					$Total = $PenumpukanMasaBebas  + $PenumpukanNHI + $PenumpukanMasa1 + $PenumpukanMasa2 + $PenumpukanMasa3;
					if ($Total > 0) {
						$DETAIL['ID_REQ'] 			= $REQ;
						$DETAIL['ID_BILLING'] 		= $ID_BIL;
						$DETAIL['NO_CONT'] 			= $DTL['NO_CONT'];
						$DETAIL['UKR_CONT']			= $DTL['UKR_CONT'];
						$DETAIL['ISO_CODE'] 		= $TYPE_CONT;
						$DETAIL['STATUS'] 			= $DTL['STATUS'];
						$DETAIL['TARIF_ID'] 		= $TARIF_ID;
						$DETAIL['CHARGE'] 			= $Charge;
						$DETAIL['TOTAL_UNIT'] 		= '1';
						$DETAIL['TOTAL'] 			= $Total;
						$DETAIL['PROSEN_M1'] 		= '0';
						$DETAIL['SELISIH_M1'] 		= $SelisihMasaBebas;
						$DETAIL['M1_START_DATE'] 	= $MasaBebas;
						$DETAIL['M1_END_DATE'] 		= $MasaBebas;
						$DETAIL['TOTAL_M1'] 		= $PenumpukanMasaBebas;
						$DETAIL['PROSEN_M2'] 		= '3';
						$DETAIL['SELISIH_M2'] 		= $SelisihMasa1;
						$DETAIL['M2_START_DATE'] 	= $Masa1;
						$DETAIL['M2_END_DATE'] 		= $Masa1;
						$DETAIL['TOTAL_M2']			= $PenumpukanMasa1;
						$DETAIL['PROSEN_M3'] 		= '6';
						$DETAIL['SELISIH_M3'] 		= $SelisihMasa2;
						$DETAIL['M3_START_DATE'] 	= $Masa2;
						$DETAIL['M3_END_DATE'] 		= $Masa2;
						$DETAIL['TOTAL_M3'] 		= $PenumpukanMasa2;
						$DETAIL['PROSEN_M4'] 		= '9';
						$DETAIL['SELISIH_M4'] 		= $SelisihMasa3;
						$DETAIL['M4_START_DATE'] 	= date("Y-m-d", strtotime($PaidThruOld. "+1 days"));
						$DETAIL['M4_END_DATE'] 		= $PaidThru;
						$DETAIL['TOTAL_M4'] 		= $PenumpukanMasa3;
						$DETAIL['PROSEN_NHI'] 		= '2';
						$DETAIL['SELISIH_NHI'] 		= $selisihNHI;
						$DETAIL['NHI_START_DATE'] 	= $StartNHI;
						$DETAIL['NHI_END_DATE'] 	= $EndNHI;
						$DETAIL['TOTAL_NHI4']   	= $PenumpukanNHI;
						$DETAIL['WK_REKAM'] 		= date('Y-m-d H:i:s');
						$DETAIL['FL_DG'] 			= $DTL['DG'];
						$this->db->insert('req_delivery_dtl',$DETAIL);
						if ($PenumpukanMasa1 > 0) {
							$SIM_M1['ID_REQ'] 		= $REQ ;
							$SIM_M1['ID_BILLING'] 	= $ID_BIL;
							$SIM_M1['NO_CONT'] 		= $DTL['NO_CONT'] ;
							$SIM_M1['UKR_CONT'] 	= $DTL['UKR_CONT'] ;
							$SIM_M1['CHARGE'] 		= $Charge;
							$SIM_M1['JENIS_TARIF'] 	= 'PENUMPUKAN 1';
							$SIM_M1['TOTAL'] 		= $PenumpukanMasa1;
							$SIM_M1['WK_REKAM'] 	= date('Y-m-d H:i:s');
							$this->db->insert('req_delivery_simkeu',$SIM_M1);
						}
						if ($PenumpukanMasa2 > 0) {
							$SIM_M2['ID_REQ'] 		= $REQ ;
							$SIM_M2['ID_BILLING'] 	= $ID_BIL;
							$SIM_M2['NO_CONT'] 		= $DTL['NO_CONT'] ;
							$SIM_M2['UKR_CONT'] 	= $DTL['UKR_CONT'] ;
							$SIM_M2['CHARGE'] 		= $Charge;
							$SIM_M2['JENIS_TARIF'] 	= 'PENUMPUKAN 1.1';
							$SIM_M2['TOTAL'] 		= $PenumpukanMasa2;
							$SIM_M2['WK_REKAM'] 	= date('Y-m-d H:i:s');
							$this->db->insert('req_delivery_simkeu',$SIM_M2);
						}
						if ($PenumpukanMasa3 > 0) {
							$SIM_M3['ID_REQ'] 		= $REQ ;
							$SIM_M3['ID_BILLING'] 	= $ID_BIL;
							$SIM_M3['NO_CONT'] 		= $DTL['NO_CONT'] ;
							$SIM_M3['UKR_CONT'] 	= $DTL['UKR_CONT'] ;
							$SIM_M3['CHARGE'] 		= $Charge;
							$SIM_M3['JENIS_TARIF'] 	= 'PENUMPUKAN 2';
							$SIM_M3['TOTAL'] 		= $PenumpukanMasa3;
							$SIM_M3['WK_REKAM'] 	= date('Y-m-d H:i:s');
							$this->db->insert('req_delivery_simkeu',$SIM_M3);
						}
						if ($PenumpukanNHI > 0) {
							$SIM_NHI['ID_REQ'] 		= $REQ ;
							$SIM_NHI['ID_BILLING'] 	= $ID_BIL;
							$SIM_NHI['NO_CONT'] 	= $DTL['NO_CONT'] ;
							$SIM_NHI['UKR_CONT'] 	= $DTL['UKR_CONT'] ;
							$SIM_NHI['CHARGE'] 		= $Charge;
							$SIM_NHI['JENIS_TARIF'] = 'PENUMPUKAN NHI';
							$SIM_NHI['TOTAL'] 		= $PenumpukanNHI;
							$SIM_NHI['WK_REKAM'] 	= date('Y-m-d H:i:s');
							print_r($SIM_NHI);
							$this->db->insert('req_delivery_simkeu',$SIM_NHI);
						}
					}
					#DENDA SP2
					$JumlahKontainerPerBL = $COUNTCONT;
				   	echo "jum cont ".$JumlahKontainerPerBL."<br>";
				   	if ($JumlahKontainerPerBL > 30) {
				   		$JumlahMasaBebas = 4;
				   	}else{
				   		$JumlahMasaBebas = 2;
				   	}

				   	$DateTimeSp21	= new DateTime($PaidThru);
				   	$DateTimeSp22	= new DateTime($TglSp2);
				   	$difference		= $DateTimeSp21->diff($DateTimeSp22);
				   	$selisih 		= $difference->days;
				    $GetDateDiff 	= $selisih;
				    echo "Selisih SP2 > ".$GetDateDiff."<br>";

				    $SelisihDateM1Sp2 = 0;
					$SelisihDateM2Sp2 = 0;
					$SelisihDateM3Sp2 = 0;
					$SelisihDateM4Sp2 = 0;
					$DendaM1Sp2 = 0;
					$DendaM2Sp2 = 0;
					$DendaM3Sp2 = 0;
					$DendaM4Sp2 = 0;

					$SelisihMasaBebas = $GetDateDiff;
					echo "SelisihMasaBebas ".$SelisihMasaBebas."<br>";
					if ($SelisihMasaBebas > 0) {
						if ($CekBilling != 0) {
							$StartDenda = date("Y-m-d", strtotime($TglSp2. "+1 days"));
							echo "Tanggal SP2<br>";
						}else{
							$StartDenda = date("Y-m-d", strtotime($TglSp2. "+2 days"));
							echo "Tanggal REQUEST<br>";
						}
						for ($i=0; $i <= $SelisihMasaBebas ; $i++) { 
							$checkDendaPS2Date = date("Y-m-d", strtotime($i . " days" . $TglSp2));
						    echo $checkDendaPS2Date."--";
						    if((in_array($checkDendaPS2Date, $checkDate1))&&($selisihNHI !=0)){
						    	$SelisihDateNHISp2 = 0;
								$DendaMHISp2 = $SelisihDateNHISp2 * (($Charge_sp2 * 0) * 3);
								echo $DendaMHISp2;
						    }else{
								if ($checkDendaPS2Date == $MasaBebas) {
			                		if ($checkDendaPS2Date >= $StartDenda) {
				                		$SelisihDateM1Sp2 = 0;
				                    	$DendaM1Sp2 = $SelisihDateM1Sp2 * (($Charge_sp2 * 0) * 3);
				                    	echo $DendaM1Sp2;
				                    }
			                	}
								if ($checkDendaPS2Date == $Masa1) {
			                		if ($checkDendaPS2Date >= $StartDenda) {
				                		$SelisihDateM2Sp2 = 1;
				                    	$DendaM2Sp2 = $SelisihDateM2Sp2 * (($Charge_sp2 * 3) * 3);
				                    	echo $DendaM2Sp2;
				                    }
			                	}
								if ($checkDendaPS2Date == $Masa2) {
			                		if ($checkDendaPS2Date >= $StartDenda) {
				                		$SelisihDateM3Sp2 = 1;
				                    	$DendaM3Sp2 = $SelisihDateM3Sp2 * (($Charge_sp2 * 6) * 3);
				                    	echo $DendaM3Sp2;
				                    }
			                	}
								if (($checkDendaPS2Date >= $Masa3)&&($checkDendaPS2Date <= $PaidThru)) {
			                		if ($checkDendaPS2Date >= $StartDenda) {
				                		$SelisihDateM4Sp2++;
										$DendaM4Sp2 = $DendaM4Sp2 + (($Charge_sp2 * 9) * 3);
										echo $DendaM4Sp2;
				                    }
			                	}
						    }
						    echo "<br>";
						}
						$TotalDendaSp2 = $DendaM1Sp2 + $DendaM2Sp2 + $DendaM3Sp2 + $DendaM4Sp2;
						if ($TotalDendaSp2 > 0){
							$DENDA_SP2['ID_REQ'] 			= $REQ;
							$DENDA_SP2['ID_BILLING'] 		= $ID_BIL;
							$DENDA_SP2['NO_CONT'] 			= $DTL['NO_CONT'];
							$DENDA_SP2['UKR_CONT'] 			= $DTL['UKR_CONT'];
							$DENDA_SP2['ISO_CODE'] 			= $TYPE_CONT;
							$DENDA_SP2['STATUS'] 			= $DTL['STATUS'];
							$DENDA_SP2['TARIF_ID'] 			= $SQL_SP2->TARIF_ID;
							$DENDA_SP2['CHARGE'] 			= $Charge_sp2;
							$DENDA_SP2['TOTAL_UNIT'] 		= '1';
							$DENDA_SP2['TOTAL'] 			= $TotalDendaSp2;
							$DENDA_SP2['PROSEN_M1'] 		= '0';
							$DENDA_SP2['SELISIH_M1'] 		= $SelisihDateM1Sp2;
							$DENDA_SP2['M1_START_DATE'] 	= $MasaBebas;
							$DENDA_SP2['M1_END_DATE'] 		= $MasaBebas;
							$DENDA_SP2['TOTAL_M1'] 			= $DendaM1Sp2;
							$DENDA_SP2['PROSEN_M2'] 		= '3';
							$DENDA_SP2['SELISIH_M2'] 		= $SelisihDateM2Sp2;
							$DENDA_SP2['M2_START_DATE'] 	= $Masa1;
							$DENDA_SP2['M2_END_DATE'] 		= $Masa1;
							$DENDA_SP2['TOTAL_M2'] 			= $DendaM2Sp2;
							$DENDA_SP2['PROSEN_M3'] 		= '6';
							$DENDA_SP2['SELISIH_M3'] 		= $SelisihDateM3Sp2;
							$DENDA_SP2['M3_START_DATE'] 	= $Masa2;
							$DENDA_SP2['M3_END_DATE'] 		= $Masa2;
							$DENDA_SP2['TOTAL_M3'] 			= $DendaM3Sp2;
							$DENDA_SP2['PROSEN_M4'] 		= '9';
							$DENDA_SP2['SELISIH_M4'] 		= $SelisihDateM4Sp2;
							$DENDA_SP2['M4_START_DATE'] 	= $StartDenda;
							$DENDA_SP2['M4_END_DATE'] 		= $PaidThru;
							$DENDA_SP2['TOTAL_M4'] 			= $DendaM4Sp2;
							$DENDA_SP2['WK_REKAM'] 			= date('Y-m-d H:i:s');
							$this->db->insert('req_delivery_dtl',$DENDA_SP2);
							$GantiTglSp2['TGL_REQ_SP2'] 	= $PaidThru;
							$this->db->where(array('ID_REQ' => $REQ));
							$this->db->update('req_delivery_hdr', $GantiTglSp2);
							if ($TotalDendaSp2 > 0) {
								$SIM_M1SP2['ID_REQ'] 		= $REQ ;
								$SIM_M1SP2['ID_BILLING'] 	= $ID_BIL;
								$SIM_M1SP2['NO_CONT'] 		= $DTL['NO_CONT'] ;
								$SIM_M1SP2['UKR_CONT'] 		= $DTL['UKR_CONT'] ;
								$SIM_M1SP2['CHARGE'] 		= $Charge_sp2;
								$SIM_M1SP2['JENIS_TARIF'] 	= 'DENDA SP 2';
								$SIM_M1SP2['TOTAL'] 		= $TotalDendaSp2;
								$SIM_M1SP2['WK_REKAM'] 		= date('Y-m-d H:i:s');
								$this->db->insert('req_delivery_simkeu',$SIM_M1SP2);
							}
						}
					}
				}
			}
			// BIAYA ADMIN
			$TARIF_ADMIN 			= $SQL_ADMIN->TARIF;
			$TARIF_ADMIN_ID 		= $SQL_ADMIN->TARIF_ID;
			$DATA_ADM['ID_REQ'] 	= $REQ;
			$DATA_ADM['ID_BILLING'] = $ID_BIL;
			$DATA_ADM['TARIF_ID'] 	= $TARIF_ADMIN_ID;
			$DATA_ADM['CHARGE'] 	= $TARIF_ADMIN;
			$DATA_ADM['TOTAL'] 		= $TARIF_ADMIN;
			$this->db->insert('req_delivery_dtl', $DATA_ADM);
			$SIM_ADM['ID_REQ'] 		= $REQ ;
			$SIM_ADM['ID_BILLING']  = $ID_BIL;
			$SIM_ADM['CHARGE'] 		= $TARIF_ADMIN;
			$SIM_ADM['JENIS_TARIF'] = 'ADMINISTRASI';
			$SIM_ADM['TOTAL'] 		= $TARIF_ADMIN;
			$SIM_ADM['WK_REKAM'] 	= date('Y-m-d H:i:s');
			$this->db->insert('req_delivery_simkeu',$SIM_ADM);

			//EDITBILLING CG
			$sub_total 	= $this->db->query("SELECT SUM(TOTAL) AS TOTAL FROM req_delivery_dtl WHERE ID_REQ = '$REQ'")->row()->TOTAL;
			$PPN 		= $sub_total * 0.1;
			if($sub_total >= 1000000){
				$MAT = 6000;
			} else {
				$MAT = 3000;
			}
			$TOTAL_ALL = $MAT + $sub_total + $PPN;
			$DATA_HDR_UP['BIAYA_MATERAI'] 	= $MAT;
			$DATA_HDR_UP['SUBTOTAL'] 		= $sub_total;
			$DATA_HDR_UP['PPN'] 			= $PPN;
			$DATA_HDR_UP['TOTAL'] 			= $TOTAL_ALL;
			$DATA_HDR_UP['TGL_STACK'] 		= $TGL_BONGKAR;
			$this->db->where(array('ID_REQ' => $REQ));
			$this->db->update('req_delivery_hdr', $DATA_HDR_UP);

			$this->db->where(array('ID_REQ' =>$IdReqOld));
			$this->db->update('req_delivery_hdr', array('FL_ID_REQ_OLD' => 'Y'));

			echo "MSG#OK#Data berhasil diproses#".site_url()."/billingDeliveryExt/delivery_ext/post";
		}else if($act=="update"){
			foreach($this->input->post('DATA') as $a => $b){
				if($b=="") unset($DATA[$a]);
				else $DATA[$a] = strtoupper(trim($b));
			}
			
			$id = $DATA['ID'];
			$DATAN['NPWP'] = $DATA['NPWP'];
			$DATAN['EXPIRED'] = $DATA['EXPIRED'];
			$DATAN['NM_KAPAL'] = $DATA['NM_KAPAL'];
			$DATAN['NO_DOK'] = $DATA['NO_DOK'];
			$DATAN['NO_DO'] = $DATA['NO_DO'];
			$DATAN['NO_VOY'] = $DATA['NO_VOY'];
			$DATAN['TGL_DOK'] = $DATA['TGL_DOK'];
			
			$this->db->where(array('ID_REQ' => $id));
			$result = $this->db->update('req_delivery_hdr', $DATAN);

			if($error == 0){
				$action = '/billingDeliveryExt/delivery_ext/post';
				echo "MSG#OK#Data berhasil diproses#".$this->input->post('action');
			}else{
				echo "MSG#ERR#".$message."#";
			}
		}
	}

	public function confirm_delivery_ext(){
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
			$query = "SELECT LPAD(SEQUENCE+1,'6','0') SEQ, (SEQUENCE+1) SEQUE FROM m_generate_nota WHERE TYPE_NOTA = 'DELIVERY'";
			$rs = $this->db->query($query);
			$data = $rs->row_array();
			$seq = $data["SEQ"];
			$seque = $data["SEQUE"];
			$no_nota_delivery = '010.801.18-61.'.$seq;

			$query = "UPDATE m_generate_nota SET SEQUENCE = '$seque' WHERE TYPE_NOTA = 'DELIVERY'";
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
			$action = '/billingDeliveryExt/delivery_ext/post';
			echo "MSG#OK#Data berhasil diproses#".site_url().$action;
		}else{
			echo "MSG#ERR#".$message."#";
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
								WHERE A.NO_DOK  LIKE '%$cek_nodok%' AND A.ID_REQ='$id_req' AND A.ID_REQ_OLD IS NOT NULL AND B.NO_CONT IS NOT NULL
								GROUP BY B.NO_CONT";
			$result = $this->db->query($SQLUpdtGatePass)->result_array();
			$EXPRIED = $this->db->query($SQLUpdtGatePass)->row()->EXPIRED;
			$NO_CONT = $this->db->query($SQLUpdtGatePass)->row()->NO_CONT;
			$NO_DOK = $this->db->query($SQLCekGatePass)->row()->NO_DOK;
			$totalCont = count($result); echo "Total : $totalCont";
			for ($i=0; $i <= $totalCont ; $i++) { 
				$tmpData = array(
						"EXPIRED_DATE" => $EXPRIED, 
						"WK_REK" => date('Y-m-d H:i:s')
					);
				$this->db->where(array('NO_CONT' =>$result[$i]['NO_CONT'], 'NO_DOK'=>$resultGatePass[$i]['NO_DOK']));
				// $this->db->where('id',$resultGatePass[$i]['ID']);
				$this->db->update('t_gatepass',$tmpData);
			}
			echo "berhasil Insert";
		}else{
			echo "Data Belum Pernah Di Proses";
		}			
	}

	public function get_data_bank(){
		$SQL =  $this->db->query("SELECT BANK_ID, NAMA_BANK, REKENING FROM m_bank WHERE FL_ACTIVE='N'");
		return $SQL->result_array();
	}

	public function get_data_delivery_hdr($id){
		$sql = $this->db->query("SELECT A.* , B.NAMA_CUST, B.NPWP
								FROM req_delivery_hdr A LEFT JOIN m_pelanggan B ON REPLACE(REPLACE(A.NPWP,'.',''),'-','') = REPLACE(REPLACE(B.NPWP,'.',''),'-','')
								WHERE A.ID_REQ = '$id'");
		return $sql->result();
	}

	public function get_data_delivery_dtl($id){
		$sql = $this->db->query("SELECT DISTINCT NO_CONT, ID_REQ, UKR_CONT FROM req_delivery_dtl WHERE ID_REQ = '$id' AND NO_CONT IS NOT NULL");
		return $sql->result();
	}

	public function get_nota_del($id){
		$func = get_instance();
        $func->load->model("m_main", "main", true);
        $func->main->log_prints($id, $act);
		$arrid = explode("~",$id);
		$SQL = "
			SELECT 'PENUMPUKAN 1' AS TITLE, IFNULL(DATE_FORMAT(A.M2_START_DATE,'%d-%m-%Y'), '') AS 'START', IFNULL(DATE_FORMAT(A.M2_END_DATE,'%d-%m-%Y'), '') AS 'END', A.SELISIH_M2 AS HARI, A.UKR_CONT AS SIZE, A.ISO_CODE AS TYPE, A.STATUS, COUNT(DISTINCT A.NO_CONT) AS BOX, A.CHARGE * A.PROSEN_M2 AS TARIF, SUM(A.TOTAL_M2) AS JUMLAH
			FROM req_delivery_dtl A
			INNER JOIN m_tarif B ON A.TARIF_ID = B.TARIF_ID
			WHERE A.ID_REQ = '$id' AND B.JENIS_BIAYA = 'PENUMPUKAN' AND A.TOTAL_M2 > 0
			GROUP BY 'PENUMPUKAN 1', A.M2_START_DATE, A.M2_END_DATE, A.SELISIH_M2, A.UKR_CONT, A.ISO_CODE, A.STATUS, A.CHARGE 
			UNION ALL
			SELECT 'PENUMPUKAN 1.1' AS TITLE, IFNULL(DATE_FORMAT(A.M3_START_DATE,'%d-%m-%Y'), '') AS 'START', IFNULL(DATE_FORMAT(A.M3_END_DATE,'%d-%m-%Y'), '') AS 'END', A.SELISIH_M3 AS HARI, A.UKR_CONT AS SIZE, A.ISO_CODE AS TYPE, A.STATUS, COUNT(DISTINCT A.NO_CONT) AS BOX, A.CHARGE * A.PROSEN_M3 AS TARIF, SUM(A.TOTAL_M3) AS JUMLAH
			FROM req_delivery_dtl A
			INNER JOIN m_tarif B ON A.TARIF_ID = B.TARIF_ID
			WHERE A.ID_REQ = '$id' AND B.JENIS_BIAYA = 'PENUMPUKAN' AND A.TOTAL_M3 > 0
			GROUP BY 'PENUMPUKAN 1.1', A.M3_START_DATE, A.M3_END_DATE, A.SELISIH_M3, A.UKR_CONT, A.ISO_CODE, A.STATUS, A.CHARGE 
			UNION ALL
			SELECT 'PENUMPUKAN NHI' AS TITLE, IFNULL(DATE_FORMAT(A.NHI_START_DATE,'%d-%m-%Y'),'') AS 'START', IFNULL(DATE_FORMAT(A.NHI_END_DATE,'%d-%m-%Y'),'') AS 'END', DATEDIFF(DATE_FORMAT(A.NHI_END_DATE,'%Y-%m-%d'), DATE_FORMAT(A.NHI_START_DATE,'%Y-%m-%d')) AS HARI, A.UKR_CONT AS SIZE, A.ISO_CODE AS TYPE, A.`STATUS`, COUNT(DISTINCT A.NO_CONT) AS BOX, A.CHARGE * A.PROSEN_NHI AS TARIF, SUM(A.TOTAL_NHI4) AS JUMLAH
			FROM req_delivery_dtl A
			INNER JOIN m_tarif B ON A.TARIF_ID = B.TARIF_ID
			WHERE A.ID_REQ = '$id' AND B.JENIS_BIAYA = 'PENUMPUKAN' AND A.TOTAL_NHI4 > 0
			GROUP BY 'PENUMPUKAN NHI', A.NHI_START_DATE, A.NHI_END_DATE, HARI, A.UKR_CONT, A.ISO_CODE, A.STATUS, A.CHARGE 
			UNION ALL
			SELECT 'PENUMPUKAN 2' AS TITLE, IFNULL(DATE_FORMAT(A.M4_START_DATE,'%d-%m-%Y'), '') AS 'START', IFNULL(DATE_FORMAT(A.M4_END_DATE,'%d-%m-%Y'), '') AS 'END', A.SELISIH_M4 AS HARI, A.UKR_CONT AS SIZE, A.ISO_CODE AS TYPE, A.STATUS, COUNT(DISTINCT A.NO_CONT) AS BOX, A.CHARGE * A.PROSEN_M4 AS TARIF, SUM(A.TOTAL_M4) AS JUMLAH
			FROM req_delivery_dtl A
			INNER JOIN m_tarif B ON A.TARIF_ID = B.TARIF_ID
			WHERE A.ID_REQ = '$id' AND B.JENIS_BIAYA = 'PENUMPUKAN' AND A.TOTAL_M4 > 0
			GROUP BY 'PENUMPUKAN 2', A.M4_START_DATE, A.M4_END_DATE, A.SELISIH_M4, A.UKR_CONT, A.ISO_CODE, A.STATUS, A.CHARGE 
			UNION ALL
			SELECT 'DENDA SPPB 1' AS TITLE, IFNULL(DATE_FORMAT(A.M2_START_DATE,'%d-%m-%Y'), '') AS 'START', IFNULL(DATE_FORMAT(A.M2_END_DATE,'%d-%m-%Y'), '') AS 'END', A.SELISIH_M2 AS HARI, A.UKR_CONT AS SIZE, A.ISO_CODE AS TYPE, A.STATUS, COUNT(DISTINCT A.NO_CONT) AS BOX, A.CHARGE * A.PROSEN_M2 * 2 AS TARIF, SUM(A.TOTAL_M2) AS JUMLAH
			FROM req_delivery_dtl A
			INNER JOIN m_tarif B ON A.TARIF_ID = B.TARIF_ID
			WHERE A.ID_REQ = '$id' AND B.JENIS_BIAYA = 'SPPB' AND A.TOTAL_M2 > 0
			GROUP BY 'DENDA SPPB 1', A.M2_START_DATE, A.M2_END_DATE, A.SELISIH_M2, A.UKR_CONT, A.ISO_CODE, A.STATUS, A.CHARGE 
			UNION ALL
			SELECT 'DENDA SPPB 1.1' AS TITLE, IFNULL(DATE_FORMAT(A.M3_START_DATE,'%d-%m-%Y'), '') AS 'START', IFNULL(DATE_FORMAT(A.M3_END_DATE,'%d-%m-%Y'), '') AS 'END', A.SELISIH_M3 AS HARI, A.UKR_CONT AS SIZE, A.ISO_CODE AS TYPE, A.STATUS, COUNT(DISTINCT A.NO_CONT) AS BOX, A.CHARGE * A.PROSEN_M3 * 2 AS TARIF, SUM(A.TOTAL_M3) AS JUMLAH
			FROM req_delivery_dtl A
			INNER JOIN m_tarif B ON A.TARIF_ID = B.TARIF_ID
			WHERE A.ID_REQ = '$id' AND B.JENIS_BIAYA = 'SPPB' AND A.TOTAL_M2 > 0
			GROUP BY 'DENDA SPPB 1.1', A.M3_START_DATE, A.M3_END_DATE, A.SELISIH_M3, A.UKR_CONT, A.ISO_CODE, A.STATUS, A.CHARGE 
			UNION ALL
			SELECT 'DENDA SPPB 2' AS TITLE, IFNULL(DATE_FORMAT(A.M4_START_DATE,'%d-%m-%Y'), '') AS 'START', IFNULL(DATE_FORMAT(A.M4_END_DATE,'%d-%m-%Y'), '') AS 'END', A.SELISIH_M4 AS HARI, A.UKR_CONT AS SIZE, A.ISO_CODE AS TYPE, A.STATUS, COUNT(DISTINCT A.NO_CONT) AS BOX, A.CHARGE * A.PROSEN_M4 * 2 AS TARIF, SUM(A.TOTAL_M4) AS JUMLAH
			FROM req_delivery_dtl A
			INNER JOIN m_tarif B ON A.TARIF_ID = B.TARIF_ID
			WHERE A.ID_REQ = '$id' AND B.JENIS_BIAYA = 'SPPB' AND A.TOTAL_M4 > 0
			GROUP BY 'DENDA SPPB 2', A.M4_START_DATE, A.M4_END_DATE, A.SELISIH_M4, A.UKR_CONT, A.ISO_CODE, A.STATUS, A.CHARGE 
			UNION ALL
			SELECT 'DENDA SP2 1' AS TITLE, IFNULL(DATE_FORMAT(A.M2_START_DATE,'%d-%m-%Y'), '') AS 'START', IFNULL(DATE_FORMAT(A.M2_END_DATE,'%d-%m-%Y'), '') AS 'END', A.SELISIH_M2 AS HARI, A.UKR_CONT AS SIZE, A.ISO_CODE AS TYPE, A.STATUS, COUNT(DISTINCT A.NO_CONT) AS BOX, A.CHARGE * A.PROSEN_M2 * 3 AS TARIF, SUM(A.TOTAL_M2) AS JUMLAH
			FROM req_delivery_dtl A
			INNER JOIN m_tarif B ON A.TARIF_ID = B.TARIF_ID
			WHERE A.ID_REQ = '$id' AND B.JENIS_BIAYA = 'SP2' AND A.TOTAL_M2 > 0
			GROUP BY 'DENDA SP2 1', A.M2_START_DATE, A.M2_END_DATE, A.SELISIH_M2, A.UKR_CONT, A.ISO_CODE, A.STATUS, A.CHARGE 
			UNION ALL
			SELECT 'DENDA SP2 1.1' AS TITLE, IFNULL(DATE_FORMAT(A.M3_START_DATE,'%d-%m-%Y'), '') AS 'START', IFNULL(DATE_FORMAT(A.M3_END_DATE,'%d-%m-%Y'), '') AS 'END', A.SELISIH_M3 AS HARI, A.UKR_CONT AS SIZE, A.ISO_CODE AS TYPE, A.STATUS, COUNT(DISTINCT A.NO_CONT) AS BOX, A.CHARGE * A.PROSEN_M3 * 3 AS TARIF, SUM(A.TOTAL_M3) AS JUMLAH
			FROM req_delivery_dtl A
			INNER JOIN m_tarif B ON A.TARIF_ID = B.TARIF_ID
			WHERE A.ID_REQ = '$id' AND B.JENIS_BIAYA = 'SP2' AND A.TOTAL_M3 > 0
			GROUP BY 'DENDA SP2 1.1', A.M3_START_DATE, A.M3_END_DATE, A.SELISIH_M3, A.UKR_CONT, A.ISO_CODE, A.STATUS, A.CHARGE 
			UNION ALL
			SELECT 'DENDA SP2 2' AS TITLE, IFNULL(DATE_FORMAT(A.M4_START_DATE,'%d-%m-%Y'), '') AS 'START', IFNULL(DATE_FORMAT(A.M4_END_DATE,'%d-%m-%Y'), '') AS 'END', A.SELISIH_M4 AS HARI, A.UKR_CONT AS SIZE, A.ISO_CODE AS TYPE, A.STATUS, COUNT(DISTINCT A.NO_CONT) AS BOX, A.CHARGE * A.PROSEN_M4 * 3 AS TARIF, SUM(A.TOTAL_M4) AS JUMLAH
			FROM req_delivery_dtl A
			INNER JOIN m_tarif B ON A.TARIF_ID = B.TARIF_ID
			WHERE A.ID_REQ = '$id' AND B.JENIS_BIAYA = 'SP2' AND A.TOTAL_M4 > 0
			GROUP BY 'DENDA SP2 2', A.M4_START_DATE, A.M4_END_DATE, A.SELISIH_M4, A.UKR_CONT, A.ISO_CODE, A.STATUS, A.CHARGE 
			UNION ALL
			SELECT 'LIFT ON' AS TITLE, IFNULL(DATE_FORMAT(A.M4_START_DATE,'%d-%m-%Y'), '') AS 'START', IFNULL(DATE_FORMAT(A.M4_END_DATE,'%d-%m-%Y'), '') AS 'END', A.SELISIH_M4 AS 'HARI',
						A.UKR_CONT AS 'SIZE', A.ISO_CODE AS 'TYPE', A.STATUS AS 'STATUS', COUNT(A.NO_CONT) AS 'BOX', A.CHARGE AS 'TARIF', SUM(A.TOTAL) AS JUMLAH
			FROM req_delivery_dtl A
			INNER JOIN m_tarif B ON A.TARIF_ID = B.TARIF_ID
			WHERE A.ID_REQ = '$id' AND B.JENIS_BIAYA = 'LIFT ON'
			GROUP BY A.CHARGE"; 
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

	public function get_nota_del_hdr($id){
		$func = get_instance();
        $func->load->model("m_main", "main", true);
        $arrid = explode("~",$id);
		$SQL = "SELECT * FROM req_delivery_hdr WHERE ID_REQ = '$id'";
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
        $arrid = explode("~",$id);
		$SQL = "SELECT A.*, B.*
				FROM m_pelanggan A, req_delivery_hdr B
				WHERE REPLACE(
				REPLACE(A.NPWP,'.',''),'-','') =
				REPLACE(
				REPLACE(B.NPWP,'.',''),'-','') AND B.ID_REQ = '$id'";
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

	public function get_nota_cont($id){
		$func = get_instance();
        $func->load->model("m_main", "main", true);
        $arrid = explode("~",$id);
		$SQL = "SELECT GROUP_CONCAT(DISTINCT NO_CONT,'-',UKR_CONT) AS 'NO_KONTAINER' FROM req_delivery_dtl WHERE ID_REQ = '$id'";
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

	public function history_delivery_ext($id){
		$func = get_instance();
        $func->load->model("m_main", "main", true);
		$func->main->log_prints($id);
		$arrid = explode("~",$id);
		$kodeuser = $this->session->userdata("ID");

		$DATA['ID_HANDLE'] = $id;
		$DATA['TYPE_RPT'] = "nota_ext";
		$DATA['USER_PRINTS'] = $kodeuser;
		$DATA['DATE_PRINTS'] = date('Y-m-d H:i:s');
		$this->db->insert('hist_print', $DATA);
	}

	public function get_history_deliveryext($id){
		$SQL = "SELECT COUNT(ID_HANDLE) AS JML, B.NAMA, A.ID_HANDLE, A.USER_PRINTS, A.TYPE_RPT
				FROM hist_print A
				LEFT JOIN reff_user B ON A.USER_PRINTS = B.ID
				where A.ID_HANDLE = '".$id."' AND TYPE_RPT = 'nota_ext'
				GROUP BY USER_PRINTS
				";
        $result = $this->db->query($SQL); 
        return $result->result_array();
	}

	public function get_data_dokumen_delivery($id){
		$arrid = explode("~",$id);
		$sql = $this->db->query("SELECT A.NM_KAPAL, A.NO_VOY, B.NAMA_CUST, A.NPWP, A.NO_DO, DATE_FORMAT(A.TGL_DOK, '%Y-%m-%d') AS 'TGL_DOK', A.NO_DOK, A.EXPIRED
										FROM req_delivery_hdr A LEFT JOIN m_pelanggan B ON REPLACE(
										REPLACE(A.NPWP,'.',''),'-','') =
										REPLACE(
										REPLACE(B.NPWP,'.',''),'-','')
										WHERE A.ID_REQ = '$arrid[0]'");
		return $sql->result_array();
	}

	public function del_delivery_ext($id){
		$exparr = explode('~',$id);
		$id_req = $exparr[0];
		$no_dok = $exparr[1];
		$no_nota = $exparr[2];

		if($no_nota != ''){
			$message .= "DATA TIDAK BISA DIHAPUS";
			$error = 1;
		}else{
			$result = $this->db->delete('req_delivery_dtl', array('ID_REQ' => $id_req));
			$this->db->delete('req_delivery_hdr', array('ID_REQ' => $id_req));
			$this->db->delete('req_delivery_simkeu', array('ID_REQ' => $id_req));
			$this->db->where('NO_DOK',$no_dok);
			$this->db->update('req_delivery_hdr',array('FL_ID_REQ_OLD' => 'N'));
			print_r($this->db->last_query());

			if (!$result) {
	            $error += 1;
	            $message .= "Data gagal diproses";
	        }
		}

        if ($error==0) {
            echo "MSG#OK#Data berhasil diproses#".site_url()."/billingDeliveryExt/delivery_ext/post";
        } else {
            echo "MSG#ERR#".$message."#";
        }
	}

	public function resend_deliveryext($IdReq, $FlTrans, $FlReceipt){
		
		if (($FlTrans == 'F')&&($FlReceipt == 'F')) {
			$this->db->where(array('ID_REQ' =>$IdReq));
			$this->db->update('req_delivery_hdr',array('FL_SEND_TRANS_SIMKEU' => 'N','MESSAGE_SEND_TRANS_SIMKEU' => '','FL_SEND_RECEIPT_SIMKEU' => 'N','MESSAGE_SEND_RECEIPT_SIMKEU' => ''));
		}else if (($FlTrans == 'S')&&($FlReceipt == 'F')) {
			$this->db->where(array('ID_REQ' =>$IdReq));
			$this->db->update('req_delivery_hdr',array('FL_SEND_RECEIPT_SIMKEU' => 'N','MESSAGE_SEND_RECEIPT_SIMKEU' => ''));
		}else if (($FlTrans == 'F')&&($FlReceipt == 'Y')) {
			$this->db->where(array('ID_REQ' =>$IdReq));
			$this->db->update('req_delivery_hdr',array('FL_SEND_TRANS_SIMKEU' => 'N','MESSAGE_SEND_TRANS_SIMKEU' => '','FL_SEND_RECEIPT_SIMKEU' => 'N','MESSAGE_SEND_RECEIPT_SIMKEU' => ''));
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

/* End of file M_billing_delivery_ext.php */
/* Location: ./application/models/M_billing_delivery_ext.php */