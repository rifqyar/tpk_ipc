<?php defined('BASEPATH') or exit('No direct script access allowed');

class Apibehandle extends CI_Controller
{
	public $content;
	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_home');
	}
    public function get_yard() {
        $query = "SELECT distinct
                    A.ID, 
                    B.CONSIGNEE, 
                    A.NO_CONT, 
                    A.UKR_CONT, 
                    CASE 
                        WHEN E.W_BEHANDLE IS NULL THEN 'TERMINAL' 
                        ELSE A.LOKASI 
                    END AS LOKASI, 
                    A.TIER, 
                    A.ROOM, 
                    CASE 
                        WHEN A.STATUS_CONT = '460' AND D.START_INSP IS NOT NULL AND D.FINISH_INSP IS NULL THEN 'SEDANG PERIKSA'
                        WHEN A.STATUS_CONT = '460' AND D.START_INSP IS NOT NULL AND D.FINISH_INSP IS NOT NULL THEN 'SELESAI PERIKSA'
                        ELSE C.KETERANGAN 
                    END AS KETERANGAN,
                    A.WK_UPDATE as 'LAST_UPDATE'
                FROM t_spk_cont A
                JOIN t_spk B ON A.ID = B.ID
                JOIN reff_status_spk C ON A.STATUS_CONT = C.ID 
                LEFT JOIN t_op_inspection D ON D.NO_CONT = A.NO_CONT AND D.NO_SPK = B.NO_SPK 
                LEFT JOIN t_op_behandlein E ON E.NO_CONT = A.NO_CONT AND E.NO_SPK = B.NO_SPK
                WHERE A.STATUS_CONT NOT IN ('900', '950')";

        $result = $this->db->query($query)->result_array();

        $kapasitas_query = "SELECT 
            (SELECT COUNT(*) FROM t_denah_lapangan WHERE KD_GUDANG_DTL = '1B') AS TOTAL_1B,
            (SELECT COUNT(*) FROM t_denah_lapangan WHERE KD_GUDANG_DTL = '1A') AS TOTAL_1A,
            (SELECT COUNT(*) FROM t_denah_lapangan WHERE KD_GUDANG_DTL = 'CIC') AS TOTAL_CIC";
        $kapasitas = $this->db->query($kapasitas_query)->row_array();

        $data = array(
            'Jumlah_Kontainer' => count($result),
            'TERMINAL' => array(
                'Jumlah' => array('20' => 0, '40' => 0, '45' => 0, 'DALAM_PROSES_PENARIKAN' => 0),
                'Kontainer' => array()
            ),
            'YARD_BEFORE' => array(
                'Jumlah' => array('20' => 0, '40' => 0, '45' => 0, 'TOTAL_ON_YARD' => 0, 'KAPASITAS' => $kapasitas['TOTAL_1B']),
                'Kontainer' => array()
            ),
            'CIC' => array(
                'Jumlah' => array('20' => 0, '40' => 0, '45' => 0, 'TOTAL_ON_YARD' => 0, 'KAPASITAS' => $kapasitas['TOTAL_CIC']),
                'Kontainer' => array()
            ),
            'YARD_AFTER' => array(
                'Jumlah' => array('20' => 0, '40' => 0, '45' => 0, 'TOTAL_ON_YARD' => 0, 'KAPASITAS' => $kapasitas['TOTAL_1A']),
                'Kontainer' => array()
            )
        );
        
        foreach ($result as $row) {
            $location = (strpos($row['LOKASI'], 'TERMINAL') === 0) ? 'TERMINAL' : ((strpos($row['LOKASI'], 'CIC') === 0) ? 'CIC' : ((strpos($row['LOKASI'], '1B') === 0) ? 'YARD_BEFORE' : 'YARD_AFTER'));
            
            if (isset($data[$location])) {
                $size = $row['UKR_CONT'];
                if (isset($data[$location]['Jumlah'][$size])) {
                    $data[$location]['Jumlah'][$size]++;
                    if ($location === 'TERMINAL') {
                        $data[$location]['Jumlah']['DALAM_PROSES_PENARIKAN']++;
                    } else {
                        $data[$location]['Jumlah']['TOTAL_ON_YARD']++;
                    }
                }
                $data[$location]['Kontainer'][] = $row;
            }
        }
        

        header('Content-Type: application/json');
        echo json_encode($data);

    }
}