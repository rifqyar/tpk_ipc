<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class M_home extends CI_Model {

	public function __construct(){
		parent::__construct();
	}

	function execute($type, $act){
		$func = get_instance();
        $func->load->model("m_main", "main", true);
		$success = 0;
		$error = 0;
		$message = "";
		$USERLOGIN = $this->session->userdata('USERLOGIN');
		if($type=="update"){
			if($act=="password"){
				foreach($this->input->post('DATA') as $a => $b){
					if($b=="") $DATA[$a] = NULL;
					else $DATA[$a] = $b;
				}

				$query = "SELECT A.ID AS USERID
						  FROM reff_user A
						  WHERE A.USER_NAME = ".$this->db->escape($USERLOGIN)." AND A.PASS = ".$this->db->escape(md5($DATA['PASS_OLD']));

				$data = $this->db->query($query);
				if($data->num_rows() > 0){
					$rs = $data->row();
					if($DATA['PASS_NEW']==$DATA['PASS_CONFIRM']){
						$ARRDATA['PASS'] = md5($DATA['PASS_NEW']);
						$ARRDATA['WK_REKAM'] = date('Y-m-d H:i:s');
						$this->db->where(array('ID' => $rs->USERID));
						$exec = $this->db->update('reff_user', $ARRDATA);
						if($exec){
							//$this->last_login($rs->USERID);
							$datses['LOGGED'] = true;
							$this->session->set_userdata($datses);
							$func->main->get_log('update','app_user');
							$message = "1|Data berhasil diproses|".base_url().'application.php';
						}
					}else{
						$error += 1;
						$message .= "0|Data gagal diproses, Konfirmasi password tidak sesuai";
					}
				}else{
					$error += 1;
					$message .= "0|Data gagal diproses, Password lama tidak sesuai";
				}
				$arrayReturn['returnData']= $message;
				echo json_encode($arrayReturn);
			}
		}
	}
	
	function get_data($act,$id,$remark){
		// echo $act.'--'.$id.'--'.$remark;
		// echo "<br>";
		// var_dump($act);
		// echo "<br>";
		// var_dump($id);
		// echo "<br>";
		// var_dump($remark);
		// die();
		$func = get_instance();
        $func->load->model("m_main", "main", true);
		if($act=="dashboard"){
			if ($id != '') {
				$SQL = "SELECT B.NO_CONT AS 'NO_KONTAINER',B.UKR_CONT AS 'SIZE',A.NO_SPK AS 'NO_SPK',A.WK_REQ,H.WK_ACTIVE,A.NM_KAPAL AS 'VESSEL_NAME',A.NO_VOY AS 'VOYAGE',D.KETERANGAN AS 'JOB',C.LOKASI_AWAL AS 'LOKASI_AWAL',C.LOKASI_AKHIR AS 'LOKASI_AKHIR',C.JENIS AS 'REMARK',F.NAMA AS 'DOKUMEN',E.START_INSP,I.CONSIGNEE,B.ID_FLAT AS 'TID',CASE WHEN G.JNS_CONT = 'F' THEN 'FL' ELSE 'MT' END AS 'JNS_CONT'
					FROM t_spk A
					INNER JOIN t_spk_cont B ON A.ID = B.ID
					LEFT JOIN t_job_slip C ON A.NO_SPK = C.NO_SPK AND B.NO_CONT = C.NO_CONT AND C.`STATUS`='WAITING'
					LEFT JOIN reff_status_spk D ON B.STATUS_CONT=D.ID
					LEFT JOIN t_op_inspection E ON A.NO_SPK = E.NO_SPK AND B.NO_CONT = E.NO_CONT
					LEFT JOIN reff_kode_dok_bc F ON A.JNS_DOK = F.ID
					LEFT JOIN t_cocostscont G ON B.NO_CONT = G.NO_CONT
					LEFT JOIN t_gatepass H ON A.NO_DOK = H.NO_DOK
					LEFT JOIN t_request I ON A.NO_DOK = I.NO_DOK AND A.TGL_DOK = I.TGL_DOK
					WHERE B.STATUS_CONT IN($id) AND B.STATUS_CONT != '450' 
					GROUP BY B.NO_CONT
					ORDER BY A.WK_REQ ASC";
					//echo $SQL;
			} else if($remark != ''){
				$SQL = "SELECT B.NO_CONT AS 'NO_KONTAINER',B.UKR_CONT AS 'SIZE',A.NO_SPK AS 'NO_SPK',A.WK_REQ,H.WK_ACTIVE,A.NM_KAPAL AS 'VESSEL_NAME',A.NO_VOY AS 'VOYAGE',D.KETERANGAN AS 'JOB',C.LOKASI_AWAL AS 'LOKASI_AWAL',C.LOKASI_AKHIR AS 'LOKASI_AKHIR',C.JENIS AS 'REMARK',F.NAMA AS 'DOKUMEN',E.START_INSP,I.CONSIGNEE,B.ID_FLAT AS 'TID',CASE WHEN G.JNS_CONT = 'F' THEN 'FL' ELSE 'MT' END AS 'JNS_CONT'
					FROM t_spk A
					LEFT JOIN t_spk_cont B ON A.ID = B.ID
					LEFT JOIN t_job_slip C ON A.NO_SPK = C.NO_SPK AND B.NO_CONT = C.NO_CONT AND C.`STATUS`='WAITING'
					LEFT JOIN reff_status_spk D ON B.STATUS_CONT=D.ID
					LEFT JOIN t_op_inspection E ON A.NO_SPK = E.NO_SPK AND B.NO_CONT = E.NO_CONT
					LEFT JOIN reff_kode_dok_bc F ON A.JNS_DOK = F.ID
					LEFT JOIN t_cocostscont G ON B.NO_CONT = G.NO_CONT
					LEFT JOIN t_gatepass H ON A.NO_DOK = H.NO_DOK
					LEFT JOIN t_request I ON A.NO_DOK = I.NO_DOK AND A.TGL_DOK = I.TGL_DOK
					WHERE C.JENIS IN($remark) 
					AND C.STATUS = 'WAITING' AND B.STATUS_CONT != '450'
					GROUP BY B.NO_CONT
					ORDER BY A.WK_REQ ASC";
			}else {
				/*$SQL = "SELECT B.NO_CONT AS 'NO_KONTAINER',B.UKR_CONT AS 'SIZE',A.NO_SPK AS 'NO_SPK',A.WK_REQ,H.WK_ACTIVE,A.NM_KAPAL AS 'VESSEL_NAME',A.NO_VOY AS 'VOYAGE',D.KETERANGAN AS 'JOB',C.LOKASI_AWAL AS 'LOKASI_AWAL',C.LOKASI_AKHIR AS 'LOKASI_AKHIR',C.JENIS AS 'REMARK',F.NAMA AS 'DOKUMEN',E.START_INSP,A.CONSIGNEE,B.ID_FLAT AS 'TID',CASE WHEN G.JNS_CONT = 'F' THEN 'FL' ELSE 'MT' END AS 'JNS_CONT'
					FROM t_spk A
					INNER JOIN t_spk_cont B ON A.ID = B.ID
					INNER JOIN t_job_slip C ON A.NO_SPK = C.NO_SPK AND B.NO_CONT = C.NO_CONT AND C.`STATUS`='WAITING'
					LEFT JOIN reff_status_spk D ON B.STATUS_CONT=D.ID
					LEFT JOIN t_op_inspection E ON A.NO_SPK = E.NO_SPK AND B.NO_CONT = E.NO_CONT
					LEFT JOIN reff_kode_dok_bc F ON E.JNS_DOK = F.ID
					LEFT JOIN t_cocostscont G ON B.NO_CONT = G.NO_CONT
					LEFT JOIN t_gatepass H ON A.NO_DOK = H.NO_DOK
					WHERE B.STATUS_CONT != '450' AND B.STATUS_CONT !='460' AND B.STATUS_CONT != '500' 
					GROUP BY B.NO_CONT
					ORDER BY A.WK_REQ DESC";*/
				$SQL = "SELECT B.NO_CONT AS 'NO_KONTAINER',K.TIPE_CONT as 'TYPE',B.UKR_CONT AS 'SIZE',A.NO_SPK AS 'NO_SPK',A.WK_REQ,H.WK_ACTIVE,J.NM_ANGKUT AS 'VESSEL_NAME', CASE WHEN G.JNS_CONT = 'F' THEN 'FL' ELSE 'MT' END AS 'JNS_CONT',J.NO_VOY_FLIGHT AS 'VOYAGE',D.KETERANGAN AS 'JOB',C.LOKASI_AWAL AS 'LOKASI_AWAL',C.LOKASI_AKHIR AS 'LOKASI_AKHIR',C.JENIS AS 'REMARK',F.NAMA AS 'DOKUMEN',E.START_INSP,I.CONSIGNEE,B.ID_FLAT AS 'TID',C.WK_STATUS
				FROM t_spk A
				INNER JOIN t_spk_cont B ON A.ID = B.ID
				INNER JOIN t_job_slip C ON A.NO_SPK = C.NO_SPK AND B.NO_CONT = C.NO_CONT -- AND C.`STATUS`='WAITING'
				LEFT JOIN reff_status_spk D ON B.STATUS_CONT=D.ID
				LEFT JOIN t_op_inspection E ON A.NO_SPK = E.NO_SPK AND B.NO_CONT = E.NO_CONT
				LEFT JOIN reff_kode_dok_bc F ON A.JNS_DOK = F.ID
				LEFT JOIN t_cocostscont G ON B.NO_CONT = G.NO_CONT
				LEFT JOIN t_cocostshdr J ON G.ID = J.ID
				LEFT JOIN t_gatepass H ON A.NO_DOK = H.NO_DOK
				LEFT JOIN t_request I ON A.NO_DOK = I.NO_DOK AND A.TGL_DOK = I.TGL_DOK
				JOIN t_request_cont K ON I.ID = K.ID AND K.NO_CONT = B.NO_CONT
				WHERE B.STATUS_CONT IN('000','100','200','510','530','520','540','460','800','850') AND B.STATUS_CONT != '450' AND SUBSTR(A.NO_SPK,1,3) = 'MTI'
				GROUP BY B.NO_CONT
				ORDER BY A.WK_REQ ASC";
			}
			
			//echo $SQL;
			
			$execute = $this->db->query($SQL);
			return $execute->result();
		}elseif($act=="dashboardNew"){
			$arrid = explode("'",$id);
			if ($id != '') {
				$arrid = explode("'",$id);
				if($arrid[1] == '510'){
					$active = "AND H.FL_ACTIVE = 'Y'";
				}else {
					$active = "";
				}

				if ($arrid[1] == '510') {
					/*$SQL = "SELECT B.NO_CONT AS 'NO_KONTAINER',B.UKR_CONT AS 'SIZE',A.NO_SPK AS 'NO_SPK',A.WK_REQ,H.WK_ACTIVE,A.NM_KAPAL AS 'VESSEL_NAME',CASE WHEN G.JNS_CONT = 'F' THEN 'FL' ELSE 'MT' END AS 'JNS_CONT',A.NO_VOY AS 'VOYAGE',D.KETERANGAN AS 'JOB',CONCAT(C.LOKASI_AWAL,'0',C.TIER_AWAL) 'LOKASI_AWAL',C.LOKASI_AKHIR AS 'LOKASI_AKHIR',C.JENIS AS 'REMARK',F.NAMA AS 'DOKUMEN',E.START_INSP,A.CONSIGNEE,B.ID_FLAT AS 'TID'
					FROM t_spk A
					INNER JOIN t_spk_cont B ON A.ID = B.ID
					INNER JOIN t_job_slip C ON A.NO_SPK = C.NO_SPK AND B.NO_CONT = C.NO_CONT AND C.`STATUS`='WAITING'
					LEFT JOIN reff_status_spk D ON B.STATUS_CONT=D.ID
					LEFT JOIN t_op_inspection E ON A.NO_SPK = E.NO_SPK AND B.NO_CONT = E.NO_CONT
					LEFT JOIN reff_kode_dok_bc F ON A.JNS_DOK = F.ID
					LEFT JOIN t_cocostscont G ON B.NO_CONT = G.NO_CONT
					LEFT JOIN t_gatepass H ON A.NO_DOK = H.NO_DOK
					WHERE B.STATUS_CONT IN($arrid[1]) AND B.STATUS_CONT != '450' AND H.FL_ACTIVE = 'Y'
					GROUP BY B.NO_CONT
					ORDER BY C.WK_STATUS ASC";*/
					$SQL = "SELECT A.NO_CONT AS 'NO_KONTAINER',B.NO_VOY AS 'VOYAGE',A.UKR_CONT AS 'SIZE',B.NO_SPK AS 'NO_SPK',B.WK_REQ,C.WK_ACTIVE,B.NM_KAPAL AS 'VESSEL_NAME',
							'FL' AS 'JNS_CONT',E.KETERANGAN AS 'JOB',A.ID_FLAT AS 'TID', CONCAT(H.LOKASI_AWAL,'0',H.TIER_AWAL) AS 'LOKASI_AWAL',H.JENIS AS 'REMARK',
							G.NAMA AS 'DOKUMEN',I.START_INSP,D.CONSIGNEE,A.ID_FLAT AS 'TID'
							FROM t_spk_cont A
							LEFT JOIN t_spk B ON A.ID = B.ID
							LEFT JOIN t_gatepass C ON A.NO_CONT = C.NO_CONT AND C.`STATUS` = 'WAITING' -- AND C.FL_ACTIVE = 'Y'
							INNER JOIN t_request D ON C.NO_DOK = D.NO_DOK AND A.TGL_DOK = D.TGL_DOK
							LEFT JOIN reff_status_spk E ON A.STATUS_CONT = E.ID
							LEFT JOIN t_op_inspection F ON F.NO_CONT = A.NO_CONT AND F.FINISH_INSP IS NULL
							LEFT JOIN reff_kode_dok_bc G ON D.JNS_DOK = G.ID
							INNER JOIN t_job_slip H ON B.NO_SPK = H.NO_SPK AND A.NO_CONT = H.NO_CONT AND H.`STATUS`='WAITING'
							LEFT JOIN t_op_inspection I ON B.NO_SPK = I.NO_SPK AND A.NO_CONT = I.NO_CONT
							WHERE A.STATUS_CONT IN('510') AND C.FL_ACTIVE = 'Y'
							GROUP BY A.NO_CONT
							ORDER BY CASE WHEN F.START_INSP IS NOT NULL AND F.FINISH_INSP IS NULL THEN 2 WHEN A.STATUS_CONT = '460' THEN 3 WHEN A.STATUS_CONT IN ('500','540','520') THEN 4 WHEN C.FL_ACTIVE = 'Y' THEN 1 ELSE 0 END ASC,C.WK_ACTIVE ASC";
				}elseif ($arrid[1] == '460') {
					$SQL = "SELECT H.JNS_KEGIATAN,B.NO_CONT AS 'NO_KONTAINER',B.UKR_CONT AS 'SIZE',A.NO_SPK AS 'NO_SPK',A.WK_REQ,H.WK_ACTIVE,J.NM_ANGKUT AS 'VESSEL_NAME', CASE WHEN G.JNS_CONT = 'F' THEN 'FL' ELSE 'MT' END AS 'JNS_CONT',J.NO_VOY_FLIGHT AS 'VOYAGE',D.KETERANGAN AS 'JOB', CONCAT(C.LOKASI_AWAL,'0',C.TIER_AWAL) 'LOKASI_AWAL',C.LOKASI_AKHIR AS 'LOKASI_AKHIR',C.JENIS AS 'REMARK',F.NAMA AS 'DOKUMEN',E.START_INSP,I.CONSIGNEE,B.ID_FLAT AS 'TID', H.ID, C.ID_JOB_SLIP
							FROM t_spk A
							INNER JOIN t_spk_cont B ON A.ID = B.ID
							INNER JOIN reff_status_spk D ON B.STATUS_CONT=D.ID
							INNER JOIN t_op_inspection E ON A.NO_SPK = E.NO_SPK AND B.NO_CONT = E.NO_CONT AND E.`STATUS` = 'WAITING'
							INNER JOIN t_cocostscont G ON B.NO_CONT = G.NO_CONT
							INNER JOIN t_cocostshdr J ON G.ID = J.ID
							INNER JOIN t_gatepass H ON B.NO_CONT = H.NO_CONT -- AND H.JNS_KEGIATAN = 2
							INNER JOIN t_request I ON H.NO_DOK = I.NO_DOK AND A.TGL_DOK = I.TGL_DOK
							INNER JOIN reff_kode_dok_bc F ON I.JNS_DOK = F.ID
							INNER JOIN t_job_slip C ON A.NO_SPK = C.NO_SPK AND B.NO_CONT = C.NO_CONT AND C.LOKASI_AWAL IS NOT NULL AND H.`STATUS` = 'WAITING' 
							AND H.ID = C.NO_GATEPASS
							WHERE B.STATUS_CONT IN(460) AND B.STATUS_CONT != '450' AND E.START_INSP IS NOT NULL 
							AND H.JNS_KEGIATAN IS NOT NULL AND E.FINISH_INSP IS NULL
							GROUP BY B.NO_CONT
							ORDER BY E.START_INSP ASC";
				}elseif ($arrid[1] == '530') {
					$SQL = "SELECT B.NO_CONT AS 'NO_KONTAINER',B.UKR_CONT AS 'SIZE',A.NO_SPK AS 'NO_SPK',A.WK_REQ,H.WK_ACTIVE,J.NM_ANGKUT AS 'VESSEL_NAME', CASE WHEN G.JNS_CONT = 'F' THEN 'FL' ELSE 'MT' END AS 'JNS_CONT',J.NO_VOY_FLIGHT AS 'VOYAGE',D.KETERANGAN AS 'JOB', CONCAT(C.LOKASI_AWAL,'0',C.TIER_AWAL) 'LOKASI_AWAL',C.LOKASI_AKHIR AS 'LOKASI_AKHIR',C.JENIS AS 'REMARK',F.NAMA AS 'DOKUMEN',E.START_INSP,I.CONSIGNEE,B.ID_FLAT AS 'TID', H.ID
							FROM t_spk A
							LEFT JOIN t_spk_cont B ON A.ID = B.ID
							LEFT JOIN t_job_slip C ON A.NO_SPK = C.NO_SPK AND B.NO_CONT = C.NO_CONT AND C.`STATUS`='WAITING'
							LEFT JOIN reff_status_spk D ON B.STATUS_CONT=D.ID
							LEFT JOIN t_op_inspection E ON A.NO_SPK = E.NO_SPK AND B.NO_CONT = E.NO_CONT
							LEFT JOIN reff_kode_dok_bc F ON A.JNS_DOK = F.ID
							LEFT JOIN t_cocostscont G ON B.NO_CONT = G.NO_CONT
							LEFT JOIN t_cocostshdr J ON G.ID = J.ID
							LEFT JOIN t_gatepass H ON B.NO_CONT = H.NO_CONT AND H.JNS_KEGIATAN = 2 AND H.`STATUS` = 'WAITING'
							LEFT JOIN t_request I ON A.NO_DOK = I.NO_DOK AND A.TGL_DOK = I.TGL_DOK
							WHERE B.STATUS_CONT IN($arrid[1]) AND B.STATUS_CONT != '450' AND H.FL_ACTIVE = 'Y' 
							GROUP BY B.NO_CONT
							ORDER BY A.WK_REQ ASC";
				}elseif ($arrid[1] == '540') {
					$SQL = "SELECT B.NO_CONT AS 'NO_KONTAINER',B.UKR_CONT AS 'SIZE',A.NO_SPK AS 'NO_SPK',A.WK_REQ,H.WK_ACTIVE,J.NM_ANGKUT AS 'VESSEL_NAME', CASE WHEN G.JNS_CONT = 'F' THEN 'FL' ELSE 'MT' END AS 'JNS_CONT',J.NO_VOY_FLIGHT AS 'VOYAGE',D.KETERANGAN AS 'JOB',C.LOKASI_AWAL AS 'LOKASI_AWAL',C.LOKASI_AKHIR AS 'LOKASI_AKHIR',D.KETERANGAN AS 'REMARK',F.NAMA AS 'DOKUMEN',E.START_INSP,I.CONSIGNEE,B.ID_FLAT AS 'TID',C.WK_STATUS
							FROM t_spk A
							INNER JOIN t_spk_cont B ON A.ID = B.ID
							LEFT JOIN reff_status_spk D ON B.STATUS_CONT=D.ID
							LEFT JOIN t_op_inspection E ON A.NO_SPK = E.NO_SPK AND B.NO_CONT = E.NO_CONT
							LEFT JOIN t_cocostscont G ON B.NO_CONT = G.NO_CONT
							LEFT JOIN t_cocostshdr J ON G.ID = J.ID
							LEFT JOIN t_gatepass H ON B.NO_CONT = H.NO_CONT
							INNER JOIN t_request I ON H.NO_DOK = I.NO_DOK AND A.TGL_DOK = I.TGL_DOK
							LEFT JOIN reff_kode_dok_bc F ON I.JNS_DOK = F.ID
							INNER JOIN t_job_slip C ON A.NO_SPK = C.NO_SPK AND B.NO_CONT = C.NO_CONT AND H.ID = C.NO_GATEPASS -- AND C.`STATUS`='WAITING'
							WHERE B.STATUS_CONT IN('540') AND B.STATUS_CONT != '450' AND C.`STATUS` = 'WAITING'
							GROUP BY B.NO_CONT
							ORDER BY A.WK_REQ ASC";
				}elseif ($arrid[1] == '520') {
					$SQL = "SELECT C.ID_JOB_SLIP,B.NO_CONT AS 'NO_KONTAINER',B.UKR_CONT AS 'SIZE',A.NO_SPK AS 'NO_SPK',A.WK_REQ,H.WK_ACTIVE,J.NM_ANGKUT AS 'VESSEL_NAME', CASE WHEN G.JNS_CONT = 'F' THEN 'FL' ELSE 'MT' END AS 'JNS_CONT',J.NO_VOY_FLIGHT AS 'VOYAGE',D.KETERANGAN AS 'JOB',C.LOKASI_AWAL AS 'LOKASI_AWAL',C.LOKASI_AKHIR AS 'LOKASI_AKHIR',C.JENIS AS 'REMARK',F.NAMA AS 'DOKUMEN',E.START_INSP,I.CONSIGNEE,B.ID_FLAT AS 'TID',C.WK_STATUS
							FROM t_spk A
							INNER JOIN t_spk_cont B ON A.ID = B.ID
							INNER JOIN t_job_slip C ON A.NO_SPK = C.NO_SPK AND B.NO_CONT = C.NO_CONT -- AND C.`STATUS`='WAITING'
							LEFT JOIN reff_status_spk D ON B.STATUS_CONT=D.ID
							LEFT JOIN t_op_inspection E ON A.NO_SPK = E.NO_SPK AND B.NO_CONT = E.NO_CONT
							LEFT JOIN reff_kode_dok_bc F ON A.JNS_DOK = F.ID
							LEFT JOIN t_cocostscont G ON B.NO_CONT = G.NO_CONT
							LEFT JOIN t_cocostshdr J ON G.ID = J.ID
							LEFT JOIN t_gatepass H ON A.NO_DOK = H.NO_DOK
							LEFT JOIN t_request I ON A.NO_DOK = I.NO_DOK AND A.TGL_DOK = I.TGL_DOK
							WHERE B.STATUS_CONT IN('520') AND B.STATUS_CONT != '450' AND C.JENIS = 'EX BEHANDLE 1'
							GROUP BY B.NO_CONT
							ORDER BY A.WK_REQ ASC";
				}elseif($arrid[1] == '800'){
					$SQL = "SELECT B.NO_CONT AS 'NO_KONTAINER',B.UKR_CONT AS 'SIZE',A.NO_SPK AS 'NO_SPK',A.WK_REQ,H.WK_ACTIVE,J.NM_ANGKUT AS 'VESSEL_NAME', CASE WHEN G.JNS_CONT = 'F' THEN 'FL' ELSE 'MT' END AS 'JNS_CONT',J.NO_VOY_FLIGHT AS 'VOYAGE',D.KETERANGAN AS 'JOB',C.LOKASI_AWAL AS 'LOKASI_AWAL',C.LOKASI_AKHIR AS 'LOKASI_AKHIR',C.JENIS AS 'REMARK',F.NAMA AS 'DOKUMEN',E.WK_TRUCKIN,E.WK_CHASSIS,I.CONSIGNEE,B.ID_FLAT AS 'TID',C.WK_STATUS
							FROM t_spk A
							INNER JOIN t_spk_cont B ON A.ID = B.ID
							INNER JOIN t_job_slip C ON A.NO_SPK = C.NO_SPK AND B.NO_CONT = C.NO_CONT -- AND C.`STATUS`='WAITING'
							LEFT JOIN reff_status_spk D ON B.STATUS_CONT=D.ID
							LEFT JOIN t_op_delivery E ON A.NO_SPK = E.NO_SPK AND B.NO_CONT = E.NO_CONT
							LEFT JOIN reff_kode_dok_bc F ON A.JNS_DOK = F.ID
							LEFT JOIN t_cocostscont G ON B.NO_CONT = G.NO_CONT
							LEFT JOIN t_cocostshdr J ON G.ID = J.ID
							LEFT JOIN t_gatepass H ON A.NO_DOK = H.NO_DOK
							LEFT JOIN t_request I ON A.NO_DOK = I.NO_DOK AND A.TGL_DOK = I.TGL_DOK
							WHERE B.STATUS_CONT IN(800) AND B.STATUS_CONT != '450'
							GROUP BY B.NO_CONT
							ORDER BY A.WK_REQ ASC";
				}elseif($arrid[1] == '850'){
					$SQL = "SELECT B.NO_CONT AS 'NO_KONTAINER',B.UKR_CONT AS 'SIZE',A.NO_SPK AS 'NO_SPK',A.WK_REQ,H.WK_ACTIVE,J.NM_ANGKUT AS 'VESSEL_NAME', CASE WHEN G.JNS_CONT = 'F' THEN 'FL' ELSE 'MT' END AS 'JNS_CONT',J.NO_VOY_FLIGHT AS 'VOYAGE',D.KETERANGAN AS 'JOB',C.LOKASI_AWAL AS 'LOKASI_AWAL',C.LOKASI_AKHIR AS 'LOKASI_AKHIR',C.JENIS AS 'REMARK',F.NAMA AS 'DOKUMEN',E.WK_TRUCKIN,E.WK_CHASSIS,I.CONSIGNEE,B.ID_FLAT AS 'TID',C.WK_STATUS
							FROM t_spk A
							INNER JOIN t_spk_cont B ON A.ID = B.ID
							INNER JOIN t_job_slip C ON A.NO_SPK = C.NO_SPK AND B.NO_CONT = C.NO_CONT -- AND C.`STATUS`='WAITING'
							LEFT JOIN reff_status_spk D ON B.STATUS_CONT=D.ID
							LEFT JOIN t_op_delivery E ON A.NO_SPK = E.NO_SPK AND B.NO_CONT = E.NO_CONT
							LEFT JOIN reff_kode_dok_bc F ON A.JNS_DOK = F.ID
							LEFT JOIN t_cocostscont G ON B.NO_CONT = G.NO_CONT
							LEFT JOIN t_cocostshdr J ON G.ID = J.ID
							LEFT JOIN t_gatepass H ON A.NO_DOK = H.NO_DOK
							LEFT JOIN t_request I ON A.NO_DOK = I.NO_DOK AND A.TGL_DOK = I.TGL_DOK
							WHERE B.STATUS_CONT IN(800,850,870) AND B.STATUS_CONT != '450'
							GROUP BY B.NO_CONT
							ORDER BY A.WK_REQ ASC";
				}elseif($arrid[1] == '200'){
					$SQL = "SELECT B.NO_CONT AS 'NO_KONTAINER',G.KD_CONT_TIPE as 'TYPE',B.UKR_CONT AS 'SIZE',A.NO_SPK AS 'NO_SPK',A.WK_REQ,H.WK_ACTIVE,J.NM_ANGKUT AS 'VESSEL_NAME', CASE WHEN G.JNS_CONT = 'F' THEN 'FL' ELSE 'MT' END AS 'JNS_CONT',J.NO_VOY_FLIGHT AS 'VOYAGE',D.KETERANGAN AS 'JOB',C.LOKASI_AWAL AS 'LOKASI_AWAL',C.LOKASI_AKHIR AS 'LOKASI_AKHIR',C.JENIS AS 'REMARK',F.NAMA AS 'DOKUMEN',I.CONSIGNEE,B.ID_FLAT AS 'TID',C.WK_STATUS, E.WK_PICKUP
							FROM t_spk A
							INNER JOIN t_spk_cont B ON A.ID = B.ID
							INNER JOIN t_job_slip C ON A.NO_SPK = C.NO_SPK AND B.NO_CONT = C.NO_CONT -- AND C.`STATUS`='WAITING'
							LEFT JOIN reff_status_spk D ON B.STATUS_CONT=D.ID
							LEFT JOIN t_operation E ON A.NO_SPK = E.NO_SPK AND B.NO_CONT = E.NO_CONT
							LEFT JOIN reff_kode_dok_bc F ON A.JNS_DOK = F.ID
							LEFT JOIN t_cocostscont G ON B.NO_CONT = G.NO_CONT
							LEFT JOIN t_cocostshdr J ON G.ID = J.ID
							LEFT JOIN t_gatepass H ON A.NO_DOK = H.NO_DOK
							LEFT JOIN t_request I ON A.NO_DOK = I.NO_DOK AND A.TGL_DOK = I.TGL_DOK
							WHERE B.STATUS_CONT IN('200') AND B.STATUS_CONT != '450'
							GROUP BY B.NO_CONT
							ORDER BY A.WK_REQ ASC";
				}elseif($arrid[1] == '860'){
					// echo "860";
					// die();
					$SQL = "SELECT B.NO_CONT AS 'NO_KONTAINER',G.KD_CONT_TIPE as 'TYPE',B.UKR_CONT AS 'SIZE',A.NO_SPK AS 'NO_SPK',A.WK_REQ,H.WK_ACTIVE,J.NM_ANGKUT AS 'VESSEL_NAME', CASE WHEN G.JNS_CONT = 'F' THEN 'FL' ELSE 'MT' END AS 'JNS_CONT',J.NO_VOY_FLIGHT AS 'VOYAGE',D.KETERANGAN AS 'JOB',C.LOKASI_AWAL AS 'LOKASI_AWAL',C.LOKASI_AKHIR AS 'LOKASI_AKHIR',C.JENIS AS 'REMARK',F.NAMA AS 'DOKUMEN',E.START_INSP,I.CONSIGNEE,B.ID_FLAT AS 'TID',C.WK_STATUS
					FROM t_spk A
					INNER JOIN t_spk_cont B ON A.ID = B.ID
					INNER JOIN t_job_slip C ON A.NO_SPK = C.NO_SPK AND B.NO_CONT = C.NO_CONT -- AND C.`STATUS`='WAITING'
					LEFT JOIN reff_status_spk D ON B.STATUS_CONT=D.ID
					LEFT JOIN t_op_inspection E ON A.NO_SPK = E.NO_SPK AND B.NO_CONT = E.NO_CONT
					LEFT JOIN reff_kode_dok_bc F ON A.JNS_DOK = F.ID
					LEFT JOIN t_cocostscont G ON B.NO_CONT = G.NO_CONT
					LEFT JOIN t_cocostshdr J ON G.ID = J.ID
					LEFT JOIN t_gatepass H ON A.NO_DOK = H.NO_DOK
					LEFT JOIN t_request I ON A.NO_DOK = I.NO_DOK AND A.TGL_DOK = I.TGL_DOK
					WHERE B.STATUS_CONT IN('000','100','200','510','530','520','540','460','800','850') AND B.STATUS_CONT != '450' AND SUBSTR(A.NO_SPK,1,3) = 'MTI' AND G.KD_CONT_TIPE = 'DRY'
					GROUP BY B.NO_CONT
					ORDER BY A.WK_REQ ASC";
				}elseif($arrid[1] == '861'){
					// echo "861";
					// die();
					$SQL = "SELECT B.NO_CONT AS 'NO_KONTAINER',G.KD_CONT_TIPE as 'TYPE',B.UKR_CONT AS 'SIZE',A.NO_SPK AS 'NO_SPK',A.WK_REQ,H.WK_ACTIVE,J.NM_ANGKUT AS 'VESSEL_NAME', CASE WHEN G.JNS_CONT = 'F' THEN 'FL' ELSE 'MT' END AS 'JNS_CONT',J.NO_VOY_FLIGHT AS 'VOYAGE',D.KETERANGAN AS 'JOB',C.LOKASI_AWAL AS 'LOKASI_AWAL',C.LOKASI_AKHIR AS 'LOKASI_AKHIR',C.JENIS AS 'REMARK',F.NAMA AS 'DOKUMEN',E.START_INSP,I.CONSIGNEE,B.ID_FLAT AS 'TID',C.WK_STATUS
					FROM t_spk A
					INNER JOIN t_spk_cont B ON A.ID = B.ID
					INNER JOIN t_job_slip C ON A.NO_SPK = C.NO_SPK AND B.NO_CONT = C.NO_CONT -- AND C.`STATUS`='WAITING'
					LEFT JOIN reff_status_spk D ON B.STATUS_CONT=D.ID
					LEFT JOIN t_op_inspection E ON A.NO_SPK = E.NO_SPK AND B.NO_CONT = E.NO_CONT
					LEFT JOIN reff_kode_dok_bc F ON A.JNS_DOK = F.ID
					LEFT JOIN t_cocostscont G ON B.NO_CONT = G.NO_CONT
					LEFT JOIN t_cocostshdr J ON G.ID = J.ID
					LEFT JOIN t_gatepass H ON A.NO_DOK = H.NO_DOK
					LEFT JOIN t_request I ON A.NO_DOK = I.NO_DOK AND A.TGL_DOK = I.TGL_DOK
					WHERE B.STATUS_CONT IN('000','100','200','510','530','520','540','460','800','850') AND B.STATUS_CONT != '450' AND SUBSTR(A.NO_SPK,1,3) = 'MTI' AND G.KD_CONT_TIPE != 'DRY'
					GROUP BY B.NO_CONT
					ORDER BY A.WK_REQ ASC";
				}elseif($arrid[1] == 'GIT') {
					echo 'On Proses'; die();
				}else {
				// 	echo "else dari di";
				// die();
					$SQL = "SELECT B.NO_CONT AS 'NO_KONTAINER',G.KD_CONT_TIPE as 'TYPE',B.UKR_CONT AS 'SIZE',A.NO_SPK AS 'NO_SPK',A.WK_REQ,H.WK_ACTIVE,J.NM_ANGKUT AS 'VESSEL_NAME',CASE WHEN G.JNS_CONT = 'F' THEN 'FL' ELSE 'MT' END AS 'JNS_CONT',J.NO_VOY_FLIGHT AS 'VOYAGE',D.KETERANGAN AS 'JOB',C.LOKASI_AWAL AS 'LOKASI_AWAL',C.LOKASI_AKHIR AS 'LOKASI_AKHIR',C.JENIS AS 'REMARK',F.NAMA AS 'DOKUMEN',E.START_INSP,I.CONSIGNEE,B.ID_FLAT AS 'TID',C.WK_STATUS
							FROM t_spk A
							INNER JOIN t_spk_cont B ON A.ID = B.ID
							INNER JOIN t_job_slip C ON A.NO_SPK = C.NO_SPK AND B.NO_CONT = C.NO_CONT -- AND C.`STATUS`='WAITING'
							LEFT JOIN reff_status_spk D ON B.STATUS_CONT=D.ID
							LEFT JOIN t_op_inspection E ON A.NO_SPK = E.NO_SPK AND B.NO_CONT = E.NO_CONT
							LEFT JOIN reff_kode_dok_bc F ON A.JNS_DOK = F.ID
							LEFT JOIN t_cocostscont G ON B.NO_CONT = G.NO_CONT
							LEFT JOIN t_cocostshdr J ON G.ID = J.ID
							LEFT JOIN t_gatepass H ON A.NO_DOK = H.NO_DOK
							LEFT JOIN t_request I ON A.NO_DOK = I.NO_DOK AND A.TGL_DOK = I.TGL_DOK
							WHERE B.STATUS_CONT IN($id) AND B.STATUS_CONT != '450'
							GROUP BY B.NO_CONT
							ORDER BY A.WK_REQ ASC";
							// print_r($SQL);
				}
			} else if($remark != ''){
				// echo "remark kosong";
				// die();
				$SQL = "SELECT B.NO_CONT AS 'NO_KONTAINER',B.UKR_CONT AS 'SIZE',A.NO_SPK AS 'NO_SPK',A.WK_REQ,H.WK_ACTIVE,A.NM_KAPAL AS 'VESSEL_NAME',CASE WHEN G.JNS_CONT = 'F' THEN 'FL' ELSE 'MT' END AS 'JNS_CONT',A.NO_VOY AS 'VOYAGE',D.KETERANGAN AS 'JOB',C.LOKASI_AWAL AS 'LOKASI_AWAL',C.LOKASI_AKHIR AS 'LOKASI_AKHIR',C.JENIS AS 'REMARK',F.NAMA AS 'DOKUMEN',E.START_INSP,I.CONSIGNEE,B.ID_FLAT AS 'TID'
					FROM t_spk A
					LEFT JOIN t_spk_cont B ON A.ID = B.ID
					LEFT JOIN t_job_slip C ON A.NO_SPK = C.NO_SPK AND B.NO_CONT = C.NO_CONT AND C.`STATUS`='WAITING'
					LEFT JOIN reff_status_spk D ON B.STATUS_CONT=D.ID
					LEFT JOIN t_op_inspection E ON A.NO_SPK = E.NO_SPK AND B.NO_CONT = E.NO_CONT
					LEFT JOIN reff_kode_dok_bc F ON A.JNS_DOK = F.ID
					LEFT JOIN t_cocostscont G ON B.NO_CONT = G.NO_CONT
					LEFT JOIN t_gatepass H ON A.NO_DOK = H.NO_DOK
					LEFT JOIN t_request I ON A.NO_DOK = I.NO_DOK
					WHERE C.JENIS IN($remark) 
					AND C.STATUS = 'WAITING' AND B.STATUS_CONT != '450'
					GROUP BY B.NO_CONT
					ORDER BY A.WK_REQ ASC";
			}else {
				$SQL = "SELECT B.NO_CONT AS 'NO_KONTAINER',G.KD_CONT_TIPE as 'TYPE',B.UKR_CONT AS 'SIZE',A.NO_SPK AS 'NO_SPK',A.WK_REQ,H.WK_ACTIVE,J.NM_ANGKUT AS 'VESSEL_NAME', CASE WHEN G.JNS_CONT = 'F' THEN 'FL' ELSE 'MT' END AS 'JNS_CONT',J.NO_VOY_FLIGHT AS 'VOYAGE',D.KETERANGAN AS 'JOB',C.LOKASI_AWAL AS 'LOKASI_AWAL',C.LOKASI_AKHIR AS 'LOKASI_AKHIR',C.JENIS AS 'REMARK',F.NAMA AS 'DOKUMEN',E.START_INSP,I.CONSIGNEE,B.ID_FLAT AS 'TID',C.WK_STATUS
				FROM t_spk A
				INNER JOIN t_spk_cont B ON A.ID = B.ID
				INNER JOIN t_job_slip C ON A.NO_SPK = C.NO_SPK AND B.NO_CONT = C.NO_CONT -- AND C.`STATUS`='WAITING'
				LEFT JOIN reff_status_spk D ON B.STATUS_CONT=D.ID
				LEFT JOIN t_op_inspection E ON A.NO_SPK = E.NO_SPK AND B.NO_CONT = E.NO_CONT
				LEFT JOIN reff_kode_dok_bc F ON A.JNS_DOK = F.ID
				LEFT JOIN t_cocostscont G ON B.NO_CONT = G.NO_CONT
				LEFT JOIN t_cocostshdr J ON G.ID = J.ID
				LEFT JOIN t_gatepass H ON A.NO_DOK = H.NO_DOK
				LEFT JOIN t_request I ON A.NO_DOK = I.NO_DOK AND A.TGL_DOK = I.TGL_DOK
				WHERE B.STATUS_CONT IN('000','100','200','510','530','520','540','460','800','850') AND B.STATUS_CONT != '450' AND SUBSTR(A.NO_SPK,1,3) = 'MTI'
				GROUP BY B.NO_CONT
				ORDER BY A.WK_REQ ASC";
			}
			
			//echo $SQL;
			$resultdtl = $func->main->get_result($SQL);
			if($resultdtl){
				$no = 0;
				$table = '<table class="" cellspacing="0" width="100%" id="myTable" border="0"  style="border:2px">';
				$table .= "<tr style='text-align:center'>
							<th style='text-align:center;'>NO</th>
							<th style='text-align:center;'>KONTAINER</th>
							<th style='text-align:center;'>TYPE</th>
							<th style='text-align:center;'>SPK</th>
							<th style='text-align:center;'>CLS</th>
							<th style='text-align:center;'>VESSEL</th>
							<th style='text-align:center;'>VOY</th>
							<th style='text-align:center;'>STAT</th>
							<th style='text-align:center;'>SIZE</th>
							<th style='text-align:center;'>DOKUMEN</th>
							<th style='text-align:center;'>JOB</th>
							<th style='text-align:center;'>TID</th>
							<th style='text-align:center;'>LOKASI AWAL</th>
							<th style='text-align:center;'>LOKASI AKHIR</th>
							<th style='text-align:center;'>WAKTU</th>
							<th style='text-align:center;'>DURASI</th>
							<th style='text-align:center;'>CUSTOMER</th>
							<th style='text-align:center;'>REMARK</th>
						</tr>";
				foreach($SQL->result_array() as $dtl){
					$no++;
					if ($no%2==1) {
						$class="style='background-color:#FFFFFF;line-height: 20px;'";
					}else{
						$class="style='background-color: #f1f1ff;line-height: 20px;'";
					}
					if($arrid[1] == '000'){
						$WK = $dtl['WK_REQ'];
						if($WK != ""){
							$tgl1 = $WK;
							$tgl2 = date("Y-m-d H:i:s");
							$a = $this->datediff($tgl1, $tgl2);
							
							if(strlen($a['days']) == 1){
									$day = "0".$a['days'];
							}else{
								$day = $a['days'];
							}
							
							if(strlen($a['hours']) == 1){
								$hours = "0".$a['hours'];
							}else{
								$hours = $a['hours'];
							}
							
							if(strlen($a['minutes']) == 1){
								$minutes = "0".$a['minutes'];
							}else{
								$minutes = $a['minutes'];
							}
							
							$result = $day.':'.$hours.':'.$minutes;
							$waktu = date('d-m-Y H:i',strtotime($WK));
						}
					}elseif($arrid[1] == '460'){
						$WK_INS = $dtl['START_INSP'];
						if($WK_INS != ""){
							$tgl1 = $WK_INS;
							$tgl2 = date("Y-m-d H:i:s");
							$a = $this->datediff($tgl1, $tgl2);
							
							if(strlen($a['days']) == 1){
									$day = "0".$a['days'];
							}else{
								$day = $a['days'];
							}
							
							if(strlen($a['hours']) == 1){
								$hours = "0".$a['hours'];
							}else{
								$hours = $a['hours'];
							}
							
							if(strlen($a['minutes']) == 1){
								$minutes = "0".$a['minutes'];
							}else{
								$minutes = $a['minutes'];
							}
							
							$result = $day.':'.$hours.':'.$minutes;
							$waktu = date('d-m-Y H:i',strtotime($WK_INS));
						}
					}elseif($arrid[1] == '510'){
						$WK = $dtl['WK_ACTIVE'];
						if($WK != ""){
							$tgl1 = $WK;
							$tgl2 = date("Y-m-d H:i:s");
							$a = $this->datediff($tgl1, $tgl2);
							
							if(strlen($a['days']) == 1){
									$day = "0".$a['days'];
							}else{
								$day = $a['days'];
							}
							
							if(strlen($a['hours']) == 1){
								$hours = "0".$a['hours'];
							}else{
								$hours = $a['hours'];
							}
							
							if(strlen($a['minutes']) == 1){
								$minutes = "0".$a['minutes'];
							}else{
								$minutes = $a['minutes'];
							}
							
							$result = $day.':'.$hours.':'.$minutes;
							$waktu = date('d-m-Y H:i',strtotime($WK));
						}
					}elseif($arrid[1] == '520'){
						$WK = $dtl['WK_STATUS'];
						if($WK != ""){
							$tgl1 = $WK;
							$tgl2 = date("Y-m-d H:i:s");
							$a = $this->datediff($tgl1, $tgl2);
							
							if(strlen($a['days']) == 1){
									$day = "0".$a['days'];
							}else{
								$day = $a['days'];
							}
							
							if(strlen($a['hours']) == 1){
								$hours = "0".$a['hours'];
							}else{
								$hours = $a['hours'];
							}
							
							if(strlen($a['minutes']) == 1){
								$minutes = "0".$a['minutes'];
							}else{
								$minutes = $a['minutes'];
							}
							
							$result = $day.':'.$hours.':'.$minutes;
							$waktu = date('d-m-Y H:i',strtotime($WK));
						}
					}elseif($arrid[1] == '530'){
						$WK = $dtl['WK_ACTIVE'];
						if($WK != ""){
							$tgl1 = $WK;
							$tgl2 = date("Y-m-d H:i:s");
							$a = $this->datediff($tgl1, $tgl2);
							
							if(strlen($a['days']) == 1){
									$day = "0".$a['days'];
							}else{
								$day = $a['days'];
							}
							
							if(strlen($a['hours']) == 1){
								$hours = "0".$a['hours'];
							}else{
								$hours = $a['hours'];
							}
							
							if(strlen($a['minutes']) == 1){
								$minutes = "0".$a['minutes'];
							}else{
								$minutes = $a['minutes'];
							}
							
							$result = $day.':'.$hours.':'.$minutes;
							$waktu = date('d-m-Y H:i',strtotime($WK));
						}
					}elseif($arrid[1] == '540'){
						$WK = $dtl['WK_STATUS'];
						if($WK != ""){
							$tgl1 = $WK;
							$tgl2 = date("Y-m-d H:i:s");
							$a = $this->datediff($tgl1, $tgl2);
							
							if(strlen($a['days']) == 1){
									$day = "0".$a['days'];
							}else{
								$day = $a['days'];
							}
							
							if(strlen($a['hours']) == 1){
								$hours = "0".$a['hours'];
							}else{
								$hours = $a['hours'];
							}
							
							if(strlen($a['minutes']) == 1){
								$minutes = "0".$a['minutes'];
							}else{
								$minutes = $a['minutes'];
							}
							
							$result = $day.':'.$hours.':'.$minutes;
							$waktu = date('d-m-Y H:i',strtotime($WK));
						}
					}elseif($arrid[1] == '800' || $arrid[1] == '850' || $arrid[1] == '870'){
						if($arrid[1] == '800'){
							$WK = $dtl['WK_TRUCKIN'];
						} else{
							$WK = $dtl['WK_CHASSIS'];
						}
						
						if($WK != ""){
							$tgl1 = $WK;
							$tgl2 = date("Y-m-d H:i:s");
							$a = $this->datediff($tgl1, $tgl2);
							
							if(strlen($a['days']) == 1){
									$day = "0".$a['days'];
							}else{
								$day = $a['days'];
							}
							
							if(strlen($a['hours']) == 1){
								$hours = "0".$a['hours'];
							}else{
								$hours = $a['hours'];
							}
							
							if(strlen($a['minutes']) == 1){
								$minutes = "0".$a['minutes'];
							}else{
								$minutes = $a['minutes'];
							}
							
							$result = $day.':'.$hours.':'.$minutes;
							$waktu = date('d-m-Y H:i',strtotime($WK));
						}
					}elseif($arrid[1] == '200'){
						$WK = $dtl['WK_PICKUP'];
						if($WK != ""){
							$tgl1 = $WK;
							$tgl2 = date("Y-m-d H:i:s");
							$a = $this->datediff($tgl1, $tgl2);
							
							if(strlen($a['days']) == 1){
									$day = "0".$a['days'];
							}else{
								$day = $a['days'];
							}
							
							if(strlen($a['hours']) == 1){
								$hours = "0".$a['hours'];
							}else{
								$hours = $a['hours'];
							}
							
							if(strlen($a['minutes']) == 1){
								$minutes = "0".$a['minutes'];
							}else{
								$minutes = $a['minutes'];
							}
							
							$result = $day.':'.$hours.':'.$minutes;
							$waktu = date('d-m-Y H:i',strtotime($WK));
						}
					}
		
					$table .= "<tr $class>";
					$table .= "
								<td style='font-size: 10px;text-align:center;'>$no</td>
								<td style='font-size: 10px;text-align:center;'>$dtl[NO_KONTAINER]</td>
								<td style='font-size: 10px;text-align:center;'>$dtl[TYPE]</td>
								<td style='font-size: 10px;text-align:center;'>$dtl[NO_SPK]</td>
								<td style='font-size: 10px;text-align:center;'>I</td>
								<td style='font-size: 10px;text-align:center;'>$dtl[VESSEL_NAME]</td>
								<td style='font-size: 10px;text-align:center;'>$dtl[VOYAGE]</td>
								<td style='font-size: 10px;text-align:center;'>$dtl[JNS_CONT]</td>
								<td style='font-size: 10px;text-align:center;'>$dtl[SIZE]</td>
								<td style='font-size: 10px;text-align:center;'>$dtl[DOKUMEN]</td>
								<td style='font-size: 10px;text-align:center;'>$dtl[JOB]</td>
								<td style='font-size: 10px;text-align:center;'>$dtl[TID]</td>
								<td style='font-size: 10px;text-align:center;'>$dtl[LOKASI_AWAL]</td>
								<td style='font-size: 10px;text-align:center;'>$dtl[LOKASI_AKHIR]</td>
								<td style='font-size: 10px;text-align:center;'>
									$waktu
								</td>
								<td style='font-size: 10px;text-align:center;'>$result</td>
								<td style='font-size: 10px;text-align:center;'>$dtl[CONSIGNEE]</td>
								<td style='font-size: 10px;text-align:center;' width='100px'>$dtl[REMARK]</td>
							";
					$table .= "</tr>";
				}
				$table .= "</table>";
				return $table;
			}		
		}
	}
	
	function datediff($tgl1, $tgl2){
		$tgl1 = strtotime($tgl1);
		$tgl2 = strtotime($tgl2);
		$diff_secs = abs($tgl1 - $tgl2);
		$base_year = min(date("Y", $tgl1), date("Y", $tgl2));
		$diff = mktime(0, 0, $diff_secs, 1, 1, $base_year);
		return array( "years" => date("Y", $diff) - $base_year, "months_total" => (date("Y", $diff) - $base_year) * 12 + date("n", $diff) - 1, "months" => date("n", $diff) - 1, "days_total" => floor($diff_secs / (3600 * 24)), "days" => date("j", $diff) - 1, "hours_total" => floor($diff_secs / 3600), "hours" => date("G", $diff), "minutes_total" => floor($diff_secs / 60), "minutes" => (int) date("i", $diff), "seconds_total" => $diff_secs, "seconds" => (int) date("s", $diff) );
	}

	function data($number,$offset){
		$SQL = "SELECT B.NO_CONT AS 'NO_KONTAINER',B.UKR_CONT AS 'SIZE',A.NO_SPK AS 'NO_SPK',A.NM_KAPAL AS 'VESSEL_NAME',A.NO_VOY AS 'VOYAGE',D.KETERANGAN AS 'JOB',C.LOKASI_AWAL AS 'LOKASI_AWAL',C.LOKASI_AKHIR AS 'LOKASI_AKHIR',C.JENIS AS 'REMARK',F.NAMA AS 'DOKUMEN',E.START_INSP
					FROM t_spk A
					INNER JOIN t_spk_cont B ON A.ID = B.ID
					INNER JOIN t_job_slip C ON A.NO_SPK = C.NO_SPK AND B.NO_CONT = C.NO_CONT AND C.`STATUS`='WAITING'
					LEFT JOIN reff_status_spk D ON B.STATUS_CONT=D.ID
					LEFT JOIN t_op_inspection E ON A.NO_SPK = E.NO_SPK AND B.NO_CONT = E.NO_CONT
					LEFT JOIN reff_kode_dok_bc F ON E.JNS_DOK = F.ID";
		$execute = $this->db->query($SQL,$number,$offset);
		return $execute->result();	
	}
 
	function jumlah_data(){
		return $this->db->query("SELECT B.NO_CONT AS 'NO_KONTAINER',B.UKR_CONT AS 'SIZE',A.NO_SPK AS 'NO_SPK',A.NM_KAPAL AS 'VESSEL_NAME',A.NO_VOY AS 'VOYAGE',D.KETERANGAN AS 'JOB',C.LOKASI_AWAL AS 'LOKASI_AWAL',C.LOKASI_AKHIR AS 'LOKASI_AKHIR',C.JENIS AS 'REMARK',F.NAMA AS 'DOKUMEN',E.START_INSP
					FROM t_spk A
					INNER JOIN t_spk_cont B ON A.ID = B.ID
					INNER JOIN t_job_slip C ON A.NO_SPK = C.NO_SPK AND B.NO_CONT = C.NO_CONT AND C.`STATUS`='WAITING'
					LEFT JOIN reff_status_spk D ON B.STATUS_CONT=D.ID
					LEFT JOIN t_op_inspection E ON A.NO_SPK = E.NO_SPK AND B.NO_CONT = E.NO_CONT
					LEFT JOIN reff_kode_dok_bc F ON E.JNS_DOK = F.ID")->num_rows();
	}

	function last_login($ID){
		$data = array('LAST_LOGIN' => date('Y-m-d H:i:s'));
		$this->db->where('ID', $ID);
		$this->db->update('reff_user', $data);
	}
}
?>