<?php defined('BASEPATH') or exit('No direct script access allowed');

class ServiceNpct1NewIntegrasi extends CI_Controller
{
    public $content;
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_home');
    }
    public function parsedate($x)
    {
        if (strlen($x) < 9) {
            if (strlen($x) == 0) {
                return $x;
            }
            return substr_replace(substr_replace($x, "-", 4, 0), "-", 7, 0);
        } else
            return substr_replace(substr_replace(substr_replace(substr_replace(substr_replace($x, "-", 4, 0), "-", 7, 0), " ", 10, 0), ":", 13, 0), ":", 16, 0);
    }
    public function tipekont($x)
    {
        if ($x == 'Y') {
            return 'RFR';
        } else
            return 'DRY';
    }
    public function getcoarri()
    {
        $start = date("YmdHis", strtotime("-6 hour", strtotime("now")));
        $end = date("YmdHis");
        echo $start . "<br>";
        echo $end;
        $url    = "https://api.npct1.co.id:9443/api/v1/get-coarri";
        $user   = "BEHANDLE";
        $key    = "5d3a2ffcb778f4b1c224f2447c048c8f";
        $addXML = '<request>
                        <start>' . $start . '</start>
                        <end>' . $end . '</end>
                    </request>

                ';
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
            echo "Connection Success , This is Url : ", $info['url'], "\r\n";
        } else {
            echo "Connection Failed =" . curl_error($curl);
        }
        curl_close($curl);
        $xml1 = str_replace('xmlns="cococont.xsd">', ">", $response);
        $xml2 = str_replace('</DOCUMENT">', "</DOCUMENT>", $xml1);

        $xml = simplexml_load_string($xml2);

        foreach ($xml->DOCUMENT->COCOCONT as $hdrdata) {
            foreach ($hdrdata->DETIL->CONT as $contdata) {
                $KD_DOK = $hdrdata->HEADER->KD_DOK;
                $KD_TPS = $hdrdata->HEADER->KD_TPS;
                $NM_ANGKUT = $hdrdata->HEADER->NM_ANGKUT;
                $NO_VOY_FLIGHT = $hdrdata->HEADER->NO_VOY_FLIGHT;
                $CALL_SIGN = $hdrdata->HEADER->CALL_SIGN;;
                $TGL_TIBA = $this->parsedate($hdrdata->HEADER->TGL_TIBA);
                $KD_GUDANG = $hdrdata->HEADER->KD_GUDANG;
                $REF_NUMBER = $hdrdata->HEADER->REF_NUMBER;
                $NO_CONT = $contdata->NO_CONT;
                $UK_CONT = $contdata->UK_CONT;
                $NO_SEGEL = $contdata->NO_SEGEL;
                $JNS_CONT = $contdata->JNS_CONT;
                $NO_BL_AWB = $contdata->NO_BL_AWB;
                $TGL_BL_AWB = $this->parsedate($contdata->TGL_BL_AWB);
                $NO_MASTER_BL_AWB = $contdata->NO_MASTER_BL_AWB;
                $TGL_MASTER_BL_AWB = $this->parsedate($contdata->TGL_MASTER_BL_AWB);
                $ID_CONSIGNEE = $contdata->ID_CONSIGNEE;
                $CONSIGNEE = $contdata->CONSIGNEE;
                $BRUTO = $contdata->BRUTO;
                $NO_BC11 = $contdata->NO_BC11;
                $TGL_BC11 = $this->parsedate($contdata->TGL_BC11);
                $NO_POS_BC11 = $contdata->NO_POS_BC11;
                $KD_TIMBUN = $contdata->KD_TIMBUN;
                $KD_DOK_INOUT = $contdata->KD_DOK_INOUT;
                $NO_DOK_INOUT = $contdata->NO_DOK_INOUT;
                $TGL_DOK_INOUT = $this->parsedate($contdata->TGL_DOK_INOUT);
                $WK_INOUT = $this->parsedate($contdata->WK_INOUT);
                $WK_EXE = $this->parsedate($contdata->WK_EXE);
                $KD_SAR_ANGKUT_INOUT = $contdata->KD_SAR_ANGKUT_INOUT;
                $NO_POL = $contdata->NO_POL;
                $FL_CONT_KOSONG = $contdata->FL_CONT_KOSONG;
                $ISO_CODE = $contdata->ISO_CODE;
                $PEL_MUAT = $contdata->PEL_MUAT;
                $PEL_TRANSIT = $contdata->PEL_TRANSIT;
                $PEL_BONGKAR = $contdata->PEL_BONGKAR;
                $GUDANG_TUJUAN = $contdata->GUDANG_TUJUAN;
                $KODE_KANTOR = $contdata->KODE_KANTOR;
                $NO_DAFTAR_PABEAN = $contdata->NO_DAFTAR_PABEAN;
                $TGL_DAFTAR_PABEAN = $this->parsedate($contdata->TGL_DAFTAR_PABEAN);
                $NO_SEGEL_BC = $contdata->NO_SEGEL_BC;
                $TGL_SEGEL_BC = $this->parsedate($contdata->TGL_SEGEL_BC);
                $NO_IJIN_TPS = $contdata->NO_IJIN_TPS;
                $TGL_IJIN_TPS = $this->parsedate($contdata->TGL_IJIN_TPS);
                $KD_CONT_TYPE = $this->tipekont($contdata->REEFER);
                $OOG = $contdata->OOG;
                $IMDG = $contdata->IMDG;
                $WK_REKAM = date("Y-m-d H:i:s");

                // INSERT TO COCOSTHDR/COCOSTCONT
                // check data ada di cocosthdr
                $query = $this->db->query("SELECT * from t_cocostshdr where CALL_SIGN = '$CALL_SIGN' and NM_ANGKUT = '$NM_ANGKUT' and NO_VOY_FLIGHT = '$NO_VOY_FLIGHT'");
                $count = $query->num_rows();
                if ($count === 0) {
                    echo $NO_VOY_FLIGHT . " + " . $CALL_SIGN . "belum ada \r\n";
                    $this->db->query("INSERT INTO t_cocostshdr (KD_ASAL_BRG, KD_TPS, KD_GUDANG, CALL_SIGN, NM_ANGKUT, NO_VOY_FLIGHT, TGL_TIBA, WK_REKAM) VALUES ('$KD_DOK', '$KD_TPS', '$KD_GUDANG', '$CALL_SIGN', '$NM_ANGKUT', '$NO_VOY_FLIGHT', '$TGL_TIBA', NOW())");
                    $insert_id = $this->db->insert_id();

                    echo  "selanjutnya insert ke cocostcont pake id = " . $insert_id . "\r\n";
                    $query = $this->db->query("INSERT INTO t_cocostscont
                                    (ID, NO_CONT, UK_CONT, JNS_CONT, ISO_CODE, TEMPERATURE, KD_CONT_TIPE, BRUTO, NO_SEGEL, NO_BL_AWB, TGL_BL_AWB, NO_MASTER_BL_AWB, TGL_MASTER_BL_AWB, NO_BC11, TGL_BC11, NO_POS_BC11, ID_CONSIGNEE, CONSIGNEE, KD_TIMBUN, PEL_MUAT, PEL_TRANSIT, PEL_BONGKAR, KD_DOK_IN, NO_DOK_IN, TGL_DOK_IN, WK_IN, FL_CONT_KOSONG_IN, KD_SARANA_ANGKUT_IN, NO_POL_IN, GUDANG_TUJUAN_IN, NO_DAFTAR_PABEAN_IN, TGL_DAFTAR_PABEAN_IN, NO_SEGEL_BC_IN, TGL_SEGEL_BC_IN, NO_IJIN_TPS_IN, TGL_IJIN_TPS_IN, KODE_KANTOR_IN, KD_DOK_OUT, NO_DOK_OUT, TGL_DOK_OUT, WK_OUT, FL_CONT_KOSONG_OUT, KD_SARANA_ANGKUT_OUT, NO_POL_OUT, GUDANG_TUJUAN_OUT, NO_DAFTAR_PABEAN_OUT, TGL_DAFTAR_PABEAN_OUT, NO_SEGEL_BC_OUT, TGL_SEGEL_BC_OUT, NO_IJIN_TPS_OUT, TGL_IJIN_TPS_OUT, KODE_KANTOR_OUT, WK_REKAM, FL_BILLING)
                                    VALUES($insert_id, '$NO_CONT', '$UK_CONT', '$JNS_CONT', '$ISO_CODE', NULL, '$KD_CONT_TYPE', '$BRUTO', '$NO_SEGEL', '$NO_BL_AWB', '$TGL_BL_AWB', NULL, NULL, '$NO_BC11', '$TGL_BC11', '$NO_POS_BC11', '$ID_CONSIGNEE', '$CONSIGNEE', '$KD_TIMBUN', '$PEL_MUAT', '$PEL_TRANSIT', '$PEL_BONGKAR', NULL, NULL, NULL, '$WK_INOUT', '$FL_CONT_KOSONG', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '040300', NULL, NULL, NULL, NULL, '$FL_CONT_KOSONG', '$KD_SARANA_ANGKUT_OUT', '$NO_POL', '$GUDANG_TUJUAN', '$NO_DAFTAR_PABEAN', '$TGL_DAFTAR_PABEAN', '$NO_SEGEL_BC', '$TGL_SEGEL_BC', '$NO_IJIN_TPS', '$TGL_IJIN_TPS', '$KODE_KANTOR', '$WK_REKAM', 'N');
                                    ");
                } else {
                    $q = $this->db->query("SELECT * from t_cocostshdr where CALL_SIGN = '$CALL_SIGN' and NM_ANGKUT = '$NM_ANGKUT' and NO_VOY_FLIGHT = '$NO_VOY_FLIGHT'");
                    foreach ($q->result() as $key => $value1) {
                        $cocosthdrid = $value1->ID;
                        //cek dulu sudah ada di cocostcont
                        $query = $this->db->query("SELECT * from t_cocostshdr dc join t_cocostscont dc2 on dc.ID = dc2.ID where dc.NM_ANGKUT = '$NM_ANGKUT' and dc.NO_VOY_FLIGHT = '$NO_VOY_FLIGHT' and dc.CALL_SIGN  = '$CALL_SIGN' and dc2.NO_CONT = '$NO_CONT'");
                        $count = $query->num_rows();
                        // insert or update ke cocostcont
                        echo "proses insert/update cocostcont id = " . $cocosthdrid . " dan kontainer = " . $NO_CONT . "\r\n";

                        $query = $this->db->query("
                                        INSERT INTO t_cocostscont (
                                            ID, NO_CONT, UK_CONT, JNS_CONT, ISO_CODE, TEMPERATURE, KD_CONT_TIPE, BRUTO, NO_SEGEL, 
                                            NO_BL_AWB, TGL_BL_AWB, NO_MASTER_BL_AWB, TGL_MASTER_BL_AWB, NO_BC11, TGL_BC11, NO_POS_BC11, 
                                            ID_CONSIGNEE, CONSIGNEE, KD_TIMBUN, PEL_MUAT, PEL_TRANSIT, PEL_BONGKAR, KD_DOK_IN, NO_DOK_IN, 
                                            TGL_DOK_IN, WK_IN, FL_CONT_KOSONG_IN, KD_SARANA_ANGKUT_IN, NO_POL_IN, GUDANG_TUJUAN_IN, 
                                            NO_DAFTAR_PABEAN_IN, TGL_DAFTAR_PABEAN_IN, NO_SEGEL_BC_IN, TGL_SEGEL_BC_IN, NO_IJIN_TPS_IN, 
                                            TGL_IJIN_TPS_IN, KODE_KANTOR_IN, KD_DOK_OUT, NO_DOK_OUT, TGL_DOK_OUT, WK_OUT, FL_CONT_KOSONG_OUT, 
                                            KD_SARANA_ANGKUT_OUT, NO_POL_OUT, GUDANG_TUJUAN_OUT, NO_DAFTAR_PABEAN_OUT, TGL_DAFTAR_PABEAN_OUT, 
                                            NO_SEGEL_BC_OUT, TGL_SEGEL_BC_OUT, NO_IJIN_TPS_OUT, TGL_IJIN_TPS_OUT, KODE_KANTOR_OUT, WK_REKAM, FL_BILLING
                                        )
                                        VALUES (
                                            $cocosthdrid, '$NO_CONT', '$UK_CONT', '$JNS_CONT', '$ISO_CODE', NULL, '$KD_CONT_TYPE', '$BRUTO', '$NO_SEGEL',
                                            '$NO_BL_AWB', '$TGL_BL_AWB', NULL, NULL, '$NO_BC11', '$TGL_BC11', '$NO_POS_BC11',
                                            '$ID_CONSIGNEE', '$CONSIGNEE', '$KD_TIMBUN', '$PEL_MUAT', '$PEL_TRANSIT', '$PEL_BONGKAR',
                                            NULL, NULL, NULL, '$WK_INOUT', '$FL_CONT_KOSONG', NULL, NULL, NULL,
                                            NULL, NULL, NULL, NULL, NULL, NULL, '040300', NULL, NULL, NULL, NULL,
                                            '$FL_CONT_KOSONG', '$KD_SARANA_ANGKUT_OUT', '$NO_POL', '$GUDANG_TUJUAN', '$NO_DAFTAR_PABEAN', '$TGL_DAFTAR_PABEAN',
                                            '$NO_SEGEL_BC', '$TGL_SEGEL_BC', '$NO_IJIN_TPS', '$TGL_IJIN_TPS', '$KODE_KANTOR', '$WK_REKAM', 'N'
                                        )
                                        ON DUPLICATE KEY UPDATE 
                                            UK_CONT = VALUES(UK_CONT),
                                            JNS_CONT = VALUES(JNS_CONT)
                                    ");

                        // tampilkan hasil
                        if ($this->db->affected_rows() > 1) {
                            echo "insert baru untuk kontainer $NO_CONT\r\n";
                        } else {
                            echo "update data kontainer $NO_CONT\r\n";
                        }
                    }
                }
            }
        }
    }
    public function gantiformattglgblk($tgl)
    {
        $date = date_create_from_format("m/d/Y", $tgl);
        $date1 = date_format($date, "Y-m-d");
        return $date1;
    }
    public function getcustdoc()
    {
        $start = date("YmdHis", strtotime("-60 minutes", strtotime("now")));
        $end = date("YmdHis");
        // echo $start."<br>";
        // echo $end;
        $url    = "https://api.npct1.co.id:9443/api/v1/get-custdoc";
        $user   = "BEHANDLE";
        $key    = "5d3a2ffcb778f4b1c224f2447c048c8f";
        $addXML = '<request>
                        <start>' . $start . '</start>
                        <end>' . $end . '</end>
        </request>';
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
            // echo "Connection Success , This is Url : ", $info['url'], "\r\n";
        } else {
            echo "Connection Failed =" . curl_error($curl);
        }
        curl_close($curl);
        $xml1 = str_replace('<?xml version="1.0"?>', "", $response);
        $xml = simplexml_load_string($xml1);
        header("Content-Type: application/xml; charset=UTF-8");
        // echo $response;
        // die();

        foreach ($xml->DOCUMENTS->DOCUMENT as $docdata) {
            // ========================
            // CASE SPPB
            // ========================
            if (isset($docdata->SPPB)) {
                foreach ($docdata->SPPB->DETIL->CONT as $contdata) {
                    $CAR = $docdata->SPPB->HEADER->CAR;
                    $NO_SPPB = $docdata->SPPB->HEADER->NO_SPPB;
                    $TGL_SPPB = $this->gantiformattglgblk($docdata->SPPB->HEADER->TGL_SPPB);
                    $KD_KPBC = $docdata->SPPB->HEADER->KD_KPBC;
                    $NO_PIB = $docdata->SPPB->HEADER->NO_PIB;
                    $TGL_PIB = $this->gantiformattglgblk($docdata->SPPB->HEADER->TGL_PIB);
                    $NPWP_IMP = $docdata->SPPB->HEADER->NPWP_IMP;
                    $NAMA_IMP = $docdata->SPPB->HEADER->NAMA_IMP;
                    $ALAMAT_IMP = $docdata->SPPB->HEADER->ALAMAT_IMP;
                    $NPWP_PPJK = $docdata->SPPB->HEADER->NPWP_PPJK;
                    $NAMA_PPJK = $docdata->SPPB->HEADER->NAMA_PPJK;
                    $ALAMAT_PPJK = $docdata->SPPB->HEADER->ALAMAT_PPJK;
                    $NM_ANGKUT = $docdata->SPPB->HEADER->NM_ANGKUT;
                    $NO_VOY_FLIGHT = $docdata->SPPB->HEADER->NO_VOY_FLIGHT;
                    $BRUTO = $docdata->SPPB->HEADER->BRUTO;
                    $NETTO = $docdata->SPPB->HEADER->NETTO;
                    $GUDANG = $docdata->SPPB->HEADER->GUDANG;
                    $STATUS_JALUR = $docdata->SPPB->HEADER->STATUS_JALUR;
                    $JML_CONT = $docdata->SPPB->HEADER->JML_CONT;
                    $NO_BC11 = $docdata->SPPB->HEADER->NO_BC11;
                    $TGL_BC11 = $this->gantiformattglgblk($docdata->SPPB->HEADER->TGL_BC11);
                    $NO_POS_BC11 = $docdata->SPPB->HEADER->NO_POS_BC11;
                    $NO_BL_AWB = $docdata->SPPB->HEADER->NO_BL_AWB;
                    $TG_BL_AWB = $this->gantiformattglgblk($docdata->SPPB->HEADER->TG_BL_AWB);
                    $NO_MASTER_BL_AWB = $docdata->SPPB->HEADER->NO_MASTER_BL_AWB;
                    $TG_MASTER_BL_AWB = $this->gantiformattglgblk($docdata->SPPB->HEADER->TG_MASTER_BL_AWB);
                    $NO_CONT = $contdata->NO_CONT;
                    $SIZE = $contdata->SIZE;
                    $JNS_MUAT = $contdata->JNS_MUAT;
                    $datenow = date("Y-m-d H:i:s");

                    echo "Insert kontainer $NO_CONT ke SPPB $NO_SPPB\r\n";
                    //check document udah ada pa belom di permit
                    $query = $this->db->query("SELECT * from t_permit_hdr where NO_DOK_INOUT = '$NO_SPPB' and TGL_DOK_INOUT = '$TGL_SPPB'");
                    $count = $query->num_rows();
                    if ($count === 0) {
                        $this->db->query("INSERT INTO t_permit_hdr (CAR, KD_KANTOR, KD_DOK_INOUT, NO_DOK_INOUT, TGL_DOK_INOUT, NO_DAFTAR_PABEAN, TGL_DAFTAR_PABEAN, ID_CONSIGNEE, CONSIGNEE, ALAMAT_CONSIGNEE, NPWP_PPJK, NAMA_PPJK, ALAMAT_PPJK, NM_ANGKUT, NO_VOY_FLIGHT, KD_GUDANG, JML_CONT, BRUTO, NETTO, NO_BC11, TGL_BC11, NO_POS_BC11, NO_BL_AWB, TGL_BL_AWB, NO_MASTER_BL_AWB, TGL_MASTER_BL_AWB, KD_KANTOR_PENGAWAS, KD_KANTOR_BONGKAR, FL_SEGEL, STATUS_JALUR, FL_KARANTINA, KD_STATUS, TGL_STATUS, FL_BAPLIE, BAPLIE_DATE, ANGKUTKODE_TPS, ANGKUTNAMA_TPS, ANGKUTNO_TPS, TMP_TIMBUN_TPS, STATUS, STATUS_MAIL, KD_STATUS_BIL, WK_STATUS, FL_MANUAL, OPERATOR, FL_MIGRASI, FL_NHI, FL_LNSW, LNSW_KD_RESPON, LNSW_IDLOG, LNSW_NOAJU, LNSW_TGLAJU)
                            VALUES ('$CAR', '$KD_KPBC', '1', '$NO_SPPB', '$TGL_SPPB', '$NO_PIB', '$TGL_PIB', '$NPWP_IMP', '$NAMA_IMP', '$ALAMAT_IMP', '$NPWP_PPJK', '$NAMA_PPJK', '$ALAMAT_PPJK', '$NM_ANGKUT', '$NO_VOY_FLIGHT', '$GUDANG', '$JML_CONT', '$BRUTO', '$NETTO', '$NO_BC11', '$TGL_BC11', '$NO_POS_BC11', '$NO_BL_AWB', '$TG_BL_AWB', '$NO_MASTER_BL_AWB', '$TG_MASTER_BL_AWB', NULL, NULL, NULL, '$STATUS_JALUR', NULL, '100', '$datenow', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL)");
                        $insert_id = $this->db->insert_id();
                        //insert ke permit cont
                        $this->db->query("INSERT into t_permit_cont (ID, NO_CONT, KD_CONT_UKURAN, KD_CONT_JENIS, TGL_STATUS) values ('$insert_id', '$NO_CONT', '$SIZE', '$JNS_MUAT', '$datenow')");
                    } else {
                        $q = $this->db->query("SELECT * from t_permit_hdr where NO_DOK_INOUT = '$NO_SPPB' and TGL_DOK_INOUT = '$TGL_SPPB'");
                        foreach ($q->result() as $key => $value1) {
                            $permitid = $value1->ID;
                            echo 'insert pake id = ' . $permitid;
                            // cek sudah ada data kontainer biar gak duplikat
                            $query = $this->db->query("SELECT * from t_permit_cont where ID = '$permitid' and NO_CONT = '$NO_CONT'");
                            $count = $query->num_rows();
                            if ($count === 0) {
                                $this->db->query("INSERT IGNORE into t_permit_cont (ID, NO_CONT, KD_CONT_UKURAN, KD_CONT_JENIS, TGL_STATUS) values ('$permitid', '$NO_CONT', '$SIZE', '$JNS_MUAT', '$datenow')");
                            } else {
                                echo 'data dah ada.<br>';
                            }
                        }
                    }
                }
            }

            // ========================
            // CASE SPJM
            // ========================
            if (isset($docdata->SPJM)) {
                $CAR = (string) $docdata->SPJM->HEADER->CAR;
                $KD_KANTOR = (string) $docdata->SPJM->HEADER->KD_KANTOR;
                $NO_PIB = (string) $docdata->SPJM->HEADER->NO_PIB;
                $TGL_PIB = date('Y-m-d', strtotime(str_replace('/', '-', (string) $docdata->SPJM->HEADER->TGL_PIB)));
                $NPWP_IMP = (string) $docdata->SPJM->HEADER->NPWP_IMP;
                $NAMA_IMP = (string) $docdata->SPJM->HEADER->NAMA_IMP;
                $NPWP_PPJK = (string) $docdata->SPJM->HEADER->NPWP_PPJK;
                $NAMA_PPJK = (string) $docdata->SPJM->HEADER->NAMA_PPJK;
                $GUDANG = (string) $docdata->SPJM->HEADER->GUDANG;
                $JML_CONT = (string) $docdata->SPJM->HEADER->JML_CONT;
                $NO_BC11 = (string) $docdata->SPJM->HEADER->NO_BC11;
                $TGL_BC11 = date('Y-m-d', strtotime(str_replace('/', '-', (string) $docdata->SPJM->HEADER->TGL_BC11)));
                $NO_POS_BC11 = (string) $docdata->SPJM->HEADER->NO_POS_BC11;
                $FL_KARANTINA = (string) $docdata->SPJM->HEADER->FL_KARANTINA;
                $NM_ANGKUT = (string) $docdata->SPJM->HEADER->NM_ANGKUT;
                $NO_VOY = (string) $docdata->SPJM->HEADER->NO_VOY_FLIGHT;
                $TGL_SPJM = (string) $docdata->SPJM->HEADER->TGL_SPJM;

                $datenow = date("Y-m-d H:i:s");

                echo "Insert SPJM No PIB $NO_PIB\r\n";

                // check document udah ada pa belom di permit
                $query = $this->db->query("SELECT * FROM t_permit_hdr WHERE NO_DOK_INOUT = '$NO_PIB' AND TGL_DOK_INOUT = '$TGL_PIB'");
                $count = $query->num_rows();

                if ($count === 0) {
                    // insert header baru
                    $this->db->query("INSERT INTO t_permit_hdr 
                        (CAR, KD_KANTOR, KD_DOK_INOUT, NO_DOK_INOUT, TGL_DOK_INOUT, 
                        NO_DAFTAR_PABEAN, TGL_DAFTAR_PABEAN, ID_CONSIGNEE, CONSIGNEE, 
                        NPWP_PPJK, NAMA_PPJK, KD_GUDANG, JML_CONT, NO_BC11, TGL_BC11, 
                        NO_POS_BC11, FL_KARANTINA, NM_ANGKUT, NO_VOY_FLIGHT, KD_STATUS, TGL_STATUS) 
                    VALUES 
                        ('$CAR', '$KD_KANTOR', '19', '$NO_PIB', '$TGL_PIB', 
                        '$NO_PIB', '$TGL_PIB', '$NPWP_IMP', '$NAMA_IMP', 
                        '$NPWP_PPJK', '$NAMA_PPJK', '$GUDANG', '$JML_CONT', '$NO_BC11', '$TGL_BC11', 
                        '$NO_POS_BC11', '$FL_KARANTINA', '$NM_ANGKUT', '$NO_VOY', '100', '$datenow')");

                    $insert_id = $this->db->insert_id();
                } else {
                    // sudah ada → ambil ID
                    $row = $query->row();
                    $insert_id = $row->ID;
                    echo "Insert pakai ID = $insert_id\r\n";
                }

                // loop kontainer SPJM
                foreach ($docdata->SPJM->DETIL->CONT as $contdata) {
                    $NO_CONT = (string) $contdata->NO_CONT;
                    $SIZE = (string) $contdata->SIZE;
                    $FL_PERIKSA = (string) $contdata->FL_PERIKSA;

                    // cek apakah kontainer sudah ada
                    $q = $this->db->query("SELECT * FROM t_permit_cont WHERE ID = '$insert_id' AND NO_CONT = '$NO_CONT'");
                    if ($q->num_rows() == 0) {
                        $this->db->query("INSERT INTO t_permit_cont 
                            (ID, NO_CONT, KD_CONT_UKURAN, FL_PERIKSA, TGL_STATUS) 
                            VALUES 
                            ('$insert_id', '$NO_CONT', '$SIZE', '$FL_PERIKSA', '$datenow')");
                        echo "Insert kontainer $NO_CONT ke SPJM $NO_PIB\r\n";
                    } else {
                        echo "Data kontainer $NO_CONT sudah ada.\r\n";
                    }
                }
            }
        }
    }
    public function getssm()
    {
        $start = date("YmdHis", strtotime("-720 minutes", strtotime("now")));
        $end = date("YmdHis");
        $url    = "https://api.npct1.co.id:9443/api/v1/get-ssm";
        $user   = "BEHANDLE";
        $key    = "5d3a2ffcb778f4b1c224f2447c048c8f";
        $addXML = '<request>
                        <start>' . $start . '</start>
                        <end>' . $end . '</end>
        </request>';
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
            echo "Connection Success , This is Url : ", $info['url'], "\r\n";
        } else {
            echo "Connection Failed =" . curl_error($curl);
        }
        curl_close($curl);
        // echo $response;
        $xml1 = str_replace('<?xml version="1.0" encoding="UTF-8" standalone="yes"?>', "", $response);
        $xml = simplexml_load_string($xml1);
        $datenow = date("Y-m-d H:i:s");
        foreach ($xml->DOCUMENTS->GETCONTAINERPERIKSA as $hdrdata) {
            $ngok = $hdrdata->asXML();;
            // var_dump($ngok);
            echo $ngok;
            // $ngek = (string)$ngok;
            // echo $ngek;
            $this->db->query("INSERT IGNORE into t_log_lnsw (typelog, raw_request, raw_respon, rekondata, tgl_get) values ('ssm', '$addXML', '$ngok', 'N', '$datenow')");
        }
        // $ngok = $xml->DOCUMENTS->GETCONTAINERPERIKSA->LOOP->KODE_RESPONSE;
        // var_dump($ngok);
    }
    public function ondemand()
    {
        $nosppb = $this->input->post('nodok');
        $tglsppb = $this->input->post('tgldok');
        $npwpsppb = $this->input->post('npwp');

        $url    = "https://api.npct1.co.id:9443/api/v1/get-ondemand";
        $user   = "BEHANDLE";
        $key    = "5d3a2ffcb778f4b1c224f2447c048c8f";
        $addXML = '<request>
                <document_code>1</document_code>
                <document_no>' . $nosppb . '</document_no>
                <document_date>' . $tglsppb . '</document_date>
                <npwp>' . $npwpsppb . '</npwp>
                </request>';
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
        }
        curl_close($curl);
        $xml1 = str_replace('<?xml version="1.0"?>', "", $response);

        $xml = simplexml_load_string($xml1);
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
        $datenow = date("Y-m-d H:i:s");

        $responget = 'success';

        if (strpos($response, 'Data tidak ditemukan') !== false) {
            $responget = 'data tidak ditemukan';
        };

        if ($responget == 'data tidak ditemukan') {
            // return $this->httpres(200, 'error', '', 'Dokumen Tidak Di temukan gan');
            return header('X-PHP-Response-Code: 404', true, 404);
            echo 'penis';
        }


        if ($responget !== 'data tidak ditemukan') {
            $query = $this->db->query("SELECT * from dum_permit_hdr where NO_DOK_INOUT = '$NO_SPPB' and TGL_DOK_INOUT = '$TGL_SPPB'");
            $count = $query->num_rows();
            if ($count === 0) {
                $this->db->query("INSERT INTO dum_permit_hdr (CAR, NO_DOK_INOUT, KD_DOK_INOUT, TGL_DOK_INOUT, KD_KANTOR, NO_DAFTAR_PABEAN, TGL_DAFTAR_PABEAN, ID_CONSIGNEE, CONSIGNEE, ALAMAT_CONSIGNEE, NPWP_PPJK, NAMA_PPJK, ALAMAT_PPJK, NM_ANGKUT, NO_VOY_FLIGHT, BRUTO, NETTO, KD_GUDANG, STATUS_JALUR, JML_CONT, NO_BC11, TGL_BC11, NO_POS_BC11, NO_BL_AWB, TGL_BL_AWB, NO_MASTER_BL_AWB, TGL_MASTER_BL_AWB)
                        VALUES ('$CAR', '$NO_SPPB', '1','$TGL_SPPB', '$KD_KPBC', '$NO_PIB', '$TGL_PIB', '$NPWP_IMP', '$NAMA_IMP', '$ALAMAT_IMP', '$NPWP_PPJK', '$NAMA_PPJK', '$ALAMAT_PPJK', '$NM_ANGKUT', '$NO_VOY_FLIGHT', '$BRUTO', '$NETTO', '$GUDANG', '$STATUS_JALUR', '$JML_CONT', '$NO_BC11', '$TGL_BC11', '$NO_POS_BC11', '$NO_BL_AWB', '$TG_BL_AWB', '$NO_MASTER_BL_AWB', '$TG_MASTER_BL_AWB')");
                $insert_id = $this->db->insert_id();

                foreach ($xml->DOCUMENT->SPPB->DETIL->CONT as $contdata) {
                    $ID = $contdata->ID;
                    $NO_CONT = $contdata->NO_CONT;
                    $SIZE = $contdata->SIZE;
                    $JNS_MUAT = $contdata->JNS_MUAT;
                    $this->db->query("INSERT IGNORE INTO dum_permit_cont (ID, NO_CONT, KD_CONT_UKURAN, KD_CONT_JENIS, TGL_STATUS)
                                VALUES ('$insert_id', '$NO_CONT', '$SIZE', '$JNS_MUAT', '$datenow')");
                }
            } else {
                echo 'akwokwok';
            }
        }
        // $this->db->query("INSERT INTO `tpk_ipc`.`solver_req_dokumen_log` (`url`, `tipe`, `no_dok`, `tgl_dok`, `npwp`, `data_respons`) VALUES ('https://api.npct1.co.id:9443/api/v1/get-ondemand', '$type', '$no_dok', '$tgl_dok', '$npwp', '$responget')");
    }
    public function msgsixbeta()
    {
        header('Content-Type: application/xml');
        $q = $this->db->query("SELECT ts.NO_SPK, tc.NM_ANGKUT, tc.NO_VOY_FLIGHT, tc.CALL_SIGN, ts.JNS_DOK as 'JNSDOKIN', tg.NO_CONT, tr.VOY_IN, ts.NO_DOK as 'DOKIN', DATE_FORMAT(ts.TGL_DOK, '%Y%m%d%H%i%s') as 'TGDOKIN',
            DATE_FORMAT(rb.PRN_BEHANDLE_IN, '%Y%m%d%H%i%s') as 'BEHADNLE_IN',
            DATE_FORMAT(rb.PRN_BEHANDLE_IN, '%Y%m%d%H%i%s') as 'STACKING_BEFORE',
            DATE_FORMAT(ppk.WK_RESPON, '%Y%m%d%H%i%s') as 'RESPON_PPK',
            DATE_FORMAT(tob.W_BEHANDLE, '%Y%m%d%H%i%s') as 'WK_BEHANDLE',
            DATE_FORMAT(rb.PB1_START_PERIKSA, '%Y%m%d%H%i%s') as 'START_INSPECTION',
            DATE_FORMAT(rb.PB2_FINISH_PERIKSA, '%Y%m%d%H%i%s') as 'FINISH_INSPECTION',
            DATE_FORMAT(rb.PB2_MARSHALLING_EX_B2, '%Y%m%d%H%i%s') as 'MARSHALLING_EX_B1',
            DATE_FORMAT(tg.WK_REK, '%Y%m%d%H%i%s') as 'GATEPASS',
            DATE_FORMAT(tod.WK_GATEOUT, '%Y%m%d%H%i%s') as 'WK_GATEOUT',
            DATE_FORMAT(tc.TGL_TIBA, '%Y%m%d') as 'TGL_TIBA', tr.REF_NUMBER,
            tph.KD_DOK_INOUT as 'JNSDOKOUT', tg.NO_DOK, DATE_FORMAT(tg.TGL_DOK, '%Y%m%d') as 'TGDOKOUT'
            from t_spk ts join t_gatepass tg on ts.NO_SPK = tg.NO_SPK
            join (select tr.NO_DOK, trc.NO_CONT, trc.VESSEL, trc.CALL_SIGN, trc.VOY_IN, trc.UKR_CONT, trc.KD_CONT_JENIS, trc.REF_NUMBER, trc.BRUTO, trc.ISO_CODE from t_request tr join t_request_cont trc on tr.ID = trc.ID)    
            tr on tr.NO_DOK = ts.NO_DOK and tr.NO_CONT = tg.NO_CONT
            join t_cocostshdr tc on tr.VESSEL = tc.NM_ANGKUT and tr.VOY_IN = tc.NO_VOY_FLIGHT
            join t_cocostscont tc2 on tc.ID = tc2.ID and tg.NO_CONT = tc2.NO_CONT
            join t_op_delivery tod on tg.NO_SPK = tod.NO_SPK and tg.NO_CONT = tod.NO_CONT
            join t_permit_hdr tph on tg.NO_DOK = tph.NO_DOK_INOUT
            join t_gatepass ppk on ts.NO_DOK = ppk.NO_DOK and ts.TGL_DOK = ppk.TGL_DOK and tg.NO_CONT = ppk.NO_CONT
            join t_op_behandlein tob on tob.NO_SPK = ts.NO_SPK and tob.NO_CONT = tg.NO_CONT
            join report_behandle rb on ts.NO_SPK = rb.RB1_NO_SPK and rb.NO_CONT = tg.NO_CONT 
            where tg.WK_REK > '2022-09-24' and tg.JNS_KEGIATAN = '3'
            and tod.WK_GATEOUT is not null limit 20");
        foreach ($q->result() as $key => $value1) {
            $cdata = '<request>
                            <containers>
                                <reff_number>' . $value1->REF_NUMBER . '</reff_number>
                                <vessel_name>' . $value1->NM_ANGKUT . '</vessel_name>
                                <call_sign>' . $value1->CALL_SIGN . '</call_sign>
                                <voyage_in>' . $value1->VOY_IN . '</voyage_in>
                                <voyage_out>' . $value1->VOY_IN . '</voyage_out>
                                <cont_no>' . $value1->NO_CONT . '</cont_no>
                                <document_type>' . $value1->JNSDOKIN . '</document_type>
                                <document_no>' . $value1->DOKIN . '</document_no>
                                <document_date>' . $value1->TGDOKIN . '</document_date>
                                <process>
                                    <in_behandle>
                                        <document_type>' . $value1->JNSDOKIN . '</document_type>
                                        <document_no>' . $value1->DOKIN . '</document_no>
                                        <document_date>' . $value1->TGDOKIN . '</document_date>
                                        <actual_time>' . $value1->BEHADNLE_IN . '</actual_time>
                                    </in_behandle>
                                    <stacking_yard_before>
                                        <document_type>' . $value1->JNSDOKIN . '</document_type>
                                        <document_no>' . $value1->DOKIN . '</document_no>
                                        <document_date>' . $value1->TGDOKIN . '</document_date>
                                        <actual_time>' . $value1->STACKING_BEFORE . '</actual_time>
                                    </stacking_yard_before>
                                    <response_ppk>
                                        <document_type>' . $value1->JNSDOKIN . '</document_type>
                                        <document_no>' . $value1->DOKIN . '</document_no>
                                        <document_date>' . $value1->TGDOKIN . '</document_date>
                                        <actual_time>' . $value1->RESPON_PPK . '</actual_time>
                                    </response_ppk>
                                    <planning_inspection>
                                        <document_type>' . $value1->JNSDOKIN . '</document_type>
                                        <document_no>' . $value1->DOKIN . '</document_no>
                                        <document_date>' . $value1->TGDOKIN . '</document_date>
                                        <actual_time>' . $value1->WK_BEHANDLE . '</actual_time>
                                    </planning_inspection>
                                    <stacking_cic>
                                        <document_type>' . $value1->JNSDOKIN . '</document_type>
                                        <document_no>' . $value1->DOKIN . '</document_no>
                                        <document_date>' . $value1->TGDOKIN . '</document_date>
                                        <actual_time>' . $value1->WK_BEHANDLE . '</actual_time>
                                    </stacking_cic>
                                    <start_inspection>
                                        <document_type>' . $value1->JNSDOKIN . '</document_type>
                                        <document_no>' . $value1->DOKIN . '</document_no>
                                        <document_date>' . $value1->TGDOKIN . '</document_date>
                                        <actual_time>' . $value1->START_INSPECTION . '</actual_time>
                                    </start_inspection>
                                    <end_inspection>
                                        <document_type>' . $value1->JNSDOKIN . '</document_type>
                                        <document_no>' . $value1->DOKIN . '</document_no>
                                        <document_date>' . $value1->TGDOKIN . '</document_date>
                                        <actual_time>' . $value1->FINISH_INSPECTION . '</actual_time>
                                    </end_inspection>
                                    <stacking_yard_after>
                                        <document_type>' . $value1->JNSDOKIN . '</document_type>
                                        <document_no>' . $value1->DOKIN . '</document_no>
                                        <document_date>' . $value1->TGDOKIN . '</document_date>
                                        <actual_time>' . $value1->MARSHALLING_EX_B1 . '</actual_time>
                                    </stacking_yard_after>
                                    <gatepass>
                                        <document_type>' . $value1->JNSDOKOUT . '</document_type>
                                        <document_no>' . $value1->NO_DOK . '</document_no>
                                        <document_date>' . $value1->TGDOKOUT . '</document_date>
                                        <actual_time>' . $value1->GATEPASS . '</actual_time>
                                    </gatepass>
                                    <out_behandle>
                                        <document_type>' . $value1->JNSDOKOUT . '</document_type>
                                        <document_no>' . $value1->NO_DOK . '</document_no>
                                        <document_date>' . $value1->TGDOKOUT . '</document_date>
                                        <actual_time>' . $value1->WK_GATEOUT . '</actual_time>
                                    </out_behandle>
                                </process>
                            </containers>
                        </request>';
            echo $cdata;
        }
    }

    public function msgsix()
    {

        $q = $this->db->query("SELECT ts.NO_SPK, tc.NM_ANGKUT, tc.NO_VOY_FLIGHT, tc.CALL_SIGN, ts.JNS_DOK as 'JNSDOKIN', tg.NO_CONT, tr.VOY_IN, ts.NO_DOK as 'DOKIN', DATE_FORMAT(ts.TGL_DOK, '%Y%m%d%H%i%s') as 'TGDOKIN',
            DATE_FORMAT(rb.PRN_BEHANDLE_IN, '%Y%m%d%H%i%s') as 'BEHADNLE_IN',
            DATE_FORMAT(rb.PRN_BEHANDLE_IN, '%Y%m%d%H%i%s') as 'STACKING_BEFORE',
            DATE_FORMAT(ppk.WK_RESPON, '%Y%m%d%H%i%s') as 'RESPON_PPK',
            DATE_FORMAT(tob.W_BEHANDLE, '%Y%m%d%H%i%s') as 'WK_BEHANDLE',
            DATE_FORMAT(rb.PB1_START_PERIKSA, '%Y%m%d%H%i%s') as 'START_INSPECTION',
            DATE_FORMAT(rb.PB2_FINISH_PERIKSA, '%Y%m%d%H%i%s') as 'FINISH_INSPECTION',
            DATE_FORMAT(rb.PB2_MARSHALLING_EX_B2, '%Y%m%d%H%i%s') as 'MARSHALLING_EX_B1',
            DATE_FORMAT(tg.WK_REK, '%Y%m%d%H%i%s') as 'GATEPASS',
            DATE_FORMAT(tod.WK_GATEOUT, '%Y%m%d%H%i%s') as 'WK_GATEOUT',
            DATE_FORMAT(tc.TGL_TIBA, '%Y%m%d') as 'TGL_TIBA', tr.REF_NUMBER,
            tph.KD_DOK_INOUT as 'JNSDOKOUT', tg.NO_DOK, DATE_FORMAT(tg.TGL_DOK, '%Y%m%d') as 'TGDOKOUT'
            from t_spk ts join t_gatepass tg on ts.NO_SPK = tg.NO_SPK
            join (select tr.NO_DOK, trc.NO_CONT, trc.VESSEL, trc.CALL_SIGN, trc.VOY_IN, trc.UKR_CONT, trc.KD_CONT_JENIS, trc.REF_NUMBER, trc.BRUTO, trc.ISO_CODE from t_request tr join t_request_cont trc on tr.ID = trc.ID)    
            tr on tr.NO_DOK = ts.NO_DOK and tr.NO_CONT = tg.NO_CONT
            join t_cocostshdr tc on tr.VESSEL = tc.NM_ANGKUT and tr.VOY_IN = tc.NO_VOY_FLIGHT
            join t_cocostscont tc2 on tc.ID = tc2.ID and tg.NO_CONT = tc2.NO_CONT
            join t_op_delivery tod on tg.NO_SPK = tod.NO_SPK and tg.NO_CONT = tod.NO_CONT
            join t_permit_hdr tph on tg.NO_DOK = tph.NO_DOK_INOUT
            join t_gatepass ppk on ts.NO_DOK = ppk.NO_DOK and ts.TGL_DOK = ppk.TGL_DOK and tg.NO_CONT = ppk.NO_CONT
            join t_op_behandlein tob on tob.NO_SPK = ts.NO_SPK and tob.NO_CONT = tg.NO_CONT
            join report_behandle rb on ts.NO_SPK = rb.RB1_NO_SPK and rb.NO_CONT = tg.NO_CONT 
            where tg.WK_REK > '2022-09-24' and tg.JNS_KEGIATAN = '3'
            and tod.WK_GATEOUT is not null and tod.FL_SEND_BC = 'N' limit 10");
        foreach ($q->result() as $key => $value1) {
            $cdata = '<request>
                            <containers>
                                <reff_number>' . $value1->REF_NUMBER . '</reff_number>
                                <vessel_name>' . $value1->NM_ANGKUT . '</vessel_name>
                                <call_sign>' . $value1->CALL_SIGN . '</call_sign>
                                <voyage_in>' . $value1->VOY_IN . '</voyage_in>
                                <voyage_out>' . $value1->VOY_IN . '</voyage_out>
                                <cont_no>' . $value1->NO_CONT . '</cont_no>
                                <document_type>' . $value1->JNSDOKIN . '</document_type>
                                <document_no>' . $value1->DOKIN . '</document_no>
                                <document_date>' . $value1->TGDOKIN . '</document_date>
                                <process>
                                    <in_behandle>
                                        <document_type>' . $value1->JNSDOKIN . '</document_type>
                                        <document_no>' . $value1->DOKIN . '</document_no>
                                        <document_date>' . $value1->TGDOKIN . '</document_date>
                                        <actual_time>' . $value1->BEHADNLE_IN . '</actual_time>
                                    </in_behandle>
                                    <stacking_yard_before>
                                        <document_type>' . $value1->JNSDOKIN . '</document_type>
                                        <document_no>' . $value1->DOKIN . '</document_no>
                                        <document_date>' . $value1->TGDOKIN . '</document_date>
                                        <actual_time>' . $value1->STACKING_BEFORE . '</actual_time>
                                    </stacking_yard_before>
                                    <response_ppk>
                                        <document_type>' . $value1->JNSDOKIN . '</document_type>
                                        <document_no>' . $value1->DOKIN . '</document_no>
                                        <document_date>' . $value1->TGDOKIN . '</document_date>
                                        <actual_time>' . $value1->RESPON_PPK . '</actual_time>
                                    </response_ppk>
                                    <planning_inspection>
                                        <document_type>' . $value1->JNSDOKIN . '</document_type>
                                        <document_no>' . $value1->DOKIN . '</document_no>
                                        <document_date>' . $value1->TGDOKIN . '</document_date>
                                        <actual_time>' . $value1->WK_BEHANDLE . '</actual_time>
                                    </planning_inspection>
                                    <stacking_cic>
                                        <document_type>' . $value1->JNSDOKIN . '</document_type>
                                        <document_no>' . $value1->DOKIN . '</document_no>
                                        <document_date>' . $value1->TGDOKIN . '</document_date>
                                        <actual_time>' . $value1->WK_BEHANDLE . '</actual_time>
                                    </stacking_cic>
                                    <start_inspection>
                                        <document_type>' . $value1->JNSDOKIN . '</document_type>
                                        <document_no>' . $value1->DOKIN . '</document_no>
                                        <document_date>' . $value1->TGDOKIN . '</document_date>
                                        <actual_time>' . $value1->START_INSPECTION . '</actual_time>
                                    </start_inspection>
                                    <end_inspection>
                                        <document_type>' . $value1->JNSDOKIN . '</document_type>
                                        <document_no>' . $value1->DOKIN . '</document_no>
                                        <document_date>' . $value1->TGDOKIN . '</document_date>
                                        <actual_time>' . $value1->FINISH_INSPECTION . '</actual_time>
                                    </end_inspection>
                                    <stacking_yard_after>
                                        <document_type>' . $value1->JNSDOKIN . '</document_type>
                                        <document_no>' . $value1->DOKIN . '</document_no>
                                        <document_date>' . $value1->TGDOKIN . '</document_date>
                                        <actual_time>' . $value1->MARSHALLING_EX_B1 . '</actual_time>
                                    </stacking_yard_after>
                                    <gatepass>
                                        <document_type>' . $value1->JNSDOKOUT . '</document_type>
                                        <document_no>' . $value1->NO_DOK . '</document_no>
                                        <document_date>' . $value1->TGDOKOUT . '</document_date>
                                        <actual_time>' . $value1->GATEPASS . '</actual_time>
                                    </gatepass>
                                    <out_behandle>
                                        <document_type>' . $value1->JNSDOKOUT . '</document_type>
                                        <document_no>' . $value1->NO_DOK . '</document_no>
                                        <document_date>' . $value1->TGDOKOUT . '</document_date>
                                        <actual_time>' . $value1->WK_GATEOUT . '</actual_time>
                                    </out_behandle>
                                </process>
                            </containers>
                        </request>';
            // echo $cdata;

            $start = date("YmdHis", strtotime("-15 minutes", strtotime("now")));
            $end = date("YmdHis");
            $url    = "https://api.npct1.co.id:9443/api/v1/set-behandle";
            $user   = "BEHANDLE";
            $key    = "5d3a2ffcb778f4b1c224f2447c048c8f";
            $addXML = $cdata;
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
                echo "Connection Success , This is Url : ", $info['url'], "\r\n";
                $this->db->query("UPDATE t_op_delivery set FL_SEND_BC = 'Y' where NO_SPK = '$value1->NO_SPK' and NO_CONT = '$value1->NO_CONT'");
                echo $response;
                $datenow = date("Y-m-d H:i:s");
                $spk = $value1->NO_SPK;
                $cont = $value1->NO_CONT;
                $this->db->query("INSERT INTO log_send_bc (NO_SPK, NO_CONTAINER, RESPONDATA, XML, WK_SEND) VALUES ('$spk', '$cont', '$response', '$addXML', '$datenow')");
            } else {
                echo "Connection Failed =" . curl_error($curl);
            }
            curl_close($curl);
        }
    }

    public function auto_ondemand_spjm()
    {
        $query = $this->db->query("
            SELECT B.FL_MANUAL, A.NO_DOK, DATE_FORMAT(A.TGL_DOK, '%d%m%Y') AS TGL_DOK
            FROM list_dokumens A
            LEFT JOIN t_permit_hdr B
                ON A.NO_DOK = B.NO_DOK_INOUT
                AND A.TGL_DOK = B.TGL_DOK_INOUT
            WHERE A.FL_STATUS = 'N'
                AND A.TYPE_DOK = 'SPJM'
                AND B.FL_MANUAL IS NULL
        ");

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                echo "FL_MANUAL: " . $row->FL_MANUAL . "<br>";
                echo "NO_DOK: " . $row->NO_DOK . "<br>";
                echo "TGL_DOK: " . $row->TGL_DOK . "<br><br>";

                $url = "https://api.npct1.co.id:9443/api/v1/get-customs-ondemand";
                $user = "BEHANDLE";
                $key = "5d3a2ffcb778f4b1c224f2447c048c8f";

                /*
                * REQUEST MASIH XML
                */
                $addXML = '<request>
                    <document_code>19</document_code>
                    <document_no>' . $row->NO_DOK . '</document_no>
                    <document_date>' . $row->TGL_DOK . '</document_date>
                    <npwp></npwp>
                </request>';

                $addXML = trim(preg_replace('/\s+/', ' ', $addXML));

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
                    echo "Connection Failed = " . curl_error($curl);
                    curl_close($curl);
                    continue;
                }
                curl_close($curl);
                /*
                * =========================================================
                * RESPONSE XML -> JSON
                * =========================================================
                */

                $responseJson = json_decode($response, true);

                if (json_last_error() !== JSON_ERROR_NONE) {
                    $responseClean = str_replace('&apos;', '', $response);
                    $responseClean = trim($responseClean);

                    /*
                    * Jika API masih mengembalikan XML, convert XML -> JSON
                    */
                    libxml_use_internal_errors(true);
                    $xml = simplexml_load_string($responseClean, "SimpleXMLElement", LIBXML_NOCDATA);

                    if ($xml === false) {
                        $datenow = date('Y-m-d H:i:s');
                        $responget = 'Invalid response from HUB service';

                        $this->db->query("
                            INSERT INTO `tpk_ipc`.`solver_req_dokumen_log`
                            (`url`, `tipe`, `no_dok`, `tgl_dok`, `npwp`, `data_respons`, `tambahan`, `response_log`)
                            VALUES (
                                '$url',
                                'spjm',
                                '{$row->NO_DOK}',
                                '{$row->TGL_DOK}',
                                '',
                                '$responget',
                                '$addXML',
                                '$response'
                            )
                        ");

                        $this->db->query("
                            INSERT INTO `tpk_ipc`.`log_services`
                            (`METHOD`, `XML_REQUEST`, `XML_RESPONSE`, `WK_REKAM`, `FL_NPCT1`, `FL_SENT_RIZKI`)
                            VALUES (
                                'ONDEMAND SPJM',
                                '$addXML',
                                '$response',
                                '$datenow',
                                'N',
                                'N'
                            )
                        ");
                        continue;
                    }

                    /*
                    * XML diubah menjadi associative array
                    */
                    $responseJson = json_decode(json_encode($xml), true);
                }

                /*
                * =========================================================
                * AMBIL RESPONSE CODE
                * =========================================================
                */
                $code = isset($responseJson['code'])
                    ? (string) $responseJson['code']
                    : null;

                if ($code == '0' || $code == '00') {
                    /*
                    * =====================================================
                    * HEADER SPJM
                    * =====================================================
                    */
                    $header = isset($responseJson['DOCUMENT']['SPJM']['HEADER'])
                        ? $responseJson['DOCUMENT']['SPJM']['HEADER']
                        : array();

                    $car = $this->getCarNumber((object) $header);

                    $kd_kantor = isset($header['KD_KANTOR'])
                        ? trim((string) $header['KD_KANTOR'])
                        : null;

                    $no_pib = isset($header['NO_PIB'])
                        ? trim((string) $header['NO_PIB'])
                        : null;

                    $tgl_pib = isset($header['TGL_PIB'])
                        ? $this->normalizeDateNpct($header['TGL_PIB'])
                        : null;

                    $npwp_imp = isset($header['NPWP_IMP'])
                        ? $this->normalizeNpwp($header['NPWP_IMP'])
                        : null;

                    $nama_imp = isset($header['NAMA_IMP'])
                        ? $this->normalizeCompanyName($header['NAMA_IMP'])
                        : null;

                    $npwp_ppjk = isset($header['NPWP_PPJK'])
                        ? $this->normalizeNpwp($header['NPWP_PPJK'])
                        : null;

                    $nama_ppjk = isset($header['NAMA_PPJK'])
                        ? $this->normalizeCompanyName($header['NAMA_PPJK'])
                        : null;

                    $gudang = isset($header['GUDANG'])
                        ? trim((string) $header['GUDANG'])
                        : null;

                    $jml_cont = isset($header['JML_CONT'])
                        ? trim((string) $header['JML_CONT'])
                        : null;

                    $no_bc11 = isset($header['NO_BC11'])
                        ? trim((string) $header['NO_BC11'])
                        : null;

                    $tgl_bc11 = isset($header['TGL_BC11'])
                        ? $this->normalizeDateNpct($header['TGL_BC11'])
                        : null;

                    $no_pos_bc11 = isset($header['NO_POS_BC11'])
                        ? trim((string) $header['NO_POS_BC11'])
                        : null;

                    $fl_karantina = isset($header['FL_KARANTINA'])
                        ? trim((string) $header['FL_KARANTINA'])
                        : null;

                    $nm_angkut = isset($header['NM_ANGKUT'])
                        ? trim((string) $header['NM_ANGKUT'])
                        : null;

                    $no_voy_flight = isset($header['NO_VOY_FLIGHT'])
                        ? trim((string) $header['NO_VOY_FLIGHT'])
                        : null;

                    /*
                    * =====================================================
                    * DETIL DOK
                    * =====================================================
                    */
                    $detail = isset($responseJson['DOCUMENT']['SPJM']['DETIL'])
                        ? $responseJson['DOCUMENT']['SPJM']['DETIL']
                        : array();

                    $dok = isset($detail['DOK'])
                        ? $detail['DOK']
                        : array();

                    $no_dok_detail = isset($dok['NO_DOK'])
                        ? trim((string) $dok['NO_DOK'])
                        : null;

                    $tgl_dok_detail = isset($dok['TGL_DOK'])
                        ? $this->normalizeDateNpct($dok['TGL_DOK'])
                        : null;

                    $datenow = date('Y-m-d H:i:s');

                    /*
                    * =====================================================
                    * CEK HEADER
                    * =====================================================
                    */
                    $this->db->where('NO_DOK_INOUT', $no_pib);
                    $this->db->where('TGL_DOK_INOUT', $tgl_pib);
                    $queryPermit = $this->db->get('t_permit_hdr');

                    if ($queryPermit->num_rows() > 0) {

                        $permitRow = $queryPermit->row();
                        $insert_id = $permitRow->ID;
                    } else {
                        $tmpData = array(
                            'CAR' => $car,
                            'KD_KANTOR' => $kd_kantor,
                            'KD_DOK_INOUT' => 19,
                            'NO_DOK_INOUT' => $no_pib,
                            'TGL_DOK_INOUT' => $tgl_pib,
                            'NO_DAFTAR_PABEAN' => $no_pib,
                            'TGL_DAFTAR_PABEAN' => $tgl_pib,
                            'ID_CONSIGNEE' => $npwp_imp,
                            'CONSIGNEE' => $nama_imp,
                            'NPWP_PPJK' => $npwp_ppjk,
                            'NAMA_PPJK' => $nama_ppjk,
                            'NM_ANGKUT' => $nm_angkut,
                            'NO_VOY_FLIGHT' => $no_voy_flight,
                            'KD_GUDANG' => $gudang,
                            'JML_CONT' => $jml_cont,
                            'NO_BC11' => $no_bc11,
                            'TGL_BC11' => $tgl_bc11,
                            'NO_POS_BC11' => $no_pos_bc11,
                            'FL_KARANTINA' => $fl_karantina,
                            'TGL_STATUS' => $datenow
                        );

                        $this->db->insert('t_permit_hdr', $tmpData);
                        $insert_id = $this->db->insert_id();
                    }
                    /*
                    * =====================================================
                    * CONTAINER
                    * =====================================================
                    */
                    $containers = isset($detail['CONT'])
                        ? $detail['CONT']
                        : array();

                    /*
                    * Kalau hanya 1 CONT, JSON biasanya menghasilkan associative
                    * array. Kalau banyak CONT, menjadi indexed array.
                    */
                    if (!empty($containers)) {
                        if (isset($containers['NO_CONT'])) {
                            $containers = array($containers);
                        }
                        foreach ($containers as $cont) {
                            $no_cont = isset($cont['NO_CONT'])
                                ? trim((string) $cont['NO_CONT'])
                                : null;

                            if (!$no_cont) {
                                continue;
                            }
                            $size = isset($cont['SIZE'])
                                ? trim((string) $cont['SIZE'])
                                : null;

                            $fl_periksa = isset($cont['FL_PERIKSA'])
                                ? trim((string) $cont['FL_PERIKSA'])
                                : null;

                            $this->db->where('ID', $insert_id);
                            $this->db->where('NO_CONT', $no_cont);
                            $queryCont = $this->db->get('t_permit_cont');

                            if ($queryCont->num_rows() == 0) {

                                $tmpContData = array(
                                    'ID' => $insert_id,
                                    'NO_CONT' => $no_cont,
                                    'KD_CONT_UKURAN' => $size,
                                    'FL_PERIKSA' => $fl_periksa,
                                    'TGL_STATUS' => $datenow
                                );

                                $this->db->insert('t_permit_cont', $tmpContData);
                            }
                        }
                    }

                    /*
                    * =====================================================
                    * LOG SUCCESS
                    * =====================================================
                    */
                    $responget = 'Sukses Ondemand Data';

                    $this->db->query("
                        INSERT INTO `tpk_ipc`.`solver_req_dokumen_log`
                        (`url`, `tipe`, `no_dok`, `tgl_dok`, `npwp`, `data_respons`, `tambahan`, `response_log`)
                        VALUES (
                            '$url',
                            'spjm',
                            '{$row->NO_DOK}',
                            '{$row->TGL_DOK}',
                            '',
                            '$responget',
                            '$addXML',
                            '$response'
                        )
                    ");

                    $this->db->query("
                        INSERT INTO `tpk_ipc`.`log_services`
                        (`METHOD`, `XML_REQUEST`, `XML_RESPONSE`, `WK_REKAM`, `FL_NPCT1`, `FL_SENT_RIZKI`)
                        VALUES (
                            'ONDEMAND SPJM',
                            '$addXML',
                            '$response',
                            '$datenow',
                            'N',
                            'N'
                        )
                    ");
                } elseif ($code == '01') {
                    $datenow = date('Y-m-d H:i:s');
                    $responget = isset($responseJson['description'])
                        ? (string) $responseJson['description']
                        : 'Data tidak ditemukan';

                    $this->db->query("
                        INSERT INTO `tpk_ipc`.`solver_req_dokumen_log`
                        (`url`, `tipe`, `no_dok`, `tgl_dok`, `npwp`, `data_respons`, `tambahan`, `response_log`)
                        VALUES (
                            '$url',
                            'spjm',
                            '{$row->NO_DOK}',
                            '{$row->TGL_DOK}',
                            '',
                            '$responget',
                            '$addXML',
                            '$response'
                        )
                    ");

                    $this->db->query("
                        INSERT INTO `tpk_ipc`.`log_services`
                        (`METHOD`, `XML_REQUEST`, `XML_RESPONSE`, `WK_REKAM`, `FL_NPCT1`, `FL_SENT_RIZKI`)
                        VALUES (
                            'GET DOKUMEN SPJM',
                            '$addXML',
                            '$response',
                            '$datenow',
                            'N',
                            'N'
                        )
                    ");
                } else {
                    $datenow = date('Y-m-d H:i:s');
                    $responget = isset($responseJson['description'])
                        ? (string) $responseJson['description']
                        : 'Unknown error from HUB service';
                    $this->db->query("
                        INSERT INTO `tpk_ipc`.`solver_req_dokumen_log`
                        (`url`, `tipe`, `no_dok`, `tgl_dok`, `npwp`, `data_respons`, `tambahan`, `response_log`)
                        VALUES (
                            '$url',
                            'spjm',
                            '{$row->NO_DOK}',
                            '{$row->TGL_DOK}',
                            '',
                            '$responget',
                            '$addXML',
                            '$response'
                        )
                    ");

                    $this->db->query("
                        INSERT INTO `tpk_ipc`.`log_services`
                        (`METHOD`, `XML_REQUEST`, `XML_RESPONSE`, `WK_REKAM`, `FL_NPCT1`, `FL_SENT_RIZKI`)
                        VALUES (
                            'GET DOKUMEN SPJM',
                            '$addXML',
                            '$response',
                            '$datenow',
                            'N',
                            'N'
                        )
                    ");
                }
            }
        } else {
            echo "No results found.";
        }
    }

    public function auto_get_spjm()
    {
        $query = $this->db->query("
            SELECT 
                A.NO_DOK,
                DATE_FORMAT(A.TGL_DOK, '%d%m%Y') AS TGL_DOK,
                A.NO_CONT,
                A.PERIKSA,
                B.KD_REQ,
                B.JNS_DOK
            FROM t_rekon_dokumen_npct1 A
            LEFT JOIN t_request B 
                ON A.NO_DOK = B.NO_DOK 
                AND A.TGL_DOK = B.TGL_DOK
            LEFT JOIN t_request_cont C 
                ON C.ID = B.ID 
                AND A.NO_CONT = C.NO_CONT
            WHERE B.KD_REQ IS NULL
                AND A.TYPE_DOK = 'SPJ'
            ORDER BY A.ID DESC
        ");

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $url  = "https://api.npct1.co.id:9443/api/v1/get-customs-ondemand";
                $user = "BEHANDLE";
                $key  = "5d3a2ffcb778f4b1c224f2447c048c8f";
                $addXML = '<request>
                    <document_code>19</document_code>
                    <document_no>' . $row->NO_DOK . '</document_no>
                    <document_date>' . $row->TGL_DOK . '</document_date>
                    <npwp></npwp>
                </request>';

                $addXML = trim(preg_replace('/\s+/', ' ', $addXML));

                $curl = curl_init();

                curl_setopt_array($curl, array(
                    CURLOPT_URL            => $url,
                    CURLOPT_SSL_VERIFYPEER => false,
                    CURLOPT_SSL_VERIFYHOST => false,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING       => '',
                    CURLOPT_MAXREDIRS      => 10,
                    CURLOPT_TIMEOUT        => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST  => 'POST',
                    CURLOPT_POSTFIELDS     => $addXML,
                    CURLOPT_HTTPHEADER     => array(
                        'User-ID: ' . $user,
                        'NPCT-API-Key: ' . $key,
                        'Content-Type: application/xml'
                    ),
                ));
                $response = curl_exec($curl);
                if (curl_errno($curl)) {
                    echo "Connection Failed = " . curl_error($curl);
                    curl_close($curl);
                    continue;
                }
                curl_close($curl);
                $datenow = date('Y-m-d H:i:s');

                // ============================================================
                // RESPONSE JSON
                // ============================================================
                $json = json_decode($response);
                if (json_last_error() !== JSON_ERROR_NONE || !$json) {
                    $responget = 'Invalid JSON response: ' . json_last_error_msg();
                    $this->db->query("
                        INSERT INTO `tpk_ipc`.`solver_req_dokumen_log`
                        (`url`, `tipe`, `no_dok`, `tgl_dok`, `npwp`, `data_respons`)
                        VALUES (
                            '$url',
                            'spjm',
                            '{$row->NO_DOK}',
                            '{$row->TGL_DOK}',
                            '',
                            '$responget'
                        )
                    ");

                    $this->db->query("
                        INSERT INTO `tpk_ipc`.`log_services`
                        (`METHOD`, `XML_REQUEST`, `XML_RESPONSE`, `WK_REKAM`, `FL_NPCT1`, `FL_SENT_RIZKI`)
                        VALUES (
                            'ONDEMAND SPJM',
                            '$addXML',
                            '$response',
                            '$datenow',
                            'N',
                            'N'
                        )
                    ");

                    continue;
                }
                // ============================================================
                // CODE RESPONSE
                // SPJM sebelumnya menggunakan code = 0
                // ============================================================
                $code = isset($json->code) ? (string) $json->code : '';
                // ============================================================
                // SUCCESS
                // ============================================================
                if ($code === '0' || $code === '00') {
                    if (!isset($json->DOCUMENT->SPJM->HEADER)) {
                        $responget = 'Response berhasil tetapi data SPJM tidak ditemukan';
                        $this->db->query("
                            INSERT INTO `tpk_ipc`.`solver_req_dokumen_log`
                            (`url`, `tipe`, `no_dok`, `tgl_dok`, `npwp`, `data_respons`)
                            VALUES (
                                '$url',
                                'spjm',
                                '{$row->NO_DOK}',
                                '{$row->TGL_DOK}',
                                '',
                                '$responget'
                            )
                        ");
                        continue;
                    }
                    $header = $json->DOCUMENT->SPJM->HEADER;
                    // ========================================================
                    // HEADER
                    // ========================================================
                    $car = $this->getCarNumber($header);

                    $kd_kantor = isset($header->KD_KANTOR)
                        ? trim((string) $header->KD_KANTOR)
                        : null;

                    $no_pib = isset($header->NO_PIB)
                        ? trim((string) $header->NO_PIB)
                        : null;

                    $tgl_pib = isset($header->TGL_PIB)
                        ? $this->normalizeDateNpct((string) $header->TGL_PIB)
                        : null;

                    $npwp_imp = $this->getNpwpConsignee($header);

                    $nama_imp = $this->getConsigneeName($header);

                    $npwp_ppjk = isset($header->NPWP_PPJK)
                        ? $this->normalizeNpwp((string) $header->NPWP_PPJK)
                        : null;

                    $nama_ppjk = isset($header->NAMA_PPJK)
                        ? $this->normalizeCompanyName((string) $header->NAMA_PPJK)
                        : null;

                    $gudang = isset($header->GUDANG)
                        ? trim((string) $header->GUDANG)
                        : null;

                    $jml_cont = isset($header->JML_CONT)
                        ? trim((string) $header->JML_CONT)
                        : null;

                    $no_bc11 = isset($header->NO_BC11)
                        ? trim((string) $header->NO_BC11)
                        : null;

                    $tgl_bc11 = isset($header->TGL_BC11)
                        ? $this->normalizeDateNpct((string) $header->TGL_BC11)
                        : null;

                    $no_pos_bc11 = isset($header->NO_POS_BC11)
                        ? trim((string) $header->NO_POS_BC11)
                        : null;

                    $fl_karantina = isset($header->FL_KARANTINA)
                        ? trim((string) $header->FL_KARANTINA)
                        : null;

                    $nm_angkut = isset($header->NM_ANGKUT)
                        ? trim((string) $header->NM_ANGKUT)
                        : null;

                    $no_voy_flight = isset($header->NO_VOY_FLIGHT)
                        ? trim((string) $header->NO_VOY_FLIGHT)
                        : null;
                    // ========================================================
                    // DOKUMEN
                    // Semua nomor/tanggal dokumen masuk object yang sama
                    // ========================================================
                    $dok = isset($json->DOCUMENT->SPJM->DETIL->DOK)
                        ? $json->DOCUMENT->SPJM->DETIL->DOK
                        : null;
                    $dokumen = array(
                        'NO_DOK'  => $dok && isset($dok->NO_DOK)
                            ? trim((string) $dok->NO_DOK)
                            : null,
                        'TGL_DOK' => $dok && isset($dok->TGL_DOK)
                            ? $this->normalizeDateNpct((string) $dok->TGL_DOK)
                            : null,
                        'NO_PIB'  => $no_pib,
                        'TGL_PIB' => $tgl_pib,
                        'NO_BC11'  => $no_bc11,
                        'TGL_BC11' => $tgl_bc11
                    );

                    // ========================================================
                    // HEADER OBJECT
                    // ========================================================
                    $permitData = array(
                        'CAR'                  => $car,
                        'KD_KANTOR'            => $kd_kantor,
                        'KD_DOK_INOUT'         => 19,
                        'NO_DOK_INOUT'         => $no_pib,
                        'TGL_DOK_INOUT'        => $tgl_pib,
                        'NO_DAFTAR_PABEAN'     => $no_pib,
                        'TGL_DAFTAR_PABEAN'    => $tgl_pib,
                        'ID_CONSIGNEE'         => $npwp_imp,
                        'CONSIGNEE'            => $nama_imp,
                        'NPWP_PPJK'            => $npwp_ppjk,
                        'NAMA_PPJK'            => $nama_ppjk,
                        'NM_ANGKUT'            => $nm_angkut,
                        'NO_VOY_FLIGHT'        => $no_voy_flight,
                        'KD_GUDANG'            => $gudang,
                        'JML_CONT'             => $jml_cont,
                        'NO_BC11'              => $no_bc11,
                        'TGL_BC11'             => $tgl_bc11,
                        'NO_POS_BC11'          => $no_pos_bc11,
                        'FL_KARANTINA'         => $fl_karantina,
                        'TGL_STATUS'           => $datenow
                    );
                    // ========================================================
                    // CEK HEADER
                    // ========================================================
                    $this->db->where('NO_DOK_INOUT', $no_pib);
                    $this->db->where('TGL_DOK_INOUT', $tgl_pib);
                    $queryPermit = $this->db->get('t_permit_hdr');
                    if ($queryPermit->num_rows() > 0) {
                        $permit = $queryPermit->row();
                        $insert_id = $permit->ID;
                    } else {
                        $this->db->insert('t_permit_hdr', $permitData);
                        $insert_id = $this->db->insert_id();
                    }
                    // ========================================================
                    // CONTAINER
                    // ========================================================
                    $containers = array();
                    if (
                        isset($json->DOCUMENT->SPJM->DETIL->CONT)
                    ) {
                        $containers = $json->DOCUMENT->SPJM->DETIL->CONT;
                        // Kalau hanya satu object, ubah menjadi array
                        if (!is_array($containers)) {
                            $containers = array($containers);
                        }
                    }

                    foreach ($containers as $cont) {
                        $no_cont = isset($cont->NO_CONT)
                            ? trim((string) $cont->NO_CONT)
                            : null;
                        if (!$no_cont) {
                            continue;
                        }
                        $this->db->where('ID', $insert_id);
                        $this->db->where('NO_CONT', $no_cont);
                        $queryCont = $this->db->get('t_permit_cont');
                        if ($queryCont->num_rows() === 0) {
                            $tmpContData = array(
                                'ID'              => $insert_id,
                                'NO_CONT'         => $no_cont,
                                'KD_CONT_UKURAN'  => isset($cont->SIZE)
                                    ? trim((string) $cont->SIZE)
                                    : null,
                                'FL_PERIKSA'      => isset($cont->FL_PERIKSA)
                                    ? trim((string) $cont->FL_PERIKSA)
                                    : null,
                                'TGL_STATUS'      => $datenow
                            );
                            $this->db->insert('t_permit_cont', $tmpContData);
                        }
                    }
                    // ========================================================
                    // LOG SUCCESS
                    // ========================================================
                    $responget = 'Sukses Ondemand Data';
                    $this->db->query("
                        INSERT INTO `tpk_ipc`.`solver_req_dokumen_log`
                        (`url`, `tipe`, `no_dok`, `tgl_dok`, `npwp`, `data_respons`)
                        VALUES (
                            '$url',
                            'spjm',
                            '{$row->NO_DOK}',
                            '{$row->TGL_DOK}',
                            '$npwp_imp',
                            '$responget'
                        )
                    ");

                    $this->db->query("
                        INSERT INTO `tpk_ipc`.`log_services`
                        (`METHOD`, `XML_REQUEST`, `XML_RESPONSE`, `WK_REKAM`, `FL_NPCT1`, `FL_SENT_RIZKI`)
                        VALUES (
                            'ONDEMAND SPJM',
                            '$addXML',
                            '$response',
                            '$datenow',
                            'N',
                            'N'
                        )
                    ");

                // ============================================================
                // FAILED
                // ============================================================
                } elseif ($code === '01') {
                    $responget = isset($json->description)
                        ? (string) $json->description
                        : 'Data tidak ditemukan';

                    $this->db->query("
                        INSERT INTO `tpk_ipc`.`solver_req_dokumen_log`
                        (`url`, `tipe`, `no_dok`, `tgl_dok`, `npwp`, `data_respons`)
                        VALUES (
                            '$url',
                            'spjm',
                            '{$row->NO_DOK}',
                            '{$row->TGL_DOK}',
                            '',
                            '$responget'
                        )
                    ");

                    $this->db->query("
                        INSERT INTO `tpk_ipc`.`log_services`
                        (`METHOD`, `XML_REQUEST`, `XML_RESPONSE`, `WK_REKAM`, `FL_NPCT1`, `FL_SENT_RIZKI`)
                        VALUES (
                            'GET DOKUMEN SPJM',
                            '$addXML',
                            '$response',
                            '$datenow',
                            'N',
                            'N'
                        )
                    ");

                // ============================================================
                // UNKNOWN ERROR
                // ============================================================
                } else {
                    $description = isset($json->description)
                        ? (string) $json->description
                        : 'Unknown error from HUB service';

                    $responget = 'Unknown error ' . $description;
                    $this->db->query("
                        INSERT INTO `tpk_ipc`.`solver_req_dokumen_log`
                        (`url`, `tipe`, `no_dok`, `tgl_dok`, `npwp`, `data_respons`)
                        VALUES (
                            '$url',
                            'spjm',
                            '{$row->NO_DOK}',
                            '{$row->TGL_DOK}',
                            '',
                            '$responget'
                        )
                    ");

                    $this->db->query("
                        INSERT INTO `tpk_ipc`.`log_services`
                        (`METHOD`, `XML_REQUEST`, `XML_RESPONSE`, `WK_REKAM`, `FL_NPCT1`, `FL_SENT_RIZKI`)
                        VALUES (
                            'GET DOKUMEN SPJM',
                            '$addXML',
                            '$response',
                            '$datenow',
                            'N',
                            'N'
                        )
                    ");
                }
            }
        } else {
            echo "No results found.";
        }
    }

    public function getcustdocdev()
    {
        $start = date("YmdHis", strtotime("-720 minutes", strtotime("now")));
        $end = date("YmdHis");
        // echo $start."<br>";
        // echo $end;
        $url    = "https://api.npct1.co.id:9443/api/v1/get-custdoc";
        $user   = "BEHANDLE";
        $key    = "5d3a2ffcb778f4b1c224f2447c048c8f";
        $addXML = '<request>
                        <start>' . $start . '</start>
                        <end>' . $end . '</end>
        </request>';
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
            // echo "Connection Success , This is Url : ", $info['url'], "\r\n";
        } else {
            echo "Connection Failed =" . curl_error($curl);
        }
        curl_close($curl);
        $xml1 = str_replace('<?xml version="1.0"?>', "", $response);
        $xml = simplexml_load_string($xml1);
        header("Content-Type: application/xml; charset=UTF-8");
        // echo $response;
        // die();

        foreach ($xml->DOCUMENTS->DOCUMENT as $docdata) {
            // ========================
            // CASE SPPB
            // ========================
            if (isset($docdata->SPPB)) {
                foreach ($docdata->SPPB->DETIL->CONT as $contdata) {
                    $CAR = $docdata->SPPB->HEADER->CAR;
                    $NO_SPPB = $docdata->SPPB->HEADER->NO_SPPB;
                    $TGL_SPPB = $this->gantiformattglgblk($docdata->SPPB->HEADER->TGL_SPPB);
                    $KD_KPBC = $docdata->SPPB->HEADER->KD_KPBC;
                    $NO_PIB = $docdata->SPPB->HEADER->NO_PIB;
                    $TGL_PIB = $this->gantiformattglgblk($docdata->SPPB->HEADER->TGL_PIB);
                    $NPWP_IMP = $docdata->SPPB->HEADER->NPWP_IMP;
                    $NAMA_IMP = $docdata->SPPB->HEADER->NAMA_IMP;
                    $ALAMAT_IMP = $docdata->SPPB->HEADER->ALAMAT_IMP;
                    $NPWP_PPJK = $docdata->SPPB->HEADER->NPWP_PPJK;
                    $NAMA_PPJK = $docdata->SPPB->HEADER->NAMA_PPJK;
                    $ALAMAT_PPJK = $docdata->SPPB->HEADER->ALAMAT_PPJK;
                    $NM_ANGKUT = $docdata->SPPB->HEADER->NM_ANGKUT;
                    $NO_VOY_FLIGHT = $docdata->SPPB->HEADER->NO_VOY_FLIGHT;
                    $BRUTO = $docdata->SPPB->HEADER->BRUTO;
                    $NETTO = $docdata->SPPB->HEADER->NETTO;
                    $GUDANG = $docdata->SPPB->HEADER->GUDANG;
                    $STATUS_JALUR = $docdata->SPPB->HEADER->STATUS_JALUR;
                    $JML_CONT = $docdata->SPPB->HEADER->JML_CONT;
                    $NO_BC11 = $docdata->SPPB->HEADER->NO_BC11;
                    $TGL_BC11 = $this->gantiformattglgblk($docdata->SPPB->HEADER->TGL_BC11);
                    $NO_POS_BC11 = $docdata->SPPB->HEADER->NO_POS_BC11;
                    $NO_BL_AWB = $docdata->SPPB->HEADER->NO_BL_AWB;
                    $TG_BL_AWB = $this->gantiformattglgblk($docdata->SPPB->HEADER->TG_BL_AWB);
                    $NO_MASTER_BL_AWB = $docdata->SPPB->HEADER->NO_MASTER_BL_AWB;
                    $TG_MASTER_BL_AWB = $this->gantiformattglgblk($docdata->SPPB->HEADER->TG_MASTER_BL_AWB);
                    $NO_CONT = $contdata->NO_CONT;
                    $SIZE = $contdata->SIZE;
                    $JNS_MUAT = $contdata->JNS_MUAT;
                    $datenow = date("Y-m-d H:i:s");

                    echo "Insert kontainer $NO_CONT ke SPPB $NO_SPPB\r\n";
                    //check document udah ada pa belom di permit
                    $query = $this->db->query("SELECT * from t_permit_hdr where NO_DOK_INOUT = '$NO_SPPB' and TGL_DOK_INOUT = '$TGL_SPPB'");
                    $count = $query->num_rows();
                    if ($count === 0) {
                        $this->db->query("INSERT INTO t_permit_hdr (CAR, KD_KANTOR, KD_DOK_INOUT, NO_DOK_INOUT, TGL_DOK_INOUT, NO_DAFTAR_PABEAN, TGL_DAFTAR_PABEAN, ID_CONSIGNEE, CONSIGNEE, ALAMAT_CONSIGNEE, NPWP_PPJK, NAMA_PPJK, ALAMAT_PPJK, NM_ANGKUT, NO_VOY_FLIGHT, KD_GUDANG, JML_CONT, BRUTO, NETTO, NO_BC11, TGL_BC11, NO_POS_BC11, NO_BL_AWB, TGL_BL_AWB, NO_MASTER_BL_AWB, TGL_MASTER_BL_AWB, KD_KANTOR_PENGAWAS, KD_KANTOR_BONGKAR, FL_SEGEL, STATUS_JALUR, FL_KARANTINA, KD_STATUS, TGL_STATUS, FL_BAPLIE, BAPLIE_DATE, ANGKUTKODE_TPS, ANGKUTNAMA_TPS, ANGKUTNO_TPS, TMP_TIMBUN_TPS, STATUS, STATUS_MAIL, KD_STATUS_BIL, WK_STATUS, FL_MANUAL, OPERATOR, FL_MIGRASI, FL_NHI, FL_LNSW, LNSW_KD_RESPON, LNSW_IDLOG, LNSW_NOAJU, LNSW_TGLAJU)
                            VALUES ('$CAR', '$KD_KPBC', '1', '$NO_SPPB', '$TGL_SPPB', '$NO_PIB', '$TGL_PIB', '$NPWP_IMP', '$NAMA_IMP', '$ALAMAT_IMP', '$NPWP_PPJK', '$NAMA_PPJK', '$ALAMAT_PPJK', '$NM_ANGKUT', '$NO_VOY_FLIGHT', '$GUDANG', '$JML_CONT', '$BRUTO', '$NETTO', '$NO_BC11', '$TGL_BC11', '$NO_POS_BC11', '$NO_BL_AWB', '$TG_BL_AWB', '$NO_MASTER_BL_AWB', '$TG_MASTER_BL_AWB', NULL, NULL, NULL, '$STATUS_JALUR', NULL, '100', '$datenow', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL)");
                        $insert_id = $this->db->insert_id();
                        //insert ke permit cont
                        $this->db->query("INSERT into t_permit_cont (ID, NO_CONT, KD_CONT_UKURAN, KD_CONT_JENIS, TGL_STATUS) values ('$insert_id', '$NO_CONT', '$SIZE', '$JNS_MUAT', '$datenow')");
                    } else {
                        $q = $this->db->query("SELECT * from t_permit_hdr where NO_DOK_INOUT = '$NO_SPPB' and TGL_DOK_INOUT = '$TGL_SPPB'");
                        foreach ($q->result() as $key => $value1) {
                            $permitid = $value1->ID;
                            echo 'insert pake id = ' . $permitid;
                            // cek sudah ada data kontainer biar gak duplikat
                            $query = $this->db->query("SELECT * from t_permit_cont where ID = '$permitid' and NO_CONT = '$NO_CONT'");
                            $count = $query->num_rows();
                            if ($count === 0) {
                                $this->db->query("INSERT IGNORE into t_permit_cont (ID, NO_CONT, KD_CONT_UKURAN, KD_CONT_JENIS, TGL_STATUS) values ('$permitid', '$NO_CONT', '$SIZE', '$JNS_MUAT', '$datenow')");
                            } else {
                                echo 'data dah ada.<br>';
                            }
                        }
                    }
                }
            }

            // ========================
            // CASE SPJM
            // ========================
            if (isset($docdata->SPJM)) {
                $CAR = (string) $docdata->SPJM->HEADER->CAR;
                $KD_KANTOR = (string) $docdata->SPJM->HEADER->KD_KANTOR;
                $NO_PIB = (string) $docdata->SPJM->HEADER->NO_PIB;
                $TGL_PIB = date('Y-m-d', strtotime(str_replace('/', '-', (string) $docdata->SPJM->HEADER->TGL_PIB)));
                $NPWP_IMP = (string) $docdata->SPJM->HEADER->NPWP_IMP;
                $NAMA_IMP = (string) $docdata->SPJM->HEADER->NAMA_IMP;
                $NPWP_PPJK = (string) $docdata->SPJM->HEADER->NPWP_PPJK;
                $NAMA_PPJK = (string) $docdata->SPJM->HEADER->NAMA_PPJK;
                $GUDANG = (string) $docdata->SPJM->HEADER->GUDANG;
                $JML_CONT = (string) $docdata->SPJM->HEADER->JML_CONT;
                $NO_BC11 = (string) $docdata->SPJM->HEADER->NO_BC11;
                $TGL_BC11 = date('Y-m-d', strtotime(str_replace('/', '-', (string) $docdata->SPJM->HEADER->TGL_BC11)));
                $NO_POS_BC11 = (string) $docdata->SPJM->HEADER->NO_POS_BC11;
                $FL_KARANTINA = (string) $docdata->SPJM->HEADER->FL_KARANTINA;
                $NM_ANGKUT = (string) $docdata->SPJM->HEADER->NM_ANGKUT;
                $NO_VOY = (string) $docdata->SPJM->HEADER->NO_VOY_FLIGHT;
                $TGL_SPJM = (string) $docdata->SPJM->HEADER->TGL_SPJM;

                $datenow = date("Y-m-d H:i:s");

                echo "Insert SPJM No PIB $NO_PIB\r\n";

                // check document udah ada pa belom di permit
                $query = $this->db->query("SELECT * FROM t_permit_hdr WHERE NO_DOK_INOUT = '$NO_PIB' AND TGL_DOK_INOUT = '$TGL_PIB'");
                $count = $query->num_rows();

                if ($count === 0) {
                    // insert header baru
                    $this->db->query("INSERT INTO t_permit_hdr 
                        (CAR, KD_KANTOR, KD_DOK_INOUT, NO_DOK_INOUT, TGL_DOK_INOUT, 
                        NO_DAFTAR_PABEAN, TGL_DAFTAR_PABEAN, ID_CONSIGNEE, CONSIGNEE, 
                        NPWP_PPJK, NAMA_PPJK, KD_GUDANG, JML_CONT, NO_BC11, TGL_BC11, 
                        NO_POS_BC11, FL_KARANTINA, NM_ANGKUT, NO_VOY_FLIGHT, KD_STATUS, TGL_STATUS) 
                    VALUES 
                        ('$CAR', '$KD_KANTOR', '19', '$NO_PIB', '$TGL_PIB', 
                        '$NO_PIB', '$TGL_PIB', '$NPWP_IMP', '$NAMA_IMP', 
                        '$NPWP_PPJK', '$NAMA_PPJK', '$GUDANG', '$JML_CONT', '$NO_BC11', '$TGL_BC11', 
                        '$NO_POS_BC11', '$FL_KARANTINA', '$NM_ANGKUT', '$NO_VOY', '100', '$datenow')");

                    $insert_id = $this->db->insert_id();
                } else {
                    // sudah ada → ambil ID
                    $row = $query->row();
                    $insert_id = $row->ID;
                    echo "Insert pakai ID = $insert_id\r\n";
                }

                // loop kontainer SPJM
                foreach ($docdata->SPJM->DETIL->CONT as $contdata) {
                    $NO_CONT = (string) $contdata->NO_CONT;
                    $SIZE = (string) $contdata->SIZE;
                    $FL_PERIKSA = (string) $contdata->FL_PERIKSA;

                    // cek apakah kontainer sudah ada
                    $q = $this->db->query("SELECT * FROM t_permit_cont WHERE ID = '$insert_id' AND NO_CONT = '$NO_CONT'");
                    if ($q->num_rows() == 0) {
                        $this->db->query("INSERT INTO t_permit_cont 
                            (ID, NO_CONT, KD_CONT_UKURAN, FL_PERIKSA, TGL_STATUS) 
                            VALUES 
                            ('$insert_id', '$NO_CONT', '$SIZE', '$FL_PERIKSA', '$datenow')");
                        echo "Insert kontainer $NO_CONT ke SPJM $NO_PIB\r\n";
                    } else {
                        echo "Data kontainer $NO_CONT sudah ada.\r\n";
                    }
                }
            }
        }
    }

    public function getCarNumber($header)
    {
        if (isset($header->car) && trim((string) $header->car) !== '') {
            return trim((string) $header->car);
        }

        // fallback jika API suatu saat mengirim ID
        if (isset($header->id) && trim((string) $header->id) !== '') {
            return trim((string) $header->id);
        }

        return null;
    }


    public function normalizeDateNpct($tgl)
    {
        $tgl = trim($tgl);

        if ($tgl === '') {
            return null;
        }

        // Case 1: YYYYMMDD
        // Contoh: 20260119
        if (preg_match('/^\d{8}$/', $tgl)) {
            $date = DateTime::createFromFormat('Ymd', $tgl);

            return $date
                ? $date->format('Y-m-d')
                : null;
        }

        // Case 2: DD/MM/YYYY
        // Contoh: 08/01/2026
        if (preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $tgl)) {
            $date = DateTime::createFromFormat('d/m/Y', $tgl);

            return $date
                ? $date->format('Y-m-d')
                : null;
        }

        // Case 3: DD-MM-YYYY
        // Contoh: 19-08-2026
        if (preg_match('/^\d{2}-\d{2}-\d{4}$/', $tgl)) {
            $date = DateTime::createFromFormat('d-m-Y', $tgl);

            return $date
                ? $date->format('Y-m-d')
                : null;
        }

        // Case 4: YYYY-MM-DD
        // Contoh: 2026-08-19
        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $tgl)) {
            $date = DateTime::createFromFormat('Y-m-d', $tgl);

            return $date
                ? $date->format('Y-m-d')
                : null;
        }

        // Case 5: datetime
        // Contoh:
        // 19-08-2026 06:46:30
        // 2026-08-19 06:46:30
        $time = strtotime($tgl);

        if ($time !== false) {
            return date('Y-m-d', $time);
        }

        return null;
    }


    public function normalizeNpwp($npwp)
    {
        // Ambil angka saja
        $npwp = preg_replace('/\D/', '', $npwp);

        // NPWP lama 15 digit
        if (strlen($npwp) === 15) {
            return $npwp;
        }

        // NPWP 16 digit
        if (strlen($npwp) === 16) {
            return $npwp;
        }

        // NPWP CEISA / padding > 16 digit
        if (strlen($npwp) > 16) {
            return substr($npwp, 0, 15);
        }

        return $npwp;
    }


    public function getNpwpConsignee($header)
    {
        /*
        * Semua jenis dokumen sekarang menggunakan:
        *
        * data.header.customer_id
        */

        if (
            isset($header->customer_id) &&
            trim((string) $header->customer_id) !== ''
        ) {
            return $this->normalizeNpwp(
                (string) $header->customer_id
            );
        }

        return null;
    }


    public function getConsigneeName($header)
    {
        /*
        * Semua jenis dokumen sekarang menggunakan:
        *
        * data.header.customer_name
        */

        if (
            isset($header->customer_name) &&
            trim((string) $header->customer_name) !== ''
        ) {
            return $this->normalizeCompanyName(
                (string) $header->customer_name
            );
        }

        return null;
    }


    public function normalizeCompanyName($name)
    {
        $name = trim($name);

        // Uppercase
        $name = strtoupper($name);

        // Rapikan spasi
        $name = preg_replace('/\s+/', ' ', $name);

        // Hapus karakter aneh
        $name = preg_replace(
            '/[^A-Z0-9\.\&\-\s]/',
            '',
            $name
        );

        return $name;
    }


    public function getNoDokInOut($header)
    {
        /*
        * Semua jenis dokumen:
        *
        * document_no
        */

        if (
            isset($header->document_no) &&
            trim((string) $header->document_no) !== ''
        ) {
            return trim((string) $header->document_no);
        }

        return null;
    }


    public function getTglDokInOut($header)
    {
        /*
        * Semua jenis dokumen:
        *
        * document_date
        */

        if (
            isset($header->document_date) &&
            trim((string) $header->document_date) !== ''
        ) {
            return $this->normalizeDateNpct(
                (string) $header->document_date
            );
        }

        return null;
    }
}
