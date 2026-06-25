<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class M_customer extends CI_Model {

	public function __construct(){
		parent::__construct();

	}


	public function info_billing($act, $id){
		$page_title = "TRACKING";
		$title = "TRACKING";
		$this->newtable->breadcrumb('Dashboard', site_url(),'icon-home');
		$this->newtable->breadcrumb('Customer', 'javascript:void(0)','');
		$this->newtable->breadcrumb('Info Tracking', 'javascript:void(0)','');
		$check = (grant()=="W")?true:false;
		$SQL = "SELECT ID,NO_CONT AS 'NO. KONTAINER', UKR_CONT AS 'UKURAN KONTAINER',LOKASI, ROOM, STATUS_CONT AS 'STATUS', NO_SEAL AS 'NO.SEAL' FROM t_spk_cont";
		// $proses = array('ENTRY'  => array('MODAL',"reference/customer/add", '0','','md-plus-circle','', 'menu'),
		// 								'UPDATE' => array('MODAL',"reference/customer/update", '1','','md-edit','', 'list'),
		// 				        'DELETE'  => array('DELETE',"execute/process/delete/customer", '1','','md-close-circle','', 'list'));
		$this->newtable->multiple_search(true);
		$this->newtable->show_chk(false);
		$this->newtable->show_menu($check);
		$this->newtable->show_search(true);
		$this->newtable->search(array(array('NAMA_CUST','NAMA CUSTOMER')));
		$this->newtable->action(site_url() . "/customer/tracking");
		if($check) $this->newtable->detail(array('DRILLDOWN',site_url()."/coarri/discharge/detail"));
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("ID"));
		$this->newtable->keys(array("ID"));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby("ID");
		$this->newtable->sortby("ASC");
		$this->newtable->set_formid("tbltrack");
		$this->newtable->set_divid("divtrack");
		$this->newtable->rowcount(10);
		$this->newtable->clear();
		$this->newtable->menu($proses);
		$tabel .= $this->newtable->generate($SQL);
		$arrdata = array("page_title" => $page_title, "title" => $title, "content" => $tabel);
		if($this->input->post("ajax")||$act == "post")
			return $tabel;
		else
			return $arrdata;
	}



	public function tracking($act, $id){
		$page_title = 'Tracking';
		$title ="";
		$usernya=$this->session->userdata('NM_LENGKAP');
		$npwpnya=$this->session->userdata('NPWP');
		$text = preg_replace("/[^a-zA-Z0-9]/", "", $npwpnya);
		$KD_GROUP=$this->session->userdata('KD_GROUP');
		//$this->newtable->breadcrumb('Planning', site_url(),'icon-home');
		$this->newtable->breadcrumb('Customer', 'javascript:void(0)','');
		$this->newtable->breadcrumb('Tracking', 'javascript:void(0)','');
		$check =(grant()=="W")?true:false;
			if($KD_GROUP=="SPA"){
				$SQL = "SELECT A.ID,A.NO_CONT AS 'NO. KONTAINER', A.UKR_CONT AS 'UKURAN KONTAINER',A.LOKASI,B.KETERANGAN AS 'STATUS', C.CONSIGNEE AS 'NAMA CUSTOMER'
				FROM t_spk_cont A
				INNER JOIN reff_status_spk B ON B.ID = A.STATUS_CONT
				INNER JOIN t_spk C ON C.ID = A.ID
				";
			}else{				
				$SQL = "SELECT A.ID,A.NO_CONT AS 'NO. KONTAINER', A.UKR_CONT AS 'UKURAN KONTAINER',A.LOKASI,B.KETERANGAN AS 'STATUS', C.CONSIGNEE AS 'NAMA CUSTOMER'
				FROM t_spk_cont A
				INNER JOIN reff_status_spk B ON B.ID = A.STATUS_CONT
				INNER JOIN t_spk C ON C.ID = A.ID
				WHERE C.NPWP IN ('$npwpnya','$text')";
			}
		

		$this->newtable->multiple_search(true);
		$this->newtable->show_chk(false);
		$this->newtable->show_menu($check);
		$this->newtable->show_search(true);
		$this->newtable->search(array(array('NO_CONT','NO. KONTAINER')));
		$this->newtable->action(site_url() . "/Customer/tracking");
		if($check) $this->newtable->detail(array('DRILLDOWN',"customer/tracking/detail/"));
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("ID"));
		$this->newtable->keys(array("NO. KONTAINER"));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby("ID");
		$this->newtable->sortby("ASC");
		$this->newtable->set_formid("tbltrack");
		$this->newtable->set_divid("divtbltrack");
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


	public function behandle1($act, $id){
		$page_title = 'Behandle';
		$page_title = 'INFO BILLING BEHANDLE';
		$title = "BILLING BEHANDLE";
		$this->newtable->breadcrumb('Billing', 'javascript:void(0)','');
		$this->newtable->breadcrumb('Behandle', 'javascript:void(0)','');
		$KD_NPWP = $this->session->userdata('NPWP');
		$check = (grant()=="W")?true:false;


		$SQL = "SELECT ID_REQ AS 'NO REQUEST',TGL_REQ AS 'TGL REQUEST', CASE WHEN JNS_KEGIATAN = '1' THEN 'BEHANDLE 1' WHEN JNS_KEGIATAN = '2' THEN 'BEHANDLE 2' END AS 'JENIS KEGIATAN',
				NO_DOK AS 'NO. DOKUMEN', NO_NOTA_BEHANDLE AS 'NO. NOTA BEHANDLE',CONCAT('<span class=\"label label-info\">Rp. ',FORMAT(TOTAL_JUMLAH,0),'</span>') AS 'TOTAL' FROM req_behandle_hdr WHERE NPWP = '$KD_NPWP' AND JNS_KEGIATAN = '1' OR JNS_KEGIATAN = '2'";
		if ($KD_NPWP == NULL) {
			$SQL = "SELECT ID_REQ AS 'NO REQUEST',CONCAT(NAMA_CUST,'<BR>',NPWP) AS 'CUSTOMER',TGL_REQ AS 'TGL REQUEST', NO_DOK AS 'NO. DOKUMEN',NM_KAPAL AS 'NAMA KAPAL', IFNULL(NO_NOTA_BEHANDLE, NULL) AS 'NO. NOTA BEHANDLE', CONCAT('<span class=\"label label-info\">Rp. ', FORMAT(TOTAL_JUMLAH,0),'</span>') AS 'TOTAL'
				FROM req_behandle_hdr WHERE JNS_KEGIATAN = '1'";
		}else{
			$SQL = "SELECT ID_REQ AS 'NO REQUEST',TGL_REQ AS 'TGL REQUEST',CASE WHEN JNS_KEGIATAN = '1' THEN 'BEHANDLE 1' WHEN JNS_KEGIATAN = '2' THEN 'BEHANDLE 2' END AS 'JENIS KEGIATAN', NO_DOK AS 'NO. DOKUMEN', NO_NOTA_BEHANDLE AS 'NO. NOTA BEHANDLE', CONCAT('<span class=\"label label-info\">Rp. ',FORMAT(TOTAL_JUMLAH,0),'</span>') AS 'TOTAL' FROM req_behandle_hdr WHERE NPWP = '$KD_NPWP' AND JNS_KEGIATAN = '1' OR JNS_KEGIATAN = '2'";
		}

		$proses = array('CETAK'  => array('PRINT',"billing/cetak_nota_behandle", '0','','md-print','','list'));
		$this->newtable->multiple_search(true);
		$this->newtable->show_chk(false);
		$this->newtable->show_menu($check);
		$this->newtable->show_search(true);
		$this->newtable->search(array(array('ID_REQ','NO REQUEST'),array('NO_DOK','NO. DOKUMEN'),array('NO_NOTA_BEHANDLE','NO. NOTA')));
		$this->newtable->action(site_url() . "/customer/behandle1");
		$this->newtable->tipe_proses('button');
		$this->newtable->keys(array("NO REQUEST"));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby("TGL_REQ");
		$this->newtable->sortby("DESC");
		$this->newtable->rowcount(10);
		$this->newtable->set_formid("tblbehandle");
		$this->newtable->set_divid("divtblbehandle");
		$this->newtable->clear();
		$this->newtable->menu($proses);
		$tabel .= $this->newtable->generate($SQL);
		$arrdata = array("page_title" => $page_title, "title" => $title, "content" => $tabel);
		if($this->input->post("ajax")||$act == "post")
			echo $tabel;
		else
			return $arrdata;
		}


	public function behandle2($act, $id){
		//print_r($_SESSION); die();
		$page_title = 'Behandle';
		$page_title = 'INFO BILLING BEHANDLE 2';
		$title = "BILLING BEHANDLE";
		$this->newtable->breadcrumb('Billing', 'javascript:void(0)','');
		$this->newtable->breadcrumb('Behandle', 'javascript:void(0)','');
		$KD_NPWP = $this->session->userdata('NPWP');
		$check = (grant()=="W")?true:false;
		$SQL = "SELECT ID_REQ AS 'NO REQUEST',TGL_REQ AS 'TGL REQUEST', NO_DOK AS 'NO. DOKUMEN', NO_NOTA_BEHANDLE AS 'NO. NOTA BEHANDLE', TOTAL_JUMLAH AS 'TOTAL' FROM req_behandle_hdr WHERE NPWP = '$KD_NPWP' AND JNS_KEGIATAN = '2'";

		if ($KD_NPWP == NULL) {
			$SQL = "SELECT ID_REQ AS 'NO REQUEST',TGL_REQ AS 'TGL REQUEST', NO_DOK AS 'NO. DOKUMEN', NO_NOTA_BEHANDLE AS 'NO. NOTA BEHANDLE', TOTAL_JUMLAH AS 'TOTAL' FROM req_behandle_hdr WHERE JNS_KEGIATAN = '2'";
		}else{
			$SQL = "SELECT ID_REQ AS 'NO REQUEST',TGL_REQ AS 'TGL REQUEST', NO_DOK AS 'NO. DOKUMEN', NO_NOTA_BEHANDLE AS 'NO. NOTA BEHANDLE', TOTAL_JUMLAH AS 'TOTAL' FROM req_behandle_hdr WHERE NPWP = '$KD_NPWP' AND JNS_KEGIATAN = '2'";
		}

		$proses = array('CETAK'  => array('PRINT',"billing/cetak_nota_behandle", '0','','md-print','','list'));
		$this->newtable->multiple_search(true);
		$this->newtable->show_chk(false);
		$this->newtable->show_menu($check);
		$this->newtable->show_search(true);
		$this->newtable->search(array(array('ID_REQ','NO REQUEST'),array('NO_DOK','NO. DOKUMEN'),array('NO_NOTA_BEHANDLE','NO. NOTA')));
		$this->newtable->action(site_url() . "/customer/behandle2");
		$this->newtable->tipe_proses('button');
		$this->newtable->keys(array("NO REQUEST"));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby("TGL_REQ");
		$this->newtable->sortby("DESC");
		$this->newtable->rowcount(10);
		$this->newtable->set_formid("tblbehandle");
		$this->newtable->set_divid("divtblbehandle");
		$this->newtable->clear();
		$this->newtable->menu($proses);
		$tabel .= $this->newtable->generate($SQL);
		$arrdata = array("page_title" => $page_title, "title" => $title, "content" => $tabel);
		if($this->input->post("ajax")||$act == "post")
			echo $tabel;
		else
			return $arrdata;
		}


	public function delivery($act, $id){
		$page_title = 'BILLING DELIVERY';
		$title ="BILLING DELIVERY";
		//$this->newtable->breadcrumb('Planning', site_url(),'icon-home');
		$this->newtable->breadcrumb('Billing', 'javascript:void(0)','');
		$this->newtable->breadcrumb('Delivery', 'javascript:void(0)','');
		$KD_NPWP = $this->session->userdata('NPWP');
		$check =(grant()=="W")?true:false;
		/*$SQL = "SELECT DISTINCT A.ID_REQ, A.JNS_DOK, A.NO_DOK, A.NO_VOY, 'CUSTOMER' AS 'CUSTOMER', B.NO_CONT, A.PAID_STATUS, A.BANK_ID
				FROM req_delivery_hdr A, req_delivery_dtl B
				WHERE  A.ID_REQ = B.ID_REQ";*/

		if ($KD_NPWP == NULL) {
			$SQL = "SELECT ID_REQ AS 'NO REQUEST',ID_REQ_OLD, TGL_REQ AS 'TGL. REQUEST',
				NO_DOK AS 'NO. DOKUMEN',NO_NOTA_DELIVERY AS 'NO. NOTA', TGL_NOTA AS 'TGL. NOTA', TOTAL
				FROM req_delivery_hdr WHERE ID_REQ_OLD IS NULL";
		}else{
			$SQL = "SELECT ID_REQ AS 'NO REQUEST',ID_REQ_OLD, TGL_REQ AS 'TGL. REQUEST',
				NO_DOK AS 'NO. DOKUMEN',NO_NOTA_DELIVERY AS 'NO. NOTA', TGL_NOTA AS 'TGL. NOTA', TOTAL
				FROM req_delivery_hdr WHERE ID_REQ_OLD IS NULL AND NPWP = '$KD_NPWP'";
		}

		$proses = array('CETAK' => array('PRINT',"billing/cetak_nota_del", '1','','md-print','', 'list'));
		$this->newtable->multiple_search(true);
		$this->newtable->show_chk($check);
		$this->newtable->show_menu($check);
		$this->newtable->show_search(true);
		$this->newtable->search(array(array('ID_REQ','ID REQUEST'),array('NO_DOK','NO. DOKUMEN')));
		$this->newtable->action(site_url() . "/billing/delivery");
		//if($check) $this->newtable->detail(array('POPUP',"billing/behandle/behandle_detail"));
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("ID_REQ_OLD"));
		$this->newtable->keys(array("NO REQUEST"));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby(1);
		$this->newtable->sortby("ASC");
		$this->newtable->set_formid("tbldelivery");
		$this->newtable->set_divid("divtbldelivery");
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


	public function get_data($act, $id){
		if($act == 'operation'){
			$arrid = explode("~",$id);
			$id1=$arrid[0];
			$id2=$arrid[1];
			//echo $id1.' '.$id2; die();
 			$sql = $this->db->query("SELECT * FROM t_operation WHERE NO_CONT = '$id'");
			return $sql->result();
		}
	}
	//
		public function gate_pass_delivery($act, $id){
			$page_title = "GATE PASS DELIVERY";
			$title = "GATE PASS DELIVERY";
			$usernya=$this->session->userdata('NM_LENGKAP');
			$npwpnya=$this->session->userdata('NPWP');
			$text = preg_replace("/[^a-zA-Z0-9]/", "", $npwpnya);
			$KD_GROUP=$this->session->userdata('KD_GROUP');
			$this->newtable->breadcrumb('Dashboard', site_url(),'icon-home');
			$this->newtable->breadcrumb('Customer', 'javascript:void(0)','');
			$this->newtable->breadcrumb('Gate Pass Delivery', 'javascript:void(0)','');
			$check = (grant()=="W")?true:false;
			if($KD_GROUP=="SPA"){
				$SQL = "SELECT ID,NO_CONT AS 'KONTAINER', JNS_DOK AS 'JENIS DOKUMEN',NM_KAPAL AS 'NAMA KAPAL', NAMA_CUST AS 'CUSTOMER', WK_REK AS 'WAKTU REKAM'
				FROM t_gatepass
				WHERE JNS_KEGIATAN = '3' AND STATUS != 'EXPIRED' AND STATUS ='WAITING'";
			}else{				
				$SQL = "SELECT ID,NO_CONT AS 'KONTAINER', JNS_DOK AS 'JENIS DOKUMEN',NM_KAPAL AS 'NAMA KAPAL', NAMA_CUST AS 'CUSTOMER', WK_REK AS 'WAKTU REKAM'
				FROM t_gatepass
				WHERE JNS_KEGIATAN = '3' AND STATUS != 'EXPIRED' AND STATUS ='WAITING'  AND NPWP IN ('$npwpnya','$text') ";
			}
					
			$proses = array('CETAK' => array('PRINT',"planning/cetak_gatepass_delivery", '1','','md-print','', 'list'),
			/*'ADD' => array('MODAL',"planning/gate_pass_delivery/add_gp_del", '','','md-plus-circle','', 'menu'),*/
							'HISTORY' => array('MODAL',"planning/gate_pass_delivery/history", '1', '', 'md-watch','','list'));
						  //'ASSOCIATE'  => array('MODAL',"planning/gate_pass_delivery/associate", '1','','md-plus-circle','', 'list')

			$this->newtable->multiple_search(true);
			$this->newtable->show_chk(false);
			$this->newtable->show_menu($check);
			$this->newtable->show_search(true);
			$this->newtable->search(array(array('NO_CONT','NO. KONTAINER'),array('NO_DOK','NO. DOKUMEN')));
			$this->newtable->action(site_url() . "/customer/reprint");
			//if($check) $this->newtable->detail(array('POPUP',"planning/shipment/detail"));
			$this->newtable->tipe_proses('button');
			$this->newtable->hiddens(array("ID"));
			$this->newtable->keys(array("ID"));
			$this->newtable->cidb($this->db);
			$this->newtable->orderby('ID DESC');
			$this->newtable->sortby("");
			$this->newtable->set_divid("divtblkapallist");
			$this->newtable->set_formid("tblkapallist");
			$this->newtable->rowcount(10);
			$this->newtable->clear();
			$this->newtable->menu($proses);
			$tabel .= $this->newtable->generate($SQL);
			$arrdata = array("page_title" => $page_title, "title" => $title, "content" => $tabel);
			if($this->input->post("ajax")||$act == "post")
				return $tabel;
			else
				return $arrdata;
		}
	//




}

?>
