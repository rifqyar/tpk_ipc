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

    public function gantiformattglgblk($tgl){
        $date=date_create_from_format("m/d/Y",$tgl);
        $date1 = date_format($date,"Y-m-d");
        return $date1;
    }

    public function getSppbOndemand()
    {
        $no_dok = $this->input->post('no_dok');
        $tgl_dok = $this->input->post('tgl_dok');
        $npwp    = $this->input->post('npwp');
        $type    = 'sppb_osbos';

        $url  = "https://api.npct1.co.id:9443/api/v1/get-customs-ondemand";
        $user = "BEHANDLE";
        $key  = "5d3a2ffcb778f4b1c224f2447c048c8f";

        /*
        |--------------------------------------------------------------------------
        | REQUEST
        |--------------------------------------------------------------------------
        */

        $addXML = '<request>
                    <document_code>1</document_code>
                    <document_no>' . $no_dok . '</document_no>
                    <document_date>' . $tgl_dok . '</document_date>
                    <npwp>' . $npwp . '</npwp>
                </request>';

        $addXML = trim(
            preg_replace(
                '/\s\s+/',
                '',
                str_replace("\n", " ", $addXML)
            )
        );

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
            ),
        ));

        $response = curl_exec($curl);

        if (curl_errno($curl)) {
            $curlError = curl_error($curl);
            curl_close($curl);

            echo json_encode(array(
                'success' => false,
                'code'    => 'CURL_ERROR',
                'message' => $curlError,
                'data'    => null
            ));
            return;
        }

        curl_close($curl);


        /*
        |--------------------------------------------------------------------------
        | PARSING JSON RESPONSE
        |--------------------------------------------------------------------------
        */
        $responseData = json_decode($response, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            $datenow = date("Y-m-d H:i:s");
            $userondemand = 'OSBOS API';
            $responget = 'Invalid JSON response from HUB';
            $this->db->query("
                INSERT INTO `tpk_ipc`.`solver_req_dokumen_log`
                (
                    `url`,
                    `tipe`,
                    `no_dok`,
                    `tgl_dok`,
                    `npwp`,
                    `data_respons`,
                    `tambahan`,
                    `response_log`,
                    `user`
                )
                VALUES
                (
                    '$url',
                    '$type',
                    '$no_dok',
                    '$tgl_dok',
                    '$npwp',
                    '$responget',
                    '$addXML',
                    '$response',
                    '$userondemand'
                )
            ");

            $this->db->query("
                INSERT INTO `tpk_ipc`.`log_services`
                (
                    `METHOD`,
                    `XML_REQUEST`,
                    `XML_RESPONSE`,
                    `WK_REKAM`,
                    `FL_NPCT1`,
                    `FL_SENT_RIZKI`
                )
                VALUES
                (
                    'GET DOKUMEN SPPB FROM API',
                    '$addXML',
                    '$response',
                    '$datenow',
                    'N',
                    'N'
                )
            ");

            echo json_encode(array(
                'success' => false,
                'code'    => 'INVALID_JSON',
                'message' => 'Invalid JSON response from HUB service',
                'data'    => null
            ));
            return;
        }

        /*
        |--------------------------------------------------------------------------
        | CEK RESPONSE API
        |--------------------------------------------------------------------------
        */

        $apiStatus   = isset($responseData['status'])
            ? $responseData['status']
            : false;

        $apiCode     = isset($responseData['response'])
            ? $responseData['response']
            : null;

        $apiMessage  = isset($responseData['message'])
            ? $responseData['message']
            : '';

        $datenow     = date("Y-m-d H:i:s");
        $userondemand = 'OSBOS API';

        /*
        |--------------------------------------------------------------------------
        | SUCCESS
        |--------------------------------------------------------------------------
        */
        if ($apiStatus === true && $apiCode === '00') {
            /*
            |--------------------------------------------------------------------------
            | AMBIL DATA HEADER
            |--------------------------------------------------------------------------
            */
            $header = isset($responseData['data']['header'])
                ? $responseData['data']['header']
                : array();
            /*
            |--------------------------------------------------------------------------
            | AMBIL DATA CONTAINER
            |--------------------------------------------------------------------------
            */
            $containers = isset($responseData['data']['containers'])
                ? $responseData['data']['containers']
                : array();
            /*
            |--------------------------------------------------------------------------
            | MAPPING HEADER JSON -> VARIABLE LAMA
            |--------------------------------------------------------------------------
            */
            $CAR = isset($header['car'])
                ? $header['car']
                : null;

            $NO_SPPB = isset($header['document_no'])
                ? $header['document_no']
                : null;

            $TGL_SPPB = isset($header['document_date'])
                ? $this->normalizeDateNpct($header['document_date'])
                : null;

            $KD_KPBC = isset($header['kpbc'])
                ? $header['kpbc']
                : null;

            $NO_PIB = isset($header['pabean_no'])
                ? $header['pabean_no']
                : null;

            $TGL_PIB = isset($header['pabean_date'])
                ? $this->normalizeDateNpct($header['pabean_date'])
                : null;

            $NPWP_IMP = isset($header['customer_id'])
                ? $this->normalizeNpwp($header['customer_id'])
                : null;

            $NAMA_IMP = isset($header['customer_name'])
                ? $header['customer_name']
                : null;

            $ALAMAT_IMP = isset($header['customer_address'])
                ? $header['customer_address']
                : null;

            $NPWP_PPJK = isset($header['ppjk_id'])
                ? $header['ppjk_id']
                : null;

            $NAMA_PPJK = isset($header['ppjk_name'])
                ? $header['ppjk_name']
                : null;

            $ALAMAT_PPJK = isset($header['ppjk_address'])
                ? $header['ppjk_address']
                : null;

            $NM_ANGKUT = isset($header['vessel_name'])
                ? $header['vessel_name']
                : null;

            $NO_VOY_FLIGHT = isset($header['voyage'])
                ? $header['voyage']
                : null;

            $BRUTO = isset($header['bruto'])
                ? $header['bruto']
                : null;

            $NETTO = isset($header['netto'])
                ? $header['netto']
                : null;

            $GUDANG = isset($header['warehouse_origin'])
                ? $header['warehouse_origin']
                : null;

            $STATUS_JALUR = isset($header['path_status'])
                ? $header['path_status']
                : null;

            $JML_CONT = isset($header['total_cont'])
                ? $header['total_cont']
                : 0;

            $NO_BC11 = isset($header['bc11_no'])
                ? $header['bc11_no']
                : null;

            $TGL_BC11 = isset($header['bc11_date'])
                ? $this->normalizeDateNpct($header['bc11_date'])
                : null;

            $NO_POS_BC11 = isset($header['bc11_pos'])
                ? $header['bc11_pos']
                : null;

            $NO_BL_AWB = isset($header['bl_no'])
                ? $header['bl_no']
                : null;

            $TG_BL_AWB = isset($header['bl_date'])
                ? $this->normalizeDateNpct($header['bl_date'])
                : null;

            $NO_MASTER_BL_AWB = isset($header['master_bl_no'])
                ? $header['master_bl_no']
                : null;

            $TG_MASTER_BL_AWB = isset($header['master_bl_date'])
                ? $this->normalizeDateNpct($header['master_bl_date'])
                : null;

            /*
            |--------------------------------------------------------------------------
            | SIMPAN HEADER
            |--------------------------------------------------------------------------
            */
            $query = $this->db->query(
                "
                SELECT *
                FROM t_permit_hdr
                WHERE NO_DOK_INOUT = ?
                AND TGL_DOK_INOUT = ?
                ",
                array(
                    $NO_SPPB,
                    $TGL_SPPB
                )
            );
            $count = $query->num_rows();
            if ($count === 0) {
                $this->db->query(
                    "
                    INSERT INTO t_permit_hdr
                    (
                        CAR,
                        NO_DOK_INOUT,
                        KD_DOK_INOUT,
                        TGL_DOK_INOUT,
                        KD_KANTOR,
                        NO_DAFTAR_PABEAN,
                        TGL_DAFTAR_PABEAN,
                        ID_CONSIGNEE,
                        CONSIGNEE,
                        ALAMAT_CONSIGNEE,
                        NPWP_PPJK,
                        NAMA_PPJK,
                        ALAMAT_PPJK,
                        NM_ANGKUT,
                        NO_VOY_FLIGHT,
                        BRUTO,
                        NETTO,
                        KD_GUDANG,
                        STATUS_JALUR,
                        JML_CONT,
                        NO_BC11,
                        TGL_BC11,
                        NO_POS_BC11,
                        NO_BL_AWB,
                        TGL_BL_AWB,
                        NO_MASTER_BL_AWB,
                        TGL_MASTER_BL_AWB,
                        OPERATOR,
                        TGL_STATUS
                    )
                    VALUES
                    (
                        ?,
                        ?,
                        '1',
                        ?,
                        ?,
                        ?,
                        ?,
                        ?,
                        ?,
                        ?,
                        ?,
                        ?,
                        ?,
                        ?,
                        ?,
                        ?,
                        ?,
                        ?,
                        ?,
                        ?,
                        ?,
                        ?,
                        ?,
                        ?,
                        ?,
                        ?,
                        ?,
                        'AUTO ONDEMAND SPPB VIA OSBOS',
                        ?
                    )
                    ",
                    array(
                        $CAR,
                        $NO_SPPB,
                        $TGL_SPPB,
                        $KD_KPBC,
                        $NO_PIB,
                        $TGL_PIB,
                        $NPWP_IMP,
                        $NAMA_IMP,
                        $ALAMAT_IMP,
                        $NPWP_PPJK,
                        $NAMA_PPJK,
                        $ALAMAT_PPJK,
                        $NM_ANGKUT,
                        $NO_VOY_FLIGHT,
                        $BRUTO,
                        $NETTO,
                        $GUDANG,
                        $STATUS_JALUR,
                        $JML_CONT,
                        $NO_BC11,
                        $TGL_BC11,
                        $NO_POS_BC11,
                        $NO_BL_AWB,
                        $TG_BL_AWB,
                        $NO_MASTER_BL_AWB,
                        $TG_MASTER_BL_AWB,
                        $datenow
                    )
                );

                $insert_id = $this->db->insert_id();
                /*
                |--------------------------------------------------------------------------
                | SIMPAN CONTAINER
                |--------------------------------------------------------------------------
                */
                foreach ($containers as $contdata) {
                    $NO_CONT = isset($contdata['cont_no'])
                        ? $contdata['cont_no']
                        : null;

                    $SIZE = isset($contdata['cont_size'])
                        ? $contdata['cont_size']
                        : null;

                    $JNS_MUAT = isset($contdata['full_empty'])
                        ? $contdata['full_empty']
                        : null;
                    if (!empty($NO_CONT)) {
                        $this->db->query(
                            "
                            INSERT IGNORE INTO t_permit_cont
                            (
                                ID,
                                NO_CONT,
                                KD_CONT_UKURAN,
                                KD_CONT_JENIS,
                                TGL_STATUS
                            )
                            VALUES
                            (
                                ?,
                                ?,
                                ?,
                                ?,
                                ?
                            )
                            ",
                            array(
                                $insert_id,
                                $NO_CONT,
                                $SIZE,
                                $JNS_MUAT,
                                $datenow
                            )
                        );
                    }
                }
            }

            /*
            |--------------------------------------------------------------------------
            | LOG SUCCESS
            |--------------------------------------------------------------------------
            */
            $responget = 'Sukses Ondemand Data';
            $this->db->query(
                "
                INSERT INTO `tpk_ipc`.`solver_req_dokumen_log`
                (
                    `url`,
                    `tipe`,
                    `no_dok`,
                    `tgl_dok`,
                    `npwp`,
                    `data_respons`,
                    `tambahan`,
                    `response_log`,
                    `user`
                )
                VALUES
                (
                    ?,
                    ?,
                    ?,
                    ?,
                    ?,
                    ?,
                    ?,
                    ?,
                    ?
                )
                ",
                array(
                    $url,
                    $type,
                    $no_dok,
                    $tgl_dok,
                    $npwp,
                    $responget,
                    $addXML,
                    $response,
                    $userondemand
                )
            );
            $this->db->query(
                "
                INSERT INTO `tpk_ipc`.`log_services`
                (
                    `METHOD`,
                    `XML_REQUEST`,
                    `XML_RESPONSE`,
                    `WK_REKAM`,
                    `FL_NPCT1`,
                    `FL_SENT_RIZKI`
                )
                VALUES
                (
                    'GET DOKUMEN SPPB FROM API',
                    ?,
                    ?,
                    ?,
                    'N',
                    'N'
                )
                ",
                array(
                    $addXML,
                    $response,
                    $datenow
                )
            );

            /*
            |--------------------------------------------------------------------------
            | RESPONSE KE CLIENT
            |--------------------------------------------------------------------------
            */
            echo json_encode(array(
                'success' => true,
                'code'    => '00',
                'message' => $responget,
                'data'    => array(
                    'no_sppb'  => $NO_SPPB,
                    'tgl_sppb' => $TGL_SPPB,
                    'jml_cont' => $JML_CONT
                )
            ));
            return;
        }

        /*
        |--------------------------------------------------------------------------
        | FAILED
        |--------------------------------------------------------------------------
        */
        elseif ($apiCode === '01') {
            $responget = !empty($apiMessage)
                ? $apiMessage
                : 'Dokumen tidak ditemukan';

            $this->db->query(
                "
                INSERT INTO `tpk_ipc`.`solver_req_dokumen_log`
                (
                    `url`,
                    `tipe`,
                    `no_dok`,
                    `tgl_dok`,
                    `npwp`,
                    `data_respons`,
                    `tambahan`,
                    `response_log`,
                    `user`
                )
                VALUES
                (
                    ?,
                    ?,
                    ?,
                    ?,
                    ?,
                    ?,
                    ?,
                    ?,
                    ?
                )
                ",
                array(
                    $url,
                    $type,
                    $no_dok,
                    $tgl_dok,
                    $npwp,
                    $responget,
                    $addXML,
                    $response,
                    $userondemand
                )
            );

            $this->db->query(
                "
                INSERT INTO `tpk_ipc`.`log_services`
                (
                    `METHOD`,
                    `XML_REQUEST`,
                    `XML_RESPONSE`,
                    `WK_REKAM`,
                    `FL_NPCT1`,
                    `FL_SENT_RIZKI`
                )
                VALUES
                (
                    'GET DOKUMEN SPPB MANUAL',
                    ?,
                    ?,
                    ?,
                    'N',
                    'N'
                )
                ",
                array(
                    $addXML,
                    $response,
                    $datenow
                )
            );

            echo json_encode(array(
                'success' => false,
                'code'    => '01',
                'message' => $responget,
                'data'    => null
            ));
            return;
        }
        /*
        |--------------------------------------------------------------------------
        | UNKNOWN ERROR
        |--------------------------------------------------------------------------
        */
        else {
            $responget = !empty($apiMessage)
                ? $apiMessage
                : 'Unknown error from HUB service';

            $this->db->query(
                "
                INSERT INTO `tpk_ipc`.`solver_req_dokumen_log`
                (
                    `url`,
                    `tipe`,
                    `no_dok`,
                    `tgl_dok`,
                    `npwp`,
                    `data_respons`,
                    `tambahan`,
                    `response_log`,
                    `user`
                )
                VALUES
                (
                    ?,
                    ?,
                    ?,
                    ?,
                    ?,
                    ?,
                    ?,
                    ?,
                    ?
                )
                ",
                array(
                    $url,
                    $type,
                    $no_dok,
                    $tgl_dok,
                    $npwp,
                    $responget,
                    $addXML,
                    $response,
                    $userondemand
                )
            );

            $this->db->query(
                "
                INSERT INTO `tpk_ipc`.`log_services`
                (
                    `METHOD`,
                    `XML_REQUEST`,
                    `XML_RESPONSE`,
                    `WK_REKAM`,
                    `FL_NPCT1`,
                    `FL_SENT_RIZKI`
                )
                VALUES
                (
                    'GET DOKUMEN SPPB MANUAL',
                    ?,
                    ?,
                    ?,
                    'N',
                    'N'
                )
                ",
                array(
                    $addXML,
                    $response,
                    $datenow
                )
            );

            echo json_encode(array(
                'success' => false,
                'code'    => $apiCode !== null ? $apiCode : '-',
                'message' => $responget,
                'data'    => null
            ));

            return;
        }
    }
}
