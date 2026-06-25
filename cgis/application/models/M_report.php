<?php if (!defined('BASEPATH'))
	exit('No direct script access allowed');
class M_report extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
	}


	function terbit_spk()
	{
		$page_title = "REPORT TERBIT SPK";
		$title = "REPORT TERBIT SPK ";
		$this->newtable->breadcrumb('Dashboard', site_url(), 'icon-home');
		$this->newtable->breadcrumb('Report', 'javascript:void(0)', '');
		$this->newtable->breadcrumb('PENARIKAN', 'javascript:void(0)', '');
		$check = (grant() == "W") ? true : false;
		// $SQL = "SELECT A.ID, A.NO_SPK AS 'NO SPK', B.NO_CONT AS 'KONTAINER', B.UKR_CONT AS 'SIZE', D.NM_ANGKUT AS 'VOYAGE', D.NO_VOY_FLIGHT AS 'NO VOYAGE', C.ISO_CODE AS 'ISO CODE', C.TIPE_CONT AS 'TIPE KONTAINER', F.IMO, D.TGL_TIBA AS 'ARRIVAL', C.STACKING, E.NAMA AS 'JENIS DOKUMEN', A.NO_DOK AS 'NO DOKUMEN', A.TGL_DOK AS 'TGL DOKUMEN', G.WK_SEND AS 'REQUEST GATEPASS', G.WK_FINISH AS 'APPROVE GATEPASS', A.WK_REQ AS 'TERBIT SPK', A.CONSIGNEE AS 'CUSTOMERS'
		// 	FROM t_spk A
		// 	INNER JOIN t_spk_cont B ON A.ID = B.ID
		// 	LEFT JOIN (SELECT ID, NO_CONT, JNS_CONT AS 'STATUS_CONT', ISO_CODE, KD_CONT_TIPE AS 'TIPE_CONT', WK_IN AS 'STACKING' FROM t_cocostscont GROUP BY NO_CONT ORDER BY ID DESC) C ON B.NO_CONT = C.NO_CONT
		// 	LEFT JOIN t_cocostshdr D ON C.ID = D.ID
		// 	INNER JOIN reff_kode_dok_bc E ON A.JNS_DOK = E.ID
		// 	LEFT JOIN (SELECT ID, NO_CONT, IMO FROM t_request_cont GROUP BY NO_CONT ORDER BY ID DESC) F ON B.NO_CONT = F.NO_CONT
		// 	LEFT JOIN t_request G ON F.ID = G.ID";

		$SQL = "SELECT A.ID, 
					A.NO_SPK AS 'NO SPK',
					B.NO_CONT AS 'KONTAINER',
					B.UKR_CONT AS 'SIZE', 
					D.VESSEL as 'VOYAGE',
					D.VOY_IN AS 'NO VOYAGE',
					D.ISO_CODE as 'ISO CODE',
					D.TIPE_CONT as 'TIPE KONTAINER',
					D.IMO,
					E.TGL_TIBA,
					D.DISCHARGE as 'STACKING',
					F.NAMA as 'JENIS DOKUMEN',
					A.NO_DOK AS 'NO DOKUMEN',
					A.TGL_DOK AS 'TGL DOKUMEN',
					C.WK_SEND AS 'REQUEST GATEPASS',
					C.WK_FINISH AS 'APPROVE GATEPASS',
					A.WK_REQ AS 'TERBIT SPK',
					A.CONSIGNEE AS 'CUSTOMERS'
					from t_spk A
					join t_spk_cont B on A.ID = B.ID
					left join t_request C on A.NO_DOK = C.NO_DOK and A.TGL_DOK = C.TGL_DOK
					left join t_request_cont D on C.ID = D.ID and B.NO_CONT = D.NO_CONT
					left join t_cocostshdr E on E.NM_ANGKUT = D.VESSEL and E.NO_VOY_FLIGHT = D.VOY_IN
					join reff_kode_dok_bc F on A.JNS_DOK = F.ID
					WHERE A.WK_REQ >= DATE_SUB(CURDATE(), INTERVAL 180 DAY)";

		$this->newtable->multiple_search(true);
		$this->newtable->show_chk(false);
		$this->newtable->show_menu($check);
		$this->newtable->show_search(true);
		$proses = array('EXCEL' => array('EXCEL', "process1/excel/penarikan/" . $act, '0', '', 'md-file-text', '', 'menu'));
		$this->newtable->search(array(array('A.NO_SPK', 'NO. SPK'), array('A.WK_REQ', 'TERBIT SPK', 'DATETIMERANGE')));
		$this->newtable->action(site_url() . "/report/terbit_spk");
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("ID", "KON", "NSPK"));
		$this->newtable->keys(array("NSPK", "KON"));
		$this->newtable->cidb($this->db);
		$this->newtable->groupby();
		$this->newtable->orderby(1);
		$this->newtable->sortby("DESC");
		$this->newtable->set_formid("tblmonitoringpenarikan");
		$this->newtable->set_divid("divmonitoringpenarikan");
		$this->newtable->rowcount(100);
		$this->newtable->clear();
		$this->newtable->menu($proses);
		$tabel .= $this->newtable->generate($SQL);
		$arrdata = array("page_title" => $page_title, "title" => $title, "content" => $tabel);
		if ($this->input->post("ajax") || $act == "post")
			return $tabel;
		else
			return $arrdata;
	}


	function reefer()
	{
		$page_title = "REPORT REEFER";
		$title = "REPORT REEFER ";
		$this->newtable->breadcrumb('Dashboard', site_url(), 'icon-home');
		$this->newtable->breadcrumb('Report', 'javascript:void(0)', '');
		$this->newtable->breadcrumb('PENARIKAN', 'javascript:void(0)', '');
		$check = (grant() == "W") ? true : false;
		$SQL = "SELECT A.ID AS 'ID', A.NO_SPK AS 'NO SPK', A.NO_CONT AS 'KONTAINER', B.TEMP_CUST AS 'TEMPERATURE DEFAULT', CONCAT('WAKTU PLUG IN TERMINAL : ', IFNULL(B.PLUG_TERMINAL,'-'),'<BR> WAKTU PLUG IN CA : ', IFNULL(A.WAKTU,'-'),'<BR>User : ', IFNULL(A.OPERATOR_START,'-')) AS 'PLUG KONTAINER', A.TEMPERATURE_AWAL AS 'TEMPERATURE AWAL', CONCAT('WAKTU PLUG OUT TERMINAL : ', IFNULL(B.UNPLUG_TERMINAL,'-'),'<BR>WAKTU PLUG OUT CA : ', IFNULL(A.WAKTU_END,'-'),'<BR>User : ', IFNULL(A.OPERATOR_END,'-')) AS 'UNPLUG KONTAINER', A.TEMPERATURE_AKHIR AS 'TEMPERATURE AKHIR', A.NO_SPK AS 'NSPK', A.NO_CONT AS 'KON', A.WK_REKAM 
		FROM t_op_reefer A
		JOIN (SELECT a.no_spk,a.NO_DOK,a.TGL_DOK,b.no_cont FROM t_spk a JOIN t_spk_cont b ON a.id = b.id) C on C.no_spk = A.no_Spk AND C.no_cont = A.no_cont
		JOIN (SELECT a.NO_DOK,a.TGL_DOK,b.* FROM t_request a JOIN t_request_cont b ON a.id = b.id) B ON B.no_dok = C.no_dok AND B.tgl_dok = C.tgl_dok AND B.no_cont = C.no_cont
		WHERE 1=1";

		$this->newtable->multiple_search(true);
		$this->newtable->show_chk(false);
		$this->newtable->show_menu($check);
		$this->newtable->show_search(true);
		// $proses = array('EXCEL' => array('EXCEL',"process/excel/penarikanreefer/".$act, '0','','md-file-text','','menu'));
		$this->newtable->search(array(array('A.NO_SPK', 'NO. SPK'), array('A.WK_REKAM', 'TANGGAL', 'DATETIMERANGE')));
		$this->newtable->action(site_url() . "/report/reefer");
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("ID", "KON", "NSPK"));
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
			return $tabel;
		else
			return $arrdata;
	}

	public function report_jinspection($act, $id)
	{
		$func = get_instance();
		$func->load->model("m_main", "main", true);
		$title = "REPORT JOIN INSPECTION" . strtoupper($act);
		$KD_TPS = $this->session->userdata('KD_TPS');
		$KD_GUDANG = $this->session->userdata('KD_GUDANG');
		$KD_GROUP = $this->session->userdata('KD_GROUP');
		$this->newtable->breadcrumb('Dashboard', site_url(), 'icon-home');
		$this->newtable->breadcrumb('Report', 'javascript:void(0)', '');
		$this->newtable->breadcrumb('JOIN INSPECTION', 'javascript:void(0)', '');
		$this->newtable->breadcrumb(strtoupper($act), 'javascript:void(0)', '');
		$check = (grant() == "W") ? true : false;
		$addsql = "";
		$SQL = "SELECT distinct A.NO_CONT 'NO KONTAINER', CONCAT('Jenis: Join Inspection <br> No: ',A.LNSW_NOAJU,'<br>Tanggal: ',A.LNSW_TGLAJU) 'DOKUMEN JOIN INSPECTION', CONCAT('Jenis: Karantina <br>No: ',A.NO_RESPON,'<br>Tanggal: ',A.TG_RESPON,'<br><br>Jenis: Beacukai <br>No: ',A.NO_DAFTAR_PABEAN,'<br>Tanggal: ', DATE_FORMAT(A.TGL_DAFTAR_PABEAN, '%Y-%m-%d')) 'DOKUMEN KARANTINA DAN BEACUKAI', CONCAT('Nama Kapal: ',E.NM_KAPAL,'<br>No Voyage: ',E.NO_VOY) 'KAPAL', CONCAT('NPWP: ',E.NPWP,'<br>Nama: ',E.NAMA_CUST) 'CUSTOMER', G.START_INSP 'START INSPECTION', F.FINISH_INSP 'FINISH INSPECTION'
			FROM v_ppk_permit_join A
			JOIN (
			SELECT b.NO_DOK, b.TGL_DOK, c.NO_CONT, c.STATUS_CONT, b.NM_KAPAL, b.NO_VOY, b.NPWP, b.CONSIGNEE
			FROM t_spk b
			JOIN t_spk_cont c ON b.id = c.id) D ON A.NO_RESPON = D.NO_DOK AND A.TG_RESPON = D.TGL_DOK AND A.NO_CONT = D.NO_CONT
			LEFT JOIN t_gatepass E ON A.NO_RESPON = E.NO_DOK AND A.TG_RESPON = E.TGL_DOK AND A.NO_CONT = E.NO_CONT
			LEFT JOIN t_op_inspection F ON F.NO_DOK = A.NO_DAFTAR_PABEAN AND YEAR(F.TGL_DOK) = YEAR(A.TGL_DAFTAR_PABEAN) AND F.NO_CONT = A.NO_CONT
			LEFT JOIN t_op_inspection G ON G.NO_DOK = A.NO_RESPON AND YEAR(G.TGL_DOK) = YEAR(A.TG_RESPON) AND G.NO_CONT = A.NO_CONT
			WHERE F.STATUS = 'DONE'" . $addsql;
		$this->newtable->multiple_search(true);
		$this->newtable->show_chk(false);
		$this->newtable->show_menu($check);
		$this->newtable->show_search(true);
		$proses = array('EXPORT EXCEL' => array('EXCEL', "process/excel/report_jinspection/" . $act, '0', '', 'md-file-text', '', 'menu'));
		$this->newtable->search(array(array('A.LNSW_NOAJU', 'NO AJU'), array('A.LNSW_TGLAJU', 'TANGGAL AJU', 'DATERANGE')));
		$this->newtable->action(site_url() . "/report/report_jinspection/" . $act);
		//if($check) $this->newtable->detail(array('POPUP',"dokumen/bc11/detail"));
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array());
		$this->newtable->keys(array());
		$this->newtable->validasi(array());
		$this->newtable->cidb($this->db);
		$this->newtable->orderby("A.LNSW_TGLAJU");
		$this->newtable->sortby("DESC");
		$this->newtable->set_formid("tblreportjinspection");
		$this->newtable->set_divid("divtblreportjinspection");
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

	function respon_pkb()
	{
		if ($this->session->userdata('KD_GROUP') == "BC") {
			$page_title = "REPORT RESPON PPK";
			$title = "REPORT RESPON PPK";
			$this->newtable->breadcrumb('Dashboard', site_url(), 'icon-home');
			$this->newtable->breadcrumb('Report', 'javascript:void(0)', '');
			$this->newtable->breadcrumb('PEMERIKSAAN', 'javascript:void(0)', '');
			$check = (grant() == "W") ? true : false;
			$addsql = " ";
			$SQL = "SELECT A.NO_SPK AS 'NO SPK', CONCAT(B.NO_CONT,'<BR>',B.UKR_CONT) AS 'KONTAINER', CONCAT('NO DOK : ',A.NO_DOK,'<BR>','JENIS : ',E.NAMA) AS 'DOKUMEN',
						A.TGL_DOK AS 'TGL ANTRIAN', CONCAT(CASE WHEN C.RESPON ='PKB PRIORITAS' THEN '<span style=\'color:green;font-weight:bold\'>PKB PRIORITAS</span>' WHEN
						C.RESPON ='PKB YARD N' THEN '<span style=\'color:green;font-weight:bold\'>PKB YARD N</span>' WHEN C.RESPON ='PKB YARD' THEN '<span style=\'color:green;font-weight:bold\'>PKB YARD</span>'
						ELSE '<span style=\'color:green;font-weight:bold\'>PKB LONGROOM</span>' END,'<BR>',C.WK_RESPON) AS 'RESPON', C.WK_ACTIVE AS 'TGL SIAP PERIKSA', D.START_INSP AS 'TGL START PERIKSA', 
						D.FINISH_INSP AS 'TGL SELESAI PERIKSA', D.NO_SEAL AS 'NO SEAL', A.CONSIGNEE AS 'CUSTOMER'
						FROM t_spk A
						LEFT JOIN t_spk_cont B ON B.ID = A.ID
						LEFT JOIN t_gatepass C ON C.NO_CONT = B.NO_CONT AND C.NO_DOK = A.NO_DOK
						LEFT JOIN t_op_inspection D ON D.NO_CONT = B.NO_CONT AND D.NO_CONT = C.NO_CONT
						LEFT JOIN reff_kode_dok_bc E ON E.ID = A.JNS_DOK
						WHERE C.FL_ACTIVE = 'Y' AND E.ID != 83 AND C.RESPON IS NOT NULL AND D.START_INSP IS NOT NULL AND D.FINISH_INSP IS NOT NULL" . $addsql . "";

			$this->newtable->multiple_search(true);
			$this->newtable->show_chk(false);
			$this->newtable->show_menu($check);
			$this->newtable->show_search(true);
			$proses = array('EXPORT PEMERIKSAAN' => array('EXCEL', "process/excel/pemeriksaan/" . $act, '0', '', 'md-file-text', '', 'menu'));
			$this->newtable->search(array(array('B.NO_CONT', 'NO CONTAINER'), array('D.START_INSP', 'TANGGAL START PERIKSA', 'DATETIMERANGE')));
			$this->newtable->action(site_url() . "/report/respon_pkb");
			$this->newtable->tipe_proses('button');
			$this->newtable->hiddens(array("STATUS_CONT", "CLASS", "KODE KAPAL", "VOYAGE", "ISO CODE", "TGL DOKUMEN", "TERBIT GATEPASS B1", "BEHANDLE IN", "LOKASI PEMERIKSAAN", "NO SEAL", "STATUS", "IMO"));
			$this->newtable->keys(array(""));
			$this->newtable->cidb($this->db);
			$this->newtable->groupby("A.NO_CONT");
			$this->newtable->orderby(6);
			$this->newtable->sortby("DESC");
			$this->newtable->set_formid("tblmonitoringpemeriksaan");
			$this->newtable->set_divid("divmonitoringpemeriksaan");
			$this->newtable->rowcount(100);
			$this->newtable->clear();
			$this->newtable->menu($proses);
			$tabel .= $this->newtable->generate($SQL);
			$arrdata = array("page_title" => $page_title, "title" => $title, "content" => $tabel);
			if ($this->input->post("ajax") || $act == "post")
				return $tabel;
			else
				return $arrdata;
		} else {
			$page_title = "REPORT RESPON PPK";
			$title = "REPORT RESPON PPK";
			$this->newtable->breadcrumb('Dashboard', site_url(), 'icon-home');
			$this->newtable->breadcrumb('Report', 'javascript:void(0)', '');
			$this->newtable->breadcrumb('PEMERIKSAAN', 'javascript:void(0)', '');
			$check = (grant() == "W") ? true : false;
			$addsql = " ";
			// $SQL = "SELECT A.ID, A.NO_SPK AS 'NO SPK', B.NO_CONT AS 'KONTAINER', B.UKR_CONT AS 'SIZE', D.NM_ANGKUT AS 'VOYAGE', D.NO_VOY_FLIGHT AS 'NO VOYAGE', CASE WHEN C.STATUS_CONT ='F' THEN 'FL' ELSE 'MT' END AS 'STATUS KONTAINER', C.TIPE_CONT AS 'TIPE KONTAINER', F.IMO, E.NAMA AS 'JENIS DOKUMEN', A.NO_DOK AS 'NO DOKUMEN', A.TGL_DOK AS 'TGL DOKUMEN', G.WK_SEND AS 'REQUEST GATEPASS', H.W_BEHANDLE AS 'BEHANDLE IN', I.RESPON AS 'RESPON PPK', I.WK_RESPON AS 'TANGGAL PPK', CONCAT('BEHANDLE ',I.JNS_KEGIATAN) AS 'JENIS KEGIATAN', A.CONSIGNEE AS 'CUSTOMERS'
			// 		FROM t_spk A
			// 		INNER JOIN t_spk_cont B ON A.ID = B.ID
			// 		LEFT JOIN (SELECT ID, NO_CONT, JNS_CONT AS 'STATUS_CONT', ISO_CODE, KD_CONT_TIPE AS 'TIPE_CONT', WK_IN AS 'STACKING' FROM t_cocostscont GROUP BY NO_CONT ORDER BY ID DESC) C ON B.NO_CONT = C.NO_CONT
			// 		LEFT JOIN t_cocostshdr D ON C.ID = D.ID
			// 		INNER JOIN reff_kode_dok_bc E ON A.JNS_DOK = E.ID
			// 		LEFT JOIN (SELECT ID, NO_CONT, IMO FROM t_request_cont GROUP BY NO_CONT ORDER BY ID DESC) F ON B.NO_CONT = F.NO_CONT
			// 		LEFT JOIN t_request G ON F.ID = G.ID
			// 		INNER JOIN (SELECT A.NO_SPK, B.NO_CONT, A.W_PICKUP, W_BEHANDLE, B.KONDISI_CONT, B.NO_SEAL, B.ROOM FROM t_op_pickup A INNER JOIN t_op_behandlein B ON A.NO_SPK = B.NO_SPK) H ON A.NO_SPK = H.NO_SPK AND C.NO_CONT = H.NO_CONT
			// 		INNER JOIN (SELECT ID, NO_CONT, NO_DOK, RESPON, WK_RESPON, JNS_KEGIATAN FROM t_gatepass WHERE JNS_KEGIATAN IN ('1','2') GROUP BY NO_CONT,JNS_KEGIATAN ORDER BY ID DESC) I ON B.NO_CONT = I.NO_CONT AND A.NO_DOK = I.NO_DOK" . $addsql . "";

			$SQL = "SELECT 
					A.ID,
						A.NO_SPK AS 'NO SPK',
						B.NO_CONT AS 'KONTAINER',
						B.UKR_CONT AS 'SIZE',
						E.NM_ANGKUT as 'VOYAGE',
						E.NO_VOY_FLIGHT as 'NO VOYAGE',
						CASE 
							WHEN EE.JNS_CONT = 'F' THEN 'FL' 
							ELSE 'MT' 
						END AS 'STATUS KONTAINER',
						EE.KD_CONT_TIPE AS 'TIPE KONTAINER',
						D.IMO,
						AA.NAMA AS 'JENIS DOKUMEN',
						A.NO_DOK AS 'NO DOKUMEN',
						A.TGL_DOK AS 'TGL DOKUMEN',
						C.WK_SEND AS 'REQUEST GATEPASS',
						F.WK_IN as 'BEHANDLE IN',
						G.RESPON AS 'RESPON PPK',
						G.WK_RESPON AS 'TANGGAL PPK',
						CONCAT('BEHANDLE ', G.JNS_KEGIATAN) AS 'JENIS KEGIATAN',
						A.CONSIGNEE AS 'CUSTOMERS'
					from t_spk A join t_spk_cont B on A.ID = B.ID
						left join reff_kode_dok_bc AA on A.JNS_DOK = AA.ID
					join t_request C on A.NO_DOK = C.NO_DOK and A.TGL_DOK = C.TGL_DOK
					join t_request_cont D on C.ID = D.ID and D.NO_CONT = B.NO_CONT
					left join t_cocostshdr E on D.VESSEL = E.NM_ANGKUT and D.VOY_IN = E.NO_VOY_FLIGHT 
					left join t_cocostscont EE on E.ID = EE.ID and B.NO_CONT = EE.NO_CONT
					left join t_operation F on A.NO_SPK = F.NO_SPK and B.NO_CONT = F.NO_CONT
					left join t_gatepass G on A.NO_DOK = G.NO_DOK and B.NO_CONT = G.NO_CONT 
					WHERE 1 = 1 
					AND F.WK_IN BETWEEN DATE_SUB(CURDATE(), INTERVAL 6 MONTH) AND CURDATE()
					" . $addsql . "";

			$this->newtable->multiple_search(true);
			$this->newtable->show_chk(false);
			$this->newtable->show_menu($check);
			$this->newtable->show_search(true);
			$proses = array('EXCEL' => array('EXCEL', "process1/excel/responpkb/" . $act, '0', '', 'md-file-text', '', 'menu'));
			$this->newtable->search(array(array('G.WK_RESPON', 'TANGGAL RESPON PPK', 'DATETIMERANGE')));
			$this->newtable->action(site_url() . "/report/respon_pkb");
			$this->newtable->tipe_proses('button');
			$this->newtable->hiddens(array("STATUS_CONT", "CLASS", "KODE KAPAL", "VOYAGE", "ISO CODE", "TGL DOKUMEN", "TERBIT GATEPASS B1", "BEHANDLE IN", "LOKASI PEMERIKSAAN", "NO SEAL", "STATUS", "IMO"));
			$this->newtable->keys(array(""));
			$this->newtable->cidb($this->db);
			$this->newtable->groupby();
			$this->newtable->orderby(12);
			$this->newtable->sortby("DESC");
			$this->newtable->set_formid("tblmonitoringresponpkb");
			$this->newtable->set_divid("divmonitoringresponpkb");
			$this->newtable->rowcount(100);
			$this->newtable->clear();
			$this->newtable->menu($proses);
			$tabel .= $this->newtable->generate($SQL);
			$arrdata = array("page_title" => $page_title, "title" => $title, "content" => $tabel);
			if ($this->input->post("ajax") || $act == "post")
				return $tabel;
			else
				return $arrdata;
		}
	}

	function delivery()
	{
		$page_title = "REPORT DELIVERY";
		$title = "REPORT DELIVERY";
		$this->newtable->breadcrumb('Dashboard', site_url(), 'icon-home');
		$this->newtable->breadcrumb('Report', 'javascript:void(0)', '');
		$this->newtable->breadcrumb('DELIVERY', 'javascript:void(0)', '');
		$check = (grant() == "W") ? true : false;

		$SQL = "SELECT A.NO_SPK AS 'NO SPK', B.NO_CONT AS 'KONTAINER', C.KD_CONT_TIPE, B.UKR_CONT AS 'SIZE', CASE WHEN C.JNS_CONT = 'F' THEN 'FULL' ELSE 'EMPTY' END AS STATUS_CONT, D.NAMA AS 'JENIS DOKUMEN', E.WK_TRUCKIN AS 'WAKTU TRUCK IN', E.NO_TRUCK AS TID, E.WK_CHASSIS AS 'WAKTU CHASSIS', E.NO_SEAL AS 'NO SEAL', F.KONDISI AS 'KONDISI', E.WK_INSPECT AS 'WAKTU INSPECT', E.WK_GATEOUT AS 'WAKTU TRUCK OUT', A.CONSIGNEE AS 'CUSTOMER', G.KETERANGAN AS 'KETERANGAN'
		FROM t_spk A
		LEFT JOIN t_spk_cont B ON A.ID = B.ID
		LEFT JOIN (SELECT NO_CONT, JNS_CONT, KD_CONT_TIPE, ISO_CODE FROM t_cocostscont GROUP BY NO_CONT ORDER BY ID DESC) AS C ON B.NO_CONT = C.NO_CONT -- AND B.ISO_CODE = C.ISO_CODE
		LEFT JOIN reff_kode_dok_bc D ON A.JNS_DOK = D.ID
		LEFT JOIN (   SELECT 
    tod.NO_CONT, 
    tod.NO_SPK, 
    tod.WK_TRUCKIN,
    tod.WK_GATEOUT,
    tod.NO_TRUCK,
    tod.WK_CHASSIS,
    tod.NO_SEAL,
    tod.WK_INSPECT,
    tod.KONDISI_CONT,
    MAX(tod.id) as latest_record_id
FROM 
    t_op_delivery tod
GROUP BY 
    tod.NO_CONT, 
    tod.NO_SPK) E ON A.NO_SPK = E.NO_SPK AND B.NO_CONT = E.NO_CONT
		LEFT JOIN reff_kondisi F ON E.KONDISI_CONT = F.ID
		LEFT JOIN reff_status_spk G ON B.STATUS_CONT = G.ID
		WHERE B.STATUS_CONT = '900'";

		$this->newtable->multiple_search(true);
		$this->newtable->show_chk(false);
		$this->newtable->show_menu($check);
		$this->newtable->show_search(true);
		$proses = array('EXPORT DELIVERY' => array('EXCEL', "process/excel/delivery/" . $act, '0', '', 'md-file-text', '', 'menu'));
		$this->newtable->search(array(array('B.NO_CONT', 'NO CONTAINER'), array('E.WK_TRUCKIN', 'TANGGAL TRUCK IN', 'DATETIMERANGE')));
		$this->newtable->action(site_url() . "/report/delivery");
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("WAKTU TRUCK IN", "WAKTU CHASSIS", "WAKTU INSPECT", "WAKTU TRUCK OUT"));
		$this->newtable->keys(array("A.NO_SPK"));
		$this->newtable->cidb($this->db);
		$this->newtable->groupby("");
		$this->newtable->orderby("A.TGL_SPK");
		$this->newtable->sortby("DESC");
		$this->newtable->set_formid("tblmonitoringdelivery");
		$this->newtable->set_divid("divmonitoringdelivery");
		$this->newtable->rowcount(100);
		$this->newtable->clear();
		$this->newtable->menu($proses);
		$tabel .= $this->newtable->generate($SQL);
		$arrdata = array("page_title" => $page_title, "title" => $title, "content" => $tabel);
		if ($this->input->post("ajax") || $act == "post")
			return $tabel;
		else
			return $arrdata;
	}

	function siap_periksa()
	{
		$page_title = "REPORT SIAP PERIKSA";
		$title = "REPORT SIAP PERIKSA ";
		$this->newtable->breadcrumb('Dashboard', site_url(), 'icon-home');
		$this->newtable->breadcrumb('Report', 'javascript:void(0)', '');
		$this->newtable->breadcrumb('PERIKSA', 'javascript:void(0)', '');
		$check = (grant() == "W") ? true : false;
		$SQL = "SELECT A.NO_SPK AS 'NO SPK',
B.NO_CONT AS 'KONTAINER',
B.UKR_CONT AS 'SIZE',
E.NM_ANGKUT AS 'VOYAGE',
E.NO_VOY_FLIGHT AS 'NO VOYAGE',
CASE WHEN EE.JNS_CONT ='F' THEN 'FL' ELSE 'MT' END AS 'STATUS KONTAINER',
EE.KD_CONT_TIPE AS 'TIPE KONTAINER', D.ISO_CODE AS 'ISO CODE',
I.JNS_DOK AS 'JENIS DOKUMEN', I.NO_DOK AS 'NO DOKUMEN',
I.TGL_DOK AS 'TGL DOKUMEN',
I.WK_REK AS 'GATEPASS TERBIT',
H.WK_IN AS 'BEHANDLE IN',
I.RESPON AS 'RESPON PKB',
J.WK_STATUS AS 'TGL MARSHALLING',
J.LOKASI_AKHIR AS 'LOKASI',
CONCAT('BEHANDLE ',I.JNS_KEGIATAN) AS 'JENIS KEGIATAN',
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
	where J.LOKASI_AKHIR LIKE 'CIC%' and I.JNS_KEGIATAN in (1,2) and DATE(A.WK_REQ) > DATE_ADD(NOW(), INTERVAL -6 MONTH)";
		$this->newtable->multiple_search(true);
		$this->newtable->show_chk(false);
		$this->newtable->show_menu($check);
		$this->newtable->show_search(true);
		$proses = array('EXCEL' => array('EXCEL', "process1/excel/siapperiksa/" . $act, '0', '', 'md-file-text', '', 'menu'));
		$this->newtable->search(array(array('J.WK_STATUS', 'TANGGAL MARSHALLING', 'DATETIMERANGE')));
		$this->newtable->action(site_url() . "/report/siap_periksa");
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens();
		$this->newtable->keys(array("NO SPK"));
		$this->newtable->cidb($this->db);
		$this->newtable->groupby();
		$this->newtable->orderby(15);
		$this->newtable->sortby("DESC");
		$this->newtable->set_formid("tblmonitoringsiapperiksa");
		$this->newtable->set_divid("divmonitoringsiapperiksa");
		$this->newtable->rowcount(100);
		$this->newtable->clear();
		$this->newtable->menu($proses);
		$tabel .= $this->newtable->generate($SQL);
		$arrdata = array("page_title" => $page_title, "title" => $title, "content" => $tabel);
		if ($this->input->post("ajax") || $act == "post")
			return $tabel;
		else
			return $arrdata;
	}

	function pemeriksaan()
	{
		$page_title = "REPORT PEMERIKSAAN";
		$title = "REPORT PEMERIKSAAN";
		$this->newtable->breadcrumb('Dashboard', site_url(), 'icon-home');
		$this->newtable->breadcrumb('Report', 'javascript:void(0)', '');
		$this->newtable->breadcrumb('PERIKSA', 'javascript:void(0)', '');
		$check = (grant() == "W") ? true : false;
		// $SQL = "SELECT A.NO_SPK AS 'NO SPK', B.NO_CONT AS 'KONTAINER', E.NM_ANGKUT AS 'VOYAGE', E.NO_VOY_FLIGHT AS 'NO VOYAGE', CASE WHEN D.JNS_CONT ='F' THEN 'FL' ELSE 'MT' END AS 'STATUS KONTAINER', B.UKR_CONT AS 'SIZE', KD_CONT_TIPE AS 'TIPE KONTAINER', F.IMO, H.JNS_DOK AS 'JENIS DOKUMEN', H.NO_DOK AS 'NO DOKUMEN', H.TGL_DOK AS 'TGL DOKUMEN', H.WK_REK AS 'TERBIT GATEPASS', J.START_INSP AS 'START PEMERIKSAAN', J.FINISH_INSP AS 'FINISH PEMERIKSAAN', CONCAT('BEHANDLE ',H.JNS_KEGIATAN) AS 'JENIS KEGIATAN', A.CONSIGNEE AS 'CUSTOMERS'
		// 	FROM t_spk A
		// 	INNER JOIN t_spk_cont B ON A.ID = B.ID
		// 	INNER JOIN reff_kode_dok_bc C ON A.JNS_DOK = C.ID
		// 	LEFT JOIN (SELECT ID, NO_CONT, JNS_CONT, ISO_CODE, KD_CONT_TIPE, WK_IN, WK_OUT FROM t_cocostscont GROUP BY NO_CONT ORDER BY ID DESC) D ON B.NO_CONT = D.NO_CONT
		// 	LEFT JOIN t_cocostshdr E ON D.ID = E.ID
		// 	LEFT JOIN (SELECT ID, NO_CONT, IMO FROM t_request_cont GROUP BY NO_CONT ORDER BY ID DESC) F ON B.NO_CONT = F.NO_CONT
		// 	LEFT JOIN t_request G ON F.ID = G.ID AND A.NO_DOK = G.NO_DOK
		// 	INNER JOIN (SELECT ID, NO_CONT, JNS_DOK,NO_DOK, TGL_DOK, RESPON, WK_RESPON, JNS_KEGIATAN, WK_REK FROM t_gatepass WHERE JNS_KEGIATAN IN ('1','2') GROUP BY NO_CONT,JNS_KEGIATAN ORDER BY ID DESC) H ON B.NO_CONT = H.NO_CONT
		// 	INNER JOIN (SELECT NO_SPK, NO_CONT, NO_GATEPASS, LOKASI_AKHIR, WK_STATUS FROM t_job_slip WHERE LOKASI_AKHIR LIKE 'CIC%' GROUP BY NO_CONT ORDER BY ID_JOB_SLIP DESC) I ON A.NO_SPK = I.NO_SPK AND B.NO_CONT = I.NO_CONT
		// 	INNER JOIN (SELECT NO_CONT, NO_SEAL, START_INSP, FINISH_INSP, JNS_DOK, NO_DOK, TGL_DOK, NO_SPK FROM t_op_inspection GROUP BY NO_CONT ORDER BY ID DESC) J ON A.NO_SPK = J.NO_SPK AND B.NO_CONT = J.NO_CONT AND H.NO_DOK = J.NO_DOK
		// 	WHERE  YEAR(A.TGL_SPK) >= '2025'";

		$SQL = "SELECT A.NO_SPK AS 'NO SPK',
B.NO_CONT AS 'KONTAINER',
E.NM_ANGKUT AS 'VOYAGE',
E.NO_VOY_FLIGHT AS 'NO VOYAGE',
CASE WHEN EE.JNS_CONT ='F' THEN 'FL' ELSE 'MT' END AS 'STATUS KONTAINER',
B.UKR_CONT AS 'SIZE', KD_CONT_TIPE AS 'TIPE KONTAINER',
D.IMO,
I.JNS_DOK AS 'JENIS DOKUMEN',
I.NO_DOK AS 'NO DOKUMEN',
I.TGL_DOK AS 'TGL DOKUMEN',
I.WK_REK AS 'TERBIT GATEPASS',
K.START_INSP AS 'START PEMERIKSAAN',
K.FINISH_INSP AS 'FINISH PEMERIKSAAN',
CONCAT('BEHANDLE ',I.JNS_KEGIATAN) AS 'JENIS KEGIATAN',
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
	where I.STATUS = 'DONE'	 and DATE(A.WK_REQ) > DATE_ADD(NOW(), INTERVAL -6 MONTH)";
		$this->newtable->multiple_search(true);
		$this->newtable->show_chk(false);
		$this->newtable->show_menu($check);
		$this->newtable->show_search(true);
		$proses = array('EXCEL' => array('EXCEL', "process1/excel/pemeriksaan/" . $act, '0', '', 'md-file-text', '', 'menu'));
		$this->newtable->search(array(array('K.FINISH_INSP', 'TANGGAL SELESAI PERIKSA', 'DATETIMERANGE')));
		$this->newtable->action(site_url() . "/report/pemeriksaan");
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens();
		$this->newtable->keys(array("NO SPK"));
		$this->newtable->cidb($this->db);
		$this->newtable->groupby();
		$this->newtable->orderby(1);
		$this->newtable->sortby("DESC");
		$this->newtable->set_formid("tblmonitoringsiapperiksa");
		$this->newtable->set_divid("divmonitoringsiapperiksa");
		$this->newtable->rowcount(1000);
		$this->newtable->clear();
		$this->newtable->menu($proses);
		$tabel .= $this->newtable->generate_custom_row($SQL);
		$arrdata = array("page_title" => $page_title, "title" => $title, "content" => $tabel);
		if ($this->input->post("ajax") || $act == "post")
			return $tabel;
		else
			return $arrdata;
	}

	function marshalling()
	{
		$page_title = "REPORT MARSHALLING BEHANDLE";
		$title = "REPORT MARSHALLING BEHANDLE";
		$this->newtable->breadcrumb('Dashboard', site_url(), 'icon-home');
		$this->newtable->breadcrumb('Report', 'javascript:void(0)', '');
		$this->newtable->breadcrumb('MARSHALLING', 'javascript:void(0)', '');
		$check = (grant() == "W") ? true : false;

		$SQL = "SELECT A.NO_SPK AS 'NO SPK',
							B.NO_CONT AS 'KONTAINER',
							B.UKR_CONT AS 'SIZE',		
							CASE WHEN EE.JNS_CONT = 'F' THEN 'FULL' ELSE 'EMPTY' END AS 'STATUS',
							AA.NAMA AS 'JENIS DOKUMEN',
							F.WK_STATUS AS 'WAKTU MARSHALLING',
							F.JENIS AS 'JENIS_JOB',
							CONCAT('<span style=\"blue:yellow;font-weight:bold\">', F.JENIS,'</span>') AS KETERANGAN
						FROM t_spk A
						INNER JOIN t_spk_cont B ON A.ID = B.ID
						join reff_kode_dok_bc AA on A.JNS_DOK = AA.ID
						join t_request C on A.NO_DOK = C.NO_DOK and A.TGL_DOK = C.TGL_DOK
						join t_request_cont D on C.ID = D.ID and D.NO_CONT = B.NO_CONT
							left join t_cocostshdr E on D.VESSEL = E.NM_ANGKUT and D.VOY_IN = E.NO_VOY_FLIGHT 
							left join t_cocostscont EE on E.ID = EE.ID and B.NO_CONT = EE.NO_CONT
							LEFT JOIN t_job_slip F ON F.NO_CONT = B.NO_CONT AND A.NO_SPK = F.NO_SPK
							WHERE F.KD_STATUS='50' AND F.LOKASI_AWAL LIKE '%CIC%' AND F.JENIS IN ('EX BEHANDLE 1','EX BEHANDLE 2')
							and DATE(A.WK_REQ) > DATE_ADD(NOW(), INTERVAL -6 MONTH)";

		$this->newtable->multiple_search(true);
		$this->newtable->show_chk(false);
		$this->newtable->show_menu($check);
		$this->newtable->show_search(true);
		$proses = array('EXPORT MARSHALLING' => array('EXCEL', "process/excel/marshalling/" . $act, '0', '', 'md-file-text', '', 'menu'));
		$arr_sts = array("" => "", "EX BEHANDLE 1" => "EX BEHANDLE 1", "EX BEHANDLE 2" => "EX BEHANDLE 2");
		$this->newtable->search(array(array('F.WK_STATUS', 'TANGGAL MARSHALLING', 'DATETIMERANGE'), array('F.JENIS', 'KETERANGAN', 'OPTION', $arr_sts)));
		$this->newtable->action(site_url() . "/report/marshalling");
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("JENIS_JOB"));
		$this->newtable->keys(array("A.NO_SPK"));
		$this->newtable->cidb($this->db);
		$this->newtable->groupby("");
		$this->newtable->orderby(6);
		$this->newtable->sortby("DESC");
		$this->newtable->set_formid("tblmonitoringmarshalling");
		$this->newtable->set_divid("divmonitoringmarshalling");
		$this->newtable->rowcount(100);
		$this->newtable->clear();
		$this->newtable->menu($proses);
		$tabel .= $this->newtable->generate($SQL);
		$arrdata = array("page_title" => $page_title, "title" => $title, "content" => $tabel);
		if ($this->input->post("ajax") || $act == "post")
			return $tabel;
		else
			return $arrdata;
	}

	function marshallingex()
	{
		$page_title = "REPORT EX MARSHALLING BEHANDLE";
		$title = "REPORT EX MARSHALLING BEHANDLE";
		$this->newtable->breadcrumb('Dashboard', site_url(), 'icon-home');
		$this->newtable->breadcrumb('Report', 'javascript:void(0)', '');
		$this->newtable->breadcrumb('MARSHALLING', 'javascript:void(0)', '');
		$check = (grant() == "W") ? true : false;

		// $SQL = "SELECT A.NO_SPK AS 'NO SPK', B.NO_CONT AS 'KONTAINER', E.NM_ANGKUT AS 'VOYAGE', B.UKR_CONT AS 'SIZE',  KD_CONT_TIPE AS 'TIPE KONTAINER', F.IMO, H.JNS_DOK AS 'JENIS DOKUMEN', H.NO_DOK AS 'NO DOKUMEN', H.TGL_DOK AS 'TGL DOKUMEN',J.START_INSP AS 'START PEMERIKSAAN', J.FINISH_INSP AS 'FINISH PEMERIKSAAN', L.WK_STATUS AS 'MARSHALLING EX BEHANDLE', CONCAT('BEHANDLE ',H.JNS_KEGIATAN) AS 'JENIS KEGIATAN', A.CONSIGNEE AS 'CUSTOMERS'
		// 	FROM t_spk A
		// 	INNER JOIN t_spk_cont B ON A.ID = B.ID
		// 	INNER JOIN reff_kode_dok_bc C ON A.JNS_DOK = C.ID
		// 	LEFT JOIN (SELECT ID, NO_CONT, JNS_CONT, ISO_CODE, KD_CONT_TIPE, WK_IN, WK_OUT FROM t_cocostscont GROUP BY NO_CONT ORDER BY ID DESC) D ON B.NO_CONT = D.NO_CONT
		// 	LEFT JOIN t_cocostshdr E ON D.ID = E.ID
		// 	LEFT JOIN (SELECT ID, NO_CONT, IMO FROM t_request_cont GROUP BY NO_CONT ORDER BY ID DESC) F ON B.NO_CONT = F.NO_CONT
		// 	LEFT JOIN t_request G ON F.ID = G.ID AND A.NO_DOK = G.NO_DOK
		// 	INNER JOIN (SELECT ID, NO_CONT, JNS_DOK,NO_DOK, TGL_DOK, RESPON, WK_RESPON, JNS_KEGIATAN, WK_REK FROM t_gatepass WHERE JNS_KEGIATAN IN ('1','2') GROUP BY NO_CONT,JNS_KEGIATAN ORDER BY ID DESC) H ON B.NO_CONT = H.NO_CONT
		// 	INNER JOIN (SELECT NO_SPK, NO_CONT, NO_GATEPASS, LOKASI_AKHIR, WK_STATUS FROM t_job_slip WHERE LOKASI_AKHIR LIKE 'CIC%' GROUP BY NO_CONT ORDER BY ID_JOB_SLIP DESC) I ON A.NO_SPK = I.NO_SPK AND B.NO_CONT = I.NO_CONT
		// 	INNER JOIN (SELECT NO_CONT, NO_SEAL, START_INSP, FINISH_INSP, JNS_DOK, NO_DOK, TGL_DOK, NO_SPK FROM t_op_inspection GROUP BY NO_CONT ORDER BY ID DESC) J ON A.NO_SPK = J.NO_SPK AND B.NO_CONT = J.NO_CONT AND H.NO_DOK = J.NO_DOK
		// 	INNER JOIN (SELECT NO_CONT, NO_SPK, NO_GATEPASS, LOKASI_AKHIR, WK_STATUS FROM t_job_slip WHERE LOKASI_AKHIR LIKE 'CIC%' GROUP BY NO_CONT,NO_GATEPASS ORDER BY ID_JOB_SLIP DESC) K ON A.NO_SPK = K.NO_SPK AND B.NO_CONT = K.NO_CONT AND H.ID = K.NO_GATEPASS
		// 	INNER JOIN (SELECT NO_CONT, NO_SPK, NO_GATEPASS, LOKASI_AKHIR, WK_STATUS FROM t_job_slip WHERE LOKASI_AKHIR LIKE '1A%' GROUP BY NO_CONT,NO_GATEPASS ORDER BY ID_JOB_SLIP DESC) L ON A.NO_SPK = L.NO_SPK AND B.NO_CONT = L.NO_CONT AND H.ID = L.NO_GATEPASS
		// 	WHERE 1 = 1";

		$SQL = "SELECT A.NO_SPK AS 'NO SPK',B.NO_CONT AS 'KONTAINER', AB.VESSEL AS 'VOYAGE', B.UKR_CONT AS 'SIZE', AB.TIPE_CONT AS 'TIPE KONTAINER', AB.IMO, D.JNS_DOK, D.NO_DOK AS 'NO DOKUMEN', D.TGL_DOK AS 'TGL DOKUMEN',
			E.START_INSP AS 'START PEMERIKSAAN', E.FINISH_INSP AS 'FINISH PEMERIKSAAN', F.WK_STATUS AS 'MARSHALLING EX BEHANDLE', CONCAT('BEHANDLE ',D.JNS_KEGIATAN) AS 'JENIS KEGIATAN', A.CONSIGNEE AS 'CUSTOMERS'
			from t_spk A
			join t_spk_cont B on A.ID =  B.ID
			INNER JOIN reff_kode_dok_bc C ON A.JNS_DOK = C.ID
			join t_request AA on A.NO_DOK = AA.NO_DOK and A.TGL_DOK = AA.TGL_DOK and AA.KD_REQ = 'INQUIRY'
			join t_request_cont AB on AA.ID = AB.ID and B.NO_CONT = AB.NO_CONT
			join t_gatepass D on A.NO_DOK = D.NO_DOK and B.NO_CONT = D.NO_CONT
			join t_op_inspection E on B.NO_CONT = E.NO_CONT and A.NO_SPK = E.NO_SPK 
			join t_job_slip F on D.ID = F.NO_GATEPASS and B.NO_CONT = F.NO_CONT and F.JENIS in ('EX BEHANDLE 1','EX BEHANDLE 2') and F.LOKASI_AKHIR like '1A%'
			where A.WK_REQ > '2025-06-01'
			";

		$this->newtable->multiple_search(true);
		$this->newtable->show_chk(false);
		$this->newtable->show_menu($check);
		$this->newtable->show_search(true);
		$proses = array('EXPORT EX MARSHALLING BEHANDLE' => array('EXCEL', "process1/excel/marshallingex/" . $act, '0', '', 'md-file-text', '', 'menu'));
		$this->newtable->search(array(array('F.WK_STATUS', 'TANGGAL EX MARSHALLING', 'DATETIMERANGE')));
		$this->newtable->action(site_url() . "/report/marshallingex");
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens();
		$this->newtable->keys(array("A.NO_SPK"));
		$this->newtable->cidb($this->db);
		$this->newtable->groupby("");
		$this->newtable->orderby(11);
		$this->newtable->sortby("DESC");
		$this->newtable->set_formid("tblmonitoringmarshallingex");
		$this->newtable->set_divid("divmonitoringmarshallingex");
		$this->newtable->rowcount(100);
		$this->newtable->clear();
		$this->newtable->menu($proses);
		$tabel .= $this->newtable->generate($SQL);
		$arrdata = array("page_title" => $page_title, "title" => $title, "content" => $tabel);
		if ($this->input->post("ajax") || $act == "post")
			return $tabel;
		else
			return $arrdata;
	}

	function stacking()
	{

		$page_title = "STACKING";
		$title = "STACKING";
		$this->newtable->breadcrumb('Dashboard', site_url(), 'icon-home');
		$this->newtable->breadcrumb('Report', 'javascript:void(0)', '');
		$this->newtable->breadcrumb('STACKING', 'javascript:void(0)', '');
		$check = (grant() == "W") ? true : false;

		$SQLTEMP1 = "SELECT distinct * FROM (
			SELECT A.NO_SPK AS 'NO SPK',A.WK_REQ,B.STATUS_CONT, B.NO_CONT AS 'KONTAINER',case when F.FL_REEFER = 'Y' then 'REEFER' when F.FL_OOG = 'Y' then 'OOG' ELSE 'DRY' END  AS 'TIPE_CONT',
			B.UKR_CONT AS 'SIZE', CASE WHEN F.KD_CONT_JENIS = 'F' THEN 'FULL' ELSE 'EMPTY' END AS 'STATUS',case when F.FL_DG = 'Y' then 'DG' end AS 'DG', A.WK_REQ AS 'TERBIT SPK'
			, E.NAMA AS 'JENIS DOKUMEN', A.NO_DOK AS 'NO DOKUMEN', A.TGL_DOK AS 'TGL DOKUMEN', B.ID_FLAT AS 'TID'
			, CONCAT((B.LOKASI),'0',(B.TIER)) AS 'LOKASI'
			, CASE WHEN B.STATUS_CONT IN ('450','510','530') AND B.LOKASI LIKE '1A%' THEN 'STACKING YARD 1A' WHEN B.STATUS_CONT IN ('450','510','530') AND B.LOKASI LIKE '1B%' THEN 'STACKING YARD 1B' WHEN B.STATUS_CONT IN ('460','520','540') THEN 'STACKING CIC' ELSE 'DELIVERY' END AS 'KETERANGAN', G.CONSIGNEE AS 'CUSTOMER',
			F.PLUG_TERMINAL AS 'PLUG NPCT1',F.UNPLUG_TERMINAL AS 'UNPLUG NPCT1',M.WAKTU AS 'PLUG CA',M.WAKTU_END AS 'UNPLUG CA'
			FROM t_spk A
			JOIN t_spk_cont B ON A.ID = B.ID
			LEFT JOIN reff_kode_dok_bc E ON E.ID = A.JNS_DOK
			LEFT JOIN t_request G ON G.NO_DOK = A.NO_DOK AND G.TGL_DOK = A.TGL_DOK
			LEFT JOIN t_request_cont F ON F.ID = G.ID AND F.KD_STATUS = 'INQUIRY' AND F.NO_CONT = B.NO_CONT
			LEFT JOIN ( SELECT A.NO_SPK, B.NO_CONT, A.W_PICKUP, W_BEHANDLE, B.KONDISI_CONT, B.NO_SEAL, B.ROOM FROM t_op_pickup A INNER JOIN t_op_behandlein B ON A.NO_SPK = B.NO_SPK) H ON A.NO_SPK = H.NO_SPK AND B.NO_CONT = H.NO_CONT
			LEFT JOIN (SELECT NO_SPK,NO_CONT,WAKTU,WAKTU_END from t_op_reefer WHERE waktu IS NOT NULL) M ON B.NO_CONT = M.NO_CONT AND M.NO_SPK = A.NO_SPK
			WHERE B.STATUS_CONT IN ('450','510','530','520','540','460','900') AND A.WK_REQ > DATE_ADD(NOW() , INTERVAL -2 MONTH)) az where 1=1";

		$SQLTEMP2 = "SELECT distinct * FROM (
			SELECT A.NO_SPK AS 'NO SPK',A.WK_REQ,B.STATUS_CONT, B.NO_CONT AS 'KONTAINER',case when F.FL_REEFER = 'Y' then 'REEFER' when F.FL_OOG = 'Y' then 'OOG' ELSE 'DRY' END  AS 'TIPE_CONT',
			B.UKR_CONT AS 'SIZE', CASE WHEN F.KD_CONT_JENIS = 'F' THEN 'FULL' ELSE 'EMPTY' END AS 'STATUS',case when F.FL_DG = 'Y' then 'DG' end AS 'DG', A.WK_REQ AS 'TERBIT SPK'
			, E.NAMA AS 'JENIS DOKUMEN', A.NO_DOK AS 'NO DOKUMEN', A.TGL_DOK AS 'TGL DOKUMEN', B.ID_FLAT AS 'TID'
			, CONCAT((B.LOKASI),'0',(B.TIER)) AS 'LOKASI'
			, CASE WHEN B.STATUS_CONT IN ('450','510','530') AND B.LOKASI LIKE '1A%' THEN 'STACKING YARD 1A' WHEN B.STATUS_CONT IN ('450','510','530') AND B.LOKASI LIKE '1B%' THEN 'STACKING YARD 1B' WHEN B.STATUS_CONT IN ('460','520','540') THEN 'STACKING CIC' ELSE 'DELIVERY' END AS 'KETERANGAN', G.CONSIGNEE AS 'CUSTOMER',
			F.PLUG_TERMINAL AS 'PLUG NPCT1',F.UNPLUG_TERMINAL AS 'UNPLUG NPCT1',M.WAKTU AS 'PLUG CA',M.WAKTU_END AS 'UNPLUG CA'
			FROM t_spk A
			JOIN t_spk_cont B ON A.ID = B.ID
			LEFT JOIN reff_kode_dok_bc E ON E.ID = A.JNS_DOK
			LEFT JOIN t_request G ON G.NO_DOK = A.NO_DOK AND G.TGL_DOK = A.TGL_DOK
			LEFT JOIN t_request_cont F ON F.ID = G.ID AND F.KD_STATUS = 'INQUIRY' AND F.NO_CONT = B.NO_CONT
			LEFT JOIN ( SELECT A.NO_SPK, B.NO_CONT, A.W_PICKUP, W_BEHANDLE, B.KONDISI_CONT, B.NO_SEAL, B.ROOM FROM t_op_pickup A INNER JOIN t_op_behandlein B ON A.NO_SPK = B.NO_SPK) H ON A.NO_SPK = H.NO_SPK AND B.NO_CONT = H.NO_CONT
			LEFT JOIN (SELECT NO_SPK,NO_CONT,WAKTU,WAKTU_END from t_op_reefer WHERE waktu IS NOT NULL) M ON B.NO_CONT = M.NO_CONT AND M.NO_SPK = A.NO_SPK
			WHERE B.STATUS_CONT IN ('450','510','530','520','540','460','900') AND A.WK_REQ > DATE_ADD(NOW() , INTERVAL -4 MONTH)) az where 1=1";
		$SQLTEMP3 = "SELECT distinct * FROM (
			SELECT A.NO_SPK AS 'NO SPK',A.WK_REQ,B.STATUS_CONT, B.NO_CONT AS 'KONTAINER',case when F.FL_REEFER = 'Y' then 'REEFER' when F.FL_OOG = 'Y' then 'OOG' ELSE 'DRY' END  AS 'TIPE_CONT',
			B.UKR_CONT AS 'SIZE', CASE WHEN F.KD_CONT_JENIS = 'F' THEN 'FULL' ELSE 'EMPTY' END AS 'STATUS',case when F.FL_DG = 'Y' then 'DG' end AS 'DG', A.WK_REQ AS 'TERBIT SPK'
			, E.NAMA AS 'JENIS DOKUMEN', A.NO_DOK AS 'NO DOKUMEN', A.TGL_DOK AS 'TGL DOKUMEN', B.ID_FLAT AS 'TID'
			, CONCAT((B.LOKASI),'0',(B.TIER)) AS 'LOKASI'
			, CASE WHEN B.STATUS_CONT IN ('450','510','530') AND B.LOKASI LIKE '1A%' THEN 'STACKING YARD 1A' WHEN B.STATUS_CONT IN ('450','510','530') AND B.LOKASI LIKE '1B%' THEN 'STACKING YARD 1B' WHEN B.STATUS_CONT IN ('460','520','540') THEN 'STACKING CIC' ELSE 'DELIVERY' END AS 'KETERANGAN', G.CONSIGNEE AS 'CUSTOMER',
			F.PLUG_TERMINAL AS 'PLUG NPCT1',F.UNPLUG_TERMINAL AS 'UNPLUG NPCT1',M.WAKTU AS 'PLUG CA',M.WAKTU_END AS 'UNPLUG CA'
			FROM t_spk A
			JOIN t_spk_cont B ON A.ID = B.ID
			LEFT JOIN reff_kode_dok_bc E ON E.ID = A.JNS_DOK
			LEFT JOIN t_request G ON G.NO_DOK = A.NO_DOK AND G.TGL_DOK = A.TGL_DOK
			LEFT JOIN t_request_cont F ON F.ID = G.ID AND F.KD_STATUS = 'INQUIRY' AND F.NO_CONT = B.NO_CONT
			LEFT JOIN ( SELECT A.NO_SPK, B.NO_CONT, A.W_PICKUP, W_BEHANDLE, B.KONDISI_CONT, B.NO_SEAL, B.ROOM FROM t_op_pickup A INNER JOIN t_op_behandlein B ON A.NO_SPK = B.NO_SPK) H ON A.NO_SPK = H.NO_SPK AND B.NO_CONT = H.NO_CONT
			LEFT JOIN (SELECT NO_SPK,NO_CONT,WAKTU,WAKTU_END from t_op_reefer WHERE waktu IS NOT NULL) M ON B.NO_CONT = M.NO_CONT AND M.NO_SPK = A.NO_SPK
			WHERE B.STATUS_CONT IN ('450','510','530','520','540','460','900')) az where 1=1";
		$SQLTEMP4k = "SELECT distinct * FROM (
			SELECT A.NO_SPK AS 'NO SPK',A.WK_REQ,B.STATUS_CONT, B.NO_CONT AS 'KONTAINER',case when F.FL_REEFER = 'Y' then 'REEFER' when F.FL_OOG = 'Y' then 'OOG' ELSE 'DRY' END  AS 'TIPE_CONT',
			B.UKR_CONT AS 'SIZE', CASE WHEN F.KD_CONT_JENIS = 'F' THEN 'FULL' ELSE 'EMPTY' END AS 'STATUS',case when F.FL_DG = 'Y' then 'DG' end AS 'DG', A.WK_REQ AS 'TERBIT SPK'
			, E.NAMA AS 'JENIS DOKUMEN', A.NO_DOK AS 'NO DOKUMEN', A.TGL_DOK AS 'TGL DOKUMEN', B.ID_FLAT AS 'TID'
			, CONCAT((B.LOKASI),'0',(B.TIER)) AS 'LOKASI'
			, CASE WHEN B.STATUS_CONT IN ('450','510','530') AND B.LOKASI LIKE '1A%' THEN 'STACKING YARD 1A' WHEN B.STATUS_CONT IN ('450','510','530') AND B.LOKASI LIKE '1B%' THEN 'STACKING YARD 1B' WHEN B.STATUS_CONT IN ('460','520','540') THEN 'STACKING CIC' ELSE 'DELIVERY' END AS 'KETERANGAN', G.CONSIGNEE AS 'CUSTOMER',
			F.PLUG_TERMINAL AS 'PLUG NPCT1',F.UNPLUG_TERMINAL AS 'UNPLUG NPCT1',M.WAKTU AS 'PLUG CA',M.WAKTU_END AS 'UNPLUG CA'
			FROM t_spk A
			JOIN t_spk_cont B ON A.ID = B.ID
			LEFT JOIN reff_kode_dok_bc E ON E.ID = A.JNS_DOK
			LEFT JOIN t_request G ON G.NO_DOK = A.NO_DOK AND G.TGL_DOK = A.TGL_DOK
			LEFT JOIN t_request_cont F ON F.ID = G.ID AND F.KD_STATUS = 'INQUIRY' AND F.NO_CONT = B.NO_CONT
			LEFT JOIN ( SELECT A.NO_SPK, B.NO_CONT, A.W_PICKUP, W_BEHANDLE, B.KONDISI_CONT, B.NO_SEAL, B.ROOM FROM t_op_pickup A INNER JOIN t_op_behandlein B ON A.NO_SPK = B.NO_SPK) H ON A.NO_SPK = H.NO_SPK AND B.NO_CONT = H.NO_CONT
			LEFT JOIN (SELECT NO_SPK,NO_CONT,WAKTU,WAKTU_END from t_op_reefer WHERE waktu IS NOT NULL) M ON B.NO_CONT = M.NO_CONT AND M.NO_SPK = A.NO_SPK
			WHERE B.STATUS_CONT IN ('450','510','530','520','540','460','900')) az where 1=1";

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
				} else {
					if ($p_khusus == "") {
						$SQL = $SQLTEMP2;
					} else {
						if ($_POST['form'][1][0] == "1B%") {
							$SQL = $SQLTEMP4k;
						} else {
							$SQL = $SQLTEMP3;
						}
					}
				}
			} else {
				$SQL = $SQLTEMP1; //jika bukan page 1
			}
		} else {
			$SQL = $SQLTEMP1; //jika bukan ajax
		}


		$this->newtable->multiple_search(true);
		$this->newtable->show_chk(false);
		$this->newtable->show_menu($check);
		$this->newtable->show_search(true);
		$proses = array('EXPORT STACKING' => array('EXCEL', "process/excel/stacking/" . $act, '0', '', 'md-file-text', '', 'menu'));
		$arr_sts = array("" => "", "450,510,530" => "STACKING YARD", "460,520,540" => "STACKING CIC");
		$arr_sts_lokasi = array("" => "", "1A%" => "STACKING 1A", "1B%" => "STACKING 1B");
		$this->newtable->search(array(array('az.STATUS_CONT', 'STATUS KONTAINER', 'FILTERIN', $arr_sts), array('az.LOKASI', 'STATUS LOKASI', 'OPTION', $arr_sts_lokasi), array('az.WK_REQ', 'TANGGAL SPK TERBIT', 'DATETIMERANGE')));
		$this->newtable->action(site_url() . "/report/stacking");
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("WK_REQ", "STATUS_CONT"));
		$this->newtable->keys(array(""));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby("az.WK_REQ DESC");
		$this->newtable->sortby("");
		$this->newtable->set_formid("tblstacking");
		$this->newtable->set_divid("divstacking");
		$this->newtable->rowcount(100);
		$this->newtable->clear();
		$this->newtable->menu($proses);
		$tabel .= $this->newtable->generate($SQL);

		if ($this->input->post("ajax") || $act == "post") {
			echo $tabel;
		} else {
			$arrdata = array("page_title" => $page_title, "title" => $title, "content" => $tabel);
			return $arrdata;
		}
	}

	function terbit_gatepass()
	{
		$page_title = "TERBIT GATEPASS";
		$title = "TERBIT GATEPASS";
		$this->newtable->breadcrumb('Dashboard', site_url(), 'icon-home');
		$this->newtable->breadcrumb('Report', 'javascript:void(0)', '');
		$this->newtable->breadcrumb('TERBIT GATEPASS', 'javascript:void(0)', '');
		$check = (grant() == "W") ? true : false;

		$SQL = "SELECT A.NO_SPK AS 'NO SPK', B.NO_CONT AS 'KONTAINER', B.UKR_CONT AS 'SIZE', CASE WHEN D.STATUS_CONT = 'F' THEN 'FULL' ELSE 'EMPTY' END AS 'STATUS', A.WK_REQ AS 'TERBIT SPK', F.NAMA AS 'JENIS DOKUMEN', A.NO_DOK AS 'NO DOKUMEN', A.TGL_DOK AS 'TGL DOKUMEN', B.ID_FLAT AS 'TID', CONCAT((B.LOKASI),'0',(B.TIER)) AS 'LOKASI', CASE WHEN C.ID IS NOT NULL THEN 'TERBIT GATEPASS' ELSE 'BELUM TERBIT GATEPASS' END AS 'KETERANGAN', A.CONSIGNEE AS 'CUSTOMER'
			FROM t_spk A
			INNER JOIN t_spk_cont B ON A.ID = B.ID
			LEFT JOIN t_gatepass C ON A.NO_DOK = C.NO_DOK AND B.NO_CONT = C.NO_CONT AND C.JNS_KEGIATAN = 1
			LEFT JOIN (SELECT ID, NO_CONT, JNS_CONT AS 'STATUS_CONT', ISO_CODE, KD_CONT_TIPE AS 'TIPE_CONT', WK_IN AS 'STACKING' FROM t_cocostscont GROUP BY NO_CONT ORDER BY ID DESC) D ON B.NO_CONT = D.NO_CONT
			LEFT JOIN t_cocostshdr E ON D.ID = E.ID
			LEFT JOIN reff_kode_dok_bc F ON A.JNS_DOK = F.ID
			LEFT JOIN (SELECT ID, NO_CONT, IMO FROM t_request_cont GROUP BY NO_CONT ORDER BY ID DESC) G ON B.NO_CONT = G.NO_CONT
			LEFT JOIN t_request H ON F.ID = H.ID
			LEFT JOIN (SELECT A.NO_SPK, B.NO_CONT, A.W_PICKUP, W_BEHANDLE, B.KONDISI_CONT, B.NO_SEAL, B.ROOM FROM t_op_pickup A INNER JOIN t_op_behandlein B ON A.NO_SPK = B.NO_SPK) I ON A.NO_SPK = I.NO_SPK AND B.NO_CONT = I.NO_CONT
			WHERE B.LOKASI LIKE '1B%' AND B.STATUS_CONT IN (450)";

		$this->newtable->multiple_search(true);
		$this->newtable->show_chk(false);
		$this->newtable->show_menu($check);
		$this->newtable->show_search(true);
		$proses = array('EXPORT TERBIT GATEPASS' => array('EXCEL', "process/excel/terbit_gatepass/" . $act, '0', '', 'md-file-text', '', 'menu'));
		$arr_sts = array("" => "", "NOT NULL" => "TERBIT GATEPASS", "NULL" => "BELUM TERBIT GATEPASS");
		$this->newtable->search(array(array('C.ID', 'STATUS GATEPASS', 'OPTIONIS', $arr_sts), array('A.WK_REQ', 'TANGGAL SPK TERBIT', 'DATETIMERANGE')));
		$this->newtable->action(site_url() . "/report/terbit_gatepass");
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array(""));
		$this->newtable->keys(array(""));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby("A.WK_REQ DESC");
		$this->newtable->sortby("");
		$this->newtable->set_formid("tbltrbgatepass");
		$this->newtable->set_divid("divtrbgatepass");
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

	function penarikan()
	{
		$page_title = "REPORT PENARIKAN BEHANDLEIN";
		$title = "REPORT PENARIKAN BEHANDLEIN";
		$this->newtable->breadcrumb('Dashboard', site_url(), 'icon-home');
		$this->newtable->breadcrumb('Monitoring', 'javascript:void(0)', '');
		$this->newtable->breadcrumb('PENARIKAN', 'javascript:void(0)', '');
		$check = (grant() == "W") ? true : false;

		// $SQL = "SELECT A.NO_SPK AS 'NO SPK', B.NO_CONT AS 'KONTAINER', B.UKR_CONT AS 'SIZE', D.NM_ANGKUT AS 'NAMA KAPAL', CASE WHEN C.STATUS_CONT ='F' THEN 'FL' ELSE 'MT' END AS 'STATUS', B.ISO_CODE AS 'ISO CODE', C.TIPE_CONT AS 'TIPE', F.IMO, E.NAMA AS 'JENIS DOKUMEN', A.NO_DOK AS 'NO DOKUMEN', A.TGL_DOK AS 'TGL DOKUMEN', H.W_PICKUP AS 'PICKUP', B.ID_FLAT AS 'TID', H.W_BEHANDLE AS 'BEHANDLE IN', A.CONSIGNEE AS 'CUSTOMERS', CASE WHEN B.STATUS_CONT IN('450','460','500','510','520','530','540','600','800','850','870','900') THEN '<span class=\"label label-warning\">ON COMMON AREA</span>' WHEN B.STATUS_CONT = '200' THEN '<span class=\"label label-warning\"style=\"background: yellow\"><font color=\"black\">ON PROCESS</font></span>' ELSE '<span class=\"label label-success\">ON TERMINAL</span>' END AS 'STATUS PENARIKAN'
		// FROM t_spk A
		// LEFT JOIN t_spk_cont B ON A.ID = B.ID
		// LEFT JOIN (SELECT ID, NO_CONT, JNS_CONT AS 'STATUS_CONT', ISO_CODE, KD_CONT_TIPE AS 'TIPE_CONT', WK_IN AS 'STACKING', WK_OUT AS 'GATEOUT' FROM t_cocostscont GROUP BY NO_CONT ORDER BY ID DESC) C ON B.NO_CONT = C.NO_CONT
		// LEFT JOIN t_cocostshdr D ON C.ID = D.ID
		// INNER JOIN reff_kode_dok_bc E ON A.JNS_DOK = E.ID
		// LEFT JOIN (SELECT ID, NO_CONT, IMO FROM t_request_cont GROUP BY NO_CONT ORDER BY ID DESC) F ON B.NO_CONT = F.NO_CONT
		// LEFT JOIN t_request G ON F.ID = G.ID
		// INNER JOIN (SELECT B.NO_SPK, B.NO_CONT, A.W_PICKUP, B.W_BEHANDLE, B.KONDISI_CONT, B.NO_SEAL, B.ROOM FROM (SELECT NO_SPK,W_PICKUP FROM t_op_pickup where date(W_PICKUP) > DATE_ADD(NOW() , INTERVAL -6 MONTH) GROUP BY NO_SPK) A INNER JOIN t_op_behandlein B ON A.NO_SPK = B.NO_SPK ORDER BY B.ID DESC) H ON A.NO_SPK = H.NO_SPK AND B.NO_CONT = H.NO_CONT
		// LEFT JOIN reff_kondisi I ON H.KONDISI_CONT = I.ID
		// WHERE date(A.WK_REQ) > DATE_ADD(NOW() , INTERVAL -6 MONTH) and 1 = 1";

		$SQL = "SELECT 
						A.NO_SPK AS 'NO SPK',
						B.NO_CONT AS 'KONTAINER',
						B.UKR_CONT AS 'SIZE',
						E.NM_ANGKUT ,
						CASE
							WHEN D.KD_CONT_JENIS = 'F' THEN 'FL'
							ELSE 'MT'
						END AS 'STATUS',
						D.ISO_CODE AS 'ISO CODE',
						D.TIPE_CONT AS 'TIPE',
						D.IMO,
						AA.NAMA AS 'JENIS DOKUMEN',
						A.NO_DOK AS 'NO DOKUMEN',
						A.TGL_DOK AS 'TGL DOKUMEN',
						F.WK_TERMINAL_IN as 'IN TERMINAL',
						F.WK_TERMINAL_OUT as 'OUT TERMINAL',
						F.WK_PICKUP AS 'PICKUP',
						F.WK_IN  AS 'BEHANDLE IN',
							A.CONSIGNEE AS 'CUSTOMERS',
						CASE WHEN B.STATUS_CONT IN('450','460','500','510','520','530','540','600','800','850','870','900') THEN '<span class=\"label label-warning\">ON COMMON AREA</span>' WHEN B.STATUS_CONT = '200' THEN '<span class=\"label label-warning\"style=\"background: yellow\"><font color=\"black\">ON PROCESS</font></span>' ELSE '<span class=\"label label-success\">ON TERMINAL</span>' END AS 'STATUS PENARIKAN'
						from t_spk A join t_spk_cont B on A.ID = B.ID
						left join reff_kode_dok_bc AA on A.JNS_DOK = AA.ID
					join t_request C on A.NO_DOK = C.NO_DOK and A.TGL_DOK = C.TGL_DOK
					join t_request_cont D on C.ID = D.ID and D.NO_CONT = B.NO_CONT
					left join t_cocostshdr E on D.VESSEL = E.NM_ANGKUT and D.VOY_IN = E.NO_VOY_FLIGHT 
					left join t_operation F on A.NO_SPK = F.NO_SPK and B.NO_CONT = F.NO_CONT
					WHERE date(A.WK_REQ) > DATE_ADD(NOW() , INTERVAL -9 MONTH) and 1 = 1";

		$this->newtable->multiple_search(true);
		$this->newtable->show_chk(false);
		$this->newtable->show_menu($check);
		$this->newtable->show_search(true);
		$proses = array('EXPORT EXCEL PENARIKAN - BEHANDLE IN' => array('EXCEL', "process1/excel/penarikan1/" . $act, '0', '', 'md-file-text', '', 'menu'));
		$arr_sts = array("" => "", "450" => "ON COMMON AREA", "200" => "ON PROCESS");
		$this->newtable->search(array(array('B.STATUS_CONT', 'STATUS PENARIKAN', 'OPTION', $arr_sts), array('F.WK_IN', 'TANGGAL BEHANDLE IN', 'DATETIMERANGE'), array('F.W_PICKUP', 'WAKTU PICKUP', 'DATETIMERANGE')));
		$this->newtable->action(site_url() . "/report/penarikan");
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens();
		$this->newtable->keys(array("NO SPK"));
		$this->newtable->cidb($this->db);
		$this->newtable->groupby();
		$this->newtable->orderby("F.WK_IN DESC");
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

	public function behandle($act, $id)
	{
		$func = get_instance();
		$func->load->model("m_main", "main", true);
		$title = "REPORT BEHANDLE " . strtoupper($act);
		$KD_TPS = $this->session->userdata('KD_TPS');
		$KD_GUDANG = $this->session->userdata('KD_GUDANG');
		$KD_GROUP = $this->session->userdata('KD_GROUP');
		$this->newtable->breadcrumb('Dashboard', site_url(), 'icon-home');
		$this->newtable->breadcrumb('Report', 'javascript:void(0)', '');
		$this->newtable->breadcrumb('Behandle', 'javascript:void(0)', '');
		$this->newtable->breadcrumb(strtoupper($act), 'javascript:void(0)', '');
		$check = (grant() == "W") ? true : false;
		$addsql = "";
		$SQL = "SELECT A.ID AS 'ID',CONCAT('',(B.NO_CONT),'<BR>',(B.UKR_CONT)) AS 'KONTAINER', CASE WHEN LEFT(B.LOKASI,3) = 'CIC' THEN 
				B.LOKASI ELSE CONCAT(B.LOKASI,'0', TIER) END AS 'LOKASI', 
				CONCAT('',(A.NO_SPK),'<BR>',(A.TGL_SPK)) AS 'SPK',
				D.W_BEHANDLE AS 'TANGGAL BEHANDLE',
				CONCAT('',(A.NM_KAPAL),'<BR>',(A.NO_VOY)) AS 'KAPAL', A.CONSIGNEE, C.KETERANGAN AS 'STATUS'
				FROM t_spk A, t_spk_cont B 
				INNER JOIN reff_status_spk C ON C.ID = B.STATUS_CONT
				LEFT JOIN t_op_behandlein D ON D.NO_CONT = B.NO_CONT
				WHERE A.ID = B.ID" . $addsql;
		$this->newtable->multiple_search(true);
		$this->newtable->show_chk(false);
		$this->newtable->show_menu($check);
		$this->newtable->show_search(true);
		$proses = array('EXPORT EXCEL 1' => array('EXCEL', "process/excel/behandle/" . $act, '0', '', 'md-file-text', '', 'menu'));
		$this->newtable->search(array(array('B.NO_CONT', 'NO. CONTAINER'), array('D.W_BEHANDLE', 'TANGGAL BEHANDLE', 'DATETIMERANGE')));
		$this->newtable->action(site_url() . "/report/behandle/" . $act);
		//if($check) $this->newtable->detail(array('POPUP',"dokumen/bc11/detail"));
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array('ID'));
		$this->newtable->keys(array("B.NO_CONT"));
		$this->newtable->validasi(array());
		$this->newtable->cidb($this->db);
		$this->newtable->orderby("A.ID");
		$this->newtable->groupby();
		$this->newtable->sortby("DESC");
		$this->newtable->set_formid("tblreport");
		$this->newtable->set_divid("divtblreport");
		$this->newtable->rowcount(50);
		$this->newtable->clear();
		$this->newtable->menu($proses);
		$tabel .= $this->newtable->generate($SQL);
		$arrdata = array("page_title" => $page_title, "title" => $title, "content" => $tabel);
		if ($this->input->post("ajax") || $act == "post")
			return $tabel;
		else
			return $arrdata;
	}

	public function bilbehandle($act, $id)
	{
		$func = get_instance();
		$func->load->model("m_main", "main", true);
		$title = "REPORT BILLING BEHANDLE " . strtoupper($act);
		$KD_TPS = $this->session->userdata('KD_TPS');
		$KD_GUDANG = $this->session->userdata('KD_GUDANG');
		$KD_GROUP = $this->session->userdata('KD_GROUP');
		$this->newtable->breadcrumb('Dashboard', site_url(), 'icon-home');
		$this->newtable->breadcrumb('Report', 'javascript:void(0)', '');
		$this->newtable->breadcrumb('Billing Behandle', 'javascript:void(0)', '');
		$this->newtable->breadcrumb(strtoupper($act), 'javascript:void(0)', '');
		$check = (grant() == "W") ? true : false;
		$addsql = "";
		$SQL = "SELECT A.ID_REQ AS 'ID REQUEST',A.TGL_REQ AS 'TANGGAL REQUEST', A.NO_NOTA_BEHANDLE AS 'NO. NOTA BEHANDLE', A.TGL_NOTA AS 'TANGGAL NOTA', A.TOTAL_JUMLAH AS 'TOTAL', A.NAMA_CUST AS 'NAMA CUSTOMER', A.NPWP 
				FROM req_behandle_hdr A
				WHERE 1=1" . $addsql;
		$this->newtable->multiple_search(true);
		$this->newtable->show_chk(false);
		$this->newtable->show_menu($check);
		$this->newtable->show_search(true);
		$proses = array(
			'PRANOTA' => array('EXCEL', "process/excel/bilbehandle2/" . $act, '0', '', 'md-file', '', 'menu'),
			'NOTA' => array('EXCEL', "process/excel/bilbehandle/" . $act, '0', '', 'md-file-text', '', 'menu')
		);
		$this->newtable->search(array(array('A.NAMA_CUST', 'NAMA CUSTOMER'), array('A.TGL_NOTA', 'TGL. NOTA', 'DATERANGE'), array('A.TGL_REQ', 'TGL. REQUEST', 'DATERANGE')));
		$this->newtable->action(site_url() . "/report/bilbehandle/" . $act);
		//if($check) $this->newtable->detail(array('POPUP',"dokumen/bc11/detail"));
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array());
		$this->newtable->keys(array("ID_REQ"));
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
		if ($this->input->post("ajax") || $act == "post")
			return $tabel;
		else
			return $arrdata;
	}

	public function pergerakan($act, $id)
	{
		$func = get_instance();
		$func->load->model("m_main", "main", true);
		$title = "REPORT PERGERAKAN " . strtoupper($act);
		$KD_TPS = $this->session->userdata('KD_TPS');
		$KD_GUDANG = $this->session->userdata('KD_GUDANG');
		$KD_GROUP = $this->session->userdata('KD_GROUP');
		$this->newtable->breadcrumb('Dashboard', site_url(), 'icon-home');
		$this->newtable->breadcrumb('Report', 'javascript:void(0)', '');
		$this->newtable->breadcrumb('Pergerakan', 'javascript:void(0)', '');
		$this->newtable->breadcrumb(strtoupper($act), 'javascript:void(0)', '');
		$check = (grant() == "W") ? true : false;
		$addsql = "";
		$SQL = "SELECT A.NO_SPK AS 'NO. SPK',CONCAT('JENIS DOKUMEN : ',C.NAMA,'<BR>NO. DOKUMEN : ',A.NO_DOK,'<BR>TGL. DOKUMEN : ',A.TGL_DOK) AS 'DOKUMEN',
				CONCAT('NAMA KAPAL : ',A.NM_KAPAL,'<BR>NO. VOYAGE : ',A.NO_VOY) AS 'KAPAL',CONCAT('NPWP : ',A.NPWP,'<BR>CONSIGNEE : ',A.CONSIGNEE) AS 'CUSTOMER',
				CONCAT('NO. KONTAINER : ',B.NO_CONT,'<BR>UKURAN : ',B.UKR_CONT) AS 'KONTAINER'
					FROM t_spk A
					INNER JOIN t_spk_cont B ON A.ID = B.ID
					LEFT JOIN reff_kode_dok_bc C ON C.ID = A.JNS_DOK
					LEFT JOIN t_operation D ON A.NO_SPK = D.NO_SPK AND B.NO_CONT = D.NO_CONT WHERE 1=1" . $addsql;
		$this->newtable->multiple_search(true);
		$this->newtable->show_chk(false);
		$this->newtable->show_menu($check);
		$this->newtable->show_search(true);
		$proses = array('EXPORT EXCEL' => array('EXCEL', "process/excel/pergerakan/" . $act, '0', '', 'md-file-text', '', 'menu'));
		$this->newtable->search(array(array('A.NO_SPK', 'NO. SPK'), array('A.NO_DOK', 'NO. DOKUMEN'), array('A.NPWP', 'NPWP')));
		$this->newtable->action(site_url() . "/report/pergerakan/" . $act);
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
		if ($this->input->post("ajax") || $act == "post")
			return $tabel;
		else
			return $arrdata;
	}

	public function bildelivery($act, $id)
	{
		$func = get_instance();
		$func->load->model("m_main", "main", true);
		$title = "REPORT BILLING DELIVERY " . strtoupper($act);
		$KD_TPS = $this->session->userdata('KD_TPS');
		$KD_GUDANG = $this->session->userdata('KD_GUDANG');
		$KD_GROUP = $this->session->userdata('KD_GROUP');
		$this->newtable->breadcrumb('Dashboard', site_url(), 'icon-home');
		$this->newtable->breadcrumb('Report', 'javascript:void(0)', '');
		$this->newtable->breadcrumb('Billing Delivery', 'javascript:void(0)', '');
		$this->newtable->breadcrumb(strtoupper($act), 'javascript:void(0)', '');
		$check = (grant() == "W") ? true : false;
		$addsql = "";
		$SQL = "SELECT A.ID_REQ AS 'ID REQUEST',A.TGL_REQ AS 'TANGGAL REQUEST', A.NO_NOTA_DELIVERY AS 'NO. NOTA DELIVERY', A.TGL_NOTA AS 'TANGGAL NOTA', A.TOTAL, B.NAMA_CUST AS 'NAMA CUSTOMER', A.NPWP
				FROM req_delivery_hdr A
				INNER JOIN m_pelanggan B ON A.NPWP=B.NPWP
				WHERE 1=1 AND ID_REQ_OLD IS NULL" . $addsql;
		$this->newtable->multiple_search(true);
		$this->newtable->show_chk(false);
		$this->newtable->show_menu($check);
		$this->newtable->show_search(true);
		$proses = array(
			'PRANOTA' => array('EXCEL', "process/excel/bildelivery2/" . $act, '0', '', 'md-file', '', 'menu'),
			'NOTA' => array('EXCEL', "process/excel/bildelivery/" . $act, '0', '', 'md-file-text', '', 'menu')
		);
		$this->newtable->search(array(array('B.NAMA_CUST', 'NAMA CUSTOMER'), array('A.TGL_NOTA', 'TGL. NOTA', 'DATERANGE'), array('A.TGL_REQ', 'TGL. REQUEST', 'DATERANGE')));
		$this->newtable->action(site_url() . "/report/bildelivery/" . $act);
		//if($check) $this->newtable->detail(array('POPUP',"dokumen/bc11/detail"));
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array());
		$this->newtable->keys(array("ID_REQ"));
		$this->newtable->validasi(array());
		$this->newtable->cidb($this->db);
		$this->newtable->orderby(3);
		$this->newtable->sortby("DESC");
		$this->newtable->set_formid("tblreport");
		$this->newtable->set_divid("divtblreport");
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

	public function bilextention($act, $id)
	{
		$func = get_instance();
		$func->load->model("m_main", "main", true);
		$title = "REPORT BILLING EXTENTION " . strtoupper($act);
		$KD_TPS = $this->session->userdata('KD_TPS');
		$KD_GUDANG = $this->session->userdata('KD_GUDANG');
		$KD_GROUP = $this->session->userdata('KD_GROUP');
		$this->newtable->breadcrumb('Dashboard', site_url(), 'icon-home');
		$this->newtable->breadcrumb('Report', 'javascript:void(0)', '');
		$this->newtable->breadcrumb('Billing Extention', 'javascript:void(0)', '');
		$this->newtable->breadcrumb(strtoupper($act), 'javascript:void(0)', '');
		$check = (grant() == "W") ? true : false;
		$addsql = "";
		$SQL = "SELECT A.ID_REQ,A.TGL_REQ, A.NO_NOTA_DELIVERY, A.TGL_NOTA, A.TOTAL, B.NAMA_CUST
				FROM req_delivery_hdr A
				INNER JOIN m_pelanggan B ON A.NPWP=B.NPWP
				WHERE 1=1 AND ID_REQ_OLD IS NOT NULL " . $addsql;
		$this->newtable->multiple_search(true);
		$this->newtable->show_chk(false);
		$this->newtable->show_menu($check);
		$this->newtable->show_search(true);
		$proses = array(
			'PRANOTA' => array('EXCEL', "process/excel/bilextention2/" . $act, '0', '', 'md-file', '', 'menu'),
			'NOTA' => array('EXCEL', "process/excel/bilextention/" . $act, '0', '', 'md-file-text', '', 'menu')
		);
		$this->newtable->search(array(array('A.NAMA_CUST', 'NAMA CUSTOMER'), array('A.TGL_NOTA', 'TGL. NOTA', 'DATERANGE'), array('A.TGL_REQ', 'TGL. REQUEST', 'DATERANGE')));
		$this->newtable->action(site_url() . "/report/bilextention/" . $act);
		//if($check) $this->newtable->detail(array('POPUP',"dokumen/bc11/detail"));
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array());
		$this->newtable->keys(array("ID_REQ"));
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
		if ($this->input->post("ajax") || $act == "post")
			return $tabel;
		else
			return $arrdata;
	}

	public function monitoringbc($act, $id)
	{
		$func = get_instance();
		$func->load->model("m_main", "main", true);
		$title = "REPORT MONITORING BC " . strtoupper($act);
		$KD_TPS = $this->session->userdata('KD_TPS');
		$KD_GUDANG = $this->session->userdata('KD_GUDANG');
		$KD_GROUP = $this->session->userdata('KD_GROUP');
		$this->newtable->breadcrumb('Dashboard', site_url(), 'icon-home');
		$this->newtable->breadcrumb('Report', 'javascript:void(0)', '');
		$this->newtable->breadcrumb('Monitoring BC', 'javascript:void(0)', '');
		$this->newtable->breadcrumb(strtoupper($act), 'javascript:void(0)', '');
		$check = (grant() == "W") ? true : false;
		$SQL = "SELECT DISTINCT A.ID, B.NO_CONT AS 'NO KONTAINER', DATE_FORMAT(B.WK_IN, '%d-%m-%Y %H:%i:%s') AS 'WAKTU DISCHARGE', A.JNS_DOK AS 'JENIS DOKUMEN', F.NO_DAFTAR_PABEAN AS 'NO SPJM', DATE_FORMAT(F.TGL_DAFTAR_PABEAN, '%d-%m-%Y %H:%i:%s') AS 'WAKTU SPJM', 
					DATE_FORMAT(H.WK_REQ, '%d-%m-%Y %H:%i:%s') AS 'TERBIT SPK', DATE_FORMAT(C.WK_IN, '%d-%m-%Y %H:%i:%s') AS 'WAKTU BEHANDLE IN', DATE_FORMAT(D.WK_STATUS, '%d-%m-%Y %H:%i:%s') AS 'WAKTU TIMBUN CA', DATE_FORMAT(A.WK_REK, '%d-%m-%Y %H:%i:%s') AS 'WAKTU REQ KARTU BEHANDLE', DATE_FORMAT(A.WK_ACTIVE, '%d-%m-%Y %H:%i:%s') AS 'AKTIF KARTU BEHANDLE', DATE_FORMAT(A.WK_RESPON, '%d-%m-%Y %H:%i:%s') AS 'RESPON PPK',
					DATE_FORMAT(G.WK_STATUS, '%d-%m-%Y %H:%i:%s') AS 'SIAP PERIKSA', DATE_FORMAT(C.WK_START, '%d-%m-%Y %H:%i:%s') AS 'MULAI PERIKSA', DATE_FORMAT(C.WK_FINISH, '%d-%m-%Y %H:%i:%s') AS 'SELESAI PERIKSA', DATE_FORMAT(E.WK_STATUS, '%d-%m-%Y %H:%i:%s') AS 'MARSHALLING EX BEHANDLE',
					I.NO_DOK AS 'NO SPPB', DATE_FORMAT(I.TGL_DOK, '%d-%m-%Y') AS 'WAKTU SPPB'
				FROM t_gatepass A
				INNER JOIN (SELECT A.ID, A.NM_ANGKUT, A.NO_VOY_FLIGHT, B.NO_CONT, B.WK_IN FROM t_cocostshdr A INNER JOIN t_cocostscont B ON A.ID = B.ID WHERE B.WK_IN IS NOT NULL ORDER BY A.ID DESC) B ON A.NO_CONT = B.NO_CONT AND A.NM_KAPAL = B.NM_ANGKUT AND A.NO_VOY = B.NO_VOY_FLIGHT
				INNER JOIN t_operation C ON A.NO_DOK = C.NO_DOK AND A.NO_CONT = C.NO_CONT
				INNER JOIN (SELECT NO_CONT, NO_DOK, NO_SPK, NO_GATEPASS, LOKASI_AKHIR, WK_STATUS FROM t_job_slip WHERE LOKASI_AKHIR LIKE '1B%' GROUP BY NO_CONT ORDER BY ID_JOB_SLIP ASC) D ON B.NO_CONT = D.NO_CONT AND D.NO_DOK = A.NO_DOK
				INNER JOIN (SELECT NO_CONT, NO_DOK, NO_SPK, NO_GATEPASS, LOKASI_AKHIR, WK_STATUS FROM t_job_slip WHERE LOKASI_AKHIR LIKE '1A%' GROUP BY NO_CONT ORDER BY ID_JOB_SLIP DESC) E ON A.NO_CONT = E.NO_CONT AND E.NO_DOK = A.NO_DOK
				INNER JOIN (SELECT NO_CONT, NO_DOK, NO_SPK, NO_GATEPASS, LOKASI_AKHIR, WK_STATUS FROM t_job_slip WHERE LOKASI_AKHIR LIKE 'CIC%' GROUP BY NO_CONT ORDER BY ID_JOB_SLIP ASC) G ON B.NO_CONT = G.NO_CONT AND G.NO_DOK = A.NO_DOK
				INNER JOIN (SELECT A.ID, A.NO_CONT, B.NO_DAFTAR_PABEAN, B.TGL_DAFTAR_PABEAN FROM t_permit_cont A INNER JOIN t_permit_hdr B ON A.ID = B.ID GROUP BY A.NO_CONT ORDER BY A.ID DESC) F ON A.NO_CONT = F.NO_CONT AND F.NO_DAFTAR_PABEAN = A.NO_DOK	
				LEFT JOIN (SELECT ID, NO_CONT, NO_DOK, TGL_DOK FROM t_gatepass WHERE JNS_KEGIATAN=3) I ON A.NO_CONT = I.NO_CONT
				INNER JOIN t_spk H ON A.NO_DOK = H.NO_DOK
				
				WHERE A.JNS_DOK !='SPPMP' AND A.JNS_KEGIATAN ='1'";
		$this->newtable->multiple_search(true);
		$this->newtable->show_chk(false);
		$this->newtable->show_menu($check);
		$this->newtable->show_search(true);
		$proses = array('EXPORT' => array('EXCEL', "process/excel/monitoringbc/" . $act, '0', '', 'md-file-text', '', 'menu'));
		$this->newtable->search(array(array('A.TGL_DOK', 'TANGGAL', 'DATERANGE')));
		$this->newtable->action(site_url() . "/report/monitoringbc/" . $act);
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("ID"));
		$this->newtable->keys(array("ID"));
		$this->newtable->validasi(array());
		$this->newtable->cidb($this->db);
		$this->newtable->orderby("A.TGL_DOK");
		$this->newtable->sortby("DESC");
		$this->newtable->set_formid("tblreport");
		$this->newtable->set_divid("divtblreport");
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
	public function monitoringbcnew($act, $id)
	{
		$func = get_instance();
		$func->load->model("m_main", "main", true);
		$title = "REPORT MONITORING BC " . strtoupper($act);
		$KD_TPS = $this->session->userdata('KD_TPS');
		$KD_GUDANG = $this->session->userdata('KD_GUDANG');
		$KD_GROUP = $this->session->userdata('KD_GROUP');
		$this->newtable->breadcrumb('Dashboard', site_url(), 'icon-home');
		$this->newtable->breadcrumb('Report', 'javascript:void(0)', '');
		$this->newtable->breadcrumb('Monitoring BC', 'javascript:void(0)', '');
		$this->newtable->breadcrumb(strtoupper($act), 'javascript:void(0)', '');
		$check = (grant() == "W") ? true : false;
		$SQL = "SELECT distinct A.NO_CONT, A.NO_DOK, A.TGL_DOK, A.RESPON, A.WK_RESPON, 
					D.WK_REQ as 'WK_REQUEST_GATEPASS_TERMINAL', concat('') as 'APPROVE_GATEPASS_TERMINAL',
					A.NPWP, A.NAMA_CUST, E.NO_SPK, E.WK_REQ as 'TERBIT_SPK', 
					concat('') as 'Gate_In_terminal',
					concat('') as Gate_Out_Terminal, 
					G.WK_IN as 'BEHANDLE_IN',
					F.WK_STATUS as 'MARSHALLING_BEHANDLE_1',
					G.WK_START as 'START_PERIKSA',
					G.WK_FINISH as 'SELESAI_PERIKSA',
					H.WK_STATUS as 'MARSHALLING_EX-BEHANDLE_1',
					I.WK_TRUCKIN as 'TRUCK_IN',
					I.WK_GATEOUT as 'TRUCK_OUT'
					from t_gatepass A 
					join t_spk B on A.NO_DOK = B.NO_DOK and B.TGL_DOK = B.TGL_DOK
					join t_spk_cont C on B.ID = C.ID and C.NO_CONT = A.NO_CONT
					join (select tr.ID, tr.NO_DOK, tr.TGL_DOK, tr.WK_REQ from t_request tr join t_request_cont trc on tr.ID = trc.ID) D
					on D.NO_DOK = A.NO_DOK and D.TGL_DOK = A.TGL_DOK
					join t_spk E on A.NO_DOK = E.NO_DOK and A.TGL_DOK = E.TGL_DOK
					join t_job_slip F on A.NO_CONT = F.NO_CONT and F.NO_SPK = E.NO_SPK and F.JENIS = 'BEHANDLE 1'
					join t_operation G on G.NO_SPK = E.NO_SPK and G.NO_CONT = A.NO_CONT
					join t_job_slip H on A.NO_CONT = H.NO_CONT and H.NO_SPK = E.NO_SPK and H.JENIS = 'EX BEHANDLE 1'
					JOIN (
						    SELECT NO_CONT, NO_SPK, MAX(ID) as max_id
						    FROM t_op_delivery
						    GROUP BY NO_CONT, NO_SPK
						) I_max ON I_max.NO_CONT = A.NO_CONT AND I_max.NO_SPK = E.NO_SPK
						JOIN t_op_delivery I ON I.NO_CONT = I_max.NO_CONT AND I.NO_SPK = I_max.NO_SPK AND I.ID = I_max.max_id
					where A.JNS_DOK != 'SPPMP' and JNS_KEGIATAN = '1' 
					AND A.TGL_DOK >= CURDATE() - INTERVAL 2 YEAR";

		$this->newtable->multiple_search(true);
		$this->newtable->show_chk(false);
		$this->newtable->show_menu($check);
		$this->newtable->show_search(true);
		$proses = array('EXPORT' => array('EXCEL', "process/excel/monitoringbcnew/" . $act, '0', '', 'md-file-text', '', 'menu'));
		$this->newtable->search(array(array('A.TGL_DOK', 'TANGGAL', 'DATERANGE')));
		$this->newtable->action(site_url() . "/report/monitoringbcnew/" . $act);
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("ID"));
		$this->newtable->keys(array("ID"));
		$this->newtable->validasi(array());
		$this->newtable->cidb($this->db);
		$this->newtable->orderby("A.TGL_DOK");
		$this->newtable->sortby("DESC");
		$this->newtable->set_formid("tblreport");
		$this->newtable->set_divid("divtblreport");
		$this->newtable->rowcount(50);
		$this->newtable->clear();
		$this->newtable->menu($proses);
		$tabel .= $this->newtable->generate($SQL);
		$arrdata = array("page_title" => $page_title, "title" => $title, "content" => $tabel);
		if ($this->input->post("ajax") || $act == "post")
			return $tabel;
		else
			return $arrdata;
	}
	public function dashboard_monitoring($act, $id)
	{
		$func = get_instance();
		$func->load->model("m_main", "main", true);
		$page_title = "MONITORING BEA CUKAI";
		$title = "MONITORING KONTAINER";
		$this->newtable->breadcrumb('Dashboard', site_url(), 'icon-home');
		$this->newtable->breadcrumb('Monitoring', 'javascript:void(0)', '');
		$this->newtable->breadcrumb('Monitoring BC', 'javascript:void(0)', '');

		$SQL = "SELECT A.ID, CONCAT('NO :&nbsp',C.NO_DOK,'<BR>TGL DOKUMEN :&nbsp',C.TGL_DOK) AS 'DOKUMEN', I.CONSIGNEE AS 'NAMA CUSTOMER',
		B.NO_CONT AS 'KONTAINER',B.UKR_CONT AS 'SIZE',
		CASE 
			WHEN B.STATUS_CONT = '510' AND C.FL_ACTIVE = 'Y' AND F.START_INSP IS NULL AND F.FINISH_INSP IS NULL THEN
				CASE
					WHEN C.RESPON = 'PKB PRIORITAS'
						THEN '<span class=\"label label-info\">PERCEPATAN</span>'
					WHEN C.RESPON IN('PKB LR', 'PKB YARD', 'PKB YARD N')
						THEN '<span class=\"label label-success\">PKB</span>'
					END
			WHEN B.STATUS_CONT = '460' AND F.START_INSP IS NULL AND F.FINISH_INSP IS NULL AND C.JNS_KEGIATAN ='1' AND C.RESPON IS NOT NULL 
				THEN '<span class=\"label label-success\">SIAP PERIKSA</span>'
			WHEN B.STATUS_CONT ='460' AND C.JNS_KEGIATAN='2' AND C.RESPON IS NOT NULL  
				THEN '<span class=\"label label-success\">SIAP PERIKSA</span>'
			WHEN B.STATUS_CONT = '460' AND F.START_INSP IS NOT NULL AND F.FINISH_INSP IS NULL 
				THEN '<span class=\"label label-warning\">SEDANG PERIKSA</span>'
			WHEN B.STATUS_CONT IN ('500','540','520') 
				THEN '<span class=\"label label-success\">SELESAI PERIKSA</span>'
			ELSE '<span class=\"label label-danger\">BELUM PKB</span>'
		END AS 'STATUS',
		DATE_FORMAT(C.WK_RESPON, '%d-%m-%Y %h:%m:%s') AS 'WAKTU PKB', CONCAT(B.LOKASI,'0',B.TIER) AS 'LOKASI'
		FROM t_spk A
		LEFT JOIN t_spk_cont B ON A.ID = B.ID
		LEFT JOIN t_gatepass C ON B.NO_CONT = C.NO_CONT AND C.`STATUS` = 'WAITING'
		INNER JOIN t_request D ON C.NO_DOK = D.NO_DOK
		LEFT JOIN reff_status_spk E ON B.STATUS_CONT = E.ID
		LEFT JOIN t_op_inspection F ON F.NO_CONT = B.NO_CONT AND C.NO_DOK = F.NO_DOK
		LEFT JOIN reff_kode_dok_bc G ON D.JNS_DOK = G.ID
		LEFT JOIN t_job_slip H ON H.NO_CONT = B.NO_CONT AND h.LOKASI_AKHIR LIKE'%CIC%'
		LEFT JOIN t_request I ON A.NO_DOK = I.NO_DOK
		WHERE B.STATUS_CONT IN('460','500','510','530','540','520') AND G.ID != 83";

		$this->newtable->multiple_search(true);
		$this->newtable->show_chk(false);
		$this->newtable->show_menu($check);
		$this->newtable->show_search(true);
		$this->newtable->search(array(array('C.NO_DOK', 'NO. SPJM'), array('C.TGL_DOK', 'TGL SPJM', 'DATERANGE'), array('B.NO_CONT', 'NO. KONTAINER')));
		$this->newtable->action(site_url() . "/report/dashboard_monitoring");
		$this->newtable->detail(array('DRILLDOWN', "report/dashboard_monitoring/detail/"));
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens("ID");
		$this->newtable->keys("ID");
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

	public function monthly($act, $id)
	{
		$func = get_instance();
		$func->load->model("m_main", "main", true);
		$title = "REPORT MONTHLY " . strtoupper($act);
		$KD_TPS = $this->session->userdata('KD_TPS');
		$KD_GUDANG = $this->session->userdata('KD_GUDANG');
		$KD_GROUP = $this->session->userdata('KD_GROUP');
		$this->newtable->breadcrumb('Dashboard', site_url(), 'icon-home');
		$this->newtable->breadcrumb('Report', 'javascript:void(0)', '');
		$this->newtable->breadcrumb('Monthly', 'javascript:void(0)', '');
		$this->newtable->breadcrumb(strtoupper($act), 'javascript:void(0)', '');
		$check = (grant() == "W") ? true : false;
		$addsql = "";
		if ($act == "impor")
			$addsql .= " AND A.KD_ASAL_BRG = '1'";
		elseif ($act == "ekspor")
			$addsql .= " AND A.KD_ASAL_BRG = '3'";
		else
			$addsql .= " AND A.KD_ASAL_BRG = '0'";
		$SQL = "SELECT E.NAMA AS 'ASAL BARANG', CONCAT(IFNULL(C.NAMA,'-'),'<BR>[',IFNULL(A.NM_ANGKUT,'-'),']') AS 'NAMA ANGKUT',
				A.NO_VOY_FLIGHT AS 'NO. VOYAGE/FLIGHT',
				DATE_FORMAT(A.TGL_TIBA,'%d-%m-%Y') AS 'TGL. TIBA', A.NO_BC11 AS 'NO. BC11',
				DATE_FORMAT(A.TGL_BC11,'%d-%m-%Y') AS 'TGL. BC11', D.NO_CONT AS 'NO. KONTAINER', D.KD_CONT_UKURAN AS UKURAN
				FROM t_cocostshdr A
				LEFT JOIN reff_gudang B ON A.KD_TPS = B.KD_TPS AND A.KD_GUDANG = B.KD_GUDANG
				LEFT JOIN reff_kapal C ON A.KD_KAPAL = C.ID
				INNER JOIN t_cocostscont D ON D.ID=A.ID
				LEFT JOIN reff_asal_brg E ON E.ID=A.KD_ASAL_BRG
				WHERE 1=1" . $addsql;
		$this->newtable->multiple_search(true);
		$this->newtable->show_chk(false);
		$this->newtable->show_menu($check);
		$this->newtable->show_search(true);
		$proses = array('EXPORT EXCEL' => array('EXCEL', "report/process/excel/monthly/" . $act, '0', '', 'md-file-text', '', '1'));
		$this->newtable->search(array(array('A.TGL_TIBA', 'TGL. TIBA', 'DATERANGE'), array('D.NO_CONT', 'NO. KONTAINER')));
		$this->newtable->action(site_url() . "/report/monthly/" . $act);
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
		if ($this->input->post("ajax") || $act == "post")
			return $tabel;
		else
			return $arrdata;
	}

	public function repository($act, $id)
	{
		$func = get_instance();
		$func->load->model("m_main", "main", true);
		$title = "REPORT REPOSITORY " . strtoupper($act);
		$KD_TPS = $this->session->userdata('KD_TPS');
		$KD_GUDANG = $this->session->userdata('KD_GUDANG');
		$KD_GROUP = $this->session->userdata('KD_GROUP');
		$this->newtable->breadcrumb('Dashboard', site_url(), 'icon-home');
		$this->newtable->breadcrumb('Report', 'javascript:void(0)', '');
		$this->newtable->breadcrumb('Repository', 'javascript:void(0)', '');
		$this->newtable->breadcrumb(strtoupper($act), 'javascript:void(0)', '');
		$check = (grant() == "W") ? true : false;
		$addsql = "";
		if ($act == "impor")
			$addsql .= " AND A.KD_ASAL_BRG IN ('1','2')";
		elseif ($act == "ekspor")
			$addsql .= " AND A.KD_ASAL_BRG IN ('3','4')";
		else
			$addsql .= " AND A.KD_ASAL_BRG = '0'";
		$SQL = "SELECT A.URAIAN_DOKUMEN AS DOKUMEN, CONCAT(IFNULL(C.NAMA,'-'),'<BR>[',IFNULL(A.NM_ANGKUT,'-'),']') AS 'NAMA ANGKUT',
				A.NO_VOY_FLIGHT AS 'NO. VOYAGE/FLIGHT',
				DATE_FORMAT(A.TGL_TIBA,'%d-%m-%Y') AS 'TGL. TIBA', A.NO_BC11 AS 'NO. BC11',
				DATE_FORMAT(A.TGL_BC11,'%d-%m-%Y') AS 'TGL. BC11', D.NO_CONT AS 'NO. KONTAINER', D.KD_CONT_UKURAN AS UKURAN,
				A.WK_REKAM
				FROM t_repohdr A
				LEFT JOIN reff_gudang B ON A.KD_TPS = B.KD_TPS AND A.KD_GUDANG = B.KD_GUDANG
				LEFT JOIN reff_kapal C ON A.KD_KAPAL = C.ID
				INNER JOIN t_repocont D ON D.ID=A.ID
				WHERE 1=1" . $addsql;
		$this->newtable->multiple_search(true);
		$this->newtable->show_chk(false);
		$this->newtable->show_menu($check);
		$this->newtable->show_search(true);
		$proses = array('EXPORT EXCEL' => array('EXCEL', "report/process/excel/repository/" . $act, '0', '', 'md-file-text', '', '1'));
		$this->newtable->search(array(array('A.TGL_TIBA', 'TGL. TIBA', 'DATERANGE'), array('D.NO_CONT', 'NO. KONTAINER')));
		$this->newtable->action(site_url() . "/report/repository/" . $act);
		//if($check) $this->newtable->detail(array('POPUP',"dokumen/bc11/detail"));
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("ID", "WK_REKAM"));
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
		if ($this->input->post("ajax") || $act == "post")
			return $tabel;
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
			if ($act == "behandle") {

				$no_kon = $this->input->post('form[0]');
				$tgl_nota = $this->input->post('form[1]');
				$tgl_nota_start = $tgl_nota[0];
				$tgl_nota_end = $tgl_nota[1];
				$no_kon1 = $no_kon[0];
				$addsql = "";
				//print_r($this->input->post('form'));die();
				if ($tgl_nota_start != "" and $tgl_nota_end != "") {
					//$addsql .= " AND DATE(K.behandlein) BETWEEN '$tgl_nota_start' AND '$tgl_nota_end' GROUP BY B.NO_CONT limit 2000";
					$addsql .= " AND E.BEHANDLEIN BETWEEN '$tgl_nota_start' AND '$tgl_nota_end' GROUP BY B.NO_CONT limit 2000";
				} else if ($tgl_nota_start != "") {
					//$addsql .= " AND DATE(K.behandlein) >= '$tgl_nota_start' GROUP BY B.NO_CONT limit 2000";
					$addsql .= " AND E.BEHANDLEIN >= '$tgl_nota_start' GROUP BY B.NO_CONT limit 2000";
				} else if ($tgl_nota_end != "") {
					//$addsql .= " AND DATE(K.behandlein) <= '$tgl_nota_end' GROUP BY B.NO_CONT limit 2000";
					$addsql .= " AND E.BEHANDLEIN <= '$tgl_nota_end' GROUP BY B.NO_CONT limit 2000";
				} else {
					$addsql .= "GROUP BY B.NO_CONT limit 2000";
				}


				if ($no_kon1 != "") {
					//$addsql .= " AND D.NO_CONT = '$no_kon1'";
				}

				/*$SQL = "SELECT B.NO_CONT AS 'NO KONTAINER', A.CALL_SIGN AS 'KODE VESSEL', A.NM_ANGKUT AS 'VESSEL NAME', E.UKR_CONT AS 'SIZE', E.ISO_CODE, A.NO_VOY_FLIGHT AS 'NO VOY', B.WK_INOUT AS 'STACKING TIME', C.NO_DOK AS 'NO SPJM/SPPMP', C.TGL_DOK AS 'DATE SPJM/SPPMP', D.WK_IN AS 'BEHANDLE IN', D.LOKASI_INSP AS 'AREA BEHANDLE', D.WK_START AS 'START BEHANDLE',D.WK_FINISH AS 'STOP BEHANDLE',D.NO_SEAL AS 'NEW SEAL NUMBER', F.NO_DOK AS 'NO SPPB',F.TGL_DOK AS 'DATE SPPB', D.WK_GATEOUT AS 'BEHANDLE OUT', F.NAMA_CUST AS 'CUSTOMER NAME', '' AS HP,(SELECT I.NAMA FROM reff_kode_dok_bc I WHERE I.ID = C.JNS_DOK) AS 'REMARK', C.NO_SPK AS 'NO SPK'
							FROM t_cocostshdr A
							INNER JOIN t_cocostscont_new B ON A.ID = B.ID AND B.DOK_INOUT = '3'
							INNER JOIN t_spk C ON C.NM_KAPAL = A.NM_ANGKUT 
							INNER JOIN t_spk_cont E ON B.NO_CONT = E.NO_CONT AND C.ID = E.ID
							INNER JOIN t_operation D ON D.NO_CONT = B.NO_CONT AND D.NO_SPK = C.NO_SPK
							LEFT JOIN t_gatepass F ON F.NO_CONT = E.NO_CONT AND F.NM_KAPAL = C.NM_KAPAL AND F.NO_VOY = C.NO_VOY AND F.JNS_KEGIATAN = 3 WHERE 1=1
							".$addsql;*/ //echo $SQL; die();

				/* $SQL = "SELECT A.ID AS 'ID',B.NO_CONT AS 'KONTAINER',B.UKR_CONT AS 'UKURAN KONTAINER', CASE WHEN LEFT(B.LOKASI,3) = 'CIC' THEN B.LOKASI ELSE CONCAT(B.LOKASI,'0', TIER) END AS 'LOKASI', A.NO_SPK AS 'NO SPK',
							 A.TGL_SPK AS 'TANGGAL SPK',
							 C.KETERANGAN AS 'STATUS', J.CLASS, J.KODE_KAPAL AS 'KODE KAPAL', J.NM_KAPAL AS 'NAMA KAPAL',
							J.NO_VOY AS 'NO VOYAGE',J.ISO_CODE AS 'ISO CODE', J.KD_CONT_TIPE AS 'TYPE', J.TGL_TIBA AS 'TANGGAL TIBA', J.JNS_DOK AS 'JENIS DOKUMEN', 
							J.DOKUMEN AS 'NO DOKUMEN', J.TANGGAL AS 'TANGGAL DOKUMEN', J.STACKING, J.CONSIGNEE AS 'CUSTOMER', 
							K.pickup AS 'WAKTU PICKUP', K.tid AS 'TID', K.WK_TERMINAL_IN AS 'GATE IN', K.WK_TERMINAL_OUT AS 'GATE OUT', 
							K.behandlein AS 'WAKTU BEHANDLEIN', K.ROOM AS 'LOKASI', K.KONDISI, K.NO_SEAL AS 'NO SEAL',
							L.WK_SEND AS 'REQUEST GATE PASS', L.WK_FINISH AS 'APPROVED GATE PASS',L.WK_REQ AS 'TERBIT SPK', L.GATEPASSBEHANDLE1 AS 'GATE PASS BEAHANDLE 1', 
							L.JNS_DOK AS 'JENIS DOKUMEN 2', L.NO_DOK AS 'NO DOKUMEN 2', L.TGL_DOK AS 'TANGGAL DOKUMEN 2', L.WK_REK AS 'GATE PASS BEHANDLE 2',
							M.LOKASI AS 'LOKASI PEMERIKSAAN 1', M.START_INSP AS 'START PERIKSA', M.FINISH_INSP AS 'SELESAI PERIKSA', M.NO_SEAL AS 'NO SEAL B1',
							M.WK_STATUS AS 'WAKTU EX B1', M.LOKASI_AKHIR AS 'LOKASI B1',
							M.EX_LOKASI_AKHIR AS 'LOKASI BA1', M.TIER_AKHIR AS 'TIER BA1',
							Q.LOKASI_PB2 AS 'LOKASI PEMERIKSAAN B2', Q.WAKTU_MB2 AS 'MARSHALLING BEHANDLE 2', Q.START_PB2 AS 'MULAI PERIKSA B2',
							Q.FINISH_PB2 AS 'SELESAI PERIKSA B2', Q.NO_SEAL_PB2 AS 'NEW SEAL B2',
							Q.EX_LOKASI_AKHIR_PB2 AS 'LOKASI M EX B2', Q.TIER_EX_PB2 AS 'TIER M EX B2', Q.WAKTU_EX_MB2 AS 'MARSHALLING EX B2',
							P.JNS_DOK AS 'JENIS DOK DELIVERY', P.NO_DOK AS 'NO DOKUMEN DELIVERY', P.TGL_DOK AS 'TANGGAL DOKUMEN DELIVERY', 
							P.ID_REQ AS 'NO REQUEST DELIVERY', P.TGL_REQ AS 'TANGGAL REQUEST DELIVERY', P.EXPIRED AS 'THROUGH DEL',
							P.ID_REQ_EX_DEL AS 'ID REQUEST EX DEL', P.TANGGAL_REQ_EX_DEL AS 'TANGGAL REQ EX DEL', 
							P.EXPIRED_EX_DEL AS 'THROUGH EX DEL',
							O.NAMA AS 'JENIS DOK B1', O.NO_DOK AS 'NO DOK B1', O.TGL_DOK AS 'TANGGAL DOK B1', O.ID_REQ AS 'NO REQ B1', O.TGL_REQ AS 'TANGGAL REQ B1', 
							O.JNS_DOK AS 'JENIS DOK B2', O.NO_DOK_B2 AS 'NO DOK B2', O.TGL_DOK_B2 AS 'TANGGAL DOK B1', 
							O.ID_REQ_B2 AS 'NO REQ B2', O.TGL_REQ_B2 AS 'TANGGAL REQ B2',
							N.WK_TRUCKIN AS 'TRUCK IN CMS', N.WK_CHASSIS AS 'ON CHASSIS', N.WK_INSPECT AS 'INSPECTION OUT', N.WK_GATEOUT AS 'TRUCK OUT EIR', 
							N.NO_SEAL AS 'NO SEAL DELIVERY', N.KONDISI AS 'KONDISI KONTAINER'
							 FROM t_spk A, t_spk_cont B
							 INNER JOIN reff_status_spk C ON C.ID = B.STATUS_CONT 
							 LEFT JOIN ( -- Behandle 1
								SELECT A.NO_CONT, 'I' AS CLASS, G.CALL_SIGN AS 'KODE_KAPAL', C.NM_KAPAL,
								C.NO_VOY, D.UKR_CONT, H.ISO_CODE, H.KD_CONT_TIPE, G.TGL_TIBA, B.NAMA AS 'JNS_DOK', 
								C.NO_DOK AS 'DOKUMEN', C.TGL_DOK AS 'TANGGAL',H.WK_IN AS 'STACKING', C.CONSIGNEE
								FROM t_operation A
								LEFT JOIN t_spk C ON A.NO_SPK = C.NO_SPK
								LEFT JOIN reff_kode_dok_bc B ON C.JNS_DOK = B.ID
								LEFT JOIN t_spk_cont D ON A.NO_CONT = D.NO_CONT 
								LEFT JOIN t_op_inspection E ON A.NO_CONT = E.NO_CONT AND A.NO_DOK = E.NO_DOK
								LEFT JOIN t_op_behandlein F ON A.NO_CONT = F.NO_CONT
								INNER JOIN t_cocostscont H ON D.NO_CONT = H.NO_CONT -- AND H.ID = G.ID					
								LEFT JOIN t_cocostshdr G ON G.ID = H.ID
							 ) AS J ON J.NO_CONT = B.NO_CONT
							 LEFT JOIN ( -- Penarikan
								SELECT a.wk_pickup AS 'pickup', c.ID_FLAT AS 'tid', a.WK_TERMINAL_IN , a.WK_TERMINAL_OUT, 
								a.WK_IN AS 'behandlein', d.ROOM, e.KONDISI, d.NO_SEAL, d.ISO_CODE, 
								d.OPERATOR, f.OPERATOR AS 'oper', c.NO_CONT
								FROM t_operation a
								INNER JOIN t_spk b ON a.NO_SPK = b.NO_SPK
								LEFT JOIN t_spk_cont c ON b.ID = c.ID AND a.NO_CONT = c.NO_CONT
								INNER JOIN t_op_behandlein d ON a.NO_SPK = d.NO_SPK AND c.NO_CONT = d.NO_CONT
								LEFT JOIN t_op_pickup f ON a.NO_SPK = f.NO_SPK 
								LEFT JOIN reff_kondisi e ON d.KONDISI_CONT = e.ID
							 ) AS K ON K.NO_CONT = B.NO_CONT
							 LEFT JOIN ( -- Req Behandle 1 dan 2
								SELECT A.WK_SEND, A.WK_FINISH, C.NO_SPK,C.WK_REQ, D.WK_REK AS 'GATEPASSBEHANDLE1', 
								M.JNS_DOK, M.NO_DOK, M.TGL_DOK, M.WK_REK, B.NO_CONT
								FROM t_request A
								INNER JOIN t_request_cont B ON A.ID = B.ID
								INNER JOIN t_gatepass D ON D.NO_DOK = A.NO_DOK AND B.NO_CONT = D.NO_CONT
								INNER JOIN t_spk C ON A.NO_DOK = C.NO_DOK AND D.TGL_DOK = C.TGL_DOK 
								LEFT JOIN (SELECT JNS_DOK, NO_DOK, TGL_DOK, WK_REK, NO_CONT
								FROM t_gatepass WHERE JNS_KEGIATAN = '2') AS M ON M.NO_CONT = B.NO_CONT
							 ) AS L ON L.NO_CONT = B.NO_CONT
							 LEFT JOIN ( -- Pemeriksaan Behandle 1
								SELECT A.LOKASI, A.START_INSP , A.FINISH_INSP , A.NO_SEAL , B.LOKASI AS 'LOK', A.OPERATOR_START, A.OPERATOR_FINISH,
								M.NO_SPK, M.KD_STATUS, M.WK_STATUS, M.LOKASI_AKHIR, M.LOKASI_AWAL, M.TIER_AWAL,
								N.LOKASI_AKHIR 'EX_LOKASI_AKHIR', N.LOKASI_AWAL AS 'EX_AWAL', N.TIER_AWAL AS 'EX_TIER', N.TIER_AKHIR, A.NO_CONT
								FROM t_op_inspection A
								LEFT JOIN reff_kode_dok_bc D ON A.JNS_DOK = D.ID
								INNER JOIN t_gatepass C ON A.NO_CONT = C.NO_CONT AND A.NO_DOK = C.NO_DOK
								INNER JOIN t_spk_cont B ON A.NO_CONT = B.NO_CONT
								LEFT JOIN (SELECT A.ID_JOB_SLIP,A.NO_SPK,A.KD_STATUS,A.WK_STATUS,A.LOKASI_AKHIR,A.LOKASI_AWAL,A.TIER_AWAL,A.TIER_AKHIR, A.NO_CONT, A.JENIS
									FROM t_job_slip A
									WHERE A.KD_STATUS = 50 AND JENIS = 'BEHANDLE 1' AND LOKASI_AWAL IS NOT NULL) AS M ON M.NO_CONT = A.NO_CONT
								LEFT JOIN (SELECT A.ID_JOB_SLIP,A.NO_SPK,A.KD_STATUS,A.WK_STATUS,A.LOKASI_AKHIR,A.LOKASI_AWAL,A.TIER_AWAL,A.TIER_AKHIR,A.NO_CONT
									FROM t_job_slip A
									WHERE A.KD_STATUS = 50 AND A.LOKASI_AWAL LIKE '%CIC%' AND JENIS = 'EX BEHANDLE 1'
								) AS N ON N.NO_CONT = A.NO_CONT 
								WHERE C.JNS_KEGIATAN = '1'
							 ) AS M ON M.NO_CONT = B.NO_CONT
							 LEFT JOIN ( -- Pemeriksaan Behandle 2
								SELECT A.LOKASI AS 'LOKASI_PB2', M.WK_STATUS AS 'WAKTU_MB2', A.START_INSP AS 'START_PB2', A.FINISH_INSP AS 'FINISH_PB2', A.NO_SEAL AS 'NO_SEAL_PB2',
								N.LOKASI_AKHIR AS 'EX_LOKASI_AKHIR_PB2', N.TIER_AKHIR AS 'TIER_EX_PB2', N.WK_STATUS AS 'WAKTU_EX_MB2', A.NO_CONT
								FROM t_op_inspection A
								LEFT JOIN reff_kode_dok_bc D ON A.JNS_DOK = D.ID
								INNER JOIN t_gatepass C ON A.NO_CONT = C.NO_CONT AND A.NO_DOK = C.NO_DOK
								INNER JOIN t_spk_cont B ON A.NO_CONT = B.NO_CONT
									LEFT JOIN (
										SELECT A.ID_JOB_SLIP,A.NO_SPK,A.KD_STATUS,A.WK_STATUS,A.LOKASI_AKHIR,A.LOKASI_AWAL,A.TIER_AWAL,A.TIER_AKHIR, A.NO_CONT
										FROM t_job_slip A
										WHERE A.KD_STATUS = 50
										AND LEFT(A.LOKASI_AKHIR,'3') = 'CIC' 
										AND A.JENIS = 'BEHANDLE 2'
										AND A.LOKASI_AWAL IS NOT NULL
									) AS M ON M.NO_CONT = A.NO_CONT
									LEFT JOIN (
										SELECT A.ID_JOB_SLIP,A.NO_SPK,A.KD_STATUS,A.WK_STATUS,A.LOKASI_AKHIR,A.LOKASI_AWAL,A.TIER_AWAL,A.TIER_AKHIR, A.NO_CONT
										FROM t_job_slip A
										WHERE A.KD_STATUS = 50 AND JENIS = 'EX BEHANDLE 2'
									) AS N ON N.NO_CONT = A.NO_CONT
								WHERE C.JNS_KEGIATAN = '2'
							 ) AS Q ON Q.NO_CONT = B.NO_CONT
							 LEFT JOIN ( -- Delivery
								SELECT A.WK_TRUCKIN, A.WK_CHASSIS, A.WK_INSPECT, A.WK_GATEOUT, A.NO_SEAL, B.KONDISI, A.NO_CONT
								FROM t_op_delivery A
								LEFT JOIN reff_kondisi B ON A.KONDISI_CONT = B.ID 
							 ) AS N ON N.NO_CONT = B.NO_CONT
							 LEFT JOIN (-- Bil Behandle 1 dan Bil Behandle 2
								SELECT E.NAMA, A.NO_DOK, A.TGL_DOK, A.ID_REQ, A.TGL_REQ, D.JNS_DOK, D.NO_DOK AS 'NO_DOK_B2', D.TGL_DOK AS 'TGL_DOK_B2', 
								D.ID_REQ AS 'ID_REQ_B2', D.TGL_REQ AS 'TGL_REQ_B2', D.NAMA_CUST, D.NO_CONT
								FROM req_behandle_hdr A
								LEFT JOIN m_pelanggan B ON A.NPWP = B.NPWP
								LEFT JOIN req_behandle_dtl C ON A.ID_REQ = C.ID_REQ
								INNER JOIN reff_kode_dok_bc E ON A.JNS_DOK = E.ID
								LEFT JOIN (
									SELECT A.JNS_DOK, A.NO_DOK, A.TGL_DOK, A.ID_REQ, A.TGL_REQ, A.EXPIRED, B.NAMA_CUST, C.JNS_KEGIATAN, C.NO_CONT
									FROM req_behandle_hdr A
									LEFT JOIN m_pelanggan B ON A.NPWP = B.NPWP
									LEFT JOIN req_behandle_dtl C ON A.ID_REQ = C.ID_REQ 
									WHERE C.JNS_KEGIATAN = 2
								) AS D ON D.NO_CONT = C.NO_CONT 
								WHERE C.JNS_KEGIATAN = 1
							 ) AS O ON O.NO_CONT = B.NO_CONT
							 LEFT JOIN (-- Billing Delivery dan EX Delivery
								SELECT DISTINCT a.JNS_DOK, a.NO_DOK, a.TGL_DOK, a.ID_REQ, a.TGL_REQ, a.EXPIRED,
								H.ID_REQ AS 'ID_REQ_EX_DEL', H.TGL_REQ AS 'TANGGAL_REQ_EX_DEL', H.EXPIRED AS 'EXPIRED_EX_DEL', c.NO_CONT
								FROM req_delivery_hdr a
								INNER JOIN req_delivery_dtl c ON a.ID_REQ = c.ID_REQ
									LEFT JOIN (
										SELECT a.ID_REQ, a.TGL_REQ, a.EXPIRED, b.NAMA_CUST, c.NO_CONT
										FROM req_delivery_hdr a
										INNER JOIN m_pelanggan b ON a.NPWP = b.NPWP
										INNER JOIN req_delivery_dtl c ON a.ID_REQ = c.ID_REQ
										INNER JOIN t_spk d ON a.NM_KAPAL = d.NM_KAPAL AND a.NO_VOY = d.NO_VOY
										WHERE LEFT(a.ID_REQ,3) = 'EXT'
									) AS H ON H.NO_CONT = c.NO_CONT
								WHERE LEFT(a.ID_REQ,3) = 'DEL'
							 ) AS P ON P.NO_CONT = B.NO_CONT
							 WHERE A.ID = B.ID ".$addsql; */

				$SQL = "SELECT A.ID AS 'ID', B.NO_CONT AS 'KONTAINER', B.UKR_CONT AS 'UKURAN KONTAINER',CASE WHEN LEFT(B.LOKASI,3) = 'CIC' THEN B.LOKASI ELSE CONCAT(B.LOKASI,'0', TIER) END AS 'LOKASI',
							A.NO_SPK AS 'NO SPK', A.TGL_SPK AS 'TANGGAL SPK',
							C.KETERANGAN AS 'STATUS', D.CLASS, D.CALL_SIGN AS 'KODE KAPAL', D.NM_ANGKUT AS 'NAMA KAPAL',
							D.NO_VOY_FLIGHT AS 'NO VOYAGE',D.ISO_CODE AS 'ISO CODE', D.KD_CONT_TIPE AS 'TYPE', D.TGL_TIBA AS 'TANGGAL TIBA', D.NAMA AS 'JENIS DOKUMEN',
							D.DOKUMEN AS 'NO DOKUMEN', D.TANGGAL AS 'TANGGAL DOKUMEN', D.STACKING, D.CONSIGNEE AS 'CUSTOMER',
							E.PICKUP AS 'WAKTU PICKUP', E.TID AS 'TID', E.WK_TERMINAL_IN AS 'GATE IN', E.WK_TERMINAL_OUT AS 'GATE OUT', 
							E.BEHANDLEIN AS 'WAKTU BEHANDLEIN', E.ROOM AS 'LOKASI', E.KONDISI, E.NO_SEAL AS 'NO SEAL',
							F.WK_SEND AS 'REQUEST GATE PASS', F.WK_FINISH AS 'APPROVED GATE PASS', F.WK_REQ AS 'TERBIT SPK', F.GATEPASSBEHANDLE1 AS 'GATE PASS BEAHANDLE 1', 
							F.JNS_DOK AS 'JENIS DOKUMEN 2', F.NO_DOK AS 'NO DOKUMEN 2', F.TGL_DOK AS 'TANGGAL DOKUMEN 2', F.WK_REK AS 'GATE PASS BEHANDLE 2',
							G.LOKASI AS 'LOKASI PEMERIKSAAN 1', G.START_INSP AS 'START PERIKSA', G.FINISH_INSP AS 'SELESAI PERIKSA', G.NO_SEAL AS 'NO SEAL B1',
							G.WK_STATUS AS 'WAKTU EX B1', G.LOKASI_AKHIR AS 'LOKASI B1', G.EX_LOKASI_AKHIR AS 'LOKASI BA1', G.TIER_AKHIR AS 'TIER BA1',
							H.LOKASI_PB2 AS 'LOKASI PEMERIKSAAN B2', H.WAKTU_MB2 AS 'MARSHALLING BEHANDLE 2', H.START_PB2 AS 'MULAI PERIKSA B2',
							H.FINISH_PB2 AS 'SELESAI PERIKSA B2', H.NO_SEAL_PB2 AS 'NEW SEAL B2',
							H.EX_LOKASI_AKHIR_PB2 AS 'LOKASI M EX B2', H.TIER_EX_PB2 AS 'TIER M EX B2', H.WAKTU_EX_MB2 AS 'MARSHALLING EX B2',
							I.NAMA AS 'JENIS DOK B1', I.NO_DOK AS 'NO DOK B1', I.TGL_DOK AS 'TANGGAL DOK B1', I.ID_REQ AS 'NO REQ B1', I.TGL_REQ AS 'TANGGAL REQ B1', 
							I.JNS_DOK AS 'JENIS DOK B2', I.NO_DOK_B2 AS 'NO DOK B2', I.TGL_DOK_B2 AS 'TANGGAL DOK B1', 
							I.ID_REQ_B2 AS 'NO REQ B2', I.TGL_REQ_B2 AS 'TANGGAL REQ B2',
							J.JNS_DOK AS 'JENIS DOK DELIVERY', J.NO_DOK AS 'NO DOKUMEN DELIVERY', J.TGL_DOK AS 'TANGGAL DOKUMEN DELIVERY', 
							J.ID_REQ AS 'NO REQUEST DELIVERY', J.TGL_REQ AS 'TANGGAL REQUEST DELIVERY', J.EXPIRED AS 'THROUGH DEL',
							J.ID_REQ_EX_DEL AS 'ID REQUEST EX DEL', J.TANGGAL_REQ_EX_DEL AS 'TANGGAL REQ EX DEL', 
							J.EXPIRED_EX_DEL AS 'THROUGH EX DEL',
							K.WK_TRUCKIN AS 'TRUCK IN CMS', K.WK_CHASSIS AS 'ON CHASSIS', K.WK_INSPECT AS 'INSPECTION OUT', K.WK_GATEOUT AS 'TRUCK OUT EIR', 
							K.NO_SEAL AS 'NO SEAL DELIVERY', K.KONDISI AS 'KONDISI KONTAINER'
								
						FROM t_spk A
						INNER JOIN t_spk_cont B ON A.ID = B.ID
						INNER JOIN reff_status_spk C ON C.ID = B.STATUS_CONT
						LEFT JOIN (
							-- Behandle 1
							SELECT A.NO_CONT, 'I' AS CLASS, H.CALL_SIGN, H.NM_ANGKUT,
								H.NO_VOY_FLIGHT, C.UKR_CONT, G.ISO_CODE, G.KD_CONT_TIPE, H.TGL_TIBA,
								D.NAMA,B.NO_DOK AS 'DOKUMEN', B.TGL_DOK AS 'TANGGAL', G.WK_IN AS 'STACKING', B.CONSIGNEE
							FROM t_operation A
							INNER JOIN t_spk B ON A.NO_SPK = B.NO_SPK
							INNER JOIN t_spk_cont C ON A.NO_CONT = C.NO_CONT
							INNER JOIN reff_kode_dok_bc D ON B.JNS_DOK = D.ID
							INNER JOIN t_op_inspection E ON A.NO_CONT = E.NO_CONT AND A.NO_DOK = E.NO_DOK
							INNER JOIN t_op_behandlein F ON A.NO_CONT = F.NO_CONT
							INNER JOIN t_cocostscont G ON C.NO_CONT = G.NO_CONT
							INNER JOIN t_cocostshdr H ON G.ID = H.ID
						) AS D ON B.NO_CONT = D.NO_CONT
						LEFT JOIN (
							SELECT A.WK_PICKUP AS 'PICKUP', C.ID_FLAT AS 'TID', A.WK_TERMINAL_IN, A.WK_TERMINAL_OUT,
								A.WK_IN AS 'BEHANDLEIN', D.ROOM, E.KONDISI, D.NO_SEAL, D.ISO_CODE, D.OPERATOR, F.OPERATOR AS 'OPER', C.NO_CONT
							FROM t_operation A
							INNER JOIN t_spk B ON A.NO_SPK = B.NO_SPK
							INNER JOIN t_spk_cont C ON B.ID = C.ID AND A.NO_CONT = C.NO_CONT
							INNER JOIN t_op_behandlein D ON A.NO_SPK = D.NO_SPK AND C.NO_CONT = D.NO_CONT
							INNER JOIN reff_kondisi E ON D.KONDISI_CONT = E.ID
							INNER JOIN t_op_pickup F ON A.NO_SPK = F.NO_SPK
						) AS E ON B.NO_CONT = E.NO_CONT
						LEFT JOIN (
							-- Req Behandle 1 dan 2
							SELECT A.WK_SEND, A.WK_FINISH, C.NO_SPK,C.WK_REQ, D.WK_REK AS 'GATEPASSBEHANDLE1',
								E.JNS_DOK, E.NO_DOK, E.TGL_DOK, E.WK_REK, B.NO_CONT 
							FROM t_request A
							INNER JOIN t_request_cont B ON A.ID = B.ID
							INNER JOIN t_spk C ON A.NO_DOK = C.NO_DOK
							INNER JOIN t_gatepass D ON A.NO_DOK = D.NO_DOK AND B.NO_CONT = D.NO_CONT
							LEFT JOIN(
								SELECT JNS_DOK, NO_DOK, TGL_DOK, WK_REK, NO_CONT FROM t_gatepass WHERE JNS_KEGIATAN = '2'
							) AS E ON B.NO_CONT = E.NO_CONT
						) AS F ON B.NO_CONT = F.NO_CONT
						LEFT JOIN (
							-- Pemeriksaan Behandle 1
							SELECT A.LOKASI, A.START_INSP , A.FINISH_INSP , A.NO_SEAL , B.LOKASI AS 'LOK', A.OPERATOR_START, A.OPERATOR_FINISH,
								E.NO_SPK, E.KD_STATUS, E.WK_STATUS, E.LOKASI_AKHIR, E.LOKASI_AWAL, E.TIER_AWAL,
								F.LOKASI_AKHIR 'EX_LOKASI_AKHIR', F.LOKASI_AWAL AS 'EX_AWAL', F.TIER_AWAL AS 'EX_TIER', F.TIER_AKHIR, A.NO_CONT
							FROM t_op_inspection A
							INNER JOIN t_spk_cont B ON A.NO_CONT = B.NO_CONT
							INNER JOIN t_gatepass C ON A.NO_CONT = C.NO_CONT AND A.NO_DOK = C.NO_DOK
							LEFT JOIN reff_kode_dok_bc D ON A.JNS_DOK = D.ID
							LEFT JOIN (
								SELECT A.ID_JOB_SLIP,A.NO_SPK,A.KD_STATUS,A.WK_STATUS,A.LOKASI_AKHIR,A.LOKASI_AWAL,
									A.TIER_AWAL,A.TIER_AKHIR, A.NO_CONT, A.JENIS
								FROM t_job_slip A
								WHERE A.KD_STATUS = 50 AND JENIS = 'BEHANDLE 1' AND LOKASI_AWAL IS NOT NULL) AS E ON A.NO_CONT = E.NO_CONT
							LEFT JOIN (
								SELECT A.ID_JOB_SLIP,A.NO_SPK,A.KD_STATUS,A.WK_STATUS,A.LOKASI_AKHIR,A.LOKASI_AWAL,
									A.TIER_AWAL,A.TIER_AKHIR,A.NO_CONT
								FROM t_job_slip A
								WHERE A.KD_STATUS = 50 AND A.LOKASI_AWAL LIKE '%CIC%' AND JENIS = 'EX BEHANDLE 1') AS F ON A.NO_CONT = F.NO_CONT
							WHERE C.JNS_KEGIATAN = '1'
						) AS G ON B.NO_CONT = G.NO_CONT
						LEFT JOIN (
							-- Pemeriksaan Behandle 2
							SELECT A.LOKASI AS 'LOKASI_PB2', E.WK_STATUS AS 'WAKTU_MB2', A.START_INSP AS 'START_PB2', A.FINISH_INSP AS 'FINISH_PB2', A.NO_SEAL AS 'NO_SEAL_PB2',
								F.LOKASI_AKHIR AS 'EX_LOKASI_AKHIR_PB2', F.TIER_AKHIR AS 'TIER_EX_PB2', F.WK_STATUS AS 'WAKTU_EX_MB2', A.NO_CONT
							FROM t_op_inspection A
							INNER JOIN t_spk_cont B ON A.NO_CONT = B.NO_CONT
							INNER JOIN t_gatepass C ON A.NO_CONT = C.NO_CONT AND A.NO_DOK = C.NO_DOK
							LEFT JOIN reff_kode_dok_bc D ON A.JNS_DOK = D.ID
							LEFT JOIN (
								SELECT A.ID_JOB_SLIP,A.NO_SPK,A.KD_STATUS,A.WK_STATUS,A.LOKASI_AKHIR,A.LOKASI_AWAL,
									A.TIER_AWAL,A.TIER_AKHIR, A.NO_CONT
								FROM t_job_slip A
								WHERE A.KD_STATUS = 50 AND LEFT(A.LOKASI_AKHIR,'3') = 'CIC' AND A.JENIS = 'BEHANDLE 2' AND A.LOKASI_AWAL IS NOT NULL
							) AS E ON A.NO_CONT = E.NO_CONT
							LEFT JOIN (
								SELECT A.ID_JOB_SLIP,A.NO_SPK,A.KD_STATUS,A.WK_STATUS,A.LOKASI_AKHIR,A.LOKASI_AWAL,
									A.TIER_AWAL,A.TIER_AKHIR, A.NO_CONT
								FROM t_job_slip A
								WHERE A.KD_STATUS = 50 AND JENIS = 'EX BEHANDLE 2'
							) AS F ON A.NO_CONT = F.NO_CONT
							WHERE C.JNS_KEGIATAN = '2'
						) AS H ON B.NO_CONT = H.NO_CONT
						LEFT JOIN (
							-- Bil Behandle 1 dan Bil Behandle 2
							SELECT D.NAMA, A.NO_DOK, A.TGL_DOK, A.ID_REQ, A.TGL_REQ, E.JNS_DOK, E.NO_DOK AS 'NO_DOK_B2', E.TGL_DOK AS 'TGL_DOK_B2', 
								E.ID_REQ AS 'ID_REQ_B2', E.TGL_REQ AS 'TGL_REQ_B2', E.NAMA_CUST, C.NO_CONT
							FROM req_behandle_hdr A
							INNER JOIN m_pelanggan B ON A.NPWP = B.NPWP
							INNER JOIN req_behandle_dtl C ON A.ID_REQ = C.ID_REQ
							INNER JOIN reff_kode_dok_bc D ON A.JNS_DOK = D.ID
							LEFT JOIN (
								SELECT A.JNS_DOK, A.NO_DOK, A.TGL_DOK, A.ID_REQ, A.TGL_REQ, A.EXPIRED, B.NAMA_CUST, C.JNS_KEGIATAN, C.NO_CONT
								FROM req_behandle_hdr A
								INNER JOIN m_pelanggan B ON A.NPWP = B.NPWP
								INNER JOIN req_behandle_dtl C ON A.ID_REQ = C.ID_REQ 
								WHERE C.JNS_KEGIATAN = 2
							) AS E ON C.NO_CONT = E.NO_CONT
							WHERE C.JNS_KEGIATAN = 1
						) AS I ON B.NO_CONT = I.NO_CONT
						LEFT JOIN(
							-- Bil Delivery dan Ex Delivery
							SELECT DISTINCT A.JNS_DOK, A.NO_DOK, A.TGL_DOK, A.ID_REQ, A.TGL_REQ, A.EXPIRED,
								C.ID_REQ AS 'ID_REQ_EX_DEL', C.TGL_REQ AS 'TANGGAL_REQ_EX_DEL', C.EXPIRED AS 'EXPIRED_EX_DEL', B.NO_CONT
							FROM req_delivery_hdr A
							INNER JOIN req_delivery_dtl B ON A.ID_REQ = B.ID_REQ
							LEFT JOIN (
								SELECT A.ID_REQ, A.TGL_REQ, A.EXPIRED, B.NAMA_CUST, C.NO_CONT
								FROM req_delivery_hdr A
								INNER JOIN m_pelanggan B ON A.NPWP = B.NPWP
								INNER JOIN req_delivery_dtl C ON A.ID_REQ = C.ID_REQ
								INNER JOIN t_spk D ON A.NM_KAPAL = D.NM_KAPAL AND A.NO_VOY = D.NO_VOY
								WHERE LEFT(A.ID_REQ,3) = 'EXT'
							) AS C ON C.NO_CONT =  B.NO_CONT
							WHERE LEFT(A.ID_REQ,3) = 'DEL'
						) AS J ON B.NO_CONT = J.NO_CONT
						LEFT JOIN (
							-- Delivery
							SELECT A.WK_TRUCKIN, A.WK_CHASSIS, A.WK_INSPECT, A.WK_GATEOUT, A.NO_SEAL, B.KONDISI, A.NO_CONT
							FROM t_op_delivery A
							LEFT JOIN reff_kondisi B ON A.KONDISI_CONT = B.ID
						) AS K ON B.NO_CONT = K.NO_CONT
						WHERE A.ID " . $addsql;

				$result = $func->main->get_result($SQL);
				$this->load->library('newphpexcel');
				$this->newphpexcel->getDefaultStyle()->getFont()->setName('Calibri')->setSize(10);
				$objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
				$objDrawing->setName('Logo');
				$objDrawing->setDescription('Logo');
				$logo = imagecreatefrompng('assets/images/Logomti.png');
				$objDrawing->setImageResource($logo);
				$objDrawing->setCoordinates('A1');
				$objDrawing->setHeight(100);
				$objDrawing->setWidth(100);
				$objDrawing->setWorksheet($this->newphpexcel->getActiveSheet());
				$this->newphpexcel->setActiveSheetIndex(0);
				$styleArray = array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
				$this->newphpexcel->getDefaultStyle()->applyFromArray($styleArray);
				$this->newphpexcel->set_bold(array('A1'));
				$this->newphpexcel->mergecell(array(array('A1', 'W1'), array('A2', 'W2'), array('A3', 'W3'), array('B5', 'P5'), array('Q5', 'U5'), array('V5', 'AD5'), array('AE5', 'AK5'), array('AL5', 'AO5'), array('AP5', 'AV5'), array('AW5', 'BB5'), array('BC5', 'BH5'), array('BI5', 'BO5'), array('BP5', 'BR5'), array('BS5', 'BX5')), FALSE); //
				$this->newphpexcel->getActiveSheet()->getStyle('A5:BX5')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFD700');
				$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A1', 'DAILY REPORT BEHANDLE');
				$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A2', 'COMMON GATE PT. MTI');
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

				$this->newphpexcel->width(array(array('A', 5), array('B', 18), array('C', 8), array('D', 8), array('E', 20), array('F', 12), array('G', 15), array('H', 18), array('I', 12), array('J', 10), array('K', 15), array('L', 22), array('M', 20), array('N', 30), array('O', 20), array('P', 25), array('Q', 20), array('R', 25), array('S', 15), array('T', 20), array('U', 25), array('V', 20), array('W', 15), array('X', 15), array('Y', 15), array('Z', 25), array('AA', 30), array('AB', 10), array('AC', 12), array('AD', 20), array('AE', 25), array('AF', 15), array('AG', 25), array('AH', 25), array('AI', 20), array('AJ', 25), array('AK', 20), array('AL', 20), array('AM', 23), array('AN', 22), array('AO', 25), array('AP', 25), array('AQ', 18), array('AR', 20), array('AS', 23), array('AT', 22), array('AU', 28), array('AV', 18), array('AW', 22), array('AX', 18), array('AY', 23), array('AZ', 22), array('BA', 23), array('BB', 40), array('BC', 23), array('BD', 23), array('BE', 25), array('BF', 25), array('BG', 22), array('BH', 40), array('BI', 22), array('BJ', 26), array('BK', 20), array('BL', 25), array('BM', 25), array('BN', 20), array('BO', 40), array('BP', 25), array('BQ', 25), array('BR', 25), array('BS', 25), array('BT', 20), array('BU', 20), array('BV', 40), array('BW', 25), array('BX', 25)));

				$this->newphpexcel->setActiveSheetIndex(0)
					->setCellValue('A6', 'NO')
					->setCellValue('B6', 'NO CONTAINER')
					->setCellValue('C6', 'SIZE')
					->setCellValue('D6', 'CLASS')
					->setCellValue('E6', 'NAMA KAPAL')
					->setCellValue('F6', 'KODE KAPAL')
					->setCellValue('G6', 'NO VOYAGE')
					->setCellValue('H6', 'STATUS')
					->setCellValue('I6', 'ISO CODE')
					->setCellValue('J6', 'TYPE')
					->setCellValue('K6', 'ARRIVAL')
					->setCellValue('L6', 'STACKING')
					->setCellValue('M6', 'JENIS DOKUMEN')
					->setCellValue('N6', 'NO DOKUMEN')
					->setCellValue('O6', 'TANGGAL DOKUMEN')
					->setCellValue('P6', 'NAMA CUSTOMER')
					->setCellValue('Q6', 'REQUEST GATE PASS')
					->setCellValue('R6', 'APPROVED GATE PASS')
					->setCellValue('S6', 'NO SPK')
					->setCellValue('T6', 'TERBIT SPK')
					->setCellValue('U6', 'GATE PASS BEHANDLE 1')
					->setCellValue('V6', 'PICK UP')
					->setCellValue('W6', 'TID')
					->setCellValue('X6', 'GATE IN TERMINAL')
					->setCellValue('Y6', 'GATE OUT TERMINAL')
					->setCellValue('Z6', 'BEHANDLE IN')
					->setCellValue('AA6', 'KONDISI KONTAINER')
					->setCellValue('AB6', 'NO SEAL')
					->setCellValue('AC6', 'ISO CODE')
					->setCellValue('AD6', 'LOKASI')
					->setCellValue('AE6', 'MARSHALLING BEHANDLE 1')
					->setCellValue('AF6', 'LOKASI')
					->setCellValue('AG6', 'MULAI PERIKSA')
					->setCellValue('AH6', 'SELESAI PERIKSA')
					->setCellValue('AI6', 'NEW SEAL NUMBER')
					->setCellValue('AJ6', 'MARSHALLING')
					->setCellValue('AK6', 'LOKASI')
					->setCellValue('AL6', 'JENIS DOKUMEN')
					->setCellValue('AM6', 'NO DOKUMEN')
					->setCellValue('AN6', 'TANGGAL DOKUMEN')
					->setCellValue('AO6', 'GATE PASS BEAHANDLE 2')
					->setCellValue('AP6', 'MARSHALLING BEHANDLE 2')
					->setCellValue('AQ6', 'LOKASI')
					->setCellValue('AR6', 'MULAI PERIKSA')
					->setCellValue('AS6', 'SELESAI PERIKSA')
					->setCellValue('AT6', 'NEW SEAL NUMBER')
					->setCellValue('AU6', 'MARSHALLING EX BEHANDLE 2')
					->setCellValue('AV6', 'LOKASI')
					->setCellValue('AW6', 'JENIS DOKUMEN')
					->setCellValue('AX6', 'NO DOKUMEN')
					->setCellValue('AY6', 'TANGGAL DOKUMEN')
					->setCellValue('AZ6', 'NO REQUEST')
					->setCellValue('BA6', 'TANGGAL REQUEST')
					->setCellValue('BB6', 'CUSTOMER NAME')
					->setCellValue('BC6', 'JENIS DOKUMEN')
					->setCellValue('BD6', 'NO DOKUMEN')
					->setCellValue('BE6', 'TANGGAL DOKUMEN')
					->setCellValue('BF6', 'NO REQUEST')
					->setCellValue('BG6', 'TANGGAL REQUEST')
					->setCellValue('BH6', 'CUSTOMER NAME')
					->setCellValue('BI6', 'JENIS DOKUMEN')
					->setCellValue('BJ6', 'NO DOKUMEN')
					->setCellValue('BK6', 'TANGGAL DOKUMEN')
					->setCellValue('BL6', 'NO REQUEST')
					->setCellValue('BM6', 'TANGGAL REQUEST')
					->setCellValue('BN6', 'PAID THROUGH')
					->setCellValue('BO6', 'CUSTOMER NAME')
					->setCellValue('BP6', 'NO REQUEST')
					->setCellValue('BQ6', 'TANGGAL REQUEST')
					->setCellValue('BR6', 'PAID THROUGH')
					->setCellValue('BS6', 'TRUCK IN + CETAK CMS')
					->setCellValue('BT6', 'ON CHASSIS')
					->setCellValue('BU6', 'NO SEAL')
					->setCellValue('BV6', 'KONDISI KONTAINER')
					->setCellValue('BW6', 'INSPECTION OUT')
					->setCellValue('BX6', 'TRUCK OUT + CETAK EIR');
				$this->newphpexcel->headings(array('A6', 'B6', 'C6', 'D6', 'E6', 'F6', 'G6', 'H6', 'I6', 'J6', 'K6', 'L6', 'M6', 'N6', 'O6', 'P6', 'Q6', 'R6', 'S6', 'T6', 'U6', 'V6', 'W6', 'X6', 'Y6', 'Z6', 'AA6', 'AB6', 'AC6', 'AD6', 'AE6', 'AF6', 'AG6', 'AH6', 'AI6', 'AJ6', 'AK6', 'AL6', 'AM6', 'AN6', 'AO6', 'AP6', 'AQ6', 'AR6', 'AS6', 'AT6', 'AU6', 'AV6', 'AW6', 'AX6', 'AY6', 'AZ6', 'BA6', 'BB6', 'BC6', 'BD6', 'BE6', 'BF6', 'BG6', 'BH6', 'BI6', 'BJ6', 'BK6', 'BL6', 'BM6', 'BN6', 'BO6', 'BP6', 'BQ6', 'BR6', 'BS6', 'BT6', 'BU6', 'BV6', 'BW6', 'BX6'));
				$this->newphpexcel->set_wrap(array('B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH', 'AI', 'AJ', 'AK', 'AL', 'AM', 'AN', 'AO', 'AP', 'AQ', 'AR', 'AS', 'AT', 'AU', 'AV', 'AW', 'AX', 'AY', 'AZ', 'BA', 'BB', 'BC', 'BD', 'BE', 'BF', 'BG', 'BH', 'BI', 'BJ', 'BK', 'BL', 'BM', 'BN', 'BO', 'BP', 'BQ', 'BR', 'BS', 'BT', 'BU', 'BV', 'BW', 'BX'));
				$no = 1;
				$rec = 7;
				if ($result) {
					foreach ($SQL->result_array() as $row) {
						$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A' . $rec, $no)
							->setCellValueExplicit('B' . $rec, $row["KONTAINER"], PHPExcel_Cell_DataType::TYPE_STRING)
							->setCellValueExplicit('C' . $rec, $row["UKURAN KONTAINER"], PHPExcel_Cell_DataType::TYPE_STRING)
							->setCellValueExplicit('D' . $rec, $row["CLASS"])
							->setCellValueExplicit('E' . $rec, $row["NAMA KAPAL"], PHPExcel_Cell_DataType::TYPE_STRING)
							->setCellValueExplicit('F' . $rec, $row["KODE KAPAL"], PHPExcel_Cell_DataType::TYPE_STRING)
							->setCellValue('G' . $rec, $row["NO VOYAGE"])
							->setCellValueExplicit('H' . $rec, $row["STATUS"], PHPExcel_Cell_DataType::TYPE_STRING)
							->setCellValue('I' . $rec, $row["ISO CODE"])
							->setCellValue('J' . $rec, $row["TYPE"])
							->setCellValue('K' . $rec, $row["TANGGAL TIBA"])
							->setCellValue('L' . $rec, $row["STACKING"])
							->setCellValue('M' . $rec, $row["JENIS DOKUMEN"])
							->setCellValue('N' . $rec, $row["NO DOKUMEN"])
							->setCellValue('O' . $rec, $row["TANGGAL DOKUMEN"])
							->setCellValue('P' . $rec, $row["CUSTOMER"])
							->setCellValue('Q' . $rec, $row["REQUEST GATE PASS"])
							->setCellValue('R' . $rec, $row["APPROVED GATE PASS"])
							->setCellValue('S' . $rec, $row["NO SPK"])
							->setCellValue('T' . $rec, $row["TERBIT SPK"])
							->setCellValue('U' . $rec, $row["GATE PASS BEAHANDLE 1"])
							->setCellValue('V' . $rec, $row["WAKTU PICKUP"])
							->setCellValue('W' . $rec, $row["TID"])
							->setCellValue('X' . $rec, $row["GATE IN"])
							->setCellValue('Y' . $rec, $row["GATE OUT"])
							->setCellValue('Z' . $rec, $row["WAKTU BEHANDLEIN"])
							->setCellValue('AA' . $rec, $row["KONDISI"])
							->setCellValue('AB' . $rec, $row["NO SEAL"])
							->setCellValue('AC' . $rec, $row["ISO CODE"])
							->setCellValue('AD' . $rec, $row["LOKASI"])
							->setCellValue('AE' . $rec, $row["WAKTU EX B1"])
							->setCellValue('AF' . $rec, $row["LOKASI B1"])
							->setCellValue('AG' . $rec, $row["START PERIKSA"])
							->setCellValue('AH' . $rec, $row["SELESAI PERIKSA"])
							->setCellValue('AI' . $rec, $row["NO SEAL B1"])
							->setCellValue('AJ' . $rec, $row["WAKTU EX B1"])
							->setCellValue('AK' . $rec, $row["LOKASI BA1"] . '0' . $row['TIER BA1'])
							->setCellValue('AL' . $rec, $row["JENIS DOKUMEN 2"])
							->setCellValue('AM' . $rec, $row["NO DOKUMEN 2"])
							->setCellValue('AN' . $rec, $row["TANGGAL DOKUMEN 2"])
							->setCellValue('AO' . $rec, $row["GATE PASS BEHANDLE 2"])
							->setCellValue('AP' . $rec, $row["MARSHALLING BEHANDLE 2"])
							->setCellValue('AQ' . $rec, $row["LOKASI PEMERIKSAAN B2"])
							->setCellValue('AR' . $rec, $row["MULAI PERIKSA B2"])
							->setCellValue('AS' . $rec, $row["SELESAI PERIKSA B2"])
							->setCellValue('AT' . $rec, $row["NEW SEAL B2"])
							->setCellValue('AU' . $rec, $row["MARSHALLING EX B2"])
							->setCellValue('AV' . $rec, $row["LOKASI M EX B2"] . '0' . $row["TIER M EX B2"])
							->setCellValue('AW' . $rec, $row["JENIS DOK B1"])
							->setCellValue('AX' . $rec, $row["NO DOK B1"])
							->setCellValue('AY' . $rec, $row["TANGGAL DOK B1"])
							->setCellValue('AZ' . $rec, $row["NO REQ B1"])
							->setCellValue('BA' . $rec, $row["TANGGAL REQ B1"])
							->setCellValue('BB' . $rec, $row["CUSTOMER"])
							->setCellValue('BC' . $rec, $row["JENIS DOK B2"])
							->setCellValue('BD' . $rec, $row["NO DOK B2"])
							->setCellValue('BE' . $rec, $row["TANGGAL DOK B1"])
							->setCellValue('BF' . $rec, $row["NO REQ B2"])
							->setCellValue('BG' . $rec, $row["TANGGAL REQ B2"])
							->setCellValue('BH' . $rec, $row["CUSTOMER"])
							->setCellValue('BI' . $rec, $row["JENIS DOK DELIVERY"])
							->setCellValue('BJ' . $rec, $row["NO DOKUMEN DELIVERY"])
							->setCellValue('BK' . $rec, $row["TANGGAL DOKUMEN DELIVERY"])
							->setCellValue('BL' . $rec, $row["NO REQUEST DELIVERY"])
							->setCellValue('BM' . $rec, $row["TANGGAL REQUEST DELIVERY"])
							->setCellValue('BN' . $rec, $row["THROUGH DEL"])
							->setCellValue('BO' . $rec, $row["CUSTOMER"])
							->setCellValue('BP' . $rec, $row["ID REQUEST EX DEL"])
							->setCellValue('BQ' . $rec, $row["TANGGAL REQ EX DEL"])
							->setCellValue('BR' . $rec, $row["THROUGH EX DEL"])
							->setCellValue('BS' . $rec, $row["TRUCK IN CMS"])
							->setCellValue('BT' . $rec, $row["ON CHASSIS"])
							->setCellValue('BU' . $rec, $row["NO SEAL DELIVERY"])
							->setCellValue('BV' . $rec, $row["KONDISI KONTAINER"])
							->setCellValue('BW' . $rec, $row["INSPECTION OUT"])
							->setCellValue('BX' . $rec, $row["TRUCK OUT EIR"]);

						$this->newphpexcel->set_detilstyle(array('A' . $rec, 'B' . $rec, 'C' . $rec, 'D' . $rec, 'E' . $rec, 'F' . $rec, 'G' . $rec, 'H' . $rec, 'I' . $rec, 'J' . $rec, 'K' . $rec, 'L' . $rec, 'M' . $rec, 'N' . $rec, 'O' . $rec, 'P' . $rec, 'Q' . $rec, 'R' . $rec, 'S' . $rec, 'T' . $rec, 'U' . $rec, 'V' . $rec, 'W' . $rec, 'X' . $rec, 'Y' . $rec, 'Z' . $rec, 'AA' . $rec, 'AB' . $rec, 'AC' . $rec, 'AD' . $rec, 'AE' . $rec, 'AF' . $rec, 'AG' . $rec, 'AH' . $rec, 'AI' . $rec, 'AJ' . $rec, 'AK' . $rec, 'AL' . $rec, 'AM' . $rec, 'AN' . $rec, 'AO' . $rec, 'AP' . $rec, 'AQ' . $rec, 'AR' . $rec, 'AS' . $rec, 'AT' . $rec, 'AU' . $rec, 'AV' . $rec, 'AW' . $rec, 'AX' . $rec, 'AY' . $rec, 'AZ' . $rec, 'BA' . $rec, 'BB' . $rec, 'BC' . $rec, 'BD' . $rec, 'BE' . $rec, 'BF' . $rec, 'BG' . $rec, 'BH' . $rec, 'BI' . $rec, 'BJ' . $rec, 'BK' . $rec, 'BL' . $rec, 'BM' . $rec, 'BN' . $rec, 'BO' . $rec, 'BP' . $rec, 'BQ' . $rec, 'BR' . $rec, 'BS' . $rec, 'BT' . $rec, 'BU' . $rec, 'BV' . $rec, 'BW' . $rec, 'BX' . $rec));
						$rec++;
						$no++;
					}
				} else {
					$this->newphpexcel->getActiveSheet()->mergeCells('A6:X6');
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A6', 'DATA TIDAK DITEMUKAN');
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
			} else if ($act == "bilbehandle") { //print_r($_POST);die();
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

				if ($tgl_nota_start != "" and $tgl_nota_end != "") {
					$addsql .= " AND DATE(A.TGL_NOTA) BETWEEN '$tgl_nota_start' AND '$tgl_nota_end'";
				} else if ($tgl_nota_start != "") {
					$addsql .= " AND DATE(A.TGL_NOTA) >= '$tgl_nota_start'";
				} else if ($tgl_nota_end != "") {
					$addsql .= " AND DATE(A.TGL_NOTA) <= '$tgl_nota_end'";
				} else {
					#$addsql .= " AND MONTH(A.TGL_TIBA) = MONTH(NOW()) AND YEAR(A.TGL_TIBA) = YEAR(NOW())";
				}

				if ($tgl_req_start != "" and $tgl_req_end != "") {
					$addsql .= " AND DATE(A.TGL_REQ) BETWEEN '$tgl_req_start' AND '$tgl_req_end'";
				} else if ($tgl_req_start != "") {
					$addsql .= " AND DATE(A.TGL_REQ) => '$tgl_req_start'";
				} else if ($tgl_req_end != "") {
					$addsql .= " AND DATE(A.TGL_REQ) <= '$tgl_req_end'";
				}

				if ($no_cust != "") {
					$addsql .= " AND B.NAMA_CUST = '$no_cust'";
				}
				$SQL = "SELECT A.ID_REQ, A.NO_NOTA_BEHANDLE, A.TGL_NOTA,'BEHANDLE' AS JNS_NOTA, A.SUBTOTAL ,A.PPN ,A.BIAYA_MATERAI ,
						A.TOTAL_JUMLAH, A.NAMA_CUST,A.NPWP, B.NO_CONT
						FROM req_behandle_hdr A
						LEFT JOIN (SELECT ID_REQ, GROUP_CONCAT(NO_CONT,'[',UK_CONT,']' SEPARATOR '\r') AS NO_CONT
					FROM req_behandle_dtl GROUP BY ID_REQ) B ON B.ID_REQ=A.ID_REQ
						WHERE 1=1 AND A.NO_NOTA_BEHANDLE != ''" . $addsql; #echo $SQL; die();
				$result = $func->main->get_result($SQL);
				$this->load->library('newphpexcel');
				$this->newphpexcel->getDefaultStyle()->getFont()->setName('Calibri')->setSize(10);
				$this->newphpexcel->setActiveSheetIndex(0);
				$styleArray = array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
				$this->newphpexcel->getDefaultStyle()->applyFromArray($styleArray);
				$this->newphpexcel->set_bold(array('A1'));
				$this->newphpexcel->mergecell(array(array('A1', 'M1')), FALSE);
				$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A1', 'REPORT BILLING BEHANDLE');
				$this->newphpexcel->width(array(array('A', 5), array('B', 25), array('C', 25), array('D', 25), array('E', 20), array('F', 15), array('G', 15), array('H', 10), array('I', 15), array('J', 25), array('K', 25), array('L', 25)));
				$this->newphpexcel->setActiveSheetIndex(0)
					->setCellValue('A3', 'NO')
					->setCellValue('B3', 'NO REQUEST')
					->setCellValue('C3', 'NO NOTA')
					->setCellValue('D3', 'TGL NOTA')
					->setCellValue('E3', 'JENIS NOTA')
					->setCellValue('F3', 'NILAI TAGIHAN')
					->setCellValue('G3', 'NILAI PPN')
					->setCellValue('H3', 'NILAI MATERAI')
					->setCellValue('I3', 'NILAI NOTA')
					->setCellValue('J3', 'CUSTOMER')
					->setCellValue('K3', 'NPWP')
					->setCellValue('L3', 'NOMOR CONTAINER');
				$this->newphpexcel->headings(array('A3', 'B3', 'C3', 'D3', 'E3', 'F3', 'G3', 'H3', 'I3', 'J3', 'K3', 'L3'));
				$this->newphpexcel->set_wrap(array('B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L'));
				$no = 1;
				$rec = 4;
				if ($result) {
					foreach ($SQL->result_array() as $row) {
						$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A' . $rec, $no)
							->setCellValueExplicit('B' . $rec, $row["ID_REQ"], PHPExcel_Cell_DataType::TYPE_STRING)
							->setCellValueExplicit('C' . $rec, $row["NO_NOTA_BEHANDLE"], PHPExcel_Cell_DataType::TYPE_STRING)
							->setCellValueExplicit('D' . $rec, $row["TGL_NOTA"], PHPExcel_Cell_DataType::TYPE_STRING)
							->setCellValue('E' . $rec, $row["JNS_NOTA"])
							->setCellValueExplicit('F' . $rec, $row["SUBTOTAL"], PHPExcel_Cell_DataType::TYPE_STRING)
							->setCellValue('G' . $rec, $row["PPN"])
							->setCellValueExplicit('H' . $rec, $row["BIAYA_MATERAI"], PHPExcel_Cell_DataType::TYPE_STRING)
							->setCellValue('I' . $rec, $row["TOTAL_JUMLAH"])
							->setCellValue('J' . $rec, $row["NAMA_CUST"])
							->setCellValue('K' . $rec, $row["NPWP"])
							->setCellValue('L' . $rec, $row["NO_CONT"]);
						$this->newphpexcel->set_detilstyle(array('A' . $rec, 'B' . $rec, 'C' . $rec, 'D' . $rec, 'E' . $rec, 'F' . $rec, 'G' . $rec, 'H' . $rec, 'I' . $rec, 'J' . $rec, 'K' . $rec, 'L' . $rec));
						$rec++;
						$no++;
					}
				} else {
					$this->newphpexcel->getActiveSheet()->mergeCells('A4:L4');
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A5', 'DATA TIDAK DITEMUKAN');
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
			} else if ($act == "bilbehandle2") {
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

				if ($tgl_nota_start != "" and $tgl_nota_end != "") {
					$addsql .= " AND DATE(A.TGL_NOTA) BETWEEN '$tgl_nota_start' AND '$tgl_nota_end'";
				} else if ($tgl_nota_start != "") {
					$addsql .= " AND DATE(A.TGL_NOTA) >= '$tgl_nota_start'";
				} else if ($tgl_nota_end != "") {
					$addsql .= " AND DATE(A.TGL_NOTA) <= '$tgl_nota_end'";
				} else {
					#$addsql .= " AND MONTH(A.TGL_TIBA) = MONTH(NOW()) AND YEAR(A.TGL_TIBA) = YEAR(NOW())";
				}

				if ($tgl_req_start != "" and $tgl_req_end != "") {
					$addsql .= " AND DATE(A.TGL_REQ) BETWEEN '$tgl_req_start' AND '$tgl_req_end'";
				} else if ($tgl_req_start != "") {
					$addsql .= " AND DATE(A.TGL_REQ) => '$tgl_req_start'";
				} else if ($tgl_req_end != "") {
					$addsql .= " AND DATE(A.TGL_REQ) <= '$tgl_req_end'";
				}

				if ($no_cust != "") {
					$addsql .= " AND B.NAMA_CUST = '$no_cust'";
				}
				$SQL = "SELECT A.ID_REQ, A.NO_NOTA_BEHANDLE, A.TGL_NOTA,'BEHANDLE' AS JNS_NOTA, A.SUBTOTAL ,A.PPN ,A.BIAYA_MATERAI ,
						A.TOTAL_JUMLAH, A.NAMA_CUST,A.NPWP, B.NO_CONT
						FROM req_behandle_hdr A
						LEFT JOIN (SELECT ID_REQ, GROUP_CONCAT(NO_CONT,'[',UK_CONT,']' SEPARATOR '\r') AS NO_CONT
					FROM req_behandle_dtl GROUP BY ID_REQ) B ON B.ID_REQ=A.ID_REQ
						WHERE 1=1 AND A.NO_NOTA_BEHANDLE = '' OR A.NO_NOTA_BEHANDLE IS NULL" . $addsql; #echo $SQL; die();
				$result = $func->main->get_result($SQL);
				$this->load->library('newphpexcel');
				$this->newphpexcel->getDefaultStyle()->getFont()->setName('Calibri')->setSize(10);
				$this->newphpexcel->setActiveSheetIndex(0);
				$styleArray = array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
				$this->newphpexcel->getDefaultStyle()->applyFromArray($styleArray);
				$this->newphpexcel->set_bold(array('A1'));
				$this->newphpexcel->mergecell(array(array('A1', 'M1')), FALSE);
				$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A1', 'REPORT BILLING BEHANDLE');
				$this->newphpexcel->width(array(array('A', 5), array('B', 25), array('C', 25), array('D', 25), array('E', 20), array('F', 15), array('G', 15), array('H', 10), array('I', 15), array('J', 25), array('K', 25), array('L', 25)));
				$this->newphpexcel->setActiveSheetIndex(0)
					->setCellValue('A3', 'NO')
					->setCellValue('B3', 'NO REQUEST')
					->setCellValue('C3', 'NO NOTA')
					->setCellValue('D3', 'TGL NOTA')
					->setCellValue('E3', 'JENIS NOTA')
					->setCellValue('F3', 'NILAI TAGIHAN')
					->setCellValue('G3', 'NILAI PPN')
					->setCellValue('H3', 'NILAI MATERAI')
					->setCellValue('I3', 'NILAI NOTA')
					->setCellValue('J3', 'CUSTOMER')
					->setCellValue('K3', 'NPWP')
					->setCellValue('L3', 'NOMOR CONTAINER');
				$this->newphpexcel->headings(array('A3', 'B3', 'C3', 'D3', 'E3', 'F3', 'G3', 'H3', 'I3', 'J3', 'K3', 'L3'));
				$this->newphpexcel->set_wrap(array('B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L'));
				$no = 1;
				$rec = 4;
				if ($result) {
					foreach ($SQL->result_array() as $row) {
						$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A' . $rec, $no)
							->setCellValueExplicit('B' . $rec, $row["ID_REQ"], PHPExcel_Cell_DataType::TYPE_STRING)
							->setCellValueExplicit('C' . $rec, $row["NO_NOTA_BEHANDLE"], PHPExcel_Cell_DataType::TYPE_STRING)
							->setCellValueExplicit('D' . $rec, $row["TGL_NOTA"], PHPExcel_Cell_DataType::TYPE_STRING)
							->setCellValue('E' . $rec, $row["JNS_NOTA"])
							->setCellValueExplicit('F' . $rec, $row["SUBTOTAL"], PHPExcel_Cell_DataType::TYPE_STRING)
							->setCellValue('G' . $rec, $row["PPN"])
							->setCellValueExplicit('H' . $rec, $row["BIAYA_MATERAI"], PHPExcel_Cell_DataType::TYPE_STRING)
							->setCellValue('I' . $rec, $row["TOTAL_JUMLAH"])
							->setCellValue('J' . $rec, $row["NAMA_CUST"])
							->setCellValue('K' . $rec, $row["NPWP"])
							->setCellValue('L' . $rec, $row["NO_CONT"]);
						$this->newphpexcel->set_detilstyle(array('A' . $rec, 'B' . $rec, 'C' . $rec, 'D' . $rec, 'E' . $rec, 'F' . $rec, 'G' . $rec, 'H' . $rec, 'I' . $rec, 'J' . $rec, 'K' . $rec, 'L' . $rec));
						$rec++;
						$no++;
					}
				} else {
					$this->newphpexcel->getActiveSheet()->mergeCells('A4:L4');
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A5', 'DATA TIDAK DITEMUKAN');
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
			} else if ($act == "bildelivery") { //print_r($_POST);die();
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

				if ($tgl_nota_start != "" and $tgl_nota_end != "") {
					$addsql .= " AND DATE(A.TGL_NOTA) BETWEEN '$tgl_nota_start' AND '$tgl_nota_end'";
				} else if ($tgl_nota_start != "") {
					$addsql .= " AND DATE(A.TGL_NOTA) >= '$tgl_nota_start'";
				} else if ($tgl_nota_end != "") {
					$addsql .= " AND DATE(A.TGL_NOTA) <= '$tgl_nota_end'";
				} else {
					#$addsql .= " AND MONTH(A.TGL_TIBA) = MONTH(NOW()) AND YEAR(A.TGL_TIBA) = YEAR(NOW())";
				}

				if ($tgl_req_start != "" and $tgl_req_end != "") {
					$addsql .= " AND DATE(A.TGL_REQ) BETWEEN '$tgl_req_start' AND '$tgl_req_end'";
				} else if ($tgl_req_start != "") {
					$addsql .= " AND DATE(A.TGL_REQ) => '$tgl_req_start'";
				} else if ($tgl_req_end != "") {
					$addsql .= " AND DATE(A.TGL_REQ) <= '$tgl_req_end'";
				}

				if ($no_cust != "") {
					$addsql .= " AND B.NAMA_CUST = '$no_cust'";
				}
				$SQL = "SELECT A.ID_REQ, A.NO_NOTA_DELIVERY, A.TGL_NOTA,'BEHANDLE' AS JNS_NOTA, A.SUBTOTAL ,A.PPN ,A.BIAYA_MATERAI ,
						A.TOTAL, C.NAMA_CUST,A.NPWP, B.NO_CONT
						FROM req_delivery_hdr A
						LEFT JOIN (SELECT ID_REQ, GROUP_CONCAT(NO_CONT,'[',UKR_CONT,']' SEPARATOR '\r') AS NO_CONT
					FROM req_delivery_dtl GROUP BY ID_REQ) B ON B.ID_REQ=A.ID_REQ
						INNER JOIN m_pelanggan C ON A.NPWP=C.NPWP
						WHERE 1=1 AND ID_REQ_OLD IS NULL AND A.NO_NOTA_DELIVERY != ''" . $addsql; #echo $SQL; die();
				$result = $func->main->get_result($SQL);
				$this->load->library('newphpexcel');
				$this->newphpexcel->getDefaultStyle()->getFont()->setName('Calibri')->setSize(10);
				$this->newphpexcel->setActiveSheetIndex(0);
				$styleArray = array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
				$this->newphpexcel->getDefaultStyle()->applyFromArray($styleArray);
				$this->newphpexcel->set_bold(array('A1'));
				$this->newphpexcel->mergecell(array(array('A1', 'M1')), FALSE);
				$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A1', 'REPORT BILLING DELIVERY');
				$this->newphpexcel->width(array(array('A', 5), array('B', 25), array('C', 25), array('D', 25), array('E', 20), array('F', 15), array('G', 15), array('H', 10), array('I', 15), array('J', 25), array('K', 25), array('L', 25)));
				$this->newphpexcel->setActiveSheetIndex(0)
					->setCellValue('A3', 'NO')
					->setCellValue('B3', 'NO REQUEST')
					->setCellValue('C3', 'NO NOTA')
					->setCellValue('D3', 'TGL NOTA')
					->setCellValue('E3', 'JENIS NOTA')
					->setCellValue('F3', 'NILAI TAGIHAN')
					->setCellValue('G3', 'NILAI PPN')
					->setCellValue('H3', 'NILAI MATERAI')
					->setCellValue('I3', 'NILAI NOTA')
					->setCellValue('J3', 'CUSTOMER')
					->setCellValue('K3', 'NPWP')
					->setCellValue('L3', 'NOMOR CONTAINER');
				$this->newphpexcel->headings(array('A3', 'B3', 'C3', 'D3', 'E3', 'F3', 'G3', 'H3', 'I3', 'J3', 'K3', 'L3'));
				$this->newphpexcel->set_wrap(array('B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L'));
				$no = 1;
				$rec = 4;
				if ($result) {
					foreach ($SQL->result_array() as $row) {
						$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A' . $rec, $no)
							->setCellValueExplicit('B' . $rec, $row["ID_REQ"], PHPExcel_Cell_DataType::TYPE_STRING)
							->setCellValueExplicit('C' . $rec, $row["NO_NOTA_DELIVERY"], PHPExcel_Cell_DataType::TYPE_STRING)
							->setCellValueExplicit('D' . $rec, $row["TGL_NOTA"], PHPExcel_Cell_DataType::TYPE_STRING)
							->setCellValue('E' . $rec, $row["JNS_NOTA"])
							->setCellValueExplicit('F' . $rec, $row["SUBTOTAL"], PHPExcel_Cell_DataType::TYPE_STRING)
							->setCellValue('G' . $rec, $row["PPN"])
							->setCellValueExplicit('H' . $rec, $row["BIAYA_MATERAI"], PHPExcel_Cell_DataType::TYPE_STRING)
							->setCellValue('I' . $rec, $row["TOTAL"])
							->setCellValue('J' . $rec, $row["NAMA_CUST"])
							->setCellValue('K' . $rec, $row["NPWP"])
							->setCellValue('L' . $rec, $row["NO_CONT"]);
						$this->newphpexcel->set_detilstyle(array('A' . $rec, 'B' . $rec, 'C' . $rec, 'D' . $rec, 'E' . $rec, 'F' . $rec, 'G' . $rec, 'H' . $rec, 'I' . $rec, 'J' . $rec, 'K' . $rec, 'L' . $rec));
						$rec++;
						$no++;
					}
				} else {
					$this->newphpexcel->getActiveSheet()->mergeCells('A4:L4');
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A5', 'DATA TIDAK DITEMUKAN');
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
			} else if ($act == "bildelivery2") {
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

				if ($tgl_nota_start != "" and $tgl_nota_end != "") {
					$addsql .= " AND DATE(A.TGL_NOTA) BETWEEN '$tgl_nota_start' AND '$tgl_nota_end'";
				} else if ($tgl_nota_start != "") {
					$addsql .= " AND DATE(A.TGL_NOTA) >= '$tgl_nota_start'";
				} else if ($tgl_nota_end != "") {
					$addsql .= " AND DATE(A.TGL_NOTA) <= '$tgl_nota_end'";
				} else {
					#$addsql .= " AND MONTH(A.TGL_TIBA) = MONTH(NOW()) AND YEAR(A.TGL_TIBA) = YEAR(NOW())";
				}

				if ($tgl_req_start != "" and $tgl_req_end != "") {
					$addsql .= " AND DATE(A.TGL_REQ) BETWEEN '$tgl_req_start' AND '$tgl_req_end'";
				} else if ($tgl_req_start != "") {
					$addsql .= " AND DATE(A.TGL_REQ) => '$tgl_req_start'";
				} else if ($tgl_req_end != "") {
					$addsql .= " AND DATE(A.TGL_REQ) <= '$tgl_req_end'";
				}

				if ($no_cust != "") {
					$addsql .= " AND B.NAMA_CUST = '$no_cust'";
				}
				$SQL = "SELECT A.ID_REQ, A.NO_NOTA_DELIVERY, A.TGL_NOTA,'BEHANDLE' AS JNS_NOTA, A.SUBTOTAL ,A.PPN ,A.BIAYA_MATERAI ,
						A.TOTAL, C.NAMA_CUST,A.NPWP, B.NO_CONT
						FROM req_delivery_hdr A
						LEFT JOIN (SELECT ID_REQ, GROUP_CONCAT(NO_CONT,'[',UKR_CONT,']' SEPARATOR '\r') AS NO_CONT
					FROM req_delivery_dtl GROUP BY ID_REQ) B ON B.ID_REQ=A.ID_REQ
						INNER JOIN m_pelanggan C ON A.NPWP=C.NPWP
						WHERE 1=1 AND ID_REQ_OLD IS NULL AND A.NO_NOTA_DELIVERY = '' OR A.NO_NOTA_DELIVERY IS NULL" . $addsql; #echo $SQL; die();
				$result = $func->main->get_result($SQL);
				$this->load->library('newphpexcel');
				$this->newphpexcel->getDefaultStyle()->getFont()->setName('Calibri')->setSize(10);
				$this->newphpexcel->setActiveSheetIndex(0);
				$styleArray = array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
				$this->newphpexcel->getDefaultStyle()->applyFromArray($styleArray);
				$this->newphpexcel->set_bold(array('A1'));
				$this->newphpexcel->mergecell(array(array('A1', 'M1')), FALSE);
				$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A1', 'REPORT BILLING DELIVERY');
				$this->newphpexcel->width(array(array('A', 5), array('B', 25), array('C', 25), array('D', 25), array('E', 20), array('F', 15), array('G', 15), array('H', 10), array('I', 15), array('J', 25), array('K', 25), array('L', 25)));
				$this->newphpexcel->setActiveSheetIndex(0)
					->setCellValue('A3', 'NO')
					->setCellValue('B3', 'NO REQUEST')
					->setCellValue('C3', 'NO NOTA')
					->setCellValue('D3', 'TGL NOTA')
					->setCellValue('E3', 'JENIS NOTA')
					->setCellValue('F3', 'NILAI TAGIHAN')
					->setCellValue('G3', 'NILAI PPN')
					->setCellValue('H3', 'NILAI MATERAI')
					->setCellValue('I3', 'NILAI NOTA')
					->setCellValue('J3', 'CUSTOMER')
					->setCellValue('K3', 'NPWP')
					->setCellValue('L3', 'NOMOR CONTAINER');
				$this->newphpexcel->headings(array('A3', 'B3', 'C3', 'D3', 'E3', 'F3', 'G3', 'H3', 'I3', 'J3', 'K3', 'L3'));
				$this->newphpexcel->set_wrap(array('B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L'));
				$no = 1;
				$rec = 4;
				if ($result) {
					foreach ($SQL->result_array() as $row) {
						$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A' . $rec, $no)
							->setCellValueExplicit('B' . $rec, $row["ID_REQ"], PHPExcel_Cell_DataType::TYPE_STRING)
							->setCellValueExplicit('C' . $rec, $row["NO_NOTA_DELIVERY"], PHPExcel_Cell_DataType::TYPE_STRING)
							->setCellValueExplicit('D' . $rec, $row["TGL_NOTA"], PHPExcel_Cell_DataType::TYPE_STRING)
							->setCellValue('E' . $rec, $row["JNS_NOTA"])
							->setCellValueExplicit('F' . $rec, $row["SUBTOTAL"], PHPExcel_Cell_DataType::TYPE_STRING)
							->setCellValue('G' . $rec, $row["PPN"])
							->setCellValueExplicit('H' . $rec, $row["BIAYA_MATERAI"], PHPExcel_Cell_DataType::TYPE_STRING)
							->setCellValue('I' . $rec, $row["TOTAL"])
							->setCellValue('J' . $rec, $row["NAMA_CUST"])
							->setCellValue('K' . $rec, $row["NPWP"])
							->setCellValue('L' . $rec, $row["NO_CONT"]);
						$this->newphpexcel->set_detilstyle(array('A' . $rec, 'B' . $rec, 'C' . $rec, 'D' . $rec, 'E' . $rec, 'F' . $rec, 'G' . $rec, 'H' . $rec, 'I' . $rec, 'J' . $rec, 'K' . $rec, 'L' . $rec));
						$rec++;
						$no++;
					}
				} else {
					$this->newphpexcel->getActiveSheet()->mergeCells('A4:L4');
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A5', 'DATA TIDAK DITEMUKAN');
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
			} else if ($act == "pergerakan") {
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

				if ($tgl_nota_start != "" and $tgl_nota_end != "") {
					$addsql .= " AND DATE(A.TGL_NOTA) BETWEEN '$tgl_nota_start' AND '$tgl_nota_end'";
				} else if ($tgl_nota_start != "") {
					$addsql .= " AND DATE(A.TGL_NOTA) >= '$tgl_nota_start'";
				} else if ($tgl_nota_end != "") {
					$addsql .= " AND DATE(A.TGL_NOTA) <= '$tgl_nota_end'";
				} else {
					#$addsql .= " AND MONTH(A.TGL_TIBA) = MONTH(NOW()) AND YEAR(A.TGL_TIBA) = YEAR(NOW())";
				}

				if ($tgl_req_start != "" and $tgl_req_end != "") {
					$addsql .= " AND DATE(A.TGL_REQ) BETWEEN '$tgl_req_start' AND '$tgl_req_end'";
				} else if ($tgl_req_start != "") {
					$addsql .= " AND DATE(A.TGL_REQ) >= '$tgl_req_start'";
				} else if ($tgl_req_end != "") {
					$addsql .= " AND DATE(A.TGL_REQ) <= '$tgl_req_end'";
				}

				if ($no_spk == "") {
					$addsql .= " ORDER BY NO_SPK, NO_CONT  ";
				} else {
					$addsql .= " ORDER BY NO_SPK, NO_CONT  ";
				}

				$SQL = "SELECT A.NO_SPK,C.NAMA, A.NO_DOK,A.TGL_DOK,A.NM_KAPAL,A.NO_VOY,A.NPWP,A.CONSIGNEE,B.NO_CONT,B.UKR_CONT,
						A.WK_REQ,D.WK_PICKUP, D.WK_IN, D.WK_START, D.WK_FINISH, D.WK_TRUCKIN, D.WK_CHASSIS, D.WK_GATEOUT
						FROM t_spk A
						INNER JOIN t_spk_cont B ON A.ID = B.ID
						LEFT JOIN reff_kode_dok_bc C ON C.ID = A.JNS_DOK
						LEFT JOIN t_operation D ON A.NO_SPK = D.NO_SPK AND B.NO_CONT = D.NO_CONT WHERE 1=1 " . $addsql; //echo $SQL; die();
				$result = $func->main->get_result($SQL);
				$this->load->library('newphpexcel');
				$this->newphpexcel->getDefaultStyle()->getFont()->setName('Calibri')->setSize(10);
				$this->newphpexcel->setActiveSheetIndex(0);
				$styleArray = array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
				$this->newphpexcel->getDefaultStyle()->applyFromArray($styleArray);
				$this->newphpexcel->set_bold(array('A1'));
				$this->newphpexcel->mergecell(array(array('A1', 'S1')), FALSE);
				$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A1', 'REPORT PERGERAKAN');
				$this->newphpexcel->width(array(array('A', 5), array('B', 15), array('C', 15), array('D', 25), array('E', 20), array('F', 25), array('G', 15), array('H', 20), array('I', 25), array('J', 20), array('K', 10), array('L', 25), array('M', 25), array('N', 25), array('O', 25), array('P', 25), array('Q', 25), array('R', 25), array('S', 25)));
				$this->newphpexcel->setActiveSheetIndex(0)
					->setCellValue('A3', 'NO')
					->setCellValue('B3', 'NO SPK')
					->setCellValue('C3', 'JENIS DOKUMEN')
					->setCellValue('D3', 'NO DOKUMEN')
					->setCellValue('E3', 'TANGGAL DOKUMEN')
					->setCellValue('F3', 'NAMA KAPAL')
					->setCellValue('G3', 'NO VOYAGE')
					->setCellValue('H3', 'NPWP')
					->setCellValue('I3', 'CONSIGNEE')
					->setCellValue('J3', 'NO KONTAINER')
					->setCellValue('K3', 'UKURAN KONTAINER')
					->setCellValue('L3', 'CREATE SPK')
					->setCellValue('M3', 'PICKUP')
					->setCellValue('N3', 'BEHANDLE IN')
					->setCellValue('O3', 'START PEMERIKSAAN')
					->setCellValue('P3', 'FINISH PEMERIKSAAN')
					->setCellValue('Q3', 'TRUCK IN')
					->setCellValue('R3', 'ON CHASSIS')
					->setCellValue('S3', 'DELIVERY');
				$this->newphpexcel->headings(array('A3', 'B3', 'C3', 'D3', 'E3', 'F3', 'G3', 'H3', 'I3', 'J3', 'K3', 'L3', 'M3', 'N3', 'O3', 'P3', 'Q3', 'R3', 'S3'));
				$this->newphpexcel->set_wrap(array('B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S'));
				$no = 1;
				$rec = 4;
				if ($result) {
					foreach ($SQL->result_array() as $row) {
						$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A' . $rec, $no)
							->setCellValue('B' . $rec, $row["NO_SPK"])
							->setCellValue('C' . $rec, $row["NAMA"])
							->setCellValue('D' . $rec, $row["NO_DOK"])
							->setCellValueExplicit('E' . $rec, $row["TGL_DOK"], PHPExcel_Cell_DataType::TYPE_STRING)
							->setCellValue('F' . $rec, $row["NM_KAPAL"])
							->setCellValue('G' . $rec, $row["NO_VOY"])
							->setCellValueExplicit('H' . $rec, $row["NPWP"], PHPExcel_Cell_DataType::TYPE_STRING)
							->setCellValue('I' . $rec, $row["CONSIGNEE"])
							->setCellValue('J' . $rec, $row["NO_CONT"])
							->setCellValueExplicit('K' . $rec, $row["UKR_CONT"], PHPExcel_Cell_DataType::TYPE_STRING)
							->setCellValueExplicit('L' . $rec, $row["WK_REQ"], PHPExcel_Cell_DataType::TYPE_STRING)
							->setCellValueExplicit('M' . $rec, $row["WK_PICKUP"], PHPExcel_Cell_DataType::TYPE_STRING)
							->setCellValueExplicit('N' . $rec, $row["WK_IN"], PHPExcel_Cell_DataType::TYPE_STRING)
							->setCellValueExplicit('O' . $rec, $row["WK_START"], PHPExcel_Cell_DataType::TYPE_STRING)
							->setCellValueExplicit('P' . $rec, $row["WK_FINISH"], PHPExcel_Cell_DataType::TYPE_STRING)
							->setCellValueExplicit('Q' . $rec, $row["WK_TRUCKIN"], PHPExcel_Cell_DataType::TYPE_STRING)
							->setCellValueExplicit('R' . $rec, $row["WK_CHASSIS"], PHPExcel_Cell_DataType::TYPE_STRING)
							->setCellValueExplicit('S' . $rec, $row["WK_GATEOUT"], PHPExcel_Cell_DataType::TYPE_STRING);
						$this->newphpexcel->set_detilstyle(array('A' . $rec, 'B' . $rec, 'C' . $rec, 'D' . $rec, 'E' . $rec, 'F' . $rec, 'G' . $rec, 'H' . $rec, 'I' . $rec, 'J' . $rec, 'K' . $rec, 'L' . $rec, 'M' . $rec, 'N' . $rec, 'O' . $rec, 'P' . $rec, 'Q' . $rec, 'R' . $rec, 'S' . $rec));
						$rec++;
						$no++;
					}
				} else {
					$this->newphpexcel->getActiveSheet()->mergeCells('A4:L4');
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A5', 'DATA TIDAK DITEMUKAN');
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
			} else if ($act == "report_jinspection") {
				$no_aju = $this->input->post('form[0]');
				$tgl_aju = $this->input->post('form[1]');
				$tgl_awal = $tgl_aju[0];
				$tgl_akhir = $tgl_aju[1];
				$addsql = "";

				if ($tgl_awal != "" and $tgl_akhir != "") {
					$addsql .= " AND DATE(A.LNSW_TGLAJU) BETWEEN '$tgl_awal' AND '$tgl_akhir'";
				} else if ($tgl_awal != "") {
					$addsql .= " AND DATE(A.LNSW_TGLAJU) >= '$tgl_awal'";
				} else if ($tgl_akhir != "") {
					$addsql .= " AND DATE(A.LNSW_TGLAJU) <= '$tgl_akhir'";
				}

				// var_dump($no_aju[0]);die();

				if ($no_aju[0] != "") {
					$addsql .= " AND A.LNSW_NOAJU LIKE '%$no_aju[0]%'  ";
				}

				$SQL = "SELECT distinct A.NO_CONT, A.LNSW_NOAJU,A.LNSW_TGLAJU, A.NO_RESPON, A.TG_RESPON, A.NO_DAFTAR_PABEAN, DATE_FORMAT(A.TGL_DAFTAR_PABEAN, '%Y-%m-%d') 'TGL_DAFTAR_PABEAN', E.NM_KAPAL,E.NO_VOY, E.NPWP, E.NAMA_CUST, G.START_INSP, F.FINISH_INSP
					FROM v_ppk_permit_join A
					JOIN (
					SELECT b.NO_DOK, b.TGL_DOK, c.NO_CONT, c.STATUS_CONT, b.NM_KAPAL, b.NO_VOY, b.NPWP, b.CONSIGNEE FROM t_spk b
					JOIN t_spk_cont c ON b.id = c.id) D ON A.NO_RESPON = D.NO_DOK AND A.TG_RESPON = D.TGL_DOK AND A.NO_CONT = D.NO_CONT
					LEFT JOIN t_gatepass E ON A.NO_RESPON = E.NO_DOK AND A.TG_RESPON = E.TGL_DOK AND A.NO_CONT = E.NO_CONT
					LEFT JOIN t_op_inspection F ON F.NO_DOK = A.NO_DAFTAR_PABEAN AND YEAR(F.TGL_DOK) = YEAR(A.TGL_DAFTAR_PABEAN) AND F.NO_CONT = A.NO_CONT
					LEFT JOIN t_op_inspection G ON G.NO_DOK = A.NO_RESPON AND YEAR(G.TGL_DOK) = YEAR(A.TG_RESPON) AND G.NO_CONT = A.NO_CONT
					WHERE F.STATUS = 'DONE'" . $addsql . "ORDER BY A.LNSW_NOAJU DESC"; //echo $SQL; die();
				$result = $func->main->get_result($SQL);
				$this->load->library('newphpexcel');
				$this->newphpexcel->getDefaultStyle()->getFont()->setName('Calibri')->setSize(10);
				$this->newphpexcel->setActiveSheetIndex(0);
				$styleArray = array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
				$this->newphpexcel->getDefaultStyle()->applyFromArray($styleArray);
				$this->newphpexcel->set_bold(array('A1'));
				$this->newphpexcel->mergecell(array(array('A1', 'H1')), FALSE);
				$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A1', 'REPORT PERGERAKAN');
				$this->newphpexcel->width(array(array('A', 5), array('B', 15), array('C', 35), array('D', 40), array('E', 35), array('F', 35), array('G', 35), array('H', 35)));
				$this->newphpexcel->setActiveSheetIndex(0)
					->setCellValue('A3', 'NO')
					->setCellValue('B3', 'NO KONTAINER')
					->setCellValue('C3', 'DOKUMEN JOIN INSPECTION')
					->setCellValue('D3', 'DOKUMEN KARANTINA DAN BEACUKAI')
					->setCellValue('E3', 'KAPAL')
					->setCellValue('F3', 'CUSTOMER')
					->setCellValue('G3', 'START INSPECTION')
					->setCellValue('H3', 'FINISH INSPECTION');
				$this->newphpexcel->headings(array('A3', 'B3', 'C3', 'D3', 'E3', 'F3', 'G3', 'H3'));
				$this->newphpexcel->set_wrap(array('B', 'C', 'D', 'E', 'F', 'G', 'H'));
				$no = 1;
				$rec = 4;
				if ($result) {
					foreach ($SQL->result_array() as $row) {
						$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A' . $rec, $no)
							->setCellValue('B' . $rec, $row["NO_CONT"])
							->setCellValue('C' . $rec, 'Jenis: Join Inspection 
							No: ' . $row["LNSW_NOAJU"] . '
							Tanggal: ' . $row["LNSW_TGLAJU"])
							->setCellValue('D' . $rec, 'Jenis: Karantina 
							No: ' . $row["NO_RESPON"] . '
							Tanggal: ' . $row["TG_RESPON"] . '

							Jenis: Beacukai
							No: ' . $row["NO_DAFTAR_PABEAN"] . '
							Tanggal: ' . $row["TGL_DAFTAR_PABEAN"])
							->setCellValueExplicit('E' . $rec, 'Nama Kapal: ' . $row["NM_KAPAL"] . '
							No Voyage: ' . $row["NO_VOY"])
							->setCellValue('F' . $rec, 'NPWP: ' . $row["NPWP"] . '
							Nama: ' . $row["NAMA_CUST"])
							->setCellValue('G' . $rec, $row["START_INSP"])
							->setCellValue('H' . $rec, $row["FINISH_INSP"]);
						$this->newphpexcel->set_detilstyle(array('A' . $rec, 'B' . $rec, 'C' . $rec, 'D' . $rec, 'E' . $rec, 'F' . $rec, 'G' . $rec, 'H' . $rec));
						$rec++;
						$no++;
					}
				} else {
					$this->newphpexcel->getActiveSheet()->mergeCells('A4:H4');
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A5', 'DATA TIDAK DITEMUKAN');
					$this->newphpexcel->set_detilstyle(array('A5'));
				}
				ob_clean();

				$file = "Report_JOIN_" . date("Ymd") . ".xls";
				header("Content-type: application/x-msdownload");
				header("Content-Disposition: attachment;filename=$file");
				header("Cache-Control: max-age=0");
				header("Pragma: no-cache");
				header("Expires: 0");
				$objWriter = PHPExcel_IOFactory::createWriter($this->newphpexcel, 'Excel5');
				$objWriter->save('php://output');
				exit();
			} else if ($act == "bilextention") { //print_r($_POST);die();
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

				if ($tgl_nota_start != "" and $tgl_nota_end != "") {
					$addsql .= " AND DATE(A.TGL_NOTA) BETWEEN '$tgl_nota_start' AND '$tgl_nota_end'";
				} else if ($tgl_nota_start != "") {
					$addsql .= " AND DATE(A.TGL_NOTA) >= '$tgl_nota_start'";
				} else if ($tgl_nota_end != "") {
					$addsql .= " AND DATE(A.TGL_NOTA) <= '$tgl_nota_end'";
				} else {
					#$addsql .= " AND MONTH(A.TGL_TIBA) = MONTH(NOW()) AND YEAR(A.TGL_TIBA) = YEAR(NOW())";
				}

				if ($tgl_req_start != "" and $tgl_req_end != "") {
					$addsql .= " AND DATE(A.TGL_REQ) BETWEEN '$tgl_req_start' AND '$tgl_req_end'";
				} else if ($tgl_req_start != "") {
					$addsql .= " AND DATE(A.TGL_REQ) => '$tgl_req_start'";
				} else if ($tgl_req_end != "") {
					$addsql .= " AND DATE(A.TGL_REQ) <= '$tgl_req_end'";
				}

				if ($no_cust != "") {
					$addsql .= " AND B.NAMA_CUST = '$no_cust'";
				}
				$SQL = "SELECT A.ID_REQ, A.NO_NOTA_DELIVERY, A.TGL_NOTA,'BEHANDLE' AS JNS_NOTA, A.SUBTOTAL ,A.PPN ,A.BIAYA_MATERAI ,
						A.TOTAL, C.NAMA_CUST,A.NPWP, B.NO_CONT
						FROM req_delivery_hdr A
						LEFT JOIN (SELECT ID_REQ, GROUP_CONCAT(NO_CONT,'[',UKR_CONT,']' SEPARATOR '\r') AS NO_CONT
					FROM req_delivery_dtl GROUP BY ID_REQ) B ON B.ID_REQ=A.ID_REQ
						INNER JOIN m_pelanggan C ON A.NPWP=C.NPWP
						WHERE 1=1 AND ID_REQ_OLD IS NOT NULL AND A.NO_NOTA_DELIVERY != ''" . $addsql; #echo $SQL; die();
				$result = $func->main->get_result($SQL);
				$this->load->library('newphpexcel');
				$this->newphpexcel->getDefaultStyle()->getFont()->setName('Calibri')->setSize(10);
				$this->newphpexcel->setActiveSheetIndex(0);
				$styleArray = array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
				$this->newphpexcel->getDefaultStyle()->applyFromArray($styleArray);
				$this->newphpexcel->set_bold(array('A1'));
				$this->newphpexcel->mergecell(array(array('A1', 'M1')), FALSE);
				$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A1', 'REPORT BILLING EXTENTION');
				$this->newphpexcel->width(array(array('A', 5), array('B', 25), array('C', 25), array('D', 25), array('E', 20), array('F', 15), array('G', 15), array('H', 10), array('I', 15), array('J', 25), array('K', 25), array('L', 25)));
				$this->newphpexcel->setActiveSheetIndex(0)
					->setCellValue('A3', 'NO')
					->setCellValue('B3', 'NO REQUEST')
					->setCellValue('C3', 'NO NOTA')
					->setCellValue('D3', 'TGL NOTA')
					->setCellValue('E3', 'JENIS NOTA')
					->setCellValue('F3', 'NILAI TAGIHAN')
					->setCellValue('G3', 'NILAI PPN')
					->setCellValue('H3', 'NILAI MATERAI')
					->setCellValue('I3', 'NILAI NOTA')
					->setCellValue('J3', 'CUSTOMER')
					->setCellValue('K3', 'NPWP')
					->setCellValue('L3', 'NOMOR CONTAINER');
				$this->newphpexcel->headings(array('A3', 'B3', 'C3', 'D3', 'E3', 'F3', 'G3', 'H3', 'I3', 'J3', 'K3', 'L3'));
				$this->newphpexcel->set_wrap(array('B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L'));
				$no = 1;
				$rec = 4;
				if ($result) {
					foreach ($SQL->result_array() as $row) {
						$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A' . $rec, $no)
							->setCellValueExplicit('B' . $rec, $row["ID_REQ"], PHPExcel_Cell_DataType::TYPE_STRING)
							->setCellValueExplicit('C' . $rec, $row["NO_NOTA_DELIVERY"], PHPExcel_Cell_DataType::TYPE_STRING)
							->setCellValueExplicit('D' . $rec, $row["TGL_NOTA"], PHPExcel_Cell_DataType::TYPE_STRING)
							->setCellValue('E' . $rec, $row["JNS_NOTA"])
							->setCellValueExplicit('F' . $rec, $row["SUBTOTAL"], PHPExcel_Cell_DataType::TYPE_STRING)
							->setCellValue('G' . $rec, $row["PPN"])
							->setCellValueExplicit('H' . $rec, $row["BIAYA_MATERAI"], PHPExcel_Cell_DataType::TYPE_STRING)
							->setCellValue('I' . $rec, $row["TOTAL"])
							->setCellValue('J' . $rec, $row["NAMA_CUST"])
							->setCellValue('K' . $rec, $row["NPWP"])
							->setCellValue('L' . $rec, $row["NO_CONT"]);
						$this->newphpexcel->set_detilstyle(array('A' . $rec, 'B' . $rec, 'C' . $rec, 'D' . $rec, 'E' . $rec, 'F' . $rec, 'G' . $rec, 'H' . $rec, 'I' . $rec, 'J' . $rec, 'K' . $rec, 'L' . $rec));
						$rec++;
						$no++;
					}
				} else {
					$this->newphpexcel->getActiveSheet()->mergeCells('A4:L4');
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A5', 'DATA TIDAK DITEMUKAN');
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
			} else if ($act == "stacking") {
				//echo json_encode($_POST);
				//die();
				$STATUS = $this->input->post('form[0]');
				$LOKASI = $this->input->post('form[1]');
				$TGL = $this->input->post('form[2]');
				/*print_r($STATUS);
							echo "<hr>";
							print_r($LOKASI);*/
				//die();
				// echo "<hr>";
				$TGL_AWAL = $TGL[0];
				$TGL_AKHIR = $TGL[1];
				$status_kontainer = $STATUS[0];
				$status_lokasi = $LOKASI[0];

				$addsql = "";

				if ($status_lokasi != "") {
					$addsql .= " AND B.LOKASI LIKE '$status_lokasi'";
				}

				if ($status_kontainer != "") {
					$addsql .= " AND B.STATUS_CONT IN ($status_kontainer)";
				}

				if ($TGL_AWAL != "" && $TGL_AKHIR != "") {
					$addsql .= " AND A.WK_REQ BETWEEN '$TGL_AWAL' AND '$TGL_AKHIR' GROUP BY B.NO_CONT";
				} else if ($TGL_AWAL != "") {
					$addsql .= " AND A.WK_REQ >= '$TGL_AWAL' GROUP BY B.NO_CONT";
				} else if ($TGL_AKHIR != "") {
					$addsql .= " AND A.WK_REQ <= '$TGL_AKHIR' GROUP BY B.NO_CONT";
				}

				if ($addsql == "") {
					$addsql2 = "ORDER BY A.WK_REQ DESC LIMIT 1000";
				}
				$SQL = "SELECT distinct A.NO_SPK, B.NO_CONT,case when R.FL_REEFER = 'Y' then 'REEFER' when R.FL_OOG = 'Y' then 'OOG' ELSE 'DRY' END AS KD_CONT_TIPE,B.UKR_CONT, 
				CASE WHEN R.KD_CONT_JENIS = 'F' THEN 'FULL' ELSE 'EMPTY' END AS STATUS_CONT,case when R.FL_DG = 'Y' then 'DG' END AS 'DG', E.IMO, R.VESSEL as NM_ANGKUT, R.VOY_IN AS NO_VOY, 
				case when C.STACKING IS NULL then E.DISCHARGE ELSE C.STACKING END AS STACKING , F.W_PICKUP, 'NO DATA' AS GATEIN_TERMINAL, 'NO DATA' AS GATEOUT_TERMINAL, F.W_BEHANDLE, A.WK_REQ, D.NAMA, A.NO_DOK, A.TGL_DOK, B.ID_FLAT AS 'TID', CONCAT((B.LOKASI),'0',(B.TIER)) AS 'LOKASI', 
				CASE WHEN B.STATUS_CONT IN ('450','510','530') AND B.LOKASI LIKE '1A%' THEN 'STACKING YARD 1A' WHEN B.STATUS_CONT IN ('450','510','530') AND B.LOKASI LIKE '1B%' THEN 'STACKING YARD 1B' WHEN B.STATUS_CONT IN ('460','520','540') THEN 'STACKING CIC' ELSE 'DELIVERY' END AS 'STATUS', 
				G.NAMA_CUST as CONSIGNEE, S.PLUG_TERMINAL,S.UNPLUG_TERMINAL,M.WAKTU,N.PLUG_END_DATE FROM t_spk A 
				INNER JOIN t_spk_cont B ON A.ID = B.ID 
				LEFT JOIN t_request_cont R ON R.NO_CONT = B.NO_CONT AND R.KD_STATUS = 'INQUIRY' and R.REQ_PILIH ='Y'
				left JOIN t_gatepass G ON B.NO_CONT = G.NO_CONT AND A.NO_DOK = G.NO_DOK 
				LEFT JOIN t_cocostscont Z on B.NO_CONT = Z.NO_CONT 
				left JOIN (SELECT A.ID, B.NO_CONT, A.NM_ANGKUT, A.NO_VOY_FLIGHT, B.JNS_CONT AS 'STATUS_CONT', B.ISO_CODE, B.KD_CONT_TIPE AS 'TIPE_CONT', B.WK_IN AS 'STACKING' FROM t_cocostshdr A INNER JOIN t_cocostscont B ON A.ID = B.ID WHERE B.WK_IN IS NOT NULL ORDER BY A.ID DESC) C ON B.NO_CONT = C.NO_CONT AND G.NM_KAPAL = C.NM_ANGKUT AND G.NO_VOY = C.NO_VOY_FLIGHT 
				LEFT JOIN reff_kode_dok_bc D ON D.ID = A.JNS_DOK 
				left JOIN (SELECT O.ID, B.NO_CONT, B.IMO, O.CONSIGNEE as CONSIGNEE, B.DISCHARGE FROM t_request O INNER JOIN t_request_cont B ON O.ID = B.ID) E ON B.NO_CONT = E.NO_CONT 
				LEFT JOIN (SELECT A.NO_SPK, B.NO_CONT, A.W_PICKUP, W_BEHANDLE, B.KONDISI_CONT, B.NO_SEAL, B.ROOM FROM t_op_pickup A INNER JOIN t_op_behandlein B ON A.NO_SPK = B.NO_SPK AND A.NO_CONT = B.NO_CONT) F ON A.NO_SPK = F.NO_SPK AND B.NO_CONT = F.NO_CONT 
				LEFT JOIN (SELECT L.NO_DOK, L.TGL_DOK, D.NO_CONT,D.PLUG_START_DATE, D.PLUG_END_DATE as PLUG_END_DATE  FROM req_delivery_dtl D inner join req_delivery_hdr L on D.ID_REQ = L.ID_REQ WHERE D.PLUG_END_DATE IS NOT NULL) N ON B.NO_CONT = N.NO_CONT and A.NO_DOK = N.NO_DOK and A.TGL_DOK = N.TGL_DOK 
				LEFT JOIN (SELECT trc.NO_CONT, tr.NO_DOK, tr.TGL_DOK, trc.VESSEL, trc.VOY_IN , trc.PLUG_TERMINAL as PLUG_TERMINAL,trc.UNPLUG_TERMINAL as UNPLUG_TERMINAL FROM t_request_cont trc inner join t_request tr on trc.ID = tr.ID WHERE trc.unplug_terminal IS NOT NULL AND trc.unplug_terminal IS NOT null order by trc.NO_CONT desc) S ON B.NO_CONT = S.NO_CONT and A.NO_DOK = S.NO_DOK and A.TGL_DOK = S.TGL_DOK
				LEFT JOIN (SELECT tru.NO_SPK, tru.NO_CONT, tru.WAKTU as WAKTU from t_op_reefer tru inner join t_op_reefer tor on tru.ID = tor.ID WHERE tru.WAKTU IS NOT null ) M ON B.NO_CONT = M.NO_CONT and A.NO_SPK = M.NO_SPK
				WHERE 1=1 " . $addsql . " " . $addsql2;

				$result = $func->main->get_result($SQL);
				$this->load->library('newphpexcel');
				$this->newphpexcel->getDefaultStyle()->getFont()->setName('Calibri')->setSize(10);
				$objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
				$objDrawing->setName('Logo');
				$objDrawing->setDescription('Logo');
				$logo = imagecreatefrompng('assets/images/Logomti.png');
				$objDrawing->setImageResource($logo);
				$objDrawing->setCoordinates('A1');
				$objDrawing->setHeight(100);
				$objDrawing->setWidth(100);
				$objDrawing->setWorksheet($this->newphpexcel->getActiveSheet());
				$this->newphpexcel->setActiveSheetIndex(0);
				$styleArray = array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
				$this->newphpexcel->getDefaultStyle()->applyFromArray($styleArray);
				$this->newphpexcel->set_bold(array('A1'));
				$this->newphpexcel->mergecell(array(array('A1', 'U1'), array('A2', 'U2'), array('A3', 'U3')), FALSE);
				$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A1', 'REPORT STACKING EX-BEHANDLE');
				$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A2', 'COMMON GATE PT. MTI');
				$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A3', date("M Y"));
				$this->newphpexcel->width(array(array('A', 5), array('B', 20), array('C', 20), array('D', 20), array('E', 7), array('F', 10), array('G', 6), array('H', 20), array('I', 25), array('J', 25), array('K', 25), array('L', 25), array('M', 25), array('N', 25), array('O', 25), array('P', 15), array('Q', 30), array('R', 25), array('S', 25), array('T', 25), array('U', 50), array('V', 25), array('W', 25), array('X', 25), array('Y', 25), array('Z', 25)));
				$this->newphpexcel->setActiveSheetIndex(0)
					->setCellValue('A5', 'NO')
					->setCellValue('B5', 'NO SPK')
					->setCellValue('C5', 'NO KONTAINER')
					->setCellValue('D5', 'TIPE KONTAINER')
					->setCellValue('E5', 'SIZE')
					->setCellValue('F5', 'STATUS')
					->setCellValue('G5', 'IMO')
					->setCellValue('H5', 'NAMA KAPAL')
					->setCellValue('I5', 'VOYAGE')
					->setCellValue('J5', 'STACKING')
					->setCellValue('K5', 'PICKUP')
					->setCellValue('L5', 'GATE IN TERMINAL')
					->setCellValue('M5', 'GATE OUT TERMINAL')
					->setCellValue('N5', 'BEHANDLE IN')
					->setCellValue('O5', 'TERBIT SPK')
					->setCellValue('P5', 'JENIS DOKUMEN')
					->setCellValue('Q5', 'NO DOKUMEN')
					->setCellValue('R5', 'TANGGAL DOKUMEN')
					->setCellValue('S5', 'TID')
					->setCellValue('T5', 'LOKASI')
					->setCellValue('U5', 'CUSTOMER')
					->setCellValue('V5', 'STATUS KONTAINER')
					->setCellValue('W5', 'PLUG NPCT1')
					->setCellValue('X5', 'UNPLUG NPCT1')
					->setCellValue('Y5', 'PLUG COMON GATE')
					->setCellValue('Z5', 'UNPLUG COMON GATE')
					->setCellValue('AA5', 'DG');
				$this->newphpexcel->headings(array('A5', 'B5', 'C5', 'D5', 'E5', 'F5', 'G5', 'H5', 'I5', 'J5', 'K5', 'L5', 'M5', 'N5', 'O5', 'P5', 'Q5', 'R5', 'S5', 'T5', 'U5', 'V5', 'W5', 'X5', 'Y5', 'Z5', 'AA5'));
				$this->newphpexcel->set_wrap(array('B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'AA'));
				$no = 1;
				$rec = 6;
				if ($result) {
					foreach ($SQL->result_array() as $row) {
						$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A' . $rec, $no)
							->setCellValue('B' . $rec, $row["NO_SPK"])
							->setCellValue('C' . $rec, $row["NO_CONT"])
							->setCellValue('D' . $rec, $row["KD_CONT_TIPE"])
							->setCellValue('E' . $rec, $row["UKR_CONT"])
							->setCellValue('F' . $rec, $row["STATUS_CONT"])
							->setCellValue('G' . $rec, $row["IMO"])
							->setCellValue('H' . $rec, $row["NM_ANGKUT"])
							->setCellValue('I' . $rec, $row["NO_VOY"])
							->setCellValue('J' . $rec, $row["STACKING"])
							->setCellValue('K' . $rec, $row["W_PICKUP"])
							->setCellValue('L' . $rec, $row["GATEIN_TERMINAL"])
							->setCellValue('M' . $rec, $row["GATEOUT_TERMINAL"])
							->setCellValue('N' . $rec, $row["W_BEHANDLE"])
							->setCellValue('O' . $rec, $row["WK_REQ"])
							->setCellValue('P' . $rec, $row["NAMA"])
							->setCellValue('Q' . $rec, $row["NO_DOK"])
							->setCellValue('R' . $rec, $row["TGL_DOK"])
							->setCellValue('S' . $rec, $row["TID"])
							->setCellValue('T' . $rec, $row["LOKASI"])
							->setCellValue('U' . $rec, $row["CONSIGNEE"])
							->setCellValue('V' . $rec, $row["STATUS"])
							->setCellValue('W' . $rec, $row["PLUG_TERMINAL"])
							->setCellValue('X' . $rec, $row["UNPLUG_TERMINAL"])
							->setCellValue('Y' . $rec, $row["WAKTU"])
							->setCellValue('Z' . $rec, $row["PLUG_END_DATE"])
							->setCellValue('AA' . $rec, $row["DG"]);

						$this->newphpexcel->set_detilstyle(array('A' . $rec, 'B' . $rec, 'C' . $rec, 'D' . $rec, 'E' . $rec, 'F' . $rec, 'G' . $rec, 'H' . $rec, 'I' . $rec, 'J' . $rec, 'K' . $rec, 'L' . $rec, 'M' . $rec, 'N' . $rec, 'O' . $rec, 'P' . $rec, 'Q' . $rec, 'R' . $rec, 'S' . $rec, 'T' . $rec, 'U' . $rec, 'V' . $rec, 'W' . $rec, 'X' . $rec, 'Y' . $rec, 'Z' . $rec, 'AA' . $rec));
						$rec++;
						$no++;
					}
				} else {
					$this->newphpexcel->getActiveSheet()->mergeCells('A4:U4');
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A5', 'DATA TIDAK DITEMUKAN');
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
			} else if ($act == "terbit_gatepass") {
				$STATUS = $this->input->post('form[0]');
				$TANGGAL = $this->input->post('form[1]');

				$TGL_AWAL = $TANGGAL[0];
				$TGL_AKHIR = $TANGGAL[1];
				$STATUS_GATEPASS = $STATUS[0];

				$addsql = "";

				if ($STATUS_GATEPASS != "") {
					$addsql .= " AND C.ID IS $STATUS_GATEPASS";
				}

				if ($TGL_AWAL != "" && $TGL_AKHIR != "") {
					$addsql .= " AND A.WK_REQ BETWEEN '$TGL_AWAL' AND '$TGL_AKHIR' ";
				} else if ($TGL_AWAL != "") {
					$addsql .= " AND A.WK_REQ >= '$TGL_AWAL'";
				} else if ($TGL_AKHIR != "") {
					$addsql .= " AND A.WK_REQ <= '$TGL_AKHIR'";
				}

				$SQL = "SELECT A.NO_SPK AS 'NO_SPK', B.NO_CONT AS 'NO_CONT', B.UKR_CONT AS 'UKR_CONT', CASE WHEN D.STATUS_CONT = 'F' THEN 'FULL' ELSE 'EMPTY' END AS 'STATUS_CONT', G.IMO, E.NM_ANGKUT, E.NO_VOY_FLIGHT AS 'NO_VOY', D.STACKING, I.W_PICKUP, 'NO DATA' AS GATEIN_TERMINAL, 'NO DATA' AS GATEOUT_TERMINAL, I.W_BEHANDLE, A.WK_REQ AS 'WK_REQ', F.NAMA, A.NO_DOK, A.TGL_DOK, B.ID_FLAT AS 'TID', CONCAT((B.LOKASI),'0',(B.TIER)) AS 'LOKASI', CASE WHEN C.ID IS NOT NULL THEN 'TERBIT GATEPASS' ELSE 'BELUM TERBIT GATEPASS' END AS 'KETERANGAN', A.CONSIGNEE AS 'CUSTOMER'
					FROM t_spk A
					INNER JOIN t_spk_cont B ON A.ID = B.ID
					LEFT JOIN t_gatepass C ON A.NO_DOK = C.NO_DOK AND B.NO_CONT = C.NO_CONT AND C.JNS_KEGIATAN = 1
					LEFT JOIN (SELECT ID, NO_CONT, JNS_CONT AS 'STATUS_CONT', ISO_CODE, KD_CONT_TIPE AS 'TIPE_CONT', WK_IN AS 'STACKING' FROM t_cocostscont GROUP BY NO_CONT ORDER BY ID DESC) D ON B.NO_CONT = D.NO_CONT
					LEFT JOIN t_cocostshdr E ON D.ID = E.ID
					LEFT JOIN reff_kode_dok_bc F ON A.JNS_DOK = F.ID
					LEFT JOIN (SELECT ID, NO_CONT, IMO FROM t_request_cont GROUP BY NO_CONT ORDER BY ID DESC) G ON B.NO_CONT = G.NO_CONT
					LEFT JOIN t_request H ON F.ID = H.ID
					LEFT JOIN (SELECT A.NO_SPK, B.NO_CONT, A.W_PICKUP, W_BEHANDLE, B.KONDISI_CONT, B.NO_SEAL, B.ROOM FROM t_op_pickup A INNER JOIN t_op_behandlein B ON A.NO_SPK = B.NO_SPK) I ON A.NO_SPK = I.NO_SPK AND B.NO_CONT = I.NO_CONT
					WHERE B.LOKASI LIKE '1B%' AND B.STATUS_CONT IN (450)" . $addsql;
				// echo $SQL;die();

				$result = $func->main->get_result($SQL);
				$this->load->library('newphpexcel');
				$this->newphpexcel->getDefaultStyle()->getFont()->setName('Calibri')->setSize(10);
				$objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
				$objDrawing->setName('Logo');
				$objDrawing->setDescription('Logo');
				$logo = imagecreatefrompng('assets/images/Logomti.png');
				$objDrawing->setImageResource($logo);
				$objDrawing->setCoordinates('A1');
				$objDrawing->setHeight(100);
				$objDrawing->setWidth(100);
				$objDrawing->setWorksheet($this->newphpexcel->getActiveSheet());
				$this->newphpexcel->setActiveSheetIndex(0);
				$styleArray = array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
				$this->newphpexcel->getDefaultStyle()->applyFromArray($styleArray);
				$this->newphpexcel->set_bold(array('A1'));
				$this->newphpexcel->mergecell(array(array('A1', 'U1'), array('A2', 'U2'), array('A3', 'U3')), FALSE);
				$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A1', 'REPORT GATEPASS TERBIT');
				$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A2', 'COMMON GATE PT. MTI');
				$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A3', date("M Y"));
				$this->newphpexcel->width(array(array('A', 5), array('B', 20), array('C', 20), array('D', 8), array('E', 10), array('F', 20), array('G', 30), array('H', 15), array('I', 45), array('J', 25), array('K', 25), array('L', 25), array('M', 25), array('N', 25), array('O', 25), array('P', 25), array('Q', 25), array('R', 25), array('S', 25), array('T', 25), array('U', 25)));
				$this->newphpexcel->setActiveSheetIndex(0)
					->setCellValue('A5', 'NO')
					->setCellValue('B5', 'NO SPK')
					->setCellValue('C5', 'NO KONTAINER')
					->setCellValue('D5', 'SIZE')
					->setCellValue('E5', 'STATUS')
					->setCellValue('F5', 'IMO')
					->setCellValue('G5', 'NAMA KAPAL')
					->setCellValue('H5', 'VOYAGE')
					->setCellValue('I5', 'STACKING')
					->setCellValue('J5', 'PICKUP')
					->setCellValue('K5', 'GATE IN TERMINAL')
					->setCellValue('L5', 'GATE OUT TERMINAL')
					->setCellValue('M5', 'BEHANDLE IN')
					->setCellValue('N5', 'TERBIT SPK')
					->setCellValue('O5', 'JENIS DOKUMEN')
					->setCellValue('P5', 'NO DOKUMEN')
					->setCellValue('Q5', 'TANGGAL DOKUMEN')
					->setCellValue('R5', 'TID')
					->setCellValue('S5', 'LOKASI')
					->setCellValue('T5', 'CUSTOMER')
					->setCellValue('U5', 'STATUS KONTAINER');
				$this->newphpexcel->headings(array('A5', 'B5', 'C5', 'D5', 'E5', 'F5', 'G5', 'H5', 'I5', 'J5', 'K5', 'L5', 'M5', 'N5', 'O5', 'P5', 'Q5', 'R5', 'S5', 'T5', 'U5'));
				$this->newphpexcel->set_wrap(array('B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U'));
				$no = 1;
				$rec = 6;
				if ($result) {
					foreach ($SQL->result_array() as $row) {
						$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A' . $rec, $no)
							->setCellValue('B' . $rec, $row["NO_SPK"])
							->setCellValue('C' . $rec, $row["NO_CONT"])
							->setCellValue('D' . $rec, $row["UKR_CONT"])
							->setCellValue('E' . $rec, $row["STATUS_CONT"])
							->setCellValue('F' . $rec, $row["IMO"])
							->setCellValue('G' . $rec, $row["NM_ANGKUT"])
							->setCellValue('H' . $rec, $row["NO_VOY"])
							->setCellValue('I' . $rec, $row["STACKING"])
							->setCellValue('J' . $rec, $row["W_PICKUP"])
							->setCellValue('K' . $rec, $row["GATEIN_TERMINAL"])
							->setCellValue('L' . $rec, $row["GATEOUT_TERMINAL"])
							->setCellValue('M' . $rec, $row["W_BEHANDLE"])
							->setCellValue('N' . $rec, $row["WK_REQ"])
							->setCellValue('O' . $rec, $row["NAMA"])
							->setCellValue('P' . $rec, $row["NO_DOK"])
							->setCellValue('Q' . $rec, $row["TGL_DOK"])
							->setCellValue('R' . $rec, $row["TID"])
							->setCellValue('S' . $rec, $row["LOKASI"])
							->setCellValue('T' . $rec, $row["CUSTOMER"])
							->setCellValue('U' . $rec, $row["KETERANGAN"]);
						$this->newphpexcel->set_detilstyle(array('A' . $rec, 'B' . $rec, 'C' . $rec, 'D' . $rec, 'E' . $rec, 'F' . $rec, 'G' . $rec, 'H' . $rec, 'I' . $rec, 'J' . $rec, 'K' . $rec, 'L' . $rec, 'M' . $rec, 'N' . $rec, 'O' . $rec, 'P' . $rec, 'Q' . $rec, 'R' . $rec, 'S' . $rec, 'T' . $rec, 'U' . $rec));
						$rec++;
						$no++;
					}
				} else {
					$this->newphpexcel->getActiveSheet()->mergeCells('A4:U4');
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A5', 'DATA TIDAK DITEMUKAN');
					$this->newphpexcel->set_detilstyle(array('A5'));
				}
				ob_clean();

				$file = "GATEPASS_TERBIT_" . date("Ymd") . ".xls";
				header("Content-type: application/x-msdownload");
				header("Content-Disposition: attachment;filename=$file");
				header("Cache-Control: max-age=0");
				header("Pragma: no-cache");
				header("Expires: 0");
				$objWriter = PHPExcel_IOFactory::createWriter($this->newphpexcel, 'Excel5');
				$objWriter->save('php://output');
				exit();
			} else if ($act == "bilextention2") {
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

				if ($tgl_nota_start != "" and $tgl_nota_end != "") {
					$addsql .= " AND DATE(A.TGL_NOTA) BETWEEN '$tgl_nota_start' AND '$tgl_nota_end'";
				} else if ($tgl_nota_start != "") {
					$addsql .= " AND DATE(A.TGL_NOTA) >= '$tgl_nota_start'";
				} else if ($tgl_nota_end != "") {
					$addsql .= " AND DATE(A.TGL_NOTA) <= '$tgl_nota_end'";
				} else {
					#$addsql .= " AND MONTH(A.TGL_TIBA) = MONTH(NOW()) AND YEAR(A.TGL_TIBA) = YEAR(NOW())";
				}

				if ($tgl_req_start != "" and $tgl_req_end != "") {
					$addsql .= " AND DATE(A.TGL_REQ) BETWEEN '$tgl_req_start' AND '$tgl_req_end'";
				} else if ($tgl_req_start != "") {
					$addsql .= " AND DATE(A.TGL_REQ) => '$tgl_req_start'";
				} else if ($tgl_req_end != "") {
					$addsql .= " AND DATE(A.TGL_REQ) <= '$tgl_req_end'";
				}

				if ($no_cust != "") {
					$addsql .= " AND B.NAMA_CUST = '$no_cust'";
				}
				$SQL = "SELECT A.ID_REQ, A.NO_NOTA_DELIVERY, A.TGL_NOTA,'BEHANDLE' AS JNS_NOTA, A.SUBTOTAL ,A.PPN ,A.BIAYA_MATERAI ,
						A.TOTAL, C.NAMA_CUST,A.NPWP, B.NO_CONT
						FROM req_delivery_hdr A
						LEFT JOIN (SELECT ID_REQ, GROUP_CONCAT(NO_CONT,'[',UKR_CONT,']' SEPARATOR '\r') AS NO_CONT
					FROM req_delivery_dtl GROUP BY ID_REQ) B ON B.ID_REQ=A.ID_REQ
						INNER JOIN m_pelanggan C ON A.NPWP=C.NPWP
						WHERE 1=1 AND ID_REQ_OLD IS NOT NULL AND A.NO_NOTA_DELIVERY = '' OR A.NO_NOTA_DELIVERY IS NULL" . $addsql; #echo $SQL; die();
				$result = $func->main->get_result($SQL);
				$this->load->library('newphpexcel');
				$this->newphpexcel->getDefaultStyle()->getFont()->setName('Calibri')->setSize(10);
				$this->newphpexcel->setActiveSheetIndex(0);
				$styleArray = array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
				$this->newphpexcel->getDefaultStyle()->applyFromArray($styleArray);
				$this->newphpexcel->set_bold(array('A1'));
				$this->newphpexcel->mergecell(array(array('A1', 'M1')), FALSE);
				$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A1', 'REPORT BILLING EXTENTION');
				$this->newphpexcel->width(array(array('A', 5), array('B', 25), array('C', 25), array('D', 25), array('E', 20), array('F', 15), array('G', 15), array('H', 10), array('I', 15), array('J', 25), array('K', 25), array('L', 25)));
				$this->newphpexcel->setActiveSheetIndex(0)
					->setCellValue('A3', 'NO')
					->setCellValue('B3', 'NO REQUEST')
					->setCellValue('C3', 'NO NOTA')
					->setCellValue('D3', 'TGL NOTA')
					->setCellValue('E3', 'JENIS NOTA')
					->setCellValue('F3', 'NILAI TAGIHAN')
					->setCellValue('G3', 'NILAI PPN')
					->setCellValue('H3', 'NILAI MATERAI')
					->setCellValue('I3', 'NILAI NOTA')
					->setCellValue('J3', 'CUSTOMER')
					->setCellValue('K3', 'NPWP')
					->setCellValue('L3', 'NOMOR CONTAINER');
				$this->newphpexcel->headings(array('A3', 'B3', 'C3', 'D3', 'E3', 'F3', 'G3', 'H3', 'I3', 'J3', 'K3', 'L3'));
				$this->newphpexcel->set_wrap(array('B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L'));
				$no = 1;
				$rec = 4;
				if ($result) {
					foreach ($SQL->result_array() as $row) {
						$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A' . $rec, $no)
							->setCellValueExplicit('B' . $rec, $row["ID_REQ"], PHPExcel_Cell_DataType::TYPE_STRING)
							->setCellValueExplicit('C' . $rec, $row["NO_NOTA_DELIVERY"], PHPExcel_Cell_DataType::TYPE_STRING)
							->setCellValueExplicit('D' . $rec, $row["TGL_NOTA"], PHPExcel_Cell_DataType::TYPE_STRING)
							->setCellValue('E' . $rec, $row["JNS_NOTA"])
							->setCellValueExplicit('F' . $rec, $row["SUBTOTAL"], PHPExcel_Cell_DataType::TYPE_STRING)
							->setCellValue('G' . $rec, $row["PPN"])
							->setCellValueExplicit('H' . $rec, $row["BIAYA_MATERAI"], PHPExcel_Cell_DataType::TYPE_STRING)
							->setCellValue('I' . $rec, $row["TOTAL"])
							->setCellValue('J' . $rec, $row["NAMA_CUST"])
							->setCellValue('K' . $rec, $row["NPWP"])
							->setCellValue('L' . $rec, $row["NO_CONT"]);
						$this->newphpexcel->set_detilstyle(array('A' . $rec, 'B' . $rec, 'C' . $rec, 'D' . $rec, 'E' . $rec, 'F' . $rec, 'G' . $rec, 'H' . $rec, 'I' . $rec, 'J' . $rec, 'K' . $rec, 'L' . $rec));
						$rec++;
						$no++;
					}
				} else {
					$this->newphpexcel->getActiveSheet()->mergeCells('A4:L4');
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A5', 'DATA TIDAK DITEMUKAN');
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
			} else if ($act == "pemeriksaan") {
				// echo "string";
				$no_kon = $this->input->post('form[0]');
				$tgl_nota = $this->input->post('form[1]');
				$tgl_nota_start = $tgl_nota[0];
				$tgl_nota_end = $tgl_nota[1];
				$no_kon1 = $no_kon[0];
				$addsql = "";

				// echo "NO CONT : ".$no_kon1;
				// echo "TGL NOTA : ".$tgl_nota;
				// echo "TGL NOTA START : ".$tgl_nota_start;
				// echo "TGL NOTA END : ".$tgl_nota_end;
				// die();

				if ($tgl_nota_start != "" and $tgl_nota_end != "") {
					$addsql .= " AND D.START_INSP BETWEEN '$tgl_nota_start' AND '$tgl_nota_end'";
				} else if ($tgl_nota_start != "") {
					$addsql .= " AND D.START_INSP >= '$tgl_nota_start'";
				} else if ($tgl_nota_end != "") {
					$addsql .= " AND D.START_INSP <= '$tgl_nota_end'";
				} else if ($no_kon1 != "") {
					$addsql .= " AND B.NO_CONT = '$no_kon1'";
				} else {
					$addsql .= " GROUP BY B.NO_CONT ORDER BY C.WK_ACTIVE";
				}

				if ($this->session->userdata('KD_GROUP') == "BC") {
					$SQL = "SELECT A.NO_SPK AS 'NO_SPK', B.NO_CONT AS 'NO_CONT', B.UKR_CONT AS 'SIZE', A.NO_DOK AS 'NO_DOK', E.NAMA AS 'JNS_DOK', A.TGL_DOK AS 'TGL ANTRIAN', 
							C.WK_RESPON AS 'TGL PKB', C.RESPON AS 'RESPON', C.WK_ACTIVE AS 'TGL SIAP PERIKSA', D.START_INSP AS 'TGL START PERIKSA', D.FINISH_INSP AS 'TGL SELESAI PERIKSA', 
							D.NO_SEAL AS 'NO SEAL', A.CONSIGNEE AS 'CUSTOMERS'
							FROM t_spk A
							LEFT JOIN t_spk_cont B ON B.ID = A.ID
							LEFT JOIN t_gatepass C ON C.NO_CONT = B.NO_CONT AND C.NO_DOK = A.NO_DOK
							LEFT JOIN t_op_inspection D ON D.NO_CONT = B.NO_CONT AND D.NO_CONT = C.NO_CONT
							LEFT JOIN reff_kode_dok_bc E ON E.ID = A.JNS_DOK
							WHERE C.FL_ACTIVE = 'Y' AND E.ID != 83 AND C.RESPON IS NOT NULL AND D.START_INSP IS NOT NULL AND D.FINISH_INSP IS NOT NULL" . $addsql;
				} else {
					$SQL = "SELECT A.NO_SPK AS 'NO_SPK', B.NO_CONT AS 'NO_CONT', B.UKR_CONT AS 'SIZE', A.NO_DOK AS 'NO_DOK', E.NAMA AS 'JNS_DOK', A.TGL_DOK AS 'TGL ANTRIAN', 
							C.WK_RESPON AS 'TGL PKB', C.RESPON AS 'RESPON', C.WK_ACTIVE AS 'TGL SIAP PERIKSA', D.START_INSP AS 'TGL START PERIKSA', D.FINISH_INSP AS 'TGL SELESAI PERIKSA', 
							D.NO_SEAL AS 'NO SEAL', A.CONSIGNEE AS 'CUSTOMERS'
							FROM t_spk A
							LEFT JOIN t_spk_cont B ON B.ID = A.ID
							LEFT JOIN t_gatepass C ON C.NO_CONT = B.NO_CONT AND C.NO_DOK = A.NO_DOK
							LEFT JOIN t_op_inspection D ON D.NO_CONT = B.NO_CONT AND D.NO_CONT = C.NO_CONT
							LEFT JOIN reff_kode_dok_bc E ON E.ID = A.JNS_DOK
							WHERE C.FL_ACTIVE = 'Y' AND D.START_INSP IS NOT NULL AND D.FINISH_INSP IS NOT NULL " . $addsql;
				}

				$result = $func->main->get_result($SQL);
				$this->load->library('newphpexcel');
				$this->newphpexcel->getDefaultStyle()->getFont()->setName('Calibri')->setSize(10);
				$objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
				$objDrawing->setName('Logo');
				$objDrawing->setDescription('Logo');
				$logo = imagecreatefrompng('assets/images/Logomti.png');
				$objDrawing->setImageResource($logo);
				$objDrawing->setCoordinates('A1');
				$objDrawing->setHeight(100);
				$objDrawing->setWidth(100);
				$objDrawing->setWorksheet($this->newphpexcel->getActiveSheet());
				$this->newphpexcel->setActiveSheetIndex(0);
				$styleArray = array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
				$this->newphpexcel->getDefaultStyle()->applyFromArray($styleArray);
				$this->newphpexcel->set_bold(array('A1'));
				$this->newphpexcel->mergecell(array(array('A1', 'N1'), array('A2', 'N2'), array('A3', 'N3')), FALSE);
				$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A1', 'REPORT PEMERIKSAAN');
				$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A2', 'COMMON GATE PT. MTI');
				$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A3', date("M Y"));
				$this->newphpexcel->width(array(array('A', 5), array('B', 20), array('C', 20), array('D', 5), array('E', 20), array('F', 25), array('G', 20), array('H', 25), array('I', 20), array('J', 25), array('K', 25), array('L', 25), array('M', 25), array('N', 35)));

				$this->newphpexcel->setActiveSheetIndex(0)
					->setCellValue('A5', 'NO')
					->setCellValue('B5', 'NO SPK')
					->setCellValue('C5', 'NO KONTAINER')
					->setCellValue('D5', 'SIZE')
					->setCellValue('E5', 'JENIS DOKUMEN')
					->setCellValue('F5', 'NO DOKUMEN')
					->setCellValue('G5', 'TANGGAL ANTRIAN')
					->setCellValue('H5', 'TANGGAL PPK')
					->setCellValue('I5', 'RESPON PPK')
					->setCellValue('J5', 'TANGGAL SIAP PERIKSA')
					->setCellValue('K5', 'TANGGAL START PERIKSA')
					->setCellValue('L5', 'TANGGAL SELESAI PERIKSA')
					->setCellValue('M5', 'NO SEAL')
					->setCellValue('N5', 'NAMA CUSTOMER');

				$this->newphpexcel->headings(array('A5', 'B5', 'C5', 'D5', 'E5', 'F5', 'G5', 'H5', 'I5', 'J5', 'K5', 'L5', 'M5', 'N5'));
				$this->newphpexcel->set_wrap(array('B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N'));
				$no = 1;
				$rec = 6;
				if ($result) {
					foreach ($SQL->result_array() as $row) {
						$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A' . $rec, $no)
							->setCellValueExplicit('B' . $rec, $row["NO_SPK"], PHPExcel_Cell_DataType::TYPE_STRING)
							->setCellValueExplicit('C' . $rec, $row["NO_CONT"], PHPExcel_Cell_DataType::TYPE_STRING)
							->setCellValueExplicit('D' . $rec, $row["SIZE"])
							->setCellValueExplicit('E' . $rec, $row["JNS_DOK"])
							->setCellValueExplicit('F' . $rec, $row["NO_DOK"], PHPExcel_Cell_DataType::TYPE_STRING)
							->setCellValueExplicit('G' . $rec, $row["TGL ANTRIAN"], PHPExcel_Cell_DataType::TYPE_STRING)
							->setCellValueExplicit('H' . $rec, $row["TGL PKB"], PHPExcel_Cell_DataType::TYPE_STRING)
							->setCellValueExplicit('I' . $rec, $row["RESPON"], PHPExcel_Cell_DataType::TYPE_STRING)
							->setCellValueExplicit('J' . $rec, $row["TGL SIAP PERIKSA"], PHPExcel_Cell_DataType::TYPE_STRING)
							->setCellValueExplicit('K' . $rec, $row["TGL START PERIKSA"], PHPExcel_Cell_DataType::TYPE_STRING)
							->setCellValueExplicit('L' . $rec, $row["TGL SELESAI PERIKSA"], PHPExcel_Cell_DataType::TYPE_STRING)
							->setCellValue('M' . $rec, $row["NO SEAL"])
							->setCellValueExplicit('N' . $rec, $row["CUSTOMERS"], PHPExcel_Cell_DataType::TYPE_STRING);

						$this->newphpexcel->set_detilstyle(array('A' . $rec, 'B' . $rec, 'C' . $rec, 'D' . $rec, 'E' . $rec, 'F' . $rec, 'G' . $rec, 'H' . $rec, 'I' . $rec, 'J' . $rec, 'K' . $rec, 'L' . $rec, 'M' . $rec, 'N' . $rec));
						$rec++;
						$no++;
					}
				} else {
					$this->newphpexcel->getActiveSheet()->mergeCells('A6:N6');
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A6', 'DATA TIDAK DITEMUKAN');
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
			} else if ($act == "delivery") {
				$NO_CONT = $this->input->post('form[0]');
				$TGL = $this->input->post('form[1]');
				$TGL_START = $TGL[0];
				$TGL_END = $TGL[1];

				if ($NO_CONT[0] != "" && $TGL_START != "" && $TGL_END != "") {
					$addsql .= " AND B.NO_CONT='$NO_CONT[0]' AND E.WK_TRUCKIN BETWEEN '$TGL_START' AND '$TGL_END' ORDER BY E.WK_TRUCKIN DESC";
				} else if ($TGL_START != "" && $TGL_END != "") {
					$addsql .= " AND E.WK_TRUCKIN BETWEEN '$TGL_START' AND '$TGL_END' ORDER BY E.WK_TRUCKIN DESC";
				} elseif ($TGL_START != "") {
					$addsql .= " AND E.WK_TRUCKIN >= '$TGL_START' ORDER BY E.WK_TRUCKIN DESC";
				} elseif ($TGL_END != "") {
					$addsql .= " AND E.WK_TRUCKIN <= '$TGL_END' ORDER BY E.WK_TRUCKIN DESC";
				} elseif ($NO_CONT[0] != "") {
					$addsql .= " AND B.NO_CONT='$NO_CONT[0]' ORDER BY E.WK_TRUCKIN DESC";
				} else {
					$addsql .= "";
				}

				$tgl_awal = date("d/m/Y H:i", strtotime($TGL_START));
				$tgl_akhir = date("d/m/Y H:i", strtotime($TGL_END));

				$SQL = "SELECT distinct A.NO_SPK, B.NO_CONT, B.UKR_CONT AS 'SIZE',CASE WHEN H.KD_CONT_JENIS = 'E' THEN 'EMPTY' when H.KD_CONT_JENIS = 'F' THEN 'FULL'  ELSE '' END AS CONT_STATUS ,case when H.FL_REEFER = 'Y' then 'REEFER' when H.FL_OOG = 'Y' then 'OOG' else 'DRY' END AS TIPECONT, D.NAMA AS JNS_DOK, E.WK_TRUCKIN, E.NO_TRUCK AS TID, E.WK_CHASSIS, E.NO_SEAL, F.KONDISI, E.WK_INSPECT, E.WK_GATEOUT, A.CONSIGNEE, G.KETERANGAN
				FROM t_spk A
				LEFT JOIN t_spk_cont B ON A.ID = B.ID
				LEFT JOIN t_request C ON C.NO_DOK = A.NO_DOK AND C.TGL_DOK = A.TGL_DOK
				LEFT JOIN t_request_cont H ON H.ID = C.ID AND B.NO_CONT = H.NO_CONT AND H.KD_STATUS = 'INQUIRY'
				LEFT JOIN reff_kode_dok_bc D ON A.JNS_DOK = D.ID
				LEFT JOIN t_op_delivery E ON A.NO_SPK = E.NO_SPK AND B.NO_CONT = E.NO_CONT
				LEFT JOIN reff_kondisi F ON E.KONDISI_CONT = F.ID
				LEFT JOIN reff_status_spk G ON B.STATUS_CONT = G.ID
				WHERE B.STATUS_CONT = '900' AND A.TGL_SPK > DATE_ADD(NOW() , INTERVAL -4 MONTH) " . $addsql;

				$result = $func->main->get_result($SQL);
				$this->load->library('newphpexcel');
				$this->newphpexcel->getDefaultStyle()->getFont()->setName('Calibri')->setSize(10);
				$objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
				$objDrawing->setName('Logo');
				$objDrawing->setDescription('Logo');
				$logo = imagecreatefrompng('assets/images/Logomti.png');
				$objDrawing->setImageResource($logo);
				$objDrawing->setCoordinates('A1');
				$objDrawing->setHeight(100);
				$objDrawing->setWidth(100);
				$objDrawing->setWorksheet($this->newphpexcel->getActiveSheet());
				$this->newphpexcel->setActiveSheetIndex(0);
				$styleArray = array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
				$this->newphpexcel->getDefaultStyle()->applyFromArray($styleArray);
				$this->newphpexcel->set_bold(array('A1'));
				$this->newphpexcel->mergecell(array(array('A1', 'O1'), array('A2', 'O2'), array('A3', 'O3'), array('AB1', 'AB3'), array('AC1', 'AC3'), array('AD1', 'AI1'), array('AD2', 'AE2'), array('AF2', 'AG2'), array('AH2', 'AI2'), array('AJ1', 'AJ3'), array('AK1', 'AK3'), array('AB7', 'AC7')), FALSE);
				$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A1', 'REPORT DELIVERY EX-BEHANDLE');
				$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A2', 'COMMON GATE PT. MTI');
				$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A3', $tgl_awal . ' - ' . $tgl_akhir);
				$this->newphpexcel->width(array(array('A', 5), array('B', 20), array('C', 20), array('D', 8), array('E', 10), array('F', 20), array('G', 30), array('H', 15), array('I', 20), array('J', 25), array('K', 45), array('L', 30), array('M', 30), array('N', 30), array('O', 20)));
				$this->newphpexcel->setActiveSheetIndex(0)
					->setCellValue('A5', 'NO')
					->setCellValue('B5', 'NO SPK')
					->setCellValue('C5', 'NO KONTAINER')
					->setCellValue('D5', 'SIZE')
					->setCellValue('E5', 'STATUS')
					->setCellValue('F5', 'JENIS DOKUMEN')
					->setCellValue('G5', 'TRUCK IN + CETAK CMS')
					->setCellValue('H5', 'TID')
					->setCellValue('I5', 'ON CHASSIS')
					->setCellValue('J5', 'NO SEAL')
					->setCellValue('K5', 'KONDISI KONTAINER')
					->setCellValue('L5', 'INSPECTION OUT')
					->setCellValue('M5', 'TRUCK OUT + CETAK EIR')
					->setCellValue('N5', 'NAMA CUSTOMER')
					->setCellValue('O5', 'KETERANGAN')
					->setCellValue('P5', 'JENIS')
					->setCellValue('AB1', 'No')
					->setCellValue('AC1', 'Dokumen')
					->setCellValue('AD1', 'UKURAN')
					->setCellValue('AJ1', 'TOTAL')
					->setCellValue('AK1', 'TEUS')
					->setCellValue('AB7', 'GATEPASS TERBIT')
					->setCellValue('AD2', '20')
					->setCellValue('AF2', '40')
					->setCellValue('AH2', '45')
					->setCellValue('AD3', 'FL')
					->setCellValue('AE3', 'MT')
					->setCellValue('AF3', 'FL')
					->setCellValue('AG3', 'MT')
					->setCellValue('AH3', 'FL')
					->setCellValue('AI3', 'MT')
					->setCellValue('AJ3', 'FL')
					->setCellValue('AK3', 'MT');
				$this->newphpexcel->headings(array('A5', 'B5', 'C5', 'D5', 'E5', 'F5', 'G5', 'H5', 'I5', 'J5', 'K5', 'L5', 'M5', 'N5', 'O5', 'P5', 'AB1', 'AB2', 'AB3', 'AC1', 'AC2', 'AC3', 'AD1', 'AJ1', 'AJ2', 'AJ3', 'AK1', 'AK2', 'AK3', 'AB7', 'AD2', 'AE2', 'AF2', 'AG2', 'AH2', 'AI2', 'AD3', 'AE3', 'AF3', 'AG3', 'AH3', 'AI3', 'AD7', 'AE7', 'AF7', 'AG7', 'AH7', 'AI7', 'AJ7', 'AK7'));
				$this->newphpexcel->set_wrap(array('B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K'));
				$no = 1;
				$rec = 6;
				if ($result) {
					foreach ($SQL->result_array() as $row) {
						$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A' . $rec, $no)
							->setCellValueExplicit('B' . $rec, $row["NO_SPK"], PHPExcel_Cell_DataType::TYPE_STRING)
							->setCellValueExplicit('C' . $rec, $row["NO_CONT"], PHPExcel_Cell_DataType::TYPE_STRING)
							->setCellValueExplicit('D' . $rec, $row["SIZE"], PHPExcel_Cell_DataType::TYPE_STRING)
							->setCellValueExplicit('E' . $rec, $row["CONT_STATUS"], PHPExcel_Cell_DataType::TYPE_STRING)
							->setCellValue('F' . $rec, $row["JNS_DOK"])
							->setCellValue('G' . $rec, $row["WK_TRUCKIN"])
							->setCellValue('H' . $rec, $row["TID"])
							->setCellValue('I' . $rec, $row["WK_CHASSIS"])
							->setCellValue('J' . $rec, $row["NO_SEAL"])
							->setCellValue('K' . $rec, $row["KONDISI"])
							->setCellValue('L' . $rec, $row["WK_INSPECT"])
							->setCellValue('M' . $rec, $row["WK_GATEOUT"])
							->setCellValue('N' . $rec, $row["CONSIGNEE"])
							->setCellValue('O' . $rec, $row["KETERANGAN"])
							->setCellValue('P' . $rec, $row["TIPECONT"]);
						$this->newphpexcel->set_detilstyle(array('A' . $rec, 'B' . $rec, 'C' . $rec, 'D' . $rec, 'E' . $rec, 'F' . $rec, 'G' . $rec, 'H' . $rec, 'I' . $rec, 'J' . $rec, 'K' . $rec, 'L' . $rec, 'M' . $rec, 'N' . $rec, 'O' . $rec, 'P' . $rec));
						$rec++;
						$no++;
					}
				} else {
					$this->newphpexcel->getActiveSheet()->mergeCells('A4:O4');
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A5', 'DATA TIDAK DITEMUKAN');
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
			} else if ($act == "marshalling") {
				$TGL = $this->input->post('form[0]');
				$JENIS_JOB = $this->input->post('form[1]');
				$TGL_START = $TGL[0];
				$TGL_END = $TGL[1];

				$addsql = " ";

				if ($NO_CONT[0] != "" && $TGL_START != "" && $TGL_END != "" && $JENIS_JOB[0] != "") {
					$addsql .= " AND B.NO_CONT='$NO_CONT[0]' AND F.JENIS='$JENIS_JOB[0]' AND F.WK_STATUS BETWEEN '$TGL_START' AND '$TGL_END' ORDER BY F.WK_STATUS DESC";
				} else if ($TGL_START != "" && $TGL_END != "" && $JENIS_JOB[0] != "") {
					$addsql .= " AND F.JENIS='$JENIS_JOB[0]' AND F.WK_STATUS BETWEEN '$TGL_START' AND '$TGL_END' ORDER BY F.WK_STATUS DESC";
				} else if ($TGL_START != "" && $TGL_END != "") {
					$addsql .= " AND F.WK_STATUS BETWEEN '$TGL_START' AND '$TGL_END' ORDER BY F.WK_STATUS DESC";
				} elseif ($TGL_START != "") {
					$addsql .= " AND F.WK_STATUS >= '$TGL_START' ORDER BY F.WK_STATUS DESC";
				} elseif ($TGL_END != "") {
					$addsql .= " AND F.WK_STATUS <= '$TGL_END' ORDER BY F.WK_STATUS DESC";
				}

				$SQL = "SELECT 
								A.NO_SPK,
								B.NO_CONT,
								B.UKR_CONT,
								CASE WHEN EE.JNS_CONT = 'F' THEN 'FULL' ELSE 'EMPTY' END AS CONT_STATUS,
								AA.NAMA AS JNS_DOK,
								F.WK_STATUS,
								CONCAT(F.LOKASI_AKHIR,'0',F.TIER_AKHIR) AS LOKASI,
								A.CONSIGNEE,
								F.JENIS AS KETERANGAN
							FROM t_spk A
							INNER JOIN t_spk_cont B ON A.ID = B.ID
							JOIN reff_kode_dok_bc AA ON A.JNS_DOK = AA.ID
							JOIN t_request C ON A.NO_DOK = C.NO_DOK AND A.TGL_DOK = C.TGL_DOK
							JOIN t_request_cont D ON C.ID = D.ID AND D.NO_CONT = B.NO_CONT
							LEFT JOIN t_cocostshdr E ON D.VESSEL = E.NM_ANGKUT AND D.VOY_IN = E.NO_VOY_FLIGHT
							LEFT JOIN t_cocostscont EE ON E.ID = EE.ID AND B.NO_CONT = EE.NO_CONT
							LEFT JOIN t_job_slip F ON F.NO_CONT = B.NO_CONT AND A.NO_SPK = F.NO_SPK
							WHERE F.KD_STATUS='50' 
							AND F.LOKASI_AWAL LIKE '%CIC%' 
							AND F.JENIS IN ('EX BEHANDLE 1','EX BEHANDLE 2')
							" . $addsql;
				
				$result = $func->main->get_result($SQL);

				$this->load->library('newphpexcel');
				$this->newphpexcel->getDefaultStyle()->getFont()->setName('Calibri')->setSize(10);

				$objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
				$objDrawing->setName('Logo');
				$objDrawing->setDescription('Logo');

				$logo = imagecreatefrompng('assets/images/Logomti.png');
				$objDrawing->setImageResource($logo);
				$objDrawing->setCoordinates('A1');
				$objDrawing->setHeight(100);
				$objDrawing->setWidth(100);
				$objDrawing->setWorksheet($this->newphpexcel->getActiveSheet());

				$this->newphpexcel->setActiveSheetIndex(0);

				$styleArray = array(
					'alignment' => array(
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
					)
				);

				$this->newphpexcel->getDefaultStyle()->applyFromArray($styleArray);

				$this->newphpexcel->set_bold(array('A1'));
				$this->newphpexcel->mergecell(
					array(
						array('A1', 'J1'),
						array('A2', 'J2'),
						array('A3', 'J3')
					),
					FALSE
				);

				$this->newphpexcel->setActiveSheetIndex(0)
					->setCellValue('A1', 'REPORT MARSHALLING EX-BEHANDLE')
					->setCellValue('A2', 'COMMON GATE PT. MTI')
					->setCellValue('A3', date("M Y"));

				$this->newphpexcel->width(array(
					array('A', 5),
					array('B', 20),
					array('C', 20),
					array('D', 8),
					array('E', 10),
					array('F', 20),
					array('G', 30),
					array('H', 15),
					array('I', 45),
					array('J', 25)
				));

				$this->newphpexcel->setActiveSheetIndex(0)
					->setCellValue('A5', 'NO')
					->setCellValue('B5', 'NO SPK')
					->setCellValue('C5', 'NO KONTAINER')
					->setCellValue('D5', 'SIZE')
					->setCellValue('E5', 'STATUS')
					->setCellValue('F5', 'JENIS DOKUMEN')
					->setCellValue('G5', 'MARSHALLING EX BEHANDLE')
					->setCellValue('H5', 'LOKASI')
					->setCellValue('I5', 'NAMA CUSTOMER')
					->setCellValue('J5', 'KETERANGAN');

				$this->newphpexcel->headings(
					array('A5', 'B5', 'C5', 'D5', 'E5', 'F5', 'G5', 'H5', 'I5', 'J5')
				);

				$this->newphpexcel->set_wrap(
					array('B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J')
				);

				$no = 1;
				$rec = 6;

				if ($result) {
					foreach ($SQL->result_array() as $row) {

						$this->newphpexcel->setActiveSheetIndex(0)
							->setCellValue('A' . $rec, $no)
							->setCellValueExplicit('B' . $rec, $row["NO_SPK"], PHPExcel_Cell_DataType::TYPE_STRING)
							->setCellValueExplicit('C' . $rec, $row["NO_CONT"], PHPExcel_Cell_DataType::TYPE_STRING)
							->setCellValueExplicit('D' . $rec, $row["UKR_CONT"], PHPExcel_Cell_DataType::TYPE_STRING)
							->setCellValueExplicit('E' . $rec, $row["CONT_STATUS"], PHPExcel_Cell_DataType::TYPE_STRING)
							->setCellValue('F' . $rec, $row["JNS_DOK"])
							->setCellValue('G' . $rec, $row["WK_STATUS"])
							->setCellValue('H' . $rec, $row["LOKASI"])
							->setCellValue('I' . $rec, $row["CONSIGNEE"])
							->setCellValue('J' . $rec, $row["KETERANGAN"]);

						$this->newphpexcel->set_detilstyle(
							array(
								'A' . $rec,
								'B' . $rec,
								'C' . $rec,
								'D' . $rec,
								'E' . $rec,
								'F' . $rec,
								'G' . $rec,
								'H' . $rec,
								'I' . $rec,
								'J' . $rec
							)
						);

						$rec++;
						$no++;
					}
				} else {

					$this->newphpexcel->getActiveSheet()->mergeCells('A5:J5');

					$this->newphpexcel->setActiveSheetIndex(0)
						->setCellValue('A5', 'DATA TIDAK DITEMUKAN');

					$this->newphpexcel->set_detilstyle(array('A5'));
				}

				if (ob_get_length()) {
					ob_clean();
				}

				$file = "MARSHALLING_" . date("Ymd") . ".xls";

				header("Content-Type: application/vnd.ms-excel");
				header("Content-Disposition: attachment; filename=\"$file\"");
				header("Cache-Control: max-age=0");
				header("Pragma: no-cache");
				header("Expires: 0");

				$objWriter = PHPExcel_IOFactory::createWriter($this->newphpexcel, 'Excel5');
				$objWriter->save('php://output');

				exit();
			} else if ($act == "monitoringbc") {
				// echo "Bisa tarik dokumen";
				$TGL = $this->input->post('form[0]');
				$TGL_START = $TGL[0];
				$TGL_END = $TGL[1];
				$addsql = " ";

				if ($TGL != "") {
					$addsql .= " AND A.TGL_DOK BETWEEN '$TGL_START' AND '$TGL_END' ORDER BY A.TGL_DOK ASC";
				} else {
					$addsql .= "";
				}

				$SQL = "SELECT DISTINCT B.NO_CONT AS 'NO_KONTAINER', B.WK_IN AS 'WAKTU_DISCHARGE', A.JNS_DOK AS 'JENIS_DOKUMEN', F.NO_DAFTAR_PABEAN AS 'NO_SPJM', F.TGL_DAFTAR_PABEAN AS 'WAKTU_SPJM', 
							H.WK_REQ AS 'TERBIT_SPK', C.WK_IN AS 'WAKTU_BEHANDLE_IN', D.WK_STATUS AS 'WAKTU_TIMBUN_CA', A.WK_REK AS 'WAKTU_REQ_KARTU_BEHANDLE', A.WK_ACTIVE AS 'AKTIF_KARTU_BEHANDLE', A.WK_RESPON AS 'RESPON_PKB',
							G.WK_STATUS AS 'SIAP_PERIKSA', C.WK_START AS 'MULAI_PERIKSA', C.WK_FINISH AS 'SELESAI_PERIKSA', E.WK_STATUS AS 'MARSHALLING_EX_BEHANDLE',
							B.NM_ANGKUT AS 'NM_KAPAL', B.NO_VOY_FLIGHT AS 'NO_VOY', K.ETA, I.NO_DOK AS 'NO_SPPB', I.TGL_DOK AS 'WAKTU_SPPB', J.WK_GATEOUT AS 'WAKTU_DELIVERY'
						FROM t_gatepass A
						INNER JOIN (SELECT A.ID, A.NM_ANGKUT, A.NO_VOY_FLIGHT, A.TGL_TIBA, B.NO_CONT, B.WK_IN FROM t_cocostshdr A INNER JOIN t_cocostscont B ON A.ID = B.ID WHERE B.WK_IN IS NOT NULL ORDER BY A.ID DESC) B ON A.NO_CONT = B.NO_CONT AND A.NM_KAPAL = B.NM_ANGKUT AND A.NO_VOY = B.NO_VOY_FLIGHT
						INNER JOIN t_operation C ON A.NO_DOK = C.NO_DOK AND A.NO_CONT = C.NO_CONT
						INNER JOIN (SELECT NO_CONT, NO_DOK, NO_SPK, NO_GATEPASS, LOKASI_AKHIR, WK_STATUS FROM t_job_slip WHERE LOKASI_AKHIR LIKE '1B%' GROUP BY NO_CONT ORDER BY ID_JOB_SLIP ASC) D ON B.NO_CONT = D.NO_CONT AND D.NO_DOK = A.NO_DOK
						INNER JOIN (SELECT NO_CONT, NO_DOK, NO_SPK, NO_GATEPASS, LOKASI_AKHIR, WK_STATUS FROM t_job_slip WHERE LOKASI_AKHIR LIKE '1A%' GROUP BY NO_CONT ORDER BY ID_JOB_SLIP DESC) E ON A.NO_CONT = E.NO_CONT AND E.NO_DOK = A.NO_DOK
						INNER JOIN (SELECT NO_CONT, NO_DOK, NO_SPK, NO_GATEPASS, LOKASI_AKHIR, WK_STATUS FROM t_job_slip WHERE LOKASI_AKHIR LIKE 'CIC%' GROUP BY NO_CONT ORDER BY ID_JOB_SLIP ASC) G ON B.NO_CONT = G.NO_CONT AND G.NO_DOK = A.NO_DOK
						INNER JOIN (SELECT A.ID, A.NO_CONT, B.NO_DAFTAR_PABEAN, B.TGL_DAFTAR_PABEAN FROM t_permit_cont A INNER JOIN t_permit_hdr B ON A.ID = B.ID GROUP BY A.NO_CONT ORDER BY A.ID DESC) F ON A.NO_CONT = F.NO_CONT AND F.NO_DAFTAR_PABEAN = A.NO_DOK	
						LEFT JOIN (SELECT ID, NO_CONT, NO_DOK, TGL_DOK FROM t_gatepass WHERE JNS_KEGIATAN=3) I ON A.NO_CONT = I.NO_CONT
						INNER JOIN t_spk H ON A.NO_DOK = H.NO_DOK
						LEFT JOIN (SELECT NM_KAPAL, NO_VOYAGE, ETA from t_jadwal_kapal) K ON B.NM_ANGKUT = K.NM_KAPAL AND B.NO_VOY_FLIGHT = K.NO_VOYAGE
						LEFT JOIN t_op_delivery J ON A.NO_CONT = J.NO_CONT
						
						WHERE A.JNS_DOK !='SPPMP' AND A.JNS_KEGIATAN ='1'" . $addsql;

				$result = $func->main->get_result($SQL);
				$this->load->library('newphpexcel');
				$this->newphpexcel->getDefaultStyle()->getFont()->setName('Calibri')->setSize(10);
				$objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
				$objDrawing->setName('Logo');
				$objDrawing->setDescription('Logo');
				$logo = imagecreatefrompng('assets/images/Logomti.png');
				$objDrawing->setImageResource($logo);
				$objDrawing->setCoordinates('A1');
				$objDrawing->setHeight(100);
				$objDrawing->setWidth(100);
				$objDrawing->setWorksheet($this->newphpexcel->getActiveSheet());
				$this->newphpexcel->setActiveSheetIndex(0);
				$styleArray = array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
				$this->newphpexcel->getDefaultStyle()->applyFromArray($styleArray);
				$this->newphpexcel->set_bold(array('A1'));
				$this->newphpexcel->mergecell(array(array('A1', 'J1'), array('A2', 'J2'), array('A3', 'J3')), FALSE);
				$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A1', 'REPORT MONITORING BEA CUKAI');
				$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A2', 'COMMON GATE PT. MTI');
				$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A3', date("M Y"));
				$this->newphpexcel->width(array(array('A', 5), array('B', 20), array('C', 20), array('D', 20), array('D', 20), array('F', 20), array('G', 20), array('H', 20), array('I', 20), array('J', 30), array('K', 30), array('L', 20), array('M', 20), array('N', 20), array('O', 20), array('P', 20), array('Q', 20), array('R', 25), array('S', 25), array('T', 25), array('U', 25), array('V', 25)));
				$this->newphpexcel->setActiveSheetIndex(0)
					->setCellValue('A5', 'NO')
					->setCellValue('B5', 'NO KONTAINER')
					->setCellValue('C5', 'WAKTU DISCHARGE')
					->setCellValue('D5', 'JENIS DOKUMEN')
					->setCellValue('E5', 'NO SPJM')
					->setCellValue('F5', 'WAKTU SPJM')
					->setCellValue('G5', 'TERBIT SPK')
					->setCellValue('H5', 'WAKTU BEHANDLE IN')
					->setCellValue('I5', 'RESPON PPK')
					->setCellValue('J5', 'SIAP PERIKSA')
					->setCellValue('K5', 'MULAI PERIKSA')
					->setCellValue('L5', 'SELESAI PERIKSA')
					->setCellValue('M5', 'NAMA KAPAL')
					->setCellValue('N5', 'VOY')
					->setCellValue('O5', 'ETA')
					->setCellValue('P5', 'NO SPPB')
					->setCellValue('Q5', 'WAKTU SPPB')
					->setCellValue('R5', 'WAKTU DELIVERY');

				$this->newphpexcel->headings(array('A5', 'B5', 'C5', 'D5', 'E5', 'F5', 'G5', 'H5', 'I5', 'J5', 'K5', 'L5', 'M5', 'N5', 'O5', 'P5', 'Q5', 'R5', 'S5', 'T5', 'U5', 'V5'));
				$this->newphpexcel->set_wrap(array('B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V'));
				$no = 1;
				$rec = 6;
				if ($result) {
					foreach ($SQL->result_array() as $row) {
						$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A' . $rec, $no)
							->setCellValueExplicit('B' . $rec, $row["NO_KONTAINER"], PHPExcel_Cell_DataType::TYPE_STRING)
							->setCellValueExplicit('C' . $rec, $row["WAKTU_DISCHARGE"])
							->setCellValueExplicit('D' . $rec, $row["JENIS_DOKUMEN"], PHPExcel_Cell_DataType::TYPE_STRING)
							->setCellValueExplicit('E' . $rec, $row["NO_SPJM"])
							->setCellValue('F' . $rec, $row["WAKTU_SPJM"])
							->setCellValue('G' . $rec, $row["TERBIT_SPK"])
							->setCellValue('H' . $rec, $row["WAKTU_BEHANDLE_IN"])
							->setCellValue('I' . $rec, $row["RESPON_PKB"])
							->setCellValue('J' . $rec, $row["SIAP_PERIKSA"])
							->setCellValue('K' . $rec, $row["MULAI_PERIKSA"])
							->setCellValue('L' . $rec, $row["SELESAI_PERIKSA"])
							->setCellValue('M' . $rec, $row["NM_KAPAL"])
							->setCellValue('N' . $rec, $row["NO_VOY"])
							->setCellValue('O' . $rec, $row["ETA"])
							->setCellValue('P' . $rec, $row["NO_SPPB"])
							->setCellValue('Q' . $rec, $row["WAKTU_SPPB"])
							->setCellValue('R' . $rec, $row["WAKTU_DELIVERY"]);
						$this->newphpexcel->set_detilstyle(array('A' . $rec, 'B' . $rec, 'C' . $rec, 'D' . $rec, 'E' . $rec, 'F' . $rec, 'G' . $rec, 'H' . $rec, 'I' . $rec, 'J' . $rec, 'K' . $rec, 'L' . $rec, 'M' . $rec, 'N' . $rec, 'O' . $rec, 'P' . $rec, 'Q' . $rec, 'R' . $rec, 'S' . $rec, 'T' . $rec, 'U' . $rec, 'V' . $rec));
						$rec++;
						$no++;
					}
				} else {
					$this->newphpexcel->getActiveSheet()->mergeCells('A4:O4');
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A5', 'DATA TIDAK DITEMUKAN');
					$this->newphpexcel->set_detilstyle(array('A5'));
				}
				ob_clean();

				$file = "MONITORING_BC_" . date("Ymd") . ".xls";
				header("Content-type: application/x-msdownload");
				header("Content-Disposition: attachment;filename=$file");
				header("Cache-Control: max-age=0");
				header("Pragma: no-cache");
				header("Expires: 0");
				$objWriter = PHPExcel_IOFactory::createWriter($this->newphpexcel, 'Excel5');
				$objWriter->save('php://output');
				exit();
			} else if ($act == "monitoringbcnew") {
				// echo "Bisa tarik dokumen";
				$TGL = $this->input->post('form[0]');
				$TGL_START = $TGL[0];
				$TGL_END = $TGL[1];
				$addsql = " ";


				if ($TGL != "") {
					$addsql .= " AND A.TGL_DOK BETWEEN '$TGL_START' AND '$TGL_END' ORDER BY A.TGL_DOK ASC";
				} else {
					$addsql .= "";
				}

				$SQL = "SELECT distinct A.NO_CONT, A.NO_DOK, A.TGL_DOK, A.RESPON, A.WK_RESPON, 
					D.WK_REQ as 'WK_REQUEST_GATEPASS_TERMINAL', concat('') as 'APPROVE_GATEPASS_TERMINAL',
					A.NPWP, A.NAMA_CUST, E.NO_SPK, E.WK_REQ as 'TERBIT_SPK', 
					concat('') as 'Gate_In_terminal',
					concat('') as Gate_Out_Terminal, 
					G.WK_IN as 'BEHANDLE_IN',
					F.WK_STATUS as 'MARSHALLING_BEHANDLE_1',
					G.WK_START as 'START_PERIKSA',
					G.WK_FINISH as 'SELESAI_PERIKSA',
					H.WK_STATUS as 'MARSHALLING_EX-BEHANDLE_1',
					I.WK_TRUCKIN as 'TRUCK_IN',
					I.WK_GATEOUT as 'TRUCK_OUT'
					from t_gatepass A 
					join t_spk B on A.NO_DOK = B.NO_DOK and B.TGL_DOK = B.TGL_DOK
					join t_spk_cont C on B.ID = C.ID and C.NO_CONT = A.NO_CONT
					join (select tr.ID, tr.NO_DOK, tr.TGL_DOK, tr.WK_REQ from t_request tr join t_request_cont trc on tr.ID = trc.ID) D
					on D.NO_DOK = A.NO_DOK and D.TGL_DOK = A.TGL_DOK
					join t_spk E on A.NO_DOK = E.NO_DOK and A.TGL_DOK = E.TGL_DOK
					join t_job_slip F on A.NO_CONT = F.NO_CONT and F.NO_SPK = E.NO_SPK and F.JENIS = 'BEHANDLE 1'
					join t_operation G on G.NO_SPK = E.NO_SPK and G.NO_CONT = A.NO_CONT
					join t_job_slip H on A.NO_CONT = H.NO_CONT and H.NO_SPK = E.NO_SPK and H.JENIS = 'EX BEHANDLE 1'
					JOIN (
						    SELECT NO_CONT, NO_SPK, MAX(ID) as max_id
						    FROM t_op_delivery
						    GROUP BY NO_CONT, NO_SPK
						) I_max ON I_max.NO_CONT = A.NO_CONT AND I_max.NO_SPK = E.NO_SPK
						JOIN t_op_delivery I ON I.NO_CONT = I_max.NO_CONT AND I.NO_SPK = I_max.NO_SPK AND I.ID = I_max.max_id
					where A.JNS_DOK != 'SPPMP' and JNS_KEGIATAN = '1' 
					AND A.TGL_DOK >= CURDATE() - INTERVAL 2 YEAR " . $addsql;

				$result = $func->main->get_result($SQL);
				$this->load->library('newphpexcel');
				$this->newphpexcel->getDefaultStyle()->getFont()->setName('Calibri')->setSize(10);
				$objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
				$objDrawing->setName('Logo');
				$objDrawing->setDescription('Logo');
				$logo = imagecreatefrompng('assets/images/Logomti.png');
				$objDrawing->setImageResource($logo);
				$objDrawing->setCoordinates('A1');
				$objDrawing->setHeight(100);
				$objDrawing->setWidth(100);
				$objDrawing->setWorksheet($this->newphpexcel->getActiveSheet());
				$this->newphpexcel->setActiveSheetIndex(0);
				$styleArray = array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
				$this->newphpexcel->getDefaultStyle()->applyFromArray($styleArray);
				$this->newphpexcel->set_bold(array('A1'));
				$this->newphpexcel->mergecell(array(array('A1', 'J1'), array('A2', 'J2'), array('A3', 'J3')), FALSE);
				$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A1', 'REPORT MONITORING SPJM');
				$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A2', 'COMMON AREA PT. MTI');
				$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A3', date("M Y"));
				$this->newphpexcel->width(array(array('A', 5), array('B', 20), array('C', 20), array('D', 20), array('D', 20), array('F', 20), array('G', 20), array('H', 20), array('I', 20), array('J', 30), array('K', 30), array('L', 20), array('M', 20), array('N', 20), array('O', 20), array('P', 20), array('Q', 20), array('R', 25), array('S', 25), array('T', 25), array('U', 25), array('V', 25)));
				$this->newphpexcel->setActiveSheetIndex(0)
					->setCellValue('A5', 'NO')
					->setCellValue('B5', 'NO KONTAINER')
					->setCellValue('C5', 'NO DOKUMEN')
					->setCellValue('D5', 'TGL DOKUMEN')
					->setCellValue('E5', 'RESPON')
					->setCellValue('F5', 'WAKTU RESPON')
					->setCellValue('G5', 'WAKTU REQUEST GATEPASS TERMINAL')
					->setCellValue('H5', 'WAKTU APPROVE GATEPASS TERMINAL')
					->setCellValue('I5', 'NPWP')
					->setCellValue('J5', 'CONSIGNEE')
					->setCellValue('K5', 'NO SPK')
					->setCellValue('L5', 'TERBIT SPK')
					->setCellValue('M5', 'GATE IN TERMINAL')
					->setCellValue('N5', 'GATE OUT TERMINAL')
					->setCellValue('O5', 'BEHANDLE IN')
					->setCellValue('P5', 'MARSHALLING BEHANDLE 1')
					->setCellValue('Q5', 'START PERIKSA')
					->setCellValue('R5', 'SELESAI PERIKSA')
					->setCellValue('S5', 'MARSHALLING EX-BEHANDLE 1')
					->setCellValue('T5', 'TRUCK IN')
					->setCellValue('U5', 'TRUCK OUT');

				$this->newphpexcel->headings(array('A5', 'B5', 'C5', 'D5', 'E5', 'F5', 'G5', 'H5', 'I5', 'J5', 'K5', 'L5', 'M5', 'N5', 'O5', 'P5', 'Q5', 'R5', 'S5', 'T5', 'U5', 'V5'));
				$this->newphpexcel->set_wrap(array('B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V'));
				$no = 1;
				$rec = 6;
				if ($result) {
					foreach ($SQL->result_array() as $row) {
						$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A' . $rec, $no)
							->setCellValueExplicit('B' . $rec, $row["NO_CONT"], PHPExcel_Cell_DataType::TYPE_STRING)
							->setCellValueExplicit('C' . $rec, $row["NO_DOK"])
							->setCellValueExplicit('D' . $rec, $row["TGL_DOK"])
							->setCellValueExplicit('E' . $rec, $row["RESPON"])
							->setCellValue('F' . $rec, $row["WK_RESPON"])
							->setCellValue('G' . $rec, $row["WK_REQUEST_GATEPASS_TERMINAL"])
							->setCellValue('H' . $rec, $row["APPROVE_GATEPASS_TERMINAL"])
							->setCellValue('I' . $rec, $row["NPWP"])
							->setCellValue('J' . $rec, $row["NAMA_CUST"])
							->setCellValue('K' . $rec, $row["NO_SPK"])
							->setCellValue('L' . $rec, $row["TERBIT_SPK"])
							->setCellValue('M' . $rec, $row["Gate_In_terminal"])
							->setCellValue('N' . $rec, $row["Gate_Out_Terminal"])
							->setCellValue('O' . $rec, $row["BEHANDLE_IN"])
							->setCellValue('P' . $rec, $row["MARSHALLING_BEHANDLE_1"])
							->setCellValue('Q' . $rec, $row["START_PERIKSA"])
							->setCellValue('R' . $rec, $row["SELESAI_PERIKSA"])
							->setCellValue('S' . $rec, $row["MARSHALLING_EX-BEHANDLE_1"])
							->setCellValue('T' . $rec, $row["TRUCK_IN"])
							->setCellValue('U' . $rec, $row["TRUCK_OUT"]);
						$this->newphpexcel->set_detilstyle(array('A' . $rec, 'B' . $rec, 'C' . $rec, 'D' . $rec, 'E' . $rec, 'F' . $rec, 'G' . $rec, 'H' . $rec, 'I' . $rec, 'J' . $rec, 'K' . $rec, 'L' . $rec, 'M' . $rec, 'N' . $rec, 'O' . $rec, 'P' . $rec, 'Q' . $rec, 'R' . $rec, 'S' . $rec, 'T' . $rec, 'U' . $rec, 'V' . $rec));
						$rec++;
						$no++;
					}
				} else {
					$this->newphpexcel->getActiveSheet()->mergeCells('A4:O4');
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A5', 'DATA TIDAK DITEMUKAN');
					$this->newphpexcel->set_detilstyle(array('A5'));
				}
				ob_clean();

				$file = "MONITORING_SPJM_" . date("Ymd") . ".xls";
				header("Content-type: application/x-msdownload");
				header("Content-Disposition: attachment;filename=$file");
				header("Cache-Control: max-age=0");
				header("Pragma: no-cache");
				header("Expires: 0");
				$objWriter = PHPExcel_IOFactory::createWriter($this->newphpexcel, 'Excel5');
				$objWriter->save('php://output');
				exit();
			} else if ($act == 'karantinaEx') {
				$TGL = $this->input->post('form[0]');
				$TGL_START = $TGL[0];
				$TGL_END = $TGL[1];
				$addsql = " ";

				if ($TGL != "") {
					$addsql .= " AND C.TG_RESPON BETWEEN '$TGL_START' AND '$TGL_END' ORDER BY C.TG_RESPON ASC";
				} else {
					$addsql .= "";
				}

				$tgl_awal = date("d/m/Y", strtotime($TGL_START));
				$tgl_akhir = date("d/m/Y", strtotime($TGL_END));

				$SQL = "SELECT DISTINCT A.NO_CONT AS 'KONTAINER', B.NM_ANGKUT AS 'NAMA_KAPAL', B.NO_VOY_FLIGHT AS 'VOYAGE', B.WK_IN AS 'WAKTU_DISCHARGE', C.NO_RESPON AS 'NO_DOK', C.TG_RESPON AS 'TGL_DOK',D.WK_IN AS 'WAKTU_BEHANDLE_IN', E.WK_GATEOUT AS 'DELIVERY',
							D.WK_START AS 'MULAI_PERIKSA', D.WK_FINISH AS 'SELESAI_PERIKSA',  F.NO_DOK AS 'NO_SPPB', F.TGL_DOK AS 'TGL_SPPB'
						FROM t_gatepass A
						INNER JOIN (SELECT A.ID, A.NM_ANGKUT, A.NO_VOY_FLIGHT, B.NO_CONT, B.WK_IN FROM t_cocostshdr A INNER JOIN t_cocostscont B ON A.ID = B.ID WHERE B.WK_IN IS NOT NULL ORDER BY A.ID DESC) B ON A.NO_CONT = B.NO_CONT AND A.NM_KAPAL = B.NM_ANGKUT AND A.NO_VOY = B.NO_VOY_FLIGHT
						INNER JOIN (SELECT A.NO_RESPON, A.TG_RESPON, B.NO_CONT FROM t_ppk_hdr A INNER JOIN t_ppk_cont B ON A.ID_IJIN = B.ID_IJIN) C ON C.NO_RESPON = A.NO_DOK AND A.TGL_DOK = C.TG_RESPON AND A.NO_CONT = C.NO_CONT
						INNER JOIN t_operation D ON A.NO_DOK = D.NO_DOK AND A.NO_CONT = D.NO_CONT
						LEFT JOIN t_op_delivery E ON A.NO_CONT = E.NO_CONT
						LEFT JOIN (SELECT ID, NO_CONT, NO_DOK, TGL_DOK FROM t_gatepass WHERE JNS_KEGIATAN=3) F ON A.NO_CONT = F.NO_CONT
						WHERE 1=1" . $addsql;

				$result = $func->main->get_result($SQL);
				$this->load->library('newphpexcel');
				$this->newphpexcel->getDefaultStyle()->getFont()->setName('Calibri')->setSize(10);
				$objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
				$objDrawing->setName('Logo');
				$objDrawing->setDescription('Logo');
				$logo = imagecreatefrompng('assets/images/Logomti.png');
				$objDrawing->setImageResource($logo);
				$objDrawing->setCoordinates('A1');
				$objDrawing->setHeight(100);
				$objDrawing->setWidth(100);
				$objDrawing->setWorksheet($this->newphpexcel->getActiveSheet());
				$this->newphpexcel->setActiveSheetIndex(0);
				$styleArray = array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
				$this->newphpexcel->getDefaultStyle()->applyFromArray($styleArray);
				$this->newphpexcel->set_bold(array('A1'));
				$this->newphpexcel->mergecell(array(array('A1', 'J1'), array('A2', 'J2'), array('A3', 'J3')), FALSE);
				$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A1', 'REPORT MONITORING KARANTINA');
				$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A2', 'COMMON GATE PT. MTI');
				$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A3', $tgl_awal . ' - ' . $tgl_akhir);
				$this->newphpexcel->width(array(array('A', 5), array('B', 20), array('C', 20), array('D', 20), array('E', 20), array('F', 30), array('G', 20), array('H', 20), array('I', 20), array('J', 20), array('K', 20), array('L', 20), array('M', 20)));
				$this->newphpexcel->setActiveSheetIndex(0)
					->setCellValue('A5', 'NO')
					->setCellValue('B5', 'NO KONTAINER')
					->setCellValue('C5', 'NAMA KAPAL')
					->setCellValue('D5', 'VOYAGE')
					->setCellValue('E5', 'WAKTU DISCHARGE')
					->setCellValue('F5', 'NO DOKUMEN')
					->setCellValue('G5', 'TGL DOKUMEN')
					->setCellValue('H5', 'WAKTU BEHANDLE IN')
					->setCellValue('I5', 'MULAI PERIKSA')
					->setCellValue('J5', 'SELESAI PERIKSA')
					->setCellValue('K5', 'DELIVERY')
					->setCellValue('L5', 'NO SPPB')
					->setCellValue('M5', 'TGL_SPPB');

				$this->newphpexcel->headings(array('A5', 'B5', 'C5', 'D5', 'E5', 'F5', 'G5', 'H5', 'I5', 'J5', 'K5', 'L5', 'M5'));
				$this->newphpexcel->set_wrap(array('B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M'));
				$no = 1;
				$rec = 6;
				if ($result) {
					foreach ($SQL->result_array() as $row) {
						$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A' . $rec, $no)
							->setCellValueExplicit('B' . $rec, $row["KONTAINER"], PHPExcel_Cell_DataType::TYPE_STRING)
							->setCellValueExplicit('C' . $rec, $row["NAMA_KAPAL"])
							->setCellValueExplicit('D' . $rec, $row["VOYAGE"], PHPExcel_Cell_DataType::TYPE_STRING)
							->setCellValueExplicit('E' . $rec, $row["WAKTU_DISCHARGE"])
							->setCellValue('F' . $rec, $row["NO_DOK"])
							->setCellValue('G' . $rec, $row["TGL_DOK"])
							->setCellValue('H' . $rec, $row["WAKTU_BEHANDLE_IN"])
							->setCellValue('I' . $rec, $row["MULAI_PERIKSA"])
							->setCellValue('J' . $rec, $row["SELESAI_PERIKSA"])
							->setCellValue('K' . $rec, $row["DELIVERY"])
							->setCellValue('L' . $rec, $row["NO_SPPB"])
							->setCellValue('M' . $rec, $row["TGL_SPPB"]);
						$this->newphpexcel->set_detilstyle(array('A' . $rec, 'B' . $rec, 'C' . $rec, 'D' . $rec, 'E' . $rec, 'F' . $rec, 'G' . $rec, 'H' . $rec, 'I' . $rec, 'J' . $rec, 'K' . $rec, 'L' . $rec, 'M' . $rec));
						$rec++;
						$no++;
					}
				} else {
					$this->newphpexcel->getActiveSheet()->mergeCells('A4:O4');
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A5', 'DATA TIDAK DITEMUKAN');
					$this->newphpexcel->set_detilstyle(array('A5'));
				}
				ob_clean();

				$file = "REPORT_KARANTINA_" . date("Ymd") . ".xls";
				header("Content-type: application/x-msdownload");
				header("Content-Disposition: attachment;filename=$file");
				header("Cache-Control: max-age=0");
				header("Pragma: no-cache");
				header("Expires: 0");
				$objWriter = PHPExcel_IOFactory::createWriter($this->newphpexcel, 'Excel5');
				$objWriter->save('php://output');
				exit();
			} else if ($act == "nhi") {
				$STATUS = $this->input->post('form[0]');
				$LOKASI = $this->input->post('form[1]');
				$TGL = $this->input->post('form[2]');
				/*print_r($STATUS);
							echo "<hr>";
							print_r($LOKASI);*/
				//die();
				// echo "<hr>";
				$TGL_AWAL = $TGL[0];
				$TGL_AKHIR = $TGL[1];
				$status_kontainer = $STATUS[0];
				$status_lokasi = $LOKASI[0];

				$addsql = "";

				if ($status_lokasi != "") {
					$addsql .= " AND B.LOKASI LIKE '$status_lokasi'";
				}

				if ($TGL_AWAL != "" && $TGL_AKHIR != "") {
					$addsql .= " AND A.WK_REQ BETWEEN '$TGL_AWAL' AND '$TGL_AKHIR' GROUP BY B.NO_CONT";
				} else if ($TGL_AWAL != "") {
					$addsql .= " AND A.WK_REQ >= '$TGL_AWAL' GROUP BY B.NO_CONT";
				} else if ($TGL_AKHIR != "") {
					$addsql .= " AND A.WK_REQ <= '$TGL_AKHIR' GROUP BY B.NO_CONT";
				}

				if ($status_kontainer != "") {
					$addsql .= " AND B.STATUS_CONT IN ($status_kontainer)";
				}

				$SQL = "SELECT A.NO_SPK, B.NO_CONT, B.UKR_CONT, CASE WHEN C.STATUS_CONT = 'F' THEN 'FULL' ELSE 'EMPTY' END AS STATUS_CONT, E.IMO, C.NM_ANGKUT, C.NO_VOY_FLIGHT AS NO_VOY, C.STACKING ,
						F.W_PICKUP, 'NO DATA' AS GATEIN_TERMINAL, 'NO DATA' AS GATEOUT_TERMINAL, F.W_BEHANDLE, A.WK_REQ, D.NAMA, A.NO_DOK, A.TGL_DOK, B.ID_FLAT AS 'TID', CONCAT((B.LOKASI),'0',(B.TIER)) AS 'LOKASI', 
						CASE WHEN B.STATUS_CONT IN ('450','510','530') AND B.LOKASI LIKE '1A%' THEN 'STACKING YARD 1A' WHEN B.STATUS_CONT IN ('450','510','530') AND B.LOKASI LIKE '1B%' THEN 'STACKING YARD 1B' WHEN B.STATUS_CONT IN ('460','520','540') THEN 'STACKING CIC' ELSE 'DELIVERY' END AS 'STATUS',
						E.CONSIGNEE
					FROM t_spk A
					INNER JOIN t_spk_cont B ON A.ID = B.ID
					INNER JOIN t_gatepass G ON B.NO_CONT = G.NO_CONT AND A.NO_DOK = G.NO_DOK
					INNER JOIN (SELECT A.ID, B.NO_CONT, A.NM_ANGKUT, A.NO_VOY_FLIGHT, B.JNS_CONT AS 'STATUS_CONT', B.ISO_CODE, B.KD_CONT_TIPE AS 'TIPE_CONT', B.WK_IN AS 'STACKING' FROM t_cocostshdr A INNER JOIN t_cocostscont B ON A.ID = B.ID WHERE B.WK_IN IS NOT NULL ORDER BY A.ID DESC) C ON B.NO_CONT = C.NO_CONT AND G.NM_KAPAL = C.NM_ANGKUT AND G.NO_VOY = C.NO_VOY_FLIGHT
					LEFT JOIN reff_kode_dok_bc D ON D.ID = A.JNS_DOK
					INNER JOIN(SELECT A.ID, A.JNS_DOK, B.NO_CONT, B.IMO, A.CONSIGNEE FROM t_request A INNER JOIN t_request_cont B ON A.ID = B.ID) E ON B.NO_CONT = E.NO_CONT
					INNER JOIN (SELECT A.NO_SPK, B.NO_CONT, A.W_PICKUP, W_BEHANDLE, B.KONDISI_CONT, B.NO_SEAL, B.ROOM FROM t_op_pickup A INNER JOIN t_op_behandlein B ON A.NO_SPK = B.NO_SPK) F ON A.NO_SPK = F.NO_SPK AND B.NO_CONT = F.NO_CONT
					WHERE 1=1 AND E.JNS_DOK=81" . $addsql;
				// echo $SQL;die();

				$result = $func->main->get_result($SQL);
				$this->load->library('newphpexcel');
				$this->newphpexcel->getDefaultStyle()->getFont()->setName('Calibri')->setSize(10);
				$objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
				$objDrawing->setName('Logo');
				$objDrawing->setDescription('Logo');
				$logo = imagecreatefrompng('assets/images/Logomti.png');
				$objDrawing->setImageResource($logo);
				$objDrawing->setCoordinates('A1');
				$objDrawing->setHeight(100);
				$objDrawing->setWidth(100);
				$objDrawing->setWorksheet($this->newphpexcel->getActiveSheet());
				$this->newphpexcel->setActiveSheetIndex(0);
				$styleArray = array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
				$this->newphpexcel->getDefaultStyle()->applyFromArray($styleArray);
				$this->newphpexcel->set_bold(array('A1'));
				$this->newphpexcel->mergecell(array(array('A1', 'U1'), array('A2', 'U2'), array('A3', 'U3')), FALSE);
				$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A1', 'REPORT STACKING EX-BEHANDLE');
				$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A2', 'COMMON GATE PT. MTI');
				$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A3', date("M Y"));
				$this->newphpexcel->width(array(array('A', 5), array('B', 20), array('C', 20), array('D', 8), array('E', 10), array('F', 20), array('G', 30), array('H', 15), array('I', 45), array('J', 25), array('K', 25), array('L', 25), array('M', 25), array('N', 25), array('O', 25), array('P', 25), array('Q', 25), array('R', 25), array('S', 25), array('T', 25), array('U', 25)));
				$this->newphpexcel->setActiveSheetIndex(0)
					->setCellValue('A5', 'NO')
					->setCellValue('B5', 'NO SPK')
					->setCellValue('C5', 'NO KONTAINER')
					->setCellValue('D5', 'SIZE')
					->setCellValue('E5', 'STATUS')
					->setCellValue('F5', 'IMO')
					->setCellValue('G5', 'NAMA KAPAL')
					->setCellValue('H5', 'VOYAGE')
					->setCellValue('I5', 'STACKING')
					->setCellValue('J5', 'PICKUP')
					->setCellValue('K5', 'GATE IN TERMINAL')
					->setCellValue('L5', 'GATE OUT TERMINAL')
					->setCellValue('M5', 'BEHANDLE IN')
					->setCellValue('N5', 'TERBIT SPK')
					->setCellValue('O5', 'JENIS DOKUMEN')
					->setCellValue('P5', 'NO DOKUMEN')
					->setCellValue('Q5', 'TANGGAL DOKUMEN')
					->setCellValue('R5', 'TID')
					->setCellValue('S5', 'LOKASI')
					->setCellValue('T5', 'CUSTOMER')
					->setCellValue('U5', 'STATUS KONTAINER');
				$this->newphpexcel->headings(array('A5', 'B5', 'C5', 'D5', 'E5', 'F5', 'G5', 'H5', 'I5', 'J5', 'K5', 'L5', 'M5', 'N5', 'O5', 'P5', 'Q5', 'R5', 'S5', 'T5', 'U5'));
				$this->newphpexcel->set_wrap(array('B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U'));
				$no = 1;
				$rec = 6;
				if ($result) {
					foreach ($SQL->result_array() as $row) {
						$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A' . $rec, $no)
							->setCellValue('B' . $rec, $row["NO_SPK"])
							->setCellValue('C' . $rec, $row["NO_CONT"])
							->setCellValue('D' . $rec, $row["UKR_CONT"])
							->setCellValue('E' . $rec, $row["STATUS_CONT"])
							->setCellValue('F' . $rec, $row["IMO"])
							->setCellValue('G' . $rec, $row["NM_ANGKUT"])
							->setCellValue('H' . $rec, $row["NO_VOY"])
							->setCellValue('I' . $rec, $row["STACKING"])
							->setCellValue('J' . $rec, $row["W_PICKUP"])
							->setCellValue('K' . $rec, $row["GATEIN_TERMINAL"])
							->setCellValue('L' . $rec, $row["GATEOUT_TERMINAL"])
							->setCellValue('M' . $rec, $row["W_BEHANDLE"])
							->setCellValue('N' . $rec, $row["WK_REQ"])
							->setCellValue('O' . $rec, $row["NAMA"])
							->setCellValue('P' . $rec, $row["NO_DOK"])
							->setCellValue('Q' . $rec, $row["TGL_DOK"])
							->setCellValue('R' . $rec, $row["TID"])
							->setCellValue('S' . $rec, $row["LOKASI"])
							->setCellValue('T' . $rec, $row["CONSIGNEE"])
							->setCellValue('U' . $rec, $row["STATUS"]);
						$this->newphpexcel->set_detilstyle(array('A' . $rec, 'B' . $rec, 'C' . $rec, 'D' . $rec, 'E' . $rec, 'F' . $rec, 'G' . $rec, 'H' . $rec, 'I' . $rec, 'J' . $rec, 'K' . $rec, 'L' . $rec, 'M' . $rec, 'N' . $rec, 'O' . $rec, 'P' . $rec, 'Q' . $rec, 'R' . $rec, 'S' . $rec, 'T' . $rec, 'U' . $rec));
						$rec++;
						$no++;
					}
				} else {
					$this->newphpexcel->getActiveSheet()->mergeCells('A4:U4');
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A5', 'DATA TIDAK DITEMUKAN');
					$this->newphpexcel->set_detilstyle(array('A5'));
				}
				ob_clean();

				$file = "NHI_" . date("Ymd") . ".xls";
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

	function get_referensi($type, $kode, $uraian)
	{
		$func = get_instance();
		$func->load->model("m_main", "main", true);
		$return = NULL;
		switch ($type) {
			case 'kapal':
				if ($uraian != "") {
					$SQL = "SELECT ID, NAMA FROM reff_kapal
							WHERE NAMA = " . $this->db->escape(trim($uraian));
					$result = $func->main->get_result($SQL);
					if ($result) {
						foreach ($SQL->result_array() as $row => $value) {

							$arrdata = $value;
						}
						$kode_angkut = $arrdata['ID'];
					} else {
						$arrdata['NAMA'] = $uraian;
						$arrdata['CALL_SIGN'] = $kode;
						$this->db->insert('reff_kapal', $arrdata);
						$kode_angkut = $this->db->insert_id();
					}
					if ($kode != "") {
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

	public function data_monitoring($id)
	{
		$arrid = explode("~", $id);
		$id = $arrid[0];
		// var_dump($id);die();

		$sql = "SELECT * FROM t_spk A INNER JOIN t_spk_cont B ON A.ID = B.ID WHERE A.ID = '$id'";
		$test = $this->db->query($sql);
		$result = $test->result_array();
		// var_dump($result);

		// var_dump($sql);die();
	}

	public function monitoring_karantina($act, $id)
	{
		$page_title = "REPORT KARANTINA";
		$title = "REPORT KARANTINA";
		$this->newtable->breadcrumb('Dashboard', site_url(), 'icon-home');
		$this->newtable->breadcrumb('Report', 'javascript:void(0)', '');
		$this->newtable->breadcrumb('KARANTINA', 'javascript:void(0)', '');
		$check = (grant() == "W") ? true : false;

		$SQL = "SELECT A.ID, A.NO_CONT AS 'KONTAINER', B.NM_ANGKUT AS 'NAMA KAPAL', B.NO_VOY_FLIGHT AS 'VOYAGE', B.WK_IN AS 'WAKTU DISCHARGE', C.NO_RESPON AS 'NO DOKUMEN', C.TG_RESPON AS 'TGL DOKUMEN',D.WK_IN AS 'WAKTU BEHANDLE IN',
					D.WK_START AS 'MULAI PERIKSA', D.WK_FINISH AS 'SELESAI PERIKSA', E.WK_GATEOUT AS 'DELIVERY', F.NO_DOK AS 'NO SPPB', F.TGL_DOK AS 'TGL SPPB'
				FROM t_gatepass A
				INNER JOIN (SELECT A.ID, A.NM_ANGKUT, A.NO_VOY_FLIGHT, B.NO_CONT, B.WK_IN FROM t_cocostshdr A INNER JOIN t_cocostscont B ON A.ID = B.ID WHERE B.WK_IN IS NOT NULL ORDER BY A.ID DESC) B ON A.NO_CONT = B.NO_CONT AND A.NM_KAPAL = B.NM_ANGKUT AND A.NO_VOY = B.NO_VOY_FLIGHT
				INNER JOIN (SELECT A.NO_RESPON, A.TG_RESPON, B.NO_CONT FROM t_ppk_hdr A INNER JOIN t_ppk_cont B ON A.ID_IJIN = B.ID_IJIN) C ON C.NO_RESPON = A.NO_DOK AND A.TGL_DOK = C.TG_RESPON AND A.NO_CONT = C.NO_CONT
				INNER JOIN t_operation D ON A.NO_DOK = D.NO_DOK AND A.NO_CONT = D.NO_CONT
				LEFT JOIN t_op_delivery E ON A.NO_CONT = E.NO_CONT
				LEFT JOIN (SELECT ID, NO_CONT, NO_DOK, TGL_DOK FROM t_gatepass WHERE JNS_KEGIATAN=3) F ON A.NO_CONT = F.NO_CONT
				WHERE 1=1";

		$this->newtable->multiple_search(true);
		$this->newtable->show_chk(false);
		$this->newtable->show_menu($check);
		$this->newtable->show_search(true);
		$proses = array('EXPORT KARANTINA' => array('EXCEL', "process/excel/karantinaEx/" . $act, '0', '', 'md-file-text', '', 'menu'));
		$this->newtable->search(array(array('C.TG_RESPON', 'TGL DOKUMEN', 'DATERANGE')));
		$this->newtable->action(site_url() . "/report/karantina");
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("ID"));
		$this->newtable->keys(array("A.NO_SPK"));
		$this->newtable->cidb($this->db);
		$this->newtable->groupby("");
		$this->newtable->orderby("C.TG_RESPON");
		$this->newtable->sortby("DESC");
		$this->newtable->set_formid("tblmonitoringdelivery");
		$this->newtable->set_divid("divmonitoringdelivery");
		$this->newtable->rowcount(100);
		$this->newtable->clear();
		$this->newtable->menu($proses);
		$tabel .= $this->newtable->generate($SQL);
		$arrdata = array("page_title" => $page_title, "title" => $title, "content" => $tabel);
		if ($this->input->post("ajax") || $act == "post")
			return $tabel;
		else
			return $arrdata;
	}

	public function monitorNHI($act, $id)
	{
		$page_title = "NHI";
		$title = "NHI";
		$this->newtable->breadcrumb('Dashboard', site_url(), 'icon-home');
		$this->newtable->breadcrumb('Report', 'javascript:void(0)', '');
		$this->newtable->breadcrumb('NHI', 'javascript:void(0)', '');
		$check = (grant() == "W") ? true : false;

		$SQL = "SELECT A.NO_SPK AS 'NO SPK', B.NO_CONT AS 'KONTAINER', B.UKR_CONT AS 'SIZE', CASE WHEN C.STATUS_CONT = 'F' THEN 'FULL' ELSE 'EMPTY' END AS 'STATUS', A.WK_REQ AS 'TERBIT SPK', E.NAMA AS 'JENIS DOKUMEN', A.NO_DOK AS 'NO DOKUMEN', A.TGL_DOK AS 'TGL DOKUMEN', B.ID_FLAT AS 'TID', CONCAT((B.LOKASI),'0',(B.TIER)) AS 'LOKASI', CASE WHEN B.STATUS_CONT IN ('450','510','530') AND B.LOKASI LIKE '1A%' THEN 'STACKING YARD 1A' WHEN B.STATUS_CONT IN ('450','510','530') AND B.LOKASI LIKE '1B%' THEN 'STACKING YARD 1B' WHEN B.STATUS_CONT IN ('460','520','540') THEN 'STACKING CIC' ELSE 'DELIVERY' END AS 'KETERANGAN', G.CONSIGNEE AS 'CUSTOMER'
			FROM t_spk A
			LEFT JOIN t_spk_cont B ON A.ID = B.ID
			LEFT JOIN (SELECT ID, NO_CONT, JNS_CONT AS 'STATUS_CONT', ISO_CODE, KD_CONT_TIPE AS 'TIPE_CONT', WK_IN AS 'STACKING' FROM t_cocostscont GROUP BY NO_CONT ORDER BY ID DESC) C ON B.NO_CONT = C.NO_CONT
			LEFT JOIN t_cocostshdr D ON C.ID = D.ID
			LEFT JOIN reff_kode_dok_bc E ON E.ID = A.JNS_DOK
			LEFT JOIN (SELECT ID, NO_CONT, IMO FROM t_request_cont GROUP BY NO_CONT ORDER BY ID DESC) F ON B.NO_CONT = F.NO_CONT
			LEFT JOIN t_request G ON F.ID = G.ID
			INNER JOIN (SELECT A.NO_SPK, B.NO_CONT, A.W_PICKUP, W_BEHANDLE, B.KONDISI_CONT, B.NO_SEAL, B.ROOM FROM t_op_pickup A INNER JOIN t_op_behandlein B ON A.NO_SPK = B.NO_SPK) H ON A.NO_SPK = H.NO_SPK AND B.NO_CONT = H.NO_CONT
			WHERE B.STATUS_CONT IN ('450','510','530','520','540','460','900') AND A.JNS_DOK=81";

		$this->newtable->multiple_search(true);
		$this->newtable->show_chk(false);
		$this->newtable->show_menu($check);
		$this->newtable->show_search(true);
		$proses = array('EXPORT STACKING' => array('EXCEL', "process/excel/nhi/" . $act, '0', '', 'md-file-text', '', 'menu'));
		$arr_sts = array("" => "", "450,510,530" => "STACKING YARD", "460,520,540" => "STACKING CIC");
		$arr_sts_lokasi = array("" => "", "1A%" => "STACKING 1A", "1B%" => "STACKING 1B");
		$this->newtable->search(array(array('B.STATUS_CONT', 'STATUS KONTAINER', 'FILTERIN', $arr_sts), array('B.LOKASI', 'STATUS LOKASI', 'OPTION', $arr_sts_lokasi), array('A.WK_REQ', 'TANGGAL SPK TERBIT', 'DATETIMERANGE')));
		$this->newtable->action(site_url() . "/report/nhi");
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array(""));
		$this->newtable->keys(array(""));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby("A.WK_REQ DESC");
		$this->newtable->sortby("");
		$this->newtable->set_formid("tblstacking");
		$this->newtable->set_divid("divstacking");
		$this->newtable->rowcount(25);
		$this->newtable->clear();
		$this->newtable->menu($proses);
		$tabel .= $this->newtable->generate($SQL);
		$arrdata = array("page_title" => $page_title, "title" => $title, "content" => $tabel);
		if ($this->input->post("ajax") || $act == "post")
			return $tabel;
		else
			return $arrdata;
	}
}
