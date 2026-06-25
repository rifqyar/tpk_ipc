<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class M_dokumen_manual extends CI_Model {

		public function __construct(){
			parent::__construct();

		}

		public function list_reqGatePass($act, $id){
			$page_title = 'REQUEST GATE PASS (DOKUMEN MANUAL)';
			$title = "REQUEST GATE PASS (DOKUMEN MANUAL)";
			$this->newtable->breadcrumb('Gate Pass', site_url()."/RequestGatePass/gatepass",'icon-home');
			$this->newtable->breadcrumb('Planning', 'javascript:void(0)','');
			$this->newtable->breadcrumb('Dokumen Gate Pass', 'javascript:void(0)','');
			$check = (grant()=="W")?true:false;
			$SQL = "SELECT DISTINCT A.ID AS 'ID',B.NAMA AS 'JENIS DOKUMEN', CONCAT('NO : ',(A.NO_DOK),'<BR>TGL : ', (DATE_FORMAT(C.TGL_DAFTAR_PABEAN,'%d-%m-%Y'))) AS 'DOKUMEN', CASE WHEN A.KD_REQ = 'DRAFT' THEN CONCAT('<span class=\"label label-danger\">',(A.KD_REQ),'</SPAN>') WHEN A.KD_REQ = 'QUEUED' THEN CONCAT('<span class=\"label label-warning\">',(A.KD_REQ),'</SPAN>') WHEN A.KD_REQ = 'SENT' THEN CONCAT('<span class=\"label label-success\">',(A.KD_REQ),'</SPAN>') WHEN A.KD_REQ = 'APPROVED' THEN CONCAT('<span class=\"label label-primary\">',(A.KD_REQ),'</SPAN>') ELSE '' END AS 'STATUS REQUEST',CASE WHEN A.FL_FINISH = 'Y' THEN '<span class=\'label label-success\'>SUDAH DI REQUEST</span>' ELSE '' END AS KETERANGAN, CASE WHEN C.STATUS_MAIL IS NULL THEN '<span class=\"label label- PRIMARY\">Email Belum Di Proses</span>' WHEN C.STATUS_MAIL = 'Email Tidak Terkirim' THEN '<span class=\"label label-danger\">Email Tidak Terkirim</span>' WHEN C.STATUS_MAIL = 'Email Terkirim' THEN '<span class=\"label label-success\">Email Terkirim</span>' END AS 'STATUS_PENGIRIMAN', CASE WHEN C.STATUS = 'N' THEN '<span style=\"color:red;font-weight:bold\">REQUEST</span>' WHEN C.STATUS = 'Y' THEN '<span style=\"color:green;font-weight:bold\">DONE</span>' ELSE 0 END AS 'STATUS'
				FROM t_request A
				LEFT JOIN reff_kode_dok_bc B ON A.JNS_DOK = B.ID
				LEFT JOIN t_request_cont F ON A.ID = F.ID
				LEFT JOIN t_permit_hdr C ON A.NO_DOK = C.NO_DAFTAR_PABEAN AND A.JNS_DOK = C.KD_DOK_INOUT AND C.FL_MANUAL = 'Y'
				LEFT JOIN t_permit_cont D ON C.ID = D.ID
				INNER JOIN t_cocostscont_new E ON E.NO_CONT=F.NO_CONT
				LEFT JOIN t_cocostshdr H ON H.NM_ANGKUT = C.ANGKUTNAMA_TPS AND H.NO_VOY_FLIGHT = C.ANGKUTNO_TPS";

			$proses = array('',
							'');

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
		
		public function list_reqGatePassBc_Old($act, $id){
			$func = get_instance();
        	$func->load->model("m_main", "main", true);
			$page_title = 'REQUEST GATE PASS (DOKUMEN MANUAL)';
			$title = "REQUEST GATE PASS (DOKUMEN MANUAL)";

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
					WHERE A.JNS_DOK  IN ('19','80','81','82') AND C.FL_MANUAL = 'Y' AND F.ISO_CODE IS NOT NULL";
			$proses = array('','',
							'');
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
			$page_title = 'REQUEST GATE PASS (DOKUMEN MANUAL)';
			$title = "REQUEST GATE PASS (DOKUMEN MANUAL)";

			$check = (grant()=="W")?true:false;
				
				
			$SQLTEMP1 = "SELECT DISTINCT A.ID AS 'ID',B.NAMA AS 'JENIS DOKUMEN', CONCAT('NO : ',(A.NO_DOK),'  ',CASE WHEN C.FL_MANUAL = 'Y' THEN '<span class=\"label label-primary\">Input Manual</span>'
					WHEN C.FL_MANUAL = 'N' THEN  '<span class=\"label label-success\">Integrasi</span>' END,'<BR>TGL : ', (DATE_FORMAT(C.TGL_DAFTAR_PABEAN,'%d-%m-%Y'))) AS 'DOKUMEN',
A.NO_BL_AWB AS 'NO BL', C.TGL_DAFTAR_PABEAN AS 'TANGGAL', CASE WHEN A.KD_REQ = 'DRAFT' THEN CONCAT('<span class=\"label label-danger\">',(A.KD_REQ),'</SPAN>') WHEN A.KD_REQ = 'QUEUED' THEN CONCAT('<span class=\"label label-warning\">',(A.KD_REQ),'</SPAN>') WHEN A.KD_REQ = 'SENT' THEN CONCAT('<span class=\"label label-success\">',(A.KD_REQ),'</SPAN>') WHEN A.KD_REQ = 'APPROVED' THEN CONCAT('<span class=\"label label-primary\">',(A.KD_REQ),'</SPAN>') WHEN A.KD_REQ = 'INQUIRY' THEN CONCAT('<span class=\"label label-success\">',(A.KD_REQ),'</SPAN>') ELSE A.RESPONSE_REQ END AS 'STATUS_REQUEST', CASE WHEN C.STATUS_MAIL IS NULL THEN '<span class=\"label label- PRIMARY\">Email Belum Di Proses</span>' WHEN C.STATUS_MAIL = 'Email Tidak Terkirim' THEN '<span class=\"label label-danger\">Email Tidak Terkirim</span>' WHEN C.STATUS_MAIL = 'Email Terkirim' THEN '<span class=\"label label-success\">Email Terkirim</span>' END AS 'STATUS_PENGIRIMAN', CASE WHEN C.STATUS = 'N' THEN '<span style=\"color:red;font-weight:bold\">REQUEST</span>' WHEN C.STATUS = 'Y' THEN '<span style=\"color:green;font-weight:bold\">DONE</span>' ELSE 0 END AS 'STATUS', A.RESPONSE_REQ AS RESPONSE, CASE WHEN A.WK_FINISH IS NOT NULL THEN '<span class=\"label label-primary\">SELESAI</span>' ELSE '-' END AS KETERANGAN
					FROM t_request A
					LEFT JOIN reff_kode_dok_bc B ON A.JNS_DOK = B.ID
					LEFT JOIN t_request_cont F ON A.ID = F.ID
					LEFT JOIN t_permit_hdr C ON A.NO_DOK = C.NO_DAFTAR_PABEAN AND C.KD_DOK_INOUT = A.JNS_DOK  AND date(C.TGL_DAFTAR_PABEAN) = date(A.TGL_DOK)
					LEFT JOIN t_permit_cont D ON C.ID = D.ID 
					LEFT JOIN (SELECT * FROM t_permit_cont WHERE FL_PERIKSA = 'Y') Z on Z.ID = C.ID
					LEFT JOIN t_cocostscont E ON E.NO_CONT = F.NO_CONT
					LEFT JOIN t_cocostshdr H ON H.NM_ANGKUT = C.ANGKUTNAMA_TPS AND H.NO_VOY_FLIGHT = C.ANGKUTNO_TPS
					WHERE A.JNS_DOK != '83' AND C.FL_MANUAL = 'Y' AND DATE(C.TGL_DAFTAR_PABEAN) > DATE_ADD(NOW() , INTERVAL -4 MONTH)";// AND D.TIPE_CONT != 'RFR'
			$SQLTEMP2 = "SELECT DISTINCT A.ID AS 'ID',B.NAMA AS 'JENIS DOKUMEN', CONCAT('NO : ',(A.NO_DOK),'  ',CASE WHEN C.FL_MANUAL = 'Y' THEN '<span class=\"label label-primary\">Input Manual</span>'
					WHEN C.FL_MANUAL = 'N' THEN  '<span class=\"label label-success\">Integrasi</span>' END,'<BR>TGL : ', (DATE_FORMAT(C.TGL_DAFTAR_PABEAN,'%d-%m-%Y'))) AS 'DOKUMEN', A.NO_BL_AWB AS 'NO BL', C.TGL_DAFTAR_PABEAN AS 'TANGGAL', CASE WHEN A.KD_REQ = 'DRAFT' THEN CONCAT('<span class=\"label label-danger\">',(A.KD_REQ),'</SPAN>') WHEN A.KD_REQ = 'QUEUED' THEN CONCAT('<span class=\"label label-warning\">',(A.KD_REQ),'</SPAN>') WHEN A.KD_REQ = 'SENT' THEN CONCAT('<span class=\"label label-success\">',(A.KD_REQ),'</SPAN>') WHEN A.KD_REQ = 'APPROVED' THEN CONCAT('<span class=\"label label-primary\">',(A.KD_REQ),'</SPAN>') WHEN A.KD_REQ = 'INQUIRY' THEN CONCAT('<span class=\"label label-success\">',(A.KD_REQ),'</SPAN>') ELSE A.RESPONSE_REQ END AS 'STATUS_REQUEST', CASE WHEN C.STATUS_MAIL IS NULL THEN '<span class=\"label label- PRIMARY\">Email Belum Di Proses</span>' WHEN C.STATUS_MAIL = 'Email Tidak Terkirim' THEN '<span class=\"label label-danger\">Email Tidak Terkirim</span>' WHEN C.STATUS_MAIL = 'Email Terkirim' THEN '<span class=\"label label-success\">Email Terkirim</span>' END AS 'STATUS_PENGIRIMAN', CASE WHEN C.STATUS = 'N' THEN '<span style=\"color:red;font-weight:bold\">REQUEST</span>' WHEN C.STATUS = 'Y' THEN '<span style=\"color:green;font-weight:bold\">DONE</span>' ELSE 0 END AS 'STATUS', A.RESPONSE_REQ AS RESPONSE, CASE WHEN A.WK_FINISH IS NOT NULL THEN '<span class=\"label label-primary\">SELESAI</span>' ELSE '-' END AS KETERANGAN
					FROM t_request A
					LEFT JOIN reff_kode_dok_bc B ON A.JNS_DOK = B.ID
					LEFT JOIN t_request_cont F ON A.ID = F.ID
					LEFT JOIN t_permit_hdr C ON A.NO_DOK = C.NO_DAFTAR_PABEAN AND C.KD_DOK_INOUT = A.JNS_DOK  AND date(C.TGL_DAFTAR_PABEAN) = date(A.TGL_DOK)
					LEFT JOIN t_permit_cont D ON C.ID = D.ID 
					LEFT JOIN (SELECT * FROM t_permit_cont WHERE FL_PERIKSA = 'Y') Z on Z.ID = C.ID
					LEFT JOIN t_cocostscont E ON E.NO_CONT = F.NO_CONT
					LEFT JOIN t_cocostshdr H ON H.NM_ANGKUT = C.ANGKUTNAMA_TPS AND H.NO_VOY_FLIGHT = C.ANGKUTNO_TPS
					WHERE A.JNS_DOK != '83' AND C.FL_MANUAL = 'Y' AND DATE(C.TGL_DAFTAR_PABEAN) > DATE_ADD(NOW() , INTERVAL -12 MONTH)";// AND D.TIPE_CONT != 'RFR'
			$SQLTEMP3 = "SELECT DISTINCT A.ID AS 'ID',B.NAMA AS 'JENIS DOKUMEN', CONCAT('NO : ',(A.NO_DOK),'  ',CASE WHEN C.FL_MANUAL = 'Y' THEN '<span class=\"label label-primary\">Input Manual</span>'
					WHEN C.FL_MANUAL = 'N' THEN  '<span class=\"label label-success\">Integrasi</span>' END,'<BR>TGL : ', (DATE_FORMAT(C.TGL_DAFTAR_PABEAN,'%d-%m-%Y'))) AS 'DOKUMEN', A.NO_BL_AWB AS 'NO BL', C.TGL_DAFTAR_PABEAN AS 'TANGGAL', CASE WHEN A.KD_REQ = 'DRAFT' THEN CONCAT('<span class=\"label label-danger\">',(A.KD_REQ),'</SPAN>') WHEN A.KD_REQ = 'QUEUED' THEN CONCAT('<span class=\"label label-warning\">',(A.KD_REQ),'</SPAN>') WHEN A.KD_REQ = 'SENT' THEN CONCAT('<span class=\"label label-success\">',(A.KD_REQ),'</SPAN>') WHEN A.KD_REQ = 'APPROVED' THEN CONCAT('<span class=\"label label-primary\">',(A.KD_REQ),'</SPAN>') WHEN A.KD_REQ = 'INQUIRY' THEN CONCAT('<span class=\"label label-success\">',(A.KD_REQ),'</SPAN>') ELSE A.RESPONSE_REQ END AS 'STATUS_REQUEST', CASE WHEN C.STATUS_MAIL IS NULL THEN '<span class=\"label label- PRIMARY\">Email Belum Di Proses</span>' WHEN C.STATUS_MAIL = 'Email Tidak Terkirim' THEN '<span class=\"label label-danger\">Email Tidak Terkirim</span>' WHEN C.STATUS_MAIL = 'Email Terkirim' THEN '<span class=\"label label-success\">Email Terkirim</span>' END AS 'STATUS_PENGIRIMAN', CASE WHEN C.STATUS = 'N' THEN '<span style=\"color:red;font-weight:bold\">REQUEST</span>' WHEN C.STATUS = 'Y' THEN '<span style=\"color:green;font-weight:bold\">DONE</span>' ELSE 0 END AS 'STATUS', A.RESPONSE_REQ AS RESPONSE, CASE WHEN A.WK_FINISH IS NOT NULL THEN '<span class=\"label label-primary\">SELESAI</span>' ELSE '-' END AS KETERANGAN
					FROM t_request A
					LEFT JOIN reff_kode_dok_bc B ON A.JNS_DOK = B.ID
					LEFT JOIN t_request_cont F ON A.ID = F.ID
					LEFT JOIN t_permit_hdr C ON A.NO_DOK = C.NO_DAFTAR_PABEAN AND C.KD_DOK_INOUT = A.JNS_DOK  AND date(C.TGL_DAFTAR_PABEAN) = date(A.TGL_DOK)
					LEFT JOIN t_permit_cont D ON C.ID = D.ID 
					LEFT JOIN (SELECT * FROM t_permit_cont WHERE FL_PERIKSA = 'Y') Z on Z.ID = C.ID
					LEFT JOIN t_cocostscont E ON E.NO_CONT = F.NO_CONT
					LEFT JOIN t_cocostshdr H ON H.NM_ANGKUT = C.ANGKUTNAMA_TPS AND H.NO_VOY_FLIGHT = C.ANGKUTNO_TPS
					WHERE A.JNS_DOK != '83' AND C.FL_MANUAL = 'Y'";// AND D.TIPE_CONT != 'RFR'

			if ($_POST['ajax'] == 1) {
				if ($_POST['page'] == 1) {
					$dat = "";
					$p_khusus = "";
					foreach ($_POST['form'] as $key => $value) {
						if ($value[0] != "") {
							$dat = $value[0];
							if ($key < 4) {
								$p_khusus = "ada";
							}
						}
					}
					if ($dat == "") {
						$SQL = $SQLTEMP1;
					}else {
						if ($p_khusus == "") {
							$SQL = $SQLTEMP2;
						}else {
							$SQL = $SQLTEMP3;
						}
					}
				}else{
					$SQL = $SQLTEMP1;
				}
			}else {
				$SQL = $SQLTEMP1;
			}
			
			$proses = array('','',
							'PRINT EXCEL'  => array('EXCEL', "proces/excel/gatepassBc", '0','','md-file-text','','menu'));

			$this->newtable->multiple_search(true);
			$this->newtable->show_chk(false);
			$this->newtable->show_menu($check);
			$this->newtable->show_search(true);
			$arr_dok = array(""=>"","SPJM"=>"SPJM","SPPMP"=>"SPPMP");
			$arr_sts = array(""=>"","Email"=>"Email Terkirim","Email Tidak Terkirim"=>"Email Tidak Terkirim");
			$arr_sts2 = array(""=>"","DRAFT"=>"DRAFT","QUEUED" => "QUEUED", "SENT" => "SENT", "APPROVED" => "APPROVED", "REJECTED" => "REJECTED", "ERROR" => "ERROR", "INQUIRY" => "INQUIRY", "BYPASS" => "BYPASS");
			$this->newtable->search(array(array('F.NO_CONT','NO. KONTAINER'),array('C.ANGKUTNAMA_TPS','NAMA KAPAL'),array('C.ANGKUTNO_TPS','NO. VOYAGE'),array('A.NO_DOK','NO. DOKUMEN'),array('A.KD_REQ','STATUS PENGIRIMAN','OPTION',$arr_sts2),array('C.STATUS_MAIL ','STATUS PENGIRIMAN','OPTION',$arr_sts)));
			$this->newtable->action(site_url() . "/requestGatePass/gatepassBc");
			if($check) $this->newtable->detail(array('POPUP',"requestGatePass/gatepassBc/gate_pass_request_detail"));
			$this->newtable->tipe_proses('button');
			$this->newtable->hiddens(array("ID","NO_CONT","STATUS_PENGIRIMAN", "STATUS","TANGGAL"));
			$this->newtable->keys(array("ID"));
			$this->newtable->cidb($this->db);
			$this->newtable->orderby("A.WK_FINISH ASC,C.TGL_DAFTAR_PABEAN DESC"); 
			$this->newtable->sortby("");
			$this->newtable->groupby();
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
		public function list_reqGatePassJoin($act, $id){
			$func = get_instance();
        	$func->load->model("m_main", "main", true);
			$page_title = 'REQUEST GATE PASS (DOKUMEN MANUAL)';
			$title = "REQUEST GATE PASS (DOKUMEN MANUAL)";

			$check = (grant()=="W")?true:false;
				
			$SQL = "SELECT distinct cc.ID,
			CONCAT('No: ',(aa.LNSW_NOAJU),'<BR>Tanggal: ', (DATE_FORMAT(aa.LNSW_TGLAJU,'%d-%m-%Y'))) AS 'DOKUMEN JOIN INSPECTION',
			CONCAT('No: ','<span class=\"label label-success\">',(aa.no_respon),'</SPAN>','<BR>Tanggal: ', (DATE_FORMAT(aa.tg_respon,'%d-%m-%Y'))) AS 'DOKUMEN KARANTINA',CONCAT('No: ','<span class=\"label label-danger\">',(aa.no_daftar_pabean),'</SPAN>','<BR>Tanggal: ', (DATE_FORMAT(aa.tgl_daftar_pabean,'%d-%m-%Y'))) AS 'DOKUMEN BEA CUKAI',cc.NO_BL_AWB as 'NO BL',
			CASE WHEN CC.KD_REQ = 'DRAFT' THEN CONCAT('<span class=\"label label-danger\">',(CC.KD_REQ),'</SPAN>') 
			WHEN CC.KD_REQ = 'QUEUED' THEN CONCAT('<span class=\"label label-warning\">',(CC.KD_REQ),'</SPAN>') 
			WHEN CC.KD_REQ = 'SENT' THEN CONCAT('<span class=\"label label-success\">',(CC.KD_REQ),'</SPAN>') 
			WHEN CC.KD_REQ = 'APPROVED' THEN CONCAT('<span class=\"label label- PRIMARY\">',(CC.KD_REQ),'</SPAN>') 
			WHEN CC.KD_REQ = 'INQUIRY' THEN CONCAT('<span class=\"label label-success\">',(CC.KD_REQ),'</SPAN>') 
			ELSE cc.RESPONSE_REQ END AS 'STATUS REQUEST',
			cc.RESPONSE_REQ AS RESPONSE, CASE WHEN cc.WK_FINISH IS NOT NULL THEN '<span class=\"label label-primary\">SELESAI</span>' ELSE '-' END AS KETERANGAN
			FROM v_ppk_permit_join aa
			JOIN (
				SELECT a.id,a.kd_req,a.response_req,a.no_dok,tgl_dok,b.NO_CONT,a.NO_BL_AWB,a.WK_FINISH from t_request a JOIN t_request_cont b ON a.id = b.id) cc ON aa.NO_RESPON = cc.no_dok AND aa.TG_RESPON = cc.tgl_dok AND aa.NO_CONT = cc.NO_CONT";
			
			$proses = array(''
							// 'PRINT EXCEL'  => array('EXCEL', "proces/excel/gatepassBc", '0','','md-file-text','','menu')
							);

			$this->newtable->multiple_search(true);
			$this->newtable->show_chk(false);
			$this->newtable->show_menu($check);
			$this->newtable->show_search(true);
			$arr_dok = array(""=>"","SPJM"=>"SPJM","SPPMP"=>"SPPMP");
			$arr_sts = array(""=>"","Email"=>"Email Terkirim","Email Tidak Terkirim"=>"Email Tidak Terkirim");
			$arr_sts2 = array(""=>"","DRAFT"=>"DRAFT","QUEUED" => "QUEUED", "SENT" => "SENT", "APPROVED" => "APPROVED", "REJECTED" => "REJECTED", "ERROR" => "ERROR", "INQUIRY" => "INQUIRY", "BYPASS" => "BYPASS");
			$this->newtable->search(array(array('cc.NO_CONT','NO. KONTAINER'),array('cc.NO_DOK','NO. DOKUMEN')));
			$this->newtable->action(site_url() . "/requestGatePass/gatepassJoin");
			if($check) $this->newtable->detail(array('POPUP',"requestGatePass/gatepassJoin/gate_pass_request_detail"));
			$this->newtable->tipe_proses('button');
			$this->newtable->hiddens(array("id"));
			$this->newtable->keys(array("id"));
			$this->newtable->cidb($this->db);
			$this->newtable->orderby("aa.LNSW_TGLAJU desc"); 
			$this->newtable->sortby("");
			$this->newtable->groupby();
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
			$page_title = 'REQUEST GATE PASS (DOKUMEN MANUAL)';
			$title = "REQUEST GATE PASS (DOKUMEN MANUAL)";

			$check = (grant()=="W")?true:false;
			// echo var_dump($this->input->post("ajax"))."<br>";
			// echo var_dump($this->input->post("ajax"))."<br>";
			// echo var_dump($_POST['form'])."<br>";
			// $dat = "";
			// foreach ($_POST['form'] as $key => $value) {
			// 	if ($value[0] != "") {
			// 		$dat = $value[0];
			// 	}
			// }
			// echo "data = ".$dat."<br>";
			//die();
			$SQLTEMP1 = "SELECT DISTINCT A.ID AS 'ID',B.NAMA AS 'JENIS DOKUMEN', CONCAT('NO : ',(A.NO_DOK),'  ',CASE WHEN C.FL_MANUAL = 'Y' THEN '<span class=\"label label-primary\">Input Manual</span>'
WHEN C.FL_MANUAL = 'N' THEN  '<span class=\"label label-success\">Integrasi</span>' END,'<BR>TGL : ', (DATE_FORMAT(C.TG_RESPON,'%d-%m-%Y'))) AS 'DOKUMEN', A.NO_BL_AWB AS 'NO BL', CASE WHEN A.KD_REQ = 'DRAFT' THEN CONCAT('<span class=\"label label-danger\">',(A.KD_REQ),'</SPAN>') WHEN A.KD_REQ = 'QUEUED' THEN CONCAT('<span class=\"label label-warning\">',(A.KD_REQ),'</SPAN>') WHEN A.KD_REQ = 'SENT' THEN CONCAT('<span class=\"label label-success\">',(A.KD_REQ),'</SPAN>') WHEN A.KD_REQ = 'APPROVED' THEN CONCAT('<span class=\"label label- PRIMARY\">',(A.KD_REQ),'</SPAN>') WHEN A.KD_REQ = 'INQUIRY' THEN CONCAT('<span class=\"label label-success\">',(A.KD_REQ),'</SPAN>') ELSE A.RESPONSE_REQ END AS 'STATUS_REQUEST', CASE WHEN C.STATUS_MAIL IS NULL THEN '<span class=\"label label-primary\">Email Belum Di Proses</span>' WHEN C.STATUS_MAIL = 'Email Tidak Terkirim' THEN '<span class=\"label label-danger\">Email Tidak Terkirim</span>' WHEN C.STATUS_MAIL = 'Email Terkirim' THEN '<span class=\"label label-success\">Email Terkirim</span>' END AS 'STATUS_PENGIRIMAN', CASE WHEN C.STATUS = 'N' THEN '<span style=\"color:red;font-weight:bold\">REQUEST</span>' WHEN C.STATUS = 'Y' THEN '<span style=\"color:green;font-weight:bold\">DONE</span>' ELSE 0 END AS 'STATUS',A.RESPONSE_REQ AS RESPONSE, CASE WHEN A.WK_FINISH IS NOT NULL THEN '<span class=\"label label-primary\">SELESAI</span>' ELSE '-' END AS KETERANGAN
						FROM t_request A
						INNER JOIN reff_kode_dok_bc B ON A.JNS_DOK = B.ID
						INNER JOIN t_request_cont F ON A.ID = F.ID
						INNER JOIN t_ppk_hdr C ON A.NO_DOK = C.NO_RESPON
						INNER JOIN t_lic_hdr J ON C.ID_IJIN = J.ID_IJIN 
						INNER JOIN t_ppk_cont D ON C.ID_IJIN = D.ID_IJIN 
						LEFT JOIN t_cocostscont_new E ON E.NO_CONT = F.NO_CONT
						LEFT JOIN t_cocostscont I ON I.NO_CONT = F.NO_CONT
						WHERE A.JNS_DOK IN('83') AND DATE(C.TG_RESPON) > DATE_ADD(NOW() , INTERVAL -4 MONTH)";
			$SQLTEMP2 = "SELECT DISTINCT A.ID AS 'ID',B.NAMA AS 'JENIS DOKUMEN', CONCAT('NO : ',(A.NO_DOK),'  ',CASE WHEN C.FL_MANUAL = 'Y' THEN '<span class=\"label label-primary\">Input Manual</span>'
