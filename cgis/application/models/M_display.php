<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

class M_display extends CI_Model
{

	public $variable;

	public function __construct()
	{
		parent::__construct();
	}

	function list_statusreefer($act, $id)
	{
		$func = get_instance();
		$func->load->model("m_main", "main", true);
		$search = $this->input->get('search');
		if ($search == "" or $search == NULL) {
			$SQL = "SELECT B.no_spk AS NO_SPK, A.no_cont AS KONTAINER, A.ukr_cont AS SIZE, A.tipe_cont AS TYPE, (CASE WHEN e.START_INSP IS NOT NULL AND e.FINISH_INSP IS NULL THEN 'SEDANG PERIKSA' WHEN e.finish_insp IS NOT NULL THEN 'SELESAI PERIKSA' ELSE 'BELUM PERIKSA' END) AS STATUS, e.finish_insp AS WAKTU_SELESAI,
						B.status_cont

						FROM (
							SELECT a.id, a.no_dok, a.tgl_dok, b.NO_CONT, b.UKR_CONT, b.tipe_cont
							FROM t_request a
							JOIN t_request_cont b ON a.id = b.id
							WHERE b.TIPE_CONT = 'RFR' OR b.FL_REEFER = 'Y') A
						JOIN (
							SELECT c.no_spk, c.no_dok, c.tgl_dok, d.status_cont, d.NO_CONT
							FROM t_spk c
							JOIN t_spk_cont d ON c.id = d.id) B ON A.no_dok = B.no_dok AND A.tgl_dok = B. tgl_dok AND A.no_cont = B.no_cont
						LEFT JOIN t_op_inspection e ON e.no_dok=a.NO_DOK AND e.tgl_dok=a.TGL_DOK AND e.no_cont=b.NO_CONT
						WHERE B.status_cont NOT IN (900,950)
						ORDER BY status asc";
		} else {
			$SQL = "SELECT B.no_spk AS NO_SPK, A.no_cont AS KONTAINER, A.ukr_cont AS SIZE, A.tipe_cont AS TYPE, (CASE WHEN e.START_INSP IS NOT NULL AND e.FINISH_INSP IS NULL THEN 'SEDANG PERIKSA' WHEN e.finish_insp IS NOT NULL THEN 'SELESAI PERIKSA' ELSE 'BELUM PERIKSA' END) AS STATUS, e.finish_insp AS WAKTU_SELESAI,
						B.status_cont

						FROM (
							SELECT a.id, a.no_dok, a.tgl_dok, b.NO_CONT, b.UKR_CONT, b.tipe_cont
							FROM t_request a
							JOIN t_request_cont b ON a.id = b.id
							WHERE b.TIPE_CONT = 'RFR' OR b.FL_REEFER = 'Y') A
						JOIN (
							SELECT c.no_spk, c.no_dok, c.tgl_dok, d.status_cont, d.NO_CONT
							FROM t_spk c
							JOIN t_spk_cont d ON c.id = d.id) B ON A.no_dok = B.no_dok AND A.tgl_dok = B. tgl_dok AND A.no_cont = B.no_cont
						LEFT JOIN t_op_inspection e ON e.no_dok=a.NO_DOK AND e.tgl_dok=a.TGL_DOK AND e.no_cont=b.NO_CONT
						WHERE B.status_cont NOT IN (900,950) and B.no_spk like UPPER('%$search%') or A.no_cont like UPPER('%$search%')
						ORDER BY status asc";
		}
		//echo $SQL;
		//die();and A.NO_DOK like UPPER('%$search%') or B.NO_CONT like UPPER('%$search%')
		$QUERY = $this->db->query($SQL);
		return $QUERY->result();
	}

