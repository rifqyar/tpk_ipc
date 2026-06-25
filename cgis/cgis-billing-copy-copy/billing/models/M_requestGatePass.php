<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class M_requestGatePass extends CI_Model {

		public function __construct(){
			parent::__construct();

		}

		public function list_reqGatePass($act, $id){
			$page_title = 'REQUEST GATE PASS';
			$title = "REQUEST GATE PASS";
			$this->newtable->breadcrumb('Gate Pass', site_url()."/RequestGatePass/gatepass",'icon-home');
			$this->newtable->breadcrumb('Planning', 'javascript:void(0)','');
			$this->newtable->breadcrumb('Dokumen Gate Pass', 'javascript:void(0)','');
			$check = (grant()=="W")?true:false;
			$SQL = "SELECT DISTINCT A.ID AS 'ID',B.NAMA AS 'JENIS DOKUMEN', CONCAT('NO : ',(A.NO_DOK),'<BR>TGL : ', (DATE_FORMAT(C.TGL_DAFTAR_PABEAN,'%d-%m-%Y'))) AS 'DOKUMEN', CASE WHEN A.KD_REQ = 'DRAFT' THEN CONCAT('<span class=\"label label-danger\">',(A.KD_REQ),'</SPAN>') WHEN A.KD_REQ = 'QUEUED' THEN CONCAT('<span class=\"label label-warning\">',(A.KD_REQ),'</SPAN>') WHEN A.KD_REQ = 'SENT' THEN CONCAT('<span class=\"label label-success\">',(A.KD_REQ),'</SPAN>') WHEN A.KD_REQ = 'APPROVED' THEN CONCAT('<span class=\"label label-primary\">',(A.KD_REQ),'</SPAN>') ELSE '' END AS 'STATUS REQUEST',CASE WHEN A.FL_FINISH = 'Y' THEN '<span class=\'label label-success\'>SUDAH DI REQUEST</span>' ELSE '' END AS KETERANGAN, CASE WHEN C.STATUS_MAIL IS NULL THEN '<span class=\"label label- PRIMARY\">Email Belum Di Proses</span>' WHEN C.STATUS_MAIL = 'Email Tidak Terkirim' THEN '<span class=\"label label-danger\">Email Tidak Terkirim</span>' WHEN C.STATUS_MAIL = 'Email Terkirim' THEN '<span class=\"label label-success\">Email Terkirim</span>' END AS 'STATUS_PENGIRIMAN', CASE WHEN C.STATUS = 'N' THEN '<span style=\"color:red;font-weight:bold\">REQUEST</span>' WHEN C.STATUS = 'Y' THEN '<span style=\"color:green;font-weight:bold\">DONE</span>' ELSE 0 END AS 'STATUS'
				FROM t_request A
				LEFT JOIN reff_kode_dok_bc B ON A.JNS_DOK = B.ID
				LEFT JOIN t_request_cont F ON A.ID = F.ID
				LEFT JOIN t_permit_hdr C ON A.NO_DOK = C.NO_DAFTAR_PABEAN AND A.JNS_DOK = C.KD_DOK_INOUT
				LEFT JOIN t_permit_cont D ON C.ID = D.ID
				INNER JOIN t_cocostscont_new E ON E.NO_CONT=F.NO_CONT
				LEFT JOIN t_cocostshdr H ON H.NM_ANGKUT = C.ANGKUTNAMA_TPS AND H.NO_VOY_FLIGHT = C.ANGKUTNO_TPS";
			/*$proses = array('SEND MAIL'  => array('POST',"RequestGatePass/request/save/request_gate_pass", '1','','md-email','','list'),*/
			$proses = array('SEND MAIL'  => array('MODAL',"RequestGatePass/gatepass/add_paidThrough", '1','','md-email','','list'),
							'PRINT EXCEL'  => array('EXCEL', "proces/excel/gatepass", '0','','md-file-text','','menu'));
			$this->newtable->multiple_search(true);
			$this->newtable->show_chk(false);
			$this->newtable->show_menu($check);
			$this->newtable->show_search(true);
			$arr_dok = array(""=>"","SPJM"=>"SPJM","SPPMP"=>"SPPMP");
			$arr_sts = array(""=>"","Email Terkirim"=>"Email Terkirim","Email Tidak Terkirim"=>"Email Tidak Terkirim");
			$this->newtable->search(array(
			array('F.NO_CONT','NO. KONTAINER'),array('C.ANGKUTNAMA_TPS','NAMA KAPAL'),array('C.ANGKUTNO_TPS','NO. VOYAGE'),array('A.NO_DOK','NO. DOKUMEN'),array('B.NAMA','JENIS DOKUMEN',
			'OPTION',$arr_dok),array('C.STATUS_MAIL ','STATUS PENGIRIMAN','OPTION',$arr_sts)));
			$this->newtable->action(site_url() . "/requestGatePass/gatepass");
			if($check) $this->newtable->detail(array('POPUP',"requestGatePass/gatepass/gate_pass_request_detail"));
			$this->newtable->tipe_proses('button');
			$this->newtable->hiddens(array("ID","NO_CONT","STATUS_PENGIRIMAN", "STATUS"));
			$this->newtable->keys(array("ID"));
			$this->newtable->cidb($this->db);
			$this->newtable->orderby("A.FL_FINISH DESC, STATUS DESC");
			$this->newtable->sortby("");
			$this->newtable->groupby(array("ID"));
			$this->newtable->set_formid("tblrequestgatepass");
			$this->newtable->set_divid("divtblrequestgatepass");
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
		
		public function list_reqGatePassBcOld($act, $id){
			$func = get_instance();
        	$func->load->model("m_main", "main", true);
			$page_title = 'REQUEST GATE PASS';
			$title = "REQUEST GATE PASS";

			$check = (grant()=="W")?true:false;
			$SQL = "SELECT DISTINCT A.ID AS 'ID',B.NAMA AS 'JENIS DOKUMEN',
					CONCAT('NO : ',(A.NO_DOK),'<BR>TGL : ', (DATE_FORMAT(C.TGL_DAFTAR_PABEAN,'%d-%m-%Y'))) AS 'DOKUMEN',
					CONCAT('<span class=\"label label-danger\">',(A.KD_REQ),'</SPAN>') AS 'STATUS REQUEST', 
					-- CONCAT('',(C.ANGKUTNAMA_TPS),'<BR>',(C.ANGKUTNO_TPS)) AS 'VOYAGE', A.KD_REQ AS 'STATUS REQUEST', 
					CASE WHEN C.STATUS_MAIL IS NULL THEN '<span class=\"label label-primary\">Email Belum Di Proses</span>'
					WHEN C.STATUS_MAIL = 'Email Tidak Terkirim' THEN '<span class=\"label label-danger\">Email Tidak Terkirim</span>'
					WHEN C.STATUS_MAIL = 'Email Terkirim' THEN '<span class=\"label label-success\">Email Terkirim</span>' END AS 'STATUS_PENGIRIMAN',
					CASE WHEN C.STATUS = 'N' THEN '<span style=\"color:red;font-weight:bold\">REQUEST</span>'
					WHEN C.STATUS = 'Y' THEN '<span style=\"color:green;font-weight:bold\">DONE</span>' ELSE 0 END AS 'STATUS'
					FROM t_request A 
					INNER JOIN reff_kode_dok_bc B ON A.JNS_DOK = B.ID
					INNER JOIN t_request_cont F ON A.ID = F.ID
					INNER JOIN t_permit_hdr C ON A.NO_DOK = C.NO_DAFTAR_PABEAN AND A.JNS_DOK = C.KD_DOK_INOUT
					INNER JOIN t_permit_cont D ON C.ID = D.ID
					INNER JOIN t_cocostscont_new E ON E.NO_CONT=F.NO_CONT
					INNER JOIN t_cocostshdr H ON H.NM_ANGKUT = C.ANGKUTNAMA_TPS AND H.NO_VOY_FLIGHT = C.ANGKUTNO_TPS 
					WHERE A.JNS_DOK  IN ('19','80','81','82') AND F.ISO_CODE IS NOT NULL";
			$proses = array('SEND MAIL'  => array('MODAL',"RequestGatePass/gatepass/add_paidThrough", '1','','md-email','','list'),
							'PRINT EXCEL'  => array('EXCEL', "proces/excel/gatepass", '0','','md-file-text','','menu'));
			$this->newtable->multiple_search(true);
			$this->newtable->show_chk(false);
			$this->newtable->show_menu($check);
			$this->newtable->show_search(true);
			$arr_dok = array(""=>"","SPJM"=>"SPJM","SPPMP"=>"SPPMP");
			$arr_sts = array(""=>"","Email Terkirim"=>"Email Terkirim","Email Tidak Terkirim"=>"Email Tidak Terkirim");
			$this->newtable->search(array(
			array('D.NO_CONT','NO. KONTAINER'),array('C.ANGKUTNAMA_TPS','NAMA KAPAL'),array('C.ANGKUTNO_TPS','NO. VOYAGE'),array('A.NO_DOK','NO. DOKUMEN'),array('B.NAMA','JENIS DOKUMEN',
			'OPTION',$arr_dok),array('C.STATUS_MAIL ','STATUS PENGIRIMAN','OPTION',$arr_sts)));
			$this->newtable->action(site_url() . "/requestGatePass/gatepass");
			if($check) $this->newtable->detail(array('POPUP',"requestGatePass/gatepass/gate_pass_request_detail"));
			$this->newtable->tipe_proses('button');
			$this->newtable->hiddens(array("ID","NO_CONT","STATUS_PENGIRIMAN", "STATUS"));
			$this->newtable->keys(array("ID"));
			$this->newtable->cidb($this->db);
			$this->newtable->orderby("TGL_DAFTAR_PABEAN ASC, STATUS DESC");
			$this->newtable->sortby("");
			$this->newtable->groupby("");
			$this->newtable->set_formid("tblrequestgatepass");
			$this->newtable->set_divid("divtblrequestgatepass");
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
		
		public function list_reqGatePassBc($act, $id){
			$func = get_instance();
        	$func->load->model("m_main", "main", true);
			$page_title = 'REQUEST GATE PASS';
			$title = "REQUEST GATE PASS";

			$check = (grant()=="W")?true:false;
				
			$SQL = "SELECT DISTINCT A.ID AS 'ID',B.NAMA AS 'JENIS DOKUMEN', CONCAT('NO : ',(A.NO_DOK),'<BR>TGL : ', (DATE_FORMAT(C.TGL_DAFTAR_PABEAN,'%d-%m-%Y'))) AS 'DOKUMEN', A.NO_BL_AWB AS 'NO BL', CASE WHEN A.KD_REQ = 'DRAFT' THEN CONCAT('<span class=\"label label-danger\">',(A.KD_REQ),'</SPAN>') WHEN A.KD_REQ = 'QUEUED' THEN CONCAT('<span class=\"label label-warning\">',(A.KD_REQ),'</SPAN>') WHEN A.KD_REQ = 'SENT' THEN CONCAT('<span class=\"label label-success\">',(A.KD_REQ),'</SPAN>') WHEN A.KD_REQ = 'APPROVED' THEN CONCAT('<span class=\"label label-primary\">',(A.KD_REQ),'</SPAN>') WHEN A.KD_REQ = 'INQUIRY' THEN CONCAT('<span class=\"label label-success\">',(A.KD_REQ),'</SPAN>') ELSE A.RESPONSE_REQ END AS 'STATUS_REQUEST', CASE WHEN C.STATUS_MAIL IS NULL THEN '<span class=\"label label- PRIMARY\">Email Belum Di Proses</span>' WHEN C.STATUS_MAIL = 'Email Tidak Terkirim' THEN '<span class=\"label label-danger\">Email Tidak Terkirim</span>' WHEN C.STATUS_MAIL = 'Email Terkirim' THEN '<span class=\"label label-success\">Email Terkirim</span>' END AS 'STATUS_PENGIRIMAN', CASE WHEN C.STATUS = 'N' THEN '<span style=\"color:red;font-weight:bold\">REQUEST</span>' WHEN C.STATUS = 'Y' THEN '<span style=\"color:green;font-weight:bold\">DONE</span>' ELSE 0 END AS 'STATUS', A.RESPONSE_REQ AS RESPONSE, CASE WHEN A.WK_FINISH IS NOT NULL THEN '<span class=\"label label-primary\">SELESAI</span>' ELSE '-' END AS KETERANGAN
					FROM t_request A
					LEFT JOIN reff_kode_dok_bc B ON A.JNS_DOK = B.ID
					LEFT JOIN t_request_cont F ON A.ID = F.ID
					LEFT JOIN t_permit_hdr C ON A.NO_DOK = C.NO_DAFTAR_PABEAN AND C.KD_DOK_INOUT = A.JNS_DOK
					LEFT JOIN t_permit_cont D ON C.ID = D.ID AND D.TIPE_CONT IS NOT NULL AND D.TIPE_CONT != 'RFR'
					LEFT JOIN t_cocostscont E ON E.NO_CONT = F.NO_CONT
					LEFT JOIN t_cocostshdr H ON H.NM_ANGKUT = C.ANGKUTNAMA_TPS AND H.NO_VOY_FLIGHT = C.ANGKUTNO_TPS
					WHERE A.JNS_DOK != '83' AND E.ISO_CODE IS NOT NULL";// AND D.TIPE_CONT != 'RFR'
			$proses = array('SEND MAIL'  => array('MODAL',"RequestGatePass/gatepassBc/add_paidThrough_karantina", '1','','md-email','','list'),
							'PRINT EXCEL'  => array('EXCEL', "proces/excel/gatepassBc", '0','','md-file-text','','menu'));
			$this->newtable->multiple_search(true);
			$this->newtable->show_chk(false);
			$this->newtable->show_menu($check);
			$this->newtable->show_search(true);
			$arr_dok = array(""=>"","SPJM"=>"SPJM","SPPMP"=>"SPPMP");
			$arr_sts = array(""=>"","Email Terkirim"=>"Email Terkirim","Email Tidak Terkirim"=>"Email Tidak Terkirim");
			$this->newtable->search(array(array('F.NO_CONT','NO. KONTAINER'),array('C.ANGKUTNAMA_TPS','NAMA KAPAL'),array('C.ANGKUTNO_TPS','NO. VOYAGE'),array('A.NO_DOK','NO. DOKUMEN'),array('B.NAMA','JENIS DOKUMEN',
			'OPTION',$arr_dok),array('C.STATUS_MAIL ','STATUS PENGIRIMAN','OPTION',$arr_sts)));
			$this->newtable->action(site_url() . "/requestGatePass/gatepassBc");
			if($check) $this->newtable->detail(array('POPUP',"requestGatePass/gatepassBc/gate_pass_request_detail"));
			$this->newtable->tipe_proses('button');
			$this->newtable->hiddens(array("ID","NO_CONT","STATUS_PENGIRIMAN", "STATUS"));
			$this->newtable->keys(array("ID"));
			$this->newtable->cidb($this->db);
			$this->newtable->orderby("A.WK_FINISH ASC,C.TGL_DAFTAR_PABEAN DESC");
			$this->newtable->sortby("");
			$this->newtable->groupby(array("A.NO_DOK"));
			$this->newtable->set_formid("tblrequestgatepassBc");
			$this->newtable->set_divid("divtblrequestgatepassBC");
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
		
		public function list_reqGatePassKarantina($act, $id){
			$func = get_instance();
        	$func->load->model("m_main", "main", true);
			$page_title = 'REQUEST GATE PASS';
			$title = "REQUEST GATE PASS";

			$check = (grant()=="W")?true:false;
				
			/*$SQL = "SELECT DISTINCT A.ID AS 'ID',B.NAMA AS 'JENIS DOKUMEN', CONCAT('NO : ',(A.NO_DOK),'<BR>TGL : ', (DATE_FORMAT(C.TG_RESPON,'%d-%m-%Y'))) AS 'DOKUMEN', CASE WHEN A.KD_REQ = 'DRAFT' THEN CONCAT('<span class=\"label label-danger\">',(A.KD_REQ),'</SPAN>') WHEN A.KD_REQ = 'QUEUED' THEN CONCAT('<span class=\"label label-warning\">',(A.KD_REQ),'</SPAN>') WHEN A.KD_REQ = 'SENT' THEN CONCAT('<span class=\"label label-success\">',(A.KD_REQ),'</SPAN>') WHEN A.KD_REQ = 'APPROVED' THEN CONCAT('<span class=\"label label-primary\">',(A.KD_REQ),'</SPAN>') WHEN A.KD_REQ = 'INQUIRY' THEN CONCAT('<span class=\"label label-success\">',(A.KD_REQ),'</SPAN>') ELSE A.RESPONSE_REQ END AS 'STATUS_REQUEST', CASE WHEN C.STATUS_MAIL IS NULL THEN '<span class=\"label label- PRIMARY\">Email Belum Di Proses</span>' WHEN C.STATUS_MAIL = 'Email Tidak Terkirim' THEN '<span class=\"label label-danger\">Email Tidak Terkirim</span>' WHEN C.STATUS_MAIL = 'Email Terkirim' THEN '<span class=\"label label-success\">Email Terkirim</span>' END AS 'STATUS_PENGIRIMAN', CASE WHEN C.STATUS = 'N' THEN '<span style=\"color:red;font-weight:bold\">REQUEST</span>' WHEN C.STATUS = 'Y' THEN '<span style=\"color:green;font-weight:bold\">DONE</span>' ELSE 0 END AS 'STATUS', CASE WHEN A.WK_FINISH IS NOT NULL THEN '<span class=\"label label-primary\">SELESAI</span>' ELSE '-' END AS KETERANGAN
					FROM t_request A
					LEFT JOIN reff_kode_dok_bc B ON A.JNS_DOK = B.ID
					LEFT JOIN t_request_cont F ON A.ID = F.ID
					LEFT JOIN t_ppk_hdr C ON A.NO_DOK = C.NO_RESPON
					LEFT JOIN t_lic_hdr J ON C.ID_IJIN = J.ID_IJIN
					LEFT JOIN t_ppk_cont D ON C.ID_IJIN = D.ID_IJIN
					LEFT JOIN t_cocostscont_new E ON E.NO_CONT = F.NO_CONT
					LEFT JOIN t_cocostscont I ON I.NO_CONT = F.NO_CONT
					-- LEFT JOIN t_cocostshdr H ON H.NM_ANGKUT = C.ANGKUTNAMA_TPS AND H.NO_VOY_FLIGHT = C.ANGKUTNO_TPS  AND D.TIPE_CONT != 'RFR'
					WHERE A.JNS_DOK IN('83') AND I.ISO_CODE IS NOT NULL";*/
			
			$SQL = "SELECT DISTINCT A.ID AS 'ID',B.NAMA AS 'JENIS DOKUMEN', CONCAT('NO : ',(A.NO_DOK),'<BR>TGL : ', (DATE_FORMAT(C.TG_RESPON,'%d-%m-%Y'))) AS 'DOKUMEN', A.NO_BL_AWB AS 'NO BL', CASE WHEN A.KD_REQ = 'DRAFT' THEN CONCAT('<span class=\"label label-danger\">',(A.KD_REQ),'</SPAN>') WHEN A.KD_REQ = 'QUEUED' THEN CONCAT('<span class=\"label label-warning\">',(A.KD_REQ),'</SPAN>') WHEN A.KD_REQ = 'SENT' THEN CONCAT('<span class=\"label label-success\">',(A.KD_REQ),'</SPAN>') WHEN A.KD_REQ = 'APPROVED' THEN CONCAT('<span class=\"label label- PRIMARY\">',(A.KD_REQ),'</SPAN>') WHEN A.KD_REQ = 'INQUIRY' THEN CONCAT('<span class=\"label label-success\">',(A.KD_REQ),'</SPAN>') ELSE A.RESPONSE_REQ END AS 'STATUS_REQUEST', CASE WHEN C.STATUS_MAIL IS NULL THEN '<span class=\"label label-primary\">Email Belum Di Proses</span>' WHEN C.STATUS_MAIL = 'Email Tidak Terkirim' THEN '<span class=\"label label-danger\">Email Tidak Terkirim</span>' WHEN C.STATUS_MAIL = 'Email Terkirim' THEN '<span class=\"label label-success\">Email Terkirim</span>' END AS 'STATUS_PENGIRIMAN', CASE WHEN C.STATUS = 'N' THEN '<span style=\"color:red;font-weight:bold\">REQUEST</span>' WHEN C.STATUS = 'Y' THEN '<span style=\"color:green;font-weight:bold\">DONE</span>' ELSE 0 END AS 'STATUS',A.RESPONSE_REQ AS RESPONSE, CASE WHEN A.WK_FINISH IS NOT NULL THEN '<span class=\"label label-primary\">SELESAI</span>' ELSE '-' END AS KETERANGAN
					FROM t_request A
					INNER JOIN reff_kode_dok_bc B ON A.JNS_DOK = B.ID
					INNER JOIN t_request_cont F ON A.ID = F.ID
					INNER JOIN t_ppk_hdr C ON A.NO_DOK = C.NO_RESPON
					INNER JOIN t_lic_hdr J ON C.ID_IJIN = J.ID_IJIN 
					INNER JOIN t_ppk_cont D ON C.ID_IJIN = D.ID_IJIN AND D.TIPE_CONT IS NOT NULL AND D.TIPE_CONT != 'RFR'
					LEFT JOIN t_cocostscont_new E ON E.NO_CONT = F.NO_CONT
					LEFT JOIN t_cocostscont I ON I.NO_CONT = F.NO_CONT
					WHERE A.JNS_DOK IN('83') AND I.ISO_CODE IS NOT NULL";
			$proses = array('SEND MAIL'  => array('MODAL',"RequestGatePass/gatepass/add_paidThrough_karantina", '1','','md-email','','list'),
							'PRINT EXCEL'  => array('EXCEL', "proces/excel/gatepass", '0','','md-file-text','','menu'));
			$this->newtable->multiple_search(true);
			$this->newtable->show_chk(false);
			$this->newtable->show_menu($check);
			$this->newtable->show_search(true);
			$arr_dok = array(""=>"","SPJM"=>"SPJM","SPPMP"=>"SPPMP");
			$arr_sts = array(""=>"","Email Terkirim"=>"Email Terkirim","Email Tidak Terkirim"=>"Email Tidak Terkirim");
			$this->newtable->search(array(
			/*array('X.NO_CONT','NO. KONTAINER'),array('X.ANGKUTNAMA_TPS','NAMA KAPAL'),array('X.ANGKUTNO_TPS','NO. VOYAGE'),array('X.NO_DOK','NO. DOKUMEN'),array('X.NAMA','JENIS DOKUMEN',
			'OPTION',$arr_dok),array('X.STATUS_MAIL ','STATUS PENGIRIMAN','OPTION',$arr_sts)));*/
			array('F.NO_CONT','NO. KONTAINER'),array('C.ANGKUTNAMA_TPS','NAMA KAPAL'),array('C.ANGKUTNO_TPS','NO. VOYAGE'),array('A.NO_DOK','NO. DOKUMEN'),array('B.NAMA','JENIS DOKUMEN',
			'OPTION',$arr_dok),array('C.STATUS_MAIL ','STATUS PENGIRIMAN','OPTION',$arr_sts)));
			$this->newtable->action(site_url() . "/requestGatePass/gatepass");
			if($check) $this->newtable->detail(array('POPUP',"requestGatePass/gatepass/gate_pass_request_detail"));
			$this->newtable->tipe_proses('button');
			$this->newtable->hiddens(array("ID","NO_CONT","STATUS_PENGIRIMAN", "STATUS"));
			$this->newtable->keys(array("ID"));
			$this->newtable->cidb($this->db);
			//$this->newtable->orderby("X.WK_FINISH ASC,X.STATUS DESC");
			$this->newtable->orderby("A.WK_FINISH ASC,C.TG_RESPON DESC");
			$this->newtable->sortby("");
			//$this->newtable->groupby(array("X.NO_DOK"));
			$this->newtable->groupby(array("A.NO_DOK"));
			$this->newtable->set_formid("tblrequestgatepasskarantina");
			$this->newtable->set_divid("divtblrequestgatepasskarantina");
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
			$func = get_instance();
        	$func->load->model("m_main", "main");
        	if ($act == 'gate_pass_request_detail') {
				$getJnsDok = "SELECT JNS_DOK FROM t_request WHERE id = '$id'";
				$restultDok = $this->db->query($getJnsDok)->result_array();
				$jns_dokumen = $restultDok[0]['JNS_DOK'];
				if($jns_dokumen == 83){
					$SQL = "SELECT B.*, E.NAMA, F.NM_TRADER AS CONSIGNEE, '83' AS KD_DOK
							FROM t_request A
							LEFT JOIN t_request_cont B ON B.ID = A.ID
							LEFT JOIN t_ppk_hdr C ON A.NO_DOK = C.NO_RESPON
							LEFT JOIN t_ppk_cont D ON C.ID_IJIN = D.ID_IJIN
							LEFT JOIN reff_status_cont E ON E.ID = D.KD_STATUS
							LEFT JOIN t_lic_hdr F ON C.NO_RESPON = F.NO_IJIN
							WHERE B.id = '$id'
							GROUP BY B.NO_CONT
							ORDER BY B.FLAG_FINISH_PRINT = 'Y' ASC";
				} else {
					$SQL = "SELECT B.*, E.NAMA, C.CONSIGNEE, C.KD_DOK_INOUT AS KD_DOK
							FROM t_request A
							LEFT JOIN t_request_cont B ON B.ID = A.ID
							LEFT JOIN t_permit_hdr C ON A.NO_DOK = C.NO_DAFTAR_PABEAN AND C.KD_DOK_INOUT = A.JNS_DOK
							LEFT JOIN t_permit_cont D ON C.ID = D.ID
							LEFT JOIN reff_status_cont E ON E.ID = D.KD_STATUS
							WHERE B.id = '$id'
							GROUP BY B.NO_CONT
							ORDER BY B.FLAG_FINISH_PRINT = 'Y' ASC";
				}
				//echo $SQL;
				$result = $this->db->query($SQL);
				return $result->result();
        	}
		}
		
		public function process($type, $act, $id){
			$func = get_instance();
			$func->load->model("m_main", "main", true);
			$success = 0;
			$error = 0;
			if($type == "excel"){
				if($act=="gatepass"){
					$SQL = "SELECT DISTINCT B.NAMA AS 'JENIS DOKUMEN',
							A.NO_DOK AS 'NO DOKUMEN', A.TGL_DOK AS 'TGL DOKUMEN', C.NM_ANGKUT AS 'NAMA KAPAL', C.NO_VOY_FLIGHT AS 'NO. VOYAGE',
							F.NO_CONT AS 'NO. KONTAINER', NULL AS 'NO. TPFT' , C.ID_CONSIGNEE AS 'NPWP', C.CONSIGNEE
							FROM t_request A 
							INNER JOIN reff_kode_dok_bc B ON A.JNS_DOK = B.ID
							INNER JOIN t_request_cont F ON A.ID = F.ID
							INNER JOIN t_permit_hdr C 	ON A.NO_DOK = C.NO_DAFTAR_PABEAN AND A.JNS_DOK = C.KD_DOK_INOUT
							INNER JOIN t_permit_cont D ON C.ID = D.ID
							INNER JOIN t_cocostscont_new E ON E.NO_CONT=F.NO_CONT
							INNER JOIN t_cocostshdr H ON H.NM_ANGKUT=C.ANGKUTNAMA_TPS AND H.NO_VOY_FLIGHT=C.ANGKUTNO_TPS 
							GROUP BY A.NO_DOK";
					$result = $func->main->get_result($SQL);
					$this->load->library('newphpexcel');
					$this->newphpexcel->getDefaultStyle()->getFont()->setName('Calibri')->setSize(10);
					$this->newphpexcel->setActiveSheetIndex(0);
					$styleArray = array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
					$this->newphpexcel->getDefaultStyle()->applyFromArray($styleArray);
					$this->newphpexcel->set_bold(array('A1'));
					$this->newphpexcel->mergecell(array(array('A1','M1'),array('AD3','AJ3'),array('AK3','AQ3')), FALSE);
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A1', 'REPORT');
					$this->newphpexcel->mergecell(array(array('A3','A4'),array('B3','B4'),array('C3','C4'),array('D3','D4'),array('E3','E4'),array('F3','F4'),array('G3','G4'),array('H3','H4'),array('I3','I4')), FALSE);
					$this->newphpexcel->width(array(array('A',25),array('B',25),array('C',25),array('D',25),array('E',25),array('F',25),array('G',25),array('H',25),array('I',25)));
					$this->newphpexcel->setActiveSheetIndex(0)
						->setCellValue('A3','JENIS DOKUMEN')
						->setCellValue('B3','NO DOKUMEN')
						->setCellValue('C3','TGL DOKUMEN')
						->setCellValue('D3','NAMA KAPAL')
						->setCellValue('E3','NO. VOYAGE')
						->setCellValue('F3','NO. KONTAINER')
						->setCellValue('G3','NO. TPFT')
						->setCellValue('H3','NPWP')
						->setCellValue('I3','CONSIGNEE');
					$this->newphpexcel->headings(array('A3','B3','C3','D3','E3','F3','G3','H3','I3','A4','B4','C4','D4','E4','F4','G4','H4','I4'));
					$this->newphpexcel->set_wrap(array('B','C','D','E','F','G','H','I'));
					$no = 1;
					$rec = 5;
					if($result){
						foreach($SQL->result_array() as $row){
							$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A'.$rec,$row["JENIS DOKUMEN"])
							->setCellValueExplicit('B'.$rec,$row["NO DOKUMEN"],PHPExcel_Cell_DataType::TYPE_STRING)
							->setCellValue('C'.$rec,$row["TGL DOKUMEN"])
							->setCellValueExplicit('D'.$rec,$row["NAMA KAPAL"],PHPExcel_Cell_DataType::TYPE_STRING)
							->setCellValueExplicit('E'.$rec,$row["NO. VOYAGE"],PHPExcel_Cell_DataType::TYPE_STRING)
							->setCellValue('F'.$rec,$row["NO. KONTAINER"])
							->setCellValueExplicit('G'.$rec,$row["NO_TPFT"],PHPExcel_Cell_DataType::TYPE_STRING)
							->setCellValue('H'.$rec,$row["NPWP"])
							->setCellValueExplicit('I'.$rec,$row["CONSIGNEE"],PHPExcel_Cell_DataType::TYPE_STRING);
							$this->newphpexcel->set_detilstyle(array('A'.$rec,'B'.$rec,'C'.$rec,'D'.$rec,'E'.$rec,'F'.$rec,'G'.$rec,'H'.$rec,'I'.$rec));
							$rec++;
							$no++;
						}
					}else{
						$this->newphpexcel->getActiveSheet()->mergeCells('A5:I5');
						$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A5','DATA TIDAK DITEMUKAN');
						$this->newphpexcel->set_detilstyle(array('A5'));
					}
					ob_clean();
					$file = "DOKUMENT_".date("Ymd").".xls";
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
	
		/*public function hitungreffnumber(){
    		$data=$this->db->query("SELECT REF_NUMBER FROM t_request_cont WHERE LEFT(REF_NUMBER,3) = 'CGO'");
    		return $data->result_array();
    	} */

    	public function hitungreffnumber(){
    		$data=$this->db->query("SELECT ID FROM t_sequence ORDER BY ID DESC LIMIT 1");
    		return $data->result_array();
    	}

		public function execute($type, $act, $id) {
	        $func = get_instance();
	        $func->load->model("m_main", "main", true);
	        $success = 0;
	        $error = 0;
	        if($type == "save"){
				if($act == "request_gate_pass"){
					$arridexp = explode("~", $id);
					$idPost = $arridexp[0];
					$no_cont = $arridexp[1];
					$SQL = "SELECT * FROM t_request WHERE ID = '".$idPost."'";
					$result = $func->main->get_result($SQL);
					if($result){
					foreach ($SQL->result_array() as $row => $value) {
						$arrdata = $value;
					}
					$cek = "SELECT * FROM t_request WHERE ID = '".$idPost."' AND KD_REQ = 'DRAFT'";
					//echo $cek;//die();
					$resCek = $this->db->query($cek)->row();
					$jmlh = count($resCek);
					/*if ($jmlh <= 0) {
						echo "Sudah di reques";die();
					} else {*/
						#today coment
						/*$this->db->where('ID',$idPost);
						$this->db->update(t_request,array('KD_REQ' => 'QUEUED'));*/
						
						$SQLMail = "SELECT DISTINCT A.ID, B.ANGKUTNAMA_TPS, B.NO_BL_AWB, B.NO_BC11,B.TGL_BC11, C.NAMA AS 'JENIS_DOKUMEN', B.NO_DAFTAR_PABEAN AS 'PIB', 
									B.TGL_DAFTAR_PABEAN AS 'TGL_PIB', A.NO_DOK AS 'NOMOR_DOKUMEN', A.TGL_DOK, B.CONSIGNEE, B.ID_CONSIGNEE,A.WK_REQ,
									E.UKR_CONT, E.NO_CONT
									FROM t_request A
									LEFT JOIN t_request_cont E ON A.ID = E.ID
									LEFT JOIN t_permit_hdr B ON A.NO_DOK = B.NO_DAFTAR_PABEAN AND A.TGL_DOK = B.TGL_DAFTAR_PABEAN
									LEFT JOIN reff_kode_dok_bc C ON A.JNS_DOK = C.ID
									LEFT JOIN t_permit_cont D ON B.ID = D.ID
									WHERE A.ID = '".$idPost."' 
									AND E.NO_CONT IN($no_cont)";
									echo $SQLMail;
						$resultMail = $func->main->get_result($SQLMail);
						if($resultMail){
							foreach ($SQLMail->result_array() as $row2 => $valueMail) {
								$arrdataMail[] = $valueMail;
							}
							$JMLH = count($arrdataMail);
							for($c=0;$c<$JMLH;$c++){
								$tmpCont .= $arrdataMail[$c]["NO_CONT"]."-".$arrdataMail[$c]["UKR_CONT"].'"'. " , ";
								$CONT = rtrim($tmpCont,", ");
							}
							$email3 = $this->db->query("SELECT EMAIL,KEGIATAN, JNS_EMAIL FROM reff_mail WHERE KEGIATAN = 'GATE'")->result_array();
							for ($i=0; $i <count($email3); $i++) {

								$subject = "REQUEST GATEPASS CIC - [".$arrdataMail[0]['CONSIGNEE']."]";//"REMINDER GATEPASS";
								$email = $email3[$i]['EMAIL'];
								print_r($email);
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
									<html lang="en">
											<head>
												<meta charset="UTF-8">
												<title>Document</title>
											</head>
											<body>
											<div align="">
												<p align="">
													Dengan Hormat,<br><br>
													Bersama ini kami informasikan data barang/container yang akan diangkut (pick up) dari terminal untuk kebutuhan pemeriksaan (behandle) dengan data sebagai berikut :
												</p>
												<table border="1" class="table" width="80%" style="width:80%;border-collapse:collapse;background:#ecf3eb">
														<tr>
															<td style="width:214px;"><b>NPWP Perusahaan</b> </td>
															<td>:</td>
															<td>'.$arrdataMail[0]['ID_CONSIGNEE'].'</td>
														</tr>
														<tr>
															<td width=""><b>Nama Perusahaan</b> </td>
															<td>:</td>
															<td>'.$arrdataMail[0]['CONSIGNEE'].'</td>
														</tr>
														<tr>
															<td><b>Nama Kapal </b></td>
															<td>:</td>
															<td>'.$arrdataMail[0]['ANGKUTNAMA_TPS'].'</td>
														</tr>
														<tr>
															<td><b>NO. BL </b></td>
															<td>:</td>
															<td>'.$arrdataMail[0]['NO_BL_AWB'].'</td>
														</tr>
														<tr>
															<td><b>Nomor Container </b></td>
															<td>:</td>
															<td>'.$CONT.'</td>
														</tr>
														<tr>
															<td><b>No. Dokumen Customs </b></td>
															<td></td>
															<td></td>
														</tr>
													</table>
													<table style="width:80%;border-collapse:collapse;background:#ecf3eb" border="1">
																	<tr>
																		<td style="width:214px;"><b>PIB</b></td>
																		<td style="width: 18px;">:</td>
																		<td></td>
																		<td><b>Tanggal Dokumen Dikeluarkan</b></td>
																		<td>:</td>
																		<td></td>
																	</tr>
																	<tr>
																		<td><b>SPJM</b></td>
																		<td>:</td>
																		<td>'.$arrdataMail[0]['PIB'].'</td>
																		<td><b>Tanggal Dokumen Dikeluarkan</b></td>
																		<td>:</td>
																		<td>'.$arrdataMail[0]['TGL_PIB'].'</td>
																	</tr>
																	<tr>
																		<td><b>SPPMP</b></td>
																		<td>:</td>
																		<td></td>
																		<td><b>Tanggal Dokumen Dikeluarkan</b></td>
																		<td>:</td>
																		<td></td>
																	</tr>
																	<tr>
																		<td><b>BC.1.1</b></td>
																		<td>:</td>
																		<td>'.$arrdataMail[0]['NO_BC11'].'</td>
																		<td><b>Tanggal Dokumen Dikeluarkan</b></td>
																		<td>:</td>
																		<td>'.$arrdataMail[0]['TGL_BC11'].'</td>
																	</tr>
																	<tr>
																		<td><b>HI CO Scan</b></td>
																		<td>:</td>
																		<td></td>
																		<td><b>Tanggal Dokumen Dikeluarkan</b></td>
																		<td>:</td>
																		<td></td>
																	</tr>
																</table>
																<table style="width:80%;border-collapse:collapse;background:#ecf3eb" border="1" width="80%">
																<tr>
																	<td style="width:214px;"><b>Rencana Keluar</b></td>
																	<td width="2%">:</td>
																	<td>'.date('d-m-Y').'</td>
																</tr>
															</table><br><br>
												<!-- <table border="1" class="table" width="55%">
													<tr>
														<th>No. SPK</th>
														<th>Nomor Kontainer</th>
													</tr>
													<tr>
														<td>IPC TPK/5</td>
														<td>SGSDGSD64546</td>
													</tr>
												</table> --><br>
												<div>
													Mohon kerjasamanya untuk mengirimkan data Gate Pass CIC sesuai kebutuhan diatas.<br><br>
													Atas perhatian dan kerjasamanya kami ucapkan terima kasih.<br><br>

													=================================================================================<br><br>
													<table border="0" class="table" width="55%">
														<tr>
															<td>
																<img src="'.base_url().'/assets/images/ipc_logo.png" alt="">
															</td>
															<td>
																<div style="color:#050567" align="justify">
																	This message was delivered by BOS � IPCTPK.
																	You are receiving this message because your email address are registered in our user database.
																	If you have any question or information regarding this message, or if you do not want to receive any notifications in the future, please contact our Customer Care officer.
																</div>
															</td>
														</tr>
													</table>
												</div>
											</div>
											</body>
											</html>
									';
									$this->load->library('email', $config);
									#$this->email->set_newline("\r\n");
									$this->email->from('cgs.ipc@gmail.com', 'BOS NOTIFICATION - REQUEST GATEPASS');
									$email = str_replace(';', ',', $email);
									$this->email->to($email);
									//$array_bcc = array('nuridin.mu23@gmail.com','muhammad.nuridin@edi-indonesia.co.id','salman.abdulaziz@edi-indonesia.co.id', 'cgs@indonesiaport.co.id', 'cgs.ipc@gmail.com','get@npct1.co.id');
									//$array_bcc = $mailnya;
									//array('muhammad.nuridin@edi-indonesia.co.id','sunarkocindaga@gmail.com');
									// $this->email->bcc($array_bcc);
									$this->email->subject($subject);
									$this->email->message($msg);
								}
								if ($this->email->send()){
									$email_success = 1;
									
									$SQL_MAIL = $this->db->query("SELECT ID,GROUP_CONCAT(EMAIL) AS 'EMAIL',KEGIATAN FROM reff_mail WHERE KEGIATAN = 'GATE'")->row();
									echo "Email Terkirim";
									//membuat reff number
									$dsc=count($this->hitungreffnumber());
									
									$sno=$dsc+1;
									if ($sno<10) {
										$nosec="CGO000000".$sno;
									}elseif ($sno >= 10 && $sno < 100 ) {
										$nosec="CGO00000".$sno;
									}elseif ($sno >= 100 && $sno < 1000 ) {
										$nosec="CGO0000".$sno;
									}elseif ($sno >= 1000 && $sno < 10000 ) {
										$nosec="CGO000".$sno;
									}elseif ($sno >= 10000 && $sno < 100000 ) {
										$nosec="CGO00".$sno;
									}elseif ($sno >= 100000 && $sno < 1000000 ) {
										$nosec="CGO0".$sno;
									}else{
										$nosec="CGO".$sno;
									}

									#coment today
									$this->db->where(array('ID' => $idPost));
									$this->db->update('t_request', array('KD_REQ' => 'QUEUED'));
									$this->db->where(array('ID' => $id));
									$this->db->update('t_request_cont', array('REF_NUMBER' => $nosec));
								}
							}
							return $email_success;
						}
						if($error==0){
							echo "MSG#OK#Data berhasil diproses#".site_url()."/RequestGatePass/gatepass/post";

						}else{
							echo "MSG#ERR#Data gagal diprose#";
						}
					}
				}else if($act == "request_gate_pass_karantina"){
					//print_r("sini".$id);die();
					$arridexp = explode("~", $id);
					$idPost = $arridexp[0];
					$no_cont = $arridexp[1];
					$idjin = $arridexp[2];
					//echo $idjin;
					$this->db->where('ID',$idPost);
					$this->db->update('t_request',array('WK_SEND' => date('Y-m-d H:i:s')));
					$SQL = "SELECT * FROM t_request WHERE ID = '".$idPost."'";
					$result = $func->main->get_result($SQL);
					if($result){
					foreach ($SQL->result_array() as $row => $value) {
						$arrdata = $value;
					}
					$cek = "SELECT * FROM t_request WHERE ID = ".$idPost;
					$resCek = $this->db->query($cek)->row();
					$resultDok = $this->db->query($cek)->result_array();
					//echo $cek;
					//print_r($resultDok);die();
					$jmlh = count($resCek);
						
						/*$SQLMail = "SELECT A.ID_IJIN, A.ANGKUTNAMA_TPS,
							A.NO_RESPON AS 'NOMOR_DOKUMEN', A.TG_RESPON,
							(SELECT C.nm_trader FROM t_lic_hdr C WHERE C.NO_IJIN = A.NO_RESPON) AS CONSIGNEE,(SELECT C.NPWP
								FROM t_lic_hdr C
								WHERE C.NO_IJIN = A.NO_RESPON) AS NPWP,(SELECT WK_REQ FROM t_request D WHERE D.NO_DOK = A.NO_RESPON) AS 'WK_REQ',
								B.NO_CONT, B.UKURAN FROM t_ppk_hdr A, 
								t_ppk_cont B WHERE A.ID_IJIN = B.ID_IJIN AND B.ID_IJIN =  '".$idjin."' AND B.NO_CONT IN($no_cont)";
						$SQLMail = "SELECT D.NPWP, D.NM_TRADER AS 'NM_PARTNER', C.ANGKUTNAMA_TPS, B.NO_CONT, A.NO_DOK,A.TGL_DOK,A.WK_REQ
									FROM t_request A
									INNER JOIN t_request_cont B ON A.ID = B.ID
									INNER JOIN t_ppk_hdr C ON A.NO_DOK = C.NO_RESPON
									INNER JOIN t_lic_hdr D ON C.ID_IJIN = D.ID_IJIN
									WHERE B.ID_IJIN =  '".$idjin."' AND B.NO_CONT IN($no_cont)";*/
						//echo $resultDok[0]['JNS_DOK'];die();
						if($resultDok[0]['JNS_DOK'] == 83){
							$SQLMail = "SELECT distinct A.ID_IJIN AS ID, A.ANGKUTNAMA_TPS,A.NO_RESPON AS 'NOMOR_DOKUMEN', A.TG_RESPON AS 'TGL_DOK',C.NPWP,C.NM_TRADER AS CONSIGNEE, D.WK_REQ, B.NO_CONT, B.UKURAN
										FROM t_ppk_hdr A
										left join t_ppk_cont B on A.ID_IJIN = B.ID_IJIN 
										left join t_lic_hdr C on C.NO_IJIN=A.NO_RESPON
										left join t_request D on D.NO_DOK=A.NO_RESPON
										WHERE D.ID =  '".$idPost."' AND B.NO_CONT IN($no_cont)
										GROUP BY B.NO_CONT";
						}else{
							$SQLMail = "SELECT DISTINCT A.ID, A.ANGKUTNAMA_TPS,A.NO_DAFTAR_PABEAN AS 'NOMOR_DOKUMEN', A.TGL_DAFTAR_PABEAN AS 'TGL_DOK',A.ID_CONSIGNEE AS 'NPWP',A.CONSIGNEE AS CONSIGNEE, D.WK_REQ, B.NO_CONT, B.KD_CONT_UKURAN AS 'UKURAN'
										FROM t_permit_hdr A
										LEFT JOIN t_permit_cont B ON A.ID = B.ID
										LEFT JOIN t_request D ON D.NO_DOK=A.NO_DAFTAR_PABEAN
										WHERE A.NO_DAFTAR_PABEAN = '".$resultDok[0]['NO_DOK']."' AND B.NO_CONT IN($no_cont)
										GROUP BY B.NO_CONT";
						}
						
						//echo $SQLMail; die();
						$resultMail = $func->main->get_result($SQLMail); //print_r($resultMail); die();
						if($resultMail){
							foreach ($SQLMail->result_array() as $row2 => $valueMail) {
								$arrdataMail[] = $valueMail;
							}
							//print_r($arrdataMail);die();
							$JMLH = count($arrdataMail);
							for($c=0;$c<$JMLH;$c++){
								$tmpCont .= $arrdataMail[$c]["NO_CONT"]."-".$arrdataMail[$c]["UKURAN"].'"'. " , ";
								$CONT = rtrim($tmpCont,", ");
							}
							if($resultDok[0]['JNS_DOK'] == 83){
								$jns_dok = 'SPPMP';
							}else{
								$jns_dok = 'SPJM';
							}
							
							$email3 = $this->db->query("SELECT EMAIL,KEGIATAN, JNS_EMAIL FROM reff_mail WHERE KEGIATAN = 'GATE'")->result_array();
							for ($i=0; $i <count($email3); $i++) {

								$subject = "REQUEST GATEPASS CIC - [".$arrdataMail[0]['CONSIGNEE']."]";//"REMINDER GATEPASS";
								$email = $email3[$i]['EMAIL'];
								//print_r($email);
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
									<html lang="en">
											<head>
												<meta charset="UTF-8">
												<title>Document</title>
											</head>
											<body>
											<div align="">
												<p align="">
													Dengan Hormat,<br><br>
													Bersama ini kami informasikan data barang/container yang akan diangkut (pick up) dari terminal untuk kebutuhan pemeriksaan (behandle) dengan data sebagai berikut :
												</p>
												<table border="1" class="table" width="80%" style="width:80%;border-collapse:collapse;background:#ecf3eb">
														<tr>
															<td style="width:214px;"><b>NPWP Perusahaan</b> </td>
															<td>:</td>
															<td>'.$arrdataMail[0]['NPWP'].'</td>
														</tr>
														<tr>
															<td width=""><b>Nama Perusahaan</b> </td>
															<td>:</td>
															<td>'.$arrdataMail[0]['CONSIGNEE'].'</td>
														</tr>
														<tr>
															<td><b>Nama Kapal </b></td>
															<td>:</td>
															<td>'.$arrdataMail[0]['ANGKUTNAMA_TPS'].'</td>
														</tr>
														<tr>
															<td><b>NO. BL </b></td>
															<td>:</td>
															<td></td>
														</tr>
														<tr>
															<td><b>Nomor Container </b></td>
															<td>:</td>
															<td>'.$CONT.'</td>
														</tr>
														<tr>
															<td><b>No. Dokumen Customs </b></td>
															<td></td>
															<td></td>
														</tr>
													</table>
													<table style="width:80%;border-collapse:collapse;background:#ecf3eb" border="1">
																	<tr>
																		<td style="width:214px;"><b>PIB</b></td>
																		<td style="width: 18px;">:</td>
																		<td></td>
																		<td><b>Tanggal Dokumen Dikeluarkan</b></td>
																		<td>:</td>
																		<td></td>
																	</tr>
																	<tr>
																		<td><b>'.$jns_dok.'</b></td>
																		<td>:</td>
																		<td>'.$arrdataMail[0]['NOMOR_DOKUMEN'].'</td>
																		<td><b>Tanggal Dokumen Dikeluarkan</b></td>
																		<td>:</td>
																		<td>'.$arrdataMail[0]['TGL_DOK'].'</td>
																	</tr>
																	<tr>
																		<td><b>BC.1.1</b></td>
																		<td>:</td>
																		<td></td>
																		<td><b>Tanggal Dokumen Dikeluarkan</b></td>
																		<td>:</td>
																		<td></td>
																	</tr>
																	<tr>
																		<td><b>HI CO Scan</b></td>
																		<td>:</td>
																		<td></td>
																		<td><b>Tanggal Dokumen Dikeluarkan</b></td>
																		<td>:</td>
																		<td></td>
																	</tr>
																</table>
																<table style="width:80%;border-collapse:collapse;background:#ecf3eb" border="1" width="80%">
																<tr>
																	<td style="width:214px;"><b>Rencana Keluar</b></td>
																	<td width="2%">:</td>
																	<td>'.date('d-m-Y H:i:s',strtotime($arrdataMail[0]['WK_REQ'])).'</td>
																</tr>
															</table><br><br>
												<!-- <table border="1" class="table" width="55%">
													<tr>
														<th>No. SPK</th>
														<th>Nomor Kontainer</th>
													</tr>
													<tr>
														<td>IPC TPK/5</td>
														<td>SGSDGSD64546</td>
													</tr>
												</table> --><br>
												<div>
													Mohon kerjasamanya untuk mengirimkan data Gate Pass CIC sesuai kebutuhan diatas.<br><br>
													Atas perhatian dan kerjasamanya kami ucapkan terima kasih.<br><br>

													=================================================================================<br><br>
													<table border="0" class="table" width="55%">
														<tr>
															<td>
																<img src="'.base_url().'/assets/images/ipc_logo.png" alt="">
															</td>
															<td>
																<div style="color:#050567" align="justify">
																	This message was delivered by BOS � IPCTPK.
																	You are receiving this message because your email address are registered in our user database.
																	If you have any question or information regarding this message, or if you do not want to receive any notifications in the future, please contact our Customer Care officer.
																</div>
															</td>
														</tr>
													</table>
												</div>
											</div>
											</body>
											</html>
									';
									$this->load->library('email', $config);
									#$this->email->set_newline("\r\n");
									$this->email->from('cgs.ipc@gmail.com', 'BOS NOTIFICATION - REQUEST GATEPASS');
									$email = str_replace(';', ',', $email);
									$this->email->to($email);
									//$array_bcc = array('nuridin.mu23@gmail.com','muhammad.nuridin@edi-indonesia.co.id','salman.abdulaziz@edi-indonesia.co.id', 'cgs@indonesiaport.co.id', 'cgs.ipc@gmail.com','get@npct1.co.id');
									//$array_bcc = $mailnya;
									//array('muhammad.nuridin@edi-indonesia.co.id','sunarkocindaga@gmail.com');
									// $this->email->bcc($array_bcc);//
									$this->email->subject($subject);
									$this->email->message($msg);
								}
								if ($this->email->send()){
									$email_success = 1;
									
									$SQL_MAIL = $this->db->query("SELECT ID,GROUP_CONCAT(EMAIL) AS 'EMAIL',KEGIATAN FROM reff_mail WHERE KEGIATAN = 'GATE'")->row();
									echo "Email Terkirim".$email3[$i]['EMAIL'];
																	
									//membuat reff number
									/*$dsc=count($this->hitungreffnumber());
									
									$sno=$dsc+1;
									if ($sno<10) {
										$nosec="CGO000000".$sno;
									}elseif ($sno >= 10 && $sno < 100 ) {
										$nosec="CGO00000".$sno;
									}elseif ($sno >= 100 && $sno < 1000 ) {
										$nosec="CGO0000".$sno;
									}elseif ($sno >= 1000 && $sno < 10000 ) {
										$nosec="CGO000".$sno;
									}elseif ($sno >= 10000 && $sno < 100000 ) {
										$nosec="CGO00".$sno;
									}elseif ($sno >= 100000 && $sno < 1000000 ) {
										$nosec="CGO0".$sno;
									}else{
										$nosec="CGO".$sno;
									}

									#coment today
									$this->db->where(array('ID' => $idPost));
									$this->db->update('t_request', array('KD_REQ' => 'QUEUED'));
									$this->db->where(array('ID' => $id));
									$this->db->update('t_request_cont', array('REF_NUMBER' => $nosec));*/
								}
							}
							return $email_success;
						}
						
					}
				}
			}else if($type == "update"){
				if ($act == "fl_finish") {
					$operatornya = $this->session->userdata('USERLOGIN');
					$dataArr = explode("~", $id);
					$idPost = $dataArr[0];
					$kode_dok = $dataArr[1];
					$this->db->where('id',$idPost);
					$this->db->update('t_request',array('FL_FINISH' => 'Y','OPERATOR' =>$operatornya,'WK_FINISH' => date('Y-m-d H:i:s')));
					if($error==0){
						if ($kode_dok == '83') {
							redirect('requestGatePass/gatepass');
						}else{
							redirect('requestGatePass/gatepassBC');
						}
						//redirect('requestGatePass/gatepass');
						//echo "MSG#OK#Data berhasil diproses#".site_url()."/RequestGatePass/gatepass/post";
					}else{
						echo "MSG#ERR#Data gagal diprose#";
					}
				}else if($act == "fl_finish_print"){

					$arrid = explode('~', $id);
					$iddata = $arrid[0];
					$no_cont = $arrid[1];

					$this->db->where(array('ID' => $iddata, 'NO_CONT' => $no_cont));
					$this->db->update('t_request_cont', array('FLAG_FINISH_PRINT' => 'Y'));
				}else if($act == "paidthrought"){
					$cekCont = $this->input->post('ceklis');
					$tmp = '';
					$row = count($cekCont);
					for ($i=0; $i < $row; $i++) { 
						$tmp .= "'".$cekCont[$i]."',";
					}
					$no_cont = rtrim($tmp,",");
					$arrid = explode('~', $id);
					$iddata = $arrid[0];
					$paidthrought = $arrid[1];
					$idarr = $arrid[2].'~'.$no_cont;
					/*print_r($idarr);die();*/

					#today coment

					$this->db->where('ID',$iddata);
					$this->db->update('t_request',array('WK_REQ' => $paidthrought));

					$this->execute('save','request_gate_pass',$idarr);
				}else if($act == "paidthrought_karantina"){
					
					$cekCont = $this->input->post('ceklis');
					//print_r($cekCont);die();
					$tmp = '';
					$row = count($cekCont);
					for ($i=0; $i < $row; $i++) { 
						$tmp .= "'".$cekCont[$i]."',";
					}
					$no_cont = rtrim($tmp,",");
					$arrid = explode('~', $id);
					$iddata = $arrid[0];
					$paidthrought = $arrid[1];
					//$paidnobl = $arrid[3];
					$id_ijin = $arrid[2];
					$idarr = $iddata.'~'.$no_cont.'~'.$id_ijin;
					//print_r($idarr);die();

					$SQLMail = "SELECT NO_CONT FROM t_request_cont WHERE id='$iddata'"; //print_r($SQLMail); die();
						//echo $SQLMail;
						$resultMail = $func->main->get_result($SQLMail);
						if($resultMail){
							foreach ($SQLMail->result_array() as $row2 => $valueMail) {
								$arrdataMail[0] = $valueMail;
								$datacont = $arrdataMail[0]['NO_CONT'];
								//print_r($datacont); die();
								$dsc=$this->hitungreffnumber();
								//print_r($dsc[0]['ID']); die();
						
								$sno=$dsc[0]['ID']+1;
								if ($sno<10) {
									$nosec="CGO000000".$sno;
								}elseif ($sno >= 10 && $sno < 100 ) {
									$nosec="CGO00000".$sno;
								}elseif ($sno >= 100 && $sno < 1000 ) {
									$nosec="CGO0000".$sno;
								}elseif ($sno >= 1000 && $sno < 10000 ) {
									$nosec="CGO000".$sno;
								}elseif ($sno >= 10000 && $sno < 100000 ) {
									$nosec="CGO00".$sno;
								}elseif ($sno >= 100000 && $sno < 1000000 ) {
									$nosec="CGO0".$sno;
								}else{
									$nosec="CGO".$sno;
								}
								$this->db->where(array('ID' => $id, 'NO_CONT'=> $datacont));
								$this->db->update('t_request_cont', array('REF_NUMBER' => $nosec));
								$this->db->insert('t_sequence', array('NAMA' => $nosec));
							}
							/**///$this->db->where(array('ID' => $idPost));  
								//print_r($nosec); die();
								//$this->db->update('t_request', array('KD_REQ' => 'QUEUED'));
								
								

						}
						#coment today				

						/**/$this->db->where('ID',$iddata);
								$this->db->update('t_request',array('WK_REQ' => $paidthrought, 'KD_REQ' => 'QUEUED'));

								$this->execute('save','request_gate_pass_karantina',$idarr);
					
								if($error==0){
									echo "MSG#OK#Data berhasil diproses#".site_url()."/RequestGatePass/gatepass/post";
								}else{
									echo "MSG#ERR#Data gagal diprose#";
								}
					#today coment

					
				}
			}
		}
	}
				/*else if($act == "paidthrought_karantina"){
					
					$cekCont = $this->input->post('ceklis');
					//print_r($cekCont);die();
					$tmp = '';
					$row = count($cekCont);
					for ($i=0; $i < $row; $i++) { 
						$tmp .= "'".$cekCont[$i]."',";
					}
					$no_cont = rtrim($tmp,",");
					$arrid = explode('~', $id);
					$iddata = $arrid[0];
					$paidthrought = $arrid[1];
					$id_ijin = $arrid[2];
					$idarr = $arrid[0].'~'.$no_cont.'~'.$id_ijin;
					//print_r($idarr);die();

					#today coment

					$this->db->where('ID',$iddata);
					$this->db->update('t_request',array('WK_REQ' => $paidthrought));

					$this->execute('save','request_gate_pass_karantina',$idarr);
					
					if($error==0){
						echo "MSG#OK#Data berhasil diproses#".site_url()."/RequestGatePass/gatepass/post";
					}else{
						echo "MSG#ERR#Data gagal diprose#";
					}
				}
			}
		}
	}*/
?>