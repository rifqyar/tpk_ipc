<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class M_monitoring extends CI_Model {

	public function __construct(){
		parent::__construct();

	}

	public function list_kontainer($act, $id){
		if($this->session->userdata('KD_GROUP')!="PUBLIC"){
			$page_title = "MONITORING KONTAINER";
			$title = "MONITORING KONTAINER";
			$this->newtable->breadcrumb('Dashboard', site_url(),'icon-home');
			$this->newtable->breadcrumb('Monitoring', 'javascript:void(0)','');
			$this->newtable->breadcrumb('Kontainer', 'javascript:void(0)','');
			//$check = (grant()=="W")?true:false;
			$SQL = "SELECT A.ID AS 'ID',CONCAT('',(B.NO_CONT),'<BR>',(B.UKR_CONT)) AS 'KONTAINER', CASE WHEN LEFT(B.LOKASI,3) = 'CIC' THEN B.LOKASI ELSE CONCAT(B.LOKASI,'0', TIER) END AS 'LOKASI', B.NO_CONT AS 'KON', A.NO_SPK AS 'NSPK',
				     CONCAT('',(A.NO_SPK),'<BR>',(A.TGL_SPK)) AS 'SPK',
				     C.KETERANGAN AS 'STATUS' FROM t_spk A, t_spk_cont B
				     INNER JOIN reff_status_spk C ON C.ID = B.STATUS_CONT WHERE A.ID = B.ID
				     ";
			$this->newtable->multiple_search(true);
			$this->newtable->show_chk(false);
			$this->newtable->show_menu(false);
			$this->newtable->show_search(true);
			$this->newtable->show_menu($check);
			$this->newtable->search(array(array('NO_SPK','NO. SPK'),array('NO_CONT','NO. KONTAINER')));
			$this->newtable->action(site_url() . "/monitoring/kontainer");
			$this->newtable->detail(array('DRILLDOWN',"monitoring/kontainer/detail/"));
			$this->newtable->tipe_proses('button');
			$this->newtable->hiddens(array("ID","KON","NSPK"));
			$this->newtable->keys(array("NSPK","KON"));
			$this->newtable->cidb($this->db);
			$this->newtable->orderby("ID");
			$this->newtable->sortby("DESC");
			$this->newtable->set_formid("tblkontainer");
			$this->newtable->set_divid("divkontainer"); 
			$this->newtable->rowcount(10);
			$this->newtable->clear();
			$this->newtable->menu($proses);
			$tabel .= $this->newtable->generate($SQL);
			$arrdata = array("page_title" => $page_title, "title" => $title, "content" => $tabel);
			if($this->input->post("ajax")||$act == "post")
				echo $tabel;
			else
				return $arrdata;
		}else{
			$page_title = "MONITORING KONTAINER";
			$title = "MONITORING KONTAINER";
			$this->newtable->breadcrumb('Dashboard', site_url(),'icon-home');
			$this->newtable->breadcrumb('Monitoring', 'javascript:void(0)','');
			$this->newtable->breadcrumb('Kontainer', 'javascript:void(0)','');
			//$check = (grant()=="W")?true:false;
			$SQL = "SELECT A.ID AS 'ID',CONCAT('',(B.NO_CONT),'<BR>',(B.UKR_CONT)) AS 'KONTAINER', CASE WHEN LEFT(B.LOKASI,3) = 'CIC' THEN B.LOKASI ELSE CONCAT(B.LOKASI,'0', TIER) END AS 'LOKASI', B.NO_CONT AS 'KON', A.NO_SPK AS 'NSPK',
				     CONCAT('',(A.NO_SPK),'<BR>',(A.TGL_SPK)) AS 'SPK',
				     C.KETERANGAN AS 'STATUS' FROM t_spk A, t_spk_cont B
				     INNER JOIN reff_status_spk C ON C.ID = B.STATUS_CONT WHERE A.ID = B.ID
				     ";
			$this->newtable->multiple_search(true);
			$this->newtable->show_chk(false);
			$this->newtable->show_menu(false);
			$this->newtable->show_search(true);
			$this->newtable->show_menu($check);
			$this->newtable->search(array(array('NO_SPK','NO. SPK'),array('NO_CONT','NO. KONTAINER')));
			$this->newtable->action(site_url() . "/monitoring/kontainer");
			// $this->newtable->detail(array('DRILLDOWN',"monitoring/kontainer/detail/"));
			$this->newtable->tipe_proses('button');
			$this->newtable->hiddens(array("ID","KON","NSPK"));
			$this->newtable->keys(array("NSPK","KON"));
			$this->newtable->cidb($this->db);
			$this->newtable->orderby("ID");
			$this->newtable->sortby("DESC");
			$this->newtable->set_formid("tblkontainer");
			$this->newtable->set_divid("divkontainer"); 
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
	}
	
	public function list_delivery($act, $id){
		$page_title = "MONITORING DELIVERY";
		$title = "MONITORING DELIVERY";
		$this->newtable->breadcrumb('Dashboard', site_url(),'icon-home');
		$this->newtable->breadcrumb('Monitoring', 'javascript:void(0)','');
		$this->newtable->breadcrumb('Delivery', 'javascript:void(0)','');
		$check = (grant()=="W")?true:false;
		//
		$SQL = "SELECT A.ID,A.NO_CONT AS 'NO. KONTAINER',A.NM_KAPAL AS 'VESSEL NAME', A.NO_VOY AS 'VOYAGE',A.UKR_CONT AS 'SIZE',E.KD_CONT_TIPE AS 'TYPE', B.LOKASI AS 'LOKASI', A.WK_REK AS 'TERBIT GATE PASS DELIVERY',A.EXPIRED_DATE AS 'PAIDTHRU',A.JNS_DOK AS 'JENIS DOKUMEN',A.NAMA_CUST AS 'NAMA CUSTOMER'
				FROM t_gatepass A
				LEFT JOIN t_spk_cont B ON A.NO_CONT = B.NO_CONT
				LEFT JOIN t_spk C ON A.NO_DOK = C.NO_DOK AND A.TGL_DOK = C.TGL_DOK
				LEFT JOIN t_permit_hdr D ON D.NO_DOK_INOUT = A.NO_DOK
				LEFT JOIN t_cocostscont E ON E.NO_CONT = A.NO_CONT
				WHERE B.STATUS_CONT != '900' AND A.JNS_KEGIATAN = '3'";
		$this->newtable->multiple_search(true);
		$this->newtable->show_chk(false);
		$this->newtable->show_menu(false);
		$this->newtable->show_search(true);
		$proses = array('EXPORT GATEOUT DELIVERY' => array('EXCEL',"process/excel/delivery/".$act, '0','','md-file-text','','menu'));
		$this->newtable->show_menu($check);
		$this->newtable->search(array(array('A.NO_CONT','NO. KONTAINER'),array('A.WK_REK','TERBIT GATEPASS','DATERANGE')));
		$this->newtable->action(site_url() . "/monitoring/delivery");
		//$this->newtable->detail(array('DRILLDOWN',"monitoring/kontainer/detail/"));
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("ID"));
		//$this->newtable->keys(array("NSPK","KON"));
		$this->newtable->cidb($this->db);
		$this->newtable->groupby(array("A.NO_DOK"));
		$this->newtable->orderby("WK_REK");
		$this->newtable->sortby("DESC");
		$this->newtable->set_formid("tblmondel");
		$this->newtable->set_divid("divmondel");
		$this->newtable->rowcount(100);
		$this->newtable->clear();
		$this->newtable->menu($proses);
		$tabel .= $this->newtable->generate($SQL);
		$arrdata = array("page_title" => $page_title, "title" => $title, "content" => $tabel);
		if($this->input->post("ajax")||$act == "post")
			echo $tabel;
		else
			return $arrdata;
	}

	public function list_jobslip($act, $id){
		$page_title = "MONITORING JOB SLIP";
		$title = "MONITORING JOB SLIP";
		$this->newtable->breadcrumb('Dashboard', site_url(),'icon-home');
		$this->newtable->breadcrumb('Monitoring', 'javascript:void(0)','');
		$this->newtable->breadcrumb('Job Slip', 'javascript:void(0)','');
		$check = (grant()=="W")?true:false;
		/*$SQL = "SELECT ID_JOB_SLIP AS ID, JNS_JOB_SLIP AS 'JENIS JOB SLIP', NO_SPK AS 'NO. SPK', TGL_SPK AS 'TGL. SPK',NO_CONT AS 'NO. KONT', NO_GATEPASS AS 'NO. GATEPASS', TGL_GATEPASS AS 'TGL. GATEPASS', ROOM_AWAL AS 'ROOM AWAL', LOKASI_AWAL AS 'LOKASI AWAL',
			ROOM_AKHIR AS 'ROOM AKHIR', LOKASI_AKHIR AS 'LOKASI AKHIR'
			FROM t_job_slip WHERE LOKASI_AKHIR IS NOT NULL AND STATUS IS NULL";*/
		$SQL = "SELECT A.ID_JOB_SLIP AS ID, CONCAT(A.JNS_JOB_SLIP,'<BR>', IFNULL(A.JENIS,'-')) AS 'JENIS', CONCAT(A.NO_SPK,'<BR>', IFNULL(A.TGL_SPK,'-')) AS 'SPK', A.NO_CONT AS 'NO. KONTAINER', CONCAT(A.NO_GATEPASS,'<BR>', IFNULL(A.TGL_GATEPASS,'-')) AS 'GATEPASS', 
				CASE WHEN LEFT(A.LOKASI_AWAL,3) = 'CIC' THEN LOKASI_AWAL WHEN A.LOKASI_AWAL IS NULL THEN 'TERMINAL' ELSE CONCAT(A.LOKASI_AWAL,'0', A.TIER_AWAL) END AS 'LOKASI AWAL', 
				CASE WHEN LEFT(A.LOKASI_AKHIR,3) = 'CIC' THEN LOKASI_AKHIR WHEN A.LOKASI_AKHIR IS NULL THEN '-' ELSE CONCAT(A.LOKASI_AKHIR,'0', A.TIER_AKHIR) END AS 'LOKASI AKHIR',
				CONCAT('<span style=\"font-weight:bold\">',B.`STATUS`,'</SPAN>','<BR>', IFNULL(B.KETERANGAN,'-')) AS 'STATUS', A.WK_STATUS AS 'WAKTU STATUS', A.OPERATOR 
				FROM t_job_slip A
				LEFT JOIN reff_status_jobslip B ON A.KD_STATUS = B.ID
				WHERE DATE_FORMAT(A.WK_STATUS,'%Y-%m-%d') = '2017-06-11'";
		$this->newtable->multiple_search(true);
		$this->newtable->show_chk(false);
		$this->newtable->show_menu($check);
		$this->newtable->show_search(true);
		$this->newtable->search(array(array('A.JNS_JOB_SLIP','JENIS JOB SLIP'),array('A.NO_SPK','NO. SPK'),array('A.NO_CONT','NO. KONTAINER')));
		$this->newtable->action(site_url() . "/monitoring/jobslip");
		if($check) $this->newtable->detail(array('DRILLDOWN',"/monitoring/jobslip/detail"));
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("ID"));
		$this->newtable->keys(array("ID"));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby("1");
		$this->newtable->sortby("ASC");
		$this->newtable->set_formid("tblmonitoring");
		$this->newtable->set_divid("divmonitoring");
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
	
	function list_karantina(){
		$page_title = "MONITORING KARANTINA";
		$title = "MONITORING KARANTINA";
		$this->newtable->breadcrumb('Dashboard', site_url(),'icon-home');
		$this->newtable->breadcrumb('Monitoring', 'javascript:void(0)','');
		$this->newtable->breadcrumb('KARANTINA', 'javascript:void(0)','');
		$check = (grant()=="W")?true:false;
		/*$SQL = "SELECT B.ID_IJIN AS ID_IJIN,B.ANGKUTNAMA_TPS AS 'NAMA KAPAL',B.ANGKUTNO_TPS AS 'NO. VOY',C.NO_CONT AS 'NO. CONT',C.UKURAN,CASE WHEN C.NO_TPFT IS NOT NULL THEN 'N' ELSE 'Y' END AS 'SAMPLING',A.NO_IJIN AS 'NO. IJIN',A.TGL_IJIN AS 'TGL. IJIN', D.WK_IN AS 'STACKING'
				FROM t_lic_hdr A
				LEFT JOIN t_ppk_hdr B ON A.ID_IJIN = B.ID_IJIN
				LEFT JOIN t_ppk_cont C ON B.ID_IJIN = C.ID_IJIN
				LEFT JOIN t_cocostscont D ON C.NO_CONT = D.NO_CONT
				WHERE DATE_FORMAT(A.TGL_IJIN, '%Y') >= '2017' AND C.NO_CONT IS NOT NULL";*/
		$SQL = "SELECT A.NM_KAPAL AS SHIP_NAME, A.NO_VOYAGE AS VOYAGE_NO, A.NO_CONT AS CNTR_ID, C.UKURAN AS SIZE, CASE IFNULL(LENGTH(C.NO_TPFT),0) WHEN '0' THEN 'N' ELSE 'Y' END AS SAMPLING, A.KD_GUDANG_PERIKSA AS AREA, /*NULL AS ETB, */
				 B.NO_IJIN, DATE_FORMAT(B.TGL_IJIN,'%d/%m/%Y') AS TGL_IJIN, DATE_FORMAT(C.TGL_TPFT,'%d/%m/%Y') AS TGL_TPFT, DATE_FORMAT(B.WK_REKAM,'%d/%m/%Y %H:%i:%s') AS RECEIVED,
				 (
				SELECT DATE_FORMAT(TGL_STATUS,'%d/%m/%Y %H:%i:%s')
				FROM t_ppk_cont_status
				WHERE ID_IJIN = A.ID_IJIN_PERMOHONAN AND NO_CONT = A.NO_CONT AND KD_STATUS = '1'
				LIMIT 0,1) AS DISCHARGE, NULL AS SIAP_PERIKSA, DATE_FORMAT(D.WK_REKAM,'%d/%m/%Y %H:%i:%s') AS RELEASED,
				 (
				SELECT DATE_FORMAT(TGL_STATUS,'%d/%m/%Y %H:%i:%s')
				FROM t_ppk_cont_status
				WHERE ID_IJIN = A.ID_IJIN_PERMOHONAN AND NO_CONT = A.NO_CONT AND KD_STATUS = '4'
				LIMIT 0,1) AS GATE_OUT,
				 /*NULL AS DESCRIPTION,*/ F.NAMA AS RISK, NULL AS INSPEKSI, NULL AS NO_INSPEKSI,
				 (
				SELECT NAMA
				FROM t_ppk_petugas
				WHERE ID_IJIN = A.ID_IJIN_PERMOHONAN
				LIMIT 0,1) AS PETUGAS
				FROM t_codeco A
				INNER JOIN t_lic_hdr B ON A.ID_IJIN_PERMOHONAN = B.ID_IJIN
				INNER JOIN t_ppk_cont C ON B.ID_IJIN = C.ID_IJIN AND A.NO_CONT = C.NO_CONT
				LEFT JOIN t_lic_hdr D ON A.ID_IJIN_PENYELESAIAN = D.ID_IJIN
				INNER JOIN reff_ga E ON B.ID_GA = E.ID
				INNER JOIN reff_status_cont F ON C.KD_STATUS = F.ID
				WHERE C.KD_STATUS NOT IN ('9') AND C.NO_TPFT IS NOT NULL AND DATE_FORMAT(B.WK_REKAM,'%Y') = '2017'";
		$this->newtable->multiple_search(true);
		$this->newtable->show_chk(false);
		$this->newtable->show_menu($check);
		$this->newtable->show_search(true);
		$this->newtable->search(array(array('A.NO_CONT','NO. CONT'),array('B.TGL_IJIN','TANGGAL IJIN','DATERANGE')));
		$this->newtable->action(site_url() . "/monitoring/karantina");
		//if($check) $this->newtable->detail(array('POPUP',"/monitoring/jobslip/detail"));
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("ID_IJIN"));
		$this->newtable->keys(array(""));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby("B.TGL_IJIN ASC");
		$this->newtable->sortby("");
		$this->newtable->set_formid("tblmonitoringkarantina");
		$this->newtable->set_divid("divmonitoringkarantina");
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

	function list_penarikan(){
		$page_title = "MONITORING PENARIKAN";
		$title = "MONITORING PENARIKAN";
		$this->newtable->breadcrumb('Dashboard', site_url(),'icon-home');
		$this->newtable->breadcrumb('Monitoring', 'javascript:void(0)','');
		$this->newtable->breadcrumb('PENARIKAN', 'javascript:void(0)','');
		$check = (grant()=="W")?true:false;
		$SQL = "SELECT B.NO_SPK AS 'NO SPK', A.NO_CONT AS 'NO CONTAINER',A.UKR_CONT AS 'SIZE',B.WK_REQ AS 'TERBIT SPK',C.NAMA AS 'JENIS DOKUMEN', D.W_PICKUP AS 'WAKTU PICKUP',A.ID_FLAT AS 'TID', F.W_BEHANDLE AS 'WAKTU BEHANDLE IN', 
			CASE WHEN A.STATUS_CONT IN('450','460','500','510','520','530','540') 
			THEN CONCAT('<span class=\"label label-success\">',
			 DATEDIFF(DATE_FORMAT(F.W_BEHANDLE,'%Y-%m-%d'), DATE_FORMAT(B.WK_REQ,'%Y-%m-%d')),' HARI</span>/','<br><span class=\"label label-success\">',TIMEDIFF(TIMESTAMP(F.W_BEHANDLE,'%Y-%m-%d, %hh:%mm:%ss'), TIMESTAMP(B.WK_REQ,'%Y-%m-%d, %hh:%mm:%ss')),' JAM</span>') 
			 ELSE '-' END AS 'LAMA PENARIKAN', D.W_PICKUP AS 'WAKTU PICK UP', B.CONSIGNEE AS 'CUSTOMER NAME', 
			 CASE WHEN A.STATUS_CONT IN('450','460','500','510','520','530','540') 
			 THEN '<span class=\"label label-warning\">ON COMMON AREA</span>' WHEN A.STATUS_CONT = '200' THEN '<span class=\"label label-warning\"style=\"background: yellow\"><font color=\"black\">ON PROCESS</font></span>' ELSE '<span class=\"label label-success\">ON TERMINAL</span>' END AS 'STATUS PENARIKAN'
			FROM t_spk_cont A
			LEFT JOIN t_op_behandlein F ON F.NO_CONT = A.NO_CONT
			INNER JOIN t_spk B ON A.id = B.id
			INNER JOIN reff_kode_dok_bc C ON C.ID = B.JNS_DOK
			LEFT JOIN t_op_pickup D ON B.NO_SPK = D.NO_SPK
			WHERE A.STATUS_CONT IN ('50','000','100','200','300','400','450','460','500','510','520','530','540')";
		$this->newtable->multiple_search(true);
		$this->newtable->show_chk(false);
		$this->newtable->show_menu($check);
		$this->newtable->show_search(true);
		$arr_sts = array(""=>"",""=>"ON TERMINAL","450"=>"ON COMMON AREA");
		$this->newtable->search(array(array('A.STATUS_CONT','STATUS PENARIKAN','OPTION',$arr_sts),array('B.WK_REQ','TANGGAL REQUEST','DATERANGE')));
		$this->newtable->action(site_url() . "/monitoring/penarikan");
		//if($check) $this->newtable->detail(array('POPUP',"/monitoring/jobslip/detail"));
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("WAKTU PICK UP"));
		$this->newtable->keys(array(""));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby("F.W_BEHANDLE DESC");
		$this->newtable->sortby("");
		$this->newtable->set_formid("tblmonitoringpenarikan");
		$this->newtable->set_divid("divmonitoringpenarikan");
		$this->newtable->rowcount(1000);
		$this->newtable->clear();
		$this->newtable->menu($proses);
		$tabel .= $this->newtable->generate($SQL);
		$arrdata = array("page_title" => $page_title, "title" => $title, "content" => $tabel);
		if($this->input->post("ajax")||$act == "post")
			return $tabel;
		else
			return $arrdata;
	}

	function list_longroom(){
		$page_title = "MONITORING LONGROOM";
		$title = "MONITORING LONGROOM";
		$this->newtable->breadcrumb('Dashboard', site_url(),'icon-home');
		$this->newtable->breadcrumb('Monitoring', 'javascript:void(0)','');
		$this->newtable->breadcrumb('LONGROOM', 'javascript:void(0)','');
		$check = (grant()=="W")?true:false;
		$SQL = "SELECT A.NO_SPK AS 'NO SPK',A.NO_CONT AS 'NO CONTAINER',A.UKR_CONT AS 'SIZE','TGL. ACTIVE' AS 'REQUEST LONGROOM',CASE WHEN A.JNS_DOK != '19' THEN CONCAT('<span class=\"label label-danger\">',A.JNS_DOK,'</span>') ELSE CONCAT('<span class=\"label label-success\">',A.JNS_DOK,'</span>') END AS 'JENIS DOKUMEN',B.LOKASI, A.JNS_KEGIATAN AS KETERANGAN,C.CONSIGNEE AS 'CUSTOMER NAME',  E.KETERANGAN AS 'STATUS'
			FROM t_gatepass A
			INNER JOIN t_spk_cont B ON B.NO_CONT = A.NO_CONT
			INNER JOIN t_spk C ON C.NO_SPK = A.NO_SPK
			LEFT JOIN t_op_inspection D ON D.NO_CONT = A.NO_CONT AND D.NO_DOK = A.NO_DOK AND D.TGL_DOK = A.TGL_DOK
			left JOIN reff_status_spk E ON B.STATUS_CONT = E.ID
			WHERE A.JNS_KEGIATAN IN ('1','2')";
		$this->newtable->multiple_search(false);
		$this->newtable->show_chk(false);
		$this->newtable->show_menu($check);
		$this->newtable->show_search(false);
		/*$arr_sts = array(""=>"",""=>"ON TERMINAL","400"=>"ON COMMON AREA");*/
		$this->newtable->search("");
		$this->newtable->action(site_url() . "/monitoring/longroom");
		//if($check) $this->newtable->detail(array('POPUP',"/monitoring/jobslip/detail"));
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array(""));
		$this->newtable->keys(array(""));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby("1");
		$this->newtable->sortby("DESC");
		$this->newtable->set_formid("tblmonitoringlongroom");
		$this->newtable->set_divid("divmonitoringlongroom");
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
	public function get_reqbehandle1($id){
		$arrid = explode("~",$id);
		$id1=$arrid[0];
		$id2=$arrid[1];
		$sql = $this->db->query(" 
			SELECT b.NO_SPK, b.TGL_SPK, a.WK_REK as 'GATEPASSBEHANDLE1', c.WK_REQ, e.NAMA
			FROM t_gatepass a
			INNER JOIN hist_print d ON d.ID_HANDLE=a.ID
			INNER JOIN reff_user e ON d.USER_PRINTS=e.ID
			inner join t_spk b on a.NO_DOK = b.NO_DOK and a.TGL_DOK = b.TGL_DOK 
			inner join t_request c on a.NO_DOK=c.NO_DOK 
			WHERE a.NO_CONT='$id2' AND b.NO_SPK = '$id1'
		");
		return $sql->row_array();
	}

	public function get_reqbehandle1New($id){
		$arrid = explode("~",$id);
		$id1=$arrid[0];
		$id2=$arrid[1];
		$sql = $this->db->query(" 
			SELECT A.WK_SEND,C.NO_SPK,C.WK_REQ,A.WK_FINISH,A.OPERATOR
			FROM t_request A
			INNER JOIN t_request_cont B ON A.ID = B.ID
			INNER JOIN t_spk C ON A.NO_DOK = C.NO_DOK
			WHERE B.NO_CONT=  '$id2' AND C.NO_SPK = '$id1'
		");
		return $sql->row_array();
	}
	
	public function get_terbitspk($id){
		$arrid = explode("~",$id);
		$id1=$arrid[0];
		$id2=$arrid[1];
		$sql = $this->db->query(" 
			SELECT COUNT(ID_HANDLE) AS JML, B.NAMA, A.ID_HANDLE, A.USER_PRINTS, A.TYPE_RPT,B.NAMA
			FROM hist_print A
			LEFT JOIN reff_user B ON A.USER_PRINTS = B.ID
			WHERE A.ID_HANDLE LIKE '%$id1%' AND TYPE_RPT = 'cetak_spk'
			GROUP BY USER_PRINTS 
		");
		return $sql->row_array();
	}
	
	public function get_terbitbehandle2($id){
		$arrid = explode("~",$id);
		$id1=$arrid[0];
		$id2=$arrid[1];
		$sql2 = $this->db->query("SELECT ID FROM t_gatepass WHERE NO_CONT='$id2' AND JNS_KEGIATAN='2'")->row_array();
		$kunci=$sql2['ID'];
		$sql = $this->db->query(" 
			SELECT COUNT(ID_HANDLE) AS JML, B.NAMA, A.ID_HANDLE, A.USER_PRINTS, A.TYPE_RPT,B.NAMA
			FROM hist_print A
			LEFT JOIN reff_user B ON A.USER_PRINTS = B.ID
			WHERE A.ID_HANDLE LIKE '%$kunci%' AND TYPE_RPT = 'cetak_gbe'
			GROUP BY USER_PRINTS 
		");
		return $sql->row_array();
	}
	
	public function get_reqbehandle2($id){
		$arrid = explode("~",$id);
		$id1=$arrid[0];
		$id2=$arrid[1];
		$sql = $this->db->query(" 
			SELECT JNS_DOK, NO_DOK, TGL_DOK, WK_REK
			FROM t_gatepass
			WHERE JNS_KEGIATAN = '2' AND NO_CONT='$id2'
		");
		return $sql->row_array();
	}
	
	public function get_pembehandle1($id){
		$arrid = explode("~",$id);
		$id1=$arrid[0];
		$id2=$arrid[1];
		$sql = $this->db->query(" 
			SELECT A.LOKASI, A.START_INSP , A.FINISH_INSP , A.NO_SEAL , B.LOKASI AS 'LOK', B.TIER, A.OPERATOR_START, A.OPERATOR_FINISH
			FROM t_op_inspection A
			LEFT JOIN reff_kode_dok_bc D ON A.JNS_DOK = D.ID
			INNER JOIN t_gatepass C ON A.NO_CONT = C.NO_CONT -- AND A.NO_DOK = C.NO_DOK
			INNER JOIN t_spk_cont B ON A.NO_CONT = B.NO_CONT
			WHERE A.JNS_KEGIATAN = '1' AND A.NO_CONT='$id2' AND A.NO_SPK='$id1'
			GROUP BY A.LOKASI");
		return $sql->row_array();
	}
	//edit
	public function get_pembehandle2($id){
		$arrid = explode("~",$id);
		$id1=$arrid[0];
		$id2=$arrid[1];
		$SQL = "SELECT A.LOKASI, A.START_INSP , A.FINISH_INSP , A.NO_SEAL, A.OPERATOR_START, A.OPERATOR_FINISH
				FROM t_op_inspection A
				LEFT JOIN reff_kode_dok_bc D ON A.JNS_DOK = D.ID
				INNER JOIN t_gatepass C ON A.NO_CONT = C.NO_CONT -- AND A.NO_DOK = C.NO_DOK
				WHERE A.JNS_KEGIATAN = '2' AND A.NO_CONT='$id2' AND A.NO_SPK='$id1' -- AND C.`STATUS` = 'WAITING'
				GROUP BY A.LOKASI";

		$result = $this->db->query($SQL);
		
		/*$sql = $this->db->query(" 
			SELECT A.LOKASI, A.START_INSP , A.FINISH_INSP , A.NO_SEAL, A.OPERATOR_START, A.OPERATOR_FINISH
			FROM t_op_inspection A
			LEFT JOIN reff_kode_dok_bc D ON A.JNS_DOK = D.ID
			INNER JOIN t_gatepass C ON A.NO_CONT = C.NO_CONT AND A.NO_DOK = C.NO_DOK AND -- D.NAMA = C.JNS_DOK
			WHERE C.JNS_KEGIATAN = '2' AND A.NO_CONT='$id2' AND A.NO_SPK='$id1'
		");*/
		return $result->row_array();
	}
	
	public function get_penarikan($id){
		$arrid = explode("~",$id);
		$id1=$arrid[0];
		$id2=$arrid[1];
		$sql = $this->db->query(" 
			SELECT a.wk_pickup AS 'pickup', c.ID_FLAT AS 'tid', a.WK_TERMINAL_IN , a.WK_TERMINAL_OUT, a.WK_IN AS 'behandlein', d.ROOM, e.KONDISI, d.NO_SEAL, d.ISO_CODE, d.OPERATOR, f.OPERATOR as 'oper'
			FROM t_operation a
			LEFT JOIN t_spk b ON a.NO_SPK = b.NO_SPK
			LEFT JOIN t_spk_cont c ON b.ID = c.ID
			LEFT JOIN t_op_behandlein d ON a.NO_SPK = d.NO_SPK
			LEFT JOIN t_op_pickup f ON a.NO_SPK = f.NO_SPK 
			LEFT JOIN reff_kondisi e ON d.KONDISI_CONT = e.ID
			WHERE d.NO_CONT='$id2' AND d.NO_SPK='$id1' AND a.WK_IN IS NOT NULL
		");
		return $sql->row_array();
	}

	public function get_penarikanGOT($id){
		$arrid = explode("~",$id);
		$id1=$arrid[0];
		$id2=$arrid[1];
		$sql = $this->db->query(" 
			SELECT a.WK_INOUT FROM t_cocostscont_new a LEFT JOIN t_spk_cont b ON a.NO_CONT = b.NO_CONT LEFT JOIN t_spk c ON b.ID = c.ID WHERE b.NO_CONT='$id2' AND a.DOK_INOUT ='4'
		");
		return $sql->row_array();
	}

	public function get_penarikanGIT($id){
		$arrid = explode("~",$id);
		$id1=$arrid[0];
		$id2=$arrid[1];
		$sql = $this->db->query(" 
			SELECT a.WK_INOUT FROM t_cocostscont_new a LEFT JOIN t_spk_cont b ON a.NO_CONT = b.NO_CONT LEFT JOIN t_spk c ON b.ID = c.ID WHERE b.NO_CONT='$id2' AND a.DOK_INOUT ='3'
		");
		return $sql->row_array();
	}
	
	public function get_delivery($id){
		$arrid = explode("~",$id);
		$id1=$arrid[0];
		$id2=$arrid[1];
		$SQL = "SELECT A.WK_TRUCKIN, A.OPERATOR_T, A.WK_CHASSIS, A.OPERATOR_O, A.WK_INSPECT, A.OPERATOR_I, A.WK_GATEOUT, A.OPERATOR_G, A.NO_SEAL, B.KONDISI
				FROM t_op_delivery A
				LEFT JOIN reff_kondisi B ON A.KONDISI_CONT = B.ID
				WHERE NO_CONT='$id2' AND A.NO_SPK='$id1'";
		$sql = $this->db->query($SQL);
		return $sql->row_array();
	}
	
	public function get_behandle1($id){
		$arrid = explode("~",$id);
		$NO_SPK = $arrid[0];
		$NO_CONT = $arrid[1];
		/*$SQL = "SELECT A.JNS_DOK, A.NO_DOK, A.TGL_DOK, A.ID_REQ, A.TGL_REQ, A.EXPIRED, B.NAMA_CUST, C.JNS_KEGIATAN
				FROM req_behandle_hdr A
				LEFT JOIN m_pelanggan B ON A.NPWP = B.NPWP
				LEFT JOIN req_behandle_dtl C ON A.ID_REQ = C.ID_REQ 
				WHERE C.NO_CONT='$NO_CONT' AND C.JNS_KEGIATAN = 1";*/
		$SQL = "SELECT E.NAMA, A.NO_DOK, A.TGL_DOK, A.ID_REQ, A.TGL_REQ, A.EXPIRED, B.NAMA_CUST, C.JNS_KEGIATAN, A.OPERATOR
				FROM req_behandle_hdr A
				LEFT JOIN m_pelanggan B ON A.NPWP = B.NPWP
				LEFT JOIN req_behandle_dtl C ON A.ID_REQ = C.ID_REQ
				INNER JOIN reff_kode_dok_bc E ON A.JNS_DOK = E.NAMA
				WHERE C.NO_CONT='$NO_CONT' AND C.JNS_KEGIATAN = 1";
		$sql = $this->db->query($SQL);
		return $sql->row_array();
	}
	
	public function get_behandle2($id){
		$arrid = explode("~",$id);
		$NO_SPK = $arrid[0];
		$NO_CONT = $arrid[1];
		$SQL = "SELECT A.JNS_DOK, A.NO_DOK, A.TGL_DOK, A.ID_REQ, A.TGL_REQ, A.EXPIRED, B.NAMA_CUST, C.JNS_KEGIATAN, A.OPERATOR
				FROM req_behandle_hdr A
				LEFT JOIN m_pelanggan B ON A.NPWP = B.NPWP
				LEFT JOIN req_behandle_dtl C ON A.ID_REQ = C.ID_REQ 
				WHERE C.NO_CONT='$NO_CONT' AND C.JNS_KEGIATAN = 2";
		$sql = $this->db->query($SQL);
		return $sql->row_array();
	}
	
	public function get_reqdelivery($id){
		$arrid = explode("~",$id);
		$id1=$arrid[0];
		$id2=$arrid[1];
		/*$SQL_OLD = " 
			select DISTINCT a.JNS_DOK, a.NO_DOK, a.TGL_DOK, a.ID_REQ, a.TGL_REQ, a.EXPIRED, b.NAMA_CUST
			from req_delivery_hdr a
			inner join m_pelanggan b on a.NPWP = b.NPWP
			inner join req_delivery_dtl c on a.ID_REQ = c.ID_REQ
			inner join t_spk d on a.NM_KAPAL = d.NM_KAPAL and a.NO_VOY = d.NO_VOY 
			WHERE NO_CONT='$id2' AND NO_SPK='$id1'
		";
		$SQL = "SELECT DISTINCT a.JNS_DOK, a.NO_DOK, a.TGL_DOK, a.ID_REQ, a.TGL_REQ, a.EXPIRED, b.NAMA_CUST
				FROM req_delivery_hdr a
				INNER JOIN m_pelanggan b ON a.NPWP = b.NPWP
				INNER JOIN req_delivery_dtl c ON a.ID_REQ = c.ID_REQ
				WHERE c.NO_CONT='$id2'";*/
		$SQL = "SELECT DISTINCT a.JNS_DOK, a.NO_DOK, a.TGL_DOK, a.ID_REQ, a.TGL_REQ, a.EXPIRED, b.CONSIGNEE AS NAMA_CUST,a.OPERATOR
				FROM req_delivery_hdr a
				INNER JOIN t_permit_hdr b ON a.NO_DOK = b.NO_DOK_INOUT -- AND a.NPWP=b.ID_CONSIGNEE
				INNER JOIN req_delivery_dtl c ON a.ID_REQ = c.ID_REQ
				WHERE c.NO_CONT='$id2'";
		//echo $SQL;
		$RESULT = $this->db->query($SQL);
		return $RESULT->row_array();
	}
	
	public function get_delivext($id){
		$arrid = explode("~",$id);
		$id1=$arrid[0];
		$id2=$arrid[1];
		$sql = $this->db->query(" 
			select a.ID_REQ, a.TGL_REQ, a.EXPIRED, b.NAMA_CUST,a.OPERATOR
			from req_delivery_hdr a
			inner join m_pelanggan b on a.NPWP = b.NPWP
			inner join req_delivery_dtl c on a.ID_REQ = c.ID_REQ
			inner join t_spk d on a.NM_KAPAL = d.NM_KAPAL and a.NO_VOY = d.NO_VOY
			WHERE LEFT(a.ID_REQ,3) = 'EXT'
			AND c.NO_CONT='$id2' AND d.NO_SPK='$id1'
		");
		return $sql->row_array();
	}

	public function get_data($act, $id){
		$func = get_instance();
        $func->load->model("m_main", "main", true);
		if($act == 'operation'){
			$arrid = explode("~",$id);
			$id1=$arrid[0];
			$id2=$arrid[1];
			$getJnsDok = "SELECT JNS_DOK FROM t_spk WHERE NO_SPK = '$id1'";
			$restultDok = $this->db->query($getJnsDok)->result_array();
			$jns_dokumen = $restultDok[0]['JNS_DOK'];
			if($jns_dokumen == 83){
				$data = "SELECT B.NO_CONT AS 'KONTAINER', F.CALL_SIGN, F.NM_ANGKUT AS 'NM_KAPAL', F.NO_VOY_FLIGHT AS 'NO_VOY', E.JNS_CONT, E.UK_CONT AS 'UKR_CONT', E.ISO_CODE, E.KD_CONT_TIPE, D.IMO, F.TGL_TIBA, E.WK_IN, I.NAMA, C.NO_DOK AS 'DOKUMEN', C.TGL_DOK  AS 'TANGGAL', C.CONSIGNEE, E.WK_OUT
			 			FROM t_ppk_hdr A
			 			INNER JOIN t_ppk_cont B ON A.ID_IJIN = B.ID_IJIN
			 			INNER JOIN t_request C ON A.NO_RESPON = C.NO_DOK
			 			INNER JOIN t_request_cont D ON C.ID = D.ID AND B.NO_CONT = D.NO_CONT
			 			INNER JOIN t_cocostscont E ON B.NO_CONT = E.NO_CONT AND D.NO_CONT = E.NO_CONT
			 			INNER JOIN t_cocostshdr F ON E.ID = F.ID -- AND A.ANGKUTNAMA_TPS = F.NM_ANGKUT AND A.ANGKUTNO_TPS = F.NO_VOY_FLIGHT
			 			INNER JOIN t_spk G ON A.NO_RESPON = G.NO_DOK 
			 			INNER JOIN t_spk_cont H ON G.ID = H.ID AND B.NO_CONT = H.NO_CONT
			 			INNER JOIN reff_kode_dok_bc I ON C.JNS_DOK = I.ID
			 			WHERE G.NO_SPK ='$id1' AND B.NO_CONT = '$id2'
			 			GROUP BY G.NO_SPK";
			}else{
				$data = "SELECT B.NO_CONT AS 'KONTAINER', F.CALL_SIGN, F.NM_ANGKUT AS 'NM_KAPAL', F.NO_VOY_FLIGHT AS 'NO_VOY', E.JNS_CONT, E.UK_CONT AS 'UKR_CONT',E.ISO_CODE, E.KD_CONT_TIPE, D.IMO, F.TGL_TIBA, E.WK_IN, I.NAMA, C.NO_DOK AS 'DOKUMEN', C.TGL_DOK  AS 'TANGGAL', C.CONSIGNEE, E.WK_OUT
			 			FROM t_permit_hdr A
			 			INNER JOIN t_permit_cont B ON A.ID = B.ID
			 			INNER JOIN t_request C ON A.NO_DAFTAR_PABEAN = C.NO_DOK
			 			INNER JOIN t_request_cont D ON C.ID = D.ID AND B.NO_CONT = D.NO_CONT
			 			INNER JOIN t_cocostscont E ON B.NO_CONT = E.NO_CONT AND D.NO_CONT = E.NO_CONT
			 			INNER JOIN t_cocostshdr F ON E.ID = F.ID -- AND A.ANGKUTNAMA_TPS = F.NM_ANGKUT AND A.ANGKUTNO_TPS = F.NO_VOY_FLIGHT
			 			INNER JOIN t_spk G ON A.NO_DAFTAR_PABEAN = G.NO_DOK 
			 			INNER JOIN t_spk_cont H ON G.ID = H.ID AND B.NO_CONT = H.NO_CONT
			 			INNER JOIN reff_kode_dok_bc I ON C.JNS_DOK = I.ID
			 			WHERE G.NO_SPK ='$id1' AND B.NO_CONT = '$id2'
			 			GROUP BY G.NO_SPK";
			}
			// echo $id1.' '.$id2; die();
			$data = "SELECT A.NO_SPK,B.NO_CONT AS 'KONTAINER', D.CALL_SIGN, D.NM_ANGKUT AS 'NM_KAPAL', D.NO_VOY_FLIGHT AS 'NO_VOY', C.JNS_CONT, C.UK_CONT AS 'UKR_CONT', C.KD_CONT_TIPE, C.ISO_CODE, F.IMO, D.TGL_TIBA, C.WK_IN, G.NAMA, A.NO_DOK AS 'DOKUMEN', A.TGL_DOK AS 'TANGGAL', A.CONSIGNEE, C.WK_OUT
					FROM t_spk A
					LEFT JOIN t_spk_cont B ON B.ID = A.ID
					LEFT JOIN t_cocostscont C ON C.NO_CONT = B.NO_CONT
					LEFT JOIN t_cocostshdr D ON D.ID = D.ID AND D.NM_ANGKUT = A.NM_KAPAL
					LEFT JOIN t_request E ON E.NO_DOK = A.NO_DOK
					LEFT JOIN t_request_cont F ON F.ID = E.ID AND F.NO_CONT = B.NO_CONT
					LEFT JOIN reff_kode_dok_bc G ON A.JNS_DOK = G.ID
					WHERE A.NO_SPK = '$id1' AND C.NO_CONT = '$id2'
					GROUP BY A.NO_SPK";
			// echo $data;DIE();
 			$sql = $this->db->query($data);
			
			return $sql->result();
		}elseif($act == 'detail_job'){
			//$arrid = explode("~",$id);
			//$id1=$arrid[0];
			//$id2=$arrid[1];
			//echo $id1.' '.$id2; die();
 			$sql = $this->db->query("SELECT A.ID_JOB_SLIP AS 'ID',CONCAT('<span style=\"font-weight:bold\">',B.`STATUS`,'</SPAN>','<BR>', IFNULL(B.KETERANGAN,'-')) AS 'STATUS', A.WK_STATUS AS 'WAKTU_STATUS', A.OPERATOR FROM t_job_slip_status A
									LEFT JOIN reff_status_jobslip B ON A.KD_STATUS = B.ID
									WHERE A.ID_JOB_SLIP = '$id' ORDER BY A.WK_STATUS DESC");
			return $sql->result();
		}elseif($act == 'penarikan'){
			$SQL = "SELECT B.NO_SPK AS 'NO_SPK', A.NO_CONT AS 'NO_CONTAINER',A.UKR_CONT AS 'SIZE',B.WK_REQ AS 'TERBIT_SPK',C.NAMA AS 'JENIS_DOKUMEN',
			CASE WHEN A.STATUS_CONT IN('000','50','100') THEN  CONCAT('<span class=\"label label-success\" style=\"font-size:1em;\">',DATEDIFF(CURRENT_DATE(), DATE_FORMAT(B.WK_REQ,'%Y-%m-%d')),' HARI</span>') ELSE '-' END AS 'LAMA_PENARIKAN',A.ID_FLAT AS 'TID', D.W_PICKUP AS 'WAKTU_PICK_UP',B.CONSIGNEE AS 'CUSTOMER_NAME', 
			CASE WHEN A.STATUS_CONT = '450' THEN '<span class=\"label label-warning\">ON COMMON AREA</span>' WHEN A.STATUS_CONT = '200' THEN '<span class=\"label label-warning\"style=\"background: yellow\"><font color=\"black\">ON PROCESS</font></span>' ELSE '<span class=\"label label-success\">ON TERMINAL</span>' END AS 'STATUS_PENARIKAN'
			FROM t_spk_cont A
			INNER JOIN t_spk B ON A.id = B.id
			INNER JOIN reff_kode_dok_bc C ON C.ID = B.JNS_DOK
			LEFT JOIN t_op_pickup D ON B.NO_SPK = D.NO_SPK
			WHERE A.STATUS_CONT IN ('50','000','100','200','300','400','450')";
			
			$QUERY = $this->db->query($SQL);
			return $QUERY->result();
		}elseif($act == 'longroom'){
			$SQL = "SELECT B.NO_SPK, A.STATUS_CONT, A.NO_CONT,A.UKR_CONT,G.NAMA,C.NO_DOK,A.LOKASI,A.TIER,C.JNS_KEGIATAN,B.CONSIGNEE, 
					CASE WHEN A.STATUS_CONT = '460' AND F.START_INSP IS NULL AND F.FINISH_INSP IS NULL AND C.JNS_KEGIATAN ='1' AND C.RESPON IS NOT NULL THEN 'SIAP PERIKSA' 
					WHEN A.STATUS_CONT ='460' AND C.JNS_KEGIATAN='2' AND C.RESPON IS NOT NULL THEN 'SIAP PERIKSA' 
					WHEN A.STATUS_CONT IN ('500','540','520') THEN 'SELESAI PERIKSA' 
					WHEN A.STATUS_CONT = '460' AND F.START_INSP IS NOT NULL AND F.FINISH_INSP IS NULL THEN 'SEDANG PERIKSA' ELSE 'ANTRIAN PERIKSA' END AS KETERANGAN, F.START_INSP,H.WK_STATUS,C.WK_ACTIVE,F.START_INSP,F.FINISH_INSP
					FROM t_spk_cont A
					LEFT JOIN t_spk B ON A.ID = B.ID
					LEFT JOIN t_gatepass C ON A.NO_CONT = C.NO_CONT AND C.`STATUS` = 'WAITING' -- AND C.FL_ACTIVE = 'Y'
					INNER JOIN t_request D ON C.NO_DOK = D.NO_DOK
					LEFT JOIN reff_status_spk E ON A.STATUS_CONT = E.ID
					LEFT JOIN t_op_inspection F ON F.NO_CONT = A.NO_CONT -- AND F.FINISH_INSP IS NULL
					LEFT JOIN reff_kode_dok_bc G ON D.JNS_DOK = G.ID
					LEFT JOIN t_job_slip H ON H.NO_CONT = A.NO_CONT
					WHERE A.STATUS_CONT IN('460','500','510','530','540','520') AND C.FL_ACTIVE = 'Y'  
					GROUP BY A.NO_CONT
					ORDER BY CASE WHEN C.RESPON IS NOT NULL AND KETERANGAN ='ANTRIAN PERIKSA' THEN 1 WHEN C.RESPON IS NULL AND KETERANGAN='ANTRIAN PERIKSA' THEN 2 ELSE 3 END ASC, CASE WHEN F.START_INSP IS NOT NULL AND F.FINISH_INSP IS NULL THEN 3 WHEN A.STATUS_CONT = '460' THEN 2 WHEN A.STATUS_CONT IN ('500','540','520') THEN 4 WHEN C.FL_ACTIVE = 'Y' THEN 1 ELSE 0 END ASC,
					C.WK_RESPON ASC,C.WK_ACTIVE ASC";
			$QUERY = $this->db->query($SQL);
			return $QUERY->result();
		}elseif($act == 'pemeriksaan_behandle1'){
			$arrid = explode("~",$id);
			$id1=$arrid[0];
			$id2=$arrid[1];
			$SQL = "SELECT A.ID_JOB_SLIP,A.NO_SPK,A.KD_STATUS,A.WK_STATUS,A.LOKASI_AWAL,A.TIER_AWAL,A.LOKASI_AKHIR,A.TIER_AKHIR,A.OPERATOR
					FROM t_job_slip A
					WHERE A.KD_STATUS = 50 AND A.NO_CONT = '$id2' AND A.LOKASI_AKHIR LIKE'%CIC%' AND A.JENIS='BEHANDLE 1'";
			//echo $SQL;
			$QUERY = $this->db->query($SQL);
			return $QUERY->result();
		}elseif($act == 'm_exb1'){
			$arrid = explode("~",$id);
			$id1=$arrid[0];
			$id2=$arrid[1];
				$SQL="SELECT A.ID_JOB_SLIP,A.NO_SPK,A.KD_STATUS,A.WK_STATUS,A.LOKASI_AWAL,A.TIER_AWAL,A.LOKASI_AKHIR,A.TIER_AKHIR,A.OPERATOR
					FROM t_job_slip A
					WHERE A.KD_STATUS = 50 AND A.NO_CONT = '$id2' AND A.NO_SPK='$id1' AND A.LOKASI_AWAL LIKE'%CIC%' AND A.JENIS='EX BEHANDLE 1'
				";
			$QUERY = $this->db->query($SQL);
			return $QUERY->result();
		}elseif($act == 'm_behandle2'){
			$arrid = explode("~",$id);
			$id1=$arrid[0];
			$id2=$arrid[1];
				$SQL="SELECT A.ID_JOB_SLIP,A.NO_SPK,A.KD_STATUS,A.WK_STATUS,A.LOKASI_AWAL,A.TIER_AWAL,A.LOKASI_AKHIR,A.TIER_AKHIR,A.OPERATOR
					FROM t_job_slip A
					WHERE A.KD_STATUS = 50 AND A.NO_CONT = '$id2' AND A.LOKASI_AKHIR LIKE'%CIC%' AND A.JENIS='BEHANDLE 2'";
			$QUERY = $this->db->query($SQL);
			return $QUERY->result();
		}elseif($act == 'm_exb2'){
			$arrid = explode("~",$id);
			$id1=$arrid[0];
			$id2=$arrid[1];
			$SQL = "SELECT A.ID_JOB_SLIP,A.NO_SPK,A.KD_STATUS,A.WK_STATUS,A.LOKASI_AWAL,A.TIER_AWAL,A.LOKASI_AKHIR,A.TIER_AKHIR,A.OPERATOR
					FROM t_job_slip A
					WHERE A.KD_STATUS = 50 AND A.NO_CONT = '$id2' AND A.LOKASI_AWAL LIKE'%CIC%' AND A.JENIS='EX BEHANDLE 2'";
			$QUERY = $this->db->query($SQL);
			return $QUERY->result();
		}elseif($act == 'cek_m_exb2'){
			$arrid = explode("~",$id);
			$id1=$arrid[0];
			$id2=$arrid[1];
					
			$SQL = "SELECT A.ID_JOB_SLIP,A.NO_SPK,A.KD_STATUS,A.WK_STATUS,A.LOKASI_AKHIR,A.LOKASI_AWAL,A.TIER_AWAL,A.TIER_AKHIR
					FROM t_job_slip A
					WHERE A.KD_STATUS = 50 AND A.NO_CONT = '$id2' AND A.JENIS = 'EX BEHANDLE 2' -- LOKASI_AWAL LIKE'%CIC%'";
			
			$QUERY = $this->db->query($SQL);
			return $QUERY->result();
		}elseif($act == 'filterLongroom'){
			$arrid = explode("~", $id);
			$kode_dok = $arrid[0];
			$kode_status = $arrid[1];
			
			if($kode_dok != ""){
				if($kode_dok == 'bc'){
					$kode_dokumen = '81,82,19';
				}else{
					$kode_dokumen = '83';
				}
				$jns_dok = "AND B.JNS_DOK IN($kode_dokumen)";
			}else{
				$jns_dok = "";
			}
			if($kode_status != ""){
				if($kode_status == "100L"){
					$kode_status = "AND C.FL_ACTIVE = 'Y' AND F.START_INSP IS NOT NULL AND F.FINISH_INSP IS NOT NULL";
				}elseif($kode_status == "200L"){
					$kode_status = "AND F.START_INSP IS NOT NULL AND F.FINISH_INSP IS NULL";
				}else {
					$kode_status = "AND A.STATUS_CONT = '$kode_status'";
				}
			}else{
				$kode_status = "";
			}
			
			if(!empty($jns_dok) || !empty($kode_status)){
				$SQL = "SELECT B.NO_SPK, A.STATUS_CONT, A.NO_CONT,A.UKR_CONT,C.WK_ACTIVE,G.NAMA,A.LOKASI,A.TIER,C.JNS_KEGIATAN,B.CONSIGNEE, CASE WHEN A.STATUS_CONT = '460' THEN '<span class=\'label label-warning\'>SIAP PERIKSA</span>' WHEN A.STATUS_CONT IN ('500','540') THEN '<span class=\'label label-success\'>SELESAI PERIKSA</span>' ELSE '<span class=\'label label-danger\'>ANTRIAN PERIKSA</span>' END AS KETERANGAN, CASE WHEN F.START_INSP IS NOT NULL AND F.FINISH_INSP IS NULL THEN 'SEDANG PERIKSA' ELSE 'ANTRIAN PERIKSA' END AS KETERANGAN2, CASE WHEN C.FL_ACTIVE = 'Y' THEN 'ANTRIAN PERIKSA' ELSE '-' END AS KETERANGAN3, -- E.KETERANGAN, 
						F.START_INSP FROM t_spk_cont A
						LEFT JOIN t_spk B ON A.ID = B.ID
						LEFT JOIN t_gatepass C ON A.NO_CONT = C.NO_CONT --  AND C.`STATUS` = 'WAITING' AND C.FL_ACTIVE = 'Y'
						INNER JOIN t_request D ON C.NO_DOK = D.NO_DOK
						LEFT JOIN reff_status_spk E ON A.STATUS_CONT = E.ID
						LEFT JOIN t_op_inspection F ON F.NO_CONT = A.NO_CONT AND F.FINISH_INSP IS NULL
						LEFT JOIN reff_kode_dok_bc G ON D.JNS_DOK = G.ID
						WHERE A.STATUS_CONT IN('460','500','510','530','540') AND C.FL_ACTIVE = 'Y' ".$jns_dok." ".$kode_status." -- AND C.`STATUS` = 'WAITING'
						GROUP BY A.NO_CONT
						ORDER BY CASE 
							WHEN F.START_INSP IS NOT NULL AND F.FINISH_INSP IS NULL THEN 3
							WHEN A.STATUS_CONT = '460' THEN 2
							WHEN A.STATUS_CONT IN ('500','540','520') THEN 4
							WHEN C.FL_ACTIVE = 'Y'THEN 1
							ELSE 0 
						END ASC,C.WK_ACTIVE ASC";
			} else {
				$SQL = "SELECT B.NO_SPK, A.STATUS_CONT, A.NO_CONT,A.UKR_CONT,C.WK_ACTIVE,G.NAMA,A.LOKASI,A.TIER,C.JNS_KEGIATAN,B.CONSIGNEE, 
						CASE WHEN A.STATUS_CONT = '460' THEN '<span class=\'label label-warning\'>SIAP PERIKSA</span>' WHEN A.STATUS_CONT IN ('500','540','520') THEN '<span class=\'label label-success\'>SELESAI PERIKSA</span>' ELSE '<span class=\'label label-danger\'>ANTRIAN PERIKSA</span>' END AS KETERANGAN, 
						CASE WHEN F.START_INSP IS NOT NULL AND F.FINISH_INSP IS NULL THEN 'SEDANG PERIKSA' ELSE 'ANTRIAN PERIKSA' END AS KETERANGAN2, CASE WHEN C.FL_ACTIVE = 'Y' THEN 'ANTRIAN PERIKSA' ELSE '-' END AS KETERANGAN3, -- E.KETERANGAN, 
						F.START_INSP FROM t_spk_cont A
						LEFT JOIN t_spk B ON A.ID = B.ID
						LEFT JOIN t_gatepass C ON A.NO_CONT = C.NO_CONT AND C.`STATUS` = 'WAITING' -- AND C.FL_ACTIVE = 'Y'
						INNER JOIN t_request D ON C.NO_DOK = D.NO_DOK
						LEFT JOIN reff_status_spk E ON A.STATUS_CONT = E.ID
						LEFT JOIN t_op_inspection F ON F.NO_CONT = A.NO_CONT AND F.FINISH_INSP IS NULL
						LEFT JOIN reff_kode_dok_bc G ON D.JNS_DOK = G.ID
						WHERE A.STATUS_CONT IN('460','500','510','530','540','520') AND C.FL_ACTIVE = 'Y' -- AND C.`STATUS` = 'WAITING'
						GROUP BY A.NO_CONT
						ORDER BY CASE 
							WHEN F.START_INSP IS NOT NULL AND F.FINISH_INSP IS NULL THEN 3
							WHEN A.STATUS_CONT = '460' THEN 2
							WHEN A.STATUS_CONT IN ('500','540','520') THEN 4
							WHEN C.FL_ACTIVE = 'Y'THEN 1
							ELSE 0 
						END ASC,C.WK_ACTIVE ASC";
			}
			$resultLongroom = $func->main->get_result($SQL);
			if($resultLongroom){
				$no = 0;
				$table = '<table class="" cellspacing="0" width="100%" id="myTable" border="0"  style="border:2px">';
				$table .= "<tr style='text-align:center'>
							<th style='text-align:center;'>NO</th>
							<th style='text-align:center;'>NO SPK</th>
							<th style='text-align:center;'>NO KONTAINER</th>
							<th style='text-align:center;'>SIZE</th>
							<th style='text-align:center;'>REQUEST LONGROOM</th>
							<th style='text-align:center;'>JENIS DOKUMEN</th>
							<th style='text-align:center;'>LOKASI</th>
							<th style='text-align:center;'>KETERANGAN</th>
							<th style='text-align:center;'>CUSTOMER NAME</th>
							<th style='text-align:center;'>STATUS</th>
						</tr>";
				foreach($SQL->result_array() as $dtl){
					$no++;
					if ($no%2==1) {
						$class="style='background-color:#FFFFFF;line-height: 20px;'";
					}else{
						$class="style='background-color: #f1f1ff;line-height: 20px;'";
					}		
					
					if($no%2==1){
						$class="contentGanjil";
					}else{
						$class="contentGenap";
					}
					
					if($dtl['KETERANGAN2'] == 'SEDANG PERIKSA'){
						$status = "<span class='label label-primary'>SEDANG PERIKSA</span>";
					} elseif($dtl['KETERANGAN3'] == 'ANTRIAN PERIKSA'){
						if($dtl['KETERANGAN'] != 'SIAP PERIKSA'){
							$status = $dtl['KETERANGAN'];//"<span class='label label-danger'>$dtl[KETERANGAN]</span>";//
						}elseif($dtl['KETERANGAN'] == 'SIAP PERIKSA'){
							$status = $dtl['KETERANGAN'];//"<span class='label label-danger'>$dtl[KETERANGAN]</span>";//$dtl['KETERANGAN'];
						}else {
							$status = "<span class='label label-danger'>ANTRIAN PERIKSA</span>";
						}
					}else{
						$status = $dtl['KETERANGAN'];//"<span class='label label-danger'>$dtl[KETERANGAN]</span>";//
					}
					
					//echo $status = $dtl['KETERANGAN'];
					$table .= "<tr $class>";
					$table .= "
								<td style='text-align:center;'>$no</td>
								<td style='text-align:center;'>$dtl[NO_SPK]</td>
								<td style='text-align:center;'>$dtl[NO_CONT]</td>
								<td style='text-align:center;'>$dtl[UKR_CONT]</td>
								<td style='text-align:center;'>$dtl[WK_ACTIVE]</td>
								<td style='text-align:center;'>$dtl[NAMA]</td>
								<td style='text-align:center;'>$dtl[LOKASI]0$dtl[TIER]</td>
								<td style='text-align:center;'>BEHANDLE $dtl[JNS_KEGIATAN]</td>
								<td style='text-align:center;'>$dtl[CONSIGNEE]</td>
								<td style='text-align:center;'>$status</td>
							";
					$table .= "</tr>";
				}
				$table .= "</table>";
				return $table;
			}
		}
	}
	
	public function filter($act,$key){
		if($act == 'penarikan'){
			$arrexp = explode("~", $key);
			$status = $arrexp[0];
			$tgl = $arrexp[1];
			print_r(count($status));
			print_r($tgl);
			/*
			if(count($status) == '1'){
				$aks = "A.STATUS_CONT IN ('$status')";
			} else if(count($tgl) == '1'){
				$aks = "DATE_FORMAT(B.WK_REQ,'%Y-%m-%d') ='$tgl'";
			} else (
				$aks = "A.STATUS_CONT IN ('50','000','100','200','300','400','450')";
			}*/
			
			$SQL = "SELECT B.NO_SPK AS 'NO_SPK', A.NO_CONT AS 'NO_CONTAINER',A.UKR_CONT AS 'SIZE',B.WK_REQ AS 'TERBIT_SPK',C.NAMA AS 'JENIS_DOKUMEN',
			CASE WHEN A.STATUS_CONT IN('000','50','100') THEN  CONCAT('<span class=\"label label-success\" style=\"font-size:1em;\">',DATEDIFF(CURRENT_DATE(), DATE_FORMAT(B.WK_REQ,'%Y-%m-%d')),' HARI</span>') ELSE '-' END AS 'LAMA_PENARIKAN',A.ID_FLAT AS 'TID', D.W_PICKUP AS 'WAKTU_PICK_UP',B.CONSIGNEE AS 'CUSTOMER_NAME', 
			CASE WHEN A.STATUS_CONT = '450' THEN '<span class=\"label label-warning\">ON COMMON AREA</span>' WHEN A.STATUS_CONT = '200' THEN '<span class=\"label label-warning\"style=\"background: yellow\"><font color=\"black\">ON PROCESS</font></span>' ELSE '<span class=\"label label-success\">ON TERMINAL</span>' END AS 'STATUS_PENARIKAN'
			FROM t_spk_cont A
			INNER JOIN t_spk B ON A.id = B.id
			INNER JOIN reff_kode_dok_bc C ON C.ID = B.JNS_DOK
			LEFT JOIN t_op_pickup D ON B.NO_SPK = D.NO_SPK
			WHERE A.STATUS_CONT IN ('50','000','100','200','300','400','450')";
			
			$QUERY = $this->db->query($SQL);
			return $QUERY->result();
		}
	}
	
	function process($type, $act, $id){//print_r($type.$act);die();
        $func = get_instance();
        $func->load->model("m_main", "main", true);
        $success = 0;
        $error = 0;
        $USERLOGIN = $this->session->userdata('USERLOGIN');
        $KD_TPS = $this->session->userdata('KD_TPS');
        $KD_GUDANG = $this->session->userdata('KD_GUDANG');
			if($type == "excel"){
				if($act=="penarikan"){
					$no_kon = $this->input->post('form[0]');
					$tgl_nota = $this->input->post('form[1]');
					$tgl_start = $tgl_nota[0];
					$tgl_end = $tgl_nota[1];
					$no_kon1 = $no_kon[0];
					$addsql = "";
				
					if($tgl_start!="" and $tgl_end !=""){
						//$addsql .= " AND DATE(B.TGL_SPK) BETWEEN '$tgl_start' AND '$tgl_end'";
						$addsql .= " AND B.WK_REQ BETWEEN '$tgl_start' AND '$tgl_end'";
					}else if($tgl_start != ""){
						//$addsql .= " AND DATE(B.TGL_SPK) >= '$tgl_start'";
						$addsql .= " AND B.WK_REQ >= '$tgl_start'";
					}else if($tgl_end != ""){
						//$addsql .= " AND DATE(B.TGL_SPK) <= '$tgl_end'";
						$addsql .= " AND B.WK_REQ <= '$tgl_end'";
					}else{
						#$addsql .= " AND MONTH(A.TGL_TIBA) = MONTH(NOW()) AND YEAR(A.TGL_TIBA) = YEAR(NOW())";
					}
				
					$SQL = "SELECT B.NO_SPK, A.NO_CONT, A.UKR_CONT AS 'SIZE',B.WK_REQ AS 'TERBIT_SPK',C.NAMA AS 'DOKUMEN',
						CASE WHEN A.STATUS_CONT IN('000','50','100') THEN  CONCAT('',DATEDIFF(CURRENT_DATE(), DATE_FORMAT(B.WK_REQ,'%Y-%m-%d')),' HARI') ELSE '-' END AS 'PENARIKAN', A.ID_FLAT AS 'TID', D.W_PICKUP, B.CONSIGNEE AS 'CUSTOMER', 
						CASE WHEN A.STATUS_CONT IN('450','460') THEN 'ON COMMON AREA' WHEN A.STATUS_CONT = '200' THEN 'ON PROCESS' ELSE 'ON TERMINAL' END AS 'STATUS'
						FROM t_spk_cont A
						INNER JOIN t_spk B ON A.id = B.id
						INNER JOIN reff_kode_dok_bc C ON C.ID = B.JNS_DOK
						LEFT JOIN t_op_pickup D ON B.NO_SPK = D.NO_SPK
						WHERE 1=1 ".$addsql; 
						
					$SQL1 = "SELECT COUNT(IF(A.UKR_CONT = '20' AND C.NAMA = 'SPPMP', A.NO_CONT, NULL)) AS 'SPPMP_20', 
								COUNT(IF(A.UKR_CONT = '40' AND C.NAMA = 'SPPMP', A.NO_CONT, NULL)) AS 'SPPMP_40',
								COUNT(IF(A.UKR_CONT = '45' AND C.NAMA = 'SPPMP', A.NO_CONT, NULL)) AS 'SPPMP_45',
								SUM(C.NAMA = 'SPPMP') AS 'TOTAL_SPPMP',
								COUNT(IF(A.UKR_CONT = '20' AND C.NAMA != 'SPPMP', A.NO_CONT, NULL)) AS 'SPJM_20', 
								COUNT(IF(A.UKR_CONT = '40' AND C.NAMA != 'SPPMP', A.NO_CONT, NULL)) AS 'SPJM_40',
								COUNT(IF(A.UKR_CONT = '45' AND C.NAMA != 'SPPMP', A.NO_CONT, NULL)) AS 'SPJM_45',
								SUM(C.NAMA != 'SPPMP') AS 'TOTAL_SPJM', 
								CONCAT(COUNT(A.NO_CONT),' BOX') AS 'TOTAL'
								FROM t_spk_cont A
								INNER JOIN t_spk B ON A.id = B.id
								INNER JOIN reff_kode_dok_bc C ON C.ID = B.JNS_DOK
								LEFT JOIN t_op_pickup D ON B.NO_SPK = D.NO_SPK
								WHERE 1=1 ".$addsql;
						///echo $SQL1; die();
						$result = $func->main->get_result($SQL);
						$result1 = $func->main->get_result($SQL1);
						$this->load->library('newphpexcel');
						$this->newphpexcel->getDefaultStyle()->getFont()->setName('Calibri')->setSize(10);
						$objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
						$objDrawing->setName('Logo');
						$objDrawing->setDescription('Logo');
						$logo = imagecreatefrompng('assets/images/ipc_logo.png');
						$objDrawing->setImageResource($logo);
						$objDrawing->setCoordinates('A1');
						$objDrawing->setHeight(100);
						$objDrawing->setWidth(100);
						$objDrawing->setWorksheet($this->newphpexcel->getActiveSheet());
						$this->newphpexcel->setActiveSheetIndex(0);
						$styleArray = array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
						$this->newphpexcel->getDefaultStyle()->applyFromArray($styleArray);
						$this->newphpexcel->set_bold(array('A1'));
						$this->newphpexcel->mergecell(array(array('A1','K1'),array('A2','K2'),array('A3','K3'),array('M5','M6'),array('N5','N6'),array('O5','Q5'),array('R5','R6'),array('M7','M8'),array('M4','N4')), FALSE);
						$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A1', 'REPORT TERBIT SPK');
						$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A2', 'COMMON GATE IPC TPK');
						$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A3', date("M Y"));
						$this->newphpexcel->width(array(array('A',5),array('B',20),array('C',20),array('D',5),array('E',20),array('F',15),array('G',20),array('H',10),array('I',20),array('J',25),array('K',25)));
						
						$this->newphpexcel->setActiveSheetIndex(0)
							->setCellValue('A5','NO')
							->setCellValue('B5','NO SPK')
							->setCellValue('C5','NO KONTAINER')
							->setCellValue('D5','SIZE')
							->setCellValue('E5','TANGGAL TERBIT SPK')
							->setCellValue('F5','JENIS DOKUMEN')
							->setCellValue('G5','WAKTU PENARIKAN')
							->setCellValue('H5','TID')
							->setCellValue('I5','WAKTU PICK UP')
							->setCellValue('J5','NAMA CUSTOMER')
							->setCellValue('K5','STATUS PENARIKAN')
							->setCellValue('M4','GATE PASS TERBIT')
							->setCellValue('M5','NO')
							->setCellValue('N5','JENIS')
							->setCellValue('O5','UKURAN')
							->setCellValue('O6','20')
							->setCellValue('P6','40')
							->setCellValue('Q6','45')
							->setCellValue('R5','TOTAL');
						
						$this->newphpexcel->headings(array('A5','B5','C5','D5','E5','F5','G5','H5','I5','J5','K5','M5','M6','N5','N6','O5','O6','P5','P6','Q5','Q6','R5','R6'));
						$this->newphpexcel->set_wrap(array('B','C','D','E','F','G','H','I','J','K'));
						$no = 1;
						$rec = 6;
						if($result){
							foreach($SQL->result_array() as $row){
								$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A'.$rec,$no)
								->setCellValue('B'.$rec,$row["NO_SPK"])
								->setCellValue('C'.$rec,$row["NO_CONT"])
								->setCellValue('D'.$rec,$row["SIZE"])
								->setCellValueExplicit('E'.$rec,$row["TERBIT_SPK"],PHPExcel_Cell_DataType::TYPE_STRING)
								->setCellValue('F'.$rec,$row["DOKUMEN"])
								->setCellValue('G'.$rec,$row["PENARIKAN"])
								->setCellValue('H'.$rec,$row["TID"])
								->setCellValue('I'.$rec,$row["W_PICKUP"])
								->setCellValue('J'.$rec,$row["CUSTOMER"])
								->setCellValue('K'.$rec,$row["STATUS"]);
								$this->newphpexcel->set_detilstyle(array('A'.$rec,'B'.$rec,'C'.$rec,'D'.$rec,'E'.$rec,'F'.$rec,'G'.$rec,'H'.$rec,'I'.$rec,'J'.$rec,'K'.$rec));
								$rec++;
								$no++;
							}
							
							$no = 1;
							$rec = 7;
							foreach($SQL1->result_array() as $row){
							$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('M'.$rec,$no)
								->setCellValue('N'.$rec,'SPPMP')
								->setCellValue('O'.$rec,$row["SPPMP_20"])
								->setCellValue('P'.$rec,$row["SPPMP_40"])
								->setCellValue('Q'.$rec,$row["SPPMP_45"])
								->setCellValue('R'.$rec,$row["TOTAL_SPPMP"])
								->setCellValue('R'.'4',$row["TOTAL"]);
								$this->newphpexcel->set_detilstyle(array('M'.$rec,'N'.$rec,'O'.$rec,'P'.$rec,'Q'.$rec,'R'.$rec));
							}
							
							$rec = 8;
							foreach($SQL1->result_array() as $row){
							$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('M'.$rec,$no)
								->setCellValue('N'.$rec,'SPJM')
								->setCellValue('O'.$rec,$row["SPJM_20"])
								->setCellValue('P'.$rec,$row["SPJM_40"])
								->setCellValue('Q'.$rec,$row["SPJM_45"])
								->setCellValue('R'.$rec,$row["TOTAL_SPJM"]);
								$this->newphpexcel->set_detilstyle(array('M'.$rec,'N'.$rec,'O'.$rec,'P'.$rec,'Q'.$rec,'R'.$rec));
							}
						}else{
							$this->newphpexcel->getActiveSheet()->mergeCells('A6:X6');
							$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A5','DATA TIDAK DITEMUKAN');
							$this->newphpexcel->set_detilstyle(array('A5'));
						}
						ob_clean();

						$file = "TERBIT_SPK_" . date("Ymd") . ".xls";
						header("Content-type: application/x-msdownload");
						header("Content-Disposition: attachment;filename=$file");
						header("Cache-Control: max-age=0");
						header("Pragma: no-cache");
						header("Expires: 0");
						$objWriter = PHPExcel_IOFactory::createWriter($this->newphpexcel, 'Excel5');
						$objWriter->save('php://output');
						exit();
				}else if($act=="penarikan1"){
					$no_kon = $this->input->post('form[0]');
					$tgl_nota = $this->input->post('form[1]');
					$tgl_start = $tgl_nota[0];
					$tgl_end = $tgl_nota[1];
					$no_kon1 = $no_kon[0];
					$addsql = "";
				
					//print_r($tgl_nota); die();
					
					if($tgl_start!="" and $tgl_end !=""){
						//$addsql .= " AND DATE(E.W_BEHANDLE) BETWEEN '$tgl_start' AND '$tgl_end'";
						$addsql .= " AND F.W_BEHANDLE BETWEEN '$tgl_start' AND '$tgl_end'";
					}else if($tgl_nota_start != ""){
						//$addsql .= " AND DATE(E.W_BEHANDLE) >= '$tgl_start'";
						$addsql .= " AND F.W_BEHANDLE >= '$tgl_start'";
					}else if($tgl_nota_end != ""){
						//$addsql .= " AND DATE(W_BEHANDLE) <= '$tgl_end'";
						$addsql .= " AND F.W_BEHANDLE <= '$tgl_end'";
					}else{
						#$addsql .= " AND MONTH(A.TGL_TIBA) = MONTH(NOW()) AND YEAR(A.TGL_TIBA) = YEAR(NOW())";
					}
					

					//if($no_kon1 != ""){
					//	$addsql .= " AND D.NO_CONT = '$no_kon1'";
					//}				
					$SQL = "SELECT B.NO_SPK AS 'NO SPK', A.NO_CONT AS 'NO CONTAINER',A.UKR_CONT AS 'SIZE',B.WK_REQ AS 'TERBIT SPK',
							C.NAMA AS 'JENIS DOKUMEN', CASE WHEN A.STATUS_CONT IN('450','460','500','510','520','530','540') 
						THEN CONCAT( DATEDIFF(DATE_FORMAT(F.W_BEHANDLE,'%Y-%m-%d'), DATE_FORMAT(D.W_PICKUP,'%Y-%m-%d')),' HARI / ',TIMEDIFF(TIMESTAMP(F.W_BEHANDLE,'%Y-%m-%d, %hh:%mm:%ss'), TIMESTAMP(D.W_PICKUP,'%Y-%m-%d, %hh:%mm:%ss')),' JAM ')  
						 ELSE '-' END AS 'LAMA PENARIKAN',
							A.ID_FLAT AS 'TID', F.W_BEHANDLE AS 'WAKTU BEHANDLE IN', D.W_PICKUP AS 'WAKTU PICK UP', B.CONSIGNEE AS 'CUSTOMER NAME', 
							CASE WHEN A.STATUS_CONT IN('450','460','510','500','520','530','540') THEN 'ON COMMON AREA' WHEN A.STATUS_CONT = '200' THEN 'ON PROCESS' ELSE 'ON TERMINAL' END AS 'STATUS PENARIKAN'
							FROM t_spk_cont A
							LEFT JOIN t_op_behandlein F ON F.NO_CONT = A.NO_CONT
							INNER JOIN t_spk B ON A.id = B.id
							INNER JOIN reff_kode_dok_bc C ON C.ID = B.JNS_DOK
							LEFT JOIN t_op_pickup D ON B.NO_SPK = D.NO_SPK
							WHERE A.STATUS_CONT IN ('50','000','100','200','300','400','450','460','500','510','520','530','540') AND F.W_BEHANDLE IS NOT NULL ".$addsql; //echo $SQL; die();	
						
					$SQL1 = "SELECT COUNT(IF(A.UKR_CONT = '20' AND C.NAMA = 'SPPMP', A.NO_CONT, NULL)) AS 'SPPMP_20', 
								COUNT(IF(A.UKR_CONT = '40' AND C.NAMA = 'SPPMP', A.NO_CONT, NULL)) AS 'SPPMP_40',
								COUNT(IF(A.UKR_CONT = '45' AND C.NAMA = 'SPPMP', A.NO_CONT, NULL)) AS 'SPPMP_45',
								SUM(C.NAMA = 'SPPMP') AS 'TOTAL_SPPMP',
								COUNT(IF(A.UKR_CONT = '20' AND C.NAMA != 'SPPMP', A.NO_CONT, NULL)) AS 'SPJM_20', 
								COUNT(IF(A.UKR_CONT = '40' AND C.NAMA != 'SPPMP', A.NO_CONT, NULL)) AS 'SPJM_40',
								COUNT(IF(A.UKR_CONT = '45' AND C.NAMA != 'SPPMP', A.NO_CONT, NULL)) AS 'SPJM_45',
								SUM(C.NAMA != 'SPPMP') AS 'TOTAL_SPJM', 
								CONCAT(COUNT(A.NO_CONT),' BOX') AS 'TOTAL'
								FROM t_spk_cont A
								LEFT JOIN t_op_behandlein F ON F.NO_CONT = A.NO_CONT
								INNER JOIN t_spk B ON A.id = B.id
								INNER JOIN reff_kode_dok_bc C ON C.ID = B.JNS_DOK
								LEFT JOIN t_op_pickup D ON B.NO_SPK = D.NO_SPK
								WHERE A.STATUS_CONT IN ('50','000','100','200','300','500','400','450','460','510','520','530','540') AND F.W_BEHANDLE IS NOT NULL ".$addsql;
						$result = $func->main->get_result($SQL);
						$result1 = $func->main->get_result($SQL1);
						$this->load->library('newphpexcel');
						$this->newphpexcel->getDefaultStyle()->getFont()->setName('Calibri')->setSize(10);
						$objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
						$objDrawing->setName('Logo');
						$objDrawing->setDescription('Logo');
						$logo = imagecreatefrompng('assets/images/ipc_logo.png');
						$objDrawing->setImageResource($logo);
						$objDrawing->setCoordinates('A1');
						$objDrawing->setHeight(100);
						$objDrawing->setWidth(100);
						$objDrawing->setWorksheet($this->newphpexcel->getActiveSheet());
						$this->newphpexcel->setActiveSheetIndex(0);
						$styleArray = array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
						$this->newphpexcel->getDefaultStyle()->applyFromArray($styleArray);
						$this->newphpexcel->set_bold(array('A1'));
						$this->newphpexcel->mergecell(array(array('A1','L1'),array('A2','L2'),array('A3','L3'),array('N5','N6'),array('O5','O6'),array('P5','R5'),array('S5','S6'),array('N7','N8'),array('N4','P4')), FALSE);
						$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A1', 'REPORT PENARIKAN BEHANDLE IN');
						$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A2', 'COMMON GATE IPC TPK');
						$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A3', date("M Y"));
						$this->newphpexcel->width(array(array('A',5),array('B',20),array('C',20),array('D',5),array('E',20),array('F',15),array('G',20),array('H',10),array('I',20),array('J',25),array('K',25),array('L',25)));
						
						$this->newphpexcel->setActiveSheetIndex(0)
						->setCellValue('A5','NO')
						->setCellValue('B5','NO SPK')
						->setCellValue('C5','NO KONTAINER')
						->setCellValue('D5','SIZE')
						->setCellValue('E5','TANGGAL TERBIT SPK')
						->setCellValue('F5','JENIS DOKUMEN')
						->setCellValue('G5','WAKTU PENARIKAN')
						->setCellValue('H5','TID')
						->setCellValue('I5','WAKTU BEHANDLE IN')
						->setCellValue('J5','WAKTU PICK UP')
						->setCellValue('K5','NAMA CUSTOMER')
						->setCellValue('L5','STATUS PENARIKAN')
						->setCellValue('N4','GATE PASS TERBIT')
						->setCellValue('N5','NO')
						->setCellValue('O5','JENIS')
						->setCellValue('P5','UKURAN')
						->setCellValue('P6','20')
						->setCellValue('Q6','40')
						->setCellValue('R6','45')
						->setCellValue('S5','TOTAL');
					
					$this->newphpexcel->headings(array('A5','B5','C5','D5','E5','F5','G5','H5','I5','J5','K5','L5','N5','N6','O5','O6','P5','P6','Q5','Q6','R5','R6','S5','S6'));
					$this->newphpexcel->set_wrap(array('B','C','D','E','F','G','H','I','J','K','L'));
					$no = 1;
					$rec = 6;
					if($result){
						foreach($SQL->result_array() as $row){
							$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A'.$rec,$no)
							->setCellValue('B'.$rec,$row["NO SPK"])
							->setCellValue('C'.$rec,$row["NO CONTAINER"])
							->setCellValue('D'.$rec,$row["SIZE"])
							->setCellValueExplicit('E'.$rec,$row["TERBIT SPK"],PHPExcel_Cell_DataType::TYPE_STRING)
							->setCellValue('F'.$rec,$row["JENIS DOKUMEN"])
							->setCellValue('G'.$rec,$row["LAMA PENARIKAN"])
							->setCellValue('H'.$rec,$row["TID"])
							->setCellValue('I'.$rec,$row["WAKTU BEHANDLE IN"])
							->setCellValue('J'.$rec,$row["WAKTU PICKUP"])
							->setCellValue('K'.$rec,$row["CUSTOMER NAME"])
							->setCellValue('L'.$rec,$row["STATUS PENARIKAN"]);
							$this->newphpexcel->set_detilstyle(array('A'.$rec,'B'.$rec,'C'.$rec,'D'.$rec,'E'.$rec,'F'.$rec,'G'.$rec,'H'.$rec,'I'.$rec,'J'.$rec,'K'.$rec,'L'.$rec));
							$rec++;
							$no++;
						}
							
							$no = 1;
							$rec = 7;
							foreach($SQL1->result_array() as $row){
							$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('N'.$rec,$no)
								->setCellValue('O'.$rec,'SPPMP')
								->setCellValue('P'.$rec,$row["SPPMP_20"])
								->setCellValue('Q'.$rec,$row["SPPMP_40"])
								->setCellValue('R'.$rec,$row["SPPMP_45"])
								->setCellValue('S'.$rec,$row["TOTAL_SPPMP"])
								->setCellValue('S'.'4',$row["TOTAL"]);
								$this->newphpexcel->set_detilstyle(array('N'.$rec,'O'.$rec,'P'.$rec,'Q'.$rec,'R'.$rec,'S'.$rec));
							}
							
							$rec = 8;
							foreach($SQL1->result_array() as $row){
							$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('N'.$rec,$no)
								->setCellValue('O'.$rec,'SPJM')
								->setCellValue('P'.$rec,$row["SPJM_20"])
								->setCellValue('Q'.$rec,$row["SPJM_40"])
								->setCellValue('R'.$rec,$row["SPJM_45"])
								->setCellValue('S'.$rec,$row["TOTAL_SPJM"]);
								$this->newphpexcel->set_detilstyle(array('N'.$rec,'O'.$rec,'P'.$rec,'Q'.$rec,'R'.$rec,'S'.$rec));
							}
						}else{
							$this->newphpexcel->getActiveSheet()->mergeCells('A6:X6');
							$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A5','DATA TIDAK DITEMUKAN');
							$this->newphpexcel->set_detilstyle(array('A5'));
						}
						ob_clean();

						$file = "PENARIKAN_BEHANDLE_" . date("Ymd") . ".xls";
						header("Content-type: application/x-msdownload");
						header("Content-Disposition: attachment;filename=$file");
						header("Cache-Control: max-age=0");
						header("Pragma: no-cache");
						header("Expires: 0");
						$objWriter = PHPExcel_IOFactory::createWriter($this->newphpexcel, 'Excel5');
						$objWriter->save('php://output');
						exit();
					/*	$no_kon = $this->input->post('form[0]');
						$tgl_nota = $this->input->post('form[1]');
						$tgl_start = $tgl_nota[0];
						$tgl_end = $tgl_nota[1];
						$no_kon1 = $no_kon[0];
						$addsql = "";
					
					//print_r($tgl_nota); die();
						
						if($tgl_start!="" and $tgl_end !=""){
							//$addsql .= " AND DATE(E.W_BEHANDLE) BETWEEN '$tgl_start' AND '$tgl_end'";
							$addsql .= " AND E.W_BEHANDLE BETWEEN '$tgl_start' AND '$tgl_end'";
						}else if($tgl_nota_start != ""){
							//$addsql .= " AND DATE(E.W_BEHANDLE) >= '$tgl_start'";
							$addsql .= " AND E.W_BEHANDLE >= '$tgl_start'";
						}else if($tgl_nota_end != ""){
							//$addsql .= " AND DATE(W_BEHANDLE) <= '$tgl_end'";
							$addsql .= " AND W_BEHANDLE <= '$tgl_end'";
						}else{
							#$addsql .= " AND MONTH(A.TGL_TIBA) = MONTH(NOW()) AND YEAR(A.TGL_TIBA) = YEAR(NOW())";
						}
						

						//if($no_kon1 != ""){
						//	$addsql .= " AND D.NO_CONT = '$no_kon1'";
						//}				
						$SQL = "SELECT B.NO_SPK, A.NO_CONT, A.UKR_CONT AS 'SIZE',B.WK_REQ AS 'TERBIT_SPK',C.NAMA AS 'DOKUMEN', E.W_BEHANDLE,
							CASE WHEN A.STATUS_CONT IN('000','50','100') THEN  CONCAT('',DATEDIFF(CURRENT_DATE(), DATE_FORMAT(B.WK_REQ,'%Y-%m-%d')),' HARI') ELSE '-' END AS 'PENARIKAN', A.ID_FLAT AS 'TID', D.W_PICKUP, B.CONSIGNEE AS 'CUSTOMER', 
							CASE WHEN A.STATUS_CONT IN('450','460') THEN 'ON COMMON AREA' WHEN A.STATUS_CONT = '200' THEN 'ON PROCESS' ELSE 'ON TERMINAL' END AS 'STATUS'
							FROM t_spk_cont A
							INNER JOIN t_spk B ON A.id = B.id
							INNER JOIN reff_kode_dok_bc C ON C.ID = B.JNS_DOK
							LEFT JOIN t_op_behandlein E ON E.NO_CONT = A.NO_CONT
							LEFT JOIN t_op_pickup D ON B.NO_SPK = D.NO_SPK
							WHERE A.STATUS_CONT IN ('50','000','100','200','300','400','450','460') AND E.W_BEHANDLE IS NOT NULL ".$addsql; //echo $SQL; die();	
							
						$SQL1 = "SELECT COUNT(IF(A.UKR_CONT = '20' AND C.NAMA = 'SPPMP', A.NO_CONT, NULL)) AS 'SPPMP_20', 
									COUNT(IF(A.UKR_CONT = '40' AND C.NAMA = 'SPPMP', A.NO_CONT, NULL)) AS 'SPPMP_40',
									COUNT(IF(A.UKR_CONT = '45' AND C.NAMA = 'SPPMP', A.NO_CONT, NULL)) AS 'SPPMP_45',
									SUM(C.NAMA = 'SPPMP') AS 'TOTAL_SPPMP',
									COUNT(IF(A.UKR_CONT = '20' AND C.NAMA != 'SPPMP', A.NO_CONT, NULL)) AS 'SPJM_20', 
									COUNT(IF(A.UKR_CONT = '40' AND C.NAMA != 'SPPMP', A.NO_CONT, NULL)) AS 'SPJM_40',
									COUNT(IF(A.UKR_CONT = '45' AND C.NAMA != 'SPPMP', A.NO_CONT, NULL)) AS 'SPJM_45',
									SUM(C.NAMA != 'SPPMP') AS 'TOTAL_SPJM', 
									CONCAT(COUNT(A.NO_CONT),' BOX') AS 'TOTAL'
									FROM t_spk_cont A
									INNER JOIN t_spk B ON A.id = B.id
									INNER JOIN reff_kode_dok_bc C ON C.ID = B.JNS_DOK
									LEFT JOIN t_op_behandlein E ON E.NO_CONT = A.NO_CONT
									LEFT JOIN t_op_pickup D ON B.NO_SPK = D.NO_SPK
									WHERE A.STATUS_CONT IN ('50','000','100','200','300','400','450','460') AND E.W_BEHANDLE IS NOT NULL ".$addsql;
							$result = $func->main->get_result($SQL);
							$result1 = $func->main->get_result($SQL1);
							$this->load->library('newphpexcel');
							$this->newphpexcel->getDefaultStyle()->getFont()->setName('Calibri')->setSize(10);
							$objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
							$objDrawing->setName('Logo');
							$objDrawing->setDescription('Logo');
							$logo = imagecreatefrompng('assets/images/ipc_logo.png');
							$objDrawing->setImageResource($logo);
							$objDrawing->setCoordinates('A1');
							$objDrawing->setHeight(100);
							$objDrawing->setWidth(100);
							$objDrawing->setWorksheet($this->newphpexcel->getActiveSheet());
							$this->newphpexcel->setActiveSheetIndex(0);
							$styleArray = array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
							$this->newphpexcel->getDefaultStyle()->applyFromArray($styleArray);
							$this->newphpexcel->set_bold(array('A1'));
							$this->newphpexcel->mergecell(array(array('A1','K1'),array('A2','K2'),array('A3','K3'),array('M5','M6'),array('N5','N6'),array('O5','Q5'),array('R5','R6'),array('M7','M8'),array('M4','O4')), FALSE);
							$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A1', 'REPORT PENARIKAN BEHANDLE IN');
							$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A2', 'COMMON GATE IPC TPK');
							$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A3', date("M Y"));
							$this->newphpexcel->width(array(array('A',5),array('B',20),array('C',20),array('D',5),array('E',20),array('F',15),array('G',20),array('H',10),array('I',20),array('J',25),array('K',25)));
							
							$this->newphpexcel->setActiveSheetIndex(0)
								->setCellValue('A5','NO')
								->setCellValue('B5','NO SPK')
								->setCellValue('C5','NO KONTAINER')
								->setCellValue('D5','SIZE')
								->setCellValue('E5','TANGGAL TERBIT SPK')
								->setCellValue('F5','JENIS DOKUMEN')
								->setCellValue('G5','WAKTU PENARIKAN')
								->setCellValue('H5','TID')
								->setCellValue('I5','WAKTU PICK UP')
								->setCellValue('J5','NAMA CUSTOMER')
								->setCellValue('K5','STATUS PENARIKAN')
								->setCellValue('M4','PENARIKAN (BEHANDLE IN)')
								->setCellValue('M5','NO')
								->setCellValue('N5','JENIS')
								->setCellValue('O5','UKURAN')
								->setCellValue('O6','20')
								->setCellValue('P6','40')
								->setCellValue('Q6','45')
								->setCellValue('R5','TOTAL');
							
							$this->newphpexcel->headings(array('A5','B5','C5','D5','E5','F5','G5','H5','I5','J5','K5','M5','M6','N5','N6','O5','O6','P5','P6','Q5','Q6','R5','R6'));
							$this->newphpexcel->set_wrap(array('B','C','D','E','F','G','H','I','J','K'));
							$no = 1;
							$rec = 6;
							if($result){
								foreach($SQL->result_array() as $row){
									$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A'.$rec,$no)
									->setCellValue('B'.$rec,$row["NO_SPK"])
									->setCellValue('C'.$rec,$row["NO_CONT"])
									->setCellValue('D'.$rec,$row["SIZE"])
									->setCellValueExplicit('E'.$rec,$row["TERBIT_SPK"],PHPExcel_Cell_DataType::TYPE_STRING)
									->setCellValue('F'.$rec,$row["DOKUMEN"])
									->setCellValue('G'.$rec,$row["PENARIKAN"])
									->setCellValue('H'.$rec,$row["TID"])
									->setCellValue('I'.$rec,$row["W_PICKUP"])
									->setCellValue('J'.$rec,$row["CUSTOMER"])
									->setCellValue('K'.$rec,$row["STATUS"]);
									$this->newphpexcel->set_detilstyle(array('A'.$rec,'B'.$rec,'C'.$rec,'D'.$rec,'E'.$rec,'F'.$rec,'G'.$rec,'H'.$rec,'I'.$rec,'J'.$rec,'K'.$rec));
									$rec++;
									$no++;
								}
								
								$no = 1;
								$rec = 7;
								foreach($SQL1->result_array() as $row){
								$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('M'.$rec,$no)
									->setCellValue('N'.$rec,'SPPMP')
									->setCellValue('O'.$rec,$row["SPPMP_20"])
									->setCellValue('P'.$rec,$row["SPPMP_40"])
									->setCellValue('Q'.$rec,$row["SPPMP_45"])
									->setCellValue('R'.$rec,$row["TOTAL_SPPMP"])
									->setCellValue('R'.'4',$row["TOTAL"]);
									$this->newphpexcel->set_detilstyle(array('M'.$rec,'N'.$rec,'O'.$rec,'P'.$rec,'Q'.$rec,'R'.$rec));
								}
								
								$rec = 8;
								foreach($SQL1->result_array() as $row){
								$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('M'.$rec,$no)
									->setCellValue('N'.$rec,'SPJM')
									->setCellValue('O'.$rec,$row["SPJM_20"])
									->setCellValue('P'.$rec,$row["SPJM_40"])
									->setCellValue('Q'.$rec,$row["SPJM_45"])
									->setCellValue('R'.$rec,$row["TOTAL_SPJM"]);
									$this->newphpexcel->set_detilstyle(array('M'.$rec,'N'.$rec,'O'.$rec,'P'.$rec,'Q'.$rec,'R'.$rec));
								}
							}else{
								$this->newphpexcel->getActiveSheet()->mergeCells('A6:X6');
								$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A5','DATA TIDAK DITEMUKAN');
								$this->newphpexcel->set_detilstyle(array('A5'));
							}
							ob_clean();

							$file = "PENARIKAN_BEHANDLE_" . date("Ymd") . ".xls";
							header("Content-type: application/x-msdownload");
							header("Content-Disposition: attachment;filename=$file");
							header("Cache-Control: max-age=0");
							header("Pragma: no-cache");
							header("Expires: 0");
							$objWriter = PHPExcel_IOFactory::createWriter($this->newphpexcel, 'Excel5');
							$objWriter->save('php://output');
							exit(); */
				}else if($act=="delivery"){
					$no_cust = $this->input->post('form[0]');
					$tgl_nota = $this->input->post('form[1]');
					$tgl_req = $this->input->post('form[2]');
					$tgl_nota_start = $tgl_nota[0];
					$tgl_nota_end = $tgl_nota[1];
					$tgl_req_start = $tgl_req[0];
					$tgl_req_end = $tgl_req[1];
					$no_cust = $no_cust[0];
					$addsql = "";
					/*if($id=="impor"){
						$addsql .= " AND A.KD_ASAL_BRG IN('1','2')";
					}else if($id=="ekspor"){
						$addsql .= " AND A.KD_ASAL_BRG IN('3','4')";
					}*/

					if($tgl_nota_start!="" and $tgl_nota_end !=""){
						$addsql .= " AND DATE(A.WK_REK) BETWEEN '$tgl_nota_start' AND '$tgl_nota_end' GROUP BY A.NO_DOK";
					}else if($tgl_nota_start != ""){
						$addsql .= " AND DATE(A.WK_REK) >= '$tgl_nota_start' GROUP BY A.NO_DOK";
					}else if($tgl_nota_end != ""){
						$addsql .= " AND DATE(A.WK_REK) <= '$tgl_nota_end' GROUP BY A.NO_DOK";
					}else{
						$addsql .= " GROUP BY A.NO_DOK";
					}


					/*if($no_cust != ""){
						$addsql .= " AND B.NAMA_CUST = '$no_cust'";
					}*/
					$SQL = "SELECT A.ID,A.NO_CONT AS 'NO. KONTAINER',A.NM_KAPAL AS 'VESSEL NAME', A.NO_VOY AS 'VOYAGE',A.UKR_CONT AS 
							'SIZE',E.KD_CONT_TIPE AS 'TYPE', B.LOKASI AS 'LOKASI', A.WK_REK AS 'TERBIT GATE PASS DELIVERY',A.EXPIRED_DATE AS 
							'PAIDTHRU',A.JNS_DOK AS 'JENIS DOKUMEN',A.NAMA_CUST AS 'NAMA CUSTOMER'
							FROM t_gatepass A
							LEFT JOIN t_spk_cont B ON A.NO_CONT = B.NO_CONT
							LEFT JOIN t_spk C ON A.NO_DOK = C.NO_DOK AND A.TGL_DOK = C.TGL_DOK
							LEFT JOIN t_permit_hdr D ON D.NO_DOK_INOUT = A.NO_DOK
							LEFT JOIN t_cocostscont E ON E.NO_CONT = A.NO_CONT
							WHERE B.STATUS_CONT != '900' AND A.JNS_KEGIATAN = '3' ".$addsql; #echo $SQL; die();
					//
					$result = $func->main->get_result($SQL);
					$this->load->library('newphpexcel');
					$this->newphpexcel->getDefaultStyle()->getFont()->setName('Calibri')->setSize(10);
					$this->newphpexcel->setActiveSheetIndex(0);
					$styleArray = array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
					$this->newphpexcel->getDefaultStyle()->applyFromArray($styleArray);
					$this->newphpexcel->set_bold(array('A1'));
					$this->newphpexcel->mergecell(array(array('A1','M1')), FALSE);
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A1', 'REPORT GATEOUT DELIVERY');
					$this->newphpexcel->width(array(array('A',5),array('B',25),array('C',25),array('D',25),array('E',20),array('F',15),array('G',15),array('H',10),array('I',15),array('J',25),array('K',25)));
					$this->newphpexcel->setActiveSheetIndex(0)
						->setCellValue('A3','NO')
						->setCellValue('B3','NO KONTAINER')
						->setCellValue('C3','UKURAN')
						->setCellValue('D3','NAMA KAPAL')
						->setCellValue('E3','NO VOYAGE')
						->setCellValue('F3','TIPE')
						->setCellValue('G3','TERBIT GATEPASS DELIVERY')
						->setCellValue('H3','PAIDTHRU')
						->setCellValue('I3','JENIS DOKUMEN')
						->setCellValue('J3','NAMA CUSTOMER')
						->setCellValue('K3','LOKASI');
					$this->newphpexcel->headings(array('A3','B3','C3','D3','E3','F3','G3','H3','I3','J3','K3'));
					$this->newphpexcel->set_wrap(array('B','C','D','E','F','G','H','I','J','K'));
					$no = 1;
					$rec = 4;
					if($result){
						foreach($SQL->result_array() as $row){
							$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A'.$rec,$no)
							->setCellValueExplicit('B'.$rec,$row["NO. KONTAINER"],PHPExcel_Cell_DataType::TYPE_STRING)
							->setCellValueExplicit('C'.$rec,$row["SIZE"],PHPExcel_Cell_DataType::TYPE_STRING)
							->setCellValueExplicit('D'.$rec,$row["VESSEL NAME"],PHPExcel_Cell_DataType::TYPE_STRING)
							->setCellValue('E'.$rec,$row["VOYAGE"])
							->setCellValueExplicit('F'.$rec,$row["TYPE"],PHPExcel_Cell_DataType::TYPE_STRING)
							->setCellValue('G'.$rec,$row["TERBIT GATE PASS DELIVERY"])
							->setCellValueExplicit('H'.$rec,$row["PAIDTHRU"],PHPExcel_Cell_DataType::TYPE_STRING)
							->setCellValue('I'.$rec,$row["JENIS DOKUMEN"])
							->setCellValue('J'.$rec,$row["NAMA CUSTOMER"])
							->setCellValue('K'.$rec,$row["LOKASI"]);
							$this->newphpexcel->set_detilstyle(array('A'.$rec,'B'.$rec,'C'.$rec,'D'.$rec,'E'.$rec,'F'.$rec,'G'.$rec,'H'.$rec,'I'.$rec,'J'.$rec,'K'.$rec));
							$rec++;
							$no++;
						}
					}else{
						$this->newphpexcel->getActiveSheet()->mergeCells('A4:L4');
						$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A5','DATA TIDAK DITEMUKAN');
						$this->newphpexcel->set_detilstyle(array('A5'));
					}
					ob_clean();

					$file = "DELIVERY_" . date("Ymd") . ".xls";
					header("Content-type: application/x-msdownload");
					header("Content-Disposition: attachment;filename=$file");
					header("Cache-Control: max-age=0");
					header("Pragma: no-cache");
					header("Expires: 0");
					$objWriter = PHPExcel_IOFactory::createWriter($this->newphpexcel, 'Excel5');
					$objWriter->save('php://output');
					exit();
				}
			}
	}

}

?>
