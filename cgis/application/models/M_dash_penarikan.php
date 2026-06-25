<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_dash_penarikan extends CI_Model {

	public $variable;

	public function __construct()
	{
		parent::__construct();
		
	}

public function get_data_kontainer($type, $act, $id) {
    $check = (grant() == "W");

    $SQL = "SELECT
            A.NO_DOK,
            A.TGL_DOK,
            A.NO_CONT,
            C.UKR_CONT,
            FF.KETERANGAN,
            CASE 
				WHEN A.PERIKSA IN ('Y', 'TRUE') THEN 'PERIKSA'
				WHEN A.PERIKSA IN ('T', 'FALSE') THEN 'TIDAK'
				WHEN A.PERIKSA = 'J' THEN 'JOIN'
				ELSE A.PERIKSA
			END AS PERIKSA,
            B.KD_REQ,
            BB.NAMA,
            IFNULL(E.NO_SPK, '<span class=\"label label-danger\">BELUM SPK</span>') AS NO_SPK,
            CASE 
                WHEN G.ID IS NULL THEN '<span class=\"label label-danger\">BELUM DIREQUEST</span>'
                ELSE '<span class=\"label label-success\">SUDAH DIREQUEST</span>'
            END AS STATUS_REQUEST
        FROM 
            t_rekon_dokumen_npct1 A
        LEFT JOIN t_request B 
            ON A.NO_DOK = B.NO_DOK AND A.TGL_DOK = B.TGL_DOK
        LEFT JOIN reff_kode_dok_bc BB 
            ON B.JNS_DOK = BB.ID
        LEFT JOIN t_request_cont C 
            ON C.ID = B.ID AND A.NO_CONT = C.NO_CONT
        LEFT JOIN t_spk E 
            ON B.NO_DOK = E.NO_DOK AND B.TGL_DOK = E.TGL_DOK
        LEFT JOIN t_spk_cont F 
            ON E.ID = F.ID AND F.NO_CONT = A.NO_CONT
        LEFT JOIN reff_status_spk FF 
            ON F.STATUS_CONT = FF.ID
        LEFT JOIN list_dokumens G 
            ON G.NO_DOK = A.NO_DOK AND G.TGL_DOK = A.TGL_DOK and G.FL_STATUS in ('N', 'Y')
        WHERE 	
            B.KD_REQ IN ('DRAFT', 'APPROVED', 'REJECTED', 'INQUIRY', 'REQUESTED')
            AND (F.STATUS_CONT IS NULL OR F.STATUS_CONT IN (000, 100, 200))
            AND A.TGL_DOK > '2025-07-18'
            AND (
        -- jika dokumen belum dispk, tetap tampilkan semua
        E.ID IS NULL
        -- jika SPK masih aktif, tetap tampilkan
        OR F.STATUS_CONT IN (000, 100, 200)
        -- jika dokumen sudah dispk (SPK ada), maka tampilkan hanya kontainer yang benar-benar masuk di spk_cont
        OR (E.ID IS NOT NULL AND F.NO_CONT IS NOT NULL)
    )
        ORDER BY 
            A.NO_DOK, A.ID desc";

    $QUERY = $this->db->query($SQL);
    return $QUERY->result();
}

	

/* End of file M_display.php */
/* Location: ./application/models/M_display.php */
}