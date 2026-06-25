<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class M_status extends CI_Model{
	
	public function kontainer($act, $id){
		$page_title = "KONTAINER";
		$title = "KONTAINER";
		$this->newtable->breadcrumb('Dashboard', site_url(),'icon-home');
		$this->newtable->breadcrumb('Reference', 'javascript:void(0)','');
		$this->newtable->breadcrumb('Customer', 'javascript:void(0)','');
		$check = (grant()=="W")?true:false;
		$SQL = "SELECT X.KD_DOK, X.ID_IJIN, X.ANGKUTNAMA, X.ANGKUTNO, X.NO_CONT, X.SAMPLE, X.NO_TPFT, X.TGL_TPFT,
				X.STATUS_CONT, X.STATUS, X.TGL_STATUS 
				FROM (
				SELECT 'SPPMP' AS KD_DOK, A.ID_IJIN, A.NO_CONT, B.ANGKUTNAMA, B.ANGKUTNO,
				CASE WHEN A.NO_TPFT IS NULL THEN 'NON SAMPEL'
					 ELSE 'SAMPEL'
				END AS SAMPLE,
				IFNULL(A.NO_TPFT,'') AS NO_TPFT, DATE_FORMAT(A.TGL_TPFT,'%d-%m-%Y') AS TGL_TPFT, 
				D.NAMA AS STATUS_CONT, C.NAMA AS STATUS, A.TGL_STATUS
				FROM t_ppk_cont A
				INNER JOIN t_ppk_hdr B ON B.ID_IJIN=A.ID_IJIN
				LEFT JOIN reff_status_cont C ON C.ID=A.KD_STATUS
				LEFT JOIN reff_relokasi D ON D.ID=A.STATUS_CONT
				UNION ALL
				SELECT 'SPJM' AS KD_DOK, AA.ID AS ID_IJIN, AA.NO_CONT, BB.NM_ANGKUT AS ANGKUTNAMA, BB.NO_VOY_FLIGHT AS ANGKUTNO,
				'NON SAMPEL' AS SAMPLE,
				IFNULL(BB.NO_DAFTAR_PABEAN,'') AS NO_TPFT, DATE_FORMAT(BB.TGL_DAFTAR_PABEAN,'%d-%m-%Y') AS TGL_TPFT, 
				DD.NAMA AS STATUS_CONT, CC.NAMA AS STATUS, AA.TGL_STATUS
				FROM t_permit_cont AA
				INNER JOIN t_permit_hdr BB ON BB.ID=AA.ID
				LEFT JOIN reff_status_cont CC ON CC.ID=AA.KD_STATUS
				LEFT JOIN reff_relokasi DD ON DD.ID=AA.STATUS_CONT
				) X
				WHERE 1=1
				ORDER BY X.TGL_STATUS DESC
				LIMIT 0,20";
		//$proses = array('ENTRY'  => array('MODAL',"reference/customer/add", '0','','md-plus-circle','', 'menu'),
		//								'UPDATE' => array('MODAL',"reference/customer/update", '1','','md-edit','', 'list'),
						//'REALISASI' => array('MODAL',"planning/shipment/release", '1','','md-refresh-alt','', 'list'),
		//				'DELETE'  => array('DELETE',"execute/process/delete/customer", '1','','md-close-circle','', 'list'));
						//'UPLOAD' => array('ADD',site_url()."/coarri/discharge/upload", '','','md-attachment'));
		$this->newtable->multiple_search(true);
		$this->newtable->show_chk(false);
		$this->newtable->show_menu($check);
		$this->newtable->show_search(true);
		$this->newtable->search(array(array('ANGKUTNAMA','NAMA KAPAL'),array('NO_CONT','NO. KONTAINER'),array('STATUS_CONT','STATUS KONTAINER')));
		$this->newtable->action(site_url() . "/status/kontainer");
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("ID"));
		$this->newtable->keys(array("ID"));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby("NPWP");
		$this->newtable->sortby("ASC");
		$this->newtable->set_formid("tblcustomer");
		$this->newtable->set_divid("divcustomer");
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
	
	
	
	function status_container(){
		error_reporting(ALL);
		$SQL = "SELECT X.KD_DOK, X.ID_IJIN, X.ANGKUTNAMA, X.ANGKUTNO, X.NO_CONT, X.SAMPLE, X.NO_TPFT, X.TGL_TPFT,
				X.STATUS_CONT, X.STATUS, X.TGL_STATUS 
				FROM (
				SELECT 'SPPMP' AS KD_DOK, A.ID_IJIN, A.NO_CONT, B.ANGKUTNAMA, B.ANGKUTNO,
				CASE WHEN A.NO_TPFT IS NULL THEN 'NON SAMPEL'
					 ELSE 'SAMPEL'
				END AS SAMPLE,
				IFNULL(A.NO_TPFT,'') AS NO_TPFT, DATE_FORMAT(A.TGL_TPFT,'%d-%m-%Y') AS TGL_TPFT, 
				D.NAMA AS STATUS_CONT, C.NAMA AS STATUS, A.TGL_STATUS
				FROM t_ppk_cont A
				INNER JOIN t_ppk_hdr B ON B.ID_IJIN=A.ID_IJIN
				LEFT JOIN reff_status_cont C ON C.ID=A.KD_STATUS
				LEFT JOIN reff_relokasi D ON D.ID=A.STATUS_CONT
				UNION ALL
				SELECT 'SPJM' AS KD_DOK, AA.ID AS ID_IJIN, AA.NO_CONT, BB.NM_ANGKUT AS ANGKUTNAMA, BB.NO_VOY_FLIGHT AS ANGKUTNO,
				'NON SAMPEL' AS SAMPLE,
				IFNULL(BB.NO_DAFTAR_PABEAN,'') AS NO_TPFT, DATE_FORMAT(BB.TGL_DAFTAR_PABEAN,'%d-%m-%Y') AS TGL_TPFT, 
				DD.NAMA AS STATUS_CONT, CC.NAMA AS STATUS, AA.TGL_STATUS
				FROM t_permit_cont AA
				INNER JOIN t_permit_hdr BB ON BB.ID=AA.ID
				LEFT JOIN reff_status_cont CC ON CC.ID=AA.KD_STATUS
				LEFT JOIN reff_relokasi DD ON DD.ID=AA.STATUS_CONT
				) X
				WHERE 1=1
				ORDER BY X.TGL_STATUS DESC
				LIMIT 0,20";
		$result = $this->db->query($SQL);
		$array_data = $result->result_array();
		$result->free_result();
		return $array_data;
	}
	
	function status_container_update(){
		$ID 	   = $this->input->post('ID');
		$TIMESTAMP = $this->input->post('TIMESTAMP');
		$arrdate   = explode(' ',$TIMESTAMP);
		$DATE	   = $arrdate[0];
		$TIME	   = $arrdate[1];
		$countData = 0;
		if ($TIMESTAMP == ""){
			$SQL = "SELECT X.KD_DOK, X.ID_IJIN, X.ANGKUTNAMA, X.ANGKUTNO, X.NO_CONT, X.SAMPLE, X.NO_TPFT, X.TGL_TPFT,
					X.STATUS_CONT, X.STATUS, X.TGL_STATUS 
					FROM (
					SELECT 'SPPMP' AS KD_DOK, A.ID_IJIN, A.NO_CONT, B.ANGKUTNAMA, B.ANGKUTNO,
					CASE WHEN A.NO_TPFT IS NULL THEN 'NON SAMPEL'
						 ELSE 'SAMPEL'
					END AS SAMPLE,
					IFNULL(A.NO_TPFT,'') AS NO_TPFT, DATE_FORMAT(A.TGL_TPFT,'%d-%m-%Y') AS TGL_TPFT, 
					D.NAMA AS STATUS_CONT, C.NAMA AS STATUS, A.TGL_STATUS
					FROM t_ppk_cont A
					INNER JOIN t_ppk_hdr B ON B.ID_IJIN=A.ID_IJIN
					LEFT JOIN reff_status_cont C ON C.ID=A.KD_STATUS
					LEFT JOIN reff_relokasi D ON D.ID=A.STATUS_CONT
					UNION ALL
					SELECT 'SPJM' AS KD_DOK, AA.ID AS ID_IJIN, AA.NO_CONT, BB.NM_ANGKUT AS ANGKUTNAMA, BB.NO_VOY_FLIGHT AS ANGKUTNO,
					'NON SAMPEL' AS SAMPLE,
					IFNULL(BB.NO_DAFTAR_PABEAN,'') AS NO_TPFT, DATE_FORMAT(BB.TGL_DAFTAR_PABEAN,'%d-%m-%Y') AS TGL_TPFT, 
					DD.NAMA AS STATUS_CONT, CC.NAMA AS STATUS, AA.TGL_STATUS
					FROM t_permit_cont AA
					INNER JOIN t_permit_hdr BB ON BB.ID=AA.ID
					LEFT JOIN reff_status_cont CC ON CC.ID=AA.KD_STATUS
					LEFT JOIN reff_relokasi DD ON DD.ID=AA.STATUS_CONT
					) X
					WHERE 1=1
					ORDER BY X.TGL_STATUS DESC
					LIMIT 0,20";
		}else{
			$SQL = "SELECT X.KD_DOK, X.ID_IJIN, X.ANGKUTNAMA, X.ANGKUTNO, X.NO_CONT, X.SAMPLE, X.NO_TPFT, X.TGL_TPFT,
					X.STATUS_CONT, X.STATUS, X.TGL_STATUS 
					FROM (
					SELECT 'SPPMP' AS KD_DOK, A.ID_IJIN, A.NO_CONT, B.ANGKUTNAMA, B.ANGKUTNO,
					CASE WHEN A.NO_TPFT IS NULL THEN 'NON SAMPEL'
						 ELSE 'SAMPEL'
					END AS SAMPLE,
					IFNULL(A.NO_TPFT,'') AS NO_TPFT, DATE_FORMAT(A.TGL_TPFT,'%d-%m-%Y') AS TGL_TPFT, 
					D.NAMA AS STATUS_CONT, C.NAMA AS STATUS, A.TGL_STATUS
					FROM t_ppk_cont A
					INNER JOIN t_ppk_hdr B ON B.ID_IJIN=A.ID_IJIN
					LEFT JOIN reff_status_cont C ON C.ID=A.KD_STATUS
					LEFT JOIN reff_relokasi D ON D.ID=A.STATUS_CONT
					UNION ALL
					SELECT 'SPJM' AS KD_DOK, AA.ID AS ID_IJIN, AA.NO_CONT, BB.NM_ANGKUT AS ANGKUTNAMA, BB.NO_VOY_FLIGHT AS ANGKUTNO,
					'NON SAMPEL' AS SAMPLE,
					IFNULL(BB.NO_DAFTAR_PABEAN,'') AS NO_TPFT, DATE_FORMAT(BB.TGL_DAFTAR_PABEAN,'%d-%m-%Y') AS TGL_TPFT, 
					DD.NAMA AS STATUS_CONT, CC.NAMA AS STATUS, AA.TGL_STATUS
					FROM t_permit_cont AA
					INNER JOIN t_permit_hdr BB ON BB.ID=AA.ID
					LEFT JOIN reff_status_cont CC ON CC.ID=AA.KD_STATUS
					LEFT JOIN reff_relokasi DD ON DD.ID=AA.STATUS_CONT
					) X
					WHERE 1=1
					AND DATE(X.TGL_STATUS) > ".$this->db->escape($DATE)."
					AND TIME(X.TGL_STATUS) > ".$this->db->escape($TIME)."
					ORDER BY X.TGL_STATUS DESC
					LIMIT 0,20";
		}
		$result = $this->db->query($SQL);
		$countData = $result->num_rows();
		$html = "";
		$UpdateID = $ID;
		$UpdateTime = $TIMESTAMP;
		$arrayData = $result->result_array();
		$result->free_result();
		$arrayDataReturn = array();
		if($countData > 0){
			$index = 0;
			foreach ($arrayData as $row){
				if ($index == 0){
					$UpdateID = $row['ID_IJIN'];
					$UpdateTime = $row['TGL_STATUS'];
				}
				$arrayDataReturn[] = array("ID"				=> $row['ID_IJIN'], 
										   "KD_DOK"			=> $row['KD_DOK'],
										   "NO_CONT"		=> $row['NO_CONT'],
										   "NO_TPFT"		=> $row['NO_TPFT'],
										   "TGL_TPFT"		=> $row['TGL_TPFT'],
										   "ANGKUTNAMA"		=> $row['ANGKUTNAMA'],
										   "ANGKUTNO"		=> $row['ANGKUTNO'],
										   "SAMPLE"			=> $row['SAMPLE'],
										   "STATUS_CONT"	=> $row['STATUS_CONT'],
										   "STATUS"			=> $row['STATUS'],
										   "TGL_STATUS"		=> $row['TGL_STATUS']);
			}
			$arrayReverse = array_reverse($arrayDataReturn);
		}
		$arrayReturn['DATA_SEND']   = $arrayReverse;
		$arrayReturn['COUNT_DATA']  = $countData;
		$arrayReturn['UPDATE_ID']   = $UpdateID;
		$arrayReturn['UPDATE_TIME'] = $UpdateTime;
		echo json_encode($arrayReturn);
	}
	
	function status_container_detail(){
		error_reporting(ALL);
		$SQL = "SELECT X.ID, KD_DOK, X.NO_TPFT, X.TGL_TPFT, X.NO_CONT, X.TGL_DISCHARGE_DESC, X.TGL_STACKING_DESC, 
				X.TGL_PERIKSA_DESC, X.TGL_TIBA_PEMERIKSA_DESC,
				X.TGL_MULAI_PERIKSA_DESC, X.TGL_SELESAI_PERIKSA_DESC, X.TGL_GATE_IN_DESC, X.TGL_GATE_OUT_DESC,
				X.ANGKUTNAMA, X.ANGKUTNO, X.WK_REKAM AS TIMESTAMP, X.STATUS_CONT, X.STATUS
				FROM (
				SELECT A.ID, 'SPPMP' AS KD_DOK, B.NO_IJIN AS NO_TPFT, 
				DATE_FORMAT(B.TGL_IJIN,'%d-%m-%Y') AS TGL_TPFT, A.NO_CONT,
				DATE_FORMAT(A.TGL_DISCHARGE,'%d-%m-%Y %H:%i:%s') AS TGL_DISCHARGE_DESC,
				DATE_FORMAT(A.TGL_STACKING,'%d-%m-%Y %H:%i:%s') AS TGL_STACKING_DESC,
				DATE_FORMAT(A.TGL_PERIKSA,'%d-%m-%Y %H:%i:%s') AS TGL_PERIKSA_DESC,
				DATE_FORMAT(A.TGL_TIBA_PEMERIKSA,'%d-%m-%Y %H:%i:%s') AS TGL_TIBA_PEMERIKSA_DESC,
				DATE_FORMAT(A.TGL_MULAI_PERIKSA,'%d-%m-%Y %H:%i:%s') AS TGL_MULAI_PERIKSA_DESC,
				DATE_FORMAT(A.TGL_SELESAI_PERIKSA,'%d-%m-%Y %H:%i:%s') AS TGL_SELESAI_PERIKSA_DESC, 
				DATE_FORMAT(A.TGL_GATE_IN,'%d-%m-%Y %H:%i:%s') AS TGL_GATE_IN_DESC, 
				DATE_FORMAT(A.TGL_GATE_OUT,'%d-%m-%Y %H:%i:%s') AS TGL_GATE_OUT_DESC,
				D.ANGKUTNAMA, D.ANGKUTNO, A.WK_REKAM, F.NAMA AS STATUS_CONT, G.NAMA AS STATUS
				FROM t_codeco A 
				INNER JOIN t_lic_hdr B ON A.ID_IJIN_PERMOHONAN = B.ID_IJIN 
				LEFT JOIN t_lic_hdr C ON A.ID_IJIN_PENYELESAIAN = C.ID_IJIN
				INNER JOIN t_ppk_hdr D ON A.ID_IJIN_PERMOHONAN = D.ID_IJIN
				INNER JOIN t_ppk_cont E ON A.ID_IJIN_PERMOHONAN = E.ID_IJIN AND A.NO_CONT = E.NO_CONT
				LEFT JOIN reff_status_cont F ON F.ID=E.KD_STATUS
				LEFT JOIN reff_relokasi G ON G.ID=E.STATUS_CONT
				UNION ALL
				SELECT A.ID, 'SPJM' AS KD_DOK, B.NO_DAFTAR_PABEAN AS NO_TPFT, 
				DATE_FORMAT(B.TGL_DAFTAR_PABEAN,'%d-%m-%Y') AS TGL_TPFT, A.NO_CONT,
				DATE_FORMAT(A.TGL_DISCHARGE,'%d-%m-%Y %H:%i:%s') AS TGL_DISCHARGE_DESC,
				DATE_FORMAT(A.TGL_STACKING,'%d-%m-%Y %H:%i:%s') AS TGL_STACKING_DESC,
				DATE_FORMAT(A.TGL_PERIKSA,'%d-%m-%Y %H:%i:%s') AS TGL_PERIKSA_DESC,
				DATE_FORMAT(A.TGL_TIBA_PEMERIKSA,'%d-%m-%Y %H:%i:%s') AS TGL_TIBA_PEMERIKSA_DESC,
				DATE_FORMAT(A.TGL_MULAI_PERIKSA,'%d-%m-%Y %H:%i:%s') AS TGL_MULAI_PERIKSA_DESC,
				DATE_FORMAT(A.TGL_SELESAI_PERIKSA,'%d-%m-%Y %H:%i:%s') AS TGL_SELESAI_PERIKSA_DESC,
				DATE_FORMAT(A.TGL_GATE_IN,'%d-%m-%Y %H:%i:%s') AS TGL_GATE_IN_DESC, 
				DATE_FORMAT(A.TGL_GATE_OUT,'%d-%m-%Y %H:%i:%s') AS TGL_GATE_OUT_DESC,
				B.NM_ANGKUT AS ANGKUTNAMA, B.NO_VOY_FLIGHT AS ANGKUTNO, A.WK_REKAM, D.NAMA AS STATUS_CONT, E.NAMA AS STATUS
				FROM t_codecopermit A
				INNER JOIN t_permit_hdr B ON B.ID = A.ID_IJIN_PERMOHONAN
				INNER JOIN t_permit_cont C ON C.ID = A.ID_IJIN_PERMOHONAN AND C.NO_CONT=A.NO_CONT
				LEFT JOIN reff_status_cont D ON D.ID=C.KD_STATUS
				LEFT JOIN reff_relokasi E ON E.ID=C.STATUS_CONT
				WHERE 1=1
				) X
				ORDER BY X.WK_REKAM DESC
				LIMIT 0,20";
		$result = $this->db->query($SQL);
		$array_data = $result->result_array();
		$result->free_result();
		return $array_data;
	}
	
	function status_container_detail_update(){
		$ID 	   = $this->input->post('ID');
		$TIMESTAMP = $this->input->post('TIMESTAMP');
		$arrdate   = explode(' ',$TIMESTAMP);
		$DATE	   = $arrdate[0];
		$TIME	   = $arrdate[1];
		$countData = 0;
		if ($TIMESTAMP == ""){
			$SQL = "SELECT X.ID, KD_DOK, X.NO_TPFT, X.TGL_TPFT, X.NO_CONT, 
					IFNULL(X.TGL_DISCHARGE_DESC,'-') AS TGL_DISCHARGE_DESC, 
					IFNULL(X.TGL_STACKING_DESC,'-') TGL_STACKING_DESC, 
					IFNULL(X.TGL_PERIKSA_DESC,'-') AS TGL_PERIKSA_DESC,
					IFNULL(X.TGL_TIBA_PEMERIKSA_DESC,'-') AS TGL_TIBA_PEMERIKSA_DESC, 
					IFNULL(X.TGL_MULAI_PERIKSA_DESC,'-') AS TGL_MULAI_PERIKSA_DESC, 
					IFNULL(X.TGL_SELESAI_PERIKSA_DESC,'-') AS TGL_SELESAI_PERIKSA_DES, 
					IFNULL(X.TGL_GATE_IN_DESC,'-') AS TGL_GATE_IN_DESC, 
					IFNULL(X.TGL_GATE_OUT_DESC,'-') AS TGL_GATE_OUT_DESC,
					X.ANGKUTNAMA, X.ANGKUTNO, X.WK_REKAM AS TIMESTAMP, X.STATUS_CONT, X.STATUS
					FROM (
					SELECT A.ID, 'SPPMP' AS KD_DOK, B.NO_IJIN AS NO_TPFT, 
					DATE_FORMAT(B.TGL_IJIN,'%d-%m-%Y') AS TGL_TPFT, A.NO_CONT,
					IFNULL(X.TGL_DISCHARGE_DESC,'') AS TGL_DISCHARGE_DESC, 
					IFNULL(X.TGL_STACKING_DESC,'') TGL_STACKING_DESC, 
					IFNULL(X.TGL_PERIKSA_DESC,'') AS TGL_PERIKSA_DESC,
					IFNULL(X.TGL_TIBA_PEMERIKSA_DESC,'') AS TGL_TIBA_PEMERIKSA_DESC, 
					IFNULL(X.TGL_MULAI_PERIKSA_DESC,'') AS TGL_MULAI_PERIKSA_DESC, 
					IFNULL(X.TGL_SELESAI_PERIKSA_DESC,'') AS TGL_SELESAI_PERIKSA_DESC, 
					IFNULL(X.TGL_GATE_IN_DESC,'') AS TGL_GATE_IN_DESC, 
					IFNULL(X.TGL_GATE_OUT_DESC,'') AS TGL_GATE_OUT_DESC,
					D.ANGKUTNAMA, D.ANGKUTNO, A.WK_REKAM, F.NAMA AS STATUS_CONT, G.NAMA AS STATUS
					FROM t_codeco A 
					INNER JOIN t_lic_hdr B ON A.ID_IJIN_PERMOHONAN = B.ID_IJIN 
					LEFT JOIN t_lic_hdr C ON A.ID_IJIN_PENYELESAIAN = C.ID_IJIN
					INNER JOIN t_ppk_hdr D ON A.ID_IJIN_PERMOHONAN = D.ID_IJIN
					INNER JOIN t_ppk_cont E ON A.ID_IJIN_PERMOHONAN = E.ID_IJIN AND A.NO_CONT = E.NO_CONT
					LEFT JOIN reff_status_cont F ON F.ID=E.KD_STATUS
					LEFT JOIN reff_relokasi G ON G.ID=E.STATUS_CONT
					UNION ALL
					SELECT A.ID, 'SPJM' AS KD_DOK, B.NO_DAFTAR_PABEAN AS NO_TPFT, 
					DATE_FORMAT(B.TGL_DAFTAR_PABEAN,'%d-%m-%Y') AS TGL_TPFT, A.NO_CONT,
					DATE_FORMAT(A.TGL_DISCHARGE,'%d-%m-%Y %H:%i:%s') AS TGL_DISCHARGE_DESC,
					DATE_FORMAT(A.TGL_STACKING,'%d-%m-%Y %H:%i:%s') AS TGL_STACKING_DESC,
					DATE_FORMAT(A.TGL_PERIKSA,'%d-%m-%Y %H:%i:%s') AS TGL_PERIKSA_DESC,
					DATE_FORMAT(A.TGL_TIBA_PEMERIKSA,'%d-%m-%Y %H:%i:%s') AS TGL_TIBA_PEMERIKSA_DESC,
					DATE_FORMAT(A.TGL_MULAI_PERIKSA,'%d-%m-%Y %H:%i:%s') AS TGL_MULAI_PERIKSA_DESC,
					DATE_FORMAT(A.TGL_SELESAI_PERIKSA,'%d-%m-%Y %H:%i:%s') AS TGL_SELESAI_PERIKSA_DESC,
					DATE_FORMAT(A.TGL_GATE_IN,'%d-%m-%Y %H:%i:%s') AS TGL_GATE_IN_DESC, 
					DATE_FORMAT(A.TGL_GATE_OUT,'%d-%m-%Y %H:%i:%s') AS TGL_GATE_OUT_DESC,
					B.NM_ANGKUT AS ANGKUTNAMA, B.NO_VOY_FLIGHT AS ANGKUTNO, A.WK_REKAM, D.NAMA AS STATUS_CONT, E.NAMA AS STATUS
					FROM t_codecopermit A
					INNER JOIN t_permit_hdr B ON B.ID = A.ID_IJIN_PERMOHONAN
					INNER JOIN t_permit_cont C ON C.ID = A.ID_IJIN_PERMOHONAN AND C.NO_CONT=A.NO_CONT
					LEFT JOIN reff_status_cont D ON D.ID=C.KD_STATUS
					LEFT JOIN reff_relokasi E ON E.ID=C.STATUS_CONT
					WHERE 1=1
					) X
					ORDER BY X.WK_REKAM DESC
					LIMIT 0,20";
		}else{
			$SQL = "SELECT X.ID, KD_DOK, X.NO_TPFT, X.TGL_TPFT, X.NO_CONT, 
					IFNULL(X.TGL_DISCHARGE_DESC,'') AS TGL_DISCHARGE_DESC, 
					IFNULL(X.TGL_STACKING_DESC,'') TGL_STACKING_DESC, 
					IFNULL(X.TGL_PERIKSA_DESC,'') AS TGL_PERIKSA_DESC,
					IFNULL(X.TGL_TIBA_PEMERIKSA_DESC,'') AS TGL_TIBA_PEMERIKSA_DESC, 
					IFNULL(X.TGL_MULAI_PERIKSA_DESC,'') AS TGL_MULAI_PERIKSA_DESC, 
					IFNULL(X.TGL_SELESAI_PERIKSA_DESC,'') AS TGL_SELESAI_PERIKSA_DESC, 
					IFNULL(X.TGL_GATE_IN_DESC,'') AS TGL_GATE_IN_DESC, 
					IFNULL(X.TGL_GATE_OUT_DESC,'') AS TGL_GATE_OUT_DESC,
					X.ANGKUTNAMA, X.ANGKUTNO, X.WK_REKAM AS TIMESTAMP, X.STATUS_CONT, X.STATUS
					FROM (
					SELECT A.ID, 'SPPMP' AS KD_DOK, B.NO_IJIN AS NO_TPFT, 
					DATE_FORMAT(B.TGL_IJIN,'%d-%m-%Y') AS TGL_TPFT, A.NO_CONT,
					DATE_FORMAT(A.TGL_DISCHARGE,'%d-%m-%Y %H:%i:%s') AS TGL_DISCHARGE_DESC,
					DATE_FORMAT(A.TGL_STACKING,'%d-%m-%Y %H:%i:%s') AS TGL_STACKING_DESC,
					DATE_FORMAT(A.TGL_PERIKSA,'%d-%m-%Y %H:%i:%s') AS TGL_PERIKSA_DESC,
					DATE_FORMAT(A.TGL_TIBA_PEMERIKSA,'%d-%m-%Y %H:%i:%s') AS TGL_TIBA_PEMERIKSA_DESC,
					DATE_FORMAT(A.TGL_MULAI_PERIKSA,'%d-%m-%Y %H:%i:%s') AS TGL_MULAI_PERIKSA_DESC,
					DATE_FORMAT(A.TGL_SELESAI_PERIKSA,'%d-%m-%Y %H:%i:%s') AS TGL_SELESAI_PERIKSA_DESC, 
					DATE_FORMAT(A.TGL_GATE_IN,'%d-%m-%Y %H:%i:%s') AS TGL_GATE_IN_DESC, 
					DATE_FORMAT(A.TGL_GATE_OUT,'%d-%m-%Y %H:%i:%s') AS TGL_GATE_OUT_DESC,
					D.ANGKUTNAMA, D.ANGKUTNO, A.WK_REKAM, F.NAMA AS STATUS_CONT, G.NAMA AS STATUS
					FROM t_codeco A 
					INNER JOIN t_lic_hdr B ON A.ID_IJIN_PERMOHONAN = B.ID_IJIN 
					LEFT JOIN t_lic_hdr C ON A.ID_IJIN_PENYELESAIAN = C.ID_IJIN
					INNER JOIN t_ppk_hdr D ON A.ID_IJIN_PERMOHONAN = D.ID_IJIN
					INNER JOIN t_ppk_cont E ON A.ID_IJIN_PERMOHONAN = E.ID_IJIN AND A.NO_CONT = E.NO_CONT
					LEFT JOIN reff_status_cont F ON F.ID=E.KD_STATUS
					LEFT JOIN reff_relokasi G ON G.ID=E.STATUS_CONT
					UNION ALL
					SELECT A.ID, 'SPJM' AS KD_DOK, B.NO_DAFTAR_PABEAN AS NO_TPFT, 
					DATE_FORMAT(B.TGL_DAFTAR_PABEAN,'%d-%m-%Y') AS TGL_TPFT, A.NO_CONT,
					DATE_FORMAT(A.TGL_DISCHARGE,'%d-%m-%Y %H:%i:%s') AS TGL_DISCHARGE_DESC,
					DATE_FORMAT(A.TGL_STACKING,'%d-%m-%Y %H:%i:%s') AS TGL_STACKING_DESC,
					DATE_FORMAT(A.TGL_PERIKSA,'%d-%m-%Y %H:%i:%s') AS TGL_PERIKSA_DESC,
					DATE_FORMAT(A.TGL_TIBA_PEMERIKSA,'%d-%m-%Y %H:%i:%s') AS TGL_TIBA_PEMERIKSA_DESC,
					DATE_FORMAT(A.TGL_MULAI_PERIKSA,'%d-%m-%Y %H:%i:%s') AS TGL_MULAI_PERIKSA_DESC,
					DATE_FORMAT(A.TGL_SELESAI_PERIKSA,'%d-%m-%Y %H:%i:%s') AS TGL_SELESAI_PERIKSA_DESC,
					DATE_FORMAT(A.TGL_GATE_IN,'%d-%m-%Y %H:%i:%s') AS TGL_GATE_IN_DESC, 
					DATE_FORMAT(A.TGL_GATE_OUT,'%d-%m-%Y %H:%i:%s') AS TGL_GATE_OUT_DESC,
					B.NM_ANGKUT AS ANGKUTNAMA, B.NO_VOY_FLIGHT AS ANGKUTNO, A.WK_REKAM, D.NAMA AS STATUS_CONT, E.NAMA AS STATUS
					FROM t_codecopermit A
					INNER JOIN t_permit_hdr B ON B.ID = A.ID_IJIN_PERMOHONAN
					INNER JOIN t_permit_cont C ON C.ID = A.ID_IJIN_PERMOHONAN AND C.NO_CONT=A.NO_CONT
					LEFT JOIN reff_status_cont D ON D.ID=C.KD_STATUS
					LEFT JOIN reff_relokasi E ON E.ID=C.STATUS_CONT
					WHERE 1=1
					) X
					WHERE 1=1
					AND DATE(X.WK_REKAM) > ".$this->db->escape($DATE)."
					AND TIME(X.WK_REKAM) > ".$this->db->escape($TIME)."
					ORDER BY X.WK_REKAM DESC
					LIMIT 0,20";
		}
		$result = $this->db->query($SQL);
		$countData = $result->num_rows();
		$html = "";
		$UpdateID = $ID;
		$UpdateTime = $TIMESTAMP;
		$arrayData = $result->result_array();
		$result->free_result();
		$arrayDataReturn = array();
		if($countData > 0){
			$index = 0;
			foreach ($arrayData as $row){
				if ($index == 0){
					$UpdateID = $row['ID_IJIN'];
					$UpdateTime = $row['TGL_STATUS'];
				}
				$arrayDataReturn[] = array("ID"				=> $row['ID_IJIN'], 
										   "KD_DOK"			=> $row['KD_DOK'],
										   "NO_CONT"		=> $row['NO_CONT'],
										   "NO_TPFT"		=> $row['NO_TPFT'],
										   "TGL_TPFT"		=> $row['TGL_TPFT'],
										   "ANGKUTNAMA"		=> $row['ANGKUTNAMA'],
										   "ANGKUTNO"		=> $row['ANGKUTNO'],
										   "STATUS_CONT"	=> $row['STATUS_CONT'],
										   "DISCHARGE"		=> $row['TGL_DISCHARGE_DESC'],
										   "STACKING"		=> $row['TGL_STACKING_DESC'],
										   "GATEOUT"		=> $row['TGL_GATE_OUT_DESC'],
										   "GATEIN"			=> $row['TGL_GATE_IN_DESC'],
										   "RELEASE"		=> $row['TGL_SELESAI_PERIKSA_DESC'],
										   "STATUS"			=> $row['STATUS']);
			}
			$arrayReverse = array_reverse($arrayDataReturn);
		}
		$arrayReturn['DATA_SEND']   = $arrayReverse;
		$arrayReturn['COUNT_DATA']  = $countData;
		$arrayReturn['UPDATE_ID']   = $UpdateID;
		$arrayReturn['UPDATE_TIME'] = $UpdateTime;
		echo json_encode($arrayReturn);
	}
}