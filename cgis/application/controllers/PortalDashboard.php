<?php defined('BASEPATH') or exit('No direct script access allowed');

class PortalDashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('LOGGED')) {
            redirect(base_url('index.php'), 'refresh');
        }
    }

    public function index()
    {
        $tab = $this->input->get('tab');

        $q1 = $this->db->query("SELECT * FROM (SELECT * FROM t_request_cont
            WHERE date(tgl_status) >= DATE_ADD(NOW() , INTERVAL -10 DAY)) az
        WHERE fl_track = 'N' and tipe_cont IS NULL");
        $q2 = $this->db->query("SELECT * FROM (SELECT * FROM t_request_cont
            WHERE date(tgl_status) >= DATE_ADD(NOW() , INTERVAL -10 DAY)) az
        WHERE fl_track = 'Y' and FL_YARD = 'N' AND tipe_cont IS NULL AND kd_cont_jenis IS null AND kd_status <> 'INQUIRY'");
        $q3 = $this->db->query("SELECT * FROM (SELECT * FROM t_request_cont
            WHERE date(tgl_status) >= DATE_ADD(NOW() , INTERVAL -10 DAY) AND tipe_cont = 'RFR') az
        WHERE fl_track = 'Y' AND kd_status = 'INQUIRY' AND fl_inquiry_done = 'Y' AND unplug_terminal IS null");
        $q4 = $this->db->query("SELECT * FROM (SELECT * FROM t_request_cont
            WHERE kd_status = 'DRAFT' and date(tgl_status) >= DATE_ADD(NOW() , INTERVAL -10 DAY) AND fl_track = 'Y' and tipe_cont IS NOT NULL) az
        WHERE fl_yard = 'Y' AND ref_number IS null");

        if ($tab == "" or $tab == "1") {
            $q = $q1->result();
        } else if ($tab == "2") {
            $q = $q2->result();
        } else if ($tab == "3") {
            $q = $q3->result();
        } else if ($tab == "4") {
            $q = $q4->result();
        }
        $data['chart'] = array($q1->num_rows(), $q2->num_rows(), $q3->num_rows(), $q4->num_rows());
        $data['query'] = $q;
        echo $this->load->view("content/dashboard/dashboardrekon", $data);
    }

    public function dokspjm()
    {
        $data['log_data'] = $this->db->query("SELECT * FROM solver_req_dokumen_log WHERE tipe = 'spjm' ORDER BY id DESC LIMIT 20")->result();
        echo $this->load->view("content/dashboard/dokspjm", $data);
    }
    public function doksppmp()
    {
        $data['log_data'] = $this->db->query("SELECT * FROM solver_req_dokumen_log WHERE tipe = 'spjm' ORDER BY id DESC LIMIT 20")->result();
        echo $this->load->view("content/dashboard/doksppmp", $data);
    }
    public function dokmanual()
    {
        $data['log_data'] = $this->db->query("SELECT a.*,b.NO_DOK_INOUT FROM solver_req_dokumen_log a LEFT JOIN t_permit_hdr b ON a.no_dok = b.NO_DOK_INOUT and b.FL_MANUAL = 'N' WHERE a.tipe = 'manual' ORDER BY a.id DESC LIMIT 20")->result();
        $data['dok_release'] = $this->db->query("SELECT * from reff_kode_dok_bc A where A.JENIS = 'RELEASE' or A.ID = 19 and A.ID not in (1,6)")->result();
        echo $this->load->view("content/dashboard/dokmanual", $data);
    }
    public function doksppb1()
    {
        $data['log_data'] = $this->db->query("SELECT a.*,b.NO_DOK_INOUT FROM solver_req_dokumen_log a LEFT JOIN t_permit_hdr b ON a.no_dok = b.NO_DOK_INOUT  WHERE a.tipe = 'sppb' ORDER BY a.id DESC LIMIT 20")->result();;
        echo $this->load->view("content/dashboard/doksppb", $data);
    }
    public function doksppbnew()
    {
        $data['log_data'] = $this->db->query("SELECT a.*,b.NO_DOK_INOUT FROM solver_req_dokumen_log a LEFT JOIN t_permit_hdr b ON a.no_dok = b.NO_DOK_INOUT  WHERE a.tipe = 'sppbnew' ORDER BY a.id DESC LIMIT 20")->result();;
        echo $this->load->view("content/dashboard/doksppbnew", $data);
    }
    public function doknpe()
    {
        $data['log_data'] = $this->db->query("SELECT a.*,b.NO_DOK_INOUT FROM solver_req_dokumen_log a LEFT JOIN t_permit_hdr b ON a.no_dok = b.NO_DOK_INOUT  WHERE a.tipe = 'npe' ORDER BY a.id DESC LIMIT 20")->result();;
        echo $this->load->view("content/dashboard/doknpe", $data);
    }

    public function gantiformattglgblk($tgl)
    {
        $date = date_create_from_format("m/d/Y", $tgl);
        $date1 = date_format($date, "Y-m-d");
        return $date1;
    }

    //////////////////// HELPER MANUAL ////////////////////
    public function getCarNumber($header)
    {
        // prioritas 1: CAR
        if (isset($header->CAR) && trim((string)$header->CAR) !== '') {
            return trim((string)$header->CAR);
        }

        // prioritas 2: ID
        if (isset($header->ID) && trim((string)$header->ID) !== '') {
            return trim((string)$header->ID);
        }

        return null;
    }

    public function normalizeDateNpct($tgl)
    {
        $tgl = trim($tgl);

        if ($tgl === '') {
            return null;
        }

        // Case 1: YYYYMMDD (20260119)
        if (preg_match('/^\d{8}$/', $tgl)) {
            return DateTime::createFromFormat('Ymd', $tgl)->format('Y-m-d');
        }

        // Case 2: DD/MM/YYYY (08/01/2026)
        if (preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $tgl)) {
            return DateTime::createFromFormat('d/m/Y', $tgl)->format('Y-m-d');
        }

        // Case 3: fallback (kalau ternyata format lain)
        $time = strtotime($tgl);
        if ($time !== false) {
            return date('Y-m-d', $time);
        }

        // gagal parse
        return null;
    }

    public function normalizeNpwp($npwp)
    {
        // ambil angka saja
        $npwp = preg_replace('/\D/', '', $npwp);

        // NPWP lama 15 digit → biarin
        if (strlen($npwp) === 15) {
            return $npwp;
        }

        // NPWP 16 digit NIK-based → biarin
        if (strlen($npwp) === 16) {
            return $npwp;
        }

        // NPWP CEISA / padding → potong ke 15 digit pertama
        if (strlen($npwp) > 16) {
            return substr($npwp, 0, 15);
        }

        return $npwp;
    }
    public function getNpwpConsignee($header, $docType = null)
    {
        // === KHUSUS NPE (EXPORT) ===
        if ($docType === 'NPE') {
            if (isset($header->NPWP_EKS) && trim((string)$header->NPWP_EKS) !== '') {
                return $this->normalizeNpwp((string)$header->NPWP_EKS);
            }
            return null;
        }

        // === IMPORT / DEFAULT ===
        if (isset($header->NPWP_IMP) && trim((string)$header->NPWP_IMP) !== '') {
            return $this->normalizeNpwp((string)$header->NPWP_IMP);
        }

        if (isset($header->ID_CONSIGNEE) && trim((string)$header->ID_CONSIGNEE) !== '') {
            return $this->normalizeNpwp((string)$header->ID_CONSIGNEE);
        }

        return null;
    }

    public function getConsigneeName($header, $docType = null)
    {
        // === KHUSUS NPE (EXPORTER) ===
        if ($docType === 'NPE') {
            if (isset($header->NAMA_EKS) && trim((string)$header->NAMA_EKS) !== '') {
                return $this->normalizeCompanyName((string)$header->NAMA_EKS);
            }
            return null;
        }

        // === IMPORT / DEFAULT ===
        if (isset($header->NM_IMP) && trim((string)$header->NM_IMP) !== '') {
            return $this->normalizeCompanyName((string)$header->NM_IMP);
        }

        if (isset($header->CONSIGNEE) && trim((string)$header->CONSIGNEE) !== '') {
            return $this->normalizeCompanyName((string)$header->CONSIGNEE);
        }

        return null;
    }

    public function normalizeCompanyName($name)
    {
        $name = trim($name);

        // upper-case biar konsisten
        $name = strtoupper($name);

        // rapihin spasi
        $name = preg_replace('/\s+/', ' ', $name);

        // hapus karakter aneh
        $name = preg_replace('/[^A-Z0-9\.\&\-\s]/', '', $name);

        return $name;
    }

    public function getNoDokInOut($docNode)
    {
        // default (MANUAL, DOKPAB, dll)
        if (isset($docNode->HEADER->NO_DOK_INOUT)) {
            return (string) $docNode->HEADER->NO_DOK_INOUT;
        }

        // khusus NPE
        if ($docNode->getName() === 'NPE' && isset($docNode->HEADER->NONPE)) {
            return (string) $docNode->HEADER->NONPE;
        }

        return null;
    }

    public function getTglDokInOut($docNode)
    {
        // default
        if (isset($docNode->HEADER->TGL_DOK_INOUT)) {
            return $this->normalizeDateNpct(
                (string) $docNode->HEADER->TGL_DOK_INOUT
            );
        }

        // khusus NPE
        if ($docNode->getName() === 'NPE' && isset($docNode->HEADER->TGLNPE)) {
            return $this->normalizeDateNpct(
                (string) $docNode->HEADER->TGLNPE
            );
        }

        return null;
    }



    //////////////////// HELPER MANUAL ////////////////////


    public function gantiformattglnpct($tgl)
    {
        $date = date_create_from_format("d/m/Y", $tgl);
        $date1 = date_format($date, "Y-m-d");
        return $date1;
    }
    public function formatdatenpct($tgl)
    {
        $date = date_create_from_format("dmY", $tgl);
        $date1 = date_format($date, "Ymd");
        return $date1;
    }

    public function requestdokumen()
    {
        $type = $this->input->post('type');
        $no_dok = preg_replace('/\s+/', '', $this->input->post('nodok'));
        $nosppb = $this->input->post('nodok');
        $tglsppb = $this->input->post('tgldok');
        $npwpsppb = $this->input->post('npwp');
        $nomanual = preg_replace('/\s+/', '', $this->input->post('noman'));
        $tgl_dok = preg_replace("/[^a-zA-Z0-9]+/", "", $this->input->post('tgldok'));
        $tgl_dok_format_npct = $this->formatdatenpct(preg_replace("/[^a-zA-Z0-9]+/", "", $this->input->post('tgldok')));
        $npwp = preg_replace("/[^a-zA-Z0-9]+/", "", $this->input->post('npwp'));

        if ($type != '') {

            if ($type == 'sppb') {
                $url = "10.1.5.130/TPSServices/WsGetImpor_Sppb_NPCT1.php?NO_SPPB=$no_dok&TGL_SPPB=$tgl_dok&NPWP=$npwp";
            } elseif ($type == 'sppbnew') {

                $url    = "https://api.npct1.co.id:9443/api/v1/get-customs-ondemand";
                $user   = "BEHANDLE";
                $key    = "5d3a2ffcb778f4b1c224f2447c048c8f";
                $addXML = '<request>
                <document_code>1</document_code>
                <document_no>' . $nosppb . '</document_no>
                <document_date>' . $tglsppb . '</document_date>
                <npwp>' . $npwpsppb . '</npwp>';
                $addXML .= '</request>';

                $addXML = trim(preg_replace('/\s\s+/', '', str_replace("\n", " ", $addXML)));
                // print_r($addXML);die();
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
                    echo "Connection Success , This is Url : ", $info['url'], "<br>\r\n";
                } else {
                    echo "Connection Failed =" . curl_error($curl);
                    echo $response;
                    // die();
                }
                curl_close($curl);
                $xml1 = str_replace('<?xml version="1.0"?>', "", $response);
                $xml2 = str_replace('&apos;', "", $xml1);

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
                            VALUES ('$CAR', '$KD_KPBC', '1', '$NO_SPPB', '$TGL_SPPB', '$NO_PIB', '$TGL_PIB', '$NPWP_IMP', '$NAMA_IMP', '$ALAMAT_IMP', '$NPWP_PPJK', '$NAMA_PPJK', '$ALAMAT_PPJK', '$NM_ANGKUT', '$NO_VOY_FLIGHT', '$GUDANG', '$JML_CONT', '$BRUTO', '$NETTO', '$NO_BC11', '$TGL_BC11', '$NO_POS_BC11', '$NO_BL_AWB', '$TG_BL_AWB', '$NO_MASTER_BL_AWB', '$TG_MASTER_BL_AWB', NULL, NULL, NULL, '$STATUS_JALUR', NULL, '100', '$datenow', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', 'DASHBOARD', NULL, NULL, NULL, NULL, NULL, NULL, NULL)");
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
                $userondemand = $_SESSION['USERLOGIN'];
                // Process the code using if-else
                if ($code === '00') {
                    // Success
                    $responget = 'Sukses Ondemand Data';
                    $this->db->query("INSERT INTO `tpk_ipc`.`solver_req_dokumen_log` (`url`, `tipe`, `no_dok`, `tgl_dok`, `npwp`, `data_respons`, `tambahan`,`response_log`,`user`) VALUES ('https://api.npct1.co.id:9443/api/v1/get-customs-ondemand', '$type', '$no_dok', '$tgl_dok', '$npwp', '$responget', '$addXML','$response', '$userondemand')");

                    $this->db->query("INSERT INTO `tpk_ipc`.`log_services` (`METHOD`, `XML_REQUEST`, `XML_RESPONSE`, `WK_REKAM`, `FL_NPCT1`, `FL_SENT_RIZKI`) VALUES ('GET DOKUMEN SPPB MANUAL', '$addXML', '$response', '$datenow', 'N', 'N')");
                } elseif ($code === '01') {
                    // Failed
                    $responget =  (string) $xmlheader->description;
                    $this->db->query("INSERT INTO `tpk_ipc`.`solver_req_dokumen_log` (`url`, `tipe`, `no_dok`, `tgl_dok`, `npwp`, `data_respons`, `tambahan`,`response_log`,`user`) VALUES ('https://api.npct1.co.id:9443/api/v1/get-customs-ondemand', '$type', '$no_dok', '$tgl_dok', '$npwp', '$responget', '$addXML','$response', '$userondemand')");

                    $this->db->query("INSERT INTO `tpk_ipc`.`log_services` (`METHOD`, `XML_REQUEST`, `XML_RESPONSE`, `WK_REKAM`, `FL_NPCT1`, `FL_SENT_RIZKI`) VALUES ('GET DOKUMEN SPPB MANUAL', '$addXML', '$response', '$datenow', 'N', 'N')");
                } else {
                    // Unknown error
                    $responget = "Unknown error " . $xmlheader->description;
                    $this->db->query("INSERT INTO `tpk_ipc`.`solver_req_dokumen_log` (`url`, `tipe`, `no_dok`, `tgl_dok`, `npwp`, `data_respons`, `tambahan`,`response_log`,`user`) VALUES ('https://api.npct1.co.id:9443/api/v1/get-customs-ondemand', '$type', '$no_dok', '$tgl_dok', '$npwp', '$responget', '$addXML','$response', '$userondemand')");

                    $this->db->query("INSERT INTO `tpk_ipc`.`log_services` (`METHOD`, `XML_REQUEST`, `XML_RESPONSE`, `WK_REKAM`, `FL_NPCT1`, `FL_SENT_RIZKI`) VALUES ('GET DOKUMEN SPPB MANUAL', '$addXML', '$response', '$datenow', 'N', 'N')");
                }

                redirect("/PortalDashboard/doksppbnew");
                die();
                // end sppbnew
            } elseif ($type == 'manual') {
                // dokumen manual start
                $url    = "https://api.npct1.co.id:9443/api/v1/get-customs-ondemand";
                $user   = "BEHANDLE";
                $key    = "5d3a2ffcb778f4b1c224f2447c048c8f";
                $addXML = '<request>
                            <document_code>' . $nomanual . '</document_code>
                            <document_no>' . $nosppb . '</document_no>
                            <document_date>' . $tglsppb . '</document_date>
                            <npwp>' . $npwpsppb . '</npwp>';
                                $addXML .= '</request>
                            ';

                $addXML = trim(preg_replace('/\s\s+/', '', str_replace("\n", " ", $addXML)));
                // print_r($addXML);die();
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
                    echo "Connection Success , This is Url : ", $info['url'], "<br>\r\n";
                } else {
                    echo "Connection Failed =" . curl_error($curl);
                    die();
                }
                curl_close($curl);
                echo $response;

                $xml1 = str_replace('<?xml version="1.0"?>', "", $response);
                $xml = simplexml_load_string($xml1);

                // Check if the response contains 'Data Tidak Ditemukan'
                $responget = 'success';
                $code = (string)$xml->code;
                if (strpos($response, 'Data Tidak Ditemukan') !== false) {
                    $responget = 'data tidak ditemukan';
                }

                if ($code  == '00') {
                    $responget = 'success';
                } else {
                    $responget = 'Tidak Ditemukan';
                }
                // echo $code; die();
                if ($code === '00') {
                    foreach ($xml->DOCUMENT->children() as $docNode) {
                        // Extract HEADER data

                        if (!isset($docNode->HEADER)) {
                            continue;
                        }
                        $docType = $docNode->getName();

                        $ID = $this->getCarNumber($docNode->HEADER);
                        $KD_KANTOR = (string) $docNode->HEADER->KD_KANTOR;
                        // antisipasi NPE
                        if (isset($docNode->HEADER->KD_DOK_INOUT)) {
                            $KD_DOK_INOUT = (string) $docNode->HEADER->KD_DOK_INOUT;
                        } elseif ($docType === 'NPE') {
                            $KD_DOK_INOUT = '6';
                        } else {
                            $KD_DOK_INOUT = null;
                        }

                        $NO_DOK_INOUT  = $this->getNoDokInOut($docNode);
                        $TGL_DOK_INOUT = $this->getTglDokInOut($docNode);
                        $NPWP_CONSIGNEE = $this->getNpwpConsignee($docNode->HEADER);
                        $CONSIGNEE = $this->getConsigneeName($docNode->HEADER);
                        $NO_DAFTAR_PABEAN = isset($docNode->HEADER->NO_DAFTAR) ? (string) $docNode->HEADER->NO_DAFTAR : null;
                        $TGL_DAFTAR_PABEAN = isset($docNode->HEADER->TGL_DAFTAR) ? $this->normalizeDateNpct((string) $docNode->HEADER->TGL_DAFTAR) : null;
                        $NPWP_PPJK = (string) $docNode->HEADER->NPWP_PPJK;
                        $NAMA_PPJK = (string) $docNode->HEADER->NAMA_PPJK;
                        $NM_ANGKUT = (string) $docNode->HEADER->NM_ANGKUT;
                        $NO_VOY_FLIGHT = (string) $docNode->HEADER->NO_VOY_FLIGHT;
                        $KD_GUDANG = (string) $docNode->HEADER->KD_GUDANG;
                        $JML_CONT = (string) $docNode->HEADER->JML_CONT;
                        $NO_BC11 = (string) $docNode->HEADER->NO_BC11;
                        $TGL_BC11 = $this->normalizeDateNpct((string) $docNode->HEADER->TGL_BC11);
                        $NO_POS_BC11 = (string) $docNode->HEADER->NO_POS_BC11;
                        $NO_BL_AWB = (string) $docNode->HEADER->NO_BL_AWB;
                        $TG_BL_AWB = $this->normalizeDateNpct((string) $docNode->HEADER->TG_BL_AWB);
                        $FL_SEGEL = (string) $docNode->HEADER->FL_SEGEL;
                        $datenow = date("Y-m-d H:i:s");

                        // if ($this->input->post('nodok') == 'S-632/KPU.1/KPU.104/2026') var_dump($docNode);die();
                        // Check if the record exists
                        $query = $this->db->query(
                            "SELECT * FROM t_permit_hdr WHERE NO_DOK_INOUT = ? AND TGL_DOK_INOUT = ? AND CAR = ?",
                            array($NO_DOK_INOUT, $TGL_DOK_INOUT, $ID)
                        );
                        $count = $query->num_rows();
                        $row = $query->row();
                        $ID_SEARCH = $row->ID;

                        if ($count === 0) {
                            // Insert new HEADER record
                            $dataHdr = array(
                                'CAR'           => $ID,
                                'KD_KANTOR'     => $KD_KANTOR,
                                'KD_DOK_INOUT'  => $KD_DOK_INOUT,
                                'NO_DOK_INOUT'  => $NO_DOK_INOUT,
                                'TGL_DOK_INOUT' => $TGL_DOK_INOUT,
                                'NO_DAFTAR_PABEAN' => $NO_DAFTAR_PABEAN,
                                'TGL_DAFTAR_PABEAN' => $TGL_DAFTAR_PABEAN,

                                'ID_CONSIGNEE'  => $NPWP_CONSIGNEE,
                                'CONSIGNEE'     => $CONSIGNEE,

                                'NPWP_PPJK'     => $NPWP_PPJK,
                                'NAMA_PPJK'     => $NAMA_PPJK,

                                'NM_ANGKUT'     => $NM_ANGKUT,
                                'NO_VOY_FLIGHT' => $NO_VOY_FLIGHT,
                                'KD_GUDANG'     => $KD_GUDANG,
                                'JML_CONT'      => $JML_CONT,

                                'NO_BC11'       => $NO_BC11,
                                'TGL_BC11'      => $TGL_BC11,
                                'NO_POS_BC11'   => $NO_POS_BC11,

                                'NO_BL_AWB'     => $NO_BL_AWB,
                                'TGL_BL_AWB'    => $TG_BL_AWB,

                                'FL_SEGEL'      => $FL_SEGEL,
                                'TGL_STATUS'    => $datenow
                            );
                            $this->db->insert('t_permit_hdr', $dataHdr);
                            $insert_id = $this->db->insert_id();
                        } else {
                            $insert_id = $ID_SEARCH;
                        }

                        // Process DETIL CONT data
                        if (isset($docNode->DETIL->CONT)) {
                            foreach ($docNode->DETIL->CONT as $contdata) {
                                $NO_CONT = (string) $contdata->NO_CONT;
                                $SIZE = (string) $contdata->SIZE;
                                $JNS_MUAT = (string) $contdata->JNS_MUAT;

                                // Insert or update CONT data
                                $this->db->query("INSERT INTO t_permit_cont (ID, NO_CONT, KD_CONT_UKURAN, KD_CONT_JENIS, TGL_STATUS)
                                VALUES ('$insert_id', '$NO_CONT', '$SIZE', '$JNS_MUAT', '$datenow')
                                ON DUPLICATE KEY UPDATE 
                                KD_CONT_UKURAN = '$SIZE', 
                                KD_CONT_JENIS = '$JNS_MUAT'");
                            }
                        }
                    }
                } else {
                    echo 'Data Tidak Ditemukan';
                }

                $userondemand = $_SESSION['USERLOGIN'];
                $this->db->query("INSERT INTO `tpk_ipc`.`solver_req_dokumen_log` (`url`, `tipe`, `no_dok`, `tgl_dok`, `npwp`, `data_respons`,`tambahan`,`response_log`, `user`) VALUES ('https://api.npct1.co.id:9443/api/v1/get-customs-ondemand', '$type', '$no_dok', '$tgl_dok', '$npwp', '$responget', '$addXML', '$response', '$userondemand')");

                $this->db->query("INSERT INTO `tpk_ipc`.`log_services` (`METHOD`, `XML_REQUEST`, `XML_RESPONSE`, `WK_REKAM`, `FL_NPCT1`, `FL_SENT_RIZKI`) VALUES ('GET DOKUMEN MANUAL', '$addXML', '$response', '$datenow', 'N', 'N')");
                //             echo '<textarea rows="30" cols="120">'.$response.'</textarea>';
                // die();
                redirect("/PortalDashboard/dokmanual");
                die();
            } elseif ($type == 'spjm') {

                $curl = curl_init();

                curl_setopt_array($curl, array(
                    CURLOPT_URL => 'https://tpsonline.beacukai.go.id/tps/service.asmx',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_SSL_VERIFYPEER => false,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ser="http://services.beacukai.go.id/">
                                <soapenv:Header/>
                                <soapenv:Body>
                                    <ser:GetSPJM_onDemand>
                                        <!--Optional:-->
                                        <ser:UserName>NCT1</ser:UserName>
                                        <!--Optional:-->
                                        <ser:Password>NCT1123456</ser:Password>
                                        <!--Optional:-->
                                         <ser:noPib>' . $no_dok . '</ser:noPib>
                                        <!--Optional:-->
                                        <ser:tglPib>' . $tgl_dok . '</ser:tglPib>
                                    </ser:GetSPJM_onDemand>
                                </soapenv:Body>
                                </soapenv:Envelope>',
                    CURLOPT_HTTPHEADER => array(
                        'Content-Type: text/xml',
                        'Cookie: Customs_Cookie=!BKsLdKu4OPv+I7VnxDXzvI+DQ/Lmj4a/rPbZoJ++7wHoowWFQIq2+UOOMZwvwF+9EiwWGlvxS2FmDxA='
                    ),
                ));

                $response = curl_exec($curl);

                curl_close($curl);
                // echo $response; die();
                $clean1 = str_replace("&lt;", "<", "$response");
                $clean2 = str_replace("&gt;", ">", "$clean1");
                $clean3 = str_replace('<?xml version="1.0"?>', "", "$clean2");
                $xml1 = simplexml_load_string($clean3);
                $data1 = $xml1->xpath("//soap:Body/*");

                $details1 = $data1[0]->children("http://services.beacukai.go.id/");



                //HEADER
                $CAR = $details1->GetSPJM_onDemandResult->DOCUMENT->SPJM->HEADER->CAR;
                $KD_KANTOR = $details1->GetSPJM_onDemandResult->DOCUMENT->SPJM->HEADER->KD_KANTOR;
                $NO_PIB = $details1->GetSPJM_onDemandResult->DOCUMENT->SPJM->HEADER->NO_PIB;
                $TGL_PIB = $this->gantiformattglgblk($details1->GetSPJM_onDemandResult->DOCUMENT->SPJM->HEADER->TGL_PIB);
                $NPWP_IMP = $details1->GetSPJM_onDemandResult->DOCUMENT->SPJM->HEADER->NPWP_IMP;
                $NAMA_IMP = $details1->GetSPJM_onDemandResult->DOCUMENT->SPJM->HEADER->NAMA_IMP;
                $NPWP_PPJK = $details1->GetSPJM_onDemandResult->DOCUMENT->SPJM->HEADER->NPWP_PPJK;
                $NAMA_PPJK = $details1->GetSPJM_onDemandResult->DOCUMENT->SPJM->HEADER->NAMA_PPJK;
                $GUDANG = $details1->GetSPJM_onDemandResult->DOCUMENT->SPJM->HEADER->GUDANG;
                $JML_CONT = $details1->GetSPJM_onDemandResult->DOCUMENT->SPJM->HEADER->JML_CONT;
                $NO_BC11 = $details1->GetSPJM_onDemandResult->DOCUMENT->SPJM->HEADER->NO_BC11;
                $TGL_BC11 = $this->gantiformattglgblk($details1->GetSPJM_onDemandResult->DOCUMENT->SPJM->HEADER->TGL_BC11);
                $NO_POS_BC11 = $details1->GetSPJM_onDemandResult->DOCUMENT->SPJM->HEADER->NO_POS_BC11;
                $FL_KARANTINA = $details1->GetSPJM_onDemandResult->DOCUMENT->SPJM->HEADER->FL_KARANTINA;
                $NM_ANGKUT = $details1->GetSPJM_onDemandResult->DOCUMENT->SPJM->HEADER->NM_ANGKUT;
                $NO_VOY_FLIGHT = $details1->GetSPJM_onDemandResult->DOCUMENT->SPJM->HEADER->NO_VOY_FLIGHT;
                $TGL_SPJM = $details1->GetSPJM_onDemandResult->DOCUMENT->SPJM->HEADER->TGL_SPJM;
                $datenow = date("Y-m-d");

                if ($responget !== 'data tidak ditemukan') {
                    $query = $this->db->query("SELECT * from t_permit_hdr where NO_DOK_INOUT = '$NO_PIB' and TGL_DOK_INOUT = '$TGL_PIB'");
                    $count = $query->num_rows();
                    if ($count === 0) {
                        $this->db->query("INSERT INTO t_permit_hdr (CAR,KD_KANTOR, KD_DOK_INOUT, NO_DOK_INOUT, TGL_DOK_INOUT, ID_CONSIGNEE, CONSIGNEE,NPWP_PPJK, NAMA_PPJK, NM_ANGKUT, NO_VOY_FLIGHT, KD_GUDANG, JML_CONT, NO_BC11, TGL_BC11, NO_POS_BC11, FL_SEGEL, TGL_STATUS)
                                VALUES ('$CAR','$KD_KANTOR', '19', '$NO_PIB', '$TGL_PIB', '$NPWP_IMP', 
                                '$NAMA_IMP','$NPWP_PPJK' ,'$NAMA_PPJK','$NM_ANGKUT','$NO_VOY_FLIGHT','$GUDANG',
                                '$JML_CONT','$NO_BC11','$TGL_BC11','$NO_POS_BC11','$FL_KARANTINA', '$datenow')");
                        $insert_id = $this->db->insert_id();
                        foreach ($details1->GetSPJM_onDemandResult->DOCUMENT->SPJM->DETIL->CONT as $contdata) {
                            $ID = $contdata->SERI_CONT;
                            $NO_CONT = $contdata->NO_CONT;
                            $SIZE = $contdata->SIZE;

                            $this->db->query("INSERT into t_permit_cont (ID, NO_CONT, KD_CONT_UKURAN, TGL_STATUS) values ('$insert_id', '$NO_CONT', '$SIZE', '$datenow')");
                        }
                        $this->db->query("INSERT INTO t_request (JNS_DOK, NO_DOK, TGL_DOK, NPWP, CONSIGNEE, WK_REKAM)
                                VALUES ('19', '$NO_PIB', '$TGL_PIB', '$NPWP_IMP', '$NAMA_IMP', '$datenow')");
                        $insert_id2 = $this->db->insert_id();
                        foreach ($details1->GetSPJM_onDemandResult->DOCUMENT->SPJM->DETIL->CONT as $contdata) {
                            $ID = $contdata->SERI_CONT;
                            $NO_CONT = $contdata->NO_CONT;
                            $SIZE = $contdata->SIZE;

                            $this->db->query("INSERT into t_request_cont (ID, NO_CONT, UKR_CONT, TGL_STATUS) values ('$insert_id2', '$NO_CONT', '$SIZE', '$datenow')");
                        }
                    }
                }

                $responget = 'success';
                if (strpos($response, 'Data tidak ditemukan') !== false) {
                    $responget = 'data tidak ditemukan';
                };

                $this->db->query("INSERT INTO `tpk_ipc`.`solver_req_dokumen_log` (`url`, `tipe`, `no_dok`, `tgl_dok`, `npwp`, `data_respons`) VALUES ('https://api.npct1.co.id:9443/api/v1/get-customs-ondemand', 'spjm', '$no_dok', '$tgl_dok', '$npwp', '$responget')");
                redirect("/PortalDashboard/dokspjm");
                die();

                // $url = "10.1.5.130/TPSServices/WsGetSPJM_NPCT1.php?NO_PIB=$no_dok&TGL_PIB=$tgl_dok";
            } elseif ($type == 'npe') {
                $curl = curl_init();

                curl_setopt_array($curl, array(
                    CURLOPT_URL => 'https://tpsonline.beacukai.go.id/tps/service.asmx',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_SSL_VERIFYPEER => false,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ser="http://services.beacukai.go.id/">
            <soapenv:Header/>
            <soapenv:Body>
            <ser:GetEkspor_NPE>
            <!--Optional:-->
            <ser:UserName>NCT1</ser:UserName>
            <!--Optional:-->
            <ser:Password>NCT1123456</ser:Password>
            <!--Optional:-->
            <ser:No_PE>' . $no_dok . '</ser:No_PE>
            <!--Optional:-->
            <ser:npwp>' . $npwp . '</ser:npwp>
            <!--Optional:-->
            <ser:kdKantor>040300</ser:kdKantor>
            </ser:GetEkspor_NPE>
            </soapenv:Body>
            </soapenv:Envelope>',
                    CURLOPT_HTTPHEADER => array(
                        'Content-Type: text/xml',
                        'Cookie: Customs_Cookie=!BKsLdKu4OPv+I7VnxDXzvI+DQ/Lmj4a/rPbZoJ++7wHoowWFQIq2+UOOMZwvwF+9EiwWGlvxS2FmDxA='
                    ),
                ));

                $response = curl_exec($curl);

                curl_close($curl);

                $xmlrequest = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ser="http://services.beacukai.go.id/">
            <soapenv:Header/>
            <soapenv:Body>
            <ser:GetEkspor_NPE>
            <!--Optional:-->
            <ser:UserName>NCT1</ser:UserName>
            <!--Optional:-->
            <ser:Password>NCT1123456</ser:Password>
            <!--Optional:-->
            <ser:No_PE>' . $no_dok . '</ser:No_PE>
            <!--Optional:-->
            <ser:npwp>' . $npwp . '</ser:npwp>
            <!--Optional:-->
            <ser:kdKantor>040300</ser:kdKantor>
            </ser:GetEkspor_NPE>
            </soapenv:Body>
            </soapenv:Envelope>';

                $clean1 = str_replace("&lt;", "<", "$response");
                $clean2 = str_replace("&gt;", ">", "$clean1");
                $clean3 = str_replace('<?xml version="1.0"?>', "", "$clean2");

                $xml1 = simplexml_load_string($clean3);
                $data1 = $xml1->xpath("//soap:Body/*");
                $details1 = $data1[0]->children("http://services.beacukai.go.id/");

                //HEADER
                $KD_KANTOR = $details1->GetEkspor_NPEResult->DOCUMENT->NPE->HEADER->KD_KANTOR;
                $NO_DAFTAR = $details1->GetEkspor_NPEResult->DOCUMENT->NPE->HEADER->NO_DAFTAR;
                $TGL_DAFTAR = $details1->GetEkspor_NPEResult->DOCUMENT->NPE->HEADER->TGL_DAFTAR;
                $NONPE = $details1->GetEkspor_NPEResult->DOCUMENT->NPE->HEADER->NONPE;
                $TGLNPE = $details1->GetEkspor_NPEResult->DOCUMENT->NPE->HEADER->TGLNPE;
                $NPWP_EKS = $details1->GetEkspor_NPEResult->DOCUMENT->NPE->HEADER->NPWP_EKS;
                $NAMA_EKS = $details1->GetEkspor_NPEResult->DOCUMENT->NPE->HEADER->NAMA_EKS;
                $FL_SEGEL = $details1->GetEkspor_NPEResult->DOCUMENT->NPE->HEADER->FL_SEGEL;
                $datenow = date("Y-m-d");

                if ($responget !== 'data tidak ditemukan') {
                    $query = $this->db->query("SELECT * from t_permit_hdr where NO_DOK_INOUT = '$NO_DOK_INOUT' and TGL_DOK_INOUT = '$TGL_DOK_INOUT'");
                    $count = $query->num_rows();
                    if ($count === 0) {
                        $this->db->query("INSERT INTO t_permit_hdr (KD_KANTOR, KD_DOK_INOUT, NO_DOK_INOUT, TGL_DOK_INOUT,NO_DAFTAR_PABEAN, TGL_DAFTAR_PABEAN, ID_CONSIGNEE, CONSIGNEE, FL_SEGEL)
                    VALUES ('$KD_KANTOR', '6', '$NONPE', '$TGLNPE', '$NO_DAFTAR', '$TGL_DAFTAR', '$NPWP_EKS', '$NAMA_EKS', '$FL_SEGEL')");
                        $insert_id = $this->db->insert_id();
                        foreach ($details1->GetEkspor_NPEResult->DOCUMENT->NPE->DETIL->CONT as $contdata) {
                            $ID = $contdata->SERI_CONT;
                            $NO_CONT = $contdata->NO_CONT;
                            $SIZE = $contdata->SIZE;

                            $this->db->query("INSERT into t_permit_cont (ID, NO_CONT, KD_CONT_UKURAN, TGL_STATUS) values ('$insert_id', '$NO_CONT', '$SIZE', '$datenow')");
                        }
                    }
                }
                $responget = 'success';
                if (strpos($response, 'Belum ada data baru') !== false) {
                    $responget = 'Belum ada data baru';
                };

                $this->db->query("INSERT INTO `tpk_ipc`.`solver_req_dokumen_log` (`url`, `tipe`, `no_dok`, `tgl_dok`, `npwp`, `data_respons`, `tambahan`, `response_log`) VALUES ('https://api.npct1.co.id:9443/api/v1/get-customs-ondemand', 'npe', '$no_dok', '$tgl_dok', '$npwp', '$responget', '$xmlrequest', '$clean3')");
                redirect("/PortalDashboard/doknpe");
                die();
            }
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $output = curl_exec($ch);
            curl_close($ch);

            $this->db->query("INSERT INTO `tpk_ipc`.`solver_req_dokumen_log` (`url`, `tipe`, `no_dok`, `tgl_dok`, `npwp`, `data_respons`) VALUES ('$url', '$type', '$no_dok', '$tgl_dok', '$npwp', '$output')");
        }

        if ($type == 'sppb') {
            $data['log_data'] = $this->db->query("SELECT a.*,b.NO_DOK_INOUT FROM solver_req_dokumen_log a LEFT JOIN t_permit_hdr b ON a.no_dok = b.NO_DOK_INOUT  WHERE a.tipe = 'sppb' ORDER BY a.id DESC LIMIT 20")->result();;
            echo $this->load->view("content/dashboard/doksppb", $data);
        } elseif ($type == 'manual') {
            $data['log_data'] = $this->db->query("SELECT a.*,b.NO_DOK_INOUT FROM solver_req_dokumen_log a LEFT JOIN t_permit_hdr b ON a.no_dok = b.NO_DOK_INOUT  WHERE a.tipe = 'manual' ORDER BY a.id DESC LIMIT 20")->result();;
            echo $this->load->view("content/dashboard/dokmanual", $data);
        } elseif ($type == 'spjm') {
            $data['log_data'] = $this->db->query("SELECT * FROM solver_req_dokumen_log WHERE tipe = 'spjm' ORDER BY id DESC LIMIT 20")->result();;
            echo $this->load->view("content/dashboard/dokspjm", $data);
        } elseif ($type == 'npe') {
            $data['log_data'] = $this->db->query("SELECT * FROM solver_req_dokumen_log WHERE tipe = 'npe' ORDER BY id DESC LIMIT 20")->result();;
            echo $this->load->view("content/dashboard/doknpe", $data);
        }
    }

    public function request_dokumen_spjm()
    {
        $nosppb = $this->input->post('nodok');
        $tglsppb = $this->input->post('tgldok');
        $npwpsppb = $this->input->post('npwp');
        // header('Content-Type: application/xml');
        $url = "https://api.npct1.co.id:9443/api/v1/get-customs-ondemand";
        $user = "BEHANDLE";
        $key = "5d3a2ffcb778f4b1c224f2447c048c8f";
        $addXML = '<request>
        <document_code>19</document_code>
        <document_no>' . $nosppb . '</document_no>
        <document_date>' . $tglsppb . '</document_date> 
        <npwp>' . $npwpsppb . '</npwp>';
        $addXML .= '</request>';

        $addXML = trim(preg_replace('/\s\s+/', '', str_replace("\n", " ", $addXML)));
        // print_r($addXML);die();
        $curl = curl_init();
        curl_setopt_array(
            $curl,
            array(
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
            )
        );
        $response = curl_exec($curl);
        if (!curl_errno($curl)) {
            $info = curl_getinfo($curl);
            echo "Connection Success , This is Url : ", $info['url'], "<br>\r\n";
        } else {
            echo "Connection Failed =" . curl_error($curl);
            echo $response;
            die();
        }
        curl_close($curl);
        $xml1 = str_replace('<?xml version="1.0"?>', "", $response);
        $xml2 = str_replace('&apos;', "", $xml1);

        $xml = simplexml_load_string($xml2);

        $code = (string) $xml->code;

        if ($code == '0') {
            //proses sukses
            $car = (string) $xml->DOCUMENT->SPJM->HEADER->CAR;
            $kd_kantor = (string) $xml->DOCUMENT->SPJM->HEADER->KD_KANTOR;
            $no_pib = (string) $xml->DOCUMENT->SPJM->HEADER->NO_PIB;
            $tgl_pib = date('Y-m-d', strtotime(str_replace('/', '-', (string) $xml->DOCUMENT->SPJM->HEADER->TGL_PIB)));
            $npwp_imp = (string) $xml->DOCUMENT->SPJM->HEADER->NPWP_IMP;
            $nama_imp = (string) $xml->DOCUMENT->SPJM->HEADER->NAMA_IMP;
            $npwp_ppjk = (string) $xml->DOCUMENT->SPJM->HEADER->NPWP_PPJK;
            $nama_ppjk = (string) $xml->DOCUMENT->SPJM->HEADER->NAMA_PPJK;
            $gudang = (string) $xml->DOCUMENT->SPJM->HEADER->GUDANG;
            $jml_cont = (string) $xml->DOCUMENT->SPJM->HEADER->JML_CONT;
            $no_bc11 = (string) $xml->DOCUMENT->SPJM->HEADER->NO_BC11;
            $tgl_bc11 = date('Y-m-d', strtotime(str_replace('/', '-', (string) $xml->DOCUMENT->SPJM->HEADER->TGL_BC11)));
            $no_pos_bc11 = (string) $xml->DOCUMENT->SPJM->HEADER->NO_POS_BC11;
            $fl_karantina = (string) $xml->DOCUMENT->SPJM->HEADER->FL_KARANTINA;
            $nm_angkut = (string) $xml->DOCUMENT->SPJM->HEADER->NM_ANGKUT;
            $no_voy_flight = (string) $xml->DOCUMENT->SPJM->HEADER->NO_VOY_FLIGHT;

            // Accessing DOK elements
            $no_dok = (string) $xml->DOCUMENT->SPJM->DETIL->DOK->NO_DOK;
            $tgl_dok = date('Y-m-d', strtotime(str_replace('/', '-', (string) $xml->DOCUMENT->SPJM->DETIL->DOK->TGL_DOK)));

            // Check if NO_DOK_INOUT and TGL_DOK_INOUT already exist in t_permit_hdr
            $this->db->where('NO_DOK_INOUT', $no_pib);
            $this->db->where('TGL_DOK_INOUT', $tgl_pib);
            $query = $this->db->get('t_permit_hdr');

            if ($query->num_rows() > 0) {
                // Record exists, get the ID
                $row = $query->row();
                $insert_id = $row->ID;
            } else {
                // Prepare the array for insertion
                $tmpData = array(
                    "CAR" => $car,
                    "KD_KANTOR" => $kd_kantor,
                    "KD_DOK_INOUT" => 19,
                    "NO_DOK_INOUT" => $no_pib,
                    "TGL_DOK_INOUT" => $tgl_pib,
                    "NO_DAFTAR_PABEAN" => $no_pib,
                    "TGL_DAFTAR_PABEAN" => $tgl_pib,
                    "ID_CONSIGNEE" => $npwp_imp,
                    "CONSIGNEE" => $nama_imp,
                    "NPWP_PPJK" => $npwp_ppjk,
                    "NAMA_PPJK" => $nama_ppjk,
                    "NM_ANGKUT" => $nm_angkut,
                    "NO_VOY_FLIGHT" => $no_voy_flight,
                    "KD_GUDANG" => $gudang,
                    "JML_CONT" => $jml_cont,
                    "NO_BC11" => $no_bc11,
                    "TGL_BC11" => $tgl_bc11,
                    "NO_POS_BC11" => $no_pos_bc11,
                    "FL_KARANTINA" => $fl_karantina,
                    "TGL_STATUS" => date('Y-m-d H:i:s')
                );

                // Insert into t_permit_hdr and get the insert ID
                $this->db->insert('t_permit_hdr', $tmpData);
                $insert_id = $this->db->insert_id(); // Get the last inserted ID
            }

            // Loop through CONT elements and insert into t_permit_cont
            foreach ($xml->DOCUMENT->SPJM->DETIL->CONT as $cont) {
                $no_cont = (string) $cont->NO_CONT;

                // Check if the CONT with the same NO_CONT and ID already exists
                $this->db->where('ID', $insert_id);
                $this->db->where('NO_CONT', $no_cont);
                $query = $this->db->get('t_permit_cont');

                if ($query->num_rows() == 0) {
                    // Prepare the array for t_permit_cont
                    $tmpContData = array(
                        "ID" => $insert_id,
                        "NO_CONT" => $no_cont,
                        "KD_CONT_UKURAN" => (string) $cont->SIZE,
                        "FL_PERIKSA" => (string) $cont->FL_PERIKSA,
                        "TGL_STATUS" => date('Y-m-d H:i:s') // Current timestamp
                    );

                    // Insert into t_permit_cont
                    $this->db->insert('t_permit_cont', $tmpContData);
                }
                $datenow = date('Y-m-d H:i:s');
                $responget = 'Sukses Ondemand Data';
                $this->db->query("INSERT INTO `tpk_ipc`.`solver_req_dokumen_log` (`url`, `tipe`, `no_dok`, `tgl_dok`, `npwp`, `data_respons`) VALUES ('https://api.npct1.co.id:9443/api/v1/get-customs-ondemand', 'spjm', '$nosppb', '$tglsppb', '$npwpsppb', '$responget')");

                $this->db->query("INSERT INTO `tpk_ipc`.`log_services` (`METHOD`, `XML_REQUEST`, `XML_RESPONSE`, `WK_REKAM`, `FL_NPCT1`, `FL_SENT_RIZKI`) VALUES ('ONDEMAND SPJM', '$addXML', '$response', '$datenow', 'N', 'N')");
            }
        } elseif ($code == '01') {
            $datenow = date('Y-m-d H:i:s');
            // Failed
            $responget = (string) $xml->description;
            $this->db->query("INSERT INTO `tpk_ipc`.`solver_req_dokumen_log` (`url`, `tipe`, `no_dok`, `tgl_dok`, `npwp`, `data_respons`) VALUES ('https://api.npct1.co.id:9443/api/v1/get-customs-ondemand', 'spjm', '$nosppb', '$tglsppb', '$npwpsppb', '$responget')");

            $this->db->query("INSERT INTO `tpk_ipc`.`log_services` (`METHOD`, `XML_REQUEST`, `XML_RESPONSE`, `WK_REKAM`, `FL_NPCT1`, `FL_SENT_RIZKI`) VALUES ('GET DOKUMEN SPPB MANUAL', '$addXML', '$response', '$datenow', 'N', 'N')");
        } else {
            $datenow = date('Y-m-d H:i:s');
            // Failed
            $responget = (string) $xml->description;
            $this->db->query("INSERT INTO `tpk_ipc`.`solver_req_dokumen_log` (`url`, `tipe`, `no_dok`, `tgl_dok`, `npwp`, `data_respons`) VALUES ('https://api.npct1.co.id:9443/api/v1/get-customs-ondemand', 'spjm', '$nosppb', '$tglsppb', '$npwpsppb', '$responget')");

            $this->db->query("INSERT INTO `tpk_ipc`.`log_services` (`METHOD`, `XML_REQUEST`, `XML_RESPONSE`, `WK_REKAM`, `FL_NPCT1`, `FL_SENT_RIZKI`) VALUES ('GET DOKUMEN SPPB MANUAL', '$addXML', '$response', '$datenow', 'N', 'N')");
        }
        redirect("/PortalDashboard/dokspjm");
    }

    public function request_ssm()
    {
        $url = "https://api.npct1.co.id:9443/api/v1/get-ssm-ondemand";
        $user = "BEHANDLE";
        $key = "5d3a2ffcb778f4b1c224f2447c048c8f";
        $addXML = '<request>    
        <request_no>20120E20EBA220240807000004</request_no>
        <document_no>2024.1.0300.0.K05.I.011707</document_no>';
        $addXML .= '</request>';

        $addXML = trim(preg_replace('/\s\s+/', '', str_replace("\n", " ", $addXML)));
        // print_r($addXML);die();
        $curl = curl_init();
        curl_setopt_array(
            $curl,
            array(
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
            )
        );
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
        header('Content-Type: application/xml');
        echo $xml2;
    }

    public function updatecode()
    {
        $data['code'] = $this->db->query("SELECT * FROM solver_kode_billing  ORDER BY id DESC LIMIT 10")->result();
        echo $this->load->view("content/dashboard/updatecode", $data);
    }

    public function ubahcode()
    {
        //var_dump($_SESSION['USERLOGIN']);die();
        if ($_POST['password'] == '123') {
            $jns = $this->input->post('jenis');

            $this->session->set_flashdata('msg', 'Ubah Kode sukses');
            $num = rand(100, 106);
            $us = $_SESSION['USERLOGIN'];
            $this->db->query("INSERT INTO solver_kode_billing (`jenis`, `kode`, `user_update`) VALUES ('$jns', '$num', '$us')");
        } else {
            $this->session->set_flashdata('msg', 'Password yang Anda Masukan Salah');
        }

        redirect("/PortalDashboard/updatecode");
    }

    public function inforeefer()
    {
        $data['ca'] = $this->db->query("SELECT DISTINCT B.NO_CONT
        FROM t_spk A INNER JOIN t_spk_cont B ON A.ID = B.ID INNER JOIN t_request C ON A.NO_DOK = C.NO_DOK AND A.TGL_DOK = C.TGL_DOK
        INNER JOIN t_request_cont D ON B.NO_CONT =  D.NO_CONT 
        WHERE D.TIPE_CONT = 'RFR' AND B.STATUS_CONT NOT IN (900,950,100)")->num_rows();

        $data['slot'] = $this->db->query("SELECT kode FROM solver_kode_billing WHERE jenis = 'RFR'")->row()->kode;

        echo $this->load->view("content/dashboard/inforeefer", $data);
    }

    public function stackingkontainer()
    {
        $data['cocos'] = $this->db->query("SELECT * from t_cocostshdr where WK_REKAM IS NOT NULL order by id desc limit 1000")->result();
        echo $this->load->view("content/dashboard/stackingcont", $data);
    }

    public function pindahcocos()
    {
        $vesel = $this->input->post('vesel');
        $voy = $this->input->post('voy');
        $id = $this->input->post('id');

        $where = "vessel = '$vesel' and voy_in = '$voy'";
        $idcocos = $id;
        $a = $this->db->query("SELECT * FROM t_request_cont WHERE $where");
        foreach ($a->result() as $key => $value) {
            if ($value->UKR_CONT == '') {
                $UKR_CONT = NULL;
            } else {
                $UKR_CONT = $value->UKR_CONT;
            }
            if ($value->KD_CONT_JENIS == '') {
                $KD_CONT_JENIS = NULL;
            } else {
                $KD_CONT_JENIS = $value->KD_CONT_JENIS;
            }
            if ($value->ISO_CODE == '') {
                $ISO_CODE = NULL;
            } else {
                $ISO_CODE = $value->ISO_CODE;
            }
            if ($value->TIPE_CONT == '') {
                $TIPE_CONT = NULL;
            } else {
                $TIPE_CONT = $value->TIPE_CONT;
            }
            if ($value->BRUTO == '') {
                $BRUTO = 0;
            } else {
                $BRUTO = $value->BRUTO;
            }
            $b = $this->db->query("SELECT ID,NO_CONT from t_cocostscont where NO_CONT = '$value->NO_CONT' and ID = '$idcocos'")->num_rows();
            if ($b == 0) {
                $this->db->query("INSERT INTO `t_cocostscont` (`ID`, `NO_CONT`, `UK_CONT`, `JNS_CONT`, `ISO_CODE`, `TEMPERATURE`, `KD_CONT_TIPE`, `BRUTO`, `NO_SEGEL`, `NO_BL_AWB`, `TGL_BL_AWB`, `NO_MASTER_BL_AWB`, `TGL_MASTER_BL_AWB`, `NO_BC11`, `TGL_BC11`, `NO_POS_BC11`, `ID_CONSIGNEE`, `CONSIGNEE`, `KD_TIMBUN`, `PEL_MUAT`, `PEL_TRANSIT`, `PEL_BONGKAR`, `KD_DOK_IN`, `NO_DOK_IN`, `TGL_DOK_IN`, `WK_IN`, `FL_CONT_KOSONG_IN`, `KD_SARANA_ANGKUT_IN`, `NO_POL_IN`, `GUDANG_TUJUAN_IN`, `NO_DAFTAR_PABEAN_IN`, `TGL_DAFTAR_PABEAN_IN`, `NO_SEGEL_BC_IN`, `TGL_SEGEL_BC_IN`, `NO_IJIN_TPS_IN`, `TGL_IJIN_TPS_IN`, `KODE_KANTOR_IN`, `KD_DOK_OUT`, `NO_DOK_OUT`, `TGL_DOK_OUT`, `WK_OUT`, `FL_CONT_KOSONG_OUT`, `KD_SARANA_ANGKUT_OUT`, `NO_POL_OUT`, `GUDANG_TUJUAN_OUT`, `NO_DAFTAR_PABEAN_OUT`, `TGL_DAFTAR_PABEAN_OUT`, `NO_SEGEL_BC_OUT`, `TGL_SEGEL_BC_OUT`, `NO_IJIN_TPS_OUT`, `TGL_IJIN_TPS_OUT`, `KODE_KANTOR_OUT`, `WK_REKAM`, `FL_BILLING`) VALUES ($idcocos, '$value->NO_CONT', '$UKR_CONT', '$KD_CONT_JENIS', '$ISO_CODE', NULL, '$TIPE_CONT', $BRUTO, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'IDJKT', NULL, NULL, NULL, '$value->DISCHARGE', '1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$date', 'N')");
                echo $value->NO_CONT . " --- terkirim <br>";
            } else {
                echo $value->NO_CONT . " --- Sudah Ada <br>";
            }
        }
    }

    public function getrespononrequest()
    {
        $data['log_data'] = $this->db->query("SELECT a.*,b.LNSW_NOAJU FROM solver_req_dokumen_log a
        left join t_ppk_hdr b on a.no_dok = b.LNSW_NOAJU
        where a.tipe = 'JI' ORDER BY a.id DESC LIMIT 10")->result();;
        echo $this->load->view("content/dashboard/dokji", $data);
    }

    public function pickup()
    {
        if (!$this->session->userdata('LOGGED')) {
            $this->index();
            return;
        }
        $data['title'] = 'MENU HANDHELD';
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('nomerspk', 'NO SPK', 'required');
        if ($this->form_validation->run() === false) {
            $data['code'] = $this->db->query("SELECT ts.NO_SPK, tsc.NO_CONT, ts.NO_DOK, ts.TGL_DOK, ru.NAMA as OPERATOR, tsc.WK_UPDATE from t_spk ts 
            inner join t_spk_cont tsc on ts.ID = tsc.ID
            left join reff_user ru on ru.USER_NAME = tsc.OPERATOR 
            where year(tsc.WK_UPDATE ) >= 2022 and tsc.FL_UPDATE in ('Y') order by tsc.WK_UPDATE desc")->result();
            echo $this->load->view('content/dashboard/pickup', $data);
        } else {
            $this->M_operationn->set_pickup();
        }
    }

    public function search_pickup()
    {

        $data['menuu'] = 'HANDHELD';
        $ss = date('y');
        $keyword    =  strtoupper(str_replace(' ', '', $this->input->post('search_spk')));
        $keyword1    =  strtoupper(str_replace(' ', '', $this->input->post('search_spk')));

        if (substr($keyword, 1, 3) != 'MTI') {
            $keyword    =  "MTI-" . $ss . "/" . $this->input->post('search_spk');
            $keyword1    =  "ITPK-" . $ss . "/" . $this->input->post('search_spk');
        } else {
            $keyword    =  strtoupper(str_replace(' ', '', $this->input->post('search_spk')));
            $keyword1    =  strtoupper(str_replace(' ', '', $this->input->post('search_spk')));
        }
        $this->load->model('M_operationn');
        $re  =   $this->M_operationn->cek_tspk3($keyword, $keyword1);
        $spk = $this->M_operationn->searchco($re['ID']);
        $kondis = $this->M_operationn->ambiltruck();

        if (count($spk) == 0) {
            $data['status'] = 0;
            $data['spk'] = $keyword;
            $data['kode'] = 1;
            $data['code'] = $this->db->query("SELECT ts.NO_SPK, tsc.NO_CONT, ts.NO_DOK, ts.TGL_DOK, ru.NAMA as OPERATOR, tsc.WK_UPDATE from t_spk ts 
            inner join t_spk_cont tsc on ts.ID = tsc.ID
            left join reff_user ru on ru.USER_NAME = tsc.OPERATOR 
            where year(tsc.WK_UPDATE ) >= 2026 and tsc.FL_UPDATE in ('Y') order by tsc.WK_UPDATE desc")->result();
            echo $this->load->view('content/dashboard/pickup', $data);
        } else {
            $data['nilai'] = $spk;
            $data['totale'] = count($spk);
            $data['status'] = 1;
            $data['kondisi'] = $kondis;
            $data['spk'] = $keyword;
            $data['code'] = $this->db->query("SELECT ts.NO_SPK, tsc.NO_CONT, ts.NO_DOK, ts.TGL_DOK, ru.NAMA as OPERATOR, tsc.WK_UPDATE from t_spk ts 
            inner join t_spk_cont tsc on ts.ID = tsc.ID
            left join reff_user ru on ru.USER_NAME = tsc.OPERATOR 
            where year(tsc.WK_UPDATE ) >= 2026 and tsc.FL_UPDATE in ('Y') order by tsc.WK_UPDATE desc")->result();
            echo $this->load->view('content/dashboard/pickup', $data);
        }
    }

    public function kirimnpct1()
    {
        //echo var_dump($_POST);die();
        //var_dump($_SESSION['USERLOGIN']);die();
        $OPERATOR = $_SESSION['USERLOGIN'];
        $cont = $this->input->post('container');
        $plat = $this->input->post('no_plat');
        $this->load->model('Requestgatepass');
        $plat = ltrim($plat);
        $plat = rtrim($plat);

        //$this->db->query("UPDATE t_spk_cont SET ID_FLAT='' WHERE ID= AND NO_CONT=''");

        $datacont = $this->db->query("SELECT A.NO_DOK,A.NO_SPK,A.TGL_DOK,A.NO_CONT,'$plat' as ID_FLAT,B.TAR,B.TIPE_CONT,B.KD_CONT_JENIS,B.VESSEL,B.VOY_IN,B.ISO_CODE,C.NO_PLAT,C.BERAT_TRUCK,B.BRUTO,B.FL_DG,B.FL_OOG FROM(
        SELECT a.NO_DOK,a.TGL_DOK,a.NO_SPK,b.NO_CONT,b.ID_FLAT,b.ISO_CODE FROM t_spk a JOIN t_spk_cont b ON a.ID = b.ID  AND YEAR(a.TGL_DOK)=YEAR(NOW())) A
    JOIN (
        SELECT c.NO_DOK,c.TGL_DOK,d.NO_CONT,d.TAR,d.TIPE_CONT,d.KD_CONT_JENIS,d.VESSEL,d.VOY_IN,d.ISO_CODE,d.BRUTO,d.FL_DG,d.FL_OOG FROM t_request c JOIN t_request_cont d ON c.ID = d.ID) B ON  A.no_dok = B.no_dok AND A.NO_CONT = B.NO_CONT
    LEFT JOIN reff_truck C ON '$plat' = C.NO_TRUCK
    WHERE A.NO_CONT = '$cont' ORDER BY A.TGL_DOK desc")->row();



        //$data1 = $this->Requestgatepass->message2a($datacont);

        $cek1 = $this->db->query("select a.no_cont, max(a.raw_response) as raw_response from log_integrasi_behandle a where a.no_cont ='$cont' and a.type in ('message2b') order by a.no_cont desc limit 1")->result();

        foreach ($cek1 as $key => $value) {
            $raw_response = $value->raw_response;
            $no_cont = $value->no_cont;
        }
        $r = json_encode($raw_response);
        //echo $no_cont;
        //var_dump($r);die();
        //$data2 = $this->Requestgatepass->message2b($datacont);

        //$data3 = json_encode($data1);di
        //  $data3 = $this->Requestgatepass->message3a($datacont);
        //  $data4 = $this->Requestgatepass->message3b($datacont);
        // echo $data1->status;
        // echo $data2->TruckEvent->TruckCall->AppStatus;
        // echo $data3->message;
        // echo $data4->TruckEvent->TruckCall->AppStatus;

        $mes = '';
        if (true) {
            //$data3 = $this->Requestgatepass->message3a($datacont);
            if (true) {
                //$data4 = $this->Requestgatepass->message3b($datacont);
                if (preg_match("/NOK/i", $r)) {
                    $stat = 'success';
                    $this->db->query("UPDATE `t_spk_cont` SET `FL_SEND_NPCT1`='Y' WHERE NO_CONT = '$cont' AND status_cont = '100'");
                    $this->db->query("UPDATE `t_spk_cont` SET `FL_UPDATE`='Y' WHERE `NO_CONT`='$cont' AND status_cont = '100'");
                    $this->db->query("UPDATE `t_spk_cont` SET `OPERATOR`='$OPERATOR' WHERE `NO_CONT`='$cont' AND status_cont = '100'");
                    $this->db->query("UPDATE `t_spk_cont` SET `ID_FLAT`='$plat' WHERE `NO_CONT`='$cont' AND status_cont = '100'");
                } else {
                    // $stat = 'Error';
                    // $mes = 'error3';
                    $stat = 'success';
                    $this->db->query("UPDATE `t_spk_cont` SET `FL_SEND_NPCT1`='Y' WHERE NO_CONT = '$cont' AND status_cont = '100'");
                    $this->db->query("UPDATE `t_spk_cont` SET `FL_UPDATE`='Y' WHERE `NO_CONT`='$cont' AND status_cont = '100'");
                    $this->db->query("UPDATE `t_spk_cont` SET `OPERATOR`='$OPERATOR' WHERE `NO_CONT`='$cont' AND status_cont = '100'");
                    $this->db->query("UPDATE `t_spk_cont` SET `ID_FLAT`='$plat' WHERE `NO_CONT`='$cont' AND status_cont = '100'");
                }
            } else {
                // $stat = 'Error';
                // $mes = 'error2';
                $stat = 'success';
                $this->db->query("UPDATE `t_spk_cont` SET `FL_SEND_NPCT1`='Y' WHERE NO_CONT = '$cont' AND status_cont = '100'");
                $this->db->query("UPDATE `t_spk_cont` SET `FL_UPDATE`='Y' WHERE `NO_CONT`='$cont' AND status_cont = '100'");
                $this->db->query("UPDATE `t_spk_cont` SET `OPERATOR`='$OPERATOR' WHERE `NO_CONT`='$cont' AND status_cont = '100'");
                $this->db->query("UPDATE `t_spk_cont` SET `ID_FLAT`='$plat' WHERE `NO_CONT`='$cont' AND status_cont = '100'");
            }
        } else {
            // $stat = 'Error';
            // $mes = 'error1';
            $stat = 'success';
            $this->db->query("UPDATE `t_spk_cont` SET `FL_SEND_NPCT1`='Y' WHERE NO_CONT = '$cont' AND status_cont = '100'");
            $this->db->query("UPDATE `t_spk_cont` SET `FL_UPDATE`='Y' WHERE `NO_CONT`='$cont' AND status_cont = '100'");
            $this->db->query("UPDATE `t_spk_cont` SET `OPERATOR`='$OPERATOR' WHERE `NO_CONT`='$cont' AND status_cont = '100'");
            $this->db->query("UPDATE `t_spk_cont` SET `ID_FLAT`='$plat' WHERE `NO_CONT`='$cont' AND status_cont = '100'");
        }
        $data['cont'] =  $datacont;
        $data['message'] = $mes;
        $data['status'] = $stat;
        echo json_encode($data);
    }



    public function human_error()
    {
        if (!$this->session->userdata('LOGGED')) {
            $this->index();
            return;
        }
        $data['title'] = 'Portal Dashboard';
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('nomerspk', 'NO SPK', 'required');
        if ($this->form_validation->run() === false) {
            $data['code'] = $this->db->query("SELECT distinct ts.NO_SPK, ts.NO_CONT, ru.NAMA as OPERATOR_UPDATE, ts.WK_UPDATE from t_op_reefer ts 
            left join reff_user ru on ru.USER_NAME = ts.OPERATOR_UPDATE 
            where year(ts.WK_UPDATE) >= 2020 and ts.FL_UPDATE_UNPLUG in ('Y') group by ts.NO_CONT order by ts.WK_UPDATE DESC")->result();
            echo $this->load->view('content/dashboard/human_error', $data);
        } else {
            echo "gagal";
        }
    }

    public function search_container()
    {

        $data['menuu'] = 'HANDHELD';
        $ss = date('y');
        $keyword    =  strtoupper(str_replace(' ', '', $this->input->post('search_spk')));
        $keyword1    =  strtoupper(str_replace(' ', '', $this->input->post('search_spk')));

        if (substr($keyword, 1, 3) != 'MTI') {
            $keyword    =  "MTI-" . $ss . "/" . $this->input->post('search_spk');
            $keyword1    =  "ITPK-" . $ss . "/" . $this->input->post('search_spk');
        } else {
            $keyword    =  strtoupper(str_replace(' ', '', $this->input->post('search_spk')));
            $keyword1    =  strtoupper(str_replace(' ', '', $this->input->post('search_spk')));
        }
        $this->load->model('M_operationn');
        $re  =   $this->M_operationn->cek_tspk4($keyword, $keyword1);
        $spk = $this->M_operationn->searchcon($re['ID']);

        if (count($spk) == 0) {
            $data['status'] = 0;
            $data['spk'] = $keyword;
            $data['kode'] = 1;
            $data['code'] = $this->db->query("SELECT distinct ts.NO_SPK, ts.NO_CONT, ru.NAMA as OPERATOR_UPDATE, ts.WK_UPDATE from t_op_reefer ts 
            left join reff_user ru on ru.USER_NAME = ts.OPERATOR_UPDATE 
            where year(ts.WK_UPDATE) >= 2020 and ts.FL_UPDATE_UNPLUG in ('Y') group by ts.NO_CONT order by ts.WK_UPDATE DESC")->result();
            echo $this->load->view('content/dashboard/human_error', $data);
        } else {
            $data['nilai'] = $spk;
            $data['totale'] = count($spk);
            $data['status'] = 1;
            $data['spk'] = $keyword;
            $data['code'] = $this->db->query("SELECT distinct ts.NO_SPK, ts.NO_CONT, ru.NAMA as OPERATOR_UPDATE, ts.WK_UPDATE from t_op_reefer ts 
            left join reff_user ru on ru.USER_NAME = ts.OPERATOR_UPDATE 
            where year(ts.WK_UPDATE) >= 2020 and ts.FL_UPDATE_UNPLUG in ('Y') group by ts.NO_CONT order by ts.WK_UPDATE DESC")->result();
            echo $this->load->view('content/dashboard/human_error', $data);
        }
    }


    public function ubahunplug()
    {
        //echo var_dump($_POST);die();
        //var_dump($_SESSION['USERLOGIN']);die();
        $OPERATOR = $_SESSION['USERLOGIN'];
        //$nospk = $this->input->post('nospk');
        $cont = $this->input->post('container');
        //$plat = $this->input->post('no_plat');
        $this->load->model('Requestgatepass');
        // $plat = ltrim($plat);
        // $plat = rtrim($plat);

        //$this->db->query("UPDATE t_spk_cont SET ID_FLAT='' WHERE ID= AND NO_CONT=''");

        // $datacont = $this->db->query("SELECT A.NO_DOK,A.NO_SPK,A.TGL_DOK,A.NO_CONT,'$plat' as ID_FLAT,B.TAR,B.TIPE_CONT,B.KD_CONT_JENIS,B.VESSEL,B.VOY_IN,B.ISO_CODE,C.NO_PLAT,C.BERAT_TRUCK,B.BRUTO,B.FL_DG,B.FL_OOG FROM(
        //     SELECT a.NO_DOK,a.TGL_DOK,a.NO_SPK,b.NO_CONT,b.ID_FLAT,b.ISO_CODE FROM t_spk a JOIN t_spk_cont b ON a.ID = b.ID  AND YEAR(a.TGL_DOK)=YEAR(NOW())) A
        //  JOIN (
        //     SELECT c.NO_DOK,c.TGL_DOK,d.NO_CONT,d.TAR,d.TIPE_CONT,d.KD_CONT_JENIS,d.VESSEL,d.VOY_IN,d.ISO_CODE,d.BRUTO,d.FL_DG,d.FL_OOG FROM t_request c JOIN t_request_cont d ON c.ID = d.ID) B ON  A.no_dok = B.no_dok AND A.NO_CONT = B.NO_CONT
        //  LEFT JOIN reff_truck C ON '$plat' = C.NO_TRUCK
        //  WHERE A.NO_CONT = '$cont' ORDER BY A.TGL_DOK desc")->row();



        //$data1 = $this->Requestgatepass->message2a($datacont);

        //  $cek1 = $this->db->query("select a.no_cont, a.raw_response as raw_response from log_integrasi_behandle a where a.no_cont ='$cont' order by a.no_cont desc limit 1")->result();

        //  foreach($cek1 as $key=>$value){
        //   $raw_response = $value->raw_response;
        //   $no_cont= $value->no_cont;
        //  }
        //  $r = json_encode($raw_response);
        //  //echo $no_cont;
        //  var_dump($r);die();
        //$data2 = $this->Requestgatepass->message2b($datacont);

        //$data3 = json_encode($data1);di
        //  $data3 = $this->Requestgatepass->message3a($datacont);
        //  $data4 = $this->Requestgatepass->message3b($datacont);
        // echo $data1->status;
        // echo $data2->TruckEvent->TruckCall->AppStatus;
        // echo $data3->message;
        // echo $data4->TruckEvent->TruckCall->AppStatus;

        $mes = '';
        if (true) {
            //$data3 = $this->Requestgatepass->message3a($datacont);
            if (true) {
                //$data4 = $this->Requestgatepass->message3b($datacont);
                if (true) {
                    $stat = 'success';
                    $this->db->query("UPDATE `t_op_reefer` SET `FL_UNPLUG`='N' WHERE `NO_CONT`='$cont'");
                    $this->db->query("UPDATE `t_op_reefer` SET `FL_UPDATE_UNPLUG`='Y' WHERE `NO_CONT`='$cont'");
                    $this->db->query("UPDATE `t_op_reefer` SET `OPERATOR_UPDATE`='$OPERATOR' WHERE `NO_CONT`='$cont'");
                    $this->db->query("UPDATE `t_op_reefer` SET `WAKTU_END`=null WHERE `NO_CONT`='$cont'");
                } else {
                    $stat = 'Error';
                    $mes = 'error3';
                }
            } else {
                $stat = 'Error';
                $mes = 'error2';
            }
        } else {
            $stat = 'Error';
            $mes = 'error1';
        }
        $data['cont'] =  $datacont;
        $data['message'] = $mes;
        $data['status'] = $stat;
        echo json_encode($data);
    }

    public function jionrequest()
    {
        //echo json_encode($_POST);
        $noaju = $this->input->post('noaju');
        $tglaju = $this->input->post('tglaju');
        $nodok = $this->input->post('nodok');
        $tgldok = $this->input->post('tgldok');
        $jenis = $this->input->post('jnsdok');

        // $q0 = $this->db->query("select a.LNSW_TGLAJU from t_ppk_hdr a where a.LNSW_NOAJU = '$noaju'")->num_rows();

        // if ($q0 > 0) {
        //     redirect('PortalDashboard/getrespononrequest?err=dokada');
        // }
        // echo '$noaju-'.$noaju."<br>";
        // echo '$tglaju-'.$tglaju."<br>";
        // echo '$nodok-'.$nodok."<br>";
        // echo '$tgldok-'.$tgldok."<br>";
        // echo '$jenis-'.$jenis."<br>";
        // die();
        $xml = '<soapenv:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ser="http://services.insw.go.id/">
    <soapenv:Header/>
    <soapenv:Body>
    <ser:getContainerPeriksaOnRequest soapenv:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/">
    <username xsi:type="xsd:string">wsnpct1</username>
    <password xsi:type="xsd:string">pass123abc</password>
    <instansi xsi:type="xsd:string">NPCT1</instansi>
    <no_aju xsi:type="xsd:string">' . $noaju . '</no_aju>
    <tgl_aju xsi:type="xsd:string">' . $tglaju . '</tgl_aju>
    <no_dok xsi:type="xsd:string">' . $nodok . '</no_dok>
    <tgl_dok xsi:type="xsd:string">' . $tgldok . '</tgl_dok>
    <jns_dok xsi:type="xsd:string">' . $jenis . '</jns_dok>
    </ser:getContainerPeriksaOnRequest>
    </soapenv:Body>
    </soapenv:Envelope>';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://10.1.6.206/SSMJIQC/server_insw.php');
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-type: text/xml',
            'Content-length: ' . strlen($xml)
        ));
        $curl1_response = curl_exec($ch);
        if (!curl_errno($ch)) {
            echo "Connection Success , Message from Curl : " . curl_getinfo($ch) . "\r\n";
            echo "Get Data XML .... \r\n";
            $response = $this->db->escape($curl1_response);
            //echo json_encode($response);
            //$response = $this->db->escape($curl1_response);

        } else {
            echo "Connection Failed =" . curl_error($ch);
            die();
        }

        if (preg_match("/{$noaju}/i", $response)) {
            $response =  str_replace('GETCONTAINERPERIKSAONREQUEST', 'GETCONTAINERPERIKSA', $response);
            $sukses = 'SUKSES';
            $insert = $this->db->query("INSERT INTO `t_log_lnsw` (`typelog`, `raw_request`, `raw_respon`) VALUES ('getdokonrespon', '$xml', $response)");
        } else {
            $sukses = 'DATA TIDAK DITEMUKAN';
        }
        $output = $nodok . '#' . $tgldok . '#' . $jenis;
        if ($insert) {
            $this->db->query("INSERT INTO `tpk_ipc`.`solver_req_dokumen_log` (`url`, `tipe`, `no_dok`, `tgl_dok`, `npwp`, `data_respons`, `tambahan`) VALUES ('http://10.1.6.206/SSMJIQC/server_insw.php', 'JI', '$noaju', '$tglaju', NULL, '$sukses', '$output')");
        } else {
            $this->db->query("INSERT INTO `tpk_ipc`.`solver_req_dokumen_log` (`url`, `tipe`, `no_dok`, `tgl_dok`, `npwp`, `data_respons`, `tambahan`) VALUES ('http://10.1.6.206/SSMJIQC/server_insw.php', 'JI', '$noaju', '$tglaju', NULL, '$sukses', '$output')");
        }
        redirect('PortalDashboard/getrespononrequest');
    }

    public function manualbiling()
    {
        $us = $_SESSION['USERLOGIN'];
        $data['search'] = NULL;
        $data['radio'] = '';
        $data['msg'] = '';
        $data['message'] = '';
        $se = $this->input->post('idreq');
        $req = $this->input->post('optradio');
        $sub = $this->input->post('sub');
        $pass = $this->input->post('pass');
        $idbank = $this->input->post('idbank');
        if ($se != '') {
            if ($sub == 1) {
                if ($pass == 'haramdipakaingabs') {
                    $data['msg'] = '1';
                    if ($req == 'behandle') {

                        $ID_REQ = $se;
                        $ID_BANK = $idbank;
                        $SQL = $this->db->query("SELECT NO_NOTA_BEHANDLE AS NO_NOTA FROM req_behandle_hdr WHERE ID_REQ = '$ID_REQ'")->row();
                        if ($SQL->NO_NOTA != null) {
                            // UPDATE DATA BANK
                            $data['msg'] = '0';
                            $data['message'] = 'Invoice sudah jadi nota';
                        } else {
                            $NOTA = $this->db->query("SELECT LPAD(SEQUENCE+1,'6','0') SEQ, (SEQUENCE+1) SEQUE FROM m_generate_nota WHERE TYPE_NOTA = 'FAKTUR'")->row_array();
                            $FAKTUR = $this->db->query("SELECT LPAD(SEQUENCE+1,'8','0') SEQ, (SEQUENCE+1) SEQUE FROM m_generate_nota WHERE TYPE_NOTA = 'FAKTUR'")->row_array();

                            // VARIABEL
                            $YEAR = substr(date('Y'), 2);
                            $VAR['NO_FAKTUR'] = '010.031.' . $YEAR . '.' . $FAKTUR['SEQ'];
                            $VAR['NO_NOTA_BEHANDLE'] = '31.' . date('Y') . '.' . $NOTA['SEQ'];
                            $VAR['TGL_FAKTUR'] = date('Y-m-d H:i:s');
                            $VAR['TGL_NOTA'] = date('Y-m-d H:i:s');
                            $VAR['BANK_ID'] = $ID_BANK;

                            $this->db->where(array('ID_REQ' => $ID_REQ));
                            $EXCT = $this->db->update('req_behandle_hdr', $VAR);

                            // UPDATE SEQUENCE
                            $this->db->where('TYPE_NOTA', 'FAKTUR');
                            $this->db->update('m_generate_nota', array('SEQUENCE' => $FAKTUR['SEQUE']));

                            if (!$EXCT) {
                                $data['msg'] = '0';
                                $data['message'] = 'Gagal';
                            } else {
                                $this->db->query("INSERT INTO `portaldashboard_log` (`typelog`, `user_login`, `isi`) VALUES ('manualbilling', '$us', '$ID_REQ')");
                                $data['msg'] = '1';
                            }
                        }
                    }
                    if ($req == 'delivery') {
                        $ID_REQ = $se;

                        $ID_BANK     = $idbank;

                        $SQL = $this->db->query("SELECT NO_NOTA_DELIVERY AS NO_NOTA FROM req_delivery_hdr WHERE ID_REQ = '$ID_REQ'")->row();

                        if ($SQL->NO_NOTA != null) {
                            $data['msg'] = '0';
                            $data['message'] = 'Invoice sudah jadi nota';
                        } else {
                            $NOTA = $this->db->query("SELECT LPAD(SEQUENCE+1,'6','0') SEQ, (SEQUENCE+1) SEQUE FROM m_generate_nota WHERE TYPE_NOTA = 'FAKTUR'")->row_array();
                            $FAKTUR = $this->db->query("SELECT LPAD(SEQUENCE+1,'8','0') SEQ, (SEQUENCE+1) SEQUE FROM m_generate_nota WHERE TYPE_NOTA = 'FAKTUR'")->row_array();

                            // VARIABEL
                            $YEAR = substr(date('Y'), 2);
                            $VAR['NO_FAKTUR'] = '010.031.' . $YEAR . '.' . $FAKTUR['SEQ'];
                            $VAR['NO_NOTA_DELIVERY'] = '31.' . date('Y') . '.' . $NOTA['SEQ'];
                            $VAR['TGL_FAKTUR'] = date('Y-m-d H:i:s');
                            $VAR['TGL_NOTA'] = date('Y-m-d H:i:s');
                            $VAR['BANK_ID'] = $ID_BANK;
                            $VAR['PAID_STATUS'] = 'DONE';

                            $this->db->where(array('ID_REQ' => $ID_REQ));
                            $EXCT = $this->db->update('req_delivery_hdr', $VAR);

                            // UPDATE SEQUENCE
                            $this->db->where('TYPE_NOTA', 'FAKTUR');
                            $this->db->update('m_generate_nota', array('SEQUENCE' => $FAKTUR['SEQUE']));

                            if (!$EXCT) {
                                $data['msg'] = '0';
                                $data['message'] = 'Gagal';
                            } else {
                                $data['msg'] = '1';
                                $this->db->query("INSERT INTO `portaldashboard_log` (`typelog`, `user_login`, `isi`) VALUES ('manualbilling', '$us', '$ID_REQ')");
                            }
                        }
                        // INSERT TO GATEPASS
                        $SQL = $this->db->query("SELECT EXPIRED,NO_DOK FROM req_delivery_hdr WHERE ID_REQ = '$ID_REQ'")->row_array();
                        $EXPIRED = $SQL['EXPIRED'];
                        $NO_DOK = $SQL['NO_DOK'];

                        $this->insertGatepassDelivery($NO_DOK, $EXPIRED, $ID_REQ);
                    }
                } else {
                    $data['msg'] = '0';
                    $data['message'] = 'Password Salah';
                }
            }
            if ($req == 'delivery') {
                $data['search'] = $this->db->query("SELECT * from req_delivery_hdr where id_req = '$se' ")->row();
                $data['radio'] = 'delivery';
            } else {
                $data['search'] = $this->db->query("SELECT * from req_behandle_hdr where id_req = '$se' ")->row();
                $data['radio'] = 'behandle';
            }
        }
        //echo json_encode($data);
        echo $this->load->view("content/dashboard/manualbilling", $data);
    }

    public function insertGatepassDelivery($cek_nodok, $cek_exp, $id_req)
    {
        $SQLInsGatePAss = "SELECT A.ID, E.NAMA AS 'JNS_DOK',A.NO_DOK_INOUT,A.TGL_DOK_INOUT,'WAITING' AS 'STATUS', '3' AS JNS_KEGIATAN, G.NO_CONT,B.KD_CONT_UKURAN,A.ID_CONSIGNEE,A.CONSIGNEE,F.NM_KAPAL AS 'ANGKUTNAMA_TPS',F.NO_VOY AS 'ANGKUTNO_TPS','' AS 'EXPIRED DATE', D.NO_SPK, NOW() AS 'WK_REQ'
    FROM t_permit_hdr A
    INNER JOIN t_permit_cont B ON A.ID = B.ID
    LEFT JOIN t_spk_cont C ON B.NO_CONT=C.NO_CONT
    LEFT JOIN t_spk D ON C.ID = D.ID
    LEFT JOIN reff_kode_dok_bc E ON A.KD_DOK_INOUT = E.ID
    INNER JOIN req_delivery_hdr F ON A.NO_DOK_INOUT = F.NO_DOK
    INNER JOIN req_delivery_dtl G ON F.ID_REQ = G.ID_REQ
    WHERE  F.ID_REQ='$id_req' AND A.NO_DOK_INOUT = '$cek_nodok' AND D.NO_SPK IS NOT NULL AND G.NO_CONT IS NOT NULL
    GROUP BY G.NO_CONT";
        $result = $this->db->query($SQLInsGatePAss)->result_array();
        $totalCont = count($result);
        for ($i = 0; $i < $totalCont; $i++) {
            $SQLCekGatePass = "SELECT NO_DOK FROM t_gatepass WHERE NO_CONT='" . $result[$i]['NO_CONT'] . "' AND JNS_KEGIATAN = 3 AND NO_DOK = '" . $result[$i]['NO_DOK_INOUT'] . "' AND STATUS='WAITING'";
            $resultGatePass = $this->db->query($SQLCekGatePass)->result_array();
            if (count($resultGatePass) == 0) {
                $tmpData = array(
                    "JNS_DOK" => $result[$i]['JNS_DOK'],
                    "NO_DOK" => $result[$i]['NO_DOK_INOUT'],
                    "TGL_DOK" => $result[$i]['TGL_DOK_INOUT'],
                    "STATUS" => $result[$i]['STATUS'],
                    "JNS_KEGIATAN" => $result[$i]['JNS_KEGIATAN'],
                    "NO_CONT" => $result[$i]['NO_CONT'],
                    "UKR_CONT" => $result[$i]['KD_CONT_UKURAN'],
                    "NPWP" => $result[$i]['ID_CONSIGNEE'],
                    "NAMA_CUST" => $result[$i]['CONSIGNEE'],
                    "NM_KAPAL" => $result[$i]['ANGKUTNAMA_TPS'],
                    "NO_VOY" => $result[$i]['ANGKUTNO_TPS'],
                    "EXPIRED_DATE" => $cek_exp,
                    "NO_SPK" => $result[$i]['NO_SPK'],
                    "WK_REK" => date('Y-m-d H:i:s')
                );
                $this->db->insert('t_gatepass', $tmpData);
            } else {
                $tmpData = array(
                    "JNS_DOK" => $result[$i]['JNS_DOK'],
                    "NO_DOK" => $result[$i]['NO_DOK_INOUT'],
                    "TGL_DOK" => $result[$i]['TGL_DOK_INOUT'],
                    "STATUS" => $result[$i]['STATUS'],
                    "JNS_KEGIATAN" => $result[$i]['JNS_KEGIATAN'],
                    "NO_CONT" => $result[$i]['NO_CONT'],
                    "UKR_CONT" => $result[$i]['KD_CONT_UKURAN'],
                    "NPWP" => $result[$i]['ID_CONSIGNEE'],
                    "NAMA_CUST" => $result[$i]['CONSIGNEE'],
                    "NM_KAPAL" => $result[$i]['ANGKUTNAMA_TPS'],
                    "NO_VOY" => $result[$i]['ANGKUTNO_TPS'],
                    "EXPIRED_DATE" => $cek_exp,
                    "NO_SPK" => $result[$i]['NO_SPK'],
                    "WK_REK" => date('Y-m-d H:i:s')
                );
                $this->db->where(array('ID' => $result[$i]['ID'], 'NO_CONT' => $result[$i]['NO_CONT']));
                $this->db->update('t_gatepass', $tmpData);
            }
            $this->db->where(array('ID' => $result[$i]['ID'], 'NO_CONT' => $result[$i]['NO_CONT']));
            $this->db->update('t_permit_cont', array('FL_GATEPASS' => 'Y'));
        }
    }

    public function updatecoari()
    {
        $dok = $this->input->get('nodok');
        $tgl = $this->input->get('tgldok');

        $tgl = date_format(new DateTime($tgl), 'Y-m-d');

        $data['datser'] = array('nod' => '', 'tgl' => '');
        if ($dok == '' or $tgl == '') {
            $data['search'] = NULL;
        } else {
            $data['datser'] = array('nod' => $dok, 'tgl' => $tgl);
            $data['search'] = $this->db->query("SELECT a.NO_DOK,a.TGL_DOK,b.* FROM t_request a JOIN t_request_cont b ON a.ID = b.ID WHERE a.NO_DOK = '$dok' AND a.TGL_DOK = '$tgl' and b.kd_status ='INQUIRY'")->result();
            // var_dump($data['search']);die();
            // $data['search'] = $this->db->query("SELECT a.NO_DOK,a.TGL_DOK,b.* FROM t_request a 
            // JOIN t_request_cont b ON a.ID = b.ID 
            // JOIN t_spk c ON a.NO_DOK = c.NO_DOK AND c.TGL_SPK = a.TGL_DOK
            // JOIN t_spk_cont d ON c.ID = d.ID AND b.NO_CONT = d.NO_CONT
            // WHERE a.NO_DOK = '$dok' AND d.STATUS_CONT != '900' AND a.TGL_DOK = '$tgl'")->result();
        }


        echo $this->load->view("content/dashboard/updatecoary", $data);
    }
    public function upcoari()
    {

        $id = $this->input->get('id');
        $co = $this->input->get('cont');
        $dok = $this->input->get('nodok');
        $tgl = $this->input->get('tgldok');

        $soapUrl = "https://api.npct1.co.id/services/index.php/behandle"; // asmx URL of WSDL
        $soapUser = "CGO"; //  username
        $soapPassword = "CGO@2017"; // password

        // xml post structure

        $xml_post_string = '<soapenv:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:urn="urn:trackingContainers">
        <soapenv:Header/>
        <soapenv:Body>
        <urn:trackingContainers soapenv:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/">
        <username xsi:type="xsd:string">CGO</username>
        <password xsi:type="xsd:string">CGO@2017</password>
        <xml xsi:type="xsd:string"><![CDATA[
        <request>
        <containers>
        <cont_no>' . $co . '</cont_no>
        </containers>
        </request>
        ]]></xml>
        </urn:trackingContainers>
        </soapenv:Body>
                            </soapenv:Envelope>'; // data from the form, e.g. some ID number

        $headers = array(
            "Content-type: text/xml;charset=\"utf-8\"",
            "Accept: text/xml",
            "Cache-Control: no-cache",
            "Pragma: no-cache",
            "SOAPAction: https://api.npct1.co.id/services/index.php/behandle",
            //"Content-length: " . strlen($xml_post_string),
        ); //SOAPAction: your op URL

        $url = $soapUrl;

        // PHP cURL  for https connection with auth
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //curl_setopt($ch, CURLOPT_USERPWD, $soapUser . ":" . $soapPassword); // username and password - declared at the top of the doc
        //curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_post_string); // the SOAP request
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        // converting
        $response = curl_exec($ch);
        curl_close($ch);
        $arrayName = array(
            //'<!--?xml version="1.0" encoding="ISO-8859-1"?-->',
            //'<SOAP-ENV:Envelope SOAP-ENV:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:SOAP-ENC="http://schemas.xmlsoap.org/soap/encoding/">',
            '<SOAP-ENV:Body>',
            '<ns1:trackingContainersResponse xmlns:ns1="urn:trackingContainers">',
            '<return xsi:type="xsd:string">',
            '</return>',
            '</ns1:trackingContainersResponse>',
            '</SOAP-ENV:Body>',
            //'</SOAP-ENV:Envelope>'
        );
        //echo $response;

        foreach ($arrayName as $key => $value) {
            $response = str_replace($value, '', $response);
        }

        $xml = simplexml_load_string($response);
        header('content-Type: application/json');
        $xml = simplexml_load_string($xml);
        $dat = json_encode($xml);

        // var_dump($dat);die();

        $VESSEL_NAME = $xml->LOOP->VESSEL_NAME;
        $CALL_SIGN = $xml->LOOP->CALL_SIGN;
        $VOYAGE_IN = $xml->LOOP->VOYAGE_IN;
        $VOYAGE_OUT = $xml->LOOP->VOYAGE_OUT;
        $SIZE = $xml->LOOP->CONT_SIZE;
        $JENIS = $xml->LOOP->CONT_STATUS;
        $slice = substr($SIZE, 0, 2);
        $ISOCODE = $xml->LOOP->ISOCODE;
        $REQ_TEMP = $xml->LOOP->REEFER_REQ_TEMP;
        $ACT_TEMP = $xml->LOOP->REEFER_ACT_TEMP;
        $PLUG = $xml->LOOP->REEFER_PLUG_IN;
        $UNPLUG = $xml->LOOP->REEFER_PLUG_OUT;
        $REEFER = $xml->LOOP->REEFER;
        $IMDG = $xml->LOOP->IMDG;
        $DISCHARGE = $xml->LOOP->DISCHARGE;
        $tgl_bongkar = date_format(new DateTime($DISCHARGE), 'Y-m-d H:i:s');
        $OOG = $xml->LOOP->OOG;
        $HOLD = $xml->LOOP->HOLD;
        $ON_YARD = $xml->LOOP->ON_YARD;

        if ($ON_YARD == 'OK') {
            $STAT = 'Y';
        } else {
            $STAT = 'N';
        }

        if ($PLUG != null) {
            $PLUGIN = date_format(new DateTime($PLUG), 'Y-m-d H:i:s');
        } else {
            $PLUGIN = 'kosong';
        }
        if ($UNPLUG != null) {
            $UNPLUGIN = date_format(new DateTime($UNPLUG), 'Y-m-d H:i:s');
        } else {
            $UNPLUGIN = 'kosong';
        }

        $stringq = "UPDATE t_request_cont
        SET KD_CONT_JENIS='$JENIS',
        UKR_CONT='$slice',
        VESSEL='$VESSEL_NAME',
        CALL_SIGN='$CALL_SIGN',
        VOY_IN='$VOYAGE_IN',
        VOY_OUT='$VOYAGE_OUT',
        ISO_CODE='$ISOCODE',
        DISCHARGE='$tgl_bongkar',
        TEMP_CUST='$REQ_TEMP',
        TEMP_TERMINAL='$ACT_TEMP',
        PLUG_TERMINAL='$PLUGIN',
        UNPLUG_TERMINAL='$UNPLUGIN',
        FL_REEFER='$REEFER',
        FL_DG='$IMDG',
        FL_OOG='$OOG',
        HOLD='$HOLD',
        FL_YARD='$STAT',
        FL_TRACK='Y'
        WHERE ID = '$id' AND NO_CONT = '$co'";
        if ($slice != '') {

            $this->db->query($stringq);
            $msg = array('msg' => 'Update Berhasil', 'stat' => '1', 'dok' => $dok, 'tgl' => $tgl);
            $this->session->set_flashdata('msg', $msg);
            $us = $_SESSION['USERLOGIN'];
            $this->db->query("INSERT INTO `portaldashboard_log` (`typelog`, `user_login`, `isi`) VALUES ('UpdateCont', '$us', '$co')");
        } else {
            $msg = array('msg' => 'Update Gagal', 'stat' => '2', 'dok' => $dok, 'tgl' => $tgl);
            $this->session->set_flashdata('msg', $msg);
        }

        redirect("/PortalDashboard/updatecoari?nodok=$dok&tgldok=$tgl");
    }
    public function plugerror()
    {
        $cont = $this->input->get('cont');


        $data['datser'] = array('cont' => '');
        if ($cont == '') {
            $data['search'] = NULL;
        } else {
            $data['datser'] = array('cont' => $cont);
            $data['search'] = $this->db->query("SELECT * from t_request_cont trc where trc.NO_CONT = '$cont' order by trc.id DESC")->result();
        }


        echo $this->load->view("content/dashboard/plugerror", $data);
    }
    public function fixplugerror()
    {

        $id = $this->input->post('id');
        $cont = $this->input->post('no_cont');
        $plug = date_format(date_create($this->input->post('tgl_plug')), "Y-m-d H:i:s");
        $temper = $this->input->post('temper');

        $temp = $this->db->query("SELECT TEMPERATURE from t_cocostscont tc where tc.NO_CONT = '$cont' order by WK_REKAM desc LIMIT 1")->row_array();
        $tempratur = $temp['TEMPERATURE'];
        // $waktu = date("Y-m-d h:i:s");


        if ($temper == '' || $temper == null)
            $this->db->query("UPDATE `t_request_cont` SET `DISCHARGE`= '$plug', TEMP_CUST = '$tempratur', TEMP_TERMINAL = '$tempratur', PLUG_TERMINAL = '$plug', UNPLUG_TERMINAL = '$plug', FL_REEFER = 'Y' WHERE ID = '$id'");
        else
            $this->db->query("UPDATE `t_request_cont` SET `DISCHARGE`= '$plug', TEMP_CUST = '$temper', TEMP_TERMINAL = '$temper', PLUG_TERMINAL = '$plug', UNPLUG_TERMINAL = '$plug', FL_REEFER = 'Y' WHERE ID = '$id'");
    }
    public function updatevessel()
    {
        $dok = $this->input->get('dok');
        $tgl = $this->input->get('tgl');


        $data['datser'] = array('dok' => '');
        if ($dok == '') {
            $data['search'] = NULL;
        } else {
            $data['datser'] = array('dok' => $dok);
            $data['search'] = $this->db->query("SELECT trc.ID, tr.NO_DOK, tr.TGL_DOK, trc.NO_CONT, trc.DISCHARGE, trc.VESSEL, trc.CALL_SIGN, trc.VOY_IN, trc.VOY_OUT  from t_request tr join t_request_cont trc on tr.ID = trc.ID where tr.NO_DOK like '%$dok%' and TGL_DOK like '%$tgl%' ORDER BY trc.ID DESC")->result();
        }


        echo $this->load->view("content/dashboard/updatevessel", $data);
    }
    public function commitupdatevessel()
    {

        $id = $this->input->post('id');
        $cont = $this->input->post('no_cont');
        $discharge = $this->input->post('discharge');
        $vessel = $this->input->post('vessel');
        $call_sign = $this->input->post('call_sign');
        $voy_in = $this->input->post('voy_in');
        $voy_out = $this->input->post('voy_out');

        $this->db->query("UPDATE `t_request_cont` SET `DISCHARGE`= '$discharge', CALL_SIGN = '$call_sign', VESSEL = '$vessel', VOY_IN = '$voy_in', VOY_OUT = '$voy_out' WHERE ID = '$id' AND NO_CONT = '$cont'");


        // if ($temper == '' || $temper == null)
        //     $this->db->query("UPDATE `t_request_cont` SET `DISCHARGE`= '$plug', TEMP_CUST = '$tempratur', TEMP_TERMINAL = '$tempratur', PLUG_TERMINAL = '$plug', UNPLUG_TERMINAL = '$plug', FL_REEFER = 'Y' WHERE ID = '$id'");
        // else
        //     $this->db->query("UPDATE `t_request_cont` SET `DISCHARGE`= '$plug', TEMP_CUST = '$temper', TEMP_TERMINAL = '$temper', PLUG_TERMINAL = '$plug', UNPLUG_TERMINAL = '$plug', FL_REEFER = 'Y' WHERE ID = '$id'");
    }
    public function codeco()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://tpsonline.beacukai.go.id/tps/service.asmx',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '<soapenv:Envelope
          xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
          xmlns:ser="http://services.beacukai.go.id/">
          <soapenv:Header/>
          <soapenv:Body>
          <ser:CoarriCodeco_Container>
          <!--Optional:-->
          <ser:fStream><![CDATA[<?xml version="1.0" encoding="utf-8"?>
          <DOCUMENT
          xmlns="cococont.xsd">
          <COCOCONT>
          <HEADER>
          <KD_DOK>3</KD_DOK>
          <KD_TPS>NCT1</KD_TPS>
          <NM_ANGKUT>MERKUR HORIZON</NM_ANGKUT>
          <NO_VOY_FLIGHT>235S</NO_VOY_FLIGHT>
          <CALL_SIGN>A8UB3</CALL_SIGN>
          <TGL_TIBA>20220916</TGL_TIBA>
          <KD_GUDANG>NCT1</KD_GUDANG>
          <REF_NUMBER>NCT1CGO011834900</REF_NUMBER>
          </HEADER>
          <DETIL>
          <CONT>
          <NO_CONT>MNBU4185755</NO_CONT>
          <UK_CONT>40</UK_CONT>
          <NO_SEGEL></NO_SEGEL>
          <JNS_CONT>F</JNS_CONT>
          <NO_BL_AWB>020062</NO_BL_AWB>
          <TGL_BL_AWB></TGL_BL_AWB>
          <NO_MASTER_BL_AWB></NO_MASTER_BL_AWB>
          <TGL_MASTER_BL_AWB></TGL_MASTER_BL_AWB>
          <ID_CONSIGNEE></ID_CONSIGNEE>
          <CONSIGNEE>PT SINAR HARAPAN BARU</CONSIGNEE>
          <BRUTO>29021</BRUTO>
          <NO_BC11>004150</NO_BC11>
          <TGL_BC11>20220916</TGL_BC11>
          <NO_POS_BC11></NO_POS_BC11>
          <KD_TIMBUN></KD_TIMBUN>
          <KD_DOK_INOUT>1</KD_DOK_INOUT>
          <NO_DOK_INOUT>498805/KPU.01/2022</NO_DOK_INOUT>
          <TGL_DOK_INOUT>20220917</TGL_DOK_INOUT>
          <WK_INOUT>20220917195849</WK_INOUT>
          <KD_SAR_ANGKUT_INOUT></KD_SAR_ANGKUT_INOUT>
          <NO_POL></NO_POL>
          <FL_CONT_KOSONG></FL_CONT_KOSONG>
          <ISO_CODE></ISO_CODE>
          <PEL_MUAT></PEL_MUAT>
          <PEL_TRANSIT></PEL_TRANSIT>
          <PEL_BONGKAR></PEL_BONGKAR>
          <GUDANG_TUJUAN></GUDANG_TUJUAN>
          <KODE_KANTOR></KODE_KANTOR>
          <NO_DAFTAR_PABEAN>497801</NO_DAFTAR_PABEAN>
          <TGL_DAFTAR_PABEAN>20220916</TGL_DAFTAR_PABEAN>
          <NO_SEGEL_BC></NO_SEGEL_BC>
          <TGL_SEGEL_BC></TGL_SEGEL_BC>
          <NO_IJIN_TPS></NO_IJIN_TPS>
          <TGL_IJIN_TPS></TGL_IJIN_TPS>
          </CONT>
          </DETIL>
          </COCOCONT>
          </DOCUMENT>]]></ser:fStream>
          <!--Optional:-->
          <ser:Username>NCT1</ser:Username>
          <!--Optional:-->
          <ser:Password>NCT1123456</ser:Password>
          </ser:CoarriCodeco_Container>
          </soapenv:Body>
          </soapenv:Envelope>',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: text/xml',
                'Cookie: Customs_Cookie=!Mfh1Pq7UpgpIO5pnxDXzvI+DQ/LmjzFTaznyycvhjWAuGJdU5/1/qn8kiAfdRoKCNo5m8Djpvp3fHQI='
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;
    }
    public function requestinsw()
    {

        $noaju = $this->input->post('noaju');

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.insw.go.id/webservice-prod/ssm-qc',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ser="http://services.insw.go.id/">
                    <soapenv:Header/>
                    <soapenv:Body>
                        <ser:getContainerPeriksaOnRequest>
                            <!--Optional:-->
                            <USERNAME>wsnpct1</USERNAME>
                            <!--Optional:-->
                            <PASSWORD>pass123abc</PASSWORD>
                            <!--Optional:-->
                            <INSTANSI></INSTANSI>
                            <!--Optional:-->
                            <NO_AJU>' . $noaju . '</NO_AJU>
                            <!--Optional:-->
                            <TGL_AJU></TGL_AJU>
                            <!--Optional:-->
                            <NO_DOC></NO_DOC>
                            <!--Optional:-->
                            <TGL_DOC></TGL_DOC>
                            <!--Optional:-->
                            <JNS_DOC></JNS_DOC>
                            <!--Optional:-->
                            <kd_tps></kd_tps>
                        </ser:getContainerPeriksaOnRequest>
                    </soapenv:Body>
                    </soapenv:Envelope>',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: text/xml',
                'Cookie: cookiesession1=678B290315F62F94957606533A5D4D91'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        // Load the SOAP response
        $soapResponse = simplexml_load_string($response);

        // Use xpath to find the 'result' element
        $resultArray = $soapResponse->xpath('//result');
        if (!empty($resultArray)) {
            $resultXml = $resultArray[0];  // Access the first result
        } else {
            $resultXml = '';  // Handle case if result is not found
        }

        // Decode the XML entities (like &lt;, &gt;)
        $decodedXml = html_entity_decode($resultXml);

        // Load the decoded XML as SimpleXMLElement to work with it
        $xml = simplexml_load_string($decodedXml);

        // Output the decoded XML
        echo '<textarea readonly rows="20" cols="100">' . htmlspecialchars($decodedXml) . '</textarea>';

        //parsing sebelum input
        $arrayName = array(
            '<?xml version="1.0" encoding="ISO-8859-1"?>',
            '<SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:SOAP-ENC="http://schemas.xmlsoap.org/soap/encoding/">',
            '<SOAP-ENV:Body>',
            '<ns1:getContainerResponse xmlns:ns1="http://services.insw.go.id/"><getContainerResult xsi:type="xsd:string">',
            '</getContainerResult>',
            '</ns1:getContainerResponse>',
            '</SOAP-ENV:Body>',
            '</SOAP-ENV:Envelope>'
        );
        //echo "Start Parsing respon get to string \r\n";
        foreach ($arrayName as $key => $value) {

            $response = str_replace($value, '', $response);
        }
        $response = str_replace('&lt;', '<', $response);
        $response = str_replace('&gt;', '>', $response);
        $response = str_replace('&quot;', '"', $response);
        try {
            $str = explode('<GETCONTAINERPERIKSAONREQUEST>', $response);
            $str = explode('</GETCONTAINERPERIKSAONREQUEST>', $str[1]);
            $json = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?><GETCONTAINERPERIKSAONREQUEST>' . $str[0] . '</GETCONTAINERPERIKSAONREQUEST>';
            $json = simplexml_load_string($json);
            if ($json->KODE != '404') {
                foreach ($json as $val2) {
                    //INSERT INTO `tpk_ipc_dev`.`t_log_detail_insw` (`idlog`, `KODE_RESPONSE`, `NO_AJU`, `TGL_AJU`, `JML_CONTAINER`, `JML_CONTAINER_PERIKSA`, `IMP_ID`, `IMP_NAMA`, `IMP_ALAMAT`, `PJAWAB_NAMA`, `PJAWAB_JABATAN`, `PJAWAB_ALAMAT`, `PJAWAB_TELP`, `PJAWAB_EMAIL`, `TRANSPORT_MODA`, `TRANSPORT_NOMOR`, `TRANSPORT_KODE_TERMINAL`, `TRANSPORT_NAMA`, `TRANSPORT_TGL_TIBA`) VALUES ('1', '1', '1', '2020-10-11', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '2020-10-01');
                    if ($val2->KODE_RESPONSE == '005' or $val2->KODE_RESPONSE == '006' or $val2->KODE_RESPONSE == '507' or $val2->KODE_RESPONSE == '007') {
                        $uniqid = $val2->NO_AJU;
                        //echo "-id = " . $uniqid . " respon = " . $val2->KODE_RESPONSE . " jumlah kontainer = " . $val2->JML_CONTAINER . "\r\n";
                        //echo "-id imp = " . $val2->IMP->ID . "- nama = " . $val2->IMP->NAMA . "- alamat = " . $val2->IMP->ALAMAT . "\r\n";
                        //echo "-moda = " . $val2->TRANSPORT->LIST->MODA . "-NOMOR = " . $val2->TRANSPORT->LIST->NOMOR . "-KODE_TERMINAL = " . $val2->TRANSPORT->LIST->KODE_TERMINAL . "-NAMA = " . $val2->TRANSPORT->LIST->NAMA . "-TGL_TIBA = " . $val2->TRANSPORT->LIST->TGL_TIBA . "\r\n";
                        foreach ($val2->INSTANSI->LOOP as $val3) {
                            //var_dump($val3);
                            //echo "---instansi = " . $val3->INSTANSI . " KODE_KANTOR = " . $val3->KODE_KANTOR . "\r\n";
                            //echo "---NAMA_KANTOR = " . $val3->NAMA_KANTOR . " NO_DOC = " . $val3->NO_DOC . $val3->NAMA_KANTOR . " TGL_DOC = " . $val3->TGL_DOC . "\r\n";
                            $conttransport = $val2->TRANSPORT->LIST->CONTLIST->CONTAINER;
                            $arr11 = array('02', '03', '04');
                            if (in_array($val3->INSTANSI, $arr11)) {
                                $this->datamasukbos('krhdr', $val2, $val3, $dt = array(), $val1);
                                //echo "karantina \r\n";
                            } else {
                                $this->datamasukbos('bchdr', $val2, $val3, $dt = array(), $val1);
                                //echo "bea cukai \r\n";
                            }
                            foreach ($val3->CONTAINER_LIST->CONTLIST_LOOP as $val4) {
                                foreach ($conttransport as $val5) {
                                    // echo "-".$val4->NOCONTAINER."\r\n";
                                    // echo "--".$val5->NOCONT."\r\n";
                                    if (trim($val4->NOCONTAINER) == trim($val5->NOCONT)) {
                                        //echo "------kontainer = " . $val4->NOCONTAINER . " ukuran = " . $val5->UKCONT . " jenis = " . $val5->TPCONT . " periksa = " . $val4->FLAGPERIKSA . "\r\n";
                                        if ($val4->FLAGPERIKSA == 'true') {
                                            $plagperiksa = 'Y';
                                            $tpft = '1';
                                        } else {
                                            $plagperiksa = 'N';
                                            $tpft = '1';
                                        }
                                        //echo "periksa : " . $plagperiksa . "\r\n";
                                        if ($val5->TPCONT == 'GP') {
                                            $typecont = 'DRY';
                                        } else if ($val5->TPCONT == 'RF') {
                                            $typecont = 'RFR';
                                        } else {
                                            $typecont = $val5->TPCONT;
                                        }
                                        $val4g = array(
                                            'cont' => $val4->NOCONTAINER,
                                            'ukuran' => $val5->UKCONT,
                                            'jenis' => $typecont,
                                            'periksa' => $plagperiksa,
                                            'tpft' => $tpft
                                        );
                                        $arr112 = array('02', '03', '04');
                                        if (in_array($val3->INSTANSI, $arr112)) {
                                            $this->datamasukbos('krcont', $val2, $val4g, $val3, $dt = array());
                                        } else {
                                            $this->datamasukbos('bccont', $val2, $val4g, $val3, $dt = array());
                                        }
                                    }
                                }
                            }
                        }
                        echo "\r\n";
                        //echo "----------------------------------------------------------------------------------------------------------";
                        echo "\r\n";
                        $this->datamasukbos('logrespon', $val2, $dt = array(), $dt2 = array(), $val1);
                        $this->datamasukbos('lg', $val2, $dt = array(), $dt2 = array(), $val1);
                    } else {
                        echo $val2->KODE_RESPONSE . " kode respon tersebut tidak masuk list \r\n";
                    }
                }
            }
        } catch (\Throwable $th) {
            echo "kosong \r\n";
        }

        echo "\r\n";
        //echo "###################################################################################################################";
        echo "\r\n";

        if ($val3->NO_DOC != null) {
            $this->db->from('t_ppk_hdr');
            $this->db->where('NO_RESPON', $val3->NO_DOC);
            $this->db->where('TG_RESPON', $val3->TGL_DOC);
            $query = $this->db->get();

            echo ($query->num_rows() > 0) ? 'Data Berhasil Tersimpan' : 'Data Gagal Disimpan';
        }
    }
    public function datamasukbos($type, $data1, $data2, $data3, $tmbah)
    {

        if ($type == 'bchdr') {
            $cekkr = '';
            $ke = 1;
            foreach ($data2->CONTAINER_LIST->CONTLIST_LOOP as $val4) {
                if ($ke > 1) {
                    $cekkr .= ',';
                }
                $cekkr .= "'" . $val4->NOCONTAINER . "'";
                $ke++;
            }
            $cekkr2 = "(" . $cekkr . ")";

            $permithdr = array(
                'CAR' => $data1->NO_AJU,
                'KD_KANTOR' => $data2->KODE_KANTOR,
                'KD_DOK_INOUT' => '19',
                'NO_DOK_INOUT' => $data2->NO_DOC,
                'TGL_DOK_INOUT' => $data2->TGL_DOC,
                'NO_DAFTAR_PABEAN' => $data2->NO_DOC,
                'TGL_DAFTAR_PABEAN' => $data2->TGL_DOC,
                'ID_CONSIGNEE' => $data1->IMP->ID,
                'CONSIGNEE' => $data1->IMP->NAMA,
                'ALAMAT_CONSIGNEE' => $data1->IMP->NAMA,
                'NPWP_PPJK' => NULL,
                'NAMA_PPJK' => NULL,
                'ALAMAT_PPJK' => NULL,
                'NM_ANGKUT' => NULL,
                'NO_VOY_FLIGHT' => NULL,
                'KD_GUDANG' => $data1->TRANSPORT->LIST->KODE_TERMINAL,
                'JML_CONT' => $data1->JML_CONTAINER,
                'BRUTO' => NULL,
                'NETTO' => NULL,
                'NO_BC11' => NULL,
                'TGL_BC11' => NULL,
                'NO_POS_BC11' => NULL,
                'NO_BL_AWB' => NULL,
                'TGL_BL_AWB' => NULL,
                'NO_MASTER_BL_AWB' => NULL,
                'TGL_MASTER_BL_AWB' => NULL,
                'KD_KANTOR_PENGAWAS' => NULL,
                'KD_KANTOR_BONGKAR' => NULL,
                'FL_SEGEL' => NULL,
                'STATUS_JALUR' => NULL,
                'FL_KARANTINA' => NULL,
                'KD_STATUS' => '100',
                'TGL_STATUS' => date('Y-m-d H:i:s'),
                'FL_BAPLIE' => '0',
                'BAPLIE_DATE' => NULL,
                'ANGKUTKODE_TPS' => NULL,
                'ANGKUTNAMA_TPS' => NULL,
                'ANGKUTNO_TPS' => NULL,
                'TMP_TIMBUN_TPS' => NULL,
                'STATUS' => 'N',
                'STATUS_MAIL' => NULL,
                'KD_STATUS_BIL' => NULL,
                'WK_STATUS' => NULL,
                'PATH' => NULL,
                'FL_MANUAL' => 'N',
                'OPERATOR' => NULL,
                'FL_MIGRASI' => 'N',
                'FL_NHI' => 'N',
                'FL_LNSW' => 'Y',
                'LNSW_KD_RESPON' => $data1->KODE_RESPONSE,
                'LNSW_IDLOG' => $tmbah->id,
                'LNSW_NOAJU' => $data1->NO_AJU,
                'LNSW_TGLAJU' => $data1->TGL_AJU
            );
            $permithdrup = array(
                'CAR' => $data1->NO_AJU,
                'KD_KANTOR' => $data2->KODE_KANTOR,
                'KD_DOK_INOUT' => '19',
                'NO_DOK_INOUT' => $data2->NO_DOC,
                'TGL_DOK_INOUT' => $data2->TGL_DOC,
                'NO_DAFTAR_PABEAN' => $data2->NO_DOC,
                'TGL_DAFTAR_PABEAN' => $data2->TGL_DOC,
                'ID_CONSIGNEE' => $data1->IMP->ID,
                'CONSIGNEE' => $data1->IMP->NAMA,
                'ALAMAT_CONSIGNEE' => $data1->IMP->NAMA,
                'KD_GUDANG' => $data1->TRANSPORT->LIST->KODE_TERMINAL,
                'JML_CONT' => $data1->JML_CONTAINER,
                'TGL_STATUS' => date('Y-m-d H:i:s'),
                'FL_LNSW' => 'Y',
                'LNSW_KD_RESPON' => $data1->KODE_RESPONSE,
                'LNSW_IDLOG' => $tmbah->id,
                'LNSW_NOAJU' => $data1->NO_AJU,
                'LNSW_TGLAJU' => $data1->TGL_AJU
            );
            $datatreq = array(
                'no_dok' => $data2->NO_DOC,
                'tgl_dok' => $data2->TGL_DOC
            );
            $jmpermithdr = $this->db->query("SELECT distinct a.id,a.NO_DAFTAR_PABEAN,a.TGL_DAFTAR_PABEAN,a.car from t_permit_hdr a
            JOIN t_permit_cont b ON a.ID = b.id
            WHERE a.NO_DAFTAR_PABEAN = '$data2->NO_DOC' and no_cont IN $cekkr2");
            if ($jmpermithdr->num_rows() == 0) {
                $this->db->insert('t_permit_hdr', $permithdr);
            } else {

                $tprhdr = $this->db->where('id', $jmpermithdr->row()->id);
                $tprhdr = $this->db->set($permithdrup);
                $tprhdr = $this->db->update('t_permit_hdr');

                $treq = $this->db->query("SELECT id,no_dok,tgl_dok FROM t_request WHERE jns_dok != 83 AND no_dok = '$data2->NO_DOC' and year(tgl_dok) = year('$data2->TGL_DOC')");
                if ($treq->num_rows() > 0) {
                    $treq1 = $this->db->where('id', $treq->row()->id);
                    $treq1 = $this->db->set($datatreq);
                    $treq1 = $this->db->update("t_request");
                }
            }
        } else if ($type == 'bccont') {
            $idcont = $this->db->query("SELECT id FROM t_permit_hdr WHERE no_daftar_pabean = '$data3->NO_DOC' AND lnsw_noaju = '$data1->NO_AJU'")->row();
            $permitcont = array(
                'ID' => $idcont->id,
                'NO_CONT' => $data2['cont'],
                'KD_CONT_UKURAN' => $data2['ukuran'],
                'KD_CONT_JENIS' => $data2['jenis'],
                'ISO_CODE' => NULL,
                'TIPE_CONT' => NULL,
                'KD_GUDANG' => NULL,
                'KD_TIMBUN' => NULL,
                'KD_GUDANG_PERIKSA' => NULL,
                'IMO_CODE' => NULL,
                'STATUS_CONT' => 'ND',
                'FL_PERIKSA' => $data2['periksa'],
                'STATUS_RELOKASI' => NULL,
                'KD_STATUS' => '0',
                'TGL_STATUS' => date('Y-m-d H:i:s'),
                'KD_STATUS_BIL' => NULL,
                'WK_STATUS_BIL' => NULL,
                'FL_RELOCATION' => '0',
                'TGL_RELOCATION' => NULL,
                'FL_GATEPASS' => 'N',
                'FL_LNSW' => 'Y'
            );
            $permitcont2 = array(
                'NO_CONT' => $data2['cont'],
                'KD_CONT_UKURAN' => $data2['ukuran'],
                'KD_CONT_JENIS' => $data2['jenis'],
                'FL_PERIKSA' => $data2['periksa'],
                'FL_LNSW' => 'Y'
            );
            $prcont = $data2['cont'];
            $jmlprmitcont = $this->db->query("SELECT id from t_permit_cont where ID = '$idcont->id' and NO_CONT = '$prcont'")->num_rows();

            if ($jmlprmitcont == 0) {
                $this->db->insert('t_permit_cont', $permitcont);
            } else {
                $treqcont = $this->db->where('id', $idcont->id);
                $treqcont = $this->db->where('no_cont', $data2['cont']);
                $treqcont = $this->db->set($permitcont2);
                $treqcont = $this->db->update('t_permit_cont');
            }
        } else if ($type == 'krhdr') {
            $cekkr = '';
            $ke = 1;
            foreach ($data2->CONTAINER_LIST->CONTLIST_LOOP as $val4) {
                if ($ke > 1) {
                    $cekkr .= ',';
                }
                $cekkr .= "'" . $val4->NOCONTAINER . "'";
                $ke++;
            }
            $cekkr2 = "(" . $cekkr . ")";
            $nodok1 = explode('.', $data2->NO_DOC);
            $nodok1 = $nodok1[count($nodok1) - 1];
            $cekdok = $this->db->query("SELECT a.id_ijin,a.NO_RESPON,a.TG_RESPON,LEFT(a.no_respon,4),RIGHT(a.no_respon,6),b.no_cont FROM t_ppk_hdr a JOIN t_ppk_cont b ON a.id_ijin = b.ID_IJIN 
            WHERE LEFT(a.no_respon,4) = YEAR(NOW()) AND RIGHT(a.no_respon,6) = '$nodok1' AND b.no_cont IN  $cekkr2 ");
            if ($cekdok->num_rows() == 0) {
                $t_lic_hdr = array(
                    'ID_IJIN_INSPEKSI' => NULL,
                    'JENIS_DOK' => 'SPPMP',
                    'NO_IJIN' => $data2->NO_DOC,
                    'TGL_AWAL' => NULL,
                    'TGL_IJIN' => $data2->TGL_DOC,
                    'TGL_AKHIR' => NULL,
                    'KETERANGAN' => NULL,
                    'NPWP' => NULL,
                    'NM_TRADER' => $data1->IMP->NAMA,
                    'ALM_TRADER' => $data1->IMP->ALAMAT,
                    'ID_GA' => NULL,
                    'WKPROSES' => NULL,
                    'KD_IJIN' => NULL,
                    'KODE_STATUS' => $data2->KODE_KANTOR,
                    'JNS_IJIN' => NULL,
                    'USED_BY_CAR' => NULL,
                    'JNS_REKAM' => NULL,
                    'REKAM_BY' => NULL,
                    'WK_REKAM' => date('Y-m-d H:i:s'),
                    'UPD_BY' => NULL,
                    'UPD_DATE' => NULL,
                    'FL_BAPLIE' => '0',
                    'BAPLIE_DATE' => NULL
                );
                $idkar = $this->db->query("SELECT id_ijin from t_lic_hdr where NO_IJIN = '$data2->NO_DOC'");

                if ($idkar->num_rows() == 0) {
                    $this->db->insert('t_lic_hdr', $t_lic_hdr);
                }
                $idkar = $this->db->query("SELECT id_ijin from t_lic_hdr where NO_IJIN = '$data2->NO_DOC'");
                //echo "SELECT id_ijin from t_lic_hdr where 'NO_IJIN' = '$data2->NO_DOC' and 'TGL_IJIN' = '$data2->TGL_DOC'";
                $ppkhdr = array(
                    'ID_IJIN' => $idkar->row()->id_ijin,
                    'JN_RESPON' => NULL,
                    'NM_PARTNER' => NULL,
                    'KD_UPT' => NULL,
                    'ALM_PARTNER' => NULL,
                    'NEG_PARTNER' => NULL,
                    'PEL_BKR' => NULL,
                    'PEL_MUAT' => NULL,
                    'TMP_TIMBUN' => $data1->TRANSPORT->LIST->KODE_TERMINAL,
                    'MODA' => NULL,
                    'ANGKUTNAMA' => NULL,
                    'ANGKUTNO' => NULL,
                    'TG_TIBA' => NULL,
                    'JM_CONT' => NULL,
                    'JM_BRG' => NULL,
                    'TUJ_MASUK' => NULL,
                    'NO_RESPON' => $data2->NO_DOC,
                    'NEG_TUJU' => NULL,
                    'DRH_TUJU' => NULL,
                    'TG_RESPON' => $data2->TGL_DOC,
                    'NO_DAFTPPK' => $data2->NO_DOC,
                    'TG_DAFTPPK' => $data2->TGL_DOC,
                    'ISI_RESPON' => NULL,
                    'NIP_JAB' => NULL,
                    'NM_JAB' => NULL,
                    'JAB' => NULL,
                    'TMP_INSTALASI' => NULL,
                    'ALM_INSTALASI' => NULL,
                    'ANGKUTKODE_TPS' => NULL,
                    'ANGKUTNAMA_TPS' => NULL,
                    'ANGKUTNO_TPS' => NULL,
                    'TMP_TIMBUN_TPS' => NULL,
                    'UPDATE_BY' => NULL,
                    'FL_SEND' => 0,
                    'DATE_SEND' => NULL,
                    'STATUS' => 'N',
                    'STATUS_MAIL' => NULL,
                    'WK_STATUS' => NULL,
                    'FL_MANUAL' => 'N',
                    'OPERATOR' => NULL,
                    'FL_LNSW' => 'Y',
                    'LNSW_KD_RESPON' => $data1->KODE_RESPONSE,
                    'LNSW_IDLOG' => $tmbah->id,
                    'LNSW_NOAJU' => $data1->NO_AJU,
                    'LNSW_TGLAJU' => $data1->TGL_AJU
                );
                $idjin = $idkar->row()->id_ijin;
                $jmhdrppk = $this->db->query("SELECT id_ijin from t_ppk_hdr where id_ijin = '$idjin'")->num_rows();
                if ($jmhdrppk == 0) {
                    $this->db->insert('t_ppk_hdr', $ppkhdr);
                }
            } else {
                if ($data1->KODE_RESPONSE == '005') {
                    $t_lic_hdr = array(
                        'JENIS_DOK' => 'SPPMP',
                        'NO_IJIN' => $data2->NO_DOC,
                        'TGL_IJIN' => $data2->TGL_DOC,
                        'NM_TRADER' => $data1->IMP->NAMA,
                        'ALM_TRADER' => $data1->IMP->ALAMAT,
                        'KODE_STATUS' => $data2->KODE_KANTOR,
                        'WK_REKAM' => date('Y-m-d H:i:s'),
                        'FL_BAPLIE' => '0'
                    );
                    $ppkhdr = array(
                        'ID_IJIN' => $cekdok->row()->id_ijin,
                        'TMP_TIMBUN' => $data1->TRANSPORT->LIST->KODE_TERMINAL,
                        'NO_RESPON' => $data2->NO_DOC,
                        'TG_RESPON' => $data2->TGL_DOC,
                        'NO_DAFTPPK' => $data2->NO_DOC,
                        'TG_DAFTPPK' => $data2->TGL_DOC,
                        'OPERATOR' => 'LNSW',
                        'FL_LNSW' => 'Y',
                        'LNSW_KD_RESPON' => $data1->KODE_RESPONSE,
                        'LNSW_IDLOG' => $tmbah->id,
                        'LNSW_NOAJU' => $data1->NO_AJU,
                        'LNSW_TGLAJU' => $data1->TGL_AJU
                    );

                    $datatreq = array(
                        'no_dok' => $data2->NO_DOC,
                        'tgl_dok' => $data2->TGL_DOC,
                        'consignee' => $data1->IMP->NAMA
                    );

                    $lic = $this->db->where('id_ijin', $cekdok->row()->id_ijin);
                    $lic = $this->db->set($t_lic_hdr);
                    $lic = $this->db->update('t_lic_hdr');

                    $hdr = $this->db->where('id_ijin', $cekdok->row()->id_ijin);
                    $hdr = $this->db->set($ppkhdr);
                    $hdr = $this->db->update('t_ppk_hdr');

                    $treq = $this->db->query("SELECT id,no_dok,tgl_dok FROM t_request WHERE jns_dok = 83 AND LEFT(no_dok,4) = YEAR(NOW()) and RIGHT(no_dok,12) = '$nodok1' ORDER BY id desc");
                    if ($treq->num_rows() > 0) {
                        $treq1 = $this->db->where('id', $treq->row()->id);
                        $treq1 = $this->db->set($datatreq);
                        $treq1 = $this->db->update("t_request");
                    }
                }
            }
        } else if ($type == 'krcont') {
            $nodok1 = explode('.', $data3->NO_DOC);
            $nodok1 = $nodok1[count($nodok1) - 1];
            $nocd = $data2['cont'];
            $cekdok = $this->db->query("SELECT a.id_ijin,a.NO_RESPON,a.TG_RESPON,LEFT(a.no_respon,4),RIGHT(a.no_respon,6),b.no_cont FROM t_ppk_hdr a JOIN t_ppk_cont b ON a.id_ijin = b.ID_IJIN 
            WHERE LEFT(a.no_respon,4) = YEAR(NOW()) AND RIGHT(a.no_respon,6) = '$nodok1' AND b.no_cont = '$nocd' ");

            if ($cekdok->num_rows() == 0) {
                $idcont = $this->db->query("SELECT id_ijin FROM t_ppk_hdr WHERE no_respon = '$data3->NO_DOC' AND tg_respon = '$data3->TGL_DOC' ")->row();
                $ppkcont = array(
                    'ID_IJIN' => $idcont->id_ijin,
                    'NO_CONT' => $data2['cont'],
                    'SEGEL' => NULL,
                    'UKURAN' => $data2['ukuran'],
                    'ISO_CODE' => NULL,
                    'TIPE_CONT' => $data2['jenis'],
                    'IMO_CODE' => NULL,
                    'NO_TPFT' => $data2['tpft'],
                    'TGL_TPFT' => $data3->TGL_DOC,
                    'KD_GUDANG' => NULL,
                    'KD_GUDANG_PERIKSA' => NULL,
                    'KD_TIMBUN' => NULL,
                    'STATUS_CONT' => 'ND',
                    'STATUS_RELOKASI' => NULL,
                    'KD_STATUS' => '0',
                    'TGL_STATUS' => date('Y-m-d H:i:s'),
                    'FL_RELOCATION' => '0',
                    'TGL_RELOCATION' => NULL,
                    'FL_GATEPASS' => 'N',
                    'FL_TPS' => 'N',
                    'WK_FL_TPS' => NULL,
                    'FL_XML' => 'N',
                    'WK_FL_XML' => NULL,
                    'FL_LNSW' => 'Y',
                    'FL_LNSW_PERIKSA' => $data2['periksa']
                );
                $nc = $data2['cont'];
                $jmlcont = $this->db->query("SELECT id_ijin from t_ppk_cont where id_ijin = '$idcont->id_ijin' and no_cont = '$nc' ")->num_rows();
                if ($jmlcont == 0) {
                    if ($data1->KODE_RESPONSE == '005') {
                        $this->db->insert('t_ppk_cont', $ppkcont);
                    } else {
                        if ($data2['periksa'] == 'Y') {
                            $this->db->insert('t_ppk_cont', $ppkcont);
                        }
                    }
                }
            } else {
                $ppkcont = array(
                    'NO_CONT' => $data2['cont'],
                    'UKURAN' => $data2['ukuran'],
                    'TIPE_CONT' => $data2['jenis'],
                    'NO_TPFT' => $data2['tpft'],
                    'TGL_TPFT' => $data3->TGL_DOC,
                    'TGL_STATUS' => date('Y-m-d H:i:s'),
                    'FL_LNSW' => 'Y',
                    'FL_LNSW_PERIKSA' => $data2['periksa']
                );
                $nc = $data2['cont'];
                $cont5 = $this->db->set($ppkcont);
                $cont5 = $this->db->where('id_ijin', $cekdok->row()->id_ijin);
                $cont5 = $this->db->where('no_cont', $data2['cont']);
                $cont5 = $this->db->update('t_ppk_cont');
            }
        } else if ($type == 'lg') {
            $data22 = array(
                'idlog' => $tmbah->id,
                'KODE_RESPONSE' => $data1->KODE_RESPONSE,
                'NO_AJU' => $data1->NO_AJU,
                'TGL_AJU' => $data1->TGL_AJU,
                'JML_CONTAINER' => $data1->JML_CONTAINER,
                'JML_CONTAINER_PERIKSA' => $data1->JML_CONTAINER_PERIKSA,
                'IMP_ID' => $data1->IMP->ID,
                'IMP_NAMA' => $data1->IMP->NAMA,
                'IMP_ALAMAT' => $data1->IMP->ALAMAT,
                'PJAWAB_NAMA' => $data1->IMP->PJAWAB->NAMA,
                'PJAWAB_JABATAN' => $data1->IMP->PJAWAB->JABATAN,
                'PJAWAB_ALAMAT' => $data1->IMP->PJAWAB->ALAMAT,
                'PJAWAB_TELP' => $data1->IMP->PJAWAB->TELP,
                'PJAWAB_EMAIL' => $data1->IMP->PJAWAB->EMAIL,
                'TRANSPORT_MODA' => $data1->TRANSPORT->LIST->MODA,
                'TRANSPORT_NOMOR' => $data1->TRANSPORT->LIST->NOMOR,
                'TRANSPORT_KODE_TERMINAL' => $data1->TRANSPORT->LIST->KODE_TERMINAL,
                'TRANSPORT_NAMA' => $data1->TRANSPORT->LIST->NAMA,
                'TRANSPORT_TGL_TIBA' => $data1->TRANSPORT->LIST->TGL_TIBA
            );
            $this->db->insert('t_log_detail_lnsw', $data22);
        } else if ($type == 'logrespon') {

            $respon = array(
                'no_aju' => $data1->NO_AJU,
                'tgl_aju' => $data1->TGL_AJU
            );
            $noaju5 = $data1->NO_AJU;
            $tglaj5 = $data1->TGL_AJU;
            $cekrespon = $this->db->query("SELECT id FROM t_log_lnsw_respon_cont WHERE no_aju = '$noaju5' AND tgl_aju = '$tglaj5'")->num_rows();
            if ($cekrespon == 0) {
                $this->db->insert('t_log_lnsw_respon_cont', $respon);
            }
        }
    }
    public function lihat_log()
    {
        $id = isset($_GET['id']) ? $_GET['id'] : null;

        if (!$id) {
            echo "<p>Error: ID is required.</p>";
            return;
        }
        $query = $this->db->query("SELECT tambahan ,response_log FROM solver_req_dokumen_log WHERE id = '" . addslashes($id) . "'");

        if ($query->num_rows() > 0) {
            $logData = $query->row();
            $responseLog = htmlspecialchars($logData->response_log, ENT_QUOTES, 'UTF-8');
            $formattedXml = $this->formatXml($responseLog);
            $requestLog = htmlspecialchars($logData->tambahan, ENT_QUOTES, 'UTF-8');
            $requestXml = $this->formatXml($requestLog);
            echo "<html>
                    <head>
                        <title>View Log</title>
                    </head>
                    <body>
                        <h1>Request Log</h1>
                        <textarea rows='5' cols='150' readonly>$requestXml</textarea>
                        <h1>Response Log</h1>
                        <textarea rows='25' cols='150' readonly>$formattedXml</textarea>
                    </body>
                  </html>";
        } else {
            echo "<p>Error: No data found for the given ID.</p>";
        }
    }

    public function liat_itungan_bhd()
    {
        $REQ = isset($_GET['req']) ? $_GET['req'] : '';
        $seal = isset($_GET['seal']) ? (int)$_GET['seal'] : 0;

        // 1. SUM_MAX_ID
        $SUM_MAX_ID_QUERY = "SELECT ID_REQ AS 'ID' FROM req_behandle_dtl WHERE ID_REQ IN
            (SELECT ID_REQ FROM req_behandle_dtl WHERE SUBSTRING(ID_REQ, 16) =
            (SELECT IFNULL(COUNT(id_req),1) AS 'urut' FROM req_behandle_hdr))";
        $SUM_MAX_ID = $this->db->query($SUM_MAX_ID_QUERY)->row()->ID;

        echo "SUM_MAX_ID: $SUM_MAX_ID<br>";

        // 2. MAX ID
        $SQL_MAX = $this->db->query("SELECT MAX(ID) AS ID FROM req_behandle_hdr")->row()->ID;
        $MAX_ID = $SQL_MAX;
        echo "MAX_ID: $MAX_ID<br>";

        // 3. SUB TOTAL 1
        $sub_total1_query = "SELECT SUM(TOTAL) AS TOTAL FROM req_behandle_dtl WHERE ID_REQ = '$REQ'";
        $sub_total1 = $this->db->query($sub_total1_query)->row()->TOTAL;
        echo "Sub Total 1: $sub_total1<br>";

        // 4. BIAYA ADMIN
        $BA = $this->db->query("SELECT TARIF AS Tarif FROM m_tarif WHERE JENIS_BIAYA = 'ADMINISTRASI'")->row()->Tarif;
        echo "Biaya Admin: $BA<br>";

        // 5. TARIF PPN
        $tarif_ppn = $this->db->query("SELECT TARIF AS Tarif FROM m_tarif2 WHERE JENIS_BIAYA = 'PPN'")->row()->Tarif;
        $tarif_ppn_final = $tarif_ppn / 100;
        echo "Tarif PPN: $tarif_ppn (%: $tarif_ppn_final)<br>";

        // 6. Sub Total A
        $sub_totalA = $sub_total1 + $BA + $seal;
        echo "Sub Total A (subtotal1 + admin + seal): $sub_totalA<br>";

        // 7. PPN Amount
        $PPN = $sub_totalA * $tarif_ppn_final;
        echo "PPN Amount: $PPN<br>";

        // 8. Sub Total BM
        $sub_totalBM  = $sub_totalA + $PPN;
        echo "Sub Total BM (subtotalA + PPN): $sub_totalBM<br>";

        // 9. Materai
        if ($sub_totalBM > 5000000) {
            $MAT = 10000;
        } else {
            $MAT = 0;
        }
        echo "Biaya Materai: $MAT<br>";

        // 10. TOTAL ALL
        $TOTAL_ALL = $sub_totalA + $PPN + $MAT;
        echo "TOTAL_ALL: $TOTAL_ALL<br>";

        // 11. Final Array
        $DATA_HDR_BH = array();
        $DATA_HDR_BH['BIAYA_ADMIN'] = $BA;
        $DATA_HDR_BH['BIAYA_MATERAI'] = $MAT;
        $DATA_HDR_BH['SUBTOTAL'] = $sub_total1;
        $DATA_HDR_BH['PPN'] = $PPN;
        $DATA_HDR_BH['SEAL'] = $seal;
        $DATA_HDR_BH['TOTAL_JUMLAH'] = $TOTAL_ALL;

        echo "<pre>";
        print_r($DATA_HDR_BH);
        echo "</pre>";
    }

    public function cektarifdelivery()
    {
        $this->load->view('content/dashboard/cektarifdelivery');
    }

    public function cek_ondemand()
    {
        $id = isset($_GET['Container']) ? $_GET['Container'] : null;

        if (!$id) {
            echo "<p>Error: Container is required.</p>";
            return;
        }

        // Melakukan query menggunakan Active Record CI2
        $this->db->select('NO_CONT, REF_NUMBER');
        $this->db->from('t_request_cont');
        $this->db->where('NO_CONT', $id);
        $this->db->where('REF_NUMBER IS NOT NULL', null, false); // false agar CI tidak membungkusnya dengan backtick
        $this->db->order_by('ID', 'DESC');
        $this->db->limit(1);

        $query = $this->db->get();
        $KdAPRF = 'GETINQUIRY';
        $KD_ORG_SENDER = '0';
        $KD_ORG_RECEIVER = '0';
        $url = "https://api.npct1.co.id:9443/api/v1/getGatePassData";
        $user = "BEHANDLE";
        $key = "5d3a2ffcb778f4b1c224f2447c048c8f";

        // Cek apakah data ditemukan
        if ($query->num_rows() > 0) {
            $row = $query->row();

            // Contoh menampilkan data
            echo "Container: " . $row->NO_CONT . "<br>";
            echo "Ref Number: " . $row->REF_NUMBER;

            // Kamu bisa return datanya jika dibutuhkan
            $xml = '<request><reff_number>' . $row->REF_NUMBER . '</reff_number></request>';
            $xmlrequest = $xml;
            // var_dump($xml);die();
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
                CURLOPT_POSTFIELDS => $xml,
                CURLOPT_HTTPHEADER => array(
                    'User-ID: ' . $user,
                    'NPCT-API-Key: ' . $key,
                    'Content-Type: application/xml'
                ),
            ));
            $response = curl_exec($curl);
            if (!curl_errno($curl)) {
                $info = curl_getinfo($curl);
                echo "Connection Success , This is Url : ", $info['url'], "\r\n";
            } else {
                echo "Connection Failed =" . curl_error($curl);
            }
            curl_close($curl);
            // 1. Format XML menggunakan fungsi yang sudah kamu buat
            $formattedXml = $this->formatXml($response);

            // 2. Tampilkan ke browser agar tidak "mentah"
            echo "<h3>Formatted RAW XML Response:</h3>";
            echo "<pre style='background: #272822; color: #f8f8f2; padding: 15px; border-radius: 5px; overflow: auto;'>";
            // htmlspecialchars penting agar tag < > tidak dieksekusi sebagai HTML oleh browser
            echo htmlspecialchars($formattedXml);
            echo "</pre>";
            die();
        } else {
            echo "Data tidak ditemukan.";
        }
    }


    /**
     * Formats an XML string to be pretty-printed.
     *
     * @param string $xml
     * @return string
     */
    private function formatXml($xml)
    {
        // Load the XML into a DOMDocument
        $dom = new DOMDocument('1.0', 'UTF-8');
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = true;

        // Suppress errors in case the XML is malformed
        if ($dom->loadXML($xml)) {
            return $dom->saveXML();
        } else {
            // Return the original string if it cannot be parsed as XML
            return $xml;
        }
    }
}
