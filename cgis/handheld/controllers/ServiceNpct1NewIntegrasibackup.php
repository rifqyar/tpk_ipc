<?php defined('BASEPATH') or exit('No direct script access allowed');

class ServiceNpct1NewIntegrasi extends CI_Controller
{
    public $content;
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_home');
    }
    public function parsedate($x) {
        if (strlen($x)<9) {
            if (strlen($x)==0){
                return $x;
            }
            return substr_replace(substr_replace($x,"-",4,0),"-",7,0);
        }
        else
            return substr_replace(substr_replace(substr_replace(substr_replace(substr_replace($x,"-",4,0),"-",7,0)," ",10,0),":",13,0),":",16,0);
    }
    public function tipekont($x) {
        if ($x == 'Y') {
            return 'RFR';
        }
        else
            return 'DRY';
    }
    public function getcoarri(){
        $start = date("YmdHis",strtotime("-15 minutes",strtotime("now")));
        $end = date("YmdHis");
        echo $start."<br>";
        echo $end;
        $url    = "http://10.244.20.14:83/api/v1/get-coarri";
        $user   = "BEHANDLE";
        $key    = "5d3a2ffcb778f4b1c224f2447c048c8f";
           $addXML ='<request>
                        <start>'.$start.'</start>
                        <end>'.$end.'</end>
                    </request>

                ';
            $addXML .='</request>
            ';

            $addXML= trim(preg_replace('/\s\s+/', '', str_replace("\n", " ", $addXML)));
            // print_r($addXML);die();
            $curl = curl_init();
            curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>$addXML,
            CURLOPT_HTTPHEADER => array(
                'User-ID: '.$user,
                'NPCT-API-Key: '.$key,
                'Content-Type: application/xml'
            ),
            ));
            $response = curl_exec($curl);
            if (!curl_errno($curl)) {
                $info = curl_getinfo($curl);
                echo "Connection Success , This is Url : ", $info['url'], "\r\n";
            }else{
                echo "Connection Failed =".curl_error($curl);
            }
            curl_close($curl); 
            $xml1 = str_replace('xmlns="cococont.xsd">',">",$response);
            $xml2 = str_replace('</DOCUMENT">',"</DOCUMENT>",$xml1);

            $xml = simplexml_load_string($xml2);

            foreach ($xml->DOCUMENT->COCOCONT as $hdrdata){
                foreach ($hdrdata->DETIL->CONT as $contdata){
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
                            $query = $this->db->query("SELECT * from dum_cocostshdr where CALL_SIGN = '$CALL_SIGN' and NM_ANGKUT = '$NM_ANGKUT' and NO_VOY_FLIGHT = '$NO_VOY_FLIGHT'");
                            $count = $query->num_rows();
                            if ($count === 0){
                                echo $NO_VOY_FLIGHT." + ".$CALL_SIGN."belum ada \r\n";
                                $this->db->query("INSERT INTO dum_cocostshdr (KD_ASAL_BRG, KD_TPS, KD_GUDANG, CALL_SIGN, NM_ANGKUT, NO_VOY_FLIGHT, TGL_TIBA)  VALUES ('$KD_DOK', '$KD_TPS', '$KD_GUDANG', '$CALL_SIGN', '$NM_ANGKUT', '$NO_VOY_FLIGHT', '$TGL_TIBA')");
                                $insert_id = $this->db->insert_id();

                                echo  "selanjutnya insert ke cocostcont pake id = ".$insert_id."\r\n";
                                $query = $this->db->query("INSERT INTO dum_cocostscont
                                    (ID, NO_CONT, UK_CONT, JNS_CONT, ISO_CODE, TEMPERATURE, KD_CONT_TIPE, BRUTO, NO_SEGEL, NO_BL_AWB, TGL_BL_AWB, NO_MASTER_BL_AWB, TGL_MASTER_BL_AWB, NO_BC11, TGL_BC11, NO_POS_BC11, ID_CONSIGNEE, CONSIGNEE, KD_TIMBUN, PEL_MUAT, PEL_TRANSIT, PEL_BONGKAR, KD_DOK_IN, NO_DOK_IN, TGL_DOK_IN, WK_IN, FL_CONT_KOSONG_IN, KD_SARANA_ANGKUT_IN, NO_POL_IN, GUDANG_TUJUAN_IN, NO_DAFTAR_PABEAN_IN, TGL_DAFTAR_PABEAN_IN, NO_SEGEL_BC_IN, TGL_SEGEL_BC_IN, NO_IJIN_TPS_IN, TGL_IJIN_TPS_IN, KODE_KANTOR_IN, KD_DOK_OUT, NO_DOK_OUT, TGL_DOK_OUT, WK_OUT, FL_CONT_KOSONG_OUT, KD_SARANA_ANGKUT_OUT, NO_POL_OUT, GUDANG_TUJUAN_OUT, NO_DAFTAR_PABEAN_OUT, TGL_DAFTAR_PABEAN_OUT, NO_SEGEL_BC_OUT, TGL_SEGEL_BC_OUT, NO_IJIN_TPS_OUT, TGL_IJIN_TPS_OUT, KODE_KANTOR_OUT, WK_REKAM, FL_BILLING)
                                    VALUES($insert_id, '$NO_CONT', '$UK_CONT', '$JNS_CONT', '$ISO_CODE', NULL, '$KD_CONT_TYPE', '$BRUTO', '$NO_SEGEL', '$NO_BL_AWB', '$TGL_BL_AWB', NULL, NULL, '$NO_BC11', '$TGL_BC11', '$NO_POS_BC11', '$ID_CONSIGNEE', '$CONSIGNEE', '$KD_TIMBUN', '$PEL_MUAT', '$PEL_TRANSIT', '$PEL_BONGKAR', NULL, NULL, NULL, '$WK_INOUT', '$FL_CONT_KOSONG', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '040300', NULL, NULL, NULL, NULL, '$FL_CONT_KOSONG', '$KD_SARANA_ANGKUT_OUT', '$NO_POL', '$GUDANG_TUJUAN', '$NO_DAFTAR_PABEAN', '$TGL_DAFTAR_PABEAN', '$NO_SEGEL_BC', '$TGL_SEGEL_BC', '$NO_IJIN_TPS', '$TGL_IJIN_TPS', '$KODE_KANTOR', '$WK_REKAM', 'N');
                                    ");

                            }
                            else{
                                $q = $this->db->query("SELECT * from dum_cocostshdr where CALL_SIGN = '$CALL_SIGN' and NM_ANGKUT = '$NM_ANGKUT' and NO_VOY_FLIGHT = '$NO_VOY_FLIGHT'");
                                foreach ($q->result() as $key => $value1) {
                                    $cocosthdrid = $value1->ID;
                                    //cek dulu sudah ada di cocostcont
                                    $query = $this->db->query("SELECT * from dum_cocostshdr dc join dum_cocostscont dc2 on dc.ID = dc2.ID where dc.NM_ANGKUT = '$NM_ANGKUT' and dc.NO_VOY_FLIGHT = '$NO_VOY_FLIGHT' and dc.CALL_SIGN  = '$CALL_SIGN' and dc2.NO_CONT = '$NO_CONT'");
                                    $count = $query->num_rows();
                                    if ($count === 0){
                                        //kalau belum ada maka di insert
                                        echo  "insert ke cocostcont pake id = ".$cocosthdrid."\r\n";
                                        $query = $this->db->query("INSERT INTO dum_cocostscont
                                            (ID, NO_CONT, UK_CONT, JNS_CONT, ISO_CODE, TEMPERATURE, KD_CONT_TIPE, BRUTO, NO_SEGEL, NO_BL_AWB, TGL_BL_AWB, NO_MASTER_BL_AWB, TGL_MASTER_BL_AWB, NO_BC11, TGL_BC11, NO_POS_BC11, ID_CONSIGNEE, CONSIGNEE, KD_TIMBUN, PEL_MUAT, PEL_TRANSIT, PEL_BONGKAR, KD_DOK_IN, NO_DOK_IN, TGL_DOK_IN, WK_IN, FL_CONT_KOSONG_IN, KD_SARANA_ANGKUT_IN, NO_POL_IN, GUDANG_TUJUAN_IN, NO_DAFTAR_PABEAN_IN, TGL_DAFTAR_PABEAN_IN, NO_SEGEL_BC_IN, TGL_SEGEL_BC_IN, NO_IJIN_TPS_IN, TGL_IJIN_TPS_IN, KODE_KANTOR_IN, KD_DOK_OUT, NO_DOK_OUT, TGL_DOK_OUT, WK_OUT, FL_CONT_KOSONG_OUT, KD_SARANA_ANGKUT_OUT, NO_POL_OUT, GUDANG_TUJUAN_OUT, NO_DAFTAR_PABEAN_OUT, TGL_DAFTAR_PABEAN_OUT, NO_SEGEL_BC_OUT, TGL_SEGEL_BC_OUT, NO_IJIN_TPS_OUT, TGL_IJIN_TPS_OUT, KODE_KANTOR_OUT, WK_REKAM, FL_BILLING)
                                            VALUES($cocosthdrid, '$NO_CONT', '$UK_CONT', '$JNS_CONT', '$ISO_CODE', NULL, '$KD_CONT_TYPE', '$BRUTO', '$NO_SEGEL', '$NO_BL_AWB', '$TGL_BL_AWB', NULL, NULL, '$NO_BC11', '$TGL_BC11', '$NO_POS_BC11', '$ID_CONSIGNEE', '$CONSIGNEE', '$KD_TIMBUN', '$PEL_MUAT', '$PEL_TRANSIT', '$PEL_BONGKAR', NULL, NULL, NULL, '$WK_INOUT', '$FL_CONT_KOSONG', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '040300', NULL, NULL, NULL, NULL, '$FL_CONT_KOSONG', '$KD_SARANA_ANGKUT_OUT', '$NO_POL', '$GUDANG_TUJUAN', '$NO_DAFTAR_PABEAN', '$TGL_DAFTAR_PABEAN', '$NO_SEGEL_BC', '$TGL_SEGEL_BC', '$NO_IJIN_TPS', '$TGL_IJIN_TPS', '$KODE_KANTOR', '$WK_REKAM', 'N');
                                            ");

                                    } else {
                                        echo "belum ada data baru"."\r\n";
                                    }
                                }

                            }

                        }
                    }
                }
    public function gantiformattglgblk($tgl){
        $date=date_create_from_format("m/d/Y",$tgl);
        $date1 = date_format($date,"Y-m-d");
        return $date1;
    }
    public function getcustdoc()
    {
        $start = date("YmdHis",strtotime("-15 minutes",strtotime("now")));
        $end = date("YmdHis");
        // echo $start."<br>";
        // echo $end;
        $url    = "http://10.244.20.14:83/api/v1/get-custdoc";
        $user   = "BEHANDLE";
        $key    = "5d3a2ffcb778f4b1c224f2447c048c8f";
        $addXML ='<request>
                        <start>'.$start.'</start>
                        <end>'.$end.'</end>
        </request>';
        $addXML .='</request>
        ';

        $addXML= trim(preg_replace('/\s\s+/', '', str_replace("\n", " ", $addXML)));
            // print_r($addXML);die();
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>$addXML,
            CURLOPT_HTTPHEADER => array(
                'User-ID: '.$user,
                'NPCT-API-Key: '.$key,
                'Content-Type: application/xml'
            ),
        ));
        $response = curl_exec($curl);
        if (!curl_errno($curl)) {
            $info = curl_getinfo($curl);
            echo "Connection Success , This is Url : ", $info['url'], "\r\n";
        }else{
            echo "Connection Failed =".curl_error($curl);
        }
        curl_close($curl); 
        $xml1 = str_replace('<?xml version="1.0"?>',"",$response);
        $xml = simplexml_load_string($xml1);
                // echo $response;

        foreach ($xml->DOCUMENTS->DOCUMENT as $docdata)
        {
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
                echo 'insert kontainer'.$NO_CONT.' ke '.$NO_SPPB."\r\n";

                //check document udah ada pa belom di permit
                    $query = $this->db->query("SELECT * from t_permit_hdr where NO_DOK_INOUT = '$NO_SPPB' and TGL_DOK_INOUT = '$TGL_SPPB'");
                    $count = $query->num_rows();
                    if ($count === 0){
                        $this->db->query("INSERT INTO t_permit_hdr (CAR, KD_KANTOR, KD_DOK_INOUT, NO_DOK_INOUT, TGL_DOK_INOUT, NO_DAFTAR_PABEAN, TGL_DAFTAR_PABEAN, ID_CONSIGNEE, CONSIGNEE, ALAMAT_CONSIGNEE, NPWP_PPJK, NAMA_PPJK, ALAMAT_PPJK, NM_ANGKUT, NO_VOY_FLIGHT, KD_GUDANG, JML_CONT, BRUTO, NETTO, NO_BC11, TGL_BC11, NO_POS_BC11, NO_BL_AWB, TGL_BL_AWB, NO_MASTER_BL_AWB, TGL_MASTER_BL_AWB, KD_KANTOR_PENGAWAS, KD_KANTOR_BONGKAR, FL_SEGEL, STATUS_JALUR, FL_KARANTINA, KD_STATUS, TGL_STATUS, FL_BAPLIE, BAPLIE_DATE, ANGKUTKODE_TPS, ANGKUTNAMA_TPS, ANGKUTNO_TPS, TMP_TIMBUN_TPS, STATUS, STATUS_MAIL, KD_STATUS_BIL, WK_STATUS, FL_MANUAL, OPERATOR, FL_MIGRASI, FL_NHI, FL_LNSW, LNSW_KD_RESPON, LNSW_IDLOG, LNSW_NOAJU, LNSW_TGLAJU)
                            VALUES ('$CAR', '$KD_KPBC', '1', '$NO_SPPB', '$TGL_SPPB', '$NO_PIB', '$TGL_PIB', '$NPWP_IMP', '$NAMA_IMP', '$ALAMAT_IMP', '$NPWP_PPJK', '$NAMA_PPJK', '$ALAMAT_PPJK', '$NM_ANGKUT', '$NO_VOY_FLIGHT', '$GUDANG', '$JML_CONT', '$BRUTO', '$NETTO', '$NO_BC11', '$TGL_BC11', '$NO_POS_BC11', '$NO_BL_AWB', '$TG_BL_AWB', '$NO_MASTER_BL_AWB', '$TG_MASTER_BL_AWB', NULL, NULL, NULL, '$STATUS_JALUR', NULL, '100', '$datenow', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL)");
                        $insert_id = $this->db->insert_id();
                    //insert ke permit cont
                        $this->db->query("INSERT into t_permit_cont (ID, NO_CONT, KD_CONT_UKURAN, KD_CONT_JENIS, TGL_STATUS) values ('$insert_id', '$NO_CONT', '$SIZE', '$JNS_MUAT', '0000-00-00 00:00:00')");
                    } else {
                        $q = $this->db->query("SELECT * from t_permit_hdr where NO_DOK_INOUT = '$NO_SPPB' and TGL_DOK_INOUT = '$TGL_SPPB'");
                        foreach ($q->result() as $key => $value1) {
                         $permitid = $value1->ID;
                         echo 'insert pake id = '.$permitid;
                         // cek sudah ada data kontainer biar gak duplikat
                         $query = $this->db->query("SELECT * from t_permit_cont where ID = '$permitid' and NO_CONT = '$NO_CONT'");
                         $count = $query->num_rows();
                         if ($count === 0){
                            $this->db->query("INSERT IGNORE into t_permit_cont (ID, NO_CONT, KD_CONT_UKURAN, KD_CONT_JENIS, TGL_STATUS) values ('$permitid', '$NO_CONT', '$SIZE', '$JNS_MUAT', '0000-00-00 00:00:00')");
                        } else {
                            echo 'data dah ada.<br>';
                        }

                    }

                }                   

            }
        }
    }
}