WHEN C.FL_MANUAL = 'N' THEN  '<span class=\"label label-success\">Integrasi</span>' END,'<BR>TGL : ', (DATE_FORMAT(C.TG_RESPON,'%d-%m-%Y'))) AS 'DOKUMEN', A.NO_BL_AWB AS 'NO BL', CASE WHEN A.KD_REQ = 'DRAFT' THEN CONCAT('<span class=\"label label-danger\">',(A.KD_REQ),'</SPAN>') WHEN A.KD_REQ = 'QUEUED' THEN CONCAT('<span class=\"label label-warning\">',(A.KD_REQ),'</SPAN>') WHEN A.KD_REQ = 'SENT' THEN CONCAT('<span class=\"label label-success\">',(A.KD_REQ),'</SPAN>') WHEN A.KD_REQ = 'APPROVED' THEN CONCAT('<span class=\"label label- PRIMARY\">',(A.KD_REQ),'</SPAN>') WHEN A.KD_REQ = 'INQUIRY' THEN CONCAT('<span class=\"label label-success\">',(A.KD_REQ),'</SPAN>') ELSE A.RESPONSE_REQ END AS 'STATUS_REQUEST', CASE WHEN C.STATUS_MAIL IS NULL THEN '<span class=\"label label-primary\">Email Belum Di Proses</span>' WHEN C.STATUS_MAIL = 'Email Tidak Terkirim' THEN '<span class=\"label label-danger\">Email Tidak Terkirim</span>' WHEN C.STATUS_MAIL = 'Email Terkirim' THEN '<span class=\"label label-success\">Email Terkirim</span>' END AS 'STATUS_PENGIRIMAN', CASE WHEN C.STATUS = 'N' THEN '<span style=\"color:red;font-weight:bold\">REQUEST</span>' WHEN C.STATUS = 'Y' THEN '<span style=\"color:green;font-weight:bold\">DONE</span>' ELSE 0 END AS 'STATUS',A.RESPONSE_REQ AS RESPONSE, CASE WHEN A.WK_FINISH IS NOT NULL THEN '<span class=\"label label-primary\">SELESAI</span>' ELSE '-' END AS KETERANGAN
						FROM t_request A
						INNER JOIN reff_kode_dok_bc B ON A.JNS_DOK = B.ID
						INNER JOIN t_request_cont F ON A.ID = F.ID
						INNER JOIN t_ppk_hdr C ON A.NO_DOK = C.NO_RESPON
						INNER JOIN t_lic_hdr J ON C.ID_IJIN = J.ID_IJIN 
						INNER JOIN t_ppk_cont D ON C.ID_IJIN = D.ID_IJIN 
						LEFT JOIN t_cocostscont_new E ON E.NO_CONT = F.NO_CONT
						LEFT JOIN t_cocostscont I ON I.NO_CONT = F.NO_CONT
						WHERE A.JNS_DOK IN('83') AND DATE(C.TG_RESPON) > DATE_ADD(NOW() , INTERVAL -12 MONTH)";
			$SQLTEMP3 = "SELECT DISTINCT A.ID AS 'ID',B.NAMA AS 'JENIS DOKUMEN', CONCAT('NO : ',(A.NO_DOK),'  ',CASE WHEN C.FL_MANUAL = 'Y' THEN '<span class=\"label label-primary\">Input Manual</span>'
