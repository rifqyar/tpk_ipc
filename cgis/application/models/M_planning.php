<?php if (! defined('BASEPATH')) exit('No direct script access allowed');
class M_planning extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
	}

	function get_data($act, $id)
	{
		$func = get_instance();
		$func->load->model("m_main", "main");
		$arrdata = array();
		if ($act == "dok_manualhdr") {
			$SQL = "SELECT A.*, B.NAMA AS NM_DOK_INOUT FROM t_permit_hdr A
					LEFT JOIN reff_kode_dok_bc B ON A.KD_DOK_INOUT=B.ID
                    WHERE A.ID = " . $this->db->escape($id);
			$result = $func->main->get_result($SQL);
			if ($result) {
				foreach ($SQL->result_array() as $row => $value) {
					$arrdata = $value;
				}
				return $arrdata;
			} else {
				redirect(site_url(), 'refresh');
			}
		} else if ($act == "dok_manualcont") {
			$SQL = "SELECT * FROM t_permit_cont
                    WHERE ID = " . $this->db->escape($id);
			$result = $this->db->query($SQL);
			return $result->result_array();
		} else if ($act == "detail_spk") {
			$explodeArr = explode("~", $id);
			$idarr = $explodeArr[0];
			$SQL = "SELECT DISTINCT A.*, CONCAT('', B.KETERANGAN,'') AS 'STATUS',D.FL_PERIKSA,C.KD_CONT_TIPE
			FROM t_spk_cont A
			INNER JOIN reff_status_spk B ON A.status_cont = B.id
			LEFT JOIN (select * from t_permit_cont where FL_PERIKSA = 'Y') D on A.NO_CONT = D.NO_CONT
			LEFT JOIN (SELECT NO_CONT,KD_CONT_TIPE FROM t_cocostscont WHERE KD_CONT_TIPE IS NOT null ) C ON A.NO_CONT = C.NO_CONT
			where A.ID = " . $this->db->escape($idarr);
			$result = $this->db->query($SQL);
			return $result->result_array();
		} else if ($act == "history_spk") {
			$dataArr = explode("~", $id);
			$id = $dataArr[0];
			$SQL = "SELECT COUNT(ID_HANDLE) AS JML, B.NAMA, A.ID_HANDLE, A.USER_PRINTS, A.TYPE_RPT
					FROM hist_print A
					LEFT JOIN reff_user B ON A.USER_PRINTS = B.ID
					where A.ID_HANDLE = '" . $id . "' AND TYPE_RPT = 'cetak_spk'
					GROUP BY USER_PRINTS ";
			$result = $this->db->query($SQL);
			return $result->result_array();
		} elseif ($act == 'cetak_spk') {
			$SQL = "SELECT A.NO_SPK, DATE_FORMAT(A.TGL_SPK,'%d-%m-%Y') AS 'TGL_SPK',
			A.NO_DOK, C.NAMA AS JENIS_DOKUMEN, B.NO_CONT, B.UKR_CONT , D.LNSW_NOAJU,D.LNSW_TGLAJU
			FROM t_spk A
			join t_spk_cont B ON A.ID = B.ID
			join reff_kode_dok_bc C ON A.JNS_DOK = C.ID
			LEFT JOIN (SELECT * from t_ppk_hdr WHERE LNSW_KD_RESPON = '005') D ON A.NO_DOK = D.NO_RESPON and A.TGL_DOK = D.TG_RESPON
			WHERE A.ID = '$id'";
			$result = $func->main->get_result($SQL);


			if ($result) {
				foreach ($SQL->result_array() as $row => $value) {
					$arrdata[] = $value;
				}
				$arrHist['ID_HANDLE'] = $arrdata[0]['NO_SPK'];
				$arrHist['TYPE_RPT'] = 'cetak_spk';
				$arrHist['USER_PRINTS'] = $this->session->userdata("ID");
				$arrHist['DATE_PRINTS'] = date('Y-m-d H:i:s');
				$this->db->insert('hist_print', $arrHist);
				return $arrdata;
			} else {
				redirect(site_url(), 'refresh');
			}
		} else if ($act == "history_gbe") {
			$SQL = "SELECT COUNT(ID_HANDLE) AS JML, B.NAMA, A.ID_HANDLE, A.USER_PRINTS, A.TYPE_RPT
					FROM hist_print A
					LEFT JOIN reff_user B ON A.USER_PRINTS = B.ID
					where A.ID_HANDLE = '" . $id . "' AND TYPE_RPT = 'cetak_gbe'
					GROUP BY USER_PRINTS ";
			$result = $this->db->query($SQL);
			return $result->result_array();
		} else if ($act == 'lokasi') {
			$SQL_ID_JOB = "SELECT * FROM t_job_slip WHERE ID_JOB_SLIP = '$id'";
			$RESULTID = $this->db->query($SQL_ID_JOB)->result_array();

			$NO_GATEPASS = count($RESULTID[0]['NO_GATEPASS']);
			if ($NO_GATEPASS != 0) {
				$SQL = "SELECT A.NO_SPK,A.NO_DOK, B.UKR_CONT, C.*, D.JNS_KEGIATAN, D.ID
						FROM t_spk A
						INNER JOIN t_spk_cont B ON A.ID = B.ID
						INNER JOIN t_job_slip C ON A.NO_SPK = C.NO_SPK
						INNER JOIN t_gatepass D ON D.NO_CONT = B.NO_CONT AND D.JNS_KEGIATAN IS NOT NULL AND C.NO_GATEPASS = D.ID
						WHERE C.ID_JOB_SLIP = '$id' AND C.JNS_JOB_SLIP IS NOT NULL
						GROUP BY A.NO_SPK";
			} else {
				$SQL = "SELECT A.NO_SPK,A.NO_DOK, B.UKR_CONT, C.*, D.JNS_KEGIATAN, D.ID
						FROM t_spk A
						INNER JOIN t_spk_cont B ON A.ID = B.ID
						INNER JOIN t_job_slip C ON A.NO_SPK = C.NO_SPK
						LEFT JOIN t_gatepass D ON D.NO_CONT = B.NO_CONT
						WHERE C.ID_JOB_SLIP = '$id' AND C.JNS_JOB_SLIP IS NOT NULL
						GROUP BY A.NO_SPK";
			}

			$result = $func->main->get_result($SQL);
			if ($result) {
				foreach ($SQL->result_array() as $row => $value) {
					$arrdata = $value;
				}
				return $arrdata;
			} else {
				redirect(site_url(), 'refresh');
			}
		} else if ($act == 'lokasi_denah') {
			$getJobSlip = "SELECT * FROM t_job_slip WHERE ID_JOB_SLIP = '$id'";
			$resultJob = $this->db->query($getJobSlip)->result_array();

			if (@$resultJob[0]['JENIS'] == 'EX BEHANDLE 1' || @$resultJob[0]['JENIS'] == 'EX BEHANDLE 2') {
				$SQL = "SELECT * FROM reff_gudang_dtl WHERE KD_GUDANG_DTL IN('1A')";
			} elseif (@$resultJob[0]['JENIS'] == 'BEHANDLE 1' && @$resultJob[0]['LOKASI_AWAL'] != "") {
				$SQL = "SELECT * FROM reff_gudang_dtl WHERE KD_GUDANG_DTL = 'CIC'";
			} elseif (@$resultJob[0]['JENIS'] == 'PICKUP') {
				$SQL = "SELECT * FROM reff_gudang_dtl WHERE KD_GUDANG_DTL = '1B'";
			} elseif (@$resultJob[0]['JENIS'] == 'BEHANDLE 1' && @$resultJob[0]['LOKASI_AWAL'] == "") {
				$SQL = "SELECT * FROM reff_gudang_dtl WHERE KD_GUDANG_DTL = '1B'";
			} elseif (@$resultJob[0]['JENIS'] == 'BEHANDLE 2' && @$resultJob[0]['LOKASI_AWAL'] != "") {
				$SQL = "SELECT * FROM reff_gudang_dtl WHERE KD_GUDANG_DTL = 'CIC'";
			} else {
				$SQL = "SELECT * FROM reff_gudang_dtl";
			}

			$result = $this->db->query($SQL);
			return $result->result_array();
		} else if ($act == 'totalCont') {
			$SQL = "select count(*) as tier, ifnull(b.total,0) as total, ifnull(b.LOKASI," . $this->db->escape($id) . ") as 	lokasi from (
					select a.LOKASI, count(*) as total
					from t_spk_cont a 
					where a.LOKASI = " . $this->db->escape($id) . "
					and a.STATUS_CONT IN('450','460')
					group by a.LOKASI
					) b left join t_denah_lapangan c on c.LEVEL_1 = b.LOKASI";

			$SQL = "select a.tier, ifnull(count(*),0) as total, ifnull(b.LOKASI,'-') as lokasi from (
					select nm_blok,count(*) as tier 
					from t_denah_lapangan
					where nm_blok = " . $this->db->escape($id) . "
					group by LOKASI
					) a
					left join t_spk_cont b on b.LOKASI= a.nm_blok				
					where b.LOKASI = " . $this->db->escape($id) . " and b.STATUS_CONT IN('450','460')
					group by b.LOKASI,a.tier,b.LOKASI";

			$result = $this->db->query($SQL);
			return $result->result_array();
		}
	}

	public function spk_list($act, $id)
	{
		$page_title = 'SPK BEHANDLE';
		$title = "SPK";
		$this->newtable->breadcrumb('SPK Behandle', site_url(), 'icon-home');
		$this->newtable->breadcrumb('PLANNING', 'javascript:void(0)', '');
		$this->newtable->breadcrumb('SPK Behandle', 'javascript:void(0)', '');
		$check = (grant() == "W") ? true : false;

		$SQL = "SELECT A.ID AS 'ID', A.NO_SPK AS 'NO. SPK',
		DATE_FORMAT(A.WK_REQ, '%d-%m-%Y %H:%i:%s') AS 'WK_REQ',C.NAMA AS 'JENIS DOKUMEN', 
		CONCAT(A.NO_DOK,'<BR>', (DATE_FORMAT(A.TGL_DOK, '%d-%m-%Y'))) AS 'NO. DOKUMEN', 
		CONCAT('<span class=\"label label-success\">TOTAL KONTAINER: ',(SELECT COUNT(B.NO_CONT) FROM t_spk_cont B WHERE B.ID = A.ID),'</span><br><span class=\"label label-danger\">PICKUP: ',(SELECT count(C.STATUS_CONT) FROM t_spk_cont C WHERE C.ID = A.ID AND C.STATUS_CONT IN('50','200','300','400','450','460', '500', '600')),'</span')  AS 'JUMLAH KONTAINER', 
		CONCAT('<span style=\"color:green;font-weight:bold\">', B.KETERANGAN,'</span>') AS 'STATUS',
		case when D.LNSW_TGLAJU IS NOT NULL then CONCAT(D.LNSW_NOAJU,'<BR>',D.LNSW_TGLAJU) else '-' END AS 'DOKUMEN JOIN INSPECTION'
		FROM t_spk A 
		join reff_status_spk B ON B.ID = A.KD_STATUS 
		JOIN reff_kode_dok_bc C ON A.JNS_DOK = C.ID
		LEFT join (SELECT * from t_ppk_hdr WHERE LNSW_KD_RESPON = '005') D ON A.no_dok = D.no_respon AND A.tgl_dok = D.tg_respon
		WHERE YEAR(TGL_SPK) >= 2020";

		$proses = array(
			'CREATE SPK'  => array('GET', site_url() . "/planning/spk/spk_create", '0', '', 'md-plus-circle', '', 'menu'),
			'ANNOUNCEMENT SPK' => array('POST', "planning/spk/spk_announcement", '1', '', 'md-mail-send', '', 'list'),
			'CETAK SPK' => array('PRINT', "planning/spk/spk_cetak", '1', '', 'md-print', '', 'list'),
			'HISTORY' => array('MODAL', "planning/spk/spk_history", '1', '', 'md-watch', '', 'list'),
			'DELETE'  => array('DELETE', "planning/spk/spk_delete", '1', '', 'md-close-circle', '', 'menu')
		);

		$this->newtable->multiple_search(true);
		$this->newtable->show_chk(true);
		$this->newtable->show_menu($check);
		$this->newtable->show_search(true);
		$arr_sts = array("" => "", "WAITING" => "WAITING", "ANNOUNCE" => "ANNOUNCE", "PICKUP" => "PICKUP", "BEHANDLE" => "BEHANDLE IN", "HOLD" => "HOLD", "RELEASE" => "RELEASE");
		$this->newtable->search(array(array('NO_DOK', 'NO. DOKUMEN'), array('NO_SPK', 'NO. SPK'), array('KETERANGAN', 'STATUS', 'OPTION', $arr_sts)));
		$this->newtable->action(site_url() . "/planning/spk");
		$this->newtable->detail(array('POPUP', "planning/spk/spk_detail"));
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("ID"));
		$this->newtable->keys(array("ID", "NO. SPK"));
		$this->newtable->validasi(array("NO. SPK"));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby('A.WK_REQ DESC');
		$this->newtable->sortby("");
		$this->newtable->set_formid("tblspk");
		$this->newtable->set_divid("divtblspk");
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

	public function spk_create($act, $id)
	{
		$page_title = 'SPK BEHANDLE';
		$title = "CREATE SPK";
		$this->newtable->breadcrumb('SPK Behandle', site_url(), 'icon-home');
		$this->newtable->breadcrumb('PLANNING', 'javascript:void(0)', '');
		$this->newtable->breadcrumb('SPK Behandle', 'javascript:void(0)', '');
		$check = (grant() == "W") ? true : false;

		$SQL = "SELECT DISTINCT A.ID, A.NO_DOK AS 'NO DOKUMEN', CASE WHEN C.ID != 'sppmp' THEN C.NAMA ELSE 'SPPMP' END AS 'JENIS DOKUMEN', TGL_DOK AS 'TGL. DOKUMEN' 
				FROM t_request A 
				INNER JOIN t_request_cont B ON A.ID = B.ID 
				INNER JOIN reff_kode_dok_bc C ON A.JNS_DOK = C.ID WHERE B.FLAG_STATUS = 'N' AND A.WK_SEND IS NOT NULL";

		$this->newtable->multiple_search(true);
		$this->newtable->show_chk(false);
		$this->newtable->show_menu($check);
		$this->newtable->show_search(true);
		$arr_sts = array("" => "", "19" => "SPJM", "SPPMP" => "SPPMP");
		$this->newtable->search(array(array('NO_DOK', 'NO. DOKUMEN'), array('JNS_DOK', 'JENIS DOKUMEN', 'OPTION', $arr_sts)));
		$this->newtable->action(site_url() . "/planning/spk/spk_create");
		if ($check) $this->newtable->detail(array('GET', site_url() . "/planning/spk/spk_add_cont"));
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("ID"));
		$this->newtable->keys(array("ID"));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby(1);
		$this->newtable->groupby();
		$this->newtable->sortby("DESC");
		$this->newtable->set_formid("tblspkDok");
		$this->newtable->set_divid("divtblspkDok");
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

	public function spk_add_cont($act, $id)
	{
		$func = get_instance();
		$func->load->model("m_main", "main", true);
		$page_title = 'SPK BEHANDLE';
		$title = "CREATE SPK CONTAINER";
		$this->newtable->breadcrumb('SPK Behandle', site_url(), 'icon-home');
		$this->newtable->breadcrumb('PLANNING', 'javascript:void(0)', '');
		$this->newtable->breadcrumb('SPK Behandle', 'javascript:void(0)', '');
		$check = (grant() == "W") ? true : false;

		$SQL = "SELECT DISTINCT a.ID, a.NO_CONT AS 'NO KONTAINER', a.UKR_CONT AS 'UKURAN KONTAINER',a.BRUTO,b.FL_PERIKSA
		FROM t_request_cont a
		LEFT JOIN t_permit_cont b on a.NO_CONT = b.NO_CONT
		WHERE a.ID = '$id' AND a.FLAG_STATUS = 'N'";

		$proses = array('SAVE SPK'  => array('POST', "planning/spk/spk_save", '0', '', 'md-plus-circle', '', 'menu'));

		$this->newtable->multiple_search(true);
		$this->newtable->show_chk(true);
		$this->newtable->show_menu(true);
		$this->newtable->show_search(true);
		$this->newtable->search(array(array('NO_CONT', 'NO. KONTAINER')));
		$this->newtable->action(site_url() . "/planning/spk/spk_add_cont/" . $id);
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("ID", "KODE DOKUMEN"));
		$this->newtable->keys(array("ID", "NO KONTAINER", "UKURAN KONTAINER"));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby(1);
		$this->newtable->sortby("DESC");
		$this->newtable->set_formid("tbldetailSpkCont");
		$this->newtable->set_divid("divtbldetailSpkCont");
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

	public function spk_save($act, $id)
	{
		$func = get_instance();
		$func->load->model("m_main", "main", true);
		$success = 0;
		$error = 0;

		foreach ($this->input->post('tb_chktbldetailSpkCont') as $Arrrow) {
			$arrid = explode('~', $Arrrow);
			$idpost = $arrid[0];
			$no_cont = $arrid[1];
		}

		$SQL = "SELECT DISTINCT A.JNS_DOK, A.NO_DOK, A.TGL_DOK, A.NPWP, A.CONSIGNEE, IFNULL(B.ANGKUTNAMA_TPS,C.ANGKUTNAMA) AS NM_KAPAL, IFNULL(B.ANGKUTNO_TPS,C.ANGKUTNO) AS VOYAGE
				FROM t_request A
				LEFT JOIN t_permit_hdr B ON B.KD_DOK_INOUT=A.JNS_DOK AND B.NO_DAFTAR_PABEAN=A.NO_DOK AND B.TGL_DAFTAR_PABEAN=A.TGL_DOK
				LEFT JOIN t_ppk_hdr C ON C.NO_DAFTPPK=A.NO_DOK AND C.TG_DAFTPPK=A.TGL_DOK AND A.JNS_DOK='sppmp'
				WHERE A.ID = '" . $idpost . "'";
		$result = $func->main->get_result($SQL);
		if ($result) {
			foreach ($SQL->result_array() as $row => $value) {
				$arrdata = $value;
			}
			$seq = $this->db->query("SELECT MAX(id) AS 'urut' FROM t_spk_temporary")->row()->urut;
			$norut = $seq + 1;
			$NO_SPK = "MTI-" . substr(date('Y'), 2) . "/" . $norut;
			$data['NO_SPK'] = $NO_SPK;
			$data['NM_KAPAL'] = $arrdata['NM_KAPAL'];
			$data['NO_VOY'] = $arrdata['VOYAGE'];
			$data['TGL_SPK'] = date('Y-m-d');
			$data['JNS_DOK'] = $arrdata['JNS_DOK'];
			$data['NO_DOK'] = $arrdata['NO_DOK'];
			$data['TGL_DOK'] = $arrdata['TGL_DOK'];
			$data['NPWP'] = $arrdata['NPWP'];
			$data['CONSIGNEE'] = $arrdata['CONSIGNEE'];
			$data['WK_REQ'] = date('Y-m-d H:i:s');
			$data['KD_STATUS'] = '000';

			$this->db->insert('t_spk', $data);
			$id_req = $this->db->insert_id();

			$CKJNS_DOK = $arrdata['JNS_DOK'];
			$cekdok = $this->db->query("SELECT NAMA FROM reff_kode_dok_bc WHERE ID='$CKJNS_DOK'")->row()->NAMA;

			$temp['keterangan'] = $NO_SPK;
			$temp['operator'] = $this->session->userdata('USERLOGIN');
			$this->db->insert('t_spk_temporary', $temp);

			foreach ($this->input->post('tb_chktbldetailSpkCont') as $row) {
				$arrid = explode('~', $row);
				$id_cont = $arrid[0];
				$no_cont = $arrid[1];
				$uk_cont = $arrid[2];

				$dataCont['ID'] = $id_req;
				$dataCont['NO_CONT'] = $no_cont;
				$dataCont['UKR_CONT'] = $uk_cont;
				$res_cont = $this->db->insert('t_spk_cont', $dataCont);
				if ($res_cont) {
					$this->db->where(array('ID' => $id_cont, 'NO_CONT' => $no_cont));
					$this->db->update('t_request_cont', array('FLAG_STATUS' => 'Y'));

					//  INSERT JOB
					$dataJob['JNS_JOB_SLIP'] = 'MARSHALLING';
					$dataJob['JENIS'] = 'PICKUP';
					$dataJob['NO_SPK'] = $NO_SPK;
					$dataJob['TGL_SPK'] = date('Y-m-d');
					$dataJob['JNS_DOK'] =  $cekdok;
					$dataJob['NO_DOK'] = $arrdata['NO_DOK'];
					$dataJob['NO_CONT'] = $no_cont;
					$dataJob['STATUS'] = 'WAITING';
					$dataJob['KD_STATUS'] = '00';
					$dataJob['WK_STATUS'] = date('Y-m-d H:i:s');
					$this->db->insert('t_job_slip', $dataJob);
					var_dump($dataJob);
				} else {
					$error += 1;
					$message = "Error, Insert Detail Container Failed";
				}

				$SQLReport = $this->db->query("SELECT * FROM report_behandle WHERE NO_CONT='" . $no_cont . "' AND REQ_NO_DOK='" . $arrdata['NO_DOK'] . "' ORDER BY ID DESC")->result_array();
				if (count($SQLReport) > 0) {
					$updateReport = array(
						'REQ_JNS_DOK' 		=> $arrdata['JNS_DOK'],
						'REQ_NO_DOK' 		=> $arrdata['NO_DOK'],
						'REQ_TGL_DOK' 		=> $arrdata['TGL_DOK'],
						'REQ_CUSTOMER' 		=> $arrdata['CONSIGNEE'],
						'NO_CONT' 			=> $no_cont,
						'RB1_NO_SPK' 		=> $NO_SPK,
						'RB1_TERBIT_SPK' 	=> date('Y-m-d')
					);
					$this->db->where(array('ID' => $SQLReport[0]['ID'], 'NO_CONT' => $no_cont));
					$this->db->update('report_behandle', $updateReport);
				} else {
					$insertReport = array(
						'REQ_JNS_DOK' 		=> $arrdata['JNS_DOK'],
						'REQ_NO_DOK' 		=> $arrdata['NO_DOK'],
						'REQ_TGL_DOK' 		=> $arrdata['TGL_DOK'],
						'REQ_CUSTOMER' 		=> $arrdata['CONSIGNEE'],
						'NO_CONT' 			=> $no_cont,
						'RB1_NO_SPK' 		=> $NO_SPK,
						'RB1_TERBIT_SPK' 	=> date('Y-m-d')
					);
					$this->db->insert('report_behandle', $insertReport);
				}
			}
		} else {
			$error += 1;
			$message = "Error, Document Not Founds";
		}
		if ($error == 0) {
			$action = '/planning/spk/post';
			echo "MSG#OK#Data berhasil diproses#" . site_url() . $action;
		} else {
			echo "MSG#ERR#" . $message . "#";
		}
	}

	/** Old Function */
	public function spk_announcement($id, $spk)
	{
		$error = 0;
		$cek 	= $this->db->query("SELECT B.LOKASI FROM t_spk A inner join t_spk_cont B on A.ID = B.ID where A.ID = '$id' AND A.NO_SPK='$spk'")->result_array();
		$cek2 	= $this->db->query("SELECT A.KD_STATUS FROM t_spk A where A.ID = '$id' AND A.NO_SPK='$spk'")->result_array();

		$lokasi = 0;
		for ($a = 0; $a < count($cek); $a++) {
			if ($cek[$a]['LOKASI'] == '') {
				$lokasi++;
			}
		}

		if (count($cek) == 0) {
			$lokasi = 1;
		}

		if ($cek2[0]['KD_STATUS'] != '000' && $cek2[0]['KD_STATUS'] != '100') {
			$message = "KONTAINER SUDAH PROSES PICKUP";
			echo "MSG#ERR#" . $message . "#";
		} else if ($lokasi > 0) {
			$message = "LOKASI KONTAINER BELUM DI PLANNING";
			echo "MSG#ERR#" . $message . "#";
		} else {
			$SQL = $this->db->query("SELECT A.NO_SPK, C.NAMA AS 'DOK', A.NO_DOK, A.TGL_DOK, B.NO_CONT, A.NPWP, A.CONSIGNEE 
					FROM t_spk A 
					INNER JOIN t_spk_cont B ON A.ID = B.ID 
					INNER JOIN reff_kode_dok_bc C ON C.ID = A.JNS_DOK WHERE A.ID ='$id' AND A.NO_SPK='$spk'")->row();

			// $SQL2 = $this->db->query("SELECT A.NO_SPK, CASE WHEN A.JNS_DOK = 19 THEN 'SPJM' ELSE 'SPPMP' END AS 'DOK', A.TGL_DOK, B.NO_CONT FROM t_spk A
			// 		INNER JOIN t_spk_cont B ON A.ID = B.ID WHERE A.ID = B.ID AND A.ID = '$id'")->result_array();
			// for ($i = 0; $i < count($SQL2); $i++) {
			// 	$tr .= '
			// 		<tr>
			// 			<td>' . $SQL2[$i]["NO_SPK"] . '</td>
			// 			<td>' . $SQL2[$i]["NO_CONT"] . '</td>
			// 		</tr>
			// 	';
			// }

			// $email2 = $this->db->query("SELECT EMAIL,KEGIATAN FROM reff_mail WHERE KEGIATAN = 'ANNOUNCE'")->result_array();

			// $subject = "SPK PENARIKAN BEHANDLE - [" . $SQL->CONSIGNEE . "]";
			// $this->load->helper('email');
			// $email_success = 0;
			// $config = array(
			// 	'protocol'  => 'smtp',
			// 	'smtp_host' => 'mail2.edi-indonesia.co.id',
			// 	'smtp_port' => 25,
			// 	'smtp_user' => '',
			// 	'smtp_pass' => '',
			// 	'smtp_timeout' => 30,
			// 	'mailtype'  => 'html',
			// 	'charset'   => 'iso-8859-1',
			// 	'wrapchars' => 100,
			// 	'crlf'         => "\r\n",
			// 	'newline'     => "\r\n",
			// 	'start_tls' => TRUE
			// );
			// $msg = '<!DOCTYPE html>
			// 		<html lang="en">
			// 			<head>
			// 				<meta charset="UTF-8">
			// 				<title>Document</title>
			// 				<style>
			// 					img {
			// 						width: 100px;
			// 					}
			// 					.table1 {
			// 						width: 100%;
			// 					}
			// 					.table2 {
			// 						width: 80%;
			// 						border: 1px solid #000000;
			// 					}
			// 				</style>
			// 			</head>

			// 			<body>
			// 				<div>
			// 					<p>
			// 						Dengan Hormat,<br><br>
			// 						Bersama ini kami informasikan bahwa saat ini akan dilakukan pick up container
			// 						untuk kebutuhan pemeriksaan (behandle) dengan data sebagai berikut :
			// 					</p>
			// 					<table class="table1">
			// 						<tr>
			// 							<td>Jenis Dokumen
			// 							</td>
			// 							<td>:</td>
			// 							<td>' . $SQL->DOK . '</td>
			// 						</tr>
			// 						<tr>
			// 							<td>No./Tgl Dok
			// 							</td>
			// 							<td>:</td>
			// 							<td>' . $SQL->NO_DOK . '/' . $SQL->TGL_DOK . '</td>
			// 						</tr>
			// 					</table><br><br>
			// 					<table class="table2">
			// 						<tr>
			// 							<th>No. SPK</th>
			// 							<th>Nomor Kontainer</th>
			// 						</tr>
			// 						' . $tr . '
			// 					</table><br>
			// 					<div>
			// 						Atas perhatian dan kerjasamanya kami ucapkan terima kasih.<br><br>
			// 						=================================================================================<br><br>
			// 						<table>
			// 							<tr>
			// 								<td>
			// 									<img
			// 										src="https://bos.ipclogistic.co.id/tpk_ipc/cgis/assets/images/Logomti.png"
			// 										alt="">
			// 								</td>
			// 								<td>
			// 									<div style="color:#050567" align="justify">
			// 										This message was delivered by BOS - PT. MTI. You are receiving this message
			// 										because your email address are registered in our user database. If you have any
			// 										question or information regarding this message, or if you do not want to receive
			// 										any notifications in the future, please contact our Customer Care officer.
			// 									</div>
			// 								</td>
			// 							</tr>
			// 						</table>
			// 					</div>
			// 				</div>
			// 			</body>
			// 		</html>';
			// $emailcustomrr = array('SYARIFHIDAYAT718@GMAIL.COM', 'GATE@NPCT1.CO.ID', 'YAYANCHY@GMAIL.COM');
			// $this->load->library('email', $config);
			// $this->email->from('automail@multiterminal.co.id', 'BOS NOTIFICATION - ANNOUNCEMENT');
			// $email = str_replace(';', ',', $email);
			// $this->email->to($emailcustomrr);
			// $this->email->subject($subject);
			// $this->email->message($msg);

			// if ($this->email->send()) {
			$email_success = 1;
			echo " Email Terkirim " . $id . " - " . $spk . " - " . $SQL->CONSIGNEE;
			$this->db->where(array('ID' => $id));
			$this->db->update('t_spk', array('KD_STATUS' => '100'));

			$this->db->where(array('ID' => $id));
			$this->db->update('t_spk_cont', array('STATUS_CONT' => '100'));
			// } else {
			// 	echo 'email tidak terkirim';
			// 	$this->db->where(array('ID' => $id));
			// 	$this->db->update('t_spk', array('KD_STATUS' => '100'));

			// 	$this->db->where(array('ID' => $id));
			// 	$this->db->update('t_spk_cont', array('STATUS_CONT' => '100'));
			// }
		}

		if ($error == 0) {
			$action = '/planning/spk/post';
			echo "MSG#OK#DATA BERHASIL DI PROSES#" . site_url() . $action;
		} else {
			echo "MSG#ERR#" . $message . "#";
		}
	}

	/** New function spk_announcement */
	// public function spk_announcement($id, $spk)
	// {
	// 	$error   = 0;
	// 	$message = '';

	// 	// =========================================================
	// 	// QUERY VALIDASI SPK + LOKASI CONTAINER
	// 	// =========================================================
	// 	$cek = $this->db->query("
	//       SELECT 
	//           A.KD_STATUS,
	//           B.LOKASI
	//       FROM t_spk A
	//       INNER JOIN t_spk_cont B ON A.ID = B.ID
	//       WHERE A.ID = ?
	//       AND A.NO_SPK = ?
	//   ", [$id, $spk])->result_array();

	// 	// =========================================================
	// 	// VALIDASI DATA
	// 	// =========================================================
	// 	if (empty($cek)) {

	// 		$message = "LOKASI KONTAINER BELUM DI PLANNING";
	// 		echo "MSG#ERR#" . $message . "#";
	// 		return;
	// 	}

	// 	$kd_status = $cek[0]['KD_STATUS'];

	// 	// =========================================================
	// 	// VALIDASI STATUS PICKUP
	// 	// =========================================================
	// 	if ($kd_status != '000' && $kd_status != '100') {

	// 		$message = "KONTAINER SUDAH PROSES PICKUP";
	// 		echo "MSG#ERR#" . $message . "#";
	// 		return;
	// 	}

	// 	// =========================================================
	// 	// VALIDASI LOKASI CONTAINER
	// 	// =========================================================
	// 	foreach ($cek as $row) {

	// 		if (trim($row['LOKASI']) == '') {

	// 			$message = "LOKASI KONTAINER BELUM DI PLANNING";
	// 			echo "MSG#ERR#" . $message . "#";
	// 			return;
	// 		}
	// 	}

	// 	// =========================================================
	// 	// QUERY HEADER EMAIL
	// 	// =========================================================
	// 	// $SQL = $this->db->query("
	// 	//     SELECT 
	// 	//         A.NO_SPK,
	// 	//         C.NAMA AS DOK,
	// 	//         A.NO_DOK,
	// 	//         A.TGL_DOK,
	// 	//         B.NO_CONT,
	// 	//         A.NPWP,
	// 	//         A.CONSIGNEE
	// 	//     FROM t_spk A
	// 	//     INNER JOIN t_spk_cont B ON A.ID = B.ID
	// 	//     INNER JOIN reff_kode_dok_bc C ON C.ID = A.JNS_DOK
	// 	//     WHERE A.ID = ?
	// 	//     AND A.NO_SPK = ?
	// 	//     LIMIT 1
	// 	// ", [$id, $spk])->row();

	// 	// =========================================================
	// 	// QUERY DETAIL CONTAINER
	// 	// =========================================================
	// 	// $SQL2 = $this->db->query("
	// 	//     SELECT 
	// 	//         A.NO_SPK,
	// 	//         CASE 
	// 	//             WHEN A.JNS_DOK = 19 THEN 'SPJM'
	// 	//             ELSE 'SPPMP'
	// 	//         END AS DOK,
	// 	//         A.TGL_DOK,
	// 	//         B.NO_CONT
	// 	//     FROM t_spk A
	// 	//     INNER JOIN t_spk_cont B ON A.ID = B.ID
	// 	//     WHERE A.ID = ?
	// 	// ", [$id])->result_array();

	// 	// =========================================================
	// 	// GENERATE HTML TABLE CONTAINER
	// 	// =========================================================
	// 	// $tr = '';

	// 	// foreach ($SQL2 as $row) {

	// 	// 	$tr .= '
	// 	//         <tr>
	// 	//             <td>' . $row["NO_SPK"] . '</td>
	// 	//             <td>' . $row["NO_CONT"] . '</td>
	// 	//         </tr>
	// 	//     ';
	// 	// }

	// 	// #################################################################
	// 	// ##################### START EMAIL LOGIC ##########################
	// 	// #################################################################

	// 	// =========================================================
	// 	// QUERY EMAIL ANNOUNCEMENT
	// 	// =========================================================
	// 	// $email2 = $this->db->query("
	// 	//     SELECT EMAIL, KEGIATAN
	// 	//     FROM reff_mail
	// 	//     WHERE KEGIATAN = 'ANNOUNCE'
	// 	// ")->result_array();

	// 	// =========================================================
	// 	// EMAIL CONFIGURATION
	// 	// =========================================================
	// 	// $subject = "SPK PENARIKAN BEHANDLE - [" . $SQL->CONSIGNEE . "]";

	// 	// $this->load->helper('email');

	// 	// $config = array(
	// 	// 	'protocol'      => 'smtp',
	// 	// 	'smtp_host'     => 'mail2.edi-indonesia.co.id',
	// 	// 	'smtp_port'     => 25,
	// 	// 	'smtp_user'     => '',
	// 	// 	'smtp_pass'     => '',
	// 	// 	'smtp_timeout'  => 30,
	// 	// 	'mailtype'      => 'html',
	// 	// 	'charset'       => 'iso-8859-1',
	// 	// 	'wrapchars'     => 100,
	// 	// 	'crlf'          => "\r\n",
	// 	// 	'newline'       => "\r\n",
	// 	// 	'start_tls'     => TRUE
	// 	// );

	// 	// =========================================================
	// 	// EMAIL BODY
	// 	// =========================================================
	// 	// $msg = '
	// 	// <!DOCTYPE html>
	// 	// <html lang="en">
	// 	//     <head>
	// 	//         <meta charset="UTF-8">
	// 	//         <title>Document</title>

	// 	//         <style>
	// 	//             img {
	// 	//                 width: 100px;
	// 	//             }

	// 	//             .table1 {
	// 	//                 width: 100%;
	// 	//             }

	// 	//             .table2 {
	// 	//                 width: 80%;
	// 	//                 border: 1px solid #000000;
	// 	//             }
	// 	//         </style>
	// 	//     </head>

	// 	//     <body>

	// 	//         <div>

	// 	//             <p>
	// 	//                 Dengan Hormat,<br><br>

	// 	//                 Bersama ini kami informasikan bahwa saat ini akan dilakukan
	// 	//                 pick up container untuk kebutuhan pemeriksaan (behandle)
	// 	//                 dengan data sebagai berikut :
	// 	//             </p>

	// 	//             <table class="table1">

	// 	//                 <tr>
	// 	//                     <td>Jenis Dokumen</td>
	// 	//                     <td>:</td>
	// 	//                     <td>' . $SQL->DOK . '</td>
	// 	//                 </tr>

	// 	//                 <tr>
	// 	//                     <td>No./Tgl Dok</td>
	// 	//                     <td>:</td>
	// 	//                     <td>' . $SQL->NO_DOK . '/' . $SQL->TGL_DOK . '</td>
	// 	//                 </tr>

	// 	//             </table>

	// 	//             <br><br>

	// 	//             <table class="table2">

	// 	//                 <tr>
	// 	//                     <th>No. SPK</th>
	// 	//                     <th>Nomor Kontainer</th>
	// 	//                 </tr>

	// 	//                 ' . $tr . '

	// 	//             </table>

	// 	//             <br>

	// 	//             <div>

	// 	//                 Atas perhatian dan kerjasamanya kami ucapkan terima kasih.

	// 	//                 <br><br>

	// 	//                 =================================================================================

	// 	//                 <br><br>

	// 	//                 <table>

	// 	//                     <tr>

	// 	//                         <td>
	// 	//                             <img
	// 	//                                 src="https://bos.ipclogistic.co.id/tpk_ipc/cgis/assets/images/Logomti.png"
	// 	//                                 alt="">
	// 	//                         </td>

	// 	//                         <td>

	// 	//                             <div style="color:#050567" align="justify">

	// 	//                                 This message was delivered by BOS - PT. MTI.
	// 	//                                 You are receiving this message because your
	// 	//                                 email address are registered in our user database.

	// 	//                                 If you have any question or information regarding
	// 	//                                 this message, or if you do not want to receive
	// 	//                                 any notifications in the future, please contact
	// 	//                                 our Customer Care officer.

	// 	//                             </div>

	// 	//                         </td>

	// 	//                     </tr>

	// 	//                 </table>

	// 	//             </div>

	// 	//         </div>

	// 	//     </body>

	// 	// </html>';

	// 	// =========================================================
	// 	// EMAIL RECEIVER
	// 	// =========================================================
	// 	// $emailcustomrr = array(
	// 	// 	'SYARIFHIDAYAT718@GMAIL.COM',
	// 	// 	'GATE@NPCT1.CO.ID',
	// 	// 	'YAYANCHY@GMAIL.COM'
	// 	// );

	// 	// =========================================================
	// 	// INITIALIZE EMAIL LIBRARY
	// 	// =========================================================
	// 	// $this->load->library('email', $config);

	// 	// $this->email->from(
	// 	// 	'automail@multiterminal.co.id',
	// 	// 	'BOS NOTIFICATION - ANNOUNCEMENT'
	// 	// );

	// 	// $this->email->to($emailcustomrr);
	// 	// $this->email->subject($subject);
	// 	// $this->email->message($msg);

	// 	// =========================================================
	// 	// SEND EMAIL
	// 	// =========================================================
	// 	// $sendEmail = $this->email->send();

	// 	// =========================================================
	// 	// EMAIL RESULT
	// 	// =========================================================
	// 	// if ($sendEmail) {

	// 	// 	echo " Email Terkirim "
	// 	// 		. $id . " - "
	// 	// 		. $spk . " - "
	// 	// 		. $SQL->CONSIGNEE;
	// 	// } else {

	// 	// 	echo "email tidak terkirim";

	// 	// 	// Uncomment untuk debug SMTP
	// 	// 	// echo $this->email->print_debugger();
	// 	// }

	// 	// #################################################################
	// 	// ###################### END EMAIL LOGIC ###########################
	// 	// #################################################################

	// 	// =========================================================
	// 	// UPDATE STATUS SPK
	// 	// =========================================================
	// 	$this->db->where('ID', $id);
	// 	$this->db->update('t_spk', array(
	// 		'KD_STATUS' => '100'
	// 	));

	// 	// =========================================================
	// 	// UPDATE STATUS CONTAINER
	// 	// =========================================================
	// 	$this->db->where('ID', $id);
	// 	$this->db->update('t_spk_cont', array(
	// 		'STATUS_CONT' => '100'
	// 	));

	// 	// =========================================================
	// 	// FINAL RESPONSE
	// 	// =========================================================
	// 	if ($error == 0) {

	// 		$action = '/planning/spk/post';

	// 		echo "MSG#OK#DATA BERHASIL DI PROSES#" . site_url() . $action;
	// 	} else {

	// 		echo "MSG#ERR#" . $message . "#";
	// 	}
	// }


	public function spk_delete($id, $spk)
	{
		$this->db->delete('t_operation', array('NO_SPK' => $spk));
		$this->db->delete('t_operation_new', array('ID_SPK' => $id));

		$querycekspk = $this->db->query("SELECT a.NO_SPK,a.NO_DOK,b.NO_CONT,b.STATUS_CONT FROM t_spk a
		JOIN t_spk_cont b on a.ID = b.ID AND a.NO_SPK = '$spk' AND b.STATUS_CONT IN ('000','100')")->num_rows();
		if ($querycekspk == 0) {
			echo "MSG#ERR#Data Kontainer Sudah berjalan Dalam Siklus#";
			die();
		}
		$SQL_SPK = "SELECT A.NO_SPK, A.NO_DOK, A.TGL_SPK FROM t_spk A WHERE A.ID='$id' AND A.NO_SPK='$spk'";
		$SQL = $this->db->query($SQL_SPK)->result_array();

		$no_dok = $SQL[0]['NO_DOK'];
		$tgl_spk = $SQL[0]['TGL_SPK'];

		$SQL_JOB = $this->db->query("SELECT ID_JOB_SLIP FROM t_job_slip WHERE NO_SPK='$spk' AND TGL_SPK ='$tgl_spk' AND NO_DOK='$no_dok'")->result_array();
		$row_job = count($SQL_JOB);
		for ($job = 0; $job < $row_job; $job++) {
			$ID_JOB = $SQL_JOB[$job];
			$this->db->delete('t_job_slip_status', array('ID_JOB_SLIP' => $ID_JOB['ID_JOB_SLIP']));
			$this->db->delete('t_job_slip', array('NO_SPK' => $spk, 'TGL_SPK' => $tgl_spk, 'ID_JOB_SLIP' => $ID_JOB['ID_JOB_SLIP'], 'NO_DOK' => $no_dok));
			print_r($this->db->last_query());
		}

		$SQL_PERMIT = $this->db->query("SELECT B.NO_CONT FROM t_request A INNER JOIN t_request_cont B ON A.ID = B.ID WHERE A.NO_DOK='$no_dok'")->result_array();
		$ROW_SQL = count($SQL_PERMIT);
		for ($c = 0; $c < $ROW_SQL; $c++) {
			$NO_CONT_PERMIT = $SQL_PERMIT[$c];
			$this->db->where(array('NO_CONT' => $NO_CONT_PERMIT['NO_CONT']));
			$this->db->update('t_request_cont', array('FLAG_STATUS' => 'N'));
		}

		$this->db->delete('t_spk_cont', array('ID' => $id));
		$exec_t_spk = $this->db->delete('t_spk', array('ID' => $id, 'NO_SPK' => $spk));
		if (!$exec_t_spk) {
			$error += 1;
			$message = "Data gagal diproses";
		}

		if ($error == 0) {
			$action = '/planning/spk/post';
			echo "MSG#OK#Data berhasil dihapus#" . site_url() . $action;
		} else {
			echo "MSG#ERR#Data gagal dihapus#";
		}
	}

	public function shipment($act, $id)
	{
		$page_title = "JADWAL KAPAL";
		$title = "JADWAL KAPAL";
		$this->newtable->breadcrumb('Dashboard', site_url(), 'icon-home');
		$this->newtable->breadcrumb('Planning', 'javascript:void(0)', '');
		$this->newtable->breadcrumb('Jadwal Kapal', 'javascript:void(0)', '');
		$check = (grant() == "W") ? true : false;
		if ($KD_GROUP != "SPA") {
			///$addsql .= " AND A.KD_TPS = ".$this->db->escape($KD_TPS)." AND A.KD_GUDANG = ".$this->db->escape($KD_GUDANG);
		}
		//$SQL = "SELECT ID,NM_KAPAL AS 'NAMA KAPAL', NO_VOYAGE AS 'NO. VOY', ETA, ETD, OPN_STACK AS 'OPEN STACK', ATA, ATD, WK_DISCH AS 'WAKTU DISCHARGE', JMLH_MUAT AS 'JUMLAH MUATAN'  FROM t_jadwal_kapal";
		$SQL = "SELECT ID,NM_KAPAL AS 'NAMA KAPAL', NO_VOYAGE AS 'NO. VOY',
				DATE_FORMAT(ETA, '%d-%m-%Y %H:%i:%s') AS ETA,
				DATE_FORMAT(ETD, '%d-%m-%Y %H:%i:%s') AS ETD, DATE_FORMAT(OPN_STACK, '%d-%m-%Y %H:%i:%s') AS 'OPEN STACK',
				DATE_FORMAT(ATA, '%d-%m-%Y %H:%i:%s') AS ATA, DATE_FORMAT(ATD, '%d-%m-%Y %H:%i:%s') AS ATD, DATE_FORMAT(WK_DISCH, '%d-%m-%Y %H:%i:%s') AS 'WAKTU DISCHARGE', JMLH_MUAT AS 'JUMLAH MUATAN'
				FROM t_jadwal_kapal";
		$proses = array(
			'ENTRY'  => array('MODAL', "planning/shipment/add", '0', '', 'md-plus-circle', '', 'menu'),
			'UPDATE' => array('MODAL', "planning/shipment/update", '1', '', 'md-edit', '', 'list'),
			'REALISASI' => array('MODAL', "planning/shipment/release", '1', '', 'md-refresh-alt', '', 'list'),
			'DELETE'  => array('DELETE', "execute/process/delete/kapal", 'all', '', 'md-close-circle', '', 'menu')
		);
		//'UPLOAD' => array('ADD',site_url()."/coarri/discharge/upload", '','','md-attachment'));
		$this->newtable->multiple_search(true);
		$this->newtable->show_chk($check);
		$this->newtable->show_menu($check);
		$this->newtable->show_search(true);
		$this->newtable->search(array(array('NM_KAPAL', 'NAMA KAPAL'), array('NO_VOYAGE', 'NO. VOYAGE')));
		$this->newtable->action(site_url() . "/planning/shipment");
		if ($check) $this->newtable->detail(array('POPUP', "planning/shipment/detail"));
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("ID"));
		$this->newtable->keys(array("ID"));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby("DATE(ETA)");
		$this->newtable->sortby("DESC");
		$this->newtable->set_formid("tblkapallist");
		$this->newtable->set_divid("divtblkapallist");
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

	public function gate_pass_behandle($act, $id)
	{
		$page_title = "GATE PASS BEHANDLE 1";
		$title = "GATE PASS BEHANDLE 1";
		$this->newtable->breadcrumb('Dashboard', site_url(), 'icon-home');
		$this->newtable->breadcrumb('Planning', 'javascript:void(0)', '');
		$this->newtable->breadcrumb('GATE PASS BEHANDLE 1', 'javascript:void(0)', '');
		$check = (grant() == "W") ? true : false;

		$SQL = "SELECT A.ID AS 'ID',CONCAT(A.NO_CONT ,'<BR>',A.UKR_CONT) AS 'KONTAINER',A.JNS_DOK AS 'JENIS DOKUMEN',
		case when B.LNSW_TGLAJU IS NOT NULL then CONCAT(B.LNSW_NOAJU,'<BR>',B.LNSW_TGLAJU) else '-' END AS 'DOKUMEN JOIN INSPECTION', 
		CONCAT(A.NM_KAPAL ,'<BR>', A.NO_VOY) AS 'NAMA KAPAL', CONCAT(A.NPWP,'<BR>',A.NAMA_CUST) AS 'CUSTOMER', A.WK_REK AS 'WAKTU REKAM',
		CASE WHEN A.WK_ACTIVE IS NOT NULL AND A.FL_ACTIVE = 'Y' THEN '<span class=\"label label-success\">Active</span>'
		WHEN A.WK_ACTIVE IS NULL AND A.FL_ACTIVE = 'N' THEN '<span class=\"label label-danger\">Not Active</span>'
		END AS 'STATUS' 
		FROM t_gatepass A 
		LEFT JOIN (SELECT * from t_ppk_hdr WHERE LNSW_KD_RESPON = '005') B ON A.NO_DOK = B.NO_RESPON AND A.TGL_DOK = B.TG_RESPON
		WHERE A.JNS_KEGIATAN = '1' AND DATE(A.WK_REK) > DATE_ADD(NOW() , INTERVAL -10 MONTH)";

		/*if($this->session->userdata('KD_GROUP')=="SPA"){*/
		$proses = array(
			'ENTRY'  => array('MODAL', "planning/gate_pass_behandle/add", '0', '', 'md-plus-circle', '', 'menu'),
			'CETAK' => array('PRINT', "planning/cetak_gatepass_behandle", '1', '', 'md-print', '', 'list'),
			'HISTORY' => array('MODAL', "planning/gate_pass_behandle/history", '1', '', 'md-watch', '', 'list'),
			'UPDATE' => array('MODAL', "planning/gate_pass_behandle/update_gatepass", '1', '', 'md-edit', '', 'list'),
			'ACTIVE' => array('POST', "planning/gate_pass_behandle/active_gatepass", '1', '', 'md-badge-check', '', 'list2'),
			'DELETE' => array('POST', "planning/gate_pass_behandle/delete_gatepass", '1', '', 'md-close-circle', '', 'menu')
		);
		/*}else{
			$proses = array('ENTRY'  => array('MODAL',"planning/gate_pass_behandle/add", '0','','md-plus-circle','', 'menu'),
											'CETAK' => array('PRINT',"planning/cetak_gatepass_behandle", '1','','md-print','', 'list'),
											'HISTORY' => array('MODAL',"planning/gate_pass_behandle/history", '1', '', 'md-watch','','list'),
											'UPDATE' => array('MODAL',"planning/gate_pass_behandle/update_gatepass", '1','','md-edit','', 'list'),
											'ACTIVE' => array('POST',"planning/gate_pass_behandle/active_gatepass", '1','','md-badge-check','', 'list2'));
		}*/

		$this->newtable->multiple_search(true);
		$this->newtable->show_chk(true);
		$this->newtable->show_menu($check);
		$this->newtable->show_search(true);
		$this->newtable->search(array(array('NO_CONT', 'NO. KONTAINER'), array('NO_DOK', 'NO. DOKUMEN')/*,array('WK_REK','TGL. GATEPASS BEHANDLE','DATERANGE')*/));
		$this->newtable->action(site_url() . "/planning/gate_pass_behandle");
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("ID"));
		$this->newtable->keys(array("ID"));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby("ID");
		$this->newtable->sortby("DESC");
		$this->newtable->set_divid("divgate");
		$this->newtable->set_formid("tblgate");
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

	public function gate_pass_behandle2($act, $id)
	{
		$page_title = "GATE PASS BEHANDLE 2";
		$title = "GATE PASS BEHANDLE 2";
		$this->newtable->breadcrumb('Dashboard', site_url(), 'icon-home');
		$this->newtable->breadcrumb('Planning', 'javascript:void(0)', '');
		$this->newtable->breadcrumb('Gate Pass Behandle 2', 'javascript:void(0)', '');
		$check = (grant() == "W") ? true : false;

		$SQL = "SELECT A.ID AS 'ID',CONCAT(A.NO_CONT ,'<BR>',A.UKR_CONT) AS 'KONTAINER',A.JNS_DOK AS 'JENIS DOKUEMN', 
			CONCAT(A.NM_KAPAL ,'<BR>', A.NO_VOY) AS 'NAMA KAPAL', CONCAT(A.NPWP,'<BR>',A.NAMA_CUST) AS 'CUSTOMER', A.WK_REK AS 'WAKTU REKAM',
			CASE WHEN A.WK_ACTIVE IS NOT NULL AND A.FL_ACTIVE = 'Y' THEN '<span class=\"label label-success\">Active</span>'
				WHEN A.WK_ACTIVE IS NULL AND A.FL_ACTIVE = 'N' THEN '<span class=\"label label-danger\">Not Active</span>'
			END AS 'STATUS'
			FROM t_gatepass A WHERE A.JNS_KEGIATAN = '2'";

		if ($this->session->userdata('KD_GROUP') == "SPA") {
			$proses = array(
				'ENTRY'  => array('MODAL', "planning/gate_pass_behandle2/add", '0', '', 'md-plus-circle', '', 'menu'),
				'CETAK' => array('PRINT', "planning/cetak_gatepass_behandle", '1', '', 'md-print', '', 'list'),
				'HISTORY' => array('MODAL', "planning/gate_pass_behandle2/history", '1', '', 'md-watch', '', 'list'),
				'UPDATE' => array('MODAL', "planning/gate_pass_behandle/update_gatepass", '1', '', 'md-edit', '', 'list'),
				'ACTIVE' => array('POST', "planning/gate_pass_behandle/active_gatepass", '1', '', 'md-badge-check', '', 'list2'),
				'DELETE' => array('POST', "planning/gate_pass_behandle2/delete_gatepass", '1', '', 'md-close-circle', '', 'menu')
			);
		} else {
			$proses = array(
				'ENTRY'  => array('MODAL', "planning/gate_pass_behandle2/add", '0', '', 'md-plus-circle', '', 'menu'),
				'CETAK' => array('PRINT', "planning/cetak_gatepass_behandle", '1', '', 'md-print', '', 'list'),
				'HISTORY' => array('MODAL', "planning/gate_pass_behandle2/history", '1', '', 'md-watch', '', 'list'),
				'UPDATE' => array('MODAL', "planning/gate_pass_behandle/update_gatepass", '1', '', 'md-edit', '', 'list'),
				'ACTIVE' => array('POST', "planning/gate_pass_behandle/active_gatepass", '1', '', 'md-badge-check', '', 'list2')
			);
		}

		$this->newtable->multiple_search(true);
		$this->newtable->show_chk(true);
		$this->newtable->show_menu($check);
		$this->newtable->show_search(true);
		$this->newtable->search(array(array('NO_CONT', 'NO. KONTAINER'), array('NO_DOK', 'NO. DOKUMEN')/*,array('WK_REK','TGL. GATEPASS BEHANDLE 2','DATERANGE')*/));
		$this->newtable->action(site_url() . "/planning/gate_pass_behandle2");
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("ID"));
		$this->newtable->keys(array("ID"));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby("WK_REK");
		$this->newtable->sortby("DESC");
		$this->newtable->set_divid("divtblkapallist");
		$this->newtable->set_formid("tblkapallist");
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

	public function gate_pass_delivery_add($act, $id)
	{
		$page_title = 'Gate Pass delivery';
		$title = "";
		//$this->newtable->breadcrumb('Planning', site_url(),'icon-home');
		$this->newtable->breadcrumb('Billing', 'javascript:void(0)', '');
		$this->newtable->breadcrumb('Gate Pass Behandle', 'javascript:void(0)', '');
		$check = (grant() == "W") ? true : false;


		$SQL = "SELECT A.ID AS ID, B.NO_CONT AS 'NO_KONTAINER', CONCAT(B.NO_CONT,'<BR>',B.KD_CONT_UKURAN) AS KONTAINER, 
				CASE WHEN A.KD_DOK_INOUT = 1 THEN 'SPPB' ELSE NULL END AS 'JENIS DOKUMEN', 
				CONCAT(A.NO_DOK_INOUT,'<BR>',A.TGL_DOK_INOUT) AS 'DOKUMEN', CONCAT(A.ANGKUTNAMA_TPS,'<BR>',A.ANGKUTNO_TPS) AS 'VOYAGE'
				FROM t_permit_hdr A
				INNER JOIN t_permit_cont B ON A.ID = B.ID
				WHERE KD_DOK_INOUT = '1'";

		$this->newtable->multiple_search(true);
		$this->newtable->show_chk(false);
		$this->newtable->show_menu($check);
		$this->newtable->show_search(true);
		$this->newtable->search(array(array('A.ANGKUTNAMA_TPS', 'NAMA KAPAL'), array('A.ANGKUTNO_TPS', 'NO. VOYAGE'), array('A.NO_DOK_INOUT', 'NO. DOKUMEN'), array('B.NO_CONT', 'NO. KONTAINER')));
		$this->newtable->action(site_url() . "/planning/gate_pass_delivery/add_gp_del");
		if ($check) $this->newtable->detail(array('POPUP', "planning/gate_pass_delivery/detail"));
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("ID", "NO_KONTAINER"));
		$this->newtable->keys(array("NO_KONTAINER"));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby("1");
		$this->newtable->sortby("DESC");
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

	public function gate_pass_delivery($act, $id)
	{
		$page_title = "GATE PASS DELIVERY";
		$title = "GATE PASS DELIVERY";
		$usernya = $this->session->userdata('NM_LENGKAP');
		$this->newtable->breadcrumb('Dashboard', site_url(), 'icon-home');
		$this->newtable->breadcrumb('Planning', 'javascript:void(0)', '');
		$this->newtable->breadcrumb('Gate Pass Delivery', 'javascript:void(0)', '');
		$check = (grant() == "W") ? true : false;
		if ($KD_GROUP != "SPA") {
			///$addsql .= " AND A.KD_TPS = ".$this->db->escape($KD_TPS)." AND A.KD_GUDANG = ".$this->db->escape($KD_GUDANG);
		}


		$SQL = "SELECT ID,NO_CONT AS 'KONTAINER', JNS_DOK AS 'JENIS DOKUMEN',NM_KAPAL AS 'NAMA KAPAL', NAMA_CUST AS 'CUSTOMER', WK_REK AS 'WAKTU REKAM'
			FROM t_gatepass
			WHERE JNS_KEGIATAN = '3' AND STATUS != 'EXPIRED' AND STATUS ='WAITING'";

		$proses = array(
			'CETAK' => array('PRINT', "planning/cetak_gatepass_delivery", '1', '', 'md-print', '', 'list'),
			/*'ADD' => array('MODAL',"planning/gate_pass_delivery/add_gp_del", '','','md-plus-circle','', 'menu'),*/
			//'ASSOCIATE'  => array('MODAL',"planning/gate_pass_delivery/associate", '1','','md-plus-circle','', 'list'),
			'HISTORY' => array('MODAL', "planning/gate_pass_delivery/history", '1', '', 'md-watch', '', 'list')
		);


		$this->newtable->multiple_search(true);
		$this->newtable->show_chk(false);
		$this->newtable->show_menu($check);
		$this->newtable->show_search(true);
		$this->newtable->search(array(array('NO_CONT', 'NO. KONTAINER'), array('NO_DOK', 'NO. DOKUMEN')));
		$this->newtable->action(site_url() . "/planning/gate_pass_delivery");
		//if($check) $this->newtable->detail(array('POPUP',"planning/shipment/detail"));
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("ID"));
		$this->newtable->keys(array("ID"));
		$this->newtable->cidb($this->db);
		$this->newtable->groupby(array("NO_CONT"));
		$this->newtable->orderby('ID DESC');
		$this->newtable->sortby("");
		$this->newtable->set_divid("divtblkapallist");
		$this->newtable->set_formid("tblkapallist");
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

	public function behandle_add($act, $id)
	{
		$this->newtable->breadcrumb('Billing', 'javascript:void(0)', '');
		$this->newtable->breadcrumb('Gate Pass Behandle', 'javascript:void(0)', '');
		$check = (grant() == "W") ? true : false;

		// ori		
		// $SQL = "SELECT X.ID AS 'ID',CONCAT(X.NO_KONTAINER ,'<BR>', X.UKURAN) AS 'KONTAINER',X.JENIS_DOKUMEN AS 'JENIS DOKUMEN', CONCAT(X.NO_DOKUMEN ,'<BR>', DATE_FORMAT(TGL_DOKUMEN, '%d-%m-%Y')) AS 'DOKUMEN',case when X.LNSW_KD_RESPON IS NOT NULL then case when X.LNSW_KD_RESPON = '005' then CONCAT(X.LNSW_NOAJU,'<br>',X.LNSW_TGLAJU) end ELSE '-' END AS 'JOIN INSPECTION', CONCAT(X.NAMA_KAPAL ,'<BR>',X.NO_VOYAGE) AS 'VOYAGE', X.NO_DOKUMEN AS 'NO. DOKUMEN', TGL_DOKUMEN AS 'TANGGAL DOKUMEN', X.NO_KONTAINER AS 'NO. KONTAINER', X.STATUS_DOKUMEN AS 'STATUS DOKUMEN',J.ID as IDG
		// FROM(
		// 	SELECT C.ID AS 'ID', C.ANGKUTNAMA_TPS AS 'NAMA_KAPAL', C.ANGKUTNO_TPS 'NO_VOYAGE', H.NAMA AS 'JENIS_DOKUMEN', C.NO_DOK_INOUT AS 'NO_DOKUMEN', C.TGL_DOK_INOUT AS 'TGL_DOKUMEN',D.NO_CONT  AS 'NO_KONTAINER', D.KD_CONT_UKURAN AS 'UKURAN',  CASE WHEN C.FL_MANUAL ='N' THEN 'INTEGRASI' ELSE 'MANUAL' END AS 'STATUS_DOKUMEN',C.LNSW_NOAJU,C.LNSW_TGLAJU,C.LNSW_KD_RESPON
		// 	FROM t_permit_hdr C,t_permit_cont D, reff_kode_dok_bc H WHERE C.ID = D.ID AND KD_DOK_INOUT NOT IN ('83','1') AND D.FL_GATEPASS != 'Y' AND H.ID = C.KD_DOK_INOUT AND C.TGL_DOK_INOUT >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH)

		// 	UNION ALL

		// 	SELECT A.ID_IJIN AS 'ID',  A.ANGKUTNAMA_TPS AS 'NAMA_KAPAL', A.ANGKUTNO_TPS AS 'NO_VOYAGE', 'SPPMP' AS 'JENIS_DOKUMEN', A.NO_RESPON AS 'NO_DOKUMEN', A.TG_RESPON AS 'TGL_DOKUMEN', B.NO_CONT AS 'NO_KONTAINER', B.UKURAN AS 'UKURAN', CASE WHEN A.FL_MANUAL = 'N' THEN 'INTEGRASI' ELSE 'MANUAL' END AS 'STATUS_DOKUMEN',A.LNSW_NOAJU,A.LNSW_TGLAJU,A.LNSW_KD_RESPON
		// 	FROM t_ppk_hdr A, t_ppk_cont B WHERE A.ID_IJIN = B.ID_IJIN AND B.NO_TPFT IS NOT NULL AND B.FL_GATEPASS != 'Y' and A.TG_RESPON >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH)) X 
		// 	INNER JOIN t_request Y ON X.NO_DOKUMEN = Y.NO_DOK
		// 	INNER JOIN t_request_cont Z ON X.NO_KONTAINER = Z.NO_CONT AND Y.ID = Z.ID
		// 	LEFT JOIN t_gatepass J ON Y.NO_DOK = J.NO_DOK AND Z.NO_CONT = J.NO_CONT
		// 	WHERE J.NO_CONT IS null";

		// Yg Lama
		// 			$SQL = "SELECT
		// 	X.ID as 'ID',
		// 	CONCAT(X.NO_KONTAINER , '<BR>', X.UKURAN) as 'KONTAINER',
		// 	X.JENIS_DOKUMEN as 'JENIS DOKUMEN',
		// 	CONCAT(X.NO_DOKUMEN , '<BR>', DATE_FORMAT(TGL_DOKUMEN, '%d-%m-%Y')) as 'DOKUMEN',
		// 	case
		// 		when X.LNSW_KD_RESPON is not null then case
		// 			when X.LNSW_KD_RESPON = '005' then CONCAT(X.LNSW_NOAJU, '<br>', X.LNSW_TGLAJU)
		// 		end
		// 		else '-'
		// 	end as 'JOIN INSPECTION',
		// 	CONCAT(X.NAMA_KAPAL , '<BR>', X.NO_VOYAGE) as 'VOYAGE',
		// 	X.NO_DOKUMEN as 'NO. DOKUMEN',
		// 	TGL_DOKUMEN as 'TANGGAL DOKUMEN',
		// 	X.NO_KONTAINER as 'NO. KONTAINER',
		// 	X.STATUS_DOKUMEN as 'STATUS DOKUMEN',
		// 	J.ID as IDG
		// from v_ppk_header_union_permit X
		// inner join t_request Y on
		// 	X.NO_DOKUMEN = Y.NO_DOK
		// inner join t_request_cont Z on
		// 	X.NO_KONTAINER = Z.NO_CONT
		// 	and Y.ID = Z.ID
		// left join t_gatepass J on
		// 	Y.NO_DOK = J.NO_DOK
		// 	and Z.NO_CONT = J.NO_CONT
		// where
		// 	J.NO_CONT is null";

		$SQL = "SELECT 
							X.ID as ID,
							CONCAT(X.NO_KONTAINER , '<BR>', X.UKURAN) as KONTAINER,
							X.JENIS_DOKUMEN,
							CONCAT(X.NO_DOKUMEN , '<BR>', DATE_FORMAT(TGL_DOKUMEN, '%d-%m-%Y')) as DOKUMEN,
							CASE
									WHEN X.LNSW_KD_RESPON = '005'
									THEN CONCAT(X.LNSW_NOAJU, '<br>', X.LNSW_TGLAJU)
									ELSE '-'
							END as `JOIN INSPECTION`,
							CONCAT(X.NAMA_KAPAL , '<BR>', X.NO_VOYAGE) as VOYAGE,
							X.NO_DOKUMEN,
							X.TGL_DOKUMEN,
							X.NO_KONTAINER,
							X.STATUS_DOKUMEN
		 				FROM v_ppk_header_union_permit_new X";

		// $SQL = "SELECT
		// 			X.ID as ID,
		// 			CONCAT(X.NO_KONTAINER , '<BR>', X.UKURAN) as KONTAINER,
		// 			X.JENIS_DOKUMEN,
		// 			CONCAT(X.NO_DOKUMEN , '<BR>', DATE_FORMAT(TGL_DOKUMEN, '%d-%m-%Y')) as DOKUMEN,
		// 			CASE
		// 					WHEN X.LNSW_KD_RESPON = '005'
		// 					THEN CONCAT(X.LNSW_NOAJU, '<br>', X.LNSW_TGLAJU)
		// 					ELSE '-'
		// 			END as `JOIN INSPECTION`,
		// 			CONCAT(X.NAMA_KAPAL , '<BR>', X.NO_VOYAGE) as VOYAGE,
		// 			X.NO_DOKUMEN,
		// 			TGL_DOKUMEN,
		// 			X.NO_KONTAINER,
		// 			X.STATUS_DOKUMEN
		// 	FROM v_ppk_header_union_permit X
		// 	INNER JOIN t_request Y 
		// 			ON X.NO_DOKUMEN = Y.NO_DOK
		// 	INNER JOIN t_request_cont Z 
		// 			ON X.NO_KONTAINER = Z.NO_CONT
		// 			AND Y.ID = Z.ID
		// 	WHERE NOT EXISTS (
		// 			SELECT 1
		// 			FROM t_gatepass J
		// 			WHERE J.NO_DOK = Y.NO_DOK
		// 				AND J.NO_CONT = Z.NO_CONT
		// 	)";

		$this->newtable->multiple_search(true);
		$this->newtable->show_chk(false);
		$this->newtable->show_menu($check);
		$this->newtable->show_search(true);
		$this->newtable->search(array(array('X.NAMA_KAPAL', 'NAMA KAPAL'), array('X.NO_VOYAGE', 'NO. VOYAGE'), array('X.NO_DOKUMEN', 'NO. DOKUMEN'), array('X.NO_KONTAINER', 'NO. KONTAINER')));
		$this->newtable->action(site_url() . "/planning/gate_pass_behandle/add");
		$this->newtable->detail(array('POPUP', "planning/gate_pass_behandle/update"));
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("ID", "NO_KONTAINER", "NO. DOKUMEN", "TANGGAL DOKUMEN", "NO. KONTAINER"));
		$this->newtable->keys(array("NO_DOKUMEN", "TGL_DOKUMEN", "NO_KONTAINER"));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby("X.ID");
		$this->newtable->sortby("ASC");
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

	public function behandle2_add($act, $id)
	{
		$page_title = 'Gate Pass Behandle';
		$title = "";
		$this->newtable->breadcrumb('Billing', 'javascript:void(0)', '');
		$this->newtable->breadcrumb('Gate Pass Behandle', 'javascript:void(0)', '');
		$check = (grant() == "W") ? true : false;

		$SQL = "SELECT A.ID, CONCAT(A.NO_CONT,'<BR>',A.UKR_CONT) AS 'KONTAINER', A.JNS_DOK AS 'JENIS DOKUMEN', CONCAT(A.NO_DOK,'<BR>', A.TGL_DOK) AS 'DOKUMEN', CONCAT(A.NM_KAPAL,'<BR>', A.NO_VOY) AS 'VOYAGE'
					FROM t_gatepass A
					INNER JOIN t_op_inspection B ON A.NO_CONT = B.NO_CONT AND A.NO_DOK = B.NO_DOK
					WHERE A.JNS_KEGIATAN IN ('1','2') AND A.STATUS = 'DONE' AND A.FL_USE = 'N' AND B.STATUS ='DONE'	";

		$this->newtable->multiple_search(true);
		$this->newtable->show_chk(FALSE);
		$this->newtable->show_menu($check);
		$this->newtable->show_search(true);
		$this->newtable->search(array(array('A.NO_CONT', 'NO. KONTAINER'), array('A.NM_KAPAL', 'NAMA KAPAL')));
		$this->newtable->action(site_url() . "/planning/gate_pass_behandle2/add");
		if ($check) $this->newtable->detail(array('POPUP', "planning/gate_pass_behandle2/update"));
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("ID"));
		$this->newtable->keys(array("ID"));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby(1);
		$this->newtable->sortby("ASC");
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

	public function list_jadwal_kapal($act, $id)
	{
		$page_title = "JADWAL KAPAL";
		$title = "";
		$this->newtable->breadcrumb('Dashboard', site_url(), 'icon-home');
		$this->newtable->breadcrumb('Planning', 'javascript:void(0)', '');
		$this->newtable->breadcrumb('Jadwal Kapal', 'javascript:void(0)', '');
		$check = (grant() == "W") ? true : false;
		if ($KD_GROUP != "SPA") {
			///$addsql .= " AND A.KD_TPS = ".$this->db->escape($KD_TPS)." AND A.KD_GUDANG = ".$this->db->escape($KD_GUDANG);
		}
		$SQL = "SELECT ID,NM_KAPAL AS 'NAMA KAPAL', NO_VOYAGE AS 'NO. VOY', ETA, ETD, OPN_STACK AS 'OPEN STACK', ATA, ATD, WK_DISCH AS 'WAKTU DISCHARGE', JMLH_MUAT AS 'JUMLAH MUATAN'  FROM t_jadwal_kapal WHERE ID = '$id'";
		/*$proses = array('ENTRY'  => array('MODAL',"planning/shipment/add", '0','','md-plus-circle','', 'menu'),
						'UPDATE' => array('MODAL',"planning/shipment/update", '1','','md-edit','', 'menu'),
						'REALISASI' => array('MODAL',"planning/shipment/release", '1','','md-refresh-alt','', 'menu'),
						'DELETE'  => array('DELETE',"execute/process/delete/kapal", '1','','md-close-circle','', 'menu'));*/
		//'UPLOAD' => array('ADD',site_url()."/coarri/discharge/upload", '','','md-attachment'));
		$this->newtable->multiple_search(false);
		$this->newtable->show_chk(false);
		$this->newtable->show_menu($check);
		$this->newtable->show_search(false);
		//$this->newtable->search(array(array('NM_KAPAL','NAMA KAPAL'),array('NO_VOYAGE','NO. VOYAGE')));
		$this->newtable->action(site_url() . "/planning/shipment");
		//if($check) $this->newtable->detail(array('DRILLDOWN',site_url()."/coarri/discharge/detail"));
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("ID"));
		$this->newtable->keys(array("ID"));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby(6);
		$this->newtable->sortby("DESC");
		$this->newtable->set_formid("tblkapal");
		$this->newtable->set_divid("divtblkapal");
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

	public function discharge_kontainer($act, $id)
	{
		$page_title = "DISCHARGE - KONTAINER";
		$title = "";
		$KD_TPS = $this->session->userdata('KD_TPS');
		$KD_GUDANG = $this->session->userdata('KD_GUDANG');
		$check = (grant() == "W") ? true : false;
		$SQL = "SELECT A.ID, A.NO_CONT AS 'NOMOR KONTAINER', CONCAT('UKURAN : ',func_name(IFNULL(A.KD_CONT_UKURAN,'-'),'CONT_UKURAN'),
				'<BR>JENIS : ',func_name(IFNULL(A.KD_CONT_JENIS,'-'),'CONT_JENIS'),'<BR>TIPE : ',func_name(IFNULL(A.KD_CONT_TIPE,'-'),'CONT_TIPE'))
				AS 'KETERANGAN KONTAINER',
				CONCAT('NO. ',IFNULL(NO_MASTER_BL_AWB,'-'),'<BR>TGL. ',IFNULL(DATE_FORMAT(A.TGL_MASTER_BL_AWB,'%d-%m-%Y'),'-')) AS 'MASTER BL/AWB',
				CONCAT('NO. ',IFNULL(NO_BL_AWB,'-'),'<BR>TGL. ',IFNULL(DATE_FORMAT(A.TGL_BL_AWB,'%d-%m-%Y'),'-')) AS 'BL/AWB', A.BRUTO,
				DATE_FORMAT(IFNULL(A.WK_IN,'-'),'%d-%m-%Y %H:%i:%s') AS 'DISCHARGE',
				DATE_FORMAT(IFNULL(A.WK_REKAM,'-'),'%d-%m-%Y %H:%i:%s') AS 'WAKTU REKAM',
				'COARRI/DISCHARGE_KONTAINER' AS POST
				FROM t_cocostscont A
				WHERE A.ID = " . $this->db->escape($id);
		$proses = array(
			'ENTRY' => array('MODAL', "coarri/discharge_kontainer/add/" . $id, '0', '', 'md-plus-circle', '', '1'),
			'UPDATE' => array('MODAL', "coarri/discharge_kontainer/update", '1', '', 'md-edit', '', '1'),
			'DELETE' => array('DELETE', "execute/process/delete/kontainer", 'ALL', '', 'md-close-circle', '', '1')
		);
		$this->newtable->show_chk($check);
		$this->newtable->show_menu($check);
		$this->newtable->multiple_search(true);
		$this->newtable->show_search(true);
		$this->newtable->search(array(array('A.NO_CONT', 'NOMOR KONTAINER')));
		$this->newtable->action(site_url() . "/coarri/discharge_kontainer/" . $act . "/" . $id);
		if ($check) $this->newtable->detail(array('POPUP', "coarri/discharge_kontainer/detail-kontainer"));
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("ID", 'POST'));
		$this->newtable->keys(array("ID", "NOMOR KONTAINER", 'POST'));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby(8);
		$this->newtable->sortby("DESC");
		$this->newtable->set_formid("tblkontainer");
		$this->newtable->set_divid("divtblkontainer");
		$this->newtable->rowcount('10');
		$this->newtable->clear();
		$this->newtable->menu($proses);
		$tabel .= $this->newtable->generate($SQL);
		$arrdata = array("title" => $judul, "content" => $tabel);
		if ($this->input->post("ajax") || $act == "post")
			echo $tabel;
		else
			return $arrdata;
	}

	public function discharge_kemasan($act, $id)
	{
		$page_title = "DISCHARGE - KEMASAN";
		$title = "";
		$KD_TPS = $this->session->userdata('KD_TPS');
		$KD_GUDANG = $this->session->userdata('KD_GUDANG');
		$check = (grant() == "W") ? true : false;
		if ($KD_GROUP != "SPA") {
			$addsql .= " AND B.KD_TPS = " . $this->db->escape($KD_TPS) . " AND B.KD_GUDANG = " . $this->db->escape($KD_GUDANG);
		}
		$SQL = "SELECT CONCAT('JUMLAH : ',A.JUMLAH,'<BR>BRUTO : ',A.BRUTO,'<BR>',
				func_name(A.KD_KEMASAN,'KEMASAN'),' [',A.KD_KEMASAN,']') AS KEMASAN,
				CONCAT('NO. ',IFNULL(NO_MASTER_BL_AWB,'-'),'<BR>TGL. ',IFNULL(DATE_FORMAT(A.TGL_MASTER_BL_AWB,'%d-%m-%Y'),'-')) AS 'MASTER BL/AWB',
				CONCAT('NO. ',IFNULL(NO_BL_AWB,'-'),'<BR>TGL. ',IFNULL(DATE_FORMAT(A.TGL_BL_AWB,'%d-%m-%Y'),'-')) AS 'BL/AWB',
				A.NO_POS_BC11 AS 'NO. POS BC11', C.NAMA AS CONISGNEE,
				DATE_FORMAT(IFNULL(A.WK_IN,'-'),'%d-%m-%Y %H:%i:%s') AS 'DISCHARGE', A.WK_REKAM AS 'WAKTU REKAM', A.ID, A.SERI,
				'COARRI/DISCHARGE_KEMASAN' AS POST
				FROM t_cocostskms A
				INNER JOIN t_cocostshdr B ON B.ID=A.ID
				LEFT JOIN t_organisasi C ON C.ID=A.KD_ORG_CONSIGNEE
				WHERE A.ID = " . $this->db->escape($id) . $addsql;
		$proses = array(
			'ENTRY' => array('MODAL', "coarri/discharge_kemasan/add/" . $id, '0', '', 'md-plus-circle', '', '1'),
			'UPDATE' => array('MODAL', "coarri/discharge_kemasan/update", '1', '', 'md-edit', '', '1'),
			'DELETE' => array('DELETE', "execute/process/delete/kemasan/" . $id, 'ALL', '', 'md-close-circle', '', '1')
		);
		$this->newtable->show_chk($check);
		$this->newtable->show_menu($check);
		$this->newtable->multiple_search(true);
		$this->newtable->show_search(true);
		$this->newtable->search(array(array('A.NO_MASTER_BL_AWB', 'MASTER BL/AWB'), array('A.NO_BL_AWB', 'BL/AWB')));
		$this->newtable->action(site_url() . "/coarri/discharge_kemasan/" . $act . "/" . $id);
		if ($check) $this->newtable->detail(array('POPUP', "coarri/discharge_kemasan/detail-kemasan"));
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("ID", "SERI", "POST"));
		$this->newtable->keys(array("ID", "SERI", "POST"));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby(9);
		$this->newtable->sortby("DESC");
		$this->newtable->set_formid("tblkemasan");
		$this->newtable->set_divid("divtblkemasan");
		$this->newtable->rowcount('10');
		$this->newtable->clear();
		$this->newtable->menu($proses);
		$tabel .= $this->newtable->generate($SQL);
		$arrdata = array("title" => $judul, "content" => $tabel);
		if ($this->input->post("ajax") || $act == "post")
			echo $tabel;
		else
			return $arrdata;
	}

	public function loading($act, $id)
	{
		$page_title = "GATE OUT";
		$title = "";
		$KD_TPS = $this->session->userdata('KD_TPS');
		$KD_GUDANG = $this->session->userdata('KD_GUDANG');
		$KD_GROUP = $this->session->userdata('KD_GROUP');
		$this->newtable->breadcrumb('Dashboard', site_url(), 'icon-home');
		$this->newtable->breadcrumb('Pergerakan Barang', 'javascript:void(0)', '');
		$this->newtable->breadcrumb('Barang Ekspor', 'javascript:void(0)', '');
		$this->newtable->breadcrumb('Loading', 'javascript:void(0)', '');
		$check = (grant() == "W") ? true : false;
		if ($KD_GROUP != "SPA") {
			$addsql .= " AND A.KD_TPS = " . $this->db->escape($KD_TPS) . " AND A.KD_GUDANG = " . $this->db->escape($KD_GUDANG);
		}
		$SQL = "SELECT CONCAT(C.NAMA,'<BR>[',A.NM_ANGKUT,']') AS 'NAMA ANGKUT',
				A.NO_VOY_FLIGHT AS 'NO. VOYAGE/FLIGHT',
				DATE_FORMAT(A.TGL_TIBA,'%d-%m-%Y') AS 'TGL. TIBA', A.NO_BC11 AS 'NO. BC11',
				DATE_FORMAT(A.TGL_BC11,'%d-%m-%Y') AS 'TGL. BC11', A.WK_REKAM AS 'WAKTU REKAM',
				CONCAT('<span class=\"label label-danger\">JUMLAH : ',(
									SELECT COUNT(X.ID) FROM t_cocostscont X WHERE X.ID = A.ID),
				'</span><BR><span class=\"label label-info\">GATE IN : ',(
									SELECT COUNT(X.ID) FROM t_cocostscont X
									WHERE X.WK_IN IS NOT NULL
									AND X.WK_OUT IS NULL
									AND X.ID = A.ID),
				'</span><BR><span class=\"label label-success\">LOADING : ',(SELECT COUNT(X.ID)
								 	FROM t_cocostscont X
									WHERE X.WK_IN IS NOT NULL
									AND X.WK_OUT IS NOT NULL
									AND X.ID = A.ID),'<span>') AS 'KONTAINER',
				CONCAT('<span class=\"label label-danger\">JUMLAH : ',(
									SELECT COUNT(Y.ID) FROM t_cocostskms Y WHERE Y.ID = A.ID),
				'</span><BR><span class=\"label label-info\">GATE IN : ',(
									SELECT COUNT(Y.ID) FROM t_cocostskms Y
									WHERE Y.WK_IN IS NOT NULL
									AND Y.WK_OUT IS NULL
									AND Y.ID = A.ID),
				'</span><BR><span class=\"label label-success\">LOADING : ',(
									SELECT COUNT(Y.ID) FROM t_cocostskms Y
									WHERE Y.WK_IN IS NOT NULL
									AND Y.WK_OUT IS NOT NULL
									AND Y.ID = A.ID),'<span>') AS 'KEMASAN', A.ID
				FROM t_cocostshdr A
				LEFT JOIN reff_gudang B ON A.KD_TPS = B.KD_TPS AND A.KD_GUDANG = B.KD_GUDANG
				LEFT JOIN reff_kapal C ON A.KD_KAPAL = C.ID
				WHERE A.KD_ASAL_BRG = '3'" . $addsql;
		$proses = array(
			'DETAIL' => array('GET', site_url() . "/coarri/loading/detail", '1', '', 'md-zoom-in'),
			'UPLOAD' => array('ADD', site_url() . "/coarri/loading/upload", '', '', 'md-attachment')
		);
		$this->newtable->multiple_search(true);
		$this->newtable->show_chk($check);
		$this->newtable->show_menu($check);
		$this->newtable->show_search(true);
		$this->newtable->search(array(array('A.NO_BC11', 'NO. BC11'), array('C.NAMA', 'NAMA ANGKUT')));
		$this->newtable->action(site_url() . "/coarri/loading");
		if ($check) $this->newtable->detail(array('GET', site_url() . "/coarri/loading/detail"));
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("ID"));
		$this->newtable->keys(array("ID"));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby(6);
		$this->newtable->sortby("DESC");
		$this->newtable->set_formid("tblkapal");
		$this->newtable->set_divid("divtblkapal");
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

	public function loading_kontainer($act, $id)
	{
		$page_title = "LOADING - KONTAINER";
		$title = "";
		$KD_TPS = $this->session->userdata('KD_TPS');
		$KD_GUDANG = $this->session->userdata('KD_GUDANG');
		$check = (grant() == "W") ? true : false;
		$SQL = "SELECT A.ID, A.NO_CONT AS 'NOMOR KONTAINER', CONCAT('UKURAN : ',func_name(IFNULL(A.KD_CONT_UKURAN,'-'),'CONT_UKURAN'),
				'<BR>JENIS : ',func_name(IFNULL(A.KD_CONT_JENIS,'-'),'CONT_JENIS'),'<BR>TIPE : ',func_name(IFNULL(A.KD_CONT_TIPE,'-'),'CONT_TIPE'))
				AS 'KETERANGAN KONTAINER',
				CONCAT('NO. ',IFNULL(NO_MASTER_BL_AWB,'-'),'<BR>TGL. ',IFNULL(DATE_FORMAT(A.TGL_MASTER_BL_AWB,'%d-%m-%Y'),'-')) AS 'MASTER BL/AWB',
				CONCAT('NO. ',IFNULL(NO_BL_AWB,'-'),'<BR>TGL. ',IFNULL(DATE_FORMAT(A.TGL_BL_AWB,'%d-%m-%Y'),'-')) AS 'BL/AWB', A.BRUTO,
				DATE_FORMAT(IFNULL(A.WK_IN,'-'),'%d-%m-%Y %H:%i:%s') AS 'GATE IN',
				DATE_FORMAT(IFNULL(A.WK_OUT,'-'),'%d-%m-%Y %H:%i:%s') AS 'LOADING',
				DATE_FORMAT(IFNULL(A.WK_REKAM,'-'),'%d-%m-%Y %H:%i:%s') AS 'WAKTU REKAM',
				'COARRI/LOADING_KONTAINER' AS POST
				FROM t_cocostscont A
				WHERE A.WK_IN IS NOT NULL AND A.ID = " . $this->db->escape($id);
		$proses = array('GATE OUT' => array('MODAL', "coarri/loading_kontainer/update", '1', '', 'md-redo', '', '1'));
		$this->newtable->show_chk($check);
		$this->newtable->show_menu($check);
		$this->newtable->multiple_search(true);
		$this->newtable->show_search(true);
		$this->newtable->search(array(array('A.NO_CONT', 'NOMOR KONTAINER')));
		$this->newtable->action(site_url() . "/coarri/loading_kontainer/" . $act . "/" . $id);
		if ($check) $this->newtable->detail(array('POPUP', "coarri/loading_kontainer/detail-kontainer"));
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("ID", 'POST'));
		$this->newtable->keys(array("ID", "NOMOR KONTAINER", 'POST'));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby(9);
		$this->newtable->sortby("DESC");
		$this->newtable->set_formid("tblkontainer");
		$this->newtable->set_divid("divtblkontainer");
		$this->newtable->rowcount('10');
		$this->newtable->clear();
		$this->newtable->menu($proses);
		$tabel .= $this->newtable->generate($SQL);
		$arrdata = array("title" => $judul, "content" => $tabel);
		if ($this->input->post("ajax") || $act == "post")
			echo $tabel;
		else
			return $arrdata;
	}

	public function loading_kemasan($act, $id)
	{
		$page_title = "LOADING - KEMASAN";
		$title = "";
		$KD_TPS = $this->session->userdata('KD_TPS');
		$KD_GUDANG = $this->session->userdata('KD_GUDANG');
		$check = (grant() == "W") ? true : false;
		if ($KD_GROUP != "SPA") {
			$addsql .= " AND B.KD_TPS = " . $this->db->escape($KD_TPS) . " AND B.KD_GUDANG = " . $this->db->escape($KD_GUDANG);
		}
		$SQL = "SELECT CONCAT('JUMLAH : ',A.JUMLAH,'<BR>BRUTO : ',A.BRUTO,'<BR>',
				func_name(A.KD_KEMASAN,'KEMASAN'),' [',A.KD_KEMASAN,']') AS KEMASAN,
				CONCAT('NO. ',IFNULL(NO_MASTER_BL_AWB,'-'),'<BR>TGL. ',IFNULL(DATE_FORMAT(A.TGL_MASTER_BL_AWB,'%d-%m-%Y'),'-')) AS 'MASTER BL/AWB',
				CONCAT('NO. ',IFNULL(NO_BL_AWB,'-'),'<BR>TGL. ',IFNULL(DATE_FORMAT(A.TGL_BL_AWB,'%d-%m-%Y'),'-')) AS 'BL/AWB',
				A.NO_POS_BC11 AS 'POS BC11', C.NAMA AS CONISGNEE,
				DATE_FORMAT(IFNULL(A.WK_IN,'-'),'%d-%m-%Y %H:%i:%s') AS 'GATE IN',
				DATE_FORMAT(IFNULL(A.WK_OUT,'-'),'%d-%m-%Y %H:%i:%s') AS 'LOADING',
				A.WK_REKAM AS 'WAKTU REKAM', A.ID, A.SERI, 'COARRI/LOADING_KEMASAN' AS POST
				FROM t_cocostskms A
				INNER JOIN t_cocostshdr B ON B.ID=A.ID
				LEFT JOIN t_organisasi C ON C.ID=A.KD_ORG_CONSIGNEE
				WHERE A.WK_IN IS NOT NULL AND A.ID = " . $this->db->escape($id) . $addsql;
		$proses = array('UPDATE' => array('MODAL', "coarri/loading_kemasan/update", '1', '', 'md-redo', '', '1'));
		$this->newtable->show_chk($check);
		$this->newtable->show_menu($check);
		$this->newtable->multiple_search(true);
		$this->newtable->show_search(true);
		$this->newtable->search(array(array('A.NO_MASTER_BL_AWB', 'MASTER BL/AWB'), array('A.NO_BL_AWB', 'BL/AWB')));
		$this->newtable->action(site_url() . "/coarri/loading_kemasan/" . $act . "/" . $id);
		if ($check) $this->newtable->detail(array('POPUP', "coarri/loading_kemasan/detail-kemasan"));
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("ID", "SERI", "POST"));
		$this->newtable->keys(array("ID", "SERI", "POST"));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby(10);
		$this->newtable->sortby("DESC");
		$this->newtable->set_formid("tblkemasan");
		$this->newtable->set_divid("divtblkemasan");
		$this->newtable->rowcount('10');
		$this->newtable->clear();
		$this->newtable->menu($proses);
		$tabel .= $this->newtable->generate($SQL);
		$arrdata = array("title" => $judul, "content" => $tabel);
		if ($this->input->post("ajax") || $act == "post")
			echo $tabel;
		else
			return $arrdata;
	}

	public function list_dokumen($act, $id)
	{
		$page_title = "SPJM";
		$title = "SPJM";
		$this->newtable->breadcrumb('Dashboard', site_url(), 'icon-home');
		$this->newtable->breadcrumb('Planning', 'javascript:void(0)', '');
		$this->newtable->breadcrumb('Dokumen SPJM', 'javascript:void(0)', '');
		$check = (grant() == "W") ? true : false;
		if ($act == 'sppb') {
			//$addsql .= " AND A.KD_DOK_INOUT IN('1')";
			//$alias = 'SPPB BC (2.0)';
		} else if ($act == "sppb_bc23") {
			//$addsql .= " AND A.KD_DOK_INOUT IN('2')";
			//$alias = 'SPPB BC (2.3)';
		} else if ($act == 'spjm') {
			$kd = "19";
			//$addsql .= " AND A.KD_DOK_INOUT IN('19')";
			//$alias = 'SPJM';
		} else {
			//$addsql .= " AND A.KD_DOK_INOUT NOT IN('1','19','2')";
			//$alias = 'DOKUMEN';
		}
		//$SQL = "SELECT A.*, B.NO_CONT, KD_CONT_UKURAN FROM t_permit_hdr A INNER JOIN t_permit_cont B ON A.ID = B.ID WHERE A.ID = '$id'".$addsql;
		$SQL = "SELECT DISTINCT CONCAT('NO : ',(A.NO_DAFTAR_PABEAN),'<BR> TGL : ',(DATE_FORMAT(A.TGL_DAFTAR_PABEAN, '%d-%m-%Y'))) AS DOKUMEN ,
		CONCAT('',(A.ANGKUTNAMA_TPS),'<BR>',(A.ANGKUTNO_TPS)) AS 'VOYAGE',
		A.ID_CONSIGNEE AS 'NPWP IMPORTIR', A.CONSIGNEE AS 'NAMA IMPORTIR',
		A.NPWP_PPJK AS 'NPWP PPJK',A.NAMA_PPJK AS 'NAMA PPJK', CASE WHEN A.STATUS = 'N' THEN '<span style=\"color:red;font-weight:bold\">REQUEST</span>' WHEN A.STATUS = 'Y' THEN '<span style=\"color:green;font-weight:bold\">DONE</span>' ELSE 0 END AS 'STATUS',A.ID
		FROM t_permit_hdr A
		INNER JOIN t_permit_cont B
		ON A.ID = B.ID
		WHERE A.KD_DOK_INOUT = '19' AND B.TIPE_CONT = 'DRY'";

		/*$proses = array('REQUEST'  => array('MODAL',"planning/execute_dokumen_ctrl/save/request", '1','','md-email','','list'),'EXPORT EXCEL' => array('EXCEL', "process2/excel/spjm/".$act, '0','','md-file-text','','menu'));*/
		/*'UPDATE' => array('MODAL',"coarri/discharge/update", '1','','md-edit'),
						'DETAIL' => array('GET',site_url()."/coarri/discharge/detail", '1','','md-zoom-in'),
						'UPLOAD' => array('ADD',site_url()."/coarri/discharge/upload", '','','md-attachment'));*/
		$this->newtable->multiple_search(true);
		$this->newtable->show_chk(false);
		$this->newtable->show_menu($check);
		$this->newtable->show_search(true);
		$arr_sts = array("" => "", "N" => "REQUEST", "Y" => "DONE");
		$this->newtable->search(array(array('A.NO_DAFTAR_PABEAN', 'NO. PIB / SPJM'), array('A.TGL_DAFTAR_PABEAN', 'TGL. PIB', 'DATERANGE'), array('A.STATUS', 'STATUS', 'OPTION', $arr_sts), array('B.NO_CONT', 'NO. KONTAINER')));
		$this->newtable->action(site_url() . "/planning/spjm");
		if ($check) $this->newtable->detail(array('POPUP', "planning/spjm/spjm_detail"));
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("ID"));
		$this->newtable->keys(array("ID"));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby(" 6 DESC ,  date(TGL_DAFTAR_PABEAN) ASC");
		$this->newtable->sortby("");
		//$this->newtable->groupby(4);
		$this->newtable->set_formid("tblkapal");
		$this->newtable->set_divid("divtblkapal");
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

	public function list_karantina($act, $id)
	{
		$page_title = "PELEPASAN KARANTINA";
		$title = "PELEPASAN KARANTINA";
		$this->newtable->breadcrumb('Karantina', site_url(), 'icon-home');
		$this->newtable->breadcrumb('Planning', 'javascript:void(0)', '');
		$this->newtable->breadcrumb('Dokumen Pelepasan Karantina', 'javascript:void(0)', '');
		$check = (grant() == "W") ? true : false;
		if ($act == 'sppb') {
			//$addsql .= " AND A.KD_DOK_INOUT IN('1')";
			//$alias = 'SPPB BC (2.0)';
		} else if ($act == "sppb_bc23") {
			//$addsql .= " AND A.KD_DOK_INOUT IN('2')";
			//$alias = 'SPPB BC (2.3)';
		} else if ($act == 'spjm') {
			$kd = "19";
			//$addsql .= " AND A.KD_DOK_INOUT IN('19')";
			//$alias = 'SPJM';
		} else {
			//$addsql .= " AND A.KD_DOK_INOUT NOT IN('1','19','2')";
			//$alias = 'DOKUMEN';
		}
		//$SQL = "SELECT A.*, B.NO_CONT, KD_CONT_UKURAN FROM t_permit_hdr A INNER JOIN t_permit_cont B ON A.ID = B.ID WHERE A.ID = '$id'".$addsql;
		$SQL = "SELECT ID,CAR, NO_DAFTAR_PABEAN AS 'NO. PIB', TGL_DAFTAR_PABEAN AS 'TGL PIB', ID_CONSIGNEE AS 'NPWP IMPORTIR', CONSIGNEE AS 'NAMA IMPORTIR', NPWP_PPJK AS 'NPWP PPJK', NAMA_PPJK AS 'NAMA PPJK', CASE WHEN STATUS = 'N' THEN '<span class=\"label label-danger\">REQUEST</span>' WHEN STATUS = 'Y' THEN '<span class=\"label label-success\">DONE</span>' ELSE 0 END AS 'STATUS' FROM t_permit_hdr WHERE KD_DOK_INOUT = '$kd'";
		/*$proses = array('ENTRY'  => array('MODAL',"coarri/discharge/add", '0','','md-plus-circle'),
						'UPDATE' => array('MODAL',"coarri/discharge/update", '1','','md-edit'),
						'DETAIL' => array('GET',site_url()."/coarri/discharge/detail", '1','','md-zoom-in'),
						'UPLOAD' => array('ADD',site_url()."/coarri/discharge/upload", '','','md-attachment'));*/
		$this->newtable->multiple_search(true);
		$this->newtable->show_chk(FALSE);
		$this->newtable->show_menu($check);
		$this->newtable->show_search(true);
		$arr_sts = array("" => "", "N" => "REQUEST", "Y" => "DONE");
		$this->newtable->search(array(array('CAR', 'CAR'), array('NO_DAFTAR_PABEAN', 'NO. PIB'), array('TGL_DAFTAR_PABEAN', 'TGL. PIB', 'DATERANGE'), array('STATUS', 'STATUS', 'OPTION', $arr_sts)));
		$this->newtable->action(site_url() . "/planning/spjm");
		if ($check) $this->newtable->detail(array('GET', site_url() . "/planning/" . $act . "/" . $act . "_detail"));
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("ID"));
		$this->newtable->keys(array("ID"));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby('4,9');
		$this->newtable->sortby("ASC");
		$this->newtable->set_formid("tblkapal");
		$this->newtable->set_divid("divtblkapal");
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

	public function list_sppmp($act, $id)
	{
		$page_title = "SPPMP";
		$title = "SPPMP";
		$this->newtable->breadcrumb('SPPMP', site_url(), 'icon-home');
		$this->newtable->breadcrumb('Planning', 'javascript:void(0)', '');
		$this->newtable->breadcrumb('Dokumen Sppmp', 'javascript:void(0)', '');
		$check = (grant() == "W") ? true : false;

		//$SQL = "SELECT A.ID_IJIN, A.JN_RESPON AS 'JENIS RESPON', A.NM_PARTNER AS 'NAMA PARTNER', A.NO_DAFTPPK AS 'NO DAFTAR', DATE_FORMAT(A.TG_DAFTPPK, '%d-%m-%Y') AS 'TGL. DAFTAR', CASE WHEN A.STATUS = 'N' THEN '<span style=\"color:red;font-weight:bold\">REQUEST</span>' WHEN STATUS = 'Y' THEN '<span style=\"color:green;font-weight:bold\">DONE</span>' ELSE 0 END AS 'STATUS' FROM t_ppk_hdr A, t_ppk_cont B WHERE A.ID_IJIN = B.ID_IJIN AND B.NO_TPFT IS NOT NULL";
		$SQL = "SELECT DISTINCT A.JN_RESPON AS 'RESPON',CONCAT('NO : ',(A.NO_RESPON), '<BR> TGL : ', (DATE_FORMAT(A.TG_RESPON, '%d-%m-%Y')))  AS 'DOKUMEN',
		CONCAT('',(A.ANGKUTNAMA_TPS),'<BR>',(A.ANGKUTNO_TPS)) AS 'VOYAGE',
		A.NM_PARTNER AS 'NAMA PARTNER', CASE WHEN A.STATUS = 'N' THEN '<span style=\"color:red;font-weight:bold\">REQUEST</span>' WHEN STATUS = 'Y' THEN '<span style=\"color:green;font-weight:bold\">DONE</span>' ELSE 0 END AS 'STATUS', A.ID_IJIN
		FROM t_ppk_hdr A
		INNER JOIN t_ppk_cont B ON A.ID_IJIN = B.ID_IJIN";

		/*$proses = array('SEND MAIL'  => array('MODAL',"planning/execute_dokumen_ctrl/save/request_sppmp/", '1','','md-email','','list'),'EXPORT EXCEL' => array('EXCEL', "process2/excel/sppmp/".$act, '0','','md-file-text','','menu'));*/
		$this->newtable->multiple_search(true);
		$this->newtable->show_chk(false);
		$this->newtable->show_menu($check);
		$this->newtable->show_search(true);
		$arr_sts = array("" => "", "N" => "REQUEST", "Y" => "DONE");
		$this->newtable->search(array(array('A.NO_RESPON', 'NO. DAFTAR'), array('NO_TPFT', 'NO. TPFT'), array('TG_DAFTPPK', 'TGL. DAFTAR', 'DATERANGE'), array('STATUS', 'STATUS', 'OPTION', $arr_sts), array('NO_CONT', 'NO. KONTAINER')));
		$this->newtable->action(site_url() . "/planning/sppmp");
		if ($check) $this->newtable->detail(array('POPUP', "planning/sppmp/sppmp_detail"));
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("ID_IJIN", "RESPON"));
		$this->newtable->keys(array("ID_IJIN"));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby('5 DESC, TG_DAFTPPK ASC');
		$this->newtable->sortby("");
		$this->newtable->set_formid("tblkapal");
		$this->newtable->set_divid("divtblkapal");
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

	public function list_sppb($act, $id)
	{
		$page_title = "SPPB";
		$title = "SPPB";
		$this->newtable->breadcrumb('SPPB', site_url(), 'icon-home');
		$this->newtable->breadcrumb('Planning', 'javascript:void(0)', '');
		$this->newtable->breadcrumb('Dokumen Sppb', 'javascript:void(0)', '');
		$check = (grant() == "W") ? true : false;
		if ($act == 'sppb') {
			$kd = "1";
			//$addsql .= " AND A.KD_DOK_INOUT IN('1')";
			//$alias = 'SPPB BC (2.0)';
		} else if ($act == "sppmp") {
			$kd = "19";
			//$addsql .= " AND A.KD_DOK_INOUT IN('2')";
			//$alias = 'SPPB BC (2.3)';
		} else if ($act == 'spjm') {
			$kd = "19";
			//$addsql .= " AND A.KD_DOK_INOUT IN('19')";
			//$alias = 'SPJM';
		} else {
			//$addsql .= " AND A.KD_DOK_INOUT NOT IN('1','19','2')";
			//$alias = 'DOKUMEN';
		}
		/*$SQL = "SELECT ID, KD_KANTOR AS 'KODE KANTOR',CONCAT('NO : ', (NO_DOK_INOUT), '<BR> TGL : ', (DATE_FORMAT(TGL_DOK_INOUT, '%d-%m-%Y'))) AS 'DOKUMEN',
		CONCAT('NPWP : ',(ID_CONSIGNEE),'<BR>NAMA : ',(CONSIGNEE)) AS 'IMPORTIR',
		CONCAT('NO : ',(NO_BC11),'<BR> TGL : ', (DATE_FORMAT(TGL_BC11, '%d-%m-%Y'))) AS 'BC 11'
		FROM t_permit_hdr
		WHERE KD_DOK_INOUT = '$kd' AND DATE_FORMAT(TGL_DOK_INOUT, '%Y') = '2017'";*/
		$SQL = "SELECT A.ID, A.KD_KANTOR AS 'KODE KANTOR', CONCAT('NO : ', (A.NO_DOK_INOUT), '<BR> TGL : ', (DATE_FORMAT(A.TGL_DOK_INOUT, '%d-%m-%Y'))) AS 'DOKUMEN', CONCAT('NPWP : ',(A.ID_CONSIGNEE),'<BR>NAMA : ',(A.CONSIGNEE)) AS 'IMPORTIR', CONCAT('NO : ',(A.NO_BC11),'<BR> TGL : ', (DATE_FORMAT(A.TGL_BC11, '%d-%m-%Y'))) AS 'BC 11'
			FROM t_permit_hdr A
			INNER JOIN t_permit_cont B ON A.ID = B.ID
			WHERE A.KD_DOK_INOUT = '1' AND DATE_FORMAT(A.TGL_DOK_INOUT, '%Y') in ('2017','2018','2019')";
		$proses = array('EXPORT EXCEL' => array('EXCEL', "process2/excel/sppb/" . $act, '0', '', 'md-file-text', '', 'menu'));
		/*$proses = array('ENTRY'  => array('MODAL',"coarri/discharge/add", '0','','md-plus-circle'),
						'UPDATE' => array('MODAL',"coarri/discharge/update", '1','','md-edit'),
						'DETAIL' => array('GET',site_url()."/coarri/discharge/detail", '1','','md-zoom-in'),
						'UPLOAD' => array('ADD',site_url()."/coarri/discharge/upload", '','','md-attachment'));*/
		$this->newtable->multiple_search(true);
		$this->newtable->show_chk(FALSE);
		$this->newtable->show_menu($check);
		$this->newtable->show_search(true);
		$this->newtable->search(array(array('CONSIGNEE', 'NAMA IMPORTIR'), array('NO_DOK_INOUT', 'NO. SPPB'), array('TGL_DOK_INOUT', 'TGL. SPPB', 'DATERANGE'), array('NO_CONT', 'NO. KONTAINER')));
		$this->newtable->action(site_url() . "/planning/sppb");
		if ($check) $this->newtable->detail(array('POPUP', "planning/" . $act . "/" . $act . "_detail"));
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("ID"));
		$this->newtable->keys(array("ID"));
		$this->newtable->cidb($this->db);
		$this->newtable->groupby(array("NO_DOK_INOUT"));
		$this->newtable->orderby(ID);
		$this->newtable->sortby("DESC");
		$this->newtable->set_formid("tblkapal");
		$this->newtable->set_divid("divtblkapal");
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

	public function list_coarri($act, $id)
	{
		$page_title = "COARRI";
		$title = "COARRI";
		$this->newtable->breadcrumb('COARRI', site_url(), 'icon-home');
		$this->newtable->breadcrumb('Planning', 'javascript:void(0)', '');
		$this->newtable->breadcrumb('Dokumen Coarri', 'javascript:void(0)', '');
		$check = (grant() == "W") ? true : false;

		$SQL = "SELECT B.ID, CONCAT(B.NO_CONT,'<BR>',B.UK_CONT) AS 'KONTAINER', CONCAT(A.NM_ANGKUT,'<BR>',A.NO_VOY_FLIGHT) AS 'KAPAL', A.CALL_SIGN AS 'CALL SIGN', A.TGL_TIBA AS 'TGL. TIBA', CONCAT(B.NO_BC11,'<BR>',B.TGL_BC11) AS 'BC11', B.ID_CONSIGNEE AS 'NPWP', B.CONSIGNEE AS 'CONSIGNEE'
			FROM t_cocostshdr A
			LEFT JOIN t_cocostscont B ON A.ID = B.ID
			WHERE KD_ASAL_BRG ='1'";
		//$proses = array('EXPORT EXCEL' => array('EXCEL', "process2/excel/sppb/".$act, '0','','md-file-text','','menu'));
		/*$proses = array('ENTRY'  => array('MODAL',"coarri/discharge/add", '0','','md-plus-circle'),
						'UPDATE' => array('MODAL',"coarri/discharge/update", '1','','md-edit'),
						'DETAIL' => array('GET',site_url()."/coarri/discharge/detail", '1','','md-zoom-in'),
						'UPLOAD' => array('ADD',site_url()."/coarri/discharge/upload", '','','md-attachment'));*/
		$this->newtable->multiple_search(true);
		$this->newtable->show_chk(FALSE);
		$this->newtable->show_menu($check);
		$this->newtable->show_search(true);
		$this->newtable->search(array(array('NM_ANGKUT', 'NAMA KAPAL'), array('NO_CONT', 'NO. KONTAINER'), array('NO_BC11', 'NO. BC11')));
		$this->newtable->action(site_url() . "/planning/coarri");
		//if($check) $this->newtable->detail(array('POPUP',"planning/".$act."/".$act."_detail"));
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("ID"));
		$this->newtable->keys(array("ID"));
		$this->newtable->cidb($this->db);
		$this->newtable->groupby(array("TGL_TIBA"));
		$this->newtable->orderby(ID);
		$this->newtable->sortby("DESC");
		$this->newtable->set_formid("tblkapal");
		$this->newtable->set_divid("divtblkapal");
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

	public function gate_pass($act, $id)
	{
		$page_title = 'REQ GATE PASS';
		$title = "REQ GATE PASS";
		$this->newtable->breadcrumb('Gate Pass', site_url() . "/planning/gate_pass", 'icon-home');
		$this->newtable->breadcrumb('Planning', 'javascript:void(0)', '');
		$this->newtable->breadcrumb('Dokumen Gate Pass', 'javascript:void(0)', '');
		$check = (grant() == "W") ? true : false;
		if ($act == 'sppb') {
			//$addsql .= " AND A.KD_DOK_INOUT IN('1')";
			//$alias = 'SPPB BC (2.0)';
		} else if ($act == "sppb_bc23") {
			//$addsql .= " AND A.KD_DOK_INOUT IN('2')";
			//$alias = 'SPPB BC (2.3)';
		} else if ($act == 'gate_pass_request') {
			$kd = "19";
			//$addsql .= " AND A.KD_DOK_INOUT IN('19')";
			//$alias = 'SPJM';
		} else {
			//$addsql .= " AND A.KD_DOK_INOUT NOT IN('1','19','2')";
			//$alias = 'DOKUMEN';
		}
		$SQL = "SELECT DISTINCT X.ID, X.NO_CONT,
			X.JENIS_DOKUMEN AS 'JENIS DOKUMEN',
			CONCAT('NO : ',(X.NO_DOKUMEN),'<BR>TGL : ', (DATE_FORMAT(X.TGL_DOKUMEN,'%d-%m-%Y'))) AS 'DOKUMEN',
			CONCAT('',(X.ANGKUTNAMA_TPS),'<BR>',(X.ANGKUTNO_TPS)) AS 'VOYAGE',
			CASE WHEN X.TANGGAL_REQUEST IS NOT NULL THEN DATE_FORMAT(X.TANGGAL_REQUEST,'%d-%m-%Y %H:%i:%s') ELSE '-' END AS 'TANGGAL REQUEST',
			X.STATUS_PENGIRIMAN AS 'STATUS PENGIRIMAN',
			X.STATUS
			FROM (
			SELECT A.ID AS 'ID', A.ANGKUTNAMA_TPS, A.ANGKUTNO_TPS, B.NO_CONT,
			CASE WHEN A.KD_DOK_INOUT = '19' THEN 'SPJM' ELSE 'NHI' END AS 'JENIS_DOKUMEN',
			A.NO_DAFTAR_PABEAN AS 'NO_DOKUMEN',
			A.TGL_DAFTAR_PABEAN AS 'TGL_DOKUMEN',
			A.WK_STATUS AS 'TANGGAL_REQUEST',
			CASE WHEN A.STATUS_MAIL IS NULL THEN '<span class=\"label label-primary\">Email Belum Di Proses</span>'
			WHEN A.STATUS_MAIL = 'Email Tidak Terkirim' THEN '<span class=\"label label-danger\">Email Tidak Terkirim</span>'
			WHEN A.STATUS_MAIL = 'Email Terkirim' THEN '<span class=\"label label-success\">Email Terkirim</span>' END AS 'STATUS_PENGIRIMAN',
			CASE WHEN A.STATUS = 'N' THEN '<span style=\"color:red;font-weight:bold\">REQUEST</span>'
			WHEN A.STATUS = 'Y' THEN '<span style=\"color:green;font-weight:bold\">DONE</span>' ELSE 0 END AS 'STATUS'
			FROM t_permit_hdr A, t_permit_cont B WHERE A.ID = B.ID AND A.KD_DOK_INOUT IN('19','81','82') AND DATE_FORMAT(A.TGL_DAFTAR_PABEAN, '%Y') = '2017' GROUP BY ID

			UNION ALL

			SELECT A.ID_IJIN AS 'ID', A.ANGKUTNAMA_TPS, A.ANGKUTNO_TPS, B.NO_CONT,
			 'SPPMP' AS 'JENIS_DOKUMEN',
			 A.NO_DAFTPPK AS 'NO_DOKUMEN',
			 A.TG_DAFTPPK AS 'TGL_DOKUMEN',
			 WK_STATUS AS 'TANGGAL_REQUEST',
			CASE WHEN STATUS_MAIL IS NULL THEN '<span class=\"label label-primary\">Email Belum Di Proses</span>'
			WHEN STATUS_MAIL = 'Email Tidak Terkirim' THEN '<span class=\"label label-danger\">Email Tidak Terkirim</span>'
			WHEN STATUS_MAIL = 'Email Terkirim'  THEN '<span class=\"label label-success\">Email Terkirim</span>'  END AS 'STATUS_PENGIRIMAN',

			CASE WHEN A.STATUS = 'N' THEN '<span style=\"color:red;font-weight:bold\">REQUEST</span>'
			WHEN STATUS = 'Y' THEN '<span style=\"color:green;font-weight:bold\">DONE</span>' ELSE 0 END AS 'STATUS'

			FROM t_ppk_hdr A, t_ppk_cont B WHERE A.ID_IJIN = B.ID_IJIN AND B.NO_TPFT IS NOT NULL AND DATE_FORMAT(A.TG_DAFTPPK, '%Y') = '2017' GROUP BY ID ) X WHERE 1 = 1";
		//echo $SQL;
		$proses = array(
			'SEND MAIL'  => array('POST', "planning/request/save/request", '1', '', 'md-email', '', 'list'),
			'PRINT EXCEL'  => array('EXCEL', "proces/excel/gatepass", '0', '', 'md-file-text', '', 'menu')
		);
		/*'UPDATE' => array('MODAL',"coarri/discharge/update", '1','','md-edit'),
						'DETAIL' => array('GET',site_url()."/coarri/discharge/detail", '1','','md-zoom-in'),
						'UPLOAD' => array('ADD',site_url()."/coarri/discharge/upload", '','','md-attachment'));*/
		$this->newtable->multiple_search(true);
		$this->newtable->show_chk(FALSE);
		$this->newtable->show_menu($check);
		$this->newtable->show_search(true);
		$arr_dok = array("" => "", "SPJM" => "SPJM", "SPPMP" => "SPPMP");
		$arr_sts = array("" => "", "Email Terkirim" => "Email Terkirim", "Email Tidak Terkirim" => "Email Tidak Terkirim");
		$this->newtable->search(array(
			array('X.NO_CONT', 'NO. KONTAINER'),
			array('X.ANGKUTNAMA_TPS', 'NAMA KAPAL'),
			array('X.ANGKUTNO_TPS', 'NO. VOYAGE'),
			array('X.NO_DOKUMEN', 'NO. DOKUMEN'),
			array(
				'X.JENIS_DOKUMEN',
				'JENIS DOKUMEN',
				'OPTION',
				$arr_dok
			),
			array('X.STATUS_PENGIRIMAN ', 'STATUS PENGIRIMAN', 'OPTION', $arr_sts)
		));
		$this->newtable->action(site_url() . "/planning/gate_pass");
		if ($check) $this->newtable->detail(array('POPUP', "planning/gate_pass/gate_pass_request_spjmn_detail"));
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("ID", "NO_CONT"));
		$this->newtable->keys(array("ID", "JENIS DOKUMEN"));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby("TGL_DOKUMEN ASC, STATUS DESC");
		$this->newtable->sortby("");
		$this->newtable->groupby("ID");
		$this->newtable->set_formid("tblkapal123");
		$this->newtable->set_divid("divtblkapal123");
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

	public function relokasi1($act, $id)
	{
		$page_title = 'RELOKASI JOB SLIP';
		$title = "";
		//$this->newtable->breadcrumb('Planning', site_url(),'icon-home');
		$this->newtable->breadcrumb('Planning', 'javascript:void(0)', '');
		$this->newtable->breadcrumb('job slip', 'javascript:void(0)', '');
		$this->newtable->breadcrumb('relokasi', 'javascript:void(0)', '');
		$check = (grant() == "W") ? true : false;
		$SQL = "SELECT ID_JOB_SLIP, CONCAT(JNS_JOB_SLIP,'<BR>', IFNULL(JENIS,'-')) AS 'JENIS', NO_SPK AS 'NO SPK',NO_GATEPASS AS 'NO GATE PASS', NO_CONT AS 'NO KONTAINER', 
				CASE WHEN LEFT(LOKASI_AKHIR,3) = 'CIC' THEN LOKASI_AKHIR ELSE CONCAT(LOKASI_AKHIR,'0', TIER_AKHIR) END AS 'LOKASI AKHIR'
				FROM t_job_slip
				WHERE STATUS='WAITING' AND LOKASI_AKHIR IS NOT NULL AND NO_SPK IS NOT NULL AND JNS_JOB_SLIP IS NOT NULL";
		$proses = array(
			'SET LOCATION' => array('GET', site_url() . "/planning/relokasi1/add", '1', '', 'md-gps-dot', '', 'menu')
		);

		$this->newtable->multiple_search(true);
		$this->newtable->show_chk(true);
		$this->newtable->show_menu(true);
		$this->newtable->show_search(true);
		$this->newtable->search(array(array('NO_SPK', 'NO.SPK'), array('NO_CONT', 'NO. KONTAINER'), array('NO_GATEPASS', 'NO. GATE PASS')));
		$this->newtable->action(site_url() . "/planning/relokasi1");
		//if($check) $this->newtable->detail(array('GET',site_url()."/planning/".$act."/".$act."_detail"));
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("ID_JOB_SLIP"));
		$this->newtable->keys(array("ID_JOB_SLIP"));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby(1);
		$this->newtable->sortby("DESC");
		$this->newtable->set_formid("tblrelokasi1");
		$this->newtable->set_divid("divrelokasi1");
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

	public function plan_placement($act, $id)
	{
		$page_title = 'JOB SLIP';
		$title = "JOB SLIP";
		$this->newtable->breadcrumb('Planning', 'javascript:void(0)', '');
		$this->newtable->breadcrumb('job slip', 'javascript:void(0)', '');
		$check = (grant() == "W") ? true : false;

		$SQL = "SELECT A.ID_JOB_SLIP, CONCAT(A.JNS_JOB_SLIP,'<BR>', IFNULL(A.JENIS,'SELESAI PRIKSA')) AS 'JENIS', A.NO_DOK AS 'DOKUMEN', case when B.LNSW_TGLAJU IS NOT NULL then CONCAT(B.LNSW_NOAJU,'<BR>',B.LNSW_TGLAJU) else '-' END AS 'DOKUMEN JOIN INSPECTION',A.NO_SPK AS 'NO SPK',A.NO_GATEPASS AS 'NO GATE PASS', A.NO_CONT AS 'NO KONTAINER', DATE_FORMAT(TGL_GATEPASS,'%d-%m-%Y') AS 'TGL. GATE PASS', CASE WHEN
		LEFT(A.LOKASI_AWAL,3) = 'CIC' THEN LOKASI_AWAL WHEN A.LOKASI_AWAL IS NULL THEN 'TERMINAL' ELSE CONCAT(A.LOKASI_AWAL,'0', A.TIER_AWAL) END AS 'LOKASI AWAL', A.LOKASI_AKHIR AS 'LOKASI AKHIR'
		FROM t_job_slip A
		LEFT JOIN v_ppk_permit_join B ON A.NO_DOK = B.NO_RESPON AND A.NO_CONT = B.NO_CONT
		WHERE A.STATUS='WAITING' AND A.LOKASI_AKHIR IS NULL AND A.NO_SPK IS NOT NULL AND A.JNS_JOB_SLIP IS NOT NULL";

		$proses = array('ROLLBACK' => array('MODAL', "planning/placement/relokasi", '0', '', 'md-undo', '', 'menu'));

		$this->newtable->multiple_search(true);
		$this->newtable->show_chk(false);
		$this->newtable->show_menu($check);
		$this->newtable->show_search(true);
		$this->newtable->search(array(array('A.NO_SPK', 'NO.SPK'), array('A.NO_CONT', 'NO. KONTAINER'), array('A.NO_DOK', 'NO. DOKUMEN'), array('A.NO_GATEPASS', 'NO. GATE PASS')));
		$this->newtable->action(site_url() . "/planning/placement/plan_placement");
		$this->newtable->detail(array('GET', site_url() . "/planning/placement/placement_lokasi_detail"));
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("ID_JOB_SLIP"));
		$this->newtable->keys(array("ID_JOB_SLIP"));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby(1);
		$this->newtable->sortby("DESC");
		$this->newtable->set_formid("tblkapal");
		$this->newtable->set_divid("divtblkapal");
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


	public function plan_placement_att_behanddle($act, $id)
	{
		$page_title = 'ATT Behandle';
		$title = "ATT Behandle";
		$this->newtable->breadcrumb('Dashboard', site_url(), 'icon-home');
		$this->newtable->breadcrumb('Planning', 'javascript:void(0)', '');
		$this->newtable->breadcrumb('ATT Behandle', 'javascript:void(0)', '');
		$check = (grant() == "W") ? true : false;

		$SQL = "SELECT A.NO_SPK, A.NO_CONT as 'CONT_ID', A.NO_DOK as 'NO_DOCUMENT', A.TGL_DOK as 'DOCUMENT_DATE', A.NO_SEAL FROM t_op_inspection A
		WHERE DATE(A.TGL_DOK ) >= DATE_ADD(NOW(), interval - 2 MONTH) and A.STATUS='WAITING' AND A.NO_SPK IS NOT NULL";

		//$proses = array('ROLLBACK' => array('MODAL',"planning/placement/relokasi", '0','','md-undo','','menu'));

		$this->newtable->multiple_search(true);
		$this->newtable->show_chk(false);
		$this->newtable->show_menu($check);
		$this->newtable->show_search(true);
		$this->newtable->search(array(array('A.NO_SPK', 'NO.SPK'), array('A.NO_CONT', 'NO. KONTAINER')));
		//$this->newtable->action(site_url() . "/planning/placement/plan_placement_att_behanddle");
		//$this->newtable->detail(array('GET',site_url()."/planning/placement/placement_lokasi_detail"));
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("ID_JOB_SLIP"));
		$this->newtable->keys(array("ID_JOB_SLIP"));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby(1);
		$this->newtable->sortby("DESC");
		$this->newtable->set_formid("tblkapal");
		$this->newtable->set_divid("divtblkapal");
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

	public function  getAreaGudang()
	{
		$func = get_instance();
		$func->load->model("m_main", "main", true);
		$SQL = "SELECT * FROM reff_gudang_dtl WHERE KD_GUDANG_DTL = " . $this->db->escape($this->input->post('id'));

		$result = $func->main->get_result($SQL);
		$table = '<table border="1" class="myTable" style="border-collapse: collapse;width:100%;" cellpadding="8" >';
		if ($result) {
			foreach ($SQL->result_array() as $row) {

				$SQLDETIL = "SELECT KD_GUDANG_DTL, NM_BLOK, LEVEL_1, LEVEL_2, LEVEL_3, LEVEL_4, IDDATA, KD_STATUS
			  		FROM t_denah_lapangan
			  		WHERE KD_GUDANG_DTL =  '" . $row['KD_GUDANG_DTL'] . "'  AND LEVEL_4 = 1  ORDER BY IDDATA ASC";

				$resultdtl = $func->main->get_result($SQLDETIL);
				if ($resultdtl) {
					$arrdetil = array();
					foreach ($SQLDETIL->result_array() as $dtl) {
						$arrdetil[lebar][$dtl['LEVEL_3']][$dtl['LEVEL_2']] = $dtl['LEVEL_1'];
						$arrdetil[nm_blok][$dtl['LEVEL_3']][$dtl['LEVEL_2']] = $dtl['NM_BLOK'];

						$SQL_TIER = "SELECT COUNT(*) AS TOTAL FROM t_denah_lapangan A WHERE A.USE = '0' AND A.LEVEL_1 = '" . $dtl['LEVEL_1'] . "'";
						$resultTier = $this->db->query($SQL_TIER)->row();
						$arrdetil[tier][$dtl['LEVEL_3']][$dtl['LEVEL_2']] = $resultTier->TOTAL;
					}
				}

				for ($a = 0; $a < $row['PANJANG']; $a++) {
					$table .= "<tr>";
					for ($b = 0; $b < $row['LEBAR']; $b++) {
						$clik = 'onclick=""';
						$val = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
						$style = "background-color:#fff;color:#fff;width:100px;text-space-collapse;border:0px solid #fff";
						if ($arrdetil['lebar'][$a][$b] != "") {
							$clik = 'onclick="getActDtl1(this.id)"';
							$val = $arrdetil['nm_blok'][$a][$b];
							$style = "background-color:green;color:#FFF";

							$getDataDenah = $this->get_data('totalCont', $val);
							if ($getDataDenah != '') {
								$hitung = floatval($getDataDenah[0]['total']) / floatval($getDataDenah[0]['tier']);
								$hitungan = number_format($hitung, 2, '.', '');
								if ($hitungan == 1) {
									$style = "background-color:red;color:#FFF";
								} else if ($hitungan > 0.5 && $hitungan < 1) {
									$style = "background-color:orange;color:#FFF";
								} else if ($hitungan >= 0.25 && $hitungan <= 0.5) {
									$style = "background-color:blue;color:#FFF";
								}
							}

							if ($arrdetil['tier'][$a][$b] == 0) {
								$clik = 'onclick="alertMsg()"';
								$style = "background-color:red;color:#FFF";
							}
						}

						$table .= "<td " . $clik . " style=" . $style . " class=\"star\" id=\"" . $this->input->post('id') . "/" . $b . "-" . $a . "-" . $val . "\" >" . $val . "</td>";
					}
					$table .= "</tr>";
				}
			}
			$table .= "</table>";
			return $table;
		} else {
			redirect(site_url(), 'refresh');
		}
	}

	public function insertGudang($act, $id)
	{
		$ID_JOB = $this->input->post('ID_JOB');
		$NO_SPK = $this->input->post('NO_SPK');
		$SQLID = $this->db->query("SELECT * FROM t_spk	WHERE NO_SPK='$NO_SPK' ")->row_array();
		$IDSPK = $SQLID['ID'];
		$GUDANG = $this->input->post('KODE_GDG');
		$BLOK = $this->input->post('BLOK');
		$LOK_AKHIR = $this->input->post('LOK_AKHIR');
		$NO_CONT = $this->input->post('NO_CONT');
		$PENUMPUKAN = $this->input->post('PENUMPUKAN');
		$JNS_KEGIATAN = $this->input->post('JNS_KEGIATAN');
		$NO_DOK = $this->input->post('NO_DOK');
		$LOKASI_AWAL = $this->input->post('LOKASI_AWAL');
		$X = $this->input->post('X');
		$Y = $this->input->post('Y');
		$VAL = $X . "-" . $Y;

		$SQL_JOBSLIP = $this->db->query("SELECT * FROM t_job_slip WHERE ID_JOB_SLIP = '" . $ID_JOB . "' AND NO_CONT = '" . $NO_CONT . "' GROUP BY NO_CONT ORDER BY ID_JOB_SLIP DESC")->row_array();

		$SQLSTATUSCONT = $this->db->query("SELECT A.STATUS_CONT FROM t_spk_cont A INNER JOIN t_spk B ON A.ID = B.ID WHERE B.ID = '" . $IDSPK . "' AND B.NO_SPK='" . $NO_SPK . "' AND A.NO_CONT = '" . $NO_CONT . "'")->row();
		$STATUSCONT = $SQLSTATUSCONT->STATUS_CONT;

		if ($STATUSCONT == 450 || $STATUSCONT == 460 || $STATUSCONT == 500) {
			$cekCIC = substr($LOK_AKHIR, 0, 3);
			if ($cekCIC == 'CIC') {
				if ($JNS_KEGIATAN == '1') {
					$ubahlokasi = array(
						'STATUS_CONT' => '510'
					);
					$this->db->where(array('ID' => $IDSPK, 'NO_CONT' => $NO_CONT));
					$this->db->update('t_spk_cont', $ubahlokasi);
				} else if ($JNS_KEGIATAN == '2') {
					$ubahlokasi = array(
						'STATUS_CONT' => '530'
					);
					$this->db->where(array('ID' => $IDSPK, 'NO_CONT' => $NO_CONT));
					$this->db->update('t_spk_cont', $ubahlokasi);
				}

				$dataPlan = array(
					'NO_DOK' 	   	=> $SQL_JOBSLIP['NO_DOK'],
					'NO_CONT'	   	=> $NO_CONT,
					'NO_GATEPASS'  	=> $SQL_JOBSLIP['NO_GATEPASS'],
					'TGL_GATEPASS' 	=> $SQL_JOBSLIP['TGL_GATEPASS'],
					'LOKASI_AKHIR' 	=> $LOK_AKHIR,
					'TIER_AKHIR' 	=> $PENUMPUKAN,
					'STATUS'		=> 'WAITING',
					'KD_STATUS'		=> '20',
					'WK_STATUS'		=> date('Y-m-d H:i:s'),
					'OPERATOR' 		=> $this->session->userdata('USERLOGIN')
				);
				$this->db->where(array('ID_JOB_SLIP' => $ID_JOB, 'NO_SPK' => $NO_SPK, 'NO_CONT' => $NO_CONT));
				$this->db->update('t_job_slip', $dataPlan);
				echo "success";
			} elseif ((substr($LOK_AKHIR, 0, 2) == "1A") || (substr($LOK_AKHIR, 0, 2) == "1B")) {
				if ($JNS_KEGIATAN == '1') {
					$ubahlokasi = array(
						'STATUS_CONT' => '520'
					);
					$this->db->where(array('ID' => $IDSPK, 'NO_CONT' => $NO_CONT));
					$this->db->update('t_spk_cont', $ubahlokasi);
				} else if ($JNS_KEGIATAN == '2') {
					$ubahlokasi = array(
						'STATUS_CONT' => '540'
					);
					$this->db->where(array('ID' => $IDSPK, 'NO_CONT' => $NO_CONT));
					$this->db->update('t_spk_cont', $ubahlokasi);
				}

				$dataPlan = array(
					'NO_DOK' 	   	=> $SQL_JOBSLIP['NO_DOK'],
					'NO_CONT'	   	=> $NO_CONT,
					'NO_GATEPASS'  	=> $SQL_JOBSLIP['NO_GATEPASS'],
					'TGL_GATEPASS' 	=> $SQL_JOBSLIP['TGL_GATEPASS'],
					'LOKASI_AKHIR' 	=> $LOK_AKHIR,
					'TIER_AKHIR' 	=> $PENUMPUKAN,
					'STATUS'		=> 'WAITING',
					'KD_STATUS'		=> '20',
					'WK_STATUS'		=> date('Y-m-d H:i:s'),
					'OPERATOR' 		=> $this->session->userdata('USERLOGIN')
				);
				$this->db->where(array('ID_JOB_SLIP' => $ID_JOB, 'NO_SPK' => $NO_SPK, 'NO_CONT' => $NO_CONT));
				$this->db->update('t_job_slip', $dataPlan);
			}
			echo "success";
		} else {
			$dataPlan = array(
				'NO_DOK' 	   	=> $SQL_JOBSLIP['NO_DOK'],
				'NO_CONT'	   	=> $NO_CONT,
				'NO_GATEPASS'  	=> $SQL_JOBSLIP['NO_GATEPASS'],
				'TGL_GATEPASS' 	=> $SQL_JOBSLIP['TGL_GATEPASS'],
				'LOKASI_AKHIR' 	=> $LOK_AKHIR,
				'TIER_AKHIR' 	=> $PENUMPUKAN,
				'STATUS'		=> 'WAITING',
				'KD_STATUS'		=> '20',
				'WK_STATUS'		=> date('Y-m-d H:i:s'),
				'OPERATOR' 		=> $this->session->userdata('USERLOGIN')
			);
			$this->db->where(array('ID_JOB_SLIP' => $ID_JOB, 'NO_SPK' => $NO_SPK, 'NO_CONT' => $NO_CONT));
			$this->db->update('t_job_slip', $dataPlan);

			$dataPlanSpk = array(
				'LOKASI' => $LOK_AKHIR,
				'TIER' => $PENUMPUKAN
			);
			$this->db->where(array('ID' => $IDSPK, 'NO_CONT' => $NO_CONT));
			$this->db->update('t_spk_cont', $dataPlanSpk);
			echo "success";
		}
	}

	public function list_relokasi($act, $id)
	{
		$page_title = 'JOB SLIP';
		$title = "JOB SLIP";
		$this->newtable->breadcrumb('Planning', 'javascript:void(0)', '');
		$this->newtable->breadcrumb('job slip', 'javascript:void(0)', '');
		$check = (grant() == "W") ? true : false;

		$SQL = "SELECT ID_JOB_SLIP, CONCAT(JNS_JOB_SLIP,'<BR>', IFNULL(JENIS,'-')) AS 'JENIS', NO_SPK AS 'NO SPK',NO_GATEPASS AS 'NO GATE PASS', NO_CONT AS 'NO KONTAINER', 
		CASE WHEN LEFT(LOKASI_AKHIR,3) = 'CIC' THEN LOKASI_AKHIR ELSE CONCAT(LOKASI_AKHIR,'0', TIER_AKHIR) END AS 'LOKASI AKHIR'
		FROM t_job_slip
		WHERE STATUS='WAITING' AND LOKASI_AKHIR IS NOT NULL AND NO_SPK IS NOT NULL AND JNS_JOB_SLIP IS NOT NULL";

		$proses = array('SET LOCATION' => array('GET', site_url() . "/planning/placement/relokasi_add", '1', '', 'md-gps-dot', '', 'menu'));

		$this->newtable->multiple_search(true);
		$this->newtable->show_chk(true);
		$this->newtable->show_menu(true);
		$this->newtable->show_search(true);
		$this->newtable->search(array(array('NO_SPK', 'NO.SPK'), array('NO_CONT', 'NO. KONTAINER'), array('NO_GATEPASS', 'NO. GATE PASS')));
		$this->newtable->action(site_url() . "/planning/placement/relokasi");
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("ID_JOB_SLIP"));
		$this->newtable->keys(array("ID_JOB_SLIP"));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby(1);
		$this->newtable->sortby("DESC");
		$this->newtable->set_formid("tblrelokasi1");
		$this->newtable->set_divid("divrelokasi1");
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

	public function list_gate_pass_spjmn($act, $id)
	{
		$func = get_instance();
		$func->load->model("m_main", "main", true);
		$title = "";
		/*$KD_TPS = $this->session->userdata('KD_TPS');
        $KD_GUDANG = $this->session->userdata('KD_GUDANG');
        $KD_GROUP = $this->session->userdata('KD_GROUP');*/
		$check = (grant() == "W") ? true : false;
		//$arrid = explode("~",$id);
		if ($act == 'gate_pass_request2') {
			$kd = "19";
		}
		$SQL = "SELECT A.ID,A.CAR, KD_KANTOR AS 'KODE KANTOR',
                        A.NO_DAFTAR_PABEAN AS 'NO. PIB', A.TGL_DAFTAR_PABEAN AS 'TGL PIB', B.NO_CONT AS 'NO. KONTAINER',
								A.ID_CONSIGNEE AS 'NPWP IMPORTIR',
                        A.CONSIGNEE AS 'NAMA IMPORTIR', A.NPWP_PPJK AS 'NPWP PPJK', A.NAMA_PPJK AS 'NAMA PPJK',
								A.NO_BC11 AS 'NO BC 11',
                        A.TGL_BC11 AS 'TGL. BC 11' FROM t_permit_hdr A INNER JOIN t_permit_cont B ON A.ID = B.ID WHERE A.KD_DOK_INOUT = '$kd' AND A.STATUS ='N'";
		#echo $SQL;
		$proses = array('SEND MAIL'  => array('POST', "planning/execute/save/request", '1', '', 'md-email'));
		$this->newtable->multiple_search(true);
		$this->newtable->show_chk($check);
		$this->newtable->show_menu($check);
		$this->newtable->show_search(true);
		$this->newtable->search(array(array('CAR', 'CAR'), array('NO_CONT', 'NO. KONTAINER'), array('CONSIGNEE', 'NAMA IMPORTIR')));
		$this->newtable->action(site_url() . "/planning/gate_pass2/" . $act);
		if ($check) $this->newtable->detail(array('POPUP', "/planning/gate_pass/gate_pass_request_spjmn/" . $id));
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("ID", "KODE DOKUMEN"));
		$this->newtable->keys(array("ID"));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby(1);
		$this->newtable->sortby("DESC");
		$this->newtable->set_formid("tbldetail");
		$this->newtable->set_divid("divtbldetail");
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

	public function list_spk_req_spjm($act, $id)
	{
		$func = get_instance();
		$func->load->model("m_main", "main", true);
		$title = "";
		$KD_TPS = $this->session->userdata('KD_TPS');
		$KD_GUDANG = $this->session->userdata('KD_GUDANG');
		$KD_GROUP = $this->session->userdata('KD_GROUP');
		$check = (grant() == "W") ? true : false;
		//$arrid = explode("~",$id);
		if ($act == 'spk_req_spjm') {
			$kd = "19";
		}
		$SQL = "SELECT ID, JNS_DOK AS 'JENIS DOKUMEN', NO_DOK AS 'NO. PIB', TGL_DOK AS 'TGL. PIB', WK_REQ AS 'WAKTU REQUEST' FROM t_request";
		#echo $SQL;
		$proses = array('Save'  => array('POST', "planning/execute/save/request", '1', '', 'md-plus-circle'));
		$this->newtable->multiple_search(true);
		$this->newtable->show_chk($check);
		$this->newtable->show_menu($check);
		$this->newtable->show_search(true);
		$this->newtable->search(array(array('NO_DOK', 'NO. PIB')));
		$this->newtable->action(site_url() . "/planning/spk_create/" . $act . "/" . $id);
		if ($check) $this->newtable->detail(array('POPUP', "/planning/spk/spk_create"));
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("ID", "KODE DOKUMEN"));
		$this->newtable->keys(array("ID"));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby(1);
		$this->newtable->sortby("DESC");
		$this->newtable->set_formid("tbldetail");
		$this->newtable->set_divid("divtbldetail");
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

	public function list_gate_pass_sppmp($act, $id)
	{
		//print_r($id);die();
		$func = get_instance();
		$func->load->model("m_main", "main", true);
		$title = "";
		$KD_TPS = $this->session->userdata('KD_TPS');
		$KD_GUDANG = $this->session->userdata('KD_GUDANG');
		$KD_GROUP = $this->session->userdata('KD_GROUP');
		$check = (grant() == "W") ? true : false;
		//$arrid = explode("~",$id);
		if ($act == 'gate_pass_request_sppmp') {
			$kd = "19";
		}
		/*$SQL = "SELECT ID,CAR, KD_KANTOR AS 'KODE KANTOR',
                        NO_DAFTAR_PABEAN AS 'NO. PIB', TGL_DAFTAR_PABEAN AS 'TGL PIB', ID_CONSIGNEE AS 'NPWP IMPORTIR',
                        CONSIGNEE AS 'NAMA IMPORTIR', NPWP_PPJK AS 'NPWP PPJK', NAMA_PPJK AS 'NAMA PPJK', NO_BC11 AS 'NO BC 11',
                        TGL_BC11 AS 'TGL. BC 11' FROM t_permit_hdr WHERE KD_DOK_INOUT = '$kd'";*/
		/*$SQL = "SELECT A.JN_RESPON AS 'JENIS RESPON', A.NM_PARTNER AS 'NAMA PARTNER', TMP_TIMBUN AS 'TEMPAT TIMBUN', JM_CONT AS 'JUMLAH KONTAINER',
		JM_BRG AS 'JUMLAH BARANG', B.NO_CONT, B.UKURAN
		FROM t_ppk_hdr A inner join t_ppk_cont B ON a.ID_IJIN = b.ID_IJIN";*/
		#echo $SQL;
		$SQL = "SELECT A.ID_IJIN, A.JN_RESPON AS 'JENIS RESPON', A.NM_PARTNER AS 'NAMA PARTNER', A.NO_DAFTPPK AS 'NO DAFTAR', A.TG_DAFTPPK AS 'TGL. DAFTAR',
				B.NO_CONT AS 'NOMOR KONTAINER'
				FROM t_ppk_hdr A INNER JOIN t_ppk_cont B ON A.ID_IJIN = B.ID_IJIN WHERE A.STATUS = 'N'";
		$proses = array('SEND MAIL'  => array('POST', "planning/execute/save/request_sppmp/", '1', '', 'md-email'));
		$this->newtable->multiple_search(true);
		$this->newtable->show_chk($check);
		$this->newtable->show_menu($check);
		$this->newtable->show_search(true);
		$this->newtable->search(array(array('NO_DAFTPPK', 'NO DAFTAR'), array('NO_CONT', 'NO. KONTAINER'), array('NM_PARTNER', 'NAMA IMPORTIR')));
		$this->newtable->action(site_url() . "/planning/gate_pass_sppmp/" . $act . "/" . $id);
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("ID_IJIN", "ID IJIN"));
		$this->newtable->keys(array("ID_IJIN"));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby(1);
		$this->newtable->sortby("DESC");
		$this->newtable->set_formid("tbldetail11");
		$this->newtable->set_divid("divtbldetail11");
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

	function execute($type, $act, $id)
	{
		$func = get_instance();
		$func->load->model("m_main", "main", true);
		$success = 0;
		$error = 0;
		if ($type == "save") {
			if ($act == "manual") {
				//echo "data"; die();
				foreach ($this->input->post('DATA') as $a => $b) {
					if ($b == "") $DATA[$a] = NULL;
					else $DATA[$a] = trim(strtoupper($b));
				}

				$kd_dok = $DATA['KD_DOK_INOUT'];
				$no_dok = $DATA['NO_DOK_INOUT'];
				$tgl_dok = $DATA['TGL_DOK_INOUT'];


				$SQLCekData = $this->db->query("SELECT A.* , B.NAMA
												FROM t_permit_hdr A
												INNER JOIN reff_kode_dok_bc B ON A.KD_DOK_INOUT = B.ID
												WHERE A.KD_DOK_INOUT = '$kd_dok' AND A.NO_DOK_INOUT = '$no_dok' AND A.TGL_DOK_INOUT = '$tgl_dok'")->row();
				$cek = count($SQLCekData);
				if ($cek == 1) {
					echo "MSG#ERR#Dokumen sudah ada!#";
				} else {
					foreach ($this->input->post('CONT') as $a => $b) {
						if ($b == "") $CONT[$a] = NULL;
						else $CONT[$a] = trim(strtoupper($b));
					}
					print_r($CONT);

					if ($_FILES['FOTO']['name'] != "") {
						$folder_path = date("Ymd");
						$uploads_dir = './assets/images/foto/' . $folder_path;
						if (!is_dir($uploads_dir))
							mkdir($uploads_dir);
						$uploads_dir .= "/";
						$orig_name = $_FILES['FOTO']['name'];
						$change_name = date("His") . "." . pathinfo($orig_name, PATHINFO_EXTENSION);
						$path = 'assets/images/foto/' . $folder_path . "/" . $change_name;
						ini_set('upload_max_filesize', '5M');
						$allowed = array('gif', 'png', 'jpg', 'JPG');
						$config['remove_spaces'] = TRUE;
						$config['allowed_types'] = 'exe|sql|psd|pdf|xls|ppt|php|php4|php3|js|swf|Xhtml|zip|wav|bmp|gif|jpg|jpeg|png|html|htm|txt|rtf|mpeg|mpg|avi|doc|docx|xlsx';
						$config['upload_path'] = $uploads_dir;
						$config['file_name'] = $change_name;
						$this->load->library('upload', $config);
						if (!$this->upload->do_upload("FOTO")) {
							$error += 1;
							$message = "Error, " . $this->upload->display_errors();
						} else {
							$myfile = fopen($uploads_dir . "/index.php", "w");
							$text = "<?php if(!defined('BASEPATH'))exit('Directory access is forbidden.'); ?>";
							fwrite($myfile, $text);
							fclose($myfile);
						}
						//print_r($path);die();
						//if(!in_array(pathinfo($orig_name, PATHINFO_EXTENSION),$allowed)){
						$DATA['PATH'] = $path;
						//}
					}

					$addXml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?><DOCUMENT>
								<SPJM>
									<HEADER>
										<CAR></CAR>
										<KD_KANTOR>040300</KD_KANTOR>
										<NO_PIB>" . $DATA['NO_DAFTAR_PABEAN'] . "</NO_PIB>
										<TGL_PIB>" . $DATA['TGL_DAFTAR_PABEAN'] . "</TGL_PIB>
										<NPWP_IMP>" . $DATA['ID_CONSIGNEE'] . "</NPWP_IMP>
										<NAMA_IMP>" . $DATA['CONSIGNEE'] . "</NAMA_IMP>
										<NPWP_PPJK></NPWP_PPJK>
										<NAMA_PPJK></NAMA_PPJK>
										<GUDANG>NCT1</GUDANG>
										<JML_CONT></JML_CONT>
										<NO_BC11>" . $DATA['NO_BC11'] . "</NO_BC11>
										<TGL_BC11>" . $DATA['TGL_BC11'] . "</TGL_BC11>
										<NO_POS_BC11></NO_POS_BC11>
										<FL_KARANTINA></FL_KARANTINA>
										<NM_ANGKUT>" . $DATA['NM_ANGKUT'] . "</NM_ANGKUT>
										<NO_VOY_FLIGHT>" . $DATA['NO_VOY_FLIGHT'] . "</NO_VOY_FLIGHT>
									</HEADER>";
					//$DATA['TGL_BL_AWB'] = validate($DATA['TGL_BL_AWB'],'DATE');
					//$DATA['TGL_DOK_INOUT'] = validate($DATA['TGL_DOK_INOUT'],'DATE');
					//$DATA['TGL_BC11'] = validate($DATA['TGL_BC11'],'DATE');
					//PRINT_R($DATA);die();

					$DATA['ANGKUTNO_TPS'] = $this->input->post('DATA[NO_VOY_FLIGHT]');
					$DATA['ANGKUTNAMA_TPS'] = $this->input->post('DATA[NM_ANGKUT]');
					$DATA['NO_DAFTAR_PABEAN'] = $this->input->post('DATA[NO_DAFTAR_PABEAN]');
					$DATA['TGL_DAFTAR_PABEAN'] = $this->input->post('DATA[TGL_DAFTAR_PABEAN]');
					//$DATA[TGL_DAFTAR_PABEAN]= validate($DATA['TGL_DAFTAR_PABEAN'],'DATE');
					$DATA['FL_MANUAL'] = 'Y';
					$DATA['OPERATOR'] = $this->session->userdata('USERLOGIN');

					//print_r($DATA);die();
					$this->db->insert('t_permit_hdr', $DATA);
					$IDHEADER = $this->db->insert_id();
					if ($IDHEADER != "") {
						//PRINT_R($DATA);DIE();
						$indexcont = $this->input->post('indexcont');
						$arrayindexcont = explode(",", substr($indexcont, 1));
						$banyakcont = count($arrayindexcont);
						if ($banyakcont > 0) {
							$addXml .= "<DETIL>";
							for ($c = 0; $c < $banyakcont; $c++) {
								$indexcontid = $arrayindexcont[$c];
								foreach ($this->input->post('CONT' . $indexcontid) as $a => $b) {
									$CONT['ID'] = $IDHEADER;
									$CONT['TGL_STATUS'] = date('Y-m-d H:i:s');
									$CONT[$a] = $b;
									$NNULL = $IDHEADER;
								}

								$addXml .= "<CONT>
												<CAR></CAR>
												<NO_CONT>" . $CONT['NO_CONT'] . "</NO_CONT>
												<SIZE>" . $CONT['KD_CONT_UKURAN'] . "</SIZE>
											<CONT>";
								if ($NNULL == NULL) {
									$error += 1;
									$message .= " Mohon Tambahkan Data Kontainer";
								} else {
									$rescont = $this->db->insert('t_permit_cont', $CONT);
								}
								$addXml .= "</DETIL>";
							}
						}
					} else {
						$error += 1;
						$message .= " &raquo; Data Gagal Diproses";
					}
					$addXml .= "<DOK>
									<NO_DOK>" . $DATA['NO_DOK_INOUT'] . "</NO_DOK>
									<TGL_DOK>" . $DATA['TGL_DOK_INOUT'] . "</TGL_DOK>
								</DOK>";
					$addXml .= "</SPJM>
						</DOCUMENT>";
					$dataArr = array(
						'KD_APRF' => 'LicenseCustomsManual',
						'KD_ORG_SENDER' => '0',
						'KD_ORG_RECEIVER' => '0',
						'KD_STATUS' => '200',
						'STR_DATA' => $addXml,
						'TGL_STATUS' => date('Y-m-d H:i:s')
					);
					$this->db->insert('mailbox', $dataArr);
					//echo $addXml;die();
					if ($error == 0) {
						echo "MSG#OK#Data berhasil diproses#" . $this->input->post('action');
					} else {
						echo "MSG#ERR#" . $message . "#";
					}
				}
				/*if($act == "manual"){
				//echo "data"; die();
            	foreach ($this->input->post('DATA') as $a => $b){
                    if($b=="") $DATA[$a] = NULL;
                    else $DATA[$a] = trim(strtoupper($b));
                }
				
				$kd_dok = $DATA['KD_DOK_INOUT'];
				$no_dok = $DATA['NO_DOK_INOUT'];
				$tgl_dok = $DATA['TGL_DOK_INOUT'];
				
				
				$SQLCekData = $this->db->query("SELECT A.* , B.NAMA
												FROM t_permit_hdr A
												INNER JOIN reff_kode_dok_bc B ON A.KD_DOK_INOUT = B.ID
												WHERE A.KD_DOK_INOUT = '$kd_dok' AND A.NO_DOK_INOUT = '$no_dok' AND A.TGL_DOK_INOUT = '$tgl_dok'")->row();
				$cek = count($SQLCekData);
				if($cek == 1){
					echo "MSG#ERR#Dokumen sudah ada!#";
				} else {
					foreach ($this->input->post('CONT') as $a => $b){
						if($b=="") $CONT[$a] = NULL;
						else $CONT[$a] = trim(strtoupper($b));
					}
					print_r($CONT);

					if($_FILES['FOTO']['name']!=""){
						$folder_path = date("Ymd");
						$uploads_dir = './assets/images/foto/'.$folder_path;
						if (!is_dir($uploads_dir))
							mkdir($uploads_dir);
						$uploads_dir .= "/";
						$orig_name = $_FILES['FOTO']['name'];
						$change_name = date("His").".".pathinfo($orig_name, PATHINFO_EXTENSION);
						$path = 'assets/images/foto/'.$folder_path."/".$change_name;
						ini_set('upload_max_filesize', '5M');
						$allowed = array('gif','png','jpg','JPG');
						$config['remove_spaces'] = TRUE;
						$config['allowed_types'] = 'exe|sql|psd|pdf|xls|ppt|php|php4|php3|js|swf|Xhtml|zip|wav|bmp|gif|jpg|jpeg|png|html|htm|txt|rtf|mpeg|mpg|avi|doc|docx|xlsx';
						$config['upload_path'] = $uploads_dir;
						$config['file_name'] = $change_name;
						$this->load->library('upload', $config);
						if(!$this->upload->do_upload("FOTO")){
							$error += 1;
							$message = "Error, ".$this->upload->display_errors();
						}else{
							$myfile = fopen($uploads_dir . "/index.php", "w");
							$text = "<?php if(!defined('BASEPATH'))exit('Directory access is forbidden.'); ?>";
							fwrite($myfile, $text);
							fclose($myfile);
						}
						//print_r($path);die();
						//if(!in_array(pathinfo($orig_name, PATHINFO_EXTENSION),$allowed)){
							$DATA['PATH'] = $path;
						//}
					}
					
					$addXml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?><DOCUMENT>
								<SPJM>
									<HEADER>
										<NO_PIB>".$DATA['NO_DOK_INOUT']."</NO_PIB>
										<TGL_PIB>".$DATA['TGL_DOK_INOUT']."</TGL_PIB>
										<NPWP_IMP>".$DATA['ID_CONSIGNEE']."</NPWP_IMP>
										<NAMA_IMP>".$DATA['CONSIGNEE']."</NAMA_IMP>
										<NO_BC11>".$DATA['NO_BC11']."</NO_BC11>
										<TGL_BC11>".$DATA['TGL_BC11']."</TGL_BC11>
										<NM_ANGKUT>".$DATA['NM_ANGKUT']."</NM_ANGKUT>
										<NO_VOY_FLIGHT>".$DATA['NO_VOY_FLIGHT']."</NO_VOY_FLIGHT>
									</HEADER>";
					//$DATA['TGL_BL_AWB'] = validate($DATA['TGL_BL_AWB'],'DATE');
					//$DATA['TGL_DOK_INOUT'] = validate($DATA['TGL_DOK_INOUT'],'DATE');
					//$DATA['TGL_BC11'] = validate($DATA['TGL_BC11'],'DATE');
					//PRINT_R($DATA);die();
					
					//$DATA['ANGKUTNO_TPS']= $this->input->post('DATA[NO_VOY_FLIGHT]');
					//$DATA['ANGKUTNAMA_TPS']= $this->input->post('DATA[NM_ANGKUT]');
					$DATA['NO_DAFTAR_PABEAN']= $this->input->post('DATA[NO_DOK_INOUT]');
					$DATA['TGL_DAFTAR_PABEAN']= $this->input->post('DATA[TGL_DOK_INOUT]');
					//$DATA[TGL_DAFTAR_PABEAN]= validate($DATA['TGL_DAFTAR_PABEAN'],'DATE');
					$DATA['FL_MANUAL']= 'Y';
					
						//print_r($DATA);die();
					$this->db->insert('t_permit_hdr', $DATA);
					$IDHEADER = $this->db->insert_id();
					if ($IDHEADER != "") {
						//PRINT_R($DATA);DIE();
						$indexcont = $this->input->post('indexcont');
						$arrayindexcont = explode(",", substr($indexcont, 1));
						$banyakcont = count($arrayindexcont);
						if ($banyakcont > 0) {
							$addXml .= "<DETIL>";
							   for ($c = 0; $c < $banyakcont; $c++) {
								$indexcontid = $arrayindexcont[$c];
								foreach ($this->input->post('CONT' . $indexcontid) as $a => $b) {
									$CONT['ID'] = $IDHEADER;
									$CONT['TGL_STATUS'] = date('Y-m-d H:i:s');
									$CONT[$a] = $b;
									$NNULL = $IDHEADER;
								}
								
									$addXml .= "<CONT>
												<NO_CONT>".$CONT['NO_CONT']."</NO_CONT>
                								<SIZE>".$CONT['KD_CONT_UKURAN']."</SIZE>
											<CONT>";
								if ($NNULL == NULL) {
									 $error += 1;
									 $message .= " Mohon Tambahkan Data Kontainer";                    			
								}else{
									$rescont = $this->db->insert('t_permit_cont', $CONT);
								}
							$addXml .= "</DETIL>";
							}
						}
					}else {
						$error += 1;
						$message .= " &raquo; Data Gagal Diproses";
					}
						$addXml .= "<DOK>
					                <NO_DOK>".$DATA['NO_DOK_INOUT']."</NO_DOK>
					                <TGL_DOK>".$DATA['TGL_DOK_INOUT']."</TGL_DOK>
					            </DOK>";
						$addXml .= "</SPJM>
						</DOCUMENT>";
					$dataArr = array(
						'METHOD' =>'LicenseCustomsManual',
						'USERNAME' =>'dokManual',
						'XML_REQUEST' => $addXml,
						'WK_REKAM' => date('Y-m-d H:i:s')
					);
					$this->db->insert('log_services',$dataArr);
					//echo $addXml;die();
					if($error==0){
						echo "MSG#OK#Data berhasil diproses#".$this->input->post('action');
					}else{
						echo "MSG#ERR#".$message."#";
					}
				}
			*/
			} else if ($act == "request") {
				$id = $this->input->post('id');
				$arrid = explode('~', $id);
				$idpost = $arrid[0];
				$jns_dokumen = $arrid[1];
				if ($jns_dokumen == "SPJM" || $jns_dokumen == "NHI") {
					$SQL = "SELECT * FROM t_permit_hdr WHERE ID = '$idpost'";
					$result = $func->main->get_result($SQL);
					if ($result) {
						foreach ($SQL->result_array() as $row => $value) {
							$arrdata = $value;
						}
						$cek = "SELECT * FROM t_permit_hdr WHERE ID = '$idpost' AND STATUS = 'N'";
						//echo $cek;//die();
						$resCek = $this->db->query($cek)->row();
						$jmlh = count($resCek);
						if ($jmlh <= 0) {
							//echo "Sudah di reques";die();
						} else {
							//echo "Belum Di request";die();
							$data['JNS_DOK'] = $arrdata['KD_DOK_INOUT'];
							$data['NO_DOK'] = $arrdata['NO_DAFTAR_PABEAN'];
							$data['TGL_DOK'] = $arrdata['TGL_DAFTAR_PABEAN'];
							$data['WK_REQ'] = date('Y-m-d H:i:s');
							$this->db->insert('t_request', $data);
							$id_req = $this->db->insert_id();

							$this->db->where(array('NO_DOK' => $arrdata['NO_DAFTAR_PABEAN']));
							$this->db->update('t_request', array('WK_SEND' => date('Y-m-d H:i:s')));

							$this->db->where(array('ID' => $idpost));
							$this->db->update('t_permit_hdr', array('STATUS' => 'Y'));

							$SQLCONT = "SELECT * FROM t_permit_cont WHERE ID = '$idpost'";
							$resultCONT = $func->main->get_result($SQLCONT);

							if ($resultCONT > 0) {
								foreach ($SQLCONT->result_array() as $row1 => $cont) {
									$arrdatacont = $cont;
									$dataCont['ID'] = $id_req;
									$dataCont['NO_CONT'] = $arrdatacont['NO_CONT'];
									$dataCont['UKR_CONT'] = $arrdatacont['KD_CONT_UKURAN'];
									$dataCont['ISO_CODE'] = $arrdatacont['ISO_CODE'];
									$dataCont['KD_CONT_JENIS'] = $arrdatacont['KD_CONT_JENIS'];
									$this->db->insert('t_request_cont', $dataCont);
								}
							} else {
								echo "error";
							}
						}
						$SQLMail = "SELECT A.ID, A.ANGKUTNAMA_TPS, A.NO_BL_AWB,  A.NO_BC11, A.TGL_BC11,
									CASE WHEN A.KD_DOK_INOUT != '19' THEN 'SPPMP' ELSE 'SPJM' END AS 'JENIS_DOKUMEN',
									A.NO_DAFTAR_PABEAN AS PIB,
									DATE_FORMAT(A.TGL_DAFTAR_PABEAN,'%d-%m-%Y') AS 'TGL_PIB', A.NO_DOK_INOUT AS 'NOMOR_DOKUMEN',
									A.TGL_DOK_INOUT AS 'TGL_DOK',CONSIGNEE, A.ID_CONSIGNEE, B.KD_CONT_UKURAN, B.NO_CONT
									FROM t_permit_hdr A, t_permit_cont B WHERE A.ID = B.ID  AND A.ID = '$idpost'";

						$resultMail = $func->main->get_result($SQLMail);
						if ($resultMail) {
							foreach ($SQLMail->result_array() as $row2 => $valueMail) {
								$arrdataMail[] = $valueMail;
							}
							$JMLH = count($arrdataMail);
							//print_r($JMLH);die();
							for ($c = 0; $c < $JMLH; $c++) {
								/*$tr .= '
									<tr>
										<td>'.$arrdataMail[$c]["NO_CONT"].'</td>
										<td>'.$arrdataMail[$c]["KD_CONT_UKURAN"].'</td>
									</tr>
								';*/
								$CONT .= $arrdataMail[$c]["NO_CONT"] . "-" . $arrdataMail[$c]["KD_CONT_UKURAN"] . '"' . " , ";
							}
							$email2 = $this->db->query("SELECT EMAIL,KEGIATAN, JNS_EMAIL FROM reff_mail WHERE KEGIATAN = 'GATE'")->result_array();

							for ($i = 0; $i < count($email2); $i++) {
								$subject = "REQUEST GATEPASS CIC - [" . $arrdataMail[0]['CONSIGNEE'] . "]";
								$email = $email2[$i]['EMAIL']; //'nuridin.mu23@gmail.com';

								$this->load->helper('email');
								$email_success = 0;
								if (valid_email($email)) {
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
														<td>' . $arrdataMail[0]['ID_CONSIGNEE'] . '</td>
													</tr>
													<tr>
														<td width=""><b>Nama Perusahaan</b> </td>
														<td>:</td>
														<td>' . $arrdataMail[0]['CONSIGNEE'] . '</td>
													</tr>
													<tr>
														<td><b>Nama Kapal </b></td>
														<td>:</td>
														<td>' . $arrdataMail[0]['ANGKUTNAMA_TPS'] . '</td>
													</tr>
													<tr>
														<td><b>NO. BL </b></td>
														<td>:</td>
														<td>' . $arrdataMail[0]['NO_BL_AWB'] . '</td>
													</tr>
													<tr>
														<td><b>Nomor Container </b></td>
														<td>:</td>
														<td>' . $CONT . '</td>
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
																	<td>' . $arrdataMail[0]['PIB'] . '</td>
																	<td><b>Tanggal Dokumen Dikeluarkan</b></td>
																	<td>:</td>
																	<td>' . $arrdataMail[0]['TGL_PIB'] . '</td>
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
																	<td>' . $arrdataMail[0]['NO_BC11'] . '</td>
																	<td><b>Tanggal Dokumen Dikeluarkan</b></td>
																	<td>:</td>
																	<td>' . $arrdataMail[0]['TGL_BC11'] . '</td>
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
																<td>' . date('d-m-Y') . '</td>
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
															<img src="' . base_url() . '/assets/images/ipc_logo.png" alt="">
														</td>
														<td>
															<div style="color:#050567" align="justify">
																This message was delivered by BOS – IPCTPK.
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
									$this->email->from('automail@multiterminal.co.id', 'BOS NOTIFICATION - REQUEST GATEPASS');
									$email = str_replace(';', ',', $email);
									$this->email->to($email);
									////$array_bcc = array('nuridin.mu23@gmail.com','muhammad.nuridin@edi-indonesia.co.id','salman.abdulaziz@edi-indonesia.co.id', 'cgs@indonesiaport.co.id', 'automail@multiterminal.co.id','get@npct1.co.id');
									//$this->email->bcc($array_bcc);
									$this->email->subject($subject);
									$this->email->message($msg);
								} //tutup for
								if ($this->email->send()) {
									$email_success = 1;
									//echo "<script>alert('Email Terkirim');window.location=''</script>";
									$SQL_MAIL = $this->db->query("SELECT ID,GROUP_CONCAT(EMAIL) AS 'EMAIL',KEGIATAN FROM reff_mail WHERE KEGIATAN = 'GATE'")->row();
									echo "Email Terkirim Ke <b>" . $SQL_MAIL->EMAIL . "</b> ";
									$this->db->where(array('ID' => $id));
									$this->db->update('t_permit_hdr', array('STATUS_MAIL' => 'Email Terkirim'));
								} else {
									echo "Email Tidak Terkirim";
									$this->db->where(array('ID' => $id));
									$this->db->update('t_permit_hdr', array('STATUS_MAIL' => 'Email Tidak Terkirim'));
								}
							}
							return $email_success;
						}
					} else {
					}
					//die('test');
					if ($error == 0) {
						//$func->main->get_log("add", "app_user");
						echo "MSG#OK#Data berhasil diproses#" . site_url() . "/planning/gate_pass/post";
						//redirect('planning/gate_pass', 'refresh');

					} else {
						echo "MSG#ERR#" . $message . "#";
					}
				} else if ($jns_dokumen == "SPPMP") {
					$id = $this->input->post('id');
					$arrid = explode('~', $id);
					$idpost = $arrid[0];
					$jns_dokumen = $arrid[1];
					$SQL = "SELECT * FROM t_ppk_hdr WHERE ID_IJIN = '$idpost'";
					$result = $func->main->get_result($SQL);
					if ($result) {
						foreach ($SQL->result_array() as $row => $value) {
							$arrdata = $value;
						}
						$cek = "SELECT * FROM t_ppk_hdr WHERE ID_IJIN = '$idpost' AND STATUS = 'N'";
						$resCek = $this->db->query($cek)->row();
						$jmlh = count($resCek);
						if ($jmlh <= 0) {
							//echo "Sudah di reques";
						} else {
							$data['JNS_DOK'] = "83";
							$data['NO_DOK'] = $arrdata['NO_DAFTPPK'];
							$data['TGL_DOK'] = $arrdata['TG_DAFTPPK'];
							$data['WK_REQ'] = date('Y-m-d H:i:s');

							$this->db->insert('t_request', $data);
							$id_req = $this->db->insert_id();

							$this->db->where(array('ID_IJIN' => $idpost));
							$this->db->update('t_ppk_hdr', array('STATUS' => 'Y'));

							$SQLCONT = "SELECT * FROM t_ppk_cont WHERE ID_IJIN = '$idpost' AND NO_TPFT IS NOT NULL";
							$resultCONT = $func->main->get_result($SQLCONT);

							//print_r($SQLCONT);die();

							if ($resultCONT > 0) {
								foreach ($SQLCONT->result_array() as $row1 => $cont) {
									$arrdatacont = $cont;
									$dataCont['ID'] = $id_req;
									$dataCont['NO_CONT'] = $arrdatacont['NO_CONT'];
									$dataCont['UKR_CONT'] = $arrdatacont['UKURAN'];
									$dataCont['ISO_CODE'] = $arrdatacont['ISO_CODE'];
									$dataCont['KD_CONT_JENIS'] = "F";
									$this->db->insert('t_request_cont', $dataCont);
								}
							} else {
								echo "error";
								//print_r($arrdatacont);die();
							}
						}

						/*$SQLMail = "SELECT A.ID_IJIN, A.ANGKUTNAMA_TPS,
								A.NO_DAFTPPK AS 'NOMOR_DOKUMEN', A.TG_DAFTPPK, A.NM_PARTNER ,B.NO_CONT, B.UKURAN
								FROM t_ppk_hdr A, t_ppk_cont B WHERE A.ID_IJIN = B.ID_IJIN and A.ID_IJIN = '$idpost' AND B.NO_TPFT IS NOT NULL";*/
						$SQLMail = "SELECT A.ID_IJIN, A.ANGKUTNAMA_TPS,
								A.NO_DAFTPPK AS 'NOMOR_DOKUMEN', A.TG_DAFTPPK,
								(select C.nm_trader
								from t_lic_hdr C
								where C.NO_IJIN = A.NO_RESPON
								) as NM_PARTNER,(select C.NPWP
								from t_lic_hdr C
								where C.NO_IJIN = A.NO_RESPON
								) as NPWP
								 ,B.NO_CONT, B.UKURAN
								FROM t_ppk_hdr A, t_ppk_cont B WHERE A.ID_IJIN = B.ID_IJIN and A.ID_IJIN = '$idpost' AND B.NO_TPFT IS NOT NULL";
						//print_r($SQLMail);die();
						$resultMail = $func->main->get_result($SQLMail);
						if ($resultMail) {
							foreach ($SQLMail->result_array() as $row2 => $valueMail) {
								$arrdataMail[] = $valueMail;
							}
							//print_r($arrdataMail);die();
							$JMLH = count($arrdataMail);
							//print_r($JMLH);die();
							for ($c = 0; $c < $JMLH; $c++) {
								/*$tr .= '
									<tr>
										<td>'.$arrdataMail[$c]["NO_CONT"].'</td>
										<td>'.$arrdataMail[$c]["UKURAN"].'</td>
									</tr>
								';*/
								$CONT .= $arrdataMail[$c]["NO_CONT"] . "-" . $arrdataMail[$c]["UKURAN"] . '"' . " , ";
							}
							$email = $this->db->query("SELECT ID,EMAIL FROM reff_mail WHERE KEGIATAN = 'GATE'")->row();
							$mail = $email->EMAIL;
							$email2 = $this->db->query("SELECT EMAIL,KEGIATAN, JNS_EMAIL FROM reff_mail WHERE KEGIATAN = 'GATE'")->result_array();
							$email_CC = $this->db->query("SELECT EMAIL,KEGIATAN, JNS_EMAIL FROM reff_mail WHERE KEGIATAN = 'GATE' AND JNS_EMAIL = 'CC'")->result_array();
							#Send Email
							for ($i = 0; $i < count($email2); $i++) {
								$subject = "REQUEST GATEPASS CIC - [" . $arrdataMail[0]['NM_PARTNER'] . "]"; //"REMINDER [".$arrdataMail['NOMOR_DOKUMEN']."]";
								$email = $email2[$i]['EMAIL']; //$mail;//'nuridin.mu23@gmail.com';
								$this->load->helper('email');
								$email_success = 0;
								if (valid_email($email)) {
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
															<td>' . $arrdataMail[0]['NPWP'] . '</td>
														</tr>
														<tr>
															<td width=""><b>Nama Perusahaan</b> </td>
															<td>:</td>
															<td>' . $arrdataMail[0]['NM_PARTNER'] . '</td>
														</tr>
														<tr>
															<td><b>Nama Kapal </b></td>
															<td>:</td>
															<td>' . $arrdataMail[0]['ANGKUTNAMA_TPS'] . '</td>
														</tr>
														<tr>
															<td><b>NO. BL </b></td>
															<td>:</td>
															<td>' . $arrdataMail[0]['NO_BL_AWB'] . '</td>
														</tr>
														<tr>
															<td><b>Nomor Container </b></td>
															<td>:</td>
															<td>' . $CONT . '</td>
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
																		<td></td>
																		<td><b>Tanggal Dokumen Dikeluarkan</b></td>
																		<td>:</td>
																		<td></td>
																	</tr>
																	<tr>
																		<td><b>SPPMP</b></td>
																		<td>:</td>
																		<td>' . $arrdataMail[0]['NOMOR_DOKUMEN'] . '</td>
																		<td><b>Tanggal Dokumen Dikeluarkan</b></td>
																		<td>:</td>
																		<td>' . $arrdataMail[0]['TG_DAFTPPK'] . '</td>
																	</tr>
																	<tr>
																		<td><b>BC.1.1</b></td>
																		<td>:</td>
																		<td>' . $arrdataMail[0]['NO_BC11'] . '</td>
																		<td><b>Tanggal Dokumen Dikeluarkan</b></td>
																		<td>:</td>
																		<td>' . $arrdataMail[0]['TGL_BC11'] . '</td>
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
																	<td>' . date('d-m-Y') . '</td>
																</tr>
															</table>
																<br><br><br>
													<div>
														Mohon kerjasamanya untuk mengirimkan data Gate Pass CIC sesuai kebutuhan diatas.<br><br>
														Atas perhatian dan kerjasamanya kami ucapkan terima kasih.<br><br>

														=================================================================================<br><br>
														<table border="0" class="table" width="55%">
															<tr>
																<td>
																	<img src="' . base_url() . '/assets/images/ipc_logo.png" alt="">
																</td>
																<td>
																	<div style="color:#050567" align="justify">
																		This message was delivered by BOS – IPCTPK.
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
									$this->email->from('automail@multiterminal.co.id', 'BOS NOTIFICATION - REQUEST GATEPASS');
									$email = str_replace(';', ',', $email);
									$this->email->to($email);
									//$array_bcc = array('nuridin.mu23@gmail.com','muhammad.nuridin@edi-indonesia.co.id','salman.abdulaziz@edi-indonesia.co.id', 'cgs@indonesiaport.co.id', 'automail@multiterminal.co.id','get@npct1.co.id');
									//$this->email->bcc($array_bcc);
									$this->email->subject($subject);
									$this->email->message($msg);

									if ($this->email->send()) {
										$email_success = 1;
										//echo "<script>alert('Email Terkirim');window.location=''</script>";
										$SQL_MAIL = $this->db->query("SELECT ID,GROUP_CONCAT(EMAIL) AS 'EMAIL',KEGIATAN FROM reff_mail WHERE KEGIATAN = 'GATE'")->row();
										echo "Email Terkirim Ke <b>" . $SQL_MAIL->EMAIL . "</b> ";
										$this->db->where(array('ID_IJIN' => $id));
										$this->db->update('t_ppk_hdr', array('STATUS_MAIL' => 'Email Terkirim'));
									} else {
										echo "Email Tidak Terkirim";
										$this->db->where(array('ID_IJIN' => $id));
										$this->db->update('t_ppk_hdr', array('STATUS_MAIL' => 'Email Tidak Terkirim'));
									}
								}
							}
							return $email_success;
						}
						//site_url()."/planning/gate_pass_sendMail";
					} else {
					}
					if ($error == 0) {
						//$func->main->get_log("add", "app_user");
						echo "MSG#OK#Data berhasil diproses#" . site_url() . "/planning/gate_pass/post";
						//redirect('planning/gate_pass', 'refresh');
						//site_url()."/planning/gate_pass";
					} else {
						echo "MSG#ERR#" . $message . "#";
					}
				}
			} else if ($act == "request_sppmp") {
				foreach ($this->input->post('tb_chktbldetail11') as $row) {
					$id = $row;
				}
				//print_r($id);die();
			} else if ($act == "spk_create") {

				foreach ($this->input->post('tb_chktbldetailCont') as $row) {
					//$id = $row;
					$arrid = explode('~', $row);
					$idpost = $arrid[0];
					$no_cont = $arrid[1];
				}
				$SQL = "SELECT DISTINCT A.JNS_DOK, A.NO_DOK, A.TGL_DOK, A.NPWP, A.CONSIGNEE, IFNULL(B.ANGKUTNAMA_TPS,C.ANGKUTNAMA) AS NM_KAPAL, IFNULL(B.ANGKUTNO_TPS,C.ANGKUTNO) AS VOYAGE
						FROM t_request A
						LEFT JOIN t_permit_hdr B ON B.KD_DOK_INOUT=A.JNS_DOK AND B.NO_DAFTAR_PABEAN=A.NO_DOK AND B.TGL_DAFTAR_PABEAN=A.TGL_DOK
						LEFT JOIN t_ppk_hdr C ON C.NO_DAFTPPK=A.NO_DOK AND C.TG_DAFTPPK=A.TGL_DOK AND A.JNS_DOK='sppmp'
						WHERE A.ID = " . $this->db->escape($idpost);
				$result = $func->main->get_result($SQL);
				if ($result) {
					foreach ($SQL->result_array() as $row => $value) {
						$arrdata = $value;
					}
					$seq = $this->db->query("SELECT MAX(id) AS 'urut' FROM t_spk_temporary")->row()->urut;
					$norut = $seq + 1;
					$NO_SPK = "MTI-" . substr(date('Y'), 2) . "/" . $norut;
					$data['NO_SPK'] = $NO_SPK;
					$data['NM_KAPAL'] = $arrdata['NM_KAPAL'];
					$data['NO_VOY'] = $arrdata['VOYAGE'];
					$data['TGL_SPK'] = date('Y-m-d');
					$data['JNS_DOK'] = $arrdata['JNS_DOK'];
					$data['NO_DOK'] = $arrdata['NO_DOK'];
					$data['TGL_DOK'] = $arrdata['TGL_DOK'];
					$data['NPWP'] = $arrdata['NPWP'];
					$data['CONSIGNEE'] = $arrdata['CONSIGNEE'];
					$data['WK_REQ'] = date('Y-m-d H:i:s');
					$data['KD_STATUS'] = '000';

					$this->db->insert('t_spk', $data);
					$id_req = $this->db->insert_id();

					$temp['keterangan'] = $NO_SPK;
					$this->db->insert('t_spk_temporary', $temp);

					foreach ($this->input->post('tb_chktbldetailCont') as $row) {
						$arrid = explode('~', $row);
						$id_cont = $arrid[0];
						$no_cont = $arrid[1];
						$uk_cont = $arrid[2];

						$dataCont['ID'] = $id_req;
						$dataCont['NO_CONT'] = $no_cont;
						$dataCont['UKR_CONT'] = $uk_cont;
						$res_cont = $this->db->insert('t_spk_cont', $dataCont);
						if ($res_cont) {
							$this->db->where(array('ID' => $id_cont, 'NO_CONT' => $no_cont));
							$this->db->update('t_request_cont', array('FLAG_STATUS' => 'Y'));
						} else {
							$error += 1;
							$message = "Error, insert detail container";
						}
					}
				} else {
					$error += 1;
					$message = "Error, insert detail";
				}
				if ($error == 0) {
					//$func->main->get_log("add", "app_user");
					//echo "MSG#OK#Data berhasil diproses#";die();
					echo "MSG#OK#Data berhasil diproses#" . site_url() . "/planning/spk";
					//redirect('planning/gate_pass', 'refresh');
					//site_url()."/planning/gate_pass";
				} else {
					echo "MSG#ERR#" . $message . "#";
				}
			}
		} else if ($type == "update") {
			if ($act == "manual") {
				foreach ($this->input->post('DATA') as $a => $b) {
					if ($b == "") $DATA[$a] = NULL;
					else $DATA[$a] = trim(strtoupper($b));
				}
				foreach ($this->input->post('CONT') as $a => $b) {
					if ($b == "") $CONT[$a] = NULL;
					else $CONT[$a] = trim(strtoupper($b));
				}
				//$orig_name = $_FILES['FOTO']['name'];
				//print_r($orig_name);die();
				if ($_FILES['FOTO']['name'] != "") {
					$folder_path = date("Ymd");
					$uploads_dir = './assets/images/foto/' . $folder_path;
					if (!is_dir($uploads_dir))
						mkdir($uploads_dir);
					$uploads_dir .= "/";
					$orig_name = $_FILES['FOTO']['name'];
					$change_name = date("His") . "." . pathinfo($orig_name, PATHINFO_EXTENSION);
					$path = 'assets/images/foto/' . $folder_path . "/" . $change_name;
					ini_set('upload_max_filesize', '5M');
					$allowed = array('gif', 'png', 'jpg', 'JPG');
					$config['remove_spaces'] = TRUE;
					$config['allowed_types'] = 'exe|sql|psd|pdf|xls|ppt|php|php4|php3|js|swf|Xhtml|zip|wav|bmp|gif|jpg|jpeg|png|html|htm|txt|rtf|mpeg|mpg|avi|doc|docx|xlsx';
					$config['upload_path'] = $uploads_dir;
					$config['file_name'] = $change_name;
					$this->load->library('upload', $config);
					if (!$this->upload->do_upload("FOTO")) {
						$error += 1;
						$message = "Error, " . $this->upload->display_errors();
					} else {
						$myfile = fopen($uploads_dir . "/index.php", "w");
						$text = "<?php if(!defined('BASEPATH'))exit('Directory access is forbidden.'); ?>";
						fwrite($myfile, $text);
						fclose($myfile);
					}
					//print_r($path);die();
					//if(!in_array(pathinfo($orig_name, PATHINFO_EXTENSION),$allowed)){
					$DATA['PATH'] = $path;
					//}
				}

				$DATA['TGL_BL_AWB'] = validate($DATA['TGL_BL_AWB'], 'DATE');
				$DATA['TGL_DOK_INOUT'] = validate($DATA['TGL_DOK_INOUT'], 'DATE');
				$DATA['TGL_BC11'] = validate($DATA['TGL_BC11'], 'DATE');
				$id = $DATA['ID'];
				//PRINT_R($DATA);die();
				$this->db->where(array('ID' => $id));
				$result = $this->db->update('t_permit_hdr', $DATA);
				//$IDHEADER = $this->db->insert_id();
				if ($id != "") {
					//PRINT_R($DATA);DIE();
					$indexcont = $this->input->post('indexcont');
					$arrayindexcont = explode(",", substr($indexcont, 1));
					$banyakcont = count($arrayindexcont);
					if ($banyakcont > 0) {
						$this->db->delete('t_permit_cont', array('ID' => $id));
						for ($c = 0; $c < $banyakcont; $c++) {
							$indexcontid = $arrayindexcont[$c];
							foreach ($this->input->post('CONT' . $indexcontid) as $a => $b) {
								$CONT['ID'] = $id;
								$CONT['TGL_STATUS'] = date('Y-m-d H:i:s');
								$CONT[$a] = $b;
							}
							//print_r($CONT);die();
							$rescont = $this->db->insert('t_permit_cont', $CONT);
						}
						if (!$rescont) {
							$error += 1;
							$message .= " &raquo; Data Kontainer";
						}
					}
				} else {
					$error += 1;
					$message .= " &raquo; Data Gagal Diproses";
				}
				if ($error == 0) {
					//$func->main->get_log("add", "app_user");
					echo "MSG#OK#Data berhasil diproses#" . site_url() . "/planning/manual";
				} else {
					echo "MSG#ERR#" . $message . "#";
				}
			} else if ($act == "user") {
				foreach ($this->input->post('DATA') as $a => $b) {
					if ($b == "") $DATA[$a] = NULL;
					else $DATA[$a] = trim(strtoupper($b));
				}
				if ($_FILES['FOTO']['name'] != "") {
					$folder_path = date("Ymd");
					$uploads_dir = './assets/images/foto/' . $folder_path;
					if (!is_dir($uploads_dir))
						mkdir($uploads_dir);
					$uploads_dir .= "/";
					$orig_name = $_FILES['FOTO']['name'];
					$ext = pathinfo($orig_name, PATHINFO_EXTENSION);
					$change_name = date("His") . "." . $ext;
					$path = 'assets/images/foto/' . $folder_path . "/" . $change_name;
					ini_set('upload_max_filesize', '5M');
					$allowed = array('gif', 'png', 'jpg', 'jpeg');
					$config['remove_spaces'] = TRUE;
					$config['upload_path'] = $uploads_dir;
					$config['file_name'] = $change_name;
					$this->load->library('upload', $config);
					if (in_array($ext, $allowed)) {
						if (!$this->upload->do_upload("FOTO")) {
							$error += 1;
							$message = "Error, " . $this->upload->display_errors();
						} else {
							unlink($this->input->post('PATH'));
							$myfile = fopen($uploads_dir . "/index.php", "w");
							$text = "<?php if(!defined('BASEPATH'))exit('Directory access is forbidden.'); ?>";
							fwrite($myfile, $text);
							fclose($myfile);
						}
						$DATA['PATH'] = $path;
					}
				}
				unset($DATA['USERLOGIN']);
				if ($DATA['PASSWORD'] == "") unset($DATA['PASSWORD']);
				else $DATA['PASSWORD'] = md5($DATA['PASSWORD']);
				$this->db->where(array('ID' => $id));
				$result = $this->db->update('app_user', $DATA);
				if ($result) {
					//$func->main->get_log("update", "app_user");
					echo "MSG#OK#Data berhasil diproses#";
					//.site_url()."/management/user/post";
				} else {
					echo "MSG#ERR#" . $message . "#";
				}
			}
		} else if ($type == "delete") {
			if ($act == "user") {
				foreach ($this->input->post('tb_chktbldata') as $chkitem) {
					$arrchk = explode("~", $chkitem);
					$ID = $arrchk[0];
					$result = $this->db->delete('app_user', array('ID' => $ID));
					if (!$result) {
						$error += 1;
						$message .= "Data gagal diproses";
					}
				}
				if ($error == 0) {
					$func->main->get_log("delete", "app_user");
					echo "MSG#OK#Data berhasil diproses#" . site_url() . "/management/user/post";
				} else {
					echo "MSG#ERR#" . $message . "#";
				}
			} else if ($act == "manual") {
				foreach ($this->input->post('tb_chktblmnl') as $chkitem) {
					$arrchk = explode("~", $chkitem);
					$ID = $arrchk[0];
					$result = $this->db->delete('t_permit_cont', array('ID' => $ID));

					if (!$result) {
						$error += 1;
						$message .= "Data gagal diproses";
					}
					$result1 = $this->db->delete('t_permit_hdr', array('ID' => $ID));
					if (!$result1) {
						$error += 1;
						$message .= "Data gagal diproses";
					}
				}
				if ($error == 0) {
					//$func->main->get_log("delete", "app_user");
					echo "MSG#OK#Data berhasil diproses#" . site_url() . "/planning/manual/post";
				} else {
					echo "MSG#ERR#" . $message . "#";
				}
			}
		}
	}

	function execute_sppmp($type, $act, $id)
	{
		//echo "string";die();
		$func = get_instance();
		$func->load->model("m_main", "main", true);
		$success = 0;
		$error = 0;
		if ($type == "save") {
			if ($act == "request") {
				print_r($id);
				die();
				$SQL = "SELECT * FROM t_permit_hdr WHERE ID = '$id'";

				$result = $func->main->get_result($SQL);
				//print_r($SQL);die();
				//var_dump($result);die();
				if ($result) {
					foreach ($SQL->result_array() as $row => $value) {
						$arrdata = $value;
					}
					//date_default_timezone_set("Asia/Jakarta");
					//$thedate = getdate();

					$data['JNS_DOK'] = $arrdata['KD_DOK_INOUT'];
					$data['NO_DOK'] = $arrdata['NO_DAFTAR_PABEAN'];
					$data['TGL_DOK'] = $arrdata['TGL_DAFTAR_PABEAN'];
					$data['WK_REQ'] = date('Y-m-d H:i:s');
					//$data['STATUS'] = $arrdata['STATUS'];

					$this->db->insert('t_request', $data);
					$id_req = $this->db->insert_id();

					$this->db->where(array('ID' => $id));
					$this->db->update('t_permit_hdr', array('STATUS' => 'Y'));



					$SQLCONT = "SELECT * FROM t_permit_cont WHERE ID = '$id'";
					$resultCONT = $func->main->get_result($SQLCONT);

					//print_r($SQLCONT);die();

					if ($resultCONT > 0) {
						foreach ($SQLCONT->result_array() as $row1 => $cont) {
							$arrdatacont = $cont;
							$dataCont['ID'] = $id_req;
							$dataCont['NO_CONT'] = $arrdatacont['NO_CONT'];
							$dataCont['UKR_CONT'] = $arrdatacont['KD_CONT_UKURAN'];
							$dataCont['ISO_CODE'] = $arrdatacont['ISO_CODE'];
							$this->db->insert('t_request_cont', $dataCont);
						}
					} else {
						echo "error";
						//print_r($arrdatacont);die();
					}



					//print_r($data);die();
				} else {
					/*if($_FILES['FOTO']['name']!=""){
						$folder_path = date("Ymd");
						$uploads_dir = './assets/images/foto/'.$folder_path;
						if (!is_dir($uploads_dir))
							mkdir($uploads_dir);
						$uploads_dir .= "/";
						$orig_name = $_FILES['FOTO']['name'];
						$change_name = date("His").".".pathinfo($orig_name, PATHINFO_EXTENSION);
						$path = 'assets/images/foto/'.$folder_path."/".$change_name;
						ini_set('upload_max_filesize', '5M');
						$allowed = array('gif','png','jpg');
						$config['remove_spaces'] = TRUE;
						$config['upload_path'] = $uploads_dir;
						$config['file_name'] = $change_name;
						$this->load->library('upload', $config);
						if(!$this->upload->do_upload("FOTO")){
							$error += 1;
							$message = "Error, ".$this->upload->display_errors();
						}else{
							$myfile = fopen($uploads_dir . "/index.php", "w");
							$text = "<?php if(!defined('BASEPATH'))exit('Directory access is forbidden.'); ?>";
							fwrite($myfile, $text);
							fclose($myfile);
						}
						if(!in_array(pathinfo($orig_name, PATHINFO_EXTENSION),$allowed)){
							$DATA['PATH'] = $path;
						}
					}
					$DATA['PASSWORD'] = md5($DATA['PASSWORD']);
                	$this->db->insert('app_user', $DATA);*/
				}
				if ($error == 0) {
					//$func->main->get_log("add", "app_user");
					echo "MSG#OK#Data berhasil diproses#";
					//redirect('planning/gate_pass', 'refresh');
					//site_url()."/planning/gate_pass";
				} else {
					echo "MSG#ERR#" . $message . "#";
				}
			}
		} else if ($type == "update") {
			if ($act == "user") {
				foreach ($this->input->post('DATA') as $a => $b) {
					if ($b == "") $DATA[$a] = NULL;
					else $DATA[$a] = trim(strtoupper($b));
				}
				if ($_FILES['FOTO']['name'] != "") {
					$folder_path = date("Ymd");
					$uploads_dir = './assets/images/foto/' . $folder_path;
					if (!is_dir($uploads_dir))
						mkdir($uploads_dir);
					$uploads_dir .= "/";
					$orig_name = $_FILES['FOTO']['name'];
					$ext = pathinfo($orig_name, PATHINFO_EXTENSION);
					$change_name = date("His") . "." . $ext;
					$path = 'assets/images/foto/' . $folder_path . "/" . $change_name;
					ini_set('upload_max_filesize', '5M');
					$allowed = array('gif', 'png', 'jpg', 'jpeg');
					$config['remove_spaces'] = TRUE;
					$config['upload_path'] = $uploads_dir;
					$config['file_name'] = $change_name;
					$this->load->library('upload', $config);
					if (in_array($ext, $allowed)) {
						if (!$this->upload->do_upload("FOTO")) {
							$error += 1;
							$message = "Error, " . $this->upload->display_errors();
						} else {
							unlink($this->input->post('PATH'));
							$myfile = fopen($uploads_dir . "/index.php", "w");
							$text = "<?php if(!defined('BASEPATH'))exit('Directory access is forbidden.'); ?>";
							fwrite($myfile, $text);
							fclose($myfile);
						}
						$DATA['PATH'] = $path;
					}
				}
				unset($DATA['USERLOGIN']);
				if ($DATA['PASSWORD'] == "") unset($DATA['PASSWORD']);
				else $DATA['PASSWORD'] = md5($DATA['PASSWORD']);
				$this->db->where(array('ID' => $id));
				$result = $this->db->update('app_user', $DATA);
				if ($result) {
					$func->main->get_log("update", "app_user");
					echo "MSG#OK#Data berhasil diproses#" . site_url() . "/management/user/post";
				} else {
					echo "MSG#ERR#" . $message . "#";
				}
			}
		} else if ($type == "delete") {
			if ($act == "user") {
				foreach ($this->input->post('tb_chktbldata') as $chkitem) {
					$arrchk = explode("~", $chkitem);
					$ID = $arrchk[0];
					$result = $this->db->delete('app_user', array('ID' => $ID));
					if (!$result) {
						$error += 1;
						$message .= "Data gagal diproses";
					}
				}
				if ($error == 0) {
					$func->main->get_log("delete", "app_user");
					echo "MSG#OK#Data berhasil diproses#" . site_url() . "/management/user/post";
				} else {
					echo "MSG#ERR#" . $message . "#";
				}
			}
		}
	}

	function execute_dokumen($type, $act, $id)
	{
		$func = get_instance();
		$func->load->model("m_main", "main", true);
		$success = 0;
		$error = 0;
		if ($type == "save") {
			if ($act == "request") {
				foreach ($this->input->post('tb_chktblkapal') as $row) {
					$id = $row;
				}
				$SQL = "SELECT * FROM t_permit_hdr WHERE ID = '$id'";

				$result = $func->main->get_result($SQL);
				if ($result) {
					foreach ($SQL->result_array() as $row => $value) {
						$arrdata = $value;
					}
					$cek = "SELECT * FROM t_permit_hdr WHERE ID = '$id' AND STATUS = 'N'";
					//echo $cek;//die();
					$resCek = $this->db->query($cek)->row();
					$jmlh = count($resCek);
					if ($jmlh <= 0) {
						//echo "Sudah di reques";die();
					} else {
						$data['JNS_DOK'] = $arrdata['KD_DOK_INOUT'];
						$data['NO_DOK'] = $arrdata['NO_DAFTAR_PABEAN'];
						$data['TGL_DOK'] = $arrdata['TGL_DAFTAR_PABEAN'];
						$data['WK_REQ'] = date('Y-m-d H:i:s');

						$this->db->insert('t_request', $data);
						$id_req = $this->db->insert_id();

						date_default_timezone_set("Asia/Jakarta");

						$WK_STATUS = date('Y-m-d H:i:s');

						$this->db->where(array('ID' => $id));
						$this->db->update('t_permit_hdr', array('WK_STATUS' => $WK_STATUS, 'STATUS' => 'Y'));

						$SQLCONT = "SELECT * FROM t_permit_cont WHERE ID = '$id'";
						$resultCONT = $func->main->get_result($SQLCONT);

						if ($resultCONT) {
							foreach ($SQLCONT->result_array() as $row1 => $cont) {
								$arrdatacont = $cont;
								$dataCont['ID'] = $id_req;
								$dataCont['NO_CONT'] = $arrdatacont['NO_CONT'];
								$dataCont['UKR_CONT'] = $arrdatacont['KD_CONT_UKURAN'];
								$dataCont['ISO_CODE'] = $arrdatacont['ISO_CODE'];
								$this->db->insert('t_request_cont', $dataCont);
							}
						} else {
							echo "error";
						}
					}
					$SQLMail = "SELECT A.ID, A.ANGKUTNAMA_TPS, A.NO_BL_AWB,  A.NO_BC11, A.TGL_BC11,
								CASE WHEN A.KD_DOK_INOUT != '19' THEN 'SPPMP' ELSE 'SPJM' END AS 'JENIS_DOKUMEN',
								A.NO_DAFTAR_PABEAN AS PIB,
								DATE_FORMAT(A.TGL_DAFTAR_PABEAN,'%d-%m-%Y') AS 'TGL_PIB', A.NO_DOK_INOUT AS 'NOMOR_DOKUMEN',
								A.TGL_DOK_INOUT AS 'TGL_DOK',CONSIGNEE, A.ID_CONSIGNEE, B.KD_CONT_UKURAN, B.NO_CONT
								FROM t_permit_hdr A, t_permit_cont B WHERE A.ID = B.ID  AND A.ID = '$id'";
					$resultMail = $func->main->get_result($SQLMail);


					if ($resultMail) {
						foreach ($SQLMail->result_array() as $row2 => $valueMail) {
							$arrdataMail[] = $valueMail;
						}
						$JMLH = count($arrdataMail);
						for ($c = 0; $c < $JMLH; $c++) {
							$CONT .= $arrdataMail[$c]["NO_CONT"] . "-" . $arrdataMail[$c]["KD_CONT_UKURAN"] . '"' . " , ";
						}
						$email2 = $this->db->query("SELECT EMAIL,KEGIATAN FROM reff_mail WHERE KEGIATAN = 'GATE'")->result_array();
						for ($i = 0; $i < count($email2); $i++) {

							$subject = "REQUEST GATEPASS CIC - [" . $arrdataMail[0]['CONSIGNEE'] . "]";
							$email = $email2[$i]['EMAIL'];
							$this->load->helper('email');
							$email_success = 0;
							if (valid_email($email)) {
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
														<td>' . $arrdataMail[0]['ID_CONSIGNEE'] . '</td>
													</tr>
													<tr>
														<td width=""><b>Nama Perusahaan</b> </td>
														<td>:</td>
														<td>' . $arrdataMail[0]['CONSIGNEE'] . '</td>
													</tr>
													<tr>
														<td><b>Nama Kapal </b></td>
														<td>:</td>
														<td>' . $arrdataMail[0]['ANGKUTNAMA_TPS'] . '</td>
													</tr>
													<tr>
														<td><b>NO. BL </b></td>
														<td>:</td>
														<td>' . $arrdataMail[0]['NO_BL_AWB'] . '</td>
													</tr>
													<tr>
														<td><b>Nomor Container </b></td>
														<td>:</td>
														<td>' . $CONT . '</td>
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
																	<td>' . $arrdataMail[0]['PIB'] . '</td>
																	<td><b>Tanggal Dokumen Dikeluarkan</b></td>
																	<td>:</td>
																	<td>' . $arrdataMail[0]['TGL_PIB'] . '</td>
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
																	<td>' . $arrdataMail[0]['NO_BC11'] . '</td>
																	<td><b>Tanggal Dokumen Dikeluarkan</b></td>
																	<td>:</td>
																	<td>' . $arrdataMail[0]['TGL_BC11'] . '</td>
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
																<td>' . date('d-m-Y') . '</td>
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
															<img src="' . base_url() . '/assets/images/ipc_logo.png" alt="">
														</td>
														<td>
															<div style="color:#050567" align="justify">
																This message was delivered by BOS – IPCTPK.
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
								$this->email->from('automail@multiterminal.co.id', 'BOS NOTIFICATION - REQUEST GATEPASS');
								$email = str_replace(';', ',', $email);
								$this->email->to($email);
								//$array_bcc = array('nuridin.mu23@gmail.com','muhammad.nuridin@edi-indonesia.co.id','salman.abdulaziz@edi-indonesia.co.id', 'cgs@indonesiaport.co.id', 'automail@multiterminal.co.id','get@npct1.co.id');
								//$array_bcc = $mailnya;
								//array('muhammad.nuridin@edi-indonesia.co.id','sunarkocindaga@gmail.com');
								// $this->email->bcc($array_bcc);
								$this->email->subject($subject);
								$this->email->message($msg);
							}
							if ($this->email->send()) {
								$email_success = 1;
								//echo "<script>alert('Email Terkirim');window.location=''</script>";
								echo "Email Terkirim";
								//echo "MSG#OK#Data berhasil dikirim#".site_url()."/planning/spk";
								$this->db->where(array('ID' => $id));
								$this->db->update('t_spk', array('KD_STATUS' => '100'));
							}
						}
						return $email_success;
					}
				} else {
				}
				if ($error == 0) {
					echo "MSG#OK#Data berhasil direquest#" . site_url() . "/planning/spjm/post";
				} else {
					echo "MSG#ERR#" . $message . "#";
				}
			} else if ($act == "request_sppmp") {
				foreach ($this->input->post('tb_chktblkapal') as $row) {
					$id = $row;
				}
				$SQL = "SELECT * FROM t_ppk_hdr A
						INNER JOIN t_lic_hdr B
						ON A.NO_RESPON = B.NO_IJIN
						WHERE A.ID_IJIN = '$id'
						GROUP BY A.NO_RESPON";

				$result = $func->main->get_result($SQL);
				if ($result) {
					foreach ($SQL->result_array() as $row => $value) {
						$arrdata = $value;
					}
					$cek = "SELECT * FROM t_ppk_hdr WHERE ID_IJIN = '$id' AND STATUS = 'N'";

					$resCek = $this->db->query($cek)->row();
					$jmlh = count($resCek);
					if ($jmlh <= 0) {
						//echo "Sudah di reques";
					} else {
						//echo "belum di reques";
						$data['JNS_DOK'] = "83";
						$data['NO_DOK'] = $arrdata['NO_DAFTPPK'];
						$data['TGL_DOK'] = $arrdata['TG_DAFTPPK'];
						$data['NPWP'] = $arrdata['NPWP'];
						$data['CONSIGNEE'] = $arrdata['NM_TRADER'];
						$data['WK_REQ'] = date('Y-m-d H:i:s');

						$this->db->insert('t_request', $data);
						$id_req = $this->db->insert_id();

						$WK_STATUS = date('Y-m-d H:i:s');

						$this->db->where(array('ID_IJIN' => $id));
						$this->db->update('t_ppk_hdr', array('WK_STATUS' => $WK_STATUS, 'STATUS' => 'Y'));

						$SQLCONT = "SELECT * FROM t_ppk_cont WHERE ID_IJIN = '$id' AND NO_TPFT IS NOT NULL";
						$resultCONT = $func->main->get_result($SQLCONT);

						if ($resultCONT) {
							foreach ($SQLCONT->result_array() as $row1 => $cont) {
								$arrdatacont = $cont;
								$dataCont['ID'] = $id_req;
								$dataCont['NO_CONT'] = $arrdatacont['NO_CONT'];
								$dataCont['UKR_CONT'] = $arrdatacont['UKURAN'];
								$dataCont['ISO_CODE'] = $arrdatacont['ISO_CODE'];
								$this->db->insert('t_request_cont', $dataCont);
							}
						} else {
							echo "error";
							//print_r($arrdatacont);die();
						}
					}

					$SQLMail = "SELECT A.ID_IJIN, A.ANGKUTNAMA_TPS, A.NO_DAFTPPK AS 'NOMOR_DOKUMEN', A.TG_DAFTPPK, C.NM_TRADER AS 'NM_PARTNER', C.NPWP,
								B.NO_CONT, B.UKURAN
								FROM t_ppk_hdr A
								INNER JOIN t_ppk_cont B ON A.ID_IJIN = B.ID_IJIN
								LEFT JOIN t_lic_hdr C ON A.NO_RESPON = C.NO_IJIN
								WHERE A.ID_IJIN = B.ID_IJIN AND A.ID_IJIN = '$id' AND B.NO_TPFT IS NOT NULL";
					// $SQLMail = "SELECT A.ID_IJIN, A.ANGKUTNAMA_TPS,
					// 			A.NO_DAFTPPK AS 'NOMOR_DOKUMEN', A.TG_DAFTPPK,
					// 			(select C.nm_trader
					// 			from t_lic_hdr C
					// 			where C.NO_IJIN = A.NO_RESPON
					// 			) as NM_PARTNER ,(select C.NPWP
					// 			from t_lic_hdr C
					// 			where C.NO_IJIN = A.NO_RESPON
					// 			) as NPWP,B.NO_CONT, B.UKURAN
					// 			FROM t_ppk_hdr A, t_ppk_cont B WHERE A.ID_IJIN = B.ID_IJIN and A.ID_IJIN = '$id' AND B.NO_TPFT IS NOT NULL";
					/*$SQLMail = "SELECT A.ID_IJIN, A.ANGKUTNAMA_TPS,
								A.NO_DAFTPPK AS 'NOMOR_DOKUMEN', A.TG_DAFTPPK,
								(select C.nm_trader
								from t_lic_hdr C
								where C.NO_IJIN = A.NO_RESPON
								) as NM_PARTNER,
								B.NO_CONT, B.UKURAN
								FROM t_ppk_hdr A, t_ppk_cont B WHERE A.ID_IJIN = B.ID_IJIN and A.ID_IJIN = '$idpost' AND B.NO_TPFT IS NOT NULL";*/
					//print_r($SQLMail);die();
					$resultMail = $func->main->get_result($SQLMail);
					if ($resultMail) {
						//echo "sini";die();
						foreach ($SQLMail->result_array() as $row2 => $valueMail) {
							$arrdataMail[] = $valueMail;
						}
						//print_r($arrdataMail);die();

						$JMLH = count($arrdataMail);
						//print_r($JMLH);die();
						for ($c = 0; $c < $JMLH; $c++) {
							/*$tr .= '
								<tr>
									<td>'.$arrdataMail[$c]["NO_CONT"].'</td>
									<td>'.$arrdataMail[$c]["UKURAN"].'</td>
								</tr>
							';*/
							$CONT .= $arrdataMail[$c]["NO_CONT"] . "-" . $arrdataMail[$c]["UKURAN"] . '"' . " , ";
						}
						$email = $this->db->query("SELECT ID,EMAIL FROM reff_mail WHERE KEGIATAN = 'GATE'")->row();
						$mail = $email->EMAIL;
						$email2 = $this->db->query("SELECT EMAIL,KEGIATAN, JNS_EMAIL FROM reff_mail WHERE KEGIATAN = 'GATE'")->result_array();
						//$email_CC = $this->db->query("SELECT EMAIL,KEGIATAN, JNS_EMAIL FROM reff_mail WHERE KEGIATAN = 'GATE' AND JNS_EMAIL = 'CC'")->result_array();
						$email_CC = $this->db->query("SELECT GROUP_CONCAT(EMAIL,'') FROM reff_mail WHERE KEGIATAN = 'GATE' AND JNS_EMAIL = 'CC'")->result_array();
						//echo $mail;die();
						#Send Email
						for ($i = 0; $i < count($email2); $i++) {
							$subject = "REQUEST GATEPASS CIC - [" . $arrdataMail[0]['NM_PARTNER'] . "]"; //"REMINDER [".$arrdataMail['NOMOR_DOKUMEN']."]";
							$email = $email2[$i]['EMAIL']; //$mail;//'nuridin.mu23@gmail.com';
							$this->load->helper('email');
							$email_success = 0;
							if (valid_email($email)) {
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
														<td>' . $arrdataMail[0]['NPWP'] . '</td>
													</tr>
													<tr>
														<td width=""><b>Nama Perusahaan</b> </td>
														<td>:</td>
														<td>' . $arrdataMail[0]['NM_PARTNER'] . '</td>
													</tr>
													<tr>
														<td><b>Nama Kapal </b></td>
														<td>:</td>
														<td>' . $arrdataMail[0]['ANGKUTNAMA_TPS'] . '</td>
													</tr>
													<tr>
														<td><b>NO. BL </b></td>
														<td>:</td>
														<td>' . $arrdataMail[0]['NO_BL_AWB'] . '</td>
													</tr>
													<tr>
														<td><b>Nomor Container </b></td>
														<td>:</td>
														<td>' . $CONT . '</td>
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
																	<td></td>
																	<td><b>Tanggal Dokumen Dikeluarkan</b></td>
																	<td>:</td>
																	<td></td>
																</tr>
																<tr>
																	<td><b>SPPMP</b></td>
																	<td>:</td>
																	<td>' . $arrdataMail[0]['NOMOR_DOKUMEN'] . '</td>
																	<td><b>Tanggal Dokumen Dikeluarkan</b></td>
																	<td>:</td>
																	<td>' . $arrdataMail[0]['TG_DAFTPPK'] . '</td>
																</tr>
																<tr>
																	<td><b>BC.1.1</b></td>
																	<td>:</td>
																	<td>' . $arrdataMail[0]['NO_BC11'] . '</td>
																	<td><b>Tanggal Dokumen Dikeluarkan</b></td>
																	<td>:</td>
																	<td>' . $arrdataMail[0]['TGL_BC11'] . '</td>
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
																<td>' . date('d-m-Y') . '</td>
															</tr>
														</table>
															<br><br><br>
												<div>
													Mohon kerjasamanya untuk mengirimkan data Gate Pass CIC sesuai kebutuhan diatas.<br><br>
													Atas perhatian dan kerjasamanya kami ucapkan terima kasih.<br><br>

													=================================================================================<br><br>
													<table border="0" class="table" width="55%">
														<tr>
															<td>
																<img src="' . base_url() . '/assets/images/ipc_logo.png" alt="">
															</td>
															<td>
																<div style="color:#050567" align="justify">
																	This message was delivered by BOS – IPCTPK.
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
								$this->email->from('automail@multiterminal.co.id', 'BOS NOTIFICATION - REQUEST GATEPASS');
								$email = str_replace(';', ',', $email);
								$this->email->to($email);
								//$array_bcc = array('nuridin.mu23@gmail.com','muhammad.nuridin@edi-indonesia.co.id','salman.abdulaziz@edi-indonesia.co.id', 'cgs@indonesiaport.co.id', 'automail@multiterminal.co.id','get@npct1.co.id');
								//	$array_bcc = array('$email_CC');
								//$this->email->bcc($array_bcc);
								$this->email->subject($subject);
								$this->email->message($msg);
								if ($this->email->send()) {
									$email_success = 1;
									//echo "<script>alert('Email Terkirim');window.location=''</script>";
									$SQL_MAIL = $this->db->query("SELECT ID,GROUP_CONCAT(EMAIL) AS 'EMAIL',KEGIATAN FROM reff_mail WHERE KEGIATAN = 'GATE'")->row();
									echo "Email Terkirim Ke <b>" . $SQL_MAIL->EMAIL . "</b> ";
									$this->db->where(array('ID_IJIN' => $id));
									$this->db->update('t_ppk_hdr', array('STATUS_MAIL' => 'Email Terkirim'));
								} else {
									echo "Email Tidak Terkirim";
									$this->db->where(array('ID_IJIN' => $id));
									$this->db->update('t_ppk_hdr', array('STATUS_MAIL' => 'Email Tidak Terkirim'));
								}
							}
						}
						return $email_success;
					}
					//site_url()."/planning/gate_pass_sendMail";
				} else {
				}

				/*if($error==0){
                    //$func->main->get_log("add", "app_user");
                    echo "MSG#OK#Data berhasil diproses#".site_url()."/planning/sppmp/post";
                    //redirect('planning/gate_pass', 'refresh');
                    //site_url()."/planning/gate_pass";
                }else{
					echo "MSG#ERR#".$message."#";
                }*/
			} else if ($act == "spk_create") {
				//echo "string";die();
				/*$no = 0;
				while ($no <= 999) {
					$zero = 3 - strlen($no);
					$norut = str_repeat('0', $zero).$no;
					$no++;
				}*/

				foreach ($this->input->post('tb_chktbldetailCont') as $row) {
					$id = $row;
				}
				//print_r($id);die();
				$SQL = "SELECT * FROM t_request WHERE ID = '$id'";

				$result = $func->main->get_result($SQL);
				//print_r($SQL);die();
				//var_dump($SQL);die();
				if ($result) {
					foreach ($SQL->result_array() as $row => $value) {
						$arrdata = $value;
					}

					$seq = $this->db->query("SELECT MAX(id) AS 'urut' FROM t_spk_temporary")->row()->urut;
					$norut = $seq + 1;

					$NO_SPK = "MTI-" . substr(date('Y'), 2) . "/" . $norut;
					$data['ID'] = $arrdata['ID'];
					$data['NO_SPK'] = $NO_SPK;
					$data['TGL_SPK'] = date('Y-m-d');
					$data['JNS_DOK'] = $arrdata['JNS_DOK'];
					$data['NO_DOK'] = $arrdata['NO_DOK'];
					$data['TGL_DOK'] = $arrdata['TG_DOK'];
					$data['WK_REQ'] = date('Y-m-d H:i:s');
					//$data['STATUS'] = $arrdata['STATUS'];

					$this->db->insert('t_spk', $data);
					$id_req = $this->db->insert_id();

					$temp['keterangan'] = $NO_SPK;
					$this->db->insert('t_spk_temporary', $temp);

					$WK_STATUS = date('Y-m-d H:i:s');

					$this->db->where(array('ID' => $id));
					$this->db->update('t_request_cont', array('FLAG_STATUS' => 'Y'));

					$SQLCONT = "SELECT * FROM t_request_cont WHERE ID = '$id'";
					$resultCONT = $func->main->get_result($SQLCONT);

					//print_r($SQLCONT);die();

					if ($resultCONT > 0) {
						foreach ($SQLCONT->result_array() as $row1 => $cont) {
							$arrdatacont = $cont;
							$dataCont['ID'] = $id_req;
							$dataCont['NO_CONT'] = $arrdatacont['NO_CONT'];
							$dataCont['UKR_CONT'] = $arrdatacont['UKR_CONT'];
							$this->db->insert('t_spk_cont', $dataCont);
						}
					} else {
						echo "error";
						//print_r($arrdatacont);die();
					}
					//redirect('planning/spk','refresh');
				} else {
					//echo "berhasil diproses";die();
				}
				if ($error == 0) {
					//$func->main->get_log("add", "app_user");
					//echo "MSG#OK#Data berhasil diproses#";die();
					echo "MSG#OK#Data berhasil diproses#" . site_url() . "/planning/spk";
					//redirect('planning/gate_pass', 'refresh');
					//site_url()."/planning/gate_pass";
				} else {
					echo "MSG#ERR#" . $message . "#";
				}
			}
		} else if ($type == "update") {
			if ($act == "user") {
				foreach ($this->input->post('DATA') as $a => $b) {
					if ($b == "") $DATA[$a] = NULL;
					else $DATA[$a] = trim(strtoupper($b));
				}
				if ($_FILES['FOTO']['name'] != "") {
					$folder_path = date("Ymd");
					$uploads_dir = './assets/images/foto/' . $folder_path;
					if (!is_dir($uploads_dir))
						mkdir($uploads_dir);
					$uploads_dir .= "/";
					$orig_name = $_FILES['FOTO']['name'];
					$ext = pathinfo($orig_name, PATHINFO_EXTENSION);
					$change_name = date("His") . "." . $ext;
					$path = 'assets/images/foto/' . $folder_path . "/" . $change_name;
					ini_set('upload_max_filesize', '5M');
					$allowed = array('gif', 'png', 'jpg', 'jpeg');
					$config['remove_spaces'] = TRUE;
					$config['upload_path'] = $uploads_dir;
					$config['file_name'] = $change_name;
					$this->load->library('upload', $config);
					if (in_array($ext, $allowed)) {
						if (!$this->upload->do_upload("FOTO")) {
							$error += 1;
							$message = "Error, " . $this->upload->display_errors();
						} else {
							unlink($this->input->post('PATH'));
							$myfile = fopen($uploads_dir . "/index.php", "w");
							$text = "<?php if(!defined('BASEPATH'))exit('Directory access is forbidden.'); ?>";
							fwrite($myfile, $text);
							fclose($myfile);
						}
						$DATA['PATH'] = $path;
					}
				}
				unset($DATA['USERLOGIN']);
				if ($DATA['PASSWORD'] == "") unset($DATA['PASSWORD']);
				else $DATA['PASSWORD'] = md5($DATA['PASSWORD']);
				$this->db->where(array('ID' => $id));
				$result = $this->db->update('app_user', $DATA);
				if ($result) {
					//$func->main->get_log("update", "app_user");
					echo "MSG#OK#Data berhasil diproses#";
					//.site_url()."/management/user/post";
				} else {
					echo "MSG#ERR#" . $message . "#";
				}
			}
		} else if ($type == "delete") {
			if ($act == "user") {
				foreach ($this->input->post('tb_chktbldata') as $chkitem) {
					$arrchk = explode("~", $chkitem);
					$ID = $arrchk[0];
					$result = $this->db->delete('app_user', array('ID' => $ID));
					if (!$result) {
						$error += 1;
						$message .= "Data gagal diproses";
					}
				}
				if ($error == 0) {
					$func->main->get_log("delete", "app_user");
					echo "MSG#OK#Data berhasil diproses#" . site_url() . "/management/user/post";
				} else {
					echo "MSG#ERR#" . $message . "#";
				}
			}
		}
	}

	function manual($act, $id)
	{
		$func = get_instance();
		$this->load->library('newtable');
		$this->newtable->breadcrumb('Dashboard', site_url());
		$this->newtable->breadcrumb('Planing', 'javascript:void(0)');
		$this->newtable->breadcrumb('Dokumen Manual', 'javascript:void(0)');
		$check = (grant() == "W") ? true : false;
		$page_title = "DOKUMEN MANUAL";
		$title = "DOKUMEN MANUAL";
		$KD_GROUP = $this->session->userdata('KD_GROUP');
		$KD_ORGANISASI = $this->session->userdata('KD_ORGANISASI');
		if ($KD_GROUP != "SPA") {
			$addsql  = " AND A.KD_ORGANISASI = " . $this->db->escape($KD_ORGANISASI);
			$addsql .= " AND A.KD_GROUP = 'USR'";
		}
		/*$SQL = "SELECT A.ID, B.NAMA AS 'JENIS DOKUMEN', A.NO_DOK_INOUT AS 'NO DOKUMEN', DATE_FORMAT(A.TGL_DOK_INOUT, '%d-%m-%Y') AS 'TGL DOKUMEN', A.ID_CONSIGNEE AS 'NPWP IMPORTIR', A.CONSIGNEE AS 'NAMA IMPORTIR' FROM t_permit_hdr A INNER JOIN reff_kode_dok_bc B ON A.KD_DOK_INOUT = B.ID
		WHERE 1=1 AND A.KD_DOK_INOUT IN (14,80,81,82,83)".$addsql;*/

		$SQL = "SELECT A.ID, B.NAMA AS 'JENIS DOKUMEN', 
				CONCAT('NO : ',(A.NO_DOK_INOUT), '<BR> TGL : ', (DATE_FORMAT(A.TGL_DOK_INOUT, '%d-%m-%Y'))) AS 'DOKUMEN', 
				CONCAT('NPWP : ',(A.ID_CONSIGNEE),'<BR> NAMA : ',(A.CONSIGNEE)) AS 'NAMA PARTNER', 
				CASE WHEN A.STATUS = 'N' THEN '<span style=\"color:red;font-weight:bold\">REQUEST</span>' WHEN STATUS = 'Y' THEN '<span style=\"color:green;font-weight:bold\">DONE</span>' ELSE 0 END AS 'STATUS'
				FROM t_permit_hdr A
				INNER JOIN reff_kode_dok_bc B ON A.KD_DOK_INOUT = B.ID
				WHERE 1=1 AND A.KD_DOK_INOUT IN (14,19,80,81,82,83,5,43,44,28) AND A.TGL_DOK_INOUT >= '2017'";
		$proses = array(
			'ADD' => array('MODAL', "planning/manual/add", '0', '', 'md-plus-circle', '', 'menu'),
			'EDIT' => array('MODAL', "planning/manual/edit", '1', '', 'md-edit', '', 'list'),
			'REQUEST' => array('POST', "planning/manual/manual_mail/send_mail", '1', '', 'md-mail-send', '', 'list'),
			'DELETE' => array('DELETE', "planning/execute/delete/manual", 'all', '', 'md-close-circle', '', 'menu')
		);
		$this->newtable->search(array(array('A.CONSIGNEE', 'NAMA IMPORTIR'), array('A.NO_DOK_INOUT', 'NO DOKUMEN'), array('A.TGL_DOK_INOUT', 'TGL DOKUMEN', 'DATERANGE')));
		$this->newtable->action(site_url() . "/planning/manual");
		if ($check) $this->newtable->detail(array('POPUP', "planning/manual/manual_detail"));
		$this->newtable->hiddens(array("ID", "PATH"));
		$this->newtable->keys(array("ID"));
		$this->newtable->multiple_search(true);
		$this->newtable->show_chk(true);
		$this->newtable->show_menu($check);
		$this->newtable->tipe_proses('button');
		$this->newtable->show_search(true);
		$this->newtable->cidb($this->db);
		$this->newtable->orderby('5 DESC, TGL_DOK_INOUT ASC');
		$this->newtable->sortby('');
		$this->newtable->set_formid("tblmnl");
		$this->newtable->set_divid("divtblmnl");
		$this->newtable->rowcount(10);
		$this->newtable->clear();
		$this->newtable->menu($proses);
		$tabel .= $this->newtable->generate($SQL);
		$arrdata = array("title" => $title, "page_title" => $page_title, "content" => $tabel);
		if ($this->input->post("ajax") || $act == "post")
			echo $tabel;
		else
			return $arrdata;
	}

	//MULAI
	function process2($type, $act, $id)
	{ //print_r($type.$act);die();
		$func = get_instance();
		$func->load->model("m_main", "main", true);
		$success = 0;
		$error = 0;
		$USERLOGIN = $this->session->userdata('USERLOGIN');
		$KD_TPS = $this->session->userdata('KD_TPS');
		$KD_GUDANG = $this->session->userdata('KD_GUDANG');
		if ($type == "excel") {
			if ($act == "sppb") { //print_r($_POST);die();
				$nm_import = $this->input->post('form[0]');
				$no_sppb = $this->input->post('form[1][0]');
				$tgl_sppb = $this->input->post('form[2]');
				$tgl_sppb_start = validate($tgl_nota[0], 'DATE');
				$tgl_sppb_end = validate($tgl_nota[1], 'DATE');
				$nm_import = strtoupper($nm_import[0]);
				$no_sppb = strtoupper($no_sppb);
				$addsql = "";


				if ($tgl_sppb_start != "" and $tgl_sppb_end != "") {
					$addsql .= " AND DATE(A.TGL_DOK_INOUT) BETWEEN '$tgl_sppb_start' AND '$tgl_sppb_end'";
				} else if ($tgl_sppb_start != "") {
					$addsql .= " AND DATE(A.TGL_DOK_INOUT) => '$tgl_sppb_start'";
				} else if ($tgl_sppb_end != "") {
					$addsql .= " AND DATE(A.TGL_DOK_INOUT) <= '$tgl_sppb_end'";
				} else {
					#$addsql .= " AND MONTH(A.TGL_TIBA) = MONTH(NOW()) AND YEAR(A.TGL_TIBA) = YEAR(NOW())";
				}


				if ($no_sppb != "") {
					$addsql .= " AND A.NO_DOK_INOUT = '$no_sppb'";
				}

				if ($nm_import != "") {
					$addsql .= " AND A.CONSIGNEE = '$nm_import'";
				}
				// $SQL = "SELECT A.NO_CONT,'' AS CLASS, D.CALL_SIGN, B.NM_KAPAL, C.JNS_CONT, B.UKR_CONT, C.ISO_CODE, B.NO_VOY, A.NO_DOK,
				// 		A.TGL_DOK, A.WK_IN AS WK_BEHANDLE , A.LOKASI_INSP, A.WK_START, A.WK_FINISH, A.NO_SEAL,  A.JNS_DOK, C.WK_IN,
				// 		E.NO_DOK_INOUT, E.TGL_DOK_INOUT, A.WK_G, '' AS HP
				// 		FROM t_operation A
				// 		INNER JOIN t_gatepass B ON B.NO_CONT = A.NO_CONT AND A.NO_DOK = B.NO_DOK AND A.TGL_DOK=B.TGL_DOK
				// 		INNER JOIN t_cocostscont C ON A.NO_CONT=C.NO_CONT
				// 		INNER JOIN t_cocostshdr D ON C.ID=D.ID AND D.NM_ANGKUT = B.NM_KAPAL
				// 		AND D.NO_VOY_FLIGHT = B.NO_VOY
				// 		LEFT JOIN t_permit_hdr E ON D.NM_ANGKUT=E.ANGKUTNAMA_TPS AND D.NO_VOY_FLIGHT=E.ANGKUTNO_TPS
				// 		LEFT JOIN req_delivery_hdr F ON E.NO_DOK_INOUT=F.NO_DOK AND E.TGL_DOK_INOUT=F.TGL_DOK
				// 		WHERE 1=1".$addsql; //echo $SQL; die();
				$SQL = "SELECT DISTINCT A.ID, A.KD_KANTOR AS 'KODE KANTOR', A.NO_DOK_INOUT AS 'NOSPPB', DATE_FORMAT(A.TGL_DOK_INOUT, '%d-%m-%Y') AS 'TANGGAL', 
					A.ID_CONSIGNEE AS 'NPWPIMPORTIR', A.CONSIGNEE AS 'NAMAIMPORTIR', A.NO_BC11 AS 'NO BC 11', DATE_FORMAT(A.TGL_BC11, '%d-%m-%Y') AS 'TGL. BC 11', 
					A.ANGKUTNAMA_TPS, A.ANGKUTKODE_TPS, B.NO_CONT FROM t_permit_hdr A
					LEFT JOIN (SELECT ID, GROUP_CONCAT(NO_CONT,'[',KD_CONT_UKURAN,']' SEPARATOR '\r') AS NO_CONT FROM t_permit_cont GROUP BY ID) B
					ON B.ID = A.ID
					WHERE KD_DOK_INOUT = '1' AND DATE_FORMAT(A.TGL_DOK_INOUT, '%Y') = '2017' " . $addsql;
				$result = $func->main->get_result($SQL);
				$this->load->library('newphpexcel');
				$this->newphpexcel->getDefaultStyle()->getFont()->setName('Calibri')->setSize(10);
				$this->newphpexcel->setActiveSheetIndex(0);
				$styleArray = array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT));
				$this->newphpexcel->getDefaultStyle()->applyFromArray($styleArray);
				// $this->newphpexcel->set_bold(array('A1'));
				// $this->newphpexcel->mergecell(array(array('A1','G1')), FALSE);
				// $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A1', 'SPJM');
				$this->newphpexcel->width(array(array('A', 25), array('B', 25), array('C', 25), array('D', 25), array('E', 25), array('F', 25), array('G', 35)));
				$this->newphpexcel->setActiveSheetIndex(0)
					->setCellValue('A3', 'NOMOR DOKUMEN')
					->setCellValue('B3', 'TANGGAL DOKUMEN')
					->setCellValue('C3', 'NAMA KAPAL')
					->setCellValue('D3', 'NOMOR VOYAGE')
					->setCellValue('E3', 'NOMOR KONTAINER')
					->setCellValue('F3', 'NPWP')
					->setCellValue('G3', 'CONSIGNEE')
				;
				$this->newphpexcel->headings(array('A3', 'B3', 'C3', 'D3', 'E3', 'F3', 'G3'));
				$this->newphpexcel->set_wrap(array('B', 'C', 'D', 'E', 'F', 'G'));
				$no = 1;
				$rec = 4;
				if ($result) {
					foreach ($SQL->result_array() as $row) {
						$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A' . $rec, $row["NOSPPB"])
							->setCellValueExplicit('B' . $rec, $row["TANGGAL"], PHPExcel_Cell_DataType::TYPE_STRING)
							->setCellValueExplicit('C' . $rec, $row["ANGKUTNAMA_TPS"], PHPExcel_Cell_DataType::TYPE_STRING)
							->setCellValueExplicit('D' . $rec, $row["ANGKUTKODE_TPS"], PHPExcel_Cell_DataType::TYPE_STRING)
							->setCellValue('E' . $rec, $row["NO_CONT"])
							->setCellValueExplicit('F' . $rec, $row["NPWPIMPORTIR"], PHPExcel_Cell_DataType::TYPE_STRING)
							->setCellValue('G' . $rec, $row["NAMAIMPORTIR"])
						;
						$this->newphpexcel->set_detilstyle(array('A' . $rec, 'B' . $rec, 'C' . $rec, 'D' . $rec, 'E' . $rec, 'F' . $rec, 'G' . $rec));
						$rec++;
						$no++;
					}
				} else {
					$this->newphpexcel->getActiveSheet()->mergeCells('A6:W6');
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A5', 'DATA TIDAK DITEMUKAN');
					$this->newphpexcel->set_detilstyle(array('A5'));
				}
				ob_clean();

				$file = "SPPB_" . date("Ymd") . ".xls";
				header("Content-type: application/x-msdownload");
				header("Content-Disposition: attachment;filename=$file");
				header("Cache-Control: max-age=0");
				header("Pragma: no-cache");
				header("Expires: 0");
				$objWriter = PHPExcel_IOFactory::createWriter($this->newphpexcel, 'Excel5');
				$objWriter->save('php://output');
				exit();
			} else if ($act == "spjm") { //print_r($_POST);die();
				$no_pib = $this->input->post('form[0]');
				$tgl_pib = $this->input->post('form[1]');
				$tatus = $this->input->post('form[2][0]');
				$contnr = $this->input->post('form[3][0]');
				$tgl_pib_start = validate($tgl_pib[0], 'DATE');
				$tgl_pib_end = validate($tgl_pib[1], 'DATE');
				$no_pib = strtoupper($no_pib[0]);
				$contnr = strtoupper($contnr);
				$addsql = "";


				if ($tgl_pib_start != "" and $tgl_pib_end != "") {
					$addsql .= " AND DATE(A.TGL_DAFTAR_PABEAN) BETWEEN '$tgl_pib_start' AND '$tgl_pib_end'";
				} else if ($tgl_pib_start != "") {
					$addsql .= " AND DATE(A.TGL_DAFTAR_PABEAN) => '$tgl_pib_start'";
				} else if ($tgl_pib_end != "") {
					$addsql .= " AND DATE(A.TGL_DAFTAR_PABEAN) <= '$tgl_pib_end'";
				} else {
					#$addsql .= " AND MONTH(A.TGL_TIBA) = MONTH(NOW()) AND YEAR(A.TGL_TIBA) = YEAR(NOW())";
				}

				if ($tatus != "") {
					$addsql .= " AND A.STATUS = '$tatus'";
				}

				if ($contnr != "") {
					$addsql .= " AND B.NO_CONT = '$contnr'";
				}


				if ($no_pib != "") {
					$addsql .= " AND B.NO_DAFTAR_PABEAN = '$no_pib'";
				}
				// $SQL = "SELECT A.ID_REQ, A.NO_NOTA_BEHANDLE, A.TGL_NOTA,'BEHANDLE' AS JNS_NOTA, A.SUBTOTAL ,A.PPN ,A.BIAYA_MATERAI ,
				// 		A.TOTAL_JUMLAH, A.NAMA_CUST,A.NPWP, B.NO_CONT
				// 		FROM req_behandle_hdr A
				// 		LEFT JOIN (SELECT ID_REQ, GROUP_CONCAT(NO_CONT,'[',UK_CONT,']' SEPARATOR '\r') AS NO_CONT
				// 	FROM req_behandle_dtl GROUP BY ID_REQ) B ON B.ID_REQ=A.ID_REQ
				// 		WHERE 1=1".$addsql; #echo $SQL; die();
				$SQL = "SELECT DISTINCT A.NO_DAFTAR_PABEAN,DATE_FORMAT(A.TGL_DAFTAR_PABEAN, '%d-%m-%Y') AS TANGGAL,
						A.ANGKUTNAMA_TPS,A.ANGKUTNO_TPS,
						A.ID_CONSIGNEE, A.CONSIGNEE, B.NO_CONT
						FROM t_permit_hdr A
						INNER JOIN (SELECT ID, GROUP_CONCAT(NO_CONT,'[',KD_CONT_UKURAN,']' SEPARATOR '\r') AS NO_CONT FROM t_permit_cont WHERE TIPE_CONT = 'DRY' GROUP BY ID) B
						ON B.ID = A.ID
						WHERE A.KD_DOK_INOUT = '19'" . $addsql;
				//echo $SQL; die();
				$result = $func->main->get_result($SQL);
				$this->load->library('newphpexcel');
				$this->newphpexcel->getDefaultStyle()->getFont()->setName('Calibri')->setSize(10);
				$this->newphpexcel->setActiveSheetIndex(0);
				$styleArray = array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT));
				$this->newphpexcel->getDefaultStyle()->applyFromArray($styleArray);
				// $this->newphpexcel->set_bold(array('A1'));
				// $this->newphpexcel->mergecell(array(array('A1','G1')), FALSE);
				// $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A1', 'SPJM');
				$this->newphpexcel->width(array(array('A', 25), array('B', 25), array('C', 25), array('D', 25), array('E', 25), array('F', 25), array('G', 35)));
				$this->newphpexcel->setActiveSheetIndex(0)
					->setCellValue('A3', 'NOMOR DOKUMEN')
					->setCellValue('B3', 'TANGGAL DOKUMEN')
					->setCellValue('C3', 'NAMA KAPAL')
					->setCellValue('D3', 'NOMOR VOYAGE')
					->setCellValue('E3', 'NOMOR KONTAINER')
					->setCellValue('F3', 'NPWP')
					->setCellValue('G3', 'CONSIGNEE')
				;
				$this->newphpexcel->headings(array('A3', 'B3', 'C3', 'D3', 'E3', 'F3', 'G3'));
				$this->newphpexcel->set_wrap(array('B', 'C', 'D', 'E', 'F', 'G'));
				$no = 1;
				$rec = 4;
				if ($result) {
					foreach ($SQL->result_array() as $row) {
						$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A' . $rec, $row["NO_DAFTAR_PABEAN"])
							->setCellValueExplicit('B' . $rec, $row["TANGGAL"], PHPExcel_Cell_DataType::TYPE_STRING)
							->setCellValueExplicit('C' . $rec, $row["ANGKUTNAMA_TPS"], PHPExcel_Cell_DataType::TYPE_STRING)
							->setCellValueExplicit('D' . $rec, $row["ANGKUTNO_TPS"], PHPExcel_Cell_DataType::TYPE_STRING)
							->setCellValue('E' . $rec, $row["NO_CONT"])
							->setCellValueExplicit('F' . $rec, $row["ID_CONSIGNEE"], PHPExcel_Cell_DataType::TYPE_STRING)
							->setCellValue('G' . $rec, $row["CONSIGNEE"])
						;
						$this->newphpexcel->set_detilstyle(array('A' . $rec, 'B' . $rec, 'C' . $rec, 'D' . $rec, 'E' . $rec, 'F' . $rec, 'G' . $rec));
						$rec++;
						$no++;
					}
				} else {
					$this->newphpexcel->getActiveSheet()->mergeCells('A4:L4');
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A5', 'DATA TIDAK DITEMUKAN');
					$this->newphpexcel->set_detilstyle(array('A5'));
				}
				ob_clean();

				$file = "SPJM_" . date("Ymd") . ".xls";
				header("Content-type: application/x-msdownload");
				header("Content-Disposition: attachment;filename=$file");
				header("Cache-Control: max-age=0");
				header("Pragma: no-cache");
				header("Expires: 0");
				$objWriter = PHPExcel_IOFactory::createWriter($this->newphpexcel, 'Excel5');
				$objWriter->save('php://output');
				exit();
			} else if ($act == "sppmp") { //print_r($_POST);die();
				$no_daf = $this->input->post('form[0]');
				$no_tpfte = $this->input->post('form[1][0]');
				$tgl_daf = $this->input->post('form[2]');
				$tatus = $this->input->post('form[3][0]');
				$contnr = $this->input->post('form[4][0]');
				$tgl_daf_start = validate($tgl_daf[0], 'DATE');
				$tgl_daf_end = validate($tgl_daf[1], 'DATE');
				$no_daf = strtoupper($no_daf[0]);
				$contnr = strtoupper($contnr);
				$addsql = "";


				if ($tgl_daf_start != "" and $tgl_daf_end != "") {
					$addsql .= " AND DATE(A.TG_DAFTPPK) BETWEEN '$tgl_daf_start' AND '$tgl_daf_end'";
				} else if ($tgl_daf_start != "") {
					$addsql .= " AND DATE(A.TG_DAFTPPK) => '$tgl_daf_start'";
				} else if ($tgl_daf_end != "") {
					$addsql .= " AND DATE(A.TG_DAFTPPK) <= '$tgl_daf_end'";
				} else {
					#$addsql .= " AND MONTH(A.TGL_TIBA) = MONTH(NOW()) AND YEAR(A.TGL_TIBA) = YEAR(NOW())";
				}

				if ($tatus != "") {
					$addsql .= " AND A.STATUS = '$tatus'";
				}

				if ($contnr != "") {
					$addsql .= " AND B.NO_CONT = '$contnr'";
				}

				if ($no_tpfte != "") {
					$addsql .= " AND B.NO_TPFT = '$no_tpfte'";
				}

				if ($no_daf != "") {
					$addsql .= " AND A.NO_DAFTPPK = '$no_daf'";
				}

				$SQL = "SELECT DISTINCT A.JN_RESPON AS 'RESPON',A.NO_DAFTPPK, DATE_FORMAT(A.TG_DAFTPPK, '%d-%m-%Y') AS 'TANGGAL',
					A.ANGKUTNAMA_TPS,A.ANGKUTNO_TPS,
					A.NM_PARTNER AS 'NAMA PARTNER', CASE WHEN A.STATUS = 'N' THEN '<span style=\"color:red;font-weight:bold\">REQUEST</span>' WHEN STATUS = 'Y' THEN '<span style=\"color:green;font-weight:bold\">DONE</span>' ELSE 0 END AS 'STATUS', A.ID_IJIN
					,B.NO_CONT, B.NO_TPFT, C.NPWP, C.NM_TRADER FROM t_ppk_hdr A   
					INNER JOIN  (SELECT ID_IJIN, GROUP_CONCAT(NO_CONT,'[',UKURAN,']' SEPARATOR '\r') AS NO_CONT, NO_TPFT FROM t_ppk_cont INNER JOIN reff_status_cont D
					ON D.ID = KD_STATUS WHERE NO_TPFT IS NOT NULL GROUP BY ID_IJIN) B 
					ON A.ID_IJIN = B.ID_IJIN INNER JOIN t_lic_hdr C ON C.NO_IJIN = A.NO_RESPON" . $addsql;
				$result = $func->main->get_result($SQL);
				$this->load->library('newphpexcel');
				$this->newphpexcel->getDefaultStyle()->getFont()->setName('Calibri')->setSize(10);
				$this->newphpexcel->setActiveSheetIndex(0);
				$styleArray = array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT));
				$this->newphpexcel->getDefaultStyle()->applyFromArray($styleArray);
				// $this->newphpexcel->set_bold(array('A1'));
				// $this->newphpexcel->mergecell(array(array('A1','G1')), FALSE);
				// $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A1', 'SPJM');
				$this->newphpexcel->width(array(array('A', 25), array('B', 20), array('C', 20), array('D', 20), array('E', 25), array('F', 25), array('G', 25), array('H', 35)));
				$this->newphpexcel->setActiveSheetIndex(0)
					->setCellValue('A3', 'NOMOR DOKUMEN')
					->setCellValue('B3', 'TANGGAL DOKUMEN')
					->setCellValue('C3', 'NAMA KAPAL')
					->setCellValue('D3', 'NOMOR VOYAGE')
					->setCellValue('E3', 'NOMOR KONTAINER')
					->setCellValue('F3', 'NOMOR TPFT')
					->setCellValue('G3', 'NPWP')
					->setCellValue('H3', 'CONSIGNEE')
				;
				$this->newphpexcel->headings(array('A3', 'B3', 'C3', 'D3', 'E3', 'F3', 'G3', 'H3'));
				$this->newphpexcel->set_wrap(array('B', 'C', 'D', 'E', 'F', 'G', 'H'));
				$no = 1;
				$rec = 4;
				if ($result) {
					foreach ($SQL->result_array() as $row) {
						$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A' . $rec, $row["NO_DAFTPPK"])
							->setCellValueExplicit('B' . $rec, $row["TANGGAL"], PHPExcel_Cell_DataType::TYPE_STRING)
							->setCellValueExplicit('C' . $rec, $row["ANGKUTNAMA_TPS"], PHPExcel_Cell_DataType::TYPE_STRING)
							->setCellValueExplicit('D' . $rec, $row["ANGKUTNO_TPS"], PHPExcel_Cell_DataType::TYPE_STRING)
							->setCellValue('E' . $rec, $row["NO_CONT"])
							->setCellValue('F' . $rec, $row["NO_TPFT"])
							->setCellValueExplicit('G' . $rec, $row["NPWP"], PHPExcel_Cell_DataType::TYPE_STRING)
							->setCellValue('H' . $rec, $row["NM_TRADER"])
						;
						$this->newphpexcel->set_detilstyle(array('A' . $rec, 'B' . $rec, 'C' . $rec, 'D' . $rec, 'E' . $rec, 'F' . $rec, 'G' . $rec, 'H' . $rec));
						$rec++;
						$no++;
					}
				} else {
					$this->newphpexcel->getActiveSheet()->mergeCells('A4:L4');
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A5', 'DATA TIDAK DITEMUKAN');
					$this->newphpexcel->set_detilstyle(array('A5'));
				}
				ob_clean();

				$file = "SPPMP_" . date("Ymd") . ".xls";
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
	//SELESAI

	function process($type, $act, $id)
	{
		$func = get_instance();
		$func->load->model("m_main", "main", true);
		$success = 0;
		$error = 0;
		$USERLOGIN = $this->session->userdata('USERLOGIN');
		$KD_TPS = $this->session->userdata('KD_TPS');
		$KD_GUDANG = $this->session->userdata('KD_GUDANG');
		if ($type == "excel") {
			if ($act == "gatepass") { //print_r($_POST);die();
				$nm_kapal = $this->input->post('form[0]');
				$no_voy = $this->input->post('form[1]');
				$no_doc = $this->input->post('form[2]');
				$jns_doc = $this->input->post('form[3]');
				$status = $this->input->post('form[4]');
				//$tgl_tiba_start = validate($tgl_tiba[0],'DATE');
				//$tgl_tiba_end = validate($tgl_tiba[1],'DATE');
				$nm_kapal = $nm_kapal[0];
				$no_voy = $no_voy[0];
				$no_doc = $no_doc[0];
				$jns_doc = $jns_doc[0];
				$status = $status[0];
				$addsql = "";


				/*if($tgl_tiba_start!="" and $tgl_tiba_end !=""){
					$addsql .= " AND DATE(A.TGL_TIBA) BETWEEN '$tgl_tiba_start' AND '$tgl_tiba_end'";
				}else if($tgl_tiba_start != ""){
					$addsql .= " AND DATE(A.TGL_TIBA) => '$tgl_tiba_start'";
				}else if($tgl_tiba_end != ""){
					$addsql .= " AND DATE(A.TGL_TIBA) <= '$tgl_tiba_end'";
				}else{
					#$addsql .= " AND MONTH(A.TGL_TIBA) = MONTH(NOW()) AND YEAR(A.TGL_TIBA) = YEAR(NOW())";
				}*/

				if ($nm_kapal != "") {
					$addsql .= " AND X.ANGKUTNAMA_TPS = '$nm_kapal'";
				}
				if ($no_voy != "") {
					$addsql .= " AND X.ANGKUTNO_TPS = '$no_voy'";
				}
				if ($no_doc != "") {
					$addsql .= " AND X.NO_DOKUMEN = '$no_doc'";
				}
				if ($jns_doc != "") {
					$addsql .= " AND X.JENIS_DOKUMEN = '$jns_doc'";
				}
				if ($status != "") {
					$addsql .= " AND X.STATUS_PENGIRIMAN = '$status'";
				}
				$SQL = "SELECT DISTINCT X.ID,
						X.JENIS_DOKUMEN AS 'JENIS DOKUMEN',
						CONCAT('NO : ',(X.NO_DOKUMEN),'<BR>TGL : ', (DATE_FORMAT(X.TGL_DOKUMEN,'%d-%m-%Y'))) AS 'DOKUMEN_',
						X.NO_DOKUMEN AS 'DOKUMEN',
						X.TGL_DOKUMEN AS 'TGL_DOKUMEN',
						X.ANGKUTNAMA_TPS AS 'NM_KAPAL',
						X.ANGKUTNO_TPS AS 'VOYAGE',
						CASE WHEN X.TANGGAL_REQUEST IS NOT NULL THEN DATE_FORMAT(X.TANGGAL_REQUEST,'%d-%m-%Y %H:%i:%s') ELSE '-' END AS 'TANGGAL REQUEST',
						X.KONTAINER,
						X.CONSIGNEE,
						X.NPWP,
						X.NO_TPFT,
						X.STATUS_PENGIRIMAN AS 'STATUS PENGIRIMAN',
						X.STATUS
						FROM (
						SELECT A.ID AS 'ID', A.ANGKUTNAMA_TPS, A.ANGKUTNO_TPS,
						CASE WHEN A.KD_DOK_INOUT = '19' THEN 'SPJM' ELSE 0 END AS 'JENIS_DOKUMEN',
						A.NO_DAFTAR_PABEAN AS 'NO_DOKUMEN',
						A.TGL_DAFTAR_PABEAN AS 'TGL_DOKUMEN',
						A.WK_STATUS AS 'TANGGAL_REQUEST',
						B.NO_CONT AS 'KONTAINER',
						A.CONSIGNEE AS 'CONSIGNEE',
						A.ID_CONSIGNEE AS 'NPWP',
						'' AS 'NO_TPFT',
						CASE WHEN A.STATUS_MAIL IS NULL THEN '<span class=\"label label-primary\">Email Belum Di Proses</span>'
						WHEN A.STATUS_MAIL = 'Email Tidak Terkirim' THEN '<span class=\"label label-danger\">Email Tidak Terkirim</span>'
						WHEN A.STATUS_MAIL = 'Email Terkirim' THEN '<span class=\"label label-success\">Email Terkirim</span>' END AS 'STATUS_PENGIRIMAN',
						CASE WHEN STATUS = 'N' THEN '<span style=\"color:red;font-weight:bold\">REQUEST</span>'
						WHEN STATUS = 'Y' THEN '<span style=\"color:green;font-weight:bold\">DONE</span>' ELSE 0 END AS 'STATUS'
						FROM t_permit_hdr A INNER JOIN t_permit_cont B ON A.ID=B.ID WHERE A.KD_DOK_INOUT = 19 AND DATE_FORMAT(A.TGL_DAFTAR_PABEAN, '%Y') = '2017'
						UNION ALL

						SELECT A.ID_IJIN AS 'ID', A.ANGKUTNAMA_TPS, A.ANGKUTNO_TPS,
						 'SPPMP' AS 'JENIS_DOKUMEN',
						 A.NO_DAFTPPK AS 'NO_DOKUMEN',
						 A.TG_DAFTPPK AS 'TGL_DOKUMEN',
						 A.WK_STATUS AS 'TANGGAL_REQUEST',
						 B.NO_CONT AS 'KONTAINER',
						 C.NM_TRADER AS 'CONSIGNEE',
						 C.NPWP AS 'NPWP',
						 B.NO_TPFT AS 'NO_TPFT',
						CASE WHEN A.STATUS_MAIL IS NULL THEN '<span class=\"label label-primary\">Email Belum Di Proses</span>'
						WHEN A.STATUS_MAIL = 'Email Tidak Terkirim' THEN '<span class=\"label label-danger\">Email Tidak Terkirim</span>'
						WHEN A.STATUS_MAIL = 'Email Terkirim'  THEN '<span class=\"label label-success\">Email Terkirim</span>'  END AS 'STATUS_PENGIRIMAN',

						CASE WHEN A.STATUS = 'N' THEN '<span style=\"color:red;font-weight:bold\">REQUEST</span>'
						WHEN STATUS = 'Y' THEN '<span style=\"color:green;font-weight:bold\">DONE</span>' ELSE 0 END AS 'STATUS'

						FROM t_ppk_hdr A INNER JOIN t_ppk_cont B ON A.ID_IJIN=B.ID_IJIN
						INNER JOIN t_lic_hdr C ON A.ID_IJIN=C.ID_IJIN
						 WHERE A.ID_IJIN = B.ID_IJIN AND B.NO_TPFT IS NOT NULL AND DATE_FORMAT(A.TG_DAFTPPK, '%Y') = '2017' ) X WHERE 1 = 1" . $addsql; //echo $SQL; die();
				$result = $func->main->get_result($SQL);
				$this->load->library('newphpexcel');
				$this->newphpexcel->getDefaultStyle()->getFont()->setName('Calibri')->setSize(10);
				$this->newphpexcel->setActiveSheetIndex(0);
				$styleArray = array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
				$this->newphpexcel->getDefaultStyle()->applyFromArray($styleArray);
				$this->newphpexcel->set_bold(array('A1'));
				$this->newphpexcel->mergecell(array(array('A1', 'M1'), array('AD3', 'AJ3'), array('AK3', 'AQ3')), FALSE);
				$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A1', 'REPORT');
				$this->newphpexcel->mergecell(array(array('A3', 'A4'), array('B3', 'B4'), array('C3', 'C4'), array('D3', 'D4'), array('E3', 'E4'), array('F3', 'F4'), array('G3', 'G4'), array('H3', 'H4'), array('I3', 'I4')), FALSE);
				$this->newphpexcel->width(array(array('A', 25), array('B', 25), array('C', 25), array('D', 25), array('E', 25), array('F', 25), array('G', 25), array('H', 25), array('I', 25)));
				$this->newphpexcel->setActiveSheetIndex(0)
					->setCellValue('A3', 'JENIS DOKUMEN')
					->setCellValue('B3', 'NO DOKUMEN')
					->setCellValue('C3', 'TGL DOKUMEN')
					->setCellValue('D3', 'NAMA KAPAL')
					->setCellValue('E3', 'NO. VOYAGE')
					->setCellValue('F3', 'NO. KONTAINER')
					->setCellValue('G3', 'NO. TPFT')
					->setCellValue('H3', 'NPWP')
					->setCellValue('I3', 'CONSIGNEE');
				$this->newphpexcel->headings(array('A3', 'B3', 'C3', 'D3', 'E3', 'F3', 'G3', 'H3', 'I3', 'A4', 'B4', 'C4', 'D4', 'E4', 'F4', 'G4', 'H4', 'I4'));
				$this->newphpexcel->set_wrap(array('B', 'C', 'D', 'E', 'F', 'G', 'H', 'I'));
				$no = 1;
				$rec = 5;
				if ($result) {
					foreach ($SQL->result_array() as $row) {
						$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A' . $rec, $row["JENIS DOKUMEN"])
							->setCellValueExplicit('B' . $rec, $row["DOKUMEN"], PHPExcel_Cell_DataType::TYPE_STRING)
							->setCellValue('C' . $rec, $row["TGL_DOKUMEN"])
							->setCellValueExplicit('D' . $rec, $row["NM_KAPAL"], PHPExcel_Cell_DataType::TYPE_STRING)
							->setCellValueExplicit('E' . $rec, $row["VOYAGE"], PHPExcel_Cell_DataType::TYPE_STRING)
							->setCellValue('F' . $rec, $row["KONTAINER"])
							->setCellValueExplicit('G' . $rec, $row["NO_TPFT"], PHPExcel_Cell_DataType::TYPE_STRING)
							->setCellValue('H' . $rec, $row["NPWP"])
							->setCellValueExplicit('I' . $rec, $row["CONSIGNEE"], PHPExcel_Cell_DataType::TYPE_STRING);
						$this->newphpexcel->set_detilstyle(array('A' . $rec, 'B' . $rec, 'C' . $rec, 'D' . $rec, 'E' . $rec, 'F' . $rec, 'G' . $rec, 'H' . $rec, 'I' . $rec));
						$rec++;
						$no++;
					}
				} else {
					$this->newphpexcel->getActiveSheet()->mergeCells('A5:I5');
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A5', 'DATA TIDAK DITEMUKAN');
					$this->newphpexcel->set_detilstyle(array('A5'));
				}
				ob_clean();
				$file = "DOKUMENT_" . date("Ymd") . ".xls";
				header("Content-type: application/x-msdownload");
				header("Content-Disposition: attachment;filename=$file");
				header("Cache-Control: max-age=0");
				header("Pragma: no-cache");
				header("Expires: 0");
				$objWriter = PHPExcel_IOFactory::createWriter($this->newphpexcel, 'Excel5');
				$objWriter->save('php://output');
				exit();
				//ob_clean();
				//header("Content-type: application/x-msdownload");
				//header("Content-Disposition: attachment;filename=$file");
				//header("Cache-Control: max-age=0");
				//header("Pragma: no-cache");
				//header("Expires: 0");
				//$objWriter = PHPExcel_IOFactory::createWriter($this->newphpexcel, 'Excel5'); 
				//$file = 'assets/files/report/repository.xls';
				//$handle = fopen($file, 'w');
				//fclose($handle);
				//chmod($file,0777);
				//$data = $objWriter->save($file);
				//$response = array('path' => $file);
				//echo json_encode($response);
			}
		}
	}

	function send_mail_manual($type, $act, $id)
	{
		$func = get_instance();
		$func->load->model("m_main", "main", true);
		$success = 0;
		$error = 0;
		if ($act == "send_mail") {
			$id = $this->input->post('id');
			$arrid = explode('~', $id);
			$idpost = $arrid[0];
			//print_r($idpost);die();
			$SQL = "SELECT * FROM t_permit_hdr WHERE ID = '$idpost'";
			$result = $func->main->get_result($SQL);
			if ($result) {
				foreach ($SQL->result_array() as $row => $value) {
					$arrdata = $value;
				} //print_r($arrdata);die();
				$cek = "SELECT * FROM t_permit_hdr WHERE ID = '$idpost' AND STATUS = 'N'";
				$resCek = $this->db->query($cek)->row();
				$jmlh = count($resCek);
				print_r($jmlh); //die();
				if ($jmlh <= 0) {
					echo "Sudah di request";
					die();
				} else {
					$data['JNS_DOK'] = $arrdata['KD_DOK_INOUT'];
					$data['NO_DOK'] = $arrdata['NO_DAFTAR_PABEAN'];
					$data['ANGKUTNAMA_TPS'] = $arrdata['NM_ANGKUT'];
					$data['ANGKUTNO_TPS'] = $arrdata['NO_VOY_FLIGHT'];
					$data['TGL_DOK'] = $arrdata['TGL_DAFTAR_PABEAN'];
					$data['WK_REQ'] = date('Y-m-d H:i:s');
					$this->db->insert('t_request', $data);
					$id_req = $this->db->insert_id();
					print_r($this->db->last_query());

					$this->db->where(array('ID' => $idpost));
					$this->db->update('t_permit_hdr', array('STATUS' => 'Y'));

					$SQLCONT = "SELECT * FROM t_permit_cont WHERE ID = '$idpost'";
					$resultCONT = $func->main->get_result($SQLCONT);

					if ($resultCONT > 0) {
						foreach ($SQLCONT->result_array() as $row1 => $cont) {
							$arrdatacont = $cont;
							$dataCont['ID'] = $id_req;
							$dataCont['NO_CONT'] = $arrdatacont['NO_CONT'];
							$dataCont['UKR_CONT'] = $arrdatacont['KD_CONT_UKURAN'];
							$dataCont['ISO_CODE'] = $arrdatacont['ISO_CODE'];
							$this->db->insert('t_request_cont', $dataCont);
						}
					} else {
						echo "error";
					}
				}

				/*$SQLMail = "SELECT A.ID, A.KD_DOK_INOUT, B.NAMA AS 'JENIS_DOKUMEN', A.NO_DOK_INOUT AS 'NO_DOKUMEN',A.NM_ANGKUT AS 'KAPAL', C.NO_CONT, C.KD_CONT_UKURAN, A.NO_BC11 AS 'NO_BC' ,DATE_FORMAT(A.TGL_BC11, '%d-%m-%Y') AS 'TGL_BC',A.NO_BL_AWB AS 'NO_BL', DATE_FORMAT(A.TGL_DOK_INOUT, '%d-%m-%Y') AS 'TGL_DOK', A.ID_CONSIGNEE AS 'NPWP_IMPORTIR', A.CONSIGNEE AS 'NAMA_IMPORTIR', A.PATH FROM t_permit_hdr A  INNER JOIN reff_kode_dok_bc B ON A.KD_DOK_INOUT = B.ID INNER JOIN t_permit_cont C ON A.ID = C.ID WHERE A.ID = '$idpost'";
					$resultMail = $func->main->get_result($SQLMail);
					if($resultMail){
						foreach ($SQLMail->result_array() as $row2 => $valueMail) {
						$arrdataMail[] = $valueMail;
					}
						//print_r($arrdataMail[0]["KD_DOK_INOUT"]);die();
					$JMLH = count($arrdataMail);
					//print_r($JMLH);die();
					for($c=0;$c<$JMLH;$c++){
						//$CONT = $arrdataMail[$c]["NO_CONT"].'-'.$arrdataMail[$c]["KD_CONT_UKURAN"].'",';
						$CONT .= $arrdataMail[$c]["NO_CONT"]."-".$arrdataMail[$c]["KD_CONT_UKURAN"].'"'." , ";
					}
					if($arrdataMail[0]["KD_DOK_INOUT"] == '19'){
						$pesan='<html lang="en">
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
								<td>'.$arrdataMail[0]['NPWP_IMPORTIR'].'</td>
							</tr>
							<tr>
								<td width=""><b>Nama Perusahaan</b> </td>
								<td>:</td>
								<td>'.$arrdataMail[0]['NAMA_IMPORTIR'].'</td>
							</tr>
							<tr>
								<td><b>Nama Kapal </b></td>
								<td>:</td>
								<td>'.$arrdataMail[0]['KAPAL'].'</td>
							</tr>
							<tr>
								<td><b>NO. BL </b></td>
								<td>:</td>
								<td>'.$arrdataMail[0]['NO_BL'].'</td>
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
											<td>'.$arrdataMail[0]['NO_DOKUMEN'].'</td>
											<td><b>Tanggal Dokumen Dikeluarkan</b></td>
											<td>:</td>
											<td>'.$arrdataMail[0]['TGL_DOK'].'</td>
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
											<td><b>DOKUMEN LAIN</b></td>
											<td>:</td>
											<td></td>
											<td><b>Tanggal Dokumen Dikeluarkan</b></td>
											<td>:</td>
											<td></td>
										</tr>
										<tr>
											<td><b>BC.1.1</b></td>
											<td>:</td>
											<td>'.$arrdataMail[0]['NO_BC'].'</td>
											<td><b>Tanggal Dokumen Dikeluarkan</b></td>
											<td>:</td>
											<td>'.$arrdataMail[0]['TGL_BC'].'</td>
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
										This message was delivered by BOS – IPCTPK.
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
					}elseif($arrdataMail[0]["KD_DOK_INOUT"] == '83'){
						$pesan='<html lang="en">
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
								<td>'.$arrdataMail[0]['NPWP_IMPORTIR'].'</td>
							</tr>
							<tr>
								<td width=""><b>Nama Perusahaan</b> </td>
								<td>:</td>
								<td>'.$arrdataMail[0]['NAMA_IMPORTIR'].'</td>
							</tr>
							<tr>
								<td><b>Nama Kapal </b></td>
								<td>:</td>
								<td>'.$arrdataMail[0]['KAPAL'].'</td>
							</tr>
							<tr>
								<td><b>NO. BL </b></td>
								<td>:</td>
								<td>'.$arrdataMail[0]['NO_BL'].'</td>
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
											<td></td>
											<td><b>Tanggal Dokumen Dikeluarkan</b></td>
											<td>:</td>
											<td></td>
										</tr>
										<tr>
											<td><b>SPPMP</b></td>
											<td>:</td>
											<td>'.$arrdataMail[0]['NO_DOKUMEN'].'</td>
											<td><b>Tanggal Dokumen Dikeluarkan</b></td>
											<td>:</td>
											<td>'.$arrdataMail[0]['TGL_DOK'].'</td>
										</tr>
										<tr>
											<td><b>DOKUMEN LAIN</b></td>
											<td>:</td>
											<td></td>
											<td><b>Tanggal Dokumen Dikeluarkan</b></td>
											<td>:</td>
											<td></td>
										</tr>
										<tr>
											<td><b>BC.1.1</b></td>
											<td>:</td>
											<td>'.$arrdataMail[0]['NO_BC'].'</td>
											<td><b>Tanggal Dokumen Dikeluarkan</b></td>
											<td>:</td>
											<td>'.$arrdataMail[0]['TGL_BC'].'</td>
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
										This message was delivered by BOS – IPCTPK.
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
					}else{
						$pesan='<html lang="en">
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
								<td>'.$arrdataMail[0]['NPWP_IMPORTIR'].'</td>
							</tr>
							<tr>
								<td width=""><b>Nama Perusahaan</b> </td>
								<td>:</td>
								<td>'.$arrdataMail[0]['NAMA_IMPORTIR'].'</td>
							</tr>
							<tr>
								<td><b>Nama Kapal </b></td>
								<td>:</td>
								<td>'.$arrdataMail[0]['KAPAL'].'</td>
							</tr>
							<tr>
								<td><b>NO. BL </b></td>
								<td>:</td>
								<td>'.$arrdataMail[0]['NO_BL'].'</td>
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
											<td></td>
											<td><b>Tanggal Dokumen Dikeluarkan</b></td>
											<td>:</td>
											<td></td>
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
											<td><b>DOKUMEN LAIN('.$arrdataMail[0]['JENIS_DOKUMEN'].')</b></td>
											<td>:</td>
											<td>'.$arrdataMail[0]['NO_DOKUMEN'].'</td>
											<td><b>Tanggal Dokumen Dikeluarkan</b></td>
											<td>:</td>
											<td>'.$arrdataMail[0]['TGL_DOK'].'</td>
										</tr>
										<tr>
											<td><b>BC.1.1</b></td>
											<td>:</td>
											<td>'.$arrdataMail[0]['NO_BC'].'</td>
											<td><b>Tanggal Dokumen Dikeluarkan</b></td>
											<td>:</td>
											<td>'.$arrdataMail[0]['TGL_BC'].'</td>
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
										This message was delivered by BOS – IPCTPK.
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
					}


					$multi_email = $this->db->query("SELECT ID,EMAIL FROM reff_mail WHERE KEGIATAN = 'GATE'")->result_array();
					//print_r($email[1]['EMAIL']);die();
					for ($i=0; $i < count($multi_email) ; $i++) {
						//$subject = "REMINDER [".$arrdataMail['NOMOR_DOKUMEN']."]";
						$subject = "REMINDER [GATEPASS]";//"REMINDER [".$arrdataMail[0]['NOMOR_DOKUMEN']."]";
						$email = $multi_email[$i]['EMAIL'];//'nuridin.mu23@gmail.com';
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

							$msg = $pesan;
							$this->load->library('email', $config);
							#$this->email->set_newline("\r\n");
							$this->email->from('automail@multiterminal.co.id', 'BOS NOTIFICATION - REQUEST GATEPASS'); //udah
							$email = str_replace(';', ',', $email);
							$this->email->to($email);
							////$array_bcc = array('nuridin.mu23@gmail.com','muhammad.nuridin@edi-indonesia.co.id','salman.abdulaziz@edi-indonesia.co.id', 'cgs@indonesiaport.co.id', 'automail@multiterminal.co.id','get@npct1.co.id');
							//$this->email->bcc($array_bcc);
							$this->email->subject($subject);
							$this->email->message($msg);

							//}//tutup for
							//}
							if ($this->email->send()){
								$email_success = 1;
								//echo "<script>alert('Email Terkirim');window.location=''</script>";
								$SQL_MAIL = $this->db->query("SELECT ID,GROUP_CONCAT(EMAIL) AS 'EMAIL',KEGIATAN FROM reff_mail WHERE KEGIATAN = 'GATE'")->row();
								echo "Email Terkirim";
								//echo "Email Terkirim Ke <b>".$SQL_MAIL->EMAIL."</b> ";
								#$this->db->where(array('ID' => $id));
								#$this->db->update('t_permit_hdr', array('STATUS_MAIL' => 'Email Terkirim'));
							} else {
								echo "Email Tidak Terkirim";
								#$this->db->where(array('ID' => $id));
								#$this->db->update('t_permit_hdr', array('STATUS_MAIL' => 'Email Tidak Terkirim'));
							}
						}
					}	
					return $email_success;
				}*/
			} else {
				echo "MSG#ERR#" . $message . "#";
			}

			if ($error == 0) {
				$action = '/planning/manual/post';
				echo "MSG#OK#Data berhasil diproses#" . site_url() . $action;
			} else {
				echo "MSG#ERR#" . $message . "#";
			}
		}
	}
}
