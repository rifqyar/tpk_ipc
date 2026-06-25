<?php if (! defined('BASEPATH')) exit('No direct script access allowed');
class M_monitoring extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
	}

	public function list_kontainer($act, $id)
	{
		if ($this->session->userdata('KD_GROUP') != "PUBLIC") {
			$page_title = "MONITORING KONTAINER";
			$title = "MONITORING KONTAINER";
			$this->newtable->breadcrumb('Dashboard', site_url(), 'icon-home');
			$this->newtable->breadcrumb('Monitoring', 'javascript:void(0)', '');
			$this->newtable->breadcrumb('Kontainer', 'javascript:void(0)', '');
			//$check = (grant()=="W")?true:false;
			$SQL = "SELECT A.ID AS 'ID',CONCAT('',(B.NO_CONT),'<BR>',(B.UKR_CONT)) AS 'KONTAINER', CASE WHEN LEFT(B.LOKASI,3) = 'CIC' THEN B.LOKASI ELSE CONCAT(B.LOKASI,'0', TIER) END AS 'LOKASI', B.NO_CONT AS 'KON', A.NO_SPK AS 'NSPK',
				     CONCAT('',(A.NO_SPK),'<BR>',(A.TGL_SPK)) AS 'SPK',
				     C.KETERANGAN AS 'STATUS', A.NO_DOK as NO_DOK FROM t_spk A, t_spk_cont B
				     INNER JOIN reff_status_spk C ON C.ID = B.STATUS_CONT WHERE A.ID = B.ID
				     ";
			$this->newtable->multiple_search(true);
			$this->newtable->show_chk(false);
			$this->newtable->show_menu(false);
			$this->newtable->show_search(true);
			$this->newtable->show_menu($check);
			$this->newtable->search(array(array('NO_SPK', 'NO. SPK'), array('NO_CONT', 'NO. KONTAINER')));
			$this->newtable->action(site_url() . "/monitoring/kontainer");
			$this->newtable->detail(array('DRILLDOWN', "monitoring/kontainer/detail/"));
			$this->newtable->tipe_proses('button');
			$this->newtable->hiddens(array("ID", "KON", "NSPK", "NO_DOK"));
			$this->newtable->keys(array("NSPK", "KON", "NO_DOK"));
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
			if ($this->input->post("ajax") || $act == "post")
				echo $tabel;
			else
				return $arrdata;
		} else {
			$page_title = "MONITORING KONTAINER";
			$title = "MONITORING KONTAINER";
			$this->newtable->breadcrumb('Dashboard', site_url(), 'icon-home');
			$this->newtable->breadcrumb('Monitoring', 'javascript:void(0)', '');
			$this->newtable->breadcrumb('Kontainer', 'javascript:void(0)', '');
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
			$this->newtable->search(array(array('NO_SPK', 'NO. SPK'), array('NO_CONT', 'NO. KONTAINER')));
			$this->newtable->action(site_url() . "/monitoring/kontainer");
			// $this->newtable->detail(array('DRILLDOWN',"monitoring/kontainer/detail/"));
			$this->newtable->tipe_proses('button');
			$this->newtable->hiddens(array("ID", "KON", "NSPK"));
			$this->newtable->keys(array("NSPK", "KON"));
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
			if ($this->input->post("ajax") || $act == "post")
				echo $tabel;
			else
				return $arrdata;
		}
	}

	public function list_delivery($act, $id)
	{
		$page_title = "MONITORING DELIVERY";
		$title = "MONITORING DELIVERY";
		$this->newtable->breadcrumb('Dashboard', site_url(), 'icon-home');
		$this->newtable->breadcrumb('Monitoring', 'javascript:void(0)', '');
		$this->newtable->breadcrumb('Delivery', 'javascript:void(0)', '');
		$check = (grant() == "W") ? true : false;
		//
		$SQL = "SELECT * FROM (SELECT a.NO_DOK,a.NO_CONT,c.KD_CONT_TIPE,C.UK_CONT,c.JNS_CONT,a.NM_KAPAL,a.NO_VOY,d.LOKASI,a.WK_REK,a.EXPIRED_DATE,b.PLUG_START_DATE,b.PLUG_END_DATE,a.NAMA_CUST
		FROM t_gatepass a
		LEFT JOIN (
		SELECT no_cont,PLUG_START_DATE,PLUG_END_DATE
		FROM req_delivery_dtl a
		WHERE a.PLUG_END_DATE IS NOT NULL
		GROUP BY no_cont) b ON a.NO_CONT = b.no_cont
		JOIN t_cocostscont c ON a.NO_CONT = c.NO_CONT
		JOIN t_spk_cont d ON a.NO_CONT = d.NO_CONT
		WHERE DATE(a.EXPIRED_DATE) >= DATE(NOW())
		GROUP BY no_cont) az WHERE 1=1";

		$this->newtable->multiple_search(true);
		$this->newtable->show_chk(false);
		$this->newtable->show_menu(false);
		$this->newtable->show_search(true);
		$proses = array('EXPORT GATEOUT DELIVERY' => array('EXCEL', "process/excel/delivery/" . $act, '0', '', 'md-file-text', '', 'menu'));
		$this->newtable->show_menu($check);
		$this->newtable->search(array(array('az.NO_CONT', 'NO. KONTAINER'), array('az.WK_REK', 'TERBIT GATEPASS', 'DATERANGE')));
		$this->newtable->action(site_url() . "/monitoring/delivery");
		//$this->newtable->detail(array('DRILLDOWN',"monitoring/kontainer/detail/"));
		$this->newtable->tipe_proses('button');
		//$this->newtable->keys(array("NSPK","KON"));
		$this->newtable->cidb($this->db);
		$this->newtable->sortby("DESC");
		$this->newtable->set_formid("tblmondel");
		$this->newtable->set_divid("divmondel");
		$this->newtable->rowcount(100);
		$this->newtable->clear();
		$this->newtable->menu($proses);
		$tabel .= $this->newtable->generate($SQL);
		$arrdata = array("page_title" => $page_title, "title" => $title, "content" => $tabel);
		if ($this->input->post("ajax") || $act == "post")
			echo $tabel;
		else
			return $arrdata;
	}

	public function list_jobslip($act, $id)
	{
		$page_title = "MONITORING JOB SLIP";
		$title = "MONITORING JOB SLIP";
		$this->newtable->breadcrumb('Dashboard', site_url(), 'icon-home');
		$this->newtable->breadcrumb('Monitoring', 'javascript:void(0)', '');
		$this->newtable->breadcrumb('Job Slip', 'javascript:void(0)', '');
		$check = (grant() == "W") ? true : false;
		/*$SQL = "SELECT ID_JOB_SLIP AS ID, JNS_JOB_SLIP AS 'JENIS JOB SLIP', NO_SPK AS 'NO. SPK', TGL_SPK AS 'TGL. SPK',NO_CONT AS 'NO. KONT', NO_GATEPASS AS 'NO. GATEPASS', TGL_GATEPASS AS 'TGL. GATEPASS', ROOM_AWAL AS 'ROOM AWAL', LOKASI_AWAL AS 'LOKASI AWAL',
			ROOM_AKHIR AS 'ROOM AKHIR', LOKASI_AKHIR AS 'LOKASI AKHIR'
			FROM t_job_slip WHERE LOKASI_AKHIR IS NOT NULL AND STATUS IS NULL";*/
		$SQL = "SELECT A.ID_JOB_SLIP AS ID, CONCAT(A.JNS_JOB_SLIP,'<BR>', IFNULL(A.JENIS,'-')) AS 'JENIS', CONCAT(A.NO_SPK,'<BR>', IFNULL(A.TGL_SPK,'-')) AS 'SPK', A.NO_CONT AS 'NO. KONTAINER', CONCAT(A.NO_GATEPASS,'<BR>', IFNULL(A.TGL_GATEPASS,'-')) AS 'GATEPASS', 
				CASE WHEN LEFT(A.LOKASI_AWAL,3) = 'CIC' THEN LOKASI_AWAL WHEN A.LOKASI_AWAL IS NULL THEN 'TERMINAL' ELSE CONCAT(A.LOKASI_AWAL,'0', A.TIER_AWAL) END AS 'LOKASI AWAL', 
				CASE WHEN LEFT(A.LOKASI_AKHIR,3) = 'CIC' THEN LOKASI_AKHIR WHEN A.LOKASI_AKHIR IS NULL THEN '-' ELSE CONCAT(A.LOKASI_AKHIR,'0', A.TIER_AKHIR) END AS 'LOKASI AKHIR',
				CONCAT('<span style=\"font-weight:bold\">',B.`STATUS`,'</SPAN>','<BR>', IFNULL(B.KETERANGAN,'-')) AS 'STATUS', A.WK_STATUS AS 'WAKTU STATUS', A.OPERATOR 
				FROM t_job_slip A
				LEFT JOIN reff_status_jobslip B ON A.KD_STATUS = B.ID";
		/*WHERE DATE_FORMAT(A.WK_STATUS,'%Y-%m-%d') = '2017-06-11'*/
		$this->newtable->multiple_search(true);
		$this->newtable->show_chk(false);
		$this->newtable->show_menu($check);
		$this->newtable->show_search(true);
		$this->newtable->search(array(array('A.JNS_JOB_SLIP', 'JENIS JOB SLIP'), array('A.NO_SPK', 'NO. SPK'), array('A.NO_CONT', 'NO. KONTAINER')));
		$this->newtable->action(site_url() . "/monitoring/jobslip");
		if ($check) $this->newtable->detail(array('DRILLDOWN', "/monitoring/jobslip/detail"));
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("ID"));
		$this->newtable->keys(array("ID"));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby("1");
		$this->newtable->sortby("DESC");
		$this->newtable->set_formid("tblmonitoring");
		$this->newtable->set_divid("divmonitoring");
		$this->newtable->rowcount(10);
		$this->newtable->clear();
		$this->newtable->menu($proses);
		$tabel .= $this->newtable->generate($SQL);
		$arrdata = array("page_title" => $page_title, "title" => $title, "content" => $tabel);
		if ($this->input->post("ajax") || $act == "post")
			return $tabel;
		else
			return $arrdata;
	}

	function list_karantina()
	{
		$page_title = "MONITORING KARANTINA";
		$title = "MONITORING KARANTINA";
		$this->newtable->breadcrumb('Dashboard', site_url(), 'icon-home');
		$this->newtable->breadcrumb('Monitoring', 'javascript:void(0)', '');
		$this->newtable->breadcrumb('KARANTINA', 'javascript:void(0)', '');
		$check = (grant() == "W") ? true : false;
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
		$this->newtable->search(array(array('A.NO_CONT', 'NO. CONT'), array('B.TGL_IJIN', 'TANGGAL IJIN', 'DATERANGE')));
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
		if ($this->input->post("ajax") || $act == "post")
			return $tabel;
		else
			return $arrdata;
	}

	function list_penarikan()
	{
		$page_title = "MONITORING PENARIKAN";
		$title = "MONITORING PENARIKAN";
		$this->newtable->breadcrumb('Dashboard', site_url(), 'icon-home');
		$this->newtable->breadcrumb('Monitoring', 'javascript:void(0)', '');
		$this->newtable->breadcrumb('PENARIKAN', 'javascript:void(0)', '');
		$check = (grant() == "W") ? true : false;
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
		$arr_sts = array("" => "", "" => "ON TERMINAL", "450" => "ON COMMON AREA");
		$this->newtable->search(array(array('A.STATUS_CONT', 'STATUS PENARIKAN', 'OPTION', $arr_sts), array('B.WK_REQ', 'TANGGAL REQUEST', 'DATERANGE')));
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
		if ($this->input->post("ajax") || $act == "post")
			return $tabel;
		else
			return $arrdata;
	}

	function list_longroom()
	{
		$page_title = "MONITORING LONGROOM";
		$title = "MONITORING LONGROOM";
		$this->newtable->breadcrumb('Dashboard', site_url(), 'icon-home');
		$this->newtable->breadcrumb('Monitoring', 'javascript:void(0)', '');
		$this->newtable->breadcrumb('LONGROOM', 'javascript:void(0)', '');
		$check = (grant() == "W") ? true : false;
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
		if ($this->input->post("ajax") || $act == "post")
			return $tabel;
		else
			return $arrdata;
	}

	//
	public function get_reqbehandle1($id)
	{
		$arrid = explode("~", $id);
		$id1 = $arrid[0];
		$id2 = $arrid[1];
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

	public function get_reqbehandle1New($id)
	{
		$arrid = explode("~", $id);
		$id1 = $arrid[0];
		$id2 = $arrid[1];
		$sql = $this->db->query(" 
			SELECT A.WK_SEND,C.NO_SPK,C.WK_REQ,A.WK_FINISH,A.OPERATOR
			FROM t_request A
			INNER JOIN t_request_cont B ON A.ID = B.ID
			INNER JOIN t_spk C ON A.NO_DOK = C.NO_DOK
			WHERE B.NO_CONT=  '$id2' AND C.NO_SPK = '$id1'
		");
		return $sql->row_array();
	}

	public function get_terbitspk($id)
	{
		$arrid = explode("~", $id);
		$id1 = $arrid[0];
		$id2 = $arrid[1];
		$sql = $this->db->query(" 
			SELECT COUNT(ID_HANDLE) AS JML, B.NAMA, A.ID_HANDLE, A.USER_PRINTS, A.TYPE_RPT,B.NAMA
			FROM hist_print A
			LEFT JOIN reff_user B ON A.USER_PRINTS = B.ID
			WHERE A.ID_HANDLE LIKE '%$id1%' AND TYPE_RPT = 'cetak_spk'
			GROUP BY USER_PRINTS 
		");
		return $sql->row_array();
	}

	public function get_terbitbehandle2($id)
	{
		$arrid = explode("~", $id);
		$id1 = $arrid[0];
		$id2 = $arrid[1];
		$sql2 = $this->db->query("SELECT ID FROM t_gatepass WHERE NO_CONT='$id2' AND JNS_KEGIATAN='2'")->row_array();
		$kunci = $sql2['ID'];
		$sql = $this->db->query(" 
			SELECT COUNT(ID_HANDLE) AS JML, B.NAMA, A.ID_HANDLE, A.USER_PRINTS, A.TYPE_RPT,B.NAMA
			FROM hist_print A
			LEFT JOIN reff_user B ON A.USER_PRINTS = B.ID
			WHERE A.ID_HANDLE LIKE '%$kunci%' AND TYPE_RPT = 'cetak_gbe'
			GROUP BY USER_PRINTS 
		");
		return $sql->row_array();
	}

	public function get_reqbehandle2($id)
	{
		$arrid = explode("~", $id);
		$id1 = $arrid[0];
		$id2 = $arrid[1];
		$sql = $this->db->query(" 
			SELECT JNS_DOK, NO_DOK, TGL_DOK, WK_REK
			FROM t_gatepass
			WHERE JNS_KEGIATAN = '2' AND NO_CONT='$id2'
		");
		return $sql->row_array();
	}

	public function get_pembehandle1($id)
	{
		$arrid = explode("~", $id);
		$id1 = $arrid[0];
		$id2 = $arrid[1];
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
	public function get_pembehandle2($id)
	{
		$arrid = explode("~", $id);
		$id1 = $arrid[0];
		$id2 = $arrid[1];
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

	public function get_penarikan($id)
	{
		$arrid = explode("~", $id);
		$id1 = $arrid[0];
		$id2 = $arrid[1];
		//codingan baru
		$sql = $this->db->query(" 
		SELECT a.wk_pickup AS 'pickup', b.ID_FLAT AS 'tid', a.WK_TERMINAL_IN , a.WK_TERMINAL_OUT, a.WK_IN AS 'behandlein', d.ROOM, d.NO_SEAL, d.ISO_CODE, d.OPERATOR, f.OPERATOR as 'oper'
		FROM t_operation a
		LEFT JOIN (select b.ID, b.NO_SPK, b.NO_DOK, b.TGL_DOK, h.NO_CONT, h.ID_FLAT from t_spk b inner join t_spk_cont h on b.ID = h.ID ) b ON a.NO_SPK = b.NO_SPK and a.NO_CONT = b.NO_CONT and a.NO_DOK = b.NO_DOK and a.TGL_DOK = b.TGL_DOK 
		LEFT JOIN t_op_behandlein d ON a.NO_SPK = d.NO_SPK  and a.NO_CONT = d.NO_CONT 
		LEFT JOIN t_op_pickup f ON a.NO_SPK = f.NO_SPK  and a.NO_CONT = f.NO_CONT 
		LEFT JOIN reff_kondisi e ON d.KONDISI_CONT = e.ID
		WHERE d.NO_CONT='$id2' AND d.NO_SPK='$id1' AND a.WK_IN IS NOT NULL ");
		//codingan lama
		// SELECT a.wk_pickup AS 'pickup', c.ID_FLAT AS 'tid', a.WK_TERMINAL_IN , a.WK_TERMINAL_OUT, a.WK_IN AS 'behandlein', d.ROOM, e.KONDISI, d.NO_SEAL, d.ISO_CODE, d.OPERATOR, f.OPERATOR as 'oper'
		// 	FROM t_operation a
		// 	LEFT JOIN t_spk b ON a.NO_SPK = b.NO_SPK
		// 	LEFT JOIN t_spk_cont c ON b.ID = c.ID
		// 	LEFT JOIN t_op_behandlein d ON a.NO_SPK = d.NO_SPK
		// 	LEFT JOIN t_op_pickup f ON a.NO_SPK = f.NO_SPK 
		// 	LEFT JOIN reff_kondisi e ON d.KONDISI_CONT = e.ID
		// 	WHERE d.NO_CONT='$id2' AND d.NO_SPK='$id1' AND a.WK_IN IS NOT NULL
		return $sql->row_array();
	}

	public function get_penarikanGOT($id)
	{
		$arrid = explode("~", $id);
		$id1 = $arrid[0];
		$id2 = $arrid[1];
		$sql = $this->db->query(" 
			SELECT a.WK_INOUT FROM t_cocostscont_new a LEFT JOIN t_spk_cont b ON a.NO_CONT = b.NO_CONT LEFT JOIN t_spk c ON b.ID = c.ID WHERE b.NO_CONT='$id2' AND a.DOK_INOUT ='4'
		");
		return $sql->row_array();
	}

	public function get_penarikanGIT($id)
	{
		$arrid = explode("~", $id);
		$id1 = $arrid[0];
		$id2 = $arrid[1];
		$sql = $this->db->query(" 
			SELECT a.WK_INOUT FROM t_cocostscont_new a LEFT JOIN t_spk_cont b ON a.NO_CONT = b.NO_CONT LEFT JOIN t_spk c ON b.ID = c.ID WHERE b.NO_CONT='$id2' AND a.DOK_INOUT ='3'
		");
		return $sql->row_array();
	}

	public function get_delivery($id)
	{
		$arrid = explode("~", $id);
		$id1 = $arrid[0];
		$id2 = $arrid[1];
		$id3 = $arrid[2];
		$SQL = "SELECT A.WK_TRUCKIN, A.OPERATOR_T, A.WK_CHASSIS, A.OPERATOR_O, A.WK_INSPECT, A.OPERATOR_I, A.WK_GATEOUT, A.OPERATOR_G, A.NO_SEAL, B.KONDISI
				FROM t_op_delivery A
				LEFT JOIN reff_kondisi B ON A.KONDISI_CONT = B.ID
				INNER JOIN t_gatepass C ON C.NO_CONT = A.NO_CONT
				WHERE A.NO_CONT='$id2' AND C.NO_DOK = '$id3' AND C.FL_BIL = 'DONE'and A.NO_SPK = '$id1' order by A.ID DESC";
		$sql = $this->db->query($SQL);
		return $sql->row_array();
	}

	public function get_behandle1($id)
	{
		$arrid = explode("~", $id);
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
				WHERE C.NO_CONT='$NO_CONT' AND (C.JNS_KEGIATAN = 1 OR C.JNS_KEGIATAN = 'JOIN')";
		$sql = $this->db->query($SQL);
		return $sql->row_array();
	}

	public function get_behandle2($id)
	{
		$arrid = explode("~", $id);
		$NO_SPK = $arrid[0];
		$NO_CONT = $arrid[1];
		$SQL = "SELECT A.JNS_DOK, A.NO_DOK, A.TGL_DOK, A.ID_REQ, A.TGL_REQ, A.EXPIRED, B.NAMA_CUST, C.JNS_KEGIATAN, A.OPERATOR
				FROM req_behandle_hdr A
				LEFT JOIN m_pelanggan B ON A.NPWP = B.NPWP
				LEFT JOIN req_behandle_dtl C ON A.ID_REQ = C.ID_REQ 
				WHERE C.NO_CONT='$NO_CONT' AND (C.JNS_KEGIATAN = 2 OR C.JNS_KEGIATAN = 'JOIN')";
		$sql = $this->db->query($SQL);
		return $sql->row_array();
	}

	public function get_reqdelivery($id)
	{
		$arrid = explode("~", $id);
		$id1 = $arrid[0];
		$id2 = $arrid[1];
		$id3 = $arrid[2];
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
				INNER JOIN t_gatepass d ON c.NO_CONT = d.NO_CONT
				WHERE c.NO_CONT='$id2' AND d.NO_DOK = '$id3' AND d.FL_BIL = 'DONE'";
		//echo $SQL;
		$RESULT = $this->db->query($SQL);
		return $RESULT->row_array();
	}

	public function get_delivext($id)
	{
		$arrid = explode("~", $id);
		$id1 = $arrid[0];
		$id2 = $arrid[1];
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

	public function get_data($act, $id)
	{
		$func = get_instance();
		$func->load->model("m_main", "main", true);
		if ($act == 'operation') {
			$arrid = explode("~", $id);
			$id1 = $arrid[0];
			$id2 = $arrid[1];
			/*$getJnsDok = "SELECT JNS_DOK FROM t_spk WHERE NO_SPK = '$id1'";
			$restultDok = $this->db->query($getJnsDok)->result_array();
			$jns_dokumen = $restultDok[0]['JNS_DOK'];
			if($jns_dokumen == 83){
				$data = "SELECT B.NO_CONT AS 'KONTAINER', F.CALL_SIGN, F.NM_ANGKUT AS 'NM_KAPAL', F.NO_VOY_FLIGHT AS 'NO_VOY', E.JNS_CONT, E.UK_CONT AS 'UKR_CONT', E.ISO_CODE, E.KD_CONT_TIPE, D.IMO, F.TGL_TIBA, E.WK_IN, I.NAMA, C.NO_DOK AS 'DOKUMEN', C.TGL_DOK  AS 'TANGGAL', C.CONSIGNEE, E.WK_OUT
			 			FROM t_ppk_hdr A
			 			LEFT JOIN t_ppk_cont B ON A.ID_IJIN = B.ID_IJIN
			 			LEFT JOIN t_request C ON A.NO_RESPON = C.NO_DOK
			 			LEFT JOIN t_request_cont D ON C.ID = D.ID AND B.NO_CONT = D.NO_CONT
			 			LEFT JOIN t_cocostscont E ON B.NO_CONT = E.NO_CONT AND D.NO_CONT = E.NO_CONT
			 			LEFT JOIN t_cocostshdr F ON E.ID = F.ID -- AND A.ANGKUTNAMA_TPS = F.NM_ANGKUT AND A.ANGKUTNO_TPS = F.NO_VOY_FLIGHT
			 			LEFT JOIN t_spk G ON A.NO_RESPON = G.NO_DOK 
			 			LEFT JOIN t_spk_cont H ON G.ID = H.ID AND B.NO_CONT = H.NO_CONT
			 			LEFT JOIN reff_kode_dok_bc I ON C.JNS_DOK = I.ID
			 			WHERE G.NO_SPK ='$id1' AND B.NO_CONT = '$id2'
			 			GROUP BY G.NO_SPK";
			}else{
				$data = "SELECT B.NO_CONT AS 'KONTAINER', F.CALL_SIGN, F.NM_ANGKUT AS 'NM_KAPAL', F.NO_VOY_FLIGHT AS 'NO_VOY', E.JNS_CONT, E.UK_CONT AS 'UKR_CONT',E.ISO_CODE, E.KD_CONT_TIPE, D.IMO, F.TGL_TIBA, E.WK_IN, I.NAMA, C.NO_DOK AS 'DOKUMEN', C.TGL_DOK  AS 'TANGGAL', C.CONSIGNEE, E.WK_OUT
			 			FROM t_permit_hdr A
			 			LEFT JOIN t_permit_cont B ON A.ID = B.ID
			 			LEFT JOIN t_request C ON A.NO_DAFTAR_PABEAN = C.NO_DOK
			 			LEFT JOIN t_request_cont D ON C.ID = D.ID AND B.NO_CONT = D.NO_CONT
			 			LEFT JOIN t_cocostscont E ON B.NO_CONT = E.NO_CONT AND D.NO_CONT = E.NO_CONT
			 			LEFT JOIN t_cocostshdr F ON E.ID = F.ID -- AND A.ANGKUTNAMA_TPS = F.NM_ANGKUT AND A.ANGKUTNO_TPS = F.NO_VOY_FLIGHT
			 			LEFT JOIN t_spk G ON A.NO_DAFTAR_PABEAN = G.NO_DOK 
			 			LEFT JOIN t_spk_cont H ON G.ID = H.ID AND B.NO_CONT = H.NO_CONT
			 			LEFT JOIN reff_kode_dok_bc I ON C.JNS_DOK = I.ID
			 			WHERE G.NO_SPK ='$id1' AND B.NO_CONT = '$id2'
			 			GROUP BY G.NO_SPK";
			}*/
			// echo $id1.' '.$id2; die();
			// 			$data = "SELECT A.NO_SPK, B.NO_CONT AS 'KONTAINER', D.CALL_SIGN, D.NM_ANGKUT AS 'NM_KAPAL',
			//        D.NO_VOY_FLIGHT AS 'NO_VOY', C.JNS_CONT, C.UK_CONT AS 'UKR_CONT',
			//        CONCAT(C.KD_CONT_TIPE, ' ', IFNULL(F.STATUS_DG, '')) AS 'KD_CONT_TIPE',
			//        F.ISO_CODE, F.IMO, D.TGL_TIBA, C.WK_IN, G.NAMA,
			//        A.NO_DOK AS 'DOKUMEN', A.TGL_DOK AS 'TANGGAL', E.CONSIGNEE, C.WK_OUT
			// FROM t_spk A
			// LEFT JOIN t_spk_cont B ON B.ID = A.ID
			// LEFT JOIN (
			//     SELECT X.*
			//     FROM t_cocostscont X
			//     JOIN (
			//         SELECT NO_CONT, MAX(ID) AS MaxID
			//         FROM t_cocostscont
			//         GROUP BY NO_CONT
			//     ) Y ON X.NO_CONT = Y.NO_CONT AND X.ID = Y.MaxID
			// ) C ON B.NO_CONT = C.NO_CONT
			// LEFT JOIN t_cocostshdr D ON C.ID = D.ID
			// LEFT JOIN t_request E ON E.NO_DOK = A.NO_DOK AND E.TGL_DOK = A.TGL_DOK
			// LEFT JOIN t_request_cont F ON F.ID = E.ID AND F.NO_CONT = B.NO_CONT
			// LEFT JOIN reff_kode_dok_bc G ON A.JNS_DOK = G.ID
			// INNER JOIN t_operation H ON A.NO_SPK = H.NO_SPK AND A.NO_DOK = H.NO_DOK
			// WHERE A.NO_SPK = '$id1' AND B.NO_CONT = '$id2'
			// GROUP BY B.NO_CONT
			// ORDER BY C.ID DESC";

			$data = "SELECT
				A.NO_SPK,
				B.NO_CONT AS 'KONTAINER',
				E.CALL_SIGN,
				E.NM_ANGKUT AS 'NM_KAPAL',
				E.NO_VOY_FLIGHT AS 'NO_VOY',
				EE.JNS_CONT, EE.UK_CONT AS 'UKR_CONT',
				CONCAT(EE.KD_CONT_TIPE, ' ', IFNULL(D.STATUS_DG, '')) AS 'KD_CONT_TIPE',
				D.ISO_CODE, D.IMO, E.TGL_TIBA,
				EE.WK_IN, AA.NAMA,
				A.NO_DOK AS 'DOKUMEN', A.TGL_DOK AS 'TANGGAL', C.CONSIGNEE, EE.WK_OUT
			from t_spk A join t_spk_cont B on A.ID = B.ID
			left join reff_kode_dok_bc AA on A.JNS_DOK = AA.ID
			join t_request C on A.NO_DOK = C.NO_DOK and A.TGL_DOK = C.TGL_DOK
			join t_request_cont D on C.ID = D.ID and D.NO_CONT = B.NO_CONT
			left join t_cocostshdr E on D.VESSEL = E.NM_ANGKUT and D.VOY_IN = E.NO_VOY_FLIGHT 
			left join t_cocostscont EE on E.ID = EE.ID and B.NO_CONT = EE.NO_CONT
			left join t_operation F on A.NO_SPK = F.NO_SPK and B.NO_CONT = F.NO_CONT
			WHERE A.NO_SPK = '$id1' AND B.NO_CONT = '$id2'";
			// echo $data;DIE();
			$sql = $this->db->query($data);

			return $sql->result();
		} elseif ($act == 'detail_job') {
			//$arrid = explode("~",$id);
			//$id1=$arrid[0];
			//$id2=$arrid[1];
			//echo $id1.' '.$id2; die();
			$sql = $this->db->query("SELECT A.ID_JOB_SLIP AS 'ID',CONCAT('<span style=\"font-weight:bold\">',B.`STATUS`,'</SPAN>','<BR>', IFNULL(B.KETERANGAN,'-')) AS 'STATUS', A.WK_STATUS AS 'WAKTU_STATUS', A.OPERATOR FROM t_job_slip_status A
									LEFT JOIN reff_status_jobslip B ON A.KD_STATUS = B.ID
									WHERE A.ID_JOB_SLIP = '$id' ORDER BY A.WK_STATUS DESC");
			return $sql->result();
		} elseif ($act == 'penarikan') {
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
		} elseif ($act == 'longroom') {
			$SQL = "SELECT B.NO_SPK, A.STATUS_CONT, A.NO_CONT,A.UKR_CONT,CASE WHEN I.JNS_CONT = 'F' THEN 'FULL' ELSE 'EMPTY' END AS 'JNS_CONT',G.NAMA,C.NO_DOK, C.TGL_DOK,A.LOKASI,A.TIER,C.JNS_KEGIATAN,B.CONSIGNEE, C.RESPON, C.WK_RESPON, 
					CASE WHEN A.STATUS_CONT = '460' AND F.START_INSP IS NULL AND F.FINISH_INSP IS NULL AND C.JNS_KEGIATAN ='1' AND C.RESPON IS NOT NULL THEN 'SIAP PERIKSA' 
					WHEN A.STATUS_CONT ='460' AND C.JNS_KEGIATAN='2' AND C.RESPON IS NOT NULL  THEN 'SIAP PERIKSA'
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
					LEFT JOIN (SELECT NO_CONT, JNS_CONT, ISO_CODE FROM t_cocostscont GROUP BY NO_CONT ORDER BY ID DESC) AS I ON A.NO_CONT = I.NO_CONT
					WHERE A.STATUS_CONT IN('460','500','510','530','540','520') AND C.FL_ACTIVE = 'Y'  
					GROUP BY A.NO_CONT
					ORDER BY CASE WHEN C.RESPON IS NOT NULL AND KETERANGAN ='ANTRIAN PERIKSA' THEN 1 WHEN C.RESPON IS NULL AND KETERANGAN='ANTRIAN PERIKSA' THEN 2 ELSE 3 END ASC, CASE WHEN F.START_INSP IS NOT NULL AND F.FINISH_INSP IS NULL THEN 3 WHEN A.STATUS_CONT = '460' THEN 2 WHEN A.STATUS_CONT IN ('500','540','520') THEN 4 WHEN C.FL_ACTIVE = 'Y' THEN 1 ELSE 0 END ASC,
					C.WK_RESPON ASC,C.WK_ACTIVE ASC";
			$QUERY = $this->db->query($SQL);
			return $QUERY->result();
		} elseif ($act == 'pemeriksaan_behandle1') {
			$arrid = explode("~", $id);
			$id1 = $arrid[0];
			$id2 = $arrid[1];
			$SQL = "SELECT A.ID_JOB_SLIP,A.NO_SPK,A.KD_STATUS,A.WK_STATUS,A.LOKASI_AWAL,A.TIER_AWAL,A.LOKASI_AKHIR,A.TIER_AKHIR,A.OPERATOR
					FROM t_job_slip A
					WHERE A.KD_STATUS = 50 AND A.NO_CONT = '$id2'  AND A.NO_SPK='$id1'  AND A.LOKASI_AKHIR LIKE'%CIC%' AND A.JENIS='BEHANDLE 1'";
			//echo $SQL;
			$QUERY = $this->db->query($SQL);
			return $QUERY->result();
		} elseif ($act == 'm_exb1') {
			$arrid = explode("~", $id);
			$id1 = $arrid[0];
			$id2 = $arrid[1];
			$SQL = "SELECT A.ID_JOB_SLIP,A.NO_SPK,A.KD_STATUS,A.WK_STATUS,A.LOKASI_AWAL,A.TIER_AWAL,A.LOKASI_AKHIR,A.TIER_AKHIR,A.OPERATOR
					FROM t_job_slip A
					WHERE A.KD_STATUS = 50 AND A.NO_CONT = '$id2' AND A.NO_SPK='$id1' AND A.LOKASI_AWAL LIKE'%CIC%' AND A.JENIS='EX BEHANDLE 1'
				";
			$QUERY = $this->db->query($SQL);
			return $QUERY->result();
		} elseif ($act == 'm_behandle2') {
			$arrid = explode("~", $id);
			$id1 = $arrid[0];
			$id2 = $arrid[1];
			$SQL = "SELECT A.ID_JOB_SLIP,A.NO_SPK,A.KD_STATUS,A.WK_STATUS,A.LOKASI_AWAL,A.TIER_AWAL,A.LOKASI_AKHIR,A.TIER_AKHIR,A.OPERATOR
					FROM t_job_slip A
					WHERE A.KD_STATUS = 50 AND A.NO_CONT = '$id2'  AND A.NO_SPK='$id1'  AND A.LOKASI_AKHIR LIKE'%CIC%' AND A.JENIS='BEHANDLE 2'";
			$QUERY = $this->db->query($SQL);
			return $QUERY->result();
		} elseif ($act == 'm_exb2') {
			$arrid = explode("~", $id);
			$id1 = $arrid[0];
			$id2 = $arrid[1];
			$SQL = "SELECT A.ID_JOB_SLIP,A.NO_SPK,A.KD_STATUS,A.WK_STATUS,A.LOKASI_AWAL,A.TIER_AWAL,A.LOKASI_AKHIR,A.TIER_AKHIR,A.OPERATOR
					FROM t_job_slip A
					WHERE A.KD_STATUS = 50 AND A.NO_CONT = '$id2'  AND A.NO_SPK='$id1'  AND A.LOKASI_AWAL LIKE'%CIC%' AND A.JENIS='EX BEHANDLE 2'";
			$QUERY = $this->db->query($SQL);
			return $QUERY->result();
		} elseif ($act == 'cek_m_exb2') {
			$arrid = explode("~", $id);
			$id1 = $arrid[0];
			$id2 = $arrid[1];

			$SQL = "SELECT A.ID_JOB_SLIP,A.NO_SPK,A.KD_STATUS,A.WK_STATUS,A.LOKASI_AKHIR,A.LOKASI_AWAL,A.TIER_AWAL,A.TIER_AKHIR
					FROM t_job_slip A
					WHERE A.KD_STATUS = 50 AND A.NO_CONT = '$id2'  AND A.NO_SPK='$id1'  AND A.JENIS = 'EX BEHANDLE 2' -- LOKASI_AWAL LIKE'%CIC%'";

			$QUERY = $this->db->query($SQL);
			return $QUERY->result();
		} elseif ($act == 'filterLongroom') {
			$arrid = explode("~", $id);
			$kode_dok = $arrid[0];
			$kode_status = $arrid[1];

			if ($kode_dok != "") {
				if ($kode_dok == 'bc') {
					$kode_dokumen = '81,82,19,13,44,43';
				} else {
					$kode_dokumen = '83';
				}
				$jns_dok = "AND B.JNS_DOK IN($kode_dokumen)";
			} else {
				$jns_dok = "";
			}
			if ($kode_status != "") {
				if ($kode_status == "100L") {
					$kode_status = "AND C.FL_ACTIVE = 'Y' AND F.START_INSP IS NOT NULL AND F.FINISH_INSP IS NOT NULL";
				} elseif ($kode_status == "200L") {
					$kode_status = "AND F.START_INSP IS NOT NULL AND F.FINISH_INSP IS NULL";
				} else {
					$kode_status = "AND A.STATUS_CONT = '$kode_status'";
				}
			} else {
				$kode_status = "";
			}

			if (!empty($jns_dok) || !empty($kode_status)) {
				$SQL = "SELECT B.NO_SPK, A.STATUS_CONT, A.NO_CONT,A.UKR_CONT,C.WK_ACTIVE,G.NAMA,A.LOKASI,A.TIER,C.JNS_KEGIATAN,B.CONSIGNEE, CASE WHEN A.STATUS_CONT = '460' THEN '<span class=\'label label-warning\'>SIAP PERIKSA</span>' WHEN A.STATUS_CONT IN ('500','540') THEN '<span class=\'label label-success\'>SELESAI PERIKSA</span>' ELSE '<span class=\'label label-danger\'>ANTRIAN PERIKSA</span>' END AS KETERANGAN, CASE WHEN F.START_INSP IS NOT NULL AND F.FINISH_INSP IS NULL THEN 'SEDANG PERIKSA' ELSE 'ANTRIAN PERIKSA' END AS KETERANGAN2, CASE WHEN C.FL_ACTIVE = 'Y' THEN 'ANTRIAN PERIKSA' ELSE '-' END AS KETERANGAN3, -- E.KETERANGAN, 
						F.START_INSP FROM t_spk_cont A
						LEFT JOIN t_spk B ON A.ID = B.ID
						LEFT JOIN t_gatepass C ON A.NO_CONT = C.NO_CONT --  AND C.`STATUS` = 'WAITING' AND C.FL_ACTIVE = 'Y'
						INNER JOIN t_request D ON C.NO_DOK = D.NO_DOK
						LEFT JOIN reff_status_spk E ON A.STATUS_CONT = E.ID
						LEFT JOIN t_op_inspection F ON F.NO_CONT = A.NO_CONT AND F.FINISH_INSP IS NULL
						LEFT JOIN reff_kode_dok_bc G ON D.JNS_DOK = G.ID
						WHERE A.STATUS_CONT IN('460','500','510','530','540') AND C.FL_ACTIVE = 'Y' " . $jns_dok . " " . $kode_status . " -- AND C.`STATUS` = 'WAITING'
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
			if ($resultLongroom) {
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
				foreach ($SQL->result_array() as $dtl) {
					$no++;
					if ($no % 2 == 1) {
						$class = "style='background-color:#FFFFFF;line-height: 20px;'";
					} else {
						$class = "style='background-color: #f1f1ff;line-height: 20px;'";
					}

					if ($no % 2 == 1) {
						$class = "contentGanjil";
					} else {
						$class = "contentGenap";
					}

					if ($dtl['KETERANGAN2'] == 'SEDANG PERIKSA') {
						$status = "<span class='label label-primary'>SEDANG PERIKSA</span>";
					} elseif ($dtl['KETERANGAN3'] == 'ANTRIAN PERIKSA') {
						if ($dtl['KETERANGAN'] != 'SIAP PERIKSA') {
							$status = $dtl['KETERANGAN']; //"<span class='label label-danger'>$dtl[KETERANGAN]</span>";//
						} elseif ($dtl['KETERANGAN'] == 'SIAP PERIKSA') {
							$status = $dtl['KETERANGAN']; //"<span class='label label-danger'>$dtl[KETERANGAN]</span>";//$dtl['KETERANGAN'];
						} else {
							$status = "<span class='label label-danger'>ANTRIAN PERIKSA</span>";
						}
					} else {
						$status = $dtl['KETERANGAN']; //"<span class='label label-danger'>$dtl[KETERANGAN]</span>";//
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
		} elseif ($act == 'cetak_monitor') {
			$arrid = explode("~", $id);
			$id1 = $arrid[0];
			$id2 = $arrid[1];

			$SQL = $this->db->query("SELECT * FROM t_op_reefer WHERE NO_CONT='$id2' AND NO_SPK='$id1' ORDER BY ID ASC LIMIT 1");
			return $SQL->row_array();
		} elseif ($act == 'monitor_cont') {
			$arrid = explode("~", $id);
			$id1 = $arrid[0];
			$id2 = $arrid[1];

			$SQL = $this->db->query("SELECT * FROM t_op_reefer WHERE NO_CONT='$id2' AND NO_SPK='$id1' AND WAKTU_MONITOR IS NOT NULL ORDER BY ID ASC");
			return $SQL->result_array();
		} elseif ($act == 'cetak_utama') {
			$arrid = explode("~", $id);
			$id1 = $arrid[0];
			$id2 = $arrid[1];

			$SQL = $this->db->query("SELECT B.TEMP_CUST,B.PLUG_TERMINAL,B.UNPLUG_TERMINAL 
			from (SELECT a.no_spk,a.NO_DOK,a.TGL_DOK,b.no_cont FROM t_spk a JOIN t_spk_cont b ON a.id = b.id) C
			JOIN (SELECT a.NO_DOK,a.TGL_DOK,b.* FROM t_request a JOIN t_request_cont b ON a.id = b.id) B ON B.no_dok = C.no_dok AND B.tgl_dok = C.tgl_dok AND B.no_cont = C.no_cont
			WHERE C.no_cont = '$id2' AND C.no_spk = '$id1'");
			return $SQL->row_array();
		}
	}

	public function filter($act, $key)
	{
		if ($act == 'penarikan') {
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

	public function monitor_reefer($act, $id)
	{
		$page_title = "MONITORING REEFER";
		$title = "MONITORING REEFER";
		$this->newtable->breadcrumb('Dashboard', site_url(), 'icon-home');
		$this->newtable->breadcrumb('Monitoring', 'javascript:void(0)', '');
		$this->newtable->breadcrumb('REEFER', 'javascript:void(0)', '');

		$check = (grant() == "W") ? true : false;


		$SQL = "SELECT A.ID AS 'ID', A.NO_SPK AS 'NO SPK', A.NO_CONT AS 'KONTAINER', B.TEMP_CUST AS 'TEMPERATURE DEFAULT', CONCAT('WAKTU PLUG IN TERMINAL : ', IFNULL(B.PLUG_TERMINAL,'-'),'<BR> WAKTU PLUG IN CA : ', IFNULL(A.WAKTU,'-'),'<BR>User : ', IFNULL(A.OPERATOR_START,'-')) AS 'PLUG KONTAINER', A.TEMPERATURE_AWAL AS 'TEMPERATURE AWAL', CONCAT('WAKTU PLUG OUT TERMINAL : ', IFNULL(B.UNPLUG_TERMINAL,'-'),'<BR>WAKTU PLUG OUT CA : ', IFNULL(A.WAKTU_END,'-'),'<BR>User : ', IFNULL(A.OPERATOR_END,'-')) AS 'UNPLUG KONTAINER', A.TEMPERATURE_AKHIR AS 'TEMPERATURE AKHIR', A.NO_SPK AS 'NSPK', A.NO_CONT AS 'KON'
		FROM t_op_reefer A
		JOIN (SELECT a.no_spk,a.NO_DOK,a.TGL_DOK,b.no_cont FROM t_spk a JOIN t_spk_cont b ON a.id = b.id) C on C.no_spk = A.no_Spk AND C.no_cont = A.no_cont
		JOIN (SELECT a.NO_DOK,a.TGL_DOK,b.* FROM t_request a JOIN t_request_cont b ON a.id = b.id) B ON B.no_dok = C.no_dok AND B.tgl_dok = C.tgl_dok AND B.no_cont = C.no_cont
		WHERE 1=1";
		// $SQL = "SELECT A.ID AS 'ID',CONCAT('',(B.NO_CONT),'<BR>',(B.UKR_CONT)) AS 'KONTAINER', CASE WHEN LEFT(B.LOKASI,3) = 'CIC' THEN B.LOKASI ELSE CONCAT(B.LOKASI,'0', TIER) END AS 'LOKASI', B.NO_CONT AS 'KON', A.NO_SPK AS 'NSPK', A.NO_DOK AS 'DOK',
		// CONCAT('',(A.NO_SPK),'<BR>',(A.TGL_SPK)) AS 'SPK',
		// C.KETERANGAN AS 'STATUS' FROM t_spk A, t_spk_cont B
		// INNER JOIN reff_status_spk C ON C.ID = B.STATUS_CONT WHERE A.ID = B.ID";
		//echo $SQL;die();
		$proses = array('CETAK'  => array('PRINT', "Monitoring/reefer/cetak_monitoring", '1', '', 'md-print', '', 'list'));

		$this->newtable->multiple_search(true);
		$this->newtable->show_chk(false);
		$this->newtable->show_menu(false);
		$this->newtable->show_search(true);
		$this->newtable->show_menu($check);
		$this->newtable->search(array(array('A.NO_SPK', 'NO. SPK'), array('B.NO_CONT', 'NO. KONTAINER')));
		$this->newtable->action(site_url() . "/monitoring/reefer");
		$this->newtable->detail(array('DRILLDOWN', "monitoring/reefer/detail/"));
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("ID", "NSPK", "KON"));
		$this->newtable->keys(array("NSPK", "KON"));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby("ID");
		$this->newtable->groupby(array("A.NO_SPK", "A.NO_CONT"));
		$this->newtable->sortby("DESC");
		$this->newtable->set_formid("tblkontainerreefer");
		$this->newtable->set_divid("divkontainerreefer");
		$this->newtable->rowcount(10);
		$this->newtable->clear();
		$this->newtable->menu($proses);
		$tabel .= $this->newtable->generate($SQL);
		$arrdata = array("page_title" => $page_title, "title" => $title, "content" => $tabel);
		if ($this->input->post("ajax") || $act == "post")
			echo $tabel;
		else
			return $arrdata;
	}

	public function monitor_plug($id)
	{
		$arrid = explode("~", $id);
		$id1 = $arrid[0];
		$id2 = $arrid[1];

		$sql = $this->db->query("SELECT * FROM t_op_reefer WHERE NO_CONT='$id2' AND NO_SPK='$id1' AND WAKTU_MONITOR IS NOT NULL ORDER BY ID DESC");
		return $sql->result_array();
	}

	public function pkb_monitor($act, $id)
	{
		$page_title = "MONITORING PKB";
		$title = "MONITORING PKB";
		$this->newtable->breadcrumb('Dashboard', site_url(), 'icon-home');
		$this->newtable->breadcrumb('Monitoring', 'javascript:void(0)', '');
		$this->newtable->breadcrumb('PKB', 'javascript:void(0)', '');
		$check = (grant() == "W") ? true : false;
		//
		$SQL = "SELECT DISTINCT A.ID, B.NO_CONT AS 'KONTAINER', B.UKR_CONT AS 'SIZE', C.JNS_DOK AS 'JENIS_DOKUMEN', C.NO_DOK AS DOKUMEN,
					DATE_FORMAT(C.WK_ACTIVE, '%d-%m-%Y %h:%m:%s') AS 'WK_ACTIVE', CONCAT(B.LOKASI,B.TIER) AS LOKASI, CONCAT('BEHANDLE ',C.JNS_KEGIATAN) AS 'KETERANGAN',
					C.NAMA_CUST AS 'CUSTOMER',
					CASE
						WHEN B.STATUS_CONT IN (450,510,530) AND C.RESPON IS NULL THEN '<span class=\"label label-danger\">BELUM PKB</span>'
						WHEN B.STATUS_CONT IN (450,510,530) AND C.RESPON IS NOT NULL THEN '<span class=\"label label-danger\">PKB</span>'
						WHEN B.STATUS_CONT = 460 AND D.START_INSP IS NULL AND D.FINISH_INSP IS NULL  AND C.RESPON IS NOT NULL THEN '<span class=\"label label-warning\">SIAP PERIKSA</span>'
						WHEN B.STATUS_CONT = 460 AND D.START_INSP IS NOT NULL AND D.FINISH_INSP IS NULL THEN '<span class=\"label label-primary\">SEDANG PERIKSA</span>' 
						WHEN B.STATUS_CONT IN (500,540,520) THEN '<span class=\"label label-success\">SELESAI PERIKSA</span>' 
						ELSE '' 
					END AS STATUS, 
					CASE 
						WHEN C.RESPON = 'PKB' THEN '<span class=\"label label-success\">PKB</span>'
						ELSE '<span class=\"label label-danger\">PERCEPATAN</span>'
					END AS 'RESPON',
					DATE_FORMAT(C.WK_RESPON, '%d-%m-%Y %H:%i:%s') AS 'WAKTU_PKB'
					FROM t_spk A
					INNER JOIN t_spk_cont B ON A.ID = B.ID
					INNER JOIN t_gatepass C ON B.NO_CONT = C.NO_CONT AND C.STATUS = 'WAITING' AND C.FL_ACTIVE = 'Y' AND C.JNS_DOK !='SPPMP'
					LEFT JOIN t_op_inspection D ON D.NO_CONT = B.NO_CONT AND C.NO_DOK = D.NO_DOK
					WHERE B.STATUS_CONT IN(460,510,530,500,510,540,520)";
		$this->newtable->multiple_search(true);
		$this->newtable->show_chk(false);
		$this->newtable->show_menu(false);
		$this->newtable->show_search(false);
		// $proses = array('EXPORT GATEOUT DELIVERY' => array('EXCEL',"process/excel/delivery/".$act, '0','','md-file-text','','menu'));
		$this->newtable->show_menu($check);
		// $this->newtable->search(array(array('A.NO_CONT','NO. KONTAINER'),array('C.NO_DOK','NO. DOKUMEN')));
		$this->newtable->action(site_url() . "/monitoring/monitor_pkb");
		//$this->newtable->detail(array('DRILLDOWN',"monitoring/kontainer/detail/"));
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("ID"));
		//$this->newtable->keys(array("NSPK","KON"));
		$this->newtable->cidb($this->db);
		$this->newtable->groupby(array("B.NO_CONT"));
		$this->newtable->orderby("CASE
				WHEN B.STATUS_CONT IN (450,510,530) AND C.RESPON IS NOT NULL THEN 1 -- PKB
				WHEN B.STATUS_CONT IN (450,510,530) AND C.RESPON IS NULL THEN 2 -- BELUM PKB
				WHEN B.STATUS_CONT = 460 AND D.START_INSP IS NULL AND D.FINISH_INSP IS NULL  AND C.RESPON IS NOT NULL THEN 3 -- SIAP PERIKSA
				WHEN B.STATUS_CONT = 460 AND D.START_INSP IS NOT NULL AND D.FINISH_INSP IS NULL THEN 4 -- SEDANG PERIKSA
				ELSE 5 -- SELESAI PERIKSA
			END ASC,
			C.WK_RESPON ASC,C.WK_ACTIVE ASC");
		$this->newtable->sortby();
		$this->newtable->set_formid("tblmonitorpkb");
		$this->newtable->set_divid("divmonitorpkb");
		$this->newtable->rowcount(100);
		$this->newtable->clear();
		$this->newtable->menu($proses);
		$tabel .= $this->newtable->generate($SQL);
		$arrdata = array("page_title" => $page_title, "title" => $title, "content" => $tabel);
		if ($this->input->post("ajax") || $act == "post")
			echo $tabel;
		else
			return $arrdata;
	}

	function process($type, $act, $id)
	{ //print_r($type.$act);die();
		$func = get_instance();
		$func->load->model("m_main", "main", true);
		$success = 0;
		$error = 0;
		$USERLOGIN = $this->session->userdata('USERLOGIN');
		$KD_TPS = $this->session->userdata('KD_TPS');
		$KD_GUDANG = $this->session->userdata('KD_GUDANG');
		if ($type == "excel") {
			if ($act == "penarikan") {
				$no_kon = $this->input->post('form[0]');
				$tgl_nota = $this->input->post('form[1]');
				$tgl_start = $tgl_nota[0];
				$tgl_end = $tgl_nota[1];
				$no_kon1 = $no_kon[0];
				$addsql = "";

				if ($tgl_start != "" and $tgl_end != "") {
					//$addsql .= " AND DATE(B.TGL_SPK) BETWEEN '$tgl_start' AND '$tgl_end'";
					$addsql .= " AND A.WK_REQ BETWEEN '$tgl_start' AND '$tgl_end' ORDER BY A.ID DESC";
				} else if ($tgl_start != "") {
					//$addsql .= " AND DATE(B.TGL_SPK) >= '$tgl_start'";
					$addsql .= " AND A.WK_REQ >= '$tgl_start' ORDER BY A.ID DESC";
				} else if ($tgl_end != "") {
					//$addsql .= " AND DATE(B.TGL_SPK) <= '$tgl_end'";
					$addsql .= " AND A.WK_REQ <= '$tgl_end' ORDER BY A.ID DESC";
				} else {
					$addsql .= " ORDER BY A.ID DESC";
				}

				$tgl_awal = date("d/m/Y H:i", strtotime($tgl_start));
				$tgl_akhir = date("d/m/Y H:i", strtotime($tgl_end));

				// $SQL = "SELECT A.NO_SPK, B.NO_CONT, B.UKR_CONT AS 'SIZE', 'I' AS CLASS, D.CALL_SIGN AS 'KD_KAPAL', D.NM_ANGKUT, D.NO_VOY_FLIGHT AS 'NO_VOY', CASE WHEN C.STATUS_CONT ='F' THEN 'FL' ELSE 'MT' END AS 'STATUS_CONT', C.ISO_CODE, C.TIPE_CONT, F.IMO, D.TGL_TIBA AS 'ARRIVAL', C.STACKING, E.NAMA AS 'JNS_DOK', A.NO_DOK, A.TGL_DOK, G.WK_SEND AS 'REQUEST_GATEPASS', G.WK_FINISH AS 'APPROVE_GATEPASS', A.WK_REQ AS 'TERBIT_SPK', A.CONSIGNEE AS 'CUSTOMERS'
				// 	FROM t_spk A
				// 	INNER JOIN t_spk_cont B ON A.ID = B.ID
				// 	LEFT JOIN (SELECT ID, NO_CONT, JNS_CONT AS 'STATUS_CONT', ISO_CODE, KD_CONT_TIPE AS 'TIPE_CONT', WK_IN AS 'STACKING' FROM t_cocostscont GROUP BY NO_CONT ORDER BY ID DESC) C ON B.NO_CONT = C.NO_CONT
				// 	LEFT JOIN t_cocostshdr D ON C.ID = D.ID
				// 	INNER JOIN reff_kode_dok_bc E ON A.JNS_DOK = E.ID
				// 	LEFT JOIN (SELECT ID, NO_CONT, IMO FROM t_request_cont GROUP BY NO_CONT ORDER BY ID DESC) F ON B.NO_CONT = F.NO_CONT
				// 	LEFT JOIN t_request G ON F.ID = G.ID
				// 	WHERE 1 = 1".$addsql; 

				// $SQL1 = "SELECT 
				// 	COUNT(IF(B.UKR_CONT = '20' AND E.NAMA = 'SPPMP' AND C.JNS_CONT = 'F', C.NO_CONT, NULL)) AS 'SPPMP_20_FL', 
				// 	COUNT(IF(B.UKR_CONT = '20' AND E.NAMA = 'SPPMP' AND C.JNS_CONT != 'F', C.NO_CONT, NULL)) AS 'SPPMP_20_MT', 
				// 	COUNT(IF(B.UKR_CONT = '40' AND E.NAMA = 'SPPMP' AND C.JNS_CONT = 'F', C.NO_CONT, NULL)) AS 'SPPMP_40_FL', 
				// 	COUNT(IF(B.UKR_CONT = '40' AND E.NAMA = 'SPPMP' AND C.JNS_CONT != 'F', C.NO_CONT, NULL)) AS 'SPPMP_40_MT', 
				// 	COUNT(IF(B.UKR_CONT = '45' AND E.NAMA = 'SPPMP' AND C.JNS_CONT = 'F', C.NO_CONT, NULL)) AS 'SPPMP_45_FL', 
				// 	COUNT(IF(B.UKR_CONT = '45' AND E.NAMA = 'SPPMP' AND C.JNS_CONT != 'F', C.NO_CONT, NULL)) AS 'SPPMP_45_MT', 
				// 	COUNT(IF(B.UKR_CONT IN ('20','40','45') AND E.NAMA = 'SPPMP', C.NO_CONT, NULL)) AS 'TOTAL_SPPMP', 
				// 	COUNT(IF(B.UKR_CONT = '20' AND E.NAMA = 'SPPMP', C.NO_CONT, NULL)) * 1 + COUNT(IF(B.UKR_CONT = '40' AND E.NAMA = 'SPPMP', C.NO_CONT, NULL)) * 2 + COUNT(IF(B.UKR_CONT = '45' AND E.NAMA = 'SPPMP', C.NO_CONT, NULL)) * 2.25 AS 'SPPMP_TEUS',
				// 	COUNT(IF(B.UKR_CONT = '20' AND E.NAMA = 'SPJM' AND C.JNS_CONT = 'F', C.NO_CONT, NULL)) AS 'SPJM_20_FL', 
				// 	COUNT(IF(B.UKR_CONT = '20' AND E.NAMA = 'SPJM' AND C.JNS_CONT != 'F', C.NO_CONT, NULL)) AS 'SPJM_20_MT', 
				// 	COUNT(IF(B.UKR_CONT = '40' AND E.NAMA = 'SPJM' AND C.JNS_CONT = 'F', C.NO_CONT, NULL)) AS 'SPJM_40_FL', 
				// 	COUNT(IF(B.UKR_CONT = '40' AND E.NAMA = 'SPJM' AND C.JNS_CONT != 'F', C.NO_CONT, NULL)) AS 'SPJM_40_MT', 
				// 	COUNT(IF(B.UKR_CONT = '45' AND E.NAMA = 'SPJM' AND C.JNS_CONT = 'F', C.NO_CONT, NULL)) AS 'SPJM_45_FL',
				// 	COUNT(IF(B.UKR_CONT = '45' AND E.NAMA = 'SPJM' AND C.JNS_CONT != 'F', C.NO_CONT, NULL)) AS 'SPJM_45_MT', 
				// 	COUNT(IF(B.UKR_CONT IN ('20','40','45') AND E.NAMA = 'SPJM', C.NO_CONT, NULL)) AS 'TOTAL_SPJM', 
				// 	COUNT(IF(B.UKR_CONT = '20' AND E.NAMA = 'SPJM', C.NO_CONT, NULL)) * 1 + COUNT(IF(B.UKR_CONT = '40' AND E.NAMA = 'SPJM', C.NO_CONT, NULL)) * 2 + COUNT(IF(B.UKR_CONT = '45' AND E.NAMA = 'SPJM', C.NO_CONT, NULL)) * 2.25 AS 'SPJM_TEUS',
				// 	COUNT(IF(B.UKR_CONT = '20' AND E.NAMA NOT IN ('SPJM','SPPMP') AND C.JNS_CONT = 'F', C.NO_CONT, NULL)) AS 'ETC_20_FL', 
				// 	COUNT(IF(B.UKR_CONT = '20' AND E.NAMA NOT IN ('SPJM','SPPMP') AND C.JNS_CONT != 'F', C.NO_CONT, NULL)) AS 'ETC_20_MT', 
				// 	COUNT(IF(B.UKR_CONT = '40' AND E.NAMA NOT IN ('SPJM','SPPMP') AND C.JNS_CONT = 'F', C.NO_CONT, NULL)) AS 'ETC_40_FL', 
				// 	COUNT(IF(B.UKR_CONT = '40' AND E.NAMA NOT IN ('SPJM','SPPMP') AND C.JNS_CONT != 'F', C.NO_CONT, NULL)) AS 'ETC_40_MT', 
				// 	COUNT(IF(B.UKR_CONT = '45' AND E.NAMA NOT IN ('SPJM','SPPMP') AND C.JNS_CONT = 'F', C.NO_CONT, NULL)) AS 'ETC_45_FL', 
				// 	COUNT(IF(B.UKR_CONT = '45' AND E.NAMA NOT IN ('SPJM','SPPMP') AND C.JNS_CONT != 'F', C.NO_CONT, NULL)) AS 'ETC_45_MT', 
				// 	COUNT(IF(B.UKR_CONT IN ('20','40','45') AND E.NAMA NOT IN ('SPJM','SPPMP'), C.NO_CONT, NULL)) AS 'TOTAL_ETC',
				// 	COUNT(IF(B.UKR_CONT = '20' AND E.NAMA NOT IN ('SPJM','SPPMP'), C.NO_CONT, NULL)) * 1 + COUNT(IF(B.UKR_CONT = '40' AND E.NAMA NOT IN ('SPJM','SPPMP'), C.NO_CONT, NULL)) * 2 + COUNT(IF(B.UKR_CONT = '45' AND E.NAMA NOT IN ('SPJM','SPPMP'), C.NO_CONT, NULL)) * 2.25 AS 'ETC_TEUS',
				// 	CONCAT(COUNT(C.NO_CONT),' BOX') AS 'TOTAL'
				// 	FROM t_spk A
				// 	INNER JOIN t_spk_cont B ON A.ID = B.ID
				// 	LEFT JOIN (SELECT ID, NO_CONT, JNS_CONT, ISO_CODE, KD_CONT_TIPE AS 'TIPE_CONT', WK_IN AS 'STACKING' FROM t_cocostscont GROUP BY NO_CONT ORDER BY ID DESC) C ON B.NO_CONT = C.NO_CONT
				// 	LEFT JOIN t_cocostshdr D ON C.ID = D.ID
				// 	INNER JOIN reff_kode_dok_bc E ON A.JNS_DOK = E.ID
				// 	LEFT JOIN (SELECT ID, NO_CONT, IMO FROM t_request_cont GROUP BY NO_CONT ORDER BY ID DESC) F ON B.NO_CONT = F.NO_CONT
				// 	LEFT JOIN t_request G ON F.ID = G.ID
				// 	WHERE 1=1  ".$addsql;

				$SQL = "SELECT A.ID, 
									A.NO_SPK,
										B.NO_CONT,
										B.UKR_CONT AS 'SIZE', 
										'I' AS CLASS,
										D.CALL_SIGN as 'KD_KAPAL',
										D.VESSEL as 'NM_ANGKUT',
										D.VOY_IN AS 'NO_VOY',
										CASE 
												WHEN D.KD_CONT_JENIS = 'F' THEN 'FL'
												ELSE 'MT'
										END AS 'STATUS_CONT',
										D.ISO_CODE,
										D.TIPE_CONT as 'TIPE_CONT',
										D.IMO,
										E.TGL_TIBA as 'ARRIVAL',
										D.DISCHARGE as 'STACKING',
										F.NAMA as 'JNS_DOK',
										A.NO_DOK AS 'NO_DOK',
										A.TGL_DOK AS 'TGL_DOK',
										C.WK_SEND AS 'REQUEST_GATEPASS',
										C.WK_FINISH AS 'APPROVE_GATEPASS',
										A.WK_REQ AS 'TERBIT_SPK',
										A.CONSIGNEE AS 'CUSTOMERS'
										from t_spk A
									join t_spk_cont B on A.ID = B.ID
									left join t_request C on A.NO_DOK = C.NO_DOK and A.TGL_DOK = C.TGL_DOK
									left join t_request_cont D on C.ID = D.ID and B.NO_CONT = D.NO_CONT
									left join t_cocostshdr E on E.NM_ANGKUT = D.VESSEL and E.NO_VOY_FLIGHT = D.VOY_IN
									join reff_kode_dok_bc F on A.JNS_DOK = F.ID
									WHERE 1=1 " . $addsql;

				$SQL1 = "SELECT  
									COUNT(IF(B.UKR_CONT = '20' AND F.NAMA = 'SPPMP' AND D.KD_CONT_JENIS = 'F', D.NO_CONT, NULL)) AS 'SPPMP_20_FL', 
									COUNT(IF(B.UKR_CONT = '20' AND F.NAMA = 'SPPMP' AND D.KD_CONT_JENIS != 'F', D.NO_CONT, NULL)) AS 'SPPMP_20_MT', 
									COUNT(IF(B.UKR_CONT = '40' AND F.NAMA = 'SPPMP' AND D.KD_CONT_JENIS = 'F', D.NO_CONT, NULL)) AS 'SPPMP_40_FL', 
									COUNT(IF(B.UKR_CONT = '40' AND F.NAMA = 'SPPMP' AND D.KD_CONT_JENIS != 'F', D.NO_CONT, NULL)) AS 'SPPMP_40_MT', 
									COUNT(IF(B.UKR_CONT = '45' AND F.NAMA = 'SPPMP' AND D.KD_CONT_JENIS = 'F', D.NO_CONT, NULL)) AS 'SPPMP_45_FL', 
									COUNT(IF(B.UKR_CONT = '45' AND F.NAMA = 'SPPMP' AND D.KD_CONT_JENIS != 'F', D.NO_CONT, NULL)) AS 'SPPMP_45_MT', 
									COUNT(IF(B.UKR_CONT IN ('20','40','45') AND F.NAMA = 'SPPMP', D.NO_CONT, NULL)) AS 'TOTAL_SPPMP', 
									COUNT(IF(B.UKR_CONT = '20' AND F.NAMA = 'SPPMP', D.NO_CONT, NULL)) * 1 + 
									COUNT(IF(B.UKR_CONT = '40' AND F.NAMA = 'SPPMP', D.NO_CONT, NULL)) * 2 + 
									COUNT(IF(B.UKR_CONT = '45' AND F.NAMA = 'SPPMP', D.NO_CONT, NULL)) * 2.25 AS 'SPPMP_TEUS',
									COUNT(IF(B.UKR_CONT = '20' AND F.NAMA = 'SPJM' AND D.KD_CONT_JENIS = 'F', D.NO_CONT, NULL)) AS 'SPJM_20_FL', 
									COUNT(IF(B.UKR_CONT = '20' AND F.NAMA = 'SPJM' AND D.KD_CONT_JENIS != 'F', D.NO_CONT, NULL)) AS 'SPJM_20_MT', 
									COUNT(IF(B.UKR_CONT = '40' AND F.NAMA = 'SPJM' AND D.KD_CONT_JENIS = 'F', D.NO_CONT, NULL)) AS 'SPJM_40_FL', 
									COUNT(IF(B.UKR_CONT = '40' AND F.NAMA = 'SPJM' AND D.KD_CONT_JENIS != 'F', D.NO_CONT, NULL)) AS 'SPJM_40_MT', 
									COUNT(IF(B.UKR_CONT = '45' AND F.NAMA = 'SPJM' AND D.KD_CONT_JENIS = 'F', D.NO_CONT, NULL)) AS 'SPJM_45_FL', 
									COUNT(IF(B.UKR_CONT = '45' AND F.NAMA = 'SPJM' AND D.KD_CONT_JENIS != 'F', D.NO_CONT, NULL)) AS 'SPJM_45_MT', 
									COUNT(IF(B.UKR_CONT IN ('20','40','45') AND F.NAMA = 'SPJM', D.NO_CONT, NULL)) AS 'TOTAL_SPJM', 
									COUNT(IF(B.UKR_CONT = '20' AND F.NAMA = 'SPJM', D.NO_CONT, NULL)) * 1 + 
									COUNT(IF(B.UKR_CONT = '40' AND F.NAMA = 'SPJM', D.NO_CONT, NULL)) * 2 + 
									COUNT(IF(B.UKR_CONT = '45' AND F.NAMA = 'SPJM', D.NO_CONT, NULL)) * 2.25 AS 'SPJM_TEUS',
									COUNT(IF(B.UKR_CONT = '20' AND F.NAMA NOT IN ('SPJM','SPPMP') AND D.KD_CONT_JENIS = 'F', D.NO_CONT, NULL)) AS 'ETC_20_FL', 
									COUNT(IF(B.UKR_CONT = '20' AND F.NAMA NOT IN ('SPJM','SPPMP') AND D.KD_CONT_JENIS != 'F', D.NO_CONT, NULL)) AS 'ETC_20_MT', 
									COUNT(IF(B.UKR_CONT = '40' AND F.NAMA NOT IN ('SPJM','SPPMP') AND D.KD_CONT_JENIS = 'F', D.NO_CONT, NULL)) AS 'ETC_40_FL', 
									COUNT(IF(B.UKR_CONT = '40' AND F.NAMA NOT IN ('SPJM','SPPMP') AND D.KD_CONT_JENIS != 'F', D.NO_CONT, NULL)) AS 'ETC_40_MT', 
									COUNT(IF(B.UKR_CONT = '45' AND F.NAMA NOT IN ('SPJM','SPPMP') AND D.KD_CONT_JENIS = 'F', D.NO_CONT, NULL)) AS 'ETC_45_FL', 
									COUNT(IF(B.UKR_CONT = '45' AND F.NAMA NOT IN ('SPJM','SPPMP') AND D.KD_CONT_JENIS != 'F', D.NO_CONT, NULL)) AS 'ETC_45_MT', 
									COUNT(IF(B.UKR_CONT IN ('20','40','45') AND F.NAMA NOT IN ('SPJM','SPPMP'), D.NO_CONT, NULL)) AS 'TOTAL_ETC',
									COUNT(IF(B.UKR_CONT = '20' AND F.NAMA NOT IN ('SPJM','SPPMP'), D.NO_CONT, NULL)) * 1 + 
									COUNT(IF(B.UKR_CONT = '40' AND F.NAMA NOT IN ('SPJM','SPPMP'), D.NO_CONT, NULL)) * 2 + 
									COUNT(IF(B.UKR_CONT = '45' AND F.NAMA NOT IN ('SPJM','SPPMP'), D.NO_CONT, NULL)) * 2.25 AS 'ETC_TEUS',
									CONCAT(COUNT(D.NO_CONT), ' BOX') AS 'TOTAL'
							FROM t_spk A
							JOIN t_spk_cont B ON A.ID = B.ID
							LEFT JOIN t_request C ON A.NO_DOK = C.NO_DOK AND A.TGL_DOK = C.TGL_DOK
							LEFT JOIN t_request_cont D ON C.ID = D.ID AND B.NO_CONT = D.NO_CONT
							LEFT JOIN t_cocostshdr E ON E.NM_ANGKUT = D.VESSEL AND E.NO_VOY_FLIGHT = D.VOY_IN
							JOIN reff_kode_dok_bc F ON A.JNS_DOK = F.ID
							WHERE 1=1 " . $addsql;
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
				$objDrawing->setHeight(40);
				$objDrawing->setWidth(100);
				$objDrawing->setWorksheet($this->newphpexcel->getActiveSheet());
				$this->newphpexcel->setActiveSheetIndex(0);
				$styleArray = array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
				$this->newphpexcel->getDefaultStyle()->applyFromArray($styleArray);
				$this->newphpexcel->set_bold(array('C1'));
				$this->newphpexcel->getActiveSheet()->getStyle("C1:J3")->getFont()->setSize(11);
				$this->newphpexcel->mergecell(array(array('C1', 'J1'), array('C2', 'J2'), array('C3', 'J3'), array('W1', 'W3'), array('X1', 'X3'), array('Y1', 'AD1'), array('Y2', 'Z2'), array('AA2', 'AB2'), array('AC2', 'AD2'), array('AE1', 'AE3'), array('AF1', 'AF3'), array('W7', 'X7')), FALSE);
				$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('C1', 'REPORT TERBIT SPK');
				$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('C2', 'COMMON GATE IPC TPK');
				$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('C3', $tgl_awal . ' - ' . $tgl_akhir);
				$this->newphpexcel->width(array(array('A', 5), array('B', 20), array('C', 20), array('D', 10), array('E', 20), array('F', 20), array('G', 20), array('H', 10), array('I', 15), array('J', 20), array('K', 15), array('L', 15), array('M', 25), array('N', 25), array('O', 25), array('P', 30), array('Q', 30), array('R', 30), array('S', 35), array('T', 35), array('U', 40), array('W', 10), array('X', 10)));

				$this->newphpexcel->setActiveSheetIndex(0)
					->setCellValue('A6', 'NO')
					->setCellValue('B6', 'NO SPK')
					->setCellValue('C6', 'NO KONTAINER')
					->setCellValue('D6', 'CLS')
					->setCellValue('E6', 'KODE VESSEL')
					->setCellValue('F6', 'VESSEL')
					->setCellValue('G6', 'VOY')
					->setCellValue('H6', 'STATUS')
					->setCellValue('I6', 'SIZE')
					->setCellValue('J6', 'ISO CODE')
					->setCellValue('K6', 'TYPE')
					->setCellValue('L6', 'IMO CODE')
					->setCellValue('M6', 'ARRIVAL')
					->setCellValue('N6', 'STACKING')
					->setCellValue('O6', 'JENIS DOKUMEN')
					->setCellValue('P6', 'NO DOKUMEN')
					->setCellValue('Q6', 'DOKUMEN DATE')
					->setCellValue('R6', 'REQUEST GATEPASS')
					->setCellValue('S6', 'APPROVED GATEPASS')
					->setCellValue('T6', 'TANGGAL TERBIT SPK')
					->setCellValue('U6', 'NAMA CUSTOMER')
					->setCellValue('W1', 'No')
					->setCellValue('X1', 'Dokumen')
					->setCellValue('Y1', 'UKURAN')
					->setCellValue('Y2', '20')
					->setCellValue('AA2', '40')
					->setCellValue('AC2', '45')
					->setCellValue('AE1', 'TOTAL')
					->setCellValue('AF1', 'TEUS')
					->setCellValue('Y3', 'FL')
					->setCellValue('Z3', 'MT')
					->setCellValue('AA3', 'FL')
					->setCellValue('AB3', 'MT')
					->setCellValue('AC3', 'FL')
					->setCellValue('AD3', 'MT')
					->setCellValue('W7', 'GATEPASS TERBIT');

				$this->newphpexcel->headings(array('A6', 'B6', 'C6', 'D6', 'E6', 'F6', 'G6', 'H6', 'I6', 'J6', 'K6', 'L6', 'M6', 'N6', 'O6', 'P6', 'Q6', 'R6', 'S6', 'T6', 'U6', 'W1', 'W2', 'W3', 'X1', 'Y1', 'Z2', 'Y2', 'AA2', 'AB2', 'AC2', 'AD2', 'AE1', 'AE2', 'AE3', 'AF1', 'AF2', 'AF3', 'Y3', 'Z3', 'AA3', 'AB3', 'AC3', 'AD3', 'W7', 'X7', 'Y7', 'Z7', 'AA7', 'AB7', 'AC7', 'AD7', 'AE7', 'AF7'));
				$this->newphpexcel->set_wrap(array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U'));
				$no = 1;
				$rec = 7;
				if ($result) {
					foreach ($SQL->result_array() as $row) {
						$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A' . $rec, $no)
							->setCellValue('B' . $rec, $row["NO_SPK"])
							->setCellValue('C' . $rec, $row["NO_CONT"])
							->setCellValue('D' . $rec, $row["CLASS"])
							->setCellValue('E' . $rec, $row["KD_KAPAL"])
							->setCellValue('F' . $rec, $row["NM_ANGKUT"])
							->setCellValue('G' . $rec, $row["NO_VOY"])
							->setCellValue('H' . $rec, $row["STATUS_CONT"])
							->setCellValue('I' . $rec, $row["SIZE"])
							->setCellValue('J' . $rec, $row["ISO_CODE"])
							->setCellValue('K' . $rec, $row["TIPE_CONT"])
							->setCellValue('L' . $rec, $row["IMO"])
							->setCellValue('M' . $rec, $row["ARRIVAL"])
							->setCellValue('N' . $rec, $row["STACKING"])
							->setCellValue('O' . $rec, $row["JNS_DOK"])
							->setCellValue('P' . $rec, $row["NO_DOK"])
							->setCellValue('Q' . $rec, $row["TGL_DOK"])
							->setCellValue('R' . $rec, $row["REQUEST_GATEPASS"])
							->setCellValue('S' . $rec, $row["APPROVE_GATEPASS"])
							->setCellValue('T' . $rec, $row["TERBIT_SPK"])
							->setCellValue('U' . $rec, $row["CUSTOMERS"]);
						$this->newphpexcel->set_detilstyle(array('A' . $rec, 'B' . $rec, 'C' . $rec, 'D' . $rec, 'E' . $rec, 'F' . $rec, 'G' . $rec, 'H' . $rec, 'I' . $rec, 'J' . $rec, 'K' . $rec, 'L' . $rec, 'M' . $rec, 'N' . $rec, 'O' . $rec, 'P' . $rec, 'Q' . $rec, 'R' . $rec, 'S' . $rec, 'T' . $rec, 'U' . $rec));
						$rec++;
						$no++;
					}

					$rec = 4;
					foreach ($SQL1->result_array() as $row) {
						$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('W' . $rec, '1')
							->setCellValue('X' . $rec, 'SPPMP')
							->setCellValue('Y' . $rec, $row["SPPMP_20_FL"])
							->setCellValue('Z' . $rec, $row["SPPMP_20_MT"])
							->setCellValue('AA' . $rec, $row["SPPMP_40_FL"])
							->setCellValue('AB' . $rec, $row["SPPMP_40_MT"])
							->setCellValue('AC' . $rec, $row["SPPMP_45_FL"])
							->setCellValue('AD' . $rec, $row["SPPMP_45_MT"])
							->setCellValue('AE' . $rec, $row["TOTAL_SPPMP"])
							->setCellValue('AF' . $rec, $row["SPPMP_TEUS"])
							->setCellValue('AE' . '7', $row["TOTAL"]);
						$this->newphpexcel->set_detilstyle(array('W' . $rec, 'X' . $rec, 'Y' . $rec, 'Z' . $rec, 'AA' . $rec, 'AB' . $rec, 'AC' . $rec, 'AD' . $rec, 'AE' . $rec, 'AF' . $rec), 'AE' . $rec);
					}

					$rec = 5;
					foreach ($SQL1->result_array() as $row) {
						$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('W' . $rec, '2')
							->setCellValue('X' . $rec, 'SPJM')
							->setCellValue('Y' . $rec, $row["SPJM_20_FL"])
							->setCellValue('Z' . $rec, $row["SPJM_20_MT"])
							->setCellValue('AA' . $rec, $row["SPJM_40_FL"])
							->setCellValue('AB' . $rec, $row["SPJM_40_MT"])
							->setCellValue('AC' . $rec, $row["SPJM_45_FL"])
							->setCellValue('AD' . $rec, $row["SPJM_45_MT"])
							->setCellValue('AE' . $rec, $row["TOTAL_SPJM"])
							->setCellValue('AF' . $rec, $row["SPJM_TEUS"]);
						$this->newphpexcel->set_detilstyle(array('W' . $rec, 'X' . $rec, 'Y' . $rec, 'Z' . $rec, 'AA' . $rec, 'AB' . $rec, 'AC' . $rec, 'AD' . $rec, 'AE' . $rec, 'AF' . $rec));
					}

					$rec = 6;
					foreach ($SQL1->result_array() as $row) {
						$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('W' . $rec, '3')
							->setCellValue('X' . $rec, 'ETC')
							->setCellValue('Y' . $rec, $row["ETC_20_FL"])
							->setCellValue('Z' . $rec, $row["ETC_20_MT"])
							->setCellValue('AA' . $rec, $row["ETC_40_FL"])
							->setCellValue('AB' . $rec, $row["ETC_40_MT"])
							->setCellValue('AC' . $rec, $row["ETC_45_FL"])
							->setCellValue('AD' . $rec, $row["ETC_45_MT"])
							->setCellValue('AE' . $rec, $row["TOTAL_ETC"])
							->setCellValue('AF' . $rec, $row["ETC_TEUS"]);
						$this->newphpexcel->set_detilstyle(array('W' . $rec, 'X' . $rec, 'Y' . $rec, 'Z' . $rec, 'AA' . $rec, 'AB' . $rec, 'AC' . $rec, 'AD' . $rec, 'AE' . $rec, 'AF' . $rec));
					}
				} else {
					$this->newphpexcel->getActiveSheet()->mergeCells('A10:U10');
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A10', 'DATA TIDAK DITEMUKAN');
					$this->newphpexcel->set_detilstyle(array('A10'));
				}
				ob_clean();

				$file = "TERBIT_SPK_" . date("Y-m-d") . ".xls";
				header("Content-type: application/x-msdownload");
				header("Content-Disposition: attachment;filename=$file");
				header("Cache-Control: max-age=0");
				header("Pragma: no-cache");
				header("Expires: 0");
				$objWriter = PHPExcel_IOFactory::createWriter($this->newphpexcel, 'Excel5');
				$objWriter->save('php://output');
				exit();
			} else if ($act == "penarikan1") {
				$status_penarikan = $this->input->post('form[0]');
				$tgl_behandle = $this->input->post('form[1]');
				$tgl_pickup = $this->input->post('form[2]');

				$status = $status_penarikan[0];
				$behandle_start = $tgl_behandle[0];
				$behandle_end = $tgl_behandle[1];
				$pickup_start = $tgl_pickup[0];
				$pickup_end = $tgl_pickup[1];
				$addsql = "";
				$addsql1 = "";

				$behandle_st = date("d/m/Y H:i", strtotime($behandle_start));
				$behandle_en = date("d/m/Y H:i", strtotime($behandle_end));

				/* BEHANDLE IN */
				if ($status != "" && $behandle_start != "" && $behandle_end != "" && $pickup_start != "" && $pickup_end != "") {
					$addsql .= " AND B.STATUS_CONT ='450' AND F.WK_IN BETWEEN '$behandle_start' AND '$behandle_end' AND F.WK_PICKUP BETWEEN '$pickup_start' AND '$pickup_end' ORDER BY F.WK_IN DESC";
				} else if ($behandle_start != "" && $behandle_end != "" && $pickup_start != "" && $pickup_end != "") {
					$addsql .= " AND F.WK_IN BETWEEN '$behandle_start' AND '$behandle_end' AND F.WK_PICKUP BETWEEN '$pickup_start' AND '$pickup_end' ORDER BY F.WK_IN DESC";
				} else if ($behandle_start != "" && $behandle_end != "") {
					$addsql .= " AND F.WK_IN BETWEEN '$behandle_start' AND '$behandle_end' ORDER BY F.WK_IN DESC";
				} else if ($pickup_start != "" && $pickup_end != "") {
					$addsql .= " AND F.WK_PICKUP BETWEEN '$pickup_start' AND '$pickup_end' ORDER BY F.WK_IN DESC";
				} else if ($behandle_start != "") {
					$addsql .= " AND F.WK_IN >= '$behandle_start' ORDER BY F.WK_IN DESC";
				} else if ($behandle_end != "") {
					$addsql .= " AND F.WK_IN <= '$behandle_end' ORDER BY F.WK_IN DESC";
				} else if ($pickup_start != "") {
					$addsql .= " AND F.WK_PICKUP >= '$pickup_start' ORDER BY F.WK_IN DESC";
				} else if ($pickup_end != "") {
					$addsql .= " AND F.WK_PICKUP <= '$pickup_end' ORDER BY F.WK_IN DESC";
				} else if ($status != "") {
					$addsql .= " AND B.STATUS_CONT ='450' ORDER BY F.WK_IN DESC";
				} else {
					$addsql .= " ORDER BY F.WK_IN DESC";
				}

				// $SQL = "SELECT A.NO_SPK, B.NO_CONT, B.UKR_CONT AS 'SIZE', 'I' AS CLASS, D.CALL_SIGN AS 'KD_KAPAL', D.NM_ANGKUT, D.NO_VOY_FLIGHT AS 'NO_VOY', CASE WHEN C.STATUS_CONT ='F' THEN 'FL' ELSE 'MT' END AS 'STATUS_CONT', B.ISO_CODE, C.TIPE_CONT, F.IMO, D.TGL_TIBA AS 'ARRIVAL', C.STACKING, C.GATEOUT, E.NAMA AS 'JNS_DOK', A.NO_DOK, A.TGL_DOK, J.WK_REK AS 'GATEPASS1', H.W_PICKUP, B.ID_FLAT AS 'TID', H.W_BEHANDLE, I.KONDISI, H.NO_SEAL, H.ROOM, A.CONSIGNEE AS 'CUSTOMERS'
				// 		FROM t_spk A
				// 		INNER JOIN t_spk_cont B ON A.ID = B.ID
				// 		LEFT JOIN (SELECT ID, NO_CONT, JNS_CONT AS 'STATUS_CONT', ISO_CODE, KD_CONT_TIPE AS 'TIPE_CONT', WK_IN AS 'STACKING', WK_OUT AS 'GATEOUT' FROM t_cocostscont GROUP BY NO_CONT ORDER BY ID DESC) C ON B.NO_CONT = C.NO_CONT
				// 		LEFT JOIN t_cocostshdr D ON C.ID = D.ID
				// 		INNER JOIN reff_kode_dok_bc E ON A.JNS_DOK = E.ID
				// 		LEFT JOIN (SELECT ID, NO_CONT, IMO FROM t_request_cont GROUP BY NO_CONT ORDER BY ID DESC) F ON B.NO_CONT = F.NO_CONT
				// 		LEFT JOIN t_request G ON F.ID = G.ID
				// 		INNER JOIN (SELECT A.NO_SPK, B.NO_CONT, A.W_PICKUP, W_BEHANDLE, B.KONDISI_CONT, B.NO_SEAL, B.ROOM FROM (SELECT NO_SPK,W_PICKUP FROM t_op_pickup where date(W_PICKUP) > DATE_ADD(NOW() , INTERVAL -6 MONTH) GROUP BY NO_SPK) A INNER JOIN t_op_behandlein B ON A.NO_SPK = B.NO_SPK) H ON A.NO_SPK = H.NO_SPK AND B.NO_CONT = H.NO_CONT
				// 		LEFT JOIN reff_kondisi I ON H.KONDISI_CONT = I.ID
				// 		LEFT JOIN t_gatepass J ON A.NO_DOK = J.NO_DOK AND C.NO_CONT = J.NO_CONT
				// 		WHERE 1 = 1".$addsql; //echo $SQL; die();	
				//query baru

				/* BEHANDLE IN */
				if ($status != "" && $behandle_start != "" && $behandle_end != "" && $pickup_start != "" && $pickup_end != "") {
					$addsql1 .= " AND B.STATUS_CONT ='450' AND F.W_BEHANDLE BETWEEN '$behandle_start' AND '$behandle_end' AND E.W_PICKUP BETWEEN '$pickup_start' AND '$pickup_end' ORDER BY F.W_BEHANDLE DESC";
				} else if ($behandle_start != "" && $behandle_end != "" && $pickup_start != "" && $pickup_end != "") {
					$addsql1 .= " AND F.W_BEHANDLE BETWEEN '$behandle_start' AND '$behandle_end' AND E.W_PICKUP BETWEEN '$pickup_start' AND '$pickup_end' ORDER BY F.W_BEHANDLE DESC";
				} else if ($behandle_start != "" && $behandle_end != "") {
					$addsql1 .= " AND F.W_BEHANDLE BETWEEN '$behandle_start' AND '$behandle_end' ORDER BY F.W_BEHANDLE DESC";
				} else if ($pickup_start != "" && $pickup_end != "") {
					$addsql1 .= " AND E.W_PICKUP BETWEEN '$pickup_start' AND '$pickup_end' ORDER BY F.W_BEHANDLE DESC";
				} else if ($behandle_start != "") {
					$addsql1 .= " AND F.W_BEHANDLE >= '$behandle_start' ORDER BY F.W_BEHANDLE DESC";
				} else if ($behandle_end != "") {
					$addsql1 .= " AND F.W_BEHANDLE <= '$behandle_end' ORDER BY F.W_BEHANDLE DESC";
				} else if ($pickup_start != "") {
					$addsql1 .= " AND E.W_PICKUP >= '$pickup_start' ORDER BY F.W_BEHANDLE DESC";
				} else if ($pickup_end != "") {
					$addsql1 .= " AND E.W_PICKUP <= '$pickup_end' ORDER BY F.W_BEHANDLE DESC";
				} else if ($status != "") {
					$addsql1 .= " AND B.STATUS_CONT ='450' ORDER BY F.W_BEHANDLE DESC";
				} else {
					$addsql1 .= " ORDER BY F.W_BEHANDLE DESC";
				}

				$SQL = "SELECT DISTINCT 
							A.NO_SPK, 
							B.NO_CONT AS 'NO_CONT', 
							B.UKR_CONT AS 'SIZE', 
							D.VESSEL AS 'NM_ANGKUT', 
							CASE WHEN D.KD_CONT_JENIS = 'F' THEN 'FL' ELSE 'MT' END AS 'STATUS_CONT', 
							D.ISO_CODE, 
							D.TIPE_CONT AS 'TIPE_CONT', 
							D.IMO, 
							Z.NAMA AS 'JNS_DOK', 
							A.NO_DOK AS 'NO_DOK', 
							A.TGL_DOK AS 'TGL_DOK', 
							A.CONSIGNEE AS 'CUSTOMERS', 
							E.W_PICKUP AS 'W_PICKUP', 
							B.ID_FLAT AS 'TID', 
							F.W_BEHANDLE AS 'W_BEHANDLE', 
							D.CALL_SIGN AS 'KD_KAPAL', 
							D.VOY_IN AS 'NO_VOY', 
							G.TGL_TIBA AS 'ARRIVAL', 
							D.DISCHARGE AS 'STACKING', 
							G.WK_OUT AS 'GATEOUT', 
							F.NO_SEAL AS 'NO_SEAL', 
							F.ROOM AS 'ROOM',
							FF.WK_TERMINAL_IN,
							FF.WK_TERMINAL_OUT
						FROM 
							t_spk A
						JOIN 
							t_spk_cont B ON A.ID = B.ID
						LEFT JOIN 
							t_request C ON C.NO_DOK = A.NO_DOK AND C.TGL_DOK = A.TGL_DOK
						LEFT JOIN 
							t_request_cont D ON C.ID = D.ID AND D.NO_CONT = B.NO_CONT
						LEFT JOIN 
							t_op_pickup E ON E.NO_SPK = A.NO_SPK AND E.NO_CONT = B.NO_CONT
						LEFT JOIN 
							t_op_behandlein F ON F.NO_SPK = A.NO_SPK AND F.NO_CONT = B.NO_CONT
						LEFT JOIN
							t_operation FF on FF.NO_SPK = A.NO_SPK AND FF.NO_CONT = B.NO_CONT
						left join 
							(select tc2.NM_ANGKUT,tc2.NO_VOY_FLIGHT ,tc.NO_CONT, tc.WK_IN, tc2.TGL_TIBA, tc.WK_OUT  from t_cocostscont tc join t_cocostshdr tc2 on tc.ID = tc2.ID) 
							G on G.NM_ANGKUT = D.VESSEL and G.NO_VOY_FLIGHT = D.VOY_IN and D.NO_CONT = D.NO_CONT
						JOIN 
							reff_kode_dok_bc Z ON Z.ID = A.JNS_DOK
						WHERE 
							1 = 1" . $addsql1; //echo $SQL; die();	

				$SQL1 = "SELECT 
								COUNT(IF(B.UKR_CONT = '20' AND AA.NAMA = 'SPPMP' AND D.KD_CONT_JENIS = 'F', D.NO_CONT, NULL)) AS 'SPPMP_20_FL', 
								COUNT(IF(B.UKR_CONT = '20' AND AA.NAMA = 'SPPMP' AND D.KD_CONT_JENIS != 'F', D.NO_CONT, NULL)) AS 'SPPMP_20_MT', 
								COUNT(IF(B.UKR_CONT = '40' AND AA.NAMA = 'SPPMP' AND D.KD_CONT_JENIS = 'F', D.NO_CONT, NULL)) AS 'SPPMP_40_FL', 
								COUNT(IF(B.UKR_CONT = '40' AND AA.NAMA = 'SPPMP' AND D.KD_CONT_JENIS != 'F', D.NO_CONT, NULL)) AS 'SPPMP_40_MT', 
								COUNT(IF(B.UKR_CONT = '45' AND AA.NAMA = 'SPPMP' AND D.KD_CONT_JENIS = 'F', D.NO_CONT, NULL)) AS 'SPPMP_45_FL', 
								COUNT(IF(B.UKR_CONT = '45' AND AA.NAMA = 'SPPMP' AND D.KD_CONT_JENIS != 'F', D.NO_CONT, NULL)) AS 'SPPMP_45_MT', 
								COUNT(IF(B.UKR_CONT IN ('20','40','45') AND AA.NAMA = 'SPPMP', D.NO_CONT, NULL)) AS 'TOTAL_SPPMP', 
								COUNT(IF(B.UKR_CONT = '20' AND AA.NAMA = 'SPPMP', D.NO_CONT, NULL)) * 1 + COUNT(IF(B.UKR_CONT = '40' AND AA.NAMA = 'SPPMP', D.NO_CONT, NULL)) * 2 + COUNT(IF(B.UKR_CONT = '45' AND AA.NAMA = 'SPPMP', D.NO_CONT, NULL)) * 2.25 AS 'SPPMP_TEUS',
								COUNT(IF(B.UKR_CONT = '20' AND AA.NAMA = 'SPJM' AND D.KD_CONT_JENIS = 'F', D.NO_CONT, NULL)) AS 'SPJM_20_FL', 
								COUNT(IF(B.UKR_CONT = '20' AND AA.NAMA = 'SPJM' AND D.KD_CONT_JENIS != 'F', D.NO_CONT, NULL)) AS 'SPJM_20_MT', 
								COUNT(IF(B.UKR_CONT = '40' AND AA.NAMA = 'SPJM' AND D.KD_CONT_JENIS = 'F', D.NO_CONT, NULL)) AS 'SPJM_40_FL', 
								COUNT(IF(B.UKR_CONT = '40' AND AA.NAMA = 'SPJM' AND D.KD_CONT_JENIS != 'F', D.NO_CONT, NULL)) AS 'SPJM_40_MT', 
								COUNT(IF(B.UKR_CONT = '45' AND AA.NAMA = 'SPJM' AND D.KD_CONT_JENIS = 'F', D.NO_CONT, NULL)) AS 'SPJM_45_FL',
								COUNT(IF(B.UKR_CONT = '45' AND AA.NAMA = 'SPJM' AND D.KD_CONT_JENIS != 'F', D.NO_CONT, NULL)) AS 'SPJM_45_MT', 
								COUNT(IF(B.UKR_CONT IN ('20','40','45') AND AA.NAMA = 'SPJM', D.NO_CONT, NULL)) AS 'TOTAL_SPJM', 
								COUNT(IF(B.UKR_CONT = '20' AND AA.NAMA = 'SPJM', D.NO_CONT, NULL)) * 1 + COUNT(IF(B.UKR_CONT = '40' AND AA.NAMA = 'SPJM', D.NO_CONT, NULL)) * 2 + COUNT(IF(B.UKR_CONT = '45' AND AA.NAMA = 'SPJM', D.NO_CONT, NULL)) * 2.25 AS 'SPJM_TEUS',
								COUNT(IF(B.UKR_CONT = '20' AND AA.NAMA NOT IN ('SPJM','SPPMP') AND D.KD_CONT_JENIS = 'F', D.NO_CONT, NULL)) AS 'ETC_20_FL', 
								COUNT(IF(B.UKR_CONT = '20' AND AA.NAMA NOT IN ('SPJM','SPPMP') AND D.KD_CONT_JENIS != 'F', D.NO_CONT, NULL)) AS 'ETC_20_MT', 
								COUNT(IF(B.UKR_CONT = '40' AND AA.NAMA NOT IN ('SPJM','SPPMP') AND D.KD_CONT_JENIS = 'F', D.NO_CONT, NULL)) AS 'ETC_40_FL', 
								COUNT(IF(B.UKR_CONT = '40' AND AA.NAMA NOT IN ('SPJM','SPPMP') AND D.KD_CONT_JENIS != 'F', D.NO_CONT, NULL)) AS 'ETC_40_MT', 
								COUNT(IF(B.UKR_CONT = '45' AND AA.NAMA NOT IN ('SPJM','SPPMP') AND D.KD_CONT_JENIS = 'F', D.NO_CONT, NULL)) AS 'ETC_45_FL', 
								COUNT(IF(B.UKR_CONT = '45' AND AA.NAMA NOT IN ('SPJM','SPPMP') AND D.KD_CONT_JENIS != 'F', D.NO_CONT, NULL)) AS 'ETC_45_MT', 
								COUNT(IF(B.UKR_CONT IN ('20','40','45') AND AA.NAMA NOT IN ('SPJM','SPPMP'), D.NO_CONT, NULL)) AS 'TOTAL_ETC', 
								COUNT(IF(B.UKR_CONT = '20' AND AA.NAMA NOT IN ('SPJM','SPPMP'), D.NO_CONT, NULL)) * 1 + COUNT(IF(B.UKR_CONT = '40' AND AA.NAMA NOT IN ('SPJM','SPPMP'), D.NO_CONT, NULL)) * 2 + COUNT(IF(B.UKR_CONT = '45' AND AA.NAMA NOT IN ('SPJM','SPPMP'), D.NO_CONT, NULL)) * 2.25 AS 'ETC_TEUS',
								CONCAT(COUNT(D.NO_CONT),' BOX') AS 'TOTAL'
								from t_spk A join t_spk_cont B on A.ID = B.ID
								left join reff_kode_dok_bc AA on A.JNS_DOK = AA.ID
							join t_request C on A.NO_DOK = C.NO_DOK and A.TGL_DOK = C.TGL_DOK
							join t_request_cont D on C.ID = D.ID and D.NO_CONT = B.NO_CONT
							left join t_cocostshdr E on D.VESSEL = E.NM_ANGKUT and D.VOY_IN = E.NO_VOY_FLIGHT 
							left join t_operation F on A.NO_SPK = F.NO_SPK and B.NO_CONT = F.NO_CONT
							WHERE 1 = 1 " . $addsql;

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
				$objDrawing->setHeight(40);
				$objDrawing->setWidth(100);
				$objDrawing->setWorksheet($this->newphpexcel->getActiveSheet());
				$this->newphpexcel->setActiveSheetIndex(0);
				$styleArray = array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
				$this->newphpexcel->getDefaultStyle()->applyFromArray($styleArray);
				$this->newphpexcel->set_bold(array('C1'));
				$this->newphpexcel->getActiveSheet()->getStyle("C1:J3")->getFont()->setSize(11);
				$this->newphpexcel->mergecell(array(array('C1', 'O1'), array('C2', 'O2'), array('C3', 'O3'), array('AA1', 'AA3'), array('AB1', 'AB3'), array('AC1', 'AH1'), array('AC2', 'AD2'), array('AE2', 'AF2'), array('AG2', 'AH2'), array('AI1', 'AI3'), array('AJ1', 'AJ3'), array('AA7', 'AB7')), FALSE);
				$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('C1', 'REPORT PENARIKAN');
				$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('C2', 'COMMON GATE IPC TPK');
				$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('C3', $behandle_st . ' - ' . $behandle_en);
				$this->newphpexcel->width(array(array('A', 5), array('B', 20), array('C', 20), array('D', 10), array('E', 20), array('F', 20), array('G', 10), array('H', 10), array('I', 10), array('J', 15), array('K', 15), array('L', 15), array('M', 25), array('N', 15), array('O', 28), array('P', 25), array('Q', 15), array('R', 20), array('S', 20), array('T', 20), array('U', 40), array('V', 20), array('W', 15), array('X', 20), array('Y', 40), array('AA', 10), array('AB', 10)));

				$this->newphpexcel->setActiveSheetIndex(0)
					->setCellValue('A6', 'NO')
					->setCellValue('B6', 'NO SPK')
					->setCellValue('C6', 'NO KONTAINER')
					->setCellValue('D6', 'CLS')
					->setCellValue('E6', 'VESSEL')
					->setCellValue('F6', 'VOY')
					->setCellValue('G6', 'STATUS')
					->setCellValue('H6', 'SIZE')
					->setCellValue('I6', 'ISO CODE')
					->setCellValue('J6', 'TYPE')
					->setCellValue('K6', 'IMO CODE')
					->setCellValue('L6', 'JENIS DOKUMEN')
					->setCellValue('M6', 'NO DOKUMEN')
					->setCellValue('N6', 'DOKUMEN DATE')
					->setCellValue('O6', 'TERBIT GATEPASS BEHANDLE 1')
					->setCellValue('P6', 'PICKUP')
					->setCellValue('Q6', 'TID')
					->setCellValue('R6', 'GATE IN TERMINAL')
					->setCellValue('S6', 'GATE OUT TERMINAL')
					->setCellValue('T6', 'BEHANDLE IN')
					->setCellValue('U6', 'KONDISI KONTAINER')
					->setCellValue('V6', 'NO SEAL')
					->setCellValue('W6', 'ISO CODE')
					->setCellValue('X6', 'LOKASI')
					->setCellValue('Y6', 'NAMA CUSTOMERS')
					->setCellValue('AA1', 'No')
					->setCellValue('AB1', 'Dokumen')
					->setCellValue('AC1', 'UKURAN')
					->setCellValue('AC2', '20')
					->setCellValue('AE2', '40')
					->setCellValue('AG2', '45')
					->setCellValue('AI1', 'TOTAL')
					->setCellValue('AJ1', 'TEUS')
					->setCellValue('AC3', 'FL')
					->setCellValue('AD3', 'MT')
					->setCellValue('AE3', 'FL')
					->setCellValue('AF3', 'MT')
					->setCellValue('AG3', 'FL')
					->setCellValue('AH3', 'MT')
					->setCellValue('AA7', 'GATEPASS TERBIT');

				$this->newphpexcel->headings(array('A6', 'B6', 'C6', 'D6', 'E6', 'F6', 'G6', 'H6', 'I6', 'J6', 'K6', 'L6', 'M6', 'N6', 'O6', 'P6', 'Q6', 'R6', 'S6', 'T6', 'U6', 'V6', 'W6', 'X6', 'Y6', 'AA1', 'AA2', 'AA3', 'AB1', 'AB2', 'AB3', 'AC1', 'AC2', 'AD2', 'AE2', 'AF2', 'AG2', 'AH2', 'AI1', 'AI2', 'AI3', 'AJ1', 'AJ2', 'AJ3', 'AC3', 'AD3', 'AE3', 'AF3', 'AG3', 'AH3', 'AA7', 'AB7', 'AC7', 'AD7', 'AE7', 'AF7', 'AG7', 'AH7', 'AI7', 'AJ7'));
				$this->newphpexcel->set_wrap(array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'W', 'X', 'Y', 'Z'));
				$no = 1;
				$rec = 7;
				if ($result) {
					foreach ($SQL->result_array() as $row) {
						$this->newphpexcel->setActiveSheetIndex(0)
							->setCellValue('A' . $rec, $no)
							->setCellValue('B' . $rec, $row["NO_SPK"])
							->setCellValue('C' . $rec, $row["NO_CONT"])
							->setCellValue('D' . $rec, $row["CLASS"])
							->setCellValue('E' . $rec, $row["NM_ANGKUT"])
							->setCellValue('F' . $rec, $row["NO_VOY"])
							->setCellValue('G' . $rec, $row["STATUS_CONT"])
							->setCellValue('H' . $rec, $row["SIZE"])
							->setCellValue('I' . $rec, $row["ISO_CODE"])
							->setCellValue('J' . $rec, $row["TIPE_CONT"])
							->setCellValue('K' . $rec, $row["IMO"])
							->setCellValue('L' . $rec, $row["JNS_DOK"])
							->setCellValue('M' . $rec, $row["NO_DOK"])
							->setCellValue('N' . $rec, $row["TGL_DOK"])
							->setCellValue('O' . $rec, $row["GATEPASS1"])
							->setCellValue('P' . $rec, $row["W_PICKUP"])
							->setCellValue('Q' . $rec, $row["TID"])
							->setCellValue('R' . $rec, $row["WK_TERMINAL_IN"])
							->setCellValue('S' . $rec, $row["WK_TERMINAL_OUT"])
							->setCellValue('T' . $rec, $row["W_BEHANDLE"])
							->setCellValue('U' . $rec, $row["KONDISI"])
							->setCellValue('V' . $rec, $row["NO_SEAL"])
							->setCellValue('W' . $rec, $row["ISO_CODE"])
							->setCellValue('X' . $rec, $row["ROOM"])
							->setCellValue('Y' . $rec, $row["CUSTOMERS"]);
						$this->newphpexcel->set_detilstyle(array('A' . $rec, 'B' . $rec, 'C' . $rec, 'D' . $rec, 'E' . $rec, 'F' . $rec, 'G' . $rec, 'H' . $rec, 'I' . $rec, 'J' . $rec, 'K' . $rec, 'L' . $rec, 'M' . $rec, 'N' . $rec, 'O' . $rec, 'P' . $rec, 'Q' . $rec, 'R' . $rec, 'S' . $rec, 'T' . $rec, 'U' . $rec, 'V' . $rec, 'W' . $rec, 'X' . $rec, 'Y' . $rec));
						$rec++;
						$no++;
					}

					$rec = 4;
					foreach ($SQL1->result_array() as $row) {
						$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('AA' . $rec, '1')
							->setCellValue('AB' . $rec, 'SPPMP')
							->setCellValue('AC' . $rec, $row["SPPMP_20_FL"])
							->setCellValue('AD' . $rec, $row["SPPMP_20_MT"])
							->setCellValue('AE' . $rec, $row["SPPMP_40_FL"])
							->setCellValue('AF' . $rec, $row["SPPMP_40_MT"])
							->setCellValue('AG' . $rec, $row["SPPMP_45_FL"])
							->setCellValue('AH' . $rec, $row["SPPMP_45_MT"])
							->setCellValue('AI' . $rec, $row["TOTAL_SPPMP"])
							->setCellValue('AJ' . $rec, $row["SPPMP_TEUS"])
							->setCellValue('AI' . '7', $row["TOTAL"]);
						$this->newphpexcel->set_detilstyle(array('AA' . $rec, 'AB' . $rec, 'AC' . $rec, 'AD' . $rec, 'AE' . $rec, 'AF' . $rec, 'AG' . $rec, 'AH' . $rec, 'AI' . $rec, 'AJ' . $rec, 'AI' . $rec));
					}

					$rec = 5;
					foreach ($SQL1->result_array() as $row) {
						$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('AA' . $rec, '2')
							->setCellValue('AB' . $rec, 'SPJM')
							->setCellValue('AC' . $rec, $row["SPJM_20_FL"])
							->setCellValue('AD' . $rec, $row["SPJM_20_MT"])
							->setCellValue('AE' . $rec, $row["SPJM_40_FL"])
							->setCellValue('AF' . $rec, $row["SPJM_40_MT"])
							->setCellValue('AG' . $rec, $row["SPJM_45_FL"])
							->setCellValue('AH' . $rec, $row["SPJM_45_MT"])
							->setCellValue('AI' . $rec, $row["TOTAL_SPJM"])
							->setCellValue('AJ' . $rec, $row["SPJM_TEUS"]);
						$this->newphpexcel->set_detilstyle(array('AA' . $rec, 'AB' . $rec, 'AC' . $rec, 'AD' . $rec, 'AE' . $rec, 'AF' . $rec, 'AG' . $rec, 'AH' . $rec, 'AI' . $rec, 'AJ' . $rec));
					}

					$rec = 6;
					foreach ($SQL1->result_array() as $row) {
						$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('AA' . $rec, '3')
							->setCellValue('AB' . $rec, 'ETC')
							->setCellValue('AC' . $rec, $row["ETC_20_FL"])
							->setCellValue('AD' . $rec, $row["ETC_20_MT"])
							->setCellValue('AE' . $rec, $row["ETC_40_FL"])
							->setCellValue('AF' . $rec, $row["ETC_40_MT"])
							->setCellValue('AG' . $rec, $row["ETC_45_FL"])
							->setCellValue('AH' . $rec, $row["ETC_45_MT"])
							->setCellValue('AI' . $rec, $row["TOTAL_ETC"])
							->setCellValue('AJ' . $rec, $row["ETC_TEUS"]);
						$this->newphpexcel->set_detilstyle(array('AA' . $rec, 'AB' . $rec, 'AC' . $rec, 'AD' . $rec, 'AE' . $rec, 'AF' . $rec, 'AG' . $rec, 'AH' . $rec, 'AI' . $rec, 'AJ' . $rec));
					}
				} else {
					$this->newphpexcel->getActiveSheet()->mergeCells('A10:Z10');
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A10', 'DATA TIDAK DITEMUKAN');
					$this->newphpexcel->set_detilstyle(array('A10'));
				}
				ob_clean();

				$file = "PENARIKAN_" . date("Y-m-d") . ".xls";
				header("Content-type: application/x-msdownload");
				header("Content-Disposition: attachment;filename=$file");
				header("Cache-Control: max-age=0");
				header("Pragma: no-cache");
				header("Expires: 0");
				$objWriter = PHPExcel_IOFactory::createWriter($this->newphpexcel, 'Excel5');
				$objWriter->save('php://output');
				exit();
			} else if ($act == "responpkb") {
				$TanggalRespon = $this->input->post('form[0]');
				$TanggalAwalRespon = $TanggalRespon[0];
				$TanggalAkhirRespon = $TanggalRespon[1];

				$addsql = "";

				if ($TanggalAwalRespon != '' && $TanggalAkhirRespon != '') {
					$addsql .= " AND I.WK_RESPON BETWEEN '$TanggalAwalRespon' AND '$TanggalAkhirRespon' ORDER BY I.WK_RESPON DESC";
				} else if ($TanggalAwalRespon != '') {
					$addsql .= " AND I.WK_RESPON >= '$TanggalAwalRespon' ORDER BY I.WK_RESPON DESC";
				} else if ($TanggalAkhirRespon != '') {
					$addsql .= " AND I.WK_RESPON <= '$TanggalAkhirRespon' ORDER BY I.WK_RESPON DESC";
				} else {
					$addsql .= " ORDER BY I.WK_RESPON DESC";
				}

				$tgl_awal = date("d/m/Y H:i", strtotime($TanggalAwalRespon));
				$tgl_akhir = date("d/m/Y H:i", strtotime($TanggalAkhirRespon));

				// 					$SQL = "SELECT A.NO_DOK AS 'NO_DOKUMEN', A.TGL_DOK AS 'TGL_DOKUMEN', B.NO_CONT AS 'KONTAINER', B.UKR_CONT AS 'SIZE', CONCAT('BEHANDLE ',I.JNS_KEGIATAN) AS 'JENIS_KEGIATAN',
				//  A.CONSIGNEE AS 'CUSTOMERS', H.W_BEHANDLE AS 'WAKTU_TIBA_CA', I.WK_RESPON, I.RESPON AS 'RESPON_PKB', rb.PRN_BEHANDLE_IN as 'SIAP_PERIKSA', 
				//  CASE WHEN I.JNS_KEGIATAN ='1' THEN rb.PB2_START_PERIKSA else rb.PB1_START_PERIKSA END AS 'START_PERIKSA', 
				//  CASE WHEN I.JNS_KEGIATAN ='1' THEN rb.PB2_FINISH_PERIKSA  else rb.PB1_FINISH_PERIKSA END AS 'FINISH_PERIKSA'
				// 						FROM t_spk A
				// 						INNER JOIN t_spk_cont B ON A.ID = B.ID
				// 						LEFT JOIN (SELECT ID, NO_CONT, JNS_CONT AS 'STATUS_CONT', ISO_CODE, KD_CONT_TIPE AS 'TIPE_CONT', WK_IN AS 'STACKING' FROM t_cocostscont GROUP BY NO_CONT ORDER BY ID DESC) C ON B.NO_CONT = C.NO_CONT
				// 						LEFT JOIN t_cocostshdr D ON C.ID = D.ID
				// 							INNER JOIN reff_kode_dok_bc E ON A.JNS_DOK = E.ID
				// 							LEFT JOIN (SELECT ID, NO_CONT, IMO FROM t_request_cont GROUP BY NO_CONT ORDER BY ID DESC) F ON B.NO_CONT = F.NO_CONT
				// 							LEFT JOIN t_request G ON F.ID = G.ID
				// 							INNER JOIN (SELECT A.NO_SPK, B.NO_CONT, A.W_PICKUP, W_BEHANDLE, B.KONDISI_CONT, B.NO_SEAL, B.ROOM FROM t_op_pickup A INNER JOIN t_op_behandlein B ON A.NO_SPK = B.NO_SPK) H ON A.NO_SPK = H.NO_SPK AND C.NO_CONT = H.NO_CONT
				// 							INNER JOIN (SELECT ID, NO_CONT, NO_DOK, RESPON, WK_RESPON, JNS_KEGIATAN FROM t_gatepass WHERE JNS_KEGIATAN IN ('1','2') GROUP BY NO_CONT,JNS_KEGIATAN ORDER BY ID DESC) I ON B.NO_CONT = I.NO_CONT 
				// 							inner join report_behandle rb on rb.REQ_NO_DOK = A.NO_DOK and rb.NO_CONT = B.NO_CONT 
				// 							WHERE 1 = 1 and A.WK_REQ between '$tgl_awal' and '$tgl_akhir'";
				$SQL = "SELECT distinct 
											A.NO_DOK AS 'NO_DOKUMEN',
											A.TGL_DOK AS 'TGL_DOKUMEN',
											B.NO_CONT AS 'KONTAINER',
											B.UKR_CONT AS 'SIZE',
											CONCAT('BEHANDLE ', G.JNS_KEGIATAN) AS 'JENIS_KEGIATAN',
											A.CONSIGNEE AS 'CUSTOMERS',
											F.WK_IN AS 'WAKTU_TIBA_CA',
											G.WK_RESPON,
											G.RESPON AS 'RESPON_PKB',
											H.WK_STATUS as 'SIAP_PERIKSA',
											I.START_INSP as 'START_PERIKSA',
											I.FINISH_INSP as 'FINISH_PERIKSA'
											from t_spk A join t_spk_cont B on A.ID = B.ID
											left join reff_kode_dok_bc AA on A.JNS_DOK = AA.ID
									join t_request C on A.NO_DOK = C.NO_DOK and A.TGL_DOK = C.TGL_DOK
									join t_request_cont D on C.ID = D.ID and D.NO_CONT = B.NO_CONT
									left join t_cocostshdr E on D.VESSEL = E.NM_ANGKUT and D.VOY_IN = E.NO_VOY_FLIGHT 
									left join t_cocostscont EE on E.ID = EE.ID and B.NO_CONT = EE.NO_CONT
									left join t_operation F on A.NO_SPK = F.NO_SPK and B.NO_CONT = F.NO_CONT
									left join t_job_slip H on H.NO_SPK = A.NO_SPK and H.NO_CONT = B.NO_CONT and H.JENIS in ('BEHANDLE 1', 'BEHANDLE 2') and H.KD_STATUS = '50'
									left join t_gatepass G on H.NO_GATEPASS = G.ID
									left join t_op_inspection I on G.NO_DOK= I.NO_DOK and B.NO_CONT = I.NO_CONT and G.JNS_KEGIATAN = I.JNS_KEGIATAN
								WHERE 1 = 1 
										AND G.WK_RESPON BETWEEN '$TanggalAwalRespon' and '$TanggalAkhirRespon'
										and G.STATUS = 'DONE'";

				/*
					$SQL = "SELECT A.NO_DOK AS 'NO_DOKUMEN', A.TGL_DOK AS 'TGL_DOKUMEN', B.NO_CONT AS 'KONTAINER', B.UKR_CONT AS 'SIZE', CONCAT('BEHANDLE ',I.JNS_KEGIATAN) AS 'JENIS_KEGIATAN',
							 A.CONSIGNEE AS 'CUSTOMERS', H.W_BEHANDLE AS 'WAKTU_TIBA_CA', I.WK_RESPON, I.RESPON AS 'RESPON_PKB', rb.PRN_BEHANDLE_IN as 'SIAP_PERIKSA', 
							 CASE WHEN I.JNS_KEGIATAN ='1' THEN rb.PB2_START_PERIKSA else rb.PB1_START_PERIKSA END AS 'START_PERIKSA', 
							 CASE WHEN I.JNS_KEGIATAN ='1' THEN rb.PB2_FINISH_PERIKSA  else rb.PB1_FINISH_PERIKSA END AS 'FINISH_PERIKSA'
						FROM t_spk A
						INNER JOIN t_spk_cont B ON A.ID = B.ID
						LEFT JOIN (SELECT ID, NO_CONT, JNS_CONT AS 'STATUS_CONT', ISO_CODE, KD_CONT_TIPE AS 'TIPE_CONT', WK_IN AS 'STACKING' FROM t_cocostscont GROUP BY NO_CONT ORDER BY ID DESC) C ON B.NO_CONT = C.NO_CONT
						LEFT JOIN t_cocostshdr D ON C.ID = D.ID
							INNER JOIN reff_kode_dok_bc E ON A.JNS_DOK = E.ID
							LEFT JOIN (SELECT ID, NO_CONT, IMO FROM t_request_cont GROUP BY NO_CONT ORDER BY ID DESC) F ON B.NO_CONT = F.NO_CONT
							LEFT JOIN t_request G ON F.ID = G.ID
							INNER JOIN (SELECT A.NO_SPK, B.NO_CONT, A.W_PICKUP, W_BEHANDLE, B.KONDISI_CONT, B.NO_SEAL, B.ROOM FROM t_op_pickup A INNER JOIN t_op_behandlein B ON A.NO_SPK = B.NO_SPK) H ON A.NO_SPK = H.NO_SPK AND C.NO_CONT = H.NO_CONT
							INNER JOIN (SELECT ID, NO_CONT, NO_DOK, RESPON, WK_RESPON, JNS_KEGIATAN FROM t_gatepass WHERE JNS_KEGIATAN IN ('1','2') GROUP BY NO_CONT,JNS_KEGIATAN ORDER BY ID DESC) I ON B.NO_CONT = I.NO_CONT 
							inner join report_behandle rb on rb.REQ_NO_DOK = A.NO_DOK and rb.NO_CONT = B.NO_CONT 
							WHERE 1 = 1".$addsql;
					*/
				$SQL1 = "SELECT distinct COUNT(IF(B.UKR_CONT = '20' AND AA.NAMA = 'SPPMP' AND EE.JNS_CONT = 'F', D.NO_CONT, NULL)) AS 'SPPMP_20_FL', 
													COUNT(IF(B.UKR_CONT = '20' AND AA.NAMA = 'SPPMP' AND EE.JNS_CONT != 'F', D.NO_CONT, NULL)) AS 'SPPMP_20_MT', 
													COUNT(IF(B.UKR_CONT = '40' AND AA.NAMA = 'SPPMP' AND EE.JNS_CONT = 'F', D.NO_CONT, NULL)) AS 'SPPMP_40_FL', 
													COUNT(IF(B.UKR_CONT = '40' AND AA.NAMA = 'SPPMP' AND EE.JNS_CONT != 'F', D.NO_CONT, NULL)) AS 'SPPMP_40_MT', 
													COUNT(IF(B.UKR_CONT = '45' AND AA.NAMA = 'SPPMP' AND EE.JNS_CONT = 'F', D.NO_CONT, NULL)) AS 'SPPMP_45_FL', 
													COUNT(IF(B.UKR_CONT = '45' AND AA.NAMA = 'SPPMP' AND EE.JNS_CONT != 'F', D.NO_CONT, NULL)) AS 'SPPMP_45_MT', 
													COUNT(IF(B.UKR_CONT IN ('20','40','45') AND AA.NAMA = 'SPPMP', D.NO_CONT, NULL)) AS 'TOTAL_SPPMP', 
													COUNT(IF(B.UKR_CONT = '20' AND AA.NAMA = 'SPPMP', D.NO_CONT, NULL)) * 1 + COUNT(IF(B.UKR_CONT = '40' AND AA.NAMA = 'SPPMP', D.NO_CONT, NULL)) * 2 + COUNT(IF(B.UKR_CONT = '45' AND AA.NAMA = 'SPPMP', D.NO_CONT, NULL)) * 2.25 AS 'SPPMP_TEUS',
													COUNT(IF(B.UKR_CONT = '20' AND AA.NAMA = 'SPJM' AND EE.JNS_CONT = 'F', D.NO_CONT, NULL)) AS 'SPJM_20_FL', 
													COUNT(IF(B.UKR_CONT = '20' AND AA.NAMA = 'SPJM' AND EE.JNS_CONT != 'F', D.NO_CONT, NULL)) AS 'SPJM_20_MT', 
													COUNT(IF(B.UKR_CONT = '40' AND AA.NAMA = 'SPJM' AND EE.JNS_CONT = 'F', D.NO_CONT, NULL)) AS 'SPJM_40_FL', 
													COUNT(IF(B.UKR_CONT = '40' AND AA.NAMA = 'SPJM' AND EE.JNS_CONT != 'F', D.NO_CONT, NULL)) AS 'SPJM_40_MT', 
													COUNT(IF(B.UKR_CONT = '45' AND AA.NAMA = 'SPJM' AND EE.JNS_CONT = 'F', D.NO_CONT, NULL)) AS 'SPJM_45_FL', 
													COUNT(IF(B.UKR_CONT = '45' AND AA.NAMA = 'SPJM' AND EE.JNS_CONT != 'F', D.NO_CONT, NULL)) AS 'SPJM_45_MT', 
													COUNT(IF(B.UKR_CONT IN ('20','40','45') AND AA.NAMA = 'SPJM', D.NO_CONT, NULL)) AS 'TOTAL_SPJM',
													COUNT(IF(B.UKR_CONT = '20' AND AA.NAMA = 'SPJM', D.NO_CONT, NULL)) * 1 + COUNT(IF(B.UKR_CONT = '40' AND AA.NAMA = 'SPJM', D.NO_CONT, NULL)) * 2 + COUNT(IF(B.UKR_CONT = '45' AND AA.NAMA = 'SPJM', D.NO_CONT, NULL)) * 2.25 AS 'SPJM_TEUS',
													COUNT(IF(B.UKR_CONT = '20' AND AA.NAMA NOT IN ('SPJM','SPPMP') AND EE.JNS_CONT = 'F', D.NO_CONT, NULL)) AS 'ETC_20_FL', 
													COUNT(IF(B.UKR_CONT = '20' AND AA.NAMA NOT IN ('SPJM','SPPMP') AND EE.JNS_CONT != 'F', D.NO_CONT, NULL)) AS 'ETC_20_MT', 
													COUNT(IF(B.UKR_CONT = '40' AND AA.NAMA NOT IN ('SPJM','SPPMP') AND EE.JNS_CONT = 'F', D.NO_CONT, NULL)) AS 'ETC_40_FL', 
													COUNT(IF(B.UKR_CONT = '40' AND AA.NAMA NOT IN ('SPJM','SPPMP') AND EE.JNS_CONT != 'F', D.NO_CONT, NULL)) AS 'ETC_40_MT', 
													COUNT(IF(B.UKR_CONT = '45' AND AA.NAMA NOT IN ('SPJM','SPPMP') AND EE.JNS_CONT = 'F', D.NO_CONT, NULL)) AS 'ETC_45_FL', 
													COUNT(IF(B.UKR_CONT = '45' AND AA.NAMA NOT IN ('SPJM','SPPMP') AND EE.JNS_CONT != 'F', D.NO_CONT, NULL)) AS 'ETC_45_MT', 
													COUNT(IF(B.UKR_CONT IN ('20','40','45') AND AA.NAMA NOT IN('SPJM','SPPMP'), D.NO_CONT, NULL)) AS 'TOTAL_ETC', 
													COUNT(IF(B.UKR_CONT = '20' AND AA.NAMA NOT IN ('SPJM','SPPMP'), D.NO_CONT, NULL)) * 1 + COUNT(IF(B.UKR_CONT = '40' AND AA.NAMA NOT IN ('SPJM','SPPMP'), D.NO_CONT, NULL)) * 2 + COUNT(IF(B.UKR_CONT = '45' AND AA.NAMA NOT IN ('SPJM','SPPMP'), D.NO_CONT, NULL)) * 2.25 AS 'ETC_TEUS',
													CONCAT(COUNT(D.NO_CONT),' BOX') AS 'TOTAL'
													FROM t_spk A
													INNER JOIN t_spk_cont B ON A.ID = B.ID
													join reff_kode_dok_bc AA on A.JNS_DOK = AA.ID
													join t_request C on A.NO_DOK = C.NO_DOK and A.TGL_DOK = C.TGL_DOK
							join t_request_cont D on C.ID = D.ID and D.NO_CONT = B.NO_CONT
								left join t_cocostshdr E on D.VESSEL = E.NM_ANGKUT and D.VOY_IN = E.NO_VOY_FLIGHT 
								left join t_cocostscont EE on E.ID = EE.ID and B.NO_CONT = EE.NO_CONT
								left join t_operation F on A.NO_SPK = F.NO_SPK and B.NO_CONT = F.NO_CONT
								left join t_job_slip H on H.NO_SPK = A.NO_SPK and H.NO_CONT = B.NO_CONT and H.JENIS in ('BEHANDLE 1', 'BEHANDLE 2') and H.KD_STATUS = '50'
								left join t_gatepass G on H.NO_GATEPASS = G.ID
								left join t_op_inspection I on G.NO_DOK= I.NO_DOK and B.NO_CONT = I.NO_CONT and G.JNS_KEGIATAN = I.JNS_KEGIATAN
							WHERE 1 = 1 
									AND G.WK_RESPON BETWEEN '$tgl_awal' and '$tgl_akhir'
									and G.STATUS = 'DONE'";

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
				$objDrawing->setHeight(40);
				$objDrawing->setWidth(100);
				$objDrawing->setWorksheet($this->newphpexcel->getActiveSheet());
				$this->newphpexcel->setActiveSheetIndex(0);
				$styleArray = array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
				$this->newphpexcel->getDefaultStyle()->applyFromArray($styleArray);
				$this->newphpexcel->set_bold(array('C1'));
				$this->newphpexcel->getActiveSheet()->getStyle("C1:I1")->getFont()->setSize(11);
				$this->newphpexcel->mergecell(array(array('C1', 'I1'), array('C2', 'I2'), array('C3', 'I3'), array('V1', 'V3'), array('W1', 'W3'), array('X1', 'AC1'), array('AJ1', 'AK1'), array('X2', 'Y2'), array('Z2', 'AA2'), array('AB2', 'AC2'), array('AD1', 'AD3'), array('AE1', 'AE3'), array('V7', 'W7'), array('K2', 'K4')), FALSE);
				$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('C1', 'REPORT RESPON PKB');
				$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('C2', 'COMMON GATE IPC TPK');
				$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('C3', $tgl_awal . ' - ' . $tgl_akhir);
				$this->newphpexcel->width(array(array('A', 5), array('B', 20), array('C', 20), array('D', 10), array('E', 20), array('F', 20), array('G', 20), array('H', 15), array('I', 15), array('J', 20), array('K', 15)));

				$this->newphpexcel->setActiveSheetIndex(0)
					->setCellValue('A6', 'NO')
					->setCellValue('B6', 'NO DOKUMEN')
					->setCellValue('C6', 'TGL DOKUMEN')
					->setCellValue('D6', 'KONTAINER')
					->setCellValue('E6', 'UKURAN')
					->setCellValue('F6', 'JENIS KEGIATAN')
					->setCellValue('G6', 'NAMA CUSTOMER')
					->setCellValue('H6', 'WAKTU TIBA')
					->setCellValue('I6', 'WAKTU RESPON')
					->setCellValue('J6', 'RESPON PKB')
					->setCellValue('K6', 'SIAP PERIKSA');
				/*
					$this->newphpexcel->setActiveSheetIndex(0)
						->setCellValue('A6','NO')
						->setCellValue('B6','NO SPK')
						->setCellValue('C6','NO KONTAINER')
						->setCellValue('D6','CLS')
						->setCellValue('E6','VESSEL')
						->setCellValue('F6','VOY')
						->setCellValue('G6','STATUS')
						->setCellValue('H6','SIZE')
						->setCellValue('I6','ISO CODE')
						->setCellValue('J6','TYPE')
						->setCellValue('K6','IMO CODE')
						->setCellValue('L6','JENIS DOKUMEN')
						->setCellValue('M6','NO DOKUMEN')
						->setCellValue('N6','DOKUMEN DATE')
						->setCellValue('O6','TERBIT GATEPASS BEHANDLE')
						->setCellValue('P6','BEHANDLE IN')
						->setCellValue('Q6','RESPON PKB')
						->setCellValue('R6','TANGGAL RESPON PKB')
						->setCellValue('S6','JENIS BEHANDLE')
						->setCellValue('T6','NAMA CUSTOMERS')
						->setCellValue('V1','No')
						->setCellValue('W1','Dokumen')
						->setCellValue('X1','UKURAN')
						->setCellValue('AD1','TOTAL')
						->setCellValue('AE1','TEUS')
						->setCellValue('V7','GATEPASS TERBIT')
						->setCellValue('X2','20')
						->setCellValue('Z2','40')
						->setCellValue('AB2','45')
						->setCellValue('X3','FL')
						->setCellValue('Y3','MT')
						->setCellValue('Z3','FL')
						->setCellValue('AA3','MT')
						->setCellValue('AB3','FL')
						->setCellValue('AC3','MT');
					*/
				$this->newphpexcel->headings(array('A6', 'B6', 'C6', 'D6', 'E6', 'F6', 'G6', 'H6', 'I6', 'J6', 'K6', 'V1', 'V2', 'V3', 'W1', 'W2', 'W3', 'X1', 'AD1', 'AD2', 'AD3', 'AE1', 'AE2', 'AE3', 'V7', 'X2', 'Y2', 'Z2', 'AA2', 'AB2', 'AC2', 'X3', 'Y3', 'Z3', 'AA3', 'AB3', 'AC3', 'X7', 'Y7', 'Z7', 'AA7', 'AB7', 'AC7', 'AD7', 'AE7'));
				//$this->newphpexcel->set_wrap(array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T'));
				$this->newphpexcel->set_wrap(array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K'));
				$no = 1;
				$rec = 7;
				if ($result) {
					foreach ($SQL->result_array() as $row) {

						$this->newphpexcel->setActiveSheetIndex(0)
							->setCellValue('A' . $rec, $no)
							->setCellValue('B' . $rec, $row["NO_DOKUMEN"])
							->setCellValue('C' . $rec, $row["TGL_DOKUMEN"])
							->setCellValue('D' . $rec, $row["KONTAINER"])
							->setCellValue('E' . $rec, $row["SIZE"])
							->setCellValue('F' . $rec, $row["JENIS_KEGIATAN"])
							->setCellValue('G' . $rec, $row["CUSTOMERS"])
							->setCellValue('H' . $rec, $row["WAKTU_TIBA_CA"])
							->setCellValue('I' . $rec, $row["WK_RESPON"])
							->setCellValue('J' . $rec, $row["RESPON_PKB"])
							->setCellValue('K' . $rec, $row["SIAP_PERIKSA"]);

						/*
							$this->newphpexcel->setActiveSheetIndex(0)
							->setCellValue('A'.$rec,$no)
							->setCellValue('B'.$rec,$row["NO_SPK"])
							->setCellValue('C'.$rec,$row["KONTAINER"])
							->setCellValue('D'.$rec,$row["CLASS"])
							->setCellValue('E'.$rec,$row["VOYAGE"])
							->setCellValue('F'.$rec,$row["NO_VOYAGE"])
							->setCellValue('G'.$rec,$row["STATUS_KONTAINER"])
							->setCellValue('H'.$rec,$row["SIZE"])
							->setCellValue('I'.$rec,$row["ISO_CODE"])
							->setCellValue('J'.$rec,$row["TIPE_KONTAINER"])
							->setCellValue('K'.$rec,$row["IMO"])
							->setCellValue('L'.$rec,$row["JENIS_DOKUMEN"])
							->setCellValue('M'.$rec,$row["NO_DOKUMEN"])
							->setCellValue('N'.$rec,$row["TGL_DOKUMEN"])
							->setCellValue('O'.$rec,$row["REQUEST_GATEPASS"])
							->setCellValue('P'.$rec,$row["BEHANDLE_IN"])
							->setCellValue('Q'.$rec,$row["RESPON_PKB"])
							->setCellValue('R'.$rec,$row["WK_RESPON"])
							->setCellValue('S'.$rec,$row["JENIS_KEGIATAN"])
							->setCellValue('T'.$rec,$row["CUSTOMERS"]);
							*/
						//$this->newphpexcel->set_detilstyle(array('A'.$rec,'B'.$rec,'C'.$rec,'D'.$rec,'E'.$rec,'F'.$rec,'G'.$rec,'H'.$rec,'I'.$rec,'J'.$rec,'K'.$rec,'L'.$rec,'M'.$rec,'N'.$rec,'O'.$rec,'P'.$rec,'Q'.$rec,'R'.$rec,'S'.$rec,'T'.$rec));
						$this->newphpexcel->set_detilstyle(array('A' . $rec, 'B' . $rec, 'C' . $rec, 'D' . $rec, 'E' . $rec, 'F' . $rec, 'G' . $rec, 'H' . $rec, 'I' . $rec, 'J' . $rec, 'K' . $rec));
						$rec++;
						$no++;
					}

					$rec = 4;
					foreach ($SQL1->result_array() as $row) {
						$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('V' . $rec, '1')
							->setCellValue('W' . $rec, 'SPPMP')
							->setCellValue('X' . $rec, $row["SPPMP_20_FL"])
							->setCellValue('Y' . $rec, $row["SPPMP_20_MT"])
							->setCellValue('Z' . $rec, $row["SPPMP_40_FL"])
							->setCellValue('AA' . $rec, $row["SPPMP_40_MT"])
							->setCellValue('AB' . $rec, $row["SPPMP_45_FL"])
							->setCellValue('AC' . $rec, $row["SPPMP_45_MT"])
							->setCellValue('AD' . $rec, $row["TOTAL_SPPMP"])
							->setCellValue('AE' . $rec, $row["SPPMP_TEUS"])
							->setCellValue('AD' . '7', $row["TOTAL"]);
						$this->newphpexcel->set_detilstyle(array('V' . $rec, 'W' . $rec, 'X' . $rec, 'Y' . $rec, 'Z' . $rec, 'AA' . $rec, 'AB' . $rec, 'AC' . $rec, 'AD' . $rec, 'AE' . $rec, 'AD' . $rec));
					}

					$rec = 5;
					foreach ($SQL1->result_array() as $row) {
						$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('V' . $rec, '2')
							->setCellValue('W' . $rec, 'SPJM')
							->setCellValue('X' . $rec, $row["SPJM_20_FL"])
							->setCellValue('Y' . $rec, $row["SPJM_20_MT"])
							->setCellValue('Z' . $rec, $row["SPJM_40_FL"])
							->setCellValue('AA' . $rec, $row["SPJM_40_MT"])
							->setCellValue('AB' . $rec, $row["SPJM_45_FL"])
							->setCellValue('AC' . $rec, $row["SPJM_45_MT"])
							->setCellValue('AD' . $rec, $row["TOTAL_SPJM"])
							->setCellValue('AE' . $rec, $row["SPJM_TEUS"]);
						$this->newphpexcel->set_detilstyle(array('V' . $rec, 'W' . $rec, 'X' . $rec, 'Y' . $rec, 'Z' . $rec, 'AA' . $rec, 'AB' . $rec, 'AC' . $rec, 'AD' . $rec, 'AE' . $rec));
					}

					$rec = 6;
					foreach ($SQL1->result_array() as $row) {
						$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('V' . $rec, '3')
							->setCellValue('W' . $rec, 'ETC')
							->setCellValue('X' . $rec, $row["ETC_20_FL"])
							->setCellValue('Y' . $rec, $row["ETC_20_MT"])
							->setCellValue('Z' . $rec, $row["ETC_40_FL"])
							->setCellValue('AA' . $rec, $row["ETC_40_MT"])
							->setCellValue('AB' . $rec, $row["ETC_45_FL"])
							->setCellValue('AC' . $rec, $row["ETC_45_MT"])
							->setCellValue('AD' . $rec, $row["TOTAL_ETC"])
							->setCellValue('AE' . $rec, $row["ETC_TEUS"]);
						$this->newphpexcel->set_detilstyle(array('V' . $rec, 'W' . $rec, 'X' . $rec, 'Y' . $rec, 'Z' . $rec, 'AA' . $rec, 'AB' . $rec, 'AC' . $rec, 'AD' . $rec, 'AE' . $rec));
					}
				} else {
					$this->newphpexcel->getActiveSheet()->mergeCells('A10:T10');
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A10', 'DATA TIDAK DITEMUKAN');
					$this->newphpexcel->set_detilstyle(array('A10'));
				}
				ob_clean();

				$file = "PEMERIKSAAN_PKB_" . date("Y-m-d") . ".xls";
				header("Content-type: application/x-msdownload");
				header("Content-Disposition: attachment;filename=$file");
				header("Cache-Control: max-age=0");
				header("Pragma: no-cache");
				header("Expires: 0");
				$objWriter = PHPExcel_IOFactory::createWriter($this->newphpexcel, 'Excel5');
				$objWriter->save('php://output');
				exit();
			} else if ($act == "siapperiksa") {
				$TanggalMarshalling = $this->input->post('form[0]');
				$TglMarshallingAwal = $TanggalMarshalling[0];
				$TglMarshallingAkhir = $TanggalMarshalling[1];

				$addsql = "";

				if ($TglMarshallingAwal != '' && $TglMarshallingAkhir != '') {
					$addsql .= " AND J.WK_STATUS BETWEEN '$TglMarshallingAwal' AND '$TglMarshallingAkhir' ORDER BY J.WK_STATUS DESC";
				} else if ($TglMarshallingAwal != '') {
					$addsql .= " AND J.WK_STATUS >= '$TglMarshallingAwal' ORDER BY J.WK_STATUS DESC";
				} else if ($TglMarshallingAkhir != '') {
					$addsql .= " AND J.WK_STATUS <= '$TglMarshallingAkhir' ORDER BY J.WK_STATUS DESC";
				} else {
					$addsql .= " ORDER BY J.WK_STATUS DESC";
				}

				$tgl_awal = date("d/m/Y H:i", strtotime($TglMarshallingAwal));
				$tgl_akhir = date("d/m/Y H:i", strtotime($TglMarshallingAkhir));

				$SQL = "SELECT A.NO_SPK AS 'NO_SPK',
					B.NO_CONT AS 'KONTAINER',
					B.UKR_CONT AS 'SIZE',
					'I' AS CLASS,
					E.NM_ANGKUT AS 'VOYAGE',
					E.NO_VOY_FLIGHT AS 'NO_VOYAGE',
					CASE WHEN EE.JNS_CONT ='F' THEN 'FL' ELSE 'MT' END AS 'STATUS_KONTAINER',
					EE.KD_CONT_TIPE AS 'TIPE_KONTAINER',
					D.ISO_CODE AS 'ISO_CODE',
					I.JNS_DOK AS 'JENIS_DOKUMEN',
					I.NO_DOK AS 'NO_DOKUMEN',
					I.TGL_DOK AS 'TGL_DOKUMEN',
					I.WK_REK AS 'GATEPASS_TERBIT',
					H.WK_IN AS 'BEHANDLE_IN',
					I.RESPON AS 'RESPON_PKB',
					J.WK_STATUS AS 'TGL_MARSHALLING',
					J.LOKASI_AKHIR AS 'LOKASI',
					CONCAT('BEHANDLE ',I.JNS_KEGIATAN) AS 'JENIS_KEGIATAN',
					A.CONSIGNEE AS 'CUSTOMERS'
					from t_spk A join t_spk_cont B on A.ID = B.ID
						left join reff_kode_dok_bc AA on A.JNS_DOK = AA.ID
					join t_request C on A.NO_DOK = C.NO_DOK and A.TGL_DOK = C.TGL_DOK
					join t_request_cont D on C.ID = D.ID and D.NO_CONT = B.NO_CONT
					left join t_cocostshdr E on D.VESSEL = E.NM_ANGKUT and D.VOY_IN = E.NO_VOY_FLIGHT 
					left join t_cocostscont EE on E.ID = EE.ID and B.NO_CONT = EE.NO_CONT
					left join t_job_slip J on J.NO_SPK = A.NO_SPK and J.NO_CONT = B.NO_CONT
					left join t_gatepass I on I.ID = J.NO_GATEPASS
					left join t_operation H on H.NO_SPK = A.NO_SPK and H.NO_CONT = B.NO_CONT
					where J.LOKASI_AKHIR LIKE 'CIC%' and I.JNS_KEGIATAN in (1,2)" . $addsql;

				$SQL1 = "SELECT 
									COUNT(IF(B.UKR_CONT = '20' AND AA.NAMA = 'SPPMP' AND EE.JNS_CONT = 'F', B.NO_CONT, NULL)) AS 'SPPMP_20_FL', 
									COUNT(IF(B.UKR_CONT = '20' AND AA.NAMA = 'SPPMP' AND EE.JNS_CONT != 'F', B.NO_CONT, NULL)) AS 'SPPMP_20_MT', 
									COUNT(IF(B.UKR_CONT = '40' AND AA.NAMA = 'SPPMP' AND EE.JNS_CONT = 'F', B.NO_CONT, NULL)) AS 'SPPMP_40_FL', 
									COUNT(IF(B.UKR_CONT = '40' AND AA.NAMA = 'SPPMP' AND EE.JNS_CONT != 'F', B.NO_CONT, NULL)) AS 'SPPMP_40_MT', 
									COUNT(IF(B.UKR_CONT = '45' AND AA.NAMA = 'SPPMP' AND EE.JNS_CONT = 'F', B.NO_CONT, NULL)) AS 'SPPMP_45_FL', 
									COUNT(IF(B.UKR_CONT = '45' AND AA.NAMA = 'SPPMP' AND EE.JNS_CONT != 'F', B.NO_CONT, NULL)) AS 'SPPMP_45_MT', 
									COUNT(IF(B.UKR_CONT IN ('20','40','45') AND AA.NAMA = 'SPPMP', B.NO_CONT, NULL)) AS 'TOTAL_SPPMP', 
									COUNT(IF(B.UKR_CONT = '20' AND AA.NAMA = 'SPPMP', B.NO_CONT, NULL)) * 1 + COUNT(IF(B.UKR_CONT = '40' AND AA.NAMA = 'SPPMP', B.NO_CONT, NULL)) * 2 + COUNT(IF(B.UKR_CONT = '45' AND AA.NAMA = 'SPPMP', B.NO_CONT, NULL)) * 2.25 AS 'SPPMP_TEUS',
									COUNT(IF(B.UKR_CONT = '20' AND AA.NAMA = 'SPJM' AND EE.JNS_CONT = 'F', B.NO_CONT, NULL)) AS 'SPJM_20_FL', 
									COUNT(IF(B.UKR_CONT = '20' AND AA.NAMA = 'SPJM' AND EE.JNS_CONT != 'F', B.NO_CONT, NULL)) AS 'SPJM_20_MT', 
									COUNT(IF(B.UKR_CONT = '40' AND AA.NAMA = 'SPJM' AND EE.JNS_CONT = 'F', B.NO_CONT, NULL)) AS 'SPJM_40_FL', 
									COUNT(IF(B.UKR_CONT = '40' AND AA.NAMA = 'SPJM' AND EE.JNS_CONT != 'F', B.NO_CONT, NULL)) AS 'SPJM_40_MT', 
									COUNT(IF(B.UKR_CONT = '45' AND AA.NAMA = 'SPJM' AND EE.JNS_CONT = 'F', B.NO_CONT, NULL)) AS 'SPJM_45_FL', 
									COUNT(IF(B.UKR_CONT = '45' AND AA.NAMA = 'SPJM' AND EE.JNS_CONT != 'F', B.NO_CONT, NULL)) AS 'SPJM_45_MT', 
									COUNT(IF(B.UKR_CONT IN ('20','40','45') AND AA.NAMA = 'SPJM', B.NO_CONT, NULL)) AS 'TOTAL_SPJM', 
									COUNT(IF(B.UKR_CONT = '20' AND AA.NAMA = 'SPJM', B.NO_CONT, NULL)) * 1 + COUNT(IF(B.UKR_CONT = '40' AND AA.NAMA = 'SPJM', B.NO_CONT, NULL)) * 2 + COUNT(IF(B.UKR_CONT = '45' AND AA.NAMA = 'SPJM', B.NO_CONT, NULL)) * 2.25 AS 'SPJM_TEUS',
									COUNT(IF(B.UKR_CONT = '20' AND AA.NAMA NOT IN ('SPJM','SPPMP') AND EE.JNS_CONT = 'F', B.NO_CONT, NULL)) AS 'ETC_20_FL', 
									COUNT(IF(B.UKR_CONT = '20' AND AA.NAMA NOT IN ('SPJM','SPPMP') AND EE.JNS_CONT != 'F', B.NO_CONT, NULL)) AS 'ETC_20_MT', 
									COUNT(IF(B.UKR_CONT = '40' AND AA.NAMA NOT IN ('SPJM','SPPMP') AND EE.JNS_CONT = 'F', B.NO_CONT, NULL)) AS 'ETC_40_FL', 
									COUNT(IF(B.UKR_CONT = '40' AND AA.NAMA NOT IN ('SPJM','SPPMP') AND EE.JNS_CONT != 'F', B.NO_CONT, NULL)) AS 'ETC_40_MT', 
									COUNT(IF(B.UKR_CONT = '45' AND AA.NAMA NOT IN ('SPJM','SPPMP') AND EE.JNS_CONT = 'F', B.NO_CONT, NULL)) AS 'ETC_45_FL', 
									COUNT(IF(B.UKR_CONT = '45' AND AA.NAMA NOT IN ('SPJM','SPPMP') AND EE.JNS_CONT != 'F', B.NO_CONT, NULL)) AS 'ETC_45_MT', 
									COUNT(IF(B.UKR_CONT IN ('20','40','45') AND AA.NAMA NOT IN('SPJM','SPPMP'), B.NO_CONT, NULL)) AS 'TOTAL_ETC', 
									COUNT(IF(B.UKR_CONT = '20' AND AA.NAMA NOT IN ('SPJM','SPPMP'), B.NO_CONT, NULL)) * 1 + COUNT(IF(B.UKR_CONT = '40' AND AA.NAMA NOT IN ('SPJM','SPPMP'), B.NO_CONT, NULL)) * 2 + COUNT(IF(B.UKR_CONT = '45' AND AA.NAMA NOT IN ('SPJM','SPPMP'), B.NO_CONT, NULL)) * 2.25 AS 'ETC_TEUS',
									CONCAT(COUNT(B.NO_CONT),' BOX') AS 'TOTAL'
								from t_spk A join t_spk_cont B on A.ID = B.ID
												left join reff_kode_dok_bc AA on A.JNS_DOK = AA.ID
											join t_request C on A.NO_DOK = C.NO_DOK and A.TGL_DOK = C.TGL_DOK
											join t_request_cont D on C.ID = D.ID and D.NO_CONT = B.NO_CONT
											left join t_cocostshdr E on D.VESSEL = E.NM_ANGKUT and D.VOY_IN = E.NO_VOY_FLIGHT 
											left join t_cocostscont EE on E.ID = EE.ID and B.NO_CONT = EE.NO_CONT
											left join t_job_slip J on J.NO_SPK = A.NO_SPK and J.NO_CONT = B.NO_CONT
											left join t_gatepass I on I.ID = J.NO_GATEPASS
											left join t_operation H on H.NO_SPK = A.NO_SPK and H.NO_CONT = B.NO_CONT
											where J.LOKASI_AKHIR LIKE 'CIC%' and I.JNS_KEGIATAN in (1,2) " . $addsql;

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
				$objDrawing->setHeight(40);
				$objDrawing->setWidth(100);
				$objDrawing->setWorksheet($this->newphpexcel->getActiveSheet());
				$this->newphpexcel->setActiveSheetIndex(0);
				$styleArray = array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
				$this->newphpexcel->getDefaultStyle()->applyFromArray($styleArray);
				$this->newphpexcel->set_bold(array('C1'));
				$this->newphpexcel->getActiveSheet()->getStyle("C1:I3")->getFont()->setSize(11);
				$this->newphpexcel->mergecell(array(array('C1', 'I1'), array('C2', 'I2'), array('C3', 'I3'), array('W1', 'W3'), array('X1', 'X3'), array('Y1', 'AD1'), array('Y2', 'Z2'), array('AA2', 'AB2'), array('AC2', 'AD2'), array('AK1', 'AK3'), array('AL1', 'AL3'), array('W7', 'X7'), array('L1', 'M1')), FALSE);
				$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('C1', 'REPORT SIAP PERIKSA');
				$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('C2', 'COMMON GATE IPC TPK');
				$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('C3', $tgl_awal . ' - ' . $tgl_akhir);
				$this->newphpexcel->width(array(array('A', 5), array('B', 20), array('C', 20), array('D', 10), array('E', 20), array('F', 20), array('G', 20), array('H', 15), array('I', 15), array('J', 20), array('K', 15), array('L', 15), array('M', 25), array('N', 25), array('O', 25), array('P', 30), array('Q', 45), array('R', 40), array('S', 20), array('T', 40), array('U', 40)));

				$this->newphpexcel->setActiveSheetIndex(0)
					->setCellValue('A6', 'NO')
					->setCellValue('B6', 'NO SPK')
					->setCellValue('C6', 'NO KONTAINER')
					->setCellValue('D6', 'CLASS')
					->setCellValue('E6', 'VESSEL')
					->setCellValue('F6', 'NO VOYAGE')
					->setCellValue('G6', 'STATUS')
					->setCellValue('H6', 'SIZE')
					->setCellValue('I6', 'ISO CODE')
					->setCellValue('J6', 'TIPE')
					->setCellValue('K6', 'IMO CODE')
					->setCellValue('L6', 'JENIS DOKUMEN')
					->setCellValue('M6', 'NO DOKUMEN')
					->setCellValue('N6', 'TANGGAL DOKUMEN')
					->setCellValue('O6', 'TERBIT GATEPASS BEHANDLE')
					->setCellValue('P6', 'BEHANDLE IN')
					->setCellValue('Q6', 'RESPON PKB')
					->setCellValue('R6', 'MARSHALLING BEHANDLE')
					->setCellValue('S6', 'LOKASI')
					->setCellValue('T6', 'JENIS BEHANDLE')
					->setCellValue('U6', 'CUSTOMERS')
					->setCellValue('W1', 'No')
					->setCellValue('X1', 'Dokumen')
					->setCellValue('Y1', 'UKURAN')
					->setCellValue('W7', 'GATEPASS TERBIT')
					->setCellValue('Y2', '20')
					->setCellValue('AA2', '40')
					->setCellValue('AC2', '45')
					->setCellValue('AE1', 'TOTAL')
					->setCellValue('AF1', 'TEUS')
					->setCellValue('Y3', 'FL')
					->setCellValue('Z3', 'MT')
					->setCellValue('AA3', 'FL')
					->setCellValue('AB3', 'MT')
					->setCellValue('AC3', 'FL')
					->setCellValue('AD3', 'MT');

				$this->newphpexcel->headings(array('A6', 'B6', 'C6', 'D6', 'E6', 'F6', 'G6', 'H6', 'I6', 'J6', 'K6', 'L6', 'M6', 'N6', 'O6', 'P6', 'Q6', 'R6', 'S6', 'T6', 'U6', 'W1', 'W2', 'W3', 'X1', 'X2', 'X3', 'Y1', 'Y2', 'Z2', 'AE1', 'W7', 'AA2', 'AB2', 'AC2', 'AD2', 'AE1', 'AE2', 'AE3', 'AF1', 'AF2', 'AF3', 'Y3', 'Z3', 'AA3', 'AB3', 'AC3', 'AD3', 'W7', 'X7', 'Y7', 'Z7', 'AA7', 'AB7', 'AC7', 'AD7', 'AE7', 'AF7'));
				$this->newphpexcel->set_wrap(array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U'));
				$no = 1;
				$rec = 7;
				if ($result) {
					foreach ($SQL->result_array() as $row) {
						$this->newphpexcel->setActiveSheetIndex(0)
							->setCellValue('A' . $rec, $no)
							->setCellValue('B' . $rec, $row["NO_SPK"])
							->setCellValue('C' . $rec, $row["KONTAINER"])
							->setCellValue('D' . $rec, $row["CLASS"])
							->setCellValue('E' . $rec, $row["VOYAGE"])
							->setCellValue('F' . $rec, $row["NO_VOYAGE"])
							->setCellValue('G' . $rec, $row["STATUS_KONTAINER"])
							->setCellValue('H' . $rec, $row["SIZE"])
							->setCellValue('I' . $rec, $row["ISO_CODE"])
							->setCellValue('J' . $rec, $row["TIPE_KONTAINER"])
							->setCellValue('K' . $rec, $row["IMO"])
							->setCellValue('L' . $rec, $row["JENIS_DOKUMEN"])
							->setCellValue('M' . $rec, $row["NO_DOKUMEN"])
							->setCellValue('N' . $rec, $row["TGL_DOKUMEN"])
							->setCellValue('O' . $rec, $row["GATEPASS_TERBIT"])
							->setCellValue('P' . $rec, $row["BEHANDLE_IN"])
							->setCellValue('Q' . $rec, $row["RESPON_PKB"])
							->setCellValue('R' . $rec, $row["TGL_MARSHALLING"])
							->setCellValue('S' . $rec, $row["LOKASI"])
							->setCellValue('T' . $rec, $row["JENIS_KEGIATAN"])
							->setCellValue('U' . $rec, $row["CUSTOMERS"]);
						$this->newphpexcel->set_detilstyle(array('A' . $rec, 'B' . $rec, 'C' . $rec, 'D' . $rec, 'E' . $rec, 'F' . $rec, 'G' . $rec, 'H' . $rec, 'I' . $rec, 'J' . $rec, 'K' . $rec, 'L' . $rec, 'M' . $rec, 'N' . $rec, 'O' . $rec, 'P' . $rec, 'Q' . $rec, 'R' . $rec, 'S' . $rec, 'T' . $rec, 'U' . $rec));
						$rec++;
						$no++;
					}

					$rec = 4;
					foreach ($SQL1->result_array() as $row) {
						$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('W' . $rec, '1')
							->setCellValue('X' . $rec, 'SPPMP')
							->setCellValue('Y' . $rec, $row["SPPMP_20_FL"])
							->setCellValue('Z' . $rec, $row["SPPMP_20_MT"])
							->setCellValue('AA' . $rec, $row["SPPMP_40_FL"])
							->setCellValue('AB' . $rec, $row["SPPMP_40_MT"])
							->setCellValue('AC' . $rec, $row["SPPMP_45_FL"])
							->setCellValue('AD' . $rec, $row["SPPMP_45_MT"])
							->setCellValue('AE' . $rec, $row["TOTAL_SPPMP"])
							->setCellValue('AF' . $rec, $row["SPPMP_TEUS"])
							->setCellValue('AE' . '7', $row["TOTAL"]);
						$this->newphpexcel->set_detilstyle(array('W' . $rec, 'X' . $rec, 'Y' . $rec, 'Z' . $rec, 'AA' . $rec, 'AB' . $rec, 'AC' . $rec, 'AD' . $rec, 'AE' . $rec, 'AF' . $rec, 'AE' . $rec));
					}

					$rec = 5;
					foreach ($SQL1->result_array() as $row) {
						$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('W' . $rec, '2')
							->setCellValue('X' . $rec, 'SPJM')
							->setCellValue('Y' . $rec, $row["SPJM_20_FL"])
							->setCellValue('Z' . $rec, $row["SPJM_20_MT"])
							->setCellValue('AA' . $rec, $row["SPJM_40_FL"])
							->setCellValue('AB' . $rec, $row["SPJM_40_MT"])
							->setCellValue('AC' . $rec, $row["SPJM_45_FL"])
							->setCellValue('AD' . $rec, $row["SPJM_45_MT"])
							->setCellValue('AE' . $rec, $row["TOTAL_SPJM"])
							->setCellValue('AF' . $rec, $row["SPJM_TEUS"]);
						$this->newphpexcel->set_detilstyle(array('W' . $rec, 'X' . $rec, 'Y' . $rec, 'Z' . $rec, 'AA' . $rec, 'AB' . $rec, 'AC' . $rec, 'AD' . $rec, 'AE' . $rec, 'AF' . $rec));
					}

					$rec = 6;
					foreach ($SQL1->result_array() as $row) {
						$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('W' . $rec, '3')
							->setCellValue('X' . $rec, 'ETC')
							->setCellValue('Y' . $rec, $row["ETC_20_FL"])
							->setCellValue('Z' . $rec, $row["ETC_20_MT"])
							->setCellValue('AA' . $rec, $row["ETC_40_FL"])
							->setCellValue('AB' . $rec, $row["ETC_40_MT"])
							->setCellValue('AC' . $rec, $row["ETC_45_FL"])
							->setCellValue('AD' . $rec, $row["ETC_45_MT"])
							->setCellValue('AE' . $rec, $row["TOTAL_ETC"])
							->setCellValue('AF' . $rec, $row["ETC_TEUS"]);
						$this->newphpexcel->set_detilstyle(array('W' . $rec, 'X' . $rec, 'Y' . $rec, 'Z' . $rec, 'AA' . $rec, 'AB' . $rec, 'AC' . $rec, 'AD' . $rec, 'AE' . $rec, 'AF' . $rec));
					}
				} else {
					$this->newphpexcel->getActiveSheet()->mergeCells('A10:U10');
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A10', 'DATA TIDAK DITEMUKAN');
					$this->newphpexcel->set_detilstyle(array('A10'));
				}
				ob_clean();

				$file = "SIAP_PERIKSA_" . date("Y-m-d") . ".xls";
				header("Content-type: application/x-msdownload");
				header("Content-Disposition: attachment;filename=$file");
				header("Cache-Control: max-age=0");
				header("Pragma: no-cache");
				header("Expires: 0");
				$objWriter = PHPExcel_IOFactory::createWriter($this->newphpexcel, 'Excel5');
				$objWriter->save('php://output');
				exit();
			} else if ($act == "pemeriksaan") {
				$TanggalSelesaiPeriksa = $this->input->post('form[0]');
				$TglSelesaiPeriksaAwal = $TanggalSelesaiPeriksa[0];
				$TglSelesaiPeriksaAkhir = $TanggalSelesaiPeriksa[1];

				$addsql = " ";

				if ($TglSelesaiPeriksaAwal != '' && $TglSelesaiPeriksaAkhir != '') {
					$addsql .= " AND K.FINISH_INSP BETWEEN '$TglSelesaiPeriksaAwal' AND '$TglSelesaiPeriksaAkhir' ORDER BY K.FINISH_INSP DESC";
				} else if ($TglSelesaiPeriksaAwal != '') {
					$addsql .= " AND K.FINISH_INSP >= '$TglSelesaiPeriksaAwal' ORDER BY K.FINISH_INSP DESC";
				} else if ($TglSelesaiPeriksaAkhir != '') {
					$addsql .= " AND K.FINISH_INSP <= '$TglSelesaiPeriksaAkhir' ORDER BY K.FINISH_INSP DESC";
				} else {
					$addsql .= " ORDER BY K.FINISH_INSP DESC";
				}

				$tgl_awal = date("d/m/Y H:i", strtotime($TglSelesaiPeriksaAwal));
				$tgl_akhir = date("d/m/Y H:i", strtotime($TglSelesaiPeriksaAkhir));

				// $SQL = "SELECT A.NO_SPK AS 'NO_SPK', B.NO_CONT AS 'KONTAINER', 'I' AS CLASS, E.NM_ANGKUT AS 'VOYAGE', E.NO_VOY_FLIGHT AS 'NO_VOYAGE', CASE WHEN D.JNS_CONT ='F' THEN 'FL' ELSE 'MT' END AS 'STATUS_KONTAINER', B.UKR_CONT AS 'SIZE', B.ISO_CODE AS 'ISO_CODE', KD_CONT_TIPE AS 'TIPE_KONTAINER', F.IMO, H.JNS_DOK AS 'JENIS_DOKUMEN', H.NO_DOK AS 'NO_DOKUMEN', H.TGL_DOK AS 'TGL_DOKUMEN', H.WK_REK AS 'TERBIT_GATEPASS', I.WK_STATUS AS 'MARSHALLING_BEHANDLE', I.LOKASI_AKHIR AS 'LOKASI_MARSHALLING', J.START_INSP AS 'START_PEMERIKSAAN', J.FINISH_INSP AS 'FINISH_PEMERIKSAAN', J.NO_SEAL AS 'NEW_SEAL_NUMBER', CONCAT('BEHANDLE ',H.JNS_KEGIATAN) AS 'JENIS_KEGIATAN', A.CONSIGNEE AS 'CUSTOMERS'
				// 	FROM t_spk A
				// 	INNER JOIN t_spk_cont B ON A.ID = B.ID
				// 	INNER JOIN reff_kode_dok_bc C ON A.JNS_DOK = C.ID
				// 	LEFT JOIN (SELECT ID, NO_CONT, JNS_CONT, ISO_CODE, KD_CONT_TIPE, WK_IN, WK_OUT FROM t_cocostscont GROUP BY NO_CONT ORDER BY ID DESC) D ON B.NO_CONT = D.NO_CONT
				// 	LEFT JOIN t_cocostshdr E ON D.ID = E.ID
				// 	LEFT JOIN (SELECT ID, NO_CONT, IMO FROM t_request_cont GROUP BY NO_CONT ORDER BY ID DESC) F ON B.NO_CONT = F.NO_CONT
				// 	LEFT JOIN t_request G ON F.ID = G.ID AND A.NO_DOK = G.NO_DOK
				// 	INNER JOIN (SELECT ID, NO_CONT, JNS_DOK,NO_DOK, TGL_DOK, RESPON, WK_RESPON, JNS_KEGIATAN, WK_REK FROM t_gatepass WHERE JNS_KEGIATAN IN ('1','2') GROUP BY NO_CONT,JNS_KEGIATAN ORDER BY ID DESC) H ON B.NO_CONT = H.NO_CONT
				// 	INNER JOIN (SELECT NO_SPK, NO_CONT, NO_GATEPASS, LOKASI_AKHIR, WK_STATUS FROM t_job_slip WHERE LOKASI_AKHIR LIKE 'CIC%' GROUP BY NO_CONT ORDER BY ID_JOB_SLIP DESC) I ON A.NO_SPK = I.NO_SPK AND B.NO_CONT = I.NO_CONT
				// 	INNER JOIN (SELECT NO_CONT, NO_SEAL, START_INSP, FINISH_INSP, JNS_DOK, NO_DOK, TGL_DOK, NO_SPK FROM t_op_inspection WHERE START_INSP IS NOT NULL AND FINISH_INSP IS NOT NULL GROUP BY NO_CONT ORDER BY ID DESC) J ON A.NO_SPK = J.NO_SPK AND B.NO_CONT = J.NO_CONT AND H.NO_DOK = J.NO_DOK
				// 	WHERE 1 = 1".$addsql;


				$SQL = "SELECT A.NO_SPK AS 'NO_SPK',
						B.NO_CONT AS 'KONTAINER', 'I' AS CLASS,
						E.NM_ANGKUT AS 'VOYAGE',
						E.NO_VOY_FLIGHT AS 'NO_VOYAGE',
						CASE WHEN EE.JNS_CONT ='F' THEN 'FL' ELSE 'MT' END AS 'STATUS_KONTAINER',
						B.UKR_CONT AS 'SIZE',
						B.ISO_CODE AS 'ISO_CODE',
						KD_CONT_TIPE AS 'TIPE_KONTAINER',
						D.IMO,
						I.JNS_DOK AS 'JENIS_DOKUMEN',
						I.NO_DOK AS 'NO_DOKUMEN',
						I.TGL_DOK AS 'TGL_DOKUMEN',
						I.WK_REK AS 'TERBIT_GATEPASS',
						J.WK_STATUS AS 'MARSHALLING_BEHANDLE',
						J.LOKASI_AKHIR AS 'LOKASI_MARSHALLING',
						K.START_INSP AS 'START_PEMERIKSAAN',
						K.FINISH_INSP AS 'FINISH_PEMERIKSAAN',
						K.NO_SEAL AS 'NEW_SEAL_NUMBER',
						CONCAT('BEHANDLE ',I.JNS_KEGIATAN) AS 'JENIS_KEGIATAN',
						A.CONSIGNEE AS 'CUSTOMERS'
							from t_spk A join t_spk_cont B on A.ID = B.ID
							left join reff_kode_dok_bc AA on A.JNS_DOK = AA.ID
							join t_request C on A.NO_DOK = C.NO_DOK and A.TGL_DOK = C.TGL_DOK
							join t_request_cont D on C.ID = D.ID and D.NO_CONT = B.NO_CONT
							left join t_cocostshdr E on D.VESSEL = E.NM_ANGKUT and D.VOY_IN = E.NO_VOY_FLIGHT 
							left join t_cocostscont EE on E.ID = EE.ID and B.NO_CONT = EE.NO_CONT
							left join t_job_slip J on J.NO_SPK = A.NO_SPK and J.NO_CONT = B.NO_CONT and J.JENIS in ('BEHANDLE 1','BEHANDLE 2')
							left join t_gatepass I on I.ID = J.NO_GATEPASS
							left join t_op_inspection K on K.NO_DOK = I.NO_DOK and K.NO_CONT = I.NO_CONT
							where I.STATUS = 'DONE'" . $addsql;

				// $SQL1 = "SELECT 
				// 	COUNT(IF(B.UKR_CONT = '20' AND C.NAMA = 'SPPMP' AND D.JNS_CONT = 'F', B.NO_CONT, NULL)) AS 'SPPMP_20_FL', 
				// 	COUNT(IF(B.UKR_CONT = '20' AND C.NAMA = 'SPPMP' AND D.JNS_CONT != 'F', B.NO_CONT, NULL)) AS 'SPPMP_20_MT', 
				// 	COUNT(IF(B.UKR_CONT = '40' AND C.NAMA = 'SPPMP' AND D.JNS_CONT = 'F', B.NO_CONT, NULL)) AS 'SPPMP_40_FL', 
				// 	COUNT(IF(B.UKR_CONT = '40' AND C.NAMA = 'SPPMP' AND D.JNS_CONT != 'F', B.NO_CONT, NULL)) AS 'SPPMP_40_MT', 
				// 	COUNT(IF(B.UKR_CONT = '45' AND C.NAMA = 'SPPMP' AND D.JNS_CONT = 'F', B.NO_CONT, NULL)) AS 'SPPMP_45_FL', 
				// 	COUNT(IF(B.UKR_CONT = '45' AND C.NAMA = 'SPPMP' AND D.JNS_CONT != 'F', B.NO_CONT, NULL)) AS 'SPPMP_45_MT', 
				// 	COUNT(IF(B.UKR_CONT IN ('20','40','45') AND C.NAMA = 'SPPMP', B.NO_CONT, NULL)) AS 'TOTAL_SPPMP', 
				// 	COUNT(IF(B.UKR_CONT = '20' AND C.NAMA = 'SPPMP', B.NO_CONT, NULL)) * 1 + COUNT(IF(B.UKR_CONT = '40' AND C.NAMA = 'SPPMP', B.NO_CONT, NULL)) * 2 + COUNT(IF(B.UKR_CONT = '45' AND C.NAMA = 'SPPMP', B.NO_CONT, NULL)) * 2.25 AS 'SPPMP_TEUS',
				// 	COUNT(IF(B.UKR_CONT = '20' AND C.NAMA = 'SPJM' AND D.JNS_CONT = 'F', B.NO_CONT, NULL)) AS 'SPJM_20_FL', 
				// 	COUNT(IF(B.UKR_CONT = '20' AND C.NAMA = 'SPJM' AND D.JNS_CONT != 'F', B.NO_CONT, NULL)) AS 'SPJM_20_MT', 
				// 	COUNT(IF(B.UKR_CONT = '40' AND C.NAMA = 'SPJM' AND D.JNS_CONT = 'F', B.NO_CONT, NULL)) AS 'SPJM_40_FL', 
				// 	COUNT(IF(B.UKR_CONT = '40' AND C.NAMA = 'SPJM' AND D.JNS_CONT != 'F', B.NO_CONT, NULL)) AS 'SPJM_40_MT', 
				// 	COUNT(IF(B.UKR_CONT = '45' AND C.NAMA = 'SPJM' AND D.JNS_CONT = 'F', B.NO_CONT, NULL)) AS 'SPJM_45_FL', 
				// 	COUNT(IF(B.UKR_CONT = '45' AND C.NAMA = 'SPJM' AND D.JNS_CONT != 'F', B.NO_CONT, NULL)) AS 'SPJM_45_MT', 
				// 	COUNT(IF(B.UKR_CONT IN ('20','40','45') AND C.NAMA = 'SPJM', B.NO_CONT, NULL)) AS 'TOTAL_SPJM', 
				// 	COUNT(IF(B.UKR_CONT = '20' AND C.NAMA = 'SPJM', B.NO_CONT, NULL)) * 1 + COUNT(IF(B.UKR_CONT = '40' AND C.NAMA = 'SPJM', B.NO_CONT, NULL)) * 2 + COUNT(IF(B.UKR_CONT = '45' AND C.NAMA = 'SPJM', B.NO_CONT, NULL)) * 2.25 AS 'SPJM_TEUS',
				// 	COUNT(IF(B.UKR_CONT = '20' AND C.NAMA NOT IN ('SPJM','SPPMP') AND D.JNS_CONT = 'F', B.NO_CONT, NULL)) AS 'ETC_20_FL', 
				// 	COUNT(IF(B.UKR_CONT = '20' AND C.NAMA NOT IN ('SPJM','SPPMP') AND D.JNS_CONT != 'F', B.NO_CONT, NULL)) AS 'ETC_20_MT', 
				// 	COUNT(IF(B.UKR_CONT = '40' AND C.NAMA NOT IN ('SPJM','SPPMP') AND D.JNS_CONT = 'F', B.NO_CONT, NULL)) AS 'ETC_40_FL', 
				// 	COUNT(IF(B.UKR_CONT = '40' AND C.NAMA NOT IN ('SPJM','SPPMP') AND D.JNS_CONT != 'F', B.NO_CONT, NULL)) AS 'ETC_40_MT', 
				// 	COUNT(IF(B.UKR_CONT = '45' AND C.NAMA NOT IN ('SPJM','SPPMP') AND D.JNS_CONT = 'F', B.NO_CONT, NULL)) AS 'ETC_45_FL', 
				// 	COUNT(IF(B.UKR_CONT = '45' AND C.NAMA NOT IN ('SPJM','SPPMP') AND D.JNS_CONT != 'F', B.NO_CONT, NULL)) AS 'ETC_45_MT', 
				// 	COUNT(IF(B.UKR_CONT IN ('20','40','45') AND C.NAMA NOT IN('SPJM','SPPMP'), B.NO_CONT, NULL)) AS 'TOTAL_ETC', 
				// 	COUNT(IF(B.UKR_CONT = '20' AND C.NAMA NOT IN ('SPJM','SPPMP'), B.NO_CONT, NULL)) * 1 + COUNT(IF(B.UKR_CONT = '40' AND C.NAMA NOT IN ('SPJM','SPPMP'), B.NO_CONT, NULL)) * 2 + COUNT(IF(B.UKR_CONT = '45' AND C.NAMA NOT IN ('SPJM','SPPMP'), B.NO_CONT, NULL)) * 2.25 AS 'ETC_TEUS',
				// 	CONCAT(COUNT(B.NO_CONT),' BOX') AS 'TOTAL'
				// 	FROM t_spk A
				// 	INNER JOIN t_spk_cont B ON A.ID = B.ID
				// 	INNER JOIN reff_kode_dok_bc C ON A.JNS_DOK = C.ID
				// 	LEFT JOIN (SELECT ID, NO_CONT, JNS_CONT, ISO_CODE, KD_CONT_TIPE, WK_IN, WK_OUT FROM t_cocostscont GROUP BY NO_CONT ORDER BY ID DESC) D ON B.NO_CONT = D.NO_CONT
				// 	LEFT JOIN t_cocostshdr E ON D.ID = E.ID
				// 	LEFT JOIN (SELECT ID, NO_CONT, IMO FROM t_request_cont GROUP BY NO_CONT ORDER BY ID DESC) F ON B.NO_CONT = F.NO_CONT
				// 	LEFT JOIN t_request G ON F.ID = G.ID AND A.NO_DOK = G.NO_DOK
				// 	INNER JOIN (SELECT ID, NO_CONT, JNS_DOK,NO_DOK, TGL_DOK, RESPON, WK_RESPON, JNS_KEGIATAN, WK_REK FROM t_gatepass WHERE JNS_KEGIATAN IN ('1','2') GROUP BY NO_CONT,JNS_KEGIATAN ORDER BY ID DESC) H ON B.NO_CONT = H.NO_CONT
				// 	INNER JOIN (SELECT NO_SPK, NO_CONT, NO_GATEPASS, LOKASI_AKHIR, WK_STATUS FROM t_job_slip WHERE LOKASI_AKHIR LIKE 'CIC%' GROUP BY NO_CONT ORDER BY ID_JOB_SLIP DESC) I ON A.NO_SPK = I.NO_SPK AND B.NO_CONT = I.NO_CONT
				// 	INNER JOIN (SELECT NO_CONT, NO_SEAL, START_INSP, FINISH_INSP, JNS_DOK, NO_DOK, TGL_DOK, NO_SPK FROM t_op_inspection WHERE START_INSP IS NOT NULL AND FINISH_INSP IS NOT NULL GROUP BY NO_CONT ORDER BY ID DESC) J ON A.NO_SPK = J.NO_SPK AND B.NO_CONT = J.NO_CONT AND H.NO_DOK = J.NO_DOK
				// 	WHERE 1 = 1 ".$addsql;


				$SQL1 = "SELECT 
										COUNT(IF(B.UKR_CONT = '20' AND AA.NAMA = 'SPPMP' AND EE.JNS_CONT = 'F', B.NO_CONT, NULL)) AS 'SPPMP_20_FL', 
										COUNT(IF(B.UKR_CONT = '20' AND AA.NAMA = 'SPPMP' AND EE.JNS_CONT != 'F', B.NO_CONT, NULL)) AS 'SPPMP_20_MT', 
										COUNT(IF(B.UKR_CONT = '40' AND AA.NAMA = 'SPPMP' AND EE.JNS_CONT = 'F', B.NO_CONT, NULL)) AS 'SPPMP_40_FL', 
										COUNT(IF(B.UKR_CONT = '40' AND AA.NAMA = 'SPPMP' AND EE.JNS_CONT != 'F', B.NO_CONT, NULL)) AS 'SPPMP_40_MT', 
										COUNT(IF(B.UKR_CONT = '45' AND AA.NAMA = 'SPPMP' AND EE.JNS_CONT = 'F', B.NO_CONT, NULL)) AS 'SPPMP_45_FL', 
										COUNT(IF(B.UKR_CONT = '45' AND AA.NAMA = 'SPPMP' AND EE.JNS_CONT != 'F', B.NO_CONT, NULL)) AS 'SPPMP_45_MT', 
										COUNT(IF(B.UKR_CONT IN ('20','40','45') AND AA.NAMA = 'SPPMP', B.NO_CONT, NULL)) AS 'TOTAL_SPPMP', 
										COUNT(IF(B.UKR_CONT = '20' AND AA.NAMA = 'SPPMP', B.NO_CONT, NULL)) * 1 + COUNT(IF(B.UKR_CONT = '40' AND AA.NAMA = 'SPPMP', B.NO_CONT, NULL)) * 2 + COUNT(IF(B.UKR_CONT = '45' AND AA.NAMA = 'SPPMP', B.NO_CONT, NULL)) * 2.25 AS 'SPPMP_TEUS',
										COUNT(IF(B.UKR_CONT = '20' AND AA.NAMA = 'SPJM' AND EE.JNS_CONT = 'F', B.NO_CONT, NULL)) AS 'SPJM_20_FL', 
										COUNT(IF(B.UKR_CONT = '20' AND AA.NAMA = 'SPJM' AND EE.JNS_CONT != 'F', B.NO_CONT, NULL)) AS 'SPJM_20_MT', 
										COUNT(IF(B.UKR_CONT = '40' AND AA.NAMA = 'SPJM' AND EE.JNS_CONT = 'F', B.NO_CONT, NULL)) AS 'SPJM_40_FL', 
										COUNT(IF(B.UKR_CONT = '40' AND AA.NAMA = 'SPJM' AND EE.JNS_CONT != 'F', B.NO_CONT, NULL)) AS 'SPJM_40_MT', 
										COUNT(IF(B.UKR_CONT = '45' AND AA.NAMA = 'SPJM' AND EE.JNS_CONT = 'F', B.NO_CONT, NULL)) AS 'SPJM_45_FL', 
										COUNT(IF(B.UKR_CONT = '45' AND AA.NAMA = 'SPJM' AND EE.JNS_CONT != 'F', B.NO_CONT, NULL)) AS 'SPJM_45_MT', 
										COUNT(IF(B.UKR_CONT IN ('20','40','45') AND AA.NAMA = 'SPJM', B.NO_CONT, NULL)) AS 'TOTAL_SPJM', 
										COUNT(IF(B.UKR_CONT = '20' AND AA.NAMA = 'SPJM', B.NO_CONT, NULL)) * 1 + COUNT(IF(B.UKR_CONT = '40' AND AA.NAMA = 'SPJM', B.NO_CONT, NULL)) * 2 + COUNT(IF(B.UKR_CONT = '45' AND AA.NAMA = 'SPJM', B.NO_CONT, NULL)) * 2.25 AS 'SPJM_TEUS',
										COUNT(IF(B.UKR_CONT = '20' AND AA.NAMA NOT IN ('SPJM','SPPMP') AND EE.JNS_CONT = 'F', B.NO_CONT, NULL)) AS 'ETC_20_FL', 
										COUNT(IF(B.UKR_CONT = '20' AND AA.NAMA NOT IN ('SPJM','SPPMP') AND EE.JNS_CONT != 'F', B.NO_CONT, NULL)) AS 'ETC_20_MT', 
										COUNT(IF(B.UKR_CONT = '40' AND AA.NAMA NOT IN ('SPJM','SPPMP') AND EE.JNS_CONT = 'F', B.NO_CONT, NULL)) AS 'ETC_40_FL', 
										COUNT(IF(B.UKR_CONT = '40' AND AA.NAMA NOT IN ('SPJM','SPPMP') AND EE.JNS_CONT != 'F', B.NO_CONT, NULL)) AS 'ETC_40_MT', 
										COUNT(IF(B.UKR_CONT = '45' AND AA.NAMA NOT IN ('SPJM','SPPMP') AND EE.JNS_CONT = 'F', B.NO_CONT, NULL)) AS 'ETC_45_FL', 
										COUNT(IF(B.UKR_CONT = '45' AND AA.NAMA NOT IN ('SPJM','SPPMP') AND EE.JNS_CONT != 'F', B.NO_CONT, NULL)) AS 'ETC_45_MT', 
										COUNT(IF(B.UKR_CONT IN ('20','40','45') AND AA.NAMA NOT IN('SPJM','SPPMP'), B.NO_CONT, NULL)) AS 'TOTAL_ETC', 
										COUNT(IF(B.UKR_CONT = '20' AND AA.NAMA NOT IN ('SPJM','SPPMP'), B.NO_CONT, NULL)) * 1 + COUNT(IF(B.UKR_CONT = '40' AND AA.NAMA NOT IN ('SPJM','SPPMP'), B.NO_CONT, NULL)) * 2 + COUNT(IF(B.UKR_CONT = '45' AND AA.NAMA NOT IN ('SPJM','SPPMP'), B.NO_CONT, NULL)) * 2.25 AS 'ETC_TEUS',
										CONCAT(COUNT(B.NO_CONT),' BOX') AS 'TOTAL'
									from t_spk A join t_spk_cont B on A.ID = B.ID
									left join reff_kode_dok_bc AA on A.JNS_DOK = AA.ID
									join t_request C on A.NO_DOK = C.NO_DOK and A.TGL_DOK = C.TGL_DOK
									join t_request_cont D on C.ID = D.ID and D.NO_CONT = B.NO_CONT
									left join t_cocostshdr E on D.VESSEL = E.NM_ANGKUT and D.VOY_IN = E.NO_VOY_FLIGHT 
									left join t_cocostscont EE on E.ID = EE.ID and B.NO_CONT = EE.NO_CONT
									left join t_job_slip J on J.NO_SPK = A.NO_SPK and J.NO_CONT = B.NO_CONT and J.JENIS in ('BEHANDLE 1','BEHANDLE 2')
									left join t_gatepass I on I.ID = J.NO_GATEPASS
									left join t_op_inspection K on K.NO_DOK = I.NO_DOK and K.NO_CONT = I.NO_CONT
									where I.STATUS = 'DONE' " . $addsql;

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
				$objDrawing->setHeight(40);
				$objDrawing->setWidth(100);
				$objDrawing->setWorksheet($this->newphpexcel->getActiveSheet());
				$this->newphpexcel->setActiveSheetIndex(0);
				$styleArray = array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
				$this->newphpexcel->getDefaultStyle()->applyFromArray($styleArray);
				$this->newphpexcel->set_bold(array('C1'));
				$this->newphpexcel->getActiveSheet()->getStyle("C1:I3")->getFont()->setSize(11);
				$this->newphpexcel->mergecell(array(array('C1', 'I1'), array('C2', 'I2'), array('C3', 'I3'), array('X1', 'X3'), array('Y1', 'Y3'), array('Z1', 'AE1'), array('Z2', 'AA2'), array('AB2', 'AC2'), array('AD2', 'AE2'), array('AF1', 'AF3'), array('AG1', 'AG3'), array('X7', 'Y7')), FALSE);
				$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('C1', 'REPORT PEMERIKSAAN');
				$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('C2', 'COMMON GATE IPC TPK');
				$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('C3', $tgl_awal . ' - ' . $tgl_akhir);
				$this->newphpexcel->width(array(array('A', 5), array('B', 20), array('C', 20), array('D', 10), array('E', 20), array('F', 20), array('G', 20), array('H', 15), array('I', 15), array('J', 20), array('K', 15), array('L', 15), array('M', 25), array('N', 25), array('O', 25), array('P', 30), array('Q', 45), array('R', 40), array('S', 20), array('T', 40), array('U', 30), array('V', 40)));

				$this->newphpexcel->setActiveSheetIndex(0)
					->setCellValue('A6', 'NO')
					->setCellValue('B6', 'NO SPK')
					->setCellValue('C6', 'NO KONTAINER')
					->setCellValue('D6', 'CLS')
					->setCellValue('E6', 'VESSEL')
					->setCellValue('F6', 'VOY')
					->setCellValue('G6', 'STATUS')
					->setCellValue('H6', 'SIZE')
					->setCellValue('I6', 'ISO CODE')
					->setCellValue('J6', 'TYPE')
					->setCellValue('K6', 'IMO CODE')
					->setCellValue('L6', 'JENIS DOKUMEN')
					->setCellValue('M6', 'NO DOKUMEN')
					->setCellValue('N6', 'DOKUMEN DATE')
					->setCellValue('O6', 'TERBIT GATEPASS BEHANDLE')
					->setCellValue('P6', 'MARSHALLING BEHANDLE')
					->setCellValue('Q6', 'LOKASI')
					->setCellValue('R6', 'START PERIKSA')
					->setCellValue('S6', 'SELESAI PERIKSA')
					->setCellValue('T6', 'NEW SEAL NUMBER')
					->setCellValue('U6', 'JENIS BEHANDLE')
					->setCellValue('V6', 'NAMA CUSTOMERS')
					->setCellValue('X1', 'No')
					->setCellValue('Y1', 'Dokumen')
					->setCellValue('Z1', 'UKURAN')
					->setCellValue('X7', 'GATEPASS TERBIT')
					->setCellValue('Z2', '20')
					->setCellValue('AB2', '40')
					->setCellValue('AD2', '45')
					->setCellValue('AF1', 'TOTAL')
					->setCellValue('AG1', 'TEUS')
					->setCellValue('Z3', 'FL')
					->setCellValue('AA3', 'MT')
					->setCellValue('AB3', 'FL')
					->setCellValue('AC3', 'MT')
					->setCellValue('AD3', 'FL')
					->setCellValue('AE3', 'MT');

				$this->newphpexcel->headings(array('A6', 'B6', 'C6', 'D6', 'E6', 'F6', 'G6', 'H6', 'I6', 'J6', 'K6', 'L6', 'M6', 'N6', 'O6', 'P6', 'Q6', 'R6', 'S6', 'T6', 'U6', 'V6', 'X1', 'X2', 'X3', 'Y1', 'Y2', 'Y3', 'Z1', 'X7', 'Z2', 'AA2', 'AB2', 'AC2', 'AD2', 'AE2', 'AF1', 'AF2', 'AF3', 'AG1', 'AG2', 'AG3', 'Z3', 'AA3', 'AB3', 'AC3', 'AD3', 'AE3', 'Z7', 'AA7', 'AB7', 'AC7', 'AD7', 'AE7', 'AF7', 'AG7'));
				$this->newphpexcel->set_wrap(array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V'));
				$no = 1;
				$rec = 7;
				if ($result) {
					foreach ($SQL->result_array() as $row) {
						$this->newphpexcel->setActiveSheetIndex(0)
							->setCellValue('A' . $rec, $no)
							->setCellValue('B' . $rec, $row["NO_SPK"])
							->setCellValue('C' . $rec, $row["KONTAINER"])
							->setCellValue('D' . $rec, $row["CLASS"])
							->setCellValue('E' . $rec, $row["VOYAGE"])
							->setCellValue('F' . $rec, $row["NO_VOYAGE"])
							->setCellValue('G' . $rec, $row["STATUS_KONTAINER"])
							->setCellValue('H' . $rec, $row["SIZE"])
							->setCellValue('I' . $rec, $row["ISO_CODE"])
							->setCellValue('J' . $rec, $row["TIPE_KONTAINER"])
							->setCellValue('K' . $rec, $row["IMO"])
							->setCellValue('L' . $rec, $row["JENIS_DOKUMEN"])
							->setCellValue('M' . $rec, $row["NO_DOKUMEN"])
							->setCellValue('N' . $rec, $row["TGL_DOKUMEN"])
							->setCellValue('O' . $rec, $row["TERBIT_GATEPASS"])
							->setCellValue('P' . $rec, $row["MARSHALLING_BEHANDLE"])
							->setCellValue('Q' . $rec, $row["LOKASI_MARSHALLING"])
							->setCellValue('R' . $rec, $row["START_PEMERIKSAAN"])
							->setCellValue('S' . $rec, $row["FINISH_PEMERIKSAAN"])
							->setCellValue('T' . $rec, $row["NEW_SEAL_NUMBER"])
							->setCellValue('U' . $rec, $row["JENIS_KEGIATAN"])
							->setCellValue('V' . $rec, $row["CUSTOMERS"]);
						$this->newphpexcel->set_detilstyle(array('A' . $rec, 'B' . $rec, 'C' . $rec, 'D' . $rec, 'E' . $rec, 'F' . $rec, 'G' . $rec, 'H' . $rec, 'I' . $rec, 'J' . $rec, 'K' . $rec, 'L' . $rec, 'M' . $rec, 'N' . $rec, 'O' . $rec, 'P' . $rec, 'Q' . $rec, 'R' . $rec, 'S' . $rec, 'T' . $rec, 'U' . $rec, 'V' . $rec));
						$rec++;
						$no++;
					}

					$rec = 4;
					foreach ($SQL1->result_array() as $row) {
						$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('X' . $rec, '1')
							->setCellValue('Y' . $rec, 'SPPMP')
							->setCellValue('Z' . $rec, $row["SPPMP_20_FL"])
							->setCellValue('AA' . $rec, $row["SPPMP_20_MT"])
							->setCellValue('AB' . $rec, $row["SPPMP_40_FL"])
							->setCellValue('AC' . $rec, $row["SPPMP_40_MT"])
							->setCellValue('AD' . $rec, $row["SPPMP_45_FL"])
							->setCellValue('AE' . $rec, $row["SPPMP_45_MT"])
							->setCellValue('AF' . $rec, $row["TOTAL_SPPMP"])
							->setCellValue('AG' . $rec, $row["SPPMP_TEUS"])
							->setCellValue('AF' . '7', $row["TOTAL"]);
						$this->newphpexcel->set_detilstyle(array('X' . $rec, 'Y' . $rec, 'Z' . $rec, 'AA' . $rec, 'AB' . $rec, 'AC' . $rec, 'AD' . $rec, 'AE' . $rec, 'AF' . $rec, 'AG' . $rec, 'AF' . $rec));
					}

					$rec = 5;
					foreach ($SQL1->result_array() as $row) {
						$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('X' . $rec, '2')
							->setCellValue('Y' . $rec, 'SPJM')
							->setCellValue('Z' . $rec, $row["SPJM_20_FL"])
							->setCellValue('AA' . $rec, $row["SPJM_20_MT"])
							->setCellValue('AB' . $rec, $row["SPJM_40_FL"])
							->setCellValue('AC' . $rec, $row["SPJM_40_MT"])
							->setCellValue('AD' . $rec, $row["SPJM_45_FL"])
							->setCellValue('AE' . $rec, $row["SPJM_45_MT"])
							->setCellValue('AF' . $rec, $row["TOTAL_SPJM"])
							->setCellValue('AG' . $rec, $row["SPJM_TEUS"]);
						$this->newphpexcel->set_detilstyle(array('X' . $rec, 'Y' . $rec, 'Z' . $rec, 'AA' . $rec, 'AB' . $rec, 'AC' . $rec, 'AD' . $rec, 'AE' . $rec, 'AF' . $rec, 'AG' . $rec));
					}

					$rec = 6;
					foreach ($SQL1->result_array() as $row) {
						$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('X' . $rec, '3')
							->setCellValue('Y' . $rec, 'ETC')
							->setCellValue('Z' . $rec, $row["ETC_20_FL"])
							->setCellValue('AA' . $rec, $row["ETC_20_MT"])
							->setCellValue('AB' . $rec, $row["ETC_40_FL"])
							->setCellValue('AC' . $rec, $row["ETC_40_MT"])
							->setCellValue('AD' . $rec, $row["ETC_45_FL"])
							->setCellValue('AE' . $rec, $row["ETC_45_MT"])
							->setCellValue('AF' . $rec, $row["TOTAL_ETC"])
							->setCellValue('AG' . $rec, $row["ETC_TEUS"]);
						$this->newphpexcel->set_detilstyle(array('X' . $rec, 'Y' . $rec, 'Z' . $rec, 'AA' . $rec, 'AB' . $rec, 'AC' . $rec, 'AD' . $rec, 'AE' . $rec, 'AF' . $rec, 'AG' . $rec));
					}
				} else {
					$this->newphpexcel->getActiveSheet()->mergeCells('A10:V10');
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A10', 'DATA TIDAK DITEMUKAN');
					$this->newphpexcel->set_detilstyle(array('A10'));
				}
				ob_clean();

				$file = "PEMERIKSAAN_" . date("Y-m-d") . ".xls";
				header("Content-type: application/x-msdownload");
				header("Content-Disposition: attachment;filename=$file");
				header("Cache-Control: max-age=0");
				header("Pragma: no-cache");
				header("Expires: 0");
				$objWriter = PHPExcel_IOFactory::createWriter($this->newphpexcel, 'Excel5');
				$objWriter->save('php://output');
				exit();
			} else if ($act == "marshallingex") {
				$TanggalMarshallingEx = $this->input->post('form[0]');

				$TglMarshallingExAwal  = !empty($TanggalMarshallingEx[0]) ? $TanggalMarshallingEx[0] : '';
				$TglMarshallingExAkhir = !empty($TanggalMarshallingEx[1]) ? $TanggalMarshallingEx[1] : '';

				$whereTanggal = "";
				$orderBy      = " ORDER BY L.WK_STATUS DESC";

				if ($TglMarshallingExAwal != '' && $TglMarshallingExAkhir != '') {
					$whereTanggal = " AND L.WK_STATUS BETWEEN '$TglMarshallingExAwal' AND '$TglMarshallingExAkhir'";
				} elseif ($TglMarshallingExAwal != '') {
					$whereTanggal = " AND L.WK_STATUS >= '$TglMarshallingExAwal'";
				} elseif ($TglMarshallingExAkhir != '') {
					$whereTanggal = " AND L.WK_STATUS <= '$TglMarshallingExAkhir'";
				}

				$tgl_awal = date("d/m/Y H:i", strtotime($TglMarshallingExAwal));
				$tgl_akhir = date("d/m/Y H:i", strtotime($TglMarshallingExAkhir));


				$SQL = "SELECT
									A.NO_SPK AS NO_SPK,
									B.NO_CONT AS KONTAINER,
									'I' AS CLASS,
									E.NM_ANGKUT AS VOYAGE,
									E.NO_VOY_FLIGHT AS NO_VOYAGE,
									CASE 
											WHEN EE.JNS_CONT = 'F' THEN 'FL'
											ELSE 'MT'
									END AS STATUS_KONTAINER,
									B.UKR_CONT AS SIZE,
									B.ISO_CODE AS ISO_CODE,
									B.KD_CONT_TIPE AS TIPE_KONTAINER,
									D.IMO,
									I.JNS_DOK AS JENIS_DOKUMEN,
									I.NO_DOK AS NO_DOKUMEN,
									I.TGL_DOK AS TGL_DOKUMEN,
									I.WK_REK AS TERBIT_GATEPASS,
									L.WK_STATUS AS MARSHALLING_BEHANDLE,
									L.LOKASI_AKHIR AS LOKASI_MARSHALLING,
									K.START_INSP AS START_PEMERIKSAAN,
									K.FINISH_INSP AS FINISH_PEMERIKSAAN,
									K.NO_SEAL AS NEW_SEAL_NUMBER,
									CONCAT('BEHANDLE ', I.JNS_KEGIATAN) AS JENIS_KEGIATAN,
									A.CONSIGNEE AS CUSTOMERS
							FROM t_spk A
							INNER JOIN t_spk_cont B 
									ON A.ID = B.ID
							INNER JOIN t_request C 
									ON A.NO_DOK = C.NO_DOK 
									AND A.TGL_DOK = C.TGL_DOK
							INNER JOIN t_request_cont D 
									ON C.ID = D.ID 
									AND D.NO_CONT = B.NO_CONT
							LEFT JOIN t_cocostshdr E 
									ON D.VESSEL = E.NM_ANGKUT 
									AND D.VOY_IN = E.NO_VOY_FLIGHT
							LEFT JOIN t_cocostscont EE 
									ON E.ID = EE.ID 
									AND B.NO_CONT = EE.NO_CONT
							LEFT JOIN t_job_slip L 
									ON L.NO_SPK = A.NO_SPK 
									AND L.NO_CONT = B.NO_CONT
									AND L.JENIS IN ('BEHANDLE 1','BEHANDLE 2')
							LEFT JOIN t_gatepass I 
									ON I.ID = L.NO_GATEPASS
							LEFT JOIN t_op_inspection K 
									ON K.NO_DOK = I.NO_DOK 
									AND K.NO_CONT = I.NO_CONT
							WHERE I.STATUS = 'DONE'
							$whereTanggal
							$orderBy
						";

				$SQL1 = "SELECT 
										COUNT(IF(B.UKR_CONT = '20' AND C.NAMA = 'SPPMP' AND D.JNS_CONT = 'F', B.NO_CONT, NULL)) AS 'SPPMP_20_FL', 
										COUNT(IF(B.UKR_CONT = '20' AND C.NAMA = 'SPPMP' AND D.JNS_CONT != 'F', B.NO_CONT, NULL)) AS 'SPPMP_20_MT', 
										COUNT(IF(B.UKR_CONT = '40' AND C.NAMA = 'SPPMP' AND D.JNS_CONT = 'F', B.NO_CONT, NULL)) AS 'SPPMP_40_FL', 
										COUNT(IF(B.UKR_CONT = '40' AND C.NAMA = 'SPPMP' AND D.JNS_CONT != 'F', B.NO_CONT, NULL)) AS 'SPPMP_40_MT', 
										COUNT(IF(B.UKR_CONT = '45' AND C.NAMA = 'SPPMP' AND D.JNS_CONT = 'F', B.NO_CONT, NULL)) AS 'SPPMP_45_FL', 
										COUNT(IF(B.UKR_CONT = '45' AND C.NAMA = 'SPPMP' AND D.JNS_CONT != 'F', B.NO_CONT, NULL)) AS 'SPPMP_45_MT', 
										COUNT(IF(B.UKR_CONT IN ('20','40','45') AND C.NAMA = 'SPPMP', B.NO_CONT, NULL)) AS 'TOTAL_SPPMP', 
										COUNT(IF(B.UKR_CONT = '20' AND C.NAMA = 'SPPMP', B.NO_CONT, NULL)) * 1 + COUNT(IF(B.UKR_CONT = '40' AND C.NAMA = 'SPPMP', B.NO_CONT, NULL)) * 2 + COUNT(IF(B.UKR_CONT = '45' AND C.NAMA = 'SPPMP', B.NO_CONT, NULL)) * 2.25 AS 'SPPMP_TEUS',
										COUNT(IF(B.UKR_CONT = '20' AND C.NAMA = 'SPJM' AND D.JNS_CONT = 'F', B.NO_CONT, NULL)) AS 'SPJM_20_FL', 
										COUNT(IF(B.UKR_CONT = '20' AND C.NAMA = 'SPJM' AND D.JNS_CONT != 'F', B.NO_CONT, NULL)) AS 'SPJM_20_MT', 
										COUNT(IF(B.UKR_CONT = '40' AND C.NAMA = 'SPJM' AND D.JNS_CONT = 'F', B.NO_CONT, NULL)) AS 'SPJM_40_FL', 
										COUNT(IF(B.UKR_CONT = '40' AND C.NAMA = 'SPJM' AND D.JNS_CONT != 'F', B.NO_CONT, NULL)) AS 'SPJM_40_MT', 
										COUNT(IF(B.UKR_CONT = '45' AND C.NAMA = 'SPJM' AND D.JNS_CONT = 'F', B.NO_CONT, NULL)) AS 'SPJM_45_FL', 
										COUNT(IF(B.UKR_CONT = '45' AND C.NAMA = 'SPJM' AND D.JNS_CONT != 'F', B.NO_CONT, NULL)) AS 'SPJM_45_MT', 
										COUNT(IF(B.UKR_CONT IN ('20','40','45') AND C.NAMA = 'SPJM', B.NO_CONT, NULL)) AS 'TOTAL_SPJM', 
										COUNT(IF(B.UKR_CONT = '20' AND C.NAMA = 'SPJM', B.NO_CONT, NULL)) * 1 + COUNT(IF(B.UKR_CONT = '40' AND C.NAMA = 'SPJM', B.NO_CONT, NULL)) * 2 + COUNT(IF(B.UKR_CONT = '45' AND C.NAMA = 'SPJM', B.NO_CONT, NULL)) * 2.25 AS 'SPJM_TEUS',
										COUNT(IF(B.UKR_CONT = '20' AND C.NAMA NOT IN ('SPJM','SPPMP') AND D.JNS_CONT = 'F', B.NO_CONT, NULL)) AS 'ETC_20_FL', 
										COUNT(IF(B.UKR_CONT = '20' AND C.NAMA NOT IN ('SPJM','SPPMP') AND D.JNS_CONT != 'F', B.NO_CONT, NULL)) AS 'ETC_20_MT', 
										COUNT(IF(B.UKR_CONT = '40' AND C.NAMA NOT IN ('SPJM','SPPMP') AND D.JNS_CONT = 'F', B.NO_CONT, NULL)) AS 'ETC_40_FL', 
										COUNT(IF(B.UKR_CONT = '40' AND C.NAMA NOT IN ('SPJM','SPPMP') AND D.JNS_CONT != 'F', B.NO_CONT, NULL)) AS 'ETC_40_MT', 
										COUNT(IF(B.UKR_CONT = '45' AND C.NAMA NOT IN ('SPJM','SPPMP') AND D.JNS_CONT = 'F', B.NO_CONT, NULL)) AS 'ETC_45_FL', 
										COUNT(IF(B.UKR_CONT = '45' AND C.NAMA NOT IN ('SPJM','SPPMP') AND D.JNS_CONT != 'F', B.NO_CONT, NULL)) AS 'ETC_45_MT', 
										COUNT(IF(B.UKR_CONT IN ('20','40','45') AND C.NAMA NOT IN('SPJM','SPPMP'), B.NO_CONT, NULL)) AS 'TOTAL_ETC', 
										COUNT(IF(B.UKR_CONT = '20' AND C.NAMA NOT IN ('SPJM','SPPMP'), B.NO_CONT, NULL)) * 1 + COUNT(IF(B.UKR_CONT = '40' AND C.NAMA NOT IN ('SPJM','SPPMP'), B.NO_CONT, NULL)) * 2 + COUNT(IF(B.UKR_CONT = '45' AND C.NAMA NOT IN ('SPJM','SPPMP'), B.NO_CONT, NULL)) * 2.25 AS 'ETC_TEUS',
										CONCAT(COUNT(B.NO_CONT),' BOX') AS 'TOTAL'
									FROM t_spk A
									INNER JOIN t_spk_cont B ON A.ID = B.ID
									INNER JOIN reff_kode_dok_bc C ON A.JNS_DOK = C.ID
									LEFT JOIN (SELECT ID, NO_CONT, JNS_CONT, ISO_CODE, KD_CONT_TIPE, WK_IN, WK_OUT FROM t_cocostscont GROUP BY NO_CONT ORDER BY ID DESC) D ON B.NO_CONT = D.NO_CONT
									LEFT JOIN t_cocostshdr E ON D.ID = E.ID
									LEFT JOIN (SELECT ID, NO_CONT, IMO FROM t_request_cont GROUP BY NO_CONT ORDER BY ID DESC) F ON B.NO_CONT = F.NO_CONT
									LEFT JOIN t_request G ON F.ID = G.ID AND A.NO_DOK = G.NO_DOK
									INNER JOIN (SELECT ID, NO_CONT, JNS_DOK,NO_DOK, TGL_DOK, RESPON, WK_RESPON, JNS_KEGIATAN, WK_REK FROM t_gatepass WHERE JNS_KEGIATAN IN ('1','2') GROUP BY NO_CONT,JNS_KEGIATAN ORDER BY ID DESC) H ON B.NO_CONT = H.NO_CONT
									INNER JOIN (SELECT NO_SPK, NO_CONT, NO_GATEPASS, LOKASI_AKHIR, WK_STATUS FROM t_job_slip WHERE LOKASI_AKHIR LIKE 'CIC%' GROUP BY NO_CONT ORDER BY ID_JOB_SLIP DESC) I ON A.NO_SPK = I.NO_SPK AND B.NO_CONT = I.NO_CONT
									INNER JOIN (SELECT NO_CONT, NO_SEAL, START_INSP, FINISH_INSP, JNS_DOK, NO_DOK, TGL_DOK, NO_SPK FROM t_op_inspection WHERE START_INSP IS NOT NULL AND FINISH_INSP IS NOT NULL GROUP BY NO_CONT ORDER BY ID DESC) J ON A.NO_SPK = J.NO_SPK AND B.NO_CONT = J.NO_CONT AND H.NO_DOK = J.NO_DOK
									INNER JOIN (SELECT NO_CONT, NO_SPK, NO_GATEPASS, LOKASI_AKHIR, WK_STATUS FROM t_job_slip WHERE LOKASI_AKHIR LIKE 'CIC%' GROUP BY NO_CONT,NO_GATEPASS ORDER BY ID_JOB_SLIP DESC) K ON A.NO_SPK = K.NO_SPK AND B.NO_CONT = K.NO_CONT AND H.ID = K.NO_GATEPASS
									INNER JOIN (SELECT NO_CONT, NO_SPK, NO_GATEPASS, LOKASI_AKHIR, WK_STATUS FROM t_job_slip WHERE LOKASI_AKHIR LIKE '1A%' GROUP BY NO_CONT,NO_GATEPASS ORDER BY ID_JOB_SLIP DESC) L ON A.NO_SPK = L.NO_SPK AND B.NO_CONT = L.NO_CONT AND H.ID = L.NO_GATEPASS
									WHERE 1 = 1" . $addsql;

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
				$objDrawing->setHeight(40);
				$objDrawing->setWidth(100);
				$objDrawing->setWorksheet($this->newphpexcel->getActiveSheet());
				$this->newphpexcel->setActiveSheetIndex(0);
				$styleArray = array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
				$this->newphpexcel->getDefaultStyle()->applyFromArray($styleArray);
				$this->newphpexcel->set_bold(array('C1'));
				$this->newphpexcel->getActiveSheet()->getStyle("C1:I3")->getFont()->setSize(11);
				$this->newphpexcel->mergecell(array(array('C1', 'I1'), array('C2', 'I2'), array('C3', 'I3'), array('Z1', 'Z3'), array('AA1', 'AA3'), array('AB1', 'AG1'), array('AB2', 'AC2'), array('AD2', 'AE2'), array('AF2', 'AG2'), array('AH1', 'AH3'), array('AI1', 'AI3'), array('Z7', 'AA7')), FALSE);
				$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('C1', 'REPORT MARSHALLING EX BEHANDLE');
				$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('C2', 'COMMON GATE IPC TPK');
				$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('C3', $tgl_awal . ' - ' . $tgl_akhir);
				$this->newphpexcel->width(array(array('A', 5), array('B', 20), array('C', 20), array('D', 10), array('E', 20), array('F', 20), array('G', 20), array('H', 15), array('I', 15), array('J', 20), array('K', 15), array('L', 15), array('M', 25), array('N', 20), array('O', 30), array('P', 30), array('Q', 10), array('R', 20), array('S', 20), array('T', 20), array('U', 30), array('V', 20), array('W', 25), array('X', 40)));

				$this->newphpexcel->setActiveSheetIndex(0)
					->setCellValue('A6', 'NO')
					->setCellValue('B6', 'NO SPK')
					->setCellValue('C6', 'NO KONTAINER')
					->setCellValue('D6', 'CLS')
					->setCellValue('E6', 'VESSEL')
					->setCellValue('F6', 'VOY')
					->setCellValue('G6', 'STATUS')
					->setCellValue('H6', 'SIZE')
					->setCellValue('I6', 'ISO CODE')
					->setCellValue('J6', 'TYPE')
					->setCellValue('K6', 'IMO CODE')
					->setCellValue('L6', 'JENIS DOKUMEN')
					->setCellValue('M6', 'NO DOKUMEN')
					->setCellValue('N6', 'DOKUMEN DATE')
					->setCellValue('O6', 'TERBIT GATEPASS BEHANDLE')
					->setCellValue('P6', 'MARSHALLING BEHANDLE')
					->setCellValue('Q6', 'LOKASI')
					->setCellValue('R6', 'START PERIKSA')
					->setCellValue('S6', 'SELESAI PERIKSA')
					->setCellValue('T6', 'NEW SEAL NUMBER')
					->setCellValue('U6', 'MARSHALLING EX BEHANDLE')
					->setCellValue('V6', 'LOKASI')
					->setCellValue('W6', 'JENIS BEHANDLE')
					->setCellValue('X6', 'NAMA CUSTOMERS')
					->setCellValue('Z1', 'No')
					->setCellValue('AA1', 'Dokumen')
					->setCellValue('AB1', 'UKURAN')
					->setCellValue('Z7', 'GATEPASS TERBIT')
					->setCellValue('AB2', '20')
					->setCellValue('AD2', '40')
					->setCellValue('AF2', '45')
					->setCellValue('AH1', 'TOTAL')
					->setCellValue('AI1', 'TEUS')
					->setCellValue('AB3', 'FL')
					->setCellValue('AC3', 'MT')
					->setCellValue('AD3', 'FL')
					->setCellValue('AE3', 'MT')
					->setCellValue('AF3', 'FL')
					->setCellValue('AG3', 'MT');

				$this->newphpexcel->headings(array('A6', 'B6', 'C6', 'D6', 'E6', 'F6', 'G6', 'H6', 'I6', 'J6', 'K6', 'L6', 'M6', 'N6', 'O6', 'P6', 'Q6', 'R6', 'S6', 'T6', 'U6', 'V6', 'W6', 'X6', 'Z1', 'Z2', 'Z3', 'AA1', 'AA2', 'AA3', 'AB1', 'Z7', 'AB2', 'AC2', 'AD2', 'AE2', 'AF2', 'AG2', 'AH1', 'AH2', 'AH3', 'AI1', 'AI2', 'AI3', 'AB3', 'AC3', 'AD3', 'AE3', 'AF3', 'AG3', 'AB7', 'AC7', 'AD7', 'AE7', 'AF7', 'AG7', 'AH7', 'AI7'));
				$this->newphpexcel->set_wrap(array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X'));
				$no = 1;
				$rec = 7;
				if ($result) {
					foreach ($SQL->result_array() as $row) {
						$this->newphpexcel->setActiveSheetIndex(0)
							->setCellValue('A' . $rec, $no)
							->setCellValue('B' . $rec, $row["NO_SPK"])
							->setCellValue('C' . $rec, $row["KONTAINER"])
							->setCellValue('D' . $rec, $row["CLASS"])
							->setCellValue('E' . $rec, $row["VOYAGE"])
							->setCellValue('F' . $rec, $row["NO_VOYAGE"])
							->setCellValue('G' . $rec, $row["STATUS_KONTAINER"])
							->setCellValue('H' . $rec, $row["SIZE"])
							->setCellValue('I' . $rec, $row["ISO_CODE"])
							->setCellValue('J' . $rec, $row["TIPE_KONTAINER"])
							->setCellValue('K' . $rec, $row["IMO"])
							->setCellValue('L' . $rec, $row["JENIS_DOKUMEN"])
							->setCellValue('M' . $rec, $row["NO_DOKUMEN"])
							->setCellValue('N' . $rec, $row["TGL_DOKUMEN"])
							->setCellValue('O' . $rec, $row["TERBIT_GATEPASS"])
							->setCellValue('P' . $rec, $row["MARSHALLING_BEHANDLE"])
							->setCellValue('Q' . $rec, $row["LOKASI_MARSHALLING"])
							->setCellValue('R' . $rec, $row["START_PEMERIKSAAN"])
							->setCellValue('S' . $rec, $row["FINISH_PEMERIKSAAN"])
							->setCellValue('T' . $rec, $row["NEW_SEAL_NUMBER"])
							->setCellValue('U' . $rec, $row["MARSHALLING_EX_BEHANDLE"])
							->setCellValue('V' . $rec, $row["LOKASI_MARSHALLING_EX_BEHANDLE"])
							->setCellValue('W' . $rec, $row["JENIS_KEGIATAN"])
							->setCellValue('X' . $rec, $row["CUSTOMERS"]);
						$this->newphpexcel->set_detilstyle(array('A' . $rec, 'B' . $rec, 'C' . $rec, 'D' . $rec, 'E' . $rec, 'F' . $rec, 'G' . $rec, 'H' . $rec, 'I' . $rec, 'J' . $rec, 'K' . $rec, 'L' . $rec, 'M' . $rec, 'N' . $rec, 'O' . $rec, 'P' . $rec, 'Q' . $rec, 'R' . $rec, 'S' . $rec, 'T' . $rec, 'U' . $rec, 'V' . $rec, 'W' . $rec, 'X' . $rec));
						$rec++;
						$no++;
					}

					$rec = 4;
					foreach ($SQL1->result_array() as $row) {
						$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('Z' . $rec, '1')
							->setCellValue('AA' . $rec, 'SPPMP')
							->setCellValue('AB' . $rec, $row["SPPMP_20_FL"])
							->setCellValue('AC' . $rec, $row["SPPMP_20_MT"])
							->setCellValue('AD' . $rec, $row["SPPMP_40_FL"])
							->setCellValue('AE' . $rec, $row["SPPMP_40_MT"])
							->setCellValue('AF' . $rec, $row["SPPMP_45_FL"])
							->setCellValue('AG' . $rec, $row["SPPMP_45_MT"])
							->setCellValue('AH' . $rec, $row["TOTAL_SPPMP"])
							->setCellValue('AI' . $rec, $row["SPPMP_TEUS"])
							->setCellValue('AH' . '7', $row["TOTAL"]);
						$this->newphpexcel->set_detilstyle(array('Z' . $rec, 'AA' . $rec, 'AB' . $rec, 'AC' . $rec, 'AD' . $rec, 'AE' . $rec, 'AF' . $rec, 'AG' . $rec, 'AH' . $rec, 'AI' . $rec, 'AH' . $rec));
					}

					$rec = 5;
					foreach ($SQL1->result_array() as $row) {
						$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('Z' . $rec, '2')
							->setCellValue('AA' . $rec, 'SPJM')
							->setCellValue('AB' . $rec, $row["SPJM_20_FL"])
							->setCellValue('AC' . $rec, $row["SPJM_20_MT"])
							->setCellValue('AD' . $rec, $row["SPJM_40_FL"])
							->setCellValue('AE' . $rec, $row["SPJM_40_MT"])
							->setCellValue('AF' . $rec, $row["SPJM_45_FL"])
							->setCellValue('AG' . $rec, $row["SPJM_45_MT"])
							->setCellValue('AH' . $rec, $row["TOTAL_SPJM"])
							->setCellValue('AI' . $rec, $row["SPJM_TEUS"]);
						$this->newphpexcel->set_detilstyle(array('Z' . $rec, 'AA' . $rec, 'AB' . $rec, 'AC' . $rec, 'AD' . $rec, 'AE' . $rec, 'AF' . $rec, 'AG' . $rec, 'AH' . $rec, 'AI' . $rec));
					}

					$rec = 6;
					foreach ($SQL1->result_array() as $row) {
						$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('Z' . $rec, '3')
							->setCellValue('AA' . $rec, 'ETC')
							->setCellValue('AB' . $rec, $row["ETC_20_FL"])
							->setCellValue('AC' . $rec, $row["ETC_20_MT"])
							->setCellValue('AD' . $rec, $row["ETC_40_FL"])
							->setCellValue('AE' . $rec, $row["ETC_40_MT"])
							->setCellValue('AF' . $rec, $row["ETC_45_FL"])
							->setCellValue('AG' . $rec, $row["ETC_45_MT"])
							->setCellValue('AH' . $rec, $row["TOTAL_ETC"])
							->setCellValue('AI' . $rec, $row["ETC_TEUS"]);
						$this->newphpexcel->set_detilstyle(array('Z' . $rec, 'AA' . $rec, 'AB' . $rec, 'AC' . $rec, 'AD' . $rec, 'AE' . $rec, 'AF' . $rec, 'AG' . $rec, 'AH' . $rec, 'AI' . $rec));
					}
				} else {
					$this->newphpexcel->getActiveSheet()->mergeCells('A10:X10');
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A10', 'DATA TIDAK DITEMUKAN');
					$this->newphpexcel->set_detilstyle(array('A10'));
				}
				ob_clean();

				$file = "MARSHALLING_EX_BEHANDLE_" . date("Y-m-d") . ".xls";
				header("Content-type: application/x-msdownload");
				header("Content-Disposition: attachment;filename=$file");
				header("Cache-Control: max-age=0");
				header("Pragma: no-cache");
				header("Expires: 0");
				$objWriter = PHPExcel_IOFactory::createWriter($this->newphpexcel, 'Excel5');
				$objWriter->save('php://output');
				exit();
			} else {
				$qw = $this->db->query("SELECT * FROM (SELECT a.NO_DOK,a.NO_CONT,c.KD_CONT_TIPE,C.UK_CONT,c.JNS_CONT,a.NM_KAPAL,a.NO_VOY,d.LOKASI,a.WK_REK,a.EXPIRED_DATE,b.PLUG_START_DATE,b.PLUG_END_DATE,a.NAMA_CUST
					FROM t_gatepass a
					LEFT JOIN (
					SELECT no_cont,PLUG_START_DATE,PLUG_END_DATE
					FROM req_delivery_dtl a
					WHERE a.PLUG_END_DATE IS NOT NULL
					GROUP BY no_cont) b ON a.NO_CONT = b.no_cont
					JOIN t_cocostscont c ON a.NO_CONT = c.NO_CONT
					JOIN t_spk_cont d ON a.NO_CONT = d.NO_CONT
					WHERE DATE(a.EXPIRED_DATE) >= DATE(NOW())
					GROUP BY no_cont) az WHERE 1=1");



				$this->load->library('newphpexcel');
				$this->newphpexcel->getDefaultStyle()->getFont()->setName('Calibri')->setSize(10);
				$objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
				$objDrawing->setName('Logo');
				$objDrawing->setDescription('Logo');
				$logo = imagecreatefrompng('assets/images/ipc_logo.png');
				$objDrawing->setImageResource($logo);
				$objDrawing->setCoordinates('A1');
				$objDrawing->setHeight(40);
				$objDrawing->setWidth(100);
				$objDrawing->setWorksheet($this->newphpexcel->getActiveSheet());
				$this->newphpexcel->setActiveSheetIndex(0);
				$styleArray = array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
				$style1 = array(
					'alignment' => array(
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					)
				);
				//$this->newphpexcel->getDefaultStyle()->applyFromArray($styleArray);
				$this->newphpexcel->set_bold(array('C1'));
				$this->newphpexcel->getActiveSheet()->getStyle("C1:I3")->getFont()->setSize(11);
				$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('C1', 'REPORT Monitoring delivery');
				$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('C2', 'COMMON GATE IPC TPK');
				$this->newphpexcel->width(array(array('A', 5), array('B', 20), array('C', 20), array('D', 20), array('E', 20), array('F', 20), array('G', 20), array('H', 20), array('I', 15), array('J', 20), array('K', 20), array('L', 20), array('M', 20), array('N', 50)));
				$this->newphpexcel->mergecell(array(array('C1', 'N1'), array('C2', 'N2'), array('C3', 'N3')));
				$this->newphpexcel->setActiveSheetIndex(0)
					->setCellValue('A6', 'NO')
					->setCellValue('B6', 'NO DOCUMENT')
					->setCellValue('C6', 'NO KONTAINER')
					->setCellValue('D6', 'TYPE')
					->setCellValue('E6', 'UKURAN')
					->setCellValue('F6', 'JENIS')
					->setCellValue('G6', 'NAMA KAPAL')
					->setCellValue('H6', 'NO VOY')
					->setCellValue('I6', 'LOKASI')
					->setCellValue('J6', 'WAKTU REKAM')
					->setCellValue('K6', 'EXPIRED DATE')
					->setCellValue('L6', 'PLUG DATE NPCT1')
					->setCellValue('M6', 'UNPLUG DATE CA')
					->setCellValue('N6', 'CUSTOMER');
				$num = 7;
				foreach ($qw->result() as $key => $val) {
					$ro = $num + $key;
					$this->newphpexcel->setActiveSheetIndex(0)
						->setCellValue('A' . $ro, $key + 1)
						->setCellValue('B' . $ro, $val->NO_DOK)
						->setCellValue('C' . $ro, $val->NO_CONT)
						->setCellValue('D' . $ro, $val->KD_CONT_TIPE)
						->setCellValue('E' . $ro, $val->UK_CONT)
						->setCellValue('F' . $ro, $val->JNS_CONT)
						->setCellValue('G' . $ro, $val->NM_KAPAL)
						->setCellValue('H' . $ro, $val->NO_VOY)
						->setCellValue('I' . $ro, $val->LOKASI)
						->setCellValue('J' . $ro, $val->WK_REK)
						->setCellValue('K' . $ro, $val->EXPIRED_DATE)
						->setCellValue('L' . $ro, $val->PLUG_START_DATE)
						->setCellValue('M' . $ro, $val->PLUG_END_DATE)
						->setCellValue('N' . $ro, $val->NAMA_CUST);
				}
				//$this->newphpexcel->getStyle("D7:M175")->applyFromArray($style1);
				$this->newphpexcel->headings(array('A6', 'B6', 'C6', 'D6', 'E6', 'F6', 'G6', 'H6', 'I6', 'J6', 'K6', 'L6', 'M6', 'N6'));
				$this->newphpexcel->set_wrap(array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N'));


				ob_clean();

				$file = "MONITORING_DELIVERY_" . date("Y-m-d") . ".xls";
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
