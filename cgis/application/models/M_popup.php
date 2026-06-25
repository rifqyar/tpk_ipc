<?php if (! defined('BASEPATH')) exit('No direct script access allowed');
class M_popup extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
	}

	function popup_search($act, $id, $popup, $ajax)
	{
		$func = get_instance();
		$this->load->library('newtable');
		$KD_USER = $this->session->userdata('ID');
		$KD_ORG = $this->session->userdata('KD_ORGANISASI');
		$KD_TPS = $this->session->userdata('KD_TPS');
		$KD_GUDANG = $this->session->userdata('KD_GUDANG');
		$KD_GROUP = $this->session->userdata('KD_GROUP');
		$arract = explode("|", urldecode($act));
		$showchk = true;
		if ($id != "")	$id = "/" . $id;
		if ($ajax != "") $ajax = "/" . $ajax;
		if ($arract[0] == "discharge_kontainer") {
			$judul = "DISCHARGE - KONTAINER";
			$SQL = "SELECT A.NO_CONT AS 'NOMOR KONTAINER', func_name(IFNULL(A.KD_CONT_UKURAN,'-'),'CONT_UKURAN') AS UKURAN,
					func_name(IFNULL(A.KD_CONT_JENIS,'-'),'CONT_JENIS') AS JENIS,
					func_name(IFNULL(A.KD_CONT_TIPE,'-'),'CONT_TIPE') AS TIPE, A.ID
					FROM t_cocostscont A
					INNER JOIN t_cocostshdr B ON B.ID=A.ID
					WHERE B.KD_ASAL_BRG = '1'
					AND A.ID = " . $this->db->escape($arract[1]);
			$proses = array('SELECT' => array('OPTION', site_url() . "/popup/pilih" . $id, '1', '', 'icon md-check', $popup));
			$this->newtable->search(array(array('NO_CONT', 'NOMOR KONTAINER')));
			$this->newtable->action(site_url() . "/popup/popup_search/" . $arract[0] . "|" . $arract[1] . $id . "/" . $popup);
			$this->newtable->hiddens(array('ID'));
			$this->newtable->keys(array("ID", "NOMOR KONTAINER"));
			$showchk = true;
		} else if ($arract[0] == "gatein_kontainer") {
			$judul = "DISCHARGE - KONTAINER";
			$SQL = "SELECT A.NO_CONT AS 'NOMOR KONTAINER', func_name(IFNULL(A.KD_CONT_UKURAN,'-'),'CONT_UKURAN') AS UKURAN,
					func_name(IFNULL(A.KD_CONT_JENIS,'-'),'CONT_JENIS') AS JENIS,
					func_name(IFNULL(A.KD_CONT_TIPE,'-'),'CONT_TIPE') AS TIPE, A.ID
					FROM t_cocostscont A
					INNER JOIN t_cocostshdr B ON B.ID=A.ID
					WHERE B.KD_ASAL_BRG = '3'
					AND A.ID = " . $this->db->escape($arract[1]);
			$proses = array('SELECT' => array('OPTION', site_url() . "/popup/pilih" . $id, '1', '', 'icon md-check', $popup));
			$this->newtable->search(array(array('NO_CONT', 'NOMOR KONTAINER')));
			$this->newtable->action(site_url() . "/popup/popup_search/" . $arract[0] . "|" . $arract[1] . $id . "/" . $popup);
			$this->newtable->hiddens(array('ID'));
			$this->newtable->keys(array("ID", "NOMOR KONTAINER"));
			$showchk = true;
		} else if ($arract[0] == "mst_organisasi") {
			$judul = "ORGANISASI";
			if ($KD_GROUP != "SPA") {
				$addsql .= " AND ID = " . $this->db->escape($KD_ORG);
			}
			if ($arract[1] != "") {
				$addsql .= " AND KD_TIPE_ORGANISASI = " . $this->db->escape($arract[1]);
			}
			$SQL = "SELECT ID, NPWP, NAMA, ALAMAT, KD_TIPE_ORGANISASI AS 'GROUP'
					FROM t_organisasi WHERE 1=1" . $addsql;
			$proses = array('SELECT' => array('OPTION', site_url() . "/popup/pilih" . $id, '1', '', 'icon md-check', $popup));
			$this->newtable->search(array(array('NPWP', 'NPWP'), array('NAMA', 'NAMA'), array('ALAMAT', 'ALAMAT')));
			$this->newtable->action(site_url() . "/popup/popup_search/" . $arract[0] . "|" . $arract[1] . "/" . $id . "/" . $popup);
			$this->newtable->hiddens(array('ID'));
			$this->newtable->keys(array("ID", "NAMA"));
			$showchk = true;
		} else if ($arract[0] == "mst_kddok") {
			$judul = "JENIS DOKUMEN";
			$SQL = "SELECT ID, NAMA, KD_PERMIT
					FROM reff_kode_dok_bc WHERE ID NOT IN ('83','2','1')  AND 1=1" . $addsql;
			$proses = array('SELECT' => array('OPTION', site_url() . "/popup/pilih" . $id, '1', '', 'icon md-check', $popup, 'menu'));
			$this->newtable->search(array(array('NAMA', 'NAMA')));
			$this->newtable->action(site_url() . "/popup/popup_search/" . $arract[0] . "|" . $arract[1] . "/" . $id . "/" . $popup);
			$this->newtable->hiddens(array('ID'));
			$this->newtable->keys(array("ID", "NAMA"));
			$showchk = true;
		} else if ($arract[0] == "group") {
			$judul = "JENIS DOKUMEN";
			$SQL = "SELECT ID, NAMA
					FROM reff_group WHERE 1=1" . $addsql;
			$proses = array('SELECT' => array('OPTION', site_url() . "/popup/pilih" . $id, '1', '', 'icon md-check', $popup, 'menu'));
			$this->newtable->search(array(array('NAMA', 'NAMA')));
			$this->newtable->action(site_url() . "/popup/popup_search/" . $arract[0] . "|" . $arract[1] . "/" . $id . "/" . $popup);
			$this->newtable->hiddens(array('ID'));
			$this->newtable->keys(array("ID", "NAMA"));
			$showchk = true;
		} else if ($arract[0] == "mst_gudang") {
			$judul = "GUDANG";
			$SQL = "SELECT KD_TPS AS 'KODE TPS', KD_GUDANG AS 'KODE GUDANG', NAMA_GUDANG AS 'NAMA GUDANG'
					FROM reff_gudang";
			$proses = array('SELECT' => array('OPTION', site_url() . "/popup/pilih" . $id, '1', '', 'icon md-check', $popup));
			$this->newtable->search(array(array('KD_TPS', 'KODE TPS'), array('KD_GUDANG', 'KODE GUDANG')));
			$this->newtable->action(site_url() . "/popup/popup_search/" . $arract[0] . "/" . $id . "/" . $popup);
			$this->newtable->hiddens(array(''));
			$this->newtable->keys(array("KODE TPS", "KODE GUDANG"));
			$showchk = true;
		} else if ($arract[0] == "app_user") {
			$judul = "USER";
			if ($KD_GROUP != "SPA") {
				$addsql .= " AND KD_GROUP = 'USR' AND KD_ORGANISASI = " . $this->db->escape($KD_ORG);
			}
			$SQL = "SELECT USERLOGIN, NM_LENGKAP AS NAMA, HANDPHONE, EMAIL, KD_GROUP AS 'GROUP', ID
					FROM app_user WHERE 1=1" . $addsql;
			$proses = array('SELECT' => array('OPTION', site_url() . "/popup/pilih" . $id, '1', '', 'icon md-check', $popup));
			$this->newtable->search(array(array('USERLOGIN', 'USERLOGIN'), array('NM_LENGKAP', 'NAMA')));
			$this->newtable->action(site_url() . "/popup/popup_search/" . $arract[0] . "/" . $id . "/" . $popup);
			$this->newtable->hiddens(array('ID'));
			$this->newtable->keys(array("ID", "USERLOGIN"));
			$showchk = true;
		} else if ($arract[0] == "app_group") {
			$judul = "USER";
			if ($KD_GROUP != "SPA") {
				$addsql .= " AND KD_GROUP = 'USR' AND KD_ORGANISASI = " . $this->db->escape($KD_ORG);
			}
			$SQL = "SELECT USER_NAME, NAMA, NOTELP, EMAIL, KD_GROUP AS 'GROUP', ID
					FROM reff_user WHERE 1=1" . $addsql;
			$proses = array('SELECT' => array('OPTION', site_url() . "/popup/pilih" . $id, '1', '', 'icon md-check', $popup, 'menu'));
			$this->newtable->search(array(array('USER_NAME', 'USER NAME'), array('NAMA', 'NAMA')));
			$this->newtable->action(site_url() . "/popup/popup_search/" . $arract[0] . "/" . $id . "/" . $popup);
			$this->newtable->hiddens(array('ID'));
			$this->newtable->keys(array("KD_GROUP", "USER_NAME"));
			$showchk = true;
		} else if ($arract[0] == "mst_all_dok") {
			$SQL = "SELECT X.JNS_DOK, X.NO_DOK, X.TGL_DOK
					FROM
					(SELECT B.NAMA AS 'JNS_DOK', A.NO_DOK_INOUT AS 'NO_DOK', A.TGL_DAFTAR_PABEAN AS 'TGL_DOK'
					FROM t_permit_hdr A
					INNER JOIN reff_kode_dok_bc B ON A.KD_DOK_INOUT = B.ID
					WHERE A.KD_DOK_INOUT IN('19','81','82','83','28','43','44','14','100', '80', '17', '18', '99', '80', '13')
					UNION ALL
					SELECT 'SPPMP' AS 'JNS_DOK', D.NO_RESPON AS 'NO_DOK', D.TG_RESPON AS 'TGL_DOK'
					FROM t_ppk_hdr D)
					X WHERE 1 = 1";
			$proses = array('SELECT' => array('OPTION', site_url() . "/popup/pilih" . $id, '1', '', 'icon md-check', $popup, 'menu'));
			$this->newtable->search(array(array('X.NO_DOK', 'NO DOKUMEN'), array('X.JNS_DOK', 'JENIS DOKUMEN')));
			$this->newtable->action(site_url() . "/popup/popup_search/" . $arract[0] . "|" . $arract[1] . "/" . $id . "/" . $popup);
			$this->newtable->hiddens(array('ID'));
			$this->newtable->keys(array("JNS_DOK", "NO_DOK", "TGL_DOK"));
			$showchk = true;
		} else if ($arract[0] == "mt_customer") {
			$judul = "CUSTOMER";
			/*if($KD_GROUP != "SPA"){
				$addsql .= " AND ID = ".$this->db->escape($KD_ORG);
			}
			if($arract[1]!=""){
				$addsql .= " AND KD_TIPE_ORGANISASI = ".$this->db->escape($arract[1]);
			}*/
			$SQL = "SELECT ID_CUST, NPWP, NAMA_CUST, ALAMAT
					FROM m_pelanggan WHERE 1=1"; //.$addsql;
			$proses = array('SELECT' => array('OPTION', site_url() . "/popup/pilih" . $id, '1', '', 'icon md-check', $popup, 'menu'));
			$this->newtable->search(array(array('NAMA_CUST', 'NAMA'), array('NPWP', 'NPWP'), array('ALAMAT', 'ALAMAT')));
			$this->newtable->action(site_url() . "/popup/popup_search/" . $arract[0] . "|" . $arract[1] . "/" . $id . "/" . $popup);
			$this->newtable->hiddens(array('NPWP'));
			$this->newtable->keys(array("NPWP", "NAMA_CUST", "ALAMAT"));
			$showchk = true;
		} else if ($arract[0] == "mst_dokumen") {
			$judul = "DOKUMEN";
			/*if($KD_GROUP != "SPA"){
				$addsql .= " AND ID = ".$this->db->escape($KD_ORG);
			}
			if($arract[1]!=""){
				$addsql .= " AND KD_TIPE_ORGANISASI = ".$this->db->escape($arract[1]);
			}*/
			$SQL = "SELECT C.NO_DAFTAR_PABEAN AS 'NO_DOKUMEN',D.NAMA AS 'JENIS_DOKUMEN',
					C.NM_ANGKUT AS 'NAMA_KAPAL', C.NO_VOY_FLIGHT 'NO_VOYAGE',
					DATE_FORMAT(C.TGL_DAFTAR_PABEAN,'%d-%m-%Y') AS 'TGL_DOKUMEN'
					FROM t_permit_hdr C 
					LEFT JOIN reff_kode_dok_bc D on C.KD_DOK_INOUT = D.ID
					WHERE KD_DOK_INOUT IN ('19','81','82','83')"; //.$addsql;
			$proses = array('SELECT' => array('OPTION', site_url() . "/popup/pilih" . $id, '1', '', 'icon md-check', $popup, 'menu'));
			$this->newtable->search(array(array('C.NO_DOK_INOUT', 'NO. DOKUMEN')));
			$this->newtable->action(site_url() . "/popup/popup_search/" . $arract[0] . "|" . $arract[1] . "/" . $id . "/" . $popup);
			$this->newtable->hiddens(array('ID'));
			$this->newtable->keys(array("JENIS_DOKUMEN", "NO_DOKUMEN", "TGL_DOKUMEN"));
			$showchk = true;
		} else if ($arract[0] == "mt_dok_sppb") {
			$judul = "SPPB";
			/*if($KD_GROUP != "SPA"){
				$addsql .= " AND ID = ".$this->db->escape($KD_ORG);
			}
			if($arract[1]!=""){
				$addsql .= " AND KD_TIPE_ORGANISASI = ".$this->db->escape($arract[1]);
			}*/
			$SQL = "SELECT ID, NM_ANGKUT,NO_VOY_FLIGHT, NO_DOK_INOUT,TGL_DOK_INOUT FROM t_permit_hdr WHERE KD_DOK_INOUT = 1"; //.$addsql;
			$proses = array('SELECT' => array('OPTION', site_url() . "/popup/pilih" . $id, '1', '', 'icon md-check', $popup, 'menu'));
			$this->newtable->search(array(array('NO_DOK_INOUT', 'NO. DOKUMEN'), array('TGL_DOK_INOUT', 'TGL. DOKUMEN')));
			$this->newtable->action(site_url() . "/popup/popup_search/" . $arract[0] . "|" . $arract[1] . "/" . $id . "/" . $popup);
			$this->newtable->hiddens(array('ID'));
			$this->newtable->keys(array("NM_ANGKUT", "NO_VOY_FLIGHT", "TGL_DOK_INOUT", "NO_DOK_INOUT"));
			$showchk = true;
		}
		$this->newtable->multiple_search(false);
		$this->newtable->tipe_proses('button');
		$this->newtable->show_chk($showchk);
		$this->newtable->show_search(true);
		$this->newtable->cidb($this->db);
		$this->newtable->set_formid("tblsearch");
		$this->newtable->set_divid("divtblsearch");
		$this->newtable->rowcount(10);
		$this->newtable->clear();
		$this->newtable->menu($proses);
		$tabel .= $this->newtable->generate($SQL);
		$arrdata = array("title" => $judul, "content" => $tabel);
		if ($this->input->post("ajax") || $act == "post") return $tabel;
		else return $arrdata;
	}

	function pilih($id, $ajax)
	{
		$arrayReturn = array();
		$arrfield = explode('|', urldecode($id));
		if (count($arrfield > 0)) {
			foreach ($this->input->post('tb_chktblsearch') as $chkitem) {
				$arrdata[]  = $chkitem;
			}
			$value = implode($arrdata, ",");
			$arrvalue = explode("~", $value);
		}
		if ($ajax != "") $ajax = str_replace("~", "/", $ajax);
		$arrayReturn['arrajax'] = $ajax;
		$arrayReturn['arrvalue'] = $arrvalue;
		$arrayReturn['arrfield'] = $arrfield;
		echo json_encode($arrayReturn);
	}

	public function execute($type, $act)
	{
		$post = $this->input->post('term');
		$post = strtoupper($post);

		if ($type == "mst_kapal") {
			if (!$post) return;
			$SQL = "SELECT ID, CONCAT(NM_KAPAL,' [',NO_VOYAGE,']') AS NAMA, NM_KAPAL, NO_VOYAGE AS NOV, CALL_SIGN, ATA AS TGL_TIBA
					FROM t_jadwal_kapal
					WHERE UPPER(ID) LIKE '%" . $post . "%' OR UPPER(NM_KAPAL) LIKE '%" . $post . "%' ORDER BY WK_REKAM DESC";
			//echo $SQL;die();
			$result = $this->db->query($SQL);
			$banyakData = $result->num_rows();
			$arrayDataTemp = array();
			if ($banyakData > 0) {
				foreach ($result->result() as $row) {
					$KODE = strtoupper($row->ID);
					$NAMA = strtoupper($row->NAMA);
					$NM_KAPAL = strtoupper($row->NM_KAPAL);
					$NOV = strtoupper($row->NOV);
					$TGL_TIBA = strtoupper($row->TGL_TIBA);
					$arrayDataTemp[] = array("value" => $NM_KAPAL, "label" => $NAMA, 'NAMA' => $KODE, 'NO_VOY' => $NOV, 'TGL_TIBA' => $TGL_TIBA);
					/*if($act=="kode"){
						$arrayDataTemp[] = array("value"=>$KODE,"label"=>$NAMA,'NAMA'=>$NAMA);
					}else if($act=="nama"){
						$arrayDataTemp[] = array("value"=>$NAMA,"KD_KAPAL"=>$KODE,'NAMA'=>$NAMA);
					}else if($act=="voy"){
						$arrayDataTemp[] = array("value"=>$NOV,"KD_KAPAL"=>$KODE,'NOV'=>$NOV);
					}*/
				}
			}
			echo json_encode($arrayDataTemp);
		} else if ($type == "mst_port") {
			if (!$post) return;
			$SQL = "SELECT ID, CONCAT(NAMA,'[',ID,']') AS NAMA, NAMA AS GET_NAME
					FROM reff_pelabuhan WHERE ID LIKE '%" . $post . "%' OR NAMA LIKE '%" . $post . "%' LIMIT 5";
			$result = $this->db->query($SQL);
			$banyakData = $result->num_rows();
			$arrayDataTemp = array();
			if ($banyakData > 0) {
				foreach ($result->result() as $row) {
					$KODE = strtoupper($row->ID);
					$NAMA = strtoupper($row->NAMA);
					$GET = strtoupper($row->GET_NAME);
					if ($act == "kode") {
						$arrayDataTemp[] = array("value" => $KODE, "label" => $NAMA, "NAMA" => $GET);
					} else if ($act == "nama") {
						$arrayDataTemp[] = array("value" => $GET, "label" => $NAMA, "KODE" => $KODE);
					}
				}
			}
			echo json_encode($arrayDataTemp);
		} else if ($type == "mst_customer") {
			if (!$post) return;
			$SQL = "SELECT ID, NAMA_CUST AS NAMA,
					FROM t_pelanggan
					WHERE UPPER(ID) LIKE '%" . $post . "%' OR UPPER(NM_KAPAL) LIKE '%" . $post . "%' LIMIT 5";
			//echo $SQL;die();
			$result = $this->db->query($SQL);
			$banyakData = $result->num_rows();
			$arrayDataTemp = array();
			if ($banyakData > 0) {
				foreach ($result->result() as $row) {
					$KODE = strtoupper($row->ID);
					$NAMA = strtoupper($row->NAMA);
					if ($act == "kode") {
						$arrayDataTemp[] = array("value" => $KODE, "label" => $NAMA, 'NAMA' => $NAMA);
					} else if ($act == "nama") {
						$arrayDataTemp[] = array("value" => $NAMA, "KD_KAPAL" => $KODE, 'NAMA' => $NAMA);
					}
				}
			}
			echo json_encode($arrayDataTemp);
		} else if ($type == "mst_kemasan") {
			if (!$post) return;
			$SQL = "SELECT ID, CONCAT(NAMA,' [',ID,']') AS NAMA, NAMA AS GET_NAME
					FROM reff_kemasan WHERE ID LIKE '%" . $post . "%' OR NAMA LIKE '%" . $post . "%' LIMIT 5";
			$result = $this->db->query($SQL);
			$banyakData = $result->num_rows();
			$arrayDataTemp = array();
			if ($banyakData > 0) {
				foreach ($result->result() as $row) {
					$KODE = strtoupper($row->ID);
					$NAMA = strtoupper($row->NAMA);
					$GET = strtoupper($row->GET_NAME);
					if ($act == "kode") {
						$arrayDataTemp[] = array("value" => $KODE, "label" => $NAMA, 'NAMA' => $GET);
					} else if ($act == "nama") {
						$arrayDataTemp[] = array("value" => $GET, "label" => $NAMA, 'KODE' => $KODE);
					}
				}
			}
			echo json_encode($arrayDataTemp);
		} else if ($type == "mst_dok_bc") {
			if (!$post) return;
			$SQL = "SELECT ID, NAMA FROM reff_kode_dok_bc
					WHERE KD_PERMIT = " . $this->db->escape(strtoupper($act)) . "
					AND NAMA LIKE '%" . $post . "%' LIMIT 5";
			$result = $this->db->query($SQL);
			$banyakData = $result->num_rows();
			$arrayDataTemp = array();
			if ($banyakData > 0) {
				foreach ($result->result() as $row) {
					$KODE = strtoupper($row->ID);
					$NAMA = strtoupper($row->NAMA);
					$arrayDataTemp[] = array("value" => $NAMA, "KODE" => $KODE);
				}
			}
			echo json_encode($arrayDataTemp);
		} else if ($type == "mst_isocode") {
			if (!$post) return;
			$SQL = "SELECT ID, NAMA FROM reff_cont_isocode
					WHERE ID LIKE '%" . $post . "%' OR NAMA LIKE '%" . $post . "%' LIMIT 5";
			$result = $this->db->query($SQL);
			$banyakData = $result->num_rows();
			$arrayDataTemp = array();
			if ($banyakData > 0) {
				foreach ($result->result() as $row) {
					$KODE = strtoupper($row->ID);
					$NAMA = strtoupper($row->NAMA);
					$arrayDataTemp[] = array("value" => $NAMA, "KODE" => $KODE);
				}
			}
			echo json_encode($arrayDataTemp);
		} else if ($type == "mst_organisasi") {
			if (!$post) return;
			if ($act != "") {
				$add_sql = " AND KD_TIPE_ORGANISASI = " . $this->db->escape($act);
			}
			$SQL = "SELECT ID, NAMA FROM t_organisasi
					WHERE NAMA LIKE '%" . $post . "%'" . $add_sql . "
					LIMIT 5";
			$result = $this->db->query($SQL);
			$banyakData = $result->num_rows();
			$arrayDataTemp = array();
			if ($banyakData > 0) {
				foreach ($result->result() as $row) {
					$KODE = strtoupper($row->ID);
					$NAMA = strtoupper($row->NAMA);
					$arrayDataTemp[] = array("value" => $NAMA, "KODE" => $KODE);
				}
			}
			echo json_encode($arrayDataTemp);
		} else if ($type == "res_plp") {
			if (!$post) return;
			$SQL = "SELECT A.ID, A.KD_KPBC, A.KD_TPS_ASAL, A.KD_TPS_TUJUAN, A.KD_GUDANG_TUJUAN, A.NO_PLP, A.NO_SURAT, A.TGL_SURAT, A.NM_ANGKUT,
					DATE_FORMAT(A.TGL_PLP,'%d-%m-%Y') AS TGL_PLP, A.NO_VOY_FLIGHT, A.CALL_SIGN, A.TGL_TIBA, A.NO_BC11, A.TGL_BC11
					FROM t_respon_plp_tujuan_v2_hdr A
					WHERE A.NO_PLP LIKE '%" . $post . "%' LIMIT 5";
			$result = $this->db->query($SQL);
			$banyakData = $result->num_rows();
			$arrayDataTemp = array();
			if ($banyakData > 0) {
				foreach ($result->result() as $row) {
					$PLP = strtoupper($row->NO_PLP);
					$TGL_PLP = $row->TGL_PLP;
					$arrayDataTemp[] = array("value" => $PLP, "TGL_PLP" => $TGL_PLP);
				}
			}
			echo json_encode($arrayDataTemp);
		} else if ($type == "t_pemeriksa_ppk_bc") {
			if (!$post) return;
			$SQL = "SELECT ID,NAMA,NIPP FROM t_pemeriksa_ppk WHERE USE_AKSES = 'BC'
					AND UPPER(NAMA) LIKE '%" . $post . "%' ORDER BY ID DESC";
			//echo $SQL;die();
			$result = $this->db->query($SQL);
			$banyakData = $result->num_rows();
			$arrayDataTemp = array();
			if ($banyakData > 0) {
				foreach ($result->result() as $row) {
					$id = strtoupper($row->ID);
					$NIPP = strtoupper($row->NIPP);
					$NAMA = $row->NAMA;
					$arrayDataTemp[] = array("value" => $NAMA, "label" => $NAMA, "nipp" => $NIPP, "id" => $id);
				}
			}
			echo json_encode($arrayDataTemp);
		} else if ($type == "t_pemeriksa_ppk_kr") {
			if (!$post) return;
			$SQL = "SELECT ID,NAMA,NIPP FROM t_pemeriksa_ppk WHERE USE_AKSES = 'KARANTINA'
					AND UPPER(NAMA) LIKE '%" . $post . "%' ORDER BY ID DESC";
			//echo $SQL;die();
			$result = $this->db->query($SQL);
			$banyakData = $result->num_rows();
			$arrayDataTemp = array();
			if ($banyakData > 0) {
				foreach ($result->result() as $row) {
					$id = strtoupper($row->ID);
					$NIPP = strtoupper($row->NIPP);
					$NAMA = $row->NAMA;
					$arrayDataTemp[] = array("value" => $NAMA, "label" => $NAMA, "nipp" => $NIPP, "id" => $id);
				}
			}
			echo json_encode($arrayDataTemp);
		}
	}

	public function get_combobox($act)
	{
		$func = get_instance();
		$func->load->model("m_main", "main", true);
		if ($act == 'cont_ukuran') {
			$sql = "SELECT ID, NAMA FROM reff_cont_ukuran ORDER BY ID ASC";
			$arrdata = $func->main->get_combobox($sql, "ID", "NAMA", TRUE);
		} else if ($act == 'cont_jenis') {
			$sql = "SELECT ID, NAMA FROM reff_cont_jenis ORDER BY ID ASC";
			$arrdata = $func->main->get_combobox($sql, "ID", "NAMA", TRUE);
		} else if ($act == 'cont_tipe') {
			$sql = "SELECT ID, NAMA FROM reff_cont_tipe ORDER BY ID ASC";
			$arrdata = $func->main->get_combobox($sql, "ID", "NAMA", TRUE);
		} else if ($act == 'cont_isocode') {
			$sql = "SELECT ID, NAMA FROM reff_cont_isocode ORDER BY ID ASC";
			$arrdata = $func->main->get_combobox($sql, "ID", "NAMA", TRUE);
		} else if ($act == 'cont_status') {
			$sql = "SELECT ID, NAMA FROM reff_cont_status ORDER BY ID ASC";
			$arrdata = $func->main->get_combobox($sql, "ID", "NAMA", TRUE);
		} else if ($act == 'sarana_angkut') {
			$sql = "SELECT ID, NAMA FROM reff_sarana_angkut ORDER BY ID ASC";
			$arrdata = $func->main->get_combobox($sql, "ID", "NAMA", TRUE);
		}
		return $arrdata;
	}
}
