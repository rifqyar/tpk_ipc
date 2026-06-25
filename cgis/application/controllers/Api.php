<?php defined('BASEPATH') or exit('No direct script access allowed');

class Api extends CI_Controller
{
    public $content;
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_home');
    }
public function get_respon(){
    $jenis       = $this->input->post('jenis');
    $status_cont = $this->input->post('status_cont');
    $no_cont     = $this->input->post('no_cont');
    $no_dok      = $this->input->post('no_dok');

    $where_extra = "";

    // filter jenis
    if ($jenis == "customs") {
        $where_extra .= " AND a.JNS_DOK != 'SPPMP'";
    } elseif ($jenis == "karantina") {
        $where_extra .= " AND a.JNS_DOK = 'SPPMP'";
    } elseif ($jenis == "all") {
        // kosong, tidak menambah filter
    }

    // mapping status text ke kondisi SQL
    $status_map = array(
        "BELUM_PPK" => "b.STATUS_CONT IN (450, 510, 530) 
                        AND d.START_INSP IS NULL 
                        AND d.FINISH_INSP IS NULL 
                        AND a.RESPON IS NULL",
        "ANTRIAN_PERIKSA" => "b.STATUS_CONT IN (450, 510, 530) 
                              AND d.START_INSP IS NULL 
                              AND d.FINISH_INSP IS NULL 
                              AND a.RESPON IS NOT NULL",
        "SIAP_PERIKSA" => "b.STATUS_CONT = 460 
                           AND d.START_INSP IS NULL 
                           AND d.FINISH_INSP IS NULL 
                           AND a.RESPON IS NOT NULL",
        "SEDANG_PERIKSA" => "b.STATUS_CONT = 460 
                             AND d.START_INSP IS NOT NULL 
                             AND d.FINISH_INSP IS NULL",
        "SELESAI_PERIKSA" => "b.STATUS_CONT IN (500, 520, 540)",
        "WAITING" => "b.STATUS_CONT NOT IN (450, 510, 530, 460, 500, 520, 540)"
    );

    // filter status_cont berdasarkan mapping
    if ($status_cont != "" && isset($status_map[$status_cont])) {
        $where_extra .= " AND (" . $status_map[$status_cont] . ")";
    }

    // filter no_cont
    if ($no_cont != "") {
        $where_extra .= " AND a.NO_CONT = " . $this->db->escape($no_cont);
    }

    // filter no_dok
    if ($no_dok != "") {
        $where_extra .= " AND a.NO_DOK = " . $this->db->escape($no_dok);
    }

    // --- Query count ---
    $sql_count = "
    SELECT 
        COUNT(
            CASE 
                WHEN b.STATUS_CONT IN (450, 510, 530) 
                     AND d.START_INSP IS NULL 
                     AND d.FINISH_INSP IS NULL 
                     AND a.RESPON IS NULL 
                THEN 1 
            END
        ) AS BELUM_PPK,
        COUNT(
            CASE 
                WHEN b.STATUS_CONT IN (450, 510, 530) 
                     AND d.START_INSP IS NULL 
                     AND d.FINISH_INSP IS NULL 
                     AND a.RESPON IS NOT NULL 
                THEN 1 
            END
        ) AS ANTRIAN_PERIKSA,
        COUNT(
            CASE 
                WHEN b.STATUS_CONT = 460 
                     AND d.START_INSP IS NULL 
                     AND d.FINISH_INSP IS NULL 
                     AND a.RESPON IS NOT NULL 
                THEN 1 
            END
        ) AS SIAP_PERIKSA,
        COUNT(
            CASE 
                WHEN b.STATUS_CONT = 460 
                     AND d.START_INSP IS NOT NULL 
                     AND d.FINISH_INSP IS NULL 
                THEN 1 
            END
        ) AS SEDANG_PERIKSA,
        COUNT(
            CASE 
                WHEN b.STATUS_CONT IN (500, 520, 540) 
                THEN 1 
            END
        ) AS SELESAI_PERIKSA,
        COUNT(
            CASE 
                WHEN b.STATUS_CONT NOT IN (450, 510, 530, 460, 500, 520, 540) 
                THEN 1 
            END
        ) AS WAITING
    FROM t_gatepass a
    LEFT JOIN (SELECT * FROM t_spk_cont WHERE STATUS_CONT != 900) b 
        ON a.NO_CONT = b.NO_CONT 
    JOIN t_spk c ON c.ID = b.ID
    LEFT JOIN t_op_inspection d 
        ON a.NO_CONT = d.NO_CONT 
       AND a.NO_DOK = d.NO_DOK 
       AND a.JNS_KEGIATAN = d.JNS_KEGIATAN 
    LEFT JOIN (SELECT * FROM t_antrian_respon_ppk WHERE reset = 'N') k 
        ON a.ID = k.id_gatepass 
    LEFT JOIN t_job_slip s 
        ON c.NO_SPK = s.NO_SPK 
       AND a.NO_CONT = s.NO_CONT 
       AND s.JENIS = CONCAT('BEHANDLE ', a.JNS_KEGIATAN)
    LEFT JOIN (
        SELECT a.id, a.no_dok, a.tgl_dok, b.NO_CONT, b.UKR_CONT, b.tipe_cont
        FROM t_request a
        JOIN t_request_cont b ON a.id = b.id
    ) t 
        ON c.NO_DOK = t.no_dok 
       AND t.no_cont = a.no_cont
    WHERE a.JNS_KEGIATAN != 3 
      AND a.STATUS = 'WAITING'" . $where_extra;

    $jumlah = $this->db->query($sql_count)->row_array();

    // --- Query antrian ---
    $sql_antrian = "
    SELECT * 
    FROM (
        SELECT 
            k.no_antrian,
            a.NO_CONT,
            a.UKR_CONT,
            a.TGL_DOK,
            a.JNS_DOK,
            a.STATUS,
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
                WHEN b.STATUS_CONT IN (450, 510, 530) 
                     AND d.START_INSP IS NULL 
                     AND d.FINISH_INSP IS NULL 
                     AND a.RESPON IS NOT NULL 
                THEN 'SIAP PERIKSA'
                WHEN b.STATUS_CONT = 460 
                     AND d.START_INSP IS NULL 
                     AND d.FINISH_INSP IS NULL  
                     AND a.RESPON IS NOT NULL 
                THEN 'PPK'
                WHEN b.STATUS_CONT IN (450, 510, 530) 
                     AND d.START_INSP IS NULL 
                     AND d.FINISH_INSP IS NULL 
                     AND a.RESPON IS NULL 
                THEN 'BELUM PPK'
                WHEN b.STATUS_CONT = 460 
                     AND d.START_INSP IS NOT NULL 
                     AND d.FINISH_INSP IS NULL 
                THEN 'SEDANG PERIKSA'
                WHEN b.STATUS_CONT IN (500, 520, 540) 
                THEN 'SELESAI PERIKSA'
                ELSE 'WAITING'
            END AS STATUS2,
            s.NOTE 
        FROM t_gatepass a
        LEFT JOIN (SELECT * FROM t_spk_cont WHERE STATUS_CONT != 900) b 
            ON a.NO_CONT = b.NO_CONT 
        JOIN t_spk c ON c.ID = b.ID
        LEFT JOIN t_op_inspection d 
            ON a.NO_CONT = d.NO_CONT 
           AND a.NO_DOK = d.NO_DOK 
           AND a.JNS_KEGIATAN = d.JNS_KEGIATAN
        LEFT JOIN (SELECT * FROM t_antrian_respon_ppk WHERE reset = 'N') k 
            ON a.ID = k.id_gatepass
        LEFT JOIN t_job_slip s 
            ON c.NO_SPK = s.NO_SPK 
           AND a.NO_CONT = s.NO_CONT 
           AND s.JENIS = CONCAT('BEHANDLE ', a.JNS_KEGIATAN)
        WHERE a.JNS_KEGIATAN != 3 
          AND a.STATUS = 'WAITING'". $where_extra ."
    ) az
    ORDER BY STATUS2, WK_RESPON";

    $antrian = $this->db->query($sql_antrian)->result_array();

    // --- Response JSON ---
    $response = array(
        "code"    => 200,
        "message" => "success",
        "data"    => array(
            "jumlah"  => $jumlah,
            "antrian" => $antrian
        )
    );

    header('Content-Type: application/json');
    echo json_encode($response);
}

}
