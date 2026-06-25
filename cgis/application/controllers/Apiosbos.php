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
        $npwp   = $this->input->post('npwp');
        $type = 'sppb_osbos';

        $url    = "https://api.npct1.co.id:9443/api/v1/get-customs-ondemand";
        $user   = "BEHANDLE";
        $key    = "5d3a2ffcb778f4b1c224f2447c048c8f";
        $addXML = '<request>
                <document_code>1</document_code>
                <document_no>' . $no_dok . '</document_no>
                <document_date>' . $tgl_dok . '</document_date>
                <npwp>' . $npwp . '</npwp>';
        $addXML .= '</request>';

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
            ),
        ));
        $response = curl_exec($curl);
        if (!curl_errno($curl)) {
            $info = curl_getinfo($curl);
            // echo "Connection Success , This is Url : ", $info['url'], "<br>\r\n";
        } else {
            echo "Connection Failed =" . curl_error($curl);
            echo $response;
            die();
        }
        curl_close($curl);
        $xml1 = str_replace('<?xml version="1.0"?>', "", $response);
        $xml2 = str_replace('&apos;', "", $xml1);
            // echo $xml2;
            // die();
        $currentdatetime = date("Y-m-d H:i:s");

        $xml = simplexml_load_string($xml2);
        $CAR = $xml->DOCUMENT->SPPB->HEADER->CAR;
        $NO_SPPB = $xml->DOCUMENT->SPPB->HEADER->NO_SPPB;
        $TGL_SPPB = $this->gantiformattglgblk($xml->DOCUMENT->SPPB->HEADER->TGL_SPPB);
        $KD_KPBC = $xml->DOCUMENT->SPPB->HEADER->KD_KPBC;
        $NO_PIB = $xml->DOCUMENT->SPPB->HEADER->NO_PIB;
        $TGL_PIB = $this->gantiformattglgblk($xml->DOCUMENT->SPPB->HEADER->TGL_PIB);
        $NPWP_IMP = $xml->DOCUMENT->SPPB->HEADER->NPWP_IMP;
        $NAMA_IMP = $xml->DOCUMENT->SPPB->HEADER->NAMA_IMP;
        $ALAMAT_IMP = $xml->DOCUMENT->SPPB->HEADER->ALAMAT_IMP;
        $NPWP_PPJK = $xml->DOCUMENT->SPPB->HEADER->NPWP_PPJK;
        $NAMA_PPJK = $xml->DOCUMENT->SPPB->HEADER->NAMA_PPJK;
        $ALAMAT_PPJK = $xml->DOCUMENT->SPPB->HEADER->ALAMAT_PPJK;
        $NM_ANGKUT = $xml->DOCUMENT->SPPB->HEADER->NM_ANGKUT;
        $NO_VOY_FLIGHT = $xml->DOCUMENT->SPPB->HEADER->NO_VOY_FLIGHT;
        $BRUTO = $xml->DOCUMENT->SPPB->HEADER->BRUTO;
        $NETTO = $xml->DOCUMENT->SPPB->HEADER->NETTO;
        $GUDANG = $xml->DOCUMENT->SPPB->HEADER->GUDANG;
        $STATUS_JALUR = $xml->DOCUMENT->SPPB->HEADER->STATUS_JALUR;
        $JML_CONT = $xml->DOCUMENT->SPPB->HEADER->JML_CONT;
        $NO_BC11 = $xml->DOCUMENT->SPPB->HEADER->NO_BC11;
        $TGL_BC11 = $this->gantiformattglgblk($xml->DOCUMENT->SPPB->HEADER->TGL_BC11);
        $NO_POS_BC11 = $xml->DOCUMENT->SPPB->HEADER->NO_POS_BC11;
        $NO_BL_AWB = $xml->DOCUMENT->SPPB->HEADER->NO_BL_AWB;
        $TG_BL_AWB = $this->gantiformattglgblk($xml->DOCUMENT->SPPB->HEADER->TG_BL_AWB);
        $NO_MASTER_BL_AWB = $xml->DOCUMENT->SPPB->HEADER->NO_MASTER_BL_AWB;
        $TG_MASTER_BL_AWB = $this->gantiformattglgblk($xml->DOCUMENT->SPPB->HEADER->TG_MASTER_BL_AWB);

        foreach ($xml->DOCUMENT->SPPB->DETIL->CONT as $contdata) {
            $NO_CONT = $contdata->NO_CONT;
            $SIZE = $contdata->SIZE;
            $JNS_MUAT = $contdata->JNS_MUAT;
            $datenow = date("Y-m-d H:i:s");
            //check document udah ada pa belom di permit
            $query = $this->db->query("SELECT * from t_permit_hdr where NO_DOK_INOUT = '$NO_SPPB' and TGL_DOK_INOUT = '$TGL_SPPB'");
            $count = $query->num_rows();
            if ($count === 0) {
                $this->db->query("INSERT INTO t_permit_hdr (CAR, KD_KANTOR, KD_DOK_INOUT, NO_DOK_INOUT, TGL_DOK_INOUT, NO_DAFTAR_PABEAN, TGL_DAFTAR_PABEAN, ID_CONSIGNEE, CONSIGNEE, ALAMAT_CONSIGNEE, NPWP_PPJK, NAMA_PPJK, ALAMAT_PPJK, NM_ANGKUT, NO_VOY_FLIGHT, KD_GUDANG, JML_CONT, BRUTO, NETTO, NO_BC11, TGL_BC11, NO_POS_BC11, NO_BL_AWB, TGL_BL_AWB, NO_MASTER_BL_AWB, TGL_MASTER_BL_AWB, KD_KANTOR_PENGAWAS, KD_KANTOR_BONGKAR, FL_SEGEL, STATUS_JALUR, FL_KARANTINA, KD_STATUS, TGL_STATUS, FL_BAPLIE, BAPLIE_DATE, ANGKUTKODE_TPS, ANGKUTNAMA_TPS, ANGKUTNO_TPS, TMP_TIMBUN_TPS, STATUS, STATUS_MAIL, KD_STATUS_BIL, WK_STATUS, FL_MANUAL, OPERATOR, FL_MIGRASI, FL_NHI, FL_LNSW, LNSW_KD_RESPON, LNSW_IDLOG, LNSW_NOAJU, LNSW_TGLAJU)
                            VALUES ('$CAR', '$KD_KPBC', '1', '$NO_SPPB', '$TGL_SPPB', '$NO_PIB', '$TGL_PIB', '$NPWP_IMP', '$NAMA_IMP', '$ALAMAT_IMP', '$NPWP_PPJK', '$NAMA_PPJK', '$ALAMAT_PPJK', '$NM_ANGKUT', '$NO_VOY_FLIGHT', '$GUDANG', '$JML_CONT', '$BRUTO', '$NETTO', '$NO_BC11', '$TGL_BC11', '$NO_POS_BC11', '$NO_BL_AWB', '$TG_BL_AWB', '$NO_MASTER_BL_AWB', '$TG_MASTER_BL_AWB', NULL, NULL, NULL, '$STATUS_JALUR', NULL, '100', '$datenow', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', 'DASHBOARD_OSBOS', NULL, NULL, NULL, NULL, NULL, NULL, NULL)");
                $insert_id = $this->db->insert_id();
                //insert ke permit cont
                $this->db->query("INSERT into t_permit_cont (ID, NO_CONT, KD_CONT_UKURAN, KD_CONT_JENIS, TGL_STATUS) values ('$insert_id', '$NO_CONT', '$SIZE', '$JNS_MUAT', '$currentdatetime')");
            } else {
                $q = $this->db->query("SELECT * from t_permit_hdr where NO_DOK_INOUT = '$NO_SPPB' and TGL_DOK_INOUT = '$TGL_SPPB'");
                foreach ($q->result() as $key => $value1) {
                    $permitid = $value1->ID;
                    //    echo 'insert pake id = '.$permitid;
                    // cek sudah ada data kontainer biar gak duplikat
                    $query = $this->db->query("SELECT * from t_permit_cont where ID = '$permitid' and NO_CONT = '$NO_CONT'");
                    $count = $query->num_rows();
                    if ($count === 0) {
                        $this->db->query("INSERT IGNORE into t_permit_cont (ID, NO_CONT, KD_CONT_UKURAN, KD_CONT_JENIS, TGL_STATUS) values ('$permitid', '$NO_CONT', '$SIZE', '$JNS_MUAT', '$datenow')");
                    } else {
                        // echo 'data dah ada.<br>';
                    }
                }
            }
        }

        $xmlheader = simplexml_load_string($xml2);

        // Extract the code value
        $code = (string) $xmlheader->code;
        $userondemand = 'OSBOS API';
        // Process the code using if-else
        if ($code === '00') {
            // Success
            $responget = 'Sukses Ondemand Data';
            $this->db->query("INSERT INTO `tpk_ipc`.`solver_req_dokumen_log` (`url`, `tipe`, `no_dok`, `tgl_dok`, `npwp`, `data_respons`, `tambahan`,`response_log`,`user`) VALUES ('https://api.npct1.co.id:9443/api/v1/get-customs-ondemand', '$type', '$no_dok', '$tgl_dok', '$npwp', '$responget', '$addXML','$response', '$userondemand')");

            $this->db->query("INSERT INTO `tpk_ipc`.`log_services` (`METHOD`, `XML_REQUEST`, `XML_RESPONSE`, `WK_REKAM`, `FL_NPCT1`, `FL_SENT_RIZKI`) VALUES ('GET DOKUMEN SPPB FROM API', '$addXML', '$response', '$datenow', 'N', 'N')");
            echo json_encode(array(
                'success' => true,
                'code'    => '00',
                'message' => $responget,
                'data' => array(
                    'no_sppb' => $NO_SPPB,
                    'tgl_sppb' => $TGL_SPPB,
                    'jml_cont' => $JML_CONT
                )
            ));
            return;
        } elseif ($code === '01') {
            // Failed
            $responget =  (string) $xmlheader->description;
            $this->db->query("INSERT INTO `tpk_ipc`.`solver_req_dokumen_log` (`url`, `tipe`, `no_dok`, `tgl_dok`, `npwp`, `data_respons`, `tambahan`,`response_log`,`user`) VALUES ('https://api.npct1.co.id:9443/api/v1/get-customs-ondemand', '$type', '$no_dok', '$tgl_dok', '$npwp', '$responget', '$addXML','$response', '$userondemand')");

            $this->db->query("INSERT INTO `tpk_ipc`.`log_services` (`METHOD`, `XML_REQUEST`, `XML_RESPONSE`, `WK_REKAM`, `FL_NPCT1`, `FL_SENT_RIZKI`) VALUES ('GET DOKUMEN SPPB MANUAL', '$addXML', '$response', '$datenow', 'N', 'N')");
            echo json_encode(array(
                'success' => false,
                'code'    => '01',
                'message' => $responget,
                'data'    => null
            ));
            return;
        } else {
            // Unknown error
            $responget = "Unknown error " . $xmlheader->description;
            $this->db->query("INSERT INTO `tpk_ipc`.`solver_req_dokumen_log` (`url`, `tipe`, `no_dok`, `tgl_dok`, `npwp`, `data_respons`, `tambahan`,`response_log`,`user`) VALUES ('https://api.npct1.co.id:9443/api/v1/get-customs-ondemand', '$type', '$no_dok', '$tgl_dok', '$npwp', '$responget', '$addXML','$response', '$userondemand')");

            $this->db->query("INSERT INTO `tpk_ipc`.`log_services` (`METHOD`, `XML_REQUEST`, `XML_RESPONSE`, `WK_REKAM`, `FL_NPCT1`, `FL_SENT_RIZKI`) VALUES ('GET DOKUMEN SPPB MANUAL', '$addXML', '$response', '$datenow', 'N', 'N')");
            echo json_encode(array(
                'success' => false,
                'code'    => '-',
                'message' => 'Unknown error from HUB service',
                'data'    => null
            ));
            return;
        }
    }
}