WHEN C.FL_MANUAL = 'N' THEN  '<span class=\"label label-success\">Integrasi</span>' END,'<BR>TGL : ', (DATE_FORMAT(C.TG_RESPON,'%d-%m-%Y'))) AS 'DOKUMEN', A.NO_BL_AWB AS 'NO BL', CASE WHEN A.KD_REQ = 'DRAFT' THEN CONCAT('<span class=\"label label-danger\">',(A.KD_REQ),'</SPAN>') WHEN A.KD_REQ = 'QUEUED' THEN CONCAT('<span class=\"label label-warning\">',(A.KD_REQ),'</SPAN>') WHEN A.KD_REQ = 'SENT' THEN CONCAT('<span class=\"label label-success\">',(A.KD_REQ),'</SPAN>') WHEN A.KD_REQ = 'APPROVED' THEN CONCAT('<span class=\"label label- PRIMARY\">',(A.KD_REQ),'</SPAN>') WHEN A.KD_REQ = 'INQUIRY' THEN CONCAT('<span class=\"label label-success\">',(A.KD_REQ),'</SPAN>') ELSE A.RESPONSE_REQ END AS 'STATUS_REQUEST', CASE WHEN C.STATUS_MAIL IS NULL THEN '<span class=\"label label-primary\">Email Belum Di Proses</span>' WHEN C.STATUS_MAIL = 'Email Tidak Terkirim' THEN '<span class=\"label label-danger\">Email Tidak Terkirim</span>' WHEN C.STATUS_MAIL = 'Email Terkirim' THEN '<span class=\"label label-success\">Email Terkirim</span>' END AS 'STATUS_PENGIRIMAN', CASE WHEN C.STATUS = 'N' THEN '<span style=\"color:red;font-weight:bold\">REQUEST</span>' WHEN C.STATUS = 'Y' THEN '<span style=\"color:green;font-weight:bold\">DONE</span>' ELSE 0 END AS 'STATUS',A.RESPONSE_REQ AS RESPONSE, CASE WHEN A.WK_FINISH IS NOT NULL THEN '<span class=\"label label-primary\">SELESAI</span>' ELSE '-' END AS KETERANGAN
						FROM t_request A
						INNER JOIN reff_kode_dok_bc B ON A.JNS_DOK = B.ID
						INNER JOIN t_request_cont F ON A.ID = F.ID
						INNER JOIN t_ppk_hdr C ON A.NO_DOK = C.NO_RESPON
						INNER JOIN t_lic_hdr J ON C.ID_IJIN = J.ID_IJIN 
						INNER JOIN t_ppk_cont D ON C.ID_IJIN = D.ID_IJIN 
						LEFT JOIN t_cocostscont_new E ON E.NO_CONT = F.NO_CONT
						LEFT JOIN t_cocostscont I ON I.NO_CONT = F.NO_CONT
						WHERE A.JNS_DOK IN('83')";
			
			if ($_POST['ajax'] == 1) {
				if ($_POST['page'] == 1) {
					$dat = "";
					$p_khusus = "";
					foreach ($_POST['form'] as $key => $value) {
						if ($value[0] != "") {
							$dat = $value[0];
							if ($key < 5) {
								$p_khusus = "ada";
							}
						}
					}
					if ($dat == "") {
						$SQL = $SQLTEMP1;
					}else {
						if ($p_khusus == "") {
							$SQL = $SQLTEMP2;
						}else {
							$SQL = $SQLTEMP3;
						}
					}
				}else{
					$SQL = $SQLTEMP1;
				}
			}else {
				$SQL = $SQLTEMP1;
			}

			$proses = array('',
							'');

			$this->newtable->multiple_search(true);
			$this->newtable->show_chk(false);
			$this->newtable->show_menu($check);
			$this->newtable->show_search(true);
			$arr_dok = array(""=>"","SPJM"=>"SPJM","SPPMP"=>"SPPMP");
			$arr_sts = array(""=>"","Email Terkirim"=>"Email Terkirim","Email Tidak Terkirim"=>"Email Tidak Terkirim");
			$arr_sts2 = array(""=>"","DRAFT"=>"DRAFT","QUEUED" => "QUEUED", "SENT" => "SENT", "APPROVED" => "APPROVED", "REJECTED" => "REJECTED", "ERROR" => "ERROR", "INQUIRY" => "INQUIRY", "BYPASS" => "BYPASS");
			$arr_tipe = array(""=>"","N"=>"DRY","Y"=>"REEFER");
			$this->newtable->search(array(
			array('F.NO_CONT','NO. KONTAINER'),array('C.ANGKUTNAMA_TPS','NAMA KAPAL'),array('C.ANGKUTNO_TPS','NO. VOYAGE'),array('J.NM_TRADER','CUSTOMER'),array('A.NO_DOK','NO. DOKUMEN'),array('F.FL_REEFER','TIPE KONTAINER','OPTION',$arr_tipe),array('B.NAMA','JENIS DOKUMEN',
			'OPTION',$arr_dok),array('A.KD_REQ','STATUS PENGIRIMAN','OPTION',$arr_sts2),array('C.STATUS_MAIL ','STATUS PENGIRIMAN','OPTION',$arr_sts)));
			$this->newtable->action(site_url() . "/requestGatePass/gatepass");
			if($check) $this->newtable->detail(array('POPUP',"requestGatePass/gatepass/gate_pass_request_detail"));
			$this->newtable->tipe_proses('button');
			$this->newtable->hiddens(array("ID","NO_CONT","STATUS_PENGIRIMAN", "STATUS"));
			$this->newtable->keys(array("ID"));
			$this->newtable->cidb($this->db);
			$this->newtable->orderby("A.WK_FINISH ASC,C.TG_RESPON DESC");
			$this->newtable->sortby("");
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

		public function list_gatepassondemand($act, $id){
			$func = get_instance();
        	$func->load->model("m_main", "main", true);
			$page_title = 'GATE PASS';
			$title = "GATE PASS ON DEMAND";

			$check = (grant()=="W")?true:false;
			
			$SQL = "SELECT DISTINCT A.ID, CONCAT(C.NAMA,'<BR>',A.NO_DOK,'<BR>',A.TGL_DOK) AS 'DOKUMEN', B.NO_CONT AS 'KONTAINER', A.CONSIGNEE AS 'CUSTOMER', B.REF_NUMBER AS 'REFF NUMBER', B.KD_STATUS AS 'STATUS', B.TGL_STATUS AS 'TGL STATUS'
					FROM t_request A
					INNER JOIN t_request_cont B ON A.ID = B.ID
					INNER JOIN reff_kode_dok_bc C ON A.JNS_DOK = C.ID
					WHERE B.KD_STATUS ='APPROVED' AND B.REF_NUMBER IS NOT NULL";

			$proses = array('TARIK GATEPASS'  => array('POST',"RequestGatePass/ondemand/ondimine_gatepass", '1','','md-print','','list'));

			$this->newtable->multiple_search(true);
			$this->newtable->show_chk(false);
			$this->newtable->show_menu($check);
			$this->newtable->show_search(true);
			$this->newtable->search(array(array('B.NO_CONT','NO. KONTAINER'),array('A.NO_DOK','NO DOKUMEN'),array('B.REF_NUMBER','REF NUMBER')));
			$this->newtable->action(site_url() . "/requestGatePass/ondemand");
			$this->newtable->tipe_proses('button');
			$this->newtable->hiddens("ID");
			$this->newtable->keys("ID");
			$this->newtable->cidb($this->db);
			$this->newtable->orderby("B.TGL_STATUS");
			$this->newtable->sortby("DESC");
			$this->newtable->groupby(array("A.NO_DOK"));
			$this->newtable->set_formid("tblrequestgatepassondimine");
			$this->newtable->set_divid("divtblrequestgatepassondimine");
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

		public function list_gatepassondemand_api($act, $id){
			$func = get_instance();
        	$func->load->model("m_main", "main", true);
			$page_title = 'GATE PASS';
			$title = "GATE PASS ON DEMAND API";

			$check = (grant()=="W")?true:false;
			
			$SQL = "SELECT DISTINCT A.ID, CONCAT(C.NAMA,'<BR>',A.NO_DOK,'<BR>',A.TGL_DOK) AS 'DOKUMEN', B.NO_CONT AS 'KONTAINER', A.CONSIGNEE AS 'CUSTOMER', B.REF_NUMBER AS 'REFF NUMBER', B.KD_STATUS AS 'STATUS', B.TGL_STATUS AS 'TGL STATUS'
					FROM t_request A
					INNER JOIN t_request_cont B ON A.ID = B.ID
					INNER JOIN reff_kode_dok_bc C ON A.JNS_DOK = C.ID
					WHERE B.KD_STATUS ='APPROVED' AND B.REF_NUMBER IS NOT NULL";

			$proses = array('TARIK GATEPASS'  => array('POST',"RequestGatePass/ondemand_api/ondimine_gatepass_api", '1','','md-print','','list'));

			$this->newtable->multiple_search(true);
			$this->newtable->show_chk(false);
			$this->newtable->show_menu($check);
			$this->newtable->show_search(true);
			$this->newtable->search(array(array('B.NO_CONT','NO. KONTAINER'),array('A.NO_DOK','NO DOKUMEN'),array('B.REF_NUMBER','REF NUMBER')));
			$this->newtable->action(site_url() . "/requestGatePass/ondemand_api");
			$this->newtable->tipe_proses('button');
			$this->newtable->hiddens("ID");
			$this->newtable->keys("ID");
			$this->newtable->cidb($this->db);
			$this->newtable->orderby("B.TGL_STATUS");
			$this->newtable->sortby("DESC");
			$this->newtable->groupby(array("A.NO_DOK"));
			$this->newtable->set_formid("tblrequestgatepassondimine_api");
			$this->newtable->set_divid("divtblrequestgatepassondimine_api");
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

		public function get_data($act, $id, $store){
			$func = get_instance();
        	$func->load->model("m_main", "main");
        	if ($act == 'gate_pass_request_detail') {
				$getJnsDok = "SELECT JNS_DOK FROM t_request WHERE id = '$id'";
				$restultDok = $this->db->query($getJnsDok)->result_array();
				$jns_dokumen = $restultDok[0]['JNS_DOK'];
				if($jns_dokumen == 83){
					$SQL = "SELECT B.*, E.NAMA, A.CONSIGNEE, '83' AS KD_DOK, G.ISO_CODE AS 'ISO_CODE_DETAIL'
					FROM t_request A
					LEFT JOIN t_request_cont B ON B.ID = A.ID
					LEFT JOIN t_ppk_hdr C ON A.NO_DOK = C.NO_RESPON
					LEFT JOIN t_ppk_cont D ON C.ID_IJIN = D.ID_IJIN
					LEFT JOIN reff_status_cont E ON E.ID = D.KD_STATUS
					LEFT JOIN t_lic_hdr F ON C.NO_RESPON = F.NO_IJIN
					LEFT JOIN t_cocostscont G ON B.NO_CONT = G.NO_CONT
					WHERE A.id = '$id'
					GROUP BY B.NO_CONT
					ORDER BY B.FLAG_FINISH_PRINT = 'Y' ASC";
				} else {
					$SQL = "SELECT B.*, E.NAMA, A.CONSIGNEE, C.KD_DOK_INOUT AS KD_DOK, G.ISO_CODE AS 'ISO_CODE_DETAIL',D.FL_PERIKSA
							FROM t_request A
							LEFT JOIN t_request_cont B ON B.ID = A.ID
							LEFT JOIN t_permit_hdr C ON A.NO_DOK = C.NO_DAFTAR_PABEAN AND C.KD_DOK_INOUT = A.JNS_DOK
							LEFT JOIN t_permit_cont D ON C.ID = D.ID AND B.NO_CONT = D.NO_CONT
							LEFT JOIN reff_status_cont E ON E.ID = D.KD_STATUS
							LEFT JOIN t_cocostscont G ON B.NO_CONT = G.NO_CONT
							WHERE A.id = '$id' AND C.FL_MANUAL = 'Y'
							GROUP BY B.NO_CONT
							ORDER BY B.FLAG_FINISH_PRINT = 'Y' ASC";
				}
				//echo $SQL;
				$result = $this->db->query($SQL);
				return $result->result();
			}else if ($act == 'gate_pass_request_detailjoin') {
				$getJnsDok = "SELECT JNS_DOK FROM t_request WHERE id = '$id'";
				$restultDok = $this->db->query($getJnsDok)->result_array();
				$jns_dokumen = $restultDok[0]['JNS_DOK'];
				if($jns_dokumen == 83){
					$SQL = "SELECT B.*, E.NAMA, A.CONSIGNEE, '83' AS KD_DOK, G.ISO_CODE AS 'ISO_CODE_DETAIL',FL_LNSW_PERIKSA as 'FL_PERIKSA'
					FROM t_request A
					LEFT JOIN t_request_cont B ON B.ID = A.ID
					LEFT JOIN t_ppk_hdr C ON A.NO_DOK = C.NO_RESPON
					LEFT JOIN t_ppk_cont D ON C.ID_IJIN = D.ID_IJIN
					LEFT JOIN reff_status_cont E ON E.ID = D.KD_STATUS
					LEFT JOIN t_lic_hdr F ON C.NO_RESPON = F.NO_IJIN
					LEFT JOIN t_cocostscont G ON B.NO_CONT = G.NO_CONT
					WHERE A.id = '$id'
					GROUP BY B.NO_CONT
					ORDER BY B.FLAG_FINISH_PRINT = 'Y' ASC";
				} else {
					$SQL = "SELECT B.*, E.NAMA, A.CONSIGNEE, C.KD_DOK_INOUT AS KD_DOK, G.ISO_CODE AS 'ISO_CODE_DETAIL',D.FL_PERIKSA
							FROM t_request A
							LEFT JOIN t_request_cont B ON B.ID = A.ID
							LEFT JOIN t_permit_hdr C ON A.NO_DOK = C.NO_DAFTAR_PABEAN AND C.KD_DOK_INOUT = A.JNS_DOK
							LEFT JOIN t_permit_cont D ON C.ID = D.ID AND B.NO_CONT = D.NO_CONT
							LEFT JOIN reff_status_cont E ON E.ID = D.KD_STATUS
							LEFT JOIN t_cocostscont G ON B.NO_CONT = G.NO_CONT
							WHERE A.id = '$id' AND C.FL_MANUAL = 'Y'
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
							INNER JOIN t_cocostshdr H ON H.NM_ANGKUT=C.ANGKUTNAMA_TPS AND H.NO_VOY_FLIGHT=C.ANGKUTNO_TPS AND C.FL_MANUAL = 'Y' 
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
	
    	public function hitungreffnumber(){
    		$data=$this->db->query("SELECT ID FROM t_sequence ORDER BY ID DESC LIMIT 1");
    		return $data->result_array();
    	}

		public function execute($type, $act, $id) {
			//echo $type." - ".$act." - ".$id;
			// die();
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
									WHERE A.ID = '".$idPost."' AND C.FL_MANUAL = 'Y'
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
							//$email3 = $this->db->query("SELECT EMAIL,KEGIATAN, JNS_EMAIL FROM reff_mail WHERE KEGIATAN = 'GATE'")->result_array();
							//for ($i=0; $i <count($email3); $i++) {
								$subject = "REQUEST GATEPASS CIC - [".$arrdataMail[0]['CONSIGNEE']."]";//"REMINDER GATEPASS";
								//$email = $email3[$i]['EMAIL'];
								//print_r($email);
								$this->load->helper('email');
								$email_success = 0;
								//if(valid_email($email)){
									$config = array(
										'protocol'  => 'smtp',
										'smtp_host' => 'mail2.edi-indonesia.co.id',
										'smtp_port' => 25,
										'smtp_user' => '',
										'smtp_timeout' => 30,
										'smtp_pass' => '',
										'mailtype'  => 'html',
										'charset'   => 'iso-8859-1',
										'wrapchars' => 100,
										'crlf'         => "\r\n",
										'newline'     => "\r\n",
										'start_tls' => TRUE
									);
									$msg = '
									<!DOCTYPE html>
									<html lang="en">
									<head>
										<meta charset="UTF-8">
										<title>Document</title>
									</head>
									
									<body>
										<div>
											<p>
												Dengan Hormat,<br><br>
												Bersama ini kami informasikan data barang/container yang akan diangkut (pick up) dari terminal untuk
												kebutuhan pemeriksaan (behandle) dengan data sebagai berikut :
											</p>
											<table class="table" style="width:80%;border-collapse:collapse;background:#ecf3eb">
												<tr>
													<td style="width:214px;"><b>NPWP Perusahaan</b> </td>
													<td>:</td>
													<td>'.$arrdataMail[0]['NPWP'].'</td>
												</tr>
												<tr>
													<td><b>Nama Perusahaan</b> </td>
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
											<table style="width:80%;border-collapse:collapse;background:#ecf3eb">
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
											<table style="width:80%;border-collapse:collapse;background:#ecf3eb">
												<tr>
													<td style="width:214px;"><b>Rencana Keluar</b></td>
													<td>:</td>
													<td>'.date('d-m-Y H:i:s',strtotime($arrdataMail[0]['WK_REQ'])).'</td>
												</tr>
											</table><br><br>
											<!-- <table border="1" class="table" width="55%">
																						<tr>
																							<th>No. SPK</th>
																							<th>Nomor Kontainer</th>
																						</tr>
																						<tr>
																							<td>PT. MTI/5</td>
																							<td>SGSDGSD64546</td>
																						</tr>
																					</table> --><br>
											<div>
												Mohon kerjasamanya untuk mengirimkan data Gate Pass CIC sesuai kebutuhan diatas.<br><br>
												Atas perhatian dan kerjasamanya kami ucapkan terima kasih.<br><br>
									
												=================================================================================<br><br>
												<table class="table">
													<tr>
														<td>
															<img src="'.base_url().'/assets/images/Logomti.png" alt="">
														</td>
														<td>
															<div style="color:#050567">
																This message was delivered by BOS � PT. MTI.
																You are receiving this message because your email address are registered in our user
																database.
																If you have any question or information regarding this message, or if you do not want to
																receive any notifications in the future, please contact our Customer Care officer.
															</div>
														</td>
													</tr>
												</table>
											</div>
										</div>
									</body>
									
									</html>';
									$emailcustomrr = array('billing@npct1.co.id','automail@multiterminal.co.id','GATE@NPCT1.CO.ID','YAYANCHY@GMAIL.COM');
									$this->load->library('email', $config);
									#$this->email->set_newline("\r\n");
									$this->email->from('automail@multiterminal.co.id', 'BOS NOTIFICATION - REQUEST GATEPASS');
									//$email = str_replace(';', ',', $email);
									$this->email->to($emailcustomrr);
									//$array_bcc = array('nuridin.mu23@gmail.com','muhammad.nuridin@edi-indonesia.co.id','salman.abdulaziz@edi-indonesia.co.id', 'cgs@indonesiaport.co.id', 'automail@multiterminal.co.id','get@npct1.co.id');
									//$array_bcc = $mailnya;
									//array('muhammad.nuridin@edi-indonesia.co.id','sunarkocindaga@gmail.com');
									// $this->email->bcc($array_bcc);
									$this->email->subject($subject);
									$this->email->message($msg);
								//}
								if ($this->email->send()){
									//$deb = $this->email->print_debugger();
									//$this->db->query("INSERT INTO log_email_solver (`email`, `status`, `debugger`) VALUES ('$msg', '1', 'deb')");
									$email_success = 1;
									
									$SQL_MAIL = $this->db->query("SELECT ID,GROUP_CONCAT(EMAIL) AS 'EMAIL',KEGIATAN FROM reff_mail WHERE KEGIATAN = 'GATE'")->row();
									echo "Email Terkirim 1";
									//membuat reff number
									//echo $this->email->print_debugger();
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
									$this->db->update('t_request_cont', array('REF_NUMBER' => $nosec ,'KD_STATUS' => 'QUEUED'));
								}else{
									echo "tidak terkirim 1";
									//$deb = $this->email->print_debugger();
									//$this->db->query("INSERT INTO log_email_solver (`email`, `status`, `debugger`) VALUES ('$msg', '0', 'deb')");
								}
							//}
							return $email_success;
						}
						if($error==0){
							echo "MSG#OK#Data berhasil diproses#".site_url()."/RequestGatePass/gatepass/post";

						}else{
							echo "MSG#ERR#Data gagal diprose#";
						}
					}
				}else if($act == "request_gate_pass_karantina"){
					$arridexp = explode("~", $id);
					$idPost = $arridexp[0];
					$no_cont = $arridexp[1];
					$idjin = $arridexp[2];
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
						$jmlh = count($resCek);
							
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
										WHERE A.NO_DAFTAR_PABEAN = '".$resultDok[0]['NO_DOK']."' AND B.NO_CONT IN($no_cont) AND A.FL_MANUAL = 'Y'
										GROUP BY B.NO_CONT";
						}
						
						$resultMail = $func->main->get_result($SQLMail); 
						if($resultMail){
							foreach ($SQLMail->result_array() as $row2 => $valueMail) {
								$arrdataMail[] = $valueMail;
							}
							$JMLH = count($arrdataMail);
							for($c=0;$c<$JMLH;$c++){
								$tmpCont .= $arrdataMail[$c]["NO_CONT"]."-".$arrdataMail[$c]["UKURAN"].'"'. " , ";
								$CONT = rtrim($tmpCont,", ");

								/* UPDATE TO REPORT BEHANDLE */
								$SQLDokumen = $this->db->query("SELECT * FROM report_behandle WHERE NO_CONT='".$arrdataMail[$c]["NO_CONT"]."' AND REQ_ID_REQUEST_GATEPASS ='".$idPost."' ORDER BY ID DESC")->result_array();
								if(count($SQLDokumen) > 0){
									$updateReport = array(
										'REQ_ID_REQUEST_GATEPASS' => $idPost,
										'RB1_REQ_GATEPASS' 		=> date('Y-m-d H:i:s')
									);
									$this->db->where(array('NO_CONT' => $arrdataMail[$c]["NO_CONT"], 'REQ_ID_REQUEST_GATEPASS' => $idPost));
									$this->db->update('report_behandle', $updateReport);
								}
							}
							if($resultDok[0]['JNS_DOK'] == 83){
								$jns_dok = 'SPPMP';
							}else{
								$jns_dok = 'SPJM';
							}
							
							//$email3 = $this->db->query("SELECT EMAIL,KEGIATAN, JNS_EMAIL FROM reff_mail WHERE KEGIATAN = 'GATE'")->result_array();
							//for ($i=0; $i <count($email3); $i++) {

								$subject = "REQUEST GATEPASS CIC - [".$arrdataMail[0]['CONSIGNEE']."]";//"REMINDER GATEPASS";
								//$email = $email3[$i]['EMAIL'];
								$this->load->helper('email');
								$email_success = 0;
								//if(valid_email($email)){
									$config = array(
										'protocol'  => 'smtp',
										'smtp_host' => 'mail2.edi-indonesia.co.id',
										'smtp_port' => 25,
										'smtp_user' => '',
										'smtp_timeout' => 30,
										'smtp_pass' => '',
										'mailtype'  => 'html',
										'charset'   => 'iso-8859-1',
										'wrapchars' => 100,
										'crlf'         => "\r\n",
										'newline'     => "\r\n",
										'start_tls' => TRUE
									);
									$msg = '
									<!DOCTYPE html>
									<html lang="en">
									<head>
										<meta charset="UTF-8">
										<title>Document</title>
									</head>
									
									<body>
										<div>
											<p>
												Dengan Hormat,<br><br>
												Bersama ini kami informasikan data barang/container yang akan diangkut (pick up) dari terminal untuk
												kebutuhan pemeriksaan (behandle) dengan data sebagai berikut :
											</p>
											<table class="table" style="width:80%;border-collapse:collapse;background:#ecf3eb">
												<tr>
													<td style="width:214px;"><b>NPWP Perusahaan</b> </td>
													<td>:</td>
													<td>'.$arrdataMail[0]['NPWP'].'</td>
												</tr>
												<tr>
													<td><b>Nama Perusahaan</b> </td>
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
											<table style="width:80%;border-collapse:collapse;background:#ecf3eb">
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
											<table style="width:80%;border-collapse:collapse;background:#ecf3eb">
												<tr>
													<td style="width:214px;"><b>Rencana Keluar</b></td>
													<td>:</td>
													<td>'.date('d-m-Y H:i:s',strtotime($arrdataMail[0]['WK_REQ'])).'</td>
												</tr>
											</table><br><br>
											<!-- <table border="1" class="table" width="55%">
																						<tr>
																							<th>No. SPK</th>
																							<th>Nomor Kontainer</th>
																						</tr>
																						<tr>
																							<td>PT. MTI/5</td>
																							<td>SGSDGSD64546</td>
																						</tr>
																					</table> --><br>
											<div>
												Mohon kerjasamanya untuk mengirimkan data Gate Pass CIC sesuai kebutuhan diatas.<br><br>
												Atas perhatian dan kerjasamanya kami ucapkan terima kasih.<br><br>
									
												=================================================================================<br><br>
												<table class="table">
													<tr>
														<td>
															<img src="'.base_url().'/assets/images/Logomti.png" alt="">
														</td>
														<td>
															<div style="color:#050567">
																This message was delivered by BOS � PT. MTI.
																You are receiving this message because your email address are registered in our user
																database.
																If you have any question or information regarding this message, or if you do not want to
																receive any notifications in the future, please contact our Customer Care officer.
															</div>
														</td>
													</tr>
												</table>
											</div>
										</div>
									</body>
									
									</html>';
									$emailcustomrr = array('billing@npct1.co.id','automail@multiterminal.co.id','GATE@NPCT1.CO.ID','YAYANCHY@GMAIL.COM');
									$this->load->library('email', $config);
									$this->email->from('automail@multiterminal.co.id', 'BOS NOTIFICATION - REQUEST GATEPASS');
									//$email = str_replace(';', ',', $email);
									$this->email->to($emailcustomrr);
									$this->email->subject($subject);
									$this->email->message($msg);
								//}
								if ($this->email->send()){
									//$deb = $this->email->print_debugger();
									//$this->db->query("INSERT INTO log_email_solver (`email`, `status`, `debugger`) VALUES ('$msg', '1', 'deb')");
									$email_success = 1;
									echo "Terkirim 2";						
								}else{
									//$deb = $this->email->print_debugger();
									//$this->db->query("INSERT INTO log_email_solver (`email`, `status`, `debugger`) VALUES ('$msg', '0', 'deb')");
									echo "tidak terkirim 2";
								}
							//}
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

					/* INSERT TO REPORT BEHANDLE */
					$SQLDokumen = $this->db->query("SELECT * FROM t_request_cont WHERE ID ='".$idPost."'")->result_array();
					$updateReport = array(
						'RB1_APPROVE_GATEPASS' 		=> date('Y-m-d H:i:s')
					);
					$this->db->where(array('REQ_ID_REQUEST_GATEPASS' => $idPost));
					$this->db->update('report_behandle', $updateReport);


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

					/*$this->db->where('ID',$iddata);
					$this->db->update('t_request',array('WK_REQ' => $paidthrought));*/

					$this->execute('save','request_gate_pass',$idarr);
				}else if($act == "paidthrought_karantina"){	
					$cekCont = $this->input->post('ceklis');
					$cekReefer = $this->input->post('reefer');
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
					$idarr = $iddata.'~'.$no_cont.'~'.$id_ijin;
					
					if ($row == 0) {
						echo "MSG#ERR#Silahkan Pilih Kontainer yang akan di request dahulu !!";
						die();
					}
					$cekqueque = $this->db->query("SELECT KD_REQ FROM t_request WHERE ID='$iddata' and kd_req IN ('QUEUED')")->num_rows();
					if ($cekqueque > 0) {
						echo "MSG#ERR#Dokumen Sedang Di request Mohon Tunggu hingga selesai";
						die();
					}

					$CEKREEFER = "SELECT NO_CONT FROM t_request_cont WHERE NO_CONT IN($no_cont) AND FL_REEFER='Y' AND ID='$iddata'";
					$resultData = $this->db->query($CEKREEFER)->result_array();

					$JMLREEFER = count($resultData);
					
					
					if ($JMLREEFER > 0) {
						$cek_area_reefer = "SELECT DISTINCT B.NO_CONT
						FROM t_spk A INNER JOIN t_spk_cont B ON A.ID = B.ID INNER JOIN t_request C ON A.NO_DOK = C.NO_DOK AND A.TGL_DOK = C.TGL_DOK
						INNER JOIN t_request_cont D ON B.NO_CONT =  D.NO_CONT 
						WHERE D.TIPE_CONT = 'RFR' AND B.STATUS_CONT NOT IN (900,950,100)";

						$resultArea = $this->db->query($cek_area_reefer)->result_array();

						$kontainerInArea = count($resultArea);

						$totalSlot = $this->db->query("SELECT kode FROM solver_kode_billing WHERE jenis = 'RFR'")->row()->kode;
						$sisaslot = $totalSlot - $kontainerInArea;
						// echo 'total slot'.$totalSlot;
						// echo '<br>';
						// echo 'kontainer di area'.$kontainerInArea;
						// echo '<br>';
						// echo 'sisa slot'.$sisaslot;
						// echo '<br>';
						// echo 'JMLREEFER'.$JMLREEFER;
						// echo '<br>';
						// if ($JMLREEFER > $sisaslot) {
						// 	echo 'tidak masuk';
						// 	echo '<br>';
						// }else{
						// 	echo '<br>';
						// 	echo 'masuk';
						// }
						// // echo '<br>';
						// // var_dump($sisaslot);
						// die();
						if ($JMLREEFER > $sisaslot) {
							echo "MSG#ERR#Slot tidak cukup | Slot tersisa $sisaslot#";
						} else {
							foreach ($cekCont as $valcon) {
								$this->db->query("UPDATE `tpk_ipc`.`t_request_cont` SET `REQ_PILIH`='Y' WHERE  `ID`=$iddata AND `NO_CONT`='$valcon'");
							}
							$SQLMail = "SELECT REF_NUMBER, NO_CONT FROM t_request_cont WHERE id='$iddata' and REF_NUMBER IS NULL AND REQ_PILIH = 'Y'"; 
							$resultMail = $func->main->get_result($SQLMail);
							if($resultMail){
								foreach ($SQLMail->result_array() as $row2 => $valueMail) {
									$arrdataMail[0] = $valueMail;
									$datacont = $arrdataMail[0]['NO_CONT'];
									$datareff = $arrdataMail[0]['REF_NUMBER'];
									$dsc=$this->hitungreffnumber();

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

									if ($datareff == '') {
										$this->db->where(array('ID' => $id, 'NO_CONT'=> $datacont));
										$this->db->update('t_request_cont', array('REF_NUMBER' => $nosec));
										$this->db->insert('t_sequence', array('NAMA' => $nosec));
									}
									
									

									/* INSERT TO REPORT BEHANDLE */
									$SQLDokumen = $this->db->query("SELECT * FROM t_request WHERE ID ='".$iddata."'")->result_array();
									if(count($SQLDokumen) > 0){
										$SQLReport = $this->db->query("SELECT * FROM report_behandle WHERE NO_CONT='".$datacont."' AND REQ_NO_DOK='".$SQLDokumen[0]['NO_DOK']."' ORDER BY ID DESC")->result_array();
										if (count($SQLReport) > 0) {
											$updateReport = array(
												'REQ_ID_REQUEST_GATEPASS' => $id,
												'NO_CONT' 		=> $datacont,
												'REQ_JNS_DOK' 	=> $SQLDokumen[0]['JNS_DOK'],
												'REQ_NO_DOK' 	=> $SQLDokumen[0]['NO_DOK'],
												'REQ_TGL_DOK' 	=> $SQLDokumen[0]['TGL_DOK'],
												'REQ_CUSTOMER' 	=> $SQLDokumen[0]['CONSIGNEE']
											);
											$this->db->where(array('ID' => $SQLReport[0]['ID'], 'NO_CONT' => $datacont, 'REQ_NO_DOK' => $SQLDokumen[0]['NO_DOK']));
											$this->db->update('report_behandle', $updateReport);
										}else{
											$insertReport = array(
												'REQ_ID_REQUEST_GATEPASS' => $id,
												'NO_CONT' 		=> $datacont,
												'REQ_JNS_DOK' 	=> $SQLDokumen[0]['JNS_DOK'],
												'REQ_NO_DOK' 	=> $SQLDokumen[0]['NO_DOK'],
												'REQ_TGL_DOK' 	=> $SQLDokumen[0]['TGL_DOK'],
												'REQ_CUSTOMER' 	=> $SQLDokumen[0]['CONSIGNEE']
											);
											$this->db->insert('report_behandle', $insertReport);
										}
									}
								}
							}
							#coment today	
							
							$this->db->where('ID',$iddata);
							$this->db->update('t_request',array('WK_REQ' => $paidthrought, 'KD_REQ' => 'QUEUED'));
							
							$this->execute('save','request_gate_pass_karantina',$idarr);

							if($error==0){
							echo "MSG#OK#Data berhasil diproses#".site_url()."/RequestGatePass/gatepass/post";
							}else{
							echo "MSG#ERR#Data gagal diprose#";
							}
							#today coment
						}
					} else {
						foreach ($cekCont as $valcon) {
							$this->db->query("UPDATE `tpk_ipc`.`t_request_cont` SET `REQ_PILIH`='Y' WHERE  `ID`=$iddata AND `NO_CONT`='$valcon'");
						}
						$SQLMail = "SELECT REF_NUMBER, NO_CONT FROM t_request_cont WHERE id='$iddata' and REF_NUMBER IS NULL AND REQ_PILIH = 'Y'"; 
						$resultMail = $func->main->get_result($SQLMail);
						if($resultMail){
							foreach ($SQLMail->result_array() as $row2 => $valueMail) {
								$arrdataMail[0] = $valueMail;
								$datacont = $arrdataMail[0]['NO_CONT'];
								$datareff = $arrdataMail[0]['REF_NUMBER'];
								$dsc=$this->hitungreffnumber();

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

								if ($datareff == '') {
									$this->db->where(array('ID' => $id, 'NO_CONT'=> $datacont));
									$this->db->update('t_request_cont', array('REF_NUMBER' => $nosec));
									$this->db->insert('t_sequence', array('NAMA' => $nosec));
								}
								
								

								/* INSERT TO REPORT BEHANDLE */
								$SQLDokumen = $this->db->query("SELECT * FROM t_request WHERE ID ='".$iddata."'")->result_array();
								if(count($SQLDokumen) > 0){
									$SQLReport = $this->db->query("SELECT * FROM report_behandle WHERE NO_CONT='".$datacont."' AND REQ_NO_DOK='".$SQLDokumen[0]['NO_DOK']."' ORDER BY ID DESC")->result_array();
									if (count($SQLReport) > 0) {
										$updateReport = array(
											'REQ_ID_REQUEST_GATEPASS' => $id,
											'NO_CONT' 		=> $datacont,
											'REQ_JNS_DOK' 	=> $SQLDokumen[0]['JNS_DOK'],
											'REQ_NO_DOK' 	=> $SQLDokumen[0]['NO_DOK'],
											'REQ_TGL_DOK' 	=> $SQLDokumen[0]['TGL_DOK'],
											'REQ_CUSTOMER' 	=> $SQLDokumen[0]['CONSIGNEE']
										);
										$this->db->where(array('ID' => $SQLReport[0]['ID'], 'NO_CONT' => $datacont, 'REQ_NO_DOK' => $SQLDokumen[0]['NO_DOK']));
										$this->db->update('report_behandle', $updateReport);
									}else{
										$insertReport = array(
											'REQ_ID_REQUEST_GATEPASS' => $id,
											'NO_CONT' 		=> $datacont,
											'REQ_JNS_DOK' 	=> $SQLDokumen[0]['JNS_DOK'],
											'REQ_NO_DOK' 	=> $SQLDokumen[0]['NO_DOK'],
											'REQ_TGL_DOK' 	=> $SQLDokumen[0]['TGL_DOK'],
											'REQ_CUSTOMER' 	=> $SQLDokumen[0]['CONSIGNEE']
										);
										$this->db->insert('report_behandle', $insertReport);
									}
								}
							}
						}
						#coment today	
						
						$this->db->where('ID',$iddata);
						$this->db->update('t_request',array('WK_REQ' => $paidthrought, 'KD_REQ' => 'QUEUED'));
						
						$this->execute('save','request_gate_pass_karantina',$idarr);

						if($error==0){
							echo "MSG#OK#Data berhasil diproses#".site_url()."/RequestGatePass/gatepass/post";
						}else{
							echo "MSG#ERR#Data gagal diprose#";
						}
						#today coment		
					}			
				}else if($act == "ondimine_gatepass"){
					$KdAPRF = 'GETINQUIRY';
					$KD_ORG_SENDER = '0';
            		$KD_ORG_RECEIVER = '0';
					$CONF['url.wsdl'] = 'https://api.npct1.co.id/services/index.php/behandle';
					$SOAPAction = 'urn:inquiryGatepass#inquiryGatepass';
					$USERNAME_TPSONLINE_BC = 'CGO';
					$PASSWORD_TPSONLINE_BC = 'CGO@2017';
					$SQL = $this->db->query("SELECT DISTINCT B.ID, A.JNS_DOK, B.NO_CONT, B.REF_NUMBER 
											FROM t_request A INNER JOIN t_request_cont B ON A.ID = B.ID
											WHERE B.ID = '$id' AND B.KD_STATUS='APPROVED' AND B.REF_NUMBER IS NOT NULL")->row_array();
					$REF_NUMBER = $SQL['REF_NUMBER'];
					$JNS_DOK = $SQL['JNS_DOK'];
					$xml = '<soapenv:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:urn="urn:inquiryGatepass">
								<soapenv:Header/>
								<soapenv:Body>
								<urn:inquiryGatepass soapenv:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/">
									<username xsi:type="xsd:string">'.$USERNAME_TPSONLINE_BC.'</username>
									<password xsi:type="xsd:string">'.$PASSWORD_TPSONLINE_BC.'</password>
									<ref_number xsi:type="xsd:string">'.$REF_NUMBER.'</ref_number>
								</urn:inquiryGatepass>
								</soapenv:Body>
							</soapenv:Envelope>';
					$Send = $this->SendCurl1($xml, $CONF['url.wsdl'], $SOAPAction, "");
					
					$response = $this->xml2array->xml2ary($Send['response']);
					$response = $response['SOAP-ENV:Envelope']['_c']['SOAP-ENV:Body']['_c']['ns1:inquiryGatepassResponse']['_c']['return']['_v'];
					
					$xmlResponse = $this->xml2array->xml2ary($response);

					$messageErr = $xmlResponse['RETURN_DATA']['_c']['STATUS']['_v'];
					$messageInfo = $xmlResponse['RETURN_DATA']['_c']['REMARK']['_v'];

					$data = array(
						'KD_APRF' => $KdAPRF,
						'KD_ORG_SENDER' => $KD_ORG_SENDER,
						'KD_ORG_RECEIVER' => $KD_ORG_RECEIVER,
						'STR_DATA' => $response,
						'KD_STATUS' => '100',
						'TGL_STATUS' => date('Y-m-d H:i:s'),
						'KETERANGAN' => $REF_NUMBER
					);
					$this->db->insert('mailbox', $data);
						
					
					if ($messageErr) {
						echo "MSG#ERR#".$messageInfo."#";
					} else {
						echo "MSG#OK#Berhasil Tarik Gatepass Silahkan Cetak";
					}
				}else if($act == "ondimine_gatepass_api"){
					$KdAPRF = 'GETINQUIRY';
					$KD_ORG_SENDER = '0';
            		$KD_ORG_RECEIVER = '0';
					$url = "https://api.npct1.co.id:9443/api/v1/getGatePassData";
					$user = "BEHANDLE";
					$key ="5d3a2ffcb778f4b1c224f2447c048c8f";

					$SQL = $this->db->query("SELECT DISTINCT B.ID, A.JNS_DOK, B.NO_CONT, B.REF_NUMBER 
											FROM t_request A INNER JOIN t_request_cont B ON A.ID = B.ID
											WHERE B.ID = '$id' AND B.KD_STATUS='APPROVED' AND B.REF_NUMBER IS NOT NULL")->row_array();
					$REF_NUMBER = $SQL['REF_NUMBER'];
					$JNS_DOK = $SQL['JNS_DOK'];

					$xml = '<request><reff_number>'.$REF_NUMBER.'</reff_number></request>';
					// var_dump($xml);die();
					$curl = curl_init();
					curl_setopt_array($curl, array(
					CURLOPT_URL => $url,
					CURLOPT_SSL_VERIFYPEER => false,
					CURLOPT_SSL_VERIFYHOST => false,
					CURLOPT_RETURNTRANSFER => true,
					CURLOPT_ENCODING => '',
					CURLOPT_MAXREDIRS => 10,
					CURLOPT_TIMEOUT => 0,
					CURLOPT_FOLLOWLOCATION => true,
					CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
					CURLOPT_CUSTOMREQUEST => 'POST',
					CURLOPT_POSTFIELDS =>$xml,
					CURLOPT_HTTPHEADER => array(
						'User-ID: '.$user,
						'NPCT-API-Key: '.$key,
						'Content-Type: application/xml'
					),
					));
					$response = curl_exec($curl);
					if (!curl_errno($curl)) {
						$info = curl_getinfo($curl);
						echo "Connection Success , This is Url : ", $info['url'], "\r\n";
					}else{
						echo "Connection Failed =".curl_error($curl);
					}
					curl_close($curl);
					// var_dump($response);die();
					$xmlresponse = trim(strtoupper(preg_replace('/\s\s+/', '', str_replace("\n", " ", $response))));
					$xml = simplexml_load_string($response);
					$code = $xml->code;
					$status = $xml->status;
					$description = $xml->description;
					$loop = $xml->response->data->loop;
					$countloop = count($loop);
					// var_dump($countloop);die();
					if ($code == 00){
						if ($countloop > 0) {
							foreach ($loop as $value) {
								$NO_CONT = $value->cont_no;
								$TYPE_CONT = $value->reefer == 'N' ? 'DRY' : 'RFR';
								$paidthrough = Date('Y-m-d H:m:s.0', strtotime(str_replace("","-",($value->paidthrough))));
								$imdg = $value->imdg_value;
								$IMDG_VALUES = $imdg == "" ? "NULL" : "'" . $imdg . "'";
								// echo $NO_CONT;die();
								$SQL = "UPDATE t_request_cont A 
								JOIN t_request B
									ON A.ID = B.ID 
									SET A.KD_STATUS ='INQUIRY', B.KD_REQ ='INQUIRY', A.TGL_STATUS = NOW(), A.TAR = '" . $value->tar . "', A.BRUTO = '" . $value->weight . "', A.VESSEL= '" . $value->vessel_name . "', A.VOY_IN = '" . $value->voyage_in . "', A.VOY_OUT = '" . $value->voyage_out . "', A.IMO = " . $IMDG_VALUES  . ", B.SHIPPER = '" . $value->customer_name . "', A.POD1 = '" . $value->pod . "', A.POD2 = '" . $value->spod . "', A.CLOSING_TIME = '" . $paidthrough . "'
									WHERE
										A.ID = ". $id ." AND
										A.REF_NUMBER = '" . $value->reff_number . "' AND
										A.NO_CONT = '" . $NO_CONT . "'
									";
									// var_dump($SQL);die();
									$Execute = $this->db->query($SQL);
									// return $Execute;
							}
						}
						$data = array(
							'KD_APRF' => $KdAPRF,
							'KD_ORG_SENDER' => $KD_ORG_SENDER,
							'KD_ORG_RECEIVER' => $KD_ORG_RECEIVER,
							'STR_DATA' => $xmlresponse,
							'KD_STATUS' => '100',
							'TGL_STATUS' => date('Y-m-d H:i:s'),
							'KETERANGAN' => $REF_NUMBER
						);
						$this->db->insert('mailbox', $data);
						if ($Execute) {
							echo "MSG#OK#Berhasil Tarik Gatepass Silahkan Cetak";
						} else {
							$messageErr = "error update sql";
							echo "MSG#ERR#".$messageErr."#";
						}
				 	} else {
						// $messageErr = "GatePass not found";
						echo "MSG#ERR#".$description."#";
				 	}
				}

			}
		}

		// function SendCurl($xml, $url, $SOAPAction, $proxy = "", $port = "443") {
		//     $header[] = 'Content-Type: text/xml';
		//     $header[] = 'SOAPAction: "' . $SOAPAction . '"';
		//     $header[] = 'Content-length: ' . strlen($xml);
		//     $header[] = 'Connection: close';

		//     $ch = curl_init();
		//     curl_setopt($ch, CURLOPT_URL, $url);
		//     curl_setopt($ch, CURLOPT_VERBOSE, 0);
		//     curl_setopt($ch, CURLOPT_HEADER, 0);
		//     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		//     curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		//     curl_setopt($ch, CURLOPT_POST, 1);
		//     curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		//     curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
		//     curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

		//     $response = curl_exec($ch);
		//     if (!curl_errno($ch)) {
		//         $return['return'] = TRUE;
		//         $return['info'] = curl_getinfo($ch);
		//         $return['response'] = $response;
		//     } else {
		//         $return['return'] = FALSE;
		//         $return['info'] = curl_error($ch);
		//         $return['response'] = '';
		//     }
		//     return $return;
		// }
		
		function SendCurl1($xml, $url, $SOAPAction, $proxy = "", $port = "443") {
		    $header[] = 'Content-Type: text/xml';
		    $header[] = 'SOAPAction: "' . $SOAPAction . '"';
		    $header[] = 'Content-length: ' . strlen($xml);
		    $header[] = 'Connection: close';

		    $ch = curl_init();
		    curl_setopt($ch, CURLOPT_URL, $url);
		    curl_setopt($ch, CURLOPT_VERBOSE, 0);
		    curl_setopt($ch, CURLOPT_HEADER, 0);
		    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		    curl_setopt($ch, CURLOPT_POST, 1);
		    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		    curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
		    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

		    $response = curl_exec($ch);
		    if (!curl_errno($ch)) {
		        $return['return'] = TRUE;
		        $return['info'] = curl_getinfo($ch);
		        $return['response'] = $response;
		    } else {
		        $return['return'] = FALSE;
		        $return['info'] = curl_error($ch);
		        $return['response'] = '';
		    }
		    return $return;
		}
	}
?>