	function get_data($act, $id)
	{
		$func = get_instance();
		$func->load->model("m_main", "main", true);
		if ($act == 'custom') {

			$search = $this->input->get('search');
			//echo $search;
			//die();
			//echo var_dump($search);
			if ($search == "" or $search == NULL) {
				// $SQL = "SELECT distinct * FROM (SELECT k.no_antrian,a.NO_CONT,a.UKR_CONT,a.TGL_DOK,a.JNS_DOK,a.`STATUS`,a.NO_DOK,b.LOKASI,a.JNS_KEGIATAN,a.NAMA_CUST,b.STATUS_CONT,d.START_INSP,d.FINISH_INSP,a.RESPON,a.WK_RESPON,
				// 	CASE
				// 				WHEN b.STATUS_CONT IN (450,510,530) AND d.START_INSP IS NULL AND d.FINISH_INSP IS NULL AND a.RESPON IS NULL THEN 3
				// 				WHEN b.STATUS_CONT IN (450,510,530) AND d.START_INSP IS NULL AND d.FINISH_INSP IS NULL AND a.RESPON IS NOT NULL THEN 2
				// 				WHEN b.STATUS_CONT = 460 AND d.START_INSP IS NULL AND d.FINISH_INSP IS NULL  AND a.RESPON IS NOT NULL THEN 1
				// 				WHEN b.STATUS_CONT = 460 AND d.START_INSP IS NOT NULL AND d.FINISH_INSP IS NULL THEN 4
				// 				WHEN b.STATUS_CONT IN (500,540,520) THEN 6 
				// 				ELSE 5 
				// 			END AS STATUS2,s.NOTE,t.tipe_cont AS tipe_cont 
				// 	FROM t_gatepass a
				// 	left JOIN (SELECT * FROM t_spk_cont WHERE STATUS_CONT != 900) b on a.NO_CONT = b.NO_CONT 
				// 	JOIN t_spk c ON c.ID = b.ID
				// 	LEFT JOIN t_op_inspection d ON a.NO_CONT = d.NO_CONT AND a.NO_DOK = d.NO_DOK and a.JNS_KEGIATAN = d.JNS_KEGIATAN 
				// 	LEFT JOIN (select * from t_antrian_respon_ppk where reset = 'N') k ON a.ID = k.id_gatepass
				// 	LEFT JOIN t_job_slip s ON c.NO_SPK = s.NO_SPK AND a.NO_CONT = s.NO_CONT AND s.JENIS = CONCAT('BEHANDLE ',a.JNS_KEGIATAN)
				// 	LEFT JOIN (SELECT a.id, a.no_dok, a.tgl_dok, b.NO_CONT, b.UKR_CONT, b.tipe_cont
				// 		FROM t_request a
				// 		JOIN t_request_cont b ON a.id = b.id ) t ON c.NO_DOK = t.no_dok AND t.no_cont = a.no_cont
				// 	WHERE  a.JNS_KEGIATAN  != 3 AND a.`STATUS` = 'WAITING'  AND a.JNS_DOK != 'SPPMP') az
				// 	ORDER BY STATUS2,WK_RESPON";
				$SQL = "SELECT *
									FROM (
											/* ===========================
												DATA EXISTING (GATEPASS)
												=========================== */
											SELECT
													k.no_antrian,
													a.NO_CONT,
													a.UKR_CONT,
													a.TGL_DOK,
													a.JNS_DOK,
													a.`STATUS`,
													a.NO_DOK,
													b.LOKASI,
													a.JNS_KEGIATAN,
													a.NAMA_CUST,
													b.STATUS_CONT,
													d.START_INSP,
													d.FINISH_INSP,
													a.RESPON,
													a.WK_RESPON,
													CASE
															WHEN b.STATUS_CONT IN (450,510,530)
																	AND d.START_INSP IS NULL
																	AND d.FINISH_INSP IS NULL
																	AND a.RESPON IS NULL THEN 3
															WHEN b.STATUS_CONT IN (450,510,530)
																	AND d.START_INSP IS NULL
																	AND d.FINISH_INSP IS NULL
																	AND a.RESPON IS NOT NULL THEN 2
															WHEN b.STATUS_CONT = 460
																	AND d.START_INSP IS NULL
																	AND d.FINISH_INSP IS NULL
																	AND a.RESPON IS NOT NULL THEN 1
															WHEN b.STATUS_CONT = 460
																	AND d.START_INSP IS NOT NULL
																	AND d.FINISH_INSP IS NULL THEN 4
															WHEN b.STATUS_CONT IN (500,540,520) THEN 6
															ELSE 5
													END AS STATUS2,
													s.NOTE,
													t.tipe_cont
											FROM t_gatepass a
											LEFT JOIN (
													SELECT *
													FROM t_spk_cont
													WHERE STATUS_CONT != 900
											) b ON a.NO_CONT = b.NO_CONT
											JOIN t_spk c ON c.ID = b.ID
											LEFT JOIN t_op_inspection d
													ON a.NO_CONT = d.NO_CONT
													AND a.NO_DOK = d.NO_DOK
													AND a.JNS_KEGIATAN = d.JNS_KEGIATAN
											LEFT JOIN (
													SELECT *
													FROM t_antrian_respon_ppk
													WHERE reset = 'N'
											) k ON a.ID = k.id_gatepass
											LEFT JOIN t_job_slip s
													ON c.NO_SPK = s.NO_SPK
													AND a.NO_CONT = s.NO_CONT
													AND s.JENIS = CONCAT('BEHANDLE ', a.JNS_KEGIATAN)
											LEFT JOIN (
													SELECT
															a.id,
															a.no_dok,
															a.tgl_dok,
															b.NO_CONT,
															b.UKR_CONT,
															b.tipe_cont
													FROM t_request a
													JOIN t_request_cont b
															ON a.id = b.id
											) t
													ON c.NO_DOK = t.no_dok
													AND t.no_cont = a.no_cont
											WHERE a.JNS_KEGIATAN != 3
												AND a.`STATUS` = 'WAITING'
												AND a.JNS_DOK != 'SPPMP'
											UNION ALL
											SELECT
													NULL AS no_antrian,
													r.NO_CONT,
													r.CONT_SIZE as UKR_CONT,
													r.TGL_DOK as TGL_DOK,
													REPLACE(r.TYPE_DOK, 'SPJ', 'SPJM') as JNS_DOK,
													'BELUM_SPK' AS STATUS,
													r.NO_DOK,
													'NPCT' AS LOKASI,
													NULL AS JNS_KEGIATAN,
													r.PPJK AS NAMA_CUST,
													NULL AS STATUS_CONT,
													NULL AS START_INSP,
													NULL AS FINISH_INSP,
													NULL AS RESPON,
													NULL AS WK_RESPON,
													7 AS STATUS2,
													'BELUM REQUEST' AS NOTE,
													t.tipe_cont
											FROM t_rekon_dokumen_npct1 r
											LEFT JOIN (
													SELECT
															a.id,
															a.no_dok,
															a.tgl_dok,
															b.NO_CONT,
															b.UKR_CONT,
															b.tipe_cont
													FROM t_request a
													JOIN t_request_cont b
															ON a.id = b.id
											) t
												ON r.NO_DOK = t.no_dok
													AND t.no_cont = r.no_cont
											WHERE DATE(r.`TIMESTAMP`) >= '2026-06-18'
											and r.TYPE_DOK = 'SPJ'
											and r.PERIKSA = 'Y'
											and NOT EXISTS (
													SELECT 1
													FROM t_spk tr
													JOIN t_spk_cont trc
															ON tr.ID = trc.ID
													WHERE tr.NO_DOK = r.NO_DOK
														AND trc.NO_CONT = r.NO_CONT
											)
									) az
									ORDER BY az.STATUS2, az.WK_RESPON";
			} else {
				// $SQL = "SELECT * FROM (SELECT k.no_antrian,a.NO_CONT,a.UKR_CONT,a.TGL_DOK,a.JNS_DOK,a.`STATUS`,a.NO_DOK,b.LOKASI,a.JNS_KEGIATAN,a.NAMA_CUST,b.STATUS_CONT,d.START_INSP,d.FINISH_INSP,a.RESPON,a.WK_RESPON,
				// 	CASE
				// 				WHEN b.STATUS_CONT IN (450,510,530) AND d.START_INSP IS NULL AND d.FINISH_INSP IS NULL AND a.RESPON IS NULL THEN 3
				// 				WHEN b.STATUS_CONT IN (450,510,530) AND d.START_INSP IS NULL AND d.FINISH_INSP IS NULL AND a.RESPON IS NOT NULL THEN 2
				// 				WHEN b.STATUS_CONT = 460 AND d.START_INSP IS NULL AND d.FINISH_INSP IS NULL  AND a.RESPON IS NOT NULL THEN 1
				// 				WHEN b.STATUS_CONT = 460 AND d.START_INSP IS NOT NULL AND d.FINISH_INSP IS NULL THEN 4
				// 				WHEN b.STATUS_CONT IN (500,540,520) THEN 6 
				// 				ELSE 5 
				// 			END AS STATUS2,s.NOTE, t.tipe_cont AS tipe_cont 
				// 	FROM t_gatepass a
				// 	left JOIN (SELECT * FROM t_spk_cont WHERE STATUS_CONT != 900) b on a.NO_CONT = b.NO_CONT 
				// 	JOIN t_spk c ON c.ID = b.ID
				// 	LEFT JOIN t_op_inspection d ON a.NO_CONT = d.NO_CONT AND a.NO_DOK = d.NO_DOK and a.JNS_KEGIATAN = d.JNS_KEGIATAN 
				// 	LEFT JOIN (select * from t_antrian_respon_ppk where reset = 'N') k ON a.ID = k.id_gatepass
				// 	LEFT JOIN t_job_slip s ON c.NO_SPK = s.NO_SPK AND a.NO_CONT = s.NO_CONT AND s.JENIS = CONCAT('BEHANDLE ',a.JNS_KEGIATAN)
				// 	LEFT JOIN (SELECT a.id, a.no_dok, a.tgl_dok, b.NO_CONT, b.UKR_CONT, b.tipe_cont
				// 		FROM t_request a
				// 		JOIN t_request_cont b ON a.id = b.id ) t ON c.NO_DOK = t.no_dok AND t.no_cont = a.no_cont
				// 	WHERE  a.JNS_KEGIATAN  != 3 AND a.`STATUS` = 'WAITING'  AND a.JNS_DOK != 'SPPMP') az
				// 	where NO_DOK like UPPER('%$search%') or NO_CONT like UPPER('%$search%')
				// 	ORDER BY STATUS2,WK_RESPON";
				$SQL = "SELECT *
									FROM (
											/* ===========================
												DATA EXISTING (GATEPASS)
												=========================== */
											SELECT
													k.no_antrian,
													a.NO_CONT,
													a.UKR_CONT,
													a.TGL_DOK,
													a.JNS_DOK,
													a.`STATUS`,
													a.NO_DOK,
													b.LOKASI,
													a.JNS_KEGIATAN,
													a.NAMA_CUST,
													b.STATUS_CONT,
													d.START_INSP,
													d.FINISH_INSP,
													a.RESPON,
													a.WK_RESPON,
													CASE
															WHEN b.STATUS_CONT IN (450,510,530)
																	AND d.START_INSP IS NULL
																	AND d.FINISH_INSP IS NULL
																	AND a.RESPON IS NULL THEN 3
															WHEN b.STATUS_CONT IN (450,510,530)
																	AND d.START_INSP IS NULL
																	AND d.FINISH_INSP IS NULL
																	AND a.RESPON IS NOT NULL THEN 2
															WHEN b.STATUS_CONT = 460
																	AND d.START_INSP IS NULL
																	AND d.FINISH_INSP IS NULL
																	AND a.RESPON IS NOT NULL THEN 1
															WHEN b.STATUS_CONT = 460
																	AND d.START_INSP IS NOT NULL
																	AND d.FINISH_INSP IS NULL THEN 4
															WHEN b.STATUS_CONT IN (500,540,520) THEN 6
															ELSE 5
													END AS STATUS2,
													s.NOTE,
													t.tipe_cont
											FROM t_gatepass a
											LEFT JOIN (
													SELECT *
													FROM t_spk_cont
													WHERE STATUS_CONT != 900
											) b ON a.NO_CONT = b.NO_CONT
											JOIN t_spk c ON c.ID = b.ID
											LEFT JOIN t_op_inspection d
													ON a.NO_CONT = d.NO_CONT
													AND a.NO_DOK = d.NO_DOK
													AND a.JNS_KEGIATAN = d.JNS_KEGIATAN
											LEFT JOIN (
													SELECT *
													FROM t_antrian_respon_ppk
													WHERE reset = 'N'
											) k ON a.ID = k.id_gatepass
											LEFT JOIN t_job_slip s
													ON c.NO_SPK = s.NO_SPK
													AND a.NO_CONT = s.NO_CONT
													AND s.JENIS = CONCAT('BEHANDLE ', a.JNS_KEGIATAN)
											LEFT JOIN (
													SELECT
															a.id,
															a.no_dok,
															a.tgl_dok,
															b.NO_CONT,
															b.UKR_CONT,
															b.tipe_cont
													FROM t_request a
													JOIN t_request_cont b
															ON a.id = b.id
											) t
													ON c.NO_DOK = t.no_dok
													AND t.no_cont = a.no_cont
											WHERE a.JNS_KEGIATAN != 3
												AND a.`STATUS` = 'WAITING'
												AND a.JNS_DOK != 'SPPMP'
											UNION ALL
											SELECT
													NULL AS no_antrian,
													r.NO_CONT,
													r.CONT_SIZE as UKR_CONT,
													r.TGL_DOK as TGL_DOK,
													REPLACE(r.TYPE_DOK, 'SPJ', 'SPJM') as JNS_DOK,
													'BELUM_SPK' AS STATUS,
													r.NO_DOK,
													'NPCT' AS LOKASI,
													NULL AS JNS_KEGIATAN,
													r.PPJK AS NAMA_CUST,
													NULL AS STATUS_CONT,
													NULL AS START_INSP,
													NULL AS FINISH_INSP,
													NULL AS RESPON,
													NULL AS WK_RESPON,
													7 AS STATUS2,
													'BELUM REQUEST' AS NOTE,
													t.tipe_cont
											FROM t_rekon_dokumen_npct1 r
											LEFT JOIN (
													SELECT
															a.id,
															a.no_dok,
															a.tgl_dok,
															b.NO_CONT,
															b.UKR_CONT,
															b.tipe_cont
													FROM t_request a
													JOIN t_request_cont b
															ON a.id = b.id
											) t
												ON r.NO_DOK = t.no_dok
													AND t.no_cont = r.no_cont
											WHERE DATE(r.`TIMESTAMP`) >= '2026-06-18'
											and r.TYPE_DOK = 'SPJ'
											and r.PERIKSA = 'Y'
											and NOT EXISTS (
													SELECT 1
													FROM t_spk tr
													JOIN t_spk_cont trc
															ON tr.ID = trc.ID
													WHERE tr.NO_DOK = r.NO_DOK
														AND trc.NO_CONT = r.NO_CONT
											)
									) az
									WHERE NO_DOK like UPPER('%$search%') or NO_CONT like UPPER('%$search%')
									ORDER BY az.STATUS2, az.WK_RESPON";
			}
			//echo $SQL;
			//die();and A.NO_DOK like UPPER('%$search%') or B.NO_CONT like UPPER('%$search%')
			$QUERY = $this->db->query($SQL);
			return $QUERY->result();
		} else if ($act == 'count_longroom') {
			$SQLcount = "SELECT 
								COUNT(CASE 
									WHEN b.STATUS_CONT IN (450,510,530) AND d.START_INSP IS NULL AND d.FINISH_INSP IS NULL AND a.RESPON IS NULL THEN 1 
									ELSE NULL 
								END) AS 'BELUM_PPK',
								COUNT(CASE 
									WHEN b.STATUS_CONT IN (450,510,530) AND d.START_INSP IS NULL AND d.FINISH_INSP IS NULL AND a.RESPON IS NOT NULL THEN 1 
									ELSE NULL 
								END) AS 'ANTRIAN_PERIKSA',
								COUNT(CASE 
									WHEN b.STATUS_CONT = 460 AND d.START_INSP IS NULL AND d.FINISH_INSP IS NULL AND a.RESPON IS NOT NULL THEN 1 
									ELSE NULL 
								END) AS 'SIAP_PERIKSA',
								COUNT(CASE 
									WHEN b.STATUS_CONT = 460 AND d.START_INSP IS NOT NULL AND d.FINISH_INSP IS NULL THEN 1 
									ELSE NULL 
								END) AS 'SEDANG_PERIKSA',
								COUNT(CASE 
									WHEN b.STATUS_CONT IN (500,540,520) THEN 1 
									ELSE NULL 
								END) AS 'SELESAI_PERIKSA',
								COUNT(CASE 
									WHEN b.STATUS_CONT NOT IN (450,510,530,460,500,540,520) THEN 1 
									ELSE NULL 
								END) AS 'WAITING',
								(
								    SELECT COUNT(*)
								    FROM t_rekon_dokumen_npct1 r
										WHERE DATE(r.`TIMESTAMP`) >= '2026-06-18'
								    and r.TYPE_DOK = 'SPJ'
								    and r.PERIKSA = 'Y'
								    and NOT EXISTS (
								        SELECT 1
								        FROM t_spk tr
								        JOIN t_spk_cont trc
								            ON tr.ID = trc.ID
								        WHERE tr.NO_DOK = r.NO_DOK
								          AND trc.NO_CONT = r.NO_CONT
								    )
								) AS BELUM_SPK
							FROM t_gatepass a
							LEFT JOIN (SELECT * FROM t_spk_cont WHERE STATUS_CONT != 900) b ON a.NO_CONT = b.NO_CONT 
							JOIN t_spk c ON c.ID = b.ID
							LEFT JOIN t_op_inspection d ON a.NO_CONT = d.NO_CONT AND a.NO_DOK = d.NO_DOK AND a.JNS_KEGIATAN = d.JNS_KEGIATAN 
							LEFT JOIN (SELECT * FROM t_antrian_respon_ppk WHERE reset = 'N') k ON a.ID = k.id_gatepass
							LEFT JOIN t_job_slip s ON c.NO_SPK = s.NO_SPK AND a.NO_CONT = s.NO_CONT AND s.JENIS = CONCAT('BEHANDLE ', a.JNS_KEGIATAN)
							LEFT JOIN (
								SELECT a.id, a.no_dok, a.tgl_dok, b.NO_CONT, b.UKR_CONT, b.tipe_cont
								FROM t_request a
								JOIN t_request_cont b ON a.id = b.id
							) t ON c.NO_DOK = t.no_dok AND t.no_cont = a.no_cont
							WHERE a.JNS_KEGIATAN != 3 AND a.`STATUS` = 'WAITING' AND a.JNS_DOK != 'SPPMP';
							";
			$QUERY = $this->db->query($SQLcount);
			return $QUERY->result();
		} else if ($act == 'customplanner') {
			$search = $this->input->get('search');

			if ($search == "" or $search == NULL) {
				// $SQL = "SELECT * FROM (SELECT k.no_antrian,a.NO_CONT,a.UKR_CONT,a.TGL_DOK,a.JNS_DOK,a.`STATUS`,a.NO_DOK,b.LOKASI,a.JNS_KEGIATAN,a.NAMA_CUST,b.STATUS_CONT,d.START_INSP,d.FINISH_INSP,a.RESPON,a.WK_RESPON,
			  //  CASE
				// 		   WHEN b.STATUS_CONT IN (450,510,530) AND d.START_INSP IS NULL AND d.FINISH_INSP IS NULL AND a.RESPON IS NULL THEN 3
				// 		   WHEN b.STATUS_CONT IN (450,510,530) AND d.START_INSP IS NULL AND d.FINISH_INSP IS NULL AND a.RESPON IS NOT NULL THEN 1
				// 		   WHEN b.STATUS_CONT = 460 AND d.START_INSP IS NULL AND d.FINISH_INSP IS NULL  AND a.RESPON IS NOT NULL THEN 2
				// 		   WHEN b.STATUS_CONT = 460 AND d.START_INSP IS NOT NULL AND d.FINISH_INSP IS NULL THEN 4
				// 		   WHEN b.STATUS_CONT IN (500,540,520) THEN 6 
				// 		   ELSE 5 
				// 	   END AS STATUS2,s.NOTE 
			  //  FROM t_gatepass a
			  //  left JOIN (SELECT * FROM t_spk_cont WHERE STATUS_CONT != 900) b on a.NO_CONT = b.NO_CONT 
			  //  JOIN t_spk c ON c.ID = b.ID
			  //  LEFT JOIN t_op_inspection d ON a.NO_CONT = d.NO_CONT AND a.NO_DOK = d.NO_DOK and a.JNS_KEGIATAN = d.JNS_KEGIATAN
			  //  LEFT JOIN (select * from t_antrian_respon_ppk where reset = 'N') k ON a.ID = k.id_gatepass
			  //  LEFT JOIN t_job_slip s ON c.NO_SPK = s.NO_SPK AND a.NO_CONT = s.NO_CONT AND s.JENIS = CONCAT('BEHANDLE ',a.JNS_KEGIATAN)
			  //  WHERE  a.JNS_KEGIATAN  != 3 AND a.`STATUS` = 'WAITING'  AND a.JNS_DOK != 'SPPMP') az
			  //  ORDER BY STATUS2,WK_RESPON";
				$SQL = "SELECT *
									FROM (
											/* ===========================
												DATA EXISTING (GATEPASS)
												=========================== */
											SELECT
													k.no_antrian,
													a.NO_CONT,
													a.UKR_CONT,
													a.TGL_DOK,
													a.JNS_DOK,
													a.`STATUS`,
													a.NO_DOK,
													b.LOKASI,
													a.JNS_KEGIATAN,
													a.NAMA_CUST,
													b.STATUS_CONT,
													d.START_INSP,
													d.FINISH_INSP,
													a.RESPON,
													a.WK_RESPON,
													CASE
															WHEN b.STATUS_CONT IN (450,510,530)
																	AND d.START_INSP IS NULL
																	AND d.FINISH_INSP IS NULL
																	AND a.RESPON IS NULL THEN 3
															WHEN b.STATUS_CONT IN (450,510,530)
																	AND d.START_INSP IS NULL
																	AND d.FINISH_INSP IS NULL
																	AND a.RESPON IS NOT NULL THEN 2
															WHEN b.STATUS_CONT = 460
																	AND d.START_INSP IS NULL
																	AND d.FINISH_INSP IS NULL
																	AND a.RESPON IS NOT NULL THEN 1
															WHEN b.STATUS_CONT = 460
																	AND d.START_INSP IS NOT NULL
																	AND d.FINISH_INSP IS NULL THEN 4
															WHEN b.STATUS_CONT IN (500,540,520) THEN 6
															ELSE 5
													END AS STATUS2,
													s.NOTE,
													t.tipe_cont
											FROM t_gatepass a
											LEFT JOIN (
													SELECT *
													FROM t_spk_cont
													WHERE STATUS_CONT != 900
											) b ON a.NO_CONT = b.NO_CONT
											JOIN t_spk c ON c.ID = b.ID
											LEFT JOIN t_op_inspection d
													ON a.NO_CONT = d.NO_CONT
													AND a.NO_DOK = d.NO_DOK
													AND a.JNS_KEGIATAN = d.JNS_KEGIATAN
											LEFT JOIN (
													SELECT *
													FROM t_antrian_respon_ppk
													WHERE reset = 'N'
											) k ON a.ID = k.id_gatepass
											LEFT JOIN t_job_slip s
													ON c.NO_SPK = s.NO_SPK
													AND a.NO_CONT = s.NO_CONT
													AND s.JENIS = CONCAT('BEHANDLE ', a.JNS_KEGIATAN)
											LEFT JOIN (
													SELECT
															a.id,
															a.no_dok,
															a.tgl_dok,
															b.NO_CONT,
															b.UKR_CONT,
															b.tipe_cont
													FROM t_request a
													JOIN t_request_cont b
															ON a.id = b.id
											) t
													ON c.NO_DOK = t.no_dok
													AND t.no_cont = a.no_cont
											WHERE a.JNS_KEGIATAN != 3
												AND a.`STATUS` = 'WAITING'
												AND a.JNS_DOK != 'SPPMP'
											UNION ALL
											SELECT
													NULL AS no_antrian,
													r.NO_CONT,
													r.CONT_SIZE as UKR_CONT,
													r.TGL_DOK as TGL_DOK,
													REPLACE(r.TYPE_DOK, 'SPJ', 'SPJM') as JNS_DOK,
													'BELUM_SPK' AS STATUS,
													r.NO_DOK,
													'NPCT' AS LOKASI,
													NULL AS JNS_KEGIATAN,
													r.PPJK AS NAMA_CUST,
													NULL AS STATUS_CONT,
													NULL AS START_INSP,
													NULL AS FINISH_INSP,
													NULL AS RESPON,
													NULL AS WK_RESPON,
													7 AS STATUS2,
													'BELUM REQUEST' AS NOTE,
													t.tipe_cont
											FROM t_rekon_dokumen_npct1 r
											LEFT JOIN (
													SELECT
															a.id,
															a.no_dok,
															a.tgl_dok,
															b.NO_CONT,
															b.UKR_CONT,
															b.tipe_cont
													FROM t_request a
													JOIN t_request_cont b
															ON a.id = b.id
											) t
												ON r.NO_DOK = t.no_dok
													AND t.no_cont = r.no_cont
											WHERE DATE(r.`TIMESTAMP`) >= '2026-06-18'
											and r.TYPE_DOK = 'SPJ'
											and r.PERIKSA = 'Y'
											and NOT EXISTS (
													SELECT 1
													FROM t_spk tr
													JOIN t_spk_cont trc
															ON tr.ID = trc.ID
													WHERE tr.NO_DOK = r.NO_DOK
														AND trc.NO_CONT = r.NO_CONT
											)
									) az
									ORDER BY az.STATUS2, az.WK_RESPON";
			} else {
				// $SQL = "SELECT * FROM (SELECT k.no_antrian,a.NO_CONT,a.UKR_CONT,a.TGL_DOK,a.JNS_DOK,a.`STATUS`,a.NO_DOK,b.LOKASI,a.JNS_KEGIATAN,a.NAMA_CUST,b.STATUS_CONT,d.START_INSP,d.FINISH_INSP,a.RESPON,a.WK_RESPON,
			  //  CASE
				// 		   WHEN b.STATUS_CONT IN (450,510,530) AND d.START_INSP IS NULL AND d.FINISH_INSP IS NULL AND a.RESPON IS NULL THEN 3
				// 		   WHEN b.STATUS_CONT IN (450,510,530) AND d.START_INSP IS NULL AND d.FINISH_INSP IS NULL AND a.RESPON IS NOT NULL THEN 1
				// 		   WHEN b.STATUS_CONT = 460 AND d.START_INSP IS NULL AND d.FINISH_INSP IS NULL  AND a.RESPON IS NOT NULL THEN 2
				// 		   WHEN b.STATUS_CONT = 460 AND d.START_INSP IS NOT NULL AND d.FINISH_INSP IS NULL THEN 4
				// 		   WHEN b.STATUS_CONT IN (500,540,520) THEN 6 
				// 		   ELSE 5 
				// 	   END AS STATUS2,s.NOTE 
			  //  FROM t_gatepass a
			  //  left JOIN (SELECT * FROM t_spk_cont WHERE STATUS_CONT != 900) b on a.NO_CONT = b.NO_CONT 
			  //  JOIN t_spk c ON c.ID = b.ID
			  //  LEFT JOIN t_op_inspection d ON a.NO_CONT = d.NO_CONT AND a.NO_DOK = d.NO_DOK and a.JNS_KEGIATAN = d.JNS_KEGIATAN
			  //  LEFT JOIN (select * from t_antrian_respon_ppk where reset = 'N') k ON a.ID = k.id_gatepass
			  //  LEFT JOIN t_job_slip s ON c.NO_SPK = s.NO_SPK AND a.NO_CONT = s.NO_CONT AND s.JENIS = CONCAT('BEHANDLE ',a.JNS_KEGIATAN)
			  //  WHERE  a.JNS_KEGIATAN  != 3 AND a.`STATUS` = 'WAITING'  AND a.JNS_DOK != 'SPPMP') az
			  //  where NO_DOK like UPPER('%$search%') or NO_CONT like UPPER('%$search%')
			  //  ORDER BY STATUS2,WK_RESPON";
				$SQL = "SELECT *
									FROM (
											/* ===========================
												DATA EXISTING (GATEPASS)
												=========================== */
											SELECT
													k.no_antrian,
													a.NO_CONT,
													a.UKR_CONT,
													a.TGL_DOK,
													a.JNS_DOK,
													a.`STATUS`,
													a.NO_DOK,
													b.LOKASI,
													a.JNS_KEGIATAN,
													a.NAMA_CUST,
													b.STATUS_CONT,
													d.START_INSP,
													d.FINISH_INSP,
													a.RESPON,
													a.WK_RESPON,
													CASE
															WHEN b.STATUS_CONT IN (450,510,530)
																	AND d.START_INSP IS NULL
																	AND d.FINISH_INSP IS NULL
																	AND a.RESPON IS NULL THEN 3
															WHEN b.STATUS_CONT IN (450,510,530)
																	AND d.START_INSP IS NULL
																	AND d.FINISH_INSP IS NULL
																	AND a.RESPON IS NOT NULL THEN 2
															WHEN b.STATUS_CONT = 460
																	AND d.START_INSP IS NULL
																	AND d.FINISH_INSP IS NULL
																	AND a.RESPON IS NOT NULL THEN 1
															WHEN b.STATUS_CONT = 460
																	AND d.START_INSP IS NOT NULL
																	AND d.FINISH_INSP IS NULL THEN 4
															WHEN b.STATUS_CONT IN (500,540,520) THEN 6
															ELSE 5
													END AS STATUS2,
													s.NOTE,
													t.tipe_cont
											FROM t_gatepass a
											LEFT JOIN (
													SELECT *
													FROM t_spk_cont
													WHERE STATUS_CONT != 900
											) b ON a.NO_CONT = b.NO_CONT
											JOIN t_spk c ON c.ID = b.ID
											LEFT JOIN t_op_inspection d
													ON a.NO_CONT = d.NO_CONT
													AND a.NO_DOK = d.NO_DOK
													AND a.JNS_KEGIATAN = d.JNS_KEGIATAN
											LEFT JOIN (
													SELECT *
													FROM t_antrian_respon_ppk
													WHERE reset = 'N'
											) k ON a.ID = k.id_gatepass
											LEFT JOIN t_job_slip s
													ON c.NO_SPK = s.NO_SPK
													AND a.NO_CONT = s.NO_CONT
													AND s.JENIS = CONCAT('BEHANDLE ', a.JNS_KEGIATAN)
											LEFT JOIN (
													SELECT
															a.id,
															a.no_dok,
															a.tgl_dok,
															b.NO_CONT,
															b.UKR_CONT,
															b.tipe_cont
													FROM t_request a
													JOIN t_request_cont b
															ON a.id = b.id
											) t
													ON c.NO_DOK = t.no_dok
													AND t.no_cont = a.no_cont
											WHERE a.JNS_KEGIATAN != 3
												AND a.`STATUS` = 'WAITING'
												AND a.JNS_DOK != 'SPPMP'
											UNION ALL
											SELECT
													NULL AS no_antrian,
													r.NO_CONT,
													r.CONT_SIZE as UKR_CONT,
													r.TGL_DOK as TGL_DOK,
													REPLACE(r.TYPE_DOK, 'SPJ', 'SPJM') as JNS_DOK,
													'BELUM_SPK' AS STATUS,
													r.NO_DOK,
													'NPCT' AS LOKASI,
													NULL AS JNS_KEGIATAN,
													r.PPJK AS NAMA_CUST,
													NULL AS STATUS_CONT,
													NULL AS START_INSP,
													NULL AS FINISH_INSP,
													NULL AS RESPON,
													NULL AS WK_RESPON,
													7 AS STATUS2,
													'BELUM REQUEST' AS NOTE,
													t.tipe_cont
											FROM t_rekon_dokumen_npct1 r
											LEFT JOIN (
													SELECT
															a.id,
															a.no_dok,
															a.tgl_dok,
															b.NO_CONT,
															b.UKR_CONT,
															b.tipe_cont
													FROM t_request a
													JOIN t_request_cont b
															ON a.id = b.id
											) t
												ON r.NO_DOK = t.no_dok
													AND t.no_cont = r.no_cont
											WHERE DATE(r.`TIMESTAMP`) >= '2026-06-18'
											and r.TYPE_DOK = 'SPJ'
											and r.PERIKSA = 'Y'
											and NOT EXISTS (
													SELECT 1
													FROM t_spk tr
													JOIN t_spk_cont trc
															ON tr.ID = trc.ID
													WHERE tr.NO_DOK = r.NO_DOK
														AND trc.NO_CONT = r.NO_CONT
											)
									) az
									WHERE NO_DOK like UPPER('%$search%') or NO_CONT like UPPER('%$search%')
									ORDER BY az.STATUS2, az.WK_RESPON";
			}
			//echo $SQL;
			//die();and A.NO_DOK like UPPER('%$search%') or B.NO_CONT like UPPER('%$search%')
			$QUERY = $this->db->query($SQL);
			return $QUERY->result();
		} elseif ($act == 'karantina') {
			$SQL = "SELECT B.NO_SPK, A.STATUS_CONT, A.NO_CONT,A.UKR_CONT,C.WK_ACTIVE,B.NO_DOK,A.LOKASI,A.TIER,C.JNS_KEGIATAN,D.CONSIGNEE, CASE WHEN A.STATUS_CONT = '460' THEN '<span class=\'label label-warning\'>SIAP PERIKSA</span>' WHEN A.STATUS_CONT IN ('500','540','520') THEN '<span class=\'label label-success\'>SELESAI PERIKSA</span>' ELSE '<span class=\'label label-danger\'>ANTRIAN PERIKSA</span>' END AS KETERANGAN, CASE WHEN F.START_INSP IS NOT NULL AND F.FINISH_INSP IS NULL THEN 'SEDANG PERIKSA' ELSE 'ANTRIAN PERIKSA' END AS KETERANGAN2, CASE WHEN C.FL_ACTIVE = 'Y' THEN 'ANTRIAN PERIKSA' ELSE '-' END AS KETERANGAN3, -- E.KETERANGAN, 
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
		} elseif ($act == 'percepatan_penarikan') {
			$SQL = "SELECT distinct tr.ID as 'ID_REQUEST', c.NAMA as 'NAMA_DOK',tr.UKR_CONT, rkdb.NAMA, trdn.NO_DOK, tr.TGL_DOK, tr.NO_CONT as 'RCONT', trdn.NO_CONT,
				(case when tg.NO_DOK is not null then '<span class=\"label label-success\">Sudah Ada</span>' 
										when tg.NO_DOK is NULL THEN '<span class=\"label label-danger\">Belum Ada</span>'
										END) AS 'STATUS_GATEPASS',
				(case when trdn.PERIKSA = 'TRUE' then 'PERIKSA' else 'TIDAK' end) as 'KETERANGANP',
				(case when ts.NO_DOK is not null then '<span class=\"label label-success\">SUDAH SPK</span>' 
						when ts.NO_DOK is NULL THEN '<span class=\"label label-danger\">Belum SPK</span>'
						END) AS 'STATUS_SPK',
				ts.NO_SPK, ts.KETERANGAN
				from t_rekon_dokumen_npct1 trdn 
				left join (select trc.ID, trc.UKR_CONT ,tr.JNS_DOK, tr.TGL_DOK, tr.NO_DOK, trc.NO_CONT, trc.TAR from t_request tr join t_request_cont trc on tr.ID = trc.ID) tr
				on trdn.NO_DOK = tr.NO_DOK and trdn.TGL_DOK = tr.TGL_DOK and trdn.NO_CONT = tr.NO_CONT
				left join reff_kode_dok_bc rkdb on rkdb.ID = tr.JNS_DOK
				left join (select ts.NO_SPK, ts.NO_DOK, ts.TGL_DOK, tsc.NO_CONT, tsc.STATUS_CONT, rss.KETERANGAN from t_spk ts join t_spk_cont tsc on ts.ID = tsc.ID join reff_status_spk rss on tsc.STATUS_CONT = rss.ID) ts
				on trdn.NO_DOK = ts.NO_DOK and trdn.TGL_DOK = ts.TGL_DOK and TS.NO_CONT = trdn.NO_CONT
				left join t_gatepass tg on tg.NO_DOK = tr.NO_DOK and tg.TGL_DOK = tr.TGL_DOK
				inner join reff_kode_dok_bc c on c.ID = tr.JNS_DOK
				where ts.STATUS_CONT in ('000','100', '200')
				--  or ts.STATUS_CONT is null
				 ";
			$QUERY = $this->db->query($SQL);
			return $QUERY->result();
		} elseif ($act == 'penarikan') {
			$SQL = "SELECT B.NO_SPK, A.NO_CONT,B.NO_DOK,A.UKR_CONT AS 'SIZE',A.LOKASI,B.WK_REQ AS 'TERBIT_SPK',C.NAMA AS 'JENIS_DOKUMEN', CASE WHEN A.STATUS_CONT IN('000','50','100') THEN CONCAT('<span class=\"label label-success\" style=\"font-size:1em;\">', DATEDIFF(CURRENT_DATE(), DATE_FORMAT(B.WK_REQ,'%Y-%m-%d')),' HARI</span>') ELSE '-' END AS 'LAMA_PENARIKAN',A.ID_FLAT AS 'TID', D.W_PICKUP,E.CONSIGNEE, CASE WHEN A.STATUS_CONT IN('450','510','530') THEN '<span class=\"label label-warning\">ON COMMON AREA</span>' WHEN A.STATUS_CONT = '200' THEN '<span class=\"label label-warning\"style=\"background: yellow\"><font color=\"black\">ON PROCESS</font></span>' ELSE '<span class=\"label label-success\">ON TERMINAL</span>' END AS 'STATUS_PENARIKAN'
					FROM t_spk_cont A
					INNER JOIN t_spk B ON A.id = B.id
					INNER JOIN reff_kode_dok_bc C ON C.ID = B.JNS_DOK
					INNER JOIN t_request E ON E.NO_DOK = B.NO_DOK
					LEFT JOIN t_op_pickup D ON B.NO_SPK = D.NO_SPK
					WHERE A.STATUS_CONT IN ('50','000','100','200','300','400','450','510','530') AND C.NAMA != 'SPPMP'
					ORDER BY B.WK_REQ DESC LIMIT 50";
			$QUERY = $this->db->query($SQL);
			return $QUERY->result();
		} elseif ($act == 'reefer') {
			$SQL = "SELECT A.NO_SPK,B.NO_DOK, B.NO_CONT, B.UKR_CONT,B.KD_CONT_JENIS,DATE_FORMAT(C.WAKTU, '%d-%m-%Y %H:%i:%s') AS PLUGIN,E.TEMPERATURE_MONITOR AS TEMP,DATE_FORMAT(E.WAKTU_MONITOR, '%d-%m-%Y %H:%i:%s') AS MONITOR FROM (
					SELECT a.NO_DOK,a.TGL_DOK,a.NO_SPK,b.NO_CONT,b.STATUS_CONT FROM t_spk a JOIN t_spk_cont b ON a.ID = b.ID WHERE  b.STATUS_CONT NOT IN (100,200,900,950)) A
				JOIN (
					SELECT c.NO_DOK,c.TGL_DOK,d.NO_CONT,d.UKR_CONT,d.TIPE_CONT,d.KD_CONT_JENIS,d.FL_REEFER FROM t_request c JOIN t_request_cont d ON c.ID = d.ID) B ON A.NO_DOK = B.NO_DOK and A.TGL_DOK = B.TGL_DOK AND A.NO_CONT = B.NO_CONT
				LEFT JOIN t_op_reefer C ON A.NO_SPK = C.NO_SPK AND A.NO_CONT = C.NO_CONT AND C.WAKTU IS NOT NULL
				LEFT JOIN (SELECT NO_CONT,NO_SPK,MAX(id) AS idmax FROM t_op_reefer GROUP BY NO_CONT,NO_SPK) D ON A.NO_SPK = D.NO_SPK and A.NO_CONT = D.NO_CONT
				LEFT JOIN t_op_reefer E ON D.idmax = E.ID
				WHERE B.TIPE_CONT = 'RFR' AND B.FL_REEFER = 'Y'
				ORDER BY A.NO_SPK";

			// $SQL = "SELECT  A.NO_SPK, A.NO_DOK, B.NO_CONT, DATE_FORMAT(C.WAKTU, '%d-%m-%Y %H:%i:%s') AS 'PLUGIN', DATE_FORMAT(C.WAKTU_MONITOR, '%d-%m-%Y %H:%i:%s') AS 'MONITOR', C.TEMPERATURE_MONITOR AS 'TEMP_MONITOR'
			// FROM t_spk A
			// INNER JOIN t_spk_cont B ON A.ID = B.ID
			// INNER JOIN t_op_reefer C ON A.NO_SPK = C.NO_SPK AND B.NO_CONT = C.NO_CONT
			// WHERE C.WAKTU_MONITOR IS NOT NULL AND C.FL_MONITOR='Y'
			// ORDER BY C.WAKTU_MONITOR ASC";
			$QUERY = $this->db->query($SQL);
			return $QUERY->result();
		} elseif ($act == 'orderonline') {
			$SQL = "SELECT A.no_dok as NO_DOK, A.tgl_dok as TGL_DOK, A.jns_dok as JENIS_DOKUMEN, A.tgl_kirim as WAKTU from list_dokumen_user A where A.fl_status ='N' order by A.no_dok ASC";

			// $SQL = "SELECT  A.NO_SPK, A.NO_DOK, B.NO_CONT, DATE_FORMAT(C.WAKTU, '%d-%m-%Y %H:%i:%s') AS 'PLUGIN', DATE_FORMAT(C.WAKTU_MONITOR, '%d-%m-%Y %H:%i:%s') AS 'MONITOR', C.TEMPERATURE_MONITOR AS 'TEMP_MONITOR'
			// FROM t_spk A
			// INNER JOIN t_spk_cont B ON A.ID = B.ID
			// INNER JOIN t_op_reefer C ON A.NO_SPK = C.NO_SPK AND B.NO_CONT = C.NO_CONT
			// WHERE C.WAKTU_MONITOR IS NOT NULL AND C.FL_MONITOR='Y'
			// ORDER BY C.WAKTU_MONITOR ASC";
			$QUERY = $this->db->query($SQL);
			return $QUERY->result();
		} elseif ($act == 'suhu') {
			$SQL = "SELECT  A.NO_SPK, A.NO_DOK, B.NO_CONT, DATE_FORMAT(C.WAKTU_MONITOR, '%d-%m-%Y %H:%i:%s') AS 'MONITOR', C.TEMPERATURE_MONITOR AS 'TEMP_MONITOR'
				FROM t_spk A
				INNER JOIN t_spk_cont B ON A.ID = B.ID
				INNER JOIN t_op_reefer C ON A.NO_SPK = C.NO_SPK AND B.NO_CONT = C.NO_CONT
				WHERE C.WAKTU_MONITOR IS NOT NULL AND C.FL_MONITOR='Y' AND B.STATUS_CONT != 900
				ORDER BY C.ID DESC LIMIT 1";
			$QUERY = $this->db->query($SQL);
			return $QUERY->row_array();
		} else if ($act == 'monitoring_jinspection') {
			$search = $this->input->get('search');
			//echo $search;
			//die();
			//echo var_dump($search);
			if ($search == "" or $search == NULL) {
				$SQL = "SELECT distinct * FROM (SELECT mm.no_antrian,a.NO_CONT,a.UKR_CONT,a.TGL_DOK,a.JNS_DOK,a.`STATUS`,a.NO_DOK,b.LOKASI,a.JNS_KEGIATAN,a.NAMA_CUST,b.STATUS_CONT,d.START_INSP,d.FINISH_INSP,a.RESPON,a.WK_RESPON,ad.no_aju,ad.tgl_aju,ad.dok_karantina,ad.tgl_karantina,ad.dok_beacukai,ad.tgl_beacukai,ad.waktu_respon_bc, ad.waktu_respon_kr,ad.respon_karantina,ad.respon_beacukai,k.NO_RESPON,k.TG_RESPON,k.NO_DAFTAR_PABEAN,date_format(k.TGL_DAFTAR_PABEAN, '%Y-%m-%d') TGL_DAFTAR_PABEAN,k.LNSW_NOAJU,k.LNSW_TGLAJU, ak.jadwal,
					CASE
								WHEN b.STATUS_CONT IN (450,510,530) AND d.START_INSP IS NULL AND d.FINISH_INSP IS NULL AND a.RESPON IS NULL THEN 3
								WHEN b.STATUS_CONT IN (450,510,530) AND d.START_INSP IS NULL AND d.FINISH_INSP IS NULL AND a.RESPON IS NOT NULL THEN 2
								WHEN b.STATUS_CONT = 460 AND d.START_INSP IS NULL AND d.FINISH_INSP IS NULL  AND a.RESPON IS NOT NULL THEN 1
								WHEN b.STATUS_CONT IN (450,800,850) AND d.START_INSP IS NOT NULL AND d.FINISH_INSP IS NOT NULL THEN 6
								WHEN b.STATUS_CONT = 460 AND d.START_INSP IS NOT NULL AND d.FINISH_INSP IS NULL THEN 4
								WHEN b.STATUS_CONT IN (500,540,520) THEN 6 
								ELSE 5 
							END AS STATUS2,s.NOTE, t.tipe_cont AS tipe_cont 
					FROM t_gatepass a
					JOIN v_ppk_permit_join k ON a.NO_DOK = k.no_respon AND a.no_cont = k.no_cont OR a.NO_DOK = k.no_daftar_pabean AND a.no_cont = k.no_cont
					LEFT JOIN t_antrian_respon_ppk_join mm ON k.LNSW_NOAJU = mm.noaju AND k.NO_CONT = mm.no_cont
					left JOIN (SELECT * FROM t_spk_cont WHERE STATUS_CONT != 900) b on a.NO_CONT = b.NO_CONT 
					JOIN t_spk c ON c.ID = b.ID
					LEFT JOIN t_op_inspection d ON a.NO_CONT = d.NO_CONT AND a.NO_DOK = d.NO_DOK
					LEFT JOIN (select * from t_antrian_respon_ppk where reset = 'N') k ON a.ID = k.id_gatepass
					LEFT JOIN t_job_slip s ON c.NO_SPK = s.NO_SPK AND a.NO_CONT = s.NO_CONT AND s.JENIS = CONCAT('BEHANDLE ',a.JNS_KEGIATAN)
					LEFT JOIN (SELECT a.id, a.no_dok, a.tgl_dok, b.NO_CONT, b.UKR_CONT, b.tipe_cont
						FROM t_request a
						JOIN t_request_cont b ON a.id = b.id ) t ON c.NO_DOK = t.no_dok AND t.no_cont = a.no_cont
					left JOIN t_lnsw_responjoin ad ON a.NO_DOK = ad.dok_karantina AND a.TGL_DOK = ad.tgl_karantina or a.NO_DOK = ad.dok_beacukai AND a.TGL_DOK = ad.tgl_beacukai 
					LEFT JOIN t_detail_pemeriksa_join ak ON (a.NO_DOK = k.no_respon OR a.NO_DOK = k.NO_DAFTAR_PABEAN) AND ak.no_cont = a.no_cont
					WHERE  a.JNS_KEGIATAN  != 3 ) az WHERE (STATUS = 'DONE' AND JNS_KEGIATAN = 2) OR STATUS = 'WAITING'
					ORDER BY STATUS2,WK_RESPON";
			} else {
				$SQL = "SELECT distinct * FROM (SELECT mm.no_antrian,a.NO_CONT,a.UKR_CONT,a.TGL_DOK,a.JNS_DOK,a.`STATUS`,a.NO_DOK,b.LOKASI,a.JNS_KEGIATAN,a.NAMA_CUST,b.STATUS_CONT,d.START_INSP,d.FINISH_INSP,a.RESPON,a.WK_RESPON,ad.no_aju,ad.tgl_aju,ad.dok_karantina,ad.tgl_karantina,ad.dok_beacukai,ad.tgl_beacukai,ad.waktu_respon_bc, ad.waktu_respon_kr,ad.respon_karantina,ad.respon_beacukai,k.NO_RESPON,k.TG_RESPON,k.NO_DAFTAR_PABEAN,date_format(k.TGL_DAFTAR_PABEAN, '%Y-%m-%d') TGL_DAFTAR_PABEAN,k.LNSW_NOAJU,k.LNSW_TGLAJU, ak.jadwal,
					CASE
								WHEN b.STATUS_CONT IN (450,510,530) AND d.START_INSP IS NULL AND d.FINISH_INSP IS NULL AND a.RESPON IS NULL THEN 3
								WHEN b.STATUS_CONT IN (450,510,530) AND d.START_INSP IS NULL AND d.FINISH_INSP IS NULL AND a.RESPON IS NOT NULL THEN 2
								WHEN b.STATUS_CONT = 460 AND d.START_INSP IS NULL AND d.FINISH_INSP IS NULL  AND a.RESPON IS NOT NULL THEN 1
								WHEN b.STATUS_CONT = 450 AND d.START_INSP IS NOT NULL AND d.FINISH_INSP IS NOT NULL THEN 6
								WHEN b.STATUS_CONT = 460 AND d.START_INSP IS NOT NULL AND d.FINISH_INSP IS NULL THEN 4
								WHEN b.STATUS_CONT IN (500,540,520) THEN 6 
								ELSE 5 
							END AS STATUS2,s.NOTE, t.tipe_cont AS tipe_cont 
					FROM t_gatepass a
					JOIN v_ppk_permit_join k ON a.NO_DOK = k.no_respon AND a.no_cont = k.no_cont OR a.NO_DOK = k.no_daftar_pabean AND a.no_cont = k.no_cont
					LEFT JOIN t_antrian_respon_ppk_join mm ON k.LNSW_NOAJU = mm.noaju AND k.NO_CONT = mm.no_cont
					left JOIN (SELECT * FROM t_spk_cont WHERE STATUS_CONT != 900) b on a.NO_CONT = b.NO_CONT 
					JOIN t_spk c ON c.ID = b.ID
					LEFT JOIN t_op_inspection d ON a.NO_CONT = d.NO_CONT AND a.NO_DOK = d.NO_DOK
					LEFT JOIN (select * from t_antrian_respon_ppk where reset = 'N') k ON a.ID = k.id_gatepass
					LEFT JOIN t_job_slip s ON c.NO_SPK = s.NO_SPK AND a.NO_CONT = s.NO_CONT AND s.JENIS = CONCAT('BEHANDLE ',a.JNS_KEGIATAN)
					LEFT JOIN (SELECT a.id, a.no_dok, a.tgl_dok, b.NO_CONT, b.UKR_CONT, b.tipe_cont
						FROM t_request a
						JOIN t_request_cont b ON a.id = b.id ) t ON c.NO_DOK = t.no_dok AND t.no_cont = a.no_cont
					left JOIN t_lnsw_responjoin ad ON a.NO_DOK = ad.dok_karantina AND a.TGL_DOK = ad.tgl_karantina or a.NO_DOK = ad.dok_beacukai AND a.TGL_DOK = ad.tgl_beacukai 
					LEFT JOIN t_detail_pemeriksa_join ak ON (a.NO_DOK = k.no_respon OR a.NO_DOK = k.NO_DAFTAR_PABEAN) AND ak.no_cont = a.no_cont
					WHERE  a.JNS_KEGIATAN  != 3) az WHERE (STATUS = 'DONE' AND JNS_KEGIATAN = 2) OR STATUS = 'WAITING'
					and NO_CONT like UPPER('%$search%') or LNSW_NOAJU like UPPER('%$search%')
					ORDER BY STATUS2,WK_RESPON";
			}
			//echo $SQL;
			//die();and A.NO_DOK like UPPER('%$search%') or B.NO_CONT like UPPER('%$search%')
			$QUERY = $this->db->query($SQL);
			return $QUERY->result();
		}
	}

	/* public function getresponcustoms($act, $id){
		if($this->session->userdata('KD_GROUP')=="BC"){
			$page_title = "RESPON CUSTOMS";
			$title = "CUSTOMS";
			$this->newtable->breadcrumb('Dashboard', site_url(),'icon-home');
			$this->newtable->breadcrumb('Reference', 'javascript:void(0)','');
			$this->newtable->breadcrumb('Customer', 'javascript:void(0)','');
			$check = (grant()=="W")?true:false;
			$addsql = " B.STATUS_CONT IN('460','510','530') AND G.ID != 83";
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
					LEFT JOIN t_op_inspection F ON F.NO_CONT = B.NO_CONT AND C.NO_DOK = F.NO_DOK
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
		}else if($this->session->userdata('KD_GROUP')=="SPA"){
			$page_title = "RESPON CUSTOMS PRIORITAS";
			$title = "CUSTOMS";
			$this->newtable->breadcrumb('Dashboard', site_url(),'icon-home');
			$this->newtable->breadcrumb('Reference', 'javascript:void(0)','');
			$this->newtable->breadcrumb('Customer', 'javascript:void(0)','');
			$check = (grant()=="W")?true:false;
			$addsql = " B.STATUS_CONT IN('460','510','530')";
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
					LEFT JOIN t_op_inspection F ON F.NO_CONT = B.NO_CONT AND C.NO_DOK = F.NO_DOK
					LEFT JOIN reff_kode_dok_bc G ON D.JNS_DOK = G.ID
					LEFT JOIN t_job_slip H ON H.NO_CONT = B.NO_CONT
					WHERE".$addsql."";
			
			$proses = array('PKB LONGROOM'  => array('DELETE',"display/execute/porses_cust1", 'all','','md-layers','', 'menu'),
							'PKB YARD'  => array('DELETE',"display/execute/porses_cust2", 'all','','md-navigation','', 'menu'),
							'PKB YARD N'  => array('DELETE',"display/execute/porses_cust3", 'all','','md-badge-check','', 'menu'),
							'PKB LONGROOM ' => array('POST',"display/respon_custom/pkblr", '1', '', 'md-layers','','list'),
							'PKB PRIORITAS'  => array('DELETE',"display/execute/porses_prioritas", 'all','','md-layers','', 'menu'),
							'PKB YARD ' => array('POST',"display/respon_custom/pkbyard", '1','','md-navigation','', 'list'),
							'PKB YARD N ' => array('POST',"display/respon_custom/pkbyardn", '1','','md-badge-check','', 'list'),
							'PKB PRIORITAS ' => array('POST',"display/respon_custom/pkbprioritas", '1', '', 'md-layers','','list'));						
			$this->newtable->multiple_search(true);
			$this->newtable->show_chk(true);
			$this->newtable->show_menu($check);
			$this->newtable->show_search(true);
			//$this->newtable->search(array(array('F.NO_CONT','NO. KONTAINER'),array('C.ANGKUTNAMA_TPS','NAMA KAPAL')));
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
		}else if($this->session->userdata('KD_GROUP')=="PLN"){
			$page_title = "RESPON CUSTOMS";
			$title = "CUSTOMS";
			$this->newtable->breadcrumb('Dashboard', site_url(),'icon-home');
			$this->newtable->breadcrumb('Reference', 'javascript:void(0)','');
			$this->newtable->breadcrumb('Customer', 'javascript:void(0)','');
			$check = (grant()=="W")?true:false;
			$addsql = " B.STATUS_CONT IN('460','510','530') AND C.FL_ACTIVE = 'Y'";
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
					LEFT JOIN t_op_inspection F ON F.NO_CONT = B.NO_CONT AND C.NO_DOK = F.NO_DOK
					LEFT JOIN reff_kode_dok_bc G ON D.JNS_DOK = G.ID
					LEFT JOIN t_job_slip H ON H.NO_CONT = B.NO_CONT
					WHERE".$addsql."";
			
			$proses = array('PKB PRIORITAS'  => array('DELETE',"display/execute/porses_prioritas", 'all','','md-layers','', 'menu'),
							'PKB PRIORITAS ' => array('POST',"display/respon_custom/pkbprioritas", '1', '', 'md-layers','','list'));

			$this->newtable->multiple_search(true);
			$this->newtable->show_chk(true);
			$this->newtable->show_menu($check);
			$this->newtable->show_search(true);
			//$this->newtable->search(array(array('F.NO_CONT','NO. KONTAINER'),array('C.ANGKUTNAMA_TPS','NAMA KAPAL')));
			$this->newtable->search(array(array('A.NO_SPK','NO. SPK'),array('B.NO_CONT','NO. KONTAINER'),array('C.NO_DOK','NO. DOKUMEN')));
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
	} */

	// RESPON PKB KE 2
	// public function getresponcustoms($type, $act, $id){
	// 	$page_title = "RESPON PKB";
	// 	$title = "RESPON PKB";
	// 	$this->newtable->breadcrumb('Dashboard', site_url(),'icon-home');
	// 	$this->newtable->breadcrumb('Customs', 'javascript:void(0)','');
	// 	$this->newtable->breadcrumb('PKB', 'javascript:void(0)','');
	// 	$check = (grant()=="W")?true:false;

	// 	if ($this->session->userdata('KD_GROUP') == 'BC') {
	// 		$addsql = " AND B.STATUS_CONT IN(460,510,530) AND C.JNS_DOK !='SPPMP'";
	// 		$proses = array('PKB LONGROOM'  => array('POST',"display/respon_custom/respon/pkb_longroom", 'all','','md-layers','', 'menu'),
	// 						'PKB YARD'  => array('POST',"display/respon_custom/respon/pkb_yard", 'all','','md-navigation','', 'menu'),
	// 						'PKB YARD N'  => array('POST',"display/respon_custom/respon/pkb_yardn", 'all','','md-badge-check','', 'menu'));
	// 	}elseif ($this->session->userdata('KD_GROUP') == 'SPA') {
	// 		$addsql = " AND B.STATUS_CONT IN(460,510,530)";
	// 		$proses = array('PKB LONGROOM'  => array('POST',"display/respon_custom/respon/pkb_longroom", 'all','','md-layers','', 'menu'),
	// 						'PKB YARD'  => array('POST',"display/respon_custom/respon/pkb_yard", 'all','','md-navigation','', 'menu'),
	// 						'PKB YARD N'  => array('POST',"display/respon_custom/respon/pkb_yardn", 'all','','md-badge-check','', 'menu'),
	// 						'PKB PERCEPATAN'  => array('POST',"display/respon_custom/respon/pkb_percepatan", 'all','','md-layers','', 'menu'));
	// 	}else{
	// 		$addsql = " AND B.STATUS_CONT IN(460,510,530)";
	// 		$proses = array('PKB PERCEPATAN'  => array('POST',"display/respon_custom/respon/pkb_percepatan", 'all','','md-layers','', 'menu'));
	// 	}


	// 	$SQL = "SELECT DISTINCT C.ID, C.NO_DOK, C.JNS_DOK AS 'JENIS DOKUMEN', CONCAT(C.NO_DOK,'<BR>',DATE_FORMAT(C.TGL_DOK, '%d-%m-%Y')) AS DOKUMEN, CONCAT(B.NO_CONT,'<BR>',B.UKR_CONT) AS 'KONTAINER', CONCAT(B.LOKASI,B.TIER) AS LOKASI, CONCAT('BEHANDLE ',C.JNS_KEGIATAN) AS 'KETERANGAN', C.NAMA_CUST AS 'CUSTOMER',
	// 				CASE
	// 					WHEN B.STATUS_CONT IN (450,510,530) AND D.START_INSP IS NULL AND D.FINISH_INSP IS NULL AND C.RESPON IS NULL THEN '<span class=\"label label-danger\">BELUM PKB</span>'
	// 					WHEN B.STATUS_CONT IN (450,510,530) AND D.START_INSP IS NULL AND D.FINISH_INSP IS NULL AND C.RESPON IS NOT NULL THEN '<span class=\"label label-danger\">PKB</span>'
	// 					WHEN B.STATUS_CONT = 460 AND D.START_INSP IS NULL AND D.FINISH_INSP IS NULL  AND C.RESPON IS NOT NULL THEN '<span class=\"label label-warning\">SIAP PERIKSA</span>'
	// 					WHEN B.STATUS_CONT = 460 AND D.START_INSP IS NOT NULL AND D.FINISH_INSP IS NULL THEN '<span class=\"label label-primary\">SEDANG PERIKSA</span>' 
	// 					WHEN B.STATUS_CONT IN (500,540,520) THEN '<span class=\"label label-success\">SELESAI PERIKSA</span>' 
	// 					WHEN B.STATUS_CONT IN (800,850,870,900,901,902,950) THEN '<span class=\"label label-success\">DELIVERY</span>'
	// 					ELSE '<span class=\"label label-success\">SELESAI PERIKSA</span>'  
	// 				END AS STATUS, 
	// 				CONCAT('RESPON :',
	// 					CASE 
	// 						WHEN C.RESPON = 'PKB' THEN '<span style=\"color:green;font-weight:bold\">PKB</span>'
	// 						ELSE '<span style=\"color:red;font-weight:bold\">PERCEPATAN</span>'
	// 					END,'<BR>','TANGGAL PKB :',DATE_FORMAT(C.WK_RESPON, '%d-%m-%Y %h:%i:%s')
	// 				)AS PKB
	// 			FROM t_spk A
	// 			INNER JOIN t_spk_cont B ON A.ID = B.ID
	// 			INNER JOIN t_gatepass C ON B.NO_CONT = C.NO_CONT AND C.STATUS = 'WAITING' AND C.FL_ACTIVE = 'Y'
	// 			LEFT JOIN t_op_inspection D ON D.NO_CONT = B.NO_CONT AND C.NO_DOK = D.NO_DOK
	// 			WHERE 1=1 ".$addsql."";
	// 	$this->newtable->multiple_search(true);
	// 	$this->newtable->show_chk($check);
	// 	$this->newtable->show_menu($check);
	// 	$this->newtable->show_search(true);
	// 	$this->newtable->search(array(array('C.NO_CONT','NO. KONTAINER'),array('C.NO_DOK','NO. DOKUMEN')));
	// 	$this->newtable->action(site_url() . "/display/respon_custom");
	// 	$this->newtable->tipe_proses('button');
	// 	$this->newtable->hiddens(array("ID","NO_DOK"));
	// 	$this->newtable->keys(array("ID","NO_DOK"));
	// 	$this->newtable->cidb($this->db);
	// 	$this->newtable->groupby("");
	// 	$this->newtable->orderby("CASE WHEN B.STATUS_CONT IN (450,510,530) AND C.RESPON IS NULL THEN 1 WHEN B.STATUS_CONT IN (450,510,530) AND C.RESPON IS NOT NULL THEN 2 WHEN B.STATUS_CONT = 460 AND D.START_INSP IS NULL AND D.FINISH_INSP IS NULL  AND C.RESPON IS NOT NULL THEN 3 WHEN B.STATUS_CONT = 460 AND D.START_INSP IS NOT NULL AND D.FINISH_INSP IS NULL THEN 4 ELSE 5 END ASC, C.WK_RESPON ASC,C.WK_ACTIVE ASC");
	// 	$this->newtable->sortby("");
	// 	$this->newtable->set_formid("tblcustoms");
	// 	$this->newtable->set_divid("divcustoms");
	// 	$this->newtable->rowcount(50);
	// 	$this->newtable->clear();
	// 	$this->newtable->menu($proses);
	// 	$tabel .= $this->newtable->generate($SQL);
	// 	$arrdata = array("page_title" => $page_title, "title" => $title, "content" => $tabel);
	// 	if($this->input->post("ajax")||$act == "post")
	// 		return $tabel;
	// 	else
	// 		return $arrdata;
	// }

	public function getresponcustoms($type, $act, $id)
	{
		$page_title = "RESPON PPK";
		$title = "RESPON PPK";
		$this->newtable->breadcrumb('Dashboard', site_url(), 'icon-home');
		$this->newtable->breadcrumb('Customs', 'javascript:void(0)', '');
		$this->newtable->breadcrumb('PPK', 'javascript:void(0)', '');
		$check = (grant() == "W") ? true : false;

		// if ($this->session->userdata('KD_GROUP') == 'BC') {
		// 	$addsql = " AND B.STATUS_CONT IN(460,510,530) AND C.JNS_DOK !='SPPMP'";
		// 	$proses = array('PKB LONGROOM'  => array('POST',"display/respon_custom/respon/pkb_longroom", 'all','','md-layers','', 'menu'),
		// 					'PKB YARD'  => array('POST',"display/respon_custom/respon/pkb_yard", 'all','','md-navigation','', 'menu'),
		// 					'PKB YARD N'  => array('POST',"display/respon_custom/respon/pkb_yardn", 'all','','md-badge-check','', 'menu'));
		// }elseif ($this->session->userdata('KD_GROUP') == 'SPA') {
		// 	$addsql = " AND B.STATUS_CONT IN(460,510,530)";
		// 	$proses = array('PKB LONGROOM'  => array('POST',"display/respon_custom/respon/pkb_longroom", 'all','','md-layers','', 'menu'),
		// 					'PKB YARD'  => array('POST',"display/respon_custom/respon/pkb_yard", 'all','','md-navigation','', 'menu'),
		// 					'PKB YARD N'  => array('POST',"display/respon_custom/respon/pkb_yardn", 'all','','md-badge-check','', 'menu'),
		// 					'PKB PERCEPATAN'  => array('POST',"display/respon_custom/respon/pkb_percepatan", 'all','','md-layers','', 'menu'));
		// }else{
		// 	$addsql = " AND B.STATUS_CONT IN(460,510,530)";
		// 	$proses = array('PKB PERCEPATAN'  => array('POST',"display/respon_custom/respon/pkb_percepatan", 'all','','md-layers','', 'menu'));
		// }


		$SQL = "SELECT NO_DOK,CONCAT(NO_DOK,'<BR>', DATE_FORMAT(TGL_DOK, '%d-%m-%Y')) AS DOKUMEN,JNS_DOK as 'JENIS DOKUMENT',NAMA_CUST as 'NAMA CUSTOMER',
		case when COUNT(RESPON) = 0 then '<span class=\"label label-danger\">SEGERA DI RESPON</span>' 
		when COUNT(RESPON) = COUNT(NO_DOK) THEN '<span class=\"label label-success\">SUDAH PPK</span>' 
		WHEN COUNT(RESPON) < COUNT(NO_DOK) THEN '<span class=\"label label-warning\">KURANG RESPON</span>' END STATUS,
		case 
		when MAX(KD_STATUS) IS NULL then 'REQUEST'
		when MAX(KD_STATUS) = 000 then 'WAITING'
		when MAX(KD_STATUS) = 100 then 'ANNOUNCE'
		when MAX(KD_STATUS) = 200 then 'PICKUP'
		else
		'BEHANDLE IN'
		END POSISI,max(WK_RESPON) 'WAKTU RESPON'
		,concat('<center><button class=\"btn btn-icon btn-success waves-effect waves-light waves-round waves-effect waves-light\">',MAX(no_antrian),'</button></center>') as 'NO URUT'
		FROM (SELECT a.NO_DOK,a.JNS_DOK,a.TGL_DOK,a.WK_REK,a.NO_CONT,a.JNS_KEGIATAN,a.NAMA_CUST,a.RESPON,a.wk_respon,
		b.NO_CONT NO_CONT1,b.STATUS_CONT,c.KD_STATUS,c.NO_DOK NO_DOK1,d.ID,d.START_INSP,d.FINISH_INSP,k.no_antrian
		FROM t_gatepass a
		JOIN t_spk c ON a.NO_DOK = c.NO_DOK and a.TGL_DOK = c.TGL_DOK
		LEFT join t_spk_cont b on c.ID = b.ID
		LEFT JOIN t_op_inspection d ON a.NO_CONT = d.NO_CONT AND a.NO_DOK = d.NO_DOK AND a.JNS_KEGIATAN = d.JNS_KEGIATAN
		LEFT JOIN t_antrian_respon_ppk k ON a.ID = k.id_gatepass and k.reset = 'N'
		WHERE a.JNS_KEGIATAN  != 3 AND a.`STATUS` = 'WAITING' AND d.FINISH_INSP IS NULL AND a.JNS_DOK != 'SPPMP' AND DATE(a.TGL_DOK) > DATE_ADD(NOW() , INTERVAL -5 month)) az where 1=1";

		$proses = array('RESPON PPK'  => array('MODAL', "display/respon_custom/getrespon", '1', '', 'md-layers', '', 'list'), 'HISTORY PPK'  => array('MODAL', "display/respon_custom/getrespon_history", '1', '', 'md-watch', '', 'list'), 'RESET ANTRIAN'  => array('GET', site_url() . "/display/resetantrian", '0', '', 'md-minus-circle', '', 'menu'));

		$this->newtable->multiple_search(true);
		$this->newtable->show_chk(false);
		$this->newtable->show_menu($check);
		$this->newtable->show_search(true);
		$this->newtable->search(array(array('az.NO_CONT', 'NO. KONTAINER'), array('az.NO_DOK', 'NO. DOKUMEN')));
		$this->newtable->action(site_url() . "/display/respon_custom");
		$this->newtable->detail(array('POPUP', "display/respon_custom/detail/"));
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("NO_DOK"));
		$this->newtable->keys(array("NO_DOK"));
		$this->newtable->cidb($this->db);
		$this->newtable->groupby(array("NO_DOK,TGL_DOK,NAMA_CUST"));
		$this->newtable->orderby("case when wk_respon IS NULL then 0 ELSE 1 end,wk_respon desc,TGL_DOK asc");
		$this->newtable->sortby("");
		$this->newtable->set_formid("tblcustoms");
		$this->newtable->set_divid("divcustoms");
		$this->newtable->rowcount(100);
		//$this->newtable->clear();
		$this->newtable->menu($proses);
		$tabel .= $this->newtable->generate($SQL);
		$arrdata = array("page_title" => $page_title, "title" => $title, "content" => $tabel);
		if ($this->input->post("ajax") || $act == "post")
			return $tabel;
		else
			return $arrdata;
	}
	public function getresponcustomsjoin($type, $act, $id)
	{
		$page_title = "RESPON IPK JOIN INSPECTION";
		$title = "RESPON IPK";
		$this->newtable->breadcrumb('Dashboard', site_url(), 'icon-home');
		$this->newtable->breadcrumb('Customs', 'javascript:void(0)', '');
		$this->newtable->breadcrumb('IPK', 'javascript:void(0)', '');
		$check = (grant() == "W") ? true : false;
		$SQL = "SELECT distinct dd.id,aa.LNSW_NOAJU,aa.LNSW_TGLAJU,aa.no_respon,aa.tg_respon,bb.no_daftar_pabean,bb.tgl_daftar_pabean,
		CONCAT('No: ',aa.LNSW_NOAJU,'<br>','Tanggal: ',aa.LNSW_TGLAJU) AS 'DOKUMEN JOIN INSPECTION',
		CONCAT('Jenis: Karantina <br> No: ',(aa.no_respon),'<BR>Tanggal: ', (DATE_FORMAT(aa.tg_respon,'%d-%m-%Y')),'<br><br>','Jenis: Bea Cukai <br> No: ',(bb.no_daftar_pabean),'<BR>Tanggal: ', (DATE_FORMAT(bb.tgl_daftar_pabean,'%d-%m-%Y'))) AS 'DOKUMEN KARANTINA & BEA CUKAI',
		(case when COUNT(yy.respon) = 0 then '<span class=\"label label-danger\">SEGERA DI RESPON</span>' 
		when COUNT(yy.respon) = COUNT(yy.no_dok) THEN '<span class=\"label label-success\">SUDAH PPK</span>' 
		WHEN COUNT(yy.respon) < COUNT(yy.no_dok) THEN '<span class=\"label label-warning\">KURANG RESPON</span>' END) STATUS, 
		(case 
		when MAX(dd.kd_status) IS NULL then 'REQUEST'
		when MAX(dd.kd_status) = 000 then 'WAITING'
		when MAX(dd.kd_status) = 100 then 'ANNOUNCE'
		when MAX(dd.kd_status) = 200 then 'PICKUP'
		else
		'BEHANDLE IN'
		END) POSISI,max(yy.wk_respon) 'WAKTU RESPON'
		FROM (
			SELECT a.ID_IJIN,a.NO_RESPON,a.TG_RESPON,b.NO_CONT,a.LNSW_NOAJU,a.LNSW_TGLAJU FROM t_ppk_hdr a JOIN t_ppk_cont b ON a.ID_IJIN = b.ID_IJIN WHERE a.LNSW_KD_RESPON = '005') aa
		JOIN (
			SELECT a.ID,a.NO_DAFTAR_PABEAN,a.TGL_DAFTAR_PABEAN,b.NO_CONT,a.LNSW_NOAJU FROM t_permit_hdr a JOIN t_permit_cont b ON a.ID = b.ID WHERE a.LNSW_KD_RESPON = '005') bb
		ON aa.lnsw_noaju = bb.lnsw_noaju AND aa.NO_CONT = bb.NO_CONT
		JOIN (SELECT a.id,a.no_dok,a.tgl_dok,a.kd_status,b.no_cont FROM t_spk a JOIN t_spk_cont b ON a.id = b.id  WHERE b.STATUS_CONT != 900) dd ON aa.NO_RESPON = dd.no_dok AND aa.TG_RESPON = dd.tgl_dok AND aa.NO_CONT = dd.NO_CONT
		LEFT JOIN t_gatepass yy ON aa.no_respon = yy.no_dok AND aa.tg_respon = yy.tgl_dok AND aa.no_cont = yy.no_cont
		left JOIN t_lnsw_responjoin ee ON aa.LNSW_NOAJU = ee.no_aju 
		LEFT JOIN t_detail_pemeriksa_join ff ON dd.no_dok = ff.no_dok AND dd.tgl_dok = ff.tgl_dok AND dd.no_cont = ff.no_cont
		LEFT JOIN t_pemeriksa_ppk gg ON ff.id_pemeriksa = gg.ID
		LEFT JOIN t_pemeriksa_ppk hh ON ff.id_pemeriksa_bc = hh.ID
		LEFT JOIN t_antrian_respon_ppk_join mm ON aa.LNSW_NOAJU = mm.noaju AND aa.NO_CONT = mm.no_cont";
		$proses = array('RESPON IPK'  => array('MODAL', "display/ppkjoininspection/getrespon", '1', '', 'md-layers', '', 'list'), 'SET PEMERIKSA'  => array('MODAL', "display/ppkjoininspection/setpemeriksa", '1', '', 'md-mail-send', '', 'list'), 'RESET ANTRIAN'  => array('GET', site_url() . "/display/resetantrianjoin", '0', '', 'md-minus-circle', '', 'menu'));

		$this->newtable->multiple_search(true);
		$this->newtable->show_chk(false);
		$this->newtable->show_menu($check);
		$this->newtable->show_search(true);
		$this->newtable->search(array(array('aa.no_cont', 'NO. KONTAINER'), array('aa.no_respon', 'NO. DOKUMEN SPPMP')));
		$this->newtable->action(site_url() . "/display/ppkjoininspection");
		$this->newtable->detail(array('POPUP', "display/ppkjoininspection/detail/"));
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("id", "LNSW_NOAJU", "LNSW_TGLAJU", "NO_RESPON", "TG_RESPON", "NO_DAFTAR_PABEAN", "TGL_DAFTAR_PABEAN"));
		$this->newtable->keys(array("id", "LNSW_NOAJU", "NO_RESPON", "TG_RESPON", "NO_DAFTAR_PABEAN", "TGL_DAFTAR_PABEAN"));
		$this->newtable->cidb($this->db);
		$this->newtable->groupby(array("aa.LNSW_NOAJU"));
		//$this->newtable->orderby("aa.LNSW_NOAJU ASC");
		$this->newtable->sortby("");
		$this->newtable->set_formid("tblcustoms");
		$this->newtable->set_divid("divcustoms");
		$this->newtable->rowcount(50);
		//$this->newtable->clear();
		$this->newtable->menu($proses);
		$tabel .= $this->newtable->generate($SQL);
		$arrdata = array("page_title" => $page_title, "title" => $title, "content" => $tabel);
		if ($this->input->post("ajax") || $act == "post")
			return $tabel;
		else
			return $arrdata;
	}

	public function getresponrequestonline($type, $act, $id)
	{
		$func = get_instance();
		$func->load->model("m_main", "main", true);
		$page_title = "MONITORING REQUEST LAYANAN ONLINE";
		$title = "MONITORING REQUEST LAYANAN ONLINE";

		$this->newtable->breadcrumb('Dashboard', site_url(), 'icon-home');
		$this->newtable->breadcrumb('Planner', 'javascript:void(0)', '');
		$this->newtable->breadcrumb('Monitoring Layanan Online', 'javascript:void(0)', '');

		$check = (grant() == "W") ? true : false;

		$SQL = "SELECT A.ID, A.NO_DOK, A.TGL_DOK, A.TYPE_DOK as JENIS_DOKUMEN, A.TGL_NHI, B.KD_REQ, A.CREATED_AT,
		CONCAT('<a style=\"color:blue;\">','Document : ' ,'</a>' ,(A.NO_DOK)) AS 'NO. DOKUMEN',
		CONCAT('Tanggal Dokumen : ', '<a style=\"color:red;\">',(A.TGL_DOK),'</a>') AS 'TGL DOKUMEN',
		CONCAT('Jenis Dokumen : ', '<a style=\"color:green;\">',(A.TYPE_DOK),'</a>') AS 'JENIS DOKUMEN',
		CONCAT('Tanggal NHI : ','<a style=\"color:red;\">',(A.TGL_NHI),'</a>') AS 'Tanggal NHI',
		(case when B.KD_REQ in('DRAFT','SENT','APPROVED','ERROR','REJECTED','INQUIRY','BYPASS','QUEUED') then '<span class=\"label label-success\">Dokumen Tersedia</span>' 
		when B.KD_REQ is NULL THEN '<span class=\"label label-danger\">Dokumen Belum Tersedia</span>'
		END) AS 'STATUS PENARIKAN',
		(case when D.NO_DOK is not null then '<span class=\"label label-success\">SUDAH SPK</span>' 
		when D.NO_DOK is NULL THEN '<span class=\"label label-danger\">Belum SPK</span>'
		END) AS 'STATUS SPK',
		(case when E.NO_DOK is not null then '<span class=\"label label-success\">Sudah Ada</span>' 
		when E.NO_DOK is NULL THEN '<span class=\"label label-danger\">Belum Ada</span>'
		END) AS 'STATUS GATEPASS',
		CONCAT('Waktu Layanan Online : ','<a style=\"color:red;\">',(A.CREATED_AT),'</a>') AS 'WAKTU LAYANAN ONLINE'
		from list_dokumens A 
		left join (select a.ID, a.NO_DOK, a.TGL_DOK, a.JNS_DOK, a.KD_REQ, c.NAMA from t_request a inner join reff_kode_dok_bc c on c.ID = a.JNS_DOK) B on B.NO_DOK = A.NO_DOK and B.TGL_DOK = A.TGL_DOK or B.NO_DOK = A.NO_DOK and B.TGL_DOK = A.TGL_DOK
		left join (select c.ID, c.NO_DOK, c.TGL_DOK from t_spk_cont d inner join t_spk c on c.ID = d.ID) D on D.NO_DOK = A.NO_DOK and D.TGL_DOK = A.TGL_DOK  
		left join t_gatepass E on E.NO_DOK = A.NO_DOK and E.TGL_DOK = A.TGL_DOK 
		where A.FL_STATUS ='N' and year(A.CREATED_AT) >= 2026";

		// array('PROSES'  => array('POST_ONLINE',"display/monitorOrderOnline/prosesonline", '1','','md-mail-send','','list'),

		// $proses = array('PROSES'  => array('MODAL',"display/monitorOrderOnline/add_data", '1','','md-email','','list'));

		$proses = array('Lihat Dokumen'  => array('MODAL', "online/monitorOrderOnline/print", '1', '', 'md-eye', '', 'list'), 'TOLAK'  => array('MODAL', "online/monitorOrderOnline/add_data_tolak", '1', '', 'md-close-circle', '', 'list'), 'PROSES'  => array('MODAL', "online/monitorOrderOnline/add_data", '1', '', 'md-mail-send', '', 'list'));




		$this->newtable->multiple_searchh(true);
		$this->newtable->show_chk(false);
		$this->newtable->show_menu($check);
		$this->newtable->show_search(true);
		$this->newtable->search(array(array('A.NO_DOK', 'NO. DOKUMEN')));
		$this->newtable->action(site_url() . "/online/monitorOrderOnline");
		//$this->newtable->detail(array('POPUP',"display/ppkjoininspection/detail/"));
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array('ID', 'NO_DOK', 'TGL_DOK', 'JENIS_DOKUMEN', 'TGL_NHI', 'KD_REQ', 'CREATED_AT'));
		$this->newtable->keys(array("ID"));
		$this->newtable->cidb($this->db);
		//$this->newtable->groupby(array("A.NO_DOK"));
		$this->newtable->orderby("A.ID");
		$this->newtable->sortby("asc");
		$this->newtable->set_formid("tblrespononline");
		$this->newtable->set_divid("divrespononline");
		$this->newtable->rowcount(12);
		$this->newtable->clear();
		$this->newtable->menu($proses);
		$tabel .= $this->newtable->generate($SQL);
		$arrdata = array("page_title" => $page_title, "title" => $title, "content" => $tabel);
		if ($this->input->post("ajax") || $act == "post")
			return $tabel;
		else
			return $arrdata;
	}

	public function getresponrequestonlinee($type, $act, $id)
	{
		$page_title = "MONITORING REQUEST LAYANAN ONLINE";
		$title = "MONITORING REQUEST LAYANAN ONLINE";
		$this->newtable->breadcrumb('Dashboard', site_url(), 'icon-home');
		$this->newtable->breadcrumb('Planner', 'javascript:void(0)', '');
		$this->newtable->breadcrumb('Monitoring Layanan Online', 'javascript:void(0)', '');

		$check = (grant() == "W") ? true : false;

		$SQL = "SELECT A.ID, E.NO_CONT, A.NO_DOK, A.TGL_DOK, A.TIPE as JENIS_DOKUMEN, A.TGL_NHI, B.KD_REQ, A.CREATED_AT,
		(case when E.NO_CONT is not null then E.NO_CONT
		when E.NO_CONT is NULL THEN 'Gatepass Behandle 2 Belum Dibuat'
		END) AS 'NO CONTAINER',
		CONCAT('<a style=\"color:blue;\">','Document : ' ,'</a>' ,(A.NO_DOK)) AS 'NO. DOKUMEN',
		CONCAT('Tanggal Dokumen : ', '<a style=\"color:red;\">',(A.TGL_DOK),'</a>') AS 'TGL DOKUMEN',
		CONCAT('Jenis Dokumen : ', '<a style=\"color:green;\">',(A.TIPE),'</a>') AS 'JENIS DOKUMEN',
		CONCAT('Tanggal NHI : ','<a style=\"color:red;\">',(A.TGL_NHI),'</a>') AS 'Tanggal NHI',
		(case when B.KD_REQ in('DRAFT','SENT','APPROVED','ERROR','REJECTED','INQUIRY','BYPASS','QUEUED') then '<span class=\"label label-success\">Dokumen Tersedia</span>' 
		when B.KD_REQ is NULL THEN '<span class=\"label label-danger\">Dokumen Belum Tersedia</span>'
		END) AS 'STATUS PENARIKAN',
		(case when D.NO_DOK is not null then '<span class=\"label label-success\">SUDAH SPK</span>' 
		when D.NO_DOK is NULL THEN '<span class=\"label label-danger\">Belum SPK</span>'
		END) AS 'STATUS SPK',
		(case when E.NO_DOK is not null then '<span class=\"label label-success\">Sudah Ada</span>' 
		when E.NO_DOK is NULL THEN '<span class=\"label label-danger\">Belum Ada</span>'
		END) AS 'STATUS GATEPASS',
		CONCAT('Waktu Layanan Online : ','<a style=\"color:red;\">',(A.CREATED_AT),'</a>') AS 'WAKTU LAYANAN ONLINE'
		from behandle2s A 
		left join (select a.ID, a.NO_DOK, a.TGL_DOK, a.JNS_DOK, a.KD_REQ, c.NAMA from t_request a inner join reff_kode_dok_bc c on c.ID = a.JNS_DOK) B on right(B.NO_DOK,6) = A.NO_DOK and B.TGL_DOK = A.TGL_DOK  
		left join (select c.ID, c.NO_DOK, c.TGL_DOK from t_spk_cont d inner join t_spk c on c.ID = d.ID) D on right(D.NO_DOK,6) = A.NO_DOK and D.TGL_DOK = A.TGL_DOK  
		left join (select e.ID,e.NO_CONT, e.NO_DOK, e.TGL_DOK, e.JNS_KEGIATAN from t_gatepass e where e.JNS_KEGIATAN='2') E on right(E.NO_DOK,6) = A.NO_DOK and E.TGL_DOK = A.TGL_DOK 
		where A.FL_STATUS ='N' and year(A.CREATED_AT) >= 2021";

		$proses = array('Lihat Dokumen'  => array('MODAL', "online/monitorOrderOnlinee/print", '1', '', 'md-eye', '', 'list'), 'TOLAK'  => array('MODAL', "online/monitorOrderOnlinee/add_data_tolak", '1', '', 'md-close-circle', '', 'list'), 'PROSES'  => array('MODAL', "online/monitorOrderOnlinee/add_data", '1', '', 'md-mail-send', '', 'list'));


		$this->newtable->multiple_searchh(true);
		$this->newtable->show_chk(false);
		$this->newtable->show_menu($check);
		$this->newtable->show_search(true);
		$this->newtable->search(array(array('A.NO_DOK', 'NO. DOKUMEN')));
		$this->newtable->action(site_url() . "/online/monitorOrderOnlinee");
		//$this->newtable->detail(array('POPUP',"display/ppkjoininspection/detail/"));
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array('ID', 'NO_CONT', 'NO_DOK', 'TGL_DOK', 'JENIS_DOKUMEN', 'TGL_NHI', 'KD_REQ', 'CREATED_AT'));
		$this->newtable->keys(array("ID"));
		$this->newtable->cidb($this->db);
		//$this->newtable->groupby(array("A.NO_DOK"));
		$this->newtable->orderby("A.ID");
		$this->newtable->sortby("desc");
		$this->newtable->set_formid("tblrespononline");
		$this->newtable->set_divid("divrespononline");
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

	public function getresponcustoms_white($type, $act, $id)
	{
		$page_title = "RESPON PPK";
		$title = "RESPON PPK";
		$this->newtable->breadcrumb('Dashboard', site_url(), 'icon-home');
		$this->newtable->breadcrumb('Customs', 'javascript:void(0)', '');
		$this->newtable->breadcrumb('PPK', 'javascript:void(0)', '');
		$check = (grant() == "W") ? true : false;
		$SQL = "SELECT DISTINCT C.ID,CASE WHEN K.no_antrian IS NOT NULL THEN CONCAT('<span class=\"label label-success\" style=\"font-size: large;\">',K.no_antrian,'</span>') END AS NO_URUT ,C.NO_DOK, CONCAT(C.NO_DOK,'<BR>', DATE_FORMAT(C.TGL_DOK, '%d-%m-%Y')) AS DOKUMEN, C.NAMA_CUST AS 'CUSTOMER',
		CASE
			WHEN C.RESPON IS NOT NULL AND C.WK_RESPON IS NOT NULL
				THEN '<span class=\"label label-success\">SUDAH PPK</span>'
			WHEN date(C.TGL_DOK) < date(NOW())
				THEN '<span class=\"label label-danger\">SEGERA DI RESPON</span>'
			WHEN date(C.TGL_DOK) = date(NOW())
				THEN '<span class=\"label label-warning\" style=\"visibility:hidden\">TANGGAL SUDAH MAU LEWAT</span>'
			ELSE
				'<span class=\"label label-success\" style=\"visibility:hidden\">TANGGAL MASIH SELAMAT</span>'
		END AS 'STATUS'
		FROM t_spk A
		INNER JOIN t_spk_cont B ON A.ID = B.ID
		INNER JOIN t_gatepass C ON B.NO_CONT = C.NO_CONT AND C.STATUS = 'WAITING' AND FL_ACTIVE='N'
		LEFT JOIN t_op_inspection D ON D.NO_CONT = B.NO_CONT AND C.NO_DOK = D.NO_DOK
		LEFT JOIN (select * from t_antrian_respon_ppk where reset = 'N') K ON C.ID = K.id_gatepass
		WHERE 1=1 AND A.JNS_DOK != 83 AND DATE(C.TGL_DOK) > DATE_ADD(NOW() , INTERVAL -4 MONTH) AND D.FINISH_INSP IS NULL AND A.KD_STATUS IN (100,400,200,000) AND B.STATUS_CONT NOT IN (500,540,520,800,850,870,900,901,902,950)" . $addsql . "";
		$proses = array('RESPON PPK'  => array('MODAL', "display/respon_custom_list/getrespon", '1', '', 'md-layers', '', 'list'), 'RESET ANTRIAN'  => array('GET', site_url() . "/display/resetantrian", '0', '', 'md-minus-circle', '', 'menu'));

		$this->newtable->multiple_search(true);
		$this->newtable->show_chk(false);
		$this->newtable->show_menu($check);
		$this->newtable->show_search(true);
		$this->newtable->search(array(array('C.NO_CONT', 'NO. KONTAINER'), array('C.NO_DOK', 'NO. DOKUMEN')));
		$this->newtable->action(site_url() . "/display/respon_custom_list");
		$this->newtable->detail(array('POPUP', "display/respon_custom_list/detail/"));
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("ID", "NO_DOK"));
		$this->newtable->keys(array("ID", "NO_DOK"));
		$this->newtable->cidb($this->db);
		$this->newtable->groupby(array("C.NO_DOK"));
		$this->newtable->orderby("C.RESPON IS NULL DESC,C.TGL_DOK asc");
		$this->newtable->sortby("");
		$this->newtable->set_formid("tblcustoms");
		$this->newtable->set_divid("divcustoms");
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

	public function monitoringresponrequestonlinee($type, $act, $id)
	{
		$page_title = "MONITORING REQUEST LAYANAN ONLINE";
		$title = "MONITORING REQUEST LAYANAN ONLINE";
		$this->newtable->breadcrumb('Dashboard', site_url(), 'icon-home');
		$this->newtable->breadcrumb('Planner', 'javascript:void(0)', '');
		$this->newtable->breadcrumb('Monitoring Layanan Online', 'javascript:void(0)', '');

		$check = (grant() == "W") ? true : false;

		$SQL = "SELECT distinct A.ID, A.NO_DOK, A.TGL_DOK, A.TYPE_DOK as JENIS_DOKUMEN, A.TGL_NHI, A.CREATED_AT,
		CONCAT('<a style=\"color:blue;\">','Document : ' ,'</a>' ,(A.NO_DOK)) AS 'NO. DOKUMEN',
		CONCAT('Tanggal Dokumen : ', '<a style=\"color:red;\">',(A.TGL_DOK),'</a>') AS 'TGL DOKUMEN',
		CONCAT('Jenis Dokumen : ', '<a style=\"color:green;\">',(A.TYPE_DOK),'</a>') AS 'JENIS DOKUMEN',
		CONCAT('Tanggal NHI : ','<a style=\"color:red;\">',(A.TGL_NHI),'</a>') AS 'Tanggal NHI',
		CONCAT('Waktu Layanan Online : ','<a style=\"color:red;\">',(A.CREATED_AT),'</a>') AS 'WAKTU LAYANAN ONLINE',
		(case when A.FL_STATUS ='Y' then '<span class=\"label label-success\">Approved</span>'
		when A.FL_STATUS ='X' THEN '<span class=\"label label-danger\">Tolak</span>'
		when A.FL_STATUS ='N' THEN '<span class=\"label label-danger\">Belum Approved</span>'
		END) AS 'LIST PROSES'
		from list_dokumens A 
		where  year(A.CREATED_AT) >= 2021";

		$proses = array('Lihat Dokumen'  => array('MODAL', "online/monitoring/print", '1', '', 'md-eye', '', 'list'));


		$this->newtable->multiple_searchh(true);
		$this->newtable->show_chk(false);
		$this->newtable->show_menu($check);
		$this->newtable->show_search(true);
		$this->newtable->search(array(array('A.NO_DOK', 'NO. DOKUMEN')));
		$this->newtable->action(site_url() . "/online/monitoring");
		//$this->newtable->detail(array('POPUP',"display/ppkjoininspection/detail/"));
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array('ID', 'NO_DOK', 'TGL_DOK', 'JENIS_DOKUMEN', 'TGL_NHI', 'KD_REQ', 'CREATED_AT'));
		$this->newtable->keys(array("ID"));
		$this->newtable->cidb($this->db);
		//$this->newtable->groupby(array("A.NO_DOK"));
		$this->newtable->orderby("A.ID");
		$this->newtable->sortby("desc");
		$this->newtable->set_formid("tblrespononline");
		$this->newtable->set_divid("divrespononline");
		$this->newtable->rowcount(30);
		$this->newtable->clear();
		$this->newtable->menu($proses);
		$tabel .= $this->newtable->generate($SQL);
		$arrdata = array("page_title" => $page_title, "title" => $title, "content" => $tabel);
		if ($this->input->post("ajax") || $act == "post")
			return $tabel;
		else
			return $arrdata;
	}

	public function getresponkarantina($type, $act, $id)
	{
		$page_title = "RESPON PKB";
		$title = "RESPON PKB";
		$this->newtable->breadcrumb('Dashboard', site_url(), 'icon-home');
		$this->newtable->breadcrumb('Customs', 'javascript:void(0)', '');
		$this->newtable->breadcrumb('PKB', 'javascript:void(0)', '');
		$check = (grant() == "W") ? true : false;

		if ($this->session->userdata('KD_GROUP') == 'BC') {
			$addsql = " AND B.STATUS_CONT IN(450,460,510,530) AND C.JNS_DOK !='SPPMP'";
			$proses = array(
				'PKB LONGROOM'  => array('POST', "display/respon_karantina/respon/pkb_longroom", 'all', '', 'md-layers', '', 'menu'),
				'PKB YARD'  => array('POST', "display/respon_karantina/respon/pkb_yard", 'all', '', 'md-navigation', '', 'menu'),
				'PKB YARD N'  => array('POST', "display/respon_karantina/respon/pkb_yardn", 'all', '', 'md-badge-check', '', 'menu')
			);
		} elseif ($this->session->userdata('KD_GROUP') == 'SPA') {
			$addsql = " AND B.STATUS_CONT IN(450,460,510,530)";
			$proses = array(
				'PKB LONGROOM'  => array('POST', "display/respon_karantina/respon/pkb_longroom", 'all', '', 'md-layers', '', 'menu'),
				'PKB YARD'  => array('POST', "display/respon_karantina/respon/pkb_yard", 'all', '', 'md-navigation', '', 'menu'),
				'PKB YARD N'  => array('POST', "display/respon_karantina/respon/pkb_yardn", 'all', '', 'md-badge-check', '', 'menu'),
				'PKB PERCEPATAN'  => array('POST', "display/respon_karantina/respon/pkb_percepatan", 'all', '', 'md-layers', '', 'menu')
			);
		} else {
			$addsql = " AND B.STATUS_CONT IN(450,460,510,530)";
			$proses = array('PKB PERCEPATAN'  => array('POST', "display/respon_karantina/respon/pkb_percepatan", 'all', '', 'md-layers', '', 'menu'));
		}


		$SQL = "SELECT DISTINCT C.ID, C.JNS_DOK AS 'JENIS DOKUMEN', C.NO_DOK, DATE_FORMAT(C.TGL_DOK, '%d-%m-%Y') AS 'TGL_DOK', B.NO_CONT, B.UKR_CONT AS 'SIZE', CONCAT(B.LOKASI,B.TIER) AS LOKASI, CONCAT('BEHANDLE ',C.JNS_KEGIATAN) AS 'KETERANGAN', C.NAMA_CUST AS 'CUSTOMER',
					CASE
						WHEN B.STATUS_CONT IN (450,510,530) AND D.START_INSP IS NULL AND D.FINISH_INSP IS NULL AND C.RESPON IS NULL THEN '<span class=\"label label-danger\">BELUM PKB</span>'
						WHEN B.STATUS_CONT IN (450,510,530) AND D.START_INSP IS NULL AND D.FINISH_INSP IS NULL AND C.RESPON IS NOT NULL THEN '<span class=\"label label-danger\">PKB</span>'
						WHEN B.STATUS_CONT = 460 AND D.START_INSP IS NULL AND D.FINISH_INSP IS NULL  AND C.RESPON IS NOT NULL THEN '<span class=\"label label-warning\">SIAP PERIKSA</span>'
						WHEN B.STATUS_CONT = 460 AND D.START_INSP IS NOT NULL AND D.FINISH_INSP IS NULL THEN '<span class=\"label label-primary\">SEDANG PERIKSA</span>' 
						WHEN B.STATUS_CONT IN (500,540,520) THEN '<span class=\"label label-success\">SELESAI PERIKSA</span>' 
						WHEN B.STATUS_CONT IN (800,850,870,900,901,902,950) THEN '<span class=\"label label-success\">DELIVERY</span>'
						ELSE '<span class=\"label label-success\">SELESAI PERIKSA</span>'  
					END AS STATUS, 
					CONCAT('RESPON :',
						CASE 
							WHEN C.RESPON = 'PKB' THEN '<span style=\"color:green;font-weight:bold\">PKB</span>'
							ELSE '<span style=\"color:red;font-weight:bold\">PERCEPATAN</span>'
						END,'<BR>','TANGGAL PKB :',DATE_FORMAT(C.WK_RESPON, '%d-%m-%Y %h:%i:%s')
					)AS PKB
				FROM t_spk A
				INNER JOIN t_spk_cont B ON A.ID = B.ID
				INNER JOIN t_gatepass C ON B.NO_CONT = C.NO_CONT AND C.STATUS = 'WAITING' AND C.FL_ACTIVE = 'Y'
				LEFT JOIN t_op_inspection D ON D.NO_CONT = B.NO_CONT AND C.NO_DOK = D.NO_DOK
				WHERE C.JNS_DOK != 'SPJM' " . $addsql . "";
		$this->newtable->multiple_search(true);
		$this->newtable->show_chk($check);
		$this->newtable->show_menu($check);
		$this->newtable->show_search(true);
		$this->newtable->search(array(array('B.NO_CONT', 'NO. KONTAINER'), array('C.NO_DOK', 'NO. DOKUMEN')));
		$this->newtable->action(site_url() . "/display/respon_karantina");
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("ID", "NO_DOK"));
		$this->newtable->keys(array("ID", "NO_DOK"));
		$this->newtable->cidb($this->db);
		$this->newtable->groupby("");
		$this->newtable->orderby("CASE WHEN B.STATUS_CONT IN (450,510,530) AND C.RESPON IS NULL THEN 1 WHEN B.STATUS_CONT IN (450,510,530) AND C.RESPON IS NOT NULL THEN 2 WHEN B.STATUS_CONT = 460 AND D.START_INSP IS NULL AND D.FINISH_INSP IS NULL  AND C.RESPON IS NOT NULL THEN 3 WHEN B.STATUS_CONT = 460 AND D.START_INSP IS NOT NULL AND D.FINISH_INSP IS NULL THEN 4 ELSE 5 END ASC, C.WK_RESPON ASC,C.WK_ACTIVE ASC");
		$this->newtable->sortby("");
		$this->newtable->set_formid("tblcustoms");
		$this->newtable->set_divid("divcustoms");
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

	public function pergerakan($act, $id)
	{
		$page_title = "RESPON PPK";
		$title = "RESPON PPK";
		$this->newtable->breadcrumb('Dashboard', site_url(), 'icon-home');
		$this->newtable->breadcrumb('Customs', 'javascript:void(0)', '');
		$this->newtable->breadcrumb('PPK', 'javascript:void(0)', '');
		$check = (grant() == "W") ? true : false;
		if ($this->session->userdata('KD_GROUP') == "USR") {
			if ($this->input->post("ajax")) {
				$VAR = 1;
			} else {
				$VAR = 0;
			}
		} else {
			$VAR = 1;
		}
		// $SQL = "SELECT DISTINCT C.ID,CASE WHEN K.no_antrian IS NOT NULL THEN CONCAT('<span class=\"label label-success\">',K.no_antrian,'</span>') END AS NO_URUT, C.JNS_DOK AS 'JENIS DOKUMEN', C.NO_DOK AS DOKUMEN, C.TGL_DOK AS 'TANGGAL DOKUMEN', C.NAMA_CUST AS 'CUSTOMER', C.NO_CONT AS 'KONTAINER', B.UKR_CONT AS 'SIZE',
		// CASE
		// 	WHEN B.STATUS_CONT IN (450,510,530) AND D.START_INSP IS NULL AND D.FINISH_INSP IS NULL AND C.RESPON IS NULL THEN '<span class=\"label label-danger\">BELUM PPK</span>'
		// 	WHEN B.STATUS_CONT IN (450,510,530) AND D.START_INSP IS NULL AND D.FINISH_INSP IS NULL AND C.RESPON IS NOT NULL THEN '<span class=\"label label-danger\">PPK</span>'
		// 	WHEN B.STATUS_CONT = 460 AND D.START_INSP IS NULL AND D.FINISH_INSP IS NULL  AND C.RESPON IS NOT NULL THEN '<span class=\"label label-warning\">SIAP PERIKSA</span>'
		// 	WHEN B.STATUS_CONT = 460 AND D.START_INSP IS NOT NULL AND D.FINISH_INSP IS NULL THEN '<span class=\"label label-primary\">SEDANG PERIKSA</span>' 
		// 	WHEN B.STATUS_CONT IN (500,540,520) THEN '<span class=\"label label-success\">SELESAI PERIKSA</span>' 
		// 	WHEN B.STATUS_CONT IN (800,850,870,900,901,902,950) THEN '<span class=\"label label-success\">DELIVERY</span>'
		// 	ELSE '<span class=\"label label-success\">SELESAI PERIKSA</span>' 
		// END AS STATUS, 
		// CASE 
		// 	WHEN C.RESPON = 'PPK LONGROOM' 
		// 		THEN '<span style=\"color:green;font-weight:bold\">LONGROOM</span>'
		// 	WHEN C.RESPON = 'PKK YARD' 
		// 		THEN '<span style=\"color:green;font-weight:bold\">YARD</span>'
		// 	WHEN C.RESPON = 'NO PPK' 
		// 		THEN '<span style=\"color:green;font-weight:bold\">NO PPK</span>'
		// 	WHEN C.RESPON = 'PERIKSA ULANG' 
		// 		THEN '<span style=\"color:green;font-weight:bold\">PERIKSA ULANG</span>'
		// 	WHEN C.RESPON = 'PERIKSA TAMBAHAN' 
		// 		THEN '<span style=\"color:green;font-weight:bold\">PERIKSA TAMBAHAN</span>'
		// 	WHEN C.RESPON = 'NHI' 
		// 		THEN '<span style=\"color:green;font-weight:bold\">NHI</span>'
		// 	WHEN C.RESPON = 'RETURNABLE PACKAGE(RP)' 
		// 		THEN '<span style=\"color:green;font-weight:bold\">RETURNABLE PACKAGE(RP)</span>'
		// 	WHEN C.RESPON = 'PIBK' 
		// 		THEN '<span style=\"color:green;font-weight:bold\">PIBK</span>'
		// 	WHEN C.RESPON = 'PKB' 
		// 		THEN '<span style=\"color:green;font-weight:bold\">PKB</span>'
		// 	ELSE '<span style=\"color:red;font-weight:bold\">PERCEPATAN</span>'
		// END AS 'RESPON PPK',
		// C.WK_RESPON AS 'WAKTU PPK',
		// IF(B.LOKASI IS NULL OR B.STATUS_CONT = 900, 'DELIVERY', CONCAT(B.LOKASI, B.TIER)) AS LOKASI
		// FROM t_spk A
		// INNER JOIN t_spk_cont B ON A.ID = B.ID
		// INNER JOIN t_gatepass C ON B.NO_CONT = C.NO_CONT AND C.FL_ACTIVE = 'Y' AND C.JNS_DOK !='SPPMP'
		// LEFT JOIN t_op_inspection D ON D.NO_CONT = B.NO_CONT AND C.NO_DOK = D.NO_DOK
		// LEFT JOIN (select * from t_antrian_respon_ppk where reset = 'N') K ON C.ID = K.id_gatepass
		// WHERE 1 = $VAR C.RESPON IS NOT NULL";

		// QUERY BELUM ADA TYPE NYA 21-07-2020
		// $SQL = "SELECT ID,no_antrian  'NO URUT',NO_CONT 'NO_KONTAINER',UKR_CONT 'UKURAN',TGL_DOK 'TANGGAL DOKUMEN',JNS_DOK 'JENIS',NO_DOK 'NO_DOKUMEN',LOKASI 'LOKASI',KEGIATAN,NAMA_CUST 'COSTUMER',
		// CASE 
		// 	WHEN STATUS2 = 1 THEN 'SIAP PERIKSA'
		// 	WHEN STATUS2 = 2 THEN 'PPK'
		// 	WHEN STATUS2 = 3 THEN 'BELUM PPK'
		// 	WHEN STATUS2 = 4 THEN 'SEDANG PERIKSA'
		// 	WHEN STATUS2 = 5 THEN 'WAITING'
		// 	WHEN STATUS2 = 6 THEN 'SELESAI PERIKSA' 
		// END 'STATUS',NOTE,
		// START_INSP 'START PERIKSA',FINISH_INSP 'FINISH PERIKSA',RESPON,WK_RESPON 'WAKTU RESPON',STATUS2 
		// FROM (SELECT a.ID,k.no_antrian,a.NO_CONT,a.UKR_CONT,a.TGL_DOK,a.JNS_DOK,a.`STATUS`,a.NO_DOK,b.LOKASI,CONCAT('BEHANDLE ',a.JNS_KEGIATAN) KEGIATAN,a.NAMA_CUST,b.STATUS_CONT,d.START_INSP,d.FINISH_INSP,a.RESPON,a.WK_RESPON,
		// CASE
		// 	WHEN b.STATUS_CONT IN (450,510,530) AND d.START_INSP IS NULL AND d.FINISH_INSP IS NULL AND a.RESPON IS NULL THEN 3
		// 	WHEN b.STATUS_CONT IN (450,510,530) AND d.START_INSP IS NULL AND d.FINISH_INSP IS NULL AND a.RESPON IS NOT NULL THEN 2
		// 	WHEN b.STATUS_CONT = 460 AND d.START_INSP IS NULL AND d.FINISH_INSP IS NULL  AND a.RESPON IS NOT NULL THEN 1
		// 	WHEN b.STATUS_CONT = 460 AND d.START_INSP IS NOT NULL AND d.FINISH_INSP IS NULL THEN 4
		// 	WHEN b.STATUS_CONT IN (500,540,520) THEN 6 
		// 	ELSE 5 
		// END AS STATUS2,s.NOTE 
		// FROM t_gatepass a
		// left JOIN (SELECT * FROM t_spk_cont WHERE STATUS_CONT != 900) b on a.NO_CONT = b.NO_CONT 
		// JOIN t_spk c ON c.ID = b.ID
		// LEFT JOIN t_op_inspection d ON a.NO_CONT = d.NO_CONT AND a.NO_DOK = d.NO_DOK
		// LEFT JOIN (select * from t_antrian_respon_ppk where reset = 'N') k ON a.ID = k.id_gatepass
		// LEFT JOIN t_job_slip s ON c.NO_SPK = s.NO_SPK AND a.NO_CONT = s.NO_CONT AND s.JENIS = CONCAT('BEHANDLE ',a.JNS_KEGIATAN)
		// WHERE  a.JNS_KEGIATAN  != 3 AND a.`STATUS` = 'WAITING'  AND a.JNS_DOK != 'SPPMP') az WHERE 1 = 1";

		//QUERY UDAH ADA TYPENYA 
		$SQL1 = "SELECT ID,no_antrian  'NO URUT',NO_CONT 'NO_KONTAINER',UKR_CONT 'UKURAN', tipe 'TYPE',TGL_DOK 'TANGGAL DOKUMEN',JNS_DOK 'JENIS',NO_DOK 'NO_DOKUMEN',LOKASI 'LOKASI',KEGIATAN,NAMA_CUST 'COSTUMER',
		CASE 
			WHEN STATUS2 = 1 THEN 'SIAP PERIKSA'
			WHEN STATUS2 = 2 THEN 'PPK'
			WHEN STATUS2 = 3 THEN 'BELUM PPK'
			WHEN STATUS2 = 4 THEN 'SEDANG PERIKSA'
			WHEN STATUS2 = 5 THEN 'WAITING'
			WHEN STATUS2 = 6 THEN 'SELESAI PERIKSA' 
		END 'STATUS',NOTE,
		START_INSP 'START PERIKSA',FINISH_INSP 'FINISH PERIKSA',RESPON,WK_RESPON 'WAKTU RESPON',STATUS2 
		FROM (SELECT a.ID,k.no_antrian,a.NO_CONT,a.UKR_CONT,a.TGL_DOK,a.JNS_DOK,a.`STATUS`,a.NO_DOK,b.LOKASI,CONCAT('BEHANDLE ',a.JNS_KEGIATAN) KEGIATAN,a.NAMA_CUST,b.STATUS_CONT,d.START_INSP,d.FINISH_INSP,a.RESPON,a.WK_RESPON,
		CASE
			WHEN b.STATUS_CONT IN (450,510,530) AND d.START_INSP IS NULL AND d.FINISH_INSP IS NULL AND a.RESPON IS NULL THEN 3
			WHEN b.STATUS_CONT IN (450,510,530) AND d.START_INSP IS NULL AND d.FINISH_INSP IS NULL AND a.RESPON IS NOT NULL THEN 2
			WHEN b.STATUS_CONT = 460 AND d.START_INSP IS NULL AND d.FINISH_INSP IS NULL  AND a.RESPON IS NOT NULL THEN 1
			WHEN b.STATUS_CONT = 460 AND d.START_INSP IS NOT NULL AND d.FINISH_INSP IS NULL THEN 4
			WHEN b.STATUS_CONT IN (500,540,520) THEN 6 
			ELSE 5 
		END AS STATUS2,s.NOTE,t.tipe_cont AS tipe 
		FROM t_gatepass a
		left JOIN (SELECT * FROM t_spk_cont WHERE STATUS_CONT != 900) b on a.NO_CONT = b.NO_CONT 
		JOIN t_spk c ON c.ID = b.ID
		LEFT JOIN t_op_inspection d ON a.NO_CONT = d.NO_CONT AND a.NO_DOK = d.NO_DOK
		LEFT JOIN (select * from t_antrian_respon_ppk where reset = 'N') k ON a.ID = k.id_gatepass
		LEFT JOIN t_job_slip s ON c.NO_SPK = s.NO_SPK AND a.NO_CONT = s.NO_CONT AND s.JENIS = CONCAT('BEHANDLE ',a.JNS_KEGIATAN)
		LEFT JOIN (SELECT a.id, a.no_dok, a.tgl_dok, b.NO_CONT, b.UKR_CONT, b.tipe_cont
						FROM t_request a
						JOIN t_request_cont b ON a.id = b.id ) t ON c.NO_DOK = t.no_dok AND t.no_cont = a.no_cont
		WHERE  a.JNS_KEGIATAN  != 3 AND a.`STATUS` = 'WAITING'  AND a.JNS_DOK != 'SPPMP') az WHERE 1 = 1";

		$SQL2 = "SELECT ID,no_antrian  'NO URUT',NO_CONT 'NO_KONTAINER',UKR_CONT 'UKURAN', tipe 'TYPE',TGL_DOK 'TANGGAL DOKUMEN',JNS_DOK 'JENIS',NO_DOK 'NO_DOKUMEN',LOKASI 'LOKASI',KEGIATAN,NAMA_CUST 'COSTUMER',
		CASE 
			WHEN STATUS2 = 1 THEN 'SIAP PERIKSA'
			WHEN STATUS2 = 2 THEN 'PPK'
			WHEN STATUS2 = 3 THEN 'BELUM PPK'
			WHEN STATUS2 = 4 THEN 'SEDANG PERIKSA'
			WHEN STATUS2 = 5 THEN 'WAITING'
			WHEN STATUS2 = 6 THEN 'SELESAI PERIKSA' 
		END 'STATUS',NOTE,
		START_INSP 'START PERIKSA',WK_STATUS 'SIAP PERIKSA',RESPON,WK_RESPON 'WAKTU RESPON',STATUS2 
		FROM (SELECT a.ID,k.no_antrian,n.wk_status,a.NO_CONT,a.UKR_CONT,a.TGL_DOK,a.JNS_DOK,a.`STATUS`,a.NO_DOK,b.LOKASI,CONCAT('BEHANDLE ',a.JNS_KEGIATAN) KEGIATAN,a.NAMA_CUST,b.STATUS_CONT,d.START_INSP,d.FINISH_INSP,a.RESPON,a.WK_RESPON,
		CASE
			WHEN b.STATUS_CONT IN (450,510,530) AND d.START_INSP IS NULL AND d.FINISH_INSP IS NULL AND a.RESPON IS NULL THEN 3
			WHEN b.STATUS_CONT IN (450,510,530) AND d.START_INSP IS NULL AND d.FINISH_INSP IS NULL AND a.RESPON IS NOT NULL THEN 2
			WHEN b.STATUS_CONT = 460 AND d.START_INSP IS NULL AND d.FINISH_INSP IS NULL  AND a.RESPON IS NOT NULL THEN 1
			WHEN b.STATUS_CONT = 460 AND d.START_INSP IS NOT NULL AND d.FINISH_INSP IS NULL THEN 4
			WHEN b.STATUS_CONT IN (500,540,520) THEN 6 
			ELSE 5 
		END AS STATUS2,s.NOTE,t.tipe_cont AS tipe 
		FROM t_gatepass a
		left JOIN (SELECT * FROM t_spk_cont WHERE STATUS_CONT != 900) b on a.NO_CONT = b.NO_CONT 
		JOIN t_spk c ON c.ID = b.ID
		LEFT JOIN t_op_inspection d ON a.NO_CONT = d.NO_CONT AND a.NO_DOK = d.NO_DOK
		LEFT JOIN (select * from t_antrian_respon_ppk where reset = 'N') k ON a.ID = k.id_gatepass
		LEFT JOIN t_job_slip s ON c.NO_SPK = s.NO_SPK AND a.NO_CONT = s.NO_CONT AND s.JENIS = CONCAT('BEHANDLE ',a.JNS_KEGIATAN)
		left join (SELECT NO_CONT, NO_DOK, NO_GATEPASS, LOKASI_AKHIR, WK_STATUS FROM t_job_slip A WHERE SUBSTRING(A.LOKASI_AKHIR, 1, 3) = 'CIC') n on n.no_cont = a.NO_CONT and n.no_dok = a.no_dok
		LEFT JOIN (SELECT a.id, a.no_dok, a.tgl_dok, b.NO_CONT, b.UKR_CONT, b.tipe_cont
						FROM t_request a
						JOIN t_request_cont b ON a.id = b.id ) t ON c.NO_DOK = t.no_dok AND t.no_cont = a.no_cont
		WHERE  a.JNS_KEGIATAN  != 3 AND a.`STATUS` = 'WAITING'  AND a.JNS_DOK != 'SPPMP') az WHERE 1 = 1";

		if ($this->session->userdata('KD_GROUP') == "BC") {
			$SQL = $SQL2;
		} else {
			$SQL = $SQL1;
		}

		$q2 = $this->db->query("SELECT STATUS,COUNT(ID) JML FROM (SELECT ID,no_antrian  'NO URUT',NO_CONT 'NO_KONTAINER',UKR_CONT 'UKURAN',TGL_DOK 'TANGGAL DOKUMEN',JNS_DOK 'JENIS',NO_DOK 'NO_DOKUMEN',LOKASI 'LOKASI',KEGIATAN,NAMA_CUST 'COSTUMER',
		CASE 
			WHEN STATUS2 = 1 THEN 'SIAP PERIKSA'
			WHEN STATUS2 = 2 THEN 'PPK'
			WHEN STATUS2 = 3 THEN 'BELUM PPK'
			WHEN STATUS2 = 4 THEN 'SEDANG PERIKSA'
			WHEN STATUS2 = 5 THEN 'WAITING'
			WHEN STATUS2 = 6 THEN 'SELESAI PERIKSA' 
		END 'STATUS',
		START_INSP 'START PERIKSA',FINISH_INSP 'FINISH PERIKSA',RESPON,WK_RESPON 'WAKTU RESPON',STATUS2 
		FROM (SELECT a.ID,k.no_antrian,a.NO_CONT,a.UKR_CONT,a.TGL_DOK,a.JNS_DOK,a.`STATUS`,a.NO_DOK,b.LOKASI,CONCAT('BEHANDLE ',a.JNS_KEGIATAN) KEGIATAN,a.NAMA_CUST,b.STATUS_CONT,d.START_INSP,d.FINISH_INSP,a.RESPON,a.WK_RESPON,
		CASE
			WHEN b.STATUS_CONT IN (450,510,530) AND d.START_INSP IS NULL AND d.FINISH_INSP IS NULL AND a.RESPON IS NULL THEN 3
			WHEN b.STATUS_CONT IN (450,510,530) AND d.START_INSP IS NULL AND d.FINISH_INSP IS NULL AND a.RESPON IS NOT NULL THEN 2
			WHEN b.STATUS_CONT = 460 AND d.START_INSP IS NULL AND d.FINISH_INSP IS NULL  AND a.RESPON IS NOT NULL THEN 1
			WHEN b.STATUS_CONT = 460 AND d.START_INSP IS NOT NULL AND d.FINISH_INSP IS NULL THEN 4
			WHEN b.STATUS_CONT IN (500,540,520) THEN 6 
			ELSE 5 
		END AS STATUS2 
		FROM t_gatepass a
		left JOIN (SELECT * FROM t_spk_cont WHERE STATUS_CONT != 900) b on a.NO_CONT = b.NO_CONT 
		JOIN t_spk c ON c.ID = b.ID
		LEFT JOIN t_op_inspection d ON a.NO_CONT = d.NO_CONT AND a.NO_DOK = d.NO_DOK
		LEFT JOIN (select * from t_antrian_respon_ppk where reset = 'N') k ON a.ID = k.id_gatepass
		WHERE  a.JNS_KEGIATAN  != 3 AND a.`STATUS` = 'WAITING'  AND a.JNS_DOK != 'SPPMP') az WHERE 1 = 1) ass
		GROUP BY status")->result();

		$jsiapperiksa = 0;
		$jppk = 0;
		$jbelumppk = 0;
		$jwaiting = 0;
		$jsedang = 0;
		$jselesai = 0;

		foreach ($q2 as $key => $v) {
			if ($v->STATUS == 'BELUM PPK') {
				$jbelumppk = $v->JML;
			}
			if ($v->STATUS == 'PPK') {
				$jppk = $v->JML;
			}
			if ($v->STATUS == 'SEDANG PERIKSA') {
				$jsedang = $v->JML;
			}
			if ($v->STATUS == 'SELESAI PERIKSA') {
				$jselesai = $v->JML;
			}
			if ($v->STATUS == 'SIAP PERIKSA') {
				$jsiapperiksa = $v->JML;
			}
			if ($v->STATUS == 'WAITING') {
				$jwaiting = $v->JML;
			}
		}

		if ($this->session->userdata('KD_GROUP') == "BC") {
			$proses = array(
				'siap periksa'  => array('GET', '', '2', '', '#76ff03', 'Siap Periksa : ' . $jsiapperiksa . '', 'ycustom'),
				'ppk'  => array('GET', '', '2', '', 'red', 'PPK : ' . $jppk . '', 'ycustom'),
				'belum ppk'  => array('GET', '', '2', '', '#9aa58c', 'Belum PPK : ' . $jbelumppk . '', 'ycustom'),
				'waiting'  => array('GET', '', '2', '', '#ffee33', 'Waiting List : ' . $jwaiting . '', 'ycustom'),
				'sedang periksa'  => array('GET', '', '2', '', '#33bfff', 'Sedang Periksa : ' . $jsedang . '', 'ycustom'),
				'selesai periksa'  => array('GET', '', '2', '', '#2a3eb1', 'Selesai Periksa : ' . $jselesai . '', 'ycustom'),
				'Set Sedang Periksa' => array('POST', "display/pergerakan/setpemeriksaan", '1', '', 'md-badge-check', '', 'list')
			);
		} else {
			$proses = array(
				'siap periksa'  => array('GET', '', '2', '', '#76ff03', 'Siap Periksa : ' . $jsiapperiksa . '', 'ycustom'),
				'ppk'  => array('GET', '', '2', '', 'red', 'PPK : ' . $jppk . '', 'ycustom'),
				'belum ppk'  => array('GET', '', '2', '', '#9aa58c', 'Belum PPK : ' . $jbelumppk . '', 'ycustom'),
				'waiting'  => array('GET', '', '2', '', '#ffee33', 'Waiting List : ' . $jwaiting . '', 'ycustom'),
				'sedang periksa'  => array('GET', '', '2', '', '#33bfff', 'Sedang Periksa : ' . $jsedang . '', 'ycustom'),
				'selesai periksa'  => array('GET', '', '2', '', '#2a3eb1', 'Selesai Periksa : ' . $jselesai . '', 'ycustom')
			);
		}

		$this->newtable->multiple_search(true);
		$this->newtable->show_chk(false);
		$this->newtable->show_menu($check);
		$this->newtable->show_search(true);
		$this->newtable->search(array(array('az.NO_DOK', 'NO. DOKUMEN'), array('az.TGL_DOK', 'TGL. DOKUMEN', 'DATERANGE'), array('az.NO_CONT', 'NO. KONTAINER')));
		$this->newtable->action(site_url() . "/display/pergerakan");
		$this->newtable->detail(array('DRILLDOWN', "display/pergerakan/detail"));
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("ID", "STATUS2"));
		$this->newtable->keys(array("ID", "NO_DOKUMEN", "NO_KONTAINER"));
		$this->newtable->cidb($this->db);
		$this->newtable->groupby();
		//$this->newtable->orderby("CASE WHEN B.STATUS_CONT IN (450,510,530) AND D.START_INSP IS NULL AND D.FINISH_INSP IS NULL AND C.RESPON IS NULL THEN 3 WHEN B.STATUS_CONT IN (450,510,530) AND D.START_INSP IS NULL AND D.FINISH_INSP IS NULL AND C.RESPON IS NOT NULL THEN 2 WHEN B.STATUS_CONT = 460 AND D.START_INSP IS NULL AND D.FINISH_INSP IS NULL AND C.RESPON IS NOT NULL THEN 1 WHEN B.STATUS_CONT = 460 AND D.START_INSP IS NOT NULL AND D.FINISH_INSP IS NULL THEN 4 WHEN B.STATUS_CONT IN (500,540,520) THEN 5 WHEN B.STATUS_CONT IN (800,850,870,900,901,902,950) THEN 6 ELSE 7 END ASC, C.WK_RESPON ASC,C.WK_ACTIVE ASC");
		$this->newtable->orderby("STATUS2,WK_RESPON");
		$this->newtable->sortby("");
		$this->newtable->set_formid("tblcustomspergerakan");
		$this->newtable->set_divid("divcustomspergerakan");
		$this->newtable->rowcount(50);
		$this->newtable->clear();
		$this->newtable->menu($proses);
		$tabel .= $this->newtable->generate_custom($SQL);
		$arrdata = array("page_title" => $page_title, "title" => $title, "content" => $tabel);
		if ($this->input->post("ajax") || $act == "post")
			return $tabel;
		else
			return $arrdata;
	}

	public function set_pemeriksaan($iddd)
	{

		$NO_CONT = $iddd;

		$SQL_SPK_CONT    = $this->db->query("SELECT A.*, B.* FROM t_spk_cont A INNER JOIN t_spk B ON A.ID = B.ID WHERE A.NO_CONT ='" . $NO_CONT . "' AND A.STATUS_CONT = '460' ORDER BY A.ID DESC")->row_array();

		$SQL_PEMERIKSAAN = $this->db->query("SELECT * FROM t_op_inspection WHERE NO_CONT = '" . $NO_CONT . "' AND NO_SPK='" . $SQL_SPK_CONT['NO_SPK'] . "' ORDER BY ID DESC LIMIT 1")->row_array();

		$SQL_KODE_DOK	 = $this->db->query("SELECT * FROM reff_kode_dok_bc WHERE ID='" . $SQL_SPK_CONT['JNS_DOK'] . "'")->row_array();

		$SQL_GATEPASS 	 = $this->db->query("SELECT * FROM t_gatepass WHERE NO_CONT ='" . $NO_CONT . "' AND JNS_DOK = '" . $SQL_KODE_DOK['NAMA'] . "' AND NO_DOK = '" . $SQL_SPK_CONT['NO_DOK'] . "' AND TGL_DOK ='" . $SQL_SPK_CONT['TGL_DOK'] . "' AND JNS_KEGIATAN IN('1','2') ORDER BY ID DESC LIMIT 1")->row_array();

		$SQL_JOBSLIP = $this->db->query("SELECT * FROM t_job_slip WHERE NO_CONT = '" . $NO_CONT . "' AND NO_SPK = '" . $SQL_SPK_CONT['NO_SPK'] . "' ORDER BY ID_JOB_SLIP DESC LIMIT 1")->row_array();

		if ($SQL_SPK_CONT['NO_CONT'] == $NO_CONT) {
			if ($SQL_SPK_CONT['STATUS_CONT'] == '460') {
				if ($SQL_PEMERIKSAAN == NULL) {
					/* START INSPECTION */
					// $startinsp= array(
					// 	'NO_CONT' 		 => $NO_CONT,
					// 	'OPERATOR_START' => $this->session->userdata('USERLOGIN'),
					// 	'LOKASI' 		 => $SQL_SPK_CONT['LOKASI'].'0'.$SQL_SPK_CONT['TIER'],
					// 	'JNS_KEGIATAN' 	 => $SQL_GATEPASS['JNS_KEGIATAN'],
					// 	'NO_DOK' 		 => $SQL_SPK_CONT['NO_DOK'],
					// 	'JNS_DOK' 		 => $SQL_KODE_DOK['NAMA'],
					// 	'TGL_DOK' 		 => $SQL_SPK_CONT['TGL_DOK'],
					// 	'NO_SPK' 		 => $SQL_SPK_CONT['NO_SPK'],
					// 	'START_INSP' 	 => date('Y-m-d H:i:s')
					// );
					// $this->db->insert('t_op_inspection',$startinsp);

					// /* UPDATE TABEL OPERATION */
					// $this->db->where(array('NO_CONT' => $NO_CONT, 'NO_SPK' =>  $SQL_SPK_CONT['NO_SPK']));
					// $this->db->update('t_operation',array('WK_START' => date('Y-m-d H:i:s')));

					//echo "MSG#OK#Berhasil Menjadikan Siap Periksa#".base_url()."application.php/display/pergerakan";
					redirect('display/pergerakan');
				} else {
					/* FINISH INSPECTION */
					echo 'MSG#ERR#Sudah dalam Posisi Siap Periksa';
				}
			} else {
				echo 'MSG#ERR#Belum Di CIC';
			}
		} else {
			echo 'MSG#ERR#Tidak dalam posisi siap periksa';
		}

		//echo $message;
		//redirect('display/pergerakan');
	}

	public function pergerakanplanner($act, $id)
	{
		$page_title = "RESPON PPK";
		$title = "RESPON PPK";
		$this->newtable->breadcrumb('Dashboard', site_url(), 'icon-home');
		$this->newtable->breadcrumb('Customs', 'javascript:void(0)', '');
		$this->newtable->breadcrumb('PPK', 'javascript:void(0)', '');
		$check = (grant() == "W") ? true : false;
		if ($this->session->userdata('KD_GROUP') == "USR") {
			if ($this->input->post("ajax")) {
				$VAR = 1;
			} else {
				$VAR = 0;
			}
		} else {
			$VAR = 1;
		}
		// $SQL = "SELECT DISTINCT C.ID,CASE WHEN K.no_antrian IS NOT NULL THEN CONCAT('<span class=\"label label-success\">',K.no_antrian,'</span>') END AS NO_URUT, C.JNS_DOK AS 'JENIS DOKUMEN', C.NO_DOK AS DOKUMEN, C.TGL_DOK AS 'TANGGAL DOKUMEN', C.NAMA_CUST AS 'CUSTOMER', C.NO_CONT AS 'KONTAINER', B.UKR_CONT AS 'SIZE',
		// CASE
		// 	WHEN B.STATUS_CONT IN (450,510,530) AND D.START_INSP IS NULL AND D.FINISH_INSP IS NULL AND C.RESPON IS NULL THEN '<span class=\"label label-danger\">BELUM PPK</span>'
		// 	WHEN B.STATUS_CONT IN (450,510,530) AND D.START_INSP IS NULL AND D.FINISH_INSP IS NULL AND C.RESPON IS NOT NULL THEN '<span class=\"label label-danger\">PPK</span>'
		// 	WHEN B.STATUS_CONT = 460 AND D.START_INSP IS NULL AND D.FINISH_INSP IS NULL  AND C.RESPON IS NOT NULL THEN '<span class=\"label label-warning\">SIAP PERIKSA</span>'
		// 	WHEN B.STATUS_CONT = 460 AND D.START_INSP IS NOT NULL AND D.FINISH_INSP IS NULL THEN '<span class=\"label label-primary\">SEDANG PERIKSA</span>' 
		// 	WHEN B.STATUS_CONT IN (500,540,520) THEN '<span class=\"label label-success\">SELESAI PERIKSA</span>' 
		// 	WHEN B.STATUS_CONT IN (800,850,870,900,901,902,950) THEN '<span class=\"label label-success\">DELIVERY</span>'
		// 	ELSE '<span class=\"label label-success\">SELESAI PERIKSA</span>' 
		// END AS STATUS, 
		// CASE 
		// 	WHEN C.RESPON = 'PPK LONGROOM' 
		// 		THEN '<span style=\"color:green;font-weight:bold\">LONGROOM</span>'
		// 	WHEN C.RESPON = 'PKK YARD' 
		// 		THEN '<span style=\"color:green;font-weight:bold\">YARD</span>'
		// 	WHEN C.RESPON = 'NO PPK' 
		// 		THEN '<span style=\"color:green;font-weight:bold\">NO PPK</span>'
		// 	WHEN C.RESPON = 'PERIKSA ULANG' 
		// 		THEN '<span style=\"color:green;font-weight:bold\">PERIKSA ULANG</span>'
		// 	WHEN C.RESPON = 'PERIKSA TAMBAHAN' 
		// 		THEN '<span style=\"color:green;font-weight:bold\">PERIKSA TAMBAHAN</span>'
		// 	WHEN C.RESPON = 'NHI' 
		// 		THEN '<span style=\"color:green;font-weight:bold\">NHI</span>'
		// 	WHEN C.RESPON = 'RETURNABLE PACKAGE(RP)' 
		// 		THEN '<span style=\"color:green;font-weight:bold\">RETURNABLE PACKAGE(RP)</span>'
		// 	WHEN C.RESPON = 'PIBK' 
		// 		THEN '<span style=\"color:green;font-weight:bold\">PIBK</span>'
		// 	WHEN C.RESPON = 'PKB' 
		// 		THEN '<span style=\"color:green;font-weight:bold\">PKB</span>'
		// 	ELSE '<span style=\"color:red;font-weight:bold\">PERCEPATAN</span>'
		// END AS 'RESPON PPK',
		// C.WK_RESPON AS 'WAKTU PPK',
		// IF(B.LOKASI IS NULL OR B.STATUS_CONT = 900, 'DELIVERY', CONCAT(B.LOKASI, B.TIER)) AS LOKASI
		// FROM t_spk A
		// INNER JOIN t_spk_cont B ON A.ID = B.ID
		// INNER JOIN t_gatepass C ON B.NO_CONT = C.NO_CONT AND C.FL_ACTIVE = 'Y' AND C.JNS_DOK !='SPPMP'
		// LEFT JOIN t_op_inspection D ON D.NO_CONT = B.NO_CONT AND C.NO_DOK = D.NO_DOK
		// LEFT JOIN (select * from t_antrian_respon_ppk where reset = 'N') K ON C.ID = K.id_gatepass
		// WHERE 1 = $VAR C.RESPON IS NOT NULL";
		$SQL = "SELECT ID,no_antrian  'NO URUT',NO_CONT 'NO_KONTAINER',UKR_CONT 'UKURAN',TGL_DOK 'TANGGAL DOKUMEN',JNS_DOK 'JENIS',NO_DOK 'NO_DOKUMEN',LOKASI 'LOKASI',KEGIATAN,NAMA_CUST 'COSTUMER',
		CASE 
			WHEN STATUS2 = 1 THEN 'PPK'
			WHEN STATUS2 = 2 THEN 'SIAP PERIKSA'
			WHEN STATUS2 = 3 THEN 'BELUM PPK'
			WHEN STATUS2 = 4 THEN 'SEDANG PERIKSA'
			WHEN STATUS2 = 5 THEN 'WAITING'
			WHEN STATUS2 = 6 THEN 'SELESAI PERIKSA' 
		END 'STATUS',
		START_INSP 'START PERIKSA',FINISH_INSP 'FINISH PERIKSA',RESPON,WK_RESPON 'WAKTU RESPON',STATUS2 
		FROM (SELECT a.ID,k.no_antrian,a.NO_CONT,a.UKR_CONT,a.TGL_DOK,a.JNS_DOK,a.`STATUS`,a.NO_DOK,b.LOKASI,CONCAT('BEHANDLE ',a.JNS_KEGIATAN) KEGIATAN,a.NAMA_CUST,b.STATUS_CONT,d.START_INSP,d.FINISH_INSP,a.RESPON,a.WK_RESPON,
		CASE
			WHEN b.STATUS_CONT IN (450,510,530) AND d.START_INSP IS NULL AND d.FINISH_INSP IS NULL AND a.RESPON IS NULL THEN 3
			WHEN b.STATUS_CONT IN (450,510,530) AND d.START_INSP IS NULL AND d.FINISH_INSP IS NULL AND a.RESPON IS NOT NULL THEN 1
			WHEN b.STATUS_CONT = 460 AND d.START_INSP IS NULL AND d.FINISH_INSP IS NULL  AND a.RESPON IS NOT NULL THEN 2
			WHEN b.STATUS_CONT = 460 AND d.START_INSP IS NOT NULL AND d.FINISH_INSP IS NULL THEN 4
			WHEN b.STATUS_CONT IN (500,540,520) THEN 6 
			ELSE 5 
		END AS STATUS2 
		FROM t_gatepass a
		left JOIN (SELECT * FROM t_spk_cont WHERE STATUS_CONT != 900) b on a.NO_CONT = b.NO_CONT 
		JOIN t_spk c ON c.ID = b.ID
		LEFT JOIN t_op_inspection d ON a.NO_CONT = d.NO_CONT AND a.NO_DOK = d.NO_DOK
		LEFT JOIN (select * from t_antrian_respon_ppk where reset = 'N') k ON a.ID = k.id_gatepass
		WHERE  a.JNS_KEGIATAN  != 3 AND a.`STATUS` = 'WAITING'  AND a.JNS_DOK != 'SPPMP') az WHERE 1 = 1";

		$q2 = $this->db->query("SELECT STATUS,COUNT(ID) JML FROM (SELECT ID,no_antrian  'NO URUT',NO_CONT 'NO_KONTAINER',UKR_CONT 'UKURAN',TGL_DOK 'TANGGAL DOKUMEN',JNS_DOK 'JENIS',NO_DOK 'NO_DOKUMEN',LOKASI 'LOKASI',KEGIATAN,NAMA_CUST 'COSTUMER',
		CASE 
			WHEN STATUS2 = 1 THEN 'SIAP PERIKSA'
			WHEN STATUS2 = 2 THEN 'PPK'
			WHEN STATUS2 = 3 THEN 'BELUM PPK'
			WHEN STATUS2 = 4 THEN 'SEDANG PERIKSA'
			WHEN STATUS2 = 5 THEN 'WAITING'
			WHEN STATUS2 = 6 THEN 'SELESAI PERIKSA' 
		END 'STATUS',
		START_INSP 'START PERIKSA',FINISH_INSP 'FINISH PERIKSA',RESPON,WK_RESPON 'WAKTU RESPON',STATUS2 
		FROM (SELECT a.ID,k.no_antrian,a.NO_CONT,a.UKR_CONT,a.TGL_DOK,a.JNS_DOK,a.`STATUS`,a.NO_DOK,b.LOKASI,CONCAT('BEHANDLE ',a.JNS_KEGIATAN) KEGIATAN,a.NAMA_CUST,b.STATUS_CONT,d.START_INSP,d.FINISH_INSP,a.RESPON,a.WK_RESPON,
		CASE
			WHEN b.STATUS_CONT IN (450,510,530) AND d.START_INSP IS NULL AND d.FINISH_INSP IS NULL AND a.RESPON IS NULL THEN 3
			WHEN b.STATUS_CONT IN (450,510,530) AND d.START_INSP IS NULL AND d.FINISH_INSP IS NULL AND a.RESPON IS NOT NULL THEN 2
			WHEN b.STATUS_CONT = 460 AND d.START_INSP IS NULL AND d.FINISH_INSP IS NULL  AND a.RESPON IS NOT NULL THEN 1
			WHEN b.STATUS_CONT = 460 AND d.START_INSP IS NOT NULL AND d.FINISH_INSP IS NULL THEN 4
			WHEN b.STATUS_CONT IN (500,540,520) THEN 6 
			ELSE 5 
		END AS STATUS2 
		FROM t_gatepass a
		left JOIN (SELECT * FROM t_spk_cont WHERE STATUS_CONT != 900) b on a.NO_CONT = b.NO_CONT 
		JOIN t_spk c ON c.ID = b.ID
		LEFT JOIN t_op_inspection d ON a.NO_CONT = d.NO_CONT AND a.NO_DOK = d.NO_DOK
		LEFT JOIN (select * from t_antrian_respon_ppk where reset = 'N') k ON a.ID = k.id_gatepass
		WHERE  a.JNS_KEGIATAN  != 3 AND a.`STATUS` = 'WAITING'  AND a.JNS_DOK != 'SPPMP') az WHERE 1 = 1) ass
		GROUP BY status")->result();

		$jsiapperiksa = 0;
		$jppk = 0;
		$jbelumppk = 0;
		$jwaiting = 0;
		$jsedang = 0;
		$jselesai = 0;

		foreach ($q2 as $key => $v) {
			if ($v->STATUS == 'BELUM PPK') {
				$jbelumppk = $v->JML;
			}
			if ($v->STATUS == 'PPK') {
				$jppk = $v->JML;
			}
			if ($v->STATUS == 'SEDANG PERIKSA') {
				$jsedang = $v->JML;
			}
			if ($v->STATUS == 'SELESAI PERIKSA') {
				$jselesai = $v->JML;
			}
			if ($v->STATUS == 'SIAP PERIKSA') {
				$jsiapperiksa = $v->JML;
			}
			if ($v->STATUS == 'WAITING') {
				$jwaiting = $v->JML;
			}
		}

		$proses = array(
			'siap periksa'  => array('GET', '', '2', '', '#76ff03', 'Siap Periksa : ' . $jsiapperiksa . '', 'ycustom'),
			'ppk'  => array('GET', '', '2', '', 'red', 'PPK : ' . $jppk . '', 'ycustom'),
			'belum ppk'  => array('GET', '', '2', '', '#9aa58c', 'Belum PPK : ' . $jbelumppk . '', 'ycustom'),
			'waiting'  => array('GET', '', '2', '', '#ffee33', 'Waiting List : ' . $jwaiting . '', 'ycustom'),
			'sedang periksa'  => array('GET', '', '2', '', '#33bfff', 'Sedang Periksa : ' . $jsedang . '', 'ycustom'),
			'selesai periksa'  => array('GET', '', '2', '', '#2a3eb1', 'Selesai Periksa : ' . $jselesai . '', 'ycustom')
		);

		$this->newtable->multiple_search(true);
		$this->newtable->show_chk(false);
		$this->newtable->show_menu($check);
		$this->newtable->show_search(true);
		$this->newtable->search(array(array('az.NO_DOK', 'NO. DOKUMEN'), array('az.TGL_DOK', 'TGL. DOKUMEN', 'DATERANGE'), array('az.NO_CONT', 'NO. KONTAINER')));
		$this->newtable->action(site_url() . "/display/pergerakan");
		$this->newtable->detail(array('DRILLDOWN', "display/pergerakan/detail"));
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("ID", "STATUS2"));
		$this->newtable->keys(array("ID", "NO_DOKUMEN", "NO_KONTAINER"));
		$this->newtable->cidb($this->db);
		$this->newtable->groupby();
		//$this->newtable->orderby("CASE WHEN B.STATUS_CONT IN (450,510,530) AND D.START_INSP IS NULL AND D.FINISH_INSP IS NULL AND C.RESPON IS NULL THEN 3 WHEN B.STATUS_CONT IN (450,510,530) AND D.START_INSP IS NULL AND D.FINISH_INSP IS NULL AND C.RESPON IS NOT NULL THEN 2 WHEN B.STATUS_CONT = 460 AND D.START_INSP IS NULL AND D.FINISH_INSP IS NULL AND C.RESPON IS NOT NULL THEN 1 WHEN B.STATUS_CONT = 460 AND D.START_INSP IS NOT NULL AND D.FINISH_INSP IS NULL THEN 4 WHEN B.STATUS_CONT IN (500,540,520) THEN 5 WHEN B.STATUS_CONT IN (800,850,870,900,901,902,950) THEN 6 ELSE 7 END ASC, C.WK_RESPON ASC,C.WK_ACTIVE ASC");
		$this->newtable->orderby("STATUS2,WK_RESPON");
		$this->newtable->sortby("");
		$this->newtable->set_formid("tblcustomspergerakan");
		$this->newtable->set_divid("divcustomspergerakan");
		$this->newtable->rowcount(50);
		$this->newtable->clear();
		$this->newtable->menu($proses);
		$tabel .= $this->newtable->generate_custom($SQL);
		$arrdata = array("page_title" => $page_title, "title" => $title, "content" => $tabel);
		if ($this->input->post("ajax") || $act == "post")
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
		$SQL = $this->db->query("SELECT DISTINCT C.ID, C.JNS_DOK, C.NO_DOK, C.TGL_DOK, C.NAMA_CUST, C.NO_CONT, C.UKR_CONT, C.WK_REK, C.WK_RESPON, E.WK_STATUS, D.START_INSP, D.FINISH_INSP, F.NOTE
		FROM  t_gatepass C
		LEFT JOIN t_op_inspection D ON D.NO_CONT = C.NO_CONT AND C.NO_DOK = D.NO_DOK
		LEFT JOIN (SELECT DISTINCT NO_CONT, NO_DOK, NO_GATEPASS, LOKASI_AKHIR, WK_STATUS FROM t_job_slip A WHERE SUBSTRING(A.LOKASI_AKHIR, 1, 3) = 'CIC' GROUP BY NO_CONT ORDER BY ID_JOB_SLIP ASC) E ON C.NO_CONT = E.NO_CONT AND C.NO_DOK = E.NO_DOK
		LEFT JOIN (SELECT DISTINCT NO_CONT, NO_DOK, NOTE FROM t_job_slip A WHERE SUBSTRING(A.LOKASI_AWAL, 1, 3) = 'CIC' GROUP BY NO_CONT ORDER BY ID_JOB_SLIP ASC) F ON C.NO_CONT = F.NO_CONT AND C.NO_DOK = F.NO_DOK
		WHERE C.ID = '$ID'");
		return $SQL->row_array();
	}
	public function detail_pergerakan_planner($act, $id)
	{
		$VAR = explode("~", $id);
		$ID = $VAR[0];
		$NO_DOK = $VAR[1];
		$NO_CONT = $VAR[2];
		$SQL = $this->db->query("SELECT DISTINCT C.ID, C.JNS_DOK, C.NO_DOK, C.TGL_DOK, C.NAMA_CUST, C.NO_CONT, C.UKR_CONT, C.WK_REK, C.WK_RESPON, E.WK_STATUS, D.START_INSP, D.FINISH_INSP, F.NOTE
		FROM  t_gatepass C
		LEFT JOIN t_op_inspection D ON D.NO_CONT = C.NO_CONT AND C.NO_DOK = D.NO_DOK
		LEFT JOIN (SELECT DISTINCT NO_CONT, NO_DOK, NO_GATEPASS, LOKASI_AKHIR, WK_STATUS FROM t_job_slip A WHERE SUBSTRING(A.LOKASI_AKHIR, 1, 3) = 'CIC' GROUP BY NO_CONT ORDER BY ID_JOB_SLIP ASC) E ON C.NO_CONT = E.NO_CONT AND C.NO_DOK = E.NO_DOK
		LEFT JOIN (SELECT DISTINCT NO_CONT, NO_DOK, NOTE FROM t_job_slip A WHERE SUBSTRING(A.LOKASI_AWAL, 1, 3) = 'CIC' GROUP BY NO_CONT ORDER BY ID_JOB_SLIP ASC) F ON C.NO_CONT = F.NO_CONT AND C.NO_DOK = F.NO_DOK
		WHERE C.ID = '$ID'");
		return $SQL->row_array();
	}

	public function getresponquarantine($act, $id)
	{
		$page_title = "RESPON QUARANTINE";
		$title = "QUARANTINE";
		$this->newtable->breadcrumb('Display', site_url(), 'icon-home');
		$this->newtable->breadcrumb('RESPON', 'javascript:void(0)', '');
		$this->newtable->breadcrumb('QUARANTINE', 'javascript:void(0)', '');
		$check = (grant() == "W") ? true : false;
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
				WHERE" . $addsql . "";

		$proses = array(
			'PKB LONGROOM'  => array('DELETE', "display/execute/porses_cust1", 'all', '', 'md-layers', '', 'menu'),
			'PKB YARD'  => array('DELETE', "display/execute/porses_cust2", 'all', '', 'md-navigation', '', 'menu'),
			'PKB YARD N'  => array('DELETE', "display/execute/porses_cust3", 'all', '', 'md-badge-check', '', 'menu'),
			'PKB LONGROOM ' => array('POST', "display/respon_custom/pkblr", '1', '', 'md-layers', '', 'list'),
			'PKB YARD ' => array('POST', "display/respon_custom/pkbyard", '1', '', 'md-navigation', '', 'list'),
			'PKB YARD N ' => array('POST', "display/respon_custom/pkbyardn", '1', '', 'md-badge-check', '', 'list')
		);

		$this->newtable->multiple_search(true);
		$this->newtable->show_chk(true);
		$this->newtable->show_menu($check);
		$this->newtable->show_search(true);
		$this->newtable->search(array(array('NO_SPK', 'NO. SPK'), array('B.NO_CONT', 'NO. KONTAINER'), array('C.NO_DOK', 'NO. DOKUMEN')));
		$this->newtable->action(site_url() . "/display/respon_custom");
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("ID", "WK_RESPON"));
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
		if ($this->input->post("ajax") || $act == "post")
			return $tabel;
		else
			return $arrdata;
	}

	function execute($type, $act, $id)
	{
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
				$ID = $arrchk[0]; //print_r($ID); die();

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
					echo "MSG#OK#Respon PKB Longroom#" . site_url(), 'refresh';
				} else {
					echo "MSG#ERR#" . $message . "#";
				}
			}
		} else if ($type == "porses_cust2") {
			foreach ($this->input->post('tb_chktblcustoms') as $chkitem) {
				$arrchk = explode("~", $chkitem);
				$ID = $arrchk[0]; //print_r($ID); die();

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
					echo "MSG#OK#Respon PKB Yard#" . site_url(), 'refresh';
					//echo "MSG#OK#Successfully to be processed#" .redirect(site_url(), 'refresh');
				} else {
					echo "MSG#ERR#" . $message . "#";
				}
			}
		} else if ($type == "porses_cust3") {
			foreach ($this->input->post('tb_chktblcustoms') as $chkitem) {
				$arrchk = explode("~", $chkitem);
				$ID = $arrchk[0]; //print_r($ID); die();

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
					echo "MSG#OK#Respon PKB Yard N#" . site_url(), 'refresh';
				} else {
					echo "MSG#ERR#" . $message . "#";
				}
			}
		} else if ($type == "porses_prioritas") {
			foreach ($this->input->post('tb_chktblcustoms') as $chkitem) {
				$arrchk = explode("~", $chkitem);
				$ID = $arrchk[0]; //print_r($ID); die();

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
					echo "MSG#OK#Respon PKB Prioritas N#" . site_url(), 'refresh';
				} else {
					echo "MSG#ERR#" . $message . "#";
				}
			}
		}
	}

	// public function set_pkb($type, $act, $id)
	// {
	// 	$ERROR = 0;
	// 	foreach ($this->input->post('tb_chktblcustoms') as $VALUE) {
	// 		$VAR = explode("~", $VALUE);
	//         $ID = $VAR[0];
	//         $NO_DOK = $VAR[1];
	//         $SQL = $this->db->query("SELECT * FROM t_gatepass WHERE ID = '".$ID."' AND NO_DOK ='".$NO_DOK."' AND STATUS = 'WAITING' AND FL_ACTIVE = 'Y'");
	//         $RESULT = $SQL->result_array();
	//         if ($SQL->num_rows() > 0) {
	// 			switch ($act) {
	// 				case 'pkb_longroom':
	// 					$RESPON = 'PKB LONGROOM';
	// 					break;
	// 				case 'pkb_yard':
	// 					$RESPON = 'PKB YARD';
	// 					break;
	// 				case 'pkb_yardn':
	// 					$RESPON = 'PKB YARD N';
	// 					break;
	// 				case 'pkb_percepatan':
	// 					$RESPON = 'PKB PERCEPATAN';
	// 					break;
	// 				default:
	// 					$RESPON = 'PKB';
	// 					break;
	// 			}
	// 			foreach ($RESULT as $VALUE) {
	// 				$this->db->set('RESPON', $RESPON);
	// 				$this->db->set('WK_RESPON', date('Y-m-d H:i:s'));
	// 				$DB = $this->db->where(array('ID' => $VALUE['ID'], 'NO_CONT' => $VALUE['NO_CONT'], 'NO_DOK' => $NO_DOK));
	// 				$EXEC = $this->db->update('t_gatepass');
	// 				if ($EXEC) {
	// 					$ERROR = 0;
	// 					$this->send_email_pkb($VALUE['ID'], $VALUE['NO_CONT'], $NO_DOK);
	// 				}else{
	// 					$ERROR++;
	// 				}
	// 			}
	// 		}
	// 	}
	// 	if ($ERROR == 0) {
	// 		 echo "MSG#OK#RESPON BERHASIL DITAMBAHKAN#" . site_url(),'refresh';
	// 	}else{
	// 		echo "MSG#ERR#DATA GAGAL DI RESPON#";
	// 	}
	// }

	public function set_pkb($id)
	{

		$ERROR = 0;

		$typedata = $this->input->post('status');
		$cekCont = $this->input->post('ceklis');

		$arrid = explode('~', $id);
		$iddata = $arrid[0];
		$no_dok = $arrid[1];

		for ($i = 0; $i <= count($typedata); $i++) {
			$no_cont = $cekCont[$i];
			$type = $typedata[$i];

			if ($no_cont) {
				//echo "SELECT * FROM t_gatepass WHERE NO_DOK='$id' AND NO_CONT='$no_cont' AND STATUS = 'WAITING'";
				$SQL = $this->db->query("SELECT * FROM t_gatepass WHERE NO_DOK='$id' AND NO_CONT='$no_cont' AND STATUS = 'WAITING' order by id desc limit 1");
				$RESULT = $SQL->row_array();
				$IDRESULT = $RESULT['ID'];
				$CONTRESULT = $RESULT['NO_CONT'];

				if ($SQL->num_rows() > 0) {
					switch ($type) {
						case "pkb_longroom":
							$RESPON = "PPK LONGROOM";
							break;
						case "mini_lr":
							$RESPON = "PPK MINI LR";
							break;
						case "pkb_yard":
							$RESPON = "PPK YARD";
							break;
						case "no":
							$RESPON = "NO PPK";
							break;
						case "pkb_percepatan":
							$RESPON = "PPK PERCEPATAN";
							break;
						case "periksa_ulang":
							$RESPON = "PERIKSA ULANG";
							break;
						case "periksa_tambahan":
							$RESPON = "PERIKSA TAMBAHAN";
							break;
						case "nhi":
							$RESPON = "NHI";
							break;
						case "returnable_package":
							$RESPON = "RETURNABLE PACKAGE(RP)";
							break;
						case "pibk":
							$RESPON = "PIBK";
							break;
						default:
							$RESPON = "PKB";
							break;
					}

					$jmlno = $this->db->query("SELECT * FROM t_antrian_respon_ppk where reset ='N' and no_dok != '$id' order by id desc limit 1");
					if ($jmlno->num_rows() > 0) {
						$no_antrian = $jmlno->row()->no_antrian + 1;
					} else {
						$no_antrian = 1;
					}

					$uusr = $this->session->userdata("USERLOGIN");
					$dtq = $this->db->query("SELECT * FROM t_gatepass WHERE ID = '$IDRESULT' AND NO_CONT = '$CONTRESULT' AND NO_DOK = '$id' AND respon IS NULL");
					if ($dtq->num_rows() > 0) {
						if ($type != 'no') {
							$adadoc = $this->db->query("SELECT * FROM t_antrian_respon_ppk where reset ='N' AND no_cont = '$CONTRESULT' AND no_dok = '$id'");
							if ($adadoc->num_rows() == 0) {
								$this->db->query("INSERT INTO t_antrian_respon_ppk (id_gatepass,no_cont,no_dok,no_antrian,user_buat) VALUES ('$IDRESULT', '$CONTRESULT', '$id', '$no_antrian','$uusr')");
							}
						}
						$DATERES = date('Y-m-d H:i:s');
						$strexec = "UPDATE t_gatepass SET RESPON='$RESPON', WK_RESPON='$DATERES'  WHERE ID = '$IDRESULT' AND NO_CONT = '$CONTRESULT' AND NO_DOK = '$id'";
					} else {
						$strexec = "UPDATE t_gatepass SET RESPON='$RESPON' WHERE ID = '$IDRESULT' AND NO_CONT = '$CONTRESULT' AND NO_DOK = '$id'";
					}
					$this->db->query("INSERT INTO t_log_ppk_bc (id_gatepass,no_cont,user_login) VALUES ('$IDRESULT', '$CONTRESULT', '$uusr')");
					$EXEC2 = $this->db->query($strexec);
					if ($EXEC2) {
						$ERROR = 0;
						//$this->send_email_pkb($IDRESULT, $CONTRESULT, $no_dok);
					} else {
						$ERROR++;
					}
				}
			}
		}

		if ($ERROR == 0) {
			echo "MSG#OK#RESPON BERHASIL DITAMBAHKAN#" . site_url(), 'refresh';
		} else {
			echo "MSG#ERR#DATA GAGAL DI RESPON#";
		}
	}
	public function set_pkbjoin($id, $id3)
	{
		$ERROR = 0;
		$msgerr = '';
		$typedata = $this->input->post('status');
		$cekCont = $this->input->post('ceklis');
		$jadwal = $this->input->post('jadwal');
		$pemeriksa = $this->input->post('pemeriksa');
		$noaju = $this->input->post('noaju');

		$dok_bc = $this->input->post('dok_bc');
		$tgl_bc = $this->input->post('tgl_bc');
		$dok_kr = $this->input->post('dok_kr');
		$tgl_kr = $this->input->post('tgl_kr');
		$tgl_kr = date('Y-m-d', strtotime($tgl_kr));

		$arrid = explode('~', $id);
		$arrid2 = explode('~', $id3);
		//var_dump($arrid2);die();
		$iddata = $arrid[0];
		$no_dok = $arrid[1];
		$kdgroup = $this->session->userdata('KD_GROUP');


		$cek  = $this->db->query("SELECT * from t_lnsw_responjoin where no_aju = '$noaju'");
		//var_dump($cek->result());die();
		$date = date('Y-m-d H:i:s');

		$spkc = $this->db->query("SELECT kd_status from t_spk where no_dok = '$dok_kr' and tgl_dok = '$tgl_kr' ")->row();
		if ($spkc->kd_status >= 100) {
			if (substr($kdgroup, 0, 2) == 'KAR') {
				// if ($cek->num_rows() > 0) {
				// 	if ($cek->row()->respon_beacukai == '') {
				// 		$this->db->query("UPDATE `t_lnsw_responjoin` SET `respon_beacukai`='$typedata[0]', `waktu_respon_bc`='$date', `dok_beacukai`='$dok_bc', `tgl_beacukai`='$tgl_bc' WHERE  no_aju = '$noaju' ");
				// 		$this->db->query("UPDATE `t_lnsw_responjoin` SET `selesai`='Y' WHERE  no_aju = '$noaju' ");
				// 	}
				// }else{
				// 	$this->db->query("INSERT INTO `t_lnsw_responjoin` (`no_aju`, `respon_beacukai`, `waktu_respon_bc`, `dok_beacukai`, `tgl_beacukai`) VALUES ('$noaju', '$typedata[0]', '$date', '$dok_bc', '$tgl_bc')");
				// }
			} else {
				if ($cek->num_rows() > 0) {
					if ($cek->row()->respon_karantina == '') {
						$this->db->query("UPDATE `t_lnsw_responjoin` SET `respon_karantina`='$typedata[0]', `waktu_respon_kr`='$date', `dok_karantina`='$dok_kr', `tgl_karantina`='$tgl_kr' WHERE  no_aju = '$noaju'");
						$this->db->query("UPDATE `t_lnsw_responjoin` SET `selesai`='Y' WHERE  no_aju = '$noaju'");

						$cekgatepass = $this->db->query("SELECT id FROM t_gatepass WHERE no_dok = '$dok_kr' AND tgl_dok = '$tgl_kr' and respon is null");
						if ($cekgatepass->num_rows() > 0) {
							foreach ($cekgatepass->result() as $k => $vl) {
								$iddd = $vl->id;
								$this->db->query("UPDATE `t_gatepass` SET `FL_ACTIVE`='Y', `RESPON`='$typedata[0]', `WK_RESPON`='$date' WHERE  `ID`=$iddd");
							}
						}
					}
				} else {
					$this->db->query("INSERT INTO `t_lnsw_responjoin` (`no_aju`, `respon_karantina`, `waktu_respon_kr`, `dok_karantina`, `tgl_karantina`) VALUES ('$noaju', '$typedata[0]', '$date', '$dok_kr', '$tgl_kr')");
					$this->db->query("UPDATE `t_lnsw_responjoin` SET `respon_beacukai`='$typedata[0]', `waktu_respon_bc`='$date', `dok_beacukai`='$dok_bc', `tgl_beacukai`='$tgl_bc' WHERE  no_aju = '$noaju' ");
					$this->db->query("UPDATE `t_lnsw_responjoin` SET `selesai`='Y' WHERE  no_aju = '$noaju' ");
					$cekgatepass = $this->db->query("SELECT id FROM t_gatepass WHERE no_dok = '$dok_kr' AND tgl_dok = '$tgl_kr' and respon is null");
					if ($cekgatepass->num_rows() > 0) {
						foreach ($cekgatepass->result() as $k => $vl) {
							$iddd = $vl->id;
							$this->db->query("UPDATE `t_gatepass` SET `FL_ACTIVE`='Y', `RESPON`='$typedata[0]', `WK_RESPON`='$date' WHERE  `ID`=$iddd");
						}
					}
					foreach ($cekCont as $k2 => $v2) {
						$ada1 = $this->db->query("SELECT * FROM t_antrian_respon_ppk_join WHERE RESET = 'N' and no_cont = '$v2'")->num_rows();
						if ($ada1 == 0) {
							$ada2 = $this->db->query("SELECT * FROM t_antrian_respon_ppk_join WHERE RESET = 'N' ORDER BY id DESC")->row();
							if (count($ada2) > 0) {
								$nom = $ada2->no_antrian + 1;
								$this->db->query("INSERT INTO `tpk_ipc`.`t_antrian_respon_ppk_join` (`noaju`, `tgl_aju`, `no_cont`, `no_antrian`, `user_buat`) VALUES ('$noaju', NULL, '$v2', '$nom', 'admin2')");
							} else {
								$this->db->query("INSERT INTO `tpk_ipc`.`t_antrian_respon_ppk_join` (`noaju`, `tgl_aju`, `no_cont`, `no_antrian`, `user_buat`) VALUES ('$noaju', NULL, '$v2', '1', 'admin2')");
							}
						}
					}
					// foreach ($cekCont as $k2 => $v2) {
					// 	$spemeriksa = $pemeriksa[$k2+1];
					// 	$sjadwal = $jadwal[$k2+1];
					// 	$this->db->query("INSERT INTO `t_detail_pemeriksa_join` (`no_dok`, `tgl_dok`, `no_cont`, `id_pemeriksa`, `jadwal`) VALUES ('$dok_kr', '$tgl_kr', '$v2', '$spemeriksa', '$sjadwal')");
					// }
				}
			}
		} else {
			$ERROR = 1;
			$msgerr = 'SPK MASIH ANNOUNCE, MOHON MENUNGGU HINGGA SPK BERJALAN';
		}

		if ($ERROR == 0) {
			echo "MSG#OK#RESPON BERHASIL DITAMBAHKAN#" . site_url(), 'refresh';
		} else {
			echo "MSG#ERR#DATA GAGAL DI RESPON :" . $msgerr . "N#";
		}
	}

	public function set_pkbjoin2($id, $id3)
	{
		$ERROR = 0;

		$typedata = $this->input->post('status');
		$cekCont = $this->input->post('ceklis');
		$jadwal = $this->input->post('jadwal');
		$pemeriksa = $this->input->post('pemeriksa');
		$noaju = $this->input->post('noaju');

		$dok_bc = $this->input->post('dok_bc');
		$tgl_bc = $this->input->post('tgl_bc');
		$dok_kr = $this->input->post('dok_kr');
		$tgl_kr = $this->input->post('tgl_kr');
		$tgl_kr = date('Y-m-d', strtotime($tgl_kr));

		$arrid = explode('~', $id);
		$arrid2 = explode('~', $id3);
		//var_dump($arrid2);die();
		$iddata = $arrid[0];
		$no_dok = $arrid[1];
		$kdgroup = $this->session->userdata('KD_GROUP');

		$spkc = $this->db->query("SELECT kd_status from t_spk where no_dok = '$dok_kr' and tgl_dok = '$tgl_kr' ")->row();
		if ($spkc->kd_status >= 400) {
			foreach ($cekCont as $k2 => $v2) {
				$spemeriksa = $pemeriksa[$k2];
				$sjadwal = $jadwal[$k2];
				$ada = $this->db->query("SELECT * FROM t_detail_pemeriksa_join WHERE no_dok = '$dok_kr' and tgl_dok = '$tgl_kr' and no_cont = '$v2' ")->row();
				// var_dump(count($ada));
				// die();
				if (count($ada) == 0) {
					$this->db->query("INSERT INTO `t_detail_pemeriksa_join` (`no_dok`, `tgl_dok`, `no_cont`, `id_pemeriksa`, `jadwal`) VALUES ('$dok_kr', '$tgl_kr', '$v2', '$spemeriksa', '$sjadwal')");
				} else {
					$this->db->query("UPDATE t_detail_pemeriksa_join SET id_pemeriksa = '$spemeriksa',jadwal = '$sjadwal' WHERE id = '$ada->id'");
				}
			}
		} else {
			$ERROR = 1;
			$msgerr = 'KONTAINER BELUM ADA DI YARD, MASIH DALAM PERJALANAN PENARIKAN';
		}



		if ($ERROR == 0) {
			echo "MSG#OK#RESPON BERHASIL DITAMBAHKAN#" . site_url(), 'refresh';
		} else {
			echo "MSG#ERR#DATA GAGAL DI RESPON :" . $msgerr . "N#";
		}
	}

	public function set_pkb_karantina($type, $act, $id)
	{
		$ERROR = 0;
		foreach ($this->input->post('tb_chktblcustoms') as $VALUE) {
			$VAR = explode("~", $VALUE);
			$ID = $VAR[0];
			$NO_DOK = $VAR[1];
			$SQL = $this->db->query("SELECT * FROM t_gatepass WHERE ID = '" . $ID . "' AND NO_DOK ='" . $NO_DOK . "' AND STATUS = 'WAITING' AND FL_ACTIVE = 'Y'");
			$RESULT = $SQL->result_array();
			if ($SQL->num_rows() > 0) {
				switch ($act) {
					case 'pkb_longroom':
						$RESPON = 'PKB LONGROOM';
						break;
					case 'pkb_yard':
						$RESPON = 'PKB YARD';
						break;
					case 'pkb_yardn':
						$RESPON = 'PKB YARD N';
						break;
					case 'pkb_percepatan':
						$RESPON = 'PKB PERCEPATAN';
						break;
					default:
						$RESPON = 'PKB';
						break;
				}
				foreach ($RESULT as $VALUE) {
					$this->db->set('RESPON', $RESPON);
					$this->db->set('WK_RESPON', date('Y-m-d H:i:s'));
					$DB = $this->db->where(array('ID' => $VALUE['ID'], 'NO_CONT' => $VALUE['NO_CONT'], 'NO_DOK' => $NO_DOK));
					$EXEC = $this->db->update('t_gatepass');
					if ($EXEC) {
						$ERROR = 0;
						$this->send_email_pkb($VALUE['ID'], $VALUE['NO_CONT'], $NO_DOK);
					} else {
						$ERROR++;
					}
				}
			}
		}
		if ($ERROR == 0) {
			echo "MSG#OK#RESPON BERHASIL DITAMBAHKAN#" . site_url(), 'refresh';
		} else {
			echo "MSG#ERR#DATA GAGAL DI RESPON#";
		}
	}

	public function send_email_pkb($ID, $NO_CONT, $NO_DOK)
	{
		$SQL = $this->db->query("SELECT * FROM t_gatepass WHERE ID = '" . $ID . "' AND NO_CONT = '" . $NO_CONT . "' AND NO_DOK ='" . $NO_DOK . "' AND RESPON IS NOT NULL AND STATUS = 'WAITING' AND FL_ACTIVE = 'Y'");
		$RESULT = $SQL->result_array();
		if ($SQL->num_rows() > 0) {
			foreach ($RESULT as $VALUE) {
				$TMPCONT .= $VALUE["NO_CONT"] . "-" . $VALUE["UKR_CONT"] . '"' . " , ";
				$CONT = rtrim($TMPCONT, ", ");
			}
			$EMAIL = $this->db->query("SELECT EMAIL FROM m_pelanggan A INNER JOIN t_gatepass B ON B.NPWP = A.NPWP AND B.NAMA_CUST = A.NAMA_CUST WHERE B.ID = '" . $ID . "'")->result_array();
			foreach ($EMAIL as $EMAIL) {
				// LOAD LIBRARY EMAIL
				$this->load->helper('email');
				// END LOAD LIBRARY EMAIL
				$HEADER = $SQL->row_array();
				$SUBJECT = "PERMOHONAN KESIAPAN BARANG (PKB) - [" . $HEADER['NAMA_CUST'] . "]";
				$EMAIL_SEND = $EMAIL['EMAIL'];
				$EMAIL_SUCCESS = 0;
				print_r($SUBJECT);
				if (valid_email($EMAIL_SEND)) {
					$CONFIG = array(
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
					$HTML_MAIL = '	<html lang="en">
										<head>
											<meta charset="UTF-8">
											<title>Document</title>
										</head>
										<body>
										<div align="">
											<p align="">
												Dengan Hormat,<br><br>
												Bersama ini kami informasikan data barang/container yang akan diperiksa (inspection) dengan data sebagai berikut :
											</p>
											<table border="1" class="table" width="80%" style="width:80%;border-collapse:collapse;background:#ecf3eb">
													<tr>
														<td style="width:214px;"><b>NPWP Perusahaan</b> </td>
														<td>:</td>
														<td>' . $HEADER['NPWP'] . '</td>
													</tr>
													<tr>
														<td width=""><b>Nama Perusahaan</b> </td>
														<td>:</td>
														<td>' . $HEADER['NAMA_CUST'] . '</td>
													</tr>
													<tr>
														<td><b>Nomor Container </b></td>
														<td>:</td>
														<td>' . $CONT . '</td>
													</tr>
													<tr>
														<td><b>Nomor Dokumen </b></td>
														<td>:</td>
														<td>' . $HEADER['NO_DOK'] . '</td>
													</tr>
													<tr>
														<td><b>Tanggal Dokumen </b></td>
														<td>:</td>
														<td>' . $HEADER['TGL_DOK'] . '</td>
													</tr>
													<tr>
														<td><b>Tanggal Gatepass </b></td>
														<td>:</td>
														<td>' . $HEADER['WK_REK'] . '</td>
													</tr>
													<tr>
														<td><b>Tanggal PKB </b></td>
														<td>:</td>
														<td>' . $HEADER['WK_RESPON'] . '</td>
													</tr>
												</table>
											<div>
												Mohon kerjasamanya untuk kesiapan customer dalam tahap pemeriksaan (inspection) yang akan di laksanakan.<br><br>
												Atas perhatian dan kerjasamanya kami ucapkan terima kasih.<br><br>

												=================================================================================<br><br>
												<table border="0" class="table" width="55%">
													<tr>
														<td>
															<img src="' . base_url() . '/assets/images/Logomti.png" alt="">
														</td>
														<td>
															<div style="color:#050567" align="justify">
																This message was delivered by BOS PT. MTI.
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
					$this->load->library('email', $CONFIG);
					$this->email->from('cgs.ipc@gmail.com', 'BOS NOTIFICATION - PERMOHONAN KESIAPAN BARANG (PKB)');
					$EMAIL_SEND = str_replace(';', ',', $EMAIL_SEND);
					$this->email->to($EMAIL_SEND);
					$this->email->cc('mailbosmti@gmail.com');
					$this->email->subject($SUBJECT);
					$this->email->message($HTML_MAIL);
					print_r($this->email->send());
				}
			}
		}
	}

	public function detail_respon($id)
	{
		$VAR = explode("~", $id);
		$ID = $VAR[0];
		$NO_DOK = $VAR[1];
		$SQL = $this->db->query("SELECT a.ID,k.no_antrian, a.NO_DOK, a.NO_DOK, DATE_FORMAT(a.TGL_DOK, '%d-%m-%Y') AS 'TGL_DOK', b.NO_CONT, b.UKR_CONT AS 'SIZE', CONCAT(b.LOKASI,b.TIER) AS LOKASI, CONCAT('BEHANDLE ',a.JNS_KEGIATAN) AS 'KETERANGAN', a.NAMA_CUST AS 'CUSTOMER', e.FL_PERIKSA,e.FL_MANUAL,e.KD_DOK_INOUT,
				CASE
					WHEN b.STATUS_CONT IN (000,100,200,300,400,450,510,530) AND d.START_INSP IS NULL AND d.FINISH_INSP IS NULL AND a.RESPON IS NULL THEN '<span class=\"label label-danger\">BELUM PPK</span>'
					WHEN b.STATUS_CONT IN (000,100,200,300,400,450,510,530) AND d.START_INSP IS NULL AND d.FINISH_INSP IS NULL AND a.RESPON IS NOT NULL THEN '<span class=\"label label-danger\">PPK</span>'
					WHEN b.STATUS_CONT = 460 AND d.START_INSP IS NULL AND d.FINISH_INSP IS NULL  AND a.RESPON IS NOT NULL THEN '<span class=\"label label-warning\">SIAP PERIKSA</span>'
					WHEN b.STATUS_CONT = 460 AND d.START_INSP IS NOT NULL AND d.FINISH_INSP IS NULL THEN '<span class=\"label label-primary\">SEDANG PERIKSA</span>' 
					WHEN b.STATUS_CONT IN (500,540,520) THEN '<span class=\"label label-success\">SELESAI PERIKSA</span>' 
					WHEN b.STATUS_CONT IN (800,850,870,900,901,902,950) THEN '<span class=\"label label-success\">DELIVERY</span>'
					ELSE '<span class=\"label label-success\">SELESAI PERIKSA</span>'  
				END AS STATUS, 
				CONCAT(CASE 
							WHEN a.RESPON = 'PKB LONGROOM' OR a.RESPON = 'PPK LONGROOM'  
								THEN '<span style=\"color:green;font-weight:bold\">LONGROOM</span>'
							WHEN a.RESPON = 'PKB YARD' OR a.RESPON = 'PPK YARD' 
								THEN '<span style=\"color:green;font-weight:bold\">YARD</span>'
							WHEN a.RESPON = 'NO PKB' OR a.RESPON = 'NO PPK'
								THEN '<span style=\"color:green;font-weight:bold\">NO PPK</span>'
							WHEN a.RESPON = 'PERIKSA ULANG' 
								THEN '<span style=\"color:green;font-weight:bold\">PERIKSA ULANG</span>'
							WHEN a.RESPON = 'PERIKSA TAMBAHAN' 
								THEN '<span style=\"color:green;font-weight:bold\">PERIKSA TAMBAHAN</span>'
							WHEN a.RESPON = 'NHI' 
								THEN '<span style=\"color:green;font-weight:bold\">NHI</span>'
							WHEN a.RESPON = 'RETURNABLE PACKAGE(RP)' 
								THEN '<span style=\"color:green;font-weight:bold\">RETURNABLE PACKAGE(RP)</span>'
							WHEN a.RESPON = 'PIBK' 
								THEN '<span style=\"color:green;font-weight:bold\">PIBK</span>'
							ELSE 
								'<span style=\"color:red;font-weight:bold\">PERCEPATAN</span>'
						END,'<BR>','TANGGAL PPK :',DATE_FORMAT(a.WK_RESPON, '%d-%m-%Y %h:%i:%s')
				)AS PPK, DATE_FORMAT(a.WK_RESPON, '%d-%m-%Y %h:%i:%s') AS 'TGL_PPK'
		FROM t_gatepass a
		left JOIN (SELECT a.NO_DAFTAR_PABEAN,b.NO_CONT,b.FL_PERIKSA,a.FL_MANUAL,a.KD_DOK_INOUT from t_permit_hdr a JOIN t_permit_cont b ON a.ID = b.ID) e ON a.NO_DOK = e.NO_DAFTAR_PABEAN AND a.NO_CONT = e.NO_CONT
		LEFT join (SELECT * FROM t_spk_cont WHERE STATUS_CONT != 900) b on a.NO_CONT = b.NO_CONT
		JOIN t_spk c ON c.ID = b.ID
		LEFT JOIN t_op_inspection d ON a.NO_CONT = d.NO_CONT AND a.NO_DOK = d.NO_DOK AND a.JNS_KEGIATAN = d.JNS_KEGIATAN
		LEFT JOIN (select * from t_antrian_respon_ppk where reset = 'N') k ON a.ID = k.id_gatepass
		LEFT JOIN v_req_delivery_hdrcont s ON a.NO_CONT = s.NO_CONT AND a.NO_DOK = s.NO_DOK
		WHERE a.JNS_KEGIATAN  != 3 AND a.`STATUS` = 'WAITING' AND d.FINISH_INSP IS NULL AND a.JNS_DOK != 'SPPMP' AND DATE(a.TGL_DOK) > DATE_ADD(NOW() , INTERVAL -5 MONTH) AND a.NO_DOK = '$id'");
		return $SQL->result();
	}
	public function detail_responjoin($id)
	{
		$VAR = explode("~", $id);
		$ID = $VAR[0];
		$NO_DOK = $VAR[1];
		$SQL = $this->db->query("SELECT b.ID,mm.no_antrian, b.NO_DOK, b.NO_DOK, DATE_FORMAT(b.TGL_DOK, '%d-%m-%Y') AS 'TGL_DOK', b.NO_CONT, b.UKR_CONT AS 'SIZE', CONCAT(b.LOKASI,b.TIER) AS LOKASI, CONCAT('BEHANDLE ',a.JNS_KEGIATAN) AS 'KETERANGAN', a.NAMA_CUST AS 'CUSTOMER',
		CASE
			WHEN b.STATUS_CONT IN (000,100,200,300,400,450,510,530) AND d.START_INSP IS NULL AND d.FINISH_INSP IS NULL AND z.selesai IS NULL THEN '<span class=\"label label-danger\">BELUM PPK</span>'
			WHEN b.STATUS_CONT IN (000,100,200,300,400,450,510,530) AND d.START_INSP IS NULL AND d.FINISH_INSP IS NULL AND z.selesai IS NOT NULL THEN '<span class=\"label label-danger\">PPK</span>'
			WHEN b.STATUS_CONT = 460 AND d.START_INSP IS NULL AND d.FINISH_INSP IS NULL  AND z.selesai IS NOT NULL THEN '<span class=\"label label-warning\">SIAP PERIKSA</span>'
			WHEN b.STATUS_CONT = 460 AND d.START_INSP IS NOT NULL AND d.FINISH_INSP IS NULL THEN '<span class=\"label label-primary\">SEDANG PERIKSA</span>' 
			WHEN b.STATUS_CONT IN (500,540,520) THEN '<span class=\"label label-success\">SELESAI PERIKSA</span>' 
			WHEN b.STATUS_CONT IN (800,850,870,900,901,902,950) THEN '<span class=\"label label-success\">DELIVERY</span>'
			ELSE '<span class=\"label label-success\">SELESAI PERIKSA</span>'  
		END AS STATUS,
		CONCAT(CASE 
					WHEN z.respon_karantina = 'PKB LONGROOM' OR z.respon_karantina = 'PPK LONGROOM'  
						THEN '<span style=\"color:green;font-weight:bold\">LONGROOM</span>'
					WHEN z.respon_karantina = 'PKB YARD' OR z.respon_karantina = 'PPK YARD' 
						THEN '<span style=\"color:green;font-weight:bold\">YARD</span>'
					WHEN z.respon_karantina = 'NO PKB' OR z.respon_karantina = 'NO PPK'
						THEN '<span style=\"color:green;font-weight:bold\">NO PPK</span>'
					WHEN z.respon_karantina = 'PERIKSA ULANG' 
						THEN '<span style=\"color:green;font-weight:bold\">PERIKSA ULANG</span>'
					WHEN z.respon_karantina = 'PERIKSA TAMBAHAN' 
						THEN '<span style=\"color:green;font-weight:bold\">PERIKSA TAMBAHAN</span>'
					WHEN z.respon_karantina = 'NHI' 
						THEN '<span style=\"color:green;font-weight:bold\">NHI</span>'
					WHEN z.respon_karantina = 'RETURNABLE PACKAGE(RP)' 
						THEN '<span style=\"color:green;font-weight:bold\">RETURNABLE PACKAGE(RP)</span>'
					WHEN z.respon_karantina = 'PIBK' 
						THEN '<span style=\"color:green;font-weight:bold\">PIBK</span>'
					ELSE 
						'<span style=\"color:red;font-weight:bold\">PERCEPATAN</span>'
				END,'<BR>','TANGGAL PPK :',DATE_FORMAT(z.waktu_respon_kr, '%d-%m-%Y %h:%i:%s')
		)AS 'PPKKARANTINA', 
		CONCAT(CASE 
					WHEN z.respon_beacukai = 'PKB LONGROOM' OR z.respon_beacukai = 'PPK LONGROOM'  
						THEN '<span style=\"color:green;font-weight:bold\">LONGROOM</span>'
					WHEN z.respon_beacukai = 'PKB YARD' OR z.respon_beacukai = 'PPK YARD' 
						THEN '<span style=\"color:green;font-weight:bold\">YARD</span>'
					WHEN z.respon_beacukai = 'NO PKB' OR z.respon_beacukai = 'NO PPK'
						THEN '<span style=\"color:green;font-weight:bold\">NO PPK</span>'
					WHEN z.respon_beacukai = 'PERIKSA ULANG' 
						THEN '<span style=\"color:green;font-weight:bold\">PERIKSA ULANG</span>'
					WHEN z.respon_beacukai = 'PERIKSA TAMBAHAN' 
						THEN '<span style=\"color:green;font-weight:bold\">PERIKSA TAMBAHAN</span>'
					WHEN z.respon_beacukai = 'NHI' 
						THEN '<span style=\"color:green;font-weight:bold\">NHI</span>'
					WHEN z.respon_beacukai = 'RETURNABLE PACKAGE(RP)' 
						THEN '<span style=\"color:green;font-weight:bold\">RETURNABLE PACKAGE(RP)</span>'
					WHEN z.respon_beacukai = 'PIBK' 
						THEN '<span style=\"color:green;font-weight:bold\">PIBK</span>'
					ELSE 
						'<span style=\"color:red;font-weight:bold\">PERCEPATAN</span>'
				END,'<BR>','TANGGAL PPK :',DATE_FORMAT(z.waktu_respon_bc, '%d-%m-%Y %h:%i:%s')
		)AS 'PPKBEACUKAI',z.respon_beacukai,z.respon_karantina,j.id_pemeriksa,j.jadwal,f.NAMA, f.NO_TELP, g.NAMA as 'NAMA_BC', g.NO_TELP as 'NO_TELPBC'
		FROM v_ppk_permit_join e
		left JOIN t_gatepass a ON a.NO_DOK = e.NO_RESPON AND a.NO_CONT = e.NO_CONT
		LEFT JOIN t_antrian_respon_ppk_join mm ON e.LNSW_NOAJU = mm.noaju AND e.NO_CONT = mm.no_cont
		LEFT join (SELECT a.NO_DOK,a.TGL_DOK,b.* FROM t_spk a JOIN t_spk_cont b ON a.id =b.id) b ON b.no_dok = e.NO_RESPON AND e.no_cont = b.NO_CONT
		LEFT JOIN t_op_inspection d ON a.NO_CONT = d.NO_CONT AND a.NO_DOK = d.NO_DOK AND a.JNS_KEGIATAN = d.JNS_KEGIATAN
		LEFT JOIN (select * from t_antrian_respon_ppk where reset = 'N') k ON a.ID = k.id_gatepass
		LEFT JOIN v_req_delivery_hdrcont s ON a.NO_CONT = s.NO_CONT AND a.NO_DOK = s.NO_DOK
        left join t_lnsw_responjoin z on e.lnsw_noaju = z.no_aju
        LEFT JOIN t_detail_pemeriksa_join j ON b.no_dok = j.no_dok AND b.tgl_dok = j.tgl_dok AND  b.NO_CONT = j.no_cont
        LEFT JOIN t_pemeriksa_ppk f ON f.ID = j.id_pemeriksa
		LEFT JOIN t_pemeriksa_ppk g ON g.ID = j.id_pemeriksa_bc 
		WHERE  b.ID = '$id'");
		return $SQL->result();
	}
	public function detail_respon_history($id)
	{
		$VAR = explode("~", $id);
		$ID = $VAR[0];
		$NO_DOK = $VAR[1];
		$SQL = $this->db->query("SELECT a.ID,a.NO_CONT,f.*
		FROM t_gatepass a
		LEFT JOIN t_op_inspection d ON a.NO_CONT = d.NO_CONT AND a.NO_DOK = d.NO_DOK AND a.JNS_KEGIATAN = d.JNS_KEGIATAN
		left JOIN t_log_ppk_bc f  ON a.ID = f.id_gatepass
		WHERE a.JNS_KEGIATAN  != 3 AND a.`STATUS` = 'WAITING' AND d.FINISH_INSP IS NULL AND a.JNS_DOK != 'SPPMP' AND DATE(a.TGL_DOK) > DATE_ADD(NOW() , INTERVAL -4 MONTH) AND a.NO_DOK = '$id'
		ORDER BY f.tgl desc");
		return $SQL->result();
	}

	public function detail_respon_white($id)
	{
		$VAR = explode("~", $id);
		$ID = $VAR[0];
		$NO_DOK = $VAR[1];
		$SQL = $this->db->query("SELECT DISTINCT C.ID,K.no_antrian, C.NO_DOK, C.NO_DOK, DATE_FORMAT(C.TGL_DOK, '%d-%m-%Y') AS 'TGL_DOK', B.NO_CONT, B.UKR_CONT AS 'SIZE', CONCAT(B.LOKASI,B.TIER) AS LOKASI, CONCAT('BEHANDLE ',C.JNS_KEGIATAN) AS 'KETERANGAN', C.NAMA_CUST AS 'CUSTOMER', F.FL_PERIKSA,
					CASE
						WHEN B.STATUS_CONT IN (450,510,530) AND D.START_INSP IS NULL AND D.FINISH_INSP IS NULL AND C.RESPON IS NULL THEN '<span class=\"label label-danger\">BELUM PPK</span>'
						WHEN B.STATUS_CONT IN (450,510,530) AND D.START_INSP IS NULL AND D.FINISH_INSP IS NULL AND C.RESPON IS NOT NULL THEN '<span class=\"label label-danger\">PPK</span>'
						WHEN B.STATUS_CONT = 460 AND D.START_INSP IS NULL AND D.FINISH_INSP IS NULL  AND C.RESPON IS NOT NULL THEN '<span class=\"label label-warning\">SIAP PERIKSA</span>'
						WHEN B.STATUS_CONT = 460 AND D.START_INSP IS NOT NULL AND D.FINISH_INSP IS NULL THEN '<span class=\"label label-primary\">SEDANG PERIKSA</span>' 
						WHEN B.STATUS_CONT IN (500,540,520) THEN '<span class=\"label label-success\">SELESAI PERIKSA</span>' 
						WHEN B.STATUS_CONT IN (800,850,870,900,901,902,950) THEN '<span class=\"label label-success\">DELIVERY</span>'
						ELSE '<span class=\"label label-success\">SELESAI PERIKSA</span>'  
					END AS STATUS, 
					CONCAT(CASE 
								WHEN C.RESPON = 'PKB LONGROOM' 
									THEN '<span style=\"color:green;font-weight:bold\">LONGROOM</span>'
								WHEN C.RESPON = 'PKB YARD' 
									THEN '<span style=\"color:green;font-weight:bold\">YARD</span>'
								WHEN C.RESPON = 'NO PKB' 
									THEN '<span style=\"color:green;font-weight:bold\">NO PPK</span>'
								WHEN C.RESPON = 'PERIKSA ULANG' 
									THEN '<span style=\"color:green;font-weight:bold\">PERIKSA ULANG</span>'
								WHEN C.RESPON = 'PERIKSA TAMBAHAN' 
									THEN '<span style=\"color:green;font-weight:bold\">PERIKSA TAMBAHAN</span>'
								WHEN C.RESPON = 'NHI' 
									THEN '<span style=\"color:green;font-weight:bold\">NHI</span>'
								WHEN C.RESPON = 'RETURNABLE PACKAGE(RP)' 
									THEN '<span style=\"color:green;font-weight:bold\">RETURNABLE PACKAGE(RP)</span>'
								WHEN C.RESPON = 'PIBK' 
									THEN '<span style=\"color:green;font-weight:bold\">PIBK</span>'
								ELSE 
									'<span style=\"color:red;font-weight:bold\">PERCEPATAN</span>'
							END,'<BR>','TANGGAL PPK :',DATE_FORMAT(C.WK_RESPON, '%d-%m-%Y %h:%i:%s')
					)AS PKB, DATE_FORMAT(C.WK_RESPON, '%d-%m-%Y %h:%i:%s') AS 'TGL_PPK'
				FROM t_spk A
				INNER JOIN t_spk_cont B ON A.ID = B.ID
				INNER JOIN t_gatepass C ON B.NO_CONT = C.NO_CONT
				INNER JOIN t_permit_hdr E ON A.NO_DOK = E.NO_DAFTAR_PABEAN AND A.TGL_DOK = DATE_FORMAT(E.TGL_DAFTAR_PABEAN, '%Y-%m-%d')
				INNER JOIN t_permit_cont F ON E.ID = F.ID AND B.NO_CONT = F.NO_CONT
				LEFT JOIN t_op_inspection D ON D.NO_CONT = B.NO_CONT AND C.NO_DOK = D.NO_DOK
				LEFT JOIN (select * from t_antrian_respon_ppk where reset = 'N' order by ID desc) K ON C.ID = K.id_gatepass
				WHERE 1=1 AND C.NO_DOK = '" . $NO_DOK . "' GROUP BY B.NO_CONT");
		return $SQL->result();
	}

	public function monitoring_pemeriksa($act, $id)
	{
		$page_title = "MONITORING PEMERIKSA";
		$title = "MONITORING PEMERIKSA";
		$this->newtable->breadcrumb('Dashboard', site_url(), 'icon-home');
		$this->newtable->breadcrumb('MONITORING PEMERIKSA', 'javascript:void(0)', '');
		// $check = (grant()=="W")?true:false;
		if ($this->session->userdata('KD_GROUP') == "USR") {
			if ($this->input->post("ajax")) {
				$VAR = 1;
			} else {
				$VAR = 0;
			}
		} else {
			$VAR = 1;
		}
		$SQL = "SELECT ID,no_antrian  'NO URUT',NO_CONT 'NO_KONTAINER',UKR_CONT 'SIZE', tipe 'TYPE', CONCAT('<b>Jenis: Join Inspection</b><br> No: ',IFNULL(LNSW_NOAJU,'-'),'<br> Tanggal: ',IFNULL(LNSW_TGLAJU,'-')) AS 'DOKUMEN JOIN INSPECTION', CONCAT('<b>Jenis: Karantina </b><br> No: ',IFNULL(NO_RESPON,'-'),'<br> Tanggal: ',IFNULL(TG_RESPON,'-'),'<br><br><b>Jenis: Bea Cukai </b><br> No: ',IFNULL(NO_DAFTAR_PABEAN,'-'),'<br> Tanggal: ',IFNULL(date_format(TGL_DAFTAR_PABEAN, '%Y-%m-%d'),'-') ) AS 'DOKUMEN KARANTINA DAN BEACUKAI', LOKASI 'LOKASI',
		CASE 
			WHEN STATUS2 = 1 THEN 'SIAP PERIKSA'
			WHEN STATUS2 = 2 THEN 'IPK'
			WHEN STATUS2 = 3 THEN 'BELUM IPK'
			WHEN STATUS2 = 4 THEN 'SEDANG PERIKSA'
			WHEN STATUS2 = 5 THEN 'WAITING'
			WHEN STATUS2 = 6 THEN 'SELESAI PERIKSA' 
		END 'STATUS',CONCAT('Karantina <br>Nama: ',IFNULL(nama,'-'),'<br>Nomor Telp: ',IFNULL(no_telp,'-'),'<br><br>Bea Cukai<br>Nama: ',IFNULL(namabc,'-'),'<br>Nomor Telp: ',IFNULL(notelpbc,'-')) AS 'INFORMASI PEMERIKSA', jadwal 'JADWAL PERIKSA',STATUS2
		FROM (SELECT a.JNS_KEGIATAN,a.ID,mm.no_antrian,a.NO_CONT,a.UKR_CONT,a.TGL_DOK,a.JNS_DOK,a.`STATUS`,a.NO_DOK,b.LOKASI,CONCAT('BEHANDLE ',a.JNS_KEGIATAN) KEGIATAN,a.NAMA_CUST,b.STATUS_CONT,d.START_INSP,d.FINISH_INSP,a.RESPON,a.WK_RESPON,ad.no_aju,ad.tgl_aju,ad.dok_karantina,ad.tgl_karantina,ad.dok_beacukai,ad.tgl_beacukai,ad.waktu_respon_bc, ad.waktu_respon_kr,ad.respon_karantina,ad.respon_beacukai,k.NO_RESPON,k.TG_RESPON,k.NO_DAFTAR_PABEAN,k.TGL_DAFTAR_PABEAN,k.LNSW_NOAJU,k.LNSW_TGLAJU,al.jadwal,al.jadwal_bc, al.nama, al.no_telp,al.namabc,al.notelpbc,
		CASE
			WHEN b.STATUS_CONT IN (450,510,530) AND d.START_INSP IS NULL AND d.FINISH_INSP IS NULL AND a.RESPON IS NULL THEN 3
			WHEN b.STATUS_CONT IN (450,510,530) AND d.START_INSP IS NULL AND d.FINISH_INSP IS NULL AND a.RESPON IS NOT NULL THEN 2
			WHEN b.STATUS_CONT = 460 AND d.START_INSP IS NULL AND d.FINISH_INSP IS NULL  AND a.RESPON IS NOT NULL THEN 1
			WHEN b.STATUS_CONT = 460 AND d.START_INSP IS NOT NULL AND d.FINISH_INSP IS NULL THEN 4
			WHEN b.STATUS_CONT = 450 AND d.START_INSP IS NOT NULL AND d.FINISH_INSP IS NOT NULL THEN 6
			WHEN b.STATUS_CONT IN (500,540,520) THEN 6 
			ELSE 5 
		END AS STATUS2,s.NOTE,t.tipe_cont AS tipe 
		FROM t_gatepass a
		JOIN v_ppk_permit_join k ON a.NO_DOK = k.no_respon AND a.no_cont = k.no_cont OR a.NO_DOK = k.no_daftar_pabean AND a.no_cont = k.no_cont
		LEFT JOIN t_antrian_respon_ppk_join mm ON k.LNSW_NOAJU = mm.noaju AND k.NO_CONT = mm.no_cont
		LEFT JOIN (SELECT ak.jadwal,ak.jadwal_bc, aj.nama, aj.no_telp, ak.no_dok, ak.no_cont, ak.tgl_dok,am.nama AS namabc,am.NO_TELP AS notelpbc FROM t_detail_pemeriksa_join ak join t_pemeriksa_ppk aj ON ak.id_pemeriksa = aj.id LEFT JOIN t_pemeriksa_ppk am on ak.id_pemeriksa_bc = am.id) al ON (a.NO_DOK = k.no_respon OR a.NO_DOK = k.NO_DAFTAR_PABEAN) AND al.no_cont = a.no_cont
		LEFT JOIN t_lnsw_responjoin ad ON a.NO_DOK = ad.dok_karantina AND a.TGL_DOK = ad.tgl_karantina or a.NO_DOK = ad.dok_beacukai AND a.TGL_DOK = ad.tgl_beacukai
		left JOIN (SELECT * FROM t_spk_cont WHERE STATUS_CONT != 900) b on a.NO_CONT = b.NO_CONT 
		JOIN t_spk c ON c.ID = b.ID
		LEFT JOIN t_op_inspection d ON a.NO_CONT = d.NO_CONT AND a.NO_DOK = d.NO_DOK
		LEFT JOIN (select * from t_antrian_respon_ppk where reset = 'N') k ON a.ID = k.id_gatepass
		LEFT JOIN t_job_slip s ON c.NO_SPK = s.NO_SPK AND a.NO_CONT = s.NO_CONT AND s.JENIS = CONCAT('BEHANDLE ',a.JNS_KEGIATAN)
		LEFT JOIN (SELECT a.id, a.no_dok, a.tgl_dok, b.NO_CONT, b.UKR_CONT, b.tipe_cont
						FROM t_request a
						JOIN t_request_cont b ON a.id = b.id ) t ON c.NO_DOK = t.no_dok AND t.no_cont = a.no_cont
		WHERE  a.JNS_KEGIATAN  != 3 ) az WHERE (STATUS = 'DONE' AND JNS_KEGIATAN = 2) OR STATUS = 'WAITING'";

		$q2 = $this->db->query("SELECT STATUS,COUNT(ID) JML FROM (SELECT ID,no_antrian  'NO URUT',NO_CONT 'NO_KONTAINER',UKR_CONT 'UKURAN',TGL_DOK 'TANGGAL DOKUMEN',JNS_DOK 'JENIS',NO_DOK 'NO_DOKUMEN',LOKASI 'LOKASI',KEGIATAN,NAMA_CUST 'COSTUMER',
		CASE 
			WHEN STATUS2 = 1 THEN 'SIAP PERIKSA'
			WHEN STATUS2 = 2 THEN 'IPK'
			WHEN STATUS2 = 3 THEN 'BELUM IPK'
			WHEN STATUS2 = 4 THEN 'SEDANG PERIKSA'
			WHEN STATUS2 = 5 THEN 'WAITING'
			WHEN STATUS2 = 6 THEN 'SELESAI PERIKSA' 
		END 'STATUS',
		START_INSP 'START PERIKSA',FINISH_INSP 'FINISH PERIKSA',RESPON,WK_RESPON 'WAKTU RESPON',STATUS2 
		FROM (SELECT a.JNS_KEGIATAN,a.ID,k.no_antrian,a.NO_CONT,a.UKR_CONT,a.TGL_DOK,a.JNS_DOK,a.`STATUS`,a.NO_DOK,b.LOKASI,CONCAT('BEHANDLE ',a.JNS_KEGIATAN) KEGIATAN,a.NAMA_CUST,b.STATUS_CONT,d.START_INSP,d.FINISH_INSP,a.RESPON,a.WK_RESPON,
		CASE
			WHEN b.STATUS_CONT IN (450,510,530) AND d.START_INSP IS NULL AND d.FINISH_INSP IS NULL AND a.RESPON IS NULL THEN 3
			WHEN b.STATUS_CONT IN (450,510,530) AND d.START_INSP IS NULL AND d.FINISH_INSP IS NULL AND a.RESPON IS NOT NULL THEN 2
			WHEN b.STATUS_CONT = 460 AND d.START_INSP IS NULL AND d.FINISH_INSP IS NULL  AND a.RESPON IS NOT NULL THEN 1
			WHEN b.STATUS_CONT = 460 AND d.START_INSP IS NOT NULL AND d.FINISH_INSP IS NULL THEN 4
			WHEN b.STATUS_CONT = 450 AND d.START_INSP IS NOT NULL AND d.FINISH_INSP IS NOT NULL THEN 6
			WHEN b.STATUS_CONT IN (500,540,520) THEN 6 
			ELSE 5 
		END AS STATUS2 
		FROM t_gatepass a
		JOIN v_ppk_permit_join k ON a.NO_DOK = k.no_respon AND a.no_cont = k.no_cont
		LEFT JOIN t_lnsw_responjoin ad ON a.NO_DOK = ad.dok_karantina AND a.TGL_DOK = ad.tgl_karantina or a.NO_DOK = ad.dok_beacukai AND a.TGL_DOK = ad.tgl_beacukai
		left JOIN (SELECT * FROM t_spk_cont WHERE STATUS_CONT != 900) b on a.NO_CONT = b.NO_CONT 
		JOIN t_spk c ON c.ID = b.ID
		LEFT JOIN t_op_inspection d ON a.NO_CONT = d.NO_CONT AND a.NO_DOK = d.NO_DOK
		LEFT JOIN (select * from t_antrian_respon_ppk where reset = 'N') k ON a.ID = k.id_gatepass
		WHERE  a.JNS_KEGIATAN  != 3) az WHERE (STATUS = 'DONE' AND JNS_KEGIATAN = 2) OR STATUS = 'WAITING') ass
		GROUP BY status")->result();

		$jsiapperiksa = 0;
		$jppk = 0;
		$jbelumppk = 0;
		$jwaiting = 0;
		$jsedang = 0;
		$jselesai = 0;

		foreach ($q2 as $key => $v) {
			if ($v->STATUS == 'BELUM IPK') {
				$jbelumppk = $v->JML;
			}
			if ($v->STATUS == 'IPK') {
				$jppk = $v->JML;
			}
			if ($v->STATUS == 'SEDANG PERIKSA') {
				$jsedang = $v->JML;
			}
			if ($v->STATUS == 'SELESAI PERIKSA') {
				$jselesai = $v->JML;
			}
			if ($v->STATUS == 'SIAP PERIKSA') {
				$jsiapperiksa = $v->JML;
			}
			if ($v->STATUS == 'WAITING') {
				$jwaiting = $v->JML;
			}
		}


		$this->newtable->multiple_search(true);
		$this->newtable->show_chk(false);
		$this->newtable->show_menu(true);
		$this->newtable->show_search(true);

		$proses = array(

			'siap periksa'  => array('GET', '', '2', '', '#76ff03', 'Siap Periksa : ' . $jsiapperiksa . '', 'ycustom'),
			'ipk'  => array('GET', '', '2', '', 'red', 'IPK : ' . $jppk . '', 'ycustom'),
			'belum ipk'  => array('GET', '', '2', '', '#9aa58c', 'Belum IPK : ' . $jbelumppk . '', 'ycustom'),
			'waiting'  => array('GET', '', '2', '', '#ffee33', 'Waiting List : ' . $jwaiting . '', 'ycustom'),
			'sedang periksa'  => array('GET', '', '2', '', '#33bfff', 'Sedang Periksa : ' . $jsedang . '', 'ycustom'),
			'selesai periksa'  => array('GET', '', '2', '', '#2a3eb1;color:white!important', 'Selesai Periksa : ' . $jselesai . '', 'ycustom')
		);

		$this->newtable->search(array(array('az.NO_CONT', 'NO. KONTAINER'), array('az.nama', 'NAMA PEMERIKSA', 'PEMERIKSA_JI'), array('az.LNSW_NOAJU', 'NO. DOKUMEN', 'DOKUMEN_JI'), array('az.LNSW_TGLAJU', 'TGL. DOKUMEN', 'DATERANGE_JI')));
		$this->newtable->action(site_url() . "/display/monitoring_pemeriksa");
		// $this->newtable->detail(array('DRILLDOWN',"display/pergerakan_jinspection/detail"));
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("ID", "STATUS2"));
		$this->newtable->keys(array("ID", "NO_DOKUMEN", "NO_KONTAINER"));
		$this->newtable->cidb($this->db);
		$this->newtable->groupby();
		$this->newtable->orderby("STATUS2,WK_RESPON");
		$this->newtable->sortby("");
		$this->newtable->set_formid("tblmonitoring_pemeriksa");
		$this->newtable->set_divid("divmonitoring_pemeriksa");
		$this->newtable->rowcount(10);
		$this->newtable->clear();
		$this->newtable->menu($proses);
		$tabel .= $this->newtable->generate_custom($SQL);
		$arrdata = array("page_title" => $page_title, "title" => $title, "content" => $tabel);
		if ($this->input->post("ajax") || $act == "post")
			return $tabel;
		else
			return $arrdata;
	}

	public function pergerakan_jinspection($act, $id)
	{
		$page_title = "PERGERAKAN JOIN INSPECTION";
		$title = "PERGERAKAN JOIN INSPECTION";
		$this->newtable->breadcrumb('Dashboard', site_url(), 'icon-home');
		$this->newtable->breadcrumb('Customs', 'javascript:void(0)', '');
		$this->newtable->breadcrumb('Pergerakan Join Inspection', 'javascript:void(0)', '');
		$check = (grant() == "W") ? true : false;
		if ($this->session->userdata('KD_GROUP') == "USR") {
			if ($this->input->post("ajax")) {
				$VAR = 1;
			} else {
				$VAR = 0;
			}
		} else {
			$VAR = 1;
		}
		$SQL = "SELECT id_pemeriksa 'id_pemeriksa_kr',ID,no_antrian  'NO URUT',NO_CONT 'NO_KONTAINER',UKR_CONT 'SIZE', tipe 'TYPE', CONCAT('<b style=\"display: inline-block;width: 189px;\">Jenis: Join Inspection</b><br> No: ',LNSW_NOAJU,'<br> Tanggal: ',LNSW_TGLAJU,'<b><br><br>Jenis: Karantina </b><br> No: ',NO_RESPON,'<br> Tanggal: ',TG_RESPON,'<br><br><b>Jenis: Bea Cukai </b><br> No: ',NO_DAFTAR_PABEAN,'<br> Tanggal: ',date_format(TGL_DAFTAR_PABEAN, '%Y-%m-%d')) AS 'DOKUMEN', LOKASI 'LOKASI',NAMA_CUST 'COSTUMER', NO_RESPON,
		CASE 
			WHEN STATUS2 = 1 THEN 'SIAP PERIKSA'
			WHEN STATUS2 = 2 THEN 'IPK'
			WHEN STATUS2 = 3 THEN 'BELUM IPK'
			WHEN STATUS2 = 4 THEN 'SEDANG PERIKSA'
			WHEN STATUS2 = 5 THEN 'WAITING'
			WHEN STATUS2 = 6 THEN 'SELESAI PERIKSA' 
		END 'STATUS',
		START_INSP 'START PERIKSA',FINISH_INSP 'FINISH PERIKSA',respon_karantina 'RESPON PKB',waktu_respon_kr 'WAKTU RESPON', CONCAT('Karantina <br>Nama: ',IFNULL(nama,'-'),'<br>Nomor Telp: ',IFNULL(no_telp,'-'),'<br><br>Bea Cukai<br>Nama: ',IFNULL(namabc,'-'),'<br>Nomor Telp: ',IFNULL(notelpbc,'-')) AS 'INFORMASI PEMERIKSA', jadwal 'JADWAL PERIKSA',
		STATUS2 
		FROM (SELECT a.JNS_KEGIATAN,a.ID,mm.no_antrian,a.NO_CONT,a.UKR_CONT,a.TGL_DOK,a.JNS_DOK,a.`STATUS`,a.NO_DOK,b.LOKASI,CONCAT('BEHANDLE ',a.JNS_KEGIATAN) KEGIATAN,a.NAMA_CUST,b.STATUS_CONT,d.START_INSP,d.FINISH_INSP,a.RESPON,a.WK_RESPON,ad.no_aju,ad.tgl_aju,ad.dok_karantina,ad.tgl_karantina,ad.dok_beacukai,ad.tgl_beacukai,ad.waktu_respon_bc, ad.waktu_respon_kr,ad.respon_karantina,ad.respon_beacukai,k.NO_RESPON,k.TG_RESPON,k.NO_DAFTAR_PABEAN,k.TGL_DAFTAR_PABEAN,k.LNSW_NOAJU,k.LNSW_TGLAJU, al.jadwal,al.jadwal_bc, al.nama, al.no_telp,al.namabc,al.notelpbc,al.id_pemeriksa,
		CASE
			WHEN b.STATUS_CONT IN (450,510,530) AND d.START_INSP IS NULL AND d.FINISH_INSP IS NULL AND a.RESPON IS NULL THEN 3
			WHEN b.STATUS_CONT IN (450,510,530) AND d.START_INSP IS NULL AND d.FINISH_INSP IS NULL AND a.RESPON IS NOT NULL THEN 2
			WHEN b.STATUS_CONT = 460 AND d.START_INSP IS NULL AND d.FINISH_INSP IS NULL  AND a.RESPON IS NOT NULL THEN 1
			WHEN b.STATUS_CONT = 460 AND d.START_INSP IS NOT NULL AND d.FINISH_INSP IS NULL THEN 4
			WHEN b.STATUS_CONT = 450 AND d.START_INSP IS NOT NULL AND d.FINISH_INSP IS NOT NULL THEN 6
			WHEN b.STATUS_CONT IN (500,540,520) THEN 6 
			ELSE 5 
		END AS STATUS2,s.NOTE,t.tipe_cont AS tipe 
		FROM t_gatepass a
		JOIN v_ppk_permit_join k ON a.NO_DOK = k.no_respon AND a.no_cont = k.no_cont OR a.NO_DOK = k.no_daftar_pabean AND a.no_cont = k.no_cont
		LEFT JOIN t_antrian_respon_ppk_join mm ON k.LNSW_NOAJU = mm.noaju AND k.NO_CONT = mm.no_cont
		LEFT JOIN (SELECT ak.id_pemeriksa,ak.jadwal,ak.jadwal_bc, aj.nama, aj.no_telp, ak.no_dok, ak.no_cont, ak.tgl_dok,am.nama AS namabc,am.NO_TELP AS notelpbc FROM t_detail_pemeriksa_join ak join t_pemeriksa_ppk aj ON ak.id_pemeriksa = aj.id LEFT JOIN t_pemeriksa_ppk am on ak.id_pemeriksa_bc = am.id) al ON (a.NO_DOK = k.no_respon OR a.NO_DOK = k.NO_DAFTAR_PABEAN)  AND al.no_cont = a.no_cont
		LEFT JOIN t_lnsw_responjoin ad ON a.NO_DOK = ad.dok_karantina AND a.TGL_DOK = ad.tgl_karantina or a.NO_DOK = ad.dok_beacukai AND a.TGL_DOK = ad.tgl_beacukai
		left JOIN (SELECT * FROM t_spk_cont WHERE STATUS_CONT != 900) b on a.NO_CONT = b.NO_CONT 
		JOIN t_spk c ON c.ID = b.ID
		LEFT JOIN t_op_inspection d ON a.NO_CONT = d.NO_CONT AND a.NO_DOK = d.NO_DOK
		LEFT JOIN (select * from t_antrian_respon_ppk where reset = 'N') k ON a.ID = k.id_gatepass
		LEFT JOIN t_job_slip s ON c.NO_SPK = s.NO_SPK AND a.NO_CONT = s.NO_CONT AND s.JENIS = CONCAT('BEHANDLE ',a.JNS_KEGIATAN)
		LEFT JOIN (SELECT a.id, a.no_dok, a.tgl_dok, b.NO_CONT, b.UKR_CONT, b.tipe_cont
						FROM t_request a
						JOIN t_request_cont b ON a.id = b.id ) t ON c.NO_DOK = t.no_dok AND t.no_cont = a.no_cont
		WHERE  a.JNS_KEGIATAN  != 3) az WHERE (STATUS = 'DONE' AND JNS_KEGIATAN = 2) OR STATUS = 'WAITING'";

		$q2 = $this->db->query("SELECT STATUS,COUNT(ID) JML,id_pemeriksa FROM (SELECT ID,no_antrian  'NO URUT',NO_CONT 'NO_KONTAINER',UKR_CONT 'UKURAN',TGL_DOK 'TANGGAL DOKUMEN',JNS_DOK 'JENIS',NO_DOK 'NO_DOKUMEN',LOKASI 'LOKASI',KEGIATAN,NAMA_CUST 'COSTUMER', id_pemeriksa,
		CASE 
			WHEN STATUS2 = 1 THEN 'SIAP PERIKSA'
			WHEN STATUS2 = 2 THEN 'IPK'
			WHEN STATUS2 = 3 THEN 'BELUM IPK'
			WHEN STATUS2 = 4 THEN 'SEDANG PERIKSA'
			WHEN STATUS2 = 5 THEN 'WAITING'
			WHEN STATUS2 = 6 THEN 'SELESAI PERIKSA' 
		END 'STATUS',
		START_INSP 'START PERIKSA',FINISH_INSP 'FINISH PERIKSA',RESPON,WK_RESPON 'WAKTU RESPON',STATUS2 
		FROM (SELECT a.JNS_KEGIATAN,a.ID,k.no_antrian,a.NO_CONT,a.UKR_CONT,a.TGL_DOK,a.JNS_DOK,a.`STATUS`,a.NO_DOK,b.LOKASI,CONCAT('BEHANDLE ',a.JNS_KEGIATAN) KEGIATAN,a.NAMA_CUST,b.STATUS_CONT,d.START_INSP,d.FINISH_INSP,a.RESPON,a.WK_RESPON, ak.id_pemeriksa,
		CASE
			WHEN b.STATUS_CONT IN (450,510,530) AND d.START_INSP IS NULL AND d.FINISH_INSP IS NULL AND a.RESPON IS NULL THEN 3
			WHEN b.STATUS_CONT IN (450,510,530) AND d.START_INSP IS NULL AND d.FINISH_INSP IS NULL AND a.RESPON IS NOT NULL THEN 2
			WHEN b.STATUS_CONT = 460 AND d.START_INSP IS NULL AND d.FINISH_INSP IS NULL  AND a.RESPON IS NOT NULL THEN 1
			WHEN b.STATUS_CONT = 460 AND d.START_INSP IS NOT NULL AND d.FINISH_INSP IS NULL THEN 4
			WHEN b.STATUS_CONT = 450 AND d.START_INSP IS NOT NULL AND d.FINISH_INSP IS NOT NULL THEN 6
			WHEN b.STATUS_CONT IN (500,540,520) THEN 6 
			ELSE 5 
		END AS STATUS2 
		FROM t_gatepass a
		JOIN v_ppk_permit_join k ON a.NO_DOK = k.no_respon AND a.no_cont = k.no_cont OR a.NO_DOK = k.no_daftar_pabean AND a.no_cont = k.no_cont
		LEFT JOIN t_detail_pemeriksa_join ak on a.NO_DOK = k.no_respon  AND ak.no_cont = a.no_cont
		LEFT JOIN t_lnsw_responjoin ad ON a.NO_DOK = ad.dok_karantina AND a.TGL_DOK = ad.tgl_karantina or a.NO_DOK = ad.dok_beacukai AND a.TGL_DOK = ad.tgl_beacukai
		left JOIN (SELECT * FROM t_spk_cont WHERE STATUS_CONT != 900) b on a.NO_CONT = b.NO_CONT 
		JOIN t_spk c ON c.ID = b.ID
		LEFT JOIN t_op_inspection d ON a.NO_CONT = d.NO_CONT AND a.NO_DOK = d.NO_DOK
		LEFT JOIN (select * from t_antrian_respon_ppk where reset = 'N') k ON a.ID = k.id_gatepass
		WHERE  a.JNS_KEGIATAN  != 3) az WHERE (STATUS = 'DONE' AND JNS_KEGIATAN = 2) OR STATUS = 'WAITING') ass
		GROUP BY status")->result();

		$jsiapperiksa = 0;
		$jppk = 0;
		$jbelumppk = 0;
		$jwaiting = 0;
		$jsedang = 0;
		$jselesai = 0;
		$pemeriksakr = "set_pemeriksa";
		$tipe = "MODAL";
		// var_dump($q2['id_pemeriksa']);die();

		foreach ($q2 as $key => $v) {
			if ($v->STATUS == 'BELUM IPK') {
				$jbelumppk = $v->JML;
			}
			if ($v->STATUS == 'IPK') {
				$jppk = $v->JML;
			}
			if ($v->STATUS == 'SEDANG PERIKSA') {
				$jsedang = $v->JML;
			}
			if ($v->STATUS == 'SELESAI PERIKSA') {
				$jselesai = $v->JML;
			}
			if ($v->STATUS == 'SIAP PERIKSA') {
				$jsiapperiksa = $v->JML;
			}
			if ($v->STATUS == 'WAITING') {
				$jwaiting = $v->JML;
			}
			// if ($v->id_pemeriksa == null) {$pemeriksakr = "set_pemeriksa_gagal";$tipe="POST_KR";}
		}




		$this->newtable->multiple_search(true);
		$this->newtable->show_chk(false);
		$this->newtable->show_menu($check);
		$this->newtable->show_search(true);
		// var_dump($pemeriksakr);die();
		if ($this->session->userdata('KD_GROUP') == "BC") {
			$proses = array(
				// 'EXPORT EXCEL' => array('EXCEL', "process/excel/pergerakan_jinspection/".$act, '0','','md-file-text','','menu'),
				'siap periksa'  => array('GET', '', '2', '', '#76ff03', 'Siap Periksa : ' . $jsiapperiksa . '', 'ycustom'),
				'ipk'  => array('GET', '', '2', '', 'red', 'IPK : ' . $jppk . '', 'ycustom'),
				'belum ipk'  => array('GET', '', '2', '', '#9aa58c', 'Belum Ipk : ' . $jbelumppk . '', 'ycustom'),
				'waiting'  => array('GET', '', '2', '', '#ffee33', 'Waiting List : ' . $jwaiting . '', 'ycustom'),
				'sedang periksa'  => array('GET', '', '2', '', '#33bfff', 'Sedang Periksa : ' . $jsedang . '', 'ycustom'),
				'selesai periksa'  => array('GET', '', '2', '', '#2a3eb1;color:white!important', 'Selesai Periksa : ' . $jselesai . '', 'ycustom'),
				'Set Sedang Periksa' => array('POST', "display/pergerakan/setpemeriksaan", '1', '', 'md-badge-check', '', 'list'),
				'Set Pemeriksa - Jadwal' => array($tipe, "display/pergerakan_jinspection/" . $pemeriksakr . "/" . $id, '1', '', 'md-layers', '', 'list')


			);
		} else {
			$proses = array(
				// 'EXPORT EXCEL' => array('EXCEL', "process/excel/pergerakan_jinspection/".$act, '0','','md-file-text','','menu'),
				'siap periksa'  => array('GET', '', '2', '', '#76ff03', 'Siap Periksa : ' . $jsiapperiksa . '', 'ycustom'),
				'ipk'  => array('GET', '', '2', '', 'red', 'IPK : ' . $jppk . '', 'ycustom'),
				'belum ipk'  => array('GET', '', '2', '', '#9aa58c', 'Belum IPK : ' . $jbelumppk . '', 'ycustom'),
				'waiting'  => array('GET', '', '2', '', '#ffee33', 'Waiting List : ' . $jwaiting . '', 'ycustom'),
				'sedang periksa'  => array('GET', '', '2', '', '#33bfff', 'Sedang Periksa : ' . $jsedang . '', 'ycustom'),
				'selesai periksa'  => array('GET', '', '2', '', '#2a3eb1;color:white!important', 'Selesai Periksa : ' . $jselesai . '', 'ycustom')
			);
		}
		$this->newtable->search(array(array('az.NO_CONT', 'NO. KONTAINER'), array('az.nama', 'NAMA PEMERIKSA', 'PEMERIKSA_JI'), array('az.LNSW_NOAJU', 'NO. DOKUMEN', 'DOKUMEN_JI'), array('az.LNSW_TGLAJU', 'TGL. DOKUMEN', 'DATERANGE_JI')));
		$this->newtable->action(site_url() . "/display/pergerakan_jinspection");
		$this->newtable->detail(array('DRILLDOWN', "display/pergerakan_jinspection/detail"));
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("ID", "STATUS2", "NO_RESPON", "id_pemeriksa_kr"));
		$this->newtable->keys(array("ID", "NO_RESPON", "NO_KONTAINER", "id_pemeriksa_kr"));
		$this->newtable->cidb($this->db);
		$this->newtable->groupby();
		$this->newtable->orderby("STATUS2,WK_RESPON");
		$this->newtable->sortby("");
		$this->newtable->set_formid("tblcustomspergerakan_jinspection");
		$this->newtable->set_divid("divcustomspergerakan_jinspection");
		$this->newtable->rowcount(50);
		$this->newtable->clear();
		$this->newtable->menu($proses);
		$tabel .= $this->newtable->generate_custom($SQL);
		$arrdata = array("page_title" => $page_title, "title" => $title, "content" => $tabel);
		if ($this->input->post("ajax") || $act == "post")
			return $tabel;
		else
			return $arrdata;
	}

	public function set_pemeriksa_simpan($act, $id)
	{
		$func = get_instance();
		$func->load->model("m_main", "main");

		foreach ($this->input->post('DATA') as $a => $b) {
			if ($b == "") unset($DATA[$a]);
			else $DATA[$a] = trim($b);
		}
		$hasil = $this->db->query("SELECT * FROM t_pemeriksa_ppk WHERE nama = '" . $DATA['PEMERIKSA_BC'] . "'")->num_rows();

		if ($hasil == 0) {
			// var_dump("Pemeriksa Tidak Terdaftar");die();
			echo "MSG#ERR#Pemeriksa Tidak Terdaftar#";
			return false;
		}
		if ($DATA['id_pemeriksa_bc'] == "") {
			// var_dump("Pemeriksa Tidak Terdaftar");die();
			echo "MSG#ERR#Anda Belum Memilih Nama Pemeriksa#";
			return false;
		}

		$DATA2 = array('id_pemeriksa_bc' => $DATA['id_pemeriksa_bc'], 'jadwal_bc' => $DATA['jadwal_bc']);

		$this->db->where(array('no_cont' => $DATA['NO_CONT'], 'no_dok' => $DATA['no_dok']));
		$this->db->update('t_detail_pemeriksa_join', $DATA2);

		echo "MSG#OK#Data Berhasil Diproses#" . $this->input->post('action');
	}

	public function detail_pergerakan_jinspection($act, $id)
	{
		$VAR = explode("~", $id);
		$ID = $VAR[0];
		$NO_DOK = $VAR[1];
		$NO_CONT = $VAR[2];
		$SQL = $this->db->query("SELECT DISTINCT C.ID, C.JNS_DOK, C.NO_DOK, C.TGL_DOK, C.NAMA_CUST, C.NO_CONT, C.UKR_CONT, C.WK_REK, C.WK_RESPON, E.WK_STATUS, D.START_INSP, D.FINISH_INSP, F.NOTE, k.NO_RESPON, k.TG_RESPON, k.NO_DAFTAR_PABEAN, DATE_FORMAT(k.TGL_DAFTAR_PABEAN,'%Y-%m-%d') 'TGL_DAFTAR_PABEAN', k.LNSW_NOAJU, k.LNSW_TGLAJU
		FROM  t_gatepass C
		JOIN v_ppk_permit_join k ON C.NO_DOK = k.no_respon AND C.no_cont = k.no_cont
		LEFT JOIN t_op_inspection D ON D.NO_CONT = C.NO_CONT AND C.NO_DOK = D.NO_DOK
		LEFT JOIN (SELECT DISTINCT NO_CONT, NO_DOK, NO_GATEPASS, LOKASI_AKHIR, WK_STATUS FROM t_job_slip A WHERE SUBSTRING(A.LOKASI_AKHIR, 1, 3) = 'CIC' GROUP BY NO_CONT ORDER BY ID_JOB_SLIP ASC) E ON C.NO_CONT = E.NO_CONT AND C.NO_DOK = E.NO_DOK
		LEFT JOIN (SELECT DISTINCT NO_CONT, NO_DOK, NOTE FROM t_job_slip A WHERE SUBSTRING(A.LOKASI_AWAL, 1, 3) = 'CIC' GROUP BY NO_CONT ORDER BY ID_JOB_SLIP ASC) F ON C.NO_CONT = F.NO_CONT AND C.NO_DOK = F.NO_DOK
		WHERE C.ID = '$ID'");
		return $SQL->row_array();
	}

	public function prosesonline($type, $act, $id)
	{
		$func = get_instance();
		$func->load->model("m_main", "main", true);
		$success = 0;
		$error = 0;
		$message = "";
		if ($type == "update") {
			if ($act == "prosesonline") {
				$Active 	= $this->db->query("SELECT A.id, A.fl_status FROM list_dokumen_user A where A.id = '$id' and A.fl_status='N'")->row_array();

				if ($Active['fl_status'] == 'N') {
					$this->db->where('id', $id);
					$DATA['fl_status'] = "Y";
					$test = $this->db->update("list_dokumen_user", $DATA);

					if ($test) {
						$action = "/display/monitorOrderOnline";
						echo "MSG#OK#DATA BERHASIL DIPROSES#" . site_url() . $action;
					} else {
						echo "MSG#ERR#Data gagal diprose#";
					}
				}
			}
		}
	}

	public function prosesonlinee($type, $act, $id)
	{
		$func = get_instance();
		$func->load->model("m_main", "main", true);
		$success = 0;
		$error = 0;
		$message = "";
		if ($type == "update") {
			if ($act == "prosesonlinee") {
				$Active 	= $this->db->query("SELECT A.id, A.fl_status FROM list_dokumen_user A where A.id = '$id' and A.fl_status='N'")->row_array();

				if ($Active['fl_status'] == 'N') {
					$this->db->where('id', $id);
					$DATA['fl_status'] = "Y";
					$test = $this->db->update("list_dokumen_user", $DATA);

					if ($test) {
						$action = "/display/monitorOrderOnline";
						echo "MSG#OK#DATA BERHASIL DIPROSES#" . site_url() . $action;
					} else {
						echo "MSG#ERR#Data gagal diprose#";
					}
				}
			}
		}
	}


	function SendCurl1($xml, $url, $SOAPAction, $proxy = "", $port = "443")
	{
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
			if ($act == "pergerakan_jinspection") {
				$no_dok = $this->input->post('form[0][0]');
				$tgl_dok_start = $this->input->post('form[1][0]');
				$tgl_dok_end = $this->input->post('form[1][1]');
				$no_kontainer = $this->input->post('form[2][0]');

				$addsql = "";



				if ($tgl_dok_start != "" && $tgl_dok_end != "") {
					$addsql .= " AND az.TGL_DOK >= '$tgl_dok_start' AND az.TGL_DOK <= '$tgl_dok_end'";

					$time1 = strtotime($tgl_dok_start);
					$newformat1 = date('d M Y', $time1);

					$time2 = strtotime($tgl_dok_end);
					$newformat2 = date('d M Y', $time2);

					$time = $newformat1 . "-" . $newformat2;
				} else if ($tgl_dok_start != "") {
					$addsql .= " AND az.TGL_DOK >= '$tgl_dok_start'";
					$time1 = strtotime($tgl_dok_start);
					$newformat1 = date('d M Y', $time1);
					$time = $newformat1;
				} else if ($tgl_dok_end != "") {
					$addsql .= " AND az.TGL_DOK <= '$tgl_dok_end'";
					$time2 = strtotime($tgl_dok_end);
					$newformat2 = date('d M Y', $time2);
					$time = $newformat2;
				} else {
					$time = date('d M Y');
				}



				if ($no_dok != "") {
					$addsql .= " AND az.NO_DOK like '%$no_dok%'";
				}
				if ($no_kontainer != "") {
					$addsql .= " AND az.NO_CONT like '%$no_kontainer%' ";
				}

				$SQL = "SELECT ID,no_antrian,NO_CONT,UKR_CONT, tipe,TGL_DOK,JNS_DOK,NO_DOK,LOKASI,KEGIATAN,NAMA_CUST,
					CASE 
						WHEN STATUS2 = 1 THEN 'SIAP PERIKSA'
						WHEN STATUS2 = 2 THEN 'PPK'
						WHEN STATUS2 = 3 THEN 'BELUM PPK'
						WHEN STATUS2 = 4 THEN 'SEDANG PERIKSA'
						WHEN STATUS2 = 5 THEN 'WAITING'
						WHEN STATUS2 = 6 THEN 'SELESAI PERIKSA' 
					END 'STATUS',
					START_INSP,FINISH_INSP,RESPON,WK_RESPON,STATUS2 
					FROM (SELECT a.ID,k.no_antrian,a.NO_CONT,a.UKR_CONT,a.TGL_DOK,a.JNS_DOK,a.`STATUS`,a.NO_DOK,b.LOKASI,CONCAT('BEHANDLE ',a.JNS_KEGIATAN) KEGIATAN,a.NAMA_CUST,b.STATUS_CONT,d.START_INSP,d.FINISH_INSP,a.RESPON,a.WK_RESPON,
					CASE
						WHEN b.STATUS_CONT IN (450,510,530) AND d.START_INSP IS NULL AND d.FINISH_INSP IS NULL AND a.RESPON IS NULL THEN 3
						WHEN b.STATUS_CONT IN (450,510,530) AND d.START_INSP IS NULL AND d.FINISH_INSP IS NULL AND a.RESPON IS NOT NULL THEN 2
						WHEN b.STATUS_CONT = 460 AND d.START_INSP IS NULL AND d.FINISH_INSP IS NULL  AND a.RESPON IS NOT NULL THEN 1
						WHEN b.STATUS_CONT = 460 AND d.START_INSP IS NOT NULL AND d.FINISH_INSP IS NULL THEN 4
						WHEN b.STATUS_CONT IN (500,540,520) THEN 6 
						ELSE 5 
					END AS STATUS2,s.NOTE,t.tipe_cont AS tipe 
					FROM t_gatepass a
					left JOIN (SELECT * FROM t_spk_cont WHERE STATUS_CONT != 900) b on a.NO_CONT = b.NO_CONT 
					JOIN t_spk c ON c.ID = b.ID
					LEFT JOIN t_op_inspection d ON a.NO_CONT = d.NO_CONT AND a.NO_DOK = d.NO_DOK
					LEFT JOIN (select * from t_antrian_respon_ppk where reset = 'N') k ON a.ID = k.id_gatepass
					LEFT JOIN t_job_slip s ON c.NO_SPK = s.NO_SPK AND a.NO_CONT = s.NO_CONT AND s.JENIS = CONCAT('BEHANDLE ',a.JNS_KEGIATAN)
					LEFT JOIN (SELECT a.id, a.no_dok, a.tgl_dok, b.NO_CONT, b.UKR_CONT, b.tipe_cont
									FROM t_request a
									JOIN t_request_cont b ON a.id = b.id ) t ON c.NO_DOK = t.no_dok AND t.no_cont = a.no_cont
					WHERE  a.JNS_KEGIATAN  != 3 AND a.`STATUS` = 'WAITING'  AND a.JNS_DOK != 'SPPMP') az WHERE 1 = 1" . $addsql . " order by STATUS2,WK_RESPON";

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
				$this->newphpexcel->mergecell(array(array('A1', 'Q1'), array('A2', 'Q2'), array('A3', 'Q3')), FALSE);
				$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A1', 'MONITORING PERGERAKAN JOIN INSPECTION');
				$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A2', $time);
				$this->newphpexcel->width(array(array('A', 5), array('B', 20), array('C', 20), array('D', 8), array('E', 10), array('F', 20), array('G', 30), array('H', 15), array('I', 45), array('J', 25), array('K', 25), array('L', 25), array('M', 25), array('N', 25), array('O', 25), array('P', 25), array('Q', 25)));
				$this->newphpexcel->setActiveSheetIndex(0)
					->setCellValue('A5', 'NO')
					->setCellValue('B5', 'NO URUT')
					->setCellValue('C5', 'NO KONTAINER')
					->setCellValue('D5', 'UKURAN')
					->setCellValue('E5', 'TYPE')
					->setCellValue('F5', 'TANGGAL DOKUMEN')
					->setCellValue('G5', 'JENIS')
					->setCellValue('H5', 'NO DOKUMEN')
					->setCellValue('I5', 'LOKASI')
					->setCellValue('J5', 'KEGIATAN')
					->setCellValue('K5', 'COSTUMER')
					->setCellValue('L5', 'STATUS')
					->setCellValue('M5', 'START PERIKSA')
					->setCellValue('N5', 'FINISH PERIKSA')
					->setCellValue('O5', 'RESPON BC')
					->setCellValue('P5', 'RESPON KARANTINA')
					->setCellValue('Q5', 'WAKTU RESPON');
				$this->newphpexcel->headings(array('A5', 'B5', 'C5', 'D5', 'E5', 'F5', 'G5', 'H5', 'I5', 'J5', 'K5', 'L5', 'M5', 'N5', 'O5', 'P5', 'Q5'));
				$this->newphpexcel->set_wrap(array('B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q'));
				$no = 1;
				$rec = 6;
				if ($result) {
					foreach ($SQL->result_array() as $row) {
						$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A' . $rec, $no)
							->setCellValue('B' . $rec, $row["no_antrian"])
							->setCellValue('C' . $rec, $row["NO_CONT"])
							->setCellValue('D' . $rec, $row["UKR_CONT"])
							->setCellValue('E' . $rec, $row["tipe"])
							->setCellValue('F' . $rec, $row["TGL_DOK"])
							->setCellValue('G' . $rec, $row["JNS_DOK"])
							->setCellValue('H' . $rec, $row["NO_DOK"])
							->setCellValue('I' . $rec, $row["LOKASI"])
							->setCellValue('J' . $rec, $row["KEGIATAN"])
							->setCellValue('K' . $rec, $row["NAMA_CUST"])
							->setCellValue('L' . $rec, $row["STATUS"])
							->setCellValue('M' . $rec, $row["START_INSP"])
							->setCellValue('N' . $rec, $row["FINISH_INSP"])
							->setCellValue('O' . $rec, $row["RESPON"])
							->setCellValue('P' . $rec, $row["RESPON"])
							->setCellValue('Q' . $rec, $row["WK_RESPON"]);
						$this->newphpexcel->set_detilstyle(array('A' . $rec, 'B' . $rec, 'C' . $rec, 'D' . $rec, 'E' . $rec, 'F' . $rec, 'G' . $rec, 'H' . $rec, 'I' . $rec, 'J' . $rec, 'K' . $rec, 'L' . $rec, 'M' . $rec, 'N' . $rec, 'O' . $rec, 'P' . $rec, 'Q' . $rec));
						$rec++;
						$no++;
					}
				} else {
					$this->newphpexcel->getActiveSheet()->mergeCells('A4:Q4');
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A5', 'DATA TIDAK DITEMUKAN');
					$this->newphpexcel->set_detilstyle(array('A5'));
				}
				ob_clean();

				if ($tgl_dok_start != "" && $tgl_dok_end != "") {
					$file = "PERGERAKAN_JOIN_INSPECTION_" . $tgl_dok_start . "_" . $tgl_dok_end . ".xls";
				} else if ($tgl_dok_start != "") {
					$file = "PERGERAKAN_JOIN_INSPECTION_" . $tgl_dok_start . ".xls";
				} else if ($tgl_dok_end != "") {
					$file = "PERGERAKAN_JOIN_INSPECTION_" . $tgl_dok_end . ".xls";
				} else {
					$file = "PERGERAKAN_JOIN_INSPECTION_" . date("Ymd") . ".xls";
				}

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
