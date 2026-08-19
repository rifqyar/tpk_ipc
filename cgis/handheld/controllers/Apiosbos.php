<?php defined('BASEPATH') or exit('No direct script access allowed');

class Apiosbos extends CI_Controller
{
    public $content;
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_home');
    }

    public function index()
    {
        $msg = 'API OSBOS';
        echo json_encode($msg);
    }

    public function gantiformattglgblk($tgl)
    {
        $date = date_create_from_format("m/d/Y", $tgl);
        $date1 = date_format($date, "Y-m-d");
        return $date1;
    }

    public function getSppbOndemand()
    {
        header('Content-Type: application/json; charset=utf-8');

        $no_dok = $this->input->post('no_dok');
        $tgl_dok = $this->input->post('tgl_dok');
        $npwp = $this->input->post('npwp');
        $type = 'sppb_ondemand';

        if (empty($no_dok) || empty($tgl_dok) || empty($npwp)) {
            echo json_encode(array(
                'success' => false,
                'code' => '99',
                'message' => 'Parameter tidak lengkap: no_dok, tgl_dok, dan npwp harus diisi',
                'data' => null
            ));
            return;
        }

        $url = "https://api.npct1.co.id:9443/api/v1/get-customs-ondemand";
        $user = "BEHANDLE";
        $key = "5d3a2ffcb778f4b1c224f2447c048c8f";

        $addXML = '<request>
                <document_code>1</document_code>
                <document_no>' . $no_dok . '</document_no>
                <document_date>' . $tgl_dok . '</document_date>
                <npwp>' . $npwp . '</npwp>
            </request>';

        $addXML = trim(preg_replace('/\s\s+/', '', str_replace("\n", " ", $addXML)));

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $addXML,
            CURLOPT_HTTPHEADER => array(
                'User-ID: ' . $user,
                'NPCT-API-Key: ' . $key,
                'Content-Type: application/xml'
            )
        ));

        $response = curl_exec($curl);

        if (curl_errno($curl)) {
            $curlError = curl_error($curl);
            curl_close($curl);

            echo json_encode(array(
                'success' => false,
                'code' => '99',
                'message' => 'Connection Failed = ' . $curlError,
                'data' => null
            ));
            return;
        }

        curl_close($curl);

        $datenow = date("Y-m-d H:i:s");

        // Response sekarang JSON
        $json = json_decode($response, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            $this->db->query("INSERT INTO `tpk_ipc`.`solver_req_dokumen_log` (`url`, `tipe`, `no_dok`, `tgl_dok`, `npwp`, `data_respons`, `tambahan`, `response_log`, `user`) VALUES ('$url', '$type', '$no_dok', '$tgl_dok', '$npwp', 'Invalid JSON Response', '$addXML', '$response', 'OSBOS API')");

            $this->db->query("INSERT INTO `tpk_ipc`.`log_services` (`METHOD`, `XML_REQUEST`, `XML_RESPONSE`, `WK_REKAM`, `FL_NPCT1`, `FL_SENT_RIZKI`) VALUES ('GET DOKUMEN SPPB FROM API', '$addXML', '$response', '$datenow', 'N', 'N')");

            echo json_encode(array(
                'success' => false,
                'code' => '99',
                'message' => 'Response dari HUB bukan JSON yang valid',
                'data' => null
            ));
            return;
        }

        $code = isset($json['code']) ? (string) $json['code'] : '';

        if ($code === '00') {
            $header = isset($json['DOCUMENT']['SPPB']['HEADER']) ? $json['DOCUMENT']['SPPB']['HEADER'] : array();
            $detil = isset($json['DOCUMENT']['SPPB']['DETIL']) ? $json['DOCUMENT']['SPPB']['DETIL'] : array();

            $CAR = isset($header['CAR']) ? $header['CAR'] : '';
            $NO_SPPB = isset($header['NO_SPPB']) ? $header['NO_SPPB'] : '';
            $TGL_SPPB = !empty($header['TGL_SPPB']) ? $this->gantiformattglgblk($header['TGL_SPPB']) : null;
            $KD_KPBC = isset($header['KD_KPBC']) ? $header['KD_KPBC'] : '';
            $NO_PIB = isset($header['NO_PIB']) ? $header['NO_PIB'] : '';
            $TGL_PIB = !empty($header['TGL_PIB']) ? $this->gantiformattglgblk($header['TGL_PIB']) : null;
            $NPWP_IMP = isset($header['NPWP_IMP']) ? $header['NPWP_IMP'] : '';
            $NAMA_IMP = isset($header['NAMA_IMP']) ? $header['NAMA_IMP'] : '';
            $ALAMAT_IMP = isset($header['ALAMAT_IMP']) ? $header['ALAMAT_IMP'] : '';
            $NPWP_PPJK = isset($header['NPWP_PPJK']) ? $header['NPWP_PPJK'] : '';
            $NAMA_PPJK = isset($header['NAMA_PPJK']) ? $header['NAMA_PPJK'] : '';
            $ALAMAT_PPJK = isset($header['ALAMAT_PPJK']) ? $header['ALAMAT_PPJK'] : '';
            $NM_ANGKUT = isset($header['NM_ANGKUT']) ? $header['NM_ANGKUT'] : '';
            $NO_VOY_FLIGHT = isset($header['NO_VOY_FLIGHT']) ? $header['NO_VOY_FLIGHT'] : '';
            $BRUTO = isset($header['BRUTO']) ? $header['BRUTO'] : '';
            $NETTO = isset($header['NETTO']) ? $header['NETTO'] : '';
            $GUDANG = isset($header['GUDANG']) ? $header['GUDANG'] : '';
            $STATUS_JALUR = isset($header['STATUS_JALUR']) ? $header['STATUS_JALUR'] : '';
            $JML_CONT = isset($header['JML_CONT']) ? $header['JML_CONT'] : '';
            $NO_BC11 = isset($header['NO_BC11']) ? $header['NO_BC11'] : '';
            $TGL_BC11 = !empty($header['TGL_BC11']) ? $this->gantiformattglgblk($header['TGL_BC11']) : null;
            $NO_POS_BC11 = isset($header['NO_POS_BC11']) ? $header['NO_POS_BC11'] : '';
            $NO_BL_AWB = isset($header['NO_BL_AWB']) ? $header['NO_BL_AWB'] : '';
            $TG_BL_AWB = !empty($header['TG_BL_AWB']) ? $this->gantiformattglgblk($header['TG_BL_AWB']) : null;
            $NO_MASTER_BL_AWB = isset($header['NO_MASTER_BL_AWB']) ? $header['NO_MASTER_BL_AWB'] : '';
            $TG_MASTER_BL_AWB = !empty($header['TG_MASTER_BL_AWB']) ? $this->gantiformattglgblk($header['TG_MASTER_BL_AWB']) : null;

            $containers = isset($detil['CONT']) ? $detil['CONT'] : array();

            // Kalau hanya 1 container, JSON bisa berupa object
            if (isset($containers['NO_CONT'])) {
                $containers = array($containers);
            }

            $query = $this->db->query("SELECT * FROM t_permit_hdr WHERE NO_DOK_INOUT = '$NO_SPPB' AND TGL_DOK_INOUT = '$TGL_SPPB'");
            $count = $query->num_rows();

            if ($count === 0) {
                $this->db->query("INSERT INTO t_permit_hdr (CAR, KD_KANTOR, KD_DOK_INOUT, NO_DOK_INOUT, TGL_DOK_INOUT, NO_DAFTAR_PABEAN, TGL_DAFTAR_PABEAN, ID_CONSIGNEE, CONSIGNEE, ALAMAT_CONSIGNEE, NPWP_PPJK, NAMA_PPJK, ALAMAT_PPJK, NM_ANGKUT, NO_VOY_FLIGHT, KD_GUDANG, JML_CONT, BRUTO, NETTO, NO_BC11, TGL_BC11, NO_POS_BC11, NO_BL_AWB, TGL_BL_AWB, NO_MASTER_BL_AWB, TGL_MASTER_BL_AWB, KD_KANTOR_PENGAWAS, KD_KANTOR_BONGKAR, FL_SEGEL, STATUS_JALUR, FL_KARANTINA, KD_STATUS, TGL_STATUS, FL_BAPLIE, BAPLIE_DATE, ANGKUTKODE_TPS, ANGKUTNAMA_TPS, ANGKUTNO_TPS, TMP_TIMBUN_TPS, STATUS, STATUS_MAIL, KD_STATUS_BIL, WK_STATUS, FL_MANUAL, OPERATOR, FL_MIGRASI, FL_NHI, FL_LNSW, LNSW_KD_RESPON, LNSW_IDLOG, LNSW_NOAJU, LNSW_TGLAJU)
            VALUES ('$CAR', '$KD_KPBC', '1', '$NO_SPPB', '$TGL_SPPB', '$NO_PIB', '$TGL_PIB', '$NPWP_IMP', '$NAMA_IMP', '$ALAMAT_IMP', '$NPWP_PPJK', '$NAMA_PPJK', '$ALAMAT_PPJK', '$NM_ANGKUT', '$NO_VOY_FLIGHT', '$GUDANG', '$JML_CONT', '$BRUTO', '$NETTO', '$NO_BC11', '$TGL_BC11', '$NO_POS_BC11', '$NO_BL_AWB', '$TG_BL_AWB', '$NO_MASTER_BL_AWB', '$TG_MASTER_BL_AWB', NULL, NULL, NULL, '$STATUS_JALUR', NULL, '100', '$datenow', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', 'DASHBOARD_OSBOS', NULL, NULL, NULL, NULL, NULL, NULL, NULL)");

                $insert_id = $this->db->insert_id();

                foreach ($containers as $contdata) {
                    $NO_CONT = isset($contdata['NO_CONT']) ? $contdata['NO_CONT'] : '';
                    $SIZE = isset($contdata['SIZE']) ? $contdata['SIZE'] : '';
                    $JNS_MUAT = isset($contdata['JNS_MUAT']) ? $contdata['JNS_MUAT'] : '';

                    $this->db->query("INSERT INTO t_permit_cont (ID, NO_CONT, KD_CONT_UKURAN, KD_CONT_JENIS, TGL_STATUS) VALUES ('$insert_id', '$NO_CONT', '$SIZE', '$JNS_MUAT', '$datenow')");
                }
            } else {
                $permit = $query->row();
                $permitid = $permit->ID;

                foreach ($containers as $contdata) {
                    $NO_CONT = isset($contdata['NO_CONT']) ? $contdata['NO_CONT'] : '';
                    $SIZE = isset($contdata['SIZE']) ? $contdata['SIZE'] : '';
                    $JNS_MUAT = isset($contdata['JNS_MUAT']) ? $contdata['JNS_MUAT'] : '';

                    $queryCont = $this->db->query("SELECT * FROM t_permit_cont WHERE ID = '$permitid' AND NO_CONT = '$NO_CONT'");

                    if ($queryCont->num_rows() === 0) {
                        $this->db->query("INSERT IGNORE INTO t_permit_cont (ID, NO_CONT, KD_CONT_UKURAN, KD_CONT_JENIS, TGL_STATUS) VALUES ('$permitid', '$NO_CONT', '$SIZE', '$JNS_MUAT', '$datenow')");
                    }
                }
            }

            $responget = 'Sukses Ondemand Data';
            $userondemand = 'OSBOS API';

            $this->db->query("INSERT INTO `tpk_ipc`.`solver_req_dokumen_log` (`url`, `tipe`, `no_dok`, `tgl_dok`, `npwp`, `data_respons`, `tambahan`, `response_log`, `user`) VALUES ('$url', '$type', '$no_dok', '$tgl_dok', '$npwp', '$responget', '$addXML', '$response', '$userondemand')");

            $this->db->query("INSERT INTO `tpk_ipc`.`log_services` (`METHOD`, `XML_REQUEST`, `XML_RESPONSE`, `WK_REKAM`, `FL_NPCT1`, `FL_SENT_RIZKI`) VALUES ('GET DOKUMEN SPPB FROM API', '$addXML', '$response', '$datenow', 'N', 'N')");

            echo json_encode(array(
                'success' => true,
                'code' => '00',
                'message' => $responget,
                'data' => array(
                    'no_sppb' => $NO_SPPB,
                    'tgl_sppb' => $TGL_SPPB,
                    'jml_cont' => $JML_CONT
                )
            ));
            return;
        } elseif ($code === '01') {
            $responget = isset($json['description']) ? $json['description'] : 'Dokumen tidak ditemukan';

            $this->db->query("INSERT INTO `tpk_ipc`.`solver_req_dokumen_log` (`url`, `tipe`, `no_dok`, `tgl_dok`, `npwp`, `data_respons`, `tambahan`, `response_log`, `user`) VALUES ('$url', '$type', '$no_dok', '$tgl_dok', '$npwp', '$responget', '$addXML', '$response', 'OSBOS API')");

            $this->db->query("INSERT INTO `tpk_ipc`.`log_services` (`METHOD`, `XML_REQUEST`, `XML_RESPONSE`, `WK_REKAM`, `FL_NPCT1`, `FL_SENT_RIZKI`) VALUES ('GET DOKUMEN SPPB MANUAL', '$addXML', '$response', '$datenow', 'N', 'N')");

            echo json_encode(array(
                'success' => false,
                'code' => '01',
                'message' => $responget,
                'data' => null
            ));
            return;
        } else {
            $responget = 'Unknown error ' . (isset($json['description']) ? $json['description'] : '');

            $this->db->query("INSERT INTO `tpk_ipc`.`solver_req_dokumen_log` (`url`, `tipe`, `no_dok`, `tgl_dok`, `npwp`, `data_respons`, `tambahan`, `response_log`, `user`) VALUES ('$url', '$type', '$no_dok', '$tgl_dok', '$npwp', '$responget', '$addXML', '$response', 'OSBOS API')");

            $this->db->query("INSERT INTO `tpk_ipc`.`log_services` (`METHOD`, `XML_REQUEST`, `XML_RESPONSE`, `WK_REKAM`, `FL_NPCT1`, `FL_SENT_RIZKI`) VALUES ('GET DOKUMEN SPPB MANUAL', '$addXML', '$response', '$datenow', 'N', 'N')");

            echo json_encode(array(
                'success' => false,
                'code' => '-',
                'message' => 'Unknown error from HUB service',
                'data' => null
            ));
            return;
        }
    }
}
