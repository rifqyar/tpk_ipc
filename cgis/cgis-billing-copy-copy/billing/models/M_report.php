<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class M_report extends CI_Model {

	public function __construct(){
		parent::__construct();
	} 
	
	
	function terbit_spk(){
		$page_title = "REPORT TERBIT SPK";
		$title = "REPORT TERBIT SPK ";
		$this->newtable->breadcrumb('Dashboard', site_url(),'icon-home');
		$this->newtable->breadcrumb('Report', 'javascript:void(0)','');
		$this->newtable->breadcrumb('PENARIKAN', 'javascript:void(0)','');
		$check = (grant()=="W")?true:false;
		$SQL = "SELECT B.NO_SPK AS 'NO SPK', A.NO_CONT AS 'NO CONTAINER',A.UKR_CONT AS 'SIZE',B.WK_REQ AS 'TERBIT SPK',C.NAMA AS 'JENIS DOKUMEN', A.ID_FLAT AS 'TID', D.W_PICKUP AS 'WAKTU PICK UP',B.CONSIGNEE AS 'CUSTOMER NAME'
				FROM t_spk_cont A
				INNER JOIN t_spk B ON A.id = B.id
				INNER JOIN reff_kode_dok_bc C ON C.ID = B.JNS_DOK
				LEFT JOIN t_op_pickup D ON B.NO_SPK = D.NO_SPK
				WHERE 1=1";
		$this->newtable->multiple_search(true);
		$this->newtable->show_chk(false);
		$this->newtable->show_menu($check);
		$this->newtable->show_search(true);
		$proses = array('EXPORT EXCEL TERBIT SPK' => array('EXCEL',"process1/excel/penarikan/".$act, '0','','md-file-text','','menu'));
		//$arr_sts = array(""=>"",""=>"ON TERMINAL","450"=>"ON COMMON AREA");
		$this->newtable->search(array(array('B.NO_SPK','NO. SPK'),array('B.WK_REQ','TANGGAL SPK','DATETIMERANGE')));
		$this->newtable->action(site_url() . "/report/terbit_spk");
		//if($check) $this->newtable->detail(array('POPUP',"/monitoring/jobslip/detail"));
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array(""));
		$this->newtable->keys(array(""));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby("B.WK_REQ ASC");
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

	function pemeriksaan(){
		$page_title = "REPORT PEMERIKSAAN";
		$title = "REPORT PEMERIKSAAN";
		$this->newtable->breadcrumb('Dashboard', site_url(),'icon-home');
		$this->newtable->breadcrumb('Report', 'javascript:void(0)','');
		$this->newtable->breadcrumb('PEMERIKSAAN', 'javascript:void(0)','');
		$check = (grant()=="W")?true:false;
		if($this->session->userdata('KD_GROUP')=="BC"){
		$addsql = " AND C.FL_ACTIVE = 'Y' AND G.ID != 83 AND F.START_INSP IS NOT NULL AND F.FINISH_INSP IS NOT NULL";
		$SQL = "SELECT B.NO_SPK AS 'NO SPK', A.STATUS_CONT AS 'STATUS_CONT',CONCAT(A.NO_CONT,'<BR>',A.UKR_CONT) AS 'KONTAINER',
				CONCAT(C.NO_DOK,'<br>',G.NAMA) AS 'DOKUMEN',B.TGL_DOK AS 'TGL ANTRIAN',C.WK_RESPON AS 'TGL PKB',
				CASE WHEN C.RESPON = 'PKB PRIORITAS' THEN '<span style=\"color:green;font-weight:bold\">PKB PRIORITAS</span>' WHEN C.RESPON = 'PKB LR' THEN '<span style=\"color:green;font-weight:bold\">PKB LONGROOM</span>' WHEN C.RESPON = 'PKB YARD' THEN '<span style=\"color:green;font-weight:bold\">PKB YARD</span>' WHEN C.RESPON = 'PKB YARD N' THEN '<span style=\"color:green;font-weight:bold\">PKB YARD N</span>' ELSE '<span style=\"color:red;font-weight:bold\">NO RESPON</span>' END AS 'RESPON',
				C.WK_ACTIVE AS 'TGL SIAP PERIKSA',F.START_INSP AS 'TGL START PERIKSA',F.FINISH_INSP AS 'TGL SELESAI PERIKSA',
				F.NO_SEAL AS 'NO SEAL',B.CONSIGNEE AS 'CUSTOMERS'
				FROM t_spk_cont A
				LEFT JOIN t_spk B ON A.ID = B.ID
				LEFT JOIN t_gatepass C ON A.NO_CONT = C.NO_CONT 
				INNER JOIN t_request D ON C.NO_DOK = D.NO_DOK
				LEFT JOIN reff_status_spk E ON A.STATUS_CONT = E.ID
				LEFT JOIN t_op_inspection F ON F.NO_CONT = A.NO_CONT 
				LEFT JOIN reff_kode_dok_bc G ON D.JNS_DOK = G.ID
				WHERE 1=1".$addsql."";
		}else{
			$addsql = " AND C.FL_ACTIVE = 'Y' AND F.START_INSP IS NOT NULL AND F.FINISH_INSP IS NOT NULL";
			$SQL = "SELECT B.NO_SPK AS 'NO SPK', A.STATUS_CONT AS 'STATUS_CONT',CONCAT(A.NO_CONT,'<BR>',A.UKR_CONT) AS 'KONTAINER',
				CONCAT(C.NO_DOK,'<br>',G.NAMA) AS 'DOKUMEN',B.TGL_DOK AS 'TGL ANTRIAN',C.WK_RESPON AS 'TGL PKB',
				CASE WHEN C.RESPON = 'PKB PRIORITAS' THEN '<span style=\"color:green;font-weight:bold\">PKB PRIORITAS</span>' WHEN C.RESPON = 'PKB LR' THEN '<span style=\"color:green;font-weight:bold\">PKB LONGROOM</span>' WHEN C.RESPON = 'PKB YARD' THEN '<span style=\"color:green;font-weight:bold\">PKB YARD</span>' WHEN C.RESPON = 'PKB YARD N' THEN '<span style=\"color:green;font-weight:bold\">PKB YARD N</span>' ELSE '<span style=\"color:red;font-weight:bold\">NO RESPON</span>' END AS 'RESPON',
				C.WK_ACTIVE AS 'TGL SIAP PERIKSA',F.START_INSP AS 'TGL START PERIKSA',F.FINISH_INSP AS 'TGL SELESAI PERIKSA',
				F.NO_SEAL AS 'NO SEAL',B.CONSIGNEE AS 'CUSTOMERS'
				FROM t_spk_cont A
				LEFT JOIN t_spk B ON A.ID = B.ID
				LEFT JOIN t_gatepass C ON A.NO_CONT = C.NO_CONT 
				INNER JOIN t_request D ON C.NO_DOK = D.NO_DOK
				LEFT JOIN reff_status_spk E ON A.STATUS_CONT = E.ID
				LEFT JOIN t_op_inspection F ON F.NO_CONT = A.NO_CONT 
				LEFT JOIN reff_kode_dok_bc G ON D.JNS_DOK = G.ID
				WHERE 1=1".$addsql."";
		}
		$this->newtable->multiple_search(true);
		$this->newtable->show_chk(false);
		$this->newtable->show_menu($check);
		$this->newtable->show_search(true);
		$proses = array('EXPORT PEMERIKSAAN' => array('EXCEL',"process/excel/pemeriksaan/".$act, '0','','md-file-text','','menu'));
		$this->newtable->search(array(array('A.NO_CONT','NO CONTAINER'),array('F.START_INSP','TANGGAL START PERIKSA','DATETIMERANGE')));
		$this->newtable->action(site_url() . "/report/pemeriksaan");
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("STATUS_CONT"));
		$this->newtable->keys(array(""));
		$this->newtable->cidb($this->db);
		$this->newtable->groupby("A.NO_CONT");
		$this->newtable->orderby("C.WK_ACTIVE DESC","C.RESPON ASC");
		$this->newtable->sortby("");
		$this->newtable->set_formid("tblmonitoringpemeriksaan");
		$this->newtable->set_divid("divmonitoringpemeriksaan");
		$this->newtable->rowcount(100);
		$this->newtable->clear();
		$this->newtable->menu($proses);
		$tabel .= $this->newtable->generate($SQL);
		$arrdata = array("page_title" => $page_title, "title" => $title, "content" => $tabel);
		if($this->input->post("ajax")||$act == "post")
			return $tabel;
		else
			return $arrdata;
	}
	
	function stacking(){
		$page_title = "STACKING";
		$title = "STACKING";
		$this->newtable->breadcrumb('Dashboard', site_url(),'icon-home');
		$this->newtable->breadcrumb('Report', 'javascript:void(0)','');
		$this->newtable->breadcrumb('STACKING', 'javascript:void(0)','');
		$check = (grant()=="W")?true:false;
		$SQL = "SELECT B.NO_SPK AS 'NO SPK', A.NO_CONT AS 'NO KONTAINER',A.UKR_CONT AS 'SIZE',B.WK_REQ AS 'TERBIT SPK',C.NAMA AS 'JENIS DOKUMEN', 
				A.ID_FLAT AS 'TID',B.CONSIGNEE AS 'NAMA CUSTOMER', CONCAT((A.LOKASI),'0',(A.TIER)) AS 'LOKASI', 
				CASE WHEN A.STATUS_CONT = '450' THEN '<span style=\"blue:yellow;font-weight:bold\">STACKING YARD</span>' WHEN A.STATUS_CONT = '460' THEN '<span style=\"color:green;font-weight:bold\">STACKING CIC</span>' ELSE '<span style=\"color:red;font-weight:bold\">DELIVERY</span>' END AS 'STATUS'
				FROM t_spk_cont A
				INNER JOIN t_spk B ON A.id = B.id
				INNER JOIN reff_kode_dok_bc C ON C.ID = B.JNS_DOK
				WHERE A.STATUS_CONT IN ('450','460')";
		$this->newtable->multiple_search(true);
		$this->newtable->show_chk(false);
		$this->newtable->show_menu($check);
		$this->newtable->show_search(true);
		$proses = array('EXPORT EXCEL TERBIT SPK' => array('EXCEL',"process/excel/stacking/".$act, '0','','md-file-text','','menu'));
		$arr_sts = array(""=>"","450"=>"STACKING YARD","460"=>"STACKING CIC");
		$this->newtable->search(array(array('A.STATUS_CONT','STATUS KONTAINER','OPTION',$arr_sts)));
		$this->newtable->action(site_url() . "/report/stacking");
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array(""));
		$this->newtable->keys(array(""));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby("B.WK_REQ ASC");
		$this->newtable->sortby("");
		$this->newtable->set_formid("tblstacking");
		$this->newtable->set_divid("divstacking");
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
	
	function penarikan(){
		$page_title = "REPORT PENARIKAN BEHANDLEIN";
		$title = "REPORT PENARIKAN BEHANDLEIN";
		$this->newtable->breadcrumb('Dashboard', site_url(),'icon-home');
		$this->newtable->breadcrumb('Monitoring', 'javascript:void(0)','');
		$this->newtable->breadcrumb('PENARIKAN', 'javascript:void(0)','');
		$check = (grant()=="W")?true:false;
		$SQL = "SELECT B.NO_SPK AS 'NO SPK', A.NO_CONT AS 'NO CONTAINER',A.UKR_CONT AS 'SIZE',B.WK_REQ AS 'TERBIT SPK',C.NAMA AS 'JENIS DOKUMEN', D.W_PICKUP AS 'WAKTU PICKUP', A.ID_FLAT AS 'TID', F.W_BEHANDLE AS 'WAKTU BEHANDLE IN',
			CASE WHEN A.STATUS_CONT IN('450','460','500','510','520','530','540') 
			THEN CONCAT('<span class=\"label label-success\">',
			 DATEDIFF(DATE_FORMAT(F.W_BEHANDLE,'%Y-%m-%d'), DATE_FORMAT(D.W_PICKUP,'%Y-%m-%d')),' HARI</span>/','<br><span class=\"label label-success\">',TIMEDIFF(TIMESTAMP(F.W_BEHANDLE,'%Y-%m-%d, %hh:%mm:%ss'), TIMESTAMP(D.W_PICKUP,'%Y-%m-%d, %hh:%mm:%ss')),' JAM</span>') 
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
		$proses = array('EXPORT EXCEL PENARIKAN - BEHANDLE IN' => array('EXCEL',"process1/excel/penarikan1/".$act, '0','','md-file-text','','menu'));
		$arr_sts = array(""=>"",""=>"ON TERMINAL","450"=>"ON COMMON AREA");
		$this->newtable->search(array(array('A.STATUS_CONT','STATUS PENARIKAN','OPTION',$arr_sts),array('F.W_BEHANDLE','TANGGAL BEHANDLE IN','DATETIMERANGE')));
		$this->newtable->action(site_url() . "/report/penarikan");
		//if($check) $this->newtable->detail(array('POPUP',"/monitoring/jobslip/detail"));
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("WAKTU PICK UP"));
		$this->newtable->keys(array(""));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby("F.W_BEHANDLE ASC");
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
//
	public function behandle($act, $id){
		$func = get_instance();
        $func->load->model("m_main", "main", true);
		$title = "REPORT BEHANDLE ".strtoupper($act);
		$KD_TPS = $this->session->userdata('KD_TPS');
		$KD_GUDANG = $this->session->userdata('KD_GUDANG');
		$KD_GROUP = $this->session->userdata('KD_GROUP');
		$this->newtable->breadcrumb('Dashboard', site_url(),'icon-home');
		$this->newtable->breadcrumb('Report', 'javascript:void(0)','');
		$this->newtable->breadcrumb('Behandle', 'javascript:void(0)','');
		$this->newtable->breadcrumb(strtoupper($act), 'javascript:void(0)','');
		$check = (grant()=="W")?true:false;
		$addsql = "";
			$SQL = "SELECT A.ID AS 'ID',CONCAT('',(B.NO_CONT),'<BR>',(B.UKR_CONT)) AS 'KONTAINER', CASE WHEN LEFT(B.LOKASI,3) = 'CIC' THEN 
				B.LOKASI ELSE CONCAT(B.LOKASI,'0', TIER) END AS 'LOKASI', 
				CONCAT('',(A.NO_SPK),'<BR>',(A.TGL_SPK)) AS 'SPK',
				D.W_BEHANDLE AS 'TANGGAL BEHANDLE',
				CONCAT('',(A.NM_KAPAL),'<BR>',(A.NO_VOY)) AS 'KAPAL', A.CONSIGNEE, C.KETERANGAN AS 'STATUS'
				FROM t_spk A, t_spk_cont B 
				INNER JOIN reff_status_spk C ON C.ID = B.STATUS_CONT
				LEFT JOIN t_op_behandlein D ON D.NO_CONT = B.NO_CONT
				WHERE A.ID = B.ID".$addsql;
		$this->newtable->multiple_search(true);
		$this->newtable->show_chk(false);
		$this->newtable->show_menu($check);
		$this->newtable->show_search(true);
		$proses = array('EXPORT EXCEL 1' => array('EXCEL', "process/excel/behandle/".$act, '0','','md-file-text','','menu'));
		$this->newtable->search(array(array('B.NO_CONT','NO. CONTAINER'),array('D.W_BEHANDLE','TANGGAL BEHANDLE IN','DATETIMERANGE'), array('A.TGL_SPK','TANGGAL SPK','DATETIMERANGE')));
		$this->newtable->action(site_url() . "/report/behandle/".$act);
		//if($check) $this->newtable->detail(array('POPUP',"dokumen/bc11/detail"));
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array('ID'));
		$this->newtable->keys(array("B.NO_CONT"));
		$this->newtable->validasi(array());
		$this->newtable->cidb($this->db);
		$this->newtable->orderby(3);
		$this->newtable->groupby(array("B.NO_CONT"));
		$this->newtable->sortby("ASC");
		$this->newtable->set_formid("tblreport");
		$this->newtable->set_divid("divtblreport");
		$this->newtable->rowcount(50);
		$this->newtable->clear();
		$this->newtable->menu($proses);
		$tabel .= $this->newtable->generate($SQL);
		$arrdata = array("page_title" => $page_title, "title" => $title, "content" => $tabel);
		if($this->input->post("ajax")||$act == "post")
			return $tabel;
		else
			return $arrdata;
	}

	public function bilbehandle($act, $id){
		$func = get_instance();
        $func->load->model("m_main", "main", true);
		$title = "REPORT BILLING BEHANDLE ".strtoupper($act);
		$KD_TPS = $this->session->userdata('KD_TPS');
		$KD_GUDANG = $this->session->userdata('KD_GUDANG');
		$KD_GROUP = $this->session->userdata('KD_GROUP');
		$this->newtable->breadcrumb('Dashboard', site_url(),'icon-home');
		$this->newtable->breadcrumb('Report', 'javascript:void(0)','');
		$this->newtable->breadcrumb('Billing Behandle', 'javascript:void(0)','');
		$this->newtable->breadcrumb(strtoupper($act), 'javascript:void(0)','');
		$check = (grant()=="W")?true:false;
		$addsql = "";
		$SQL = "SELECT A.ID_REQ AS 'ID REQUEST',A.TGL_REQ AS 'TANGGAL REQUEST', A.NO_NOTA_BEHANDLE AS 'NO. NOTA BEHANDLE', A.TGL_NOTA AS 'TANGGAL NOTA', A.TOTAL_JUMLAH AS 'TOTAL', A.NAMA_CUST AS 'NAMA CUSTOMER', A.NPWP 
				FROM req_behandle_hdr A
				WHERE 1=1".$addsql;
		$this->newtable->multiple_search(true);
		$this->newtable->show_chk(false);
		$this->newtable->show_menu($check);
		$this->newtable->show_search(true);
		$proses = array('PRANOTA' => array('EXCEL', "process/excel/bilbehandle2/".$act, '0','','md-file','', 'menu'),
						'NOTA' => array('EXCEL', "process/excel/bilbehandle/".$act, '0','','md-file-text','','menu'));
		$this->newtable->search(array(array('A.NAMA_CUST','NAMA CUSTOMER'),array('A.TGL_NOTA','TGL. NOTA','DATERANGE'),array('A.TGL_REQ','TGL. REQUEST','DATERANGE')));
		$this->newtable->action(site_url() . "/report/bilbehandle/".$act);
		//if($check) $this->newtable->detail(array('POPUP',"dokumen/bc11/detail"));
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array());
		$this->newtable->keys(array("ID_REQ"));
		$this->newtable->validasi(array());
		$this->newtable->cidb($this->db);
		$this->newtable->orderby("4");
		$this->newtable->sortby("DESC");
		$this->newtable->set_formid("tblreport");
		$this->newtable->set_divid("divtblreport");
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

	public function pergerakan($act, $id){
		$func = get_instance();
        $func->load->model("m_main", "main", true);
		$title = "REPORT PERGERAKAN ".strtoupper($act);
		$KD_TPS = $this->session->userdata('KD_TPS');
		$KD_GUDANG = $this->session->userdata('KD_GUDANG');
		$KD_GROUP = $this->session->userdata('KD_GROUP');
		$this->newtable->breadcrumb('Dashboard', site_url(),'icon-home');
		$this->newtable->breadcrumb('Report', 'javascript:void(0)','');
		$this->newtable->breadcrumb('Pergerakan', 'javascript:void(0)','');
		$this->newtable->breadcrumb(strtoupper($act), 'javascript:void(0)','');
		$check = (grant()=="W")?true:false;
		$addsql = "";
		$SQL = "SELECT A.NO_SPK AS 'NO. SPK',CONCAT('JENIS DOKUMEN : ',C.NAMA,'<BR>NO. DOKUMEN : ',A.NO_DOK,'<BR>TGL. DOKUMEN : ',A.TGL_DOK) AS 'DOKUMEN',
				CONCAT('NAMA KAPAL : ',A.NM_KAPAL,'<BR>NO. VOYAGE : ',A.NO_VOY) AS 'KAPAL',CONCAT('NPWP : ',A.NPWP,'<BR>CONSIGNEE : ',A.CONSIGNEE) AS 'CUSTOMER',
				CONCAT('NO. KONTAINER : ',B.NO_CONT,'<BR>UKURAN : ',B.UKR_CONT) AS 'KONTAINER'
					FROM t_spk A
					INNER JOIN t_spk_cont B ON A.ID = B.ID
					LEFT JOIN reff_kode_dok_bc C ON C.ID = A.JNS_DOK
					LEFT JOIN t_operation D ON A.NO_SPK = D.NO_SPK AND B.NO_CONT = D.NO_CONT WHERE 1=1".$addsql;
		$this->newtable->multiple_search(true);
		$this->newtable->show_chk(false);
		$this->newtable->show_menu($check);
		$this->newtable->show_search(true);
		$proses = array('EXPORT EXCEL' => array('EXCEL', "process/excel/pergerakan/".$act, '0','','md-file-text','','menu'));
		$this->newtable->search(array(array('A.NO_SPK','NO. SPK'),array('A.NO_DOK','NO. DOKUMEN'),array('A.NPWP','NPWP')));
		$this->newtable->action(site_url() . "/report/pergerakan/".$act);
		//if($check) $this->newtable->detail(array('POPUP',"dokumen/bc11/detail"));
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array());
		$this->newtable->keys(array("ID_REQ"));
		$this->newtable->validasi(array());
		$this->newtable->cidb($this->db);
		$this->newtable->orderby("A.NO_SPK,B.NO_CONT");
		$this->newtable->sortby("ASC");
		$this->newtable->set_formid("tblpergerakan");
		$this->newtable->set_divid("divtblpergerakan");
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
	
	public function bildelivery($act, $id){
		$func = get_instance();
        $func->load->model("m_main", "main", true);
		$title = "REPORT BILLING DELIVERY ".strtoupper($act);
		$KD_TPS = $this->session->userdata('KD_TPS');
		$KD_GUDANG = $this->session->userdata('KD_GUDANG');
		$KD_GROUP = $this->session->userdata('KD_GROUP');
		$this->newtable->breadcrumb('Dashboard', site_url(),'icon-home');
		$this->newtable->breadcrumb('Report', 'javascript:void(0)','');
		$this->newtable->breadcrumb('Billing Delivery', 'javascript:void(0)','');
		$this->newtable->breadcrumb(strtoupper($act), 'javascript:void(0)','');
		$check = (grant()=="W")?true:false;
		$addsql = "";
		$SQL = "SELECT A.ID_REQ AS 'ID REQUEST',A.TGL_REQ AS 'TANGGAL REQUEST', A.NO_NOTA_DELIVERY AS 'NO. NOTA DELIVERY', A.TGL_NOTA AS 'TANGGAL NOTA', A.TOTAL, B.NAMA_CUST AS 'NAMA CUSTOMER', A.NPWP
				FROM req_delivery_hdr A
				INNER JOIN m_pelanggan B ON A.NPWP=B.NPWP
				WHERE 1=1 AND ID_REQ_OLD IS NULL".$addsql;
		$this->newtable->multiple_search(true);
		$this->newtable->show_chk(false);
		$this->newtable->show_menu($check);
		$this->newtable->show_search(true);
		$proses = array('PRANOTA' => array('EXCEL', "process/excel/bildelivery2/".$act, '0','','md-file','', 'menu'),
						'NOTA' => array('EXCEL', "process/excel/bildelivery/".$act, '0','','md-file-text','','menu'));
		$this->newtable->search(array(array('B.NAMA_CUST','NAMA CUSTOMER'),array('A.TGL_NOTA','TGL. NOTA','DATERANGE'),array('A.TGL_REQ','TGL. REQUEST','DATERANGE')));
		$this->newtable->action(site_url() . "/report/bildelivery/".$act);
		//if($check) $this->newtable->detail(array('POPUP',"dokumen/bc11/detail"));
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array());
		$this->newtable->keys(array("ID_REQ"));
		$this->newtable->validasi(array());
		$this->newtable->cidb($this->db);
		$this->newtable->orderby("A.TGL_NOTA");
		$this->newtable->sortby("DESC");
		$this->newtable->set_formid("tblreport");
		$this->newtable->set_divid("divtblreport");
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

	public function bilextention($act, $id){
		$func = get_instance();
        $func->load->model("m_main", "main", true);
		$title = "REPORT BILLING EXTENTION ".strtoupper($act);
		$KD_TPS = $this->session->userdata('KD_TPS');
		$KD_GUDANG = $this->session->userdata('KD_GUDANG');
		$KD_GROUP = $this->session->userdata('KD_GROUP');
		$this->newtable->breadcrumb('Dashboard', site_url(),'icon-home');
		$this->newtable->breadcrumb('Report', 'javascript:void(0)','');
		$this->newtable->breadcrumb('Billing Extention', 'javascript:void(0)','');
		$this->newtable->breadcrumb(strtoupper($act), 'javascript:void(0)','');
		$check = (grant()=="W")?true:false;
		$addsql = "";
		$SQL = "SELECT A.ID_REQ,A.TGL_REQ, A.NO_NOTA_DELIVERY, A.TGL_NOTA, A.TOTAL, B.NAMA_CUST
				FROM req_delivery_hdr A
				INNER JOIN m_pelanggan B ON A.NPWP=B.NPWP
				WHERE 1=1 AND ID_REQ_OLD IS NOT NULL ".$addsql;
		$this->newtable->multiple_search(true);
		$this->newtable->show_chk(false);
		$this->newtable->show_menu($check);
		$this->newtable->show_search(true);
		$proses = array('PRANOTA' => array('EXCEL', "process/excel/bilextention2/".$act, '0','','md-file','', 'menu'),
						'NOTA' => array('EXCEL', "process/excel/bilextention/".$act, '0','','md-file-text','','menu'));
		$this->newtable->search(array(array('A.NAMA_CUST','NAMA CUSTOMER'),array('A.TGL_NOTA','TGL. NOTA','DATERANGE'),array('A.TGL_REQ','TGL. REQUEST','DATERANGE')));
		$this->newtable->action(site_url() . "/report/bilextention/".$act);
		//if($check) $this->newtable->detail(array('POPUP',"dokumen/bc11/detail"));
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array());
		$this->newtable->keys(array("ID_REQ"));
		$this->newtable->validasi(array());
		$this->newtable->cidb($this->db);
		$this->newtable->groupby(1);
		$this->newtable->orderby(3);
		$this->newtable->sortby("DESC");
		$this->newtable->set_formid("tblreport");
		$this->newtable->set_divid("divtblreport");
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

	public function bilproduction($act, $id){
		$func = get_instance();
        $func->load->model("m_main", "main", true);
		$title = "REPORT BILLING PRODUCTION ".strtoupper($act);
		$KD_TPS = $this->session->userdata('KD_TPS');
		$KD_GUDANG = $this->session->userdata('KD_GUDANG');
		$KD_GROUP = $this->session->userdata('KD_GROUP');
		$this->newtable->breadcrumb('Dashboard', site_url(),'icon-home');
		$this->newtable->breadcrumb('Report', 'javascript:void(0)','');
		$this->newtable->breadcrumb('Billing Production', 'javascript:void(0)','');
		$this->newtable->breadcrumb(strtoupper($act), 'javascript:void(0)','');
		$check = (grant()=="W")?true:false;
		$addsql = " ";
		$SQL = "SELECT A.NO_CONT AS 'KONTAINER', CONCAT(C.BHD_NO_DOK, '<BR>', C.BHD_TGL_DOK) AS 'DOKUMEN', C.BHD_ID_REQ AS 'NO REQUEST BEHANDLE', C.BHD_TGL_REQ AS 'TGL REQUEST BEHANDLE',CONCAT(D.NO_DOK, '<BR>',D.TGL_DOK) AS 'DOKUMEN SPPB', D.ID_REQ AS 'NO REQUEST DELIVERY', D.TGL_REQ AS 'TGL REQUEST DELIVERY', D.NO_NOTA_DELIVERY AS 'NO NOTA', D.TGL_NOTA AS 'TGL NOTA', C.BHD_NAMA_CUST AS 'CUSTOMER'
				FROM t_cocostscont A
				LEFT JOIN t_cocostshdr B ON B.ID = A.ID

				INNER JOIN (
					SELECT B.NO_CONT, A.JNS_DOK AS BHD_JNS_DOK, A.NO_DOK AS BHD_NO_DOK, A.TGL_DOK AS BHD_TGL_DOK, A.NAMA_CUST AS BHD_NAMA_CUST, B.JNS_KEGIATAN AS BHD_JNS_KEGIATAN, A.ID_REQ AS BHD_ID_REQ, A.TGL_REQ AS BHD_TGL_REQ, A.NO_NOTA_BEHANDLE, A.TGL_NOTA AS BHD_TGL_NOTA, (A.SUBTOTAL + A.BIAYA_ADMIN) AS BHD_SUB_TOTAL, A.PPN AS BHD_PPN, A.BIAYA_MATERAI AS BHD_BIAYA_MATERAI, A.TOTAL_JUMLAH AS BHD_TOTAL_JUMLAH
					FROM req_behandle_hdr A
					INNER JOIN (
						SELECT DISTINCT ID_REQ, NO_CONT, CONCAT('BEHANDLE ',JNS_KEGIATAN) AS JNS_KEGIATAN
						FROM req_behandle_dtl 
					)AS B ON B.ID_REQ = A.ID_REQ
				)AS C ON C.NO_CONT = A.NO_CONT

				INNER JOIN (
					SELECT B.NO_CONT, CASE WHEN A.ID_REQ_OLD IS NULL THEN 'DELIVERY' ELSE 'DELIVERY EXT' END AS TYPE_KEGIATAN, 'SPPB PIB 2.0' AS TYPE_SPPB, A.NO_DOK, A.TGL_DOK, A.EXPIRED, A.NO_DO, A.NO_BL, A.ID_REQ, A.TGL_REQ, A.NO_NOTA_DELIVERY, A.TGL_NOTA, A.SUBTOTAL, A.PPN, A.BIAYA_MATERAI, A.TOTAL, A.NPWP, A.NM_KAPAL, A.NO_VOY 
					FROM req_delivery_hdr A
					INNER JOIN (
						SELECT DISTINCT ID_REQ, NO_CONT
						FROM req_delivery_dtl -- GROUP BY NO_CONT
					)AS B ON B.ID_REQ = A.ID_REQ
				) AS D ON D.NO_CONT = A.NO_CONT -- AND D.NM_KAPAL = B.NM_ANGKUT AND D.NO_VOY = B.NO_VOY_FLIGHT

				INNER JOIN (
					SELECT ID_REQ, NO_CONT, LIFT_ON AS TOTAL_LIFT_ON, TOTAL AS TOTAL_NPCT
					FROM req_delivery_production
				) AS E ON E.NO_CONT = A.NO_CONT AND E.ID_REQ = D.ID_REQ
				WHERE D.NO_NOTA_DELIVERY IS NOT NULL".$addsql;
		$this->newtable->multiple_search(true);
		$this->newtable->show_chk(false);
		$this->newtable->show_menu($check);
		$this->newtable->show_search(true);
		$proses = array('CETAK' => array('EXCEL', "process/excel/bilproduction/".$act, '0','','md-file','', 'menu'));
		$this->newtable->search(array(array('C.BHD_NAMA_CUST','NAMA CUSTOMER'),array('D.TGL_NOTA','TGL. NOTA DELIVERY','DATERANGE'),array('D.TGL_REQ','TGL. REQUEST','DATERANGE')));
		$this->newtable->action(site_url() . "/report/bilproduction/".$act);
		//if($check) $this->newtable->detail(array('POPUP',"dokumen/bc11/detail"));
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array());
		$this->newtable->keys(array("D.ID_REQ"));
		$this->newtable->validasi(array());
		$this->newtable->cidb($this->db);
		$this->newtable->groupby();
		$this->newtable->orderby(3);
		$this->newtable->sortby("DESC");
		$this->newtable->set_formid("tblreport");
		$this->newtable->set_divid("divtblreport");
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

	public function monthly($act, $id){
		$func = get_instance();
        $func->load->model("m_main", "main", true);
		$title = "REPORT MONTHLY ".strtoupper($act);
		$KD_TPS = $this->session->userdata('KD_TPS');
		$KD_GUDANG = $this->session->userdata('KD_GUDANG');
		$KD_GROUP = $this->session->userdata('KD_GROUP');
		$this->newtable->breadcrumb('Dashboard', site_url(),'icon-home');
		$this->newtable->breadcrumb('Report', 'javascript:void(0)','');
		$this->newtable->breadcrumb('Monthly', 'javascript:void(0)','');
		$this->newtable->breadcrumb(strtoupper($act), 'javascript:void(0)','');
		$check = (grant()=="W")?true:false;
		$addsql = "";
		if($act=="impor") $addsql .= " AND A.KD_ASAL_BRG = '1'";
		elseif($act=="ekspor") $addsql .= " AND A.KD_ASAL_BRG = '3'";
		else $addsql .= " AND A.KD_ASAL_BRG = '0'";
		$SQL = "SELECT E.NAMA AS 'ASAL BARANG', CONCAT(IFNULL(C.NAMA,'-'),'<BR>[',IFNULL(A.NM_ANGKUT,'-'),']') AS 'NAMA ANGKUT',
				A.NO_VOY_FLIGHT AS 'NO. VOYAGE/FLIGHT',
				DATE_FORMAT(A.TGL_TIBA,'%d-%m-%Y') AS 'TGL. TIBA', A.NO_BC11 AS 'NO. BC11',
				DATE_FORMAT(A.TGL_BC11,'%d-%m-%Y') AS 'TGL. BC11', D.NO_CONT AS 'NO. KONTAINER', D.KD_CONT_UKURAN AS UKURAN
				FROM t_cocostshdr A
				LEFT JOIN reff_gudang B ON A.KD_TPS = B.KD_TPS AND A.KD_GUDANG = B.KD_GUDANG
				LEFT JOIN reff_kapal C ON A.KD_KAPAL = C.ID
				INNER JOIN t_cocostscont D ON D.ID=A.ID
				LEFT JOIN reff_asal_brg E ON E.ID=A.KD_ASAL_BRG
				WHERE 1=1".$addsql;
		$this->newtable->multiple_search(true);
		$this->newtable->show_chk(false);
		$this->newtable->show_menu($check);
		$this->newtable->show_search(true);
		$proses = array('EXPORT EXCEL' => array('EXCEL', "report/process/excel/monthly/".$act, '0','','md-file-text','','1'));
		$this->newtable->search(array(array('A.TGL_TIBA','TGL. TIBA','DATERANGE'),array('D.NO_CONT','NO. KONTAINER')));
		$this->newtable->action(site_url() . "/report/monthly/".$act);
		//if($check) $this->newtable->detail(array('POPUP',"dokumen/bc11/detail"));
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("ID"));
		$this->newtable->keys(array("ID"));
		$this->newtable->validasi(array());
		$this->newtable->cidb($this->db);
		$this->newtable->orderby(3);
		$this->newtable->sortby("ASC");
		$this->newtable->set_formid("tblreport");
		$this->newtable->set_divid("divtblreport");
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

	public function repository($act, $id){
		$func = get_instance();
        $func->load->model("m_main", "main", true);
		$title = "REPORT REPOSITORY ".strtoupper($act);
		$KD_TPS = $this->session->userdata('KD_TPS');
		$KD_GUDANG = $this->session->userdata('KD_GUDANG');
		$KD_GROUP = $this->session->userdata('KD_GROUP');
		$this->newtable->breadcrumb('Dashboard', site_url(),'icon-home');
		$this->newtable->breadcrumb('Report', 'javascript:void(0)','');
		$this->newtable->breadcrumb('Repository', 'javascript:void(0)','');
		$this->newtable->breadcrumb(strtoupper($act), 'javascript:void(0)','');
		$check = (grant()=="W")?true:false;
		$addsql = "";
		if($act=="impor") $addsql .= " AND A.KD_ASAL_BRG IN ('1','2')";
		elseif($act=="ekspor") $addsql .= " AND A.KD_ASAL_BRG IN ('3','4')";
		else $addsql .= " AND A.KD_ASAL_BRG = '0'";
		$SQL = "SELECT A.URAIAN_DOKUMEN AS DOKUMEN, CONCAT(IFNULL(C.NAMA,'-'),'<BR>[',IFNULL(A.NM_ANGKUT,'-'),']') AS 'NAMA ANGKUT',
				A.NO_VOY_FLIGHT AS 'NO. VOYAGE/FLIGHT',
				DATE_FORMAT(A.TGL_TIBA,'%d-%m-%Y') AS 'TGL. TIBA', A.NO_BC11 AS 'NO. BC11',
				DATE_FORMAT(A.TGL_BC11,'%d-%m-%Y') AS 'TGL. BC11', D.NO_CONT AS 'NO. KONTAINER', D.KD_CONT_UKURAN AS UKURAN,
				A.WK_REKAM
				FROM t_repohdr A
				LEFT JOIN reff_gudang B ON A.KD_TPS = B.KD_TPS AND A.KD_GUDANG = B.KD_GUDANG
				LEFT JOIN reff_kapal C ON A.KD_KAPAL = C.ID
				INNER JOIN t_repocont D ON D.ID=A.ID
				WHERE 1=1".$addsql;
		$this->newtable->multiple_search(true);
		$this->newtable->show_chk(false);
		$this->newtable->show_menu($check);
		$this->newtable->show_search(true);
		$proses = array('EXPORT EXCEL' => array('EXCEL', "report/process/excel/repository/".$act, '0','','md-file-text','','1'));
		$this->newtable->search(array(array('A.TGL_TIBA','TGL. TIBA','DATERANGE'),array('D.NO_CONT','NO. KONTAINER')));
		$this->newtable->action(site_url() . "/report/repository/".$act);
		//if($check) $this->newtable->detail(array('POPUP',"dokumen/bc11/detail"));
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("ID","WK_REKAM"));
		$this->newtable->keys(array("ID"));
		$this->newtable->validasi(array());
		$this->newtable->cidb($this->db);
		$this->newtable->orderby(8);
		$this->newtable->sortby("DESC");
		$this->newtable->set_formid("tblreport");
		$this->newtable->set_divid("divtblreport");
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

	function process($type, $act, $id){//print_r($type.$act);die();
        $func = get_instance();
        $func->load->model("m_main", "main", true);
        $success = 0;
        $error = 0;
        $USERLOGIN = $this->session->userdata('USERLOGIN');
        $KD_TPS = $this->session->userdata('KD_TPS');
        $KD_GUDANG = $this->session->userdata('KD_GUDANG');
        if($type == "excel"){
			if($act=="behandle"){
				
				$no_kon = $this->input->post('form[0]');
				$tgl_nota = $this->input->post('form[1]');
				$tgl_nota_start = $tgl_nota[0];
				$tgl_nota_end = $tgl_nota[1];
				$no_kon1 = $no_kon[0];
				$addsql = "";
				//print_r($this->input->post('form'));die();
				if($tgl_nota_start!="" and $tgl_nota_end !=""){
					//$addsql .= " AND DATE(K.behandlein) BETWEEN '$tgl_nota_start' AND '$tgl_nota_end' GROUP BY B.NO_CONT limit 2000";
					$addsql .= " D.WK_IN BETWEEN '$tgl_nota_start' AND '$tgl_nota_end' GROUP BY B.NO_CONT";
				}else if($tgl_nota_start != ""){
					//$addsql .= " AND DATE(K.behandlein) >= '$tgl_nota_start' GROUP BY B.NO_CONT limit 2000";
					$addsql .= " D.WK_IN >= '$tgl_nota_start' GROUP BY B.NO_CONT";
				}else if($tgl_nota_end != ""){
					//$addsql .= " AND DATE(K.behandlein) <= '$tgl_nota_end' GROUP BY B.NO_CONT limit 2000";
					$addsql .= " AND D.WK_IN <= '$tgl_nota_end' GROUP BY B.NO_CONT";
				}else{
					$addsql .= "GROUP BY B.NO_CONT";
				}
				

				if($no_kon1 != ""){
					//$addsql .= " AND D.NO_CONT = '$no_kon1'";
				}
				
				$SQL = "SELECT B.NO_CONT AS 'KONTAINER', B.UKR_CONT AS 'UKURAN', B.LOKASI, A.NO_SPK AS 'NO SPK', A.TGL_SPK AS 'TANGGAL SPK', H.JNS_KEGIATAN AS 'BEHANDLE', C.KETERANGAN AS 'STATUS', 'I' AS CLASS, F.CALL_SIGN AS 'KODE KAPAL', A.NM_KAPAL AS 'NAMA KAPAL', A.NO_VOY AS 'NO VOYAGE', E.ISO_CODE AS 'ISO CODE', E.KD_CONT_TIPE AS 'TYPE', F.TGL_TIBA AS 'TANGGAL TIBA', G.NAMA AS 'JENIS DOKUMEN', A.NO_DOK AS 'NO DOKUMEN',A.TGL_DOK AS 'TANGGAL DOKUMEN', E.WK_IN AS 'STACKING', A.CONSIGNEE AS 'CUSTOMER', D.WK_PICKUP AS 'WAKTU PICKUP', B.ID_FLAT AS 'TID', D.WK_TERMINAL_IN AS 'GATE IN', D.WK_TERMINAL_OUT AS 'GATE OUT', D.WK_IN AS 'WAKTU BEHANDLE IN', D.WK_START AS 'WAKTU MULAI PERIKSA', D.WK_FINISH AS 'WAKTU SELESAI PERIKSA', D.LOKASI_INSP AS 'LOKASI PERIKSA', D.NO_SEAL AS 'SEAL', J.WK_REKAM AS 'REQUEST_GATEPASS', J.WK_APP AS 'WAKTU APPROVED',I.JNS_DOK AS 'JENIS DOKUMEN DELIVERY', I.NO_DOK AS 'NO DOKUMEN DELIVERY', I.TGL_DOK AS 'TGL DOKUMEN DELIVERY', D.WK_TRUCKIN AS 'WAKTU TRUCK IN',  D.WK_CHASSIS AS 'WAKTU ON CHASSIS', D.WK_GATEOUT AS 'WAKTU DELIVERY'
					FROM t_spk A
					INNER JOIN t_spk_cont B ON A.ID = B.ID
					LEFT JOIN reff_status_spk C ON B.STATUS_CONT = C.ID
					LEFT JOIN t_operation D ON A.NO_SPK = D.NO_SPK AND B.NO_CONT = D.NO_CONT
					INNER JOIN t_cocostscont E ON B.NO_CONT = E.NO_CONT
					INNER JOIN t_cocostshdr F ON E.ID = F.ID
					LEFT JOIN reff_kode_dok_bc G ON A.JNS_DOK = G.ID
					LEFT JOIN t_gatepass H ON H.NO_DOK = D.NO_DOK AND H.TGL_DOK = D.TGL_DOK AND H.NO_CONT = D.NO_CONT

					LEFT JOIN (SELECT DISTINCT Y.JNS_DOK, Y.NO_DOK, Y.TGL_DOK, W.NO_CONT FROM req_delivery_hdr Y
					INNER JOIN req_delivery_dtl W ON Y.ID_REQ = W.ID_REQ
					WHERE W.NO_CONT IS NOT NULL ORDER BY Y.ID DESC LIMIT 1) I ON I.NO_CONT = B.NO_CONT

					LEFT JOIN (SELECT X.JNS_DOK, X.NO_DOK, X.TGL_DOK,Z.NO_CONT, CASE WHEN Z.KD_STATUS = 'APPROVED' THEN Z.TGL_STATUS ELSE NULL END AS 'WK_APP', X.WK_REKAM
					FROM t_request X
					INNER JOIN t_request_cont Z ON X.ID = Z.ID
					ORDER BY X.id DESC
					LIMIT 1) J ON A.JNS_DOK = J.JNS_DOK AND A.NO_DOK = J.NO_DOK AND A.TGL_DOK = J.TGL_DOK AND B.NO_CONT = J.NO_CONT ".$addsql;
				
				$result = $func->main->get_result($SQL);
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
				$this->newphpexcel->mergecell(array(array('A1','W1'),array('A2','W2'),array('A3','W3'),array('B5','P5'),array('Q5','U5'),array('V5','AD5'),array('AE5','AK5'),array('AL5','AO5'),array('AP5','AV5'),array('AW5','BB5'),array('BC5','BH5'),array('BI5','BO5'),array('BP5','BR5'),array('BS5','BX5')), FALSE);//
				$this->newphpexcel->getActiveSheet()->getStyle('A5:BX5')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFD700');
				$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A1', 'DAILY REPORT BEHANDLE');
				$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A2', 'COMMON GATE IPC TPK');
				$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A3', date("M Y"));
				$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('B5', 'BEHANDLE 1');
				$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('Q5', 'REQUEST BEHANDLE 1');
				$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('V5', 'PENARIKAN');
				$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('AE5', 'PEMERIKSAAN BEHANDLE 1');
				$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('AL5', 'REQ BEHANDLE 2');
				$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('AP5', 'PEMERIKSAAN BEHANDLE 2');
				$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('AW5', 'BILLING BEHANDLE 1');
				$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('BC5', 'BILLING BEHANDLE 2');
				$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('BI5', 'REQUEST BILLING DELIVERY');
				$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('BP5', 'REQUEST BILLING DELIVERY EXTENTION');
				$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('BS5', 'DELIVERY');
				
				$this->newphpexcel->width(array(array('A',5),array('B',18),array('C',8),array('D',8),array('E',20),array('F',12),array('G',15),array('H',18),array('I',12),array('J',10),array('K',15),array('L',22),array('M',20),array('N',30),array('O',20),array('P',25),array('Q',20),array('R',25),array('S',15),array('T',20),array('U',25),array('V',20),array('W',15),array('X',15),array('Y',15),array('Z',25),array('AA',30),array('AB',10),array('AC',12),array('AD',20),array('AE',25),array('AF',15),array('AG',25),array('AH',25),array('AI',20),array('AJ',25),array('AK',20)));
				
				$this->newphpexcel->setActiveSheetIndex(0)
					->setCellValue('A6','NO')
					->setCellValue('B6','NO CONTAINER')
					->setCellValue('C6','SIZE')
					->setCellValue('D6','LOKASI')
					->setCellValue('E6','NO SPK')
					->setCellValue('F6','TANGGAL SPK')
					->setCellValue('G6','BEHANDLE')
					->setCellValue('H6','STATUS')
					->setCellValue('I6','CLASS')
					->setCellValue('J6','NAMA KAPAL')
					->setCellValue('K6','KODE KAPAL')
					->setCellValue('L6','NO VOYAGE')
					->setCellValue('M6','ISO CODE')
					->setCellValue('N6','TYPE')
					->setCellValue('O6','TANGGAL TIBA')
					->setCellValue('P6','JENIS DOKUMEN')
					->setCellValue('Q6','NO DOKUMEN')
					->setCellValue('R6','TANGGAL DOKUMEN')
					->setCellValue('S6','STACKING')
					->setCellValue('T6','CUSTOMER')
					->setCellValue('U6','WAKTU PICKUP')
					->setCellValue('V6','TID')
					->setCellValue('W6','GATE IN')
					->setCellValue('X6','GATE OUT')
					->setCellValue('Y6','WAKTU BEHANDLE IN')
					->setCellValue('Z6','WAKTU MULAI PERIKSA')
					->setCellValue('AA6','WAKTU SELESAI PERIKSA')
					->setCellValue('AB6','LOKASI PERIKSA')
					->setCellValue('AC6','NO SEAL')
					->setCellValue('AD6','REQUEST GATEPASS')
					->setCellValue('AE6','WAKTU APPROVED')
					->setCellValue('AF6','JENIS DOKUMEN DELIVERY')
					->setCellValue('AG6','NO DOKUMEN DELIVERY')
					->setCellValue('AH6','TANGGAL DOKUMEN DELIVERY')
					->setCellValue('AI6','WAKTU TRUCK IN')
					->setCellValue('AJ6','WAKTU ON CHASSIS')
					->setCellValue('AK6','WAKTU DELIVERY');
				$this->newphpexcel->headings(array('A6','B6','C6','D6','E6','F6','G6','H6','I6','J6','K6','L6','M6','N6','O6','P6','Q6','R6','S6','T6','U6','V6','W6','X6','Y6','Z6','AA6','AB6','AC6','AD6','AE6','AF6','AG6','AH6','AI6','AJ6','AK6'));
				$this->newphpexcel->set_wrap(array('B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK'));
				$no = 1;
				$rec = 7;
				if($result){
					foreach($SQL->result_array() as $row){
						$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A'.$rec,$no)
						->setCellValueExplicit('B'.$rec,$row["KONTAINER"],PHPExcel_Cell_DataType::TYPE_STRING)
						->setCellValueExplicit('C'.$rec,$row["UKURAN"],PHPExcel_Cell_DataType::TYPE_STRING)
						->setCellValueExplicit('D'.$rec,$row["LOKASI"])
						->setCellValueExplicit('E'.$rec,$row["NO SPK"],PHPExcel_Cell_DataType::TYPE_STRING)
						->setCellValueExplicit('F'.$rec,$row["TANGGAL SPK"],PHPExcel_Cell_DataType::TYPE_STRING)
						->setCellValue('G'.$rec,$row["BEHANDLE"])
						->setCellValueExplicit('H'.$rec,$row["STATUS"],PHPExcel_Cell_DataType::TYPE_STRING)
						->setCellValue('I'.$rec,$row["CLASS"])
						->setCellValue('J'.$rec,$row["NAMA KAPAL"])
						->setCellValue('K'.$rec,$row["KODE KAPAL"])
						->setCellValue('L'.$rec,$row["NO VOYAGE"])
						->setCellValue('M'.$rec,$row["ISO CODE"])
						->setCellValue('N'.$rec,$row["TYPE"])
						->setCellValue('O'.$rec,$row["TANGGAL TIBA"])
						->setCellValue('P'.$rec,$row["JENIS DOKUMEN"])
						->setCellValue('Q'.$rec,$row["NO DOKUMEN"])
						->setCellValue('R'.$rec,$row["TANGGAL DOKUMEN"])
						->setCellValue('S'.$rec,$row["STACKING"])
						->setCellValue('T'.$rec,$row["CUSTOMER"])
						->setCellValue('U'.$rec,$row["WAKTU PICKUP"])
						->setCellValue('V'.$rec,$row["TID"])
						->setCellValue('W'.$rec,$row["GATE IN"])
						->setCellValue('X'.$rec,$row["GATE OUT"])
						->setCellValue('Y'.$rec,$row["WAKTU BEHANDLE IN"])
						->setCellValue('Z'.$rec,$row["WAKTU MULAI PERIKSA"])
						->setCellValue('AA'.$rec,$row["WAKTU SELESAI PERIKSA"])
						->setCellValue('AB'.$rec,$row["LOKASI PERIKSA"])
						->setCellValue('AC'.$rec,$row["SEAL"])
						->setCellValue('AD'.$rec,$row["REQUEST_GATEPASS"])
						->setCellValue('AE'.$rec,$row["WAKTU APPROVED"])
						->setCellValue('AF'.$rec,$row["JENIS DOKUMEN DELIVERY"])
						->setCellValue('AG'.$rec,$row["NO DOKUMEN DELIVERY"])
						->setCellValue('AH'.$rec,$row["TGL DOKUMEN DELIVERY"])
						->setCellValue('AI'.$rec,$row["WAKTU TRUCK IN"])
						->setCellValue('AJ'.$rec,$row["WAKTU ON CHASSIS"])
						->setCellValue('AK'.$rec,$row["WAKTU DELIVERY"]);
						
						$this->newphpexcel->set_detilstyle(array('A'.$rec,'B'.$rec,'C'.$rec,'D'.$rec,'E'.$rec,'F'.$rec,'G'.$rec,'H'.$rec,'I'.$rec,'J'.$rec,'K'.$rec,'L'.$rec,'M'.$rec,'N'.$rec,'O'.$rec,'P'.$rec,'Q'.$rec,'R'.$rec,'S'.$rec,'T'.$rec,'U'.$rec,'V'.$rec,'W'.$rec,'X'.$rec,'Y'.$rec,'Z'.$rec,'AA'.$rec,'AB'.$rec,'AC'.$rec,'AD'.$rec,'AE'.$rec,'AF'.$rec,'AG'.$rec,'AH'.$rec,'AI'.$rec,'AJ'.$rec,'AK'.$rec));
						$rec++;
						$no++;	
					}
				}else{
					$this->newphpexcel->getActiveSheet()->mergeCells('A6:AK6');
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A6','DATA TIDAK DITEMUKAN');
					$this->newphpexcel->set_detilstyle(array('A6'));
				}
				ob_clean();

				$file = "BEHANDLE_" . date("Ymd") . ".xls";
				header("Content-type: application/x-msdownload");
				header("Content-Disposition: attachment;filename=$file");
				header("Cache-Control: max-age=0");
				header("Pragma: no-cache");
				header("Expires: 0");
				$objWriter = PHPExcel_IOFactory::createWriter($this->newphpexcel, 'Excel5');
				$objWriter->save('php://output');
				exit();
			}else if($act=="bilbehandle"){//print_r($_POST);die();
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
					$addsql .= " AND DATE(A.TGL_NOTA) BETWEEN '$tgl_nota_start' AND '$tgl_nota_end' order by A.TGL_NOTA";
				}else if($tgl_nota_start != ""){
					$addsql .= " AND DATE(A.TGL_NOTA) >= '$tgl_nota_start' order by A.TGL_NOTA";
				}else if($tgl_nota_end != ""){
					$addsql .= " AND DATE(A.TGL_NOTA) <= '$tgl_nota_end' order by A.TGL_NOTA";
				}else{
					#$addsql .= " AND MONTH(A.TGL_TIBA) = MONTH(NOW()) AND YEAR(A.TGL_TIBA) = YEAR(NOW())";
				}

				if($tgl_req_start!="" and $tgl_req_end !=""){
					$addsql .= " AND DATE(A.TGL_REQ) BETWEEN '$tgl_req_start' AND '$tgl_req_end' order by A.TGL_NOTA";
				}else if($tgl_req_start != ""){
					$addsql .= " AND DATE(A.TGL_REQ) >= '$tgl_req_start' order by A.TGL_NOTA";
				}else if($tgl_req_end != ""){
					$addsql .= " AND DATE(A.TGL_REQ) <= '$tgl_req_end' order by A.TGL_NOTA";
				}

				if($no_cust != ""){
					$addsql .= " AND A.NAMA_CUST LIKE '%$no_cust%' order by A.TGL_NOTA";
				}
				$SQL = "SELECT A.ID_REQ, A.TGL_REQ,A.NO_NOTA_BEHANDLE, A.TGL_NOTA,B.JNS_KEGIATAN AS 'JNS_NOTA', (A.SUBTOTAL+A.BIAYA_ADMIN) AS SUBTOTAL,A.PPN,A.BIAYA_MATERAI,
						A.TOTAL_JUMLAH, A.NAMA_CUST,A.NPWP, B.NO_CONT, B.TGL_BONGKAR, C.NAMA_BANK
						FROM req_behandle_hdr A
						LEFT JOIN (SELECT Z.ID_REQ, Z.NO_CONT AS 'CONT',
						GROUP_CONCAT(DISTINCT Z.NO_CONT,'[',Z.UK_CONT,']' SEPARATOR '\r') AS NO_CONT, 
						GROUP_CONCAT('BEHANDLE ',Z.JNS_KEGIATAN SEPARATOR '\r') AS JNS_KEGIATAN,
						GROUP_CONCAT(X.WK_IN SEPARATOR '\r') AS TGL_BONGKAR
						FROM req_behandle_dtl Z
						INNER JOIN t_cocostscont X ON X.NO_CONT = Z.NO_CONT
						GROUP BY ID_REQ) B ON B.ID_REQ=A.ID_REQ
						INNER JOIN m_bank C ON A.BANK_ID = C.BANK_ID
						WHERE 1=1 AND A.NO_NOTA_BEHANDLE != ''".$addsql;
				$result = $func->main->get_result($SQL);
				$this->load->library('newphpexcel');
				$this->newphpexcel->getDefaultStyle()->getFont()->setName('Calibri')->setSize(10);
				$this->newphpexcel->setActiveSheetIndex(0);
				$styleArray = array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
				$this->newphpexcel->getDefaultStyle()->applyFromArray($styleArray);
				$this->newphpexcel->set_bold(array('A1'));
				$this->newphpexcel->mergecell(array(array('A1','O1')), FALSE);
				$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A1', 'REPORT BILLING BEHANDLE');
				$this->newphpexcel->width(array(array('A',5),array('B',25),array('C',25),array('D',25),array('E',20),array('F',15),array('G',15),array('H',10),array('I',15),array('J',25),array('K',25),array('L',25),array('M',25),array('N',25),array('O',25)));
				$this->newphpexcel->setActiveSheetIndex(0)
					->setCellValue('A3','NO')
					->setCellValue('B3','NO REQUEST')
					->setCellValue('C3','TGL REQUEST')
					->setCellValue('D3','NO NOTA')
					->setCellValue('E3','TGL NOTA')
					->setCellValue('F3','JENIS NOTA')
					->setCellValue('G3','NAMA BANK')
					->setCellValue('H3','TGL BONGKAR')
					->setCellValue('I3','NILAI TAGIHAN')
					->setCellValue('J3','NILAI PPN')
					->setCellValue('K3','NILAI MATERAI')
					->setCellValue('L3','NILAI NOTA')
					->setCellValue('M3','CUSTOMER')
					->setCellValue('N3','NPWP')
					->setCellValue('O3','NOMOR CONTAINER');
				$this->newphpexcel->headings(array('A3','B3','C3','D3','E3','F3','G3','H3','I3','J3','K3','L3','M3','N3','O3'));
				$this->newphpexcel->set_wrap(array('B','C','D','E','F','G','H','I','J','K','L','M','N','O'));
				$no = 1;
				$rec = 4;
				if($result){
					foreach($SQL->result_array() as $row){
						$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A'.$rec,$no)
						->setCellValueExplicit('B'.$rec,$row["ID_REQ"],PHPExcel_Cell_DataType::TYPE_STRING)
						->setCellValueExplicit('C'.$rec,$row["TGL_REQ"],PHPExcel_Cell_DataType::TYPE_STRING)
						->setCellValueExplicit('D'.$rec,$row["NO_NOTA_BEHANDLE"],PHPExcel_Cell_DataType::TYPE_STRING)
						->setCellValueExplicit('E'.$rec,$row["TGL_NOTA"],PHPExcel_Cell_DataType::TYPE_STRING)
						->setCellValue('F'.$rec,$row["JNS_NOTA"])
						->setCellValue('G'.$rec,$row["NAMA_BANK"])
						->setCellValueExplicit('H'.$rec,$row["TGL_BONGKAR"],PHPExcel_Cell_DataType::TYPE_STRING)
						->setCellValueExplicit('I'.$rec,$row["SUBTOTAL"],PHPExcel_Cell_DataType::TYPE_STRING)
						->setCellValue('J'.$rec,$row["PPN"])
						->setCellValueExplicit('K'.$rec,$row["BIAYA_MATERAI"],PHPExcel_Cell_DataType::TYPE_STRING)
						->setCellValue('L'.$rec,$row["TOTAL_JUMLAH"])
						->setCellValue('M'.$rec,$row["NAMA_CUST"])
						->setCellValue('N'.$rec,$row["NPWP"])
						->setCellValue('O'.$rec,$row["NO_CONT"]);
						$this->newphpexcel->set_detilstyle(array('A'.$rec,'B'.$rec,'C'.$rec,'D'.$rec,'E'.$rec,'F'.$rec,'G'.$rec,'H'.$rec,'I'.$rec,'J'.$rec,'K'.$rec,'L'.$rec,'M'.$rec,'N'.$rec,'O'.$rec));
						$rec++;
						$no++;
					}
				}else{
					$this->newphpexcel->mergecell(array(array('A5','O5')), FALSE);
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A5','DATA TIDAK DITEMUKAN');
					$this->newphpexcel->set_detilstyle(array('A5'));
				}
				ob_clean();

				$file = "BEHANDLE_" . date("Ymd") . ".xls";
				header("Content-type: application/x-msdownload");
				header("Content-Disposition: attachment;filename=$file");
				header("Cache-Control: max-age=0");
				header("Pragma: no-cache");
				header("Expires: 0");
				$objWriter = PHPExcel_IOFactory::createWriter($this->newphpexcel, 'Excel5');
				$objWriter->save('php://output');
				exit();
			}else if($act=="bilbehandle2"){
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
					$addsql .= " AND DATE(A.TGL_NOTA) BETWEEN '$tgl_nota_start' AND '$tgl_nota_end' order by A.TGL_NOTA";
				}else if($tgl_nota_start != ""){
					$addsql .= " AND DATE(A.TGL_NOTA) >= '$tgl_nota_start' order by A.TGL_NOTA";
				}else if($tgl_nota_end != ""){
					$addsql .= " AND DATE(A.TGL_NOTA) <= '$tgl_nota_end' order by A.TGL_NOTA";
				}else{
					#$addsql .= " AND MONTH(A.TGL_TIBA) = MONTH(NOW()) AND YEAR(A.TGL_TIBA) = YEAR(NOW())";
				}

				if($tgl_req_start!="" and $tgl_req_end !=""){
					$addsql .= " AND DATE(A.TGL_REQ) BETWEEN '$tgl_req_start' AND '$tgl_req_end' order by A.TGL_NOTA";
				}else if($tgl_req_start != ""){
					$addsql .= " AND DATE(A.TGL_REQ) >= '$tgl_req_start' order by A.TGL_NOTA";
				}else if($tgl_req_end != ""){
					$addsql .= " AND DATE(A.TGL_REQ) <= '$tgl_req_end' order by A.TGL_NOTA";
				}

				if($no_cust != ""){
					$addsql .= " AND A.NAMA_CUST LIKE '%$no_cust%' order by A.TGL_NOTA";
				}
				$SQL = "SELECT A.ID_REQ, A.TGL_REQ,A.NO_NOTA_BEHANDLE, A.TGL_NOTA,B.JNS_KEGIATAN AS 'JNS_NOTA', (A.SUBTOTAL+A.BIAYA_ADMIN) AS SUBTOTAL,A.PPN,A.BIAYA_MATERAI,
						A.TOTAL_JUMLAH, A.NAMA_CUST,A.NPWP, B.NO_CONT, B.TGL_BONGKAR, C.NAMA_BANK
						FROM req_behandle_hdr A
						LEFT JOIN (SELECT Z.ID_REQ, Z.NO_CONT AS 'CONT',
						GROUP_CONCAT(DISTINCT Z.NO_CONT,'[',Z.UK_CONT,']' SEPARATOR '\r') AS NO_CONT, 
						GROUP_CONCAT('BEHANDLE ',Z.JNS_KEGIATAN SEPARATOR '\r') AS JNS_KEGIATAN,
						GROUP_CONCAT(X.WK_IN SEPARATOR '\r') AS TGL_BONGKAR
						FROM req_behandle_dtl Z
						INNER JOIN t_cocostscont X ON X.NO_CONT = Z.NO_CONT
						GROUP BY ID_REQ) B ON B.ID_REQ=A.ID_REQ
						INNER JOIN m_bank C ON A.BANK_ID = C.BANK_ID
						WHERE 1=1 AND A.NO_NOTA_BEHANDLE = ''".$addsql;
				$result = $func->main->get_result($SQL);
				$this->load->library('newphpexcel');
				$this->newphpexcel->getDefaultStyle()->getFont()->setName('Calibri')->setSize(10);
				$this->newphpexcel->setActiveSheetIndex(0);
				$styleArray = array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
				$this->newphpexcel->getDefaultStyle()->applyFromArray($styleArray);
				$this->newphpexcel->set_bold(array('A1'));
				$this->newphpexcel->mergecell(array(array('A1','O1')), FALSE);
				$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A1', 'REPORT BILLING BEHANDLE');
				$this->newphpexcel->width(array(array('A',5),array('B',25),array('C',25),array('D',25),array('E',20),array('F',15),array('G',15),array('H',10),array('I',15),array('J',25),array('K',25),array('L',25),array('M',25),array('N',25),array('O',25)));
				$this->newphpexcel->setActiveSheetIndex(0)
					->setCellValue('A3','NO')
					->setCellValue('B3','NO REQUEST')
					->setCellValue('C3','TGL REQUEST')
					->setCellValue('D3','NO NOTA')
					->setCellValue('E3','TGL NOTA')
					->setCellValue('F3','JENIS NOTA')
					->setCellValue('G3','NAMA BANK')
					->setCellValue('H3','TGL BONGKAR')
					->setCellValue('I3','NILAI TAGIHAN')
					->setCellValue('J3','NILAI PPN')
					->setCellValue('K3','NILAI MATERAI')
					->setCellValue('L3','NILAI NOTA')
					->setCellValue('M3','CUSTOMER')
					->setCellValue('N3','NPWP')
					->setCellValue('O3','NOMOR CONTAINER');
				$this->newphpexcel->headings(array('A3','B3','C3','D3','E3','F3','G3','H3','I3','J3','K3','L3','M3','N3','O3'));
				$this->newphpexcel->set_wrap(array('B','C','D','E','F','G','H','I','J','K','L','M','N','O'));
				$no = 1;
				$rec = 4;
				if($result){
					foreach($SQL->result_array() as $row){
						$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A'.$rec,$no)
						->setCellValueExplicit('B'.$rec,$row["ID_REQ"],PHPExcel_Cell_DataType::TYPE_STRING)
						->setCellValueExplicit('C'.$rec,$row["TGL_REQ"],PHPExcel_Cell_DataType::TYPE_STRING)
						->setCellValueExplicit('D'.$rec,$row["NO_NOTA_BEHANDLE"],PHPExcel_Cell_DataType::TYPE_STRING)
						->setCellValueExplicit('E'.$rec,$row["TGL_NOTA"],PHPExcel_Cell_DataType::TYPE_STRING)
						->setCellValue('F'.$rec,$row["JNS_NOTA"])
						->setCellValue('G'.$rec,$row["NAMA_BANK"])
						->setCellValueExplicit('H'.$rec,$row["TGL_BONGKAR"],PHPExcel_Cell_DataType::TYPE_STRING)
						->setCellValueExplicit('I'.$rec,$row["SUBTOTAL"],PHPExcel_Cell_DataType::TYPE_STRING)
						->setCellValue('J'.$rec,$row["PPN"])
						->setCellValueExplicit('K'.$rec,$row["BIAYA_MATERAI"],PHPExcel_Cell_DataType::TYPE_STRING)
						->setCellValue('L'.$rec,$row["TOTAL_JUMLAH"])
						->setCellValue('M'.$rec,$row["NAMA_CUST"])
						->setCellValue('N'.$rec,$row["NPWP"])
						->setCellValue('O'.$rec,$row["NO_CONT"]);
						$this->newphpexcel->set_detilstyle(array('A'.$rec,'B'.$rec,'C'.$rec,'D'.$rec,'E'.$rec,'F'.$rec,'G'.$rec,'H'.$rec,'I'.$rec,'J'.$rec,'K'.$rec,'L'.$rec,'M'.$rec,'N'.$rec,'O'.$rec));
						$rec++;
						$no++;
					}
				}else{
					$this->newphpexcel->mergecell(array(array('A5','O5')), FALSE);
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A5','DATA TIDAK DITEMUKAN');
					$this->newphpexcel->set_detilstyle(array('A5'));
				}
				ob_clean();

				$file = "BEHANDLE_" . date("Ymd") . ".xls";
				header("Content-type: application/x-msdownload");
				header("Content-Disposition: attachment;filename=$file");
				header("Cache-Control: max-age=0");
				header("Pragma: no-cache");
				header("Expires: 0");
				$objWriter = PHPExcel_IOFactory::createWriter($this->newphpexcel, 'Excel5');
				$objWriter->save('php://output');
				exit();
			}else if($act=="bildelivery"){//print_r($_POST);die();
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
					$addsql .= " AND DATE(A.TGL_NOTA) BETWEEN '$tgl_nota_start' AND '$tgl_nota_end' GROUP BY A.ID_REQ order by A.TGL_NOTA ";
				}else if($tgl_nota_start != ""){
					$addsql .= " AND DATE(A.TGL_NOTA) >= '$tgl_nota_start' GROUP BY A.ID_REQ order by A.TGL_NOTA ";
				}else if($tgl_nota_end != ""){
					$addsql .= " AND DATE(A.TGL_NOTA) <= '$tgl_nota_end' GROUP BY A.ID_REQ order by A.TGL_NOTA ";
				}else{
					#$addsql .= " AND MONTH(A.TGL_TIBA) = MONTH(NOW()) AND YEAR(A.TGL_TIBA) = YEAR(NOW())";
				}

				if($tgl_req_start!="" and $tgl_req_end !=""){
					$addsql .= " AND DATE(A.TGL_REQ) BETWEEN '$tgl_req_start' AND '$tgl_req_end' GROUP BY A.ID_REQ order by A.TGL_NOTA ";
				}else if($tgl_req_start != ""){
					$addsql .= " AND DATE(A.TGL_REQ) >= '$tgl_req_start' GROUP BY A.ID_REQ order by A.TGL_NOTA ";
				}else if($tgl_req_end != ""){
					$addsql .= " AND DATE(A.TGL_REQ) <= '$tgl_req_end' GROUP BY A.ID_REQ order by A.TGL_NOTA ";
				}

				if($no_cust != ""){
					$addsql .= " AND C.NAMA_CUST LIKE '%$no_cust%' GROUP by A.ID_REQ order by A.TGL_NOTA";
				}
				$SQL = "SELECT A.ID_REQ, A.TGL_REQ, A.NO_NOTA_DELIVERY, A.TGL_NOTA,'DELIVERY' AS JNS_NOTA, A.SUBTOTAL ,A.PPN ,A.BIAYA_MATERAI ,
						A.TOTAL, C.NAMA_CUST,A.NPWP, B.NO_CONT, B.TGL_BONGKAR, D.NAMA_BANK
						FROM req_delivery_hdr A
						LEFT JOIN (SELECT Z.ID_REQ,
						GROUP_CONCAT(DISTINCT Z.NO_CONT,'[',Z.UKR_CONT,']' SEPARATOR '\r') AS NO_CONT,
						GROUP_CONCAT(DISTINCT X.WK_IN SEPARATOR '\r') AS TGL_BONGKAR
						FROM req_delivery_dtl Z
						INNER JOIN t_cocostscont X ON X.NO_CONT = Z.NO_CONT
						GROUP BY ID_REQ) B ON B.ID_REQ=A.ID_REQ
						INNER JOIN m_pelanggan C ON A.NPWP=C.NPWP
						INNER JOIN m_bank D ON A.BANK_ID = D.BANK_ID
						WHERE 1=1 AND ID_REQ_OLD IS NULL AND A.NO_NOTA_DELIVERY != ''".$addsql; #echo $SQL; die();
				$result = $func->main->get_result($SQL);
				$this->load->library('newphpexcel');
				$this->newphpexcel->getDefaultStyle()->getFont()->setName('Calibri')->setSize(10);
				$this->newphpexcel->setActiveSheetIndex(0);
				$styleArray = array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
				$this->newphpexcel->getDefaultStyle()->applyFromArray($styleArray);
				$this->newphpexcel->set_bold(array('A1'));
				$this->newphpexcel->mergecell(array(array('A1','O1')), FALSE);
				$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A1', 'REPORT BILLING DELIVERY');
				$this->newphpexcel->width(array(array('A',5),array('B',25),array('C',25),array('D',25),array('E',20),array('F',15),array('G',15),array('H',10),array('I',15),array('J',25),array('K',25),array('L',25),array('M',25),array('N',25),array('O',25)));
				$this->newphpexcel->setActiveSheetIndex(0)
					->setCellValue('A3','NO')
					->setCellValue('B3','NO REQUEST')
					->setCellValue('C3','TGL REQUEST')
					->setCellValue('D3','NO NOTA')
					->setCellValue('E3','TGL NOTA')
					->setCellValue('F3','JENIS NOTA')
					->setCellValue('G3','NAMA BANK')
					->setCellValue('H3','TGL BONGKAR')
					->setCellValue('I3','NILAI TAGIHAN')
					->setCellValue('J3','NILAI PPN')
					->setCellValue('K3','NILAI MATERAI')
					->setCellValue('L3','NILAI NOTA')
					->setCellValue('M3','CUSTOMER')
					->setCellValue('N3','NPWP')
					->setCellValue('O3','NOMOR CONTAINER');
				$this->newphpexcel->headings(array('A3','B3','C3','D3','E3','F3','G3','H3','I3','J3','K3','L3','M3','N3','O3'));
				$this->newphpexcel->set_wrap(array('B','C','D','E','F','G','H','I','J','K','L','M','N','O'));
				$no = 1;
				$rec = 4;
				if($result){
					foreach($SQL->result_array() as $row){
						$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A'.$rec,$no)
						->setCellValueExplicit('B'.$rec,$row["ID_REQ"],PHPExcel_Cell_DataType::TYPE_STRING)
						->setCellValueExplicit('C'.$rec,$row["TGL_REQ"],PHPExcel_Cell_DataType::TYPE_STRING)
						->setCellValueExplicit('D'.$rec,$row["NO_NOTA_DELIVERY"],PHPExcel_Cell_DataType::TYPE_STRING)
						->setCellValueExplicit('E'.$rec,$row["TGL_NOTA"],PHPExcel_Cell_DataType::TYPE_STRING)
						->setCellValue('F'.$rec,$row["JNS_NOTA"])
						->setCellValue('G'.$rec,$row["NAMA_BANK"])
						->setCellValueExplicit('H'.$rec,$row["TGL_BONGKAR"],PHPExcel_Cell_DataType::TYPE_STRING)
						->setCellValueExplicit('I'.$rec,$row["SUBTOTAL"],PHPExcel_Cell_DataType::TYPE_STRING)
						->setCellValue('J'.$rec,$row["PPN"])
						->setCellValueExplicit('K'.$rec,$row["BIAYA_MATERAI"],PHPExcel_Cell_DataType::TYPE_STRING)
						->setCellValue('L'.$rec,$row["TOTAL"])
						->setCellValue('M'.$rec,$row["NAMA_CUST"])
						->setCellValue('N'.$rec,$row["NPWP"])
						->setCellValue('O'.$rec,$row["NO_CONT"]);
						$this->newphpexcel->set_detilstyle(array('A'.$rec,'B'.$rec,'C'.$rec,'D'.$rec,'E'.$rec,'F'.$rec,'G'.$rec,'H'.$rec,'I'.$rec,'J'.$rec,'K'.$rec,'L'.$rec,'M'.$rec,'N'.$rec,'O'.$rec));
						$rec++;
						$no++;
					}
				}else{
					$this->newphpexcel->mergecell(array(array('A5','O5')), FALSE);
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
			}else if($act == "bildelivery2"){
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
					$addsql .= " AND DATE(A.TGL_NOTA) BETWEEN '$tgl_nota_start' AND '$tgl_nota_end' GROUP BY A.ID_REQ order by A.TGL_NOTA";
				}else if($tgl_nota_start != ""){
					$addsql .= " AND DATE(A.TGL_NOTA) >= '$tgl_nota_start' GROUP BY A.ID_REQ order by A.TGL_NOTA";
				}else if($tgl_nota_end != ""){
					$addsql .= " AND DATE(A.TGL_NOTA) <= '$tgl_nota_end' GROUP BY A.ID_REQ order by A.TGL_NOTA";
				}else{
					#$addsql .= " AND MONTH(A.TGL_TIBA) = MONTH(NOW()) AND YEAR(A.TGL_TIBA) = YEAR(NOW())";
				}

				if($tgl_req_start!="" and $tgl_req_end !=""){
					$addsql .= " AND DATE(A.TGL_REQ) BETWEEN '$tgl_req_start' AND '$tgl_req_end' GROUP BY A.ID_REQ order by A.TGL_NOTA";
				}else if($tgl_req_start != ""){
					$addsql .= " AND DATE(A.TGL_REQ) >= '$tgl_req_start' GROUP BY A.ID_REQ order by A.TGL_NOTA";
				}else if($tgl_req_end != ""){
					$addsql .= " AND DATE(A.TGL_REQ) <= '$tgl_req_end' GROUP BY A.ID_REQ order by A.TGL_NOTA";
				}

				if($no_cust != ""){
					$addsql .= " AND C.NAMA_CUST LIKE '%$no_cust%' GROUP A.ID_REQ order by A.TGL_NOTA";
				}
				$SQL = "SELECT A.ID_REQ, A.TGL_REQ, A.NO_NOTA_DELIVERY, A.TGL_NOTA,'DELIVERY' AS JNS_NOTA, A.SUBTOTAL ,A.PPN ,A.BIAYA_MATERAI ,
						A.TOTAL, C.NAMA_CUST,A.NPWP, B.NO_CONT, B.TGL_BONGKAR, D.NAMA_BANK
						FROM req_delivery_hdr A
						LEFT JOIN (SELECT Z.ID_REQ,
						GROUP_CONCAT(DISTINCT Z.NO_CONT,'[',Z.UKR_CONT,']' SEPARATOR '\r') AS NO_CONT,
						GROUP_CONCAT(DISTINCT X.WK_IN SEPARATOR '\r') AS TGL_BONGKAR
						FROM req_delivery_dtl Z
						INNER JOIN t_cocostscont X ON X.NO_CONT = Z.NO_CONT
						GROUP BY ID_REQ) B ON B.ID_REQ=A.ID_REQ
						INNER JOIN m_pelanggan C ON A.NPWP=C.NPWP
						INNER JOIN m_bank D ON A.BANK_ID = D.BANK_ID
						WHERE 1=1 AND ID_REQ_OLD IS NULL AND A.NO_NOTA_DELIVERY = ''".$addsql; #echo $SQL; die();
				$result = $func->main->get_result($SQL);
				$this->load->library('newphpexcel');
				$this->newphpexcel->getDefaultStyle()->getFont()->setName('Calibri')->setSize(10);
				$this->newphpexcel->setActiveSheetIndex(0);
				$styleArray = array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
				$this->newphpexcel->getDefaultStyle()->applyFromArray($styleArray);
				$this->newphpexcel->set_bold(array('A1'));
				$this->newphpexcel->mergecell(array(array('A1','O1')), FALSE);
				$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A1', 'REPORT BILLING DELIVERY');
				$this->newphpexcel->width(array(array('A',5),array('B',25),array('C',25),array('D',25),array('E',20),array('F',15),array('G',15),array('H',10),array('I',15),array('J',25),array('K',25),array('L',25),array('M',25),array('N',25),array('O',25)));
				$this->newphpexcel->setActiveSheetIndex(0)
					->setCellValue('A3','NO')
					->setCellValue('B3','NO REQUEST')
					->setCellValue('C3','TGL REQUEST')
					->setCellValue('D3','NO NOTA')
					->setCellValue('E3','TGL NOTA')
					->setCellValue('F3','JENIS NOTA')
					->setCellValue('G3','NAMA BANK')
					->setCellValue('H3','TGL BONGKAR')
					->setCellValue('I3','NILAI TAGIHAN')
					->setCellValue('J3','NILAI PPN')
					->setCellValue('K3','NILAI MATERAI')
					->setCellValue('L3','NILAI NOTA')
					->setCellValue('M3','CUSTOMER')
					->setCellValue('N3','NPWP')
					->setCellValue('O3','NOMOR CONTAINER');
				$this->newphpexcel->headings(array('A3','B3','C3','D3','E3','F3','G3','H3','I3','J3','K3','L3','M3','N3','O3'));
				$this->newphpexcel->set_wrap(array('B','C','D','E','F','G','H','I','J','K','L','M','N','O'));
				$no = 1;
				$rec = 4;
				if($result){
					foreach($SQL->result_array() as $row){
						$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A'.$rec,$no)
						->setCellValueExplicit('B'.$rec,$row["ID_REQ"],PHPExcel_Cell_DataType::TYPE_STRING)
						->setCellValueExplicit('C'.$rec,$row["TGL_REQ"],PHPExcel_Cell_DataType::TYPE_STRING)
						->setCellValueExplicit('D'.$rec,$row["NO_NOTA_DELIVERY"],PHPExcel_Cell_DataType::TYPE_STRING)
						->setCellValueExplicit('E'.$rec,$row["TGL_NOTA"],PHPExcel_Cell_DataType::TYPE_STRING)
						->setCellValue('F'.$rec,$row["JNS_NOTA"])
						->setCellValue('G'.$rec,$row["NAMA_BANK"])
						->setCellValueExplicit('H'.$rec,$row["TGL_BONGKAR"],PHPExcel_Cell_DataType::TYPE_STRING)
						->setCellValueExplicit('I'.$rec,$row["SUBTOTAL"],PHPExcel_Cell_DataType::TYPE_STRING)
						->setCellValue('J'.$rec,$row["PPN"])
						->setCellValueExplicit('K'.$rec,$row["BIAYA_MATERAI"],PHPExcel_Cell_DataType::TYPE_STRING)
						->setCellValue('L'.$rec,$row["TOTAL"])
						->setCellValue('M'.$rec,$row["NAMA_CUST"])
						->setCellValue('N'.$rec,$row["NPWP"])
						->setCellValue('O'.$rec,$row["NO_CONT"]);
						$this->newphpexcel->set_detilstyle(array('A'.$rec,'B'.$rec,'C'.$rec,'D'.$rec,'E'.$rec,'F'.$rec,'G'.$rec,'H'.$rec,'I'.$rec,'J'.$rec,'K'.$rec,'L'.$rec,'M'.$rec,'N'.$rec,'O'.$rec));
						$rec++;
						$no++;
					}
				}else{
					$this->newphpexcel->mergecell(array(array('A5','O5')), FALSE);
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
			}else if($act == "pergerakan"){
				$no_spk = $this->input->post('form[0]');
				$no_dok = $this->input->post('form[1]');
				$npwp = $this->input->post('form[2]');
				$tgl_nota_start = $tgl_nota[0];
				$tgl_nota_end = $tgl_nota[1];
				$tgl_req_start = $tgl_req[0];
				$tgl_req_end = $tgl_req[1];
				//$no_cust = $no_cust[0];
				//print_r($no_SPK); die();
				$addsql = "";
				/*if($id=="impor"){
					$addsql .= " AND A.KD_ASAL_BRG IN('1','2')";
				}else if($id=="ekspor"){
					$addsql .= " AND A.KD_ASAL_BRG IN('3','4')";
				}*/

				if($tgl_nota_start!="" and $tgl_nota_end !=""){
					$addsql .= " AND DATE(A.TGL_NOTA) BETWEEN '$tgl_nota_start' AND '$tgl_nota_end'";
				}else if($tgl_nota_start != ""){
					$addsql .= " AND DATE(A.TGL_NOTA) >= '$tgl_nota_start'";
				}else if($tgl_nota_end != ""){
					$addsql .= " AND DATE(A.TGL_NOTA) <= '$tgl_nota_end'";
				}else{
					#$addsql .= " AND MONTH(A.TGL_TIBA) = MONTH(NOW()) AND YEAR(A.TGL_TIBA) = YEAR(NOW())";
				}

				if($tgl_req_start!="" and $tgl_req_end !=""){
					$addsql .= " AND DATE(A.TGL_REQ) BETWEEN '$tgl_req_start' AND '$tgl_req_end'";
				}else if($tgl_req_start != ""){
					$addsql .= " AND DATE(A.TGL_REQ) >= '$tgl_req_start'";
				}else if($tgl_req_end != ""){
					$addsql .= " AND DATE(A.TGL_REQ) <= '$tgl_req_end'";
				}

				if($no_spk == ""){
					$addsql .= " ORDER BY NO_SPK, NO_CONT  ";
				}else{
					$addsql .= " ORDER BY NO_SPK, NO_CONT  ";
				}
				
				$SQL = "SELECT A.NO_SPK,C.NAMA, A.NO_DOK,A.TGL_DOK,A.NM_KAPAL,A.NO_VOY,A.NPWP,A.CONSIGNEE,B.NO_CONT,B.UKR_CONT,
						A.WK_REQ,D.WK_PICKUP, D.WK_IN, D.WK_START, D.WK_FINISH, D.WK_TRUCKIN, D.WK_CHASSIS, D.WK_GATEOUT
						FROM t_spk A
						INNER JOIN t_spk_cont B ON A.ID = B.ID
						LEFT JOIN reff_kode_dok_bc C ON C.ID = A.JNS_DOK
						LEFT JOIN t_operation D ON A.NO_SPK = D.NO_SPK AND B.NO_CONT = D.NO_CONT WHERE 1=1 ".$addsql; //echo $SQL; die();
				$result = $func->main->get_result($SQL);
				$this->load->library('newphpexcel');
				$this->newphpexcel->getDefaultStyle()->getFont()->setName('Calibri')->setSize(10);
				$this->newphpexcel->setActiveSheetIndex(0);
				$styleArray = array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
				$this->newphpexcel->getDefaultStyle()->applyFromArray($styleArray);
				$this->newphpexcel->set_bold(array('A1'));
				$this->newphpexcel->mergecell(array(array('A1','S1')), FALSE);
				$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A1', 'REPORT PERGERAKAN');
				$this->newphpexcel->width(array(array('A',5),array('B',15),array('C',15),array('D',25),array('E',20),array('F',25),array('G',15),array('H',20),array('I',25),array('J',20),array('K',10),array('L',25),array('M',25),array('N',25),array('O',25),array('P',25),array('Q',25),array('R',25),array('S',25)));
				$this->newphpexcel->setActiveSheetIndex(0)
					->setCellValue('A3','NO')
					->setCellValue('B3','NO SPK')
					->setCellValue('C3','JENIS DOKUMEN')
					->setCellValue('D3','NO DOKUMEN')
					->setCellValue('E3','TANGGAL DOKUMEN')
					->setCellValue('F3','NAMA KAPAL')
					->setCellValue('G3','NO VOYAGE')
					->setCellValue('H3','NPWP')
					->setCellValue('I3','CONSIGNEE')
					->setCellValue('J3','NO KONTAINER')
					->setCellValue('K3','UKURAN KONTAINER')
					->setCellValue('L3','CREATE SPK')
					->setCellValue('M3','PICKUP')
					->setCellValue('N3','BEHANDLE IN')
					->setCellValue('O3','START PEMERIKSAAN')
					->setCellValue('P3','FINISH PEMERIKSAAN')
					->setCellValue('Q3','TRUCK IN')
					->setCellValue('R3','ON CHASSIS')
					->setCellValue('S3','DELIVERY');
				$this->newphpexcel->headings(array('A3','B3','C3','D3','E3','F3','G3','H3','I3','J3','K3','L3','M3','N3','O3','P3','Q3','R3','S3'));
				$this->newphpexcel->set_wrap(array('B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S'));
				$no = 1;
				$rec = 4;
				if($result){
					foreach($SQL->result_array() as $row){
						$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A'.$rec,$no)
						->setCellValue('B'.$rec,$row["NO_SPK"])
						->setCellValue('C'.$rec,$row["NAMA"])
						->setCellValue('D'.$rec,$row["NO_DOK"])
						->setCellValueExplicit('E'.$rec,$row["TGL_DOK"],PHPExcel_Cell_DataType::TYPE_STRING)
						->setCellValue('F'.$rec,$row["NM_KAPAL"])
						->setCellValue('G'.$rec,$row["NO_VOY"])
						->setCellValueExplicit('H'.$rec,$row["NPWP"],PHPExcel_Cell_DataType::TYPE_STRING)
						->setCellValue('I'.$rec,$row["CONSIGNEE"])
						->setCellValue('J'.$rec,$row["NO_CONT"])
						->setCellValueExplicit('K'.$rec,$row["UKR_CONT"],PHPExcel_Cell_DataType::TYPE_STRING)
						->setCellValueExplicit('L'.$rec,$row["WK_REQ"],PHPExcel_Cell_DataType::TYPE_STRING)
						->setCellValueExplicit('M'.$rec,$row["WK_PICKUP"],PHPExcel_Cell_DataType::TYPE_STRING)
						->setCellValueExplicit('N'.$rec,$row["WK_IN"],PHPExcel_Cell_DataType::TYPE_STRING)
						->setCellValueExplicit('O'.$rec,$row["WK_START"],PHPExcel_Cell_DataType::TYPE_STRING)
						->setCellValueExplicit('P'.$rec,$row["WK_FINISH"],PHPExcel_Cell_DataType::TYPE_STRING)
						->setCellValueExplicit('Q'.$rec,$row["WK_TRUCKIN"],PHPExcel_Cell_DataType::TYPE_STRING)
						->setCellValueExplicit('R'.$rec,$row["WK_CHASSIS"],PHPExcel_Cell_DataType::TYPE_STRING)
						->setCellValueExplicit('S'.$rec,$row["WK_GATEOUT"],PHPExcel_Cell_DataType::TYPE_STRING);
						$this->newphpexcel->set_detilstyle(array('A'.$rec,'B'.$rec,'C'.$rec,'D'.$rec,'E'.$rec,'F'.$rec,'G'.$rec,'H'.$rec,'I'.$rec,'J'.$rec,'K'.$rec,'L'.$rec,'M'.$rec,'N'.$rec,'O'.$rec,'P'.$rec,'Q'.$rec,'R'.$rec,'S'.$rec));
						$rec++;
						$no++;
					}
				}else{
					$this->newphpexcel->getActiveSheet()->mergeCells('A4:L4');
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A5','DATA TIDAK DITEMUKAN');
					$this->newphpexcel->set_detilstyle(array('A5'));
				}
				ob_clean();

				$file = "PERGERAKAN_" . date("Ymd") . ".xls";
				header("Content-type: application/x-msdownload");
				header("Content-Disposition: attachment;filename=$file");
				header("Cache-Control: max-age=0");
				header("Pragma: no-cache");
				header("Expires: 0");
				$objWriter = PHPExcel_IOFactory::createWriter($this->newphpexcel, 'Excel5');
				$objWriter->save('php://output');
				exit();
			}else if($act=="bilextention"){//print_r($_POST);die();
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
					$addsql .= " AND DATE(A.TGL_NOTA) BETWEEN '$tgl_nota_start' AND '$tgl_nota_end' GROUP BY A.ID_REQ ORDER BY A.TGL_NOTA";
				}else if($tgl_nota_start != ""){
					$addsql .= " AND DATE(A.TGL_NOTA) >= '$tgl_nota_start' GROUP BY A.ID_REQ ORDER BY A.TGL_NOTA";
				}else if($tgl_nota_end != ""){
					$addsql .= " AND DATE(A.TGL_NOTA) <= '$tgl_nota_end' GROUP BY A.ID_REQ ORDER BY A.TGL_NOTA";
				}else{
					#$addsql .= " AND MONTH(A.TGL_TIBA) = MONTH(NOW()) AND YEAR(A.TGL_TIBA) = YEAR(NOW())";
				}

				if($tgl_req_start!="" and $tgl_req_end !=""){
					$addsql .= " AND DATE(A.TGL_REQ) BETWEEN '$tgl_req_start' AND '$tgl_req_end' GROUP BY A.ID_REQ ORDER BY A.TGL_NOTA";
				}else if($tgl_req_start != ""){
					$addsql .= " AND DATE(A.TGL_REQ) >= '$tgl_req_start' GROUP BY A.ID_REQ ORDER BY A.TGL_NOTA";
				}else if($tgl_req_end != ""){
					$addsql .= " AND DATE(A.TGL_REQ) <= '$tgl_req_end' GROUP BY A.ID_REQ ORDER BY A.TGL_NOTA";
				}

				if($no_cust != ""){
					$addsql .= " AND B.NAMA_CUST LIKE '%$no_cust%' GROUP BY A.ID_REQ ORDER BY A.TGL_NOTA";
				}
				$SQL = "SELECT A.ID_REQ, A.TGL_REQ, A.NO_NOTA_DELIVERY, A.TGL_NOTA,'DELIVERY EXT' AS JNS_NOTA, A.SUBTOTAL ,A.PPN ,A.BIAYA_MATERAI ,
						A.TOTAL, C.NAMA_CUST,A.NPWP, B.NO_CONT, A.TGL_STACK AS 'TGL_BONGKAR', D.NAMA_BANK
						FROM req_delivery_hdr A
						LEFT JOIN (SELECT ID_REQ, GROUP_CONCAT(DISTINCT NO_CONT,'[',UKR_CONT,']' SEPARATOR '\r') AS NO_CONT
						FROM req_delivery_dtl GROUP BY ID_REQ) B ON B.ID_REQ=A.ID_REQ
						INNER JOIN m_pelanggan C ON A.NPWP=C.NPWP
						INNER JOIN m_bank D ON A.BANK_ID = D.BANK_ID
						WHERE 1=1 AND ID_REQ_OLD IS NOT NULL AND A.NO_NOTA_DELIVERY != ''".$addsql; #echo $SQL; die();
				$result = $func->main->get_result($SQL);
				$this->load->library('newphpexcel');
				$this->newphpexcel->getDefaultStyle()->getFont()->setName('Calibri')->setSize(10);
				$this->newphpexcel->setActiveSheetIndex(0);
				$styleArray = array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
				$this->newphpexcel->getDefaultStyle()->applyFromArray($styleArray);
				$this->newphpexcel->set_bold(array('A1'));
				$this->newphpexcel->mergecell(array(array('A1','O1')), FALSE);
				$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A1', 'REPORT BILLING EXTENTION');
				$this->newphpexcel->width(array(array('A',5),array('B',25),array('C',25),array('D',25),array('E',20),array('F',15),array('G',15),array('H',10),array('I',15),array('J',25),array('K',25),array('L',25),array('M',25),array('N',25),array('O',25)));
				$this->newphpexcel->setActiveSheetIndex(0)
					->setCellValue('A3','NO')
					->setCellValue('B3','NO REQUEST')
					->setCellValue('C3','TGL REQUEST')
					->setCellValue('D3','NO NOTA')
					->setCellValue('E3','TGL NOTA')
					->setCellValue('F3','JENIS NOTA')
					->setCellValue('G3','NAMA BANK')
					->setCellValue('H3','TGL BONGKAR')
					->setCellValue('I3','NILAI TAGIHAN')
					->setCellValue('J3','NILAI PPN')
					->setCellValue('K3','NILAI MATERAI')
					->setCellValue('L3','NILAI NOTA')
					->setCellValue('M3','CUSTOMER')
					->setCellValue('N3','NPWP')
					->setCellValue('O3','NOMOR CONTAINER');
				$this->newphpexcel->headings(array('A3','B3','C3','D3','E3','F3','G3','H3','I3','J3','K3','L3','M3','N3','O3'));
				$this->newphpexcel->set_wrap(array('B','C','D','E','F','G','H','I','J','K','L','M','N','O'));
				$no = 1;
				$rec = 4;
				if($result){
					foreach($SQL->result_array() as $row){
						$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A'.$rec,$no)
						->setCellValueExplicit('B'.$rec,$row["ID_REQ"],PHPExcel_Cell_DataType::TYPE_STRING)
						->setCellValueExplicit('C'.$rec,$row["TGL_REQ"],PHPExcel_Cell_DataType::TYPE_STRING)
						->setCellValueExplicit('D'.$rec,$row["NO_NOTA_DELIVERY"],PHPExcel_Cell_DataType::TYPE_STRING)
						->setCellValueExplicit('E'.$rec,$row["TGL_NOTA"],PHPExcel_Cell_DataType::TYPE_STRING)
						->setCellValue('F'.$rec,$row["JNS_NOTA"])
						->setCellValue('G'.$rec,$row["NAMA_BANK"])
						->setCellValueExplicit('H'.$rec,$row["TGL_BONGKAR"],PHPExcel_Cell_DataType::TYPE_STRING)
						->setCellValueExplicit('I'.$rec,$row["SUBTOTAL"],PHPExcel_Cell_DataType::TYPE_STRING)
						->setCellValue('J'.$rec,$row["PPN"])
						->setCellValueExplicit('K'.$rec,$row["BIAYA_MATERAI"],PHPExcel_Cell_DataType::TYPE_STRING)
						->setCellValue('L'.$rec,$row["TOTAL"])
						->setCellValue('M'.$rec,$row["NAMA_CUST"])
						->setCellValue('N'.$rec,$row["NPWP"])
						->setCellValue('O'.$rec,$row["NO_CONT"]);
						$this->newphpexcel->set_detilstyle(array('A'.$rec,'B'.$rec,'C'.$rec,'D'.$rec,'E'.$rec,'F'.$rec,'G'.$rec,'H'.$rec,'I'.$rec,'J'.$rec,'K'.$rec,'L'.$rec,'M'.$rec,'N'.$rec,'O'.$rec));
						$rec++;
						$no++;
					}
				}else{
					$this->newphpexcel->getActiveSheet()->mergeCells('A5:O5');
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A5','DATA TIDAK DITEMUKAN');
					$this->newphpexcel->set_detilstyle(array('A5'));
				}
				ob_clean();

				$file = "EXTENTION_" . date("Ymd") . ".xls";
				header("Content-type: application/x-msdownload");
				header("Content-Disposition: attachment;filename=$file");
				header("Cache-Control: max-age=0");
				header("Pragma: no-cache");
				header("Expires: 0");
				$objWriter = PHPExcel_IOFactory::createWriter($this->newphpexcel, 'Excel5');
				$objWriter->save('php://output');
				exit();
			}else if($act=="bilproduction"){
				$nama = $this->input->post('form[0]');
				$tgl_nota_dlv = $this->input->post('form[1]');
				$tgl_nota_bhd = $this->input->post('form[2]');
				
				$nama_cust = $nama[0];
				$dlv_start = $tgl_nota_dlv[0];
				$dlv_end = $tgl_nota_dlv[1];
				$bhd_start = $tgl_nota_bhd[0];
				$bhd_end = $tgl_nota_bhd[1];
				
				if ($dlv_start != "" and $dlv_end != "") {
					$addsql .= " AND DATE_FORMAT(D.TGL_NOTA,'%Y-%m-%d') BETWEEN '$dlv_start' AND '$dlv_end' ";
				}else if($dlv_start !=""){
					$addsql .= " AND DATE_FORMAT(D.TGL_NOTA,'%Y-%m-%d') >= '$dlv_start' ";
				}else if ($dlv_end !="") {
					$addsql .= " AND DATE_FORMAT(D.TGL_NOTA,'%Y-%m-%d') <= '$dlv_end' ";
				} 

				if ($bhd_start != "" and $bhd_end !="") {
					$addsql .= " AND DATE_FORMAT(D.TGL_REQ,'%Y-%m-%d') BETWEEN '$bhd_start' AND '$bhd_end' ";
				}else if ($bhd_start != "") {
					$addsql .= " AND DATE_FORMAT(D.TGL_REQ,'%Y-%m-%d') >= '$bhd_start' ";
				}else if ($bhd_end != "") {
					$addsql .= " AND DATE_FORMAT(D.TGL_REQ,'%Y-%m-%d') <= '$bhd_end' ";
				}

				if ($nama_cust != "") {
					$addsql .= " ";
				}

				$SQL = "SELECT A.NO_CONT, 'I' AS CLASS, B.CALL_SIGN, B.NM_ANGKUT, B.NO_VOY_FLIGHT, CASE WHEN A.JNS_CONT ='F' THEN 'FULL' ELSE 'EMPTY' END AS STATUS, A.UK_CONT AS SIZE, A.KD_CONT_TIPE AS TYPE, B.TGL_TIBA, A.WK_IN, A.WK_OUT, C.BHD_JNS_DOK, C.BHD_NO_DOK, C.BHD_TGL_DOK, C.BHD_NAMA_CUST, C.BHD_JNS_KEGIATAN, C.BHD_ID_REQ, C.BHD_TGL_REQ, C.NO_NOTA_BEHANDLE, C.BHD_TGL_NOTA, C.BHD_SUB_TOTAL, C.BHD_PPN, C.BHD_BIAYA_MATERAI, C.BHD_TOTAL_JUMLAH, D.TYPE_KEGIATAN, D.TYPE_SPPB, D.NO_DOK, D.TGL_DOK, D.EXPIRED, D.NO_DO, D.NO_BL, D.ID_REQ, D.TGL_REQ, D.NO_NOTA_DELIVERY, D.TGL_NOTA, E.TOTAL_LIFT_ON, E.TOTAL_NPCT, D.SUBTOTAL, D.PPN, D.BIAYA_MATERAI, D.TOTAL, D.NPWP, C.BHD_NAMA_CUST AS NAMA_CUST
					FROM t_cocostscont A
					INNER JOIN t_cocostshdr B ON B.ID = A.ID

					INNER JOIN (
						SELECT B.NO_CONT, A.JNS_DOK AS BHD_JNS_DOK, A.NO_DOK AS BHD_NO_DOK, A.TGL_DOK AS BHD_TGL_DOK, A.NAMA_CUST AS BHD_NAMA_CUST, B.JNS_KEGIATAN AS BHD_JNS_KEGIATAN, A.ID_REQ AS BHD_ID_REQ, A.TGL_REQ AS BHD_TGL_REQ, A.NO_NOTA_BEHANDLE, A.TGL_NOTA AS BHD_TGL_NOTA, (A.SUBTOTAL + A.BIAYA_ADMIN) AS BHD_SUB_TOTAL, A.PPN AS BHD_PPN, A.BIAYA_MATERAI AS BHD_BIAYA_MATERAI, A.TOTAL_JUMLAH AS BHD_TOTAL_JUMLAH
						FROM req_behandle_hdr A
						INNER JOIN (
							SELECT DISTINCT ID_REQ, NO_CONT, CONCAT('BEHANDLE ',JNS_KEGIATAN) AS JNS_KEGIATAN
							FROM req_behandle_dtl 
						)AS B ON B.ID_REQ = A.ID_REQ
					)AS C ON C.NO_CONT = A.NO_CONT

					INNER JOIN (
						SELECT B.NO_CONT, CASE WHEN A.ID_REQ_OLD IS NULL THEN 'DELIVERY' ELSE 'DELIVERY EXT' END AS TYPE_KEGIATAN, 'SPPB PIB 2.0' AS TYPE_SPPB, A.NO_DOK, A.TGL_DOK, A.EXPIRED, A.NO_DO, A.NO_BL, A.ID_REQ, A.TGL_REQ, A.NO_NOTA_DELIVERY, A.TGL_NOTA, A.SUBTOTAL, A.PPN, A.BIAYA_MATERAI, A.TOTAL, A.NPWP, A.NM_KAPAL, A.NO_VOY 
						FROM req_delivery_hdr A
						INNER JOIN (
							SELECT DISTINCT ID_REQ, NO_CONT
							FROM req_delivery_dtl -- GROUP BY NO_CONT
						)AS B ON B.ID_REQ = A.ID_REQ
					) AS D ON D.NO_CONT = A.NO_CONT -- AND D.NM_KAPAL = B.NM_ANGKUT AND D.NO_VOY = B.NO_VOY_FLIGHT

					INNER JOIN (
						SELECT ID_REQ, NO_CONT, LIFT_ON AS TOTAL_LIFT_ON, TOTAL AS TOTAL_NPCT
						FROM req_delivery_production
					) AS E ON E.NO_CONT = A.NO_CONT AND E.ID_REQ = D.ID_REQ
					WHERE 1=1".$addsql;
	/* echo $SQL; die(); */
				$result = $func->main->get_result($SQL);
				$this->load->library('newphpexcel');
				$this->newphpexcel->getDefaultStyle()->getFont()->setName('Calibri')->setSize(10);
				$this->newphpexcel->setActiveSheetIndex(0);
				$styleArray = array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
				$this->newphpexcel->getDefaultStyle()->applyFromArray($styleArray);
				$this->newphpexcel->set_bold(array('A1'));
				$this->newphpexcel->mergecell(array(array('A1','AR1')), FALSE);
				$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A1', 'REPORT BILLING PRODUCTION');
				$this->newphpexcel->width(array(array('A',5),array('B',15),array('C',5),array('D',25),array('E',20),array('F',15),array('G',10),array('H',10),array('I',25),array('J',25),array('K',25),array('L',25),array('M',25),array('N',25),array('O',25),array('P',25),array('Q',25),array('R',25),array('S',25),array('T',25),array('U',25),array('V',25),array('W',25),array('X',25),array('Y',25),array('Z',25),array('AA',25),array('AB',25),array('AC',25),array('AD',25),array('AE',25),array('AF',25),array('AG',25),array('AH',25),array('AI',25),array('AJ',25),array('AK',25),array('AL',25),array('AM',25),array('AN',25),array('AO',25),array('AP',25),array('AQ',25),array('AR',25)));
				$this->newphpexcel->setActiveSheetIndex(0)
					->setCellValue('A3','NO')
					->setCellValue('B3','NO CONTAINER')
					->setCellValue('C3','CLASS')
					->setCellValue('D3','KODE KAPAL')
					->setCellValue('E3','VESSEL NAME')
					->setCellValue('F3','VOYAGE')
					->setCellValue('G3','STATUS')
					->setCellValue('H3','SIZE')
					->setCellValue('I3','TIPE')
					->setCellValue('J3','ARRIVAL')
					->setCellValue('K3','STACKING')
					->setCellValue('L3','TGL GATE OUT')
					->setCellValue('M3','JENIS DOKUMEN')
					->setCellValue('N3','NO DOKUMEN')
					->setCellValue('O3','TGL DOKUMEN')
					->setCellValue('P3','CUSTOMER')
					->setCellValue('Q3','JENIS BEHANDLE')
					->setCellValue('R3','NO REQUEST')
					->setCellValue('S3','TGL REQUEST')
					->setCellValue('T3','NO NOTA BEHANDLE')
					->setCellValue('U3','TGL NOTA')
					->setCellValue('V3','NILAI TAGIHAN')
					->setCellValue('W3','NILAI PPN')
					->setCellValue('X3','NILAI MATERAI')
					->setCellValue('Y3','NILAI NOTA')
					->setCellValue('Z3','TYPE KEGIATAN')
					->setCellValue('AA3','TYPE SPPB')
					->setCellValue('AB3','NO SPPB')
					->setCellValue('AC3','TGL SPPB')
					->setCellValue('AD3','PAID THROUGHT')
					->setCellValue('AE3','NO DO')
					->setCellValue('AF3','NO BL')
					->setCellValue('AG3','NO REQUEST')
					->setCellValue('AH3','TGL REQUEST')
					->setCellValue('AI3','NO NOTA DELIVERY')
					->setCellValue('AJ3','TGL NOTA')
					->setCellValue('AK3','LIFT ON NPCT1')
					->setCellValue('AL3','NILAI NPCT1')
					->setCellValue('AM3','NILAI TAGIHAN')
					->setCellValue('AN3','NILAI PPN')
					->setCellValue('AO3','NILAI MATERAI')
					->setCellValue('AP3','NILAI NOTA')
					->setCellValue('AQ3','NPWP')
					->setCellValue('AR3','CUSTOMER');
				$this->newphpexcel->headings(array('A3','B3','C3','D3','E3','F3','G3','H3','I3','J3','K3','L3','M3','N3','O3','P3','Q3','R3','S3','T3','U3','V3','W3','X3','Y3','Z3','AA3','AB3','AC3','AD3','AE3','AF3','AG3','AH3','AI3','AJ3','AJ3','AK3','AL3','AM3','AN3','AO3','AP3','AQ3','AR3'));
				$this->newphpexcel->set_wrap(array('B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR'));
				$no = 1;
				$rec = 4;
				if($result){
					foreach($SQL->result_array() as $row){
						$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A'.$rec,$no)
						->setCellValueExplicit('B'.$rec,$row["NO_CONT"],PHPExcel_Cell_DataType::TYPE_STRING)
						->setCellValueExplicit('C'.$rec,$row["CLASS"],PHPExcel_Cell_DataType::TYPE_STRING)
						->setCellValueExplicit('D'.$rec,$row["CALL_SIGN"],PHPExcel_Cell_DataType::TYPE_STRING)
						->setCellValueExplicit('E'.$rec,$row["NM_ANGKUT"],PHPExcel_Cell_DataType::TYPE_STRING)
						->setCellValueExplicit('F'.$rec,$row["NO_VOY_FLIGHT"],PHPExcel_Cell_DataType::TYPE_STRING)
						->setCellValueExplicit('G'.$rec,$row["STATUS"],PHPExcel_Cell_DataType::TYPE_STRING)
						->setCellValueExplicit('H'.$rec,$row["SIZE"],PHPExcel_Cell_DataType::TYPE_STRING)
						->setCellValueExplicit('I'.$rec,$row["TYPE"],PHPExcel_Cell_DataType::TYPE_STRING)
						->setCellValueExplicit('J'.$rec,$row["TGL_TIBA"],PHPExcel_Cell_DataType::TYPE_STRING)
						->setCellValueExplicit('K'.$rec,$row["WK_IN"],PHPExcel_Cell_DataType::TYPE_STRING)
						->setCellValueExplicit('L'.$rec,$row["WK_OUT"],PHPExcel_Cell_DataType::TYPE_STRING)
						->setCellValueExplicit('M'.$rec,$row["BHD_JNS_DOK"],PHPExcel_Cell_DataType::TYPE_STRING)
						->setCellValueExplicit('N'.$rec,$row["BHD_NO_DOK"],PHPExcel_Cell_DataType::TYPE_STRING)
						->setCellValueExplicit('O'.$rec,$row["BHD_TGL_DOK"],PHPExcel_Cell_DataType::TYPE_STRING)
						->setCellValueExplicit('P'.$rec,$row["BHD_NAMA_CUST"],PHPExcel_Cell_DataType::TYPE_STRING)
						->setCellValueExplicit('Q'.$rec,$row["BHD_JNS_KEGIATAN"],PHPExcel_Cell_DataType::TYPE_STRING)
						->setCellValueExplicit('R'.$rec,$row["BHD_ID_REQ"],PHPExcel_Cell_DataType::TYPE_STRING)
						->setCellValueExplicit('S'.$rec,$row["BHD_TGL_REQ"],PHPExcel_Cell_DataType::TYPE_STRING)
						->setCellValueExplicit('T'.$rec,$row["NO_NOTA_BEHANDLE"],PHPExcel_Cell_DataType::TYPE_STRING)
						->setCellValueExplicit('U'.$rec,$row["BHD_TGL_NOTA"],PHPExcel_Cell_DataType::TYPE_STRING)
						->setCellValueExplicit('V'.$rec,$row["BHD_SUB_TOTAL"],PHPExcel_Cell_DataType::TYPE_STRING)
						->setCellValueExplicit('W'.$rec,$row["BHD_PPN"],PHPExcel_Cell_DataType::TYPE_STRING)
						->setCellValueExplicit('X'.$rec,$row["BHD_BIAYA_MATERAI"],PHPExcel_Cell_DataType::TYPE_STRING)
						->setCellValueExplicit('Y'.$rec,$row["BHD_TOTAL_JUMLAH"],PHPExcel_Cell_DataType::TYPE_STRING)
						->setCellValueExplicit('Z'.$rec,$row["TYPE_KEGIATAN"],PHPExcel_Cell_DataType::TYPE_STRING)
						->setCellValueExplicit('AA'.$rec,$row["TYPE_SPPB"],PHPExcel_Cell_DataType::TYPE_STRING)
						->setCellValueExplicit('AB'.$rec,$row["NO_DOK"],PHPExcel_Cell_DataType::TYPE_STRING)
						->setCellValueExplicit('AC'.$rec,$row["TGL_DOK"],PHPExcel_Cell_DataType::TYPE_STRING)
						->setCellValueExplicit('AD'.$rec,$row["EXPIRED"],PHPExcel_Cell_DataType::TYPE_STRING)
						->setCellValueExplicit('AE'.$rec,$row["NO_DO"],PHPExcel_Cell_DataType::TYPE_STRING)
						->setCellValueExplicit('AF'.$rec,$row["NO_BL"],PHPExcel_Cell_DataType::TYPE_STRING)
						->setCellValueExplicit('AG'.$rec,$row["ID_REQ"],PHPExcel_Cell_DataType::TYPE_STRING)
						->setCellValueExplicit('AH'.$rec,$row["TGL_REQ"],PHPExcel_Cell_DataType::TYPE_STRING)
						->setCellValueExplicit('AI'.$rec,$row["NO_NOTA_DELIVERY"],PHPExcel_Cell_DataType::TYPE_STRING)
						->setCellValueExplicit('AJ'.$rec,$row["TGL_NOTA"],PHPExcel_Cell_DataType::TYPE_STRING)
						->setCellValueExplicit('AK'.$rec,$row["TOTAL_LIFT_ON"],PHPExcel_Cell_DataType::TYPE_STRING)
						->setCellValueExplicit('AL'.$rec,$row["TOTAL_NPCT"],PHPExcel_Cell_DataType::TYPE_STRING)
						->setCellValueExplicit('AM'.$rec,$row["SUBTOTAL"],PHPExcel_Cell_DataType::TYPE_STRING)
						->setCellValueExplicit('AN'.$rec,$row["PPN"],PHPExcel_Cell_DataType::TYPE_STRING)
						->setCellValueExplicit('AO'.$rec,$row["BIAYA_MATERAI"],PHPExcel_Cell_DataType::TYPE_STRING)
						->setCellValueExplicit('AP'.$rec,$row["TOTAL"],PHPExcel_Cell_DataType::TYPE_STRING)
						->setCellValueExplicit('AQ'.$rec,$row["NPWP"],PHPExcel_Cell_DataType::TYPE_STRING)
						->setCellValueExplicit('AR'.$rec,$row["NAMA_CUST"],PHPExcel_Cell_DataType::TYPE_STRING);
						
						$this->newphpexcel->set_detilstyle(array('A'.$rec,'B'.$rec,'C'.$rec,'D'.$rec,'E'.$rec,'F'.$rec,'G'.$rec,'H'.$rec,'I'.$rec,'J'.$rec,'K'.$rec,'L'.$rec,'M'.$rec,'N'.$rec,'O'.$rec,'P'.$rec,'A'.$rec,'R'.$rec,'S'.$rec,'T'.$rec,'U'.$rec,'V'.$rec,'W'.$rec,'X'.$rec,'Y'.$rec,'Z'.$rec,'AA'.$rec,'AB'.$rec,'AC'.$rec,'AD'.$rec,'AE'.$rec,'AF'.$rec,'AG'.$rec,'AH'.$rec,'AI'.$rec,'AJ'.$rec,'AK'.$rec,'AL'.$rec,'AM'.$rec,'AN'.$rec,'AO'.$rec,'AP'.$rec,'AQ'.$rec,'AR'.$rec));
						$rec++;
						$no++;
					}
				}else{
					$this->newphpexcel->getActiveSheet()->mergeCells('A5:AR5');
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A5','DATA TIDAK DITEMUKAN');
					$this->newphpexcel->set_detilstyle(array('A5'));
				}
				ob_clean();

				$file = "PRODUCTION_" . date("Ymd") . ".xls";
				header("Content-type: application/x-msdownload");
				header("Content-Disposition: attachment;filename=$file");
				header("Cache-Control: max-age=0");
				header("Pragma: no-cache");
				header("Expires: 0");
				$objWriter = PHPExcel_IOFactory::createWriter($this->newphpexcel, 'Excel5');
				$objWriter->save('php://output');
				exit();
			}else if($act == "stacking"){
				$status = $this->input->post('form[0]');
				$tgl_nota = $this->input->post('form[1]');
				$tgl_start = $tgl_nota[0];
				$tgl_end = $tgl_nota[1];
				$status_kontainer = $status[0];
				$addsql = "";

				
				//print_r($tgl_nota); die();
				
				if($status_kontainer != NULL || $status_kontainer != ""){
					$addsql .= " AND A.STATUS_CONT = '$status_kontainer'";
				}else if($status_kontainer){
					$addsql .= " ";
				}else{
					$addsql .= " ";
				}
				//sal
				$SQL = "SELECT B.NO_SPK AS 'NO SPK', A.NO_CONT AS 'NO CONTAINER',A.UKR_CONT AS 'SIZE',B.WK_REQ AS 'TERBIT SPK',C.NAMA AS 'JENIS DOKUMEN', 
				A.ID_FLAT AS 'TID',B.CONSIGNEE AS 'CUSTOMER NAME', CONCAT((A.LOKASI),'0',(A.TIER)) AS 'LOKASI', A.STATUS_CONT_COARI AS 'COARI',
				CASE WHEN A.STATUS_CONT = '450' THEN 'STACKING YARD' WHEN A.STATUS_CONT = '460' THEN 'STACKING CIC' ELSE 0 END AS 'STATUS'
				FROM t_spk_cont A
				INNER JOIN t_spk B ON A.id = B.id
				INNER JOIN reff_kode_dok_bc C ON C.ID = B.JNS_DOK
				WHERE A.STATUS_CONT IN ('450','460')".$addsql; //echo $SQL; die();
					
					$result = $func->main->get_result($SQL);
				$this->load->library('newphpexcel');
				$this->newphpexcel->getDefaultStyle()->getFont()->setName('Calibri')->setSize(10);
				$this->newphpexcel->setActiveSheetIndex(0);
				$styleArray = array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
				$this->newphpexcel->getDefaultStyle()->applyFromArray($styleArray);
				$this->newphpexcel->set_bold(array('A1'));
				$this->newphpexcel->mergecell(array(array('A1','K1')), FALSE);
				$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A1', 'REPORT STACKING');
				$this->newphpexcel->width(array(array('A',5),array('B',18),array('C',18),array('D',8),array('E',20),array('F',15),array('G',15),array('H',35),array('I',13),array('J',8),array('K',20)));
				$this->newphpexcel->setActiveSheetIndex(0)
					->setCellValue('A3','NO')
					->setCellValue('B3','NO SPK')
					->setCellValue('C3','NO KONTAINER')
					->setCellValue('D3','SIZE')
					->setCellValue('E3','TERBIT SPK')
					->setCellValue('F3','JENIS DOKUMEN')
					->setCellValue('G3','TID')
					->setCellValue('H3','NAMA CUSTOMER')
					->setCellValue('I3','LOKASI')
					->setCellValue('J3','STATUS')
					->setCellValue('K3','STATUS KONTAINER');
				$this->newphpexcel->headings(array('A3','B3','C3','D3','E3','F3','G3','H3','I3','J3','K3'));
				$this->newphpexcel->set_wrap(array('B','C','D','E','F','G','H','I','J','K'));
				$no = 1;
				$rec = 4;
				if($result){
					foreach($SQL->result_array() as $row){
						$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A'.$rec,$no)
						->setCellValueExplicit('B'.$rec,$row["NO SPK"],PHPExcel_Cell_DataType::TYPE_STRING)
						->setCellValueExplicit('C'.$rec,$row["NO CONTAINER"],PHPExcel_Cell_DataType::TYPE_STRING)
						->setCellValueExplicit('D'.$rec,$row["SIZE"],PHPExcel_Cell_DataType::TYPE_STRING)
						->setCellValue('E'.$rec,$row["TERBIT SPK"])
						->setCellValueExplicit('F'.$rec,$row["JENIS DOKUMEN"],PHPExcel_Cell_DataType::TYPE_STRING)
						->setCellValue('G'.$rec,$row["TID"])
						->setCellValueExplicit('H'.$rec,$row["CUSTOMER NAME"],PHPExcel_Cell_DataType::TYPE_STRING)
						->setCellValue('I'.$rec,$row["LOKASI"])
						->setCellValue('J'.$rec,$row["COARI"])
						->setCellValue('K'.$rec,$row["STATUS"]);
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

				$file = "STACKING_" . date("Ymd") . ".xls";
				header("Content-type: application/x-msdownload");
				header("Content-Disposition: attachment;filename=$file");
				header("Cache-Control: max-age=0");
				header("Pragma: no-cache");
				header("Expires: 0");
				$objWriter = PHPExcel_IOFactory::createWriter($this->newphpexcel, 'Excel5');
				$objWriter->save('php://output');
				exit();
			}else if($act == "bilextention2"){
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
					$addsql .= " AND DATE(A.TGL_NOTA) BETWEEN '$tgl_nota_start' AND '$tgl_nota_end' GROUP BY A.ID_REQ ORDER BY A.TGL_NOTA";
				}else if($tgl_nota_start != ""){
					$addsql .= " AND DATE(A.TGL_NOTA) >= '$tgl_nota_start' GROUP BY A.ID_REQ ORDER BY A.TGL_NOTA";
				}else if($tgl_nota_end != ""){
					$addsql .= " AND DATE(A.TGL_NOTA) <= '$tgl_nota_end' GROUP BY A.ID_REQ ORDER BY A.TGL_NOTA";
				}else{
					#$addsql .= " AND MONTH(A.TGL_TIBA) = MONTH(NOW()) AND YEAR(A.TGL_TIBA) = YEAR(NOW())";
				}

				if($tgl_req_start!="" and $tgl_req_end !=""){
					$addsql .= " AND DATE(A.TGL_REQ) BETWEEN '$tgl_req_start' AND '$tgl_req_end' GROUP BY A.ID_REQ ORDER BY A.TGL_NOTA";
				}else if($tgl_req_start != ""){
					$addsql .= " AND DATE(A.TGL_REQ) >= '$tgl_req_start' GROUP BY A.ID_REQ ORDER BY A.TGL_NOTA";
				}else if($tgl_req_end != ""){
					$addsql .= " AND DATE(A.TGL_REQ) <= '$tgl_req_end' GROUP BY A.ID_REQ ORDER BY A.TGL_NOTA";
				}

				if($no_cust != ""){
					$addsql .= " AND B.NAMA_CUST LIKE '%$no_cust%' GROUP BY A.ID_REQ ORDER BY A.TGL_NOTA";
				}
				$SQL = "SELECT A.ID_REQ, A.TGL_REQ, A.NO_NOTA_DELIVERY, A.TGL_NOTA,'DELIVERY EXT' AS JNS_NOTA, A.SUBTOTAL ,A.PPN ,A.BIAYA_MATERAI ,
						A.TOTAL, C.NAMA_CUST,A.NPWP, B.NO_CONT, A.TGL_STACK AS 'TGL_BONGKAR', D.NAMA_BANK
						FROM req_delivery_hdr A
						LEFT JOIN (SELECT ID_REQ, GROUP_CONCAT(DISTINCT NO_CONT,'[',UKR_CONT,']' SEPARATOR '\r') AS NO_CONT
						FROM req_delivery_dtl GROUP BY ID_REQ) B ON B.ID_REQ=A.ID_REQ
						INNER JOIN m_pelanggan C ON A.NPWP=C.NPWP
						INNER JOIN m_bank D ON A.BANK_ID = D.BANK_ID
						WHERE 1=1 AND ID_REQ_OLD IS NOT NULL AND A.NO_NOTA_DELIVERY = ''".$addsql; #echo $SQL; die();
				$result = $func->main->get_result($SQL);
				$this->load->library('newphpexcel');
				$this->newphpexcel->getDefaultStyle()->getFont()->setName('Calibri')->setSize(10);
				$this->newphpexcel->setActiveSheetIndex(0);
				$styleArray = array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
				$this->newphpexcel->getDefaultStyle()->applyFromArray($styleArray);
				$this->newphpexcel->set_bold(array('A1'));
				$this->newphpexcel->mergecell(array(array('A1','O1')), FALSE);
				$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A1', 'REPORT BILLING EXTENTION');
				$this->newphpexcel->width(array(array('A',5),array('B',25),array('C',25),array('D',25),array('E',20),array('F',15),array('G',15),array('H',10),array('I',15),array('J',25),array('K',25),array('L',25),array('M',25),array('N',25),array('O',25)));
				$this->newphpexcel->setActiveSheetIndex(0)
					->setCellValue('A3','NO')
					->setCellValue('B3','NO REQUEST')
					->setCellValue('C3','TGL REQUEST')
					->setCellValue('D3','NO NOTA')
					->setCellValue('E3','TGL NOTA')
					->setCellValue('F3','JENIS NOTA')
					->setCellValue('G3','NAMA BANK')
					->setCellValue('H3','TGL BONGKAR')
					->setCellValue('I3','NILAI TAGIHAN')
					->setCellValue('J3','NILAI PPN')
					->setCellValue('K3','NILAI MATERAI')
					->setCellValue('L3','NILAI NOTA')
					->setCellValue('M3','CUSTOMER')
					->setCellValue('N3','NPWP')
					->setCellValue('O3','NOMOR CONTAINER');
				$this->newphpexcel->headings(array('A3','B3','C3','D3','E3','F3','G3','H3','I3','J3','K3','L3','M3','N3','O3'));
				$this->newphpexcel->set_wrap(array('B','C','D','E','F','G','H','I','J','K','L','M','N','O'));
				$no = 1;
				$rec = 4;
				if($result){
					foreach($SQL->result_array() as $row){
						$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A'.$rec,$no)
						->setCellValueExplicit('B'.$rec,$row["ID_REQ"],PHPExcel_Cell_DataType::TYPE_STRING)
						->setCellValueExplicit('C'.$rec,$row["TGL_REQ"],PHPExcel_Cell_DataType::TYPE_STRING)
						->setCellValueExplicit('D'.$rec,$row["NO_NOTA_DELIVERY"],PHPExcel_Cell_DataType::TYPE_STRING)
						->setCellValueExplicit('E'.$rec,$row["TGL_NOTA"],PHPExcel_Cell_DataType::TYPE_STRING)
						->setCellValue('F'.$rec,$row["JNS_NOTA"])
						->setCellValue('G'.$rec,$row["NAMA_BANK"])
						->setCellValueExplicit('H'.$rec,$row["TGL_BONGKAR"],PHPExcel_Cell_DataType::TYPE_STRING)
						->setCellValueExplicit('I'.$rec,$row["SUBTOTAL"],PHPExcel_Cell_DataType::TYPE_STRING)
						->setCellValue('J'.$rec,$row["PPN"])
						->setCellValueExplicit('K'.$rec,$row["BIAYA_MATERAI"],PHPExcel_Cell_DataType::TYPE_STRING)
						->setCellValue('L'.$rec,$row["TOTAL"])
						->setCellValue('M'.$rec,$row["NAMA_CUST"])
						->setCellValue('N'.$rec,$row["NPWP"])
						->setCellValue('O'.$rec,$row["NO_CONT"]);
						$this->newphpexcel->set_detilstyle(array('A'.$rec,'B'.$rec,'C'.$rec,'D'.$rec,'E'.$rec,'F'.$rec,'G'.$rec,'H'.$rec,'I'.$rec,'J'.$rec,'K'.$rec,'L'.$rec,'M'.$rec,'N'.$rec,'O'.$rec));
						$rec++;
						$no++;
					}
				}else{
					$this->newphpexcel->getActiveSheet()->mergeCells('A5:O5');
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A5','DATA TIDAK DITEMUKAN');
					$this->newphpexcel->set_detilstyle(array('A5'));
				}
				ob_clean();

				$file = "EXTENTION_" . date("Ymd") . ".xls";
				header("Content-type: application/x-msdownload");
				header("Content-Disposition: attachment;filename=$file");
				header("Cache-Control: max-age=0");
				header("Pragma: no-cache");
				header("Expires: 0");
				$objWriter = PHPExcel_IOFactory::createWriter($this->newphpexcel, 'Excel5');
				$objWriter->save('php://output');
				exit();
			}else if($act == "pemeriksaan"){
				// echo "string";
				$no_kon = $this->input->post('form[0]');
				$tgl_nota = $this->input->post('form[1]');
				$tgl_nota_start = $tgl_nota[0];
				$tgl_nota_end = $tgl_nota[1];
				$no_kon1 = $no_kon[0];
				$addsql = "";

				if($tgl_nota_start!="" and $tgl_nota_end !=""){
					$addsql .= " AND DATE(F.START_INSP) BETWEEN '$tgl_nota_start' AND '$tgl_nota_end'";
				}else if($tgl_nota_start != ""){
					$addsql .= " AND DATE(F.START_INSP) >= '$tgl_nota_start'";
				}else if($tgl_nota_end != ""){
					$addsql .= " AND DATE(F.START_INSP) <= '$tgl_nota_end'";
				}else{
					 $addsql .= " GROUP BY A.NO_CONT ORDER BY C.WK_ACTIVE";
				}
				if($no_kon1 != ""){
					$addsql .= " AND A.NO_CONT = '$no_kon1' ";
				}
				if($this->session->userdata('KD_GROUP')=="BC"){
					$SQL = "SELECT B.NO_SPK AS 'NO_SPK',A.NO_CONT AS 'NO_CONT',A.UKR_CONT AS 'SIZE',C.NO_DOK AS 'NO_DOK',G.NAMA AS 'JNS_DOK',
						B.TGL_DOK AS 'TGL ANTRIAN',C.WK_RESPON AS 'TGL PKB', C.RESPON AS 'RESPON',C.WK_ACTIVE AS 'TGL SIAP PERIKSA',
						F.START_INSP AS 'TGL START PERIKSA',F.FINISH_INSP AS 'TGL SELESAI PERIKSA',F.NO_SEAL AS 'NO SEAL',B.CONSIGNEE AS 'CUSTOMERS'
						FROM t_spk_cont A
						LEFT JOIN t_spk B ON A.ID = B.ID
						LEFT JOIN t_gatepass C ON A.NO_CONT = C.NO_CONT
						INNER JOIN t_request D ON C.NO_DOK = D.NO_DOK
						LEFT JOIN reff_status_spk E ON A.STATUS_CONT = E.ID
						LEFT JOIN t_op_inspection F ON F.NO_CONT = A.NO_CONT
						LEFT JOIN reff_kode_dok_bc G ON D.JNS_DOK = G.ID
						WHERE C.FL_ACTIVE = 'Y' AND G.ID != 83 AND F.START_INSP IS NOT NULL AND F.FINISH_INSP IS NOT NULL ".$addsql;
				}else{
					$SQL = "SELECT B.NO_SPK AS 'NO_SPK',A.NO_CONT AS 'NO_CONT',A.UKR_CONT AS 'SIZE',C.NO_DOK AS 'NO_DOK',G.NAMA AS 'JNS_DOK',
						B.TGL_DOK AS 'TGL ANTRIAN',C.WK_RESPON AS 'TGL PKB', C.RESPON AS 'RESPON',C.WK_ACTIVE AS 'TGL SIAP PERIKSA',
						F.START_INSP AS 'TGL START PERIKSA',F.FINISH_INSP AS 'TGL SELESAI PERIKSA',F.NO_SEAL AS 'NO SEAL',B.CONSIGNEE AS 'CUSTOMERS'
						FROM t_spk_cont A
						LEFT JOIN t_spk B ON A.ID = B.ID
						LEFT JOIN t_gatepass C ON A.NO_CONT = C.NO_CONT
						INNER JOIN t_request D ON C.NO_DOK = D.NO_DOK
						LEFT JOIN reff_status_spk E ON A.STATUS_CONT = E.ID
						LEFT JOIN t_op_inspection F ON F.NO_CONT = A.NO_CONT
						LEFT JOIN reff_kode_dok_bc G ON D.JNS_DOK = G.ID
						WHERE C.FL_ACTIVE = 'Y' AND F.START_INSP IS NOT NULL AND F.FINISH_INSP IS NOT NULL ".$addsql;
				}

						$result = $func->main->get_result($SQL);
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
						$this->newphpexcel->mergecell(array(array('A1','N1'),array('A2','N2'),array('A3','N3')), FALSE);
						$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A1', 'REPORT PEMERIKSAAN');
						$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A2', 'COMMON GATE IPC TPK');
						$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A3', date("M Y"));
						$this->newphpexcel->width(array(array('A',5),array('B',20),array('C',20),array('D',5),array('E',20),array('F',25),array('G',20),array('H',25),array('I',20),array('J',25),array('K',25),array('L',25),array('M',25),array('N',35)));
						
						$this->newphpexcel->setActiveSheetIndex(0)
						->setCellValue('A5','NO')
						->setCellValue('B5','NO SPK')
						->setCellValue('C5','NO KONTAINER')
						->setCellValue('D5','SIZE')
						->setCellValue('E5','JENIS DOKUMEN')
						->setCellValue('F5','NO DOKUMEN')
						->setCellValue('G5','TANGGAL ANTRIAN')
						->setCellValue('H5','TANGGAL PKB')
						->setCellValue('I5','RESPON PKB')
						->setCellValue('J5','TANGGAL SIAP PERIKSA')
						->setCellValue('K5','TANGGAL START PERIKSA')
						->setCellValue('L5','TANGGAL SELESAI PERIKSA')
						->setCellValue('M5','NO SEAL')
						->setCellValue('N5','NAMA CUSTOMER');

						$this->newphpexcel->headings(array('A5','B5','C5','D5','E5','F5','G5','H5','I5','J5','K5','L5','M5','N5'));
						$this->newphpexcel->set_wrap(array('B','C','D','E','F','G','H','I','J','K','L','M','N'));
					$no = 1;
					$rec = 6;
					if($result){
						foreach($SQL->result_array() as $row){
							$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A'.$rec,$no)
							->setCellValueExplicit('B'.$rec,$row["NO_SPK"],PHPExcel_Cell_DataType::TYPE_STRING)
							->setCellValueExplicit('C'.$rec,$row["NO_CONT"],PHPExcel_Cell_DataType::TYPE_STRING)
							->setCellValueExplicit('D'.$rec,$row["SIZE"])
							->setCellValueExplicit('E'.$rec,$row["JNS_DOK"])
							->setCellValueExplicit('F'.$rec,$row["NO_DOK"],PHPExcel_Cell_DataType::TYPE_STRING)
							->setCellValueExplicit('G'.$rec,$row["TGL ANTRIAN"],PHPExcel_Cell_DataType::TYPE_STRING)
							->setCellValueExplicit('H'.$rec,$row["TGL PKB"],PHPExcel_Cell_DataType::TYPE_STRING)
							->setCellValueExplicit('I'.$rec,$row["RESPON"],PHPExcel_Cell_DataType::TYPE_STRING)
							->setCellValueExplicit('J'.$rec,$row["TGL SIAP PERIKSA"],PHPExcel_Cell_DataType::TYPE_STRING)
							->setCellValueExplicit('K'.$rec,$row["TGL START PERIKSA"],PHPExcel_Cell_DataType::TYPE_STRING)
							->setCellValueExplicit('L'.$rec,$row["TGL SELESAI PERIKSA"],PHPExcel_Cell_DataType::TYPE_STRING)
							->setCellValue('M'.$rec,$row["NO SEAL"])
							->setCellValueExplicit('N'.$rec,$row["CUSTOMERS"],PHPExcel_Cell_DataType::TYPE_STRING);

							$this->newphpexcel->set_detilstyle(array('A'.$rec,'B'.$rec,'C'.$rec,'D'.$rec,'E'.$rec,'F'.$rec,'G'.$rec,'H'.$rec,'I'.$rec,'J'.$rec,'K'.$rec,'L'.$rec,'M'.$rec,'N'.$rec));
							$rec++;
							$no++;	
						}
					}else{
						$this->newphpexcel->getActiveSheet()->mergeCells('A6:N6');
						$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A6','DATA TIDAK DITEMUKAN');
						$this->newphpexcel->set_detilstyle(array('A6'));
					}
					ob_clean();

					$file = "PEMERIKSAAN_" . date("Ymd") . ".xls";
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

	function get_referensi($type,$kode,$uraian){
		$func = get_instance();
        $func->load->model("m_main", "main", true);
		$return = NULL;
		switch($type){
			case 'kapal' :
				if($uraian!=""){
					$SQL = "SELECT ID, NAMA FROM reff_kapal
							WHERE NAMA = ".$this->db->escape(trim($uraian));
					$result = $func->main->get_result($SQL);
					if($result){
						foreach($SQL->result_array() as $row => $value){

							$arrdata = $value;
						}
						$kode_angkut = $arrdata['ID'];
					}else{
						$arrdata['NAMA'] = $uraian;
						$arrdata['CALL_SIGN'] = $kode;
						$this->db->insert('reff_kapal',$arrdata);
						$kode_angkut = $this->db->insert_id();
					}
					if($kode!=""){
						$data['NAMA'] = $uraian;
						$data['CALL_SIGN'] = $kode;
						$this->db->where(array('ID' => $arrdata['ID']));
						$this->db->update('reff_kapal', $data);
						$kode_angkut = $arrdata['ID'];
					}
				}
				$return = $kode_angkut;
			break;
		}
		return $return;
	}
}
?>
