<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_display extends CI_Model {

	public $variable;

	public function __construct()
	{
		parent::__construct();
		
	}

	function get_data($act, $id){
			$func = get_instance();
        	$func->load->model("m_main", "main", true);
        	if($act == 'custom'){
    				 //    		$SQL = "SELECT B.NO_SPK, A.STATUS_CONT, A.NO_CONT,A.UKR_CONT,C.WK_ACTIVE,G.NAMA,A.LOKASI,A.TIER,C.JNS_KEGIATAN,B.CONSIGNEE, CASE WHEN A.STATUS_CONT = '460' THEN '<span class=\'label label-warning\'>SIAP PERIKSA</span>' WHEN A.STATUS_CONT IN ('500','540','520') THEN '<span class=\'label label-success\'>SELESAI PERIKSA</span>' ELSE '<span class=\'label label-danger\'>ANTRIAN PERIKSA</span>' END AS KETERANGAN, CASE WHEN F.START_INSP IS NOT NULL AND F.FINISH_INSP IS NULL THEN 'SEDANG PERIKSA' ELSE 'ANTRIAN PERIKSA' END AS KETERANGAN2, CASE WHEN C.FL_ACTIVE = 'Y' THEN 'ANTRIAN PERIKSA' ELSE '-' END AS KETERANGAN3, -- E.KETERANGAN, 
					// F.START_INSP
					// FROM t_spk_cont A
					// LEFT JOIN t_spk B ON A.ID = B.ID
					// LEFT JOIN t_gatepass C ON A.NO_CONT = C.NO_CONT AND C.`STATUS` = 'WAITING' -- AND C.FL_ACTIVE = 'Y'
					// INNER JOIN t_request D ON C.NO_DOK = D.NO_DOK
					// LEFT JOIN reff_status_spk E ON A.STATUS_CONT = E.ID
					// LEFT JOIN t_op_inspection F ON F.NO_CONT = A.NO_CONT AND F.FINISH_INSP IS NULL
					// LEFT JOIN reff_kode_dok_bc G ON D.JNS_DOK = G.ID
					// WHERE A.STATUS_CONT IN('460','500','510','530','540','520') AND C.FL_ACTIVE = 'Y' 
					// AND G.ID != 83
					// GROUP BY A.NO_CONT
					// ORDER BY CASE 
					// 	WHEN F.START_INSP IS NOT NULL AND F.FINISH_INSP IS NULL THEN 3 
					// 	WHEN A.STATUS_CONT = '460' THEN 2 
					// 	WHEN A.STATUS_CONT IN ('500','540','520') THEN 4 
					// 	WHEN C.FL_ACTIVE = 'Y' THEN 1 
					// ELSE 0 END ASC,C.WK_ACTIVE ASC";
        		$SQL = "SELECT C.ID AS 'ID',A.NO_SPK AS 'NO_SPK', B.NO_CONT AS 'KONTAINER',B.UKR_CONT AS 'SIZE',C.NO_DOK,G.NAMA, DATE_FORMAT(C.WK_ACTIVE, '%d-%m-%Y %h:%m:%s') AS 'WK_ACTIVE', 
					CONCAT(B.LOKASI,'0',B.TIER) AS 'LOKASI', C.JNS_KEGIATAN,I.CONSIGNEE AS 'NAMA_CUSTOMER', 
					CASE WHEN B.STATUS_CONT = '460' AND F.START_INSP IS NULL AND F.FINISH_INSP IS NULL AND C.JNS_KEGIATAN ='1' AND C.RESPON IS NOT NULL THEN 'SIAP PERIKSA' 
					WHEN B.STATUS_CONT ='460' AND C.JNS_KEGIATAN='2' AND C.RESPON IS NOT NULL  THEN 'SIAP PERIKSA'
					WHEN B.STATUS_CONT IN ('500','540','520') THEN 'SELESAI PERIKSA' 
					WHEN B.STATUS_CONT = '460' AND F.START_INSP IS NOT NULL AND F.FINISH_INSP IS NULL THEN 'SEDANG PERIKSA' ELSE 'ANTRIAN PERIKSA' END AS 'WSTATUS',C.RESPON AS 'RESPON',DATE_FORMAT(C.WK_RESPON, '%d-%m-%Y %h:%m:%s') AS 'WK_RESPON', F.START_INSP, F.FINISH_INSP, H.WK_STATUS
					FROM t_spk A
					LEFT JOIN t_spk_cont B ON A.ID = B.ID
					LEFT JOIN t_gatepass C ON B.NO_CONT = C.NO_CONT AND C.`STATUS` = 'WAITING'
					INNER JOIN t_request D ON C.NO_DOK = D.NO_DOK
					LEFT JOIN reff_status_spk E ON B.STATUS_CONT = E.ID
					LEFT JOIN t_op_inspection F ON F.NO_CONT = B.NO_CONT AND C.NO_DOK = F.NO_DOK
					LEFT JOIN reff_kode_dok_bc G ON D.JNS_DOK = G.ID
					LEFT JOIN t_job_slip H ON H.NO_CONT = B.NO_CONT AND h.LOKASI_AKHIR LIKE'%CIC%'
					LEFT JOIN t_request I ON A.NO_DOK = I.NO_DOK
					WHERE B.STATUS_CONT IN('460','500','510','530','540','520') AND G.ID != 83
					GROUP BY B.NO_CONT
					ORDER BY 
					CASE WHEN C.RESPON IS NOT NULL AND WSTATUS ='ANTRIAN PERIKSA' THEN 1 WHEN C.RESPON IS NULL AND WSTATUS='ANTRIAN PERIKSA' THEN 2  ELSE 3 END ASC,
					CASE WHEN F.START_INSP IS NOT NULL AND F.FINISH_INSP IS NULL THEN 3 WHEN B.STATUS_CONT = '460' THEN 2 WHEN B.STATUS_CONT IN ('500','540','520') THEN 4 WHEN C.FL_ACTIVE = 'Y' THEN 1 ELSE 0 END ASC,
					C.WK_RESPON asc,C.WK_ACTIVE ASC";
				$QUERY = $this->db->query($SQL);
				return $QUERY->result();
        	}elseif($act == 'karantina'){
        		$SQL = "SELECT B.NO_SPK, A.STATUS_CONT, A.NO_CONT,A.UKR_CONT,C.WK_ACTIVE,G.NAMA,A.LOKASI,A.TIER,C.JNS_KEGIATAN,B.CONSIGNEE, CASE WHEN A.STATUS_CONT = '460' THEN '<span class=\'label label-warning\'>SIAP PERIKSA</span>' WHEN A.STATUS_CONT IN ('500','540','520') THEN '<span class=\'label label-success\'>SELESAI PERIKSA</span>' ELSE '<span class=\'label label-danger\'>ANTRIAN PERIKSA</span>' END AS KETERANGAN, CASE WHEN F.START_INSP IS NOT NULL AND F.FINISH_INSP IS NULL THEN 'SEDANG PERIKSA' ELSE 'ANTRIAN PERIKSA' END AS KETERANGAN2, CASE WHEN C.FL_ACTIVE = 'Y' THEN 'ANTRIAN PERIKSA' ELSE '-' END AS KETERANGAN3, -- E.KETERANGAN, 
					F.START_INSP
					FROM t_spk_cont A
					LEFT JOIN t_spk B ON A.ID = B.ID
					LEFT JOIN t_gatepass C ON A.NO_CONT = C.NO_CONT AND C.`STATUS` = 'WAITING' -- AND C.FL_ACTIVE = 'Y'
					INNER JOIN t_request D ON C.NO_DOK = D.NO_DOK
					LEFT JOIN reff_status_spk E ON A.STATUS_CONT = E.ID
					LEFT JOIN t_op_inspection F ON F.NO_CONT = A.NO_CONT AND F.FINISH_INSP IS NULL
					LEFT JOIN reff_kode_dok_bc G ON D.JNS_DOK = G.ID
					WHERE A.STATUS_CONT IN('460','500','510','530','540','520')
					AND G.ID = 83
					GROUP BY A.NO_CONT
					ORDER BY CASE 
						WHEN F.START_INSP IS NOT NULL AND F.FINISH_INSP IS NULL THEN 3 
						WHEN A.STATUS_CONT = '460' THEN 2 
						WHEN A.STATUS_CONT IN ('500','540','520') THEN 4 
						WHEN C.FL_ACTIVE = 'Y' THEN 1 
					ELSE 0 END ASC,C.WK_ACTIVE ASC";
				$QUERY = $this->db->query($SQL);
				return $QUERY->result();
        	}elseif($act == 'penarikan'){
        		$SQL = "SELECT B.NO_SPK, A.NO_CONT,B.NO_DOK,A.UKR_CONT AS 'SIZE',A.LOKASI,B.WK_REQ AS 'TERBIT_SPK',C.NAMA AS 'JENIS_DOKUMEN', CASE WHEN A.STATUS_CONT IN('000','50','100') THEN CONCAT('<span class=\"label label-success\" style=\"font-size:1em;\">', DATEDIFF(CURRENT_DATE(), DATE_FORMAT(B.WK_REQ,'%Y-%m-%d')),' HARI</span>') ELSE '-' END AS 'LAMA_PENARIKAN',A.ID_FLAT AS 'TID', D.W_PICKUP,B.CONSIGNEE, CASE WHEN A.STATUS_CONT IN('450','510','530') THEN '<span class=\"label label-warning\">ON COMMON AREA</span>' WHEN A.STATUS_CONT = '200' THEN '<span class=\"label label-warning\"style=\"background: yellow\"><font color=\"black\">ON PROCESS</font></span>' ELSE '<span class=\"label label-success\">ON TERMINAL</span>' END AS 'STATUS_PENARIKAN'
					FROM t_spk_cont A
					INNER JOIN t_spk B ON A.id = B.id
					INNER JOIN reff_kode_dok_bc C ON C.ID = B.JNS_DOK
					LEFT JOIN t_op_pickup D ON B.NO_SPK = D.NO_SPK
					WHERE A.STATUS_CONT IN ('50','000','100','200','300','400','450','510','530') AND C.NAMA != 'SPPMP'
					ORDER BY B.WK_REQ DESC LIMIT 50";
				$QUERY = $this->db->query($SQL);
				return $QUERY->result();
        	}
	}

	public function getresponcustoms($type, $act, $id){
		$page_title = "RESPON PKB";
		$title = "RESPON PKB";
		$this->newtable->breadcrumb('Dashboard', site_url(),'icon-home');
		$this->newtable->breadcrumb('Customs', 'javascript:void(0)','');
		$this->newtable->breadcrumb('PKB', 'javascript:void(0)','');
		$check = (grant()=="W")?true:false;
		if ($this->session->userdata('KD_GROUP') == 'BC_COUNTER') {
			$addsql = " AND B.STATUS_CONT IN(460,510,530) AND C.JNS_DOK !='SPPMP'";
			$proses = array('PKB'  => array('POST',"display/respon_custom/pkb", '1','','md-layers','', 'list'));
		}else{
			$addsql = " AND B.STATUS_CONT IN(460,510,530)";
			$proses = array('PKB'  => array('POST',"display/respon_custom/respon/pkb", '1','','md-layers','', 'list'),
							'PERCEPATAN'  => array('POST',"display/respon_custom/respon/percepatan", '1','','md-layers','', 'list'));
		}

		$SQL = "SELECT DISTINCT C.ID, C.NO_DOK, C.JNS_DOK AS 'JENIS DOKUMEN', CONCAT('NO :',C.NO_DOK,'<BR>','TANGGAL :',C.TGL_DOK) AS DOKUMEN, CONCAT(B.LOKASI,B.TIER) AS LOKASI, CONCAT('BEHANDLE ',C.JNS_KEGIATAN) AS 'KETERANGAN',	C.NAMA_CUST AS 'CUSTOMER',
				CASE
					WHEN B.STATUS_CONT IN (450,510,530) AND C.RESPON IS NULL THEN '<span class=\"label label-danger\">BELUM PKB</span>'
					WHEN B.STATUS_CONT IN (450,510,530) AND C.RESPON IS NOT NULL THEN '<span class=\"label label-danger\">PKB</span>'
					WHEN B.STATUS_CONT = 460 AND D.START_INSP IS NULL AND D.FINISH_INSP IS NULL  AND C.RESPON IS NOT NULL THEN '<span class=\"label label-warning\">SIAP PERIKSA</span>'
					WHEN B.STATUS_CONT = 460 AND D.START_INSP IS NOT NULL AND D.FINISH_INSP IS NULL THEN '<span class=\"label label-primary\">SEDANG PERIKSA</span>' 
					WHEN B.STATUS_CONT IN (500,540,520) THEN '<span class=\"label label-success\">SELESAI PERIKSA</span>' 
					ELSE '' 
				END AS STATUS, 
				CONCAT('RESPON :',
					CASE 
						WHEN C.RESPON = 'PKB' THEN '<span style=\"color:green;font-weight:bold\">PKB</span>'
						ELSE '<span style=\"color:red;font-weight:bold\">PERCEPATAN</span>'
					END,'<BR>','TANGGAL PKB :',C.WK_RESPON
				)AS PKB,
				CONCAT('<span style=\"color:green;font-weight:bold\">','TOTAL KONTAINER: ',(SELECT COUNT(B.NO_CONT) FROM t_spk_cont A WHERE C.NO_CONT = A.NO_CONT),'</span>')  AS 'JUMLAH KONTAINER'
				FROM t_spk A
				INNER JOIN t_spk_cont B ON A.ID = B.ID
				INNER JOIN t_gatepass C ON B.NO_CONT = C.NO_CONT AND C.STATUS = 'WAITING' AND C.FL_ACTIVE = 'Y' AND C.JNS_DOK !='SPPMP'
				LEFT JOIN t_op_inspection D ON D.NO_CONT = B.NO_CONT AND C.NO_DOK = D.NO_DOK
				WHERE 1=1 ".$addsql."";
		$this->newtable->multiple_search(true);
		$this->newtable->show_chk(false);
		$this->newtable->show_menu($check);
		$this->newtable->show_search(true);
		$this->newtable->search(array(array('C.NO_CONT','NO. KONTAINER'),array('C.NO_DOK','NO. DOKUMEN')));
		$this->newtable->action(site_url() . "/display/respon_custom");
		$this->newtable->detail(array('POPUP',"display/respon_custom/detail"));
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("ID","NO_DOK"));
		$this->newtable->keys(array("ID","NO_DOK"));
		$this->newtable->cidb($this->db);
		$this->newtable->groupby(array("C.NO_DOK"));
		$this->newtable->orderby("CASE WHEN B.STATUS_CONT IN (450,510,530) AND C.RESPON IS NULL THEN 1 WHEN B.STATUS_CONT IN (450,510,530) AND C.RESPON IS NOT NULL THEN 2 WHEN B.STATUS_CONT = 460 AND D.START_INSP IS NULL AND D.FINISH_INSP IS NULL  AND C.RESPON IS NOT NULL THEN 3 WHEN B.STATUS_CONT = 460 AND D.START_INSP IS NOT NULL AND D.FINISH_INSP IS NULL THEN 4 ELSE 5 END ASC, C.WK_RESPON ASC,C.WK_ACTIVE ASC");
		$this->newtable->sortby("");
		$this->newtable->set_formid("tblcustoms");
		$this->newtable->set_divid("divcustoms");
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

	public function pergerakan($act, $id)
	{
		$page_title = "RESPON PKB";
		$title = "RESPON PKB";
		$this->newtable->breadcrumb('Dashboard', site_url(),'icon-home');
		$this->newtable->breadcrumb('Customs', 'javascript:void(0)','');
		$this->newtable->breadcrumb('PKB', 'javascript:void(0)','');
		$check = (grant()=="W")?true:false;
		if ($this->session->userdata('KD_GROUP') == "USR") {
			if ($this->input->post("ajax")) {
				$VAR = 1;
			}else{
				$VAR = 0;
			}
		}else{
			$$VAR = 1;
		}
		$SQL = "SELECT DISTINCT C.ID, C.JNS_DOK AS 'JENIS DOKUMEN', C.NO_DOK AS DOKUMEN, C.TGL_DOK AS 'TANGGAL DOKUMEN', C.NAMA_CUST AS 'CUSTOMER', C.NO_CONT AS 'KONTAINER', B.UKR_CONT AS 'SIZE',
				CASE
					WHEN B.STATUS_CONT IN (450,510,530) AND D.START_INSP IS NULL AND D.FINISH_INSP IS NULL AND C.RESPON IS NULL THEN '<span class=\"label label-danger\">BELUM PKB</span>'
					WHEN B.STATUS_CONT IN (450,510,530) AND D.START_INSP IS NULL AND D.FINISH_INSP IS NULL AND C.RESPON IS NOT NULL THEN '<span class=\"label label-danger\">PKB</span>'
					WHEN B.STATUS_CONT = 460 AND D.START_INSP IS NULL AND D.FINISH_INSP IS NULL  AND C.RESPON IS NOT NULL THEN '<span class=\"label label-warning\">SIAP PERIKSA</span>'
					WHEN B.STATUS_CONT = 460 AND D.START_INSP IS NOT NULL AND D.FINISH_INSP IS NULL THEN '<span class=\"label label-primary\">SEDANG PERIKSA</span>' 
					WHEN B.STATUS_CONT IN (500,540,520) THEN '<span class=\"label label-success\">SELESAI PERIKSA</span>' 
					WHEN B.STATUS_CONT IN (800,850,870,900,901,902,950) THEN '<span class=\"label label-success\">DELIVERY</span>'
					ELSE '<span class=\"label label-success\">SELESAI PERIKSA</span>' 
				END AS STATUS, 
				CASE 
					WHEN C.RESPON = 'PKB' THEN '<span style=\"color:green;font-weight:bold\">PKB</span>'
					ELSE '<span style=\"color:red;font-weight:bold\">PERCEPATAN</span>'
				END AS 'RESPON PKB',
				C.WK_RESPON AS 'WAKTU PKB',
				IF(B.LOKASI IS NULL OR B.STATUS_CONT = 900, 'DELIVERY', CONCAT(B.LOKASI, B.TIER)) AS LOKASI
				FROM t_spk A
				INNER JOIN t_spk_cont B ON A.ID = B.ID
				INNER JOIN t_gatepass C ON B.NO_CONT = C.NO_CONT AND C.FL_ACTIVE = 'Y' AND C.JNS_DOK !='SPPMP'
				LEFT JOIN t_op_inspection D ON D.NO_CONT = B.NO_CONT AND C.NO_DOK = D.NO_DOK
				WHERE 1 = $VAR C.RESPON IS NOT NULL";
		$this->newtable->multiple_search(true);
		$this->newtable->show_chk(false);
		$this->newtable->show_menu($check);
		$this->newtable->show_search(true);
		$this->newtable->search(array(array('C.NO_DOK','NO. DOKUMEN'),array('C.TGL_DOK','TGL. DOKUMEN'),array('C.NO_CONT','NO. KONTAINER')));
		$this->newtable->action(site_url() . "/display/pergerakan");
		$this->newtable->detail(array('DRILLDOWN',"display/pergerakan/detail"));
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("ID"));
		$this->newtable->keys(array("ID","DOKUMEN","KONTAINER"));
		$this->newtable->cidb($this->db);
		$this->newtable->groupby();
		$this->newtable->orderby("CASE WHEN B.STATUS_CONT IN (450,510,530) AND D.START_INSP IS NULL AND D.FINISH_INSP IS NULL AND C.RESPON IS NULL THEN 1 WHEN B.STATUS_CONT IN (450,510,530) AND D.START_INSP IS NULL AND D.FINISH_INSP IS NULL AND C.RESPON IS NOT NULL THEN 2 WHEN B.STATUS_CONT = 460 AND D.START_INSP IS NULL AND D.FINISH_INSP IS NULL AND C.RESPON IS NOT NULL THEN 3 WHEN B.STATUS_CONT = 460 AND D.START_INSP IS NOT NULL AND D.FINISH_INSP IS NULL THEN 4 WHEN B.STATUS_CONT IN (500,540,520) THEN 5 WHEN B.STATUS_CONT IN (800,850,870,900,901,902,950) THEN 6 ELSE 7 END ASC, C.WK_RESPON ASC,C.WK_ACTIVE ASC");
		$this->newtable->sortby("");
		$this->newtable->set_formid("tblcustomspergerakan");
		$this->newtable->set_divid("divcustomspergerakan");
		$this->newtable->rowcount(50);
		$this->newtable->clear();
		$this->newtable->menu();
		$tabel .= $this->newtable->generate($SQL);
		$arrdata = array("page_title" => $page_title, "title" => $title, "content" => $tabel);
		if($this->input->post("ajax")||$act == "post")
			return $tabel;
		else
			return $arrdata;
	}

	public function detail_pergerakan($act, $id)
	{
		$VAR = explode("~", $id);
		$ID = $VAR[0];
		$NO_DOK = $VAR[1];
		$NO_CONT = $VAR[2];
		$SQL = $this->db->query("SELECT DISTINCT C.ID, C.JNS_DOK, C.NO_DOK, C.TGL_DOK, C.NAMA_CUST, C.NO_CONT, B.UKR_CONT, C.WK_REK, C.WK_RESPON, E.WK_STATUS, D.START_INSP, D.FINISH_INSP
								FROM t_spk A
								INNER JOIN t_spk_cont B ON A.ID = B.ID
								INNER JOIN t_gatepass C ON B.NO_CONT = C.NO_CONT AND C.FL_ACTIVE = 'Y' AND C.JNS_DOK !='SPPMP'
								LEFT JOIN t_op_inspection D ON D.NO_CONT = B.NO_CONT AND C.NO_DOK = D.NO_DOK
								LEFT JOIN (SELECT DISTINCT NO_CONT, NO_DOK, NO_GATEPASS, LOKASI_AKHIR, WK_STATUS FROM t_job_slip A WHERE SUBSTRING(A.LOKASI_AKHIR, 1, 3) = 'CIC' GROUP BY NO_CONT ORDER BY ID_JOB_SLIP ASC) E ON C.NO_CONT = E.NO_CONT AND C.NO_DOK = E.NO_DOK
								WHERE C.ID = '".$ID."' AND C.NO_DOK ='".$NO_DOK."' AND C.NO_CONT = '".$NO_CONT."'");
		return $SQL->row_array();
	}

	public function getresponquarantine($act, $id){
		$page_title = "RESPON QUARANTINE";
		$title = "QUARANTINE";
		$this->newtable->breadcrumb('Display', site_url(),'icon-home');
		$this->newtable->breadcrumb('RESPON', 'javascript:void(0)','');
		$this->newtable->breadcrumb('QUARANTINE', 'javascript:void(0)','');
		$check = (grant()=="W")?true:false;
		$addsql = " B.STATUS_CONT IN('460','510','530') AND C.FL_ACTIVE = 'Y' AND G.ID = 83";
		
		$SQL = "SELECT C.ID AS 'ID',A.NO_SPK AS 'NO_SPK',CONCAT(B.NO_CONT,'<BR>',B.UKR_CONT) AS 'KONTAINER',CONCAT('NO :&nbsp',C.NO_DOK,'<BR>JNS :&nbsp',G.NAMA) AS 'DOKUMEN',CONCAT(B.LOKASI,'0',B.TIER) AS 'LOKASI',
				CASE WHEN C.JNS_KEGIATAN = '1' THEN 'BEHANDLE 1' WHEN C.JNS_KEGIATAN = '2' THEN 'BEHANDLE 2' END AS 'KETERANGAN',A.CONSIGNEE AS 'NAMA CUSTOMER',
				CASE WHEN B.STATUS_CONT = '460' AND F.START_INSP IS NULL AND F.FINISH_INSP IS NULL AND C.JNS_KEGIATAN ='1' AND C.RESPON IS NOT NULL THEN '<span class=\"label label-warning\">SIAP PERIKSA</span>' WHEN B.STATUS_CONT ='460' AND C.JNS_KEGIATAN='2' AND C.RESPON IS NOT NULL  THEN '<span class=\"label label-warning\">SIAP PERIKSA</span>'
				WHEN B.STATUS_CONT IN ('500','540','520') THEN '<span class=\"label label-success\">SELESAI PERIKSA</span>' 
				WHEN B.STATUS_CONT = '460' AND F.START_INSP IS NOT NULL AND F.FINISH_INSP IS NULL THEN '<span class=\"label label-primary\">SEDANG PERIKSA</span>' 
				ELSE '<span class=\"label label-danger\">ANTRIAN PERIKSA</span>' END AS 'STATUS',

				CASE WHEN C.RESPON = 'PKB PRIORITAS' THEN '<span style=\"color:green;font-weight:bold\">PKB PRIORITAS</span>' WHEN C.RESPON = 'PKB LR' THEN '<span style=\"color:green;font-weight:bold\">PKB LONGROOM</span>' WHEN C.RESPON = 'PKB YARD' THEN '<span style=\"color:green;font-weight:bold\">PKB YARD</span>' WHEN C.RESPON = 'PKB YARD N' THEN '<span style=\"color:green;font-weight:bold\">PKB YARD N</span>' ELSE '<span style=\"color:red;font-weight:bold\">NO RESPON</span>' END AS 'RESPON',
				 C.WK_RESPON AS 'WK_RESPON' 
				FROM t_spk A
				LEFT JOIN t_spk_cont B ON A.ID = B.ID
				LEFT JOIN t_gatepass C ON B.NO_CONT = C.NO_CONT AND C.`STATUS` = 'WAITING'
				INNER JOIN t_request D ON C.NO_DOK = D.NO_DOK
				LEFT JOIN reff_status_spk E ON B.STATUS_CONT = E.ID
				LEFT JOIN t_op_inspection F ON F.NO_CONT = B.NO_CONT
				LEFT JOIN reff_kode_dok_bc G ON D.JNS_DOK = G.ID
				LEFT JOIN t_job_slip H ON H.NO_CONT = B.NO_CONT
				WHERE".$addsql."";
		
		$proses = array('PKB LONGROOM'  => array('DELETE',"display/execute/porses_cust1", 'all','','md-layers','', 'menu'),
						'PKB YARD'  => array('DELETE',"display/execute/porses_cust2", 'all','','md-navigation','', 'menu'),
						'PKB YARD N'  => array('DELETE',"display/execute/porses_cust3", 'all','','md-badge-check','', 'menu'),
						'PKB LONGROOM ' => array('POST',"display/respon_custom/pkblr", '1', '', 'md-layers','','list'),
						'PKB YARD ' => array('POST',"display/respon_custom/pkbyard", '1','','md-navigation','', 'list'),
						'PKB YARD N ' => array('POST',"display/respon_custom/pkbyardn", '1','','md-badge-check','', 'list'));

		$this->newtable->multiple_search(true);
		$this->newtable->show_chk(true);
		$this->newtable->show_menu($check);
		$this->newtable->show_search(true);
		$this->newtable->search(array(array('NO_SPK','NO. SPK'),array('B.NO_CONT','NO. KONTAINER'),array('C.NO_DOK','NO. DOKUMEN')));
		$this->newtable->action(site_url() . "/display/respon_custom");
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("ID","WK_RESPON"));
		$this->newtable->keys(array("ID"));
		$this->newtable->cidb($this->db);
		$this->newtable->groupby(array("B.NO_CONT"));
		$this->newtable->orderby("STATUS ASC, WK_RESPON DESC");
		$this->newtable->sortby("");
		$this->newtable->set_formid("tblcustoms");
		$this->newtable->set_divid("divcustoms");
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

	public function set_pkb($type, $act, $id)
	{
		$ERROR = 0;
		$VAR = explode("~", $id);
		$ID = $VAR[0];
		$NO_DOK = $VAR[1];
		$SQL = $this->db->query("SELECT * FROM t_gatepass WHERE NO_DOK ='".$NO_DOK."' AND STATUS = 'WAITING' AND FL_ACTIVE = 'Y'");
		$RESULT = $SQL->result_array();
		if ($act == 'pkb') {
			if ($SQL->num_rows() > 0) {
				foreach ($RESULT as $VALUE) {
					if ($VALUE['RESPON']) {
						$ERROR = 0;
					}else{
						$this->db->set('RESPON', 'PKB');
						$this->db->set('WK_RESPON', date('Y-m-d H:i:s'));
						$this->db->where(array('ID' => $VALUE['ID'], 'NO_CONT' => $VALUE['NO_CONT'], 'NO_DOK' => $NO_DOK));
						$EXEC = $this->db->update('t_gatepass');
						if ($EXEC) {
							$ERROR = 0;
						}else{
							$ERROR++;
						}
					}
				}
			}else{
				$ERROR++;
			}
		}else{
			if ($SQL->num_rows() > 0) {
				foreach ($RESULT as $VALUE) {
					if ($VALUE['RESPON']) {
						$ERROR = 0;
					}else{
						$this->db->set('RESPON', 'PERCEPATAN');
						$this->db->set('WK_RESPON', date('Y-m-d H:i:s'));
						$this->db->where(array('ID' => $VALUE['ID'], 'NO_CONT' => $VALUE['NO_CONT'], 'NO_DOK' => $NO_DOK));
						$EXEC = $this->db->update('t_gatepass');
						if ($EXEC) {
							$ERROR = 0;
						}else{
							$ERROR++;
						}
					}
				}
			}else{
				$ERROR++;
			}
		}
		if ($ERROR == 0) {
			 echo "MSG#OK#RESPON BERHASIL DITAMBAHKAN#" . site_url(),'/display/respon_custom/post';
		}else{
			echo "MSG#ERR#DATA GAGAL DI RESPON#";
		}
	}

	public function detail_respon($id)
	{
		$VAR = explode("~", $id);
		$ID = $VAR[0];
		$NO_DOK = $VAR[1];
			$SQL = $this->db->query("SELECT DISTINCT C.ID, C.NO_DOK, C.JNS_DOK, C.NO_DOK, C.TGL_DOK, CONCAT(B.LOKASI,B.TIER) AS LOKASI, C.NAMA_CUST AS 'CUSTOMER',
				CASE
					WHEN B.STATUS_CONT IN (450,510,530) AND C.RESPON IS NULL THEN 'BELUM PKB'
					WHEN B.STATUS_CONT IN (450,510,530) AND C.RESPON IS NOT NULL THEN 'PKB'
					WHEN B.STATUS_CONT = 460 AND D.START_INSP IS NULL AND D.FINISH_INSP IS NULL  AND C.RESPON IS NOT NULL THEN 'SIAP PERIKSA'
					WHEN B.STATUS_CONT = 460 AND D.START_INSP IS NOT NULL AND D.FINISH_INSP IS NULL THEN 'SEDANG PERIKSA' 
					WHEN B.STATUS_CONT IN (500,540,520) THEN 'SELESAI PERIKSA' 
					ELSE '' 
				END AS STATUS, C.NO_CONT, B.UKR_CONT
				FROM t_spk A
				INNER JOIN t_spk_cont B ON A.ID = B.ID
				INNER JOIN t_gatepass C ON B.NO_CONT = C.NO_CONT AND C.STATUS = 'WAITING' AND C.FL_ACTIVE = 'Y' AND C.JNS_DOK !='SPPMP'
				LEFT JOIN t_op_inspection D ON D.NO_CONT = B.NO_CONT AND C.NO_DOK = D.NO_DOK
				WHERE B.STATUS_CONT IN(460,510,530) AND C.NO_DOK = '".$NO_DOK."'");
		return $SQL->result_array();
	}

	/*function execute($type, $act, $id) {
        $func = get_instance();
        $func->load->model("m_main", "main", true);
        $success = 0;
        $error = 0;
        $USERLOGIN = $this->session->userdata('USERLOGIN');
        $KD_TPS = $this->session->userdata('KD_TPS');
        $KD_GUDANG = $this->session->userdata('KD_GUDANG');
        if ($type == "porses_cust1") {
        	foreach ($this->input->post('tb_chktblcustoms') as $chkitem) {
                $arrchk = explode("~", $chkitem);
                $ID = $arrchk[0];//print_r($ID); die();

                $this->db->where(array('ID' => $ID));
                $DATA['RESPON'] = "PKB LR";
				$DATA['WK_RESPON'] = date('Y-m-d H:i:s');
                $result = $this->db->update('t_gatepass', $DATA);
                if (!$result) {
                    $error += 1;
                    $message .= "Could not be processed data";
                }
                if ($error == 0) {
                    // $func->main->get_log("delete", "t_hari_libur");
                    echo "MSG#OK#Respon PKB Longroom#" . site_url(),'refresh';
                } else {
                    echo "MSG#ERR#" . $message . "#";
                }
            }
        }else if ($type == "porses_cust2") {
        	foreach ($this->input->post('tb_chktblcustoms') as $chkitem) {
                $arrchk = explode("~", $chkitem);
                $ID = $arrchk[0];//print_r($ID); die();

                $this->db->where(array('ID' => $ID));
                $DATA['RESPON'] = "PKB YARD";
				$DATA['WK_RESPON'] = date('Y-m-d H:i:s');
                $result = $this->db->update('t_gatepass', $DATA);
                if (!$result) {
                    $error += 1;
                    $message .= "Could not be processed data";
                }
                if ($error == 0) {
                    // $func->main->get_log("delete", "t_hari_libur");
                    echo "MSG#OK#Respon PKB Yard#" . site_url(),'refresh';
                    //echo "MSG#OK#Successfully to be processed#" .redirect(site_url(), 'refresh');
                } else {
                    echo "MSG#ERR#" . $message . "#";
                }
            }
        }else if ($type == "porses_cust3") {
        	foreach ($this->input->post('tb_chktblcustoms') as $chkitem) {
                $arrchk = explode("~", $chkitem);
                $ID = $arrchk[0];//print_r($ID); die();

                $this->db->where(array('ID' => $ID));
                $DATA['RESPON'] = "PKB YARD N";
				$DATA['WK_RESPON'] = date('Y-m-d H:i:s');
                $result = $this->db->update('t_gatepass', $DATA);
                if (!$result) {
                    $error += 1;
                    $message .= "Could not be processed data";
                }
                if ($error == 0) {
                    // $func->main->get_log("delete", "t_hari_libur");
                    echo "MSG#OK#Respon PKB Yard N#" . site_url(),'refresh';
                } else {
                    echo "MSG#ERR#" . $message . "#";
                }
            }
        }else if ($type == "porses_prioritas") {
        	foreach ($this->input->post('tb_chktblcustoms') as $chkitem) {
                $arrchk = explode("~", $chkitem);
                $ID = $arrchk[0];//print_r($ID); die();

                $this->db->where(array('ID' => $ID));
                $DATA['RESPON'] = "PKB PRIORITAS";
				$DATA['WK_RESPON'] = date('Y-m-d H:i:s');
                $result = $this->db->update('t_gatepass', $DATA);
                if (!$result) {
                    $error += 1;
                    $message .= "Could not be processed data";
                }
                if ($error == 0) {
                    // $func->main->get_log("delete", "t_hari_libur");
                    echo "MSG#OK#Respon PKB Prioritas N#" . site_url(),'refresh';
                } else {
                    echo "MSG#ERR#" . $message . "#";
                }
            }
        }
    }*/
}

/* End of file M_display.php */
/* Location: ./application/models/M_display.php */
